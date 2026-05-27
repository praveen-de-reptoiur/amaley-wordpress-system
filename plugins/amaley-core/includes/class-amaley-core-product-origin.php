<?php
/**
 * WooCommerce product origin mapping.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Product_Origin {
    /**
     * Field registry.
     *
     * @var Amaley_Core_Fields
     */
    private $fields;

    /**
     * Constructor.
     *
     * @param Amaley_Core_Fields $fields Field registry.
     */
    public function __construct( $fields ) {
        $this->fields = $fields;

        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post_product', array( $this, 'save_product_origin' ), 10, 2 );
    }

    /**
     * Add product origin metabox.
     *
     * @return void
     */
    public function add_meta_box() {
        if ( ! post_type_exists( 'product' ) ) {
            return;
        }

        add_meta_box(
            'amaley_product_origin',
            'Amaley Origin Mapping',
            array( $this, 'render_meta_box' ),
            'product',
            'normal',
            'high'
        );
    }

    /**
     * Render metabox.
     *
     * @param WP_Post $post Product post.
     * @return void
     */
    public function render_meta_box( $post ) {
        wp_nonce_field( 'amaley_core_save_product_origin', 'amaley_core_product_origin_nonce' );

        $fields = $this->fields->get_product_origin_fields();

        echo '<div class="amaley-core-metabox amaley-core-product-origin">';
        echo '<section class="amaley-core-field-section">';
        echo '<h3>Origin Relationship</h3>';
        echo '<p class="description">Connect this WooCommerce product to Amaley Cluster, SHG Group and optional Member / Producer records.</p>';

        foreach ( $fields as $meta_key => $field ) {
            $value = get_post_meta( $post->ID, $meta_key, true );
            if ( '' === $value && isset( $field['default'] ) ) {
                $value = $field['default'];
            }
            $this->render_field( $meta_key, $field, $value );
        }

        echo '</section>';
        echo '</div>';
    }

    /**
     * Render product field.
     *
     * @param string $meta_key Meta key.
     * @param array  $field Field definition.
     * @param mixed  $value Current value.
     * @return void
     */
    private function render_field( $meta_key, $field, $value ) {
        $type  = isset( $field['type'] ) ? $field['type'] : 'text';
        $label = isset( $field['label'] ) ? $field['label'] : $meta_key;
        $name  = 'amaley_product_origin[' . esc_attr( $meta_key ) . ']';

        echo '<div class="amaley-core-field amaley-core-field-' . esc_attr( $type ) . '">';
        echo '<label for="' . esc_attr( $meta_key ) . '">' . esc_html( $label ) . '</label>';

        switch ( $type ) {
            case 'relation_cluster':
                $this->render_post_select( $meta_key, $name, $value, 'amaley_cluster', 'Select Cluster', false );
                break;

            case 'relation_shg_multi':
                $this->render_post_select( $meta_key, $name . '[]', (array) $value, 'amaley_shg_group', 'Select SHG Groups', true );
                break;

            case 'relation_member_multi':
                $this->render_post_select( $meta_key, $name . '[]', (array) $value, 'amaley_member', 'Select Members / Producers', true );
                break;

            case 'textarea':
                $rows = isset( $field['rows'] ) ? absint( $field['rows'] ) : 3;
                echo '<textarea id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" rows="' . esc_attr( $rows ) . '">' . esc_textarea( $value ) . '</textarea>';
                break;

            case 'checkbox':
                echo '<label class="amaley-core-inline-check"><input type="checkbox" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( $value, '1', false ) . ' /> Yes</label>';
                break;

            case 'text':
            default:
                echo '<input type="text" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
                break;
        }

        echo '</div>';
    }

    /**
     * Render post select.
     *
     * @param string       $field_id Field ID.
     * @param string       $name Field name.
     * @param string|array $value Current value.
     * @param string       $post_type Post type.
     * @param string       $placeholder Placeholder.
     * @param bool         $multiple Multiple select.
     * @return void
     */
    private function render_post_select( $field_id, $name, $value, $post_type, $placeholder, $multiple ) {
        $posts = get_posts(
            array(
                'post_type'      => $post_type,
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => 500,
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );

        $selected_values = is_array( $value ) ? array_map( 'strval', $value ) : array( (string) $value );
        $multiple_attr   = $multiple ? ' multiple size="6"' : '';

        echo '<select id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name ) . '"' . $multiple_attr . '>';
        if ( ! $multiple ) {
            echo '<option value="">' . esc_html( $placeholder ) . '</option>';
        }
        foreach ( $posts as $item ) {
            echo '<option value="' . esc_attr( $item->ID ) . '" ' . selected( in_array( (string) $item->ID, $selected_values, true ), true, false ) . '>' . esc_html( get_the_title( $item ) ) . '</option>';
        }
        echo '</select>';

        if ( $multiple ) {
            echo '<p class="description">Hold Ctrl/Cmd to select multiple records.</p>';
        }
    }

    /**
     * Save product origin mapping.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post Post.
     * @return void
     */
    public function save_product_origin( $post_id, $post ) {
        if ( ! isset( $_POST['amaley_core_product_origin_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amaley_core_product_origin_nonce'] ) ), 'amaley_core_save_product_origin' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $posted = isset( $_POST['amaley_product_origin'] ) && is_array( $_POST['amaley_product_origin'] ) ? wp_unslash( $_POST['amaley_product_origin'] ) : array();
        $fields = $this->fields->get_product_origin_fields();

        foreach ( $fields as $meta_key => $field ) {
            $type = isset( $field['type'] ) ? $field['type'] : 'text';

            if ( 'checkbox' === $type ) {
                $value = isset( $posted[ $meta_key ] ) ? '1' : '0';
            } elseif ( in_array( $type, array( 'relation_shg_multi', 'relation_member_multi' ), true ) ) {
                $value = isset( $posted[ $meta_key ] ) && is_array( $posted[ $meta_key ] ) ? array_values( array_filter( array_map( 'absint', $posted[ $meta_key ] ) ) ) : array();
            } elseif ( 'relation_cluster' === $type ) {
                $value = isset( $posted[ $meta_key ] ) ? absint( $posted[ $meta_key ] ) : 0;
            } elseif ( 'textarea' === $type ) {
                $value = isset( $posted[ $meta_key ] ) ? sanitize_textarea_field( $posted[ $meta_key ] ) : '';
            } else {
                $value = isset( $posted[ $meta_key ] ) ? sanitize_text_field( $posted[ $meta_key ] ) : '';
            }

            update_post_meta( $post_id, $meta_key, $value );
        }
    }
}
