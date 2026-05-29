<?php
/**
 * Amaley Home Hero V6 renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders the locked live-style homepage hero.
 */
final class Amaley_UI_Home_Hero_V6 {

	/**
	 * Render the hero.
	 *
	 * @param array $atts Shortcode/widget attributes.
	 * @return string
	 */
	public static function render( $atts = array() ) {
		$atts = self::normalize_atts( $atts );

		$html  = '<div class="amaley-home-hero-v6" data-amaley-home-hero-v6>';
		$html .= '<div class="amaley-home-hero-v6-inner"><div class="amaley-home-hero-v6-grid">';
		$html .= self::render_left( $atts );
		$html .= self::render_right( $atts );
		$html .= '</div></div></div>';

		return $html;
	}

	/**
	 * Normalize attributes.
	 *
	 * @param array $atts Raw attributes.
	 * @return array
	 */
	private static function normalize_atts( $atts ) {
		$defaults = array(
			'tag'              => 'Himalayan Foods · Women-Led · Small Batch',
			'title_line_1'     => 'From Himalayan',
			'title_em'         => 'Kitchens',
			'title_line_3'     => 'To Your Home',
			'subtitle'         => 'Small-batch foods crafted by women-led communities across the Himalayas. Rooted in tradition. Made with care. Curated for everyday life and gifting.',
			'primary_text'     => 'Shop Now',
			'primary_url'      => 'https://lightsalmon-lemur-689499.hostingersite.com/shop-2/',
			'secondary_text'   => 'Explore Our Story →',
			'secondary_url'    => 'https://lightsalmon-lemur-689499.hostingersite.com/about/',
			'stat_1_value'     => '12',
			'stat_1_suffix'    => '+',
			'stat_1_label'     => 'Clusters',
			'stat_2_value'     => '48',
			'stat_2_suffix'    => '',
			'stat_2_label'     => 'SHGs',
			'stat_3_value'     => '200',
			'stat_3_suffix'    => '+',
			'stat_3_label'     => 'Producers',
			'stat_4_value'     => '60',
			'stat_4_suffix'    => '+',
			'stat_4_label'     => 'Products',
			'image_1'          => 'https://lightsalmon-lemur-689499.hostingersite.com/wp-content/uploads/2026/05/amaley-hero-image-1-large-left.jpg',
			'image_1_alt'      => 'Amaley Himalayan food products with mountain background',
			'image_1_crop'     => 'center',
			'image_2'          => 'https://lightsalmon-lemur-689499.hostingersite.com/wp-content/uploads/2026/05/ChatGPT-Image-May-6-2026-01_11_38-AM-3.png',
			'image_2_alt'      => 'Amaley Himalayan ingredients and spices',
			'image_2_crop'     => 'center',
			'image_3'          => 'https://lightsalmon-lemur-689499.hostingersite.com/wp-content/uploads/2026/05/nre-2.png',
			'image_3_alt'      => 'Women preparing Himalayan food products',
			'image_3_crop'     => 'center',
			'badge_kicker'     => 'Himalayas<br>To Home',
			'badge_text'       => 'Made with<br>a mother\'s care',
		);

		$atts = shortcode_atts( $defaults, $atts, 'amaley_home_hero_v6' );

		foreach ( array( 'tag', 'title_line_1', 'title_em', 'title_line_3', 'subtitle', 'primary_text', 'secondary_text', 'stat_1_label', 'stat_2_label', 'stat_3_label', 'stat_4_label', 'image_1_alt', 'image_2_alt', 'image_3_alt' ) as $key ) {
			$atts[ $key ] = wp_strip_all_tags( (string) $atts[ $key ] );
		}

		foreach ( array( 'primary_url', 'secondary_url', 'image_1', 'image_2', 'image_3' ) as $key ) {
			$atts[ $key ] = esc_url_raw( (string) $atts[ $key ] );
		}

		foreach ( array( 'stat_1_value', 'stat_2_value', 'stat_3_value', 'stat_4_value' ) as $key ) {
			$atts[ $key ] = (string) max( 0, absint( $atts[ $key ] ) );
		}

		foreach ( array( 'stat_1_suffix', 'stat_2_suffix', 'stat_3_suffix', 'stat_4_suffix' ) as $key ) {
			$atts[ $key ] = preg_replace( '/[^+a-zA-Z0-9]/', '', (string) $atts[ $key ] );
		}

		foreach ( array( 'image_1_crop', 'image_2_crop', 'image_3_crop' ) as $key ) {
			$atts[ $key ] = self::safe_crop( $atts[ $key ] );
		}

		$atts['badge_kicker'] = self::safe_badge_text( $atts['badge_kicker'] );
		$atts['badge_text']   = self::safe_badge_text( $atts['badge_text'] );

		return $atts;
	}

