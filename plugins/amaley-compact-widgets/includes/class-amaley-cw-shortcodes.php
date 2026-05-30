<?php
/**
 * Shortcodes for Amaley Compact Widgets.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Shortcodes {
	public static function shortcode_map() {
		return array(
			'amaley_cw_info_cards'          => 'info_cards',
			'amaley_cw_split_editorial'     => 'split_editorial',
			'amaley_cw_traceability'        => 'traceability',
			'amaley_cw_origin_map'          => 'origin_map',
			'amaley_cw_gifting_band'        => 'gifting_band',
			'amaley_cw_value_strip'         => 'value_strip',
			'amaley_cw_process_steps'       => 'process_steps',
			'amaley_cw_origin_cards'        => 'origin_cards',
			'amaley_cw_purpose_cards'       => 'purpose_cards',
			'amaley_cw_collection_cards'    => 'collection_cards',
			'amaley_cw_two_panel_info'      => 'two_panel_info',
			'amaley_cw_dark_chain'          => 'dark_chain',
			'amaley_cw_image_flip_cards'    => 'image_flip_cards',
			'amaley_cw_image_cards'         => 'image_cards',
			'amaley_cw_image_info_cards'    => 'image_info_cards',
			'amaley_cw_image_overlay_cards' => 'image_overlay_cards',
			'amaley_cw_quote_cards'         => 'quote_cards',
			'amaley_cw_cta_tiles'           => 'cta_tiles',
			'amaley_cw_metric_tiles'        => 'metric_tiles',
		);
	}

	public function register() {
		foreach ( self::shortcode_map() as $shortcode => $method ) {
			add_shortcode( $shortcode, array( $this, $method ) );
		}
	}

	private function render( $method, $atts ) {
		if ( class_exists( 'Amaley_CW_Plugin' ) ) {
			Amaley_CW_Plugin::instance()->enqueue_assets();
		}
		return call_user_func( array( 'Amaley_CW_Renderer', $method ), is_array( $atts ) ? $atts : array() );
	}

	public function info_cards( $atts ) { return $this->render( 'info_cards', $atts ); }
	public function split_editorial( $atts ) { return $this->render( 'split_editorial', $atts ); }
	public function traceability( $atts ) { return $this->render( 'traceability', $atts ); }
	public function origin_map( $atts ) { if ( class_exists( 'Amaley_CW_Plugin' ) ) { Amaley_CW_Plugin::instance()->enqueue_assets(); } return class_exists( 'Amaley_CW_Origin_Map' ) ? Amaley_CW_Origin_Map::render( is_array( $atts ) ? $atts : array() ) : ''; }
	public function gifting_band( $atts ) { return $this->render( 'gifting_band', $atts ); }
	public function value_strip( $atts ) { return $this->render( 'value_strip', $atts ); }
	public function process_steps( $atts ) { return $this->render( 'process_steps', $atts ); }
	public function origin_cards( $atts ) { return $this->render( 'origin_cards', $atts ); }
	public function purpose_cards( $atts ) { return $this->render( 'purpose_cards', $atts ); }
	public function collection_cards( $atts ) { return $this->render( 'collection_cards', $atts ); }
	public function two_panel_info( $atts ) { return $this->render( 'two_panel_info', $atts ); }
	public function dark_chain( $atts ) { return $this->render( 'dark_chain', $atts ); }
	public function image_flip_cards( $atts ) { return $this->render( 'image_flip_cards', $atts ); }
	public function image_cards( $atts ) { return $this->render( 'image_cards', $atts ); }
	public function image_info_cards( $atts ) { return $this->render( 'image_info_cards', $atts ); }
	public function image_overlay_cards( $atts ) { return $this->render( 'image_overlay_cards', $atts ); }
	public function quote_cards( $atts ) { return $this->render( 'quote_cards', $atts ); }
	public function cta_tiles( $atts ) { return $this->render( 'cta_tiles', $atts ); }
	public function metric_tiles( $atts ) { return $this->render( 'metric_tiles', $atts ); }
}
