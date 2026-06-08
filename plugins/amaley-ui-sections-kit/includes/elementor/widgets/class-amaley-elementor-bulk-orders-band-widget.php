<?php
/**
 * Elementor Bulk Orders Band widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

if ( ! class_exists( 'Amaley_UI_Bulk_Orders_Band' ) && defined( 'AMALEY_UI_SECTIONS_KIT_PATH' ) ) {
	$amaley_bulk_orders_renderer = AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-bulk-orders-band.php';
	if ( file_exists( $amaley_bulk_orders_renderer ) ) {
		require_once $amaley_bulk_orders_renderer;
	}
}

/**
 * Elementor-native widget for a bulk orders / institutional enquiry band.
 */
final class Amaley_Elementor_Bulk_Orders_Band_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'amaley_ui_bulk_orders_band';
	}

	public function get_title() {
		return esc_html__( 'Amaley Bulk Orders Band', 'amaley-ui-sections-kit' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return array( 'amaley-ui', 'general' );
	}

	public function get_keywords() {
		return array( 'amaley', 'bulk orders', 'corporate gifting', 'hospitality', 'cta', 'collections' );
	}

	public function get_style_depends() {
		return array( 'amaley-ui-sections-kit', 'amaley-ui-bulk-orders-band' );
	}

	protected function register_controls() {
		$this->content_controls();
		$this->feature_controls();
		$this->visibility_controls();
		$this->style_controls();
	}

	private function content_controls() {
		$this->start_controls_section( 'abob_content', array( 'label' => esc_html__( 'Section Content', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'eyebrow', array( 'label' => esc_html__( 'Eyebrow / Small Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Bulk orders', 'label_block' => true ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Corporate gifting, hospitality, events, and retail supply', 'rows' => 3, 'label_block' => true ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word / Phrase', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Optional. Wrap the accent inside title with { }.', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Amaley collections are suitable for larger use cases — festive gifting, hospitality counters, guest welcome hampers, premium counters, and institutional buyer needs.', 'rows' => 4 ) );
		$this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Submit bulk enquiry' ) );
		$this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore buyer-ready collections' ) );
		$this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'tone', array( 'label' => esc_html__( 'Tone', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'deep', 'options' => array( 'deep' => 'Deep Chocolate', 'green' => 'Olive Green', 'cream' => 'Warm Cream' ) ) );
		$this->add_control( 'width', array( 'label' => esc_html__( 'Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'contained', 'options' => array( 'contained' => 'Contained', 'full' => 'Full Width' ) ) );
		$this->end_controls_section();
	}

	private function feature_controls() {
		$this->start_controls_section( 'abob_features', array( 'label' => esc_html__( 'Feature Cards', 'amaley-ui-sections-kit' ) ) );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'title', array( 'label' => esc_html__( 'Feature Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Small team gifting', 'rows' => 2, 'label_block' => true ) );
		$repeater->add_control( 'text', array( 'label' => esc_html__( 'Feature Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'For founders, offices, and thoughtful end-of-year hampers.', 'rows' => 3 ) );
		$this->add_control(
			'features',
			array(
				'label'       => esc_html__( 'Cards', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => Amaley_UI_Bulk_Orders_Band::default_features(),
				'title_field' => '{{{ title }}}',
			)
		);
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

	private function visibility_controls() {
		$this->start_controls_section( 'abob_visibility', array( 'label' => esc_html__( 'Visibility (Device Wise)', 'amaley-ui-sections-kit' ) ) );
		$this->add_hide_control( 'hide_eyebrow', 'Hide Eyebrow on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__eyebrow' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_title', 'Hide Title on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__title' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_accent', 'Hide Accent on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__title em' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_description', 'Hide Description on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__description' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_features', 'Hide Feature Cards on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__features' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_feature_titles', 'Hide Feature Titles on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__feature-title' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_feature_text', 'Hide Feature Text on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__feature-text' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_actions', 'Hide All Buttons on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__actions' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_primary_button', 'Hide Primary Button on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__button--primary' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_secondary_button', 'Hide Secondary Button on Device', array( '{{WRAPPER}} .amaley-bulk-orders-band__button--secondary' => 'display:none !important;' ) );
		$this->end_controls_section();
	}

	private function style_controls() {
		$this->section_style_controls();
		$this->layout_style_controls();
		$this->typography_style_controls();
		$this->feature_style_controls();
		$this->button_style_controls();
	}

	private function section_style_controls() {
		$this->start_controls_section( 'abob_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'section_text_color', array( 'label' => esc_html__( 'Base Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band' => 'color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'section_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 760, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function layout_style_controls() {
		$this->start_controls_section( 'abob_layout_style', array( 'label' => esc_html__( 'Layout', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'content_max_width', array( 'label' => esc_html__( 'Content Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 320, 'max' => 1200 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__content' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'content_alignment', array( 'label' => esc_html__( 'Text Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__content' => 'text-align: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'content_gap', array( 'label' => esc_html__( 'Content Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__content' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'feature_columns', array( 'label' => esc_html__( 'Feature Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( '' => 'Default', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__features' => 'grid-template-columns: repeat({{VALUE}}, minmax(0,1fr));' ) ) );
		$this->add_responsive_control( 'feature_gap', array( 'label' => esc_html__( 'Feature Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__features' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'actions_margin_top', array( 'label' => esc_html__( 'Buttons Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__actions' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function typography_style_controls() {
		$this->start_controls_section( 'abob_typography_style', array( 'label' => esc_html__( 'Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'eyebrow_color', array( 'label' => esc_html__( 'Eyebrow Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__eyebrow' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'eyebrow_typography', 'label' => esc_html__( 'Eyebrow Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__eyebrow' ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__title em' ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__description' ) );
		$this->end_controls_section();
	}

	private function feature_style_controls() {
		$this->start_controls_section( 'abob_feature_style', array( 'label' => esc_html__( 'Feature Cards', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'feature_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'feature_border_color', array( 'label' => esc_html__( 'Card Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'feature_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'feature_min_height', array( 'label' => esc_html__( 'Card Min Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 460 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'feature_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'feature_shadow', 'label' => esc_html__( 'Card Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__feature' ) );
		$this->add_responsive_control( 'feature_inner_gap', array( 'label' => esc_html__( 'Title/Text Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'feature_title_color', array( 'label' => esc_html__( 'Feature Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'feature_title_typography', 'label' => esc_html__( 'Feature Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__feature-title' ) );
		$this->add_control( 'feature_text_color', array( 'label' => esc_html__( 'Feature Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__feature-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'feature_text_typography', 'label' => esc_html__( 'Feature Text Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__feature-text' ) );
		$this->end_controls_section();
	}

	private function button_style_controls() {
		$this->start_controls_section( 'abob_button_style', array( 'label' => esc_html__( 'Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'button_alignment', array( 'label' => esc_html__( 'Button Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__actions' => 'justify-content: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'button_gap', array( 'label' => esc_html__( 'Button Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-bulk-orders-band__button' ) );
		$this->add_control( 'primary_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--primary' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'primary_color', array( 'label' => esc_html__( 'Primary Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--primary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_bg', array( 'label' => esc_html__( 'Secondary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--secondary' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_color', array( 'label' => esc_html__( 'Secondary Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--secondary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_border_color', array( 'label' => esc_html__( 'Secondary Border', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--secondary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_heading', array( 'label' => esc_html__( 'Hover', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 'primary_hover_bg', array( 'label' => esc_html__( 'Primary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--primary:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'primary_hover_color', array( 'label' => esc_html__( 'Primary Hover Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--primary:hover' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_hover_bg', array( 'label' => esc_html__( 'Secondary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--secondary:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'secondary_hover_color', array( 'label' => esc_html__( 'Secondary Hover Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-bulk-orders-band__button--secondary:hover' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$primary_url = isset( $settings['primary_url']['url'] ) ? $settings['primary_url']['url'] : '#';
		$secondary_url = isset( $settings['secondary_url']['url'] ) ? $settings['secondary_url']['url'] : '#';

		echo Amaley_UI_Bulk_Orders_Band::render(
			array(
				'eyebrow'        => isset( $settings['eyebrow'] ) ? $settings['eyebrow'] : '',
				'title'          => isset( $settings['title'] ) ? $settings['title'] : '',
				'accent'         => isset( $settings['accent'] ) ? $settings['accent'] : '',
				'description'    => isset( $settings['description'] ) ? $settings['description'] : '',
				'features'       => isset( $settings['features'] ) ? $settings['features'] : array(),
				'primary_text'   => isset( $settings['primary_text'] ) ? $settings['primary_text'] : '',
				'primary_url'    => $primary_url,
				'secondary_text' => isset( $settings['secondary_text'] ) ? $settings['secondary_text'] : '',
				'secondary_url'  => $secondary_url,
				'tone'           => isset( $settings['tone'] ) ? $settings['tone'] : 'deep',
				'width'          => isset( $settings['width'] ) ? $settings['width'] : 'contained',
			)
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
