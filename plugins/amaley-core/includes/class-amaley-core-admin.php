<?php
/** Admin dashboard and utility pages. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Admin {
    private $fields;
    public function __construct( $fields ) { $this->fields = $fields; add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 9 ); }
    public function register_admin_menu() {
        add_menu_page( 'Amaley Core', 'Amaley Core', 'manage_options', 'amaley-core', array( $this, 'render_dashboard' ), 'dashicons-networking', 26 );
        add_submenu_page( 'amaley-core', 'Dashboard', 'Dashboard', 'manage_options', 'amaley-core', array( $this, 'render_dashboard' ) );
        add_submenu_page( 'amaley-core', 'Product Origin Mapping', 'Product Origin Mapping', 'manage_options', 'amaley-core-origin-mapping', array( $this, 'render_origin_mapping_page' ) );
        add_submenu_page( 'amaley-core', 'Settings', 'Settings', 'manage_options', 'amaley-core-settings', array( $this, 'render_settings_page' ) );
    }
    public function render_dashboard() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        echo '<div class="wrap amaley-core-wrap"><h1>Amaley Core Dashboard</h1><p class="amaley-core-lead">Cluster → SHG Group → Member / Producer → Product Origin backbone for Amaley.</p><div class="amaley-core-cards">';
        $this->render_stat_card( 'Total Clusters', $this->count_posts( 'amaley_cluster' ) );
        $this->render_stat_card( 'Total SHG Groups', $this->count_posts( 'amaley_shg_group' ) );
        $this->render_stat_card( 'Total Members / Producers', $this->count_posts( 'amaley_member' ) );
        $this->render_stat_card( 'Products with Origin', $this->count_products_with_origin() );
        $this->render_stat_card( 'Schema Version', AMALEY_CORE_SCHEMA_VERSION );
        echo '</div><div class="amaley-core-panel"><h2>Locked Structure</h2><pre>Cluster\n  └── Multiple SHG Groups\n        └── Multiple Members / Producers\n\nWooCommerce Product\n  └── One Primary Cluster\n  └── One or Multiple SHG Groups\n  └── Optional Members / Producers</pre></div></div>';
    }
    public function render_origin_mapping_page() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        echo '<div class="wrap amaley-core-wrap"><h1>Product Origin Mapping</h1>';
        if ( ! post_type_exists( 'product' ) ) { echo '<div class="notice notice-warning inline"><p>WooCommerce product post type was not found. Activate WooCommerce to use product origin mapping.</p></div></div>'; return; }
        $products = get_posts( array( 'post_type' => 'product', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 100, 'orderby' => 'date', 'order' => 'DESC' ) );
        echo '<p>Showing latest 100 products. Edit a product to manage Amaley Origin Mapping.</p><table class="widefat striped amaley-core-table"><thead><tr><th>Product</th><th>Cluster</th><th>SHGs</th><th>Members</th><th>Status</th><th>Edit</th></tr></thead><tbody>';
        if ( empty( $products ) ) { echo '<tr><td colspan="6">No products found.</td></tr>'; }
        foreach ( $products as $product ) {
            $cluster_id = absint( get_post_meta( $product->ID, '_amaley_origin_cluster_id', true ) );
            echo '<tr><td>' . esc_html( get_the_title( $product ) ) . '</td><td>' . esc_html( $cluster_id ? get_the_title( $cluster_id ) : '—' ) . '</td><td>' . esc_html( $this->names_from_ids( get_post_meta( $product->ID, '_amaley_origin_shg_ids', true ) ) ) . '</td><td>' . esc_html( $this->names_from_ids( get_post_meta( $product->ID, '_amaley_origin_member_ids', true ) ) ) . '</td><td>' . esc_html( $cluster_id ? 'Mapped' : 'Missing Cluster' ) . '</td><td><a href="' . esc_url( get_edit_post_link( $product->ID ) ) . '">Edit</a></td></tr>';
        }
        echo '</tbody></table></div>';
    }
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        echo '<div class="wrap amaley-core-wrap"><h1>Amaley Core Settings</h1><div class="amaley-core-panel"><h2>Version</h2><p><strong>Plugin Version:</strong> ' . esc_html( AMALEY_CORE_VERSION ) . '</p><p><strong>Data Schema Version:</strong> ' . esc_html( AMALEY_CORE_SCHEMA_VERSION ) . '</p></div><div class="amaley-core-panel"><h2>Non-Coder Rule</h2><p>Cluster, SHG, Member and Product Origin data must remain manageable from WordPress admin without code editing.</p></div></div>';
    }
    private function render_stat_card( $label, $value ) { echo '<div class="amaley-core-card"><span>' . esc_html( $label ) . '</span><strong>' . esc_html( $value ) . '</strong></div>'; }
    private function count_posts( $post_type ) { $counts = wp_count_posts( $post_type ); return isset( $counts->publish ) ? absint( $counts->publish ) : 0; }
    private function count_products_with_origin() {
        if ( ! post_type_exists( 'product' ) ) { return 0; }
        $query = new WP_Query( array( 'post_type' => 'product', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_amaley_origin_cluster_id', 'value' => '0', 'compare' => '>', 'type' => 'NUMERIC' ) ) ) );
        return absint( $query->found_posts );
    }
    private function names_from_ids( $ids ) {
        $ids = array_filter( array_map( 'absint', (array) $ids ) );
        if ( empty( $ids ) ) { return '—'; }
        $names = array(); foreach ( $ids as $id ) { $names[] = get_the_title( $id ); }
        return implode( ', ', array_filter( $names ) );
    }
}
