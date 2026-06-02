<?php
/**
 * Member / Producer Archive section widgets renderer.
 *
 * Clean rebuild from v1.0.74 baseline. v1.0.76.2 adds member archive grid card micro-controls only. Scoped member archive only.
 * v1.0.99.3: Adds lightweight OG Member Card 1 selector/render path without heavy Elementor style mapping.
 * v1.0.99.4: Bridges OG Member Card 1 markup to existing Member Archive hide/show + style controls without adding new controls.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Member_Archive_Sections {
    /** Prevent duplicate Elementor widget registration. */
    private $elementor_widgets_registered = false;

    /** Constructor. */
    public function __construct() {
        $GLOBALS['amaley_core_member_archive_sections'] = $this;

        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );

        add_shortcode( 'amaley_member_archive_hero', array( $this, 'shortcode_hero' ) );
        add_shortcode( 'amaley_member_archive_trust_strip', array( $this, 'shortcode_trust_strip' ) );
        add_shortcode( 'amaley_member_archive_intro', array( $this, 'shortcode_intro' ) );
        add_shortcode( 'amaley_member_archive_grid', array( $this, 'shortcode_grid' ) );
        add_shortcode( 'amaley_member_archive_gallery', array( $this, 'shortcode_gallery' ) );
        add_shortcode( 'amaley_manual_gallery_section', array( $this, 'shortcode_manual_gallery' ) );
        add_shortcode( 'amaley_member_archive_cta', array( $this, 'shortcode_cta' ) );

        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );
    }

    /** Register stylesheet. */
    public function register_assets() {
        wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        wp_register_style( 'amaley-core-member-archive-sections', AMALEY_CORE_URL . 'assets/amaley-core-member-archive-sections.css', array( 'amaley-core-cards' ), AMALEY_CORE_VERSION );
    }

    /** Enqueue stylesheet. */
    public function enqueue_assets() {
        if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        }
        wp_enqueue_style( 'amaley-core-cards' );
        wp_enqueue_style( 'amaley-core-member-archive-sections' );
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
            'class-amaley-core-member-archive-hero-widget.php',
            'class-amaley-core-member-archive-trust-strip-widget.php',
            'class-amaley-core-member-archive-intro-widget.php',
            'class-amaley-core-member-archive-grid-widget.php',
            'class-amaley-core-member-archive-gallery-widget.php',
            'class-amaley-core-manual-gallery-widget.php',
            'class-amaley-core-member-archive-cta-widget.php',
        );

        foreach ( $files as $file_name ) {
            $file = AMALEY_CORE_PATH . 'includes/widgets/' . $file_name;
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }

        $widgets = array(
            'Amaley_Core_Member_Archive_Hero_Widget',
            'Amaley_Core_Member_Archive_Trust_Strip_Widget',
            'Amaley_Core_Member_Archive_Intro_Widget',
            'Amaley_Core_Member_Archive_Grid_Widget',
            'Amaley_Core_Member_Archive_Gallery_Widget',
            'Amaley_Core_Manual_Gallery_Widget',
            'Amaley_Core_Member_Archive_CTA_Widget',
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

    /** Merge defaults safely. */
    private function normalize( $atts, $defaults ) {
        $atts = is_array( $atts ) ? $atts : array();
        return wp_parse_args( $atts, $defaults );
    }

    /** Shortcode wrappers. */
    public function shortcode_hero( $atts ) { $this->enqueue_assets(); return $this->render_hero( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_trust_strip( $atts ) { $this->enqueue_assets(); return $this->render_trust_strip( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_intro( $atts ) { $this->enqueue_assets(); return $this->render_intro( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_grid( $atts ) { $this->enqueue_assets(); return $this->render_grid( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_gallery( $atts ) { $this->enqueue_assets(); return $this->render_gallery( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_manual_gallery( $atts ) { $this->enqueue_assets(); return $this->render_manual_gallery( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_cta( $atts ) { $this->enqueue_assets(); return $this->render_cta( is_array( $atts ) ? $atts : array() ); }

    /** Hero defaults. */
    public function hero_defaults() {
        return array(
            'show_section' => '1',
            'show_breadcrumb' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_accent' => '1',
            'show_description' => '1',
            'show_primary_button' => '1',
            'show_secondary_button' => '1',
            'show_stats' => '1',
            'show_stat_value' => '1',
            'show_stat_label' => '1',
            'breadcrumb' => 'Home / SHG Groups / Producers',
            'label' => 'Producer Profiles',
            'title' => 'Meet the hands behind Amaley products',
            'accent' => 'Amaley products',
            'description' => 'Browse members and producers connected to SHG groups, source clusters, village skills and product-origin stories.',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'View SHG Groups',
            'secondary_url' => '/shg-groups/',
            'stats_mode' => 'dynamic',
            'stats_columns_desktop' => '2',
            'stats_columns_tablet' => '2',
            'stats_columns_mobile' => '2',
            'stat_1_value' => 'Auto',
            'stat_1_label' => 'Producers',
            'stat_2_value' => 'Auto',
            'stat_2_label' => 'Linked SHGs',
            'stat_3_value' => 'Auto',
            'stat_3_label' => 'Clusters',
            'stat_4_value' => 'Auto',
            'stat_4_label' => 'Products',
        );
    }

    /** Trust strip defaults. */
    public function trust_defaults() {
        return array(
            'show_section' => '1',
            'items' => "Producer profiles|People behind collection, sorting, drying and preparation work.\nLinked SHGs|Each producer can connect to a source SHG group.\nVillage skills|Role, village and skills remain visible.\nProduct origin|Mapped products can show who contributed to the origin story.",
            'show_icon' => '1',
            'show_item_title' => '1',
            'show_item_text' => '1',
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
        );
    }

    /** Intro defaults. */
    public function intro_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_features' => '1',
            'show_feature_1' => '1',
            'show_feature_2' => '1',
            'show_feature_3' => '1',
            'label' => 'Human Layer',
            'title' => 'Producers make origin traceable at ground level.',
            'description' => 'Clusters explain geography and products. SHG groups explain collective work. Member profiles bring the actual people, roles and skills into the product story.',
            'feature_1_title' => 'Role',
            'feature_1_text' => 'Collector, sorter, processor, handler or maker.',
            'feature_2_title' => 'Place',
            'feature_2_text' => 'Village and source group connection.',
            'feature_3_title' => 'Products',
            'feature_3_text' => 'Products and skills connected to the person.',
        );
    }

    /** Grid defaults. */
    public function grid_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_card_label' => '1',
            'card_label_text' => 'Producer',
            'label' => 'Producer Directory',
            'title' => 'Browse members and producers',
            'description' => 'A controlled, section-wise archive of producer/member profiles connected to SHGs and products.',
            'limit' => '12',
            'shg_id' => '',
            'cluster_id' => '',
            'featured_only' => '0',
            'show_only_website' => '0',
            'status' => '',
            'order_by' => 'menu_order',
            'order' => 'ASC',
            'include_ids' => '',
            'exclude_ids' => '',
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
            'show_image' => '1',
            'show_placeholder' => '1',
            'show_role' => '1',
            'show_village' => '1',
            'show_shg' => '1',
            'show_cluster' => '0',
            'show_skills' => '1',
            'show_products' => '0',
            'show_bio' => '0',
            'show_button' => '1',
            'card_template' => 'current_existing',
            'button_text' => 'View Producer Profile',
            'detail_url_pattern' => '/producer-detail/?member_slug={slug}',
            'max_tags' => '3',
            'max_skill_tags' => '3',
            'max_product_tags' => '0',
            'bio_word_limit' => '16',
            'show_section_button' => '1',
            'section_button_text' => 'View All Producers',
            'section_button_url' => '/producers/',
            'empty_message' => 'No producer/member profiles found yet.',
        );
    }

    /** Gallery defaults. */
    public function gallery_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_caption' => '1',
            'show_empty_fallback' => '1',
            'gallery_source' => 'manual',
            'manual_gallery' => array(),
            'manual_caption_source' => 'attachment_title',
            'caption_label' => 'Producer Visual',
            'label' => 'Producer Gallery',
            'title' => 'Images from the people behind the work',
            'description' => 'Visual references from producer profiles, SHG work, products and field stories.',
            'limit' => '6',
            'shg_id' => '',
            'cluster_id' => '',
            'featured_only' => '0',
            'show_only_website' => '0',
            'status' => '',
            'order_by' => 'menu_order',
            'order' => 'ASC',
            'columns_desktop' => '3',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
            'empty_message' => 'Photos can be added from member records.',
        );
    }

    /** Generic manual gallery defaults for reusable archive/page sections. */
    public function manual_gallery_defaults() {
        $defaults = $this->gallery_defaults();
        $defaults['gallery_source'] = 'manual';
        $defaults['manual_caption_source'] = 'attachment_title';
        $defaults['label'] = 'Gallery';
        $defaults['title'] = 'Images from Amaley stories';
        $defaults['description'] = 'Manual visual references selected in Elementor for this page section.';
        $defaults['caption_label'] = 'Amaley Visual';
        $defaults['empty_message'] = 'Add gallery images from the Elementor panel.';
        $defaults['columns_desktop'] = '3';
        $defaults['columns_tablet'] = '2';
        $defaults['columns_mobile'] = '1';
        return $defaults;
    }

    /** CTA defaults. */
    public function cta_defaults() {
        return array(
            'show_section' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_description' => '1',
            'show_primary_button' => '1',
            'show_secondary_button' => '1',
            'label' => 'Work with Amaley',
            'title' => 'Build product stories around verified producer profiles.',
            'description' => 'Use Amaley producer visibility for conscious retail, gifting, hospitality counters and origin-led storytelling.',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'Contact Amaley',
            'secondary_url' => '/contact/',
        );
    }

    /** Render hero. */
    public function render_hero( $atts = array() ) {
        $a = $this->normalize( $atts, $this->hero_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $stats = $this->hero_stats( $a );
        $stats_style = '--ampa-stat-cols:' . max( 1, absint( $a['stats_columns_desktop'] ) ) . ';--ampa-stat-cols-tablet:' . max( 1, absint( $a['stats_columns_tablet'] ) ) . ';--ampa-stat-cols-mobile:' . max( 1, absint( $a['stats_columns_mobile'] ) ) . ';';
        $out  = '<section class="ampa-section ampa-hero"><div class="ampa-wrap ampa-hero-grid">';
        $out .= '<div class="ampa-hero-copy">';
        if ( $this->boolish( $a['show_breadcrumb'] ) ) { $out .= '<p class="ampa-breadcrumb">' . esc_html( $a['breadcrumb'] ) . '</p>'; }
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="ampa-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h1 class="ampa-title">' . esc_html( $a['title'] ); if ( $this->boolish( $a['show_accent'] ) && ! empty( $a['accent'] ) ) { $out .= ' <em>' . esc_html( $a['accent'] ) . '</em>'; } $out .= '</h1>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="ampa-description">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= $this->render_button_group( $a, 'primary_text', 'primary_url', 'secondary_text', 'secondary_url', 'show_primary_button', 'show_secondary_button' );
        $out .= '</div>';
        if ( $this->boolish( $a['show_stats'] ) ) {
            $out .= '<div class="ampa-hero-panel" style="' . esc_attr( $stats_style ) . '">';
            foreach ( $stats as $stat ) {
                $out .= '<div class="ampa-hero-stat">';
                if ( $this->boolish( $a['show_stat_value'] ?? '1' ) ) { $out .= '<strong>' . esc_html( $stat[0] ) . '</strong>'; }
                if ( $this->boolish( $a['show_stat_label'] ?? '1' ) ) { $out .= '<span>' . esc_html( $stat[1] ) . '</span>'; }
                $out .= '</div>';
            }
            $out .= '</div>';
        }
        $out .= '</div></section>';
        return $out;
    }

    /** Render trust strip. */
    public function render_trust_strip( $atts = array() ) {
        $a = $this->normalize( $atts, $this->trust_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $style = '--ampa-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--ampa-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--ampa-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';
        $out = '<section class="ampa-section ampa-trust"><div class="ampa-wrap"><div class="ampa-trust-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $this->item_lines( $a['items'] ) as $item ) {
            $out .= '<div class="ampa-trust-card">';
            if ( $this->boolish( $a['show_icon'] ?? '1' ) ) { $out .= '<span></span>'; }
            if ( $this->boolish( $a['show_item_title'] ?? '1' ) ) { $out .= '<strong>' . esc_html( $item[0] ) . '</strong>'; }
            if ( $this->boolish( $a['show_item_text'] ?? '1' ) ) { $out .= '<p>' . esc_html( $item[1] ) . '</p>'; }
            $out .= '</div>';
        }
        $out .= '</div></div></section>';
        return $out;
    }

    /** Render intro. */
    public function render_intro( $atts = array() ) {
        $a = $this->normalize( $atts, $this->intro_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $out = '<section class="ampa-section ampa-intro"><div class="ampa-wrap ampa-intro-grid"><div class="ampa-intro-copy">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="ampa-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="ampa-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="ampa-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= '</div>';
        if ( $this->boolish( $a['show_features'] ) ) {
            $out .= '<div class="ampa-feature-grid">';
            for ( $i = 1; $i <= 3; $i++ ) {
                if ( ! $this->boolish( $a[ 'show_feature_' . $i ] ?? '1' ) ) { continue; }
                $out .= '<div class="ampa-feature-card"><strong>' . esc_html( $a[ 'feature_' . $i . '_title' ] ) . '</strong><p>' . esc_html( $a[ 'feature_' . $i . '_text' ] ) . '</p></div>';
            }
            $out .= '</div>';
        }
        $out .= '</div></section>';
        return $out;
    }

    /** Render grid. */
    private function member_archive_control_on( $a, $key, $default = '1' ) {
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

    private function render_og_member_archive_card_light( $member, $a ) {
        $id = $member->ID;
        $title = get_the_title( $member );

        $shg_id = absint( get_post_meta( $id, '_amaley_member_shg_id', true ) );
        $shg = $shg_id ? get_the_title( $shg_id ) : '';

        $cluster_id = $shg_id ? absint( get_post_meta( $shg_id, '_amaley_shg_cluster_id', true ) ) : 0;
        $cluster = $cluster_id ? get_the_title( $cluster_id ) : '';

        $role = get_post_meta( $id, '_amaley_role', true );
        $village = get_post_meta( $id, '_amaley_village', true );
        $skills = get_post_meta( $id, '_amaley_skills', true );
        $products = get_post_meta( $id, '_amaley_products_handled', true );
        $bio = get_post_meta( $id, '_amaley_short_bio', true );

        if ( '' === trim( (string) $bio ) ) {
            $bio = wp_trim_words( wp_strip_all_tags( get_post_meta( $id, '_amaley_story', true ) ), 24 );
        }

        $image = get_the_post_thumbnail_url( $id, 'large' );
        if ( ! $image ) {
            $image = get_post_meta( $id, '_amaley_photo_url', true );
        }

        $url = str_replace(
            array( '{id}', '{slug}', '{shg_id}', '{cluster_id}' ),
            array( $id, $member->post_name, $shg_id, $cluster_id ),
            (string) $a['detail_url_pattern']
        );

        $has_media = $this->member_archive_control_on( $a, 'show_image', '1' ) && ( $image || $this->member_archive_control_on( $a, 'show_placeholder', '1' ) );

        $rows = array();

        if ( $this->member_archive_control_on( $a, 'show_role', '1' ) && $role ) {
            $rows[] = array( 'Role', $role );
        }

        if ( $this->member_archive_control_on( $a, 'show_village', '1' ) && $village ) {
            $rows[] = array( 'Village', $village );
        }

        if ( $this->member_archive_control_on( $a, 'show_shg', '1' ) && $shg ) {
            $rows[] = array( 'SHG', $shg );
        }

        if ( $this->member_archive_control_on( $a, 'show_cluster', '0' ) && $cluster ) {
            $rows[] = array( 'Cluster', $cluster );
        }

        $tags = array();
        $skill_limit = array_key_exists( 'max_skill_tags', $a ) ? absint( $a['max_skill_tags'] ) : absint( $a['max_tags'] );
        $product_limit = array_key_exists( 'max_product_tags', $a ) ? absint( $a['max_product_tags'] ) : 0;

        if ( $this->member_archive_control_on( $a, 'show_skills', '1' ) && $skill_limit > 0 ) {
            $tags = array_merge( $tags, $this->split_terms( $skills, $skill_limit ) );
        }

        if ( $this->member_archive_control_on( $a, 'show_products', '0' ) && $product_limit > 0 ) {
            $tags = array_merge( $tags, $this->split_terms( $products, $product_limit ) );
        }

        $fallback_limit = absint( $a['max_tags'] ?? 3 );
        $total_limit = max( 0, $skill_limit + $product_limit );

        if ( 0 === $total_limit && $fallback_limit > 0 ) {
            $total_limit = $fallback_limit;
        }

        $tags = array_slice( array_values( array_unique( array_filter( $tags ) ) ), 0, $total_limit );

        $out = '<article class="amaley-card ampa-member-card amaley-card--member amaley-card--og-member-card-1 amaley-card--member-archive-light' . ( ! $has_media ? ' amaley-card--no-media' : '' ) . '">';

        if ( $has_media ) {
            $out .= '<div class="amaley-card__media ampa-member-media">';
            if ( $image ) {
                $out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />';
            } else {
                $out .= '<span class="amaley-card__initials ampa-member-initials" aria-hidden="true">' . esc_html( $this->initials( $title ) ) . '</span>';
            }
            $out .= '</div>';
        }

        $out .= '<div class="amaley-card__body ampa-member-body">';

        if ( $this->member_archive_control_on( $a, 'show_card_label', '1' ) ) {
            $out .= '<p class="amaley-card__label ampa-card-label">' . esc_html( $a['card_label_text'] ?? 'Producer' ) . '</p>';
        }

        $out .= '<h3 class="amaley-card__title ampa-card-title">' . esc_html( $title ) . '</h3>';

        if ( $this->member_archive_control_on( $a, 'show_bio', '0' ) && $bio ) {
            $out .= '<p class="amaley-card__excerpt ampa-card-desc">' . esc_html( wp_trim_words( $bio, max( 6, absint( $a['bio_word_limit'] ) ) ) ) . '</p>';
        }

        if ( ! empty( $rows ) ) {
            $out .= '<div class="amaley-card__meta ampa-card-meta">';
            foreach ( $rows as $row ) {
                $out .= '<div class="amaley-card__meta-item"><dt>' . esc_html( $row[0] ) . '</dt><dd>' . esc_html( $row[1] ) . '</dd></div>';
            }
            $out .= '</div>';
        }

        if ( ! empty( $tags ) ) {
            $out .= '<div class="amaley-card__tags ampa-chip-row" aria-label="Member skills and product chips">';
            foreach ( $tags as $tag ) {
                $out .= '<span>' . esc_html( $tag ) . '</span>';
            }
            $out .= '</div>';
        }

        if ( $this->member_archive_control_on( $a, 'show_button', '1' ) ) {
            $out .= '<a class="amaley-card__button ampa-card-button" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ) . '</a>';
        }

        $out .= '</div></article>';

        return $out;
    }

    public function render_grid( $atts = array() ) {
        $a = $this->normalize( $atts, $this->grid_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $items = $this->get_members( $a );
        $style = '--ampa-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--ampa-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--ampa-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';
        $use_og_card = 'og_card_1' === sanitize_key( isset( $a['card_template'] ) ? $a['card_template'] : 'current_existing' );
        $out = '<section class="ampa-section ampa-grid-section' . ( $use_og_card ? ' ampa-grid-section-og-light' : '' ) . '"><div class="ampa-wrap">';
        $out .= '<div class="ampa-section-head">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="ampa-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="ampa-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="ampa-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= '</div>';
        if ( empty( $items ) ) { return $out . '<div class="ampa-empty">' . esc_html( $a['empty_message'] ) . '</div></div></section>'; }
        $out .= '<div class="ampa-card-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $items as $member ) { $out .= $use_og_card ? $this->render_og_member_archive_card_light( $member, $a ) : $this->render_member_card( $member, $a ); }
        $out .= '</div>';
        if ( $this->boolish( $a['show_section_button'] ) && ! empty( $a['section_button_text'] ) ) { $out .= '<div class="ampa-section-actions"><a class="ampa-section-button" href="' . esc_url( $a['section_button_url'] ) . '">' . esc_html( $a['section_button_text'] ) . '</a></div>'; }
        $out .= '</div></section>';
        return $out;
    }

    /** Render gallery. */
    public function render_gallery( $atts = array() ) {
        $a = $this->normalize( $atts, $this->gallery_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $items = $this->get_gallery_items( $a );
        $style = '--ampa-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--ampa-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--ampa-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';
        $out = '<section class="ampa-section ampa-gallery-section"><div class="ampa-wrap">';
        $out .= '<div class="ampa-section-head">';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="ampa-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="ampa-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="ampa-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= '</div>';
        if ( empty( $items ) ) {
            if ( ! $this->boolish( $a['show_empty_fallback'] ?? '1' ) ) { return ''; }
            return $out . '<div class="ampa-gallery-empty-card"><span>' . esc_html( $a['caption_label'] ?? 'Producer Visual' ) . '</span><strong>' . esc_html( $a['empty_message'] ) . '</strong></div></div></section>';
        }
        $out .= '<div class="ampa-gallery-grid" style="' . esc_attr( $style ) . '">';
        foreach ( $items as $item ) {
            $out .= '<figure class="ampa-gallery-card"><img src="' . esc_url( $item['url'] ) . '" alt="' . esc_attr( $item['title'] ) . '" loading="lazy" />';
            if ( $this->boolish( $a['show_caption'] ) ) { $out .= '<figcaption><span>' . esc_html( $a['caption_label'] ?? 'Producer Visual' ) . '</span><strong>' . esc_html( $item['title'] ) . '</strong></figcaption>'; }
            $out .= '</figure>';
        }
        $out .= '</div></div></section>';
        return $out;
    }

    /** Render reusable manual gallery. */
    public function render_manual_gallery( $atts = array() ) {
        $a = $this->normalize( $atts, $this->manual_gallery_defaults() );
        $a['gallery_source'] = 'manual';
        return $this->render_gallery( $a );
    }

    /** Render CTA. */
    public function render_cta( $atts = array() ) {
        $a = $this->normalize( $atts, $this->cta_defaults() );
        if ( ! $this->boolish( $a['show_section'] ) ) { return ''; }
        $out = '<section class="ampa-section ampa-cta"><div class="ampa-wrap ampa-cta-grid"><div>';
        if ( $this->boolish( $a['show_label'] ) ) { $out .= '<p class="ampa-kicker">' . esc_html( $a['label'] ) . '</p>'; }
        if ( $this->boolish( $a['show_title'] ) ) { $out .= '<h2 class="ampa-section-title">' . esc_html( $a['title'] ) . '</h2>'; }
        if ( $this->boolish( $a['show_description'] ) ) { $out .= '<p class="ampa-section-desc">' . esc_html( $a['description'] ) . '</p>'; }
        $out .= '</div>';
        $out .= $this->render_button_group( $a, 'primary_text', 'primary_url', 'secondary_text', 'secondary_url', 'show_primary_button', 'show_secondary_button' );
        $out .= '</div></section>';
        return $out;
    }

    /** Button group helper. */
    private function render_button_group( $a, $primary_text, $primary_url, $secondary_text, $secondary_url, $show_primary, $show_secondary ) {
        if ( ! $this->boolish( $a[ $show_primary ] ) && ! $this->boolish( $a[ $show_secondary ] ) ) { return ''; }
        $out = '<div class="ampa-actions">';
        if ( $this->boolish( $a[ $show_primary ] ) ) { $out .= '<a class="ampa-btn ampa-btn-primary" href="' . esc_url( $a[ $primary_url ] ) . '">' . esc_html( $a[ $primary_text ] ) . '</a>'; }
        if ( $this->boolish( $a[ $show_secondary ] ) ) { $out .= '<a class="ampa-btn ampa-btn-secondary" href="' . esc_url( $a[ $secondary_url ] ) . '">' . esc_html( $a[ $secondary_text ] ) . '</a>'; }
        $out .= '</div>';
        return $out;
    }

    /** Member card. */
    private function render_member_card( $member, $a ) {
        $id = $member->ID;
        $title = get_the_title( $member );
        $shg_id = absint( get_post_meta( $id, '_amaley_member_shg_id', true ) );
        $shg = $shg_id ? get_the_title( $shg_id ) : '';
        $cluster_id = $shg_id ? absint( get_post_meta( $shg_id, '_amaley_shg_cluster_id', true ) ) : 0;
        $cluster = $cluster_id ? get_the_title( $cluster_id ) : '';
        $role = get_post_meta( $id, '_amaley_role', true );
        $village = get_post_meta( $id, '_amaley_village', true );
        $skills = get_post_meta( $id, '_amaley_skills', true );
        $products = get_post_meta( $id, '_amaley_products_handled', true );
        $bio = get_post_meta( $id, '_amaley_short_bio', true );
        if ( '' === $bio ) { $bio = wp_trim_words( wp_strip_all_tags( get_post_meta( $id, '_amaley_story', true ) ), 24 ); }
        $image = get_the_post_thumbnail_url( $id, 'large' );
        if ( ! $image ) { $image = get_post_meta( $id, '_amaley_photo_url', true ); }
        $url = str_replace( array( '{id}', '{slug}', '{shg_id}', '{cluster_id}' ), array( $id, $member->post_name, $shg_id, $cluster_id ), (string) $a['detail_url_pattern'] );
        $has_media = $this->boolish( $a['show_image'] ) && ( $image || $this->boolish( $a['show_placeholder'] ) );

        $rows = array();
        if ( $this->boolish( $a['show_role'] ) && $role ) { $rows[] = array( 'Role', $role ); }
        if ( $this->boolish( $a['show_village'] ) && $village ) { $rows[] = array( 'Village', $village ); }
        if ( $this->boolish( $a['show_shg'] ) && $shg ) { $rows[] = array( 'SHG', $shg ); }
        if ( $this->boolish( $a['show_cluster'] ) && $cluster ) { $rows[] = array( 'Cluster', $cluster ); }

        $out = '<article class="ampa-member-card' . ( ! $has_media ? ' ampa-card-no-media' : '' ) . '">';
        if ( $has_media ) {
            $out .= '<div class="ampa-member-media">';
            if ( $image ) { $out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />'; } else { $out .= '<span>' . esc_html( $this->initials( $title ) ) . '</span>'; }
            $out .= '</div>';
        }
        $out .= '<div class="ampa-member-body">';
        if ( $this->boolish( $a['show_card_label'] ?? '1' ) ) { $out .= '<p class="ampa-card-label">' . esc_html( $a['card_label_text'] ?? 'Producer' ) . '</p>'; }
        $out .= '<h3>' . esc_html( $title ) . '</h3>';
        if ( $this->boolish( $a['show_bio'] ) && $bio ) { $out .= '<p class="ampa-card-desc">' . esc_html( wp_trim_words( $bio, max( 6, absint( $a['bio_word_limit'] ) ) ) ) . '</p>'; }
        if ( $rows ) {
            $out .= '<dl class="ampa-card-meta">';
            foreach ( $rows as $row ) { $out .= '<div><dt>' . esc_html( $row[0] ) . '</dt><dd>' . esc_html( $row[1] ) . '</dd></div>'; }
            $out .= '</dl>';
        }
        $tags = array();
        $skill_limit = array_key_exists( 'max_skill_tags', $a ) ? absint( $a['max_skill_tags'] ) : absint( $a['max_tags'] );
        $product_limit = array_key_exists( 'max_product_tags', $a ) ? absint( $a['max_product_tags'] ) : 0;
        if ( $this->boolish( $a['show_skills'] ) && $skill_limit > 0 ) { $tags = array_merge( $tags, $this->split_terms( $skills, $skill_limit ) ); }
        if ( $this->boolish( $a['show_products'] ) && $product_limit > 0 ) { $tags = array_merge( $tags, $this->split_terms( $products, $product_limit ) ); }
        $fallback_limit = absint( $a['max_tags'] ?? 3 );
        $total_limit = max( 0, $skill_limit + $product_limit );
        if ( 0 === $total_limit && $fallback_limit > 0 ) { $total_limit = $fallback_limit; }
        $tags = array_slice( array_values( array_unique( array_filter( $tags ) ) ), 0, $total_limit );
        if ( $tags ) { $out .= '<div class="ampa-chip-row" aria-label="Member skills and product chips">'; foreach ( $tags as $tag ) { $out .= '<span>' . esc_html( $tag ) . '</span>'; } $out .= '</div>'; }
        if ( $this->boolish( $a['show_button'] ) ) { $out .= '<a class="ampa-card-button" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ) . '</a>'; }
        $out .= '</div></article>';
        return $out;
    }

    /** Query members. */
    private function get_members( $a ) {
        $meta_query = array();
        if ( $this->boolish( $a['show_only_website'] ) ) { $meta_query[] = array( 'key' => '_amaley_show_on_website', 'value' => '1', 'compare' => '=' ); }
        if ( $this->boolish( $a['featured_only'] ) ) { $meta_query[] = array( 'key' => '_amaley_featured', 'value' => '1', 'compare' => '=' ); }
        if ( ! empty( $a['status'] ) ) { $meta_query[] = array( 'key' => '_amaley_status', 'value' => sanitize_key( $a['status'] ), 'compare' => '=' ); }
        if ( ! empty( $a['shg_id'] ) ) { $meta_query[] = array( 'key' => '_amaley_member_shg_id', 'value' => absint( $a['shg_id'] ), 'compare' => '=' ); }
        if ( empty( $a['shg_id'] ) && ! empty( $a['cluster_id'] ) ) {
            $shg_ids = $this->shg_ids_for_cluster( absint( $a['cluster_id'] ) );
            if ( empty( $shg_ids ) ) { return array(); }
            $meta_query[] = array( 'key' => '_amaley_member_shg_id', 'value' => $shg_ids, 'compare' => 'IN' );
        }
        $args = array(
            'post_type' => 'amaley_member',
            'post_status' => 'publish',
            'posts_per_page' => max( 1, absint( $a['limit'] ) ),
            'orderby' => $this->orderby( $a['order_by'] ),
            'order' => ( 'DESC' === strtoupper( (string) $a['order'] ) ) ? 'DESC' : 'ASC',
        );
        if ( 'menu_order' === $a['order_by'] ) { $args['orderby'] = 'menu_order title'; }
        if ( $meta_query ) { $args['meta_query'] = $meta_query; }
        $include = $this->ids_from_csv( $a['include_ids'] ?? '' );
        if ( $include ) { $args['post__in'] = $include; $args['orderby'] = 'post__in'; }
        $exclude = $this->ids_from_csv( $a['exclude_ids'] ?? '' );
        if ( $exclude ) { $args['post__not_in'] = $exclude; }
        return get_posts( $args );
    }

    /** Gallery items. */
    private function get_gallery_items( $a ) {
        $limit  = max( 1, absint( $a['limit'] ?? 6 ) );
        $source = isset( $a['gallery_source'] ) ? sanitize_key( $a['gallery_source'] ) : 'manual';

        $manual_items = array();
        if ( 'member_records' !== $source ) {
            $manual_items = $this->manual_gallery_items( $a );
        }

        if ( 'manual' === $source ) {
            return array_slice( $manual_items, 0, $limit );
        }

        $items = array_slice( $manual_items, 0, $limit );
        if ( count( $items ) >= $limit && 'manual_then_records' === $source ) {
            return $items;
        }

        $members = $this->get_members( array_merge( $a, array( 'limit' => $limit ) ) );
        foreach ( $members as $member ) {
            foreach ( $this->gallery_urls_for_member( $member->ID ) as $url ) {
                $items[] = array( 'url' => $url, 'title' => get_the_title( $member ) );
                if ( count( $items ) >= $limit ) { break 2; }
            }
        }
        return array_slice( $items, 0, $limit );
    }

    /** Manual Elementor gallery images for archive pages. */
    private function manual_gallery_items( $a ) {
        $gallery = isset( $a['manual_gallery'] ) && is_array( $a['manual_gallery'] ) ? $a['manual_gallery'] : array();
        $items   = array();
        $source  = isset( $a['manual_caption_source'] ) ? sanitize_key( $a['manual_caption_source'] ) : 'attachment_title';
        foreach ( $gallery as $image ) {
            $url = '';
            $id  = 0;
            if ( is_array( $image ) ) {
                $url = isset( $image['url'] ) ? esc_url_raw( $image['url'] ) : '';
                $id  = isset( $image['id'] ) ? absint( $image['id'] ) : 0;
            }
            if ( ! $url && $id ) {
                $url = wp_get_attachment_image_url( $id, 'large' );
            }
            if ( ! $url ) { continue; }
            $title = $this->manual_gallery_caption( $id, $source, $a );
            $items[] = array(
                'url'   => $url,
                'title' => $title,
            );
        }
        return $items;
    }

    /** Caption helper for manual gallery images. */
    private function manual_gallery_caption( $attachment_id, $source, $a ) {
        $fallback = ! empty( $a['empty_message'] ) ? $a['empty_message'] : 'Amaley producer visual';
        if ( ! $attachment_id ) { return $fallback; }
        if ( 'attachment_caption' === $source ) {
            $caption = wp_get_attachment_caption( $attachment_id );
            return $caption ? $caption : $fallback;
        }
        if ( 'attachment_alt' === $source ) {
            $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
            return $alt ? $alt : $fallback;
        }
        if ( 'fallback' === $source ) { return $fallback; }
        $title = get_the_title( $attachment_id );
        return $title ? $title : $fallback;
    }

    /** Gallery URLs. */
    private function gallery_urls_for_member( $member_id ) {
        $urls = array();
        $featured = get_the_post_thumbnail_url( $member_id, 'large' );
        $photo = get_post_meta( $member_id, '_amaley_photo_url', true );
        if ( $featured ) { $urls[] = esc_url_raw( $featured ); }
        if ( $photo && filter_var( $photo, FILTER_VALIDATE_URL ) ) { $urls[] = esc_url_raw( $photo ); }
        $gallery = get_post_meta( $member_id, '_amaley_gallery_urls', true );
        foreach ( preg_split( '/\r\n|\r|\n|,/', (string) $gallery ) as $url ) {
            $url = trim( $url );
            if ( $url && filter_var( $url, FILTER_VALIDATE_URL ) ) { $urls[] = esc_url_raw( $url ); }
        }
        return array_values( array_unique( $urls ) );
    }

    /** Dynamic stats. */
    private function hero_stats( $a ) {
        if ( 'manual' === (string) ( $a['stats_mode'] ?? '' ) ) {
            $stats = array();
            for ( $i = 1; $i <= 4; $i++ ) { $stats[] = array( $a[ 'stat_' . $i . '_value' ], $a[ 'stat_' . $i . '_label' ] ); }
            return $stats;
        }
        $counts = $this->network_counts();
        return array(
            array( $counts['members'], 'Producers' ),
            array( $counts['shgs'], 'Linked SHGs' ),
            array( $counts['clusters'], 'Clusters' ),
            array( $counts['products'], 'Products' ),
        );
    }

    /** Counts. */
    private function network_counts() {
        $member_ids = get_posts( array( 'post_type' => 'amaley_member', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids' ) );
        $shg_ids = array();
        $cluster_ids = array();
        foreach ( $member_ids as $mid ) {
            $sid = absint( get_post_meta( $mid, '_amaley_member_shg_id', true ) );
            if ( $sid ) { $shg_ids[] = $sid; }
            $cid = $sid ? absint( get_post_meta( $sid, '_amaley_shg_cluster_id', true ) ) : 0;
            if ( $cid ) { $cluster_ids[] = $cid; }
        }
        $product_count = 0;
        if ( post_type_exists( 'product' ) ) {
            $product_q = new WP_Query( array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_amaley_origin_member_ids', 'compare' => 'EXISTS' ) ) ) );
            $product_count = absint( $product_q->found_posts );
        }
        return array( 'members' => count( $member_ids ), 'shgs' => count( array_unique( $shg_ids ) ), 'clusters' => count( array_unique( $cluster_ids ) ), 'products' => $product_count );
    }

    /** Helpers. */
    private function shg_ids_for_cluster( $cluster_id ) { return get_posts( array( 'post_type' => 'amaley_shg_group', 'post_status' => 'publish', 'posts_per_page' => 500, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_amaley_shg_cluster_id', 'value' => absint( $cluster_id ), 'compare' => '=' ) ) ) ); }
    private function ids_from_csv( $csv ) { return array_values( array_filter( array_map( 'absint', explode( ',', (string) $csv ) ) ) ); }
    private function split_terms( $text, $limit = 5 ) { $terms = preg_split( '/[\n,]+/', (string) $text ); return array_slice( array_values( array_filter( array_map( 'trim', $terms ) ) ), 0, max( 1, absint( $limit ) ) ); }
    private function item_lines( $value ) { $rows = preg_split( '/\r\n|\r|\n/', (string) $value ); $items = array(); foreach ( $rows as $row ) { $parts = array_map( 'trim', explode( '|', $row, 2 ) ); if ( ! empty( $parts[0] ) ) { $items[] = array( $parts[0], isset( $parts[1] ) ? $parts[1] : '' ); } } return $items; }
    private function orderby( $value ) { $allowed = array( 'title', 'date', 'modified', 'menu_order', 'rand' ); return in_array( $value, $allowed, true ) ? $value : 'menu_order'; }
    private function initials( $title ) { $words = preg_split( '/\s+/', trim( wp_strip_all_tags( (string) $title ) ) ); $letters = ''; foreach ( $words as $word ) { if ( '' !== $word ) { $letters .= mb_substr( $word, 0, 1 ); } if ( mb_strlen( $letters ) >= 2 ) { break; } } return $letters ? mb_strtoupper( $letters ) : 'PM'; }
}
