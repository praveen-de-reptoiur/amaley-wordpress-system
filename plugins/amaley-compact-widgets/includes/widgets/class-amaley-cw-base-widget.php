<?php
/**
 * Base Elementor widget for Amaley Compact Widgets.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

abstract class Amaley_CW_Base_Widget extends \Elementor\Widget_Base {
	abstract protected function widget_key();
	abstract protected function renderer_method();
	abstract protected function widget_title();

	protected function def() { return Amaley_CW_Renderer::elementor_defaults( $this->renderer_method() ); }
	protected function supports_columns() { $d = Amaley_CW_Renderer::widget_definitions(); return ! empty( $d[ $this->renderer_method() ]['supports_columns'] ); }
	protected function supports_main_media() { $d = Amaley_CW_Renderer::widget_definitions(); return ! empty( $d[ $this->renderer_method() ]['supports_main_media'] ); }
	protected function supports_media_side() { $d = Amaley_CW_Renderer::widget_definitions(); return ! empty( $d[ $this->renderer_method() ]['supports_media_side'] ); }
	protected function supports_item_images() { $d = Amaley_CW_Renderer::widget_definitions(); return ! empty( $d[ $this->renderer_method() ]['supports_item_images'] ); }
	protected function supports_buttons() { $d = Amaley_CW_Renderer::widget_definitions(); return ! empty( $d[ $this->renderer_method() ]['supports_buttons'] ); }
	protected function supports_flip() { $d = Amaley_CW_Renderer::widget_definitions(); return ! empty( $d[ $this->renderer_method() ]['supports_flip'] ); }
	protected function style_options() { $d = Amaley_CW_Renderer::widget_definitions(); return $d[ $this->renderer_method() ]['styles'] ?? array( 'style-1' => 'Style 1' ); }

	public function get_name() { return $this->widget_key(); }
	public function get_title() { return $this->widget_title(); }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return array( 'amaley-compact' ); }
	public function get_style_depends() { return array( 'amaley-compact-widgets' ); }
	public function get_keywords() { return array( 'amaley', 'compact', 'cards', 'himalayan', 'section' ); }

	protected function register_controls() {
		$this->content_controls();
		$this->items_controls();
		$this->layout_controls();
		$this->section_style_controls();
		$this->typography_controls();
		$this->card_style_controls();
		$this->image_style_controls();
		$this->button_style_controls();
	}

	protected function content_controls() {
		$data = $this->def(); $defaults = $data['defaults'];
		$this->start_controls_section( 'acw_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );
		$this->add_control( 'style', array( 'label' => esc_html__( 'Style Variation', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'style-1', 'options' => $this->style_options() ) );
		$this->add_control( 'kicker', array( 'label' => esc_html__( 'Kicker / Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['kicker'] ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => $defaults['title'] ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['accent'] ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $defaults['description'] ) );
		if ( $this->supports_buttons() ) {
			$this->add_control( 'button_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['button_text'] ) );
			$this->add_control( 'button_url', array( 'label' => esc_html__( 'Primary Button Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
			$this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['secondary_text'] ) );
			$this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		}
		if ( $this->supports_main_media() ) {
			$this->add_control( 'image_url', array( 'label' => esc_html__( 'Main Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => array( 'url' => '' ) ) );
			$this->add_control( 'image_alt', array( 'label' => esc_html__( 'Main Image Alt Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley product table visual' ) );
		}
		$this->end_controls_section();
	}

	protected function items_controls() {
		$data = $this->def();
		$this->start_controls_section( 'acw_items', array( 'label' => esc_html__( 'Items / Cards', 'amaley-compact-widgets' ) ) );
		$rep = new \Elementor\Repeater();
		$rep->add_control( 'number', array( 'label' => esc_html__( 'Number / Meta', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ) );
		$rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon / Mark', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✦' ) );
		$rep->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley card' ) );
		$rep->add_control( 'text', array( 'label' => esc_html__( 'Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Short helpful text for this card.' ) );
		if ( $this->supports_item_images() ) {
			$rep->add_control( 'image_url', array( 'label' => esc_html__( 'Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => array( 'url' => '' ) ) );
			$rep->add_control( 'image_alt', array( 'label' => esc_html__( 'Image Alt', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley visual' ) );
		}
		if ( $this->supports_flip() ) {
			$rep->add_control( 'back_title', array( 'label' => esc_html__( 'Back Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Why it matters' ) );
			$rep->add_control( 'back_text', array( 'label' => esc_html__( 'Back Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Add the deeper explanation here.' ) );
		}
		$rep->add_control( 'button_text', array( 'label' => esc_html__( 'Card Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
		$rep->add_control( 'url', array( 'label' => esc_html__( 'Card Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'items', array( 'label' => esc_html__( 'Items', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}', 'default' => $data['items'] ) );
		$this->end_controls_section();
	}

	protected function layout_controls() {
		$data = $this->def(); $defaults = $data['defaults'];
		$this->start_controls_section( 'acw_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );
		$this->add_responsive_control( 'align', array( 'label' => esc_html__( 'Content Alignment', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'default' => $defaults['align'], 'options' => array( 'left' => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4' => 'text-align: {{VALUE}};' ) ) );
		if ( $this->supports_columns() ) {
			$this->add_responsive_control( 'columns', array( 'label' => esc_html__( 'Columns', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $defaults['columns'], 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-grid' => '--acw4-cols: {{VALUE}};' ) ) );
		}
		if ( $this->supports_media_side() ) {
			$this->add_control( 'image_side', array( 'label' => esc_html__( 'Image Side', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'left', 'options' => array( 'left' => 'Image Left / Text Right', 'right' => 'Text Left / Image Right' ) ) );
		}
		$this->add_responsive_control( 'gap', array( 'label' => esc_html__( 'Item Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-grid, {{WRAPPER}} .amaley-cw4-split, {{WRAPPER}} .amaley-cw4-trace, {{WRAPPER}} .amaley-cw4-band, {{WRAPPER}} .amaley-cw4-panels' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function section_style_controls() {
		$this->start_controls_section( 'acw_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 700, 'max' => 1500 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function typography_controls() {
		$this->start_controls_section( 'acw_typography', array( 'label' => esc_html__( 'Typography', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-kicker, {{WRAPPER}} .amaley-cw4-meta' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-kicker, {{WRAPPER}} .amaley-cw4-meta' ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Word Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-title em' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'text_color', array( 'label' => esc_html__( 'Body Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-desc, {{WRAPPER}} .amaley-cw4 p' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'body_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-desc, {{WRAPPER}} .amaley-cw4 p' ) );
		$this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4 h3' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'selector' => '{{WRAPPER}} .amaley-cw4 h3' ) );
		$this->end_controls_section();
	}

	protected function card_style_controls() {
		$this->start_controls_section( 'acw_card_style', array( 'label' => esc_html__( 'Cards / Items', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$card_selector = '{{WRAPPER}} .amaley-cw4-card, {{WRAPPER}} .amaley-cw4-icon-card, {{WRAPPER}} .amaley-cw4-process-card, {{WRAPPER}} .amaley-cw4-image-card, {{WRAPPER}} .amaley-cw4-info-image-card, {{WRAPPER}} .amaley-cw4-panels article, {{WRAPPER}} .amaley-cw4-quote, {{WRAPPER}} .amaley-cw4-cta, {{WRAPPER}} .amaley-cw4-metric, {{WRAPPER}} .amaley-cw4-route article';
		$this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card_selector => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'card_border', array( 'label' => esc_html__( 'Card Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card_selector => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( $card_selector => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( $card_selector . ', {{WRAPPER}} .amaley-cw4-image-card-body, {{WRAPPER}} .amaley-cw4-info-image-card>div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => $card_selector ) );
		$this->end_controls_section();
	}

	protected function image_style_controls() {
		if ( ! $this->supports_main_media() && ! $this->supports_item_images() ) { return; }
		$this->start_controls_section( 'acw_images', array( 'label' => esc_html__( 'Images / Media', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 120, 'max' => 720 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-photo' => 'min-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'image_position', array( 'label' => esc_html__( 'Image Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => array( 'center center'=>'Center Center','center top'=>'Center Top','center bottom'=>'Center Bottom','left center'=>'Left Center','right center'=>'Right Center' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-photo img' => 'object-position: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-photo' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'image_shadow', 'selector' => '{{WRAPPER}} .amaley-cw4-photo' ) );
		$this->end_controls_section();
	}

	protected function button_style_controls() {
		if ( ! $this->supports_buttons() ) { return; }
		$this->start_controls_section( 'acw_buttons', array( 'label' => esc_html__( 'Buttons', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-btn' ) );
		$this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn' => 'color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( class_exists( 'Amaley_CW_Plugin' ) ) { Amaley_CW_Plugin::instance()->enqueue_assets(); }
		echo call_user_func( array( 'Amaley_CW_Renderer', $this->renderer_method() ), $settings );
	}
}
