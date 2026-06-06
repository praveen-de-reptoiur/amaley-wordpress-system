<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

abstract class APAB_Widget_Base extends \Elementor\Widget_Base {

    public function get_categories() {
        return array( 'amaley-bridge' );
    }

    public function get_style_depends() {
        return array( 'apab-single-product' );
    }

    public function get_script_depends() {
        return array( 'apab-single-product' );
    }

    protected function current_product() {
        return APAB_Product_Context::get_product();
    }

    protected function editor_notice() {
        if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            echo '<div class="apab-editor-note">Amaley Bridge: select a Preview Product in Amaley Bridge settings to style this widget with real WooCommerce product data.</div>';
        }
    }

    protected function field_text( $field_name, $product_id ) {
        return APAB_Product_Context::text_value( APAB_Product_Context::acf_or_meta( $field_name, $product_id ) );
    }

    protected function field_raw( $field_name, $product_id ) {
        return APAB_Product_Context::acf_or_meta( $field_name, $product_id );
    }

    protected function post_object_link( $value ) {
        return APAB_Product_Context::post_object_link_html( $value );
    }

    protected function post_object_title( $value ) {
        return APAB_Product_Context::post_object_title( $value );
    }

    protected function icon_initials( $label ) {
        $label = trim( wp_strip_all_tags( (string) $label ) );
        if ( '' === $label ) {
            return 'AM';
        }
        $words = preg_split( '/\s+/', $label );
        if ( count( $words ) >= 2 ) {
            return strtoupper( substr( $words[0], 0, 1 ) . substr( $words[1], 0, 1 ) );
        }
        return strtoupper( substr( $label, 0, 2 ) );
    }

    protected function render_origin_icon( $value, $label = '' ) {
        $post_id = APAB_Product_Context::post_object_id( $value );
        if ( $post_id && has_post_thumbnail( $post_id ) ) {
            $thumb = get_the_post_thumbnail(
                $post_id,
                'thumbnail',
                array(
                    'class'   => 'apab-origin-icon-img',
                    'loading' => 'lazy',
                    'alt'     => esc_attr( get_the_title( $post_id ) ),
                )
            );
            if ( $thumb ) {
                return '<span class="apab-origin-icon apab-origin-icon--image" aria-hidden="true">' . $thumb . '</span>';
            }
        }

        return '<span class="apab-origin-icon apab-origin-icon--initials" aria-hidden="true">' . esc_html( $this->icon_initials( $label ) ) . '</span>';
    }
}
