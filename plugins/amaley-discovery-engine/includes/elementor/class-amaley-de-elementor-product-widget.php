<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Product_Widget extends Amaley_DE_Elementor_Base_Widget {
    public function get_name() { return 'amaley_product_discovery'; }
    public function get_title() { return __('Amaley Product Discovery', 'amaley-discovery-engine'); }
    protected function get_discovery_type() { return 'products'; }
    protected function get_default_heading() { return 'Our {Products}'; }
    protected function get_default_kicker() { return 'Shop Amaley'; }
}
