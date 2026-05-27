<?php
/**
 * Asset manager.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell_Assets {
    /** Init hooks. */
    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_frontend_assets' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_assets' ) );
    }

    /** Register frontend assets. */
    public static function register_frontend_assets() {
        wp_register_style(
            'amaley-site-shell',
            AMALEY_SHELL_URL . 'assets/css/amaley-site-shell.css',
            array(),
            AMALEY_SHELL_VERSION
        );

        wp_register_script(
            'amaley-site-shell',
            AMALEY_SHELL_URL . 'assets/js/amaley-site-shell.js',
            array(),
            AMALEY_SHELL_VERSION,
            true
        );
    }

    /** Enqueue frontend assets when output renders. */
    public static function enqueue_frontend() {
        if ( ! wp_style_is( 'amaley-site-shell', 'registered' ) ) {
            self::register_frontend_assets();
        }
        wp_enqueue_style( 'amaley-site-shell' );
        wp_enqueue_script( 'amaley-site-shell' );

        $settings = Amaley_Shell_Settings::all();
        $css      = self::build_css_variables( $settings );
        if ( $css ) {
            wp_add_inline_style( 'amaley-site-shell', $css );
        }
    }

    /**
     * Build scoped CSS variables.
     *
     * @param array $settings Settings.
     * @return string
     */
    private static function build_css_variables( array $settings ) {
        $logo_desktop = absint( $settings['logo_width_desktop'] ?? 148 );
        $logo_tablet  = absint( $settings['logo_width_tablet'] ?? 136 );
        $logo_mobile  = absint( $settings['logo_width_mobile'] ?? 120 );
        $height       = absint( $settings['header_height'] ?? 82 );
        $breakpoint   = absint( $settings['mobile_breakpoint'] ?? 980 );

        $css = ':root{';
        $css .= '--amaley-shell-header-bg:' . esc_html( $settings['color_header_bg'] ?? '#fff8ee' ) . ';';
        $css .= '--amaley-shell-header-text:' . esc_html( $settings['color_header_text'] ?? '#2e1203' ) . ';';
        $css .= '--amaley-shell-header-border:' . esc_html( $settings['color_header_border'] ?? '#ead9c2' ) . ';';
        $css .= '--amaley-shell-accent:' . esc_html( $settings['color_accent'] ?? '#c2880a' ) . ';';
        $css .= '--amaley-shell-button-bg:' . esc_html( $settings['color_button_bg'] ?? '#2e1203' ) . ';';
        $css .= '--amaley-shell-button-text:' . esc_html( $settings['color_button_text'] ?? '#fff8ee' ) . ';';
        $css .= '--amaley-shell-footer-bg:' . esc_html( $settings['color_footer_bg'] ?? '#2e1203' ) . ';';
        $css .= '--amaley-shell-footer-text:' . esc_html( $settings['color_footer_text'] ?? '#fff8ee' ) . ';';
        $css .= '--amaley-shell-footer-muted:' . esc_html( $settings['color_footer_muted'] ?? '#d9c5a6' ) . ';';
        $css .= '--amaley-shell-footer-link:' . esc_html( $settings['color_footer_link'] ?? '#f4dfb9' ) . ';';
        $css .= '--amaley-shell-heading-font:' . esc_html( $settings['font_heading'] ?? 'Georgia, serif' ) . ';';
        $css .= '--amaley-shell-body-font:' . esc_html( $settings['font_body'] ?? 'Arial, sans-serif' ) . ';';
        $css .= '--amaley-shell-logo-desktop:' . $logo_desktop . 'px;';
        $css .= '--amaley-shell-logo-tablet:' . $logo_tablet . 'px;';
        $css .= '--amaley-shell-logo-mobile:' . $logo_mobile . 'px;';
        $css .= '--amaley-shell-header-height:' . $height . 'px;';
        $css .= '}';
        $css .= '@media(max-width:' . $breakpoint . 'px){.amaley-shell-desktop-nav,.amaley-shell-header-actions{display:none!important}.amaley-shell-mobile-toggle{display:inline-flex!important}}';
        $css .= '@media(min-width:' . ( $breakpoint + 1 ) . 'px){.amaley-shell-mobile-toggle{display:none!important}}';

        if ( ! empty( $settings['hide_theme_header'] ) ) {
            $selector = ! empty( $settings['theme_header_selector'] ) ? $settings['theme_header_selector'] : '#apus-header, .apus-header, header.site-header, .site-header';
            $css     .= self::prefix_selector_list( 'body.amaley-shell-hide-theme-header', $selector ) . '{display:none!important;visibility:hidden!important;height:0!important;min-height:0!important;overflow:hidden!important;}';
        }

        if ( ! empty( $settings['hide_theme_footer'] ) ) {
            $selector = ! empty( $settings['theme_footer_selector'] ) ? $settings['theme_footer_selector'] : '#apus-footer, .apus-footer, footer.site-footer, .site-footer';
            $css     .= self::prefix_selector_list( 'body.amaley-shell-hide-theme-footer', $selector ) . '{display:none!important;visibility:hidden!important;height:0!important;min-height:0!important;overflow:hidden!important;}';
        }

        return $css;
    }


    /**
     * Prefix every selector in a comma-separated selector list.
     *
     * @param string $prefix Prefix selector.
     * @param string $selector_list Selector list.
     * @return string
     */
    private static function prefix_selector_list( $prefix, $selector_list ) {
        $selectors = array_filter( array_map( 'trim', explode( ',', (string) $selector_list ) ) );
        if ( empty( $selectors ) ) {
            return '';
        }
        $prefixed = array();
        foreach ( $selectors as $selector ) {
            $prefixed[] = trim( $prefix . ' ' . $selector );
        }
        return implode( ',', $prefixed );
    }

    /** Admin assets. */
    public static function admin_assets( $hook ) {
        if ( false === strpos( (string) $hook, 'amaley-site-shell' ) ) {
            return;
        }
        wp_enqueue_style(
            'amaley-site-shell-admin',
            AMALEY_SHELL_URL . 'assets/css/amaley-site-shell-admin.css',
            array(),
            AMALEY_SHELL_VERSION
        );
    }
}
