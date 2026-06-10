<?php
if (!defined('ABSPATH')) { exit; }

class Amaley_DE_Elementor_Contact_Map_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_contact_map'; }
    public function get_title(){ return __('Amaley Contact Map Section', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-google-maps'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    public function get_keywords(){ return array('amaley','contact','map','location','google'); }
    public function get_style_depends(){ if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }

    protected function register_controls(){ $this->register_content_controls(); $this->register_style_controls(); $this->register_advanced_visibility_controls(); }
    private function switcher($label,$default='yes',$condition=array()){ $args=array('label'=>$label,'type'=>\Elementor\Controls_Manager::SWITCHER,'label_on'=>__('Show','amaley-discovery-engine'),'label_off'=>__('Hide','amaley-discovery-engine'),'return_value'=>'yes','default'=>$default); if($condition){$args['condition']=$condition;} return $args; }
    private function css_color($prop){ return $prop . ': {{VALUE}};'; }

    private function register_content_controls(){
        $this->start_controls_section('content_panel', array('label'=>__('Content Panel', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_content_panel', $this->switcher(__('Content Panel','amaley-discovery-engine'), 'yes'));
        $this->add_control('show_kicker', $this->switcher(__('Kicker','amaley-discovery-engine'), 'yes', array('show_content_panel'=>'yes')));
        $this->add_control('kicker', array('label'=>__('Kicker Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Location','amaley-discovery-engine'), 'condition'=>array('show_content_panel'=>'yes','show_kicker'=>'yes')));
        $this->add_control('show_heading', $this->switcher(__('Heading','amaley-discovery-engine'), 'yes', array('show_content_panel'=>'yes')));
        $this->add_control('heading', array('label'=>__('Heading','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('Rooted in Leh, reaching homes everywhere.','amaley-discovery-engine'), 'condition'=>array('show_content_panel'=>'yes','show_heading'=>'yes')));
        $this->add_control('show_description', $this->switcher(__('Description','amaley-discovery-engine'), 'yes', array('show_content_panel'=>'yes')));
        $this->add_control('description', array('label'=>__('Description','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('Use this section to place your Google Map widget or embed. Keep the map wide and clean, with contact details visible alongside it.','amaley-discovery-engine'), 'condition'=>array('show_content_panel'=>'yes','show_description'=>'yes')));
        $this->add_control('show_address', $this->switcher(__('Address','amaley-discovery-engine'), 'no', array('show_content_panel'=>'yes')));
        $this->add_control('address', array('label'=>__('Address','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('Leh, Ladakh','amaley-discovery-engine'), 'condition'=>array('show_content_panel'=>'yes','show_address'=>'yes')));
        $this->add_control('show_phone', $this->switcher(__('Phone','amaley-discovery-engine'), 'no', array('show_content_panel'=>'yes')));
        $this->add_control('phone', array('label'=>__('Phone','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'rows'=>3, 'default'=>__('+91 XXXXX XXXXX','amaley-discovery-engine'), 'condition'=>array('show_content_panel'=>'yes','show_phone'=>'yes')));
        $this->add_control('show_email', $this->switcher(__('Email','amaley-discovery-engine'), 'no', array('show_content_panel'=>'yes')));
        $this->add_control('email', array('label'=>__('Email','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'rows'=>3, 'default'=>__('hello@amaley.in','amaley-discovery-engine'), 'condition'=>array('show_content_panel'=>'yes','show_email'=>'yes')));
        $this->add_control('show_button', $this->switcher(__('Button','amaley-discovery-engine'), 'yes', array('show_content_panel'=>'yes')));
        $this->add_control('button_text', array('label'=>__('Button Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Open Map','amaley-discovery-engine'), 'condition'=>array('show_content_panel'=>'yes','show_button'=>'yes')));
        $this->add_control('button_link', array('label'=>__('Button Link','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::URL, 'condition'=>array('show_content_panel'=>'yes','show_button'=>'yes')));
        $this->end_controls_section();

        $this->start_controls_section('content_map', array('label'=>__('Map Panel', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_map_panel', $this->switcher(__('Map Panel','amaley-discovery-engine'), 'yes'));
        $this->add_control('map_source', array('label'=>__('Map Source','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SELECT, 'default'=>'address', 'options'=>array('address'=>__('Address Auto Map','amaley-discovery-engine'), 'iframe'=>__('Google Embed Iframe','amaley-discovery-engine'), 'image'=>__('Image Fallback','amaley-discovery-engine'), 'shortcode'=>__('Shortcode','amaley-discovery-engine')), 'condition'=>array('show_map_panel'=>'yes')));
        $this->add_control('map_address', array('label'=>__('Map Address / Search Query','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'rows'=>3, 'default'=>__('Leh Palace Road, Leh, Ladakh 194101','amaley-discovery-engine'), 'placeholder'=>__('Enter address, landmark, or Google Maps search query','amaley-discovery-engine'), 'condition'=>array('show_map_panel'=>'yes','map_source'=>'address')));
        $this->add_control('map_zoom', array('label'=>__('Map Zoom','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>3,'max'=>18,'step'=>1)), 'default'=>array('size'=>13), 'condition'=>array('show_map_panel'=>'yes','map_source'=>'address')));
        $this->add_control('map_iframe', array('label'=>__('Google Map Iframe','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'rows'=>6, 'placeholder'=>'<iframe src="https://www.google.com/maps/embed?..." ...></iframe>', 'condition'=>array('show_map_panel'=>'yes','map_source'=>'iframe')));
        $this->add_control('map_image', array('label'=>__('Fallback Image','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::MEDIA, 'condition'=>array('show_map_panel'=>'yes','map_source'=>'image')));
        $this->add_control('map_shortcode', array('label'=>__('Shortcode','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'placeholder'=>'[your_map_shortcode]', 'condition'=>array('show_map_panel'=>'yes','map_source'=>'shortcode')));
        $this->add_control('fallback_text', array('label'=>__('Fallback Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Map embed goes here','amaley-discovery-engine'), 'condition'=>array('show_map_panel'=>'yes')));
        $this->end_controls_section();
    }

    private function register_style_controls(){
        $root='{{WRAPPER}} .amaley-de-contact-map';
        $inner=$root.' .amaley-de-contact-map__inner';
        $panel=$root.' .amaley-de-contact-map__panel';
        $map=$root.' .amaley-de-contact-map__map';
        $button=$root.' .amaley-de-contact-map__button';
        $details=$root.' .amaley-de-contact-map__details';
        $this->start_controls_section('style_layout', array('label'=>__('Section / Layout','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('layout_tabs');
        $this->start_controls_tab('section_tab', array('label'=>__('Section','amaley-discovery-engine')));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array('name'=>'section_background', 'selector'=>$root));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'section_border', 'selector'=>$root));
        $this->add_responsive_control('section_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('section_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('layout_tab', array('label'=>__('Layout','amaley-discovery-engine')));
        $this->add_responsive_control('inner_max_width', array('label'=>__('Inner Max Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>320,'max'=>1700), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($inner=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_control('desktop_ratio', array('label'=>__('Desktop Column Ratio','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SELECT, 'default'=>'40-60', 'options'=>array('35-65'=>'35 / 65', '40-60'=>'40 / 60', '50-50'=>'50 / 50', '60-40'=>'60 / 40'), 'selectors'=>array($inner=>'--amaley-contact-map-grid: {{VALUE}};')));
        $this->add_responsive_control('column_gap', array('label'=>__('Column Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>100)), 'selectors'=>array($inner=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('mobile_order', array('label'=>__('Mobile Order','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SELECT, 'default'=>'content-first', 'options'=>array('content-first'=>__('Content First','amaley-discovery-engine'), 'map-first'=>__('Map First','amaley-discovery-engine')), 'prefix_class'=>'amaley-de-contact-map-mobile-order-'));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_panel', array('label'=>__('Content Panel','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('panel_tabs');
        $this->start_controls_tab('panel_box_tab', array('label'=>__('Box','amaley-discovery-engine')));
        $this->add_control('panel_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($panel=>$this->css_color('background-color'))));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'panel_border', 'selector'=>$panel));
        $this->add_responsive_control('panel_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($panel=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('panel_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($panel=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('panel_min_height', array('label'=>__('Min Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>800)), 'selectors'=>array($panel=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('panel_gap', array('label'=>__('Inner Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($panel=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('panel_text_align', array('label'=>__('Text Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('left'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-text-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-text-align-center'), 'right'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-text-align-right')), 'selectors'=>array($panel=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('panel_element_align', array('label'=>__('Element Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'), 'stretch'=>array('title'=>__('Stretch','amaley-discovery-engine'),'icon'=>'eicon-h-align-stretch')), 'selectors'=>array($panel=>'align-items: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'panel_shadow', 'selector'=>$panel));
        $this->end_controls_tab();
        foreach(array('kicker'=>__('Kicker','amaley-discovery-engine'), 'heading'=>__('Heading','amaley-discovery-engine'), 'description'=>__('Description','amaley-discovery-engine')) as $key=>$label){
            $this->start_controls_tab('panel_'.$key.'_tab', array('label'=>$label));
            $this->add_control($key.'_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-map__'.$key=>$this->css_color('color'))));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>$key.'_typography', 'selector'=>$root.' .amaley-de-contact-map__'.$key));
            $this->add_responsive_control($key.'_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($root.' .amaley-de-contact-map__'.$key=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_details_button', array('label'=>__('Details & Button','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('details_button_tabs');
        $this->start_controls_tab('details_tab', array('label'=>__('Details','amaley-discovery-engine')));
        $this->add_responsive_control('details_gap', array('label'=>__('Row Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>50)), 'selectors'=>array($details=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('details_label_color', array('label'=>__('Label Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-map__detail-label'=>$this->css_color('color'))));
        $this->add_control('details_value_color', array('label'=>__('Value Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-map__detail-value'=>$this->css_color('color'))));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'details_typography', 'selector'=>$details));
        $this->end_controls_tab();
        $this->start_controls_tab('button_normal_tab', array('label'=>__('Button Normal','amaley-discovery-engine')));
        $this->add_control('button_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('background-color'))));
        $this->add_control('button_text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('color'))));
        $this->add_control('button_border', array('label'=>__('Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->start_controls_tab('button_hover_tab', array('label'=>__('Button Hover','amaley-discovery-engine')));
        $this->add_control('button_hover_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('background-color'))));
        $this->add_control('button_hover_text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('color'))));
        $this->add_control('button_hover_border', array('label'=>__('Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control('button_padding', array('label'=>__('Button Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($button=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_radius', array('label'=>__('Button Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($button=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_align', array('label'=>__('Button Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'), 'stretch'=>array('title'=>__('Stretch','amaley-discovery-engine'),'icon'=>'eicon-h-align-stretch')), 'selectors_dictionary'=>array('flex-start'=>'align-self:flex-start;', 'center'=>'align-self:center;', 'flex-end'=>'align-self:flex-end;', 'stretch'=>'align-self:stretch; width:100%;'), 'selectors'=>array($button=>'{{VALUE}}')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'button_typography', 'selector'=>$button));
        $this->end_controls_section();

        $this->start_controls_section('style_map', array('label'=>__('Map Panel','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('map_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($map=>$this->css_color('background-color'))));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'map_border', 'selector'=>$map));
        $this->add_responsive_control('map_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($map=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('map_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($map=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('map_height', array('label'=>__('Map Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>180,'max'=>900)), 'selectors'=>array($map.' iframe, '.$map.' img, '.$map.' .amaley-de-contact-map__placeholder'=>'height: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('map_opacity', array('label'=>__('Map Opacity','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>1,'step'=>0.01)), 'selectors'=>array($map.' iframe, '.$map.' img'=>'opacity: {{SIZE}};')));
        $this->add_control('map_grayscale', array('label'=>__('Grayscale %','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>100)), 'selectors'=>array($map.' iframe, '.$map.' img'=>'filter: grayscale({{SIZE}}%);')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'map_shadow', 'selector'=>$map));
        $this->end_controls_section();
    }

    private function register_advanced_visibility_controls(){
        $this->start_controls_section('advanced_visibility', array('label'=>__('Visibility / Responsive Layout','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_ADVANCED));
        $this->start_controls_tabs('visibility_tabs');
        foreach(array('desktop'=>__('Desktop','amaley-discovery-engine'), 'tablet'=>__('Tablet','amaley-discovery-engine'), 'mobile'=>__('Mobile','amaley-discovery-engine')) as $d=>$label){
            $this->start_controls_tab('vis_'.$d, array('label'=>$label));
            foreach(array('whole'=>'Whole Section','content_panel'=>'Content Panel','kicker'=>'Kicker','heading'=>'Heading','description'=>'Description','details'=>'Contact Details','button'=>'Button','map_panel'=>'Map Panel') as $key=>$label2){
                $this->add_control('hide_'.$key.'_'.$d, array('label'=>sprintf(__('Hide %s','amaley-discovery-engine'), __($label2,'amaley-discovery-engine')), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'no'));
            }
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function is_show($s,$key){ return isset($s[$key]) && 'yes' === $s[$key]; }
    private function hide_classes($s,$key){ $c=array(); foreach(array('desktop','tablet','mobile') as $d){ if(!empty($s['hide_'.$key.'_'.$d]) && 'yes'===$s['hide_'.$key.'_'.$d]) $c[]='amaley-de-hide-'.$d; } return implode(' ', $c); }
    private function link_attrs($url,$class){ $attrs='class="'.esc_attr($class).'"'; if(!empty($url['url'])){ $attrs.=' href="'.esc_url($url['url']).'"'; if(!empty($url['is_external'])) $attrs.=' target="_blank"'; if(!empty($url['nofollow'])) $attrs.=' rel="nofollow"'; } else { $attrs.=' href="#"'; } return $attrs; }
    private function allowed_iframe(){ return array('iframe'=>array('src'=>true,'width'=>true,'height'=>true,'style'=>true,'allowfullscreen'=>true,'loading'=>true,'referrerpolicy'=>true,'aria-label'=>true,'title'=>true,'frameborder'=>true)); }
    private function ratio_class($ratio){ return 'ratio-'.sanitize_html_class($ratio); }


    private function text_lines_html($text){
        $lines = preg_split('/\r\n|\r|\n/', (string) $text);
        $html = array();
        foreach ($lines as $line) {
            $line = trim($line);
            if ('' !== $line) { $html[] = esc_html($line); }
        }
        return implode('<br>', $html);
    }
    private function map_address_src($s){
        $address = !empty($s['map_address']) ? $s['map_address'] : (!empty($s['address']) ? $s['address'] : 'Leh Ladakh');
        $zoom = 13;
        if (isset($s['map_zoom']['size'])) { $zoom = max(3, min(18, absint($s['map_zoom']['size']))); }
        return add_query_arg(array('q'=>$address, 'output'=>'embed', 'z'=>$zoom), 'https://www.google.com/maps');
    }

    protected function render(){
        if(function_exists('amaley_de_bootstrap')){ amaley_de_bootstrap()->enqueue_frontend_assets(); }
        $s=$this->get_settings_for_display();
        $classes=array('amaley-de-contact-map', $this->ratio_class(isset($s['desktop_ratio']) ? $s['desktop_ratio'] : '40-60'), $this->hide_classes($s,'whole'));
        ?>
        <section class="<?php echo esc_attr(trim(implode(' ', $classes))); ?>">
            <div class="amaley-de-contact-map__inner">
                <?php if($this->is_show($s,'show_content_panel')): ?>
                    <aside class="amaley-de-contact-map__panel <?php echo esc_attr($this->hide_classes($s,'content_panel')); ?>">
                        <?php if($this->is_show($s,'show_kicker') && !empty($s['kicker'])): ?><div class="amaley-de-contact-map__kicker <?php echo esc_attr($this->hide_classes($s,'kicker')); ?>"><?php echo esc_html($s['kicker']); ?></div><?php endif; ?>
                        <?php if($this->is_show($s,'show_heading') && !empty($s['heading'])): ?><h2 class="amaley-de-contact-map__heading <?php echo esc_attr($this->hide_classes($s,'heading')); ?>"><?php echo nl2br(esc_html($s['heading'])); ?></h2><?php endif; ?>
                        <?php if($this->is_show($s,'show_description') && !empty($s['description'])): ?><p class="amaley-de-contact-map__description <?php echo esc_attr($this->hide_classes($s,'description')); ?>"><?php echo esc_html($s['description']); ?></p><?php endif; ?>
                        <?php if($this->is_show($s,'show_address') || $this->is_show($s,'show_phone') || $this->is_show($s,'show_email')): ?>
                            <div class="amaley-de-contact-map__details <?php echo esc_attr($this->hide_classes($s,'details')); ?>">
                                <?php if($this->is_show($s,'show_address') && !empty($s['address'])): ?><div class="amaley-de-contact-map__detail"><span class="amaley-de-contact-map__detail-label"><?php esc_html_e('Address','amaley-discovery-engine'); ?></span><span class="amaley-de-contact-map__detail-value"><?php echo nl2br(esc_html($s['address'])); ?></span></div><?php endif; ?>
                                <?php if($this->is_show($s,'show_phone') && !empty($s['phone'])): ?><div class="amaley-de-contact-map__detail"><span class="amaley-de-contact-map__detail-label"><?php esc_html_e('Phone','amaley-discovery-engine'); ?></span><span class="amaley-de-contact-map__detail-value"><?php echo $this->text_lines_html($s['phone']); ?></span></div><?php endif; ?>
                                <?php if($this->is_show($s,'show_email') && !empty($s['email'])): ?><div class="amaley-de-contact-map__detail"><span class="amaley-de-contact-map__detail-label"><?php esc_html_e('Email','amaley-discovery-engine'); ?></span><span class="amaley-de-contact-map__detail-value"><?php echo $this->text_lines_html($s['email']); ?></span></div><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($this->is_show($s,'show_button') && !empty($s['button_text'])): ?><a <?php echo $this->link_attrs($s['button_link'], 'amaley-de-contact-map__button '.$this->hide_classes($s,'button')); ?>><?php echo esc_html($s['button_text']); ?></a><?php endif; ?>
                    </aside>
                <?php endif; ?>
                <?php if($this->is_show($s,'show_map_panel')): ?>
                    <div class="amaley-de-contact-map__map <?php echo esc_attr($this->hide_classes($s,'map_panel')); ?>">
                        <?php if('address' === $s['map_source'] && (!empty($s['map_address']) || !empty($s['address']))): ?>
                            <iframe src="<?php echo esc_url($this->map_address_src($s)); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="<?php esc_attr_e('Map location','amaley-discovery-engine'); ?>"></iframe>
                        <?php elseif('iframe' === $s['map_source'] && !empty($s['map_iframe'])): ?>
                            <?php echo wp_kses($s['map_iframe'], $this->allowed_iframe()); ?>
                        <?php elseif('image' === $s['map_source'] && !empty($s['map_image']['url'])): ?>
                            <img src="<?php echo esc_url($s['map_image']['url']); ?>" alt="<?php esc_attr_e('Map location','amaley-discovery-engine'); ?>">
                        <?php elseif('shortcode' === $s['map_source'] && !empty($s['map_shortcode'])): ?>
                            <?php echo do_shortcode($s['map_shortcode']); ?>
                        <?php else: ?>
                            <div class="amaley-de-contact-map__placeholder"><?php echo esc_html($s['fallback_text']); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
