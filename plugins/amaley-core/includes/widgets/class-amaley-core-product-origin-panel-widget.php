<?php
/**
 * Elementor Product Origin Panel widget.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_Product_Origin_Panel_Widget extends \Elementor\Widget_Base {
    /** @var Amaley_Core_Product_Origin_Panel */
    private $renderer;

    public function __construct( $renderer = null, $data = array(), $args = null ) {
        parent::__construct( $data, $args );
        $this->renderer = $renderer;
    }

    public function get_name() { return 'amaley_core_product_origin_panel'; }
    public function get_title() { return esc_html__( 'Amaley Product Origin Panel', 'amaley-core' ); }
    public function get_icon() { return 'eicon-product-info'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-product-origin-panel' ); }
    public function get_keywords() { return array( 'amaley', 'product', 'origin', 'traceability', 'cluster', 'shg', 'producer' ); }

    protected function register_controls() {
        $this->start_controls_section( 'section_content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Panel Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Product Origin' ) );
        $this->add_control( 'subtitle', array( 'label' => esc_html__( 'Subtitle', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'A quick view of where this product comes from and the community value chain connected with it.' ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Origin Story' ) );
        $this->add_control( 'button_url', array( 'label' => esc_html__( 'Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '#', 'description' => 'Use {product_id}, {product_slug}, or {cluster_id} for dynamic links.' ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Origin details are being updated for this product.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_data', array( 'label' => esc_html__( 'Data Source', 'amaley-core' ) ) );
        $this->add_control( 'auto_detect', array( 'label' => esc_html__( 'Auto-detect Current Product', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'product_id', array( 'label' => esc_html__( 'Manual Product ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'Optional product ID' ) );
        $this->add_control( 'product_sku', array( 'label' => esc_html__( 'Manual Product SKU', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'Optional WooCommerce SKU' ) );
        $this->add_control( 'product_name', array( 'label' => esc_html__( 'Manual Product Name', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'Example: Amaley Ladakh Apricot Jam', 'description' => esc_html__( 'Use this when SKU/ID is not handy. Must match the WooCommerce product title.', 'amaley-core' ) ) );
        $this->add_control( 'product_slug', array( 'label' => esc_html__( 'Manual Product Slug', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'Optional product slug' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_visibility', array( 'label' => esc_html__( 'Field Visibility', 'amaley-core' ) ) );
        foreach ( array(
            'show_header' => 'Show Header', 'show_product_name' => 'Show Product Name', 'show_cluster' => 'Show Cluster', 'show_shgs' => 'Show SHG Groups', 'show_producers' => 'Show Producers', 'show_source_village' => 'Show Source Village', 'show_origin_note' => 'Show Origin Note', 'show_traceability_note' => 'Show Traceability Note', 'show_button' => 'Show Button', 'show_empty' => 'Show Empty State'
        ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html__( $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Layout', 'amaley-core' ) ) );
        $this->add_control( 'layout_style', array( 'label' => esc_html__( 'Layout Style', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'panel', 'options' => array( 'panel' => 'Panel', 'compact' => 'Compact', 'editorial' => 'Editorial' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_wrapper', array( 'label' => esc_html__( 'Section / Wrapper', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_card', array( 'label' => esc_html__( 'Panel Card', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-card' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'card_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-card' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'card_radius', array( 'label' => esc_html__( 'Border Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_text', array( 'label' => esc_html__( 'Typography / Text', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-head h2, {{WRAPPER}} .amaley-core-origin-panel-product strong' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .amaley-core-origin-panel-head h2, {{WRAPPER}} .amaley-core-origin-panel-product strong' ) );
        $this->add_control( 'body_color', array( 'label' => esc_html__( 'Body Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-note, {{WRAPPER}} .amaley-core-origin-panel-trace-note, {{WRAPPER}} .amaley-core-origin-panel-head p' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'body_typography', 'selector' => '{{WRAPPER}} .amaley-core-origin-panel-note, {{WRAPPER}} .amaley-core-origin-panel-trace-note, {{WRAPPER}} .amaley-core-origin-panel-head p' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_details_button', array( 'label' => esc_html__( 'Details / Button', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'detail_bg', array( 'label' => esc_html__( 'Detail Row Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-row' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-btn' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-btn' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-origin-panel-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        if ( ! $this->renderer instanceof Amaley_Core_Product_Origin_Panel ) {
            $this->renderer = new Amaley_Core_Product_Origin_Panel();
        }
        echo $this->renderer->render( $this->get_settings_for_display() );
    }
}
