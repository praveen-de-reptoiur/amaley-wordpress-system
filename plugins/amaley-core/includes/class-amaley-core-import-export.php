<?php
/**
 * CSV import/export utilities.
 *
 * Restored in v1.0.6 after the temporary safe-stub test build.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Import_Export {
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

        add_action( 'admin_menu', array( $this, 'register_page' ), 20 );
        add_action( 'admin_post_amaley_core_download_template', array( $this, 'download_template' ) );
        add_action( 'admin_post_amaley_core_export_csv', array( $this, 'export_csv' ) );
        add_action( 'admin_post_amaley_core_import_csv', array( $this, 'import_csv' ) );
    }

    /**
     * Register import/export page.
     *
     * @return void
     */
    public function register_page() {
        add_submenu_page(
            'amaley-core',
            'Import / Export',
            'Import / Export',
            'manage_options',
            'amaley-core-import-export',
            array( $this, 'render_page' )
        );
    }

    /**
     * Render page with full import form.
     *
     * @return void
     */
    public function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $types = $this->types();

        echo '<div class="wrap amaley-core-wrap">';
        echo '<h1>Amaley Core Import / Export</h1>';
        echo '<p class="amaley-core-lead">Use CSV templates to bulk manage Clusters, SHG Groups, Members and Product Origin Mapping. Always run dry-run first.</p>';

        echo '<div class="amaley-core-panel">';
        echo '<h2>Download CSV Templates</h2>';
        echo '<div class="amaley-core-actions">';
        foreach ( $types as $type => $label ) {
            $url = wp_nonce_url( admin_url( 'admin-post.php?action=amaley_core_download_template&type=' . rawurlencode( $type ) ), 'amaley_core_download_template_' . $type );
            echo '<a class="button" href="' . esc_url( $url ) . '">Download ' . esc_html( $label ) . ' Template</a> ';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="amaley-core-panel">';
        echo '<h2>Export CSV</h2>';
        echo '<div class="amaley-core-actions">';
        foreach ( $types as $type => $label ) {
            $url = wp_nonce_url( admin_url( 'admin-post.php?action=amaley_core_export_csv&type=' . rawurlencode( $type ) ), 'amaley_core_export_csv_' . $type );
            echo '<a class="button button-secondary" href="' . esc_url( $url ) . '">Export ' . esc_html( $label ) . '</a> ';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="amaley-core-panel">';
        echo '<h2>Import CSV</h2>';
        echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" enctype="multipart/form-data">';
        wp_nonce_field( 'amaley_core_import_csv', 'amaley_core_import_nonce' );
        echo '<input type="hidden" name="action" value="amaley_core_import_csv" />';
        echo '<table class="form-table" role="presentation"><tbody>';
        echo '<tr><th scope="row"><label for="amaley_import_type">Import Type</label></th><td><select id="amaley_import_type" name="import_type">';
        foreach ( $types as $type => $label ) {
            echo '<option value="' . esc_attr( $type ) . '">' . esc_html( $label ) . '</option>';
        }
        echo '</select></td></tr>';
        echo '<tr><th scope="row"><label for="amaley_import_mode">Import Mode</label></th><td><select id="amaley_import_mode" name="import_mode"><option value="create_update">Create + Update</option><option value="create_only">Create Only</option><option value="update_only">Update Existing Only</option></select></td></tr>';
        echo '<tr><th scope="row"><label for="amaley_import_file">CSV File</label></th><td><input id="amaley_import_file" type="file" name="import_file" accept=".csv,text/csv" required /></td></tr>';
        echo '<tr><th scope="row">Safety Mode</th><td><label><input type="checkbox" name="dry_run" value="1" checked /> Dry-run preview only. Keep this checked first to validate data before writing.</label></td></tr>';
        echo '</tbody></table>';
        submit_button( 'Run Import Preview / Import' );
        echo '</form>';
        echo '</div>';

        echo '<div class="amaley-core-panel amaley-core-warning-panel">';
        echo '<h2>Safety Rules</h2>';
        echo '<ul><li>Import order: Clusters → SHG Groups → Members / Producers → Product Origin Mapping.</li><li>Run dry-run preview first.</li><li>Use stable codes, not names, for relations.</li><li>Origins require exact WooCommerce product SKU.</li><li>Export existing data before bulk import.</li></ul>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Valid types.
     *
     * @return array
     */
    private function types() {
        return array(
            'clusters' => 'Clusters',
            'shgs'     => 'SHG Groups',
            'members'  => 'Members / Producers',
            'origins'  => 'Product Origin Mapping',
        );
    }

    /**
     * Download template CSV.
     *
     * @return void
     */
    public function download_template() {
        $type = isset( $_GET['type'] ) ? sanitize_key( wp_unslash( $_GET['type'] ) ) : '';
        $this->verify_download_request( 'amaley_core_download_template_' . $type );

        $columns = $this->fields->get_csv_columns( $type );
        if ( empty( $columns ) ) {
            wp_die( 'Invalid template type.' );
        }

        $this->send_csv_headers( 'amaley-' . $type . '-template.csv' );
        $out = fopen( 'php://output', 'w' );
        fputcsv( $out, $columns );
        fputcsv( $out, $this->sample_row( $type ) );
        fclose( $out );
        exit;
    }

    /**
     * Export CSV.
     *
     * @return void
     */
    public function export_csv() {
        $type = isset( $_GET['type'] ) ? sanitize_key( wp_unslash( $_GET['type'] ) ) : '';
        $this->verify_download_request( 'amaley_core_export_csv_' . $type );

        $columns = $this->fields->get_csv_columns( $type );
        if ( empty( $columns ) ) {
            wp_die( 'Invalid export type.' );
        }

        $this->send_csv_headers( 'amaley-' . $type . '-export-' . gmdate( 'Y-m-d' ) . '.csv' );
        $out = fopen( 'php://output', 'w' );
        fputcsv( $out, $columns );
        foreach ( $this->get_export_rows( $type ) as $row ) {
            fputcsv( $out, $row );
        }
        fclose( $out );
        exit;
    }

    /**
     * Import CSV handler.
     *
     * @return void
     */
    public function import_csv() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Permission denied.' );
        }

        if ( ! isset( $_POST['amaley_core_import_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['amaley_core_import_nonce'] ) ), 'amaley_core_import_csv' ) ) {
            wp_die( 'Security check failed.' );
        }

        $type    = isset( $_POST['import_type'] ) ? sanitize_key( wp_unslash( $_POST['import_type'] ) ) : '';
        $mode    = isset( $_POST['import_mode'] ) ? sanitize_key( wp_unslash( $_POST['import_mode'] ) ) : 'create_update';
        $dry_run = isset( $_POST['dry_run'] );

        if ( empty( $_FILES['import_file']['tmp_name'] ) ) {
            wp_die( 'No CSV file uploaded.' );
        }

        $rows   = $this->read_csv_file( $_FILES['import_file']['tmp_name'] );
        $report = $this->process_rows( $type, $rows, $mode, $dry_run );
        $this->render_import_report( $type, $mode, $dry_run, $report );
        exit;
    }

    /**
     * Verify request.
     *
     * @param string $action Nonce action.
     * @return void
     */
    private function verify_download_request( $action ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Permission denied.' );
        }
        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), $action ) ) {
            wp_die( 'Security check failed.' );
        }
    }

    /**
     * Send CSV headers.
     *
     * @param string $filename File name.
     * @return void
     */
    private function send_csv_headers( $filename ) {
        nocache_headers();
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=' . sanitize_file_name( $filename ) );
    }

    /**
     * Sample rows.
     *
     * @param string $type Type.
     * @return array
     */
    private function sample_row( $type ) {
        $samples = array(
            'clusters' => array( 'LAD-APR-001', 'Ladakh Apricot Cluster', 'Ladakh', 'Leh', 'Sham / Nubra Belt', 'Diskit, Turtuk', 'Mountain apricot value chain.', 'Apricot jam, dried apricot', 'Coordinator Name', '', 'active' ),
            'shgs'     => array( 'DISKIT-APR-SHG-001', 'Diskit Apricot Women Collective', 'LAD-APR-001', 'Diskit', 'Leh', '12', 'Apricot products, preserve', 'SHG Coordinator', '', 'active' ),
            'members'  => array( 'MEM-APR-001', 'Producer Member 01', 'DISKIT-APR-SHG-001', 'Producer', 'Sorting, drying, processing', 'Apricot preserve', 'Diskit', 'active' ),
            'origins'  => array( 'ACTUAL-PRODUCT-SKU', 'LAD-APR-001', 'DISKIT-APR-SHG-001', 'MEM-APR-001', 'Diskit', 'Small-batch apricot product linked to SHG value chain.', '1' ),
        );
        return isset( $samples[ $type ] ) ? $samples[ $type ] : array();
    }

    /**
     * Read CSV rows.
     *
     * @param string $file File path.
     * @return array
     */
    private function read_csv_file( $file ) {
        $rows   = array();
        $handle = fopen( $file, 'r' );
        if ( ! $handle ) {
            return $rows;
        }

        $headers = fgetcsv( $handle );
        if ( empty( $headers ) ) {
            fclose( $handle );
            return $rows;
        }

        $headers = array_map(
            function ( $header ) {
                $header = preg_replace( '/^\xEF\xBB\xBF/', '', (string) $header );
                return sanitize_key( $header );
            },
            $headers
        );

        while ( ( $data = fgetcsv( $handle ) ) !== false ) {
            if ( count( array_filter( $data ) ) === 0 ) {
                continue;
            }
            $row = array();
            foreach ( $headers as $index => $header ) {
                $row[ $header ] = isset( $data[ $index ] ) ? sanitize_text_field( $data[ $index ] ) : '';
            }
            $rows[] = $row;
        }

        fclose( $handle );
        return $rows;
    }

    /**
     * Process rows.
     *
     * @param string $type Type.
     * @param array  $rows Rows.
     * @param string $mode Mode.
     * @param bool   $dry_run Dry run.
     * @return array
     */
    private function process_rows( $type, $rows, $mode, $dry_run ) {
        $report = array(
            'total'   => count( $rows ),
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors'  => array(),
            'details' => array(),
        );

        if ( ! isset( $this->types()[ $type ] ) ) {
            $report['errors'][] = 'Invalid import type.';
            return $report;
        }

        foreach ( $rows as $index => $row ) {
            $line = $index + 2;
            foreach ( $this->required_columns( $type ) as $column ) {
                if ( empty( $row[ $column ] ) ) {
                    $report['errors'][] = 'Line ' . $line . ': Missing required value: ' . $column;
                    $report['skipped']++;
                    continue 2;
                }
            }

            $result = $this->process_single_row( $type, $row, $mode, $dry_run );
            if ( ! empty( $result['error'] ) ) {
                $report['errors'][] = 'Line ' . $line . ': ' . $result['error'];
                $report['skipped']++;
                continue;
            }

            if ( 'created' === $result['action'] ) {
                $report['created']++;
            } elseif ( 'updated' === $result['action'] ) {
                $report['updated']++;
            } else {
                $report['skipped']++;
            }
            $report['details'][] = 'Line ' . $line . ': ' . $result['message'];
        }
        return $report;
    }

    /**
     * Required columns.
     *
     * @param string $type Type.
     * @return array
     */
    private function required_columns( $type ) {
        $required = array(
            'clusters' => array( 'cluster_code', 'cluster_name' ),
            'shgs'     => array( 'shg_code', 'shg_name', 'cluster_code' ),
            'members'  => array( 'member_code', 'member_name', 'shg_code' ),
            'origins'  => array( 'product_sku', 'cluster_code' ),
        );
        return isset( $required[ $type ] ) ? $required[ $type ] : array();
    }

    /**
     * Process single row.
     *
     * @param string $type Type.
     * @param array  $row Row.
     * @param string $mode Mode.
     * @param bool   $dry_run Dry run.
     * @return array
     */
    private function process_single_row( $type, $row, $mode, $dry_run ) {
        if ( 'clusters' === $type ) {
            return $this->import_cluster( $row, $mode, $dry_run );
        }
        if ( 'shgs' === $type ) {
            return $this->import_shg( $row, $mode, $dry_run );
        }
        if ( 'members' === $type ) {
            return $this->import_member( $row, $mode, $dry_run );
        }
        if ( 'origins' === $type ) {
            return $this->import_origin( $row, $mode, $dry_run );
        }
        return array( 'action' => 'skipped', 'message' => 'Unsupported row type.' );
    }

    /** Import cluster row. */
    private function import_cluster( $row, $mode, $dry_run ) {
        $code    = $row['cluster_code'];
        $title   = $row['cluster_name'];
        $post_id = $this->find_post_by_meta( 'amaley_cluster', '_amaley_cluster_code', $code );
        $action  = $post_id ? 'updated' : 'created';

        if ( $post_id && 'create_only' === $mode ) {
            return array( 'action' => 'skipped', 'message' => 'Cluster already exists: ' . $code );
        }
        if ( ! $post_id && 'update_only' === $mode ) {
            return array( 'action' => 'skipped', 'message' => 'Cluster not found for update: ' . $code );
        }
        if ( $dry_run ) {
            return array( 'action' => $action, 'message' => 'DRY-RUN ' . $action . ' cluster: ' . $title );
        }

        if ( $post_id ) {
            wp_update_post( array( 'ID' => $post_id, 'post_title' => $title, 'post_status' => 'publish' ) );
        } else {
            $post_id = wp_insert_post( array( 'post_type' => 'amaley_cluster', 'post_title' => $title, 'post_status' => 'publish' ) );
        }
        if ( is_wp_error( $post_id ) || ! $post_id ) {
            return array( 'error' => 'Could not save cluster.' );
        }

        $this->update_meta_set( $post_id, array(
            '_amaley_cluster_code'    => $code,
            '_amaley_region'          => isset( $row['region'] ) ? $row['region'] : '',
            '_amaley_district'        => isset( $row['district'] ) ? $row['district'] : '',
            '_amaley_block_area'      => isset( $row['block_area'] ) ? $row['block_area'] : '',
            '_amaley_villages'        => isset( $row['villages'] ) ? $row['villages'] : '',
            '_amaley_short_intro'     => isset( $row['short_intro'] ) ? $row['short_intro'] : '',
            '_amaley_main_products'   => isset( $row['main_products'] ) ? $row['main_products'] : '',
            '_amaley_contact_person'  => isset( $row['contact_person'] ) ? $row['contact_person'] : '',
            '_amaley_phone'           => isset( $row['phone'] ) ? $row['phone'] : '',
            '_amaley_status'          => isset( $row['status'] ) ? $row['status'] : 'active',
            '_amaley_show_on_website' => '1',
        ) );
        return array( 'action' => $action, 'message' => ucfirst( $action ) . ' cluster: ' . $title );
    }

    /** Import SHG row. */
    private function import_shg( $row, $mode, $dry_run ) {
        $code       = $row['shg_code'];
        $title      = $row['shg_name'];
        $cluster_id = $this->find_post_by_meta( 'amaley_cluster', '_amaley_cluster_code', $row['cluster_code'] );
        if ( ! $cluster_id ) {
            return array( 'error' => 'Linked cluster not found: ' . $row['cluster_code'] );
        }

        $post_id = $this->find_post_by_meta( 'amaley_shg_group', '_amaley_shg_code', $code );
        $action  = $post_id ? 'updated' : 'created';
        if ( $post_id && 'create_only' === $mode ) {
            return array( 'action' => 'skipped', 'message' => 'SHG already exists: ' . $code );
        }
        if ( ! $post_id && 'update_only' === $mode ) {
            return array( 'action' => 'skipped', 'message' => 'SHG not found for update: ' . $code );
        }
        if ( $dry_run ) {
            return array( 'action' => $action, 'message' => 'DRY-RUN ' . $action . ' SHG: ' . $title );
        }

        if ( $post_id ) {
            wp_update_post( array( 'ID' => $post_id, 'post_title' => $title, 'post_status' => 'publish' ) );
        } else {
            $post_id = wp_insert_post( array( 'post_type' => 'amaley_shg_group', 'post_title' => $title, 'post_status' => 'publish' ) );
        }
        if ( is_wp_error( $post_id ) || ! $post_id ) {
            return array( 'error' => 'Could not save SHG.' );
        }

        $this->update_meta_set( $post_id, array(
            '_amaley_shg_code'         => $code,
            '_amaley_shg_cluster_id'   => $cluster_id,
            '_amaley_shg_cluster_code' => $row['cluster_code'],
            '_amaley_village'          => isset( $row['village'] ) ? $row['village'] : '',
            '_amaley_district'         => isset( $row['district'] ) ? $row['district'] : '',
            '_amaley_member_count'     => isset( $row['member_count'] ) ? absint( $row['member_count'] ) : 0,
            '_amaley_product_categories' => isset( $row['product_categories'] ) ? $row['product_categories'] : '',
            '_amaley_contact_person'   => isset( $row['contact_person'] ) ? $row['contact_person'] : '',
            '_amaley_phone'            => isset( $row['phone'] ) ? $row['phone'] : '',
            '_amaley_status'           => isset( $row['status'] ) ? $row['status'] : 'active',
            '_amaley_show_on_website'  => '1',
        ) );
        return array( 'action' => $action, 'message' => ucfirst( $action ) . ' SHG: ' . $title );
    }

    /** Import member row. */
    private function import_member( $row, $mode, $dry_run ) {
        $code   = $row['member_code'];
        $title  = $row['member_name'];
        $shg_id = $this->find_post_by_meta( 'amaley_shg_group', '_amaley_shg_code', $row['shg_code'] );
        if ( ! $shg_id ) {
            return array( 'error' => 'Linked SHG not found: ' . $row['shg_code'] );
        }

        $post_id = $this->find_post_by_meta( 'amaley_member', '_amaley_member_code', $code );
        $action  = $post_id ? 'updated' : 'created';
        if ( $post_id && 'create_only' === $mode ) {
            return array( 'action' => 'skipped', 'message' => 'Member already exists: ' . $code );
        }
        if ( ! $post_id && 'update_only' === $mode ) {
            return array( 'action' => 'skipped', 'message' => 'Member not found for update: ' . $code );
        }
        if ( $dry_run ) {
            return array( 'action' => $action, 'message' => 'DRY-RUN ' . $action . ' member: ' . $title );
        }

        if ( $post_id ) {
            wp_update_post( array( 'ID' => $post_id, 'post_title' => $title, 'post_status' => 'publish' ) );
        } else {
            $post_id = wp_insert_post( array( 'post_type' => 'amaley_member', 'post_title' => $title, 'post_status' => 'publish' ) );
        }
        if ( is_wp_error( $post_id ) || ! $post_id ) {
            return array( 'error' => 'Could not save member.' );
        }

        $this->update_meta_set( $post_id, array(
            '_amaley_member_code'      => $code,
            '_amaley_member_shg_id'    => $shg_id,
            '_amaley_member_shg_code'  => $row['shg_code'],
            '_amaley_role'             => isset( $row['role'] ) ? $row['role'] : '',
            '_amaley_skills'           => isset( $row['skills'] ) ? $row['skills'] : '',
            '_amaley_products_handled' => isset( $row['products_handled'] ) ? $row['products_handled'] : '',
            '_amaley_village'          => isset( $row['village'] ) ? $row['village'] : '',
            '_amaley_status'           => isset( $row['status'] ) ? $row['status'] : 'active',
            '_amaley_show_on_website'  => '1',
        ) );
        return array( 'action' => $action, 'message' => ucfirst( $action ) . ' member: ' . $title );
    }

    /** Import product origin row. */
    private function import_origin( $row, $mode, $dry_run ) {
        $product_id = $this->find_product_by_sku( $row['product_sku'] );
        if ( ! $product_id ) {
            return array( 'error' => 'Product SKU not found: ' . $row['product_sku'] );
        }
        $cluster_id = $this->find_post_by_meta( 'amaley_cluster', '_amaley_cluster_code', $row['cluster_code'] );
        if ( ! $cluster_id ) {
            return array( 'error' => 'Cluster code not found: ' . $row['cluster_code'] );
        }

        $shg_ids    = $this->codes_to_ids( isset( $row['shg_codes'] ) ? $row['shg_codes'] : '', 'amaley_shg_group', '_amaley_shg_code' );
        $member_ids = $this->codes_to_ids( isset( $row['member_codes'] ) ? $row['member_codes'] : '', 'amaley_member', '_amaley_member_code' );

        if ( $dry_run ) {
            return array( 'action' => 'updated', 'message' => 'DRY-RUN update origin for SKU: ' . $row['product_sku'] );
        }

        update_post_meta( $product_id, '_amaley_origin_cluster_id', $cluster_id );
        update_post_meta( $product_id, '_amaley_origin_shg_ids', $shg_ids );
        update_post_meta( $product_id, '_amaley_origin_member_ids', $member_ids );
        update_post_meta( $product_id, '_amaley_origin_source_village', isset( $row['source_village'] ) ? $row['source_village'] : '' );
        update_post_meta( $product_id, '_amaley_origin_note', isset( $row['origin_note'] ) ? $row['origin_note'] : '' );
        update_post_meta( $product_id, '_amaley_origin_traceability_note', isset( $row['origin_note'] ) ? $row['origin_note'] : '' );
        update_post_meta( $product_id, '_amaley_origin_show_origin', isset( $row['show_origin'] ) ? ( '1' === (string) $row['show_origin'] ? '1' : '0' ) : '1' );
        update_post_meta( $product_id, '_amaley_origin_show_producer', '1' );

        return array( 'action' => 'updated', 'message' => 'Updated origin mapping for SKU: ' . $row['product_sku'] );
    }

    /** Update meta values. */
    private function update_meta_set( $post_id, $values ) {
        foreach ( $values as $key => $value ) {
            update_post_meta( $post_id, $key, $value );
        }
    }

    /** Find post by meta. */
    private function find_post_by_meta( $post_type, $meta_key, $meta_value ) {
        $posts = get_posts( array(
            'post_type'      => $post_type,
            'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_key'       => $meta_key,
            'meta_value'     => $meta_value,
        ) );
        return empty( $posts ) ? 0 : absint( $posts[0] );
    }

    /** Find Woo product by SKU. */
    private function find_product_by_sku( $sku ) {
        $sku = trim( (string) $sku );
        if ( '' === $sku ) {
            return 0;
        }
        if ( function_exists( 'wc_get_product_id_by_sku' ) ) {
            $product_id = wc_get_product_id_by_sku( $sku );
            if ( $product_id ) {
                return absint( $product_id );
            }
        }
        return $this->find_post_by_meta( 'product', '_sku', $sku );
    }

    /** Convert comma codes to post IDs. */
    private function codes_to_ids( $raw, $post_type, $meta_key ) {
        $ids = array();
        foreach ( array_filter( array_map( 'trim', explode( ',', (string) $raw ) ) ) as $code ) {
            $id = $this->find_post_by_meta( $post_type, $meta_key, $code );
            if ( $id ) {
                $ids[] = $id;
            }
        }
        return array_values( array_unique( array_map( 'absint', $ids ) ) );
    }

    /** Convert IDs to codes. */
    private function ids_to_codes( $ids, $meta_key ) {
        $codes = array();
        foreach ( array_filter( array_map( 'absint', (array) $ids ) ) as $id ) {
            $code = get_post_meta( $id, $meta_key, true );
            if ( $code ) {
                $codes[] = $code;
            }
        }
        return implode( ',', $codes );
    }

    /** Export rows by type. */
    private function get_export_rows( $type ) {
        if ( 'clusters' === $type ) {
            return $this->export_posts( 'amaley_cluster', array( '_amaley_cluster_code', 'post_title', '_amaley_region', '_amaley_district', '_amaley_block_area', '_amaley_villages', '_amaley_short_intro', '_amaley_main_products', '_amaley_contact_person', '_amaley_phone', '_amaley_status' ) );
        }
        if ( 'shgs' === $type ) {
            return $this->export_posts( 'amaley_shg_group', array( '_amaley_shg_code', 'post_title', '_amaley_shg_cluster_code', '_amaley_village', '_amaley_district', '_amaley_member_count', '_amaley_product_categories', '_amaley_contact_person', '_amaley_phone', '_amaley_status' ) );
        }
        if ( 'members' === $type ) {
            return $this->export_posts( 'amaley_member', array( '_amaley_member_code', 'post_title', '_amaley_member_shg_code', '_amaley_role', '_amaley_skills', '_amaley_products_handled', '_amaley_village', '_amaley_status' ) );
        }
        if ( 'origins' === $type ) {
            return $this->export_origins();
        }
        return array();
    }

    /** Export CPT rows. */
    private function export_posts( $post_type, $keys ) {
        $posts = get_posts( array( 'post_type' => $post_type, 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
        $rows  = array();
        foreach ( $posts as $post ) {
            $row = array();
            foreach ( $keys as $key ) {
                $row[] = 'post_title' === $key ? get_the_title( $post ) : get_post_meta( $post->ID, $key, true );
            }
            $rows[] = $row;
        }
        return $rows;
    }

    /** Export product origins. */
    private function export_origins() {
        if ( ! post_type_exists( 'product' ) ) {
            return array();
        }
        $products = get_posts( array( 'post_type' => 'product', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
        $rows     = array();
        foreach ( $products as $product ) {
            $cluster_id = absint( get_post_meta( $product->ID, '_amaley_origin_cluster_id', true ) );
            if ( ! $cluster_id ) {
                continue;
            }
            $sku = '';
            if ( function_exists( 'wc_get_product' ) ) {
                $wc_product = wc_get_product( $product->ID );
                $sku        = $wc_product ? $wc_product->get_sku() : '';
            } else {
                $sku = get_post_meta( $product->ID, '_sku', true );
            }
            $rows[] = array(
                $sku,
                get_post_meta( $cluster_id, '_amaley_cluster_code', true ),
                $this->ids_to_codes( get_post_meta( $product->ID, '_amaley_origin_shg_ids', true ), '_amaley_shg_code' ),
                $this->ids_to_codes( get_post_meta( $product->ID, '_amaley_origin_member_ids', true ), '_amaley_member_code' ),
                get_post_meta( $product->ID, '_amaley_origin_source_village', true ),
                get_post_meta( $product->ID, '_amaley_origin_note', true ),
                get_post_meta( $product->ID, '_amaley_origin_show_origin', true ),
            );
        }
        return $rows;
    }

    /** Render import report. */
    private function render_import_report( $type, $mode, $dry_run, $report ) {
        echo '<div class="wrap amaley-core-wrap">';
        echo '<h1>Amaley Core Import Report</h1>';
        echo '<p><strong>Type:</strong> ' . esc_html( $type ) . ' &nbsp; <strong>Mode:</strong> ' . esc_html( $mode ) . ' &nbsp; <strong>Dry-run:</strong> ' . esc_html( $dry_run ? 'Yes' : 'No' ) . '</p>';
        echo '<div class="amaley-core-cards">';
        $this->report_card( 'Total Rows', $report['total'] );
        $this->report_card( 'Created', $report['created'] );
        $this->report_card( 'Updated', $report['updated'] );
        $this->report_card( 'Skipped', $report['skipped'] );
        echo '</div>';
        if ( ! empty( $report['errors'] ) ) {
            echo '<div class="notice notice-error"><p><strong>Errors:</strong></p><ul>';
            foreach ( $report['errors'] as $error ) {
                echo '<li>' . esc_html( $error ) . '</li>';
            }
            echo '</ul></div>';
        }
        if ( ! empty( $report['details'] ) ) {
            echo '<div class="amaley-core-panel"><h2>Details</h2><ol>';
            foreach ( $report['details'] as $detail ) {
                echo '<li>' . esc_html( $detail ) . '</li>';
            }
            echo '</ol></div>';
        }
        echo '<p><a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=amaley-core-import-export' ) ) . '">Back to Import / Export</a></p>';
        echo '</div>';
    }

    /** Report stat card. */
    private function report_card( $label, $value ) {
        echo '<div class="amaley-core-card"><span>' . esc_html( $label ) . '</span><strong>' . esc_html( $value ) . '</strong></div>';
    }
}
