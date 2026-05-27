<?php
/**
 * Design token registry.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Holds Phase 1 design tokens in one place for documentation and future reuse.
 */
final class Amaley_UI_Token_Registry {

	/**
	 * Returns the locked Phase 1 color tokens.
	 *
	 * @return array<string,string>
	 */
	public static function colors() {
		return array(
			'deep_chocolate' => '#2E1203',
			'warm_chocolate' => '#4A2208',
			'ivory_base'     => '#FFF8ED',
			'warm_cream'     => '#F6EFE3',
			'soft_sand'      => '#EFE3D0',
			'muted_gold'     => '#C2880A',
			'rust_accent'    => '#B85C38',
			'leaf_green'     => '#6F7A3A',
			'text_brown'     => '#4A2208',
			'muted_text'     => '#7A6250',
			'border_warm'    => '#E5D7C2',
		);
	}
}
