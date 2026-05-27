<?php
/**
 * Import/export handler.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell_Import_Export {
    public static function init() {
        add_action( 'admin_init', array( __CLASS__, 'maybe_export' ) );
        add_action( 'admin_post_amaley_shell_import_settings', array( __CLASS__, 'import_settings' ) );
        add_action( 'admin_post_amaley_shell_reset_settings', array( __CLASS__, 'reset_settings' ) );
    }

    public static function maybe_export() {
        if ( empty( $_GET['amaley_shell_export'] ) ) {
            return;
        }
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to export settings.', 'amaley-site-shell' ) );
        }
        check_admin_referer( 'amaley_shell_export_settings' );

        $payload = array(
            'plugin'     => 'amaley-site-shell',
            'version'    => AMALEY_SHELL_VERSION,
            'exported'   => gmdate( 'c' ),
            'settings'   => Amaley_Shell_Settings::all(),
        );

        nocache_headers();
        header( 'Content-Type: application/json; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename="amaley-site-shell-settings-' . gmdate( 'Y-m-d' ) . '.json"' );
        echo wp_json_encode( $payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
        exit;
    }

    public static function import_settings() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to import settings.', 'amaley-site-shell' ) );
        }
        check_admin_referer( 'amaley_shell_import_settings' );

        $json = isset( $_POST['amaley_shell_import_json'] ) ? wp_unslash( $_POST['amaley_shell_import_json'] ) : '';
        $data = json_decode( $json, true );
        if ( ! is_array( $data ) || empty( $data['settings'] ) || ! is_array( $data['settings'] ) ) {
            wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-site-shell', 'tab' => 'import', 'amaley_shell_notice' => 'import_failed' ), admin_url( 'admin.php' ) ) );
            exit;
        }

        update_option( 'amaley_shell_settings_backup_' . time(), Amaley_Shell_Settings::all(), false );
        Amaley_Shell_Settings::update( $data['settings'] );

        wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-site-shell', 'tab' => 'import', 'amaley_shell_notice' => 'imported' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    public static function reset_settings() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to reset settings.', 'amaley-site-shell' ) );
        }
        check_admin_referer( 'amaley_shell_reset_settings' );

        update_option( 'amaley_shell_settings_backup_' . time(), Amaley_Shell_Settings::all(), false );
        update_option( Amaley_Shell_Settings::OPTION_KEY, Amaley_Shell_Settings::defaults(), false );

        wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-site-shell', 'tab' => 'import', 'amaley_shell_notice' => 'reset' ), admin_url( 'admin.php' ) ) );
        exit;
    }
}
