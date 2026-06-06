<?php
/** Amaley Universal Showcase Elementor widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Universal_Showcase_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_universal_showcase'; }
    public function get_title() { return esc_html__( 'Amaley Universal Showcase', 'amaley-core' ); }
    public function get_icon() { return 'eicon-slider-push'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_keywords() { return array( 'amaley', 'showcase', 'slider', 'grid', 'cluster', 'shg', 'member', 'product' ); }
    public function get_style_depends() { return array( 'amaley-core-cards', 'amaley-core-universal-showcase' ); }
    public function get_script_depends() { return array( 'amaley-core-universal-showcase' ); }

    protected function register_controls() {
        $this->source_controls();
        $this->heading_controls();
        $this->layout_controls();
        $this->card_family_controls( 'cluster', 'Cluster', 'OG Cluster Card 1', 'View Cluster', 18 );
        $this->card_family_controls( 'shg', 'SHG', 'OG SHG Card 1', 'View Collective', 18 );
        $this->card_family_controls( 'member', 'Member / Producer', 'OG Member Card 1', 'View Producer', 18 );
        $this->card_family_controls( 'product', 'Product', 'OG Product Card 1', 'View Product', 16 );
        $this->slider_controls();
        $this->style_controls();
    }

    private function source_controls() {
        $this->start_controls_section( 'source_section', array( 'label' => esc_html__( '1. Showcase Source', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'content_type', array(
            'label' => esc_html__( 'What to Show', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'cluster',
            'options' => array( 'cluster' => 'Cluster', 'shg' => 'SHG / Producer Group', 'member' => 'Member / Producer', 'product' => 'Product' ),
            'description' => esc_html__( 'Only the selected card type controls will appear below.', 'amaley-core' ),
        ) );
        $this->add_control( 'source_mode', array( 'label' => esc_html__( 'Source Mode', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'latest', 'options' => array( 'latest' => 'Latest / Normal Query', 'manual' => 'Manual IDs', 'featured' => 'Featured Only', 'product_category' => 'Product Category Slug' ) ) );
        $this->add_control( 'manual_ids', array( 'label' => esc_html__( 'Manual IDs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Comma-separated IDs filtered by selected content type.', 'amaley-core' ), 'condition' => array( 'source_mode' => 'manual' ) ) );
        $this->add_control( 'product_category', array( 'label' => esc_html__( 'Product Category Slugs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'condition' => array( 'content_type' => 'product', 'source_mode' => 'product_category' ) ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Items', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 60, 'default' => 8 ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'date', 'options' => array( 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'menu_order' => 'Menu Order', 'rand' => 'Random' ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'DESC', 'options' => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ) ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty State Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'No items are available yet.' ) );
        $this->end_controls_section();
    }

    private function heading_controls() {
        $this->start_controls_section( 'heading_section', array( 'label' => esc_html__( '2. Section Heading / CTA', 'amaley-core' ) ) );
        $this->add_control( 'section_label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley ecosystem' ) );
        $this->add_control( 'section_title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Explore Amaley stories, sources and products' ) );
        $this->add_control( 'section_description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'A reusable showcase for clusters, collectives, producers and products.' ) );
        $this->add_control( 'show_section_button', array( 'label' => esc_html__( 'Show Section Button', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'section_button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View All', 'condition' => array( 'show_section_button' => '1' ) ) );
        $this->add_control( 'section_button_url', array( 'label' => esc_html__( 'Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'condition' => array( 'show_section_button' => '1' ) ) );
        $this->end_controls_section();
    }

    private function layout_controls() {
        $this->start_controls_section( 'layout_section', array( 'label' => esc_html__( '3. Layout Mode', 'amaley-core' ) ) );
        $layout_options = array( 'grid' => 'Grid', 'slider' => 'Slider', 'card-row' => 'Card Row', 'list' => 'List' );
        $this->add_control( 'desktop_layout', array( 'label' => esc_html__( 'Desktop Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => $layout_options ) );
        $this->add_control( 'tablet_layout', array( 'label' => esc_html__( 'Tablet Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => $layout_options ) );
        $this->add_control( 'phone_layout', array( 'label' => esc_html__( 'Phone Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'slider', 'options' => array( 'slider' => 'Phone Slider', 'card-row' => 'Horizontal Card Row', 'grid' => '1 Column Grid', 'list' => 'Compact List' ) ) );
        $this->add_control( 'columns_desktop', array( 'label' => esc_html__( 'Desktop Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5' ) ) );
        $this->add_control( 'columns_tablet', array( 'label' => esc_html__( 'Tablet Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '2', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ) ) );
        $this->add_control( 'columns_phone', array( 'label' => esc_html__( 'Phone Grid Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1', 'options' => array( '1'=>'1','2'=>'2' ) ) );
        $this->add_responsive_control( 'item_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 22, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-usw__track' => '--amaley-usw-gap: {{SIZE}}{{UNIT}}; gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function card_family_controls( $type, $title, $template_label, $button_text, $words ) {
        $this->start_controls_section( $type . '_card_section', array( 'label' => esc_html__( $title . ' Card Controls', 'amaley-core' ), 'condition' => array( 'content_type' => $type ) ) );
        $this->add_control( $type . '_card_template', array( 'label' => esc_html__( $title . ' Card Template', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'og_card_1', 'options' => array( 'og_card_1' => $template_label ) ) );
        foreach ( array( 'image'=>'Image / Fallback Initial', 'label'=>'Label', 'title'=>'Title', 'excerpt'=>'Description / Excerpt', 'meta'=>'Meta / Stat Boxes', 'tags'=>'Tags / Chips', 'button'=>'Button' ) as $key => $label ) {
            $this->add_control( $type . '_show_' . $key, array( 'label' => esc_html__( 'Show ' . $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->add_control( $type . '_label_text', array( 'label' => esc_html__( $title . ' Label Override', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( $type . '_description_words', array( 'label' => esc_html__( $title . ' Description Word Limit', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 6, 'max' => 40, 'default' => $words ) );
        $this->add_control( $type . '_button_text', array( 'label' => esc_html__( $title . ' Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $button_text ) );
        $this->end_controls_section();
    }

    private function slider_controls() {
        $this->start_controls_section( 'slider_section', array( 'label' => esc_html__( '5. Phone Slider / Pagination', 'amaley-core' ) ) );
        $this->add_control( 'show_arrows', array( 'label' => esc_html__( 'Show Arrows', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_dots', array( 'label' => esc_html__( 'Show Dots', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_numbers', array( 'label' => esc_html__( 'Show Current / Total Number', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'mobile_cards_view', array( 'label' => esc_html__( 'Phone Cards Per View', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1.12', 'options' => array( '1'=>'1','1.12'=>'1.12','1.25'=>'1.25','1.5'=>'1.5','2'=>'2' ) ) );
        $this->end_controls_section();
    }

    private function style_controls() {
        $this->start_controls_section( 'style_section_box', array( 'label' => esc_html__( 'Section Box', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-usw' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1760 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-usw__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_heading', array( 'label' => esc_html__( 'Heading Elements', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__label' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw__description' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-usw__title' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .amaley-usw__description' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_cards', array( 'label' => esc_html__( 'Selected Card Styling', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-usw .amaley-card' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-usw .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 420 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-usw .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amaley-usw .amaley-card' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $engine = isset( $GLOBALS['amaley_core_universal_showcase'] ) ? $GLOBALS['amaley_core_universal_showcase'] : null;
        if ( $engine && method_exists( $engine, 'render' ) ) {
            echo $engine->render( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
