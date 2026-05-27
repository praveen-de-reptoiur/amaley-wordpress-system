<?php
/**
 * Button renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders Amaley buttons.
 */
final class Amaley_UI_Button {

	/**
	 * Renders a button link.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'text'    => 'Explore',
				'url'     => '#',
				'variant' => 'primary',
				'align'   => 'left',
				'target'  => '_self',
				'rel'     => '',
				'class'   => '',
			),
			$atts,
			'amaley_button'
		);

		$variant  = Amaley_UI_Helpers::button_variant( $atts['variant'] );
		$align    = Amaley_UI_Helpers::align( $atts['align'] );
		$link     = Amaley_UI_Helpers::link_meta( $atts['target'], $atts['rel'] );
		$extra    = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$classes  = 'amaley-ui-btn amaley-ui-btn--' . $variant;
		$classes .= '' !== $extra ? ' ' . $extra : '';

		return '<div class="amaley-ui-btn-wrap amaley-ui-btn-wrap--' . esc_attr( $align ) . '"><a class="' . esc_attr( $classes ) . '" href="' . esc_url( $atts['url'] ) . '" target="' . esc_attr( $link['target'] ) . '" rel="' . esc_attr( $link['rel'] ) . '"><span>' . esc_html( $atts['text'] ) . '</span></a></div>';
	}

	/**
	 * Renders a button without wrapper for internal components.
	 *
	 * @param string $text    Button text.
	 * @param string $url     Button URL.
	 * @param string $variant Button variant.
	 * @return string
	 */
	public static function link( $text, $url, $variant = 'primary' ) {
		if ( '' === trim( $text ) ) {
			return '';
		}

		$variant = Amaley_UI_Helpers::button_variant( $variant );

		return '<a class="amaley-ui-btn amaley-ui-btn--' . esc_attr( $variant ) . '" href="' . esc_url( $url ) . '"><span>' . esc_html( $text ) . '</span></a>';
	}
}
