<?php
/**
 * Pages Hero Other renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders reusable inner-page hero variations for Amaley non-home pages.
 */
final class Amaley_UI_Pages_Hero_Other {

	/** Render hero. */
	public static function render( $atts = array() ) {
		$atts     = self::normalize_atts( $atts );
		$stats    = self::parse_pairs( $atts['stats'] );
		$features = self::parse_pairs( $atts['features'] );

		$classes = array(
			'amaley-pages-hero-other',
			'amaley-pages-hero-other--' . $atts['style'],
			'amaley-pages-hero-other--tone-' . $atts['tone'],
			'amaley-pages-hero-other--width-' . $atts['width'],
			'amaley-pages-hero-other--image-' . $atts['image_position'],
		);

		if ( '' !== $atts['extra_class'] ) {
			$classes[] = $atts['extra_class'];
		}

		$html  = '<section class="' . esc_attr( implode( ' ', $classes ) ) . '" aria-label="' . esc_attr( $atts['aria_label'] ) . '">';
		$html .= '<div class="amaley-pages-hero-other__inner">';

		switch ( $atts['style'] ) {
			case 'style-2':
				$html .= self::render_cluster( $atts, $stats );
				break;
			case 'style-3':
				$html .= self::render_intent( $atts, $stats );
				break;
			case 'style-6':
				$html .= self::render_image_split( $atts );
				break;
			case 'style-7':
			case 'style-9':
			case 'style-10':
			case 'style-11':
				$html .= self::render_editorial_image( $atts, $stats );
				break;
			case 'style-8':
			case 'style-12':
			case 'style-13':
				$html .= self::render_statement( $atts, $features, $stats );
				break;
			default:
				$html .= self::render_text_split( $atts );
				break;
		}

		$html .= '</div></section>';
		return $html;
	}

	/** Normalize attributes. */
	private static function normalize_atts( $atts ) {
		$allowed = self::allowed_styles();
		$incoming_style = '';
		if ( is_array( $atts ) ) {
			$incoming_style = isset( $atts['hero_style'] ) ? $atts['hero_style'] : ( isset( $atts['style'] ) ? $atts['style'] : '' );
		}
		$style    = self::safe_choice( $incoming_style, $allowed, 'style-1' );
		$defaults = self::preset_defaults( $style );

		$atts = shortcode_atts(
			array_merge(
				$defaults,
				array(
					'hero_style'     => $style,
					'style'          => $style,
					'tone'           => 'deep',
					'width'          => 'contained',
					'image_position' => 'right',
					'extra_class'    => '',
				)
			),
			$atts,
			'amaley_pages_hero_other'
		);

		$atts['style']          = self::safe_choice( isset( $atts['hero_style'] ) ? $atts['hero_style'] : $atts['style'], $allowed, $style );
		$atts['tone']           = self::safe_choice( $atts['tone'], array( 'deep', 'cream' ), 'deep' );
		$atts['width']          = self::safe_choice( $atts['width'], array( 'contained', 'full' ), 'contained' );
		$atts['image_position'] = self::safe_choice( $atts['image_position'], array( 'left', 'right' ), 'right' );
		$atts['extra_class']    = class_exists( 'Amaley_UI_Helpers' ) ? Amaley_UI_Helpers::extra_classes( $atts['extra_class'] ) : sanitize_html_class( $atts['extra_class'] );

		foreach ( array( 'kicker', 'title', 'accent', 'description', 'side_kicker', 'side_title', 'side_text', 'primary_text', 'secondary_text', 'image_alt', 'aria_label' ) as $key ) {
			$atts[ $key ] = isset( $atts[ $key ] ) ? wp_strip_all_tags( (string) $atts[ $key ] ) : '';
		}
		foreach ( array( 'primary_url', 'secondary_url', 'image' ) as $key ) {
			$atts[ $key ] = esc_url_raw( (string) $atts[ $key ] );
		}
		$atts['stats']    = wp_strip_all_tags( (string) $atts['stats'] );
		$atts['features'] = wp_strip_all_tags( (string) $atts['features'] );
		return $atts;
	}

