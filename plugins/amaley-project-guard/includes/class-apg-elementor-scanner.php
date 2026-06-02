<?php
/**
 * Elementor scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Elementor_Scanner {

    /**
     * Scan basic Elementor status and registered widgets.
     *
     * @return array<string,mixed>
     */
    public function scan() {
        $active = class_exists( '\Elementor\Plugin' );
        $widgets = array();
        $issues = array();
        $experiments = $this->scan_experiments();

        if ( $active ) {
            try {
                $manager = \Elementor\Plugin::$instance->widgets_manager ?? null;
                if ( $manager && method_exists( $manager, 'get_widget_types' ) ) {
                    $types = $manager->get_widget_types();
                    foreach ( $types as $name => $widget ) {
                        $class = is_object( $widget ) ? get_class( $widget ) : '';
                        $widgets[] = array(
                            'name'       => (string) $name,
                            'class'      => $class,
                            'is_amaley'  => ( false !== stripos( (string) $name, 'amaley' ) || false !== stripos( $class, 'Amaley' ) ),
                        );
                    }
                }
            } catch ( Throwable $e ) {
                $issues[] = APG_Utils::issue(
                    'HIGH',
                    'Elementor',
                    'Could not read Elementor widget registry',
                    'Elementor widgets manager',
                    'Project Guard could not list widgets. This does not mean frontend is broken, but it limits visibility.',
                    'Open Elementor once and rerun Quick Scan. If still failing, check debug.log.'
                );
            }
        } else {
            $issues[] = APG_Utils::issue(
                'INFO',
                'Elementor',
                'Elementor class not detected during scan',
                'WordPress active plugins / Elementor bootstrap',
                'Elementor widgets cannot be mapped in this scan.',
                'Confirm Elementor is active if Amaley pages depend on Elementor widgets.'
            );
        }

        foreach ( $experiments as $experiment ) {
            $name = strtolower( (string) $experiment['option_name'] );
            $value = strtolower( (string) $experiment['option_value'] );
            if ( false !== strpos( $name, 'atomic' ) && in_array( $value, array( 'active', 'default_active', '1', 'yes', 'on' ), true ) ) {
                $issues[] = APG_Utils::issue(
                    'HIGH',
                    'Elementor',
                    'Atomic Editor / Atomic feature appears active',
                    $experiment['option_name'],
                    'This feature has already caused editor loading/control issues in the Amaley build workflow.',
                    'Elementor → Settings → Features: deactivate Atomic/Atomic Editor related experiment, then purge cache and retest editor.'
                );
            }
        }

        usort(
            $widgets,
            function ( $a, $b ) {
                if ( $a['is_amaley'] === $b['is_amaley'] ) {
                    return strcasecmp( $a['name'], $b['name'] );
                }
                return $a['is_amaley'] ? -1 : 1;
            }
        );

        return array(
            'active'           => $active,
            'widget_count'     => count( $widgets ),
            'amaley_widgets'   => count( array_filter( $widgets, function ( $item ) { return ! empty( $item['is_amaley'] ); } ) ),
            'widgets'          => $widgets,
            'experiments'      => $experiments,
            'issues'           => $issues,
        );
    }

    /**
     * Read a limited list of Elementor experiment options.
     *
     * @return array<int,array<string,string>>
     */
    private function scan_experiments() {
        global $wpdb;

        $rows = array();
        if ( ! $wpdb ) {
            return $rows;
        }

        $results = $wpdb->get_results(
            "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'elementor_experiment-%' OR option_name LIKE 'elementor_experiment_%' LIMIT 100",
            ARRAY_A
        );

        foreach ( (array) $results as $row ) {
            $rows[] = array(
                'option_name'  => isset( $row['option_name'] ) ? (string) $row['option_name'] : '',
                'option_value' => isset( $row['option_value'] ) ? APG_Utils::limit_text( (string) $row['option_value'], 80 ) : '',
            );
        }

        return $rows;
    }
}
