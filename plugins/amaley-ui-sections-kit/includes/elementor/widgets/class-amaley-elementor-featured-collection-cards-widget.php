<?php
/**
 * Elementor Featured Collection Cards widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

/**
 * Elementor-native widget for featured collection cards.
 */
final class Amaley_Elementor_Featured_Collection_Cards_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'amaley_ui_featured_collection_cards';
	}

	public function get_title() {
		return esc_html__( 'Amaley Featured Collection Cards', 'amaley-ui-sections-kit' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'amaley-ui', 'general' );
	}

	public function get_keywords() {
		return array( 'amaley', 'featured', 'collection', 'cards', 'gifting', 'wellness' );
	}

	public function get_style_depends() {
		return array( 'amaley-ui-sections-kit', 'amaley-ui-featured-collection-cards' );
	}

	protected function register_controls() {
		$this->content_controls();
		$this->visibility_controls();
		$this->style_controls();
	}

	private function content_controls() {
		$this->start_controls_section( 'afcc_content', array( 'label' => esc_html__( 'Section Content', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'eyebrow', array( 'label' => esc_html__( 'Eyebrow / Small Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Featured collections', 'label_block' => true ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Collections by {why you are buying}', 'rows' => 2, 'label_block' => true ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word / Phrase', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'why you are buying', 'description' => esc_html__( 'Wrap the accent inside title with { }. Example: Collections by {why you are buying}', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Choose a collection route that matches the moment — everyday pantry, wellness routines, hospitality tables, or gifting needs.', 'rows' => 4 ) );
		$this->add_control( 'tone', array( 'label' => esc_html__( 'Tone', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cream', 'options' => array( 'cream' => 'Warm Cream', 'white' => 'Soft White', 'deep' => 'Deep Chocolate' ) ) );
		$this->add_control( 'width', array( 'label' => esc_html__( 'Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'contained', 'options' => array( 'contained' => 'Contained', 'full' => 'Full Width' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'afcc_cards', array( 'label' => esc_html__( 'Collection Cards', 'amaley-ui-sections-kit' ) ) );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'tone', array( 'label' => esc_html__( 'Card Tone', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'light', 'options' => array( 'light' => 'Light Card', 'deep' => 'Dark CTA Card', 'accent' => 'Accent Card' ) ) );
		$repeater->add_control( 'kicker', array( 'label' => esc_html__( 'Card Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Breakfast & Pantry', 'label_block' => true ) );
		$repeater->add_control( 'title', array( 'label' => esc_html__( 'Card Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Daily jars, mixes, staples, and table-ready products.', 'rows' => 3, 'label_block' => true ) );
		$repeater->add_control( 'description', array( 'label' => esc_html__( 'Card Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'A practical route for repeat buying, home kitchens, and everyday food shelves.', 'rows' => 4 ) );
		$repeater->add_control( 'meta', array( 'label' => esc_html__( 'Meta / Footer Note', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Good for regular household use', 'label_block' => true ) );
		$repeater->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Collection' ) );
		$repeater->add_control( 'button_url', array( 'label' => esc_html__( 'Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__( 'Cards', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => Amaley_UI_Featured_Collection_Cards::default_cards(),
				'title_field' => '{{{ kicker }}}',
			)
		);
		$this->end_controls_section();
	}

	private function add_device_hide_control( $id, $label, $selector, $separator = '' ) {
		$args = array(
			'label'        => esc_html__( $label, 'amaley-ui-sections-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'selectors'    => array( $selector => 'display:none !important;' ),
		);
		if ( '' !== $separator ) {
			$args['separator'] = $separator;
		}
		$this->add_responsive_control( $id, $args );
	}

	private function visibility_controls() {
		$this->start_controls_section( 'afcc_visibility', array( 'label' => esc_html__( 'Visibility (Device Wise)', 'amaley-ui-sections-kit' ) ) );
		$this->add_device_hide_control( 'hide_eyebrow', 'Hide Eyebrow on Device', '{{WRAPPER}} .amaley-featured-collection-cards__eyebrow' );
		$this->add_device_hide_control( 'hide_title', 'Hide Title on Device', '{{WRAPPER}} .amaley-featured-collection-cards__title' );
		$this->add_device_hide_control( 'hide_accent', 'Hide Accent on Device', '{{WRAPPER}} .amaley-featured-collection-cards__title em' );
		$this->add_device_hide_control( 'hide_description', 'Hide Description on Device', '{{WRAPPER}} .amaley-featured-collection-cards__description' );
		$this->add_device_hide_control( 'hide_grid', 'Hide Cards Grid on Device', '{{WRAPPER}} .amaley-featured-collection-cards__grid', 'before' );
		$this->add_device_hide_control( 'hide_card_kickers', 'Hide Card Labels on Device', '{{WRAPPER}} .amaley-featured-collection-cards__card-kicker' );
		$this->add_device_hide_control( 'hide_card_titles', 'Hide Card Titles on Device', '{{WRAPPER}} .amaley-featured-collection-cards__card-title' );
		$this->add_device_hide_control( 'hide_card_texts', 'Hide Card Text on Device', '{{WRAPPER}} .amaley-featured-collection-cards__card-description' );
		$this->add_device_hide_control( 'hide_card_meta', 'Hide Card Meta / Footer Notes on Device', '{{WRAPPER}} .amaley-featured-collection-cards__card-meta' );
		$this->add_device_hide_control( 'hide_card_buttons', 'Hide Card Buttons on Device', '{{WRAPPER}} .amaley-featured-collection-cards__card-button' );
		$this->end_controls_section();
	}

	private function style_controls() {
		$this->section_style_controls();
		$this->layout_style_controls();
		$this->typography_style_controls();
		$this->card_style_controls();
		$this->button_style_controls();
	}

	private function section_style_controls() {
		$this->start_controls_section( 'afcc_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'section_text_color', array( 'label' => esc_html__( 'Base Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards' => 'color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'section_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 760, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function layout_style_controls() {
		$this->start_controls_section( 'afcc_layout_style', array( 'label' => esc_html__( 'Layout', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'header_columns', array( 'label' => esc_html__( 'Header Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'minmax(240px,.58fr) minmax(320px,.72fr)', 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__header' => 'grid-template-columns: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'header_gap', array( 'label' => esc_html__( 'Header Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__header' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'header_bottom_spacing', array( 'label' => esc_html__( 'Header Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__header' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'grid_columns', array( 'label' => esc_html__( 'Card Grid Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => 'Default', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
		$this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Card Grid Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'text_alignment', array( 'label' => esc_html__( 'Text Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__heading, {{WRAPPER}} .amaley-featured-collection-cards__description' => 'text-align: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	private function typography_style_controls() {
		$this->start_controls_section( 'afcc_typography_style', array( 'label' => esc_html__( 'Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'eyebrow_color', array( 'label' => esc_html__( 'Eyebrow Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__eyebrow' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'eyebrow_typography', 'label' => esc_html__( 'Eyebrow Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__eyebrow' ) );
		$this->add_responsive_control( 'eyebrow_spacing', array( 'label' => esc_html__( 'Eyebrow Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__title' ) );
		$this->add_responsive_control( 'title_max_width', array( 'label' => esc_html__( 'Title Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 240, 'max' => 1100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__title' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__title em' ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__description' ) );
		$this->add_responsive_control( 'description_max_width', array( 'label' => esc_html__( 'Description Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 900 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__description' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function card_style_controls() {
		$this->start_controls_section( 'afcc_card_style', array( 'label' => esc_html__( 'Cards / Items', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'light_card_bg', array( 'label' => esc_html__( 'Light Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card--light' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'deep_card_bg', array( 'label' => esc_html__( 'Dark CTA Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card--deep' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'accent_card_bg', array( 'label' => esc_html__( 'Accent Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card--accent' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'card_border_color', array( 'label' => esc_html__( 'Card Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_min_height', array( 'label' => esc_html__( 'Card Min Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 760 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_inner_gap', array( 'label' => esc_html__( 'Card Inner Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'label' => esc_html__( 'Card Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__card' ) );
		$this->add_control( 'card_text_heading', array( 'label' => esc_html__( 'Card Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'card_kicker_color', array( 'label' => esc_html__( 'Card Label Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_kicker_typography', 'label' => esc_html__( 'Card Label Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__card-kicker' ) );
		$this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'label' => esc_html__( 'Card Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__card-title' ) );
		$this->add_control( 'card_description_color', array( 'label' => esc_html__( 'Card Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_description_typography', 'label' => esc_html__( 'Card Text Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__card-description' ) );
		$this->add_control( 'card_meta_color', array( 'label' => esc_html__( 'Meta Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-meta' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_meta_typography', 'label' => esc_html__( 'Meta Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__card-meta' ) );
		$this->add_control( 'dark_text_heading', array( 'label' => esc_html__( 'Dark Card Text Override', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'deep_card_title_color', array( 'label' => esc_html__( 'Dark Card Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card--deep .amaley-featured-collection-cards__card-title' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'deep_card_text_color', array( 'label' => esc_html__( 'Dark Card Body Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card--deep .amaley-featured-collection-cards__card-description, {{WRAPPER}} .amaley-featured-collection-cards__card--deep .amaley-featured-collection-cards__card-meta' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'hover_heading', array( 'label' => esc_html__( 'Hover', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_responsive_control( 'card_hover_lift', array( 'label' => esc_html__( 'Hover Lift', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});' ) ) );
		$this->end_controls_section();
	}

	private function button_style_controls() {
		$this->start_controls_section( 'afcc_button_style', array( 'label' => esc_html__( 'Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'button_top_spacing', array( 'label' => esc_html__( 'Button Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'button_border_color', array( 'label' => esc_html__( 'Button Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button' => 'border-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-featured-collection-cards__card-button' ) );
		$this->add_control( 'dark_button_heading', array( 'label' => esc_html__( 'Dark Card Button Override', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'deep_button_bg', array( 'label' => esc_html__( 'Dark Card Button Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card--deep .amaley-featured-collection-cards__card-button' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'deep_button_color', array( 'label' => esc_html__( 'Dark Card Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card--deep .amaley-featured-collection-cards__card-button' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_heading', array( 'label' => esc_html__( 'Hover', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'button_hover_bg', array( 'label' => esc_html__( 'Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_color', array( 'label' => esc_html__( 'Hover Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-featured-collection-cards__card-button:hover' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$cards    = array();

		if ( ! empty( $settings['cards'] ) && is_array( $settings['cards'] ) ) {
			foreach ( $settings['cards'] as $card ) {
				$cards[] = array(
					'tone'        => isset( $card['tone'] ) ? $card['tone'] : 'light',
					'kicker'      => isset( $card['kicker'] ) ? $card['kicker'] : '',
					'title'       => isset( $card['title'] ) ? $card['title'] : '',
					'description' => isset( $card['description'] ) ? $card['description'] : '',
					'meta'        => isset( $card['meta'] ) ? $card['meta'] : '',
					'button_text' => isset( $card['button_text'] ) ? $card['button_text'] : '',
					'button_url'  => isset( $card['button_url']['url'] ) ? $card['button_url']['url'] : '#',
				);
			}
		}

		echo Amaley_UI_Featured_Collection_Cards::render(
			array(
				'eyebrow'     => isset( $settings['eyebrow'] ) ? $settings['eyebrow'] : '',
				'title'       => isset( $settings['title'] ) ? $settings['title'] : '',
				'accent'      => isset( $settings['accent'] ) ? $settings['accent'] : '',
				'description' => isset( $settings['description'] ) ? $settings['description'] : '',
				'cards'       => $cards,
				'tone'        => isset( $settings['tone'] ) ? $settings['tone'] : 'cream',
				'width'       => isset( $settings['width'] ) ? $settings['width'] : 'contained',
			)
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
