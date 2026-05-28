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
	 * Elementor integration loader.
	 *
	 * @var Amaley_UI_Elementor_Loader|null
	 */
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

	/**
	 * Private constructor for singleton.
	 */
	private function __construct() {
		$this->shortcodes       = new Amaley_UI_Shortcodes();
		$this->elementor_loader = class_exists( 'Amaley_UI_Elementor_Loader' ) ? new Amaley_UI_Elementor_Loader() : null;
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

		if ( $this->elementor_loader ) {
			$this->elementor_loader->hooks();
		}
	}

	/**
	 * Enqueues scoped frontend CSS.
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
