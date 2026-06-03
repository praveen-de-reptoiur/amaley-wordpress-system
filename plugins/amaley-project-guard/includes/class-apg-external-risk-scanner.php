<?php
/**
 * External plugin conflict/risk scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_External_Risk_Scanner {

    /**
     * Run read-only external plugin risk scan.
     *
     * This scanner does not disable, edit, delete or configure any plugin. It only flags
     * possible conflict areas for manual review.
     *
     * @param array<string,mixed> $plugins Plugin registry.
     * @return array<string,mixed>
     */
    public function scan( $plugins ) {
        $rows          = array();
        $issues        = array();
        $scanned_items = 0;
        $category_hits = array(
            'cache_performance' => 0,
            'custom_code'       => 0,
            'filter_search'     => 0,
            'security_firewall' => 0,
            'image_cdn'         => 0,
            'page_builder'      => 0,
            'woocommerce_addon' => 0,
        );

        foreach ( (array) ( $plugins['items'] ?? array() ) as $plugin ) {
            $scanned_items++;

            $group  = (string) ( $plugin['group'] ?? '' );
            $status = (string) ( $plugin['status'] ?? '' );
            if ( 'amaley' === $group || 'active' !== $status ) {
                continue;
            }

            $name        = (string) ( $plugin['name'] ?? '' );
            $file        = (string) ( $plugin['file'] ?? '' );
            $description = (string) ( $plugin['description'] ?? '' );
            $haystack    = strtolower( $name . ' ' . $file . ' ' . $description );

            foreach ( $this->risk_rules() as $category => $rule ) {
                $matched = $this->match_keywords( $haystack, (array) $rule['keywords'] );
                if ( empty( $matched ) ) {
                    continue;
                }

                $category_hits[ $category ]++;
                $risk_level = (string) $rule['risk_level'];

                $row = array(
                    'category'         => (string) $rule['label'],
                    'risk_level'       => $risk_level,
                    'plugin'           => $name,
                    'file'             => $file,
                    'signal'           => implode( ', ', $matched ),
                    'reason'           => (string) $rule['reason'],
                    'suggested_action' => (string) $rule['suggested_action'],
                );
                $rows[] = $row;

                $issues[] = APG_Utils::issue(
                    $risk_level,
                    'External Plugin Risks',
                    'Potential ' . (string) $rule['label'] . ' conflict area detected: ' . $name,
                    'Plugins → ' . $file,
                    (string) $rule['reason'],
                    (string) $rule['suggested_action']
                );
            }
        }

        if ( empty( $rows ) ) {
            $issues[] = APG_Utils::issue(
                'INFO',
                'External Plugin Risks',
                'No active external plugin conflict signals detected in v1.0.3 scope',
                'Amaley Project Guard → External Risks',
                'The scanner did not find known cache/minify/snippet/filter/security/image conflict signals among active external plugins.',
                'Continue manual checks after plugin/theme updates. Keep this as review-only.'
            );
        }

        return array(
            'available'      => true,
            'summary'        => array(
                'status'                 => empty( $rows ) ? 'pass' : 'review',
                'active_external_scanned'=> $this->count_active_external_plugins( $plugins ),
                'risk_rows'              => count( $rows ),
                'issue_count'            => count( $issues ),
            ),
            'category_hits'  => $category_hits,
            'rows'           => $rows,
            'issues'         => $issues,
            'scanned_items'  => $scanned_items,
            'safety'         => 'Read-only warning scanner. No plugin activation, deactivation, deletion, file edit, setting change or auto-fix.',
        );
    }

    /**
     * Risk rules.
     *
     * @return array<string,array<string,mixed>>
     */
    private function risk_rules() {
        return array(
            'cache_performance' => array(
                'label'            => 'Cache / Performance',
                'risk_level'       => 'LOW',
                'keywords'         => array( 'cache', 'caching', 'autoptimize', 'litespeed', 'lite speed', 'rocket', 'w3 total', 'wp fastest', 'minify', 'combine', 'defer', 'perfmatters', 'flying', 'speed optimizer', 'optimization' ),
                'reason'           => 'Cache/minify/defer tools can sometimes delay or combine Elementor/WooCommerce/Amaley CSS and JS, causing card, filter or AJAX display issues after updates.',
                'suggested_action' => 'If a visual/AJAX issue appears, temporarily exclude Amaley/Elementor/WooCommerce assets from minify/defer/cache. Do not deactivate automatically.',
            ),
            'custom_code' => array(
                'label'            => 'Snippet / Custom Code',
                'risk_level'       => 'MEDIUM',
                'keywords'         => array( 'code snippets', 'snippet', 'wpcode', 'insert headers', 'custom code', 'custom css', 'custom js', 'header footer code', 'functions' ),
                'reason'           => 'Custom code/snippet plugins can silently override hooks, filters, shortcodes, WooCommerce templates or Elementor behavior.',
                'suggested_action' => 'Review active snippets before blaming Amaley Core. Keep a screenshot/export of snippets before major changes.',
            ),
            'filter_search' => array(
                'label'            => 'Filter / Search Overlap',
                'risk_level'       => 'MEDIUM',
                'keywords'         => array( 'jetsmartfilters', 'jet smart filters', 'facetwp', 'filter everything', 'search & filter', 'search and filter', 'ajax filter', 'product filter', 'woo filter', 'yith ajax product filter' ),
                'reason'           => 'External filter/search plugins can overlap with Amaley Discovery Engine filters, query arguments, pagination or AJAX rendering.',
                'suggested_action' => 'Before changing Discovery Engine, confirm whether the external filter is active on the same page/template.',
            ),
            'security_firewall' => array(
                'label'            => 'Security / Firewall',
                'risk_level'       => 'LOW',
                'keywords'         => array( 'wordfence', 'sucuri', 'security', 'firewall', 'cerber', 'solid security', 'ithemes security', 'all-in-one security', 'aios' ),
                'reason'           => 'Security/firewall plugins may block REST API, admin-ajax or query requests used by filters, forms, editors or dashboards.',
                'suggested_action' => 'If AJAX/filter/admin requests fail, check firewall logs and allowlist trusted Amaley/Elementor/WooCommerce admin requests.',
            ),
            'image_cdn' => array(
                'label'            => 'Image / CDN / Lazy Load',
                'risk_level'       => 'LOW',
                'keywords'         => array( 'smush', 'shortpixel', 'imagify', 'ewww', 'optimole', 'lazy load', 'lazyload', 'cdn', 'cloudflare', 'webp', 'image optimizer', 'image optimization' ),
                'reason'           => 'Image optimization/lazy-load/CDN plugins can sometimes break product cards, background images, galleries or responsive image loading.',
                'suggested_action' => 'If images disappear or crop badly, test with lazy-load/CDN exclusions for Amaley card/gallery selectors first.',
            ),
            'page_builder' => array(
                'label'            => 'Page Builder Add-on',
                'risk_level'       => 'LOW',
                'keywords'         => array( 'essential addons', 'premium addons', 'elementor addon', 'elementskit', 'crocoblock', 'jetengine', 'jet elements', 'header footer elementor', 'happy addons' ),
                'reason'           => 'Page builder add-ons can register overlapping widgets, scripts or templates that affect Elementor editor performance and layout behavior.',
                'suggested_action' => 'If editor/widgets slow down or duplicate controls appear, compare active Elementor add-ons before changing Amaley widgets.',
            ),
            'woocommerce_addon' => array(
                'label'            => 'WooCommerce Add-on',
                'risk_level'       => 'LOW',
                'keywords'         => array( 'woocommerce', 'woo ', 'checkout', 'cart', 'variation swatches', 'wishlist', 'compare', 'payment', 'shipping', 'invoice', 'subscription' ),
                'reason'           => 'WooCommerce add-ons can alter product cards, cart buttons, checkout flow, variation display, compare/wishlist buttons or template hooks.',
                'suggested_action' => 'If product/card/cart behavior changes, review active WooCommerce add-ons and template hooks before editing Amaley templates.',
            ),
        );
    }

    /**
     * Match keywords.
     *
     * @param string $haystack Search text.
     * @param array<int,string> $keywords Keywords.
     * @return array<int,string>
     */
    private function match_keywords( $haystack, $keywords ) {
        $matches = array();
        foreach ( $keywords as $keyword ) {
            $keyword = strtolower( (string) $keyword );
            if ( '' !== $keyword && false !== strpos( $haystack, $keyword ) ) {
                $matches[] = $keyword;
            }
        }
        return array_values( array_unique( $matches ) );
    }

    /**
     * Count active external plugins.
     *
     * @param array<string,mixed> $plugins Plugin registry.
     * @return int
     */
    private function count_active_external_plugins( $plugins ) {
        $count = 0;
        foreach ( (array) ( $plugins['items'] ?? array() ) as $plugin ) {
            if ( 'external' === (string) ( $plugin['group'] ?? '' ) && 'active' === (string) ( $plugin['status'] ?? '' ) ) {
                $count++;
            }
        }
        return $count;
    }
}
