<?php
/**
 * Cluster Archive Section Widgets renderer.
 * v1.0.32 rebuilds archive section widgets with full Elementor control coverage.
 *
 * This is the safe Elementor-first section system. It does not replace theme
 * templates, WooCommerce templates, header, footer, routes or permalinks.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Cluster_Archive_Sections {
    /** Constructor. */
    public function __construct() {
        $GLOBALS['amaley_core_cluster_archive_sections'] = $this;
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );

        add_shortcode( 'amaley_cluster_archive_hero', array( $this, 'shortcode_hero' ) );
        add_shortcode( 'amaley_cluster_archive_trust_strip', array( $this, 'shortcode_trust_strip' ) );
        add_shortcode( 'amaley_cluster_archive_intro', array( $this, 'shortcode_intro' ) );
        add_shortcode( 'amaley_cluster_archive_grid', array( $this, 'shortcode_grid' ) );
        add_shortcode( 'amaley_cluster_archive_cta', array( $this, 'shortcode_cta' ) );

        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
    }

    /** Register frontend assets. */
    public function register_assets() {
        wp_register_style( 'amaley-core-cluster-archive-sections', AMALEY_CORE_URL . 'assets/amaley-core-cluster-archive-sections.css', array(), AMALEY_CORE_VERSION );
    }

    /** Enqueue frontend assets. */
    public function enqueue_assets() {
        wp_enqueue_style( 'amaley-core-cluster-archive-sections' );
    }

    /** Register Elementor category. */
    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    /** Register Elementor section widgets. */
    public function register_elementor_widgets( $widgets_manager ) {
        if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
            return;
        }

        $files = array(
            'class-amaley-core-cluster-archive-hero-widget.php',
            'class-amaley-core-cluster-archive-trust-strip-widget.php',
            'class-amaley-core-cluster-archive-intro-widget.php',
            'class-amaley-core-cluster-archive-grid-widget.php',
            'class-amaley-core-cluster-archive-cta-widget.php',
        );

        foreach ( $files as $file_name ) {
            $file = AMALEY_CORE_PATH . 'includes/widgets/' . $file_name;
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }

        $widgets = array(
            'Amaley_Core_Cluster_Archive_Hero_Widget',
            'Amaley_Core_Cluster_Archive_Trust_Strip_Widget',
            'Amaley_Core_Cluster_Archive_Intro_Widget',
            'Amaley_Core_Cluster_Archive_Grid_Widget',
            'Amaley_Core_Cluster_Archive_CTA_Widget',
        );

        foreach ( $widgets as $class_name ) {
            if ( class_exists( $class_name ) && method_exists( $widgets_manager, 'register' ) ) {
                $widgets_manager->register( new $class_name() );
            }
        }
    }

    /** Basic yes/no helper. */
    public function boolish( $value ) {
        return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true );
    }

    /** Sanitize scalar attr. */
    private function s( $value ) {
        return is_scalar( $value ) ? trim( (string) $value ) : '';
    }

    /** Template settings shared with Amaley Core Settings. */
    public function template_settings() {
        $defaults = array(
            'cluster_single_page_id' => '0',
            'cluster_detail_param_mode' => 'slug',
            'archive_detail_url_pattern' => '/cluster-detail/?cluster_slug={slug}',
        );
        $saved = get_option( 'amaley_core_template_settings', array() );
        return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
    }

    /** Build the assigned single-cluster detail URL pattern. */
    public function assigned_single_detail_pattern() {
        $settings = $this->template_settings();
        $single_id = absint( isset( $settings['cluster_single_page_id'] ) ? $settings['cluster_single_page_id'] : 0 );
        $mode = isset( $settings['cluster_detail_param_mode'] ) && 'id' === $settings['cluster_detail_param_mode'] ? 'id' : 'slug';

        if ( $single_id && get_post_status( $single_id ) ) {
            $base = get_permalink( $single_id );
            if ( $base ) {
                $separator = false === strpos( $base, '?' ) ? '?' : '&';
                return $base . $separator . ( 'id' === $mode ? 'cluster_id={id}' : 'cluster_slug={slug}' );
            }
        }

        return ! empty( $settings['archive_detail_url_pattern'] ) ? $settings['archive_detail_url_pattern'] : '/cluster-detail/?cluster_slug={slug}';
    }

    /** Resolve detail pattern from widget controls and global assignment. */
    public function resolve_detail_url_pattern( $override = '', $use_assigned = '1' ) {
        if ( $this->boolish( $use_assigned ) ) {
            return $this->assigned_single_detail_pattern();
        }
        $override = $this->s( $override );
        return '' !== $override ? $override : $this->assigned_single_detail_pattern();
    }

    /** Shortcode hero. */
    public function shortcode_hero( $atts ) { $this->enqueue_assets(); return $this->render_hero( is_array( $atts ) ? $atts : array() ); }
    /** Shortcode trust. */
    public function shortcode_trust_strip( $atts ) { $this->enqueue_assets(); return $this->render_trust_strip( is_array( $atts ) ? $atts : array() ); }
    /** Shortcode intro. */
    public function shortcode_intro( $atts ) { $this->enqueue_assets(); return $this->render_intro( is_array( $atts ) ? $atts : array() ); }
    /** Shortcode grid. */
    public function shortcode_grid( $atts ) { $this->enqueue_assets(); return $this->render_grid( is_array( $atts ) ? $atts : array() ); }
    /** Shortcode CTA. */
    public function shortcode_cta( $atts ) { $this->enqueue_assets(); return $this->render_cta( is_array( $atts ) ? $atts : array() ); }

    /** Defaults: hero. */
    public function hero_defaults() {
        return array(
            'label'              => 'Amaley Origins',
            'title'              => 'Browse Amaley Source Clusters',
            'accent'             => 'Clusters',
            'description'        => 'Explore origin geographies, women collectives, producer families and products through a simple cluster directory.',
            'home_label'         => 'Home',
            'home_url'           => '/',
            'middle_label'       => 'Shop',
            'middle_url'         => '/shop/',
            'current_label'      => 'Clusters',
            'primary_text'       => 'Explore Products',
            'primary_url'        => '/shop/',
            'secondary_text'     => 'Know the Collectives',
            'secondary_url'      => '#cluster-grid',
            'show_breadcrumbs'   => '1',
            'show_stats'         => '1',
            'show_buttons'       => '1',
            'hero_height'        => 'compact',
            'visual_style'       => 'directory',
            'right_image_url'    => '',
            'right_caption'      => 'Origin-led Amaley directory',
            'stat_one_label'     => 'Clusters',
            'stat_two_label'     => 'SHGs',
            'stat_three_label'   => 'Producers',
        );
    }

    /** Defaults: trust. */
    public function trust_defaults() {
        return array(
            'item_one_icon' => '⌂',
            'item_one_title' => 'Geography-led',
            'item_one_text' => 'Browse by place and origin.',
            'item_two_icon' => '✦',
            'item_two_title' => 'Traceable',
            'item_two_text' => 'Connected to groups and makers.',
            'item_three_icon' => '♧',
            'item_three_title' => 'Community-rooted',
            'item_three_text' => 'Built through producer networks.',
            'item_four_icon' => '→',
            'item_four_title' => 'Product-linked',
            'item_four_text' => 'Open products from each cluster.',
        );
    }

    /** Defaults: intro. */
    public function intro_defaults() {
        return array(
            'label' => 'Why clusters matter',
            'title' => 'Every Amaley product begins somewhere.',
            'description' => 'A cluster is not just a location. It connects ingredients, villages, women collectives, producer skills and product stories into one clear origin system.',
            'card_one_title' => 'Place',
            'card_one_text' => 'Region, village and local ingredient base.',
            'card_two_title' => 'People',
            'card_two_text' => 'SHGs, producers and skilled hands behind the work.',
            'card_three_title' => 'Product',
            'card_three_text' => 'Mapped products that carry the origin forward.',
        );
    }

    /** Defaults: grid. */
    public function grid_defaults() {
        return array(
            'label' => 'Cluster directory',
            'title' => 'Open a cluster to explore the full origin story',
            'description' => 'Each cluster card opens a deeper page with its SHGs, producers, mapped products and origin journey.',
            'limit' => '12',
            'columns_desktop' => '3',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
            'show_only_website' => '',
            'featured_only' => '',
            'include_ids' => '',
            'exclude_ids' => '',
            'order_by' => 'title',
            'order' => 'ASC',
            'use_template_single' => '1',
            'detail_url_pattern' => '',
            'button_text' => 'View Cluster',
            'empty_message' => 'No Amaley clusters are available yet.',
            'show_image' => '1',
            'show_region' => '1',
            'show_villages' => '1',
            'show_products' => '1',
            'show_counts' => '1',
            'show_button' => '1',
        );
    }

    /** Defaults: CTA. */
    public function cta_defaults() {
        return array(
            'label' => 'Build origin-led shelves',
            'title' => 'Use Amaley clusters for products, gifting, hospitality and retail partnerships.',
            'description' => 'Cluster visibility helps customers and partners understand what they are buying, where it comes from and who is connected to the product journey.',
            'button_text' => 'Explore Amaley Products',
            'button_url' => '/shop/',
            'secondary_text' => 'Contact Amaley',
            'secondary_url' => '/contact/',
        );
    }

    /** Stats. */
    public function stats() {
        $clusters = wp_count_posts( 'amaley_cluster' );
        $shgs     = wp_count_posts( 'amaley_shg_group' );
        $members  = wp_count_posts( 'amaley_member' );
        return array(
            'clusters' => isset( $clusters->publish ) ? (int) $clusters->publish : 0,
            'shgs'     => isset( $shgs->publish ) ? (int) $shgs->publish : 0,
            'members'  => isset( $members->publish ) ? (int) $members->publish : 0,
        );
    }

    /** Render hero. */
    public function render_hero( $atts ) {
        $a = shortcode_atts( $this->hero_defaults(), $atts, 'amaley_cluster_archive_hero' );
        $stats = $this->stats();
        $classes = 'amaley-archive-sec amcas-hero amcas-hero-' . sanitize_html_class( $a['hero_height'] ) . ' amcas-hero-style-' . sanitize_html_class( $a['visual_style'] );
        ob_start();
        ?>
        <section class="<?php echo esc_attr( $classes ); ?>">
            <div class="amcas-hero-bg"></div>
            <div class="amcas-hero-inner">
                <div class="amcas-hero-copy">
                    <?php if ( $this->boolish( $a['show_breadcrumbs'] ) ) : ?>
                        <nav class="amcas-breadcrumb" aria-label="Breadcrumb">
                            <a href="<?php echo esc_url( $a['home_url'] ); ?>"><?php echo esc_html( $a['home_label'] ); ?></a><span>/</span>
                            <a href="<?php echo esc_url( $a['middle_url'] ); ?>"><?php echo esc_html( $a['middle_label'] ); ?></a><span>/</span>
                            <strong><?php echo esc_html( $a['current_label'] ); ?></strong>
                        </nav>
                    <?php endif; ?>
                    <p class="amcas-label"><?php echo esc_html( $a['label'] ); ?></p>
                    <h1><?php echo esc_html( $a['title'] ); ?> <em><?php echo esc_html( $a['accent'] ); ?></em></h1>
                    <p class="amcas-hero-desc"><?php echo esc_html( $a['description'] ); ?></p>
                    <?php if ( $this->boolish( $a['show_buttons'] ) ) : ?>
                        <div class="amcas-actions">
                            <a class="amcas-btn amcas-btn-gold" href="<?php echo esc_url( $a['primary_url'] ); ?>"><?php echo esc_html( $a['primary_text'] ); ?></a>
                            <a class="amcas-btn amcas-btn-outline" href="<?php echo esc_url( $a['secondary_url'] ); ?>"><?php echo esc_html( $a['secondary_text'] ); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <aside class="amcas-hero-side">
                    <?php if ( ! empty( $a['right_image_url'] ) ) : ?>
                        <img src="<?php echo esc_url( $a['right_image_url'] ); ?>" alt="" loading="lazy" />
                    <?php else : ?>
                        <div class="amcas-hero-mark"><span>Amaley</span><strong>Origin Directory</strong><small><?php echo esc_html( $a['right_caption'] ); ?></small></div>
                    <?php endif; ?>
                    <?php if ( $this->boolish( $a['show_stats'] ) ) : ?>
                        <div class="amcas-hero-stats">
                            <span><strong><?php echo esc_html( $stats['clusters'] ); ?></strong><?php echo esc_html( $a['stat_one_label'] ); ?></span>
                            <span><strong><?php echo esc_html( $stats['shgs'] ); ?></strong><?php echo esc_html( $a['stat_two_label'] ); ?></span>
                            <span><strong><?php echo esc_html( $stats['members'] ); ?></strong><?php echo esc_html( $a['stat_three_label'] ); ?></span>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render trust strip. */
    public function render_trust_strip( $atts ) {
        $a = shortcode_atts( $this->trust_defaults(), $atts, 'amaley_cluster_archive_trust_strip' );
        $items = array(
            array( $a['item_one_icon'], $a['item_one_title'], $a['item_one_text'] ),
            array( $a['item_two_icon'], $a['item_two_title'], $a['item_two_text'] ),
            array( $a['item_three_icon'], $a['item_three_title'], $a['item_three_text'] ),
            array( $a['item_four_icon'], $a['item_four_title'], $a['item_four_text'] ),
        );
        ob_start();
        ?>
        <section class="amaley-archive-sec amcas-trust">
            <div class="amcas-trust-inner">
                <?php foreach ( $items as $item ) : ?>
                    <div class="amcas-trust-item"><span><?php echo esc_html( $item[0] ); ?></span><div><strong><?php echo esc_html( $item[1] ); ?></strong><small><?php echo esc_html( $item[2] ); ?></small></div></div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render intro. */
    public function render_intro( $atts ) {
        $a = shortcode_atts( $this->intro_defaults(), $atts, 'amaley_cluster_archive_intro' );
        $cards = array(
            array( $a['card_one_title'], $a['card_one_text'] ),
            array( $a['card_two_title'], $a['card_two_text'] ),
            array( $a['card_three_title'], $a['card_three_text'] ),
        );
        ob_start();
        ?>
        <section class="amaley-archive-sec amcas-intro">
            <div class="amcas-wrap amcas-intro-grid">
                <div class="amcas-intro-copy"><p class="amcas-label"><?php echo esc_html( $a['label'] ); ?></p><h2><?php echo esc_html( $a['title'] ); ?></h2><p><?php echo esc_html( $a['description'] ); ?></p></div>
                <div class="amcas-intro-cards">
                    <?php foreach ( $cards as $card ) : ?>
                        <div class="amcas-info-card"><strong><?php echo esc_html( $card[0] ); ?></strong><span><?php echo esc_html( $card[1] ); ?></span></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Query clusters. */
    public function get_clusters( $atts ) {
        $a = shortcode_atts( $this->grid_defaults(), $atts );
        $args = array(
            'post_type'      => 'amaley_cluster',
            'post_status'    => 'publish',
            'posts_per_page' => max( 1, min( 60, absint( $a['limit'] ) ) ),
            'orderby'        => in_array( $a['order_by'], array( 'title', 'date', 'modified', 'rand', 'menu_order' ), true ) ? $a['order_by'] : 'title',
            'order'          => 'DESC' === strtoupper( $a['order'] ) ? 'DESC' : 'ASC',
        );
        $include_ids = $this->csv_ids( $a['include_ids'] );
        $exclude_ids = $this->csv_ids( $a['exclude_ids'] );
        if ( $include_ids ) { $args['post__in'] = $include_ids; }
        if ( $exclude_ids ) { $args['post__not_in'] = $exclude_ids; }
        $meta_query = array();
        if ( $this->boolish( $a['show_only_website'] ) ) {
            $meta_query[] = array( 'key' => '_amaley_show_on_website', 'value' => '1', 'compare' => '=' );
        }
        if ( $this->boolish( $a['featured_only'] ) ) {
            $meta_query[] = array( 'key' => '_amaley_featured', 'value' => '1', 'compare' => '=' );
        }
        if ( $meta_query ) { $args['meta_query'] = $meta_query; }
        return new WP_Query( $args );
    }

    /** CSV to IDs. */
    public function csv_ids( $value ) {
        return array_values( array_filter( array_map( 'absint', preg_split( '/[\s,]+/', (string) $value ) ) ) );
    }

    /** Get meta. */
    public function meta( $post_id, $key, $fallback = '' ) {
        $value = get_post_meta( $post_id, $key, true );
        return '' === $value || null === $value ? $fallback : $value;
    }

    /** List from comma string. */
    public function split_list( $value, $limit = 4 ) {
        $items = array_filter( array_map( 'trim', preg_split( '/[,\n]+/', (string) $value ) ) );
        return array_slice( $items, 0, $limit );
    }

    /** Image URL. */
    public function cluster_image_url( $post_id ) {
        $featured = get_the_post_thumbnail_url( $post_id, 'large' );
        if ( $featured ) { return $featured; }
        $gallery = $this->meta( $post_id, '_amaley_gallery_urls' );
        $items = $this->split_list( $gallery, 1 );
        return $items ? esc_url_raw( $items[0] ) : '';
    }

    /** Related counts. */
    public function related_counts( $cluster_id ) {
        $shgs = new WP_Query( array(
            'post_type' => 'amaley_shg_group', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids',
            'meta_query' => array( array( 'key' => '_amaley_shg_cluster_id', 'value' => (string) $cluster_id, 'compare' => '=' ) ),
        ) );
        $members = 0;
        $shg_ids = get_posts( array(
            'post_type' => 'amaley_shg_group', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids',
            'meta_query' => array( array( 'key' => '_amaley_shg_cluster_id', 'value' => (string) $cluster_id, 'compare' => '=' ) ),
        ) );
        if ( $shg_ids ) {
            $mq = array( 'relation' => 'OR' );
            foreach ( $shg_ids as $sid ) { $mq[] = array( 'key' => '_amaley_member_shg_id', 'value' => (string) $sid, 'compare' => '=' ); }
            $member_q = new WP_Query( array( 'post_type' => 'amaley_member', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => $mq ) );
            $members = (int) $member_q->found_posts;
        }
        return array( 'shgs' => (int) $shgs->found_posts, 'members' => $members );
    }

    /** Render grid. */
    public function render_grid( $atts ) {
        $a = shortcode_atts( $this->grid_defaults(), $atts, 'amaley_cluster_archive_grid' );
        $q = $this->get_clusters( $a );
        $detail_pattern = $this->resolve_detail_url_pattern( isset( $a['detail_url_pattern'] ) ? $a['detail_url_pattern'] : '', isset( $a['use_template_single'] ) ? $a['use_template_single'] : '1' );
        $style = '--amcas-cols:' . absint( $a['columns_desktop'] ) . ';--amcas-cols-tab:' . absint( $a['columns_tablet'] ) . ';--amcas-cols-mob:' . absint( $a['columns_mobile'] ) . ';';
        ob_start();
        ?>
        <section id="cluster-grid" class="amaley-archive-sec amcas-grid-sec" style="<?php echo esc_attr( $style ); ?>">
            <div class="amcas-wrap">
                <div class="amcas-sec-head amcas-sec-head-stacked"><p class="amcas-label"><?php echo esc_html( $a['label'] ); ?></p><h2><?php echo esc_html( $a['title'] ); ?></h2><p class="amcas-head-desc"><?php echo esc_html( $a['description'] ); ?></p></div>
                <?php if ( ! $q->have_posts() ) : ?>
                    <div class="amcas-empty"><?php echo esc_html( $a['empty_message'] ); ?></div>
                <?php else : ?>
                    <div class="amcas-grid">
                        <?php while ( $q->have_posts() ) : $q->the_post(); $id = get_the_ID(); $counts = $this->related_counts( $id ); $img = $this->cluster_image_url( $id ); $detail = str_replace( array( '{id}', '{slug}' ), array( $id, get_post_field( 'post_name', $id ) ), $detail_pattern ); ?>
                            <article class="amcas-cluster-card">
                                <?php if ( $this->boolish( $a['show_image'] ) ) : ?>
                                    <div class="amcas-card-media">
                                        <?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" /><?php else : ?><span><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span><?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="amcas-card-body">
                                    <p class="amcas-card-region"><?php echo esc_html( $this->meta( $id, '_amaley_region', $this->meta( $id, '_amaley_district', 'Amaley origin cluster' ) ) ); ?></p>
                                    <h3><?php echo esc_html( get_the_title() ); ?></h3>
                                    <?php if ( $this->boolish( $a['show_villages'] ) ) : ?><p class="amcas-card-text"><?php echo esc_html( $this->meta( $id, '_amaley_villages', 'Village details will be updated soon.' ) ); ?></p><?php endif; ?>
                                    <?php if ( $this->boolish( $a['show_products'] ) ) : ?><div class="amcas-tags"><?php foreach ( $this->split_list( $this->meta( $id, '_amaley_main_products', 'Himalayan ingredients, Small-batch products' ), 4 ) as $tag ) : ?><span><?php echo esc_html( $tag ); ?></span><?php endforeach; ?></div><?php endif; ?>
                                    <?php if ( $this->boolish( $a['show_counts'] ) ) : ?><div class="amcas-mini-stats"><span class="amcas-stat-box"><strong class="amcas-stat-number"><?php echo esc_html( $counts['shgs'] ); ?></strong><small class="amcas-stat-label">SHGs</small></span><span class="amcas-stat-box"><strong class="amcas-stat-number"><?php echo esc_html( $counts['members'] ); ?></strong><small class="amcas-stat-label">Producers</small></span></div><?php endif; ?>
                                    <?php if ( $this->boolish( $a['show_button'] ) ) : ?><a class="amcas-card-link" href="<?php echo esc_url( $detail ); ?>"><?php echo esc_html( $a['button_text'] ); ?></a><?php endif; ?>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render CTA. */
    public function render_cta( $atts ) {
        $a = shortcode_atts( $this->cta_defaults(), $atts, 'amaley_cluster_archive_cta' );
        ob_start();
        ?>
        <section class="amaley-archive-sec amcas-cta">
            <div class="amcas-wrap amcas-cta-inner">
                <div><p class="amcas-label"><?php echo esc_html( $a['label'] ); ?></p><h2><?php echo esc_html( $a['title'] ); ?></h2><p><?php echo esc_html( $a['description'] ); ?></p></div>
                <div class="amcas-actions"><a class="amcas-btn amcas-btn-gold" href="<?php echo esc_url( $a['button_url'] ); ?>"><?php echo esc_html( $a['button_text'] ); ?></a><a class="amcas-btn amcas-btn-outline-light" href="<?php echo esc_url( $a['secondary_url'] ); ?>"><?php echo esc_html( $a['secondary_text'] ); ?></a></div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }
}
