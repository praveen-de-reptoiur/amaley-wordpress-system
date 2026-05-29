<?php
/**
 * Plugin Name: Amaley UI Sections Kit
 * Plugin URI:  https://amaleycollective.com/
 * Description: Lightweight, scoped UI foundation components for Amaley. Adds Amaley UI components, product display shortcodes, Home Hero V6, Page Trust Strip and Pages Hero Other widgets with conditional asset loading.
 * Version: 0.6.1
 * Author:      Praveen
 * Text Domain: amaley-ui-sections-kit
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_VERSION' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_VERSION', '0.6.1' );
}

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_FILE' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_FILE', __FILE__ );
}

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_DIR' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'AMALEY_UI_SECTIONS_KIT_URL' ) ) {
	define( 'AMALEY_UI_SECTIONS_KIT_URL', plugin_dir_url( __FILE__ ) );
}

require_once AMALEY_UI_SECTIONS_KIT_DIR . 'includes/class-amaley-ui-sections-kit.php';

Amaley_UI_Sections_Kit::instance();
