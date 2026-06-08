<?php
/**
 * Collection detail split renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a collection detail split section for collection landing pages.
 */
final class Amaley_UI_Collection_Detail_Split {

	/**
	 * Default detail items.
	 *
	 * @return array
	 */
	public static function default_detail_items() {
		return array(
			array(
				'label' => 'What is inside',
				'text'  => 'Preserves, oils, tea pairing, and seasonal add-ons.',
			),
			array(
				'label' => 'Best for',
				'text'  => 'Corporate gifting, homestay counters, boutique retail.',
			),
			array(
				'label' => 'Cluster to box',
				'text'  => 'Made visible through Amaley’s SHG and cluster traceability.',
			),
			array(
				'label' => 'How it works',
				'text'  => 'Choose set size, message, packaging, and delivery plan.',
			),
		);
	}

	/**
	 * Default guide items.
	 *
	 * @return array
	 */
	public static function default_guide_items() {
		return array(
			array(
				'label' => 'Buyer purpose',
				'text'  => 'Gifting / Hospitality / Retail / Everyday Use',
			),
			array(
				'label' => 'Origin story',
				'text'  => 'Cluster, SHG group, maker, and product linkage',
			),
			array(
				'label' => 'Commercial use',
				'text'  => 'Quantity, pairing, pricing, and reorder logic',
			),
		);
	}

	/**
	 * Normalises repeater items.
	 *
	 * @param mixed $items Items input.
	 * @param array $defaults Default items.
	 * @return array
	 */
	public static function normalise_items( $items, $defaults ) {
		if ( is_string( $items ) && '' !== trim( $items ) ) {
			$decoded = json_decode( wp_unslash( $items ), true );
			if ( is_array( $decoded ) ) {
				$items = $decoded;
			}
		}

		if ( ! is_array( $items ) || empty( $items ) ) {
			$items = $defaults;
		}

		$normalised = array();
		foreach ( $items as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$normalised[] = array(
				'label' => isset( $item['label'] ) ? (string) $item['label'] : '',
				'text'  => isset( $item['text'] ) ? (string) $item['text'] : '',
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
	 * Renders an anchor button.
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

		return '<a class="amaley-collection-detail-split__button amaley-collection-detail-split__button--' . esc_attr( $modifier ) . '" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a>';
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
				'eyebrow'          => 'Limited collection · from apricot clusters',
				'title'            => 'The Apricot Table {Collection}',
				'accent'           => 'Collection',
				'description'      => 'This box brings together Amaley’s apricot-led story across preserves, kernel oil, and complementary teas. It is designed for gifting and hospitality use where the buyer wants a soft Himalayan story and a balanced table experience.',
				'detail_items'     => '',
				'primary_text'     => 'Build this collection',
				'primary_url'      => '#',
				'secondary_text'   => 'Ask a question',
				'secondary_url'    => '#',
				'guide_icon'       => '🎁',
				'guide_title'      => 'What should every Amaley collection page make clear?',
				'guide_text'       => 'The buyer should understand the purpose of the collection, where the products come from, and how it can be used for gifting, hospitality, retail, or everyday purchase.',
				'guide_items'      => '',
				'tone'             => 'cream',
				'width'            => 'contained',
				'id'               => '',
				'class'            => '',
			),
			$atts,
			'amaley_collection_detail_split'
		);

		$tone         = in_array( $atts['tone'], array( 'cream', 'white', 'deep', 'soft-gold' ), true ) ? $atts['tone'] : 'cream';
		$width        = in_array( $atts['width'], array( 'contained', 'full' ), true ) ? $atts['width'] : 'contained';
		$extra        = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$detail_items = self::normalise_items( $atts['detail_items'], self::default_detail_items() );
		$guide_items  = self::normalise_items( $atts['guide_items'], self::default_guide_items() );

		$classes  = 'amaley-collection-detail-split amaley-collection-detail-split--' . $tone;
		$classes .= ' amaley-collection-detail-split--' . $width;
		$classes .= '' !== $extra ? ' ' . $extra : '';
		$id_attr  = '' !== trim( $atts['id'] ) ? ' id="' . esc_attr( sanitize_title( $atts['id'] ) ) . '"' : '';

		$html  = '<section' . $id_attr . ' class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-collection-detail-split__inner">';
		$html .= '<div class="amaley-collection-detail-split__grid">';

		$html .= '<article class="amaley-collection-detail-split__panel amaley-collection-detail-split__panel--primary">';
		if ( '' !== trim( $atts['eyebrow'] ) ) {
			$html .= '<div class="amaley-collection-detail-split__eyebrow">' . esc_html( $atts['eyebrow'] ) . '</div>';
		}
		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-collection-detail-split__title">' . self::title_html( $atts['title'], $atts['accent'] ) . '</h2>';
		}
		if ( '' !== trim( $atts['description'] ) ) {
			$html .= '<p class="amaley-collection-detail-split__description">' . wp_kses_post( $atts['description'] ) . '</p>';
		}

		$html .= '<div class="amaley-collection-detail-split__detail-grid">';
		foreach ( $detail_items as $item ) {
			$html .= '<div class="amaley-collection-detail-split__detail-item">';
			if ( '' !== trim( $item['label'] ) ) {
				$html .= '<div class="amaley-collection-detail-split__detail-label">' . esc_html( $item['label'] ) . '</div>';
			}
			if ( '' !== trim( $item['text'] ) ) {
				$html .= '<p class="amaley-collection-detail-split__detail-text">' . wp_kses_post( $item['text'] ) . '</p>';
			}
			$html .= '</div>';
		}
		$html .= '</div>';

		$html .= '<div class="amaley-collection-detail-split__actions">';
		$html .= self::button_html( $atts['primary_text'], $atts['primary_url'], 'primary' );
		$html .= self::button_html( $atts['secondary_text'], $atts['secondary_url'], 'secondary' );
		$html .= '</div>';
		$html .= '</article>';

		$html .= '<aside class="amaley-collection-detail-split__panel amaley-collection-detail-split__panel--guide">';
		if ( '' !== trim( $atts['guide_icon'] ) ) {
			$html .= '<div class="amaley-collection-detail-split__guide-icon" aria-hidden="true">' . esc_html( $atts['guide_icon'] ) . '</div>';
		}
		if ( '' !== trim( $atts['guide_title'] ) ) {
			$html .= '<h3 class="amaley-collection-detail-split__guide-title">' . esc_html( $atts['guide_title'] ) . '</h3>';
		}
		if ( '' !== trim( $atts['guide_text'] ) ) {
			$html .= '<p class="amaley-collection-detail-split__guide-text">' . wp_kses_post( $atts['guide_text'] ) . '</p>';
		}

		$html .= '<div class="amaley-collection-detail-split__guide-list">';
		foreach ( $guide_items as $item ) {
			$html .= '<div class="amaley-collection-detail-split__guide-item">';
			if ( '' !== trim( $item['label'] ) ) {
				$html .= '<div class="amaley-collection-detail-split__guide-label">' . esc_html( $item['label'] ) . '</div>';
			}
			if ( '' !== trim( $item['text'] ) ) {
				$html .= '<p class="amaley-collection-detail-split__guide-item-text">' . wp_kses_post( $item['text'] ) . '</p>';
			}
			$html .= '</div>';
		}
		$html .= '</div>';

		$html .= '</aside>';

		$html .= '</div>';
		$html .= '</div>';
		$html .= '</section>';

		return $html;
	}
}
