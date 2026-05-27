<?php
/**
 * Custom post type registration.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_CPTs {
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_types' ) );
    }

    /**
     * Register all Amaley Core CPTs.
     *
     * @return void
     */
    public function register_post_types() {
        $this->register_cluster();
        $this->register_shg_group();
        $this->register_member();
    }

    /**
     * Cluster CPT.
     *
     * @return void
     */
    private function register_cluster() {
        register_post_type(
            'amaley_cluster',
            array(
                'labels' => array(
                    'name'          => 'Clusters',
                    'singular_name' => 'Cluster',
                    'add_new_item'  => 'Add New Cluster',
                    'edit_item'     => 'Edit Cluster',
                    'new_item'      => 'New Cluster',
                    'view_item'     => 'View Cluster',
                    'search_items'  => 'Search Clusters',
                    'not_found'     => 'No clusters found',
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => 'amaley-core',
                'show_in_rest'        => true,
                'hierarchical'        => false,
                'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
                'capability_type'     => 'post',
                'map_meta_cap'        => true,
                'menu_position'       => 26,
                'rewrite'             => false,
            )
        );
    }

    /**
     * SHG Group CPT.
     *
     * @return void
     */
    private function register_shg_group() {
        register_post_type(
            'amaley_shg_group',
            array(
                'labels' => array(
                    'name'          => 'SHG Groups',
                    'singular_name' => 'SHG Group',
                    'add_new_item'  => 'Add New SHG Group',
                    'edit_item'     => 'Edit SHG Group',
                    'new_item'      => 'New SHG Group',
                    'view_item'     => 'View SHG Group',
                    'search_items'  => 'Search SHG Groups',
                    'not_found'     => 'No SHG groups found',
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => 'amaley-core',
                'show_in_rest'        => true,
                'hierarchical'        => false,
                'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
                'capability_type'     => 'post',
                'map_meta_cap'        => true,
                'rewrite'             => false,
            )
        );
    }

    /**
     * Member/Producer CPT.
     *
     * @return void
     */
    private function register_member() {
        register_post_type(
            'amaley_member',
            array(
                'labels' => array(
                    'name'          => 'Members / Producers',
                    'singular_name' => 'Member / Producer',
                    'add_new_item'  => 'Add New Member / Producer',
                    'edit_item'     => 'Edit Member / Producer',
                    'new_item'      => 'New Member / Producer',
                    'view_item'     => 'View Member / Producer',
                    'search_items'  => 'Search Members / Producers',
                    'not_found'     => 'No members found',
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => 'amaley-core',
                'show_in_rest'        => true,
                'hierarchical'        => false,
                'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'capability_type'     => 'post',
                'map_meta_cap'        => true,
                'rewrite'             => false,
            )
        );
    }
}
