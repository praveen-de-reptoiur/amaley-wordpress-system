<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class APAB_Product_Context {

    private static $product_id = 0;
    private static $source     = '';

    public static function set_product_id( $product_id, $source = 'manual' ) {
        $product_id = absint( $product_id );
        if ( $product_id && function_exists( 'wc_get_product' ) && wc_get_product( $product_id ) ) {
            self::$product_id = $product_id;
            self::$source     = sanitize_key( $source );
        }
    }

    public static function get_product() {
        if ( ! function_exists( 'wc_get_product' ) ) {
            return false;
        }

        $product_id = self::get_product_id();
        return $product_id ? wc_get_product( $product_id ) : false;
    }

    public static function get_product_id() {
        if ( self::$product_id && function_exists( 'wc_get_product' ) && wc_get_product( self::$product_id ) ) {
            return self::$product_id;
        }

        if ( function_exists( 'is_product' ) && is_product() ) {
            $queried = absint( get_queried_object_id() );
            if ( $queried && wc_get_product( $queried ) ) {
                return $queried;
            }
        }

        global $product;
        if ( $product instanceof WC_Product ) {
            return $product->get_id();
        }

        $current_id = absint( get_the_ID() );
        if ( $current_id && wc_get_product( $current_id ) ) {
            return $current_id;
        }

        $preview = self::get_preview_product_id_for_assigned_page();
        if ( $preview ) {
            return $preview;
        }

        return 0;
    }

    public static function get_preview_product_id_for_assigned_page() {
        if ( ! function_exists( 'wc_get_product' ) ) {
            return 0;
        }
        $settings = APAB_Settings::get_settings();
        $sp       = isset( $settings['single_product'] ) ? $settings['single_product'] : array();

        if ( empty( $sp['preview_assigned_page'] ) || 'yes' !== sanitize_key( $sp['preview_assigned_page'] ) ) {
            return 0;
        }

        $assigned_page_id = ! empty( $sp['assigned_page_id'] ) ? absint( $sp['assigned_page_id'] ) : 0;
        if ( ! $assigned_page_id ) {
            return 0;
        }

        $is_assigned_page = false;
        $ids_to_check     = array(
            absint( get_queried_object_id() ),
            absint( get_the_ID() ),
            isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0,
            isset( $_GET['preview_id'] ) ? absint( wp_unslash( $_GET['preview_id'] ) ) : 0,
            isset( $_GET['elementor-preview'] ) ? absint( wp_unslash( $_GET['elementor-preview'] ) ) : 0,
        );

        foreach ( $ids_to_check as $id ) {
            if ( $assigned_page_id === $id ) {
                $is_assigned_page = true;
                break;
            }
        }

        if ( ! $is_assigned_page ) {
            return 0;
        }

        $product_id = ! empty( $sp['preview_product_id'] ) ? absint( $sp['preview_product_id'] ) : 0;
        if ( ! $product_id ) {
            $product_id = ! empty( $sp['test_product_id'] ) ? absint( $sp['test_product_id'] ) : 0;
        }

        return $product_id && wc_get_product( $product_id ) ? $product_id : 0;
    }

    public static function with_product_globals( $wc_product, $callback ) {
        if ( ! $wc_product instanceof WC_Product || ! is_callable( $callback ) ) {
            return '';
        }

        global $post;
        global $product;

        $old_post           = $post;
        $old_global_product = $product;

        $post    = get_post( $wc_product->get_id() );
        $product = $wc_product;
        self::set_product_id( $wc_product->get_id(), 'with_globals' );
        if ( $post ) {
            setup_postdata( $post );
        }

        ob_start();
        call_user_func( $callback, $wc_product );
        $output = ob_get_clean();

        if ( $old_post ) {
            $post = $old_post;
            setup_postdata( $post );
        } else {
            wp_reset_postdata();
        }
        $product = $old_global_product;

        return $output;
    }

    public static function acf_or_meta( $field_name, $product_id ) {
        $field_name = trim( (string) $field_name );
        $product_id = absint( $product_id );
        if ( ! $field_name || ! $product_id ) {
            return '';
        }
        if ( function_exists( 'get_field' ) ) {
            $value = get_field( $field_name, $product_id );
            if ( '' !== $value && null !== $value ) {
                return $value;
            }
        }
        return get_post_meta( $product_id, $field_name, true );
    }

    public static function text_value( $value ) {
        if ( is_array( $value ) || is_object( $value ) ) {
            return '';
        }
        return trim( (string) $value );
    }

    public static function post_object_id( $value ) {
        if ( empty( $value ) ) {
            return 0;
        }
        if ( is_object( $value ) && isset( $value->ID ) ) {
            return absint( $value->ID );
        }
        if ( is_numeric( $value ) ) {
            return absint( $value );
        }
        if ( is_array( $value ) ) {
            if ( isset( $value['ID'] ) ) {
                return absint( $value['ID'] );
            }
            if ( isset( $value[0] ) ) {
                return self::post_object_id( $value[0] );
            }
        }
        return 0;
    }

    public static function post_object_title( $value ) {
        $id = self::post_object_id( $value );
        if ( $id ) {
            $title = get_the_title( $id );
            return $title ? $title : '';
        }
        return self::text_value( $value );
    }

    public static function post_object_link_html( $value ) {
        $id = self::post_object_id( $value );
        if ( $id ) {
            $title = get_the_title( $id );
            $link  = get_permalink( $id );
            if ( $title && $link ) {
                return '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>';
            }
            return $title ? esc_html( $title ) : '';
        }
        return esc_html( self::text_value( $value ) );
    }



    public static function maybe_unserialize_value( $value ) {
        if ( is_string( $value ) ) {
            $maybe = maybe_unserialize( $value );
            if ( $maybe !== $value ) {
                return $maybe;
            }
            $json = json_decode( $value, true );
            if ( is_array( $json ) ) {
                return $json;
            }
        }
        return $value;
    }

    public static function first_non_empty_raw( $product_id, $keys ) {
        $product_id = absint( $product_id );
        foreach ( (array) $keys as $key ) {
            $key = trim( (string) $key );
            if ( '' === $key ) {
                continue;
            }

            if ( function_exists( 'get_field' ) ) {
                $value = get_field( $key, $product_id );
                if ( self::has_value( $value ) ) {
                    return $value;
                }
            }

            $value = get_post_meta( $product_id, $key, true );
            if ( self::has_value( $value ) ) {
                return self::maybe_unserialize_value( $value );
            }
        }
        return '';
    }

    public static function has_value( $value ) {
        if ( null === $value || false === $value ) {
            return false;
        }
        if ( is_array( $value ) ) {
            return ! empty( array_filter( $value, array( __CLASS__, 'has_value' ) ) );
        }
        if ( is_object( $value ) ) {
            return true;
        }
        return '' !== trim( (string) $value );
    }

    public static function ids_from_any( $value ) {
        $value = self::maybe_unserialize_value( $value );
        $ids   = array();

        if ( empty( $value ) ) {
            return array();
        }

        if ( is_object( $value ) ) {
            if ( isset( $value->ID ) ) {
                $ids[] = absint( $value->ID );
            }
        } elseif ( is_array( $value ) ) {
            foreach ( $value as $item ) {
                $ids = array_merge( $ids, self::ids_from_any( $item ) );
            }
        } elseif ( is_numeric( $value ) ) {
            $ids[] = absint( $value );
        } else {
            $parts = preg_split( '/[,|]/', (string) $value );
            foreach ( $parts as $part ) {
                if ( is_numeric( trim( $part ) ) ) {
                    $ids[] = absint( trim( $part ) );
                }
            }
        }

        $ids = array_values( array_unique( array_filter( $ids ) ) );
        return $ids;
    }

    public static function links_from_ids( $ids ) {
        $items = array();
        foreach ( (array) $ids as $id ) {
            $id    = absint( $id );
            $title = $id ? get_the_title( $id ) : '';
            if ( ! $title ) {
                continue;
            }
            $link = get_permalink( $id );
            $items[] = $link ? '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) . '</a>' : esc_html( $title );
        }
        return implode( ', ', $items );
    }

    public static function titles_from_ids( $ids ) {
        $items = array();
        foreach ( (array) $ids as $id ) {
            $title = get_the_title( absint( $id ) );
            if ( $title ) {
                $items[] = $title;
            }
        }
        return $items;
    }

    public static function origin_data( $product_id, $field_overrides = array() ) {
        $product_id = absint( $product_id );
        if ( ! $product_id ) {
            return array();
        }

        $field = function( $name, $fallback ) use ( $field_overrides ) {
            return ! empty( $field_overrides[ $name ] ) ? (string) $field_overrides[ $name ] : $fallback;
        };

        $cluster_raw = self::first_non_empty_raw( $product_id, array(
            '_amaley_origin_cluster_id',
            $field( 'cluster', 'linked_cluster' ),
            'linked_cluster', '_linked_cluster', 'product_cluster', '_product_cluster', 'origin_cluster', '_origin_cluster'
        ) );
        $shg_raw = self::first_non_empty_raw( $product_id, array(
            '_amaley_origin_shg_ids',
            $field( 'shg', 'linked_shg_group' ),
            'linked_shg_group', '_linked_shg_group', 'linked_shg', '_linked_shg', 'origin_shg', '_origin_shg'
        ) );
        $maker_raw = self::first_non_empty_raw( $product_id, array(
            '_amaley_origin_member_ids',
            $field( 'maker', 'linked_producer_maker' ),
            'linked_producer_maker', '_linked_producer_maker', 'linked_member', '_linked_member', 'linked_producer', '_linked_producer', 'origin_producer', '_origin_producer'
        ) );

        $cluster_ids = self::ids_from_any( $cluster_raw );
        $shg_ids     = self::ids_from_any( $shg_raw );
        $maker_ids   = self::ids_from_any( $maker_raw );

        // Derive cluster from the first linked SHG when product-level cluster is not stored.
        if ( empty( $cluster_ids ) && ! empty( $shg_ids ) ) {
            foreach ( $shg_ids as $shg_id ) {
                $linked_cluster = absint( get_post_meta( $shg_id, '_amaley_shg_cluster_id', true ) );
                if ( $linked_cluster ) {
                    $cluster_ids[] = $linked_cluster;
                }
            }
            $cluster_ids = array_values( array_unique( array_filter( $cluster_ids ) ) );
        }

        $origin_short = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'origin_short', 'origin_short_line' ), 'origin_short_line', '_origin_short_line', '_amaley_origin_note' ) ),
        ) );
        $source_village = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'village', 'village_source_location' ), 'village_source_location', '_village_source_location', 'source_village', '_source_village', '_amaley_origin_source_village' ) ),
        ) );
        if ( '' === $source_village && ! empty( $shg_ids ) ) {
            $source_village = self::first_non_empty_text( array(
                get_post_meta( $shg_ids[0], '_amaley_village', true ),
                get_post_meta( $shg_ids[0], '_amaley_district', true ),
            ) );
        }

        $region = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'region', 'region_source_belt' ), 'region_source_belt', '_region_source_belt', 'source_region', '_source_region' ) ),
        ) );
        if ( '' === $region && ! empty( $cluster_ids ) ) {
            $region = self::first_non_empty_text( array(
                get_post_meta( $cluster_ids[0], '_amaley_region', true ),
                get_post_meta( $cluster_ids[0], '_amaley_district', true ),
                get_post_meta( $cluster_ids[0], '_amaley_block_area', true ),
            ) );
        }

        $traceability = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'traceability', 'traceability_note' ), 'traceability_note', '_traceability_note', '_amaley_origin_traceability_note' ) ),
        ) );
        $processing = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'processing', 'processing_method' ), 'processing_method', '_processing_method' ) ),
        ) );
        $quote = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'quote', 'producer_quote_maker_note' ), 'producer_quote_maker_note', '_producer_quote_maker_note' ) ),
        ) );
        $batch = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'batch', 'batch_type' ), 'batch_type', '_batch_type' ) ),
        ) );
        $season = self::first_non_empty_text( array(
            self::first_non_empty_raw( $product_id, array( $field( 'season', 'harvest_collection_season' ), 'harvest_collection_season', '_harvest_collection_season' ) ),
        ) );

        $cluster_text = self::links_from_ids( $cluster_ids );
        if ( '' === $cluster_text ) {
            $cluster_text = esc_html( self::text_value( $cluster_raw ) );
        }
        $shg_text = self::links_from_ids( $shg_ids );
        if ( '' === $shg_text ) {
            $shg_text = esc_html( self::text_value( $shg_raw ) );
        }
        $maker_text = self::links_from_ids( $maker_ids );
        if ( '' === $maker_text ) {
            $maker_text = esc_html( self::text_value( $maker_raw ) );
        }

        return array(
            'cluster_ids'       => $cluster_ids,
            'shg_ids'           => $shg_ids,
            'maker_ids'         => $maker_ids,
            'cluster_html'      => $cluster_text,
            'shg_html'          => $shg_text,
            'maker_html'        => $maker_text,
            'cluster_titles'    => self::titles_from_ids( $cluster_ids ),
            'shg_titles'        => self::titles_from_ids( $shg_ids ),
            'maker_titles'      => self::titles_from_ids( $maker_ids ),
            'origin_short'      => $origin_short,
            'source_village'    => $source_village,
            'region'            => $region,
            'traceability_note' => $traceability,
            'processing_method' => $processing,
            'producer_quote'    => $quote,
            'batch_type'        => $batch,
            'season'            => $season,
        );
    }

    public static function first_non_empty_text( $values ) {
        foreach ( (array) $values as $value ) {
            $text = self::text_value( $value );
            if ( '' !== $text ) {
                return $text;
            }
        }
        return '';
    }
}
