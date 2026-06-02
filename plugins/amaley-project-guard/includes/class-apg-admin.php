<?php
/**
 * Admin UI.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Admin {

    /**
     * Render main page.
     *
     * @return void
     */
    public static function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $report = APG_Utils::get_last_report();
        $tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'overview'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $tabs = array(
            'overview'     => 'Overview',
            'project-map'  => 'Project Map',
            'plugins'      => 'Plugins',
            'checks'       => 'Core Target Checks',
            'elementor'    => 'Elementor',
            'usage-map'    => 'Usage Map',
            'woocommerce'  => 'WooCommerce',
            'reports'      => 'Reports',
        );

        if ( isset( $_GET['apg_notice'] ) && 'scan_done' === $_GET['apg_notice'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            echo '<div class="notice notice-success is-dismissible"><p><strong>Project Guard Quick Scan completed.</strong> Cached report updated. Frontend was not touched.</p></div>';
        }

        echo '<div class="wrap apg-wrap">';
        echo '<div class="apg-hero">';
        echo '<div><p class="apg-kicker">Separate Plugin · Read Only · Manual Scan</p>';
        echo '<h1>Amaley Project Guard</h1>';
        echo '<p class="apg-subtitle">Independent admin control room for project mapping, plugin status, safe checks and handoff reports. Not inside Amaley Core.</p></div>';
        echo '<div class="apg-actions">';
        self::render_scan_button();
        echo '</div></div>';

        echo '<div class="apg-safety-strip">';
        echo '<span>No frontend output</span><span>No auto-fix</span><span>No deletion</span><span>No plugin deactivation</span><span>No Core menu dependency</span>';
        echo '</div>';

        echo '<nav class="nav-tab-wrapper apg-tabs">';
        foreach ( $tabs as $key => $label ) {
            $url = admin_url( 'admin.php?page=amaley-project-guard&tab=' . $key );
            $class = $tab === $key ? ' nav-tab-active' : '';
            echo '<a class="nav-tab' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
        }
        echo '</nav>';

        if ( empty( $report ) ) {
            self::render_empty_state();
        } else {
            switch ( $tab ) {
                case 'project-map':
                    self::render_project_map( $report );
                    break;
                case 'plugins':
                    self::render_plugins( $report );
                    break;
                case 'checks':
                    self::render_core_checks( $report );
                    break;
                case 'elementor':
                    self::render_elementor( $report );
                    break;
                case 'usage-map':
                    self::render_usage_map( $report );
                    break;
                case 'woocommerce':
                    self::render_woocommerce( $report );
                    break;
                case 'reports':
                    self::render_reports( $report );
                    break;
                case 'overview':
                default:
                    self::render_overview( $report );
                    break;
            }
        }

        echo '</div>';
    }

    /** Render scan button. */
    private static function render_scan_button() {
        echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
        wp_nonce_field( 'apg_run_quick_scan' );
        echo '<input type="hidden" name="action" value="apg_run_quick_scan">';
        submit_button( 'Run Quick Scan', 'primary apg-primary', 'submit', false );
        echo '</form>';
    }

    /** Empty state. */
    private static function render_empty_state() {
        echo '<div class="apg-card apg-empty">';
        echo '<h2>No cached report yet</h2>';
        echo '<p>Click <strong>Run Quick Scan</strong>. The scan runs only when you click the button and stores a cached report for this admin page.</p>';
        echo '<p><strong>Safe behavior:</strong> this plugin does not attach to Amaley Core menu, does not load frontend assets, and does not change content/data.</p>';
        echo '</div>';
    }

    /** Overview. */
    private static function render_overview( $report ) {
        $counts = (array) ( $report['summary']['severity_counts'] ?? array() );
        echo '<div class="apg-grid apg-grid-5">';
        foreach ( array( 'CRITICAL', 'HIGH', 'MEDIUM', 'LOW', 'INFO' ) as $sev ) {
            echo '<div class="apg-stat apg-sev-' . esc_attr( strtolower( $sev ) ) . '"><span>' . esc_html( $sev ) . '</span><strong>' . esc_html( (string) ( $counts[ $sev ] ?? 0 ) ) . '</strong></div>';
        }
        echo '</div>';

        echo '<div class="apg-grid apg-grid-2">';
        echo '<div class="apg-card"><h2>Last Scan</h2>';
        echo '<p><strong>Generated:</strong> ' . esc_html( (string) ( $report['meta']['generated_at'] ?? '' ) ) . '</p>';
        echo '<p><strong>Mode:</strong> ' . esc_html( (string) ( $report['meta']['mode'] ?? '' ) ) . '</p>';
        echo '<p><strong>Version:</strong> ' . esc_html( (string) ( $report['meta']['version'] ?? APG_VERSION ) ) . '</p>';
        echo '<p><strong>Safety:</strong> ' . esc_html( (string) ( $report['meta']['safety_lock'] ?? '' ) ) . '</p>';
        echo '</div>';

        echo '<div class="apg-card"><h2>Scan Metrics</h2>';
        foreach ( (array) ( $report['metrics'] ?? array() ) as $key => $value ) {
            echo '<p><strong>' . esc_html( ucwords( str_replace( '_', ' ', $key ) ) ) . ':</strong> ' . esc_html( (string) $value ) . '</p>';
        }
        echo '</div></div>';

        self::render_issues_table( (array) ( $report['issues'] ?? array() ) );
    }

    /** Project map. */
    private static function render_project_map( $report ) {
        $nodes = (array) ( $report['project_map']['nodes'] ?? array() );
        echo '<div class="apg-card"><h2>Project Map</h2><p>Lightweight map generated from active WordPress APIs. This is read-only and does not modify Amaley Core.</p>';
        echo '<div class="apg-tree">';
        foreach ( $nodes as $key => $node ) {
            echo '<details open><summary>' . esc_html( (string) ( $node['label'] ?? $key ) ) . '</summary>';
            echo '<pre>' . esc_html( wp_json_encode( $node, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) ) . '</pre>';
            echo '</details>';
        }
        echo '</div></div>';
    }

    /** Plugins. */
    private static function render_plugins( $report ) {
        $plugins = (array) ( $report['plugins']['items'] ?? array() );
        echo '<div class="apg-card"><h2>Detected Plugins</h2>';
        self::render_assoc_summary( (array) ( $report['plugins']['counts'] ?? array() ) );
        echo '<table class="widefat striped"><thead><tr><th>Plugin</th><th>Version</th><th>Status</th><th>Group</th><th>File</th></tr></thead><tbody>';
        foreach ( $plugins as $plugin ) {
            echo '<tr>';
            echo '<td><strong>' . esc_html( (string) ( $plugin['name'] ?? '' ) ) . '</strong><br><span class="description">' . esc_html( (string) ( $plugin['description'] ?? '' ) ) . '</span></td>';
            echo '<td>' . esc_html( (string) ( $plugin['version'] ?? '' ) ) . '</td>';
            echo '<td>' . esc_html( (string) ( $plugin['status'] ?? '' ) ) . '</td>';
            echo '<td>' . esc_html( (string) ( $plugin['group'] ?? '' ) ) . '</td>';
            echo '<td><code>' . esc_html( (string) ( $plugin['file'] ?? '' ) ) . '</code></td>';
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    }

    /** Core checks. */
    private static function render_core_checks( $report ) {
        $core = (array) ( $report['amaley_core'] ?? array() );
        echo '<div class="apg-card"><h2>Amaley Core Target Checks</h2>';
        echo '<p><strong>Separation:</strong> ' . esc_html( (string) ( $core['separation'] ?? '' ) ) . '</p>';
        echo '<p><strong>Detected:</strong> ' . esc_html( ! empty( $core['detected'] ) ? 'Yes' : 'No' ) . '</p>';
        if ( ! empty( $core['target'] ) ) {
            echo '<p><strong>Target:</strong> ' . esc_html( (string) ( $core['target']['name'] ?? '' ) ) . ' — <code>' . esc_html( (string) ( $core['target']['file'] ?? '' ) ) . '</code></p>';
        }
        echo '<table class="widefat striped"><thead><tr><th>Check</th><th>Status</th><th>Detail</th></tr></thead><tbody>';
        foreach ( (array) ( $core['checks'] ?? array() ) as $check ) {
            echo '<tr><td>' . esc_html( (string) ( $check['label'] ?? '' ) ) . '</td><td>' . esc_html( (string) ( $check['status'] ?? '' ) ) . '</td><td>' . esc_html( (string) ( $check['detail'] ?? '' ) ) . '</td></tr>';
        }
        echo '</tbody></table></div>';
    }

    /** Elementor. */
    private static function render_elementor( $report ) {
        $elementor = (array) ( $report['elementor'] ?? array() );
        echo '<div class="apg-card"><h2>Elementor</h2>';
        echo '<p><strong>Active:</strong> ' . esc_html( ! empty( $elementor['active'] ) ? 'Yes' : 'No' ) . '</p>';
        echo '<p><strong>Widgets:</strong> ' . esc_html( (string) ( $elementor['widget_count'] ?? 0 ) ) . ' | <strong>Amaley Widgets:</strong> ' . esc_html( (string) ( $elementor['amaley_widgets'] ?? 0 ) ) . '</p>';
        echo '<h3>Amaley Widgets</h3><table class="widefat striped"><thead><tr><th>Name</th><th>Class</th></tr></thead><tbody>';
        foreach ( (array) ( $elementor['widgets'] ?? array() ) as $widget ) {
            if ( empty( $widget['is_amaley'] ) ) { continue; }
            echo '<tr><td>' . esc_html( (string) ( $widget['name'] ?? '' ) ) . '</td><td><code>' . esc_html( (string) ( $widget['class'] ?? '' ) ) . '</code></td></tr>';
        }
        echo '</tbody></table></div>';
    }


    /** Usage Map. */
    private static function render_usage_map( $report ) {
        $usage = (array) ( $report['usage_map'] ?? array() );
        $counts = (array) ( $usage['counts'] ?? array() );
        $widgets = (array) ( $usage['widgets'] ?? array() );
        $shortcodes = (array) ( $usage['shortcodes'] ?? array() );

        echo '<div class="apg-card"><h2>Usage Map</h2>';
        echo '<p><strong>Read-only scan:</strong> shows where Amaley widgets and shortcodes were found. This is for review only, not cleanup action.</p>';
        if ( ! empty( $usage['scope']['note'] ) ) {
            echo '<p class="description">' . esc_html( (string) $usage['scope']['note'] ) . '</p>';
        }
        self::render_assoc_summary( $counts );
        echo '</div>';

        echo '<div class="apg-usage-grid">';
        echo '<div class="apg-card apg-usage-section"><h2>Used Elementor Widgets</h2>';
        self::render_usage_rows( (array) ( $widgets['used'] ?? array() ), 'widget' );
        echo '</div>';

        echo '<div class="apg-card apg-usage-section"><h2>Used Shortcodes</h2>';
        self::render_usage_rows( (array) ( $shortcodes['used'] ?? array() ), 'shortcode' );
        echo '</div>';
        echo '</div>';

        echo '<div class="apg-usage-grid">';
        echo '<div class="apg-card apg-usage-section"><h2>Unused Widgets — Review Only</h2>';
        self::render_unused_rows( (array) ( $widgets['unused'] ?? array() ), 'widget' );
        echo '</div>';

        echo '<div class="apg-card apg-usage-section"><h2>Unused Shortcodes — Review Only</h2>';
        self::render_unused_rows( (array) ( $shortcodes['unused'] ?? array() ), 'shortcode' );
        echo '</div>';
        echo '</div>';
    }

    /**
     * Render usage rows.
     *
     * @param array<int,array<string,mixed>> $rows Rows.
     * @param string $type Type.
     * @return void
     */
    private static function render_usage_rows( $rows, $type ) {
        if ( empty( $rows ) ) {
            echo '<p>No usage found in this scan scope.</p>';
            return;
        }

        echo '<div class="apg-section-note">Compact view: open any row to see exact page/template usage. This is read-only.</div>';
        echo '<div class="apg-usage-accordion-list">';
        foreach ( $rows as $index => $row ) {
            $name       = 'shortcode' === $type ? (string) ( $row['tag'] ?? '' ) : (string) ( $row['name'] ?? '' );
            $count      = absint( $row['count'] ?? 0 );
            $detail     = ! empty( $row['class'] ) ? (string) $row['class'] : (string) ( $row['callback'] ?? '' );
            $item_count = count( (array) ( $row['items'] ?? array() ) );

            echo '<details class="apg-usage-accordion">';
            echo '<summary>';
            echo '<span class="apg-usage-summary-title"><strong>' . esc_html( $name ) . '</strong>';
            if ( '' !== $detail ) {
                echo '<code>' . esc_html( $detail ) . '</code>';
            }
            echo '</span>';
            echo '<span class="apg-count-pill">Used ' . esc_html( (string) $count ) . ' time(s)</span>';
            echo '</summary>';

            echo '<div class="apg-usage-locations apg-usage-locations-compact">';
            if ( 0 === $item_count ) {
                echo '<p>No exact page/template item stored for this row.</p>';
            }

            foreach ( (array) ( $row['items'] ?? array() ) as $item ) {
                $label     = '#' . (string) ( $item['id'] ?? '' ) . ' — ' . (string) ( $item['title'] ?? '' ) . ' (' . (string) ( $item['post_type'] ?? '' ) . ', ' . (string) ( $item['status'] ?? '' ) . ')';
                $edit_link = (string) ( $item['edit_link'] ?? '' );

                echo '<div class="apg-usage-item">';
                if ( '' !== $edit_link ) {
                    echo '<a href="' . esc_url( $edit_link ) . '">' . esc_html( $label ) . '</a>';
                } else {
                    echo esc_html( $label );
                }

                echo '<br><span class="description">Source: ' . esc_html( (string) ( $item['source'] ?? '' ) );
                if ( ! empty( $item['widget_id'] ) ) {
                    echo ' · Widget ID: ' . esc_html( (string) $item['widget_id'] );
                }
                echo '</span></div>';
            }

            echo '</div>';
            echo '</details>';
        }
        echo '</div>';
    }

    /**
     * Render unused rows.
     *
     * @param array<int,array<string,mixed>> $rows Rows.
     * @param string $type Type.
     * @return void
     */
    private static function render_unused_rows( $rows, $type ) {
        if ( empty( $rows ) ) {
            echo '<p>No unused items found in this scan scope.</p>';
            return;
        }

        echo '<div class="apg-section-note">Review-only list. Do not delete anything from here without manual confirmation.</div>';
        echo '<details class="apg-review-panel">';
        echo '<summary><strong>Show review-only unused list</strong><span class="apg-count-pill">' . esc_html( (string) count( $rows ) ) . ' item(s)</span></summary>';
        echo '<div class="apg-review-list">';
        foreach ( $rows as $row ) {
            $name   = 'shortcode' === $type ? (string) ( $row['tag'] ?? '' ) : (string) ( $row['name'] ?? '' );
            $detail = 'shortcode' === $type ? (string) ( $row['callback'] ?? '' ) : (string) ( $row['class'] ?? '' );
            echo '<div class="apg-review-item"><strong>' . esc_html( $name ) . '</strong><code>' . esc_html( $detail ) . '</code><span class="apg-review-status">' . esc_html( (string) ( $row['status'] ?? '' ) ) . '</span></div>';
        }
        echo '</div>';
        echo '</details>';
    }


    /** WooCommerce. */
    private static function render_woocommerce( $report ) {
        $wc = (array) ( $report['woocommerce'] ?? array() );
        echo '<div class="apg-card"><h2>WooCommerce</h2>';
        echo '<p><strong>Active:</strong> ' . esc_html( ! empty( $wc['active'] ) ? 'Yes' : 'No' ) . '</p>';
        echo '<table class="widefat striped"><thead><tr><th>Page</th><th>ID</th><th>Title</th><th>Status</th></tr></thead><tbody>';
        foreach ( (array) ( $wc['pages'] ?? array() ) as $key => $page ) {
            echo '<tr><td>' . esc_html( (string) $key ) . '</td><td>' . esc_html( (string) ( $page['id'] ?? '' ) ) . '</td><td>' . esc_html( (string) ( $page['title'] ?? '' ) ) . '</td><td>' . esc_html( (string) ( $page['status'] ?? '' ) ) . '</td></tr>';
        }
        echo '</tbody></table></div>';
    }

    /** Reports. */
    private static function render_reports( $report ) {
        echo '<div class="apg-card"><h2>Export Reports</h2>';
        echo '<p>Use these exports for GitHub notes, developer handoff, or ChatGPT debugging context.</p>';
        echo '<p><a class="button button-primary" href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=apg_export_markdown' ), 'apg_export_markdown' ) ) . '">Download Markdown Report</a> ';
        echo '<a class="button" href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=apg_export_json' ), 'apg_export_json' ) ) . '">Download JSON Report</a></p>';
        echo '<h3>Copy Debug Summary</h3>';
        $markdown = APG_Report_Exporter::build_markdown( $report );
        echo '<textarea class="apg-copy-box" readonly>' . esc_textarea( $markdown ) . '</textarea>';
        echo '</div>';
    }

    /** Render issues table. */
    private static function render_issues_table( $issues ) {
        echo '<div class="apg-card"><h2>Issue List</h2>';
        echo '<table class="widefat striped"><thead><tr><th>Severity</th><th>Area</th><th>Problem</th><th>Location</th><th>Impact</th><th>Suggested Action</th></tr></thead><tbody>';
        foreach ( $issues as $issue ) {
            echo '<tr>';
            echo '<td><span class="apg-badge apg-badge-' . esc_attr( strtolower( (string) ( $issue['severity'] ?? 'info' ) ) ) . '">' . esc_html( (string) ( $issue['severity'] ?? 'INFO' ) ) . '</span></td>';
            echo '<td>' . esc_html( (string) ( $issue['area'] ?? '' ) ) . '</td>';
            echo '<td><strong>' . esc_html( (string) ( $issue['problem'] ?? '' ) ) . '</strong></td>';
            echo '<td>' . esc_html( (string) ( $issue['location'] ?? '' ) ) . '</td>';
            echo '<td>' . esc_html( (string) ( $issue['impact'] ?? '' ) ) . '</td>';
            echo '<td>' . esc_html( (string) ( $issue['suggested_action'] ?? '' ) ) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    }

    /** Assoc summary. */
    private static function render_assoc_summary( $data ) {
        echo '<div class="apg-mini-summary">';
        foreach ( $data as $key => $value ) {
            echo '<span><strong>' . esc_html( ucwords( str_replace( '_', ' ', $key ) ) ) . '</strong> ' . esc_html( (string) $value ) . '</span>';
        }
        echo '</div>';
    }
}
