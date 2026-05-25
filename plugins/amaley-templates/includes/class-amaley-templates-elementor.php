<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Templates_Elementor {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_styles' ) );
        add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_scripts' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'register_styles' ) );
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'register_scripts' ) );
    }

    public function register_category( $elements_manager ) {
        $elements_manager->add_category(
            'amaley-templates',
            array(
                'title' => esc_html__( 'Amaley Templates', 'amaley-templates' ),
                'icon'  => 'fa fa-plug',
            )
        );
    }

    public function register_styles() {
        if ( ! wp_style_is( 'amaley-templates-frontend', 'registered' ) ) {
            wp_register_style(
                'amaley-templates-frontend',
                AMALEY_TPL_URL . 'assets/css/amaley-templates.css',
                array(),
                AMALEY_TPL_VERSION
            );
        }
    }

    public function register_scripts() {
        if ( ! wp_script_is( 'amaley-templates-frontend', 'registered' ) ) {
            wp_register_script(
                'amaley-templates-frontend',
                AMALEY_TPL_URL . 'assets/js/amaley-templates.js',
                array(),
                AMALEY_TPL_VERSION,
                true
            );
        }
    }

    public function register_widgets( $widgets_manager ) {
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-widget-base.php';
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-product-hero.php';
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-origin-panel.php';
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-info-tabs.php';
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-trust-strip.php';
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-shop-hero.php';
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-shop-discovery.php';
        require_once AMALEY_TPL_PATH . 'includes/widgets/class-amaley-tpl-member-value-strip.php';

        $widgets_manager->register( new \Amaley_Tpl_Product_Hero_Widget() );
        $widgets_manager->register( new \Amaley_Tpl_Origin_Panel_Widget() );
        $widgets_manager->register( new \Amaley_Tpl_Info_Tabs_Widget() );
        $widgets_manager->register( new \Amaley_Tpl_Trust_Strip_Widget() );
        $widgets_manager->register( new \Amaley_Tpl_Shop_Hero_Widget() );
        $widgets_manager->register( new \Amaley_Tpl_Shop_Discovery_Widget() );
        $widgets_manager->register( new \Amaley_Tpl_Member_Value_Strip_Widget() );
    }
}
