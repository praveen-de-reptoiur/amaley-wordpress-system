<?php
/** Elementor widget: Amaley Split Editorial. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Split_Editorial_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_split_editorial'; }
    protected function renderer_method() { return 'split_editorial'; }
    protected function widget_title() { return esc_html__( 'Amaley Split Editorial', 'amaley-compact-widgets' ); }
}
