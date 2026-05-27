<?php
/**
 * Section heading renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a reusable Amaley section heading.
 */
final class Amaley_UI_Section_Heading {

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'label'       => '',
				'title'       => '',
				'accent'      => '',
				'description' => '',
				'align'       => 'left',
				'id'          => '',
				'class'       => '',
			),
			$atts,
			'amaley_section_heading'
		);

		$align   = Amaley_UI_Helpers::align( $atts['align'] );
		$classes = 'amaley-ui-section-heading amaley-ui-section-heading--' . $align;
		$extra   = Amaley_UI_Helpers::extra_classes( $atts['class'] );

		if ( '' !== $extra ) {
			$classes .= ' ' . $extra;
		}

		$id_attr = '' !== $atts['id'] ? ' id="' . esc_attr( sanitize_title( $atts['id'] ) ) . '"' : '';
		$html    = '<div' . $id_attr . ' class="' . esc_attr( $classes ) . '">';

		if ( '' !== trim( $atts['label'] ) ) {
			$html .= '<div class="amaley-ui-section-heading__label"><span></span>' . esc_html( $atts['label'] ) . '</div>';
		}

		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-ui-section-heading__title">' . Amaley_UI_Helpers::accent_title( $atts['title'], $atts['accent'] ) . '</h2>';
		}

		if ( '' !== trim( $atts['description'] ) ) {
			$html .= '<p class="amaley-ui-section-heading__description">' . wp_kses_post( $atts['description'] ) . '</p>';
		}

		$html .= '</div>';

		return $html;
	}
}
