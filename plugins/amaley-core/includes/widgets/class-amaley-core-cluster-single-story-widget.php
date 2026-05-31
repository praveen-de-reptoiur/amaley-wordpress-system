<?php
/** Elementor widget: Amaley Cluster Story. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_Story_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_story'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Story', 'amaley-core' ); }
    public function get_icon() { return 'eicon-text'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'section' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();
        
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Story Content / Visibility', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster Story' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The story behind this cluster' ) );
        $this->add_control( 'story_source_note', array(
            'label' => esc_html__( 'Story Source', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'This widget uses the Cluster Full Story field from Amaley Core → Clusters. Edit the cluster Full Story field to add paragraphs, bold, italic, links and lists.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );
        $this->add_control( 'show_products', array( 'label' => esc_html__( 'Show Product Chips', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_villages', array( 'label' => esc_html__( 'Show Village List', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();
        
        $this->add_common_layout_controls();
        $this->add_section_style_controls();
        $this->add_heading_style_controls();
        
        $this->add_card_style_controls();
        $this->add_chip_style_controls();
        $this->add_meta_style_controls();
        
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_single_sections'] ) && $GLOBALS['amaley_core_cluster_single_sections'] instanceof Amaley_Core_Cluster_Single_Sections ? $GLOBALS['amaley_core_cluster_single_sections'] : new Amaley_Core_Cluster_Single_Sections();
        echo $renderer->render_story( $this->get_settings_for_display() );
    }
}
