<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Collection_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_de_collection_discovery'; }
    public function get_title() { return __('Amaley Collection Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'products'; }
    protected function get_default_heading() { return 'Shop by {Collection}'; }
    protected function get_default_kicker() { return 'Curated product paths'; }
    protected function get_default_filter_position() { return 'left'; }
    protected function get_default_desktop_filter_position() { return 'left'; }
}
