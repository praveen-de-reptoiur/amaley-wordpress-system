<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Heading_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_heading'; }
    public function get_title(){ return __('Amaley Heading', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-heading'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    protected function register_controls(){
        $this->start_controls_section('content', array('label'=>__('Content','amaley-discovery-engine')));
        $this->add_control('kicker', array('label'=>__('Kicker','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'Amaley'));
        $this->add_control('heading', array('label'=>__('Heading','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>'Community-rooted {Himalayan} products'));
        $this->end_controls_section();
    }
    protected function render(){ $s=$this->get_settings_for_display(); $h=wp_kses_post($s['heading']); $h=str_replace(array('{','}'),array('<span>','</span>'),$h); echo '<div class="amaley-discovery-engine-v1__heading-wrap"><div class="amaley-discovery-engine-v1__kicker">'.esc_html($s['kicker']).'</div><h2 class="amaley-discovery-engine-v1__heading">'.wp_kses($h,array('span'=>array())).'</h2></div>'; }
}
