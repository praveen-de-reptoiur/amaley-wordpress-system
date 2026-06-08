<?php
/**
 * Elementor Collection Detail Split widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

/**
 * Elementor-native widget for a collection detail split section.
 */
final class Amaley_Elementor_Collection_Detail_Split_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'amaley_ui_collection_detail_split';
	}

	public function get_title() {
		return esc_html__( 'Amaley Collection Detail Split', 'amaley-ui-sections-kit' );
	}

	public function get_icon() {
		return 'eicon-columns';
	}

	public function get_categories() {
		return array( 'amaley-ui', 'general' );
	}

	public function get_keywords() {
		return array( 'amaley', 'collection', 'detail', 'split', 'guide', 'gifting' );
	}

	public function get_style_depends() {
		return array( 'amaley-ui-sections-kit', 'amaley-ui-collection-detail-split' );
	}

	protected function register_controls() {
		$this->content_controls();
		$this->detail_item_controls();
		$this->guide_controls();
		$this->visibility_controls();
		$this->style_controls();
	}

	private function content_controls() {
		$this->start_controls_section( 'acds_content', array( 'label' => esc_html__( 'Left Collection Content', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'eyebrow', array( 'label' => esc_html__( 'Eyebrow / Small Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Limited collection · from apricot clusters', 'label_block' => true ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'The Apricot Table {Collection}', 'rows' => 2, 'label_block' => true ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word / Phrase', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Collection', 'description' => esc_html__( 'Wrap the accent inside title with { }. Example: The Apricot Table {Collection}', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'This box brings together Amaley’s apricot-led story across preserves, kernel oil, and complementary teas. It is designed for gifting and hospitality use where the buyer wants a soft Himalayan story and a balanced table experience.', 'rows' => 5 ) );
		$this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Build this collection' ) );
		$this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ask a question' ) );
		$this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'tone', array( 'label' => esc_html__( 'Tone', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cream', 'options' => array( 'cream' => 'Warm Cream', 'white' => 'Soft White', 'soft-gold' => 'Soft Gold', 'deep' => 'Deep Chocolate' ) ) );
		$this->add_control( 'width', array( 'label' => esc_html__( 'Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'contained', 'options' => array( 'contained' => 'Contained', 'full' => 'Full Width' ) ) );
		$this->end_controls_section();
	}

	private function detail_item_controls() {
		$this->start_controls_section( 'acds_detail_items', array( 'label' => esc_html__( 'Left Detail Boxes', 'amaley-ui-sections-kit' ) ) );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'label', array( 'label' => esc_html__( 'Box Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'What is inside', 'label_block' => true ) );
		$repeater->add_control( 'text', array( 'label' => esc_html__( 'Box Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Preserves, oils, tea pairing, and seasonal add-ons.', 'rows' => 3 ) );
		$this->add_control(
			'detail_items',
			array(
				'label'       => esc_html__( 'Detail Boxes', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => Amaley_UI_Collection_Detail_Split::default_detail_items(),
			)
		);
		$this->end_controls_section();
	}

	private function guide_controls() {
		$this->start_controls_section( 'acds_guide', array( 'label' => esc_html__( 'Right Guide Card', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'guide_icon', array( 'label' => esc_html__( 'Top Icon / Emoji', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🎁', 'label_block' => true ) );
		$this->add_control( 'guide_title', array( 'label' => esc_html__( 'Guide Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'What should every Amaley collection page make clear?', 'rows' => 2, 'label_block' => true ) );
		$this->add_control( 'guide_text', array( 'label' => esc_html__( 'Guide Description', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'The buyer should understand the purpose of the collection, where the products come from, and how it can be used for gifting, hospitality, retail, or everyday purchase.', 'rows' => 4 ) );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'label', array( 'label' => esc_html__( 'Item Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Buyer purpose', 'label_block' => true ) );
		$repeater->add_control( 'text', array( 'label' => esc_html__( 'Item Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Gifting / Hospitality / Retail / Everyday Use', 'rows' => 2 ) );
		$this->add_control(
			'guide_items',
			array(
				'label'       => esc_html__( 'Guide Items', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => Amaley_UI_Collection_Detail_Split::default_guide_items(),
			)
		);
		$this->end_controls_section();
	}

	private function visibility_controls() {
		$this->start_controls_section( 'acds_visibility', array( 'label' => esc_html__( 'Visibility (Device Wise)', 'amaley-ui-sections-kit' ) ) );
		$this->add_hide_control( 'hide_left_panel', 'Hide Left Panel on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__panel--primary' => 'display:none !important;', '{{WRAPPER}} .amaley-collection-detail-split__grid' => 'grid-template-columns:minmax(0,1fr) !important;' ) );
		$this->add_hide_control( 'hide_right_panel', 'Hide Right Guide Card on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__panel--guide' => 'display:none !important;', '{{WRAPPER}} .amaley-collection-detail-split__grid' => 'grid-template-columns:minmax(0,1fr) !important;' ) );
		$this->add_hide_control( 'hide_eyebrow', 'Hide Eyebrow on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__eyebrow' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_title', 'Hide Title on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__title' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_accent', 'Hide Accent on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__title em' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_description', 'Hide Description on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__description' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_detail_grid', 'Hide Left Detail Boxes on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__detail-grid' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_detail_labels', 'Hide Detail Box Labels on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__detail-label' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_detail_text', 'Hide Detail Box Text on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__detail-text' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_actions', 'Hide All Buttons on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__actions' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_primary_button', 'Hide Primary Button on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__button--primary' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_secondary_button', 'Hide Secondary Button on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__button--secondary' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_guide_icon', 'Hide Guide Icon on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__guide-icon' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_guide_title', 'Hide Guide Title on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__guide-title' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_guide_text', 'Hide Guide Description on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__guide-text' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_guide_items', 'Hide Guide Items on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__guide-list' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_guide_item_labels', 'Hide Guide Item Labels on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__guide-label' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_guide_item_text', 'Hide Guide Item Text on Device', array( '{{WRAPPER}} .amaley-collection-detail-split__guide-item-text' => 'display:none !important;' ) );
		$this->end_controls_section();
	}

	private function add_hide_control( $id, $label, $selectors, $separator = '' ) {
		$args = array(
			'label'        => esc_html__( $label, 'amaley-ui-sections-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'selectors'    => $selectors,
		);
		if ( '' !== $separator ) {
			$args['separator'] = $separator;
		}
		$this->add_responsive_control( $id, $args );
	}

	private function style_controls() {
		$this->section_style_controls();
		$this->layout_style_controls();
		$this->typography_style_controls();
		$this->primary_card_style_controls();
		$this->guide_card_style_controls();
		$this->button_style_controls();
	}

	private function section_style_controls() {
		$this->start_controls_section( 'acds_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'inner_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 640, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function layout_style_controls() {
		$this->start_controls_section( 'acds_layout_style', array( 'label' => esc_html__( 'Layout', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'grid_columns', array( 'label' => esc_html__( 'Grid Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'minmax(0, .95fr) minmax(0, 1fr)', 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__grid' => 'grid-template-columns: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Column Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'panel_min_height', array( 'label' => esc_html__( 'Panel Minimum Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 900 ), 'vh' => array( 'min' => 10, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'panel_alignment', array( 'label' => esc_html__( 'Vertical Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => esc_html__( 'Top', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-v-align-top' ), 'center' => array( 'title' => esc_html__( 'Middle', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-v-align-middle' ), 'flex-end' => array( 'title' => esc_html__( 'Bottom', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-v-align-bottom' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel' => 'justify-content: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	private function typography_style_controls() {
		$this->start_controls_section( 'acds_typography_style', array( 'label' => esc_html__( 'Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'eyebrow_color', array( 'label' => esc_html__( 'Eyebrow Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__eyebrow' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'eyebrow_typography', 'label' => esc_html__( 'Eyebrow Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__eyebrow' ) );
		$this->add_responsive_control( 'eyebrow_spacing', array( 'label' => esc_html__( 'Eyebrow Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__title em' ) );
		$this->add_responsive_control( 'title_spacing', array( 'label' => esc_html__( 'Title Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__description' ) );
		$this->end_controls_section();
	}

	private function primary_card_style_controls() {
		$this->start_controls_section( 'acds_primary_style', array( 'label' => esc_html__( 'Left Detail Card', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'primary_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--primary' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'primary_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'primary_border_color', array( 'label' => esc_html__( 'Card Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--primary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'primary_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--primary' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'primary_shadow', 'label' => esc_html__( 'Card Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__panel--primary' ) );
		$this->add_control( 'detail_boxes_heading', array( 'label' => esc_html__( 'Detail Boxes', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_responsive_control( 'detail_grid_columns', array( 'label' => esc_html__( 'Detail Box Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( '' => 'Default', '1' => '1', '2' => '2', '3' => '3' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-grid' => 'grid-template-columns:repeat({{VALUE}}, minmax(0,1fr));' ) ) );
		$this->add_responsive_control( 'detail_grid_gap', array( 'label' => esc_html__( 'Detail Box Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'detail_grid_spacing', array( 'label' => esc_html__( 'Detail Grid Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-grid' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'detail_item_bg', array( 'label' => esc_html__( 'Detail Box Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-item' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'detail_item_padding', array( 'label' => esc_html__( 'Detail Box Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'detail_item_border_color', array( 'label' => esc_html__( 'Detail Box Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-item' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'detail_item_radius', array( 'label' => esc_html__( 'Detail Box Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'detail_label_color', array( 'label' => esc_html__( 'Detail Label Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-label' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'detail_label_typography', 'label' => esc_html__( 'Detail Label Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__detail-label' ) );
		$this->add_control( 'detail_text_color', array( 'label' => esc_html__( 'Detail Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__detail-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'detail_text_typography', 'label' => esc_html__( 'Detail Text Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__detail-text' ) );
		$this->end_controls_section();
	}

	private function guide_card_style_controls() {
		$this->start_controls_section( 'acds_guide_style', array( 'label' => esc_html__( 'Right Guide Card', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'guide_bg', array( 'label' => esc_html__( 'Guide Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--guide' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'guide_padding', array( 'label' => esc_html__( 'Guide Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--guide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'guide_border_color', array( 'label' => esc_html__( 'Guide Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--guide' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'guide_radius', array( 'label' => esc_html__( 'Guide Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--guide' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'guide_shadow', 'label' => esc_html__( 'Guide Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__panel--guide' ) );
		$this->add_responsive_control( 'guide_text_align', array( 'label' => esc_html__( 'Guide Text Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__panel--guide' => 'text-align: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'guide_icon_size', array( 'label' => esc_html__( 'Guide Icon Size', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'em', 'rem' ), 'range' => array( 'px' => array( 'min' => 10, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-icon' => 'font-size: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'guide_icon_spacing', array( 'label' => esc_html__( 'Guide Icon Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'guide_title_color', array( 'label' => esc_html__( 'Guide Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'guide_title_typography', 'label' => esc_html__( 'Guide Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__guide-title' ) );
		$this->add_control( 'guide_text_color', array( 'label' => esc_html__( 'Guide Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'guide_text_typography', 'label' => esc_html__( 'Guide Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__guide-text' ) );
		$this->add_control( 'guide_items_heading', array( 'label' => esc_html__( 'Guide Items', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_responsive_control( 'guide_items_gap', array( 'label' => esc_html__( 'Guide Items Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-list' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'guide_list_spacing', array( 'label' => esc_html__( 'Guide List Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-list' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'guide_item_bg', array( 'label' => esc_html__( 'Guide Item Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-item' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'guide_item_padding', array( 'label' => esc_html__( 'Guide Item Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'guide_item_border_color', array( 'label' => esc_html__( 'Guide Item Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-item' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'guide_item_radius', array( 'label' => esc_html__( 'Guide Item Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'guide_label_color', array( 'label' => esc_html__( 'Guide Item Label Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-label' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'guide_label_typography', 'label' => esc_html__( 'Guide Item Label Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__guide-label' ) );
		$this->add_control( 'guide_item_text_color', array( 'label' => esc_html__( 'Guide Item Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__guide-item-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'guide_item_text_typography', 'label' => esc_html__( 'Guide Item Text Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__guide-item-text' ) );
		$this->end_controls_section();
	}

	private function button_style_controls() {
		$this->start_controls_section( 'acds_button_style', array( 'label' => esc_html__( 'Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'actions_spacing', array( 'label' => esc_html__( 'Buttons Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__actions' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'buttons_gap', array( 'label' => esc_html__( 'Buttons Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-collection-detail-split__button' ) );
		$this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--primary' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--primary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'primary_button_border', array( 'label' => esc_html__( 'Primary Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--primary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_button_bg', array( 'label' => esc_html__( 'Secondary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--secondary' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_button_color', array( 'label' => esc_html__( 'Secondary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--secondary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_button_border', array( 'label' => esc_html__( 'Secondary Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--secondary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_heading', array( 'label' => esc_html__( 'Hover', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'primary_hover_bg', array( 'label' => esc_html__( 'Primary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--primary:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'primary_hover_color', array( 'label' => esc_html__( 'Primary Hover Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--primary:hover' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_hover_bg', array( 'label' => esc_html__( 'Secondary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--secondary:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_hover_color', array( 'label' => esc_html__( 'Secondary Hover Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-collection-detail-split__button--secondary:hover' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$detail_items = array();
		$guide_items  = array();

		if ( ! empty( $settings['detail_items'] ) && is_array( $settings['detail_items'] ) ) {
			foreach ( $settings['detail_items'] as $item ) {
				$detail_items[] = array(
					'label' => isset( $item['label'] ) ? $item['label'] : '',
					'text'  => isset( $item['text'] ) ? $item['text'] : '',
				);
			}
		}

		if ( ! empty( $settings['guide_items'] ) && is_array( $settings['guide_items'] ) ) {
			foreach ( $settings['guide_items'] as $item ) {
				$guide_items[] = array(
					'label' => isset( $item['label'] ) ? $item['label'] : '',
					'text'  => isset( $item['text'] ) ? $item['text'] : '',
				);
			}
		}

		echo Amaley_UI_Collection_Detail_Split::render(
			array(
				'eyebrow'        => isset( $settings['eyebrow'] ) ? $settings['eyebrow'] : '',
				'title'          => isset( $settings['title'] ) ? $settings['title'] : '',
				'accent'         => isset( $settings['accent'] ) ? $settings['accent'] : '',
				'description'    => isset( $settings['description'] ) ? $settings['description'] : '',
				'detail_items'   => $detail_items,
				'primary_text'   => isset( $settings['primary_text'] ) ? $settings['primary_text'] : '',
				'primary_url'    => isset( $settings['primary_url']['url'] ) ? $settings['primary_url']['url'] : '#',
				'secondary_text' => isset( $settings['secondary_text'] ) ? $settings['secondary_text'] : '',
				'secondary_url'  => isset( $settings['secondary_url']['url'] ) ? $settings['secondary_url']['url'] : '#',
				'guide_icon'     => isset( $settings['guide_icon'] ) ? $settings['guide_icon'] : '',
				'guide_title'    => isset( $settings['guide_title'] ) ? $settings['guide_title'] : '',
				'guide_text'     => isset( $settings['guide_text'] ) ? $settings['guide_text'] : '',
				'guide_items'    => $guide_items,
				'tone'           => isset( $settings['tone'] ) ? $settings['tone'] : 'cream',
				'width'          => isset( $settings['width'] ) ? $settings['width'] : 'contained',
			)
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
