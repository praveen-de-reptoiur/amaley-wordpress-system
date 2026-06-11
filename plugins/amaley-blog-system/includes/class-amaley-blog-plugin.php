<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Plugin {
    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init();
    }

    private function init() {
        $settings = new Amaley_Blog_Settings();
        $settings->init();

        $router = new Amaley_Blog_Template_Router();
        $router->init();

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
    }

    public function enqueue_assets() {
        if ( ! $this->should_enqueue_assets() ) {
            return;
        }

        wp_enqueue_style(
            'amaley-blog-frontend',
            AMALEY_BLOG_URL . 'assets/css/amaley-blog-frontend.css',
            array(),
            AMALEY_BLOG_VERSION
        );

        wp_enqueue_script(
            'amaley-blog-frontend',
            AMALEY_BLOG_URL . 'assets/js/amaley-blog-frontend.js',
            array(),
            AMALEY_BLOG_VERSION,
            true
        );
    }

    private function should_enqueue_assets() {
        if ( is_admin() && ! wp_doing_ajax() ) {
            return false;
        }

        if ( class_exists( '\Elementor\Plugin' ) ) {
            $elementor = \Elementor\Plugin::$instance;

            if ( isset( $elementor->editor ) && method_exists( $elementor->editor, 'is_edit_mode' ) && $elementor->editor->is_edit_mode() ) {
                return true;
            }

            if ( isset( $elementor->preview ) && method_exists( $elementor->preview, 'is_preview_mode' ) && $elementor->preview->is_preview_mode() ) {
                return true;
            }
        }

        $archive_page_id    = absint( Amaley_Blog_Settings::get( 'archive_page_id', 0 ) );
        $single_template_id = absint( Amaley_Blog_Settings::get( 'single_template_id', 0 ) );

        if ( $archive_page_id && is_page( $archive_page_id ) ) {
            return true;
        }

        if ( $single_template_id && is_page( $single_template_id ) ) {
            return true;
        }

        if ( is_singular( 'post' ) && Amaley_Blog_Settings::get( 'enable_single_router', 1 ) ) {
            return true;
        }

        return false;
    }

    public function register_elementor_category( $elements_manager ) {
        $elements_manager->add_category(
            'amaley-blog',
            array(
                'title' => __( 'Amaley Blog System', 'amaley-blog-system' ),
                'icon'  => 'fa fa-edit',
            )
        );
    }

    public function register_elementor_widgets( $widgets_manager ) {
        $files = array(
            'class-amaley-blog-elementor-base.php',
            'class-amaley-blog-archive-hero-widget.php',
            'class-amaley-blog-archive-layout-widget.php',
            'class-amaley-single-hero-clean-widget.php',
            'class-amaley-single-layout-clean-widget.php',
        );

        foreach ( $files as $file ) {
            require_once AMALEY_BLOG_PATH . 'includes/elementor/' . $file;
        }

        $classes = array(
            'Amaley_Blog_Archive_Hero_Widget',
            'Amaley_Blog_Archive_Layout_Widget',
            'Amaley_Single_Hero_Clean_Widget',
            'Amaley_Single_Layout_Clean_Widget',
        );

        foreach ( $classes as $class ) {
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }
}
