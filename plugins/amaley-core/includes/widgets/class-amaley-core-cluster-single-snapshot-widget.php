<?php
/** Elementor widget: Amaley Cluster Snapshot. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_Snapshot_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_snapshot'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Snapshot', 'amaley-core' ); }
    public function get_icon() { return 'eicon-table'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'section' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();
        
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Snapshot Content', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster Snapshot' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Quick details' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'A compact view of geography, products, collectives and producers connected with this source cluster.' ) );
        $this->end_controls_section();
        $this->start_controls_section( 'visibility_section', array( 'label' => esc_html__( '3. Show / Hide Snapshot Items', 'amaley-core' ) ) );
        foreach ( array( 'show_code' => 'Show Cluster Code', 'show_region' => 'Show Region', 'show_district' => 'Show District', 'show_block' => 'Show Block / Area', 'show_villages' => 'Show Villages', 'show_products' => 'Show Main Products', 'show_shg_count' => 'Show SHG Count', 'show_producer_count' => 'Show Producer Count', 'show_product_count' => 'Show Product Count', 'show_gallery_count' => 'Show Gallery Count', 'show_contact' => 'Show Contact Summary' ) as $key => $label ) { $this->add_control( $key, array( 'label' => esc_html__( $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) ); }
        $this->end_controls_section();
        
        $this->add_common_layout_controls();
        $this->add_section_style_controls();
        $this->add_heading_style_controls();
        
        $this->add_card_style_controls();
        $this->add_meta_style_controls();
        
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_single_sections'] ) && $GLOBALS['amaley_core_cluster_single_sections'] instanceof Amaley_Core_Cluster_Single_Sections ? $GLOBALS['amaley_core_cluster_single_sections'] : new Amaley_Core_Cluster_Single_Sections();
        echo $renderer->render_snapshot( $this->get_settings_for_display() );
    }
}
