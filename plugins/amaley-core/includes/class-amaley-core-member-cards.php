<?php
/**
 * Member / Producer Cards Grid frontend widget and shortcode.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Member_Cards {
    /** Constructor. */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_shortcode( 'amaley_member_cards', array( $this, 'shortcode' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widget' ) );
    }

    /** Register frontend assets. */
    public function register_assets() {
        wp_register_style( 'amaley-core-member-cards', AMALEY_CORE_URL . 'assets/amaley-core-member-cards.css', array(), AMALEY_CORE_VERSION );
    }

    /** Enqueue frontend assets. */
    public function enqueue_assets() {
        wp_enqueue_style( 'amaley-core-member-cards' );
    }

    /** Shortcode renderer. */
    public function shortcode( $atts ) {
        $this->enqueue_assets();
        return $this->render( is_array( $atts ) ? $atts : array() );
    }

    /** Register Elementor category. */
    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    /** Register Elementor widget. */
    public function register_elementor_widget( $widgets_manager ) {
        if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
            return;
        }

        $file = AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-member-cards-widget.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        }

        if ( class_exists( 'Amaley_Core_Member_Cards_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_Member_Cards_Widget( $this ) );
        }
    }

    /** Defaults. */
    public function defaults() {
        return array(
            'limit'             => '8',
            'featured_only'     => '0',
            'show_only_website' => '1',
            'shg_id'            => '',
            'cluster_id'        => '',
            'order_by'          => 'title',
            'order'             => 'ASC',
            'include_ids'       => '',
            'exclude_ids'       => '',
            'columns_desktop'   => '4',
            'columns_tablet'    => '2',
            'columns_mobile'    => '1',
            'image_ratio'       => '1-1',
            'image_shape'       => 'circle',
            'equal_height'      => '1',
            'layout_style'      => 'grid',
            'show_image'        => '1',
            'show_badge'        => '1',
            'show_shg'          => '1',
            'show_cluster'      => '1',
            'show_village'      => '1',
            'show_role'         => '1',
            'show_skills'       => '1',
            'show_products'     => '1',
            'show_bio'          => '0',
            'show_button'       => '1',
            'button_text'       => 'View Profile',
            'button_url'        => '#',
            'empty_message'     => 'No Amaley members / producers found yet.',
            'title'             => '',
            'subtitle'          => '',
        );
    }

    /** Render member cards. */
    public function render( $atts = array() ) {
        $a       = shortcode_atts( $this->defaults(), $atts, 'amaley_member_cards' );
        $members = $this->get_members( $a );

        $classes = array(
            'amaley-core-members',
            'amaley-core-members-layout-' . sanitize_html_class( $a['layout_style'] ),
            'amaley-core-members-equal-' . $this->bool_class( $a['equal_height'] ),
            'amaley-core-members-ratio-' . sanitize_html_class( $a['image_ratio'] ),
            'amaley-core-members-image-' . sanitize_html_class( $a['image_shape'] ),
        );
        $style = '--acore-member-cols:' . absint( $a['columns_desktop'] ) . ';--acore-member-cols-tablet:' . absint( $a['columns_tablet'] ) . ';--acore-member-cols-mobile:' . absint( $a['columns_mobile'] ) . ';';

        $out  = '<section class="' . esc_attr( implode( ' ', $classes ) ) . '" style="' . esc_attr( $style ) . '">';
        if ( ! empty( $a['title'] ) || ! empty( $a['subtitle'] ) ) {
            $out .= '<div class="amaley-core-members-head">';
            if ( ! empty( $a['title'] ) ) {
                $out .= '<h2>' . esc_html( $a['title'] ) . '</h2>';
            }
            if ( ! empty( $a['subtitle'] ) ) {
                $out .= '<p>' . esc_html( $a['subtitle'] ) . '</p>';
            }
            $out .= '</div>';
        }

        if ( empty( $members ) ) {
            $out .= '<div class="amaley-core-members-empty">' . esc_html( $a['empty_message'] ) . '</div></section>';
            return $out;
        }

        $out .= '<div class="amaley-core-members-grid">';
        foreach ( $members as $member ) {
            $out .= $this->render_card( $member, $a );
        }
        $out .= '</div></section>';

        return $out;
    }

    /** Query members. */
    private function get_members( $a ) {
        $meta_query = array();

        if ( '1' === (string) $a['show_only_website'] ) {
            $meta_query[] = array(
                'key'     => '_amaley_show_on_website',
                'value'   => '1',
                'compare' => '=',
            );
        }

        if ( '1' === (string) $a['featured_only'] ) {
            $meta_query[] = array(
                'key'     => '_amaley_featured',
                'value'   => '1',
                'compare' => '=',
            );
        }

        if ( ! empty( $a['shg_id'] ) ) {
            $meta_query[] = array(
                'key'     => '_amaley_member_shg_id',
                'value'   => absint( $a['shg_id'] ),
                'compare' => '=',
            );
        }

        if ( empty( $a['shg_id'] ) && ! empty( $a['cluster_id'] ) ) {
            $shg_ids = $this->shg_ids_for_cluster( absint( $a['cluster_id'] ) );
            if ( empty( $shg_ids ) ) {
                return array();
            }
            $meta_query[] = array(
                'key'     => '_amaley_member_shg_id',
                'value'   => $shg_ids,
                'compare' => 'IN',
            );
        }

        $query_args = array(
            'post_type'      => 'amaley_member',
            'post_status'    => array( 'publish' ),
            'posts_per_page' => max( 1, absint( $a['limit'] ) ),
            'orderby'        => $this->orderby( $a['order_by'] ),
            'order'          => 'DESC' === strtoupper( $a['order'] ) ? 'DESC' : 'ASC',
        );

        if ( ! empty( $meta_query ) ) {
            $query_args['meta_query'] = $meta_query;
        }

        $include_ids = $this->ids_from_csv( $a['include_ids'] );
        if ( ! empty( $include_ids ) ) {
            $query_args['post__in'] = $include_ids;
            $query_args['orderby']  = 'post__in';
        }

        $exclude_ids = $this->ids_from_csv( $a['exclude_ids'] );
        if ( ! empty( $exclude_ids ) ) {
            $query_args['post__not_in'] = $exclude_ids;
        }

        $items = get_posts( $query_args );

        if ( empty( $items ) && '1' !== (string) $a['show_only_website'] ) {
            unset( $query_args['meta_query'] );
            $query_args['post_status'] = array( 'publish', 'draft', 'pending', 'private' );
            $items = get_posts( $query_args );
        }

        return $items;
    }

    /** Render single member card. */
    private function render_card( $member, $a ) {
        $id        = $member->ID;
        $shg_id    = absint( get_post_meta( $id, '_amaley_member_shg_id', true ) );
        $role      = get_post_meta( $id, '_amaley_role', true );
        $skills    = get_post_meta( $id, '_amaley_skills', true );
        $products  = get_post_meta( $id, '_amaley_products_handled', true );
        $bio       = get_post_meta( $id, '_amaley_short_bio', true );
        $story     = get_post_meta( $id, '_amaley_story', true );
        $village   = get_post_meta( $id, '_amaley_village', true );
        $photo_url = get_post_meta( $id, '_amaley_photo_url', true );
        $featured  = get_post_meta( $id, '_amaley_featured', true );
        $status    = get_post_meta( $id, '_amaley_status', true );
        $image     = get_the_post_thumbnail_url( $id, 'medium_large' );
        $image     = $image ? $image : $photo_url;

        $shg_name      = $shg_id ? get_the_title( $shg_id ) : '';
        $cluster_id    = $shg_id ? absint( get_post_meta( $shg_id, '_amaley_shg_cluster_id', true ) ) : 0;
        $cluster_name  = $cluster_id ? get_the_title( $cluster_id ) : '';
        $button_url    = str_replace( array( '{id}', '{slug}', '{shg_id}', '{cluster_id}' ), array( $id, $member->post_name, $shg_id, $cluster_id ), (string) $a['button_url'] );
        $button_url    = $button_url ? $button_url : '#';
        $display_name  = get_the_title( $member );
        $badge         = '1' === (string) $featured ? 'Featured' : ( $status ? ucfirst( $status ) : 'Active' );

        if ( '' === $bio ) {
            $bio = $story ? $story : ( $member->post_excerpt ? $member->post_excerpt : wp_trim_words( wp_strip_all_tags( $member->post_content ), 22 ) );
        }

        $meta_line = array();
        if ( '1' === (string) $a['show_shg'] && $shg_name ) {
            $meta_line[] = $shg_name;
        }
        if ( '1' === (string) $a['show_cluster'] && $cluster_name ) {
            $meta_line[] = $cluster_name;
        }

        $out  = '<article class="amaley-core-member-card">';
        $out .= '<div class="amaley-core-member-shell">';
        $out .= '<div class="amaley-core-member-head">';

        if ( '1' === (string) $a['show_badge'] ) {
            $out .= '<span class="amaley-core-member-badge">' . esc_html( $badge ) . '</span>';
        }

        if ( '1' === (string) $a['show_image'] ) {
            $out .= '<div class="amaley-core-member-media' . ( $image ? ' has-photo' : ' is-fallback' ) . '">';
            if ( $image ) {
                $out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $display_name ) . '" loading="lazy" />';
            } else {
                $out .= '<div class="amaley-core-member-media-fallback"><span>Amaley Producer</span><small>Photo coming soon</small></div>';
            }
            $out .= '</div>';
        }

        $out .= '</div>';
        $out .= '<div class="amaley-core-member-body">';
        $out .= '<h3 class="amaley-core-member-title">' . esc_html( $display_name ) . '</h3>';

        if ( '1' === (string) $a['show_role'] && $role ) {
            $out .= '<p class="amaley-core-member-role">' . esc_html( $role ) . '</p>';
        }

        if ( '1' === (string) $a['show_village'] && $village ) {
            $out .= '<p class="amaley-core-member-village">' . esc_html( $village ) . '</p>';
        }

        if ( ! empty( $meta_line ) ) {
            $out .= '<p class="amaley-core-member-meta">' . esc_html( implode( ' · ', $meta_line ) ) . '</p>';
        }

        if ( '1' === (string) $a['show_bio'] && $bio ) {
            $out .= '<p class="amaley-core-member-bio">' . esc_html( wp_trim_words( $bio, 18 ) ) . '</p>';
        }

        if ( '1' === (string) $a['show_skills'] && $skills ) {
            $skill_terms = $this->split_terms( $skills, 3 );
            if ( ! empty( $skill_terms ) ) {
                $out .= '<div class="amaley-core-member-tags amaley-core-member-skills">';
                foreach ( $skill_terms as $skill ) {
                    $out .= '<span>' . esc_html( $skill ) . '</span>';
                }
                $out .= '</div>';
            }
        }

        if ( '1' === (string) $a['show_products'] && $products ) {
            $product_terms = $this->split_terms( $products, 2 );
            if ( ! empty( $product_terms ) ) {
                $out .= '<div class="amaley-core-member-tags amaley-core-member-products">';
                foreach ( $product_terms as $product ) {
                    $out .= '<span>' . esc_html( $product ) . '</span>';
                }
                $out .= '</div>';
            }
        }

        if ( '1' === (string) $a['show_button'] ) {
            $out .= '<a class="amaley-core-member-btn" href="' . esc_url( $button_url ) . '">' . esc_html( $a['button_text'] ) . '</a>';
        }

        $out .= '</div></div></article>';
        return $out;
    }

    /** SHG ids for cluster. */
    private function shg_ids_for_cluster( $cluster_id ) {
        return get_posts( array(
            'post_type'      => 'amaley_shg_group',
            'post_status'    => array( 'publish' ),
            'posts_per_page' => 500,
            'fields'         => 'ids',
            'meta_query'     => array(
                array(
                    'key'     => '_amaley_shg_cluster_id',
                    'value'   => absint( $cluster_id ),
                    'compare' => '=',
                ),
            ),
        ) );
    }

    private function orderby( $value ) {
        $allowed = array( 'title', 'date', 'modified', 'rand' );
        return in_array( $value, $allowed, true ) ? $value : 'title';
    }

    private function ids_from_csv( $csv ) {
        if ( empty( $csv ) ) {
            return array();
        }
        return array_values( array_filter( array_map( 'absint', explode( ',', (string) $csv ) ) ) );
    }

    private function split_terms( $text, $limit = 5 ) {
        $terms = preg_split( '/[\n,]+/', (string) $text );
        $terms = array_map( 'trim', $terms );
        return array_slice( array_values( array_filter( $terms ) ), 0, max( 1, absint( $limit ) ) );
    }

    private function member_initials( $name ) {
        $name   = trim( wp_strip_all_tags( (string) $name ) );
        $parts  = preg_split( '/\s+/', $name );
        $parts  = array_values( array_filter( $parts ) );
        $first  = isset( $parts[0] ) ? mb_substr( $parts[0], 0, 1 ) : 'P';
        $second = isset( $parts[1] ) ? mb_substr( $parts[1], 0, 1 ) : '';
        return strtoupper( $first . $second );
    }

    private function bool_class( $value ) {
        return '1' === (string) $value ? 'yes' : 'no';
    }
}
