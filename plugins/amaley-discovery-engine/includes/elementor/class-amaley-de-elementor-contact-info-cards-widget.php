<?php
if (!defined('ABSPATH')) { exit; }

class Amaley_DE_Elementor_Contact_Info_Cards_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_contact_info_cards'; }
    public function get_title(){ return __('Amaley Contact Info Cards', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-info-box'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    public function get_keywords(){ return array('amaley','contact','cards','info','phone','email'); }
    public function get_style_depends(){ if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }

    protected function register_controls(){ $this->register_content_controls(); $this->register_style_controls(); $this->register_advanced_visibility_controls(); }
    private function switcher($label, $default='yes', $condition=array()){
        $args = array('label'=>$label, 'type'=>\Elementor\Controls_Manager::SWITCHER, 'label_on'=>__('Show','amaley-discovery-engine'), 'label_off'=>__('Hide','amaley-discovery-engine'), 'return_value'=>'yes', 'default'=>$default);
        if ($condition) { $args['condition']=$condition; }
        return $args;
    }
    private function css_color($prop){ return $prop . ': {{VALUE}};'; }

    private function register_content_controls(){
        $this->start_controls_section('content_header', array('label'=>__('Section Heading', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_header', $this->switcher(__('Mini Heading Block', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_kicker', $this->switcher(__('Kicker', 'amaley-discovery-engine'), 'yes', array('show_header'=>'yes')));
        $this->add_control('kicker', array('label'=>__('Kicker Text', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Reach Us', 'amaley-discovery-engine'), 'condition'=>array('show_header'=>'yes','show_kicker'=>'yes')));
        $this->add_control('show_heading', $this->switcher(__('Heading', 'amaley-discovery-engine'), 'yes', array('show_header'=>'yes')));
        $this->add_control('heading', array('label'=>__('Heading', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Choose the right contact path.', 'amaley-discovery-engine'), 'label_block'=>true, 'condition'=>array('show_header'=>'yes','show_heading'=>'yes')));
        $this->add_control('show_description', $this->switcher(__('Description', 'amaley-discovery-engine'), 'yes', array('show_header'=>'yes')));
        $this->add_control('description', array('label'=>__('Description', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('For product questions, bulk enquiries, collaboration or community sourcing updates, connect through the most relevant channel.', 'amaley-discovery-engine'), 'condition'=>array('show_header'=>'yes','show_description'=>'yes')));
        $this->end_controls_section();

        $this->start_controls_section('content_cards', array('label'=>__('Contact Cards', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_CONTENT));
        $rep = new \Elementor\Repeater();
        $rep->add_control('show_card', array('label'=>__('Show Card', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'yes'));
        $rep->add_control('show_icon', array('label'=>__('Show Icon', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'yes'));
        $rep->add_control('icon', array('label'=>__('Icon', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::ICONS, 'default'=>array('value'=>'fas fa-phone','library'=>'fa-solid'), 'condition'=>array('show_icon'=>'yes')));
        $rep->add_control('title', array('label'=>__('Title', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Call / WhatsApp', 'amaley-discovery-engine'), 'label_block'=>true));
        $rep->add_control('description', array('label'=>__('Description', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('For order support and quick enquiries.', 'amaley-discovery-engine')));
        $rep->add_control('value', array('label'=>__('Primary Contact Value', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('+91 XXXXX XXXXX', 'amaley-discovery-engine'), 'label_block'=>true));
        $rep->add_control('value_lines', array('label'=>__('Multiple Contact Lines', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'rows'=>4, 'placeholder'=>__('Add one phone / email / address per line. If empty, Primary Contact Value is used.', 'amaley-discovery-engine')));
        $rep->add_control('auto_link_values', array('label'=>__('Auto Link Phone / Email / URL', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'yes'));
        $rep->add_control('show_button', array('label'=>__('Show Button', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'yes'));
        $rep->add_control('button_text', array('label'=>__('Button Text', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Contact Now', 'amaley-discovery-engine'), 'condition'=>array('show_button'=>'yes')));
        $rep->add_control('button_link', array('label'=>__('Button Link', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::URL, 'condition'=>array('show_button'=>'yes')));
        $this->add_control('cards', array(
            'label'=>__('Cards', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::REPEATER, 'fields'=>$rep->get_controls(),
            'default'=>array(
                array('title'=>__('Call / WhatsApp','amaley-discovery-engine'), 'description'=>__('For orders, delivery, and quick support.','amaley-discovery-engine'), 'value'=>__('+91 XXXXX XXXXX','amaley-discovery-engine'), 'value_lines'=>__('+91 XXXXX XXXXX\n+91 XXXXX XXXXX','amaley-discovery-engine'), 'button_text'=>__('Call Now','amaley-discovery-engine'), 'show_card'=>'yes','show_icon'=>'yes','show_button'=>'yes','auto_link_values'=>'yes'),
                array('title'=>__('Email','amaley-discovery-engine'), 'description'=>__('For formal queries, partnerships, and documents.','amaley-discovery-engine'), 'value'=>__('hello@amaley.in','amaley-discovery-engine'), 'value_lines'=>__('hello@amaley.in\norders@amaley.in','amaley-discovery-engine'), 'button_text'=>__('Send Email','amaley-discovery-engine'), 'show_card'=>'yes','show_icon'=>'yes','show_button'=>'yes','auto_link_values'=>'yes'),
                array('title'=>__('Bulk / Gifting','amaley-discovery-engine'), 'description'=>__('Corporate hampers, events, properties, and stores.','amaley-discovery-engine'), 'value'=>__('Custom enquiry','amaley-discovery-engine'), 'value_lines'=>__('Custom enquiry\nCorporate gifting\nStore counters','amaley-discovery-engine'), 'button_text'=>__('Request Quote','amaley-discovery-engine'), 'show_card'=>'yes','show_icon'=>'yes','show_button'=>'yes','auto_link_values'=>'yes'),
            ), 'title_field'=>'{{{ title }}}'
        ));
        $this->add_control('show_card_titles', $this->switcher(__('Card Titles', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_card_descriptions', $this->switcher(__('Card Descriptions', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_card_values', $this->switcher(__('Card Values', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_card_buttons', $this->switcher(__('Card Buttons', 'amaley-discovery-engine'), 'yes'));
        $this->end_controls_section();
    }

    private function register_style_controls(){
        $root = '{{WRAPPER}} .amaley-de-contact-cards';
        $inner = $root.' .amaley-de-contact-cards__inner';
        $header = $root.' .amaley-de-contact-cards__header';
        $grid = $root.' .amaley-de-contact-cards__grid';
        $card = $root.' .amaley-de-contact-card';
        $button = $root.' .amaley-de-contact-card__button';
        $this->start_controls_section('style_section_layout', array('label'=>__('Section / Layout', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('section_layout_tabs');
        $this->start_controls_tab('section_tab', array('label'=>__('Section', 'amaley-discovery-engine')));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array('name'=>'section_bg_group', 'selector'=>$root));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'section_border', 'selector'=>$root));
        $this->add_responsive_control('section_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('section_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('layout_tab', array('label'=>__('Layout', 'amaley-discovery-engine')));
        $this->add_responsive_control('inner_max_width', array('label'=>__('Inner Max Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>320,'max'=>1600), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($inner=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('section_gap', array('label'=>__('Header/Grid Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>100)), 'selectors'=>array($inner=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('columns', array('label'=>__('Columns','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::NUMBER, 'min'=>1, 'max'=>6, 'step'=>1, 'default'=>3, 'tablet_default'=>2, 'mobile_default'=>1, 'selectors'=>array($grid=>'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));')));
        $this->add_responsive_control('grid_gap', array('label'=>__('Card Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($grid=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('header_max_width', array('label'=>__('Header Max Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>220,'max'=>1000), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($header=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('header_text_align', array('label'=>__('Header Text Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('left'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-text-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-text-align-center'), 'right'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-text-align-right')), 'selectors'=>array($header=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('card_text_align', array('label'=>__('Card Text Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('left'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-text-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-text-align-center'), 'right'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-text-align-right')), 'selectors'=>array($card=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('card_element_align', array('label'=>__('Card Element Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'), 'stretch'=>array('title'=>__('Stretch','amaley-discovery-engine'),'icon'=>'eicon-h-align-stretch')), 'selectors'=>array($card=>'align-items: {{VALUE}};')));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_header', array('label'=>__('Heading Text', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('header_text_tabs');
        foreach (array('kicker'=>__('Kicker','amaley-discovery-engine'), 'heading'=>__('Heading','amaley-discovery-engine'), 'description'=>__('Description','amaley-discovery-engine')) as $key=>$label) {
            $this->start_controls_tab('header_'.$key.'_tab', array('label'=>$label));
            $this->add_control($key.'_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-cards__'.$key=>$this->css_color('color'))));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>$key.'_typography', 'selector'=>$root.' .amaley-de-contact-cards__'.$key));
            $this->add_responsive_control($key.'_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($root.' .amaley-de-contact-cards__'.$key=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_card', array('label'=>__('Card Box', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('card_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($card=>$this->css_color('background-color'))));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'card_border', 'selector'=>$card));
        $this->add_responsive_control('card_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($card=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('card_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($card=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('card_inner_gap', array('label'=>__('Inner Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>60)), 'selectors'=>array($card=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('card_min_height', array('label'=>__('Min Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>500)), 'selectors'=>array($card=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'card_shadow', 'selector'=>$card));
        $this->end_controls_section();

        $this->start_controls_section('style_card_elements', array('label'=>__('Card Elements', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('card_elements_tabs');
        $this->start_controls_tab('icon_tab', array('label'=>__('Icon','amaley-discovery-engine')));
        $this->add_responsive_control('icon_size', array('label'=>__('Size','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>10,'max'=>80)), 'selectors'=>array($root.' .amaley-de-contact-card__icon'=>'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
        $this->add_control('icon_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-card__icon'=>$this->css_color('color'))));
        $this->add_control('icon_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-card__icon'=>$this->css_color('background-color'))));
        $this->add_responsive_control('icon_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($root.' .amaley-de-contact-card__icon'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        foreach (array('title'=>__('Title','amaley-discovery-engine'), 'description'=>__('Description','amaley-discovery-engine'), 'value'=>__('Value','amaley-discovery-engine')) as $key=>$label) {
            $this->start_controls_tab('card_'.$key.'_tab', array('label'=>$label));
            $this->add_control('card_'.$key.'_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-card__'.$key=>$this->css_color('color'))));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'card_'.$key.'_typography', 'selector'=>$root.' .amaley-de-contact-card__'.$key));
            $this->add_responsive_control('card_'.$key.'_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'selectors'=>array($root.' .amaley-de-contact-card__'.$key=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            if ('value' === $key) {
                $this->add_responsive_control('card_value_line_gap', array('label'=>__('Value Line Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>24)), 'selectors'=>array($root.' .amaley-de-contact-card__value'=>'gap: {{SIZE}}{{UNIT}};')));
            }
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_button', array('label'=>__('Card Button', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('button_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($button=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($button=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'button_typography', 'selector'=>$button));
        $this->start_controls_tabs('button_tabs');
        $this->start_controls_tab('button_normal', array('label'=>__('Normal','amaley-discovery-engine')));
        $this->add_control('button_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('background-color'))));
        $this->add_control('button_text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('color'))));
        $this->add_control('button_border', array('label'=>__('Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->start_controls_tab('button_hover', array('label'=>__('Hover','amaley-discovery-engine')));
        $this->add_control('button_hover_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('background-color'))));
        $this->add_control('button_hover_text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('color'))));
        $this->add_control('button_hover_border', array('label'=>__('Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'button_shadow', 'selector'=>$button));
        $this->end_controls_section();
    }

    private function register_advanced_visibility_controls(){
        $this->start_controls_section('advanced_visibility', array('label'=>__('Visibility / Responsive Layout', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_ADVANCED));
        $this->start_controls_tabs('visibility_tabs');
        foreach (array('desktop'=>__('Desktop','amaley-discovery-engine'), 'tablet'=>__('Tablet','amaley-discovery-engine'), 'mobile'=>__('Mobile','amaley-discovery-engine')) as $device=>$label) {
            $this->start_controls_tab('vis_'.$device, array('label'=>$label));
            foreach (array('whole'=>'Whole Section','header'=>'Header','kicker'=>'Kicker','heading'=>'Heading','description'=>'Header Description','grid'=>'Cards Grid','icons'=>'Card Icons','titles'=>'Card Titles','card_descriptions'=>'Card Descriptions','values'=>'Card Values','buttons'=>'Card Buttons') as $key=>$label2) {
                $this->add_control('hide_'.$key.'_'.$device, array('label'=>sprintf(__('Hide %s','amaley-discovery-engine'), __($label2,'amaley-discovery-engine')), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'no'));
            }
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function is_show($s,$key){ return isset($s[$key]) && 'yes' === $s[$key]; }
    private function hide_classes($s,$key){ $c=array(); foreach(array('desktop','tablet','mobile') as $d){ if(!empty($s['hide_'.$key.'_'.$d]) && 'yes'===$s['hide_'.$key.'_'.$d]) $c[]='amaley-de-hide-'.$d; } return implode(' ', $c); }
    private function link_attrs($url,$class){ $attrs='class="'.esc_attr($class).'"'; if(!empty($url['url'])){ $attrs.=' href="'.esc_url($url['url']).'"'; if(!empty($url['is_external'])) $attrs.=' target="_blank"'; if(!empty($url['nofollow'])) $attrs.=' rel="nofollow"'; } else { $attrs.=' href="#"'; } return $attrs; }


    private function contact_lines($card){
        $raw = '';
        if (!empty($card['value_lines'])) {
            $raw = $card['value_lines'];
        } elseif (!empty($card['value'])) {
            $raw = $card['value'];
        }
        $lines = preg_split('/\r\n|\r|\n/', (string) $raw);
        $clean = array();
        foreach ($lines as $line) {
            $line = trim(wp_strip_all_tags($line));
            if ('' !== $line) { $clean[] = $line; }
        }
        return $clean;
    }
    private function contact_href($line){
        $line = trim((string) $line);
        if (is_email($line)) { return 'mailto:' . sanitize_email($line); }
        if (preg_match('/^https?:\/\//i', $line)) { return esc_url_raw($line); }
        $phone = preg_replace('/[^0-9+]/', '', $line);
        if (preg_match('/^[+0-9][0-9+]{6,}$/', $phone)) { return 'tel:' . $phone; }
        return '';
    }
    private function render_contact_value_line($line, $auto_link){
        $href = ('yes' === $auto_link) ? $this->contact_href($line) : '';
        if ($href) {
            return '<a href="' . esc_url($href) . '">' . esc_html($line) . '</a>';
        }
        return '<span>' . esc_html($line) . '</span>';
    }

    protected function render(){
        if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->enqueue_frontend_assets(); }
        $s=$this->get_settings_for_display();
        ?>
        <section class="amaley-de-contact-cards <?php echo esc_attr($this->hide_classes($s,'whole')); ?>">
            <div class="amaley-de-contact-cards__inner">
                <?php if($this->is_show($s,'show_header')): ?>
                    <header class="amaley-de-contact-cards__header <?php echo esc_attr($this->hide_classes($s,'header')); ?>">
                        <?php if($this->is_show($s,'show_kicker') && !empty($s['kicker'])): ?><div class="amaley-de-contact-cards__kicker <?php echo esc_attr($this->hide_classes($s,'kicker')); ?>"><?php echo esc_html($s['kicker']); ?></div><?php endif; ?>
                        <?php if($this->is_show($s,'show_heading') && !empty($s['heading'])): ?><h2 class="amaley-de-contact-cards__heading <?php echo esc_attr($this->hide_classes($s,'heading')); ?>"><?php echo esc_html($s['heading']); ?></h2><?php endif; ?>
                        <?php if($this->is_show($s,'show_description') && !empty($s['description'])): ?><p class="amaley-de-contact-cards__description <?php echo esc_attr($this->hide_classes($s,'description')); ?>"><?php echo esc_html($s['description']); ?></p><?php endif; ?>
                    </header>
                <?php endif; ?>
                <?php if(!empty($s['cards']) && is_array($s['cards'])): ?>
                    <div class="amaley-de-contact-cards__grid <?php echo esc_attr($this->hide_classes($s,'grid')); ?>">
                        <?php foreach($s['cards'] as $card): if(empty($card['show_card']) || 'yes' !== $card['show_card']) continue; ?>
                            <article class="amaley-de-contact-card">
                                <?php if(!empty($card['show_icon']) && 'yes'===$card['show_icon']): ?><span class="amaley-de-contact-card__icon <?php echo esc_attr($this->hide_classes($s,'icons')); ?>"><?php \Elementor\Icons_Manager::render_icon($card['icon'], array('aria-hidden'=>'true')); ?></span><?php endif; ?>
                                <?php if($this->is_show($s,'show_card_titles') && !empty($card['title'])): ?><h3 class="amaley-de-contact-card__title <?php echo esc_attr($this->hide_classes($s,'titles')); ?>"><?php echo esc_html($card['title']); ?></h3><?php endif; ?>
                                <?php if($this->is_show($s,'show_card_descriptions') && !empty($card['description'])): ?><p class="amaley-de-contact-card__description <?php echo esc_attr($this->hide_classes($s,'card_descriptions')); ?>"><?php echo esc_html($card['description']); ?></p><?php endif; ?>
                                <?php $contact_lines = $this->contact_lines($card); if($this->is_show($s,'show_card_values') && !empty($contact_lines)): ?><div class="amaley-de-contact-card__value <?php echo esc_attr($this->hide_classes($s,'values')); ?>"><?php foreach($contact_lines as $contact_line): ?><div class="amaley-de-contact-card__value-line"><?php echo $this->render_contact_value_line($contact_line, !empty($card['auto_link_values']) ? $card['auto_link_values'] : 'yes'); ?></div><?php endforeach; ?></div><?php endif; ?>
                                <?php if($this->is_show($s,'show_card_buttons') && !empty($card['show_button']) && 'yes'===$card['show_button'] && !empty($card['button_text'])): ?><a <?php echo $this->link_attrs($card['button_link'], 'amaley-de-contact-card__button '.$this->hide_classes($s,'buttons')); ?>><?php echo esc_html($card['button_text']); ?></a><?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
