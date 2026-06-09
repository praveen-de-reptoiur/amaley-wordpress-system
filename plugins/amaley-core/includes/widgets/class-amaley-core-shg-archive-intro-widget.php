<?php
/**
 * Amaley SHG Archive Intro Elementor widget.
 *
 * v1.0.103-full-controls
 * Live-site safe replacement: adds complete non-coder Elementor controls for the
 * SHG Archive Intro section without touching data, queries, pages, mappings,
 * images, products, or frontend business logic.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Archive_Intro_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_shg_archive_intro'; }
    public function get_title() { return esc_html__( 'Amaley SHG Archive Intro', 'amaley-core' ); }
    public function get_icon() { return 'eicon-text-area'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'archive', 'intro' ); }

    /**
     * Normalizes old switcher defaults safely.
     * Some older defaults used text values by mistake. This prevents sections
     * from hiding accidentally when this replacement file is used on a live site.
     */
    private function switch_default( $defaults, $key, $fallback = '1' ) {
        if ( ! isset( $defaults[ $key ] ) ) {
            return $fallback;
        }

        $value = $defaults[ $key ];

        if ( is_bool( $value ) ) {
            return $value ? '1' : '';
        }

        if ( is_numeric( $value ) ) {
            return absint( $value ) ? '1' : '';
        }

        $value = strtolower( trim( (string) $value ) );

        if ( in_array( $value, array( '1', 'yes', 'true', 'on', 'show' ), true ) ) {
            return '1';
        }

        if ( in_array( $value, array( '0', 'no', 'false', 'off', 'hide', '' ), true ) ) {
            return '';
        }

        return $fallback;
    }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d = $renderer->intro_defaults();

        /* ------------------------------------------------------------------
         * Content
         * ------------------------------------------------------------------ */
        $this->start_controls_section( 'content', array(
            'label' => esc_html__( 'Content', 'amaley-core' ),
        ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Section', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $this->switch_default( $d, 'show_section', '1' ),
        ) );

        $this->add_control( 'label', array(
            'label'       => esc_html__( 'Small Label', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => isset( $d['label'] ) ? $d['label'] : '',
            'label_block' => true,
        ) );

        $this->add_control( 'title', array(
            'label'       => esc_html__( 'Title', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 3,
            'default'     => isset( $d['title'] ) ? $d['title'] : '',
            'label_block' => true,
        ) );

        $this->add_control( 'description', array(
            'label'       => esc_html__( 'Description', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 4,
            'default'     => isset( $d['description'] ) ? $d['description'] : '',
            'label_block' => true,
        ) );

        $this->add_control( 'features_heading', array(
            'label'     => esc_html__( 'Feature Cards Content', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        for ( $i = 1; $i <= 3; $i++ ) {
            $this->add_control( 'feature_' . $i . '_title', array(
                'label'       => esc_html( 'Feature ' . $i . ' Title' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => isset( $d[ 'feature_' . $i . '_title' ] ) ? $d[ 'feature_' . $i . '_title' ] : '',
                'label_block' => true,
            ) );

            $this->add_control( 'feature_' . $i . '_text', array(
                'label'       => esc_html( 'Feature ' . $i . ' Text' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'default'     => isset( $d[ 'feature_' . $i . '_text' ] ) ? $d[ 'feature_' . $i . '_text' ] : '',
                'label_block' => true,
            ) );
        }

        $this->end_controls_section();

        /* ------------------------------------------------------------------
         * Show / Hide
         * ------------------------------------------------------------------ */
        $this->start_controls_section( 'visibility', array(
            'label' => esc_html__( 'Show / Hide', 'amaley-core' ),
        ) );

        foreach ( array(
            'show_label'       => 'Small Label',
            'show_title'       => 'Title',
            'show_description' => 'Description',
            'show_features'    => 'Feature Cards',
        ) as $key => $label ) {
            $this->add_control( $key, array(
                'label'        => esc_html( $label ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default'      => $this->switch_default( $d, $key, '1' ),
            ) );
        }

        $this->end_controls_section();

        /* ------------------------------------------------------------------
         * Section Background / Box
         * ------------------------------------------------------------------ */
        $this->start_controls_section( 'section_box_style', array(
            'label' => esc_html__( 'Section Background / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background',
            'label'    => esc_html__( 'Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-intro',
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border',
            'label'    => esc_html__( 'Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-intro',
        ) );

        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow',
            'label'    => esc_html__( 'Section Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-intro',
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------------
         * Layout / Spacing
         * ------------------------------------------------------------------ */
        $this->start_controls_section( 'layout_style', array(
            'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'wrap_max_width', array(
            'label'      => esc_html__( 'Content Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 760, 'max' => 1600, 'step' => 10 ),
                '%'  => array( 'min' => 60, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-archive-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'wrap_padding', array(
            'label'      => esc_html__( 'Inner Wrap Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-archive-wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'grid_vertical_align', array(
            'label'     => esc_html__( 'Vertical Align', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => '',
            'options'   => array(
                ''       => esc_html__( 'Default', 'amaley-core' ),
                'start'  => esc_html__( 'Top', 'amaley-core' ),
                'center' => esc_html__( 'Middle', 'amaley-core' ),
                'end'    => esc_html__( 'Bottom', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-intro-grid' => 'align-items: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'column_gap', array(
            'label'      => esc_html__( 'Column Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 140 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'intro_copy_width', array(
            'label'      => esc_html__( 'Intro Copy Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 260, 'max' => 900, 'step' => 10 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro-copy' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'intro_text_align', array(
            'label'   => esc_html__( 'Intro Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-intro-copy' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------------
         * Heading / Label / Text
         * ------------------------------------------------------------------ */
        $this->start_controls_section( 'heading_text_style', array(
            'label' => esc_html__( 'Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_style_heading', array(
            'label' => esc_html__( 'Small Label', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-kicker' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-kicker',
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'title_style_heading', array(
            'label'     => esc_html__( 'Title', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-section-title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-section-title',
        ) );

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'description_style_heading', array(
            'label'     => esc_html__( 'Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'description_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-section-desc' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'description_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-section-desc',
        ) );

        $this->add_responsive_control( 'description_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro .amaley-core-shg-section-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------------
         * Feature Cards / Boxes
         * ------------------------------------------------------------------ */
        $this->start_controls_section( 'feature_card_style', array(
            'label' => esc_html__( 'Feature Cards / Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'feature_columns', array(
            'label'      => esc_html__( 'Feature Columns', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( '' ),
            'range'      => array( '' => array( 'min' => 1, 'max' => 3, 'step' => 1 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-feature-grid' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
            ),
        ) );

        $this->add_responsive_control( 'feature_gap', array(
            'label'      => esc_html__( 'Feature Card Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-feature-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'feature_text_align', array(
            'label'   => esc_html__( 'Feature Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-feature' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'feature_normal_heading', array(
            'label'     => esc_html__( 'Normal', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'feature_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-feature' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'feature_border',
            'label'    => esc_html__( 'Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-feature',
        ) );

        $this->add_responsive_control( 'feature_radius', array(
            'label'      => esc_html__( 'Border Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-feature' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'feature_shadow',
            'label'    => esc_html__( 'Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-feature',
        ) );

        $this->add_responsive_control( 'feature_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'feature_hover_heading', array(
            'label'     => esc_html__( 'Hover', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'feature_hover_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-feature:hover' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'feature_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-feature:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'feature_hover_shadow',
            'label'    => esc_html__( 'Hover Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-feature:hover',
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------------
         * Feature Text
         * ------------------------------------------------------------------ */
        $this->start_controls_section( 'feature_text_style', array(
            'label' => esc_html__( 'Feature Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'feature_title_heading', array(
            'label' => esc_html__( 'Feature Title', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_control( 'feature_title_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-feature strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'feature_title_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-feature strong',
        ) );

        $this->add_responsive_control( 'feature_title_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-feature strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'feature_description_heading', array(
            'label'     => esc_html__( 'Feature Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'feature_text_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-feature span' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'feature_text_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-feature span',
        ) );

        $this->add_responsive_control( 'feature_text_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-feature span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------------
         * Animation / Micro Motion
         * ------------------------------------------------------------------ */
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
            'range'      => array( 'ms' => array( 'min' => 150, 'max' => 900, 'step' => 50 ) ),
            'default'    => array( 'size' => 520, 'unit' => 'ms' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro' => '--acore-motion-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->add_control( 'motion_distance', array(
            'label'      => esc_html__( 'Animation Lift Distance', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 18 ) ),
            'default'    => array( 'size' => 6, 'unit' => 'px' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-intro' => '--acore-motion-y: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_lift', array(
            'label'       => esc_html__( 'Feature Hover Lift', 'amaley-core' ),
            'description' => esc_html__( 'Keep 1–3px for smooth premium motion. Use 0 to disable lift.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => array( 'px' ),
            'range'       => array( 'px' => array( 'min' => 0, 'max' => 8 ) ),
            'default'     => array( 'size' => 2, 'unit' => 'px' ),
            'selectors'   => array(
                '{{WRAPPER}} .amaley-core-shg-feature' => '--acore-hover-lift: {{SIZE}}px;',
                '{{WRAPPER}} .amaley-core-shg-feature:hover' => 'transform: translateY(calc(-1 * var(--acore-hover-lift, 2px))) scale(var(--acore-hover-scale, 1));',
            ),
        ) );

        $this->add_control( 'hover_scale', array(
            'label'       => esc_html__( 'Feature Hover Scale', 'amaley-core' ),
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
                '{{WRAPPER}} .amaley-core-shg-feature' => '--acore-hover-scale: {{VALUE}}; transition: transform .25s ease, box-shadow .25s ease, background .25s ease, border-color .25s ease;',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        echo $renderer->render_intro( $this->get_settings_for_display() );
    }
}
