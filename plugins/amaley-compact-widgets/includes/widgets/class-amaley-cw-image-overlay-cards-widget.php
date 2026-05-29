<?php
/**
 * Elementor widget: Amaley Image Overlay Cards.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Image_Overlay_Cards_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_image_overlay_cards'; }
	protected function renderer_method() { return 'image_overlay_cards'; }
	protected function widget_title() { return esc_html__( 'Amaley Image Overlay Cards', 'amaley-compact-widgets' ); }
}
