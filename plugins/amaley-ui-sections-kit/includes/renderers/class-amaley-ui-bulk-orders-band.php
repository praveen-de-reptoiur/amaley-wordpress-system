<?php
/**
 * Bulk orders band renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a dark editorial band for bulk orders and institutional enquiries.
 */
final class Amaley_UI_Bulk_Orders_Band {

	/**
	 * Default feature cards.
	 *
	 * @return array
	 */
	public static function default_features() {
		return array(
			array(
				'title' => 'Small team gifting',
				'text'  => 'For founders, offices, and thoughtful end-of-year hampers.',
			),
			array(
				'title' => 'Corporate and institutional orders',
				'text'  => 'For larger quantities, storytelling inserts, and repeat supply.',
			),
			array(
				'title' => 'Hospitality and shelf placement',
				'text'  => 'For breakfast counters, welcome tables, and boutique retail.',
			),
		);
	}

	/**
	 * Normalises feature cards.
	 *
	 * @param mixed $features Features input.
	 * @return array
	 */
	public static function normalise_features( $features ) {
		$defaults = self::default_features();

		if ( is_string( $features ) && '' !== trim( $features ) ) {
			$decoded = json_decode( wp_unslash( $features ), true );
			if ( is_array( $decoded ) ) {
				$features = $decoded;
			}
		}

		if ( ! is_array( $features ) || empty( $features ) ) {
			$features = $defaults;
		}

		$normalised = array();
		foreach ( $features as $feature ) {
			if ( ! is_array( $feature ) ) {
				continue;
			}

			$normalised[] = array(
				'title' => isset( $feature['title'] ) ? (string) $feature['title'] : '',
				'text'  => isset( $feature['text'] ) ? (string) $feature['text'] : '',
			);
		}

		return ! empty( $normalised ) ? $normalised : $defaults;
	}

	/**
	 * Renders title text with brace-based accent markup.
	 *
	 * @param string $title Title text.
	 * @param string $accent Accent phrase.
	 * @return string Safe HTML.
	 */
	private static function title_html( $title, $accent ) {
		$title  = (string) $title;
		$accent = (string) $accent;

		if ( '' !== $accent && false !== strpos( $title, '{' . $accent . '}' ) ) {
			return str_replace( '{' . $accent . '}', '<em>' . esc_html( $accent ) . '</em>', esc_html( $title ) );
		}

		if ( false !== strpos( $title, '{' ) && false !== strpos( $title, '}' ) ) {
			return preg_replace_callback(
				'/\{([^}]+)\}/',
				function( $matches ) {
					return '<em>' . esc_html( $matches[1] ) . '</em>';
				},
				esc_html( $title )
			);
		}

		return esc_html( $title );
	}

	/**
	 * Renders a button.
	 *
	 * @param string $text Button text.
	 * @param string $url Button URL.
	 * @param string $modifier Modifier class.
	 * @return string
	 */
	private static function button_html( $text, $url, $modifier ) {
		if ( '' === trim( (string) $text ) ) {
			return '';
		}

		return '<a class="amaley-bulk-orders-band__button amaley-bulk-orders-band__button--' . esc_attr( $modifier ) . '" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a>';
	}

	/**
	 * Renders the section.
	 *
	 * @param array $atts Shortcode/Elementor attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'eyebrow'        => 'Bulk orders',
				'title'          => 'Corporate gifting, hospitality, events, and retail supply',
				'accent'         => '',
				'description'    => 'Amaley collections are suitable for larger use cases — festive gifting, hospitality counters, guest welcome hampers, premium counters, and institutional buyer needs.',
				'features'       => '',
				'primary_text'   => 'Submit bulk enquiry',
				'primary_url'    => '#',
				'secondary_text' => 'Explore buyer-ready collections',
				'secondary_url'  => '#',
				'tone'           => 'deep',
				'width'          => 'contained',
				'id'             => '',
				'class'          => '',
			),
			$atts,
			'amaley_bulk_orders_band'
		);

		$tone     = in_array( $atts['tone'], array( 'deep', 'green', 'cream' ), true ) ? $atts['tone'] : 'deep';
		$width    = in_array( $atts['width'], array( 'contained', 'full' ), true ) ? $atts['width'] : 'contained';
		$extra    = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$features = self::normalise_features( $atts['features'] );

		$classes  = 'amaley-bulk-orders-band amaley-bulk-orders-band--' . $tone;
		$classes .= ' amaley-bulk-orders-band--' . $width;
		$classes .= '' !== $extra ? ' ' . $extra : '';
		$id_attr  = '' !== trim( $atts['id'] ) ? ' id="' . esc_attr( sanitize_title( $atts['id'] ) ) . '"' : '';

		$html  = '<section' . $id_attr . ' class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-bulk-orders-band__inner">';
		$html .= '<div class="amaley-bulk-orders-band__content">';

		if ( '' !== trim( $atts['eyebrow'] ) ) {
			$html .= '<div class="amaley-bulk-orders-band__eyebrow">' . esc_html( $atts['eyebrow'] ) . '</div>';
		}

		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-bulk-orders-band__title">' . self::title_html( $atts['title'], $atts['accent'] ) . '</h2>';
		}

		if ( '' !== trim( $atts['description'] ) ) {
			$html .= '<p class="amaley-bulk-orders-band__description">' . wp_kses_post( $atts['description'] ) . '</p>';
		}

		$html .= '</div>';
		$html .= '<div class="amaley-bulk-orders-band__features">';

		foreach ( $features as $feature ) {
			$html .= '<article class="amaley-bulk-orders-band__feature">';

			if ( '' !== trim( $feature['title'] ) ) {
				$html .= '<h3 class="amaley-bulk-orders-band__feature-title">' . esc_html( $feature['title'] ) . '</h3>';
			}

			if ( '' !== trim( $feature['text'] ) ) {
				$html .= '<p class="amaley-bulk-orders-band__feature-text">' . wp_kses_post( $feature['text'] ) . '</p>';
			}

			$html .= '</article>';
		}

		$html .= '</div>';
		$html .= '<div class="amaley-bulk-orders-band__actions">';
		$html .= self::button_html( $atts['primary_text'], $atts['primary_url'], 'primary' );
		$html .= self::button_html( $atts['secondary_text'], $atts['secondary_url'], 'secondary' );
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</section>';

		return $html;
	}
}
