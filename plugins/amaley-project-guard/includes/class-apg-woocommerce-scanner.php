<?php
/**
 * WooCommerce scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_WooCommerce_Scanner {

    /**
     * Scan basic WooCommerce status.
     *
     * @return array<string,mixed>
     */
    public function scan() {
        $active = class_exists( 'WooCommerce' ) || APG_Utils::is_plugin_active_safe( 'woocommerce/woocommerce.php' );
        $pages  = array();
        $issues = array();

        if ( $active && function_exists( 'wc_get_page_id' ) ) {
            $page_keys = array( 'shop', 'cart', 'checkout', 'myaccount' );
            foreach ( $page_keys as $key ) {
                $page_id = wc_get_page_id( $key );
                $pages[ $key ] = array(
                    'id'     => $page_id,
                    'title'  => $page_id > 0 ? get_the_title( $page_id ) : '',
                    'status' => $page_id > 0 ? get_post_status( $page_id ) : 'missing',
                );

                if ( in_array( $key, array( 'cart', 'checkout' ), true ) && $page_id <= 0 ) {
                    $issues[] = APG_Utils::issue(
                        'HIGH',
                        'WooCommerce',
                        ucfirst( $key ) . ' page is not assigned',
                        'WooCommerce → Settings → Advanced',
                        'Cart/checkout flow may break or confuse customers.',
                        'Assign the required WooCommerce page and retest cart/checkout.'
                    );
                }
            }
        }

        if ( ! $active ) {
            $issues[] = APG_Utils::issue(
                'INFO',
                'WooCommerce',
                'WooCommerce not detected',
                'Active plugins',
                'Commerce/product mapping checks are limited.',
                'Ignore if this environment is not intended to run WooCommerce.'
            );
        }

        return array(
            'active' => $active,
            'pages'  => $pages,
            'issues' => $issues,
        );
    }
}
