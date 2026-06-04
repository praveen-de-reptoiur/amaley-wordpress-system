<?php
/**
 * Main scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Scanner {

    /**
     * Run v1.0.4 Quick Scan.
     *
     * @return array<string,mixed>
     */
    public function run_quick_scan() {
        $started_at    = microtime( true );
        $memory_start  = memory_get_usage( true );
        $scanned_items = 0;
        $issues        = array();

        $plugin_registry_scanner = new APG_Plugin_Registry();
        $plugins = $plugin_registry_scanner->scan();
        $scanned_items += (int) ( $plugins['counts']['total'] ?? 0 );

        $core_check = $this->scan_amaley_core_target( $plugins, $plugin_registry_scanner );
        $issues = array_merge( $issues, (array) ( $core_check['issues'] ?? array() ) );
        $scanned_items += (int) ( $core_check['scanned_items'] ?? 0 );

        $shortcodes = $this->scan_shortcodes();
        $scanned_items += (int) ( $shortcodes['total_count'] ?? 0 );

        $elementor_scanner = new APG_Elementor_Scanner();
        $elementor = $elementor_scanner->scan();
        $issues = array_merge( $issues, (array) ( $elementor['issues'] ?? array() ) );
        $scanned_items += (int) ( $elementor['widget_count'] ?? 0 );

        $woocommerce_scanner = new APG_WooCommerce_Scanner();
        $woocommerce = $woocommerce_scanner->scan();
        $issues = array_merge( $issues, (array) ( $woocommerce['issues'] ?? array() ) );
        $scanned_items += count( (array) ( $woocommerce['pages'] ?? array() ) );

        $core_integrity_scanner = new APG_Core_Integrity_Scanner();
        $core_integrity = $core_integrity_scanner->scan( $core_check, $elementor );
        $issues = array_merge( $issues, (array) ( $core_integrity['issues'] ?? array() ) );
        $scanned_items += (int) ( $core_integrity['scanned_items'] ?? 0 );

        $external_risk_scanner = new APG_External_Risk_Scanner();
        $external_risks = $external_risk_scanner->scan( $plugins );
        $issues = array_merge( $issues, (array) ( $external_risks['issues'] ?? array() ) );
        $scanned_items += (int) ( $external_risks['scanned_items'] ?? 0 );

        $error_log_scanner = new APG_Error_Log_Scanner();
        $error_logs = $error_log_scanner->scan();
        $issues = array_merge( $issues, (array) ( $error_logs['issues'] ?? array() ) );
        $scanned_items += (int) ( $error_logs['scanned_items'] ?? 0 );

        $usage_scanner = new APG_Widget_Usage_Scanner();
        $usage_map = $usage_scanner->scan( $elementor, $shortcodes );
        $scanned_items += (int) ( $usage_map['counts']['elementor_documents_scanned'] ?? 0 );
        $scanned_items += (int) ( $usage_map['counts']['shortcode_documents_scanned'] ?? 0 );
        $scanned_items += (int) ( $usage_map['counts']['elementor_widget_hits'] ?? 0 );
        $scanned_items += (int) ( $usage_map['counts']['shortcode_hits'] ?? 0 );

        $map_builder = new APG_Project_Map();
        $project_map = $map_builder->build( $plugins, $shortcodes, $elementor );

        if ( empty( $issues ) ) {
            $issues[] = APG_Utils::issue(
                'INFO',
                'Project Guard',
                'Quick Scan completed without critical/high findings from v1.0.4 checks',
                'Amaley Project Guard → Overview',
                'The foundation + usage map + deep Core integrity + external risk + error log scan did not detect blocking issues in its limited v1.0.4 scope.',
                'Continue with manual frontend/editor checks before making major changes.'
            );
        }

        $metrics = array(
            'scan_time_seconds' => round( microtime( true ) - $started_at, 4 ),
            'memory_delta_mb'   => round( ( memory_get_usage( true ) - $memory_start ) / 1048576, 3 ),
            'memory_peak_mb'    => round( memory_get_peak_usage( true ) / 1048576, 3 ),
            'scanned_items'     => $scanned_items,
        );

        return array(
            'meta' => array(
                'tool'          => 'Amaley Project Guard',
                'version'       => APG_VERSION,
                'mode'          => 'quick_scan',
                'generated_at'  => current_time( 'mysql' ),
                'generated_gmt' => current_time( 'mysql', true ),
                'safety_lock'   => 'Separate plugin. Read-only. No frontend output. No auto-fix. Manual scan only.',
            ),
            'summary' => array(
                'severity_counts' => APG_Utils::severity_counts( $issues ),
                'issue_count'      => count( $issues ),
            ),
            'metrics'      => $metrics,
            'issues'       => $issues,
            'plugins'      => $plugins,
            'amaley_core'  => $core_check,
            'shortcodes'   => $shortcodes,
            'elementor'    => $elementor,
            'woocommerce'     => $woocommerce,
            'core_integrity'  => $core_integrity,
            'external_risks'  => $external_risks,
            'error_logs'      => $error_logs,
            'usage_map'       => $usage_map,
            'project_map'  => $project_map,
        );
    }

    /**
     * Scan Amaley Core as a read-only external target.
     * No files/classes are included from Amaley Core.
     *
     * @param array<string,mixed> $plugins Plugin registry.
     * @param APG_Plugin_Registry $registry_scanner Registry scanner.
     * @return array<string,mixed>
     */
    private function scan_amaley_core_target( $plugins, $registry_scanner ) {
        $issues = array();
        $target = $registry_scanner->find_amaley_core( $plugins );
        $checks = array();
        $scanned_items = 0;

        if ( empty( $target ) ) {
            $issues[] = APG_Utils::issue(
                'INFO',
                'Amaley Core Target',
                'Amaley Core plugin was not detected as a scan target',
                'Installed plugins list',
                'Core-specific integrity checks are skipped. Project Guard remains separate and active.',
                'Ignore if Amaley Core is not installed in this environment; otherwise confirm the plugin folder/name.'
            );
            return array(
                'detected'      => false,
                'target'        => array(),
                'checks'        => $checks,
                'issues'        => $issues,
                'scanned_items' => 1,
                'separation'    => 'Project Guard did not include or call any Amaley Core file.',
            );
        }

        $file = (string) ( $target['file'] ?? '' );
        $abs_file = trailingslashit( WP_PLUGIN_DIR ) . $file;
        $base_dir = dirname( $abs_file );
        $active = ( isset( $target['status'] ) && 'active' === $target['status'] );
        $header_version = (string) ( $target['version'] ?? '' );
        $constant_version = defined( 'AMALEY_CORE_VERSION' ) ? (string) AMALEY_CORE_VERSION : '';

        $checks[] = array(
            'label'  => 'Detected plugin file',
            'status' => file_exists( $abs_file ) ? 'pass' : 'fail',
            'detail' => $file,
        );
        $scanned_items++;

        $checks[] = array(
            'label'  => 'Plugin status',
            'status' => $active ? 'active' : 'inactive',
            'detail' => $active ? 'Amaley Core is active' : 'Amaley Core is installed but inactive',
        );
        $scanned_items++;

        $checks[] = array(
            'label'  => 'Header version',
            'status' => '' !== $header_version ? 'pass' : 'warning',
            'detail' => '' !== $header_version ? $header_version : 'Header version missing',
        );
        $scanned_items++;

        $checks[] = array(
            'label'  => 'AMALEY_CORE_VERSION constant',
            'status' => '' !== $constant_version ? 'detected' : 'not_detected',
            'detail' => '' !== $constant_version ? $constant_version : 'Constant not available during this admin scan',
        );
        $scanned_items++;

        if ( $active && '' !== $constant_version && '' !== $header_version && $constant_version !== $header_version ) {
            $issues[] = APG_Utils::issue(
                'LOW',
                'Amaley Core Target',
                'Amaley Core header version and constant version differ',
                'Amaley Core plugin header / AMALEY_CORE_VERSION',
                'Version mismatch can confuse future debugging and handoff notes.',
                'Review version constant and plugin header in Amaley Core source before next GitHub sync.'
            );
        }

        $required_files = array(
            'includes/class-amaley-core.php',
            'includes/class-amaley-core-cpts.php',
            'includes/class-amaley-core-card-registry.php',
            'includes/class-amaley-core-card-renderer.php',
            'includes/class-amaley-core-cluster-single-sections.php',
            'includes/class-amaley-core-shg-single-sections.php',
            'includes/class-amaley-core-member-single-sections.php',
            'assets/amaley-core-cards.css',
        );

        foreach ( $required_files as $rel ) {
            $exists = file_exists( trailingslashit( $base_dir ) . $rel );
            $checks[] = array(
                'label'  => 'Required file: ' . $rel,
                'status' => $exists ? 'pass' : 'missing',
                'detail' => $exists ? 'Found' : 'Missing',
            );
            $scanned_items++;

            if ( ! $exists ) {
                $issues[] = APG_Utils::issue(
                    'CRITICAL',
                    'Amaley Core Target',
                    'Required Amaley Core file missing: ' . $rel,
                    $rel,
                    'A missing required file can break widgets, cards, sections, or plugin loading.',
                    'Restore the file from the locked Amaley Core backup/source before editing related modules.'
                );
            }
        }

        return array(
            'detected'          => true,
            'target'            => $target,
            'header_version'    => $header_version,
            'constant_version'  => $constant_version,
            'checks'            => $checks,
            'issues'            => $issues,
            'scanned_items'     => $scanned_items,
            'separation'        => 'Read-only target scan only. Project Guard does not include Amaley Core files, does not register inside Amaley Core menu, and does not depend on Amaley Core.',
        );
    }

    /**
     * Scan shortcodes.
     *
     * @return array<string,mixed>
     */
    private function scan_shortcodes() {
        global $shortcode_tags;

        $all = array();
        $amaley = array();

        foreach ( (array) $shortcode_tags as $tag => $callback ) {
            $callback_label = '';
            if ( is_string( $callback ) ) {
                $callback_label = $callback;
            } elseif ( is_array( $callback ) ) {
                $class = is_object( $callback[0] ?? null ) ? get_class( $callback[0] ) : (string) ( $callback[0] ?? '' );
                $method = (string) ( $callback[1] ?? '' );
                $callback_label = $class . '::' . $method;
            } elseif ( $callback instanceof Closure ) {
                $callback_label = 'Closure';
            }

            $row = array(
                'tag'      => (string) $tag,
                'callback' => $callback_label,
            );
            $all[] = $row;

            if ( false !== stripos( (string) $tag, 'amaley' ) || false !== stripos( $callback_label, 'Amaley' ) ) {
                $amaley[] = $row;
            }
        }

        usort( $all, function ( $a, $b ) { return strcasecmp( $a['tag'], $b['tag'] ); } );
        usort( $amaley, function ( $a, $b ) { return strcasecmp( $a['tag'], $b['tag'] ); } );

        return array(
            'total_count'  => count( $all ),
            'amaley_count' => count( $amaley ),
            'all'          => $all,
            'amaley'       => $amaley,
        );
    }
}
