<?php
/** Amaley Cluster Archive CTA Band Elementor widget. v1.0.32 full control rebuild. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Archive_CTA_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_cluster_archive_cta'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Archive CTA Band', 'amaley-core' ); }
    public function get_icon() { return 'eicon-call-to-action'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-archive-sections' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => esc_html__( '1. CTA Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Build origin-led shelves' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Use Amaley clusters for products, gifting, hospitality and retail partnerships.', 'rows' => 3 ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Cluster visibility helps customers and partners understand what they are buying, where it comes from and who is connected to the product journey.', 'rows' => 4 ) );
        $this->end_controls_section();

        $this->start_controls_section( 'buttons', array( 'label' => esc_html__( '2. Buttons / Links', 'amaley-core' ) ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Amaley Products' ) );
        $this->add_control( 'button_url', array( 'label' => esc_html__( 'Primary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Contact Amaley' ) );
        $this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/contact/' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'layout', array( 'label' => esc_html__( '3. Layout / Alignment', 'amaley-core' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>720, 'max'=>1720 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'column_gap', array( 'label' => esc_html__( 'Column Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>0, 'max'=>120 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-cta-inner' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'text_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right') ), 'default'=>'left', 'selectors' => array( '{{WRAPPER}} .amcas-cta-inner' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'button_align', array( 'label' => esc_html__( 'Button Group Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start'=>array('title'=>'Left','icon'=>'eicon-h-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>'Right','icon'=>'eicon-h-align-right') ), 'default'=>'flex-start', 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-actions' => 'justify-content: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style', array( 'label' => esc_html__( '4. Section Box / Background', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-cta' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'ornament_color', array( 'label' => esc_html__( 'Ornament / Glow Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-cta:before' => 'background: radial-gradient(circle at 70% 35%, {{VALUE}}, transparent 42%);' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'selector' => '{{WRAPPER}} .amcas-cta' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'section_shadow', 'selector' => '{{WRAPPER}} .amcas-cta' ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_radius', array( 'label' => esc_html__( 'Section Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'text_style', array( 'label' => esc_html__( '5. Typography / Text', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        foreach ( array( 'label'=>'Small Label', 'title'=>'Heading', 'description'=>'Description' ) as $key => $label ) {
            $selector = 'label' === $key ? '{{WRAPPER}} .amcas-cta .amcas-label' : ( 'title' === $key ? '{{WRAPPER}} .amcas-cta h2' : '{{WRAPPER}} .amcas-cta p:not(.amcas-label)' );
            $this->add_control( $key . '_color', array( 'label' => esc_html__( $label . ' Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'color: {{VALUE}};' ) ) );
            $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $key . '_typography', 'label' => esc_html__( $label . ' Typography', 'amaley-core' ), 'selector' => $selector ) );
            $this->add_responsive_control( $key . '_margin', array( 'label' => esc_html__( $label . ' Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'button_style', array( 'label' => esc_html__( '6. Button Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'button_gap', array( 'label' => esc_html__( 'Button Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>0, 'max'=>60 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-cta .amcas-btn' ) );
        $this->add_control( 'primary_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-btn-gold' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-btn-gold' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_color', array( 'label' => esc_html__( 'Secondary Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-btn-outline-light' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_border_color', array( 'label' => esc_html__( 'Secondary Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-cta .amcas-btn-outline-light' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_archive_sections'] ) && $GLOBALS['amaley_core_cluster_archive_sections'] instanceof Amaley_Core_Cluster_Archive_Sections ? $GLOBALS['amaley_core_cluster_archive_sections'] : new Amaley_Core_Cluster_Archive_Sections();
        echo $renderer->render_cta( $this->get_settings_for_display() );
    }
}
