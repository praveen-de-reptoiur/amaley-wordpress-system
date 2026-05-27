<?php
/**
 * Main plugin loader.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell {
    /** @var Amaley_Shell|null */
    private static $instance = null;

    /**
     * Get singleton.
     *
     * @return Amaley_Shell
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Activation routine.
     *
     * @return void
     */
    public static function activate() {
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-settings.php';
        Amaley_Shell_Settings::install_defaults();
    }

    /**
     * Constructor.
     */
    private function __construct() {
        $this->load_files();
        $this->init_hooks();
    }

    /**
     * Load plugin classes.
     *
     * @return void
     */
    private function load_files() {
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-settings.php';
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-assets.php';
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-renderer.php';
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-shortcodes.php';
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-import-export.php';
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-admin.php';
        require_once AMALEY_SHELL_PATH . 'includes/class-amaley-shell-elementor.php';
    }

    /**
     * Init hooks.
     *
     * @return void
     */
    private function init_hooks() {
        Amaley_Shell_Settings::init();
        Amaley_Shell_Assets::init();
        Amaley_Shell_Shortcodes::init();
        Amaley_Shell_Admin::init();
        Amaley_Shell_Import_Export::init();
        Amaley_Shell_Elementor::init();

        add_action( 'wp_body_open', array( $this, 'maybe_auto_render_header' ), 20 );
        add_action( 'get_footer', array( $this, 'maybe_auto_render_footer' ), 5 );
        add_filter( 'body_class', array( $this, 'body_classes' ) );
    }

    /**
     * Optional auto-render header.
     *
     * @return void
     */
    public function maybe_auto_render_header() {
        static $rendered = false;
        if ( $rendered || is_admin() || ! Amaley_Shell_Settings::get_bool( 'auto_render_header' ) ) {
            return;
        }
        $rendered = true;
        echo Amaley_Shell_Renderer::render_header(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Optional auto-render footer.
     *
     * @return void
     */
    public function maybe_auto_render_footer() {
        static $rendered = false;
        if ( $rendered || is_admin() || ! Amaley_Shell_Settings::get_bool( 'auto_render_footer' ) ) {
            return;
        }
        $rendered = true;
        echo Amaley_Shell_Renderer::render_footer(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Add optional body classes for staging-only theme shell hiding.
     *
     * @param array $classes Body classes.
     * @return array
     */
    public function body_classes( $classes ) {
        if ( Amaley_Shell_Settings::get_bool( 'hide_theme_header' ) ) {
            $classes[] = 'amaley-shell-hide-theme-header';
        }
        if ( Amaley_Shell_Settings::get_bool( 'hide_theme_footer' ) ) {
            $classes[] = 'amaley-shell-hide-theme-footer';
        }
        return $classes;
    }
}
