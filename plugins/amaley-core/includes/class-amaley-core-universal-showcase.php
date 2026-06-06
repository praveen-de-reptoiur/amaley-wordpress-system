<?php
/** Amaley Core Universal Showcase. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Universal_Showcase {
    public function __construct() {
        $GLOBALS['amaley_core_universal_showcase'] = $this;
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
        add_shortcode( 'amaley_universal_showcase', array( $this, 'shortcode' ) );
    }

    public function register_assets() {
        if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) ) {
            wp_register_style( 'amaley-core-cards', AMALEY_CORE_URL . 'assets/amaley-core-cards.css', array(), AMALEY_CORE_VERSION );
        }
        wp_register_style( 'amaley-core-universal-showcase', AMALEY_CORE_URL . 'assets/amaley-core-universal-showcase.css', array( 'amaley-core-cards' ), AMALEY_CORE_VERSION );
        wp_register_script( 'amaley-core-universal-showcase', AMALEY_CORE_URL . 'assets/amaley-core-universal-showcase.js', array(), AMALEY_CORE_VERSION, true );
    }

    public function enqueue_assets() {
        if ( ! wp_style_is( 'amaley-core-universal-showcase', 'registered' ) ) { $this->register_assets(); }
        wp_enqueue_style( 'amaley-core-cards' );
        wp_enqueue_style( 'amaley-core-universal-showcase' );
        wp_enqueue_script( 'amaley-core-universal-showcase' );
    }

    public function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'amaley-core', array( 'title' => esc_html__( 'Amaley Core', 'amaley-core' ), 'icon' => 'fa fa-database' ) );
        }
    }

    public function register_elementor_widgets( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) || ! is_object( $widgets_manager ) ) { return; }
        $file = AMALEY_CORE_PATH . 'includes/widgets/class-amaley-core-universal-showcase-widget.php';
        if ( file_exists( $file ) ) { require_once $file; }
        if ( class_exists( 'Amaley_Core_Universal_Showcase_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new Amaley_Core_Universal_Showcase_Widget() );
        }
    }

    public function shortcode( $atts ) { return $this->render( is_array( $atts ) ? $atts : array() ); }

    public function defaults() {
        $d = array(
            'show_section'=>'1','content_type'=>'cluster','source_mode'=>'latest','manual_ids'=>'','featured_only'=>'','product_category'=>'','limit'=>'8','order_by'=>'date','order'=>'DESC',
            'section_label'=>'Amaley ecosystem','section_title'=>'Explore Amaley stories, sources and products','section_description'=>'A reusable showcase for clusters, collectives, producers and products.',
            'show_section_button'=>'','section_button_text'=>'View All','section_button_url'=>'','desktop_layout'=>'grid','tablet_layout'=>'grid','phone_layout'=>'slider','columns_desktop'=>'4','columns_tablet'=>'2','columns_phone'=>'1',
            'show_arrows'=>'1','show_dots'=>'1','show_numbers'=>'','mobile_cards_view'=>'1.12','empty_message'=>'No items are available yet.',
        );
        foreach ( array( 'cluster','shg','member','product' ) as $t ) {
            foreach ( array( 'image','label','title','excerpt','meta','tags','button' ) as $el ) { $d[ $t . '_show_' . $el ] = '1'; }
            $d[ $t . '_label_text' ] = '';
            $d[ $t . '_description_words' ] = '18';
        }
        $d['cluster_button_text']='View Cluster'; $d['shg_button_text']='View Collective'; $d['member_button_text']='View Producer'; $d['product_button_text']='View Product'; $d['product_description_words']='16';
        return $d;
    }

    public function boolish( $v ) { return in_array( (string) $v, array( '1','yes','true','on' ), true ); }

    public function render( $settings = array() ) {
        $this->enqueue_assets();
        $s = wp_parse_args( is_array( $settings ) ? $settings : array(), $this->defaults() );
        if ( ! $this->boolish( $s['show_section'] ) ) { return ''; }
        $type = $this->sanitize_content_type( $s['content_type'] );
        $items = $this->query_items( $type, $s );
        $uid = 'amaley-usw-' . wp_rand( 1000, 999999 );
        $desktop = $this->sanitize_layout( $s['desktop_layout'], 'grid' );
        $tablet  = $this->sanitize_layout( $s['tablet_layout'], 'grid' );
        $phone   = $this->sanitize_layout( $s['phone_layout'], 'slider' );
        $classes = 'amaley-universal-showcase amaley-usw amaley-usw--type-' . $type . ' amaley-usw--desktop-' . $desktop . ' amaley-usw--tablet-' . $tablet . ' amaley-usw--phone-' . $phone;
        $cd = max( 1, min( 5, absint( $s['columns_desktop'] ) ) ); $ct = max( 1, min( 4, absint( $s['columns_tablet'] ) ) ); $cp = max( 1, min( 2, absint( $s['columns_phone'] ) ) );
        ob_start(); ?>
        <section id="<?php echo esc_attr( $uid ); ?>" class="<?php echo esc_attr( $classes ); ?>" data-amaley-usw="1" data-mobile-cards-view="<?php echo esc_attr( $s['mobile_cards_view'] ); ?>">
            <div class="amaley-usw__inner">
                <?php echo $this->render_header( $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php if ( empty( $items ) ) : ?>
                    <div class="amaley-usw__empty"><?php echo esc_html( $s['empty_message'] ); ?></div>
                <?php else : ?>
                    <div class="amaley-usw__viewport" data-amaley-usw-viewport>
                        <div class="amaley-usw__track" data-amaley-usw-track style="--amaley-usw-cols-desktop:<?php echo esc_attr( $cd ); ?>;--amaley-usw-cols-tablet:<?php echo esc_attr( $ct ); ?>;--amaley-usw-cols-phone:<?php echo esc_attr( $cp ); ?>;">
                            <?php foreach ( $items as $post_id ) : ?><div class="amaley-usw__item"><?php echo $this->render_card( $type, $post_id, $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><?php endforeach; ?>
                        </div>
                    </div>
                    <?php if ( $this->boolish( $s['show_arrows'] ) || $this->boolish( $s['show_dots'] ) || $this->boolish( $s['show_numbers'] ) ) : ?>
                        <div class="amaley-usw__nav" aria-label="<?php echo esc_attr__( 'Showcase navigation', 'amaley-core' ); ?>">
                            <?php if ( $this->boolish( $s['show_arrows'] ) ) : ?><button class="amaley-usw__arrow" type="button" data-amaley-usw-prev aria-label="<?php echo esc_attr__( 'Previous', 'amaley-core' ); ?>">‹</button><?php endif; ?>
                            <?php if ( $this->boolish( $s['show_numbers'] ) ) : ?><span class="amaley-usw__counter" data-amaley-usw-counter>1 / <?php echo esc_html( count( $items ) ); ?></span><?php endif; ?>
                            <?php if ( $this->boolish( $s['show_dots'] ) ) : ?><span class="amaley-usw__dots" data-amaley-usw-dots></span><?php endif; ?>
                            <?php if ( $this->boolish( $s['show_arrows'] ) ) : ?><button class="amaley-usw__arrow" type="button" data-amaley-usw-next aria-label="<?php echo esc_attr__( 'Next', 'amaley-core' ); ?>">›</button><?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section><?php return ob_get_clean();
    }

    private function render_header( $s ) {
        if ( empty( $s['section_label'] ) && empty( $s['section_title'] ) && empty( $s['section_description'] ) && ! $this->boolish( $s['show_section_button'] ) ) { return ''; }
        ob_start(); ?><div class="amaley-usw__header"><div class="amaley-usw__heading">
            <?php if ( ! empty( $s['section_label'] ) ) : ?><p class="amaley-usw__label"><?php echo esc_html( $s['section_label'] ); ?></p><?php endif; ?>
            <?php if ( ! empty( $s['section_title'] ) ) : ?><h2 class="amaley-usw__title"><?php echo esc_html( $s['section_title'] ); ?></h2><?php endif; ?>
            <?php if ( ! empty( $s['section_description'] ) ) : ?><p class="amaley-usw__description"><?php echo esc_html( $s['section_description'] ); ?></p><?php endif; ?>
        </div><?php if ( $this->boolish( $s['show_section_button'] ) && ! empty( $s['section_button_text'] ) && ! empty( $s['section_button_url'] ) ) : ?><a class="amaley-usw__section-button" href="<?php echo esc_url( $s['section_button_url'] ); ?>"><?php echo esc_html( $s['section_button_text'] ); ?></a><?php endif; ?></div><?php return ob_get_clean();
    }

    private function render_card( $type, $post_id, $s ) {
        if ( ! class_exists( 'Amaley_Core_Card_Renderer' ) ) { return ''; }
        $p = $this->sanitize_content_type( $type );
        $args = array( 'preset'=>'og-card-1','class'=>'amaley-usw__core-card' );
        foreach ( array( 'image','label','title','excerpt','meta','tags','button' ) as $el ) { $args[ 'show_' . $el ] = $this->boolish( isset( $s[ $p . '_show_' . $el ] ) ? $s[ $p . '_show_' . $el ] : '1' ); }
        $args['label_text']    = isset( $s[ $p . '_label_text' ] ) ? $s[ $p . '_label_text' ] : '';
        $args['button_text']   = isset( $s[ $p . '_button_text' ] ) ? $s[ $p . '_button_text' ] : '';
        $args['excerpt_words'] = absint( isset( $s[ $p . '_description_words' ] ) ? $s[ $p . '_description_words' ] : 16 );
        return Amaley_Core_Card_Renderer::render( $p, absint( $post_id ), $args );
    }

    private function query_items( $type, $s ) {
        $mode = isset( $s['source_mode'] ) ? sanitize_key( $s['source_mode'] ) : 'latest';
        $manual = $this->ids_from_string( isset( $s['manual_ids'] ) ? $s['manual_ids'] : '' );
        if ( 'manual' === $mode && $manual ) { return $this->filter_ids_by_type( $manual, $type ); }
        $pt = $this->post_type_for_content_type( $type ); if ( ! $pt ) { return array(); }
        $args = array( 'post_type'=>$pt, 'post_status'=>'publish', 'posts_per_page'=>max( 1, min( 60, absint( $s['limit'] ) ) ), 'orderby'=>$this->sanitize_orderby( $s['order_by'] ), 'order'=>'ASC' === strtoupper( (string) $s['order'] ) ? 'ASC' : 'DESC', 'fields'=>'ids', 'no_found_rows'=>true );
        if ( 'product_category' === $mode && 'product' === $type && ! empty( $s['product_category'] ) ) { $args['tax_query'] = array( array( 'taxonomy'=>'product_cat', 'field'=>'slug', 'terms'=>array_map( 'sanitize_title', array_map( 'trim', explode( ',', $s['product_category'] ) ) ) ) ); }
        if ( 'featured' === $mode || $this->boolish( $s['featured_only'] ) ) {
            if ( 'product' === $type ) { $args['tax_query'][] = array( 'taxonomy'=>'product_visibility', 'field'=>'name', 'terms'=>'featured', 'operator'=>'IN' ); }
            else { $args['meta_query'] = array( array( 'key'=>'_amaley_featured', 'value'=>array( '1','yes','true','on' ), 'compare'=>'IN' ) ); }
        }
        return array_map( 'absint', get_posts( $args ) );
    }

    private function sanitize_content_type( $t ) { $t = sanitize_key( $t ); return in_array( $t, array( 'cluster','shg','member','product' ), true ) ? $t : 'cluster'; }
    private function sanitize_layout( $v, $fb = 'grid' ) { $v = sanitize_key( $v ); return in_array( $v, array( 'grid','slider','card-row','list' ), true ) ? $v : $fb; }
    private function post_type_for_content_type( $t ) { $m = array( 'cluster'=>'amaley_cluster', 'shg'=>'amaley_shg_group', 'member'=>'amaley_member', 'product'=>'product' ); return isset( $m[ $t ] ) ? $m[ $t ] : ''; }
    private function filter_ids_by_type( $ids, $type ) { $pt = $this->post_type_for_content_type( $type ); $out = array(); foreach ( $ids as $id ) { if ( $pt && $pt === get_post_type( $id ) && 'publish' === get_post_status( $id ) ) { $out[] = absint( $id ); } } return $out; }
    private function ids_from_string( $v ) { $ids = array(); foreach ( preg_split( '/[\s,]+/', (string) $v ) as $p ) { $id = absint( $p ); if ( $id ) { $ids[] = $id; } } return array_values( array_unique( $ids ) ); }
    private function sanitize_orderby( $v ) { $v = sanitize_key( $v ); return in_array( $v, array( 'date','title','modified','menu_order','rand' ), true ) ? $v : 'date'; }
}
