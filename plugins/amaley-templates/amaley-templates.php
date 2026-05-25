<?php
/**
 * Plugin Name: Amaley Templates
 * Plugin URI: https://amaleycollective.com
 * Description: Elementor-native template widgets and module settings for Amaley Single Product, Shop Page, Quick View/Popup and future template modules. WooCommerce remains the source for products, price, variations, stock, cart, checkout and reviews.
 * Version: 1.2.7
 * Author: Praveen
 * Author URI: https://amaleycollective.com
 * Text Domain: amaley-templates
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AMALEY_TPL_VERSION', '1.2.7' );
define( 'AMALEY_TPL_FILE', __FILE__ );
define( 'AMALEY_TPL_PATH', plugin_dir_path( __FILE__ ) );
define( 'AMALEY_TPL_URL', plugin_dir_url( __FILE__ ) );
define( 'AMALEY_TPL_OPTION', 'amaley_tpl_settings' );
define( 'AMALEY_TPL_BACKUPS_OPTION', 'amaley_tpl_backups' );
define( 'AMALEY_TPL_EVENTS_OPTION', 'amaley_tpl_events' );

require_once AMALEY_TPL_PATH . 'includes/class-amaley-templates-settings.php';
require_once AMALEY_TPL_PATH . 'includes/class-amaley-templates-admin.php';

final class Amaley_Templates_Plugin {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'plugins_loaded', array( $this, 'load' ) );
        add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'maybe_buy_now_redirect' ), 20, 1 );
        add_action( 'admin_init', array( $this, 'maybe_upgrade' ) );
        add_action( 'admin_notices', array( $this, 'dependency_admin_notices' ) );

        if ( is_admin() ) {
            Amaley_Templates_Admin::instance();
        }
    }

    public function maybe_upgrade() {
        $settings = Amaley_Templates_Settings::get_settings();
        if ( empty( $settings['meta']['installed_version'] ) || version_compare( $settings['meta']['installed_version'], AMALEY_TPL_VERSION, '<' ) ) {
            $settings['meta']['installed_version'] = AMALEY_TPL_VERSION;
            $settings['meta']['updated_at']        = current_time( 'mysql' );
            Amaley_Templates_Settings::update_settings( $settings );
            Amaley_Templates_Settings::log_event( 'Plugin settings checked/upgraded to v' . AMALEY_TPL_VERSION, 'system' );
        }
    }

    public function load() {
        if ( did_action( 'elementor/loaded' ) ) {
            require_once AMALEY_TPL_PATH . 'includes/class-amaley-templates-elementor.php';
            Amaley_Templates_Elementor::instance();
        }
    }

    public function dependency_admin_notices() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
        if ( $screen && false === strpos( (string) $screen->id, 'amaley' ) && false === strpos( (string) $screen->id, 'plugins' ) ) {
            return;
        }

        if ( ! did_action( 'elementor/loaded' ) ) {
            echo '<div class="notice notice-warning"><p><strong>Amaley Templates:</strong> Elementor is not active/loaded, so Amaley Elementor widgets will not load. WooCommerce data is not affected.</p></div>';
        }

        if ( ! function_exists( 'wc_get_product' ) ) {
            echo '<div class="notice notice-warning"><p><strong>Amaley Templates:</strong> WooCommerce is not active/loaded. Product widgets will show editor fallback messages only. Cart/checkout/product data are not modified.</p></div>';
        }
    }

    public function maybe_buy_now_redirect( $url ) {
        $settings = Amaley_Templates_Settings::get_settings();
        $enabled  = ! empty( $settings['single_product']['buy_now_enabled'] ) && 'yes' === $settings['single_product']['buy_now_enabled'];

        if ( $enabled && isset( $_REQUEST['amaley_buy_now'] ) && '1' === sanitize_text_field( wp_unslash( $_REQUEST['amaley_buy_now'] ) ) ) {
            if ( function_exists( 'wc_get_checkout_url' ) ) {
                return wc_get_checkout_url();
            }
        }
        return $url;
    }
}

Amaley_Templates_Plugin::instance();
