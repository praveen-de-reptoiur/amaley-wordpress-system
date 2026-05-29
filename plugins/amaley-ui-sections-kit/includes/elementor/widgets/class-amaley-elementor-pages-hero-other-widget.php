<?php
/**
 * Elementor Pages Hero Other widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

/**
 * Elementor widget for Amaley inner page hero variations.
 *
 * v0.6.0: fixes style selector clarity, image left/right controls for image styles, and no-gap image media.
 */
final class Amaley_Elementor_Pages_Hero_Other_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'amaley_ui_pages_hero_other'; }
	public function get_title() { return esc_html__( 'Amaley Pages Hero Other', 'amaley-ui-sections-kit' ); }
	public function get_icon() { return 'eicon-site-title'; }
	public function get_categories() { return array( 'amaley-ui', 'general' ); }
	public function get_keywords() { return array( 'amaley', 'pages hero', 'inner hero', 'about hero', 'collection hero', 'gifting hero' ); }
	public function get_style_depends() { return array( 'amaley-ui-sections-kit', 'amaley-ui-pages-hero-other' ); }

	protected function register_controls() {
		$this->content_controls();
		$this->style_controls();
	}

	private function style_options() {
		return array(
			'style-1'  => '01 — Story Split',
			'style-2'  => '02 — Cluster / Traceability',
			'style-3'  => '03 — Collections / Intent Card',
			'style-5'  => '05 — Contact / Minimal',
			'style-6'  => '06 — Gifting / Image Split',
			'style-7'  => '07 — Premium Editorial Ribbon',
			'style-9'  => '09 — Framed Origin Editorial',
			'style-10' => '10 — Product Story Editorial',
			'style-11' => '11 — Warm Story Editorial',
			'style-8'  => '08 — Centered Statement',
			'style-12' => '12 — Centered Trust Board',
			'style-13' => '13 — Quiet Minimal Statement',
		);
	}

	private function content_controls() {
		$this->start_controls_section( 'apho_content_main', array( 'label' => esc_html__( 'Hero Content', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'hero_style', array( 'label' => esc_html__( 'Hero Style / Variation Number', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'style-1', 'options' => $this->style_options(), 'description' => esc_html__( 'The number in this dropdown is the style number. Style 4 was removed intentionally.', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'kicker', array( 'label' => esc_html__( 'Kicker / Label', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Our Story', 'label_block' => true ) );
		$this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'About, {Amaley}', 'rows' => 2, 'label_block' => true ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word / Phrase', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley', 'description' => esc_html__( 'Wrap the accent inside title with { }. Example: About, {Amaley}', 'amaley-ui-sections-kit' ) ) );
		$this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'A heart-led journey rooted in Himalayan food, women-led livelihoods, and honest ingredients made for everyday homes.', 'rows' => 4 ) );
		$this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Our Journey →' ) );
		$this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
		$this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button Link', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style1_side', array( 'label' => esc_html__( 'Style 1 — Right Text Panel', 'amaley-ui-sections-kit' ), 'condition' => array( 'hero_style' => 'style-1' ) ) );
		$this->add_control( 'style1_side_title', array( 'label' => esc_html__( 'Right Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Rooted in the Himalayas' ) );
		$this->add_control( 'style1_side_text', array( 'label' => esc_html__( 'Right Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Pure. Honest. Traceable.' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style2_stats', array( 'label' => esc_html__( 'Style 2 — Cluster Stats Only', 'amaley-ui-sections-kit' ), 'condition' => array( 'hero_style' => 'style-2' ) ) );
		$this->add_control( 'style2_stats', array( 'label' => esc_html__( 'Stats', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => '05::Clusters|05::SHG Groups|Traceable::Place to Product', 'description' => 'Format: value::label|value::label. Bottom feature strip removed in v0.5.9.' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style3_card', array( 'label' => esc_html__( 'Style 3 — Intent Card', 'amaley-ui-sections-kit' ), 'condition' => array( 'hero_style' => 'style-3' ) ) );
		$this->add_control( 'style3_side_kicker', array( 'label' => esc_html__( 'Card Kicker', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Start with intent' ) );
		$this->add_control( 'style3_side_title', array( 'label' => esc_html__( 'Card Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Choose by why you are buying.' ) );
		$this->add_control( 'style3_side_text', array( 'label' => esc_html__( 'Card Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Gift, breakfast, wellness, hospitality, retail placement, or everyday pantry.' ) );
		$this->add_control( 'style3_stats', array( 'label' => esc_html__( 'Card Stats', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '12+::Curated Lines|3::Buying Routes|100%::Place-led Story' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_image_content', array( 'label' => esc_html__( 'Image', 'amaley-ui-sections-kit' ), 'condition' => array( 'hero_style' => array( 'style-6', 'style-7', 'style-9', 'style-10', 'style-11' ) ) ) );
		$this->add_control( 'image', array( 'label' => esc_html__( 'Hero Image', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
		$this->add_control( 'image_alt', array( 'label' => esc_html__( 'Image Alt Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
		$this->add_control( 'image_position', array( 'label' => esc_html__( 'Image / Media Side', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'right', 'options' => array( 'right' => 'Image Right / Text Left', 'left' => 'Image Left / Text Right' ), 'condition' => array( 'hero_style' => array( 'style-6', 'style-7', 'style-9', 'style-10', 'style-11' ) ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_editorial_note', array( 'label' => esc_html__( 'Editorial Note / Stats', 'amaley-ui-sections-kit' ), 'condition' => array( 'hero_style' => array( 'style-7', 'style-9', 'style-10', 'style-11' ) ) ) );
		$this->add_control( 'editorial_side_kicker', array( 'label' => esc_html__( 'Note Kicker', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley Note' ) );
		$this->add_control( 'editorial_side_title', array( 'label' => esc_html__( 'Note Title', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Made with care' ) );
		$this->add_control( 'editorial_side_text', array( 'label' => esc_html__( 'Note Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'A premium note for context and trust.' ) );
		$this->add_control( 'editorial_stats', array( 'label' => esc_html__( 'Stats / Proof Items', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Natural::Ingredients|Small::Batches|Traceable::Origins' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_statement_features', array( 'label' => esc_html__( 'Statement Feature Pills', 'amaley-ui-sections-kit' ), 'condition' => array( 'hero_style' => array( 'style-8', 'style-12', 'style-13' ) ) ) );
		$this->add_control( 'statement_features', array( 'label' => esc_html__( 'Feature Pills', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Pure Ingredients::Thoughtfully sourced and prepared|Women Collectives::Community-rooted production|Small Batch::Made with discipline and care' ) );
		$this->end_controls_section();
	}

	private function style_controls() {
		$this->start_controls_section( 'apho_style_section', array( 'label' => esc_html__( 'Section / Background', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'tone', array( 'label' => esc_html__( 'Tone', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'deep', 'options' => array( 'deep' => 'Deep Chocolate', 'cream' => 'Cream' ) ) );
		$this->add_control( 'width', array( 'label' => esc_html__( 'Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'contained', 'options' => array( 'contained' => 'Contained', 'full' => 'Full Width' ) ) );
		$this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_typography', array( 'label' => esc_html__( 'Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'label' => esc_html__( 'Kicker Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__kicker' ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Word Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__title em' ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__description' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_buttons', array( 'label' => esc_html__( 'Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__btn' ) );
		$this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__btn--primary' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__btn--primary' => 'color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_stats', array( 'label' => esc_html__( 'Stats / Proof', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style' => array( 'style-2', 'style-3', 'style-7', 'style-9', 'style-10', 'style-11' ) ) ) );
		$this->add_control( 'stats_value_color', array( 'label' => esc_html__( 'Stats Value Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__stat strong' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'stats_value_typography', 'label' => esc_html__( 'Stats Value Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__stat strong' ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'stats_label_typography', 'label' => esc_html__( 'Stats Label Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__stat span' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_cards', array( 'label' => esc_html__( 'Cards / Feature Pills', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style' => array( 'style-1', 'style-3', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11', 'style-12', 'style-13' ) ) ) );
		$this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card/Pill Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__side-text, {{WRAPPER}} .amaley-pages-hero-other__intent-card, {{WRAPPER}} .amaley-pages-hero-other__editorial-note, {{WRAPPER}} .amaley-pages-hero-other__statement-pill' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'card_border_color', array( 'label' => esc_html__( 'Card Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__side-text, {{WRAPPER}} .amaley-pages-hero-other__intent-card, {{WRAPPER}} .amaley-pages-hero-other__editorial-note, {{WRAPPER}} .amaley-pages-hero-other__statement-pill' => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__side-text, {{WRAPPER}} .amaley-pages-hero-other__intent-card, {{WRAPPER}} .amaley-pages-hero-other__editorial-note, {{WRAPPER}} .amaley-pages-hero-other__statement-pill' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__side-text, {{WRAPPER}} .amaley-pages-hero-other__intent-card, {{WRAPPER}} .amaley-pages-hero-other__editorial-note, {{WRAPPER}} .amaley-pages-hero-other__statement-pill' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_features', array( 'label' => esc_html__( 'Statement Feature Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style' => array( 'style-8', 'style-12', 'style-13' ) ) ) );
		$this->add_control( 'feature_title_color', array( 'label' => esc_html__( 'Feature Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__statement-pill strong' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'feature_text_color', array( 'label' => esc_html__( 'Feature Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__statement-pill span' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'feature_title_typography', 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__statement-pill strong' ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'feature_text_typography', 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__statement-pill span' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_media', array( 'label' => esc_html__( 'Image Controls', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style' => array( 'style-6', 'style-7', 'style-9', 'style-10', 'style-11' ) ) ) );
		$this->add_responsive_control( 'media_height', array( 'label' => esc_html__( 'Image Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 160, 'max' => 760 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => '--apho-media-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => '--apho-img-fit: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'image_focus_x', array( 'label' => esc_html__( 'Image Horizontal Focus', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => '--apho-img-x: {{SIZE}}%;' ) ) );
		$this->add_responsive_control( 'image_focus_y', array( 'label' => esc_html__( 'Image Vertical Focus', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => '--apho-img-y: {{SIZE}}%;' ) ) );
		$this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Border Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => '--apho-media-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'image_border_width', array( 'label' => esc_html__( 'Image Border Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 8 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => '--apho-media-border-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'image_border_color', array( 'label' => esc_html__( 'Image Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other' => '--apho-media-border-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'image_shadow', 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__media' ) );
		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$style = isset( $s['hero_style'] ) ? $s['hero_style'] : 'style-1';
		$atts = array(
			'hero_style'     => $style,
			'kicker'         => isset( $s['kicker'] ) ? $s['kicker'] : '',
			'title'          => isset( $s['title'] ) ? $s['title'] : '',
			'accent'         => isset( $s['accent'] ) ? $s['accent'] : '',
			'description'    => isset( $s['description'] ) ? $s['description'] : '',
			'primary_text'   => isset( $s['primary_text'] ) ? $s['primary_text'] : '',
			'primary_url'    => isset( $s['primary_url']['url'] ) ? $s['primary_url']['url'] : '#',
			'secondary_text' => isset( $s['secondary_text'] ) ? $s['secondary_text'] : '',
			'secondary_url'  => isset( $s['secondary_url']['url'] ) ? $s['secondary_url']['url'] : '#',
			'tone'           => isset( $s['tone'] ) ? $s['tone'] : 'deep',
			'width'          => isset( $s['width'] ) ? $s['width'] : 'contained',
		);
		if ( 'style-1' === $style ) {
			$atts['side_title'] = isset( $s['style1_side_title'] ) ? $s['style1_side_title'] : '';
			$atts['side_text']  = isset( $s['style1_side_text'] ) ? $s['style1_side_text'] : '';
		}
		if ( 'style-2' === $style ) {
			$atts['stats'] = isset( $s['style2_stats'] ) ? $s['style2_stats'] : '';
		}
		if ( 'style-3' === $style ) {
			$atts['side_kicker'] = isset( $s['style3_side_kicker'] ) ? $s['style3_side_kicker'] : '';
			$atts['side_title']  = isset( $s['style3_side_title'] ) ? $s['style3_side_title'] : '';
			$atts['side_text']   = isset( $s['style3_side_text'] ) ? $s['style3_side_text'] : '';
			$atts['stats']       = isset( $s['style3_stats'] ) ? $s['style3_stats'] : '';
		}
		if ( in_array( $style, array( 'style-6', 'style-7', 'style-9', 'style-10', 'style-11' ), true ) ) {
			$atts['image']     = isset( $s['image']['url'] ) ? $s['image']['url'] : '';
			$atts['image_alt'] = isset( $s['image_alt'] ) ? $s['image_alt'] : '';
		}
		if ( in_array( $style, array( 'style-6', 'style-7', 'style-9', 'style-10', 'style-11' ), true ) ) {
			$atts['image_position'] = isset( $s['image_position'] ) ? $s['image_position'] : 'right';
		}
		if ( in_array( $style, array( 'style-7', 'style-9', 'style-10', 'style-11' ), true ) ) {
			$atts['side_kicker'] = isset( $s['editorial_side_kicker'] ) ? $s['editorial_side_kicker'] : '';
			$atts['side_title']  = isset( $s['editorial_side_title'] ) ? $s['editorial_side_title'] : '';
			$atts['side_text']   = isset( $s['editorial_side_text'] ) ? $s['editorial_side_text'] : '';
			$atts['stats']       = isset( $s['editorial_stats'] ) ? $s['editorial_stats'] : '';
		}
		if ( in_array( $style, array( 'style-8', 'style-12', 'style-13' ), true ) ) {
			$atts['features'] = isset( $s['statement_features'] ) ? $s['statement_features'] : '';
		}
		echo Amaley_UI_Pages_Hero_Other::render( $atts );
	}
}
