<?php
/**
 * CSV import/export utilities.
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
     * Register page.
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
     * Render import/export page.
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
        echo '<p class="amaley-core-lead">Use CSV templates to bulk manage Clusters, SHG Groups, Members and Product Origin Mapping. Import defaults to dry-run preview for safety.</p>';

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
        echo '<ul><li>Export existing data before import.</li><li>Use stable codes, not names, for relations.</li><li>SHG rows must include cluster_code.</li><li>Member rows must include shg_code.</li><li>Product Origin rows must include product_sku.</li></ul>';
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
     * Download a template CSV.
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

        $rows = $this->read_csv_file( $_FILES['import_file']['tmp_name'] );
        $report = $this->process_rows( $type, $rows, $mode, $dry_run );

        $this->render_import_report( $type, $mode, $dry_run, $report );
        exit;
    }

    /**
     * Verify download/export request.
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
     * Sample row by type.
     *
     * @param string $type Type.
     * @return array
     */
    private function sample_row( $type ) {
        $samples = array(
            'clusters' => array( 'NUB-APR-001', 'Nubra Apricot Cluster', 'Ladakh', 'Leh', 'Nubra', 'Diskit, Turtuk', 'Small-batch apricot value chain.', 'Apricot jam, dried apricot', 'Coordinator Name', '+91 XXXXX XXXXX', 'active' ),
            'shgs'     => array( 'DISKIT-SHG-001', 'Diskit Women Collective', 'NUB-APR-001', 'Diskit', 'Leh', '12', 'Apricot, bakery', 'Coordinator Name', '+91 XXXXX XXXXX', 'active' ),
            'members'  => array( 'MEM-001', 'Tsering Dolma', 'DISKIT-SHG-001', 'Producer', 'Processing, packaging', 'Apricot jam', 'Diskit', 'active' ),
            'origins'  => array( 'APR-JAM-250', 'NUB-APR-001', 'DISKIT-SHG-001', 'MEM-001', 'Nubra', 'Small-batch apricot jam prepared by producer families.', '1' ),
        );

        return isset( $samples[ $type ] ) ? $samples[ $type ] : array();
    }

    /**
     * Read CSV into associative rows.
     *
     * @param string $file File path.
     * @return array
     */
    private function read_csv_file( $file ) {
        $rows = array();
        $handle = fopen( $file, 'r' );

        if ( ! $handle ) {
            return $rows;
        }

        $headers = fgetcsv( $handle );
        if ( empty( $headers ) ) {
            fclose( $handle );
            return $rows;
        }

        $headers = array_map( 'sanitize_key', $headers );

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
     * Process import rows.
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

        $required = $this->required_columns( $type );
        foreach ( $rows as $index => $row ) {
            $line = $index + 2;
            foreach ( $required as $column ) {
                if ( empty( $row[ $column ] ) ) {
                    $report['errors'][] = 'Line ' . $line . ': Missing required column value: ' . $column;
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
     * Process one row.
     *
     * @param string $type Type.
     * @param array  $row Row.
     * @param string $mode Mode.
     * @param bool   $dry_run Dry run.
     * @return array
     */
    private function process_single_row( $type, $row, $mode, $dry_run ) {
        switch ( $type ) {
            case 'clusters':
                return $this->upsert_cluster( $row, $mode, $dry_run );
            case 'shgs':
                return $this->upsert_shg( $row, $mode, $dry_run );
            case 'members':
                return $this->upsert_member( $row, $mode, $dry_run );
            case 'origins':
                return $this->upsert_origin( $row, $mode, $dry_run );
        }

        return array( 'error' => 'Invalid import type.' );
    }

    /**
     * Upsert cluster.
     *
     * @param array  $row Row.
     * @param string $mode Mode.
     * @param bool   $dry_run Dry run.
     * @return array
     */
    private function upsert_cluster( $row, $mode, $dry_run ) {
        $existing_id = $this->find_post_by_meta( 'amaley_cluster', '_amaley_cluster_code', $row['cluster_code'] );

        // Safety fallback for old imported clusters that existed before Amaley Core
        // and therefore do not yet have a stable cluster_code saved.
        // This prevents duplicate Cluster records during first code backfill imports.
        if ( ! $existing_id && ! empty( $row['cluster_name'] ) ) {
            $existing_id = $this->find_post_by_title( 'amaley_cluster', $row['cluster_name'] );
        }

        $action = $existing_id ? 'updated' : 'created';

        if ( 'create_only' === $mode && $existing_id ) {
            return array( 'action' => 'skipped', 'message' => 'Cluster exists, skipped: ' . $row['cluster_code'] );
        }
        if ( 'update_only' === $mode && ! $existing_id ) {
            return array( 'action' => 'skipped', 'message' => 'Cluster does not exist, skipped: ' . $row['cluster_code'] );
        }

        if ( ! $dry_run ) {
            $post_id = $this->insert_or_update_post( $existing_id, 'amaley_cluster', $row['cluster_name'] );
            update_post_meta( $post_id, '_amaley_cluster_code', $row['cluster_code'] );
            update_post_meta( $post_id, '_amaley_region', $row['region'] ?? '' );
            update_post_meta( $post_id, '_amaley_district', $row['district'] ?? '' );
            update_post_meta( $post_id, '_amaley_block_area', $row['block_area'] ?? '' );
            update_post_meta( $post_id, '_amaley_villages', $row['villages'] ?? '' );
            update_post_meta( $post_id, '_amaley_short_intro', $row['short_intro'] ?? '' );
            update_post_meta( $post_id, '_amaley_main_products', $row['main_products'] ?? '' );
            update_post_meta( $post_id, '_amaley_contact_person', $row['contact_person'] ?? '' );
            update_post_meta( $post_id, '_amaley_phone', $row['phone'] ?? '' );
            update_post_meta( $post_id, '_amaley_status', $row['status'] ?? 'active' );
            update_post_meta( $post_id, '_amaley_show_on_website', '1' );
        }

        return array( 'action' => $action, 'message' => ucfirst( $action ) . ' cluster: ' . $row['cluster_code'] );
    }

    /**
     * Upsert SHG.
     */
    private function upsert_shg( $row, $mode, $dry_run ) {
        $cluster_id = $this->find_post_by_meta( 'amaley_cluster', '_amaley_cluster_code', $row['cluster_code'] );
        if ( ! $cluster_id ) {
            return array( 'error' => 'Cluster not found for cluster_code: ' . $row['cluster_code'] );
        }

        $existing_id = $this->find_post_by_meta( 'amaley_shg_group', '_amaley_shg_code', $row['shg_code'] );
        $action = $existing_id ? 'updated' : 'created';

        if ( 'create_only' === $mode && $existing_id ) {
            return array( 'action' => 'skipped', 'message' => 'SHG exists, skipped: ' . $row['shg_code'] );
        }
        if ( 'update_only' === $mode && ! $existing_id ) {
            return array( 'action' => 'skipped', 'message' => 'SHG does not exist, skipped: ' . $row['shg_code'] );
        }

        if ( ! $dry_run ) {
            $post_id = $this->insert_or_update_post( $existing_id, 'amaley_shg_group', $row['shg_name'] );
            update_post_meta( $post_id, '_amaley_shg_code', $row['shg_code'] );
            update_post_meta( $post_id, '_amaley_shg_cluster_id', $cluster_id );
            update_post_meta( $post_id, '_amaley_shg_cluster_code', $row['cluster_code'] );
            update_post_meta( $post_id, '_amaley_village', $row['village'] ?? '' );
            update_post_meta( $post_id, '_amaley_district', $row['district'] ?? '' );
            update_post_meta( $post_id, '_amaley_member_count', $row['member_count'] ?? '' );
            update_post_meta( $post_id, '_amaley_product_categories', $row['product_categories'] ?? '' );
            update_post_meta( $post_id, '_amaley_contact_person', $row['contact_person'] ?? '' );
            update_post_meta( $post_id, '_amaley_phone', $row['phone'] ?? '' );
            update_post_meta( $post_id, '_amaley_status', $row['status'] ?? 'active' );
            update_post_meta( $post_id, '_amaley_show_on_website', '1' );
        }

        return array( 'action' => $action, 'message' => ucfirst( $action ) . ' SHG: ' . $row['shg_code'] );
    }

    /**
     * Upsert member.
     */
    private function upsert_member( $row, $mode, $dry_run ) {
        $shg_id = $this->find_post_by_meta( 'amaley_shg_group', '_amaley_shg_code', $row['shg_code'] );
        if ( ! $shg_id ) {
            return array( 'error' => 'SHG not found for shg_code: ' . $row['shg_code'] );
        }

        $existing_id = $this->find_post_by_meta( 'amaley_member', '_amaley_member_code', $row['member_code'] );
        $action = $existing_id ? 'updated' : 'created';

        if ( 'create_only' === $mode && $existing_id ) {
            return array( 'action' => 'skipped', 'message' => 'Member exists, skipped: ' . $row['member_code'] );
        }
        if ( 'update_only' === $mode && ! $existing_id ) {
            return array( 'action' => 'skipped', 'message' => 'Member does not exist, skipped: ' . $row['member_code'] );
        }

        if ( ! $dry_run ) {
            $post_id = $this->insert_or_update_post( $existing_id, 'amaley_member', $row['member_name'] );
            update_post_meta( $post_id, '_amaley_member_code', $row['member_code'] );
            update_post_meta( $post_id, '_amaley_member_shg_id', $shg_id );
            update_post_meta( $post_id, '_amaley_member_shg_code', $row['shg_code'] );
            update_post_meta( $post_id, '_amaley_role', $row['role'] ?? '' );
            update_post_meta( $post_id, '_amaley_skills', $row['skills'] ?? '' );
            update_post_meta( $post_id, '_amaley_products_handled', $row['products_handled'] ?? '' );
            update_post_meta( $post_id, '_amaley_village', $row['village'] ?? '' );
            update_post_meta( $post_id, '_amaley_status', $row['status'] ?? 'active' );
            update_post_meta( $post_id, '_amaley_show_on_website', '1' );
        }

        return array( 'action' => $action, 'message' => ucfirst( $action ) . ' member: ' . $row['member_code'] );
    }

    /**
     * Upsert product origin.
     */
    private function upsert_origin( $row, $mode, $dry_run ) {
        if ( ! function_exists( 'wc_get_product_id_by_sku' ) ) {
            return array( 'error' => 'WooCommerce function wc_get_product_id_by_sku not available.' );
        }

        $product_id = wc_get_product_id_by_sku( $row['product_sku'] );
        if ( ! $product_id ) {
            return array( 'error' => 'Product not found for SKU: ' . $row['product_sku'] );
        }

        $cluster_id = $this->find_post_by_meta( 'amaley_cluster', '_amaley_cluster_code', $row['cluster_code'] );
        if ( ! $cluster_id ) {
            return array( 'error' => 'Cluster not found for cluster_code: ' . $row['cluster_code'] );
        }

        $shg_ids = $this->ids_from_codes( 'amaley_shg_group', '_amaley_shg_code', $row['shg_codes'] ?? '' );
        $member_ids = $this->ids_from_codes( 'amaley_member', '_amaley_member_code', $row['member_codes'] ?? '' );
        $has_existing = absint( get_post_meta( $product_id, '_amaley_origin_cluster_id', true ) );
        $action = $has_existing ? 'updated' : 'created';

        if ( 'create_only' === $mode && $has_existing ) {
            return array( 'action' => 'skipped', 'message' => 'Origin mapping exists, skipped SKU: ' . $row['product_sku'] );
        }
        if ( 'update_only' === $mode && ! $has_existing ) {
            return array( 'action' => 'skipped', 'message' => 'Origin mapping does not exist, skipped SKU: ' . $row['product_sku'] );
        }

        if ( ! $dry_run ) {
            update_post_meta( $product_id, '_amaley_origin_cluster_id', $cluster_id );
            update_post_meta( $product_id, '_amaley_origin_shg_ids', $shg_ids );
            update_post_meta( $product_id, '_amaley_origin_member_ids', $member_ids );
            update_post_meta( $product_id, '_amaley_origin_source_village', $row['source_village'] ?? '' );
            update_post_meta( $product_id, '_amaley_origin_note', $row['origin_note'] ?? '' );
            update_post_meta( $product_id, '_amaley_origin_show_origin', ! empty( $row['show_origin'] ) ? '1' : '0' );
        }

        return array( 'action' => $action, 'message' => ucfirst( $action ) . ' origin mapping for SKU: ' . $row['product_sku'] );
    }

    /**
     * Find post by meta value.
     */
    private function find_post_by_meta( $post_type, $meta_key, $meta_value ) {
        $posts = get_posts(
            array(
                'post_type'      => $post_type,
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'meta_key'       => $meta_key,
                'meta_value'     => $meta_value,
            )
        );

        return ! empty( $posts ) ? absint( $posts[0] ) : 0;
    }

    /**
     * Find an existing post by exact title.
     *
     * Used only as a safe fallback when old records do not yet have stable codes.
     *
     * @param string $post_type Post type.
     * @param string $title     Post title from CSV.
     * @return int
     */
    private function find_post_by_title( $post_type, $title ) {
        $target_title = $this->normalize_title( $title );
        if ( '' === $target_title ) {
            return 0;
        }

        $posts = get_posts(
            array(
                'post_type'      => $post_type,
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => -1,
                'fields'         => 'ids',
            )
        );

        foreach ( $posts as $post_id ) {
            if ( $this->normalize_title( get_the_title( $post_id ) ) === $target_title ) {
                return absint( $post_id );
            }
        }

        return 0;
    }

    /**
     * Normalize title values for safe exact matching.
     *
     * @param string $title Title.
     * @return string
     */
    private function normalize_title( $title ) {
        $charset = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'charset' ) : 'UTF-8';
        $title   = wp_specialchars_decode( (string) $title, ENT_QUOTES );
        $title   = html_entity_decode( $title, ENT_QUOTES, $charset ? $charset : 'UTF-8' );
        $title   = wp_strip_all_tags( $title );

        return trim( preg_replace( '/\s+/', ' ', $title ) );
    }

    /**
     * Insert or update post.
     */
    private function insert_or_update_post( $post_id, $post_type, $title ) {
        $data = array(
            'post_title'  => $title,
            'post_type'   => $post_type,
            'post_status' => 'publish',
        );

        if ( $post_id ) {
            $data['ID'] = $post_id;
            wp_update_post( $data );
            return $post_id;
        }

        return wp_insert_post( $data );
    }

    /**
     * Get IDs from comma-separated codes.
     */
    private function ids_from_codes( $post_type, $meta_key, $codes_string ) {
        $codes = array_filter( array_map( 'trim', explode( ',', (string) $codes_string ) ) );
        $ids = array();
        foreach ( $codes as $code ) {
            $id = $this->find_post_by_meta( $post_type, $meta_key, $code );
            if ( $id ) {
                $ids[] = $id;
            }
        }
        return $ids;
    }

    /**
     * Export rows.
     */
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

    /**
     * Export CPT posts.
     */
    private function export_posts( $post_type, $keys ) {
        $posts = get_posts(
            array(
                'post_type'      => $post_type,
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );
        $rows = array();
        foreach ( $posts as $post ) {
            $row = array();
            foreach ( $keys as $key ) {
                $row[] = 'post_title' === $key ? get_the_title( $post ) : get_post_meta( $post->ID, $key, true );
            }
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Export product origin mapping.
     */
    private function export_origins() {
        if ( ! post_type_exists( 'product' ) ) {
            return array();
        }

        $products = get_posts(
            array(
                'post_type'      => 'product',
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => -1,
            )
        );

        $rows = array();
        foreach ( $products as $product ) {
            $cluster_id = absint( get_post_meta( $product->ID, '_amaley_origin_cluster_id', true ) );
            if ( ! $cluster_id ) {
                continue;
            }
            $product_obj = function_exists( 'wc_get_product' ) ? wc_get_product( $product->ID ) : null;
            $rows[] = array(
                $product_obj ? $product_obj->get_sku() : '',
                get_post_meta( $cluster_id, '_amaley_cluster_code', true ),
                $this->codes_from_ids( (array) get_post_meta( $product->ID, '_amaley_origin_shg_ids', true ), '_amaley_shg_code' ),
                $this->codes_from_ids( (array) get_post_meta( $product->ID, '_amaley_origin_member_ids', true ), '_amaley_member_code' ),
                get_post_meta( $product->ID, '_amaley_origin_source_village', true ),
                get_post_meta( $product->ID, '_amaley_origin_note', true ),
                get_post_meta( $product->ID, '_amaley_origin_show_origin', true ),
            );
        }

        return $rows;
    }

    /**
     * Get CSV codes from IDs.
     */
    private function codes_from_ids( $ids, $meta_key ) {
        $codes = array();
        foreach ( array_filter( array_map( 'absint', $ids ) ) as $id ) {
            $code = get_post_meta( $id, $meta_key, true );
            if ( $code ) {
                $codes[] = $code;
            }
        }
        return implode( ',', $codes );
    }

    /**
     * Render import report and stop.
     */
    private function render_import_report( $type, $mode, $dry_run, $report ) {
        echo '<div class="wrap amaley-core-wrap">';
        echo '<h1>Amaley Core Import Report</h1>';
        echo '<p><a href="' . esc_url( admin_url( 'admin.php?page=amaley-core-import-export' ) ) . '">← Back to Import / Export</a></p>';
        echo '<div class="amaley-core-panel">';
        echo '<h2>' . esc_html( $dry_run ? 'Dry-run Preview' : 'Import Completed' ) . '</h2>';
        echo '<p><strong>Type:</strong> ' . esc_html( $type ) . '</p>';
        echo '<p><strong>Mode:</strong> ' . esc_html( $mode ) . '</p>';
        echo '<ul>';
        echo '<li>Total rows: ' . esc_html( $report['total'] ) . '</li>';
        echo '<li>New records: ' . esc_html( $report['created'] ) . '</li>';
        echo '<li>Records to update: ' . esc_html( $report['updated'] ) . '</li>';
        echo '<li>Skipped: ' . esc_html( $report['skipped'] ) . '</li>';
        echo '<li>Errors: ' . esc_html( count( $report['errors'] ) ) . '</li>';
        echo '</ul>';
        echo '</div>';

        if ( ! empty( $report['errors'] ) ) {
            echo '<div class="amaley-core-panel amaley-core-error-panel"><h2>Errors</h2><ul>';
            foreach ( $report['errors'] as $error ) {
                echo '<li>' . esc_html( $error ) . '</li>';
            }
            echo '</ul></div>';
        }

        if ( ! empty( $report['details'] ) ) {
            echo '<div class="amaley-core-panel"><h2>Details</h2><ul>';
            foreach ( $report['details'] as $detail ) {
                echo '<li>' . esc_html( $detail ) . '</li>';
            }
            echo '</ul></div>';
        }

        if ( $dry_run ) {
            echo '<div class="amaley-core-panel amaley-core-warning-panel"><p>This was a dry-run. No data was written. Run again with Dry-run unchecked only after reviewing the report and exporting current data.</p></div>';
        }

        echo '</div>';
    }
}
