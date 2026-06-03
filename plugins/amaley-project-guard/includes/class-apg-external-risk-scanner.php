<?php
/**
 * External plugin conflict risk scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_External_Risk_Scanner {

    /**
     * Scan active external plugins for review-only risk categories.
     *
     * @param array<string,mixed> $plugins Plugin registry.
     * @return array<string,mixed>
     */
    public function scan( $plugins ) {
        $rows       = array();
        $issues     = array();
        $categories = array(
            'cache_performance'  => 0,
            'custom_code'        => 0,
            'filter_search'      => 0,
            'security_firewall'  => 0,
            'image_cdn'          => 0,
            'page_builder'       => 0,
            'woocommerce_addon'  => 0,
        );

        $active_external = array();
        foreach ( (array) ( $plugins['items'] ?? array() ) as $plugin ) {
            if ( 'active' !== (string) ( $plugin['status'] ?? '' ) ) {
                continue;
            }
            if ( 'amaley' === (string) ( $plugin['group'] ?? '' ) ) {
                continue;
            }
            $active_external[] = $plugin;
        }

        foreach ( $active_external as $plugin ) {
            $name = (string) ( $plugin['name'] ?? '' );
            $file = (string) ( $plugin['file'] ?? '' );
            $haystack = strtolower( $name . ' ' . $file . ' ' . (string) ( $plugin['description'] ?? '' ) );

            $matched = $this->match_category( $haystack );
            foreach ( $matched as $category => $meta ) {
                $categories[ $category ]++;
                $rows[] = array(
                    'category'         => $meta['label'],
                    'category_key'     => $category,
                    'risk'             => 'LOW',
                    'plugin'           => $name,
                    'file'             => $file,
                    'signal'           => $meta['signal'],
                    'why_it_matters'   => $meta['why'],
                    'manual_next_step' => $meta['step'],
                );

                $issues[] = APG_Utils::issue(
                    'LOW',
                    'External Plugin Risks',
                    'Potential ' . $meta['label'] . ' conflict area detected: ' . $name,
                    'Plugins → ' . $file,
                    $meta['why'],
                    $meta['step']
                );
            }
        }

        return array(
            'status'                  => empty( $rows ) ? 'pass' : 'review',
            'active_external_scanned' => count( $active_external ),
            'risk_rows'               => count( $rows ),
            'issue_count'             => count( $issues ),
            'categories'              => $categories,
            'rows'                    => $rows,
            'issues'                  => $issues,
            'safety'                  => 'Read-only warning scanner. No plugin activation, deactivation, deletion, file edit, setting change or auto-fix.',
            'scanned_items'           => count( $active_external ) + count( $rows ),
        );
    }

    /**
     * Match categories by plugin signal keywords.
     *
     * @param string $haystack Combined plugin string.
     * @return array<string,array<string,string>>
     */
    private function match_category( $haystack ) {
        $matches = array();

        if ( $this->contains_any( $haystack, array( 'cache', 'litespeed', 'wp rocket', 'autoptimize', 'perfmatters', 'minify', 'defer', 'optimization', 'speed' ) ) ) {
            $matches['cache_performance'] = array(
                'label'  => 'Cache / Performance',
                'signal' => 'cache, minify, defer, optimization',
                'why'    => 'Cache/minify/defer tools can sometimes delay or combine Elementor/WooCommerce/Amaley CSS and JS, causing card, filter or AJAX display issues after updates.',
                'step'   => 'If a visual/AJAX issue appears, temporarily exclude Amaley/Elementor/WooCommerce assets from minify/defer/cache. Do not deactivate automatically.',
            );
        }

        if ( $this->contains_any( $haystack, array( 'snippet', 'code snippet', 'custom code', 'functions', 'insert headers', 'wpcode' ) ) ) {
            $matches['custom_code'] = array(
                'label'  => 'Custom Code',
                'signal' => 'snippet or custom code plugin',
                'why'    => 'Custom snippets can alter hooks, templates, shortcodes, AJAX, product cards or Elementor behavior without being visible in Amaley source files.',
                'step'   => 'Review active snippets before editing Amaley plugin files. Disable only manually after backup and confirmation.',
            );
        }

        if ( $this->contains_any( $haystack, array( 'filter', 'search', 'ajax search', 'facet', 'jetsmartfilters', 'product filter' ) ) ) {
            $matches['filter_search'] = array(
                'label'  => 'Filter / Search',
                'signal' => 'filter, search or AJAX listing plugin',
                'why'    => 'Filter/search plugins may overlap with Amaley Discovery Engine queries, pagination, AJAX responses or WooCommerce loops.',
                'step'   => 'If search/filter behavior breaks, compare Discovery Engine filters with external filter plugin settings before code changes.',
            );
        }

        if ( $this->contains_any( $haystack, array( 'security', 'firewall', 'wordfence', 'ithemes security', 'sucuri', 'captcha', 'limit login' ) ) ) {
            $matches['security_firewall'] = array(
                'label'  => 'Security / Firewall',
                'signal' => 'security or firewall plugin',
                'why'    => 'Security plugins can block REST API, admin-ajax, nonce requests, file uploads or dashboard actions used by Elementor/WooCommerce/Amaley tools.',
                'step'   => 'If AJAX/admin scan actions fail, check firewall logs and whitelist safe admin/ajax endpoints manually.',
            );
        }

        if ( $this->contains_any( $haystack, array( 'image', 'cdn', 'lazy', 'webp', 'smush', 'shortpixel', 'imagify', 'cloudflare', 'optimole' ) ) ) {
            $matches['image_cdn'] = array(
                'label'  => 'Image / CDN / Lazy Load',
                'signal' => 'image optimization, CDN or lazy-load plugin',
                'why'    => 'Image/CDN/lazy-load plugins may affect product cards, producer images, gallery thumbnails or responsive image loading.',
                'step'   => 'If images appear blank/cropped/wrong, test by excluding Amaley card/gallery selectors from lazy-load/CDN rewriting.',
            );
        }

        if ( $this->contains_any( $haystack, array( 'elementor addon', 'elementor', 'essential addons', 'premium addons', 'happy addons', 'ultimate addons' ) ) ) {
            $matches['page_builder'] = array(
                'label'  => 'Page Builder Add-on',
                'signal' => 'Elementor add-on or builder extension',
                'why'    => 'Builder add-ons can register overlapping widgets, editor assets or frontend scripts that affect Elementor editing and Amaley widget behavior.',
                'step'   => 'If editor/widgets behave strangely, compare add-on widget names and scripts before editing Amaley widgets.',
            );
        }

        if ( $this->contains_any( $haystack, array( 'woocommerce', 'wishlist', 'compare', 'variation', 'cart', 'checkout', 'payment', 'shipping' ) ) ) {
            $matches['woocommerce_addon'] = array(
                'label'  => 'WooCommerce Add-on',
                'signal' => 'woocommerce',
                'why'    => 'WooCommerce add-ons can alter product cards, cart buttons, checkout flow, variation display, compare/wishlist buttons or template hooks.',
                'step'   => 'If product/card/cart behavior changes, review active WooCommerce add-ons and template hooks before editing Amaley templates.',
            );
        }

        return $matches;
    }

    /**
     * Check whether haystack contains any keyword.
     *
     * @param string $haystack Haystack.
     * @param array<int,string> $needles Needles.
     * @return bool
     */
    private function contains_any( $haystack, $needles ) {
        foreach ( $needles as $needle ) {
            if ( false !== strpos( $haystack, $needle ) ) {
                return true;
            }
        }
        return false;
    }
}
