<?php
/**
 * Plugin Name: Amaley UI Sections Kit
 * Plugin URI:  https://amaleycollective.com/
 * Description: Lightweight, scoped UI foundation components for Amaley. Includes headings, buttons, trust sections, CTA bands, empty states, and temporary product card/grid display components.
 * Version: 0.2.5
 * Author:      Praveen
 * Text Domain: amaley-ui-sections-kit
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_VERSION' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_VERSION', '0.2.5' );
}

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_FILE' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_FILE', __FILE__ );
}

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_PATH' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_URL' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_URL', plugin_dir_url( __FILE__ ) );
}

require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/helpers/class-amaley-ui-helpers.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/class-amaley-ui-token-registry.php';

require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-section-container.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-section-heading.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-button.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-button-group.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-trust-item.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-brand-promise.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-cta-band.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-empty-state.php';

/**
 * Temporary product display renderers.
 *
 * WooCommerce remains the commerce engine.
 * These renderers only display selected products through shortcodes.
 */
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-product-card.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-product-grid.php';

require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/class-amaley-ui-shortcodes.php';
require_once AMALEY_UI_SECTIONS_KIT_PATH . 'includes/class-amaley-ui-sections-kit.php';

if ( ! function_exists( 'amaley_ui_sections_kit' ) ) {
	/**
	 * Returns the plugin singleton.
	 *
	 * @return Amaley_UI_Sections_Kit
	 */
	function amaley_ui_sections_kit() {
		return Amaley_UI_Sections_Kit::instance();
	}
}

add_action( 'plugins_loaded', 'amaley_ui_sections_kit' );
