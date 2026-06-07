<?php
/**
 * Plugin Name: Amaley Compact Widgets
 * Plugin URI: https://amaleycollective.com/
 * Description: Professional, compact, mobile-first Elementor widgets and shortcodes for Amaley page sections. Merged safe home-section widgets from Compact Spacing Controls v1.0.23: Mission/Vision Visual Statement, Process Journey, Origin Pillars, Livelihood Chain Band, Gifting Feature Split, and extra Split/Origin controls.
 * Version: 0.4.19
 * Author: Praveen
 * Text Domain: amaley-compact-widgets
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'AMALEY_CW_VERSION' ) ) {
    define( 'AMALEY_CW_VERSION', '0.4.19' );
}
if ( ! defined( 'AMALEY_CW_FILE' ) ) {
    define( 'AMALEY_CW_FILE', __FILE__ );
}
if ( ! defined( 'AMALEY_CW_PATH' ) ) {
    define( 'AMALEY_CW_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'AMALEY_CW_URL' ) ) {
    define( 'AMALEY_CW_URL', plugin_dir_url( __FILE__ ) );
}

require_once AMALEY_CW_PATH . 'includes/class-amaley-cw-renderer.php';
require_once AMALEY_CW_PATH . 'includes/class-amaley-cw-origin-map.php';
require_once AMALEY_CW_PATH . 'includes/class-amaley-cw-shortcodes.php';
require_once AMALEY_CW_PATH . 'includes/class-amaley-cw-plugin.php';

Amaley_CW_Plugin::instance();
