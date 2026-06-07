<?php
/**
 * Dedicated Dual Section Heading Elementor widget.
 *
 * This widget intentionally does not extend the generic card base widget because
 * it must expose heading-only controls with no card, item, image, grid or button panels.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

final class Amaley_CW_Dual_Heading_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'amaley_cw_dual_heading'; }
	public function get_title() { return esc_html__( 'Amaley Dual Section Heading', 'amaley-compact-widgets' ); }
	public function get_icon() { return 'eicon-heading'; }
	public function get_categories() { return array( 'amaley-compact' ); }
	public function get_style_depends() { return array( 'amaley-compact-widgets' ); }
	public function get_keywords() { return array( 'amaley', 'dual', 'heading', 'section', 'kicker', 'accent' ); }

	protected function register_controls() {
		$this->content_controls();
		$this->layout_controls();
		$this->section_style_controls();
		$this->kicker_style_controls();
		$this->heading_style_controls();
		$this->accent_style_controls();
		$this->description_style_controls();
	}

	protected function content_controls() {
		$this->start_controls_section( 'acw_dh_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );

		$this->add_control( 'show_section', array(
			'label'        => esc_html__( 'Show Section', 'amaley-compact-widgets' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'amaley-compact-widgets' ),
			'label_off'    => esc_html__( 'Hide', 'amaley-compact-widgets' ),
			'return_value' => '1',
			'default'      => '1',
		) );

		$this->add_control( 'style', array(
			'label'   => esc_html__( 'Style Variation', 'amaley-compact-widgets' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'style-1',
			'options' => array(
				'style-1' => esc_html__( 'Elegant Centered', 'amaley-compact-widgets' ),
				'style-2' => esc_html__( 'Compact Left', 'amaley-compact-widgets' ),
				'style-3' => esc_html__( 'Editorial Wide', 'amaley-compact-widgets' ),
			),
		) );

		$this->add_control( 'show_kicker', array(
			'label'        => esc_html__( 'Show Kicker', 'amaley-compact-widgets' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => '1',
			'default'      => '1',
			'separator'    => 'before',
		) );
		$this->add_control( 'kicker', array(
			'label'     => esc_html__( 'Kicker Text', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( 'WHAT PEOPLE LOVE', 'amaley-compact-widgets' ),
			'condition' => array( 'show_kicker' => '1' ),
		) );

		$this->add_control( 'show_heading', array(
			'label'        => esc_html__( 'Show Heading', 'amaley-compact-widgets' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => '1',
			'default'      => '1',
			'separator'    => 'before',
		) );
		$this->add_control( 'heading_part_one', array(
			'label'     => esc_html__( 'Heading Part One', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( 'Bestselling', 'amaley-compact-widgets' ),
			'condition' => array( 'show_heading' => '1' ),
		) );
		$this->add_control( 'show_accent', array(
			'label'        => esc_html__( 'Show Accent Text', 'amaley-compact-widgets' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => '1',
			'default'      => '1',
			'condition'    => array( 'show_heading' => '1' ),
		) );
		$this->add_control( 'accent_text', array(
			'label'     => esc_html__( 'Accent Text', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => esc_html__( 'Products', 'amaley-compact-widgets' ),
			'condition' => array( 'show_heading' => '1', 'show_accent' => '1' ),
		) );
		$this->add_control( 'accent_position', array(
			'label'     => esc_html__( 'Accent Position', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'after',
			'options'   => array(
				'after'   => esc_html__( 'After Main Text', 'amaley-compact-widgets' ),
				'before'  => esc_html__( 'Before Main Text', 'amaley-compact-widgets' ),
				'newline' => esc_html__( 'New Line', 'amaley-compact-widgets' ),
			),
			'condition' => array( 'show_heading' => '1', 'show_accent' => '1' ),
		) );
		$this->add_control( 'html_tag', array(
			'label'     => esc_html__( 'HTML Tag', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'h2',
			'options'   => array( 'h1'=>'H1', 'h2'=>'H2', 'h3'=>'H3', 'h4'=>'H4', 'h5'=>'H5', 'h6'=>'H6', 'div'=>'DIV' ),
			'condition' => array( 'show_heading' => '1' ),
		) );

		$this->add_control( 'show_description', array(
			'label'        => esc_html__( 'Show Description', 'amaley-compact-widgets' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => '1',
			'default'      => '1',
			'separator'    => 'before',
		) );
		$this->add_control( 'description', array(
			'label'     => esc_html__( 'Description', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::TEXTAREA,
			'rows'      => 3,
			'default'   => esc_html__( 'Discover Amaley products loved for their honest ingredients, small-batch preparation and Himalayan identity.', 'amaley-compact-widgets' ),
			'condition' => array( 'show_description' => '1' ),
		) );

		$this->end_controls_section();
	}

	protected function layout_controls() {
		$this->start_controls_section( 'acw_dh_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );

		$this->add_responsive_control( 'align', array(
			'label'     => esc_html__( 'Alignment', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'default'   => 'center',
			'options'   => array(
				'left'   => array( 'title' => esc_html__( 'Left', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-left' ),
				'center' => array( 'title' => esc_html__( 'Center', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-center' ),
				'right'  => array( 'title' => esc_html__( 'Right', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-right' ),
			),
			'selectors_dictionary' => array(
				'left'   => 'text-align:left; --acw4-dh-inner-ml:0; --acw4-dh-inner-mr:auto; --acw4-dh-desc-ml:0; --acw4-dh-desc-mr:auto;',
				'center' => 'text-align:center; --acw4-dh-inner-ml:auto; --acw4-dh-inner-mr:auto; --acw4-dh-desc-ml:auto; --acw4-dh-desc-mr:auto;',
				'right'  => 'text-align:right; --acw4-dh-inner-ml:auto; --acw4-dh-inner-mr:0; --acw4-dh-desc-ml:auto; --acw4-dh-desc-mr:0;',
			),
			'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading' => '{{VALUE}}' ),
		) );

		$this->add_responsive_control( 'description_align', array(
			'label'     => esc_html__( 'Description Alignment', 'amaley-compact-widgets' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'default'   => 'center',
			'options'   => array(
				'left'   => array( 'title' => esc_html__( 'Left', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-left' ),
				'center' => array( 'title' => esc_html__( 'Center', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-center' ),
				'right'  => array( 'title' => esc_html__( 'Right', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-right' ),
			),
			'condition' => array( 'show_description' => '1' ),
			'selectors_dictionary' => array(
				'left'   => 'text-align:left; margin-left:0; margin-right:auto;',
				'center' => 'text-align:center; margin-left:auto; margin-right:auto;',
				'right'  => 'text-align:right; margin-left:auto; margin-right:0;',
			),
			'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-desc' => '{{VALUE}}' ),
		) );

		$this->add_responsive_control( 'content_max_width', array(
			'label'      => esc_html__( 'Content Max Width', 'amaley-compact-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 320, 'max' => 1400 ) ),
			'default'    => array( 'size' => 900, 'unit' => 'px' ),
			'selectors'  => array( '{{WRAPPER}} .amaley-cw4-dual-heading-inner' => 'max-width: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'section_padding', array(
			'label'      => esc_html__( 'Section Padding', 'amaley-compact-widgets' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', 'em', '%' ),
			'selectors'  => array( '{{WRAPPER}} .amaley-cw4-dual-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'kicker_title_gap', array(
			'label'      => esc_html__( 'Kicker to Title Gap', 'amaley-compact-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px', 'em' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
			'selectors'  => array( '{{WRAPPER}} .amaley-cw4-dual-heading-kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'accent_gap', array(
			'label'      => esc_html__( 'Main / Accent Gap', 'amaley-compact-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px', 'em' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
			'selectors'  => array(
				'{{WRAPPER}} .amaley-cw4-dual-heading-title--after .amaley-cw4-dual-heading-accent'  => 'margin-left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .amaley-cw4-dual-heading-title--before .amaley-cw4-dual-heading-accent' => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .amaley-cw4-dual-heading-title--newline .amaley-cw4-dual-heading-accent' => 'margin-top: {{SIZE}}{{UNIT}};',
			),
		) );

		$this->add_responsive_control( 'title_description_gap', array(
			'label'      => esc_html__( 'Title to Description Gap', 'amaley-compact-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px', 'em' ),
			'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
			'selectors'  => array( '{{WRAPPER}} .amaley-cw4-dual-heading-desc' => 'margin-top: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_responsive_control( 'description_max_width', array(
			'label'      => esc_html__( 'Description Max Width', 'amaley-compact-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 260, 'max' => 1100 ) ),
			'default'    => array( 'size' => 560, 'unit' => 'px' ),
			'selectors'  => array( '{{WRAPPER}} .amaley-cw4-dual-heading-desc' => 'max-width: {{SIZE}}{{UNIT}};' ),
		) );

		$this->end_controls_section();
	}

	protected function section_style_controls() {
		$this->start_controls_section( 'acw_dh_section_style', array( 'label' => esc_html__( 'Section', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading' => 'background: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function kicker_style_controls() {
		$this->start_controls_section( 'acw_dh_kicker_style', array( 'label' => esc_html__( 'Kicker', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-dual-heading-kicker' ) );
		$this->add_responsive_control( 'kicker_letter_spacing', array( 'label' => esc_html__( 'Letter Spacing', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'em' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 20 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-kicker' => 'letter-spacing: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'kicker_transform', array( 'label' => esc_html__( 'Text Transform', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'uppercase', 'options' => array( 'none'=>'None', 'uppercase'=>'Uppercase', 'lowercase'=>'Lowercase', 'capitalize'=>'Capitalize' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-kicker' => 'text-transform: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function heading_style_controls() {
		$this->start_controls_section( 'acw_dh_heading_style', array( 'label' => esc_html__( 'Main Heading', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'heading_color', array( 'label' => esc_html__( 'Main Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-main' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-dual-heading-title' ) );
		$this->add_responsive_control( 'heading_size', array( 'label' => esc_html__( 'Font Size', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'em' ), 'range' => array( 'px' => array( 'min' => 20, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-title' => 'font-size: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'heading_line_height', array( 'label' => esc_html__( 'Line Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'em', 'px' ), 'range' => array( 'em' => array( 'min' => 0.8, 'max' => 2, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-title' => 'line-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'heading_letter_spacing', array( 'label' => esc_html__( 'Letter Spacing', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'em' ), 'range' => array( 'px' => array( 'min' => -5, 'max' => 20 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-title' => 'letter-spacing: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function accent_style_controls() {
		$this->start_controls_section( 'acw_dh_accent_style', array( 'label' => esc_html__( 'Accent Text', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-accent' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-dual-heading-accent' ) );
		$this->add_control( 'accent_font_style', array( 'label' => esc_html__( 'Font Style', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'italic', 'options' => array( 'normal'=>'Normal', 'italic'=>'Italic' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-accent' => 'font-style: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function description_style_controls() {
		$this->start_controls_section( 'acw_dh_description_style', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-desc' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-dual-heading-desc' ) );
		$this->add_responsive_control( 'description_line_height', array( 'label' => esc_html__( 'Line Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'em', 'px' ), 'range' => array( 'em' => array( 'min' => 0.8, 'max' => 2.5, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-dual-heading-desc' => 'line-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		if ( class_exists( 'Amaley_CW_Plugin' ) ) {
			Amaley_CW_Plugin::instance()->enqueue_assets();
		}
		echo Amaley_CW_Renderer::dual_heading( $this->get_settings_for_display() );
	}
}
