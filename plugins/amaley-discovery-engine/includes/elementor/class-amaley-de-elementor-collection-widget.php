<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Collection_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_collection_discovery'; }
    public function get_title() { return __('Amaley Collection Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'collections'; }
    protected function get_default_heading() { return 'Our {Collections}'; }
    protected function get_default_kicker() { return 'Explore by Curation'; }
}
