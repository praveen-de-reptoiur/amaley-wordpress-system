<?php
/**
 * Collection-focused product filter widget.
 *
 * v1.5.4: Mobile drawer responsive polish and Elementor editor drawer initialization fix.
 * - No parent generic style sections are registered for this widget.
 * - Controls are grouped section-wise with tabs to avoid duplicate/unclear panels.
 * - Rendering still uses the existing Discovery renderer and Amaley Core OG Product Card 1.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amaley_DE_Elementor_Collection_Product_Filter_Widget') && class_exists('Amaley_DE_Elementor_Base_Widget')) {
    class Amaley_DE_Elementor_Collection_Product_Filter_Widget extends Amaley_DE_Elementor_Base_Widget {
        public function get_name() { return 'amaley_de_collection_product_filter'; }
        public function get_title() { return __('Amaley Collection Product Filter', 'amaley-discovery-engine'); }
        public function get_icon() { return 'eicon-products'; }
        public function get_keywords() { return array('amaley', 'collection', 'product', 'filter', 'shop', 'drawer', 'og card'); }

        protected function get_discovery_type() { return 'products'; }
        protected function get_default_heading() { return 'Discover by {Collections}'; }
        protected function get_default_kicker() { return 'Shop by purpose'; }
        protected function get_default_filter_position() { return 'left'; }
        protected function get_default_desktop_filter_position() { return 'left'; }
        protected function get_default_tablet_filter_mode() { return 'drawer'; }
        protected function get_default_mobile_filter_mode() { return 'drawer'; }
        protected function get_default_custom_wrapper_class() { return 'amaley-collection-product-filter-v145'; }

        protected function register_controls() {
            $this->register_content_controls_clean();
            $this->register_style_controls_clean();
            $this->register_device_visibility_controls_clean();
        }

        private function register_content_controls_clean() {
            $this->start_controls_section('acf_heading_content', array(
                'label' => __('Heading Content', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ));
            $this->add_control('kicker', array(
                'label' => __('Small Label / Kicker', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => $this->get_default_kicker(),
                'label_block' => true,
            ));
            $this->add_control('heading', array(
                'label' => __('Main Heading', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => $this->get_default_heading(),
                'label_block' => true,
                'description' => __('Use {word} for rust italic accent. Example: Discover by {Collections}', 'amaley-discovery-engine'),
            ));
            $this->end_controls_section();

            $this->start_controls_section('acf_query_filters', array(
                'label' => __('Query & Filters', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ));
            $this->add_control('per_page', array(
                'label' => __('Cards Per Page', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 9,
                'min' => 1,
                'max' => 96,
            ));
            $this->add_control('default_sort', array(
                'label' => __('Default Sort', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'latest',
                'options' => array(
                    'latest' => __('Latest', 'amaley-discovery-engine'),
                    'title' => __('A to Z', 'amaley-discovery-engine'),
                    'price_low' => __('Price low-high', 'amaley-discovery-engine'),
                    'price_high' => __('Price high-low', 'amaley-discovery-engine'),
                    'popular' => __('Popular', 'amaley-discovery-engine'),
                    'featured' => __('Featured', 'amaley-discovery-engine'),
                ),
            ));
            $this->add_control('acf_filter_core_heading', array(
                'label' => __('Filter Fields', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ));
            $this->add_control('show_search', $this->switcher(__('Search', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_categories', $this->switcher(__('Category', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_tags', $this->switcher(__('Tag', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_attr_cluster', $this->switcher(__('Cluster', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_attr_collection_type', $this->switcher(__('Collection Type', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_attr_core_ingredient', $this->switcher(__('Core Ingredient', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_attr_region_cluster', $this->switcher(__('Source Belt / Region Cluster', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_attr_use_case', $this->switcher(__('Use Case', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_price', $this->switcher(__('Price Range', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_stock', $this->switcher(__('Stock', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_sort', $this->switcher(__('Sort', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('acf_advanced_filters_heading', array(
                'label' => __('Advanced Origin Filters', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ));
            $this->add_control('show_attr_producer_maker', $this->switcher(__('Producer / Maker', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_shg', $this->switcher(__('SHG / Producer Group', 'amaley-discovery-engine'), 'no'));
            $this->add_control('show_attr_village_source_location', $this->switcher(__('Village / Source Location', 'amaley-discovery-engine'), 'no'));
            $this->end_controls_section();

            $this->start_controls_section('acf_layout', array(
                'label' => __('Layout', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ));
            $this->add_responsive_control('columns_desktop', array(
                'label' => __('Columns', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'min' => 1,
                'max' => 6,
            ));
            $this->add_control('desktop_filter_position', array(
                'label' => __('Desktop Filter Position', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => array('left' => __('Left Sidebar', 'amaley-discovery-engine'), 'top' => __('Top Bar', 'amaley-discovery-engine')),
            ));
            $this->add_control('tablet_filter_mode', array(
                'label' => __('Tablet Filter Mode', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'drawer',
                'options' => array('visible' => __('Visible', 'amaley-discovery-engine'), 'compact' => __('Compact', 'amaley-discovery-engine'), 'drawer' => __('Drawer', 'amaley-discovery-engine')),
            ));
            $this->add_control('mobile_filter_mode', array(
                'label' => __('Mobile Filter Mode', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'drawer',
                'options' => array('visible' => __('Visible', 'amaley-discovery-engine'), 'compact' => __('Compact', 'amaley-discovery-engine'), 'drawer' => __('Drawer', 'amaley-discovery-engine')),
            ));
            $this->add_control('show_mobile_result_count', $this->switcher(__('Mobile Result Count', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_mobile_quick_pills', $this->switcher(__('Mobile / Tablet Quick Pills', 'amaley-discovery-engine'), 'no'));
            $this->add_control('acf_mobile_quick_pills_note', array(
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Keep this OFF for the clean phone/tablet layout. Turn ON only if you want category chips above the Filter + Sort row.', 'amaley-discovery-engine'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ));
            $this->add_control('show_mobile_sort', $this->switcher(__('Mobile / Top Sort', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('show_mobile_active_chips', $this->switcher(__('Mobile Active Filter Chips', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('mobile_toolbar_layout', array(
                'label' => __('Mobile Toolbar Layout', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'filter_sort',
                'options' => array(
                    'filter_sort' => __('Filter + Sort', 'amaley-discovery-engine'),
                    'filter_only' => __('Filter Only', 'amaley-discovery-engine'),
                    'sort_only' => __('Sort Only', 'amaley-discovery-engine'),
                ),
            ));
            $this->add_control('mobile_quick_pills_limit', array(
                'label' => __('Quick Pills Limit', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 8,
                'min' => 0,
                'max' => 20,
            ));
            $this->add_control('pagination_type', array(
                'label' => __('Pagination', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'numbers',
                'options' => array('numbers' => __('Numbers', 'amaley-discovery-engine'), 'none' => __('None', 'amaley-discovery-engine')),
            ));
            $this->add_control('full_bleed', array(
                'label' => __('Full Bleed Section', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ));
            $this->add_control('custom_wrapper_class', array(
                'label' => __('Custom Wrapper Class', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => $this->get_default_custom_wrapper_class(),
            ));
            $this->end_controls_section();

            $this->start_controls_section('acf_card_renderer', array(
                'label' => __('Product Card Renderer', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ));
            $this->add_control('card_renderer', array(
                'label' => __('Card Renderer', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'amaley_core_product_card',
                'options' => array(
                    'amaley_core_product_card' => __('Amaley Core Product Card — Select Template', 'amaley-discovery-engine'),
                    'elementor_template' => __('Legacy Elementor Template — Advanced Only', 'amaley-discovery-engine'),
                    'marketplace_card' => __('Discovery Native Marketplace Card', 'amaley-discovery-engine'),
                    'default' => __('Discovery Default Card', 'amaley-discovery-engine'),
                ),
            ));
            $this->add_control('amaley_core_product_card_template', array(
                'label' => __('Amaley Core Product Card Template', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'og_product_card_1',
                'options' => apply_filters('amaley_de_core_product_card_template_options', array('og_product_card_1' => __('OG Product Card 1', 'amaley-discovery-engine'))),
                'condition' => array('card_renderer' => 'amaley_core_product_card'),
            ));
            $this->add_control('elementor_template_id', array(
                'label' => __('Elementor Template ID', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => array('card_renderer' => 'elementor_template'),
            ));
            $this->add_control('marketplace_badge_text', array(
                'label' => __('Native Card Badge Text', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Bestseller',
                'condition' => array('card_renderer' => 'marketplace_card'),
            ));
            $this->add_control('marketplace_meta_text', array(
                'label' => __('Native Card Small Label', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Amaley Collection',
                'condition' => array('card_renderer' => 'marketplace_card'),
            ));
            $this->add_control('acf_card_elements_heading', array(
                'label' => __('OG Product Card Elements', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array('card_renderer' => 'amaley_core_product_card'),
            ));
            foreach (array(
                'show_image' => 'Image / Media',
                'show_label' => 'Label',
                'show_title' => 'Title',
                'show_excerpt' => 'Description',
                'show_meta' => 'Price / Origin Meta',
                'show_tags' => 'Tags / Chips',
                'show_button' => 'Button',
            ) as $short => $label) {
                $this->add_control('amaley_dcrsf_' . $short, $this->switcher(__($label, 'amaley-discovery-engine'), 'yes', array('card_renderer' => 'amaley_core_product_card')));
            }
            $this->add_control('amaley_dcrsf_label_text', array(
                'label' => __('Label Text Override', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Product', 'amaley-discovery-engine'),
                'condition' => array('card_renderer' => 'amaley_core_product_card'),
            ));
            $this->add_control('amaley_dcrsf_excerpt_words', array(
                'label' => __('Description Word Limit', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 16,
                'min' => 6,
                'max' => 40,
                'condition' => array('card_renderer' => 'amaley_core_product_card'),
            ));
            $this->add_control('amaley_dcrsf_button_text', array(
                'label' => __('Button Text', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View Product', 'amaley-discovery-engine'),
                'condition' => array('card_renderer' => 'amaley_core_product_card'),
            ));
            $this->end_controls_section();

            $this->start_controls_section('acf_messages_labels', array(
                'label' => __('Messages & Labels', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ));
            foreach ($this->label_controls() as $key => $data) {
                $this->add_control($key, array(
                    'label' => __($data[0], 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => $data[1],
                    'label_block' => true,
                ));
            }
            $this->end_controls_section();

            $this->start_controls_section('acf_collection_builder_cta', array(
                'label' => __('Collection Builder CTA', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ));
            $this->add_control('show_sidebar_cta', $this->switcher(__('Show CTA Box', 'amaley-discovery-engine'), 'yes'));
            $this->add_control('sidebar_cta_kicker', array('label' => __('CTA Kicker', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Collection Builder', 'amaley-discovery-engine'), 'condition' => array('show_sidebar_cta' => 'yes')));
            $this->add_control('sidebar_cta_title', array('label' => __('CTA Title', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Choose Collection Paths', 'amaley-discovery-engine'), 'condition' => array('show_sidebar_cta' => 'yes')));
            $this->add_control('sidebar_cta_text', array('label' => __('CTA Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => __('Buying for teams, properties, events, guest hampers, or store counters? Start with bulk enquiry and Amaley can recommend the right collection by budget, audience, and purpose.', 'amaley-discovery-engine'), 'condition' => array('show_sidebar_cta' => 'yes')));
            $this->add_control('show_sidebar_cta_kicker', $this->switcher(__('Show CTA Kicker', 'amaley-discovery-engine'), 'yes', array('show_sidebar_cta' => 'yes')));
            $this->add_control('show_sidebar_cta_title', $this->switcher(__('Show CTA Title', 'amaley-discovery-engine'), 'yes', array('show_sidebar_cta' => 'yes')));
            $this->add_control('show_sidebar_cta_text', $this->switcher(__('Show CTA Description', 'amaley-discovery-engine'), 'yes', array('show_sidebar_cta' => 'yes')));
            $this->add_control('show_sidebar_cta_button', $this->switcher(__('Show CTA Button', 'amaley-discovery-engine'), 'yes', array('show_sidebar_cta' => 'yes')));
            $this->add_control('sidebar_cta_button_text', array('label' => __('CTA Button Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Curate Hamper', 'amaley-discovery-engine'), 'condition' => array('show_sidebar_cta' => 'yes', 'show_sidebar_cta_button' => 'yes')));
            $this->add_control('sidebar_cta_button_url', array('label' => __('CTA Button URL', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '#', 'placeholder' => 'https:// or #', 'condition' => array('show_sidebar_cta' => 'yes', 'show_sidebar_cta_button' => 'yes')));
            $this->end_controls_section();
        }

        private function register_style_controls_clean() {
            $root = '{{WRAPPER}} .amaley-discovery-engine-v1.amaley-collection-product-filter-v145';
            $inner = $root . ' .amaley-discovery-engine-v1__inner';
            $heading_wrap = $root . ' .amaley-discovery-engine-v1__heading-wrap';
            $kicker = $root . ' .amaley-discovery-engine-v1__kicker';
            $heading = $root . ' .amaley-discovery-engine-v1__heading';
            $heading_accent = $root . ' .amaley-discovery-engine-v1__heading span';
            $layout = $root . ' .amaley-discovery-engine-v1__layout';
            $grid = $root . ' .amaley-discovery-engine-v1__grid';
            $filters = $root . ' .amaley-discovery-engine-v1__filters';
            $field = $root . ' .amaley-discovery-engine-v1__field';
            $field_label = $root . ' .amaley-discovery-engine-v1__field > span';
            $field_input = $root . ' .amaley-discovery-engine-v1__field input, ' . $root . ' .amaley-discovery-engine-v1__field select';
            $price_fields = $root . ' .amaley-discovery-engine-v1__price-fields';
            $actions = $root . ' .amaley-discovery-engine-v1__filter-actions';
            $apply = $root . ' .amaley-discovery-engine-v1__apply';
            $reset = $root . ' .amaley-discovery-engine-v1__reset';
            $mobile_bar = $root . ' .amaley-discovery-engine-v1__mobile-bar';
            $quick_pills = $root . ' .amaley-discovery-engine-v1__quick-pills';
            $quick_pill = $root . ' .amaley-discovery-engine-v1__quick-pill';
            $quick_pill_active = $root . ' .amaley-discovery-engine-v1__quick-pill.is-active';
            $filter_button = $root . ' .amaley-discovery-engine-v1__mobile-filter-button';
            $drawer_head = $root . ' .amaley-discovery-engine-v1__filter-drawer-head';
            $drawer_close = $root . ' .amaley-discovery-engine-v1__filter-drawer-head button';
            $result_head = $root . ' .amaley-discovery-engine-v1__result-head';
            $result_count = $root . ' .amaley-discovery-engine-v1__result-count, ' . $root . ' .amaley-discovery-engine-v1__mobile-count';
            $pagination = $root . ' .amaley-discovery-engine-v1__pagination';
            $pagination_item = $root . ' .amaley-discovery-engine-v1__pagination a, ' . $root . ' .amaley-discovery-engine-v1__pagination span';
            $pagination_active = $root . ' .amaley-discovery-engine-v1__pagination .is-active';
            $cta = $root . ' .amaley-discovery-engine-v1__sidebar-cta';
            $cta_kicker = $cta . ' .amaley-discovery-engine-v1__sidebar-cta-kicker, ' . $cta . ' small';
            $cta_title = $cta . ' .amaley-discovery-engine-v1__sidebar-cta-title, ' . $cta . ' strong';
            $cta_text = $cta . ' .amaley-discovery-engine-v1__sidebar-cta-text, ' . $cta . ' p';
            $cta_button = $cta . ' .amaley-discovery-engine-v1__sidebar-cta-button';
            $card = $root . ' .amaley-de-core-card-wrap > .amaley-card.amaley-card--product, ' . $root . ' .amaley-dcrsf-core-card-wrap > .amaley-card.amaley-card--product';
            $card_media = $root . ' .amaley-card.amaley-card--product .amaley-card__media';
            $card_body = $root . ' .amaley-card.amaley-card--product .amaley-card__body';
            $card_label = $root . ' .amaley-card.amaley-card--product .amaley-card__label';
            $card_title = $root . ' .amaley-card.amaley-card--product .amaley-card__title';
            $card_excerpt = $root . ' .amaley-card.amaley-card--product .amaley-card__excerpt';
            $card_meta = $root . ' .amaley-card.amaley-card--product .amaley-card__meta';
            $card_meta_item = $root . ' .amaley-card.amaley-card--product .amaley-card__meta-item';
            $card_meta_label = $root . ' .amaley-card.amaley-card--product .amaley-card__meta span';
            $card_meta_value = $root . ' .amaley-card.amaley-card--product .amaley-card__meta strong, ' . $root . ' .amaley-card.amaley-card--product .amaley-card__price, ' . $root . ' .amaley-card.amaley-card--product .amaley-card__price .amount, ' . $root . ' .amaley-card.amaley-card--product .amaley-card__price .woocommerce-Price-amount, ' . $root . ' .amaley-card.amaley-card--product .amaley-card__price bdi';
            $card_tags = $root . ' .amaley-card.amaley-card--product .amaley-card__tags';
            $card_tag = $root . ' .amaley-card.amaley-card--product .amaley-card__tags span';
            $card_button = $root . ' .amaley-card.amaley-card--product .amaley-card__button';

            $this->start_controls_section('acf_style_section_heading', array('label' => __('Section / Heading', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
            $this->start_controls_tabs('acf_section_heading_tabs');
            $this->start_controls_tab('acf_section_tab', array('label' => __('Section', 'amaley-discovery-engine')));
            $this->add_control('acf_section_bg', array('label' => __('Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($root => 'background-color: {{VALUE}};')));
            $this->add_responsive_control('acf_section_padding', array('label' => __('Section Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em','%'), 'selectors' => array($root => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_inner_width', array('label' => __('Inner Max Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 720, 'max' => 1600)), 'selectors' => array($inner => 'width:min({{SIZE}}{{UNIT}}, calc(100% - 32px));')));
            $this->add_responsive_control('acf_heading_gap', array('label' => __('Heading Bottom Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 80)), 'selectors' => array($heading_wrap => 'margin-bottom: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_heading_block_width', array('label' => __('Heading Block Max Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px','%'), 'range' => array('px' => array('min' => 220, 'max' => 1200), '%' => array('min' => 20, 'max' => 100)), 'selectors' => array($heading_wrap => 'max-width: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_heading_block_position', array('label' => __('Heading Block Position', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array('left' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-left'), 'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-center'), 'right' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-right'), 'stretch' => array('title' => __('Stretch', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-stretch')), 'selectors_dictionary' => array('left' => 'margin-left:0; margin-right:auto;', 'center' => 'margin-left:auto; margin-right:auto;', 'right' => 'margin-left:auto; margin-right:0;', 'stretch' => 'width:100%; max-width:100%; margin-left:0; margin-right:0;'), 'selectors' => array($heading_wrap => '{{VALUE}};')));
            $this->add_responsive_control('acf_heading_text_align', array('label' => __('Heading Text Alignment', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array('left' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-left'), 'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-center'), 'right' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-right')), 'selectors' => array($heading_wrap => 'text-align: {{VALUE}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_kicker_tab', array('label' => __('Kicker', 'amaley-discovery-engine')));
            $this->add_control('acf_kicker_color', array('label' => __('Kicker Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($kicker => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_kicker_typography', 'selector' => $kicker));
            $this->add_responsive_control('acf_kicker_margin', array('label' => __('Kicker Margin', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($kicker => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_heading_tab', array('label' => __('Heading', 'amaley-discovery-engine')));
            $this->add_control('acf_heading_color', array('label' => __('Heading Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($heading => 'color: {{VALUE}};')));
            $this->add_control('acf_heading_accent_color', array('label' => __('Accent Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($heading_accent => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_heading_typography', 'selector' => $heading));
            $this->add_responsive_control('acf_heading_margin', array('label' => __('Heading Margin', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($heading => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->end_controls_section();

            $this->start_controls_section('acf_style_filters', array('label' => __('Filters / Toolbar', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
            $this->start_controls_tabs('acf_filter_style_tabs');
            $this->start_controls_tab('acf_filter_panel_tab', array('label' => __('Panel', 'amaley-discovery-engine')));
            $this->add_control('acf_filter_bg', array('label' => __('Panel Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($filters => 'background-color: {{VALUE}};')));
            $this->add_control('acf_filter_border', array('label' => __('Border Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($filters => 'border-color: {{VALUE}};')));
            $this->add_responsive_control('acf_filter_border_width', array('label' => __('Border Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 8)), 'selectors' => array($filters => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;')));
            $this->add_responsive_control('acf_filter_radius', array('label' => __('Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 60)), 'selectors' => array($filters => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_filter_padding', array('label' => __('Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($filters => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_filter_gap', array('label' => __('Item Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 32)), 'selectors' => array($filters => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name' => 'acf_filter_shadow', 'selector' => $filters));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_filter_fields_tab', array('label' => __('Fields', 'amaley-discovery-engine')));
            $this->add_responsive_control('acf_field_gap', array('label' => __('Label/Input Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 20)), 'selectors' => array($field => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_label_color', array('label' => __('Label Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($field_label => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_label_typography', 'selector' => $field_label));
            $this->add_control('acf_input_bg', array('label' => __('Input Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => array($field_input => 'background-color: {{VALUE}};')));
            $this->add_control('acf_input_text', array('label' => __('Input Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($field_input => 'color: {{VALUE}};')));
            $this->add_control('acf_input_border', array('label' => __('Input Border', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($field_input => 'border-color: {{VALUE}};')));
            $this->add_responsive_control('acf_input_radius', array('label' => __('Input Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 40)), 'selectors' => array($field_input => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_input_height', array('label' => __('Input Min Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 28, 'max' => 72)), 'selectors' => array($field_input => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_input_padding', array('label' => __('Input Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($field_input => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_input_typography', 'selector' => $field_input));
            $this->add_responsive_control('acf_price_gap', array('label' => __('Price Min/Max Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'separator' => 'before', 'range' => array('px' => array('min' => 0, 'max' => 28)), 'selectors' => array($price_fields => 'gap: {{SIZE}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_filter_buttons_tab', array('label' => __('Buttons', 'amaley-discovery-engine')));
            $this->add_responsive_control('acf_action_gap', array('label' => __('Button Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 32)), 'selectors' => array($actions => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_action_margin', array('label' => __('Button Row Margin', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($actions => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_action_height', array('label' => __('Button Min Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 28, 'max' => 80)), 'selectors' => array($apply . ', ' . $reset => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_action_padding', array('label' => __('Button Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($apply . ', ' . $reset => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_action_radius', array('label' => __('Button Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 80)), 'selectors' => array($apply . ', ' . $reset => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_action_typography', 'selector' => $apply . ', ' . $reset));
            $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name' => 'acf_action_shadow', 'selector' => $apply . ', ' . $reset));
            $this->add_control('acf_apply_heading', array('label' => __('Apply Button — Normal', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            $this->add_control('acf_apply_bg', array('label' => __('Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($apply => 'background-color: {{VALUE}};')));
            $this->add_control('acf_apply_text', array('label' => __('Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($apply => 'color: {{VALUE}};')));
            $this->add_control('acf_apply_border', array('label' => __('Border Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($apply => 'border-color: {{VALUE}};')));
            $this->add_control('acf_apply_hover_heading', array('label' => __('Apply Button — Hover', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            $this->add_control('acf_apply_hover_bg', array('label' => __('Hover Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($apply . ':hover, ' . $apply . ':focus' => 'background-color: {{VALUE}};')));
            $this->add_control('acf_apply_hover_text', array('label' => __('Hover Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($apply . ':hover, ' . $apply . ':focus' => 'color: {{VALUE}};')));
            $this->add_control('acf_apply_hover_border', array('label' => __('Hover Border', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($apply . ':hover, ' . $apply . ':focus' => 'border-color: {{VALUE}};')));
            $this->add_control('acf_reset_heading', array('label' => __('Clear Button — Normal', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            $this->add_control('acf_reset_bg', array('label' => __('Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($reset => 'background-color: {{VALUE}};')));
            $this->add_control('acf_reset_text', array('label' => __('Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($reset => 'color: {{VALUE}};')));
            $this->add_control('acf_reset_border', array('label' => __('Border Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($reset => 'border-color: {{VALUE}};')));
            $this->add_control('acf_reset_hover_heading', array('label' => __('Clear Button — Hover', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            $this->add_control('acf_reset_hover_bg', array('label' => __('Hover Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($reset . ':hover, ' . $reset . ':focus' => 'background-color: {{VALUE}};')));
            $this->add_control('acf_reset_hover_text', array('label' => __('Hover Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($reset . ':hover, ' . $reset . ':focus' => 'color: {{VALUE}};')));
            $this->add_control('acf_reset_hover_border', array('label' => __('Hover Border', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($reset . ':hover, ' . $reset . ':focus' => 'border-color: {{VALUE}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_filter_mobile_tab', array('label' => __('Mobile', 'amaley-discovery-engine')));
            $this->add_responsive_control('acf_mobile_bar_gap', array('label' => __('Mobile Toolbar Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 36)), 'selectors' => array($mobile_bar => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_mobile_toolbar_columns_gap', array('label' => __('Filter / Sort Column Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 28)), 'selectors' => array($root . ' .amaley-discovery-engine-v1__mobile-toolbar' => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_mobile_toolbar_item_height', array('label' => __('Filter / Sort Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 34, 'max' => 74)), 'selectors' => array($root . ' .amaley-discovery-engine-v1__mobile-filter-button, ' . $root . ' .amaley-discovery-engine-v1__mobile-toolbar .amaley-discovery-engine-v1__sort-select' => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_mobile_toolbar_item_radius', array('label' => __('Filter / Sort Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 40)), 'selectors' => array($root . ' .amaley-discovery-engine-v1__mobile-filter-button, ' . $root . ' .amaley-discovery-engine-v1__mobile-toolbar .amaley-discovery-engine-v1__sort-select' => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_mobile_hide_sort_label', array('label' => __('Hide Sort Label in Phone/Tablet Row', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes', 'return_value' => 'yes', 'selectors' => array($root . ' .amaley-discovery-engine-v1__mobile-toolbar .amaley-discovery-engine-v1__sort-field > span' => 'display: none !important;')));
            $this->add_responsive_control('acf_pills_gap', array('label' => __('Quick Pills Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 26)), 'selectors' => array($quick_pills => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_pill_color', array('label' => __('Pill Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($quick_pill => 'color: {{VALUE}};')));
            $this->add_control('acf_pill_border', array('label' => __('Pill Border', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($quick_pill => 'border-color: {{VALUE}};')));
            $this->add_control('acf_pill_active_bg', array('label' => __('Active Pill Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($quick_pill_active => 'background-color: {{VALUE}};')));
            $this->add_control('acf_pill_active_text', array('label' => __('Active Pill Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($quick_pill_active => 'color: {{VALUE}};')));
            $this->add_control('acf_filter_button_bg', array('label' => __('Filter Button Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => array($filter_button => 'background-color: {{VALUE}};')));
            $this->add_control('acf_filter_button_text', array('label' => __('Filter Button Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($filter_button => 'color: {{VALUE}};')));
            $this->add_control('acf_filter_button_border', array('label' => __('Filter Button Border', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($filter_button => 'border-color: {{VALUE}};')));
            $this->add_responsive_control('acf_filter_button_radius', array('label' => __('Filter Button Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 80)), 'selectors' => array($filter_button => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_filter_button_padding', array('label' => __('Filter Button Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($filter_button => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_control('acf_drawer_style_heading', array('label' => __('Drawer Panel', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            $this->add_responsive_control('acf_drawer_width', array('label' => __('Drawer Max Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px','vw'), 'range' => array('px' => array('min' => 260, 'max' => 560), 'vw' => array('min' => 60, 'max' => 100)), 'selectors' => array($root => '--ade-drawer-width: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_drawer_edge_gap', array('label' => __('Drawer Screen Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 40)), 'selectors' => array($root => '--ade-drawer-edge: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_drawer_radius', array('label' => __('Drawer Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 48)), 'selectors' => array($root => '--ade-drawer-radius: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_drawer_padding', array('label' => __('Drawer Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($root => '--ade-drawer-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_control('acf_drawer_head_bg', array('label' => __('Drawer Header Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => array($drawer_head => 'background-color: {{VALUE}};')));
            $this->add_control('acf_drawer_head_color', array('label' => __('Drawer Header Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($drawer_head => 'color: {{VALUE}};')));
            $this->add_control('acf_drawer_close_color', array('label' => __('Drawer Close Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($drawer_close => 'color: {{VALUE}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_filter_results_tab', array('label' => __('Results', 'amaley-discovery-engine')));
            $this->add_responsive_control('acf_result_head_margin', array('label' => __('Result Bar Bottom Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 60)), 'selectors' => array($result_head => 'margin-bottom: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_result_head_gap', array('label' => __('Result Bar Item Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 40)), 'selectors' => array($result_head => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_result_count_color', array('label' => __('Result Count Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($result_count => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_result_count_typography', 'selector' => $result_count));
            $this->add_responsive_control('acf_top_sort_width', array('label' => __('Top Sort Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 120, 'max' => 360)), 'selectors' => array($root . ' .amaley-discovery-engine-v1__result-head .amaley-discovery-engine-v1__sort-field' => 'width: {{SIZE}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->end_controls_section();

            $this->start_controls_section('acf_style_grid_cards', array('label' => __('Product Grid & OG Card', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array('card_renderer' => 'amaley_core_product_card')));
            $this->start_controls_tabs('acf_grid_card_tabs');
            $this->start_controls_tab('acf_grid_tab', array('label' => __('Grid', 'amaley-discovery-engine')));
            $this->add_responsive_control('acf_layout_gap', array('label' => __('Filter / Results Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 80)), 'selectors' => array($layout => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_sidebar_width', array('label' => __('Desktop Sidebar Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 220, 'max' => 430)), 'selectors' => array($root => '--ade-sidebar-width: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_grid_gap', array('label' => __('Product Grid Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 70)), 'selectors' => array($grid => 'gap: {{SIZE}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_card_layout_tab', array('label' => __('Layout', 'amaley-discovery-engine')));
            $this->add_control('acf_card_bg', array('label' => __('Card Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card => 'background-color: {{VALUE}}; --amaley-card-paper: {{VALUE}};')));
            $this->add_control('acf_card_border', array('label' => __('Card Border', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card => 'border-color: {{VALUE}}; --amaley-card-border: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name' => 'acf_card_shadow', 'selector' => $card));
            $this->add_responsive_control('acf_card_radius', array('label' => __('Card Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 60)), 'separator' => 'before', 'selectors' => array($card => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_card_min_height', array('label' => __('Card Min Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 760)), 'selectors' => array($card => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_card_media_height', array('label' => __('Image / Media Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 80, 'max' => 420)), 'selectors' => array($card_media => 'height: {{SIZE}}{{UNIT}} !important;')));
            $this->add_responsive_control('acf_card_body_padding', array('label' => __('Body Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($card_body => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_card_body_gap', array('label' => __('Body Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 42)), 'selectors' => array($card_body => 'gap: {{SIZE}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_card_text_tab', array('label' => __('Text', 'amaley-discovery-engine')));
            $this->add_control('acf_card_label_color', array('label' => __('Label Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_label => 'color: {{VALUE}}; --amaley-card-gold: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_card_label_typography', 'selector' => $card_label));
            $this->add_control('acf_card_title_color', array('label' => __('Title Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => array($card_title => 'color: {{VALUE}}; --amaley-card-dark: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_card_title_typography', 'selector' => $card_title));
            $this->add_responsive_control('acf_card_title_min_height', array('label' => __('Title Min Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 140)), 'selectors' => array($card_title => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_card_excerpt_color', array('label' => __('Description Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => array($card_excerpt => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_card_excerpt_typography', 'selector' => $card_excerpt));
            $this->add_responsive_control('acf_card_excerpt_min_height', array('label' => __('Description Min Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 140)), 'selectors' => array($card_excerpt => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_card_meta_tab', array('label' => __('Meta & Tags', 'amaley-discovery-engine')));
            $this->add_responsive_control('acf_card_meta_gap', array('label' => __('Meta Box Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 28)), 'selectors' => array($card_meta => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_card_price_column', array('label' => __('Price Column Min Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 52, 'max' => 130)), 'selectors' => array($card_meta => 'grid-template-columns:minmax({{SIZE}}{{UNIT}}, .34fr) minmax(0,1fr);')));
            $this->add_responsive_control('acf_card_meta_padding', array('label' => __('Meta Box Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($card_meta_item => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_card_meta_radius', array('label' => __('Meta Box Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 42)), 'selectors' => array($card_meta_item => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_card_meta_label_color', array('label' => __('Meta Label Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_meta_label => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_card_meta_label_typography', 'selector' => $card_meta_label));
            $this->add_control('acf_card_meta_value_color', array('label' => __('Meta Value / Price Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_meta_value => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_card_meta_value_typography', 'selector' => $card_meta_value));
            $this->add_responsive_control('acf_card_tag_gap', array('label' => __('Tag Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'separator' => 'before', 'range' => array('px' => array('min' => 0, 'max' => 24)), 'selectors' => array($card_tags => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_card_tag_bg', array('label' => __('Tag Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_tag => 'background-color: {{VALUE}};')));
            $this->add_control('acf_card_tag_text', array('label' => __('Tag Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_tag => 'color: {{VALUE}};')));
            $this->add_responsive_control('acf_card_tag_radius', array('label' => __('Tag Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 40)), 'selectors' => array($card_tag => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_card_tag_typography', 'selector' => $card_tag));
            $this->end_controls_tab();
            $this->start_controls_tab('acf_card_button_tab', array('label' => __('Button', 'amaley-discovery-engine')));
            $this->add_control('acf_card_button_bg', array('label' => __('Button Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_button => 'background-color: {{VALUE}};')));
            $this->add_control('acf_card_button_text', array('label' => __('Button Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_button => 'color: {{VALUE}};')));
            $this->add_control('acf_card_button_hover_bg', array('label' => __('Hover Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_button . ':hover, ' . $card_button . ':focus' => 'background-color: {{VALUE}};')));
            $this->add_control('acf_card_button_hover_text', array('label' => __('Hover Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($card_button . ':hover, ' . $card_button . ':focus' => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_card_button_typography', 'selector' => $card_button));
            $this->add_responsive_control('acf_card_button_height', array('label' => __('Button Min Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'separator' => 'before', 'range' => array('px' => array('min' => 28, 'max' => 80)), 'selectors' => array($card_button => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_card_button_radius', array('label' => __('Button Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 80)), 'selectors' => array($card_button => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_card_button_padding', array('label' => __('Button Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($card_button => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->end_controls_section();

            $this->start_controls_section('acf_style_pagination', array('label' => __('Pagination', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
            $this->add_responsive_control('acf_pagination_gap', array('label' => __('Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 40)), 'selectors' => array($pagination => 'gap: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_pagination_size', array('label' => __('Button Size', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 24, 'max' => 70)), 'selectors' => array($pagination_item => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
            $this->add_control('acf_pagination_bg', array('label' => __('Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($pagination_item => 'background-color: {{VALUE}};')));
            $this->add_control('acf_pagination_text', array('label' => __('Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($pagination_item => 'color: {{VALUE}};')));
            $this->add_control('acf_pagination_active_bg', array('label' => __('Active Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($pagination_active => 'background-color: {{VALUE}};')));
            $this->add_control('acf_pagination_active_text', array('label' => __('Active Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($pagination_active => 'color: {{VALUE}};')));
            $this->end_controls_section();

            $this->start_controls_section('acf_style_cta', array('label' => __('Collection Builder CTA', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array('show_sidebar_cta' => 'yes')));
            $this->start_controls_tabs('acf_cta_tabs');

            $this->start_controls_tab('acf_cta_box_tab', array('label' => __('Box', 'amaley-discovery-engine')));
            $this->add_control('sidebar_cta_bg_color', array('label' => __('Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta => 'background-color: {{VALUE}};')));
            $this->add_control('acf_cta_border_color', array('label' => __('Border Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta => 'border-color: {{VALUE}};')));
            $this->add_responsive_control('acf_cta_border_width', array('label' => __('Border Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 8)), 'selectors' => array($cta => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;')));
            $this->add_responsive_control('acf_cta_radius', array('label' => __('Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 60)), 'selectors' => array($cta => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_cta_padding', array('label' => __('Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em','%'), 'selectors' => array($cta => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_cta_margin', array('label' => __('Margin', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em','%'), 'selectors' => array($cta => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_cta_gap', array('label' => __('Inner Gap', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 60)), 'selectors' => array($cta => 'display:flex; flex-direction:column; gap: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_cta_element_align', array('label' => __('Element Alignment', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array('flex-start' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-left'), 'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-center'), 'flex-end' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-right'), 'stretch' => array('title' => __('Stretch', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-stretch')), 'selectors' => array($cta => 'align-items: {{VALUE}};')));
            $this->add_responsive_control('acf_cta_text_align', array('label' => __('Text Alignment', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array('left' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-left'), 'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-center'), 'right' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-right')), 'selectors' => array($cta => 'text-align: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name' => 'acf_cta_shadow', 'selector' => $cta));
            $this->end_controls_tab();

            $this->start_controls_tab('acf_cta_kicker_tab', array('label' => __('Kicker', 'amaley-discovery-engine')));
            $this->add_control('sidebar_cta_accent_color', array('label' => __('Kicker Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_kicker => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_cta_kicker_typography', 'selector' => $cta_kicker));
            $this->add_responsive_control('acf_cta_kicker_margin', array('label' => __('Kicker Margin', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($cta_kicker => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->end_controls_tab();

            $this->start_controls_tab('acf_cta_title_tab', array('label' => __('Title', 'amaley-discovery-engine')));
            $this->add_control('acf_cta_title_color', array('label' => __('Title Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_title => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_cta_title_typography', 'selector' => $cta_title));
            $this->add_responsive_control('acf_cta_title_margin', array('label' => __('Title Margin', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($cta_title => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->end_controls_tab();

            $this->start_controls_tab('acf_cta_desc_tab', array('label' => __('Description', 'amaley-discovery-engine')));
            $this->add_control('sidebar_cta_text_color', array('label' => __('Description Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_text => 'color: {{VALUE}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_cta_text_typography', 'selector' => $cta_text));
            $this->add_responsive_control('acf_cta_text_margin', array('label' => __('Description Margin', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($cta_text => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_cta_text_max_width', array('label' => __('Description Max Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px','%'), 'range' => array('px' => array('min' => 120, 'max' => 700), '%' => array('min' => 20, 'max' => 100)), 'selectors' => array($cta_text => 'max-width: {{SIZE}}{{UNIT}};')));
            $this->end_controls_tab();

            $this->start_controls_tab('acf_cta_button_tab', array('label' => __('Button', 'amaley-discovery-engine'), 'condition' => array('show_sidebar_cta_button' => 'yes')));
            $this->add_responsive_control('acf_cta_button_width', array('label' => __('Button Width', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array('' => __('Default', 'amaley-discovery-engine'), '100%' => __('Full Width', 'amaley-discovery-engine'), 'max-content' => __('Fit Content', 'amaley-discovery-engine')), 'selectors' => array($cta_button => 'width: {{VALUE}}; max-width:100%;')));
            $this->add_responsive_control('acf_cta_button_min_height', array('label' => __('Button Min Height', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 24, 'max' => 80)), 'selectors' => array($cta_button => 'min-height: {{SIZE}}{{UNIT}};')));
            $this->add_responsive_control('acf_cta_button_padding', array('label' => __('Button Padding', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array('px','em'), 'selectors' => array($cta_button => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->add_responsive_control('acf_cta_button_radius', array('label' => __('Button Radius', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array('px'), 'range' => array('px' => array('min' => 0, 'max' => 80)), 'selectors' => array($cta_button => 'border-radius: {{SIZE}}{{UNIT}};')));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name' => 'acf_cta_button_typography', 'selector' => $cta_button));
            $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name' => 'acf_cta_button_shadow', 'selector' => $cta_button));
            $this->add_control('acf_cta_button_normal_heading', array('label' => __('Normal', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            $this->add_control('sidebar_cta_button_bg_color', array('label' => __('Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_button => 'background-color: {{VALUE}};')));
            $this->add_control('sidebar_cta_button_text_color', array('label' => __('Text Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_button => 'color: {{VALUE}};')));
            $this->add_control('acf_cta_button_border', array('label' => __('Border Color', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_button => 'border-color: {{VALUE}}; border-style: solid;')));
            $this->add_control('acf_cta_button_hover_heading', array('label' => __('Hover', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            $this->add_control('acf_cta_button_hover_bg', array('label' => __('Hover Background', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_button . ':hover, ' . $cta_button . ':focus' => 'background-color: {{VALUE}};')));
            $this->add_control('acf_cta_button_hover_text', array('label' => __('Hover Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_button . ':hover, ' . $cta_button . ':focus' => 'color: {{VALUE}};')));
            $this->add_control('acf_cta_button_hover_border', array('label' => __('Hover Border', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array($cta_button . ':hover, ' . $cta_button . ':focus' => 'border-color: {{VALUE}};')));
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->end_controls_section();
        }

        private function register_device_visibility_controls_clean() {
            $this->start_controls_section('acf_device_visibility', array(
                'label' => __('Device Visibility', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ));
            $this->add_control('acf_device_visibility_note', array(
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Use only when a filter or card part should be hidden on desktop/tablet/phone. Style settings are in the Style tab.', 'amaley-discovery-engine'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ));
            $this->add_control('acf_visibility_filters_heading', array('label' => __('Filters & Toolbar', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            foreach ($this->visibility_filter_targets() as $key => $target) {
                $this->add_responsive_control('ade_visibility_' . $key, array(
                    'label' => __($target[0], 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => $target[2],
                    'tablet_default' => isset($target[3]) ? $target[3] : $target[2],
                    'mobile_default' => isset($target[4]) ? $target[4] : $target[2],
                    'options' => array($target[2] => __('Show', 'amaley-discovery-engine'), 'none' => __('Hide', 'amaley-discovery-engine')),
                    'selectors' => array('{{WRAPPER}} ' . $target[1] => 'display: {{VALUE}} !important;'),
                ));
            }
            $this->add_control('acf_visibility_cards_heading', array('label' => __('Card Elements', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before'));
            foreach ($this->visibility_card_targets() as $key => $target) {
                $this->add_responsive_control('ade_visibility_' . $key, array(
                    'label' => __($target[0], 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => $target[2],
                    'tablet_default' => $target[2],
                    'mobile_default' => $target[2],
                    'options' => array($target[2] => __('Show', 'amaley-discovery-engine'), 'none' => __('Hide', 'amaley-discovery-engine')),
                    'selectors' => array('{{WRAPPER}} ' . $target[1] => 'display: {{VALUE}} !important;'),
                ));
            }
            $this->end_controls_section();
        }

        private function label_controls() {
            return array(
                'mobile_filter_button_text' => array('Mobile Filter Button', 'Filter'),
                'filter_drawer_title' => array('Drawer Title', 'Filters'),
                'apply_button_text' => array('Apply Button Text', 'Apply Filters'),
                'reset_button_text' => array('Clear Button Text', 'Clear All'),
                'all_option_text' => array('All Option Text', 'All'),
                'search_label' => array('Search Label', 'Search'),
                'search_placeholder' => array('Search Placeholder', 'Search products...'),
                'category_label' => array('Category Label', 'Category'),
                'tag_label' => array('Tag Label', 'Tag'),
                'stock_label' => array('Stock Label', 'Stock'),
                'stock_any_label' => array('Stock Any Label', 'Any stock status'),
                'stock_in_label' => array('Stock In Label', 'In stock'),
                'stock_out_label' => array('Stock Out Label', 'Out of stock'),
                'collection_type_label' => array('Collection Type Label', 'Collection Type'),
                'core_ingredient_label' => array('Core Ingredient Label', 'Core Ingredient'),
                'cluster_label' => array('Cluster Label', 'Cluster'),
                'producer_maker_label' => array('Producer / Maker Label', 'Producer / Maker'),
                'shg_label' => array('SHG / Producer Group Label', 'SHG / Producer Group'),
                'region_cluster_label' => array('Source Belt / Region Label', 'Source Belt / Region Cluster'),
                'use_case_label' => array('Use Case Label', 'Use Case'),
                'village_source_location_label' => array('Village / Source Location Label', 'Village / Source Location'),
                'price_label' => array('Price Label', 'Price Range'),
                'min_price_placeholder' => array('Min Price Placeholder', 'Min'),
                'max_price_placeholder' => array('Max Price Placeholder', 'Max'),
                'sort_label' => array('Sort Label', 'Sort'),
                'result_count_singular' => array('Singular Result Text', '{count} result found'),
                'result_count_plural' => array('Plural Result Text', '{count} products found'),
                'empty_state_title' => array('Empty State Title', 'No products found.'),
                'empty_state_text' => array('Empty State Text', 'Try clearing one filter or explore all Amaley collections.'),
            );
        }

        private function visibility_filter_targets() {
            return array(
                'search' => array('Search Filter', '.amaley-de-field-search', 'flex'),
                'collection_type' => array('Collection Type Filter', '.amaley-de-field-ade-attr-collection-type', 'flex'),
                'core_ingredient' => array('Core Ingredient Filter', '.amaley-de-field-ade-attr-core-ingredient', 'flex'),
                'cluster' => array('Cluster Filter', '.amaley-de-field-ade-attr-cluster', 'flex'),
                'region_cluster' => array('Source Belt / Region Filter', '.amaley-de-field-ade-attr-region-cluster', 'flex'),
                'use_case' => array('Use Case Filter', '.amaley-de-field-ade-attr-use-case', 'flex'),
                'price' => array('Price Range Filter', '.amaley-de-field-price', 'flex'),
                'sort' => array('Sort Field', '.amaley-de-field-sort', 'flex'),
                'actions' => array('Apply / Clear Buttons', '.amaley-de-field-actions', 'flex'),
                'cta' => array('Collection Builder CTA', '.amaley-discovery-engine-v1__sidebar-cta', 'block'),
                'result_count' => array('Result Count', '.amaley-discovery-engine-v1__result-count, .amaley-discovery-engine-v1__mobile-count', 'block'),
                'quick_pills' => array('Quick Pills / Category Chips', '.amaley-discovery-engine-v1__quick-pills', 'flex', 'none', 'none'),
                'active_chips' => array('Active Filter Chips', '.amaley-discovery-engine-v1__chips, .amaley-discovery-engine-v1__mobile-chips', 'flex', 'none', 'none'),
                'pagination' => array('Pagination', '.amaley-discovery-engine-v1__pagination', 'flex'),
            );
        }

        private function visibility_card_targets() {
            return array(
                'card_image' => array('Card Image / Media', '.amaley-de-core-card-wrap .amaley-card__media', 'block'),
                'card_label' => array('Card Label', '.amaley-de-core-card-wrap .amaley-card__label', 'block'),
                'card_title' => array('Card Title', '.amaley-de-core-card-wrap .amaley-card__title', 'block'),
                'card_excerpt' => array('Card Description', '.amaley-de-core-card-wrap .amaley-card__excerpt', 'block'),
                'card_meta' => array('Card Price / Origin Meta', '.amaley-de-core-card-wrap .amaley-card__meta', 'grid'),
                'card_tags' => array('Card Tags / Chips', '.amaley-de-core-card-wrap .amaley-card__tags', 'flex'),
                'card_button' => array('Card Button', '.amaley-de-core-card-wrap .amaley-card__button', 'inline-flex'),
            );
        }

        protected function render() {
            if (!function_exists('amaley_de_bootstrap')) {
                return;
            }
            $settings = $this->get_settings_for_display();
            $settings['type'] = 'products';
            $settings['custom_wrapper_class'] = !empty($settings['custom_wrapper_class']) ? $settings['custom_wrapper_class'] : $this->get_default_custom_wrapper_class();
            $settings['card_renderer'] = !empty($settings['card_renderer']) ? $settings['card_renderer'] : 'amaley_core_product_card';
            $settings['amaley_core_product_card_template'] = !empty($settings['amaley_core_product_card_template']) ? $settings['amaley_core_product_card_template'] : 'og_product_card_1';
            $settings['tablet_filter_position'] = 'top';
            $settings['mobile_filter_position'] = 'top';
            $settings['desktop_filter_mode'] = 'visible';
            if (empty($settings['tablet_filter_mode'])) { $settings['tablet_filter_mode'] = 'drawer'; }
            if (empty($settings['mobile_filter_mode'])) { $settings['mobile_filter_mode'] = 'drawer'; }
            $settings['show_sidebar_cta_kicker'] = isset($settings['show_sidebar_cta_kicker']) ? $settings['show_sidebar_cta_kicker'] : 'yes';
            $settings['show_sidebar_cta_title'] = isset($settings['show_sidebar_cta_title']) ? $settings['show_sidebar_cta_title'] : 'yes';
            $settings['show_sidebar_cta_text'] = isset($settings['show_sidebar_cta_text']) ? $settings['show_sidebar_cta_text'] : 'yes';
            $settings['show_sidebar_cta_button'] = isset($settings['show_sidebar_cta_button']) ? $settings['show_sidebar_cta_button'] : 'yes';
            $settings['sidebar_cta_button_url'] = !empty($settings['sidebar_cta_button_url']) ? $settings['sidebar_cta_button_url'] : '#';
            $settings['show_sidebar_cta_desktop'] = 'yes';
            $settings['show_sidebar_cta_tablet'] = 'yes';
            $settings['show_sidebar_cta_mobile'] = 'yes';
            echo amaley_de_bootstrap()->renderer->render($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
