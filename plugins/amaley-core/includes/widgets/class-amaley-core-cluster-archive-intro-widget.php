<?php
/** Amaley Cluster Archive Intro / Why Section Elementor widget. v1.0.32 full control rebuild. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Archive_Intro_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_cluster_archive_intro'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Archive Intro / Why Section', 'amaley-core' ); }
    public function get_icon() { return 'eicon-post-content'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-archive-sections' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => esc_html__( '1. Intro Content', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Why clusters matter' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Every Amaley product begins somewhere.', 'rows' => 2 ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'A cluster is not just a location. It connects ingredients, villages, women collectives, producer skills and product stories into one clear origin system.', 'rows' => 4 ) );
        $this->end_controls_section();

        for ( $i = 1; $i <= 3; $i++ ) {
            $keys = array( 1 => 'one', 2 => 'two', 3 => 'three' );
            $titles = array( 'Place', 'People', 'Product' );
            $texts = array( 'Region, village and local ingredient base.', 'SHGs, producers and skilled hands behind the work.', 'Mapped products that carry the origin forward.' );
            $key = $keys[$i];
            $this->start_controls_section( 'card_' . $key, array( 'label' => esc_html__( ( $i + 1 ) . '. Info Card ' . $i, 'amaley-core' ) ) );
            $this->add_control( 'card_' . $key . '_title', array( 'label' => esc_html__( 'Card Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $titles[$i-1] ) );
            $this->add_control( 'card_' . $key . '_text', array( 'label' => esc_html__( 'Card Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $texts[$i-1] ) );
            $this->end_controls_section();
        }

        $this->start_controls_section( 'layout', array( 'label' => esc_html__( '5. Layout / Alignment', 'amaley-core' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1720 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'column_gap', array( 'label' => esc_html__( 'Column Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>0, 'max'=>120 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-intro-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_columns', array( 'label' => esc_html__( 'Card Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '3', 'mobile_default' => '1', 'options' => array( '1'=>'1','2'=>'2','3'=>'3' ), 'selectors' => array( '{{WRAPPER}} .amcas-intro-cards' => 'grid-template-columns: repeat({{VALUE}}, minmax(0,1fr));' ) ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>0, 'max'=>80 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-intro-cards' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'text_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right') ), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .amcas-intro-copy, {{WRAPPER}} .amcas-info-card' => 'text-align: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style', array( 'label' => esc_html__( '6. Section Box / Background', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-intro' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'selector' => '{{WRAPPER}} .amcas-intro' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'section_shadow', 'selector' => '{{WRAPPER}} .amcas-intro' ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-intro' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_radius', array( 'label' => esc_html__( 'Section Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-intro' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'heading_style', array( 'label' => esc_html__( '7. Heading / Text Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        foreach ( array( 'label'=>'Small Label', 'title'=>'Heading', 'description'=>'Description' ) as $key => $label ) {
            $selector = 'label' === $key ? '{{WRAPPER}} .amcas-intro .amcas-label' : ( 'title' === $key ? '{{WRAPPER}} .amcas-intro h2' : '{{WRAPPER}} .amcas-intro-copy p:not(.amcas-label)' );
            $this->add_control( $key . '_color', array( 'label' => esc_html__( $label . ' Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'color: {{VALUE}};' ) ) );
            $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $key . '_typography', 'label' => esc_html__( $label . ' Typography', 'amaley-core' ), 'selector' => $selector ) );
            $this->add_responsive_control( $key . '_margin', array( 'label' => esc_html__( $label . ' Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'card_style', array( 'label' => esc_html__( '8. Info Card Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-info-card' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .amcas-info-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amcas-info-card' ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-info-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_margin', array( 'label' => esc_html__( 'Card Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-info-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-info-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_min_height', array( 'label' => esc_html__( 'Card Minimum Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>0, 'max'=>420 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-info-card' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-info-card strong' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'label' => esc_html__( 'Card Title Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-info-card strong' ) );
        $this->add_responsive_control( 'card_title_margin', array( 'label' => esc_html__( 'Card Title Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amcas-info-card strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'card_text_color', array( 'label' => esc_html__( 'Card Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-info-card span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_text_typography', 'label' => esc_html__( 'Card Text Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-info-card span' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_archive_sections'] ) && $GLOBALS['amaley_core_cluster_archive_sections'] instanceof Amaley_Core_Cluster_Archive_Sections ? $GLOBALS['amaley_core_cluster_archive_sections'] : new Amaley_Core_Cluster_Archive_Sections();
        echo $renderer->render_intro( $this->get_settings_for_display() );
    }
}
