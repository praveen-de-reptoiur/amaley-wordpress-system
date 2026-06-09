<?php
/**
 * Amaley Member Single Snapshot Elementor widget.
 * v1.0.119 — Single Snapshot scoped full controls.
 *
 * Live-site safe scope:
 * - Only Single Member / Producer Snapshot widget controls are changed.
 * - No producer data, SHG mapping, cluster mapping, products, gallery, pages or render logic is changed.
 * - Controls are section-wise and only for actual snapshot elements.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Single_Snapshot_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_member_single_snapshot'; }
    public function get_title() { return esc_html__( 'Amaley Member Single Snapshot', 'amaley-core' ); }
    public function get_icon() { return 'eicon-info-box'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'member', 'producer', 'single', 'snapshot' ); }

    protected function register_controls() {
        $defaults = $this->defaults_for( 'snapshot_defaults' );
        $this->register_source_controls( $defaults );
        $this->register_snapshot_content_controls( $defaults );
        $this->register_snapshot_style_controls();
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

    private function val( $defaults, $key, $fallback = '' ) {
        return array_key_exists( $key, $defaults ) ? $defaults[ $key ] : $fallback;
    }

    private function add_switch_if( $defaults, $key, $label, $fallback = '1' ) {
        $this->add_control( $key, array(
            'label'        => esc_html__( $label, 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->val( $defaults, $key, $fallback ),
        ) );
    }

    private function register_source_controls( $defaults ) {
        $this->start_controls_section( 'source_section', array(
            'label' => esc_html__( 'Snapshot Data / Preview Source', 'amaley-core' ),
        ) );

        $this->add_control( 'auto_detect', array(
            'label'        => esc_html__( 'Auto Detect Producer from URL', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'amaley-core' ),
            'label_off'    => esc_html__( 'No', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->val( $defaults, 'auto_detect', '1' ),
        ) );

        $this->add_control( 'preview_member_id', array(
            'label'       => esc_html__( 'Preview Producer / Member ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Use only inside Elementor editor when URL auto-detect is empty.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_id', array(
            'label'       => esc_html__( 'Fixed Producer / Member ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Optional. Leave blank for dynamic single producer pages.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_slug', array(
            'label'       => esc_html__( 'Fixed Producer / Member Slug', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => '',
            'description' => esc_html__( 'Optional. Leave blank for dynamic single producer pages.', 'amaley-core' ),
        ) );

        $this->add_control( 'empty_message', array(
            'label'   => esc_html__( 'Fallback / Empty Message', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => $this->val( $defaults, 'empty_message', 'Producer details are not available yet.' ),
        ) );

        $this->end_controls_section();
    }

    private function register_snapshot_content_controls( $defaults ) {
        $this->start_controls_section( 'snapshot_content_section', array(
            'label' => esc_html__( 'Snapshot Content / Display', 'amaley-core' ),
        ) );

        $this->add_switch_if( $defaults, 'show_section', 'Show Snapshot Section', '1' );

        $this->add_control( 'content_heading', array(
            'label'     => esc_html__( 'Section Heading', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_switch_if( $defaults, 'show_label', 'Show Small Label', '1' );
        $this->add_control( 'label', array(
            'label'     => esc_html__( 'Small Label Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $this->val( $defaults, 'label', 'Producer Snapshot' ),
            'condition' => array( 'show_label' => '1' ),
        ) );

        $this->add_switch_if( $defaults, 'show_title', 'Show Heading', '1' );
        $this->add_control( 'title', array(
            'label'     => esc_html__( 'Heading Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $this->val( $defaults, 'title', 'Quick details' ),
            'condition' => array( 'show_title' => '1' ),
        ) );

        $this->add_switch_if( $defaults, 'show_description', 'Show Description', '1' );
        $this->add_control( 'description', array(
            'label'     => esc_html__( 'Description Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 4,
            'default'   => $this->val( $defaults, 'description', 'Key information about this producer, their SHG group, village role and linked origin story.' ),
            'condition' => array( 'show_description' => '1' ),
        ) );

        $this->add_control( 'stats_heading', array(
            'label'     => esc_html__( 'Snapshot Stat Boxes', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_switch_if( $defaults, 'show_role_stat', 'Show Role Box', '1' );
        $this->add_switch_if( $defaults, 'show_village_stat', 'Show Village Box', '1' );
        $this->add_switch_if( $defaults, 'show_shg_stat', 'Show SHG Group Box', '1' );
        $this->add_switch_if( $defaults, 'show_cluster_stat', 'Show Cluster Box', '1' );

        $this->add_control( 'columns_heading', array(
            'label'     => esc_html__( 'Responsive Columns', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'columns_desktop', array(
            'label'   => esc_html__( 'Columns Desktop', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => $this->val( $defaults, 'columns_desktop', 4 ),
            'min'     => 1,
            'max'     => 6,
        ) );

        $this->add_control( 'columns_tablet', array(
            'label'   => esc_html__( 'Columns Tablet', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => $this->val( $defaults, 'columns_tablet', 2 ),
            'min'     => 1,
            'max'     => 4,
        ) );

        $this->add_control( 'columns_mobile', array(
            'label'   => esc_html__( 'Columns Mobile', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => $this->val( $defaults, 'columns_mobile', 2 ),
            'min'     => 1,
            'max'     => 2,
        ) );

        $this->end_controls_section();
    }

    private function register_snapshot_style_controls() {
        $s = '{{WRAPPER}} .amms-section.amms-snapshot';

        $this->start_controls_section( 'snapshot_section_style', array(
            'label' => esc_html__( 'Snapshot Section / Background', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'snapshot_section_background',
            'selector' => $s,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'snapshot_section_border',
            'selector' => $s,
        ) );

        $this->add_responsive_control( 'snapshot_section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'snapshot_section_shadow',
            'selector' => $s,
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'snapshot_layout_style', array(
            'label' => esc_html__( 'Snapshot Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'snapshot_section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array( $s => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array( $s => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_wrap_width', array(
            'label'      => esc_html__( 'Content Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 600, 'max' => 1500 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors' => array( $s . ' .amms-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_wrap_padding', array(
            'label'      => esc_html__( 'Inner Side Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array( $s . ' .amms-wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_head_gap', array(
            'label'      => esc_html__( 'Heading to Stats Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
            'selectors'  => array( $s . ' .amms-snapshot-grid' => 'margin-top: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_text_align', array(
            'label'     => esc_html__( 'Heading Alignment', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( $s . ' .amms-section-head' => 'text-align: {{VALUE}};' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'snapshot_heading_style', array(
            'label' => esc_html__( 'Snapshot Heading / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'snapshot_label_heading', array(
            'label'     => esc_html__( 'Small Label', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'snapshot_label_typography',
            'selector' => $s . ' .amms-section-label, ' . $s . ' .amms-kicker',
        ) );

        $this->add_control( 'snapshot_label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-label, ' . $s . ' .amms-kicker' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_label_margin', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-section-label, ' . $s . ' .amms-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'snapshot_title_heading', array(
            'label'     => esc_html__( 'Heading', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'snapshot_title_typography',
            'selector' => $s . ' .amms-section-title, ' . $s . ' .amms-title',
        ) );

        $this->add_control( 'snapshot_title_color', array(
            'label'     => esc_html__( 'Heading Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-title, ' . $s . ' .amms-title' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_title_margin', array(
            'label'      => esc_html__( 'Heading Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-section-title, ' . $s . ' .amms-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'snapshot_desc_heading', array(
            'label'     => esc_html__( 'Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'snapshot_desc_typography',
            'selector' => $s . ' .amms-section-desc, ' . $s . ' .amms-description',
        ) );

        $this->add_control( 'snapshot_desc_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-desc, ' . $s . ' .amms-description' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_desc_width', array(
            'label'      => esc_html__( 'Description Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 220, 'max' => 1200 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors' => array( $s . ' .amms-section-desc, ' . $s . ' .amms-description' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_desc_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-section-desc, ' . $s . ' .amms-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'snapshot_grid_style', array(
            'label' => esc_html__( 'Snapshot Stat Grid', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'snapshot_grid_gap', array(
            'label'      => esc_html__( 'Grid Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 100 ) ),
            'selectors'  => array( $s . ' .amms-snapshot-grid' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'snapshot_grid_align', array(
            'label'     => esc_html__( 'Box Text Alignment', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( $s . ' .amms-stat' => 'text-align: {{VALUE}};' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'snapshot_stat_box_style', array(
            'label' => esc_html__( 'Snapshot Stat Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'stat_padding', array(
            'label'      => esc_html__( 'Box Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-stat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'stat_min_height', array(
            'label'      => esc_html__( 'Box Min Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 320 ) ),
            'selectors'  => array( $s . ' .amms-stat' => 'min-height: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'stat_radius', array(
            'label'      => esc_html__( 'Box Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' .amms-stat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->start_controls_tabs( 'stat_box_state_tabs' );

        $this->start_controls_tab( 'stat_box_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'stat_background',
            'selector' => $s . ' .amms-stat',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'stat_border',
            'selector' => $s . ' .amms-stat',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'stat_shadow',
            'selector' => $s . ' .amms-stat',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'stat_box_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'stat_hover_background', array(
            'label'     => esc_html__( 'Hover Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-stat:hover' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'stat_hover_border_color', array(
            'label'     => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-stat:hover' => 'border-color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'stat_hover_shadow',
            'selector' => $s . ' .amms-stat:hover',
        ) );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section( 'snapshot_stat_text_style', array(
            'label' => esc_html__( 'Snapshot Stat Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'stat_label_heading', array(
            'label' => esc_html__( 'Stat Label', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'stat_label_typography',
            'selector' => $s . ' .amms-stat span',
        ) );

        $this->add_control( 'stat_label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-stat span' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'stat_label_margin', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-stat span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'stat_value_heading', array(
            'label'     => esc_html__( 'Stat Value', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'stat_value_typography',
            'selector' => $s . ' .amms-stat strong',
        ) );

        $this->add_control( 'stat_value_color', array(
            'label'     => esc_html__( 'Value Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-stat strong' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'stat_value_margin', array(
            'label'      => esc_html__( 'Value Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-stat strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'snapshot_motion_style', array(
            'label' => esc_html__( 'Snapshot Motion / Transform', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'stat_hover_lift', array(
            'label'      => esc_html__( 'Box Hover Lift', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => -30, 'max' => 30 ) ),
            'selectors'  => array( $s . ' .amms-stat:hover' => 'transform: translateY({{SIZE}}{{UNIT}});' ),
        ) );

        $this->add_control( 'stat_transition_duration', array(
            'label'     => esc_html__( 'Transition Duration (ms)', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 0,
            'max'       => 2000,
            'step'      => 50,
            'selectors' => array( $s . ' .amms-stat' => 'transition-duration: {{VALUE}}ms;' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'snapshot_fallback_style', array(
            'label' => esc_html__( 'Snapshot Empty / Fallback', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'empty_typography',
            'selector' => $s . ' .amms-empty',
        ) );

        $this->add_control( 'empty_color', array(
            'label'     => esc_html__( 'Message Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-empty' => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'empty_background',
            'selector' => $s . ' .amms-empty',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'empty_border',
            'selector' => $s . ' .amms-empty',
        ) );

        $this->add_responsive_control( 'empty_padding', array(
            'label'      => esc_html__( 'Message Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'empty_radius', array(
            'label'      => esc_html__( 'Message Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' .amms-empty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = $this->renderer_instance();
        echo $renderer->render_snapshot( $this->get_settings_for_display() );
    }
}
