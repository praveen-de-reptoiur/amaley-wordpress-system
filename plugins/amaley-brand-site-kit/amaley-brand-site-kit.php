<?php
/**
 * Plugin Name: Amaley Brand Site Kit
 * Plugin URI:  https://amaleycollective.com/
 * Description: Global Amaley design-token layer for the fresh WordPress build. Controls brand colors, fonts, spacing, cards, buttons, badges and optional WooCommerce/Elementor visual bridges from one safe place.
 * Version:     1.0.4
 * Author:      Praveen
 * Text Domain: amaley-brand-site-kit
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package Amaley_Brand_Site_Kit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( defined( 'AMALEY_BRAND_SITE_KIT_VERSION' ) ) {
    return;
}

define( 'AMALEY_BRAND_SITE_KIT_VERSION', '1.0.4' );
define( 'AMALEY_BRAND_SITE_KIT_FILE', __FILE__ );
define( 'AMALEY_BRAND_SITE_KIT_PATH', plugin_dir_path( __FILE__ ) );
define( 'AMALEY_BRAND_SITE_KIT_URL', plugin_dir_url( __FILE__ ) );
define( 'AMALEY_BRAND_SITE_KIT_OPTION', 'amaley_brand_site_kit_settings' );
define( 'AMALEY_BRAND_SITE_KIT_ELEMENTOR_BACKUP_OPTION', 'amaley_brand_site_kit_elementor_backup' );
define( 'AMALEY_BRAND_SITE_KIT_SYNC_STATUS_OPTION', 'amaley_brand_site_kit_sync_status' );
define( 'AMALEY_BRAND_SITE_KIT_SAFETY_MIGRATION_OPTION', 'amaley_brand_site_kit_v104_safety_migrated' );

/**
 * Amaley Brand Site Kit.
 *
 * This plugin is intentionally separate from Amaley Core.
 * It does not register CPTs, change WooCommerce data, replace templates,
 * create header/footer output, or alter cart/checkout logic.
 */
final class Amaley_Brand_Site_Kit {

    /**
     * Singleton instance.
     *
     * @var self|null
     */
    private static $instance = null;

    /**
     * Return singleton instance.
     *
     * @return self
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        add_action( 'init', array( $this, 'load_textdomain' ) );
        add_action( 'init', array( $this, 'maybe_apply_v104_safety_defaults' ), 1 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ), 20 );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ), 20 );
        add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
        add_action( 'admin_init', array( $this, 'maybe_save_settings' ) );
        add_action( 'admin_post_amaley_bsk_sync_elementor', array( $this, 'handle_sync_elementor' ) );
        add_action( 'admin_post_amaley_bsk_restore_elementor', array( $this, 'handle_restore_elementor' ) );
        add_action( 'admin_post_amaley_bsk_sync_wordpress', array( $this, 'handle_sync_wordpress' ) );
        add_action( 'after_setup_theme', array( $this, 'register_wordpress_editor_palette' ), 20 );
        add_filter( 'block_editor_settings_all', array( $this, 'filter_block_editor_settings' ), 20, 2 );
        add_filter( 'body_class', array( $this, 'add_body_class' ) );
    }

    /**
     * Plugin activation.
     */
    public static function activate() {
        $current = get_option( AMALEY_BRAND_SITE_KIT_OPTION );

        if ( ! is_array( $current ) ) {
            update_option( AMALEY_BRAND_SITE_KIT_OPTION, self::defaults(), false );
        }
    }

    /**
     * Load translation files if added later.
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'amaley-brand-site-kit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
     * Apply v1.0.4 safety defaults once on existing installs.
     *
     * This keeps global token sync intact, but prevents broad frontend CSS bridges from
     * automatically changing future pages, WooCommerce cards, buttons or headings.
     */
    public function maybe_apply_v104_safety_defaults() {
        if ( get_option( AMALEY_BRAND_SITE_KIT_SAFETY_MIGRATION_OPTION ) ) {
            return;
        }

        $settings = self::settings();
        $settings['enable_global_bridge']      = 'no';
        $settings['enable_woocommerce_bridge'] = 'no';
        $settings['enable_elementor_bridge']   = 'no';

        update_option( AMALEY_BRAND_SITE_KIT_OPTION, $settings, false );
        update_option( AMALEY_BRAND_SITE_KIT_SAFETY_MIGRATION_OPTION, current_time( 'mysql' ), false );
    }

    /**
     * Default settings based on the uploaded Amaley design-system PDF.
     *
     * @return array<string,string>
     */
    public static function defaults() {
        return array(
            'cacao'                       => '#2E1203',
            'gold'                        => '#C2880A',
            'clay'                        => '#8A4A24',
            'sage'                        => '#6F7F55',
            'rose'                        => '#B86B5E',
            'ivory'                       => '#FBF6EC',
            'cream'                       => '#FFF9EF',
            'border'                      => '#E6D6BF',
            'text'                        => '#3A2114',
            'muted'                       => '#7A6858',
            'sage_wash'                   => '#F0F2E8',
            'rose_wash'                   => '#FBEEE9',
            'women_badge_bg'              => '#F5E1DC',
            'women_badge_text'            => '#8A3F35',
            'natural_badge_bg'            => '#E8EBDD',
            'natural_badge_text'          => '#4D5E3F',
            'quality_badge_bg'            => '#F7EBC8',
            'quality_badge_text'          => '#6B4B00',
            'ingredient_badge_bg'         => '#EFE3D0',
            'ingredient_badge_text'       => '#6B3B1F',
            'font_heading'                => 'Playfair Display, Georgia, serif',
            'font_body'                   => 'Lato, Arial, sans-serif',
            'font_button'                 => 'Lato, Arial, sans-serif',
            'section_padding_desktop'     => '96px',
            'section_padding_tablet'      => '64px',
            'section_padding_mobile'      => '48px',
            'container_width'             => '1240px',
            'radius_card'                 => '24px',
            'radius_small'                => '14px',
            'radius_pill'                 => '999px',
            'shadow_card'                 => '0 18px 45px rgba(46,18,3,.08)',
            'shadow_card_hover'           => '0 22px 60px rgba(46,18,3,.14)',
            'enable_google_fonts'         => 'yes',
            'enable_global_bridge'        => 'no',
            'enable_woocommerce_bridge'   => 'no',
            'enable_elementor_bridge'     => 'no',
        );
    }

