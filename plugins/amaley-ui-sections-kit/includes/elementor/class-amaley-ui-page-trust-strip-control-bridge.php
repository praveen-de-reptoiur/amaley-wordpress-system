<?php
/**
 * Elementor style-control bridge for Amaley Page Trust Strip.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_UI_Page_Trust_Strip_Control_Bridge {
	private static $hooked = false;

	public static function hooks() {
		if ( self::$hooked ) { return; }
		self::$hooked = true;
		add_action( 'elementor/element/amaley_ui_page_trust_strip/layout_section/after_section_end', array( __CLASS__, 'register' ), 10, 2 );
	}

	public static function register( $element, $args ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( ! class_exists( '\\Elementor\\Controls_Manager' ) || ! is_object( $element ) ) { return; }
		self::frame( $element );
		self::intro( $element );
		self::cards( $element );
		self::icon( $element );
		self::text( $element );
	}

	private static function frame( $e ) {
		$e->start_controls_section( 'aui_pts_frame', array( 'label' => esc_html__( 'Section / Frame', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		self::dimensions( $e, 'aui_pts_margin', 'Outer Margin', '{{WRAPPER}} .amaley-ui-trust-strip', 'margin' );
		self::slider( $e, 'aui_pts_width', 'Inner Max Width', '{{WRAPPER}} .amaley-ui-trust-strip--width-contained .amaley-ui-trust-strip__inner', 'max-width', 720, 1600, array( 'px', '%' ) );
		self::slider( $e, 'aui_pts_min_height', 'Frame Min Height', '{{WRAPPER}} .amaley-ui-trust-strip__inner', 'min-height', 60, 240 );
		self::color( $e, 'aui_pts_frame_bg', 'Frame Background', '{{WRAPPER}} .amaley-ui-trust-strip__inner', 'background' );
		self::border( $e, 'aui_pts_frame_border', '{{WRAPPER}} .amaley-ui-trust-strip__inner' );
		self::dimensions( $e, 'aui_pts_frame_radius', 'Frame Radius', '{{WRAPPER}} .amaley-ui-trust-strip__inner', 'border-radius' );
		self::shadow( $e, 'aui_pts_frame_shadow', '{{WRAPPER}} .amaley-ui-trust-strip__inner' );
		$e->end_controls_section();
	}

	private static function intro( $e ) {
		$e->start_controls_section( 'aui_pts_intro', array( 'label' => esc_html__( 'Intro Panel', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$e->add_responsive_control( 'aui_pts_intro_width', array( 'label' => esc_html__( 'Desktop Intro Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 180, 'max' => 560 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-ui-trust-strip__inner' => 'grid-template-columns: minmax({{SIZE}}{{UNIT}}, .58fr) minmax(0, 1.42fr);' ) ) );
		self::dimensions( $e, 'aui_pts_intro_padding', 'Panel Padding', '{{WRAPPER}} .amaley-ui-trust-strip__intro', 'padding' );
		self::color( $e, 'aui_pts_intro_bg', 'Panel Background', '{{WRAPPER}} .amaley-ui-trust-strip__intro', 'background' );
		self::color( $e, 'aui_pts_intro_accent', 'Left Accent Color', '{{WRAPPER}} .amaley-ui-trust-strip__intro::after', 'background' );
		$e->add_control( 'aui_pts_intro_label_head', array( 'label' => esc_html__( 'Small Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		self::typography( $e, 'aui_pts_label_typo', '{{WRAPPER}} .amaley-ui-trust-strip__label' );
		self::color( $e, 'aui_pts_label_color', 'Label Color', '{{WRAPPER}} .amaley-ui-trust-strip__label', 'color' );
		$e->add_control( 'aui_pts_intro_main_head', array( 'label' => esc_html__( 'Main Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		self::typography( $e, 'aui_pts_heading_typo', '{{WRAPPER}} .amaley-ui-trust-strip__heading' );
		self::color( $e, 'aui_pts_heading_color', 'Main Text Color', '{{WRAPPER}} .amaley-ui-trust-strip__heading', 'color' );
		$e->end_controls_section();
	}

	private static function cards( $e ) {
		$e->start_controls_section( 'aui_pts_cards', array( 'label' => esc_html__( 'Items / Cards', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		self::slider( $e, 'aui_pts_grid_gap', 'Grid Gap', '{{WRAPPER}} .amaley-ui-trust-strip__items', 'gap', 0, 44 );
		self::dimensions( $e, 'aui_pts_grid_padding', 'Grid Padding', '{{WRAPPER}} .amaley-ui-trust-strip__items', 'padding' );
		self::dimensions( $e, 'aui_pts_card_padding', 'Card Padding', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'padding' );
		self::slider( $e, 'aui_pts_card_gap', 'Icon/Text Gap', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'gap', 0, 40 );
		self::slider( $e, 'aui_pts_card_min_height', 'Card Min Height', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'min-height', 54, 220 );
		self::color( $e, 'aui_pts_card_bg', 'Card Background', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'background' );
		self::color( $e, 'aui_pts_card_hover_bg', 'Hover Background', '{{WRAPPER}} .amaley-ui-trust-strip__item:hover', 'background' );
		self::border( $e, 'aui_pts_card_border', '{{WRAPPER}} .amaley-ui-trust-strip__item' );
		self::dimensions( $e, 'aui_pts_card_radius', 'Card Radius', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'border-radius' );
		self::shadow( $e, 'aui_pts_card_shadow', '{{WRAPPER}} .amaley-ui-trust-strip__item' );
		self::color( $e, 'aui_pts_card_glow', 'Top Glow Color', '{{WRAPPER}} .amaley-ui-trust-strip--motion-glow .amaley-ui-trust-strip__item::before', 'background' );
		$e->end_controls_section();
	}

	private static function icon( $e ) {
		$e->start_controls_section( 'aui_pts_icon', array( 'label' => esc_html__( 'Item Icon', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		self::slider( $e, 'aui_pts_icon_box', 'Icon Box Size', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 'width', 24, 80 );
		$e->add_responsive_control( 'aui_pts_icon_svg', array( 'label' => esc_html__( 'SVG Size', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 10, 'max' => 44 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-ui-trust-strip__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
		self::color( $e, 'aui_pts_icon_color', 'Icon Color', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 'color' );
		self::color( $e, 'aui_pts_icon_bg', 'Icon Background', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 'background' );
		self::border( $e, 'aui_pts_icon_border', '{{WRAPPER}} .amaley-ui-trust-strip__icon' );
		self::dimensions( $e, 'aui_pts_icon_radius', 'Icon Radius', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 'border-radius' );
		$e->end_controls_section();
	}

	private static function text( $e ) {
		$e->start_controls_section( 'aui_pts_text', array( 'label' => esc_html__( 'Item Title & Text', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$e->add_control( 'aui_pts_title_head', array( 'label' => esc_html__( 'Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING ) );
		self::typography( $e, 'aui_pts_title_typo', '{{WRAPPER}} .amaley-ui-trust-strip__item-title' );
		self::color( $e, 'aui_pts_title_color', 'Title Color', '{{WRAPPER}} .amaley-ui-trust-strip__item-title', 'color' );
		$e->add_control( 'aui_pts_copy_head', array( 'label' => esc_html__( 'Short Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		self::typography( $e, 'aui_pts_copy_typo', '{{WRAPPER}} .amaley-ui-trust-strip__item-text' );
		self::color( $e, 'aui_pts_copy_color', 'Text Color', '{{WRAPPER}} .amaley-ui-trust-strip__item-text', 'color' );
		self::slider( $e, 'aui_pts_copy_space', 'Text Top Spacing', '{{WRAPPER}} .amaley-ui-trust-strip__item-text', 'margin-top', 0, 40 );
		$e->end_controls_section();
	}

	private static function color( $e, $name, $label, $selector, $property ) {
		$e->add_control( $name, array( 'label' => esc_html__( $label, 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => $property . ': {{VALUE}};' ) ) );
	}

	private static function slider( $e, $name, $label, $selector, $property, $min, $max, $units = array( 'px' ) ) {
		$value = 'width' === $property ? 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' : $property . ': {{SIZE}}{{UNIT}};';
		$e->add_responsive_control( $name, array( 'label' => esc_html__( $label, 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => $units, 'range' => array( 'px' => array( 'min' => $min, 'max' => $max ) ), 'selectors' => array( $selector => $value ) ) );
	}

	private static function dimensions( $e, $name, $label, $selector, $property ) {
		$template = 'border-radius' === $property ? 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' : $property . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
		$e->add_responsive_control( $name, array( 'label' => esc_html__( $label, 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%', 'em', 'rem' ), 'selectors' => array( $selector => $template ) ) );
	}

	private static function border( $e, $name, $selector ) {
		if ( class_exists( '\\Elementor\\Group_Control_Border' ) ) { $e->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => $name, 'selector' => $selector ) ); }
	}

	private static function shadow( $e, $name, $selector ) {
		if ( class_exists( '\\Elementor\\Group_Control_Box_Shadow' ) ) { $e->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => $name, 'selector' => $selector ) ); }
	}

	private static function typography( $e, $name, $selector ) {
		if ( class_exists( '\\Elementor\\Group_Control_Typography' ) ) { $e->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $name, 'selector' => $selector ) ); }
	}
}

Amaley_UI_Page_Trust_Strip_Control_Bridge::hooks();
