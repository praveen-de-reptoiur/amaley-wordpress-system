<?php
/**
 * Empty state renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders safe empty states.
 */
final class Amaley_UI_Empty_State {

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'       => 'Nothing to show yet.',
				'text'        => 'This section is ready, but content has not been added.',
				'button_text' => '',
				'button_url'  => '#',
				'align'       => 'center',
				'class'       => '',
			),
			$atts,
			'amaley_empty_state'
		);

		$align   = Amaley_UI_Helpers::align( $atts['align'] );
		$extra   = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$classes = 'amaley-ui-empty-state amaley-ui-empty-state--' . $align;
		$classes .= '' !== $extra ? ' ' . $extra : '';

		$html  = '<div class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-ui-empty-state__mark" aria-hidden="true"></div>';
		$html .= '<h2 class="amaley-ui-empty-state__title">' . esc_html( $atts['title'] ) . '</h2>';
		$html .= '<p class="amaley-ui-empty-state__text">' . wp_kses_post( $atts['text'] ) . '</p>';
		$html .= Amaley_UI_Button::link( $atts['button_text'], $atts['button_url'], 'primary' );
		$html .= '</div>';

		return $html;
	}
}
