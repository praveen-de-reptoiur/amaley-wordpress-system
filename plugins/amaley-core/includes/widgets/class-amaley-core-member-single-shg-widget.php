<?php
/** Amaley Member Single Linked SHG Elementor widget — full-control safe version. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Single_SHG_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_member_single_shg'; }
    public function get_title() { return esc_html__( 'Amaley Member Single Linked SHG', 'amaley-core' ); }
    public function get_icon() { return 'eicon-posts-group'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'member', 'producer', 'single', 'shg' ); }

    protected function register_controls() {
        $defaults = $this->defaults_for( 'shg_defaults' );
        $this->register_source_controls( $defaults );
        $this->register_content_controls( $defaults );
        $this->register_common_style_controls( '.amms-related-shg' );
        $this->register_specific_style_controls( '.amms-related-shg' );
        $this->register_og_card_fine_controls( '.amms-related-shg' );
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
        $this->add_switch_if( $defaults, 'show_card_title', 'Show Card Title' );
        $this->add_switch_if( $defaults, 'show_card_excerpt', 'Show Card Description' );
        $this->add_switch_if( $defaults, 'show_card_meta', 'Show Card Stat Boxes' );
        $this->add_switch_if( $defaults, 'show_card_tags', 'Show Card Tags / Chips' );
        $this->add_switch_if( $defaults, 'show_button', 'Show Card Button' );
        $this->add_text_if( $defaults, 'button_text', 'Card Button Text' );
        $this->add_text_if( $defaults, 'detail_url_pattern', 'Detail URL Pattern' );
        if ( array_key_exists( 'card_template', $defaults ) ) {
            $this->add_control( 'card_template', array(
                'label' => esc_html__( 'Card Template', 'amaley-core' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => isset( $defaults['card_template'] ) ? $defaults['card_template'] : 'current_existing',
                'options' => array(
                    'current_existing' => esc_html__( 'Current / Existing Card', 'amaley-core' ),
                    'og_card_1' => esc_html__( 'OG Card 1', 'amaley-core' ),
                ),
                'description' => esc_html__( 'Choose Current layout or the approved OG Card 1.', 'amaley-core' ),
            ) );
        }
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
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'selector' => $s . ' .amms-kicker, ' . $s . ' .amms-card-label, ' . $s . ' .amaley-card__label' ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-kicker, ' . $s . ' .amms-card-label, ' . $s . ' .amaley-card__label' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'label_spacing', array( 'label' => esc_html__( 'Label Bottom Spacing', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $s . ' .amms-kicker, ' . $s . ' .amms-card-label, ' . $s . ' .amaley-card__label' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'label_margin_box', array( 'label' => esc_html__( 'Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-kicker, ' . $s . ' .amms-card-label, ' . $s . ' .amaley-card__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
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
        $this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary, ' . $s . ' .amms-product-button, ' . $s . ' .amaley-card__button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Primary Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary, ' . $s . ' .amms-product-button, ' . $s . ' .amaley-card__button' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
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
        $this->start_controls_section( 'style_related_cards', array(
            'label' => esc_html__( 'Cards: Grid / Card / Image / Meta', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'current_existing' ),
        ) );
        $this->add_responsive_control( 'related_columns', array( 'label' => esc_html__( 'Card Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'selectors' => array( $s . ' .amms-related-grid.amms-one-card, ' . $s . ' .amms-related-grid.amms-card-count-1, ' . $s . ' .amms-related-grid.amms-card-count-2, ' . $s . ' .amms-related-grid.amms-card-count-3' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 330px)) !important;' ) ) );
        $this->add_responsive_control( 'related_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $s . ' .amms-related-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_card_width', array( 'label' => esc_html__( 'Card Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 180, 'max' => 620 ) ), 'selectors' => array( $s . ' .amms-related-card, ' . $s . ' .amaley-card' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'related_card_background', 'selector' => $s . ' .amms-related-card, ' . $s . ' .amaley-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'related_card_border', 'selector' => $s . ' .amms-related-card, ' . $s . ' .amaley-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'related_card_shadow', 'selector' => $s . ' .amms-related-card, ' . $s . ' .amaley-card' ) );
        $this->add_responsive_control( 'related_card_padding', array( 'label' => esc_html__( 'Card Body Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body, ' . $s . ' .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_card_margin', array( 'label' => esc_html__( 'Card Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-card, ' . $s . ' .amaley-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-related-card, ' . $s . ' .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'related_media_heading', array( 'label' => esc_html__( 'Image / Icon Area', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'related_media_height', array( 'label' => esc_html__( 'Image / Icon Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 420 ) ), 'selectors' => array( $s . ' .amms-related-media, ' . $s . ' .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'related_media_bg', array( 'label' => esc_html__( 'Image Fallback Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-media, ' . $s . ' .amaley-card__media' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'related_media_radius', array( 'label' => esc_html__( 'Image / Icon Area Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-related-media, ' . $s . ' .amaley-card__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'related_icon_color', array( 'label' => esc_html__( 'Fallback Icon/Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-media span, ' . $s . ' .amaley-card__initials' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'related_badge_heading', array( 'label' => esc_html__( 'Badge', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_badge_typography', 'selector' => $s . ' .amms-related-media b, ' . $s . ' .amaley-card__label' ) );
        $this->add_control( 'related_badge_color', array( 'label' => esc_html__( 'Badge Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-media b, ' . $s . ' .amaley-card__label' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'related_badge_bg', array( 'label' => esc_html__( 'Badge Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-media b, ' . $s . ' .amaley-card__label' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'related_text_heading', array( 'label' => esc_html__( 'Card Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_title_typography', 'selector' => $s . ' .amms-related-body h3, ' . $s . ' .amaley-card__title' ) );
        $this->add_control( 'related_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body h3, ' . $s . ' .amaley-card__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_excerpt_typography', 'selector' => $s . ' .amms-related-body p:not(.amms-card-label), ' . $s . ' .amaley-card__excerpt' ) );
        $this->add_control( 'related_excerpt_color', array( 'label' => esc_html__( 'Card Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body p:not(.amms-card-label), ' . $s . ' .amaley-card__excerpt' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'related_meta_heading', array( 'label' => esc_html__( 'Stat Boxes / List Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'related_meta_gap', array( 'label' => esc_html__( 'Stat Box Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( $s . ' .amms-related-body dl, ' . $s . ' .amaley-card__meta' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'related_meta_bg', array( 'label' => esc_html__( 'Stat Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body dl div, ' . $s . ' .amaley-card__meta-item' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'related_meta_padding', array( 'label' => esc_html__( 'Stat Box Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body dl div, ' . $s . ' .amaley-card__meta-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_meta_margin', array( 'label' => esc_html__( 'Stat Box Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body dl div, ' . $s . ' .amaley-card__meta-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_meta_radius', array( 'label' => esc_html__( 'Stat Box Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-related-body dl div, ' . $s . ' .amaley-card__meta-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_meta_min_height', array( 'label' => esc_html__( 'Stat Box Min Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 220 ) ), 'selectors' => array( $s . ' .amms-related-body dl div, ' . $s . ' .amaley-card__meta-item' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_meta_columns', array( 'label' => esc_html__( 'Stat Box Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 3, 'selectors' => array( $s . ' .amms-related-body dl, ' . $s . ' .amaley-card__meta' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'related_meta_border', 'selector' => $s . ' .amms-related-body dl div, ' . $s . ' .amaley-card__meta-item' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_meta_label_typography', 'selector' => $s . ' .amms-related-body dt, ' . $s . ' .amaley-card__meta span' ) );
        $this->add_control( 'related_meta_label_color', array( 'label' => esc_html__( 'Stat Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body dt, ' . $s . ' .amaley-card__meta span' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'related_meta_label_margin', array( 'label' => esc_html__( 'Stat Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body dt, ' . $s . ' .amaley-card__meta span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_meta_value_typography', 'selector' => $s . ' .amms-related-body dd, ' . $s . ' .amaley-card__meta strong' ) );
        $this->add_control( 'related_meta_value_color', array( 'label' => esc_html__( 'Stat Value Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body dd, ' . $s . ' .amaley-card__meta strong' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'related_meta_value_margin', array( 'label' => esc_html__( 'Stat Value Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body dd, ' . $s . ' .amaley-card__meta strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'related_button_heading', array( 'label' => esc_html__( 'Card Button Fine Controls', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'related_button_margin', array( 'label' => esc_html__( 'Card Button Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-card-button, ' . $s . ' .amaley-card__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }


    private function register_og_card_fine_controls( $section_selector ) {
        $s = '{{WRAPPER}} ' . $section_selector;

        $this->start_controls_section( 'style_og_card_fine_controls', array(
            'label' => esc_html__( 'OG Card: Full Controls', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'og_card_1' ),
        ) );

        $this->add_control( 'og_card_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'These controls target OG Card 1 only. Current / Existing Card controls stay separate for editor performance.', 'amaley-core' ),
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


    protected function render() {
        $renderer = $this->renderer_instance();
        echo $renderer->render_shg( $this->get_settings_for_display() );
    }
}
