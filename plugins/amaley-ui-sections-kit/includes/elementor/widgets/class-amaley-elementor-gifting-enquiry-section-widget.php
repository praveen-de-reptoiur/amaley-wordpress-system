<?php
/**
 * Elementor Gifting Enquiry Section widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

if ( ! class_exists( 'Amaley_UI_Gifting_Enquiry_Section' ) && defined( 'AMALEY_UI_SECTIONS_KIT_PATH' ) ) {
	$amaley_gifting_enquiry_renderer = AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-gifting-enquiry-section.php';
	if ( file_exists( $amaley_gifting_enquiry_renderer ) ) {
		require_once $amaley_gifting_enquiry_renderer;
	}
}

/**
 * Elementor-native widget for gifting / bulk enquiry section.
 */
final class Amaley_Elementor_Gifting_Enquiry_Section_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'amaley_ui_gifting_enquiry_section';
	}

	public function get_title() {
		return esc_html__( 'Amaley Gifting Enquiry Section', 'amaley-ui-sections-kit' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return array( 'amaley-ui', 'general' );
	}

	public function get_keywords() {
		return array( 'amaley', 'gifting', 'enquiry', 'form', 'bulk orders', 'collections' );
	}

	public function get_style_depends() {
		return array( 'amaley-ui-sections-kit', 'amaley-ui-gifting-enquiry-section' );
	}

	protected function register_controls() {
		$this->content_controls();
		$this->points_controls();
		$this->form_controls();
		$this->visibility_controls();
		$this->style_controls();
	}

	private function content_controls() {
		$this->start_controls_section( 'ages_content', array( 'label' => esc_html__( 'Section Content', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'eyebrow', array( 'label' => esc_html__( 'Eyebrow / Small Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'For businesses & gifting', 'label_block' => true ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Curated Gifting & Bulk {Orders}', 'rows' => 3, 'label_block' => true ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word / Phrase', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Orders', 'description' => esc_html__( 'Wrap the accent inside title with { }. Example: Bulk {Orders}', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Our clusters span some of the most biodiverse and culturally rich landscapes in the Indian Himalayas — from Ladakh to Kinnaur, Spiti to the Pir Panjal range.', 'rows' => 4 ) );
		$this->add_control( 'button_text', array( 'label' => esc_html__( 'Catalogue Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Download gifting catalogue' ) );
		$this->add_control( 'button_url', array( 'label' => esc_html__( 'Catalogue Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'tone', array( 'label' => esc_html__( 'Tone', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'green', 'options' => array( 'green' => 'Olive Green', 'deep' => 'Deep Chocolate', 'cream' => 'Warm Cream' ) ) );
		$this->add_control( 'width', array( 'label' => esc_html__( 'Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'contained', 'options' => array( 'contained' => 'Contained', 'full' => 'Full Width' ) ) );
		$this->end_controls_section();
	}

	private function points_controls() {
		$this->start_controls_section( 'ages_points', array( 'label' => esc_html__( 'Enquiry Points', 'amaley-ui-sections-kit' ) ) );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'icon', array( 'label' => esc_html__( 'Icon / Symbol', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🎁', 'label_block' => true ) );
		$repeater->add_control( 'text', array( 'label' => esc_html__( 'Point Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Corporate & Festival Gift Hampers', 'rows' => 2, 'label_block' => true ) );
		$this->add_control(
			'points',
			array(
				'label'       => esc_html__( 'Points', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => Amaley_UI_Gifting_Enquiry_Section::default_points(),
				'title_field' => '{{{ text }}}',
			)
		);
		$this->end_controls_section();
	}

	private function form_controls() {
		$this->start_controls_section( 'ages_form', array( 'label' => esc_html__( 'Form / Enquiry Box', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'form_eyebrow', array( 'label' => esc_html__( 'Form Eyebrow', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Start an enquiry', 'label_block' => true ) );
		$this->add_control( 'form_title', array( 'label' => esc_html__( 'Form Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tell us what you need', 'label_block' => true ) );
		$this->add_control( 'form_description', array( 'label' => esc_html__( 'Form Description', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Share your requirement for hampers, hospitality counters, retail placement, or institutional orders.', 'rows' => 3 ) );
		$this->add_control( 'form_mode', array( 'label' => esc_html__( 'Form Mode', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'dummy', 'options' => array( 'dummy' => 'Dummy / Fillable Form Now', 'embed' => 'Use Shortcode / HTML Form' ), 'separator' => 'before', 'description' => esc_html__( 'Keep Dummy mode until a real Contact Form 7, WPForms, Elementor Form, or custom form is ready.', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'dummy_form_note', array( 'type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => esc_html__( 'Dummy mode shows a fillable non-submitting form. Visitors can type in fields for preview/testing, but it will not send enquiries. Switch to Shortcode / HTML mode later and paste your real form shortcode.', 'amaley-ui-sections-kit' ), 'content_classes' => 'elementor-panel-alert elementor-panel-alert-info', 'condition' => array( 'form_mode' => 'dummy' ) ) );
		$this->add_control( 'first_name_label', array( 'label' => esc_html__( 'Dummy Field: First Name', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'First Name', 'condition' => array( 'form_mode' => 'dummy' ) ) );
		$this->add_control( 'last_name_label', array( 'label' => esc_html__( 'Dummy Field: Last Name', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Last Name', 'condition' => array( 'form_mode' => 'dummy' ) ) );
		$this->add_control( 'email_label', array( 'label' => esc_html__( 'Dummy Field: Email', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Email Address', 'condition' => array( 'form_mode' => 'dummy' ) ) );
		$this->add_control( 'enquiry_label', array( 'label' => esc_html__( 'Dummy Field: Enquiry Type', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Type of Enquiry', 'condition' => array( 'form_mode' => 'dummy' ) ) );
		$this->add_control( 'message_label', array( 'label' => esc_html__( 'Dummy Field: Message', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Your Message', 'condition' => array( 'form_mode' => 'dummy' ) ) );
		$this->add_control( 'submit_label', array( 'label' => esc_html__( 'Dummy Submit Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Submit Enquiry →', 'condition' => array( 'form_mode' => 'dummy' ) ) );
		$this->add_control(
			'form_embed',
			array(
				'label'       => esc_html__( 'Form Shortcode / HTML', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 6,
				'default'     => '',
				'placeholder' => '[contact-form-7 id="123" title="Bulk Enquiry"]',
				'description' => esc_html__( 'Paste Contact Form 7 / WPForms / Elementor form shortcode or safe form HTML. Form, input, select, textarea, label and button markup is allowed safely. If empty, the fillable dummy form will show as fallback.', 'amaley-ui-sections-kit' ),
				'condition'   => array( 'form_mode' => 'embed' ),
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
		$this->start_controls_section( 'ages_visibility', array( 'label' => esc_html__( 'Visibility (Device Wise)', 'amaley-ui-sections-kit' ) ) );
		$this->add_hide_control( 'hide_eyebrow', 'Hide Eyebrow on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__eyebrow' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_title', 'Hide Title on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__title' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_accent', 'Hide Accent on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__title em' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_description', 'Hide Description on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__description' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_points', 'Hide Enquiry Points on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__points' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_point_icons', 'Hide Point Icons on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__point-icon' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_point_text', 'Hide Point Text on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__point-text' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_button', 'Hide Catalogue Button on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__actions' => 'display:none !important;' ), 'before' );
		$this->add_hide_control( 'hide_form_card', 'Hide Form Card on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-card' => 'display:none !important;', '{{WRAPPER}} .amaley-gifting-enquiry-section__grid' => 'grid-template-columns:minmax(0,1fr) !important;' ), 'before' );
		$this->add_hide_control( 'hide_form_eyebrow', 'Hide Form Eyebrow on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-eyebrow' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_form_title', 'Hide Form Title on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-title' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_form_description', 'Hide Form Description on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-description' => 'display:none !important;' ) );
		$this->add_hide_control( 'hide_form_embed', 'Hide Form Embed on Device', array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-embed' => 'display:none !important;' ) );
		$this->end_controls_section();
	}

	private function style_controls() {
		$this->section_style_controls();
		$this->layout_style_controls();
		$this->typography_style_controls();
		$this->points_style_controls();
		$this->form_style_controls();
		$this->button_style_controls();
	}

	private function section_style_controls() {
		$this->start_controls_section( 'ages_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'section_text_color', array( 'label' => esc_html__( 'Base Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section' => 'color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'section_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 760, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function layout_style_controls() {
		$this->start_controls_section( 'ages_layout_style', array( 'label' => esc_html__( 'Layout', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'grid_columns', array( 'label' => esc_html__( 'Grid Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'minmax(0,1fr) minmax(360px,.82fr)', 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__grid' => 'grid-template-columns: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Column Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'content_max_width', array( 'label' => esc_html__( 'Content Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 320, 'max' => 1000 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__content' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'content_alignment', array( 'label' => esc_html__( 'Text Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__content' => 'text-align: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	private function typography_style_controls() {
		$this->start_controls_section( 'ages_typography_style', array( 'label' => esc_html__( 'Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'eyebrow_color', array( 'label' => esc_html__( 'Eyebrow Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__eyebrow' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'eyebrow_typography', 'label' => esc_html__( 'Eyebrow Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__eyebrow' ) );
		$this->add_responsive_control( 'eyebrow_spacing', array( 'label' => esc_html__( 'Eyebrow Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__title em' ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__description' ) );
		$this->add_responsive_control( 'description_spacing', array( 'label' => esc_html__( 'Description Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__description' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function points_style_controls() {
		$this->start_controls_section( 'ages_points_style', array( 'label' => esc_html__( 'Enquiry Points', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'points_margin_top', array( 'label' => esc_html__( 'Points Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__points' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'point_gap', array( 'label' => esc_html__( 'Point Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__points' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'point_padding', array( 'label' => esc_html__( 'Point Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__point' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'point_border_color', array( 'label' => esc_html__( 'Point Divider / Border', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__point' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 'point_icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__point-icon' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'point_icon_typography', 'label' => esc_html__( 'Icon Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__point-icon' ) );
		$this->add_control( 'point_text_color', array( 'label' => esc_html__( 'Point Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__point-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'point_text_typography', 'label' => esc_html__( 'Point Text Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__point-text' ) );
		$this->end_controls_section();
	}

	private function form_style_controls() {
		$this->start_controls_section( 'ages_form_style', array( 'label' => esc_html__( 'Form Card', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'form_card_bg', array( 'label' => esc_html__( 'Form Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-card' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'form_card_border', array( 'label' => esc_html__( 'Form Card Border', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-card' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'form_card_padding', array( 'label' => esc_html__( 'Form Card Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'form_card_radius', array( 'label' => esc_html__( 'Form Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'form_card_shadow', 'label' => esc_html__( 'Form Card Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__form-card' ) );
		$this->add_control( 'form_eyebrow_color', array( 'label' => esc_html__( 'Form Eyebrow Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-eyebrow' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'form_title_color', array( 'label' => esc_html__( 'Form Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'form_title_typography', 'label' => esc_html__( 'Form Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__form-title' ) );
		$this->add_control( 'form_description_color', array( 'label' => esc_html__( 'Form Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__form-description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'form_description_typography', 'label' => esc_html__( 'Form Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__form-description' ) );
		$this->add_control( 'field_bg', array( 'label' => esc_html__( 'Fallback Field Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__fake-field, {{WRAPPER}} .amaley-gifting-enquiry-section__form-embed input:not([type="hidden"]):not([type="submit"]):not([type="button"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]), {{WRAPPER}} .amaley-gifting-enquiry-section__form-embed select, {{WRAPPER}} .amaley-gifting-enquiry-section__form-embed textarea' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'field_border', array( 'label' => esc_html__( 'Fallback Field Border', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__fake-field, {{WRAPPER}} .amaley-gifting-enquiry-section__form-embed input:not([type="hidden"]):not([type="submit"]):not([type="button"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]), {{WRAPPER}} .amaley-gifting-enquiry-section__form-embed select, {{WRAPPER}} .amaley-gifting-enquiry-section__form-embed textarea' => 'border-color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	private function button_style_controls() {
		$this->start_controls_section( 'ages_button_style', array( 'label' => esc_html__( 'Catalogue Button', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'button_margin_top', array( 'label' => esc_html__( 'Button Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__actions' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__button' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-gifting-enquiry-section__button' ) );
		$this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__button' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__button' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_bg', array( 'label' => esc_html__( 'Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__button:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_color', array( 'label' => esc_html__( 'Hover Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-gifting-enquiry-section__button:hover' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'Amaley_UI_Gifting_Enquiry_Section' ) ) {
			return;
		}

		$settings   = $this->get_settings_for_display();
		$button_url = isset( $settings['button_url']['url'] ) ? $settings['button_url']['url'] : '#';

		echo Amaley_UI_Gifting_Enquiry_Section::render(
			array(
				'eyebrow'          => isset( $settings['eyebrow'] ) ? $settings['eyebrow'] : '',
				'title'            => isset( $settings['title'] ) ? $settings['title'] : '',
				'accent'           => isset( $settings['accent'] ) ? $settings['accent'] : '',
				'description'      => isset( $settings['description'] ) ? $settings['description'] : '',
				'points'           => isset( $settings['points'] ) ? $settings['points'] : array(),
				'button_text'      => isset( $settings['button_text'] ) ? $settings['button_text'] : '',
				'button_url'       => $button_url,
				'form_eyebrow'     => isset( $settings['form_eyebrow'] ) ? $settings['form_eyebrow'] : '',
				'form_title'       => isset( $settings['form_title'] ) ? $settings['form_title'] : '',
				'form_description' => isset( $settings['form_description'] ) ? $settings['form_description'] : '',
				'form_mode'        => isset( $settings['form_mode'] ) ? $settings['form_mode'] : 'dummy',
				'form_embed'       => isset( $settings['form_embed'] ) ? $settings['form_embed'] : '',
				'first_name_label' => isset( $settings['first_name_label'] ) ? $settings['first_name_label'] : 'First Name',
				'last_name_label'  => isset( $settings['last_name_label'] ) ? $settings['last_name_label'] : 'Last Name',
				'email_label'      => isset( $settings['email_label'] ) ? $settings['email_label'] : 'Email Address',
				'enquiry_label'    => isset( $settings['enquiry_label'] ) ? $settings['enquiry_label'] : 'Type of Enquiry',
				'message_label'    => isset( $settings['message_label'] ) ? $settings['message_label'] : 'Your Message',
				'submit_label'     => isset( $settings['submit_label'] ) ? $settings['submit_label'] : 'Submit Enquiry →',
				'tone'             => isset( $settings['tone'] ) ? $settings['tone'] : 'green',
				'width'            => isset( $settings['width'] ) ? $settings['width'] : 'contained',
			)
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
