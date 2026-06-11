<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Query {
    public static function archive_query( $settings = array() ) {
        $client_side_archive = ! empty( $settings['client_side_archive'] );
        $posts_per_page      = isset( $settings['posts_per_page'] ) ? absint( $settings['posts_per_page'] ) : 9;
        $posts_per_page      = $posts_per_page > 0 ? $posts_per_page : 9;

        $paged = $client_side_archive ? 1 : max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

        $orderby = ( ! $client_side_archive && isset( $_GET['abs_orderby'] ) ) ? sanitize_key( wp_unslash( $_GET['abs_orderby'] ) ) : 'date_desc';
        $order_args = self::orderby_args( $orderby );

        $args = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $client_side_archive ? 200 : $posts_per_page,
            'paged'               => $paged,
            'ignore_sticky_posts' => true,
            'orderby'             => $order_args['orderby'],
            'order'               => $order_args['order'],
        );

        if ( ! $client_side_archive && ! empty( $_GET['abs_s'] ) ) {
            $args['s'] = sanitize_text_field( wp_unslash( $_GET['abs_s'] ) );
        }

        $tax_query = array();
        if ( ! $client_side_archive && ! empty( $_GET['abs_category'] ) ) {
            $category = sanitize_title( wp_unslash( $_GET['abs_category'] ) );
            if ( 'all' !== $category ) {
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $category,
                );
            }
        }

        if ( ! $client_side_archive && ! empty( $_GET['abs_tag'] ) ) {
            $tag = sanitize_title( wp_unslash( $_GET['abs_tag'] ) );
            if ( 'all' !== $tag ) {
                $tax_query[] = array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'slug',
                    'terms'    => $tag,
                );
            }
        }

        if ( ! empty( $settings['include_categories'] ) && is_array( $settings['include_categories'] ) ) {
            $include = array_filter( array_map( 'absint', $settings['include_categories'] ) );
            if ( $include ) {
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $include,
                );
            }
        }

        if ( ! empty( $settings['exclude_categories'] ) && is_array( $settings['exclude_categories'] ) ) {
            $exclude = array_filter( array_map( 'absint', $settings['exclude_categories'] ) );
            if ( $exclude ) {
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $exclude,
                    'operator' => 'NOT IN',
                );
            }
        }



        if ( ! empty( $settings['include_tags'] ) && is_array( $settings['include_tags'] ) ) {
            $include_tags = array_filter( array_map( 'absint', $settings['include_tags'] ) );
            if ( $include_tags ) {
                $tax_query[] = array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'term_id',
                    'terms'    => $include_tags,
                );
            }
        }

        if ( ! empty( $settings['exclude_tags'] ) && is_array( $settings['exclude_tags'] ) ) {
            $exclude_tags = array_filter( array_map( 'absint', $settings['exclude_tags'] ) );
            if ( $exclude_tags ) {
                $tax_query[] = array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'term_id',
                    'terms'    => $exclude_tags,
                    'operator' => 'NOT IN',
                );
            }
        }

        if ( count( $tax_query ) > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        if ( ! empty( $tax_query ) ) {
            $args['tax_query'] = $tax_query;
        }

        return new WP_Query( $args );
    }

    public static function related_query( $post_id, $count = 3, $logic = 'same_category' ) {
        $post_id = absint( $post_id );
        $count   = max( 1, absint( $count ) );

        $args = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $count,
            'post__not_in'        => array( $post_id ),
            'ignore_sticky_posts' => true,
            'orderby'             => 'date',
            'order'               => 'DESC',
        );

        if ( 'same_tags' === $logic ) {
            $tags = wp_get_post_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
            if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
                $args['tag__in'] = $tags;
            }
        } elseif ( 'same_category' === $logic ) {
            $cats = wp_get_post_terms( $post_id, 'category', array( 'fields' => 'ids' ) );
            if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
                $args['category__in'] = $cats;
            }
        }

        return new WP_Query( $args );
    }

    public static function popular_posts( $count = 3 ) {
        return new WP_Query(
            array(
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => max( 1, absint( $count ) ),
                'ignore_sticky_posts' => true,
                'orderby'             => 'comment_count',
                'order'               => 'DESC',
            )
        );
    }

    private static function orderby_args( $orderby ) {
        switch ( $orderby ) {
            case 'date_asc':
                return array( 'orderby' => 'date', 'order' => 'ASC' );
            case 'title_asc':
                return array( 'orderby' => 'title', 'order' => 'ASC' );
            case 'title_desc':
                return array( 'orderby' => 'title', 'order' => 'DESC' );
            case 'date_desc':
            default:
                return array( 'orderby' => 'date', 'order' => 'DESC' );
        }
    }
}
