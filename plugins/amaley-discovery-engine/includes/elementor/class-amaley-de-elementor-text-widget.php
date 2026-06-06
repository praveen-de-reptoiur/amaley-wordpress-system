<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Text_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_text'; }
    public function get_title(){ return __('Amaley Text', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-text'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    protected function register_controls(){ $this->start_controls_section('content', array('label'=>__('Content','amaley-discovery-engine'))); $this->add_control('text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>'Add Amaley content here.')); $this->end_controls_section(); }
    protected function render(){ $s=$this->get_settings_for_display(); echo '<div class="amaley-de-text">'.wp_kses_post(wpautop($s['text'])).'</div>'; }
}
