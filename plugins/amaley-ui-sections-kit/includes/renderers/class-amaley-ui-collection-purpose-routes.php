<?php
/**
 * Collection purpose routes renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a purpose-led collection routes section.
 */
final class Amaley_UI_Collection_Purpose_Routes {

	/**
	 * Default card data.
	 *
	 * @return array
	 */
	public static function default_cards() {
		return array(
			array(
				'number'      => '01',
				'label'       => 'Gifting',
				'title'       => 'For festive sets, boxes, and thoughtful hampers.',
				'description' => 'Choose items that feel coherent, place-rooted, and less generic than normal gift packs.',
				'button_text' => 'Explore Gift Boxes',
				'button_url'  => '#',
			),
			array(
				'number'      => '02',
				'label'       => 'Everyday Use',
				'title'       => 'For regular kitchens and repeat pantry buying.',
				'description' => 'Bring Amaley into daily routines through preserves, mixes, teas, oils, and staples.',
				'button_text' => 'View Everyday Collections',
				'button_url'  => '#',
			),
			array(
				'number'      => '03',
				'label'       => 'Hospitality',
				'title'       => 'For homestays, boutique stays, and guest tables.',
				'description' => 'Create breakfast, welcome, or in-room lines that feel local, premium, and guest-facing.',
				'button_text' => 'View Hospitality Collections',
				'button_url'  => '#',
			),
			array(
				'number'      => '04',
				'label'       => 'Seasonal',
				'title'       => 'For winter warmth, summer lightness, and festival-led lines.',
				'description' => 'Collections can be arranged around seasons, traditions, and regional ingredient cycles.',
				'button_text' => 'View Seasonal Collections',
				'button_url'  => '#',
			),
			array(
				'number'      => '05',
				'label'       => 'Retail Table',
				'title'       => 'For shelves, counters, and curated product storytelling.',
				'description' => 'Build clearer shelf logic so buyers understand where products come from and pair well.',
				'button_text' => 'View Retail Collections',
				'button_url'  => '#',
			),
			array(
				'number'      => '06',
				'label'       => 'SHG-led Showcase',
				'title'       => 'Let each group reveal the right collection.',
				'description' => 'Useful when the goal is to show traceability, women-led enterprise, and community production.',
				'button_text' => 'Browse Maker Collections',
				'button_url'  => '#',
			),
		);
	}

	/**
	 * Normalises cards from shortcode JSON or Elementor array.
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

			$normalised[] = array(
				'number'      => isset( $card['number'] ) ? (string) $card['number'] : '',
				'label'       => isset( $card['label'] ) ? (string) $card['label'] : '',
				'title'       => isset( $card['title'] ) ? (string) $card['title'] : '',
				'description' => isset( $card['description'] ) ? (string) $card['description'] : '',
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
				'eyebrow'     => 'Shop with purpose',
				'title'       => 'Start with {why you are buying}',
				'accent'      => 'why you are buying',
				'description' => 'Amaley collections are not just shelves full of products. They are buying routes for different needs — from gifts and hospitality placements to daily kitchen use and retail counters.',
				'cards'       => '',
				'tone'        => 'cream',
				'width'       => 'contained',
				'id'          => '',
				'class'       => '',
			),
			$atts,
			'amaley_collection_purpose_routes'
		);

		$tone  = in_array( $atts['tone'], array( 'cream', 'deep', 'white' ), true ) ? $atts['tone'] : 'cream';
		$width = in_array( $atts['width'], array( 'contained', 'full' ), true ) ? $atts['width'] : 'contained';
		$extra = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$cards = self::normalise_cards( $atts['cards'] );

		$classes  = 'amaley-collection-purpose-routes amaley-collection-purpose-routes--' . $tone;
		$classes .= ' amaley-collection-purpose-routes--' . $width;
		$classes .= '' !== $extra ? ' ' . $extra : '';
		$id_attr  = '' !== trim( $atts['id'] ) ? ' id="' . esc_attr( sanitize_title( $atts['id'] ) ) . '"' : '';

		$html  = '<section' . $id_attr . ' class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-collection-purpose-routes__inner">';
		$html .= '<div class="amaley-collection-purpose-routes__header">';
		$html .= '<div class="amaley-collection-purpose-routes__heading">';

		if ( '' !== trim( $atts['eyebrow'] ) ) {
			$html .= '<div class="amaley-collection-purpose-routes__eyebrow">' . esc_html( $atts['eyebrow'] ) . '</div>';
		}

		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-collection-purpose-routes__title">' . self::title_html( $atts['title'], $atts['accent'] ) . '</h2>';
		}

		$html .= '</div>';

		if ( '' !== trim( $atts['description'] ) ) {
			$html .= '<p class="amaley-collection-purpose-routes__description">' . wp_kses_post( $atts['description'] ) . '</p>';
		}

		$html .= '</div>';
		$html .= '<div class="amaley-collection-purpose-routes__grid">';

		foreach ( $cards as $card ) {
			$html .= '<article class="amaley-collection-purpose-routes__card">';

			if ( '' !== trim( $card['number'] ) || '' !== trim( $card['label'] ) ) {
				$html .= '<div class="amaley-collection-purpose-routes__card-kicker">';
				if ( '' !== trim( $card['number'] ) ) {
					$html .= '<span class="amaley-collection-purpose-routes__card-number">' . esc_html( $card['number'] ) . '</span>';
				}
				if ( '' !== trim( $card['label'] ) ) {
					$html .= '<span class="amaley-collection-purpose-routes__card-label">' . esc_html( $card['label'] ) . '</span>';
				}
				$html .= '</div>';
			}

			if ( '' !== trim( $card['title'] ) ) {
				$html .= '<h3 class="amaley-collection-purpose-routes__card-title">' . esc_html( $card['title'] ) . '</h3>';
			}

			if ( '' !== trim( $card['description'] ) ) {
				$html .= '<p class="amaley-collection-purpose-routes__card-description">' . wp_kses_post( $card['description'] ) . '</p>';
			}

			if ( '' !== trim( $card['button_text'] ) ) {
				$html .= '<a class="amaley-collection-purpose-routes__card-button" href="' . esc_url( $card['button_url'] ) . '">' . esc_html( $card['button_text'] ) . '</a>';
			}

			$html .= '</article>';
		}

		$html .= '</div>';
		$html .= '</div>';
		$html .= '</section>';

		return $html;
	}
}
