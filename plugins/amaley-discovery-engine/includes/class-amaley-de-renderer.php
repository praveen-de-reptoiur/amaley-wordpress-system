<?php
/**
 * Frontend renderer for Amaley Discovery Engine.
 *
 * v1.3.6 fixes card rendering at source level: product grid, AJAX filtering,
 * sorting and pagination now all use the same selected renderer path.
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

        public function render_results_only($settings = array()) {
            $settings = $this->normalize_settings($settings);
            return array('html' => $this->render_results_html($settings));
        }

        public function normalize_settings($settings) {
            $global = Amaley_DE_Settings::get();
            $defaults = array(
                'type' => 'products',
                'use_global_preset' => 'no',
                'global_preset_key' => '',
                'heading' => 'Our Products',
                'kicker' => 'Shop Amaley',
                'per_page' => 9,
                'columns_desktop' => 3,
                'columns_tablet' => 2,
                'columns_mobile' => 1,
                'filter_position' => 'left',
                'desktop_filter_position' => '',
                'tablet_filter_position' => '',
                'mobile_filter_position' => '',
                'desktop_filter_mode' => 'visible',
                'tablet_filter_mode' => 'drawer',
                'mobile_filter_mode' => 'drawer',
                'show_mobile_result_count' => 'yes',
                'show_mobile_quick_pills' => 'yes',
                'show_mobile_sort' => 'yes',
                'show_mobile_active_chips' => 'yes',
                'show_result_count_desktop' => 'yes',
                'show_result_count_tablet' => 'yes',
                'show_result_count_mobile' => 'yes',
                'mobile_toolbar_layout' => 'filter_sort',
                'mobile_quick_pills_limit' => 8,
                'full_bleed' => 'yes',
                'inner_width' => 'none',
                'pagination_type' => 'numbers',
                'show_search' => 'yes',
                'show_categories' => 'yes',
                'show_price' => 'yes',
                'show_tags' => 'yes',
                'show_stock' => 'yes',
                'show_attr_cluster' => 'no',
                'show_attr_collection_type' => 'no',
                'show_attr_core_ingredient' => 'no',
                'show_attr_producer_maker' => 'no',
                'show_attr_region_cluster' => 'no',
                'show_attr_shg' => 'no',
                'show_attr_use_case' => 'no',
                'show_attr_village_source_location' => 'no',
                'show_sort' => 'yes',
                'show_active_chips' => 'yes',
                'default_filter_mode' => 'all',
                'default_category' => '',
                'default_tag' => '',
                'default_attr_collection_type' => '',
                'default_attr_core_ingredient' => '',
                'default_attr_cluster' => '',
                'default_attr_producer_maker' => '',
                'default_attr_region_cluster' => '',
                'default_attr_shg' => '',
                'default_attr_use_case' => '',
                'default_attr_village_source_location' => '',
                'include_product_ids' => '',
                'exclude_product_ids' => '',
                'include_product_categories' => '',
                'exclude_product_categories' => '',
                'include_product_tags' => '',
                'exclude_product_tags' => '',
                'include_attr_collection_type' => '',
                'exclude_attr_collection_type' => '',
                'include_attr_core_ingredient' => '',
                'exclude_attr_core_ingredient' => '',
                'include_attr_cluster' => '',
                'exclude_attr_cluster' => '',
                'include_attr_producer_maker' => '',
                'exclude_attr_producer_maker' => '',
                'include_attr_region_cluster' => '',
                'exclude_attr_region_cluster' => '',
                'include_attr_shg' => '',
                'exclude_attr_shg' => '',
                'include_attr_use_case' => '',
                'exclude_attr_use_case' => '',
                'include_attr_village_source_location' => '',
                'exclude_attr_village_source_location' => '',
                'default_sort' => 'latest',
                'post_type' => '',
                'taxonomy' => '',
                'relation_meta_key' => '',
                'relation_meta_value' => '',
                'heading_color' => $global['primary_color'],
                'heading_accent_color' => $global['rust_color'],
                'kicker_color' => $global['gold_color'],
                'section_bg_color' => $global['ivory_color'],
                'card_bg_color' => $global['cream_color'],
                'filter_bg_color' => $global['cream_color'],
                'text_color' => $global['primary_color'],
                'muted_color' => '#7A573F',
                'primary_color' => $global['primary_color'],
                'gold_color' => $global['gold_color'],
                'rust_color' => $global['rust_color'],
                'heading_font' => $global['heading_font'],
                'body_font' => $global['body_font'],
                'section_padding_top' => 76,
                'section_padding_top_tablet' => 66,
                'section_padding_top_mobile' => 56,
                'section_padding_bottom' => 84,
                'section_padding_bottom_tablet' => 74,
                'section_padding_bottom_mobile' => 68,
                'card_radius' => 22,
                'card_radius_tablet' => 20,
                'card_radius_mobile' => 18,
                'image_height' => 250,
                'image_height_tablet' => 230,
                'image_height_mobile' => 260,
                'heading_size' => 76,
                'heading_size_tablet' => 58,
                'heading_size_mobile' => 44,
                'kicker_size' => 11,
                'card_title_size' => 25,
                'card_title_size_mobile' => 23,
                'body_text_size' => 13,
                'price_color' => $global['primary_color'],
                'price_font_size' => 15,
                'button_bg_color' => $global['primary_color'],
                'button_text_color' => '#FFF8EA',
                'button_hover_bg_color' => $global['gold_color'],
                'button_hover_text_color' => $global['primary_color'],
                'pagination_bg_color' => '#FFFFFF',
                'pagination_active_bg' => $global['primary_color'],
                'pagination_active_text' => '#FFF8EA',
                'drawer_bg_color' => $global['cream_color'],
                'filters' => array(),
                'custom_wrapper_class' => '',
                'sidebar_width' => 290,
                'sidebar_min_width' => 260,
                'sidebar_sticky_top' => 96,
                'topbar_field_min_width' => 150,
                'filter_actions_gap' => 10,
                'card_min_width' => 240,
                'grid_gap' => 30,
                'card_renderer' => 'amaley_core_product_card',
                'elementor_template_id' => 0,
                'amaley_core_product_card_template' => 'og_product_card_1',
                'marketplace_badge_text' => 'Bestseller',
                'marketplace_meta_text' => 'Amaley Collection',
                'mobile_filter_button_text' => 'Filter',
                'filter_drawer_title' => 'Filters',
                'apply_button_text' => 'Apply Filters',
                'reset_button_text' => 'Clear All',
                'show_filter_panel_title' => 'no',
                'filter_panel_kicker' => 'Refine Selection',
                'filter_panel_title' => 'Filters',
                'all_option_text' => 'All',
                'search_label' => 'Search',
                'search_placeholder' => 'Search here...',
                'category_label' => 'Category',
                'tag_label' => 'Tag',
                'collection_type_label' => 'Collection Type',
                'core_ingredient_label' => 'Core Ingredient',
                'cluster_label' => 'Cluster',
                'producer_maker_label' => 'Producer / Maker',
                'region_cluster_label' => 'Source Belt / Region Cluster',
                'shg_label' => 'SHG / Producer Group',
                'use_case_label' => 'Use Case',
                'village_source_location_label' => 'Village / Source Location',
                'price_label' => 'Price Range',
                'min_price_placeholder' => 'Min',
                'max_price_placeholder' => 'Max',
                'stock_label' => 'Stock',
                'stock_any_label' => 'Any stock status',
                'stock_in_label' => 'In stock',
                'stock_out_label' => 'Out of stock',
                'sort_label' => 'Sort',
                'show_sidebar_cta' => 'no',
                'show_sidebar_cta_desktop' => 'yes',
                'show_sidebar_cta_tablet' => 'no',
                'show_sidebar_cta_mobile' => 'no',
                'sidebar_cta_kicker' => 'Collection Builder',
                'sidebar_cta_title' => 'Choose Collection Paths',
                'sidebar_cta_text' => 'Buying for teams, properties, events, guest hampers, or store counters? Start with bulk enquiry and Amaley can recommend the right collection by budget, audience, and purpose.',
                'sidebar_cta_button_text' => 'Curate Hamper',
                'sidebar_cta_button_url' => '',
                'sidebar_cta_bg_color' => '#4A1806',
                'sidebar_cta_text_color' => '#FFF8EA',
                'sidebar_cta_accent_color' => '#C2880A',
                'sidebar_cta_button_bg_color' => '#C2880A',
                'sidebar_cta_button_text_color' => '#2E1203',
                'result_count_singular' => '{count} result found',
                'result_count_plural' => '{count} results found',
                'empty_state_title' => 'No results found.',
                'empty_state_text' => 'Try clearing one filter or explore all Amaley discoveries.',
                // Controls kept compatible with earlier card-control patch, now handled natively here.
                'amaley_dcrsf_show_image' => 'yes',
                'amaley_dcrsf_show_label' => 'yes',
                'amaley_dcrsf_label_text' => '',
                'amaley_dcrsf_show_title' => 'yes',
                'amaley_dcrsf_show_excerpt' => 'yes',
                'amaley_dcrsf_excerpt_words' => 16,
                'amaley_dcrsf_show_meta' => 'yes',
                'amaley_dcrsf_show_tags' => 'yes',
                'amaley_dcrsf_show_button' => 'yes',
                'amaley_dcrsf_button_text' => 'View Product',
            );

            if (!empty($settings['use_global_preset']) && 'yes' === $settings['use_global_preset'] && !empty($settings['global_preset_key']) && class_exists('Amaley_DE_Settings')) {
                $requested_type = !empty($settings['type']) ? sanitize_key($settings['type']) : '';
                $preset_settings = Amaley_DE_Settings::get_preset_settings($settings['global_preset_key'], $requested_type);
                if (!empty($preset_settings)) {
                    $settings = array_merge($settings, $preset_settings);
                    if (!empty($requested_type)) { $settings['type'] = $requested_type; }
                }
            }

            $settings = wp_parse_args(is_array($settings) ? $settings : array(), $defaults);
            $settings['type'] = sanitize_key($settings['type']);
            $settings['use_global_preset'] = ('yes' === $settings['use_global_preset']) ? 'yes' : 'no';
            $settings['global_preset_key'] = sanitize_key($settings['global_preset_key']);

            $filter_modes = array('visible', 'drawer', 'compact');
            foreach (array('desktop_filter_mode' => 'visible', 'tablet_filter_mode' => 'drawer', 'mobile_filter_mode' => 'drawer') as $mode_key => $fallback_mode) {
                if (!empty($settings[$mode_key]) && 'inline' === $settings[$mode_key]) { $settings[$mode_key] = 'visible'; }
                $settings[$mode_key] = in_array($settings[$mode_key], $filter_modes, true) ? $settings[$mode_key] : $fallback_mode;
            }
            $filter_positions = array('left', 'top');
            $settings['filter_position'] = in_array($settings['filter_position'], $filter_positions, true) ? $settings['filter_position'] : 'left';
            foreach (array('desktop_filter_position' => $settings['filter_position'], 'tablet_filter_position' => 'top', 'mobile_filter_position' => 'top') as $position_key => $position_fallback) {
                if (empty($settings[$position_key])) { $settings[$position_key] = $position_fallback; }
                $settings[$position_key] = in_array($settings[$position_key], $filter_positions, true) ? $settings[$position_key] : $position_fallback;
            }

            foreach (array('show_mobile_result_count','show_mobile_quick_pills','show_mobile_sort','show_mobile_active_chips','show_result_count_desktop','show_result_count_tablet','show_result_count_mobile','show_search','show_categories','show_price','show_tags','show_stock','show_sort','show_active_chips','show_attr_cluster','show_attr_collection_type','show_attr_core_ingredient','show_attr_producer_maker','show_attr_region_cluster','show_attr_shg','show_attr_use_case','show_attr_village_source_location','show_sidebar_cta','show_sidebar_cta_desktop','show_sidebar_cta_tablet','show_sidebar_cta_mobile','show_filter_panel_title','amaley_dcrsf_show_image','amaley_dcrsf_show_label','amaley_dcrsf_show_title','amaley_dcrsf_show_excerpt','amaley_dcrsf_show_meta','amaley_dcrsf_show_tags','amaley_dcrsf_show_button') as $switch_key) {
                $settings[$switch_key] = ('yes' === ($settings[$switch_key] ?? 'yes')) ? 'yes' : 'no';
            }

            $settings['mobile_toolbar_layout'] = in_array($settings['mobile_toolbar_layout'], array('filter_sort', 'filter_only', 'sort_only'), true) ? $settings['mobile_toolbar_layout'] : 'filter_sort';
            $settings['mobile_quick_pills_limit'] = max(0, min(20, absint($settings['mobile_quick_pills_limit'])));
            $settings['per_page'] = max(1, min(96, absint($settings['per_page'])));
            $settings['columns_desktop'] = max(1, min(6, absint($settings['columns_desktop'])));
            $settings['columns_tablet'] = max(1, min(4, absint($settings['columns_tablet'])));
            $settings['columns_mobile'] = max(1, min(2, absint($settings['columns_mobile'])));
            foreach (array('section_padding_top','section_padding_top_tablet','section_padding_top_mobile','section_padding_bottom','section_padding_bottom_tablet','section_padding_bottom_mobile','card_radius','card_radius_tablet','card_radius_mobile','image_height','image_height_tablet','image_height_mobile','heading_size','heading_size_tablet','heading_size_mobile','kicker_size','card_title_size','card_title_size_mobile','body_text_size','price_font_size','sidebar_width','sidebar_min_width','sidebar_sticky_top','topbar_field_min_width','filter_actions_gap','card_min_width','grid_gap','amaley_dcrsf_excerpt_words') as $numeric_key) {
                $settings[$numeric_key] = isset($settings[$numeric_key]) ? absint($settings[$numeric_key]) : 0;
            }
            foreach (array('heading_color','heading_accent_color','kicker_color','section_bg_color','card_bg_color','filter_bg_color','text_color','muted_color','primary_color','gold_color','rust_color','price_color','button_bg_color','button_text_color','button_hover_bg_color','button_hover_text_color','pagination_bg_color','pagination_active_bg','pagination_active_text','drawer_bg_color','sidebar_cta_bg_color','sidebar_cta_text_color','sidebar_cta_accent_color','sidebar_cta_button_bg_color','sidebar_cta_button_text_color') as $color_key) {
                if (!empty($settings[$color_key])) {
                    $clean_color = sanitize_hex_color($settings[$color_key]);
                    if ($clean_color) { $settings[$color_key] = $clean_color; }
                }
            }
            $settings['custom_wrapper_class'] = sanitize_html_class($settings['custom_wrapper_class']);
            $settings['card_renderer'] = $this->normalize_card_renderer($settings['card_renderer']);
            $settings['elementor_template_id'] = max(0, absint($settings['elementor_template_id']));
            $settings['amaley_core_product_card_template'] = sanitize_key($settings['amaley_core_product_card_template']);
            if (!$settings['amaley_core_product_card_template']) { $settings['amaley_core_product_card_template'] = 'og_product_card_1'; }
            foreach (array('marketplace_badge_text','marketplace_meta_text','mobile_filter_button_text','filter_drawer_title','apply_button_text','reset_button_text','sidebar_cta_kicker','sidebar_cta_title','sidebar_cta_button_text','result_count_singular','result_count_plural','empty_state_title','empty_state_text','amaley_dcrsf_label_text','amaley_dcrsf_button_text') as $text_key) {
                $settings[$text_key] = sanitize_text_field($settings[$text_key]);
            }
            $settings['sidebar_cta_text'] = wp_kses_post($settings['sidebar_cta_text']);
            $settings['sidebar_cta_button_url'] = esc_url_raw($settings['sidebar_cta_button_url']);
            return $settings;
        }

        private function normalize_card_renderer($value) {
            $value = sanitize_key($value);
            $core_aliases = array('amaley_core_product_card','amaley_core_product_card_direct','amaley_core_select','core_product_card','amaley_core_card','amaley_core');
            if (in_array($value, $core_aliases, true)) {
                return 'amaley_core_product_card';
            }
            if (in_array($value, array('default','marketplace_card','elementor_template'), true)) {
                return $value;
            }
            return 'amaley_core_product_card';
        }

        private function public_settings($settings) {
            $allowed = array('type','use_global_preset','global_preset_key','per_page','columns_desktop','columns_tablet','columns_mobile','filter_position','desktop_filter_position','tablet_filter_position','mobile_filter_position','desktop_filter_mode','tablet_filter_mode','mobile_filter_mode','show_mobile_result_count','show_mobile_quick_pills','show_mobile_sort','show_mobile_active_chips','show_result_count_desktop','show_result_count_tablet','show_result_count_mobile','mobile_toolbar_layout','mobile_quick_pills_limit','full_bleed','inner_width','pagination_type','show_search','show_categories','show_price','show_tags','show_stock','show_attr_cluster','show_attr_collection_type','show_attr_core_ingredient','show_attr_producer_maker','show_attr_region_cluster','show_attr_shg','show_attr_use_case','show_attr_village_source_location','show_sort','show_active_chips','default_filter_mode','default_category','default_tag','default_attr_collection_type','default_attr_core_ingredient','default_attr_cluster','default_attr_producer_maker','default_attr_region_cluster','default_attr_shg','default_attr_use_case','default_attr_village_source_location','include_product_ids','exclude_product_ids','include_product_categories','exclude_product_categories','include_product_tags','exclude_product_tags','include_attr_collection_type','exclude_attr_collection_type','include_attr_core_ingredient','exclude_attr_core_ingredient','include_attr_cluster','exclude_attr_cluster','include_attr_producer_maker','exclude_attr_producer_maker','include_attr_region_cluster','exclude_attr_region_cluster','include_attr_shg','exclude_attr_shg','include_attr_use_case','exclude_attr_use_case','include_attr_village_source_location','exclude_attr_village_source_location','default_sort','post_type','taxonomy','relation_meta_key','relation_meta_value','heading','kicker','heading_color','heading_accent_color','kicker_color','section_bg_color','card_bg_color','filter_bg_color','text_color','muted_color','primary_color','gold_color','rust_color','heading_font','body_font','section_padding_top','section_padding_top_tablet','section_padding_top_mobile','section_padding_bottom','section_padding_bottom_tablet','section_padding_bottom_mobile','card_radius','card_radius_tablet','card_radius_mobile','image_height','image_height_tablet','image_height_mobile','heading_size','heading_size_tablet','heading_size_mobile','kicker_size','card_title_size','card_title_size_mobile','body_text_size','price_color','price_font_size','button_bg_color','button_text_color','button_hover_bg_color','button_hover_text_color','pagination_bg_color','pagination_active_bg','pagination_active_text','drawer_bg_color','custom_wrapper_class','sidebar_width','sidebar_min_width','sidebar_sticky_top','topbar_field_min_width','filter_actions_gap','card_min_width','grid_gap','card_renderer','elementor_template_id','amaley_core_product_card_template','marketplace_badge_text','marketplace_meta_text','mobile_filter_button_text','filter_drawer_title','apply_button_text','reset_button_text','show_filter_panel_title','filter_panel_kicker','filter_panel_title','all_option_text','search_label','search_placeholder','category_label','tag_label','collection_type_label','core_ingredient_label','cluster_label','producer_maker_label','region_cluster_label','shg_label','use_case_label','village_source_location_label','price_label','min_price_placeholder','max_price_placeholder','stock_label','stock_any_label','stock_in_label','stock_out_label','sort_label','show_sidebar_cta','show_sidebar_cta_desktop','show_sidebar_cta_tablet','show_sidebar_cta_mobile','sidebar_cta_kicker','sidebar_cta_title','sidebar_cta_text','sidebar_cta_button_text','sidebar_cta_button_url','sidebar_cta_bg_color','sidebar_cta_text_color','sidebar_cta_accent_color','sidebar_cta_button_bg_color','sidebar_cta_button_text_color','result_count_singular','result_count_plural','empty_state_title','empty_state_text','amaley_dcrsf_show_image','amaley_dcrsf_show_label','amaley_dcrsf_label_text','amaley_dcrsf_show_title','amaley_dcrsf_show_excerpt','amaley_dcrsf_excerpt_words','amaley_dcrsf_show_meta','amaley_dcrsf_show_tags','amaley_dcrsf_show_button','amaley_dcrsf_button_text');
            return array_intersect_key($settings, array_flip($allowed));
        }

        private function current_filters($settings) {
            $provided = isset($settings['filters']) && is_array($settings['filters']) ? $settings['filters'] : array();
            $filters = array(
                'search' => sanitize_text_field($provided['search'] ?? (isset($_GET['ade_search']) ? wp_unslash($_GET['ade_search']) : '')),
                'category' => $this->request_value_or_default($settings, $provided, 'category', 'ade_category', $settings['default_category'] ?? '', 'product_cat', $settings['include_product_categories'] ?? '', $settings['exclude_product_categories'] ?? ''),
                'tag' => $this->request_value_or_default($settings, $provided, 'tag', 'ade_tag', $settings['default_tag'] ?? '', 'product_tag', $settings['include_product_tags'] ?? '', $settings['exclude_product_tags'] ?? ''),
                'stock' => sanitize_text_field($provided['stock'] ?? (isset($_GET['ade_stock']) ? wp_unslash($_GET['ade_stock']) : '')),
                'min_price' => isset($provided['min_price']) ? $provided['min_price'] : (isset($_GET['ade_min_price']) ? wp_unslash($_GET['ade_min_price']) : ''),
                'max_price' => isset($provided['max_price']) ? $provided['max_price'] : (isset($_GET['ade_max_price']) ? wp_unslash($_GET['ade_max_price']) : ''),
                'sort' => sanitize_text_field($provided['sort'] ?? (isset($_GET['ade_sort']) ? wp_unslash($_GET['ade_sort']) : ($settings['default_sort'] ?? 'latest'))),
                'page' => max(1, absint($provided['page'] ?? (isset($_GET['ade_page']) ? wp_unslash($_GET['ade_page']) : 1))),
                'attrs' => array(),
            );
            foreach ($this->attribute_definitions() as $attr_key => $definition) {
                $provided_has_attr = isset($provided['attrs']) && is_array($provided['attrs']) && array_key_exists($attr_key, $provided['attrs']);
                $get_key = 'ade_attr_' . $attr_key;
                if ($provided_has_attr) {
                    $filters['attrs'][$attr_key] = sanitize_text_field($provided['attrs'][$attr_key]);
                } elseif (isset($_GET[$get_key])) {
                    $filters['attrs'][$attr_key] = sanitize_text_field(wp_unslash($_GET[$get_key]));
                } else {
                    $filters['attrs'][$attr_key] = $this->default_filter_value($settings['default_attr_' . $attr_key] ?? '', $definition['taxonomy'], $settings['include_attr_' . $attr_key] ?? '', $settings['exclude_attr_' . $attr_key] ?? '');
                }
            }
            return $filters;
        }

        private function request_value_or_default($settings, $provided, $filter_key, $get_key, $default, $taxonomy, $include = '', $exclude = '') {
            if (array_key_exists($filter_key, $provided)) { return sanitize_text_field($provided[$filter_key]); }
            if (isset($_GET[$get_key])) { return sanitize_text_field(wp_unslash($_GET[$get_key])); }
            return $this->default_filter_value($default, $taxonomy, $include, $exclude);
        }

        private function default_filter_value($default, $taxonomy, $include = '', $exclude = '') {
            if (empty($default)) { return ''; }
            $value = is_array($default) ? reset($default) : $default;
            $slug = sanitize_title($value);
            if (!$slug || !$taxonomy || !taxonomy_exists($taxonomy)) { return $slug; }
            $include_slugs = $this->csv_to_slugs($include);
            $exclude_slugs = $this->csv_to_slugs($exclude);
            if (!empty($include_slugs) && !in_array($slug, $include_slugs, true)) { return ''; }
            if (!empty($exclude_slugs) && in_array($slug, $exclude_slugs, true)) { return ''; }
            return $slug;
        }

        private function style_vars($settings) {
            $vars = array(
                '--ade-section-bg' => $settings['section_bg_color'], '--ade-card-bg' => $settings['card_bg_color'], '--ade-filter-bg' => $settings['filter_bg_color'], '--ade-text' => $settings['text_color'], '--ade-muted' => $settings['muted_color'], '--ade-primary' => $settings['primary_color'], '--ade-gold' => $settings['gold_color'], '--ade-rust' => $settings['rust_color'], '--ade-price' => $settings['price_color'], '--ade-button-bg' => $settings['button_bg_color'], '--ade-button-text' => $settings['button_text_color'], '--ade-button-hover-bg' => $settings['button_hover_bg_color'], '--ade-button-hover-text' => $settings['button_hover_text_color'], '--ade-pagination-bg' => $settings['pagination_bg_color'], '--ade-pagination-active-bg' => $settings['pagination_active_bg'], '--ade-pagination-active-text' => $settings['pagination_active_text'], '--ade-drawer-bg' => $settings['drawer_bg_color'], '--ade-sidebar-width' => absint($settings['sidebar_width']) . 'px', '--ade-sidebar-min-width' => absint($settings['sidebar_min_width']) . 'px', '--ade-sidebar-sticky-top' => absint($settings['sidebar_sticky_top']) . 'px', '--ade-topbar-field-min-width' => absint($settings['topbar_field_min_width']) . 'px', '--ade-filter-actions-gap' => absint($settings['filter_actions_gap']) . 'px', '--ade-card-min-width' => absint($settings['card_min_width']) . 'px', '--ade-grid-gap' => absint($settings['grid_gap']) . 'px', '--ade-card-radius' => absint($settings['card_radius']) . 'px', '--ade-image-height' => absint($settings['image_height']) . 'px', '--ade-columns-desktop' => absint($settings['columns_desktop']), '--ade-columns-tablet' => absint($settings['columns_tablet']), '--ade-columns-mobile' => absint($settings['columns_mobile'])
            );
            $out = array();
            foreach ($vars as $key => $value) { $out[] = $key . ':' . $value; }
            return implode(';', $out);
        }

        private function render_instance_filter_mode_css($instance_id, $settings) {
            $id = '#' . sanitize_html_class($instance_id);
            $css = $this->desktop_laptop_filter_position_css($id, $settings);
            $css .= '@media(min-width:881px){' . $this->device_filter_css($id, $settings['desktop_filter_mode'], 'desktop', $settings['desktop_filter_position']) . '}';
            $css .= '@media(min-width:621px) and (max-width:880px){' . $this->device_filter_css($id, $settings['tablet_filter_mode'], 'tablet', $settings['tablet_filter_position']) . '}';
            $css .= '@media(max-width:620px){' . $this->device_filter_css($id, $settings['mobile_filter_mode'], 'mobile', $settings['mobile_filter_position']) . '}';
            return '<style id="' . esc_attr($instance_id) . '-filter-css">' . $css . '</style>';
        }

        private function desktop_laptop_filter_position_css($id, $settings) {
            $base = $id . '.amaley-discovery-engine-v1';
            if ('visible' !== ($settings['desktop_filter_mode'] ?? 'visible')) { return ''; }
            if ('left' === ($settings['desktop_filter_position'] ?? 'left')) {
                return $base . ' .amaley-discovery-engine-v1__mobile-bar{display:none!important;}' . $base . ' .amaley-discovery-engine-v1__result-head{display:flex!important;}' . $base . ' .amaley-discovery-engine-v1__layout{display:grid!important;grid-template-columns:minmax(var(--ade-sidebar-min-width,260px),var(--ade-sidebar-width,290px)) minmax(0,1fr)!important;gap:var(--ade-grid-gap,30px)!important;align-items:start!important;width:100%!important;min-width:0!important;}' . $base . ' .amaley-discovery-engine-v1__filters{display:flex!important;flex-direction:column!important;position:sticky!important;top:var(--ade-sidebar-sticky-top,96px)!important;width:100%!important;max-width:100%!important;align-self:start!important;justify-self:stretch!important;inset:auto!important;transform:none!important;translate:none!important;height:auto!important;max-height:none!important;overflow:visible!important;}';
            }
            return $base . ' .amaley-discovery-engine-v1__mobile-bar{display:none!important;}' . $base . ' .amaley-discovery-engine-v1__layout{display:grid!important;grid-template-columns:1fr!important;gap:var(--ade-grid-gap,30px)!important;}';
        }

        private function device_filter_css($id, $mode, $device, $position = 'top') {
            $base = $id . '.amaley-discovery-engine-v1';
            $css = '';
            if ('drawer' === $mode || 'compact' === $mode) {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-bar{display:flex!important;flex-direction:column!important;align-items:flex-start!important;gap:14px!important;width:100%!important;margin:0 0 22px!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__result-head{display:none!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:1fr!important;gap:24px!important;}';
            } else {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-bar{display:none!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__result-head{display:flex!important;}';
            }
            if ('drawer' === $mode) {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-filter-button{display:inline-flex!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__filters{display:flex!important;position:fixed!important;top:0!important;right:0!important;bottom:0!important;left:auto!important;transform:translateX(105%)!important;width:min(390px,92vw)!important;max-width:92vw!important;height:auto!important;max-height:100dvh!important;overflow:auto!important;z-index:99999!important;border-radius:22px 0 0 22px!important;background:var(--ade-drawer-bg,var(--ade-filter-bg,#FFF8EA))!important;}';
                $css .= $base . '.is-filter-open .amaley-discovery-engine-v1__filters{transform:translateX(0)!important;}';
                $css .= $base . '.is-filter-open .amaley-discovery-engine-v1__drawer-backdrop{display:block!important;}';
            } elseif ('compact' === $mode) {
                $css .= $base . ' .amaley-discovery-engine-v1__mobile-filter-button{display:none!important;}';
                $css .= $base . ' .amaley-discovery-engine-v1__filters{display:none!important;}';
            } elseif ('visible' === $mode) {
                if ('desktop' === $device && 'left' === $position) {
                    $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:minmax(var(--ade-sidebar-min-width,260px),var(--ade-sidebar-width,290px)) minmax(0,1fr)!important;gap:var(--ade-grid-gap,30px)!important;}';
                } else {
                    $css .= $base . ' .amaley-discovery-engine-v1__layout{grid-template-columns:1fr!important;gap:24px!important;}';
                    $css .= $base . ' .amaley-discovery-engine-v1__filters{display:grid!important;grid-template-columns:repeat(auto-fit,minmax(var(--ade-topbar-field-min-width,150px),1fr))!important;}';
                }
            }
            return $css;
        }

        private function render_mobile_experience_bar($settings) {
            $result = (!empty($settings['preloaded_result']) && is_array($settings['preloaded_result'])) ? $settings['preloaded_result'] : array('total' => 0);
            $filters = isset($settings['filters']) && is_array($settings['filters']) ? $settings['filters'] : $this->current_filters($settings);
            $show_filter_button = in_array($settings['mobile_toolbar_layout'], array('filter_sort','filter_only'), true);
            $show_sort_toolbar = ('yes' === $settings['show_mobile_sort'] && in_array($settings['mobile_toolbar_layout'], array('filter_sort','sort_only'), true));
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__mobile-bar" data-ade-mobile-bar>
                <?php if ('yes' === $settings['show_mobile_result_count']) : ?>
                    <div class="amaley-discovery-engine-v1__mobile-count" data-ade-mobile-count><?php echo esc_html(str_replace('{count}', number_format_i18n((int) $result['total']), (1 === (int) $result['total']) ? $settings['result_count_singular'] : $settings['result_count_plural'])); ?></div>
                <?php endif; ?>
                <?php if ('yes' === $settings['show_mobile_quick_pills'] && $settings['mobile_quick_pills_limit'] > 0) : echo $this->render_mobile_quick_pills($settings, $filters); endif; // phpcs:ignore ?>
                <?php if ($show_filter_button || $show_sort_toolbar) : ?>
                    <div class="amaley-discovery-engine-v1__mobile-toolbar">
                        <?php if ($show_filter_button) : ?><button type="button" class="amaley-discovery-engine-v1__mobile-filter-button" data-ade-open-filter><?php echo esc_html($settings['mobile_filter_button_text']); ?></button><?php endif; ?>
                        <?php if ($show_sort_toolbar) : echo $this->render_sort_selector($settings, $filters, 'mobile'); endif; // phpcs:ignore ?>
                    </div>
                <?php endif; ?>
                <?php if ('yes' === $settings['show_mobile_active_chips']) : ?><div class="amaley-discovery-engine-v1__mobile-chips" data-ade-mobile-chips></div><?php endif; ?>
            </div>
            <?php
            return ob_get_clean();
        }

        private function render_mobile_quick_pills($settings, $filters) {
            $taxonomy = ('products' === $settings['type']) ? 'product_cat' : (!empty($settings['taxonomy']) ? $settings['taxonomy'] : '');
            if (!$taxonomy || !taxonomy_exists($taxonomy)) { return ''; }
            $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => true, 'number' => absint($settings['mobile_quick_pills_limit'])));
            if (is_wp_error($terms)) { return ''; }
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__quick-pills" data-ade-quick-pills>
                <button type="button" class="amaley-discovery-engine-v1__quick-pill <?php echo empty($filters['category']) ? 'is-active' : ''; ?>" data-ade-quick-category=""><?php echo esc_html($settings['all_option_text']); ?></button>
                <?php foreach ($terms as $term) : ?>
                    <button type="button" class="amaley-discovery-engine-v1__quick-pill <?php echo ($filters['category'] === $term->slug) ? 'is-active' : ''; ?>" data-ade-quick-category="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
                <?php endforeach; ?>
            </div>
            <?php
            return ob_get_clean();
        }

        private function render_heading($settings) {
            $heading = wp_kses_post($settings['heading']);
            $heading = str_replace(array('{','}'), array('<span>','</span>'), $heading);
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__heading-wrap">
                <?php if (!empty($settings['kicker'])) : ?><div class="amaley-discovery-engine-v1__kicker"><?php echo esc_html($settings['kicker']); ?></div><?php endif; ?>
                <?php if (!empty($heading)) : ?><h2 class="amaley-discovery-engine-v1__heading"><?php echo wp_kses($heading, array('span'=>array())); ?></h2><?php endif; ?>
            </div>
            <?php
            return ob_get_clean();
        }

        private function render_results_html($settings) {
            $filters = $this->current_filters($settings);
            $settings['filters'] = $filters;
            if (!empty($settings['preloaded_result']) && is_array($settings['preloaded_result'])) { $result = $settings['preloaded_result']; unset($settings['preloaded_result']); } else { $result = $this->query->run($settings, $filters); }
            ob_start();
            ?>
            <div class="amaley-discovery-engine-v1__result-head">
                <div class="amaley-discovery-engine-v1__result-count" data-ade-count><?php echo esc_html(str_replace('{count}', number_format_i18n($result['total']), (1 === (int) $result['total']) ? $settings['result_count_singular'] : $settings['result_count_plural'])); ?></div>
                <div class="amaley-discovery-engine-v1__result-actions">
                    <?php if ('yes' === $settings['show_active_chips']) : echo $this->render_active_chips($filters, $settings); endif; // phpcs:ignore ?>
                    <?php if ('yes' === ($settings['show_mobile_sort'] ?? 'no')) : echo $this->render_sort_selector($settings, $filters, 'desktop'); endif; // phpcs:ignore ?>
                </div>
            </div>
            <?php if (!empty($result['items'])) : ?>
                <div class="amaley-discovery-engine-v1__grid" data-ade-grid>
                    <?php foreach ($result['items'] as $post) : echo $this->render_item_card($post, $settings); endforeach; // phpcs:ignore ?>
                </div>
            <?php else : ?>
                <div class="amaley-discovery-engine-v1__empty"><h3><?php echo esc_html($settings['empty_state_title']); ?></h3><p><?php echo esc_html($settings['empty_state_text']); ?></p></div>
            <?php endif; ?>
            <?php echo $this->render_pagination($result, $settings); // phpcs:ignore ?>
            <?php
            return ob_get_clean();
        }

        private function render_item_card($post, $settings) {
            if ('products' === $settings['type']) {
                if ('marketplace_card' === $settings['card_renderer']) {
                    return $this->render_marketplace_product_card($post, $settings);
                }
                if ('elementor_template' === $settings['card_renderer'] && !empty($settings['elementor_template_id'])) {
                    $template_output = $this->render_elementor_template_card($post, $settings);
                    if ('' !== $template_output) { return $template_output; }
                }
                if ('amaley_core_product_card' === $settings['card_renderer']) {
                    $core_output = $this->render_core_product_card($post, $settings);
                    if ('' !== $core_output) { return $core_output; }
                }
                return $this->render_product_card($post);
            }
            return $this->render_generic_card($post, $settings);
        }

        private function render_core_product_card($post, $settings) {
            if (!is_a($post, 'WP_Post') || !class_exists('Amaley_Core_Card_Renderer') || !method_exists('Amaley_Core_Card_Renderer', 'render_product')) {
                return '';
            }
            $args = array(
                'preset' => $settings['amaley_core_product_card_template'],
                'show_image' => 'yes' === $settings['amaley_dcrsf_show_image'],
                'show_label' => 'yes' === $settings['amaley_dcrsf_show_label'],
                'show_title' => 'yes' === $settings['amaley_dcrsf_show_title'],
                'show_excerpt' => 'yes' === $settings['amaley_dcrsf_show_excerpt'],
                'show_meta' => 'yes' === $settings['amaley_dcrsf_show_meta'],
                'show_tags' => 'yes' === $settings['amaley_dcrsf_show_tags'],
                'show_button' => 'yes' === $settings['amaley_dcrsf_show_button'],
                'button_text' => !empty($settings['amaley_dcrsf_button_text']) ? $settings['amaley_dcrsf_button_text'] : 'View Product',
                'label_text' => !empty($settings['amaley_dcrsf_label_text']) ? $settings['amaley_dcrsf_label_text'] : 'Product',
                'excerpt_words' => max(6, min(40, absint($settings['amaley_dcrsf_excerpt_words']))),
                'class' => 'amaley-de-core-product-card',
            );
            $args = apply_filters('amaley_de_core_product_card_args', $args, $post->ID, $settings);
            try { $html = Amaley_Core_Card_Renderer::render_product($post->ID, $args); } catch (Throwable $e) { $html = ''; } catch (Exception $e) { $html = ''; }
            if ('' === trim((string) $html)) { return ''; }
            return '<div class="amaley-dcrsf-core-card-wrap amaley-de-core-card-wrap" data-amaley-de-product-id="' . esc_attr($post->ID) . '">' . $html . '</div>';
        }

        private function render_elementor_template_card($post, $settings) {
            $template_id = absint($settings['elementor_template_id']);
            if (!$template_id || !is_a($post, 'WP_Post') || !did_action('elementor/loaded') || !class_exists('\\Elementor\\Plugin')) { return ''; }
            $template_post = get_post($template_id);
            if (!$template_post || !in_array($template_post->post_type, array('elementor_library','e-landing-page'), true)) { return ''; }
            $old_post = $GLOBALS['post'] ?? null;
            $old_product = $GLOBALS['product'] ?? null;
            $GLOBALS['post'] = $post; setup_postdata($post);
            if ('product' === $post->post_type && function_exists('wc_get_product')) { $GLOBALS['product'] = wc_get_product($post->ID); }
            if (class_exists('\\Elementor\\Core\\Files\\CSS\\Post')) { try { $css_file = new \Elementor\Core\Files\CSS\Post($template_id); $css_file->enqueue(); } catch (Throwable $e) {} catch (Exception $e) {} }
            $content = '';
            try { $content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, true); } catch (Throwable $e) { $content = ''; } catch (Exception $e) { $content = ''; }
            if ($old_post) { $GLOBALS['post'] = $old_post; setup_postdata($old_post); } else { wp_reset_postdata(); }
            $GLOBALS['product'] = $old_product;
            return '' === trim((string)$content) ? '' : '<article class="amaley-discovery-engine-v1__template-card" data-ade-template-card="' . esc_attr($template_id) . '">' . $content . '</article>';
        }

        private function render_marketplace_product_card($post, $settings) {
            $product = function_exists('wc_get_product') ? wc_get_product($post->ID) : null;
            if (!$product) { return ''; }
            $title = get_the_title($post); $link = get_permalink($post); $image = get_the_post_thumbnail_url($post, 'large');
            if (!$image && function_exists('wc_placeholder_img_src')) { $image = wc_placeholder_img_src('large'); }
            $price = $product->get_price_html();
            $button_text = __('View', 'amaley-discovery-engine'); $button_url = $link; $button_classes = 'amaley-native-product-card-v1__button'; $button_attrs = '';
            if ($product->is_purchasable() && $product->is_in_stock() && $product->is_type('simple')) { $button_text = __('Add to Cart', 'amaley-discovery-engine'); $button_url = $product->add_to_cart_url(); $button_classes .= ' add_to_cart_button ajax_add_to_cart'; $button_attrs .= ' data-product_id="' . esc_attr($product->get_id()) . '" data-product_sku="' . esc_attr($product->get_sku()) . '" aria-label="' . esc_attr($product->add_to_cart_description()) . '" rel="nofollow"'; }
            ob_start();
            ?>
            <article class="amaley-native-product-card-v1" data-ade-native-card="marketplace">
                <a class="amaley-native-product-card-v1__image-wrap" href="<?php echo esc_url($link); ?>"><span class="amaley-native-product-card-v1__badge"><?php echo esc_html($settings['marketplace_badge_text']); ?></span><img class="amaley-native-product-card-v1__image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy"></a>
                <div class="amaley-native-product-card-v1__body"><div class="amaley-native-product-card-v1__meta"><?php echo esc_html($settings['marketplace_meta_text']); ?></div><h3 class="amaley-native-product-card-v1__title"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h3><div class="amaley-native-product-card-v1__price"><?php echo wp_kses_post($price); ?></div><a class="<?php echo esc_attr($button_classes); ?>" href="<?php echo esc_url($button_url); ?>"<?php echo $button_attrs; // phpcs:ignore ?>><?php echo esc_html($button_text); ?></a></div>
            </article>
            <?php return ob_get_clean();
        }

        private function render_product_card($post) {
            $product = function_exists('wc_get_product') ? wc_get_product($post->ID) : null;
            if (!$product) { return ''; }
            $title = get_the_title($post); $link = get_permalink($post); $image = get_the_post_thumbnail_url($post, 'large');
            if (!$image && function_exists('wc_placeholder_img_src')) { $image = wc_placeholder_img_src('large'); }
            $terms = get_the_terms($post->ID, 'product_cat'); $category = (!is_wp_error($terms) && !empty($terms)) ? $terms[0]->name : __('Amaley Product', 'amaley-discovery-engine');
            $stock_status = $product->is_in_stock() ? __('In Stock', 'amaley-discovery-engine') : __('Out of Stock', 'amaley-discovery-engine'); $price = $product->get_price_html();
            ob_start(); ?>
            <article class="amaley-discovery-engine-v1__card amaley-discovery-engine-v1__product-card"><a class="amaley-discovery-engine-v1__image-link" href="<?php echo esc_url($link); ?>"><span class="amaley-discovery-engine-v1__badge"><?php echo esc_html($category); ?></span><img class="amaley-discovery-engine-v1__image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy"></a><div class="amaley-discovery-engine-v1__card-body"><div class="amaley-discovery-engine-v1__meta"><?php echo esc_html($stock_status); ?></div><h3 class="amaley-discovery-engine-v1__card-title"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h3><div class="amaley-discovery-engine-v1__card-footer"><div class="amaley-discovery-engine-v1__price"><?php echo wp_kses_post($price); ?></div><a class="amaley-discovery-engine-v1__button" href="<?php echo esc_url($link); ?>"><?php esc_html_e('View', 'amaley-discovery-engine'); ?></a></div></div></article>
            <?php return ob_get_clean();
        }

        private function render_generic_card($post, $settings) {
            $title = get_the_title($post); $link = get_permalink($post); $image = get_the_post_thumbnail_url($post, 'large');
            if (!$image) { $image = AMALEY_DE_URL . 'assets/css/placeholder.svg'; }
            $type_label = ucfirst(str_replace('_', ' ', $settings['type']));
            $taxonomy = !empty($settings['taxonomy']) ? $settings['taxonomy'] : '';
            if ($taxonomy && taxonomy_exists($taxonomy)) { $terms = get_the_terms($post->ID, $taxonomy); if (!is_wp_error($terms) && !empty($terms)) { $type_label = $terms[0]->name; } }
            $excerpt = has_excerpt($post) ? get_the_excerpt($post) : wp_trim_words(wp_strip_all_tags($post->post_content), 18);
            ob_start(); ?>
            <article class="amaley-discovery-engine-v1__card amaley-discovery-engine-v1__generic-card"><a class="amaley-discovery-engine-v1__image-link" href="<?php echo esc_url($link); ?>"><span class="amaley-discovery-engine-v1__badge"><?php echo esc_html($type_label); ?></span><img class="amaley-discovery-engine-v1__image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy"></a><div class="amaley-discovery-engine-v1__card-body"><div class="amaley-discovery-engine-v1__meta"><?php echo esc_html($type_label); ?></div><h3 class="amaley-discovery-engine-v1__card-title"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h3><?php if ($excerpt) : ?><p class="amaley-discovery-engine-v1__excerpt"><?php echo esc_html($excerpt); ?></p><?php endif; ?><div class="amaley-discovery-engine-v1__card-footer"><a class="amaley-discovery-engine-v1__button" href="<?php echo esc_url($link); ?>"><?php esc_html_e('Explore', 'amaley-discovery-engine'); ?></a></div></div></article>
            <?php return ob_get_clean();
        }

        private function render_filters($settings) {
            $filters = $settings['filters'];
            ob_start(); ?>
            <form class="amaley-discovery-engine-v1__filters" data-ade-form method="get">
                <div class="amaley-discovery-engine-v1__filter-drawer-head"><strong><?php echo esc_html($settings['filter_drawer_title']); ?></strong><button type="button" data-ade-close-filter aria-label="Close">×</button></div>
                <?php if ('yes' === $settings['show_filter_panel_title']) : ?><div class="amaley-discovery-engine-v1__filter-panel-title"><small><?php echo esc_html($settings['filter_panel_kicker']); ?></small><strong><?php echo esc_html($settings['filter_panel_title']); ?></strong></div><?php endif; ?>
                <input type="hidden" name="ade_page" value="<?php echo esc_attr($filters['page']); ?>" data-ade-page-field>
                <?php if ('yes' === $settings['show_search']) : ?><label class="amaley-discovery-engine-v1__field"><span><?php echo esc_html($settings['search_label']); ?></span><input type="search" name="ade_search" value="<?php echo esc_attr($filters['search']); ?>" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>"></label><?php endif; ?>
                <?php if ('yes' === $settings['show_categories']) : echo $this->render_term_select('ade_category', 'product_cat', $settings['category_label'], $filters['category'], $settings); endif; // phpcs:ignore ?>
                <?php if ('yes' === $settings['show_tags']) : echo $this->render_term_select('ade_tag', 'product_tag', $settings['tag_label'], $filters['tag'], $settings); endif; // phpcs:ignore ?>
                <?php foreach ($this->attribute_definitions() as $attr_key => $definition) : if ('yes' === ($settings['show_attr_' . $attr_key] ?? 'no')) { echo $this->render_term_select('ade_attr_' . $attr_key, $definition['taxonomy'], $settings[$definition['label_key']], $filters['attrs'][$attr_key] ?? '', $settings); } endforeach; // phpcs:ignore ?>
                <?php if ('yes' === $settings['show_price']) : ?><div class="amaley-discovery-engine-v1__price-fields"><label class="amaley-discovery-engine-v1__field"><span><?php echo esc_html($settings['price_label']); ?></span><input type="number" min="0" step="1" name="ade_min_price" value="<?php echo esc_attr($filters['min_price']); ?>" placeholder="<?php echo esc_attr($settings['min_price_placeholder']); ?>"></label><label class="amaley-discovery-engine-v1__field"><span>&nbsp;</span><input type="number" min="0" step="1" name="ade_max_price" value="<?php echo esc_attr($filters['max_price']); ?>" placeholder="<?php echo esc_attr($settings['max_price_placeholder']); ?>"></label></div><?php endif; ?>
                <?php if ('yes' === $settings['show_stock']) : ?><label class="amaley-discovery-engine-v1__field"><span><?php echo esc_html($settings['stock_label']); ?></span><select name="ade_stock"><option value=""><?php echo esc_html($settings['stock_any_label']); ?></option><option value="instock" <?php selected($filters['stock'], 'instock'); ?>><?php echo esc_html($settings['stock_in_label']); ?></option><option value="outofstock" <?php selected($filters['stock'], 'outofstock'); ?>><?php echo esc_html($settings['stock_out_label']); ?></option></select></label><?php endif; ?>
                <?php if ('yes' === $settings['show_sort']) : echo $this->render_sort_selector($settings, $filters, 'form'); endif; // phpcs:ignore ?>
                <div class="amaley-discovery-engine-v1__filter-actions"><button class="amaley-discovery-engine-v1__apply" type="submit"><?php echo esc_html($settings['apply_button_text']); ?></button><button class="amaley-discovery-engine-v1__reset" type="button" data-ade-reset><?php echo esc_html($settings['reset_button_text']); ?></button></div>
                <div class="amaley-discovery-engine-v1__drawer-backdrop" data-ade-backdrop></div>
            </form>
            <?php return ob_get_clean();
        }

        private function render_term_select($name, $taxonomy, $label, $current, $settings) {
            if (!$taxonomy || !taxonomy_exists($taxonomy)) { return ''; }
            $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => true));
            if (is_wp_error($terms)) { return ''; }
            ob_start(); ?>
            <label class="amaley-discovery-engine-v1__field"><span><?php echo esc_html($label); ?></span><select name="<?php echo esc_attr($name); ?>"><option value=""><?php echo esc_html($settings['all_option_text']); ?></option><?php foreach ($terms as $term) : ?><option value="<?php echo esc_attr($term->slug); ?>" <?php selected($current, $term->slug); ?>><?php echo esc_html($term->name); ?></option><?php endforeach; ?></select></label>
            <?php return ob_get_clean();
        }

        private function render_sort_selector($settings, $filters, $context = 'form') {
            $name = ('mobile' === $context) ? '' : ' name="ade_sort"'; $data = ('mobile' === $context) ? ' data-ade-mobile-sort' : ''; $class = 'amaley-discovery-engine-v1__sort-select';
            ob_start(); ?>
            <label class="amaley-discovery-engine-v1__field amaley-discovery-engine-v1__sort-field"><span><?php echo esc_html($settings['sort_label']); ?></span><select class="<?php echo esc_attr($class); ?>"<?php echo $name . $data; // phpcs:ignore ?>><option value="latest" <?php selected($filters['sort'], 'latest'); ?>><?php esc_html_e('Latest', 'amaley-discovery-engine'); ?></option><option value="price_low" <?php selected($filters['sort'], 'price_low'); ?>><?php esc_html_e('Price low-high', 'amaley-discovery-engine'); ?></option><option value="price_high" <?php selected($filters['sort'], 'price_high'); ?>><?php esc_html_e('Price high-low', 'amaley-discovery-engine'); ?></option><option value="popular" <?php selected($filters['sort'], 'popular'); ?>><?php esc_html_e('Popular', 'amaley-discovery-engine'); ?></option><option value="featured" <?php selected($filters['sort'], 'featured'); ?>><?php esc_html_e('Featured', 'amaley-discovery-engine'); ?></option><option value="title" <?php selected($filters['sort'], 'title'); ?>><?php esc_html_e('A to Z', 'amaley-discovery-engine'); ?></option></select></label>
            <?php return ob_get_clean();
        }

        private function render_active_chips($filters, $settings) {
            $chips = array();
            if (!empty($filters['search'])) { $chips[] = sprintf(__('Search: %s', 'amaley-discovery-engine'), $filters['search']); }
            if (!empty($filters['category'])) { $chips[] = $this->term_name('product_cat', $filters['category']); }
            if (!empty($filters['tag'])) { $chips[] = $this->term_name('product_tag', $filters['tag']); }
            foreach ($this->attribute_definitions() as $attr_key => $definition) { if (!empty($filters['attrs'][$attr_key])) { $chips[] = $this->term_name($definition['taxonomy'], $filters['attrs'][$attr_key]); } }
            if (empty($chips)) { return ''; }
            $out = '<div class="amaley-discovery-engine-v1__chips">'; foreach ($chips as $chip) { $out .= '<span class="amaley-discovery-engine-v1__chip">' . esc_html($chip) . '</span>'; } $out .= '</div>'; return $out;
        }

        private function render_pagination($result, $settings) {
            $pages = max(0, absint($result['pages'] ?? 0)); $current = max(1, absint($result['current'] ?? 1));
            if ($pages <= 1 || 'none' === ($settings['pagination_type'] ?? 'numbers')) { return ''; }
            $out = '<nav class="amaley-discovery-engine-v1__pagination" aria-label="' . esc_attr__('Product pagination', 'amaley-discovery-engine') . '">';
            for ($i = 1; $i <= $pages; $i++) { $class = $i === $current ? ' is-active' : ''; $out .= '<a href="#" class="amaley-discovery-engine-v1__page-link' . esc_attr($class) . '" data-ade-page="' . esc_attr($i) . '">' . esc_html($i) . '</a>'; }
            $out .= '</nav>'; return $out;
        }

        private function term_name($taxonomy, $slug) { $term = get_term_by('slug', $slug, $taxonomy); return ($term && !is_wp_error($term)) ? $term->name : $slug; }
        private function csv_to_slugs($value) { $raw = is_array($value) ? $value : preg_split('/[,\n]+/', (string)$value); $slugs = array(); foreach ((array)$raw as $item) { $slug = sanitize_title($item); if ('' !== $slug) { $slugs[] = $slug; } } return array_values(array_unique($slugs)); }
        private function attribute_definitions() { return array('cluster'=>array('taxonomy'=>'pa_cluster','label_key'=>'cluster_label'), 'collection_type'=>array('taxonomy'=>'pa_collection-type','label_key'=>'collection_type_label'), 'core_ingredient'=>array('taxonomy'=>'pa_ingredient','label_key'=>'core_ingredient_label'), 'producer_maker'=>array('taxonomy'=>'pa_producer-maker','label_key'=>'producer_maker_label'), 'region_cluster'=>array('taxonomy'=>'pa_region-cluster','label_key'=>'region_cluster_label'), 'shg'=>array('taxonomy'=>'pa_shg','label_key'=>'shg_label'), 'use_case'=>array('taxonomy'=>'pa_use-case','label_key'=>'use_case_label'), 'village_source_location'=>array('taxonomy'=>'pa_village-source-location','label_key'=>'village_source_location_label')); }
    }
}
