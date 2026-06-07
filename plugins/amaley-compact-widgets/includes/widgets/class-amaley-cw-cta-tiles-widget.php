<?php
/** Elementor widget: Amaley CTA Tiles. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Cta_Tiles_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_cta_tiles'; }
    protected function renderer_method() { return 'cta_tiles'; }
    protected function widget_title() { return esc_html__( 'Amaley CTA Tiles', 'amaley-compact-widgets' ); }
}
