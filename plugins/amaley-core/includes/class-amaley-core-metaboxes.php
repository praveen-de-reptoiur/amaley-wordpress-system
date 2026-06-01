<?php
/** CPT metaboxes. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Metaboxes {
    private $fields;
    public function __construct( $fields ) {
        $this->fields = $fields;
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post_amaley_cluster', array( $this, 'save_cluster' ), 10, 2 );
        add_action( 'save_post_amaley_shg_group', array( $this, 'save_shg' ), 10, 2 );
        add_action( 'save_post_amaley_member', array( $this, 'save_member' ), 10, 2 );
    }
    public function add_meta_boxes() {
        add_meta_box( 'amaley_cluster_details', 'Amaley Cluster Details', array( $this, 'render_cluster_box' ), 'amaley_cluster', 'normal', 'high' );
        add_meta_box( 'amaley_cluster_linked_groups', 'Amaley Linked Producer Groups / SHGs', array( $this, 'render_cluster_linked_groups_box' ), 'amaley_cluster', 'side', 'default' );
        add_meta_box( 'amaley_shg_details', 'Amaley SHG Group Details', array( $this, 'render_shg_box' ), 'amaley_shg_group', 'normal', 'high' );
        add_meta_box( 'amaley_member_details', 'Amaley Member / Producer Details', array( $this, 'render_member_box' ), 'amaley_member', 'normal', 'high' );
    }
    public function render_cluster_box( $post ) { $this->render_fields( $post, 'cluster' ); }
    public function render_shg_box( $post ) { $this->render_fields( $post, 'shg' ); }
    public function render_member_box( $post ) { $this->render_fields( $post, 'member' ); }

    /**
     * Cluster-side explicit group links.
     *
     * This is the stable source for Cluster Single Template relationship output.
     * Earlier relation fields on the live site are inconsistent across plugins, so
     * this stores selected group IDs directly on the cluster in one safe meta key.
     */
    public function render_cluster_linked_groups_box( $post ) {
        wp_nonce_field( 'amaley_core_save_cluster_linked_groups', 'amaley_core_cluster_linked_groups_nonce' );

        $saved = get_post_meta( $post->ID, '_amaley_cluster_linked_group_ids', true );
        if ( ! is_array( $saved ) ) {
            $saved = $this->csv_to_ids( $saved );
        }
        $saved = array_values( array_unique( array_filter( array_map( 'absint', $saved ) ) ) );

        $types = $this->get_group_like_post_types_for_admin();
        if ( empty( $types ) ) {
            echo '<p>No SHG / producer group post type found.</p>';
            return;
        }

        $groups = get_posts( array(
            'post_type' => $types,
            'post_status' => array( 'publish', 'private', 'draft', 'pending' ),
            'posts_per_page' => 500,
            'orderby' => 'title',
            'order' => 'ASC',
        ) );

        echo '<p style="margin-top:0;">Select the groups that must appear on this cluster single page.</p>';
        echo '<div style="max-height:320px;overflow:auto;border:1px solid #ccd0d4;background:#fff;padding:8px;">';

        if ( empty( $groups ) ) {
            echo '<p>No groups found.</p>';
        } else {
            foreach ( $groups as $group ) {
                $checked = in_array( absint( $group->ID ), $saved, true );
                echo '<label style="display:block;margin:0 0 8px;line-height:1.35;">';
                echo '<input type="checkbox" name="amaley_cluster_linked_group_ids[]" value="' . esc_attr( $group->ID ) . '" ' . checked( $checked, true, false ) . ' /> ';
                echo '<strong>' . esc_html( get_the_title( $group ) ) . '</strong>';
                echo '<br><small>ID ' . esc_html( $group->ID ) . ' · ' . esc_html( get_post_type( $group ) ) . '</small>';
                echo '</label>';
            }
        }

        echo '</div>';
        echo '<p class="description">Saved in <code>_amaley_cluster_linked_group_ids</code>. This is what the single cluster template reads first.</p>';
    }

    private function csv_to_ids( $value ) {
        if ( is_array( $value ) ) {
            $ids = array();
            foreach ( $value as $item ) {
                $ids = array_merge( $ids, $this->csv_to_ids( $item ) );
            }
            return $ids;
        }
        $text = (string) $value;
        if ( '' === trim( $text ) ) {
            return array();
        }
        if ( preg_match_all( '/\d+/', $text, $matches ) ) {
            return array_map( 'absint', $matches[0] );
        }
        return array();
    }

    private function get_group_like_post_types_for_admin() {
        $types = get_post_types( array(), 'objects' );
        $out = array();

        foreach ( $types as $type => $obj ) {
            if ( in_array( $type, array( 'post', 'page', 'attachment', 'product', 'amaley_cluster', 'amaley_member' ), true ) ) {
                continue;
            }

            $haystack = strtolower( $type . ' ' . $obj->label . ' ' . $obj->labels->name . ' ' . $obj->labels->singular_name );
            foreach ( array( 'shg', 'group', 'producer', 'collective', 'women', 'mahila', 'self_help' ) as $needle ) {
                if ( false !== strpos( $haystack, $needle ) ) {
                    $out[] = $type;
                    break;
                }
            }
        }

        if ( post_type_exists( 'amaley_shg_group' ) && ! in_array( 'amaley_shg_group', $out, true ) ) {
            $out[] = 'amaley_shg_group';
        }

        return array_values( array_unique( $out ) );
    }

    private function render_fields( $post, $entity ) {
        wp_nonce_field( 'amaley_core_save_' . $entity, 'amaley_core_' . $entity . '_nonce' );
        $groups = $this->fields->get_fields( $entity );
        echo '<div class="amaley-core-metabox">';
        foreach ( $groups as $group ) {
            echo '<section class="amaley-core-field-section"><h3>' . esc_html( $group['label'] ) . '</h3>';
            foreach ( $group['fields'] as $meta_key => $field ) {
                $value = get_post_meta( $post->ID, $meta_key, true );
                if ( '' === $value && isset( $field['default'] ) ) { $value = $field['default']; }
                $this->render_field( $post->ID, $meta_key, $field, $value );
            }
            echo '</section>';
        }
        echo '</div>';
    }
    private function render_field( $post_id, $meta_key, $field, $value ) {
        $type = isset( $field['type'] ) ? $field['type'] : 'text';
        $label = isset( $field['label'] ) ? $field['label'] : $meta_key;
        $name = 'amaley_core_meta[' . esc_attr( $meta_key ) . ']';
        $required = ! empty( $field['required'] ) ? ' <span class="amaley-core-required">*</span>' : '';
        echo '<div class="amaley-core-field amaley-core-field-' . esc_attr( $type ) . '">';
        echo '<label for="' . esc_attr( $meta_key ) . '">' . esc_html( $label ) . wp_kses_post( $required ) . '</label>';
        switch ( $type ) {
            case 'textarea':
                $rows = isset( $field['rows'] ) ? absint( $field['rows'] ) : 3;
                echo '<textarea id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" rows="' . esc_attr( $rows ) . '" placeholder="' . esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ) . '">' . esc_textarea( $value ) . '</textarea>';
                break;
            case 'wysiwyg':
                $rows = isset( $field['rows'] ) ? absint( $field['rows'] ) : 9;
                $editor_id = 'amaley_core_editor_' . sanitize_key( $meta_key ) . '_' . absint( $post_id );
                wp_editor(
                    wp_kses_post( (string) $value ),
                    $editor_id,
                    array(
                        'textarea_name' => $name,
                        'textarea_rows' => $rows,
                        'media_buttons' => false,
                        'teeny'         => false,
                        'quicktags'     => true,
                        'tinymce'       => array(
                            'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,undo,redo',
                            'toolbar2' => '',
                        ),
                    )
                );
                echo '<p class="description amaley-core-richtext-note">Use Visual tab for normal writing. Code tab remains available for clean HTML if TinyMCE is slow.</p>';
                break;
            case 'gallery':
                $this->render_gallery_field( $meta_key, $name, $value );
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
            default:
                echo '<input type="text" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ) . '" />';
                break;
        }
        if ( ! empty( $field['description'] ) ) { echo '<p class="description">' . esc_html( $field['description'] ) . '</p>'; }
        echo '</div>';
    }
    private function render_post_select( $meta_key, $name, $value, $post_type, $placeholder ) {
        $posts = get_posts( array( 'post_type' => $post_type, 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 500, 'orderby' => 'title', 'order' => 'ASC' ) );
        echo '<select id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '">';
        echo '<option value="">' . esc_html( $placeholder ) . '</option>';
        foreach ( $posts as $item ) { echo '<option value="' . esc_attr( $item->ID ) . '" ' . selected( (string) $value, (string) $item->ID, false ) . '>' . esc_html( get_the_title( $item ) ) . '</option>'; }
        echo '</select>';
    }
    private function render_gallery_field( $meta_key, $name, $value ) {
        $urls = $this->gallery_urls_from_value( $value );
        echo '<div class="amaley-core-gallery-field" data-gallery-field="1">';
        echo '<textarea class="amaley-core-gallery-value" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $name ) . '" rows="5" readonly>' . esc_textarea( implode( "
", $urls ) ) . '</textarea>';
        echo '<div class="amaley-core-gallery-actions">';
        echo '<button type="button" class="button button-primary amaley-core-gallery-select">Add / Select Gallery Images</button> ';
        echo '<button type="button" class="button amaley-core-gallery-clear">Clear Gallery</button>';
        echo '</div>';
        echo '<div class="amaley-core-gallery-preview">';
        foreach ( $urls as $url ) {
            echo '<figure><img src="' . esc_url( $url ) . '" alt="" loading="lazy" /><button type="button" class="button-link-delete amaley-core-gallery-remove" aria-label="Remove image">×</button></figure>';
        }
        echo '</div>';
        echo '<p class="description">This stores one clean image URL per line. Use WordPress Featured Image for the main visual; use this gallery for the visual story section.</p>';
        echo '</div>';
    }

    private function gallery_urls_from_value( $value ) {
        if ( is_array( $value ) ) {
            $parts = $value;
        } else {
            $parts = preg_split( '/[
,]+/', (string) $value );
        }
        $urls = array();
        foreach ( (array) $parts as $part ) {
            $url = trim( (string) $part );
            if ( '' === $url ) { continue; }
            if ( filter_var( $url, FILTER_VALIDATE_URL ) ) { $urls[] = esc_url_raw( $url ); }
        }
        return array_values( array_unique( $urls ) );
    }

    public function save_cluster( $post_id, $post ) {
        $this->save_entity( $post_id, 'cluster' );
        $this->save_cluster_linked_groups( $post_id );
    }

    private function save_cluster_linked_groups( $post_id ) {
        if ( ! isset( $_POST['amaley_core_cluster_linked_groups_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amaley_core_cluster_linked_groups_nonce'] ) ), 'amaley_core_save_cluster_linked_groups' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $raw = isset( $_POST['amaley_cluster_linked_group_ids'] ) && is_array( $_POST['amaley_cluster_linked_group_ids'] ) ? wp_unslash( $_POST['amaley_cluster_linked_group_ids'] ) : array();
        $ids = array_values( array_unique( array_filter( array_map( 'absint', (array) $raw ) ) ) );

        if ( empty( $ids ) ) {
            delete_post_meta( $post_id, '_amaley_cluster_linked_group_ids' );
            return;
        }

        update_post_meta( $post_id, '_amaley_cluster_linked_group_ids', $ids );
    }
    public function save_shg( $post_id, $post ) {
        $this->save_entity( $post_id, 'shg' );
        $cluster_id = absint( get_post_meta( $post_id, '_amaley_shg_cluster_id', true ) );
        if ( $cluster_id ) { update_post_meta( $post_id, '_amaley_shg_cluster_code', get_post_meta( $cluster_id, '_amaley_cluster_code', true ) ); }
    }
    public function save_member( $post_id, $post ) {
        $this->save_entity( $post_id, 'member' );
        $shg_id = absint( get_post_meta( $post_id, '_amaley_member_shg_id', true ) );
        if ( $shg_id ) { update_post_meta( $post_id, '_amaley_member_shg_code', get_post_meta( $shg_id, '_amaley_shg_code', true ) ); }
    }
    private function save_entity( $post_id, $entity ) {
        if ( ! isset( $_POST[ 'amaley_core_' . $entity . '_nonce' ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ 'amaley_core_' . $entity . '_nonce' ] ) ), 'amaley_core_save_' . $entity ) ) { return; }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
        if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
        $posted = isset( $_POST['amaley_core_meta'] ) && is_array( $_POST['amaley_core_meta'] ) ? wp_unslash( $_POST['amaley_core_meta'] ) : array();
        foreach ( $this->fields->get_fields( $entity ) as $group ) {
            foreach ( $group['fields'] as $meta_key => $field ) {
                $type = isset( $field['type'] ) ? $field['type'] : 'text';
                if ( 'readonly' === $type ) { continue; }
                $value = 'checkbox' === $type ? ( isset( $posted[ $meta_key ] ) ? '1' : '0' ) : ( isset( $posted[ $meta_key ] ) ? $this->sanitize_value( $posted[ $meta_key ], $type ) : '' );
                update_post_meta( $post_id, $meta_key, $value );
            }
        }
    }
    private function sanitize_value( $value, $type ) {
        if ( 'wysiwyg' === $type ) { return wp_kses_post( $value ); }
        if ( 'gallery' === $type ) { return implode( "\n", $this->gallery_urls_from_value( $value ) ); }
        if ( 'textarea' === $type ) { return sanitize_textarea_field( $value ); }
        if ( 'number' === $type || false !== strpos( $type, 'relation_' ) ) { return absint( $value ); }
        return sanitize_text_field( $value );
    }
}
