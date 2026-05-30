<?php
/**
 * Cluster Cards Grid frontend widget and shortcode.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Cluster_Cards {
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_shortcode( 'amaley_cluster_cards', array( $this, 'shortcode' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widget' ) );
    }

    /**
     * Register frontend assets.
     *
     * @return void
     */
    public function register_assets() {
        wp_register_style( 'amaley-core-cluster-cards', AMALEY_CORE_URL . 'assets/amaley-core-cluster-cards.css', array(), AMALEY_CORE_VERSION );
    }

    /**
     * Enqueue frontend assets.
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'amaley-core-cluster-cards' );
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

        $file = AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-cluster-cards-widget.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        }

        if ( class_exists( 'Amaley_Core_Cluster_Cards_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_Cluster_Cards_Widget( $this ) );
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
            'featured_only'         => '0',
            'show_only_website'     => '1',
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
            'show_region'           => '1',
            'show_villages'         => '1',
            'show_description'      => '1',
            'show_products'         => '1',
            'show_counts'           => '1',
            'show_button'           => '1',
            'button_text'           => 'View Cluster',
            'button_url'            => '#',
            'empty_message'         => 'No Amaley clusters found yet.',
            'title'                 => '',
            'subtitle'              => '',
        );
    }

    /**
     * Render cluster cards.
     *
     * @param array $atts Attributes.
     * @return string
     */
    public function render( $atts = array() ) {
        $a        = shortcode_atts( $this->defaults(), $atts, 'amaley_cluster_cards' );
        $clusters = $this->get_clusters( $a );

        $classes = array( 'amaley-core-clusters', 'amaley-core-clusters-layout-' . sanitize_html_class( $a['layout_style'] ), 'amaley-core-clusters-equal-' . $this->bool_class( $a['equal_height'] ), 'amaley-core-clusters-ratio-' . sanitize_html_class( $a['image_ratio'] ) );
        $style   = '--acore-cluster-cols:' . absint( $a['columns_desktop'] ) . ';--acore-cluster-cols-tablet:' . absint( $a['columns_tablet'] ) . ';--acore-cluster-cols-mobile:' . absint( $a['columns_mobile'] ) . ';';

        $out  = '<section class="' . esc_attr( implode( ' ', $classes ) ) . '" style="' . esc_attr( $style ) . '">';
        if ( ! empty( $a['title'] ) || ! empty( $a['subtitle'] ) ) {
            $out .= '<div class="amaley-core-clusters-head">';
            if ( ! empty( $a['title'] ) ) {
                $out .= '<h2>' . esc_html( $a['title'] ) . '</h2>';
            }
            if ( ! empty( $a['subtitle'] ) ) {
                $out .= '<p>' . esc_html( $a['subtitle'] ) . '</p>';
            }
            $out .= '</div>';
        }

        if ( empty( $clusters ) ) {
            $out .= '<div class="amaley-core-clusters-empty">' . esc_html( $a['empty_message'] ) . '</div></section>';
            return $out;
        }

        $out .= '<div class="amaley-core-clusters-grid">';
        foreach ( $clusters as $cluster ) {
            $out .= $this->render_card( $cluster, $a );
        }
        $out .= '</div></section>';

        return $out;
    }

    /**
     * Query clusters.
     *
     * @param array $a Attributes.
     * @return array
     */
    private function get_clusters( $a ) {
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

        $query_args = array(
            'post_type'      => 'amaley_cluster',
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
                    'post_type'      => 'amaley_cluster',
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
     * @param WP_Post $cluster Cluster post.
     * @param array   $a Attributes.
     * @return string
     */
    private function render_card( $cluster, $a ) {
        $id          = $cluster->ID;
        $region      = get_post_meta( $id, '_amaley_region', true );
        $district    = get_post_meta( $id, '_amaley_district', true );
        $block_area  = get_post_meta( $id, '_amaley_block_area', true );
        $villages    = get_post_meta( $id, '_amaley_villages', true );
        $intro       = get_post_meta( $id, '_amaley_short_intro', true );
        $products    = get_post_meta( $id, '_amaley_main_products', true );
        $featured    = get_post_meta( $id, '_amaley_featured', true );
        $status      = get_post_meta( $id, '_amaley_status', true );
        $image       = get_the_post_thumbnail_url( $id, 'large' );
        $button_url  = str_replace( array( '{id}', '{slug}' ), array( $id, $cluster->post_name ), (string) $a['button_url'] );
        $button_url  = $button_url ? $button_url : '#';

        if ( '' === $intro ) {
            $intro = $cluster->post_excerpt ? $cluster->post_excerpt : wp_trim_words( wp_strip_all_tags( $cluster->post_content ), 22 );
        }

        $out  = '<article class="amaley-core-cluster-card">';
        if ( '1' === (string) $a['show_image'] ) {
            $out .= '<div class="amaley-core-cluster-image">';
            if ( $image ) {
                $out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title( $cluster ) ) . '" loading="lazy" />';
            } else {
                $out .= '<span class="amaley-core-cluster-image-fallback">Amaley</span>';
            }
            if ( '1' === (string) $a['show_badge'] ) {
                $badge = '1' === (string) $featured ? 'Featured Cluster' : ( $status ? ucfirst( $status ) : 'Cluster' );
                $out .= '<span class="amaley-core-cluster-badge">' . esc_html( $badge ) . '</span>';
            }
            $out .= '</div>';
        }

        $out .= '<div class="amaley-core-cluster-body">';
        $out .= '<h3 class="amaley-core-cluster-title">' . esc_html( get_the_title( $cluster ) ) . '</h3>';

        if ( '1' === (string) $a['show_region'] && ( $region || $district || $block_area ) ) {
            $meta = array_filter( array( $region, $district, $block_area ) );
            $out .= '<p class="amaley-core-cluster-meta">' . esc_html( implode( ' · ', $meta ) ) . '</p>';
        }

        if ( '1' === (string) $a['show_villages'] && $villages ) {
            $out .= '<p class="amaley-core-cluster-villages">' . esc_html( $villages ) . '</p>';
        }

        if ( '1' === (string) $a['show_description'] && $intro ) {
            $out .= '<p class="amaley-core-cluster-desc">' . esc_html( wp_trim_words( $intro, 24 ) ) . '</p>';
        }

        if ( '1' === (string) $a['show_products'] && $products ) {
            $out .= '<div class="amaley-core-cluster-products">';
            foreach ( $this->split_terms( $products ) as $product ) {
                $out .= '<span>' . esc_html( $product ) . '</span>';
            }
            $out .= '</div>';
        }

        if ( '1' === (string) $a['show_counts'] ) {
            $shg_count    = $this->count_shgs_for_cluster( $id );
            $member_count = $this->count_members_for_cluster( $id );
            $out .= '<div class="amaley-core-cluster-stats"><span><strong>' . esc_html( $shg_count ) . '</strong> SHGs</span><span><strong>' . esc_html( $member_count ) . '</strong> Producers</span></div>';
        }

        if ( '1' === (string) $a['show_button'] ) {
            $out .= '<a class="amaley-core-cluster-btn" href="' . esc_url( $button_url ) . '">' . esc_html( $a['button_text'] ) . '</a>';
        }

        $out .= '</div></article>';
        return $out;
    }

    /**
     * Count SHGs for cluster.
     *
     * @param int $cluster_id Cluster ID.
     * @return int
     */
    private function count_shgs_for_cluster( $cluster_id ) {
        $query = new WP_Query(
            array(
                'post_type'      => 'amaley_shg_group',
                'post_status'    => array( 'publish' ),
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array(
                        'key'     => '_amaley_shg_cluster_id',
                        'value'   => absint( $cluster_id ),
                        'compare' => '=',
                    ),
                ),
            )
        );
        return absint( $query->found_posts );
    }

    /**
     * Count members linked through SHGs.
     *
     * @param int $cluster_id Cluster ID.
     * @return int
     */
    private function count_members_for_cluster( $cluster_id ) {
        $shg_ids = get_posts(
            array(
                'post_type'      => 'amaley_shg_group',
                'post_status'    => array( 'publish' ),
                'posts_per_page' => 200,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array(
                        'key'     => '_amaley_shg_cluster_id',
                        'value'   => absint( $cluster_id ),
                        'compare' => '=',
                    ),
                ),
            )
        );
        if ( empty( $shg_ids ) ) {
            return 0;
        }
        $query = new WP_Query(
            array(
                'post_type'      => 'amaley_member',
                'post_status'    => array( 'publish' ),
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array(
                        'key'     => '_amaley_member_shg_id',
                        'value'   => array_map( 'absint', $shg_ids ),
                        'compare' => 'IN',
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

    private function bool_class( $value ) {
        return '1' === (string) $value ? 'yes' : 'no';
    }
}
