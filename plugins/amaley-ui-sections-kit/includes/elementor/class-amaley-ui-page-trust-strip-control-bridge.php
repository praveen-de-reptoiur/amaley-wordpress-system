<?php
/**
 * Final tested Page Trust Strip Elementor control bridge.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_UI_Page_Trust_Strip_Control_Bridge {
	private static $hooked = false;

	public static function init() {
		if ( self::$hooked ) {
			return;
		}

		self::$hooked = true;

		add_action( 'elementor/element/amaley_ui_page_trust_strip/layout_section/before_section_end', array( __CLASS__, 'add_layout_controls' ), 20, 2 );
		add_action( 'elementor/element/amaley_ui_page_trust_strip/layout_section/after_section_end', array( __CLASS__, 'add_style_sections' ), 20, 2 );

		// Strong override CSS for desktop / tablet / phone columns.
		add_action( 'wp_head', array( __CLASS__, 'print_forced_column_css' ), 99 );
		add_action( 'elementor/preview/enqueue_styles', array( __CLASS__, 'print_forced_column_css' ), 99 );
		add_action( 'elementor/editor/after_enqueue_styles', array( __CLASS__, 'print_forced_column_css' ), 99 );
	}

	public static function add_layout_controls( $element, $args ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( ! self::ready( $element ) ) {
			return;
		}

		$element->add_control(
			'amaley_pts_force_columns_head',
			array(
				'label'     => esc_html__( 'Forced Responsive Columns', 'amaley-ui-sections-kit' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$element->add_control(
			'amaley_pts_desktop_cols_class',
			array(
				'label'        => esc_html__( 'Desktop Columns', 'amaley-ui-sections-kit' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '4',
				'options'      => self::column_options(),
				'prefix_class' => 'amaley-pts-desktop-cols-',
			)
		);

		$element->add_control(
			'amaley_pts_tablet_cols_class',
			array(
				'label'        => esc_html__( 'Tablet Columns', 'amaley-ui-sections-kit' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '2',
				'options'      => self::column_options(),
				'prefix_class' => 'amaley-pts-tablet-cols-',
			)
		);

		$element->add_control(
			'amaley_pts_phone_cols_class',
			array(
				'label'        => esc_html__( 'Phone Columns', 'amaley-ui-sections-kit' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '2',
				'options'      => self::column_options(),
				'prefix_class' => 'amaley-pts-phone-cols-',
				'description'  => esc_html__( 'This uses a strong wrapper-class override so it can beat the original mobile 1-column CSS.', 'amaley-ui-sections-kit' ),
			)
		);

		$element->add_responsive_control(
			'amaley_pts_items_gap_force',
			array(
				'label'      => esc_html__( 'Items Gap', 'amaley-ui-sections-kit' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 44 ) ),
				'selectors'  => array(
					'{{WRAPPER}} .amaley-ui-trust-strip__items' => 'gap: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$element->add_responsive_control(
			'amaley_pts_card_direction_force',
			array(
				'label'     => esc_html__( 'Card Content Direction', 'amaley-ui-sections-kit' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'Default', 'amaley-ui-sections-kit' ),
					'row'    => esc_html__( 'Icon Side', 'amaley-ui-sections-kit' ),
					'column' => esc_html__( 'Icon Top', 'amaley-ui-sections-kit' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .amaley-ui-trust-strip__item' => 'flex-direction: {{VALUE}} !important;',
				),
			)
		);

		$element->add_responsive_control(
			'amaley_pts_card_align_force',
			array(
				'label'     => esc_html__( 'Card Text Align', 'amaley-ui-sections-kit' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ),
					'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ),
					'right'  => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .amaley-ui-trust-strip__item' => 'text-align: {{VALUE}} !important;',
				),
			)
		);
	}

	public static function add_style_sections( $element, $args ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( ! self::ready( $element ) ) {
			return;
		}

		self::section_frame( $element );
		self::intro_panel( $element );
		self::items_cards( $element );
		self::item_icon( $element );
		self::item_text( $element );
		self::responsive_style( $element );
	}

	public static function print_forced_column_css() {
		static $printed = false;

		if ( $printed ) {
			return;
		}
		$printed = true;

		$base = '.elementor-widget-amaley_ui_page_trust_strip.amaley-pts-%1$s-cols-%2$d .amaley-ui-trust-strip.amaley-ui-trust-strip .amaley-ui-trust-strip__items';
		$css  = "/* Amaley UI Sections Kit Page Trust Strip Controls v0.6.2 */\n";

		foreach ( array( 1, 2, 3, 4 ) as $cols ) {
			$css .= sprintf( $base, 'desktop', $cols ) . '{grid-template-columns:repeat(' . $cols . ',minmax(0,1fr)) !important;}' . "\n";
		}

		$css .= '@media (max-width:1024px){' . "\n";
		foreach ( array( 1, 2, 3, 4 ) as $cols ) {
			$css .= sprintf( $base, 'tablet', $cols ) . '{grid-template-columns:repeat(' . $cols . ',minmax(0,1fr)) !important;}' . "\n";
		}
		$css .= "}\n";

		$css .= '@media (max-width:767px){' . "\n";
		foreach ( array( 1, 2, 3, 4 ) as $cols ) {
			$css .= sprintf( $base, 'phone', $cols ) . '{grid-template-columns:repeat(' . $cols . ',minmax(0,1fr)) !important;}' . "\n";
		}
		$css .= "}\n";

		echo '<style id="amaley-ui-sections-kit-css">' . wp_strip_all_tags( $css ) . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	private static function section_frame( $e ) {
		$e->start_controls_section( 'amaley_pts_frame_section', array( 'label' => esc_html__( 'Section / Frame', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		self::dimensions( $e, 'amaley_pts_outer_margin', 'Outer Margin', '{{WRAPPER}} .amaley-ui-trust-strip', 'margin' );
		self::slider( $e, 'amaley_pts_inner_width', 'Inner Max Width', '{{WRAPPER}} .amaley-ui-trust-strip--width-contained .amaley-ui-trust-strip__inner', 'max-width', 720, 1600, array( 'px', '%' ) );
		self::slider( $e, 'amaley_pts_min_height', 'Frame Min Height', '{{WRAPPER}} .amaley-ui-trust-strip__inner', 'min-height', 60, 260 );
		self::color( $e, 'amaley_pts_frame_bg', 'Frame Background', '{{WRAPPER}} .amaley-ui-trust-strip__inner', 'background' );
		self::border( $e, 'amaley_pts_frame_border', '{{WRAPPER}} .amaley-ui-trust-strip__inner' );
		self::dimensions( $e, 'amaley_pts_frame_radius', 'Frame Radius', '{{WRAPPER}} .amaley-ui-trust-strip__inner', 'border-radius' );
		self::shadow( $e, 'amaley_pts_frame_shadow', '{{WRAPPER}} .amaley-ui-trust-strip__inner' );
		$e->end_controls_section();
	}

	private static function intro_panel( $e ) {
		$e->start_controls_section( 'amaley_pts_intro_section', array( 'label' => esc_html__( 'Intro Panel', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$e->add_responsive_control(
			'amaley_pts_intro_width',
			array(
				'label'      => esc_html__( 'Intro Width', 'amaley-ui-sections-kit' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 160, 'max' => 620 ) ),
				'selectors'  => array(
					'{{WRAPPER}} .amaley-ui-trust-strip__inner' => 'grid-template-columns: minmax({{SIZE}}{{UNIT}}, .58fr) minmax(0, 1.42fr);',
				),
			)
		);
		self::dimensions( $e, 'amaley_pts_intro_padding', 'Panel Padding', '{{WRAPPER}} .amaley-ui-trust-strip__intro', 'padding' );
		self::color( $e, 'amaley_pts_intro_bg', 'Panel Background', '{{WRAPPER}} .amaley-ui-trust-strip__intro', 'background' );
		self::color( $e, 'amaley_pts_intro_accent', 'Left Accent Color', '{{WRAPPER}} .amaley-ui-trust-strip__intro::after', 'background' );
		$e->add_control( 'amaley_pts_label_heading', array( 'label' => esc_html__( 'Small Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		self::typography( $e, 'amaley_pts_label_typography', '{{WRAPPER}} .amaley-ui-trust-strip__label' );
		self::color( $e, 'amaley_pts_label_color', 'Label Color', '{{WRAPPER}} .amaley-ui-trust-strip__label', 'color' );
		$e->add_control( 'amaley_pts_main_text_heading', array( 'label' => esc_html__( 'Main Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		self::typography( $e, 'amaley_pts_main_text_typography', '{{WRAPPER}} .amaley-ui-trust-strip__heading' );
		self::color( $e, 'amaley_pts_main_text_color', 'Main Text Color', '{{WRAPPER}} .amaley-ui-trust-strip__heading', 'color' );
		$e->end_controls_section();
	}

	private static function items_cards( $e ) {
		$e->start_controls_section( 'amaley_pts_cards_section', array( 'label' => esc_html__( 'Items / Cards', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		self::dimensions( $e, 'amaley_pts_items_padding', 'Items Area Padding', '{{WRAPPER}} .amaley-ui-trust-strip__items', 'padding' );
		self::slider( $e, 'amaley_pts_items_gap_style', 'Items Gap', '{{WRAPPER}} .amaley-ui-trust-strip__items', 'gap', 0, 50 );
		self::dimensions( $e, 'amaley_pts_card_padding', 'Card Padding', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'padding' );
		self::slider( $e, 'amaley_pts_card_gap', 'Icon / Text Gap', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'gap', 0, 44 );
		self::slider( $e, 'amaley_pts_card_min_height', 'Card Min Height', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'min-height', 44, 240 );
		self::color( $e, 'amaley_pts_card_bg', 'Card Background', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'background' );
		self::color( $e, 'amaley_pts_card_hover_bg', 'Hover Background', '{{WRAPPER}} .amaley-ui-trust-strip__item:hover', 'background' );
		self::border( $e, 'amaley_pts_card_border', '{{WRAPPER}} .amaley-ui-trust-strip__item' );
		self::dimensions( $e, 'amaley_pts_card_radius', 'Card Radius', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'border-radius' );
		self::shadow( $e, 'amaley_pts_card_shadow', '{{WRAPPER}} .amaley-ui-trust-strip__item' );
		$e->end_controls_section();
	}

	private static function item_icon( $e ) {
		$e->start_controls_section( 'amaley_pts_icon_section', array( 'label' => esc_html__( 'Item Icon', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		self::box_size( $e, 'amaley_pts_icon_box_size', 'Icon Box Size', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 22, 90 );
		$e->add_responsive_control(
			'amaley_pts_icon_svg_size',
			array(
				'label'      => esc_html__( 'Icon SVG Size', 'amaley-ui-sections-kit' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 8, 'max' => 48 ) ),
				'selectors'  => array(
					'{{WRAPPER}} .amaley-ui-trust-strip__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		self::color( $e, 'amaley_pts_icon_color', 'Icon Color', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 'color' );
		self::color( $e, 'amaley_pts_icon_bg', 'Icon Background', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 'background' );
		self::border( $e, 'amaley_pts_icon_border', '{{WRAPPER}} .amaley-ui-trust-strip__icon' );
		self::dimensions( $e, 'amaley_pts_icon_radius', 'Icon Radius', '{{WRAPPER}} .amaley-ui-trust-strip__icon', 'border-radius' );
		$e->end_controls_section();
	}

	private static function item_text( $e ) {
		$e->start_controls_section( 'amaley_pts_text_section', array( 'label' => esc_html__( 'Item Title & Text', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$e->add_control( 'amaley_pts_item_title_heading', array( 'label' => esc_html__( 'Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING ) );
		self::typography( $e, 'amaley_pts_item_title_typography', '{{WRAPPER}} .amaley-ui-trust-strip__item-title' );
		self::color( $e, 'amaley_pts_item_title_color', 'Title Color', '{{WRAPPER}} .amaley-ui-trust-strip__item-title', 'color' );
		$e->add_control( 'amaley_pts_item_copy_heading', array( 'label' => esc_html__( 'Short Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		self::typography( $e, 'amaley_pts_item_copy_typography', '{{WRAPPER}} .amaley-ui-trust-strip__item-text' );
		self::color( $e, 'amaley_pts_item_copy_color', 'Text Color', '{{WRAPPER}} .amaley-ui-trust-strip__item-text', 'color' );
		self::slider( $e, 'amaley_pts_item_copy_gap', 'Text Top Spacing', '{{WRAPPER}} .amaley-ui-trust-strip__item-text', 'margin-top', 0, 40 );
		$e->end_controls_section();
	}

	private static function responsive_style( $e ) {
		$e->start_controls_section( 'amaley_pts_responsive_style', array( 'label' => esc_html__( 'Responsive / Device Polish', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		self::slider( $e, 'amaley_pts_mobile_icon_gap', 'Card Gap', '{{WRAPPER}} .amaley-ui-trust-strip__item', 'gap', 0, 40 );
		self::slider( $e, 'amaley_pts_mobile_copy_size', 'Text Top Spacing', '{{WRAPPER}} .amaley-ui-trust-strip__item-text', 'margin-top', 0, 32 );
		$e->end_controls_section();
	}

	private static function column_options() {
		return array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
		);
	}

	private static function ready( $element ) {
		return class_exists( '\\Elementor\\Controls_Manager' ) && is_object( $element );
	}

	private static function color( $e, $name, $label, $selector, $property ) {
		$e->add_control( $name, array( 'label' => esc_html__( $label, 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => $property . ': {{VALUE}};' ) ) );
	}

	private static function slider( $e, $name, $label, $selector, $property, $min, $max, $units = array( 'px' ) ) {
		$e->add_responsive_control(
			$name,
			array(
				'label'      => esc_html__( $label, 'amaley-ui-sections-kit' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => $units,
				'range'      => array( 'px' => array( 'min' => $min, 'max' => $max ) ),
				'selectors'  => array( $selector => $property . ': {{SIZE}}{{UNIT}};' ),
			)
		);
	}

	private static function box_size( $e, $name, $label, $selector, $min, $max ) {
		$e->add_responsive_control(
			$name,
			array(
				'label'      => esc_html__( $label, 'amaley-ui-sections-kit' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => $min, 'max' => $max ) ),
				'selectors'  => array( $selector => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ),
			)
		);
	}

	private static function dimensions( $e, $name, $label, $selector, $property ) {
		$template = 'border-radius' === $property ? 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' : $property . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
		$e->add_responsive_control( $name, array( 'label' => esc_html__( $label, 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%', 'em', 'rem' ), 'selectors' => array( $selector => $template ) ) );
	}

	private static function border( $e, $name, $selector ) {
		if ( class_exists( '\\Elementor\\Group_Control_Border' ) ) {
			$e->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => $name, 'selector' => $selector ) );
		}
	}

	private static function shadow( $e, $name, $selector ) {
		if ( class_exists( '\\Elementor\\Group_Control_Box_Shadow' ) ) {
			$e->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => $name, 'selector' => $selector ) );
		}
	}

	private static function typography( $e, $name, $selector ) {
		if ( class_exists( '\\Elementor\\Group_Control_Typography' ) ) {
			$e->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $name, 'selector' => $selector ) );
		}
	}
}

Amaley_UI_Page_Trust_Strip_Control_Bridge::init();
