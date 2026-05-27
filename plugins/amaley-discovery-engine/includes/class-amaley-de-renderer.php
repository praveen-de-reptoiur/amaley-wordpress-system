<?php
/**
 * Frontend renderer for Amaley Discovery Engine.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amaley_DE_Renderer')) {
    class Amaley_DE_Renderer {
        /** @var Amaley_DE_Query */
        private $query;

        public function __construct($query) {
            $this->query = $query;
        }

        /**
         * Render a full discovery widget/block.
         *
         * @param array $settings Settings.
         * @return string
         */
        public function render($settings = array()) {
            if (function_exists('amaley_de_bootstrap')) {
                amaley_de_bootstrap()->enqueue_frontend_assets();
            }

            $settings = $this->normalize_settings($settings);
            $filters = $this->current_filters($settings);
            $settings['filters'] = $filters;
            $initial_result = $this->query->run($settings, $filters);
            $settings['preloaded_result'] = $initial_result;
            $instance_id = 'ade-' . wp_generate_uuid4();
            $settings['instance_id'] = $instance_id;

            $full_bleed = 'yes' === $settings['full_bleed'] ? ' is-full-bleed' : '';
            $layout_class = ' layout-' . sanitize_html_class($settings['desktop_filter_position']);
            $device_position_class = ' pos-desktop-' . sanitize_html_class($settings['desktop_filter_position']) . ' pos-tablet-' . sanitize_html_class($settings['tablet_filter_position']) . ' pos-mobile-' . sanitize_html_class($settings['mobile_filter_position']);
            $filter_mode_class = ' filter-desktop-' . sanitize_html_class($settings['desktop_filter_mode']) . ' filter-tablet-' . sanitize_html_class($settings['tablet_filter_mode']) . ' filter-mobile-' . sanitize_html_class($settings['mobile_filter_mode']);
            $json_settings = wp_json_encode($this->public_settings($settings));
            $custom_class = !empty($settings['custom_wrapper_class']) ? ' ' . sanitize_html_class($settings['custom_wrapper_class']) : '';

            ob_start();
            ?>
            <div id="<?php echo esc_attr($instance_id); ?>" class="amaley-discovery-engine-v1<?php echo esc_attr($full_bleed . $layout_class . $device_position_class . $filter_mode_class . $custom_class); ?>" data-ade-root data-ade-settings="<?php echo esc_attr($json_settings); ?>" style="<?php echo esc_attr($this->style_vars($settings)); ?>">
                <?php echo $this->render_instance_filter_mode_css($instance_id, $settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <div class="amaley-discovery-engine-v1__inner">
                    <?php echo $this->render_heading($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

                    <?php echo $this->render_mobile_experience_bar($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

                    <div class="amaley-discovery-engine-v1__layout">
                        <?php echo $this->render_filters($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <div class="amaley-discovery-engine-v1__results-wrap" data-ade-results-wrap>
                            <?php echo $this->render_results_html($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * Render just AJAX results.
         *
         * @param array $settings Settings.
         * @return array
         */
        public function render_results_only($settings = array()) {
            $settings = $this->normalize_settings($settings);
            return array(
                'html' => $this->render_results_html($settings),
            );
        }

        /**
         * Normalize shortcode/widget settings.
         *
         * @param array $settings Raw settings.
         * @return array
         */
        public function normalize_settings($settings) {
            $global = Amaley_DE_Settings::get();
            $defaults = array(
                'type'                    => 'products',
                'use_global_preset'       => 'no',
                'global_preset_key'       => '',
                'heading'                 => 'Our Products',
                'kicker'                  => 'Shop Amaley',
                'per_page'                => 9,
                'columns_desktop'         => 3,
                'columns_tablet'          => 2,
                'columns_mobile'          => 1,
                'filter_position'         => 'left',
                'desktop_filter_position' => '',
                'tablet_filter_position'  => '',
                'mobile_filter_position'  => '',
                'desktop_filter_mode'     => 'visible',
                'tablet_filter_mode'      => 'drawer',
                'mobile_filter_mode'      => 'drawer',
                'show_mobile_result_count' => 'yes',
                'show_mobile_quick_pills' => 'yes',
                'show_mobile_sort'        => 'yes',
                'show_mobile_active_chips' => 'yes',
                'show_result_count_desktop' => 'yes',
                'show_result_count_tablet' => 'yes',
                'show_result_count_mobile' => 'yes',
                'mobile_toolbar_layout'   => 'filter_sort',
                'mobile_quick_pills_limit' => 8,
                'full_bleed'              => 'yes',
                'inner_width'             => 'none',
                'pagination_type'         => 'numbers',
                'show_search'             => 'yes',
                'show_categories'         => 'yes',
                'show_price'              => 'yes',
                'show_tags'               => 'yes',
                'show_stock'              => 'yes',
                'show_attr_cluster'       => 'no',
                'show_attr_collection_type' => 'no',
                'show_attr_core_ingredient' => 'no',
                'show_attr_producer_maker' => 'no',
                'show_attr_region_cluster' => 'no',
                'show_attr_shg'           => 'no',
                'show_attr_use_case'      => 'no',
                'show_attr_village_source_location' => 'no',
                'show_sort'               => 'yes',
                'show_active_chips'       => 'yes',
                'default_filter_mode'     => 'all',
                'default_category'        => '',
                'default_tag'             => '',
                'default_attr_collection_type' => '',
                'default_attr_core_ingredient' => '',
                'default_attr_cluster'    => '',
                'default_attr_producer_maker' => '',
                'default_attr_region_cluster' => '',
                'default_attr_shg'        => '',
                'default_attr_use_case'   => '',
                'default_attr_village_source_location' => '',
                'include_product_ids'     => '',
                'exclude_product_ids'     => '',
                'include_product_categories' => '',
                'exclude_product_categories' => '',
                'include_product_tags'    => '',
                'exclude_product_tags'    => '',
                'include_attr_collection_type' => '',
                'exclude_attr_collection_type' => '',
                'include_attr_core_ingredient' => '',
                'exclude_attr_core_ingredient' => '',
                'include_attr_cluster'    => '',
                'exclude_attr_cluster'    => '',
                'include_attr_producer_maker' => '',
                'exclude_attr_producer_maker' => '',
                'include_attr_region_cluster' => '',
                'exclude_attr_region_cluster' => '',
                'include_attr_shg'        => '',
                'exclude_attr_shg'        => '',
                'include_attr_use_case'   => '',
                'exclude_attr_use_case'   => '',
                'include_attr_village_source_location' => '',
                'exclude_attr_village_source_location' => '',
                'default_sort'            => 'latest',
                'post_type'               => '',
                'taxonomy'                => '',
                'relation_meta_key'       => '',
                'relation_meta_value'     => '',
                'heading_color'           => $global['primary_color'],
                'heading_accent_color'    => $global['rust_color'],
                'kicker_color'            => $global['gold_color'],
                'section_bg_color'        => $global['ivory_color'],
                'card_bg_color'           => $global['cream_color'],
                'filter_bg_color'         => $global['cream_color'],
                'text_color'              => $global['primary_color'],
                'muted_color'             => '#7A573F',
                'primary_color'           => $global['primary_color'],
                'gold_color'              => $global['gold_color'],
                'rust_color'              => $global['rust_color'],
                'heading_font'            => $global['heading_font'],
                'body_font'               => $global['body_font'],
                'section_padding_top'     => 76,
                'section_padding_top_tablet' => 66,
                'section_padding_top_mobile' => 56,
                'section_padding_bottom'  => 84,
                'section_padding_bottom_tablet' => 74,
                'section_padding_bottom_mobile' => 68,
                'card_radius'             => 22,
                'card_radius_tablet'      => 20,
                'card_radius_mobile'      => 18,
                'image_height'            => 250,
                'image_height_tablet'     => 230,
                'image_height_mobile'     => 260,
                'heading_size'            => 76,
                'heading_size_tablet'     => 58,
                'heading_size_mobile'     => 44,
                'kicker_size'             => 11,
                'card_title_size'         => 25,
                'card_title_size_mobile'  => 23,
                'body_text_size'          => 13,
                'price_color'             => $global['primary_color'],
                'price_font_size'         => 15,
                'button_bg_color'         => $global['primary_color'],
                'button_text_color'       => '#FFF8EA',
                'button_hover_bg_color'   => $global['gold_color'],
                'button_hover_text_color' => $global['primary_color'],
                'pagination_bg_color'     => '#FFFFFF',
                'pagination_active_bg'    => $global['primary_color'],
                'pagination_active_text'  => '#FFF8EA',
                'drawer_bg_color'         => $global['cream_color'],
                'filters'                 => array(),
                'custom_wrapper_class'    => '',
                'sidebar_width'           => 290,
                'sidebar_min_width'       => 260,
                'sidebar_sticky_top'      => 96,
                'topbar_field_min_width'  => 150,
                'filter_actions_gap'      => 10,
                'card_min_width'          => 240,
                'grid_gap'                => 30,
                'card_renderer'           => 'default',
                'elementor_template_id'   => 0,
                'marketplace_badge_text'  => 'Bestseller',
                'marketplace_meta_text'   => 'Amaley Collection',
                'mobile_filter_button_text' => 'Filter',
                'filter_drawer_title'     => 'Filters',
                'apply_button_text'       => 'Apply Filters',
                'reset_button_text'       => 'Clear All',
                'show_filter_panel_title' => 'no',
                'filter_panel_kicker'     => 'Refine Selection',
                'filter_panel_title'      => 'Filters',
                'all_option_text'         => 'All',
                'search_label'            => 'Search',
                'search_placeholder'      => 'Search here...',
                'category_label'          => 'Category',
                'tag_label'               => 'Tag',
                'collection_type_label'   => 'Collection Type',
                'core_ingredient_label'   => 'Core Ingredient',
                'cluster_label'           => 'Cluster',
                'producer_maker_label'    => 'Producer / Maker',
                'region_cluster_label'    => 'Source Belt / Region Cluster',
                'shg_label'               => 'SHG / Producer Group',
                'use_case_label'          => 'Use Case',
                'village_source_location_label' => 'Village / Source Location',
                'price_label'             => 'Price Range',
                'min_price_placeholder'   => 'Min',
                'max_price_placeholder'   => 'Max',
                'stock_label'             => 'Stock',
                'stock_any_label'         => 'Any stock status',
                'stock_in_label'          => 'In stock',
                'stock_out_label'         => 'Out of stock',
                'sort_label'              => 'Sort',
                'show_sidebar_cta'        => 'no',
                'show_sidebar_cta_desktop' => 'yes',
                'show_sidebar_cta_tablet'  => 'no',
                'show_sidebar_cta_mobile'  => 'no',
                'sidebar_cta_kicker'      => 'Collection Builder',
                'sidebar_cta_title'       => 'Choose Collection Paths',
                'sidebar_cta_text'        => 'Buying for teams, properties, events, guest hampers, or store counters? Start with bulk enquiry and Amaley can recommend the right collection by budget, audience, and purpose.',
                'sidebar_cta_button_text' => 'Curate Hamper',
                'sidebar_cta_button_url'  => '',
                'sidebar_cta_bg_color'    => '#4A1806',
                'sidebar_cta_text_color'  => '#FFF8EA',
                'sidebar_cta_accent_color' => '#C2880A',
                'sidebar_cta_button_bg_color' => '#C2880A',
                'sidebar_cta_button_text_color' => '#2E1203',
                'result_count_singular'   => '{count} result found',
                'result_count_plural'     => '{count} results found',
                'empty_state_title'       => 'No results found.',
                'empty_state_text'        => 'Try clearing one filter or explore all Amaley discoveries.',
            );

            // Imported preset engine: future filter/card/style presets can be imported
            // from Dashboard → Amaley Discovery without replacing plugin files.
            if (!empty($settings['use_global_preset']) && 'yes' === $settings['use_global_preset'] && !empty($settings['global_preset_key']) && class_exists('Amaley_DE_Settings')) {
                $requested_type = !empty($settings['type']) ? sanitize_key($settings['type']) : '';
                $preset_settings = Amaley_DE_Settings::get_preset_settings($settings['global_preset_key'], $requested_type);
                if (!empty($preset_settings)) {
                    $settings = array_merge($settings, $preset_settings);
                    if (!empty($requested_type)) {
                        $settings['type'] = $requested_type;
                    }
                }
            }

            $settings = wp_parse_args($settings, $defaults);

            $settings['type'] = sanitize_key($settings['type']);
            $settings['use_global_preset'] = ('yes' === $settings['use_global_preset']) ? 'yes' : 'no';
            $settings['global_preset_key'] = sanitize_key($settings['global_preset_key']);
            $filter_modes = array('visible', 'drawer', 'compact');
            // Backward compatibility: old v1.0.9/v1.1.0 setting used "inline".
            // It now maps to the clearer "visible" mode.
            foreach (array('desktop_filter_mode' => 'visible', 'tablet_filter_mode' => 'drawer', 'mobile_filter_mode' => 'drawer') as $mode_key => $fallback_mode) {
                if (!empty($settings[$mode_key]) && 'inline' === $settings[$mode_key]) {
                    $settings[$mode_key] = 'visible';
                }
                $settings[$mode_key] = in_array($settings[$mode_key], $filter_modes, true) ? $settings[$mode_key] : $fallback_mode;
            }
            $filter_positions = array('left', 'top');
            $settings['filter_position'] = in_array($settings['filter_position'], $filter_positions, true) ? $settings['filter_position'] : 'left';
            foreach (array('desktop_filter_position' => $settings['filter_position'], 'tablet_filter_position' => 'top', 'mobile_filter_position' => 'top') as $position_key => $position_fallback) {
                if (empty($settings[$position_key])) {
                    $settings[$position_key] = $position_fallback;
                }
                $settings[$position_key] = in_array($settings[$position_key], $filter_positions, true) ? $settings[$position_key] : $position_fallback;
            }

            foreach (array('show_mobile_result_count', 'show_mobile_quick_pills', 'show_mobile_sort', 'show_mobile_active_chips', 'show_result_count_desktop', 'show_result_count_tablet', 'show_result_count_mobile', 'show_attr_cluster', 'show_attr_collection_type', 'show_attr_core_ingredient', 'show_attr_producer_maker', 'show_attr_region_cluster', 'show_attr_shg', 'show_attr_use_case', 'show_attr_village_source_location', 'show_sidebar_cta', 'show_sidebar_cta_desktop', 'show_sidebar_cta_tablet', 'show_sidebar_cta_mobile', 'show_filter_panel_title') as $mobile_switch_key) {
                $settings[$mobile_switch_key] = ('yes' === ($settings[$mobile_switch_key] ?? 'yes')) ? 'yes' : 'no';
            }
            $label_text_keys = array(
                'filter_panel_kicker','filter_panel_title','all_option_text','search_label','search_placeholder',
                'category_label','tag_label','collection_type_label','core_ingredient_label','cluster_label',
                'producer_maker_label','region_cluster_label','shg_label','use_case_label','village_source_location_label',
                'price_label','min_price_placeholder','max_price_placeholder','stock_label','stock_any_label',
                'stock_in_label','stock_out_label','sort_label'
            );
            foreach ($label_text_keys as $label_text_key) {
                $settings[$label_text_key] = isset($settings[$label_text_key]) ? sanitize_text_field($settings[$label_text_key]) : '';
            }

            $settings['mobile_toolbar_layout'] = in_array($settings['mobile_toolbar_layout'], array('filter_sort', 'filter_only', 'sort_only'), true) ? $settings['mobile_toolbar_layout'] : 'filter_sort';
            $settings['mobile_quick_pills_limit'] = max(0, min(20, absint($settings['mobile_quick_pills_limit'])));
            $settings['per_page'] = max(1, min(96, absint($settings['per_page'])));
            $settings['columns_desktop'] = max(1, min(6, absint($settings['columns_desktop'])));
            $settings['columns_tablet'] = max(1, min(4, absint($settings['columns_tablet'])));
            $settings['columns_mobile'] = max(1, min(2, absint($settings['columns_mobile'])));
            foreach (array('section_padding_top','section_padding_top_tablet','section_padding_top_mobile','section_padding_bottom','section_padding_bottom_tablet','section_padding_bottom_mobile','card_radius','card_radius_tablet','card_radius_mobile','image_height','image_height_tablet','image_height_mobile','heading_size','heading_size_tablet','heading_size_mobile','kicker_size','card_title_size','card_title_size_mobile','body_text_size','price_font_size','sidebar_width','sidebar_min_width','sidebar_sticky_top','topbar_field_min_width','filter_actions_gap','card_min_width','grid_gap') as $numeric_key) {
                $settings[$numeric_key] = isset($settings[$numeric_key]) ? absint($settings[$numeric_key]) : 0;
            }
            foreach (array('heading_color','heading_accent_color','kicker_color','section_bg_color','card_bg_color','filter_bg_color','text_color','muted_color','primary_color','gold_color','rust_color','price_color','button_bg_color','button_text_color','button_hover_bg_color','button_hover_text_color','pagination_bg_color','pagination_active_bg','pagination_active_text','drawer_bg_color','sidebar_cta_bg_color','sidebar_cta_text_color','sidebar_cta_accent_color','sidebar_cta_button_bg_color','sidebar_cta_button_text_color') as $color_key) {
                if (!empty($settings[$color_key])) {
                    $clean_color = sanitize_hex_color($settings[$color_key]);
                    if ($clean_color) {
                        $settings[$color_key] = $clean_color;
                    }
                }
            }

            $settings['custom_wrapper_class'] = sanitize_html_class($settings['custom_wrapper_class']);
            $settings['card_renderer'] = in_array($settings['card_renderer'], array('default', 'marketplace_card', 'elementor_template'), true) ? $settings['card_renderer'] : 'default';
            $settings['elementor_template_id'] = max(0, absint($settings['elementor_template_id']));
            foreach (array('marketplace_badge_text','marketplace_meta_text','mobile_filter_button_text','filter_drawer_title','apply_button_text','reset_button_text','sidebar_cta_kicker','sidebar_cta_title','sidebar_cta_button_text','result_count_singular','result_count_plural','empty_state_title','empty_state_text') as $text_key) {
                $settings[$text_key] = sanitize_text_field($settings[$text_key]);
            }
            $settings['sidebar_cta_text'] = wp_kses_post($settings['sidebar_cta_text']);
            $settings['sidebar_cta_button_url'] = esc_url_raw($settings['sidebar_cta_button_url']);

            return $settings;
        }

        private function public_settings($settings) {
            $allowed = array(
                'type', 'use_global_preset', 'global_preset_key', 'per_page', 'columns_desktop', 'columns_tablet', 'columns_mobile', 'filter_position', 'desktop_filter_position', 'tablet_filter_position', 'mobile_filter_position', 'desktop_filter_mode', 'tablet_filter_mode', 'mobile_filter_mode', 'show_mobile_result_count', 'show_mobile_quick_pills', 'show_mobile_sort', 'show_mobile_active_chips', 'show_result_count_desktop', 'show_result_count_tablet', 'show_result_count_mobile', 'mobile_toolbar_layout', 'mobile_quick_pills_limit', 'full_bleed', 'inner_width', 'pagination_type', 'show_search', 'show_categories', 'show_price', 'show_tags', 'show_stock', 'show_attr_cluster', 'show_attr_collection_type', 'show_attr_core_ingredient', 'show_attr_producer_maker', 'show_attr_region_cluster', 'show_attr_shg', 'show_attr_use_case', 'show_attr_village_source_location', 'show_sort', 'show_active_chips', 'default_filter_mode', 'default_category', 'default_tag', 'default_attr_collection_type', 'default_attr_core_ingredient', 'default_attr_cluster', 'default_attr_producer_maker', 'default_attr_region_cluster', 'default_attr_shg', 'default_attr_use_case', 'default_attr_village_source_location', 'include_product_ids', 'exclude_product_ids', 'include_product_categories', 'exclude_product_categories', 'include_product_tags', 'exclude_product_tags', 'include_attr_collection_type', 'exclude_attr_collection_type', 'include_attr_core_ingredient', 'exclude_attr_core_ingredient', 'include_attr_cluster', 'exclude_attr_cluster', 'include_attr_producer_maker', 'exclude_attr_producer_maker', 'include_attr_region_cluster', 'exclude_attr_region_cluster', 'include_attr_shg', 'exclude_attr_shg', 'include_attr_use_case', 'exclude_attr_use_case', 'include_attr_village_source_location', 'exclude_attr_village_source_location', 'default_sort', 'post_type', 'taxonomy', 'relation_meta_key', 'relation_meta_value', 'heading', 'kicker', 'heading_color', 'heading_accent_color', 'kicker_color', 'section_bg_color', 'card_bg_color', 'filter_bg_color', 'text_color', 'muted_color', 'primary_color', 'gold_color', 'rust_color', 'heading_font', 'body_font', 'section_padding_top', 'section_padding_top_tablet', 'section_padding_top_mobile', 'section_padding_bottom', 'section_padding_bottom_tablet', 'section_padding_bottom_mobile', 'card_radius', 'card_radius_tablet', 'card_radius_mobile', 'image_height', 'image_height_tablet', 'image_height_mobile', 'heading_size', 'heading_size_tablet', 'heading_size_mobile', 'kicker_size', 'card_title_size', 'card_title_size_mobile', 'body_text_size', 'price_color', 'price_font_size', 'button_bg_color', 'button_text_color', 'button_hover_bg_color', 'button_hover_text_color', 'pagination_bg_color', 'pagination_active_bg', 'pagination_active_text', 'drawer_bg_color', 'custom_wrapper_class', 'sidebar_width', 'sidebar_min_width', 'sidebar_sticky_top', 'topbar_field_min_width', 'filter_actions_gap', 'card_min_width', 'grid_gap', 'card_renderer', 'elementor_template_id', 'marketplace_badge_text', 'marketplace_meta_text', 'mobile_filter_button_text', 'filter_drawer_title', 'apply_button_text', 'reset_button_text', 'show_filter_panel_title', 'filter_panel_kicker', 'filter_panel_title', 'all_option_text', 'search_label', 'search_placeholder', 'category_label', 'tag_label', 'collection_type_label', 'core_ingredient_label', 'cluster_label', 'producer_maker_label', 'region_cluster_label', 'shg_label', 'use_case_label', 'village_source_location_label', 'price_label', 'min_price_placeholder', 'max_price_placeholder', 'stock_label', 'stock_any_label', 'stock_in_label', 'stock_out_label', 'sort_label', 'show_sidebar_cta', 'show_sidebar_cta_desktop', 'show_sidebar_cta_tablet', 'show_sidebar_cta_mobile', 'sidebar_cta_kicker', 'sidebar_cta_title', 'sidebar_cta_text', 'sidebar_cta_button_text', 'sidebar_cta_button_url', 'sidebar_cta_bg_color', 'sidebar_cta_text_color', 'sidebar_cta_accent_color', 'sidebar_cta_button_bg_color', 'sidebar_cta_button_text_color', 'result_count_singular', 'result_count_plural', 'empty_state_title', 'empty_state_text'
            );
            return array_intersect_key($settings, array_flip($allowed));
        }

        /**
         * Read URL filters or provided filters.
         *
         * @param array $settings Settings.
         * @return array
         */
        private function current_filters($settings) {
            $provided = isset($settings['filters']) && is_array($settings['filters']) ? $settings['filters'] : array();

            $category = $this->request_value_or_default(
                $settings,
                $provided,
                'category',
                'ade_category',
                $settings['default_category'] ?? '',
                'product_cat',
                $settings['include_product_categories'] ?? '',
                $settings['exclude_product_categories'] ?? ''
            );

            $tag = $this->request_value_or_default(
                $settings,
                $provided,
                'tag',
                'ade_tag',
                $settings['default_tag'] ?? '',
                'product_tag',
                $settings['include_product_tags'] ?? '',
                $settings['exclude_product_tags'] ?? ''
            );

            $filters = array(
                'search'    => sanitize_text_field($provided['search'] ?? (isset($_GET['ade_search']) ? wp_unslash($_GET['ade_search']) : '')),
                'category'  => $category,
                'tag'       => $tag,
                'stock'     => sanitize_text_field($provided['stock'] ?? (isset($_GET['ade_stock']) ? wp_unslash($_GET['ade_stock']) : '')),
                'min_price' => isset($provided['min_price']) ? $provided['min_price'] : (isset($_GET['ade_min_price']) ? wp_unslash($_GET['ade_min_price']) : ''),
                'max_price' => isset($provided['max_price']) ? $provided['max_price'] : (isset($_GET['ade_max_price']) ? wp_unslash($_GET['ade_max_price']) : ''),
                'sort'      => sanitize_text_field($provided['sort'] ?? (isset($_GET['ade_sort']) ? wp_unslash($_GET['ade_sort']) : ($settings['default_sort'] ?? 'latest'))),
                'page'      => max(1, absint($provided['page'] ?? (isset($_GET['ade_page']) ? wp_unslash($_GET['ade_page']) : 1))),
                'attrs'     => array(),
            );

            foreach ($this->attribute_definitions() as $attr_key => $definition) {
                $provided_has_attr = isset($provided['attrs']) && is_array($provided['attrs']) && array_key_exists($attr_key, $provided['attrs']);
                $provided_attr = $provided_has_attr ? $provided['attrs'][$attr_key] : null;
                $get_key = 'ade_attr_' . $attr_key;

                if ($provided_has_attr) {
                    $filters['attrs'][$attr_key] = sanitize_text_field($provided_attr);
                } elseif (isset($_GET[$get_key])) {
                    $filters['attrs'][$attr_key] = sanitize_text_field(wp_unslash($_GET[$get_key]));
                } else {
                    $filters['attrs'][$attr_key] = $this->default_filter_value(
                        $settings,
                        $settings['default_attr_' . $attr_key] ?? '',
                        $definition['taxonomy'],
                        $settings['include_attr_' . $attr_key] ?? '',
                        $settings['exclude_attr_' . $attr_key] ?? ''
                    );
                }
            }
            $filters['min_price'] = '' === $filters['min_price'] ? '' : floatval($filters['min_price']);
            $filters['max_price'] = '' === $filters['max_price'] ? '' : floatval($filters['max_price']);
            return $filters;
        }

        private function request_value_or_default($settings, $provided, $provided_key, $get_key, $custom_default, $taxonomy = '', $include_slugs = '', $exclude_slugs = '') {
            if (array_key_exists($provided_key, $provided)) {
                return sanitize_text_field($provided[$provided_key]);
            }
            if (isset($_GET[$get_key])) {
                return sanitize_text_field(wp_unslash($_GET[$get_key]));
            }
            return $this->default_filter_value($settings, $custom_default, $taxonomy, $include_slugs, $exclude_slugs);
        }

        private function default_filter_value($settings, $custom_default, $taxonomy = '', $include_slugs = '', $exclude_slugs = '') {
            $mode = sanitize_key($settings['default_filter_mode'] ?? 'all');
            if ('custom' === $mode) {
                if (is_array($custom_default)) {
                    $custom_default = reset($custom_default);
                }
                if ('' !== (string) $custom_default) {
                    return sanitize_title($custom_default);
                }
            }
            if ('first' === $mode && $taxonomy) {
                return $this->first_available_term_slug($taxonomy, $include_slugs, $exclude_slugs);
            }
            return '';
        }

        private function first_available_term_slug($taxonomy, $include_slugs = '', $exclude_slugs = '') {
            if (!taxonomy_exists($taxonomy)) {
                return '';
            }
            $include = $this->csv_to_slugs($include_slugs);
            $exclude = $this->csv_to_slugs($exclude_slugs);
            $term_args = array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
                'number'     => 1,
                'orderby'    => 'name',
                'order'      => 'ASC',
            );
            if (!empty($include)) {
                $term_args['slug'] = $include;
            }
            if (!empty($exclude)) {
                $excluded_term_ids = get_terms(array(
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                    'fields'     => 'ids',
                    'slug'       => $exclude,
                ));
                if (!is_wp_error($excluded_term_ids) && !empty($excluded_term_ids)) {
                    $term_args['exclude'] = array_map('absint', $excluded_term_ids);
                }
            }
            $terms = get_terms($term_args);
            if (is_wp_error($terms) || empty($terms)) {
                return '';
            }
            return sanitize_title($terms[0]->slug);
        }

        private function style_vars($settings) {
            $vars = array(
                '--ade-heading-color' => $settings['heading_color'],
                '--ade-heading-accent-color' => $settings['heading_accent_color'],
                '--ade-kicker-color' => $settings['kicker_color'],
                '--ade-section-bg' => $settings['section_bg_color'],
                '--ade-card-bg' => $settings['card_bg_color'],
                '--ade-filter-bg' => $settings['filter_bg_color'],
                '--ade-text' => $settings['text_color'],
                '--ade-muted' => $settings['muted_color'],
                '--ade-primary' => $settings['primary_color'],
                '--ade-gold' => $settings['gold_color'],
                '--ade-rust' => $settings['rust_color'],
                '--ade-heading-font' => $settings['heading_font'],
                '--ade-body-font' => $settings['body_font'],
                '--ade-columns-desktop' => $settings['columns_desktop'],
                '--ade-columns-tablet' => $settings['columns_tablet'],
                '--ade-columns-mobile' => $settings['columns_mobile'],
                '--ade-section-padding-top' => absint($settings['section_padding_top']) . 'px',
                '--ade-section-padding-top-tablet' => absint($settings['section_padding_top_tablet']) . 'px',
                '--ade-section-padding-top-mobile' => absint($settings['section_padding_top_mobile']) . 'px',
                '--ade-section-padding-bottom' => absint($settings['section_padding_bottom']) . 'px',
                '--ade-section-padding-bottom-tablet' => absint($settings['section_padding_bottom_tablet']) . 'px',
                '--ade-section-padding-bottom-mobile' => absint($settings['section_padding_bottom_mobile']) . 'px',
                '--ade-card-radius' => absint($settings['card_radius']) . 'px',
                '--ade-card-radius-tablet' => absint($settings['card_radius_tablet']) . 'px',
                '--ade-card-radius-mobile' => absint($settings['card_radius_mobile']) . 'px',
                '--ade-image-height' => absint($settings['image_height']) . 'px',
                '--ade-image-height-tablet' => absint($settings['image_height_tablet']) . 'px',
                '--ade-image-height-mobile' => absint($settings['image_height_mobile']) . 'px',
                '--ade-heading-size' => absint($settings['heading_size']) . 'px',
                '--ade-heading-size-tablet' => absint($settings['heading_size_tablet']) . 'px',
                '--ade-heading-size-mobile' => absint($settings['heading_size_mobile']) . 'px',
                '--ade-kicker-size' => absint($settings['kicker_size']) . 'px',
                '--ade-card-title-size' => absint($settings['card_title_size']) . 'px',
                '--ade-card-title-size-mobile' => absint($settings['card_title_size_mobile']) . 'px',
                '--ade-body-text-size' => absint($settings['body_text_size']) . 'px',
                '--ade-price-color' => $settings['price_color'],
                '--ade-price-font-size' => absint($settings['price_font_size']) . 'px',
                '--ade-button-bg' => $settings['button_bg_color'],
                '--ade-button-text' => $settings['button_text_color'],
                '--ade-button-hover-bg' => $settings['button_hover_bg_color'],
                '--ade-button-hover-text' => $settings['button_hover_text_color'],
                '--ade-pagination-bg' => $settings['pagination_bg_color'],
                '--ade-pagination-active-bg' => $settings['pagination_active_bg'],
                '--ade-pagination-active-text' => $settings['pagination_active_text'],
                '--ade-drawer-bg' => $settings['drawer_bg_color'],
                '--ade-inner-max' => 'none' === $settings['inner_width'] ? 'none' : absint($settings['inner_width']) . 'px',
                '--ade-sidebar-width' => absint($settings['sidebar_width']) . 'px',
                '--ade-sidebar-min-width' => absint($settings['sidebar_min_width']) . 'px',
                '--ade-sidebar-sticky-top' => absint($settings['sidebar_sticky_top']) . 'px',
                '--ade-topbar-field-min-width' => absint($settings['topbar_field_min_width']) . 'px',
                '--ade-filter-actions-gap' => absint($settings['filter_actions_gap']) . 'px',
                '--ade-card-min-width' => absint($settings['card_min_width']) . 'px',
                '--ade-grid-gap' => absint($settings['grid_gap']) . 'px',
                '--ade-sidebar-cta-bg' => $settings['sidebar_cta_bg_color'],
                '--ade-sidebar-cta-text' => $settings['sidebar_cta_text_color'],
                '--ade-sidebar-cta-accent' => $settings['sidebar_cta_accent_color'],
                '--ade-sidebar-cta-button-bg' => $settings['sidebar_cta_button_bg_color'],
                '--ade-sidebar-cta-button-text' => $settings['sidebar_cta_button_text_color'],
            );

            $out = '';
            foreach ($vars as $key => $value) {
                $out .= $key . ':' . $value . ';';
            }
            return $out;
        }

        /**
         * Instance-scoped responsive filter mode CSS.
         *
         * v1.1.2 gives independent Desktop / Tablet / Phone controls and safe full-visible responsive rendering:
         * - visible: full filter form remains visible
         * - drawer: compact toolbar + advanced filter drawer
         * - compact: compact toolbar only, no drawer/form
         *
         * This instance-level CSS is intentionally printed inside the widget
         * so Elementor controls override older imported runtime patches safely.
         *
         * @param string $instance_id Widget instance ID.
         * @param array  $settings Widget settings.
         * @return string
         */
        private function render_instance_filter_mode_css($instance_id, $settings) {
            $id = '#' . sanitize_html_class($instance_id);
            $desktop = $settings['desktop_filter_mode'];
            $tablet = $settings['tablet_filter_mode'];
            $mobile = $settings['mobile_filter_mode'];
            $desktop_position = $settings['desktop_filter_position'];
            $tablet_position = $settings['tablet_filter_position'];
            $mobile_position = $settings['mobile_filter_position'];

            $css = '';

            $css .= $this->device_filter_css($id, $desktop, 'desktop', $desktop_position);
            $css .= '@media(max-width:1024px){' . $this->device_filter_css($id, $tablet, 'tablet', $tablet_position) . '}';
            $css .= '@media(max-width:620px){' . $this->device_filter_css($id, $mobile, 'mobile', $mobile_position) . '}';

            // v1.1.3 laptop sidebar lock:
            // Elementor desktop preview can have an iframe width close to tablet size.
            // This rule only affects 881px+ screens and re-applies the selected desktop
            // filter position after tablet media rules, without changing phone/tablet
            // behaviours below 880px.
            $css .= '@media(min-width:881px){' . $this->desktop_laptop_filter_position_css($id, $settings) . '}';

            $css .= $this->result_count_visibility_css($id, $settings);

            return '<style>' . $css . '</style>';
        }

        /**
         * Instance-scoped main result count visibility.
         *
         * This gives the user direct Elementor controls for hiding the normal
         * "15 results found" line above cards independently on desktop,
         * tablet and phone. It is intentionally separate from the toolbar
         * result count, because toolbar count and main count are different UI
         * layers.
         *
         * @param string $id Widget CSS ID selector.
         * @param array  $settings Widget settings.
         * @return string
         */
        private function result_count_visibility_css($id, $settings) {
            $base = $id . '.amaley-discovery-engine-v1';
            $css = '';

            $hide_rule = $base . ' .amaley-discovery-engine-v1__result-count{display:none!important;}';
            $empty_head_rule = $base . ' .amaley-discovery-engine-v1__result-head:not(:has(.amaley-discovery-engine-v1__chips)):not(:has(.amaley-discovery-engine-v1__result-sort-wrap)){display:none!important;margin:0!important;}';

            if ('no' === ($settings['show_result_count_desktop'] ?? 'yes')) {
                $css .= $hide_rule . $empty_head_rule;
            }

            if ('no' === ($settings['show_result_count_tablet'] ?? 'yes')) {
                $css .= '@media(max-width:1024px){' . $hide_rule . $empty_head_rule . '}';
            }

            if ('no' === ($settings['show_result_count_mobile'] ?? 'yes')) {
                $css .= '@media(max-width:620px){' . $hide_rule . $empty_head_rule . '}';
            }

            return $css;
        }

        /**
         * Re-apply desktop filter position on laptop/editor widths.
         *
         * This protects the Desktop + Left Sidebar layout from being visually
         * converted into a top bar by tablet media rules inside Elementor's
         * desktop preview iframe. The rule starts at 881px, so approved phone
         * and tablet compact/drawer behaviour below 880px stays untouched.
         *
         * @param string $id Widget CSS ID selector.
         * @param array  $settings Widget settings.
         * @return string
         */
        private function desktop_laptop_filter_position_css($id, $settings) {
            $base = $id . '.amaley-discovery-engine-v1';
            $position = isset($settings['desktop_filter_position']) ? $settings['desktop_filter_position'] : (isset($settings['filter_position']) ? $settings['filter_position'] : 'left');
            $desktop_mode = isset($settings['desktop_filter_mode']) ? $settings['desktop_filter_mode'] : 'visible';

            // Only force a sidebar/topbar when desktop is using the full visible form.
            // Drawer/compact desktop modes should keep their toolbar behaviour.
            if ('visible' !== $desktop_mode) {
                return '';
            }

            if ('left' === $position) {
                return $base . ' .amaley-discovery-engine-v1__mobile-bar{display:none!important;}'
                    . $base . ' .amaley-discovery-engine-v1__result-head{display:flex!important;}'
                    . $base . ' .amaley-discovery-engine-v1__layout{display:grid!important;grid-template-columns:minmax(var(--ade-sidebar-min-width,260px),var(--ade-sidebar-width,290px)) minmax(0,1fr)!important;gap:var(--ade-grid-gap,30px)!important;align-items:start!important;width:100%!important;min-width:0!important;}'
                    . $base . ' .amaley-discovery-engine-v1__filters{display:flex!important;flex-direction:column!important;position:sticky!important;top:var(--ade-sidebar-sticky-top,96px)!important;width:100%!important;max-width:100%!important;align-self:start!important;justify-self:stretch!important;inset:auto!important;transform:none!important;translate:none!important;height:auto!important;max-height:none!important;overflow:visible!important;border-radius:24px!important;padding:22px!important;}'
                    . $base . ' .amaley-discovery-engine-v1__filter-actions{display:flex!important;flex-direction:column!important;gap:var(--ade-filter-actions-gap,10px)!important;}'
                    . $base . ' .amaley-discovery-engine-v1__results-wrap{width:100%!important;min-width:0!important;}';
            }

            // Top Bar desktop must remain a compact horizontal filter bar.
            return $base . ' .amaley-discovery-engine-v1__mobile-bar{display:none!important;}'
                . $base . ' .amaley-discovery-engine-v1__result-head{display:flex!important;}'
                . $base . ' .amaley-discovery-engine-v1__layout{display:grid!important;grid-template-columns:1fr!important;gap:var(--ade-grid-gap,30px)!important;width:100%!important;min-width:0!important;}'
                . $base . ' .amaley-discovery-engine-v1__filters{display:grid!important;grid-template-columns:repeat(auto-fit,minmax(var(--ade-topbar-field-min-width,150px),1fr))!important;align-items:end!important;gap:14px!important;position:relative!important;top:auto!important;width:100%!important;max-width:100%!important;}'
                . $base . ' .amaley-discovery-engine-v1__filter-actions{display:grid!important;grid-template-columns:1fr 1fr!important;gap:var(--ade-filter-actions-gap,10px)!important;}';
        }

        /**
         * Build scoped CSS for one device filter mode.
         *
         * @param string $id Widget CSS ID selector.
         * @param string $mode visible|drawer|compact.
         * @param string $device desktop|tablet|mobile.
         * @param string $position left|top for full-visible mode on this device.
         * @return string
         */
        private function device_filter_css($id, $mode, $device, $position = 'top') {
            $base = $id . '.amaley-discovery-engine-v1';
            $css = '';

            // Shared mode rule: drawer/compact use the responsive toolbar, so the normal result head is hidden.
            if ('drawer' === $mode || 'compact' === $mode) {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-bar{display:flex!important;flex-direction:column!important;align-items:flex-start!important;justify-content:flex-start!important;gap:14px!important;width:100%!important;margin:0 0 22px!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__result-head{display:none!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:1fr!important;gap:24px!important;}';
            } else {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-bar{display:none!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__result-head{display:flex!important;}';
            }

            if ('drawer' === $mode) {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-filter-button{display:inline-flex!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__filters,' . $base . '.layout-top .amaley-discovery-engine-v1__filters{display:flex!important;position:fixed!important;top:0!important;right:0!important;bottom:0!important;left:auto!important;transform:translateX(105%)!important;translate:none!important;width:min(390px,92vw)!important;max-width:92vw!important;height:auto!important;max-height:100dvh!important;overflow:auto!important;z-index:99999!important;border-radius:22px 0 0 22px!important;background:var(--ade-drawer-bg,var(--ade-filter-bg,#FFF8EA))!important;}';
                $css .= $base . '.is-filter-open .amaley-discovery-engine-v1__filters{transform:translateX(0)!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__filter-drawer-head{display:flex!important;align-items:center!important;justify-content:space-between!important;gap:12px!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__drawer-backdrop{display:none!important;position:fixed!important;inset:0!important;z-index:99998!important;background:rgba(46,18,3,.34)!important;}';
                $css .= $base . '.is-filter-open .amaley-discovery-engine-v1__drawer-backdrop{display:block!important;}';
            }

            if ('compact' === $mode) {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-filter-button{display:none!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__filters,' . $base . '.layout-top .amaley-discovery-engine-v1__filters{display:none!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__drawer-backdrop{display:none!important;opacity:0!important;visibility:hidden!important;pointer-events:none!important;}';
            }

            if ('visible' === $mode) {
                $css .= $base . ' .amaley-discovery-engine-v1__filter-drawer-head,' . $base . ' .amaley-discovery-engine-v1__drawer-backdrop{display:none!important;}';

                if ('desktop' === $device) {
                    if ('left' === $position) {
                        $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:minmax(var(--ade-sidebar-min-width,260px),var(--ade-sidebar-width,290px)) minmax(0,1fr)!important;gap:var(--ade-grid-gap,30px)!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filters{display:flex!important;flex-direction:column!important;position:sticky!important;top:var(--ade-sidebar-sticky-top,96px)!important;width:100%!important;max-width:100%!important;align-self:start!important;justify-self:stretch!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filter-actions{display:flex!important;flex-direction:column!important;gap:var(--ade-filter-actions-gap,10px)!important;}';
                    } else {
                        $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:1fr!important;gap:var(--ade-grid-gap,30px)!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filters{display:grid!important;grid-template-columns:repeat(auto-fit,minmax(var(--ade-topbar-field-min-width,150px),1fr))!important;align-items:end!important;gap:14px!important;position:relative!important;top:auto!important;width:100%!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filter-actions{display:grid!important;grid-template-columns:1fr 1fr!important;gap:var(--ade-filter-actions-gap,10px)!important;}';
                    }
                } elseif ('tablet' === $device) {
                    if ('left' === $position) {
                        // Optional tablet sidebar for directory-heavy pages. Keep it safe and readable.
                        $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:minmax(210px,var(--ade-sidebar-width,290px)) minmax(0,1fr)!important;gap:22px!important;align-items:start!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filters{display:flex!important;flex-direction:column!important;gap:13px!important;position:relative!important;inset:auto!important;transform:none!important;translate:none!important;opacity:1!important;visibility:visible!important;pointer-events:auto!important;width:100%!important;max-width:100%!important;height:auto!important;max-height:none!important;overflow:visible!important;z-index:1!important;border-radius:22px!important;padding:18px!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filter-actions{display:flex!important;flex-direction:column!important;gap:var(--ade-filter-actions-gap,10px)!important;}';
                    } else {
                        // Approved topbar full-visible layout: compact, no giant empty box.
                        $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:1fr!important;gap:24px!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filters{display:grid!important;grid-template-columns:repeat(2,minmax(0,1fr))!important;align-items:end!important;gap:14px!important;position:relative!important;inset:auto!important;transform:none!important;translate:none!important;opacity:1!important;visibility:visible!important;pointer-events:auto!important;width:100%!important;max-width:100%!important;height:auto!important;max-height:none!important;overflow:visible!important;z-index:1!important;border-radius:22px!important;padding:18px!important;}';
                        $css .= $base . ' .amaley-discovery-engine-v1__filter-actions{grid-column:1 / -1!important;display:grid!important;grid-template-columns:1fr 1fr!important;gap:12px!important;}';
                    }
                } else {
                    // Phone can never be a true sidebar without causing overflow. If Left is chosen, it stacks safely.
                    $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:1fr!important;gap:22px!important;}';
                    $css .= $base . ' .amaley-discovery-engine-v1__filters{display:grid!important;grid-template-columns:1fr!important;align-items:end!important;gap:13px!important;position:relative!important;inset:auto!important;top:auto!important;right:auto!important;bottom:auto!important;left:auto!important;transform:none!important;translate:none!important;opacity:1!important;visibility:visible!important;pointer-events:auto!important;width:100%!important;max-width:100%!important;height:auto!important;max-height:none!important;overflow:visible!important;z-index:1!important;border-radius:20px!important;padding:16px!important;}';
                    $css .= $base . ' .amaley-discovery-engine-v1__filter-actions{display:grid!important;grid-template-columns:1fr!important;gap:var(--ade-filter-actions-gap,10px)!important;}';
                }
            }

            return $css;
        }

        /**
         * Render mobile discovery bar for drawer mode.
         *
         * This keeps mobile UX premium: result count, quick category pills,
         * filter button, sort dropdown, and active chips are visible before
         * the drawer opens. It stays scoped to this widget instance.
         *
         * @param array $settings Normalized settings.
         * @return string
         */
        private function render_mobile_experience_bar($settings) {
            $result = (!empty($settings['preloaded_result']) && is_array($settings['preloaded_result'])) ? $settings['preloaded_result'] : array('total' => 0);
            $filters = isset($settings['filters']) && is_array($settings['filters']) ? $settings['filters'] : $this->current_filters($settings);
            $show_filter_button = in_array($settings['mobile_toolbar_layout'], array('filter_sort', 'filter_only'), true);
            $show_sort_toolbar = ('yes' === $settings['show_mobile_sort'] && in_array($settings['mobile_toolbar_layout'], array('filter_sort', 'sort_only'), true));
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__mobile-bar" data-ade-mobile-bar>
                <?php if ('yes' === $settings['show_mobile_result_count']) : ?>
                    <div class="amaley-discovery-engine-v1__mobile-count" data-ade-mobile-count>
                        <?php
                        $count_label = (1 === (int) $result['total']) ? $settings['result_count_singular'] : $settings['result_count_plural'];
                        echo esc_html(str_replace('{count}', number_format_i18n((int) $result['total']), $count_label));
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_mobile_quick_pills'] && $settings['mobile_quick_pills_limit'] > 0) : ?>
                    <?php echo $this->render_mobile_quick_pills($settings, $filters); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php endif; ?>

                <?php if ($show_filter_button || $show_sort_toolbar) : ?>
                    <div class="amaley-discovery-engine-v1__mobile-toolbar">
                        <?php if ($show_filter_button) : ?>
                            <button type="button" class="amaley-discovery-engine-v1__mobile-filter-button" data-ade-open-filter><?php echo esc_html($settings['mobile_filter_button_text']); ?></button>
                        <?php endif; ?>
                        <?php if ($show_sort_toolbar) : ?>
                            <?php echo $this->render_sort_selector($settings, $filters, 'mobile'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_mobile_active_chips']) : ?>
                    <div class="amaley-discovery-engine-v1__mobile-chips" data-ade-mobile-chips>
                        <?php echo $this->render_active_chips($filters, $settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * Render a shared sort selector for toolbar/result bar UI.
         *
         * This selector uses the same data attribute as the responsive toolbar
         * sort dropdown, so existing AJAX behaviour remains unchanged.
         *
         * @param array  $settings Normalized settings.
         * @param array  $filters Current filters.
         * @param string $context desktop|mobile.
         * @return string
         */
        private function render_sort_selector($settings, $filters, $context = 'desktop') {
            ob_start();
            ?>
            <label class="amaley-discovery-engine-v1__result-sort-wrap amaley-discovery-engine-v1__result-sort-wrap--<?php echo esc_attr($context); ?>">
                <span class="amaley-discovery-engine-v1__result-sort-label"><?php echo esc_html($settings['sort_label']); ?></span>
                <select class="amaley-discovery-engine-v1__result-sort" data-ade-mobile-sort aria-label="<?php echo esc_attr($settings['sort_label']); ?>">
                    <option value="latest" <?php selected($filters['sort'], 'latest'); ?>><?php esc_html_e('Latest', 'amaley-discovery-engine'); ?></option>
                    <?php if ('products' === $settings['type']) : ?>
                        <option value="price_low" <?php selected($filters['sort'], 'price_low'); ?>><?php esc_html_e('Price low-high', 'amaley-discovery-engine'); ?></option>
                        <option value="price_high" <?php selected($filters['sort'], 'price_high'); ?>><?php esc_html_e('Price high-low', 'amaley-discovery-engine'); ?></option>
                        <option value="popular" <?php selected($filters['sort'], 'popular'); ?>><?php esc_html_e('Popular', 'amaley-discovery-engine'); ?></option>
                        <option value="featured" <?php selected($filters['sort'], 'featured'); ?>><?php esc_html_e('Featured', 'amaley-discovery-engine'); ?></option>
                    <?php endif; ?>
                    <option value="title" <?php selected($filters['sort'], 'title'); ?>><?php esc_html_e('A to Z', 'amaley-discovery-engine'); ?></option>
                </select>
            </label>
            <?php
            return ob_get_clean();
        }

        /**
         * Render mobile quick taxonomy/category pills.
         *
         * @param array $settings Normalized settings.
         * @param array $filters Current filters.
         * @return string
         */
        private function render_mobile_quick_pills($settings, $filters) {
            $taxonomy = '';
            if ('products' === $settings['type']) {
                $taxonomy = 'product_cat';
            } elseif ('yes' === $settings['show_categories']) {
                $taxonomy = !empty($settings['taxonomy']) ? $settings['taxonomy'] : $this->default_taxonomy_for_type($settings['type']);
            }

            if (!$taxonomy || !taxonomy_exists($taxonomy)) {
                return '';
            }

            $term_args = array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => true,
                'number'     => absint($settings['mobile_quick_pills_limit']),
            );
            if ('product_cat' === $taxonomy) {
                $include = $this->csv_to_slugs($settings['include_product_categories'] ?? '');
                $exclude = $this->csv_to_slugs($settings['exclude_product_categories'] ?? '');
                if (!empty($include)) {
                    $term_args['slug'] = $include;
                }
                if (!empty($exclude)) {
                    $excluded_term_ids = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false, 'fields' => 'ids', 'slug' => $exclude));
                    if (!is_wp_error($excluded_term_ids) && !empty($excluded_term_ids)) {
                        $term_args['exclude'] = array_map('absint', $excluded_term_ids);
                    }
                }
            }
            $terms = get_terms($term_args);
            if (is_wp_error($terms)) {
                return '';
            }

            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__quick-pills" data-ade-quick-pills>
                <button type="button" class="amaley-discovery-engine-v1__quick-pill <?php echo empty($filters['category']) ? 'is-active' : ''; ?>" data-ade-quick-category="">
                    <?php esc_html_e('All', 'amaley-discovery-engine'); ?>
                </button>
                <?php foreach ($terms as $term) : ?>
                    <button type="button" class="amaley-discovery-engine-v1__quick-pill <?php echo ($filters['category'] === $term->slug) ? 'is-active' : ''; ?>" data-ade-quick-category="<?php echo esc_attr($term->slug); ?>">
                        <?php echo esc_html($term->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php
            return ob_get_clean();
        }

        private function render_heading($settings) {
            $heading = wp_kses_post($settings['heading']);
            $heading = str_replace(array('{', '}'), array('<span>', '</span>'), $heading);
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__heading-wrap">
                <?php if (!empty($settings['kicker'])) : ?>
                    <div class="amaley-discovery-engine-v1__kicker"><?php echo esc_html($settings['kicker']); ?></div>
                <?php endif; ?>
                <?php if (!empty($heading)) : ?>
                    <h2 class="amaley-discovery-engine-v1__heading"><?php echo wp_kses($heading, array('span' => array())); ?></h2>
                <?php endif; ?>
            </div>
            <?php
            return ob_get_clean();
        }

        private function render_results_html($settings) {
            $filters = $this->current_filters($settings);
            $settings['filters'] = $filters;
            if (!empty($settings['preloaded_result']) && is_array($settings['preloaded_result'])) {
                $result = $settings['preloaded_result'];
                unset($settings['preloaded_result']);
            } else {
                $result = $this->query->run($settings, $filters);
            }
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__result-head">
                <div class="amaley-discovery-engine-v1__result-count" data-ade-count>
                    <?php
                    $count_label = (1 === (int) $result['total']) ? $settings['result_count_singular'] : $settings['result_count_plural'];
                    echo esc_html(str_replace('{count}', number_format_i18n($result['total']), $count_label));
                    ?>
                </div>
                <div class="amaley-discovery-engine-v1__result-actions">
                    <?php if ('yes' === $settings['show_active_chips']) : ?>
                        <?php echo $this->render_active_chips($filters, $settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endif; ?>
                    <?php if ('yes' === ($settings['show_mobile_sort'] ?? 'no')) : ?>
                        <?php echo $this->render_sort_selector($settings, $filters, 'desktop'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($result['items'])) : ?>
                <div class="amaley-discovery-engine-v1__grid" data-ade-grid>
                    <?php foreach ($result['items'] as $post) : ?>
                        <?php echo $this->render_item_card($post, $settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="amaley-discovery-engine-v1__empty">
                    <h3><?php echo esc_html($settings['empty_state_title']); ?></h3>
                    <p><?php echo esc_html($settings['empty_state_text']); ?></p>
                </div>
            <?php endif; ?>

            <?php echo $this->render_pagination($result, $settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php
            return ob_get_clean();
        }

        /**
         * Render one result card. This keeps query/filter/pagination in the plugin,
         * while allowing the visual card to come either from the plugin default
         * card or from a selected Elementor Loop Item / Template.
         *
         * @param WP_Post $post Current result post.
         * @param array   $settings Normalized settings.
         * @return string
         */
        private function render_item_card($post, $settings) {
            if ('elementor_template' === $settings['card_renderer'] && !empty($settings['elementor_template_id'])) {
                $template_output = $this->render_elementor_template_card($post, $settings);
                if ('' !== $template_output) {
                    return $template_output;
                }
            }

            if ('products' === $settings['type'] && 'marketplace_card' === $settings['card_renderer']) {
                return $this->render_marketplace_product_card($post, $settings);
            }

            return ('products' === $settings['type']) ? $this->render_product_card($post) : $this->render_generic_card($post, $settings);
        }

        /**
         * Render a post/product using an Elementor template without taking over
         * Elementor, WooCommerce, or theme templates.
         *
         * Safety design:
         * - Works only when Elementor is available.
         * - Sets the current post/product context temporarily.
         * - Restores global state after rendering.
         * - Falls back to plugin card if anything is missing.
         *
         * @param WP_Post $post Current result post.
         * @param array   $settings Normalized settings.
         * @return string
         */
        private function render_elementor_template_card($post, $settings) {
            $template_id = absint($settings['elementor_template_id']);
            if (!$template_id || !is_a($post, 'WP_Post')) {
                return '';
            }

            if (!did_action('elementor/loaded') || !class_exists('\\Elementor\Plugin')) {
                return '';
            }

            $template_post = get_post($template_id);
            if (!$template_post || !in_array($template_post->post_type, array('elementor_library', 'e-landing-page'), true)) {
                return '';
            }

            $old_post = isset($GLOBALS['post']) ? $GLOBALS['post'] : null;
            $old_product = isset($GLOBALS['product']) ? $GLOBALS['product'] : null;

            $GLOBALS['post'] = $post;
            setup_postdata($post);

            if ('product' === $post->post_type && function_exists('wc_get_product')) {
                $GLOBALS['product'] = wc_get_product($post->ID);
            }

            // Enqueue Elementor template CSS once, instead of printing duplicate CSS per card.
            if (class_exists('\\Elementor\Core\Files\CSS\Post')) {
                try {
                    $css_file = new \Elementor\Core\Files\CSS\Post($template_id);
                    $css_file->enqueue();
                } catch (\Throwable $e) {
                    // Fail silently and let Elementor still try to render the content.
                } catch (\Exception $e) {
                    // PHP 7 compatibility fallback.
                }
            }

            $content = '';
            try {
                // Use with_css=true so Elementor template CSS is printed with the rendered card.
                // This prevents Loop Item cards from appearing unstyled on frontend/AJAX output.
                $content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, true);
            } catch (\Throwable $e) {
                $content = '';
            } catch (\Exception $e) {
                $content = '';
            }

            if ($old_post) {
                $GLOBALS['post'] = $old_post;
                setup_postdata($old_post);
            } else {
                wp_reset_postdata();
            }
            $GLOBALS['product'] = $old_product;

            if ('' === trim((string) $content)) {
                return '';
            }

            return '<article class="amaley-discovery-engine-v1__template-card" data-ade-template-card="' . esc_attr($template_id) . '">' . $content . '</article>';
        }

        /**
         * Render coded native Amaley marketplace product card.
         * This avoids Elementor Loop Item CSS dependency while keeping the
         * premium card style responsive and controlled by the Discovery Engine.
         *
         * @param WP_Post $post Product post.
         * @param array   $settings Normalized settings.
         * @return string
         */
        private function render_marketplace_product_card($post, $settings) {
            $product = function_exists('wc_get_product') ? wc_get_product($post->ID) : null;
            if (!$product) {
                return '';
            }

            $title = get_the_title($post);
            $link = get_permalink($post);
            $image = get_the_post_thumbnail_url($post, 'large');
            if (!$image && function_exists('wc_placeholder_img_src')) {
                $image = wc_placeholder_img_src('large');
            }

            $badge_text = !empty($settings['marketplace_badge_text']) ? $settings['marketplace_badge_text'] : __('Bestseller', 'amaley-discovery-engine');
            $meta_text = !empty($settings['marketplace_meta_text']) ? $settings['marketplace_meta_text'] : __('Amaley Collection', 'amaley-discovery-engine');
            $price = $product->get_price_html();
            $average_rating = (float) $product->get_average_rating();
            $rating_count = (int) $product->get_rating_count();
            $stock_quantity = $product->managing_stock() ? $product->get_stock_quantity() : '';
            $sold_quantity = (int) get_post_meta($post->ID, 'total_sales', true);
            $available_label = '' !== $stock_quantity && null !== $stock_quantity ? max(0, (int) $stock_quantity) : '';
            $sold_label = max(0, $sold_quantity);
            $progress_total = ($available_label !== '' ? (int) $available_label : 0) + $sold_label;
            $progress_percent = $progress_total > 0 ? min(100, max(6, round(($sold_label / $progress_total) * 100))) : 44;

            $button_text = __('View', 'amaley-discovery-engine');
            $button_url = $link;
            $button_classes = 'amaley-native-product-card-v1__button';
            $button_attrs = '';

            if ($product->is_purchasable() && $product->is_in_stock() && $product->is_type('simple')) {
                $button_text = __('Add to Cart', 'amaley-discovery-engine');
                $button_url = $product->add_to_cart_url();
                $button_classes .= ' add_to_cart_button ajax_add_to_cart';
                $button_attrs .= ' data-product_id="' . esc_attr($product->get_id()) . '" data-product_sku="' . esc_attr($product->get_sku()) . '" aria-label="' . esc_attr($product->add_to_cart_description()) . '" rel="nofollow"';
            } elseif ($product->is_type('variable')) {
                $button_text = __('View Options', 'amaley-discovery-engine');
            } elseif (!$product->is_in_stock()) {
                $button_text = __('View', 'amaley-discovery-engine');
            }

            ob_start();
            ?>
            <article class="amaley-native-product-card-v1" data-ade-native-card="marketplace">
                <a class="amaley-native-product-card-v1__image-wrap" href="<?php echo esc_url($link); ?>" aria-label="<?php echo esc_attr($title); ?>">
                    <?php if (!empty($badge_text)) : ?>
                        <span class="amaley-native-product-card-v1__badge"><?php echo esc_html($badge_text); ?></span>
                    <?php endif; ?>
                    <img class="amaley-native-product-card-v1__image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
                </a>

                <div class="amaley-native-product-card-v1__body">
                    <?php if (!empty($meta_text)) : ?>
                        <div class="amaley-native-product-card-v1__meta"><?php echo esc_html($meta_text); ?></div>
                    <?php endif; ?>

                    <h3 class="amaley-native-product-card-v1__title">
                        <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
                    </h3>

                    <div class="amaley-native-product-card-v1__rating" aria-label="<?php echo esc_attr(sprintf(__('Rated %s out of 5', 'amaley-discovery-engine'), $average_rating)); ?>">
                        <span class="amaley-native-product-card-v1__stars"><?php echo esc_html($this->rating_stars($average_rating)); ?></span>
                        <?php if ($rating_count > 0) : ?>
                            <span class="amaley-native-product-card-v1__rating-count">(<?php echo esc_html(number_format_i18n($rating_count)); ?>)</span>
                        <?php endif; ?>
                    </div>

                    <div class="amaley-native-product-card-v1__price"><?php echo wp_kses_post($price); ?></div>

                    <a class="<?php echo esc_attr($button_classes); ?>" href="<?php echo esc_url($button_url); ?>"<?php echo $button_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html($button_text); ?></a>

                    <div class="amaley-native-product-card-v1__progress" aria-hidden="true">
                        <span class="amaley-native-product-card-v1__progress-bar" style="width: <?php echo esc_attr($progress_percent); ?>%;"></span>
                    </div>

                    <div class="amaley-native-product-card-v1__stock-row">
                        <span><?php echo esc_html__('Available:', 'amaley-discovery-engine'); ?> <?php echo esc_html($available_label !== '' ? number_format_i18n((int) $available_label) : '—'); ?></span>
                        <span><?php echo esc_html__('Already Sold:', 'amaley-discovery-engine'); ?> <?php echo esc_html(number_format_i18n($sold_label)); ?></span>
                    </div>
                </div>
            </article>
            <?php
            return ob_get_clean();
        }

        /**
         * Build simple star string for the native marketplace card.
         *
         * @param float $rating Average rating.
         * @return string
         */
        private function rating_stars($rating) {
            $rating = max(0, min(5, (float) $rating));
            $rounded = (int) round($rating);
            if ($rounded < 1) {
                $rounded = 5;
            }
            return str_repeat('★', $rounded) . str_repeat('☆', 5 - $rounded);
        }

        private function render_product_card($post) {
            $product = function_exists('wc_get_product') ? wc_get_product($post->ID) : null;
            if (!$product) {
                return '';
            }

            $title = get_the_title($post);
            $link = get_permalink($post);
            $image = get_the_post_thumbnail_url($post, 'large');
            if (!$image) {
                $image = wc_placeholder_img_src('large');
            }
            $terms = get_the_terms($post->ID, 'product_cat');
            $category = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : __('Amaley Product', 'amaley-discovery-engine');
            $stock_status = $product->is_in_stock() ? __('In Stock', 'amaley-discovery-engine') : __('Out of Stock', 'amaley-discovery-engine');
            $price = $product->get_price_html();

            ob_start();
            ?>
            <article class="amaley-discovery-engine-v1__card amaley-discovery-engine-v1__product-card">
                <a class="amaley-discovery-engine-v1__image-link" href="<?php echo esc_url($link); ?>">
                    <span class="amaley-discovery-engine-v1__badge"><?php echo esc_html($category); ?></span>
                    <img class="amaley-discovery-engine-v1__image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
                </a>
                <div class="amaley-discovery-engine-v1__card-body">
                    <div class="amaley-discovery-engine-v1__meta"><?php echo esc_html($stock_status); ?></div>
                    <h3 class="amaley-discovery-engine-v1__card-title"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h3>
                    <div class="amaley-discovery-engine-v1__card-footer">
                        <div class="amaley-discovery-engine-v1__price"><?php echo wp_kses_post($price); ?></div>
                        <a class="amaley-discovery-engine-v1__button" href="<?php echo esc_url($link); ?>"><?php esc_html_e('View', 'amaley-discovery-engine'); ?></a>
                    </div>
                </div>
            </article>
            <?php
            return ob_get_clean();
        }

        private function render_generic_card($post, $settings) {
            $title = get_the_title($post);
            $link = get_permalink($post);
            $image = get_the_post_thumbnail_url($post, 'large');
            if (!$image) {
                $image = AMALEY_DE_URL . 'assets/css/placeholder.svg';
            }
            $type_label = ucfirst(str_replace('_', ' ', $settings['type']));
            $taxonomy = !empty($settings['taxonomy']) ? $settings['taxonomy'] : '';
            if ($taxonomy && taxonomy_exists($taxonomy)) {
                $terms = get_the_terms($post->ID, $taxonomy);
                if (!is_wp_error($terms) && !empty($terms)) {
                    $type_label = $terms[0]->name;
                }
            }
            $excerpt = has_excerpt($post) ? get_the_excerpt($post) : wp_trim_words(wp_strip_all_tags($post->post_content), 18);

            ob_start();
            ?>
            <article class="amaley-discovery-engine-v1__card amaley-discovery-engine-v1__generic-card">
                <a class="amaley-discovery-engine-v1__image-link" href="<?php echo esc_url($link); ?>">
                    <span class="amaley-discovery-engine-v1__badge"><?php echo esc_html($type_label); ?></span>
                    <img class="amaley-discovery-engine-v1__image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
                </a>
                <div class="amaley-discovery-engine-v1__card-body">
                    <div class="amaley-discovery-engine-v1__meta"><?php echo esc_html($type_label); ?></div>
                    <h3 class="amaley-discovery-engine-v1__card-title"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h3>
                    <?php if ($excerpt) : ?>
                        <p class="amaley-discovery-engine-v1__excerpt"><?php echo esc_html($excerpt); ?></p>
                    <?php endif; ?>
                    <div class="amaley-discovery-engine-v1__card-footer">
                        <a class="amaley-discovery-engine-v1__button" href="<?php echo esc_url($link); ?>"><?php esc_html_e('Explore', 'amaley-discovery-engine'); ?></a>
                    </div>
                </div>
            </article>
            <?php
            return ob_get_clean();
        }

        private function render_filters($settings) {
            $filters = $settings['filters'];
            ob_start();
            ?>
            <form class="amaley-discovery-engine-v1__filters" data-ade-form method="get">
                <div class="amaley-discovery-engine-v1__filter-drawer-head">
                    <div class="amaley-discovery-engine-v1__filter-heading"><?php echo esc_html($settings['filter_drawer_title']); ?></div>
                    <button type="button" class="amaley-discovery-engine-v1__drawer-close" data-ade-close-filter aria-label="<?php esc_attr_e('Close filters', 'amaley-discovery-engine'); ?>">&times;</button>
                </div>

                <?php if ('yes' === $settings['show_filter_panel_title']) : ?>
                    <div class="amaley-discovery-engine-v1__filter-panel-head">
                        <?php if (!empty($settings['filter_panel_kicker'])) : ?>
                            <div class="amaley-discovery-engine-v1__filter-panel-kicker"><?php echo esc_html($settings['filter_panel_kicker']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($settings['filter_panel_title'])) : ?>
                            <div class="amaley-discovery-engine-v1__filter-panel-title"><?php echo esc_html($settings['filter_panel_title']); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_search']) : ?>
                    <label class="amaley-discovery-engine-v1__field">
                        <span class="amaley-discovery-engine-v1__field-label"><?php echo esc_html($settings['search_label']); ?></span>
                        <input type="search" name="ade_search" value="<?php echo esc_attr($filters['search']); ?>" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>">
                    </label>
                <?php endif; ?>

                <?php if ('products' === $settings['type'] && 'yes' === $settings['show_categories']) : ?>
                    <?php echo $this->render_term_select('product_cat', 'ade_category', $settings['category_label'], $filters['category'], $settings['include_product_categories'], $settings['exclude_product_categories'], $settings['all_option_text']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php elseif ('products' !== $settings['type'] && 'yes' === $settings['show_categories']) : ?>
                    <?php $tax = !empty($settings['taxonomy']) ? $settings['taxonomy'] : $this->default_taxonomy_for_type($settings['type']); ?>
                    <?php if ($tax && taxonomy_exists($tax)) : ?>
                        <?php echo $this->render_term_select($tax, 'ade_category', $settings['category_label'], $filters['category'], '', '', $settings['all_option_text']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ('products' === $settings['type'] && 'yes' === $settings['show_tags']) : ?>
                    <?php echo $this->render_term_select('product_tag', 'ade_tag', $settings['tag_label'], $filters['tag'], $settings['include_product_tags'], $settings['exclude_product_tags'], $settings['all_option_text']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php endif; ?>

                <?php if ('products' === $settings['type']) : ?>
                    <?php foreach ($this->attribute_definitions() as $attr_key => $definition) : ?>
                        <?php $setting_key = 'show_attr_' . $attr_key; ?>
                        <?php if ('yes' === ($settings[$setting_key] ?? 'no') && taxonomy_exists($definition['taxonomy'])) : ?>
                            <?php $custom_attr_label_key = $attr_key . '_label'; ?>
                            <?php $attr_label = !empty($settings[$custom_attr_label_key]) ? $settings[$custom_attr_label_key] : $definition['label']; ?>
                            <?php echo $this->render_term_select($definition['taxonomy'], 'ade_attr_' . $attr_key, $attr_label, $filters['attrs'][$attr_key] ?? '', $settings['include_attr_' . $attr_key] ?? '', $settings['exclude_attr_' . $attr_key] ?? '', $settings['all_option_text']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ('products' === $settings['type'] && 'yes' === $settings['show_price']) : ?>
                    <div class="amaley-discovery-engine-v1__field amaley-discovery-engine-v1__price-fields">
                        <span class="amaley-discovery-engine-v1__field-label"><?php echo esc_html($settings['price_label']); ?></span>
                        <div class="amaley-discovery-engine-v1__price-row">
                            <input type="number" name="ade_min_price" min="0" step="1" value="<?php echo esc_attr($filters['min_price']); ?>" placeholder="<?php echo esc_attr($settings['min_price_placeholder']); ?>">
                            <input type="number" name="ade_max_price" min="0" step="1" value="<?php echo esc_attr($filters['max_price']); ?>" placeholder="<?php echo esc_attr($settings['max_price_placeholder']); ?>">
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ('products' === $settings['type'] && 'yes' === $settings['show_stock']) : ?>
                    <label class="amaley-discovery-engine-v1__field">
                        <span class="amaley-discovery-engine-v1__field-label"><?php echo esc_html($settings['stock_label']); ?></span>
                        <select name="ade_stock">
                            <option value=""><?php echo esc_html($settings['stock_any_label']); ?></option>
                            <option value="instock" <?php selected($filters['stock'], 'instock'); ?>><?php echo esc_html($settings['stock_in_label']); ?></option>
                            <option value="outofstock" <?php selected($filters['stock'], 'outofstock'); ?>><?php echo esc_html($settings['stock_out_label']); ?></option>
                        </select>
                    </label>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_sort']) : ?>
                    <label class="amaley-discovery-engine-v1__field">
                        <span class="amaley-discovery-engine-v1__field-label"><?php echo esc_html($settings['sort_label']); ?></span>
                        <select name="ade_sort">
                            <option value="latest" <?php selected($filters['sort'], 'latest'); ?>><?php esc_html_e('Latest', 'amaley-discovery-engine'); ?></option>
                            <?php if ('products' === $settings['type']) : ?>
                                <option value="price_low" <?php selected($filters['sort'], 'price_low'); ?>><?php esc_html_e('Price: Low to High', 'amaley-discovery-engine'); ?></option>
                                <option value="price_high" <?php selected($filters['sort'], 'price_high'); ?>><?php esc_html_e('Price: High to Low', 'amaley-discovery-engine'); ?></option>
                                <option value="popular" <?php selected($filters['sort'], 'popular'); ?>><?php esc_html_e('Popular', 'amaley-discovery-engine'); ?></option>
                                <option value="featured" <?php selected($filters['sort'], 'featured'); ?>><?php esc_html_e('Featured', 'amaley-discovery-engine'); ?></option>
                            <?php endif; ?>
                            <option value="title" <?php selected($filters['sort'], 'title'); ?>><?php esc_html_e('A to Z', 'amaley-discovery-engine'); ?></option>
                        </select>
                    </label>
                <?php endif; ?>

                <?php if ('yes' !== $settings['show_sort']) : ?>
                    <input type="hidden" name="ade_sort" value="<?php echo esc_attr($filters['sort']); ?>" data-ade-hidden-sort>
                <?php endif; ?>

                <input type="hidden" name="ade_page" value="1" data-ade-page-field>

                <div class="amaley-discovery-engine-v1__filter-actions">
                    <button type="submit" class="amaley-discovery-engine-v1__apply"><?php echo esc_html($settings['apply_button_text']); ?></button>
                    <button type="button" class="amaley-discovery-engine-v1__reset" data-ade-reset><?php echo esc_html($settings['reset_button_text']); ?></button>
                </div>

                <?php echo $this->render_sidebar_cta($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </form>
            <div class="amaley-discovery-engine-v1__drawer-backdrop" data-ade-backdrop></div>
            <?php
            return ob_get_clean();
        }

        /**
         * Optional sidebar promotional CTA shown below filter actions.
         * Scoped and controlled from Elementor; disabled by default.
         *
         * @param array $settings Normalized settings.
         * @return string
         */
        private function render_sidebar_cta($settings) {
            if ('yes' !== ($settings['show_sidebar_cta'] ?? 'no')) {
                return '';
            }

            $url = !empty($settings['sidebar_cta_button_url']) ? $settings['sidebar_cta_button_url'] : '#';
            $classes = array('amaley-discovery-engine-v1__sidebar-cta');
            if ('yes' !== ($settings['show_sidebar_cta_desktop'] ?? 'yes')) {
                $classes[] = 'amaley-discovery-engine-v1__sidebar-cta--hide-desktop';
            }
            if ('yes' !== ($settings['show_sidebar_cta_tablet'] ?? 'no')) {
                $classes[] = 'amaley-discovery-engine-v1__sidebar-cta--hide-tablet';
            }
            if ('yes' !== ($settings['show_sidebar_cta_mobile'] ?? 'no')) {
                $classes[] = 'amaley-discovery-engine-v1__sidebar-cta--hide-mobile';
            }
            ob_start();
            ?>
            <aside class="<?php echo esc_attr(implode(' ', $classes)); ?>" aria-label="<?php echo esc_attr($settings['sidebar_cta_title']); ?>">
                <?php if (!empty($settings['sidebar_cta_kicker'])) : ?>
                    <div class="amaley-discovery-engine-v1__sidebar-cta-kicker"><?php echo esc_html($settings['sidebar_cta_kicker']); ?></div>
                <?php endif; ?>
                <?php if (!empty($settings['sidebar_cta_title'])) : ?>
                    <div class="amaley-discovery-engine-v1__sidebar-cta-title"><?php echo esc_html($settings['sidebar_cta_title']); ?></div>
                <?php endif; ?>
                <?php if (!empty($settings['sidebar_cta_text'])) : ?>
                    <div class="amaley-discovery-engine-v1__sidebar-cta-text"><?php echo wp_kses_post($settings['sidebar_cta_text']); ?></div>
                <?php endif; ?>
                <?php if (!empty($settings['sidebar_cta_button_text'])) : ?>
                    <a class="amaley-discovery-engine-v1__sidebar-cta-button" href="<?php echo esc_url($url); ?>"><?php echo esc_html($settings['sidebar_cta_button_text']); ?></a>
                <?php endif; ?>
            </aside>
            <?php
            return ob_get_clean();
        }

        private function render_term_select($taxonomy, $name, $label, $selected, $include_slugs = '', $exclude_slugs = '', $all_label = '') {
            if (!taxonomy_exists($taxonomy)) {
                return '';
            }

            $include = $this->csv_to_slugs($include_slugs);
            $exclude = $this->csv_to_slugs($exclude_slugs);
            $term_args = array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
            );
            if (!empty($include)) {
                $term_args['slug'] = $include;
            }
            if (!empty($exclude)) {
                $excluded_term_ids = get_terms(array(
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                    'fields'     => 'ids',
                    'slug'       => $exclude,
                ));
                if (!is_wp_error($excluded_term_ids) && !empty($excluded_term_ids)) {
                    $term_args['exclude'] = array_map('absint', $excluded_term_ids);
                }
            }

            $terms = get_terms($term_args);
            if (is_wp_error($terms)) {
                return '';
            }

            ob_start();
            ?>
            <label class="amaley-discovery-engine-v1__field">
                <span class="amaley-discovery-engine-v1__field-label"><?php echo esc_html($label); ?></span>
                <select name="<?php echo esc_attr($name); ?>">
                    <option value=""><?php echo esc_html($all_label ? $all_label : __('All', 'amaley-discovery-engine')); ?></option>
                    <?php foreach ($terms as $term) : ?>
                        <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($selected, $term->slug); ?>><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php
            return ob_get_clean();
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

        private function render_active_chips($filters, $settings = array()) {
            $chips = array();
            $chip_labels = array(
                'search'    => $settings['search_label'] ?? __('Search', 'amaley-discovery-engine'),
                'category'  => $settings['category_label'] ?? __('Category', 'amaley-discovery-engine'),
                'tag'       => $settings['tag_label'] ?? __('Tag', 'amaley-discovery-engine'),
                'stock'     => $settings['stock_label'] ?? __('Stock', 'amaley-discovery-engine'),
                'min_price' => $settings['price_label'] ?? __('Price Range', 'amaley-discovery-engine'),
                'max_price' => $settings['price_label'] ?? __('Price Range', 'amaley-discovery-engine'),
            );
            foreach (array('search', 'category', 'tag', 'stock', 'min_price', 'max_price') as $key) {
                if (isset($filters[$key]) && '' !== $filters[$key]) {
                    $chips[] = ($chip_labels[$key] ?? ucfirst(str_replace('_', ' ', $key))) . ': ' . $filters[$key];
                }
            }
            if (!empty($filters['attrs']) && is_array($filters['attrs'])) {
                foreach ($this->attribute_definitions() as $attr_key => $definition) {
                    if (!empty($filters['attrs'][$attr_key])) {
                        $custom_attr_label_key = $attr_key . '_label';
                        $attr_label = !empty($settings[$custom_attr_label_key]) ? $settings[$custom_attr_label_key] : $definition['label'];
                        $chips[] = $attr_label . ': ' . $filters['attrs'][$attr_key];
                    }
                }
            }
            if (empty($chips)) {
                return '';
            }
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__chips">
                <?php foreach ($chips as $chip) : ?>
                    <span class="amaley-discovery-engine-v1__chip"><?php echo esc_html($chip); ?></span>
                <?php endforeach; ?>
            </div>
            <?php
            return ob_get_clean();
        }

        private function render_pagination($result, $settings) {
            if ('none' === $settings['pagination_type'] || $result['pages'] < 2) {
                return '';
            }

            ob_start();
            ?>
            <nav class="amaley-discovery-engine-v1__pagination" aria-label="<?php esc_attr_e('Pagination', 'amaley-discovery-engine'); ?>">
                <?php for ($i = 1; $i <= $result['pages']; $i++) : ?>
                    <a href="<?php echo esc_url(add_query_arg('ade_page', $i)); ?>" class="amaley-discovery-engine-v1__page-link <?php echo $i === (int) $result['current'] ? 'is-active' : ''; ?>" data-ade-page="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></a>
                <?php endfor; ?>
            </nav>
            <?php
            return ob_get_clean();
        }

        /**
         * Product attribute filters approved for Amaley collection/shop discovery.
         * Taxonomy names map WooCommerce attributes from Products → Attributes.
         *
         * @return array
         */
        private function attribute_definitions() {
            return array(
                'collection_type' => array(
                    'label'    => __('Collection Type', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_collection-type',
                ),
                'core_ingredient' => array(
                    'label'    => __('Core Ingredient', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_ingredient',
                ),
                'cluster' => array(
                    'label'    => __('Cluster', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_cluster',
                ),
                'producer_maker' => array(
                    'label'    => __('Producer / Maker', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_producer-maker',
                ),
                'region_cluster' => array(
                    'label'    => __('Source Belt / Region Cluster', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_region-cluster',
                ),
                'shg' => array(
                    'label'    => __('SHG / Producer Group', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_shg',
                ),
                'use_case' => array(
                    'label'    => __('Use Case', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_use-case',
                ),
                'village_source_location' => array(
                    'label'    => __('Village / Source Location', 'amaley-discovery-engine'),
                    'taxonomy' => 'pa_village-source-location',
                ),
            );
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
