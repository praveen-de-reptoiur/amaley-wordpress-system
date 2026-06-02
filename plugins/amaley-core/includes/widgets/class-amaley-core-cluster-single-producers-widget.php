<?php
/** Elementor widget: Amaley Cluster Related Producers. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Cluster_Single_Producers_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_Cluster_Single_Widget_Controls;

    public function get_name() { return 'amaley_cluster_single_producers'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Related Producers', 'amaley-core' ); }
    public function get_icon() { return 'eicon-person'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'single', 'section' ); }

    protected function register_controls() {
        $this->add_cluster_source_controls();
        
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( '2. Related Section Content', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Producer Profiles' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'People behind the cluster' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Members and producers connected through linked SHGs.' ) );
        $this->add_control( 'show_empty_state', array( 'label' => esc_html__( 'Show Empty State', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'card_template', array(
            'label' => esc_html__( 'Card Template', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'og_card_1',
            'options' => array(
                'og_card_1' => esc_html__( 'OG Card 1', 'amaley-core' ),
                'current_existing' => esc_html__( 'Current / Existing Card', 'amaley-core' ),
            ),
            'description' => esc_html__( 'Keep OG Card 1 for the approved universal card. Current / Existing Card is a safe fallback.', 'amaley-core' ),
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'card_elements_section', array( 'label' => esc_html__( 'Card Elements / Show-Hide', 'amaley-core' ) ) );
        $this->add_control( 'show_card_media', array( 'label' => esc_html__( 'Show Image / Placeholder', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'amaley-core' ), 'label_off' => esc_html__( 'Hide', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_card_label', array( 'label' => esc_html__( 'Show Card Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'amaley-core' ), 'label_off' => esc_html__( 'Hide', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_card_title', array( 'label' => esc_html__( 'Show Card Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'amaley-core' ), 'label_off' => esc_html__( 'Hide', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_card_description', array( 'label' => esc_html__( 'Show Card Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'amaley-core' ), 'label_off' => esc_html__( 'Hide', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_card_meta', array( 'label' => esc_html__( 'Show Meta / Stat Boxes', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'amaley-core' ), 'label_off' => esc_html__( 'Hide', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_card_tags', array( 'label' => esc_html__( 'Show Tags / Chips', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'amaley-core' ), 'label_off' => esc_html__( 'Hide', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_card_button', array( 'label' => esc_html__( 'Show Card Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'amaley-core' ), 'label_off' => esc_html__( 'Hide', 'amaley-core' ), 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();
        $this->start_controls_section( 'query_section', array( 'label' => esc_html__( '3. Query / Layout', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 4 ) );
        $this->add_control( 'show_all_connected', array( 'label' => esc_html__( 'Show All Connected Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '0', 'description' => esc_html__( 'Turn on only when you intentionally want to show every linked item. Keep off for preview sections with a section button.', 'amaley-core' ) ) );
        $this->add_control( 'enable_pagination', array( 'label' => esc_html__( 'Enable Pagination', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'amaley-core' ), 'label_off' => esc_html__( 'No', 'amaley-core' ), 'return_value' => '1', 'default' => '1', 'description' => esc_html__( 'Shows page numbers when total linked items are more than the Number of Items value.', 'amaley-core' ) ) );
        $this->add_control( 'pagination_prev_text', array( 'label' => esc_html__( 'Previous Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Previous', 'condition' => array( 'enable_pagination' => '1' ) ) );
        $this->add_control( 'pagination_next_text', array( 'label' => esc_html__( 'Next Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Next', 'condition' => array( 'enable_pagination' => '1' ) ) );
        $this->add_responsive_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->add_responsive_control( 'columns_tablet', array( 'label' => esc_html__( 'Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '2', 'options' => array( '1' => '1', '2' => '2', '3' => '3' ) ) );
        $this->add_responsive_control( 'columns_mobile', array( 'label' => esc_html__( 'Columns Mobile', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1', 'options' => array( '1' => '1', '2' => '2' ) ) );
        $this->add_control( 'show_section_button', array( 'label' => esc_html__( 'Show Section Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'section_button_text', array( 'label' => esc_html__( 'Section Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View all producers' ) );
        $this->add_control( 'section_button_url', array( 'label' => esc_html__( 'Section Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/members-producers/' ) );
        $this->add_responsive_control( 'section_button_align', array( 'label' => esc_html__( 'Section Button Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => 'Left', 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => 'Right', 'icon' => 'eicon-h-align-right' ) ), 'default' => 'center', 'selectors' => array( '{{WRAPPER}} .amcss-section-action' => 'justify-content: {{VALUE}};' ) ) );
        $this->end_controls_section();
        
        $this->add_common_layout_controls();
        $this->add_section_style_controls();
        $this->add_heading_style_controls();
        
        $this->add_card_style_controls();
        $this->add_card_transform_controls();
        $this->add_image_style_controls();
        $this->add_chip_style_controls();
        $this->add_meta_style_controls();
        $this->add_button_style_controls();
        $this->add_pagination_style_controls();
        
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_single_sections'] ) && $GLOBALS['amaley_core_cluster_single_sections'] instanceof Amaley_Core_Cluster_Single_Sections ? $GLOBALS['amaley_core_cluster_single_sections'] : new Amaley_Core_Cluster_Single_Sections();
        echo $renderer->render_producers( $this->get_settings_for_display() );
    }
}
