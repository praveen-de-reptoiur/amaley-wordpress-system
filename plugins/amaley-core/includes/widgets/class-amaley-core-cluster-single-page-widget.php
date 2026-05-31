<?php
/** Elementor OG-aligned Cluster Single Page widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Single_Page_Widget extends \Elementor\Widget_Base {
    private $renderer;
    public function __construct( $renderer = null, $data = array(), $args = null ) { parent::__construct( $data, $args ); $this->renderer = $renderer; }
    public function get_name() { return 'amaley_core_cluster_single_page'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Single Page', 'amaley-core' ); }
    public function get_icon() { return 'eicon-single-page'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-pages' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'detail', 'origin' ); }

    protected function register_controls() {
        $this->start_controls_section( 'section_source', array( 'label' => esc_html__( 'Cluster Source', 'amaley-core' ) ) );
        $this->add_control( 'cluster_id', array( 'label' => esc_html__( 'Cluster ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'description' => 'Use when placing this widget on a normal Elementor page.' ) );
        $this->add_control( 'cluster_slug', array( 'label' => esc_html__( 'Cluster Slug', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'description' => 'Alternative to Cluster ID.' ) );
        $this->add_control( 'auto_detect', array( 'label' => esc_html__( 'Auto-detect from URL/current post', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'description' => 'Supports ?cluster_id=123 or ?cluster_slug=ladakh-apricot-cluster.' ) );
        $this->add_control( 'kicker', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Source Cluster' ) );
        $this->add_control( 'breadcrumb_home_url', array( 'label' => esc_html__( 'Breadcrumb Home URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/' ) );
        $this->add_control( 'breadcrumb_middle_url', array( 'label' => esc_html__( 'Breadcrumb Clusters URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/cluster/' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_visibility', array( 'label' => esc_html__( 'Sections', 'amaley-core' ) ) );
        foreach ( array( 'show_hero' => 'Hero', 'show_trust_strip' => 'Trust Strip', 'show_snapshot' => 'Snapshot', 'show_story' => 'Story', 'show_villages' => 'Villages', 'show_shgs' => 'Linked SHGs', 'show_members' => 'Linked Producers', 'show_products' => 'Linked Products', 'show_journey' => 'Origin Journey', 'show_gallery' => 'Gallery', 'show_cta' => 'CTA' ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html__( 'Show ' . $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'section_limits', array( 'label' => esc_html__( 'Related Limits', 'amaley-core' ) ) );
        $this->add_control( 'shg_limit', array( 'label' => esc_html__( 'SHG Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 6 ) );
        $this->add_control( 'member_limit', array( 'label' => esc_html__( 'Producer Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 6 ) );
        $this->add_control( 'product_limit', array( 'label' => esc_html__( 'Product Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 6 ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_cta', array( 'label' => esc_html__( 'CTA', 'amaley-core' ) ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Related Products' ) );
        $this->add_control( 'button_url', array( 'label' => esc_html__( 'Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'This cluster detail page will appear once verified Amaley data is available.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style', array( 'label' => esc_html__( 'Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'hero_bg', array( 'label' => esc_html__( 'Hero Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acp-shop-hero' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'hero_title_color', array( 'label' => esc_html__( 'Hero Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acp-sh-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_typography', 'selector' => '{{WRAPPER}} .acp-sh-title' ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Panel Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acp-cluster-detail-head, {{WRAPPER}} .acp-cluster-detail-side, {{WRAPPER}} .acp-entity-card, {{WRAPPER}} .acp-cluster-inline-detail' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        if ( ! $this->renderer instanceof Amaley_Core_Cluster_Pages ) { $this->renderer = new Amaley_Core_Cluster_Pages(); }
        echo $this->renderer->render_single( $this->get_settings_for_display() );
    }
}
