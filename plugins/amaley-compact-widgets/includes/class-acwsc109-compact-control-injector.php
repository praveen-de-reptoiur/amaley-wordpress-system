<?php
/**
 * Adds safe design controls to existing Amaley Compact Widgets.
 * No database writes. No imports. No product/mapping/media changes.
 */
defined( 'ABSPATH' ) || exit;

final class ACWSC109_Compact_Control_Injector {
    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'elementor/element/amaley_cw_split_editorial/acw_heading_style/before_section_end', array( $this, 'split_heading_controls' ), 10, 2 );
        add_action( 'elementor/element/amaley_cw_split_editorial/acw_card_style/before_section_end', array( $this, 'split_card_controls' ), 10, 2 );
        add_action( 'elementor/element/amaley_cw_split_editorial/acw_layout/before_section_end', array( $this, 'split_layout_controls' ), 10, 2 );

        add_action( 'elementor/element/amaley_cw_origin_map/origin_style/before_section_end', array( $this, 'origin_full_style_controls' ), 10, 2 );
        add_action( 'elementor/element/amaley_cw_origin_map/origin_layout/before_section_end', array( $this, 'origin_layout_controls' ), 10, 2 );
        add_action( 'elementor/element/amaley_cw_origin_map/origin_content/before_section_end', array( $this, 'origin_visibility_controls' ), 10, 2 );
        add_action( 'elementor/element/amaley_cw_origin_map/origin_map/before_section_end', array( $this, 'origin_map_visibility_controls' ), 10, 2 );
        add_action( 'elementor/element/amaley_cw_origin_map/origin_items/before_section_end', array( $this, 'origin_step_visibility_controls' ), 10, 2 );
    }

    private function cm() {
        return '\\Elementor\\Controls_Manager';
    }

    private function typography_type() {
        return class_exists( '\\Elementor\\Group_Control_Typography' ) ? \Elementor\Group_Control_Typography::get_type() : null;
    }

    private function shadow_type() {
        return class_exists( '\\Elementor\\Group_Control_Box_Shadow' ) ? \Elementor\Group_Control_Box_Shadow::get_type() : null;
    }

    public function split_heading_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }

        $element->add_control( 'acwsc_split_spacing_note', array(
            'label' => esc_html__( 'Precise Split Editorial Spacing', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $element->add_responsive_control( 'acwsc_split_kicker_bottom_gap', array(
            'label' => esc_html__( 'Kicker Bottom Gap', 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};' ),
        ) );
        $element->add_responsive_control( 'acwsc_split_title_bottom_gap', array(
            'label' => esc_html__( 'Title Bottom Gap', 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-desc' => 'margin-top: {{SIZE}}{{UNIT}};' ),
        ) );
        $element->add_responsive_control( 'acwsc_split_heading_to_cards_gap', array(
            'label' => esc_html__( 'Heading Block to Cards Gap', 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-head' => 'margin-bottom: {{SIZE}}{{UNIT}};' ),
        ) );
    }

    public function split_card_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }
        $element->add_control( 'acwsc_split_card_note', array(
            'label' => esc_html__( 'Split Editorial Feature Cards', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $element->add_responsive_control( 'acwsc_split_feature_card_gap', array(
            'label' => esc_html__( 'Feature Card Gap', 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-story-lines' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );
        $element->add_responsive_control( 'acwsc_split_feature_card_padding', array(
            'label' => esc_html__( 'Feature Card Padding', 'amaley-compact-widgets' ),
            'type' => $cm::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-story-lines article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $element->add_responsive_control( 'acwsc_split_feature_card_radius', array(
            'label' => esc_html__( 'Feature Card Radius', 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-story-lines article' => 'border-radius: {{SIZE}}{{UNIT}};' ),
        ) );
    }

    public function split_layout_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }
        $element->add_control( 'acwsc_split_swap_note', array(
            'label' => esc_html__( 'Split Editorial Swap / Gaps', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $element->add_responsive_control( 'acwsc_split_column_gap', array(
            'label' => esc_html__( 'Image / Text Column Gap', 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-story-shell' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );
        $element->add_control( 'acwsc_split_mobile_text_first', array(
            'label' => esc_html__( 'Mobile: Text First', 'amaley-compact-widgets' ),
            'type' => $cm::SWITCHER,
            'return_value' => 'yes',
            'description' => esc_html__( 'For mobile/tablet stack, puts text before image without changing saved content.', 'amaley-compact-widgets' ),
            'selectors' => array(
                '@media (max-width: 767px) { {{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-story-copy' => 'order: 1;',
                '@media (max-width: 767px) { {{WRAPPER}} .amaley-cw4-split-editorial .amaley-cw4-story-photo' => 'order: 2;',
            ),
        ) );
    }

    public function origin_visibility_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }
        $element->add_control( 'acwsc_origin_visibility_note', array(
            'label' => esc_html__( 'Micro Visibility Overrides', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $this->hide_switch( $element, 'acwsc_hide_left_kicker', 'Hide Left Kicker', '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--map > .amaley-cw4-head .amaley-cw4-kicker' );
        $this->hide_switch( $element, 'acwsc_hide_left_title', 'Hide Left Title', '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--map > .amaley-cw4-head .amaley-cw4-title' );
        $this->hide_switch( $element, 'acwsc_hide_left_desc', 'Hide Left Description', '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--map > .amaley-cw4-head .amaley-cw4-desc' );
        $this->hide_switch( $element, 'acwsc_hide_right_kicker', 'Hide Right Kicker', '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--list > .amaley-cw4-head .amaley-cw4-kicker' );
        $this->hide_switch( $element, 'acwsc_hide_right_title', 'Hide Right Title', '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--list > .amaley-cw4-head .amaley-cw4-title' );
        $this->hide_switch( $element, 'acwsc_hide_right_desc', 'Hide Right Description', '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--list > .amaley-cw4-head .amaley-cw4-desc' );
    }

    public function origin_map_visibility_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }
        $element->add_control( 'acwsc_origin_map_visibility_note', array(
            'label' => esc_html__( 'Map Micro Visibility', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $this->hide_switch( $element, 'acwsc_hide_map_kicker', 'Hide Map Kicker', '{{WRAPPER}} .amaley-cw4-origin-map-path-board-kicker' );
        $this->hide_switch( $element, 'acwsc_hide_map_title', 'Hide Map Title', '{{WRAPPER}} .amaley-cw4-origin-map-path-board > h3' );
        $this->hide_switch( $element, 'acwsc_hide_map_hint', 'Hide Map Hint', '{{WRAPPER}} .amaley-cw4-origin-map-path-hint' );
        $this->hide_switch( $element, 'acwsc_hide_reset_button', 'Hide Reset Button', '{{WRAPPER}} .amaley-cw4-origin-map-path-reset' );
        $this->hide_switch( $element, 'acwsc_hide_route_caption', 'Hide Route Caption', '{{WRAPPER}} .amaley-cw4-origin-map-path-route-text' );
        $this->hide_switch( $element, 'acwsc_hide_foot_note', 'Hide Bottom Note', '{{WRAPPER}} .amaley-cw4-origin-map-path-foot' );
    }

    public function origin_step_visibility_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }
        $element->add_control( 'acwsc_origin_step_visibility_note', array(
            'label' => esc_html__( 'Step Card Micro Visibility', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $this->hide_switch( $element, 'acwsc_hide_step_number', 'Hide Step Number', '{{WRAPPER}} .amaley-cw4-origin-map-path-step > span' );
        $this->hide_switch( $element, 'acwsc_hide_step_title', 'Hide Step Title', '{{WRAPPER}} .amaley-cw4-origin-map-path-step h3' );
        $this->hide_switch( $element, 'acwsc_hide_step_text', 'Hide Step Text', '{{WRAPPER}} .amaley-cw4-origin-map-path-step p' );
    }

    private function hide_switch( $element, $id, $label, $selector ) {
        $cm = $this->cm();
        $element->add_control( $id, array(
            'label' => esc_html__( $label, 'amaley-compact-widgets' ),
            'type' => $cm::SWITCHER,
            'return_value' => 'none',
            'selectors' => array( $selector => 'display: {{VALUE}} !important;' ),
        ) );
    }

    public function origin_layout_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }
        $element->add_control( 'acwsc_origin_layout_note', array(
            'label' => esc_html__( 'Origin Map Extra Layout', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $element->add_responsive_control( 'acwsc_origin_panel_gap', array(
            'label' => esc_html__( 'Left / Right Panel Gap', 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-shell' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );
    }

    public function origin_full_style_controls( $element, $args ) {
        $cm = $this->cm();
        if ( ! class_exists( $cm ) ) { return; }

        $element->add_control( 'acwsc_origin_heading_micro_note', array(
            'label' => esc_html__( 'Header Micro Spacing', 'amaley-compact-widgets' ),
            'type' => $cm::HEADING,
            'separator' => 'before',
        ) );
        $this->gap_control( $element, 'acwsc_origin_kicker_gap', 'Kicker Bottom Gap', '{{WRAPPER}} .amaley-cw4-origin-map-path .amaley-cw4-kicker', 'margin-bottom', 60 );
        $this->gap_control( $element, 'acwsc_origin_title_gap', 'Title Bottom Gap', '{{WRAPPER}} .amaley-cw4-origin-map-path .amaley-cw4-desc', 'margin-top', 80 );
        $this->gap_control( $element, 'acwsc_origin_head_gap', 'Heading Block to Next Content Gap', '{{WRAPPER}} .amaley-cw4-origin-map-path .amaley-cw4-head', 'margin-bottom', 100 );

        $element->add_control( 'acwsc_origin_panel_note', array( 'label' => esc_html__( 'Panels / Map Board', 'amaley-compact-widgets' ), 'type' => $cm::HEADING, 'separator' => 'before' ) );
        $element->add_control( 'acwsc_origin_left_panel_bg', array( 'label' => esc_html__( 'Left Panel Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--map' => 'background: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_right_panel_bg', array( 'label' => esc_html__( 'Right Panel Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-panel--list' => 'background: {{VALUE}};' ) ) );
        $element->add_responsive_control( 'acwsc_origin_panel_padding', array( 'label' => esc_html__( 'Panel Padding', 'amaley-compact-widgets' ), 'type' => $cm::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $element->add_control( 'acwsc_origin_map_board_bg', array( 'label' => esc_html__( 'Map Board Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-board' => 'background: {{VALUE}};' ) ) );
        $element->add_responsive_control( 'acwsc_origin_map_board_padding', array( 'label' => esc_html__( 'Map Board Padding', 'amaley-compact-widgets' ), 'type' => $cm::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-board' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $element->add_control( 'acwsc_origin_map_viewport_bg', array( 'label' => esc_html__( 'Map Viewport Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-map' => 'background: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_map_viewport_border', array( 'label' => esc_html__( 'Map Viewport Border', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-map' => 'border-color: {{VALUE}};' ) ) );
        $element->add_responsive_control( 'acwsc_origin_map_viewport_radius', array( 'label' => esc_html__( 'Map Viewport Radius', 'amaley-compact-widgets' ), 'type' => $cm::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-map' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );

        $element->add_control( 'acwsc_origin_steps_note', array( 'label' => esc_html__( 'Right Step Cards', 'amaley-compact-widgets' ), 'type' => $cm::HEADING, 'separator' => 'before' ) );
        $this->gap_control( $element, 'acwsc_origin_step_gap', 'Step Card Gap', '{{WRAPPER}} .amaley-cw4-origin-map-path-steps', 'gap', 80 );
        $element->add_control( 'acwsc_origin_step_bg', array( 'label' => esc_html__( 'Step Card Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step' => 'background: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_step_hover_bg', array( 'label' => esc_html__( 'Step Card Hover Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step:hover' => 'background: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_step_border', array( 'label' => esc_html__( 'Step Card Border Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step' => 'border-color: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_step_hover_border', array( 'label' => esc_html__( 'Step Card Hover Border Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step:hover' => 'border-color: {{VALUE}};' ) ) );
        $element->add_responsive_control( 'acwsc_origin_step_padding', array( 'label' => esc_html__( 'Step Card Padding', 'amaley-compact-widgets' ), 'type' => $cm::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $element->add_responsive_control( 'acwsc_origin_step_radius', array( 'label' => esc_html__( 'Step Card Radius', 'amaley-compact-widgets' ), 'type' => $cm::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $element->add_responsive_control( 'acwsc_origin_step_hover_lift', array( 'label' => esc_html__( 'Step Card Hover Lift', 'amaley-compact-widgets' ), 'type' => $cm::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => -20, 'max' => 0 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step:hover' => 'transform: translateY({{SIZE}}{{UNIT}});' ) ) );

        $element->add_control( 'acwsc_origin_step_number_note', array( 'label' => esc_html__( 'Step Number Style', 'amaley-compact-widgets' ), 'type' => $cm::HEADING, 'separator' => 'before' ) );
        $element->add_control( 'acwsc_origin_step_num_bg', array( 'label' => esc_html__( 'Step Number Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step > span' => 'background: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_step_num_color', array( 'label' => esc_html__( 'Step Number Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step > span' => 'color: {{VALUE}};' ) ) );
        $this->gap_control( $element, 'acwsc_origin_step_title_gap', 'Step Title Bottom Gap', '{{WRAPPER}} .amaley-cw4-origin-map-path-step h3', 'margin-bottom', 60 );
        $element->add_control( 'acwsc_origin_step_title_color', array( 'label' => esc_html__( 'Step Title Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step h3' => 'color: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_step_text_color', array( 'label' => esc_html__( 'Step Text Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-step p' => 'color: {{VALUE}};' ) ) );

        $element->add_control( 'acwsc_origin_button_note', array( 'label' => esc_html__( 'Main CTA Button Style', 'amaley-compact-widgets' ), 'type' => $cm::HEADING, 'separator' => 'before' ) );
        $this->button_colors( $element, 'acwsc_origin_btn', '{{WRAPPER}} .amaley-cw4-origin-map-path .amaley-cw4-btn' );
        $element->add_responsive_control( 'acwsc_origin_btn_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-compact-widgets' ), 'type' => $cm::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path .amaley-cw4-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $element->add_responsive_control( 'acwsc_origin_btn_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-compact-widgets' ), 'type' => $cm::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path .amaley-cw4-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );

        $element->add_control( 'acwsc_origin_zoom_note', array( 'label' => esc_html__( 'Map Zoom / Reset Buttons', 'amaley-compact-widgets' ), 'type' => $cm::HEADING, 'separator' => 'before' ) );
        $this->button_colors( $element, 'acwsc_origin_zoom', '{{WRAPPER}} .amaley-cw4-origin-map-path-controls button' );
        $this->button_colors( $element, 'acwsc_origin_reset', '{{WRAPPER}} .amaley-cw4-origin-map-path-reset' );

        $element->add_control( 'acwsc_origin_marker_note', array( 'label' => esc_html__( 'Markers / Labels', 'amaley-compact-widgets' ), 'type' => $cm::HEADING, 'separator' => 'before' ) );
        $element->add_control( 'acwsc_origin_marker_bg', array( 'label' => esc_html__( 'Marker Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-marker' => 'background: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_marker_text', array( 'label' => esc_html__( 'Marker Text Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-marker' => 'color: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_label_bg', array( 'label' => esc_html__( 'Map Label Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-label' => 'background: {{VALUE}};' ) ) );
        $element->add_control( 'acwsc_origin_label_text', array( 'label' => esc_html__( 'Map Label Text Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-label, {{WRAPPER}} .amaley-cw4-origin-map-path-label strong, {{WRAPPER}} .amaley-cw4-origin-map-path-label small' => 'color: {{VALUE}};' ) ) );
    }

    private function gap_control( $element, $id, $label, $selector, $property, $max = 80 ) {
        $cm = $this->cm();
        $element->add_responsive_control( $id, array(
            'label' => esc_html__( $label, 'amaley-compact-widgets' ),
            'type' => $cm::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => $max ) ),
            'selectors' => array( $selector => $property . ': {{SIZE}}{{UNIT}};' ),
        ) );
    }

    private function button_colors( $element, $prefix, $selector ) {
        $cm = $this->cm();
        $element->add_control( $prefix . '_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( $selector => 'background: {{VALUE}};' ) ) );
        $element->add_control( $prefix . '_text', array( 'label' => esc_html__( 'Text Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( $selector => 'color: {{VALUE}};' ) ) );
        $element->add_control( $prefix . '_border', array( 'label' => esc_html__( 'Border Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( $selector => 'border-color: {{VALUE}};' ) ) );
        $element->add_control( $prefix . '_hover_bg', array( 'label' => esc_html__( 'Hover Background', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( $selector . ':hover' => 'background: {{VALUE}};' ) ) );
        $element->add_control( $prefix . '_hover_text', array( 'label' => esc_html__( 'Hover Text Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( $selector . ':hover' => 'color: {{VALUE}};' ) ) );
        $element->add_control( $prefix . '_hover_border', array( 'label' => esc_html__( 'Hover Border Color', 'amaley-compact-widgets' ), 'type' => $cm::COLOR, 'selectors' => array( $selector . ':hover' => 'border-color: {{VALUE}};' ) ) );
    }
}
