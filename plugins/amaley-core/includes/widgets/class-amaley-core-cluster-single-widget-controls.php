<?php
/** Shared controls for Cluster Single section widgets. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

trait Amaley_Core_Cluster_Single_Widget_Controls {
    protected function add_cluster_source_controls() {
        $this->start_controls_section( 'source_section', array( 'label' => esc_html__( '1. Cluster Source / Preview', 'amaley-core' ) ) );
        $this->add_control( 'auto_detect', array( 'label' => esc_html__( 'Auto-detect from URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'amaley-core' ), 'label_off' => esc_html__( 'No', 'amaley-core' ), 'return_value' => '1', 'default' => '1', 'description' => esc_html__( 'Live page reads cluster_id or cluster_slug from URL. Use Preview Cluster ID while designing in Elementor.', 'amaley-core' ) ) );
        $this->add_control( 'preview_cluster_id', array( 'label' => esc_html__( 'Preview Cluster ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 0, 'default' => '', 'description' => esc_html__( 'Only for editor preview. Leave blank on final page if URL routing is active.', 'amaley-core' ) ) );
        $this->add_control( 'cluster_id', array( 'label' => esc_html__( 'Force Cluster ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 0, 'default' => '', 'description' => esc_html__( 'Optional. Use only if this widget should always show one fixed cluster.', 'amaley-core' ) ) );
        $this->add_control( 'cluster_slug', array( 'label' => esc_html__( 'Force Cluster Slug', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Optional slug fallback.', 'amaley-core' ) ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty / Missing Cluster Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Select a preview cluster in Elementor, or open this page from a cluster archive card.' ) );
        $this->end_controls_section();
    }

    protected function add_common_layout_controls( $label = 'Layout' ) {
        $this->start_controls_section( 'layout_section', array( 'label' => esc_html__( 'Layout / Alignment', 'amaley-core' ) ) );
        $this->add_responsive_control( 'content_align', array( 'label' => esc_html__( 'Content Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ) ), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .amcss-section' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'container_width', array( 'label' => esc_html__( 'Container Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-container' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_gap', array( 'label' => esc_html__( 'Inner Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 96 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-hero-grid, {{WRAPPER}} .amcss-story-grid, {{WRAPPER}} .amcss-cta-inner' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function add_section_style_controls() {
        $this->start_controls_section( 'section_style', array( 'label' => esc_html__( 'Section Background / Box', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-section' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'label' => esc_html__( 'Section Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-section' ) );
        $this->add_responsive_control( 'section_radius', array( 'label' => esc_html__( 'Section Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'section_shadow', 'label' => esc_html__( 'Section Shadow', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-section' ) );
        $this->end_controls_section();
    }

    protected function add_heading_style_controls() {
        /*
         * v1.0.100-safe-control-split
         * Live-site safe fix: section heading controls are now scoped only to
         * section heading elements. They no longer affect card labels, card
         * titles, card descriptions, stats/meta labels or OG card typography.
         *
         * This file update changes Elementor style selectors only. It does not
         * touch data queries, product/SHG/member/cluster mappings, images,
         * WooCommerce products, page routing, pagination or frontend content.
         */
        $this->start_controls_section( 'heading_style', array(
            'label' => esc_html__( 'Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_color', array(
            'label' => esc_html__( 'Section Label Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amcss-label' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typo',
            'label'    => esc_html__( 'Section Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-label',
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Section Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amcss-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'heading_color', array(
            'label' => esc_html__( 'Section Heading Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amcss-title, {{WRAPPER}} .amcss-heading h2, {{WRAPPER}} .amcss-story-copy h2, {{WRAPPER}} .amcss-cta h2' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'heading_typo',
            'label'    => esc_html__( 'Section Heading Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-title, {{WRAPPER}} .amcss-heading h2, {{WRAPPER}} .amcss-story-copy h2, {{WRAPPER}} .amcss-cta h2',
        ) );

        $this->add_responsive_control( 'heading_margin', array(
            'label'      => esc_html__( 'Section Heading Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amcss-title, {{WRAPPER}} .amcss-heading h2, {{WRAPPER}} .amcss-story-copy h2, {{WRAPPER}} .amcss-cta h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'text_color', array(
            'label' => esc_html__( 'Section Description/Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amcss-description, {{WRAPPER}} .amcss-heading p, {{WRAPPER}} .amcss-rich-text, {{WRAPPER}} .amcss-cta p' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'text_typo',
            'label'    => esc_html__( 'Section Description/Text Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-description, {{WRAPPER}} .amcss-heading p, {{WRAPPER}} .amcss-rich-text, {{WRAPPER}} .amcss-cta p',
        ) );

        $this->add_responsive_control( 'text_margin', array(
            'label'      => esc_html__( 'Section Text Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amcss-description, {{WRAPPER}} .amcss-heading p, {{WRAPPER}} .amcss-rich-text, {{WRAPPER}} .amcss-cta p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function add_card_style_controls() {
        $this->start_controls_section( 'card_style', array(
            'label' => esc_html__( 'Cards / Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'card_style_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => esc_html__( 'Card box controls and card text controls are separated here. Section Heading controls will not affect card title typography.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_control( 'card_box_heading', array(
            'label' => esc_html__( 'Card Box', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ) );

        $this->add_control( 'card_bg', array(
            'label' => esc_html__( 'Card Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media, {{WRAPPER}} .amaley-card' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'card_border',
            'label' => esc_html__( 'Card Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media, {{WRAPPER}} .amaley-card',
        ) );

        $this->add_responsive_control( 'card_padding', array(
            'label' => esc_html__( 'Card Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amcss-card-body, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-empty-card, {{WRAPPER}} .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'card_radius', array(
            'label' => esc_html__( 'Card Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array(
                '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media, {{WRAPPER}} .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'card_shadow',
            'label' => esc_html__( 'Card Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media, {{WRAPPER}} .amaley-card',
        ) );

        $this->add_responsive_control( 'card_gap', array(
            'label' => esc_html__( 'Card / Grid Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors' => array(
                '{{WRAPPER}} .amcss-card-grid, {{WRAPPER}} .amcss-snapshot-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'card_inner_gap', array(
            'label' => esc_html__( 'OG Card Inner Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-card__body' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'card_text_heading', array(
            'label' => esc_html__( 'Card Text / Typography', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'card_text_align', array(
            'label' => esc_html__( 'Card Text Alignment', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amcss-related-card .amcss-card-body, {{WRAPPER}} .amaley-card__body' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'card_label_color', array(
            'label' => esc_html__( 'Card Label Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amcss-related-card .amcss-card-label, {{WRAPPER}} .amaley-card__label' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'card_label_typography',
            'label' => esc_html__( 'Card Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-related-card .amcss-card-label, {{WRAPPER}} .amaley-card__label',
        ) );

        $this->add_responsive_control( 'card_label_margin', array(
            'label' => esc_html__( 'Card Label Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amcss-related-card .amcss-card-label, {{WRAPPER}} .amaley-card__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'card_title_color', array(
            'label' => esc_html__( 'Card Title Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amcss-related-card .amcss-card-body > h3, {{WRAPPER}} .amaley-card__title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'card_title_typography',
            'label' => esc_html__( 'Card Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-related-card .amcss-card-body > h3, {{WRAPPER}} .amaley-card__title',
        ) );

        $this->add_responsive_control( 'card_title_margin', array(
            'label' => esc_html__( 'Card Title Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amcss-related-card .amcss-card-body > h3, {{WRAPPER}} .amaley-card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'card_description_color', array(
            'label' => esc_html__( 'Card Description Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amcss-related-card .amcss-related-desc, {{WRAPPER}} .amaley-card__excerpt' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'card_description_typography',
            'label' => esc_html__( 'Card Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-related-card .amcss-related-desc, {{WRAPPER}} .amaley-card__excerpt',
        ) );

        $this->add_responsive_control( 'card_description_margin', array(
            'label' => esc_html__( 'Card Description Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amcss-related-card .amcss-related-desc, {{WRAPPER}} .amaley-card__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function add_image_style_controls() {
        $this->start_controls_section( 'image_style', array( 'label' => esc_html__( 'Image / Media', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 640 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-card-image, {{WRAPPER}} .amcss-hero-media, {{WRAPPER}} .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-card-image, {{WRAPPER}} .amcss-card-image img, {{WRAPPER}} .amcss-hero-media, {{WRAPPER}} .amcss-hero-media img, {{WRAPPER}} .amaley-card__media, {{WRAPPER}} .amaley-card__media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'fallback_bg', array( 'label' => esc_html__( 'Fallback Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-image-fallback, {{WRAPPER}} .amcss-card-image span, {{WRAPPER}} .amaley-card__media, {{WRAPPER}} .amaley-card__initials' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'fallback_color', array( 'label' => esc_html__( 'Fallback Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-image-fallback, {{WRAPPER}} .amcss-card-image span, {{WRAPPER}} .amaley-card__media, {{WRAPPER}} .amaley-card__initials' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    protected function add_chip_style_controls() {
        $this->start_controls_section( 'chip_style', array( 'label' => esc_html__( 'Tags / Chips', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'chip_gap', array( 'label' => esc_html__( 'Chip Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-chip-row, {{WRAPPER}} .amaley-card__tags' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'chip_bg', array( 'label' => esc_html__( 'Chip Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-chip-row, {{WRAPPER}} .amaley-card__tags span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'chip_color', array( 'label' => esc_html__( 'Chip Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-chip-row, {{WRAPPER}} .amaley-card__tags span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'chip_border', 'label' => esc_html__( 'Chip Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-chip-row, {{WRAPPER}} .amaley-card__tags span' ) );
        $this->add_responsive_control( 'chip_padding', array( 'label' => esc_html__( 'Chip Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-chip-row, {{WRAPPER}} .amaley-card__tags span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'chip_radius', array( 'label' => esc_html__( 'Chip Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-chip-row, {{WRAPPER}} .amaley-card__tags span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'chip_typo', 'label' => esc_html__( 'Chip Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-chip-row, {{WRAPPER}} .amaley-card__tags span' ) );
        $this->end_controls_section();
    }



    protected function add_meta_style_controls() {
        $this->start_controls_section( 'meta_style', array( 'label' => esc_html__( 'Meta / Detail Rows', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'meta_gap', array( 'label' => esc_html__( 'Meta Row Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'meta_label_color', array( 'label' => esc_html__( 'Meta Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta dt, {{WRAPPER}} .amcss-stat-label' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'meta_value_color', array( 'label' => esc_html__( 'Meta Value Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta dd, {{WRAPPER}} .amcss-stat-value' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_label_typo', 'label' => esc_html__( 'Meta Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta dt, {{WRAPPER}} .amcss-stat-label' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_value_typo', 'label' => esc_html__( 'Meta Value Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta dd, {{WRAPPER}} .amcss-stat-value' ) );
        $this->add_control( 'meta_box_bg', array( 'label' => esc_html__( 'Meta Row Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta div' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'meta_box_border', 'label' => esc_html__( 'Meta Row Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta div' ) );
        $this->add_responsive_control( 'meta_box_padding', array( 'label' => esc_html__( 'Meta Row Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'meta_box_radius', array( 'label' => esc_html__( 'Meta Row Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-meta-list, {{WRAPPER}} .amaley-card__meta div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function add_gallery_style_controls() {
        $this->start_controls_section( 'gallery_style', array( 'label' => esc_html__( 'Gallery Images', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'gallery_gap', array( 'label' => esc_html__( 'Gallery Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 64 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'gallery_image_height', array( 'label' => esc_html__( 'Gallery Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 120, 'max' => 720 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-gallery-grid figure' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'gallery_radius', array( 'label' => esc_html__( 'Gallery Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-gallery-grid figure, {{WRAPPER}} .amcss-gallery-grid img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'gallery_border', 'label' => esc_html__( 'Gallery Image Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-gallery-grid figure' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'gallery_shadow', 'label' => esc_html__( 'Gallery Shadow', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-gallery-grid figure' ) );
        $this->end_controls_section();
    }

    protected function add_button_style_controls() {
        $this->start_controls_section( 'button_style', array( 'label' => esc_html__( 'Buttons', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'button_gap', array( 'label' => esc_html__( 'Button Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 48 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-button-row' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-btn, {{WRAPPER}} .amcss-card-link, {{WRAPPER}} .amaley-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-btn, {{WRAPPER}} .amcss-card-link, {{WRAPPER}} .amaley-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'primary_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-primary, {{WRAPPER}} .amcss-card-link, {{WRAPPER}} .amaley-card__button' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-primary, {{WRAPPER}} .amcss-card-link, {{WRAPPER}} .amaley-card__button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_bg', array( 'label' => esc_html__( 'Secondary Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-secondary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_color', array( 'label' => esc_html__( 'Secondary Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-secondary' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typo', 'label' => esc_html__( 'Button Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-btn, {{WRAPPER}} .amcss-card-link, {{WRAPPER}} .amaley-card__button' ) );
        $this->add_responsive_control( 'section_action_align', array( 'label' => esc_html__( 'Section Button Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-h-align-right' ) ), 'default' => 'center', 'selectors' => array( '{{WRAPPER}} .amcss-section-action' => 'justify-content: {{VALUE}};' ) ) );
        $this->add_control( 'section_action_bg', array( 'label' => esc_html__( 'Section Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-section-link' => 'background: {{VALUE}} !important; border-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'section_action_color', array( 'label' => esc_html__( 'Section Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-section-link' => 'color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }
    protected function add_card_transform_controls() {
        $this->start_controls_section( 'card_transform_style', array(
            'label' => esc_html__( 'Card Transform / Motion', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'card_transform_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'These controls apply only to the card box. Default values keep the approved OG design unchanged.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_responsive_control( 'card_translate_y', array(
            'label' => esc_html__( 'Translate Y', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => -80, 'max' => 80 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-translate-y: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'card_scale', array(
            'label' => esc_html__( 'Scale', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( '' => array( 'min' => 0.80, 'max' => 1.20, 'step' => 0.01 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-scale: {{SIZE}};' ),
        ) );

        $this->add_responsive_control( 'card_rotate', array(
            'label' => esc_html__( 'Rotate', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'deg' ),
            'range' => array( 'deg' => array( 'min' => -8, 'max' => 8, 'step' => 0.1 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-rotate: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'card_hover_translate_y', array(
            'label' => esc_html__( 'Hover Translate Y', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => -80, 'max' => 80 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-card:hover' => '--amaley-og-card-hover-translate-y: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'card_hover_scale', array(
            'label' => esc_html__( 'Hover Scale', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( '' => array( 'min' => 0.80, 'max' => 1.20, 'step' => 0.01 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-card:hover' => '--amaley-og-card-hover-scale: {{SIZE}};' ),
        ) );

        $this->add_responsive_control( 'card_hover_rotate', array(
            'label' => esc_html__( 'Hover Rotate', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'deg' ),
            'range' => array( 'deg' => array( 'min' => -8, 'max' => 8, 'step' => 0.1 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-card:hover' => '--amaley-og-card-hover-rotate: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_control( 'card_transition_duration', array(
            'label' => esc_html__( 'Transition Duration', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range' => array( 'ms' => array( 'min' => 0, 'max' => 1500, 'step' => 50 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-transition-duration: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    protected function add_pagination_style_controls() {
        $this->start_controls_section( 'pagination_style', array(
            'label' => esc_html__( 'Pagination', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
            'selectors' => array( '{{WRAPPER}} .amcss-pagination' => 'justify-content: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'pagination_gap', array(
            'label' => esc_html__( 'Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( '{{WRAPPER}} .amcss-pagination' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'pagination_margin', array(
            'label' => esc_html__( 'Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amcss-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'pagination_padding', array(
            'label' => esc_html__( 'Button Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amcss-page-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'pagination_bg', array(
            'label' => esc_html__( 'Button Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amcss-page-link' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_color', array(
            'label' => esc_html__( 'Button Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amcss-page-link' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_active_bg', array(
            'label' => esc_html__( 'Current Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amcss-page-current' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_active_color', array(
            'label' => esc_html__( 'Current Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amcss-page-current' => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'pagination_border',
            'label' => esc_html__( 'Button Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-page-link',
        ) );

        $this->add_responsive_control( 'pagination_radius', array(
            'label' => esc_html__( 'Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( '{{WRAPPER}} .amcss-page-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'pagination_typography',
            'label' => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amcss-page-link, {{WRAPPER}} .amcss-page-ellipsis',
        ) );

        $this->end_controls_section();
    }

}
