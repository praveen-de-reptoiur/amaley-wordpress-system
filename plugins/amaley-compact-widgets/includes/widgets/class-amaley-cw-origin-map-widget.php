<?php
/**
 * Origin Map Path Elementor widget.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

final class Amaley_CW_Origin_Map_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'amaley_cw_origin_map'; }
	public function get_title() { return esc_html__( 'Amaley Origin Map Path', 'amaley-compact-widgets' ); }
	public function get_icon() { return 'eicon-map-pin'; }
	public function get_categories() { return array( 'amaley-compact' ); }
	public function get_style_depends() { return array( 'amaley-compact-widgets', 'amaley-compact-widgets-origin-map' ); }
	public function get_script_depends() { return array( 'amaley-compact-widgets-origin-map' ); }
	public function get_keywords() { return array( 'amaley', 'origin', 'map', 'traceability', 'homepage' ); }

	protected function register_controls() {
		$defaults = Amaley_CW_Origin_Map::defaults();

		$this->start_controls_section( 'origin_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );
		$this->add_control( 'kicker', array( 'label' => esc_html__( 'Left Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['kicker'] ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Left Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => $defaults['title'] ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Left Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $defaults['description'] ) );
		$this->add_control( 'right_kicker', array( 'label' => esc_html__( 'Right Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['right_kicker'] ) );
		$this->add_control( 'right_title', array( 'label' => esc_html__( 'Right Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => $defaults['right_title'] ) );
		$this->add_control( 'right_description', array( 'label' => esc_html__( 'Right Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $defaults['right_description'] ) );
		$this->end_controls_section();

		$this->start_controls_section( 'origin_map', array( 'label' => esc_html__( 'Real Map', 'amaley-compact-widgets' ) ) );
		$this->add_control( 'map_kicker', array( 'label' => esc_html__( 'Map Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['map_kicker'] ) );
		$this->add_control( 'map_title', array( 'label' => esc_html__( 'Map Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['map_title'] ) );
		$this->add_control( 'route_text', array( 'label' => esc_html__( 'Route Caption', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => $defaults['route_text'] ) );
		$this->add_control( 'foot_note', array( 'label' => esc_html__( 'Bottom Note', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => $defaults['foot_note'] ) );
		$this->add_control( 'center_lat', array( 'label' => esc_html__( 'Map Center Latitude', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['center_lat'] ) );
		$this->add_control( 'center_lng', array( 'label' => esc_html__( 'Map Center Longitude', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['center_lng'] ) );
		$this->add_control( 'zoom', array( 'label' => esc_html__( 'Initial Zoom', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 4, 'max' => 15, 'step' => 1, 'default' => $defaults['zoom'] ) );
		$this->add_control( 'tile_url', array( 'label' => esc_html__( 'Tile URL Template', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['tile_url'], 'description' => esc_html__( 'Use {z}, {x}, {y}. Default uses OpenStreetMap tiles.', 'amaley-compact-widgets' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'origin_items', array( 'label' => esc_html__( 'Right Step Cards', 'amaley-compact-widgets' ) ) );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'number', array( 'label' => esc_html__( 'Number', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ) );
		$rep->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster Origin' ) );
		$rep->add_control( 'text', array( 'label' => esc_html__( 'Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Where the ingredient, landscape and local knowledge begin.' ) );
		$this->add_control( 'items', array( 'label' => esc_html__( 'Steps', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}', 'default' => Amaley_CW_Origin_Map::default_items() ) );
		$this->end_controls_section();

		$this->start_controls_section( 'origin_actions', array( 'label' => esc_html__( 'Button', 'amaley-compact-widgets' ) ) );
		$this->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['button_text'] ) );
		$this->add_control( 'button_url', array( 'label' => esc_html__( 'Button Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'origin_style', array( 'label' => esc_html__( 'Section / Cards', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'panel_bg', array( 'label' => esc_html__( 'Panel Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path-panel' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-origin-map-path' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		if ( class_exists( 'Amaley_CW_Plugin' ) ) {
			Amaley_CW_Plugin::instance()->enqueue_assets();
		}
		echo Amaley_CW_Origin_Map::render( $this->get_settings_for_display() );
	}
}
