<?php
/**
 * Base Elementor widget for Amaley Compact Widgets.
 *
 * v0.4.9 cleanup rule:
 * - A control appears only where that widget's renderer actually uses it.
 * - No dummy card-button / URL / icon / meta controls on widgets that do not render those parts.
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

	protected function uses_meta() {
		return in_array( $this->renderer_method(), array( 'info_cards', 'traceability', 'process_steps', 'origin_cards', 'collection_cards', 'two_panel_info', 'image_flip_cards', 'image_cards', 'image_info_cards', 'image_overlay_cards', 'metric_tiles' ), true );
	}
	protected function uses_icon() {
		return in_array( $this->renderer_method(), array( 'info_cards', 'split_editorial', 'gifting_band', 'value_strip', 'purpose_cards', 'dark_chain', 'quote_cards', 'cta_tiles' ), true );
	}
	protected function uses_card_buttons() {
		return in_array( $this->renderer_method(), array( 'origin_cards', 'collection_cards', 'image_cards', 'cta_tiles' ), true );
	}
	protected function outputs_buttons() {
		return $this->supports_buttons() || $this->uses_card_buttons();
	}
	protected function outputs_icon_circle() {
		return in_array( $this->renderer_method(), array( 'info_cards', 'value_strip', 'dark_chain', 'quote_cards', 'cta_tiles' ), true );
	}
	protected function outputs_plain_marker_icon() {
		return in_array( $this->renderer_method(), array( 'split_editorial', 'gifting_band', 'purpose_cards' ), true );
	}

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
		$this->heading_style_controls();
		$this->card_style_controls();
		$this->image_style_controls();
		$this->button_style_controls();
		$this->motion_controls();
	}

	protected function content_controls() {
		$data = $this->def(); $defaults = $data['defaults'];
		$this->start_controls_section( 'acw_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );
		$this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'label_on' => 'Show', 'label_off' => 'Hide', 'return_value' => '1', 'default' => '1' ) );
		$this->add_control( 'style', array( 'label' => esc_html__( 'Style Variation', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'style-1', 'options' => $this->style_options() ) );
		$this->add_control( 'show_kicker', array( 'label' => esc_html__( 'Show Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
		$this->add_control( 'kicker', array( 'label' => esc_html__( 'Kicker / Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['kicker'], 'condition' => array( 'show_kicker' => '1' ) ) );
		$this->add_control( 'show_title', array( 'label' => esc_html__( 'Show Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => $defaults['title'], 'condition' => array( 'show_title' => '1' ) ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['accent'], 'condition' => array( 'show_title' => '1' ) ) );
		$this->add_control( 'show_description', array( 'label' => esc_html__( 'Show Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $defaults['description'], 'condition' => array( 'show_description' => '1' ) ) );
		if ( $this->supports_buttons() ) {
			$this->add_control( 'buttons_heading', array( 'label' => esc_html__( 'Section Buttons', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
			$this->add_control( 'show_buttons', array( 'label' => esc_html__( 'Show Button Row', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
			$this->add_control( 'show_primary_button', array( 'label' => esc_html__( 'Show Primary Button', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_buttons' => '1' ) ) );
			$this->add_control( 'button_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['button_text'], 'condition' => array( 'show_buttons' => '1', 'show_primary_button' => '1' ) ) );
			$this->add_control( 'button_url', array( 'label' => esc_html__( 'Primary Button Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ), 'condition' => array( 'show_buttons' => '1', 'show_primary_button' => '1' ) ) );
			$this->add_control( 'show_secondary_button', array( 'label' => esc_html__( 'Show Secondary Button', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_buttons' => '1' ) ) );
			$this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['secondary_text'], 'condition' => array( 'show_buttons' => '1', 'show_secondary_button' => '1' ) ) );
			$this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ), 'condition' => array( 'show_buttons' => '1', 'show_secondary_button' => '1' ) ) );
		}
		if ( $this->supports_main_media() ) {
			$this->add_control( 'media_heading', array( 'label' => esc_html__( 'Main Media', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
			$this->add_control( 'show_main_image', array( 'label' => esc_html__( 'Show Main Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
			$this->add_control( 'image_url', array( 'label' => esc_html__( 'Main Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => array( 'url' => '' ), 'condition' => array( 'show_main_image' => '1' ) ) );
			$this->add_control( 'image_alt', array( 'label' => esc_html__( 'Main Image Alt Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley product table visual', 'condition' => array( 'show_main_image' => '1' ) ) );
		}
		if ( 'traceability' === $this->renderer_method() ) {
			$this->add_control( 'trace_summary_heading', array( 'label' => esc_html__( 'Traceability Board Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
			$this->add_control( 'trace_summary_label', array( 'label' => esc_html__( 'Summary Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['trace_summary_label'] ) );
			$this->add_control( 'trace_summary_title', array( 'label' => esc_html__( 'Summary Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['trace_summary_title'] ) );
			$this->add_control( 'trace_summary_text', array( 'label' => esc_html__( 'Summary Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $defaults['trace_summary_text'] ) );
			$this->add_control( 'trace_point_start', array( 'label' => esc_html__( 'Route Point 1 Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['trace_point_start'] ) );
			$this->add_control( 'trace_point_middle', array( 'label' => esc_html__( 'Route Point 2 Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['trace_point_middle'] ) );
			$this->add_control( 'trace_point_end', array( 'label' => esc_html__( 'Route Point 3 Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['trace_point_end'] ) );
		}
		if ( 'gifting_band' === $this->renderer_method() ) {
			$this->add_control( 'gifting_panel_label', array( 'label' => esc_html__( 'Right Panel Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['gifting_panel_label'], 'separator' => 'before' ) );
		}
		if ( 'image_flip_cards' === $this->renderer_method() ) {
			$this->add_control( 'flip_back_label', array( 'label' => esc_html__( 'Flip Back Small Label', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $defaults['flip_back_label'], 'separator' => 'before' ) );
		}
		$this->end_controls_section();
	}

	protected function items_controls() {
		$data = $this->def();
		$this->start_controls_section( 'acw_items', array( 'label' => esc_html__( 'Items / Cards', 'amaley-compact-widgets' ) ) );
		$this->add_control( 'show_items', array( 'label' => esc_html__( 'Show Items / Cards', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
		$this->add_control( 'item_visibility_heading', array( 'label' => esc_html__( 'Card Element Visibility', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before', 'condition' => array( 'show_items' => '1' ) ) );
		if ( $this->uses_meta() ) {
			$this->add_control( 'show_meta', array( 'label' => esc_html__( 'Show Number / Meta', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_items' => '1' ) ) );
		}
		if ( $this->uses_icon() ) {
			$this->add_control( 'show_icon', array( 'label' => esc_html__( 'Show Icon / Marker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_items' => '1' ) ) );
		}
		$this->add_control( 'show_card_title', array( 'label' => esc_html__( 'Show Card Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_items' => '1' ) ) );
		$this->add_control( 'show_card_text', array( 'label' => esc_html__( 'Show Card Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_items' => '1' ) ) );
		if ( $this->uses_card_buttons() ) {
			$this->add_control( 'show_card_button', array( 'label' => esc_html__( 'Show Card Buttons', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_items' => '1' ) ) );
		}
		if ( $this->supports_item_images() ) {
			$this->add_control( 'show_images', array( 'label' => esc_html__( 'Show Card Images', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'condition' => array( 'show_items' => '1' ) ) );
		}

		$rep = new \Elementor\Repeater();
		if ( $this->uses_meta() ) {
			$rep->add_control( 'number', array( 'label' => esc_html__( 'Number / Meta', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ) );
		}
		if ( $this->uses_icon() ) {
			$rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon / Marker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✦' ) );
		}
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
		if ( $this->uses_card_buttons() ) {
			$rep->add_control( 'button_text', array( 'label' => esc_html__( 'Card Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
			$rep->add_control( 'url', array( 'label' => esc_html__( 'Card Button Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		}
		$this->add_control( 'items', array( 'label' => esc_html__( 'Items', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}', 'default' => $data['items'], 'condition' => array( 'show_items' => '1' ) ) );
		$this->end_controls_section();
	}

	protected function layout_controls() {
		$data = $this->def(); $defaults = $data['defaults'];
		$this->start_controls_section( 'acw_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );
		$this->add_control( 'alignment_system_note', array( 'label' => esc_html__( 'Alignment Controls', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_responsive_control( 'header_align', array(
			'label' => esc_html__( 'Header Alignment', 'amaley-compact-widgets' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'default' => '',
			'options' => array(
				'left'   => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ),
				'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ),
				'right'  => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ),
			),
			'description' => esc_html__( 'Controls only the section heading. Leave unselected for the widget default.', 'amaley-compact-widgets' ),
			'selectors_dictionary' => array(
				'left'   => 'text-align:left; margin-left:0; margin-right:auto;',
				'center' => 'text-align:center; margin-left:auto; margin-right:auto;',
				'right'  => 'text-align:right; margin-left:auto; margin-right:0;',
			),
			'selectors' => array(
				'{{WRAPPER}} .amaley-cw4-head' => '{{VALUE}}',
				'{{WRAPPER}} .amaley-cw4-head .amaley-cw4-desc' => '{{VALUE}}',
			),
		) );
		$this->add_responsive_control( 'card_align', array( 'label' => esc_html__( 'Card Text Alignment', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'default' => 'left', 'options' => array( 'left' => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-card, {{WRAPPER}} .amaley-cw4 article' => 'text-align: {{VALUE}};' ) ) );
		if ( $this->supports_buttons() ) {
			$this->add_responsive_control( 'button_align', array( 'label' => esc_html__( 'Section Button Alignment', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'default' => 'flex-start', 'options' => array( 'flex-start' => array( 'title' => 'Left', 'icon' => 'eicon-align-start-h' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-align-center-h' ), 'flex-end' => array( 'title' => 'Right', 'icon' => 'eicon-align-end-h' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-actions' => 'justify-content: {{VALUE}};' ) ) );
		}
		if ( $this->supports_columns() ) {
			$this->add_responsive_control( 'columns', array( 'label' => esc_html__( 'Columns', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $defaults['columns'], 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-grid, {{WRAPPER}} .amaley-cw4-values-row, {{WRAPPER}} .amaley-cw4-purpose-grid, {{WRAPPER}} .amaley-cw4-panels' => '--acw4-cols: {{VALUE}};' ) ) );
		}
		if ( $this->supports_media_side() ) {
			$this->add_control( 'image_side', array( 'label' => esc_html__( 'Image Side', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'left', 'options' => array( 'left' => 'Image Left / Text Right', 'right' => 'Text Left / Image Right' ) ) );
		}
		$this->add_responsive_control( 'gap', array( 'label' => esc_html__( 'Item / Panel Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-grid, {{WRAPPER}} .amaley-cw4-trace-shell, {{WRAPPER}} .amaley-cw4-story-shell, {{WRAPPER}} .amaley-cw4-gift-shell, {{WRAPPER}} .amaley-cw4-values-row, {{WRAPPER}} .amaley-cw4-purpose-grid, {{WRAPPER}} .amaley-cw4-panels' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function section_style_controls() {
		$this->start_controls_section( 'acw_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'section_border_color', array( 'label' => esc_html__( 'Top Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4' => 'border-top-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 640, 'max' => 1680 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function heading_style_controls() {
		$this->start_controls_section( 'acw_heading_style', array( 'label' => esc_html__( 'Heading / Text', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'heading_gap', array( 'label' => esc_html__( 'Heading Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-head' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-kicker' ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Word Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-title em' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'text_color', array( 'label' => esc_html__( 'Body Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-desc, {{WRAPPER}} .amaley-cw4 p' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'body_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-desc, {{WRAPPER}} .amaley-cw4 p' ) );
		$this->end_controls_section();
	}

	protected function card_style_controls() {
		$this->start_controls_section( 'acw_card_style', array( 'label' => esc_html__( 'Cards / Items', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$card_selector = '{{WRAPPER}} .amaley-cw4-card, {{WRAPPER}} .amaley-cw4-icon-card, {{WRAPPER}} .amaley-cw4-process-card, {{WRAPPER}} .amaley-cw4-image-card, {{WRAPPER}} .amaley-cw4-info-image-card, {{WRAPPER}} .amaley-cw4-panels article, {{WRAPPER}} .amaley-cw4-quote, {{WRAPPER}} .amaley-cw4-cta, {{WRAPPER}} .amaley-cw4-metric, {{WRAPPER}} .amaley-cw4-route article, {{WRAPPER}} .amaley-cw4-story-lines article, {{WRAPPER}} .amaley-cw4-gift-panel article, {{WRAPPER}} .amaley-cw4-values-row article, {{WRAPPER}} .amaley-cw4-purpose-grid article, {{WRAPPER}} .amaley-cw4-overlay-card, {{WRAPPER}} .amaley-cw4-flip-front, {{WRAPPER}} .amaley-cw4-flip-back';
		$this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card_selector => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'card_border', array( 'label' => esc_html__( 'Card Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card_selector => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $card_selector => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( $card_selector . ', {{WRAPPER}} .amaley-cw4-image-card-body, {{WRAPPER}} .amaley-cw4-info-image-card>div, {{WRAPPER}} .amaley-cw4-overlay-card>div, {{WRAPPER}} .amaley-cw4-flip-front>div:not(.amaley-cw4-photo), {{WRAPPER}} .amaley-cw4-flip-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_min_height', array( 'label' => esc_html__( 'Card Minimum Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 640 ) ), 'selectors' => array( $card_selector => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => $card_selector ) );
		$this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4 h3' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'selector' => '{{WRAPPER}} .amaley-cw4 h3' ) );
		if ( $this->uses_meta() ) {
			$this->add_control( 'meta_color', array( 'label' => esc_html__( 'Number / Meta Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-meta, {{WRAPPER}} .amaley-cw4-route article > span, {{WRAPPER}} .amaley-cw4-process-card span, {{WRAPPER}} .amaley-cw4-panels span, {{WRAPPER}} .amaley-cw4-overlay-card span, {{WRAPPER}} .amaley-cw4-flip-front span, {{WRAPPER}} .amaley-cw4-metric strong' => 'color: {{VALUE}};' ) ) );
			$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-meta, {{WRAPPER}} .amaley-cw4-route article > span, {{WRAPPER}} .amaley-cw4-process-card span, {{WRAPPER}} .amaley-cw4-panels span, {{WRAPPER}} .amaley-cw4-overlay-card span, {{WRAPPER}} .amaley-cw4-flip-front span, {{WRAPPER}} .amaley-cw4-metric strong' ) );
		}
		if ( $this->uses_icon() ) {
			$icon_selector = '{{WRAPPER}} .amaley-cw4-icon, {{WRAPPER}} .amaley-cw4-story-lines article > span, {{WRAPPER}} .amaley-cw4-gift-panel article > span, {{WRAPPER}} .amaley-cw4-purpose-grid article > span';
			$this->add_control( 'icon_bg', array( 'label' => esc_html__( 'Icon / Marker Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $icon_selector => 'background: {{VALUE}};' ) ) );
			$this->add_control( 'icon_color', array( 'label' => esc_html__( 'Icon / Marker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $icon_selector => 'color: {{VALUE}};' ) ) );
			$this->add_responsive_control( 'icon_size', array( 'label' => esc_html__( 'Icon / Marker Size', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 20, 'max' => 100 ) ), 'selectors' => array( $icon_selector => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; display: inline-flex; align-items: center; justify-content: center; border-radius: 999px;' ) ) );
		}
		$this->end_controls_section();
	}

	protected function image_style_controls() {
		if ( ! $this->supports_main_media() && ! $this->supports_item_images() ) { return; }
		$this->start_controls_section( 'acw_images', array( 'label' => esc_html__( 'Images / Media', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 760 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-photo' => 'min-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover'=>'Cover','contain'=>'Contain','fill'=>'Fill' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-photo img' => 'object-fit: {{VALUE}};' ) ) );
		$this->add_control( 'image_position', array( 'label' => esc_html__( 'Image Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => array( 'center center'=>'Center Center','center top'=>'Center Top','center bottom'=>'Center Bottom','left center'=>'Left Center','right center'=>'Right Center' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-photo img' => 'object-position: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-photo' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'image_shadow', 'selector' => '{{WRAPPER}} .amaley-cw4-photo' ) );
		$this->end_controls_section();
	}

	protected function button_style_controls() {
		if ( ! $this->outputs_buttons() ) { return; }
		$this->start_controls_section( 'acw_buttons', array( 'label' => esc_html__( 'Buttons', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .amaley-cw4-btn' ) );
		$this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_bg', array( 'label' => esc_html__( 'Button Hover Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_color', array( 'label' => esc_html__( 'Button Hover Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn:hover' => 'color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-cw4-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function motion_controls() {
		$this->start_controls_section( 'acw_motion_style', array( 'label' => esc_html__( 'Motion', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'disable_hover_mobile', array( 'label' => esc_html__( 'Reduce Motion on Mobile', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'acw-reduce-mobile-motion', 'prefix_class' => '' ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( class_exists( 'Amaley_CW_Plugin' ) ) { Amaley_CW_Plugin::instance()->enqueue_assets(); }
		echo call_user_func( array( 'Amaley_CW_Renderer', $this->renderer_method() ), $settings );
	}
}
