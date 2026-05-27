<?php
/**
 * Elementor footer widget.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( class_exists( '\\Elementor\\Widget_Base' ) && ! class_exists( 'Amaley_Shell_Elementor_Footer_Widget' ) ) {
    class Amaley_Shell_Elementor_Footer_Widget extends \Elementor\Widget_Base {
        public function get_name() { return 'amaley_site_footer'; }
        public function get_title() { return 'Amaley Footer'; }
        public function get_icon() { return 'eicon-footer'; }
        public function get_categories() { return array( 'amaley-site-shell' ); }
        public function get_keywords() { return array( 'amaley', 'footer', 'site shell' ); }

        protected function register_controls() {
            $this->start_controls_section( 'content_section', array( 'label' => 'Amaley Footer' ) );
            $this->add_control(
                'note',
                array(
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw'  => 'This widget renders the global Amaley Site Shell footer. Edit content and styles from WordPress Admin → Amaley Site Shell.',
                )
            );
            $this->end_controls_section();
        }

        protected function render() {
            echo Amaley_Shell_Renderer::render_footer(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
