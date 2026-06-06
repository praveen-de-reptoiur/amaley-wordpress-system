<?php
/**
 * Amaley Core Universal Showcase.
 *
 * Adds a safe reusable Elementor showcase section for Clusters, SHGs, Members and Products.
 * This class is intentionally additive. It does not modify Discovery Engine filters, product
 * data, origin mappings, WooCommerce templates, header/footer or permalink behaviour.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Universal_Showcase {
    /** Constructor. */
    public function __construct() {
        $GLOBALS['amaley_core_universal_showcase'] = $this;

        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );

        add_shortcode( 'amaley_universal_showcase', array( $this, 'shortcode' ) );
    }

    /** Register scoped assets. */
    public function register_assets() {
        if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        }

        wp_register_style(
            'amaley-core-universal-showcase',
            AMALEY_CORE_URL . 'assets/amaley-core-universal-showcase.css',
            array( 'amaley-core-cards' ),
            AMALEY_CORE_VERSION
        );

        wp_register_script(
            'amaley-core-universal-showcase',
            AMALEY_CORE_URL . 'assets/amaley-core-universal-showcase.js',
            array(),
            AMALEY_CORE_VERSION,
            true
        );
    }

    /** Enqueue scoped assets. */
    public function enqueue_assets() {
        if ( ! wp_style_is( 'amaley-core-universal-showcase', 'registered' ) ) {
            $this->register_assets();
        }
        wp_enqueue_style( 'amaley-core-cards' );
        wp_enqueue_style( 'amaley-core-universal-showcase' );
        wp_enqueue_script( 'amaley-core-universal-showcase' );
    }

    /** Register Elementor category. */
    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    /** Register Elementor widget. */
    public function register_elementor_widgets( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
            return;
        }

        $file = AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-universal-showcase-widget.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        }

        if ( class_exists( 'Amaley_Core_Universal_Showcase_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_Universal_Showcase_Widget() );
        }
    }

    /** Shortcode wrapper. */
    public function shortcode( $atts ) {
        return $this->render( is_array( $atts ) ? $atts : array() );
    }

    /** Defaults. */
    public function defaults() {
        return array(
            'show_section' => '1',
            'content_type' => 'cluster',
            'source_mode' => 'latest',
            'manual_ids' => '',
            'featured_only' => '',
            'product_category' => '',
            'limit' => '8',
            'order_by' => 'date',
            'order' => 'DESC',
            'section_label' => 'Amaley ecosystem',
            'section_title' => 'Explore Amaley stories, sources and products',
            'section_description' => 'A reusable showcase for clusters, collectives, producers and products.',
            'show_section_button' => '',
            'section_button_text' => 'View All',
            'section_button_url' => '',
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
            'empty_message' => 'No items are available yet.',
            'cluster_label_text' => '',
            'cluster_button_text' => 'View Cluster',
            'cluster_description_words' => '18',
            'shg_label_text' => '',
            'shg_button_text' => 'View Collective',
            'shg_description_words' => '18',
            'member_label_text' => '',
            'member_button_text' => 'View Producer',
            'member_description_words' => '18',
            'product_label_text' => '',
            'product_button_text' => 'View Product',
            'product_description_words' => '16',
            'show_image' => '1',
            'show_label' => '1',
            'show_title' => '1',
            'show_excerpt' => '1',
            'show_meta' => '1',
            'show_tags' => '1',
            'show_button' => '1',
        );
    }

    /** Boolean helper. */
    public function boolish( $value ) {
        return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true );
    }

    /** Render showcase. */
    public function render( $settings = array() ) {
        $this->enqueue_assets();

        $settings = wp_parse_args( is_array( $settings ) ? $settings : array(), $this->defaults() );
        if ( ! $this->boolish( $settings['show_section'] ) ) {
            return '';
        }

        $type = $this->sanitize_content_type( $settings['content_type'] );
        $items = $this->query_items( $type, $settings );
        $uid = 'amaley-usw-' . wp_rand( 1000, 999999 );

        $classes = array(
            'amaley-universal-showcase',
            'amaley-usw',
            'amaley-usw--type-' . $type,
            'amaley-usw--desktop-' . sanitize_html_class( $settings['desktop_layout'] ),
            'amaley-usw--tablet-' . sanitize_html_class( $settings['tablet_layout'] ),
            'amaley-usw--phone-' . sanitize_html_class( $settings['phone_layout'] ),
        );

        ob_start();
        ?>
        <section id="<?php echo esc_attr( $uid ); ?>" class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>" data-amaley-usw="1" data-phone-layout="<?php echo esc_attr( $settings['phone_layout'] ); ?>" data-mobile-cards-view="<?php echo esc_attr( $settings['mobile_cards_view'] ); ?>">
            <div class="amaley-usw__inner">
                <?php echo $this->render_header( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

                <?php if ( empty( $items ) ) : ?>
                    <div class="amaley-usw__empty"><?php echo esc_html( $settings['empty_message'] ); ?></div>
                <?php else : ?>
                    <div class="amaley-usw__viewport" data-amaley-usw-viewport>
                        <div class="amaley-usw__track" data-amaley-usw-track style="--amaley-usw-cols-desktop: <?php echo esc_attr( absint( $settings['columns_desktop'] ) ); ?>; --amaley-usw-cols-tablet: <?php echo esc_attr( absint( $settings['columns_tablet'] ) ); ?>; --amaley-usw-cols-phone: <?php echo esc_attr( absint( $settings['columns_phone'] ) ); ?>;">
                            <?php foreach ( $items as $post_id ) : ?>
                                <div class="amaley-usw__item">
                                    <?php echo $this->render_card( $type, $post_id, $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if ( $this->boolish( $settings['show_arrows'] ) || $this->boolish( $settings['show_dots'] ) || $this->boolish( $settings['show_numbers'] ) ) : ?>
                        <div class="amaley-usw__nav" aria-label="<?php echo esc_attr__( 'Showcase navigation', 'amaley-core' ); ?>">
                            <?php if ( $this->boolish( $settings['show_arrows'] ) ) : ?>
                                <button class="amaley-usw__arrow" type="button" data-amaley-usw-prev aria-label="<?php echo esc_attr__( 'Previous', 'amaley-core' ); ?>">‹</button>
                            <?php endif; ?>
                            <?php if ( $this->boolish( $settings['show_numbers'] ) ) : ?>
                                <span class="amaley-usw__counter" data-amaley-usw-counter>1 / <?php echo esc_html( count( $items ) ); ?></span>
                            <?php endif; ?>
                            <?php if ( $this->boolish( $settings['show_dots'] ) ) : ?>
                                <span class="amaley-usw__dots" data-amaley-usw-dots></span>
                            <?php endif; ?>
                            <?php if ( $this->boolish( $settings['show_arrows'] ) ) : ?>
                                <button class="amaley-usw__arrow" type="button" data-amaley-usw-next aria-label="<?php echo esc_attr__( 'Next', 'amaley-core' ); ?>">›</button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /** Render section heading. */
    private function render_header( $settings ) {
        $has_header = ! empty( $settings['section_label'] ) || ! empty( $settings['section_title'] ) || ! empty( $settings['section_description'] ) || $this->boolish( $settings['show_section_button'] );
        if ( ! $has_header ) {
            return '';
        }

        ob_start();
        ?>
        <div class="amaley-usw__header">
            <div class="amaley-usw__heading">
                <?php if ( ! empty( $settings['section_label'] ) ) : ?>
                    <p class="amaley-usw__label"><?php echo esc_html( $settings['section_label'] ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $settings['section_title'] ) ) : ?>
                    <h2 class="amaley-usw__title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                <?php endif; ?>
                <?php if ( ! empty( $settings['section_description'] ) ) : ?>
                    <p class="amaley-usw__description"><?php echo esc_html( $settings['section_description'] ); ?></p>
                <?php endif; ?>
            </div>
            <?php if ( $this->boolish( $settings['show_section_button'] ) && ! empty( $settings['section_button_text'] ) && ! empty( $settings['section_button_url'] ) ) : ?>
                <a class="amaley-usw__section-button" href="<?php echo esc_url( $settings['section_button_url'] ); ?>"><?php echo esc_html( $settings['section_button_text'] ); ?></a>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /** Render one Core card. */
    private function render_card( $type, $post_id, $settings ) {
        if ( ! class_exists( 'Amaley_Core_Card_Renderer' ) ) {
            return '';
        }

        $prefix = $type;
        $args = array(
            'preset' => 'og-card-1',
            'show_image' => $this->boolish( $settings['show_image'] ),
            'show_label' => $this->boolish( $settings['show_label'] ),
            'show_title' => $this->boolish( $settings['show_title'] ),
            'show_excerpt' => $this->boolish( $settings['show_excerpt'] ),
            'show_meta' => $this->boolish( $settings['show_meta'] ),
            'show_tags' => $this->boolish( $settings['show_tags'] ),
            'show_button' => $this->boolish( $settings['show_button'] ),
            'label_text' => isset( $settings[ $prefix . '_label_text' ] ) ? $settings[ $prefix . '_label_text' ] : '',
            'button_text' => isset( $settings[ $prefix . '_button_text' ] ) ? $settings[ $prefix . '_button_text' ] : '',
            'excerpt_words' => isset( $settings[ $prefix . '_description_words' ] ) ? absint( $settings[ $prefix . '_description_words' ] ) : 16,
            'class' => 'amaley-usw__core-card',
        );

        return Amaley_Core_Card_Renderer::render( $type, absint( $post_id ), $args );
    }

    /** Query items. */
    private function query_items( $type, $settings ) {
        $manual_ids = $this->ids_from_string( isset( $settings['manual_ids'] ) ? $settings['manual_ids'] : '' );
        if ( 'manual' === $settings['source_mode'] && ! empty( $manual_ids ) ) {
            return $this->filter_ids_by_type( $manual_ids, $type );
        }

        $post_type = $this->post_type_for_content_type( $type );
        if ( ! $post_type ) {
            return array();
        }

        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => max( 1, min( 60, absint( $settings['limit'] ) ) ),
            'orderby' => $this->sanitize_orderby( $settings['order_by'] ),
            'order' => 'ASC' === strtoupper( (string) $settings['order'] ) ? 'ASC' : 'DESC',
            'fields' => 'ids',
            'no_found_rows' => true,
        );

        if ( 'product_category' === $settings['source_mode'] && 'product' === $type && ! empty( $settings['product_category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array_map( 'sanitize_title', array_map( 'trim', explode( ',', $settings['product_category'] ) ) ),
                ),
            );
        }

        if ( 'featured' === $settings['source_mode'] || $this->boolish( $settings['featured_only'] ) ) {
            if ( 'product' === $type ) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'featured',
                    'operator' => 'IN',
                );
            } else {
                $args['meta_query'][] = array(
                    'key' => '_amaley_featured',
                    'value' => array( '1', 'yes', 'true', 'on' ),
                    'compare' => 'IN',
                );
            }
        }

        return array_map( 'absint', get_posts( $args ) );
    }

    /** Sanitize content type. */
    private function sanitize_content_type( $type ) {
        $type = sanitize_key( $type );
        return in_array( $type, array( 'cluster', 'shg', 'member', 'product' ), true ) ? $type : 'cluster';
    }

    /** Post type map. */
    private function post_type_for_content_type( $type ) {
        $map = array(
            'cluster' => 'amaley_cluster',
            'shg' => 'amaley_shg_group',
            'member' => 'amaley_member',
            'product' => 'product',
        );
        return isset( $map[ $type ] ) ? $map[ $type ] : '';
    }

    /** Filter manual IDs by selected type. */
    private function filter_ids_by_type( $ids, $type ) {
        $post_type = $this->post_type_for_content_type( $type );
        $clean = array();
        foreach ( $ids as $id ) {
            if ( $post_type && $post_type === get_post_type( $id ) && 'publish' === get_post_status( $id ) ) {
                $clean[] = absint( $id );
            }
        }
        return $clean;
    }

    /** Parse comma-separated IDs. */
    private function ids_from_string( $value ) {
        $parts = preg_split( '/[\s,]+/', (string) $value );
        $ids = array();
        foreach ( (array) $parts as $part ) {
            $id = absint( $part );
            if ( $id ) {
                $ids[] = $id;
            }
        }
        return array_values( array_unique( $ids ) );
    }

    /** Safe orderby values. */
    private function sanitize_orderby( $value ) {
        $value = sanitize_key( $value );
        return in_array( $value, array( 'date', 'title', 'modified', 'menu_order', 'rand' ), true ) ? $value : 'date';
    }
}
