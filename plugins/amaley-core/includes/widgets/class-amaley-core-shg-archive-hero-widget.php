<?php
/**
 * Amaley SHG Archive Hero Elementor widget.
 *
 * v1.0.102 — SHG Archive Hero full-control pass.
 * Live-site safe scope: Elementor controls only. No data, query, CPT,
 * mapping, product, photo, page-template, or renderer logic changes.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_SHG_Archive_Hero_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_core_shg_archive_hero';
    }

    public function get_title() {
        return esc_html__( 'Amaley SHG Archive Hero', 'amaley-core' );
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return array( 'amaley-core' );
    }

    public function get_style_depends() {
        return array( 'amaley-core-shg-archive-sections' );
    }

    public function get_keywords() {
        return array( 'amaley', 'shg', 'archive', 'hero', 'producer groups' );
    }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d        = $renderer->hero_defaults();

        /* --------------------------------------------------------------------
         * CONTENT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'content', array(
            'label' => esc_html__( 'Content', 'amaley-core' ),
        ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Section', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_section'],
        ) );

        $this->add_control( 'label', array(
            'label'   => esc_html__( 'Small Label', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => $d['label'],
        ) );

        $this->add_control( 'title', array(
            'label'   => esc_html__( 'Title', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => $d['title'],
        ) );

        $this->add_control( 'accent', array(
            'label'       => esc_html__( 'Italic Accent Text', 'amaley-core' ),
            'description' => esc_html__( 'This text is highlighted inside the title if it matches the title text.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['accent'],
        ) );

        $this->add_control( 'description', array(
            'label'   => esc_html__( 'Description', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 4,
            'default' => $d['description'],
        ) );

        $this->add_control( 'primary_text', array(
            'label'   => esc_html__( 'Primary Button Text', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => $d['primary_text'],
        ) );

        $this->add_control( 'primary_url', array(
            'label'       => esc_html__( 'Primary Button URL', 'amaley-core' ),
            'description' => esc_html__( 'Use a normal URL or site path such as /shop/.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['primary_url'],
        ) );

        $this->add_control( 'secondary_text', array(
            'label'   => esc_html__( 'Secondary Button Text', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => $d['secondary_text'],
        ) );

        $this->add_control( 'secondary_url', array(
            'label'       => esc_html__( 'Secondary Button URL', 'amaley-core' ),
            'description' => esc_html__( 'Use a normal URL or site path such as /clusters/.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['secondary_url'],
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * SHOW / HIDE
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'visibility', array(
            'label' => esc_html__( 'Show / Hide', 'amaley-core' ),
        ) );

        foreach ( array(
            'show_label'            => 'Small Label',
            'show_title'            => 'Title',
            'show_description'      => 'Description',
            'show_primary_button'   => 'Primary Button',
            'show_secondary_button' => 'Secondary Button',
            'show_stats'            => 'Stats Panel',
        ) as $key => $label ) {
            $this->add_control( $key, array(
                'label'        => esc_html( $label ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default'      => isset( $d[ $key ] ) ? $d[ $key ] : '1',
            ) );
        }

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STATS CONTENT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'stats', array(
            'label' => esc_html__( 'Stats Panel', 'amaley-core' ),
        ) );

        $this->add_control( 'stats_mode', array(
            'label'   => esc_html__( 'Stats Mode', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => isset( $d['stats_mode'] ) ? $d['stats_mode'] : 'dynamic',
            'options' => array(
                'dynamic' => esc_html__( 'Auto / Dynamic Counts', 'amaley-core' ),
                'manual'  => esc_html__( 'Manual Text', 'amaley-core' ),
            ),
        ) );

        for ( $i = 1; $i <= 4; $i++ ) {
            $this->add_control( 'stat_' . $i . '_value', array(
                'label'   => esc_html( 'Stat ' . $i . ' Value' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => isset( $d[ 'stat_' . $i . '_value' ] ) ? $d[ 'stat_' . $i . '_value' ] : '',
            ) );

            $this->add_control( 'stat_' . $i . '_label', array(
                'label'   => esc_html( 'Stat ' . $i . ' Label' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => isset( $d[ 'stat_' . $i . '_label' ] ) ? $d[ 'stat_' . $i . '_label' ] : '',
            ) );
        }

        $this->add_control( 'stats_columns_desktop', array(
            'label'   => esc_html__( 'Stats Columns Desktop', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 4,
            'default' => isset( $d['stats_columns_desktop'] ) ? $d['stats_columns_desktop'] : 2,
        ) );

        $this->add_control( 'stats_columns_tablet', array(
            'label'   => esc_html__( 'Stats Columns Tablet', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 4,
            'default' => isset( $d['stats_columns_tablet'] ) ? $d['stats_columns_tablet'] : 2,
        ) );

        $this->add_control( 'stats_columns_mobile', array(
            'label'       => esc_html__( 'Stats Columns Mobile', 'amaley-core' ),
            'description' => esc_html__( 'Set 2 for 2 + 2 layout on phone.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'min'         => 1,
            'max'         => 2,
            'default'     => isset( $d['stats_columns_mobile'] ) ? $d['stats_columns_mobile'] : 2,
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: SECTION BACKGROUND / BOX
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'section_box_style', array(
            'label' => esc_html__( 'Section Background / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background',
            'label'    => esc_html__( 'Section Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-archive-hero',
        ) );

        $this->add_control( 'section_overlay_color', array(
            'label'     => esc_html__( 'Soft Overlay Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero::before' => 'background: radial-gradient(circle at 14% 22%, {{VALUE}}, transparent 34%);',
            ),
        ) );

        $this->add_control( 'section_grid_opacity', array(
            'label' => esc_html__( 'Subtle Grid Opacity', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'range' => array(
                'px' => array(
                    'min'  => 0,
                    'max'  => 1,
                    'step' => 0.01,
                ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero::after' => 'opacity: {{SIZE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border',
            'label'    => esc_html__( 'Section Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-archive-hero',
        ) );

        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow',
            'label'    => esc_html__( 'Section Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-archive-hero',
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: LAYOUT / SPACING
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'layout_style', array(
            'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'inner_width', array(
            'label'      => esc_html__( 'Inner Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 720, 'max' => 1800 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-archive-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'inner_side_padding', array(
            'label'      => esc_html__( 'Inner Side Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'allowed_dimensions' => array( 'left', 'right' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-archive-wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_gap', array(
            'label'      => esc_html__( 'Hero Column Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 140 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-archive-wrap' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'hero_vertical_align', array(
            'label'   => esc_html__( 'Vertical Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''           => esc_html__( 'Default', 'amaley-core' ),
                'start'      => esc_html__( 'Top', 'amaley-core' ),
                'center'     => esc_html__( 'Center', 'amaley-core' ),
                'end'        => esc_html__( 'Bottom', 'amaley-core' ),
                'stretch'    => esc_html__( 'Stretch', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-archive-wrap' => 'align-items: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'copy_max_width', array(
            'label'      => esc_html__( 'Copy Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 320, 'max' => 1000 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-hero-copy' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'text_alignment', array(
            'label'   => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-hero-copy' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'button_alignment', array(
            'label'   => esc_html__( 'Button Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''           => esc_html__( 'Default', 'amaley-core' ),
                'flex-start' => esc_html__( 'Left', 'amaley-core' ),
                'center'     => esc_html__( 'Center', 'amaley-core' ),
                'flex-end'   => esc_html__( 'Right', 'amaley-core' ),
                'stretch'    => esc_html__( 'Stretch', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-hero-actions' => 'justify-content: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'content_bottom_gap', array(
            'label'      => esc_html__( 'Button Area Top Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 80 ),
                'em' => array( 'min' => 0, 'max' => 6, 'step' => 0.1 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-hero-actions' => 'margin-top: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: HEADING / LABEL / TEXT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'heading_text_style', array(
            'label' => esc_html__( 'Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_style_heading', array(
            'label' => esc_html__( 'Small Label', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-kicker' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'label'    => esc_html__( 'Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-kicker',
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'title_style_heading', array(
            'label'     => esc_html__( 'Title', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-archive-title',
        ) );

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'accent_style_heading', array(
            'label'     => esc_html__( 'Title Accent', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'accent_color', array(
            'label'     => esc_html__( 'Accent Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-title em' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'accent_typography',
            'label'    => esc_html__( 'Accent Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-archive-title em',
        ) );

        $this->add_control( 'description_style_heading', array(
            'label'     => esc_html__( 'Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'description_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-desc' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'description_typography',
            'label'    => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-archive-desc',
        ) );

        $this->add_responsive_control( 'description_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: BUTTONS
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'button_style', array(
            'label' => esc_html__( 'Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'button_typography',
            'label'    => esc_html__( 'Button Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt',
        ) );

        $this->add_responsive_control( 'button_gap', array(
            'label'      => esc_html__( 'Button Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 50 ),
                'em' => array( 'min' => 0, 'max' => 4, 'step' => 0.1 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-hero-actions' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'button_padding', array(
            'label'      => esc_html__( 'Button Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'button_min_height', array(
            'label'      => esc_html__( 'Button Min Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 26, 'max' => 90 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt' => 'min-height: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'button_radius', array(
            'label'      => esc_html__( 'Button Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 100 ),
                '%'  => array( 'min' => 0, 'max' => 50 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt' => 'border-radius: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'button_shadow',
            'label'    => esc_html__( 'Button Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt',
        ) );

        $this->add_control( 'primary_button_heading', array(
            'label'     => esc_html__( 'Primary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->start_controls_tabs( 'primary_button_tabs' );

        $this->start_controls_tab( 'primary_button_normal', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'primary_button_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn' => 'background: {{VALUE}}; border-color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'primary_button_hover', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'primary_button_hover_bg', array(
            'label'     => esc_html__( 'Hover Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn:hover' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_hover_color', array(
            'label'     => esc_html__( 'Hover Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn:hover' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_hover_border_color', array(
            'label'     => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control( 'secondary_button_heading', array(
            'label'     => esc_html__( 'Secondary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->start_controls_tabs( 'secondary_button_tabs' );

        $this->start_controls_tab( 'secondary_button_normal', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'secondary_button_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn-alt' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn-alt' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn-alt' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'secondary_button_hover', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'secondary_button_hover_bg', array(
            'label'     => esc_html__( 'Hover Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn-alt:hover' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_hover_color', array(
            'label'     => esc_html__( 'Hover Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn-alt:hover' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_hover_border_color', array(
            'label'     => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-btn-alt:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: STATS PANEL
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'stats_panel_style', array(
            'label' => esc_html__( 'Stats Panel / Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'stats_panel_heading', array(
            'label' => esc_html__( 'Panel', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'stats_panel_background',
            'label'    => esc_html__( 'Panel Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-hero-panel',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'stats_panel_border',
            'label'    => esc_html__( 'Panel Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-hero-panel',
        ) );

        $this->add_responsive_control( 'stats_panel_radius', array(
            'label'      => esc_html__( 'Panel Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 80 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-hero-panel' => 'border-radius: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'stats_panel_shadow',
            'label'    => esc_html__( 'Panel Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-hero-panel',
        ) );

        $this->add_responsive_control( 'stats_panel_padding', array(
            'label'      => esc_html__( 'Panel Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-hero-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'stats_gap', array(
            'label'      => esc_html__( 'Stats Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 50 ),
                'em' => array( 'min' => 0, 'max' => 4, 'step' => 0.1 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-hero-panel' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'stats_panel_max_width', array(
            'label'      => esc_html__( 'Panel Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 240, 'max' => 800 ),
                '%'  => array( 'min' => 20, 'max' => 100 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-hero-panel' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'stats_text_alignment', array(
            'label'   => esc_html__( 'Stats Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-stat' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'stat_box_heading', array(
            'label'     => esc_html__( 'Stat Box', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'stat_box_background',
            'label'    => esc_html__( 'Stat Box Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-stat',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'stat_box_border',
            'label'    => esc_html__( 'Stat Box Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-stat',
        ) );

        $this->add_responsive_control( 'stat_box_radius', array(
            'label'      => esc_html__( 'Stat Box Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 60 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-stat' => 'border-radius: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'stat_box_shadow',
            'label'    => esc_html__( 'Stat Box Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-stat',
        ) );

        $this->add_responsive_control( 'stat_box_padding', array(
            'label'      => esc_html__( 'Stat Box Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-stat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'stat_number_heading', array(
            'label'     => esc_html__( 'Stat Number', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'stat_number_color', array(
            'label'     => esc_html__( 'Number Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-stat strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'stat_number_typography',
            'label'    => esc_html__( 'Number Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-stat strong',
        ) );

        $this->add_responsive_control( 'stat_number_margin', array(
            'label'      => esc_html__( 'Number Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-stat strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'stat_label_heading', array(
            'label'     => esc_html__( 'Stat Label', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'stat_label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-stat span' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'stat_label_typography',
            'label'    => esc_html__( 'Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-stat span',
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: MOTION
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'motion_style', array(
            'label' => esc_html__( 'Animation / Micro Motion', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'motion_mode', array(
            'label'        => esc_html__( 'Section Animation', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SELECT,
            'default'      => 'on',
            'options'      => array(
                'on'  => esc_html__( 'On', 'amaley-core' ),
                'off' => esc_html__( 'Off', 'amaley-core' ),
            ),
            'prefix_class' => 'amaley-core-motion-',
        ) );

        $this->add_control( 'motion_duration', array(
            'label'      => esc_html__( 'Animation Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range'      => array(
                'ms' => array( 'min' => 150, 'max' => 900, 'step' => 50 ),
            ),
            'default'    => array( 'size' => 520, 'unit' => 'ms' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->add_control( 'motion_distance', array(
            'label'      => esc_html__( 'Animation Lift Distance', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 18 ),
            ),
            'default'    => array( 'size' => 6, 'unit' => 'px' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-y: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_lift', array(
            'label'       => esc_html__( 'Hover Lift', 'amaley-core' ),
            'description' => esc_html__( 'Keep 1–3px for smooth premium motion. Use 0 to disable lift.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => array( 'px' ),
            'range'       => array(
                'px' => array( 'min' => 0, 'max' => 8 ),
            ),
            'default'     => array( 'size' => 2, 'unit' => 'px' ),
            'selectors'   => array(
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-hover-lift: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_scale', array(
            'label'       => esc_html__( 'Hover Scale', 'amaley-core' ),
            'description' => esc_html__( 'Use Soft for smooth movement. Set None if the page feels heavy.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '1.003',
            'options'     => array(
                '1'     => esc_html__( 'None', 'amaley-core' ),
                '1.003' => esc_html__( 'Soft', 'amaley-core' ),
                '1.006' => esc_html__( 'Medium', 'amaley-core' ),
                '1.01'  => esc_html__( 'Strong', 'amaley-core' ),
            ),
            'selectors'   => array(
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-hover-scale: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'image_hover_zoom', array(
            'label'       => esc_html__( 'Image Hover Zoom', 'amaley-core' ),
            'description' => esc_html__( 'Used by shared archive image/card areas if present.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '1.018',
            'options'     => array(
                '1'     => esc_html__( 'None', 'amaley-core' ),
                '1.012' => esc_html__( 'Very Soft', 'amaley-core' ),
                '1.018' => esc_html__( 'Soft', 'amaley-core' ),
                '1.035' => esc_html__( 'Visible', 'amaley-core' ),
            ),
            'selectors'   => array(
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-image-zoom: {{VALUE}};',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        echo $renderer->render_hero( $this->get_settings_for_display() );
    }
}
