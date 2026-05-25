<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Tpl_Shop_Discovery_Widget extends Amaley_Tpl_Widget_Base {

    public function get_name() {
        return 'amaley_tpl_shop_discovery';
    }

    public function get_title() {
        return esc_html__( 'Amaley Templates Shop Discovery', 'amaley-templates' );
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return array( 'amaley-templates' );
    }

    public function get_keywords() {
        return array( 'amaley templates', 'amaley', 'shop', 'products', 'filter', 'discovery', 'woocommerce', 'archive' );
    }

    private function add_box_controls( $prefix, $label, $selector, $include_margin = true ) {
        $this->start_controls_section( 'style_' . $prefix, array(
            'label' => esc_html__( $label, 'amaley-templates' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( $prefix . '_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-templates' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} ' . $selector => 'background: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( $prefix . '_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-templates' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        if ( $include_margin ) {
            $this->add_responsive_control( $prefix . '_margin', array(
                'label'      => esc_html__( 'Margin', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array( '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            ) );
        }

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => $prefix . '_border',
            'selector' => '{{WRAPPER}} ' . $selector,
        ) );

        $this->add_responsive_control( $prefix . '_radius', array(
            'label'      => esc_html__( 'Border Radius', 'amaley-templates' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => $prefix . '_shadow',
            'selector' => '{{WRAPPER}} ' . $selector,
        ) );

        $this->end_controls_section();
    }

    private function add_text_controls( $prefix, $label, $selector, $hover_selector = '' ) {
        $this->start_controls_section( 'style_' . $prefix, array(
            'label' => esc_html__( $label, 'amaley-templates' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( $prefix . '_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-templates' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} ' . $selector => 'color: {{VALUE}};' ),
        ) );

        if ( ! empty( $hover_selector ) ) {
            $this->add_control( $prefix . '_hover_color', array(
                'label'     => esc_html__( 'Hover Text Color', 'amaley-templates' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} ' . $hover_selector => 'color: {{VALUE}};' ),
            ) );
        }

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => $prefix . '_typography',
            'selector' => '{{WRAPPER}} ' . $selector,
        ) );

        $this->add_responsive_control( $prefix . '_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-templates' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( $prefix . '_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-templates' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }


    private function add_shop_text_controls( $prefix, $label, $selector, $hover_selector = '' ) {
        $this->start_controls_section( 'style_' . $prefix, array(
            'label' => esc_html__( $label, 'amaley-templates' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( $prefix . '_align', array(
            'label'     => esc_html__( 'Alignment', 'amaley-templates' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-templates' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-templates' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-templates' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( '{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}};' ),
        ) );

        $this->add_control( $prefix . '_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-templates' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} ' . $selector => 'color: {{VALUE}} !important;' ),
        ) );

        if ( ! empty( $hover_selector ) ) {
            $this->add_control( $prefix . '_hover_color', array(
                'label'     => esc_html__( 'Hover Text Color', 'amaley-templates' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} ' . $hover_selector => 'color: {{VALUE}} !important;' ),
            ) );
        }

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => $prefix . '_typography',
            'selector' => '{{WRAPPER}} ' . $selector,
        ) );

        $this->add_responsive_control( $prefix . '_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-templates' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( $prefix . '_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-templates' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    protected function register_controls() {
        $this->start_controls_section( 'content_main', array( 'label' => esc_html__( 'Shop Discovery Content', 'amaley-templates' ) ) );
        $this->add_control( 'heading', array( 'label' => 'Heading', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.discovery_heading', 'Shop Amaley' ), 'label_block' => true ) );
        $this->add_control( 'kicker', array( 'label' => 'Kicker', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.discovery_kicker', 'Filter by origin, ingredient and use' ), 'label_block' => true ) );
        $this->add_control( 'per_page', array( 'label' => 'Products Per Page', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => (int) $this->tpl_setting( 'shop_page.per_page', 12 ), 'min' => 1, 'max' => 60 ) );
        $this->add_control( 'custom_wrapper_class', array( 'label' => 'Custom Wrapper Class', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.custom_wrapper_class', 'amaley-tpl-shop-og' ), 'label_block' => true ) );
        $this->end_controls_section();

        $this->start_controls_section( 'content_layout', array( 'label' => esc_html__( 'Layout / Responsive', 'amaley-templates' ) ) );
        $this->add_control( 'columns_desktop', array( 'label' => 'Desktop Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => (string) $this->tpl_setting( 'shop_page.columns_desktop', 3 ), 'options' => array( '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->add_control( 'columns_tablet', array( 'label' => 'Tablet Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => (string) $this->tpl_setting( 'shop_page.columns_tablet', 2 ), 'options' => array( '1' => '1', '2' => '2', '3' => '3' ) ) );
        $this->add_control( 'columns_mobile', array( 'label' => 'Mobile Columns', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => (string) $this->tpl_setting( 'shop_page.columns_mobile', 1 ), 'options' => array( '1' => '1', '2' => '2' ) ) );
        $position_options = array( 'left' => 'Left Sidebar', 'top' => 'Top Bar', 'right' => 'Right Sidebar' );
        $mode_options = array( 'visible' => 'Visible', 'compact' => 'Compact Inline', 'drawer' => 'Drawer', 'hidden' => 'Hidden' );
        $this->add_control( 'desktop_filter_position', array( 'label' => 'Desktop Filter Position', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.desktop_filter_position', 'left' ), 'options' => $position_options ) );
        $this->add_control( 'tablet_filter_position', array( 'label' => 'Tablet Filter Position', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.tablet_filter_position', 'top' ), 'options' => $position_options ) );
        $this->add_control( 'mobile_filter_position', array( 'label' => 'Mobile Filter Position', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.mobile_filter_position', 'top' ), 'options' => $position_options ) );
        $this->add_control( 'desktop_filter_mode', array( 'label' => 'Desktop Filter Behaviour', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.desktop_filter_mode', 'visible' ), 'options' => $mode_options ) );
        $this->add_control( 'tablet_filter_mode', array( 'label' => 'Tablet Filter Behaviour', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.tablet_filter_mode', 'compact' ), 'options' => $mode_options ) );
        $this->add_control( 'mobile_filter_mode', array( 'label' => 'Phone Filter Behaviour', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.mobile_filter_mode', 'compact' ), 'options' => $mode_options ) );
        $this->add_control( 'mobile_quick_pills_limit', array( 'label' => 'Quick Pills Limit', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => (int) $this->tpl_setting( 'shop_page.mobile_quick_pills_limit', 8 ), 'min' => 0, 'max' => 20 ) );
        $this->end_controls_section();

        $this->start_controls_section( 'content_filters', array( 'label' => esc_html__( 'Filters / Toolbar', 'amaley-templates' ) ) );
        foreach ( array(
            'show_search' => 'Search', 'show_categories' => 'Categories', 'show_price' => 'Price', 'show_tags' => 'Tags', 'show_stock' => 'Stock', 'show_sort' => 'Sort', 'show_active_chips' => 'Active Chips',
            'show_attr_collection_type' => 'Collection Type Attribute', 'show_attr_core_ingredient' => 'Core Ingredient Attribute', 'show_attr_cluster' => 'Cluster Attribute', 'show_attr_producer_maker' => 'Producer / Maker Attribute', 'show_attr_region_cluster' => 'Region / Source Belt Attribute', 'show_attr_shg' => 'SHG Attribute', 'show_attr_use_case' => 'Use Case Attribute', 'show_attr_village_source_location' => 'Village / Source Location Attribute'
        ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => 'Show ' . $label, 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => $this->tpl_setting( 'shop_page.' . $key, 'yes' ), 'return_value' => 'yes' ) );
        }
        $this->add_control( 'pagination_type', array( 'label' => 'Pagination Type', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.pagination_type', 'numbers' ), 'options' => array( 'numbers' => 'Numbers', 'none' => 'None' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'content_labels', array( 'label' => esc_html__( 'Labels / Text', 'amaley-templates' ) ) );
        $label_controls = array(
            'filter_panel_kicker' => array( 'Filter Kicker', 'Refine' ),
            'filter_panel_title' => array( 'Filter Title', 'Choose your product' ),
            'filter_drawer_title' => array( 'Mobile Drawer Title', 'Filters' ),
            'mobile_filter_button_text' => array( 'Mobile Filter Button', 'Filter' ),
            'all_option_text' => array( 'All Option Text', 'All' ),
            'search_label' => array( 'Search Label', 'Search' ),
            'search_placeholder' => array( 'Search Placeholder', 'Search products...' ),
            'category_label' => array( 'Category Label', 'Category' ),
            'tag_label' => array( 'Tag Label', 'Tags' ),
            'price_label' => array( 'Price Label', 'Price' ),
            'min_price_placeholder' => array( 'Min Price Placeholder', 'Min' ),
            'max_price_placeholder' => array( 'Max Price Placeholder', 'Max' ),
            'stock_label' => array( 'Stock Label', 'Availability' ),
            'stock_any_label' => array( 'Any Stock Label', 'Any' ),
            'stock_in_label' => array( 'In Stock Label', 'In stock' ),
            'stock_out_label' => array( 'Out of Stock Label', 'Out of stock' ),
            'sort_label' => array( 'Sort Label', 'Sort' ),
            'apply_button_text' => array( 'Apply Button Text', 'Apply Filters' ),
            'reset_button_text' => array( 'Reset Button Text', 'Reset' ),
            'result_count_singular' => array( 'Result Count Singular', '{count} result found' ),
            'result_count_plural' => array( 'Result Count Plural', '{count} results found' ),
            'empty_state_title' => array( 'Empty Title', 'No products found' ),
            'empty_state_text' => array( 'Empty Text', 'Try changing your filters or search term.' ),
        );
        foreach ( $label_controls as $key => $data ) {
            $this->add_control( $key, array( 'label' => $data[0], 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.' . $key, $data[1] ), 'label_block' => true ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'content_attribute_labels', array( 'label' => esc_html__( 'Attribute Labels', 'amaley-templates' ) ) );
        foreach ( array(
            'collection_type_label' => 'Collection Type',
            'core_ingredient_label' => 'Core Ingredient',
            'cluster_label' => 'Cluster',
            'producer_maker_label' => 'Producer / Maker',
            'region_cluster_label' => 'Region / Source Belt',
            'shg_label' => 'SHG / Producer Group',
            'use_case_label' => 'Use Case',
            'village_source_location_label' => 'Village / Source Location',
        ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => $label, 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.' . $key, $label ), 'label_block' => true ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'content_card', array( 'label' => esc_html__( 'Product Card Renderer', 'amaley-templates' ) ) );
        $this->add_control( 'card_renderer', array( 'label' => 'Card Renderer', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $this->tpl_setting( 'shop_page.card_renderer', 'elementor_template' ), 'options' => array( 'elementor_template' => 'Existing Elementor Loop Item / Template', 'marketplace_card' => 'Discovery Native Marketplace Card', 'default' => 'Discovery Default Card' ) ) );
        $this->add_control( 'elementor_template_id', array( 'label' => 'Elementor Product Card Template ID', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => (int) $this->tpl_setting( 'shop_page.elementor_template_id', 0 ), 'description' => 'Use your existing OG Amaley Product Card Loop template ID. If empty or invalid, Discovery Engine will fallback safely.' ) );
        $this->add_control( 'marketplace_badge_text', array( 'label' => 'Native Card Badge Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Small Batch' ) );
        $this->add_control( 'marketplace_meta_text', array( 'label' => 'Native Card Small Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley Collection' ) );
        $this->end_controls_section();

        $this->add_box_controls( 'shell', 'Wrapper / Section', '.amaley-tpl-shop-discovery', true );
        $this->add_box_controls( 'de_root', 'Discovery Root', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1', true );
        $this->add_box_controls( 'inner', 'Inner Container', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__inner', true );
        $this->add_box_controls( 'layout', 'Main Layout / Grid Gap', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__layout', true );

        $this->start_controls_section( 'style_layout_gaps', array( 'label' => esc_html__( 'Layout Sizing / Gaps', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'layout_gap', array( 'label' => 'Sidebar/Product Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__layout' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sidebar_width', array( 'label' => 'Sidebar Width', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 180, 'max' => 420 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1' => '--ade-sidebar-width: {{SIZE}}{{UNIT}}; --ade-sidebar-min-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'grid_gap', array( 'label' => 'Product Grid Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'inner_max_width', array(
            'label' => 'Inner Max Width',
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 900, 'max' => 1600 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__inner' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'topbar_field_min_width', array(
            'label' => 'Top Filter Field Min Width',
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( 'px' => array( 'min' => 120, 'max' => 320 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1' => '--ade-topbar-field-min-width: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'sidebar_sticky_top', array(
            'label' => 'Desktop Sidebar Sticky Top',
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( 'px' => array( 'min' => 0, 'max' => 180 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1' => '--ade-sidebar-sticky-top: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'filter_actions_gap', array(
            'label' => 'Filter Button Gap',
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1' => '--ade-filter-actions-gap: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->end_controls_section();

        $this->add_text_controls( 'heading_kicker', 'Header Kicker', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__kicker' );
        $this->add_text_controls( 'heading_title', 'Header Heading', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__heading' );
        $this->add_box_controls( 'heading_wrap', 'Header Wrapper', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__heading-wrap', true );

        $this->add_box_controls( 'filter_panel', 'Filter Panel', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__filters', true );
        $this->add_box_controls( 'filter_panel_head', 'Filter Header Wrapper', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__filter-panel-head', true );
        $this->add_shop_text_controls( 'filter_kicker_text', 'Filter Kicker Text', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__filter-panel-kicker' );
        $this->add_shop_text_controls( 'filter_main_heading', 'Filter Main Heading', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__filter-panel-title' );
        $this->add_box_controls( 'filter_field', 'Filter Field Rows', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field', true );
        $this->add_shop_text_controls( 'field_label', 'Filter Field Labels', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field-label' );

        $this->start_controls_section( 'style_inputs', array( 'label' => esc_html__( 'Inputs / Selects', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $input_selector = '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field input, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field select';
        $this->add_control( 'input_text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $input_selector => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'input_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $input_selector => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'input_placeholder_color', array( 'label' => 'Placeholder Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field input::placeholder' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'input_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field input:hover, {{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field select:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'input_focus_bg', array( 'label' => 'Focus Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field input:focus, {{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field select:focus' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'input_focus_border', array( 'label' => 'Focus Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field input:focus, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__field select:focus' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'input_min_height', array( 'label' => 'Input Min Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 28, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} ' . $input_selector => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'input_typography', 'selector' => '{{WRAPPER}} ' . $input_selector ) );
        $this->add_responsive_control( 'input_padding', array( 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $input_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'input_margin', array( 'label' => 'Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $input_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'input_border', 'selector' => '{{WRAPPER}} ' . $input_selector ) );
        $this->add_responsive_control( 'input_radius', array( 'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $input_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->add_box_controls( 'price_row', 'Price Row', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__price-row', true );
        $this->add_box_controls( 'filter_actions', 'Filter Buttons Row', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__filter-actions', true );

        $this->start_controls_section( 'style_buttons', array( 'label' => esc_html__( 'Apply / Reset Buttons', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $button_selector = '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__apply, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__reset';
        $this->add_control( 'button_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $button_selector => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $button_selector => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_hover_color', array( 'label' => 'Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__apply:hover, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__reset:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__apply:hover, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__reset:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} ' . $button_selector ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $button_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_margin', array( 'label' => 'Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $button_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'button_border', 'selector' => '{{WRAPPER}} ' . $button_selector ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $button_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->add_box_controls( 'result_head', 'Result Count / Toolbar', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-head', true );
        $this->add_text_controls( 'result_count', 'Result Count Text', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-count' );
        $this->add_box_controls( 'sort_wrap', 'Sort Dropdown Wrapper', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort-wrap', true );
        $this->add_box_controls( 'active_chips', 'Active Filter Chips', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__chips, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__mobile-chips', true );
        $this->add_box_controls( 'quick_pills', 'Quick Category Pills', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__quick-pills', true );
        $this->add_box_controls( 'quick_pill', 'Quick Pill Item', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__quick-pill', true );
        $this->add_box_controls( 'results_wrap', 'Main Results Area', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__results-wrap', true );
        $this->add_box_controls( 'result_actions', 'Toolbar Actions Wrapper', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-actions', true );

        $this->start_controls_section( 'style_sort_select', array( 'label' => esc_html__( 'Sort Label / Select', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'sort_label_color', array( 'label' => 'Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort-label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'sort_label_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort-label' ) );
        $this->add_control( 'sort_select_color', array( 'label' => 'Select Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'sort_select_bg', array( 'label' => 'Select Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'sort_select_hover_bg', array( 'label' => 'Select Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'sort_select_focus_border', array( 'label' => 'Select Focus Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort:focus' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'sort_select_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort' ) );
        $this->add_responsive_control( 'sort_select_padding', array( 'label' => 'Select Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sort_select_margin', array( 'label' => 'Select Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'sort_select_border', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort' ) );
        $this->add_responsive_control( 'sort_select_radius', array( 'label' => 'Select Border Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__result-sort' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_chip_item', array( 'label' => esc_html__( 'Active Chip Item', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $chip_selector = '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__chip';
        $this->add_control( 'chip_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $chip_selector => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'chip_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $chip_selector => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'chip_hover_color', array( 'label' => 'Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $chip_selector . ':hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'chip_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $chip_selector . ':hover' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'chip_padding', array( 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $chip_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'chip_margin', array( 'label' => 'Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $chip_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'chip_border', 'selector' => '{{WRAPPER}} ' . $chip_selector ) );
        $this->add_responsive_control( 'chip_radius', array( 'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $chip_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_quick_pill_state', array( 'label' => esc_html__( 'Quick Pill States', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $pill_selector = '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__quick-pill';
        $this->add_control( 'pill_text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $pill_selector => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'pill_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $pill_selector => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'pill_hover_text_color', array( 'label' => 'Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $pill_selector . ':hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'pill_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $pill_selector . ':hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'pill_active_text_color', array( 'label' => 'Active Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $pill_selector . '.is-active' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'pill_active_bg', array( 'label' => 'Active Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $pill_selector . '.is-active' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->add_box_controls( 'grid', 'Product Grid', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__grid', true );
        $this->add_box_controls( 'template_card', 'Elementor Template Card Wrapper', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__template-card', true );

        $this->start_controls_section( 'style_template_card_hover', array( 'label' => esc_html__( 'Elementor Card Hover', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'template_card_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__template-card:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'template_card_hover_border', array( 'label' => 'Hover Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__template-card:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'template_card_hover_shadow', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__template-card:hover' ) );
        $this->add_responsive_control( 'template_card_hover_lift', array( 'label' => 'Hover Lift', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => -16, 'max' => 16 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__template-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});' ) ) );
        $this->end_controls_section();

        $this->add_box_controls( 'native_card', 'Native Product Card', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__card, .amaley-tpl-shop-discovery .amaley-native-product-card-v1', true );

        $this->start_controls_section( 'style_native_card_parts', array( 'label' => esc_html__( 'Native Card Parts', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'native_image_radius', array( 'label' => 'Image Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__image-wrap, {{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'native_image_height', array( 'label' => 'Image Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 120, 'max' => 520 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__image' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;' ) ) );
        $this->add_control( 'native_meta_color', array( 'label' => 'Meta Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__meta' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'native_title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__title, {{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__title a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'native_title_hover_color', array( 'label' => 'Title Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__title a:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'native_price_color', array( 'label' => 'Price Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__price' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'native_button_color', array( 'label' => 'Button Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'native_button_bg', array( 'label' => 'Button Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__button' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'native_button_hover_bg', array( 'label' => 'Button Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-discovery .amaley-native-product-card-v1__button:hover' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_mobile_toolbar_button', array( 'label' => esc_html__( 'Mobile Toolbar Buttons', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $mobile_button_selector = '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__mobile-filter-button';
        $this->add_control( 'mobile_button_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $mobile_button_selector => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'mobile_button_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $mobile_button_selector => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'mobile_button_hover_color', array( 'label' => 'Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $mobile_button_selector . ':hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'mobile_button_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} ' . $mobile_button_selector . ':hover' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'mobile_button_padding', array( 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $mobile_button_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'mobile_button_border', 'selector' => '{{WRAPPER}} ' . $mobile_button_selector ) );
        $this->add_responsive_control( 'mobile_button_radius', array( 'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} ' . $mobile_button_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->add_box_controls( 'mobile_count', 'Mobile Result Count', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__mobile-count', true );
        $this->add_box_controls( 'mobile_toolbar', 'Mobile Toolbar Wrapper', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__mobile-toolbar', true );
        $this->add_box_controls( 'drawer_head', 'Mobile Drawer Header', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__filter-drawer-head', true );
        $this->add_box_controls( 'drawer_backdrop', 'Mobile Drawer Backdrop', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__drawer-backdrop', false );
        $this->add_box_controls( 'pagination_link', 'Pagination Buttons', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__pagination a, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1__pagination span', true );
        $this->add_box_controls( 'mobile_bar', 'Mobile Filter Bar', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__mobile-bar', true );
        $this->add_box_controls( 'drawer', 'Mobile Drawer', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__filters.is-drawer, .amaley-tpl-shop-discovery .amaley-discovery-engine-v1--filter-drawer .amaley-discovery-engine-v1__filters', true );
        $this->add_box_controls( 'empty_state', 'Empty State', '.amaley-tpl-shop-discovery .amaley-discovery-engine-v1__empty', true );
    }

    protected function render() {
        if ( ! function_exists( 'amaley_de_bootstrap' ) || ! class_exists( 'Amaley_DE_Renderer' ) || ! class_exists( 'Amaley_DE_Query' ) ) {
            echo '<div class="amaley-tpl-editor-note">Amaley Shop Discovery needs the Amaley Discovery Engine plugin active. It will not affect WooCommerce products.</div>';
            return;
        }

        $s = $this->get_settings_for_display();
        $yesno = array( 'show_search', 'show_categories', 'show_price', 'show_tags', 'show_stock', 'show_sort', 'show_active_chips', 'show_attr_collection_type', 'show_attr_core_ingredient', 'show_attr_cluster', 'show_attr_producer_maker', 'show_attr_region_cluster', 'show_attr_shg', 'show_attr_use_case', 'show_attr_village_source_location' );
        $settings = array(
            'type' => 'products',
            'heading' => isset( $s['heading'] ) ? $s['heading'] : 'Shop Amaley',
            'kicker' => isset( $s['kicker'] ) ? $s['kicker'] : 'Filter by origin, ingredient and use',
            'per_page' => max( 1, absint( $s['per_page'] ) ),
            'columns_desktop' => absint( $s['columns_desktop'] ),
            'columns_tablet' => absint( $s['columns_tablet'] ),
            'columns_mobile' => absint( $s['columns_mobile'] ),
            'filter_position' => $s['desktop_filter_position'],
            'desktop_filter_position' => $s['desktop_filter_position'],
            'tablet_filter_position' => $s['tablet_filter_position'],
            'mobile_filter_position' => $s['mobile_filter_position'],
            'desktop_filter_mode' => $s['desktop_filter_mode'],
            'tablet_filter_mode' => $s['tablet_filter_mode'],
            'mobile_filter_mode' => $s['mobile_filter_mode'],
            'mobile_toolbar_layout' => 'filter_sort',
            'show_mobile_result_count' => 'yes',
            'show_mobile_quick_pills' => 'yes',
            'show_mobile_sort' => 'yes',
            'show_mobile_active_chips' => 'yes',
            'mobile_quick_pills_limit' => absint( $s['mobile_quick_pills_limit'] ?? 8 ),
            'show_result_count_desktop' => 'yes',
            'show_result_count_tablet' => 'yes',
            'show_result_count_mobile' => 'yes',
            'full_bleed' => 'yes',
            'inner_width' => 'none',
            'pagination_type' => $s['pagination_type'],
            'default_sort' => 'latest',
            'card_renderer' => $s['card_renderer'],
            'elementor_template_id' => absint( $s['elementor_template_id'] ),
            'marketplace_badge_text' => isset( $s['marketplace_badge_text'] ) ? $s['marketplace_badge_text'] : 'Small Batch',
            'marketplace_meta_text' => isset( $s['marketplace_meta_text'] ) ? $s['marketplace_meta_text'] : 'Amaley Collection',
            'custom_wrapper_class' => sanitize_html_class( isset( $s['custom_wrapper_class'] ) ? $s['custom_wrapper_class'] : 'amaley-tpl-shop-og' ),
            'section_padding_top' => 0,
            'section_padding_bottom' => 0,
            'section_padding_top_tablet' => 0,
            'section_padding_bottom_tablet' => 0,
            'section_padding_top_mobile' => 0,
            'section_padding_bottom_mobile' => 0,
        );

        foreach ( array(
            'filter_panel_kicker','filter_panel_title','filter_drawer_title','mobile_filter_button_text','all_option_text','search_label','search_placeholder','category_label','tag_label','price_label','min_price_placeholder','max_price_placeholder','stock_label','stock_any_label','stock_in_label','stock_out_label','sort_label','apply_button_text','reset_button_text','result_count_singular','result_count_plural','empty_state_title','empty_state_text','collection_type_label','core_ingredient_label','cluster_label','producer_maker_label','region_cluster_label','shg_label','use_case_label','village_source_location_label'
        ) as $text_key ) {
            if ( isset( $s[ $text_key ] ) ) {
                $settings[ $text_key ] = $s[ $text_key ];
            }
        }

        $settings['show_filter_panel_title'] = 'yes';

        foreach ( $yesno as $key ) {
            $settings[ $key ] = ( isset( $s[ $key ] ) && 'yes' === $s[ $key ] ) ? 'yes' : 'no';
        }
        $renderer = new Amaley_DE_Renderer( new Amaley_DE_Query() );
        echo '<div class="amaley-tpl-shop-discovery">';
        echo $renderer->render( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</div>';
    }
}
