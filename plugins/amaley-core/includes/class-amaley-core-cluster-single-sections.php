<?php
/**
 * Cluster Single Template Section Widgets renderer.
 * v1.0.41 fixes group-like linked producer group rendering on cluster single templates under the Universal Full-Control Standard.
 * v1.0.82 connects Cluster Single SHG and Member/Producer cards to the central Amaley Core Card Renderer.
 * v1.0.82.1 fixes central card CSS loading inside Cluster Single Elementor preview/frontend.
 * v1.0.82.2 adds visual polish for Cluster Single SHG and Producer central cards.
 * v1.0.87 adds section-level Card Template selector for Cluster Single SHG and Producer widgets.
 * v1.0.88 maps existing Elementor style controls to OG universal card classes.
 * v1.0.89 adds card element show/hide controls and transform controls for Cluster OG cards.
 * v1.0.90 adds frontend pagination for Cluster Single SHG, Producer and Product related card sections.
 * v1.0.91 upgrades Cluster Single related-card pagination to AJAX/no-reload with normal URL fallback.
 *
 * No theme template override, no WooCommerce override, no permalink rewrite.
 * A normal WordPress page acts as the single template container.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Cluster_Single_Sections {
    /** Constructor. */
    public function __construct() {
        $GLOBALS['amaley_core_cluster_single_sections'] = $this;
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );

        add_action( 'wp_ajax_amaley_cluster_related_pagination', array( $this, 'ajax_related_pagination' ) );
        add_action( 'wp_ajax_nopriv_amaley_cluster_related_pagination', array( $this, 'ajax_related_pagination' ) );

        add_shortcode( 'amaley_cluster_single_hero_section', array( $this, 'shortcode_hero' ) );
        add_shortcode( 'amaley_cluster_single_snapshot_section', array( $this, 'shortcode_snapshot' ) );
        add_shortcode( 'amaley_cluster_single_story_section', array( $this, 'shortcode_story' ) );
        add_shortcode( 'amaley_cluster_single_shgs_section', array( $this, 'shortcode_shgs' ) );
        add_shortcode( 'amaley_cluster_single_producers_section', array( $this, 'shortcode_producers' ) );
        add_shortcode( 'amaley_cluster_single_products_section', array( $this, 'shortcode_products' ) );
        add_shortcode( 'amaley_cluster_single_gallery_section', array( $this, 'shortcode_gallery' ) );
        add_shortcode( 'amaley_cluster_single_contact_section', array( $this, 'shortcode_contact' ) );
        add_shortcode( 'amaley_cluster_single_cta_section', array( $this, 'shortcode_cta' ) );

        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
    }

    /** Register assets. */
    public function register_assets() {
        wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        wp_register_style( 'amaley-core-cluster-single-sections', AMALEY_CORE_URL . 'assets/amaley-core-cluster-single-sections.css', array( 'amaley-core-cards' ), AMALEY_CORE_VERSION );
        wp_register_script( 'amaley-core-cluster-pagination', AMALEY_CORE_URL . 'assets/amaley-core-cluster-pagination.js', array(), AMALEY_CORE_VERSION, true );
    }

    /** Enqueue assets. */
    public function enqueue_assets() {
        if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        }
        wp_enqueue_style( 'amaley-core-cards' );
        wp_enqueue_style( 'amaley-core-cluster-single-sections' );
        if ( ! wp_script_is( 'amaley-core-cluster-pagination', 'registered' ) ) {
            wp_register_script( 'amaley-core-cluster-pagination', AMALEY_CORE_URL . 'assets/amaley-core-cluster-pagination.js', array(), AMALEY_CORE_VERSION, true );
        }
        wp_enqueue_script( 'amaley-core-cluster-pagination' );
    }

    /** Register category. */
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
            'class-amaley-core-cluster-single-widget-controls.php',
            'class-amaley-core-cluster-single-hero-widget.php',
            'class-amaley-core-cluster-single-snapshot-widget.php',
            'class-amaley-core-cluster-single-story-widget.php',
            'class-amaley-core-cluster-single-shgs-widget.php',
            'class-amaley-core-cluster-single-producers-widget.php',
            'class-amaley-core-cluster-single-products-widget.php',
            'class-amaley-core-cluster-single-gallery-widget.php',
            'class-amaley-core-cluster-single-contact-widget.php',
            'class-amaley-core-cluster-single-cta-widget.php',
        );

        foreach ( $files as $file_name ) {
            $file = AMALEY_CORE_PATH . 'includes/widgets/' . $file_name;
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }

        $widgets = array(
            'Amaley_Core_Cluster_Single_Hero_Widget',
            'Amaley_Core_Cluster_Single_Snapshot_Widget',
            'Amaley_Core_Cluster_Single_Story_Widget',
            'Amaley_Core_Cluster_Single_SHGs_Widget',
            'Amaley_Core_Cluster_Single_Producers_Widget',
            'Amaley_Core_Cluster_Single_Products_Widget',
            'Amaley_Core_Cluster_Single_Gallery_Widget',
            'Amaley_Core_Cluster_Single_Contact_Widget',
            'Amaley_Core_Cluster_Single_CTA_Widget',
        );

        foreach ( $widgets as $class_name ) {
            if ( class_exists( $class_name ) && method_exists( $widgets_manager, 'register' ) ) {
                $widgets_manager->register( new $class_name() );
            }
        }
    }

    /** Yes/no helper. */
    public function boolish( $value ) {
        return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true );
    }

    /** Sanitize scalar helper. */
    public function s( $value ) {
        return is_scalar( $value ) ? trim( (string) $value ) : '';
    }

    /** Format rich text saved from cluster fields without double-wrapping existing paragraphs. */
    public function rich_text( $value ) {
        $value = is_scalar( $value ) ? trim( (string) $value ) : '';
        if ( '' === $value ) {
            return '';
        }
        if ( preg_match( '/<(p|br|ul|ol|li|blockquote|h1|h2|h3|h4|h5|h6|div)\b/i', $value ) ) {
            return wp_kses_post( $value );
        }
        return wp_kses_post( wpautop( $value ) );
    }

    /** Shortcodes. */
    public function shortcode_hero( $atts ) { $this->enqueue_assets(); return $this->render_hero( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_snapshot( $atts ) { $this->enqueue_assets(); return $this->render_snapshot( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_story( $atts ) { $this->enqueue_assets(); return $this->render_story( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_shgs( $atts ) { $this->enqueue_assets(); return $this->render_shgs( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_producers( $atts ) { $this->enqueue_assets(); return $this->render_producers( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_products( $atts ) { $this->enqueue_assets(); return $this->render_products( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_gallery( $atts ) { $this->enqueue_assets(); return $this->render_gallery( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_contact( $atts ) { $this->enqueue_assets(); return $this->render_contact( is_array( $atts ) ? $atts : array() ); }
    public function shortcode_cta( $atts ) { $this->enqueue_assets(); return $this->render_cta( is_array( $atts ) ? $atts : array() ); }

    /** Base defaults shared by all single widgets. */
    public function base_defaults() {
        return array(
            'cluster_id' => '',
            'cluster_slug' => '',
            'preview_cluster_id' => '',
            'auto_detect' => '1',
            'empty_message' => 'Select a preview cluster in Elementor, or open this page from a cluster archive card.',
        );
    }

    /** Hero defaults. */
    public function hero_defaults() {
        return wp_parse_args( array(
            'label' => 'Source Cluster',
            'home_label' => 'Home',
            'home_url' => '/',
            'middle_label' => 'Clusters',
            'middle_url' => '/clusters/',
            'show_breadcrumbs' => '1',
            'show_image' => '1',
            'show_meta' => '1',
            'show_buttons' => '1',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'Back to Clusters',
            'secondary_url' => '/clusters/',
        ), $this->base_defaults() );
    }

    /** Snapshot defaults. */
    public function snapshot_defaults() {
        return wp_parse_args( array(
            'label' => 'Cluster Snapshot',
            'title' => 'Quick details',
            'description' => 'A compact view of geography, products, collectives and producers connected with this source cluster.',
            'show_code' => '1',
            'show_region' => '1',
            'show_district' => '1',
            'show_block' => '1',
            'show_villages' => '1',
            'show_products' => '1',
            'show_shg_count' => '1',
            'show_producer_count' => '1',
            'show_product_count' => '1',
            'show_gallery_count' => '1',
            'show_contact' => '0',
        ), $this->base_defaults() );
    }

    /** Story defaults. */
    public function story_defaults() {
        return wp_parse_args( array(
            'label' => 'Cluster Story',
            'title' => 'The story behind this cluster',
            'show_products' => '1',
            'show_villages' => '1',
        ), $this->base_defaults() );
    }

    /** Related defaults. */
    public function related_defaults() {
        return wp_parse_args( array(
            'label' => 'Connected Network',
            'title' => 'Linked items',
            'description' => 'Records connected to this source cluster.',
            'limit' => '4',
            'show_all_connected' => '0',
            'show_section_button' => '1',
            'section_button_text' => 'View all',
            'section_button_url' => '#',
            'section_button_position' => 'after',
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
            'show_empty_state' => '1',
            'enable_pagination' => '1',
            'pagination_prev_text' => 'Previous',
            'pagination_next_text' => 'Next',
        ), $this->base_defaults() );
    }



    /** Gallery defaults. */
    public function gallery_defaults() {
        return wp_parse_args( array(
            'label' => 'Cluster Gallery',
            'title' => 'Images from this cluster',
            'description' => 'Visual references from the cluster, producers, ingredients or source geography.',
            'show_empty_state' => '1',
            'empty_message' => 'Gallery images are not added yet. Add image URLs in the Cluster gallery field or set a featured image.',
            'columns_desktop' => '3',
            'columns_tablet' => '2',
            'columns_mobile' => '1',
        ), $this->base_defaults() );
    }

    /** Contact/source defaults. */
    public function contact_defaults() {
        return wp_parse_args( array(
            'label' => 'Source Support',
            'title' => 'Need details about this cluster?',
            'description' => 'Contact Amaley for sourcing, partnership, retail shelves, institutional gifting or product storytelling connected to this cluster.',
            'show_contact_person' => '1',
            'show_phone' => '0',
            'show_location' => '1',
            'primary_text' => 'Contact Amaley',
            'primary_url' => '/contact/',
            'secondary_text' => 'Explore Products',
            'secondary_url' => '/shop/',
            'show_buttons' => '1',
        ), $this->base_defaults() );
    }

    /** CTA defaults. */
    public function cta_defaults() {
        return wp_parse_args( array(
            'label' => 'Work with Amaley',
            'title' => 'Build product stories from verified origin clusters.',
            'description' => 'Use cluster visibility for curated shelves, hospitality counters, conscious retail and partner storytelling.',
            'primary_text' => 'Explore Products',
            'primary_url' => '/shop/',
            'secondary_text' => 'Contact Amaley',
            'secondary_url' => '/contact/',
            'show_buttons' => '1',
        ), $this->base_defaults() );
    }

    /** Resolve current cluster from widget settings or URL. */
    public function resolve_cluster( $a = array() ) {
        $a = wp_parse_args( is_array( $a ) ? $a : array(), $this->base_defaults() );
        $id = absint( $a['cluster_id'] );
        if ( ! $id ) {
            $id = absint( $a['preview_cluster_id'] );
        }
        if ( ! $id && $this->boolish( $a['auto_detect'] ) && isset( $_GET['cluster_id'] ) ) {
            $id = absint( wp_unslash( $_GET['cluster_id'] ) );
        }
        if ( $id ) {
            $post = get_post( $id );
            return ( $post && 'amaley_cluster' === $post->post_type ) ? $post : null;
        }

        $slug = sanitize_title( $a['cluster_slug'] );
        if ( ! $slug && $this->boolish( $a['auto_detect'] ) && isset( $_GET['cluster_slug'] ) ) {
            $slug = sanitize_title( wp_unslash( $_GET['cluster_slug'] ) );
        }
        if ( $slug ) {
            $posts = get_posts( array( 'name' => $slug, 'post_type' => 'amaley_cluster', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1 ) );
            return ! empty( $posts ) ? $posts[0] : null;
        }

        if ( $this->is_elementor_editor_context() ) {
            $posts = get_posts( array( 'post_type' => 'amaley_cluster', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
            return ! empty( $posts ) ? $posts[0] : null;
        }

        global $post;
        if ( $post && isset( $post->post_type ) && 'amaley_cluster' === $post->post_type ) {
            return $post;
        }

        return null;
    }

    /** Detect Elementor editor/preview. */
    private function is_elementor_editor_context() {
        if ( isset( $_GET['elementor-preview'] ) || isset( $_GET['preview_id'] ) ) {
            return true;
        }
        if ( class_exists( '\\Elementor\\Plugin' ) ) {
            try {
                return isset( \Elementor\Plugin::$instance->editor ) && \Elementor\Plugin::$instance->editor->is_edit_mode();
            } catch ( Exception $e ) {
                return false;
            }
        }
        return false;
    }

    /** Empty state. */
    public function empty_state( $message = '' ) {
        $message = $message ? $message : 'Cluster data is not available yet.';
        return '<section class="amcss-section amcss-empty"><div class="amcss-container"><p>' . esc_html( $message ) . '</p></div></section>';
    }

    /** Cluster meta bundle. */
    public function cluster_meta( $cluster ) {
        $id = is_object( $cluster ) ? $cluster->ID : absint( $cluster );
        $post = is_object( $cluster ) ? $cluster : get_post( $id );
        $villages = $this->split_terms( get_post_meta( $id, '_amaley_villages', true ) );
        $products = $this->split_terms( get_post_meta( $id, '_amaley_main_products', true ) );
        $region   = $this->s( get_post_meta( $id, '_amaley_region', true ) );
        $district = $this->s( get_post_meta( $id, '_amaley_district', true ) );
        $block    = $this->s( get_post_meta( $id, '_amaley_block_area', true ) );
        $story    = $this->s( get_post_meta( $id, '_amaley_full_story', true ) );
        if ( '' === $story && $post ) {
            $story = wp_strip_all_tags( $post->post_content );
        }
        $intro = $this->s( get_post_meta( $id, '_amaley_short_intro', true ) );
        if ( '' === $intro && $post ) {
            $intro = $post->post_excerpt ? wp_strip_all_tags( $post->post_excerpt ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 28 );
        }
        $location_parts = array_filter( array( $block, $district, $region ) );
        $image = get_the_post_thumbnail_url( $id, 'large' );
        $gallery = $this->gallery_urls( get_post_meta( $id, '_amaley_gallery_urls', true ) );
        if ( ! $image && ! empty( $gallery ) ) {
            $image = $gallery[0];
        }
        return array(
            'title' => $post ? get_the_title( $post ) : '',
            'code' => $this->s( get_post_meta( $id, '_amaley_cluster_code', true ) ),
            'status' => $this->s( get_post_meta( $id, '_amaley_status', true ) ),
            'label' => $this->s( get_post_meta( $id, '_amaley_short_label', true ) ),
            'region' => $region,
            'district' => $district,
            'block' => $block,
            'location' => implode( ', ', $location_parts ),
            'villages' => $villages,
            'products' => $products,
            'intro' => $intro,
            'story' => $story,
            'image' => $image ? $image : '',
            'gallery' => $gallery,
            'contact_person' => $this->s( get_post_meta( $id, '_amaley_contact_person', true ) ),
            'phone' => $this->s( get_post_meta( $id, '_amaley_phone', true ) ),
        );
    }

    /** Render hero. */
    public function render_hero( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->hero_defaults() );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $m = $this->cluster_meta( $cluster );
        $this->enqueue_assets();
        ob_start();
        ?>
        <section class="amcss-section amcss-hero">
            <div class="amcss-container amcss-hero-grid">
                <div class="amcss-hero-content">
                    <?php if ( $this->boolish( $a['show_breadcrumbs'] ) ) : ?>
                        <nav class="amcss-breadcrumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( $a['home_url'] ); ?>"><?php echo esc_html( $a['home_label'] ); ?></a><span>/</span><a href="<?php echo esc_url( $a['middle_url'] ); ?>"><?php echo esc_html( $a['middle_label'] ); ?></a><span>/</span><strong><?php echo esc_html( $m['title'] ); ?></strong></nav>
                    <?php endif; ?>
                    <span class="amcss-label"><?php echo esc_html( $a['label'] ); ?></span>
                    <h1 class="amcss-title"><?php echo esc_html( $m['title'] ); ?></h1>
                    <p class="amcss-description"><?php echo esc_html( $m['intro'] ? $m['intro'] : $a['empty_message'] ); ?></p>
                    <?php if ( $this->boolish( $a['show_meta'] ) ) : ?>
                        <div class="amcss-chip-row">
                            <?php if ( $m['region'] ) : ?><span><?php echo esc_html( $m['region'] ); ?></span><?php endif; ?>
                            <?php if ( $m['district'] ) : ?><span><?php echo esc_html( $m['district'] ); ?></span><?php endif; ?>
                            <?php if ( ! empty( $m['products'] ) ) : ?><span><?php echo esc_html( implode( ' · ', array_slice( $m['products'], 0, 2 ) ) ); ?></span><?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $this->boolish( $a['show_buttons'] ) ) : ?>
                        <div class="amcss-button-row"><a class="amcss-btn amcss-btn-primary" href="<?php echo esc_url( $a['primary_url'] ); ?>"><?php echo esc_html( $a['primary_text'] ); ?></a><a class="amcss-btn amcss-btn-secondary" href="<?php echo esc_url( $a['secondary_url'] ); ?>"><?php echo esc_html( $a['secondary_text'] ); ?></a></div>
                    <?php endif; ?>
                </div>
                <?php if ( $this->boolish( $a['show_image'] ) ) : ?>
                    <div class="amcss-hero-media">
                        <?php if ( $m['image'] ) : ?><img src="<?php echo esc_url( $m['image'] ); ?>" alt="<?php echo esc_attr( $m['title'] ); ?>"><?php else : ?><div class="amcss-image-fallback"><span><?php echo esc_html( mb_substr( $m['title'], 0, 2 ) ); ?></span></div><?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render snapshot. */
    public function render_snapshot( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->snapshot_defaults() );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $m = $this->cluster_meta( $cluster );
        $items = array();
        if ( $this->boolish( $a['show_code'] ) ) { $items[] = array( 'Cluster code', $m['code'] ? $m['code'] : 'To be updated' ); }
        if ( $this->boolish( $a['show_region'] ) ) { $items[] = array( 'Region', $m['region'] ? $m['region'] : 'To be updated' ); }
        if ( $this->boolish( $a['show_district'] ) ) { $items[] = array( 'District', $m['district'] ? $m['district'] : 'To be updated' ); }
        if ( $this->boolish( $a['show_block'] ) ) { $items[] = array( 'Block / Area', $m['block'] ? $m['block'] : 'To be updated' ); }
        if ( $this->boolish( $a['show_villages'] ) ) { $items[] = array( 'Villages', ! empty( $m['villages'] ) ? implode( ', ', array_slice( $m['villages'], 0, 6 ) ) : 'To be updated' ); }
        if ( $this->boolish( $a['show_products'] ) ) { $items[] = array( 'Main products', ! empty( $m['products'] ) ? implode( ', ', array_slice( $m['products'], 0, 6 ) ) : 'To be updated' ); }
        if ( $this->boolish( $a['show_shg_count'] ) ) { $items[] = array( 'SHGs', (string) count( $this->get_shgs_for_cluster( $cluster->ID, 200 ) ) ); }
        if ( $this->boolish( $a['show_producer_count'] ) ) { $items[] = array( 'Producers', (string) count( $this->get_members_for_cluster( $cluster->ID, 200 ) ) ); }
        if ( $this->boolish( $a['show_product_count'] ) ) { $items[] = array( 'Mapped products', (string) count( $this->get_products_for_cluster( $cluster->ID, 200 ) ) ); }
        if ( $this->boolish( $a['show_gallery_count'] ) ) { $items[] = array( 'Gallery images', (string) count( $m['gallery'] ) ); }
        if ( $this->boolish( $a['show_contact'] ) ) { $items[] = array( 'Contact', $m['contact_person'] ? $m['contact_person'] : 'Use Amaley enquiry' ); }
        $this->enqueue_assets();
        ob_start();
        ?>
        <section class="amcss-section amcss-snapshot">
            <div class="amcss-container">
                <div class="amcss-heading"><span class="amcss-label"><?php echo esc_html( $a['label'] ); ?></span><h2><?php echo esc_html( $a['title'] ); ?></h2><p><?php echo esc_html( $a['description'] ); ?></p></div>
                <div class="amcss-snapshot-grid">
                    <?php foreach ( $items as $item ) : ?><div class="amcss-stat-card"><span class="amcss-stat-label"><?php echo esc_html( $item[0] ); ?></span><strong class="amcss-stat-value"><?php echo esc_html( $item[1] ); ?></strong></div><?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render story. */
    public function render_story( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->story_defaults() );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $m = $this->cluster_meta( $cluster );
        $story = $m['story'] ? $m['story'] : $this->generated_cluster_story( $m );
        $this->enqueue_assets();
        ob_start();
        ?>
        <section class="amcss-section amcss-story">
            <div class="amcss-container amcss-story-grid">
                <div class="amcss-story-copy"><span class="amcss-label"><?php echo esc_html( $a['label'] ); ?></span><h2><?php echo esc_html( $a['title'] ); ?></h2><div class="amcss-rich-text"><?php echo $this->rich_text( $story ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div></div>
                <aside class="amcss-story-side">
                    <?php if ( $this->boolish( $a['show_products'] ) && ! empty( $m['products'] ) ) : ?><div class="amcss-side-box"><h3>Main products</h3><div class="amcss-chip-row"><?php foreach ( $m['products'] as $product ) : ?><span><?php echo esc_html( $product ); ?></span><?php endforeach; ?></div></div><?php endif; ?>
                    <?php if ( $this->boolish( $a['show_villages'] ) && ! empty( $m['villages'] ) ) : ?><div class="amcss-side-box"><h3>Villages</h3><ul><?php foreach ( $m['villages'] as $village ) : ?><li><?php echo esc_html( $village ); ?></li><?php endforeach; ?></ul></div><?php endif; ?>
                </aside>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render SHGs. */
    public function render_shgs( $atts = array() ) {
        $type_defaults = array(
            'label' => 'Women collectives',
            'title' => 'SHGs connected with this cluster',
            'description' => 'Groups directly linked with this source cluster.',
            'limit' => '4',
            'show_all_connected' => '0',
            'section_button_text' => 'View all SHG groups',
            'section_button_url' => '/shg-groups/',
            'card_template' => 'og_card_1',
        );
        $a = wp_parse_args( $atts, wp_parse_args( $type_defaults, $this->related_defaults() ) );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $a['_cluster_id'] = absint( $cluster->ID );
        $limit = max( 1, absint( $a['limit'] ) );
        $total = count( $this->get_shg_ids_for_cluster( $cluster->ID ) );
        $paged = $this->related_current_page( 'shg' );
        $offset = 0;
        if ( ! empty( $a['show_all_connected'] ) && $this->boolish( $a['show_all_connected'] ) ) {
            $limit = 200;
            $paged = 1;
        } elseif ( $this->boolish( isset( $a['enable_pagination'] ) ? $a['enable_pagination'] : '1' ) ) {
            $offset = ( $paged - 1 ) * $limit;
            $a['_pagination'] = $this->pagination_data( 'shg', $total, $limit, $paged, $a );
        }
        $items = $this->get_shgs_for_cluster( $cluster->ID, $limit, $offset );
        return $this->render_related_cards( $a, $items, 'shg' );
    }

    /** Render producers. */
    public function render_producers( $atts = array() ) {
        $type_defaults = array(
            'label' => 'Producer profiles',
            'title' => 'People behind the cluster',
            'description' => 'Members and producers connected through linked SHGs.',
            'limit' => '4',
            'show_all_connected' => '0',
            'section_button_text' => 'View all producers',
            'section_button_url' => '/members-producers/',
            'card_template' => 'og_card_1',
        );
        $a = wp_parse_args( $atts, wp_parse_args( $type_defaults, $this->related_defaults() ) );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $a['_cluster_id'] = absint( $cluster->ID );
        $limit = max( 1, absint( $a['limit'] ) );
        $total = count( $this->get_member_ids_for_cluster( $cluster->ID ) );
        $paged = $this->related_current_page( 'producer' );
        $offset = 0;
        if ( ! empty( $a['show_all_connected'] ) && $this->boolish( $a['show_all_connected'] ) ) {
            $limit = 200;
            $paged = 1;
        } elseif ( $this->boolish( isset( $a['enable_pagination'] ) ? $a['enable_pagination'] : '1' ) ) {
            $offset = ( $paged - 1 ) * $limit;
            $a['_pagination'] = $this->pagination_data( 'producer', $total, $limit, $paged, $a );
        }
        $items = $this->get_members_for_cluster( $cluster->ID, $limit, $offset );
        return $this->render_related_cards( $a, $items, 'producer' );
    }

    /** Render products. */
    public function render_products( $atts = array() ) {
        $type_defaults = array(
            'label' => 'Mapped products',
            'title' => 'Products mapped to this cluster',
            'description' => 'WooCommerce products carrying this cluster as their origin.',
            'limit' => '4',
            'show_all_connected' => '0',
            'section_button_text' => 'View all products',
            'section_button_url' => '/shop/',
        );
        $a = wp_parse_args( $atts, wp_parse_args( $type_defaults, $this->related_defaults() ) );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $a['_cluster_id'] = absint( $cluster->ID );
        $limit = max( 1, absint( $a['limit'] ) );
        $total = count( $this->get_product_ids_for_cluster( $cluster->ID ) );
        $paged = $this->related_current_page( 'product' );
        $offset = 0;
        if ( ! empty( $a['show_all_connected'] ) && $this->boolish( $a['show_all_connected'] ) ) {
            $limit = 200;
            $paged = 1;
        } elseif ( $this->boolish( isset( $a['enable_pagination'] ) ? $a['enable_pagination'] : '1' ) ) {
            $offset = ( $paged - 1 ) * $limit;
            $a['_pagination'] = $this->pagination_data( 'product', $total, $limit, $paged, $a );
        }
        $items = $this->get_products_for_cluster( $cluster->ID, $limit, $offset );
        return $this->render_related_cards( $a, $items, 'product' );
    }

    /** Shared cards renderer. */
    private function render_related_cards( $a, $items, $type ) {
        $this->enqueue_assets();
        $cols = '--amcss-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--amcss-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--amcss-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';
        $cluster_id = isset( $a['_cluster_id'] ) ? absint( $a['_cluster_id'] ) : 0;
        $ajax_settings = $this->ajax_settings_for_related( $a );
        ob_start();
        ?>
        <section id="amcss-related-<?php echo esc_attr( $type ); ?>" class="amcss-section amcss-related amcss-related-<?php echo esc_attr( $type ); ?>" data-amcss-related-section="1" data-amcss-type="<?php echo esc_attr( $type ); ?>" data-amcss-cluster-id="<?php echo esc_attr( $cluster_id ); ?>" data-amcss-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-amcss-nonce="<?php echo esc_attr( wp_create_nonce( 'amaley_cluster_related_pagination' ) ); ?>" data-amcss-settings="<?php echo esc_attr( wp_json_encode( $ajax_settings ) ); ?>">
            <div class="amcss-container">
                <div class="amcss-heading"><span class="amcss-label"><?php echo esc_html( $a['label'] ); ?></span><h2><?php echo esc_html( $a['title'] ); ?></h2><p><?php echo esc_html( $a['description'] ); ?></p></div>
                <div class="amcss-related-results" data-amcss-results="1">
                    <?php echo $this->render_related_results_inner( $a, $items, $type, $cols ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
                <?php if ( $this->boolish( isset( $a['show_section_button'] ) ? $a['show_section_button'] : '0' ) && ! empty( $a['section_button_text'] ) && ! empty( $a['section_button_url'] ) ) : ?>
                    <div class="amcss-section-action amcss-section-action-<?php echo esc_attr( isset( $a['section_button_position'] ) ? $a['section_button_position'] : 'after' ); ?>">
                        <a class="amcss-btn amcss-btn-secondary amcss-section-link" href="<?php echo esc_url( $a['section_button_url'] ); ?>"><?php echo esc_html( $a['section_button_text'] ); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Render only card-grid + pagination inner HTML.
     *
     * @param array  $a Widget settings.
     * @param array  $items Posts.
     * @param string $type Section type.
     * @param string $cols CSS custom property string.
     * @return string
     */
    private function render_related_results_inner( $a, $items, $type, $cols ) {
        ob_start();
        ?>
        <?php if ( empty( $items ) ) : ?>
            <?php if ( $this->boolish( $a['show_empty_state'] ) ) : ?><div class="amcss-card amcss-empty-card"><p><?php echo esc_html( $a['empty_message'] ); ?></p></div><?php endif; ?>
        <?php else : ?>
            <div class="amcss-card-grid" style="<?php echo esc_attr( $cols ); ?>">
                <?php foreach ( $items as $item ) : echo $this->related_card( $item, $type, $a ); endforeach; ?>
            </div>
        <?php endif; ?>
        <?php echo $this->render_related_pagination( isset( $a['_pagination'] ) ? $a['_pagination'] : array() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php
        return ob_get_clean();
    }

    /**
     * Whitelisted settings needed for AJAX pagination.
     *
     * @param array $a Widget settings.
     * @return array
     */
    private function ajax_settings_for_related( $a ) {
        $allowed = array(
            'limit',
            'columns_desktop',
            'columns_tablet',
            'columns_mobile',
            'show_empty_state',
            'empty_message',
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
        );

        $out = array();
        foreach ( $allowed as $key ) {
            if ( isset( $a[ $key ] ) ) {
                $out[ $key ] = is_scalar( $a[ $key ] ) ? (string) $a[ $key ] : '';
            }
        }

        return $out;
    }

    /**
     * AJAX handler for no-reload related-card pagination.
     *
     * Returns only the cards grid + pagination block, not the full page.
     */
    public function ajax_related_pagination() {
        if ( ! check_ajax_referer( 'amaley_cluster_related_pagination', 'nonce', false ) ) {
            wp_send_json_error( array( 'message' => 'Invalid pagination request.' ), 403 );
        }

        $type = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
        $cluster_id = isset( $_POST['cluster_id'] ) ? absint( wp_unslash( $_POST['cluster_id'] ) ) : 0;
        $page = isset( $_POST['page'] ) ? max( 1, absint( wp_unslash( $_POST['page'] ) ) ) : 1;
        $settings_json = isset( $_POST['settings'] ) ? wp_unslash( $_POST['settings'] ) : '{}';
        $settings = json_decode( (string) $settings_json, true );
        if ( ! is_array( $settings ) ) {
            $settings = array();
        }

        if ( ! $cluster_id || ! in_array( $type, array( 'shg', 'producer', 'product' ), true ) ) {
            wp_send_json_error( array( 'message' => 'Missing pagination data.' ), 400 );
        }

        $a = wp_parse_args( $settings, $this->related_defaults() );
        $a['_cluster_id'] = $cluster_id;
        $a['enable_pagination'] = '1';
        $a['show_all_connected'] = '0';

        $limit = max( 1, absint( isset( $a['limit'] ) ? $a['limit'] : 4 ) );
        $offset = ( $page - 1 ) * $limit;

        if ( 'shg' === $type ) {
            $total = count( $this->get_shg_ids_for_cluster( $cluster_id ) );
            $items = $this->get_shgs_for_cluster( $cluster_id, $limit, $offset );
        } elseif ( 'producer' === $type ) {
            $total = count( $this->get_member_ids_for_cluster( $cluster_id ) );
            $items = $this->get_members_for_cluster( $cluster_id, $limit, $offset );
        } else {
            $total = count( $this->get_product_ids_for_cluster( $cluster_id ) );
            $items = $this->get_products_for_cluster( $cluster_id, $limit, $offset );
        }

        $a['_pagination'] = $this->pagination_data( $type, $total, $limit, $page, $a );
        $cols = '--amcss-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--amcss-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--amcss-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';

        wp_send_json_success( array(
            'html' => $this->render_related_results_inner( $a, $items, $type, $cols ),
        ) );
    }

    /**
     * Current page for a related-card section.
     *
     * @param string $type Related section type.
     * @return int
     */
    private function related_current_page( $type ) {
        $type = sanitize_key( $type );
        $key  = 'amcss_' . $type . '_page';
        $page = isset( $_GET[ $key ] ) ? absint( wp_unslash( $_GET[ $key ] ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return max( 1, $page );
    }

    /**
     * Pagination metadata.
     *
     * @param string $type Related section type.
     * @param int    $total Total items.
     * @param int    $per_page Items per page.
     * @param int    $current Current page.
     * @param array  $a Widget settings.
     * @return array
     */
    private function pagination_data( $type, $total, $per_page, $current, $a ) {
        $total = max( 0, absint( $total ) );
        $per_page = max( 1, absint( $per_page ) );
        $pages = (int) ceil( $total / $per_page );

        if ( $pages <= 1 ) {
            return array();
        }

        return array(
            'type' => sanitize_key( $type ),
            'key' => 'amcss_' . sanitize_key( $type ) . '_page',
            'total' => $total,
            'per_page' => $per_page,
            'current' => max( 1, min( absint( $current ), $pages ) ),
            'pages' => $pages,
            'prev_text' => ! empty( $a['pagination_prev_text'] ) ? (string) $a['pagination_prev_text'] : 'Previous',
            'next_text' => ! empty( $a['pagination_next_text'] ) ? (string) $a['pagination_next_text'] : 'Next',
        );
    }

    /**
     * Render pagination for related cards.
     *
     * @param array $p Pagination metadata.
     * @return string
     */
    private function render_related_pagination( $p ) {
        if ( empty( $p ) || empty( $p['pages'] ) || absint( $p['pages'] ) <= 1 ) {
            return '';
        }

        $type = sanitize_key( $p['type'] );
        $key = sanitize_key( $p['key'] );
        $current = max( 1, absint( $p['current'] ) );
        $pages = max( 1, absint( $p['pages'] ) );
        $anchor = 'amcss-related-' . $type;

        $out = '<nav class="amcss-pagination amcss-pagination-' . esc_attr( $type ) . '" aria-label="' . esc_attr__( 'Related cards pagination', 'amaley-core' ) . '">';

        if ( $current > 1 ) {
            $out .= '<a class="amcss-page-link amcss-page-prev" data-amcss-page="' . esc_attr( $current - 1 ) . '" href="' . esc_url( $this->pagination_url( $key, $current - 1, $anchor ) ) . '">' . esc_html( $p['prev_text'] ) . '</a>';
        }

        $window = 2;
        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( 1 !== $i && $pages !== $i && abs( $i - $current ) > $window ) {
                if ( 2 === $i || $pages - 1 === $i ) {
                    $out .= '<span class="amcss-page-ellipsis" aria-hidden="true">…</span>';
                }
                continue;
            }

            if ( $i === $current ) {
                $out .= '<span class="amcss-page-link amcss-page-current" aria-current="page">' . esc_html( (string) $i ) . '</span>';
            } else {
                $out .= '<a class="amcss-page-link" data-amcss-page="' . esc_attr( $i ) . '" href="' . esc_url( $this->pagination_url( $key, $i, $anchor ) ) . '">' . esc_html( (string) $i ) . '</a>';
            }
        }

        if ( $current < $pages ) {
            $out .= '<a class="amcss-page-link amcss-page-next" data-amcss-page="' . esc_attr( $current + 1 ) . '" href="' . esc_url( $this->pagination_url( $key, $current + 1, $anchor ) ) . '">' . esc_html( $p['next_text'] ) . '</a>';
        }

        $out .= '</nav>';

        return $out;
    }

    /**
     * Build pagination URL while preserving the current cluster query arguments.
     *
     * @param string $key Query key.
     * @param int    $page Page number.
     * @param string $anchor HTML anchor.
     * @return string
     */
    private function pagination_url( $key, $page, $anchor ) {
        $url = add_query_arg( sanitize_key( $key ), max( 1, absint( $page ) ) );
        return $url . '#' . sanitize_key( $anchor );
    }

    /** Build safe links from related cards to their assigned template pages. */
    private function related_detail_url( $post, $type ) {
        $settings = get_option( 'amaley_core_template_settings', array() );
        $id       = absint( $post->ID );
        $slug     = $post->post_name;

        if ( 'shg' === $type ) {
            $page_id = absint( isset( $settings['shg_single_page_id'] ) ? $settings['shg_single_page_id'] : 0 );
            $base    = $page_id ? get_permalink( $page_id ) : home_url( '/shg-detail/' );
            return add_query_arg( array( 'shg_slug' => $slug ), $base ? $base : home_url( '/' ) );
        }

        if ( 'producer' === $type ) {
            $page_id = absint( isset( $settings['producer_single_page_id'] ) ? $settings['producer_single_page_id'] : 0 );
            $base    = $page_id ? get_permalink( $page_id ) : home_url( '/producer-detail/' );
            return add_query_arg( array( 'member_slug' => $slug, 'member_id' => $id ), $base ? $base : home_url( '/' ) );
        }

        if ( 'cluster' === $type ) {
            $page_id = absint( isset( $settings['cluster_single_page_id'] ) ? $settings['cluster_single_page_id'] : 0 );
            $base    = $page_id ? get_permalink( $page_id ) : home_url( '/cluster-detail/' );
            return add_query_arg( array( 'cluster_slug' => $slug ), $base ? $base : home_url( '/' ) );
        }

        return get_permalink( $id );
    }

    /** Single related card. */
    private function related_card( $post, $type, $a = array() ) {
        $id = $post->ID;

        /*
         * v1.0.82: SHG and Producer cards now use the central Amaley Core Card Renderer
         * so cluster pages follow the final shared card structure.
         * Product cards stay on the existing product flow for now.
         */
        $card_template = isset( $a['card_template'] ) ? sanitize_key( $a['card_template'] ) : 'og_card_1';

        if ( 'current_existing' !== $card_template && class_exists( 'Amaley_Core_Card_Renderer' ) && in_array( $type, array( 'shg', 'producer' ), true ) ) {
            if ( 'shg' === $type ) {
                $preset = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::get_assignment( 'card_template_shg', 'og_shg_card_1' ) : 'og_shg_card_1';
                return Amaley_Core_Card_Renderer::render_shg( $id, array(
                    'preset' => $preset,
                    'url' => $this->related_detail_url( $post, 'shg' ),
                    'button_text' => 'View Collective Details',
                    'show_image' => $this->boolish( isset( $a['show_card_media'] ) ? $a['show_card_media'] : '1' ),
                    'show_label' => $this->boolish( isset( $a['show_card_label'] ) ? $a['show_card_label'] : '1' ),
                    'show_title' => $this->boolish( isset( $a['show_card_title'] ) ? $a['show_card_title'] : '1' ),
                    'show_excerpt' => $this->boolish( isset( $a['show_card_description'] ) ? $a['show_card_description'] : '1' ),
                    'show_meta' => $this->boolish( isset( $a['show_card_meta'] ) ? $a['show_card_meta'] : '1' ),
                    'show_tags' => $this->boolish( isset( $a['show_card_tags'] ) ? $a['show_card_tags'] : '1' ),
                    'show_button' => $this->boolish( isset( $a['show_card_button'] ) ? $a['show_card_button'] : '1' ),
                    'excerpt_words' => 18,
                    'class' => 'amaley-card--cluster-single-shg',
                ) );
            }

            if ( 'producer' === $type ) {
                $preset = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::get_assignment( 'card_template_member', 'og_member_card_1' ) : 'og_member_card_1';
                return Amaley_Core_Card_Renderer::render_member( $id, array(
                    'preset' => $preset,
                    'url' => $this->related_detail_url( $post, 'producer' ),
                    'button_text' => 'View Producer Profile',
                    'show_image' => $this->boolish( isset( $a['show_card_media'] ) ? $a['show_card_media'] : '1' ),
                    'show_label' => $this->boolish( isset( $a['show_card_label'] ) ? $a['show_card_label'] : '1' ),
                    'show_title' => $this->boolish( isset( $a['show_card_title'] ) ? $a['show_card_title'] : '1' ),
                    'show_excerpt' => $this->boolish( isset( $a['show_card_description'] ) ? $a['show_card_description'] : '1' ),
                    'show_meta' => $this->boolish( isset( $a['show_card_meta'] ) ? $a['show_card_meta'] : '1' ),
                    'show_tags' => $this->boolish( isset( $a['show_card_tags'] ) ? $a['show_card_tags'] : '1' ),
                    'show_button' => $this->boolish( isset( $a['show_card_button'] ) ? $a['show_card_button'] : '1' ),
                    'excerpt_words' => 18,
                    'class' => 'amaley-card--cluster-single-producer',
                ) );
            }
        }
        $image = get_the_post_thumbnail_url( $id, 'medium_large' );
        $title = get_the_title( $post );
        $excerpt = '';
        $meta_rows = array();
        $chips = array();
        $url = '#';
        $button = '';

        if ( 'shg' === $type ) {
            $excerpt = get_post_meta( $id, '_amaley_short_story', true );
            if ( '' === trim( (string) $excerpt ) ) { $excerpt = get_post_meta( $id, '_amaley_full_story', true ); }
            $village = $this->s( get_post_meta( $id, '_amaley_village', true ) );
            $district = $this->s( get_post_meta( $id, '_amaley_district', true ) );
            $members = $this->s( get_post_meta( $id, '_amaley_member_count', true ) );
            $verification = $this->s( get_post_meta( $id, '_amaley_verification_status', true ) );
            $contact = $this->s( get_post_meta( $id, '_amaley_contact_person', true ) );
            $categories = $this->split_terms( get_post_meta( $id, '_amaley_product_categories', true ) );
            $meta_rows = array_filter( array(
                $village ? array( 'Village', $village ) : null,
                $district ? array( 'District', $district ) : null,
                $members ? array( 'Members', $members ) : null,
                $verification ? array( 'Verification', ucfirst( $verification ) ) : null,
                $contact ? array( 'Contact', $contact ) : null,
            ) );
            $chips = array_slice( $categories, 0, 3 );
            if ( '' === trim( (string) $excerpt ) ) {
                $bits = array();
                if ( $village ) { $bits[] = 'based in ' . $village; }
                if ( $members ) { $bits[] = $members . ' members'; }
                if ( ! empty( $categories ) ) { $bits[] = 'working with ' . implode( ', ', array_slice( $categories, 0, 3 ) ); }
                $excerpt = ! empty( $bits ) ? 'This collective is ' . implode( ', ', $bits ) . '.' : '';
            }
            $url = $this->related_detail_url( $post, 'shg' );
            $button = 'View collective details';
        } elseif ( 'producer' === $type ) {
            $excerpt = get_post_meta( $id, '_amaley_short_bio', true );
            if ( '' === trim( (string) $excerpt ) ) { $excerpt = get_post_meta( $id, '_amaley_story', true ); }
            $role = $this->s( get_post_meta( $id, '_amaley_role', true ) );
            $village = $this->s( get_post_meta( $id, '_amaley_village', true ) );
            $phone = $this->s( get_post_meta( $id, '_amaley_phone', true ) );
            $skills = $this->split_terms( get_post_meta( $id, '_amaley_skills', true ) );
            $handled = $this->split_terms( get_post_meta( $id, '_amaley_products_handled', true ) );
            $photo = get_post_meta( $id, '_amaley_photo_url', true );
            if ( ! $image && filter_var( $photo, FILTER_VALIDATE_URL ) ) { $image = $photo; }
            $meta_rows = array_filter( array(
                $role ? array( 'Role', $role ) : null,
                $village ? array( 'Village', $village ) : null,
                $phone ? array( 'Phone', $phone ) : null,
            ) );
            $chips = array_slice( array_merge( $skills, $handled ), 0, 3 );
            if ( '' === trim( (string) $excerpt ) ) {
                $bits = array();
                if ( $role ) { $bits[] = $role; }
                if ( $village ) { $bits[] = 'from ' . $village; }
                if ( ! empty( $handled ) ) { $bits[] = 'connected with ' . implode( ', ', array_slice( $handled, 0, 3 ) ); }
                $excerpt = ! empty( $bits ) ? implode( ', ', $bits ) . '.' : '';
            }
            $url = $this->related_detail_url( $post, 'producer' );
            $button = 'View producer profile';
        } else {
            $excerpt = $post->post_excerpt ? $post->post_excerpt : wp_trim_words( wp_strip_all_tags( $post->post_content ), 22 );
            $price = function_exists( 'wc_get_product' ) ? wp_strip_all_tags( wc_price( (float) get_post_meta( $id, '_price', true ) ) ) : '';
            $meta_rows = array_filter( array(
                $price ? array( 'Price', $price ) : null,
                array( 'Origin', 'Mapped to this cluster' ),
            ) );
            $chips = array( 'Traceable', 'Origin linked' );
            $url = get_permalink( $id );
            $button = 'View Product';
        }

        if ( '' === $excerpt ) { $excerpt = wp_trim_words( wp_strip_all_tags( $post->post_content ), 24 ); }
        if ( '' === trim( $excerpt ) ) { $excerpt = 'Profile details are not filled yet. Add Short Story / Full Story in Amaley Core to show a richer public profile.'; }
        ob_start();
        ?>
        <article class="amcss-card amcss-related-card amcss-related-card-<?php echo esc_attr( $type ); ?>">
            <div class="amcss-card-image"><?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>"><?php else : ?><span><?php echo esc_html( mb_substr( $title, 0, 2 ) ); ?></span><?php endif; ?></div>
            <div class="amcss-card-body">
                <span class="amcss-card-label"><?php echo esc_html( ucfirst( $type ) ); ?></span>
                <h3><?php echo esc_html( $title ); ?></h3>
                <p class="amcss-related-desc"><?php echo esc_html( $excerpt ); ?></p>
                <?php if ( ! empty( $meta_rows ) ) : ?><dl class="amcss-meta-list"><?php foreach ( $meta_rows as $row ) : ?><div><dt><?php echo esc_html( $row[0] ); ?></dt><dd><?php echo esc_html( $row[1] ); ?></dd></div><?php endforeach; ?></dl><?php endif; ?>
                <?php if ( ! empty( $chips ) ) : ?><div class="amcss-chip-row amcss-card-chips"><?php foreach ( $chips as $chip ) : ?><span><?php echo esc_html( $chip ); ?></span><?php endforeach; ?></div><?php endif; ?>
                <?php if ( $button && $url && '#' !== $url ) : ?><a class="amcss-card-link" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $button ); ?></a><?php elseif ( $button ) : ?><span class="amcss-card-link amcss-card-link-muted"><?php echo esc_html( $button ); ?></span><?php endif; ?>
            </div>
        </article>
        <?php
        return ob_get_clean();
    }

    /** Generate a useful cluster story when the long story field is empty. */
    private function generated_cluster_story( $m ) {
        $parts = array();
        if ( ! empty( $m['intro'] ) ) { $parts[] = $m['intro']; }
        $where = array_filter( array( $m['block'], $m['district'], $m['region'] ) );
        if ( ! empty( $where ) ) { $parts[] = 'This cluster is connected to ' . implode( ', ', $where ) . ', bringing together local geography, seasonal produce and community-led value addition.'; }
        if ( ! empty( $m['villages'] ) ) { $parts[] = 'Key villages linked with this cluster include ' . implode( ', ', array_slice( $m['villages'], 0, 6 ) ) . '.'; }
        if ( ! empty( $m['products'] ) ) { $parts[] = 'Primary product lines currently mapped here include ' . implode( ', ', array_slice( $m['products'], 0, 6 ) ) . '.'; }
        if ( empty( $parts ) ) { $parts[] = 'This cluster profile is ready for the Amaley team to add deeper stories, village notes, product context, producer details and sourcing information.'; }
        return implode( "\n\n", $parts );
    }

    /** Render gallery. */
    public function render_gallery( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->gallery_defaults() );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $m = $this->cluster_meta( $cluster );
        $images = $m['gallery'];
        if ( empty( $images ) && ! empty( $m['image'] ) ) { $images = array( $m['image'] ); }
        $cols = '--amcss-cols:' . max( 1, absint( $a['columns_desktop'] ) ) . ';--amcss-cols-tablet:' . max( 1, absint( $a['columns_tablet'] ) ) . ';--amcss-cols-mobile:' . max( 1, absint( $a['columns_mobile'] ) ) . ';';
        $this->enqueue_assets();
        ob_start();
        ?>
        <section class="amcss-section amcss-gallery">
            <div class="amcss-container">
                <div class="amcss-heading"><span class="amcss-label"><?php echo esc_html( $a['label'] ); ?></span><h2><?php echo esc_html( $a['title'] ); ?></h2><p><?php echo esc_html( $a['description'] ); ?></p></div>
                <?php if ( empty( $images ) ) : ?>
                    <?php if ( $this->boolish( $a['show_empty_state'] ) ) : ?><div class="amcss-card amcss-empty-card"><p><?php echo esc_html( $a['empty_message'] ); ?></p></div><?php endif; ?>
                <?php else : ?>
                    <div class="amcss-gallery-grid" style="<?php echo esc_attr( $cols ); ?>"><?php foreach ( $images as $image ) : ?><figure><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $m['title'] ); ?>"></figure><?php endforeach; ?></div>
                <?php endif; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render contact/source support card. */
    public function render_contact( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->contact_defaults() );
        $cluster = $this->resolve_cluster( $a );
        if ( ! $cluster ) { return $this->empty_state( $a['empty_message'] ); }
        $m = $this->cluster_meta( $cluster );
        $this->enqueue_assets();
        ob_start();
        ?>
        <section class="amcss-section amcss-contact">
            <div class="amcss-container amcss-contact-grid">
                <div class="amcss-contact-copy"><span class="amcss-label"><?php echo esc_html( $a['label'] ); ?></span><h2><?php echo esc_html( $a['title'] ); ?></h2><p><?php echo esc_html( $a['description'] ); ?></p><?php if ( $this->boolish( $a['show_buttons'] ) ) : ?><div class="amcss-button-row"><a class="amcss-btn amcss-btn-primary" href="<?php echo esc_url( $a['primary_url'] ); ?>"><?php echo esc_html( $a['primary_text'] ); ?></a><a class="amcss-btn amcss-btn-secondary" href="<?php echo esc_url( $a['secondary_url'] ); ?>"><?php echo esc_html( $a['secondary_text'] ); ?></a></div><?php endif; ?></div>
                <div class="amcss-contact-card amcss-side-box">
                    <h3><?php echo esc_html( $m['title'] ); ?></h3>
                    <dl class="amcss-meta-list">
                        <?php if ( $this->boolish( $a['show_location'] ) && $m['location'] ) : ?><div><dt>Location</dt><dd><?php echo esc_html( $m['location'] ); ?></dd></div><?php endif; ?>
                        <?php if ( $this->boolish( $a['show_contact_person'] ) && $m['contact_person'] ) : ?><div><dt>Contact person</dt><dd><?php echo esc_html( $m['contact_person'] ); ?></dd></div><?php endif; ?>
                        <?php if ( $this->boolish( $a['show_phone'] ) && $m['phone'] ) : ?><div><dt>Phone / WhatsApp</dt><dd><?php echo esc_html( $m['phone'] ); ?></dd></div><?php endif; ?>
                        <?php if ( $m['code'] ) : ?><div><dt>Cluster code</dt><dd><?php echo esc_html( $m['code'] ); ?></dd></div><?php endif; ?>
                    </dl>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render CTA. */
    public function render_cta( $atts = array() ) {
        $a = wp_parse_args( $atts, $this->cta_defaults() );
        $cluster = $this->resolve_cluster( $a );
        if ( $cluster ) {
            $m = $this->cluster_meta( $cluster );
            $a['title'] = str_replace( '{cluster}', $m['title'], $a['title'] );
            $a['description'] = str_replace( '{cluster}', $m['title'], $a['description'] );
        }
        $this->enqueue_assets();
        ob_start();
        ?>
        <section class="amcss-section amcss-cta">
            <div class="amcss-container amcss-cta-inner">
                <div><span class="amcss-label"><?php echo esc_html( $a['label'] ); ?></span><h2><?php echo esc_html( $a['title'] ); ?></h2><p><?php echo esc_html( $a['description'] ); ?></p></div>
                <?php if ( $this->boolish( $a['show_buttons'] ) ) : ?><div class="amcss-button-row"><a class="amcss-btn amcss-btn-primary" href="<?php echo esc_url( $a['primary_url'] ); ?>"><?php echo esc_html( $a['primary_text'] ); ?></a><a class="amcss-btn amcss-btn-secondary" href="<?php echo esc_url( $a['secondary_url'] ); ?>"><?php echo esc_html( $a['secondary_text'] ); ?></a></div><?php endif; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Query helpers. */
    public function get_shgs_for_cluster( $cluster_id, $limit = 6, $offset = 0 ) {
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }
        $limit = max( 1, absint( $limit ) );
        $ids = $this->get_shg_ids_for_cluster( $cluster_id );
        if ( empty( $ids ) ) { return array(); }
        $ids = array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
        $ids = array_slice( $ids, max( 0, absint( $offset ) ), $limit );
        if ( empty( $ids ) ) { return array(); }

        $types = $this->get_group_like_post_types();
        if ( empty( $types ) ) { $types = array( 'amaley_shg_group' ); }

        return get_posts( array(
            'post_type' => $types,
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'post__in' => $ids,
            'posts_per_page' => $limit,
            'orderby' => 'post__in',
        ) );
    }

    public function get_members_for_cluster( $cluster_id, $limit = 6, $offset = 0 ) {
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }
        $limit = max( 1, absint( $limit ) );
        $member_ids = $this->get_member_ids_for_cluster( $cluster_id );
        if ( empty( $member_ids ) ) { return array(); }
        return get_posts( array(
            'post_type' => 'amaley_member',
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'post__in' => array_slice( $member_ids, max( 0, absint( $offset ) ), $limit ),
            'posts_per_page' => $limit,
            'orderby' => 'post__in',
        ) );
    }

    private function get_member_ids_for_cluster( $cluster_id ) {
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }
        $shg_ids = $this->get_shg_ids_for_cluster( $cluster_id );
        $member_ids = $this->get_metabox_relationship_ids_for_cluster( $cluster_id, array( 'amaley_member' ) );
        if ( ! empty( $shg_ids ) ) {
            $through_shg = get_posts( array(
                'post_type' => 'amaley_member',
                'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
                'fields' => 'ids',
                'posts_per_page' => 500,
                'meta_query' => array( array( 'key' => '_amaley_member_shg_id', 'value' => array_map( 'absint', $shg_ids ), 'compare' => 'IN' ) ),
            ) );
            $member_ids = array_merge( $member_ids, array_map( 'absint', $through_shg ) );
        }
        return array_values( array_unique( array_filter( array_map( 'absint', $member_ids ) ) ) );
    }

    public function get_products_for_cluster( $cluster_id, $limit = 6, $offset = 0 ) {
        if ( ! post_type_exists( 'product' ) ) { return array(); }
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }
        $limit = max( 1, absint( $limit ) );
        $product_ids = $this->get_product_ids_for_cluster( $cluster_id );
        if ( empty( $product_ids ) ) { return array(); }
        return get_posts( array(
            'post_type' => 'product',
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'post__in' => array_slice( $product_ids, max( 0, absint( $offset ) ), $limit ),
            'posts_per_page' => $limit,
            'orderby' => 'post__in',
        ) );
    }

    private function get_product_ids_for_cluster( $cluster_id ) {
        if ( ! post_type_exists( 'product' ) ) { return array(); }
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }
        $product_ids = get_posts( array(
            'post_type' => 'product',
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'fields' => 'ids',
            'posts_per_page' => 500,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array( array( 'key' => '_amaley_origin_cluster_id', 'value' => $cluster_id, 'compare' => '=' ) ),
        ) );
        $product_ids = array_merge( array_map( 'absint', $product_ids ), $this->get_metabox_relationship_ids_for_cluster( $cluster_id, array( 'product' ) ) );
        return array_values( array_unique( array_filter( array_map( 'absint', $product_ids ) ) ) );
    }

    private function get_shg_ids_for_cluster( $cluster_id ) {
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }
        $cluster_code = (string) get_post_meta( $cluster_id, '_amaley_cluster_code', true );
        $cluster_title = get_the_title( $cluster_id );
        $cluster_slug = get_post_field( 'post_name', $cluster_id );

        // v1.0.41 stable explicit cluster-side links.
        // This is the first source of truth for the Cluster Single Template.
        $explicit_ids = get_post_meta( $cluster_id, '_amaley_cluster_linked_group_ids', true );
        if ( ! is_array( $explicit_ids ) ) {
            $explicit_ids = $this->extract_ids_from_any_value( $explicit_ids );
        }
        $ids = $this->filter_post_ids_by_type( $explicit_ids, array( 'amaley_shg_group' ) );

        $meta_query = array( 'relation' => 'OR', array( 'key' => '_amaley_shg_cluster_id', 'value' => $cluster_id, 'compare' => '=' ) );
        if ( '' !== trim( $cluster_code ) ) { $meta_query[] = array( 'key' => '_amaley_shg_cluster_code', 'value' => $cluster_code, 'compare' => '=' ); }
        $direct_ids = get_posts( array(
            'post_type' => $this->get_group_like_post_types(),
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'fields' => 'ids',
            'posts_per_page' => 500,
            'orderby' => 'menu_order title',
            'order' => 'ASC',
            'meta_query' => $meta_query,
        ) );

        $ids = array_merge(
            array_map( 'absint', $ids ),
            array_map( 'absint', $direct_ids ),
            $this->get_metabox_relationship_ids_for_cluster( $cluster_id, array( 'amaley_shg_group' ) ),
            $this->get_post_ids_from_meta_bucket( $cluster_id, array( 'amaley_shg_group' ) ),
            $this->get_group_like_ids_from_cluster_meta_titles( $cluster_id ),
            $this->get_post_ids_by_reverse_meta_scan( 'amaley_shg_group', $cluster_id, $cluster_code, $cluster_title, $cluster_slug )
        );

        return array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
    }

    /**
     * Read Meta Box relationship table robustly.
     * Different installs may use `from`/`to` or from_id/to_id column names.
     */
    private function get_metabox_relationship_ids_for_cluster( $cluster_id, $target_types = array() ) {
        global $wpdb;
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id || ! is_object( $wpdb ) ) { return array(); }
        $table = $wpdb->prefix . 'mb_relationships';
        $exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
        if ( $exists !== $table ) { return array(); }

        $columns = $wpdb->get_col( "DESC {$table}", 0 );
        if ( empty( $columns ) ) { return array(); }
        $from_col = in_array( 'from', $columns, true ) ? '`from`' : ( in_array( 'from_id', $columns, true ) ? '`from_id`' : '' );
        $to_col   = in_array( 'to', $columns, true ) ? '`to`' : ( in_array( 'to_id', $columns, true ) ? '`to_id`' : '' );
        if ( ! $from_col || ! $to_col ) { return array(); }

        $sql = "SELECT DISTINCT CASE WHEN {$from_col} = %d THEN {$to_col} ELSE {$from_col} END AS related_id FROM {$table} WHERE {$from_col} = %d OR {$to_col} = %d";
        $raw_ids = $wpdb->get_col( $wpdb->prepare( $sql, $cluster_id, $cluster_id, $cluster_id ) );
        if ( empty( $raw_ids ) ) { return array(); }
        return $this->filter_post_ids_by_type( $raw_ids, $target_types );
    }

    /**
     * Some relationship plugins store selected IDs directly on the source post as meta.
     * This pulls IDs from all cluster-side meta values and filters them by post type.
     */
    private function get_post_ids_from_meta_bucket( $post_id, $target_types = array() ) {
        $post_id = absint( $post_id );
        if ( ! $post_id ) { return array(); }
        $all_meta = get_post_meta( $post_id );
        if ( empty( $all_meta ) || ! is_array( $all_meta ) ) { return array(); }
        $ids = array();
        foreach ( $all_meta as $key => $values ) {
            if ( 0 === strpos( (string) $key, '_' ) && false === strpos( (string) $key, 'amaley' ) && false === strpos( (string) $key, 'relation' ) && false === strpos( (string) $key, 'linked' ) ) {
                // Still allow unknown relationship keys, but skip common private noise where possible.
            }
            foreach ( (array) $values as $value ) {
                $ids = array_merge( $ids, $this->extract_ids_from_any_value( $value ) );
            }
        }
        return $this->filter_post_ids_by_type( $ids, $target_types );
    }

    /**
     * Some site relationship fields store selected post titles/slugs instead of
     * IDs. This matches cluster-side meta text against group-like post titles
     * and slugs, then returns those IDs as collective cards.
     */
    private function get_group_like_ids_from_cluster_meta_titles( $cluster_id ) {
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }

        $strings = array();
        foreach ( get_post_meta( $cluster_id ) as $values ) {
            foreach ( (array) $values as $value ) {
                $strings = array_merge( $strings, $this->extract_strings_from_any_value( $value ) );
            }
        }
        $strings = array_values( array_unique( array_filter( array_map( 'trim', $strings ) ) ) );
        if ( empty( $strings ) ) { return array(); }

        $candidate_types = $this->get_group_like_post_types();
        if ( empty( $candidate_types ) ) { return array(); }

        $posts = get_posts( array(
            'post_type' => $candidate_types,
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'fields' => 'ids',
            'posts_per_page' => 500,
        ) );

        $ids = array();
        foreach ( $posts as $pid ) {
            $title = strtolower( get_the_title( $pid ) );
            $slug  = strtolower( (string) get_post_field( 'post_name', $pid ) );
            foreach ( $strings as $string ) {
                $s = strtolower( $string );
                if ( strlen( $s ) < 4 ) { continue; }
                if ( $s === $title || $s === $slug || false !== strpos( $s, $title ) || false !== strpos( $s, $slug ) ) {
                    $ids[] = absint( $pid );
                    break;
                }
            }
        }
        return array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
    }

    /**
     * Fallback scanner for records that store cluster ID/code/title/slug in unknown meta keys.
     */
    private function get_post_ids_by_reverse_meta_scan( $post_type, $cluster_id, $cluster_code = '', $cluster_title = '', $cluster_slug = '' ) {
        $post_type = sanitize_key( $post_type );
        if ( ! $post_type || ! post_type_exists( $post_type ) ) { return array(); }
        $needles = array_filter( array_map( 'strval', array( absint( $cluster_id ), $cluster_code, $cluster_title, $cluster_slug ) ) );
        if ( empty( $needles ) ) { return array(); }
        $posts = get_posts( array(
            'post_type' => $post_type,
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'fields' => 'ids',
            'posts_per_page' => 500,
            'orderby' => 'menu_order title',
            'order' => 'ASC',
        ) );
        $ids = array();
        foreach ( $posts as $pid ) {
            $all_meta = get_post_meta( $pid );
            foreach ( $all_meta as $values ) {
                foreach ( (array) $values as $value ) {
                    $flat = wp_json_encode( maybe_unserialize( $value ) );
                    if ( false === $flat || null === $flat ) { $flat = (string) $value; }
                    foreach ( $needles as $needle ) {
                        if ( '' !== $needle && false !== stripos( (string) $flat, (string) $needle ) ) { $ids[] = absint( $pid ); break 3; }
                    }
                }
            }
        }
        return array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
    }

    private function extract_ids_from_any_value( $value ) {
        $ids = array();
        $value = maybe_unserialize( $value );
        if ( is_array( $value ) || is_object( $value ) ) {
            foreach ( (array) $value as $v ) { $ids = array_merge( $ids, $this->extract_ids_from_any_value( $v ) ); }
            return $ids;
        }
        if ( is_numeric( $value ) ) { return array( absint( $value ) ); }
        $text = (string) $value;
        $json = json_decode( $text, true );
        if ( json_last_error() === JSON_ERROR_NONE && is_array( $json ) ) { return $this->extract_ids_from_any_value( $json ); }
        if ( preg_match_all( '/\\b\\d{1,10}\\b/', $text, $m ) ) { $ids = array_merge( $ids, array_map( 'absint', $m[0] ) ); }
        return $ids;
    }

    private function extract_strings_from_any_value( $value ) {
        $out = array();
        $value = maybe_unserialize( $value );
        if ( is_array( $value ) || is_object( $value ) ) {
            foreach ( (array) $value as $v ) { $out = array_merge( $out, $this->extract_strings_from_any_value( $v ) ); }
            return $out;
        }
        if ( is_scalar( $value ) ) {
            $text = trim( (string) $value );
            if ( '' !== $text ) {
                $json = json_decode( $text, true );
                if ( json_last_error() === JSON_ERROR_NONE && is_array( $json ) ) {
                    return $this->extract_strings_from_any_value( $json );
                }
                $out[] = $text;
            }
        }
        return $out;
    }

    private function get_group_like_post_types() {
        $types = get_post_types( array(), 'names' );
        $out = array();
        foreach ( (array) $types as $type ) {
            if ( $this->is_group_like_post_type( $type ) ) { $out[] = $type; }
        }
        if ( post_type_exists( 'amaley_shg_group' ) && ! in_array( 'amaley_shg_group', $out, true ) ) { $out[] = 'amaley_shg_group'; }
        return array_values( array_unique( $out ) );
    }

    private function filter_post_ids_by_type( $raw_ids, $target_types = array() ) {
        $ids = array();
        $target_types = array_filter( array_map( 'sanitize_key', (array) $target_types ) );
        $allow_group_like = in_array( 'amaley_shg_group', $target_types, true );
        foreach ( (array) $raw_ids as $raw_id ) {
            $id = absint( $raw_id );
            if ( ! $id || get_post_status( $id ) === false ) { continue; }
            $type = get_post_type( $id );
            if ( ! empty( $target_types ) && ! in_array( $type, $target_types, true ) ) {
                if ( ! $allow_group_like || ! $this->is_group_like_post_type( $type ) ) { continue; }
            }
            $ids[] = $id;
        }
        return array_values( array_unique( $ids ) );
    }

    /**
     * Relationship plugins / earlier site builds may store "producer groups" in
     * CPTs whose post type is not exactly `amaley_shg_group`.
     *
     * For the cluster single page, those group-like records are still valid
     * public collective cards. This helper allows SHG widgets to include those
     * records while still excluding products, members, pages, attachments, etc.
     */
    private function is_group_like_post_type( $type ) {
        $type = sanitize_key( $type );
        if ( ! $type || ! post_type_exists( $type ) ) { return false; }
        if ( in_array( $type, array( 'post', 'page', 'attachment', 'product', 'amaley_cluster', 'amaley_member' ), true ) ) { return false; }
        if ( 'amaley_shg_group' === $type ) { return true; }

        $obj = get_post_type_object( $type );
        $haystack = $type;
        if ( $obj ) {
            $haystack .= ' ' . ( isset( $obj->label ) ? $obj->label : '' );
            $haystack .= ' ' . ( isset( $obj->labels->name ) ? $obj->labels->name : '' );
            $haystack .= ' ' . ( isset( $obj->labels->singular_name ) ? $obj->labels->singular_name : '' );
        }
        $haystack = strtolower( $haystack );

        foreach ( array( 'shg', 'group', 'producer', 'collective', 'women', 'mahila', 'self_help' ) as $needle ) {
            if ( false !== strpos( $haystack, $needle ) ) { return true; }
        }
        return false;
    }

    /** Text splitting helpers. */
    public function split_terms( $text ) {
        if ( empty( $text ) ) { return array(); }
        $terms = preg_split( '/[\n,]+/', (string) $text );
        $terms = array_map( 'trim', $terms );
        return array_values( array_filter( $terms ) );
    }

    public function gallery_urls( $text ) {
        $items = $this->split_terms( $text );
        return array_values( array_filter( $items, function( $url ) { return filter_var( $url, FILTER_VALIDATE_URL ); } ) );
    }
}
