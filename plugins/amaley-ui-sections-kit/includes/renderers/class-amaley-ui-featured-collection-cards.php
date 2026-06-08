<?php
/**
 * Featured collection cards renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a featured collection-card section for collection landing pages.
 */
final class Amaley_UI_Featured_Collection_Cards {

	/**
	 * Default card data.
	 *
	 * @return array
	 */
	public static function default_cards() {
		return array(
			array(
				'tone'        => 'light',
				'kicker'      => 'Breakfast & Pantry',
				'title'       => 'Daily jars, mixes, staples, and table-ready products.',
				'description' => 'A practical route for repeat buying, home kitchens, and everyday food shelves.',
				'meta'        => 'Good for regular household use',
				'button_text' => 'Explore Pantry Sets',
				'button_url'  => '#',
			),
			array(
				'tone'        => 'light',
				'kicker'      => 'Wellness & Ritual',
				'title'       => 'Infusions, natural ingredients, and slower daily rituals.',
				'description' => 'Useful for customers looking for calm routines, seasonal care, and Himalayan ingredient stories.',
				'meta'        => 'Good for wellness shelves',
				'button_text' => 'View Wellness Picks',
				'button_url'  => '#',
			),
			array(
				'tone'        => 'deep',
				'kicker'      => 'Gift Boxes & Hampers',
				'title'       => 'Build curated gifts with place, purpose, and warmth.',
				'description' => 'For festivals, institutions, guests, teams, and thoughtful gifting moments.',
				'meta'        => 'Custom combinations available',
				'button_text' => 'Plan a Gift Set',
				'button_url'  => '#',
			),
		);
	}

	/**
	 * Normalises cards from shortcode JSON or Elementor repeater array.
	 *
	 * @param mixed $cards Cards input.
	 * @return array
	 */
	public static function normalise_cards( $cards ) {
		if ( is_string( $cards ) && '' !== trim( $cards ) ) {
			$decoded = json_decode( wp_unslash( $cards ), true );
			if ( is_array( $decoded ) ) {
				$cards = $decoded;
			}
		}

		if ( ! is_array( $cards ) || empty( $cards ) ) {
			$cards = self::default_cards();
		}

		$normalised = array();
		foreach ( $cards as $card ) {
			if ( ! is_array( $card ) ) {
				continue;
			}

			$tone = isset( $card['tone'] ) ? (string) $card['tone'] : 'light';
			$tone = in_array( $tone, array( 'light', 'deep', 'accent' ), true ) ? $tone : 'light';

			$normalised[] = array(
				'tone'        => $tone,
				'kicker'      => isset( $card['kicker'] ) ? (string) $card['kicker'] : '',
				'title'       => isset( $card['title'] ) ? (string) $card['title'] : '',
				'description' => isset( $card['description'] ) ? (string) $card['description'] : '',
				'meta'        => isset( $card['meta'] ) ? (string) $card['meta'] : '',
				'button_text' => isset( $card['button_text'] ) ? (string) $card['button_text'] : '',
				'button_url'  => isset( $card['button_url'] ) ? (string) $card['button_url'] : '#',
			);
		}

		return ! empty( $normalised ) ? $normalised : self::default_cards();
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
	 * Renders the section.
	 *
	 * @param array $atts Shortcode/Elementor attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'eyebrow'     => 'Featured collections',
				'title'       => 'Collections by {why you are buying}',
				'accent'      => 'why you are buying',
				'description' => 'Choose a collection route that matches the moment — everyday pantry, wellness routines, hospitality tables, or gifting needs.',
				'cards'       => '',
				'tone'        => 'cream',
				'width'       => 'contained',
				'id'          => '',
				'class'       => '',
			),
			$atts,
			'amaley_featured_collection_cards'
		);

		$tone  = in_array( $atts['tone'], array( 'cream', 'deep', 'white' ), true ) ? $atts['tone'] : 'cream';
		$width = in_array( $atts['width'], array( 'contained', 'full' ), true ) ? $atts['width'] : 'contained';
		$extra = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$cards = self::normalise_cards( $atts['cards'] );

		$classes  = 'amaley-featured-collection-cards amaley-featured-collection-cards--' . $tone;
		$classes .= ' amaley-featured-collection-cards--' . $width;
		$classes .= '' !== $extra ? ' ' . $extra : '';
		$id_attr  = '' !== trim( $atts['id'] ) ? ' id="' . esc_attr( sanitize_title( $atts['id'] ) ) . '"' : '';

		$html  = '<section' . $id_attr . ' class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-featured-collection-cards__inner">';
		$html .= '<div class="amaley-featured-collection-cards__header">';
		$html .= '<div class="amaley-featured-collection-cards__heading">';

		if ( '' !== trim( $atts['eyebrow'] ) ) {
			$html .= '<div class="amaley-featured-collection-cards__eyebrow">' . esc_html( $atts['eyebrow'] ) . '</div>';
		}

		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-featured-collection-cards__title">' . self::title_html( $atts['title'], $atts['accent'] ) . '</h2>';
		}

		$html .= '</div>';

		if ( '' !== trim( $atts['description'] ) ) {
			$html .= '<p class="amaley-featured-collection-cards__description">' . wp_kses_post( $atts['description'] ) . '</p>';
		}

		$html .= '</div>';
		$html .= '<div class="amaley-featured-collection-cards__grid">';

		foreach ( $cards as $card ) {
			$html .= '<article class="amaley-featured-collection-cards__card amaley-featured-collection-cards__card--' . esc_attr( $card['tone'] ) . '">';
			$html .= '<div class="amaley-featured-collection-cards__card-body">';

			if ( '' !== trim( $card['kicker'] ) ) {
				$html .= '<div class="amaley-featured-collection-cards__card-kicker">' . esc_html( $card['kicker'] ) . '</div>';
			}

			if ( '' !== trim( $card['title'] ) ) {
				$html .= '<h3 class="amaley-featured-collection-cards__card-title">' . esc_html( $card['title'] ) . '</h3>';
			}

			if ( '' !== trim( $card['description'] ) ) {
				$html .= '<p class="amaley-featured-collection-cards__card-description">' . wp_kses_post( $card['description'] ) . '</p>';
			}

			$html .= '</div>';
			$html .= '<div class="amaley-featured-collection-cards__card-footer">';

			if ( '' !== trim( $card['meta'] ) ) {
				$html .= '<div class="amaley-featured-collection-cards__card-meta">' . esc_html( $card['meta'] ) . '</div>';
			}

			if ( '' !== trim( $card['button_text'] ) ) {
				$html .= '<a class="amaley-featured-collection-cards__card-button" href="' . esc_url( $card['button_url'] ) . '">' . esc_html( $card['button_text'] ) . '</a>';
			}

			$html .= '</div>';
			$html .= '</article>';
		}

		$html .= '</div>';
		$html .= '</div>';
		$html .= '</section>';

		return $html;
	}
}
