<?php
/** Elementor widget: Amaley Image Cards. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Amaley_CW_Base_Widget' ) ) { return; }

final class Amaley_CW_Image_Cards_Widget extends Amaley_CW_Base_Widget {
    protected function widget_key() { return 'amaley_cw_image_cards'; }
    protected function renderer_method() { return 'image_cards'; }
    protected function widget_title() { return esc_html__( 'Amaley Image Cards', 'amaley-compact-widgets' ); }
}
