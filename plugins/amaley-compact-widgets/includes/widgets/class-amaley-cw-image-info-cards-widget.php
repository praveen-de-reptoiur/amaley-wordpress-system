<?php
/**
 * Elementor widget: Amaley Image Info Cards.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Image_Info_Cards_Widget extends Amaley_CW_Base_Widget {
	protected function widget_key() { return 'amaley_cw_image_info_cards'; }
	protected function renderer_method() { return 'image_info_cards'; }
	protected function widget_title() { return esc_html__( 'Amaley Image Info Cards', 'amaley-compact-widgets' ); }
}
