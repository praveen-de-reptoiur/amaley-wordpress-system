<?php
/**
 * Shortcodes.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell_Shortcodes {
    public static function init() {
        add_shortcode( 'amaley_site_header', array( __CLASS__, 'header' ) );
        add_shortcode( 'amaley_site_footer', array( __CLASS__, 'footer' ) );
    }

    public static function header() {
        return Amaley_Shell_Renderer::render_header();
    }

    public static function footer() {
        return Amaley_Shell_Renderer::render_footer();
    }
}
