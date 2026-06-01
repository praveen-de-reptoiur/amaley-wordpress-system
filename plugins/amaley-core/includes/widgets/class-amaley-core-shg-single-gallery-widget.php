<?php
/** Amaley SHG Single Gallery Elementor widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Single_Gallery_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_SHG_Single_Widget_Controls;
    public function get_name() { return 'amaley_core_shg_single_gallery'; }
    public function get_title() { return esc_html__( 'Amaley SHG Single Gallery', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'single', 'gallery' ); }
    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_single_sections'] ) ? $GLOBALS['amaley_core_shg_single_sections'] : new Amaley_Core_SHG_Single_Sections();
        $this->add_shg_source_controls();
        $this->add_text_controls_from_defaults( 'content', 'Content / Display', $renderer->gallery_defaults(), array( 'shg_id', 'shg_slug', 'preview_shg_id', 'auto_detect', 'empty_message' ) );
        $this->add_shg_full_style_controls( 'gallery' );
    }
    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_single_sections'] ) ? $GLOBALS['amaley_core_shg_single_sections'] : new Amaley_Core_SHG_Single_Sections();
        echo $renderer->render_gallery( $this->get_settings_for_display() );
    }
}
