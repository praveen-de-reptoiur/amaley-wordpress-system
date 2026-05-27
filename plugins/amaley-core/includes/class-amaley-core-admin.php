<?php
/**
 * Admin dashboard and utility pages.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Admin {
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

        add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 9 );
    }

    /**
     * Register admin menu.
     *
     * @return void
     */
    public function register_admin_menu() {
        add_menu_page(
            'Amaley Core',
            'Amaley Core',
            'manage_options',
            'amaley-core',
            array( $this, 'render_dashboard' ),
            'dashicons-networking',
            26
        );

        add_submenu_page( 'amaley-core', 'Dashboard', 'Dashboard', 'manage_options', 'amaley-core', array( $this, 'render_dashboard' ) );
        add_submenu_page( 'amaley-core', 'Product Origin Mapping', 'Product Origin Mapping', 'manage_options', 'amaley-core-origin-mapping', array( $this, 'render_origin_mapping_page' ) );
        add_submenu_page( 'amaley-core', 'Settings', 'Settings', 'manage_options', 'amaley-core-settings', array( $this, 'render_settings_page' ) );
    }

    /**
     * Render dashboard.
     *
     * @return void
     */
    public function render_dashboard() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $cluster_count = $this->count_posts( 'amaley_cluster' );
        $shg_count     = $this->count_posts( 'amaley_shg_group' );
        $member_count  = $this->count_posts( 'amaley_member' );
        $mapped        = $this->count_products_with_origin();
        $missing       = $this->count_products_missing_origin();

        echo '<div class="wrap amaley-core-wrap">';
        echo '<h1>Amaley Core Dashboard</h1>';
        echo '<p class="amaley-core-lead">Cluster → SHG Group → Member / Producer → Product Origin backbone for the Amaley fresh build.</p>';

        echo '<div class="amaley-core-cards">';
        $this->render_stat_card( 'Total Clusters', $cluster_count );
        $this->render_stat_card( 'Total SHG Groups', $shg_count );
        $this->render_stat_card( 'Total Members / Producers', $member_count );
        $this->render_stat_card( 'Products with Origin', $mapped );
        $this->render_stat_card( 'Products Missing Origin', $missing );
        $this->render_stat_card( 'Schema Version', AMALEY_CORE_SCHEMA_VERSION );
        echo '</div>';

        echo '<div class="amaley-core-panel">';
        echo '<h2>Locked Structure</h2>';
        echo '<pre>Cluster
  └── Multiple SHG Groups
        └── Multiple Members / Producers

