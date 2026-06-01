<?php
/** Elementor widget: Amaley Cluster Related Products. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_Products_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_products'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Related Products', 'amaley-core' ); }
    public function get_icon() { return 'eicon-products'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'section' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();
        
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Related Section Content', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Mapped Products' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Products mapped to this cluster' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'WooCommerce products carrying this cluster as their origin.' ) );
        $this->add_control( 'show_empty_state', array( 'label' => esc_html__( 'Show Empty State', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();
        $this->start_controls_section( 'query_section', array( 'label' => esc_html__( '3. Query / Layout', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 4 ) );
        $this->add_control( 'show_all_connected', array( 'label' => esc_html__( 'Show All Connected Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '0', 'description' => esc_html__( 'Turn on only when you intentionally want to show every linked item. Keep off for preview sections with a section button.', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->add_responsive_control( 'columns_tablet', array( 'label' => esc_html__( 'Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '2', 'options' => array( '1' => '1', '2' => '2', '3' => '3' ) ) );
        $this->add_responsive_control( 'columns_mobile', array( 'label' => esc_html__( 'Columns Mobile', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1', 'options' => array( '1' => '1', '2' => '2' ) ) );
        $this->add_control( 'show_section_button', array( 'label' => esc_html__( 'Show Section Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'section_button_text', array( 'label' => esc_html__( 'Section Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View all products' ) );
        $this->add_control( 'section_button_url', array( 'label' => esc_html__( 'Section Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->add_responsive_control( 'section_button_align', array( 'label' => esc_html__( 'Section Button Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => 'Left', 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => 'Right', 'icon' => 'eicon-h-align-right' ) ), 'default' => 'center', 'selectors' => array( '{{WRAPPER}} .amcss-section-action' => 'justify-content: {{VALUE}};' ) ) );
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
        echo $renderer->render_products( $this->get_settings_for_display() );
    }
}
