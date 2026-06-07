<?php
/** Main plugin bootstrap. */
defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Plugin {
    private static $instance = null;
    public static function instance() { if ( null === self::$instance ) { self::$instance = new self(); } return self::$instance; }
    private function __construct() {
        add_action( 'init', array( $this, 'register_assets' ) );
        add_action( 'init', array( $this, 'register_shortcodes' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_for_shortcodes' ), 20 );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/init', array( $this, 'load_merged_control_injector' ) );
    }
    public function register_assets() {
        wp_register_style( 'amaley-compact-widgets', AMALEY_CW_URL . 'assets/css/amaley-compact-widgets.css', array(), AMALEY_CW_VERSION );
        wp_register_style( 'amaley-compact-widgets-origin-map', AMALEY_CW_URL . 'assets/css/amaley-cw-origin-map.css', array( 'amaley-compact-widgets' ), AMALEY_CW_VERSION );
        wp_register_script( 'amaley-compact-widgets-origin-map', AMALEY_CW_URL . 'assets/js/amaley-cw-origin-map.js', array(), AMALEY_CW_VERSION, true );
        if ( ! wp_style_is( 'acwsc-reference-visual-statement', 'registered' ) ) {
            wp_register_style( 'acwsc-reference-visual-statement', AMALEY_CW_URL . 'assets/css/reference-visual-statement.css', array(), AMALEY_CW_VERSION );
        }
        if ( ! wp_style_is( 'acwsc-process-journey', 'registered' ) ) {
            wp_register_style( 'acwsc-process-journey', AMALEY_CW_URL . 'assets/css/process-journey.css', array(), AMALEY_CW_VERSION );
        }
        if ( ! wp_style_is( 'acwsc-three-sections', 'registered' ) ) {
            wp_register_style( 'acwsc-three-sections', AMALEY_CW_URL . 'assets/css/three-sections.css', array(), AMALEY_CW_VERSION );
        }
    }
    public function enqueue_assets() {
        wp_enqueue_style( 'amaley-compact-widgets' );
        wp_enqueue_style( 'amaley-compact-widgets-origin-map' );
        wp_enqueue_script( 'amaley-compact-widgets-origin-map' );
        wp_enqueue_style( 'acwsc-reference-visual-statement' );
        wp_enqueue_style( 'acwsc-process-journey' );
        wp_enqueue_style( 'acwsc-three-sections' );
    }
    public function maybe_enqueue_for_shortcodes() {
        if ( is_admin() || ! is_singular() ) { return; }
        global $post;
        if ( ! $post || empty( $post->post_content ) ) { return; }
        foreach ( Amaley_CW_Shortcodes::shortcode_map() as $shortcode => $method ) {
            if ( has_shortcode( $post->post_content, $shortcode ) ) { $this->enqueue_assets(); return; }
        }
    }
    public function register_shortcodes() { $shortcodes = new Amaley_CW_Shortcodes(); $shortcodes->register(); }
    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-compact', array( 'title' => esc_html__( 'Amaley Compact', 'amaley-compact-widgets' ), 'icon' => 'fa fa-leaf' ) );
        }
    }
    public function register_elementor_widgets( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) || ! is_object( $widgets_manager ) ) { return; }
        require_once AMALEY_CW_PATH . 'includes/widgets/class-amaley-cw-base-widget.php';
        $widgets = Amaley_CW_Renderer::widget_definitions();
        foreach ( $widgets as $key => $definition ) {
            $class_file = AMALEY_CW_PATH . 'includes/widgets/class-amaley-cw-' . str_replace( '_', '-', $key ) . '-widget.php';
            if ( file_exists( $class_file ) ) { require_once $class_file; }
            $class = 'Amaley_CW_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $key ) ) ) . '_Widget';
            if ( class_exists( $class ) && method_exists( $widgets_manager, 'register' ) ) { $widgets_manager->register( new $class() ); }
        }
        $origin_map_widget = AMALEY_CW_PATH . 'includes/widgets/class-amaley-cw-origin-map-widget.php';
        if ( file_exists( $origin_map_widget ) ) { require_once $origin_map_widget; }
        if ( class_exists( 'Amaley_CW_Origin_Map_Widget' ) && method_exists( $widgets_manager, 'register' ) ) { $widgets_manager->register( new Amaley_CW_Origin_Map_Widget() ); }
        $this->register_merged_home_widgets( $widgets_manager );
    }

    /**
     * Register widgets merged from the safe local Compact Spacing Controls v1.0.23 add-on.
     * If the old add-on is still active, this method skips registration to avoid duplicate Elementor widget IDs.
     */
    private function register_merged_home_widgets( $widgets_manager ) {
        if ( class_exists( 'ACWSC109_Plugin' ) ) {
            return;
        }
        $merged_widget_files = array(
            'class-acwsc109-reference-visual-statement-base-widget.php',
            'class-acwsc109-mission-visual-statement-widget.php',
            'class-acwsc109-vision-visual-statement-widget.php',
            'class-acwsc109-process-journey-widget.php',
            'class-acwsc109-origin-pillars-widget.php',
            'class-acwsc109-livelihood-chain-band-widget.php',
            'class-acwsc109-gifting-feature-split-widget.php',
        );
        foreach ( $merged_widget_files as $merged_widget_file ) {
            $merged_path = AMALEY_CW_PATH . 'includes/widgets/' . $merged_widget_file;
            if ( file_exists( $merged_path ) ) {
                require_once $merged_path;
            }
        }
        $merged_widget_classes = array(
            'ACWSC109_Mission_Visual_Statement_Widget',
            'ACWSC109_Vision_Visual_Statement_Widget',
            'ACWSC109_Process_Journey_Widget',
            'ACWSC109_Origin_Pillars_Widget',
            'ACWSC109_Livelihood_Chain_Band_Widget',
            'ACWSC109_Gifting_Feature_Split_Widget',
        );
        foreach ( $merged_widget_classes as $merged_widget_class ) {
            if ( class_exists( $merged_widget_class ) && method_exists( $widgets_manager, 'register' ) ) {
                $widgets_manager->register( new $merged_widget_class() );
            }
        }
    }

    /**
     * Load merged Split Editorial and Origin Map extra controls.
     * Skips if the old add-on is active to avoid duplicated Elementor controls.
     */
    public function load_merged_control_injector() {
        if ( class_exists( 'ACWSC109_Plugin' ) ) {
            return;
        }
        $injector = AMALEY_CW_PATH . 'includes/class-acwsc109-compact-control-injector.php';
        if ( file_exists( $injector ) ) {
            require_once $injector;
        }
        if ( class_exists( 'ACWSC109_Compact_Control_Injector' ) ) {
            ACWSC109_Compact_Control_Injector::instance();
        }
    }
}

