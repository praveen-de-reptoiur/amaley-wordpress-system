<?php
/**
 * Amaley Universal Showcase Elementor widget.
 *
 * Important editor rule: only the selected content/card type exposes its matching card controls.
 * Cluster controls are visible only for Cluster, SHG controls only for SHG, Member controls only
 * for Member, and Product controls only for Product.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_Universal_Showcase_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_universal_showcase'; }
    public function get_title() { return esc_html__( 'Amaley Universal Showcase', 'amaley-core' ); }
    public function get_icon() { return 'eicon-slider-push'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'universal', 'showcase', 'slider', 'grid', 'cluster', 'shg', 'member', 'product' ); }
    public function get_style_depends() { return array( 'amaley-core-cards', 'amaley-core-universal-showcase' ); }
    public function get_script_depends() { return array( 'amaley-core-universal-showcase' ); }

    protected function register_controls() {
        $this->section_source_controls();
        $this->section_heading_controls();
        $this->section_layout_controls();
        $this->section_common_card_controls();
        $this->section_cluster_card_controls();
        $this->section_shg_card_controls();
        $this->section_member_card_controls();
        $this->section_product_card_controls();
        $this->section_slider_controls();
        $this->style_section_controls();
        $this->style_heading_controls();
        $this->style_card_bridge_controls();
        $this->style_navigation_controls();
    }

    private function section_source_controls() {
        $this->start_controls_section( 'source_section', array( 'label' => esc_html__( '1. Showcase Source', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'content_type', array(
            'label' => esc_html__( 'What to Show', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'cluster',
            'options' => array(
                'cluster' => esc_html__( 'Cluster', 'amaley-core' ),
                'shg' => esc_html__( 'SHG / Producer Group', 'amaley-core' ),
                'member' => esc_html__( 'Member / Producer', 'amaley-core' ),
                'product' => esc_html__( 'Product', 'amaley-core' ),
            ),
            'description' => esc_html__( 'Only the selected card type controls will appear below.', 'amaley-core' ),
        ) );
        $this->add_control( 'source_mode', array(
            'label' => esc_html__( 'Source Mode', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest' => esc_html__( 'Latest / Normal Query', 'amaley-core' ),
                'manual' => esc_html__( 'Manual IDs', 'amaley-core' ),
                'featured' => esc_html__( 'Featured Only', 'amaley-core' ),
                'product_category' => esc_html__( 'Product Category Slug', 'amaley-core' ),
            ),
        ) );
        $this->add_control( 'manual_ids', array(
            'label' => esc_html__( 'Manual IDs', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'description' => esc_html__( 'Comma-separated IDs. IDs are filtered by the selected content type.', 'amaley-core' ),
            'condition' => array( 'source_mode' => 'manual' ),
        ) );
        $this->add_control( 'product_category', array(
            'label' => esc_html__( 'Product Category Slugs', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'description' => esc_html__( 'Comma-separated WooCommerce product category slugs.', 'amaley-core' ),
            'condition' => array( 'content_type' => 'product', 'source_mode' => 'product_category' ),
        ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 60, 'default' => 8 ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'date', 'options' => array( 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'menu_order' => 'Menu Order', 'rand' => 'Random' ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'DESC', 'options' => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ) ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty State Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'No items are available yet.' ) );
        $this->end_controls_section();
    }

    private function section_heading_controls() {
        $this->start_controls_section( 'heading_section', array( 'label' => esc_html__( '2. Section Heading / CTA', 'amaley-core' ) ) );
        $this->add_control( 'section_label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley ecosystem' ) );
        $this->add_control( 'section_title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Explore Amaley stories, sources and products' ) );
        $this->add_control( 'section_description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'A reusable showcase for clusters, collectives, producers and products.' ) );
        $this->add_control( 'show_section_button', array( 'label' => esc_html__( 'Show Section Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'section_button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View All', 'condition' => array( 'show_section_button' => '1' ) ) );
        $this->add_control( 'section_button_url', array( 'label' => esc_html__( 'Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'condition' => array( 'show_section_button' => '1' ) ) );
        $this->end_controls_section();
    }

    private function section_layout_controls() {
        $this->start_controls_section( 'layout_section', array( 'label' => esc_html__( '3. Layout Mode', 'amaley-core' ) ) );
        $layout_options = array( 'grid' => 'Grid', 'slider' => 'Slider', 'card-row' => 'Card Row', 'list' => 'List' );
        $phone_options  = array( 'slider' => 'Phone Slider', 'card-row' => 'Horizontal Card Row', 'grid' => '1 Column Grid', 'list' => 'Compact List' );
        $this->add_control( 'desktop_layout', array( 'label' => esc_html__( 'Desktop Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => $layout_options ) );
        $this->add_control( 'tablet_layout', array( 'label' => esc_html__( 'Tablet Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => $layout_options ) );
        $this->add_control( 'phone_layout', array( 'label' => esc_html__( 'Phone Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'slider', 'options' => $phone_options ) );
        $this->add_responsive_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5' ) ) );
        $this->add_responsive_control( 'item_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 22, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-usw__track' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function section_common_card_controls() {
        $this->start_controls_section( 'common_card_section', array( 'label' => esc_html__( '4. Common Card Elements', 'amaley-core' ) ) );
        $fields = array(
            'show_image' => 'Image / Fallback Initial',
            'show_label' => 'Label',
            'show_title' => 'Title',
            'show_excerpt' => 'Description / Excerpt',
            'show_meta' => 'Meta / Stat Boxes',
            'show_tags' => 'Tags / Chips',
            'show_button' => 'Button',
        );
        foreach ( $fields as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html__( 'Show ' . $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->end_controls_section();
    }

    private function section_cluster_card_controls() {
        $this->start_controls_section( 'cluster_card_section', array( 'label' => esc_html__( 'Cluster Card Controls', 'amaley-core' ), 'condition' => array( 'content_type' => 'cluster' ) ) );
        $this->add_control( 'cluster_card_template', array( 'label' => esc_html__( 'Cluster Card Template', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'og_cluster_card_1', 'options' => array( 'og_cluster_card_1' => 'OG Cluster Card 1' ) ) );
        $this->add_control( 'cluster_label_text', array( 'label' => esc_html__( 'Cluster Label Override', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'cluster_description_words', array( 'label' => esc_html__( 'Cluster Description Word Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 8, 'max' => 40, 'default' => 18 ) );
        $this->add_control( 'cluster_button_text', array( 'label' => esc_html__( 'Cluster Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Cluster' ) );
        $this->end_controls_section();
    }

    private function section_shg_card_controls() {
        $this->start_controls_section( 'shg_card_section', array( 'label' => esc_html__( 'SHG Card Controls', 'amaley-core' ), 'condition' => array( 'content_type' => 'shg' ) ) );
        $this->add_control( 'shg_card_template', array( 'label' => esc_html__( 'SHG Card Template', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'og_shg_card_1', 'options' => array( 'og_shg_card_1' => 'OG SHG Card 1' ) ) );
        $this->add_control( 'shg_label_text', array( 'label' => esc_html__( 'SHG Label Override', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'shg_description_words', array( 'label' => esc_html__( 'SHG Description Word Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 8, 'max' => 40, 'default' => 18 ) );
        $this->add_control( 'shg_button_text', array( 'label' => esc_html__( 'SHG Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Collective' ) );
        $this->end_controls_section();
    }

    private function section_member_card_controls() {
        $this->start_controls_section( 'member_card_section', array( 'label' => esc_html__( 'Member / Producer Card Controls', 'amaley-core' ), 'condition' => array( 'content_type' => 'member' ) ) );
        $this->add_control( 'member_card_template', array( 'label' => esc_html__( 'Member Card Template', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'og_member_card_1', 'options' => array( 'og_member_card_1' => 'OG Member Card 1' ) ) );
        $this->add_control( 'member_label_text', array( 'label' => esc_html__( 'Member Label Override', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'member_description_words', array( 'label' => esc_html__( 'Member Bio Word Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 8, 'max' => 40, 'default' => 18 ) );
        $this->add_control( 'member_button_text', array( 'label' => esc_html__( 'Member Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Producer' ) );
        $this->end_controls_section();
    }

    private function section_product_card_controls() {
        $this->start_controls_section( 'product_card_section', array( 'label' => esc_html__( 'Product Card Controls', 'amaley-core' ), 'condition' => array( 'content_type' => 'product' ) ) );
        $this->add_control( 'product_card_template', array( 'label' => esc_html__( 'Product Card Template', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'og_product_card_1', 'options' => array( 'og_product_card_1' => 'OG Product Card 1' ) ) );
        $this->add_control( 'product_label_text', array( 'label' => esc_html__( 'Product Label Override', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'product_description_words', array( 'label' => esc_html__( 'Product Description Word Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 6, 'max' => 40, 'default' => 16 ) );
        $this->add_control( 'product_button_text', array( 'label' => esc_html__( 'Product Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Product' ) );
        $this->end_controls_section();
    }

    private function section_slider_controls() {
        $this->start_controls_section( 'slider_section', array( 'label' => esc_html__( '5. Phone Slider / Pagination', 'amaley-core' ) ) );
        $this->add_control( 'show_arrows', array( 'label' => esc_html__( 'Show Arrows', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_dots', array( 'label' => esc_html__( 'Show Dots', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_numbers', array( 'label' => esc_html__( 'Show Current / Total Number', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'mobile_cards_view', array( 'label' => esc_html__( 'Phone Cards Per View', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1.12', 'options' => array( '1' => '1', '1.12' => '1.12', '1.25' => '1.25', '1.5' => '1.5', '2' => '2' ) ) );
        $this->end_controls_section();
    }

    private function style_section_controls() {
        $this->start_controls_section( 'style_section_box', array( 'label' => esc_html__( 'Section Box', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-usw' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1760 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-usw__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function style_heading_controls() {
        $this->start_controls_section( 'style_heading', array( 'label' => esc_html__( 'Heading Elements', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__label' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__description' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-usw__title' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .amaley-usw__description' ) );
        $this->end_controls_section();
    }

    private function style_card_bridge_controls() {
        $this->start_controls_section( 'style_cards', array( 'label' => esc_html__( 'Card Bridge Styling', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw .amaley-card' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-usw .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 420 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-usw .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amaley-usw .amaley-card' ) );
        $this->end_controls_section();
    }

    private function style_navigation_controls() {
        $this->start_controls_section( 'style_nav', array( 'label' => esc_html__( 'Slider Navigation', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'nav_bg', array( 'label' => esc_html__( 'Arrow Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__arrow' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'nav_color', array( 'label' => esc_html__( 'Arrow Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__arrow' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'dot_color', array( 'label' => esc_html__( 'Dot Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__dot' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'dot_active_color', array( 'label' => esc_html__( 'Active Dot Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__dot.is-active' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $engine = isset( $GLOBALS['amaley_core_universal_showcase'] ) ? $GLOBALS['amaley_core_universal_showcase'] : null;
        if ( ! $engine || ! method_exists( $engine, 'render' ) ) {
            return;
        }
        echo $engine->render( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
