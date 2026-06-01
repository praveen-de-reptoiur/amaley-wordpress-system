<?php
/** Amaley SHG Archive Trust Strip Elementor widget. */
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

        $this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_section'] ) );
        $this->add_control( 'items', array( 'label' => esc_html__( 'Items', 'amaley-core' ), 'description' => esc_html__( 'One item per line. Format: Title|Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 8, 'default' => $d['items'] ) );
        $this->end_controls_section();

        $this->start_controls_section( 'layout', array( 'label' => esc_html__( 'Layout', 'amaley-core' ) ) );
        $this->add_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 6, 'default' => $d['columns_desktop'] ) );
        $this->add_control( 'columns_tablet', array( 'label' => esc_html__( 'Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'default' => $d['columns_tablet'] ) );
        $this->add_control( 'columns_mobile', array( 'label' => esc_html__( 'Columns Mobile', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 2, 'default' => $d['columns_mobile'] ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_spacing', array( 'label' => esc_html__( 'Spacing / Layout', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_colors', array( 'label' => esc_html__( 'Colors', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-item' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-item strong' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-item span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-item' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_section();


        $this->start_controls_section( 'alignment_controls', array( 'label' => esc_html__( 'Alignment Controls', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'trust_text_align', array( 'label' => esc_html__( 'Card Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-trust-item' => 'text-align: {{VALUE}};' ) ) );
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
        echo $renderer->render_trust_strip( $this->get_settings_for_display() );
    }
}
