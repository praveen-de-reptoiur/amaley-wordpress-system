<?php
/** Shortcode registration. */
defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Shortcodes {
    public static function shortcode_map() {
        $map = array();
        foreach ( Amaley_CW_Renderer::widget_definitions() as $definition ) {
            $map[ $definition['shortcode'] ] = $definition['method'];
        }
        $map['amaley_cw_origin_map'] = 'origin_map';
        return $map;
    }
    public function register() {
        foreach ( self::shortcode_map() as $shortcode => $method ) {
            add_shortcode( $shortcode, array( $this, 'render' ) );
        }
    }
    public function render( $atts, $content = '', $tag = '' ) {
        if ( class_exists( 'Amaley_CW_Plugin' ) ) { Amaley_CW_Plugin::instance()->enqueue_assets(); }
        $map = self::shortcode_map();
        $method = isset( $map[ $tag ] ) ? $map[ $tag ] : '';
        if ( 'origin_map' === $method ) { return Amaley_CW_Origin_Map::render( is_array( $atts ) ? $atts : array() ); }
        if ( $method && method_exists( 'Amaley_CW_Renderer', $method ) ) { return call_user_func( array( 'Amaley_CW_Renderer', $method ), is_array( $atts ) ? $atts : array() ); }
        return '';
    }
}
