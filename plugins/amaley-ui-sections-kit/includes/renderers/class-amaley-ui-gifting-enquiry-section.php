<?php
/**
 * Gifting enquiry section renderer.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders a two-column gifting / bulk enquiry section with safe form embed slot.
 */
final class Amaley_UI_Gifting_Enquiry_Section {

	/**
	 * Default enquiry points.
	 *
	 * @return array
	 */
	public static function default_points() {
		return array(
			array(
				'icon' => '🎁',
				'text' => 'Corporate & Festival Gift Hampers',
			),
			array(
				'icon' => '⌂',
				'text' => 'Hotels, Homestays & Hospitality Counters',
			),
			array(
				'icon' => '⇄',
				'text' => 'Retail Partnerships & Resellers',
			),
			array(
				'icon' => '▣',
				'text' => 'Institutional & CSR Procurement',
			),
		);
	}

	/**
	 * Normalises point input.
	 *
	 * @param mixed $points Points input.
	 * @return array
	 */
	public static function normalise_points( $points ) {
		$defaults = self::default_points();

		if ( is_string( $points ) && '' !== trim( $points ) ) {
			$decoded = json_decode( wp_unslash( $points ), true );
			if ( is_array( $decoded ) ) {
				$points = $decoded;
			}
		}

		if ( ! is_array( $points ) || empty( $points ) ) {
			$points = $defaults;
		}

		$normalised = array();
		foreach ( $points as $point ) {
			if ( ! is_array( $point ) ) {
				continue;
			}

			$normalised[] = array(
				'icon' => isset( $point['icon'] ) ? (string) $point['icon'] : '',
				'text' => isset( $point['text'] ) ? (string) $point['text'] : '',
			);
		}

		return ! empty( $normalised ) ? $normalised : $defaults;
	}

	/**
	 * Renders title with brace-based accent markup.
	 *
	 * @param string $title Title text.
	 * @param string $accent Accent phrase.
	 * @return string
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
	 * Renders a button.
	 *
	 * @param string $text Button text.
	 * @param string $url Button URL.
	 * @return string
	 */
	private static function button_html( $text, $url ) {
		if ( '' === trim( (string) $text ) ) {
			return '';
		}

		return '<a class="amaley-gifting-enquiry-section__button" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a>';
	}

	/**
	 * Renders fallback fillable, non-submitting form preview.
	 *
	 * @param array $atts Section attributes.
	 * @return string
	 */
	private static function fallback_form_html( $atts = array() ) {
		$labels = array(
			'first_name_label' => isset( $atts['first_name_label'] ) ? $atts['first_name_label'] : 'First Name',
			'last_name_label'  => isset( $atts['last_name_label'] ) ? $atts['last_name_label'] : 'Last Name',
			'email_label'      => isset( $atts['email_label'] ) ? $atts['email_label'] : 'Email Address',
			'enquiry_label'    => isset( $atts['enquiry_label'] ) ? $atts['enquiry_label'] : 'Type of Enquiry',
			'message_label'    => isset( $atts['message_label'] ) ? $atts['message_label'] : 'Your Message',
			'submit_label'     => isset( $atts['submit_label'] ) ? $atts['submit_label'] : 'Submit Enquiry →',
		);

		$html  = '<form class="amaley-gifting-enquiry-section__fallback-form amaley-gifting-enquiry-section__dummy-form" aria-label="Enquiry form preview" onsubmit="return false;">';
		$html .= '<div class="amaley-gifting-enquiry-section__form-row">';
		$html .= '<input class="amaley-gifting-enquiry-section__fake-field amaley-gifting-enquiry-section__dummy-input" type="text" name="amaley_dummy_first_name" autocomplete="given-name" placeholder="' . esc_attr( $labels['first_name_label'] ) . '">';
		$html .= '<input class="amaley-gifting-enquiry-section__fake-field amaley-gifting-enquiry-section__dummy-input" type="text" name="amaley_dummy_last_name" autocomplete="family-name" placeholder="' . esc_attr( $labels['last_name_label'] ) . '">';
		$html .= '</div>';
		$html .= '<input class="amaley-gifting-enquiry-section__fake-field amaley-gifting-enquiry-section__dummy-input amaley-gifting-enquiry-section__fake-field--full" type="email" name="amaley_dummy_email" autocomplete="email" placeholder="' . esc_attr( $labels['email_label'] ) . '">';
		$html .= '<input class="amaley-gifting-enquiry-section__fake-field amaley-gifting-enquiry-section__dummy-input amaley-gifting-enquiry-section__fake-field--full" type="text" name="amaley_dummy_enquiry_type" placeholder="' . esc_attr( $labels['enquiry_label'] ) . '">';
		$html .= '<textarea class="amaley-gifting-enquiry-section__fake-field amaley-gifting-enquiry-section__dummy-input amaley-gifting-enquiry-section__fake-field--message" name="amaley_dummy_message" placeholder="' . esc_attr( $labels['message_label'] ) . '"></textarea>';
		$html .= '<button class="amaley-gifting-enquiry-section__fake-submit amaley-gifting-enquiry-section__dummy-submit" type="button">' . esc_html( $labels['submit_label'] ) . '</button>';
		$html .= '</form>';

		return $html;
	}

