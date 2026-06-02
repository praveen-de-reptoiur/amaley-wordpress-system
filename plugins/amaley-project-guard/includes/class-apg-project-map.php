<?php
/**
 * Project map builder.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Project_Map {

    /**
     * Build a lightweight project map.
     *
     * @param array<string,mixed> $plugin_registry Plugin registry.
     * @param array<string,mixed> $shortcodes Shortcodes.
     * @param array<string,mixed> $elementor Elementor scan.
     * @return array<string,mixed>
     */
    public function build( $plugin_registry, $shortcodes, $elementor ) {
        $post_types = get_post_types( array(), 'objects' );
        $taxonomies = get_taxonomies( array(), 'objects' );

        $amaley_cpts = array();
        foreach ( $post_types as $name => $object ) {
            if ( false !== stripos( $name, 'amaley' ) || false !== stripos( $object->label, 'Amaley' ) || in_array( $name, array( 'amaley_cluster', 'amaley_shg', 'amaley_member' ), true ) ) {
                $amaley_cpts[] = array(
                    'name'   => $name,
                    'label'  => $object->label,
                    'public' => ! empty( $object->public ),
                    'show_ui'=> ! empty( $object->show_ui ),
                );
            }
        }

        $amaley_tax = array();
        foreach ( $taxonomies as $name => $object ) {
            if ( false !== stripos( $name, 'amaley' ) || false !== stripos( $object->label, 'Amaley' ) ) {
                $amaley_tax[] = array(
                    'name'   => $name,
                    'label'  => $object->label,
                    'public' => ! empty( $object->public ),
                );
            }
        }

        $amaley_plugins = array_values(
            array_filter(
                (array) ( $plugin_registry['items'] ?? array() ),
                function ( $plugin ) {
                    return isset( $plugin['group'] ) && 'amaley' === $plugin['group'];
                }
            )
        );

        return array(
            'title' => 'Amaley Ecosystem Read-Only Map',
            'nodes' => array(
                'project_guard' => array(
                    'label'       => 'Amaley Project Guard',
                    'role'        => 'Separate read-only admin control room',
                    'version'     => APG_VERSION,
                    'menu'        => 'Top-level admin menu: Amaley Project Guard',
                    'frontend'    => 'No frontend hooks/assets/output',
                ),
                'plugins' => array(
                    'label' => 'Detected Amaley Plugins',
                    'count' => count( $amaley_plugins ),
                    'items' => $amaley_plugins,
                ),
                'content_types' => array(
                    'label' => 'Detected Amaley CPTs',
                    'count' => count( $amaley_cpts ),
                    'items' => $amaley_cpts,
                ),
                'taxonomies' => array(
                    'label' => 'Detected Amaley Taxonomies',
                    'count' => count( $amaley_tax ),
                    'items' => $amaley_tax,
                ),
                'shortcodes' => array(
                    'label' => 'Detected Amaley Shortcodes',
                    'count' => (int) ( $shortcodes['amaley_count'] ?? 0 ),
                    'items' => (array) ( $shortcodes['amaley'] ?? array() ),
                ),
                'elementor_widgets' => array(
                    'label' => 'Detected Amaley Elementor Widgets',
                    'count' => (int) ( $elementor['amaley_widgets'] ?? 0 ),
                    'items' => array_values(
                        array_filter(
                            (array) ( $elementor['widgets'] ?? array() ),
                            function ( $widget ) {
                                return ! empty( $widget['is_amaley'] );
                            }
                        )
                    ),
                ),
            ),
        );
    }
}
