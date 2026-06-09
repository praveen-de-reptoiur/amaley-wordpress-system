<?php
/**
 * Amaley Member Single Products Elementor widget — clean scoped controls.
 *
 * v1.0.140-clean-og-product-card-controls
 * - Single Member / Producer detail page: Related Products section only.
 * - Keeps product query, mapping, pagination and render logic unchanged.
 * - Cleans Elementor panel labels so only product-section controls appear here.
 * - Splits Section Button from Product Card Button to avoid selector bleed.
 * - Keeps OG Product Card 1 controls separate from Current Product Card controls.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Single_Products_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_member_single_products'; }
    public function get_title() { return esc_html__( 'Amaley Member Single Products', 'amaley-core' ); }
    public function get_icon() { return 'eicon-products'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'member', 'producer', 'single', 'products' ); }

    protected function register_controls() {
        $defaults = $this->defaults_for( 'products_defaults' );

        $this->register_source_controls( $defaults );
        $this->register_content_controls( $defaults );

        $this->register_common_style_controls( '.amms-products' );
        $this->register_product_grid_layout_controls( '.amms-products' );

        /*
         * v1.0.140: Clean controls only for the real rendered OG product card.
         * The old Current/Legacy card controls are intentionally not registered.
         */
        $this->register_og_card_clean_controls( '.amms-products' );

        $this->register_pagination_style_controls( '.amms-products' );
    }

    private function renderer_instance() {
        return isset( $GLOBALS['amaley_core_member_single_sections'] ) && $GLOBALS['amaley_core_member_single_sections'] instanceof Amaley_Core_Member_Single_Sections ? $GLOBALS['amaley_core_member_single_sections'] : new Amaley_Core_Member_Single_Sections();
    }

    private function defaults_for( $method ) {
        $renderer = $this->renderer_instance();
        return method_exists( $renderer, $method ) ? $renderer->$method() : $renderer->base_defaults();
    }


    private function add_select_if( $defaults, $key, $label, $options, $condition = array() ) {
        if ( array_key_exists( $key, $defaults ) ) {
            $args = array(
                'label' => esc_html__( $label, 'amaley-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => $defaults[ $key ],
                'options' => $options,
            );
            if ( ! empty( $condition ) ) {
                $args['condition'] = $condition;
            }
            $this->add_control( $key, $args );
        }
    }

    private function add_switch_if( $defaults, $key, $label ) {
        if ( array_key_exists( $key, $defaults ) ) {
            $this->add_control( $key, array(
                'label' => esc_html__( $label, 'amaley-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'amaley-core' ),
                'label_off' => esc_html__( 'Hide', 'amaley-core' ),
                'return_value' => '1',
                'default' => $defaults[ $key ],
            ) );
        }
    }

    private function add_text_if( $defaults, $key, $label, $type = 'TEXT' ) {
        if ( array_key_exists( $key, $defaults ) ) {
            $control_type = ( 'TEXTAREA' === $type ) ? \Elementor\Controls_Manager::TEXTAREA : \Elementor\Controls_Manager::TEXT;
            $this->add_control( $key, array(
                'label' => esc_html__( $label, 'amaley-core' ),
                'type' => $control_type,
                'default' => $defaults[ $key ],
            ) );
        }
    }

    private function add_number_if( $defaults, $key, $label, $min = 1, $max = 24 ) {
        if ( array_key_exists( $key, $defaults ) ) {
            $this->add_control( $key, array(
                'label' => esc_html__( $label, 'amaley-core' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => $defaults[ $key ],
                'min' => $min,
                'max' => $max,
            ) );
        }
    }

    private function register_source_controls( $defaults ) {
        $this->start_controls_section( 'source_section', array( 'label' => esc_html__( 'Product Data / Preview Source', 'amaley-core' ) ) );
        $this->add_control( 'auto_detect', array( 'label' => esc_html__( 'Auto Detect from URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => 'Yes', 'label_off' => 'No', 'return_value' => '1', 'default' => isset( $defaults['auto_detect'] ) ? $defaults['auto_detect'] : '1' ) );
        $this->add_control( 'preview_member_id', array( 'label' => esc_html__( 'Preview Member ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => '', 'description' => esc_html__( 'Use in Elementor editor if URL auto-detect is empty.', 'amaley-core' ) ) );
        $this->add_control( 'member_id', array( 'label' => esc_html__( 'Fixed Member ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => '' ) );
        $this->add_control( 'member_slug', array( 'label' => esc_html__( 'Fixed Member Slug', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Product Fallback / Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => isset( $defaults['empty_message'] ) ? $defaults['empty_message'] : '' ) );
        $this->end_controls_section();
    }

    private function register_content_controls( $defaults ) {
        $this->start_controls_section( 'content_section', array(
            'label' => esc_html__( 'Product Content / Display', 'amaley-core' ),
        ) );

        $this->add_control( 'product_card_locked_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => esc_html__( 'Product cards use the existing Amaley OG Product Card renderer. This keeps the card design stable; controls below only show/hide content and adjust real OG card styling.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_switch_if( $defaults, 'show_section', 'Show Full Section' );

        $this->add_control( 'section_heading_content', array(
            'label' => esc_html__( 'Section Heading', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_switch_if( $defaults, 'show_label', 'Show Section Label / Eyebrow' );
        $this->add_text_if( $defaults, 'label', 'Section Label Text' );
        $this->add_switch_if( $defaults, 'show_title', 'Show Section Heading' );
        $this->add_text_if( $defaults, 'title', 'Section Heading Text' );
        $this->add_switch_if( $defaults, 'show_description', 'Show Section Description' );
        $this->add_text_if( $defaults, 'description', 'Section Description Text', 'TEXTAREA' );

        $this->add_control( 'product_list_content', array(
            'label' => esc_html__( 'Product List', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_number_if( $defaults, 'limit', 'Products Per Page', 1, 24 );
        $this->add_switch_if( $defaults, 'enable_pagination', 'Enable Pagination' );
        $this->add_text_if( $defaults, 'pagination_prev_text', 'Pagination Previous Text' );
        $this->add_text_if( $defaults, 'pagination_next_text', 'Pagination Next Text' );

        $this->add_control( 'product_card_content', array(
            'label' => esc_html__( 'OG Product Card Content', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_switch_if( $defaults, 'show_product_image', 'Show Product Image' );
        $this->add_switch_if( $defaults, 'show_product_label', 'Show Product Label' );
        $this->add_text_if( $defaults, 'product_label_text', 'Product Label Text' );
        $this->add_switch_if( $defaults, 'show_product_excerpt', 'Show Product Description / Excerpt' );
        $this->add_number_if( $defaults, 'product_excerpt_words', 'Product Description Word Limit', 6, 40 );
        $this->add_switch_if( $defaults, 'show_product_meta', 'Show Product Price / Origin Boxes' );
        $this->add_switch_if( $defaults, 'show_product_chips', 'Show Product Traceability Chips' );
        $this->add_switch_if( $defaults, 'show_product_button', 'Show Product Card Button' );
        $this->add_switch_if( $defaults, 'show_fallback_tags', 'Show Fallback Product Tags' );

        $this->add_control( 'section_button_content', array(
            'label' => esc_html__( 'Section Button', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_switch_if( $defaults, 'show_section_button', 'Show Section Button' );
        $this->add_text_if( $defaults, 'section_button_text', 'Section Button Text' );
        $this->add_text_if( $defaults, 'section_button_url', 'Section Button URL' );

        $this->end_controls_section();
    }

    private function register_common_style_controls( $section_selector ) {
        $s = '{{WRAPPER}} ' . $section_selector;

        $this->start_controls_section( 'style_section_shell', array(
            'label' => esc_html__( 'Product Section / Background', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'section_background', 'selector' => $s ) );
        $this->add_responsive_control( 'section_padding', array(
            'label' => esc_html__( 'Section Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors' => array( $s => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'section_min_height', array(
            'label' => esc_html__( 'Minimum Height', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 900 ), 'vh' => array( 'min' => 0, 'max' => 100 ) ),
            'selectors' => array( $s => 'min-height: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'wrap_width', array(
            'label' => esc_html__( 'Content Width', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range' => array( 'px' => array( 'min' => 320, 'max' => 1600 ), '%' => array( 'min' => 40, 'max' => 100 ) ),
            'selectors' => array( $s . ' .amms-wrap' => 'width: min({{SIZE}}{{UNIT}}, 100%);' ),
        ) );
        $this->add_responsive_control( 'section_align', array(
            'label' => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( $s => 'text-align: {{VALUE}};' ),
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_heading_block', array(
            'label' => esc_html__( 'Product Heading / Text', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );
        $this->add_responsive_control( 'head_width', array(
            'label' => esc_html__( 'Heading Block Width', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range' => array( 'px' => array( 'min' => 220, 'max' => 1200 ), '%' => array( 'min' => 30, 'max' => 100 ) ),
            'selectors' => array( $s . ' .amms-section-head' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'head_margin', array(
            'label' => esc_html__( 'Heading Block Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors' => array( $s . ' .amms-section-head' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->add_control( 'divider_color', array(
            'label' => esc_html__( 'Divider Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-head:after, ' . $s . ' .amms-story-card:before' => 'background: {{VALUE}};' ),
        ) );
        $this->add_responsive_control( 'divider_width', array(
            'label' => esc_html__( 'Divider / Accent Width', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 220 ) ),
            'selectors' => array( $s . ' .amms-section-head:after, ' . $s . ' .amms-story-card:before' => 'width: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_control( 'label_heading', array( 'label' => esc_html__( 'Label / Eyebrow', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'selector' => $s . ' .amms-section-head .amms-kicker' ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-section-head .amms-kicker' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'label_spacing', array( 'label' => esc_html__( 'Label Bottom Spacing', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $s . ' .amms-section-head .amms-kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'label_margin_box', array( 'label' => esc_html__( 'Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-section-head .amms-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'title_heading', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => $s . ' .amms-title, ' . $s . ' .amms-section-title' ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-title, ' . $s . ' .amms-section-title' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'title_width', array( 'label' => esc_html__( 'Heading Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 1200 ), '%' => array( 'min' => 30, 'max' => 100 ) ), 'selectors' => array( $s . ' .amms-title, ' . $s . ' .amms-section-title' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'title_margin_box', array( 'label' => esc_html__( 'Heading Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-title, ' . $s . ' .amms-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'desc_heading', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'desc_typography', 'selector' => $s . ' .amms-description, ' . $s . ' .amms-section-desc' ) );
        $this->add_control( 'desc_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-description, ' . $s . ' .amms-section-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'desc_width', array( 'label' => esc_html__( 'Description Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 1200 ), '%' => array( 'min' => 30, 'max' => 100 ) ), 'selectors' => array( $s . ' .amms-description, ' . $s . ' .amms-section-desc' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'desc_margin_box', array( 'label' => esc_html__( 'Description Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-description, ' . $s . ' .amms-section-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_section_button', array(
            'label' => esc_html__( 'Product Section Button', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'show_section_button' => '1' ),
        ) );

        $this->add_responsive_control( 'section_button_align', array(
            'label' => esc_html__( 'Button Alignment', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( $s . ' .amms-section-actions' => 'display:flex;justify-content:{{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'section_button_margin', array(
            'label' => esc_html__( 'Button Wrapper Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors' => array( $s . ' .amms-section-actions' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'section_button_typography',
            'selector' => $s . ' .amms-section-button',
        ) );

        $this->add_responsive_control( 'section_button_padding', array(
            'label' => esc_html__( 'Button Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amms-section-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'section_button_radius', array(
            'label' => esc_html__( 'Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amms-section-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->start_controls_tabs( 'section_button_tabs' );
        $this->start_controls_tab( 'section_button_normal_tab', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'section_button_text_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-button' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'section_button_background', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-button' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'section_button_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-button' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'section_button_hover_tab', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'section_button_hover_text_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-button:hover' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'section_button_hover_background', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-button:hover' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'section_button_hover_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-button:hover' => 'border-color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'section_button_hover_shadow',
            'selector' => $s . ' .amms-section-button:hover',
        ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section( 'style_fallback', array(
            'label' => esc_html__( 'Product Fallback / Empty Message', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'empty_typography', 'selector' => $s . ' .amms-empty' ) );
        $this->add_control( 'empty_color', array( 'label' => esc_html__( 'Message Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-empty' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'empty_background', 'selector' => $s . ' .amms-empty' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'empty_border', 'selector' => $s . ' .amms-empty' ) );
        $this->add_responsive_control( 'empty_padding', array( 'label' => esc_html__( 'Message Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }


    private function register_product_grid_layout_controls( $section_selector ) {
        $s = '{{WRAPPER}} #amms-member-products.amms-products';

        $this->start_controls_section( 'style_product_grid_layout', array(
            'label' => esc_html__( 'Product Grid / Layout', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'product_grid_layout_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => esc_html__( 'These controls affect the product grid container. Responsive columns are applied by the renderer so desktop settings do not squeeze tablet/mobile.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_control( 'product_desktop_columns_fixed', array(
            'label' => esc_html__( 'Desktop Columns', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '4',
            'options' => array(
                '1' => esc_html__( '1 Column', 'amaley-core' ),
                '2' => esc_html__( '2 Columns', 'amaley-core' ),
                '3' => esc_html__( '3 Columns', 'amaley-core' ),
                '4' => esc_html__( '4 Columns — Recommended', 'amaley-core' ),
            ),
        ) );

        $this->add_control( 'product_tablet_columns_fixed', array(
            'label' => esc_html__( 'Tablet Columns', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '2',
            'options' => array(
                '1' => esc_html__( '1 Column', 'amaley-core' ),
                '2' => esc_html__( '2 Columns — Recommended', 'amaley-core' ),
                '3' => esc_html__( '3 Columns — Compact', 'amaley-core' ),
            ),
        ) );

        $this->add_control( 'product_mobile_columns_fixed', array(
            'label' => esc_html__( 'Mobile Columns', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '1',
            'options' => array(
                '1' => esc_html__( '1 Column — Recommended', 'amaley-core' ),
                '2' => esc_html__( '2 Columns — Very Compact', 'amaley-core' ),
            ),
        ) );

        $this->add_responsive_control( 'product_grid_gap_safe', array(
            'label' => esc_html__( 'Card Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'default' => array( 'size' => 24, 'unit' => 'px' ),
            'selectors' => array(
                $s . ' .amms-product-grid' => 'gap: {{SIZE}}{{UNIT}} !important;',
            ),
        ) );

        $this->add_responsive_control( 'product_wrap_max_width', array(
            'label' => esc_html__( 'Grid Max Width', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range' => array(
                'px' => array( 'min' => 720, 'max' => 1600 ),
                '%'  => array( 'min' => 60, 'max' => 100 ),
            ),
            'selectors' => array(
                $s . ' .amms-wrap' => 'max-width: {{SIZE}}{{UNIT}} !important;',
            ),
        ) );

        $this->add_responsive_control( 'product_wrap_padding', array(
            'label' => esc_html__( 'Grid Side Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'allowed_dimensions' => 'horizontal',
            'selectors' => array(
                $s . ' .amms-wrap' => 'padding-left: {{LEFT}}{{UNIT}} !important; padding-right: {{RIGHT}}{{UNIT}} !important;',
            ),
        ) );

        $this->end_controls_section();
    }


    private function register_og_card_clean_controls( $section_selector ) {
        $s = '{{WRAPPER}} #amms-member-products.amms-products';

        $card_selector   = $s . ' .amaley-card';
        $media_selector  = $s . ' .amaley-card__media';
        $body_selector   = $s . ' .amaley-card__body';
        $label_selector  = $s . ' .amaley-card__label';
        $title_selector  = $s . ' .amaley-card__title';
        $desc_selector   = $s . ' .amaley-card__excerpt';
        $meta_selector   = $s . ' .amaley-card__meta';
        $meta_item       = $s . ' .amaley-card__meta-item';
        $tag_selector    = $s . ' .amaley-card__tags span';
        $button_selector = $s . ' .amaley-card__button';

        $this->start_controls_section( 'style_og_card_box_image', array(
            'label' => esc_html__( 'OG Product Card / Box & Image', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name' => 'og_card_background',
            'label' => esc_html__( 'Card Background', 'amaley-core' ),
            'selector' => $card_selector,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'og_card_border',
            'label' => esc_html__( 'Card Border', 'amaley-core' ),
            'selector' => $card_selector,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'og_card_shadow',
            'label' => esc_html__( 'Card Shadow', 'amaley-core' ),
            'selector' => $card_selector,
        ) );

        $this->add_responsive_control( 'og_card_radius', array(
            'label' => esc_html__( 'Card Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $card_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_card_body_padding', array(
            'label' => esc_html__( 'Card Body Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $body_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_card_inner_gap', array(
            'label' => esc_html__( 'Card Inner Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 48 ) ),
            'selectors' => array( $body_selector => 'gap: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'og_media_heading', array(
            'label' => esc_html__( 'Image Area', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_responsive_control( 'og_media_height', array(
            'label' => esc_html__( 'Image Height', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 80, 'max' => 520 ) ),
            'selectors' => array( $media_selector => 'height: {{SIZE}}{{UNIT}} !important; min-height: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'og_media_bg', array(
            'label' => esc_html__( 'Image Area Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $media_selector => 'background: {{VALUE}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_media_radius', array(
            'label' => esc_html__( 'Image Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $media_selector . ', ' . $media_selector . ' img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_og_card_text', array(
            'label' => esc_html__( 'OG Product Card / Text', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'og_label_heading', array(
            'label' => esc_html__( 'Label', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_label_typography',
            'label' => esc_html__( 'Label Typography', 'amaley-core' ),
            'selector' => $label_selector,
        ) );

        $this->add_control( 'og_label_color', array(
            'label' => esc_html__( 'Label Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $label_selector => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_label_margin', array(
            'label' => esc_html__( 'Label Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $label_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'og_title_heading', array(
            'label' => esc_html__( 'Title', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_title_typography',
            'label' => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => $title_selector,
        ) );

        $this->add_control( 'og_title_color', array(
            'label' => esc_html__( 'Title Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $title_selector => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_title_margin', array(
            'label' => esc_html__( 'Title Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $title_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'og_desc_heading', array(
            'label' => esc_html__( 'Description', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_excerpt_typography',
            'label' => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => $desc_selector,
        ) );

        $this->add_control( 'og_excerpt_color', array(
            'label' => esc_html__( 'Description Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $desc_selector => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_excerpt_margin', array(
            'label' => esc_html__( 'Description Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $desc_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_excerpt_min_height', array(
            'label' => esc_html__( 'Description Min Height', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 180 ) ),
            'selectors' => array( $desc_selector => 'min-height: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_og_card_meta_chips', array(
            'label' => esc_html__( 'OG Product Card / Meta & Chips', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'og_meta_heading', array(
            'label' => esc_html__( 'Price / Origin Boxes', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_responsive_control( 'og_meta_columns', array(
            'label' => esc_html__( 'Meta Box Columns', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 4,
            'selectors' => array( $meta_selector => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr)) !important;' ),
        ) );

        $this->add_responsive_control( 'og_meta_gap', array(
            'label' => esc_html__( 'Meta Box Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( $meta_selector => 'gap: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'og_meta_bg', array(
            'label' => esc_html__( 'Meta Box Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $meta_item => 'background: {{VALUE}} !important;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'og_meta_border',
            'label' => esc_html__( 'Meta Box Border', 'amaley-core' ),
            'selector' => $meta_item,
        ) );

        $this->add_responsive_control( 'og_meta_padding', array(
            'label' => esc_html__( 'Meta Box Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $meta_item => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_meta_radius', array(
            'label' => esc_html__( 'Meta Box Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $meta_item => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_meta_label_typography',
            'label' => esc_html__( 'Meta Label Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__meta span',
        ) );

        $this->add_control( 'og_meta_label_color', array(
            'label' => esc_html__( 'Meta Label Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__meta span' => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_meta_value_typography',
            'label' => esc_html__( 'Meta Value Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__meta strong',
        ) );

        $this->add_control( 'og_meta_value_color', array(
            'label' => esc_html__( 'Meta Value Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__meta strong' => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_control( 'og_tags_heading', array(
            'label' => esc_html__( 'Traceability Chips', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_responsive_control( 'og_tags_gap', array(
            'label' => esc_html__( 'Chip Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( $s . ' .amaley-card__tags' => 'gap: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_tags_typography',
            'label' => esc_html__( 'Chip Typography', 'amaley-core' ),
            'selector' => $tag_selector,
        ) );

        $this->add_control( 'og_tags_color', array(
            'label' => esc_html__( 'Chip Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $tag_selector => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_control( 'og_tags_bg', array(
            'label' => esc_html__( 'Chip Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $tag_selector => 'background: {{VALUE}} !important;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'og_tags_border',
            'label' => esc_html__( 'Chip Border', 'amaley-core' ),
            'selector' => $tag_selector,
        ) );

        $this->add_responsive_control( 'og_tags_padding', array(
            'label' => esc_html__( 'Chip Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $tag_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_tags_radius', array(
            'label' => esc_html__( 'Chip Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $tag_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_og_card_button', array(
            'label' => esc_html__( 'OG Product Card / Button', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_button_typography',
            'label' => esc_html__( 'Button Typography', 'amaley-core' ),
            'selector' => $button_selector,
        ) );

        $this->start_controls_tabs( 'og_button_tabs' );

        $this->start_controls_tab( 'og_button_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'og_button_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $button_selector => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_control( 'og_button_bg', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $button_selector => 'background: {{VALUE}} !important;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'og_button_border',
            'label' => esc_html__( 'Border', 'amaley-core' ),
            'selector' => $button_selector,
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'og_button_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'og_button_hover_color', array(
            'label' => esc_html__( 'Hover Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $button_selector . ':hover' => 'color: {{VALUE}} !important;' ),
        ) );

        $this->add_control( 'og_button_hover_bg', array(
            'label' => esc_html__( 'Hover Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $button_selector . ':hover' => 'background: {{VALUE}} !important;' ),
        ) );

        $this->add_control( 'og_button_hover_border_color', array(
            'label' => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $button_selector . ':hover' => 'border-color: {{VALUE}} !important;' ),
        ) );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control( 'og_button_padding', array(
            'label' => esc_html__( 'Button Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'separator' => 'before',
            'selectors' => array( $button_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_button_radius', array(
            'label' => esc_html__( 'Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $button_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'og_button_margin', array(
            'label' => esc_html__( 'Button Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $button_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();
    }

    private function register_specific_style_controls( $section_selector ) {
        $s = '{{WRAPPER}} ' . $section_selector;
        $this->start_controls_section( 'style_product_cards', array(
            'label' => esc_html__( 'Current Product Card / Grid / Text / Meta', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'current_existing' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'product_card_background', 'selector' => $s . ' .amms-product-card, ' . $s . ' .amaley-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'product_card_border', 'selector' => $s . ' .amms-product-card, ' . $s . ' .amaley-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'product_card_shadow', 'selector' => $s . ' .amms-product-card, ' . $s . ' .amaley-card' ) );
        $this->add_responsive_control( 'product_card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-product-card, ' . $s . ' .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_body_padding', array( 'label' => esc_html__( 'Card Body Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-product-body, ' . $s . ' .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_card_margin', array( 'label' => esc_html__( 'Card Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-product-card, ' . $s . ' .amaley-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'product_image_heading', array( 'label' => esc_html__( 'Product Image', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'product_image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 520 ) ), 'selectors' => array( $s . ' .amms-product-media, ' . $s . ' .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-product-media, ' . $s . ' .amaley-card__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'product_text_heading', array( 'label' => esc_html__( 'Product Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'product_title_typography', 'selector' => $s . ' .amms-product-body h3, ' . $s . ' .amaley-card__title' ) );
        $this->add_control( 'product_title_color', array( 'label' => esc_html__( 'Product Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-product-body h3, ' . $s . ' .amaley-card__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'product_excerpt_heading', array( 'label' => esc_html__( 'Product Description / Excerpt', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'product_excerpt_typography', 'selector' => $s . ' .amms-product-excerpt, ' . $s . ' .amaley-card__excerpt' ) );
        $this->add_control( 'product_excerpt_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-product-excerpt, ' . $s . ' .amaley-card__excerpt' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'product_excerpt_margin', array( 'label' => esc_html__( 'Description Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-product-excerpt, ' . $s . ' .amaley-card__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );

        $this->add_control( 'product_meta_heading', array( 'label' => esc_html__( 'Price / Origin Stat Boxes', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'product_meta_gap', array( 'label' => esc_html__( 'Meta Box Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( $s . ' .amms-product-meta, ' . $s . ' .amaley-card__meta' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'product_meta_bg', array( 'label' => esc_html__( 'Meta Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-product-meta div, ' . $s . ' .amaley-card__meta-item' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'product_meta_padding', array( 'label' => esc_html__( 'Meta Box Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-product-meta div, ' . $s . ' .amaley-card__meta-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_meta_margin', array( 'label' => esc_html__( 'Meta Box Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-product-meta div, ' . $s . ' .amaley-card__meta-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_meta_radius', array( 'label' => esc_html__( 'Meta Box Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-product-meta div, ' . $s . ' .amaley-card__meta-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_meta_min_height', array( 'label' => esc_html__( 'Meta Box Min Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 220 ) ), 'selectors' => array( $s . ' .amms-product-meta div, ' . $s . ' .amaley-card__meta-item' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_meta_columns', array( 'label' => esc_html__( 'Meta Box Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 3, 'default' => 1, 'tablet_default' => 1, 'mobile_default' => 1, 'description' => esc_html__( 'For 4 product cards in one row, keep this as 1 so Price and Origin boxes do not squeeze.', 'amaley-core' ), 'selectors' => array( $s . ' .amms-product-meta, ' . $s . ' .amaley-card__meta' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'product_meta_border', 'selector' => $s . ' .amms-product-meta div, ' . $s . ' .amaley-card__meta-item' ) );
        $this->add_control( 'product_tags_heading', array( 'label' => esc_html__( 'Tags / Fallback Tags', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'product_tag_gap', array( 'label' => esc_html__( 'Tag Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $s . ' .amms-chip-row, ' . $s . ' .amms-product-fallback, ' . $s . ' .amaley-card__tags' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'product_tag_typography', 'selector' => $s . ' .amms-chip-row span, ' . $s . ' .amms-product-fallback span, ' . $s . ' .amaley-card__tags span' ) );
        $this->add_control( 'product_tag_color', array( 'label' => esc_html__( 'Tag Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-chip-row span, ' . $s . ' .amms-product-fallback span, ' . $s . ' .amaley-card__tags span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'product_tag_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-chip-row span, ' . $s . ' .amms-product-fallback span, ' . $s . ' .amaley-card__tags span' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'product_tag_padding', array( 'label' => esc_html__( 'Tag Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-chip-row span, ' . $s . ' .amms-product-fallback span, ' . $s . ' .amaley-card__tags span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_tag_margin', array( 'label' => esc_html__( 'Tag Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-chip-row span, ' . $s . ' .amms-product-fallback span, ' . $s . ' .amaley-card__tags span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'product_tag_radius', array( 'label' => esc_html__( 'Tag Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-chip-row span, ' . $s . ' .amms-product-fallback span, ' . $s . ' .amaley-card__tags span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );


        $this->add_control( 'product_card_button_heading', array(
            'label' => esc_html__( 'Product Card Button', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'product_button_typography',
            'selector' => $s . ' .amms-product-button',
        ) );

        $this->add_responsive_control( 'product_button_padding', array(
            'label' => esc_html__( 'Button Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amms-product-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'product_button_margin', array(
            'label' => esc_html__( 'Button Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amms-product-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'product_button_radius', array(
            'label' => esc_html__( 'Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amms-product-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->start_controls_tabs( 'product_button_tabs' );
        $this->start_controls_tab( 'product_button_normal_tab', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'product_button_text_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-product-button' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'product_button_background', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-product-button' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'product_button_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-product-button' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'product_button_hover_tab', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'product_button_hover_text_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-product-button:hover' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'product_button_hover_background', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-product-button:hover' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'product_button_hover_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-product-button:hover' => 'border-color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'product_button_hover_shadow',
            'selector' => $s . ' .amms-product-button:hover',
        ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    private function register_og_card_fine_controls( $section_selector ) {
        $s = '{{WRAPPER}} ' . $section_selector;

        $this->start_controls_section( 'style_og_card_fine_controls', array(
            'label' => esc_html__( 'OG Product Card 1 Controls', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'og_card_1' ),
        ) );

        $this->add_control( 'og_card_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'These controls target OG Product Card 1 only. Current product card controls stay separate to keep the editor clean.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_control( 'og_box_heading', array( 'label' => esc_html__( 'Card Box', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name' => 'og_card_background',
            'label' => esc_html__( 'Card Background', 'amaley-core' ),
            'selector' => $s . ' .amaley-card',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'og_card_border',
            'label' => esc_html__( 'Card Border', 'amaley-core' ),
            'selector' => $s . ' .amaley-card',
        ) );

        $this->add_responsive_control( 'og_card_radius', array(
            'label' => esc_html__( 'Card Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'og_card_shadow',
            'label' => esc_html__( 'Card Shadow', 'amaley-core' ),
            'selector' => $s . ' .amaley-card',
        ) );

        $this->add_responsive_control( 'og_card_body_padding', array(
            'label' => esc_html__( 'Card Body Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_card_inner_gap', array(
            'label' => esc_html__( 'Card Inner Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( $s . ' .amaley-card__body' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_media_heading', array( 'label' => esc_html__( 'Image / Placeholder Area', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_responsive_control( 'og_media_height', array(
            'label' => esc_html__( 'Image / Placeholder Height', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 60, 'max' => 520 ) ),
            'selectors' => array( $s . ' .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_media_radius', array(
            'label' => esc_html__( 'Image / Placeholder Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amaley-card__media, ' . $s . ' .amaley-card__media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_media_bg', array(
            'label' => esc_html__( 'Placeholder Area Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__media' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'og_initials_bg', array(
            'label' => esc_html__( 'Initials Circle Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__initials' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'og_initials_color', array(
            'label' => esc_html__( 'Initials Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__initials' => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_initials_typography',
            'label' => esc_html__( 'Initials Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__initials',
        ) );

        $this->add_control( 'og_label_heading', array( 'label' => esc_html__( 'Card Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_label_typography',
            'label' => esc_html__( 'Label Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__label',
        ) );

        $this->add_control( 'og_label_color', array(
            'label' => esc_html__( 'Label Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__label' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'og_label_margin', array(
            'label' => esc_html__( 'Label Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_title_heading', array( 'label' => esc_html__( 'Card Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_title_typography',
            'label' => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__title',
        ) );

        $this->add_control( 'og_title_color', array(
            'label' => esc_html__( 'Title Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__title' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'og_title_margin', array(
            'label' => esc_html__( 'Title Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_excerpt_heading', array( 'label' => esc_html__( 'Card Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_excerpt_typography',
            'label' => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__excerpt',
        ) );

        $this->add_control( 'og_excerpt_color', array(
            'label' => esc_html__( 'Description Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__excerpt' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'og_excerpt_margin', array(
            'label' => esc_html__( 'Description Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_excerpt_min_height', array(
            'label' => esc_html__( 'Description Min Height', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 180 ) ),
            'selectors' => array( $s . ' .amaley-card__excerpt' => 'min-height: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_meta_heading', array( 'label' => esc_html__( 'Meta / Stat Boxes', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_responsive_control( 'og_meta_gap', array(
            'label' => esc_html__( 'Meta Box Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( $s . ' .amaley-card__meta' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_meta_columns', array(
            'label' => esc_html__( 'Meta Box Columns', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 4,
            'selectors' => array( $s . ' .amaley-card__meta' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ),
        ) );

        $this->add_control( 'og_meta_bg', array(
            'label' => esc_html__( 'Meta Box Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__meta-item' => 'background: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'og_meta_border',
            'label' => esc_html__( 'Meta Box Border', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__meta-item',
        ) );

        $this->add_responsive_control( 'og_meta_padding', array(
            'label' => esc_html__( 'Meta Box Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__meta-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_meta_radius', array(
            'label' => esc_html__( 'Meta Box Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amaley-card__meta-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_meta_min_height', array(
            'label' => esc_html__( 'Meta Box Min Height', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 180 ) ),
            'selectors' => array( $s . ' .amaley-card__meta-item' => 'min-height: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_meta_label_typography',
            'label' => esc_html__( 'Meta Label Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__meta span',
        ) );

        $this->add_control( 'og_meta_label_color', array(
            'label' => esc_html__( 'Meta Label Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__meta span' => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_meta_value_typography',
            'label' => esc_html__( 'Meta Value Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__meta strong',
        ) );

        $this->add_control( 'og_meta_value_color', array(
            'label' => esc_html__( 'Meta Value Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__meta strong' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'og_tags_heading', array( 'label' => esc_html__( 'Tags / Chips', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_responsive_control( 'og_tags_gap', array(
            'label' => esc_html__( 'Tags Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( $s . ' .amaley-card__tags' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_tags_typography',
            'label' => esc_html__( 'Tags Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__tags span',
        ) );

        $this->add_control( 'og_tags_color', array(
            'label' => esc_html__( 'Tags Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__tags span' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'og_tags_bg', array(
            'label' => esc_html__( 'Tags Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__tags span' => 'background: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'og_tags_border',
            'label' => esc_html__( 'Tags Border', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__tags span',
        ) );

        $this->add_responsive_control( 'og_tags_padding', array(
            'label' => esc_html__( 'Tags Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__tags span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_tags_radius', array(
            'label' => esc_html__( 'Tags Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amaley-card__tags span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_button_heading', array( 'label' => esc_html__( 'Card Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'og_button_typography',
            'label' => esc_html__( 'Button Typography', 'amaley-core' ),
            'selector' => $s . ' .amaley-card__button',
        ) );

        $this->add_control( 'og_button_color', array(
            'label' => esc_html__( 'Button Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__button' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'og_button_bg', array(
            'label' => esc_html__( 'Button Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__button' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'og_button_hover_color', array(
            'label' => esc_html__( 'Button Hover Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__button:hover' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'og_button_hover_bg', array(
            'label' => esc_html__( 'Button Hover Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amaley-card__button:hover' => 'background: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'og_button_padding', array(
            'label' => esc_html__( 'Button Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_button_radius', array(
            'label' => esc_html__( 'Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amaley-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_button_margin', array(
            'label' => esc_html__( 'Button Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( $s . ' .amaley-card__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_transform_heading', array( 'label' => esc_html__( 'Transform / Motion', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );

        $this->add_responsive_control( 'og_card_translate_y', array(
            'label' => esc_html__( 'Translate Y', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => -80, 'max' => 80 ) ),
            'selectors' => array( $s . ' .amaley-card' => '--amaley-og-card-translate-y: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_card_scale', array(
            'label' => esc_html__( 'Scale', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( '' => array( 'min' => 0.80, 'max' => 1.20, 'step' => 0.01 ) ),
            'selectors' => array( $s . ' .amaley-card' => '--amaley-og-card-scale: {{SIZE}};' ),
        ) );

        $this->add_responsive_control( 'og_card_rotate', array(
            'label' => esc_html__( 'Rotate', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'deg' ),
            'range' => array( 'deg' => array( 'min' => -8, 'max' => 8, 'step' => 0.1 ) ),
            'selectors' => array( $s . ' .amaley-card' => '--amaley-og-card-rotate: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_card_hover_translate_y', array(
            'label' => esc_html__( 'Hover Translate Y', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => -80, 'max' => 80 ) ),
            'selectors' => array( $s . ' .amaley-card:hover' => '--amaley-og-card-hover-translate-y: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'og_card_hover_scale', array(
            'label' => esc_html__( 'Hover Scale', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( '' => array( 'min' => 0.80, 'max' => 1.20, 'step' => 0.01 ) ),
            'selectors' => array( $s . ' .amaley-card:hover' => '--amaley-og-card-hover-scale: {{SIZE}};' ),
        ) );

        $this->add_responsive_control( 'og_card_hover_rotate', array(
            'label' => esc_html__( 'Hover Rotate', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'deg' ),
            'range' => array( 'deg' => array( 'min' => -8, 'max' => 8, 'step' => 0.1 ) ),
            'selectors' => array( $s . ' .amaley-card:hover' => '--amaley-og-card-hover-rotate: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_control( 'og_card_transition_duration', array(
            'label' => esc_html__( 'Transition Duration', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range' => array( 'ms' => array( 'min' => 0, 'max' => 1500, 'step' => 50 ) ),
            'selectors' => array( $s . ' .amaley-card' => '--amaley-og-card-transition-duration: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }


    private function register_pagination_style_controls( $section_selector ) {
        $s = '{{WRAPPER}} ' . $section_selector;

        $this->start_controls_section( 'style_pagination_controls', array(
            'label' => esc_html__( 'Product Pagination', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'enable_pagination' => '1' ),
        ) );

        $this->add_responsive_control( 'pagination_align', array(
            'label' => esc_html__( 'Alignment', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-h-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-h-align-center' ),
                'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-h-align-right' ),
            ),
            'default' => 'center',
            'selectors' => array( $s . ' .amms-pagination' => 'justify-content: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'pagination_gap', array(
            'label' => esc_html__( 'Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( $s . ' .amms-pagination' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_control( 'pagination_bg', array(
            'label' => esc_html__( 'Button Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-page-link' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_color', array(
            'label' => esc_html__( 'Button Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-page-link' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_active_bg', array(
            'label' => esc_html__( 'Current Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-page-current' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_active_color', array(
            'label' => esc_html__( 'Current Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-page-current' => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'pagination_border',
            'selector' => $s . ' .amms-page-link',
        ) );

        $this->add_responsive_control( 'pagination_radius', array(
            'label' => esc_html__( 'Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( $s . ' .amms-page-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'pagination_typography',
            'selector' => $s . ' .amms-page-link',
        ) );

        $this->end_controls_section();
    }


    protected function render() {
        /*
         * v1.0.140-clean-og-product-card-controls
         * No layout/card CSS is injected from this widget.
         * Product card output is handled by Amaley_Core_Card_Renderer via
         * includes/class-amaley-core-member-single-sections.php.
         */
        $renderer = $this->renderer_instance();
        echo $renderer->render_products( $this->get_settings_for_display() );
    }
}
