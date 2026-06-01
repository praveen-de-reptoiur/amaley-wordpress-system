<?php
/** Amaley SHG Archive Intro Elementor widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Archive_Intro_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_shg_archive_intro'; }
    public function get_title() { return esc_html__( 'Amaley SHG Archive Intro', 'amaley-core' ); }
    public function get_icon() { return 'eicon-text-area'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'archive', 'intro' ); }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d = $renderer->intro_defaults();

        $this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_section'] ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['label'] ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $d['title'] ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $d['description'] ) );
        for ( $i = 1; $i <= 3; $i++ ) {
            $this->add_control( 'feature_' . $i . '_title', array( 'label' => esc_html( 'Feature ' . $i . ' Title' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d[ 'feature_' . $i . '_title' ] ) );
            $this->add_control( 'feature_' . $i . '_text', array( 'label' => esc_html( 'Feature ' . $i . ' Text' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $d[ 'feature_' . $i . '_text' ] ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', array( 'label' => esc_html__( 'Show / Hide', 'amaley-core' ) ) );
        foreach ( array( 'show_label' => 'Small Label', 'show_title' => 'Title', 'show_description' => 'Description', 'show_features' => 'Feature Cards' ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html( $label ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d[ $key ] ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'layout_style', array( 'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-intro' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'column_gap', array( 'label' => esc_html__( 'Column Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-intro-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'feature_gap', array( 'label' => esc_html__( 'Feature Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-feature-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'feature_padding', array( 'label' => esc_html__( 'Feature Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'colors_style', array( 'label' => esc_html__( 'Colors', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-intro' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-section-title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'accent_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-kicker' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-section-desc, {{WRAPPER}} .amaley-core-shg-feature span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'feature_bg', array( 'label' => esc_html__( 'Feature Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-feature' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();


        $this->start_controls_section( 'alignment_controls', array( 'label' => esc_html__( 'Alignment Controls', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'intro_text_align', array( 'label' => esc_html__( 'Intro Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-intro-copy' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'feature_text_align', array( 'label' => esc_html__( 'Feature Card Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-feature' => 'text-align: {{VALUE}};' ) ) );
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
        echo $renderer->render_intro( $this->get_settings_for_display() );
    }
}
