<?php
/**
 * Elementor widget: Amaley Metric Tiles.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Metric_Tiles_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_metric_tiles'; }
	protected function renderer_method() { return 'metric_tiles'; }
	protected function widget_title() { return esc_html__( 'Amaley Metric Tiles', 'amaley-compact-widgets' ); }
}
