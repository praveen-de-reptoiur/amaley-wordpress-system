<?php
/**
 * SHG Single section widgets renderer.
 *
 * v1.0.69: CSS recovery pass for SHG Single; keeps section buttons while restoring approved card/hero/contact styling.
 * v1.0.93: Adds safe OG Card 1 selector and full controls support for SHG Single linked Cluster, Members and Products.
 * v1.0.93.2: Fixes SHG Single OG Card full controls registration so controls actually apply in Elementor.
 * v1.0.93.3: Hides duplicate legacy card controls when SHG Single Card Template is OG Card 1.
 * v1.0.95: Clean safe pagination for SHG Single Members and Products from stable base.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_SHG_Single_Sections {
    /** Prevent duplicate Elementor widget registration across hook variants. */
    private $elementor_widgets_registered = false;

    /** Constructor. */
    public function __construct() {
        $GLOBALS['amaley_core_shg_single_sections'] = $this;
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );

        add_action( 'wp_ajax_amaley_shg_single_pagination', array( $this, 'ajax_shg_single_pagination' ) );
        add_action( 'wp_ajax_nopriv_amaley_shg_single_pagination', array( $this, 'ajax_shg_single_pagination' ) );

        add_shortcode( 'amaley_shg_single_hero', array( $this, 'shortcode_hero' ) );
        add_shortcode( 'amaley_shg_single_snapshot', array( $this, 'shortcode_snapshot' ) );
        add_shortcode( 'amaley_shg_single_story', array( $this, 'shortcode_story' ) );
        add_shortcode( 'amaley_shg_single_cluster', array( $this, 'shortcode_cluster' ) );
        add_shortcode( 'amaley_shg_single_members', array( $this, 'shortcode_members' ) );
        add_shortcode( 'amaley_shg_single_products', array( $this, 'shortcode_products' ) );
        add_shortcode( 'amaley_shg_single_gallery', array( $this, 'shortcode_gallery' ) );
        add_shortcode( 'amaley_shg_single_contact', array( $this, 'shortcode_contact' ) );
        add_shortcode( 'amaley_shg_single_cta', array( $this, 'shortcode_cta' ) );

        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );
    }

    public function register_assets() {
        wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        wp_register_style( 'amaley-core-shg-single-sections', AMALEY_CORE_URL . 'assets/amaley-core-shg-single-sections.css', array( 'amaley-core-cards' ), AMALEY_CORE_VERSION );
        wp_register_script( 'amaley-core-shg-pagination', AMALEY_CORE_URL . 'assets/amaley-core-shg-pagination.js', array(), AMALEY_CORE_VERSION, true );
    }

    public function enqueue_assets() {
        if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        }
        wp_enqueue_style( 'amaley-core-cards' );
        wp_enqueue_style( 'amaley-core-shg-single-sections' );

        if ( $this->should_load_shg_pagination_script() ) {
            if ( ! wp_script_is( 'amaley-core-shg-pagination', 'registered' ) ) {
                wp_register_script( 'amaley-core-shg-pagination', AMALEY_CORE_URL . 'assets/amaley-core-shg-pagination.js', array(), AMALEY_CORE_VERSION, true );
            }
            wp_enqueue_script( 'amaley-core-shg-pagination' );
        }
    }

    private function should_load_shg_pagination_script() {
        if ( is_admin() ) { return false; }

        /*
         * Elementor editor preview iframe behaves like frontend.
         * Do not load pagination JS there, otherwise Elementor sidebar can keep refreshing.
         */
        if ( isset( $_GET['action'] ) && 'elementor' === sanitize_key( wp_unslash( $_GET['action'] ) ) ) { return false; } // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['elementor-preview'] ) || isset( $_GET['preview_id'] ) || isset( $_GET['preview_nonce'] ) ) { return false; } // phpcs:ignore WordPress.Security.NonceVerification.Recommended

        if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) ) {
            $elementor = \Elementor\Plugin::$instance;
            if ( isset( $elementor->editor ) && method_exists( $elementor->editor, 'is_edit_mode' ) && $elementor->editor->is_edit_mode() ) { return false; }
            if ( isset( $elementor->preview ) && method_exists( $elementor->preview, 'is_preview_mode' ) && $elementor->preview->is_preview_mode() ) { return false; }
        }

        return true;
    }

    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    public function register_elementor_widgets( $widgets_manager ) {
        if ( $this->elementor_widgets_registered || ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) { return; }
        $files = array(
            'class-amaley-core-shg-single-widget-controls.php',
            'class-amaley-core-shg-single-hero-widget.php',
            'class-amaley-core-shg-single-snapshot-widget.php',
            'class-amaley-core-shg-single-story-widget.php',
            'class-amaley-core-shg-single-cluster-widget.php',
            'class-amaley-core-shg-single-members-widget.php',
            'class-amaley-core-shg-single-products-widget.php',
            'class-amaley-core-shg-single-gallery-widget.php',
            'class-amaley-core-shg-single-contact-widget.php',
            'class-amaley-core-shg-single-cta-widget.php',
        );
        foreach ( $files as $file_name ) {
            $file = AMALEY_CORE_PATH . 'includes/widgets/' . $file_name;
            if ( file_exists( $file ) ) { require_once $file; }
        }
        $widgets = array(
            'Amaley_Core_SHG_Single_Hero_Widget',
            'Amaley_Core_SHG_Single_Snapshot_Widget',
            'Amaley_Core_SHG_Single_Story_Widget',
            'Amaley_Core_SHG_Single_Cluster_Widget',
            'Amaley_Core_SHG_Single_Members_Widget',
            'Amaley_Core_SHG_Single_Products_Widget',
            'Amaley_Core_SHG_Single_Gallery_Widget',
            'Amaley_Core_SHG_Single_Contact_Widget',
            'Amaley_Core_SHG_Single_CTA_Widget',
        );
        foreach ( $widgets as $class_name ) {
            if ( class_exists( $class_name ) && method_exists( $widgets_manager, 'register' ) ) {
                $widgets_manager->register( new $class_name() );
            }
        }
        $this->elementor_widgets_registered = true;
    }

    public function boolish( $value ) { return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true ); }
    public function s( $value ) { return is_scalar( $value ) ? trim( (string) $value ) : ''; }
    public function url_from_setting( $value, $fallback = '#' ) {
        if ( is_array( $value ) && isset( $value['url'] ) ) { return $value['url'] ? $value['url'] : $fallback; }
        return is_scalar( $value ) && '' !== trim( (string) $value ) ? trim( (string) $value ) : $fallback;
    }
    public function rich_text( $value ) {
        $value = is_scalar( $value ) ? trim( (string) $value ) : '';
        if ( '' === $value ) { return ''; }
        if ( preg_match( '/<(p|br|ul|ol|li|blockquote|h1|h2|h3|h4|h5|h6|div)\b/i', $value ) ) { return wp_kses_post( $value ); }
        return wp_kses_post( wpautop( $value ) );
    }

    public function shortcode_hero( $atts ) { $this->enqueue_assets(); return $this->render_hero( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_snapshot( $atts ) { $this->enqueue_assets(); return $this->render_snapshot( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_story( $atts ) { $this->enqueue_assets(); return $this->render_story( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_cluster( $atts ) { $this->enqueue_assets(); return $this->render_cluster( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_members( $atts ) { $this->enqueue_assets(); return $this->render_members( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_products( $atts ) { $this->enqueue_assets(); return $this->render_products( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_gallery( $atts ) { $this->enqueue_assets(); return $this->render_gallery( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_contact( $atts ) { $this->enqueue_assets(); return $this->render_contact( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_cta( $atts ) { $this->enqueue_assets(); return $this->render_cta( is_array( $atts ) ? $atts : array() ); }

    public function base_defaults() {
        return array(
            'show_section' => '1', 'shg_id' => '', 'shg_slug' => '', 'preview_shg_id' => '', 'auto_detect' => '1',
            'empty_message' => 'Select a preview SHG group, or open this page from an SHG archive card.',
        );
    }
    public function hero_defaults() { return wp_parse_args( array( 'label' => 'SHG Group', 'title' => '', 'description' => '', 'show_image' => '1', 'show_meta' => '1', 'show_breadcrumb' => '1', 'home_label' => 'Home', 'home_url' => '/', 'middle_label' => 'SHG Groups', 'middle_url' => '/shg-groups/', 'primary_text' => 'Explore Products', 'primary_url' => '/shop/', 'secondary_text' => 'Back to SHG Groups', 'secondary_url' => '/shg-groups/' ), $this->base_defaults() ); }
    public function snapshot_defaults() { return wp_parse_args( array( 'label' => 'Collective Snapshot', 'title' => 'Quick details', 'description' => 'Key details for this SHG group, its cluster, location, members and product linkages.', 'columns_desktop' => 4, 'columns_tablet' => 2, 'columns_mobile' => 2 ), $this->base_defaults() ); }
    public function story_defaults() { return wp_parse_args( array( 'label' => 'Collective Story', 'title' => 'The story behind this group', 'description' => 'A human layer behind the product origin.', 'show_products' => '1', 'max_tags' => 6 ), $this->base_defaults() ); }
    public function cluster_defaults() { return wp_parse_args( array( 'label' => 'Linked Cluster', 'title' => 'Source cluster connection', 'description' => 'This SHG group is connected to a larger Amaley source cluster.', 'button_text' => 'View Cluster Story', 'button_url' => '/cluster-detail/?cluster_slug={cluster_slug}', 'show_section_button' => '1', 'section_button_text' => 'View All Clusters', 'section_button_url' => '/cluster-archive-page/', 'description_words' => 18, 'max_tags' => 4, 'columns_desktop' => 4, 'columns_tablet' => 2, 'columns_mobile' => 1, 'card_template' => 'current_existing', 'show_card_media' => '1', 'show_card_label' => '1', 'show_card_title' => '1', 'show_card_description' => '1', 'show_card_meta' => '1', 'show_card_tags' => '1', 'show_card_button' => '1' ), $this->base_defaults() ); }
    public function related_defaults() { return wp_parse_args( array( 'label' => 'Connected Network', 'title' => 'Linked items', 'description' => 'Records connected to this SHG group.', 'limit' => 8, 'columns_desktop' => 4, 'columns_tablet' => 2, 'columns_mobile' => 1, 'description_words' => 14, 'max_tags' => 4, 'show_empty_state' => '1' ), $this->base_defaults() ); }
    public function member_defaults() { return wp_parse_args( array( 'label' => 'People Behind The Group', 'title' => 'Members and producers', 'description' => 'Producer members connected to this SHG group.', 'limit' => 4, 'columns_desktop' => 4, 'columns_tablet' => 2, 'columns_mobile' => 1, 'description_words' => 14, 'max_tags' => 3, 'show_empty_state' => '1', 'show_card_button' => '1', 'card_button_text' => 'View Producer Profile', 'show_section_button' => '1', 'section_button_text' => 'View All Producers', 'section_button_url' => '/producers/', 'enable_pagination' => '0', 'pagination_prev_text' => 'Previous', 'pagination_next_text' => 'Next', 'card_template' => 'current_existing', 'show_card_media' => '1', 'show_card_label' => '1', 'show_card_title' => '1', 'show_card_description' => '1', 'show_card_meta' => '1', 'show_card_tags' => '1' ), $this->base_defaults() ); }
    public function product_defaults() { return wp_parse_args( array( 'label' => 'Mapped Products', 'title' => 'Products linked to this collective', 'description' => 'WooCommerce products mapped to this SHG group through Amaley Origin Mapping.', 'limit' => 4, 'columns_desktop' => 4, 'columns_tablet' => 2, 'columns_mobile' => 1, 'description_words' => 14, 'max_tags' => 2, 'show_empty_state' => '1', 'show_card_button' => '1', 'card_button_text' => 'View Product', 'show_section_button' => '1', 'section_button_text' => 'View All Products', 'section_button_url' => '/shop/', 'enable_pagination' => '0', 'pagination_prev_text' => 'Previous', 'pagination_next_text' => 'Next', 'card_template' => 'current_existing', 'show_card_media' => '1', 'show_card_label' => '1', 'show_card_title' => '1', 'show_card_description' => '1', 'show_card_meta' => '1', 'show_card_tags' => '1' ), $this->base_defaults() ); }
    public function gallery_defaults() { return wp_parse_args( array( 'label' => 'Gallery', 'title' => 'Images from this collective', 'description' => 'Visual references from the group, producers, ingredients or processing work.', 'columns_desktop' => 3, 'columns_tablet' => 2, 'columns_mobile' => 1, 'show_section_button' => '0', 'section_button_text' => 'View Gallery', 'section_button_url' => '#' ), $this->base_defaults() ); }
    public function contact_defaults() { return wp_parse_args( array( 'label' => 'Source Support', 'title' => 'Need details about this collective?', 'description' => 'Contact Amaley for retail shelves, institutional gifting, hospitality counters or product storytelling connected to this group.', 'primary_text' => 'Contact Amaley', 'primary_url' => '/contact/', 'secondary_text' => 'Explore Products', 'secondary_url' => '/shop/' ), $this->base_defaults() ); }
    public function cta_defaults() { return wp_parse_args( array( 'label' => 'Work with Amaley', 'title' => 'Build product stories around verified producer groups.', 'description' => 'Use SHG visibility for conscious retail, hospitality counters, curated shelves and origin-led storytelling.', 'primary_text' => 'Explore Products', 'primary_url' => '/shop/', 'secondary_text' => 'Contact Amaley', 'secondary_url' => '/contact/' ), $this->base_defaults() ); }

    public function resolve_shg( $a = array() ) {
        $a = wp_parse_args( is_array( $a ) ? $a : array(), $this->base_defaults() );
        $id = absint( $a['shg_id'] );
        if ( ! $id ) { $id = absint( $a['preview_shg_id'] ); }
        if ( ! $id && $this->boolish( $a['auto_detect'] ) && isset( $_GET['shg_id'] ) ) { $id = absint( wp_unslash( $_GET['shg_id'] ) ); }
        $slug = $this->s( $a['shg_slug'] );
        if ( '' === $slug && $this->boolish( $a['auto_detect'] ) && isset( $_GET['shg_slug'] ) ) { $slug = sanitize_title( wp_unslash( $_GET['shg_slug'] ) ); }
        if ( $id ) { $post = get_post( $id ); return ( $post && 'amaley_shg_group' === $post->post_type ) ? $post : null; }
        if ( '' !== $slug ) { $post = get_page_by_path( $slug, OBJECT, 'amaley_shg_group' ); return $post ? $post : null; }

        // Elementor/editor preview fallback: the assigned SHG detail template is edited from a
        // normal WordPress page URL, so it does not naturally include shg_slug/shg_id. In that
        // preview/editing context, show the first available SHG group so the user can design the
        // template with real content instead of repeated empty-state boxes. Live frontend without
        // shg_slug/shg_id still remains empty-safe.
        if ( $this->is_preview_context() ) {
            return $this->first_preview_shg();
        }

        return null;
    }

    private function is_preview_context() {
        if ( is_admin() ) { return true; }

        $preview_keys = array( 'preview', 'preview_id', 'preview_nonce', 'elementor-preview' );
        foreach ( $preview_keys as $key ) {
            if ( isset( $_GET[ $key ] ) ) { return true; }
        }

        if ( class_exists( '\Elementor\Plugin' ) ) {
            try {
                $elementor = \Elementor\Plugin::$instance;
                if ( isset( $elementor->editor ) && method_exists( $elementor->editor, 'is_edit_mode' ) && $elementor->editor->is_edit_mode() ) { return true; }
                if ( isset( $elementor->preview ) && method_exists( $elementor->preview, 'is_preview_mode' ) && $elementor->preview->is_preview_mode() ) { return true; }
            } catch ( \Throwable $e ) {
                return false;
            }
        }

        return false;
    }

    private function first_preview_shg() {
        $posts = get_posts( array(
            'post_type'      => 'amaley_shg_group',
            'post_status'    => array( 'publish', 'private', 'draft' ),
            'posts_per_page' => 1,
            'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
            'order'          => 'ASC',
        ) );
        return ! empty( $posts ) ? $posts[0] : null;
    }

    private function should_render( $a ) { return $this->boolish( isset( $a['show_section'] ) ? $a['show_section'] : '1' ); }
    private function empty_state( $msg ) { return '<section class="amss-section amss-empty"><div class="amss-wrap"><p>' . esc_html( $msg ) . '</p></div></section>'; }
    private function meta( $id, $key ) { return get_post_meta( $id, $key, true ); }
    private function verification_label( $value ) { $labels = array( 'verified' => 'Verified', 'pending' => 'Pending', 'review' => 'Review' ); $key = sanitize_key( $value ); return isset( $labels[ $key ] ) ? $labels[ $key ] : ( $value ? ucwords( str_replace( array( '-', '_' ), ' ', $value ) ) : 'Pending' ); }
    private function initials( $title ) { $words = preg_split( '/\s+/', trim( wp_strip_all_tags( (string) $title ) ) ); $letters = ''; foreach ( $words as $w ) { if ( '' !== $w ) { $letters .= mb_substr( $w, 0, 1 ); } if ( mb_strlen( $letters ) >= 2 ) { break; } } return strtoupper( $letters ? $letters : 'SH' ); }
    private function split_terms( $text, $limit = 8 ) { $terms = preg_split( '/[\n,]+/', (string) $text ); return array_slice( array_values( array_filter( array_map( 'trim', $terms ) ) ), 0, max( 1, absint( $limit ) ) ); }
    private function ids_from_meta( $value ) { if ( empty( $value ) ) { return array(); } if ( is_array( $value ) ) { return array_values( array_filter( array_map( 'absint', $value ) ) ); } return array_values( array_filter( array_map( 'absint', explode( ',', (string) $value ) ) ) ); }
    private function image_for_post( $id, $meta_key = '' ) { $img = get_the_post_thumbnail_url( $id, 'large' ); if ( ! $img && $meta_key ) { $raw = $this->meta( $id, $meta_key ); $img = filter_var( $raw, FILTER_VALIDATE_URL ) ? $raw : ''; } return $img; }
    private function count_members_for_shg( $shg_id ) { $q = new WP_Query( array( 'post_type' => 'amaley_member', 'post_status' => array( 'publish' ), 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_amaley_member_shg_id', 'value' => absint( $shg_id ), 'compare' => '=' ) ) ) ); return absint( $q->found_posts ); }
    private function get_member_ids_for_shg( $shg_id ) {
        return get_posts( array(
            'post_type'      => 'amaley_member',
            'post_status'    => array( 'publish' ),
            'fields'         => 'ids',
            'posts_per_page' => 500,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'meta_query'     => array( array( 'key' => '_amaley_member_shg_id', 'value' => absint( $shg_id ), 'compare' => '=' ) ),
        ) );
    }

    private function get_members_for_shg( $shg_id, $limit, $offset = 0 ) {
        $ids = array_slice( array_map( 'absint', $this->get_member_ids_for_shg( $shg_id ) ), max( 0, absint( $offset ) ), max( 1, absint( $limit ) ) );
        if ( empty( $ids ) ) { return array(); }

        return get_posts( array(
            'post_type'      => 'amaley_member',
            'post_status'    => array( 'publish' ),
            'post__in'       => $ids,
            'posts_per_page' => count( $ids ),
            'orderby'        => 'post__in',
        ) );
    }

    private function get_product_ids_for_shg( $shg_id ) {
        $products = get_posts( array(
            'post_type'      => 'product',
            'post_status'    => array( 'publish', 'private' ),
            'fields'         => 'ids',
            'posts_per_page' => 500,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );

        $matched = array();
        foreach ( $products as $product_id ) {
            $meta_ids = array_merge(
                $this->ids_from_meta( get_post_meta( absint( $product_id ), '_amaley_origin_shg_ids', true ) ),
                $this->ids_from_meta( get_post_meta( absint( $product_id ), '_amaley_origin_shg_id', true ) ),
                $this->ids_from_meta( get_post_meta( absint( $product_id ), 'linked_shg_group', true ) ),
                $this->ids_from_meta( get_post_meta( absint( $product_id ), '_linked_shg_group', true ) )
            );

            if ( in_array( absint( $shg_id ), array_map( 'absint', $meta_ids ), true ) ) {
                $matched[] = absint( $product_id );
            }
        }

        return array_values( array_unique( array_filter( array_map( 'absint', $matched ) ) ) );
    }

    private function get_products_for_shg( $shg_id, $limit, $offset = 0 ) {
        $ids = array_slice( $this->get_product_ids_for_shg( $shg_id ), max( 0, absint( $offset ) ), max( 1, absint( $limit ) ) );
        if ( empty( $ids ) ) { return array(); }

        return get_posts( array(
            'post_type'      => 'product',
            'post_status'    => array( 'publish', 'private' ),
            'post__in'       => $ids,
            'posts_per_page' => count( $ids ),
            'orderby'        => 'post__in',
        ) );
    }
    private function gallery_urls( $id ) {
        $urls = array();
        $featured = get_the_post_thumbnail_url( $id, 'large' );
        if ( $featured ) { $urls[] = $featured; }
        $raw = get_post_meta( $id, '_amaley_gallery_urls', true );
        $raw = is_scalar( $raw ) ? (string) $raw : '';
        if ( '' !== trim( $raw ) ) {
            preg_match_all( "/https?:\/\/[^\s,\"'<>]+/i", $raw, $matches );
            if ( ! empty( $matches[0] ) ) {
                foreach ( $matches[0] as $url ) {
                    $url = rtrim( trim( $url ), '.,;)' );
                    if ( filter_var( $url, FILTER_VALIDATE_URL ) ) { $urls[] = $url; }
                }
            }
        }
        return array_values( array_unique( $urls ) );
    }
    private function section_head( $label, $title, $description = '' ) { return '<div class="amss-heading"><p class="amss-label">' . esc_html( $label ) . '</p><h2>' . esc_html( $title ) . '</h2>' . ( $description ? '<p class="amss-description">' . esc_html( $description ) . '</p>' : '' ) . '</div>'; }
    private function columns_style( $a ) { return '--amss-cols:' . max( 1, absint( isset( $a['columns_desktop'] ) ? $a['columns_desktop'] : 3 ) ) . ';--amss-cols-tablet:' . max( 1, absint( isset( $a['columns_tablet'] ) ? $a['columns_tablet'] : 2 ) ) . ';--amss-cols-mobile:' . max( 1, absint( isset( $a['columns_mobile'] ) ? $a['columns_mobile'] : 1 ) ) . ';'; }
    private function replace_placeholders( $url, $shg = null, $extra = array() ) {
        $url = $this->url_from_setting( $url, '#' );
        $pairs = array();
        if ( $shg && isset( $shg->ID ) ) {
            $pairs['{shg_id}']   = absint( $shg->ID );
            $pairs['{shg_slug}'] = $shg->post_name;
            $pairs['{slug}']     = $shg->post_name;
        }
        foreach ( $extra as $key => $value ) {
            $pairs[ '{' . sanitize_key( $key ) . '}' ] = is_scalar( $value ) ? (string) $value : '';
        }
        return strtr( $url, $pairs );
    }
    private function section_button( $a, $shg = null, $extra = array() ) {
        if ( ! $this->boolish( isset( $a['show_section_button'] ) ? $a['show_section_button'] : '0' ) ) { return ''; }
        $text = isset( $a['section_button_text'] ) && '' !== $this->s( $a['section_button_text'] ) ? $this->s( $a['section_button_text'] ) : 'View More';
        $url  = $this->replace_placeholders( isset( $a['section_button_url'] ) ? $a['section_button_url'] : '#', $shg, $extra );
        return '<div class="amss-section-actions"><a class="amss-section-button" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a></div>';
    }
    private function card_button_enabled( $a ) { return $this->boolish( isset( $a['show_card_button'] ) ? $a['show_card_button'] : '1' ); }


    public function render_hero( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->hero_defaults() ); if ( ! $this->should_render( $a ) ) { return ''; }
        $shg = $this->resolve_shg( $a ); if ( ! $shg ) { return $this->empty_state( $a['empty_message'] ); }
        $id = $shg->ID; $cluster_id = absint( $this->meta( $id, '_amaley_shg_cluster_id' ) ); $cluster_title = $cluster_id ? get_the_title( $cluster_id ) : 'Not linked'; $village = $this->meta( $id, '_amaley_village' ); $district = $this->meta( $id, '_amaley_district' ); $members = $this->meta( $id, '_amaley_member_count' ); if ( '' === (string) $members ) { $members = $this->count_members_for_shg( $id ); } $verification = $this->verification_label( $this->meta( $id, '_amaley_verification_status' ) ); $products = $this->get_products_for_shg( $id, 99 ); $title = $this->s( $a['title'] ) ? $a['title'] : get_the_title( $shg ); $desc = $this->s( $a['description'] ) ? $a['description'] : ( $this->meta( $id, '_amaley_short_story' ) ? $this->meta( $id, '_amaley_short_story' ) : 'A source-linked Amaley producer group connected to community-rooted products and transparent origin stories.' ); $image = $this->image_for_post( $id );
        $out = '<section class="amss-section amss-hero"><div class="amss-wrap"><div class="amss-hero-grid"><div class="amss-hero-copy">';
        if ( $this->boolish( $a['show_breadcrumb'] ) ) { $out .= '<nav class="amss-breadcrumb"><a href="' . esc_url( $this->url_from_setting( $a['home_url'], '/' ) ) . '">' . esc_html( $a['home_label'] ) . '</a><span>/</span><a href="' . esc_url( $this->url_from_setting( $a['middle_url'], '/shg-groups/' ) ) . '">' . esc_html( $a['middle_label'] ) . '</a><span>/</span><strong>' . esc_html( get_the_title( $shg ) ) . '</strong></nav>'; }
        $out .= '<p class="amss-label">' . esc_html( $a['label'] ) . '</p><h1 class="amss-title">' . esc_html( $title ) . '</h1><p class="amss-description">' . esc_html( wp_trim_words( wp_strip_all_tags( $desc ), 34 ) ) . '</p>';
        if ( $this->boolish( $a['show_meta'] ) ) { $out .= '<div class="amss-chip-row"><span class="amss-chip">' . esc_html( $cluster_title ) . '</span><span class="amss-chip">' . esc_html( trim( $village . ( $district ? ' · ' . $district : '' ) ) ) . '</span><span class="amss-chip">' . esc_html( $verification ) . '</span></div>'; }
        $out .= '<div class="amss-actions"><a class="amss-btn amss-btn-primary" href="' . esc_url( $this->url_from_setting( $a['primary_url'], '/shop/' ) ) . '">' . esc_html( $a['primary_text'] ) . '</a><a class="amss-btn amss-btn-secondary" href="' . esc_url( $this->url_from_setting( $a['secondary_url'], '/shg-groups/' ) ) . '">' . esc_html( $a['secondary_text'] ) . '</a></div></div>';
        $out .= '<div class="amss-hero-panel">';
        if ( $this->boolish( $a['show_image'] ) ) { $out .= '<div class="amss-image">' . ( $image ? '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title( $shg ) ) . '" loading="lazy" />' : '<span>' . esc_html( $this->initials( get_the_title( $shg ) ) ) . '</span>' ) . '</div>'; }
        $out .= '<div class="amss-snapshot-grid amss-hero-stats"><div class="amss-stat-card"><span class="amss-stat-label">Members</span><strong class="amss-stat-value">' . esc_html( $members ) . '</strong></div><div class="amss-stat-card"><span class="amss-stat-label">Products</span><strong class="amss-stat-value">' . esc_html( count( $products ) ) . '</strong></div><div class="amss-stat-card"><span class="amss-stat-label">Village</span><strong class="amss-stat-value">' . esc_html( $village ? $village : '—' ) . '</strong></div><div class="amss-stat-card"><span class="amss-stat-label">Status</span><strong class="amss-stat-value">' . esc_html( $verification ) . '</strong></div></div></div></div></div></section>';
        return $out;
    }

    public function render_snapshot( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->snapshot_defaults() ); if ( ! $this->should_render( $a ) ) { return ''; }
        $shg = $this->resolve_shg( $a ); if ( ! $shg ) { return $this->empty_state( $a['empty_message'] ); }
        $id = $shg->ID; $cluster_id = absint( $this->meta( $id, '_amaley_shg_cluster_id' ) ); $items = array(
            'Cluster' => $cluster_id ? get_the_title( $cluster_id ) : 'Not linked',
            'Village' => $this->meta( $id, '_amaley_village' ) ?: '—',
            'District' => $this->meta( $id, '_amaley_district' ) ?: '—',
            'Members' => $this->meta( $id, '_amaley_member_count' ) ?: $this->count_members_for_shg( $id ),
            'Verification' => $this->verification_label( $this->meta( $id, '_amaley_verification_status' ) ),
            'Contact' => $this->meta( $id, '_amaley_contact_person' ) ?: 'Amaley team',
            'SHG Code' => $this->meta( $id, '_amaley_shg_code' ) ?: '—',
            'Mapped Products' => count( $this->get_products_for_shg( $id, 99 ) ),
        );
        $out = '<section class="amss-section amss-snapshot"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] ) . '<div class="amss-snapshot-grid" style="' . esc_attr( $this->columns_style( $a ) ) . '">';
        foreach ( $items as $label => $value ) { $out .= '<div class="amss-stat-card"><span class="amss-stat-label">' . esc_html( $label ) . '</span><strong class="amss-stat-value">' . esc_html( $value ) . '</strong></div>'; }
        return $out . '</div></div></section>';
    }

    public function render_story( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->story_defaults() ); if ( ! $this->should_render( $a ) ) { return ''; }
        $shg = $this->resolve_shg( $a ); if ( ! $shg ) { return $this->empty_state( $a['empty_message'] ); }
        $id = $shg->ID; $story = $this->meta( $id, '_amaley_full_story' ); if ( '' === trim( (string) $story ) ) { $story = $this->meta( $id, '_amaley_short_story' ); } if ( '' === trim( (string) $story ) ) { $story = $shg->post_content; } $products = $this->split_terms( $this->meta( $id, '_amaley_product_categories' ), isset( $a['max_tags'] ) ? $a['max_tags'] : 6 );
        $out = '<section class="amss-section amss-story"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] ) . '<div class="amss-story-grid"><div class="amss-story-card"><div class="amss-rich-text">' . $this->rich_text( $story ? $story : 'Story content is not added yet.' ) . '</div></div><aside class="amss-side-card"><h3>Products handled</h3>';
        if ( ! empty( $products ) ) { $out .= '<div class="amss-chip-row">'; foreach ( $products as $term ) { $out .= '<span class="amss-chip">' . esc_html( $term ) . '</span>'; } $out .= '</div>'; } else { $out .= '<p class="amss-card-text">Product categories are not added yet.</p>'; }
        $out .= '</aside></div></div></section>'; return $out;
    }

    public function render_cluster( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->cluster_defaults() ); if ( ! $this->should_render( $a ) ) { return ''; }
        $shg = $this->resolve_shg( $a ); if ( ! $shg ) { return $this->empty_state( $a['empty_message'] ); }
        $cluster_id = absint( get_post_meta( $shg->ID, '_amaley_shg_cluster_id', true ) );
        if ( ! $cluster_id ) { return '<section class="amss-section amss-linked-cluster"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] ) . '<div class="amss-empty-card">No source cluster linked yet.</div></div></section>'; }
        $cluster = get_post( $cluster_id );
        if ( ! $cluster ) { return ''; }

        if ( 'og_card_1' === sanitize_key( isset( $a['card_template'] ) ? $a['card_template'] : 'current_existing' ) && class_exists( 'Amaley_Core_Card_Renderer' ) ) {
            $preset = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::get_assignment( 'card_template_cluster', 'og_cluster_card_1' ) : 'og_cluster_card_1';
            $raw_url = $this->url_from_setting( $a['button_url'], '/cluster-detail/?cluster_slug={cluster_slug}' );
            $url = $this->replace_placeholders( $raw_url, $shg, array( 'cluster_slug' => $cluster->post_name, 'cluster_id' => $cluster_id ) );
            $out = '<section class="amss-section amss-linked-cluster"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] );
            $out .= '<div class="amss-grid amss-linked-cluster-grid" style="' . esc_attr( $this->columns_style( $a ) ) . '">';
            $out .= Amaley_Core_Card_Renderer::render_cluster( $cluster_id, array(
                'preset' => $preset,
                'url' => $url,
                'button_text' => isset( $a['button_text'] ) ? $a['button_text'] : 'View Cluster Story',
                'show_image' => $this->boolish( $a['show_card_media'] ?? '1' ),
                'show_label' => $this->boolish( $a['show_card_label'] ?? '1' ),
                'show_title' => $this->boolish( $a['show_card_title'] ?? '1' ),
                'show_excerpt' => $this->boolish( $a['show_card_description'] ?? '1' ),
                'show_meta' => $this->boolish( $a['show_card_meta'] ?? '1' ),
                'show_tags' => $this->boolish( $a['show_card_tags'] ?? '1' ),
                'show_button' => $this->boolish( $a['show_card_button'] ?? '1' ),
                'excerpt_words' => isset( $a['description_words'] ) ? absint( $a['description_words'] ) : 18,
                'class' => 'amaley-card--shg-single-linked-cluster',
            ) );
            $out .= '</div>' . $this->section_button( $a, $shg, array( 'cluster_slug' => $cluster->post_name, 'cluster_id' => $cluster_id ) ) . '</div></section>';
            return $out;
        }

        $image      = $this->image_for_post( $cluster_id, '_amaley_cluster_image_url' );
        $intro      = get_post_meta( $cluster_id, '_amaley_cluster_intro', true );
        $region     = get_post_meta( $cluster_id, '_amaley_region', true );
        $district   = get_post_meta( $cluster_id, '_amaley_district', true );
        $products   = $this->split_terms( get_post_meta( $cluster_id, '_amaley_main_products', true ), isset( $a['max_tags'] ) ? $a['max_tags'] : 4 );
        $shg_count  = is_object( $GLOBALS['amaley_core_cluster_single_sections'] ?? null ) && method_exists( $GLOBALS['amaley_core_cluster_single_sections'], 'get_explicit_shg_ids_for_cluster' ) ? count( $GLOBALS['amaley_core_cluster_single_sections']->get_explicit_shg_ids_for_cluster( $cluster_id ) ) : 0;
        $url        = $this->replace_placeholders( $a['button_url'], $shg, array( 'cluster_slug' => $cluster->post_name, 'cluster_id' => $cluster_id ) );

        $out = '<section class="amss-section amss-linked-cluster"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] );
        $out .= '<div class="amss-grid amss-linked-cluster-grid" style="' . esc_attr( $this->columns_style( $a ) ) . '">';
        $out .= '<article class="amss-card amss-network-card amss-cluster-lock-card">';
        $out .= '<div class="amss-card-image">' . ( $image ? '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title( $cluster_id ) ) . '" loading="lazy" />' : '<span>' . esc_html( $this->initials( get_the_title( $cluster_id ) ) ) . '</span>' ) . '</div>';
        $out .= '<div class="amss-card-body"><span class="amss-card-label">Source Cluster</span><h3 class="amss-card-title">' . esc_html( get_the_title( $cluster_id ) ) . '</h3>';
        $out .= '<p class="amss-card-text amss-related-desc">' . esc_html( $intro ? wp_trim_words( wp_strip_all_tags( $intro ), absint( $a['description_words'] ) ) : 'Source cluster connected with this producer group.' ) . '</p>';
        $out .= '<dl class="amss-card-meta"><div><dt>Region</dt><dd>' . esc_html( $region ? $region : '—' ) . '</dd></div><div><dt>District</dt><dd>' . esc_html( $district ? $district : '—' ) . '</dd></div><div><dt>SHGs</dt><dd>' . esc_html( $shg_count ? $shg_count : '—' ) . '</dd></div><div><dt>Status</dt><dd>Linked</dd></div></dl>';
        if ( ! empty( $products ) ) { $out .= '<div class="amss-chip-row">'; foreach ( $products as $term ) { $out .= '<span class="amss-chip">' . esc_html( $term ) . '</span>'; } $out .= '</div>'; }
        if ( $this->s( $a['button_text'] ) ) { $out .= '<div class="amss-card-actions"><a class="amss-card-link" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ) . '</a></div>'; }
        $out .= '</div></article></div>' . $this->section_button( $a, $shg, array( 'cluster_slug' => $cluster->post_name, 'cluster_id' => $cluster_id ) ) . '</div></section>';
        return $out;
    }

    private function clean_related_copy( $a, $type ) {
        $generic_labels = array( '', 'Connected Network' );
        $generic_titles = array( '', 'Linked items' );
        $generic_descs  = array( '', 'Records connected to this SHG group.' );
        if ( 'members' === $type ) {
            if ( in_array( isset( $a['label'] ) ? $a['label'] : '', $generic_labels, true ) ) { $a['label'] = 'People Behind The Group'; }
            if ( in_array( isset( $a['title'] ) ? $a['title'] : '', $generic_titles, true ) ) { $a['title'] = 'Members and producers'; }
            if ( in_array( isset( $a['description'] ) ? $a['description'] : '', $generic_descs, true ) ) { $a['description'] = 'Producer members connected to this SHG group.'; }
        }
        if ( 'products' === $type ) {
            if ( in_array( isset( $a['label'] ) ? $a['label'] : '', $generic_labels, true ) ) { $a['label'] = 'Mapped Products'; }
            if ( in_array( isset( $a['title'] ) ? $a['title'] : '', $generic_titles, true ) ) { $a['title'] = 'Products linked to this collective'; }
            if ( in_array( isset( $a['description'] ) ? $a['description'] : '', $generic_descs, true ) ) { $a['description'] = 'WooCommerce products mapped to this SHG group through Amaley Origin Mapping.'; }
        }
        return $a;
    }

    private function shg_related_current_page( $type ) {
        $key = 'amss_' . sanitize_key( $type ) . '_page';
        return isset( $_GET[ $key ] ) ? max( 1, absint( wp_unslash( $_GET[ $key ] ) ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    }

    private function shg_pagination_data( $type, $total, $per_page, $current, $a ) {
        $total    = max( 0, absint( $total ) );
        $per_page = max( 1, absint( $per_page ) );
        $pages    = (int) ceil( $total / $per_page );

        if ( $pages <= 1 ) { return array(); }

        return array(
            'type'      => sanitize_key( $type ),
            'key'       => 'amss_' . sanitize_key( $type ) . '_page',
            'current'   => max( 1, min( absint( $current ), $pages ) ),
            'pages'     => $pages,
            'prev_text' => ! empty( $a['pagination_prev_text'] ) ? (string) $a['pagination_prev_text'] : 'Previous',
            'next_text' => ! empty( $a['pagination_next_text'] ) ? (string) $a['pagination_next_text'] : 'Next',
        );
    }

    private function render_shg_pagination( $p ) {
        if ( empty( $p ) || empty( $p['pages'] ) || absint( $p['pages'] ) <= 1 ) { return ''; }

        $type    = sanitize_key( $p['type'] );
        $key     = sanitize_key( $p['key'] );
        $current = max( 1, absint( $p['current'] ) );
        $pages   = max( 1, absint( $p['pages'] ) );
        $anchor  = 'amss-related-' . $type;

        $out = '<nav class="amss-pagination amss-pagination-' . esc_attr( $type ) . '" aria-label="' . esc_attr__( 'SHG related cards pagination', 'amaley-core' ) . '">';

        if ( $current > 1 ) {
            $out .= '<a class="amss-page-link amss-page-prev" data-amss-page="' . esc_attr( $current - 1 ) . '" href="' . esc_url( $this->shg_pagination_url( $key, $current - 1, $anchor ) ) . '">' . esc_html( $p['prev_text'] ) . '</a>';
        }

        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $i === $current ) {
                $out .= '<span class="amss-page-link amss-page-current" aria-current="page">' . esc_html( (string) $i ) . '</span>';
            } else {
                $out .= '<a class="amss-page-link" data-amss-page="' . esc_attr( $i ) . '" href="' . esc_url( $this->shg_pagination_url( $key, $i, $anchor ) ) . '">' . esc_html( (string) $i ) . '</a>';
            }
        }

        if ( $current < $pages ) {
            $out .= '<a class="amss-page-link amss-page-next" data-amss-page="' . esc_attr( $current + 1 ) . '" href="' . esc_url( $this->shg_pagination_url( $key, $current + 1, $anchor ) ) . '">' . esc_html( $p['next_text'] ) . '</a>';
        }

        $out .= '</nav>';
        return $out;
    }

    private function shg_pagination_url( $key, $page, $anchor ) {
        return add_query_arg( sanitize_key( $key ), max( 1, absint( $page ) ) ) . '#' . sanitize_key( $anchor );
    }

    private function shg_ajax_settings( $a ) {
        $allowed = array(
            'limit',
            'columns_desktop',
            'columns_tablet',
            'columns_mobile',
            'description_words',
            'max_tags',
            'show_empty_state',
            'enable_pagination',
            'pagination_prev_text',
            'pagination_next_text',
            'card_template',
            'show_card_media',
            'show_card_label',
            'show_card_title',
            'show_card_description',
            'show_card_meta',
            'show_card_tags',
            'show_card_button',
            'card_button_text',
        );

        $out = array();
        foreach ( $allowed as $key ) {
            if ( isset( $a[ $key ] ) ) {
                $out[ $key ] = is_scalar( $a[ $key ] ) ? (string) $a[ $key ] : '';
            }
        }
        return $out;
    }

    private function render_shg_member_card_for_pagination( $member, $a ) {
        if ( 'og_card_1' === sanitize_key( isset( $a['card_template'] ) ? $a['card_template'] : 'current_existing' ) && class_exists( 'Amaley_Core_Card_Renderer' ) ) {
            $preset = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::get_assignment( 'card_template_member', 'og_member_card_1' ) : 'og_member_card_1';
            return Amaley_Core_Card_Renderer::render_member( $member->ID, array(
                'preset'        => $preset,
                'url'           => get_permalink( $member ),
                'button_text'   => isset( $a['card_button_text'] ) ? $a['card_button_text'] : 'View Producer Profile',
                'show_image'    => $this->boolish( $a['show_card_media'] ?? '1' ),
                'show_label'    => $this->boolish( $a['show_card_label'] ?? '1' ),
                'show_title'    => $this->boolish( $a['show_card_title'] ?? '1' ),
                'show_excerpt'  => $this->boolish( $a['show_card_description'] ?? '1' ),
                'show_meta'     => $this->boolish( $a['show_card_meta'] ?? '1' ),
                'show_tags'     => $this->boolish( $a['show_card_tags'] ?? '1' ),
                'show_button'   => $this->boolish( $a['show_card_button'] ?? '1' ),
                'excerpt_words' => isset( $a['description_words'] ) ? absint( $a['description_words'] ) : 14,
                'class'         => 'amaley-card--shg-single-member',
            ) );
        }

        $role    = get_post_meta( $member->ID, '_amaley_role', true );
        $bio     = get_post_meta( $member->ID, '_amaley_short_bio', true );
        $img     = $this->image_for_post( $member->ID, '_amaley_photo_url' );
        $village = get_post_meta( $member->ID, '_amaley_village', true );
        $skill   = get_post_meta( $member->ID, '_amaley_skill', true );

        $out = '<article class="amss-card amss-network-card amss-member-card"><div class="amss-card-image">' . ( $img ? '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( get_the_title( $member ) ) . '" loading="lazy" />' : '<span>' . esc_html( $this->initials( get_the_title( $member ) ) ) . '</span>' ) . '</div>';
        $out .= '<div class="amss-card-body"><span class="amss-card-label">Producer</span><h3 class="amss-card-title">' . esc_html( get_the_title( $member ) ) . '</h3>';
        $out .= '<p class="amss-card-text amss-related-desc">' . esc_html( $bio ? wp_trim_words( wp_strip_all_tags( $bio ), absint( $a['description_words'] ) ) : 'Linked producer member.' ) . '</p>';
        $out .= '<dl class="amss-card-meta"><div><dt>Role</dt><dd>' . esc_html( $role ? $role : 'Producer' ) . '</dd></div><div><dt>Village</dt><dd>' . esc_html( $village ? $village : '—' ) . '</dd></div></dl>';
        if ( $skill ) { $out .= '<div class="amss-chip-row"><span class="amss-chip">' . esc_html( $skill ) . '</span></div>'; }
        if ( $this->card_button_enabled( $a ) ) { $out .= '<div class="amss-card-actions"><a class="amss-card-link amss-card-link-muted" href="' . esc_url( get_permalink( $member ) ) . '">' . esc_html( isset( $a['card_button_text'] ) ? $a['card_button_text'] : 'View Producer Profile' ) . '</a></div>'; }
        $out .= '</div></article>';

        return $out;
    }

    private function render_shg_product_card_for_pagination( $product_post, $a ) {
        if ( 'og_card_1' === sanitize_key( isset( $a['card_template'] ) ? $a['card_template'] : 'current_existing' ) && class_exists( 'Amaley_Core_Card_Renderer' ) ) {
            $preset = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::get_assignment( 'card_template_product', 'og_product_card_1' ) : 'og_product_card_1';
            return Amaley_Core_Card_Renderer::render_product( $product_post->ID, array(
                'preset'        => $preset,
                'url'           => get_permalink( $product_post ),
                'button_text'   => isset( $a['card_button_text'] ) ? $a['card_button_text'] : 'View Product',
                'show_image'    => $this->boolish( $a['show_card_media'] ?? '1' ),
                'show_label'    => $this->boolish( $a['show_card_label'] ?? '1' ),
                'show_title'    => $this->boolish( $a['show_card_title'] ?? '1' ),
                'show_excerpt'  => $this->boolish( $a['show_card_description'] ?? '1' ),
                'show_meta'     => $this->boolish( $a['show_card_meta'] ?? '1' ),
                'show_tags'     => $this->boolish( $a['show_card_tags'] ?? '1' ),
                'show_button'   => $this->boolish( $a['show_card_button'] ?? '1' ),
                'excerpt_words' => isset( $a['description_words'] ) ? absint( $a['description_words'] ) : 14,
                'class'         => 'amaley-card--shg-single-product',
            ) );
        }

        $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_post->ID ) : null;
        $img = get_the_post_thumbnail_url( $product_post->ID, 'large' );
        $price = ( $product && function_exists( 'wc_price' ) ) ? wc_price( $product->get_price() ) : '';
        $excerpt = $product_post->post_excerpt ? $product_post->post_excerpt : $product_post->post_content;
        $origin = get_post_meta( $product_post->ID, '_amaley_origin_note', true );
        $origin_text = $origin ? wp_trim_words( wp_strip_all_tags( $origin ), 5 ) : 'Mapped to this group';

        $out = '<article class="amss-product-card amss-final-product-card"><a class="amss-product-image" href="' . esc_url( get_permalink( $product_post ) ) . '">' . ( $img ? '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( get_the_title( $product_post ) ) . '" loading="lazy" />' : '<span>' . esc_html( $this->initials( get_the_title( $product_post ) ) ) . '</span>' ) . '</a>';
        $out .= '<div class="amss-product-body"><span class="amss-card-label">Product</span><h3 class="amss-card-title">' . esc_html( get_the_title( $product_post ) ) . '</h3>';
        $out .= '<p class="amss-card-text">' . esc_html( wp_trim_words( wp_strip_all_tags( $excerpt ), absint( $a['description_words'] ) ) ) . '</p>';
        $out .= '<div class="amss-product-meta"><div><span>Price</span><strong>' . wp_kses_post( $price ? $price : '—' ) . '</strong></div><div><span>Origin</span><strong>' . esc_html( $origin_text ) . '</strong></div></div>';
        $out .= '<div class="amss-chip-row"><span class="amss-chip">Traceable</span><span class="amss-chip">Origin linked</span></div>';
        if ( $this->card_button_enabled( $a ) ) { $out .= '<div class="amss-card-actions amss-product-actions"><a class="amss-product-button" href="' . esc_url( get_permalink( $product_post ) ) . '">' . esc_html( isset( $a['card_button_text'] ) ? $a['card_button_text'] : 'View Product' ) . '</a></div>'; }
        $out .= '</div></article>';

        return $out;
    }

    private function render_shg_members_grid_inner( $a, $members ) {
        $out = '';
        if ( empty( $members ) ) {
            $out .= '<div class="amss-empty-card">No members are linked yet.</div>';
        } else {
            $out .= '<div class="amss-grid" style="' . esc_attr( $this->columns_style( $a ) ) . '">';
            foreach ( $members as $member ) {
                $out .= $this->render_shg_member_card_for_pagination( $member, $a );
            }
            $out .= '</div>';
        }
        $out .= $this->render_shg_pagination( isset( $a['_pagination'] ) ? $a['_pagination'] : array() );
        return $out;
    }

    private function render_shg_products_grid_inner( $a, $products ) {
        $out = '';
        if ( empty( $products ) ) {
            $out .= '<div class="amss-empty-card">No mapped products found yet.</div>';
        } else {
            $out .= '<div class="amss-grid amss-product-grid" style="' . esc_attr( $this->columns_style( $a ) ) . '">';
            foreach ( $products as $product_post ) {
                $out .= $this->render_shg_product_card_for_pagination( $product_post, $a );
            }
            $out .= '</div>';
        }
        $out .= $this->render_shg_pagination( isset( $a['_pagination'] ) ? $a['_pagination'] : array() );
        return $out;
    }

    public function ajax_shg_single_pagination() {
        if ( ! check_ajax_referer( 'amaley_shg_single_pagination', 'nonce', false ) ) {
            wp_send_json_error( array( 'message' => 'Invalid pagination request.' ), 403 );
        }

        $type = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
        $shg_id = isset( $_POST['shg_id'] ) ? absint( wp_unslash( $_POST['shg_id'] ) ) : 0;
        $page = isset( $_POST['page'] ) ? max( 1, absint( wp_unslash( $_POST['page'] ) ) ) : 1;
        $settings_json = isset( $_POST['settings'] ) ? wp_unslash( $_POST['settings'] ) : '{}';
        $settings = json_decode( (string) $settings_json, true );
        if ( ! is_array( $settings ) ) { $settings = array(); }

        if ( ! $shg_id || ! in_array( $type, array( 'members', 'products' ), true ) ) {
            wp_send_json_error( array( 'message' => 'Missing pagination data.' ), 400 );
        }

        $a = 'members' === $type ? $this->clean_related_copy( wp_parse_args( $settings, $this->member_defaults() ), 'members' ) : $this->clean_related_copy( wp_parse_args( $settings, $this->product_defaults() ), 'products' );
        $limit = max( 1, absint( isset( $a['limit'] ) ? $a['limit'] : 4 ) );
        $offset = ( $page - 1 ) * $limit;

        if ( 'members' === $type ) {
            $total = count( $this->get_member_ids_for_shg( $shg_id ) );
            $items = $this->get_members_for_shg( $shg_id, $limit, $offset );
            $a['_pagination'] = $this->shg_pagination_data( 'members', $total, $limit, $page, $a );
            wp_send_json_success( array( 'html' => $this->render_shg_members_grid_inner( $a, $items ) ) );
        }

        $total = count( $this->get_product_ids_for_shg( $shg_id ) );
        $items = $this->get_products_for_shg( $shg_id, $limit, $offset );
        $a['_pagination'] = $this->shg_pagination_data( 'products', $total, $limit, $page, $a );
        wp_send_json_success( array( 'html' => $this->render_shg_products_grid_inner( $a, $items ) ) );
    }

    public function render_members( $atts = array() ) {
        $a = $this->clean_related_copy( wp_parse_args( $atts, $this->member_defaults() ), 'members' ); if ( ! $this->should_render( $a ) ) { return ''; }
        $shg = $this->resolve_shg( $a ); if ( ! $shg ) { return $this->empty_state( $a['empty_message'] ); }

        $limit = max( 1, absint( isset( $a['limit'] ) ? $a['limit'] : 4 ) );
        $page = $this->shg_related_current_page( 'members' );
        $offset = 0;

        if ( $this->boolish( isset( $a['enable_pagination'] ) ? $a['enable_pagination'] : '0' ) ) {
            $offset = ( $page - 1 ) * $limit;
            $a['_pagination'] = $this->shg_pagination_data( 'members', count( $this->get_member_ids_for_shg( $shg->ID ) ), $limit, $page, $a );
        }

        $members = $this->get_members_for_shg( $shg->ID, $limit, $offset );
        $out = '<section id="amss-related-members" class="amss-section amss-members" data-amss-related-section="1" data-amss-type="members" data-amss-shg-id="' . esc_attr( absint( $shg->ID ) ) . '" data-amss-ajax-url="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" data-amss-nonce="' . esc_attr( wp_create_nonce( 'amaley_shg_single_pagination' ) ) . '" data-amss-settings="' . esc_attr( wp_json_encode( $this->shg_ajax_settings( $a ) ) ) . '"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] );
        $out .= '<div class="amss-related-results" data-amss-results="1">' . $this->render_shg_members_grid_inner( $a, $members ) . '</div>';
        return $out . $this->section_button( $a, $shg ) . '</div></section>';
    }

    public function render_products( $atts = array() ) {
        $a = $this->clean_related_copy( wp_parse_args( $atts, $this->product_defaults() ), 'products' ); if ( ! $this->should_render( $a ) ) { return ''; }
        $shg = $this->resolve_shg( $a ); if ( ! $shg ) { return $this->empty_state( $a['empty_message'] ); }

        $limit = max( 1, absint( isset( $a['limit'] ) ? $a['limit'] : 4 ) );
        $page = $this->shg_related_current_page( 'products' );
        $offset = 0;

        if ( $this->boolish( isset( $a['enable_pagination'] ) ? $a['enable_pagination'] : '0' ) ) {
            $offset = ( $page - 1 ) * $limit;
            $a['_pagination'] = $this->shg_pagination_data( 'products', count( $this->get_product_ids_for_shg( $shg->ID ) ), $limit, $page, $a );
        }

        $products = $this->get_products_for_shg( $shg->ID, $limit, $offset );
        $out = '<section id="amss-related-products" class="amss-section amss-products" data-amss-related-section="1" data-amss-type="products" data-amss-shg-id="' . esc_attr( absint( $shg->ID ) ) . '" data-amss-ajax-url="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" data-amss-nonce="' . esc_attr( wp_create_nonce( 'amaley_shg_single_pagination' ) ) . '" data-amss-settings="' . esc_attr( wp_json_encode( $this->shg_ajax_settings( $a ) ) ) . '"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] );
        $out .= '<div class="amss-related-results" data-amss-results="1">' . $this->render_shg_products_grid_inner( $a, $products ) . '</div>';
        return $out . $this->section_button( $a, $shg ) . '</div></section>';
    }

    public function render_gallery( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->gallery_defaults() ); if ( ! $this->should_render( $a ) ) { return ''; }
        $shg = $this->resolve_shg( $a ); if ( ! $shg ) { return $this->empty_state( $a['empty_message'] ); }
        $urls = $this->gallery_urls( $shg->ID );
        $out = '<section class="amss-section amss-gallery"><div class="amss-wrap">' . $this->section_head( $a['label'], $a['title'], $a['description'] );
        if ( empty( $urls ) ) { return $out . '<div class="amss-empty-card">Gallery images are not added yet.</div></div></section>'; }
        $out .= '<div class="amss-gallery-grid" style="' . esc_attr( $this->columns_style( $a ) ) . '">';
        foreach ( $urls as $index => $url ) {
            $out .= '<figure class="amss-gallery-item"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( get_the_title( $shg ) ) . '" loading="lazy" /><figcaption><span>Collective Visual</span><strong>' . esc_html( get_the_title( $shg ) ) . '</strong></figcaption></figure>';
        }
        return $out . '</div>' . $this->section_button( $a, $shg ) . '</div></section>';
    }

    public function render_contact( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->contact_defaults() ); if ( ! $this->should_render( $a ) ) { return ''; }
        return '<section class="amss-section amss-contact"><div class="amss-wrap"><div class="amss-cta-inner"><div><p class="amss-label">' . esc_html( $a['label'] ) . '</p><h2 class="amss-title">' . esc_html( $a['title'] ) . '</h2><p class="amss-description">' . esc_html( $a['description'] ) . '</p></div><div class="amss-actions"><a class="amss-btn amss-btn-primary" href="' . esc_url( $this->url_from_setting( $a['primary_url'], '/contact/' ) ) . '">' . esc_html( $a['primary_text'] ) . '</a><a class="amss-btn amss-btn-secondary" href="' . esc_url( $this->url_from_setting( $a['secondary_url'], '/shop/' ) ) . '">' . esc_html( $a['secondary_text'] ) . '</a></div></div></div></section>';
    }
    public function render_cta( $atts = array() ) { return $this->render_contact( wp_parse_args( $atts, $this->cta_defaults() ) ); }
}
