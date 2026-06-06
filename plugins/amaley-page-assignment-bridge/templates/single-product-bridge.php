<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$product_id = absint( get_queried_object_id() );
$product    = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : false;
$page_id    = Amaley_Page_Assignment_Bridge::instance()->get_single_product_template_page_id();

if ( ! $product || ! $page_id ) {
    // Fallback safety: let WordPress/WooCommerce continue if something is missing.
    include get_query_template( 'single' );
    return;
}

define( 'APAB_RENDERING_SINGLE_PRODUCT', true );
APAB_Product_Context::set_product_id( $product_id, 'single_product_url' );

get_header();

echo '<main id="primary" class="site-main apab-single-product-template" data-product-id="' . esc_attr( $product_id ) . '" data-page-id="' . esc_attr( $page_id ) . '">';

if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) ) {
    echo APAB_Product_Context::with_product_globals(
        $product,
        function() use ( $page_id ) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $page_id, true );
        }
    );
} else {
    $page = get_post( $page_id );
    if ( $page ) {
        echo APAB_Product_Context::with_product_globals(
            $product,
            function() use ( $page ) {
                echo apply_filters( 'the_content', $page->post_content );
            }
        );
    }
}

echo '</main>';

get_footer();
