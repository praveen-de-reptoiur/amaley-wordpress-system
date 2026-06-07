<?php
/** Elementor widget: Amaley Collection Cards. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Collection_Cards_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_collection_cards'; }
    protected function renderer_method() { return 'collection_cards'; }
    protected function widget_title() { return esc_html__( 'Amaley Collection Cards', 'amaley-compact-widgets' ); }
}
