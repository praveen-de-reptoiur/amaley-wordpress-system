<?php
/**
 * Plugin Name: Amaley Discovery Engine
 * Plugin URI: https://amaley.in
 * Description: Elementor-native discovery, filtering, pagination, and listing engine for Amaley products and existing mapped content types. Does not register default CPTs.
 * Version: 1.3.5
 * Author: Praveen
 * Text Domain: amaley-discovery-engine
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Tested up to: 6.7
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

define('AMALEY_DE_VERSION', '1.3.5');
define('AMALEY_DE_FILE', __FILE__);
define('AMALEY_DE_PATH', plugin_dir_path(__FILE__));
define('AMALEY_DE_URL', plugin_dir_url(__FILE__));
define('AMALEY_DE_BASENAME', plugin_basename(__FILE__));
define('AMALEY_DE_MIN_PHP', '7.4');
define('AMALEY_DE_MIN_WP', '6.0');

require_once AMALEY_DE_PATH . 'includes/class-amaley-de-settings.php';
require_once AMALEY_DE_PATH . 'includes/class-amaley-de-query.php';
require_once AMALEY_DE_PATH . 'includes/class-amaley-de-renderer.php';
require_once AMALEY_DE_PATH . 'includes/class-amaley-de-plugin.php';

/**
 * Main access helper.
 *
 * @return Amaley_DE_Plugin
 */
function amaley_de_bootstrap() {
    return Amaley_DE_Plugin::instance();
}

amaley_de_bootstrap();
