<?php
/**
 * Plugin Name: Amaley Core
 * Description: Cluster, SHG Group, Member/Producer and Product Origin Mapping backbone for the Amaley fresh WordPress build.
 * Version: 1.1.1
 * Author: Praveen
 * Text Domain: amaley-core
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * WC requires at least: 7.0
 * WC tested up to: 10.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'AMALEY_CORE_VERSION' ) ) {
    define( 'AMALEY_CORE_VERSION', '1.1.1' );
}
if ( ! defined( 'AMALEY_CORE_SCHEMA_VERSION' ) ) {
    define( 'AMALEY_CORE_SCHEMA_VERSION', '1' );
}
if ( ! defined( 'AMALEY_CORE_FILE' ) ) {
    define( 'AMALEY_CORE_FILE', __FILE__ );
}
if ( ! defined( 'AMALEY_CORE_PATH' ) ) {
    define( 'AMALEY_CORE_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'AMALEY_CORE_URL' ) ) {
    define( 'AMALEY_CORE_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'AMALEY_CORE_BASENAME' ) ) {
    define( 'AMALEY_CORE_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * Declare compatibility with WooCommerce features used on modern stores.
 */
function amaley_core_declare_woocommerce_compatibility() {
    if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
}
add_action( 'before_woocommerce_init', 'amaley_core_declare_woocommerce_compatibility' );

require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-fields.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-cpts.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-metaboxes.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-product-origin.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-import-export.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-card-registry.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-card-renderer.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-admin.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-cluster-cards.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-shg-cards.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-member-cards.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-product-origin-panel.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-cluster-pages.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-cluster-archive-sections.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-cluster-single-sections.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-shg-archive-sections.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-shg-single-sections.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-member-archive-sections.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-member-single-sections.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-universal-showcase.php';
require_once AMALEY_CORE_PATH . 'includes/class-amaley-core.php';

/** Return the main plugin instance. */
function amaley_core() {
    static $instance = null;
    if ( null === $instance ) {
        $instance = new Amaley_Core();
    }
    return $instance;
}
add_action( 'plugins_loaded', 'amaley_core' );

/** Activation routine. */
function amaley_core_activate() {
    update_option( 'amaley_core_version', AMALEY_CORE_VERSION );
    update_option( 'amaley_core_schema_version', AMALEY_CORE_SCHEMA_VERSION );
    require_once AMALEY_CORE_PATH . 'includes/class-amaley-core-cpts.php';
    $cpts = new Amaley_Core_CPTs();
    $cpts->register_post_types();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'amaley_core_activate' );

/** Deactivation routine. */
function amaley_core_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'amaley_core_deactivate' );
