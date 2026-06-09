<?php
/**
 * Amaley Member / Producer Archive CTA Elementor widget.
 *
 * v1.0.117 — Producer Archive CTA full-control pass.
 * Live-site safe scope: Elementor controls only. No CPT, query, product,
 * member, SHG, cluster, media, mapping, pagination, or renderer logic changes.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_Member_Archive_CTA_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_core_member_archive_cta';
    }

    public function get_title() {
        return esc_html__( 'Amaley Member Archive CTA', 'amaley-core' );
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return array( 'amaley-core' );
    }

    public function get_style_depends() {
        return array( 'amaley-core-member-archive-sections' );
    }

    public function get_keywords() {
        return array( 'amaley', 'member', 'producer', 'archive', 'cta' );
    }

    private function defaults() {
        $renderer = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
        return $renderer->cta_defaults();
    }

    protected function register_controls() {
        $d = $this->defaults();

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
            'default'      => isset( $d['show_section'] ) ? $d['show_section'] : '1',
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

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * SHOW / HIDE
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'display_controls', array(
            'label' => esc_html__( 'Display / Show-Hide', 'amaley-core' ),
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
         * BUTTON CONTENT / LINKS
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'button_content', array(
            'label' => esc_html__( 'Button Content / Links', 'amaley-core' ),
        ) );

        $this->add_control( 'primary_text', array(
            'label'       => esc_html__( 'Primary Button Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => isset( $d['primary_text'] ) ? $d['primary_text'] : '',
            'label_block' => true,
        ) );

        $this->add_control( 'primary_url', array(
            'label'       => esc_html__( 'Primary Button URL', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'amaley-core' ),
            'default'     => array(
                'url' => isset( $d['primary_url'] ) ? $d['primary_url'] : '',
            ),
        ) );

        $this->add_control( 'secondary_text', array(
            'label'       => esc_html__( 'Secondary Button Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => isset( $d['secondary_text'] ) ? $d['secondary_text'] : '',
            'label_block' => true,
        ) );

        $this->add_control( 'secondary_url', array(
            'label'       => esc_html__( 'Secondary Button URL', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'amaley-core' ),
            'default'     => array(
                'url' => isset( $d['secondary_url'] ) ? $d['secondary_url'] : '',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: CTA SECTION / BACKGROUND
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'section_background_style', array(
            'label' => esc_html__( 'CTA Section / Background', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background',
            'label'    => esc_html__( 'Section Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .ampa-section.ampa-cta',
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-cta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border',
            'label'    => esc_html__( 'Section Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-section.ampa-cta',
        ) );

        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow',
            'label'    => esc_html__( 'Section Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-section.ampa-cta',
        ) );

        $this->add_control( 'shape_opacity', array(
            'label'      => esc_html__( 'Background Glow Opacity', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-cta::before' => 'opacity: {{SIZE}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: CTA LAYOUT / SPACING
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'layout_style', array(
            'label' => esc_html__( 'CTA Layout / Spacing', 'amaley-core' ),
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
                '{{WRAPPER}} .ampa-cta .ampa-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'grid_gap', array(
            'label'      => esc_html__( 'Text / Button Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 120 ),
                'em' => array( 'min' => 0, 'max' => 8, 'step' => 0.1 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-cta-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'text_align', array(
            'label'   => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-cta-grid > div:first-child' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'button_align', array(
            'label'   => esc_html__( 'Button Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''              => esc_html__( 'Default', 'amaley-core' ),
                'flex-start'    => esc_html__( 'Left', 'amaley-core' ),
                'center'        => esc_html__( 'Center', 'amaley-core' ),
                'flex-end'      => esc_html__( 'Right', 'amaley-core' ),
                'space-between' => esc_html__( 'Space Between', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-actions' => 'justify-content: {{VALUE}};',
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
                '{{WRAPPER}} .ampa-cta .ampa-actions' => 'gap: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .ampa-cta .ampa-actions' => 'margin-top: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: CTA HEADING / LABEL / TEXT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'text_style', array(
            'label' => esc_html__( 'CTA Heading / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Small Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-kicker' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'label'    => esc_html__( 'Small Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-kicker',
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Small Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-section-title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-section-title',
        ) );

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'desc_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-section-desc' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'desc_typography',
            'label'    => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-section-desc',
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
                '{{WRAPPER}} .ampa-cta .ampa-section-desc' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'description_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-section-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: CTA BUTTONS — locked Normal / Hover pattern.
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'button_style', array(
            'label' => esc_html__( 'CTA Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'primary_button_heading', array(
            'label' => esc_html__( 'Primary Button', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'primary_button_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-btn-primary',
        ) );

        $this->add_responsive_control( 'primary_button_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'primary_button_radius', array(
            'label'      => esc_html__( 'Border Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->start_controls_tabs( 'primary_button_tabs' );

        $this->start_controls_tab( 'primary_button_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'primary_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'primary_button_shadow',
            'label'    => esc_html__( 'Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-btn-primary',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'primary_button_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'primary_hover_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-primary:focus' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_hover_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-primary:focus' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'primary_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-primary:focus' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'primary_button_hover_shadow',
            'label'    => esc_html__( 'Hover Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-btn-primary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-primary:focus',
        ) );

        $this->add_control( 'primary_hover_transform', array(
            'label'   => esc_html__( 'Hover Lift', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''                 => esc_html__( 'Default', 'amaley-core' ),
                'translateY(0)'    => esc_html__( 'None', 'amaley-core' ),
                'translateY(-1px)' => esc_html__( 'Soft', 'amaley-core' ),
                'translateY(-2px)' => esc_html__( 'Medium', 'amaley-core' ),
                'translateY(-3px)' => esc_html__( 'Strong', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-primary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-primary:focus' => 'transform: {{VALUE}};',
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
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-btn-secondary',
        ) );

        $this->add_responsive_control( 'secondary_button_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'secondary_button_radius', array(
            'label'      => esc_html__( 'Border Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->start_controls_tabs( 'secondary_button_tabs' );

        $this->start_controls_tab( 'secondary_button_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'secondary_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'secondary_button_shadow',
            'label'    => esc_html__( 'Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-btn-secondary',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'secondary_button_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'secondary_hover_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-secondary:focus' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_hover_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-secondary:focus' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'secondary_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-secondary:focus' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'secondary_button_hover_shadow',
            'label'    => esc_html__( 'Hover Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-cta .ampa-btn-secondary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-secondary:focus',
        ) );

        $this->add_control( 'secondary_hover_transform', array(
            'label'   => esc_html__( 'Hover Lift', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''                 => esc_html__( 'Default', 'amaley-core' ),
                'translateY(0)'    => esc_html__( 'None', 'amaley-core' ),
                'translateY(-1px)' => esc_html__( 'Soft', 'amaley-core' ),
                'translateY(-2px)' => esc_html__( 'Medium', 'amaley-core' ),
                'translateY(-3px)' => esc_html__( 'Strong', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-cta .ampa-btn-secondary:hover, {{WRAPPER}} .ampa-cta .ampa-btn-secondary:focus' => 'transform: {{VALUE}};',
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
                '{{WRAPPER}} .ampa-cta .ampa-btn' => 'transition-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: CTA ANIMATION / MICRO MOTION
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'motion_style', array(
            'label' => esc_html__( 'CTA Animation / Micro Motion', 'amaley-core' ),
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
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-cta' => '--acore-motion-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->add_control( 'motion_distance', array(
            'label'      => esc_html__( 'Animation Lift Distance', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 18 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-cta' => '--acore-motion-y: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_lift', array(
            'label'      => esc_html__( 'Hover Lift', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
                'px' => array( 'min' => 0, 'max' => 8 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-cta' => '--acore-hover-lift: {{SIZE}}px;',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
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
