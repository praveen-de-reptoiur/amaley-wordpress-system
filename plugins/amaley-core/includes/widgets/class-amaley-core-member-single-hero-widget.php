<?php
/**
 * Amaley Core — Member / Producer Single Hero Elementor widget.
 *
 * v1.0.114-producer-hero-legacy-compatible-controls
 * - Live-site safe complete file replacement.
 * - Scope: Producer / Member Single Hero only.
 * - Keeps data detection and rendering in Amaley_Core_Member_Single_Sections.
 * - Adds dedicated Elementor controls that target only actual hero elements.
 * - Restores legacy Elementor control IDs so old saved style values keep working.
 * - Uses stronger hero selectors so controls override the member single CSS file.
 * - No card/gallery/meta controls are shown in Hero.
 * - No product, SHG, cluster, gallery, mapping, WooCommerce or post data changes.
 */
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
        $this->register_hero_style_controls();
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

    private function add_switch_if( $defaults, $key, $label ) {
        if ( ! array_key_exists( $key, $defaults ) ) { return; }
        $this->add_control( $key, array(
            'label'        => esc_html__( $label, 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $defaults[ $key ],
        ) );
    }

    private function add_text_if( $defaults, $key, $label, $type = 'TEXT' ) {
        if ( ! array_key_exists( $key, $defaults ) ) { return; }
        $control_type = ( 'TEXTAREA' === $type ) ? \Elementor\Controls_Manager::TEXTAREA : \Elementor\Controls_Manager::TEXT;
        $this->add_control( $key, array(
            'label'   => esc_html__( $label, 'amaley-core' ),
            'type'    => $control_type,
            'default' => $defaults[ $key ],
        ) );
    }

    private function register_source_controls( $defaults ) {
        $this->start_controls_section( 'source_section', array(
            'label' => esc_html__( 'Data / Preview Source', 'amaley-core' ),
        ) );

        $this->add_control( 'auto_detect', array(
            'label'        => esc_html__( 'Auto Detect from URL', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'amaley-core' ),
            'label_off'    => esc_html__( 'No', 'amaley-core' ),
            'return_value' => '1',
            'default'      => isset( $defaults['auto_detect'] ) ? $defaults['auto_detect'] : '1',
            'description'  => esc_html__( 'Live detail page reads the producer/member from the URL. Use preview/fixed fields only while designing.', 'amaley-core' ),
        ) );

        $this->add_control( 'preview_member_id', array(
            'label'       => esc_html__( 'Preview Member / Producer ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Optional. Use only in Elementor editor if URL auto-detect is empty.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_id', array(
            'label'       => esc_html__( 'Fixed Member / Producer ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Optional. Leave blank for dynamic live pages.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_slug', array(
            'label'       => esc_html__( 'Fixed Member / Producer Slug', 'amaley-core' ),
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
            'label' => esc_html__( 'Content / Show-Hide', 'amaley-core' ),
        ) );

        $this->add_switch_if( $defaults, 'show_section', 'Show Full Section' );
        $this->add_switch_if( $defaults, 'show_breadcrumb', 'Show Breadcrumb' );
        $this->add_text_if( $defaults, 'breadcrumb', 'Breadcrumb Text' );
        $this->add_switch_if( $defaults, 'show_label', 'Show Label / Eyebrow' );
        $this->add_text_if( $defaults, 'label', 'Label / Eyebrow Text' );
        $this->add_switch_if( $defaults, 'show_title', 'Show Heading' );
        $this->add_text_if( $defaults, 'title', 'Heading Text' );
        $this->add_switch_if( $defaults, 'show_description', 'Show Description' );
        $this->add_text_if( $defaults, 'description', 'Description Text', 'TEXTAREA' );
        $this->add_switch_if( $defaults, 'show_pills', 'Show Hero Tags / Chips' );
        $this->add_switch_if( $defaults, 'show_image', 'Show Main Image' );
        $this->add_switch_if( $defaults, 'show_buttons', 'Show Buttons' );
        $this->add_text_if( $defaults, 'primary_text', 'Primary Button Text' );
        $this->add_text_if( $defaults, 'primary_url', 'Primary Button URL' );
        $this->add_text_if( $defaults, 'secondary_text', 'Secondary Button Text' );
        $this->add_text_if( $defaults, 'secondary_url', 'Secondary Button URL' );

        $this->end_controls_section();
    }

    private function register_hero_style_controls() {
        $s = '{{WRAPPER}} .amms-section.amms-hero';

        $this->start_controls_section( 'style_section_background', array(
            'label' => esc_html__( 'Hero Section / Background', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'hero_background',
            'selector' => $s,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'hero_border',
            'selector' => $s,
        ) );

        $this->add_responsive_control( 'hero_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow:hidden;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_shadow',
            'selector' => $s,
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_layout_spacing', array(
            'label' => esc_html__( 'Hero Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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

        $this->add_responsive_control( 'wrap_width', array(
            'label'      => esc_html__( 'Container Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 320, 'max' => 1600 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-wrap' => 'width: min({{SIZE}}{{UNIT}}, 100%) !important;' ),
        ) );

        $this->add_responsive_control( 'hero_grid_gap', array(
            'label'      => esc_html__( 'Text–Image Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 140 ) ),
            'selectors'  => array( $s . ' .amms-hero-grid' => 'gap: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'hero_text_width', array(
            'label'      => esc_html__( 'Text Column Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 260, 'max' => 1100 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-hero-copy' => 'max-width: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'section_align', array(
            'label'     => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( $s . ' .amms-hero-copy' => 'text-align: {{VALUE}};' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_breadcrumb', array(
            'label' => esc_html__( 'Breadcrumb', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'breadcrumb_typography',
            'selector' => $s . ' .amms-breadcrumb',
        ) );
        $this->add_control( 'breadcrumb_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-breadcrumb' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'breadcrumb_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-breadcrumb' => 'background: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'breadcrumb_border',
            'selector' => $s . ' .amms-breadcrumb',
        ) );
        $this->add_responsive_control( 'breadcrumb_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'breadcrumb_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'breadcrumb_radius', array(
            'label'      => esc_html__( 'Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' .amms-breadcrumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_heading_text', array(
            'label' => esc_html__( 'Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-kicker' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'label'    => esc_html__( 'Label Typography', 'amaley-core' ),
            'selector' => $s . ' .amms-kicker',
        ) );
        $this->add_responsive_control( 'label_margin_box', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Heading Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-title' => 'color: {{VALUE}};' ),
            'separator' => 'before',
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Heading Typography', 'amaley-core' ),
            'selector' => $s . ' .amms-title',
        ) );
        $this->add_responsive_control( 'title_width', array(
            'label'      => esc_html__( 'Heading Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array( 'px' => array( 'min' => 200, 'max' => 1100 ), '%' => array( 'min' => 30, 'max' => 100 ) ),
            'selectors'  => array( $s . ' .amms-title' => 'max-width: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'title_margin_box', array(
            'label'      => esc_html__( 'Heading Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'desc_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-description' => 'color: {{VALUE}};' ),
            'separator' => 'before',
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'description_typography',
            'label'    => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => $s . ' .amms-description',
        ) );
        $this->add_responsive_control( 'desc_width', array(
            'label'      => esc_html__( 'Description Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array( 'px' => array( 'min' => 200, 'max' => 1100 ), '%' => array( 'min' => 30, 'max' => 100 ) ),
            'selectors'  => array( $s . ' .amms-description' => 'max-width: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'desc_margin_box', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_chips', array(
            'label' => esc_html__( 'Hero Tags / Chips', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'tag_gap', array(
            'label'      => esc_html__( 'Chip Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
            'selectors'  => array( $s . ' .amms-hero-pills' => 'gap: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'chips_margin', array(
            'label'      => esc_html__( 'Chip Row Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-hero-pills' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'chip_typography',
            'selector' => $s . ' .amms-hero-pills span',
        ) );

        $this->start_controls_tabs( 'chips_tabs' );
        $this->start_controls_tab( 'chips_normal_tab', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'tag_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'chip_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'chips_hover_tab', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'chip_hover_text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'chip_hover_background', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'chip_hover_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-hero-pills span:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control( 'tag_padding', array(
            'label'      => esc_html__( 'Chip Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-hero-pills span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
            'separator'  => 'before',
        ) );
        $this->add_responsive_control( 'tag_radius', array(
            'label'      => esc_html__( 'Chip Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' .amms-hero-pills span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_media', array(
            'label' => esc_html__( 'Image / Media Panel', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'hero_image_height', array(
            'label'      => esc_html__( 'Media Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range'      => array( 'px' => array( 'min' => 120, 'max' => 800 ), 'vh' => array( 'min' => 10, 'max' => 90 ) ),
            'selectors'  => array( $s . ' .amms-hero-media' => 'height: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'media_width', array(
            'label'      => esc_html__( 'Media Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array( 'px' => array( 'min' => 180, 'max' => 800 ), '%' => array( 'min' => 30, 'max' => 100 ) ),
            'selectors'  => array( $s . ' .amms-hero-media' => 'max-width: {{SIZE}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'hero_image_radius', array(
            'label'      => esc_html__( 'Media Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' .amms-hero-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; overflow:hidden;' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'media_background',
            'selector' => $s . ' .amms-hero-media',
        ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'media_border',
            'selector' => $s . ' .amms-hero-media',
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'media_shadow',
            'selector' => $s . ' .amms-hero-media',
        ) );
        $this->add_control( 'image_object_position', array(
            'label'     => esc_html__( 'Image Position', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'center center',
            'options'   => array(
                'center center' => esc_html__( 'Center Center', 'amaley-core' ),
                'center top'    => esc_html__( 'Center Top', 'amaley-core' ),
                'center bottom' => esc_html__( 'Center Bottom', 'amaley-core' ),
                'left center'   => esc_html__( 'Left Center', 'amaley-core' ),
                'right center'  => esc_html__( 'Right Center', 'amaley-core' ),
            ),
            'selectors' => array( $s . ' .amms-hero-media img' => 'object-position: {{VALUE}};' ),
            'separator' => 'before',
        ) );
        $this->add_control( 'image_opacity', array(
            'label'     => esc_html__( 'Image Opacity', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => array( 'px' => array( 'min' => 0.1, 'max' => 1, 'step' => 0.01 ) ),
            'selectors' => array( $s . ' .amms-hero-media img' => 'opacity: {{SIZE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Css_Filter::get_type(), array(
            'name'     => 'image_css_filters',
            'selector' => $s . ' .amms-hero-media img',
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_buttons', array(
            'label' => esc_html__( 'Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'button_row_gap', array(
            'label'      => esc_html__( 'Button Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array( $s . ' .amms-button-row' => 'gap: {{SIZE}}{{UNIT}} !important;' ),
        ) );

        $this->add_responsive_control( 'button_row_margin', array(
            'label'      => esc_html__( 'Button Row Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-button-row' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'button_typography',
            'selector' => $s . ' .amms-btn',
        ) );
        $this->add_responsive_control( 'button_padding', array(
            'label'      => esc_html__( 'Button Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'button_radius', array(
            'label'      => esc_html__( 'Button Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' .amms-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->add_control( 'primary_button_heading', array(
            'label'     => esc_html__( 'Primary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->start_controls_tabs( 'primary_button_tabs' );
        $this->start_controls_tab( 'primary_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'primary_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'primary_button_hover_background', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_hover_text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_hover_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-primary:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'primary_button_hover_shadow', 'selector' => $s . ' .amms-btn-primary:hover' ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'secondary_button_heading', array(
            'label'     => esc_html__( 'Secondary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->start_controls_tabs( 'secondary_button_tabs' );
        $this->start_controls_tab( 'secondary_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'secondary_button_background', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'outline_button_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'outline_button_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'secondary_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'secondary_button_hover_background', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_button_hover_text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_button_hover_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $s . ' .amms-btn-secondary:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'secondary_button_hover_shadow', 'selector' => $s . ' .amms-btn-secondary:hover' ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section( 'style_motion', array(
            'label' => esc_html__( 'Animation / Micro Motion', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'transition_duration', array(
            'label'     => esc_html__( 'Transition Duration', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 's' ),
            'range'     => array( 's' => array( 'min' => 0, 'max' => 2, 'step' => 0.05 ) ),
            'selectors' => array( $s . ' .amms-btn, ' . $s . ' .amms-hero-media, ' . $s . ' .amms-hero-media img, ' . $s . ' .amms-hero-pills span' => 'transition-duration: {{SIZE}}s !important;' ),
        ) );

        $this->add_control( 'media_hover_scale', array(
            'label'     => esc_html__( 'Image Hover Scale', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => array( 'px' => array( 'min' => 1, 'max' => 1.12, 'step' => 0.01 ) ),
            'selectors' => array( $s . ' .amms-hero-media:hover img' => 'transform: scale({{SIZE}}) !important;' ),
        ) );

        $this->add_control( 'button_hover_lift', array(
            'label'     => esc_html__( 'Button Hover Lift', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'     => array( 'px' => array( 'min' => 0, 'max' => 16 ) ),
            'selectors' => array( $s . ' .amms-btn:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}}) !important;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_empty_state', array(
            'label' => esc_html__( 'Fallback / Empty Message', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'empty_typography', 'selector' => '{{WRAPPER}} .amms-empty' ) );
        $this->add_control( 'empty_color', array( 'label' => esc_html__( 'Message Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amms-empty' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'empty_background', 'selector' => '{{WRAPPER}} .amms-empty' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'empty_border', 'selector' => '{{WRAPPER}} .amms-empty' ) );
        $this->add_responsive_control( 'empty_padding', array(
            'label'      => esc_html__( 'Message Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( '{{WRAPPER}} .amms-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );
        $this->add_responsive_control( 'empty_radius', array(
            'label'      => esc_html__( 'Message Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( '{{WRAPPER}} .amms-empty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = $this->renderer_instance();
        $widget_id = $this->get_id();
        $scope = '.elementor-element-' . $widget_id . ' .amms-section.amms-hero';
        echo '<style>@media(max-width:767px){' .
            $scope . '{width:100% !important;max-width:100% !important;}' .
            $scope . ' .amms-wrap{width:100% !important;max-width:100% !important;min-width:0 !important;}' .
            $scope . ' .amms-hero-grid{grid-template-columns:1fr !important;gap:18px !important;align-items:flex-start !important;}' .
            $scope . ' .amms-hero-copy{width:100% !important;max-width:none !important;min-width:0 !important;flex:0 0 100% !important;}' .
            $scope . ' .amms-title,' . $scope . ' .amms-description,' . $scope . ' .amms-hero-copy p{max-width:100% !important;word-break:normal !important;overflow-wrap:break-word !important;hyphens:none !important;}' .
            $scope . ' .amms-hero-media{display:block !important;width:100% !important;max-width:none !important;min-width:0 !important;height:240px !important;}' .
            $scope . ' .amms-hero-media img{width:100% !important;height:100% !important;object-fit:cover !important;display:block !important;}' .
            $scope . ' .amms-button-row{width:100% !important;display:flex !important;flex-direction:column !important;gap:12px !important;}' .
            $scope . ' .amms-btn{width:100% !important;justify-content:center !important;}' .
            $scope . ' .amms-hero-pills{width:100% !important;}' .
        '}</style>';
        echo $renderer->render_hero( $this->get_settings_for_display() );
    }
}
