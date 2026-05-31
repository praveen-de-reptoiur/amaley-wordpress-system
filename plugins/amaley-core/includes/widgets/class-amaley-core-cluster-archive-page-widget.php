<?php
/** Elementor OG-aligned Cluster Archive Page widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Archive_Page_Widget extends \Elementor\Widget_Base {
    private $renderer;
    public function __construct( $renderer = null, $data = array(), $args = null ) { parent::__construct( $data, $args ); $this->renderer = $renderer; }
    public function get_name() { return 'amaley_core_cluster_archive_page'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Archive Page', 'amaley-core' ); }
    public function get_icon() { return 'eicon-archive'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-pages' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'archive', 'origin', 'og' ); }

    protected function register_controls() {
        $this->start_controls_section( 'section_content', array( 'label' => esc_html__( 'Hero Content', 'amaley-core' ) ) );
        $this->add_control( 'kicker', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Traceable by place, group, and maker' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Clusters that hold the Amaley story together.' ) );
        $this->add_control( 'title_accent', array( 'label' => esc_html__( 'Rust Accent Word', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley' ) );
        $this->add_control( 'subtitle', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'This is where Amaley becomes visible as an ecosystem. Each cluster connects geography, women collectives, producers, products, and the local strengths that make traceability meaningful — not decorative.' ) );
        $this->add_control( 'breadcrumb_home_url', array( 'label' => esc_html__( 'Breadcrumb Home URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/' ) );
        $this->add_control( 'breadcrumb_middle_url', array( 'label' => esc_html__( 'Breadcrumb Middle URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->add_control( 'detail_url_pattern', array( 'label' => esc_html__( 'Detail URL Pattern', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/amaley-cluster/?cluster_id={id}', 'description' => 'Use {id} and {slug}.' ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Card Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Cluster Story' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_query', array( 'label' => esc_html__( 'Query', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Clusters', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 48, 'default' => 12 ) );
        $this->add_control( 'show_only_website', array( 'label' => esc_html__( 'Only Website-Enabled', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_visibility', array( 'label' => esc_html__( 'Page Sections', 'amaley-core' ) ) );
        foreach ( array( 'show_hero' => 'Hero', 'show_trust_strip' => 'Trust Strip', 'show_intro' => 'Why Clusters Matter', 'show_traceability' => 'Traceability Flow', 'show_featured_cluster' => 'Featured Cluster', 'show_cards' => 'Cluster Grid', 'show_cta' => 'Buyer CTA' ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html__( 'Show ' . $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'section_body_copy', array( 'label' => esc_html__( 'Section Copy', 'amaley-core' ) ) );
        $this->add_control( 'intro_title', array( 'label' => esc_html__( 'Intro Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley is not just a shelf of products.' ) );
        $this->add_control( 'intro_text', array( 'label' => esc_html__( 'Intro Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 5, 'default' => 'Products do not emerge in isolation. They come from local ingredients, women collectives, household skills, seasonal rhythms, and geographies that shape what can be made well. This page makes that structure visible.' ) );
        $this->add_control( 'archive_title', array( 'label' => esc_html__( 'Archive Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Browse clusters by state and geography' ) );
        $this->add_control( 'archive_text', array( 'label' => esc_html__( 'Archive Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Open a cluster to see its detailed page, linked SHGs, members, traceable products, and direct pathways into product purchase and deeper origin viewing.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_cta', array( 'label' => esc_html__( 'Buyer CTA', 'amaley-core' ) ) );
        $this->add_control( 'cta_title', array( 'label' => esc_html__( 'CTA Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster visibility helps customers and partners buy better.' ) );
        $this->add_control( 'cta_text', array( 'label' => esc_html__( 'CTA Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Use cluster visibility to build story-rich product sets, hospitality counters, curated shelves, and origin-led retail experiences.' ) );
        $this->add_control( 'cta_button_text', array( 'label' => esc_html__( 'CTA Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Amaley Products' ) );
        $this->add_control( 'cta_button_url', array( 'label' => esc_html__( 'CTA Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Layout', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns', array( 'label' => esc_html__( 'Cluster Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style', array( 'label' => esc_html__( 'Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'hero_bg', array( 'label' => esc_html__( 'Hero Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acp-shop-hero' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'hero_title_color', array( 'label' => esc_html__( 'Hero Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acp-sh-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_typography', 'selector' => '{{WRAPPER}} .acp-sh-title' ) );
        $this->add_control( 'page_bg', array( 'label' => esc_html__( 'Page Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-system' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .acp-page-sec' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        if ( ! $this->renderer instanceof Amaley_Core_Cluster_Pages ) { $this->renderer = new Amaley_Core_Cluster_Pages(); }
        $settings = $this->get_settings_for_display();
        $settings['columns_desktop'] = isset( $settings['columns'] ) ? $settings['columns'] : '3';
        $settings['columns_tablet']  = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : '2';
        $settings['columns_mobile']  = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : '1';
        echo $this->renderer->render_archive( $settings );
    }
}