WooCommerce Product
  └── One Primary Cluster
  └── One or Multiple SHG Groups
  └── Optional Members / Producers</pre>';
        echo '</div>';

        echo '<div class="amaley-core-panel">';
        echo '<h2>Next Safe Actions</h2>';
        echo '<ol>';
        echo '<li>Add or import Clusters.</li>';
        echo '<li>Add or import SHG Groups linked to Cluster codes.</li>';
        echo '<li>Add or import Members linked to SHG codes.</li>';
        echo '<li>Map WooCommerce products to Cluster / SHG / Member origins.</li>';
        echo '<li>Export data before bulk changes.</li>';
        echo '</ol>';
        echo '</div>';

        echo '</div>';
    }

    /**
     * Render origin mapping status page.
     *
     * @return void
     */
    public function render_origin_mapping_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        echo '<div class="wrap amaley-core-wrap">';
        echo '<h1>Product Origin Mapping</h1>';

        if ( ! post_type_exists( 'product' ) ) {
            echo '<div class="notice notice-warning inline"><p>WooCommerce product post type was not found. Activate WooCommerce to use product origin mapping.</p></div>';
            echo '</div>';
            return;
        }

        $products = get_posts(
            array(
                'post_type'      => 'product',
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => 100,
                'orderby'        => 'date',
                'order'          => 'DESC',
            )
        );

        echo '<p>Showing latest 100 products. Edit a product to manage its Amaley Origin Mapping panel.</p>';
        echo '<table class="widefat striped amaley-core-table">';
        echo '<thead><tr><th>Product</th><th>SKU</th><th>Cluster</th><th>SHGs</th><th>Members</th><th>Status</th><th>Edit</th></tr></thead><tbody>';

        if ( empty( $products ) ) {
            echo '<tr><td colspan="7">No products found.</td></tr>';
        }

        foreach ( $products as $product ) {
            $cluster_id = absint( get_post_meta( $product->ID, '_amaley_origin_cluster_id', true ) );
            $shg_ids    = (array) get_post_meta( $product->ID, '_amaley_origin_shg_ids', true );
            $member_ids = (array) get_post_meta( $product->ID, '_amaley_origin_member_ids', true );
            $sku        = function_exists( 'wc_get_product' ) ? ( ( wc_get_product( $product->ID ) ) ? wc_get_product( $product->ID )->get_sku() : '' ) : '';
            $mapped     = $cluster_id ? 'Mapped' : 'Missing Cluster';

            echo '<tr>';
            echo '<td>' . esc_html( get_the_title( $product ) ) . '</td>';
            echo '<td>' . esc_html( $sku ) . '</td>';
            echo '<td>' . esc_html( $cluster_id ? get_the_title( $cluster_id ) : '—' ) . '</td>';
            echo '<td>' . esc_html( $this->names_from_ids( $shg_ids ) ) . '</td>';
            echo '<td>' . esc_html( $this->names_from_ids( $member_ids ) ) . '</td>';
            echo '<td>' . esc_html( $mapped ) . '</td>';
            echo '<td><a href="' . esc_url( get_edit_post_link( $product->ID ) ) . '">Edit</a></td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
    }

    /**
     * Render settings page.
     *
     * @return void
     */
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        echo '<div class="wrap amaley-core-wrap">';
        echo '<h1>Amaley Core Settings</h1>';
        echo '<div class="amaley-core-panel">';
        echo '<h2>Version</h2>';
        echo '<p><strong>Plugin Version:</strong> ' . esc_html( AMALEY_CORE_VERSION ) . '</p>';
        echo '<p><strong>Data Schema Version:</strong> ' . esc_html( AMALEY_CORE_SCHEMA_VERSION ) . '</p>';
        echo '</div>';
        echo '<div class="amaley-core-panel">';
        echo '<h2>Non-Coder Rule</h2>';
        echo '<p>Cluster, SHG, Member and Product Origin data must remain manageable from WordPress admin without code editing.</p>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Render stat card.
     *
     * @param string $label Label.
     * @param mixed  $value Value.
     * @return void
     */
    private function render_stat_card( $label, $value ) {
        echo '<div class="amaley-core-card"><span>' . esc_html( $label ) . '</span><strong>' . esc_html( $value ) . '</strong></div>';
    }

    /**
     * Count posts by type.
     *
     * @param string $post_type Post type.
     * @return int
     */
    private function count_posts( $post_type ) {
        $counts = wp_count_posts( $post_type );
        return isset( $counts->publish ) ? absint( $counts->publish ) : 0;
    }

    /**
     * Count mapped products.
     *
     * @return int
     */
    private function count_products_with_origin() {
        if ( ! post_type_exists( 'product' ) ) {
            return 0;
        }

        $query = new WP_Query(
            array(
                'post_type'      => 'product',
                'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array(
                        'key'     => '_amaley_origin_cluster_id',
                        'value'   => '0',
                        'compare' => '>',
                        'type'    => 'NUMERIC',
                    ),
                ),
            )
        );

        return absint( $query->found_posts );
    }

    /**
     * Count products missing origin.
     *
     * @return int
     */
    private function count_products_missing_origin() {
        if ( ! post_type_exists( 'product' ) ) {
            return 0;
        }

        $total = wp_count_posts( 'product' );
        $published = isset( $total->publish ) ? absint( $total->publish ) : 0;
        return max( 0, $published - $this->count_products_with_origin() );
    }

    /**
     * Convert IDs to title list.
     *
     * @param array $ids IDs.
     * @return string
     */
    private function names_from_ids( $ids ) {
        $ids = array_filter( array_map( 'absint', (array) $ids ) );
        if ( empty( $ids ) ) {
            return '—';
        }

        $names = array();
        foreach ( $ids as $id ) {
            $names[] = get_the_title( $id );
        }

        return implode( ', ', array_filter( $names ) );
    }
}
