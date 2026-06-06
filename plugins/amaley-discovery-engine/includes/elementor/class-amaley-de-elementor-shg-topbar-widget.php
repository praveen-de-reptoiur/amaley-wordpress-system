<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_SHG_Topbar_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_de_shg_topbar_discovery'; }
    public function get_title() { return __('Amaley SHG Topbar Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'shgs'; }
    protected function get_default_heading() { return 'Explore {Producer Groups}'; }
    protected function get_default_kicker() { return 'Compact SHG filter'; }
    protected function get_default_filter_position() { return 'top'; }
    protected function get_default_desktop_filter_position() { return 'top'; }
}
