<?php
/**
 * Shortcode registration.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers all Amaley UI Sections Kit shortcodes.
 */
final class Amaley_UI_Shortcodes {

	/**
	 * Registers shortcodes.
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( 'amaley_section_heading', array( 'Amaley_UI_Section_Heading', 'render' ) );
		add_shortcode( 'amaley_button', array( 'Amaley_UI_Button', 'render' ) );
		add_shortcode( 'amaley_button_group', array( 'Amaley_UI_Button_Group', 'render' ) );
		add_shortcode( 'amaley_trust_item', array( 'Amaley_UI_Trust_Item', 'render' ) );
		add_shortcode( 'amaley_page_trust_strip', array( 'Amaley_UI_Trust_Strip', 'render' ) );
		add_shortcode( 'amaley_trust_strip', array( 'Amaley_UI_Trust_Strip', 'render' ) );
		add_shortcode( 'amaley_brand_promise', array( 'Amaley_UI_Brand_Promise', 'render' ) );
		add_shortcode( 'amaley_cta_band', array( 'Amaley_UI_CTA_Band', 'render' ) );
		add_shortcode( 'amaley_empty_state', array( 'Amaley_UI_Empty_State', 'render' ) );
		add_shortcode( 'amaley_product_card', array( 'Amaley_UI_Product_Card', 'render' ) );
		add_shortcode( 'amaley_product_grid', array( 'Amaley_UI_Product_Grid', 'render' ) );
	}
}
