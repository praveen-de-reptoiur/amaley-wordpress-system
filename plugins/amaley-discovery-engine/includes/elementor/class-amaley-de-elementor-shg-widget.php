<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_SHG_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_de_shg_discovery'; }
    public function get_title() { return __('Amaley SHG Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'shgs'; }
    protected function get_default_heading() { return 'Explore {Producer Groups}'; }
    protected function get_default_kicker() { return 'Women collectives and SHGs'; }
    protected function get_default_filter_position() { return 'left'; }
    protected function get_default_desktop_filter_position() { return 'left'; }
}
