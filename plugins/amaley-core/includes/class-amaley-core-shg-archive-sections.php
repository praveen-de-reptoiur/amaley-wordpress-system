<?php
/**
 * SHG Archive section widgets renderer.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_SHG_Archive_Sections {
    /** Prevent duplicate Elementor widget registration across hook variants. */
    private $elementor_widgets_registered = false;

    /** Constructor. */
    public function __construct() {
        $GLOBALS['amaley_core_shg_archive_sections'] = $this;
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );

        add_shortcode( 'amaley_shg_archive_hero', array( $this, 'shortcode_hero' ) );
        add_shortcode( 'amaley_shg_archive_trust_strip', array( $this, 'shortcode_trust_strip' ) );
        add_shortcode( 'amaley_shg_archive_intro', array( $this, 'shortcode_intro' ) );
        add_shortcode( 'amaley_shg_archive_grid', array( $this, 'shortcode_grid' ) );
        add_shortcode( 'amaley_shg_archive_gallery', array( $this, 'shortcode_gallery' ) );
        add_shortcode( 'amaley_shg_archive_cta', array( $this, 'shortcode_cta' ) );

        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );
    }

    /** Register assets. */
    public function register_assets() {
        wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        wp_register_style( 'amaley-core-shg-archive-sections', AMALEY_CORE_URL . 'assets/amaley-core-shg-archive-sections.css', array( 'amaley-core-cards' ), AMALEY_CORE_VERSION );
    }

    /** Enqueue assets. */
    public function enqueue_assets() {
        if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        }
        wp_enqueue_style( 'amaley-core-cards' );
        wp_enqueue_style( 'amaley-core-shg-archive-sections' );
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

        if ( null === $widgets_manager && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->widgets_manager ) ) {
            $widgets_manager = \Elementor\Plugin::$instance->widgets_manager;
        }

        if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
            return;
        }

        $files = array(
            'class-amaley-core-shg-archive-hero-widget.php',
            'class-amaley-core-shg-archive-trust-strip-widget.php',
            'class-amaley-core-shg-archive-intro-widget.php',
            'class-amaley-core-shg-archive-grid-widget.php',
            'class-amaley-core-shg-archive-gallery-widget.php',
            'class-amaley-core-shg-archive-cta-widget.php',
        );

        foreach ( $files as $file_name ) {
            $file = AMALEY_CORE_PATH . 'includes/widgets/' . $file_name;
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }

        $widgets = array(
            'Amaley_Core_SHG_Archive_Hero_Widget',
            'Amaley_Core_SHG_Archive_Trust_Strip_Widget',
            'Amaley_Core_SHG_Archive_Intro_Widget',
            'Amaley_Core_SHG_Archive_Grid_Widget',
            'Amaley_Core_SHG_Archive_Gallery_Widget',
            'Amaley_Core_SHG_Archive_CTA_Widget',
        );

        foreach ( $widgets as $class_name ) {
            if ( class_exists( $class_name ) && method_exists( $widgets_manager, 'register' ) ) {
                $widgets_manager->register( new $class_name() );
            }
        }

        $this->elementor_widgets_registered = true;
    }

    /** Bool helper. */
    public function boolish( $value ) {
        return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true );
    }

    /** Sanitize scalar. */
    public function s( $value ) {
        return is_scalar( $value ) ? trim( (string) $value ) : '';
    }

    /** Merge defaults and ensure shortcode settings stay safe. */
    private function normalize( $atts, $defaults ) {
        $atts = is_array( $atts ) ? $atts : array();
        return wp_parse_args( $atts, $defaults );
    }

    public function shortcode_hero( $atts ) { $this->enqueue_assets(); return $this->render_hero( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_trust_strip( $atts ) { $this->enqueue_assets(); return $this->render_trust_strip( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_intro( $atts ) { $this->enqueue_assets(); return $this->render_intro( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_grid( $atts ) { $this->enqueue_assets(); return $this->render_grid( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_gallery( $atts ) { $this->enqueue_assets(); return $this->render_gallery( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_cta( $atts ) { $this->enqueue_assets(); return $this->render_cta( is_array( $atts ) ? $atts : array() ); }

    public function hero_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_primary_button' => '1',
            'show_secondary_button' => '1',
            'show_stats' => '1',
            'stats_mode' => 'dynamic',
            'stats_columns_desktop' => '2',
            'stats_columns_tablet' => '2',
            'stats_columns_mobile' => '2',
            'label' => 'SHG Groups',
            'title' => 'Meet the producer groups behind Amaley products',
            'accent' => 'Amaley products',
            'description' => 'Browse SHG and producer groups connected to Himalayan ingredients, product origins, members and village-level processing stories.',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'View Clusters',
            'secondary_url' => '/clusters/',
            'stat_1_value' => 'Auto',
            'stat_1_label' => 'SHG Groups',
            'stat_2_value' => 'Auto',
            'stat_2_label' => 'Linked Clusters',
            'stat_3_value' => 'Auto',
            'stat_3_label' => 'Producers',
            'stat_4_value' => 'Auto',
            'stat_4_label' => 'Mapped Products',
        );
    }

    public function trust_defaults() {
        return array(
            'show_section' => '1',
            'items' => "Source cluster|Which cluster this group belongs to.
Producer members|Linked members and contact context.
Mapped products|Products carrying this origin story.
Village work|Sorting, drying, preserving, blending and packing work.",
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
        );
    }

    public function intro_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => 'Source Network',
            'show_title' => '1',
            'show_description' => '1',
            'show_features' => '1',
            'label' => 'Source Network',
            'title' => 'How source groups make every product traceable.',
            'description' => 'Each group card connects a product story to its source cluster, village context, members, contact person and preparation work — so the origin stays visible and trustworthy.',
            'feature_1_title' => 'Source cluster',
            'feature_1_text' => 'Connects every group to its source Cluster.',
            'feature_2_title' => 'Members and contact',
            'feature_2_text' => 'Keeps member and contact context visible.',
            'feature_3_title' => 'Mapped products',
            'feature_3_text' => 'Shows products and ingredients connected to the group.',
        );
    }

    public function grid_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_images' => '1',
            'show_placeholder' => '1',
            'show_verification_badge' => '1',
            'show_cluster' => '1',
            'show_location' => '1',
            'show_member_count' => '1',
            'show_verification_detail' => '0',
            'show_contact' => '1',
            'show_story' => '1',
            'show_product_tags' => '1',
            'show_button' => '1',
            'card_template' => 'current_existing',
            'label' => 'SHG Directory',
            'title' => 'Browse SHG groups',
            'description' => 'A compact archive of SHG groups, linked clusters, members and product-origin work.',
            'limit' => '12',
            'cluster_id' => '',
            'featured_only' => '0',
            'show_only_website' => '0',
            'verification_status' => '',
            'order_by' => 'menu_order',
            'order' => 'ASC',
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
            'detail_url_pattern' => '/shg-detail/?shg_slug={slug}',
            'button_text' => 'Open SHG group',
            'empty_message' => 'No SHG groups found yet.',
            'max_tags' => '3',
            'story_word_limit' => '16',
        );
    }

    public function gallery_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'label' => 'Visual Story',
            'title' => 'Faces, ingredients and work behind the groups',
            'description' => 'A gallery-style section using SHG featured images and gallery photo URLs. Add images from the SHG Group edit screen to make this section richer.',
            'limit' => '8',
            'cluster_id' => '',
            'show_only_website' => '0',
            'featured_only' => '0',
            'verification_status' => '',
            'order_by' => 'menu_order',
            'order' => 'ASC',
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
            'show_caption' => '1',
            'empty_message' => 'Gallery images are not added yet. Add featured images or gallery URLs in SHG Group records.',
        );
    }

    public function cta_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_primary_button' => '1',
            'show_secondary_button' => '1',
            'label' => 'Work with Amaley',
            'title' => 'Bring verified SHG stories into your product shelves.',
            'description' => 'Use Amaley’s producer group mapping for hospitality shelves, conscious retail, gifting and origin-led storytelling.',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'Contact Amaley',
            'secondary_url' => '/contact/',
        );
    }

    public function render_hero( $atts = array() ) {
        $a = $this->normalize( $atts, $this->hero_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $title = $this->highlight_title( $a['title'], $a['accent'] );
        $out  = '<section class="amaley-core-shg-archive-section amaley-core-shg-archive-hero"><div class="amaley-core-shg-archive-wrap">';
        $out .= '<div class="amaley-core-shg-hero-copy">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="amaley-core-shg-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h1 class="amaley-core-shg-archive-title">' . $title . '</h1>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="amaley-core-shg-archive-desc">' . esc_html( $a['description'] ) . '</p>'; }
        if ( $this->boolish( $a['show_primary_button'] ) || $this->boolish( $a['show_secondary_button'] ) ) {
            $out .= '<div class="amaley-core-shg-hero-actions">';
            if ( $this->boolish( $a['show_primary_button'] ) ) { $out .= '<a class="amaley-core-shg-btn" href="' . esc_url( $a['primary_url'] ) . '">' . esc_html( $a['primary_text'] ) . '</a>'; }
            if ( $this->boolish( $a['show_secondary_button'] ) ) { $out .= '<a class="amaley-core-shg-btn-alt" href="' . esc_url( $a['secondary_url'] ) . '">' . esc_html( $a['secondary_text'] ) . '</a>'; }
            $out .= '</div>';
        }
        $out .= '</div>';
        if ( $this->boolish( $a['show_stats'] ) ) {
            $stats = $this->hero_stats( $a );
            $stats_style = '--acore-stats-cols:' . max( 1, absint( $a['stats_columns_desktop'] ?? 2 ) ) . ';--acore-stats-cols-tablet:' . max( 1, absint( $a['stats_columns_tablet'] ?? 2 ) ) . ';--acore-stats-cols-mobile:' . max( 1, absint( $a['stats_columns_mobile'] ?? 2 ) ) . ';';
            $out .= '<div class="amaley-core-shg-hero-panel" style="' . esc_attr( $stats_style ) . '">';
            foreach ( $stats as $stat ) {
                $out .= '<div class="amaley-core-shg-stat"><strong>' . esc_html( $stat[0] ) . '</strong><span>' . esc_html( $stat[1] ) . '</span></div>';
            }
            $out .= '</div>';
        }
        $out .= '</div></section>';
        return $out;
    }

    public function render_trust_strip( $atts = array() ) {
        $a = $this->normalize( $atts, $this->trust_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $style = '--acore-cols:' . absint( $a['columns_desktop'] ) . ';--acore-cols-tablet:' . absint( $a['columns_tablet'] ) . ';--acore-cols-mobile:' . absint( $a['columns_mobile'] ) . ';';
        $out = '<section class="amaley-core-shg-archive-section amaley-core-shg-trust"><div class="amaley-core-shg-archive-wrap"><div class="amaley-core-shg-trust-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $this->item_lines( $a['items'] ) as $item ) {
            $out .= '<div class="amaley-core-shg-trust-item"><strong>' . esc_html( $item[0] ) . '</strong><span>' . esc_html( $item[1] ) . '</span></div>';
        }
        $out .= '</div></div></section>';
        return $out;
    }

    public function render_intro( $atts = array() ) {
        $a = $this->normalize( $atts, $this->intro_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $out = '<section class="amaley-core-shg-archive-section amaley-core-shg-intro"><div class="amaley-core-shg-archive-wrap"><div class="amaley-core-shg-intro-grid"><div class="amaley-core-shg-intro-copy">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="amaley-core-shg-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="amaley-core-shg-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="amaley-core-shg-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= '</div>';
        if ( $this->boolish( $a['show_features'] ) ) {
            $out .= '<div class="amaley-core-shg-feature-grid">';
            for ( $i = 1; $i <= 3; $i++ ) {
                $out .= '<div class="amaley-core-shg-feature"><strong>' . esc_html( $a[ 'feature_' . $i . '_title' ] ) . '</strong><span>' . esc_html( $a[ 'feature_' . $i . '_text' ] ) . '</span></div>';
            }
            $out .= '</div>';
        }
        $out .= '</div></div></section>';
        return $out;
    }

    private function shg_archive_control_on( $a, $key, $default = '1' ) {
        $value = array_key_exists( $key, $a ) ? $a[ $key ] : $default;

        if ( is_bool( $value ) ) {
            return $value;
        }

        if ( is_numeric( $value ) ) {
            return 1 === absint( $value );
        }

        $value = strtolower( trim( (string) $value ) );

        return in_array( $value, array( '1', 'yes', 'true', 'on', 'show' ), true );
    }

    private function render_og_shg_archive_card( $shg, $a ) {
        $id = $shg->ID;
        $cluster_id = absint( get_post_meta( $id, '_amaley_shg_cluster_id', true ) );
        $cluster_title = $cluster_id ? get_the_title( $cluster_id ) : '';
        $village = get_post_meta( $id, '_amaley_village', true );
        $district = get_post_meta( $id, '_amaley_district', true );
        $contact = get_post_meta( $id, '_amaley_contact_person', true );
        $products = get_post_meta( $id, '_amaley_product_categories', true );
        if ( ! $products ) {
            $products = get_post_meta( $id, '_amaley_main_products', true );
        }
        $story = get_post_meta( $id, '_amaley_short_story', true );
        if ( '' === $story ) {
            $story = $shg->post_excerpt ? $shg->post_excerpt : wp_trim_words( wp_strip_all_tags( $shg->post_content ), 22 );
        }
        $verification = get_post_meta( $id, '_amaley_verification_status', true );
        $member_count = $this->count_members_for_shg( $id );
        $image = get_the_post_thumbnail_url( $id, 'large' );
        $url = str_replace( array( '{id}', '{slug}', '{cluster_id}' ), array( $id, $shg->post_name, $cluster_id ), (string) $a['detail_url_pattern'] );

        $has_media = $this->shg_archive_control_on( $a, 'show_images', '1' ) && ( $image || $this->shg_archive_control_on( $a, 'show_placeholder', '1' ) );
        $tags = $this->split_terms( $products, isset( $a['max_tags'] ) ? absint( $a['max_tags'] ) : 3 );

        $meta = array();
        if ( $this->shg_archive_control_on( $a, 'show_cluster', '1' ) && $cluster_title ) {
            $meta[] = array( 'label' => 'Cluster', 'value' => $cluster_title );
        }
        if ( $this->shg_archive_control_on( $a, 'show_location', '1' ) && ( $village || $district ) ) {
            $meta[] = array( 'label' => 'Location', 'value' => implode( ' · ', array_filter( array( $village, $district ) ) ) );
        }
        if ( $this->shg_archive_control_on( $a, 'show_member_count', '1' ) ) {
            $meta[] = array( 'label' => 'Members', 'value' => absint( $member_count ) );
        }
        if ( $this->shg_archive_control_on( $a, 'show_verification_detail', '0' ) ) {
            $meta[] = array( 'label' => 'Status', 'value' => $this->verification_label( $verification ) );
        }
        if ( $this->shg_archive_control_on( $a, 'show_contact', '1' ) && $contact ) {
            $meta[] = array( 'label' => 'Contact', 'value' => $contact, 'wide' => true );
        }

        $out = '<article class="amaley-card amaley-card--shg amaley-card--og-shg-card-1 amaley-card--shg-archive">';
        if ( $has_media ) {
            $out .= '<div class="amaley-card__media">';
            if ( $image ) {
                $out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title( $shg ) ) . '" loading="lazy" />';
            } else {
                $out .= '<span class="amaley-card__initials" aria-hidden="true">' . esc_html( $this->initials( get_the_title( $shg ) ) ) . '</span>';
            }
            if ( $this->shg_archive_control_on( $a, 'show_verification_badge', '1' ) ) {
                $out .= '<span class="amaley-card__badge">' . esc_html( $this->verification_label( $verification ) ) . '</span>';
            }
            $out .= '</div>';
        }

        $out .= '<div class="amaley-card__body">';
        $out .= '<p class="amaley-card__label">SHG</p>';
        if ( ! $has_media && $this->shg_archive_control_on( $a, 'show_verification_badge', '1' ) ) {
            $out .= '<span class="amaley-card__badge-inline">' . esc_html( $this->verification_label( $verification ) ) . '</span>';
        }
        $out .= '<h3 class="amaley-card__title">' . esc_html( get_the_title( $shg ) ) . '</h3>';

        if ( $this->shg_archive_control_on( $a, 'show_story', '1' ) && $story ) {
            $out .= '<p class="amaley-card__excerpt">' . esc_html( wp_trim_words( $story, max( 6, absint( $a['story_word_limit'] ?? 16 ) ) ) ) . '</p>';
        }

        if ( ! empty( $meta ) ) {
            $out .= '<div class="amaley-card__meta">';
            foreach ( $meta as $row ) {
                $wide = ! empty( $row['wide'] ) ? ' amaley-card__meta-item--wide' : '';
                $out .= '<div class="amaley-card__meta-item' . esc_attr( $wide ) . '"><span>' . esc_html( $row['label'] ) . '</span><strong>' . esc_html( $row['value'] ) . '</strong></div>';
            }
            $out .= '</div>';
        }

        if ( $this->shg_archive_control_on( $a, 'show_product_tags', '1' ) && ! empty( $tags ) ) {
            $out .= '<div class="amaley-card__tags">';
            foreach ( $tags as $tag ) {
                $out .= '<span>' . esc_html( $tag ) . '</span>';
            }
            $out .= '</div>';
        }

        if ( $this->shg_archive_control_on( $a, 'show_button', '1' ) ) {
            $out .= '<a class="amaley-card__button" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ) . '</a>';
        }

        $out .= '</div></article>';
        return $out;
    }

    public function render_grid( $atts = array() ) {
        $a = $this->normalize( $atts, $this->grid_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $items = $this->get_shgs( $a );
        $style = '--acore-cols:' . absint( $a['columns_desktop'] ) . ';--acore-cols-tablet:' . absint( $a['columns_tablet'] ) . ';--acore-cols-mobile:' . absint( $a['columns_mobile'] ) . ';';
        $use_og_card = 'og_card_1' === sanitize_key( isset( $a['card_template'] ) ? $a['card_template'] : 'current_existing' );
        $out = '<section class="amaley-core-shg-archive-section amaley-core-shg-grid-section' . ( $use_og_card ? ' amaley-core-shg-grid-section-og' : '' ) . '"><div class="amaley-core-shg-archive-wrap"><div class="amaley-core-shg-grid-head"><div>';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="amaley-core-shg-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="amaley-core-shg-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="amaley-core-shg-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= '</div></div>';
        if ( empty( $items ) ) {
            return $out . '<div class="amaley-core-shg-empty">' . esc_html( $a['empty_message'] ) . '</div></div></section>';
        }
        $out .= '<div class="amaley-core-shg-cards-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $items as $shg ) {
            $out .= $use_og_card ? $this->render_og_shg_archive_card( $shg, $a ) : $this->render_card( $shg, $a );
        }
        $out .= '</div></div></section>';
        return $out;
    }


    public function render_gallery( $atts = array() ) {
        $a = $this->normalize( $atts, $this->gallery_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $items = $this->get_gallery_items( $a );
        $style = '--acore-cols:' . absint( $a['columns_desktop'] ) . ';--acore-cols-tablet:' . absint( $a['columns_tablet'] ) . ';--acore-cols-mobile:' . absint( $a['columns_mobile'] ) . ';';
        $out = '<section class="amaley-core-shg-archive-section amaley-core-shg-gallery-section"><div class="amaley-core-shg-archive-wrap">';
        $out .= '<div class="amaley-core-shg-gallery-head">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="amaley-core-shg-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="amaley-core-shg-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="amaley-core-shg-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= '</div>';
        if ( empty( $items ) ) { return $out . '<div class="amaley-core-shg-empty">' . esc_html( $a['empty_message'] ) . '</div></div></section>'; }
        $out .= '<div class="amaley-core-shg-gallery-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $items as $item ) {
            $out .= '<figure class="amaley-core-shg-gallery-card"><img src="' . esc_url( $item['url'] ) . '" alt="' . esc_attr( $item['title'] ) . '" loading="lazy" />';
            if ( $this->boolish( $a['show_caption'] ) ) { $out .= '<figcaption><span>SHG</span><strong>' . esc_html( $item['title'] ) . '</strong></figcaption>'; }
            $out .= '</figure>';
        }
        $out .= '</div></div></section>';
        return $out;
    }

    public function render_cta( $atts = array() ) {
        $a = $this->normalize( $atts, $this->cta_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $out = '<section class="amaley-core-shg-archive-section amaley-core-shg-cta"><div class="amaley-core-shg-archive-wrap"><div class="amaley-core-shg-cta-inner">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="amaley-core-shg-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="amaley-core-shg-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="amaley-core-shg-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        if ( $this->boolish( $a['show_primary_button'] ) || $this->boolish( $a['show_secondary_button'] ) ) {
            $out .= '<div class="amaley-core-shg-hero-actions">';
            if ( $this->boolish( $a['show_primary_button'] ) ) { $out .= '<a class="amaley-core-shg-btn" href="' . esc_url( $a['primary_url'] ) . '">' . esc_html( $a['primary_text'] ) . '</a>'; }
            if ( $this->boolish( $a['show_secondary_button'] ) ) { $out .= '<a class="amaley-core-shg-btn-alt" href="' . esc_url( $a['secondary_url'] ) . '">' . esc_html( $a['secondary_text'] ) . '</a>'; }
            $out .= '</div>';
        }
        return $out . '</div></div></section>';
    }

    private function get_shgs( $a ) {
        $meta_query = array();
        if ( $this->boolish( $a['show_only_website'] ) ) { $meta_query[] = array( 'key' => '_amaley_show_on_website', 'value' => '1', 'compare' => '=' ); }
        if ( $this->boolish( $a['featured_only'] ) ) { $meta_query[] = array( 'key' => '_amaley_featured', 'value' => '1', 'compare' => '=' ); }
        if ( ! empty( $a['cluster_id'] ) ) { $meta_query[] = array( 'key' => '_amaley_shg_cluster_id', 'value' => absint( $a['cluster_id'] ), 'compare' => '=' ); }
        if ( ! empty( $a['verification_status'] ) ) { $meta_query[] = array( 'key' => '_amaley_verification_status', 'value' => sanitize_key( $a['verification_status'] ), 'compare' => '=' ); }
        $args = array( 'post_type' => 'amaley_shg_group', 'post_status' => array( 'publish' ), 'posts_per_page' => max( 1, absint( $a['limit'] ) ), 'orderby' => $this->orderby( $a['order_by'] ), 'order' => 'DESC' === strtoupper( $a['order'] ) ? 'DESC' : 'ASC' );
        if ( ! empty( $meta_query ) ) { $args['meta_query'] = $meta_query; }
        if ( 'menu_order' === $a['order_by'] ) {
            // Use native menu_order/title ordering. Do not require _amaley_display_order meta,
            // because existing SHG records may not have that key and would be hidden by an inner meta join.
            $args['orderby'] = 'menu_order title';
        }
        return get_posts( $args );
    }

    private function render_card( $shg, $a ) {
        $id = $shg->ID;
        $cluster_id = absint( get_post_meta( $id, '_amaley_shg_cluster_id', true ) );
        $cluster_title = $cluster_id ? get_the_title( $cluster_id ) : '';
        $village = get_post_meta( $id, '_amaley_village', true );
        $district = get_post_meta( $id, '_amaley_district', true );
        $contact = get_post_meta( $id, '_amaley_contact_person', true );
        $products = get_post_meta( $id, '_amaley_product_categories', true );
        $story = get_post_meta( $id, '_amaley_short_story', true );
        $verification = get_post_meta( $id, '_amaley_verification_status', true );
        $member_count = $this->count_members_for_shg( $id );
        $image = get_the_post_thumbnail_url( $id, 'large' );
        $url = str_replace( array( '{id}', '{slug}', '{cluster_id}' ), array( $id, $shg->post_name, $cluster_id ), (string) $a['detail_url_pattern'] );
        if ( '' === $story ) { $story = $shg->post_excerpt ? $shg->post_excerpt : wp_trim_words( wp_strip_all_tags( $shg->post_content ), 22 ); }

        $has_image_area = $this->boolish( $a['show_images'] ) && ( $image || $this->boolish( $a['show_placeholder'] ) );
        $out = '<article class="amaley-core-shg-archive-card' . ( ! $has_image_area ? ' amaley-core-shg-card-no-image' : '' ) . '">';
        if ( $has_image_area ) {
            $out .= '<div class="amaley-core-shg-archive-image">';
            $out .= $image ? '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title( $shg ) ) . '" loading="lazy" />' : '<span class="amaley-core-shg-image-mark" aria-hidden="true">' . esc_html( $this->initials( get_the_title( $shg ) ) ) . '</span>';
            if ( $this->boolish( $a['show_verification_badge'] ) ) { $out .= '<span class="amaley-core-shg-badge">' . esc_html( $this->verification_label( $verification ) ) . '</span>'; }
            $out .= '</div>';
        }

        $out .= '<div class="amaley-core-shg-archive-body">';
        $out .= '<span class="amaley-core-shg-card-label">SHG</span>';
        if ( ! $has_image_area && $this->boolish( $a['show_verification_badge'] ) ) { $out .= '<span class="amaley-core-shg-badge-inline">' . esc_html( $this->verification_label( $verification ) ) . '</span>'; }
        $out .= '<h3>' . esc_html( get_the_title( $shg ) ) . '</h3>';
        if ( $this->boolish( $a['show_story'] ) && $story ) { $out .= '<p class="amaley-core-shg-card-desc">' . esc_html( wp_trim_words( $story, max( 6, absint( $a['story_word_limit'] ?? 16 ) ) ) ) . '</p>'; }

        $rows = array();
        if ( $this->boolish( $a['show_cluster'] ) && $cluster_title ) { $rows[] = array( 'Cluster', $cluster_title ); }
        if ( $this->boolish( $a['show_location'] ) && ( $village || $district ) ) { $rows[] = array( 'Location', implode( ' · ', array_filter( array( $village, $district ) ) ) ); }
        if ( $this->boolish( $a['show_member_count'] ) ) { $rows[] = array( 'Members', absint( $member_count ) ); }
        if ( $this->boolish( $a['show_verification_detail'] ) && ! $this->boolish( $a['show_verification_badge'] ) ) { $rows[] = array( 'Status', $this->verification_label( $verification ) ); }
        if ( $this->boolish( $a['show_contact'] ) && $contact ) { $rows[] = array( 'Contact', $contact ); }
        if ( ! empty( $rows ) ) {
            $out .= '<dl class="amaley-core-shg-detail-grid">';
            foreach ( $rows as $row ) { $out .= '<div><dt>' . esc_html( $row[0] ) . '</dt><dd>' . esc_html( $row[1] ) . '</dd></div>'; }
            $out .= '</dl>';
        }

        if ( $this->boolish( $a['show_product_tags'] ) && $products ) {
            $out .= '<div class="amaley-core-shg-products">';
            foreach ( $this->split_terms( $products, isset( $a['max_tags'] ) ? absint( $a['max_tags'] ) : 4 ) as $product ) { $out .= '<span>' . esc_html( $product ) . '</span>'; }
            $out .= '</div>';
        }
        if ( $this->boolish( $a['show_button'] ) ) { $out .= '<a class="amaley-core-shg-archive-btn" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ) . '</a>'; }
        $out .= '</div></article>';
        return $out;
    }


    private function get_gallery_items( $a ) {
        $posts = $this->get_shgs( array_merge( $a, array( 'limit' => max( 1, absint( $a['limit'] ) ) ) ) );
        $items = array();
        foreach ( $posts as $post ) {
            $urls = $this->gallery_urls_for_post( $post->ID );
            foreach ( $urls as $url ) {
                $items[] = array( 'url' => $url, 'title' => get_the_title( $post ) );
                if ( count( $items ) >= absint( $a['limit'] ) ) { break 2; }
            }
        }
        return $items;
    }

    private function gallery_urls_for_post( $post_id ) {
        $urls = array();
        $featured = get_the_post_thumbnail_url( $post_id, 'large' );
        if ( $featured ) { $urls[] = esc_url_raw( $featured ); }
        $gallery = get_post_meta( $post_id, '_amaley_gallery_urls', true );
        foreach ( preg_split( '/
|
|
|,/', (string) $gallery ) as $url ) {
            $url = trim( $url );
            if ( $url && filter_var( $url, FILTER_VALIDATE_URL ) ) { $urls[] = esc_url_raw( $url ); }
        }
        return array_values( array_unique( $urls ) );
    }

    private function hero_stats( $a ) {
        $old_values = array( 'local', 'origin', 'small', 'care' );
        $use_dynamic = ! isset( $a['stats_mode'] ) || 'dynamic' === (string) $a['stats_mode'] || in_array( strtolower( trim( (string) $a['stat_1_value'] ) ), $old_values, true );
        if ( ! $use_dynamic && 'manual' === (string) ( $a['stats_mode'] ?? '' ) ) {
            $stats = array();
            for ( $i = 1; $i <= 4; $i++ ) { $stats[] = array( $a[ 'stat_' . $i . '_value' ], $a[ 'stat_' . $i . '_label' ] ); }
            return $stats;
        }
        $counts = $this->network_counts();
        return array(
            array( $counts['shgs'], 'SHG Groups' ),
            array( $counts['clusters'], 'Linked Clusters' ),
            array( $counts['members'], 'Producers' ),
            array( $counts['products'], 'Mapped Products' ),
        );
    }

    private function network_counts() {
        $shg_ids = get_posts( array( 'post_type' => 'amaley_shg_group', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids' ) );
        $cluster_ids = array();
        foreach ( $shg_ids as $sid ) { $cid = absint( get_post_meta( $sid, '_amaley_shg_cluster_id', true ) ); if ( $cid ) { $cluster_ids[] = $cid; } }
        $member_count = 0;
        if ( post_type_exists( 'amaley_member' ) ) {
            $member_q = new WP_Query( array( 'post_type' => 'amaley_member', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids' ) );
            $member_count = absint( $member_q->found_posts );
        }
        $product_count = 0;
        if ( post_type_exists( 'product' ) ) {
            $product_q = new WP_Query( array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'fields' => 'ids',
                'meta_query' => array(
                    'relation' => 'OR',
                    array( 'key' => '_amaley_origin_cluster_id', 'compare' => 'EXISTS' ),
                    array( 'key' => '_amaley_origin_shg_ids', 'compare' => 'EXISTS' ),
                ),
            ) );
            $product_count = absint( $product_q->found_posts );
        }
        return array( 'shgs' => count( $shg_ids ), 'clusters' => count( array_unique( $cluster_ids ) ), 'members' => $member_count, 'products' => $product_count );
    }

    private function initials( $title ) {
        $words = preg_split( '/\s+/', trim( wp_strip_all_tags( (string) $title ) ) );
        $letters = '';
        foreach ( $words as $word ) { if ( '' !== $word ) { $letters .= mb_substr( $word, 0, 1 ); } if ( mb_strlen( $letters ) >= 2 ) { break; } }
        return $letters ? mb_strtoupper( $letters ) : 'SH';
    }

    private function count_members_for_shg( $shg_id ) {
        $q = new WP_Query( array( 'post_type' => 'amaley_member', 'post_status' => array( 'publish' ), 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_amaley_member_shg_id', 'value' => absint( $shg_id ), 'compare' => '=' ) ) ) );
        return absint( $q->found_posts );
    }

    private function item_lines( $value ) {
        $rows = preg_split( '/\r\n|\r|\n/', (string) $value );
        $items = array();
        foreach ( $rows as $row ) { $parts = array_map( 'trim', explode( '|', $row, 2 ) ); if ( ! empty( $parts[0] ) ) { $items[] = array( $parts[0], isset( $parts[1] ) ? $parts[1] : '' ); } }
        return $items;
    }

    private function split_terms( $text, $limit = 4 ) { $terms = preg_split( '/[\n,]+/', (string) $text ); return array_slice( array_values( array_filter( array_map( 'trim', $terms ) ) ), 0, max( 1, absint( $limit ) ) ); }
    private function orderby( $value ) { $allowed = array( 'title', 'date', 'modified', 'menu_order', 'rand' ); return in_array( $value, $allowed, true ) ? $value : 'title'; }
    private function verification_label( $value ) { $labels = array( 'verified' => 'Verified', 'pending' => 'Pending', 'review' => 'Review' ); $key = sanitize_key( $value ); return isset( $labels[ $key ] ) ? $labels[ $key ] : 'Verified'; }
    private function highlight_title( $title, $accent ) { $safe = esc_html( $this->s( $title ) ); $accent = $this->s( $accent ); if ( '' === $accent ) { return $safe; } return str_replace( esc_html( $accent ), '<em>' . esc_html( $accent ) . '</em>', $safe ); }
}
