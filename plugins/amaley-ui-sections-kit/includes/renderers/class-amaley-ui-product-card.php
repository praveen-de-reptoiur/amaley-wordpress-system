<?php
/**
 * Product card renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a safe WooCommerce product card.
 */
final class Amaley_UI_Product_Card {

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		if ( ! function_exists( 'wc_get_product' ) ) {
			return self::notice( 'WooCommerce is required for this product display.' );
		}

		$atts = self::normalize_atts( $atts );
		$product = self::get_product_from_atts( $atts );

		if ( ! $product ) {
			return self::notice( 'This product is not available.' );
		}

		return self::render_product( $product, $atts );
	}

	/**
	 * Normalizes shortcode attributes.
	 *
	 * @param array $atts Raw shortcode attributes.
	 * @return array<string,string>
	 */
	public static function normalize_atts( $atts ) {
		$atts = shortcode_atts(
			array(
				'id'           => '',
				'sku'          => '',
				'show_price'   => 'yes',
				'show_excerpt' => 'yes',
				'show_button'  => 'yes',
				'show_cart'    => 'no',
				'badge'        => '',
				'image_ratio'  => 'square',
				'class'        => '',
			),
			$atts,
			'amaley_product_card'
		);

		$atts['id']           = absint( $atts['id'] );
		$atts['sku']          = sanitize_text_field( $atts['sku'] );
		$atts['show_price']   = self::yes_no( $atts['show_price'] );
		$atts['show_excerpt'] = self::yes_no( $atts['show_excerpt'] );
		$atts['show_button']  = self::yes_no( $atts['show_button'] );
		$atts['show_cart']    = self::yes_no( $atts['show_cart'] );
		$atts['badge']        = wp_strip_all_tags( $atts['badge'] );
		$atts['image_ratio']  = self::image_ratio( $atts['image_ratio'] );
		$atts['class']        = Amaley_UI_Helpers::extra_classes( $atts['class'] );

		return $atts;
	}

	/**
	 * Renders a product card from an already loaded product object.
	 *
	 * @param WC_Product $product Product object.
	 * @param array      $atts    Normalized display options.
	 * @return string
	 */
	public static function render_product( $product, $atts = array() ) {
		$atts = wp_parse_args(
			$atts,
			self::normalize_atts( array() )
		);

		if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
			return self::notice( 'This product is not available.' );
		}

		$product_id = $product->get_id();
		$title      = $product->get_name();
		$url        = get_permalink( $product_id );
		$classes    = 'amaley-ui-product-card amaley-ui-product-card--ratio-' . $atts['image_ratio'];
		$classes   .= '' !== $atts['class'] ? ' ' . $atts['class'] : '';

		$badge_label = self::badge_label( $product, $atts );

		$html  = '<article class="' . esc_attr( $classes ) . '">';
		$html .= '<a class="amaley-ui-product-card__media" href="' . esc_url( $url ) . '" aria-label="' . esc_attr( $title ) . '">';
		$html .= self::image_html( $product );
		if ( '' !== $badge_label ) {
			$html .= '<span class="amaley-ui-product-card__media-badge">' . esc_html( $badge_label ) . '</span>';
		}
		$html .= '</a>';

		$html .= '<div class="amaley-ui-product-card__body">';
		$html .= '<div class="amaley-ui-product-card__meta">Small batch • Amaley</div>';
		$html .= '<h3 class="amaley-ui-product-card__title"><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></h3>';

		if ( 'yes' === $atts['show_price'] ) {
			$price_html = $product->get_price_html();
			if ( '' !== $price_html ) {
				$html .= '<div class="amaley-ui-product-card__price">' . wp_kses_post( $price_html ) . '</div>';
			}
		}

		if ( 'yes' === $atts['show_excerpt'] ) {
			$excerpt = self::excerpt( $product );
			if ( '' !== $excerpt ) {
				$html .= '<p class="amaley-ui-product-card__excerpt">' . esc_html( $excerpt ) . '</p>';
			}
		}

		$html .= self::actions( $product, $atts );
		$html .= '</div>';
		$html .= '</article>';

		return $html;
	}

	/**
	 * Gets a product using id or sku.
	 *
	 * @param array $atts Normalized attributes.
	 * @return WC_Product|false
	 */
	private static function get_product_from_atts( $atts ) {
		$product_id = absint( $atts['id'] );

		if ( ! $product_id && '' !== $atts['sku'] && function_exists( 'wc_get_product_id_by_sku' ) ) {
			$product_id = absint( wc_get_product_id_by_sku( $atts['sku'] ) );
		}

		if ( ! $product_id ) {
			return false;
		}

		$product = wc_get_product( $product_id );

		return $product && 'publish' === get_post_status( $product_id ) ? $product : false;
	}

	/**
	 * Returns the visual badge label for the product card.
	 *
	 * @param WC_Product $product Product object.
	 * @param array      $atts    Normalized display options.
	 * @return string
	 */
	private static function badge_label( $product, $atts ) {
		if ( ! empty( $atts['badge'] ) ) {
			return $atts['badge'];
		}

		if ( $product->is_on_sale() ) {
			return 'Offer';
		}

		return '';
	}

	/**
	 * Returns product image markup.
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	private static function image_html( $product ) {
		$image_id = $product->get_image_id();

		if ( $image_id ) {
			return wp_get_attachment_image(
				$image_id,
				'woocommerce_thumbnail',
				false,
				array(
					'class'   => 'amaley-ui-product-card__img',
					'loading' => 'lazy',
				)
			);
		}

		return '<div class="amaley-ui-product-card__placeholder">Amaley</div>';
	}

	/**
	 * Returns a short product excerpt.
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	private static function excerpt( $product ) {
		$text = $product->get_short_description();
		$text = '' !== $text ? $text : get_post_field( 'post_excerpt', $product->get_id() );
		$text = wp_strip_all_tags( (string) $text );
		$text = preg_replace( '/\s+/', ' ', $text );
		$text = trim( (string) $text );

		if ( '' === $text ) {
			return '';
		}

		return wp_trim_words( $text, 18, '…' );
	}

	/**
	 * Returns product card action buttons.
	 *
	 * @param WC_Product $product Product object.
	 * @param array      $atts    Normalized attributes.
	 * @return string
	 */
	private static function actions( $product, $atts ) {
		if ( 'yes' !== $atts['show_button'] && 'yes' !== $atts['show_cart'] ) {
			return '';
		}

		$html = '<div class="amaley-ui-product-card__actions">';

		if ( 'yes' === $atts['show_button'] ) {
			$html .= '<a class="amaley-ui-btn amaley-ui-btn--primary amaley-ui-product-card__btn" href="' . esc_url( get_permalink( $product->get_id() ) ) . '">View product</a>';
		}

		if ( 'yes' === $atts['show_cart'] && $product->is_purchasable() && $product->is_in_stock() ) {
			$html .= '<a class="amaley-ui-btn amaley-ui-btn--outline amaley-ui-product-card__btn" href="' . esc_url( $product->add_to_cart_url() ) . '">' . esc_html( $product->add_to_cart_text() ) . '</a>';
		} elseif ( 'yes' === $atts['show_cart'] && ! $product->is_in_stock() ) {
			$html .= '<span class="amaley-ui-product-card__stock">Out of stock</span>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Returns a safe notice block.
	 *
	 * @param string $message Notice text.
	 * @return string
	 */
	private static function notice( $message ) {
		return '<div class="amaley-ui-product-notice">' . esc_html( $message ) . '</div>';
	}

	/**
	 * Normalizes yes/no values.
	 *
	 * @param string $value Raw value.
	 * @return string
	 */
	private static function yes_no( $value ) {
		$value = strtolower( trim( (string) $value ) );
		return in_array( $value, array( 'yes', 'true', '1' ), true ) ? 'yes' : 'no';
	}

	/**
	 * Normalizes image ratio.
	 *
	 * @param string $ratio Raw ratio value.
	 * @return string
	 */
	private static function image_ratio( $ratio ) {
		$ratio = sanitize_key( $ratio );
		return in_array( $ratio, array( 'square', 'portrait', 'wide' ), true ) ? $ratio : 'square';
	}
}
