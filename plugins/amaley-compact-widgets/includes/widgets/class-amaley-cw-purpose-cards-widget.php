<?php
/** Elementor widget: Amaley Purpose Cards. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Purpose_Cards_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_purpose_cards'; }
    protected function renderer_method() { return 'purpose_cards'; }
    protected function widget_title() { return esc_html__( 'Amaley Purpose Cards', 'amaley-compact-widgets' ); }
}
