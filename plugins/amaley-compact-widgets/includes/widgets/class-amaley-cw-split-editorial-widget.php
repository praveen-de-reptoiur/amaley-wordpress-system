<?php
/**
 * Elementor widget: Amaley Split Editorial Section.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Split_Editorial_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_split_editorial'; }
	protected function renderer_method() { return 'split_editorial'; }
	protected function widget_title() { return esc_html__( 'Amaley Split Editorial Section', 'amaley-compact-widgets' ); }
}
