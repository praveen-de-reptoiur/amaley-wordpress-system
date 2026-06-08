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
 * v0.6.4-staging:
 * - Keeps approved Style 10 controls untouched.
 * - Adds variation-wise controls for all remaining styles.
 * - Hides old mixed shared panels by replacing them with selected-style panels.
 * - No WooCommerce, Discovery, Core, Templates, header/footer or global CSS changes.
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

		$this->remaining_variation_visibility_controls();

		/* Style 10 single visibility panel. Uses Elementor responsive controls for Desktop / Tablet / Mobile visibility. */
		$this->start_controls_section( 'apho_s10_device_visibility', array( 'label' => esc_html__( 'Style 10 — Visibility (Device Wise)', 'amaley-ui-sections-kit' ), 'condition' => array( 'hero_style' => 'style-10' ) ) );
		$this->add_responsive_control( 's10_device_hide_kicker', array( 'label' => esc_html__( 'Hide Kicker on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__kicker' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_title', array( 'label' => esc_html__( 'Hide Title on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__title' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_accent', array( 'label' => esc_html__( 'Hide Accent on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__title em' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_description', array( 'label' => esc_html__( 'Hide Description on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__description' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_buttons', array( 'label' => esc_html__( 'Hide All Buttons on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'separator' => 'before', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__actions' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_primary_button', array( 'label' => esc_html__( 'Hide Primary Button on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--primary' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_secondary_button', array( 'label' => esc_html__( 'Hide Secondary Button on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--secondary' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_media', array( 'label' => esc_html__( 'Hide Image / Media on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'separator' => 'before', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-media-wrap' => 'display:none !important;', '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-grid' => 'grid-template-columns:minmax(0,1fr) !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_media_frame', array( 'label' => esc_html__( 'Hide Image Frame on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-media-wrap::before' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_note', array( 'label' => esc_html__( 'Hide Note Card on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'separator' => 'before', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_note_kicker', array( 'label' => esc_html__( 'Hide Note Kicker on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-kicker' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_note_title', array( 'label' => esc_html__( 'Hide Note Title on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-title' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_note_text', array( 'label' => esc_html__( 'Hide Note Text on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-text' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_stats', array( 'label' => esc_html__( 'Hide Stats on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'separator' => 'before', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stats' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_stat_values', array( 'label' => esc_html__( 'Hide Stat Values on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat-value, {{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat strong' => 'display:none !important;' ) ) );
		$this->add_responsive_control( 's10_device_hide_stat_labels', array( 'label' => esc_html__( 'Hide Stat Labels on Device', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat-label, {{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat span' => 'display:none !important;' ) ) );
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

		$this->remaining_variation_style_controls();
		$this->style10_controls();
	}


	/** Remaining style definitions used by the v0.6.4 variation-wise controls. */
	private function remaining_style_definitions() {
		return array(
			'style-1'  => array( 'prefix' => 's1', 'label' => 'Style 1 — Story Split', 'layout' => 'text', 'side' => true ),
			'style-2'  => array( 'prefix' => 's2', 'label' => 'Style 2 — Cluster / Traceability', 'layout' => 'cluster', 'stats' => 'content' ),
			'style-3'  => array( 'prefix' => 's3', 'label' => 'Style 3 — Collections / Intent Card', 'layout' => 'collections', 'intent' => true, 'stats' => 'intent' ),
			'style-5'  => array( 'prefix' => 's5', 'label' => 'Style 5 — Contact / Minimal', 'layout' => 'minimal' ),
			'style-6'  => array( 'prefix' => 's6', 'label' => 'Style 6 — Gifting / Image Split', 'layout' => 'image', 'media' => true ),
			'style-7'  => array( 'prefix' => 's7', 'label' => 'Style 7 — Premium Editorial Ribbon', 'layout' => 'editorial', 'media' => true, 'note' => true, 'stats' => 'editorial' ),
			'style-8'  => array( 'prefix' => 's8', 'label' => 'Style 8 — Centered Statement', 'layout' => 'statement', 'pills' => true ),
			'style-9'  => array( 'prefix' => 's9', 'label' => 'Style 9 — Framed Origin Editorial', 'layout' => 'editorial', 'media' => true, 'note' => true, 'stats' => 'editorial' ),
			'style-11' => array( 'prefix' => 's11', 'label' => 'Style 11 — Warm Story Editorial', 'layout' => 'editorial', 'media' => true, 'note' => true, 'stats' => 'editorial' ),
			'style-12' => array( 'prefix' => 's12', 'label' => 'Style 12 — Centered Trust Board', 'layout' => 'statement', 'pills' => true ),
			'style-13' => array( 'prefix' => 's13', 'label' => 'Style 13 — Quiet Minimal Statement', 'layout' => 'statement', 'pills' => true ),
		);
	}

	/** Add device-wise visibility controls for all non-Style-10 variations. */
	private function remaining_variation_visibility_controls() {
		foreach ( $this->remaining_style_definitions() as $style => $def ) {
			$this->add_variation_visibility_controls( $style, $def );
		}
	}

	/** Add style controls for all non-Style-10 variations. */
	private function remaining_variation_style_controls() {
		foreach ( $this->remaining_style_definitions() as $style => $def ) {
			$this->add_variation_layout_controls( $style, $def );
			$this->add_variation_typography_controls( $style, $def );

			if ( ! empty( $def['side'] ) ) {
				$this->add_variation_side_card_controls( $style, $def );
			}

			if ( ! empty( $def['intent'] ) ) {
				$this->add_variation_intent_card_controls( $style, $def );
			}

			if ( ! empty( $def['media'] ) ) {
				$this->add_variation_media_controls( $style, $def );
			}

			if ( ! empty( $def['note'] ) ) {
				$this->add_variation_note_controls( $style, $def );
			}

			if ( ! empty( $def['stats'] ) ) {
				$this->add_variation_stats_controls( $style, $def );
			}

			if ( ! empty( $def['pills'] ) ) {
				$this->add_variation_statement_pill_controls( $style, $def );
			}

			$this->add_variation_button_controls( $style, $def );
		}
	}

	private function style_base_selector( $style ) {
		return '{{WRAPPER}} .amaley-pages-hero-other--' . $style;
	}

	private function style_layout_selector( $style, $def ) {
		$base = $this->style_base_selector( $style );

		switch ( $def['layout'] ) {
			case 'text':
				return $base . ' .amaley-pages-hero-other__text-grid';
			case 'collections':
				return $base . ' .amaley-pages-hero-other__collections-grid';
			case 'image':
				return $base . ' .amaley-pages-hero-other__image-grid';
			case 'editorial':
				return $base . ' .amaley-pages-hero-other__editorial-grid';
			case 'statement':
				return $base . ' .amaley-pages-hero-other__statement-wrap';
			case 'minimal':
				return $base . ' .amaley-pages-hero-other__inner';
			case 'cluster':
			default:
				return $base . ' .amaley-pages-hero-other__cluster-wrap';
		}
	}

	private function stats_selector( $style, $def ) {
		$base = $this->style_base_selector( $style );

		if ( isset( $def['stats'] ) && 'intent' === $def['stats'] ) {
			return $base . ' .amaley-pages-hero-other__intent-card .amaley-pages-hero-other__stats';
		}

		if ( isset( $def['stats'] ) && 'editorial' === $def['stats'] ) {
			return $base . ' .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stats';
		}

		return $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__stats';
	}

	private function add_device_hide_control( $control_id, $label, $selectors, $separator = '' ) {
		$args = array(
			'label'        => esc_html__( $label, 'amaley-ui-sections-kit' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'selectors'    => $selectors,
		);

		if ( '' !== $separator ) {
			$args['separator'] = $separator;
		}

		$this->add_responsive_control( $control_id, $args );
	}

	private function add_variation_visibility_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );

		$this->start_controls_section(
			'apho_' . $prefix . '_device_visibility',
			array(
				'label'     => esc_html__( $def['label'] . ' — Visibility (Device Wise)', 'amaley-ui-sections-kit' ),
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_device_hide_control( $prefix . '_device_hide_kicker', 'Hide Kicker on Device', array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__kicker' => 'display:none !important;' ) );
		$this->add_device_hide_control( $prefix . '_device_hide_title', 'Hide Title on Device', array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__title' => 'display:none !important;' ) );
		$this->add_device_hide_control( $prefix . '_device_hide_accent', 'Hide Accent on Device', array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__title em' => 'display:none !important;' ) );
		$this->add_device_hide_control( $prefix . '_device_hide_description', 'Hide Description on Device', array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__description' => 'display:none !important;' ) );
		$this->add_device_hide_control( $prefix . '_device_hide_buttons', 'Hide All Buttons on Device', array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__actions' => 'display:none !important;' ), 'before' );
		$this->add_device_hide_control( $prefix . '_device_hide_primary_button', 'Hide Primary Button on Device', array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__actions .amaley-pages-hero-other__btn--primary' => 'display:none !important;' ) );
		$this->add_device_hide_control( $prefix . '_device_hide_secondary_button', 'Hide Secondary Button on Device', array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__actions .amaley-pages-hero-other__btn--secondary' => 'display:none !important;' ) );

		if ( ! empty( $def['side'] ) ) {
			$this->add_device_hide_control( $prefix . '_device_hide_side_panel', 'Hide Right Text Panel on Device', array( $base . ' .amaley-pages-hero-other__side-text' => 'display:none !important;', $base . ' .amaley-pages-hero-other__text-grid' => 'grid-template-columns:minmax(0,1fr) !important;' ), 'before' );
			$this->add_device_hide_control( $prefix . '_device_hide_side_title', 'Hide Right Panel Title on Device', array( $base . ' .amaley-pages-hero-other__side-title' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_side_text', 'Hide Right Panel Text on Device', array( $base . ' .amaley-pages-hero-other__side-description' => 'display:none !important;' ) );
		}

		if ( ! empty( $def['intent'] ) ) {
			$this->add_device_hide_control( $prefix . '_device_hide_intent_card', 'Hide Intent Card on Device', array( $base . ' .amaley-pages-hero-other__intent-card' => 'display:none !important;', $base . ' .amaley-pages-hero-other__collections-grid' => 'grid-template-columns:minmax(0,1fr) !important;' ), 'before' );
			$this->add_device_hide_control( $prefix . '_device_hide_intent_kicker', 'Hide Intent Card Kicker on Device', array( $base . ' .amaley-pages-hero-other__intent-kicker' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_intent_title', 'Hide Intent Card Title on Device', array( $base . ' .amaley-pages-hero-other__intent-title' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_intent_text', 'Hide Intent Card Text on Device', array( $base . ' .amaley-pages-hero-other__intent-description' => 'display:none !important;' ) );
		}

		if ( ! empty( $def['media'] ) ) {
			$layout_selector = $this->style_layout_selector( $style, $def );
			$media_wrap      = 'editorial' === $def['layout'] ? $base . ' .amaley-pages-hero-other__editorial-media-wrap' : $base . ' .amaley-pages-hero-other__media';
			$this->add_device_hide_control( $prefix . '_device_hide_media', 'Hide Image / Media on Device', array( $media_wrap => 'display:none !important;', $layout_selector => 'grid-template-columns:minmax(0,1fr) !important;' ), 'before' );

			if ( 'editorial' === $def['layout'] ) {
				$this->add_device_hide_control( $prefix . '_device_hide_media_frame', 'Hide Image Frame on Device', array( $base . ' .amaley-pages-hero-other__editorial-media-wrap::before' => 'display:none !important;' ) );
			}
		}

		if ( ! empty( $def['note'] ) ) {
			$this->add_device_hide_control( $prefix . '_device_hide_note', 'Hide Note Card on Device', array( $base . ' .amaley-pages-hero-other__editorial-note' => 'display:none !important;' ), 'before' );
			$this->add_device_hide_control( $prefix . '_device_hide_note_kicker', 'Hide Note Kicker on Device', array( $base . ' .amaley-pages-hero-other__note-kicker' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_note_title', 'Hide Note Title on Device', array( $base . ' .amaley-pages-hero-other__note-title' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_note_text', 'Hide Note Text on Device', array( $base . ' .amaley-pages-hero-other__note-text' => 'display:none !important;' ) );
		}

		if ( ! empty( $def['stats'] ) ) {
			$stats_selector = $this->stats_selector( $style, $def );
			$this->add_device_hide_control( $prefix . '_device_hide_stats', 'Hide Stats / Proof on Device', array( $stats_selector => 'display:none !important;' ), 'before' );
			$this->add_device_hide_control( $prefix . '_device_hide_stat_values', 'Hide Stat Values on Device', array( $stats_selector . ' .amaley-pages-hero-other__stat-value, ' . $stats_selector . ' .amaley-pages-hero-other__stat strong' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_stat_labels', 'Hide Stat Labels on Device', array( $stats_selector . ' .amaley-pages-hero-other__stat-label, ' . $stats_selector . ' .amaley-pages-hero-other__stat span' => 'display:none !important;' ) );
		}

		if ( ! empty( $def['pills'] ) ) {
			$this->add_device_hide_control( $prefix . '_device_hide_statement_frame', 'Hide Outer Frame on Device', array( $base . '::before' => 'display:none !important;' ), 'before' );
			$this->add_device_hide_control( $prefix . '_device_hide_pills', 'Hide Statement Pills on Device', array( $base . ' .amaley-pages-hero-other__statement-pills' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_pill_titles', 'Hide Pill Titles on Device', array( $base . ' .amaley-pages-hero-other__statement-pill-title' => 'display:none !important;' ) );
			$this->add_device_hide_control( $prefix . '_device_hide_pill_texts', 'Hide Pill Text on Device', array( $base . ' .amaley-pages-hero-other__statement-pill-text' => 'display:none !important;' ) );
		}

		$this->end_controls_section();
	}

	private function add_variation_layout_controls( $style, $def ) {
		$prefix          = $def['prefix'];
		$base            = $this->style_base_selector( $style );
		$layout_selector = $this->style_layout_selector( $style, $def );

		$this->start_controls_section(
			'apho_' . $prefix . '_layout',
			array(
				'label'     => esc_html__( $def['label'] . ' — Layout', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_responsive_control( $prefix . '_section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( $base . ' .amaley-pages-hero-other__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_content_max_width', array( 'label' => esc_html__( 'Content Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 240, 'max' => 1200 ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_layout_gap', array( 'label' => esc_html__( 'Column / Block Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'selectors' => array( $layout_selector => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_layout_min_height', array( 'label' => esc_html__( 'Minimum Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 900 ), 'vh' => array( 'min' => 10, 'max' => 100 ) ), 'selectors' => array( $layout_selector => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_content_alignment', array( 'label' => esc_html__( 'Text Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content' => 'text-align: {{VALUE}};' ) ) );

		if ( in_array( $def['layout'], array( 'text', 'collections', 'image', 'editorial' ), true ) ) {
			$this->add_responsive_control( $prefix . '_grid_columns', array( 'label' => esc_html__( 'Desktop Grid Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::TEXT, 'placeholder' => 'minmax(0,1fr) minmax(360px,.8fr)', 'selectors' => array( $layout_selector => 'grid-template-columns: {{VALUE}};' ) ) );
		}

		$this->end_controls_section();
	}

	private function add_variation_typography_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );

		$this->start_controls_section(
			'apho_' . $prefix . '_typography',
			array(
				'label'     => esc_html__( $def['label'] . ' — Typography', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_control( $prefix . '_kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_kicker_typography', 'label' => esc_html__( 'Kicker Typography', 'amaley-ui-sections-kit' ), 'selector' => $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__kicker' ) );
		$this->add_responsive_control( $prefix . '_kicker_spacing', array( 'label' => esc_html__( 'Kicker Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__title' ) );
		$this->add_responsive_control( $prefix . '_title_max_width', array( 'label' => esc_html__( 'Title Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 240, 'max' => 1200 ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__title' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__title em' ) );
		$this->add_control( $prefix . '_description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__description' ) );
		$this->add_responsive_control( $prefix . '_description_max_width', array( 'label' => esc_html__( 'Description Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 1000 ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__description' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );

		$this->end_controls_section();
	}

	private function add_variation_button_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );

		$this->start_controls_section(
			'apho_' . $prefix . '_buttons',
			array(
				'label'     => esc_html__( $def['label'] . ' — Buttons', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_responsive_control( $prefix . '_button_alignment', array( 'label' => esc_html__( 'Button Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-right' ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__actions' => 'justify-content: {{VALUE}};' ) ) );
		$this->add_responsive_control( $prefix . '_button_gap', array( 'label' => esc_html__( 'Button Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_button_margin_top', array( 'label' => esc_html__( 'Button Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__content > .amaley-pages-hero-other__actions' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( $base . ' .amaley-pages-hero-other__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $base . ' .amaley-pages-hero-other__btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-ui-sections-kit' ), 'selector' => $base . ' .amaley-pages-hero-other__btn' ) );
		$this->add_control( $prefix . '_primary_button_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--primary' => 'background: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_primary_button_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--primary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_primary_button_border', array( 'label' => esc_html__( 'Primary Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--primary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_secondary_button_bg', array( 'label' => esc_html__( 'Secondary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--secondary' => 'background: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_secondary_button_color', array( 'label' => esc_html__( 'Secondary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--secondary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_secondary_button_border', array( 'label' => esc_html__( 'Secondary Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--secondary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_button_hover_heading', array( 'label' => esc_html__( 'Hover', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( $prefix . '_primary_button_hover_bg', array( 'label' => esc_html__( 'Primary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--primary:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_primary_button_hover_color', array( 'label' => esc_html__( 'Primary Hover Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--primary:hover' => 'color: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_secondary_button_hover_bg', array( 'label' => esc_html__( 'Secondary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--secondary:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_secondary_button_hover_color', array( 'label' => esc_html__( 'Secondary Hover Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__btn--secondary:hover' => 'color: {{VALUE}};' ) ) );

		$this->end_controls_section();
	}

	private function add_variation_stats_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$stats  = $this->stats_selector( $style, $def );

		$this->start_controls_section(
			'apho_' . $prefix . '_stats',
			array(
				'label'     => esc_html__( $def['label'] . ' — Stats / Proof', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_responsive_control( $prefix . '_stats_columns', array( 'label' => esc_html__( 'Stats Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( '' => 'Default', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( $stats => 'display:grid !important; grid-template-columns:repeat({{VALUE}}, minmax(0,1fr));' ) ) );
		$this->add_responsive_control( $prefix . '_stats_gap', array( 'label' => esc_html__( 'Stats Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $stats => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_stats_margin_top', array( 'label' => esc_html__( 'Stats Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( $stats => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_stat_padding', array( 'label' => esc_html__( 'Each Stat Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_stat_background', array( 'label' => esc_html__( 'Each Stat Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat' => 'background: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_stat_border_color', array( 'label' => esc_html__( 'Each Stat Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat' => 'border-color: {{VALUE}}; border-style:solid;' ) ) );
		$this->add_responsive_control( $prefix . '_stat_radius', array( 'label' => esc_html__( 'Each Stat Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_stat_value_color', array( 'label' => esc_html__( 'Stat Value Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat-value, ' . $stats . ' .amaley-pages-hero-other__stat strong' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_stat_value_typography', 'label' => esc_html__( 'Stat Value Typography', 'amaley-ui-sections-kit' ), 'selector' => $stats . ' .amaley-pages-hero-other__stat-value, ' . $stats . ' .amaley-pages-hero-other__stat strong' ) );
		$this->add_control( $prefix . '_stat_label_color', array( 'label' => esc_html__( 'Stat Label Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat-label, ' . $stats . ' .amaley-pages-hero-other__stat span' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_stat_label_typography', 'label' => esc_html__( 'Stat Label Typography', 'amaley-ui-sections-kit' ), 'selector' => $stats . ' .amaley-pages-hero-other__stat-label, ' . $stats . ' .amaley-pages-hero-other__stat span' ) );
		$this->add_responsive_control( $prefix . '_stat_value_label_gap', array( 'label' => esc_html__( 'Value and Label Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat' => 'display:flex; flex-direction:column; align-items:flex-start; row-gap:{{SIZE}}{{UNIT}};', $stats . ' .amaley-pages-hero-other__stat-label, ' . $stats . ' .amaley-pages-hero-other__stat span' => 'margin-top:0;' ) ) );
		$this->add_responsive_control( $prefix . '_stat_item_gap_after_value', array( 'label' => esc_html__( 'Label Top Spacing Fallback', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( $stats . ' .amaley-pages-hero-other__stat-label, ' . $stats . ' .amaley-pages-hero-other__stat span' => 'display:block; margin-top:{{SIZE}}{{UNIT}};' ) ) );

		$this->end_controls_section();
	}

	private function add_variation_media_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );
		$media  = $base . ' .amaley-pages-hero-other__media';
		$wrap   = 'editorial' === $def['layout'] ? $base . ' .amaley-pages-hero-other__editorial-media-wrap' : $media;

		$this->start_controls_section(
			'apho_' . $prefix . '_media',
			array(
				'label'     => esc_html__( $def['label'] . ' — Image / Media', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_responsive_control( $prefix . '_media_height', array( 'label' => esc_html__( 'Image Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 120, 'max' => 850 ), 'vh' => array( 'min' => 10, 'max' => 100 ) ), 'selectors' => array( $media => 'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_media_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $media => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_media_bg', array( 'label' => esc_html__( 'Empty Image Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $media => 'background: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_media_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( '' => 'Default', 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( $media . ' img' => 'object-fit: {{VALUE}} !important;' ) ) );
		$this->add_control( $prefix . '_media_position', array( 'label' => esc_html__( 'Image Position', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( '' => 'Default', 'center center' => 'Center Center', 'center top' => 'Center Top', 'center bottom' => 'Center Bottom', 'left center' => 'Left Center', 'right center' => 'Right Center' ), 'selectors' => array( $media . ' img' => 'object-position: {{VALUE}} !important;' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => $prefix . '_media_shadow', 'label' => esc_html__( 'Image Shadow', 'amaley-ui-sections-kit' ), 'selector' => $wrap ) );

		if ( 'editorial' === $def['layout'] ) {
			$this->add_control( $prefix . '_media_frame_color', array( 'label' => esc_html__( 'Frame Line Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amaley-pages-hero-other__editorial-media-wrap::before' => 'border-color: {{VALUE}};' ) ) );
		}

		$this->end_controls_section();
	}

	private function add_variation_note_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );
		$note   = $base . ' .amaley-pages-hero-other__editorial-note';

		$this->start_controls_section(
			'apho_' . $prefix . '_note',
			array(
				'label'     => esc_html__( $def['label'] . ' — Editorial Note Card', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_control( $prefix . '_note_background', array( 'label' => esc_html__( 'Note Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $note => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( $prefix . '_note_padding', array( 'label' => esc_html__( 'Note Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( $note => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_note_radius', array( 'label' => esc_html__( 'Note Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $note => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_note_max_width', array( 'label' => esc_html__( 'Note Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 160, 'max' => 620 ) ), 'selectors' => array( $note => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_note_border_color', array( 'label' => esc_html__( 'Note Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $note => 'border-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => $prefix . '_note_shadow', 'label' => esc_html__( 'Note Shadow', 'amaley-ui-sections-kit' ), 'selector' => $note ) );
		$this->add_control( $prefix . '_note_kicker_color', array( 'label' => esc_html__( 'Note Kicker Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $note . ' .amaley-pages-hero-other__note-kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_note_kicker_typography', 'label' => esc_html__( 'Note Kicker Typography', 'amaley-ui-sections-kit' ), 'selector' => $note . ' .amaley-pages-hero-other__note-kicker' ) );
		$this->add_control( $prefix . '_note_title_color', array( 'label' => esc_html__( 'Note Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $note . ' .amaley-pages-hero-other__note-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_note_title_typography', 'label' => esc_html__( 'Note Title Typography', 'amaley-ui-sections-kit' ), 'selector' => $note . ' .amaley-pages-hero-other__note-title' ) );
		$this->add_control( $prefix . '_note_text_color', array( 'label' => esc_html__( 'Note Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $note . ' .amaley-pages-hero-other__note-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_note_text_typography', 'label' => esc_html__( 'Note Text Typography', 'amaley-ui-sections-kit' ), 'selector' => $note . ' .amaley-pages-hero-other__note-text' ) );

		$this->end_controls_section();
	}

	private function add_variation_side_card_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );
		$card   = $base . ' .amaley-pages-hero-other__side-text';

		$this->start_controls_section(
			'apho_' . $prefix . '_side_card',
			array(
				'label'     => esc_html__( $def['label'] . ' — Right Text Panel', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_card_skin_controls( $prefix, $card );
		$this->add_control( $prefix . '_side_title_color', array( 'label' => esc_html__( 'Panel Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-pages-hero-other__side-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_side_title_typography', 'label' => esc_html__( 'Panel Title Typography', 'amaley-ui-sections-kit' ), 'selector' => $card . ' .amaley-pages-hero-other__side-title' ) );
		$this->add_control( $prefix . '_side_text_color', array( 'label' => esc_html__( 'Panel Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-pages-hero-other__side-description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_side_text_typography', 'label' => esc_html__( 'Panel Text Typography', 'amaley-ui-sections-kit' ), 'selector' => $card . ' .amaley-pages-hero-other__side-description' ) );

		$this->end_controls_section();
	}

	private function add_variation_intent_card_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );
		$card   = $base . ' .amaley-pages-hero-other__intent-card';

		$this->start_controls_section(
			'apho_' . $prefix . '_intent_card',
			array(
				'label'     => esc_html__( $def['label'] . ' — Intent Card', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_card_skin_controls( $prefix . '_intent', $card );
		$this->add_control( $prefix . '_intent_kicker_color', array( 'label' => esc_html__( 'Card Kicker Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-pages-hero-other__intent-kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_intent_kicker_typography', 'label' => esc_html__( 'Card Kicker Typography', 'amaley-ui-sections-kit' ), 'selector' => $card . ' .amaley-pages-hero-other__intent-kicker' ) );
		$this->add_control( $prefix . '_intent_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-pages-hero-other__intent-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_intent_title_typography', 'label' => esc_html__( 'Card Title Typography', 'amaley-ui-sections-kit' ), 'selector' => $card . ' .amaley-pages-hero-other__intent-title' ) );
		$this->add_control( $prefix . '_intent_text_color', array( 'label' => esc_html__( 'Card Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $card . ' .amaley-pages-hero-other__intent-description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_intent_text_typography', 'label' => esc_html__( 'Card Text Typography', 'amaley-ui-sections-kit' ), 'selector' => $card . ' .amaley-pages-hero-other__intent-description' ) );

		$this->end_controls_section();
	}

	private function add_variation_statement_pill_controls( $style, $def ) {
		$prefix = $def['prefix'];
		$base   = $this->style_base_selector( $style );
		$pills  = $base . ' .amaley-pages-hero-other__statement-pills';
		$pill   = $base . ' .amaley-pages-hero-other__statement-pill';

		$this->start_controls_section(
			'apho_' . $prefix . '_statement_pills',
			array(
				'label'     => esc_html__( $def['label'] . ' — Statement Pills', 'amaley-ui-sections-kit' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'hero_style' => $style ),
			)
		);

		$this->add_responsive_control( $prefix . '_pills_columns', array( 'label' => esc_html__( 'Pill Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'options' => array( '' => 'Default', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( $pills => 'grid-template-columns:repeat({{VALUE}}, minmax(0,1fr));' ) ) );
		$this->add_responsive_control( $prefix . '_pills_gap', array( 'label' => esc_html__( 'Pill Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $pills => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_pills_margin_top', array( 'label' => esc_html__( 'Pills Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'selectors' => array( $pills => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_pills_max_width', array( 'label' => esc_html__( 'Pills Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 240, 'max' => 1300 ) ), 'selectors' => array( $pills => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_pills_background', array( 'label' => esc_html__( 'Pills Wrap Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $pills => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( $prefix . '_pill_padding', array( 'label' => esc_html__( 'Each Pill Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( $pill => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_pill_background', array( 'label' => esc_html__( 'Each Pill Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $pill => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( $prefix . '_pill_radius', array( 'label' => esc_html__( 'Each Pill Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( $pill => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_pill_border_color', array( 'label' => esc_html__( 'Each Pill Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $pill => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( $prefix . '_pill_title_color', array( 'label' => esc_html__( 'Pill Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $pill . ' .amaley-pages-hero-other__statement-pill-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_pill_title_typography', 'label' => esc_html__( 'Pill Title Typography', 'amaley-ui-sections-kit' ), 'selector' => $pill . ' .amaley-pages-hero-other__statement-pill-title' ) );
		$this->add_control( $prefix . '_pill_text_color', array( 'label' => esc_html__( 'Pill Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $pill . ' .amaley-pages-hero-other__statement-pill-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $prefix . '_pill_text_typography', 'label' => esc_html__( 'Pill Text Typography', 'amaley-ui-sections-kit' ), 'selector' => $pill . ' .amaley-pages-hero-other__statement-pill-text' ) );

		$this->end_controls_section();
	}

	private function add_card_skin_controls( $prefix, $selector ) {
		$this->add_control( $prefix . '_card_background', array( 'label' => esc_html__( 'Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( $prefix . '_card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', 'rem' ), 'selectors' => array( $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( $prefix . '_card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( $selector => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( $prefix . '_card_border_color', array( 'label' => esc_html__( 'Card Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'border-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( $prefix . '_card_min_height', array( 'label' => esc_html__( 'Card Min Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 760 ) ), 'selectors' => array( $selector => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => $prefix . '_card_shadow', 'label' => esc_html__( 'Card Shadow', 'amaley-ui-sections-kit' ), 'selector' => $selector ) );
	}

	/** Style 10 isolated pilot controls. */
	private function style10_controls() {
		$condition = array( 'hero_style' => 'style-10' );

		$this->start_controls_section( 'apho_s10_layout', array( 'label' => esc_html__( 'Style 10 — Layout', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => $condition ) );
		$this->add_responsive_control( 's10_grid_gap', array( 'label' => esc_html__( 'Grid Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_grid_min_height', array( 'label' => esc_html__( 'Grid Minimum Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 900 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-grid' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_copy_max_width', array( 'label' => esc_html__( 'Copy Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 260, 'max' => 900 ), '%' => array( 'min' => 20, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__content' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_vertical_align', array( 'label' => esc_html__( 'Vertical Align', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => esc_html__( 'Top', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-v-align-top' ), 'center' => array( 'title' => esc_html__( 'Middle', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-v-align-middle' ), 'flex-end' => array( 'title' => esc_html__( 'Bottom', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-v-align-bottom' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-grid' => 'align-items: {{VALUE}};' ) ) );
		$this->add_responsive_control( 's10_text_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy' => 'text-align: {{VALUE}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_s10_typography', array( 'label' => esc_html__( 'Style 10 — Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => $condition ) );
		$this->add_control( 's10_kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_kicker_typography', 'label' => esc_html__( 'Kicker Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__kicker' ) );
		$this->add_responsive_control( 's10_kicker_margin_bottom', array( 'label' => esc_html__( 'Kicker Bottom Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 's10_title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__title' ) );
		$this->add_responsive_control( 's10_title_max_width', array( 'label' => esc_html__( 'Title Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 260, 'max' => 1000 ), '%' => array( 'min' => 20, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__title' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 's10_accent_color', array( 'label' => esc_html__( 'Accent Word Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__title em' ) );
		$this->add_control( 's10_description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__description' ) );
		$this->add_responsive_control( 's10_description_max_width', array( 'label' => esc_html__( 'Description Max Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 900 ), '%' => array( 'min' => 20, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__description' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_description_margin_top', array( 'label' => esc_html__( 'Description Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__description' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_s10_media', array( 'label' => esc_html__( 'Style 10 — Image / Media', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => $condition ) );
		$this->add_responsive_control( 's10_media_height', array( 'label' => esc_html__( 'Image Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 140, 'max' => 760 ), 'vh' => array( 'min' => 10, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-media-wrap .amaley-pages-hero-other__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 's10_image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10' => '--apho-img-fit: {{VALUE}};' ) ) );
		$this->add_responsive_control( 's10_image_focus_x', array( 'label' => esc_html__( 'Image Horizontal Focus', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10' => '--apho-img-x: {{SIZE}}%;' ) ) );
		$this->add_responsive_control( 's10_image_focus_y', array( 'label' => esc_html__( 'Image Vertical Focus', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10' => '--apho-img-y: {{SIZE}}%;' ) ) );
		$this->add_responsive_control( 's10_media_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__media' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_media_border_width', array( 'label' => esc_html__( 'Image Border Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 10 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__media' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;' ) ) );
		$this->add_control( 's10_media_border_color', array( 'label' => esc_html__( 'Image Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__media' => 'border-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 's10_media_shadow', 'label' => esc_html__( 'Image Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__media' ) );
		$this->add_control( 's10_disable_hover_zoom', array( 'label' => esc_html__( 'Disable Image Hover Zoom', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__media:hover img' => 'transform: none; filter: none;' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_s10_note', array( 'label' => esc_html__( 'Style 10 — Editorial Note Card', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => $condition ) );
		$this->add_control( 's10_note_bg', array( 'label' => esc_html__( 'Note Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 's10_note_padding', array( 'label' => esc_html__( 'Note Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_note_margin_top', array( 'label' => esc_html__( 'Note Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_note_radius', array( 'label' => esc_html__( 'Note Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_note_border_width', array( 'label' => esc_html__( 'Note Border Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 10 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;' ) ) );
		$this->add_control( 's10_note_border_color', array( 'label' => esc_html__( 'Note Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' => 'border-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 's10_note_shadow', 'label' => esc_html__( 'Note Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-note' ) );
		$this->add_control( 's10_note_kicker_color', array( 'label' => esc_html__( 'Note Kicker Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_note_kicker_typography', 'label' => esc_html__( 'Note Kicker Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-kicker' ) );
		$this->add_control( 's10_note_title_color', array( 'label' => esc_html__( 'Note Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_note_title_typography', 'label' => esc_html__( 'Note Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-title' ) );
		$this->add_control( 's10_note_text_color', array( 'label' => esc_html__( 'Note Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-text' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_note_text_typography', 'label' => esc_html__( 'Note Text Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__note-text' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_s10_stats', array( 'label' => esc_html__( 'Style 10 — Stats / Proof', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => $condition ) );
		$this->add_control( 's10_stats_hide', array( 'label' => esc_html__( 'Hide Stats Visually', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stats' => 'display: none;' ) ) );
		$this->add_responsive_control( 's10_stats_margin_top', array( 'label' => esc_html__( 'Stats Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stats' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_stats_gap', array( 'label' => esc_html__( 'Stats Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stats' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_stats_columns', array( 'label' => esc_html__( 'Stats Columns', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => 'Default', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stats' => 'display: grid; grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
		$this->add_control( 's10_stat_card_bg', array( 'label' => esc_html__( 'Stat Card Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stat' => 'background: {{VALUE}};' ) ) );
		$this->add_responsive_control( 's10_stat_card_padding', array( 'label' => esc_html__( 'Stat Card Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_stat_card_radius', array( 'label' => esc_html__( 'Stat Card Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stat' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_stat_card_border_width', array( 'label' => esc_html__( 'Stat Card Border Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 8 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stat' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;' ) ) );
		$this->add_control( 's10_stat_card_border_color', array( 'label' => esc_html__( 'Stat Card Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stat' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 's10_stat_divider_color', array( 'label' => esc_html__( 'Default Divider Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stat' => 'border-right-color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 's10_stat_card_shadow', 'label' => esc_html__( 'Stat Card Shadow', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__editorial-copy .amaley-pages-hero-other__stat' ) );
		$this->add_control( 's10_stat_value_color', array( 'label' => esc_html__( 'Stat Value Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat-value' => 'color: {{VALUE}};', '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat strong' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_stat_value_typography', 'label' => esc_html__( 'Stat Value Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat-value, {{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat strong' ) );
		$this->add_control( 's10_stat_label_color', array( 'label' => esc_html__( 'Stat Label Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat-label' => 'color: {{VALUE}};', '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat span' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_stat_label_typography', 'label' => esc_html__( 'Stat Label Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat-label, {{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat span' ) );
		$this->add_responsive_control( 's10_stat_label_spacing', array( 'label' => esc_html__( 'Stat Label Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat-label' => 'margin-top: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__stat span' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_s10_buttons', array( 'label' => esc_html__( 'Style 10 — Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => $condition ) );
		$this->add_responsive_control( 's10_button_alignment', array( 'label' => esc_html__( 'Button Alignment', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-ui-sections-kit' ), 'icon' => 'eicon-h-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__actions' => 'justify-content: {{VALUE}};' ) ) );
		$this->add_responsive_control( 's10_button_gap', array( 'label' => esc_html__( 'Button Gap', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_button_margin_top', array( 'label' => esc_html__( 'Button Top Spacing', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__actions' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_button_min_height', array( 'label' => esc_html__( 'Button Min Height', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 20, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 's10_button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ), '%' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 's10_button_typography', 'label' => esc_html__( 'Button Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn' ) );
		$this->add_responsive_control( 's10_button_width', array( 'label' => esc_html__( 'Button Width', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => 'Default', 'auto' => 'Auto', '100%' => 'Full Width' ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn' => 'width: {{VALUE}};' ) ) );
		$this->add_control( 's10_primary_button_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--primary' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 's10_primary_button_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--primary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 's10_primary_button_border', array( 'label' => esc_html__( 'Primary Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--primary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 's10_secondary_button_bg', array( 'label' => esc_html__( 'Secondary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--secondary' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 's10_secondary_button_color', array( 'label' => esc_html__( 'Secondary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--secondary' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 's10_secondary_button_border', array( 'label' => esc_html__( 'Secondary Border Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--secondary' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 's10_button_hover_heading', array( 'label' => esc_html__( 'Hover', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		$this->add_control( 's10_primary_button_hover_bg', array( 'label' => esc_html__( 'Primary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--primary:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 's10_primary_button_hover_color', array( 'label' => esc_html__( 'Primary Hover Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--primary:hover' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 's10_secondary_button_hover_bg', array( 'label' => esc_html__( 'Secondary Hover Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--secondary:hover' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 's10_secondary_button_hover_color', array( 'label' => esc_html__( 'Secondary Hover Text', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other--style-10 .amaley-pages-hero-other__btn--secondary:hover' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	/** Old shared controls kept for all non-Style-10 variations during pilot. */
	private function legacy_shared_style_controls() {
		$this->start_controls_section( 'apho_style_typography', array( 'label' => esc_html__( 'Typography', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style!' => 'style-10' ) ) );
		$this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__kicker' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'label' => esc_html__( 'Kicker Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__kicker' ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'label' => esc_html__( 'Title Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__title' ) );
		$this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Word Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__title em' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'accent_typography', 'label' => esc_html__( 'Accent Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__title em' ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'label' => esc_html__( 'Description Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__description' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_buttons', array( 'label' => esc_html__( 'Buttons', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style!' => 'style-10' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__btn' ) );
		$this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Primary Background', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__btn--primary' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
		$this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Primary Text Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__btn--primary' => 'color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_stats', array( 'label' => esc_html__( 'Stats / Proof', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style' => array( 'style-2', 'style-3', 'style-7', 'style-9', 'style-11' ) ) ) );
		$this->add_control( 'stats_value_color', array( 'label' => esc_html__( 'Stats Value Color', 'amaley-ui-sections-kit' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-pages-hero-other__stat strong' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'stats_value_typography', 'label' => esc_html__( 'Stats Value Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__stat strong' ) );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'stats_label_typography', 'label' => esc_html__( 'Stats Label Typography', 'amaley-ui-sections-kit' ), 'selector' => '{{WRAPPER}} .amaley-pages-hero-other__stat span' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'apho_style_cards', array( 'label' => esc_html__( 'Cards / Feature Pills', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style' => array( 'style-1', 'style-3', 'style-7', 'style-8', 'style-9', 'style-11', 'style-12', 'style-13' ) ) ) );
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

		$this->start_controls_section( 'apho_style_media', array( 'label' => esc_html__( 'Image Controls', 'amaley-ui-sections-kit' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => array( 'hero_style' => array( 'style-6', 'style-7', 'style-9', 'style-11' ) ) ) );
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
		$atts  = array(
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
			$atts['image']          = isset( $s['image']['url'] ) ? $s['image']['url'] : '';
			$atts['image_alt']      = isset( $s['image_alt'] ) ? $s['image_alt'] : '';
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
