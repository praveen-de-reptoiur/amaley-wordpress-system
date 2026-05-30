<?php
/**
 * Elementor Cluster Cards Grid widget.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_Cluster_Cards_Widget extends \Elementor\Widget_Base {
    /**
     * Renderer.
     *
     * @var Amaley_Core_Cluster_Cards
     */
    private $renderer;

    public function __construct( $renderer = null, $data = array(), $args = null ) {
        parent::__construct( $data, $args );
        $this->renderer = $renderer;
    }

    public function get_name() { return 'amaley_core_cluster_cards'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Cards Grid', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-cards' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'cpt', 'cards', 'grid', 'shg' ); }

    protected function register_controls() {
        $this->start_controls_section( 'section_content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Section Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Himalayan Clusters' ) );
        $this->add_control( 'subtitle', array( 'label' => esc_html__( 'Section Subtitle', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Explore the local clusters that shape Amaley products, producer families and origin stories.' ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Cluster' ) );
        $this->add_control( 'button_url', array( 'label' => esc_html__( 'Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '#', 'description' => 'Use {id} or {slug} if you build custom detail URLs later.' ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'No Amaley clusters found yet.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_data', array( 'label' => esc_html__( 'Data Source', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Cards', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => 8 ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'show_only_website', array( 'label' => esc_html__( 'Only Show Website-Enabled Clusters', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'include_ids', array( 'label' => esc_html__( 'Include Cluster IDs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => '12,14,19' ) );
        $this->add_control( 'exclude_ids', array( 'label' => esc_html__( 'Exclude Cluster IDs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => '8,10' ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'menu_order', 'options' => array( 'menu_order' => 'Display Order', 'title' => 'Title', 'date' => 'Date', 'modified' => 'Modified', 'rand' => 'Random' ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'ASC', 'options' => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_visibility', array( 'label' => esc_html__( 'Field Visibility', 'amaley-core' ) ) );
        $fields = array(
            'show_image'       => 'Image',
            'show_badge'       => 'Badge',
            'show_region'      => 'Region / District / Area',
            'show_villages'    => 'Villages',
            'show_description' => 'Description',
            'show_products'    => 'Product Tags',
            'show_counts'      => 'SHG + Producer Counts',
            'show_button'      => 'Button',
        );
        foreach ( $fields as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html__( 'Show ' . $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Layout', 'amaley-core' ) ) );
        $this->add_control( 'layout_style', array( 'label' => esc_html__( 'Card Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => array( 'grid' => 'Grid Cards', 'editorial' => 'Editorial Wide' ), 'description' => esc_html__( 'Editorial Wide creates an image-left, content-middle, details-right card variation.', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns', array( 'label' => esc_html__( 'Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->add_control( 'image_ratio', array( 'label' => esc_html__( 'Image Ratio', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '16-9', 'options' => array( '1-1' => 'Square', '4-3' => '4:3', '16-9' => '16:9' ) ) );
        $this->add_control( 'equal_height', array( 'label' => esc_html__( 'Equal Height Cards', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_wrapper', array( 'label' => esc_html__( 'Section / Wrapper', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-clusters' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-clusters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-clusters-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_card', array( 'label' => esc_html__( 'Card', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-card' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'card_radius', array( 'label' => esc_html__( 'Border Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'card_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-card' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_text', array( 'label' => esc_html__( 'Typography / Text', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-core-cluster-title' ) );
        $this->add_control( 'meta_color', array( 'label' => esc_html__( 'Meta Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-meta, {{WRAPPER}} .amaley-core-cluster-villages' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_typography', 'selector' => '{{WRAPPER}} .amaley-core-cluster-meta, {{WRAPPER}} .amaley-core-cluster-villages' ) );
        $this->add_control( 'desc_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'desc_typography', 'selector' => '{{WRAPPER}} .amaley-core-cluster-desc' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_tags_button', array( 'label' => esc_html__( 'Tags / Stats / Button', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'tag_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-products span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'tag_color', array( 'label' => esc_html__( 'Tag Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-products span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-btn' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-btn' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-cluster-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        if ( ! $this->renderer instanceof Amaley_Core_Cluster_Cards ) {
            $this->renderer = new Amaley_Core_Cluster_Cards();
        }
        $settings = $this->get_settings_for_display();
        $settings['columns_desktop'] = isset( $settings['columns'] ) ? $settings['columns'] : '4';
        $settings['columns_tablet']  = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : '2';
        $settings['columns_mobile']  = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : '1';
        echo $this->renderer->render( $settings );
    }
}
