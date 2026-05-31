<?php
/** Elementor widget: Amaley Cluster Contact / Source Support. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_Contact_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_contact'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Contact / Source Support', 'amaley-core' ); }
    public function get_icon() { return 'eicon-info-box'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'contact', 'source' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();

        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Contact Content / Visibility', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Source Support' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Need details about this cluster?' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Contact Amaley for sourcing, partnership, retail shelves, institutional gifting or product storytelling connected to this cluster.' ) );
        $this->add_control( 'show_location', array( 'label' => esc_html__( 'Show Location', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_contact_person', array( 'label' => esc_html__( 'Show Contact Person', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_phone', array( 'label' => esc_html__( 'Show Phone / WhatsApp', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'show_buttons', array( 'label' => esc_html__( 'Show Buttons', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'button_content_section', array( 'label' => esc_html__( '3. Buttons / Links', 'amaley-core' ) ) );
        $this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Contact Amaley' ) );
        $this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/contact/' ) );
        $this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Products' ) );
        $this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->end_controls_section();

        $this->add_common_layout_controls();
        $this->add_section_style_controls();
        $this->add_heading_style_controls();
        $this->add_card_style_controls();
        $this->add_meta_style_controls();
        $this->add_button_style_controls();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_single_sections'] ) && $GLOBALS['amaley_core_cluster_single_sections'] instanceof Amaley_Core_Cluster_Single_Sections ? $GLOBALS['amaley_core_cluster_single_sections'] : new Amaley_Core_Cluster_Single_Sections();
        echo $renderer->render_contact( $this->get_settings_for_display() );
    }
}
