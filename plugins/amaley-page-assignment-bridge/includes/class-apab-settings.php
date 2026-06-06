<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class APAB_Settings {

    public static function defaults() {
        return array(
            'meta' => array(
                'installed_version' => APAB_VERSION,
                'updated_at'        => current_time( 'mysql' ),
            ),
            'single_product' => array(
                'enabled'               => 'off',
                'assigned_page_id'      => 0,
                'test_product_id'       => 0,
                'preview_assigned_page' => 'yes',
                'preview_product_id'    => 0,
                'notes'                 => 'v1.3.4 bridge: Product Hero controls upgrade with show/hide, layout, alignment, style and responsive spacing. Other widgets unchanged.',
            ),
            'debug' => array(
                'debug_mode' => 'yes',
            ),
        );
    }

    public static function get_settings() {
        $saved = get_option( APAB_OPTION, array() );
        if ( ! is_array( $saved ) ) {
            $saved = array();
        }
        return self::recursive_merge( self::defaults(), $saved );
    }

    public static function update_settings( $settings ) {
        $settings = self::sanitize_settings( $settings );
        $settings = self::recursive_merge( self::defaults(), $settings );
        $settings['meta']['installed_version'] = APAB_VERSION;
        $settings['meta']['updated_at']        = current_time( 'mysql' );
        return update_option( APAB_OPTION, $settings, false );
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

    public static function health_checks() {
        $settings = self::get_settings();
        $checks   = array();

        $checks[] = array(
            'label'  => 'Plugin version',
            'status' => 'ok',
            'detail' => 'Amaley Page Assignment Bridge v' . APAB_VERSION,
        );
        $checks[] = array(
            'label'  => 'WooCommerce',
            'status' => function_exists( 'wc_get_product' ) ? 'ok' : 'error',
            'detail' => function_exists( 'wc_get_product' ) ? 'WooCommerce product functions are available.' : 'WooCommerce is missing/inactive.',
        );
        $checks[] = array(
            'label'  => 'Elementor',
            'status' => did_action( 'elementor/loaded' ) ? 'ok' : 'warning',
            'detail' => did_action( 'elementor/loaded' ) ? 'Elementor is loaded.' : 'Elementor is not loaded; widgets/page assignment cannot render.',
        );

        $page_id = ! empty( $settings['single_product']['assigned_page_id'] ) ? absint( $settings['single_product']['assigned_page_id'] ) : 0;
        $checks[] = array(
            'label'  => 'Assigned page',
            'status' => $page_id && get_post( $page_id ) ? 'ok' : 'warning',
            'detail' => $page_id && get_post( $page_id ) ? 'Assigned page exists: #' . $page_id : 'No assigned page selected yet.',
        );

        $mode = isset( $settings['single_product']['enabled'] ) ? $settings['single_product']['enabled'] : 'off';
        $checks[] = array(
            'label'  => 'Bridge mode',
            'status' => 'off' === $mode ? 'warning' : 'ok',
            'detail' => 'Current mode: ' . $mode,
        );

        return $checks;
    }
}
