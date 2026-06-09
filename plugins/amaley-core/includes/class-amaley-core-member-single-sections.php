<?php
/**
 * Member / Producer Single section widgets renderer.
 *
 * v1.0.77: Clean Member Single normal build from the accepted v1.0.76.5 baseline.
 * v1.0.78: Member Single visual rhythm polish.
 * v1.0.78.1: Safe section-polish pass for Member Single only.
 * v1.0.78.3: Restore Producer Story to single-card rhythm; no SHG/Cluster structure changes.
 * v1.0.78.5: Safe rollback package from v1.0.78.3 to override the rejected v1.0.78.4 linked-section styling.
 * v1.0.78.6: Convert Linked SHG / Cluster sections from side-by-side split to top-heading + card-grid layout.
 * v1.0.78.7: Controls-only pass: section-wise Elementor controls with safe show/hide hooks for existing elements.
 * v1.0.78.8: Controls-only completion for inner card/stat/meta boxes: margin, padding, radius, gap and responsive controls.
 * v1.0.78.9: Product card price inline fix so currency and amount do not break into separate lines.
 * v1.0.78.10: Member Single product cards aligned with accepted compact product-card consistency.
 * v1.0.80: Optional pilot bridge from Member Single Products to Amaley Core Product Card Renderer.
 * v1.0.92.1: Adds safe Member Single OG Card 1 selectors for Linked SHG, Linked Cluster and Products.
 * v1.0.92.2: Maps Member Single Elementor style controls to OG card classes and adds transform controls.
 * v1.0.92.3: Performance-safe editor controls by conditionally loading OG fine controls only for OG Card 1.
 * v1.0.92.4: Adds complete Member Single OG Card 1 controls aligned with Cluster Single controls.
 * v1.0.96: Adds safe AJAX/no-reload pagination for Member Single Products section.
 * Scope: Member Single only. No Member Archive, SHG, Cluster, WooCommerce checkout, header/footer changes.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Member_Single_Sections {
    /** Prevent duplicate Elementor widget registration. */
    private $elementor_widgets_registered = false;

    /** Constructor. */
    public function __construct() {
        $GLOBALS['amaley_core_member_single_sections'] = $this;

        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );

        add_action( 'wp_ajax_amaley_member_single_products_pagination', array( $this, 'ajax_member_products_pagination' ) );
        add_action( 'wp_ajax_nopriv_amaley_member_single_products_pagination', array( $this, 'ajax_member_products_pagination' ) );

        add_shortcode( 'amaley_member_single_hero', array( $this, 'shortcode_hero' ) );
        add_shortcode( 'amaley_member_single_snapshot', array( $this, 'shortcode_snapshot' ) );
        add_shortcode( 'amaley_member_single_story', array( $this, 'shortcode_story' ) );
        add_shortcode( 'amaley_member_single_shg', array( $this, 'shortcode_shg' ) );
        add_shortcode( 'amaley_member_single_cluster', array( $this, 'shortcode_cluster' ) );
        add_shortcode( 'amaley_member_single_products', array( $this, 'shortcode_products' ) );
        add_shortcode( 'amaley_member_single_gallery', array( $this, 'shortcode_gallery' ) );
        add_shortcode( 'amaley_member_single_contact', array( $this, 'shortcode_contact' ) );

        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );
    }

    /** Register stylesheet. */
    public function register_assets() {
        wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        wp_register_style( 'amaley-core-member-single-sections', AMALEY_CORE_URL . 'assets/amaley-core-member-single-sections.css', array( 'amaley-core-cards' ), AMALEY_CORE_VERSION );
        wp_register_script( 'amaley-core-member-products-pagination', AMALEY_CORE_URL . 'assets/amaley-core-member-products-pagination.js', array(), AMALEY_CORE_VERSION, true );
    }

    /** Enqueue stylesheet. */
    public function enqueue_assets() {
        if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        }
        wp_enqueue_style( 'amaley-core-cards' );
        wp_enqueue_style( 'amaley-core-member-single-sections' );

        if ( $this->should_load_member_products_pagination_script() ) {
            if ( ! wp_script_is( 'amaley-core-member-products-pagination', 'registered' ) ) {
                wp_register_script( 'amaley-core-member-products-pagination', AMALEY_CORE_URL . 'assets/amaley-core-member-products-pagination.js', array(), AMALEY_CORE_VERSION, true );
            }
            wp_enqueue_script( 'amaley-core-member-products-pagination' );
        }
    }

    private function should_load_member_products_pagination_script() {
        if ( is_admin() ) {
            return false;
        }

        /*
         * Keep frontend pagination JavaScript out of Elementor editor and preview iframe.
         * Elementor preview is a frontend-like request, so is_admin() is not enough.
         */
        if ( isset( $_GET['action'] ) && 'elementor' === sanitize_key( wp_unslash( $_GET['action'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            return false;
        }
        if ( isset( $_GET['elementor-preview'] ) || isset( $_GET['preview_id'] ) || isset( $_GET['preview_nonce'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            return false;
        }

        if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) ) {
            $elementor = \Elementor\Plugin::$instance;
            if ( isset( $elementor->editor ) && method_exists( $elementor->editor, 'is_edit_mode' ) && $elementor->editor->is_edit_mode() ) {
                return false;
            }
            if ( isset( $elementor->preview ) && method_exists( $elementor->preview, 'is_preview_mode' ) && $elementor->preview->is_preview_mode() ) {
                return false;
            }
        }

        return true;
    }

    /** Register Elementor category. */
    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    /** Register Elementor widgets. */
    public function register_elementor_widgets( $widgets_manager = null ) {
        if ( $this->elementor_widgets_registered ) {
            return;
        }

        if ( null === $widgets_manager && class_exists( '\\Elementor\\Plugin' ) && isset( \Elementor\Plugin::$instance->widgets_manager ) ) {
            $widgets_manager = \Elementor\Plugin::$instance->widgets_manager;
        }

        if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
            return;
        }

        $files = array(
            'class-amaley-core-member-single-hero-widget.php',
            'class-amaley-core-member-single-snapshot-widget.php',
            'class-amaley-core-member-single-story-widget.php',
            'class-amaley-core-member-single-shg-widget.php',
            'class-amaley-core-member-single-cluster-widget.php',
            'class-amaley-core-member-single-products-widget.php',
            'class-amaley-core-member-single-gallery-widget.php',
            'class-amaley-core-member-single-contact-widget.php',
        );

        foreach ( $files as $file_name ) {
            $file = AMALEY_CORE_PATH . 'includes/widgets/' . $file_name;
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }

        $widgets = array(
            'Amaley_Core_Member_Single_Hero_Widget',
            'Amaley_Core_Member_Single_Snapshot_Widget',
            'Amaley_Core_Member_Single_Story_Widget',
            'Amaley_Core_Member_Single_SHG_Widget',
            'Amaley_Core_Member_Single_Cluster_Widget',
            'Amaley_Core_Member_Single_Products_Widget',
            'Amaley_Core_Member_Single_Gallery_Widget',
            'Amaley_Core_Member_Single_Contact_Widget',
        );

        foreach ( $widgets as $class_name ) {
            if ( class_exists( $class_name ) && method_exists( $widgets_manager, 'register' ) ) {
                $widgets_manager->register( new $class_name() );
            }
        }

        $this->elementor_widgets_registered = true;
    }

    /** Boolean helper. */
    public function boolish( $value ) {
        return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true );
    }

    /** Normalize settings. */
    private function normalize( $atts, $defaults ) {
        return wp_parse_args( is_array( $atts ) ? $atts : array(), $defaults );
    }

    /** Rich text helper. */
    private function rich_text( $value ) {
        $value = is_scalar( $value ) ? trim( (string) $value ) : '';
        if ( '' === $value ) { return ''; }
        if ( preg_match( '/<(p|br|ul|ol|li|blockquote|h1|h2|h3|h4|h5|h6|div)\b/i', $value ) ) { return wp_kses_post( $value ); }
        return wp_kses_post( wpautop( $value ) );
    }

    /** URL setting helper. */
    private function url_from_setting( $value, $fallback = '#' ) {
        if ( is_array( $value ) && isset( $value['url'] ) ) { return $value['url'] ? $value['url'] : $fallback; }
        return is_scalar( $value ) && '' !== trim( (string) $value ) ? trim( (string) $value ) : $fallback;
    }

    /** Shortcodes. */
    public function shortcode_hero( $atts ) { $this->enqueue_assets(); return $this->render_hero( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_snapshot( $atts ) { $this->enqueue_assets(); return $this->render_snapshot( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_story( $atts ) { $this->enqueue_assets(); return $this->render_story( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_shg( $atts ) { $this->enqueue_assets(); return $this->render_shg( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_cluster( $atts ) { $this->enqueue_assets(); return $this->render_cluster( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_products( $atts ) { $this->enqueue_assets(); return $this->render_products( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_gallery( $atts ) { $this->enqueue_assets(); return $this->render_gallery( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_contact( $atts ) { $this->enqueue_assets(); return $this->render_contact( is_array( $atts ) ? $atts : array() ); }

    /** Base defaults. */
    public function base_defaults() {
        return array(
            'show_section' => '1',
            'member_id' => '',
            'member_slug' => '',
            'preview_member_id' => '',
            'auto_detect' => '1',
            'empty_message' => 'Select a preview member / producer, or open this page from a member archive card.',
        );
    }

    public function hero_defaults() {
        return wp_parse_args( array(
            'breadcrumb' => 'Home / Producers',
            'label' => 'Producer Profile',
            'title' => '',
            'description' => '',
            'show_image' => '1',
            'show_breadcrumb' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_buttons' => '1',
            'show_pills' => '1',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'Back to Producers',
            'secondary_url' => '/producers/',
        ), $this->base_defaults() );
    }

    public function snapshot_defaults() {
        return wp_parse_args( array(
            'label' => 'Producer Snapshot',
            'title' => 'Quick details',
            'description' => 'Key information about this producer, their SHG group, village role and linked origin story.',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_mobile' => '2',
            'show_role_stat' => '1',
            'show_village_stat' => '1',
            'show_shg_stat' => '1',
            'show_cluster_stat' => '1',
        ), $this->base_defaults() );
    }

    public function story_defaults() {
        return wp_parse_args( array(
            'label' => 'Producer Story',
            'title' => 'The person behind the work',
            'description' => 'A human layer behind the product origin.',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_skills' => '1',
            'show_products' => '1',
            'max_tags' => '8',
        ), $this->base_defaults() );
    }

    public function shg_defaults() {
        return wp_parse_args( array(
            'label' => 'Linked SHG Group',
            'title' => 'The collective connected with this producer',
            'description' => 'This section shows the SHG / producer group linked with this member record.',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_button' => '1',
            'show_card_media' => '1',
            'show_card_badge' => '1',
            'show_card_label' => '1',
            'show_card_excerpt' => '1',
            'show_card_meta' => '1',
            'show_card_tags' => '1',
            'show_card_title' => '1',
            'card_template' => 'current_existing',
            'button_text' => 'View Collective Details',
            'detail_url_pattern' => '/shg-detail/?shg_slug={slug}',
        ), $this->base_defaults() );
    }

    public function cluster_defaults() {
        return wp_parse_args( array(
            'label' => 'Linked Cluster',
            'title' => 'The source cluster behind this profile',
            'description' => 'This section resolves the cluster through the linked SHG group.',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_button' => '1',
            'show_card_media' => '1',
            'show_card_label' => '1',
            'show_card_excerpt' => '1',
            'show_card_meta' => '1',
            'show_card_tags' => '1',
            'show_card_title' => '1',
            'card_template' => 'current_existing',
            'button_text' => 'View Cluster Story',
            'detail_url_pattern' => '/cluster-detail/?cluster_slug={slug}',
        ), $this->base_defaults() );
    }

    public function products_defaults() {
        return wp_parse_args( array(
            'label' => 'Products & Skills',
            'title' => 'Products connected with this producer',
            'description' => 'Mapped products are shown first. If no mapped WooCommerce product exists, the producer profile product list is shown as a clean fallback.',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'card_template' => 'og_card_1',
            'product_card_source' => 'global_assignment',
            'product_card_manual_preset' => 'compact_marketplace',
            'show_product_image' => '1',
            'show_product_label' => '1',
            'product_label_text' => 'Product',
            'show_product_excerpt' => '1',
            'product_excerpt_words' => '16',
            'show_product_meta' => '1',
            'show_product_chips' => '1',
            'show_product_button' => '1',
            'show_fallback_tags' => '1',
            'limit' => '4',
            'enable_pagination' => '0',
            'pagination_prev_text' => 'Previous',
            'pagination_next_text' => 'Next',
            'show_section_button' => '1',
            'section_button_text' => 'View All Products',
            'section_button_url' => '/shop/',
        ), $this->base_defaults() );
    }

    public function gallery_defaults() {
        return wp_parse_args( array(
            'label' => 'Producer Gallery',
            'title' => 'Visual story from this profile',
            'description' => 'Images uploaded in the member / producer record gallery.',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_caption' => '1',
            'max_images' => '6',
            'columns_desktop' => '3',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
        ), $this->base_defaults() );
    }

    public function contact_defaults() {
        return wp_parse_args( array(
            'label' => 'Work with Amaley',
            'title' => 'Build origin-led product stories with verified producers.',
            'description' => 'Use this producer profile as part of product traceability, gifting, hospitality counters or conscious retail storytelling.',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_phone' => '1',
            'show_buttons' => '1',
            'show_pills' => '1',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'Contact Amaley',
            'secondary_url' => '/contact/',
        ), $this->base_defaults() );
    }

    /** Render hero. */
    public function render_hero( $atts = array() ) {
        $a = $this->normalize( $atts, $this->hero_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }
        $data = $this->member_data( $member );
        $title = ! empty( $a['title'] ) ? $a['title'] : $data['title'];
        $description = ! empty( $a['description'] ) ? $a['description'] : $data['bio'];
        $out = '<section class="amms-section amms-hero"><div class="amms-wrap amms-hero-grid"><div class="amms-hero-copy">';
        if ( $this->boolish( $a['show_breadcrumb'] ) ) { $out .= '<p class="amms-breadcrumb">' . esc_html( $a['breadcrumb'] ) . '</p>'; }
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="amms-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h1 class="amms-title">' . esc_html( $title ) . '</h1>'; }
        if ( $this->boolish( $a['show_description'] ) && $description ) { $out .= '<p class="amms-description">' . esc_html( $description ) . '</p>'; }
        if ( $this->boolish( $a['show_pills'] ?? '1' ) ) {
            $out .= '<div class="amms-hero-pills">';
            if ( $data['role'] ) { $out .= '<span>' . esc_html( $data['role'] ) . '</span>'; }
            if ( $data['village'] ) { $out .= '<span>' . esc_html( $data['village'] ) . '</span>'; }
            if ( $data['shg_title'] ) { $out .= '<span>' . esc_html( $data['shg_title'] ) . '</span>'; }
            $out .= '</div>';
        }
        if ( $this->boolish( $a['show_buttons'] ) ) { $out .= $this->button_group( $a ); }
        $out .= '</div>';
        if ( $this->boolish( $a['show_image'] ) ) {
            $out .= '<div class="amms-hero-media">';
            if ( $data['image'] ) { $out .= '<img src="' . esc_url( $data['image'] ) . '" alt="' . esc_attr( $data['title'] ) . '" loading="lazy" />'; }
            else { $out .= '<span>' . esc_html( $this->initials( $data['title'] ) ) . '</span>'; }
            $out .= '</div>';
        }
        $out .= '</div></section>';
        return $out;
    }

    /** Render snapshot. */
    public function render_snapshot( $atts = array() ) {
        $a = $this->normalize( $atts, $this->snapshot_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }
        $data = $this->member_data( $member );
        $rows = array();
        if ( $this->boolish( $a['show_role_stat'] ?? '1' ) ) { $rows[] = array( 'Role', $data['role'] ? $data['role'] : 'Producer / Member' ); }
        if ( $this->boolish( $a['show_village_stat'] ?? '1' ) ) { $rows[] = array( 'Village', $data['village'] ? $data['village'] : 'Not added yet' ); }
        if ( $this->boolish( $a['show_shg_stat'] ?? '1' ) ) { $rows[] = array( 'SHG Group', $data['shg_title'] ? $data['shg_title'] : 'Not linked yet' ); }
        if ( $this->boolish( $a['show_cluster_stat'] ?? '1' ) ) { $rows[] = array( 'Cluster', $data['cluster_title'] ? $data['cluster_title'] : 'Resolving through SHG' ); }
        $style = '--amms-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--amms-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--amms-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';
        $out = '<section class="amms-section amms-snapshot"><div class="amms-wrap">' . $this->section_head( $a );
        $out .= '<div class="amms-snapshot-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $rows as $row ) { $out .= '<div class="amms-stat"><span>' . esc_html( $row[0] ) . '</span><strong>' . esc_html( $row[1] ) . '</strong></div>'; }
        $out .= '</div></div></section>';
        return $out;
    }

    /** Render story. */
    public function render_story( $atts = array() ) {
        $a = $this->normalize( $atts, $this->story_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }
        $data = $this->member_data( $member );
        $story = $data['story'] ? $data['story'] : $data['bio'];
        $out = '<section class="amms-section amms-story"><div class="amms-wrap amms-story-card">' . $this->section_head( $a );
        $out .= '<div class="amms-story-body">' . ( $story ? $this->rich_text( $story ) : '<p>Story content is not added yet.</p>' ) . '</div>';
        $tags = array();
        if ( $this->boolish( $a['show_skills'] ) ) { $tags = array_merge( $tags, $this->split_terms( $data['skills'], absint( $a['max_tags'] ) ) ); }
        if ( $this->boolish( $a['show_products'] ) ) { $tags = array_merge( $tags, $this->split_terms( $data['products_handled'], absint( $a['max_tags'] ) ) ); }
        $tags = array_slice( array_values( array_unique( $tags ) ), 0, absint( $a['max_tags'] ) );
        if ( $tags ) { $out .= '<div class="amms-chip-row">'; foreach ( $tags as $tag ) { $out .= '<span>' . esc_html( $tag ) . '</span>'; } $out .= '</div>'; }
        $out .= '</div></section>';
        return $out;
    }

    /** Render linked SHG. */
    public function render_shg( $atts = array() ) {
        $a = $this->normalize( $atts, $this->shg_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }
        $data = $this->member_data( $member );
        $out = '<section class="amms-section amms-related amms-related-shg"><div class="amms-wrap">' . $this->section_head( $a );
        $shg_ids = ! empty( $data['shg_ids'] ) && is_array( $data['shg_ids'] ) ? array_values( array_filter( array_map( 'absint', $data['shg_ids'] ) ) ) : array();
        if ( empty( $shg_ids ) && ! empty( $data['shg_id'] ) ) {
            $shg_ids = array( absint( $data['shg_id'] ) );
        }
        $shg_ids = array_values( array_unique( $shg_ids ) );
        if ( empty( $shg_ids ) ) { return $out . '<div class="amms-empty">No linked SHG group yet.</div></div></section>'; }
        $out .= '<div class="amms-related-grid amms-one-card amms-card-count-' . esc_attr( count( $shg_ids ) ) . '">';
        foreach ( $shg_ids as $linked_shg_id ) {
            $out .= $this->render_shg_card( $linked_shg_id, $a );
        }
        $out .= '</div></div></section>';
        return $out;
    }

    /** Render linked cluster. */
    public function render_cluster( $atts = array() ) {
        $a = $this->normalize( $atts, $this->cluster_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }
        $data = $this->member_data( $member );
        $out = '<section class="amms-section amms-related amms-related-cluster"><div class="amms-wrap">' . $this->section_head( $a );
        $cluster_ids = ! empty( $data['cluster_ids'] ) && is_array( $data['cluster_ids'] ) ? array_values( array_filter( array_map( 'absint', $data['cluster_ids'] ) ) ) : array();
        if ( empty( $cluster_ids ) && ! empty( $data['cluster_id'] ) ) {
            $cluster_ids = array( absint( $data['cluster_id'] ) );
        }
        $cluster_ids = array_values( array_unique( $cluster_ids ) );
        if ( empty( $cluster_ids ) ) { return $out . '<div class="amms-empty">No linked cluster found yet.</div></div></section>'; }
        $out .= '<div class="amms-related-grid amms-one-card amms-card-count-' . esc_attr( count( $cluster_ids ) ) . '">';
        foreach ( $cluster_ids as $linked_cluster_id ) {
            $out .= $this->render_cluster_card( $linked_cluster_id, $a );
        }
        $out .= '</div></div></section>';
        return $out;
    }

    private function member_products_current_page() {
        return isset( $_GET['amms_products_page'] ) ? max( 1, absint( wp_unslash( $_GET['amms_products_page'] ) ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    }

    private function member_products_pagination_data( $total, $per_page, $current, $a ) {
        $total    = max( 0, absint( $total ) );
        $per_page = max( 1, absint( $per_page ) );
        $pages    = (int) ceil( $total / $per_page );

        if ( $pages <= 1 ) {
            return array();
        }

        return array(
            'current'   => max( 1, min( absint( $current ), $pages ) ),
            'pages'     => $pages,
            'prev_text' => ! empty( $a['pagination_prev_text'] ) ? (string) $a['pagination_prev_text'] : 'Previous',
            'next_text' => ! empty( $a['pagination_next_text'] ) ? (string) $a['pagination_next_text'] : 'Next',
        );
    }

    private function member_products_pagination_url( $page ) {
        return add_query_arg( 'amms_products_page', max( 1, absint( $page ) ) ) . '#amms-member-products';
    }

    private function render_member_products_pagination( $p ) {
        if ( empty( $p ) || empty( $p['pages'] ) || absint( $p['pages'] ) <= 1 ) {
            return '';
        }

        $current = max( 1, absint( $p['current'] ) );
        $pages   = max( 1, absint( $p['pages'] ) );

        $out = '<nav class="amms-pagination amms-products-pagination" aria-label="' . esc_attr__( 'Member products pagination', 'amaley-core' ) . '">';

        if ( $current > 1 ) {
            $out .= '<a class="amms-page-link amms-page-prev" data-amms-page="' . esc_attr( $current - 1 ) . '" href="' . esc_url( $this->member_products_pagination_url( $current - 1 ) ) . '">' . esc_html( $p['prev_text'] ) . '</a>';
        }

        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $i === $current ) {
                $out .= '<span class="amms-page-link amms-page-current" aria-current="page">' . esc_html( (string) $i ) . '</span>';
            } else {
                $out .= '<a class="amms-page-link" data-amms-page="' . esc_attr( $i ) . '" href="' . esc_url( $this->member_products_pagination_url( $i ) ) . '">' . esc_html( (string) $i ) . '</a>';
            }
        }

        if ( $current < $pages ) {
            $out .= '<a class="amms-page-link amms-page-next" data-amms-page="' . esc_attr( $current + 1 ) . '" href="' . esc_url( $this->member_products_pagination_url( $current + 1 ) ) . '">' . esc_html( $p['next_text'] ) . '</a>';
        }

        $out .= '</nav>';
        return $out;
    }

    private function member_products_ajax_settings( $a ) {
        $allowed = array(
            'limit',
            'card_template',
            'product_card_source',
            'product_card_manual_preset',
            'show_product_image',
            'show_product_label',
            'product_label_text',
            'show_product_excerpt',
            'product_excerpt_words',
            'show_product_meta',
            'show_product_chips',
            'show_product_button',
            'show_fallback_tags',
            'enable_pagination',
            'pagination_prev_text',
            'pagination_next_text',
        );

        $out = array();
        foreach ( $allowed as $key ) {
            if ( isset( $a[ $key ] ) ) {
                $out[ $key ] = is_scalar( $a[ $key ] ) ? (string) $a[ $key ] : '';
            }
        }

        return $out;
    }

    private function render_member_products_grid_inner( $a, $products, $fallback_tags = array() ) {
        $out = '';

        if ( $products ) {
            $out .= '<div class="amms-product-grid">';
            foreach ( $products as $product_post ) {
                $out .= $this->render_product_card( $product_post, $a );
            }
            $out .= '</div>';
        } else {
            if ( $fallback_tags && $this->boolish( $a['show_fallback_tags'] ?? '1' ) ) {
                $out .= '<div class="amms-product-fallback">';
                foreach ( $fallback_tags as $tag ) {
                    $out .= '<span>' . esc_html( $tag ) . '</span>';
                }
                $out .= '</div>';
            } else {
                $out .= '<div class="amms-empty">No mapped products yet.</div>';
            }
        }

        $out .= $this->render_member_products_pagination( isset( $a['_pagination'] ) ? $a['_pagination'] : array() );
        return $out;
    }

    public function ajax_member_products_pagination() {
        if ( ! check_ajax_referer( 'amaley_member_single_products_pagination', 'nonce', false ) ) {
            wp_send_json_error( array( 'message' => 'Invalid pagination request.' ), 403 );
        }

        $member_id = isset( $_POST['member_id'] ) ? absint( wp_unslash( $_POST['member_id'] ) ) : 0;
        $page      = isset( $_POST['page'] ) ? max( 1, absint( wp_unslash( $_POST['page'] ) ) ) : 1;
        $settings_json = isset( $_POST['settings'] ) ? wp_unslash( $_POST['settings'] ) : '{}';
        $settings = json_decode( (string) $settings_json, true );

        if ( ! is_array( $settings ) ) {
            $settings = array();
        }

        if ( ! $member_id ) {
            wp_send_json_error( array( 'message' => 'Missing member data.' ), 400 );
        }

        $member = get_post( $member_id );
        if ( ! $member || 'amaley_member' !== $member->post_type ) {
            wp_send_json_error( array( 'message' => 'Invalid member.' ), 404 );
        }

        $a = $this->normalize( $settings, $this->products_defaults() );
        $limit  = max( 1, absint( isset( $a['limit'] ) ? $a['limit'] : 4 ) );
        $offset = ( $page - 1 ) * $limit;

        $total    = count( $this->product_ids_for_member( $member_id ) );
        $products = $this->products_for_member( $member_id, $limit, $offset );
        $a['_pagination'] = $this->member_products_pagination_data( $total, $limit, $page, $a );

        wp_send_json_success( array(
            'html' => $this->render_member_products_grid_inner( $a, $products, array() ),
        ) );
    }

    private function member_products_setting_css_value( $a, $key, $default = '0px' ) {
        if ( ! isset( $a[ $key ] ) ) {
            return $default;
        }

        $value = $a[ $key ];
        if ( is_array( $value ) ) {
            $size = isset( $value['size'] ) ? $value['size'] : '';
            $unit = isset( $value['unit'] ) && '' !== $value['unit'] ? $value['unit'] : 'px';

            if ( '' === $size || null === $size ) {
                return $default;
            }

            return is_numeric( $size ) ? ( (string) $size . $unit ) : $default;
        }

        if ( is_numeric( $value ) ) {
            return (string) $value . 'px';
        }

        return $default;
    }

    private function member_products_setting_int( $a, $key, $default, $min, $max ) {
        if ( ! isset( $a[ $key ] ) || '' === $a[ $key ] ) {
            return (int) $default;
        }

        $value = absint( $a[ $key ] );
        if ( $value < $min ) {
            $value = $min;
        }
        if ( $value > $max ) {
            $value = $max;
        }

        return $value;
    }

    private function member_products_archive_rhythm_css( $a = array() ) {
        /*
         * v1.0.140-clean-controls
         * Grid/container CSS only. The actual product card remains the existing OG/Core card.
         */
        $desktop_cols = $this->member_products_setting_int( $a, 'product_desktop_columns_fixed', 4, 1, 4 );
        $tablet_cols  = $this->member_products_setting_int( $a, 'product_tablet_columns_fixed', 2, 1, 3 );
        $mobile_cols  = $this->member_products_setting_int( $a, 'product_mobile_columns_fixed', 1, 1, 2 );
        $gap          = $this->member_products_setting_css_value( $a, 'product_grid_gap_safe', '24px' );

        return '<style id="amms-member-products-og-grid-css">'
            . '#amms-member-products.amms-products .amms-wrap{width:100%;max-width:1180px;margin:0 auto;padding-left:22px;padding-right:22px;box-sizing:border-box;}'
            . '#amms-member-products.amms-products .amms-product-grid{display:grid;grid-template-columns:repeat(' . esc_attr( $desktop_cols ) . ',minmax(0,1fr));gap:' . esc_attr( $gap ) . ';align-items:stretch;width:100%;max-width:100%;}'
            . '#amms-member-products.amms-products .amms-product-grid>.amaley-card{height:100%;min-width:0;}'
            . '#amms-member-products.amms-products .amms-section-actions{display:flex;justify-content:center;flex-wrap:wrap;gap:12px;margin-top:28px;}'
            . '@media(max-width:1100px){#amms-member-products.amms-products .amms-product-grid{grid-template-columns:repeat(3,minmax(0,1fr)) !important;gap:20px !important;}}'
            . '@media(max-width:900px){#amms-member-products.amms-products .amms-product-grid{grid-template-columns:repeat(' . esc_attr( $tablet_cols ) . ',minmax(0,1fr)) !important;gap:18px !important;}}'
            . '@media(max-width:640px){#amms-member-products.amms-products .amms-wrap{padding-left:14px !important;padding-right:14px !important;}#amms-member-products.amms-products .amms-product-grid{grid-template-columns:repeat(' . esc_attr( $mobile_cols ) . ',minmax(0,1fr)) !important;gap:18px !important;}}'
            
            /* v1.0.141 responsive priority: duplicate ID beats Elementor-generated desktop column CSS. */
            . '#amms-member-products#amms-member-products.amms-products{overflow-x:hidden;}'
            . '#amms-member-products#amms-member-products.amms-products .amms-wrap{box-sizing:border-box;width:100%;max-width:1180px;overflow-x:hidden;}'
            . '#amms-member-products#amms-member-products.amms-products .amms-product-grid{box-sizing:border-box;min-width:0;max-width:100%;overflow:visible;grid-template-columns:repeat(' . esc_attr( $desktop_cols ) . ',minmax(0,1fr)) !important;}'
            . '#amms-member-products#amms-member-products.amms-products .amms-product-card{min-width:0;max-width:100%;}'
            . '@media(max-width:1024px){#amms-member-products#amms-member-products.amms-products .amms-product-grid{grid-template-columns:repeat(' . esc_attr( $tablet_cols ) . ',minmax(0,1fr)) !important;gap:18px !important;}}'
            . '@media(max-width:767px){#amms-member-products#amms-member-products.amms-products .amms-wrap{padding-left:16px !important;padding-right:16px !important;}#amms-member-products#amms-member-products.amms-products .amms-product-grid{grid-template-columns:repeat(' . esc_attr( $mobile_cols ) . ',minmax(0,1fr)) !important;gap:18px !important;}#amms-member-products#amms-member-products.amms-products .amms-product-card{width:100% !important;max-width:100% !important;}#amms-member-products#amms-member-products.amms-products .amms-product-media{height:220px !important;min-height:220px !important;}}'
            . '@media(max-width:420px){#amms-member-products#amms-member-products.amms-products .amms-product-grid{grid-template-columns:1fr !important;}#amms-member-products#amms-member-products.amms-products .amms-product-meta{grid-template-columns:1fr !important;}}'
            . '</style>';
    }

    /** Render products. */
    public function render_products( $atts = array() ) {
        $a = $this->normalize( $atts, $this->products_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }

        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }

        $data  = $this->member_data( $member );
        $limit = max( 1, absint( isset( $a['limit'] ) ? $a['limit'] : 4 ) );
        $page  = $this->member_products_current_page();
        $offset = 0;

        if ( $this->boolish( isset( $a['enable_pagination'] ) ? $a['enable_pagination'] : '0' ) ) {
            $offset = ( $page - 1 ) * $limit;
            $a['_pagination'] = $this->member_products_pagination_data( count( $this->product_ids_for_member( $member->ID ) ), $limit, $page, $a );
        }

        $products = $this->products_for_member( $member->ID, $limit, $offset );
        $fallback_tags = $products ? array() : $this->split_terms( $data['products_handled'], 16 );

        $out = $this->member_products_archive_rhythm_css( $a );
        $out .= '<section id="amms-member-products" class="amms-section amms-products" data-amms-products-section="1" data-amms-member-id="' . esc_attr( absint( $member->ID ) ) . '" data-amms-ajax-url="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" data-amms-nonce="' . esc_attr( wp_create_nonce( 'amaley_member_single_products_pagination' ) ) . '" data-amms-settings="' . esc_attr( wp_json_encode( $this->member_products_ajax_settings( $a ) ) ) . '"><div class="amms-wrap">' . $this->section_head( $a );
        $out .= '<div class="amms-products-results" data-amms-products-results="1">' . $this->render_member_products_grid_inner( $a, $products, $fallback_tags ) . '</div>';

        if ( $this->boolish( $a['show_section_button'] ) ) {
            $out .= '<div class="amms-section-actions"><a class="amms-section-button" href="' . esc_url( $a['section_button_url'] ) . '">' . esc_html( $a['section_button_text'] ) . '</a></div>';
        }

        $out .= '</div></section>';
        return $out;
    }

    /** Render gallery. */
    public function render_gallery( $atts = array() ) {
        $a = $this->normalize( $atts, $this->gallery_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }
        $items = $this->gallery_urls_for_member( $member->ID );
        $max_images = max( 1, absint( $a['max_images'] ?? 6 ) );
        $items = array_slice( $items, 0, $max_images );
        $style = '--amms-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--amms-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--amms-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';
        $out = '<section class="amms-section amms-gallery"><div class="amms-wrap">' . $this->section_head( $a );
        if ( ! $items ) { return $out . '<div class="amms-empty">No gallery images added yet.</div></div></section>'; }
        $out .= '<div class="amms-gallery-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $items as $url ) { $out .= '<figure><img src="' . esc_url( $url ) . '" alt="" loading="lazy" />'; if ( $this->boolish( $a['show_caption'] ) ) { $out .= '<figcaption>' . esc_html( get_the_title( $member ) ) . '</figcaption>'; } $out .= '</figure>'; }
        $out .= '</div></div></section>';
        return $out;
    }

    /** Render contact CTA. */
    public function render_contact( $atts = array() ) {
        $a = $this->normalize( $atts, $this->contact_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $member = $this->detect_member( $a );
        if ( ! $member ) { return $this->empty_state( $a ); }
        $data = $this->member_data( $member );
        $out = '<section class="amms-section amms-contact"><div class="amms-wrap amms-contact-card">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="amms-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="amms-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="amms-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        if ( $this->boolish( $a['show_phone'] ) && $data['phone'] ) { $out .= '<p class="amms-phone">Phone / WhatsApp: ' . esc_html( $data['phone'] ) . '</p>'; }
        if ( $this->boolish( $a['show_buttons'] ) ) { $out .= $this->button_group( $a ); }
        $out .= '</div></section>';
        return $out;
    }

    /** Member detection. */
    private function detect_member( $a ) {
        $id = 0;
        if ( ! empty( $a['member_id'] ) ) { $id = absint( $a['member_id'] ); }
        if ( ! $id && ! empty( $a['preview_member_id'] ) ) { $id = absint( $a['preview_member_id'] ); }
        if ( $id ) {
            $post = get_post( $id );
            if ( $post && 'amaley_member' === $post->post_type ) { return $post; }
        }
        $slug = '';
        if ( ! empty( $a['member_slug'] ) ) { $slug = sanitize_title( $a['member_slug'] ); }
        if ( ! $slug && $this->boolish( $a['auto_detect'] ) ) {
            $slug = isset( $_GET['member_slug'] ) ? sanitize_title( wp_unslash( $_GET['member_slug'] ) ) : '';
            if ( ! $slug ) { $slug = isset( $_GET['producer_slug'] ) ? sanitize_title( wp_unslash( $_GET['producer_slug'] ) ) : ''; }
            if ( ! $slug && isset( $_GET['member_id'] ) ) { $id = absint( $_GET['member_id'] ); }
        }
        if ( $id ) {
            $post = get_post( $id );
            if ( $post && 'amaley_member' === $post->post_type ) { return $post; }
        }
        if ( $slug ) {
            $posts = get_posts( array( 'post_type' => 'amaley_member', 'name' => $slug, 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1 ) );
            if ( $posts ) { return $posts[0]; }
        }
        if ( is_admin() || ( defined( 'ELEMENTOR_VERSION' ) && class_exists( '\\Elementor\\Plugin' ) ) ) {
            $posts = get_posts( array( 'post_type' => 'amaley_member', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
            if ( $posts ) { return $posts[0]; }
        }
        return null;
    }

    /** Member data. */
    private function member_data( $member ) {
        $id = $member->ID;

        /*
         * v1.0.78.6 display support:
         * Current admin field still stores a single SHG in _amaley_member_shg_id.
         * This also reads future-safe multi values from _amaley_member_shg_ids if present,
         * so the frontend can show multiple SHG cards later without breaking today's data.
         */
        $shg_ids = array();
        $raw_shg_ids = get_post_meta( $id, '_amaley_member_shg_ids', true );
        if ( is_array( $raw_shg_ids ) ) {
            $shg_ids = array_map( 'absint', $raw_shg_ids );
        } elseif ( is_string( $raw_shg_ids ) && '' !== trim( $raw_shg_ids ) ) {
            $shg_ids = array_map( 'absint', preg_split( '/[\\s,|]+/', $raw_shg_ids ) );
        }

        $single_shg_id = absint( get_post_meta( $id, '_amaley_member_shg_id', true ) );
        if ( $single_shg_id ) {
            array_unshift( $shg_ids, $single_shg_id );
        }
        $shg_ids = array_values( array_unique( array_filter( array_map( 'absint', $shg_ids ) ) ) );
        $shg_id = ! empty( $shg_ids ) ? absint( $shg_ids[0] ) : 0;

        $cluster_ids = array();
        foreach ( $shg_ids as $linked_shg_id ) {
            $linked_cluster_id = absint( get_post_meta( $linked_shg_id, '_amaley_shg_cluster_id', true ) );
            if ( $linked_cluster_id ) {
                $cluster_ids[] = $linked_cluster_id;
            }
        }

        $raw_cluster_ids = get_post_meta( $id, '_amaley_member_cluster_ids', true );
        if ( is_array( $raw_cluster_ids ) ) {
            $cluster_ids = array_merge( $cluster_ids, array_map( 'absint', $raw_cluster_ids ) );
        } elseif ( is_string( $raw_cluster_ids ) && '' !== trim( $raw_cluster_ids ) ) {
            $cluster_ids = array_merge( $cluster_ids, array_map( 'absint', preg_split( '/[\\s,|]+/', $raw_cluster_ids ) ) );
        }

        $cluster_ids = array_values( array_unique( array_filter( array_map( 'absint', $cluster_ids ) ) ) );
        $cluster_id = ! empty( $cluster_ids ) ? absint( $cluster_ids[0] ) : 0;
        $image = get_the_post_thumbnail_url( $id, 'large' );
        if ( ! $image ) { $image = get_post_meta( $id, '_amaley_photo_url', true ); }
        $bio = get_post_meta( $id, '_amaley_short_bio', true );
        if ( '' === trim( (string) $bio ) ) { $bio = wp_trim_words( wp_strip_all_tags( get_post_meta( $id, '_amaley_story', true ) ), 28 ); }
        return array(
            'id' => $id,
            'title' => get_the_title( $member ),
            'slug' => $member->post_name,
            'image' => $image,
            'role' => get_post_meta( $id, '_amaley_role', true ),
            'skills' => get_post_meta( $id, '_amaley_skills', true ),
            'products_handled' => get_post_meta( $id, '_amaley_products_handled', true ),
            'bio' => $bio,
            'story' => get_post_meta( $id, '_amaley_story', true ),
            'village' => get_post_meta( $id, '_amaley_village', true ),
            'phone' => get_post_meta( $id, '_amaley_phone', true ),
            'shg_id' => $shg_id,
            'shg_ids' => $shg_ids,
            'shg_title' => $shg_id ? get_the_title( $shg_id ) : '',
            'cluster_id' => $cluster_id,
            'cluster_ids' => $cluster_ids,
            'cluster_title' => $cluster_id ? get_the_title( $cluster_id ) : '',
        );
    }

    /** Section head. */
    private function section_head( $a ) {
        $out = '<div class="amms-section-head">';
        if ( $this->boolish( $a['show_label'] ?? '1' ) ) { $out .= '<p class="amms-kicker">' . esc_html( $a['label'] ?? '' ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ?? '1' ) ) { $out .= '<h2 class="amms-section-title">' . esc_html( $a['title'] ?? '' ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ?? '1' ) ) { $out .= '<p class="amms-section-desc">' . esc_html( $a['description'] ?? '' ) . '</p>'; }
        $out .= '</div>';
        return $out;
    }

    /** Button group. */
    private function button_group( $a ) {
        $out = '<div class="amms-button-row">';
        if ( ! empty( $a['primary_text'] ) ) { $out .= '<a class="amms-btn amms-btn-primary" href="' . esc_url( $a['primary_url'] ) . '">' . esc_html( $a['primary_text'] ) . '</a>'; }
        if ( ! empty( $a['secondary_text'] ) ) { $out .= '<a class="amms-btn amms-btn-secondary" href="' . esc_url( $a['secondary_url'] ) . '">' . esc_html( $a['secondary_text'] ) . '</a>'; }
        $out .= '</div>';
        return $out;
    }

    /** Render SHG card. */
    private function render_shg_card( $shg_id, $a ) {
        $card_template = isset( $a['card_template'] ) ? sanitize_key( $a['card_template'] ) : 'current_existing';
        if ( 'og_card_1' === $card_template && class_exists( 'Amaley_Core_Card_Renderer' ) ) {
            $preset = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::get_assignment( 'card_template_shg', 'og_shg_card_1' ) : 'og_shg_card_1';
            $url = str_replace( array( '{id}', '{slug}' ), array( absint( $shg_id ), get_post_field( 'post_name', $shg_id ) ), (string) $a['detail_url_pattern'] );
            return Amaley_Core_Card_Renderer::render_shg( $shg_id, array(
                'preset' => $preset,
                'url' => $url,
                'button_text' => isset( $a['button_text'] ) ? $a['button_text'] : 'View Collective Details',
                'show_image' => $this->boolish( $a['show_card_media'] ?? '1' ),
                'show_label' => $this->boolish( $a['show_card_label'] ?? '1' ),
                'show_title' => $this->boolish( $a['show_card_title'] ?? '1' ),
                'show_excerpt' => $this->boolish( $a['show_card_excerpt'] ?? '1' ),
                'show_meta' => $this->boolish( $a['show_card_meta'] ?? '1' ),
                'show_tags' => $this->boolish( $a['show_card_tags'] ?? '1' ),
                'show_button' => $this->boolish( $a['show_button'] ?? '1' ),
                'excerpt_words' => 18,
                'class' => 'amaley-card--member-single-linked-shg',
            ) );
        }

        $title = get_the_title( $shg_id );
        $village = get_post_meta( $shg_id, '_amaley_village', true );
        $district = get_post_meta( $shg_id, '_amaley_district', true );
        $members = get_post_meta( $shg_id, '_amaley_member_count', true );
        $story = get_post_meta( $shg_id, '_amaley_short_story', true );
        if ( ! $story ) { $story = wp_strip_all_tags( get_post_meta( $shg_id, '_amaley_full_story', true ) ); }
        $img = get_the_post_thumbnail_url( $shg_id, 'large' );
        $url = str_replace( array( '{id}', '{slug}' ), array( $shg_id, get_post_field( 'post_name', $shg_id ) ), (string) $a['detail_url_pattern'] );
        $out = '<article class="amms-related-card amms-shg-card ' . ( $img ? 'amms-has-media' : 'amms-no-media' ) . '">';
        if ( $this->boolish( $a['show_card_media'] ?? '1' ) ) {
            $out .= '<div class="amms-related-media">' . ( $img ? '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />' : '<span>SHG</span>' );
            if ( $this->boolish( $a['show_card_badge'] ?? '1' ) ) { $out .= '<b>Verified</b>'; }
            $out .= '</div>';
        }
        $out .= '<div class="amms-related-body">';
        if ( $this->boolish( $a['show_card_label'] ?? '1' ) ) { $out .= '<p class="amms-card-label">SHG Group</p>'; }
        $out .= '<h3>' . esc_html( $title ) . '</h3>';
        if ( $this->boolish( $a['show_card_excerpt'] ?? '1' ) && $story ) { $out .= '<p>' . esc_html( wp_trim_words( $story, 22 ) ) . '</p>'; }
        if ( $this->boolish( $a['show_card_meta'] ?? '1' ) ) {
            $out .= '<dl>';
            if ( $village ) { $out .= '<div><dt>Village</dt><dd>' . esc_html( $village ) . '</dd></div>'; }
            if ( $district ) { $out .= '<div><dt>District</dt><dd>' . esc_html( $district ) . '</dd></div>'; }
            if ( $members ) { $out .= '<div><dt>Members</dt><dd>' . esc_html( $members ) . '</dd></div>'; }
            $out .= '</dl>';
        }
        if ( $this->boolish( $a['show_button'] ?? '1' ) ) { $out .= '<a class="amms-card-button" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ?? 'View Collective Details' ) . '</a>'; }
        $out .= '</div></article>';
        return $out;
    }

    /** Render cluster card. */
    private function render_cluster_card( $cluster_id, $a ) {
        $card_template = isset( $a['card_template'] ) ? sanitize_key( $a['card_template'] ) : 'current_existing';
        if ( 'og_card_1' === $card_template && class_exists( 'Amaley_Core_Card_Renderer' ) ) {
            $preset = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::get_assignment( 'card_template_cluster', 'og_cluster_card_1' ) : 'og_cluster_card_1';
            $url = str_replace( array( '{id}', '{slug}' ), array( absint( $cluster_id ), get_post_field( 'post_name', $cluster_id ) ), (string) $a['detail_url_pattern'] );
            return Amaley_Core_Card_Renderer::render_cluster( $cluster_id, array(
                'preset' => $preset,
                'url' => $url,
                'button_text' => isset( $a['button_text'] ) ? $a['button_text'] : 'View Cluster Story',
                'show_image' => $this->boolish( $a['show_card_media'] ?? '1' ),
                'show_label' => $this->boolish( $a['show_card_label'] ?? '1' ),
                'show_title' => $this->boolish( $a['show_card_title'] ?? '1' ),
                'show_excerpt' => $this->boolish( $a['show_card_excerpt'] ?? '1' ),
                'show_meta' => $this->boolish( $a['show_card_meta'] ?? '1' ),
                'show_tags' => $this->boolish( $a['show_card_tags'] ?? '1' ),
                'show_button' => $this->boolish( $a['show_button'] ?? '1' ),
                'excerpt_words' => 18,
                'class' => 'amaley-card--member-single-linked-cluster',
            ) );
        }

        $title = get_the_title( $cluster_id );
        $region = get_post_meta( $cluster_id, '_amaley_region', true );
        $district = get_post_meta( $cluster_id, '_amaley_district', true );
        $villages = get_post_meta( $cluster_id, '_amaley_villages', true );
        $intro = get_post_meta( $cluster_id, '_amaley_short_intro', true );
        $img = get_the_post_thumbnail_url( $cluster_id, 'large' );
        $url = str_replace( array( '{id}', '{slug}' ), array( $cluster_id, get_post_field( 'post_name', $cluster_id ) ), (string) $a['detail_url_pattern'] );
        $out = '<article class="amms-related-card amms-cluster-card ' . ( $img ? 'amms-has-media' : 'amms-no-media' ) . '">';
        if ( $this->boolish( $a['show_card_media'] ?? '1' ) ) {
            $out .= '<div class="amms-related-media">' . ( $img ? '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />' : '<span>Cluster</span>' ) . '</div>';
        }
        $out .= '<div class="amms-related-body">';
        if ( $this->boolish( $a['show_card_label'] ?? '1' ) ) { $out .= '<p class="amms-card-label">' . esc_html( $region ? $region : 'Cluster' ) . '</p>'; }
        $out .= '<h3>' . esc_html( $title ) . '</h3>';
        if ( $this->boolish( $a['show_card_excerpt'] ?? '1' ) && $intro ) { $out .= '<p>' . esc_html( wp_trim_words( $intro, 24 ) ) . '</p>'; }
        if ( $this->boolish( $a['show_card_meta'] ?? '1' ) ) {
            $out .= '<dl>';
            if ( $district ) { $out .= '<div><dt>District</dt><dd>' . esc_html( $district ) . '</dd></div>'; }
            if ( $villages ) { $out .= '<div><dt>Villages</dt><dd>' . esc_html( wp_trim_words( $villages, 7 ) ) . '</dd></div>'; }
            $out .= '</dl>';
        }
        if ( $this->boolish( $a['show_button'] ?? '1' ) ) { $out .= '<a class="amms-card-button" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ?? 'View Cluster Story' ) . '</a>'; }
        $out .= '</div></article>';
        return $out;
    }

    /** Render product card. */
    private function render_product_card( $product_post, $a = array() ) {
        /*
         * v1.0.140-clean-og-product-card-controls
         * Restore the existing Amaley OG/Core Product Card renderer.
         * No custom product-card markup is generated here.
         */
        $id = is_object( $product_post ) && isset( $product_post->ID ) ? absint( $product_post->ID ) : absint( $product_post );

        if ( ! $id ) {
            return '';
        }

        if ( class_exists( 'Amaley_Core_Card_Renderer' ) && method_exists( 'Amaley_Core_Card_Renderer', 'render_product' ) ) {
            $preset = ! empty( $a['product_card_manual_preset'] ) ? sanitize_key( $a['product_card_manual_preset'] ) : 'compact';
            if ( ! empty( $a['card_template'] ) && 'og_card_1' === $a['card_template'] ) {
                $preset = 'compact';
            }

            return Amaley_Core_Card_Renderer::render_product( $id, array(
                'preset'        => $preset,
                'class'         => 'amms-member-product-og-card',
                'show_image'    => $this->boolish( $a['show_product_image'] ?? '1' ),
                'show_label'    => $this->boolish( $a['show_product_label'] ?? '1' ),
                'label_text'    => isset( $a['product_label_text'] ) ? (string) $a['product_label_text'] : 'Product',
                'show_title'    => true,
                'show_excerpt'  => $this->boolish( $a['show_product_excerpt'] ?? '1' ),
                'excerpt_words' => isset( $a['product_excerpt_words'] ) ? absint( $a['product_excerpt_words'] ) : 16,
                'show_meta'     => $this->boolish( $a['show_product_meta'] ?? '1' ),
                'show_tags'     => $this->boolish( $a['show_product_chips'] ?? '1' ),
                'show_button'   => $this->boolish( $a['show_product_button'] ?? '1' ),
                'button_text'   => 'View Product',
                'url'           => get_permalink( $id ),
            ) );
        }

        /* Safe fallback only if the core renderer is unavailable. */
        $title = get_the_title( $id );
        $url   = get_permalink( $id );
        return '<article class="amaley-card amaley-card--product amms-member-product-og-card"><div class="amaley-card__body"><h3 class="amaley-card__title">' . esc_html( $title ) . '</h3><a class="amaley-card__button" href="' . esc_url( $url ) . '">View Product</a></div></article>';
    }


    /** Products for member. */
    private function product_ids_for_member( $member_id ) {
        if ( ! post_type_exists( 'product' ) ) { return array(); }

        $candidates = get_posts( array(
            'post_type'      => 'product',
            'post_status'    => array( 'publish', 'private' ),
            'fields'         => 'ids',
            'posts_per_page' => 500,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        $out = array();

        foreach ( $candidates as $product_id ) {
            $raw_values = array(
                get_post_meta( absint( $product_id ), '_amaley_origin_member_ids', true ),
                get_post_meta( absint( $product_id ), '_amaley_origin_member_id', true ),
                get_post_meta( absint( $product_id ), 'linked_producer_maker', true ),
                get_post_meta( absint( $product_id ), '_linked_producer_maker', true ),
                get_post_meta( absint( $product_id ), 'linked_member', true ),
                get_post_meta( absint( $product_id ), '_linked_member', true ),
            );

            $ids = array();
            foreach ( $raw_values as $raw ) {
                if ( is_array( $raw ) ) {
                    foreach ( $raw as $value ) {
                        $ids[] = absint( is_object( $value ) && isset( $value->ID ) ? $value->ID : $value );
                    }
                } elseif ( is_object( $raw ) && isset( $raw->ID ) ) {
                    $ids[] = absint( $raw->ID );
                } elseif ( is_scalar( $raw ) ) {
                    foreach ( preg_split( '/[,\s|]+/', (string) $raw ) as $part ) {
                        if ( '' !== trim( $part ) ) {
                            $ids[] = absint( $part );
                        }
                    }
                }
            }

            if ( in_array( absint( $member_id ), array_values( array_unique( array_filter( $ids ) ) ), true ) ) {
                $out[] = absint( $product_id );
            }
        }

        return array_values( array_unique( array_filter( array_map( 'absint', $out ) ) ) );
    }

    private function products_for_member( $member_id, $limit = 4, $offset = 0 ) {
        $ids = array_slice( $this->product_ids_for_member( $member_id ), max( 0, absint( $offset ) ), max( 1, absint( $limit ) ) );
        if ( empty( $ids ) ) { return array(); }

        return get_posts( array(
            'post_type'      => 'product',
            'post_status'    => array( 'publish', 'private' ),
            'post__in'       => $ids,
            'posts_per_page' => count( $ids ),
            'orderby'        => 'post__in',
        ) );
    }

    /** Gallery URLs. */
    private function gallery_urls_for_member( $member_id ) {
        $urls = array();
        $gallery = get_post_meta( $member_id, '_amaley_gallery_urls', true );
        foreach ( preg_split( '/[\r\n,]+/', (string) $gallery ) as $url ) {
            $url = trim( $url );
            if ( $url && filter_var( $url, FILTER_VALIDATE_URL ) ) { $urls[] = esc_url_raw( $url ); }
        }
        if ( empty( $urls ) ) {
            $featured = get_the_post_thumbnail_url( $member_id, 'large' );
            if ( $featured ) { $urls[] = esc_url_raw( $featured ); }
        }
        return array_values( array_unique( $urls ) );
    }

    /** Utility: split terms. */
    private function split_terms( $value, $limit = 6 ) {
        $parts = preg_split( '/[\r\n,|]+/', (string) $value );
        $out = array();
        foreach ( $parts as $part ) {
            $part = trim( $part );
            if ( '' !== $part ) { $out[] = $part; }
            if ( count( $out ) >= $limit ) { break; }
        }
        return $out;
    }

    /** Initials. */
    private function initials( $title ) {
        $words = preg_split( '/\s+/', trim( wp_strip_all_tags( (string) $title ) ) );
        $letters = '';
        foreach ( array_slice( $words, 0, 2 ) as $word ) { $letters .= strtoupper( substr( $word, 0, 1 ) ); }
        return $letters ? $letters : 'MP';
    }

    /** Empty state. */
    private function empty_state( $a ) {
        return '<section class="amms-section"><div class="amms-wrap"><div class="amms-empty">' . esc_html( $a['empty_message'] ?? 'No member selected.' ) . '</div></div></section>';
    }
}
