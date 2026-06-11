<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Template_Router {
    protected static $current_post_id = 0;

    public function init() {
        add_filter( 'template_include', array( $this, 'maybe_route_single_post' ), 99 );
        add_filter( 'body_class', array( $this, 'body_class' ) );
    }

    public function maybe_route_single_post( $template ) {
        if ( is_admin() || ! is_singular( 'post' ) ) {
            return $template;
        }

        if ( ! Amaley_Blog_Settings::get( 'enable_single_router', 1 ) ) {
            return $template;
        }

        $template_id = absint( Amaley_Blog_Settings::get( 'single_template_id', 0 ) );
        if ( ! $template_id || 'publish' !== get_post_status( $template_id ) ) {
            return $template;
        }

        $plugin_template = AMALEY_BLOG_PATH . 'templates/single-post-router.php';
        return file_exists( $plugin_template ) ? $plugin_template : $template;
    }

    public static function set_current_post_id( $post_id ) {
        self::$current_post_id = absint( $post_id );
    }

    public static function get_current_post_id() {
        if ( self::$current_post_id ) {
            return self::$current_post_id;
        }

        if ( is_singular( 'post' ) ) {
            $queried_id = absint( get_queried_object_id() );
            if ( $queried_id && 'post' === get_post_type( $queried_id ) ) {
                return $queried_id;
            }
        }

        $current_id = absint( get_the_ID() );
        if ( $current_id && 'post' === get_post_type( $current_id ) ) {
            return $current_id;
        }

        return self::get_preview_post_id();
    }

    public static function get_preview_post_id() {
        $posts = get_posts(
            array(
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => 1,
                'orderby'             => 'date',
                'order'               => 'DESC',
                'ignore_sticky_posts' => true,
                'fields'              => 'ids',
            )
        );

        if ( ! empty( $posts[0] ) ) {
            return absint( $posts[0] );
        }

        return $current_id = absint( get_the_ID() );
    }

    public function body_class( $classes ) {
        if ( is_singular( 'post' ) && Amaley_Blog_Settings::get( 'enable_single_router', 1 ) ) {
            $classes[] = 'amaley-blog-single-routed';
        }
        return $classes;
    }
}
