<?php
/**
 * Plugin Name: Amaley Project Guard
 * Description: Read-only admin control room for Amaley project mapping, safe scans, and conflict intelligence. Separate from Amaley Core.
 * Version: 1.0.3
 * Author: Praveen
 * Text Domain: amaley-project-guard
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'APG_VERSION', '1.0.3' );
define( 'APG_FILE', __FILE__ );
define( 'APG_DIR', plugin_dir_path( __FILE__ ) );
define( 'APG_URL', plugin_dir_url( __FILE__ ) );
define( 'APG_OPTION_LAST_REPORT', 'apg_last_report_v103' );

/**
 * Frontend safety lock.
 * The plugin file is loaded by WordPress on all requests, but Project Guard registers
 * no frontend hooks, no frontend CSS, no frontend JS, and no frontend output.
 */
if ( ! is_admin() ) {
    return;
}

require_once APG_DIR . 'includes/class-apg-utils.php';
require_once APG_DIR . 'includes/class-apg-plugin.php';

APG_Plugin::instance();
