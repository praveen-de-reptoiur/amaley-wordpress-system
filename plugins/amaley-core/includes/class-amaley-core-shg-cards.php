<?php
/**
 * SHG Group Cards Grid frontend widget and shortcode.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_SHG_Cards {
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_shortcode( 'amaley_shg_cards', array( $this, 'shortcode' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widget' ) );
    }

    /**
     * Register frontend assets.
     *
     * @return void
     */
    public function register_assets() {
        wp_register_style( 'amaley-core-shg-cards', AMALEY_CORE_URL . 'assets/amaley-core-shg-cards.css', array(), AMALEY_CORE_VERSION );
    }

    /**
     * Enqueue frontend assets.
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'amaley-core-shg-cards' );
    }

    /**
     * Shortcode renderer.
     *
     * @param array $atts Attributes.
     * @return string
     */
    public function shortcode( $atts ) {
        $this->enqueue_assets();
        return $this->render( is_array( $atts ) ? $atts : array() );
    }

    /**
     * Register Elementor category.
     *
     * @param object $elements_manager Elementor elements manager.
     * @return void
     */
    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    /**
     * Register Elementor widget.
     *
     * @param object $widgets_manager Elementor widgets manager.
     * @return void
     */
    public function register_elementor_widget( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
            return;
        }

        $file = AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-shg-cards-widget.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        }

        if ( class_exists( 'Amaley_Core_SHG_Cards_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_SHG_Cards_Widget( $this ) );
        }
    }

    /**
     * Defaults.
     *
     * @return array
     */
    public function defaults() {
        return array(
            'limit'                 => '8',
            'cluster_id'            => '',
            'featured_only'         => '0',
            'show_only_website'     => '1',
            'verification_status'   => '',
            'order_by'              => 'menu_order',
            'order'                 => 'ASC',
            'include_ids'           => '',
            'exclude_ids'           => '',
            'columns_desktop'       => '4',
            'columns_tablet'        => '2',
            'columns_mobile'        => '1',
            'image_ratio'           => '16-9',
            'equal_height'          => '1',
            'layout_style'          => 'grid',
            'show_image'            => '1',
            'show_badge'            => '1',
            'show_cluster'          => '1',
            'show_location'         => '1',
            'show_member_count'     => '1',
            'show_products'         => '1',
            'show_story'            => '1',
            'show_verification'     => '1',
            'show_button'           => '1',
            'button_text'           => 'View SHG Group',
            'button_url'            => '#',
            'empty_message'         => 'No Amaley SHG groups found yet.',
            'title'                 => '',
            'subtitle'              => '',
        );
    }

    /**
     * Render SHG cards.
     *
     * @param array $atts Attributes.
     * @return string
     */
    public function render( $atts = array() ) {
        $a    = shortcode_atts( $this->defaults(), $atts, 'amaley_shg_cards' );
        $shgs = $this->get_shgs( $a );

        $classes = array( 'amaley-core-shgs', 'amaley-core-shgs-layout-' . sanitize_html_class( $a['layout_style'] ), 'amaley-core-shgs-equal-' . $this->bool_class( $a['equal_height'] ), 'amaley-core-shgs-ratio-' . sanitize_html_class( $a['image_ratio'] ) );
        $style   = '--acore-shg-cols:' . absint( $a['columns_desktop'] ) . ';--acore-shg-cols-tablet:' . absint( $a['columns_tablet'] ) . ';--acore-shg-cols-mobile:' . absint( $a['columns_mobile'] ) . ';';

        $out  = '<section class="' . esc_attr( implode( ' ', $classes ) ) . '" style="' . esc_attr( $style ) . '">';
        if ( ! empty( $a['title'] ) || ! empty( $a['subtitle'] ) ) {
            $out .= '<div class="amaley-core-shgs-head">';
            if ( ! empty( $a['title'] ) ) {
                $out .= '<h2>' . esc_html( $a['title'] ) . '</h2>';
            }
            if ( ! empty( $a['subtitle'] ) ) {
                $out .= '<p>' . esc_html( $a['subtitle'] ) . '</p>';
            }
            $out .= '</div>';
        }

        if ( empty( $shgs ) ) {
            $out .= '<div class="amaley-core-shgs-empty">' . esc_html( $a['empty_message'] ) . '</div></section>';
            return $out;
        }

        $out .= '<div class="amaley-core-shgs-grid">';
        foreach ( $shgs as $shg ) {
            $out .= $this->render_card( $shg, $a );
        }
        $out .= '</div></section>';

        return $out;
    }

    /**
     * Query SHG groups.
     *
     * @param array $a Attributes.
     * @return array
     */
    private function get_shgs( $a ) {
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

        if ( ! empty( $a['cluster_id'] ) ) {
            $meta_query[] = array(
                'key'     => '_amaley_shg_cluster_id',
                'value'   => absint( $a['cluster_id'] ),
                'compare' => '=',
            );
        }

        if ( ! empty( $a['verification_status'] ) ) {
            $meta_query[] = array(
                'key'     => '_amaley_verification_status',
                'value'   => sanitize_key( $a['verification_status'] ),
                'compare' => '=',
            );
        }

        $query_args = array(
            'post_type'      => 'amaley_shg_group',
            'post_status'    => array( 'publish' ),
            'posts_per_page' => max( 1, absint( $a['limit'] ) ),
            'orderby'        => $this->orderby( $a['order_by'] ),
            'order'          => 'DESC' === strtoupper( $a['order'] ) ? 'DESC' : 'ASC',
        );

        if ( ! empty( $meta_query ) ) {
            $query_args['meta_query'] = $meta_query;
        }

        if ( '1' !== (string) $a['show_only_website'] ) {
            unset( $query_args['meta_query'] );
            $query_args['post_status'] = array( 'publish', 'draft', 'pending', 'private' );
        }

        if ( 'menu_order' === $a['order_by'] ) {
            $query_args['orderby']  = 'meta_value_num title';
            $query_args['meta_key'] = '_amaley_display_order';
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
            $items = get_posts(
                array(
                    'post_type'      => 'amaley_shg_group',
                    'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                    'posts_per_page' => max( 1, absint( $a['limit'] ) ),
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                )
            );
        }

        return $items;
    }

    /**
     * Render single card.
     *
     * @param WP_Post $shg SHG group post.
     * @param array   $a Attributes.
     * @return string
     */
    private function render_card( $shg, $a ) {
        $id             = $shg->ID;
        $cluster_id     = absint( get_post_meta( $id, '_amaley_shg_cluster_id', true ) );
        $village        = get_post_meta( $id, '_amaley_village', true );
        $district       = get_post_meta( $id, '_amaley_district', true );
        $member_count   = get_post_meta( $id, '_amaley_member_count', true );
        $products       = get_post_meta( $id, '_amaley_product_categories', true );
        $story          = get_post_meta( $id, '_amaley_short_story', true );
        $featured       = get_post_meta( $id, '_amaley_featured', true );
        $status         = get_post_meta( $id, '_amaley_status', true );
        $verification   = get_post_meta( $id, '_amaley_verification_status', true );
        $image          = get_the_post_thumbnail_url( $id, 'large' );
        $button_url     = str_replace( array( '{id}', '{slug}', '{cluster_id}' ), array( $id, $shg->post_name, $cluster_id ), (string) $a['button_url'] );
        $button_url     = $button_url ? $button_url : '#';

        if ( '' === $story ) {
            $story = $shg->post_excerpt ? $shg->post_excerpt : wp_trim_words( wp_strip_all_tags( $shg->post_content ), 22 );
        }

        $live_member_count = $this->count_members_for_shg( $id );
        if ( '' === (string) $member_count || '0' === (string) $member_count ) {
            $member_count = $live_member_count;
        }

        $out  = '<article class="amaley-core-shg-card">';
        if ( '1' === (string) $a['show_image'] ) {
            $out .= '<div class="amaley-core-shg-image">';
            if ( $image ) {
                $out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title( $shg ) ) . '" loading="lazy" />';
            } else {
                $out .= '<span class="amaley-core-shg-image-fallback">SHG</span>';
            }
            if ( '1' === (string) $a['show_badge'] ) {
                $badge = '1' === (string) $featured ? 'Featured SHG' : ( $status ? ucfirst( $status ) : 'SHG Group' );
                $out .= '<span class="amaley-core-shg-badge">' . esc_html( $badge ) . '</span>';
            }
            $out .= '</div>';
        }

        $out .= '<div class="amaley-core-shg-body">';
        $out .= '<h3 class="amaley-core-shg-title">' . esc_html( get_the_title( $shg ) ) . '</h3>';

        if ( '1' === (string) $a['show_cluster'] && $cluster_id ) {
            $out .= '<p class="amaley-core-shg-cluster">Cluster: ' . esc_html( get_the_title( $cluster_id ) ) . '</p>';
        }

        if ( '1' === (string) $a['show_location'] && ( $village || $district ) ) {
            $location = array_filter( array( $village, $district ) );
            $out .= '<p class="amaley-core-shg-location">' . esc_html( implode( ' · ', $location ) ) . '</p>';
        }

        if ( '1' === (string) $a['show_story'] && $story ) {
            $out .= '<p class="amaley-core-shg-desc">' . esc_html( wp_trim_words( $story, 24 ) ) . '</p>';
        }

        if ( '1' === (string) $a['show_products'] && $products ) {
            $out .= '<div class="amaley-core-shg-products">';
            foreach ( $this->split_terms( $products ) as $product ) {
                $out .= '<span>' . esc_html( $product ) . '</span>';
            }
            $out .= '</div>';
        }

        if ( '1' === (string) $a['show_member_count'] || '1' === (string) $a['show_verification'] ) {
            $out .= '<div class="amaley-core-shg-stats">';
            if ( '1' === (string) $a['show_member_count'] ) {
                $out .= '<span><strong>' . esc_html( absint( $member_count ) ) . '</strong> Members</span>';
            }
            if ( '1' === (string) $a['show_verification'] ) {
                $out .= '<span><strong>' . esc_html( $this->verification_label( $verification ) ) . '</strong> Status</span>';
            }
            $out .= '</div>';
        }

        if ( '1' === (string) $a['show_button'] ) {
            $out .= '<a class="amaley-core-shg-btn" href="' . esc_url( $button_url ) . '">' . esc_html( $a['button_text'] ) . '</a>';
        }

        $out .= '</div></article>';
        return $out;
    }

    /**
     * Count members linked to SHG.
     *
     * @param int $shg_id SHG ID.
     * @return int
     */
    private function count_members_for_shg( $shg_id ) {
        $query = new WP_Query(
            array(
                'post_type'      => 'amaley_member',
                'post_status'    => array( 'publish' ),
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array(
                        'key'     => '_amaley_member_shg_id',
                        'value'   => absint( $shg_id ),
                        'compare' => '=',
                    ),
                ),
            )
        );
        return absint( $query->found_posts );
    }

    private function orderby( $value ) {
        $allowed = array( 'title', 'date', 'modified', 'menu_order', 'rand' );
        return in_array( $value, $allowed, true ) ? $value : 'title';
    }

    private function ids_from_csv( $csv ) {
        if ( empty( $csv ) ) {
            return array();
        }
        return array_values( array_filter( array_map( 'absint', explode( ',', (string) $csv ) ) ) );
    }

    private function split_terms( $text ) {
        $terms = preg_split( '/[\n,]+/', (string) $text );
        $terms = array_map( 'trim', $terms );
        return array_slice( array_values( array_filter( $terms ) ), 0, 6 );
    }

    private function verification_label( $value ) {
        $labels = array(
            'verified' => 'Verified',
            'pending'  => 'Pending',
            'review'   => 'Review',
        );
        $key = sanitize_key( $value );
        return isset( $labels[ $key ] ) ? $labels[ $key ] : 'Pending';
    }

    private function bool_class( $value ) {
        return '1' === (string) $value ? 'yes' : 'no';
    }
}
