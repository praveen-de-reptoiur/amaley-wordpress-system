<?php
/**
 * Plugin Name: Amaley Site Shell
 * Plugin URI:  https://amaleycollective.com/
 * Description: Lightweight, scoped, mobile-first header/footer shell for Amaley. Provides header, footer, navigation, mobile drawer, shortcodes and safe Elementor widgets.
 * Version:     1.0.1
 * Author:      Praveen
 * Text Domain: amaley-site-shell
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( defined( 'AMALEY_SHELL_VERSION' ) ) {
    return;
}

define( 'AMALEY_SHELL_VERSION', '1.0.1' );
define( 'AMALEY_SHELL_FILE', __FILE__ );
define( 'AMALEY_SHELL_PATH', plugin_dir_path( __FILE__ ) );
define( 'AMALEY_SHELL_URL', plugin_dir_url( __FILE__ ) );

require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell.php';

register_activation_hook( __FILE__, array( 'Amaley_Shell', 'activate' ) );

add_action( 'plugins_loaded', static function() {
    Amaley_Shell::instance();
} );