	private static function allowed_styles() {
		return array( 'style-1', 'style-2', 'style-3', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11', 'style-12', 'style-13' );
	}

	/** Preset defaults. */
	private static function preset_defaults( $style ) {
		$common = array(
			'aria_label'     => 'Amaley page hero',
			'kicker'         => 'Amaley',
			'title'          => 'Amaley {Story}',
			'accent'         => 'Story',
			'description'    => 'Rooted stories, Himalayan ingredients and careful everyday foods.',
			'primary_text'   => '',
			'primary_url'    => '#',
			'secondary_text' => '',
			'secondary_url'  => '#',
			'side_kicker'    => '',
			'side_title'     => '',
			'side_text'      => '',
			'stats'          => '',
			'features'       => '',
			'image'          => '',
			'image_alt'      => '',
		);

		$presets = array(
			'style-1' => array(
				'aria_label'   => 'About Amaley hero',
				'kicker'       => 'Our Story',
				'title'        => 'About, {Amaley}',
				'accent'       => 'Amaley',
				'description'  => 'A heart-led journey rooted in Himalayan food, women-led livelihoods, and honest ingredients made for everyday homes.',
				'primary_text' => 'Explore Our Journey →',
				'side_title'   => 'Rooted in the Himalayas',
				'side_text'    => 'Pure. Honest. Traceable.',
			),
			'style-2' => array(
				'aria_label'  => 'Amaley clusters hero',
				'kicker'      => 'Traceable by place, group, and maker',
				'title'       => 'Clusters that hold the {Amaley story together.}',
				'accent'      => 'Amaley story together.',
				'description' => 'This is where Amaley becomes visible as an ecosystem — products linked to landscapes, SHGs, women producers, seasonality, and village-level enterprise.',
				'stats'       => '05::Clusters|05::SHG Groups|Traceable::Place to Product',
			),
			'style-3' => array(
				'aria_label'     => 'Amaley collections hero',
				'kicker'         => 'Amaley Collections',
				'title'          => 'Explore {Collections.}',
				'accent'         => 'Collections.',
				'description'    => 'Discover Amaley through curated product worlds shaped by Himalayan ingredients, women-led groups, cluster identities, and everyday use-cases.',
				'primary_text'   => 'Explore Collections',
				'secondary_text' => 'Build a Gift Box',
				'side_kicker'    => 'Start with intent',
				'side_title'     => 'Choose by why you are buying.',
				'side_text'      => 'Gift, breakfast, wellness, hospitality, retail placement, or everyday pantry — this page helps buyers choose the right Amaley line.',
				'stats'          => '12+::Curated Lines|3::Buying Routes|100%::Place-led Story',
			),
			'style-5' => array(
				'aria_label'     => 'Contact Amaley hero',
				'kicker'         => 'Contact',
				'title'          => 'Start a Conversation {with Amaley}',
				'accent'         => 'with Amaley',
				'description'    => 'Whether it is a product enquiry, gifting request, retail conversation, hospitality placement or collaboration — write to us with your requirement.',
				'primary_text'   => 'Send an Enquiry',
				'secondary_text' => 'Explore Collections',
			),
			'style-6' => array(
				'aria_label'   => 'Amaley gifting hero',
				'kicker'       => 'Gifts that come from the Himalayas',
				'title'        => 'Gifting with {Meaning}',
				'accent'       => 'Meaning',
				'description'  => 'Thoughtfully curated hampers made with honest ingredients, traditional recipes and lots of care. Because the best gifts are the ones that care back.',
				'primary_text' => 'Explore Gift Collections →',
				'image_alt'    => 'Amaley curated gifting box',
			),
			'style-7' => array(
				'aria_label'     => 'Amaley premium editorial hero',
				'kicker'         => 'Crafted for thoughtful homes',
				'title'          => 'Small-batch food with a {Himalayan soul}',
				'accent'         => 'Himalayan soul',
				'description'    => 'A refined inner-page hero for premium pages — clean editorial copy, one strong visual, and a small floating story note for trust and context.',
				'primary_text'   => 'Explore Products',
				'secondary_text' => 'Read the Story',
				'side_kicker'    => 'Amaley Note',
				'side_title'     => 'Made with care',
				'side_text'      => 'Best for About, Quality, Ingredients, and premium brand pages.',
				'stats'          => 'Natural::Ingredients|Small::Batches|Traceable::Origins',
				'image_alt'      => 'Amaley premium Himalayan product story',
			),
			'style-8' => array(
				'aria_label'  => 'Amaley centered statement hero',
				'kicker'      => 'Amaley Collective',
				'title'       => 'Rooted in {Himalayan care}',
				'accent'      => 'Himalayan care',
				'description' => 'A calm, centered hero for simple pages where the message matters more than imagery.',
				'features'    => 'Pure Ingredients::Thoughtfully sourced and prepared|Women Collectives::Community-rooted production|Small Batch::Made with discipline and care',
			),
			'style-9' => array(
				'aria_label'     => 'Amaley framed editorial hero',
				'kicker'         => 'From place to plate',
				'title'          => 'Every batch begins with a {Himalayan place}',
				'accent'         => 'Himalayan place',
				'description'    => 'An editorial image-forward hero with a clean framed image and story note. Best for cluster, ingredient, and origin pages.',
				'primary_text'   => 'Explore the Origin',
				'side_kicker'    => 'Origin Note',
				'side_title'     => 'Place-led batches',
				'side_text'      => 'Use this when image and place need to lead the page narrative.',
				'stats'          => 'Place::First|Makers::Visible|Batch::Traceable',
			),
			'style-10' => array(
				'aria_label'     => 'Amaley product story hero',
				'kicker'         => 'Ingredient led',
				'title'          => 'A quieter hero for {product stories}',
				'accent'         => 'product stories',
				'description'    => 'Balanced image, refined copy, and a compact trust note. Best for ingredient, quality, and value-chain pages.',
				'primary_text'   => 'Read the Story',
				'secondary_text' => 'View Products',
				'side_kicker'    => 'Quality Note',
				'side_title'     => 'Small-batch discipline',
				'side_text'      => 'A premium page hero without making the page feel too heavy.',
				'stats'          => 'Seasonal::Produce|Careful::Sorting|Clean::Processing',
			),
			'style-11' => array(
				'aria_label'     => 'Amaley warm image story hero',
				'kicker'         => 'Stories from the hills',
				'title'          => 'Where food carries {memory and care}',
				'accent'         => 'memory and care',
				'description'    => 'A softer image and content composition for pages that need warmth, people, and story without clutter.',
				'primary_text'   => 'Begin Reading',
				'side_kicker'    => 'Field Note',
				'side_title'     => 'Human-first design',
				'side_text'      => 'Works well for journal, story, and producer narrative pages.',
				'stats'          => 'People::First|Recipes::Rooted|Stories::Alive',
			),
			'style-12' => array(
				'aria_label'  => 'Amaley centered trust board hero',
				'kicker'      => 'A clear Amaley promise',
				'title'       => 'Pure. Small-batch. {Traceable.}',
				'accent'      => 'Traceable.',
				'description' => 'A minimal centered hero with a strong promise board. Best for policy, assurance, quality, and simple brand pages.',
				'features'    => 'Natural Produce::No unnecessary complexity|Quality Checks::Built into every batch|Place-linked::Stories stay connected',
			),
			'style-13' => array(
				'aria_label'  => 'Amaley quiet centered hero',
				'kicker'      => 'Simple and premium',
				'title'       => 'A calm page start for {focused actions}',
				'accent'      => 'focused actions',
				'description' => 'A very clean centered statement hero for contact, partner enquiry, terms, policies, or pages that should not feel image-heavy.',
				'primary_text'=> 'Start Here',
				'features'    => 'Clear Message::No visual clutter|Fast Loading::No image required|Easy Edit::Simple controls',
			),
		);

		return array_merge( $common, isset( $presets[ $style ] ) ? $presets[ $style ] : $presets['style-1'] );
	}

	private static function render_text_split( $atts ) {
		$html  = '<div class="amaley-pages-hero-other__text-grid">';
		$html .= self::render_content( $atts );
		if ( 'style-1' === $atts['style'] && '' !== $atts['side_title'] ) {
			$html .= '<div class="amaley-pages-hero-other__side-text"><h2>' . self::title_html( $atts['side_title'], '' ) . '</h2>';
			$html .= '' !== $atts['side_text'] ? '<p>' . esc_html( $atts['side_text'] ) . '</p>' : '';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}

	private static function render_cluster( $atts, $stats ) {
		return '<div class="amaley-pages-hero-other__cluster-wrap">' . self::render_content( $atts, $stats ) . '</div>';
	}

	private static function render_intent( $atts, $stats ) {
		$html  = '<div class="amaley-pages-hero-other__collections-grid">';
		$html .= self::render_content( $atts );
		$html .= '<aside class="amaley-pages-hero-other__intent-card">';
		$html .= '' !== $atts['side_kicker'] ? '<span class="amaley-pages-hero-other__kicker">' . esc_html( $atts['side_kicker'] ) . '</span>' : '';
		$html .= '' !== $atts['side_title'] ? '<h2>' . self::title_html( $atts['side_title'], '' ) . '</h2>' : '';
		$html .= '' !== $atts['side_text'] ? '<p>' . esc_html( $atts['side_text'] ) . '</p>' : '';
		$html .= self::render_stats( $stats );
		$html .= '</aside></div>';
		return $html;
	}

	private static function render_image_split( $atts ) {
		$html  = '<div class="amaley-pages-hero-other__image-grid">';
		$html .= 'left' === $atts['image_position'] ? self::render_media( $atts ) . self::render_content( $atts ) : self::render_content( $atts ) . self::render_media( $atts );
		$html .= '</div>';
		return $html;
	}

	private static function render_editorial_image( $atts, $stats ) {
		$copy  = '<div class="amaley-pages-hero-other__editorial-copy">' . self::render_content( $atts, $stats ) . '</div>';
		$media = '<div class="amaley-pages-hero-other__editorial-media-wrap">';
		$media .= self::render_media( $atts );
		if ( '' !== $atts['side_title'] || '' !== $atts['side_text'] ) {
			$media .= '<aside class="amaley-pages-hero-other__editorial-note">';
			$media .= '' !== $atts['side_kicker'] ? '<span>' . esc_html( $atts['side_kicker'] ) . '</span>' : '';
			$media .= '' !== $atts['side_title'] ? '<strong>' . esc_html( $atts['side_title'] ) . '</strong>' : '';
			$media .= '' !== $atts['side_text'] ? '<p>' . esc_html( $atts['side_text'] ) . '</p>' : '';
			$media .= '</aside>';
		}
		$media .= '</div>';

		$html  = '<div class="amaley-pages-hero-other__editorial-grid">';
		$html .= 'left' === $atts['image_position'] ? $media . $copy : $copy . $media;
		$html .= '</div>';
		return $html;
	}

	private static function render_statement( $atts, $features, $stats ) {
		$html  = '<div class="amaley-pages-hero-other__statement-wrap">';
		$html .= '<div class="amaley-pages-hero-other__statement-content">' . self::render_content( $atts, $stats ) . '</div>';
		if ( ! empty( $features ) ) {
			$html .= '<div class="amaley-pages-hero-other__statement-pills">';
			foreach ( $features as $feature ) {
				$html .= '<div class="amaley-pages-hero-other__statement-pill"><strong>' . esc_html( $feature['value'] ) . '</strong><span>' . esc_html( $feature['label'] ) . '</span></div>';
			}
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}

	private static function render_content( $atts, $stats = array() ) {
		$html  = '<div class="amaley-pages-hero-other__content">';
		$html .= '' !== $atts['kicker'] ? '<span class="amaley-pages-hero-other__kicker">' . esc_html( $atts['kicker'] ) . '</span>' : '';
		$html .= '<h1 class="amaley-pages-hero-other__title">' . self::title_html( $atts['title'], $atts['accent'] ) . '</h1>';
		$html .= '' !== $atts['description'] ? '<p class="amaley-pages-hero-other__description">' . esc_html( $atts['description'] ) . '</p>' : '';
		$html .= self::render_buttons( $atts );
		$html .= self::render_stats( $stats );
		$html .= '</div>';
		return $html;
	}

	private static function render_media( $atts ) {
		if ( '' === $atts['image'] ) {
			return '<div class="amaley-pages-hero-other__media amaley-pages-hero-other__media--empty" aria-hidden="true"></div>';
		}
		return '<figure class="amaley-pages-hero-other__media"><img src="' . esc_url( $atts['image'] ) . '" alt="' . esc_attr( $atts['image_alt'] ) . '"></figure>';
	}

	private static function render_buttons( $atts ) {
		if ( '' === $atts['primary_text'] && '' === $atts['secondary_text'] ) {
			return '';
		}
		$html = '<div class="amaley-pages-hero-other__actions">';
		if ( '' !== $atts['primary_text'] ) {
			$html .= '<a class="amaley-pages-hero-other__btn amaley-pages-hero-other__btn--primary" href="' . esc_url( $atts['primary_url'] ) . '">' . esc_html( $atts['primary_text'] ) . '</a>';
		}
		if ( '' !== $atts['secondary_text'] ) {
			$html .= '<a class="amaley-pages-hero-other__btn amaley-pages-hero-other__btn--secondary" href="' . esc_url( $atts['secondary_url'] ) . '">' . esc_html( $atts['secondary_text'] ) . '</a>';
		}
		$html .= '</div>';
		return $html;
	}

	private static function render_stats( $stats ) {
		if ( empty( $stats ) ) {
			return '';
		}
		$html = '<div class="amaley-pages-hero-other__stats">';
		foreach ( $stats as $stat ) {
			$html .= '<div class="amaley-pages-hero-other__stat"><strong>' . esc_html( $stat['value'] ) . '</strong><span>' . esc_html( $stat['label'] ) . '</span></div>';
		}
		$html .= '</div>';
		return $html;
	}

	private static function title_html( $title, $accent ) {
		$title  = (string) $title;
		$accent = (string) $accent;
		if ( '' !== $accent && false !== strpos( $title, '{' . $accent . '}' ) ) {
			return str_replace( '{' . $accent . '}', '<em>' . esc_html( $accent ) . '</em>', esc_html( $title ) );
		}
		if ( false !== strpos( $title, '{' ) && false !== strpos( $title, '}' ) ) {
			return preg_replace_callback( '/\{([^}]+)\}/', function( $matches ) { return '<em>' . esc_html( $matches[1] ) . '</em>'; }, esc_html( $title ) );
		}
		return esc_html( $title );
	}

	private static function parse_pairs( $raw ) {
		$items = array();
		$raw   = trim( (string) $raw );
		if ( '' === $raw ) {
			return $items;
		}
		foreach ( explode( '|', $raw ) as $piece ) {
			$parts = array_map( 'trim', explode( '::', $piece, 2 ) );
			if ( '' === $parts[0] ) {
				continue;
			}
			$items[] = array( 'value' => wp_strip_all_tags( $parts[0] ), 'label' => isset( $parts[1] ) ? wp_strip_all_tags( $parts[1] ) : '' );
		}
		return $items;
	}

	private static function safe_choice( $value, $allowed, $default ) {
		$value = sanitize_key( (string) $value );
		return in_array( $value, $allowed, true ) ? $value : $default;
	}
}
