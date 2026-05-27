<?php
/**
 * Button group renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders grouped Amaley buttons.
 */
final class Amaley_UI_Button_Group {

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'primary_text'   => 'Explore Amaley',
				'primary_url'    => '#',
				'secondary_text' => '',
				'secondary_url'  => '#',
				'align'          => 'left',
				'class'          => '',
			),
			$atts,
			'amaley_button_group'
		);

		$align   = Amaley_UI_Helpers::align( $atts['align'] );
		$extra   = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$classes = 'amaley-ui-btn-group amaley-ui-btn-group--' . $align;
		$classes .= '' !== $extra ? ' ' . $extra : '';

		$html  = '<div class="' . esc_attr( $classes ) . '">';
		$html .= Amaley_UI_Button::link( $atts['primary_text'], $atts['primary_url'], 'primary' );
		$html .= Amaley_UI_Button::link( $atts['secondary_text'], $atts['secondary_url'], 'outline' );
		$html .= '</div>';

		return $html;
	}
}
