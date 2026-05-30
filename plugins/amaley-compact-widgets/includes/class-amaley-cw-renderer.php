<?php
/**
 * Professional renderers for Amaley Compact Widgets.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Renderer {

	public static function widget_definitions() {
		return array(
			'info_cards'          => array( 'title' => 'Amaley Info Cards Grid', 'shortcode' => 'amaley_cw_info_cards', 'method' => 'info_cards', 'supports_columns' => true,  'supports_item_images' => false, 'supports_buttons' => false, 'styles' => array( 'style-1' => 'Numbered premium cards', 'style-2' => 'Icon cards', 'style-3' => 'Dark editorial cards', 'style-4' => 'Compact rows' ) ),
			'split_editorial'     => array( 'title' => 'Amaley Split Editorial', 'shortcode' => 'amaley_cw_split_editorial', 'method' => 'split_editorial', 'supports_columns' => false, 'supports_main_media' => true, 'supports_media_side' => true, 'supports_buttons' => true, 'styles' => array( 'style-1' => 'Image + feature cards', 'style-2' => 'Paper editorial', 'style-3' => 'Dark story split' ) ),
			'traceability'        => array( 'title' => 'Amaley Traceability Journey', 'shortcode' => 'amaley_cw_traceability', 'method' => 'traceability', 'supports_columns' => false, 'supports_buttons' => false, 'styles' => array( 'style-1' => 'Map + route steps', 'style-2' => 'Compact route board' ) ),
			'gifting_band'        => array( 'title' => 'Amaley Gifting / Bulk Band', 'shortcode' => 'amaley_cw_gifting_band', 'method' => 'gifting_band', 'supports_columns' => false, 'supports_buttons' => true, 'styles' => array( 'style-1' => 'Green gifting band', 'style-2' => 'Dark gifting band' ) ),
			'value_strip'         => array( 'title' => 'Amaley Feature / Value Strip', 'shortcode' => 'amaley_cw_value_strip', 'method' => 'value_strip', 'supports_columns' => true, 'supports_buttons' => false, 'styles' => array( 'style-1' => 'Icon value row', 'style-2' => 'Minimal proof strip', 'style-3' => 'Dark trust strip' ) ),
			'process_steps'       => array( 'title' => 'Amaley Process Steps', 'shortcode' => 'amaley_cw_process_steps', 'method' => 'process_steps', 'supports_columns' => true, 'supports_item_images' => true, 'styles' => array( 'style-1' => 'Image step cards', 'style-2' => 'Numbered process row' ) ),
			'origin_cards'        => array( 'title' => 'Amaley Origin Story Cards', 'shortcode' => 'amaley_cw_origin_cards', 'method' => 'origin_cards', 'supports_columns' => true, 'supports_item_images' => true, 'styles' => array( 'style-1' => 'Origin image cards', 'style-2' => 'Editorial origin cards' ) ),
			'purpose_cards'       => array( 'title' => 'Amaley Purpose Cards', 'shortcode' => 'amaley_cw_purpose_cards', 'method' => 'purpose_cards', 'supports_columns' => true, 'supports_buttons' => false, 'styles' => array( 'style-1' => 'Shop by purpose', 'style-2' => 'Compact buyer cards' ) ),
			'collection_cards'    => array( 'title' => 'Amaley Collection Cards', 'shortcode' => 'amaley_cw_collection_cards', 'method' => 'collection_cards', 'supports_columns' => true, 'supports_item_images' => true, 'styles' => array( 'style-1' => 'Featured collection cards', 'style-2' => 'Occasion cards', 'style-3' => 'Mixed CTA card' ) ),
			'two_panel_info'      => array( 'title' => 'Amaley Two Panel Info', 'shortcode' => 'amaley_cw_two_panel_info', 'method' => 'two_panel_info', 'supports_columns' => false, 'styles' => array( 'style-1' => 'Two clear panels', 'style-2' => 'Question panels' ) ),
			'dark_chain'          => array( 'title' => 'Amaley Dark Chain Cards', 'shortcode' => 'amaley_cw_dark_chain', 'method' => 'dark_chain', 'supports_columns' => true, 'styles' => array( 'style-1' => 'Dark value-chain cards', 'style-2' => 'Dark compact cards' ) ),
			'image_flip_cards'    => array( 'title' => 'Amaley Image Flip Cards', 'shortcode' => 'amaley_cw_image_flip_cards', 'method' => 'image_flip_cards', 'supports_columns' => true, 'supports_item_images' => true, 'supports_flip' => true, 'styles' => array( 'style-1' => 'Image flip cards', 'style-2' => 'Soft info flip cards' ) ),
			'image_cards'         => array( 'title' => 'Amaley Image Cards', 'shortcode' => 'amaley_cw_image_cards', 'method' => 'image_cards', 'supports_columns' => true, 'supports_item_images' => true, 'styles' => array( 'style-1' => 'Clean image cards', 'style-2' => 'Tall editorial cards' ) ),
			'image_info_cards'    => array( 'title' => 'Amaley Image Info Cards', 'shortcode' => 'amaley_cw_image_info_cards', 'method' => 'image_info_cards', 'supports_columns' => true, 'supports_item_images' => true, 'styles' => array( 'style-1' => 'Image + info cards', 'style-2' => 'Horizontal info cards' ) ),
			'image_overlay_cards' => array( 'title' => 'Amaley Image Overlay Cards', 'shortcode' => 'amaley_cw_image_overlay_cards', 'method' => 'image_overlay_cards', 'supports_columns' => true, 'supports_item_images' => true, 'styles' => array( 'style-1' => 'Overlay story cards', 'style-2' => 'Dark overlay cards' ) ),
			'quote_cards'         => array( 'title' => 'Amaley Quote Cards', 'shortcode' => 'amaley_cw_quote_cards', 'method' => 'quote_cards', 'supports_columns' => true, 'styles' => array( 'style-1' => 'Quote cards', 'style-2' => 'Field note cards' ) ),
			'cta_tiles'           => array( 'title' => 'Amaley CTA Tiles', 'shortcode' => 'amaley_cw_cta_tiles', 'method' => 'cta_tiles', 'supports_columns' => true, 'supports_buttons' => false, 'styles' => array( 'style-1' => 'Action tiles', 'style-2' => 'Dark action tiles' ) ),
			'metric_tiles'        => array( 'title' => 'Amaley Metric Tiles', 'shortcode' => 'amaley_cw_metric_tiles', 'method' => 'metric_tiles', 'supports_columns' => true, 'styles' => array( 'style-1' => 'Metric proof row', 'style-2' => 'Compact metrics' ) ),
		);
	}


	public static function elementor_defaults( $type ) {
		return array( 'defaults' => self::defaults( $type ), 'items' => self::default_items( $type ) );
	}

	private static function esc( $text ) { return function_exists( 'esc_html' ) ? esc_html( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' ); }
	private static function attr( $text ) { return function_exists( 'esc_attr' ) ? esc_attr( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' ); }
	private static function url( $text ) { return function_exists( 'esc_url' ) ? esc_url( $text ) : htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' ); }

	private static function a( $atts, $type ) {
		$defaults = self::defaults( $type );
		$atts = is_array( $atts ) ? $atts : array();
		$out = array_merge( $defaults, $atts );
		$out['style'] = preg_match( '/^style-[0-9]+$/', (string) $out['style'] ) ? (string) $out['style'] : 'style-1';
		$out['columns'] = in_array( (string) $out['columns'], array( '1', '2', '3', '4' ), true ) ? (string) $out['columns'] : $defaults['columns'];
		$out['align'] = in_array( (string) $out['align'], array( 'left', 'center', 'right' ), true ) ? (string) $out['align'] : 'left';
		$out['header_align'] = in_array( (string) $out['header_align'], array( 'left', 'center', 'right' ), true ) ? (string) $out['header_align'] : $out['align'];
		$out['card_align'] = in_array( (string) $out['card_align'], array( 'left', 'center', 'right' ), true ) ? (string) $out['card_align'] : '';
		$out['button_align'] = in_array( (string) $out['button_align'], array( 'left', 'center', 'right' ), true ) ? (string) $out['button_align'] : '';
		$out['image_side'] = in_array( (string) $out['image_side'], array( 'left', 'right' ), true ) ? (string) $out['image_side'] : 'left';
		$out['items_array'] = self::items( $out['items'], self::default_items( $type ) );
		return $out;
	}

	private static function defaults( $type ) {
		$base = array(
			'style' => 'style-1', 'kicker' => 'AMALEY', 'title' => 'A Better Amaley Section', 'accent' => '',
			'description' => '', 'button_text' => 'Explore', 'button_url' => '#', 'secondary_text' => '', 'secondary_url' => '#',
			'image_url' => '', 'image_alt' => 'Amaley image', 'items' => '', 'columns' => '3', 'align' => 'left', 'header_align' => '', 'card_align' => '', 'button_align' => '', 'image_side' => 'left',
		);
		$map = array(
			'info_cards' => array( 'kicker'=>'FEATURED COLLECTIONS', 'title'=>'Collections that help a buyer decide faster', 'accent'=>'buyer', 'description'=>'Use for compact benefit cards, buyer notes and collection explanation sections.', 'columns'=>'4' ),
			'split_editorial' => array( 'kicker'=>'OUR STORY', 'title'=>'Rooted in the Himalayas, Made for You', 'accent'=>'Made', 'description'=>'Amaley brings mountain ingredients, careful preparation and community-rooted value into products that feel honest, useful and gift-worthy.', 'button_text'=>'Explore Our Story', 'secondary_text'=>'View Products' ),
			'traceability' => array( 'kicker'=>'TRACEABILITY', 'title'=>'From Cluster to Kitchen to Customer', 'accent'=>'Customer', 'description'=>'A clear journey from sourcing and preparation to packing and customer use, without making the page look technical or cluttered.' ),
			'gifting_band' => array( 'kicker'=>'GIFTING', 'title'=>'Gifts That Carry a Place With Them', 'accent'=>'Place', 'description'=>'Curated Amaley hampers for teams, guests, events and partner shelves — built around real Himalayan products, not generic corporate gifting.', 'button_text'=>'Plan a Gift Box', 'secondary_text'=>'Talk to Us' ),
			'value_strip' => array( 'kicker'=>'OUR VALUES', 'title'=>'Why Choose Amaley Gifts?', 'accent'=>'Choose', 'description'=>'Simple reasons that help customers trust the product, the source and the people behind it.', 'columns'=>'4' ),
			'process_steps' => array( 'kicker'=>'OUR PROCESS', 'title'=>'Small batches, clear checks and careful packing', 'accent'=>'careful', 'description'=>'Show how products move from harvest to preparation, quality check and dispatch.', 'columns'=>'4' ),
			'origin_cards' => array( 'kicker'=>'WHERE IT BEGINS', 'title'=>'Every product begins with place, season and people', 'accent'=>'place', 'description'=>'Use for Ladakh, Uttarakhand, Himalayan ingredients and producer story cards.', 'columns'=>'3' ),
			'purpose_cards' => array( 'kicker'=>'FOR WHOM', 'title'=>'Made for the Ways People Actually Buy', 'accent'=>'Buy', 'description'=>'Use this section to guide buyers by occasion, use-case and intent instead of making them guess.', 'columns'=>'4' ),
			'collection_cards' => array( 'kicker'=>'FEATURED COLLECTIONS', 'title'=>'Curated collections for everyday and gifting needs', 'accent'=>'collections', 'description'=>'Use this for apricot tables, breakfast trays, pantry bundles and seasonal gift sets.', 'columns'=>'3' ),
			'two_panel_info' => array( 'kicker'=>'MAKE IT CLEAR', 'title'=>'Two strong panels for simple decisions', 'accent'=>'simple', 'description'=>'Use for buyer/partner explanation, FAQs, policy notes or clear value comparison.', 'columns'=>'2' ),
			'dark_chain' => array( 'kicker'=>'LIVELIHOOD CHAIN', 'title'=>'A value chain that stays visible', 'accent'=>'visible', 'description'=>'A dark premium band for local ingredients, producer dignity, quality and customer trust.', 'columns'=>'4' ),
			'image_flip_cards' => array( 'kicker'=>'IMAGE INFO CARDS', 'title'=>'Flip cards for product education without clutter', 'accent'=>'education', 'description'=>'A CSS-only flip card set for ingredients, origin notes, quality checks and FAQs.', 'columns'=>'3' ),
			'image_cards' => array( 'kicker'=>'VISUAL CARDS', 'title'=>'Premium image cards for collections and stories', 'accent'=>'image', 'description'=>'Use for category visuals, product jars, gift packs, village images and producer photos.', 'columns'=>'3' ),
			'image_info_cards' => array( 'kicker'=>'IMAGE + INFO', 'title'=>'Image info cards with useful context', 'accent'=>'context', 'description'=>'For product benefits, origin notes, retail use-cases and story-led explanations.', 'columns'=>'3' ),
			'image_overlay_cards' => array( 'kicker'=>'EDITORIAL VISUALS', 'title'=>'Overlay cards for strong visual storytelling', 'accent'=>'visual', 'description'=>'For premium visual panels that still guide users clearly.', 'columns'=>'3' ),
			'quote_cards' => array( 'kicker'=>'FIELD NOTES', 'title'=>'Trust notes that do not shout', 'accent'=>'trust', 'description'=>'Use for principles, testimonials, field reflections, and brand promises.', 'columns'=>'3' ),
			'cta_tiles' => array( 'kicker'=>'NEXT STEP', 'title'=>'Guide visitors to the right action', 'accent'=>'action', 'description'=>'Use for shop, gifting, wholesale, story and contact routes.', 'columns'=>'4' ),
			'metric_tiles' => array( 'kicker'=>'IMPACT SNAPSHOT', 'title'=>'Simple numbers that build confidence', 'accent'=>'confidence', 'description'=>'Use for product range, batches, collectives, regions and delivery reach.', 'columns'=>'4' ),
		);
		return array_merge( $base, isset( $map[ $type ] ) ? $map[ $type ] : array() );
	}

	private static function items( $raw, $fallback ) {
		if ( is_array( $raw ) && ! empty( $raw ) ) { return $raw; }
		$raw = trim( (string) $raw );
		if ( '' === $raw ) { return $fallback; }
		$decoded = json_decode( $raw, true );
		if ( is_array( $decoded ) ) { return $decoded; }
		$out = array();
		foreach ( array_filter( array_map( 'trim', explode( '|', $raw ) ) ) as $row ) {
			$p = array_map( 'trim', explode( '::', $row ) );
			$out[] = array( 'number'=>$p[0] ?? '', 'icon'=>$p[1] ?? '✦', 'title'=>$p[2] ?? '', 'text'=>$p[3] ?? '', 'back_title'=>$p[4] ?? '', 'back_text'=>$p[5] ?? '', 'url'=>$p[6] ?? '#', 'button_text'=>$p[7] ?? '', 'image_url'=>$p[8] ?? '', 'image_alt'=>$p[2] ?? 'Amaley image' );
		}
		return $out ?: $fallback;
	}

	private static function default_items( $type ) {
		$sets = array(
			'info_cards' => array(
				array( 'number'=>'01', 'icon'=>'✦', 'title'=>'Apricot Table Collection', 'text'=>'A refined set around preserves, oils and simple table pairings.' ),
				array( 'number'=>'02', 'icon'=>'☕', 'title'=>'Homestay Breakfast Collection', 'text'=>'Useful for guest tables, breakfast trays and welcome placements.' ),
				array( 'number'=>'03', 'icon'=>'◇', 'title'=>'Seasonal Gifting Collection', 'text'=>'Premium Himalayan food stories packed for festivals and teams.' ),
				array( 'number'=>'04', 'icon'=>'♧', 'title'=>'Retail Shelf Collection', 'text'=>'Clear product grouping for stores, cafés and hospitality shelves.' ),
			),
			'split_editorial' => array(
				array( 'icon'=>'01', 'title'=>'Seasonal ingredients', 'text'=>'Apricot, seabuckthorn, rhododendron and herbs are selected around season, place and practical use.' ),
				array( 'icon'=>'02', 'title'=>'Community-rooted preparation', 'text'=>'Products are prepared in smaller batches so quality, care and producer value remain visible.' ),
				array( 'icon'=>'03', 'title'=>'Shelf-ready stories', 'text'=>'Clean labels, giftable formats and clear product notes make each item easier to understand and buy.' ),
			),
			'traceability' => array(
				array( 'number'=>'01', 'title'=>'Source', 'text'=>'Ingredients are mapped to region, season and producer context.' ),
				array( 'number'=>'02', 'title'=>'Prepare', 'text'=>'Small-batch processing protects taste, freshness and accountability.' ),
				array( 'number'=>'03', 'title'=>'Pack', 'text'=>'Labels, batches and packaging turn local food into a trusted shelf product.' ),
				array( 'number'=>'04', 'title'=>'Share', 'text'=>'Customers understand what they are buying and why it carries value.' ),
			),
			'gifting_band' => array(
				array( 'icon'=>'01', 'title'=>'Corporate gifting', 'text'=>'Curated Himalayan products for teams, clients and partners.' ),
				array( 'icon'=>'02', 'title'=>'Custom hampers', 'text'=>'Choose product mix, budget, packaging and personal notes.' ),
				array( 'icon'=>'03', 'title'=>'Bulk support', 'text'=>'Useful for hotels, homestays, events, cafés and partner shelves.' ),
			),
			'value_strip' => array(
				array( 'icon'=>'✦', 'title'=>'Natural', 'text'=>'Ingredients that feel clean, useful and honest.' ),
				array( 'icon'=>'▲', 'title'=>'Himalayan', 'text'=>'Rooted in mountain produce and local food knowledge.' ),
				array( 'icon'=>'♧', 'title'=>'Small batch', 'text'=>'Prepared with care, not rushed for mass production.' ),
				array( 'icon'=>'◇', 'title'=>'Gift-worthy', 'text'=>'Packaging and pairings suitable for thoughtful gifting.' ),
				array( 'icon'=>'◆', 'title'=>'Trust-led', 'text'=>'Clear sourcing, product story and quality presentation.' ),
			),
			'process_steps' => array(
				array( 'number'=>'01', 'title'=>'Harvest', 'text'=>'Seasonal produce is selected at the right time.', 'image_alt'=>'Harvest visual' ),
				array( 'number'=>'02', 'title'=>'Prepare', 'text'=>'Recipes are processed in small batches.', 'image_alt'=>'Preparation visual' ),
				array( 'number'=>'03', 'title'=>'Check', 'text'=>'Batch quality, labelling and packing are verified.', 'image_alt'=>'Quality check visual' ),
				array( 'number'=>'04', 'title'=>'Dispatch', 'text'=>'Ready for homes, gifts, retail and hospitality.', 'image_alt'=>'Packed product visual' ),
			),
			'origin_cards' => array(
				array( 'number'=>'Ladakh', 'title'=>'Apricot and seabuckthorn landscapes', 'text'=>'High-altitude ingredients with strong place identity.', 'image_alt'=>'Ladakh origin visual' ),
				array( 'number'=>'Uttarakhand', 'title'=>'Rhododendron and forest-edge recipes', 'text'=>'Seasonal produce linked with local collectives.', 'image_alt'=>'Uttarakhand origin visual' ),
				array( 'number'=>'Himalayas', 'title'=>'A wider mountain pantry', 'text'=>'Products shaped by ecology, culture and careful sourcing.', 'image_alt'=>'Himalayan origin visual' ),
			),
			'purpose_cards' => array(
				array( 'icon'=>'Home', 'title'=>'Everyday homes', 'text'=>'Preserves, infusions and pantry products for daily tables.' ),
				array( 'icon'=>'Gift', 'title'=>'Gifting buyers', 'text'=>'Thoughtful gift boxes for festivals, teams and partners.' ),
				array( 'icon'=>'Retail', 'title'=>'Retail shelves', 'text'=>'Story-led Himalayan products for cafés, stores and boutiques.' ),
				array( 'icon'=>'Stay', 'title'=>'Hospitality hosts', 'text'=>'Welcome trays, breakfast tables and local product shelves.' ),
			),
			'collection_cards' => array(
				array( 'number'=>'Best Table Gift', 'title'=>'Apricot Table Collection', 'text'=>'Preserves, kernel oil and apricot-led table pairings.', 'button_text'=>'View Collection', 'url'=>'#', 'image_alt'=>'Apricot collection visual' ),
				array( 'number'=>'Hospitality Ready', 'title'=>'Homestay Breakfast Collection', 'text'=>'Small jars and infusions for guest tables and stays.', 'button_text'=>'View Collection', 'url'=>'#', 'image_alt'=>'Breakfast collection visual' ),
				array( 'number'=>'SHG Identity', 'title'=>'Need a custom collection?', 'text'=>'Region, budget and story-led curation can be planned together.', 'button_text'=>'Build Enquiry', 'url'=>'#', 'image_alt'=>'Custom collection visual' ),
			),
			'two_panel_info' => array(
				array( 'number'=>'For customers', 'title'=>'What should every Amaley collection make clear?', 'text'=>'What the product is for, where it comes from, who prepared it and how to use it.' ),
				array( 'number'=>'For partners', 'title'=>'What makes it easier to place on shelves?', 'text'=>'Clear categories, compact stories, giftable design and repeatable quality.' ),
			),
			'dark_chain' => array(
				array( 'icon'=>'♧', 'title'=>'Local Ingredients', 'text'=>'Natural regional produce and seasonal knowledge.' ),
				array( 'icon'=>'♙', 'title'=>'Producer Work', 'text'=>'Small batches prepared through community-rooted systems.' ),
				array( 'icon'=>'□', 'title'=>'Quality', 'text'=>'Clean packaging, labelling and product consistency.' ),
				array( 'icon'=>'♡', 'title'=>'Customer Trust', 'text'=>'A product story that makes buying easier.' ),
			),
			'image_flip_cards' => array(
				array( 'number'=>'Ingredient', 'title'=>'Sea Buckthorn', 'text'=>'A high-altitude berry with strong identity.', 'back_title'=>'Why it matters', 'back_text'=>'It helps customers understand place, season and use without crowding the card.', 'image_alt'=>'Sea buckthorn visual' ),
				array( 'number'=>'Process', 'title'=>'Small Batch', 'text'=>'Prepared with care and limited batches.', 'back_title'=>'Why it matters', 'back_text'=>'It avoids over-production and keeps quality easier to monitor.', 'image_alt'=>'Small batch visual' ),
				array( 'number'=>'Use', 'title'=>'Giftable Food', 'text'=>'Products that carry a clear story.', 'back_title'=>'Why it matters', 'back_text'=>'Gift buyers need beauty, clarity and a reason to choose.', 'image_alt'=>'Giftable food visual' ),
			),
			'image_cards' => array(
				array( 'number'=>'Pantry', 'title'=>'Himalayan Pantry', 'text'=>'A compact visual card for food categories.', 'image_alt'=>'Himalayan pantry visual' ),
				array( 'number'=>'Gift', 'title'=>'Gift Boxes', 'text'=>'A strong card for festive and corporate gifting.', 'image_alt'=>'Gift box visual' ),
				array( 'number'=>'People', 'title'=>'Producer Stories', 'text'=>'A respectful place for community and making visuals.', 'image_alt'=>'Producer story visual' ),
			),
			'image_info_cards' => array(
				array( 'number'=>'Product Value', 'title'=>'Easy to understand', 'text'=>'Image, meta and text sit together without making the card heavy.', 'image_alt'=>'Product value visual' ),
				array( 'number'=>'Origin Note', 'title'=>'Place stays visible', 'text'=>'Useful for linking ingredient, region and recipe story.', 'image_alt'=>'Origin note visual' ),
				array( 'number'=>'Retail Ready', 'title'=>'Clear shelf message', 'text'=>'Helps buyers and retailers understand the product quickly.', 'image_alt'=>'Retail ready visual' ),
			),
			'image_overlay_cards' => array(
				array( 'number'=>'Apricot', 'title'=>'The Apricot Table', 'text'=>'A warm visual block for product-led collection storytelling.', 'image_alt'=>'Apricot table visual' ),
				array( 'number'=>'Infusions', 'title'=>'Herbal Infusion Shelf', 'text'=>'A premium overlay card for teas and wellness shelves.', 'image_alt'=>'Infusion shelf visual' ),
				array( 'number'=>'Gifts', 'title'=>'Himalayan Gifting', 'text'=>'A compact card for gifting campaigns and festive pages.', 'image_alt'=>'Gifting visual' ),
			),
			'quote_cards' => array(
				array( 'icon'=>'“', 'title'=>'Small batches are a promise', 'text'=>'We work with what grows naturally and seasonally, not pressure for mass production.' ),
				array( 'icon'=>'“', 'title'=>'A product should explain itself', 'text'=>'The buyer should quickly understand use, source, maker and value.' ),
				array( 'icon'=>'“', 'title'=>'Trust is built before checkout', 'text'=>'Good design, clear labels and honest stories reduce doubt.' ),
			),
			'cta_tiles' => array(
				array( 'icon'=>'→', 'title'=>'Shop Collections', 'text'=>'Guide users to curated product groups.', 'button_text'=>'Open Shop', 'url'=>'#' ),
				array( 'icon'=>'□', 'title'=>'Plan Gifting', 'text'=>'Create team, guest or event hampers.', 'button_text'=>'Send Enquiry', 'url'=>'#' ),
				array( 'icon'=>'◇', 'title'=>'Retail Partnership', 'text'=>'Use products for shelves and hospitality.', 'button_text'=>'Talk to Us', 'url'=>'#' ),
				array( 'icon'=>'♧', 'title'=>'Read the Story', 'text'=>'Connect products with place and people.', 'button_text'=>'Learn More', 'url'=>'#' ),
			),
			'metric_tiles' => array(
				array( 'number'=>'25+', 'title'=>'Product Ideas', 'text'=>'Across preserves, infusions, pantry and gifts.' ),
				array( 'number'=>'2', 'title'=>'Mountain Regions', 'text'=>'Ladakh and Uttarakhand as early focus areas.' ),
				array( 'number'=>'4', 'title'=>'Use Cases', 'text'=>'Home, gifting, retail and hospitality.' ),
				array( 'number'=>'100%', 'title'=>'Story-led', 'text'=>'Every product needs a clear reason to exist.' ),
			),
		);
		return isset( $sets[ $type ] ) ? $sets[ $type ] : array();
	}

	private static function text( $item, $key, $default = '' ) { return isset( $item[ $key ] ) ? (string) $item[ $key ] : $default; }

	private static function head( $a, $center = false ) {
		$classes = 'amaley-cw4-head' . ( $center ? ' amaley-cw4-head--center' : '' );
		$title = self::title( $a['title'], $a['accent'] );
		$out  = '<div class="' . self::attr( $classes ) . '">';
		$out .= '<p class="amaley-cw4-kicker">' . self::esc( $a['kicker'] ) . '</p>';
		$out .= '<h2 class="amaley-cw4-title">' . $title . '</h2>';
		if ( ! empty( $a['description'] ) ) { $out .= '<p class="amaley-cw4-desc">' . self::esc( $a['description'] ) . '</p>'; }
		$out .= '</div>';
		return $out;
	}

	private static function title( $title, $accent ) {
		$title = self::esc( $title );
		$accent = trim( (string) $accent );
		if ( '' === $accent ) { return $title; }
		$escaped_accent = self::esc( $accent );
		$pos = stripos( $title, $escaped_accent );
		if ( false === $pos ) { return $title; }
		return substr( $title, 0, $pos ) . '<em>' . substr( $title, $pos, strlen( $escaped_accent ) ) . '</em>' . substr( $title, $pos + strlen( $escaped_accent ) );
	}

	private static function section_open( $type, $a, $extra = '' ) {
		$classes = 'amaley-cw4 amaley-cw4-' . str_replace( '_', '-', $type ) . ' amaley-cw4-' . self::attr( $a['style'] ) . ' amaley-cw4-align-' . self::attr( $a['align'] );
		if ( ! empty( $a['header_align'] ) ) { $classes .= ' amaley-cw4-head-align-' . self::attr( $a['header_align'] ); }
		if ( ! empty( $a['card_align'] ) ) { $classes .= ' amaley-cw4-card-align-' . self::attr( $a['card_align'] ); }
		if ( ! empty( $a['button_align'] ) ) { $classes .= ' amaley-cw4-btn-align-' . self::attr( $a['button_align'] ); }
		if ( $extra ) { $classes .= ' ' . $extra; }
		return '<section class="' . self::attr( $classes ) . '" data-acw="' . self::attr( $type ) . '"><div class="amaley-cw4-inner">';
	}
	private static function section_close() { return '</div></section>'; }
	private static function grid_open( $cols = '3', $extra = '' ) { return '<div class="amaley-cw4-grid ' . self::attr( $extra ) . '" style="--acw4-cols:' . self::attr( $cols ) . '">'; }
	private static function card_meta( $item ) { return '<span class="amaley-cw4-meta">' . self::esc( self::text( $item, 'number', self::text( $item, 'icon', '✦' ) ) ) . '</span>'; }
	private static function icon( $item ) { return '<span class="amaley-cw4-icon">' . self::esc( self::text( $item, 'icon', '✦' ) ) . '</span>'; }

	private static function photo( $item, $class = '', $alt = '' ) {
		$url = self::media_url( $item );
		$label = $alt ?: self::text( $item, 'image_alt', self::text( $item, 'title', 'Amaley visual' ) );
		if ( $url ) {
			return '<figure class="amaley-cw4-photo ' . self::attr( $class ) . '"><img src="' . self::url( $url ) . '" alt="' . self::attr( $label ) . '" loading="lazy"></figure>';
		}
		return '<figure class="amaley-cw4-photo amaley-cw4-photo--placeholder ' . self::attr( $class ) . '"><span>' . self::esc( $label ) . '</span></figure>';
	}

	private static function media_url( $item ) {
		$raw = isset( $item['image_url'] ) ? $item['image_url'] : '';
		if ( is_array( $raw ) && isset( $raw['url'] ) ) { return (string) $raw['url']; }
		return (string) $raw;
	}

	private static function button( $text, $url = '#', $ghost = false ) {
		if ( '' === trim( (string) $text ) ) { return ''; }
		return '<a class="amaley-cw4-btn ' . ( $ghost ? 'amaley-cw4-btn--ghost' : '' ) . '" href="' . self::url( $url ?: '#' ) . '">' . self::esc( $text ) . '</a>';
	}

	private static function link_url( $raw ) {
		if ( is_array( $raw ) && isset( $raw['url'] ) ) { return (string) $raw['url']; }
		return (string) $raw;
	}

	public static function info_cards( $atts ) {
		$a = self::a( $atts, 'info_cards' ); $out = self::section_open( 'info_cards', $a ); $out .= self::head( $a, 'center' === $a['align'] ); $out .= self::grid_open( $a['columns'], 'amaley-cw4-card-grid' );
		foreach ( $a['items_array'] as $item ) { $out .= '<article class="amaley-cw4-card amaley-cw4-info-card">' . self::card_meta( $item ) . self::icon( $item ) . '<h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function split_editorial( $atts ) {
		$a = self::a( $atts, 'split_editorial' );
		$out = self::section_open( 'split_editorial', $a, 'amaley-cw4-story-pro amaley-cw4-image-' . $a['image_side'] );
		$photo = self::photo( array( 'image_url'=>$a['image_url'], 'image_alt'=>$a['image_alt'] ?: 'Amaley story visual' ), 'amaley-cw4-story-photo' );
		$copy  = '<div class="amaley-cw4-story-copy">' . self::head( $a );
		$copy .= '<div class="amaley-cw4-story-lines">';
		foreach ( $a['items_array'] as $item ) {
			$copy .= '<article><span>' . self::esc( self::text( $item, 'icon', self::text( $item, 'number', '01' ) ) ) . '</span><div><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></div></article>';
		}
		$copy .= '</div><div class="amaley-cw4-actions">' . self::button( $a['button_text'], self::link_url( $a['button_url'] ) ) . self::button( $a['secondary_text'], self::link_url( $a['secondary_url'] ), true ) . '</div></div>';
		$out .= '<div class="amaley-cw4-story-shell">' . ( 'right' === $a['image_side'] ? $copy . $photo : $photo . $copy ) . '</div>' . self::section_close();
		return $out;
	}

	public static function traceability( $atts ) {
		$a = self::a( $atts, 'traceability' );
		$out = self::section_open( 'traceability', $a, 'amaley-cw4-trace-pro' );
		$out .= '<div class="amaley-cw4-trace-shell"><div class="amaley-cw4-trace-copy">' . self::head( $a );
		$out .= '<div class="amaley-cw4-trace-summary"><span>Clear route</span><strong>Source → Prepare → Pack → Share</strong><p>Useful for showing traceability without creating a heavy technical section.</p></div></div>';
		$out .= '<div class="amaley-cw4-trace-board"><div class="amaley-cw4-trace-mapline"><span>Cluster</span><span>Kitchen</span><span>Customer</span></div><div class="amaley-cw4-route">';
		foreach ( $a['items_array'] as $item ) {
			$out .= '<article><span>' . self::esc( self::text( $item, 'number' ) ) . '</span><div><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></div></article>';
		}
		return $out . '</div></div></div>' . self::section_close();
	}

	public static function gifting_band( $atts ) {
		$a = self::a( $atts, 'gifting_band' );
		$out = self::section_open( 'gifting_band', $a, 'amaley-cw4-gift-pro' );
		$out .= '<div class="amaley-cw4-gift-shell"><div class="amaley-cw4-gift-copy">' . self::head( $a ) . '<div class="amaley-cw4-actions">' . self::button( $a['button_text'], self::link_url( $a['button_url'] ) ) . self::button( $a['secondary_text'], self::link_url( $a['secondary_url'] ), true ) . '</div></div>';
		$out .= '<div class="amaley-cw4-gift-panel"><span class="amaley-cw4-gift-label">Curated options</span>';
		foreach ( $a['items_array'] as $item ) {
			$out .= '<article><span>' . self::esc( self::text( $item, 'icon', self::text( $item, 'number', '01' ) ) ) . '</span><div><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></div></article>';
		}
		return $out . '</div></div>' . self::section_close();
	}

	public static function value_strip( $atts ) {
		$a = self::a( $atts, 'value_strip' );
		$out = self::section_open( 'value_strip', $a, 'amaley-cw4-values-pro' );
		$out .= self::head( $a, true ) . '<div class="amaley-cw4-values-row">';
		foreach ( $a['items_array'] as $item ) {
			$out .= '<article><span>' . self::esc( self::text( $item, 'icon', '✦' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></article>';
		}
		return $out . '</div>' . self::section_close();
	}
	public static function purpose_cards( $atts ) {
		$a = self::a( $atts, 'purpose_cards' );
		$out = self::section_open( 'purpose_cards', $a, 'amaley-cw4-purpose-pro' );
		$out .= self::head( $a, true ) . '<div class="amaley-cw4-purpose-grid">';
		foreach ( $a['items_array'] as $item ) {
			$out .= '<article><span>' . self::esc( self::text( $item, 'icon', self::text( $item, 'number', 'Use' ) ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></article>';
		}
		return $out . '</div>' . self::section_close();
	}
	public static function dark_chain( $atts ) { return self::cards_icon_strip( $atts, 'dark_chain' ); }
	private static function cards_icon_strip( $atts, $type ) {
		$a = self::a( $atts, $type ); $out = self::section_open( $type, $a ); $out .= self::head( $a, true ) . self::grid_open( $a['columns'], 'amaley-cw4-icon-grid' );
		foreach ( $a['items_array'] as $item ) { $out .= '<article class="amaley-cw4-card amaley-cw4-icon-card">' . self::icon( $item ) . '<h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function process_steps( $atts ) {
		$a = self::a( $atts, 'process_steps' ); $out = self::section_open( 'process_steps', $a ); $out .= self::head( $a, true ) . self::grid_open( $a['columns'], 'amaley-cw4-process-grid' );
		foreach ( $a['items_array'] as $item ) { $out .= '<article class="amaley-cw4-process-card">' . self::photo( $item, 'amaley-cw4-process-photo' ) . '<div><span>' . self::esc( self::text( $item, 'number' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></div></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function origin_cards( $atts ) { return self::image_card_family( $atts, 'origin_cards', 'origin' ); }
	public static function image_cards( $atts ) { return self::image_card_family( $atts, 'image_cards', 'image' ); }
	public static function collection_cards( $atts ) { return self::image_card_family( $atts, 'collection_cards', 'collection' ); }
	private static function image_card_family( $atts, $type, $kind ) {
		$a = self::a( $atts, $type ); $out = self::section_open( $type, $a ); $out .= self::head( $a, 'center' === $a['align'] ) . self::grid_open( $a['columns'], 'amaley-cw4-image-grid' );
		foreach ( $a['items_array'] as $item ) { $out .= '<article class="amaley-cw4-image-card amaley-cw4-image-card--' . self::attr( $kind ) . '">' . self::photo( $item, 'amaley-cw4-card-photo' ) . '<div class="amaley-cw4-image-card-body"><span>' . self::esc( self::text( $item, 'number', self::text( $item, 'icon', 'Amaley' ) ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p>' . self::button( self::text( $item, 'button_text' ), self::link_url( self::text( $item, 'url', '#' ) ), true ) . '</div></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function two_panel_info( $atts ) {
		$a = self::a( $atts, 'two_panel_info' ); $out = self::section_open( 'two_panel_info', $a ); $out .= self::head( $a, true ) . '<div class="amaley-cw4-panels">';
		foreach ( $a['items_array'] as $item ) { $out .= '<article><span>' . self::esc( self::text( $item, 'number' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function image_flip_cards( $atts ) {
		$a = self::a( $atts, 'image_flip_cards' ); $out = self::section_open( 'image_flip_cards', $a ); $out .= self::head( $a, true ) . self::grid_open( $a['columns'], 'amaley-cw4-flip-grid' );
		foreach ( $a['items_array'] as $item ) { $out .= '<article class="amaley-cw4-flip"><div class="amaley-cw4-flip-inner"><div class="amaley-cw4-flip-front">' . self::photo( $item, 'amaley-cw4-flip-photo' ) . '<div><span>' . self::esc( self::text( $item, 'number' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></div></div><div class="amaley-cw4-flip-back"><span>Details</span><h3>' . self::esc( self::text( $item, 'back_title', self::text( $item, 'title' ) ) ) . '</h3><p>' . self::esc( self::text( $item, 'back_text', self::text( $item, 'text' ) ) ) . '</p></div></div></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function image_info_cards( $atts ) {
		$a = self::a( $atts, 'image_info_cards' ); $out = self::section_open( 'image_info_cards', $a ); $out .= self::head( $a, true ) . self::grid_open( $a['columns'], 'amaley-cw4-info-image-grid' );
		foreach ( $a['items_array'] as $item ) { $out .= '<article class="amaley-cw4-info-image-card">' . self::photo( $item, 'amaley-cw4-info-image-photo' ) . '<div><span>' . self::esc( self::text( $item, 'number' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></div></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function image_overlay_cards( $atts ) {
		$a = self::a( $atts, 'image_overlay_cards' ); $out = self::section_open( 'image_overlay_cards', $a ); $out .= self::head( $a, true ) . self::grid_open( $a['columns'], 'amaley-cw4-overlay-grid' );
		foreach ( $a['items_array'] as $item ) { $out .= '<article class="amaley-cw4-overlay-card">' . self::photo( $item, 'amaley-cw4-overlay-photo' ) . '<div><span>' . self::esc( self::text( $item, 'number' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></div></article>'; }
		return $out . '</div>' . self::section_close();
	}

	public static function quote_cards( $atts ) { return self::simple_cards( $atts, 'quote_cards', 'quote' ); }
	public static function cta_tiles( $atts ) { return self::simple_cards( $atts, 'cta_tiles', 'cta' ); }
	public static function metric_tiles( $atts ) { return self::simple_cards( $atts, 'metric_tiles', 'metric' ); }
	private static function simple_cards( $atts, $type, $kind ) {
		$a = self::a( $atts, $type ); $out = self::section_open( $type, $a ); $out .= self::head( $a, true ) . self::grid_open( $a['columns'], 'amaley-cw4-' . $kind . '-grid' );
		foreach ( $a['items_array'] as $item ) {
			if ( 'metric' === $kind ) { $out .= '<article class="amaley-cw4-metric"><strong>' . self::esc( self::text( $item, 'number' ) ) . '</strong><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></article>'; }
			elseif ( 'cta' === $kind ) { $out .= '<article class="amaley-cw4-cta"><span>' . self::esc( self::text( $item, 'icon', '→' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p>' . self::button( self::text( $item, 'button_text', 'Open' ), self::link_url( self::text( $item, 'url', '#' ) ), true ) . '</article>'; }
			else { $out .= '<article class="amaley-cw4-quote"><span>' . self::esc( self::text( $item, 'icon', '“' ) ) . '</span><h3>' . self::esc( self::text( $item, 'title' ) ) . '</h3><p>' . self::esc( self::text( $item, 'text' ) ) . '</p></article>'; }
		}
		return $out . '</div>' . self::section_close();
	}
}
