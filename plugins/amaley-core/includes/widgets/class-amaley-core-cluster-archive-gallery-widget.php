<?php
/** Elementor widget: Amaley Cluster Archive Gallery. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Archive_Gallery_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_cluster_archive_gallery'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Archive Gallery', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'archive', 'gallery', 'photos' ); }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_archive_sections'] ) ? $GLOBALS['amaley_core_cluster_archive_sections'] : new Amaley_Core_Cluster_Archive_Sections();
        $d = $renderer->gallery_defaults();
        $this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_label', array( 'label' => esc_html__( 'Show Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_label'] ) );
        $this->add_control( 'show_title', array( 'label' => esc_html__( 'Show Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_title'] ) );
        $this->add_control( 'show_description', array( 'label' => esc_html__( 'Show Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_description'] ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['label'] ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['title'] ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $d['description'] ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['empty_message'] ) );
        $this->end_controls_section();
        $this->start_controls_section( 'query', array( 'label' => esc_html__( 'Data Source / Query', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Image Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 40, 'default' => $d['limit'] ) );
        $this->add_control( 'show_only_website', array( 'label' => esc_html__( 'Show Only Website-visible', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_only_website'] ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['featured_only'] ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $d['order_by'], 'options' => array( 'menu_order' => 'Menu Order', 'title' => 'Title', 'date' => 'Date', 'modified' => 'Modified', 'rand' => 'Random' ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $d['order'], 'options' => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ) ) );
        $this->end_controls_section();
        $this->start_controls_section( 'layout', array( 'label' => esc_html__( 'Gallery Layout', 'amaley-core' ) ) );
        $this->add_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 6, 'default' => $d['columns_desktop'] ) );
        $this->add_control( 'columns_tablet', array( 'label' => esc_html__( 'Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'default' => $d['columns_tablet'] ) );
        $this->add_control( 'columns_mobile', array( 'label' => esc_html__( 'Columns Mobile', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 2, 'default' => $d['columns_mobile'] ) );
        $this->add_control( 'show_caption', array( 'label' => esc_html__( 'Show Caption', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_caption'] ) );
        $this->end_controls_section();
        $this->start_controls_section( 'style_spacing', array( 'label' => esc_html__( 'Spacing / Layout', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-gallery-sec' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'gallery_gap', array( 'label' => esc_html__( 'Gallery Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 140, 'max' => 520 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-gallery-card' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_archive_sections'] ) ? $GLOBALS['amaley_core_cluster_archive_sections'] : new Amaley_Core_Cluster_Archive_Sections();
        echo $renderer->render_gallery( $this->get_settings_for_display() );
    }
}
