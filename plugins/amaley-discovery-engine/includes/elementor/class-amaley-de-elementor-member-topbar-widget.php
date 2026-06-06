<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Member_Topbar_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_de_member_topbar_discovery'; }
    public function get_title() { return __('Amaley Member Topbar Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'members'; }
    protected function get_default_heading() { return 'Meet the {Producers}'; }
    protected function get_default_kicker() { return 'Compact member filter'; }
    protected function get_default_filter_position() { return 'top'; }
    protected function get_default_desktop_filter_position() { return 'top'; }
}
