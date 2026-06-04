<?php
/**
 * Fatal / error / log scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Error_Log_Scanner {

    /** Maximum bytes to read from the end of debug.log. */
    const MAX_BYTES = 131072;

    /** Maximum grouped issue rows to convert into issue cards. */
    const MAX_ISSUES = 12;

    /**
     * Run read-only log scan.
     *
     * This scanner reads only a small recent tail of wp-content/debug.log.
     * It does not create, clear, delete, write, rotate, download publicly, or expose logs outside admin.
     *
     * @return array<string,mixed>
     */
    public function scan() {
        $log_path = trailingslashit( WP_CONTENT_DIR ) . 'debug.log';
        $summary  = array(
            'status'          => 'no_log',
            'debug_log_path'  => $log_path,
            'wp_debug'        => defined( 'WP_DEBUG' ) && WP_DEBUG ? 'enabled' : 'disabled_or_unknown',
            'wp_debug_log'    => defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ? 'enabled' : 'disabled_or_unknown',
            'max_bytes_read'  => self::MAX_BYTES,
            'lines_read'      => 0,
            'findings'        => 0,
            'grouped_findings'=> 0,
            'fatal_errors'    => 0,
            'parse_errors'    => 0,
            'warnings'        => 0,
            'deprecated'      => 0,
            'notices'         => 0,
            'amaley_related'  => 0,
        );
        $category_hits = array(
            'fatal'      => 0,
            'parse'      => 0,
            'warning'    => 0,
            'deprecated' => 0,
            'notice'     => 0,
            'other'      => 0,
        );
        $rows   = array();
        $issues = array();

        if ( ! file_exists( $log_path ) ) {
            $issues[] = APG_Utils::issue(
                'INFO',
                'Fatal / Error / Log Scanner',
                'debug.log file was not found in wp-content',
                'wp-content/debug.log',
                'No recent WordPress debug log could be reviewed. This is normal when debug logging is disabled or no errors have been logged.',
                'No action needed. If a critical issue appears later, enable WP_DEBUG_LOG temporarily on staging or during a controlled support check.'
            );

            return $this->build_result( $summary, $category_hits, $rows, $issues, 1 );
        }

        if ( ! is_readable( $log_path ) ) {
            $summary['status'] = 'unreadable';
            $issues[] = APG_Utils::issue(
                'LOW',
                'Fatal / Error / Log Scanner',
                'debug.log exists but Project Guard cannot read it',
                'wp-content/debug.log',
                'File permissions may prevent admin-side error review from Project Guard.',
                'Review file permissions manually through hosting/file manager. Do not change permissions blindly on live without backup.'
            );

            return $this->build_result( $summary, $category_hits, $rows, $issues, 1 );
        }

        $content = $this->read_recent_log_tail( $log_path, self::MAX_BYTES );
        if ( '' === trim( $content ) ) {
            $summary['status'] = 'empty';
            $issues[] = APG_Utils::issue(
                'INFO',
                'Fatal / Error / Log Scanner',
                'debug.log is readable but currently empty',
                'wp-content/debug.log',
                'No logged PHP issues were found in the recent log window.',
                'No action needed. Keep monitoring after plugin/theme updates.'
            );

            return $this->build_result( $summary, $category_hits, $rows, $issues, 1 );
        }

        $lines = preg_split( '/\r\n|\r|\n/', $content );
        $lines = is_array( $lines ) ? array_values( array_filter( $lines, 'strlen' ) ) : array();
        $summary['lines_read'] = count( $lines );

        $groups = array();
        foreach ( $lines as $line ) {
            $parsed = $this->parse_log_line( $line );
            if ( empty( $parsed ) ) {
                continue;
            }

            $summary['findings']++;
            $category = (string) $parsed['category'];
            if ( ! isset( $category_hits[ $category ] ) ) {
                $category_hits[ $category ] = 0;
            }
            $category_hits[ $category ]++;

            if ( 'fatal' === $category ) {
                $summary['fatal_errors']++;
            } elseif ( 'parse' === $category ) {
                $summary['parse_errors']++;
            } elseif ( 'warning' === $category ) {
                $summary['warnings']++;
            } elseif ( 'deprecated' === $category ) {
                $summary['deprecated']++;
            } elseif ( 'notice' === $category ) {
                $summary['notices']++;
            }

            if ( ! empty( $parsed['amaley_related'] ) ) {
                $summary['amaley_related']++;
            }

            $signature = $this->build_signature( $parsed );
            if ( ! isset( $groups[ $signature ] ) ) {
                $groups[ $signature ] = $parsed;
                $groups[ $signature ]['count'] = 0;
            }
            $groups[ $signature ]['count']++;
            $groups[ $signature ]['last_seen'] = (string) $parsed['timestamp'];
        }

        $summary['grouped_findings'] = count( $groups );
        $summary['status'] = empty( $groups ) ? 'clean' : 'review';

        foreach ( $groups as $group ) {
            $rows[] = array(
                'severity'         => (string) $group['severity'],
                'type'             => (string) $group['type'],
                'count'            => (string) $group['count'],
                'last_seen'        => (string) $group['last_seen'],
                'file'             => (string) $group['file'],
                'line'             => (string) $group['line'],
                'message'          => APG_Utils::limit_text( (string) $group['message'], 170 ),
                'related_to'       => ! empty( $group['amaley_related'] ) ? 'Amaley / Project Guard' : (string) $group['related_to'],
                'suggested_action' => $this->suggest_action( $group ),
            );
        }

        usort( $rows, array( $this, 'sort_rows_by_severity' ) );

        $issue_rows = array_slice( $rows, 0, self::MAX_ISSUES );
        foreach ( $issue_rows as $row ) {
            $issues[] = APG_Utils::issue(
                (string) $row['severity'],
                'Fatal / Error / Log Scanner',
                (string) $row['type'] . ' detected in recent debug.log: ' . APG_Utils::limit_text( (string) $row['message'], 100 ),
                (string) $row['file'] . ( '' !== (string) $row['line'] ? ' line ' . (string) $row['line'] : '' ),
                'This is a recent grouped log finding. It may be historical if the log was not cleared after an older issue.',
                (string) $row['suggested_action']
            );
        }

        if ( count( $rows ) > self::MAX_ISSUES ) {
            $issues[] = APG_Utils::issue(
                'LOW',
                'Fatal / Error / Log Scanner',
                'Additional grouped log findings were hidden from issue cards for safety',
                'wp-content/debug.log recent tail',
                'Too many log groups can make the dashboard noisy and hard to review.',
                'Open the Error Logs tab and review the grouped table. Do not delete/clear logs before taking a backup.'
            );
        }

        if ( empty( $issues ) ) {
            $issues[] = APG_Utils::issue(
                'INFO',
                'Fatal / Error / Log Scanner',
                'No PHP error patterns detected in recent debug.log tail',
                'wp-content/debug.log recent tail',
                'The safe recent log scan did not detect fatal, parse, warning, deprecated or notice patterns.',
                'No action needed. Continue normal manual testing.'
            );
        }

        return $this->build_result( $summary, $category_hits, $rows, $issues, count( $lines ) );
    }

    /**
     * Build result array.
     *
     * @param array<string,mixed> $summary Summary.
     * @param array<string,int>   $category_hits Category hits.
     * @param array<int,array<string,string>> $rows Rows.
     * @param array<int,array<string,string>> $issues Issues.
     * @param int $scanned_items Scanned items.
     * @return array<string,mixed>
     */
    private function build_result( $summary, $category_hits, $rows, $issues, $scanned_items ) {
        return array(
            'available'     => true,
            'summary'       => $summary,
            'category_hits' => $category_hits,
            'rows'          => $rows,
            'issues'        => $issues,
            'scanned_items' => $scanned_items,
            'safety'        => 'Read-only recent log scanner. No log deletion, no log clearing, no public output, no auto-fix, no plugin deactivation.',
        );
    }

    /**
     * Read only a recent tail of a log file.
     *
     * @param string $path File path.
     * @param int    $max_bytes Maximum bytes.
     * @return string
     */
    private function read_recent_log_tail( $path, $max_bytes ) {
        $size = filesize( $path );
        if ( false === $size || 0 === $size ) {
            return '';
        }

        $handle = fopen( $path, 'rb' );
        if ( false === $handle ) {
            return '';
        }

        $offset = max( 0, (int) $size - (int) $max_bytes );
        if ( $offset > 0 ) {
            fseek( $handle, $offset );
            fgets( $handle ); // Drop partial first line when reading from middle.
        }

        $content = stream_get_contents( $handle );
        fclose( $handle );

        return false === $content ? '' : (string) $content;
    }

    /**
     * Parse one debug log line.
     *
     * @param string $line Log line.
     * @return array<string,mixed>
     */
    private function parse_log_line( $line ) {
        $line = trim( (string) $line );
        if ( '' === $line ) {
            return array();
        }

        $timestamp = '';
        $message   = $line;
        if ( preg_match( '/^\[([^\]]+)\]\s*(.*)$/', $line, $matches ) ) {
            $timestamp = (string) $matches[1];
            $message   = (string) $matches[2];
        }

        $type = '';
        if ( preg_match( '/PHP\s+(Fatal error|Parse error|Warning|Deprecated|Notice|Recoverable fatal error)\s*:\s*(.*)$/i', $message, $matches ) ) {
            $type    = (string) $matches[1];
            $message = (string) $matches[2];
        } elseif ( preg_match( '/(Fatal error|Parse error|Warning|Deprecated|Notice)\s*:\s*(.*)$/i', $message, $matches ) ) {
            $type    = (string) $matches[1];
            $message = (string) $matches[2];
        } else {
            return array();
        }

        $file = '';
        $line_no = '';
        if ( preg_match( '/\sin\s+(.+?)\s+on\s+line\s+(\d+)/i', $message, $matches ) ) {
            $file    = (string) $matches[1];
            $line_no = (string) $matches[2];
        }

        $category = $this->category_from_type( $type );
        $severity = $this->severity_from_category( $category );
        $related_to = $this->related_area( $line . ' ' . $file );
        $amaley_related = ( false !== stripos( $line . ' ' . $file, 'amaley' ) || false !== stripos( $line . ' ' . $file, 'project-guard' ) );

        return array(
            'timestamp'      => $timestamp,
            'type'           => $type,
            'category'       => $category,
            'severity'       => $severity,
            'file'           => $file,
            'line'           => $line_no,
            'message'        => $message,
            'related_to'     => $related_to,
            'amaley_related' => $amaley_related,
        );
    }

    /** Category from type. */
    private function category_from_type( $type ) {
        $type = strtolower( (string) $type );
        if ( false !== strpos( $type, 'fatal' ) ) {
            return 'fatal';
        }
        if ( false !== strpos( $type, 'parse' ) ) {
            return 'parse';
        }
        if ( false !== strpos( $type, 'warning' ) ) {
            return 'warning';
        }
        if ( false !== strpos( $type, 'deprecated' ) ) {
            return 'deprecated';
        }
        if ( false !== strpos( $type, 'notice' ) ) {
            return 'notice';
        }
        return 'other';
    }

    /** Severity from category. */
    private function severity_from_category( $category ) {
        if ( 'fatal' === $category || 'parse' === $category ) {
            return 'HIGH';
        }
        if ( 'warning' === $category ) {
            return 'MEDIUM';
        }
        if ( 'deprecated' === $category || 'notice' === $category ) {
            return 'LOW';
        }
        return 'INFO';
    }

    /** Related area from text. */
    private function related_area( $text ) {
        $text = strtolower( (string) $text );
        if ( false !== strpos( $text, 'amaley-project-guard' ) || false !== strpos( $text, 'project guard' ) ) {
            return 'Amaley Project Guard';
        }
        if ( false !== strpos( $text, 'amaley-core' ) ) {
            return 'Amaley Core';
        }
        if ( false !== strpos( $text, 'amaley-discovery' ) ) {
            return 'Amaley Discovery Engine';
        }
        if ( false !== strpos( $text, 'woocommerce' ) ) {
            return 'WooCommerce';
        }
        if ( false !== strpos( $text, 'elementor' ) ) {
            return 'Elementor';
        }
        if ( false !== strpos( $text, 'themes/' ) || false !== strpos( $text, '/themes/' ) ) {
            return 'Theme';
        }
        return 'Unknown / External';
    }

    /** Build grouping signature. */
    private function build_signature( $parsed ) {
        $message = preg_replace( '/\s+/', ' ', (string) ( $parsed['message'] ?? '' ) );
        $message = substr( (string) $message, 0, 140 );
        return md5( (string) ( $parsed['category'] ?? '' ) . '|' . (string) ( $parsed['file'] ?? '' ) . '|' . $message );
    }

    /** Suggested action for group. */
    private function suggest_action( $group ) {
        $category = (string) ( $group['category'] ?? '' );
        $related  = (string) ( $group['related_to'] ?? '' );

        if ( 'fatal' === $category || 'parse' === $category ) {
            return 'Take backup, note exact file/line, then inspect the related plugin/theme source. Do not edit live files blindly.';
        }
        if ( 'warning' === $category ) {
            return 'Review the exact file/line and reproduce the related page/admin action before changing code.';
        }
        if ( 'deprecated' === $category ) {
            return 'Plan compatibility cleanup later. This is usually not urgent unless it repeats heavily or affects output.';
        }
        if ( 'notice' === $category ) {
            return 'Review during cleanup. Do not prioritise above fatal/warning issues unless repeated on key pages.';
        }
        if ( '' !== $related ) {
            return 'Review this grouped log row manually before making changes.';
        }
        return 'Review manually. Keep logs as evidence until issue is understood.';
    }

    /** Sort rows by severity. */
    private function sort_rows_by_severity( $a, $b ) {
        $rank = array( 'CRITICAL' => 0, 'HIGH' => 1, 'MEDIUM' => 2, 'LOW' => 3, 'INFO' => 4 );
        $sa = isset( $rank[ (string) ( $a['severity'] ?? 'INFO' ) ] ) ? $rank[ (string) ( $a['severity'] ?? 'INFO' ) ] : 4;
        $sb = isset( $rank[ (string) ( $b['severity'] ?? 'INFO' ) ] ) ? $rank[ (string) ( $b['severity'] ?? 'INFO' ) ] : 4;
        if ( $sa === $sb ) {
            return 0;
        }
        return ( $sa < $sb ) ? -1 : 1;
    }
}
