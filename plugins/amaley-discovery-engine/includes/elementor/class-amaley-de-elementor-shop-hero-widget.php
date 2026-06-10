<?php
if (!defined('ABSPATH')) { exit; }

class Amaley_DE_Elementor_Shop_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_shop_hero'; }
    public function get_title(){ return __('Amaley Shop Hero', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-header'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    public function get_keywords(){ return array('amaley','shop','hero','banner','woocommerce','header'); }
    public function get_style_depends(){ if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }

    protected function register_controls(){
        $this->register_content_controls();
        $this->register_style_controls();
        $this->register_advanced_controls();
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
        $this->start_controls_section('content_text', array(
            'label' => __('Hero Content', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('show_breadcrumb', $this->switcher(__('Breadcrumb', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('breadcrumb_home', array(
            'label' => __('Home Label', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Home', 'amaley-discovery-engine'),
            'condition' => array('show_breadcrumb' => 'yes'),
        ));
        $this->add_control('breadcrumb_current', array(
            'label' => __('Current Page Label', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Shop All Products', 'amaley-discovery-engine'),
            'condition' => array('show_breadcrumb' => 'yes'),
        ));
        $this->add_control('breadcrumb_home_link', array(
            'label' => __('Home Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => home_url('/'),
            'condition' => array('show_breadcrumb' => 'yes'),
        ));
        $this->add_control('show_kicker', $this->switcher(__('Kicker', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('kicker', array(
            'label' => __('Kicker Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Shop by Source, Story & Purpose', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_kicker' => 'yes'),
        ));
        $this->add_control('show_heading', $this->switcher(__('Heading', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('heading_before', array(
            'label' => __('Heading Before Accent', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Shop', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_heading' => 'yes'),
        ));
        $this->add_control('show_heading_accent', $this->switcher(__('Accent Text', 'amaley-discovery-engine'), 'yes', array('show_heading' => 'yes')));
        $this->add_control('heading_accent', array(
            'label' => __('Accent Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Amaley', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_heading' => 'yes', 'show_heading_accent' => 'yes'),
        ));
        $this->add_control('heading_after', array(
            'label' => __('Heading After Accent', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'label_block' => true,
            'condition' => array('show_heading' => 'yes'),
        ));
        $this->add_control('show_description', $this->switcher(__('Description', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('description', array(
            'label' => __('Description', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Small-batch Himalayan foods, crafts, and wellness products traceable to clusters, SHGs, and producers. Every product tells a story.', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_description' => 'yes'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('content_stats', array(
            'label' => __('Stats', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('show_stats', $this->switcher(__('Stats Row', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('stats_source', array(
            'label' => __('Stats Source', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'manual',
            'options' => array(
                'manual' => __('Manual', 'amaley-discovery-engine'),
                'dynamic' => __('Dynamic Counts', 'amaley-discovery-engine'),
            ),
            'condition' => array('show_stats' => 'yes'),
        ));
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('show_stat', array(
            'label' => __('Show Stat', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ));
        $repeater->add_control('number', array(
            'label' => __('Number', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '11',
        ));
        $repeater->add_control('label', array(
            'label' => __('Label', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Products', 'amaley-discovery-engine'),
        ));
        $repeater->add_control('link', array(
            'label' => __('Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
        ));
        $this->add_control('manual_stats', array(
            'label' => __('Manual Stats', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => array(
                array('number' => '11', 'label' => __('Products', 'amaley-discovery-engine'), 'show_stat' => 'yes'),
                array('number' => '12', 'label' => __('Clusters', 'amaley-discovery-engine'), 'show_stat' => 'yes'),
                array('number' => '48', 'label' => __('SHGs', 'amaley-discovery-engine'), 'show_stat' => 'yes'),
            ),
            'title_field' => '{{{ number }}} {{{ label }}}',
            'condition' => array('show_stats' => 'yes', 'stats_source' => 'manual'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('content_buttons', array(
            'label' => __('Buttons', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('show_primary_button', $this->switcher(__('Primary Button', 'amaley-discovery-engine'), 'no'));
        $this->add_control('primary_button_text', array(
            'label' => __('Primary Button Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Explore Products', 'amaley-discovery-engine'),
            'condition' => array('show_primary_button' => 'yes'),
        ));
        $this->add_control('primary_button_link', array(
            'label' => __('Primary Button Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
            'condition' => array('show_primary_button' => 'yes'),
        ));
        $this->add_control('show_secondary_button', $this->switcher(__('Secondary Button', 'amaley-discovery-engine'), 'no'));
        $this->add_control('secondary_button_text', array(
            'label' => __('Secondary Button Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Know the Source', 'amaley-discovery-engine'),
            'condition' => array('show_secondary_button' => 'yes'),
        ));
        $this->add_control('secondary_button_link', array(
            'label' => __('Secondary Button Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
            'condition' => array('show_secondary_button' => 'yes'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('content_visual', array(
            'label' => __('Background Visual', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('show_pattern', $this->switcher(__('Show Pattern', 'amaley-discovery-engine'), 'yes'));
        $this->add_control('pattern_type', array(
            'label' => __('Pattern Type', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'geometric',
            'options' => array(
                'geometric' => __('Geometric Circles', 'amaley-discovery-engine'),
                'mountain' => __('Mountain Lines', 'amaley-discovery-engine'),
                'orb' => __('Soft Orb', 'amaley-discovery-engine'),
                'none' => __('None', 'amaley-discovery-engine'),
            ),
            'condition' => array('show_pattern' => 'yes'),
        ));
        $this->add_control('show_visual_image', $this->switcher(__('Show Visual Image', 'amaley-discovery-engine'), 'no'));
        $this->add_control('visual_image', array(
            'label' => __('Image', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'condition' => array('show_visual_image' => 'yes'),
        ));
        $this->add_control('image_alt', array(
            'label' => __('Image Alt Text', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Amaley products', 'amaley-discovery-engine'),
            'condition' => array('show_visual_image' => 'yes'),
        ));
        $this->end_controls_section();
    }

    private function register_style_controls(){
        $root = '{{WRAPPER}} .amaley-de-shop-hero';
        $inner = $root . ' .amaley-de-shop-hero__inner';
        $content = $root . ' .amaley-de-shop-hero__content';
        $breadcrumb = $root . ' .amaley-de-shop-hero__breadcrumb';
        $kicker = $root . ' .amaley-de-shop-hero__kicker';
        $heading = $root . ' .amaley-de-shop-hero__heading';
        $accent = $root . ' .amaley-de-shop-hero__heading-accent';
        $desc = $root . ' .amaley-de-shop-hero__description';
        $stats = $root . ' .amaley-de-shop-hero__stats';
        $stat = $root . ' .amaley-de-shop-hero__stat';
        $primary = $root . ' .amaley-de-shop-hero__button--primary';
        $secondary = $root . ' .amaley-de-shop-hero__button--secondary';
        $pattern = $root . ' .amaley-de-shop-hero__pattern';
        $visual = $root . ' .amaley-de-shop-hero__visual';

        $this->start_controls_section('style_section_layout', array(
            'label' => __('Section / Layout', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->start_controls_tabs('style_section_layout_tabs');
        $this->start_controls_tab('style_section_tab_box', array('label' => __('Section', 'amaley-discovery-engine')));
        $this->add_control('section_bg', array(
            'label' => __('Background', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($root => 'background-color: {{VALUE}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name' => 'section_border',
            'selector' => $root,
        ));
        $this->add_responsive_control('section_radius', array(
            'label' => __('Border Radius', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','%','em'),
            'selectors' => array($root => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'section_shadow',
            'selector' => $root,
        ));
        $this->add_responsive_control('section_padding', array(
            'label' => __('Padding', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','%','em','rem'),
            'selectors' => array($root => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('section_margin', array(
            'label' => __('Margin', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','%','em','rem'),
            'selectors' => array('{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('section_min_height', array(
            'label' => __('Min Height', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','vh'),
            'range' => array('px' => array('min' => 120, 'max' => 760), 'vh' => array('min' => 10, 'max' => 100)),
            'selectors' => array($root => 'min-height: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('inner_max_width', array(
            'label' => __('Inner Max Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','%'),
            'range' => array('px' => array('min' => 720, 'max' => 1800), '%' => array('min' => 40, 'max' => 100)),
            'selectors' => array($inner => 'max-width: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('content_max_width', array(
            'label' => __('Content Max Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','%'),
            'range' => array('px' => array('min' => 240, 'max' => 1000), '%' => array('min' => 20, 'max' => 100)),
            'selectors' => array($content => 'max-width: {{SIZE}}{{UNIT}};'),
        ));
        $this->end_controls_tab();

        $this->start_controls_tab('style_section_tab_alignment', array('label' => __('Alignment', 'amaley-discovery-engine')));
        $this->add_responsive_control('content_position', array(
            'label' => __('Content Block Position', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-left'),
                'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-center'),
                'right' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-right'),
                'stretch' => array('title' => __('Stretch', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-stretch'),
            ),
            'default' => 'left',
            'selectors_dictionary' => array(
                'left' => 'margin-left:0; margin-right:auto;',
                'center' => 'margin-left:auto; margin-right:auto;',
                'right' => 'margin-left:auto; margin-right:0;',
                'stretch' => 'margin-left:0; margin-right:0; max-width:none;',
            ),
            'selectors' => array($content => '{{VALUE}}'),
        ));
        $this->add_responsive_control('text_align', array(
            'label' => __('Text Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-left'),
                'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-center'),
                'right' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-right'),
            ),
            'default' => 'left',
            'selectors' => array($content => 'text-align: {{VALUE}};'),
        ));
        $this->add_responsive_control('stats_align', array(
            'label' => __('Stats Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-left'),
                'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-center'),
                'flex-end' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-right'),
            ),
            'default' => 'flex-start',
            'selectors' => array($stats => 'justify-content: {{VALUE}};'),
        ));
        $this->add_responsive_control('buttons_align', array(
            'label' => __('Buttons Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-left'),
                'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-center'),
                'flex-end' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-h-align-right'),
            ),
            'default' => 'flex-start',
            'selectors' => array($root . ' .amaley-de-shop-hero__buttons' => 'justify-content: {{VALUE}};'),
        ));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_background_pattern', array(
            'label' => __('Background / Visual', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->add_control('overlay_color', array(
            'label' => __('Overlay Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($root . '::before' => 'background: {{VALUE}};'),
        ));
        $this->add_responsive_control('overlay_opacity', array(
            'label' => __('Overlay Opacity', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array('px' => array('min' => 0, 'max' => 1, 'step' => .01)),
            'selectors' => array($root . '::before' => 'opacity: {{SIZE}};'),
        ));
        $this->add_control('pattern_color', array(
            'label' => __('Pattern Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($pattern => 'color: {{VALUE}}; border-color: {{VALUE}};'),
        ));
        $this->add_responsive_control('pattern_opacity', array(
            'label' => __('Pattern Opacity', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array('px' => array('min' => 0, 'max' => 1, 'step' => .01)),
            'selectors' => array($pattern => 'opacity: {{SIZE}};'),
        ));
        $this->add_responsive_control('visual_width', array(
            'label' => __('Visual Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px','%'),
            'range' => array('px' => array('min' => 120, 'max' => 720), '%' => array('min' => 10, 'max' => 80)),
            'selectors' => array($visual => 'width: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('visual_opacity', array(
            'label' => __('Visual Opacity', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array('px' => array('min' => 0, 'max' => 1, 'step' => .01)),
            'selectors' => array($visual => 'opacity: {{SIZE}};'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('style_breadcrumb', array('label' => __('Breadcrumb', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('breadcrumb_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($breadcrumb => 'color: {{VALUE}};')));
        $this->add_control('breadcrumb_link_color', array('label'=>__('Link Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($breadcrumb . ' a' => 'color: {{VALUE}};')));
        $this->add_control('breadcrumb_sep_color', array('label'=>__('Separator Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($breadcrumb . ' .amaley-de-shop-hero__breadcrumb-sep' => 'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'breadcrumb_typography','selector'=>$breadcrumb));
        $this->add_responsive_control('breadcrumb_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($breadcrumb=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_kicker', array('label' => __('Kicker', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('kicker_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($kicker=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'kicker_typography','selector'=>$kicker));
        $this->add_responsive_control('kicker_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($kicker=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_heading', array('label' => __('Heading', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('heading_color', array('label'=>__('Heading Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($heading=>'color: {{VALUE}};')));
        $this->add_control('accent_color', array('label'=>__('Accent Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($accent=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'heading_typography','selector'=>$heading));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'accent_typography','selector'=>$accent));
        $this->add_responsive_control('heading_margin', array('label'=>__('Heading Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($heading=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_description', array('label' => __('Description', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('description_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($desc=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'description_typography','selector'=>$desc));
        $this->add_responsive_control('description_width', array('label'=>__('Max Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>120,'max'=>900), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($desc=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('description_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($desc=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_stats', array('label' => __('Stats', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('stats_gap', array('label'=>__('Stats Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','em'), 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($stats=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('stats_margin', array('label'=>__('Stats Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($stats=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('stat_number_color', array('label'=>__('Number Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root . ' .amaley-de-shop-hero__stat-number'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'stat_number_typography','selector'=>$root . ' .amaley-de-shop-hero__stat-number'));
        $this->add_control('stat_label_color', array('label'=>__('Label Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root . ' .amaley-de-shop-hero__stat-label'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'stat_label_typography','selector'=>$root . ' .amaley-de-shop-hero__stat-label'));
        $this->add_responsive_control('stat_padding', array('label'=>__('Item Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($stat=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_buttons', array('label' => __('Buttons', 'amaley-discovery-engine'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('button_gap', array('label'=>__('Button Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','em'), 'range'=>array('px'=>array('min'=>0,'max'=>60)), 'selectors'=>array($root . ' .amaley-de-shop-hero__buttons'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_margin', array('label'=>__('Button Row Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($root . ' .amaley-de-shop-hero__buttons'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'button_typography','selector'=>$root . ' .amaley-de-shop-hero__button'));
        $this->add_responsive_control('button_padding', array('label'=>__('Button Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($root . ' .amaley-de-shop-hero__button'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_radius', array('label'=>__('Button Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%','em'), 'selectors'=>array($root . ' .amaley-de-shop-hero__button'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->start_controls_tabs('button_state_tabs');
        $this->start_controls_tab('primary_normal', array('label'=>__('Primary', 'amaley-discovery-engine')));
        $this->add_control('primary_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary=>'background-color: {{VALUE}};')));
        $this->add_control('primary_color', array('label'=>__('Text Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary=>'color: {{VALUE}};')));
        $this->add_control('primary_border', array('label'=>__('Border Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('primary_hover', array('label'=>__('Primary Hover', 'amaley-discovery-engine')));
        $this->add_control('primary_hover_bg', array('label'=>__('Hover Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary . ':hover'=>'background-color: {{VALUE}};')));
        $this->add_control('primary_hover_color', array('label'=>__('Hover Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary . ':hover'=>'color: {{VALUE}};')));
        $this->add_control('primary_hover_border', array('label'=>__('Hover Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($primary . ':hover'=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('secondary_normal', array('label'=>__('Secondary', 'amaley-discovery-engine')));
        $this->add_control('secondary_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary=>'background-color: {{VALUE}};')));
        $this->add_control('secondary_color', array('label'=>__('Text Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary=>'color: {{VALUE}};')));
        $this->add_control('secondary_border', array('label'=>__('Border Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('secondary_hover', array('label'=>__('Secondary Hover', 'amaley-discovery-engine')));
        $this->add_control('secondary_hover_bg', array('label'=>__('Hover Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary . ':hover'=>'background-color: {{VALUE}};')));
        $this->add_control('secondary_hover_color', array('label'=>__('Hover Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary . ':hover'=>'color: {{VALUE}};')));
        $this->add_control('secondary_hover_border', array('label'=>__('Hover Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($secondary . ':hover'=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    private function add_device_hide_control($id, $label, $device){
        $device_label = ucfirst($device);
        $this->add_control($id . '_' . $device, array(
            'label' => sprintf(__('Hide %1$s on %2$s', 'amaley-discovery-engine'), $label, $device_label),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'prefix_class' => 'amaley-de-shop-hero-hide-' . $id . '-' . $device . '-',
        ));
    }

    private function register_advanced_controls(){
        $this->start_controls_section('advanced_visibility_layout', array(
            'label' => __('Visibility / Responsive Layout', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
        ));
        $this->start_controls_tabs('hero_visibility_device_tabs');
        foreach (array('desktop' => __('Desktop', 'amaley-discovery-engine'), 'tablet' => __('Tablet', 'amaley-discovery-engine'), 'mobile' => __('Mobile', 'amaley-discovery-engine')) as $device => $title) {
            $this->start_controls_tab('hero_visibility_' . $device, array('label' => $title));
            $this->add_device_hide_control('widget', __('Whole Hero', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('breadcrumb', __('Breadcrumb', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('kicker', __('Kicker', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('heading', __('Heading', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('description', __('Description', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('stats', __('Stats', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('buttons', __('Buttons', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('pattern', __('Pattern', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('visual', __('Visual Image', 'amaley-discovery-engine'), $device);
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->add_control('hero_mobile_buttons_full', array(
            'label' => __('Mobile Buttons Full Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
            'separator' => 'before',
            'prefix_class' => 'amaley-de-shop-hero-mobile-buttons-full-',
        ));
        $this->add_control('hero_mobile_stack_center', array(
            'label' => __('Mobile Auto Center Content', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => '',
            'prefix_class' => 'amaley-de-shop-hero-mobile-center-',
        ));
        $this->end_controls_section();
    }

    private function dynamic_stats(){
        $product_count = 0;
        if (post_type_exists('product')) {
            $counts = wp_count_posts('product');
            $product_count = isset($counts->publish) ? (int) $counts->publish : 0;
        }
        $cluster_count = 0;
        foreach (array('amaley_cluster','cluster') as $pt) {
            if (post_type_exists($pt)) { $c = wp_count_posts($pt); $cluster_count = isset($c->publish) ? (int) $c->publish : 0; break; }
        }
        $shg_count = 0;
        foreach (array('amaley_shg','shg') as $pt) {
            if (post_type_exists($pt)) { $c = wp_count_posts($pt); $shg_count = isset($c->publish) ? (int) $c->publish : 0; break; }
        }
        return array(
            array('number' => $product_count, 'label' => __('Products', 'amaley-discovery-engine')),
            array('number' => $cluster_count, 'label' => __('Clusters', 'amaley-discovery-engine')),
            array('number' => $shg_count, 'label' => __('SHGs', 'amaley-discovery-engine')),
        );
    }

    private function print_link_attrs($link){
        if (empty($link['url'])) { return ''; }
        $attrs = ' href="' . esc_url($link['url']) . '"';
        if (!empty($link['is_external'])) { $attrs .= ' target="_blank"'; }
        if (!empty($link['nofollow'])) { $attrs .= ' rel="nofollow"'; }
        return $attrs;
    }

    protected function render(){
        $s = $this->get_settings_for_display();
        $pattern_type = !empty($s['pattern_type']) ? sanitize_html_class($s['pattern_type']) : 'geometric';
        echo '<section class="amaley-de-shop-hero amaley-de-shop-hero--pattern-' . esc_attr($pattern_type) . '">';
        if ('yes' === ($s['show_pattern'] ?? '')) {
            echo '<div class="amaley-de-shop-hero__pattern" aria-hidden="true"></div>';
        }
        if ('yes' === ($s['show_visual_image'] ?? '') && !empty($s['visual_image']['url'])) {
            echo '<figure class="amaley-de-shop-hero__visual"><img src="' . esc_url($s['visual_image']['url']) . '" alt="' . esc_attr($s['image_alt'] ?? '') . '"></figure>';
        }
        echo '<div class="amaley-de-shop-hero__inner"><div class="amaley-de-shop-hero__content">';
        if ('yes' === ($s['show_breadcrumb'] ?? '')) {
            $home_link = !empty($s['breadcrumb_home_link']['url']) ? $s['breadcrumb_home_link'] : array('url' => home_url('/'));
            echo '<nav class="amaley-de-shop-hero__breadcrumb" aria-label="' . esc_attr__('Breadcrumb', 'amaley-discovery-engine') . '">';
            echo '<a' . $this->print_link_attrs($home_link) . '>' . esc_html($s['breadcrumb_home'] ?? 'Home') . '</a>';
            echo '<span class="amaley-de-shop-hero__breadcrumb-sep">›</span>';
            echo '<span>' . esc_html($s['breadcrumb_current'] ?? '') . '</span>';
            echo '</nav>';
        }
        if ('yes' === ($s['show_kicker'] ?? '') && !empty($s['kicker'])) {
            echo '<div class="amaley-de-shop-hero__kicker">' . esc_html($s['kicker']) . '</div>';
        }
        if ('yes' === ($s['show_heading'] ?? '')) {
            echo '<h1 class="amaley-de-shop-hero__heading">';
            echo esc_html($s['heading_before'] ?? '');
            if ('yes' === ($s['show_heading_accent'] ?? '') && !empty($s['heading_accent'])) { echo ' <span class="amaley-de-shop-hero__heading-accent">' . esc_html($s['heading_accent']) . '</span>'; }
            if (!empty($s['heading_after'])) { echo ' ' . esc_html($s['heading_after']); }
            echo '</h1>';
        }
        if ('yes' === ($s['show_description'] ?? '') && !empty($s['description'])) {
            echo '<p class="amaley-de-shop-hero__description">' . esc_html($s['description']) . '</p>';
        }
        if ('yes' === ($s['show_stats'] ?? '')) {
            $stats = ('dynamic' === ($s['stats_source'] ?? 'manual')) ? $this->dynamic_stats() : (is_array($s['manual_stats'] ?? null) ? $s['manual_stats'] : array());
            if (!empty($stats)) {
                echo '<div class="amaley-de-shop-hero__stats">';
                foreach ($stats as $stat_item) {
                    if (isset($stat_item['show_stat']) && 'yes' !== $stat_item['show_stat']) { continue; }
                    $number = isset($stat_item['number']) ? $stat_item['number'] : '';
                    $label = isset($stat_item['label']) ? $stat_item['label'] : '';
                    $has_link = !empty($stat_item['link']['url']);
                    echo $has_link ? '<a class="amaley-de-shop-hero__stat"' . $this->print_link_attrs($stat_item['link']) . '>' : '<div class="amaley-de-shop-hero__stat">';
                    echo '<span class="amaley-de-shop-hero__stat-number">' . esc_html($number) . '</span>';
                    echo '<span class="amaley-de-shop-hero__stat-label">' . esc_html($label) . '</span>';
                    echo $has_link ? '</a>' : '</div>';
                }
                echo '</div>';
            }
        }
        $buttons = '';
        if ('yes' === ($s['show_primary_button'] ?? '') && !empty($s['primary_button_text']) && !empty($s['primary_button_link']['url'])) {
            $buttons .= '<a class="amaley-de-shop-hero__button amaley-de-shop-hero__button--primary"' . $this->print_link_attrs($s['primary_button_link']) . '>' . esc_html($s['primary_button_text']) . '</a>';
        }
        if ('yes' === ($s['show_secondary_button'] ?? '') && !empty($s['secondary_button_text']) && !empty($s['secondary_button_link']['url'])) {
            $buttons .= '<a class="amaley-de-shop-hero__button amaley-de-shop-hero__button--secondary"' . $this->print_link_attrs($s['secondary_button_link']) . '>' . esc_html($s['secondary_button_text']) . '</a>';
        }
        if ($buttons) { echo '<div class="amaley-de-shop-hero__buttons">' . $buttons . '</div>'; }
        echo '</div></div></section>';
    }
}
