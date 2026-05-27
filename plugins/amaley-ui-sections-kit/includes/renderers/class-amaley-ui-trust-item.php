<?php
/**
 * Trust item renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a small trust/value item.
 */
final class Amaley_UI_Trust_Item {

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'icon'  => 'leaf',
				'title' => 'Naturally rooted',
				'text'  => '',
				'align' => 'left',
				'class' => '',
			),
			$atts,
			'amaley_trust_item'
		);

		$align   = Amaley_UI_Helpers::align( $atts['align'] );
		$extra   = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$classes = 'amaley-ui-trust-item amaley-ui-trust-item--' . $align;
		$classes .= '' !== $extra ? ' ' . $extra : '';

		$html  = '<div class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-ui-trust-item__icon">' . self::icon_svg( $atts['icon'] ) . '</div>';
		$html .= '<div class="amaley-ui-trust-item__body">';
		$html .= '<h3 class="amaley-ui-trust-item__title">' . esc_html( $atts['title'] ) . '</h3>';

		if ( '' !== trim( $atts['text'] ) ) {
			$html .= '<p class="amaley-ui-trust-item__text">' . wp_kses_post( $atts['text'] ) . '</p>';
		}

		$html .= '</div></div>';

		return $html;
	}

	/**
	 * Returns a tiny inline SVG icon.
	 *
	 * @param string $icon Icon key.
	 * @return string
	 */
	private static function icon_svg( $icon ) {
		$icon = sanitize_key( $icon );

		$paths = array(
			'leaf'     => '<path d="M20 4c-7.5.7-12.6 4.8-14.2 10.5C4.7 18.5 7.4 21 11 20.5c5.7-.8 9.2-7.1 9-16.5Z"/><path d="M6.2 19.2c3.8-5.9 7.4-8.8 12.6-12"/>',
			'heart'    => '<path d="M12 21s-7.5-4.4-9.6-9.1C.9 8.4 2.9 5 6.2 5c1.9 0 3.4 1 4.3 2.4C11.4 6 12.9 5 14.8 5c3.3 0 5.3 3.4 3.8 6.9C16.5 16.6 12 21 12 21Z"/>',
			'check'    => '<path d="M20 6 9 17l-5-5"/>',
			'mountain' => '<path d="m3 19 6.5-11 4 6 2-3L21 19H3Z"/><path d="m9.5 8 1.7 3h-3.4"/>',
			'hand'     => '<path d="M7 11V6.8a1.8 1.8 0 1 1 3.6 0V11"/><path d="M10.6 11V5.8a1.8 1.8 0 1 1 3.6 0V12"/><path d="M14.2 12V8.4a1.8 1.8 0 1 1 3.6 0V14c0 4-2.5 7-6.6 7-3.6 0-6.2-2.2-7.2-5.6L3.1 12a1.7 1.7 0 0 1 3.2-1.1L7 13"/>',
		);

		$path = isset( $paths[ $icon ] ) ? $paths[ $icon ] : $paths['leaf'];

		return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
	}
}
