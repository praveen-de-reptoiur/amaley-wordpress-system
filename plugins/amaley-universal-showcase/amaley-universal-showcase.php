<?php
/**
 * Plugin Name: Amaley Universal Showcase
 * Description: Standalone Elementor showcase widget for Amaley Core content: Cluster, SHG, Member and Product grid/slider/list sections.
 * Version: 1.0.20
 * Author: Praveen
 * Text Domain: amaley-universal-showcase
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'AUS_VERSION' ) ) { define( 'AUS_VERSION', '1.0.20' ); }
if ( ! defined( 'AUS_FILE' ) ) { define( 'AUS_FILE', __FILE__ ); }
if ( ! defined( 'AUS_PATH' ) ) { define( 'AUS_PATH', plugin_dir_path( __FILE__ ) ); }
if ( ! defined( 'AUS_URL' ) ) { define( 'AUS_URL', plugin_dir_url( __FILE__ ) ); }

require_once AUS_PATH . 'includes/class-aus-plugin.php';

if ( ! function_exists( 'aus_plugin' ) ) {
function aus_plugin() {
    static $instance = null;
    if ( null === $instance ) {
        $instance = new AUS_Plugin();
    }
    return $instance;
}
add_action( 'plugins_loaded', 'aus_plugin' );
}
