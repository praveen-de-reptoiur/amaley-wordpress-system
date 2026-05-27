<?php
/**
 * Safe Elementor integration.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell_Elementor {
    public static function init() {
        add_action( 'elementor/widgets/register', array( __CLASS__, 'register_widgets' ) );
        add_action( 'elementor/elements/categories_registered', array( __CLASS__, 'register_category' ) );
    }

    public static function register_category( $elements_manager ) {
        if ( ! is_object( $elements_manager ) || ! method_exists( $elements_manager, 'add_category' ) ) {
            return;
        }
        $elements_manager->add_category(
            'amaley-site-shell',
            array(
                'title' => 'Amaley Site Shell',
                'icon'  => 'fa fa-plug',
            )
        );
    }

    public static function register_widgets( $widgets_manager ) {
        if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) {
            return;
        }

        require_once AMALEY_SHELL_PATH . 'includes/widgets/class-amaley-shell-elementor-header-widget.php';
        require_once AMALEY_SHELL_PATH . 'includes/widgets/class-amaley-shell-elementor-footer-widget.php';

        if ( method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Shell_Elementor_Header_Widget() );
            $widgets_manager->register( new Amaley_Shell_Elementor_Footer_Widget() );
        } elseif ( method_exists( $widgets_manager, 'register_widget_type' ) ) {
            $widgets_manager->register_widget_type( new Amaley_Shell_Elementor_Header_Widget() );
            $widgets_manager->register_widget_type( new Amaley_Shell_Elementor_Footer_Widget() );
        }
    }
}
