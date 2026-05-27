<?php
/**
 * Main plugin bootstrap class.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Coordinates frontend assets and shortcode registration.
 */
final class Amaley_UI_Sections_Kit {

	/**
	 * Singleton instance.
	 *
	 * @var Amaley_UI_Sections_Kit|null
	 */
	private static $instance = null;

	/**
	 * Shortcode manager.
	 *
	 * @var Amaley_UI_Shortcodes
	 */
	private $shortcodes;

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

	/**
	 * Private constructor for singleton.
	 */
	private function __construct() {
		$this->shortcodes = new Amaley_UI_Shortcodes();
		$this->hooks();
	}

	/**
	 * Registers WordPress hooks.
	 *
	 * @return void
	 */
	private function hooks() {
		add_action( 'init', array( $this->shortcodes, 'register' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Enqueues the tiny scoped frontend CSS.
	 *
	 * Phase 1 intentionally avoids JavaScript and heavy libraries. CSS is scoped
	 * with the .amaley-ui-* prefix and is safe to load on the frontend. Developers
	 * can disable this globally and enqueue manually if a later performance audit
	 * requires per-page loading.
	 *
	 * @return void
	 */
	public function enqueue_frontend_assets() {
		if ( is_admin() ) {
			return;
		}

		$should_enqueue = apply_filters( 'amaley_ui_sections_kit_enqueue_frontend_assets', true );

		if ( ! $should_enqueue ) {
			return;
		}

		wp_enqueue_style(
			'amaley-ui-sections-kit',
			AMALEY_UI_SECTIONS_KIT_URL . 'assets/css/amaley-ui-sections-kit.css',
			array(),
			AMALEY_UI_SECTIONS_KIT_VERSION
		);
	}
}
