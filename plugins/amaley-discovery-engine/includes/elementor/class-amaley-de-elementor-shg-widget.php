<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_SHG_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_shg_discovery'; }
    public function get_title() { return __('Amaley SHG Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'shgs'; }
    protected function get_default_heading() { return 'Women-led {SHGs}'; }
    protected function get_default_kicker() { return 'Community Enterprise'; }
}
