<?php
/**
 * Deep Amaley Core integrity scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Core_Integrity_Scanner {

    /**
     * Run read-only deep integrity checks against Amaley Core as a target.
     * This scanner never includes or edits Amaley Core files.
     *
     * @param array<string,mixed> $core_check Basic core check report.
     * @param array<string,mixed> $elementor Elementor scanner report.
     * @return array<string,mixed>
     */
    public function scan( $core_check, $elementor ) {
        $issues        = array();
        $checks        = array();
        $class_checks  = array();
        $method_checks = array();
        $asset_checks  = array();
        $widget_checks = array();
        $scanned_items = 0;

        if ( empty( $core_check['detected'] ) || empty( $core_check['target']['file'] ) ) {
            return array(
                'available'      => false,
                'summary'        => array(
                    'status' => 'skipped',
                    'note'   => 'Amaley Core was not detected; deep integrity checks skipped.',
                ),
                'checks'         => $checks,
                'class_checks'   => $class_checks,
                'method_checks'  => $method_checks,
                'asset_checks'   => $asset_checks,
                'widget_checks'  => $widget_checks,
                'issues'         => $issues,
                'scanned_items'  => 1,
                'safety'         => 'Read-only. No Amaley Core file include, edit, deactivate, delete or auto-fix.',
            );
        }

        $target_file = (string) $core_check['target']['file'];
        $base_dir    = dirname( trailingslashit( WP_PLUGIN_DIR ) . $target_file );

        $checks[] = array(
            'label'  => 'Deep scan mode',
            'status' => 'read_only',
            'detail' => 'v1.0.2 checks class/file/method/widget/asset signals without changing Amaley Core.',
        );
        $scanned_items++;

        $version_check = $this->scan_version_consistency( $core_check );
        $checks        = array_merge( $checks, $version_check['checks'] );
        $issues        = array_merge( $issues, $version_check['issues'] );
        $scanned_items += (int) $version_check['scanned_items'];

        $class_result  = $this->scan_required_classes( $base_dir );
        $class_checks  = $class_result['checks'];
        $issues        = array_merge( $issues, $class_result['issues'] );
        $scanned_items += (int) $class_result['scanned_items'];

        $method_result = $this->scan_required_methods();
        $method_checks = $method_result['checks'];
        $issues        = array_merge( $issues, $method_result['issues'] );
        $scanned_items += (int) $method_result['scanned_items'];

        $asset_result  = $this->scan_assets( $base_dir );
        $asset_checks  = $asset_result['checks'];
        $issues        = array_merge( $issues, $asset_result['issues'] );
        $scanned_items += (int) $asset_result['scanned_items'];

        $widget_result = $this->scan_widget_duplicates( $elementor );
        $widget_checks = $widget_result['checks'];
        $issues        = array_merge( $issues, $widget_result['issues'] );
        $scanned_items += (int) $widget_result['scanned_items'];

        return array(
            'available'      => true,
            'summary'        => array(
                'status'              => empty( $issues ) ? 'pass' : 'review',
                'class_checks'        => count( $class_checks ),
                'method_checks'       => count( $method_checks ),
                'asset_checks'        => count( $asset_checks ),
                'widget_checks'       => count( $widget_checks ),
                'issue_count'         => count( $issues ),
            ),
            'checks'         => $checks,
            'class_checks'   => $class_checks,
            'method_checks'  => $method_checks,
            'asset_checks'   => $asset_checks,
            'widget_checks'  => $widget_checks,
            'issues'         => $issues,
            'scanned_items'  => $scanned_items,
            'safety'         => 'Read-only. No Amaley Core file include, edit, deactivate, delete or auto-fix.',
        );
    }

    /**
     * Version consistency checks.
     *
     * @param array<string,mixed> $core_check Core report.
     * @return array<string,mixed>
     */
    private function scan_version_consistency( $core_check ) {
        $checks        = array();
        $issues        = array();
        $scanned_items = 0;

        $header_version   = (string) ( $core_check['header_version'] ?? '' );
        $constant_version = (string) ( $core_check['constant_version'] ?? '' );

        $status = 'not_available';
        $detail = 'Header or constant version not available during scan.';
        if ( '' !== $header_version && '' !== $constant_version ) {
            $status = ( $header_version === $constant_version ) ? 'pass' : 'mismatch';
            $detail = 'Header: ' . $header_version . ' | Constant: ' . $constant_version;
        }

        $checks[] = array(
            'label'  => 'Header version vs AMALEY_CORE_VERSION',
            'status' => $status,
            'detail' => $detail,
        );
        $scanned_items++;

        if ( 'mismatch' === $status ) {
            $issues[] = APG_Utils::issue(
                'LOW',
                'Amaley Core Integrity',
                'Amaley Core header version and constant version mismatch',
                'Amaley Core plugin header / AMALEY_CORE_VERSION',
                'Version mismatch can confuse future debugging, GitHub sync and handoff notes.',
                'Update either the plugin header or AMALEY_CORE_VERSION in Amaley Core only after backup and manual review.'
            );
        }

        return array(
            'checks'        => $checks,
            'issues'        => $issues,
            'scanned_items' => $scanned_items,
        );
    }

    /**
     * Required class checks.
     *
     * @param string $base_dir Amaley Core base dir.
     * @return array<string,mixed>
     */
    private function scan_required_classes( $base_dir ) {
        $checks        = array();
        $issues        = array();
        $scanned_items = 0;

        $required = array(
            array( 'label' => 'Core bootstrap', 'class' => 'Amaley_Core', 'file' => 'includes/class-amaley-core.php', 'severity' => 'HIGH' ),
            array( 'label' => 'CPT registration', 'class' => 'Amaley_Core_CPTs', 'file' => 'includes/class-amaley-core-cpts.php', 'severity' => 'HIGH' ),
            array( 'label' => 'Metaboxes', 'class' => 'Amaley_Core_Metaboxes', 'file' => 'includes/class-amaley-core-metaboxes.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Fields', 'class' => 'Amaley_Core_Fields', 'file' => 'includes/class-amaley-core-fields.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Card registry', 'class' => 'Amaley_Core_Card_Registry', 'file' => 'includes/class-amaley-core-card-registry.php', 'severity' => 'HIGH' ),
            array( 'label' => 'Card renderer', 'class' => 'Amaley_Core_Card_Renderer', 'file' => 'includes/class-amaley-core-card-renderer.php', 'severity' => 'HIGH' ),
            array( 'label' => 'Cluster archive sections', 'class' => 'Amaley_Core_Cluster_Archive_Sections', 'file' => 'includes/class-amaley-core-cluster-archive-sections.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Cluster single sections', 'class' => 'Amaley_Core_Cluster_Single_Sections', 'file' => 'includes/class-amaley-core-cluster-single-sections.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'SHG archive sections', 'class' => 'Amaley_Core_SHG_Archive_Sections', 'file' => 'includes/class-amaley-core-shg-archive-sections.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'SHG single sections', 'class' => 'Amaley_Core_SHG_Single_Sections', 'file' => 'includes/class-amaley-core-shg-single-sections.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Member archive sections', 'class' => 'Amaley_Core_Member_Archive_Sections', 'file' => 'includes/class-amaley-core-member-archive-sections.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Member single sections', 'class' => 'Amaley_Core_Member_Single_Sections', 'file' => 'includes/class-amaley-core-member-single-sections.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Product origin', 'class' => 'Amaley_Core_Product_Origin', 'file' => 'includes/class-amaley-core-product-origin.php', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Product origin panel', 'class' => 'Amaley_Core_Product_Origin_Panel', 'file' => 'includes/class-amaley-core-product-origin-panel.php', 'severity' => 'MEDIUM' ),
        );

        foreach ( $required as $item ) {
            $file_path = trailingslashit( $base_dir ) . $item['file'];
            $file_ok   = file_exists( $file_path );
            $class_ok  = class_exists( $item['class'], false );

            $status = 'pass';
            if ( ! $file_ok ) {
                $status = 'file_missing';
            } elseif ( ! $class_ok ) {
                $status = 'class_not_loaded';
            }

            $checks[] = array(
                'label'  => $item['label'],
                'class'  => $item['class'],
                'file'   => $item['file'],
                'status' => $status,
                'detail' => $file_ok ? ( $class_ok ? 'File exists and class loaded.' : 'File exists but class is not loaded during this admin scan.' ) : 'Required file missing.',
            );
            $scanned_items++;

            if ( 'file_missing' === $status ) {
                $issues[] = APG_Utils::issue(
                    (string) $item['severity'],
                    'Amaley Core Integrity',
                    'Required Amaley Core class file missing: ' . $item['file'],
                    $item['file'],
                    'Missing file can break related Amaley widgets, cards or origin sections.',
                    'Restore the file from locked Amaley Core source before editing dependent modules.'
                );
            } elseif ( 'class_not_loaded' === $status ) {
                $issues[] = APG_Utils::issue(
                    (string) $item['severity'],
                    'Amaley Core Integrity',
                    'Required Amaley Core class not loaded: ' . $item['class'],
                    $item['file'],
                    'The file exists, but the class was not available during scan. This may indicate include/order issue or unused module.',
                    'Check Amaley Core bootstrap include order only after backup. Do not auto-fix.'
                );
            }
        }

        return array(
            'checks'        => $checks,
            'issues'        => $issues,
            'scanned_items' => $scanned_items,
        );
    }

    /**
     * Required method checks for card/section classes.
     *
     * @return array<string,mixed>
     */
    private function scan_required_methods() {
        $checks        = array();
        $issues        = array();
        $scanned_items = 0;

        $required = array(
            'Amaley_Core_Card_Renderer' => array( 'render', 'render_product', 'render_shg', 'render_cluster', 'render_member' ),
            'Amaley_Core_Card_Registry' => array( 'card_families', 'card_presets', 'assignment_locations', 'default_assignments', 'get_assignment' ),
            'Amaley_Core_Cluster_Single_Sections' => array( 'render_hero', 'render_snapshot', 'render_shgs', 'render_producers', 'render_products' ),
            'Amaley_Core_SHG_Single_Sections' => array( 'render_hero', 'render_cluster', 'render_members', 'render_products' ),
            'Amaley_Core_Member_Single_Sections' => array( 'render_hero', 'render_shg', 'render_cluster', 'render_products' ),
            'Amaley_Core_Member_Archive_Sections' => array( 'render_grid', 'render_gallery' ),
        );

        foreach ( $required as $class => $methods ) {
            $class_loaded = class_exists( $class, false );
            foreach ( $methods as $method ) {
                $method_ok = $class_loaded && method_exists( $class, $method );
                $checks[] = array(
                    'class'  => $class,
                    'method' => $method,
                    'status' => $method_ok ? 'pass' : ( $class_loaded ? 'missing_method' : 'class_not_loaded' ),
                    'detail' => $method_ok ? 'Method available.' : ( $class_loaded ? 'Method missing from loaded class.' : 'Class not loaded; method check skipped.' ),
                );
                $scanned_items++;

                if ( ! $method_ok ) {
                    $issues[] = APG_Utils::issue(
                        'MEDIUM',
                        'Amaley Core Integrity',
                        'Expected method unavailable: ' . $class . '::' . $method . '()',
                        $class . '::' . $method . '()',
                        'A missing render/registry method may break card rendering or related Elementor sections.',
                        'Review the class source and recent changes after backup. Do not auto-fix from Project Guard.'
                    );
                }
            }
        }

        return array(
            'checks'        => $checks,
            'issues'        => $issues,
            'scanned_items' => $scanned_items,
        );
    }

    /**
     * Asset file and registration checks.
     *
     * @param string $base_dir Amaley Core base dir.
     * @return array<string,mixed>
     */
    private function scan_assets( $base_dir ) {
        $checks        = array();
        $issues        = array();
        $scanned_items = 0;

        $assets = array(
            array( 'label' => 'Universal card CSS', 'file' => 'assets/amaley-core-cards.css', 'handle' => 'amaley-core-cards', 'severity' => 'HIGH' ),
            array( 'label' => 'Cluster single CSS', 'file' => 'assets/amaley-core-cluster-single-sections.css', 'handle' => 'amaley-core-cluster-single-sections', 'severity' => 'MEDIUM' ),
            array( 'label' => 'SHG single CSS', 'file' => 'assets/amaley-core-shg-single-sections.css', 'handle' => 'amaley-core-shg-single-sections', 'severity' => 'MEDIUM' ),
            array( 'label' => 'Member single CSS', 'file' => 'assets/amaley-core-member-single-sections.css', 'handle' => 'amaley-core-member-single-sections', 'severity' => 'MEDIUM' ),
        );

        foreach ( $assets as $asset ) {
            $file_ok    = file_exists( trailingslashit( $base_dir ) . $asset['file'] );
            $registered = wp_style_is( $asset['handle'], 'registered' );
            $enqueued   = wp_style_is( $asset['handle'], 'enqueued' );

            $checks[] = array(
                'label'      => $asset['label'],
                'file'       => $asset['file'],
                'handle'     => $asset['handle'],
                'status'     => $file_ok ? 'file_found' : 'file_missing',
                'registered' => $registered ? 'yes' : 'no',
                'enqueued'   => $enqueued ? 'yes' : 'no',
                'detail'     => $file_ok ? 'File exists. Registration/enqueue can vary by admin/frontend context.' : 'Required/expected CSS file missing.',
            );
            $scanned_items++;

            if ( ! $file_ok ) {
                $issues[] = APG_Utils::issue(
                    (string) $asset['severity'],
                    'Amaley Core Integrity',
                    'Expected Amaley Core asset file missing: ' . $asset['file'],
                    $asset['file'],
                    'Missing CSS can break visual consistency of cards or related sections.',
                    'Restore the asset from locked Amaley Core source before changing widget/card layout.'
                );
            }
        }

        return array(
            'checks'        => $checks,
            'issues'        => $issues,
            'scanned_items' => $scanned_items,
        );
    }

    /**
     * Duplicate registered Elementor widget checks.
     *
     * @param array<string,mixed> $elementor Elementor report.
     * @return array<string,mixed>
     */
    private function scan_widget_duplicates( $elementor ) {
        $checks        = array();
        $issues        = array();
        $scanned_items = 0;
        $names         = array();

        foreach ( (array) ( $elementor['widgets'] ?? array() ) as $widget ) {
            if ( empty( $widget['is_amaley'] ) ) {
                continue;
            }
            $name = (string) ( $widget['name'] ?? '' );
            if ( '' === $name ) {
                continue;
            }
            if ( ! isset( $names[ $name ] ) ) {
                $names[ $name ] = array();
            }
            $names[ $name ][] = (string) ( $widget['class'] ?? '' );
        }

        foreach ( $names as $name => $classes ) {
            $unique_classes = array_values( array_unique( $classes ) );
            $status         = count( $classes ) > 1 ? 'duplicate_name' : 'pass';
            $checks[]       = array(
                'widget'  => $name,
                'status'  => $status,
                'classes' => implode( ', ', $unique_classes ),
                'count'   => count( $classes ),
            );
            $scanned_items++;

            if ( 'duplicate_name' === $status ) {
                $issues[] = APG_Utils::issue(
                    'HIGH',
                    'Amaley Core Integrity',
                    'Duplicate Amaley Elementor widget name registered: ' . $name,
                    'Elementor widget registry',
                    'Duplicate widget names can confuse Elementor editor controls and template rendering.',
                    'Check which plugin/class is registering this widget name. Do not deactivate plugins blindly.'
                );
            }
        }

        return array(
            'checks'        => $checks,
            'issues'        => $issues,
            'scanned_items' => $scanned_items,
        );
    }
}
