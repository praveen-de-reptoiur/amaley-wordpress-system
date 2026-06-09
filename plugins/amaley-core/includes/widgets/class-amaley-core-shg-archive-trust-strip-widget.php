<?php
/**
 * Amaley SHG Archive Trust Strip Elementor widget.
 *
 * v1.0.104-full-controls
 * Live-site safe upgrade: adds full Elementor style controls for the SHG Archive
 * Trust Strip without touching data queries, SHG records, pages, media, mappings,
 * WooCommerce, or frontend renderer logic.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Archive_Trust_Strip_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_shg_archive_trust_strip'; }
    public function get_title() { return esc_html__( 'Amaley SHG Archive Trust Strip', 'amaley-core' ); }
    public function get_icon() { return 'eicon-info-box'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'archive', 'trust', 'strip' ); }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d = $renderer->trust_defaults();

        /* ------------------------------------------------------------
         * Content
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'content', array(
            'label' => esc_html__( 'Content', 'amaley-core' ),
        ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Section', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_section'],
        ) );

        $this->add_control( 'items', array(
            'label'       => esc_html__( 'Items', 'amaley-core' ),
            'description' => esc_html__( 'One item per line. Format: Title|Description', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 8,
            'default'     => $d['items'],
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Layout
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'layout', array(
            'label' => esc_html__( 'Layout', 'amaley-core' ),
        ) );

        $this->add_control( 'columns_desktop', array(
            'label'   => esc_html__( 'Columns Desktop', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 6,
            'default' => $d['columns_desktop'],
        ) );

        $this->add_control( 'columns_tablet', array(
            'label'   => esc_html__( 'Columns Tablet', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 4,
            'default' => $d['columns_tablet'],
        ) );

        $this->add_control( 'columns_mobile', array(
            'label'   => esc_html__( 'Columns Mobile', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 2,
            'default' => $d['columns_mobile'],
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Section Background / Box
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'section_box_style', array(
            'label' => esc_html__( 'Section Background / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background_group',
            'label'    => esc_html__( 'Section Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust',
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border_group',
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust',
        ) );

        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow_group',
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust',
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Layout / Spacing
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'layout_spacing_style', array(
            'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'wrap_max_width', array(
            'label'      => esc_html__( 'Container Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 720, 'max' => 1600, 'step' => 10 ),
                '%'  => array( 'min' => 70, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust .amaley-core-shg-archive-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'wrap_padding', array(
            'label'      => esc_html__( 'Container Inner Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust .amaley-core-shg-archive-wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'grid_gap', array(
            'label'      => esc_html__( 'Card Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'grid_align_items', array(
            'label'   => esc_html__( 'Card Vertical Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'start'  => array( 'title' => esc_html__( 'Top', 'amaley-core' ), 'icon' => 'eicon-v-align-top' ),
                'center' => array( 'title' => esc_html__( 'Middle', 'amaley-core' ), 'icon' => 'eicon-v-align-middle' ),
                'end'    => array( 'title' => esc_html__( 'Bottom', 'amaley-core' ), 'icon' => 'eicon-v-align-bottom' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-trust-grid' => 'align-items: {{VALUE}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Cards / Boxes
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'card_box_style', array(
            'label' => esc_html__( 'Cards / Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'card_padding', array(
            'label'      => esc_html__( 'Card Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'card_min_height', array(
            'label'      => esc_html__( 'Card Min Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 420 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item' => 'min-height: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'card_radius', array(
            'label'      => esc_html__( 'Card Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->start_controls_tabs( 'card_state_tabs' );

        $this->start_controls_tab( 'card_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'card_background_group',
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust-item',
        ) );

        $this->add_control( 'card_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'card_shadow_group',
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust-item',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'card_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'card_hover_background_group',
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust-item:hover',
        ) );

        $this->add_control( 'card_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'card_hover_shadow_group',
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust-item:hover',
        ) );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Card Text / Typography
         * ------------------------------------------------------------ */
        $this->start_controls_section( 'card_text_style', array(
            'label' => esc_html__( 'Card Text / Typography', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'trust_text_align', array(
            'label'   => esc_html__( 'Card Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography_group',
            'label'    => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust-item strong',
        ) );

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'text_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item span' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'text_typography_group',
            'label'    => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-trust-item span',
        ) );

        $this->add_responsive_control( 'text_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-trust-item span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* ------------------------------------------------------------
         * Style: Animation / Micro Motion
         * ------------------------------------------------------------ */
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
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->add_control( 'motion_distance', array(
            'label'      => esc_html__( 'Animation Lift Distance', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 18 ) ),
            'default'    => array( 'size' => 6, 'unit' => 'px' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-y: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_lift', array(
            'label'       => esc_html__( 'Card Hover Lift', 'amaley-core' ),
            'description' => esc_html__( 'Keep 1–3px for smooth premium motion. Use 0 to disable lift.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => array( 'px' ),
            'range'       => array( 'px' => array( 'min' => 0, 'max' => 8 ) ),
            'default'     => array( 'size' => 2, 'unit' => 'px' ),
            'selectors'   => array(
                '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-hover-lift: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_scale', array(
            'label'       => esc_html__( 'Card Hover Scale', 'amaley-core' ),
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
        echo $renderer->render_trust_strip( $this->get_settings_for_display() );
    }
}
