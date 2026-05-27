<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Member_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_member_discovery'; }
    public function get_title() { return __('Amaley Member Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'members'; }
    protected function get_default_heading() { return 'Meet the {Makers}'; }
    protected function get_default_kicker() { return 'Producer Stories'; }
}
