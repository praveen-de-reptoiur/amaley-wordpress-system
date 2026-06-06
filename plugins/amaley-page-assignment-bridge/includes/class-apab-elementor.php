<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class APAB_Elementor {

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
    }

    public function register_category( $elements_manager ) {
        $elements_manager->add_category(
            'amaley-bridge',
            array(
                'title' => esc_html__( 'Amaley Bridge', 'amaley-page-assignment-bridge' ),
                'icon'  => 'fa fa-link',
            )
        );
    }

    public function register_widgets( $widgets_manager ) {
        require_once APAB_PATH . 'includes/widgets/class-apab-widget-base.php';
        require_once APAB_PATH . 'includes/widgets/class-apab-widget-product-hero.php';
        require_once APAB_PATH . 'includes/widgets/class-apab-widget-trust-strip.php';
        require_once APAB_PATH . 'includes/widgets/class-apab-widget-origin-panel.php';
        require_once APAB_PATH . 'includes/widgets/class-apab-widget-info-tabs.php';
        require_once APAB_PATH . 'includes/widgets/class-apab-widget-value-strip.php';

        $widgets_manager->register( new \APAB_Widget_Product_Hero() );
        $widgets_manager->register( new \APAB_Widget_Trust_Strip() );
        $widgets_manager->register( new \APAB_Widget_Origin_Panel() );
        $widgets_manager->register( new \APAB_Widget_Info_Tabs() );
        $widgets_manager->register( new \APAB_Widget_Value_Strip() );
    }
}
