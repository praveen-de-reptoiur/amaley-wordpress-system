<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Cluster_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_cluster_discovery'; }
    public function get_title() { return __('Amaley Cluster Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'clusters'; }
    protected function get_default_heading() { return 'Meet the {Clusters}'; }
    protected function get_default_kicker() { return 'Producer Ecosystem'; }
}
