<?php
/**
 * Central field registry.
 *
 * @package Amaley_Core
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Fields {
    public function get_fields( $entity ) {
        $method = 'get_' . sanitize_key( $entity ) . '_fields';
        return method_exists( $this, $method ) ? $this->{$method}() : array();
    }

    public function get_cluster_fields() {
        return array(
            'basic' => array(
                'label' => 'Basic Details',
                'fields' => array(
                    '_amaley_cluster_code'    => array( 'label' => 'Cluster Code', 'type' => 'text', 'required' => true, 'placeholder' => 'NUB-APR-001', 'description' => 'Stable unique code used for import/export and mapping.' ),
                    '_amaley_short_label'     => array( 'label' => 'Short Label', 'type' => 'text', 'placeholder' => 'Nubra Apricot' ),
                    '_amaley_status'          => array( 'label' => 'Status', 'type' => 'select', 'options' => $this->status_options(), 'default' => 'active' ),
                    '_amaley_show_on_website' => array( 'label' => 'Show on Website', 'type' => 'checkbox', 'default' => '1' ),
                    '_amaley_featured'        => array( 'label' => 'Featured Cluster', 'type' => 'checkbox' ),
                    '_amaley_display_order'   => array( 'label' => 'Display Order', 'type' => 'number', 'default' => '0' ),
                ),
            ),
            'location' => array(
                'label' => 'Location',
                'fields' => array(
                    '_amaley_region'     => array( 'label' => 'Region', 'type' => 'text', 'placeholder' => 'Ladakh / Uttarakhand' ),
                    '_amaley_district'   => array( 'label' => 'District', 'type' => 'text' ),
                    '_amaley_block_area' => array( 'label' => 'Block / Area', 'type' => 'text' ),
                    '_amaley_villages'   => array( 'label' => 'Village / Villages', 'type' => 'textarea' ),
                ),
            ),
            'story' => array(
                'label' => 'Story',
                'fields' => array(
                    '_amaley_short_intro'   => array( 'label' => 'Short Introduction', 'type' => 'textarea' ),
                    '_amaley_full_story'    => array( 'label' => 'Full Story', 'type' => 'textarea', 'rows' => 6 ),
                    '_amaley_main_products' => array( 'label' => 'Main Products', 'type' => 'textarea', 'placeholder' => 'Apricot jam, dried apricot, cookies' ),
                ),
            ),
            'media' => array(
                'label' => 'Media',
                'fields' => array(
                    '_amaley_gallery_urls' => array( 'label' => 'Gallery Image URLs', 'type' => 'textarea', 'description' => 'One image URL per line. Featured image should be set using WordPress Featured Image.' ),
                ),
            ),
            'contact' => array(
                'label' => 'Contact',
                'fields' => array(
                    '_amaley_contact_person' => array( 'label' => 'Contact Person', 'type' => 'text' ),
                    '_amaley_phone'          => array( 'label' => 'Phone / WhatsApp', 'type' => 'text' ),
                ),
            ),
        );
    }

    public function get_shg_fields() {
        return array(
            'basic' => array(
                'label' => 'Basic Details',
                'fields' => array(
                    '_amaley_shg_code'        => array( 'label' => 'SHG Code', 'type' => 'text', 'required' => true, 'placeholder' => 'DISKIT-SHG-001', 'description' => 'Stable unique code used for import/export and mapping.' ),
                    '_amaley_status'          => array( 'label' => 'Status', 'type' => 'select', 'options' => $this->status_options(), 'default' => 'active' ),
                    '_amaley_show_on_website' => array( 'label' => 'Show on Website', 'type' => 'checkbox', 'default' => '1' ),
                    '_amaley_featured'        => array( 'label' => 'Featured SHG', 'type' => 'checkbox' ),
                    '_amaley_display_order'   => array( 'label' => 'Display Order', 'type' => 'number', 'default' => '0' ),
                ),
            ),
            'relations' => array(
                'label' => 'Relations',
                'fields' => array(
                    '_amaley_shg_cluster_id'   => array( 'label' => 'Linked Cluster', 'type' => 'relation_cluster', 'required' => true ),
                    '_amaley_shg_cluster_code' => array( 'label' => 'Linked Cluster Code', 'type' => 'readonly' ),
                ),
            ),
            'location' => array(
                'label' => 'Location',
                'fields' => array(
                    '_amaley_village'  => array( 'label' => 'Village', 'type' => 'text' ),
                    '_amaley_district' => array( 'label' => 'District', 'type' => 'text' ),
                ),
            ),
            'story' => array(
                'label' => 'Story and Products',
                'fields' => array(
                    '_amaley_member_count'        => array( 'label' => 'No. of Members', 'type' => 'number' ),
                    '_amaley_product_categories'  => array( 'label' => 'Product Categories', 'type' => 'textarea', 'placeholder' => 'Apricot, seabuckthorn, herbs, bakery' ),
                    '_amaley_short_story'         => array( 'label' => 'Short Story', 'type' => 'textarea' ),
                    '_amaley_full_story'          => array( 'label' => 'Full Story', 'type' => 'textarea', 'rows' => 6 ),
                    '_amaley_verification_status' => array( 'label' => 'Verification Status', 'type' => 'select', 'options' => $this->verification_options(), 'default' => 'pending' ),
                ),
            ),
            'media' => array(
                'label' => 'Media',
                'fields' => array(
                    '_amaley_gallery_urls' => array( 'label' => 'Gallery Image URLs', 'type' => 'textarea', 'description' => 'One image URL per line. Featured image should be set using WordPress Featured Image.' ),
                ),
            ),
            'contact' => array(
                'label' => 'Contact',
                'fields' => array(
                    '_amaley_contact_person' => array( 'label' => 'Contact Person', 'type' => 'text' ),
                    '_amaley_phone'          => array( 'label' => 'Phone / WhatsApp', 'type' => 'text' ),
                ),
            ),
        );
    }

    public function get_member_fields() {
        return array(
            'basic' => array(
                'label' => 'Basic Details',
                'fields' => array(
                    '_amaley_member_code'     => array( 'label' => 'Member Code', 'type' => 'text', 'required' => true, 'placeholder' => 'MEM-001', 'description' => 'Stable unique code used for import/export and mapping.' ),
                    '_amaley_status'          => array( 'label' => 'Status', 'type' => 'select', 'options' => $this->status_options(), 'default' => 'active' ),
                    '_amaley_show_on_website' => array( 'label' => 'Show on Website', 'type' => 'checkbox', 'default' => '1' ),
                    '_amaley_featured'        => array( 'label' => 'Featured Member', 'type' => 'checkbox' ),
                ),
            ),
            'relations' => array(
                'label' => 'Relations',
                'fields' => array(
                    '_amaley_member_shg_id'   => array( 'label' => 'Linked SHG Group', 'type' => 'relation_shg', 'required' => true ),
                    '_amaley_member_shg_code' => array( 'label' => 'Linked SHG Code', 'type' => 'readonly' ),
                ),
            ),
            'profile' => array(
                'label' => 'Profile',
                'fields' => array(
                    '_amaley_role'             => array( 'label' => 'Role', 'type' => 'text', 'placeholder' => 'Producer / Baker / Collector / Processor' ),
                    '_amaley_skills'           => array( 'label' => 'Skills', 'type' => 'textarea' ),
                    '_amaley_products_handled' => array( 'label' => 'Products Handled', 'type' => 'textarea' ),
                    '_amaley_short_bio'        => array( 'label' => 'Short Bio', 'type' => 'textarea' ),
                    '_amaley_story'            => array( 'label' => 'Story', 'type' => 'textarea', 'rows' => 6 ),
                    '_amaley_village'          => array( 'label' => 'Village', 'type' => 'text' ),
                    '_amaley_phone'            => array( 'label' => 'Phone / WhatsApp Optional', 'type' => 'text' ),
                    '_amaley_photo_url'        => array( 'label' => 'Photo URL', 'type' => 'text', 'description' => 'Optional URL. Featured image can also be used.' ),
                ),
            ),
        );
    }

    public function get_product_origin_fields() {
        return array(
            '_amaley_origin_cluster_id'        => array( 'label' => 'Primary Cluster', 'type' => 'relation_cluster' ),
            '_amaley_origin_shg_ids'           => array( 'label' => 'Linked SHG Groups', 'type' => 'relation_shg_multi' ),
            '_amaley_origin_member_ids'        => array( 'label' => 'Linked Members / Producers', 'type' => 'relation_member_multi' ),
            '_amaley_origin_source_village'    => array( 'label' => 'Source Village / Region', 'type' => 'text' ),
            '_amaley_origin_note'              => array( 'label' => 'Origin Note', 'type' => 'textarea', 'rows' => 4 ),
            '_amaley_origin_traceability_note' => array( 'label' => 'Traceability Note', 'type' => 'textarea', 'rows' => 4 ),
            '_amaley_origin_show_origin'       => array( 'label' => 'Show Origin on Product Page', 'type' => 'checkbox', 'default' => '1' ),
            '_amaley_origin_show_producer'     => array( 'label' => 'Show Producer Story', 'type' => 'checkbox', 'default' => '1' ),
        );
    }

    public function status_options() { return array( 'active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived' ); }
    public function verification_options() { return array( 'verified' => 'Verified', 'pending' => 'Pending', 'review' => 'Needs Review' ); }

    public function get_csv_columns( $type ) {
        $columns = array(
            'clusters' => array( 'cluster_code', 'cluster_name', 'region', 'district', 'block_area', 'villages', 'short_intro', 'main_products', 'contact_person', 'phone', 'status' ),
            'shgs'     => array( 'shg_code', 'shg_name', 'cluster_code', 'village', 'district', 'member_count', 'product_categories', 'contact_person', 'phone', 'status' ),
            'members'  => array( 'member_code', 'member_name', 'shg_code', 'role', 'skills', 'products_handled', 'village', 'status' ),
            'origins'  => array( 'product_sku', 'cluster_code', 'shg_codes', 'member_codes', 'source_village', 'origin_note', 'show_origin' ),
        );
        return isset( $columns[ $type ] ) ? $columns[ $type ] : array();
    }
}
