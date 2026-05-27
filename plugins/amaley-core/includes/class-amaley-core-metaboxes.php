<?php
/**
 * CPT metaboxes.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Metaboxes {
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

        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post_amaley_cluster', array( $this, 'save_cluster' ), 10, 2 );
        add_action( 'save_post_amaley_shg_group', array( $this, 'save_shg' ), 10, 2 );
        add_action( 'save_post_amaley_member', array( $this, 'save_member' ), 10, 2 );
    }

    /**
     * Add metaboxes.
     *
     * @return void
     */
    public function add_meta_boxes() {
        add_meta_box( 'amaley_cluster_details', 'Amaley Cluster Details', array( $this, 'render_cluster_box' ), 'amaley_cluster', 'normal', 'high' );
        add_meta_box( 'amaley_shg_details', 'Amaley SHG Group Details', array( $this, 'render_shg_box' ), 'amaley_shg_group', 'normal', 'high' );
        add_meta_box( 'amaley_member_details', 'Amaley Member / Producer Details', array( $this, 'render_member_box' ), 'amaley_member', 'normal', 'high' );
    }

    /**
     * Render cluster metabox.
     *
     * @param WP_Post $post Post.
     * @return void
     */
    public function render_cluster_box( $post ) {
        $this->render_fields( $post, 'cluster' );
    }

    /**
     * Render SHG metabox.
     *
     * @param WP_Post $post Post.
     * @return void
     */
    public function render_shg_box( $post ) {
        $this->render_fields( $post, 'shg' );
    }

    /**
     * Render member metabox.
     *
     * @param WP_Post $post Post.
     * @return void
     */
    public function render_member_box( $post ) {
        $this->render_fields( $post, 'member' );
    }

    /**
     * Render a field group set.
     *
     * @param WP_Post $post Post.
     * @param string  $entity Entity.
     * @return void
     */
    private function render_fields( $post, $entity ) {
        wp_nonce_field( 'amaley_core_save_' . $entity, 'amaley_core_' . $entity . '_nonce' );

        $groups = $this->fields->get_fields( $entity );
        echo '<div class="amaley-core-metabox">';

        foreach ( $groups as $group_key => $group ) {
            echo '<section class="amaley-core-field-section">';
            echo '<h3>' . esc_html( $group['label'] ) . '</h3>';

            foreach ( $group['fields'] as $meta_key => $field ) {
                $value = get_post_meta( $post->ID, $meta_key, true );
                if ( '' === $value && isset( $field['default'] ) ) {
                    $value = $field['default'];
                }
                $this->render_field( $post->ID, $meta_key, $field, $value );
            }

            echo '</section>';
        }

        echo '</div>';
    }

    /**
     * Render a single field.
     *
     * @param int    $post_id Post ID.
     * @param string $meta_key Meta key.
     * @param array  $field Field definition.
     * @param mixed  $value Current value.
     * @return void
     */
    private function render_field( $post_id, $meta_key, $field, $value ) {
        $type        = isset( $field['type'] ) ? $field['type'] : 'text';
        $label       = isset( $field['label'] ) ? $field['label'] : $meta_key;
        $description = isset( $field['description'] ) ? $field['description'] : '';
        $required    = ! empty( $field['required'] ) ? ' <span class="amaley-core-required">*</span>' : '';
        $name        = 'amaley_core_meta[' . esc_attr( $meta_key ) . ']';

        echo '<div class="amaley-core-field amaley-core-field-' . esc_attr( $type ) . '">';
        echo '<label for="' . esc_attr( $meta_key ) . '">' . esc_html( $label ) . wp_kses_post( $required ) . '</label>';

        switch ( $type ) {
            case 'textarea':
                $rows = isset( $field['rows'] ) ? absint( $field['rows'] ) : 3;
                echo '<textarea id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" rows="' . esc_attr( $rows ) . '" placeholder="' . esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ) . '">' . esc_textarea( $value ) . '</textarea>';
                break;

            case 'number':
                echo '<input type="number" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
                break;

            case 'select':
                echo '<select id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '">';
                foreach ( $field['options'] as $option_value => $option_label ) {
                    echo '<option value="' . esc_attr( $option_value ) . '" ' . selected( $value, $option_value, false ) . '>' . esc_html( $option_label ) . '</option>';
                }
                echo '</select>';
                break;

            case 'checkbox':
                echo '<label class="amaley-core-inline-check"><input type="checkbox" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( $value, '1', false ) . ' /> Yes</label>';
                break;

            case 'relation_cluster':
                $this->render_post_select( $meta_key, $name, $value, 'amaley_cluster', 'Select Cluster' );
                break;

            case 'relation_shg':
                $this->render_post_select( $meta_key, $name, $value, 'amaley_shg_group', 'Select SHG Group' );
                break;

            case 'readonly':
                echo '<input type="text" id="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $value ) . '" readonly />';
                echo '<input type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
                break;

            case 'text':
            default:
                echo '<input type="text" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ) . '" />';
                break;
        }

        if ( $description ) {
            echo '<p class="description">' . esc_html( $description ) . '</p>';
        }

        echo '</div>';
    }

    /**
     * Render post select field.
     *
     * @param string $meta_key Meta key.
     * @param string $name Field name.
     * @param mixed  $value Current value.
     * @param string $post_type Post type.
     * @param string $placeholder Placeholder.
     * @return void
     */
    private function render_post_select( $meta_key, $name, $value, $post_type, $placeholder ) {
        $posts = get_posts(
            array(
                'post_type'      => $post_type,
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => 500,
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );

        echo '<select id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '">';
        echo '<option value="">' . esc_html( $placeholder ) . '</option>';
        foreach ( $posts as $item ) {
            echo '<option value="' . esc_attr( $item->ID ) . '" ' . selected( (string) $value, (string) $item->ID, false ) . '>' . esc_html( get_the_title( $item ) ) . '</option>';
        }
        echo '</select>';
    }

    /**
     * Save cluster fields.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post Post.
     * @return void
     */
    public function save_cluster( $post_id, $post ) {
        $this->save_entity( $post_id, 'cluster' );
    }

    /**
     * Save SHG fields.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post Post.
     * @return void
     */
    public function save_shg( $post_id, $post ) {
        $this->save_entity( $post_id, 'shg' );
        $cluster_id = absint( get_post_meta( $post_id, '_amaley_shg_cluster_id', true ) );
        if ( $cluster_id ) {
            update_post_meta( $post_id, '_amaley_shg_cluster_code', get_post_meta( $cluster_id, '_amaley_cluster_code', true ) );
        }
    }

    /**
     * Save member fields.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post Post.
     * @return void
     */
    public function save_member( $post_id, $post ) {
        $this->save_entity( $post_id, 'member' );
        $shg_id = absint( get_post_meta( $post_id, '_amaley_member_shg_id', true ) );
        if ( $shg_id ) {
            update_post_meta( $post_id, '_amaley_member_shg_code', get_post_meta( $shg_id, '_amaley_shg_code', true ) );
        }
    }

    /**
     * Save entity metadata.
     *
     * @param int    $post_id Post ID.
     * @param string $entity Entity.
     * @return void
     */
    private function save_entity( $post_id, $entity ) {
        if ( ! isset( $_POST[ 'amaley_core_' . $entity . '_nonce' ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ 'amaley_core_' . $entity . '_nonce' ] ) ), 'amaley_core_save_' . $entity ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $posted = isset( $_POST['amaley_core_meta'] ) && is_array( $_POST['amaley_core_meta'] ) ? wp_unslash( $_POST['amaley_core_meta'] ) : array();
        $groups = $this->fields->get_fields( $entity );

        foreach ( $groups as $group ) {
            foreach ( $group['fields'] as $meta_key => $field ) {
                $type = isset( $field['type'] ) ? $field['type'] : 'text';
                if ( 'readonly' === $type ) {
                    continue;
                }

                if ( 'checkbox' === $type ) {
                    $value = isset( $posted[ $meta_key ] ) ? '1' : '0';
                } else {
                    $value = isset( $posted[ $meta_key ] ) ? $this->sanitize_value( $posted[ $meta_key ], $type ) : '';
                }

                update_post_meta( $post_id, $meta_key, $value );
            }
        }
    }

    /**
     * Sanitize field value by type.
     *
     * @param mixed  $value Value.
     * @param string $type Field type.
     * @return mixed
     */
    private function sanitize_value( $value, $type ) {
        if ( 'textarea' === $type ) {
            return sanitize_textarea_field( $value );
        }

        if ( 'number' === $type || false !== strpos( $type, 'relation_' ) ) {
            return absint( $value );
        }

        return sanitize_text_field( $value );
    }
}
