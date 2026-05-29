<?php
/**
 * Elementor widget: Amaley Origin Story Cards.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Origin_Cards_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_origin_cards'; }
	protected function renderer_method() { return 'origin_cards'; }
	protected function widget_title() { return esc_html__( 'Amaley Origin Story Cards', 'amaley-compact-widgets' ); }
}
