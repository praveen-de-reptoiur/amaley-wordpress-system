<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Templates_Settings {

    public static function defaults() {
        return array(
            'meta' => array(
                'installed_version' => AMALEY_TPL_VERSION,
                'updated_at'        => current_time( 'mysql' ),
            ),
            'global' => array(
                'primary_color' => '#2E1203',
                'gold_color'    => '#C2880A',
                'rust_color'    => '#B5502A',
                'ivory_color'   => '#F7EFE2',
                'cream_color'   => '#FFF8EA',
                'heading_font'  => 'Playfair Display',
                'body_font'     => 'Lato',
                'radius'        => '0',
                'compact_mode'  => 'yes',
            ),
            'single_product' => array(
                'module_enabled'       => 'yes',
                'preset'               => 'single_product_og_compact_v1',
                'hero_layout'          => 'compact_two_column',
                'buy_now_enabled'      => 'yes',
                'buy_now_text'         => 'Buy Now',
                'wishlist_enabled'     => 'yes',
                'wishlist_text'        => '♡',
                'details_label'        => 'Details',
                'origin_label'         => 'Origin',
                'how_to_use_label'     => 'How to Use',
                'reviews_label'        => 'Reviews',
                'trust_items'          => 'Small Batch|Made with limited seasonal capacity
Traceable Origin|Cluster · SHG · Producer
Carefully Packed|Packed for safe delivery',
                'origin_short_line'    => 'origin_short_line',
                'linked_cluster'       => 'linked_cluster',
                'linked_shg_group'     => 'linked_shg_group',
                'linked_producer_maker'=> 'linked_producer_maker',
                'village_source_location' => 'village_source_location',
                'region_source_belt'   => 'region_source_belt',
                'batch_type'           => 'batch_type',
                'harvest_collection_season' => 'harvest_collection_season',
                'processing_method'    => 'processing_method',
                'traceability_note'    => 'traceability_note',
                'ingredients_note'     => 'ingredients_note',
                'how_to_use'           => 'how_to_use',
                'storage_instructions' => 'storage_instructions',
                'shelf_life'           => 'shelf_life',
                'allergen_note'        => 'allergen_note',
                'producer_quote_maker_note' => 'producer_quote_maker_note',
            ),
            'shop_page' => array(
                'module_enabled'          => 'yes',
                'preset'                  => 'shop_page_og_filter_v1',
                'hero_kicker'             => 'Shop Amaley',
                'hero_title'              => 'Himalayan Pantry',
                'hero_accent'             => 'Collections',
                'hero_text'               => 'Explore small-batch Himalayan foods, teas, preserves and seasonal products linked with Amaley’s village and producer network.',
                'hero_pills'              => 'Small Batch|Traceable Origin|Natural Himalayan Foods',
                'discovery_heading'       => 'Shop Amaley',
                'discovery_kicker'        => 'Filter by origin, ingredient and use',
                'per_page'                => 12,
                'columns_desktop'         => 3,
                'columns_tablet'          => 2,
                'columns_mobile'          => 1,
                'desktop_filter_position' => 'left',
                'tablet_filter_position'  => 'top',
                'mobile_filter_position'  => 'top',
                'desktop_filter_mode'     => 'visible',
                'tablet_filter_mode'      => 'compact',
                'mobile_filter_mode'      => 'compact',
                'show_search'             => 'yes',
                'show_categories'         => 'yes',
                'show_price'              => 'yes',
                'show_tags'               => 'yes',
                'show_stock'              => 'yes',
                'show_sort'               => 'yes',
                'show_active_chips'       => 'yes',
                'show_attr_collection_type' => 'yes',
                'show_attr_core_ingredient' => 'yes',
                'show_attr_cluster'       => 'yes',
                'show_attr_producer_maker'=> 'yes',
                'show_attr_region_cluster'=> 'yes',
                'show_attr_shg'           => 'yes',
                'show_attr_use_case'      => 'yes',
                'show_attr_village_source_location' => 'yes',
                'pagination_type'         => 'numbers',
                'card_renderer'           => 'elementor_template',
                'elementor_template_id'   => 0,
                'custom_wrapper_class'    => 'amaley-tpl-shop-og',
                'notes'                   => 'Shop page uses Amaley Discovery Engine for filters/query/pagination and may render the existing OG Amaley Product Card Loop through Elementor Template ID.',
            ),
            'quick_view' => array(
                'module_enabled' => 'planned',
                'notes'          => 'Reserved for future Quick View / Popup widgets. Must not replace WooCommerce cart or checkout.',
            ),
            'debug' => array(
                'debug_mode'         => 'yes',
                'show_admin_notices' => 'yes',
                'keep_event_count'   => 30,
            ),
        );
    }

    public static function get_settings() {
        $saved = get_option( AMALEY_TPL_OPTION, array() );
        if ( ! is_array( $saved ) ) {
            $saved = array();
        }
        return self::recursive_merge( self::defaults(), $saved );
    }

    public static function update_settings( $settings ) {
        $settings = self::sanitize_settings( $settings );
        $settings = self::recursive_merge( self::defaults(), $settings );
        $settings['meta']['updated_at'] = current_time( 'mysql' );
        return update_option( AMALEY_TPL_OPTION, $settings, false );
    }

    public static function get( $path, $default = '' ) {
        $settings = self::get_settings();
        $parts    = explode( '.', (string) $path );
        $current  = $settings;
        foreach ( $parts as $part ) {
            if ( is_array( $current ) && array_key_exists( $part, $current ) ) {
                $current = $current[ $part ];
            } else {
                return $default;
            }
        }
        return $current;
    }

    public static function recursive_merge( $defaults, $saved ) {
        foreach ( $saved as $key => $value ) {
            if ( is_array( $value ) && isset( $defaults[ $key ] ) && is_array( $defaults[ $key ] ) ) {
                $defaults[ $key ] = self::recursive_merge( $defaults[ $key ], $value );
            } else {
                $defaults[ $key ] = $value;
            }
        }
        return $defaults;
    }

    public static function sanitize_settings( $settings ) {
        if ( ! is_array( $settings ) ) {
            return self::defaults();
        }

        $clean = array();
        foreach ( $settings as $key => $value ) {
            $safe_key = sanitize_key( $key );
            if ( is_array( $value ) ) {
                $clean[ $safe_key ] = self::sanitize_settings( $value );
            } else {
                $clean[ $safe_key ] = is_string( $value ) ? wp_kses_post( wp_unslash( $value ) ) : $value;
            }
        }
        return $clean;
    }

    public static function make_package( $scope = 'full' ) {
        $settings = self::get_settings();
        $scope    = sanitize_key( $scope );

        if ( 'full' !== $scope && isset( $settings[ $scope ] ) ) {
            $export_settings = array( $scope => $settings[ $scope ] );
        } else {
            $export_settings = $settings;
            $scope           = 'full';
        }

        return array(
            'schema'      => 'amaley_templates_package_v1',
            'plugin'      => 'Amaley Templates',
            'author'      => 'Praveen',
            'version'     => AMALEY_TPL_VERSION,
            'scope'       => $scope,
            'exported_at' => current_time( 'mysql' ),
            'environment' => self::environment_summary(),
            'settings'    => $export_settings,
            'notes'       => array(
                'safe_import' => 'Use Merge for normal updates. Use Replace only for a selected module after exporting/backup.',
                'commerce'    => 'WooCommerce remains the source for products, price, variations, stock, cart, checkout and reviews.',
                'safety'      => 'No global CSS/JS, no WooCommerce template overrides, no Freshen/Apus overrides, no duplicate CPT registration.',
            ),
        );
    }

    public static function create_backup( $reason = 'manual' ) {
        $backups = get_option( AMALEY_TPL_BACKUPS_OPTION, array() );
        if ( ! is_array( $backups ) ) {
            $backups = array();
        }

        array_unshift( $backups, array(
            'created_at' => current_time( 'mysql' ),
            'reason'     => sanitize_text_field( $reason ),
            'package'    => self::make_package( 'full' ),
        ) );

        $backups = array_slice( $backups, 0, 8 );
        update_option( AMALEY_TPL_BACKUPS_OPTION, $backups, false );
        self::log_event( 'Backup created: ' . $reason, 'backup' );
        return $backups[0];
    }

    public static function get_backups() {
        $backups = get_option( AMALEY_TPL_BACKUPS_OPTION, array() );
        return is_array( $backups ) ? $backups : array();
    }

    public static function import_package( $package, $mode = 'merge', $scope = 'full' ) {
        if ( ! is_array( $package ) || empty( $package['settings'] ) || empty( $package['schema'] ) || 'amaley_templates_package_v1' !== $package['schema'] ) {
            return new WP_Error( 'invalid_package', 'Invalid Amaley Templates import package.' );
        }

        self::create_backup( 'before_import_' . sanitize_key( $mode ) );

        $current  = self::get_settings();
        $incoming = self::sanitize_settings( $package['settings'] );
        $mode     = 'replace' === $mode ? 'replace' : 'merge';
        $scope    = sanitize_key( $scope );

        if ( 'full' !== $scope && isset( $incoming[ $scope ] ) ) {
            if ( 'replace' === $mode ) {
                $current[ $scope ] = $incoming[ $scope ];
            } else {
                $current[ $scope ] = self::recursive_merge( isset( $current[ $scope ] ) ? $current[ $scope ] : array(), $incoming[ $scope ] );
            }
        } else {
            if ( 'replace' === $mode ) {
                $current = self::recursive_merge( self::defaults(), $incoming );
            } else {
                $current = self::recursive_merge( $current, $incoming );
            }
        }

        self::update_settings( $current );
        self::log_event( 'Import completed using ' . $mode . ' mode for scope ' . $scope, 'import' );
        return true;
    }

    public static function rollback( $index ) {
        $backups = self::get_backups();
        $index   = absint( $index );

        if ( ! isset( $backups[ $index ]['package']['settings'] ) ) {
            return new WP_Error( 'missing_backup', 'Selected rollback backup was not found.' );
        }

        self::create_backup( 'before_rollback' );
        self::update_settings( $backups[ $index ]['package']['settings'] );
        self::log_event( 'Rollback restored backup from ' . $backups[ $index ]['created_at'], 'rollback' );
        return true;
    }

    public static function log_event( $message, $type = 'info' ) {
        $settings = self::get_settings();
        $limit    = isset( $settings['debug']['keep_event_count'] ) ? absint( $settings['debug']['keep_event_count'] ) : 30;
        $limit    = $limit > 0 ? $limit : 30;

        $events = get_option( AMALEY_TPL_EVENTS_OPTION, array() );
        if ( ! is_array( $events ) ) {
            $events = array();
        }

        array_unshift( $events, array(
            'time'    => current_time( 'mysql' ),
            'type'    => sanitize_key( $type ),
            'message' => sanitize_text_field( $message ),
        ) );

        update_option( AMALEY_TPL_EVENTS_OPTION, array_slice( $events, 0, $limit ), false );
    }

    public static function get_events() {
        $events = get_option( AMALEY_TPL_EVENTS_OPTION, array() );
        return is_array( $events ) ? $events : array();
    }

    public static function environment_summary() {
        global $wp_version;
        $theme = wp_get_theme();

        return array(
            'php'               => PHP_VERSION,
            'wordpress'         => isset( $wp_version ) ? $wp_version : '',
            'theme'             => $theme ? $theme->get( 'Name' ) . ' ' . $theme->get( 'Version' ) : '',
            'elementor_loaded'  => did_action( 'elementor/loaded' ) ? 'yes' : 'no',
            'elementor_version' => defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '',
            'elementor_pro'     => defined( 'ELEMENTOR_PRO_VERSION' ) ? ELEMENTOR_PRO_VERSION : '',
            'woocommerce'       => defined( 'WC_VERSION' ) ? WC_VERSION : '',
            'acf'               => defined( 'ACF_VERSION' ) ? ACF_VERSION : '',
            'discovery_engine'  => defined( 'AMALEY_DISCOVERY_ENGINE_VERSION' ) ? AMALEY_DISCOVERY_ENGINE_VERSION : self::plugin_version_by_folder( 'amaley-discovery-engine/amaley-discovery-engine.php' ),
            'templates_version' => AMALEY_TPL_VERSION,
        );
    }

    public static function plugin_version_by_folder( $plugin_file ) {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $plugins = get_plugins();
        if ( isset( $plugins[ $plugin_file ]['Version'] ) ) {
            return $plugins[ $plugin_file ]['Version'];
        }
        return '';
    }

    public static function health_checks() {
        $env = self::environment_summary();
        $checks = array();

        $checks[] = array(
            'label'  => 'PHP Version',
            'status' => version_compare( PHP_VERSION, '7.4', '>=' ) ? 'ok' : 'warning',
            'detail' => 'Current: ' . PHP_VERSION . '. Recommended: 7.4 or higher.',
        );

        $checks[] = array(
            'label'  => 'Elementor',
            'status' => did_action( 'elementor/loaded' ) ? 'ok' : 'error',
            'detail' => did_action( 'elementor/loaded' ) ? 'Loaded: ' . $env['elementor_version'] : 'Not loaded. Elementor widgets will not be available.',
        );

        $checks[] = array(
            'label'  => 'WooCommerce',
            'status' => function_exists( 'wc_get_product' ) ? 'ok' : 'error',
            'detail' => function_exists( 'wc_get_product' ) ? 'Loaded: ' . $env['woocommerce'] : 'Not loaded. Product data/cart/checkout are not available.',
        );

        $checks[] = array(
            'label'  => 'ACF',
            'status' => function_exists( 'get_field' ) ? 'ok' : 'warning',
            'detail' => function_exists( 'get_field' ) ? 'Loaded: ' . $env['acf'] : 'ACF not detected. Plugin will fall back to post meta, but origin fields may not show.',
        );

        $checks[] = array(
            'label'  => 'Amaley Discovery Engine',
            'status' => ! empty( $env['discovery_engine'] ) ? 'ok' : 'info',
            'detail' => ! empty( $env['discovery_engine'] ) ? 'Detected: ' . $env['discovery_engine'] . '. No shared class prefixes are used.' : 'Not detected. Amaley Templates can still run independently.',
        );

        $checks[] = array(
            'label'  => 'Template Safety',
            'status' => 'ok',
            'detail' => 'No WooCommerce template override, no CPT registration, no Freshen/Apus global class override.',
        );

        return $checks;
    }
}

function amaley_tpl_setting( $path, $default = '' ) {
    return Amaley_Templates_Settings::get( $path, $default );
}
