<?php
if (!defined('ABSPATH')) { exit; }

class Amaley_DE_Elementor_Universal_CTA_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_universal_cta'; }
    public function get_title(){ return __('Amaley Universal CTA', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-call-to-action'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    public function get_keywords(){ return array('amaley','cta','call to action','banner','button','universal'); }
    public function get_style_depends(){ if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }

    protected function register_controls(){
        $this->register_content_controls();
        $this->register_style_controls();
        $this->register_advanced_controls();
    }

    private function switcher($label, $default='yes', $condition=array()){
        $args = array(
            'label' => $label,
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'amaley-discovery-engine'),
            'label_off' => __('Hide', 'amaley-discovery-engine'),
            'return_value' => 'yes',
            'default' => $default,
        );
        if (!empty($condition)) { $args['condition'] = $condition; }
        return $args;
    }

    private function register_content_controls(){
        $this->start_controls_section('content_main', array(
            'label' => __('CTA Content', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('layout_preset', array(
            'label' => __('Layout Preset', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'split',
            'options' => array(
                'split' => __('Split Content + Visual', 'amaley-discovery-engine'),
                'centered' => __('Centered Banner', 'amaley-discovery-engine'),
                'card' => __('Compact Card', 'amaley-discovery-engine'),
                'inline' => __('Inline Strip', 'amaley-discovery-engine'),
            ),
        ));
        $this->add_control('show_kicker', $this->switcher(__('Kicker', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('kicker', array(
            'label' => __('Kicker Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Amaley Collective', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_kicker' => 'yes'),
        ));
        $this->add_control('show_heading', $this->switcher(__('Heading', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('heading', array(
            'label' => __('Heading Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Bring Himalayan stories into every order', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_heading' => 'yes'),
        ));
        $this->add_control('show_accent', $this->switcher(__('Accent Text', 'amaley-discovery-engine'), 'yes', array('show_heading' => 'yes')));
        $this->add_control('accent_text', array(
            'label' => __('Accent Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Small batch. Source linked.', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_heading' => 'yes','show_accent' => 'yes'),
        ));
        $this->add_control('show_description', $this->switcher(__('Description', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('description', array(
            'label' => __('Description', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Use this reusable CTA on shop, cluster, SHG, product, blog, or landing pages to guide visitors toward enquiries, gifting, custom orders, or source-led discovery.', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_description' => 'yes'),
        ));
        $this->add_control('show_buttons', $this->switcher(__('Buttons Row', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('show_primary_button', $this->switcher(__('Primary Button', 'amaley-discovery-engine'), 'yes', array('show_buttons'=>'yes')));
        $this->add_control('primary_button_text', array(
            'label' => __('Primary Button Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Start an Enquiry', 'amaley-discovery-engine'),
            'condition' => array('show_buttons'=>'yes','show_primary_button'=>'yes'),
        ));
        $this->add_control('primary_button_link', array(
            'label' => __('Primary Button Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
            'condition' => array('show_buttons'=>'yes','show_primary_button'=>'yes'),
        ));
        $this->add_control('show_secondary_button', $this->switcher(__('Secondary Button', 'amaley-discovery-engine'), 'yes', array('show_buttons'=>'yes')));
        $this->add_control('secondary_button_text', array(
            'label' => __('Secondary Button Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Explore Products', 'amaley-discovery-engine'),
            'condition' => array('show_buttons'=>'yes','show_secondary_button'=>'yes'),
        ));
        $this->add_control('secondary_button_link', array(
            'label' => __('Secondary Button Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
            'condition' => array('show_buttons'=>'yes','show_secondary_button'=>'yes'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('content_visual', array(
            'label' => __('Visual / Pattern', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('show_visual', $this->switcher(__('Visual Area', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('visual_type', array(
            'label' => __('Visual Type', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'pattern_card',
            'options' => array(
                'pattern_card' => __('Pattern Card', 'amaley-discovery-engine'),
                'image' => __('Image', 'amaley-discovery-engine'),
                'badge' => __('Badge / Seal', 'amaley-discovery-engine'),
                'none' => __('None', 'amaley-discovery-engine'),
            ),
            'condition' => array('show_visual'=>'yes'),
        ));
        $this->add_control('visual_image', array(
            'label' => __('Visual Image', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'condition' => array('show_visual'=>'yes','visual_type'=>'image'),
        ));
        $this->add_control('image_alt', array(
            'label' => __('Image Alt Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Amaley products', 'amaley-discovery-engine'),
            'condition' => array('show_visual'=>'yes','visual_type'=>'image'),
        ));
        $this->add_control('badge_text', array(
            'label' => __('Badge Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Source\nLinked', 'amaley-discovery-engine'),
            'condition' => array('show_visual'=>'yes','visual_type'=>'badge'),
        ));
        $this->add_control('show_pattern', $this->switcher(__('Background Pattern', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('pattern_style', array(
            'label' => __('Pattern Style', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'rings',
            'options' => array(
                'rings' => __('Rings', 'amaley-discovery-engine'),
                'grid' => __('Soft Grid', 'amaley-discovery-engine'),
                'orb' => __('Soft Orb', 'amaley-discovery-engine'),
                'none' => __('None', 'amaley-discovery-engine'),
            ),
            'condition' => array('show_pattern'=>'yes'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('content_trust', array(
            'label' => __('Trust Points / Mini Items', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('show_trust_points', $this->switcher(__('Trust Points', 'amaley-discovery-engine'), 'yes'));
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('show_item', array(
            'label' => __('Show Item', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ));
        $repeater->add_control('icon', array(
            'label' => __('Icon', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => array('value'=>'fas fa-check','library'=>'fa-solid'),
        ));
        $repeater->add_control('title', array(
            'label' => __('Title', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Traceable', 'amaley-discovery-engine'),
        ));
        $repeater->add_control('description', array(
            'label' => __('Description', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Linked to source clusters', 'amaley-discovery-engine'),
        ));
        $repeater->add_control('link', array(
            'label' => __('Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
        ));
        $this->add_control('trust_items', array(
            'label' => __('Items', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => array(
                array('title'=>__('Source Linked','amaley-discovery-engine'),'description'=>__('Every product has a story','amaley-discovery-engine'),'show_item'=>'yes'),
                array('title'=>__('SHG Connected','amaley-discovery-engine'),'description'=>__('Community-led value chains','amaley-discovery-engine'),'show_item'=>'yes'),
                array('title'=>__('Small Batch','amaley-discovery-engine'),'description'=>__('Made with care, not mass produced','amaley-discovery-engine'),'show_item'=>'yes'),
            ),
            'title_field' => '{{{ title }}}',
            'condition' => array('show_trust_points'=>'yes'),
        ));
        $this->end_controls_section();
    }

    private function register_style_controls(){
        $root = '{{WRAPPER}} .amaley-de-universal-cta';
        $inner = $root . ' .amaley-de-universal-cta__inner';
        $content = $root . ' .amaley-de-universal-cta__content';
        $visual = $root . ' .amaley-de-universal-cta__visual';
        $kicker = $root . ' .amaley-de-universal-cta__kicker';
        $heading = $root . ' .amaley-de-universal-cta__heading';
        $accent = $root . ' .amaley-de-universal-cta__accent';
        $desc = $root . ' .amaley-de-universal-cta__description';
        $buttons = $root . ' .amaley-de-universal-cta__buttons';
        $primary = $root . ' .amaley-de-universal-cta__button--primary';
        $secondary = $root . ' .amaley-de-universal-cta__button--secondary';
        $trust = $root . ' .amaley-de-universal-cta__trust';
        $trust_item = $root . ' .amaley-de-universal-cta__trust-item';

        $this->start_controls_section('style_section_layout', array(
            'label' => __('Section / Layout', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->start_controls_tabs('section_layout_tabs');
        $this->start_controls_tab('section_tab_box', array('label'=>__('Box','amaley-discovery-engine')));
        $this->add_responsive_control('section_max_width', array(
            'label' => __('Section Max Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','%','vw'),
            'range' => array('px'=>array('min'=>320,'max'=>1600),'%'=>array('min'=>40,'max'=>100),'vw'=>array('min'=>40,'max'=>100)),
            'selectors' => array($root => 'max-width: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('section_margin', array(
            'label' => __('Section Margin', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','em','rem','%'),
            'selectors' => array($root => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('box_padding', array(
            'label' => __('Box Padding', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','em','rem','%'),
            'selectors' => array($inner => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('box_min_height', array(
            'label' => __('Box Min Height', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','vh'),
            'range' => array('px'=>array('min'=>0,'max'=>900),'vh'=>array('min'=>10,'max'=>100)),
            'selectors' => array($inner => 'min-height: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array(
            'name' => 'box_background',
            'selector' => $inner,
        ));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name' => 'box_border',
            'selector' => $inner,
        ));
        $this->add_responsive_control('box_radius', array(
            'label' => __('Box Radius', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','%'),
            'selectors' => array($inner => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'box_shadow','selector'=>$inner));
        $this->end_controls_tab();

        $this->start_controls_tab('section_tab_layout', array('label'=>__('Layout','amaley-discovery-engine')));
        $this->add_responsive_control('content_columns', array(
            'label' => __('Content / Visual Columns', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '2',
            'options' => array('1'=>__('1 Column','amaley-discovery-engine'),'2'=>__('2 Columns','amaley-discovery-engine')),
            'selectors' => array($inner => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));'),
        ));
        $this->add_responsive_control('layout_gap', array(
            'label' => __('Layout Gap', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','em','rem'),
            'range' => array('px'=>array('min'=>0,'max'=>120)),
            'selectors' => array($inner => 'gap: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('content_max_width', array(
            'label' => __('Content Max Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','%'),
            'range' => array('px'=>array('min'=>240,'max'=>1000),'%'=>array('min'=>30,'max'=>100)),
            'selectors' => array($content => 'max-width: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('content_position', array(
            'label' => __('Content Block Position', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'),
                'flex-end' => array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'),
                'stretch' => array('title'=>__('Stretch','amaley-discovery-engine'),'icon'=>'eicon-h-align-stretch'),
            ),
            'selectors' => array($content => 'justify-self: {{VALUE}};'),
        ));
        $this->add_responsive_control('vertical_align', array(
            'label' => __('Vertical Align', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'start' => array('title'=>__('Top','amaley-discovery-engine'),'icon'=>'eicon-v-align-top'),
                'center' => array('title'=>__('Middle','amaley-discovery-engine'),'icon'=>'eicon-v-align-middle'),
                'end' => array('title'=>__('Bottom','amaley-discovery-engine'),'icon'=>'eicon-v-align-bottom'),
            ),
            'selectors' => array($inner => 'align-items: {{VALUE}};'),
        ));
        $this->end_controls_tab();

        $this->start_controls_tab('section_tab_alignment', array('label'=>__('Alignment','amaley-discovery-engine')));
        $this->add_responsive_control('text_align', array(
            'label' => __('Text Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-text-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-text-align-center'),
                'right' => array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-text-align-right'),
            ),
            'selectors' => array($content => 'text-align: {{VALUE}};'),
        ));
        $this->add_responsive_control('buttons_align', array(
            'label' => __('Buttons Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'),
                'flex-end' => array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'),
                'stretch' => array('title'=>__('Stretch','amaley-discovery-engine'),'icon'=>'eicon-h-align-stretch'),
            ),
            'selectors' => array($buttons => 'justify-content: {{VALUE}};'),
        ));
        $this->add_responsive_control('trust_align', array(
            'label' => __('Trust Items Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'),
                'flex-end' => array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'),
            ),
            'selectors' => array($trust => 'justify-content: {{VALUE}};'),
        ));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_text', array('label'=>__('Text Elements','amaley-discovery-engine'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('text_tabs');
        $this->start_controls_tab('text_kicker', array('label'=>__('Kicker','amaley-discovery-engine')));
        $this->add_control('kicker_color', array('label'=>__('Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($kicker=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'kicker_typography','selector'=>$kicker));
        $this->add_responsive_control('kicker_margin', array('label'=>__('Margin','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','rem'),'selectors'=>array($kicker=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('text_heading', array('label'=>__('Heading','amaley-discovery-engine')));
        $this->add_control('heading_color', array('label'=>__('Heading Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($heading=>'color: {{VALUE}};')));
        $this->add_control('accent_color', array('label'=>__('Accent Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($accent=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'heading_typography','selector'=>$heading));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'accent_typography','selector'=>$accent));
        $this->add_responsive_control('heading_margin', array('label'=>__('Margin','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','rem'),'selectors'=>array($heading=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('text_desc', array('label'=>__('Description','amaley-discovery-engine')));
        $this->add_control('desc_color', array('label'=>__('Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($desc=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'desc_typography','selector'=>$desc));
        $this->add_responsive_control('desc_max_width', array('label'=>__('Max Width','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px','%'),'range'=>array('px'=>array('min'=>160,'max'=>900),'%'=>array('min'=>20,'max'=>100)),'selectors'=>array($desc=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('desc_margin', array('label'=>__('Margin','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','rem'),'selectors'=>array($desc=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_buttons', array('label'=>__('Buttons','amaley-discovery-engine'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('buttons_gap', array('label'=>__('Button Gap','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px','em','rem'),'range'=>array('px'=>array('min'=>0,'max'=>60)),'selectors'=>array($buttons=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_min_height', array('label'=>__('Button Min Height','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>24,'max'=>100)),'selectors'=>array($root.' .amaley-de-universal-cta__button'=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_padding', array('label'=>__('Button Padding','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','rem'),'selectors'=>array($root.' .amaley-de-universal-cta__button'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_radius', array('label'=>__('Button Radius','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','%'),'selectors'=>array($root.' .amaley-de-universal-cta__button'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'button_typography','selector'=>$root.' .amaley-de-universal-cta__button'));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'button_shadow','selector'=>$root.' .amaley-de-universal-cta__button'));
        $this->start_controls_tabs('button_state_tabs');
        $this->start_controls_tab('primary_normal', array('label'=>__('Primary Normal','amaley-discovery-engine')));
        $this->add_control('primary_bg', array('label'=>__('Background','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($primary=>'background: {{VALUE}};')));
        $this->add_control('primary_text', array('label'=>__('Text Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($primary=>'color: {{VALUE}};')));
        $this->add_control('primary_border', array('label'=>__('Border Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($primary=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('primary_hover', array('label'=>__('Primary Hover','amaley-discovery-engine')));
        $this->add_control('primary_bg_hover', array('label'=>__('Background','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($primary.':hover, '.$primary.':focus'=>'background: {{VALUE}};')));
        $this->add_control('primary_text_hover', array('label'=>__('Text Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($primary.':hover, '.$primary.':focus'=>'color: {{VALUE}};')));
        $this->add_control('primary_border_hover', array('label'=>__('Border Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($primary.':hover, '.$primary.':focus'=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('secondary_normal', array('label'=>__('Secondary Normal','amaley-discovery-engine')));
        $this->add_control('secondary_bg', array('label'=>__('Background','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($secondary=>'background: {{VALUE}};')));
        $this->add_control('secondary_text', array('label'=>__('Text Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($secondary=>'color: {{VALUE}};')));
        $this->add_control('secondary_border', array('label'=>__('Border Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($secondary=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('secondary_hover', array('label'=>__('Secondary Hover','amaley-discovery-engine')));
        $this->add_control('secondary_bg_hover', array('label'=>__('Background','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($secondary.':hover, '.$secondary.':focus'=>'background: {{VALUE}};')));
        $this->add_control('secondary_text_hover', array('label'=>__('Text Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($secondary.':hover, '.$secondary.':focus'=>'color: {{VALUE}};')));
        $this->add_control('secondary_border_hover', array('label'=>__('Border Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($secondary.':hover, '.$secondary.':focus'=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_visual', array('label'=>__('Visual / Pattern','amaley-discovery-engine'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('visual_tabs');
        $this->start_controls_tab('visual_box', array('label'=>__('Visual Box','amaley-discovery-engine')));
        $this->add_responsive_control('visual_min_height', array('label'=>__('Min Height','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px','vh'),'range'=>array('px'=>array('min'=>80,'max'=>700),'vh'=>array('min'=>10,'max'=>80)),'selectors'=>array($visual=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array('name'=>'visual_background','selector'=>$visual));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'visual_border','selector'=>$visual));
        $this->add_responsive_control('visual_radius', array('label'=>__('Radius','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','%'),'selectors'=>array($visual=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'visual_shadow','selector'=>$visual));
        $this->end_controls_tab();
        $this->start_controls_tab('pattern_tab', array('label'=>__('Pattern','amaley-discovery-engine')));
        $this->add_control('pattern_color', array('label'=>__('Pattern Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($root.' .amaley-de-universal-cta__pattern'=>'border-color: {{VALUE}};', $root.' .amaley-de-universal-cta__pattern:before'=>'border-color: {{VALUE}};', $root.' .amaley-de-universal-cta__pattern:after'=>'background: {{VALUE}};')));
        $this->add_responsive_control('pattern_opacity', array('label'=>__('Pattern Opacity','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'range'=>array('px'=>array('min'=>0,'max'=>1,'step'=>0.01)),'selectors'=>array($root.' .amaley-de-universal-cta__pattern'=>'opacity: {{SIZE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('image_tab', array('label'=>__('Image / Badge','amaley-discovery-engine')));
        $this->add_control('image_fit', array('label'=>__('Image Fit','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SELECT,'default'=>'cover','options'=>array('cover'=>'Cover','contain'=>'Contain','fill'=>'Fill'),'selectors'=>array($root.' .amaley-de-universal-cta__image img'=>'object-fit: {{VALUE}};')));
        $this->add_responsive_control('badge_size', array('label'=>__('Badge Size','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>80,'max'=>360)),'selectors'=>array($root.' .amaley-de-universal-cta__badge'=>'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
        $this->add_control('badge_color', array('label'=>__('Badge Text Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($root.' .amaley-de-universal-cta__badge'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'badge_typography','selector'=>$root.' .amaley-de-universal-cta__badge'));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_trust', array('label'=>__('Trust Points','amaley-discovery-engine'),'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('trust_gap', array('label'=>__('Items Gap','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px','em','rem'),'range'=>array('px'=>array('min'=>0,'max'=>60)),'selectors'=>array($trust=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('trust_margin', array('label'=>__('Trust Row Margin','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','rem'),'selectors'=>array($trust=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('trust_item_padding', array('label'=>__('Item Padding','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','rem'),'selectors'=>array($trust_item=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array('name'=>'trust_item_background','selector'=>$trust_item));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'trust_item_border','selector'=>$trust_item));
        $this->add_responsive_control('trust_item_radius', array('label'=>__('Item Radius','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','%'),'selectors'=>array($trust_item=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('trust_icon_color', array('label'=>__('Icon Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($root.' .amaley-de-universal-cta__trust-icon'=>'color: {{VALUE}};')));
        $this->add_responsive_control('trust_icon_size', array('label'=>__('Icon Size','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px','em'),'range'=>array('px'=>array('min'=>8,'max'=>64)),'selectors'=>array($root.' .amaley-de-universal-cta__trust-icon'=>'font-size: {{SIZE}}{{UNIT}};')));
        $this->add_control('trust_title_color', array('label'=>__('Title Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($root.' .amaley-de-universal-cta__trust-title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'trust_title_typography','selector'=>$root.' .amaley-de-universal-cta__trust-title'));
        $this->add_control('trust_desc_color', array('label'=>__('Description Color','amaley-discovery-engine'),'type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array($root.' .amaley-de-universal-cta__trust-desc'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'trust_desc_typography','selector'=>$root.' .amaley-de-universal-cta__trust-desc'));
        $this->end_controls_section();
    }

    private function register_advanced_controls(){
        $this->start_controls_section('advanced_visibility', array(
            'label' => __('Visibility / Responsive Layout', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
        ));
        $this->start_controls_tabs('visibility_tabs');
        foreach (array('desktop'=>__('Desktop','amaley-discovery-engine'), 'tablet'=>__('Tablet','amaley-discovery-engine'), 'mobile'=>__('Mobile','amaley-discovery-engine')) as $device => $label) {
            $this->start_controls_tab('vis_'.$device, array('label'=>$label));
            foreach (array(
                'widget'=>__('Whole CTA','amaley-discovery-engine'),
                'kicker'=>__('Kicker','amaley-discovery-engine'),
                'heading'=>__('Heading','amaley-discovery-engine'),
                'accent'=>__('Accent Text','amaley-discovery-engine'),
                'description'=>__('Description','amaley-discovery-engine'),
                'buttons'=>__('Buttons','amaley-discovery-engine'),
                'visual'=>__('Visual Area','amaley-discovery-engine'),
                'pattern'=>__('Pattern','amaley-discovery-engine'),
                'trust'=>__('Trust Points','amaley-discovery-engine'),
            ) as $part => $part_label) {
                $this->add_control('hide_'.$part.'_'.$device, array(
                    'label' => sprintf(__('Hide %s', 'amaley-discovery-engine'), $part_label),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => '',
                    'prefix_class' => 'amaley-de-universal-cta-hide-'.$part.'-'.$device.'-',
                ));
            }
            if ('mobile' === $device) {
                $this->add_control('mobile_stack', array(
                    'label' => __('Force 1 Column on Mobile', 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'prefix_class' => 'amaley-de-universal-cta-mobile-stack-',
                ));
                $this->add_control('mobile_buttons_full', array(
                    'label' => __('Full Width Buttons on Mobile', 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => '',
                    'prefix_class' => 'amaley-de-universal-cta-mobile-buttons-full-',
                ));
                $this->add_control('mobile_center', array(
                    'label' => __('Auto Center Content on Mobile', 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => '',
                    'prefix_class' => 'amaley-de-universal-cta-mobile-center-',
                ));
            }
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render(){
        $s = $this->get_settings_for_display();
        $classes = array(
            'amaley-de-universal-cta',
            'amaley-de-universal-cta--layout-' . sanitize_html_class(isset($s['layout_preset']) ? $s['layout_preset'] : 'split'),
            'amaley-de-universal-cta--visual-' . sanitize_html_class(isset($s['visual_type']) ? $s['visual_type'] : 'pattern_card'),
            'amaley-de-universal-cta--pattern-' . sanitize_html_class(isset($s['pattern_style']) ? $s['pattern_style'] : 'rings'),
        );
        echo '<section class="' . esc_attr(implode(' ', $classes)) . '">';
        echo '<div class="amaley-de-universal-cta__inner">';
        echo '<div class="amaley-de-universal-cta__content">';
        if (!empty($s['show_kicker']) && 'yes' === $s['show_kicker'] && !empty($s['kicker'])) {
            echo '<div class="amaley-de-universal-cta__kicker">' . esc_html($s['kicker']) . '</div>';
        }
        if (!empty($s['show_heading']) && 'yes' === $s['show_heading']) {
            echo '<h2 class="amaley-de-universal-cta__heading">' . wp_kses_post(nl2br($s['heading']));
            if (!empty($s['show_accent']) && 'yes' === $s['show_accent'] && !empty($s['accent_text'])) {
                echo '<span class="amaley-de-universal-cta__accent">' . esc_html($s['accent_text']) . '</span>';
            }
            echo '</h2>';
        }
        if (!empty($s['show_description']) && 'yes' === $s['show_description'] && !empty($s['description'])) {
            echo '<div class="amaley-de-universal-cta__description">' . wp_kses_post(wpautop($s['description'])) . '</div>';
        }
        if (!empty($s['show_buttons']) && 'yes' === $s['show_buttons']) {
            $primary = $this->button_html($s, 'primary');
            $secondary = $this->button_html($s, 'secondary');
            if ($primary || $secondary) {
                echo '<div class="amaley-de-universal-cta__buttons">' . $primary . $secondary . '</div>';
            }
        }
        if (!empty($s['show_trust_points']) && 'yes' === $s['show_trust_points'] && !empty($s['trust_items']) && is_array($s['trust_items'])) {
            echo '<div class="amaley-de-universal-cta__trust">';
            foreach ($s['trust_items'] as $item) {
                if (isset($item['show_item']) && 'yes' !== $item['show_item']) { continue; }
                $tag = (!empty($item['link']['url'])) ? 'a' : 'div';
                $href = (!empty($item['link']['url'])) ? ' href="' . esc_url($item['link']['url']) . '"' : '';
                $target = (!empty($item['link']['is_external'])) ? ' target="_blank"' : '';
                $nofollow = (!empty($item['link']['nofollow'])) ? ' rel="nofollow"' : '';
                echo '<' . $tag . ' class="amaley-de-universal-cta__trust-item"' . $href . $target . $nofollow . '>';
                if (!empty($item['icon']['value'])) { echo '<span class="amaley-de-universal-cta__trust-icon">'; \Elementor\Icons_Manager::render_icon($item['icon'], array('aria-hidden'=>'true')); echo '</span>'; }
                echo '<span class="amaley-de-universal-cta__trust-copy">';
                if (!empty($item['title'])) { echo '<strong class="amaley-de-universal-cta__trust-title">' . esc_html($item['title']) . '</strong>'; }
                if (!empty($item['description'])) { echo '<small class="amaley-de-universal-cta__trust-desc">' . esc_html($item['description']) . '</small>'; }
                echo '</span></' . $tag . '>';
            }
            echo '</div>';
        }
        echo '</div>';
        if (!empty($s['show_visual']) && 'yes' === $s['show_visual'] && (!isset($s['visual_type']) || 'none' !== $s['visual_type'])) {
            echo '<div class="amaley-de-universal-cta__visual">';
            if (!empty($s['show_pattern']) && 'yes' === $s['show_pattern'] && (!isset($s['pattern_style']) || 'none' !== $s['pattern_style'])) {
                echo '<span class="amaley-de-universal-cta__pattern" aria-hidden="true"></span>';
            }
            if (isset($s['visual_type']) && 'image' === $s['visual_type'] && !empty($s['visual_image']['url'])) {
                echo '<figure class="amaley-de-universal-cta__image"><img src="' . esc_url($s['visual_image']['url']) . '" alt="' . esc_attr(isset($s['image_alt']) ? $s['image_alt'] : '') . '"></figure>';
            } elseif (isset($s['visual_type']) && 'badge' === $s['visual_type']) {
                echo '<div class="amaley-de-universal-cta__badge">' . esc_html(isset($s['badge_text']) ? $s['badge_text'] : '') . '</div>';
            } else {
                echo '<div class="amaley-de-universal-cta__visual-card"><span>Amaley</span><small>Source-led products</small></div>';
            }
            echo '</div>';
        }
        echo '</div></section>';
    }

    private function button_html($s, $type){
        $show = 'show_' . $type . '_button';
        $text_key = $type . '_button_text';
        $link_key = $type . '_button_link';
        if (empty($s[$show]) || 'yes' !== $s[$show] || empty($s[$text_key])) { return ''; }
        $url = !empty($s[$link_key]['url']) ? $s[$link_key]['url'] : '#';
        $target = !empty($s[$link_key]['is_external']) ? ' target="_blank"' : '';
        $nofollow = !empty($s[$link_key]['nofollow']) ? ' rel="nofollow"' : '';
        return '<a class="amaley-de-universal-cta__button amaley-de-universal-cta__button--' . esc_attr($type) . '" href="' . esc_url($url) . '"' . $target . $nofollow . '>' . esc_html($s[$text_key]) . '</a>';
    }
}
