<?php
/** Amaley SHG Archive CTA Elementor widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Archive_CTA_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_shg_archive_cta'; }
    public function get_title() { return esc_html__( 'Amaley SHG Archive CTA', 'amaley-core' ); }
    public function get_icon() { return 'eicon-call-to-action'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'archive', 'cta' ); }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d = $renderer->cta_defaults();

        $this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_section'] ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['label'] ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $d['title'] ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $d['description'] ) );
        $this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['primary_text'] ) );
        $this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['primary_url'] ) );
        $this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['secondary_text'] ) );
        $this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['secondary_url'] ) );
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', array( 'label' => esc_html__( 'Show / Hide', 'amaley-core' ) ) );
        foreach ( array( 'show_label' => 'Small Label', 'show_title' => 'Title', 'show_description' => 'Description', 'show_primary_button' => 'Primary Button', 'show_secondary_button' => 'Secondary Button' ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html( $label ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d[ $key ] ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'layout_style', array( 'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'content_width', array( 'label' => esc_html__( 'Content Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 480, 'max' => 1400 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta-inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'text_align', array( 'label' => esc_html__( 'Text Align', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta-inner' => 'text-align: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'colors_style', array( 'label' => esc_html__( 'Colors', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'text_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-section-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-kicker' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Primary Button BG', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_color', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-btn' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();


        $this->start_controls_section( 'alignment_extra_controls', array( 'label' => esc_html__( 'Alignment Controls', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'cta_button_align', array( 'label' => esc_html__( 'Button Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => esc_html__( 'Default', 'amaley-core' ), 'flex-start' => esc_html__( 'Left', 'amaley-core' ), 'center' => esc_html__( 'Center', 'amaley-core' ), 'flex-end' => esc_html__( 'Right', 'amaley-core' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cta .amaley-core-shg-hero-actions' => 'justify-content: {{VALUE}};' ) ) );
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
        echo $renderer->render_cta( $this->get_settings_for_display() );
    }
}
