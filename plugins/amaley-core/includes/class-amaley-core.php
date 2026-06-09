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
        new Amaley_Core_Cluster_Cards();
        new Amaley_Core_SHG_Cards();
        new Amaley_Core_Member_Cards();
        new Amaley_Core_Product_Origin_Panel();
        new Amaley_Core_Cluster_Pages();
        new Amaley_Core_Cluster_Archive_Sections();
        new Amaley_Core_Cluster_Single_Sections();
        new Amaley_Core_SHG_Archive_Sections();
        new Amaley_Core_SHG_Single_Sections();
        new Amaley_Core_Member_Archive_Sections();
        new Amaley_Core_Member_Single_Sections();

        add_action( 'wp_enqueue_scripts', array( $this, 'register_card_assets' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'admin_notices', array( $this, 'admin_dependency_notice' ) );
    }

    /**
     * Register centralized card library assets.
     *
     * v1.0.79 only registers the stylesheet. Future connected widgets/renderers may enqueue it.
     *
     * @return void
     */
    public function register_card_assets() {
        wp_register_style(
            'amaley-core-cards',
            AMALEY_CORE_URL . 'assets/amaley-core-cards.css',
            array(),
            AMALEY_CORE_VERSION
        );
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

        if ( in_array( $post_type, array( 'amaley_cluster', 'amaley_shg_group', 'amaley_member' ), true ) ) {
            wp_enqueue_media();
            if ( function_exists( 'wp_enqueue_editor' ) ) {
                wp_enqueue_editor();
            }
            wp_enqueue_script(
                'amaley-core-admin',
                AMALEY_CORE_URL . 'assets/admin.js',
                array( 'jquery' ),
                AMALEY_CORE_VERSION,
                true
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