    /**
     * Get merged settings.
     *
     * @return array<string,string>
     */
    public static function settings() {
        $saved = get_option( AMALEY_BRAND_SITE_KIT_OPTION, array() );

        if ( ! is_array( $saved ) ) {
            $saved = array();
        }

        return wp_parse_args( $saved, self::defaults() );
    }


    /**
     * Brand color token list for Elementor and WordPress editor sync.
     *
     * @param array<string,string>|null $settings Optional settings.
     * @return array<int,array<string,string>>
     */
    public static function brand_color_tokens( $settings = null ) {
        $s = is_array( $settings ) ? wp_parse_args( $settings, self::defaults() ) : self::settings();

        return array(
            array( 'slug' => 'amaley-cacao', 'elementor_id' => 'amaley_cacao', 'name' => 'Himalayan Cacao', 'color' => $s['cacao'] ),
            array( 'slug' => 'amaley-gold', 'elementor_id' => 'amaley_gold', 'name' => 'Apricot Gold', 'color' => $s['gold'] ),
            array( 'slug' => 'amaley-clay', 'elementor_id' => 'amaley_clay', 'name' => 'Clay Brown', 'color' => $s['clay'] ),
            array( 'slug' => 'amaley-sage', 'elementor_id' => 'amaley_sage', 'name' => 'Himalayan Sage', 'color' => $s['sage'] ),
            array( 'slug' => 'amaley-rose', 'elementor_id' => 'amaley_rose', 'name' => 'Collective Rose', 'color' => $s['rose'] ),
            array( 'slug' => 'amaley-ivory', 'elementor_id' => 'amaley_ivory', 'name' => 'Warm Ivory', 'color' => $s['ivory'] ),
            array( 'slug' => 'amaley-cream', 'elementor_id' => 'amaley_cream', 'name' => 'Soft Cream', 'color' => $s['cream'] ),
            array( 'slug' => 'amaley-border', 'elementor_id' => 'amaley_border', 'name' => 'Sand Border', 'color' => $s['border'] ),
            array( 'slug' => 'amaley-walnut', 'elementor_id' => 'amaley_walnut', 'name' => 'Deep Walnut', 'color' => $s['text'] ),
            array( 'slug' => 'amaley-earth-grey', 'elementor_id' => 'amaley_earth_grey', 'name' => 'Earth Grey', 'color' => $s['muted'] ),
            array( 'slug' => 'amaley-sage-wash', 'elementor_id' => 'amaley_sage_wash', 'name' => 'Soft Sage Wash', 'color' => $s['sage_wash'] ),
            array( 'slug' => 'amaley-rose-wash', 'elementor_id' => 'amaley_rose_wash', 'name' => 'Rose Wash', 'color' => $s['rose_wash'] ),
        );
    }

    /**
     * Register Amaley palette in the WordPress block editor.
     */
    public function register_wordpress_editor_palette() {
        $palette = array();

        foreach ( self::brand_color_tokens() as $token ) {
            $palette[] = array(
                'name'  => $token['name'],
                'slug'  => $token['slug'],
                'color' => $token['color'],
            );
        }

        if ( function_exists( 'add_theme_support' ) ) {
            add_theme_support( 'editor-color-palette', $palette );
        }
    }

    /**
     * Make the Amaley palette visible in newer block-editor settings too.
     *
     * @param array<string,mixed> $editor_settings Editor settings.
     * @param mixed              $context Editor context.
     * @return array<string,mixed>
     */
    public function filter_block_editor_settings( $editor_settings, $context ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
        $palette = array();

        foreach ( self::brand_color_tokens() as $token ) {
            $palette[] = array(
                'name'  => $token['name'],
                'slug'  => $token['slug'],
                'color' => $token['color'],
            );
        }

        $existing = isset( $editor_settings['colors'] ) && is_array( $editor_settings['colors'] ) ? $editor_settings['colors'] : array();
        $existing = array_filter(
            $existing,
            function ( $item ) {
                return ! ( is_array( $item ) && isset( $item['slug'] ) && 0 === strpos( (string) $item['slug'], 'amaley-' ) );
            }
        );

        $editor_settings['colors'] = array_values( array_merge( $existing, $palette ) );

        return $editor_settings;
    }

    /**
     * Add a body class so global bridge styles stay opt-in and reversible.
     *
     * @param array<int,string> $classes Body classes.
     * @return array<int,string>
     */
    public function add_body_class( $classes ) {
        $settings = self::settings();

        if ( 'yes' === $settings['enable_global_bridge'] ) {
            $classes[] = 'amaley-brand-kit-enabled';
        }

        return $classes;
    }

    /**
     * Enqueue frontend CSS and optional fonts.
     */
    public function enqueue_frontend_assets() {
        $settings = self::settings();

        if ( 'yes' === $settings['enable_google_fonts'] ) {
            wp_enqueue_style(
                'amaley-brand-site-kit-fonts',
                'https://fonts.googleapis.com/css2?family=Lato:wght@400;600;700;900&family=Playfair+Display:wght@600;700&display=swap',
                array(),
                null
            );
        }

        wp_register_style( 'amaley-brand-site-kit', false, array(), AMALEY_BRAND_SITE_KIT_VERSION );
        wp_enqueue_style( 'amaley-brand-site-kit' );
        wp_add_inline_style( 'amaley-brand-site-kit', $this->build_css( 'frontend' ) );
    }

    /**
     * Enqueue small admin CSS for the settings page and Elementor/admin visual reference.
     *
     * @param string $hook Current admin hook.
     */
    public function enqueue_admin_assets( $hook ) {
        if ( false === strpos( (string) $hook, 'amaley-brand-site-kit' ) ) {
            return;
        }

        $settings = self::settings();

        if ( 'yes' === $settings['enable_google_fonts'] ) {
            wp_enqueue_style(
                'amaley-brand-site-kit-fonts',
                'https://fonts.googleapis.com/css2?family=Lato:wght@400;600;700;900&family=Playfair+Display:wght@600;700&display=swap',
                array(),
                null
            );
        }

        wp_register_style( 'amaley-brand-site-kit-admin', false, array(), AMALEY_BRAND_SITE_KIT_VERSION );
        wp_enqueue_style( 'amaley-brand-site-kit-admin' );
        wp_add_inline_style( 'amaley-brand-site-kit-admin', $this->build_css( 'admin' ) . $this->admin_css() );
    }

