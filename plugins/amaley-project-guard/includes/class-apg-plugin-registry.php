<?php
/**
 * Plugin registry scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Plugin_Registry {

    /**
     * Get plugin registry.
     *
     * @return array<string,mixed>
     */
    public function scan() {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $plugins = get_plugins();
        $rows    = array();
        $counts  = array(
            'total'    => 0,
            'active'   => 0,
            'inactive' => 0,
            'amaley'   => 0,
            'external' => 0,
        );

        foreach ( $plugins as $file => $data ) {
            $name        = isset( $data['Name'] ) ? (string) $data['Name'] : $file;
            $version     = isset( $data['Version'] ) ? (string) $data['Version'] : '';
            $author      = isset( $data['Author'] ) ? wp_strip_all_tags( (string) $data['Author'] ) : '';
            $description = isset( $data['Description'] ) ? APG_Utils::limit_text( (string) $data['Description'], 140 ) : '';
            $active      = APG_Utils::is_plugin_active_safe( $file );
            $is_amaley   = ( false !== stripos( $name, 'amaley' ) || false !== stripos( $file, 'amaley' ) );

            $rows[] = array(
                'file'        => $file,
                'name'        => $name,
                'version'     => $version,
                'author'      => $author,
                'description' => $description,
                'status'      => $active ? 'active' : 'inactive',
                'group'       => $is_amaley ? 'amaley' : 'external',
            );

            $counts['total']++;
            $active ? $counts['active']++ : $counts['inactive']++;
            $is_amaley ? $counts['amaley']++ : $counts['external']++;
        }

        usort(
            $rows,
            function ( $a, $b ) {
                if ( $a['group'] === $b['group'] ) {
                    return strcasecmp( $a['name'], $b['name'] );
                }
                return 'amaley' === $a['group'] ? -1 : 1;
            }
        );

        return array(
            'counts' => $counts,
            'items'  => $rows,
        );
    }

    /**
     * Locate Amaley Core as a read-only scan target.
     *
     * @param array<string,mixed> $registry Registry.
     * @return array<string,mixed>
     */
    public function find_amaley_core( $registry ) {
        foreach ( (array) ( $registry['items'] ?? array() ) as $plugin ) {
            $name = strtolower( (string) ( $plugin['name'] ?? '' ) );
            $file = strtolower( (string) ( $plugin['file'] ?? '' ) );
            if ( false !== strpos( $file, 'amaley-core/' ) || 'amaley core' === trim( $name ) || false !== strpos( $name, 'amaley core' ) ) {
                return $plugin;
            }
        }
        return array();
    }
}
