<?php
/**
 * Member / Producer detail link resolver for Amaley Universal Showcase.
 *
 * The Universal Showcase renders member cards through the shared Amaley Core
 * card renderer. When that renderer does not receive an explicit URL, it falls
 * back to get_permalink( $member_id ). This filter makes the fallback safe for
 * Amaley's current page-based producer detail flow.
 *
 * Expected frontend URL:
 * /producers-details/?member_slug=member-slug
 *
 * @package Amaley_Universal_Showcase
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'aus_member_detail_base_url' ) ) {
    /**
     * Resolve the Producer Single Template Page base URL.
     *
     * Priority:
     * 1. Amaley Core Settings -> producer_single_page_id
     * 2. WordPress page slug -> producers-details
     * 3. Empty string so WordPress can keep its original permalink fallback
     *
     * @return string
     */
    function aus_member_detail_base_url() {
        $base_url = '';
        $settings = get_option( 'amaley_core_template_settings', array() );

        if ( is_array( $settings ) && ! empty( $settings['producer_single_page_id'] ) ) {
            $page_id = absint( $settings['producer_single_page_id'] );

            if ( $page_id ) {
                $permalink = get_permalink( $page_id );
                if ( $permalink ) {
                    $base_url = $permalink;
                }
            }
        }

        if ( ! $base_url ) {
            $fallback_page = get_page_by_path( 'producers-details' );

            if ( $fallback_page && ! empty( $fallback_page->ID ) ) {
                $permalink = get_permalink( $fallback_page->ID );
                if ( $permalink ) {
                    $base_url = $permalink;
                }
            }
        }

        return $base_url;
    }
}

if ( ! function_exists( 'aus_member_detail_permalink' ) ) {
    /**
     * Route Amaley member/producer CPT permalinks to the page-based profile view.
     *
     * @param string  $post_link Current permalink.
     * @param WP_Post $post      Current post object.
     * @param bool    $leavename Whether to keep post name.
     * @param bool    $sample    Whether this is a sample permalink.
     * @return string
     */
    function aus_member_detail_permalink( $post_link, $post, $leavename, $sample ) {
        if ( ! is_object( $post ) || empty( $post->post_type ) || 'amaley_member' !== $post->post_type ) {
            return $post_link;
        }

        $slug = ! empty( $post->post_name ) ? sanitize_title( $post->post_name ) : sanitize_title( get_the_title( $post ) );
        if ( ! $slug ) {
            return $post_link;
        }

        $base_url = aus_member_detail_base_url();
        if ( ! $base_url ) {
            return $post_link;
        }

        return add_query_arg( 'member_slug', $slug, $base_url );
    }
}

if ( ! has_filter( 'post_type_link', 'aus_member_detail_permalink' ) ) {
    add_filter( 'post_type_link', 'aus_member_detail_permalink', 20, 4 );
}
