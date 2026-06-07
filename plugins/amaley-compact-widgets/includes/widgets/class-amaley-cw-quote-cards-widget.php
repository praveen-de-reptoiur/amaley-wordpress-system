<?php
/** Elementor widget: Amaley Quote Cards. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Quote_Cards_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_quote_cards'; }
    protected function renderer_method() { return 'quote_cards'; }
    protected function widget_title() { return esc_html__( 'Amaley Quote Cards', 'amaley-compact-widgets' ); }
}
