<?php
/**
 * Utility helpers for Amaley Project Guard.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Utils {

    /**
     * Build a normalized issue row.
     *
     * @param string $severity Severity.
     * @param string $area Area.
     * @param string $problem Problem.
     * @param string $location Exact location.
     * @param string $impact Impact.
     * @param string $suggested_action Suggested action.
     * @return array<string,string>
     */
    public static function issue( $severity, $area, $problem, $location, $impact, $suggested_action ) {
        return array(
            'severity'         => strtoupper( (string) $severity ),
            'area'             => (string) $area,
            'problem'          => (string) $problem,
            'location'         => (string) $location,
            'impact'           => (string) $impact,
            'suggested_action' => (string) $suggested_action,
        );
    }

    /**
     * Count issue severities.
     *
     * @param array<int,array<string,string>> $issues Issues.
     * @return array<string,int>
     */
    public static function severity_counts( $issues ) {
        $counts = array(
            'CRITICAL' => 0,
            'HIGH'     => 0,
            'MEDIUM'   => 0,
            'LOW'      => 0,
            'INFO'     => 0,
        );

        foreach ( (array) $issues as $issue ) {
            $severity = isset( $issue['severity'] ) ? strtoupper( (string) $issue['severity'] ) : 'INFO';
            if ( ! isset( $counts[ $severity ] ) ) {
                $counts[ $severity ] = 0;
            }
            $counts[ $severity ]++;
        }

        return $counts;
    }

    /**
     * Return report from option.
     *
     * @return array<string,mixed>
     */
    public static function get_last_report() {
        $report = get_option( APG_OPTION_LAST_REPORT, array() );
        return is_array( $report ) ? $report : array();
    }

    /**
     * Save report.
     *
     * @param array<string,mixed> $report Report.
     * @return void
     */
    public static function save_last_report( $report ) {
        update_option( APG_OPTION_LAST_REPORT, $report, false );
    }

    /**
     * Is plugin active safely.
     *
     * @param string $plugin_file Plugin file path relative to plugins dir.
     * @return bool
     */
    public static function is_plugin_active_safe( $plugin_file ) {
        if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        return is_plugin_active( $plugin_file );
    }

    /**
     * Limit a string for display/export.
     *
     * @param string $value Input.
     * @param int    $limit Limit.
     * @return string
     */
    public static function limit_text( $value, $limit = 180 ) {
        $value = wp_strip_all_tags( (string) $value );
        if ( strlen( $value ) <= $limit ) {
            return $value;
        }
        return substr( $value, 0, $limit - 3 ) . '...';
    }
}