	/**
	 * Returns a controlled allow-list for real form embeds.
	 *
	 * This keeps future Contact Form 7 / WPForms / Elementor form output usable
	 * without allowing unsafe script tags or global markup.
	 *
	 * @return array
	 */
	private static function allowed_form_embed_html() {
		$allowed = wp_kses_allowed_html( 'post' );

		$global_attrs = array(
			'class'       => true,
			'id'          => true,
			'style'       => true,
			'title'       => true,
			'role'        => true,
			'aria-label'  => true,
			'aria-live'   => true,
			'aria-hidden' => true,
			'aria-invalid' => true,
			'aria-required' => true,
			'data-id'     => true,
			'data-name'   => true,
			'data-status' => true,
			'data-formid' => true,
			'data-field-id' => true,
			'data-alt-text' => true,
			'data-submit-text' => true,
		);

		$allowed['form'] = array_merge(
			$global_attrs,
			array(
				'action'     => true,
				'method'     => true,
				'name'       => true,
				'enctype'    => true,
				'novalidate' => true,
				'target'     => true,
			)
		);

		$allowed['input'] = array_merge(
			$global_attrs,
			array(
				'type'         => true,
				'name'         => true,
				'value'        => true,
				'placeholder'  => true,
				'autocomplete' => true,
				'required'     => true,
				'checked'      => true,
				'disabled'     => true,
				'readonly'     => true,
				'min'          => true,
				'max'          => true,
				'minlength'    => true,
				'maxlength'    => true,
				'size'         => true,
			)
		);

		$allowed['textarea'] = array_merge(
			$global_attrs,
			array(
				'name'         => true,
				'placeholder'  => true,
				'autocomplete' => true,
				'required'     => true,
				'disabled'     => true,
				'readonly'     => true,
				'rows'         => true,
				'cols'         => true,
				'minlength'    => true,
				'maxlength'    => true,
			)
		);

		$allowed['select'] = array_merge(
			$global_attrs,
			array(
				'name'     => true,
				'required' => true,
				'multiple' => true,
				'disabled' => true,
			)
		);

		$allowed['option'] = array(
			'value'    => true,
			'selected' => true,
			'disabled' => true,
			'class'    => true,
			'id'       => true,
		);

		$allowed['label'] = array_merge( $global_attrs, array( 'for' => true ) );
		$allowed['button'] = array_merge(
			$global_attrs,
			array(
				'type'     => true,
				'name'     => true,
				'value'    => true,
				'disabled' => true,
			)
		);
		$allowed['fieldset'] = $global_attrs;
		$allowed['legend']   = $global_attrs;

		return $allowed;
	}

	/**
	 * Renders form embed HTML / shortcode.
	 *
	 * @param string $embed Embed string.
	 * @param string $mode Display mode.
	 * @param array  $atts Section attributes.
	 * @return string
	 */
	private static function form_embed_html( $embed, $mode = 'dummy', $atts = array() ) {
		$embed = trim( (string) $embed );
		$mode  = in_array( $mode, array( 'dummy', 'embed' ), true ) ? $mode : 'dummy';

		if ( 'embed' !== $mode || '' === $embed ) {
			return self::fallback_form_html( $atts );
		}

		if ( function_exists( 'do_shortcode' ) ) {
			$embed = do_shortcode( $embed );
		}

		$embed = trim( (string) $embed );
		if ( '' === $embed ) {
			return self::fallback_form_html( $atts );
		}

		return wp_kses( $embed, self::allowed_form_embed_html() );
	}

