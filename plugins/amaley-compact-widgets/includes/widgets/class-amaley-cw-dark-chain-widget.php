<?php
/** Elementor widget: Amaley Dark Chain Cards. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Dark_Chain_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_dark_chain'; }
    protected function renderer_method() { return 'dark_chain'; }
    protected function widget_title() { return esc_html__( 'Amaley Dark Chain Cards', 'amaley-compact-widgets' ); }
}
