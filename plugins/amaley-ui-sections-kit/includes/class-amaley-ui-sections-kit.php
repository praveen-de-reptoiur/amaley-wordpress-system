<?php
/**
 * Main plugin bootstrap class.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Coordinates frontend assets, shortcode registration and Elementor integration.
 */
final class Amaley_UI_Sections_Kit {

	/** @var Amaley_UI_Sections_Kit|null */
	private static $instance = null;

	/** @var Amaley_UI_Shortcodes */
	private $shortcodes;

	/** @var Amaley_UI_Elementor_Loader|null */
	private $elementor_loader;

	/**
	 * Returns the singleton instance.
	 *
	 * @return Amaley_UI_Sections_Kit
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/** Private constructor for singleton. */
	private function __construct() {
		$this->shortcodes       = new Amaley_UI_Shortcodes();
		$this->elementor_loader = class_exists( 'Amaley_UI_Elementor_Loader' ) ? new Amaley_UI_Elementor_Loader() : null;
		$this->hooks();
	}

	/** Registers WordPress hooks. */
	private function hooks() {
		add_action( 'init', array( $this->shortcodes, 'register' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );

		if ( $this->elementor_loader ) {
			$this->elementor_loader->hooks();
		}
	}

	/**
	 * Registers all frontend assets without loading them automatically.
	 *
	 * @return void
	 */
	private function register_frontend_assets() {
		wp_register_style(
			'amaley-ui-sections-kit',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-sections-kit.css',
			array(),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-page-trust-strip',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-page-trust-strip.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-home-hero-v6',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-home-hero-v6.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-pages-hero-other',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-pages-hero-other.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-collection-purpose-routes',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-collection-purpose-routes.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-featured-collection-cards',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-featured-collection-cards.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-collection-detail-split',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-collection-detail-split.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-bulk-orders-band',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-bulk-orders-band.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_style(
			'amaley-ui-gifting-enquiry-section',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-gifting-enquiry-section.css',
			array( 'amaley-ui-sections-kit' ),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);

		wp_register_script(
			'amaley-ui-home-hero-v6',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/js/amaley-ui-home-hero-v6.js',
			array(),
			AMALEY_UI_SECTIONS_KIT_VERSION,
			true
		);
	}

	/**
	 * Enqueues scoped frontend assets only when the current page uses them.
	 *
	 * v0.6.2 performance rule:
	 * - Base CSS loads only on pages using Amaley UI shortcodes/widgets.
	 * - Page Trust Strip CSS loads only when Page Trust Strip is present.
	 * - Home Hero CSS/JS loads only when Home Hero V6 is present.
	 * - Pages Hero CSS loads only when Pages Hero Other is present.
	 * - Elementor editor/preview loads all registered assets for safe editing.
	 *
	 * @return void
	 */
	public function enqueue_frontend_assets() {
		if ( is_admin() ) {
			return;
		}

		$this->register_frontend_assets();

		$should_enqueue = apply_filters( 'amaley_ui_sections_kit_enqueue_frontend_assets', true );
		if ( ! $should_enqueue ) {
			return;
		}

		if ( apply_filters( 'amaley_ui_sections_kit_enqueue_all_assets', false ) || $this->is_elementor_edit_or_preview() ) {
			$this->enqueue_all_frontend_assets();
			return;
		}

		$handles = $this->detect_required_asset_handles();
		$handles = array_merge( $handles, $this->forced_asset_handles() );
		$handles = array_values( array_unique( array_filter( $handles ) ) );

		foreach ( $handles as $handle ) {
			$this->enqueue_asset_handle( $handle );
		}
	}

	/** Enqueues all registered assets for Elementor edit/preview safety. */
	private function enqueue_all_frontend_assets() {
		$this->enqueue_asset_handle( 'amaley-ui-sections-kit' );
		$this->enqueue_asset_handle( 'amaley-ui-page-trust-strip' );
		$this->enqueue_asset_handle( 'amaley-ui-home-hero-v6' );
		$this->enqueue_asset_handle( 'amaley-ui-pages-hero-other' );
		$this->enqueue_asset_handle( 'amaley-ui-collection-purpose-routes' );
		$this->enqueue_asset_handle( 'amaley-ui-featured-collection-cards' );
		$this->enqueue_asset_handle( 'amaley-ui-collection-detail-split' );
		$this->enqueue_asset_handle( 'amaley-ui-bulk-orders-band' );
		$this->enqueue_asset_handle( 'amaley-ui-gifting-enquiry-section' );
	}

	/**
	 * Enqueue a single registered asset handle safely.
	 *
	 * @param string $handle Asset handle.
	 * @return void
	 */
	private function enqueue_asset_handle( $handle ) {
		switch ( $handle ) {
			case 'amaley-ui-sections-kit':
			case 'amaley-ui-page-trust-strip':
			case 'amaley-ui-home-hero-v6':
			case 'amaley-ui-pages-hero-other':
			case 'amaley-ui-collection-purpose-routes':
			case 'amaley-ui-featured-collection-cards':
			case 'amaley-ui-collection-detail-split':
			case 'amaley-ui-bulk-orders-band':
			case 'amaley-ui-gifting-enquiry-section':
				wp_enqueue_style( $handle );
				break;

			case 'amaley-ui-home-hero-v6-js':
				wp_enqueue_script( 'amaley-ui-home-hero-v6' );
				break;
		}
	}

	/**
	 * Allows developers to force asset handles if a page builder renders dynamic content late.
	 *
	 * @return array
	 */
	private function forced_asset_handles() {
		$handles = apply_filters( 'amaley_ui_sections_kit_force_asset_handles', array() );
		return is_array( $handles ) ? $handles : array();
	}

	/**
	 * Detects required assets from post content and Elementor data.
	 *
	 * @return array
	 */
	private function detect_required_asset_handles() {
		$content = $this->current_page_source_string();
		$handles = array();

		if ( '' === $content ) {
			return $handles;
		}

		$base_needles = array(
			'[amaley_section_heading',
			'[amaley_button',
			'[amaley_button_group',
			'[amaley_trust_item',
			'[amaley_page_trust_strip',
			'[amaley_trust_strip',
			'[amaley_brand_promise',
			'[amaley_cta_band',
			'[amaley_empty_state',
			'[amaley_product_card',
			'[amaley_product_grid',
			'[amaley_home_hero_v6',
			'[amaley_pages_hero_other',
			'[amaley_collection_purpose_routes',
			'[amaley_featured_collection_cards',
			'[amaley_collection_detail_split',
			'[amaley_bulk_orders_band',
			'[amaley_gifting_enquiry_section',
			'amaley_ui_page_trust_strip',
			'amaley_ui_home_hero_v6',
			'amaley_ui_pages_hero_other',
			'amaley_ui_collection_purpose_routes',
			'amaley_ui_featured_collection_cards',
			'amaley_ui_collection_detail_split',
			'amaley_ui_bulk_orders_band',
			'amaley_ui_gifting_enquiry_section',
		);

		if ( $this->string_contains_any( $content, $base_needles ) ) {
			$handles[] = 'amaley-ui-sections-kit';
		}

		if ( $this->string_contains_any( $content, array( '[amaley_page_trust_strip', '[amaley_trust_strip', 'amaley_ui_page_trust_strip' ) ) ) {
			$handles[] = 'amaley-ui-page-trust-strip';
		}

		if ( $this->string_contains_any( $content, array( '[amaley_home_hero_v6', 'amaley_ui_home_hero_v6' ) ) ) {
			$handles[] = 'amaley-ui-home-hero-v6';
			$handles[] = 'amaley-ui-home-hero-v6-js';
		}

		if ( $this->string_contains_any( $content, array( '[amaley_pages_hero_other', 'amaley_ui_pages_hero_other' ) ) ) {
			$handles[] = 'amaley-ui-pages-hero-other';
		}


		if ( $this->string_contains_any( $content, array( '[amaley_collection_purpose_routes', 'amaley_ui_collection_purpose_routes' ) ) ) {
			$handles[] = 'amaley-ui-collection-purpose-routes';
		}

		if ( $this->string_contains_any( $content, array( '[amaley_featured_collection_cards', 'amaley_ui_featured_collection_cards' ) ) ) {
			$handles[] = 'amaley-ui-featured-collection-cards';
		}

		if ( $this->string_contains_any( $content, array( '[amaley_collection_detail_split', 'amaley_ui_collection_detail_split' ) ) ) {
			$handles[] = 'amaley-ui-collection-detail-split';
		}

		if ( $this->string_contains_any( $content, array( '[amaley_bulk_orders_band', 'amaley_ui_bulk_orders_band' ) ) ) {
			$handles[] = 'amaley-ui-bulk-orders-band';
		}

		if ( $this->string_contains_any( $content, array( '[amaley_gifting_enquiry_section', 'amaley_ui_gifting_enquiry_section' ) ) ) {
			$handles[] = 'amaley-ui-gifting-enquiry-section';
		}

		return apply_filters( 'amaley_ui_sections_kit_detected_asset_handles', $handles, $content );
	}

	/**
	 * Returns current post content plus Elementor data for asset detection.
	 *
	 * @return string
	 */
	private function current_page_source_string() {
		$post_id = get_queried_object_id();

		if ( ! $post_id ) {
			return '';
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			return '';
		}

		$content = (string) $post->post_content;
		$elementor_data = get_post_meta( $post_id, '_elementor_data', true );

		if ( is_string( $elementor_data ) && '' !== $elementor_data ) {
			$content .= ' ' . $elementor_data;
		}

		return strtolower( $content );
	}

	/**
	 * Checks whether a string contains any needle.
	 *
	 * @param string $haystack Haystack string.
	 * @param array  $needles Needles.
	 * @return bool
	 */
	private function string_contains_any( $haystack, $needles ) {
		foreach ( $needles as $needle ) {
			if ( false !== strpos( $haystack, strtolower( $needle ) ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Detects Elementor editor/preview contexts where assets should be safely available.
	 *
	 * @return bool
	 */
	private function is_elementor_edit_or_preview() {
		if ( isset( $_GET['elementor-preview'] ) || isset( $_GET['preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		if ( class_exists( '\\Elementor\\Plugin' ) ) {
			$elementor = \Elementor\Plugin::$instance;

			if ( isset( $elementor->editor ) && method_exists( $elementor->editor, 'is_edit_mode' ) && $elementor->editor->is_edit_mode() ) {
				return true;
			}

			if ( isset( $elementor->preview ) && method_exists( $elementor->preview, 'is_preview_mode' ) && $elementor->preview->is_preview_mode() ) {
				return true;
			}
		}

		return false;
	}
}
