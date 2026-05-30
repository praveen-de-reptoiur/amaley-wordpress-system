<?php
/**
 * Elementor Member / Producer Cards Grid widget.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_Member_Cards_Widget extends \Elementor\Widget_Base {
    /** @var Amaley_Core_Member_Cards */
    private $renderer;

    public function __construct( $renderer = null, $data = array(), $args = null ) {
        parent::__construct( $data, $args );
        $this->renderer = $renderer;
    }

    public function get_name() { return 'amaley_core_member_cards'; }
    public function get_title() { return esc_html__( 'Amaley Member / Producer Cards Grid', 'amaley-core' ); }
    public function get_icon() { return 'eicon-person'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-cards' ); }
    public function get_keywords() { return array( 'amaley', 'member', 'producer', 'maker', 'cards', 'grid' ); }

    protected function register_controls() {
        $this->start_controls_section( 'section_content', array( 'label' => esc_html__( 'Content', 'amaley-core' ) ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Section Title', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Producer Stories' ) );
        $this->add_control( 'subtitle', array( 'label' => esc_html__( 'Section Subtitle', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Meet the producer members and maker families connected with Amaley clusters and SHG groups.' ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Producer' ) );
        $this->add_control( 'button_url', array( 'label' => esc_html__( 'Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '#', 'description' => 'Use {id}, {slug}, {shg_id}, or {cluster_id} for custom detail URLs later.' ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'No Amaley members / producers found yet.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_data', array( 'label' => esc_html__( 'Data Source', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Cards', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 96, 'default' => 8 ) );
        $this->add_control( 'shg_id', array( 'label' => esc_html__( 'Only From SHG ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'Leave blank for all members' ) );
        $this->add_control( 'cluster_id', array( 'label' => esc_html__( 'Only From Cluster ID', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'Optional. Used only when SHG ID is blank.' ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'show_only_website', array( 'label' => esc_html__( 'Only Show Website-Enabled Members', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'include_ids', array( 'label' => esc_html__( 'Include Member IDs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => '12,14,19' ) );
        $this->add_control( 'exclude_ids', array( 'label' => esc_html__( 'Exclude Member IDs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => '8,10' ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'title', 'options' => array( 'title' => 'Title', 'date' => 'Date', 'modified' => 'Modified', 'rand' => 'Random' ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'ASC', 'options' => array( 'ASC' => 'Ascending', 'DESC' => 'Descending' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_visibility', array( 'label' => esc_html__( 'Field Visibility', 'amaley-core' ) ) );
        foreach ( array(
            'show_image' => 'Show Image', 'show_badge' => 'Show Badge', 'show_shg' => 'Show SHG Name', 'show_cluster' => 'Show Cluster Name', 'show_village' => 'Show Village', 'show_role' => 'Show Role', 'show_skills' => 'Show Skills', 'show_products' => 'Show Product Tags', 'show_bio' => 'Show Bio / Story', 'show_button' => 'Show Button'
        ) as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html__( $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Layout', 'amaley-core' ) ) );
        $this->add_control( 'layout_style', array( 'label' => esc_html__( 'Card Layout', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => array( 'grid' => 'Grid Cards', 'editorial' => 'Editorial Wide' ), 'description' => esc_html__( 'Editorial Wide creates an image-left, content-middle, details-right card variation.', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns', array( 'label' => esc_html__( 'Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ) ) );
        $this->add_control( 'image_ratio', array( 'label' => esc_html__( 'Image Ratio', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1-1', 'options' => array( '1-1' => '1:1', '4-3' => '4:3', '16-9' => '16:9' ) ) );
        $this->add_control( 'image_shape', array( 'label' => esc_html__( 'Image Shape', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'rounded', 'options' => array( 'rounded' => 'Rounded', 'circle' => 'Circle', 'square' => 'Square' ) ) );
        $this->add_control( 'equal_height', array( 'label' => esc_html__( 'Equal Height Cards', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_section', array( 'label' => esc_html__( 'Section / Layout', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-members' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-members' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-members-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_card', array( 'label' => esc_html__( 'Card', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-card' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-member-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'card_radius', array( 'label' => esc_html__( 'Border Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-member-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'card_border_color', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-card' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_image', array( 'label' => esc_html__( 'Image', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-member-image' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'badge_bg', array( 'label' => esc_html__( 'Badge Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-badge' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'badge_color', array( 'label' => esc_html__( 'Badge Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-badge' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_text', array( 'label' => esc_html__( 'Typography / Text', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Name Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-core-member-title' ) );
        $this->add_control( 'meta_color', array( 'label' => esc_html__( 'Meta Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-meta, {{WRAPPER}} .amaley-core-member-village, {{WRAPPER}} .amaley-core-member-role' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_typography', 'selector' => '{{WRAPPER}} .amaley-core-member-meta, {{WRAPPER}} .amaley-core-member-village, {{WRAPPER}} .amaley-core-member-role' ) );
        $this->add_control( 'bio_color', array( 'label' => esc_html__( 'Bio Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-bio' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'bio_typography', 'selector' => '{{WRAPPER}} .amaley-core-member-bio' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_tags_button', array( 'label' => esc_html__( 'Tags / Button', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'tag_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-tags span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'tag_color', array( 'label' => esc_html__( 'Tag Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-tags span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-btn' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-member-btn' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-member-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        if ( ! $this->renderer instanceof Amaley_Core_Member_Cards ) {
            $this->renderer = new Amaley_Core_Member_Cards();
        }
        $settings = $this->get_settings_for_display();
        $settings['columns_desktop'] = isset( $settings['columns'] ) ? $settings['columns'] : '4';
        $settings['columns_tablet']  = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : '2';
        $settings['columns_mobile']  = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : '1';
        echo $this->renderer->render( $settings );
    }
}
