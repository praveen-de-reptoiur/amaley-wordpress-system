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
		add_shortcode( 'amaley_home_hero_v6', array( 'Amaley_UI_Home_Hero_V6', 'render' ) );
		add_shortcode( 'amaley_pages_hero_other', array( 'Amaley_UI_Pages_Hero_Other', 'render' ) );
		add_shortcode( 'amaley_collection_purpose_routes', array( 'Amaley_UI_Collection_Purpose_Routes', 'render' ) );
		add_shortcode( 'amaley_featured_collection_cards', array( 'Amaley_UI_Featured_Collection_Cards', 'render' ) );
		add_shortcode( 'amaley_collection_detail_split', array( 'Amaley_UI_Collection_Detail_Split', 'render' ) );
		add_shortcode( 'amaley_gifting_enquiry_section', array( $this, 'render_gifting_enquiry_section' ) );
		// Backward-compatible alias for v0.3.0-v0.3.2 tests. Prefer [amaley_page_trust_strip] going forward.
		add_shortcode( 'amaley_trust_strip', array( 'Amaley_UI_Trust_Strip', 'render' ) );
		add_shortcode( 'amaley_brand_promise', array( 'Amaley_UI_Brand_Promise', 'render' ) );
		add_shortcode( 'amaley_cta_band', array( 'Amaley_UI_CTA_Band', 'render' ) );
		add_shortcode( 'amaley_empty_state', array( 'Amaley_UI_Empty_State', 'render' ) );
		add_shortcode( 'amaley_product_card', array( 'Amaley_UI_Product_Card', 'render' ) );
		add_shortcode( 'amaley_product_grid', array( 'Amaley_UI_Product_Grid', 'render' ) );

	}

	/**
	 * Lazily renders the gifting enquiry section shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function render_gifting_enquiry_section( $atts ) {
		if ( ! class_exists( 'Amaley_UI_Gifting_Enquiry_Section' ) && defined( 'AMALEY_UI_SECTIONS_KIT_PATH' ) ) {
			$renderer_file = AMALEY_UI_SECTIONS_KIT_PATH . 'includes/renderers/class-amaley-ui-gifting-enquiry-section.php';
			if ( file_exists( $renderer_file ) ) {
				require_once $renderer_file;
			}
		}

		if ( ! class_exists( 'Amaley_UI_Gifting_Enquiry_Section' ) ) {
			return '';
		}

		return Amaley_UI_Gifting_Enquiry_Section::render( is_array( $atts ) ? $atts : array() );
	}
}
