<?php
if (!defined('ABSPATH')) { exit; }
class Amaley_DE_Elementor_Icon_List_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_icon_list'; }
    public function get_title(){ return __('Amaley Icon List', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-bullet-list'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    protected function register_controls(){ $this->start_controls_section('content', array('label'=>__('Content','amaley-discovery-engine'))); $this->add_control('items', array('label'=>__('Items, one per line','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>"Small-batch
Himalayan
Community-rooted")); $this->end_controls_section(); }
    protected function render(){ $s=$this->get_settings_for_display(); $items=preg_split('/\r?\n/', (string)$s['items']); echo '<ul class="amaley-de-icon-list">'; foreach($items as $item){ $item=trim($item); if($item!==''){ echo '<li>'.esc_html($item).'</li>'; } } echo '</ul>'; }
}
