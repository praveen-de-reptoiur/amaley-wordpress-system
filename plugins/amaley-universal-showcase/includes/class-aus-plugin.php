<?php
/**
 * Main plugin class for Amaley Universal Showcase.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'AUS_Plugin', false ) ) {
class AUS_Plugin {
    private $last_relation_status = '';
    private $last_relation_message = '';
    private $meta_overrides = array();

    public function __construct() {
        $GLOBALS['aus_showcase_plugin'] = $this;
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        add_shortcode( 'amaley_universal_showcase', array( $this, 'shortcode' ) );
        add_filter( 'get_post_metadata', array( $this, 'dynamic_meta_override' ), 10, 4 );
    }

    public function register_assets() {
        wp_register_style( 'aus-showcase', AUS_URL . 'assets/css/showcase.css', array(), AUS_VERSION );
        wp_register_script( 'aus-showcase', AUS_URL . 'assets/js/showcase.js', array(), AUS_VERSION, true );
        if ( defined( 'AMALEY_CORE_URL' ) && ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), defined( 'AMALEY_CORE_VERSION' ) ? AMALEY_CORE_VERSION : AUS_VERSION );
        }
    }

    public function enqueue_assets() {
        if ( ! wp_style_is( 'aus-showcase', 'registered' ) ) { $this->register_assets(); }
        if ( wp_style_is( 'amaley-core-cards', 'registered' ) ) { wp_enqueue_style( 'amaley-core-cards' ); }
        wp_enqueue_style( 'aus-showcase' );
        wp_enqueue_script( 'aus-showcase' );
    }

    public function register_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-universal-showcase' ), 'icon' => 'fa fa-database' ) );
        }
    }

    public function register_widgets( $widgets_manager ) {
        if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) { return; }
        require_once AUS_PATH . 'includes/widgets/class-aus-showcase-widget.php';
        if ( class_exists( 'AUS_Showcase_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new AUS_Showcase_Widget() );
        }
    }

    public function shortcode( $atts ) {
        return $this->render( is_array( $atts ) ? $atts : array() );
    }

    public function defaults() {
        $d = array(
            'show_section' => '1',
            'content_type' => 'cluster',
            'source_mode' => 'latest',
            'source_mode_cluster' => 'latest',
            'source_mode_shg' => 'latest',
            'source_mode_member' => 'latest',
            'source_mode_product' => 'latest',
            'manual_ids' => '',
            'featured_only' => '',
            'product_category' => '',
            'relation_cluster_id' => '',
            'relation_shg_id' => '',
            'relation_member_id' => '',
            'relation_cluster_id_shg' => '',
            'relation_cluster_id_member' => '',
            'relation_shg_id_member' => '',
            'relation_cluster_id_product' => '',
            'relation_shg_id_product' => '',
            'relation_member_id_product' => '',
            'limit' => '8',
            'order_by' => 'date',
            'order' => 'DESC',
            'section_label' => 'Amaley ecosystem',
            'section_title' => 'Explore Amaley stories, sources and products',
            'section_description' => 'A reusable showcase for clusters, collectives, producers and products.',
            'heading_layout_align' => 'left',
            'show_section_button' => '1',
            'section_button_text' => 'View All',
            'section_button_url' => '',
            'section_button_align' => 'center',
            'desktop_layout' => 'grid',
            'tablet_layout' => 'grid',
            'phone_layout' => 'slider',
            'columns_desktop' => '4',
            'columns_tablet' => '2',
            'columns_phone' => '1',
            'show_arrows' => '1',
            'show_dots' => '1',
            'show_numbers' => '',
            'mobile_cards_view' => '1.12',
            'tablet_cards_view' => '2',
            'desktop_cards_view' => '4',
            'autoplay' => '',
            'autoplay_speed' => '3500',
            'loop_slider' => '',
            'pause_on_hover' => '1',
            'hide_nav_on_single_page' => '1',
            'empty_relation_action' => 'latest',
            'relation_fallback_manual_ids' => '',
            'show_relation_status' => '1',
            'relation_status_linked_text' => 'Showing linked items',
            'relation_status_fallback_text' => 'Relation empty — showing latest items',
            'relation_status_empty_text' => 'No linked items found',
            'empty_message' => 'No items are available yet.',
            'shg_show_village_meta' => '1',
            'shg_show_district_meta' => '1',
            'shg_show_members_meta' => '1',
            'shg_show_verification_meta' => '1',
            'cluster_show_district_meta' => '1',
            'cluster_show_villages_meta' => '1',
            'cluster_show_products_meta' => '1',
            'cluster_show_status_meta' => '1',
            'member_show_role_meta' => '1',
            'member_show_village_meta' => '1',
            'member_show_phone_meta' => '1',
        );
        foreach ( array( 'cluster', 'shg', 'member', 'product' ) as $t ) {
            foreach ( array( 'image', 'label', 'title', 'excerpt', 'meta', 'tags', 'button' ) as $el ) {
                $d[ $t . '_show_' . $el ] = '1';
            }
            $d[ $t . '_label_text' ] = '';
            $d[ $t . '_description_words' ] = '18';
        }
        $d['cluster_button_text'] = 'View Cluster';
        $d['shg_button_text'] = 'View Collective';
        $d['member_button_text'] = 'View Producer';
        $d['product_button_text'] = 'View Product';
        $d['product_description_words'] = '16';
        return $d;
    }

    public function boolish( $value ) {
        return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true );
    }

    public function render( $settings = array() ) {
        $this->enqueue_assets();
        $s = wp_parse_args( is_array( $settings ) ? $settings : array(), $this->defaults() );
        if ( ! $this->boolish( $s['show_section'] ) ) { return ''; }

        $type = $this->sanitize_content_type( $s['content_type'] );
        $this->last_relation_status = '';
        $this->last_relation_message = '';
        $items = $this->query_items( $type, $s );
        $desktop = $this->sanitize_layout( $s['desktop_layout'], 'grid' );
        $tablet = $this->sanitize_layout( $s['tablet_layout'], 'grid' );
        $phone = $this->sanitize_layout( $s['phone_layout'], 'slider' );
        $uid = 'aus-' . wp_rand( 1000, 999999 );

        $classes = 'aus-showcase aus-showcase--type-' . $type . ' aus-showcase--desktop-' . $desktop . ' aus-showcase--tablet-' . $tablet . ' aus-showcase--phone-' . $phone;
        $cd = max( 1, min( 5, absint( $s['columns_desktop'] ) ) );
        $ct = max( 1, min( 4, absint( $s['columns_tablet'] ) ) );
        $cp = max( 1, min( 2, absint( $s['columns_phone'] ) ) );

        ob_start();
        ?>
        <section id="<?php echo esc_attr( $uid ); ?>" class="<?php echo esc_attr( $classes ); ?>" data-aus-showcase="1" data-mobile-cards-view="<?php echo esc_attr( $s['mobile_cards_view'] ); ?>" data-tablet-cards-view="<?php echo esc_attr( $s['tablet_cards_view'] ); ?>" data-desktop-cards-view="<?php echo esc_attr( $s['desktop_cards_view'] ); ?>" data-autoplay="<?php echo esc_attr( $this->boolish( $s['autoplay'] ) ? '1' : '0' ); ?>" data-autoplay-speed="<?php echo esc_attr( absint( $s['autoplay_speed'] ) ); ?>" data-loop="<?php echo esc_attr( $this->boolish( $s['loop_slider'] ) ? '1' : '0' ); ?>" data-hide-nav="<?php echo esc_attr( $this->boolish( isset( $s['hide_nav_on_single_page'] ) ? $s['hide_nav_on_single_page'] : '1' ) ? '1' : '0' ); ?>" data-pause-on-hover="<?php echo esc_attr( $this->boolish( $s['pause_on_hover'] ) ? '1' : '0' ); ?>">
            <div class="aus-showcase__inner">
                <?php echo $this->render_header( $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php echo $this->render_relation_status( $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php if ( 'hidden' === $this->last_relation_status ) : ?>
                    <?php // Relation empty and editor selected Hide Items Area. ?>
                <?php elseif ( empty( $items ) ) : ?>
                    <div class="aus-showcase__empty"><?php echo esc_html( $s['empty_message'] ); ?></div>
                <?php else : ?>
                    <div class="aus-showcase__viewport">
                        <div class="aus-showcase__track" data-aus-track style="--aus-cols-desktop:<?php echo esc_attr( $cd ); ?>;--aus-cols-tablet:<?php echo esc_attr( $ct ); ?>;--aus-cols-phone:<?php echo esc_attr( $cp ); ?>;">
                            <?php foreach ( $items as $post_id ) : ?>
                                <div class="aus-showcase__item"><?php echo $this->render_card( $type, $post_id, $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php if ( $this->boolish( $s['show_arrows'] ) || $this->boolish( $s['show_dots'] ) || $this->boolish( $s['show_numbers'] ) ) : ?>
                        <div class="aus-showcase__nav" aria-label="<?php echo esc_attr__( 'Showcase navigation', 'amaley-universal-showcase' ); ?>">
                            <?php if ( $this->boolish( $s['show_arrows'] ) ) : ?><button class="aus-showcase__arrow" type="button" data-aus-prev aria-label="<?php echo esc_attr__( 'Previous', 'amaley-universal-showcase' ); ?>">‹</button><?php endif; ?>
                            <?php if ( $this->boolish( $s['show_numbers'] ) ) : ?><span class="aus-showcase__counter" data-aus-counter>1 / <?php echo esc_html( count( $items ) ); ?></span><?php endif; ?>
                            <?php if ( $this->boolish( $s['show_dots'] ) ) : ?><span class="aus-showcase__dots" data-aus-dots></span><?php endif; ?>
                            <?php if ( $this->boolish( $s['show_arrows'] ) ) : ?><button class="aus-showcase__arrow" type="button" data-aus-next aria-label="<?php echo esc_attr__( 'Next', 'amaley-universal-showcase' ); ?>">›</button><?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php echo $this->render_section_button( $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    private function render_header( $s ) {
        if ( empty( $s['section_label'] ) && empty( $s['section_title'] ) && empty( $s['section_description'] ) && ! $this->boolish( $s['show_section_button'] ) ) { return ''; }
        ob_start();
        ?>
        <div class="aus-showcase__header">
            <div class="aus-showcase__heading">
                <?php if ( ! empty( $s['section_label'] ) ) : ?><p class="aus-showcase__label"><?php echo esc_html( $s['section_label'] ); ?></p><?php endif; ?>
                <?php if ( ! empty( $s['section_title'] ) ) : ?><h2 class="aus-showcase__title"><?php echo esc_html( $s['section_title'] ); ?></h2><?php endif; ?>
                <?php if ( ! empty( $s['section_description'] ) ) : ?><p class="aus-showcase__description"><?php echo esc_html( $s['section_description'] ); ?></p><?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function render_section_button( $s ) {
        $button_url = $this->section_button_url( $s );
        if ( ! $this->boolish( isset( $s['show_section_button'] ) ? $s['show_section_button'] : '1' ) || empty( $s['section_button_text'] ) || empty( $button_url ) ) { return ''; }
        ob_start();
        ?>
        <div class="aus-showcase__footer-cta">
            <a class="aus-showcase__section-button" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $s['section_button_text'] ); ?></a>
        </div>
        <?php
        return ob_get_clean();
    }

    private function section_button_url( $s ) {
        if ( ! empty( $s['section_button_url'] ) ) {
            return $s['section_button_url'];
        }
        $type = $this->sanitize_content_type( isset( $s['content_type'] ) ? $s['content_type'] : 'cluster' );
        $defaults = array(
            'cluster' => '/clusters/',
            'shg'     => '/producer-groups/',
            'member'  => '/producers/',
            'product' => '/shop/',
        );
        return isset( $defaults[ $type ] ) ? $defaults[ $type ] : '#';
    }

    private function render_card( $type, $post_id, $s ) {
        if ( ! class_exists( 'Amaley_Core_Card_Renderer' ) ) {
            return '<div class="aus-showcase__empty">Amaley Core card renderer is required.</div>';
        }
        $p = $this->sanitize_content_type( $type );
        $post_id = absint( $post_id );
        $this->prepare_dynamic_meta_overrides( $p, $post_id, $s );

        $args = array( 'preset' => 'og-card-1', 'class' => 'aus-showcase__core-card' );
        foreach ( array( 'image', 'label', 'title', 'excerpt', 'meta', 'tags', 'button' ) as $el ) {
            $args[ 'show_' . $el ] = $this->boolish( isset( $s[ $p . '_show_' . $el ] ) ? $s[ $p . '_show_' . $el ] : '1' );
        }
        $args['label_text'] = isset( $s[ $p . '_label_text' ] ) ? $s[ $p . '_label_text' ] : '';
        $args['button_text'] = isset( $s[ $p . '_button_text' ] ) ? $s[ $p . '_button_text' ] : '';
        $args['excerpt_words'] = absint( isset( $s[ $p . '_description_words' ] ) ? $s[ $p . '_description_words' ] : 16 );
        return Amaley_Core_Card_Renderer::render( $p, $post_id, $args );
    }

    public function dynamic_meta_override( $value, $object_id, $meta_key, $single ) {
        $object_id = absint( $object_id );
        if ( ! $object_id || empty( $meta_key ) || empty( $this->meta_overrides[ $object_id ] ) || ! array_key_exists( $meta_key, $this->meta_overrides[ $object_id ] ) ) {
            return $value;
        }
        $override = $this->meta_overrides[ $object_id ][ $meta_key ];
        return $single ? $override : array( $override );
    }

    private function prepare_dynamic_meta_overrides( $type, $post_id, $s = array() ) {
        $type = $this->sanitize_content_type( $type );
        $post_id = absint( $post_id );
        if ( ! $post_id ) { return; }
        if ( ! isset( $this->meta_overrides[ $post_id ] ) ) { $this->meta_overrides[ $post_id ] = array(); }

        if ( 'shg' === $type ) {
            $member_count = count( $this->members_for_shgs( array( $post_id ) ) );
            if ( $member_count > 0 ) { $this->meta_overrides[ $post_id ]['_amaley_member_count'] = (string) $member_count; }
            if ( ! $this->boolish( isset( $s['shg_show_village_meta'] ) ? $s['shg_show_village_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_village'] = ''; }
            if ( ! $this->boolish( isset( $s['shg_show_district_meta'] ) ? $s['shg_show_district_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_district'] = ''; }
            if ( ! $this->boolish( isset( $s['shg_show_members_meta'] ) ? $s['shg_show_members_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_member_count'] = ''; }
            if ( ! $this->boolish( isset( $s['shg_show_verification_meta'] ) ? $s['shg_show_verification_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_verification_status'] = ''; }
        }

        if ( 'cluster' === $type ) {
            $shg_ids = $this->linked_shgs_for_cluster( $post_id );
            $member_count = count( $this->members_for_shgs( $shg_ids ) );
            $product_count = count( $this->products_by_origin( 'cluster', $post_id, array( 'limit' => 60, 'order_by' => 'date', 'order' => 'DESC', 'featured_only' => '' ) ) );
            if ( $product_count > 0 ) { $this->meta_overrides[ $post_id ]['_amaley_main_products'] = $product_count . ' products'; }
            if ( $shg_ids ) { $this->meta_overrides[ $post_id ]['_amaley_status'] = count( $shg_ids ) . ' collectives' . ( $member_count ? ' · ' . $member_count . ' producers' : '' ); }
            if ( ! $this->boolish( isset( $s['cluster_show_district_meta'] ) ? $s['cluster_show_district_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_district'] = ''; }
            if ( ! $this->boolish( isset( $s['cluster_show_villages_meta'] ) ? $s['cluster_show_villages_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_villages'] = ''; }
            if ( ! $this->boolish( isset( $s['cluster_show_products_meta'] ) ? $s['cluster_show_products_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_main_products'] = ''; }
            if ( ! $this->boolish( isset( $s['cluster_show_status_meta'] ) ? $s['cluster_show_status_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_status'] = ''; }
        }

        if ( 'member' === $type ) {
            if ( ! $this->boolish( isset( $s['member_show_role_meta'] ) ? $s['member_show_role_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_role'] = ''; }
            if ( ! $this->boolish( isset( $s['member_show_village_meta'] ) ? $s['member_show_village_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_village'] = ''; }
            if ( ! $this->boolish( isset( $s['member_show_phone_meta'] ) ? $s['member_show_phone_meta'] : '1' ) ) { $this->meta_overrides[ $post_id ]['_amaley_phone'] = ''; }
        }
    }

    private function selected_source_mode( $type, $s ) {
        $type = $this->sanitize_content_type( $type );
        $key = 'source_mode_' . $type;
        if ( isset( $s[ $key ] ) && '' !== (string) $s[ $key ] ) {
            return sanitize_key( $s[ $key ] );
        }
        return isset( $s['source_mode'] ) ? sanitize_key( $s['source_mode'] ) : 'latest';
    }

    private function relation_cluster_id( $type, $s ) {
        $type = $this->sanitize_content_type( $type );
        if ( 'shg' === $type && ! empty( $s['relation_cluster_id_shg'] ) ) { return absint( $s['relation_cluster_id_shg'] ); }
        if ( 'member' === $type && ! empty( $s['relation_cluster_id_member'] ) ) { return absint( $s['relation_cluster_id_member'] ); }
        if ( 'product' === $type && ! empty( $s['relation_cluster_id_product'] ) ) { return absint( $s['relation_cluster_id_product'] ); }
        return absint( isset( $s['relation_cluster_id'] ) ? $s['relation_cluster_id'] : 0 );
    }

    private function relation_shg_id( $type, $s ) {
        $type = $this->sanitize_content_type( $type );
        if ( 'member' === $type && ! empty( $s['relation_shg_id_member'] ) ) { return absint( $s['relation_shg_id_member'] ); }
        if ( 'product' === $type && ! empty( $s['relation_shg_id_product'] ) ) { return absint( $s['relation_shg_id_product'] ); }
        return absint( isset( $s['relation_shg_id'] ) ? $s['relation_shg_id'] : 0 );
    }

    private function relation_member_id( $type, $s ) {
        $type = $this->sanitize_content_type( $type );
        if ( 'product' === $type && ! empty( $s['relation_member_id_product'] ) ) { return absint( $s['relation_member_id_product'] ); }
        return absint( isset( $s['relation_member_id'] ) ? $s['relation_member_id'] : 0 );
    }

    private function query_items( $type, $s ) {
        $type = $this->sanitize_content_type( $type );
        $mode = $this->selected_source_mode( $type, $s );
        if ( in_array( $mode, array( 'by_cluster', 'by_shg', 'by_member' ), true ) ) {
            $this->last_relation_status = 'checking';
            $this->last_relation_message = '';
        }

        if ( 'manual' === $mode ) {
            $manual = $this->ids_from_string( isset( $s['manual_ids'] ) ? $s['manual_ids'] : '' );
            return $manual ? $this->apply_order_limit( $this->filter_ids_by_type( $manual, $type ), $s ) : array();
        }

        if ( 'by_cluster' === $mode ) {
            $cluster_id = $this->relation_cluster_id( $type, $s );
            if ( ! $cluster_id ) { return array(); }
            if ( 'cluster' === $type ) { return $this->apply_order_limit( $this->filter_ids_by_type( array( $cluster_id ), 'cluster' ), $s ); }
            if ( 'shg' === $type ) { return $this->relation_or_latest_fallback( $this->apply_order_limit( $this->filter_featured_ids( $this->linked_shgs_for_cluster( $cluster_id ), $type, $s ), $s ), $type, $s ); }
            if ( 'member' === $type ) { return $this->relation_or_latest_fallback( $this->apply_order_limit( $this->filter_featured_ids( $this->members_for_shgs( $this->linked_shgs_for_cluster( $cluster_id ) ), $type, $s ), $s ), $type, $s ); }
            if ( 'product' === $type ) { return $this->relation_or_latest_fallback( $this->products_by_origin( 'cluster', $cluster_id, $s ), $type, $s ); }
        }

        if ( 'by_shg' === $mode ) {
            $shg_id = $this->relation_shg_id( $type, $s );
            if ( ! $shg_id ) { return array(); }
            if ( 'shg' === $type ) { return $this->apply_order_limit( $this->filter_ids_by_type( array( $shg_id ), 'shg' ), $s ); }
            if ( 'member' === $type ) { return $this->relation_or_latest_fallback( $this->apply_order_limit( $this->filter_featured_ids( $this->members_for_shgs( array( $shg_id ) ), $type, $s ), $s ), $type, $s ); }
            if ( 'product' === $type ) { return $this->relation_or_latest_fallback( $this->products_by_origin( 'shg', $shg_id, $s ), $type, $s ); }
        }

        if ( 'by_member' === $mode ) {
            $member_id = $this->relation_member_id( $type, $s );
            if ( ! $member_id ) { return array(); }
            if ( 'member' === $type ) { return $this->apply_order_limit( $this->filter_ids_by_type( array( $member_id ), 'member' ), $s ); }
            if ( 'product' === $type ) { return $this->relation_or_latest_fallback( $this->products_by_origin( 'member', $member_id, $s ), $type, $s ); }
        }

        $pt = $this->post_type_for_content_type( $type );
        if ( ! $pt ) { return array(); }
        $args = array(
            'post_type' => $pt,
            'post_status' => 'publish',
            'posts_per_page' => max( 1, min( 60, absint( $s['limit'] ) ) ),
            'orderby' => $this->sanitize_orderby( $s['order_by'] ),
            'order' => 'ASC' === strtoupper( (string) $s['order'] ) ? 'ASC' : 'DESC',
            'fields' => 'ids',
            'no_found_rows' => true,
        );
        if ( 'product_category' === $mode && 'product' === $type && ! empty( $s['product_category'] ) ) {
            $args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => array_map( 'sanitize_title', array_map( 'trim', explode( ',', $s['product_category'] ) ) ) ) );
        }
        if ( 'featured' === $mode || $this->boolish( $s['featured_only'] ) ) {
            if ( 'product' === $type ) {
                if ( empty( $args['tax_query'] ) ) { $args['tax_query'] = array(); }
                $args['tax_query'][] = array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured', 'operator' => 'IN' );
            } else {
                $args['meta_query'] = array( array( 'key' => '_amaley_featured', 'value' => array( '1', 'yes', 'true', 'on' ), 'compare' => 'IN' ) );
            }
        }
        return array_map( 'absint', get_posts( $args ) );
    }

    private function linked_shgs_for_cluster( $cluster_id ) {
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }
        $linked = $this->ids_from_mixed( get_post_meta( $cluster_id, '_amaley_cluster_linked_group_ids', true ) );
        $linked = $this->filter_ids_by_type( $linked, 'shg' );
        if ( $linked ) { return $linked; }

        $fallback = array();
        $shgs = get_posts( array( 'post_type' => 'amaley_shg_group', 'post_status' => 'publish', 'posts_per_page' => 500, 'fields' => 'ids', 'no_found_rows' => true ) );
        $keys = array( '_amaley_cluster_id', '_amaley_linked_cluster_id', '_amaley_parent_cluster_id', '_amaley_origin_cluster_id', '_amaley_related_cluster_id', 'linked_cluster', '_linked_cluster', 'amaley_linked_cluster', '_amaley_linked_cluster' );
        foreach ( $shgs as $shg_id ) {
            foreach ( $keys as $key ) {
                if ( in_array( $cluster_id, $this->ids_from_mixed( get_post_meta( $shg_id, $key, true ) ), true ) ) {
                    $fallback[] = absint( $shg_id );
                    break;
                }
            }
        }

        if ( empty( $fallback ) ) {
            $fallback = $this->shgs_inferred_from_products_for_cluster( $cluster_id );
        }

        return array_values( array_unique( $fallback ) );
    }

    private function shgs_inferred_from_products_for_cluster( $cluster_id ) {
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id ) { return array(); }

        $cluster_keys = array( '_amaley_origin_cluster_id', '_amaley_cluster_id', 'linked_cluster', '_linked_cluster', 'amaley_linked_cluster', '_amaley_linked_cluster' );
        $shg_keys = array( '_amaley_origin_shg_id', '_amaley_origin_shg_group_id', '_amaley_origin_group_id', '_amaley_origin_producer_group_id', '_amaley_shg_group_id', 'linked_shg_group', '_linked_shg_group', 'linked_producer_group', '_linked_producer_group', 'linked_group', '_linked_group' );
        $products = get_posts( array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 1000, 'fields' => 'ids', 'no_found_rows' => true ) );
        $out = array();

        foreach ( $products as $product_id ) {
            $matched_cluster = false;
            foreach ( $cluster_keys as $cluster_key ) {
                if ( in_array( $cluster_id, $this->ids_from_mixed( get_post_meta( $product_id, $cluster_key, true ) ), true ) ) {
                    $matched_cluster = true;
                    break;
                }
            }
            if ( ! $matched_cluster ) { continue; }

            foreach ( $shg_keys as $shg_key ) {
                $out = array_merge( $out, $this->filter_ids_by_type( $this->ids_from_mixed( get_post_meta( $product_id, $shg_key, true ) ), 'shg' ) );
            }
        }

        return array_values( array_unique( array_filter( array_map( 'absint', $out ) ) ) );
    }

    private function members_for_shgs( $shg_ids ) {
        $shg_ids = array_values( array_filter( array_map( 'absint', (array) $shg_ids ) ) );
        if ( empty( $shg_ids ) ) { return array(); }

        $out = array();

        // 1) SHG-side direct member/producers fields. This is important when the relation is saved
        // on the SHG/Producer Group post instead of on the Member post.
        $shg_member_keys = array(
            '_amaley_linked_member_ids', '_amaley_linked_members', '_amaley_member_ids', '_amaley_members',
            '_amaley_shg_member_ids', '_amaley_group_member_ids', '_amaley_producer_ids', '_amaley_linked_producer_ids',
            'linked_members', '_linked_members', 'linked_member', '_linked_member',
            'linked_producers', '_linked_producers', 'linked_producer', '_linked_producer',
            'linked_producer_maker', '_linked_producer_maker', 'linked_producer_makers', '_linked_producer_makers'
        );
        foreach ( $shg_ids as $shg_id ) {
            foreach ( $shg_member_keys as $key ) {
                $out = array_merge( $out, $this->filter_ids_by_type( $this->ids_from_mixed( get_post_meta( $shg_id, $key, true ) ), 'member' ) );
            }
        }

        // 2) Member-side reverse relation fields.
        $members = get_posts( array( 'post_type' => 'amaley_member', 'post_status' => 'publish', 'posts_per_page' => 1000, 'fields' => 'ids', 'no_found_rows' => true ) );
        $member_shg_keys = array(
            '_amaley_shg_group_id', '_amaley_shg_group_ids', '_amaley_linked_shg_id', '_amaley_linked_shg_ids',
            '_amaley_parent_shg_id', '_amaley_origin_shg_id', '_amaley_origin_shg_group_id',
            '_amaley_group_id', '_amaley_group_ids', '_amaley_producer_group_id', '_amaley_producer_group_ids',
            'linked_shg_group', '_linked_shg_group', 'linked_shg_groups', '_linked_shg_groups',
            'linked_shg', '_linked_shg', 'linked_producer_group', '_linked_producer_group',
            'linked_producer_groups', '_linked_producer_groups', 'linked_group', '_linked_group',
            'linked_groups', '_linked_groups'
        );
        foreach ( $members as $member_id ) {
            foreach ( $member_shg_keys as $key ) {
                if ( array_intersect( $shg_ids, $this->ids_from_mixed( get_post_meta( $member_id, $key, true ) ) ) ) {
                    $out[] = absint( $member_id );
                    break;
                }
            }
        }

        return array_values( array_unique( array_filter( array_map( 'absint', $out ) ) ) );
    }

    private function products_by_origin( $origin_type, $origin_id, $s ) {
        $origin_id = absint( $origin_id );
        if ( ! $origin_id ) { return array(); }
        $key_map = array(
            'cluster' => array( '_amaley_origin_cluster_id', '_amaley_cluster_id', 'linked_cluster', '_linked_cluster', 'amaley_linked_cluster', '_amaley_linked_cluster' ),
            'shg'     => array( '_amaley_origin_shg_id', '_amaley_origin_shg_group_id', '_amaley_origin_group_id', '_amaley_origin_producer_group_id', '_amaley_shg_group_id', 'linked_shg_group', '_linked_shg_group', 'linked_producer_group', '_linked_producer_group', 'linked_group', '_linked_group' ),
            'member'  => array( '_amaley_origin_member_id', '_amaley_origin_producer_id', '_amaley_member_id', '_amaley_producer_id', 'linked_producer_maker', '_linked_producer_maker', 'linked_member', '_linked_member', 'linked_producer', '_linked_producer' ),
        );
        $keys = isset( $key_map[ $origin_type ] ) ? $key_map[ $origin_type ] : array();
        if ( empty( $keys ) ) { return array(); }
        $meta_query = array( 'relation' => 'OR' );
        foreach ( $keys as $key ) {
            $meta_query[] = array( 'key' => $key, 'value' => (string) $origin_id, 'compare' => '=' );
        }
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => max( 1, min( 60, absint( $s['limit'] ) ) ),
            'orderby' => $this->sanitize_orderby( $s['order_by'] ),
            'order' => 'ASC' === strtoupper( (string) $s['order'] ) ? 'ASC' : 'DESC',
            'fields' => 'ids',
            'no_found_rows' => true,
            'meta_query' => $meta_query,
        );
        if ( $this->boolish( $s['featured_only'] ) ) {
            $args['tax_query'] = array( array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured', 'operator' => 'IN' ) );
        }
        $found = array_map( 'absint', get_posts( $args ) );
        if ( empty( $found ) ) {
            $found = $this->products_by_origin_slow_scan( $origin_type, $origin_id, $keys, $s );
        }
        return $this->apply_order_limit( $found, $s );
    }

    private function products_by_origin_slow_scan( $origin_type, $origin_id, $keys, $s ) {
        $origin_id = absint( $origin_id );
        $out = array();
        if ( ! $origin_id || empty( $keys ) ) { return $out; }
        $products = get_posts( array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 1000, 'fields' => 'ids', 'no_found_rows' => true ) );
        foreach ( $products as $product_id ) {
            foreach ( $keys as $key ) {
                if ( in_array( $origin_id, $this->ids_from_mixed( get_post_meta( $product_id, $key, true ) ), true ) ) {
                    if ( ! $this->boolish( isset( $s['featured_only'] ) ? $s['featured_only'] : '' ) || has_term( 'featured', 'product_visibility', $product_id ) ) {
                        $out[] = absint( $product_id );
                    }
                    break;
                }
            }
        }
        return array_values( array_unique( $out ) );
    }

    private function filter_featured_ids( $ids, $type, $s ) {
        if ( ! $this->boolish( isset( $s['featured_only'] ) ? $s['featured_only'] : '' ) ) { return $ids; }
        $out = array();
        foreach ( (array) $ids as $id ) {
            if ( 'product' === $type ) {
                if ( has_term( 'featured', 'product_visibility', $id ) ) { $out[] = absint( $id ); }
            } elseif ( $this->boolish( get_post_meta( $id, '_amaley_featured', true ) ) ) {
                $out[] = absint( $id );
            }
        }
        return $out;
    }

    private function apply_order_limit( $ids, $s ) {
        $ids = array_values( array_unique( array_filter( array_map( 'absint', (array) $ids ) ) ) );
        $order_by = $this->sanitize_orderby( isset( $s['order_by'] ) ? $s['order_by'] : 'date' );
        if ( 'rand' === $order_by ) { shuffle( $ids ); }
        elseif ( 'title' === $order_by ) { usort( $ids, function( $a, $b ) { return strcasecmp( get_the_title( $a ), get_the_title( $b ) ); } ); }
        elseif ( 'menu_order' === $order_by ) { usort( $ids, function( $a, $b ) { return intval( get_post_field( 'menu_order', $a ) ) <=> intval( get_post_field( 'menu_order', $b ) ); } ); }
        elseif ( 'modified' === $order_by ) { usort( $ids, function( $a, $b ) { return strcmp( get_post_field( 'post_modified', $a ), get_post_field( 'post_modified', $b ) ); } ); }
        else { usort( $ids, function( $a, $b ) { return strcmp( get_post_field( 'post_date', $a ), get_post_field( 'post_date', $b ) ); } ); }
        if ( 'DESC' === strtoupper( (string) ( isset( $s['order'] ) ? $s['order'] : 'DESC' ) ) && 'rand' !== $order_by ) { $ids = array_reverse( $ids ); }
        return array_slice( $ids, 0, max( 1, min( 60, absint( isset( $s['limit'] ) ? $s['limit'] : 8 ) ) ) );
    }

    private function ids_from_mixed( $value ) {
        $ids = array();
        if ( is_array( $value ) ) {
            foreach ( $value as $item ) { $ids = array_merge( $ids, $this->ids_from_mixed( $item ) ); }
        } elseif ( is_object( $value ) && isset( $value->ID ) ) {
            $ids[] = absint( $value->ID );
        } else {
            foreach ( preg_split( '/[\s,|]+/', (string) $value ) as $part ) {
                $id = absint( $part );
                if ( $id ) { $ids[] = $id; }
            }
        }
        return array_values( array_unique( array_filter( $ids ) ) );
    }


    private function relation_or_latest_fallback( $ids, $type, $s ) {
        $ids = array_values( array_unique( array_filter( array_map( 'absint', (array) $ids ) ) ) );
        if ( ! empty( $ids ) ) {
            $this->last_relation_status = 'linked';
            $this->last_relation_message = ! empty( $s['relation_status_linked_text'] ) ? (string) $s['relation_status_linked_text'] : 'Showing linked items';
            return $ids;
        }

        $action = isset( $s['empty_relation_action'] ) ? sanitize_key( $s['empty_relation_action'] ) : 'latest';

        if ( 'manual' === $action ) {
            $manual = $this->filter_ids_by_type( $this->ids_from_string( isset( $s['relation_fallback_manual_ids'] ) ? $s['relation_fallback_manual_ids'] : '' ), $type );
            if ( ! empty( $manual ) ) {
                $this->last_relation_status = 'fallback';
                $this->last_relation_message = 'Relation empty — showing manual fallback items';
                return $this->apply_order_limit( $manual, $s );
            }
        }

        if ( 'hide' === $action ) {
            $this->last_relation_status = 'hidden';
            $this->last_relation_message = ! empty( $s['relation_status_empty_text'] ) ? (string) $s['relation_status_empty_text'] : 'No linked items found';
            return array();
        }

        if ( 'empty' === $action ) {
            $this->last_relation_status = 'empty';
            $this->last_relation_message = ! empty( $s['relation_status_empty_text'] ) ? (string) $s['relation_status_empty_text'] : 'No linked items found';
            return array();
        }

        $fallback = $this->latest_fallback_items( $type, $s );
        $this->last_relation_status = empty( $fallback ) ? 'empty' : 'fallback';
        $this->last_relation_message = ! empty( $s['relation_status_fallback_text'] ) ? (string) $s['relation_status_fallback_text'] : 'Relation empty — showing latest items';
        return $fallback;
    }

    private function render_relation_status( $s ) {
        if ( ! $this->boolish( isset( $s['show_relation_status'] ) ? $s['show_relation_status'] : '1' ) ) { return ''; }
        if ( empty( $this->last_relation_status ) || 'checking' === $this->last_relation_status ) { return ''; }
        $message = $this->last_relation_message ? $this->last_relation_message : ucfirst( $this->last_relation_status );
        $class = 'aus-showcase__relation-status aus-showcase__relation-status--' . sanitize_html_class( $this->last_relation_status );
        return '<div class="' . esc_attr( $class ) . '">' . esc_html( $message ) . '</div>';
    }

    private function latest_fallback_items( $type, $s ) {
        $type = $this->sanitize_content_type( $type );
        $pt = $this->post_type_for_content_type( $type );
        if ( ! $pt ) { return array(); }
        $args = array(
            'post_type'      => $pt,
            'post_status'    => 'publish',
            'posts_per_page' => max( 1, min( 60, absint( isset( $s['limit'] ) ? $s['limit'] : 8 ) ) ),
            'orderby'        => $this->sanitize_orderby( isset( $s['order_by'] ) ? $s['order_by'] : 'date' ),
            'order'          => 'ASC' === strtoupper( (string) ( isset( $s['order'] ) ? $s['order'] : 'DESC' ) ) ? 'ASC' : 'DESC',
            'fields'         => 'ids',
            'no_found_rows'  => true,
        );
        if ( $this->boolish( isset( $s['featured_only'] ) ? $s['featured_only'] : '' ) ) {
            if ( 'product' === $type ) {
                $args['tax_query'] = array( array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured', 'operator' => 'IN' ) );
            } else {
                $args['meta_query'] = array( array( 'key' => '_amaley_featured', 'value' => array( '1', 'yes', 'true', 'on' ), 'compare' => 'IN' ) );
            }
        }
        return array_map( 'absint', get_posts( $args ) );
    }

    private function sanitize_content_type( $t ) { $t = sanitize_key( $t ); return in_array( $t, array( 'cluster', 'shg', 'member', 'product' ), true ) ? $t : 'cluster'; }
    private function sanitize_layout( $v, $fb = 'grid' ) { $v = sanitize_key( $v ); return in_array( $v, array( 'grid', 'slider', 'card-row', 'list' ), true ) ? $v : $fb; }
    private function post_type_for_content_type( $t ) { $m = array( 'cluster' => 'amaley_cluster', 'shg' => 'amaley_shg_group', 'member' => 'amaley_member', 'product' => 'product' ); return isset( $m[ $t ] ) ? $m[ $t ] : ''; }
    private function filter_ids_by_type( $ids, $type ) { $pt = $this->post_type_for_content_type( $type ); $out = array(); foreach ( $ids as $id ) { if ( $pt && $pt === get_post_type( $id ) && 'publish' === get_post_status( $id ) ) { $out[] = absint( $id ); } } return $out; }
    private function ids_from_string( $v ) { $ids = array(); foreach ( preg_split( '/[\s,]+/', (string) $v ) as $p ) { $id = absint( $p ); if ( $id ) { $ids[] = $id; } } return array_values( array_unique( $ids ) ); }
    private function sanitize_orderby( $v ) { $v = sanitize_key( $v ); return in_array( $v, array( 'date', 'title', 'modified', 'menu_order', 'rand' ), true ) ? $v : 'date'; }
}
}
