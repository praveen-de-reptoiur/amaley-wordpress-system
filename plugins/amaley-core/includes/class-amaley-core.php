<?php
/**
 * Main plugin loader.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core {
    /**
     * Field registry.
     *
     * @var Amaley_Core_Fields
     */
    public $fields;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->fields = new Amaley_Core_Fields();

        new Amaley_Core_CPTs();
        new Amaley_Core_Metaboxes( $this->fields );
        new Amaley_Core_Product_Origin( $this->fields );
        new Amaley_Core_Admin( $this->fields );
        new Amaley_Core_Import_Export( $this->fields );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'admin_notices', array( $this, 'admin_dependency_notice' ) );
    }

    /**
     * Load admin CSS only where useful.
     *
     * @param string $hook Current admin hook.
     * @return void
     */
    public function enqueue_admin_assets( $hook ) {
        $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
        $post_type = $screen && isset( $screen->post_type ) ? $screen->post_type : '';

        $allowed_post_types = array( 'amaley_cluster', 'amaley_shg_group', 'amaley_member', 'product' );
        $allowed_pages      = array(
            'toplevel_page_amaley-core',
            'amaley-core_page_amaley-core-origin-mapping',
            'amaley-core_page_amaley-core-import-export',
            'amaley-core_page_amaley-core-settings',
        );

        if ( in_array( $post_type, $allowed_post_types, true ) || in_array( $hook, $allowed_pages, true ) ) {
            wp_enqueue_style(
                'amaley-core-admin',
                AMALEY_CORE_URL . 'assets/admin.css',
                array(),
                AMALEY_CORE_VERSION
            );
        }
    }

    /**
     * Warn admin if WooCommerce is missing. Core can still manage Cluster/SHG/Member data.
     *
     * @return void
     */
    public function admin_dependency_notice() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( class_exists( 'WooCommerce' ) ) {
            return;
        }

        $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
        $is_amaley_screen = $screen && ( false !== strpos( (string) $screen->id, 'amaley-core' ) || in_array( $screen->post_type, array( 'amaley_cluster', 'amaley_shg_group', 'amaley_member' ), true ) );

        if ( ! $is_amaley_screen ) {
            return;
        }

        echo '<div class="notice notice-warning"><p><strong>Amaley Core:</strong> WooCommerce is not active. Cluster, SHG and Member data can be managed, but Product Origin Mapping requires WooCommerce.</p></div>';
    }
}