    /**
     * Register admin page.
     */
    public function register_admin_page() {
        add_menu_page(
            __( 'Amaley Brand Kit', 'amaley-brand-site-kit' ),
            __( 'Amaley Brand Kit', 'amaley-brand-site-kit' ),
            'manage_options',
            'amaley-brand-site-kit',
            array( $this, 'render_admin_page' ),
            'dashicons-art',
            58
        );

        add_submenu_page(
            'amaley-brand-site-kit',
            __( 'Global Tokens', 'amaley-brand-site-kit' ),
            __( 'Global Tokens', 'amaley-brand-site-kit' ),
            'manage_options',
            'amaley-brand-site-kit',
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Save settings safely.
     */
    public function maybe_save_settings() {
        if ( empty( $_POST['amaley_brand_site_kit_action'] ) || 'save' !== sanitize_text_field( wp_unslash( $_POST['amaley_brand_site_kit_action'] ) ) ) {
            return;
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        check_admin_referer( 'amaley_brand_site_kit_save', 'amaley_brand_site_kit_nonce' );

        $defaults = self::defaults();
        $next     = array();
        $color_keys = array(
            'cacao',
            'gold',
            'clay',
            'sage',
            'rose',
            'ivory',
            'cream',
            'border',
            'text',
            'muted',
            'sage_wash',
            'rose_wash',
            'women_badge_bg',
            'women_badge_text',
            'natural_badge_bg',
            'natural_badge_text',
            'quality_badge_bg',
            'quality_badge_text',
            'ingredient_badge_bg',
            'ingredient_badge_text',
        );
        $text_keys = array(
            'font_heading',
            'font_body',
            'font_button',
            'section_padding_desktop',
            'section_padding_tablet',
            'section_padding_mobile',
            'container_width',
            'radius_card',
            'radius_small',
            'radius_pill',
            'shadow_card',
            'shadow_card_hover',
        );
        $bool_keys = array(
            'enable_google_fonts',
            'enable_global_bridge',
            'enable_woocommerce_bridge',
            'enable_elementor_bridge',
        );

        foreach ( $color_keys as $key ) {
            $raw          = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : $defaults[ $key ];
            $next[ $key ] = sanitize_hex_color( $raw ) ? sanitize_hex_color( $raw ) : $defaults[ $key ];
        }

        foreach ( $text_keys as $key ) {
            $raw          = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : $defaults[ $key ];
            $next[ $key ] = $raw ? $raw : $defaults[ $key ];
        }

        foreach ( $bool_keys as $key ) {
            $next[ $key ] = ! empty( $_POST[ $key ] ) ? 'yes' : 'no';
        }

        update_option( AMALEY_BRAND_SITE_KIT_OPTION, $next, false );

        wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-brand-site-kit', 'updated' => '1' ), admin_url( 'admin.php' ) ) );
        exit;
    }


    /**
     * Return the active Elementor Kit ID when Elementor is available.
     *
     * @return int
     */
    private function get_active_elementor_kit_id() {
        $kit_id = 0;

        if ( class_exists( '\Elementor\Plugin' ) ) {
            try {
                $elementor = \Elementor\Plugin::$instance;

                if ( $elementor && isset( $elementor->kits_manager ) ) {
                    if ( method_exists( $elementor->kits_manager, 'get_active_id' ) ) {
                        $kit_id = absint( $elementor->kits_manager->get_active_id() );
                    } elseif ( method_exists( $elementor->kits_manager, 'get_active_kit' ) ) {
                        $kit = $elementor->kits_manager->get_active_kit();
                        if ( is_object( $kit ) && method_exists( $kit, 'get_id' ) ) {
                            $kit_id = absint( $kit->get_id() );
                        }
                    }
                }
            } catch ( \Throwable $e ) { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
                $kit_id = 0;
            }
        }

        if ( ! $kit_id ) {
            $kit_id = absint( get_option( 'elementor_active_kit' ) );
        }

        return $kit_id;
    }

    /**
     * Extract the first font family name from a CSS font stack.
     *
     * @param string $stack Font stack.
     * @return string
     */
    private function first_font_family( $stack ) {
        $parts = explode( ',', (string) $stack );
        $font  = trim( $parts[0] ?? '' );
        $font  = trim( $font, " \t\n\r\0\x0B'\"" );

        return $font ? $font : 'Arial';
    }

    /**
     * Build Elementor system colors.
     *
     * @param array<string,string> $s Settings.
     * @return array<int,array<string,string>>
     */
    private function elementor_system_colors( $s ) {
        return array(
            array( '_id' => 'primary', 'title' => 'Primary', 'color' => $s['cacao'] ),
            array( '_id' => 'secondary', 'title' => 'Secondary', 'color' => $s['clay'] ),
            array( '_id' => 'text', 'title' => 'Text', 'color' => $s['text'] ),
            array( '_id' => 'accent', 'title' => 'Accent', 'color' => $s['gold'] ),
        );
    }

    /**
     * Build Elementor system typography.
     *
     * @param array<string,string> $s Settings.
     * @return array<int,array<string,string>>
     */
    private function elementor_system_typography( $s ) {
        $heading = $this->first_font_family( $s['font_heading'] );
        $body    = $this->first_font_family( $s['font_body'] );
        $button  = $this->first_font_family( $s['font_button'] );

        return array(
            array(
                '_id'                    => 'primary',
                'title'                  => 'Primary',
                'typography_typography'  => 'custom',
                'typography_font_family' => $heading,
                'typography_font_weight' => '700',
            ),
            array(
                '_id'                    => 'secondary',
                'title'                  => 'Secondary',
                'typography_typography'  => 'custom',
                'typography_font_family' => $heading,
                'typography_font_weight' => '600',
            ),
            array(
                '_id'                    => 'text',
                'title'                  => 'Text',
                'typography_typography'  => 'custom',
                'typography_font_family' => $body,
                'typography_font_weight' => '400',
            ),
            array(
                '_id'                    => 'accent',
                'title'                  => 'Accent',
                'typography_typography'  => 'custom',
                'typography_font_family' => $button,
                'typography_font_weight' => '800',
            ),
        );
    }

    /**
     * Remove previous Amaley entries before re-adding them, without touching unrelated user tokens.
     *
     * @param array<int,mixed> $items Existing items.
     * @return array<int,mixed>
     */
    private function remove_amaley_elementor_items( $items ) {
        if ( ! is_array( $items ) ) {
            return array();
        }

        $clean = array();

        foreach ( $items as $item ) {
            if ( ! is_array( $item ) ) {
                continue;
            }

            $id    = isset( $item['_id'] ) ? (string) $item['_id'] : '';
            $title = isset( $item['title'] ) ? (string) $item['title'] : '';

            if ( 0 === strpos( $id, 'amaley_' ) || 0 === strpos( $title, 'Amaley ' ) || in_array( $title, wp_list_pluck( self::brand_color_tokens(), 'name' ), true ) ) {
                continue;
            }

            $clean[] = $item;
        }

        return $clean;
    }

    /**
     * Handle Elementor Kit sync.
     */
    public function handle_sync_elementor() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You are not allowed to sync Amaley brand tokens.', 'amaley-brand-site-kit' ) );
        }

        check_admin_referer( 'amaley_bsk_sync_elementor', 'amaley_bsk_sync_nonce' );

        $kit_id = $this->get_active_elementor_kit_id();
        if ( ! $kit_id ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-brand-site-kit', 'sync' => 'elementor-missing' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        $current_settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
        if ( ! is_array( $current_settings ) ) {
            $current_settings = array();
        }

        update_option(
            AMALEY_BRAND_SITE_KIT_ELEMENTOR_BACKUP_OPTION,
            array(
                'time'     => current_time( 'mysql' ),
                'kit_id'   => $kit_id,
                'settings' => $current_settings,
            ),
            false
        );

        $s = self::settings();

        $custom_colors = $this->remove_amaley_elementor_items( isset( $current_settings['custom_colors'] ) ? $current_settings['custom_colors'] : array() );
        foreach ( self::brand_color_tokens( $s ) as $token ) {
            $custom_colors[] = array(
                '_id'   => $token['elementor_id'],
                'title' => $token['name'],
                'color' => $token['color'],
            );
        }

        $custom_typography = $this->remove_amaley_elementor_items( isset( $current_settings['custom_typography'] ) ? $current_settings['custom_typography'] : array() );
        $custom_typography[] = array(
            '_id'                    => 'amaley_heading',
            'title'                  => 'Amaley Heading',
            'typography_typography'  => 'custom',
            'typography_font_family' => $this->first_font_family( $s['font_heading'] ),
            'typography_font_weight' => '700',
        );
        $custom_typography[] = array(
            '_id'                    => 'amaley_body',
            'title'                  => 'Amaley Body',
            'typography_typography'  => 'custom',
            'typography_font_family' => $this->first_font_family( $s['font_body'] ),
            'typography_font_weight' => '400',
        );
        $custom_typography[] = array(
            '_id'                    => 'amaley_button',
            'title'                  => 'Amaley Button',
            'typography_typography'  => 'custom',
            'typography_font_family' => $this->first_font_family( $s['font_button'] ),
            'typography_font_weight' => '800',
        );

        $current_settings['system_colors']     = $this->elementor_system_colors( $s );
        $current_settings['custom_colors']     = $custom_colors;
        $current_settings['system_typography'] = $this->elementor_system_typography( $s );
        $current_settings['custom_typography'] = $custom_typography;

        update_post_meta( $kit_id, '_elementor_page_settings', $current_settings );

        $status                     = get_option( AMALEY_BRAND_SITE_KIT_SYNC_STATUS_OPTION, array() );
        $status['elementor_time']   = current_time( 'mysql' );
        $status['elementor_kit_id'] = $kit_id;
        update_option( AMALEY_BRAND_SITE_KIT_SYNC_STATUS_OPTION, $status, false );

        if ( class_exists( '\Elementor\Plugin' ) ) {
            try {
                $elementor = \Elementor\Plugin::$instance;
                if ( $elementor && isset( $elementor->files_manager ) && method_exists( $elementor->files_manager, 'clear_cache' ) ) {
                    $elementor->files_manager->clear_cache();
                }
            } catch ( \Throwable $e ) { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
            }
        }

        wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-brand-site-kit', 'sync' => 'elementor-success' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    /**
     * Restore previous Elementor Kit backup created before last sync.
     */
    public function handle_restore_elementor() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You are not allowed to restore Elementor Kit backup.', 'amaley-brand-site-kit' ) );
        }

        check_admin_referer( 'amaley_bsk_restore_elementor', 'amaley_bsk_restore_nonce' );

        $backup = get_option( AMALEY_BRAND_SITE_KIT_ELEMENTOR_BACKUP_OPTION, array() );
        if ( empty( $backup['kit_id'] ) || ! isset( $backup['settings'] ) || ! is_array( $backup['settings'] ) ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-brand-site-kit', 'sync' => 'restore-missing' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        update_post_meta( absint( $backup['kit_id'] ), '_elementor_page_settings', $backup['settings'] );

        wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-brand-site-kit', 'sync' => 'restore-success' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    /**
     * Handle safe WordPress palette sync.
     */
    public function handle_sync_wordpress() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You are not allowed to sync WordPress brand tokens.', 'amaley-brand-site-kit' ) );
        }

        check_admin_referer( 'amaley_bsk_sync_wordpress', 'amaley_bsk_wp_nonce' );

        $palette = array();
        foreach ( self::brand_color_tokens() as $token ) {
            $palette[] = array(
                'name'  => $token['name'],
                'slug'  => $token['slug'],
                'color' => $token['color'],
            );
        }

        set_theme_mod( 'editor-color-palette', $palette );

        $status                   = get_option( AMALEY_BRAND_SITE_KIT_SYNC_STATUS_OPTION, array() );
        $status['wordpress_time'] = current_time( 'mysql' );
        update_option( AMALEY_BRAND_SITE_KIT_SYNC_STATUS_OPTION, $status, false );

        wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-brand-site-kit', 'sync' => 'wordpress-success' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    /**
     * Render global sync controls.
     *
     * @param array<string,string> $settings Current settings.
     */
    private function render_global_sync_panel( $settings ) {
        $kit_id = $this->get_active_elementor_kit_id();
        $backup = get_option( AMALEY_BRAND_SITE_KIT_ELEMENTOR_BACKUP_OPTION, array() );
        $status = get_option( AMALEY_BRAND_SITE_KIT_SYNC_STATUS_OPTION, array() );
        ?>
        <h2><?php esc_html_e( 'Global Sync', 'amaley-brand-site-kit' ); ?></h2>
        <div class="amaley-bsk-sync-panel">
            <div class="amaley-bsk-sync-card">
                <h3><?php esc_html_e( 'Elementor Global Colors + Fonts', 'amaley-brand-site-kit' ); ?></h3>
                <p><?php esc_html_e( 'Sync Amaley colors and fonts into the active Elementor Site Kit so they appear in Elementor Global Colors and Global Fonts.', 'amaley-brand-site-kit' ); ?></p>
                <p><strong><?php esc_html_e( 'Active Elementor Kit:', 'amaley-brand-site-kit' ); ?></strong> <?php echo $kit_id ? esc_html( '#' . $kit_id ) : esc_html__( 'Not detected', 'amaley-brand-site-kit' ); ?></p>
                <?php if ( ! empty( $status['elementor_time'] ) ) : ?>
                    <p><strong><?php esc_html_e( 'Last Elementor sync:', 'amaley-brand-site-kit' ); ?></strong> <?php echo esc_html( $status['elementor_time'] ); ?></p>
                <?php endif; ?>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php wp_nonce_field( 'amaley_bsk_sync_elementor', 'amaley_bsk_sync_nonce' ); ?>
                    <input type="hidden" name="action" value="amaley_bsk_sync_elementor" />
                    <button type="submit" class="button button-primary"><?php esc_html_e( 'Sync Amaley Colors + Fonts to Elementor', 'amaley-brand-site-kit' ); ?></button>
                </form>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="amaley-bsk-inline-form">
                    <?php wp_nonce_field( 'amaley_bsk_restore_elementor', 'amaley_bsk_restore_nonce' ); ?>
                    <input type="hidden" name="action" value="amaley_bsk_restore_elementor" />
                    <button type="submit" class="button" <?php disabled( empty( $backup['kit_id'] ) ); ?>><?php esc_html_e( 'Restore Last Elementor Kit Backup', 'amaley-brand-site-kit' ); ?></button>
                </form>
            </div>
            <div class="amaley-bsk-sync-card">
                <h3><?php esc_html_e( 'WordPress Editor Palette', 'amaley-brand-site-kit' ); ?></h3>
                <p><?php esc_html_e( 'Make Amaley colors available inside the WordPress block editor palette. This is safe and does not overwrite theme files.', 'amaley-brand-site-kit' ); ?></p>
                <?php if ( ! empty( $status['wordpress_time'] ) ) : ?>
                    <p><strong><?php esc_html_e( 'Last WordPress sync:', 'amaley-brand-site-kit' ); ?></strong> <?php echo esc_html( $status['wordpress_time'] ); ?></p>
                <?php endif; ?>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php wp_nonce_field( 'amaley_bsk_sync_wordpress', 'amaley_bsk_wp_nonce' ); ?>
                    <input type="hidden" name="action" value="amaley_bsk_sync_wordpress" />
                    <button type="submit" class="button button-secondary"><?php esc_html_e( 'Sync Amaley Colors to WordPress Editor', 'amaley-brand-site-kit' ); ?></button>
                </form>
            </div>
        </div>
        <?php
    }

    /**
     * Render admin settings page.
     */
    public function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $settings = self::settings();
        $colors = array(
            'cacao'                 => 'Himalayan Cacao',
            'gold'                  => 'Apricot Gold',
            'clay'                  => 'Clay Brown',
            'sage'                  => 'Himalayan Sage',
            'rose'                  => 'Collective Rose',
            'ivory'                 => 'Warm Ivory',
            'cream'                 => 'Soft Cream',
            'border'                => 'Sand Border',
            'text'                  => 'Deep Walnut',
            'muted'                 => 'Earth Grey',
            'sage_wash'             => 'Soft Sage Wash',
            'rose_wash'             => 'Rose Wash',
            'women_badge_bg'        => 'Women Badge Background',
            'women_badge_text'      => 'Women Badge Text',
            'natural_badge_bg'      => 'Natural Badge Background',
            'natural_badge_text'    => 'Natural Badge Text',
            'quality_badge_bg'      => 'Quality Badge Background',
            'quality_badge_text'    => 'Quality Badge Text',
            'ingredient_badge_bg'   => 'Ingredient Badge Background',
            'ingredient_badge_text' => 'Ingredient Badge Text',
        );
        ?>
        <div class="wrap amaley-bsk-admin">
            <h1><?php esc_html_e( 'Amaley Brand Site Kit', 'amaley-brand-site-kit' ); ?></h1>
            <?php if ( isset( $_GET['updated'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
                <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Amaley brand tokens saved.', 'amaley-brand-site-kit' ); ?></p></div>
            <?php endif; ?>
            <?php if ( isset( $_GET['sync'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
                <?php
                $sync_message = '';
                switch ( sanitize_text_field( wp_unslash( $_GET['sync'] ) ) ) {
                    case 'elementor-success':
                        $sync_message = __( 'Amaley colors and fonts synced to the active Elementor Kit.', 'amaley-brand-site-kit' );
                        break;
                    case 'wordpress-success':
                        $sync_message = __( 'Amaley colors synced to the WordPress editor palette.', 'amaley-brand-site-kit' );
                        break;
                    case 'restore-success':
                        $sync_message = __( 'Previous Elementor Kit backup restored.', 'amaley-brand-site-kit' );
                        break;
                    case 'elementor-missing':
                        $sync_message = __( 'Elementor active Kit was not detected. Please ensure Elementor is active and a Site Kit exists.', 'amaley-brand-site-kit' );
                        break;
                    case 'restore-missing':
                        $sync_message = __( 'No Elementor Kit backup is available yet.', 'amaley-brand-site-kit' );
                        break;
                }
                ?>
                <?php if ( $sync_message ) : ?>
                    <div class="notice notice-info is-dismissible"><p><?php echo esc_html( $sync_message ); ?></p></div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="amaley-bsk-admin__intro">
                <p><strong><?php esc_html_e( 'Purpose:', 'amaley-brand-site-kit' ); ?></strong> <?php esc_html_e( 'One controlled place for Amaley global colors, fonts, spacing, buttons, cards and WooCommerce visual bridge.', 'amaley-brand-site-kit' ); ?></p>
                <p><?php esc_html_e( 'This plugin is separate from Amaley Core. It does not create CPTs, product data, header/footer, cart, checkout, or templates.', 'amaley-brand-site-kit' ); ?></p>
            </div>

            <?php $this->render_global_sync_panel( $settings ); ?>

            <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=amaley-brand-site-kit' ) ); ?>">
                <?php wp_nonce_field( 'amaley_brand_site_kit_save', 'amaley_brand_site_kit_nonce' ); ?>
                <input type="hidden" name="amaley_brand_site_kit_action" value="save" />

                <h2><?php esc_html_e( 'Global Color Tokens', 'amaley-brand-site-kit' ); ?></h2>
                <div class="amaley-bsk-token-grid">
                    <?php foreach ( $colors as $key => $label ) : ?>
                        <label class="amaley-bsk-token">
                            <span class="amaley-bsk-token__swatch" style="background: <?php echo esc_attr( $settings[ $key ] ); ?>"></span>
                            <span class="amaley-bsk-token__name"><?php echo esc_html( $label ); ?></span>
                            <input type="text" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $settings[ $key ] ); ?>" pattern="^#[0-9a-fA-F]{6}$" />
                        </label>
                    <?php endforeach; ?>
                </div>

                <h2><?php esc_html_e( 'Typography, Spacing and Shape', 'amaley-brand-site-kit' ); ?></h2>
                <div class="amaley-bsk-fields">
                    <?php
                    $text_fields = array(
                        'font_heading'            => 'Heading font stack',
                        'font_body'               => 'Body font stack',
                        'font_button'             => 'Button font stack',
                        'section_padding_desktop' => 'Section padding desktop',
                        'section_padding_tablet'  => 'Section padding tablet',
                        'section_padding_mobile'  => 'Section padding mobile',
                        'container_width'         => 'Container width',
                        'radius_card'             => 'Card radius',
                        'radius_small'            => 'Small radius',
                        'radius_pill'             => 'Pill radius',
                        'shadow_card'             => 'Card shadow',
                        'shadow_card_hover'       => 'Card hover shadow',
                    );
                    foreach ( $text_fields as $key => $label ) :
                        ?>
                        <label>
                            <span><?php echo esc_html( $label ); ?></span>
                            <input type="text" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $settings[ $key ] ); ?>" />
                        </label>
                    <?php endforeach; ?>
                </div>

                <h2><?php esc_html_e( 'Safe Bridges', 'amaley-brand-site-kit' ); ?></h2>
                <div class="amaley-bsk-switches">
                    <?php
                    $switches = array(
                        'enable_google_fonts'       => 'Load Playfair Display + Lato from Google Fonts',
                        'enable_global_bridge'      => 'Optional: enable frontend body-class bridge for background, text, headings and buttons',
                        'enable_woocommerce_bridge' => 'Optional: enable WooCommerce visual bridge for product cards, price, badges and buttons',
                        'enable_elementor_bridge'   => 'Optional: enable Elementor-friendly token bridge for Elementor buttons/widgets',
                    );
                    foreach ( $switches as $key => $label ) :
                        ?>
                        <label>
                            <input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="yes" <?php checked( 'yes', $settings[ $key ] ); ?> />
                            <span><?php echo esc_html( $label ); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <p class="submit">
                    <button type="submit" class="button button-primary"><?php esc_html_e( 'Save Amaley Brand Tokens', 'amaley-brand-site-kit' ); ?></button>
                </p>
            </form>

            <div class="amaley-site amaley-bsk-preview">
                <p class="am-kicker">Amaley preview</p>
                <h2>Pure Himalayan ingredients, curated with care.</h2>
                <p>This preview uses the same live tokens that are sent to the frontend.</p>
                <div class="am-card-grid">
                    <div class="am-card">
                        <span class="am-badge am-badge--women">Women collectives</span>
                        <h3>Small-batch product card</h3>
                        <p>Warm cream surface, sand border, soft shadow and bottom-aligned action.</p>
                        <a class="am-btn am-btn--primary" href="#">Explore products</a>
                    </div>
                    <div class="am-card">
                        <span class="am-badge am-badge--natural">Natural ingredients</span>
                        <h3>Origin-aware section</h3>
                        <p>Built for Amaley sections, product discovery and future controlled components.</p>
                        <a class="am-btn am-btn--secondary" href="#">View origin</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * CSS variables and controlled bridges.
     *
     * @param string $context frontend|admin.
     * @return string
     */
    private function build_css( $context = 'frontend' ) {
        $s = self::settings();

        $css = ':root{' .
            '--am-cacao:' . esc_html( $s['cacao'] ) . ';' .
            '--am-gold:' . esc_html( $s['gold'] ) . ';' .
            '--am-clay:' . esc_html( $s['clay'] ) . ';' .
            '--am-sage:' . esc_html( $s['sage'] ) . ';' .
            '--am-rose:' . esc_html( $s['rose'] ) . ';' .
            '--am-ivory:' . esc_html( $s['ivory'] ) . ';' .
            '--am-cream:' . esc_html( $s['cream'] ) . ';' .
            '--am-border-color:' . esc_html( $s['border'] ) . ';' .
            '--am-text:' . esc_html( $s['text'] ) . ';' .
            '--am-muted:' . esc_html( $s['muted'] ) . ';' .
            '--am-sage-wash:' . esc_html( $s['sage_wash'] ) . ';' .
            '--am-rose-wash:' . esc_html( $s['rose_wash'] ) . ';' .
            '--am-women-badge-bg:' . esc_html( $s['women_badge_bg'] ) . ';' .
            '--am-women-badge-text:' . esc_html( $s['women_badge_text'] ) . ';' .
            '--am-natural-badge-bg:' . esc_html( $s['natural_badge_bg'] ) . ';' .
            '--am-natural-badge-text:' . esc_html( $s['natural_badge_text'] ) . ';' .
            '--am-quality-badge-bg:' . esc_html( $s['quality_badge_bg'] ) . ';' .
            '--am-quality-badge-text:' . esc_html( $s['quality_badge_text'] ) . ';' .
            '--am-ingredient-badge-bg:' . esc_html( $s['ingredient_badge_bg'] ) . ';' .
            '--am-ingredient-badge-text:' . esc_html( $s['ingredient_badge_text'] ) . ';' .
            '--am-font-heading:' . esc_html( $s['font_heading'] ) . ';' .
            '--am-font-body:' . esc_html( $s['font_body'] ) . ';' .
            '--am-font-button:' . esc_html( $s['font_button'] ) . ';' .
            '--am-section-pad-desktop:' . esc_html( $s['section_padding_desktop'] ) . ';' .
            '--am-section-pad-tablet:' . esc_html( $s['section_padding_tablet'] ) . ';' .
            '--am-section-pad-mobile:' . esc_html( $s['section_padding_mobile'] ) . ';' .
            '--am-container:' . esc_html( $s['container_width'] ) . ';' .
            '--am-radius-card:' . esc_html( $s['radius_card'] ) . ';' .
            '--am-radius-small:' . esc_html( $s['radius_small'] ) . ';' .
            '--am-radius-pill:' . esc_html( $s['radius_pill'] ) . ';' .
            '--am-shadow-card:' . esc_html( $s['shadow_card'] ) . ';' .
            '--am-shadow-card-hover:' . esc_html( $s['shadow_card_hover'] ) . ';' .
            '--amaley-color-primary:' . esc_html( $s['cacao'] ) . ';' .
            '--amaley-color-accent:' . esc_html( $s['gold'] ) . ';' .
            '--amaley-color-text:' . esc_html( $s['text'] ) . ';' .
            '--amaley-color-background:' . esc_html( $s['ivory'] ) . ';' .
            '--amaley-color-card:' . esc_html( $s['cream'] ) . ';' .
            '}' . "\n";

        $css .= '.amaley-site{background:var(--am-ivory);color:var(--am-text);font-family:var(--am-font-body);}' .
            '.amaley-site *{box-sizing:border-box;}' .
            '.amaley-site :where(h1,h2,h3){color:var(--am-cacao);font-family:var(--am-font-heading);letter-spacing:-.02em;line-height:1.08;margin-top:0;}' .
            '.amaley-site :where(p,li){color:var(--am-text);line-height:1.7;}' .
            '.amaley-site .am-container{max-width:var(--am-container);margin-inline:auto;padding-inline:24px;}' .
            '.amaley-site .am-section{padding-block:var(--am-section-pad-desktop);}' .
            '.amaley-site .am-kicker{color:var(--am-gold);font-family:var(--am-font-button);font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;margin:0 0 10px;}' .
            '.amaley-site .am-card{background:var(--am-cream);border:1px solid var(--am-border-color);border-radius:var(--am-radius-card);box-shadow:var(--am-shadow-card);padding:28px;transition:box-shadow .2s ease,transform .2s ease;}' .
            '.amaley-site .am-card:hover{box-shadow:var(--am-shadow-card-hover);transform:translateY(-2px);}' .
            '.amaley-site .am-card-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:22px;}' .
            '.amaley-site .am-btn{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:14px 28px;border-radius:var(--am-radius-pill);font-family:var(--am-font-button);font-size:14px;font-weight:800;letter-spacing:.04em;text-decoration:none;line-height:1;border:1px solid transparent;transition:background-color .2s ease,color .2s ease,border-color .2s ease;}' .
            '.amaley-site .am-btn--primary{background:var(--am-cacao);border-color:var(--am-cacao);color:var(--am-ivory);}' .
            '.amaley-site .am-btn--primary:hover{background:var(--am-gold);border-color:var(--am-gold);color:var(--am-cacao);}' .
            '.amaley-site .am-btn--secondary{background:transparent;border-color:var(--am-cacao);color:var(--am-cacao);}' .
            '.amaley-site .am-btn--secondary:hover{background:var(--am-cacao);color:var(--am-ivory);}' .
            '.amaley-site .am-badge{display:inline-flex;align-items:center;gap:6px;min-height:28px;padding:6px 10px;border-radius:var(--am-radius-pill);font-family:var(--am-font-button);font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;line-height:1;}' .
            '.amaley-site .am-badge--women{background:var(--am-women-badge-bg);color:var(--am-women-badge-text);}' .
            '.amaley-site .am-badge--natural{background:var(--am-natural-badge-bg);color:var(--am-natural-badge-text);}' .
            '.amaley-site .am-badge--quality{background:var(--am-quality-badge-bg);color:var(--am-quality-badge-text);}' .
            '.amaley-site .am-badge--ingredient{background:var(--am-ingredient-badge-bg);color:var(--am-ingredient-badge-text);}' .
            '@media(max-width:1024px){.amaley-site .am-section{padding-block:var(--am-section-pad-tablet);}.amaley-site .am-container{padding-inline:22px;}}' .
            '@media(max-width:767px){.amaley-site .am-section{padding-block:var(--am-section-pad-mobile);}.amaley-site .am-container{padding-inline:18px;}.amaley-site .am-card-grid{grid-template-columns:1fr;gap:16px;}.amaley-site .am-card{padding:20px;border-radius:22px;}.amaley-site .am-btn{width:100%;padding-inline:18px;}}' . "\n";

        if ( 'yes' === $s['enable_global_bridge'] ) {
            $css .= 'body.amaley-brand-kit-enabled{background:var(--am-ivory);color:var(--am-text);font-family:var(--am-font-body);}' .
                'body.amaley-brand-kit-enabled :where(h1,h2,h3,h4,h5,h6){color:var(--am-cacao);font-family:var(--am-font-heading);}' .
                'body.amaley-brand-kit-enabled :where(p,li,label,input,textarea,select){font-family:var(--am-font-body);}' .
                'body.amaley-brand-kit-enabled :where(a){color:var(--am-cacao);}' .
                'body.amaley-brand-kit-enabled :where(a:hover){color:var(--am-gold);}' .
                'body.amaley-brand-kit-enabled :where(.button,.elementor-button,button,input[type="submit"]){border-radius:var(--am-radius-pill);font-family:var(--am-font-button);font-weight:800;}' . "\n";
        }

        if ( 'yes' === $s['enable_elementor_bridge'] ) {
            $css .= 'body.amaley-brand-kit-enabled .elementor-button{background-color:var(--am-cacao);color:var(--am-ivory);border:1px solid var(--am-cacao);min-height:46px;padding:14px 28px;}' .
                'body.amaley-brand-kit-enabled .elementor-button:hover{background-color:var(--am-gold);border-color:var(--am-gold);color:var(--am-cacao);}' .
                'body.amaley-brand-kit-enabled .elementor-heading-title{font-family:var(--am-font-heading);color:var(--am-cacao);}' . "\n";
        }

        if ( 'yes' === $s['enable_woocommerce_bridge'] ) {
            $css .= 'body.amaley-brand-kit-enabled .woocommerce ul.products{display:grid;gap:24px;}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products:before,body.amaley-brand-kit-enabled .woocommerce ul.products:after{display:none;}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products li.product{background:var(--am-cream);border:1px solid var(--am-border-color);border-radius:var(--am-radius-card);box-shadow:var(--am-shadow-card);padding:18px;display:flex;flex-direction:column;min-height:100%;transition:box-shadow .2s ease,transform .2s ease;}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products li.product:hover{box-shadow:var(--am-shadow-card-hover);transform:translateY(-2px);}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products li.product img{aspect-ratio:1/1;object-fit:contain;background:linear-gradient(145deg,var(--am-cream),var(--am-ivory));border-radius:18px;margin-bottom:14px;}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products li.product .woocommerce-loop-product__title{font-family:var(--am-font-heading);font-size:22px;line-height:1.18;color:var(--am-cacao);padding:0;margin:0 0 8px;}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products li.product .price{color:var(--am-clay);font-family:var(--am-font-body);font-size:16px;font-weight:800;margin-top:auto;margin-bottom:12px;}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products li.product .button{background:var(--am-cacao);color:var(--am-ivory);border:1px solid var(--am-cacao);border-radius:var(--am-radius-pill);width:100%;text-align:center;min-height:44px;display:inline-flex;align-items:center;justify-content:center;margin-top:auto;}' .
                'body.amaley-brand-kit-enabled .woocommerce ul.products li.product .button:hover{background:var(--am-gold);border-color:var(--am-gold);color:var(--am-cacao);}' .
                'body.amaley-brand-kit-enabled .woocommerce span.onsale{background:var(--am-quality-badge-bg);color:var(--am-quality-badge-text);border-radius:var(--am-radius-pill);font-weight:800;min-height:auto;line-height:1;padding:8px 10px;}' .
                'body.amaley-brand-kit-enabled .woocommerce-message,body.amaley-brand-kit-enabled .woocommerce-info{border-top-color:var(--am-gold);background:var(--am-cream);color:var(--am-text);}' . "\n";
        }

        return $css;
    }

    /**
     * Admin settings page styling.
     *
     * @return string
     */
    private function admin_css() {
        return '.amaley-bsk-admin{max-width:1180px;}' .
            '.amaley-bsk-admin h1,.amaley-bsk-admin h2{font-family:var(--am-font-heading);color:var(--am-cacao);}' .
            '.amaley-bsk-admin__intro{background:var(--am-cream);border:1px solid var(--am-border-color);border-radius:18px;padding:18px 20px;margin:18px 0;box-shadow:0 8px 24px rgba(46,18,3,.06);}' .
            '.amaley-bsk-token-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin:14px 0 26px;}' .
            '.amaley-bsk-token{background:#fff;border:1px solid var(--am-border-color);border-radius:14px;padding:12px;display:grid;grid-template-columns:34px 1fr;gap:8px 10px;align-items:center;}' .
            '.amaley-bsk-token__swatch{width:34px;height:34px;border-radius:10px;border:1px solid rgba(0,0,0,.08);grid-row:span 2;}' .
            '.amaley-bsk-token__name{font-weight:800;color:var(--am-cacao);}' .
            '.amaley-bsk-token input,.amaley-bsk-fields input{width:100%;border:1px solid var(--am-border-color);border-radius:10px;padding:8px 10px;}' .
            '.amaley-bsk-fields{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-bottom:26px;}' .
            '.amaley-bsk-fields label{background:#fff;border:1px solid var(--am-border-color);border-radius:14px;padding:12px;display:grid;gap:8px;}' .
            '.amaley-bsk-fields span{font-weight:800;color:var(--am-cacao);}' .
            '.amaley-bsk-switches{display:grid;gap:10px;background:#fff;border:1px solid var(--am-border-color);border-radius:14px;padding:16px;margin-bottom:20px;}' .
            '.amaley-bsk-switches label{display:flex;gap:10px;align-items:flex-start;font-weight:700;}' .
            '.amaley-bsk-sync-panel{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;margin:14px 0 28px;}' .
            '.amaley-bsk-sync-card{background:#fff;border:1px solid var(--am-border-color);border-radius:16px;padding:18px;box-shadow:0 8px 24px rgba(46,18,3,.05);}' .
            '.amaley-bsk-sync-card h3{margin-top:0;color:var(--am-cacao);}' .
            '.amaley-bsk-sync-card form{margin:12px 0 0;}' .
            '.amaley-bsk-inline-form{display:inline-block;margin-left:8px!important;}' .
            '.amaley-bsk-preview{padding:32px;margin:28px 0;background:var(--am-ivory);border:1px solid var(--am-border-color);border-radius:22px;}' .
            '@media(max-width:960px){.amaley-bsk-token-grid,.amaley-bsk-fields,.amaley-bsk-sync-panel{grid-template-columns:repeat(2,minmax(0,1fr));}}' .
            '@media(max-width:640px){.amaley-bsk-token-grid,.amaley-bsk-fields,.amaley-bsk-sync-panel{grid-template-columns:1fr;}.amaley-bsk-inline-form{display:block;margin-left:0!important;}}';
    }
}

register_activation_hook( __FILE__, array( 'Amaley_Brand_Site_Kit', 'activate' ) );
add_action( 'plugins_loaded', array( 'Amaley_Brand_Site_Kit', 'instance' ) );
