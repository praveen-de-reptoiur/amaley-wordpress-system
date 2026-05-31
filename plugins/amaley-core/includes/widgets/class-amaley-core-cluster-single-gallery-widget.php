<?php
/** Elementor widget: Amaley Cluster Gallery. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_Gallery_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_gallery'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Gallery', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'gallery', 'images' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();

        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Gallery Content / Visibility', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster Gallery' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Images from this cluster' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Visual references from the cluster, producers, ingredients or source geography.' ) );
        $this->add_control( 'show_empty_state', array( 'label' => esc_html__( 'Show Empty State', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'layout_grid_section', array( 'label' => esc_html__( '3. Gallery Layout', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '3', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->add_responsive_control( 'columns_tablet', array( 'label' => esc_html__( 'Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '2', 'options' => array( '1' => '1', '2' => '2', '3' => '3' ) ) );
        $this->add_responsive_control( 'columns_mobile', array( 'label' => esc_html__( 'Columns Mobile', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1', 'options' => array( '1' => '1', '2' => '2' ) ) );
        $this->end_controls_section();

        $this->add_common_layout_controls();
        $this->add_section_style_controls();
        $this->add_heading_style_controls();
        $this->add_gallery_style_controls();
        $this->add_card_style_controls();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_single_sections'] ) && $GLOBALS['amaley_core_cluster_single_sections'] instanceof Amaley_Core_Cluster_Single_Sections ? $GLOBALS['amaley_core_cluster_single_sections'] : new Amaley_Core_Cluster_Single_Sections();
        echo $renderer->render_gallery( $this->get_settings_for_display() );
    }
}
