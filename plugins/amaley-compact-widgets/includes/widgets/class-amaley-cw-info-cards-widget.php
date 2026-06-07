<?php
/** Elementor widget: Amaley Info Cards Grid. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Info_Cards_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_info_cards'; }
    protected function renderer_method() { return 'info_cards'; }
    protected function widget_title() { return esc_html__( 'Amaley Info Cards Grid', 'amaley-compact-widgets' ); }
}
