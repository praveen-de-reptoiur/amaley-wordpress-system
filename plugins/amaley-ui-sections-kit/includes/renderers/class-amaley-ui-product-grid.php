<?php
/**
 * Product grid renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a safe curated WooCommerce product grid.
 */
final class Amaley_UI_Product_Grid {

	/** Maximum products allowed in one grid. */
	const MAX_LIMIT = 8;

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

		$atts     = self::normalize_atts( $atts );
		$products = self::get_products( $atts );

		if ( empty( $products ) ) {
			return self::notice( 'No products are available for this section yet.' );
		}

		$classes  = 'amaley-ui-product-grid amaley-ui-product-grid--cols-' . absint( $atts['columns'] );
		$classes .= '' !== $atts['class'] ? ' ' . $atts['class'] : '';

		$card_atts = array(
			'show_price'   => $atts['show_price'],
			'show_excerpt' => $atts['show_excerpt'],
			'show_button'  => $atts['show_button'],
			'show_cart'    => $atts['show_cart'],
			'badge'        => $atts['badge'],
			'image_ratio'  => $atts['image_ratio'],
			'class'        => '',
		);

		$html = '<div class="' . esc_attr( $classes ) . '">';

		foreach ( $products as $product ) {
			$html .= Amaley_UI_Product_Card::render_product( $product, $card_atts );
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Normalizes shortcode attributes.
	 *
	 * @param array $atts Raw shortcode attributes.
	 * @return array<string,mixed>
	 */
	private static function normalize_atts( $atts ) {
		$atts = shortcode_atts(
			array(
				'ids'          => '',
				'skus'         => '',
				'category'     => '',
				'limit'        => 4,
				'columns'      => 4,
				'show_price'   => 'yes',
				'show_excerpt' => 'no',
				'show_button'  => 'yes',
				'show_cart'    => 'no',
				'badge'        => '',
				'image_ratio'  => 'square',
				'class'        => '',
			),
			$atts,
			'amaley_product_grid'
		);

		$card_atts = Amaley_UI_Product_Card::normalize_atts(
			array(
				'show_price'   => $atts['show_price'],
				'show_excerpt' => $atts['show_excerpt'],
				'show_button'  => $atts['show_button'],
				'show_cart'    => $atts['show_cart'],
				'badge'        => $atts['badge'],
				'image_ratio'  => $atts['image_ratio'],
			)
		);

		return array(
			'ids'          => self::id_list( $atts['ids'] ),
			'skus'         => self::sku_list( $atts['skus'] ),
			'category'     => sanitize_title( $atts['category'] ),
			'limit'        => max( 1, min( self::MAX_LIMIT, absint( $atts['limit'] ) ) ),
			'columns'      => max( 1, min( 4, absint( $atts['columns'] ) ) ),
			'show_price'   => $card_atts['show_price'],
			'show_excerpt' => $card_atts['show_excerpt'],
			'show_button'  => $card_atts['show_button'],
			'show_cart'    => $card_atts['show_cart'],
			'badge'        => $card_atts['badge'],
			'image_ratio'  => $card_atts['image_ratio'],
			'class'        => Amaley_UI_Helpers::extra_classes( $atts['class'] ),
		);
	}

	/**
	 * Gets products using IDs, SKUs, or one category slug.
	 *
	 * @param array $atts Normalized attributes.
	 * @return array<int,WC_Product>
	 */
	private static function get_products( $atts ) {
		$product_ids = array();

		if ( ! empty( $atts['ids'] ) ) {
			$product_ids = $atts['ids'];
		} elseif ( ! empty( $atts['skus'] ) && function_exists( 'wc_get_product_id_by_sku' ) ) {
			foreach ( $atts['skus'] as $sku ) {
				$product_id = absint( wc_get_product_id_by_sku( $sku ) );
				if ( $product_id ) {
					$product_ids[] = $product_id;
				}
			}
		} elseif ( '' !== $atts['category'] && function_exists( 'wc_get_products' ) ) {
			$product_ids = wc_get_products(
				array(
					'limit'    => $atts['limit'],
					'status'   => 'publish',
					'category' => array( $atts['category'] ),
					'return'   => 'ids',
				)
			);
		}

		$product_ids = array_slice( array_unique( array_map( 'absint', $product_ids ) ), 0, $atts['limit'] );

		return self::products_from_ids( $product_ids );
	}

	/**
	 * Converts product IDs into WC_Product objects.
	 *
	 * @param array $product_ids Product IDs.
	 * @return array<int,WC_Product>
	 */
	private static function products_from_ids( $product_ids ) {
		$products = array();

		foreach ( $product_ids as $product_id ) {
			$product = wc_get_product( absint( $product_id ) );
			if ( $product && 'publish' === get_post_status( $product->get_id() ) ) {
				$products[] = $product;
			}
		}

		return $products;
	}

	/** Parses comma-separated IDs. */
	private static function id_list( $value ) {
		$ids = array_map( 'absint', explode( ',', (string) $value ) );
		return array_values( array_unique( array_filter( $ids ) ) );
	}

	/** Parses comma-separated SKUs. */
	private static function sku_list( $value ) {
		$skus = array_map( 'trim', explode( ',', (string) $value ) );
		$skus = array_filter( array_map( 'sanitize_text_field', $skus ) );
		return array_values( array_unique( $skus ) );
	}

	/** Returns a safe notice block. */
	private static function notice( $message ) {
		return '<div class="amaley-ui-product-notice">' . esc_html( $message ) . '</div>';
	}
}
