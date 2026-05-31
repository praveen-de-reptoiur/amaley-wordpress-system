<?php
/** Elementor widget: Amaley Cluster Single Hero. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_Hero_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_hero'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Single Hero', 'amaley-core' ); }
    public function get_icon() { return 'eicon-banner'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'section' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();
        
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Hero Content / Visibility', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Source Cluster' ) );
        $this->add_control( 'show_breadcrumbs', array( 'label' => esc_html__( 'Show Breadcrumbs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_image', array( 'label' => esc_html__( 'Show Image / Visual', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_meta', array( 'label' => esc_html__( 'Show Meta Chips', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_buttons', array( 'label' => esc_html__( 'Show Buttons', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();
        $this->start_controls_section( 'breadcrumb_section', array( 'label' => esc_html__( '3. Breadcrumbs / Links', 'amaley-core' ) ) );
        $this->add_control( 'home_label', array( 'label' => esc_html__( 'Home Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Home' ) );
        $this->add_control( 'home_url', array( 'label' => esc_html__( 'Home URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/' ) );
        $this->add_control( 'middle_label', array( 'label' => esc_html__( 'Middle Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Clusters' ) );
        $this->add_control( 'middle_url', array( 'label' => esc_html__( 'Middle URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/clusters/' ) );
        $this->end_controls_section();
        $this->start_controls_section( 'button_content_section', array( 'label' => esc_html__( '4. Buttons', 'amaley-core' ) ) );
        $this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Products' ) );
        $this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Back to Clusters' ) );
        $this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/clusters/' ) );
        $this->end_controls_section();
        
        $this->add_common_layout_controls();
        $this->add_section_style_controls();
        $this->add_heading_style_controls();
        
        $this->add_image_style_controls();
        $this->add_chip_style_controls();
        $this->add_button_style_controls();
        
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_single_sections'] ) && $GLOBALS['amaley_core_cluster_single_sections'] instanceof Amaley_Core_Cluster_Single_Sections ? $GLOBALS['amaley_core_cluster_single_sections'] : new Amaley_Core_Cluster_Single_Sections();
        echo $renderer->render_hero( $this->get_settings_for_display() );
    }
}
