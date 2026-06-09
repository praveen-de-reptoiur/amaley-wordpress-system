<?php
/** Shared full-control Elementor controls for SHG Single section widgets. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

trait Amaley_Core_SHG_Single_Widget_Controls {
    protected function add_shg_source_controls() {
        $this->start_controls_section( 'source', array( 'label' => esc_html__( '1. Data / Preview Source', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'amaley-core' ), 'label_off' => esc_html__( 'No', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'auto_detect', array( 'label' => esc_html__( 'Auto-detect from URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'amaley-core' ), 'label_off' => esc_html__( 'No', 'amaley-core' ), 'return_value' => '1', 'default' => '1', 'description' => esc_html__( 'Live detail page reads shg_slug or shg_id from the URL. Elementor preview automatically falls back to the first available SHG group; use Preview/Fixed fields only when you need a specific group while designing.', 'amaley-core' ) ) );
        $this->add_control( 'preview_shg_id', array( 'label' => esc_html__( 'Preview SHG ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 0, 'default' => '', 'description' => esc_html__( 'Optional. Use only when you want the Elementor editor to preview one specific SHG group.', 'amaley-core' ) ) );
        $this->add_control( 'shg_id', array( 'label' => esc_html__( 'Fixed SHG ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 0, 'default' => '', 'description' => esc_html__( 'Optional. Use only if this widget must always show one fixed SHG group.', 'amaley-core' ) ) );
        $this->add_control( 'shg_slug', array( 'label' => esc_html__( 'Fixed SHG Slug', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Optional. Use this to force a specific SHG group in Elementor/template preview.', 'amaley-core' ) ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty State Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Select a preview SHG group, or open this page from an SHG archive card.' ) );
        $this->end_controls_section();
    }

    protected function add_text_controls_from_defaults( $section_id, $label, $defaults, $skip = array() ) {
        $this->start_controls_section( $section_id, array( 'label' => esc_html( $label ) ) );
        foreach ( $defaults as $key => $value ) {
            if ( in_array( $key, $skip, true ) || in_array( $key, array( 'shg_id','shg_slug','preview_shg_id','auto_detect','empty_message','show_section' ), true ) ) { continue; }
            $clean_label = esc_html( ucwords( str_replace( '_', ' ', $key ) ) );
            if ( 'enable_pagination' === $key ) {
                $this->add_control( $key, array(
                    'label' => esc_html__( 'Enable Pagination', 'amaley-core' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', 'amaley-core' ),
                    'label_off' => esc_html__( 'No', 'amaley-core' ),
                    'return_value' => '1',
                    'default' => (string) $value,
                    'description' => esc_html__( 'Shows page numbers when total linked cards are more than the Number of Cards / Limit.', 'amaley-core' ),
                    'render_type' => 'none',
                ) );
            } elseif ( 'card_template' === $key ) {
                $this->add_control( $key, array(
                    'label' => esc_html__( 'Card Template', 'amaley-core' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => (string) $value,
                    'options' => array(
                        'current_existing' => esc_html__( 'Current / Existing Card', 'amaley-core' ),
                        'og_card_1' => esc_html__( 'OG Card 1', 'amaley-core' ),
                    ),
                    'description' => esc_html__( 'Choose Current layout or approved OG Card 1.', 'amaley-core' ),
                ) );
            } elseif ( preg_match( '/^(show_)/', $key ) ) {
                $this->add_control( $key, array( 'label' => $clean_label, 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => (string) $value ) );
            } elseif ( preg_match( '/(columns|limit|words|clamp|max_)/', $key ) ) {
                $this->add_control( $key, array( 'label' => $clean_label, 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 0, 'default' => is_numeric( $value ) ? (int) $value : $value ) );
            } elseif ( false !== strpos( $key, 'url' ) ) {
                $this->add_control( $key, array( 'label' => $clean_label, 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => (string) $value ), 'placeholder' => esc_html__( 'https://your-link.com', 'amaley-core' ) ) );
            } elseif ( false !== strpos( $key, 'description' ) || false !== strpos( $key, 'message' ) || false !== strpos( $key, 'note' ) ) {
                $this->add_control( $key, array( 'label' => $clean_label, 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => (string) $value, 'rows' => 3 ) );
            } else {
                $this->add_control( $key, array( 'label' => $clean_label, 'type' => \Elementor\Controls_Manager::TEXT, 'default' => (string) $value ) );
            }
        }
        $this->end_controls_section();
    }

    protected function add_shg_full_style_controls( $scope = 'section' ) {
        if ( 'hero' === $scope ) {
            $this->add_shg_hero_style_controls();
            return;
        }

        /*
         * v1.0.111-live-safe-scope-cleanup
         * Do not show every shared control on every SHG Single widget.
         * CTA/Contact/Story sections should only expose controls for elements
         * that actually exist in those sections. Card-only controls are limited
         * to linked cluster, related members and related products widgets.
         */
        $is_og_card_scope          = in_array( $scope, array( 'cluster', 'members', 'products' ), true );
        $has_current_card_controls = in_array( $scope, array( 'cluster', 'members', 'products' ), true );
        $has_image_controls        = in_array( $scope, array( 'cluster', 'members', 'products', 'gallery', 'snapshot' ), true );
        $has_meta_controls         = in_array( $scope, array( 'cluster', 'members', 'products', 'snapshot' ), true );
        $has_grid_controls         = in_array( $scope, array( 'cluster', 'members', 'products', 'gallery', 'snapshot' ), true );
        $has_section_button        = in_array( $scope, array( 'cluster', 'members', 'products', 'cta', 'contact' ), true );
        $legacy_card_condition     = $is_og_card_scope ? array( 'card_template' => 'current_existing' ) : array();

        $this->start_controls_section( 'layout_align_controls', array( 'label' => esc_html__( '2. Layout / Alignment', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_align', array( 'label' => esc_html__( 'Section Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ) ), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .amss-section' => 'text-align: {{VALUE}};' ) ) );
        /*
         * v1.0.111-live-safe
         * Keep section button alignment separate from card button alignment.
         * Earlier selector grouped .amss-actions, .amss-card-actions and
         * .amss-section-actions together, which caused section buttons and
         * card buttons to move/style together on Linked Cluster and Related
         * Members widgets.
         */
        $this->add_responsive_control( 'section_button_align', array(
            'label' => esc_html__( 'Section Button Alignment', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-align-start-h' ),
                'center'     => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-align-center-h' ),
                'flex-end'   => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-align-end-h' ),
            ),
            'default' => 'flex-start',
            'selectors' => array(
                '{{WRAPPER}} .amss-section-actions, {{WRAPPER}} .amss-contact .amss-actions, {{WRAPPER}} .amss-cta .amss-actions' => 'justify-content: {{VALUE}};',
            ),
        ) );

        if ( $has_current_card_controls ) {
            $this->add_responsive_control( 'card_button_align', array(
                'label' => esc_html__( 'Card Button Alignment', 'amaley-core' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-align-start-h' ),
                    'center'     => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-align-center-h' ),
                    'flex-end'   => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-align-end-h' ),
                ),
                'default' => 'center',
                'selectors' => array(
                    '{{WRAPPER}} .amss-card-actions, {{WRAPPER}} .amss-product-actions' => 'justify-content: {{VALUE}};',
                ),
                'condition' => $legacy_card_condition,
            ) );
        }
        $this->add_responsive_control( 'content_width', array( 'label' => esc_html__( 'Content Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 640, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amss-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        if ( $has_grid_controls ) {
            $this->add_responsive_control( 'columns_desktop_style', array( 'label' => esc_html__( 'Columns Override', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '' ), 'range' => array( '' => array( 'min' => 1, 'max' => 5, 'step' => 1 ) ), 'selectors' => array( '{{WRAPPER}} .amss-grid, {{WRAPPER}} .amss-gallery-grid, {{WRAPPER}} .amss-snapshot-grid' => '--amss-cols: {{SIZE}};' ) ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'section_background_controls', array( 'label' => esc_html__( '3. Section Background', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amss-section' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'section_background', 'label' => esc_html__( 'Background', 'amaley-core' ), 'types' => array( 'classic', 'gradient' ), 'selector' => '{{WRAPPER}} .amss-section' ) );
        $this->add_control( 'section_overlay_opacity', array( 'label' => esc_html__( 'Overlay / Texture Opacity', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amss-section:before' => 'opacity: calc({{SIZE}} / 100);' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_spacing_controls', array( 'label' => esc_html__( '4. Section Spacing', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amss-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amss-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Grid / Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 64 ) ), 'selectors' => array( '{{WRAPPER}} .amss-grid, {{WRAPPER}} .amss-gallery-grid, {{WRAPPER}} .amss-snapshot-grid, {{WRAPPER}} .amss-hero-grid, {{WRAPPER}} .amss-story-grid, {{WRAPPER}} .amss-cta-inner' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'heading_text_controls', array( 'label' => esc_html__( '5. Section Heading / Text Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        /*
         * v1.0.108-live-safe-control-split
         * Keep section typography separate from card typography. Do not target
         * .amss-card-label, .amss-card-title, .amss-card-text or OG card text here.
         */
        $this->add_control( 'label_color', array(
            'label' => esc_html__( 'Section Label Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-label' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'label_typography',
            'label' => esc_html__( 'Section Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-label',
        ) );
        $this->add_responsive_control( 'label_margin', array(
            'label' => esc_html__( 'Section Label Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amss-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'heading_color', array(
            'label' => esc_html__( 'Section Heading Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-title, {{WRAPPER}} .amss-heading h2' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'heading_typography',
            'label' => esc_html__( 'Section Heading Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-title, {{WRAPPER}} .amss-heading h2',
        ) );
        $this->add_responsive_control( 'heading_margin', array(
            'label' => esc_html__( 'Section Heading Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amss-title, {{WRAPPER}} .amss-heading h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'body_color', array(
            'label' => esc_html__( 'Section Body Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-description, {{WRAPPER}} .amss-rich-text, {{WRAPPER}} .amss-section > p, {{WRAPPER}} .amss-heading p' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'body_typography',
            'label' => esc_html__( 'Section Body Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-description, {{WRAPPER}} .amss-rich-text, {{WRAPPER}} .amss-section > p, {{WRAPPER}} .amss-heading p',
        ) );
        $this->add_responsive_control( 'body_margin', array(
            'label' => esc_html__( 'Section Body Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amss-description, {{WRAPPER}} .amss-rich-text, {{WRAPPER}} .amss-section > p, {{WRAPPER}} .amss-heading p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->end_controls_section();

        if ( $has_current_card_controls ) {
        $current_card_text_section_args = array(
            'label' => esc_html__( '5B. Current Card Text / Typography', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        );
        if ( ! empty( $legacy_card_condition ) ) { $current_card_text_section_args['condition'] = $legacy_card_condition; }
        $this->start_controls_section( 'current_card_text_controls', $current_card_text_section_args );
        $this->add_responsive_control( 'current_card_text_align', array(
            'label' => esc_html__( 'Card Text Alignment', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( '{{WRAPPER}} .amss-card-body, {{WRAPPER}} .amss-linked-body, {{WRAPPER}} .amss-product-body, {{WRAPPER}} .amss-stat-card, {{WRAPPER}} .amss-story-card, {{WRAPPER}} .amss-side-card' => 'text-align: {{VALUE}};' ),
        ) );
        $this->add_control( 'current_card_label_color', array(
            'label' => esc_html__( 'Card Label Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-card-label, {{WRAPPER}} .amss-stat-label' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'current_card_label_typography',
            'label' => esc_html__( 'Card Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-card-label, {{WRAPPER}} .amss-stat-label',
        ) );
        $this->add_responsive_control( 'current_card_label_margin', array(
            'label' => esc_html__( 'Card Label Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amss-card-label, {{WRAPPER}} .amss-stat-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->add_control( 'current_card_title_color', array(
            'label' => esc_html__( 'Card Title Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-card-title' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'current_card_title_typography',
            'label' => esc_html__( 'Card Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-card-title',
        ) );
        $this->add_responsive_control( 'current_card_title_margin', array(
            'label' => esc_html__( 'Card Title Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amss-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->add_control( 'current_card_text_color', array(
            'label' => esc_html__( 'Card Description Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-card-text' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'current_card_text_typography',
            'label' => esc_html__( 'Card Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-card-text',
        ) );
        $this->add_responsive_control( 'current_card_text_margin', array(
            'label' => esc_html__( 'Card Description Margin', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amss-card-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->end_controls_section();

        }

        if ( $has_current_card_controls ) {
        $card_box_section_args = array( 'label' => esc_html__( '6. Current Card / Box Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE );
        if ( ! empty( $legacy_card_condition ) ) { $card_box_section_args['condition'] = $legacy_card_condition; }
        $this->start_controls_section( 'card_box_controls', $card_box_section_args );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amss-card, {{WRAPPER}} .amss-network-card, {{WRAPPER}} .amss-member-card, {{WRAPPER}} .amss-cluster-lock-card, {{WRAPPER}} .amss-stat-card, {{WRAPPER}} .amss-story-card, {{WRAPPER}} .amss-side-card, {{WRAPPER}} .amss-linked-card, {{WRAPPER}} .amss-product-card, {{WRAPPER}} .amss-final-product-card' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amss-card-body, {{WRAPPER}} .amss-stat-card, {{WRAPPER}} .amss-story-card, {{WRAPPER}} .amss-side-card, {{WRAPPER}} .amss-linked-body, {{WRAPPER}} .amss-product-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amss-card, {{WRAPPER}} .amss-network-card, {{WRAPPER}} .amss-member-card, {{WRAPPER}} .amss-cluster-lock-card, {{WRAPPER}} .amss-stat-card, {{WRAPPER}} .amss-story-card, {{WRAPPER}} .amss-side-card, {{WRAPPER}} .amss-linked-card, {{WRAPPER}} .amss-product-card, {{WRAPPER}} .amss-final-product-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .amss-card, {{WRAPPER}} .amss-network-card, {{WRAPPER}} .amss-member-card, {{WRAPPER}} .amss-cluster-lock-card, {{WRAPPER}} .amss-stat-card, {{WRAPPER}} .amss-story-card, {{WRAPPER}} .amss-side-card, {{WRAPPER}} .amss-linked-card, {{WRAPPER}} .amss-product-card, {{WRAPPER}} .amss-final-product-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amss-card, {{WRAPPER}} .amss-network-card, {{WRAPPER}} .amss-member-card, {{WRAPPER}} .amss-cluster-lock-card, {{WRAPPER}} .amss-stat-card, {{WRAPPER}} .amss-story-card, {{WRAPPER}} .amss-side-card, {{WRAPPER}} .amss-linked-card, {{WRAPPER}} .amss-product-card, {{WRAPPER}} .amss-final-product-card' ) );
        $this->end_controls_section();

        }

        if ( $has_image_controls ) {
        $image_section_args = array( 'label' => esc_html__( '7. Current Image / Gallery Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE );
        if ( ! empty( $legacy_card_condition ) ) { $image_section_args['condition'] = $legacy_card_condition; }
        $this->start_controls_section( 'image_controls', $image_section_args );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 60, 'max' => 560 ) ), 'selectors' => array( '{{WRAPPER}} .amss-image, {{WRAPPER}} .amss-linked-image, {{WRAPPER}} .amss-card-image, {{WRAPPER}} .amss-gallery-item, {{WRAPPER}} .amss-product-image' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amss-image, {{WRAPPER}} .amss-linked-image, {{WRAPPER}} .amss-card-image, {{WRAPPER}} .amss-gallery-item, {{WRAPPER}} .amss-product-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'image_opacity', array( 'label' => esc_html__( 'Image Opacity', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 20, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amss-image img, {{WRAPPER}} .amss-linked-image img, {{WRAPPER}} .amss-card-image img, {{WRAPPER}} .amss-gallery-item img, {{WRAPPER}} .amss-product-image img' => 'opacity: calc({{SIZE}} / 100);' ) ) );
        $this->end_controls_section();

        }

        if ( $has_meta_controls ) {
        $meta_section_args = array( 'label' => esc_html__( '8. Current Details / Tags / Badges', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE );
        if ( ! empty( $legacy_card_condition ) ) { $meta_section_args['condition'] = $legacy_card_condition; }
        $this->start_controls_section( 'meta_tag_controls', $meta_section_args );
        $this->add_control( 'meta_bg', array( 'label' => esc_html__( 'Meta Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amss-card-meta div, {{WRAPPER}} .amss-product-meta div, {{WRAPPER}} .amss-meta-box, {{WRAPPER}} .amss-chip, {{WRAPPER}} .amss-badge' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'meta_text_color', array( 'label' => esc_html__( 'Meta / Tag Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amss-card-meta dt, {{WRAPPER}} .amss-card-meta dd, {{WRAPPER}} .amss-product-meta span, {{WRAPPER}} .amss-product-meta strong, {{WRAPPER}} .amss-meta-box, {{WRAPPER}} .amss-chip, {{WRAPPER}} .amss-badge' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'chip_gap', array( 'label' => esc_html__( 'Tag Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}} .amss-chip-row' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        }

        /*
         * v1.0.111-live-safe
         * Button controls are intentionally split into two sections:
         * 1) Section Button: only .amss-section-button / CTA action buttons.
         * 2) Current Card Buttons: only .amss-card-link / .amss-product-button.
         *
         * This fixes the live-site issue where changing button text color on
         * SHG Linked Cluster or SHG Related Members changed both the card
         * button and the section button together.
         */
        if ( $has_section_button ) {
        $this->start_controls_section( 'section_button_controls', array(
            'label' => esc_html__( '9A. Section Button', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'section_button_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => esc_html__( 'These controls target only the section-level button such as View All Clusters / View All Producers. They do not style card buttons.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_responsive_control( 'section_button_gap', array(
            'label' => esc_html__( 'Button Row Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
            'selectors' => array(
                '{{WRAPPER}} .amss-section-actions, {{WRAPPER}} .amss-contact .amss-actions, {{WRAPPER}} .amss-cta .amss-actions' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'section_button_width', array(
            'label' => esc_html__( 'Section Button Width', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'auto',
            'options' => array(
                'auto' => esc_html__( 'Auto', 'amaley-core' ),
                '100%' => esc_html__( 'Full Width', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button' => 'width: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'section_button_padding', array(
            'label' => esc_html__( 'Section Button Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button, {{WRAPPER}} .amss-contact .amss-btn, {{WRAPPER}} .amss-cta .amss-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_button_radius', array(
            'label' => esc_html__( 'Section Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button, {{WRAPPER}} .amss-contact .amss-btn, {{WRAPPER}} .amss-cta .amss-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'section_button_typography',
            'selector' => '{{WRAPPER}} .amss-section-button, {{WRAPPER}} .amss-contact .amss-btn, {{WRAPPER}} .amss-cta .amss-btn',
        ) );

        $this->start_controls_tabs( 'section_button_state_tabs' );

        $this->start_controls_tab( 'section_button_state_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'section_button_bg', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button, {{WRAPPER}} .amss-contact .amss-btn-primary, {{WRAPPER}} .amss-cta .amss-btn-primary' => 'background: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'section_button_text_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button, {{WRAPPER}} .amss-contact .amss-btn-primary, {{WRAPPER}} .amss-cta .amss-btn-primary' => 'color: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'section_button_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button, {{WRAPPER}} .amss-contact .amss-btn-primary, {{WRAPPER}} .amss-cta .amss-btn-primary' => 'border-color: {{VALUE}};',
            ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'section_button_shadow',
            'selector' => '{{WRAPPER}} .amss-section-button, {{WRAPPER}} .amss-contact .amss-btn-primary, {{WRAPPER}} .amss-cta .amss-btn-primary',
        ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'section_button_state_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'section_button_hover_bg', array(
            'label' => esc_html__( 'Hover Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button:hover, {{WRAPPER}} .amss-contact .amss-btn-primary:hover, {{WRAPPER}} .amss-cta .amss-btn-primary:hover' => 'background: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'section_button_hover_text_color', array(
            'label' => esc_html__( 'Hover Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button:hover, {{WRAPPER}} .amss-contact .amss-btn-primary:hover, {{WRAPPER}} .amss-cta .amss-btn-primary:hover' => 'color: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'section_button_hover_border_color', array(
            'label' => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-section-button:hover, {{WRAPPER}} .amss-contact .amss-btn-primary:hover, {{WRAPPER}} .amss-cta .amss-btn-primary:hover' => 'border-color: {{VALUE}};',
            ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'section_button_hover_shadow',
            'selector' => '{{WRAPPER}} .amss-section-button:hover, {{WRAPPER}} .amss-contact .amss-btn-primary:hover, {{WRAPPER}} .amss-cta .amss-btn-primary:hover',
        ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        }

        if ( $has_current_card_controls ) {
        $card_button_section_args = array(
            'label' => esc_html__( '9B. Current Card Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        );
        if ( ! empty( $legacy_card_condition ) ) { $card_button_section_args['condition'] = $legacy_card_condition; }
        $this->start_controls_section( 'card_button_controls', $card_button_section_args );

        $this->add_control( 'card_button_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => esc_html__( 'These controls target only card buttons such as View Cluster Story / View Producer Profile / View Product. They do not style section buttons.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_responsive_control( 'card_button_row_gap', array(
            'label' => esc_html__( 'Card Button Row Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
            'selectors' => array(
                '{{WRAPPER}} .amss-card-actions, {{WRAPPER}} .amss-product-actions' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'card_button_width', array(
            'label' => esc_html__( 'Card Button Width', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '100%',
            'options' => array(
                'auto' => esc_html__( 'Auto', 'amaley-core' ),
                '100%' => esc_html__( 'Full Width', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button' => 'width: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'card_button_padding', array(
            'label' => esc_html__( 'Card Button Padding', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'card_button_radius', array(
            'label' => esc_html__( 'Card Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'card_button_typography',
            'selector' => '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button',
        ) );

        $this->start_controls_tabs( 'card_button_state_tabs' );

        $this->start_controls_tab( 'card_button_state_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'card_button_bg', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button' => 'background: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'card_button_text_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button' => 'color: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'card_button_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button' => 'border-color: {{VALUE}};',
            ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'card_button_shadow',
            'selector' => '{{WRAPPER}} .amss-card-link, {{WRAPPER}} .amss-product-button',
        ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'card_button_state_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'card_button_hover_bg', array(
            'label' => esc_html__( 'Hover Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link:hover, {{WRAPPER}} .amss-product-button:hover' => 'background: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'card_button_hover_text_color', array(
            'label' => esc_html__( 'Hover Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link:hover, {{WRAPPER}} .amss-product-button:hover' => 'color: {{VALUE}};',
            ),
        ) );
        $this->add_control( 'card_button_hover_border_color', array(
            'label' => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-card-link:hover, {{WRAPPER}} .amss-product-button:hover' => 'border-color: {{VALUE}};',
            ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'card_button_hover_shadow',
            'selector' => '{{WRAPPER}} .amss-card-link:hover, {{WRAPPER}} .amss-product-button:hover',
        ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        }

        if ( $has_current_card_controls ) {
        $motion_section_args = array( 'label' => esc_html__( '10. Current Card Motion / Transform', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE );
        if ( ! empty( $legacy_card_condition ) ) { $motion_section_args['condition'] = $legacy_card_condition; }
        $this->start_controls_section( 'motion_controls', $motion_section_args );
        $this->add_control( 'motion_enabled', array( 'label' => esc_html__( 'Enable Smooth Motion', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'selectors' => array( '{{WRAPPER}} .amss-section' => '--amss-motion-enabled: 1;' ) ) );
        $this->add_control( 'hover_lift', array( 'label' => esc_html__( 'Hover Lift', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 12 ) ), 'default' => array( 'size' => 2, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amss-section' => '--amss-hover-lift: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'image_zoom', array( 'label' => esc_html__( 'Image Hover Zoom', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1.025', 'options' => array( '1' => esc_html__( 'None', 'amaley-core' ), '1.012' => esc_html__( 'Very Soft', 'amaley-core' ), '1.025' => esc_html__( 'Soft', 'amaley-core' ), '1.04' => esc_html__( 'Visible', 'amaley-core' ) ), 'selectors' => array( '{{WRAPPER}} .amss-section' => '--amss-image-zoom: {{VALUE}};' ) ) );
        $this->add_control( 'motion_duration', array( 'label' => esc_html__( 'Motion Duration', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'ms' ), 'range' => array( 'ms' => array( 'min' => 100, 'max' => 900 ) ), 'default' => array( 'size' => 220, 'unit' => 'ms' ), 'selectors' => array( '{{WRAPPER}} .amss-section' => '--amss-motion-duration: {{SIZE}}ms;' ) ) );
        $this->end_controls_section();

        }

        if ( $is_og_card_scope ) {
            $this->add_shg_og_card_full_controls( $scope );
            $this->add_shg_pagination_style_controls( $scope );
        }
    }
    protected function add_shg_og_card_full_controls( $scope = 'section' ) {
        $this->start_controls_section( 'og_card_full_controls', array(
            'label' => esc_html__( 'OG Card: Full Controls', 'amaley-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'card_template' => 'og_card_1' ),
        ) );

        $this->add_control( 'og_card_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'These controls target OG Card 1 only. They match the Cluster Single and Member Single control standard.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_control( 'og_box_heading', array( 'label' => esc_html__( 'Card Box', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'og_card_background', 'selector' => '{{WRAPPER}} .amaley-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'og_card_border', 'selector' => '{{WRAPPER}} .amaley-card' ) );
        $this->add_responsive_control( 'og_card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'og_card_shadow', 'selector' => '{{WRAPPER}} .amaley-card' ) );
        $this->add_responsive_control( 'og_card_body_padding', array( 'label' => esc_html__( 'Card Body Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_card_inner_gap', array( 'label' => esc_html__( 'Card Inner Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card__body' => 'gap: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'og_media_heading', array( 'label' => esc_html__( 'Image / Placeholder Area', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'og_media_height', array( 'label' => esc_html__( 'Image / Placeholder Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 60, 'max' => 520 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_media_radius', array( 'label' => esc_html__( 'Image / Placeholder Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__media, {{WRAPPER}} .amaley-card__media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'og_media_bg', array( 'label' => esc_html__( 'Placeholder Area Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__media' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'og_initials_bg', array( 'label' => esc_html__( 'Initials Circle Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__initials' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'og_initials_color', array( 'label' => esc_html__( 'Initials Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__initials' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_initials_typography', 'selector' => '{{WRAPPER}} .amaley-card__initials' ) );

        $this->add_control( 'og_label_heading', array( 'label' => esc_html__( 'Card Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_label_typography', 'selector' => '{{WRAPPER}} .amaley-card__label' ) );
        $this->add_control( 'og_label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__label' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'og_label_margin', array( 'label' => esc_html__( 'Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );

        $this->add_control( 'og_title_heading', array( 'label' => esc_html__( 'Card Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_title_typography', 'selector' => '{{WRAPPER}} .amaley-card__title' ) );
        $this->add_control( 'og_title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__title' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'og_title_margin', array( 'label' => esc_html__( 'Title Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );

        $this->add_control( 'og_excerpt_heading', array( 'label' => esc_html__( 'Card Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_excerpt_typography', 'selector' => '{{WRAPPER}} .amaley-card__excerpt' ) );
        $this->add_control( 'og_excerpt_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__excerpt' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'og_excerpt_margin', array( 'label' => esc_html__( 'Description Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_excerpt_min_height', array( 'label' => esc_html__( 'Description Min Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 180 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card__excerpt' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'og_meta_heading', array( 'label' => esc_html__( 'Meta / Stat Boxes', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'og_meta_gap', array( 'label' => esc_html__( 'Meta Box Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card__meta' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_meta_columns', array( 'label' => esc_html__( 'Meta Box Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'selectors' => array( '{{WRAPPER}} .amaley-card__meta' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
        $this->add_control( 'og_meta_bg', array( 'label' => esc_html__( 'Meta Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__meta-item' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'og_meta_border', 'selector' => '{{WRAPPER}} .amaley-card__meta-item' ) );
        $this->add_responsive_control( 'og_meta_padding', array( 'label' => esc_html__( 'Meta Box Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__meta-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_meta_radius', array( 'label' => esc_html__( 'Meta Box Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__meta-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_meta_min_height', array( 'label' => esc_html__( 'Meta Box Min Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 180 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card__meta-item' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_meta_label_typography', 'selector' => '{{WRAPPER}} .amaley-card__meta span' ) );
        $this->add_control( 'og_meta_label_color', array( 'label' => esc_html__( 'Meta Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__meta span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_meta_value_typography', 'selector' => '{{WRAPPER}} .amaley-card__meta strong' ) );
        $this->add_control( 'og_meta_value_color', array( 'label' => esc_html__( 'Meta Value Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__meta strong' => 'color: {{VALUE}};' ) ) );

        $this->add_control( 'og_tags_heading', array( 'label' => esc_html__( 'Tags / Chips', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'og_tags_gap', array( 'label' => esc_html__( 'Tags Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card__tags' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_tags_typography', 'selector' => '{{WRAPPER}} .amaley-card__tags span' ) );
        $this->add_control( 'og_tags_color', array( 'label' => esc_html__( 'Tags Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__tags span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'og_tags_bg', array( 'label' => esc_html__( 'Tags Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__tags span' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'og_tags_border', 'selector' => '{{WRAPPER}} .amaley-card__tags span' ) );
        $this->add_responsive_control( 'og_tags_padding', array( 'label' => esc_html__( 'Tags Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__tags span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_tags_radius', array( 'label' => esc_html__( 'Tags Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__tags span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );

        $this->add_control( 'og_button_heading', array( 'label' => esc_html__( 'Card Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'og_button_typography', 'selector' => '{{WRAPPER}} .amaley-card__button' ) );
        $this->add_responsive_control( 'og_button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_button_margin', array( 'label' => esc_html__( 'Button Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-card__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );

        $this->start_controls_tabs( 'og_button_state_tabs' );
        $this->start_controls_tab( 'og_button_state_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'og_button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'og_button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__button' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'og_button_border_color', array( 'label' => esc_html__( 'Button Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__button' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'og_button_shadow', 'selector' => '{{WRAPPER}} .amaley-card__button' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'og_button_state_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'og_button_hover_color', array( 'label' => esc_html__( 'Button Hover Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__button:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'og_button_hover_bg', array( 'label' => esc_html__( 'Button Hover Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__button:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'og_button_hover_border_color', array( 'label' => esc_html__( 'Button Hover Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-card__button:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'og_button_hover_shadow', 'selector' => '{{WRAPPER}} .amaley-card__button:hover' ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'og_transform_heading', array( 'label' => esc_html__( 'Transform / Motion', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'og_card_translate_y', array( 'label' => esc_html__( 'Translate Y', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => -80, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-translate-y: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_card_scale', array( 'label' => esc_html__( 'Scale', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '' => array( 'min' => 0.80, 'max' => 1.20, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-scale: {{SIZE}};' ) ) );
        $this->add_responsive_control( 'og_card_rotate', array( 'label' => esc_html__( 'Rotate', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'deg' ), 'range' => array( 'deg' => array( 'min' => -8, 'max' => 8, 'step' => 0.1 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-rotate: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_card_hover_translate_y', array( 'label' => esc_html__( 'Hover Translate Y', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => -80, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card:hover' => '--amaley-og-card-hover-translate-y: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'og_card_hover_scale', array( 'label' => esc_html__( 'Hover Scale', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '' => array( 'min' => 0.80, 'max' => 1.20, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card:hover' => '--amaley-og-card-hover-scale: {{SIZE}};' ) ) );
        $this->add_responsive_control( 'og_card_hover_rotate', array( 'label' => esc_html__( 'Hover Rotate', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'deg' ), 'range' => array( 'deg' => array( 'min' => -8, 'max' => 8, 'step' => 0.1 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card:hover' => '--amaley-og-card-hover-rotate: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'og_card_transition_duration', array( 'label' => esc_html__( 'Transition Duration', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'ms' ), 'range' => array( 'ms' => array( 'min' => 0, 'max' => 1500, 'step' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-card' => '--amaley-og-card-transition-duration: {{SIZE}}{{UNIT}};' ) ) );

        $this->end_controls_section();
    }



    /**
     * v1.0.109-live-safe
     * Dedicated SHG Single Hero controls.
     *
     * Reason: the theme CSS uses hero-specific selectors like
     * `.amss-hero .amss-title`, so generic controls such as `.amss-title`
     * can lose priority and appear as "not working" in Elementor. These
     * controls target only the hero widget markup and do not touch SHG data,
     * mappings, products, members, gallery items or page content.
     */
    protected function add_shg_hero_style_controls() {
        $this->start_controls_section( 'hero_section_box_controls', array(
            'label' => esc_html__( '2. Hero Section / Background', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'hero_section_background',
            'label'    => esc_html__( 'Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amss-section.amss-hero',
        ) );

        $this->add_control( 'hero_section_text_color', array(
            'label' => esc_html__( 'Base Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-section.amss-hero' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-section.amss-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-section.amss-hero' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_section_min_height', array(
            'label'      => esc_html__( 'Minimum Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range'      => array(
                'px' => array( 'min' => 260, 'max' => 900 ),
                'vh' => array( 'min' => 20, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-section.amss-hero' => 'min-height: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'hero_section_border',
            'selector' => '{{WRAPPER}} .amss-section.amss-hero',
        ) );

        $this->add_responsive_control( 'hero_section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-section.amss-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_section_shadow',
            'selector' => '{{WRAPPER}} .amss-section.amss-hero',
        ) );

        $this->add_control( 'hero_overlay_opacity', array(
            'label'      => esc_html__( 'Overlay / Texture Opacity', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( '%' ),
            'range'      => array( '%' => array( 'min' => 0, 'max' => 100 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-section.amss-hero:before' => 'opacity: calc({{SIZE}} / 100);',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'hero_layout_controls', array(
            'label' => esc_html__( '3. Hero Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'hero_container_width', array(
            'label'      => esc_html__( 'Container Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 720, 'max' => 1800 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_grid_gap', array(
            'label'      => esc_html__( 'Copy / Panel Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_copy_width', array(
            'label'      => esc_html__( 'Copy Column Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'fr' ),
            'range'      => array( 'fr' => array( 'min' => 0.6, 'max' => 1.8, 'step' => 0.05 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-grid' => 'grid-template-columns: minmax(0, {{SIZE}}fr) minmax(300px, .82fr);',
            ),
        ) );

        $this->add_responsive_control( 'hero_vertical_align', array(
            'label' => esc_html__( 'Vertical Align', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'start'  => array( 'title' => esc_html__( 'Top', 'amaley-core' ), 'icon' => 'eicon-v-align-top' ),
                'center' => array( 'title' => esc_html__( 'Middle', 'amaley-core' ), 'icon' => 'eicon-v-align-middle' ),
                'end'    => array( 'title' => esc_html__( 'Bottom', 'amaley-core' ), 'icon' => 'eicon-v-align-bottom' ),
            ),
            'default'   => 'center',
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-hero-grid' => 'align-items: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_text_align', array(
            'label' => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'default'   => 'left',
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-hero-copy' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_panel_gap', array(
            'label'      => esc_html__( 'Image / Stats Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-panel' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'hero_breadcrumb_controls', array(
            'label' => esc_html__( '4. Breadcrumb', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'hero_breadcrumb_color', array(
            'label' => esc_html__( 'Breadcrumb Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-breadcrumb, {{WRAPPER}} .amss-hero .amss-breadcrumb strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_breadcrumb_link_color', array(
            'label' => esc_html__( 'Breadcrumb Link Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-breadcrumb a' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_breadcrumb_separator_color', array(
            'label' => esc_html__( 'Separator Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-breadcrumb span' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_breadcrumb_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-breadcrumb, {{WRAPPER}} .amss-hero .amss-breadcrumb a, {{WRAPPER}} .amss-hero .amss-breadcrumb strong',
        ) );

        $this->add_responsive_control( 'hero_breadcrumb_margin', array(
            'label'      => esc_html__( 'Breadcrumb Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'hero_heading_text_controls', array(
            'label' => esc_html__( '5. Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'hero_label_color', array(
            'label' => esc_html__( 'Label Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-label' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_label_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-label',
        ) );

        $this->add_responsive_control( 'hero_label_margin', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'hero_title_color', array(
            'label' => esc_html__( 'Title Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_title_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-title',
        ) );

        $this->add_responsive_control( 'hero_title_margin', array(
            'label'      => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'hero_description_color', array(
            'label' => esc_html__( 'Description Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-description' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_description_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-description',
        ) );

        $this->add_responsive_control( 'hero_description_width', array(
            'label'      => esc_html__( 'Description Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 240, 'max' => 960 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-description' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_description_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'hero_chips_controls', array(
            'label' => esc_html__( '6. Meta Chips', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'hero_chips_gap', array(
            'label'      => esc_html__( 'Chips Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-chip-row' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_chips_margin', array(
            'label'      => esc_html__( 'Chips Row Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-chip-row' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'hero_chip_bg', array(
            'label' => esc_html__( 'Chip Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-chip' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_chip_color', array(
            'label' => esc_html__( 'Chip Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-chip' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_chip_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-chip',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'hero_chip_border',
            'selector' => '{{WRAPPER}} .amss-hero .amss-chip',
        ) );

        $this->add_responsive_control( 'hero_chip_padding', array(
            'label'      => esc_html__( 'Chip Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-chip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_chip_radius', array(
            'label'      => esc_html__( 'Chip Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-chip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'hero_media_controls', array(
            'label' => esc_html__( '7. Image / Media Panel', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'hero_panel_bg', array(
            'label' => esc_html__( 'Panel Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-hero-panel' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_panel_padding', array(
            'label'      => esc_html__( 'Panel Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'hero_panel_border',
            'selector' => '{{WRAPPER}} .amss-hero .amss-hero-panel',
        ) );

        $this->add_responsive_control( 'hero_panel_radius', array(
            'label'      => esc_html__( 'Panel Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_panel_shadow',
            'selector' => '{{WRAPPER}} .amss-hero .amss-hero-panel',
        ) );

        $this->add_responsive_control( 'hero_image_height', array(
            'label'      => esc_html__( 'Image Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range'      => array(
                'px' => array( 'min' => 100, 'max' => 760 ),
                'vh' => array( 'min' => 12, 'max' => 80 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-image' => 'height: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_image_radius', array(
            'label'      => esc_html__( 'Image Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->add_control( 'hero_image_position', array(
            'label' => esc_html__( 'Image Position', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::SELECT,
            'default' => 'center center',
            'options' => array(
                'center center' => esc_html__( 'Center Center', 'amaley-core' ),
                'center top'    => esc_html__( 'Center Top', 'amaley-core' ),
                'center bottom' => esc_html__( 'Center Bottom', 'amaley-core' ),
                'left center'   => esc_html__( 'Left Center', 'amaley-core' ),
                'right center'  => esc_html__( 'Right Center', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-image img' => 'object-position: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_image_opacity', array(
            'label'      => esc_html__( 'Image Opacity', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( '%' ),
            'range'      => array( '%' => array( 'min' => 20, 'max' => 100 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-image img' => 'opacity: calc({{SIZE}} / 100);',
            ),
        ) );

        $this->add_control( 'hero_image_hover_zoom', array(
            'label'   => esc_html__( 'Hover Zoom', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '1.025',
            'options' => array(
                '1'     => esc_html__( 'None', 'amaley-core' ),
                '1.015' => esc_html__( 'Soft', 'amaley-core' ),
                '1.035' => esc_html__( 'Visible', 'amaley-core' ),
                '1.06'  => esc_html__( 'Strong', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amss-hero' => '--amss-image-zoom: {{VALUE}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'hero_stats_controls', array(
            'label' => esc_html__( '8. Stats Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'hero_stats_gap', array(
            'label'      => esc_html__( 'Stats Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-stats' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_stats_columns', array(
            'label'      => esc_html__( 'Stats Columns', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( '' ),
            'range'      => array( '' => array( 'min' => 1, 'max' => 4, 'step' => 1 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-stats' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
            ),
        ) );

        $this->add_responsive_control( 'hero_stat_padding', array(
            'label'      => esc_html__( 'Box Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-stat-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_stat_align', array(
            'label' => esc_html__( 'Text Align', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'default'   => 'left',
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-stat-card' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_stat_bg', array(
            'label' => esc_html__( 'Box Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-stat-card' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'hero_stat_border',
            'selector' => '{{WRAPPER}} .amss-hero .amss-stat-card',
        ) );

        $this->add_responsive_control( 'hero_stat_radius', array(
            'label'      => esc_html__( 'Box Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-stat-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_stat_shadow',
            'selector' => '{{WRAPPER}} .amss-hero .amss-stat-card',
        ) );

        $this->add_control( 'hero_stat_label_color', array(
            'label' => esc_html__( 'Stat Label Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-stat-label' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_stat_label_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-stat-label',
        ) );

        $this->add_control( 'hero_stat_value_color', array(
            'label' => esc_html__( 'Stat Value Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-stat-value' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_stat_value_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-stat-value',
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'hero_button_controls', array(
            'label' => esc_html__( '9. Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'hero_button_align', array(
            'label' => esc_html__( 'Button Alignment', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-align-start-h' ),
                'center'     => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-align-center-h' ),
                'flex-end'   => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-align-end-h' ),
            ),
            'default'   => 'flex-start',
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-actions' => 'justify-content: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_button_gap', array(
            'label'      => esc_html__( 'Button Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-actions' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_button_margin', array(
            'label'      => esc_html__( 'Button Row Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-actions' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_button_padding', array(
            'label'      => esc_html__( 'Button Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_button_radius', array(
            'label'      => esc_html__( 'Button Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'hero_button_typography',
            'selector' => '{{WRAPPER}} .amss-hero .amss-btn',
        ) );

        $this->add_control( 'hero_primary_button_heading', array(
            'label'     => esc_html__( 'Primary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->start_controls_tabs( 'hero_primary_button_tabs' );

        $this->start_controls_tab( 'hero_primary_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );

        $this->add_control( 'hero_primary_button_bg', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-primary' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_primary_button_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-primary' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_primary_button_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-primary' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_primary_button_shadow',
            'selector' => '{{WRAPPER}} .amss-hero .amss-btn-primary',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_primary_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );

        $this->add_control( 'hero_primary_button_hover_bg', array(
            'label' => esc_html__( 'Hover Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-primary:hover' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_primary_button_hover_color', array(
            'label' => esc_html__( 'Hover Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-primary:hover' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_primary_button_hover_border_color', array(
            'label' => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-primary:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_primary_button_hover_shadow',
            'selector' => '{{WRAPPER}} .amss-hero .amss-btn-primary:hover',
        ) );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control( 'hero_secondary_button_heading', array(
            'label'     => esc_html__( 'Secondary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->start_controls_tabs( 'hero_secondary_button_tabs' );

        $this->start_controls_tab( 'hero_secondary_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );

        $this->add_control( 'hero_secondary_button_bg', array(
            'label' => esc_html__( 'Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-secondary' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_secondary_button_color', array(
            'label' => esc_html__( 'Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-secondary' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_secondary_button_border_color', array(
            'label' => esc_html__( 'Border Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-secondary' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_secondary_button_shadow',
            'selector' => '{{WRAPPER}} .amss-hero .amss-btn-secondary',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_secondary_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );

        $this->add_control( 'hero_secondary_button_hover_bg', array(
            'label' => esc_html__( 'Hover Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-secondary:hover' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_secondary_button_hover_color', array(
            'label' => esc_html__( 'Hover Text Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-secondary:hover' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_secondary_button_hover_border_color', array(
            'label' => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-hero .amss-btn-secondary:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'hero_secondary_button_hover_shadow',
            'selector' => '{{WRAPPER}} .amss-hero .amss-btn-secondary:hover',
        ) );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section( 'hero_motion_controls', array(
            'label' => esc_html__( '10. Animation / Micro Motion', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'hero_enable_reveal', array(
            'label'        => esc_html__( 'Enable Soft Reveal', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'amaley-core' ),
            'label_off'    => esc_html__( 'No', 'amaley-core' ),
            'return_value' => '1',
            'default'      => '',
            'selectors'    => array(
                '{{WRAPPER}} .amss-hero .amss-hero-copy, {{WRAPPER}} .amss-hero .amss-hero-panel' => 'animation-name: amssFadeUp; animation-fill-mode: both;',
            ),
        ) );

        $this->add_control( 'hero_motion_duration', array(
            'label'      => esc_html__( 'Motion Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range'      => array( 'ms' => array( 'min' => 0, 'max' => 1600, 'step' => 50 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero' => '--amss-motion-duration: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_panel_hover_lift', array(
            'label'      => esc_html__( 'Panel Hover Lift', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => -40, 'max' => 20 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amss-hero .amss-hero-panel:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function add_shg_pagination_style_controls( $scope = 'section' ) {
        if ( ! in_array( $scope, array( 'members', 'products' ), true ) ) {
            return;
        }

        $this->start_controls_section( 'shg_pagination_style_controls', array(
            'label' => esc_html__( 'Pagination', 'amaley-core' ),
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
            'selectors' => array( '{{WRAPPER}} .amss-pagination' => 'justify-content: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'pagination_gap', array(
            'label' => esc_html__( 'Gap', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
            'selectors' => array( '{{WRAPPER}} .amss-pagination' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_control( 'pagination_bg', array(
            'label' => esc_html__( 'Button Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-page-link' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_color', array(
            'label' => esc_html__( 'Button Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-page-link' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_active_bg', array(
            'label' => esc_html__( 'Current Background', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-page-current' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'pagination_active_color', array(
            'label' => esc_html__( 'Current Text Color', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amss-page-current' => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name' => 'pagination_border',
            'selector' => '{{WRAPPER}} .amss-page-link',
        ) );

        $this->add_responsive_control( 'pagination_radius', array(
            'label' => esc_html__( 'Button Radius', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array( '{{WRAPPER}} .amss-page-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'pagination_typography',
            'selector' => '{{WRAPPER}} .amss-page-link',
        ) );

        $this->end_controls_section();
    }


}
