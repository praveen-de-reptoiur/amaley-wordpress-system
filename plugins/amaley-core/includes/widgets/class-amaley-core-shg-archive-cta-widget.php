<?php
/**
 * Amaley SHG Archive CTA Elementor widget.
 *
 * v1.0.106 — SHG Archive CTA full-control pass.
 * Live-site safe scope: Elementor controls only. No data, query, CPT,
 * mapping, product, photo, page-template, or renderer logic changes.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_SHG_Archive_CTA_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_core_shg_archive_cta';
    }

    public function get_title() {
        return esc_html__( 'Amaley SHG Archive CTA', 'amaley-core' );
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return array( 'amaley-core' );
    }

    public function get_style_depends() {
        return array( 'amaley-core-shg-archive-sections' );
    }

    public function get_keywords() {
        return array( 'amaley', 'shg', 'archive', 'cta' );
    }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d        = $renderer->cta_defaults();

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
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'amaley-core' ),
            'default'     => array(
                'url' => $d['primary_url'],
            ),
        ) );

        $this->add_control( 'secondary_text', array(
            'label'   => esc_html__( 'Secondary Button Text', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => $d['secondary_text'],
        ) );

        $this->add_control( 'secondary_url', array(
            'label'       => esc_html__( 'Secondary Button URL', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'amaley-core' ),
            'default'     => array(
                'url' => $d['secondary_url'],
            ),
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
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta',
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border',
            'label'    => esc_html__( 'Section Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta',
        ) );

        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow',
            'label'    => esc_html__( 'Section Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta',
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: INNER CTA PANEL
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'panel_style', array(
            'label' => esc_html__( 'CTA Panel / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'panel_background',
            'label'    => esc_html__( 'Panel Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta-inner',
        ) );

        $this->add_responsive_control( 'panel_padding', array(
            'label'      => esc_html__( 'Panel Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'panel_border',
            'label'    => esc_html__( 'Panel Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta-inner',
        ) );

        $this->add_responsive_control( 'panel_radius', array(
            'label'      => esc_html__( 'Panel Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'panel_shadow',
            'label'    => esc_html__( 'Panel Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta-inner',
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: LAYOUT / SPACING
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'layout_style', array(
            'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'container_width', array(
            'label'      => esc_html__( 'Container Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 640, 'max' => 1600, 'step' => 10 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'content_width', array(
            'label'      => esc_html__( 'Content Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 420, 'max' => 1200, 'step' => 10 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta-inner' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'content_alignment', array(
            'label'   => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta-inner' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'panel_horizontal_position', array(
            'label'   => esc_html__( 'Panel Position', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''            => esc_html__( 'Default', 'amaley-core' ),
                'flex-start'  => esc_html__( 'Left', 'amaley-core' ),
                'center'      => esc_html__( 'Center', 'amaley-core' ),
                'flex-end'    => esc_html__( 'Right', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-archive-wrap' => 'display: flex; justify-content: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'button_gap', array(
            'label'      => esc_html__( 'Button Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 80 ),
                'em' => array( 'min' => 0, 'max' => 5, 'step' => 0.1 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-hero-actions' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'button_top_gap', array(
            'label'      => esc_html__( 'Buttons Top Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 100 ),
                'em' => array( 'min' => 0, 'max' => 6, 'step' => 0.1 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-hero-actions' => 'margin-top: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'button_alignment', array(
            'label'   => esc_html__( 'Button Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''            => esc_html__( 'Default', 'amaley-core' ),
                'flex-start'  => esc_html__( 'Left', 'amaley-core' ),
                'center'      => esc_html__( 'Center', 'amaley-core' ),
                'flex-end'    => esc_html__( 'Right', 'amaley-core' ),
                'space-between' => esc_html__( 'Space Between', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-hero-actions' => 'justify-content: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'button_stack_width', array(
            'label'   => esc_html__( 'Button Layout', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''        => esc_html__( 'Default / Inline', 'amaley-core' ),
                'wrap'    => esc_html__( 'Wrap', 'amaley-core' ),
                'nowrap'  => esc_html__( 'No Wrap', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-hero-actions' => 'flex-wrap: {{VALUE}};',
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

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Small Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-kicker' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'label'    => esc_html__( 'Small Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-kicker',
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Small Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-title',
        ) );

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'description_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-desc' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'description_typography',
            'label'    => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-desc',
        ) );

        $this->add_responsive_control( 'description_width', array(
            'label'      => esc_html__( 'Description Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 300, 'max' => 1200 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-desc' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'description_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: BUTTONS — locked Normal / Hover pattern.
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'buttons_style', array(
            'label' => esc_html__( 'Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'primary_button_heading', array(
            'label' => esc_html__( 'Primary Button', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'primary_button_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn',
        ) );

        $this->add_responsive_control( 'primary_button_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'primary_button_radius', array(
            'label'      => esc_html__( 'Border Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->start_controls_tabs( 'primary_button_tabs' );

        $this->start_controls_tab( 'primary_button_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'primary_button_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_text_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'primary_button_shadow',
            'label'    => esc_html__( 'Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'primary_button_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'primary_button_hover_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:focus' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_hover_text_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:focus' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_button_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:focus' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'primary_button_hover_shadow',
            'label'    => esc_html__( 'Hover Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:focus',
        ) );

        $this->add_control( 'primary_button_hover_transform', array(
            'label'   => esc_html__( 'Hover Lift', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''                          => esc_html__( 'Default', 'amaley-core' ),
                'translateY(0)'             => esc_html__( 'None', 'amaley-core' ),
                'translateY(-1px)'          => esc_html__( 'Soft', 'amaley-core' ),
                'translateY(-2px)'          => esc_html__( 'Medium', 'amaley-core' ),
                'translateY(-3px)'          => esc_html__( 'Strong', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn:focus' => 'transform: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'secondary_button_heading', array(
            'label'     => esc_html__( 'Secondary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'secondary_button_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt',
        ) );

        $this->add_responsive_control( 'secondary_button_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'secondary_button_radius', array(
            'label'      => esc_html__( 'Border Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->start_controls_tabs( 'secondary_button_tabs' );

        $this->start_controls_tab( 'secondary_button_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'secondary_button_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_text_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'secondary_button_shadow',
            'label'    => esc_html__( 'Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'secondary_button_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'secondary_button_hover_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:focus' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_hover_text_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:focus' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_button_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:focus' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'secondary_button_hover_shadow',
            'label'    => esc_html__( 'Hover Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:focus',
        ) );

        $this->add_control( 'secondary_button_hover_transform', array(
            'label'   => esc_html__( 'Hover Lift', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''                          => esc_html__( 'Default', 'amaley-core' ),
                'translateY(0)'             => esc_html__( 'None', 'amaley-core' ),
                'translateY(-1px)'          => esc_html__( 'Soft', 'amaley-core' ),
                'translateY(-2px)'          => esc_html__( 'Medium', 'amaley-core' ),
                'translateY(-3px)'          => esc_html__( 'Strong', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:hover, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt:focus' => 'transform: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'button_transition_duration', array(
            'label'      => esc_html__( 'Transition Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range'      => array(
                'ms' => array( 'min' => 0, 'max' => 900, 'step' => 50 ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn-alt' => 'transition-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: ANIMATION / MICRO MOTION
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

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $settings = $this->get_settings_for_display();

        if ( isset( $settings['primary_url'] ) && is_array( $settings['primary_url'] ) ) {
            $settings['primary_url'] = isset( $settings['primary_url']['url'] ) ? $settings['primary_url']['url'] : '';
        }

        if ( isset( $settings['secondary_url'] ) && is_array( $settings['secondary_url'] ) ) {
            $settings['secondary_url'] = isset( $settings['secondary_url']['url'] ) ? $settings['secondary_url']['url'] : '';
        }

        echo $renderer->render_cta( $settings );
    }
}
