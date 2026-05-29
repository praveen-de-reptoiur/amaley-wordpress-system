<?php
/**
 * Elementor widget: Amaley Traceability Journey.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Traceability_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_traceability'; }
	protected function renderer_method() { return 'traceability'; }
	protected function widget_title() { return esc_html__( 'Amaley Traceability Journey', 'amaley-compact-widgets' ); }
}
