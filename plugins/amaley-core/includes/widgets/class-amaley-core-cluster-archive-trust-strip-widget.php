<?php
/** Amaley Cluster Archive Trust Strip Elementor widget. v1.0.32 full control rebuild. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Archive_Trust_Strip_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_cluster_archive_trust_strip'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Archive Trust Strip', 'amaley-core' ); }
    public function get_icon() { return 'eicon-info-circle-o'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-archive-sections' ); }

    protected function register_controls() {
        $this->start_controls_section( 'section_visibility', array( 'label' => esc_html__( '0. Section Visibility', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();

        for ( $i = 1; $i <= 4; $i++ ) {
            $names = array( 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four' );
            $key = $names[$i];
            $this->start_controls_section( 'item_' . $key, array( 'label' => esc_html__( $i . '. Trust Item ' . $i, 'amaley-core' ) ) );
            $this->add_control( 'item_' . $key . '_icon', array( 'label' => esc_html__( 'Icon / Symbol', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => array( '⌂', '✦', '♧', '→' )[$i-1] ) );
            $this->add_control( 'item_' . $key . '_title', array( 'label' => esc_html__( 'Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => array( 'Geography-led', 'Traceable', 'Community-rooted', 'Product-linked' )[$i-1] ) );
            $this->add_control( 'item_' . $key . '_text', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => array( 'Browse by place and origin.', 'Connected to groups and makers.', 'Built through producer networks.', 'Open products from each cluster.' )[$i-1] ) );
            $this->end_controls_section();
        }

        $this->start_controls_section( 'layout', array( 'label' => esc_html__( '5. Layout / Alignment', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns', array( 'label' => esc_html__( 'Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-inner' => 'grid-template-columns: repeat({{VALUE}}, minmax(0,1fr));' ) ) );
        $this->add_responsive_control( 'gap', array( 'label' => esc_html__( 'Item Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-inner' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'item_align', array( 'label' => esc_html__( 'Item Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start'=>array('title'=>'Left','icon'=>'eicon-h-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>'Right','icon'=>'eicon-h-align-right') ), 'default' => 'flex-start', 'selectors' => array( '{{WRAPPER}} .amcas-trust-item' => 'justify-content: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1720 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style', array( 'label' => esc_html__( '6. Section Box / Background', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-trust' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'selector' => '{{WRAPPER}} .amcas-trust' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'section_shadow', 'selector' => '{{WRAPPER}} .amcas-trust' ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-trust' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_radius', array( 'label' => esc_html__( 'Section Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-trust' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'item_style', array( 'label' => esc_html__( '7. Item Box / Icon', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'item_bg', array( 'label' => esc_html__( 'Item Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-trust-item' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'item_border', 'selector' => '{{WRAPPER}} .amcas-trust-item' ) );
        $this->add_responsive_control( 'item_padding', array( 'label' => esc_html__( 'Item Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'item_radius', array( 'label' => esc_html__( 'Item Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'icon_size', array( 'label' => esc_html__( 'Icon Box Size', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 18, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-item > span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'icon_bg', array( 'label' => esc_html__( 'Icon Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-trust-item > span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-trust-item > span' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'icon_radius', array( 'label' => esc_html__( 'Icon Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-item > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'text_style', array( 'label' => esc_html__( '8. Typography / Text', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-trust-item strong' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typo', 'selector' => '{{WRAPPER}} .amcas-trust-item strong' ) );
        $this->add_control( 'text_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-trust-item small' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'text_typo', 'selector' => '{{WRAPPER}} .amcas-trust-item small' ) );
        $this->add_responsive_control( 'text_gap', array( 'label' => esc_html__( 'Title/Text Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>0, 'max'=>24 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-trust-item strong' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_archive_sections'] ) && $GLOBALS['amaley_core_cluster_archive_sections'] instanceof Amaley_Core_Cluster_Archive_Sections ? $GLOBALS['amaley_core_cluster_archive_sections'] : new Amaley_Core_Cluster_Archive_Sections();
        echo $renderer->render_trust_strip( $this->get_settings_for_display() );
    }
}
