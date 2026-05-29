<?php
/**
 * Elementor widget: Amaley Gifting / Bulk Band.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Gifting_Band_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_gifting_band'; }
	protected function renderer_method() { return 'gifting_band'; }
	protected function widget_title() { return esc_html__( 'Amaley Gifting / Bulk Band', 'amaley-compact-widgets' ); }
}
