<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Collection_Topbar_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_de_collection_topbar_discovery'; }
    public function get_title() { return __('Amaley Collection Topbar Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'products'; }
    protected function get_default_heading() { return 'Shop by {Collection}'; }
    protected function get_default_kicker() { return 'Compact collection filter'; }
    protected function get_default_filter_position() { return 'top'; }
    protected function get_default_desktop_filter_position() { return 'top'; }
}
