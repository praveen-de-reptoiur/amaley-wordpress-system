<?php
/**
 * Elementor Home Hero V6 widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

/**
 * Elementor widget for the locked live-style Amaley Home Hero V6.
 */
final class Amaley_Elementor_Home_Hero_V6_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'amaley_ui_home_hero_v6';
	}

	public function get_title() {
		return esc_html__( 'Amaley Home Hero V6', 'amaley-ui-sections-kit' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return array( 'amaley-ui', 'general' );
	}

	public function get_keywords() {
		return array( 'amaley', 'home hero', 'hero v6', 'live hero', 'homepage' );
	}

	public function get_style_depends() {
		return array( 'amaley-ui-sections-kit', 'amaley-ui-home-hero-v6' );
	}

	public function get_script_depends() {
		return array( 'amaley-ui-home-hero-v6' );
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_counter_controls();
		$this->register_image_controls();
		$this->register_badge_controls();
		$this->register_style_section_controls();
		$this->register_style_left_panel_controls();
		$this->register_style_typography_controls();
		$this->register_style_button_controls();
		$this->register_style_counter_controls();
		$this->register_style_image_controls();
		$this->register_style_badge_controls();
	}

	private function register_content_controls() {
		$this->start_controls_section( 'ahh6_content', array( 'label' => esc_html__( 'Hero Content', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'tag', array( 'label' => esc_html__( 'Hero Tag', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Himalayan Foods · Women-Led · Small Batch', 'label_block' => true ) );
		$this->add_control( 'title_line_1', array( 'label' => esc_html__( 'Title Line 1', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'From Himalayan', 'label_block' => true ) );
		$this->add_control( 'title_em', array( 'label' => esc_html__( 'Italic Word', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Kitchens', 'label_block' => true ) );
		$this->add_control( 'title_line_3', array( 'label' => esc_html__( 'Title Line 3', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'To Your Home', 'label_block' => true ) );
		$this->add_control( 'subtitle', array( 'label' => esc_html__( 'Subtitle', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Small-batch foods crafted by women-led communities across the Himalayas. Rooted in tradition. Made with care. Curated for everyday life and gifting.' ) );
		$this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Shop Now' ) );
		$this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button URL', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => 'https://lightsalmon-lemur-689499.hostingersite.com/shop-2/' ) ) );
		$this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Our Story →' ) );
		$this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button URL', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => 'https://lightsalmon-lemur-689499.hostingersite.com/about/' ) ) );
		$this->end_controls_section();
	}

	private function register_counter_controls() {
		$this->start_controls_section( 'ahh6_counters', array( 'label' => esc_html__( 'Live Counter', 'amaley-ui-sections-kit' ) ) );
		for ( $i = 1; $i <= 4; $i++ ) {
			$values = array( 1 => 12, 2 => 48, 3 => 200, 4 => 60 );
			$labels = array( 1 => 'Clusters', 2 => 'SHGs', 3 => 'Producers', 4 => 'Products' );
			$this->add_control( 'stat_' . $i . '_value', array( 'label' => sprintf( esc_html__( 'Counter %d Value', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => $values[ $i ], 'min' => 0 ) );
			$this->add_control( 'stat_' . $i . '_suffix', array( 'label' => sprintf( esc_html__( 'Counter %d Suffix', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => in_array( $i, array( 1, 3, 4 ), true ) ? '+' : '' ) );
			$this->add_control( 'stat_' . $i . '_label', array( 'label' => sprintf( esc_html__( 'Counter %d Label', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $labels[ $i ] ) );
		}
		$this->end_controls_section();
	}

	private function register_image_controls() {
		$this->start_controls_section( 'ahh6_images', array( 'label' => esc_html__( 'Right Images', 'amaley-ui-sections-kit' ) ) );

		$this->add_control(
			'images_note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Image boxes are now hard-locked to center center + cover by default. Use Style tab > Image Collage / Fit Controls only when a crop needs adjustment.', 'amaley-ui-sections-kit' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$defaults = array(
			1 => 'https://lightsalmon-lemur-689499.hostingersite.com/wp-content/uploads/2026/05/amaley-hero-image-1-large-left.jpg',
			2 => 'https://lightsalmon-lemur-689499.hostingersite.com/wp-content/uploads/2026/05/ChatGPT-Image-May-6-2026-01_11_38-AM-3.png',
			3 => 'https://lightsalmon-lemur-689499.hostingersite.com/wp-content/uploads/2026/05/nre-2.png',
		);
		$labels = array(
			1 => esc_html__( 'Main Tall Image', 'amaley-ui-sections-kit' ),
			2 => esc_html__( 'Top Right Image', 'amaley-ui-sections-kit' ),
			3 => esc_html__( 'Bottom Right Image', 'amaley-ui-sections-kit' ),
		);
		$alts = array(
			1 => 'Amaley Himalayan food products with mountain background',
			2 => 'Amaley Himalayan ingredients and spices',
			3 => 'Women preparing Himalayan food products',
		);

		for ( $i = 1; $i <= 3; $i++ ) {
			$this->add_control( 'image_' . $i, array( 'label' => $labels[ $i ], 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => array( 'url' => $defaults[ $i ] ) ) );
			$this->add_control( 'image_' . $i . '_alt', array( 'label' => sprintf( esc_html__( 'Image %d Alt Text', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $alts[ $i ] ) );
			$this->add_control( 'image_' . $i . '_crop', array( 'label' => sprintf( esc_html__( 'Image %d Default Crop Preset', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center', 'options' => array( 'center' => 'Center Center', 'top' => 'Center Top', 'bottom' => 'Center Bottom', 'left' => 'Left Center', 'right' => 'Right Center' ) ) );
		}
		$this->end_controls_section();
	}

	private function register_badge_controls() {
		$this->start_controls_section( 'ahh6_badge', array( 'label' => esc_html__( 'Center Medallion', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'badge_kicker', array( 'label' => esc_html__( 'Badge Kicker', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => "Himalayas<br>To Home", 'description' => esc_html__( 'Use <br> for line break.', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'badge_text', array( 'label' => esc_html__( 'Badge Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => "Made with<br>a mother's care", 'description' => esc_html__( 'Use <br> for line break.', 'amaley-ui-sections-kit' ) ) );
		$this->end_controls_section();
	}

	private function register_style_section_controls() {
		$this->start_controls_section( 'ahh6_style_section', array( 'label' => esc_html__( 'Section / Background', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-ivory: {{VALUE}};' ) ) );
		$this->add_control( 'deep_color', array( 'label' => esc_html__( 'Deep Chocolate', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-choco: {{VALUE}};' ) ) );
		$this->add_control( 'gold_color', array( 'label' => esc_html__( 'Gold Accent', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-gold: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'hero_max_width', array( 'label' => esc_html__( 'Hero Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 960, 'max' => 1600 ) ), 'default' => array( 'size' => 1280, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-max: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'hero_height', array( 'label' => esc_html__( 'Desktop Hero Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 520, 'max' => 820 ) ), 'default' => array( 'size' => 680, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-hero-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'left_width', array( 'label' => esc_html__( 'Left Panel Width %', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 42, 'max' => 58 ) ), 'default' => array( 'size' => 49, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-left-col: {{SIZE}}%; --ahh6-right-col: calc(100% - {{SIZE}}%);' ) ) );
		$this->end_controls_section();
	}

	private function register_style_left_panel_controls() {
		$this->start_controls_section( 'ahh6_style_left', array( 'label' => esc_html__( 'Left Content Panel', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'left_panel_bg', array( 'label' => esc_html__( 'Panel Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-left' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'left_panel_border', array( 'label' => esc_html__( 'Inner Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-border-soft: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'left_panel_padding', array( 'label' => esc_html__( 'Panel Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-left' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_style_typography_controls() {
		$this->start_controls_section( 'ahh6_style_text', array( 'label' => esc_html__( 'Label / Heading / Text', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'tag_color', array( 'label' => esc_html__( 'Tag Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-tag-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'tag_typography', 'selector' => '{{WRAPPER}} .amaley-home-hero-v6-tag-text' ) );
		$this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-title' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'heading_accent_color', array( 'label' => esc_html__( 'Heading Italic Accent', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-title-em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .amaley-home-hero-v6-title' ) );
		$this->add_control( 'subtitle_color', array( 'label' => esc_html__( 'Subtitle Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-subtitle' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'subtitle_typography', 'selector' => '{{WRAPPER}} .amaley-home-hero-v6-subtitle' ) );
		$this->end_controls_section();
	}

	private function register_style_button_controls() {
		$this->start_controls_section( 'ahh6_style_buttons', array( 'label' => esc_html__( 'Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-btn-primary' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-btn-primary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_button_color', array( 'label' => esc_html__( 'Secondary Text / Border', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-btn-outline' => 'color: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .amaley-home-hero-v6-btn-primary, {{WRAPPER}} .amaley-home-hero-v6-btn-outline' ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-btn-primary, {{WRAPPER}} .amaley-home-hero-v6-btn-outline' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_style_counter_controls() {
		$this->start_controls_section( 'ahh6_style_counter', array( 'label' => esc_html__( 'Counter / Proof Row', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'counter_border_color', array( 'label' => esc_html__( 'Counter Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-border: {{VALUE}};' ) ) );
		$this->add_control( 'counter_number_color', array( 'label' => esc_html__( 'Number Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-stat-number' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'counter_number_typography', 'selector' => '{{WRAPPER}} .amaley-home-hero-v6-stat-number' ) );
		$this->add_control( 'counter_label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-stat-label' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'counter_label_typography', 'selector' => '{{WRAPPER}} .amaley-home-hero-v6-stat-label' ) );
		$this->end_controls_section();
	}

	private function register_style_image_controls() {
		$this->start_controls_section( 'ahh6_style_images', array( 'label' => esc_html__( 'Image Collage / Fit Controls', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

		$this->add_control(
			'image_fit_note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Default is Cover + Center Center for every image. This is the safest setting for mixed image sizes. Use Contain only when the full image must be visible, but it may leave empty background space.', 'amaley-ui-sections-kit' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control( 'image_panel_bg', array( 'label' => esc_html__( 'Image Panel Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-parchment: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'image_gap', array( 'label' => esc_html__( 'Image Grid Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 20 ) ), 'default' => array( 'size' => 3, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-mosaic-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'main_image_ratio', array( 'label' => esc_html__( 'Main Image Width Ratio', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 45, 'max' => 70 ) ), 'default' => array( 'size' => 51, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-main-image-width: {{SIZE}}%;' ) ) );
		$this->add_control( 'image_hover_scale', array( 'label' => esc_html__( 'Image Hover Zoom', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.2, 'step' => 0.005 ) ), 'default' => array( 'size' => 1.075 ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-img-hover-scale: {{SIZE}};' ) ) );

		$this->add_control( 'all_images_heading', array( 'label' => esc_html__( 'All Images Default Fit', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'all_images_fit', array( 'label' => esc_html__( 'All Images Fit', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover: fill box and crop safely', 'contain' => 'Contain: full image visible', 'fill' => 'Fill: stretch image' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-image-card img' => 'object-fit: {{VALUE}} !important;' ) ) );
		$this->add_control( 'all_images_x', array( 'label' => esc_html__( 'All Images Horizontal Focus', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '50%', 'options' => array( '0%' => 'Left', '50%' => 'Center', '100%' => 'Right' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-img1-x: {{VALUE}}; --ahh6-img2-x: {{VALUE}}; --ahh6-img3-x: {{VALUE}};' ) ) );
		$this->add_control( 'all_images_y', array( 'label' => esc_html__( 'All Images Vertical Focus', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '50%', 'options' => array( '0%' => 'Top', '50%' => 'Center', '100%' => 'Bottom' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-img1-y: {{VALUE}}; --ahh6-img2-y: {{VALUE}}; --ahh6-img3-y: {{VALUE}};' ) ) );

		for ( $i = 1; $i <= 3; $i++ ) {
			$this->add_control( 'image_' . $i . '_style_heading', array( 'label' => sprintf( esc_html__( 'Image %d Individual Fit / Crop', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
			$this->add_control( 'image_' . $i . '_fit', array( 'label' => sprintf( esc_html__( 'Image %d Fit', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover: fill box and crop safely', 'contain' => 'Contain: full image visible', 'fill' => 'Fill: stretch image' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-img' . $i . '-fit: {{VALUE}};' ) ) );
			$this->add_responsive_control( 'image_' . $i . '_focus_x', array( 'label' => sprintf( esc_html__( 'Image %d Horizontal Focus', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 50, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-img' . $i . '-x: {{SIZE}}%;' ) ) );
			$this->add_responsive_control( 'image_' . $i . '_focus_y', array( 'label' => sprintf( esc_html__( 'Image %d Vertical Focus', 'amaley-ui-sections-kit' ), $i ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 50, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-img' . $i . '-y: {{SIZE}}%;' ) ) );
		}
		$this->end_controls_section();
	}

	private function register_style_badge_controls() {
		$this->start_controls_section( 'ahh6_style_badge', array( 'label' => esc_html__( 'Center Medallion / Badge', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'badge_size', array( 'label' => esc_html__( 'Badge Size', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 80, 'max' => 190 ) ), 'default' => array( 'size' => 130, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-badge-size: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'badge_x', array( 'label' => esc_html__( 'Badge X Position', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 35, 'max' => 70 ) ), 'default' => array( 'size' => 50, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-badge-x: {{SIZE}}%;' ) ) );
		$this->add_responsive_control( 'badge_y', array( 'label' => esc_html__( 'Badge Y Position', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 35, 'max' => 68 ) ), 'default' => array( 'size' => 50, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6' => '--ahh6-badge-y: {{SIZE}}%;' ) ) );
		$this->add_control( 'badge_bg', array( 'label' => esc_html__( 'Badge Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-medallion-circle' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'badge_border', array( 'label' => esc_html__( 'Badge Border', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-medallion-circle' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 'badge_text_color', array( 'label' => esc_html__( 'Badge Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-home-hero-v6-medallion-text' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$atts     = array(
			'tag'            => $settings['tag'] ?? '',
			'title_line_1'   => $settings['title_line_1'] ?? '',
			'title_em'       => $settings['title_em'] ?? '',
			'title_line_3'   => $settings['title_line_3'] ?? '',
			'subtitle'       => $settings['subtitle'] ?? '',
			'primary_text'   => $settings['primary_text'] ?? '',
			'primary_url'    => $settings['primary_url']['url'] ?? '',
			'secondary_text' => $settings['secondary_text'] ?? '',
			'secondary_url'  => $settings['secondary_url']['url'] ?? '',
			'badge_kicker'   => $settings['badge_kicker'] ?? '',
			'badge_text'     => $settings['badge_text'] ?? '',
		);
		for ( $i = 1; $i <= 4; $i++ ) {
			$atts[ 'stat_' . $i . '_value' ]  = $settings[ 'stat_' . $i . '_value' ] ?? '';
			$atts[ 'stat_' . $i . '_suffix' ] = $settings[ 'stat_' . $i . '_suffix' ] ?? '';
			$atts[ 'stat_' . $i . '_label' ]  = $settings[ 'stat_' . $i . '_label' ] ?? '';
		}
		for ( $i = 1; $i <= 3; $i++ ) {
			$atts[ 'image_' . $i ]           = $settings[ 'image_' . $i ]['url'] ?? '';
			$atts[ 'image_' . $i . '_alt' ]  = $settings[ 'image_' . $i . '_alt' ] ?? '';
			$atts[ 'image_' . $i . '_crop' ] = $settings[ 'image_' . $i . '_crop' ] ?? 'center';
		}
		echo Amaley_UI_Home_Hero_V6::render( $atts );
	}
}
