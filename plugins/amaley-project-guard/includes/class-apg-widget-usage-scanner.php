<?php
/**
 * Widget and shortcode usage scanner.
 *
 * @package Amaley_Project_Guard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APG_Widget_Usage_Scanner {

    /** Maximum Elementor documents scanned per manual Quick Scan. */
    const ELEMENTOR_LIMIT = 250;

    /** Maximum shortcode content documents scanned per manual Quick Scan. */
    const SHORTCODE_LIMIT = 250;

    /** Maximum usage rows stored per widget/shortcode. */
    const ITEMS_PER_KEY_LIMIT = 30;

    /**
     * Scan Elementor widget usage and shortcode usage.
     *
     * This runs only during manual Project Guard scans. It does not attach to frontend requests.
     *
     * @param array<string,mixed> $elementor Elementor scanner data.
     * @param array<string,mixed> $shortcodes Shortcode scanner data.
     * @return array<string,mixed>
     */
    public function scan( $elementor, $shortcodes ) {
        $known_widgets = $this->normalize_known_widgets( (array) ( $elementor['widgets'] ?? array() ) );
        $known_shortcodes = $this->normalize_known_shortcodes( (array) ( $shortcodes['amaley'] ?? array() ) );

        $widget_result = $this->scan_elementor_widgets( $known_widgets );
        $shortcode_result = $this->scan_shortcodes_in_content( $known_shortcodes );

        return array(
            'version' => '1.0.1.3',
            'mode'    => 'manual_quick_scan_usage_map',
            'scope'   => array(
                'safety'               => 'Read-only. Manual scan only. No frontend output. No content mutation.',
                'elementor_limit'      => self::ELEMENTOR_LIMIT,
                'shortcode_limit'      => self::SHORTCODE_LIMIT,
                'items_per_key_limit'  => self::ITEMS_PER_KEY_LIMIT,
                'note'                 => 'Usage Map is a safe scan snapshot. For very large sites, future versions can add deeper batched scans.',
            ),
            'counts'  => array(
                'known_amaley_widgets'       => count( $known_widgets ),
                'used_amaley_widgets'        => count( $widget_result['used'] ),
                'unused_amaley_widgets'      => count( $widget_result['unused'] ),
                'elementor_documents_scanned'=> (int) $widget_result['documents_scanned'],
                'elementor_widget_hits'      => (int) $widget_result['usage_hits'],
                'known_amaley_shortcodes'    => count( $known_shortcodes ),
                'used_amaley_shortcodes'     => count( $shortcode_result['used'] ),
                'unused_amaley_shortcodes'   => count( $shortcode_result['unused'] ),
                'shortcode_documents_scanned'=> (int) $shortcode_result['documents_scanned'],
                'shortcode_hits'             => (int) $shortcode_result['usage_hits'],
            ),
            'widgets'    => $widget_result,
            'shortcodes' => $shortcode_result,
            'cleanup_candidates' => array(
                'widgets_review_only'    => $widget_result['unused'],
                'shortcodes_review_only' => $shortcode_result['unused'],
                'warning'                => 'Review-only. Do not delete/deactivate anything from this list without manual confirmation and backup.',
            ),
        );
    }

    /**
     * Normalize known Amaley widgets.
     *
     * @param array<int,array<string,mixed>> $widgets Widgets.
     * @return array<string,array<string,string>>
     */
    private function normalize_known_widgets( $widgets ) {
        $known = array();
        foreach ( $widgets as $widget ) {
            if ( empty( $widget['is_amaley'] ) || empty( $widget['name'] ) ) {
                continue;
            }
            $name = (string) $widget['name'];
            $known[ $name ] = array(
                'name'  => $name,
                'class' => (string) ( $widget['class'] ?? '' ),
            );
        }
        ksort( $known, SORT_NATURAL | SORT_FLAG_CASE );
        return $known;
    }

    /**
     * Normalize known Amaley shortcodes.
     *
     * @param array<int,array<string,mixed>> $shortcodes Shortcodes.
     * @return array<string,array<string,string>>
     */
    private function normalize_known_shortcodes( $shortcodes ) {
        $known = array();
        foreach ( $shortcodes as $shortcode ) {
            if ( empty( $shortcode['tag'] ) ) {
                continue;
            }
            $tag = (string) $shortcode['tag'];
            $known[ $tag ] = array(
                'tag'      => $tag,
                'callback' => (string) ( $shortcode['callback'] ?? '' ),
            );
        }
        ksort( $known, SORT_NATURAL | SORT_FLAG_CASE );
        return $known;
    }

    /**
     * Scan Elementor _elementor_data for Amaley widget usage.
     *
     * @param array<string,array<string,string>> $known_widgets Known widgets.
     * @return array<string,mixed>
     */
    private function scan_elementor_widgets( $known_widgets ) {
        $usage = array();
        $documents = $this->get_elementor_document_ids();
        $hits = 0;

        foreach ( $documents as $post_id ) {
            $raw = get_post_meta( $post_id, '_elementor_data', true );
            if ( empty( $raw ) ) {
                continue;
            }

            $data = is_string( $raw ) ? json_decode( $raw, true ) : $raw;
            if ( ! is_array( $data ) ) {
                continue;
            }

            $post = get_post( $post_id );
            if ( ! $post ) {
                continue;
            }

            $page_info = $this->page_info( $post );
            $found = array();
            $this->walk_elementor_nodes( $data, $known_widgets, $page_info, $usage, $found, $hits, 0 );
        }

        ksort( $usage, SORT_NATURAL | SORT_FLAG_CASE );
        $used = array_values( $usage );
        $unused = array();

        foreach ( $known_widgets as $name => $widget ) {
            if ( ! isset( $usage[ $name ] ) ) {
                $unused[] = array(
                    'name'   => $name,
                    'class'  => (string) ( $widget['class'] ?? '' ),
                    'status' => 'not_found_in_scanned_elementor_documents',
                );
            }
        }

        return array(
            'documents_scanned' => count( $documents ),
            'usage_hits'        => $hits,
            'used'              => $used,
            'unused'            => $unused,
        );
    }

    /**
     * Get Elementor document IDs with safe limit.
     *
     * @return array<int,int>
     */
    private function get_elementor_document_ids() {
        $post_types = get_post_types( array( 'show_ui' => true ), 'names' );
        $extra = array( 'page', 'post', 'product', 'elementor_library', 'wp_template', 'wp_template_part' );
        $post_types = array_values( array_unique( array_filter( array_merge( array_values( $post_types ), $extra ) ) ) );

        $ids = get_posts(
            array(
                'post_type'      => $post_types,
                'post_status'    => array( 'publish', 'private', 'draft', 'pending', 'future' ),
                'posts_per_page' => self::ELEMENTOR_LIMIT,
                'fields'         => 'ids',
                'meta_key'       => '_elementor_data', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- manual admin scan only.
                'orderby'        => 'modified',
                'order'          => 'DESC',
                'no_found_rows'  => true,
            )
        );

        return array_map( 'intval', (array) $ids );
    }

    /**
     * Walk Elementor nodes recursively.
     *
     * @param array<int|string,mixed> $nodes Nodes.
     * @param array<string,array<string,string>> $known_widgets Known widgets.
     * @param array<string,mixed> $page_info Page info.
     * @param array<string,mixed> $usage Usage reference.
     * @param array<string,bool> $found Found-on-page reference.
     * @param int $hits Hit count reference.
     * @param int $depth Depth.
     * @return void
     */
    private function walk_elementor_nodes( $nodes, $known_widgets, $page_info, &$usage, &$found, &$hits, $depth ) {
        foreach ( $nodes as $node ) {
            if ( ! is_array( $node ) ) {
                continue;
            }

            $widget_type = isset( $node['widgetType'] ) ? (string) $node['widgetType'] : '';
            $is_amaley = ( '' !== $widget_type && ( isset( $known_widgets[ $widget_type ] ) || false !== stripos( $widget_type, 'amaley' ) ) );

            if ( $is_amaley ) {
                $widget_id = isset( $node['id'] ) ? (string) $node['id'] : '';
                $key = $widget_type;

                if ( ! isset( $usage[ $key ] ) ) {
                    $usage[ $key ] = array(
                        'name'  => $key,
                        'class' => (string) ( $known_widgets[ $key ]['class'] ?? '' ),
                        'count' => 0,
                        'items' => array(),
                    );
                }

                $usage[ $key ]['count']++;
                $hits++;

                $item_key = $page_info['id'] . ':' . $widget_id;
                if ( ! isset( $found[ $item_key ] ) && count( $usage[ $key ]['items'] ) < self::ITEMS_PER_KEY_LIMIT ) {
                    $found[ $item_key ] = true;
                    $usage[ $key ]['items'][] = array_merge(
                        $page_info,
                        array(
                            'source'      => 'Elementor JSON',
                            'widget_id'   => $widget_id,
                            'depth'       => $depth,
                        )
                    );
                }
            }

            if ( ! empty( $node['elements'] ) && is_array( $node['elements'] ) ) {
                $this->walk_elementor_nodes( $node['elements'], $known_widgets, $page_info, $usage, $found, $hits, $depth + 1 );
            }
        }
    }

    /**
     * Scan page/post content for Amaley shortcodes.
     *
     * @param array<string,array<string,string>> $known_shortcodes Known shortcodes.
     * @return array<string,mixed>
     */
    private function scan_shortcodes_in_content( $known_shortcodes ) {
        global $wpdb;

        $usage = array();
        $hits = 0;
        $rows = array();

        if ( $wpdb && ! empty( $known_shortcodes ) ) {
            $rows = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT ID, post_title, post_type, post_status, post_modified, post_content FROM {$wpdb->posts} WHERE post_status NOT IN ('auto-draft','inherit','trash') AND post_content LIKE %s ORDER BY post_modified DESC LIMIT %d",
                    '%[amaley%',
                    self::SHORTCODE_LIMIT
                ),
                ARRAY_A
            );
        }

        foreach ( (array) $rows as $row ) {
            $content = isset( $row['post_content'] ) ? (string) $row['post_content'] : '';
            if ( '' === $content ) {
                continue;
            }

            $page_info = array(
                'id'        => (int) ( $row['ID'] ?? 0 ),
                'title'     => (string) ( $row['post_title'] ?? '' ),
                'post_type' => (string) ( $row['post_type'] ?? '' ),
                'status'    => (string) ( $row['post_status'] ?? '' ),
                'modified'  => (string) ( $row['post_modified'] ?? '' ),
                'edit_link' => get_edit_post_link( (int) ( $row['ID'] ?? 0 ), '' ),
            );

            foreach ( $known_shortcodes as $tag => $shortcode ) {
                if ( has_shortcode( $content, $tag ) ) {
                    if ( ! isset( $usage[ $tag ] ) ) {
                        $usage[ $tag ] = array(
                            'tag'      => $tag,
                            'callback' => (string) ( $shortcode['callback'] ?? '' ),
                            'count'    => 0,
                            'items'    => array(),
                        );
                    }
                    $usage[ $tag ]['count']++;
                    $hits++;
                    if ( count( $usage[ $tag ]['items'] ) < self::ITEMS_PER_KEY_LIMIT ) {
                        $usage[ $tag ]['items'][] = array_merge( $page_info, array( 'source' => 'post_content shortcode' ) );
                    }
                }
            }
        }

        ksort( $usage, SORT_NATURAL | SORT_FLAG_CASE );
        $used = array_values( $usage );
        $unused = array();

        foreach ( $known_shortcodes as $tag => $shortcode ) {
            if ( ! isset( $usage[ $tag ] ) ) {
                $unused[] = array(
                    'tag'      => $tag,
                    'callback' => (string) ( $shortcode['callback'] ?? '' ),
                    'status'   => 'not_found_in_scanned_content',
                );
            }
        }

        return array(
            'documents_scanned' => count( (array) $rows ),
            'usage_hits'        => $hits,
            'used'              => $used,
            'unused'            => $unused,
        );
    }

    /**
     * Create page info array.
     *
     * @param WP_Post $post Post.
     * @return array<string,mixed>
     */
    private function page_info( $post ) {
        return array(
            'id'        => (int) $post->ID,
            'title'     => (string) get_the_title( $post ),
            'post_type' => (string) $post->post_type,
            'status'    => (string) $post->post_status,
            'modified'  => (string) $post->post_modified,
            'edit_link' => get_edit_post_link( $post->ID, '' ),
        );
    }
}
