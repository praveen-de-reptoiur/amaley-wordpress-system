<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Cluster_Topbar_Widget extends Amaley_DE_Elementor_Cluster_Widget {
    public function get_name() { return 'amaley_cluster_topbar_discovery'; }
    public function get_title() { return __('Amaley Cluster Topbar Discovery', 'amaley-discovery-engine'); }
    protected function get_default_filter_position() { return 'top'; }
    protected function get_default_desktop_filter_position() { return 'top'; }
    protected function get_default_tablet_filter_position() { return 'top'; }
    protected function get_default_mobile_filter_position() { return 'top'; }
    protected function get_default_desktop_filter_mode() { return 'visible'; }
    protected function get_default_tablet_filter_mode() { return 'compact'; }
    protected function get_default_mobile_filter_mode() { return 'compact'; }
    protected function get_default_custom_wrapper_class() { return 'amaley-de-topbar-preset'; }
}
