<?php
/**
 * Plugin Name: Amaley Page Assignment Bridge
 * Plugin URI: https://amaleycollective.com
 * Description: Safe Elementor page-assignment bridge for Amaley WooCommerce single product pages. v1.4.1 fixes Member Value Strip Elementor controls so tile repeater, layout, alignment, style and responsive spacing controls apply reliably while keeping the bridge flow safe.
 * Version: 1.4.1
 * Author: Praveen
 * Author URI: https://amaleycollective.com
 * Text Domain: amaley-page-assignment-bridge
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'APAB_VERSION', '1.4.1' );
define( 'APAB_FILE', __FILE__ );
define( 'APAB_PATH', plugin_dir_path( __FILE__ ) );
define( 'APAB_URL', plugin_dir_url( __FILE__ ) );
define( 'APAB_OPTION', 'amaley_page_assignment_bridge_settings' );

require_once APAB_PATH . 'includes/class-apab-settings.php';
require_once APAB_PATH . 'includes/class-apab-product-context.php';
require_once APAB_PATH . 'includes/class-apab-admin.php';

final class Amaley_Page_Assignment_Bridge {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'plugins_loaded', array( $this, 'load' ), 20 );
        add_action( 'admin_notices', array( $this, 'dependency_admin_notices' ) );

        if ( is_admin() ) {
            APAB_Admin::instance();
        }
    }

    public function load() {
        add_filter( 'template_include', array( $this, 'maybe_use_single_product_bridge_template' ), 99 );
        add_filter( 'body_class', array( $this, 'add_body_classes' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_assets' ) );
        add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_frontend_assets' ) );
        add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'register_frontend_assets' ) );
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'register_frontend_assets' ) );
        add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'maybe_buy_now_redirect' ), 20, 1 );

        // Prepare preview context early for assigned-page previews and Elementor editor iframe.
        add_action( 'wp', array( $this, 'maybe_setup_assigned_page_preview_context' ), 1 );
        add_action( 'template_redirect', array( $this, 'maybe_setup_assigned_page_preview_context' ), 1 );
        add_action( 'elementor/frontend/before_render', array( $this, 'maybe_setup_assigned_page_preview_context' ), 1 );

        if ( did_action( 'elementor/loaded' ) ) {
            require_once APAB_PATH . 'includes/class-apab-elementor.php';
            APAB_Elementor::instance();
        }
    }

    public function register_frontend_assets() {
        if ( ! wp_style_is( 'apab-single-product', 'registered' ) ) {
            wp_register_style(
                'apab-single-product',
                APAB_URL . 'assets/css/apab-single-product.css',
                array(),
                APAB_VERSION
            );
        }

        if ( ! wp_script_is( 'apab-single-product', 'registered' ) ) {
            wp_register_script(
                'apab-single-product',
                APAB_URL . 'assets/js/apab-single-product.js',
                array(),
                APAB_VERSION,
                true
            );
        }
    }

    public function add_body_classes( $classes ) {
        if ( $this->should_bridge_current_single_product() ) {
            $classes[] = 'apab-single-product-bridge-active';
            $classes[] = 'apab-assigned-page-template-active';
        }
        if ( $this->should_use_assigned_page_preview_product_context() ) {
            $classes[] = 'apab-assigned-page-preview-product-context';
        }
        return $classes;
    }

    public function maybe_buy_now_redirect( $url ) {
        if ( isset( $_REQUEST['apab_buy_now'] ) && '1' === sanitize_text_field( wp_unslash( $_REQUEST['apab_buy_now'] ) ) ) {
            if ( function_exists( 'wc_get_checkout_url' ) ) {
                return wc_get_checkout_url();
            }
        }
        return $url;
    }

    public function maybe_setup_assigned_page_preview_context( $element = null ) {
        if ( ! $this->should_use_assigned_page_preview_product_context() ) {
            return;
        }

        $settings   = APAB_Settings::get_settings();
        $product_id = ! empty( $settings['single_product']['preview_product_id'] ) ? absint( $settings['single_product']['preview_product_id'] ) : 0;
        if ( ! $product_id ) {
            $product_id = ! empty( $settings['single_product']['test_product_id'] ) ? absint( $settings['single_product']['test_product_id'] ) : 0;
        }

        if ( $product_id && function_exists( 'wc_get_product' ) && wc_get_product( $product_id ) ) {
            APAB_Product_Context::set_product_id( $product_id, 'assigned_page_preview' );
        }
    }

    public function should_use_assigned_page_preview_product_context() {
        if ( defined( 'APAB_RENDERING_SINGLE_PRODUCT' ) && APAB_RENDERING_SINGLE_PRODUCT ) {
            return false;
        }
        if ( ! function_exists( 'wc_get_product' ) ) {
            return false;
        }

        $settings = APAB_Settings::get_settings();
        $enabled  = isset( $settings['single_product']['enabled'] ) ? sanitize_key( $settings['single_product']['enabled'] ) : 'off';
        $preview  = isset( $settings['single_product']['preview_assigned_page'] ) ? sanitize_key( $settings['single_product']['preview_assigned_page'] ) : 'yes';

        if ( 'off' === $enabled || 'yes' !== $preview ) {
            return false;
        }

        $page_id = $this->get_single_product_template_page_id();
        if ( ! $page_id ) {
            return false;
        }

        $product_id = ! empty( $settings['single_product']['preview_product_id'] ) ? absint( $settings['single_product']['preview_product_id'] ) : 0;
        if ( ! $product_id ) {
            $product_id = ! empty( $settings['single_product']['test_product_id'] ) ? absint( $settings['single_product']['test_product_id'] ) : 0;
        }
        if ( ! $product_id || ! wc_get_product( $product_id ) ) {
            return false;
        }

        $queried_id = absint( get_queried_object_id() );
        $current_id = absint( get_the_ID() );
        if ( $page_id === $queried_id || $page_id === $current_id ) {
            return true;
        }

        $preview_id           = isset( $_GET['preview_id'] ) ? absint( wp_unslash( $_GET['preview_id'] ) ) : 0;
        $elementor_preview_id = isset( $_GET['elementor-preview'] ) ? absint( wp_unslash( $_GET['elementor-preview'] ) ) : 0;
        $post_id              = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0;

        return $page_id === $preview_id || $page_id === $elementor_preview_id || $page_id === $post_id;
    }

    public function maybe_use_single_product_bridge_template( $template ) {
        if ( ! $this->should_bridge_current_single_product() ) {
            return $template;
        }

        $page_id = $this->get_single_product_template_page_id();
        if ( ! $page_id || ! get_post( $page_id ) ) {
            return $template;
        }

        $bridge_template = APAB_PATH . 'templates/single-product-bridge.php';
        return file_exists( $bridge_template ) ? $bridge_template : $template;
    }

    public function should_bridge_current_single_product() {
        if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
            return false;
        }
        if ( defined( 'APAB_RENDERING_SINGLE_PRODUCT' ) && APAB_RENDERING_SINGLE_PRODUCT ) {
            return false;
        }
        if ( ! function_exists( 'is_product' ) || ! function_exists( 'wc_get_product' ) || ! is_product() ) {
            return false;
        }

        $settings = APAB_Settings::get_settings();
        $mode     = isset( $settings['single_product']['enabled'] ) ? sanitize_key( $settings['single_product']['enabled'] ) : 'off';
        if ( 'off' === $mode ) {
            return false;
        }

        $product_id = absint( get_queried_object_id() );
        if ( ! $product_id || ! wc_get_product( $product_id ) ) {
            return false;
        }
        if ( ! $this->get_single_product_template_page_id() ) {
            return false;
        }
        if ( 'test' === $mode ) {
            $test_product_id = ! empty( $settings['single_product']['test_product_id'] ) ? absint( $settings['single_product']['test_product_id'] ) : 0;
            return $test_product_id && $test_product_id === $product_id;
        }
        return 'all' === $mode;
    }

    public function get_single_product_template_page_id() {
        $settings = APAB_Settings::get_settings();
        $page_id  = ! empty( $settings['single_product']['assigned_page_id'] ) ? absint( $settings['single_product']['assigned_page_id'] ) : 0;
        if ( ! $page_id ) {
            return 0;
        }
        $post = get_post( $page_id );
        if ( ! $post || 'page' !== $post->post_type ) {
            return 0;
        }
        if ( ! in_array( $post->post_status, array( 'publish', 'private', 'draft' ), true ) ) {
            return 0;
        }
        return $page_id;
    }

    public function dependency_admin_notices() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $screen    = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
        $screen_id = $screen ? (string) $screen->id : '';
        if ( false === strpos( $screen_id, 'amaley-page-assignment-bridge' ) && false === strpos( $screen_id, 'plugins' ) ) {
            return;
        }
        if ( ! function_exists( 'wc_get_product' ) ) {
            echo '<div class="notice notice-warning"><p><strong>Amaley Page Assignment Bridge:</strong> WooCommerce is not active. Single Product Bridge will stay inactive.</p></div>';
        }
        if ( ! did_action( 'elementor/loaded' ) ) {
            echo '<div class="notice notice-warning"><p><strong>Amaley Page Assignment Bridge:</strong> Elementor is not active. Assigned Elementor page and Bridge widgets cannot render.</p></div>';
        }
    }
}

Amaley_Page_Assignment_Bridge::instance();
