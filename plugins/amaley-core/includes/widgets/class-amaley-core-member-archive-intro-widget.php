<?php
/**
 * Amaley Member/Producer Archive Intro Elementor widget.
 *
 * v1.0.114 archive-intro-full-controls
 * - Producer Archive only.
 * - Keeps render/data logic untouched.
 * - Adds clean section-wise controls only for the elements present in Intro.
 * - No card/product/gallery/button/pagination controls here.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_Intro_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_core_member_archive_intro';
    }

    public function get_title() {
        return esc_html__( 'Amaley Member Archive Intro', 'amaley-core' );
    }

    public function get_icon() {
        return 'eicon-text-area';
    }

    public function get_categories() {
        return array( 'amaley-core' );
    }

    public function get_style_depends() {
        return array( 'amaley-core-member-archive-sections' );
    }

    private function defaults() {
        $r = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
        return $r->intro_defaults();
    }

    protected function register_controls() {
        $d = $this->defaults();

        /* ------------------------------------------------------------
         * Content controls — only Intro section elements.
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'content_display', array(
            'label' => esc_html__( '1. Content + Show / Hide', 'amaley-core' ),
        ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Section', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_section'] ?? '1',
        ) );

        $this->add_control( 'show_label', array(
            'label'        => esc_html__( 'Show Small Label', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_label'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'show_title', array(
            'label'        => esc_html__( 'Show Title', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_title'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'show_description', array(
            'label'        => esc_html__( 'Show Description', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_description'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'label', array(
            'label'       => esc_html__( 'Small Label Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['label'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_section' => '1', 'show_label' => '1' ),
        ) );

        $this->add_control( 'title', array(
            'label'       => esc_html__( 'Title', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['title'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_section' => '1', 'show_title' => '1' ),
        ) );

        $this->add_control( 'description', array(
            'label'       => esc_html__( 'Description', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => $d['description'] ?? '',
            'label_block' => true,
            'rows'        => 5,
            'condition'   => array( 'show_section' => '1', 'show_description' => '1' ),
        ) );

        $this->add_control( 'show_features', array(
            'label'        => esc_html__( 'Show Feature Cards', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_features'] ?? '1',
            'separator'    => 'before',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        for ( $i = 1; $i <= 3; $i++ ) {
            $this->add_control( 'show_feature_' . $i, array(
                'label'        => sprintf( esc_html__( 'Show Feature %d', 'amaley-core' ), $i ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default'      => $d[ 'show_feature_' . $i ] ?? '1',
                'condition'    => array( 'show_section' => '1', 'show_features' => '1' ),
            ) );

            $this->add_control( 'feature_' . $i . '_title', array(
                'label'       => sprintf( esc_html__( 'Feature %d Title', 'amaley-core' ), $i ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => $d[ 'feature_' . $i . '_title' ] ?? '',
                'label_block' => true,
                'condition'   => array( 'show_section' => '1', 'show_features' => '1', 'show_feature_' . $i => '1' ),
            ) );

            $this->add_control( 'feature_' . $i . '_text', array(
                'label'       => sprintf( esc_html__( 'Feature %d Text', 'amaley-core' ), $i ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => $d[ 'feature_' . $i . '_text' ] ?? '',
                'label_block' => true,
                'rows'        => 3,
                'condition'   => array( 'show_section' => '1', 'show_features' => '1', 'show_feature_' . $i => '1' ),
            ) );
        }

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Section Background / Box.
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'style_section_box', array(
            'label' => esc_html__( '2. Section Background / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background',
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .ampa-section.ampa-intro',
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-intro' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-intro' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border',
            'selector' => '{{WRAPPER}} .ampa-section.ampa-intro',
        ) );

        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-intro' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow',
            'selector' => '{{WRAPPER}} .ampa-section.ampa-intro',
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Layout / Spacing.
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'style_layout', array(
            'label' => esc_html__( '3. Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'container_max_width', array(
            'label'      => esc_html__( 'Container Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 640, 'max' => 1600 ),
                '%'  => array( 'min' => 60, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro > .ampa-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'container_side_padding', array(
            'label'      => esc_html__( 'Container Side Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%', 'rem' ),
            'allowed_dimensions' => 'horizontal',
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro > .ampa-wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'intro_column_gap', array(
            'label'      => esc_html__( 'Text / Feature Column Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em', 'rem' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 140 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'intro_row_gap', array(
            'label'      => esc_html__( 'Row Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em', 'rem' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'intro_vertical_align', array(
            'label'   => esc_html__( 'Vertical Align', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'start'  => array( 'title' => esc_html__( 'Top', 'amaley-core' ), 'icon' => 'eicon-v-align-top' ),
                'center' => array( 'title' => esc_html__( 'Middle', 'amaley-core' ), 'icon' => 'eicon-v-align-middle' ),
                'end'    => array( 'title' => esc_html__( 'Bottom', 'amaley-core' ), 'icon' => 'eicon-v-align-bottom' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-intro-grid' => 'align-items: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'copy_align', array(
            'label'   => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-intro-copy' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'copy_max_width', array(
            'label'      => esc_html__( 'Text Column Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 260, 'max' => 900 ),
                '%'  => array( 'min' => 20, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro-copy' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Heading / Label / Text.
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'style_text', array(
            'label' => esc_html__( '4. Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Small Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-intro .ampa-kicker' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'label'    => esc_html__( 'Small Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-intro .ampa-kicker',
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Small Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro .ampa-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-intro .ampa-section-title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-intro .ampa-section-title',
        ) );

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro .ampa-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'description_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-intro .ampa-section-desc' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'description_typography',
            'label'    => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-intro .ampa-section-desc',
        ) );

        $this->add_responsive_control( 'description_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-intro .ampa-section-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Feature Cards / Boxes.
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'style_feature_cards', array(
            'label' => esc_html__( '5. Feature Cards / Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'feature_columns', array(
            'label'     => esc_html__( 'Feature Columns', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 1,
            'max'       => 4,
            'step'      => 1,
            'selectors' => array(
                '{{WRAPPER}} .ampa-feature-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
            ),
        ) );

        $this->add_responsive_control( 'feature_gap', array(
            'label'      => esc_html__( 'Feature Card Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em', 'rem' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'feature_card_min_height', array(
            'label'      => esc_html__( 'Card Minimum Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em', 'rem' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 320 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card' => 'min-height: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'feature_card_padding', array(
            'label'      => esc_html__( 'Card Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'feature_card_radius', array(
            'label'      => esc_html__( 'Card Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'feature_card_border',
            'selector' => '{{WRAPPER}} .ampa-feature-card',
        ) );

        $this->start_controls_tabs( 'feature_card_state_tabs' );

        $this->start_controls_tab( 'feature_card_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'feature_card_background',
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .ampa-feature-card',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'feature_card_shadow',
            'selector' => '{{WRAPPER}} .ampa-feature-card',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'feature_card_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'feature_card_hover_background',
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .ampa-feature-card:hover',
        ) );

        $this->add_control( 'feature_card_hover_border_color', array(
            'label'     => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-feature-card:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'feature_card_hover_shadow',
            'selector' => '{{WRAPPER}} .ampa-feature-card:hover',
        ) );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Feature Text.
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'style_feature_text', array(
            'label' => esc_html__( '6. Feature Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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
                '{{WRAPPER}} .ampa-feature-card' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'feature_title_color', array(
            'label'     => esc_html__( 'Feature Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-feature-card strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'feature_title_typography',
            'label'    => esc_html__( 'Feature Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-feature-card strong',
        ) );

        $this->add_responsive_control( 'feature_title_margin', array(
            'label'      => esc_html__( 'Feature Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'feature_text_color', array(
            'label'     => esc_html__( 'Feature Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-feature-card p' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'feature_text_typography',
            'label'    => esc_html__( 'Feature Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-feature-card p',
        ) );

        $this->add_responsive_control( 'feature_text_margin', array(
            'label'      => esc_html__( 'Feature Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', 'rem' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Animation / Micro Motion.
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'style_motion', array(
            'label' => esc_html__( '7. Animation / Micro Motion', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'feature_transition_duration', array(
            'label'      => esc_html__( 'Card Transition Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 's', 'ms' ),
            'range'      => array(
                's'  => array( 'min' => 0, 'max' => 2, 'step' => 0.05 ),
                'ms' => array( 'min' => 0, 'max' => 2000, 'step' => 50 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'feature_hover_lift', array(
            'label'      => esc_html__( 'Card Hover Lift', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 32 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card:hover' => 'transform: translateY(calc({{SIZE}}{{UNIT}} * -1));',
            ),
        ) );

        $this->add_responsive_control( 'feature_hover_scale', array(
            'label'      => esc_html__( 'Card Hover Scale', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => array( '' => array( 'min' => 1, 'max' => 1.08, 'step' => 0.005 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-feature-card:hover' => 'transform: translateY(calc(var(--ampa-member-intro-lift, 0px) * -1)) scale({{SIZE}});',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $r = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
        echo $r->render_intro( $this->get_settings_for_display() );
    }
}
