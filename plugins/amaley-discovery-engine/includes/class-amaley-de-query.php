<?php
/**
 * Query layer for Amaley Discovery Engine.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amaley_DE_Query')) {
    class Amaley_DE_Query {
        /**
         * Run a discovery query.
         *
         * @param array $settings Widget/shortcode settings.
         * @param array $filters Current filters.
         * @return array
         */
        public function run($settings, $filters) {
            $type = isset($settings['type']) ? sanitize_key($settings['type']) : 'products';
            return ('products' === $type) ? $this->query_products($settings, $filters) : $this->query_posts($settings, $filters);
        }

        /**
         * WooCommerce product query.
         *
         * @param array $settings Settings.
         * @param array $filters Filters.
         * @return array
         */
        private function query_products($settings, $filters) {
            if (!post_type_exists('product')) {
                return array(
                    'items'   => array(),
                    'total'   => 0,
                    'pages'   => 0,
                    'current' => 1,
                );
            }

            $page = max(1, absint($filters['page'] ?? 1));
            $per_page = max(1, min(96, absint($settings['per_page'] ?? 9)));
            $sort = sanitize_key($filters['sort'] ?? ($settings['default_sort'] ?? 'latest'));

            $args = array(
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => $per_page,
                'paged'          => $page,
                's'              => sanitize_text_field($filters['search'] ?? ''),
                'tax_query'      => array(),
                'meta_query'     => array(),
            );

            $include_ids = $this->csv_to_absints($settings['include_product_ids'] ?? '');
            $exclude_ids = $this->csv_to_absints($settings['exclude_product_ids'] ?? '');
            if (!empty($include_ids)) {
                $args['post__in'] = $include_ids;
            }
            if (!empty($exclude_ids)) {
                $args['post__not_in'] = $exclude_ids;
            }

            $this->apply_tax_include_exclude($args, 'product_cat', $settings['include_product_categories'] ?? '', $settings['exclude_product_categories'] ?? '');
            $this->apply_tax_include_exclude($args, 'product_tag', $settings['include_product_tags'] ?? '', $settings['exclude_product_tags'] ?? '');
            foreach ($this->attribute_taxonomy_map() as $attr_key_for_scope => $attr_taxonomy_for_scope) {
                $this->apply_tax_include_exclude(
                    $args,
                    $attr_taxonomy_for_scope,
                    $settings['include_attr_' . $attr_key_for_scope] ?? '',
                    $settings['exclude_attr_' . $attr_key_for_scope] ?? ''
                );
            }

            $category = sanitize_title($filters['category'] ?? '');
            if (!$category && 'custom' === sanitize_key($settings['default_filter_mode'] ?? '') && !empty($settings['default_category'])) {
                $default_category = is_array($settings['default_category']) ? reset($settings['default_category']) : $settings['default_category'];
                $category = sanitize_title($default_category);
            }
            if ($category) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category,
                );
            }

            $tag = sanitize_title($filters['tag'] ?? '');
            if (!$tag && 'custom' === sanitize_key($settings['default_filter_mode'] ?? '') && !empty($settings['default_tag'])) {
                $default_tag = is_array($settings['default_tag']) ? reset($settings['default_tag']) : $settings['default_tag'];
                $tag = sanitize_title($default_tag);
            }
            if ($tag) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_tag',
                    'field'    => 'slug',
                    'terms'    => $tag,
                );
            }

            // WooCommerce product attribute filters. These are mapped to
            // product attribute taxonomies such as pa_collection-type.
            if (!empty($filters['attrs']) && is_array($filters['attrs'])) {
                foreach ($this->attribute_taxonomy_map() as $attr_key => $taxonomy) {
                    if (empty($filters['attrs'][$attr_key]) || !taxonomy_exists($taxonomy)) {
                        continue;
                    }
                    $args['tax_query'][] = array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => sanitize_title($filters['attrs'][$attr_key]),
                    );
                }
            }

            $stock = sanitize_key($filters['stock'] ?? '');
            if ($stock) {
                $args['meta_query'][] = array(
                    'key'   => '_stock_status',
                    'value' => $stock,
                );
            }

            $min_price = isset($filters['min_price']) && '' !== $filters['min_price'] ? floatval($filters['min_price']) : null;
            $max_price = isset($filters['max_price']) && '' !== $filters['max_price'] ? floatval($filters['max_price']) : null;
            if (null !== $min_price || null !== $max_price) {
                $price_query = array(
                    'key'     => '_price',
                    'type'    => 'NUMERIC',
                    'compare' => 'BETWEEN',
                    'value'   => array(null !== $min_price ? $min_price : 0, null !== $max_price ? $max_price : 999999999),
                );
                $args['meta_query'][] = $price_query;
            }

            switch ($sort) {
                case 'title':
                    $args['orderby'] = 'title';
                    $args['order'] = 'ASC';
                    break;
                case 'price_low':
                    $args['meta_key'] = '_price';
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = 'ASC';
                    break;
                case 'price_high':
                    $args['meta_key'] = '_price';
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = 'DESC';
                    break;
                case 'popular':
                    $args['meta_key'] = 'total_sales';
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = 'DESC';
                    break;
                case 'featured':
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                    );
                    $args['orderby'] = 'date';
                    $args['order'] = 'DESC';
                    break;
                case 'latest':
                default:
                    $args['orderby'] = 'date';
                    $args['order'] = 'DESC';
                    break;
            }

            if (count($args['tax_query']) > 1) {
                $args['tax_query']['relation'] = 'AND';
            }
            if (count($args['meta_query']) > 1) {
                $args['meta_query']['relation'] = 'AND';
            }

            $query = new WP_Query($args);

            return array(
                'items'   => $query->posts,
                'total'   => (int) $query->found_posts,
                'pages'   => (int) $query->max_num_pages,
                'current' => $page,
            );
        }

        /**
         * Generic CPT query for collections/clusters/SHGs/members.
         *
         * @param array $settings Settings.
         * @param array $filters Filters.
         * @return array
         */
        private function query_posts($settings, $filters) {
            $type = sanitize_key($settings['type'] ?? 'collections');
            $post_type = !empty($settings['post_type']) ? sanitize_key($settings['post_type']) : $this->default_post_type_for_type($type);
            $taxonomy = !empty($settings['taxonomy']) ? sanitize_key($settings['taxonomy']) : $this->default_taxonomy_for_type($type);

            if (!$post_type || !post_type_exists($post_type)) {
                return array('items' => array(), 'total' => 0, 'pages' => 0, 'current' => 1);
            }

            $page = max(1, absint($filters['page'] ?? 1));
            $per_page = max(1, min(96, absint($settings['per_page'] ?? 9)));
            $sort = sanitize_key($filters['sort'] ?? ($settings['default_sort'] ?? 'latest'));

            $args = array(
                'post_type'      => $post_type,
                'post_status'    => 'publish',
                'posts_per_page' => $per_page,
                'paged'          => $page,
                's'              => sanitize_text_field($filters['search'] ?? ''),
                'tax_query'      => array(),
                'meta_query'     => array(),
            );

            $category = sanitize_title($filters['category'] ?? '');
            if ($category && $taxonomy && taxonomy_exists($taxonomy)) {
                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $category,
                );
            }

            if (!empty($settings['relation_meta_key']) && !empty($settings['relation_meta_value'])) {
                $args['meta_query'][] = array(
                    'key'   => sanitize_key($settings['relation_meta_key']),
                    'value' => sanitize_text_field($settings['relation_meta_value']),
                );
            }

            if (count($args['tax_query']) > 1) {
                $args['tax_query']['relation'] = 'AND';
            }
            if (count($args['meta_query']) > 1) {
                $args['meta_query']['relation'] = 'AND';
            }

            if ('title' === $sort) {
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
            } else {
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
            }

            $query = new WP_Query($args);

            return array(
                'items'   => $query->posts,
                'total'   => (int) $query->found_posts,
                'pages'   => (int) $query->max_num_pages,
                'current' => $page,
            );
        }

        private function csv_to_slugs($value) {
            if (is_array($value)) {
                $raw = $value;
            } else {
                $raw = preg_split('/[,\n]+/', (string) $value);
            }
            $slugs = array();
            foreach ((array) $raw as $item) {
                $slug = sanitize_title($item);
                if ('' !== $slug) {
                    $slugs[] = $slug;
                }
            }
            return array_values(array_unique($slugs));
        }

        private function csv_to_absints($value) {
            if (is_array($value)) {
                $raw = $value;
            } else {
                $raw = preg_split('/[,\n]+/', (string) $value);
            }
            $ids = array();
            foreach ((array) $raw as $item) {
                $id = absint($item);
                if ($id > 0) {
                    $ids[] = $id;
                }
            }
            return array_values(array_unique($ids));
        }

        private function apply_tax_include_exclude(&$args, $taxonomy, $include_slugs = '', $exclude_slugs = '') {
            if (!$taxonomy || !taxonomy_exists($taxonomy)) {
                return;
            }
            $include = $this->csv_to_slugs($include_slugs);
            $exclude = $this->csv_to_slugs($exclude_slugs);
            if (!empty($include)) {
                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $include,
                    'operator' => 'IN',
                );
            }
            if (!empty($exclude)) {
                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $exclude,
                    'operator' => 'NOT IN',
                );
            }
        }

        /**
         * Product attribute taxonomy map used by collection/shop discovery.
         *
         * @return array
         */
        private function attribute_taxonomy_map() {
            return array(
                'cluster'                 => 'pa_cluster',
                'collection_type'         => 'pa_collection-type',
                'core_ingredient'         => 'pa_ingredient',
                'producer_maker'          => 'pa_producer-maker',
                'region_cluster'          => 'pa_region-cluster',
                'shg'                     => 'pa_shg',
                'use_case'                => 'pa_use-case',
                'village_source_location' => 'pa_village-source-location',
            );
        }

        private function default_post_type_for_type($type) {
            $map = array(
                'collections' => Amaley_DE_Settings::get_value('collection_post_type', 'amaley_collection'),
                'clusters'    => Amaley_DE_Settings::get_value('cluster_post_type', 'amaley_cluster'),
                'shgs'        => Amaley_DE_Settings::get_value('shg_post_type', 'amaley_shg'),
                'members'     => Amaley_DE_Settings::get_value('member_post_type', 'amaley_member'),
            );
            return isset($map[$type]) ? $map[$type] : 'post';
        }

        private function default_taxonomy_for_type($type) {
            $map = array(
                'collections' => Amaley_DE_Settings::get_value('collection_taxonomy', 'amaley_collection_type'),
                'clusters'    => Amaley_DE_Settings::get_value('cluster_taxonomy', 'amaley_region'),
                'shgs'        => Amaley_DE_Settings::get_value('shg_taxonomy', 'amaley_shg_category'),
                'members'     => Amaley_DE_Settings::get_value('member_taxonomy', 'amaley_member_skill'),
            );
            return isset($map[$type]) ? $map[$type] : '';
        }
    }
}
