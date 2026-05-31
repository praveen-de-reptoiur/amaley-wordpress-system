<?php
/** Elementor widget: Amaley Cluster Related SHGs. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_SHGs_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_shgs'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Related SHGs', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'section' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();
        
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Related Section Content', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Women Collectives' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'SHGs connected with this cluster' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Groups directly linked with this source cluster.' ) );
        $this->add_control( 'show_empty_state', array( 'label' => esc_html__( 'Show Empty State', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();
        $this->start_controls_section( 'query_section', array( 'label' => esc_html__( '3. Query / Layout', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 6 ) );
        $this->add_control( 'show_all_connected', array( 'label' => esc_html__( 'Show All Connected Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'description' => esc_html__( 'Keeps archive/single pages from accidentally showing only one linked record. Turn off only if you want to manually limit items.', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->add_responsive_control( 'columns_tablet', array( 'label' => esc_html__( 'Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '2', 'options' => array( '1' => '1', '2' => '2', '3' => '3' ) ) );
        $this->add_responsive_control( 'columns_mobile', array( 'label' => esc_html__( 'Columns Mobile', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1', 'options' => array( '1' => '1', '2' => '2' ) ) );
        $this->end_controls_section();
        
        $this->add_common_layout_controls();
        $this->add_section_style_controls();
        $this->add_heading_style_controls();
        
        $this->add_card_style_controls();
        $this->add_image_style_controls();
        $this->add_chip_style_controls();
        $this->add_meta_style_controls();
        $this->add_button_style_controls();
        
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_single_sections'] ) && $GLOBALS['amaley_core_cluster_single_sections'] instanceof Amaley_Core_Cluster_Single_Sections ? $GLOBALS['amaley_core_cluster_single_sections'] : new Amaley_Core_Cluster_Single_Sections();
        echo $renderer->render_shgs( $this->get_settings_for_display() );
    }
}