	/**
	 * Renders the section.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'eyebrow'          => 'For businesses & gifting',
				'title'            => 'Curated Gifting & Bulk {Orders}',
				'accent'           => 'Orders',
				'description'      => 'Our clusters span some of the most biodiverse and culturally rich landscapes in the Indian Himalayas — from Ladakh to Kinnaur, Spiti to the Pir Panjal range.',
				'points'           => '',
				'button_text'      => 'Download gifting catalogue',
				'button_url'       => '#',
				'form_eyebrow'     => 'Start an enquiry',
				'form_title'       => 'Tell us what you need',
				'form_description' => 'Share your requirement for hampers, hospitality counters, retail placement, or institutional orders.',
				'form_mode'        => 'dummy',
				'form_embed'       => '',
				'first_name_label' => 'First Name',
				'last_name_label'  => 'Last Name',
				'email_label'      => 'Email Address',
				'enquiry_label'    => 'Type of Enquiry',
				'message_label'    => 'Your Message',
				'submit_label'     => 'Submit Enquiry →',
				'tone'             => 'green',
				'width'            => 'contained',
				'id'               => '',
				'class'            => '',
			),
			$atts,
			'amaley_gifting_enquiry_section'
		);

		$tone   = in_array( $atts['tone'], array( 'green', 'deep', 'cream' ), true ) ? $atts['tone'] : 'green';
		$width  = in_array( $atts['width'], array( 'contained', 'full' ), true ) ? $atts['width'] : 'contained';
		$extra  = Amaley_UI_Helpers::extra_classes( $atts['class'] );
		$points = self::normalise_points( $atts['points'] );

		$classes  = 'amaley-gifting-enquiry-section amaley-gifting-enquiry-section--' . $tone;
		$classes .= ' amaley-gifting-enquiry-section--' . $width;
		$classes .= '' !== $extra ? ' ' . $extra : '';
		$id_attr  = '' !== trim( $atts['id'] ) ? ' id="' . esc_attr( sanitize_title( $atts['id'] ) ) . '"' : '';

		$html  = '<section' . $id_attr . ' class="' . esc_attr( $classes ) . '">';
		$html .= '<div class="amaley-gifting-enquiry-section__inner">';
		$html .= '<div class="amaley-gifting-enquiry-section__grid">';
		$html .= '<div class="amaley-gifting-enquiry-section__content">';

		if ( '' !== trim( $atts['eyebrow'] ) ) {
			$html .= '<div class="amaley-gifting-enquiry-section__eyebrow">' . esc_html( $atts['eyebrow'] ) . '</div>';
		}

		if ( '' !== trim( $atts['title'] ) ) {
			$html .= '<h2 class="amaley-gifting-enquiry-section__title">' . self::title_html( $atts['title'], $atts['accent'] ) . '</h2>';
		}

		if ( '' !== trim( $atts['description'] ) ) {
			$html .= '<p class="amaley-gifting-enquiry-section__description">' . wp_kses_post( $atts['description'] ) . '</p>';
		}

		$html .= '<div class="amaley-gifting-enquiry-section__points">';
		foreach ( $points as $point ) {
			$html .= '<div class="amaley-gifting-enquiry-section__point">';
			if ( '' !== trim( $point['icon'] ) ) {
				$html .= '<span class="amaley-gifting-enquiry-section__point-icon" aria-hidden="true">' . esc_html( $point['icon'] ) . '</span>';
			}
			if ( '' !== trim( $point['text'] ) ) {
				$html .= '<span class="amaley-gifting-enquiry-section__point-text">' . esc_html( $point['text'] ) . '</span>';
			}
			$html .= '</div>';
		}
		$html .= '</div>';

		$html .= '<div class="amaley-gifting-enquiry-section__actions">';
		$html .= self::button_html( $atts['button_text'], $atts['button_url'] );
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<aside class="amaley-gifting-enquiry-section__form-card">';
		if ( '' !== trim( $atts['form_eyebrow'] ) ) {
			$html .= '<div class="amaley-gifting-enquiry-section__form-eyebrow">' . esc_html( $atts['form_eyebrow'] ) . '</div>';
		}
		if ( '' !== trim( $atts['form_title'] ) ) {
			$html .= '<h3 class="amaley-gifting-enquiry-section__form-title">' . esc_html( $atts['form_title'] ) . '</h3>';
		}
		if ( '' !== trim( $atts['form_description'] ) ) {
			$html .= '<p class="amaley-gifting-enquiry-section__form-description">' . wp_kses_post( $atts['form_description'] ) . '</p>';
		}
		$html .= '<div class="amaley-gifting-enquiry-section__form-embed">' . self::form_embed_html( $atts['form_embed'], $atts['form_mode'], $atts ) . '</div>';
		$html .= '</aside>';

		$html .= '</div>';
		$html .= '</div>';
		$html .= '</section>';

		return $html;
	}
}
