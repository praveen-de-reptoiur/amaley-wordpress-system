<?php
/**
 * Page trust strip renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders reusable page trust/promise strip for hero-below and page-intro sections.
 */
final class Amaley_UI_Trust_Strip {

	/**
	 * Render trust strip.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts  = self::normalize_atts( $atts );
		$items = self::normalize_items( $atts );

		if ( empty( $items ) ) {
			return '';
		}

		$classes  = 'amaley-ui-page-trust-strip amaley-ui-trust-strip';
		$classes .= ' amaley-ui-trust-strip--tone-' . $atts['tone'];
		$classes .= ' amaley-ui-trust-strip--style-' . $atts['style'];
		$classes .= ' amaley-ui-trust-strip--cols-' . absint( $atts['columns'] );
		$classes .= ' amaley-ui-trust-strip--mobile-' . $atts['mobile'];
		$classes .= ' amaley-ui-trust-strip--motion-' . $atts['motion'];
		$classes .= ' amaley-ui-trust-strip--align-' . $atts['align'];
		$classes .= ' amaley-ui-trust-strip--width-' . $atts['width'];
		$classes .= '' !== $atts['class'] ? ' ' . $atts['class'] : '';

		$html  = '<section class="' . esc_attr( $classes ) . '" aria-label="' . esc_attr__( 'Amaley trust highlights', 'amaley-ui-sections-kit' ) . '">';
		$html .= '<div class="amaley-ui-trust-strip__inner">';

		if ( '' !== $atts['label'] || '' !== $atts['title'] ) {
			$html .= '<div class="amaley-ui-trust-strip__intro">';
			if ( '' !== $atts['label'] ) {
				$html .= '<div class="amaley-ui-trust-strip__label">' . esc_html( $atts['label'] ) . '</div>';
			}
			if ( '' !== $atts['title'] ) {
				$html .= '<h2 class="amaley-ui-trust-strip__heading">' . wp_kses_post( $atts['title'] ) . '</h2>';
			}
			$html .= '</div>';
		}

		$html .= '<div class="amaley-ui-trust-strip__items">';
		foreach ( $items as $item ) {
			$html .= '<article class="amaley-ui-trust-strip__item">';
			$html .= '<span class="amaley-ui-trust-strip__icon" aria-hidden="true">' . self::icon_svg( $item['icon'] ) . '</span>';
			$html .= '<span class="amaley-ui-trust-strip__copy">';
			$html .= '<strong class="amaley-ui-trust-strip__item-title">' . esc_html( $item['title'] ) . '</strong>';
			if ( '' !== $item['text'] ) {
				$html .= '<span class="amaley-ui-trust-strip__item-text">' . esc_html( $item['text'] ) . '</span>';
			}
			$html .= '</span></article>';
		}
		$html .= '</div></div></section>';

		return $html;
	}

	/**
	 * Normalize attributes.
	 *
	 * @param array $atts Raw attributes.
	 * @return array
	 */
	private static function normalize_atts( $atts ) {
		$atts = shortcode_atts(
			array(
				'label'          => '',
				'title'          => 'Rooted in taste, trust & traceability.',
				'items'          => 'Never bulk|Small batch|Himalayan sourced|Cluster linked',
				'texts'          => 'Made with care, not pressure.|Produced in careful small lots.|Built around mountain ingredients.|Connected to real producer clusters.',
				'icons'          => 'shield|batch|mountain|cluster',
				'tone'           => 'cream',
				'style'          => 'cards',
				'columns'        => 4,
				'mobile'         => 'stack',
				'motion'         => 'glow',
				'transformation' => '',
				'align'          => 'left',
				'width'          => 'contained',
				'class'          => '',
				'items_array'    => array(),
			),
			$atts,
			'amaley_page_trust_strip'
		);

		$atts['label']   = wp_strip_all_tags( (string) $atts['label'] );
		$atts['title']   = wp_kses_post( (string) $atts['title'] );
		$atts['tone']    = self::safe_choice( $atts['tone'], array( 'cream', 'white', 'sand', 'deep', 'green' ), 'cream' );
		$atts['style']   = self::safe_choice( $atts['style'], array( 'cards', 'compact', 'minimal' ), 'cards' );
		$atts['columns'] = max( 2, min( 5, absint( $atts['columns'] ) ) );
		$atts['mobile']  = self::safe_choice( $atts['mobile'], array( 'scroll', 'stack' ), 'stack' );

		$motion_source = '' !== (string) $atts['transformation'] ? (string) $atts['transformation'] : (string) $atts['motion'];
		$motion_source = str_replace( '_', '-', sanitize_key( $motion_source ) );
		$aliases       = array(
			'gold-glow'     => 'glow',
			'goldglow'      => 'glow',
			'glow'          => 'glow',
			'soft-motion'   => 'soft',
			'soft'          => 'soft',
			'lift-on-hover' => 'lift',
			'lift'          => 'lift',
			'none'          => 'none',
		);
		$atts['motion'] = isset( $aliases[ $motion_source ] ) ? $aliases[ $motion_source ] : 'glow';
		$atts['align']  = Amaley_UI_Helpers::align( $atts['align'] );
		$atts['width']  = self::safe_choice( $atts['width'], array( 'contained', 'full', 'full-bleed' ), 'contained' );
		$atts['class']  = Amaley_UI_Helpers::extra_classes( $atts['class'] );

		return $atts;
	}

