<?php
/**
 * CTA band renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a premium CTA band.
 */
final class Amaley_UI_CTA_Band {

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'label'          => '',
				'title'          => 'Bring Amaley to your customers.',
				'text'           => '',
				'primary_text'   => 'Enquire now',
				'primary_url'    => '#',
				'secondary_text' => '',
				'secondary_url'  => '#',
				'align'          => 'left',
				'tone'           => 'deep',
				'class'          => '',
			),
			$atts,
			'amaley_cta_band'
		);

		$align   = Amaley_UI_Helpers::align( $atts['align'] );
		$tone    = Amaley_UI_Helpers::tone( $atts['tone'] );
		$extra   = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$classes = 'amaley-ui-cta-band amaley-ui-cta-band--' . $tone . ' amaley-ui-cta-band--' . $align;
		$classes .= '' !== $extra ? ' ' . $extra : '';

		$html  = '<div class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-ui-cta-band__content">';

		if ( '' !== trim( $atts['label'] ) ) {
			$html .= '<div class="amaley-ui-cta-band__label">' . esc_html( $atts['label'] ) . '</div>';
		}

		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-ui-cta-band__title">' . esc_html( $atts['title'] ) . '</h2>';
		}

		if ( '' !== trim( $atts['text'] ) ) {
			$html .= '<p class="amaley-ui-cta-band__text">' . wp_kses_post( $atts['text'] ) . '</p>';
		}

		$html .= '</div>';
		$html .= '<div class="amaley-ui-cta-band__actions">';
		$html .= Amaley_UI_Button::link( $atts['primary_text'], $atts['primary_url'], 'secondary' );
		$html .= Amaley_UI_Button::link( $atts['secondary_text'], $atts['secondary_url'], 'outline' );
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}
