<?php
/**
 * Helper utilities.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitization, class and parsing helpers for renderers.
 */
final class Amaley_UI_Helpers {

	/**
	 * Returns a safe alignment value.
	 *
	 * @param string $align Raw align value.
	 * @return string
	 */
	public static function align( $align ) {
		$align = sanitize_key( $align );
		return in_array( $align, array( 'left', 'center', 'right' ), true ) ? $align : 'left';
	}

	/**
	 * Returns a safe button variant value.
	 *
	 * @param string $variant Raw variant value.
	 * @return string
	 */
	public static function button_variant( $variant ) {
		$variant = sanitize_key( $variant );
		return in_array( $variant, array( 'primary', 'secondary', 'outline', 'text', 'pill' ), true ) ? $variant : 'primary';
	}

	/**
	 * Returns a safe CTA tone.
	 *
	 * @param string $tone Raw tone value.
	 * @return string
	 */
	public static function tone( $tone ) {
		$tone = sanitize_key( $tone );
		return in_array( $tone, array( 'warm', 'deep', 'sand' ), true ) ? $tone : 'warm';
	}

	/**
	 * Sanitizes a CSS class string supplied by a shortcode user.
	 *
	 * @param string $classes Raw class string.
	 * @return string
	 */
	public static function extra_classes( $classes ) {
		$classes = preg_split( '/\s+/', (string) $classes );
		$classes = array_filter( array_map( 'sanitize_html_class', $classes ) );
		return implode( ' ', $classes );
	}

	/**
	 * Converts pipe-separated shortcode lists into safe text items.
	 *
	 * @param string $value Pipe-separated list.
	 * @return array<int,string>
	 */
	public static function pipe_list( $value ) {
		$items = array_map( 'trim', explode( '|', (string) $value ) );
		$items = array_filter( $items );
		return array_values( array_map( 'wp_strip_all_tags', $items ) );
	}

	/**
	 * Builds target and rel attributes for links.
	 *
	 * @param string $target Raw target value.
	 * @param string $rel Raw rel value.
	 * @return array<string,string>
	 */
	public static function link_meta( $target, $rel ) {
		$target = '_blank' === $target ? '_blank' : '_self';
		$rel    = sanitize_text_field( $rel );

		if ( '_blank' === $target && '' === $rel ) {
			$rel = 'noopener noreferrer';
		}

		return array(
			'target' => $target,
			'rel'    => $rel,
		);
	}

	/**
	 * Applies an accent span when the accent phrase exists inside the title.
	 *
	 * @param string $title  Raw title.
	 * @param string $accent Raw accent phrase.
	 * @return string Safe HTML.
	 */
	public static function accent_title( $title, $accent = '' ) {
		$title  = wp_strip_all_tags( (string) $title );
		$accent = wp_strip_all_tags( (string) $accent );

		if ( '' === $title ) {
			return '';
		}

		if ( '' === $accent || false === stripos( $title, $accent ) ) {
			return esc_html( $title );
		}

		$pattern = '/(' . preg_quote( $accent, '/' ) . ')/i';
		$parts   = preg_split( $pattern, $title, 2, PREG_SPLIT_DELIM_CAPTURE );

		if ( false === $parts || count( $parts ) < 3 ) {
			return esc_html( $title );
		}

		return esc_html( $parts[0] ) . '<span class="amaley-ui-heading__accent">' . esc_html( $parts[1] ) . '</span>' . esc_html( $parts[2] );
	}
}
