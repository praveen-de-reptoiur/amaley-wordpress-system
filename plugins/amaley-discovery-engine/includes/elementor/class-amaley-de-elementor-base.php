<?php
/**
 * Base Elementor widget class.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

abstract class Amaley_DE_Elementor_Base_Widget extends \Elementor\Widget_Base {
    abstract protected function get_discovery_type();
    abstract protected function get_default_heading();
    abstract protected function get_default_kicker();

    /**
     * Default filter position for this widget instance.
     * Standard widgets use left sidebar; topbar widgets override this.
     */
    protected function get_default_filter_position() { return 'left'; }

    /** Device-level default filter position helpers. */
    protected function get_default_desktop_filter_position() { return $this->get_default_filter_position(); }
    protected function get_default_tablet_filter_position() { return 'top'; }
    protected function get_default_mobile_filter_position() { return 'top'; }

    /** Device-level default filter mode helpers. */
    protected function get_default_desktop_filter_mode() { return 'visible'; }
    protected function get_default_tablet_filter_mode() { return 'compact'; }
    protected function get_default_mobile_filter_mode() { return 'compact'; }

    /** Optional wrapper class for preset-like widgets. */
    protected function get_default_custom_wrapper_class() { return ''; }

    public function get_icon() {
        return 'eicon-filter';
    }

    public function get_categories() {
        return array('amaley-discovery-engine');
    }

    public function get_keywords() {
        return array('amaley', 'discovery', 'filter', 'products', 'collections', 'clusters', 'shg', 'members');
    }

    public function get_style_depends() {
        if (function_exists('amaley_de_bootstrap')) {
            amaley_de_bootstrap()->register_assets();
        }
        return array('amaley-de-frontend');
    }

    public function get_script_depends() {
        if (function_exists('amaley_de_bootstrap')) {
            amaley_de_bootstrap()->register_assets();
        }
        return array('amaley-de-frontend');
    }


    /**
     * Build product options for Elementor SELECT2 controls.
     * Kept intentionally limited to protect editor performance.
     *
     * @return array
     */
    protected function get_product_options() {
        if (!post_type_exists('product')) {
            return array();
        }
        $posts = get_posts(array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 300,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'fields'         => 'ids',
        ));
        $options = array();
        foreach ($posts as $post_id) {
            $label = get_the_title($post_id);
            if (!$label) {
                $label = sprintf(__('Product #%d', 'amaley-discovery-engine'), $post_id);
            }
            $options[(string) $post_id] = $label . ' (#' . $post_id . ')';
        }
        return $options;
    }

    /**
     * Build term options by taxonomy for Elementor SELECT/SELECT2 controls.
     * Values remain term slugs internally because frontend filter URLs use slugs,
     * but the editor user selects by readable names.
     *
     * @param string $taxonomy Taxonomy name.
     * @param bool   $with_empty Whether to add a top empty option.
     * @return array
     */
    protected function get_term_options($taxonomy, $with_empty = false) {
        $options = $with_empty ? array('' => __('All / None', 'amaley-discovery-engine')) : array();
        $taxonomy = sanitize_key((string) $taxonomy);
        if (!$taxonomy) {
            return $options;
        }

        $terms = array();

        // Normal WordPress path. Works when taxonomy is registered in the current request.
        if (taxonomy_exists($taxonomy)) {
            $terms = get_terms(array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));
        }

        // Elementor editor can sometimes ask for controls before WooCommerce attribute
        // taxonomies are fully visible to the request. Fall back to a direct term table
        // lookup so controls do not appear blank for product_cat, product_tag or pa_*.
        if ((is_wp_error($terms) || empty($terms)) && (taxonomy_exists('product_cat') || !taxonomy_exists($taxonomy)) && (0 === strpos($taxonomy, 'pa_') || in_array($taxonomy, array('product_cat', 'product_tag'), true))) {
            global $wpdb;
            $rows = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT t.slug, t.name FROM {$wpdb->terms} t INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id WHERE tt.taxonomy = %s ORDER BY t.name ASC LIMIT 500",
                    $taxonomy
                )
            );
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    if (!empty($row->slug) && !empty($row->name)) {
                        $options[sanitize_title($row->slug)] = $row->name;
                    }
                }
                return $options;
            }
        }

        if (is_wp_error($terms) || empty($terms)) {
            // Not selectable, but not visually blank. This tells us the taxonomy/terms
            // are missing instead of showing an empty black hole in Elementor controls.
            if (!$with_empty) {
                $options['__ade_no_terms__'] = sprintf(__('No terms found for %s', 'amaley-discovery-engine'), $taxonomy);
            }
            return $options;
        }

        foreach ($terms as $term) {
            $options[$term->slug] = $term->name;
        }
        return $options;
    }

    /**
     * Common multiple term picker control.
     *
     * @param string $label Label.
     * @param string $taxonomy Taxonomy.
     * @param string $description Description.
     * @return array
     */
    protected function term_multi_control($label, $taxonomy, $description = '') {
        return array(
            'label'       => $label,
            'type'        => \Elementor\Controls_Manager::SELECT2,
            'multiple'    => true,
            'label_block' => true,
            'options'     => $this->get_term_options($taxonomy, false),
            'description' => $description,
        );
    }

    /**
     * Single term picker control.
     *
     * @param string $label Label.
     * @param string $taxonomy Taxonomy.
     * @param string $description Description.
     * @return array
     */
    protected function term_single_control($label, $taxonomy, $description = '') {
        return array(
            'label'       => $label,
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '',
            'options'     => $this->get_term_options($taxonomy, true),
            'label_block' => true,
            'description' => $description,
        );
    }

    /**
     * Product attribute taxonomy map used by editor controls.
     *
     * @return array
     */
    protected function product_attribute_control_map() {
        return array(
            'collection_type'         => array('label' => __('Collection Type', 'amaley-discovery-engine'), 'taxonomy' => 'pa_collection-type'),
            'core_ingredient'         => array('label' => __('Core Ingredient', 'amaley-discovery-engine'), 'taxonomy' => 'pa_ingredient'),
            'cluster'                 => array('label' => __('Cluster', 'amaley-discovery-engine'), 'taxonomy' => 'pa_cluster'),
            'producer_maker'          => array('label' => __('Producer / Maker', 'amaley-discovery-engine'), 'taxonomy' => 'pa_producer-maker'),
            'region_cluster'          => array('label' => __('Source Belt / Region Cluster', 'amaley-discovery-engine'), 'taxonomy' => 'pa_region-cluster'),
            'shg'                     => array('label' => __('SHG / Producer Group', 'amaley-discovery-engine'), 'taxonomy' => 'pa_shg'),
            'use_case'                => array('label' => __('Use Case', 'amaley-discovery-engine'), 'taxonomy' => 'pa_use-case'),
            'village_source_location' => array('label' => __('Village / Source Location', 'amaley-discovery-engine'), 'taxonomy' => 'pa_village-source-location'),
        );
    }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    private function register_content_controls() {
        $type = $this->get_discovery_type();

        $this->start_controls_section('ade_heading_content', array(
            'label' => __('Heading Content', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $this->add_control('kicker', array(
            'label'       => __('Small Label / Kicker', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $this->get_default_kicker(),
            'label_block' => true,
        ));

        $this->add_control('heading', array(
            'label'       => __('Main Heading', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => $this->get_default_heading(),
            'description' => __('Use {word} for rust italic accent. Example: Our {Products}', 'amaley-discovery-engine'),
            'label_block' => true,
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_query_filters', array(
            'label' => __('Query & Filters', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $this->add_control('use_global_preset', $this->switcher(__('Use Imported Preset', 'amaley-discovery-engine'), 'no'));

        $preset_options = class_exists('Amaley_DE_Settings') ? Amaley_DE_Settings::get_preset_options($type) : array('' => __('Do not use imported preset', 'amaley-discovery-engine'));
        $this->add_control('global_preset_key', array(
            'label'       => __('Imported Preset', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '',
            'options'     => $preset_options,
            'description' => __('Presets are managed in Dashboard → Amaley Discovery → Import / Export. When enabled, the imported preset can control layout/filter/style without changing plugin files.', 'amaley-discovery-engine'),
            'condition'   => array('use_global_preset' => 'yes'),
        ));

        $this->add_control('preset_lock_note', array(
            'type'      => \Elementor\Controls_Manager::RAW_HTML,
            'raw'       => __('Guru note: Use imported presets when you want future changes from Admin → Import / Export. Disable this when you want this individual widget to be fully controlled from Elementor.', 'amaley-discovery-engine'),
            'condition' => array('use_global_preset' => 'yes'),
        ));

        $this->add_control('per_page', array(
            'label'   => __('Items Per Page', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 9,
            'min'     => 1,
            'max'     => 96,
        ));

        if ('products' === $type) {
            $this->add_control('default_category', $this->term_single_control(
                __('Default Product Category', 'amaley-discovery-engine'),
                'product_cat',
                __('Optional. Select a default category for first load. Leave empty to show all products.', 'amaley-discovery-engine')
            ));
        } else {
            $this->add_control('post_type', array(
                'label'       => __('Post Type Slug', 'amaley-discovery-engine'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Leave empty to use plugin settings', 'amaley-discovery-engine'),
            ));

            $this->add_control('taxonomy', array(
                'label'       => __('Filter Taxonomy Slug', 'amaley-discovery-engine'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Leave empty to use plugin settings', 'amaley-discovery-engine'),
            ));

            $this->add_control('relation_meta_key', array(
                'label'       => __('Relation Meta Key', 'amaley-discovery-engine'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Example: _amaley_cluster_id', 'amaley-discovery-engine'),
                'description' => __('Optional. Useful for showing SHGs of a cluster or members of an SHG.', 'amaley-discovery-engine'),
            ));

            $this->add_control('relation_meta_value', array(
                'label'       => __('Relation Meta Value', 'amaley-discovery-engine'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Example: 123', 'amaley-discovery-engine'),
            ));
        }

        $this->add_control('default_sort', array(
            'label'   => __('Default Sort', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest'     => __('Latest', 'amaley-discovery-engine'),
                'title'      => __('A to Z', 'amaley-discovery-engine'),
                'price_low'  => __('Price Low to High', 'amaley-discovery-engine'),
                'price_high' => __('Price High to Low', 'amaley-discovery-engine'),
                'popular'    => __('Popular', 'amaley-discovery-engine'),
                'featured'   => __('Featured', 'amaley-discovery-engine'),
            ),
        ));

        $this->add_control('show_search', $this->switcher(__('Show Search', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_categories', $this->switcher(__('Show Category / Taxonomy Filter', 'amaley-discovery-engine'), 'yes'));
        if ('products' === $type) {
            $this->add_control('show_price', $this->switcher(__('Show Price Filter', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_tags', $this->switcher(__('Show Tag Filter', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_stock', $this->switcher(__('Show Stock Filter', 'amaley-discovery-engine'), 'yes'));

            $this->add_control('ade_include_exclude_heading', array(
                'label'     => __('Include / Exclude Controls', 'amaley-discovery-engine'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ));
            $this->add_control('include_product_ids', array(
                'label'       => __('Include Products', 'amaley-discovery-engine'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => $this->get_product_options(),
                'description' => __('Optional. Select products to show only these items.', 'amaley-discovery-engine'),
            ));
            $this->add_control('exclude_product_ids', array(
                'label'       => __('Exclude Products', 'amaley-discovery-engine'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => $this->get_product_options(),
                'description' => __('Optional. Select products to hide from this widget.', 'amaley-discovery-engine'),
            ));
            $this->add_control('include_product_categories', $this->term_multi_control(
                __('Include Categories', 'amaley-discovery-engine'),
                'product_cat',
                __('Limits both results and category dropdown to selected categories.', 'amaley-discovery-engine')
            ));
            $this->add_control('exclude_product_categories', $this->term_multi_control(
                __('Exclude Categories', 'amaley-discovery-engine'),
                'product_cat',
                __('Hides selected categories from results and dropdown.', 'amaley-discovery-engine')
            ));
            $this->add_control('include_product_tags', $this->term_multi_control(
                __('Include Tags', 'amaley-discovery-engine'),
                'product_tag',
                __('Limits both results and tag dropdown to selected tags.', 'amaley-discovery-engine')
            ));
            $this->add_control('exclude_product_tags', $this->term_multi_control(
                __('Exclude Tags', 'amaley-discovery-engine'),
                'product_tag',
                __('Hides selected tags from results and dropdown.', 'amaley-discovery-engine')
            ));

            $this->add_control('ade_default_selected_filters_heading', array(
                'label'     => __('Default Selected Filters', 'amaley-discovery-engine'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ));
            $this->add_control('default_filter_mode', array(
                'label'       => __('Default Dropdown Selection', 'amaley-discovery-engine'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'all',
                'options'     => array(
                    'all'    => __('All / No Default Selection', 'amaley-discovery-engine'),
                    'first'  => __('First Available Term', 'amaley-discovery-engine'),
                    'custom' => __('Use Custom Selection Below', 'amaley-discovery-engine'),
                ),
                'description' => __('Controls what is selected when the page first loads. User selections still override this.', 'amaley-discovery-engine'),
            ));
            $this->add_control('default_tag', $this->term_single_control(
                __('Default Tag', 'amaley-discovery-engine'),
                'product_tag',
                __('Used only when Default Dropdown Selection is set to Use Custom Selection Below.', 'amaley-discovery-engine')
            ));

            $this->add_control('ade_product_attribute_filters_heading', array(
                'label'     => __('WooCommerce Attribute Filters', 'amaley-discovery-engine'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ));

            $this->add_control('show_attr_collection_type', $this->switcher(__('Show Collection Type Attribute', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_core_ingredient', $this->switcher(__('Show Core Ingredient Attribute', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_cluster', $this->switcher(__('Show Cluster Attribute', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_producer_maker', $this->switcher(__('Show Producer / Maker Attribute', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_region_cluster', $this->switcher(__('Show Source Belt / Region Cluster Attribute', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_shg', $this->switcher(__('Show SHG / Producer Group Attribute', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_use_case', $this->switcher(__('Show Use Case Attribute', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_village_source_location', $this->switcher(__('Show Village / Source Location Attribute', 'amaley-discovery-engine'), 'no'));

            $this->add_control('ade_attribute_default_heading', array(
                'label'     => __('Default Selected Attribute Terms', 'amaley-discovery-engine'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ));
            foreach ($this->product_attribute_control_map() as $attr_default_key => $attr_info) {
                $this->add_control('default_attr_' . $attr_default_key, $this->term_single_control(
                    sprintf(__('Default %s', 'amaley-discovery-engine'), $attr_info['label']),
                    $attr_info['taxonomy'],
                    __('Used only when Default Dropdown Selection is set to Use Custom Selection Below.', 'amaley-discovery-engine')
                ));
            }

            $this->add_control('ade_attribute_include_exclude_heading', array(
                'label'     => __('Attribute Include / Exclude', 'amaley-discovery-engine'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ));
            foreach ($this->product_attribute_control_map() as $attr_control_key => $attr_info) {
                $this->add_control('include_attr_' . $attr_control_key, $this->term_multi_control(
                    sprintf(__('Include %s Terms', 'amaley-discovery-engine'), $attr_info['label']),
                    $attr_info['taxonomy'],
                    __('Limits both results and this filter dropdown to selected terms.', 'amaley-discovery-engine')
                ));
                $this->add_control('exclude_attr_' . $attr_control_key, $this->term_multi_control(
                    sprintf(__('Exclude %s Terms', 'amaley-discovery-engine'), $attr_info['label']),
                    $attr_info['taxonomy'],
                    __('Hides selected terms from results and this filter dropdown.', 'amaley-discovery-engine')
                ));
            }
        }
        $this->add_control('show_sort', $this->switcher(__('Show Sort Dropdown', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_active_chips', $this->switcher(__('Show Active Filter Chips', 'amaley-discovery-engine'), 'yes'));

        $this->add_control('pagination_type', array(
            'label'   => __('Pagination Type', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'numbers',
            'options' => array(
                'numbers' => __('Numbers', 'amaley-discovery-engine'),
                'none'    => __('None', 'amaley-discovery-engine'),
            ),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_card_template', array(
            'label' => __('Card Template / Renderer', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $this->add_control('card_renderer', array(
            'label'       => __('Card Renderer', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'default',
            'options'     => array(
                'default'            => __('Plugin Default Card', 'amaley-discovery-engine'),
                'marketplace_card'   => __('Amaley Native Marketplace Card', 'amaley-discovery-engine'),
                'elementor_template' => __('Elementor Loop Item / Template', 'amaley-discovery-engine'),
            ),
            'description' => __('Use Plugin Default for simple cards. Use Amaley Native Marketplace Card for a coded responsive premium product card. Use Elementor Template when you want to render your existing Loop Item design.', 'amaley-discovery-engine'),
        ));



        $this->add_control('marketplace_card_note', array(
            'type'      => \Elementor\Controls_Manager::RAW_HTML,
            'raw'       => __('Native Marketplace Card is coded inside Amaley Discovery Engine: responsive image, badge, rating, price, add-to-cart/view button, availability/sold info and progress bar. It avoids Elementor Loop CSS dependency and is safer for filtered grids.', 'amaley-discovery-engine'),
            'condition' => array('card_renderer' => 'marketplace_card'),
        ));

        $this->add_control('marketplace_badge_text', array(
            'label'       => __('Native Card Badge Text', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Bestseller', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition'   => array('card_renderer' => 'marketplace_card'),
        ));

        $this->add_control('marketplace_meta_text', array(
            'label'       => __('Native Card Small Label', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Amaley Collection', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition'   => array('card_renderer' => 'marketplace_card'),
        ));

        $this->add_control('elementor_template_id', array(
            'label'       => __('Elementor Template ID', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 0,
            'min'         => 0,
            'description' => __('Paste the Loop Item / Elementor Template ID here. Example from your screenshot: 7184. The plugin will keep query, filters, pagination and AJAX; the card design will come from this template.', 'amaley-discovery-engine'),
            'condition'   => array('card_renderer' => 'elementor_template'),
        ));

        $this->add_control('template_fallback_note', array(
            'type'      => \Elementor\Controls_Manager::RAW_HTML,
            'raw'       => __('Safe fallback: if the template ID is empty, missing, or Elementor cannot render it, the plugin will automatically use the default conflict-safe Amaley card.', 'amaley-discovery-engine'),
            'condition' => array('card_renderer' => 'elementor_template'),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_messages_labels', array(
            'label' => __('Messages & Labels', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $this->add_control('mobile_filter_button_text', array(
            'label'   => __('Mobile Filter Button Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Filter', 'amaley-discovery-engine'),
        ));

        $this->add_control('filter_drawer_title', array(
            'label'   => __('Mobile Drawer Title', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Filters', 'amaley-discovery-engine'),
        ));

        $this->add_control('apply_button_text', array(
            'label'   => __('Apply Button Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Apply Filters', 'amaley-discovery-engine'),
        ));

        $this->add_control('reset_button_text', array(
            'label'   => __('Reset Button Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Clear All', 'amaley-discovery-engine'),
        ));

        $this->add_control('ade_filter_panel_heading_controls', array(
            'label'     => __('Filter Panel Heading', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('show_filter_panel_title', $this->switcher(__('Show Filter Heading Above Fields', 'amaley-discovery-engine'), 'no'));

        $this->add_control('filter_panel_kicker', array(
            'label'       => __('Filter Heading Small Label', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Refine Selection', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition'   => array('show_filter_panel_title' => 'yes'),
        ));

        $this->add_control('filter_panel_title', array(
            'label'       => __('Filter Heading Title', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Filters', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition'   => array('show_filter_panel_title' => 'yes'),
        ));

        $this->add_control('ade_filter_label_controls', array(
            'label'     => __('Filter Field Labels', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('all_option_text', array(
            'label'   => __('Default Dropdown Option Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('All', 'amaley-discovery-engine'),
        ));

        $this->add_control('search_label', array(
            'label'   => __('Search Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Search', 'amaley-discovery-engine'),
        ));

        $this->add_control('search_placeholder', array(
            'label'   => __('Search Placeholder', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Search here...', 'amaley-discovery-engine'),
        ));

        $this->add_control('category_label', array(
            'label'   => __('Category Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Category', 'amaley-discovery-engine'),
        ));

        $this->add_control('tag_label', array(
            'label'   => __('Tag Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Tag', 'amaley-discovery-engine'),
        ));

        $this->add_control('collection_type_label', array(
            'label'   => __('Collection Type Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Collection Type', 'amaley-discovery-engine'),
        ));

        $this->add_control('core_ingredient_label', array(
            'label'   => __('Core Ingredient Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Core Ingredient', 'amaley-discovery-engine'),
        ));

        $this->add_control('cluster_label', array(
            'label'   => __('Cluster Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Cluster', 'amaley-discovery-engine'),
        ));

        $this->add_control('producer_maker_label', array(
            'label'   => __('Producer / Maker Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Producer / Maker', 'amaley-discovery-engine'),
        ));

        $this->add_control('region_cluster_label', array(
            'label'   => __('Source Belt / Region Cluster Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Source Belt / Region Cluster', 'amaley-discovery-engine'),
        ));

        $this->add_control('shg_label', array(
            'label'   => __('SHG / Producer Group Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('SHG / Producer Group', 'amaley-discovery-engine'),
        ));

        $this->add_control('use_case_label', array(
            'label'   => __('Use Case Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Use Case', 'amaley-discovery-engine'),
        ));

        $this->add_control('village_source_location_label', array(
            'label'   => __('Village / Source Location Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Village / Source Location', 'amaley-discovery-engine'),
        ));

        $this->add_control('price_label', array(
            'label'   => __('Price Filter Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Price Range', 'amaley-discovery-engine'),
        ));

        $this->add_control('min_price_placeholder', array(
            'label'   => __('Minimum Price Placeholder', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Min', 'amaley-discovery-engine'),
        ));

        $this->add_control('max_price_placeholder', array(
            'label'   => __('Maximum Price Placeholder', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Max', 'amaley-discovery-engine'),
        ));

        $this->add_control('stock_label', array(
            'label'   => __('Stock Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Stock', 'amaley-discovery-engine'),
        ));

        $this->add_control('stock_any_label', array(
            'label'   => __('Any Stock Option Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Any stock status', 'amaley-discovery-engine'),
        ));

        $this->add_control('stock_in_label', array(
            'label'   => __('In Stock Option Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('In stock', 'amaley-discovery-engine'),
        ));

        $this->add_control('stock_out_label', array(
            'label'   => __('Out of Stock Option Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Out of stock', 'amaley-discovery-engine'),
        ));

        $this->add_control('sort_label', array(
            'label'   => __('Sort Label', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('Sort', 'amaley-discovery-engine'),
        ));

        $this->add_control('result_count_singular', array(
            'label'       => __('Result Count Text — Singular', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('{count} result found', 'amaley-discovery-engine'),
            'description' => __('Use {count} where the number should appear.', 'amaley-discovery-engine'),
        ));

        $this->add_control('result_count_plural', array(
            'label'       => __('Result Count Text — Plural', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('{count} results found', 'amaley-discovery-engine'),
            'description' => __('Use {count} where the number should appear.', 'amaley-discovery-engine'),
        ));

        $this->add_control('empty_state_title', array(
            'label'   => __('Empty State Title', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __('No results found.', 'amaley-discovery-engine'),
        ));

        $this->add_control('empty_state_text', array(
            'label'   => __('Empty State Text', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Try clearing one filter or explore all Amaley discoveries.', 'amaley-discovery-engine'),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_layout', array(
            'label' => __('Layout', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $filter_position_options = array(
            'left' => __('Left Sidebar', 'amaley-discovery-engine'),
            'top'  => __('Top Bar', 'amaley-discovery-engine'),
        );

        $filter_mode_options = array(
            'visible' => __('Full Visible Filter Form', 'amaley-discovery-engine'),
            'drawer'  => __('Drawer Toolbar', 'amaley-discovery-engine'),
            'compact' => __('Compact Inline Filter Bar', 'amaley-discovery-engine'),
        );

        /* Legacy fallback: kept hidden for backward compatibility with old widgets/shortcodes. */
        $this->add_control('filter_position', array(
            'type'    => \Elementor\Controls_Manager::HIDDEN,
            'default' => $this->get_default_filter_position(),
        ));

        /* ---------------------------------------------------------
         * Desktop controls are grouped together to avoid confusion.
         * Position + Behaviour stay beside each other in the panel.
         * ------------------------------------------------------ */
        $this->add_control('desktop_filter_layout_heading', array(
            'label'     => __('Desktop Filter Layout', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('desktop_filter_position', array(
            'label'       => __('Filter Position', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => $this->get_default_desktop_filter_position(),
            'options'     => $filter_position_options,
            'description' => __('Desktop only. Left Sidebar is ideal for shop pages; Top Bar is ideal for directory/search pages.', 'amaley-discovery-engine'),
        ));

        $this->add_control('desktop_filter_mode', array(
            'label'       => __('Behaviour', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => $this->get_default_desktop_filter_mode(),
            'options'     => $filter_mode_options,
            'description' => __('Desktop only. Choose full visible filter, drawer toolbar, or compact inline bar.', 'amaley-discovery-engine'),
        ));

        /* ---------------------------------------------------------
         * Tablet controls are grouped together.
         * ------------------------------------------------------ */
        $this->add_control('tablet_filter_layout_heading', array(
            'label'     => __('Tablet Filter Layout', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('tablet_filter_position', array(
            'label'       => __('Filter Position', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => $this->get_default_tablet_filter_position(),
            'options'     => $filter_position_options,
            'description' => __('Tablet only. Top Bar is usually safer; Left Sidebar is available for wider tablet directory layouts.', 'amaley-discovery-engine'),
        ));

        $this->add_control('tablet_filter_mode', array(
            'label'       => __('Behaviour', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => $this->get_default_tablet_filter_mode(),
            'options'     => $filter_mode_options,
            'description' => __('Tablet only. Compact mode shows result count, quick pills and sort without opening the full filter.', 'amaley-discovery-engine'),
        ));

        /* ---------------------------------------------------------
         * Phone controls are grouped together.
         * ------------------------------------------------------ */
        $this->add_control('phone_filter_layout_heading', array(
            'label'     => __('Phone Filter Layout', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('mobile_filter_position', array(
            'label'       => __('Filter Position', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => $this->get_default_mobile_filter_position(),
            'options'     => $filter_position_options,
            'description' => __('Phone only. Top Bar is recommended; Left Sidebar is safely converted into a stacked mobile form to avoid overflow.', 'amaley-discovery-engine'),
        ));

        $this->add_control('mobile_filter_mode', array(
            'label'       => __('Behaviour', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => $this->get_default_mobile_filter_mode(),
            'options'     => $filter_mode_options,
            'description' => __('Phone only. Drawer Toolbar is usually best for shop pages; Compact Inline is best when you do not want a drawer.', 'amaley-discovery-engine'),
        ));

        $this->add_control('responsive_filter_experience_heading', array(
            'label'     => __('Responsive Filter Bar Controls', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('show_mobile_result_count', $this->switcher(__('Show Result Count in Toolbar', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_mobile_quick_pills', $this->switcher(__('Show Quick Category Pills', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_mobile_sort', $this->switcher(__('Show Sort Dropdown in Toolbar', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_mobile_active_chips', $this->switcher(__('Show Active Filter Chips in Toolbar', 'amaley-discovery-engine'), 'yes'));

        $this->add_control('main_result_count_visibility_heading', array(
            'label'     => __('Main Result Count Display', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('show_result_count_desktop', $this->switcher(__('Desktop: Show Count Above Cards', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_result_count_tablet', $this->switcher(__('Tablet: Show Count Above Cards', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_result_count_mobile', $this->switcher(__('Phone: Show Count Above Cards', 'amaley-discovery-engine'), 'yes'));

        $this->add_control('mobile_toolbar_layout', array(
            'label'   => __('Toolbar Layout', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'filter_sort',
            'options' => array(
                'filter_sort' => __('Filter + Sort', 'amaley-discovery-engine'),
                'filter_only' => __('Filter Only', 'amaley-discovery-engine'),
                'sort_only'   => __('Sort Only', 'amaley-discovery-engine'),
            ),
            'description' => __('Used when a device behaviour is Drawer Toolbar. In Compact mode the filter button is hidden automatically and quick pills/sort remain visible.', 'amaley-discovery-engine'),
        ));

        $this->add_control('mobile_quick_pills_limit', array(
            'label'       => __('Quick Pills Limit', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 8,
            'min'         => 0,
            'max'         => 20,
            'description' => __('How many taxonomy/category pills to show in Drawer Toolbar or Compact Inline Filter Bar. 0 disables pills.', 'amaley-discovery-engine'),
        ));

        $this->add_control('full_bleed', $this->switcher(__('Full Width / Break Out of Boxed Container', 'amaley-discovery-engine'), 'yes'));

        $this->add_control('inner_width', array(
            'label'   => __('Inner Max Width', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'options' => array(
                'none' => __('Full Available Width', 'amaley-discovery-engine'),
                '1180' => __('1180px', 'amaley-discovery-engine'),
                '1280' => __('1280px', 'amaley-discovery-engine'),
                '1440' => __('1440px', 'amaley-discovery-engine'),
            ),
        ));

        $this->add_control('sidebar_control_panel_heading', array(
            'label'     => __('Sidebar / Filter Panel Control', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('sidebar_width', array(
            'label'       => __('Sidebar Width', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 290,
            'min'         => 220,
            'max'         => 440,
            'description' => __('Controls the left filter column width on desktop. Recommended: 290–320 for collection pages.', 'amaley-discovery-engine'),
        ));

        $this->add_control('sidebar_min_width', array(
            'label'       => __('Sidebar Minimum Width', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 260,
            'min'         => 200,
            'max'         => 360,
            'description' => __('Safety minimum for sidebar. Increase only if the filter feels too narrow.', 'amaley-discovery-engine'),
        ));

        $this->add_control('sidebar_sticky_top', array(
            'label'       => __('Sidebar Sticky Top Offset', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 96,
            'min'         => 0,
            'max'         => 220,
            'description' => __('Distance from top while sticky. Increase if header overlaps the filter.', 'amaley-discovery-engine'),
        ));

        $this->add_control('topbar_field_min_width', array(
            'label'       => __('Top Bar Field Min Width', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 150,
            'min'         => 110,
            'max'         => 260,
            'description' => __('Controls how compact topbar filter fields become before wrapping.', 'amaley-discovery-engine'),
        ));

        $this->add_control('filter_actions_gap', array(
            'label'       => __('Apply / Clear Button Gap', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 10,
            'min'         => 0,
            'max'         => 40,
            'description' => __('Space between Apply Filters and Clear All buttons.', 'amaley-discovery-engine'),
        ));

        $this->add_control('card_min_width', array(
            'label'       => __('Card Minimum Width', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 240,
            'min'         => 180,
            'max'         => 420,
            'description' => __('Prevents product cards from becoming thin vertical strips.', 'amaley-discovery-engine'),
        ));

        $this->add_control('grid_gap', array(
            'label'       => __('Filter + Card Grid Gap', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 30,
            'min'         => 0,
            'max'         => 80,
            'description' => __('Controls space between filter/results and card grid gap.', 'amaley-discovery-engine'),
        ));

        $this->add_control('custom_wrapper_class', array(
            'label'       => __('Custom Wrapper Class', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __('Example: amaley-shop-page-discovery', 'amaley-discovery-engine'),
            'default'     => $this->get_default_custom_wrapper_class(),
            'description' => __('Advanced. Adds one extra safe class to this widget wrapper for future page-specific styling.', 'amaley-discovery-engine'),
        ));

        $this->add_control('sidebar_cta_heading', array(
            'label'     => __('Sidebar CTA / Collection Builder Box', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ));

        $this->add_control('show_sidebar_cta', $this->switcher(__('Show CTA Box Below Filter', 'amaley-discovery-engine'), 'no'));

        $this->add_control('sidebar_cta_device_heading', array(
            'label'     => __('CTA Device Visibility', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array('show_sidebar_cta' => 'yes'),
        ));

        $this->add_control('show_sidebar_cta_desktop', $this->switcher(__('Show CTA on Desktop', 'amaley-discovery-engine'), 'yes') + array('condition' => array('show_sidebar_cta' => 'yes')));
        $this->add_control('show_sidebar_cta_tablet', $this->switcher(__('Show CTA on Tablet', 'amaley-discovery-engine'), 'no') + array('condition' => array('show_sidebar_cta' => 'yes')));
        $this->add_control('show_sidebar_cta_mobile', $this->switcher(__('Show CTA on Phone', 'amaley-discovery-engine'), 'no') + array('condition' => array('show_sidebar_cta' => 'yes')));

        $this->add_control('sidebar_cta_content_heading', array(
            'label'     => __('CTA Content', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array('show_sidebar_cta' => 'yes'),
        ));

        $this->add_control('sidebar_cta_kicker', array(
            'label'       => __('CTA Small Label', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Collection Builder', 'amaley-discovery-engine'),
            'condition'   => array('show_sidebar_cta' => 'yes'),
        ));

        $this->add_control('sidebar_cta_title', array(
            'label'       => __('CTA Title', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Choose Collection Paths', 'amaley-discovery-engine'),
            'condition'   => array('show_sidebar_cta' => 'yes'),
        ));

        $this->add_control('sidebar_cta_text', array(
            'label'       => __('CTA Description', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => __('Buying for teams, properties, events, guest hampers, or store counters? Start with bulk enquiry and Amaley can recommend the right collection by budget, audience, and purpose.', 'amaley-discovery-engine'),
            'rows'        => 4,
            'condition'   => array('show_sidebar_cta' => 'yes'),
        ));

        $this->add_control('sidebar_cta_button_text', array(
            'label'       => __('CTA Button Text', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Curate Hamper', 'amaley-discovery-engine'),
            'condition'   => array('show_sidebar_cta' => 'yes'),
        ));

        $this->add_control('sidebar_cta_button_url', array(
            'label'       => __('CTA Button URL', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __('https://... or /contact', 'amaley-discovery-engine'),
            'default'     => '',
            'condition'   => array('show_sidebar_cta' => 'yes'),
        ));

        $this->add_control('sidebar_cta_bg_color', $this->color_control(__('CTA Background', 'amaley-discovery-engine'), '#4A1806'));
        $this->add_control('sidebar_cta_text_color', $this->color_control(__('CTA Text Color', 'amaley-discovery-engine'), '#FFF8EA'));
        $this->add_control('sidebar_cta_accent_color', $this->color_control(__('CTA Accent Color', 'amaley-discovery-engine'), '#C2880A'));
        $this->add_control('sidebar_cta_button_bg_color', $this->color_control(__('CTA Button Background', 'amaley-discovery-engine'), '#C2880A'));
        $this->add_control('sidebar_cta_button_text_color', $this->color_control(__('CTA Button Text Color', 'amaley-discovery-engine'), '#2E1203'));

        $this->add_responsive_control('columns_desktop', array(
            'label'       => __('Cards Per Row', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options'     => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'),
        ));

        $this->end_controls_section();
    }

    private function register_style_controls() {
        $this->style_section_wrapper_controls();
        $this->style_heading_controls();
        $this->style_kicker_controls();
        $this->style_filter_controls();
        $this->style_sidebar_cta_controls();
        $this->style_responsive_toolbar_controls();
        $this->style_card_controls();
        $this->style_image_controls();
        $this->style_title_controls();
        $this->style_meta_controls();
        $this->style_price_controls();
        $this->style_button_controls();
        $this->style_pagination_controls();
        $this->style_mobile_drawer_controls();
    }

    /**
     * SECTION / WRAPPER STYLE
     * Controls the full discovery block background and outer spacing only.
     */
    private function style_section_wrapper_controls() {
        $this->start_controls_section('ade_style_section_wrapper', array(
            'label' => __('Section / Wrapper Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('section_bg_color', $this->color_control(__('Section Background', 'amaley-discovery-engine'), '#F7EFE2'));

        $this->add_responsive_control('section_padding_top', $this->slider_control(__('Top Padding', 'amaley-discovery-engine'), 0, 220, 76));
        $this->add_responsive_control('section_padding_bottom', $this->slider_control(__('Bottom Padding', 'amaley-discovery-engine'), 0, 240, 84));

        $this->add_responsive_control('section_side_padding', array(
            'label'      => __('Left / Right Padding', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 80)),
            'default'    => array('unit' => 'px', 'size' => 24),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-discovery-engine-v1' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
            ),
        ));

        $this->add_control('section_control_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => __('Use this section only for full widget background and outer spacing. Heading, filter, cards and buttons have their own sections below.', 'amaley-discovery-engine'),
        ));

        $this->end_controls_section();
    }

    /**
     * HEADING STYLE
     * Only heading typography/color/alignment lives here.
     */
    private function style_heading_controls() {
        $this->start_controls_section('ade_style_heading', array(
            'label' => __('Heading Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('heading_color', $this->color_control(__('Heading Color', 'amaley-discovery-engine'), '#2E1203'));
        $this->add_control('heading_accent_color', $this->color_control(__('Accent Word Color', 'amaley-discovery-engine'), '#B5502A'));
        $this->add_control('heading_font', array('label' => __('Heading Font Family', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Playfair Display'));
        $this->add_responsive_control('heading_size', $this->slider_control(__('Heading Size', 'amaley-discovery-engine'), 24, 120, 76));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'heading_typography',
            'label'    => __('Heading Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__heading',
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'heading_accent_typography',
            'label'    => __('Accent Word Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__heading span',
        ));

        $this->add_responsive_control('heading_alignment', array(
            'label'   => __('Alignment', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-left'),
                'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-center'),
                'right' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-right'),
            ),
            'default'   => 'center',
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__heading-wrap' => 'text-align: {{VALUE}};'),
        ));

        $this->add_responsive_control('heading_bottom_spacing', array(
            'label'      => __('Heading Area Bottom Spacing', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 120)),
            'default'    => array('unit' => 'px', 'size' => 42),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__heading-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};'),
        ));

        $this->end_controls_section();
    }

    /**
     * KICKER STYLE
     * Only small label/kicker typography and spacing lives here.
     */
    private function style_kicker_controls() {
        $this->start_controls_section('ade_style_kicker', array(
            'label' => __('Kicker / Small Label Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('kicker_color', $this->color_control(__('Kicker Color', 'amaley-discovery-engine'), '#C2880A'));
        $this->add_responsive_control('kicker_size', $this->slider_control(__('Kicker Font Size', 'amaley-discovery-engine'), 8, 24, 11));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'kicker_typography',
            'label'    => __('Kicker Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__kicker',
        ));

        $this->add_responsive_control('kicker_bottom_spacing', array(
            'label'      => __('Bottom Spacing', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 60)),
            'default'    => array('unit' => 'px', 'size' => 16),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};'),
        ));

        $this->end_controls_section();
    }

    /**
     * FILTER STYLE
     * Panel, labels, inputs, selects and topbar form spacing live here.
     */
    private function style_filter_controls() {
        $this->start_controls_section('ade_style_filter', array(
            'label' => __('Filter Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('filter_bg_color', $this->color_control(__('Filter Panel Background', 'amaley-discovery-engine'), '#FFF8EA'));
        $this->add_control('primary_color', $this->color_control(__('Primary / Active Color', 'amaley-discovery-engine'), '#2E1203'));
        $this->add_control('gold_color', $this->color_control(__('Gold Accent', 'amaley-discovery-engine'), '#C2880A'));

        $this->add_responsive_control('filter_panel_padding', array(
            'label'      => __('Panel Padding', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));

        $this->add_responsive_control('filter_panel_radius', array(
            'label'      => __('Panel Radius', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 60)),
            'default'    => array('unit' => 'px', 'size' => 24),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters' => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'filter_panel_border',
            'label'    => __('Panel Border', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__filters',
        ));

        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'filter_panel_shadow',
            'label'    => __('Panel Shadow', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__filters',
        ));

        $this->add_responsive_control('filter_field_gap', array(
            'label'      => __('Field Gap', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 50)),
            'default'    => array('unit' => 'px', 'size' => 14),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters' => 'gap: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_control('filter_label_heading', array('label' => __('Filter Label Typography', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'filter_label_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__field-label',
        ));
        $this->add_control('filter_label_color', array(
            'label'     => __('Label Color', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__field-label' => 'color: {{VALUE}};'),
        ));

        $this->add_control('filter_input_heading', array('label' => __('Input / Select Style', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'filter_input_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__field input, {{WRAPPER}} .amaley-discovery-engine-v1__field select',
        ));
        $this->add_control('filter_input_text_color', array(
            'label'     => __('Input Text Color', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__field input, {{WRAPPER}} .amaley-discovery-engine-v1__field select' => 'color: {{VALUE}};'),
        ));
        $this->add_control('filter_input_bg_color', array(
            'label'     => __('Input Background', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__field input, {{WRAPPER}} .amaley-discovery-engine-v1__field select' => 'background-color: {{VALUE}};'),
        ));
        $this->add_control('filter_input_border_color', array(
            'label'     => __('Input Border Color', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__field input, {{WRAPPER}} .amaley-discovery-engine-v1__field select' => 'border-color: {{VALUE}};'),
        ));
        $this->add_responsive_control('filter_input_height', array(
            'label'      => __('Input Height', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 30, 'max' => 80)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__field input, {{WRAPPER}} .amaley-discovery-engine-v1__field select' => 'min-height: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('filter_input_radius', array(
            'label'      => __('Input Radius', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 50)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__field input, {{WRAPPER}} .amaley-discovery-engine-v1__field select' => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_responsive_control('filter_input_padding', array(
            'label'      => __('Input Inner Padding', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__field input, {{WRAPPER}} .amaley-discovery-engine-v1__field select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));

        $this->add_control('filter_button_spacing_heading', array('label' => __('Filter Button Spacing', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_responsive_control('filter_actions_style_gap', array(
            'label'      => __('Apply / Clear Gap', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 40)),
            'default'    => array('unit' => 'px', 'size' => 10),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__filter-actions' => 'gap: {{SIZE}}{{UNIT}};'),
        ));

        $this->end_controls_section();
    }


    /**
     * SIDEBAR CTA / COLLECTION BUILDER BOX STYLE
     * Controls only the optional CTA box below the filter panel.
     */
    private function style_sidebar_cta_controls() {
        $this->start_controls_section('ade_style_sidebar_cta', array(
            'label' => __('Sidebar CTA Box Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('sidebar_cta_style_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => __('These controls style the optional Collection Builder / CTA box shown below the filter. Enable the box from Content → Layout → Sidebar CTA / Collection Builder Box.', 'amaley-discovery-engine'),
        ));

        $this->add_control('sidebar_cta_box_heading', array('label' => __('Box', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_responsive_control('sidebar_cta_margin', array(
            'label'      => __('Box Margin', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('sidebar_cta_padding', array(
            'label'      => __('Box Padding', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('sidebar_cta_radius', array(
            'label'      => __('Box Radius', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 80)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta' => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'sidebar_cta_border',
            'label'    => __('Box Border', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta',
        ));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'sidebar_cta_shadow',
            'label'    => __('Box Shadow', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta',
        ));

        $this->add_control('sidebar_cta_kicker_style_heading', array('label' => __('Small Label / Kicker', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'sidebar_cta_kicker_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-kicker',
        ));
        $this->add_responsive_control('sidebar_cta_kicker_spacing', array(
            'label'      => __('Kicker Bottom Spacing', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 50)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_control('sidebar_cta_title_style_heading', array('label' => __('Title', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'sidebar_cta_title_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-title',
        ));
        $this->add_responsive_control('sidebar_cta_title_spacing', array(
            'label'      => __('Title Bottom Spacing', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 60)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_control('sidebar_cta_text_style_heading', array('label' => __('Description', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'sidebar_cta_text_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-text',
        ));
        $this->add_responsive_control('sidebar_cta_text_spacing', array(
            'label'      => __('Description Bottom Spacing', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 70)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-text' => 'margin-bottom: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_control('sidebar_cta_button_style_heading', array('label' => __('Button', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'sidebar_cta_button_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-button',
        ));
        $this->add_responsive_control('sidebar_cta_button_padding', array(
            'label'      => __('Button Padding', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('sidebar_cta_button_radius', array(
            'label'      => __('Button Radius', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 60)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-button' => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'sidebar_cta_button_border',
            'label'    => __('Button Border', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__sidebar-cta-button',
        ));
        $this->end_controls_section();
    }

    /**
     * RESPONSIVE TOOLBAR STYLE
     * Controls mobile/tablet compact bars, quick pills, sort and result count.
     */
    private function style_responsive_toolbar_controls() {
        $this->start_controls_section('ade_style_responsive_toolbar', array(
            'label' => __('Responsive Toolbar Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('toolbar_bg_color', array(
            'label'     => __('Toolbar Background', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__mobile-bar' => 'background-color: {{VALUE}};'),
        ));
        $this->add_responsive_control('toolbar_padding', array(
            'label'      => __('Toolbar Padding', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__mobile-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('toolbar_radius', array(
            'label'      => __('Toolbar Radius', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 50)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__mobile-bar' => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_control('toolbar_result_heading', array('label' => __('Result Count', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'toolbar_result_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__mobile-count, {{WRAPPER}} .amaley-discovery-engine-v1__result-count',
        ));
        $this->add_control('toolbar_result_color', array(
            'label'     => __('Result Count Color', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__mobile-count, {{WRAPPER}} .amaley-discovery-engine-v1__result-count' => 'color: {{VALUE}};'),
        ));

        $this->add_control('toolbar_pills_heading', array('label' => __('Quick Pills', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'quick_pill_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__quick-pill',
        ));
        $this->add_control('quick_pill_text_color', array('label' => __('Pill Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__quick-pill' => 'color: {{VALUE}};')));
        $this->add_control('quick_pill_bg_color', array('label' => __('Pill Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__quick-pill' => 'background-color: {{VALUE}};')));
        $this->add_control('quick_pill_active_text_color', array('label' => __('Active Pill Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__quick-pill.is-active' => 'color: {{VALUE}};')));
        $this->add_control('quick_pill_active_bg_color', array('label' => __('Active Pill Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__quick-pill.is-active' => 'background-color: {{VALUE}};')));
        $this->add_responsive_control('quick_pill_radius', array('label' => __('Pill Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 50)), 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__quick-pill' => 'border-radius: {{SIZE}}{{UNIT}};')));

        $this->end_controls_section();
    }

    /**
     * CARD STYLE
     * Controls plugin default cards and the wrapper around Elementor Loop Item cards.
     */
    private function style_card_controls() {
        $this->start_controls_section('ade_style_card', array(
            'label' => __('Card Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('card_bg_color', $this->color_control(__('Card Background', 'amaley-discovery-engine'), '#FFF8EA'));
        $this->add_responsive_control('card_radius', $this->slider_control(__('Card Radius', 'amaley-discovery-engine'), 0, 60, 22));

        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'card_border',
            'label'    => __('Card Border', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__card, {{WRAPPER}} .amaley-discovery-engine-v1__template-card',
        ));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'card_shadow',
            'label'    => __('Card Shadow', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__card, {{WRAPPER}} .amaley-discovery-engine-v1__template-card',
        ));
        $this->add_responsive_control('card_padding', array(
            'label'      => __('Template Card Wrapper Padding', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__template-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_control('template_card_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => __('If Card Renderer is Elementor Template, inner card styling should still be edited inside that Elementor Loop Item. These controls style the plugin wrapper and built-in fallback cards only.', 'amaley-discovery-engine'),
        ));

        $this->end_controls_section();
    }

    private function style_image_controls() {
        $this->start_controls_section('ade_style_image', array('label' => __('Image Style', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('image_height', $this->slider_control(__('Image Height', 'amaley-discovery-engine'), 120, 560, 250));
        $this->add_control('image_object_fit', array(
            'label'     => __('Image Object Fit', 'amaley-discovery-engine'),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'cover',
            'options'   => array('cover' => __('Cover', 'amaley-discovery-engine'), 'contain' => __('Contain', 'amaley-discovery-engine'), 'fill' => __('Fill', 'amaley-discovery-engine')),
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__image' => 'object-fit: {{VALUE}};'),
        ));
        $this->add_responsive_control('image_radius', array(
            'label'      => __('Image Radius', 'amaley-discovery-engine'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range'      => array('px' => array('min' => 0, 'max' => 50)),
            'selectors'  => array('{{WRAPPER}} .amaley-discovery-engine-v1__image, {{WRAPPER}} .amaley-discovery-engine-v1__image-link' => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));
        $this->end_controls_section();
    }

    private function style_title_controls() {
        $this->start_controls_section('ade_style_title', array('label' => __('Card Title Style', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('text_color', $this->color_control(__('Title / Main Text Color', 'amaley-discovery-engine'), '#2E1203'));
        $this->add_control('body_font', array('label' => __('Body Font Family', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Lato'));
        $this->add_responsive_control('card_title_size', $this->slider_control(__('Card Title Size', 'amaley-discovery-engine'), 14, 48, 25));
        $this->add_responsive_control('body_text_size', $this->slider_control(__('Body Text Size', 'amaley-discovery-engine'), 10, 24, 13));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'card_title_typography',
            'label'    => __('Card Title Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__card-title, {{WRAPPER}} .amaley-discovery-engine-v1__card-title a',
        ));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'card_excerpt_typography',
            'label'    => __('Card Body Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__excerpt',
        ));
        $this->add_responsive_control('card_title_bottom_spacing', array('label' => __('Title Bottom Spacing', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 50)), 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};')));
        $this->end_controls_section();
    }

    private function style_meta_controls() {
        $this->start_controls_section('ade_style_meta', array('label' => __('Meta / Badge Style', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('muted_color', $this->color_control(__('Muted Text Color', 'amaley-discovery-engine'), '#7A573F'));
        $this->add_control('rust_color', $this->color_control(__('Rust Accent', 'amaley-discovery-engine'), '#B5502A'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'meta_typography', 'label' => __('Meta Typography', 'amaley-discovery-engine'), 'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__meta'));
        $this->add_control('meta_color', array('label' => __('Meta Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__meta' => 'color: {{VALUE}};')));
        $this->add_control('badge_text_color', array('label' => __('Badge Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__badge' => 'color: {{VALUE}};')));
        $this->add_control('badge_bg_color', array('label' => __('Badge Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__badge' => 'background-color: {{VALUE}};')));
        $this->add_responsive_control('badge_radius', array('label' => __('Badge Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 50)), 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__badge' => 'border-radius: {{SIZE}}{{UNIT}};')));
        $this->end_controls_section();
    }

    private function style_price_controls() {
        $this->start_controls_section('ade_style_price', array('label' => __('Price Style', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('price_color', $this->color_control(__('Price Color', 'amaley-discovery-engine'), '#2E1203'));
        $this->add_responsive_control('price_font_size', $this->slider_control(__('Price Font Size', 'amaley-discovery-engine'), 10, 32, 15));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'price_typography', 'label' => __('Price Typography', 'amaley-discovery-engine'), 'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__price'));
        $this->add_control('sale_price_color', array('label' => __('Sale Price Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__price ins' => 'color: {{VALUE}};')));
        $this->add_control('regular_price_color', array('label' => __('Regular Price Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__price del' => 'color: {{VALUE}};')));
        $this->end_controls_section();
    }

    private function style_button_controls() {
        $this->start_controls_section('ade_style_button', array('label' => __('Button Style', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'button_typography', 'label' => __('Button Typography', 'amaley-discovery-engine'), 'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__apply, {{WRAPPER}} .amaley-discovery-engine-v1__reset, {{WRAPPER}} .amaley-discovery-engine-v1__button, {{WRAPPER}} .amaley-discovery-engine-v1__mobile-filter-button'));
        $this->add_responsive_control('button_padding', array('label' => __('Button Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px'), 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__apply, {{WRAPPER}} .amaley-discovery-engine-v1__reset, {{WRAPPER}} .amaley-discovery-engine-v1__button, {{WRAPPER}} .amaley-discovery-engine-v1__mobile-filter-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_radius', array('label' => __('Button Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 50)), 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__apply, {{WRAPPER}} .amaley-discovery-engine-v1__reset, {{WRAPPER}} .amaley-discovery-engine-v1__button, {{WRAPPER}} .amaley-discovery-engine-v1__mobile-filter-button' => 'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_control('button_bg_color', $this->color_control(__('Primary Button Background', 'amaley-discovery-engine'), '#2E1203'));
        $this->add_control('button_text_color', $this->color_control(__('Primary Button Text', 'amaley-discovery-engine'), '#FFF8EA'));
        $this->add_control('button_hover_bg_color', $this->color_control(__('Primary Button Hover Background', 'amaley-discovery-engine'), '#C2880A'));
        $this->add_control('button_hover_text_color', $this->color_control(__('Primary Button Hover Text', 'amaley-discovery-engine'), '#2E1203'));
        $this->add_control('reset_button_heading', array('label' => __('Secondary / Reset Button', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
        $this->add_control('reset_button_text_color', array('label' => __('Reset Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__reset' => 'color: {{VALUE}};')));
        $this->add_control('reset_button_bg_color', array('label' => __('Reset Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__reset' => 'background-color: {{VALUE}};')));
        $this->add_control('reset_button_border_color', array('label' => __('Reset Border Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__reset' => 'border-color: {{VALUE}};')));
        $this->end_controls_section();
    }

    private function style_pagination_controls() {
        $this->start_controls_section('ade_style_pagination', array('label' => __('Pagination Style', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'pagination_typography', 'label' => __('Pagination Typography', 'amaley-discovery-engine'), 'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__page-link'));
        $this->add_responsive_control('pagination_size', array('label' => __('Pagination Button Size', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 24, 'max' => 70)), 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__page-link' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('pagination_gap', array('label' => __('Pagination Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 40)), 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__pagination' => 'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('pagination_bg_color', $this->color_control(__('Pagination Background', 'amaley-discovery-engine'), '#FFFFFF'));
        $this->add_control('pagination_active_bg', $this->color_control(__('Active Page Background', 'amaley-discovery-engine'), '#2E1203'));
        $this->add_control('pagination_active_text', $this->color_control(__('Active Page Text', 'amaley-discovery-engine'), '#FFF8EA'));
        $this->end_controls_section();
    }

    private function style_mobile_drawer_controls() {
        $this->start_controls_section('ade_style_mobile_drawer', array('label' => __('Mobile Drawer Style', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('drawer_bg_color', $this->color_control(__('Drawer Background', 'amaley-discovery-engine'), '#FFF8EA'));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name' => 'drawer_shadow', 'label' => __('Drawer Shadow', 'amaley-discovery-engine'), 'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__filters'));
        $this->add_control('drawer_close_color', array('label' => __('Close Icon Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__drawer-close' => 'color: {{VALUE}};')));
        $this->add_control('drawer_note', array('type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => __('Drawer styles apply only when a device behaviour is set to Drawer Toolbar. Compact and Full Visible modes use Filter Style and Responsive Toolbar Style.', 'amaley-discovery-engine')));
        $this->end_controls_section();
    }

    private function switcher($label, $default = 'yes') {
        return array('label' => $label, 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => __('Yes', 'amaley-discovery-engine'), 'label_off' => __('No', 'amaley-discovery-engine'), 'return_value' => 'yes', 'default' => $default);
    }

    private function color_control($label, $default) {
        return array('label' => $label, 'type' => \Elementor\Controls_Manager::COLOR, 'default' => $default);
    }

    private function slider_control($label, $min, $max, $default) {
        return array('label' => $label, 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => $min, 'max' => $max)), 'default' => array('unit' => 'px', 'size' => $default));
    }

    protected function render() {
        if (!function_exists('amaley_de_bootstrap')) {
            return;
        }
        $settings = $this->get_settings_for_display();
        $settings['type'] = $this->get_discovery_type();

        // Responsive column compatibility: Elementor stores responsive values in separate keys.
        if (!empty($settings['columns_desktop_tablet'])) {
            $settings['columns_tablet'] = $settings['columns_desktop_tablet'];
        }
        if (!empty($settings['columns_desktop_mobile'])) {
            $settings['columns_mobile'] = $settings['columns_desktop_mobile'];
        }
        if (is_array($settings['section_padding_top'] ?? null)) {
            $settings['section_padding_top'] = $settings['section_padding_top']['size'];
        }
        if (is_array($settings['section_padding_bottom'] ?? null)) {
            $settings['section_padding_bottom'] = $settings['section_padding_bottom']['size'];
        }
        if (is_array($settings['card_radius'] ?? null)) {
            $settings['card_radius'] = $settings['card_radius']['size'];
        }
        if (is_array($settings['image_height'] ?? null)) {
            $settings['image_height'] = $settings['image_height']['size'];
        }

        // Elementor stores responsive controls in *_tablet and *_mobile keys.
        foreach (array('section_padding_top', 'section_padding_bottom', 'card_radius', 'image_height', 'heading_size', 'kicker_size', 'card_title_size', 'body_text_size', 'price_font_size') as $responsive_key) {
            if (isset($settings[$responsive_key]) && is_array($settings[$responsive_key])) {
                $settings[$responsive_key] = $settings[$responsive_key]['size'];
            }
            foreach (array('tablet', 'mobile') as $device) {
                $device_key = $responsive_key . '_' . $device;
                if (isset($settings[$device_key]) && is_array($settings[$device_key])) {
                    $settings[$device_key] = $settings[$device_key]['size'];
                }
            }
        }

        if (!empty($settings['heading_size_tablet'])) {
            $settings['heading_size_tablet'] = is_array($settings['heading_size_tablet']) ? $settings['heading_size_tablet']['size'] : $settings['heading_size_tablet'];
        }
        if (!empty($settings['heading_size_mobile'])) {
            $settings['heading_size_mobile'] = is_array($settings['heading_size_mobile']) ? $settings['heading_size_mobile']['size'] : $settings['heading_size_mobile'];
        }
        if (!empty($settings['card_title_size_mobile'])) {
            $settings['card_title_size_mobile'] = is_array($settings['card_title_size_mobile']) ? $settings['card_title_size_mobile']['size'] : $settings['card_title_size_mobile'];
        }
        if (!empty($settings['image_height_tablet'])) {
            $settings['image_height_tablet'] = is_array($settings['image_height_tablet']) ? $settings['image_height_tablet']['size'] : $settings['image_height_tablet'];
        }
        if (!empty($settings['image_height_mobile'])) {
            $settings['image_height_mobile'] = is_array($settings['image_height_mobile']) ? $settings['image_height_mobile']['size'] : $settings['image_height_mobile'];
        }
        if (!empty($settings['card_radius_tablet'])) {
            $settings['card_radius_tablet'] = is_array($settings['card_radius_tablet']) ? $settings['card_radius_tablet']['size'] : $settings['card_radius_tablet'];
        }
        if (!empty($settings['card_radius_mobile'])) {
            $settings['card_radius_mobile'] = is_array($settings['card_radius_mobile']) ? $settings['card_radius_mobile']['size'] : $settings['card_radius_mobile'];
        }

        echo amaley_de_bootstrap()->renderer->render($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
