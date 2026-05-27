<?php
/**
 * Brand promise renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a compact brand promise strip.
 */
final class Amaley_UI_Brand_Promise {

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'label'       => 'Amaley Promise',
				'title'       => 'Rooted in Himalayan ingredients and careful production.',
				'description' => '',
				'items'       => 'Small-batch|Community-rooted|Quality checked',
				'align'       => 'left',
				'tone'        => 'warm',
				'class'       => '',
			),
			$atts,
			'amaley_brand_promise'
		);

		$align   = Amaley_UI_Helpers::align( $atts['align'] );
		$tone    = Amaley_UI_Helpers::tone( $atts['tone'] );
		$items   = Amaley_UI_Helpers::pipe_list( $atts['items'] );
		$extra   = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$classes = 'amaley-ui-promise-strip amaley-ui-promise-strip--' . $tone . ' amaley-ui-promise-strip--' . $align;
		$classes .= '' !== $extra ? ' ' . $extra : '';

		$html  = '<div class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-ui-promise-strip__content">';

		if ( '' !== trim( $atts['label'] ) ) {
			$html .= '<div class="amaley-ui-promise-strip__label">' . esc_html( $atts['label'] ) . '</div>';
		}

		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-ui-promise-strip__title">' . esc_html( $atts['title'] ) . '</h2>';
		}

		if ( '' !== trim( $atts['description'] ) ) {
			$html .= '<p class="amaley-ui-promise-strip__description">' . wp_kses_post( $atts['description'] ) . '</p>';
		}

		$html .= '</div>';

		if ( ! empty( $items ) ) {
			$html .= '<div class="amaley-ui-promise-strip__items">';
			foreach ( $items as $item ) {
				$html .= '<span class="amaley-ui-promise-strip__item">' . esc_html( $item ) . '</span>';
			}
			$html .= '</div>';
		}

		$html .= '</div>';

		return $html;
	}
}
