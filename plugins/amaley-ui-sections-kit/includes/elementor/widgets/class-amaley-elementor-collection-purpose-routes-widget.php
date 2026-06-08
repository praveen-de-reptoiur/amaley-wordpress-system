<?php
/**
 * Elementor Collection Purpose Routes widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

/**
 * Elementor-native widget for purpose-led Amaley collection route cards.
 */
final class Amaley_Elementor_Collection_Purpose_Routes_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'amaley_ui_collection_purpose_routes';
	}

	public function get_title() {
		return esc_html__( 'Amaley Collection Purpose Routes', 'amaley-ui-sections-kit' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'amaley-ui', 'general' );
	}

	public function get_keywords() {
		return array( 'amaley', 'collection', 'purpose', 'routes', 'cards', 'buying' );
	}

	public function get_style_depends() {
		return array( 'amaley-ui-sections-kit', 'amaley-ui-collection-purpose-routes' );
	}

	protected function register_controls() {
		$this->content_controls();
		$this->visibility_controls();
		$this->style_controls();
	}

	private function content_controls() {
		$this->start_controls_section(
			'acpr_content',
			array(
				'label' => esc_html__( 'Section Content', 'amaley-ui-sections-kit' ),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'       => esc_html__( 'Eyebrow / Small Label', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Shop with purpose',
				'label_block' => true,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => 'Start with {why you are buying}',
				'rows'        => 2,
				'label_block' => true,
			)
		);

		$this->add_control(
			'accent',
			array(
				'label'       => esc_html__( 'Accent Word / Phrase', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'why you are buying',
				'description' => esc_html__( 'Wrap the accent inside title with { }. Example: Start with {why you are buying}', 'amaley-ui-sections-kit' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => 'Amaley collections are not just shelves full of products. They are buying routes for different needs — from gifts and hospitality placements to daily kitchen use and retail counters.',
			)
		);

		$this->add_control(
			'tone',
			array(
				'label'   => esc_html__( 'Tone', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'cream',
				'options' => array(
					'cream' => esc_html__( 'Warm Cream', 'amaley-ui-sections-kit' ),
					'white' => esc_html__( 'White Cards', 'amaley-ui-sections-kit' ),
					'deep'  => esc_html__( 'Deep Chocolate', 'amaley-ui-sections-kit' ),
				),
			)
		);

		$this->add_control(
			'width',
			array(
				'label'   => esc_html__( 'Width', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'contained',
				'options' => array(
					'contained' => esc_html__( 'Contained', 'amaley-ui-sections-kit' ),
					'full'      => esc_html__( 'Full Width', 'amaley-ui-sections-kit' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'acpr_cards',
			array(
				'label' => esc_html__( 'Purpose Cards', 'amaley-ui-sections-kit' ),
			)
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'number',
			array(
				'label'       => esc_html__( 'Number', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '01',
				'label_block' => false,
			)
		);
		$repeater->add_control(
			'label',
			array(
				'label'       => esc_html__( 'Small Label', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Gifting',
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Card Title', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => 'For festive sets, boxes, and thoughtful hampers.',
				'rows'        => 2,
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Card Description', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Choose items that feel coherent, place-rooted, and less generic than normal gift packs.',
				'rows'    => 3,
			)
		);
		$repeater->add_control(
			'button_text',
			array(
				'label'       => esc_html__( 'Button Text', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Explore Gift Boxes',
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'button_url',
			array(
				'label'   => esc_html__( 'Button Link', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => '#' ),
			)
		);

		$defaults = Amaley_UI_Collection_Purpose_Routes::default_cards();
		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__( 'Cards', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $defaults,
				'title_field' => '{{{ number }}} · {{{ label }}}',
			)
		);

		$this->end_controls_section();
	}

	private function visibility_controls() {
		$this->start_controls_section(
			'acpr_visibility',
			array(
				'label' => esc_html__( 'Visibility (Device Wise)', 'amaley-ui-sections-kit' ),
			)
		);

		$this->add_responsive_control( 'hide_eyebrow', array( 'label' => esc_html__( 'Hide Eyebrow on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__eyebrow' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_title', array( 'label' => esc_html__( 'Hide Title on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__title' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_accent', array( 'label' => esc_html__( 'Hide Accent on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__title em' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_description', array( 'label' => esc_html__( 'Hide Description on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__description' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_grid', array( 'label' => esc_html__( 'Hide Cards Grid on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'separator' => 'before', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__grid' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_card_kicker', array( 'label' => esc_html__( 'Hide Card Numbers/Labels on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-kicker' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_card_title', array( 'label' => esc_html__( 'Hide Card Titles on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-title' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_card_description', array( 'label' => esc_html__( 'Hide Card Text on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-description' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 'hide_card_buttons', array( 'label' => esc_html__( 'Hide Card Buttons on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' => 'display:none !important;' ) ) );

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
		$this->start_controls_section( 'acpr_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'inner_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 640, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function layout_style_controls() {
		$this->start_controls_section( 'acpr_layout_style', array( 'label' => esc_html__( 'Layout', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'header_columns', array( 'label' => esc_html__( 'Header Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'minmax(260px,.55fr) minmax(320px,.75fr)', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__header' => 'grid-template-columns: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'header_gap', array( 'label' => esc_html__( 'Header Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__header' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'header_bottom_spacing', array( 'label' => esc_html__( 'Header Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__header' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'grid_columns', array( 'label' => esc_html__( 'Cards Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( '' => esc_html__( 'Default', 'amaley-ui-sections-kit' ), '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0,1fr));' ) ) );
		$this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Card Column Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__grid' => 'column-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'grid_row_gap', array( 'label' => esc_html__( 'Card Row Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__grid' => 'row-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'section_text_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__heading, {{WRAPPER}} .amaley-collection-purpose-routes__description' => 'text-align: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	private function typography_style_controls() {
		$this->start_controls_section( 'acpr_typography_style', array( 'label' => esc_html__( 'Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'eyebrow_color', array( 'label' => esc_html__( 'Eyebrow Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__eyebrow' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'eyebrow_typography', 'label' => esc_html__( 'Eyebrow Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__eyebrow' ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__title em' ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__description' ) );
		$this->end_controls_section();
	}

	private function card_style_controls() {
		$this->start_controls_section( 'acpr_card_style', array( 'label' => esc_html__( 'Cards / Items', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_min_height', array( 'label' => esc_html__( 'Card Min Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 520 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'card_border_color', array( 'label' => esc_html__( 'Card Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'label' => esc_html__( 'Card Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__card' ) );
		$this->add_responsive_control( 'card_content_gap', array( 'label' => esc_html__( 'Card Inner Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'card_kicker_color', array( 'label' => esc_html__( 'Number / Label Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_kicker_typography', 'label' => esc_html__( 'Number / Label Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__card-kicker' ) );
		$this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'label' => esc_html__( 'Card Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__card-title' ) );
		$this->add_control( 'card_description_color', array( 'label' => esc_html__( 'Card Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_description_typography', 'label' => esc_html__( 'Card Text Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__card-description' ) );
		$this->add_responsive_control( 'card_hover_lift', array( 'label' => esc_html__( 'Hover Lift', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});' ) ) );
		$this->end_controls_section();
	}

	private function button_style_controls() {
		$this->start_controls_section( 'acpr_button_style', array( 'label' => esc_html__( 'Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'button_top_spacing', array( 'label' => esc_html__( 'Button Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'button_border_color', array( 'label' => esc_html__( 'Button Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' => 'border-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-purpose-routes__card-button' ) );
		$this->add_control( 'button_hover_heading', array( 'label' => esc_html__( 'Hover', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'button_hover_bg', array( 'label' => esc_html__( 'Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_color', array( 'label' => esc_html__( 'Hover Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-purpose-routes__card-button:hover' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$cards    = array();

		if ( ! empty( $settings['cards'] ) && is_array( $settings['cards'] ) ) {
			foreach ( $settings['cards'] as $card ) {
				$cards[] = array(
					'number'      => isset( $card['number'] ) ? $card['number'] : '',
					'label'       => isset( $card['label'] ) ? $card['label'] : '',
					'title'       => isset( $card['title'] ) ? $card['title'] : '',
					'description' => isset( $card['description'] ) ? $card['description'] : '',
					'button_text' => isset( $card['button_text'] ) ? $card['button_text'] : '',
					'button_url'  => isset( $card['button_url']['url'] ) ? $card['button_url']['url'] : '#',
				);
			}
		}

		echo Amaley_UI_Collection_Purpose_Routes::render(
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
