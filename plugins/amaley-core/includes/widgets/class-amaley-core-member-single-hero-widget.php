<?php
/** Amaley Member Single Hero Elementor widget — full-control safe version. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Single_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_member_single_hero'; }
    public function get_title() { return esc_html__( 'Amaley Member Single Hero', 'amaley-core' ); }
    public function get_icon() { return 'eicon-banner'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'member', 'producer', 'single', 'hero' ); }

    protected function register_controls() {
        $defaults = $this->defaults_for( 'hero_defaults' );
        $this->register_source_controls( $defaults );
        $this->register_content_controls( $defaults );
        $this->register_common_style_controls( '.amms-hero' );
        $this->register_specific_style_controls( '.amms-hero' );
    }

    private function renderer_instance() {
        return isset( $GLOBALS['amaley_core_member_single_sections'] ) && $GLOBALS['amaley_core_member_single_sections'] instanceof Amaley_Core_Member_Single_Sections ? $GLOBALS['amaley_core_member_single_sections'] : new Amaley_Core_Member_Single_Sections();
    }

    private function defaults_for( $method ) {
        $renderer = $this->renderer_instance();
        return method_exists( $renderer, $method ) ? $renderer->$method() : $renderer->base_defaults();
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
        $this->start_controls_section( 'source_section', array( 'label' => esc_html__( 'Data / Preview Source', 'amaley-core' ) ) );
        $this->add_control( 'auto_detect', array( 'label' => esc_html__( 'Auto Detect from URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => 'Yes', 'label_off' => 'No', 'return_value' => '1', 'default' => isset( $defaults['auto_detect'] ) ? $defaults['auto_detect'] : '1' ) );
        $this->add_control( 'preview_member_id', array( 'label' => esc_html__( 'Preview Member ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => '', 'description' => esc_html__( 'Use in Elementor editor if URL auto-detect is empty.', 'amaley-core' ) ) );
        $this->add_control( 'member_id', array( 'label' => esc_html__( 'Fixed Member ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => '' ) );
        $this->add_control( 'member_slug', array( 'label' => esc_html__( 'Fixed Member Slug', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Fallback / Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => isset( $defaults['empty_message'] ) ? $defaults['empty_message'] : '' ) );
        $this->end_controls_section();
    }

    private function register_content_controls( $defaults ) {
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( 'Content / Show-Hide', 'amaley-core' ) ) );
        $this->add_switch_if( $defaults, 'show_section', 'Show Full Section' );
        $this->add_switch_if( $defaults, 'show_breadcrumb', 'Show Breadcrumb' );
        $this->add_text_if( $defaults, 'breadcrumb', 'Breadcrumb Text' );
        $this->add_switch_if( $defaults, 'show_label', 'Show Label / Eyebrow' );
        $this->add_text_if( $defaults, 'label', 'Label / Eyebrow Text' );
        $this->add_switch_if( $defaults, 'show_title', 'Show Heading' );
        $this->add_text_if( $defaults, 'title', 'Heading Text' );
        $this->add_switch_if( $defaults, 'show_description', 'Show Description' );
        $this->add_text_if( $defaults, 'description', 'Description Text', 'TEXTAREA' );
        $this->add_switch_if( $defaults, 'show_image', 'Show Main Image' );
        $this->add_switch_if( $defaults, 'show_pills', 'Show Hero Tags / Chips' );
        $this->add_switch_if( $defaults, 'show_buttons', 'Show Buttons' );
        $this->add_text_if( $defaults, 'primary_text', 'Primary Button Text' );
        $this->add_text_if( $defaults, 'primary_url', 'Primary Button URL' );
        $this->add_text_if( $defaults, 'secondary_text', 'Secondary Button Text' );
        $this->add_text_if( $defaults, 'secondary_url', 'Secondary Button URL' );
        $this->add_number_if( $defaults, 'columns_desktop', 'Columns Desktop', 1, 8 );
        $this->add_number_if( $defaults, 'columns_tablet', 'Columns Tablet', 1, 4 );
        $this->add_number_if( $defaults, 'columns_mobile', 'Columns Mobile', 1, 2 );
        $this->add_switch_if( $defaults, 'show_role_stat', 'Show Role Stat' );
        $this->add_switch_if( $defaults, 'show_village_stat', 'Show Village Stat' );
        $this->add_switch_if( $defaults, 'show_shg_stat', 'Show SHG Stat' );
        $this->add_switch_if( $defaults, 'show_cluster_stat', 'Show Cluster Stat' );
        $this->add_switch_if( $defaults, 'show_skills', 'Show Skill Tags' );
        $this->add_switch_if( $defaults, 'show_products', 'Show Product Tags' );
        $this->add_number_if( $defaults, 'max_tags', 'Maximum Tags', 1, 24 );
        $this->add_switch_if( $defaults, 'show_card_media', 'Show Card Image / Icon Area' );
        $this->add_switch_if( $defaults, 'show_card_badge', 'Show Card Badge' );
        $this->add_switch_if( $defaults, 'show_card_label', 'Show Card Label' );
        $this->add_switch_if( $defaults, 'show_card_excerpt', 'Show Card Description' );
        $this->add_switch_if( $defaults, 'show_card_meta', 'Show Card Stat Boxes' );
        $this->add_switch_if( $defaults, 'show_button', 'Show Card Button' );
        $this->add_text_if( $defaults, 'button_text', 'Card Button Text' );
        $this->add_text_if( $defaults, 'detail_url_pattern', 'Detail URL Pattern' );
        $this->add_number_if( $defaults, 'limit', 'Product Limit', 1, 24 );
        $this->add_switch_if( $defaults, 'show_product_image', 'Show Product Image' );
        $this->add_switch_if( $defaults, 'show_product_label', 'Show Product Label' );
        $this->add_switch_if( $defaults, 'show_product_meta', 'Show Product Price / Origin Boxes' );
        $this->add_switch_if( $defaults, 'show_product_chips', 'Show Product Traceability Chips' );
        $this->add_switch_if( $defaults, 'show_product_button', 'Show Product Button' );
        $this->add_switch_if( $defaults, 'show_fallback_tags', 'Show Fallback Product Tags' );
        $this->add_switch_if( $defaults, 'show_section_button', 'Show Section Button' );
        $this->add_text_if( $defaults, 'section_button_text', 'Section Button Text' );
        $this->add_text_if( $defaults, 'section_button_url', 'Section Button URL' );
        $this->add_number_if( $defaults, 'max_images', 'Maximum Gallery Images', 1, 30 );
        $this->add_switch_if( $defaults, 'show_caption', 'Show Gallery Caption' );
        $this->add_switch_if( $defaults, 'show_phone', 'Show Phone / WhatsApp' );
        $this->end_controls_section();
    }

    private function register_common_style_controls( $section_selector ) {
        $s = '{{WRAPPER}} ' . $section_selector;

        $this->start_controls_section( 'style_section_shell', array(
            'label' => esc_html__( 'Section: Background & Layout', 'amaley-core' ),
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
            'label' => esc_html__( 'Section Head: Label / Heading / Description', 'amaley-core' ),
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
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'selector' => $s . ' .amms-kicker, ' . $s . ' .amms-card-label' ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-kicker, ' . $s . ' .amms-card-label' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'label_spacing', array( 'label' => esc_html__( 'Label Bottom Spacing', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $s . ' .amms-kicker, ' . $s . ' .amms-card-label' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'label_margin_box', array( 'label' => esc_html__( 'Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-kicker, ' . $s . ' .amms-card-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
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

        $this->start_controls_section( 'style_buttons', array(
            'label' => esc_html__( 'Buttons / CTA Buttons', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );
        $this->add_responsive_control( 'button_row_gap', array( 'label' => esc_html__( 'Button Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $s . ' .amms-button-row' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => $s . ' .amms-btn, ' . $s . ' .amms-card-button, ' . $s . ' .amms-product-button, ' . $s . ' .amms-section-button' ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-btn, ' . $s . ' .amms-card-button, ' . $s . ' .amms-product-button, ' . $s . ' .amms-section-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-btn, ' . $s . ' .amms-card-button, ' . $s . ' .amms-product-button, ' . $s . ' .amms-section-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary, ' . $s . ' .amms-product-button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Primary Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary, ' . $s . ' .amms-product-button' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
        $this->add_control( 'outline_button_color', array( 'label' => esc_html__( 'Outline Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary, ' . $s . ' .amms-card-button, ' . $s . ' .amms-section-button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'outline_button_border', array( 'label' => esc_html__( 'Outline Button Border', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary, ' . $s . ' .amms-card-button, ' . $s . ' .amms-section-button' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_fallback', array(
            'label' => esc_html__( 'Fallback / Empty Message', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'empty_typography', 'selector' => $s . ' .amms-empty' ) );
        $this->add_control( 'empty_color', array( 'label' => esc_html__( 'Message Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-empty' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'empty_background', 'selector' => $s . ' .amms-empty' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'empty_border', 'selector' => $s . ' .amms-empty' ) );
        $this->add_responsive_control( 'empty_padding', array( 'label' => esc_html__( 'Message Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }


    private function register_specific_style_controls( $section_selector ) {
        $s = '{{WRAPPER}} ' . $section_selector;
        $this->start_controls_section( 'style_hero_layout', array( 'label' => esc_html__( 'Hero: Grid / Image / Breadcrumb / Tags', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'hero_grid_gap', array( 'label' => esc_html__( 'Text–Image Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( $s . ' .amms-hero-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_text_width', array( 'label' => esc_html__( 'Text Column Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 260, 'max' => 1000 ), '%' => array( 'min' => 30, 'max' => 100 ) ), 'selectors' => array( $s . ' .amms-hero-copy' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 120, 'max' => 800 ), 'vh' => array( 'min' => 10, 'max' => 90 ) ), 'selectors' => array( $s . ' .amms-hero-media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-hero-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_image_margin', array( 'label' => esc_html__( 'Image Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-hero-media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'hero_image_border', 'selector' => $s . ' .amms-hero-media' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'hero_image_shadow', 'selector' => $s . ' .amms-hero-media' ) );
        $this->add_control( 'breadcrumb_heading', array( 'label' => esc_html__( 'Breadcrumb', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'breadcrumb_typography', 'selector' => $s . ' .amms-breadcrumb' ) );
        $this->add_control( 'breadcrumb_color', array( 'label' => esc_html__( 'Breadcrumb Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-breadcrumb' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'breadcrumb_bg', array( 'label' => esc_html__( 'Breadcrumb Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-breadcrumb' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'tag_heading', array( 'label' => esc_html__( 'Hero Tags / Chips', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'tag_gap', array( 'label' => esc_html__( 'Tag Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $s . ' .amms-hero-pills' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'tag_typography', 'selector' => $s . ' .amms-hero-pills span' ) );
        $this->add_control( 'tag_color', array( 'label' => esc_html__( 'Tag Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'tag_padding', array( 'label' => esc_html__( 'Tag Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-hero-pills span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_margin', array( 'label' => esc_html__( 'Tag Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-hero-pills span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_radius', array( 'label' => esc_html__( 'Tag Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-hero-pills span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'tag_border', 'selector' => $s . ' .amms-hero-pills span' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = $this->renderer_instance();
        echo $renderer->render_hero( $this->get_settings_for_display() );
    }
}
