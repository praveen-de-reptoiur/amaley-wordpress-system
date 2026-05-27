<?php
/**
 * Section container renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Internal foundation wrapper for UI sections.
 */
final class Amaley_UI_Section_Container {

	/**
	 * Renders a consistent section wrapper.
	 *
	 * @param string $content Inner HTML.
	 * @param array  $args    Wrapper args.
	 * @return string
	 */
	public static function render( $content, $args = array() ) {
		$defaults = array(
			'id'      => '',
			'class'   => '',
			'align'   => 'left',
			'tone'    => 'warm',
			'compact' => false,
		);

		$args = wp_parse_args( $args, $defaults );

		$align   = Amaley_UI_Helpers::align( $args['align'] );
		$tone    = Amaley_UI_Helpers::tone( $args['tone'] );
		$classes = array(
			'amaley-ui-section',
			'amaley-ui-section--align-' . $align,
			'amaley-ui-section--tone-' . $tone,
		);

		if ( ! empty( $args['compact'] ) ) {
			$classes[] = 'amaley-ui-section--compact';
		}

		$extra = Amaley_UI_Helpers::extra_classes( $args['class'] );
		if ( '' !== $extra ) {
			$classes[] = $extra;
		}

		$id_attr = '' !== $args['id'] ? ' id="' . esc_attr( sanitize_title( $args['id'] ) ) . '"' : '';

		return '<section' . $id_attr . ' class="' . esc_attr( implode( ' ', $classes ) ) . '"><div class="amaley-ui-section__inner">' . $content . '</div></section>';
	}
}
