<?php
/**
 * Main admin-only bootstrap.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Plugin {

    /** @var APG_Plugin|null */
    private static $instance = null;

    /** @var string */
    private $screen_hook = '';

    /**
     * Singleton.
     *
     * @return APG_Plugin
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        require_once APG_DIR . 'includes/class-apg-plugin-registry.php';
        require_once APG_DIR . 'includes/class-apg-elementor-scanner.php';
        require_once APG_DIR . 'includes/class-apg-woocommerce-scanner.php';
        require_once APG_DIR . 'includes/class-apg-widget-usage-scanner.php';
        require_once APG_DIR . 'includes/class-apg-project-map.php';
        require_once APG_DIR . 'includes/class-apg-scanner.php';
        require_once APG_DIR . 'includes/class-apg-report-exporter.php';
        require_once APG_DIR . 'includes/class-apg-admin.php';

        add_action( 'admin_menu', array( $this, 'register_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'admin_post_apg_run_quick_scan', array( $this, 'handle_quick_scan' ) );
        add_action( 'admin_post_apg_export_markdown', array( 'APG_Report_Exporter', 'export_markdown' ) );
        add_action( 'admin_post_apg_export_json', array( 'APG_Report_Exporter', 'export_json' ) );
    }

    /**
     * Register a completely separate top-level admin menu.
     * No Amaley Core parent slug is used here.
     *
     * @return void
     */
    public function register_menu() {
        $this->screen_hook = add_menu_page(
            __( 'Amaley Project Guard', 'amaley-project-guard' ),
            __( 'Amaley Project Guard', 'amaley-project-guard' ),
            'manage_options',
            'amaley-project-guard',
            array( 'APG_Admin', 'render_page' ),
            'dashicons-shield-alt',
            58
        );
    }

    /**
     * Enqueue assets only on Project Guard admin screen.
     *
     * @param string $hook Current screen hook.
     * @return void
     */
    public function enqueue_admin_assets( $hook ) {
        if ( $hook !== $this->screen_hook ) {
            return;
        }

        wp_enqueue_style(
            'apg-admin',
            APG_URL . 'assets/admin.css',
            array(),
            APG_VERSION
        );

        wp_enqueue_script(
            'apg-admin',
            APG_URL . 'assets/admin.js',
            array(),
            APG_VERSION,
            true
        );
    }

    /**
     * Manual Quick Scan handler.
     *
     * @return void
     */
    public function handle_quick_scan() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to run Project Guard scans.', 'amaley-project-guard' ) );
        }

        check_admin_referer( 'apg_run_quick_scan' );

        $scanner = new APG_Scanner();
        $report  = $scanner->run_quick_scan();
        APG_Utils::save_last_report( $report );

        wp_safe_redirect( admin_url( 'admin.php?page=amaley-project-guard&apg_notice=scan_done' ) );
        exit;
    }
}
