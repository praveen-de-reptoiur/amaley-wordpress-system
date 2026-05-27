<?php
/**
 * Settings manager.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell_Settings {
    public const OPTION_KEY = 'amaley_shell_settings';

    /**
     * Init.
     *
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'install_defaults' ), 1 );
    }

    /**
     * Default settings.
     *
     * @return array
     */
    public static function defaults() {
        return array(
            'schema_version'        => 1,
            'enable_header'         => 1,
            'enable_footer'         => 1,
            'auto_render_header'    => 0,
            'auto_render_footer'    => 0,
            'hide_theme_header'     => 0,
            'hide_theme_footer'     => 0,
            'theme_header_selector' => '#apus-header, .apus-header, header.site-header, .site-header, .header-mobile, .header-default, .header-main',
            'theme_footer_selector' => '#apus-footer, .apus-footer, footer.site-footer, .site-footer, .footer-default, .footer-main',
            'show_announcement'     => 0,
            'announcement_text'     => 'Small-batch Himalayan products curated from community-rooted collectives.',
            'announcement_link'     => '/shop/',
            'logo_url'              => '',
            'logo_text'             => 'Amaley Collective',
            'logo_width_desktop'    => 148,
            'logo_width_tablet'     => 136,
            'logo_width_mobile'     => 120,
            'header_height'         => 82,
            'sticky_header'         => 1,
            'cta_text'              => 'Shop Now',
            'cta_link'              => '/shop/',
            'show_cta'              => 1,
            'show_cart'             => 1,
            'show_account'          => 0,
            'account_link'          => '/my-account/',
            'mobile_breakpoint'     => 980,
            'footer_logo_url'       => '',
            'footer_description'    => 'Himalayan products rooted in women collectives, producer families, natural ingredients, and small-batch community enterprise.',
            'contact_email'         => '',
            'contact_phone'         => '',
            'contact_whatsapp'      => '',
            'contact_address'       => '',
            'instagram_link'        => '',
            'facebook_link'         => '',
            'linkedin_link'         => '',
            'youtube_link'          => '',
            'copyright_text'        => '© Amaley Collective. All rights reserved.',
            'designed_by_text'      => 'Designed by Gram Connect Impact Technologies & Consulting LLP',
            'color_header_bg'       => '#fff8ee',
            'color_header_text'     => '#2e1203',
            'color_header_border'   => '#ead9c2',
            'color_accent'          => '#c2880a',
            'color_button_bg'       => '#2e1203',
            'color_button_text'     => '#fff8ee',
            'color_footer_bg'       => '#2e1203',
            'color_footer_text'     => '#fff8ee',
            'color_footer_muted'    => '#d9c5a6',
            'color_footer_link'     => '#f4dfb9',
            'font_heading'          => 'Playfair Display, Georgia, serif',
            'font_body'             => 'Lato, Arial, sans-serif',
            'nav_items'             => array(
                array( 'label' => 'Home', 'url' => '/', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 0, 'badge' => '' ),
                array( 'label' => 'Shop', 'url' => '/shop/', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 1, 'badge' => '' ),
                array( 'label' => 'Our Ecosystem', 'url' => '/ecosystem/', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 0, 'badge' => '' ),
                array( 'label' => 'Clusters', 'url' => '/clusters/', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 0, 'badge' => '' ),
                array( 'label' => 'Women Collectives', 'url' => '/women-collectives/', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 0, 'badge' => '' ),
                array( 'label' => 'About', 'url' => '/about/', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 0, 'badge' => '' ),
                array( 'label' => 'Contact', 'url' => '/contact/', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 0, 'badge' => '' ),
            ),
            'footer_columns'         => array(
                array(
                    'title' => 'Shop',
                    'links' => array(
                        array( 'label' => 'All Products', 'url' => '/shop/' ),
                        array( 'label' => 'Himalayan Foods', 'url' => '/product-category/himalayan-foods/' ),
                        array( 'label' => 'Ghee', 'url' => '/product-category/ghee/' ),
                        array( 'label' => 'Apricot', 'url' => '/product-category/apricot/' ),
                        array( 'label' => 'Seabuckthorn', 'url' => '/product-category/seabuckthorn/' ),
                    ),
                ),
                array(
                    'title' => 'Ecosystem',
                    'links' => array(
                        array( 'label' => 'Clusters', 'url' => '/clusters/' ),
                        array( 'label' => 'Women Collectives', 'url' => '/women-collectives/' ),
                        array( 'label' => 'Producer Families', 'url' => '/producers/' ),
                        array( 'label' => 'Traceability', 'url' => '/traceability/' ),
                    ),
                ),
                array(
                    'title' => 'About',
                    'links' => array(
                        array( 'label' => 'Our Story', 'url' => '/about/' ),
                        array( 'label' => 'Contact', 'url' => '/contact/' ),
                        array( 'label' => 'Gram Connect', 'url' => '/about-gram-connect/' ),
                    ),
                ),
            ),
        );
    }

    /**
     * Install default options only when absent.
     *
     * @return void
     */
    public static function install_defaults() {
        $existing = get_option( self::OPTION_KEY, null );
        if ( null === $existing || false === $existing ) {
            add_option( self::OPTION_KEY, self::defaults(), '', false );
            return;
        }

        if ( is_array( $existing ) ) {
            $merged = wp_parse_args( $existing, self::defaults() );
            update_option( self::OPTION_KEY, $merged, false );
        }
    }

    /**
     * Get all settings.
     *
     * @return array
     */
    public static function all() {
        $settings = get_option( self::OPTION_KEY, array() );
        if ( ! is_array( $settings ) ) {
            $settings = array();
        }
        return wp_parse_args( $settings, self::defaults() );
    }

    /**
     * Update settings.
     *
     * @param array $settings Settings.
     * @return void
     */
    public static function update( array $settings ) {
        update_option( self::OPTION_KEY, self::sanitize( $settings ), false );
    }

    /**
     * Get a value.
     *
     * @param string $key Key.
     * @param mixed  $default Default.
     * @return mixed
     */
    public static function get( $key, $default = null ) {
        $settings = self::all();
        return array_key_exists( $key, $settings ) ? $settings[ $key ] : $default;
    }

    /**
     * Get boolean.
     *
     * @param string $key Key.
     * @return bool
     */
    public static function get_bool( $key ) {
        return (bool) self::get( $key, 0 );
    }

    /**
     * Sanitize all settings.
     *
     * @param array $input Input.
     * @return array
     */
    public static function sanitize( array $input ) {
        $defaults = self::defaults();
        $clean    = array();

        foreach ( $defaults as $key => $default ) {
            if ( ! array_key_exists( $key, $input ) ) {
                $clean[ $key ] = is_bool( $default ) || is_int( $default ) ? 0 : $default;
                if ( is_array( $default ) ) {
                    $clean[ $key ] = $default;
                }
                continue;
            }

            $value = $input[ $key ];

            if ( is_int( $default ) ) {
                $clean[ $key ] = absint( $value );
            } elseif ( is_array( $default ) ) {
                if ( 'nav_items' === $key ) {
                    $clean[ $key ] = self::sanitize_nav_items( $value );
                } elseif ( 'footer_columns' === $key ) {
                    $clean[ $key ] = self::sanitize_footer_columns( $value );
                } else {
                    $clean[ $key ] = array();
                }
            } elseif ( false !== strpos( $key, 'url' ) || false !== strpos( $key, 'link' ) ) {
                $clean[ $key ] = esc_url_raw( $value );
            } elseif ( false !== strpos( $key, 'color_' ) ) {
                $clean[ $key ] = sanitize_hex_color( $value ) ?: $default;
            } elseif ( 'contact_email' === $key ) {
                $clean[ $key ] = sanitize_email( $value );
            } elseif ( in_array( $key, array( 'theme_header_selector', 'theme_footer_selector' ), true ) ) {
                $clean[ $key ] = self::sanitize_css_selector_list( $value );
            } else {
                $clean[ $key ] = sanitize_text_field( $value );
            }
        }

        $clean['schema_version'] = 1;
        return $clean;
    }


    /**
     * Sanitize a CSS selector list used only for optional staging theme-shell hiding.
     *
     * @param mixed $selector Selector list.
     * @return string
     */
    public static function sanitize_css_selector_list( $selector ) {
        $selector = is_scalar( $selector ) ? (string) $selector : '';
        $selector = wp_strip_all_tags( $selector );
        $selector = preg_replace( '/[^a-zA-Z0-9_\-#\.\,\s>\+~:\[\]=\"\'\(\)\*]/', '', $selector );
        $selector = preg_replace( '/\s+/', ' ', $selector );
        return trim( (string) $selector );
    }

    /**
     * Sanitize nav items.
     *
     * @param mixed $items Items.
     * @return array
     */
    public static function sanitize_nav_items( $items ) {
        $clean = array();
        if ( ! is_array( $items ) ) {
            return $clean;
        }
        foreach ( $items as $item ) {
            if ( ! is_array( $item ) ) {
                continue;
            }
            $label = isset( $item['label'] ) ? sanitize_text_field( $item['label'] ) : '';
            $url   = isset( $item['url'] ) ? esc_url_raw( $item['url'] ) : '';
            if ( '' === $label || '' === $url ) {
                continue;
            }
            $clean[] = array(
                'label'     => $label,
                'url'       => $url,
                'desktop'   => ! empty( $item['desktop'] ) ? 1 : 0,
                'mobile'    => ! empty( $item['mobile'] ) ? 1 : 0,
                'new_tab'   => ! empty( $item['new_tab'] ) ? 1 : 0,
                'highlight' => ! empty( $item['highlight'] ) ? 1 : 0,
                'badge'     => isset( $item['badge'] ) ? sanitize_text_field( $item['badge'] ) : '',
            );
        }
        return $clean;
    }

    /**
     * Sanitize footer columns.
     *
     * @param mixed $columns Columns.
     * @return array
     */
    public static function sanitize_footer_columns( $columns ) {
        $clean = array();
        if ( ! is_array( $columns ) ) {
            return $clean;
        }
        foreach ( $columns as $column ) {
            if ( ! is_array( $column ) ) {
                continue;
            }
            $title = isset( $column['title'] ) ? sanitize_text_field( $column['title'] ) : '';
            if ( '' === $title ) {
                continue;
            }
            $links = array();
            if ( isset( $column['links'] ) && is_array( $column['links'] ) ) {
                foreach ( $column['links'] as $link ) {
                    if ( ! is_array( $link ) ) {
                        continue;
                    }
                    $label = isset( $link['label'] ) ? sanitize_text_field( $link['label'] ) : '';
                    $url   = isset( $link['url'] ) ? esc_url_raw( $link['url'] ) : '';
                    if ( '' === $label || '' === $url ) {
                        continue;
                    }
                    $links[] = array( 'label' => $label, 'url' => $url );
                }
            }
            $clean[] = array( 'title' => $title, 'links' => $links );
        }
        return $clean;
    }
}
