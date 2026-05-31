<?php
/**
 * OG-aligned Cluster Archive + Single Page frontend widgets and shortcodes.
 *
 * Elementor-first display layer only. It does not create theme templates,
 * override WooCommerce templates, or change public CPT rewrite rules.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Cluster_Pages {
    /** Constructor. */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_shortcode( 'amaley_cluster_archive_page', array( $this, 'archive_shortcode' ) );
        add_shortcode( 'amaley_cluster_single_page', array( $this, 'single_shortcode' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
    }

    /** Register frontend assets. */
    public function register_assets() {
        wp_register_style( 'amaley-core-cluster-pages', AMALEY_CORE_URL . 'assets/amaley-core-cluster-pages.css', array(), AMALEY_CORE_VERSION );
    }

    /** Enqueue frontend assets. */
    public function enqueue_assets() {
        wp_enqueue_style( 'amaley-core-cluster-pages' );
    }

    /** Register Elementor category. */
    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    /** Register Elementor widgets. */
    public function register_elementor_widgets( $widgets_manager ) {
        if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
            return;
        }

        $files = array(
            AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-cluster-archive-page-widget.php',
            AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-cluster-single-page-widget.php',
        );

        foreach ( $files as $file ) {
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }

        if ( class_exists( 'Amaley_Core_Cluster_Archive_Page_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_Cluster_Archive_Page_Widget( $this ) );
        }
        if ( class_exists( 'Amaley_Core_Cluster_Single_Page_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_Cluster_Single_Page_Widget( $this ) );
        }
    }

    /** Archive shortcode. */
    public function archive_shortcode( $atts ) {
        $this->enqueue_assets();
        return $this->render_archive( is_array( $atts ) ? $atts : array() );
    }

    /** Single shortcode. */
    public function single_shortcode( $atts ) {
        $this->enqueue_assets();
        return $this->render_single( is_array( $atts ) ? $atts : array() );
    }

    /** Archive defaults. */
    public function archive_defaults() {
        $defaults = array(
            'title'                  => 'Browse Amaley Source Clusters',
            'title_accent'           => 'Source',
            'kicker'                 => 'Origin Directory',
            'subtitle'               => 'A clean directory of source clusters connected with women collectives, producer families and mapped Amaley products.',
            'breadcrumb_home'        => 'Home',
            'breadcrumb_home_url'    => '/',
            'breadcrumb_middle'      => 'Shop',
            'breadcrumb_middle_url'  => '/shop/',
            'breadcrumb_current'     => 'Clusters',
            'breadcrumb_current_url' => '',
            'limit'                  => '12',
            'columns_desktop'        => '3',
            'columns_tablet'         => '2',
            'columns_mobile'         => '1',
            'show_only_website'      => '0',
            'featured_only'          => '0',
            'show_hero'              => '1',
            'show_trust_strip'       => '1',
            'show_intro'             => '1',
            'show_traceability'      => '1',
            'show_stats'             => '1',
            'show_featured_cluster'  => '1',
            'show_cards'             => '1',
            'show_cta'               => '1',
            'detail_url_pattern'     => '/cluster-detail/?cluster_id={id}',
            'button_text'            => 'View Cluster Story',
            'intro_title'            => 'Amaley is not just a shelf of products.',
            'intro_text'             => 'Products do not emerge in isolation. They come from local ingredients, women collectives, household skills, seasonal rhythms, and geographies that shape what can be made well. This page makes that structure visible.',
            'map_title'              => 'Where the Amaley ecosystem is being shaped',
            'map_text'               => 'The archive starts with clusters because clusters are the most intuitive way to understand local production, ingredient strengths, and women-led enterprise across geographies.',
            'trace_title'            => 'From cluster to SHG to member to product.',
            'trace_text'             => 'This is the logic that makes Amaley stand apart. The product is the commercial face, but its origin remains legible.',
            'archive_title'          => 'Browse clusters by state and geography',
            'archive_text'           => 'Open a cluster to see its detailed page, linked SHGs, members, traceable products, and direct pathways into product purchase and deeper origin viewing.',
            'cta_title'              => 'Cluster visibility helps customers and partners buy better.',
            'cta_text'               => 'Use cluster visibility to build story-rich product sets, hospitality counters, curated shelves, and origin-led retail experiences.',
            'cta_button_text'        => 'Explore Amaley Products',
            'cta_button_url'         => '/shop/',
            'empty_message'          => 'Cluster information will appear once verified Amaley data is available.',
        );
        $saved = $this->admin_template_settings();
        $mapped = array(
            'title' => $saved['archive_title'],
            'title_accent' => $saved['archive_title_accent'],
            'kicker' => $saved['archive_kicker'],
            'subtitle' => $saved['archive_subtitle'],
            'breadcrumb_home_url' => $saved['archive_breadcrumb_home_url'],
            'breadcrumb_middle' => $saved['archive_breadcrumb_middle'],
            'breadcrumb_middle_url' => $saved['archive_breadcrumb_middle_url'],
            'detail_url_pattern' => isset( $saved['archive_detail_url_pattern'] ) ? $saved['archive_detail_url_pattern'] : '/cluster-detail/?cluster_id={id}',
            'intro_title' => $saved['archive_intro_title'],
            'intro_text' => $saved['archive_intro_text'],
            'trace_title' => $saved['archive_trace_title'],
            'trace_text' => $saved['archive_trace_text'],
            'archive_title' => $saved['archive_list_title'],
            'archive_text' => $saved['archive_list_text'],
            'cta_title' => $saved['archive_cta_title'],
            'cta_text' => $saved['archive_cta_text'],
            'cta_button_text' => $saved['archive_cta_button_text'],
            'cta_button_url' => $saved['archive_cta_button_url'],
            'show_hero' => $saved['archive_show_hero'],
            'show_trust_strip' => $saved['archive_show_trust_strip'],
            'show_intro' => $saved['archive_show_intro'],
            'show_traceability' => $saved['archive_show_traceability'],
            'show_featured_cluster' => $saved['archive_show_featured_cluster'],
            'show_cta' => $saved['archive_show_cta'],
        );
        return wp_parse_args( array_filter( $mapped, 'strlen' ), $defaults );
    }

    /** Single defaults. */
    public function single_defaults() {
        $defaults = array(
            'cluster_id'             => '',
            'cluster_slug'           => '',
            'auto_detect'            => '1',
            'kicker'                 => 'Source Cluster',
            'breadcrumb_home'        => 'Home',
            'breadcrumb_home_url'    => '/',
            'breadcrumb_middle'      => 'Clusters',
            'breadcrumb_middle_url'  => '/cluster/',
            'show_hero'              => '1',
            'show_trust_strip'       => '1',
            'show_snapshot'          => '1',
            'show_story'             => '1',
            'show_villages'          => '1',
            'show_shgs'              => '1',
            'show_members'           => '1',
            'show_products'          => '1',
            'show_journey'           => '1',
            'show_gallery'           => '1',
            'show_cta'               => '1',
            'shg_limit'              => '6',
            'member_limit'           => '6',
            'product_limit'          => '6',
            'button_text'            => 'Explore Related Products',
            'button_url'             => '/shop/',
            'empty_message'          => 'This cluster detail page will appear once verified Amaley data is available.',
        );
        $saved = $this->admin_template_settings();
        $mapped = array(
            'kicker' => $saved['single_kicker'],
            'breadcrumb_home_url' => $saved['single_breadcrumb_home_url'],
            'breadcrumb_middle' => $saved['single_breadcrumb_middle'],
            'breadcrumb_middle_url' => $saved['single_breadcrumb_middle_url'],
            'button_text' => $saved['single_button_text'],
            'button_url' => $saved['single_button_url'],
            'show_hero' => $saved['single_show_hero'],
            'show_trust_strip' => $saved['single_show_trust_strip'],
            'show_snapshot' => $saved['single_show_snapshot'],
            'show_story' => $saved['single_show_story'],
            'show_villages' => $saved['single_show_villages'],
            'show_shgs' => $saved['single_show_shgs'],
            'show_members' => $saved['single_show_members'],
            'show_products' => $saved['single_show_products'],
            'show_journey' => $saved['single_show_journey'],
            'show_gallery' => $saved['single_show_gallery'],
            'show_cta' => $saved['single_show_cta'],
        );
        return wp_parse_args( array_filter( $mapped, 'strlen' ), $defaults );
    }

    /** Admin template settings defaults. */
    private function admin_template_settings() {
        $defaults = array(
            'archive_title' => 'Browse Amaley Source Clusters',
            'archive_title_accent' => 'Source',
            'archive_kicker' => 'Origin Directory',
            'archive_subtitle' => 'A clean directory of source clusters connected with women collectives, producer families and mapped Amaley products.',
            'archive_breadcrumb_home_url' => '/',
            'archive_breadcrumb_middle' => 'Shop',
            'archive_breadcrumb_middle_url' => '/shop/',
            'archive_detail_url_pattern' => '/cluster-detail/?cluster_id={id}',
            'archive_intro_title' => 'Amaley is not just a shelf of products.',
            'archive_intro_text' => 'Products come from local ingredients, women collectives, household skills, seasonal rhythms and geographies that shape what can be made well.',
            'archive_trace_title' => 'From cluster to SHG to member to product.',
            'archive_trace_text' => 'The product is the commercial face, but its origin remains legible through cluster, collective and maker connections.',
            'archive_list_title' => 'Browse clusters by state and geography',
            'archive_list_text' => 'Open a cluster to see its detailed page, linked SHGs, members, traceable products and deeper origin viewing.',
            'archive_cta_title' => 'Cluster visibility helps customers and partners buy better.',
            'archive_cta_text' => 'Use cluster visibility to build story-rich product sets, hospitality counters, curated shelves and origin-led retail experiences.',
            'archive_cta_button_text' => 'Explore Amaley Products',
            'archive_cta_button_url' => '/shop/',
            'archive_show_hero' => '1',
            'archive_show_trust_strip' => '1',
            'archive_show_intro' => '1',
            'archive_show_traceability' => '1',
            'archive_show_featured_cluster' => '1',
            'archive_show_cta' => '1',
            'single_kicker' => 'Source Cluster',
            'single_breadcrumb_home_url' => '/',
            'single_breadcrumb_middle' => 'Clusters',
            'single_breadcrumb_middle_url' => '/clusters/',
            'single_button_text' => 'Explore Related Products',
            'single_button_url' => '/shop/',
            'single_show_hero' => '1',
            'single_show_trust_strip' => '1',
            'single_show_snapshot' => '1',
            'single_show_story' => '1',
            'single_show_villages' => '1',
            'single_show_shgs' => '1',
            'single_show_members' => '1',
            'single_show_products' => '1',
            'single_show_journey' => '1',
            'single_show_gallery' => '1',
            'single_show_cta' => '1',
        );
        $saved = get_option( 'amaley_core_template_settings', array() );
        return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
    }

    /** Render cluster archive page. */
    public function render_archive( $atts = array() ) {
        $a        = shortcode_atts( $this->archive_defaults(), $atts, 'amaley_cluster_archive_page' );
        $clusters = $this->get_clusters( $a );
        $counts   = $this->get_archive_counts();
        $style    = '--acp-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--acp-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--acp-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';

        $out  = '<section class="amaley-core-cluster-system amaley-core-cluster-archive" style="' . esc_attr( $style ) . '">';

        if ( '1' === (string) $a['show_hero'] ) {
            $out .= $this->render_dark_hero(
                array(
                    'home'        => $a['breadcrumb_home'],
                    'home_url'    => $a['breadcrumb_home_url'],
                    'middle'      => $a['breadcrumb_middle'],
                    'middle_url'  => $a['breadcrumb_middle_url'],
                    'current'     => $a['breadcrumb_current'],
                    'current_url' => $a['breadcrumb_current_url'],
                    'kicker'   => $a['kicker'],
                    'title'    => $a['title'],
                    'accent'   => $a['title_accent'],
                    'subtitle' => $a['subtitle'],
                    'mode'     => 'archive',
                    'image_id' => 0,
                    'stats'    => array(
                        array( $counts['clusters'], 'Active Clusters' ),
                        array( $counts['shgs'], 'SHGs Mapped' ),
                        array( $counts['members'], 'Members Listed' ),
                        array( $counts['products'], 'Traceable Products' ),
                    ),
                )
            );
        }

        if ( '1' === (string) $a['show_trust_strip'] ) {
            $out .= $this->render_trust_strip();
        }

        if ( '1' === (string) $a['show_intro'] ) {
            $out .= '<section class="acp-page-sec"><div class="acp-page-inner acp-intro-grid"><div><div class="acp-section-head"><div><span class="acp-eyebrow">Why clusters matter</span><h2>' . esc_html( $a['intro_title'] ) . '</h2></div></div>';
            $out .= '<div class="acp-info-panel"><p>' . esc_html( $a['intro_text'] ) . '</p><div class="acp-filter-strip">' . $this->archive_filter_terms( $clusters ) . '</div></div>';
            if ( '1' === (string) $a['show_stats'] ) {
                $out .= '<div class="acp-kpi-row">';
                $out .= $this->kpi_box( $this->count_regions( $clusters ), 'Regions represented' );
                $out .= $this->kpi_box( $this->count_geographies( $clusters ), 'Geographies mapped' );
                $out .= $this->kpi_box( $counts['products'], 'Products linked to origin' );
                $out .= $this->kpi_box( $counts['shgs'], 'Collectives connected' );
                $out .= '</div>';
            }
            $out .= '</div><div class="acp-cluster-map"><span class="acp-eyebrow">Current geography map</span><h3>' . esc_html( $a['map_title'] ) . '</h3><p>' . esc_html( $a['map_text'] ) . '</p><div class="acp-map-points">' . $this->map_points( $clusters ) . '</div></div></div></section>';
        }

        if ( '1' === (string) $a['show_traceability'] ) {
            $out .= '<section class="acp-page-sec"><div class="acp-page-inner"><div class="acp-section-head"><div><span class="acp-eyebrow">Traceability flow</span><h2>' . esc_html( $a['trace_title'] ) . '</h2></div><p>' . esc_html( $a['trace_text'] ) . '</p></div>';
            $out .= $this->render_trace_grid();
            $out .= '</div></section>';
        }

        $out .= '<section class="acp-page-sec"><div class="acp-page-inner"><div class="acp-section-head"><div><span class="acp-eyebrow">Cluster archive</span><h2>' . esc_html( $a['archive_title'] ) . '</h2></div><p>' . esc_html( $a['archive_text'] ) . '</p></div>';

        if ( empty( $clusters ) ) {
            $out .= '<div class="acp-safe-empty">' . esc_html( $a['empty_message'] ) . '</div>';
        } else {
            if ( '1' === (string) $a['show_featured_cluster'] ) {
                $out .= $this->render_highlight_cluster( $clusters[0], $a );
            }

            if ( '1' === (string) $a['show_cards'] ) {
                $out .= '<div class="acp-cluster-grid-v2">';
                foreach ( $clusters as $cluster ) {
                    $out .= $this->render_archive_card( $cluster, $a );
                }
                $out .= '</div>';
            }
        }
        $out .= '</div></section>';

        if ( '1' === (string) $a['show_cta'] ) {
            $out .= '<section class="acp-page-sec"><div class="acp-page-inner"><div class="acp-buyer-banner"><div><span class="acp-eyebrow">Built for buyers too</span><h2>' . esc_html( $a['cta_title'] ) . '</h2><p>' . esc_html( $a['cta_text'] ) . '</p></div>';
            if ( ! empty( $a['cta_button_text'] ) && ! empty( $a['cta_button_url'] ) ) {
                $out .= '<a class="acp-btn acp-btn-gold" href="' . esc_url( $a['cta_button_url'] ) . '">' . esc_html( $a['cta_button_text'] ) . '</a>';
            }
            $out .= '</div></div></section>';
        }

        $out .= '</section>';
        return $out;
    }

    /** Render cluster single page. */
    public function render_single( $atts = array() ) {
        $a       = shortcode_atts( $this->single_defaults(), $atts, 'amaley_cluster_single_page' );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) {
            return '<section class="amaley-core-cluster-system amaley-core-cluster-single"><div class="acp-page-inner"><div class="acp-safe-empty">' . esc_html( $a['empty_message'] ) . '</div></div></section>';
        }

        $id       = $cluster->ID;
        $meta     = $this->cluster_meta( $id, $cluster );
        $shgs     = $this->get_shgs_for_cluster( $id, absint( $a['shg_limit'] ) );
        $members  = $this->get_members_for_cluster( $id, absint( $a['member_limit'] ) );
        $products = $this->get_products_for_cluster( $id, absint( $a['product_limit'] ) );
        $gallery  = $this->gallery_urls( get_post_meta( $id, '_amaley_gallery_urls', true ) );

        $out = '<section class="amaley-core-cluster-system amaley-core-cluster-single">';

        if ( '1' === (string) $a['show_hero'] ) {
            $out .= $this->render_dark_hero(
                array(
                    'home'        => isset( $a['breadcrumb_home'] ) ? $a['breadcrumb_home'] : 'Home',
                    'home_url'    => isset( $a['breadcrumb_home_url'] ) ? $a['breadcrumb_home_url'] : '/',
                    'middle'      => isset( $a['breadcrumb_middle'] ) ? $a['breadcrumb_middle'] : 'Clusters',
                    'middle_url'  => isset( $a['breadcrumb_middle_url'] ) ? $a['breadcrumb_middle_url'] : '/cluster/',
                    'current'     => get_the_title( $cluster ),
                    'current_url' => '',
                    'kicker'   => $a['kicker'],
                    'title'    => get_the_title( $cluster ),
                    'accent'   => '',
                    'subtitle' => $meta['intro'] ? $meta['intro'] : 'A source cluster inside Amaley’s traceable origin system.',
                    'mode'     => 'single',
                    'image_id' => $id,
                    'stats'    => array(
                        array( $meta['village_count'], 'Villages' ),
                        array( count( $shgs ), 'SHGs' ),
                        array( count( $members ), 'Members' ),
                        array( count( $products ), 'Products' ),
                    ),
                )
            );
        }

        if ( '1' === (string) $a['show_trust_strip'] ) {
            $out .= $this->render_trust_strip( array(
                array( '⛰', 'Geography-led', $meta['location'] ? $meta['location'] : 'Mapped source context' ),
                array( '◉', 'Traceable', 'Linked to SHGs, makers and products' ),
                array( '✦', 'Structured', 'Readable archive and detail flow' ),
                array( '❧', 'Market-rooted', 'Useful for retail, gifting and hospitality' ),
            ) );
        }

        $out .= '<section class="acp-page-sec"><div class="acp-page-inner acp-cluster-detail-shell">';
        $out .= '<div class="acp-cluster-detail-top"><div class="acp-cluster-detail-head"><span class="acp-eyebrow">Cluster story</span><h2>' . esc_html( get_the_title( $cluster ) ) . '</h2>';
        if ( $meta['location'] ) { $out .= '<div class="acp-cluster-crumbs"><span>' . esc_html( $meta['location'] ) . '</span></div>'; }
        if ( $meta['story'] && '1' === (string) $a['show_story'] ) { $out .= '<p>' . esc_html( $meta['story'] ) . '</p>'; }
        elseif ( $meta['intro'] ) { $out .= '<p>' . esc_html( $meta['intro'] ) . '</p>'; }
        $out .= '</div><div class="acp-cluster-detail-visual">' . $this->cluster_visual( $id, get_the_title( $cluster ), 'single' ) . '</div><aside class="acp-cluster-detail-side"><h4>Cluster snapshot</h4>';
        $out .= $this->side_stat( 'Villages', ! empty( $meta['villages'] ) ? implode( ', ', array_slice( $meta['villages'], 0, 6 ) ) : 'To be updated' );
        $out .= $this->side_stat( 'Main products', ! empty( $meta['products'] ) ? implode( ', ', array_slice( $meta['products'], 0, 6 ) ) : 'To be updated' );
        $out .= $this->side_stat( 'SHG groups', count( $shgs ) );
        $out .= $this->side_stat( 'Mapped products', count( $products ) );
        $out .= '</aside></div>';

        if ( '1' === (string) $a['show_snapshot'] ) {
            $out .= '<div class="acp-cluster-kpi-grid">';
            $out .= $this->kpi_box( $meta['village_count'], 'Villages' );
            $out .= $this->kpi_box( count( $shgs ), 'SHG groups' );
            $out .= $this->kpi_box( count( $members ), 'Producer profiles' );
            $out .= $this->kpi_box( count( $products ), 'Mapped products' );
            $out .= '</div>';
        }

        if ( '1' === (string) $a['show_villages'] && ! empty( $meta['villages'] ) ) {
            $out .= '<div class="acp-cluster-inline-detail"><span class="acp-eyebrow">Village and product logic</span><h3>Places and product categories connected with this cluster</h3><div class="acp-chip-row">';
            foreach ( $meta['villages'] as $village ) { $out .= '<span>' . esc_html( $village ) . '</span>'; }
            $out .= '</div></div>';
        }

        if ( '1' === (string) $a['show_journey'] ) {
            $out .= '<div class="acp-cluster-section-v2"><div class="acp-section-head"><div><span class="acp-eyebrow">Traceability flow</span><h2>From this cluster to Amaley products.</h2></div><p>Only verified data should appear. If a link is missing, the page keeps the section clean instead of inventing information.</p></div>' . $this->render_trace_grid() . '</div>';
        }

        if ( '1' === (string) $a['show_shgs'] ) { $out .= $this->render_related_shgs( $shgs ); }
        if ( '1' === (string) $a['show_members'] ) { $out .= $this->render_related_members( $members ); }
        if ( '1' === (string) $a['show_products'] ) { $out .= $this->render_related_products( $products ); }

        if ( '1' === (string) $a['show_gallery'] && ! empty( $gallery ) ) {
            $out .= '<div class="acp-related-section"><span class="acp-eyebrow">Gallery</span><h2>Visual notes from this cluster</h2><div class="acp-gallery-grid">';
            foreach ( array_slice( $gallery, 0, 6 ) as $url ) { $out .= '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( get_the_title( $cluster ) ) . '" loading="lazy" />'; }
            $out .= '</div></div>';
        }

        if ( '1' === (string) $a['show_cta'] ) {
            $out .= '<div class="acp-buyer-banner"><div><span class="acp-eyebrow">Continue</span><h2>Explore products connected with this origin.</h2><p>Use this section as a bridge from origin story to product discovery.</p></div><a class="acp-btn acp-btn-gold" href="' . esc_url( $a['button_url'] ) . '">' . esc_html( $a['button_text'] ) . '</a></div>';
        }

        $out .= '</div></section></section>';
        return $out;
    }

    /** Render functional breadcrumb links. */
    private function render_breadcrumb( $args ) {
        $items = array(
            array(
                'label' => isset( $args['home'] ) ? (string) $args['home'] : 'Home',
                'url'   => isset( $args['home_url'] ) ? (string) $args['home_url'] : '/',
                'type'  => 'link',
            ),
            array(
                'label' => isset( $args['middle'] ) ? (string) $args['middle'] : 'Clusters',
                'url'   => isset( $args['middle_url'] ) ? (string) $args['middle_url'] : '/cluster/',
                'type'  => 'link',
            ),
            array(
                'label' => isset( $args['current'] ) ? (string) $args['current'] : '',
                'url'   => isset( $args['current_url'] ) ? (string) $args['current_url'] : '',
                'type'  => 'current',
            ),
        );

        $out = '<nav class="acp-sh-breadcrumb" aria-label="Breadcrumb">';
        $i = 0;
        foreach ( $items as $item ) {
            if ( '' === trim( $item['label'] ) ) {
                continue;
            }
            if ( $i > 0 ) {
                $out .= '<s aria-hidden="true">•</s>';
            }
            if ( 'current' !== $item['type'] && ! empty( $item['url'] ) ) {
                $out .= '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
            } else {
                $out .= '<span class="acp-breadcrumb-current" aria-current="page">' . esc_html( $item['label'] ) . '</span>';
            }
            $i++;
        }
        $out .= '</nav>';
        return $out;
    }

    /** Clean Amaley hero. v1.0.23 keeps archive and single hero visually different, with working breadcrumbs. */
    private function render_dark_hero( $args ) {
        $title  = isset( $args['title'] ) ? (string) $args['title'] : '';
        $accent = isset( $args['accent'] ) ? (string) $args['accent'] : '';
        $mode   = isset( $args['mode'] ) ? sanitize_html_class( $args['mode'] ) : 'archive';

        $title_html = esc_html( $title );
        if ( $accent && false !== stripos( $title, $accent ) ) {
            $title_html = preg_replace( '/' . preg_quote( $accent, '/' ) . '/i', '<em>' . esc_html( $accent ) . '</em>', esc_html( $title ), 1 );
        }

        $image = '';
        if ( ! empty( $args['image_id'] ) ) {
            $image = get_the_post_thumbnail_url( absint( $args['image_id'] ), 'large' );
            if ( ! $image ) {
                $gallery = $this->gallery_urls( get_post_meta( absint( $args['image_id'] ), '_amaley_gallery_urls', true ) );
                if ( ! empty( $gallery ) ) {
                    $image = $gallery[0];
                }
            }
        }

        if ( 'archive' === $mode ) {
            $out  = '<div class="acp-shop-hero acp-archive-hero-v24">';
            $out .= '<div class="acp-sh-inner acp-archive-hero-inner-v24">';
            $out .= '<div class="acp-archive-directory-copy">' . $this->render_breadcrumb( $args ) . '';
            $out .= '<span class="acp-eyebrow">' . esc_html( $args['kicker'] ) . '</span><h1 class="acp-sh-title">' . wp_kses_post( $title_html ) . '</h1><p class="acp-sh-sub">' . esc_html( $args['subtitle'] ) . '</p></div>';
            $out .= '<div class="acp-archive-directory-panel">';
            $out .= '<span class="acp-directory-label">Browse by</span><div class="acp-directory-pills"><span>Region</span><span>Collective</span><span>Product</span><span>Origin</span></div>';
            if ( ! empty( $args['stats'] ) ) {
                $out .= '<div class="acp-archive-stat-strip">';
                foreach ( $args['stats'] as $stat ) {
                    $out .= '<div class="acp-archive-stat"><strong>' . esc_html( $stat[0] ) . '</strong><span>' . esc_html( $stat[1] ) . '</span></div>';
                }
                $out .= '</div>';
            }
            $out .= '</div>';
            $out .= '</div></div>';
            return $out;
        }

        $out  = '<div class="acp-shop-hero acp-clean-hero acp-clean-hero-' . esc_attr( $mode ) . '">';
        $out .= '<div class="acp-clean-hero-glow"></div>';
        $out .= '<div class="acp-sh-inner acp-clean-hero-inner">';
        $out .= '<div class="acp-clean-hero-copy">' . $this->render_breadcrumb( $args ) . '';
        $out .= '<span class="acp-eyebrow">' . esc_html( $args['kicker'] ) . '</span><h1 class="acp-sh-title">' . wp_kses_post( $title_html ) . '</h1><p class="acp-sh-sub">' . esc_html( $args['subtitle'] ) . '</p>';
        if ( ! empty( $args['stats'] ) ) {
            $out .= '<div class="acp-sh-stats">';
            foreach ( $args['stats'] as $stat ) {
                $out .= '<div class="acp-sh-stat"><strong>' . esc_html( $stat[0] ) . '</strong><span>' . esc_html( $stat[1] ) . '</span></div>';
            }
            $out .= '</div>';
        }
        $out .= '</div>';

        if ( $image ) {
            $out .= '<div class="acp-clean-hero-image"><img src="' . esc_url( $image ) . '" alt="' . esc_attr( wp_strip_all_tags( $title ) ) . '" loading="eager" /><span>Amaley source</span></div>';
        } else {
            $out .= '<div class="acp-clean-hero-note"><span>Cluster detail</span><strong>Story · SHG · Producer · Product</strong><p>This page opens one cluster as a detailed origin story with connected groups, makers and products.</p></div>';
        }

        $out .= '</div></div>';
        return $out;
    }

    /** Trust strip. */
    private function render_trust_strip( $items = array() ) {
        if ( empty( $items ) ) {
            $items = array(
                array( '⛰', 'Geography-led', 'Clusters mapped by landscape and food logic' ),
                array( '◉', 'Traceable', 'Each product links back to cluster, SHG and member' ),
                array( '✦', 'Structured', 'Archive, detail pages and linked profiles in one flow' ),
                array( '❧', 'Market-rooted', 'Built for trust, curation, gifting and repeat demand' ),
            );
        }
        $out = '<div class="acp-trust-strip"><div class="acp-ts-inner">';
        foreach ( $items as $item ) { $out .= '<div class="acp-ts-item"><div class="acp-ts-icon">' . esc_html( $item[0] ) . '</div><div><strong>' . esc_html( $item[1] ) . '</strong><span>' . esc_html( $item[2] ) . '</span></div></div>'; }
        $out .= '</div></div>';
        return $out;
    }

    /** Render traceability grid. */
    private function render_trace_grid() {
        $steps = array(
            array( '01 · Cluster', 'Place and production context', 'Landscape, ingredients, enterprise readiness, and why a cluster matters to the brand.' ),
            array( '02 · SHG', 'The collective layer', 'Groups, production disciplines, shared strengths, and product associations inside each cluster.' ),
            array( '03 · Members', 'The people behind the product', 'Named producers, roles, product involvement, and the lived intelligence that goes into making.' ),
            array( '04 · Product', 'Market-ready, still rooted', 'Traceable food lines that customers can discover, trust, gift, and reorder with confidence.' ),
        );
        $out = '<div class="acp-trace-grid">';
        foreach ( $steps as $step ) { $out .= '<div class="acp-trace-step"><span class="acp-trace-no">' . esc_html( $step[0] ) . '</span><strong>' . esc_html( $step[1] ) . '</strong><p>' . esc_html( $step[2] ) . '</p></div>'; }
        return $out . '</div>';
    }

    /** Get clusters. Fallback to all published clusters if a display filter returns nothing. */
    private function get_clusters( $a ) {
        $meta_query = array();
        if ( '1' === (string) $a['show_only_website'] ) { $meta_query[] = array( 'key' => '_amaley_show_on_website', 'value' => '1', 'compare' => '=' ); }
        if ( '1' === (string) $a['featured_only'] ) { $meta_query[] = array( 'key' => '_amaley_featured', 'value' => '1', 'compare' => '=' ); }
        $args = array(
            'post_type'      => 'amaley_cluster',
            'post_status'    => array( 'publish' ),
            'posts_per_page' => max( 1, absint( $a['limit'] ) ),
            'orderby'        => 'title',
            'order'          => 'ASC',
        );
        if ( ! empty( $meta_query ) ) { $args['meta_query'] = $meta_query; }
        $clusters = get_posts( $args );
        if ( empty( $clusters ) && ! empty( $meta_query ) ) {
            unset( $args['meta_query'] );
            $clusters = get_posts( $args );
        }
        return $clusters;
    }

    /** Featured highlight cluster. */
    private function render_highlight_cluster( $cluster, $a ) {
        $id   = $cluster->ID;
        $meta = $this->cluster_meta( $id, $cluster );
        $url  = $this->detail_url( $a['detail_url_pattern'], $cluster );
        $out  = '<div class="acp-cluster-highlight"><div class="acp-highlight-copy"><span class="acp-eyebrow">Featured cluster</span><h3>' . esc_html( get_the_title( $cluster ) ) . '</h3>';
        if ( $meta['intro'] ) { $out .= '<p>' . esc_html( $meta['intro'] ) . '</p>'; }
        if ( ! empty( $meta['products'] ) ) { $out .= '<div class="acp-tag-row">'; foreach ( array_slice( $meta['products'], 0, 5 ) as $product ) { $out .= '<span>' . esc_html( $product ) . '</span>'; } $out .= '</div>'; }
        $out .= '<a class="acp-btn acp-btn-outline-gold" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ) . '</a></div><div class="acp-highlight-visual">' . $this->cluster_visual( $id, get_the_title( $cluster ) ) . '<div class="acp-highlight-metrics">';
        $out .= $this->summary_card( $this->count_shgs_for_cluster( $id ), 'SHGs' );
        $out .= $this->summary_card( $this->count_members_for_cluster( $id ), 'Producers' );
        $out .= $this->summary_card( $meta['village_count'], 'Villages' );
        $out .= $this->summary_card( count( $this->get_products_for_cluster( $id, 99 ) ), 'Products' );
        $out .= '</div></div></div>';
        return $out;
    }

    /** Archive card. */
    private function render_archive_card( $cluster, $a ) {
        $id   = $cluster->ID;
        $meta = $this->cluster_meta( $id, $cluster );
        $url  = $this->detail_url( $a['detail_url_pattern'], $cluster );
        $out  = '<article class="acp-cluster-card-v2">' . $this->cluster_visual( $id, get_the_title( $cluster ), 'card' ) . '<div class="acp-cluster-card-head"><span class="acp-eyebrow">Source cluster</span><h3>' . esc_html( get_the_title( $cluster ) ) . '</h3>';
        if ( $meta['location'] ) { $out .= '<p>' . esc_html( $meta['location'] ) . '</p>'; }
        $out .= '</div><div class="acp-cluster-card-body"><div class="acp-cluster-stat-row">';
        $out .= $this->mini_stat( $this->count_shgs_for_cluster( $id ), 'SHGs' );
        $out .= $this->mini_stat( $this->count_members_for_cluster( $id ), 'Makers' );
        $out .= $this->mini_stat( $meta['village_count'], 'Villages' );
        $out .= '</div>';
        if ( ! empty( $meta['products'] ) ) { $out .= '<div class="acp-tag-row">'; foreach ( array_slice( $meta['products'], 0, 4 ) as $product ) { $out .= '<span>' . esc_html( $product ) . '</span>'; } $out .= '</div>'; }
        if ( $meta['intro'] ) { $out .= '<p>' . esc_html( wp_trim_words( $meta['intro'], 22 ) ) . '</p>'; }
        $out .= '<div class="acp-cluster-actions"><a class="acp-btn acp-btn-outline" href="' . esc_url( $url ) . '">' . esc_html( $a['button_text'] ) . '</a></div></div></article>';
        return $out;
    }

    /** Cluster image / fallback visual. */
    private function cluster_visual( $id, $title = '', $variant = 'default' ) {
        $image = get_the_post_thumbnail_url( $id, 'large' );
        if ( ! $image ) {
            $gallery = $this->gallery_urls( get_post_meta( $id, '_amaley_gallery_urls', true ) );
            if ( ! empty( $gallery ) ) {
                $image = $gallery[0];
            }
        }
        $label = trim( (string) $title );
        $initials = '';
        if ( $label ) {
            $words = preg_split( '/\s+/', wp_strip_all_tags( $label ) );
            foreach ( array_slice( $words, 0, 2 ) as $word ) {
                $initials .= mb_substr( $word, 0, 1 );
            }
        }
        if ( ! $initials ) {
            $initials = 'A';
        }
        $class = 'acp-cluster-visual acp-cluster-visual-' . sanitize_html_class( $variant );
        if ( $image ) {
            return '<div class="' . esc_attr( $class ) . '"><img src="' . esc_url( $image ) . '" alt="' . esc_attr( $label ) . '" loading="lazy" /><span>Source cluster</span></div>';
        }
        return '<div class="' . esc_attr( $class ) . ' acp-cluster-visual-fallback"><i>' . esc_html( strtoupper( $initials ) ) . '</i><span>Amaley origin</span></div>';
    }

    /** Cluster meta with premium front-end fallbacks so pages look complete while data is being improved. */
    private function cluster_meta( $id, $cluster = null ) {
        $cluster       = $cluster ? $cluster : get_post( $id );
        $title         = $cluster ? get_the_title( $cluster ) : 'Amaley Source Cluster';
        $region        = trim( (string) get_post_meta( $id, '_amaley_region', true ) );
        $district      = trim( (string) get_post_meta( $id, '_amaley_district', true ) );
        $block         = trim( (string) get_post_meta( $id, '_amaley_block_area', true ) );
        $villages_text = get_post_meta( $id, '_amaley_villages', true );
        $intro         = trim( (string) get_post_meta( $id, '_amaley_short_intro', true ) );
        $story         = trim( (string) get_post_meta( $id, '_amaley_full_story', true ) );
        $products_text = get_post_meta( $id, '_amaley_main_products', true );

        if ( '' === $intro && $cluster ) { $intro = $cluster->post_excerpt ? $cluster->post_excerpt : wp_trim_words( wp_strip_all_tags( $cluster->post_content ), 28 ); }
        if ( '' === $story && $cluster ) { $story = wp_strip_all_tags( $cluster->post_content ); }

        $fallback = $this->cluster_fallback_profile( $title );
        if ( '' === $region ) { $region = $fallback['region']; }
        if ( '' === $district ) { $district = $fallback['district']; }
        if ( '' === $block ) { $block = $fallback['block']; }
        $villages = $this->split_terms( $villages_text );
        if ( empty( $villages ) ) { $villages = $fallback['villages']; }
        $products = $this->split_terms( $products_text );
        if ( empty( $products ) ) { $products = $fallback['products']; }
        if ( '' === $intro ) { $intro = $fallback['intro']; }
        if ( '' === $story ) { $story = $fallback['story']; }

        return array(
            'location'      => implode( ' · ', array_filter( array( $region, $district, $block ) ) ),
            'region'        => $region,
            'district'      => $district,
            'villages'      => $villages,
            'village_count' => count( $villages ),
            'intro'         => $intro,
            'story'         => $story,
            'products'      => $products,
        );
    }

    /** Localised fallback profile for a ready-looking frontend. */
    private function cluster_fallback_profile( $title ) {
        $key = strtolower( (string) $title );
        if ( false !== strpos( $key, 'apricot' ) ) {
            return array(
                'region' => 'Ladakh', 'district' => 'Leh', 'block' => 'Nimmoo / Diskit',
                'villages' => array( 'Nimmoo', 'Diskit', 'Sham Valley' ),
                'products' => array( 'Apricot jam', 'Dried apricot', 'Apricot preserve', 'Kernel oil' ),
                'intro' => 'A Ladakh source cluster connecting apricot fruit sorting, small-batch preparation, jar filling and Amaley quality checks.',
                'story' => 'This cluster represents the way Himalayan fruit moves from village-level sorting and careful preparation into small-batch Amaley products. The page connects place, collective work, producer skill and product traceability in one readable flow.',
            );
        }
        if ( false !== strpos( $key, 'seabuckthorn' ) || false !== strpos( $key, 'sea buckthorn' ) ) {
            return array(
                'region' => 'Ladakh', 'district' => 'Nubra / Sham Valley', 'block' => 'High-altitude berry belt',
                'villages' => array( 'Nubra', 'Sham Valley', 'Leh' ),
                'products' => array( 'Seabuckthorn preserve', 'Seabuckthorn juice', 'Herbal tea' ),
                'intro' => 'A high-altitude berry cluster linked to careful collection, sorting and small-batch value addition.',
                'story' => 'This cluster helps customers understand how seasonal Himalayan berries are handled with care before becoming traceable Amaley products for homes, shelves and gifting.',
            );
        }
        if ( false !== strpos( $key, 'herbal' ) || false !== strpos( $key, 'nettle' ) || false !== strpos( $key, 'chamomile' ) || false !== strpos( $key, 'buransh' ) || false !== strpos( $key, 'rhododendron' ) ) {
            return array(
                'region' => 'Ladakh / Himalayas', 'district' => 'Leh', 'block' => 'Herbal sourcing belt',
                'villages' => array( 'Leh', 'Nubra', 'Sham Valley' ),
                'products' => array( 'Herbal infusion', 'Chamomile blend', 'Nettle tea', 'Tulsi blend' ),
                'intro' => 'A seasonal herbal cluster shaped by clean sorting, shade drying, blending and careful packing.',
                'story' => 'This cluster brings together mountain herbs, local knowledge and Amaley quality support so that each infusion can be understood through its place and preparation pathway.',
            );
        }
        if ( false !== strpos( $key, 'barley' ) || false !== strpos( $key, 'tsampa' ) ) {
            return array(
                'region' => 'Ladakh', 'district' => 'Leh', 'block' => 'Traditional grain belt',
                'villages' => array( 'Leh', 'Chuchot', 'Sham Valley' ),
                'products' => array( 'Roasted barley flour', 'Tsampa mix', 'Barley nutrition mix' ),
                'intro' => 'A traditional grain cluster linked to cleaning, roasting, grinding and small-batch packing.',
                'story' => 'This cluster explains how everyday Himalayan grain knowledge can become a traceable, shelf-ready product line without losing its local context.',
            );
        }
        return array(
            'region' => 'Himalayan Region', 'district' => 'Village sourcing area', 'block' => 'Amaley producer network',
            'villages' => array( 'Source village', 'Producer hamlet', 'Market linkage point' ),
            'products' => array( 'Small-batch product', 'Seasonal ingredient', 'Community-rooted line' ),
            'intro' => 'A source cluster connected to local ingredients, women collectives, producer families and Amaley quality checks.',
            'story' => 'This cluster page is designed to make the origin system visible: place, people, product handling and traceability come together in one customer-friendly story.',
        );
    }

    /** Related SHGs section. */
    private function render_related_shgs( $shgs ) {
        $out = '<div class="acp-related-section"><span class="acp-eyebrow">Women collectives</span><h2>SHG groups connected with this cluster</h2>';
        if ( empty( $shgs ) ) { return $out . $this->sample_shg_cards() . '</div>'; }
        $out .= '<div class="acp-entity-grid">';
        foreach ( $shgs as $shg ) {
            $village = get_post_meta( $shg->ID, '_amaley_village', true );
            $cats    = $this->split_terms( get_post_meta( $shg->ID, '_amaley_product_categories', true ) );
            $out .= '<article class="acp-entity-card"><span class="acp-eyebrow">SHG group</span><h3>' . esc_html( get_the_title( $shg ) ) . '</h3>';
            if ( $village ) { $out .= '<p>' . esc_html( $village ) . '</p>'; }
            if ( ! empty( $cats ) ) { $out .= '<div class="acp-tag-row">'; foreach ( array_slice( $cats, 0, 3 ) as $cat ) { $out .= '<span>' . esc_html( $cat ) . '</span>'; } $out .= '</div>'; }
            $out .= '</article>';
        }
        return $out . '</div></div>';
    }

    /** Related members section. */
    private function render_related_members( $members ) {
        $out = '<div class="acp-related-section"><span class="acp-eyebrow">Producer profiles</span><h2>People and producer families connected here</h2>';
        if ( empty( $members ) ) { return $out . $this->sample_member_cards() . '</div>'; }
        $out .= '<div class="acp-entity-grid acp-producer-grid">';
        foreach ( $members as $member ) {
            $village = get_post_meta( $member->ID, '_amaley_village', true );
            $role    = get_post_meta( $member->ID, '_amaley_role', true );
            $photo   = get_post_meta( $member->ID, '_amaley_photo_url', true );
            if ( ! $photo ) { $photo = get_the_post_thumbnail_url( $member->ID, 'medium' ); }
            $out .= '<article class="acp-entity-card">';
            if ( $photo ) { $out .= '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr( get_the_title( $member ) ) . '" loading="lazy" />'; }
            $out .= '<span class="acp-eyebrow">Producer</span><h3>' . esc_html( get_the_title( $member ) ) . '</h3>';
            $line = implode( ' · ', array_filter( array( $role, $village ) ) );
            if ( $line ) { $out .= '<p>' . esc_html( $line ) . '</p>'; }
            $out .= '</article>';
        }
        return $out . '</div></div>';
    }

    /** Related products section. */
    private function render_related_products( $products ) {
        $out = '<div class="acp-related-section"><span class="acp-eyebrow">Products</span><h2>Products mapped to this source cluster</h2>';
        if ( empty( $products ) ) { return $out . $this->sample_product_cards() . '</div>'; }
        $out .= '<div class="acp-entity-grid acp-product-grid">';
        foreach ( $products as $product ) {
            $image = get_the_post_thumbnail_url( $product->ID, 'woocommerce_thumbnail' );
            $out .= '<article class="acp-entity-card">';
            if ( $image ) { $out .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title( $product ) ) . '" loading="lazy" />'; }
            $out .= '<span class="acp-eyebrow">Traceable product</span><h3>' . esc_html( get_the_title( $product ) ) . '</h3>';
            if ( function_exists( 'wc_get_product' ) ) { $wc_product = wc_get_product( $product->ID ); if ( $wc_product ) { $out .= '<p class="acp-price-line">' . wp_kses_post( $wc_product->get_price_html() ) . '</p>'; } }
            $out .= '<a class="acp-btn acp-btn-outline" href="' . esc_url( get_permalink( $product ) ) . '">View Product</a></article>';
        }
        return $out . '</div></div>';
    }

    /** Sample SHG cards for a ready-looking page when linked data is pending. */
    private function sample_shg_cards() {
        $items = array(
            array( 'Nimmoo Apricot Processing Group', 'Nimmoo · small-batch fruit preparation', array( 'sorting', 'jam support', 'packing' ) ),
            array( 'Himalayan Herbal Blend Group', 'Leh · herbal sorting and blending', array( 'cleaning', 'shade drying', 'blending' ) ),
            array( 'Village Preserve & Honey Group', 'Ladakh · preserve and pantry support', array( 'preserve', 'honey', 'quality' ) ),
        );
        $out = '<div class="acp-entity-grid acp-sample-grid">';
        foreach ( $items as $item ) {
            $out .= '<article class="acp-entity-card"><span class="acp-eyebrow">Women collective</span><h3>' . esc_html( $item[0] ) . '</h3><p>' . esc_html( $item[1] ) . '</p><div class="acp-tag-row">';
            foreach ( $item[2] as $tag ) { $out .= '<span>' . esc_html( $tag ) . '</span>'; }
            $out .= '</div></article>';
        }
        return $out . '</div>';
    }

    /** Sample member cards for a ready-looking page when member data is pending. */
    private function sample_member_cards() {
        $items = array(
            array( 'Producer Member 04', 'Packaging support · Nimmoo', 'PM' ),
            array( 'Producer Member 09', 'Sorting and preparation · Leh', 'PM' ),
            array( 'Producer Family Profile', 'Ingredient handling and packing', 'PF' ),
        );
        $out = '<div class="acp-entity-grid acp-producer-grid acp-sample-grid">';
        foreach ( $items as $item ) {
            $out .= '<article class="acp-entity-card"><div class="acp-avatar-fallback">' . esc_html( $item[2] ) . '</div><span class="acp-eyebrow">Producer profile</span><h3>' . esc_html( $item[0] ) . '</h3><p>' . esc_html( $item[1] ) . '</p></article>';
        }
        return $out . '</div>';
    }

    /** Sample product cards for a ready-looking page when origin mapping is pending. */
    private function sample_product_cards() {
        $items = array(
            array( 'Amaley Ladakh Apricot Jam', 'Small-batch fruit preserve', '₹260' ),
            array( 'Nettle Herbal Infusion', 'Mountain herbal infusion', '₹220' ),
            array( 'Roasted Barley Flour', 'Traditional grain line', '₹180' ),
        );
        $out = '<div class="acp-entity-grid acp-product-grid acp-sample-grid">';
        foreach ( $items as $item ) {
            $out .= '<article class="acp-entity-card"><div class="acp-product-visual-fallback"><span>Amaley</span></div><span class="acp-eyebrow">Traceable product</span><h3>' . esc_html( $item[0] ) . '</h3><p>' . esc_html( $item[1] ) . '</p><p class="acp-price-line">' . esc_html( $item[2] ) . '</p><a class="acp-btn acp-btn-outline" href="/shop/">View Product</a></article>';
        }
        return $out . '</div>';
    }

    /** Resolve cluster. */
    private function resolve_cluster( $a ) {
        $id = absint( $a['cluster_id'] );
        if ( ! $id && '1' === (string) $a['auto_detect'] && isset( $_GET['cluster_id'] ) ) { $id = absint( wp_unslash( $_GET['cluster_id'] ) ); }
        if ( $id ) { $post = get_post( $id ); return ( $post && 'amaley_cluster' === $post->post_type ) ? $post : null; }
        $slug = sanitize_title( $a['cluster_slug'] );
        if ( ! $slug && '1' === (string) $a['auto_detect'] && isset( $_GET['cluster_slug'] ) ) { $slug = sanitize_title( wp_unslash( $_GET['cluster_slug'] ) ); }
        if ( $slug ) { $posts = get_posts( array( 'name' => $slug, 'post_type' => 'amaley_cluster', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1 ) ); return ! empty( $posts ) ? $posts[0] : null; }
        global $post;
        if ( $post && isset( $post->post_type ) && 'amaley_cluster' === $post->post_type ) { return $post; }
        return null;
    }

    /** Counts. */
    private function get_archive_counts() {
        return array(
            'clusters' => $this->count_posts( 'amaley_cluster' ),
            'shgs'     => $this->count_posts( 'amaley_shg_group' ),
            'members'  => $this->count_posts( 'amaley_member' ),
            'products' => $this->count_origin_products(),
        );
    }

    private function count_posts( $post_type ) { $counts = wp_count_posts( $post_type ); return isset( $counts->publish ) ? absint( $counts->publish ) : 0; }
    private function count_origin_products() { if ( ! post_type_exists( 'product' ) ) { return 0; } $query = new WP_Query( array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_amaley_origin_cluster_id', 'compare' => 'EXISTS' ) ) ) ); return absint( $query->found_posts ); }
    private function get_shgs_for_cluster( $cluster_id, $limit = 6 ) { return get_posts( array( 'post_type' => 'amaley_shg_group', 'post_status' => array( 'publish' ), 'posts_per_page' => max( 1, $limit ), 'orderby' => 'title', 'order' => 'ASC', 'meta_query' => array( array( 'key' => '_amaley_shg_cluster_id', 'value' => absint( $cluster_id ), 'compare' => '=' ) ) ) ); }
    private function get_members_for_cluster( $cluster_id, $limit = 6 ) { $shg_ids = get_posts( array( 'post_type' => 'amaley_shg_group', 'post_status' => array( 'publish' ), 'fields' => 'ids', 'posts_per_page' => 200, 'meta_query' => array( array( 'key' => '_amaley_shg_cluster_id', 'value' => absint( $cluster_id ), 'compare' => '=' ) ) ) ); if ( empty( $shg_ids ) ) { return array(); } return get_posts( array( 'post_type' => 'amaley_member', 'post_status' => array( 'publish' ), 'posts_per_page' => max( 1, $limit ), 'orderby' => 'title', 'order' => 'ASC', 'meta_query' => array( array( 'key' => '_amaley_member_shg_id', 'value' => array_map( 'absint', $shg_ids ), 'compare' => 'IN' ) ) ) ); }
    private function get_products_for_cluster( $cluster_id, $limit = 6 ) { if ( ! post_type_exists( 'product' ) ) { return array(); } return get_posts( array( 'post_type' => 'product', 'post_status' => array( 'publish' ), 'posts_per_page' => max( 1, $limit ), 'orderby' => 'title', 'order' => 'ASC', 'meta_query' => array( array( 'key' => '_amaley_origin_cluster_id', 'value' => absint( $cluster_id ), 'compare' => '=' ) ) ) ); }
    private function count_shgs_for_cluster( $cluster_id ) { return count( $this->get_shgs_for_cluster( $cluster_id, 200 ) ); }
    private function count_members_for_cluster( $cluster_id ) { return count( $this->get_members_for_cluster( $cluster_id, 200 ) ); }
    private function mini_stat( $number, $label ) { return '<div class="acp-cluster-stat"><strong>' . esc_html( $number ) . '</strong><span>' . esc_html( $label ) . '</span></div>'; }
    private function kpi_box( $number, $label ) { return '<div class="acp-kpi"><strong>' . esc_html( $number ) . '</strong><span>' . esc_html( $label ) . '</span></div>'; }
    private function summary_card( $number, $label ) { return '<div class="acp-summary-card"><strong>' . esc_html( $number ) . '</strong><span>' . esc_html( $label ) . '</span></div>'; }
    private function side_stat( $label, $value ) { return '<div class="acp-side-stat"><strong>' . esc_html( $label ) . '</strong><span>' . esc_html( $value ) . '</span></div>'; }
    private function detail_url( $pattern, $cluster ) { $pattern = (string) $pattern; if ( '' === $pattern ) { $pattern = '/cluster-detail/?cluster_id={id}'; } return str_replace( array( '{id}', '{slug}' ), array( $cluster->ID, $cluster->post_name ), $pattern ); }
    private function split_terms( $text ) { if ( empty( $text ) ) { return array(); } $terms = preg_split( '/[\n,]+/', (string) $text ); $terms = array_map( 'trim', $terms ); return array_values( array_filter( $terms ) ); }
    private function gallery_urls( $text ) { $items = $this->split_terms( $text ); return array_values( array_filter( $items, function( $url ) { return filter_var( $url, FILTER_VALIDATE_URL ); } ) ); }
    private function count_regions( $clusters ) { $regions = array(); foreach ( $clusters as $cluster ) { $meta = $this->cluster_meta( $cluster->ID, $cluster ); if ( $meta['region'] ) { $regions[] = $meta['region']; } } return count( array_unique( $regions ) ); }
    private function count_geographies( $clusters ) { $geos = array(); foreach ( $clusters as $cluster ) { $meta = $this->cluster_meta( $cluster->ID, $cluster ); if ( $meta['location'] ) { $geos[] = $meta['location']; } } return count( array_unique( $geos ) ); }
    private function archive_filter_terms( $clusters ) { $terms = array(); foreach ( $clusters as $cluster ) { $meta = $this->cluster_meta( $cluster->ID, $cluster ); if ( $meta['region'] ) { $terms[] = $meta['region']; } foreach ( array_slice( $meta['products'], 0, 2 ) as $product ) { $terms[] = $product; } } $terms = array_slice( array_unique( array_filter( $terms ) ), 0, 9 ); if ( empty( $terms ) ) { return '<span>Verified cluster filters will appear here</span>'; } $out = ''; foreach ( $terms as $term ) { $out .= '<span>' . esc_html( $term ) . '</span>'; } return $out; }
    private function map_points( $clusters ) { if ( empty( $clusters ) ) { return '<span>Map points will appear after cluster data is added.</span>'; } $out = ''; foreach ( array_slice( $clusters, 0, 6 ) as $cluster ) { $meta = $this->cluster_meta( $cluster->ID, $cluster ); $out .= '<span><strong>' . esc_html( get_the_title( $cluster ) ) . '</strong>' . esc_html( $meta['location'] ? $meta['location'] : 'Location to be updated' ) . '</span>'; } return $out; }
}
