<?php
/** Origin Map Path renderer for Amaley Compact Widgets. */
defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Origin_Map {
    public static function defaults() {
        return array(
            'show_section' => '1', 'show_left_panel' => '1', 'show_right_panel' => '1', 'show_map' => '1', 'show_route_text' => '1', 'show_foot_note' => '1', 'show_items' => '1', 'show_button' => '1',
            'kicker' => 'FROM CLUSTER TO KITCHEN', 'title' => 'Know the Path of Every Product', 'description' => 'A real map-style journey view that lets visitors drag, zoom and understand how Amaley products move from Himalayan origin to everyday tables.',
            'right_kicker' => 'FROM HIMALAYAN CLUSTERS TO EVERYDAY TABLES', 'right_title' => 'A Visible Journey, Not Just a Product', 'right_description' => 'Each product carries a journey: where it begins, who prepares it, how it is made and how it reaches the customer.',
            'map_kicker' => 'AMALEY ORIGIN MAP', 'map_title' => 'From Cluster to Kitchen', 'route_text' => 'Sham Valley / Apricot Cluster → Nimmo SHG Group → Leh Women Makers → Product Hub → Customer', 'foot_note' => 'Drag the real map, zoom in or out, and follow the product route from origin to customer.',
            'button_text' => 'Explore Amaley Origins', 'button_url' => '#', 'center_lat' => '34.1850', 'center_lng' => '77.4300', 'zoom' => '10', 'tile_url' => 'https://tile.openstreetmap.org/{z}/{x}/{y}.png', 'attribution' => '© OpenStreetMap contributors', 'reset_text' => 'Reset', 'hint_text' => 'Drag map · wheel/touch zoom · + / −', 'items' => '', 'route_points' => '',
        );
    }
    public static function default_items() {
        return array(
            array( 'number' => '01', 'title' => 'Cluster Origin', 'text' => 'Ingredients begin in Himalayan landscapes, seasons and local knowledge.' ),
            array( 'number' => '02', 'title' => 'SHG & Maker Link', 'text' => 'Community groups prepare, sort and add value with care.' ),
            array( 'number' => '03', 'title' => 'Small-batch Products', 'text' => 'Products are made in controlled small batches, not anonymous mass production.' ),
            array( 'number' => '04', 'title' => 'Customer Connection', 'text' => 'The customer sees the visible chain behind what they buy.' ),
        );
    }
    public static function route_points() {
        return array(
            array( 'slug' => 'cluster',  'number' => '01', 'lat' => '34.2300', 'lng' => '77.1600', 'title' => 'Cluster Origin', 'text' => 'Apricot and Himalayan ingredient belt.' ),
            array( 'slug' => 'shg',      'number' => '02', 'lat' => '34.2050', 'lng' => '77.3400', 'title' => 'SHG Group', 'text' => 'Sorting, preparation and value addition.' ),
            array( 'slug' => 'makers',   'number' => '03', 'lat' => '34.1526', 'lng' => '77.5771', 'title' => 'Makers', 'text' => 'Small-batch making and quality discipline.' ),
            array( 'slug' => 'products', 'number' => '04', 'lat' => '34.1660', 'lng' => '77.5850', 'title' => 'Products', 'text' => 'Ready for Amaley shelves.' ),
            array( 'slug' => 'customer', 'number' => '05', 'lat' => '34.1700', 'lng' => '77.6200', 'title' => 'Customer', 'text' => 'Homestays, travellers and conscious buyers.' ),
        );
    }
    private static function yes( $value ) { return in_array( (string) $value, array( '1', 'yes', 'true', 'on' ), true ); }
    public static function render( $atts = array() ) {
        $a = self::parse_atts( $atts ); if ( ! self::yes( $a['show_section'] ) ) { return ''; }
        $items = self::parse_items( $a['items'] ); $points = self::parse_route_points( $a['route_points'] );
        $out = '<section class="amaley-cw4 amaley-cw4-origin-map-path" data-acw="origin_map_path"><div class="amaley-cw4-inner"><div class="amaley-cw4-origin-map-path-shell">';
        if ( self::yes( $a['show_left_panel'] ) ) {
            $out .= '<article class="amaley-cw4-origin-map-path-panel amaley-cw4-origin-map-path-panel--map"><div class="amaley-cw4-head"><p class="amaley-cw4-kicker">' . self::esc( $a['kicker'] ) . '</p><h2 class="amaley-cw4-title">' . self::esc( $a['title'] ) . '</h2><p class="amaley-cw4-desc">' . self::esc( $a['description'] ) . '</p></div>';
            if ( self::yes( $a['show_map'] ) ) {
                $out .= '<div class="amaley-cw4-origin-map-path-board"><p class="amaley-cw4-origin-map-path-board-kicker">' . self::esc( $a['map_kicker'] ) . '</p><h3>' . self::esc( $a['map_title'] ) . '</h3>';
                $out .= '<div class="amaley-cw4-origin-map-path-map" data-acw-origin-map data-center-lat="' . self::attr( $a['center_lat'] ) . '" data-center-lng="' . self::attr( $a['center_lng'] ) . '" data-zoom="' . self::attr( $a['zoom'] ) . '" data-tile-url="' . self::attr( $a['tile_url'] ) . '" role="application" aria-label="Interactive Amaley origin map."><div class="amaley-cw4-origin-map-path-tile-layer" data-acw-tile-layer></div><svg class="amaley-cw4-origin-map-path-route-svg" data-acw-route-svg aria-hidden="true"><polyline data-acw-route-line points=""></polyline></svg><div class="amaley-cw4-origin-map-path-marker-layer" data-acw-marker-layer>';
                foreach ( $points as $point ) { $out .= '<button type="button" class="amaley-cw4-origin-map-path-marker amaley-cw4-origin-map-path-marker--' . self::attr( $point['slug'] ) . '" data-acw-map-point data-lat="' . self::attr( $point['lat'] ) . '" data-lng="' . self::attr( $point['lng'] ) . '"><span>' . self::esc( $point['number'] ) . '</span></button><div class="amaley-cw4-origin-map-path-label amaley-cw4-origin-map-path-label--' . self::attr( $point['slug'] ) . '" data-acw-map-label data-lat="' . self::attr( $point['lat'] ) . '" data-lng="' . self::attr( $point['lng'] ) . '"><strong>' . self::esc( $point['title'] ) . '</strong><small>' . self::esc( $point['text'] ) . '</small></div>'; }
                $out .= '</div><div class="amaley-cw4-origin-map-path-controls"><button type="button" data-acw-map-control="zoom-in">+</button><button type="button" data-acw-map-control="zoom-out">−</button></div><button type="button" class="amaley-cw4-origin-map-path-reset" data-acw-map-control="reset">' . self::esc( $a['reset_text'] ) . '</button><span class="amaley-cw4-origin-map-path-hint">' . self::esc( $a['hint_text'] ) . '</span><span class="amaley-cw4-origin-map-path-attribution">' . self::esc( $a['attribution'] ) . '</span></div>';
                if ( self::yes( $a['show_route_text'] ) ) { $out .= '<p class="amaley-cw4-origin-map-path-route-text">' . self::esc( $a['route_text'] ) . '</p>'; }
                $out .= '</div>';
            }
            if ( self::yes( $a['show_foot_note'] ) ) { $out .= '<p class="amaley-cw4-origin-map-path-foot">' . self::esc( $a['foot_note'] ) . '</p>'; }
            $out .= '</article>';
        }
        if ( self::yes( $a['show_right_panel'] ) ) {
            $out .= '<article class="amaley-cw4-origin-map-path-panel amaley-cw4-origin-map-path-panel--list"><div class="amaley-cw4-head"><p class="amaley-cw4-kicker">' . self::esc( $a['right_kicker'] ) . '</p><h2 class="amaley-cw4-title">' . self::esc( $a['right_title'] ) . '</h2><p class="amaley-cw4-desc">' . self::esc( $a['right_description'] ) . '</p></div>';
            if ( self::yes( $a['show_items'] ) ) { $out .= '<div class="amaley-cw4-origin-map-path-steps">'; foreach ( $items as $item ) { $out .= '<div class="amaley-cw4-origin-map-path-step"><span>' . self::esc( self::item_text( $item, 'number', '01' ) ) . '</span><div><h3>' . self::esc( self::item_text( $item, 'title', 'Origin step' ) ) . '</h3><p>' . self::esc( self::item_text( $item, 'text', '' ) ) . '</p></div></div>'; } $out .= '</div>'; }
            if ( self::yes( $a['show_button'] ) ) { $out .= '<div class="amaley-cw4-actions"><a class="amaley-cw4-btn" href="' . self::url( $a['button_url'] ) . '">' . self::esc( $a['button_text'] ) . '</a></div>'; }
            $out .= '</article>';
        }
        return $out . '</div></div></section>';
    }
    private static function parse_atts( $atts ) { $atts = is_array( $atts ) ? $atts : array(); $out = array_merge( self::defaults(), $atts ); foreach ( $out as $key => $value ) { if ( is_array( $value ) && isset( $value['url'] ) ) { $out[ $key ] = (string) $value['url']; } } return $out; }
    private static function parse_route_points( $raw ) { if ( is_array( $raw ) && ! empty( $raw ) ) { return $raw; } $raw = trim( (string) $raw ); if ( '' === $raw ) { return self::route_points(); } $decoded = json_decode( $raw, true ); return is_array( $decoded ) ? $decoded : self::route_points(); }
    private static function parse_items( $raw ) { if ( is_array( $raw ) && ! empty( $raw ) ) { return $raw; } $raw = trim( (string) $raw ); if ( '' === $raw ) { return self::default_items(); } $decoded = json_decode( $raw, true ); return is_array( $decoded ) ? $decoded : self::default_items(); }
    private static function item_text( $item, $key, $default = '' ) { return isset( $item[ $key ] ) ? (string) $item[ $key ] : $default; }
    private static function esc( $text ) { return function_exists( 'esc_html' ) ? esc_html( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' ); }
    private static function attr( $text ) { return function_exists( 'esc_attr' ) ? esc_attr( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' ); }
    private static function url( $text ) { return function_exists( 'esc_url' ) ? esc_url( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' ); }
}
