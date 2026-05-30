<?php
/**
 * Origin Map Path renderer for Amaley Compact Widgets.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Origin_Map {
	public static function defaults() {
		return array(
			'kicker'            => 'FROM CLUSTER TO KITCHEN',
			'title'             => 'Know the Path of Every Product',
			'description'       => 'A real map-style journey view that lets visitors drag, zoom and understand how Amaley products move from Himalayan origin to everyday tables.',
			'right_kicker'      => 'FROM HIMALAYAN CLUSTERS TO EVERYDAY TABLES',
			'right_title'       => 'A Visible Journey, Not Just a Product',
			'right_description' => 'Each product carries a journey: where it begins, who prepares it, how it is made and how it reaches the customer.',
			'map_kicker'        => 'AMALEY ORIGIN MAP',
			'map_title'         => 'From Cluster to Kitchen',
			'route_text'        => 'Sham Valley / Apricot Cluster → Nimmo SHG Group → Leh Women Makers → Product Hub → Customer',
			'foot_note'         => 'Drag the real map, zoom in or out, and follow the product route from origin to customer.',
			'button_text'       => 'Explore Amaley Origins',
			'button_url'        => '#',
			'center_lat'        => '34.1850',
			'center_lng'        => '77.4300',
			'zoom'              => '10',
			'tile_url'          => 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
			'attribution'       => '© OpenStreetMap contributors',
			'items'             => '',
		);
	}

	public static function default_items() {
		return array(
			array( 'number' => '01', 'title' => 'Cluster Origin', 'text' => 'Ingredients begin in Himalayan landscapes, seasons and local knowledge.' ),
			array( 'number' => '02', 'title' => 'SHG & Maker Link', 'text' => 'Women-led groups prepare, sort and add value with care.' ),
			array( 'number' => '03', 'title' => 'Small-batch Products', 'text' => 'Products are made in controlled small batches, not anonymous mass production.' ),
			array( 'number' => '04', 'title' => 'Customer Connection', 'text' => 'The customer sees the visible chain behind what they buy.' ),
		);
	}

	public static function route_points() {
		return array(
			array( 'slug' => 'cluster',  'number' => '01', 'lat' => '34.2300', 'lng' => '77.1600', 'title' => 'Cluster Origin', 'text' => 'Apricot and Himalayan ingredient belt.' ),
			array( 'slug' => 'shg',      'number' => '02', 'lat' => '34.2050', 'lng' => '77.3400', 'title' => 'SHG Group', 'text' => 'Sorting, preparation and value addition.' ),
			array( 'slug' => 'makers',   'number' => '03', 'lat' => '34.1526', 'lng' => '77.5771', 'title' => 'Women Makers', 'text' => 'Small-batch making and quality discipline.' ),
			array( 'slug' => 'products', 'number' => '04', 'lat' => '34.1660', 'lng' => '77.5850', 'title' => 'Products', 'text' => 'Ready for Amaley shelves.' ),
			array( 'slug' => 'customer', 'number' => '05', 'lat' => '34.1700', 'lng' => '77.6200', 'title' => 'Customer', 'text' => 'Homestays, travellers and conscious buyers.' ),
		);
	}

	public static function render( $atts = array() ) {
		$a      = self::parse_atts( $atts );
		$items  = self::parse_items( $a['items'] );
		$points = self::route_points();

		$out  = '<section class="amaley-cw4 amaley-cw4-origin-map-path" data-acw="origin_map_path"><div class="amaley-cw4-inner">';
		$out .= '<div class="amaley-cw4-origin-map-path-shell">';
		$out .= '<article class="amaley-cw4-origin-map-path-panel amaley-cw4-origin-map-path-panel--map">';
		$out .= '<div class="amaley-cw4-head"><p class="amaley-cw4-kicker">' . self::esc( $a['kicker'] ) . '</p><h2 class="amaley-cw4-title">' . self::esc( $a['title'] ) . '</h2><p class="amaley-cw4-desc">' . self::esc( $a['description'] ) . '</p></div>';
		$out .= '<div class="amaley-cw4-origin-map-path-board">';
		$out .= '<p class="amaley-cw4-origin-map-path-board-kicker">' . self::esc( $a['map_kicker'] ) . '</p>';
		$out .= '<h3>' . self::esc( $a['map_title'] ) . '</h3>';
		$out .= '<div class="amaley-cw4-origin-map-path-map" data-acw-origin-map data-center-lat="' . self::attr( $a['center_lat'] ) . '" data-center-lng="' . self::attr( $a['center_lng'] ) . '" data-zoom="' . self::attr( $a['zoom'] ) . '" data-tile-url="' . self::attr( $a['tile_url'] ) . '" role="application" aria-label="Interactive Amaley origin map. Drag the map and use plus or minus controls to zoom.">';
		$out .= '<div class="amaley-cw4-origin-map-path-tile-layer" data-acw-tile-layer></div>';
		$out .= '<svg class="amaley-cw4-origin-map-path-route-svg" data-acw-route-svg aria-hidden="true"><polyline data-acw-route-line points=""></polyline></svg>';
		$out .= '<div class="amaley-cw4-origin-map-path-marker-layer" data-acw-marker-layer>';
		foreach ( $points as $point ) {
			$out .= '<button type="button" class="amaley-cw4-origin-map-path-marker amaley-cw4-origin-map-path-marker--' . self::attr( $point['slug'] ) . '" data-acw-map-point data-lat="' . self::attr( $point['lat'] ) . '" data-lng="' . self::attr( $point['lng'] ) . '"><span>' . self::esc( $point['number'] ) . '</span></button>';
			$out .= '<div class="amaley-cw4-origin-map-path-label amaley-cw4-origin-map-path-label--' . self::attr( $point['slug'] ) . '" data-acw-map-label data-lat="' . self::attr( $point['lat'] ) . '" data-lng="' . self::attr( $point['lng'] ) . '"><strong>' . self::esc( $point['title'] ) . '</strong><small>' . self::esc( $point['text'] ) . '</small></div>';
		}
		$out .= '</div>';
		$out .= '<div class="amaley-cw4-origin-map-path-controls" aria-label="Map zoom controls"><button type="button" data-acw-map-control="zoom-in" aria-label="Zoom in">+</button><button type="button" data-acw-map-control="zoom-out" aria-label="Zoom out">−</button></div>';
		$out .= '<button type="button" class="amaley-cw4-origin-map-path-reset" data-acw-map-control="reset" aria-label="Reset map view">Reset</button>';
		$out .= '<span class="amaley-cw4-origin-map-path-hint">Drag map · wheel/touch zoom · + / −</span>';
		$out .= '<span class="amaley-cw4-origin-map-path-attribution">' . self::esc( $a['attribution'] ) . '</span>';
		$out .= '</div>';
		$out .= '<p class="amaley-cw4-origin-map-path-route-text">' . self::esc( $a['route_text'] ) . '</p>';
		$out .= '</div>';
		$out .= '<p class="amaley-cw4-origin-map-path-foot">' . self::esc( $a['foot_note'] ) . '</p>';
		$out .= '</article>';
		$out .= '<article class="amaley-cw4-origin-map-path-panel amaley-cw4-origin-map-path-panel--list">';
		$out .= '<div class="amaley-cw4-head"><p class="amaley-cw4-kicker">' . self::esc( $a['right_kicker'] ) . '</p><h2 class="amaley-cw4-title">' . self::esc( $a['right_title'] ) . '</h2><p class="amaley-cw4-desc">' . self::esc( $a['right_description'] ) . '</p></div>';
		$out .= '<div class="amaley-cw4-origin-map-path-steps">';
		foreach ( $items as $item ) {
			$out .= '<div class="amaley-cw4-origin-map-path-step"><span>' . self::esc( self::item_text( $item, 'number', '01' ) ) . '</span><div><h3>' . self::esc( self::item_text( $item, 'title', 'Origin step' ) ) . '</h3><p>' . self::esc( self::item_text( $item, 'text', '' ) ) . '</p></div></div>';
		}
		$out .= '</div><div class="amaley-cw4-actions"><a class="amaley-cw4-btn" href="' . self::url( $a['button_url'] ) . '">' . self::esc( $a['button_text'] ) . '</a></div>';
		$out .= '</article></div></div></section>';

		return $out;
	}

	private static function parse_atts( $atts ) {
		$atts     = is_array( $atts ) ? $atts : array();
		$defaults = self::defaults();
		$out      = array_merge( $defaults, $atts );
		foreach ( $out as $key => $value ) {
			if ( is_array( $value ) && isset( $value['url'] ) ) {
				$out[ $key ] = (string) $value['url'];
			}
		}
		return $out;
	}

	private static function parse_items( $raw ) {
		if ( is_array( $raw ) && ! empty( $raw ) ) {
			return $raw;
		}
		$raw = trim( (string) $raw );
		if ( '' === $raw ) {
			return self::default_items();
		}
		$decoded = json_decode( $raw, true );
		return is_array( $decoded ) ? $decoded : self::default_items();
	}

	private static function item_text( $item, $key, $default = '' ) {
		return isset( $item[ $key ] ) ? (string) $item[ $key ] : $default;
	}

	private static function esc( $text ) {
		return function_exists( 'esc_html' ) ? esc_html( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}

	private static function attr( $text ) {
		return function_exists( 'esc_attr' ) ? esc_attr( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}

	private static function url( $text ) {
		return function_exists( 'esc_url' ) ? esc_url( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}
}