	/** Render left content area. */
	private static function render_left( $atts ) {
		$html  = '<div class="amaley-home-hero-v6-left"><div class="amaley-home-hero-v6-content">';
		$html .= '<div class="amaley-home-hero-v6-tag"><span class="amaley-home-hero-v6-tag-text">' . esc_html( $atts['tag'] ) . '</span></div>';
		$html .= '<h1 class="amaley-home-hero-v6-title">' . esc_html( $atts['title_line_1'] ) . '<br><span class="amaley-home-hero-v6-title-em">' . esc_html( $atts['title_em'] ) . '</span><br>' . esc_html( $atts['title_line_3'] ) . '</h1>';
		$html .= '<p class="amaley-home-hero-v6-subtitle">' . esc_html( $atts['subtitle'] ) . '</p>';
		$html .= '<div class="amaley-home-hero-v6-buttons">';
		$html .= '<a href="' . esc_url( $atts['primary_url'] ) . '" class="amaley-home-hero-v6-btn-primary">' . esc_html( $atts['primary_text'] ) . '</a>';
		$html .= '<a href="' . esc_url( $atts['secondary_url'] ) . '" class="amaley-home-hero-v6-btn-outline">' . esc_html( $atts['secondary_text'] ) . '</a>';
		$html .= '</div>';
		$html .= '<div class="amaley-home-hero-v6-stats">';
		for ( $i = 1; $i <= 4; $i++ ) {
			$html .= self::render_stat( $atts[ 'stat_' . $i . '_value' ], $atts[ 'stat_' . $i . '_suffix' ], $atts[ 'stat_' . $i . '_label' ] );
		}
		$html .= '</div></div></div>';
		return $html;
	}

	/** Render one stat. */
	private static function render_stat( $value, $suffix, $label ) {
		$html  = '<div class="amaley-home-hero-v6-stat">';
		$html .= '<span class="amaley-home-hero-v6-stat-number" data-ahh6-counter data-count="' . esc_attr( $value ) . '" data-suffix="' . esc_attr( $suffix ) . '">0</span>';
		$html .= '<span class="amaley-home-hero-v6-stat-label">' . esc_html( $label ) . '</span></div>';
		return $html;
	}

	/** Render right mosaic area. */
	private static function render_right( $atts ) {
		$html  = '<div class="amaley-home-hero-v6-right"><div class="amaley-home-hero-v6-mosaic">';
		$html .= self::render_image( $atts['image_1'], $atts['image_1_alt'], $atts['image_1_crop'], true, 1 );
		$html .= self::render_image( $atts['image_2'], $atts['image_2_alt'], $atts['image_2_crop'], false, 2 );
		$html .= self::render_image( $atts['image_3'], $atts['image_3_alt'], $atts['image_3_crop'], false, 3 );
		$html .= '</div><div class="amaley-home-hero-v6-medallion"><div class="amaley-home-hero-v6-medallion-inner"><div class="amaley-home-hero-v6-medallion-circle">';
		$html .= '<p class="amaley-home-hero-v6-medallion-kicker">' . wp_kses_post( $atts['badge_kicker'] ) . '</p>';
		$html .= '<strong class="amaley-home-hero-v6-medallion-text">' . wp_kses_post( $atts['badge_text'] ) . '</strong>';
		$html .= '</div></div></div></div>';
		return $html;
	}

	/** Render an image card. */
	private static function render_image( $url, $alt, $crop, $main, $index ) {
		$crop    = self::safe_crop( $crop );
		$classes = 'amaley-home-hero-v6-image-card amaley-home-hero-v6-image-card-' . absint( $index );
		$classes .= ' amaley-home-hero-v6-image-card--crop-' . $crop;
		if ( $main ) {
			$classes .= ' amaley-home-hero-v6-image-card-main';
		}
		return '<div class="' . esc_attr( $classes ) . '"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '"></div>';
	}

	/** Crop helper. */
	private static function safe_crop( $crop ) {
		$crop = sanitize_key( $crop );
		return in_array( $crop, array( 'top', 'bottom', 'left', 'right', 'center' ), true ) ? $crop : 'center';
	}

	/** Allow only line breaks in badge copy. */
	private static function safe_badge_text( $text ) {
		$text = str_replace( array( '&lt;br&gt;', '&lt;br/&gt;', '&lt;br /&gt;' ), '<br>', (string) $text );
		return wp_kses( $text, array( 'br' => array() ) );
	}
}
