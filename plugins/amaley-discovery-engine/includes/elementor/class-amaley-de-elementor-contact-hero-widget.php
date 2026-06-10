<?php
if (!defined('ABSPATH')) { exit; }

class Amaley_DE_Elementor_Contact_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_contact_hero'; }
    public function get_title(){ return __('Amaley Contact Hero', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-banner'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    public function get_keywords(){ return array('amaley','contact','hero','header','banner'); }
    public function get_style_depends(){ if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }

    protected function register_controls(){
        $this->register_content_controls();
        $this->register_style_controls();
        $this->register_advanced_visibility_controls();
    }

    private function switcher($label, $default = 'yes', $condition = array()){
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
        $this->start_controls_section('content_text', array('label' => __('Hero Content', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_breadcrumb', $this->switcher(__('Breadcrumb', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('breadcrumb_home', array('label' => __('Home Label', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Home', 'amaley-discovery-engine'), 'condition' => array('show_breadcrumb' => 'yes')));
        $this->add_control('breadcrumb_current', array('label' => __('Current Page Label', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Contact Amaley', 'amaley-discovery-engine'), 'condition' => array('show_breadcrumb' => 'yes')));
        $this->add_control('breadcrumb_home_link', array('label' => __('Home Link', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::URL, 'placeholder' => home_url('/'), 'condition' => array('show_breadcrumb' => 'yes')));
        $this->add_control('show_kicker', $this->switcher(__('Kicker', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('kicker', array('label' => __('Kicker Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Contact Amaley', 'amaley-discovery-engine'), 'label_block' => true, 'condition' => array('show_kicker' => 'yes')));
        $this->add_control('show_heading', $this->switcher(__('Heading', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('heading_before', array('label' => __('Heading Before Accent', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Let’s connect from the', 'amaley-discovery-engine'), 'label_block' => true, 'condition' => array('show_heading' => 'yes')));
        $this->add_control('show_heading_accent', $this->switcher(__('Accent Text', 'amaley-discovery-engine'), 'yes', array('show_heading' => 'yes')));
        $this->add_control('heading_accent', array('label' => __('Accent Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Himalayas', 'amaley-discovery-engine'), 'label_block' => true, 'condition' => array('show_heading' => 'yes', 'show_heading_accent' => 'yes')));
        $this->add_control('heading_after', array('label' => __('Heading After Accent', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '.', 'label_block' => true, 'condition' => array('show_heading' => 'yes')));
        $this->add_control('show_description', $this->switcher(__('Description', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('description', array('label' => __('Description', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => __('For product enquiries, bulk orders, gifting, collaborations, sourcing stories, or community partnerships — reach out to the Amaley team.', 'amaley-discovery-engine'), 'label_block' => true, 'condition' => array('show_description' => 'yes')));
        $this->end_controls_section();

        $this->start_controls_section('content_buttons', array('label' => __('Buttons', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_primary_button', $this->switcher(__('Primary Button', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('primary_button_text', array('label' => __('Primary Button Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Send Enquiry', 'amaley-discovery-engine'), 'condition' => array('show_primary_button' => 'yes')));
        $this->add_control('primary_button_link', array('label' => __('Primary Button Link', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::URL, 'condition' => array('show_primary_button' => 'yes')));
        $this->add_control('show_secondary_button', $this->switcher(__('Secondary Button', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('secondary_button_text', array('label' => __('Secondary Button Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Open Map', 'amaley-discovery-engine'), 'condition' => array('show_secondary_button' => 'yes')));
        $this->add_control('secondary_button_link', array('label' => __('Secondary Button Link', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::URL, 'condition' => array('show_secondary_button' => 'yes')));
        $this->end_controls_section();

        $this->start_controls_section('content_trust', array('label' => __('Trust Points / Mini Items', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_trust_points', $this->switcher(__('Trust Points', 'amaley-discovery-engine'), 'yes'));
        $rep = new \Elementor\Repeater();
        $rep->add_control('show_item', array('label' => __('Show Item', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes'));
        $rep->add_control('number', array('label' => __('Top Text / Number', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '24h'));
        $rep->add_control('label', array('label' => __('Label', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Response window', 'amaley-discovery-engine')));
        $rep->add_control('link', array('label' => __('Link', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::URL));
        $this->add_control('trust_items', array(
            'label' => __('Trust Items', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => array(
                array('number'=>'Bulk', 'label'=>__('Orders & gifting', 'amaley-discovery-engine'), 'show_item'=>'yes'),
                array('number'=>'Leh', 'label'=>__('Rooted in Ladakh', 'amaley-discovery-engine'), 'show_item'=>'yes'),
                array('number'=>'SHG', 'label'=>__('Community sourced', 'amaley-discovery-engine'), 'show_item'=>'yes'),
            ),
            'title_field' => '{{{ number }}} — {{{ label }}}',
            'condition' => array('show_trust_points' => 'yes'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('content_visual', array('label' => __('Visual / Pattern', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_pattern', $this->switcher(__('Pattern', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('pattern_type', array('label' => __('Pattern Type', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'rings', 'options' => array('rings'=>__('Rings', 'amaley-discovery-engine'), 'mountain'=>__('Mountain Lines', 'amaley-discovery-engine'), 'orb'=>__('Soft Orb', 'amaley-discovery-engine'), 'none'=>__('None', 'amaley-discovery-engine')), 'condition' => array('show_pattern' => 'yes')));
        $this->add_control('show_visual_image', $this->switcher(__('Visual Image', 'amaley-discovery-engine'), 'no'));
        $this->add_control('visual_image', array('label' => __('Image', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::MEDIA, 'condition' => array('show_visual_image' => 'yes')));
        $this->add_control('image_alt', array('label' => __('Image Alt Text', 'amaley-discovery-engine'), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __('Amaley contact', 'amaley-discovery-engine'), 'condition' => array('show_visual_image' => 'yes')));
        $this->end_controls_section();
    }

    private function register_style_controls(){
        $root = '{{WRAPPER}} .amaley-de-contact-hero';
        $inner = $root . ' .amaley-de-contact-hero__inner';
        $content = $root . ' .amaley-de-contact-hero__content';
        $buttons = $root . ' .amaley-de-contact-hero__actions';
        $primary = $root . ' .amaley-de-contact-hero__button--primary';
        $secondary = $root . ' .amaley-de-contact-hero__button--secondary';
        $trust = $root . ' .amaley-de-contact-hero__trust';
        $pattern = $root . ' .amaley-de-contact-hero__pattern';
        $visual = $root . ' .amaley-de-contact-hero__visual';

        $this->start_controls_section('style_layout', array('label' => __('Section / Layout', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('layout_tabs');
        $this->start_controls_tab('layout_section_tab', array('label'=>__('Section', 'amaley-discovery-engine')));
        $this->add_control('section_bg', array('label'=>__('Background', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root=>'background-color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array('name'=>'section_background_group', 'selector'=>$root));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'section_border', 'selector'=>$root));
        $this->add_responsive_control('section_radius', array('label'=>__('Border Radius', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($root=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('section_padding', array('label'=>__('Padding', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('section_margin', array('label'=>__('Margin', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'section_shadow', 'selector'=>$root));
        $this->end_controls_tab();
        $this->start_controls_tab('layout_inner_tab', array('label'=>__('Layout', 'amaley-discovery-engine')));
        $this->add_responsive_control('inner_max_width', array('label'=>__('Inner Max Width', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>320,'max'=>1600), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($inner=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('min_height', array('label'=>__('Min Height', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','vh'), 'range'=>array('px'=>array('min'=>0,'max'=>900), 'vh'=>array('min'=>0,'max'=>100)), 'selectors'=>array($root=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('content_max_width', array('label'=>__('Content Max Width', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>220,'max'=>1000), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($content=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('inner_gap', array('label'=>__('Inner Gap', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>120)), 'selectors'=>array($inner=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('content_gap', array('label'=>__('Content Inner Gap', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($content=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('content_position', array('label'=>__('Content Position', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right')), 'selectors'=>array($inner=>'justify-content: {{VALUE}};')));
        $this->add_responsive_control('text_align', array('label'=>__('Text Alignment', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('left'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-text-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-text-align-center'), 'right'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-text-align-right')), 'selectors'=>array($content=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('actions_align', array('label'=>__('Buttons / Trust Alignment', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right')), 'selectors'=>array($buttons=>'justify-content: {{VALUE}};', $trust=>'justify-content: {{VALUE}};')));
        $this->add_responsive_control('vertical_align', array('label'=>__('Vertical Align', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Top','amaley-discovery-engine'),'icon'=>'eicon-v-align-top'), 'center'=>array('title'=>__('Middle','amaley-discovery-engine'),'icon'=>'eicon-v-align-middle'), 'flex-end'=>array('title'=>__('Bottom','amaley-discovery-engine'),'icon'=>'eicon-v-align-bottom')), 'selectors'=>array($inner=>'align-items: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('layout_responsive_tab', array('label'=>__('Responsive', 'amaley-discovery-engine')));
        $this->add_responsive_control('mobile_stack_gap', array('label'=>__('Mobile/Tablet Stack Gap', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($root . '.is-stack-tablet ' . '.amaley-de-contact-hero__inner'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('tablet_stack_note', array('type'=>\Elementor\Controls_Manager::RAW_HTML, 'raw'=>__('Hero automatically stacks cleanly on tablet/mobile when the visual image is shown.', 'amaley-discovery-engine'), 'content_classes'=>'elementor-panel-alert elementor-panel-alert-info'));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_text', array('label'=>__('Text Elements', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('text_tabs');
        $this->start_controls_tab('text_breadcrumb_tab', array('label'=>__('Breadcrumb', 'amaley-discovery-engine')));
        $this->add_control('breadcrumb_color', array('label'=>__('Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__breadcrumb'=>$this->css_color('color'))));
        $this->add_control('breadcrumb_link_color', array('label'=>__('Link Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__breadcrumb a'=>$this->css_color('color'))));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'breadcrumb_typography', 'selector'=>$root.' .amaley-de-contact-hero__breadcrumb'));
        $this->add_responsive_control('breadcrumb_margin', array('label'=>__('Margin', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($root.' .amaley-de-contact-hero__breadcrumb'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('text_kicker_tab', array('label'=>__('Kicker', 'amaley-discovery-engine')));
        $this->add_control('kicker_color', array('label'=>__('Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__kicker'=>$this->css_color('color'))));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'kicker_typography', 'selector'=>$root.' .amaley-de-contact-hero__kicker'));
        $this->add_responsive_control('kicker_margin', array('label'=>__('Margin', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($root.' .amaley-de-contact-hero__kicker'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('text_heading_tab', array('label'=>__('Heading', 'amaley-discovery-engine')));
        $this->add_control('heading_color', array('label'=>__('Heading Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__heading'=>$this->css_color('color'))));
        $this->add_control('accent_color', array('label'=>__('Accent Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__heading-accent'=>$this->css_color('color'))));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'heading_typography', 'selector'=>$root.' .amaley-de-contact-hero__heading'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'accent_typography', 'selector'=>$root.' .amaley-de-contact-hero__heading-accent'));
        $this->add_responsive_control('heading_margin', array('label'=>__('Margin', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($root.' .amaley-de-contact-hero__heading'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('text_desc_tab', array('label'=>__('Description', 'amaley-discovery-engine')));
        $this->add_control('description_color', array('label'=>__('Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__description'=>$this->css_color('color'))));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'description_typography', 'selector'=>$root.' .amaley-de-contact-hero__description'));
        $this->add_responsive_control('description_max_width', array('label'=>__('Max Width', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>120,'max'=>900), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($root.' .amaley-de-contact-hero__description'=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('description_margin', array('label'=>__('Margin', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($root.' .amaley-de-contact-hero__description'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_buttons', array('label'=>__('Buttons', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('button_gap', array('label'=>__('Button Gap', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>60)), 'selectors'=>array($buttons=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_min_height', array('label'=>__('Min Height', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>20,'max'=>90)), 'selectors'=>array($root.' .amaley-de-contact-hero__button'=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_padding', array('label'=>__('Padding', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($root.' .amaley-de-contact-hero__button'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_radius', array('label'=>__('Radius', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($root.' .amaley-de-contact-hero__button'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'button_typography', 'selector'=>$root.' .amaley-de-contact-hero__button'));
        $this->start_controls_tabs('button_tabs');
        $this->start_controls_tab('primary_normal', array('label'=>__('Primary Normal', 'amaley-discovery-engine')));
        $this->add_control('primary_bg', array('label'=>__('Background', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary=>$this->css_color('background-color'))));
        $this->add_control('primary_text', array('label'=>__('Text', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary=>$this->css_color('color'))));
        $this->add_control('primary_border', array('label'=>__('Border', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->start_controls_tab('primary_hover', array('label'=>__('Primary Hover', 'amaley-discovery-engine')));
        $this->add_control('primary_hover_bg', array('label'=>__('Background', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary.':hover'=>$this->css_color('background-color'))));
        $this->add_control('primary_hover_text', array('label'=>__('Text', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary.':hover'=>$this->css_color('color'))));
        $this->add_control('primary_hover_border', array('label'=>__('Border', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary.':hover'=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->start_controls_tab('secondary_normal', array('label'=>__('Secondary Normal', 'amaley-discovery-engine')));
        $this->add_control('secondary_bg', array('label'=>__('Background', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary=>$this->css_color('background-color'))));
        $this->add_control('secondary_text', array('label'=>__('Text', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary=>$this->css_color('color'))));
        $this->add_control('secondary_border', array('label'=>__('Border', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->start_controls_tab('secondary_hover', array('label'=>__('Secondary Hover', 'amaley-discovery-engine')));
        $this->add_control('secondary_hover_bg', array('label'=>__('Background', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary.':hover'=>$this->css_color('background-color'))));
        $this->add_control('secondary_hover_text', array('label'=>__('Text', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary.':hover'=>$this->css_color('color'))));
        $this->add_control('secondary_hover_border', array('label'=>__('Border', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary.':hover'=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'button_shadow', 'selector'=>$root.' .amaley-de-contact-hero__button'));
        $this->end_controls_section();

        $this->start_controls_section('style_trust_visual', array('label'=>__('Trust Points & Visual', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('trust_visual_tabs');
        $this->start_controls_tab('trust_tab', array('label'=>__('Trust Points', 'amaley-discovery-engine')));
        $this->add_responsive_control('trust_gap', array('label'=>__('Gap', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($trust=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('trust_number_color', array('label'=>__('Top Text Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__trust-number'=>$this->css_color('color'))));
        $this->add_control('trust_label_color', array('label'=>__('Label Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-hero__trust-label'=>$this->css_color('color'))));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'trust_number_typography', 'selector'=>$root.' .amaley-de-contact-hero__trust-number'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'trust_label_typography', 'selector'=>$root.' .amaley-de-contact-hero__trust-label'));
        $this->end_controls_tab();
        $this->start_controls_tab('pattern_tab', array('label'=>__('Pattern', 'amaley-discovery-engine')));
        $this->add_control('pattern_color', array('label'=>__('Pattern Color', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($pattern=>$this->css_color('border-color'))));
        $this->add_responsive_control('pattern_opacity', array('label'=>__('Opacity', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>1,'step'=>0.01)), 'selectors'=>array($pattern=>'opacity: {{SIZE}};')));
        $this->add_responsive_control('pattern_size', array('label'=>__('Size', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>80,'max'=>900)), 'selectors'=>array($pattern=>'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('image_tab', array('label'=>__('Image', 'amaley-discovery-engine')));
        $this->add_responsive_control('image_width', array('label'=>__('Image Width', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>60,'max'=>600), '%'=>array('min'=>10,'max'=>100)), 'selectors'=>array($visual=>'width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('image_radius', array('label'=>__('Image Radius', 'amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($visual.' img'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'image_shadow', 'selector'=>$visual.' img'));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_advanced_visibility_controls(){
        $this->start_controls_section('advanced_visibility', array('label'=>__('Visibility / Responsive Layout', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_ADVANCED));
        $this->start_controls_tabs('visibility_tabs');
        foreach (array('desktop'=>__('Desktop','amaley-discovery-engine'), 'tablet'=>__('Tablet','amaley-discovery-engine'), 'mobile'=>__('Mobile','amaley-discovery-engine')) as $device => $label) {
            $this->start_controls_tab('vis_'.$device, array('label'=>$label));
            foreach (array('whole'=>'Whole Hero','breadcrumb'=>'Breadcrumb','kicker'=>'Kicker','heading'=>'Heading','description'=>'Description','buttons'=>'Buttons','trust'=>'Trust Points','pattern'=>'Pattern','visual'=>'Visual Image') as $key=>$item_label) {
                $this->add_control('hide_'.$key.'_'.$device, array('label'=>sprintf(__('Hide %s', 'amaley-discovery-engine'), __($item_label, 'amaley-discovery-engine')), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'no'));
            }
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function css_color($property){ return $property . ': {{VALUE}};'; }
    private function is_show($settings, $key){ return isset($settings[$key]) && 'yes' === $settings[$key]; }
    private function hide_classes($settings, $key){
        $classes = array();
        foreach (array('desktop','tablet','mobile') as $device) {
            if (!empty($settings['hide_'.$key.'_'.$device]) && 'yes' === $settings['hide_'.$key.'_'.$device]) { $classes[] = 'amaley-de-hide-'.$device; }
        }
        return implode(' ', $classes);
    }
    private function link_attrs($url, $class){
        $attrs = 'class="'.esc_attr($class).'"';
        if (!empty($url['url'])) {
            $attrs .= ' href="'.esc_url($url['url']).'"';
            if (!empty($url['is_external'])) { $attrs .= ' target="_blank"'; }
            if (!empty($url['nofollow'])) { $attrs .= ' rel="nofollow"'; }
        } else {
            $attrs .= ' href="#"';
        }
        return $attrs;
    }

    protected function render(){
        if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->enqueue_frontend_assets(); }
        $s = $this->get_settings_for_display();
        $classes = array('amaley-de-contact-hero', 'pattern-'.sanitize_html_class(isset($s['pattern_type']) ? $s['pattern_type'] : 'rings'), $this->hide_classes($s, 'whole'));
        ?>
        <section class="<?php echo esc_attr(trim(implode(' ', $classes))); ?>">
            <?php if ($this->is_show($s,'show_pattern') && (!isset($s['pattern_type']) || 'none' !== $s['pattern_type'])) : ?><span class="amaley-de-contact-hero__pattern <?php echo esc_attr($this->hide_classes($s,'pattern')); ?>" aria-hidden="true"></span><?php endif; ?>
            <div class="amaley-de-contact-hero__inner">
                <div class="amaley-de-contact-hero__content">
                    <?php if ($this->is_show($s,'show_breadcrumb')) : ?>
                        <div class="amaley-de-contact-hero__breadcrumb <?php echo esc_attr($this->hide_classes($s,'breadcrumb')); ?>">
                            <?php if (!empty($s['breadcrumb_home_link']['url'])) : ?><a href="<?php echo esc_url($s['breadcrumb_home_link']['url']); ?>"><?php echo esc_html($s['breadcrumb_home']); ?></a><?php else: ?><span><?php echo esc_html($s['breadcrumb_home']); ?></span><?php endif; ?>
                            <span class="amaley-de-contact-hero__breadcrumb-sep">›</span><span><?php echo esc_html($s['breadcrumb_current']); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->is_show($s,'show_kicker') && !empty($s['kicker'])) : ?><div class="amaley-de-contact-hero__kicker <?php echo esc_attr($this->hide_classes($s,'kicker')); ?>"><?php echo esc_html($s['kicker']); ?></div><?php endif; ?>
                    <?php if ($this->is_show($s,'show_heading')) : ?>
                        <h1 class="amaley-de-contact-hero__heading <?php echo esc_attr($this->hide_classes($s,'heading')); ?>"><?php echo esc_html($s['heading_before']); ?> <?php if ($this->is_show($s,'show_heading_accent')) : ?><em class="amaley-de-contact-hero__heading-accent"><?php echo esc_html($s['heading_accent']); ?></em><?php endif; ?><?php echo esc_html($s['heading_after']); ?></h1>
                    <?php endif; ?>
                    <?php if ($this->is_show($s,'show_description') && !empty($s['description'])) : ?><p class="amaley-de-contact-hero__description <?php echo esc_attr($this->hide_classes($s,'description')); ?>"><?php echo esc_html($s['description']); ?></p><?php endif; ?>
                    <?php if (($this->is_show($s,'show_primary_button') && !empty($s['primary_button_text'])) || ($this->is_show($s,'show_secondary_button') && !empty($s['secondary_button_text']))) : ?>
                        <div class="amaley-de-contact-hero__actions <?php echo esc_attr($this->hide_classes($s,'buttons')); ?>">
                            <?php if ($this->is_show($s,'show_primary_button') && !empty($s['primary_button_text'])) : ?><a <?php echo $this->link_attrs($s['primary_button_link'], 'amaley-de-contact-hero__button amaley-de-contact-hero__button--primary'); ?>><?php echo esc_html($s['primary_button_text']); ?></a><?php endif; ?>
                            <?php if ($this->is_show($s,'show_secondary_button') && !empty($s['secondary_button_text'])) : ?><a <?php echo $this->link_attrs($s['secondary_button_link'], 'amaley-de-contact-hero__button amaley-de-contact-hero__button--secondary'); ?>><?php echo esc_html($s['secondary_button_text']); ?></a><?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->is_show($s,'show_trust_points') && !empty($s['trust_items']) && is_array($s['trust_items'])) : ?>
                        <div class="amaley-de-contact-hero__trust <?php echo esc_attr($this->hide_classes($s,'trust')); ?>">
                            <?php foreach ($s['trust_items'] as $item) : if (empty($item['show_item']) || 'yes' !== $item['show_item']) { continue; } $tag = !empty($item['link']['url']) ? 'a' : 'span'; $href = !empty($item['link']['url']) ? ' href="'.esc_url($item['link']['url']).'"' : ''; ?>
                                <<?php echo esc_html($tag); ?> class="amaley-de-contact-hero__trust-item"<?php echo $href; ?>><strong class="amaley-de-contact-hero__trust-number"><?php echo esc_html($item['number']); ?></strong><span class="amaley-de-contact-hero__trust-label"><?php echo esc_html($item['label']); ?></span></<?php echo esc_html($tag); ?>>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($this->is_show($s,'show_visual_image') && !empty($s['visual_image']['url'])) : ?>
                    <figure class="amaley-de-contact-hero__visual <?php echo esc_attr($this->hide_classes($s,'visual')); ?>"><img src="<?php echo esc_url($s['visual_image']['url']); ?>" alt="<?php echo esc_attr($s['image_alt']); ?>"></figure>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
