<?php
/** Amaley SHG Archive Hero Elementor widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Archive_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_shg_archive_hero'; }
    public function get_title() { return esc_html__( 'Amaley SHG Archive Hero', 'amaley-core' ); }
    public function get_icon() { return 'eicon-banner'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'archive', 'hero' ); }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d = $renderer->hero_defaults();

        $this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_section'] ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['label'] ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $d['title'] ) );
        $this->add_control( 'accent', array( 'label' => esc_html__( 'Italic Accent Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['accent'] ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $d['description'] ) );
        $this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['primary_text'] ) );
        $this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['primary_url'] ) );
        $this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['secondary_text'] ) );
        $this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['secondary_url'] ) );
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', array( 'label' => esc_html__( 'Show / Hide', 'amaley-core' ) ) );
        foreach ( array( 'show_label' => 'Small Label', 'show_title' => 'Title', 'show_description' => 'Description', 'show_primary_button' => 'Primary Button', 'show_secondary_button' => 'Secondary Button', 'show_stats' => 'Stats Panel' ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html( $label ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d[ $key ] ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'stats', array( 'label' => esc_html__( 'Stats Panel', 'amaley-core' ) ) );
        $this->add_control( 'stats_mode', array( 'label' => esc_html__( 'Stats Mode', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => isset( $d['stats_mode'] ) ? $d['stats_mode'] : 'dynamic', 'options' => array( 'dynamic' => esc_html__( 'Auto / Dynamic Counts', 'amaley-core' ), 'manual' => esc_html__( 'Manual Text', 'amaley-core' ) ) ) );
        for ( $i = 1; $i <= 4; $i++ ) {
            $this->add_control( 'stat_' . $i . '_value', array( 'label' => esc_html( 'Stat ' . $i . ' Value' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d[ 'stat_' . $i . '_value' ] ) );
            $this->add_control( 'stat_' . $i . '_label', array( 'label' => esc_html( 'Stat ' . $i . ' Label' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d[ 'stat_' . $i . '_label' ] ) );
        }
        $this->add_control( 'stats_columns_desktop', array( 'label' => esc_html__( 'Stats Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'default' => $d['stats_columns_desktop'] ?? 2 ) );
        $this->add_control( 'stats_columns_tablet', array( 'label' => esc_html__( 'Stats Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'default' => $d['stats_columns_tablet'] ?? 2 ) );
        $this->add_control( 'stats_columns_mobile', array( 'label' => esc_html__( 'Stats Columns Mobile', 'amaley-core' ), 'description' => esc_html__( 'Set 2 for 2 + 2 layout on phone.', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 2, 'default' => $d['stats_columns_mobile'] ?? 2 ) );
        $this->end_controls_section();

        $this->start_controls_section( 'layout_style', array( 'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_gap', array( 'label' => esc_html__( 'Hero Column Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-archive-wrap' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();


        $this->start_controls_section( 'typography_style', array( 'label' => esc_html__( 'Typography', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_label_typography', 'label' => esc_html__( 'Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-archive-hero .amaley-core-shg-kicker' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-archive-title' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-archive-desc' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'stats_panel_style', array( 'label' => esc_html__( 'Stats Panel Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'stats_panel_padding', array( 'label' => esc_html__( 'Panel Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-hero-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'stats_gap', array( 'label' => esc_html__( 'Stats Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 18 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-hero-panel' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'stat_box_bg', array( 'label' => esc_html__( 'Stat Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-stat' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'stat_box_border', array( 'label' => esc_html__( 'Stat Box Border', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-stat' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'stat_number_color', array( 'label' => esc_html__( 'Stat Number Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-stat strong' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'stat_label_color', array( 'label' => esc_html__( 'Stat Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-stat span' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'button_style', array( 'label' => esc_html__( 'Button Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt' ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-btn, {{WRAPPER}} .amaley-core-shg-btn-alt' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'colors_style', array( 'label' => esc_html__( 'Colors', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-hero' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-kicker, {{WRAPPER}} .amaley-core-shg-archive-title em' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Primary Button BG', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-btn' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_color', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-btn' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'panel_bg', array( 'label' => esc_html__( 'Stats Panel BG', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-hero-panel' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();


        $this->start_controls_section( 'alignment_controls', array( 'label' => esc_html__( 'Alignment Controls', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'hero_text_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-hero-copy' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_button_align', array( 'label' => esc_html__( 'Button Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => esc_html__( 'Default', 'amaley-core' ), 'flex-start' => esc_html__( 'Left', 'amaley-core' ), 'center' => esc_html__( 'Center', 'amaley-core' ), 'flex-end' => esc_html__( 'Right', 'amaley-core' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-hero-actions' => 'justify-content: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_stats_align', array( 'label' => esc_html__( 'Stats Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-stat' => 'text-align: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'motion_style', array( 'label' => esc_html__( 'Animation / Micro Motion', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'motion_mode', array(
            'label' => esc_html__( 'Section Animation', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'on',
            'options' => array( 'on' => esc_html__( 'On', 'amaley-core' ), 'off' => esc_html__( 'Off', 'amaley-core' ) ),
            'prefix_class' => 'amaley-core-motion-'
        ) );
        $this->add_control( 'motion_duration', array(
            'label' => esc_html__( 'Animation Duration', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range' => array( 'ms' => array( 'min' => 150, 'max' => 900, 'step' => 50 ) ),
            'default' => array( 'size' => 520, 'unit' => 'ms' ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-duration: {{SIZE}}ms;' )
        ) );
        $this->add_control( 'motion_distance', array(
            'label' => esc_html__( 'Animation Lift Distance', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 18 ) ),
            'default' => array( 'size' => 6, 'unit' => 'px' ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-y: {{SIZE}}px;' )
        ) );
        $this->add_control( 'hover_lift', array(
            'label' => esc_html__( 'Hover Lift', 'amaley-core' ),
            'description' => esc_html__( 'Keep 1–3px for smooth premium motion. Use 0 to disable lift.', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 8 ) ),
            'default' => array( 'size' => 2, 'unit' => 'px' ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-hover-lift: {{SIZE}}px;' )
        ) );
        $this->add_control( 'hover_scale', array(
            'label' => esc_html__( 'Hover Scale', 'amaley-core' ),
            'description' => esc_html__( 'Use Soft for smooth movement. Set None if the page feels heavy.', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '1.003',
            'options' => array( '1' => esc_html__( 'None', 'amaley-core' ), '1.003' => esc_html__( 'Soft', 'amaley-core' ), '1.006' => esc_html__( 'Medium', 'amaley-core' ), '1.01' => esc_html__( 'Strong', 'amaley-core' ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-hover-scale: {{VALUE}};' )
        ) );
        $this->add_control( 'image_hover_zoom', array(
            'label' => esc_html__( 'Image Hover Zoom', 'amaley-core' ),
            'description' => esc_html__( 'Controls card image/placeholder zoom on hover.', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '1.018',
            'options' => array( '1' => esc_html__( 'None', 'amaley-core' ), '1.012' => esc_html__( 'Very Soft', 'amaley-core' ), '1.018' => esc_html__( 'Soft', 'amaley-core' ), '1.035' => esc_html__( 'Visible', 'amaley-core' ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-image-zoom: {{VALUE}};' )
        ) );
        $this->end_controls_section();

    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        echo $renderer->render_hero( $this->get_settings_for_display() );
    }
}