	/**
	 * Normalize items from Elementor repeater or pipe strings.
	 *
	 * @param array $atts Normalized attributes.
	 * @return array
	 */
	private static function normalize_items( $atts ) {
		$items = array();

		if ( ! empty( $atts['items_array'] ) && is_array( $atts['items_array'] ) ) {
			foreach ( $atts['items_array'] as $raw_item ) {
				$title = isset( $raw_item['title'] ) ? wp_strip_all_tags( $raw_item['title'] ) : '';
				$text  = isset( $raw_item['text'] ) ? wp_strip_all_tags( $raw_item['text'] ) : '';
				$icon  = isset( $raw_item['icon'] ) ? sanitize_key( $raw_item['icon'] ) : 'leaf';
				if ( '' !== $title ) {
					$items[] = array( 'icon' => self::safe_icon( $icon ), 'title' => $title, 'text' => $text );
				}
			}
			return $items;
		}

		$titles = Amaley_UI_Helpers::pipe_list( $atts['items'] );
		$texts  = Amaley_UI_Helpers::pipe_list( $atts['texts'] );
		$icons  = Amaley_UI_Helpers::pipe_list( $atts['icons'] );

		foreach ( $titles as $index => $title ) {
			$items[] = array(
				'icon'  => self::safe_icon( isset( $icons[ $index ] ) ? $icons[ $index ] : 'leaf' ),
				'title' => $title,
				'text'  => isset( $texts[ $index ] ) ? $texts[ $index ] : '',
			);
		}

		return $items;
	}

	private static function safe_choice( $value, $allowed, $default ) {
		$value = sanitize_key( $value );
		return in_array( $value, $allowed, true ) ? $value : $default;
	}

	private static function safe_icon( $icon ) {
		return self::safe_choice( $icon, array( 'leaf', 'mountain', 'shield', 'batch', 'cluster', 'gift', 'hands' ), 'leaf' );
	}

	private static function icon_svg( $icon ) {
		$icon  = self::safe_icon( $icon );
		$icons = array(
			'leaf'     => '<svg viewBox="0 0 24 24" focusable="false"><path d="M19.5 4.5c-7.8.2-12.6 3.7-14 10.2-.5 2.4.7 4.8 3.1 5.3 5.9 1.2 10.5-4.2 10.9-15.5ZM7.3 17.2c2.7-3.5 5.7-5.6 9.1-6.6"/></svg>',
			'mountain' => '<svg viewBox="0 0 24 24" focusable="false"><path d="M3.5 19.5 9.4 8.8l3.2 5.2 2.4-3.8 5.5 9.3H3.5Z"/><path d="m8.5 10.4 1.7 1.4 1.1-1.1"/></svg>',
			'shield'   => '<svg viewBox="0 0 24 24" focusable="false"><path d="M12 3.5 19 6v5.2c0 4.5-2.7 7.7-7 9.3-4.3-1.6-7-4.8-7-9.3V6l7-2.5Z"/><path d="m8.7 12.1 2 2 4.6-4.6"/></svg>',
			'batch'    => '<svg viewBox="0 0 24 24" focusable="false"><path d="M7 5.5h10l1.2 14H5.8L7 5.5Z"/><path d="M9 5.5c.2-1.4 1.3-2.5 3-2.5s2.8 1.1 3 2.5"/><path d="M8.5 10.5h7"/><path d="M8.7 14h6.6"/></svg>',
			'cluster'  => '<svg viewBox="0 0 24 24" focusable="false"><circle cx="7" cy="8" r="2.4"/><circle cx="17" cy="8" r="2.4"/><circle cx="12" cy="17" r="2.4"/><path d="M9 9.4 11 15"/><path d="m15 9.4-2 5.6"/></svg>',
			'gift'     => '<svg viewBox="0 0 24 24" focusable="false"><path d="M4.5 9.5h15v10h-15v-10Z"/><path d="M4 9.5V6.8h16v2.7"/><path d="M12 6.8v12.7"/></svg>',
			'hands'    => '<svg viewBox="0 0 24 24" focusable="false"><path d="M7 13.5 4.8 16c-.7.8-.6 2 .2 2.7l.2.2c.8.6 2 .5 2.7-.2l2.5-2.7"/><path d="M17 13.5 19.2 16c.7.8.6 2-.2 2.7l-.2.2c-.8.6-2 .5-2.7-.2l-2.5-2.7"/><path d="M8.5 9.2 12 12.4l3.5-3.2"/></svg>',
		);

		return $icons[ $icon ];
	}
}
