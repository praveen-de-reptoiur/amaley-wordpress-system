<?php
/**
 * Elementor widget: Amaley Process Steps.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Process_Steps_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_process_steps'; }
	protected function renderer_method() { return 'process_steps'; }
	protected function widget_title() { return esc_html__( 'Amaley Process Steps', 'amaley-compact-widgets' ); }
}
