<?php
/**
 * Report exporter.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Report_Exporter {

    /**
     * Export Markdown.
     *
     * @return void
     */
    public static function export_markdown() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'amaley-project-guard' ) );
        }
        check_admin_referer( 'apg_export_markdown' );

        $report = APG_Utils::get_last_report();
        if ( empty( $report ) ) {
            wp_die( esc_html__( 'No Project Guard report available yet. Run Quick Scan first.', 'amaley-project-guard' ) );
        }

        $content = self::build_markdown( $report );
        self::download_text( 'amaley-project-guard-report-v' . APG_VERSION . '.md', $content, 'text/markdown' );
    }

    /**
     * Export JSON.
     *
     * @return void
     */
    public static function export_json() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Permission denied.', 'amaley-project-guard' ) );
        }
        check_admin_referer( 'apg_export_json' );

        $report = APG_Utils::get_last_report();
        if ( empty( $report ) ) {
            wp_die( esc_html__( 'No Project Guard report available yet. Run Quick Scan first.', 'amaley-project-guard' ) );
        }

        $content = wp_json_encode( $report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
        self::download_text( 'amaley-project-guard-report-v' . APG_VERSION . '.json', $content, 'application/json' );
    }

    /**
     * Build Markdown report.
     *
     * @param array<string,mixed> $report Report.
     * @return string
     */
    public static function build_markdown( $report ) {
        $lines = array();
        $lines[] = '# Amaley Project Guard Report';
        $lines[] = '';
        $lines[] = '- Version: ' . ( $report['meta']['version'] ?? APG_VERSION );
        $lines[] = '- Mode: ' . ( $report['meta']['mode'] ?? 'quick_scan' );
        $lines[] = '- Generated: ' . ( $report['meta']['generated_at'] ?? '' );
        $lines[] = '- Safety Lock: ' . ( $report['meta']['safety_lock'] ?? '' );
        $lines[] = '';
        $lines[] = '## Metrics';
        foreach ( (array) ( $report['metrics'] ?? array() ) as $key => $value ) {
            $lines[] = '- ' . $key . ': ' . $value;
        }
        $lines[] = '';
        $lines[] = '## Severity Counts';
        foreach ( (array) ( $report['summary']['severity_counts'] ?? array() ) as $severity => $count ) {
            $lines[] = '- ' . $severity . ': ' . $count;
        }
        $lines[] = '';
        $lines[] = '## Issues';
        foreach ( (array) ( $report['issues'] ?? array() ) as $issue ) {
            $lines[] = '### [' . ( $issue['severity'] ?? 'INFO' ) . '] ' . ( $issue['problem'] ?? '' );
            $lines[] = '- Area: ' . ( $issue['area'] ?? '' );
            $lines[] = '- Location: ' . ( $issue['location'] ?? '' );
            $lines[] = '- Impact: ' . ( $issue['impact'] ?? '' );
            $lines[] = '- Suggested Action: ' . ( $issue['suggested_action'] ?? '' );
            $lines[] = '';
        }
        $lines[] = '## Plugin Summary';
        foreach ( (array) ( $report['plugins']['counts'] ?? array() ) as $key => $value ) {
            $lines[] = '- ' . $key . ': ' . $value;
        }
        $lines[] = '';
        $lines[] = '';
        $lines[] = '## Usage Map Summary';
        foreach ( (array) ( $report['usage_map']['counts'] ?? array() ) as $key => $value ) {
            $lines[] = '- ' . $key . ': ' . $value;
        }
        $lines[] = '';
        $lines[] = '## Deep Amaley Core Integrity Summary';
        foreach ( (array) ( $report['core_integrity']['summary'] ?? array() ) as $key => $value ) {
            $lines[] = '- ' . $key . ': ' . $value;
        }
        $lines[] = '';
        $lines[] = '## Amaley Core Target Separation';
        $lines[] = (string) ( $report['amaley_core']['separation'] ?? 'Not available' );
        $lines[] = '';

        return implode( "\n", $lines );
    }

    /**
     * Download text.
     *
     * @param string $filename File name.
     * @param string $content Content.
     * @param string $content_type Content type.
     * @return void
     */
    private static function download_text( $filename, $content, $content_type ) {
        nocache_headers();
        header( 'Content-Type: ' . $content_type . '; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename="' . sanitize_file_name( $filename ) . '"' );
        echo (string) $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- export file content.
        exit;
    }
}
