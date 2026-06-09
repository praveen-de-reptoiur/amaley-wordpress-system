<?php
/**
 * Amaley Core — Member / Producer Single Linked Cluster Elementor widget.
 *
 * v1.0.123-linked-cluster-clean-controls
 * - Live-site safe complete file replacement.
 * - Scope: Single Member / Producer Detail page → Linked Cluster section only.
 * - Removes unrelated generic controls from this widget.
 * - Keeps only controls for actual Linked Cluster elements: section shell, heading, cluster card,
 *   image/badge, card text, meta boxes, card button, OG Card 1 and fallback message.
 * - No post data, cluster mapping, products, gallery, archive page, WooCommerce or URL logic changes.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Single_Cluster_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'amaley_core_member_single_cluster'; }
    public function get_title() { return esc_html__( 'Amaley Member Single Linked Cluster', 'amaley-core' ); }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'member', 'producer', 'single', 'cluster', 'source' ); }

    protected function register_controls() {
        $defaults = $this->defaults_for( 'cluster_defaults' );

        $this->register_source_controls( $defaults );
        $this->register_content_controls( $defaults );
        $this->register_section_style_controls();
        $this->register_heading_style_controls();
        $this->register_current_card_style_controls();
        $this->register_og_card_style_controls();
        $this->register_fallback_style_controls();
    }

    private function renderer_instance() {
        return isset( $GLOBALS['amaley_core_member_single_sections'] ) && $GLOBALS['amaley_core_member_single_sections'] instanceof Amaley_Core_Member_Single_Sections
            ? $GLOBALS['amaley_core_member_single_sections']
            : new Amaley_Core_Member_Single_Sections();
    }

    private function defaults_for( $method ) {
        $renderer = $this->renderer_instance();
        return method_exists( $renderer, $method ) ? $renderer->$method() : $renderer->base_defaults();
    }

    private function add_switch_if( $defaults, $key, $label, $condition = array() ) {
        if ( ! array_key_exists( $key, $defaults ) ) { return; }
        $args = array(
            'label'        => esc_html__( $label, 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $defaults[ $key ],
        );
        if ( ! empty( $condition ) ) { $args['condition'] = $condition; }
        $this->add_control( $key, $args );
    }

    private function add_text_if( $defaults, $key, $label, $type = 'TEXT', $condition = array() ) {
        if ( ! array_key_exists( $key, $defaults ) ) { return; }
        $control_type = ( 'TEXTAREA' === $type ) ? \Elementor\Controls_Manager::TEXTAREA : \Elementor\Controls_Manager::TEXT;
        $args = array(
            'label'   => esc_html__( $label, 'amaley-core' ),
            'type'    => $control_type,
            'default' => $defaults[ $key ],
        );
        if ( ! empty( $condition ) ) { $args['condition'] = $condition; }
        $this->add_control( $key, $args );
    }

    private function register_source_controls( $defaults ) {
        $this->start_controls_section( 'source_section', array(
            'label' => esc_html__( 'Linked Cluster Data / Preview Source', 'amaley-core' ),
        ) );

        $this->add_control( 'auto_detect', array(
            'label'        => esc_html__( 'Auto Detect Producer from URL', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'amaley-core' ),
            'label_off'    => esc_html__( 'No', 'amaley-core' ),
            'return_value' => '1',
            'default'      => isset( $defaults['auto_detect'] ) ? $defaults['auto_detect'] : '1',
            'description'  => esc_html__( 'Live detail page reads the producer/member from the URL. Use preview/fixed fields only while designing.', 'amaley-core' ),
        ) );

        $this->add_control( 'preview_member_id', array(
            'label'       => esc_html__( 'Preview Producer ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Optional. Use only in Elementor editor if URL auto-detect is empty.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_id', array(
            'label'       => esc_html__( 'Fixed Producer ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Optional. Leave blank for dynamic live pages.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_slug', array(
            'label'       => esc_html__( 'Fixed Producer Slug', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => '',
            'description' => esc_html__( 'Optional. Leave blank for dynamic live pages.', 'amaley-core' ),
        ) );

        $this->add_control( 'empty_message', array(
            'label'   => esc_html__( 'Fallback / Empty Message', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => isset( $defaults['empty_message'] ) ? $defaults['empty_message'] : '',
        ) );

        $this->end_controls_section();
    }

    private function register_content_controls( $defaults ) {
        $this->start_controls_section( 'content_section', array(
            'label' => esc_html__( 'Linked Cluster Content / Display', 'amaley-core' ),
        ) );

        $this->add_switch_if( $defaults, 'show_section', 'Show Linked Cluster Section' );

        $this->add_control( 'section_content_heading', array(
            'label'     => esc_html__( 'Section Heading Content', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_switch_if( $defaults, 'show_label', 'Show Section Label' );
        $this->add_text_if( $defaults, 'label', 'Section Label Text' );
        $this->add_switch_if( $defaults, 'show_title', 'Show Section Heading' );
        $this->add_text_if( $defaults, 'title', 'Section Heading Text' );
        $this->add_switch_if( $defaults, 'show_description', 'Show Section Description' );
        $this->add_text_if( $defaults, 'description', 'Section Description Text', 'TEXTAREA' );

        $this->add_control( 'card_display_heading', array(
            'label'     => esc_html__( 'Linked Cluster Card Display', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'card_template', array(
            'label'       => esc_html__( 'Cluster Card Template', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => isset( $defaults['card_template'] ) ? $defaults['card_template'] : 'current_existing',
            'options'     => array(
                'current_existing' => esc_html__( 'Current / Existing Cluster Card', 'amaley-core' ),
                'og_card_1'        => esc_html__( 'OG Cluster Card 1', 'amaley-core' ),
            ),
            'description' => esc_html__( 'Current card uses this section layout. OG Card 1 uses the approved central card renderer.', 'amaley-core' ),
        ) );

        $this->add_switch_if( $defaults, 'show_card_media', 'Show Card Image / Initials' );
        $this->add_switch_if( $defaults, 'show_card_label', 'Show Card Label' );
        $this->add_switch_if( $defaults, 'show_card_title', 'Show Card Title' );
        $this->add_switch_if( $defaults, 'show_card_excerpt', 'Show Card Description' );
        $this->add_switch_if( $defaults, 'show_card_meta', 'Show Card Detail Boxes' );
        $this->add_switch_if( $defaults, 'show_card_tags', 'Show Card Tags / Chips', array( 'card_template' => 'og_card_1' ) );
        $this->add_switch_if( $defaults, 'show_button', 'Show Card Button' );
        $this->add_text_if( $defaults, 'button_text', 'Card Button Text' );
        $this->add_text_if( $defaults, 'detail_url_pattern', 'Card Detail URL Pattern' );

        $this->end_controls_section();
    }

    private function register_section_style_controls() {
        $s = '{{WRAPPER}} .amms-related-cluster';

        $this->start_controls_section( 'style_section_shell', array(
            'label' => esc_html__( 'Linked Cluster Section / Background', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background',
            'selector' => $s,
        ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border',
            'selector' => $s,
        ) );
        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array( $s => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array( $s => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow:hidden;' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow',
            'selector' => $s,
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_layout', array(
            'label' => esc_html__( 'Linked Cluster Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );
        $this->add_responsive_control( 'wrap_width', array(
            'label'      => esc_html__( 'Content Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 320, 'max' => 1600 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-wrap' => 'width: min({{SIZE}}{{UNIT}}, 100%) !important;' ),
        ) );
        $this->add_responsive_control( 'section_align', array(
            'label'   => esc_html__( 'Section Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( $s . ' .amms-section-head' => 'text-align: {{VALUE}} !important;' ),
        ) );
        $this->add_responsive_control( 'head_width', array(
            'label'      => esc_html__( 'Heading Block Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 240, 'max' => 1200 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-section-head' => 'max-width: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'head_margin', array(
            'label'      => esc_html__( 'Heading Block Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array( $s . ' .amms-section-head' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'related_gap', array(
            'label'      => esc_html__( 'Card Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 90 ) ),
            'selectors'  => array( $s . ' .amms-related-grid' => 'gap: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'related_card_width', array(
            'label'      => esc_html__( 'Single Card Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 260, 'max' => 1000 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-one-card' => 'grid-template-columns: minmax(0, {{SIZE}}{{UNIT}}) !important;' ),
        ) );
        $this->end_controls_section();
    }

    private function register_heading_style_controls() {
        $s = '{{WRAPPER}} .amms-related-cluster';

        $this->start_controls_section( 'style_heading_block', array(
            'label' => esc_html__( 'Linked Cluster Heading / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_heading', array(
            'label'     => esc_html__( 'Section Label', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
        ) );
        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-label' => 'color: {{VALUE}} !important;' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'selector' => $s . ' .amms-label',
        ) );
        $this->add_responsive_control( 'label_margin_box', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'title_heading', array(
            'label'     => esc_html__( 'Section Heading', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Heading Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-title' => 'color: {{VALUE}} !important;' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'selector' => $s . ' .amms-section-title',
        ) );
        $this->add_responsive_control( 'title_width', array(
            'label'      => esc_html__( 'Heading Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 220, 'max' => 1200 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-section-title' => 'max-width: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'title_margin_box', array(
            'label'      => esc_html__( 'Heading Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'desc_heading', array(
            'label'     => esc_html__( 'Section Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_control( 'desc_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-description' => 'color: {{VALUE}} !important;' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'desc_typography',
            'selector' => $s . ' .amms-section-description',
        ) );
        $this->add_responsive_control( 'desc_width', array(
            'label'      => esc_html__( 'Description Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 220, 'max' => 1200 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-section-description' => 'max-width: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'desc_margin_box', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-section-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();
    }

    private function register_current_card_style_controls() {
        $s = '{{WRAPPER}} .amms-related-cluster';
        $card = $s . ' .amms-related-card.amms-cluster-card';

        $this->start_controls_section( 'style_current_card_box', array(
            'label'     => esc_html__( 'Current Cluster Card / Box', 'amaley-core' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'current_existing' ),
        ) );

        $this->add_responsive_control( 'related_card_margin', array(
            'label'      => esc_html__( 'Card Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $card => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'related_card_padding', array(
            'label'      => esc_html__( 'Card Inner Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-related-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'related_card_radius', array(
            'label'      => esc_html__( 'Card Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $card => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow:hidden;' ),
        ) );

        $this->start_controls_tabs( 'current_card_box_tabs' );
        $this->start_controls_tab( 'current_card_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'related_card_background', 'selector' => $card ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'related_card_border', 'selector' => $card ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'related_card_shadow', 'selector' => $card ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'current_card_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'related_card_hover_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ':hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'related_card_hover_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ':hover' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'related_card_hover_shadow', 'selector' => $card . ':hover' ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section( 'style_current_card_media', array(
            'label'     => esc_html__( 'Current Cluster Card Image / Media', 'amaley-core' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'current_existing' ),
        ) );
        $this->add_responsive_control( 'related_media_height', array(
            'label'      => esc_html__( 'Image Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range'      => array( 'px' => array( 'min' => 80, 'max' => 520 ), 'vh' => array( 'min' => 10, 'max' => 80 ) ),
            'selectors'  => array( $s . ' .amms-related-media' => 'height: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'related_media_bg', 'selector' => $s . ' .amms-related-media' ) );
        $this->add_responsive_control( 'related_media_radius', array(
            'label'      => esc_html__( 'Image Area Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' .amms-related-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow:hidden;' ),
        ) );
        $this->add_control( 'related_image_position', array(
            'label'     => esc_html__( 'Image Position', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => '',
            'options'   => array(
                ''              => esc_html__( 'Default', 'amaley-core' ),
                'center center' => esc_html__( 'Center Center', 'amaley-core' ),
                'center top'    => esc_html__( 'Center Top', 'amaley-core' ),
                'center bottom' => esc_html__( 'Center Bottom', 'amaley-core' ),
            ),
            'selectors' => array( $s . ' .amms-related-media img' => 'object-position: {{VALUE}} !important;' ),
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_current_card_text', array(
            'label'     => esc_html__( 'Current Cluster Card Text', 'amaley-core' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'current_existing' ),
        ) );
        $this->add_control( 'related_label_color', array( 'label' => esc_html__( 'Card Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-card-label' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_label_typography', 'selector' => $s . ' .amms-card-label' ) );
        $this->add_responsive_control( 'related_label_margin', array( 'label' => esc_html__( 'Card Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-card-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'related_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body h3' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_title_typography', 'selector' => $s . ' .amms-related-body h3' ) );
        $this->add_responsive_control( 'related_title_margin', array( 'label' => esc_html__( 'Card Title Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'related_excerpt_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body > p:not(.amms-card-label)' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_excerpt_typography', 'selector' => $s . ' .amms-related-body > p:not(.amms-card-label)' ) );
        $this->add_responsive_control( 'related_excerpt_margin', array( 'label' => esc_html__( 'Description Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body > p:not(.amms-card-label)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_current_card_meta', array(
            'label'     => esc_html__( 'Current Cluster Detail Boxes', 'amaley-core' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'current_existing' ),
        ) );
        $this->add_responsive_control( 'related_meta_gap', array( 'label' => esc_html__( 'Detail Box Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $s . ' .amms-related-body dl' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'related_meta_columns', array( 'label' => esc_html__( 'Detail Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'selectors' => array( $s . ' .amms-related-body dl' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr)) !important;' ) ) );
        $this->add_control( 'related_meta_bg', array( 'label' => esc_html__( 'Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body dl div' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'related_meta_border', 'selector' => $s . ' .amms-related-body dl div' ) );
        $this->add_responsive_control( 'related_meta_padding', array( 'label' => esc_html__( 'Box Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-related-body dl div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'related_meta_radius', array( 'label' => esc_html__( 'Box Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-related-body dl div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'related_meta_label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body dt' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_meta_label_typography', 'selector' => $s . ' .amms-related-body dt' ) );
        $this->add_control( 'related_meta_value_color', array( 'label' => esc_html__( 'Value Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-related-body dd' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_meta_value_typography', 'selector' => $s . ' .amms-related-body dd' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_current_card_button', array(
            'label'     => esc_html__( 'Current Cluster Card Button', 'amaley-core' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'current_existing' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_button_typography', 'selector' => $s . ' .amms-card-button' ) );
        $this->add_responsive_control( 'related_button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-card-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'related_button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-card-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'related_button_margin', array( 'label' => esc_html__( 'Button Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-card-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->start_controls_tabs( 'current_card_button_tabs' );
        $this->start_controls_tab( 'current_card_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'related_button_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-card-button' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'related_button_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-card-button' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'related_button_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-card-button' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'current_card_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'related_button_hover_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-card-button:hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'related_button_hover_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-card-button:hover' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'related_button_hover_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-card-button:hover' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'related_button_hover_shadow', 'selector' => $s . ' .amms-card-button:hover' ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_og_card_style_controls() {
        $s = '{{WRAPPER}} .amms-related-cluster';
        $card = $s . ' .amaley-card';

        $this->start_controls_section( 'style_og_card_fine_controls', array(
            'label'     => esc_html__( 'OG Cluster Card 1 Controls', 'amaley-core' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'og_card_1' ),
        ) );

        $this->add_control( 'og_card_note', array(
            'type'            => \Elementor\Controls_Manager::RAW_HTML,
            'raw'             => esc_html__( 'These controls appear only when Cluster Card Template is set to OG Cluster Card 1.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_control( 'og_box_heading', array( 'label' => esc_html__( 'Card Box', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'og_card_background', 'selector' => $card ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'og_card_border', 'selector' => $card ) );
        $this->add_responsive_control( 'og_card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $card => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow:hidden;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'og_card_shadow', 'selector' => $card ) );
        $this->add_responsive_control( 'og_card_body_padding', array( 'label' => esc_html__( 'Body Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $card . ' .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );

        $this->add_control( 'og_media_heading', array( 'label' => esc_html__( 'Image / Media', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'og_media_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 90, 'max' => 520 ) ), 'selectors' => array( $card . ' .amaley-card__media' => 'height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'og_media_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $card . ' .amaley-card__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow:hidden;' ) ) );

        $this->add_control( 'og_text_heading', array( 'label' => esc_html__( 'Card Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'og_label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__label' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_label_typography', 'selector' => $card . ' .amaley-card__label' ) );
        $this->add_control( 'og_title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_title_typography', 'selector' => $card . ' .amaley-card__title' ) );
        $this->add_control( 'og_excerpt_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__excerpt' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_excerpt_typography', 'selector' => $card . ' .amaley-card__excerpt' ) );

        $this->add_control( 'og_meta_heading', array( 'label' => esc_html__( 'Meta Boxes / Tags', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'og_meta_gap', array( 'label' => esc_html__( 'Meta Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $card . ' .amaley-card__meta' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'og_meta_bg', array( 'label' => esc_html__( 'Meta Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__meta-item' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_meta_label_color', array( 'label' => esc_html__( 'Meta Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__meta-label' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_meta_value_color', array( 'label' => esc_html__( 'Meta Value Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__meta-value' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_tags_color', array( 'label' => esc_html__( 'Tag Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__tag' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_tags_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__tag' => 'background: {{VALUE}} !important;' ) ) );

        $this->add_control( 'og_button_heading', array( 'label' => esc_html__( 'Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_button_typography', 'selector' => $card . ' .amaley-card__button' ) );
        $this->add_responsive_control( 'og_button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $card . ' .amaley-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'og_button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $card . ' .amaley-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->start_controls_tabs( 'og_button_tabs' );
        $this->start_controls_tab( 'og_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'og_button_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__button' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_button_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__button' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_button_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__button' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'og_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'og_button_hover_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__button:hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_button_hover_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__button:hover' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'og_button_hover_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-card__button:hover' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'og_transform_heading', array( 'label' => esc_html__( 'Motion', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'og_card_hover_translate_y', array( 'label' => esc_html__( 'Hover Lift', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => -30, 'max' => 30 ) ), 'selectors' => array( $card . ':hover' => 'transform: translateY({{SIZE}}{{UNIT}}) !important;' ) ) );
        $this->add_control( 'og_card_transition_duration', array( 'label' => esc_html__( 'Transition Duration', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'ms' ), 'range' => array( 'ms' => array( 'min' => 0, 'max' => 1500, 'step' => 50 ) ), 'selectors' => array( $card => 'transition-duration: {{SIZE}}{{UNIT}} !important;' ) ) );

        $this->end_controls_section();
    }

    private function register_fallback_style_controls() {
        $s = '{{WRAPPER}} .amms-related-cluster';
        $this->start_controls_section( 'style_fallback', array(
            'label' => esc_html__( 'Linked Cluster Fallback / Empty Message', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );
        $this->add_control( 'empty_color', array( 'label' => esc_html__( 'Message Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-empty, {{WRAPPER}} .amms-empty' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'empty_background', 'selector' => $s . ' .amms-empty, {{WRAPPER}} .amms-empty' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'empty_border', 'selector' => $s . ' .amms-empty, {{WRAPPER}} .amms-empty' ) );
        $this->add_responsive_control( 'empty_padding', array( 'label' => esc_html__( 'Message Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( $s . ' .amms-empty, {{WRAPPER}} .amms-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'empty_radius', array( 'label' => esc_html__( 'Message Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( $s . ' .amms-empty, {{WRAPPER}} .amms-empty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = $this->renderer_instance();
        echo $renderer->render_cluster( $this->get_settings_for_display() );
    }
}
