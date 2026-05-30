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
			'description'       => 'The map traces ingredients moving from Himalayan clusters to women-led groups, small-batch production units and finally to the customer who brings Amaley home.',
			'right_kicker'      => 'FROM CLUSTER TO KITCHEN',
			'right_title'       => 'From Himalayan Clusters to Everyday Tables',
			'right_description' => 'Amaley connects the origin of ingredients, women-led SHGs, careful small-batch production and the customer who chooses a product with identity.',
			'map_kicker'        => 'AMALEY ORIGIN MAP',
			'map_title'         => 'From Cluster to Kitchen',
			'route_text'        => 'Sham Valley / Apricot Cluster to Nimmo SHG Group to Leh Women Makers to Product Hub to Customer',
			'foot_note'         => 'A visible journey helps customers see origin, care and community behind every product.',
			'button_text'       => 'Explore Amaley Origins',
			'button_url'        => '#',
			'map_image_url'     => '',
			'items'             => '',
		);
	}

	public static function default_items() {
		return array(
			array( 'number' => '01', 'title' => 'Cluster Origin', 'text' => 'Where the ingredient, landscape and local knowledge begin.' ),
			array( 'number' => '02', 'title' => 'Women-led Groups', 'text' => 'SHGs handle preparation, value addition and quality discipline.' ),
			array( 'number' => '03', 'title' => 'Small-batch Products', 'text' => 'Food is made with care, identity and consistency.' ),
			array( 'number' => '04', 'title' => 'Customer Connection', 'text' => 'Each purchase supports a visible livelihood chain.' ),
		);
	}

	public static function render( $atts = array() ) {
		$a     = self::parse_atts( $atts );
		$items = self::parse_items( $a['items'] );
		$style = '';

		if ( ! empty( $a['map_image_url'] ) ) {
			$style = ' style="background-image:linear-gradient(rgba(255,253,246,.10),rgba(255,253,246,.10)),url(' . self::url( $a['map_image_url'] ) . ')"';
		}

		$out  = '<section class="amaley-cw4 amaley-cw4-origin-map-path" data-acw="origin_map_path"><div class="amaley-cw4-inner">';
		$out .= '<div class="amaley-cw4-origin-map-path-shell">';
		$out .= '<article class="amaley-cw4-origin-map-path-panel amaley-cw4-origin-map-path-panel--map">';
		$out .= '<div class="amaley-cw4-head"><p class="amaley-cw4-kicker">' . self::esc( $a['kicker'] ) . '</p><h2 class="amaley-cw4-title">' . self::esc( $a['title'] ) . '</h2><p class="amaley-cw4-desc">' . self::esc( $a['description'] ) . '</p></div>';
		$out .= '<div class="amaley-cw4-origin-map-path-board">';
		$out .= '<p class="amaley-cw4-origin-map-path-board-kicker">' . self::esc( $a['map_kicker'] ) . '</p>';
		$out .= '<h3>' . self::esc( $a['map_title'] ) . '</h3>';
		$out .= '<div class="amaley-cw4-origin-map-path-canvas"' . $style . '>';
		$out .= '<span class="amaley-cw4-origin-map-path-zoom">+<br>-</span>';
		$out .= '<span class="amaley-cw4-origin-map-path-route"></span>';
		$out .= '<span class="amaley-cw4-origin-map-path-pin amaley-cw4-origin-map-path-pin--one">01</span>';
		$out .= '<span class="amaley-cw4-origin-map-path-pin amaley-cw4-origin-map-path-pin--two">02</span>';
		$out .= self::map_label( 'cluster', 'Cluster Origin', 'Apricot and Himalayan ingredient belt around Sham Valley.' );
		$out .= self::map_label( 'shg', 'SHG Group', 'Women-led group handling sorting and value addition.' );
		$out .= self::map_label( 'makers', 'Women Makers', 'Small-batch processing by trained women.' );
		$out .= self::map_label( 'products', 'Products', 'Ready for Amaley shelves.' );
		$out .= self::map_label( 'customer', 'Customer', 'Product reaching homestays, travellers and local buyers.' );
		$out .= '<span class="amaley-cw4-origin-map-path-credit">Map style reference</span>';
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

	private static function map_label( $slug, $title, $text ) {
		return '<div class="amaley-cw4-origin-map-path-label amaley-cw4-origin-map-path-label--' . self::attr( $slug ) . '"><strong>' . self::esc( $title ) . '</strong><small>' . self::esc( $text ) . '</small></div>';
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
