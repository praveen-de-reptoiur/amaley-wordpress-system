<?php
/**
 * Renderer layer for Amaley Compact Widgets v0.4.2.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Renderer {
	public static function widget_definitions() {
		return array(
			'info_cards'          => array( 'title' => 'Amaley Info Cards Grid', 'shortcode' => 'amaley_cw_info_cards', 'method' => 'info_cards', 'columns' => true ),
			'split_editorial'     => array( 'title' => 'Amaley Split Editorial', 'shortcode' => 'amaley_cw_split_editorial', 'method' => 'split_editorial', 'media' => true, 'buttons' => true ),
			'traceability'        => array( 'title' => 'Amaley Traceability Journey', 'shortcode' => 'amaley_cw_traceability', 'method' => 'traceability' ),
			'gifting_band'        => array( 'title' => 'Amaley Gifting / Bulk Band', 'shortcode' => 'amaley_cw_gifting_band', 'method' => 'gifting_band', 'buttons' => true ),
			'value_strip'         => array( 'title' => 'Amaley Feature / Value Strip', 'shortcode' => 'amaley_cw_value_strip', 'method' => 'value_strip', 'columns' => true ),
			'process_steps'       => array( 'title' => 'Amaley Process Steps', 'shortcode' => 'amaley_cw_process_steps', 'method' => 'process_steps', 'columns' => true, 'images' => true ),
			'origin_cards'        => array( 'title' => 'Amaley Origin Story Cards', 'shortcode' => 'amaley_cw_origin_cards', 'method' => 'origin_cards', 'columns' => true, 'images' => true ),
			'purpose_cards'       => array( 'title' => 'Amaley Purpose Cards', 'shortcode' => 'amaley_cw_purpose_cards', 'method' => 'purpose_cards', 'columns' => true ),
			'collection_cards'    => array( 'title' => 'Amaley Collection Cards', 'shortcode' => 'amaley_cw_collection_cards', 'method' => 'collection_cards', 'columns' => true, 'images' => true ),
			'two_panel_info'      => array( 'title' => 'Amaley Two Panel Info', 'shortcode' => 'amaley_cw_two_panel_info', 'method' => 'two_panel_info' ),
			'dark_chain'          => array( 'title' => 'Amaley Dark Chain Cards', 'shortcode' => 'amaley_cw_dark_chain', 'method' => 'dark_chain', 'columns' => true ),
			'image_flip_cards'    => array( 'title' => 'Amaley Image Flip Cards', 'shortcode' => 'amaley_cw_image_flip_cards', 'method' => 'image_flip_cards', 'columns' => true, 'images' => true, 'flip' => true ),
			'image_cards'         => array( 'title' => 'Amaley Image Cards', 'shortcode' => 'amaley_cw_image_cards', 'method' => 'image_cards', 'columns' => true, 'images' => true ),
			'image_info_cards'    => array( 'title' => 'Amaley Image Info Cards', 'shortcode' => 'amaley_cw_image_info_cards', 'method' => 'image_info_cards', 'columns' => true, 'images' => true ),
			'image_overlay_cards' => array( 'title' => 'Amaley Image Overlay Cards', 'shortcode' => 'amaley_cw_image_overlay_cards', 'method' => 'image_overlay_cards', 'columns' => true, 'images' => true ),
			'quote_cards'         => array( 'title' => 'Amaley Quote Cards', 'shortcode' => 'amaley_cw_quote_cards', 'method' => 'quote_cards', 'columns' => true ),
			'cta_tiles'           => array( 'title' => 'Amaley CTA Tiles', 'shortcode' => 'amaley_cw_cta_tiles', 'method' => 'cta_tiles', 'columns' => true ),
			'metric_tiles'        => array( 'title' => 'Amaley Metric Tiles', 'shortcode' => 'amaley_cw_metric_tiles', 'method' => 'metric_tiles', 'columns' => true ),
		);
	}

	public static function elementor_defaults( $type ) { return array( 'defaults' => self::defaults( $type ), 'items' => self::items_for( $type ) ); }
	private static function e( $v ) { return function_exists( 'esc_html' ) ? esc_html( $v ) : htmlspecialchars( (string) $v, ENT_QUOTES, 'UTF-8' ); }
	private static function a( $v ) { return function_exists( 'esc_attr' ) ? esc_attr( $v ) : htmlspecialchars( (string) $v, ENT_QUOTES, 'UTF-8' ); }
	private static function u( $v ) { return function_exists( 'esc_url' ) ? esc_url( $v ) : htmlspecialchars( (string) $v, ENT_QUOTES, 'UTF-8' ); }

	private static function defaults( $type ) {
		$base = array( 'style'=>'style-1', 'kicker'=>'AMALEY', 'title'=>'A Better Amaley Section', 'accent'=>'', 'description'=>'', 'button_text'=>'Explore', 'button_url'=>'#', 'secondary_text'=>'', 'secondary_url'=>'#', 'image_url'=>'', 'image_alt'=>'Amaley visual', 'items'=>'', 'columns'=>'3', 'align'=>'left', 'header_align'=>'left', 'card_align'=>'left', 'button_align'=>'left', 'image_side'=>'left' );
		$map = array(
			'info_cards'=>array('kicker'=>'FEATURED COLLECTIONS','title'=>'Collections that help a buyer decide faster','accent'=>'buyer','description'=>'Compact benefit cards, buyer notes and collection explanations.','columns'=>'4'),
			'split_editorial'=>array('kicker'=>'OUR STORY','title'=>'Rooted in the Himalayas, Made for You','accent'=>'Made','description'=>'Mountain ingredients, careful preparation and community-rooted value in products that feel honest and gift-worthy.','button_text'=>'Explore Our Story','secondary_text'=>'View Products'),
			'traceability'=>array('kicker'=>'TRACEABILITY','title'=>'From Cluster to Kitchen to Customer','accent'=>'Customer','description'=>'Show sourcing, preparation, packing and customer use without clutter.'),
			'gifting_band'=>array('kicker'=>'GIFTING','title'=>'Gifts That Carry a Place With Them','accent'=>'Place','description'=>'Curated Amaley hampers for teams, guests, events and partner shelves.','button_text'=>'Plan a Gift Box','secondary_text'=>'Talk to Us'),
			'value_strip'=>array('kicker'=>'OUR VALUES','title'=>'Why Choose Amaley Gifts?','accent'=>'Choose','description'=>'Simple reasons that help customers trust the product and the people behind it.','columns'=>'4'),
			'purpose_cards'=>array('kicker'=>'FOR WHOM','title'=>'Made for homes, gifting, shelves and stays','accent'=>'homes','description'=>'Help different buyers quickly find their entry point.','columns'=>'4'),
		);
		return array_merge( $base, isset( $map[$type] ) ? $map[$type] : array( 'kicker'=>strtoupper(str_replace('_',' ', $type)), 'title'=>ucwords(str_replace('_',' ', $type)), 'description'=>'A compact Amaley section with professional spacing and mobile-first layout.' ) );
	}

	private static function setup( $atts, $type ) {
		$a = array_merge( self::defaults( $type ), is_array( $atts ) ? $atts : array() );
		foreach ( array( 'align','header_align','card_align','button_align' ) as $k ) { if ( ! in_array( $a[$k], array( 'left','center','right' ), true ) ) { $a[$k] = 'left'; } }
		$a['columns'] = in_array( (string) $a['columns'], array( '1','2','3','4' ), true ) ? (string) $a['columns'] : '3';
		$a['items_array'] = self::items_for( $type );
		return $a;
	}

	private static function items_for( $type ) {
		$sets = array(
			'info_cards'=>array(array('number'=>'01','title'=>'Purpose-led collections','text'=>'Designed around real buying moments, not random product grouping.'),array('number'=>'02','title'=>'Clear product use','text'=>'Each card explains when and why the product fits.'),array('number'=>'03','title'=>'Himalayan identity','text'=>'Place and ingredient story remain visible.'),array('number'=>'04','title'=>'Easy decisions','text'=>'Users understand value quickly.')),
			'split_editorial'=>array(array('number'=>'01','title'=>'Ingredients with identity','text'=>'Products begin with regional produce and mountain food memories.'),array('number'=>'02','title'=>'Prepared with care','text'=>'Small batches keep the product honest and easier to trust.'),array('number'=>'03','title'=>'Value reaches people','text'=>'Design and market access convert work into income.')),
			'traceability'=>array(array('number'=>'01','title'=>'Cluster','text'=>'Ingredients and makers are mapped.'),array('number'=>'02','title'=>'Kitchen','text'=>'Processing and preparation are organised.'),array('number'=>'03','title'=>'Packaging','text'=>'Labels and product story become clear.'),array('number'=>'04','title'=>'Customer','text'=>'Buyers understand source, use and value.')),
			'gifting_band'=>array(array('number'=>'01','title'=>'Corporate gifts','text'=>'Curated boxes for partners and teams.'),array('number'=>'02','title'=>'Hospitality shelves','text'=>'Products for welcome trays and guest tables.'),array('number'=>'03','title'=>'Festival hampers','text'=>'Useful, beautiful, place-rooted gifting.')),
			'value_strip'=>array(array('icon'=>'✦','title'=>'Natural ingredients','text'=>'No unnecessary showmanship.'),array('icon'=>'◇','title'=>'Women-led value','text'=>'Community enterprise stays visible.'),array('icon'=>'□','title'=>'Small batch care','text'=>'Quality remains easier to check.'),array('icon'=>'♡','title'=>'Gift-ready','text'=>'Premium enough for shelves and hampers.')),
			'purpose_cards'=>array(array('icon'=>'Home','title'=>'Everyday homes','text'=>'Preserves, infusions and pantry products.'),array('icon'=>'Gift','title'=>'Gifting buyers','text'=>'Thoughtful gifts with a clear story.'),array('icon'=>'Retail','title'=>'Retail shelves','text'=>'Premium-looking products for stores.'),array('icon'=>'Stay','title'=>'Hospitality hosts','text'=>'Guest tables, welcome trays and local shelves.')),
		);
		return $sets[$type] ?? array(array('number'=>'01','title'=>'Amaley card','text'=>'A compact premium card for this section.'),array('number'=>'02','title'=>'Clear information','text'=>'Useful copy that stays readable on mobile.'),array('number'=>'03','title'=>'Professional layout','text'=>'Scoped styling with no frontend JavaScript.'));
	}

	private static function open( $type, $a, $extra='' ) { return '<section class="amaley-cw4 amaley-cw4-' . self::a(str_replace('_','-', $type)) . ' amaley-cw4-head-align-' . self::a($a['header_align']) . ' amaley-cw4-card-align-' . self::a($a['card_align']) . ' amaley-cw4-btn-align-' . self::a($a['button_align']) . ' ' . self::a($extra) . '"><div class="amaley-cw4-inner">'; }
	private static function close() { return '</div></section>'; }
	private static function head( $a ) { return '<div class="amaley-cw4-head"><p class="amaley-cw4-kicker">'.self::e($a['kicker']).'</p><h2 class="amaley-cw4-title">'.self::e($a['title']).'</h2><p class="amaley-cw4-desc">'.self::e($a['description']).'</p></div>'; }
	private static function button( $txt, $url='#', $ghost=false ) { return $txt ? '<a class="amaley-cw4-btn '.($ghost?'amaley-cw4-btn--ghost':'').'" href="'.self::u($url).'">'.self::e($txt).'</a>' : ''; }
	private static function photo( $label='Amaley visual' ) { return '<figure class="amaley-cw4-photo amaley-cw4-photo--placeholder"><span>'.self::e($label).'</span></figure>'; }

	private static function grid( $type, $a, $class='amaley-cw4-card' ) {
		$out = self::open($type,$a) . self::head($a) . '<div class="amaley-cw4-grid" style="--acw4-cols:'.self::a($a['columns']).'">';
		foreach ( $a['items_array'] as $i ) { $out .= '<article class="'.self::a($class).'"><span class="amaley-cw4-meta">'.self::e($i['number'] ?? $i['icon'] ?? '✦').'</span><h3>'.self::e($i['title']).'</h3><p>'.self::e($i['text']).'</p></article>'; }
		return $out . '</div>' . self::close();
	}

	public static function info_cards( $atts=array() ) { return self::grid('info_cards', self::setup($atts,'info_cards')); }
	public static function value_strip( $atts=array() ) { return self::grid('value_strip', self::setup($atts,'value_strip'), 'amaley-cw4-icon-card'); }
	public static function purpose_cards( $atts=array() ) { return self::grid('purpose_cards', self::setup($atts,'purpose_cards')); }
	public static function process_steps( $atts=array() ) { return self::grid('process_steps', self::setup($atts,'process_steps'), 'amaley-cw4-process-card'); }
	public static function origin_cards( $atts=array() ) { return self::grid('origin_cards', self::setup($atts,'origin_cards'), 'amaley-cw4-image-card'); }
	public static function collection_cards( $atts=array() ) { return self::grid('collection_cards', self::setup($atts,'collection_cards'), 'amaley-cw4-image-card'); }
	public static function two_panel_info( $atts=array() ) { return self::grid('two_panel_info', self::setup($atts,'two_panel_info'), 'amaley-cw4-card'); }
	public static function dark_chain( $atts=array() ) { return self::grid('dark_chain', self::setup($atts,'dark_chain'), 'amaley-cw4-card'); }
	public static function image_flip_cards( $atts=array() ) { return self::grid('image_flip_cards', self::setup($atts,'image_flip_cards'), 'amaley-cw4-image-card'); }
	public static function image_cards( $atts=array() ) { return self::grid('image_cards', self::setup($atts,'image_cards'), 'amaley-cw4-image-card'); }
	public static function image_info_cards( $atts=array() ) { return self::grid('image_info_cards', self::setup($atts,'image_info_cards'), 'amaley-cw4-image-card'); }
	public static function image_overlay_cards( $atts=array() ) { return self::grid('image_overlay_cards', self::setup($atts,'image_overlay_cards'), 'amaley-cw4-image-card'); }
	public static function quote_cards( $atts=array() ) { return self::grid('quote_cards', self::setup($atts,'quote_cards'), 'amaley-cw4-quote'); }
	public static function cta_tiles( $atts=array() ) { return self::grid('cta_tiles', self::setup($atts,'cta_tiles'), 'amaley-cw4-cta'); }
	public static function metric_tiles( $atts=array() ) { return self::grid('metric_tiles', self::setup($atts,'metric_tiles'), 'amaley-cw4-metric'); }

	public static function split_editorial( $atts=array() ) { $a=self::setup($atts,'split_editorial'); $out=self::open('split_editorial',$a,'amaley-cw4-story-pro'); $out.='<div class="amaley-cw4-story-shell"><div>'.self::photo('Amaley product table visual').'</div><div>'.self::head($a).'<div class="amaley-cw4-story-lines">'; foreach($a['items_array'] as $i){$out.='<article><span>'.self::e($i['number']).'</span><div><h3>'.self::e($i['title']).'</h3><p>'.self::e($i['text']).'</p></div></article>'; } $out.='</div><div class="amaley-cw4-actions">'.self::button($a['button_text'],$a['button_url']).self::button($a['secondary_text'],$a['secondary_url'],true).'</div></div></div>'; return $out.self::close(); }
	public static function traceability( $atts=array() ) { $a=self::setup($atts,'traceability'); $out=self::open('traceability',$a,'amaley-cw4-trace-pro'); $out.=self::head($a).'<div class="amaley-cw4-trace-board"><div class="amaley-cw4-route">'; foreach($a['items_array'] as $i){$out.='<article><span>'.self::e($i['number']).'</span><div><h3>'.self::e($i['title']).'</h3><p>'.self::e($i['text']).'</p></div></article>'; } return $out.'</div></div>'.self::close(); }
	public static function gifting_band( $atts=array() ) { $a=self::setup($atts,'gifting_band'); $out=self::open('gifting_band',$a,'amaley-cw4-gift-pro'); $out.='<div class="amaley-cw4-gift-shell"><div>'.self::head($a).'<div class="amaley-cw4-actions">'.self::button($a['button_text'],$a['button_url']).self::button($a['secondary_text'],$a['secondary_url'],true).'</div></div><div class="amaley-cw4-gift-panel">'; foreach($a['items_array'] as $i){$out.='<article><span>'.self::e($i['number']).'</span><div><h3>'.self::e($i['title']).'</h3><p>'.self::e($i['text']).'</p></div></article>'; } return $out.'</div></div>'.self::close(); }
}
