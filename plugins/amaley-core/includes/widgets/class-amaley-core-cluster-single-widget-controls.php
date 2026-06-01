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
        $this->start_controls_section( 'heading_style', array( 'label' => esc_html__( 'Heading / Label / Text', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-label, {{WRAPPER}} .amcss-card-label, {{WRAPPER}} .amcss-stat-label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typo', 'label' => esc_html__( 'Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-label, {{WRAPPER}} .amcss-card-label, {{WRAPPER}} .amcss-stat-label' ) );
        $this->add_responsive_control( 'label_margin', array( 'label' => esc_html__( 'Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-title, {{WRAPPER}} .amcss-heading h2, {{WRAPPER}} .amcss-story-copy h2, {{WRAPPER}} .amcss-cta h2, {{WRAPPER}} .amcss-card h3' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typo', 'label' => esc_html__( 'Heading Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-title, {{WRAPPER}} .amcss-heading h2, {{WRAPPER}} .amcss-story-copy h2, {{WRAPPER}} .amcss-cta h2' ) );
        $this->add_responsive_control( 'heading_margin', array( 'label' => esc_html__( 'Heading Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-title, {{WRAPPER}} .amcss-heading h2, {{WRAPPER}} .amcss-story-copy h2, {{WRAPPER}} .amcss-cta h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'text_color', array( 'label' => esc_html__( 'Description/Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-description, {{WRAPPER}} .amcss-heading p, {{WRAPPER}} .amcss-rich-text, {{WRAPPER}} .amcss-card p, {{WRAPPER}} .amcss-cta p' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'text_typo', 'label' => esc_html__( 'Description/Text Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-description, {{WRAPPER}} .amcss-heading p, {{WRAPPER}} .amcss-rich-text, {{WRAPPER}} .amcss-card p, {{WRAPPER}} .amcss-cta p' ) );
        $this->add_responsive_control( 'text_margin', array( 'label' => esc_html__( 'Text Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-description, {{WRAPPER}} .amcss-heading p, {{WRAPPER}} .amcss-rich-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function add_card_style_controls() {
        $this->start_controls_section( 'card_style', array( 'label' => esc_html__( 'Cards / Boxes', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'label' => esc_html__( 'Card Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media' ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-card-body, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-empty-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'label' => esc_html__( 'Card Shadow', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-card, {{WRAPPER}} .amcss-stat-card, {{WRAPPER}} .amcss-side-box, {{WRAPPER}} .amcss-hero-media' ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => esc_html__( 'Card / Grid Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-card-grid, {{WRAPPER}} .amcss-snapshot-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function add_image_style_controls() {
        $this->start_controls_section( 'image_style', array( 'label' => esc_html__( 'Image / Media', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 640 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-card-image, {{WRAPPER}} .amcss-hero-media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-card-image, {{WRAPPER}} .amcss-card-image img, {{WRAPPER}} .amcss-hero-media, {{WRAPPER}} .amcss-hero-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'fallback_bg', array( 'label' => esc_html__( 'Fallback Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-image-fallback, {{WRAPPER}} .amcss-card-image span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'fallback_color', array( 'label' => esc_html__( 'Fallback Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-image-fallback, {{WRAPPER}} .amcss-card-image span' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    protected function add_chip_style_controls() {
        $this->start_controls_section( 'chip_style', array( 'label' => esc_html__( 'Tags / Chips', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'chip_gap', array( 'label' => esc_html__( 'Chip Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-chip-row' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'chip_bg', array( 'label' => esc_html__( 'Chip Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-chip-row span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'chip_color', array( 'label' => esc_html__( 'Chip Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-chip-row span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'chip_border', 'label' => esc_html__( 'Chip Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-chip-row span' ) );
        $this->add_responsive_control( 'chip_padding', array( 'label' => esc_html__( 'Chip Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-chip-row span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'chip_radius', array( 'label' => esc_html__( 'Chip Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-chip-row span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'chip_typo', 'label' => esc_html__( 'Chip Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-chip-row span' ) );
        $this->end_controls_section();
    }



    protected function add_meta_style_controls() {
        $this->start_controls_section( 'meta_style', array( 'label' => esc_html__( 'Meta / Detail Rows', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'meta_gap', array( 'label' => esc_html__( 'Meta Row Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amcss-meta-list' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'meta_label_color', array( 'label' => esc_html__( 'Meta Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-meta-list dt, {{WRAPPER}} .amcss-stat-label' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'meta_value_color', array( 'label' => esc_html__( 'Meta Value Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-meta-list dd, {{WRAPPER}} .amcss-stat-value' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_label_typo', 'label' => esc_html__( 'Meta Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-meta-list dt, {{WRAPPER}} .amcss-stat-label' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_value_typo', 'label' => esc_html__( 'Meta Value Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-meta-list dd, {{WRAPPER}} .amcss-stat-value' ) );
        $this->add_control( 'meta_box_bg', array( 'label' => esc_html__( 'Meta Row Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-meta-list div' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'meta_box_border', 'label' => esc_html__( 'Meta Row Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-meta-list div' ) );
        $this->add_responsive_control( 'meta_box_padding', array( 'label' => esc_html__( 'Meta Row Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-meta-list div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'meta_box_radius', array( 'label' => esc_html__( 'Meta Row Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-meta-list div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
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
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcss-btn, {{WRAPPER}} .amcss-card-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcss-btn, {{WRAPPER}} .amcss-card-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'primary_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-primary, {{WRAPPER}} .amcss-card-link' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-primary, {{WRAPPER}} .amcss-card-link' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_bg', array( 'label' => esc_html__( 'Secondary Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-secondary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_color', array( 'label' => esc_html__( 'Secondary Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-btn-secondary' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typo', 'label' => esc_html__( 'Button Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcss-btn, {{WRAPPER}} .amcss-card-link' ) );
        $this->add_responsive_control( 'section_action_align', array( 'label' => esc_html__( 'Section Button Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-h-align-right' ) ), 'default' => 'center', 'selectors' => array( '{{WRAPPER}} .amcss-section-action' => 'justify-content: {{VALUE}};' ) ) );
        $this->add_control( 'section_action_bg', array( 'label' => esc_html__( 'Section Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-section-link' => 'background: {{VALUE}} !important; border-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'section_action_color', array( 'label' => esc_html__( 'Section Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcss-section-link' => 'color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }
}
