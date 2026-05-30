<?php
/**
 * Product Origin Panel frontend widget and shortcode.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Product_Origin_Panel {
    /** Constructor. */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_shortcode( 'amaley_product_origin_panel', array( $this, 'shortcode' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widget' ) );
    }

    /** Register frontend assets. */
    public function register_assets() {
        wp_register_style( 'amaley-core-product-origin-panel', AMALEY_CORE_URL . 'assets/amaley-core-product-origin-panel.css', array(), AMALEY_CORE_VERSION );
    }

    /** Enqueue frontend assets. */
    public function enqueue_assets() {
        wp_enqueue_style( 'amaley-core-product-origin-panel' );
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

        $file = AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-product-origin-panel-widget.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        }

        if ( class_exists( 'Amaley_Core_Product_Origin_Panel_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_Product_Origin_Panel_Widget( $this ) );
        }
    }

    /** Defaults. */
    public function defaults() {
        return array(
            'product_id'             => '',
            'product_sku'            => '',
            'product_name'           => '',
            'product_slug'           => '',
            'auto_detect'            => '1',
            'layout_style'           => 'panel',
            'show_header'            => '1',
            'show_product_name'      => '1',
            'show_cluster'           => '1',
            'show_shgs'              => '1',
            'show_producers'         => '1',
            'show_source_village'    => '1',
            'show_origin_note'       => '1',
            'show_traceability_note' => '1',
            'show_button'            => '1',
            'show_empty'             => '1',
            'title'                  => 'Product Origin',
            'subtitle'               => 'A quick view of where this product comes from and the community value chain connected with it.',
            'button_text'            => 'View Origin Story',
            'button_url'             => '#',
            'empty_message'          => 'Origin details are being updated for this product.',
        );
    }

    /** Render panel. */
    public function render( $atts = array() ) {
        $a          = shortcode_atts( $this->defaults(), $atts, 'amaley_product_origin_panel' );
        $product_id = $this->resolve_product_id( $a );

        if ( ! $product_id ) {
            return $this->render_empty( $a );
        }

        $origin = $this->get_origin_data( $product_id );
        if ( ! $origin['has_origin'] ) {
            return $this->render_empty( $a );
        }

        $classes = array(
            'amaley-core-origin-panel',
            'amaley-core-origin-panel-layout-' . sanitize_html_class( $a['layout_style'] ),
        );

        $out  = '<section class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        $out .= '<div class="amaley-core-origin-panel-inner">';

        if ( '1' === (string) $a['show_header'] ) {
            $out .= '<div class="amaley-core-origin-panel-head">';
            $out .= '<span class="amaley-core-origin-panel-kicker">Traceability</span>';
            if ( ! empty( $a['title'] ) ) {
                $out .= '<h2>' . esc_html( $a['title'] ) . '</h2>';
            }
            if ( ! empty( $a['subtitle'] ) ) {
                $out .= '<p>' . esc_html( $a['subtitle'] ) . '</p>';
            }
            $out .= '</div>';
        }

        $out .= '<div class="amaley-core-origin-panel-card">';
        $out .= '<div class="amaley-core-origin-panel-main">';

        if ( '1' === (string) $a['show_product_name'] ) {
            $out .= '<div class="amaley-core-origin-panel-product">';
            $out .= '<span>Product</span>';
            $out .= '<strong>' . esc_html( get_the_title( $product_id ) ) . '</strong>';
            $out .= '</div>';
        }

        if ( '1' === (string) $a['show_origin_note'] && ! empty( $origin['origin_note'] ) ) {
            $out .= '<p class="amaley-core-origin-panel-note">' . esc_html( $origin['origin_note'] ) . '</p>';
        }

        if ( '1' === (string) $a['show_traceability_note'] && ! empty( $origin['traceability_note'] ) ) {
            $out .= '<p class="amaley-core-origin-panel-trace-note">' . esc_html( $origin['traceability_note'] ) . '</p>';
        }

        $out .= '</div>';

        $out .= '<div class="amaley-core-origin-panel-details">';

        if ( '1' === (string) $a['show_source_village'] && ! empty( $origin['source_village'] ) ) {
            $out .= $this->render_detail_row( 'Source', $origin['source_village'] );
        }

        if ( '1' === (string) $a['show_cluster'] && ! empty( $origin['cluster_name'] ) ) {
            $out .= $this->render_detail_row( 'Cluster', $origin['cluster_name'] );
        }

        if ( '1' === (string) $a['show_shgs'] && ! empty( $origin['shg_names'] ) ) {
            $out .= $this->render_detail_row( 'SHG Groups', implode( ', ', $origin['shg_names'] ) );
        }

        if ( '1' === (string) $a['show_producers'] && ! empty( $origin['member_names'] ) ) {
            $out .= $this->render_detail_row( 'Producers', implode( ', ', $origin['member_names'] ) );
        }

        if ( '1' === (string) $a['show_button'] ) {
            $button_url = str_replace( array( '{product_id}', '{product_slug}', '{cluster_id}' ), array( $product_id, get_post_field( 'post_name', $product_id ), $origin['cluster_id'] ), (string) $a['button_url'] );
            $button_url = $button_url ? $button_url : '#';
            $out .= '<a class="amaley-core-origin-panel-btn" href="' . esc_url( $button_url ) . '">' . esc_html( $a['button_text'] ) . '</a>';
        }

        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</section>';

        return $out;
    }

    /** Render detail row. */
    private function render_detail_row( $label, $value ) {
        return '<div class="amaley-core-origin-panel-row"><span>' . esc_html( $label ) . '</span><strong>' . esc_html( $value ) . '</strong></div>';
    }

    /** Render empty state. */
    private function render_empty( $a ) {
        if ( '1' !== (string) $a['show_empty'] ) {
            return '';
        }

        $this->enqueue_assets();
        return '<section class="amaley-core-origin-panel"><div class="amaley-core-origin-panel-empty">' . esc_html( $a['empty_message'] ) . '</div></section>';
    }

    /** Resolve product ID from shortcode/widget settings. */
    private function resolve_product_id( $a ) {
        if ( ! empty( $a['product_id'] ) ) {
            $product_id = absint( $a['product_id'] );
            return 'product' === get_post_type( $product_id ) ? $product_id : 0;
        }

        if ( ! empty( $a['product_sku'] ) && function_exists( 'wc_get_product_id_by_sku' ) ) {
            $product_id = absint( wc_get_product_id_by_sku( sanitize_text_field( $a['product_sku'] ) ) );
            if ( $product_id ) {
                return $product_id;
            }
        }

        if ( ! empty( $a['product_name'] ) ) {
            $product_id = $this->resolve_product_id_by_name( sanitize_text_field( $a['product_name'] ) );
            if ( $product_id ) {
                return $product_id;
            }
        }

        if ( ! empty( $a['product_slug'] ) ) {
            $product_id = $this->resolve_product_id_by_slug( sanitize_title( $a['product_slug'] ) );
            if ( $product_id ) {
                return $product_id;
            }
        }

        if ( '1' === (string) $a['auto_detect'] ) {
            $queried_id = get_queried_object_id();
            if ( $queried_id && 'product' === get_post_type( $queried_id ) ) {
                return absint( $queried_id );
            }

            global $post;
            if ( $post && isset( $post->ID ) && 'product' === get_post_type( $post->ID ) ) {
                return absint( $post->ID );
            }
        }

        return 0;
    }


    /** Resolve product ID by exact product title, with a safe case-insensitive fallback. */
    private function resolve_product_id_by_name( $product_name ) {
        $product_name = trim( (string) $product_name );
        if ( '' === $product_name ) {
            return 0;
        }

        $query = new WP_Query(
            array(
                'post_type'              => 'product',
                'post_status'            => array( 'publish', 'private', 'draft' ),
                'title'                  => $product_name,
                'fields'                 => 'ids',
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
            )
        );

        if ( ! empty( $query->posts[0] ) ) {
            return absint( $query->posts[0] );
        }

        $candidates = get_posts(
            array(
                'post_type'              => 'product',
                'post_status'            => array( 'publish', 'private', 'draft' ),
                's'                      => $product_name,
                'fields'                 => 'ids',
                'posts_per_page'         => 20,
                'no_found_rows'          => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
            )
        );

        foreach ( $candidates as $candidate_id ) {
            if ( 0 === strcasecmp( trim( get_the_title( $candidate_id ) ), $product_name ) ) {
                return absint( $candidate_id );
            }
        }

        return 0;
    }

    /** Resolve product ID by product slug. */
    private function resolve_product_id_by_slug( $product_slug ) {
        $product_slug = trim( (string) $product_slug );
        if ( '' === $product_slug ) {
            return 0;
        }

        $post = get_page_by_path( $product_slug, OBJECT, 'product' );
        return ( $post && isset( $post->ID ) ) ? absint( $post->ID ) : 0;
    }

    /** Get origin mapping data. */
    private function get_origin_data( $product_id ) {
        $show_origin = get_post_meta( $product_id, '_amaley_origin_show_origin', true );
        $cluster_id  = absint( get_post_meta( $product_id, '_amaley_origin_cluster_id', true ) );
        $shg_ids     = $this->ids_from_meta( get_post_meta( $product_id, '_amaley_origin_shg_ids', true ) );
        $member_ids  = $this->ids_from_meta( get_post_meta( $product_id, '_amaley_origin_member_ids', true ) );

        $data = array(
            'show_origin'       => $show_origin,
            'cluster_id'        => $cluster_id,
            'cluster_name'      => $cluster_id ? get_the_title( $cluster_id ) : '',
            'shg_ids'           => $shg_ids,
            'shg_names'         => $this->titles_from_ids( $shg_ids ),
            'member_ids'        => $member_ids,
            'member_names'      => $this->titles_from_ids( $member_ids ),
            'source_village'    => get_post_meta( $product_id, '_amaley_origin_source_village', true ),
            'origin_note'       => get_post_meta( $product_id, '_amaley_origin_note', true ),
            'traceability_note' => get_post_meta( $product_id, '_amaley_origin_traceability_note', true ),
            'has_origin'        => false,
        );

        $has_content = $data['cluster_id'] || ! empty( $data['shg_ids'] ) || ! empty( $data['member_ids'] ) || ! empty( $data['source_village'] ) || ! empty( $data['origin_note'] ) || ! empty( $data['traceability_note'] );
        $data['has_origin'] = $has_content && '0' !== (string) $show_origin;

        return $data;
    }

    /** IDs from stored meta. */
    private function ids_from_meta( $value ) {
        if ( empty( $value ) ) {
            return array();
        }
        if ( is_array( $value ) ) {
            return array_values( array_filter( array_map( 'absint', $value ) ) );
        }
        return array_values( array_filter( array_map( 'absint', explode( ',', (string) $value ) ) ) );
    }

    /** Titles from IDs. */
    private function titles_from_ids( $ids ) {
        $titles = array();
        foreach ( $ids as $id ) {
            $title = get_the_title( $id );
            if ( $title ) {
                $titles[] = $title;
            }
        }
        return $titles;
    }
}
