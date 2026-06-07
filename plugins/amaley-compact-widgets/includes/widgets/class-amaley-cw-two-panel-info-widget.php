<?php
/** Elementor widget: Amaley Two Panel Info. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Two_Panel_Info_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_two_panel_info'; }
    protected function renderer_method() { return 'two_panel_info'; }
    protected function widget_title() { return esc_html__( 'Amaley Two Panel Info', 'amaley-compact-widgets' ); }
}
