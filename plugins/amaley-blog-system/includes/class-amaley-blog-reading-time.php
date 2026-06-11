<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Reading_Time {
    public static function get_minutes( $post_id = 0 ) {
        $post_id = $post_id ? absint( $post_id ) : get_the_ID();
        if ( ! $post_id ) {
            return 1;
        }

        $content = get_post_field( 'post_content', $post_id );
        $words   = str_word_count( wp_strip_all_tags( strip_shortcodes( $content ) ) );
        $minutes = max( 1, (int) ceil( $words / 220 ) );

        return $minutes;
    }

    public static function get_label( $post_id = 0 ) {
        $minutes = self::get_minutes( $post_id );
        return sprintf( _n( '%s min read', '%s min read', $minutes, 'amaley-blog-system' ), number_format_i18n( $minutes ) );
    }
}
