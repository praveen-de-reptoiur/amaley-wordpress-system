<?php
/**
 * Elementor widget: Amaley Feature / Value Strip.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Value_Strip_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_value_strip'; }
	protected function renderer_method() { return 'value_strip'; }
	protected function widget_title() { return esc_html__( 'Amaley Feature / Value Strip', 'amaley-compact-widgets' ); }
}
