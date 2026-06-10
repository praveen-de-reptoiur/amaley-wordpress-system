<?php
if (!defined('ABSPATH')) { exit; }

class Amaley_DE_Elementor_Shop_Strip_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_shop_strip'; }
    public function get_title(){ return __('Amaley Shop Strip', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-info-box'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    public function get_keywords(){ return array('amaley','shop','strip','trust','navigation','collections'); }
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
        $this->start_controls_section('content_strip', array(
            'label' => __('Strip Content', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('strip_mode', array(
            'label' => __('Strip Mode', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'trust',
            'options' => array(
                'trust' => __('Trust Strip', 'amaley-discovery-engine'),
                'navigation' => __('Collection Navigation', 'amaley-discovery-engine'),
                'mixed' => __('Mixed', 'amaley-discovery-engine'),
            ),
        ));
        $this->add_control('show_heading', $this->switcher(__('Mini Heading Block', 'amaley-discovery-engine'), 'no'));
        $this->add_control('show_kicker', $this->switcher(__('Kicker', 'amaley-discovery-engine'), 'yes', array('show_heading' => 'yes')));
        $this->add_control('kicker', array(
            'label' => __('Kicker', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Why Amaley', 'amaley-discovery-engine'),
            'condition' => array('show_heading' => 'yes', 'show_kicker' => 'yes'),
        ));
        $this->add_control('show_strip_title', $this->switcher(__('Heading Text', 'amaley-discovery-engine'), 'yes', array('show_heading' => 'yes')));
        $this->add_control('heading', array(
            'label' => __('Heading', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Traceable Himalayan products', 'amaley-discovery-engine'),
            'condition' => array('show_heading' => 'yes', 'show_strip_title' => 'yes'),
        ));
        $this->add_control('show_strip_description', $this->switcher(__('Description', 'amaley-discovery-engine'), 'yes', array('show_heading' => 'yes')));
        $this->add_control('description', array(
            'label' => __('Description', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Browse products by purpose, source cluster, and community connection.', 'amaley-discovery-engine'),
            'condition' => array('show_heading' => 'yes', 'show_strip_description' => 'yes'),
        ));
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('show_item', array(
            'label' => __('Show Item', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ));
        $repeater->add_control('show_icon', array(
            'label' => __('Show Icon / Image', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ));
        $repeater->add_control('icon_type', array(
            'label' => __('Icon Type', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => array(
                'none' => __('None', 'amaley-discovery-engine'),
                'icon' => __('Elementor Icon', 'amaley-discovery-engine'),
                'image' => __('Image', 'amaley-discovery-engine'),
            ),
        ));
        $repeater->add_control('selected_icon', array(
            'label' => __('Icon', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => array('value' => 'fas fa-seedling', 'library' => 'fa-solid'),
            'condition' => array('show_icon' => 'yes', 'icon_type' => 'icon'),
        ));
        $repeater->add_control('image', array(
            'label' => __('Image', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'condition' => array('show_icon' => 'yes', 'icon_type' => 'image'),
        ));
        $repeater->add_control('show_title', array(
            'label' => __('Show Title', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ));
        $repeater->add_control('title', array(
            'label' => __('Title', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Traceable Source', 'amaley-discovery-engine'),
            'label_block' => true,
            'condition' => array('show_title' => 'yes'),
        ));
        $repeater->add_control('show_desc', array(
            'label' => __('Show Description', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ));
        $repeater->add_control('desc', array(
            'label' => __('Description', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Linked to source clusters and communities.', 'amaley-discovery-engine'),
            'condition' => array('show_desc' => 'yes'),
        ));
        $repeater->add_control('link', array(
            'label' => __('Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
        ));
        $this->add_control('items', array(
            'label' => __('Strip Items', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => array(
                array('title' => __('Traceable to Source Clusters', 'amaley-discovery-engine'), 'desc' => __('Every product is connected to a region, cluster, or maker story.', 'amaley-discovery-engine'), 'icon_type' => 'icon', 'show_item' => 'yes', 'show_icon' => 'yes', 'show_title' => 'yes', 'show_desc' => 'yes'),
                array('title' => __('Women SHG Linked', 'amaley-discovery-engine'), 'desc' => __('Built around community enterprises and local livelihoods.', 'amaley-discovery-engine'), 'icon_type' => 'icon', 'show_item' => 'yes', 'show_icon' => 'yes', 'show_title' => 'yes', 'show_desc' => 'yes'),
                array('title' => __('Small-Batch Himalayan', 'amaley-discovery-engine'), 'desc' => __('Food, craft, and wellness products from Himalayan value chains.', 'amaley-discovery-engine'), 'icon_type' => 'icon', 'show_item' => 'yes', 'show_icon' => 'yes', 'show_title' => 'yes', 'show_desc' => 'yes'),
                array('title' => __('Gifts & Daily Use', 'amaley-discovery-engine'), 'desc' => __('Made for households, hampers, stores, and thoughtful gifting.', 'amaley-discovery-engine'), 'icon_type' => 'icon', 'show_item' => 'yes', 'show_icon' => 'yes', 'show_title' => 'yes', 'show_desc' => 'yes'),
            ),
            'title_field' => '{{{ title }}}',
        ));
        $this->end_controls_section();
    }

    private function register_style_controls(){
        $root = '{{WRAPPER}} .amaley-de-shop-strip';
        $inner = $root . ' .amaley-de-shop-strip__inner';
        $header = $root . ' .amaley-de-shop-strip__header';
        $items = $root . ' .amaley-de-shop-strip__items';
        $item = $root . ' .amaley-de-shop-strip__item';
        $icon = $root . ' .amaley-de-shop-strip__icon';
        $title = $root . ' .amaley-de-shop-strip__title';
        $desc = $root . ' .amaley-de-shop-strip__desc';

        $this->start_controls_section('style_section', array(
            'label' => __('Strip Section', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->start_controls_tabs('style_strip_section_tabs');
        $this->start_controls_tab('style_strip_box', array('label' => __('Box', 'amaley-discovery-engine')));
        $this->add_control('section_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root=>'background-color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'section_border','selector'=>$root));
        $this->add_responsive_control('section_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%','em'), 'selectors'=>array($root=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'section_shadow','selector'=>$root));
        $this->add_responsive_control('section_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%','em','rem'), 'selectors'=>array($root=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('section_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%','em','rem'), 'selectors'=>array('{{WRAPPER}}'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('style_strip_layout', array('label' => __('Layout', 'amaley-discovery-engine')));
        $this->add_responsive_control('inner_max_width', array('label'=>__('Inner Max Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>600,'max'=>1800), '%'=>array('min'=>40,'max'=>100)), 'selectors'=>array($inner=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('inner_position', array(
            'label' => __('Inner Position', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title'=>__('Left','amaley-discovery-engine'), 'icon'=>'eicon-h-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'), 'icon'=>'eicon-h-align-center'),
                'right' => array('title'=>__('Right','amaley-discovery-engine'), 'icon'=>'eicon-h-align-right'),
                'stretch' => array('title'=>__('Stretch','amaley-discovery-engine'), 'icon'=>'eicon-h-align-stretch'),
            ),
            'default' => 'center',
            'selectors_dictionary' => array(
                'left' => 'margin-left:0; margin-right:auto;',
                'center' => 'margin-left:auto; margin-right:auto;',
                'right' => 'margin-left:auto; margin-right:0;',
                'stretch' => 'margin-left:0; margin-right:0; max-width:none;',
            ),
            'selectors' => array($inner => '{{VALUE}}'),
        ));
        $this->add_responsive_control('item_min_height', array('label'=>__('Item Min Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','em','rem'), 'range'=>array('px'=>array('min'=>0,'max'=>320)), 'selectors'=>array($item=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('item_inner_gap', array('label'=>__('Item Inner Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','em'), 'range'=>array('px'=>array('min'=>0,'max'=>50)), 'selectors'=>array($item=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('item_content_align', array(
            'label' => __('Item Content Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array('title'=>__('Left','amaley-discovery-engine'), 'icon'=>'eicon-h-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'), 'icon'=>'eicon-h-align-center'),
                'flex-end' => array('title'=>__('Right','amaley-discovery-engine'), 'icon'=>'eicon-h-align-right'),
                'stretch' => array('title'=>__('Stretch','amaley-discovery-engine'), 'icon'=>'eicon-h-align-stretch'),
            ),
            'default' => 'flex-start',
            'selectors' => array($item => 'align-items: {{VALUE}};'),
        ));
        $this->add_responsive_control('item_vertical_align', array(
            'label' => __('Item Vertical Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'flex-start' => array('title'=>__('Top','amaley-discovery-engine'), 'icon'=>'eicon-v-align-top'),
                'center' => array('title'=>__('Middle','amaley-discovery-engine'), 'icon'=>'eicon-v-align-middle'),
                'flex-end' => array('title'=>__('Bottom','amaley-discovery-engine'), 'icon'=>'eicon-v-align-bottom'),
                'space-between' => array('title'=>__('Space Between','amaley-discovery-engine'), 'icon'=>'eicon-v-align-stretch'),
            ),
            'default' => 'flex-start',
            'selectors' => array($item => 'justify-content: {{VALUE}};'),
        ));

        $this->add_responsive_control('columns', array('label'=>__('Columns','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::NUMBER, 'default'=>4, 'tablet_default'=>2, 'mobile_default'=>1, 'min'=>1, 'max'=>6, 'selectors'=>array($items=>'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));')));
        $this->add_responsive_control('items_gap', array('label'=>__('Item Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','em'), 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($items=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('section_text_align', array(
            'label' => __('Text Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title'=>__('Left','amaley-discovery-engine'), 'icon'=>'eicon-text-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'), 'icon'=>'eicon-text-align-center'),
                'right' => array('title'=>__('Right','amaley-discovery-engine'), 'icon'=>'eicon-text-align-right'),
            ),
            'default' => 'left',
            'selectors' => array($root => 'text-align: {{VALUE}};'),
        ));
        $this->add_control('mobile_mode', array(
            'label' => __('Mobile Behaviour', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'stack',
            'options' => array(
                'stack' => __('Stack', 'amaley-discovery-engine'),
                'scroll' => __('Horizontal Scroll', 'amaley-discovery-engine'),
                'two_col' => __('2-column Grid', 'amaley-discovery-engine'),
            ),
        ));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_header', array('label'=>__('Mini Heading','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('header_gap', array('label'=>__('Header Bottom Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','em'), 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($header=>'margin-bottom: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('header_max_width', array('label'=>__('Header Max Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>160,'max'=>1000), '%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($header=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('header_position', array(
            'label' => __('Header Position', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title'=>__('Left','amaley-discovery-engine'), 'icon'=>'eicon-h-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'), 'icon'=>'eicon-h-align-center'),
                'right' => array('title'=>__('Right','amaley-discovery-engine'), 'icon'=>'eicon-h-align-right'),
                'stretch' => array('title'=>__('Stretch','amaley-discovery-engine'), 'icon'=>'eicon-h-align-stretch'),
            ),
            'default' => 'left',
            'selectors_dictionary' => array(
                'left' => 'margin-left:0; margin-right:auto;',
                'center' => 'margin-left:auto; margin-right:auto;',
                'right' => 'margin-left:auto; margin-right:0;',
                'stretch' => 'margin-left:0; margin-right:0; max-width:none;',
            ),
            'selectors' => array($header => '{{VALUE}}'),
        ));
        $this->add_responsive_control('header_text_align', array(
            'label' => __('Header Text Alignment', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title'=>__('Left','amaley-discovery-engine'), 'icon'=>'eicon-text-align-left'),
                'center' => array('title'=>__('Center','amaley-discovery-engine'), 'icon'=>'eicon-text-align-center'),
                'right' => array('title'=>__('Right','amaley-discovery-engine'), 'icon'=>'eicon-text-align-right'),
            ),
            'default' => 'left',
            'selectors' => array($header => 'text-align: {{VALUE}};'),
        ));

        $this->add_control('kicker_color', array('label'=>__('Kicker Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root . ' .amaley-de-shop-strip__kicker'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'kicker_typography','selector'=>$root . ' .amaley-de-shop-strip__kicker'));
        $this->add_control('heading_color', array('label'=>__('Heading Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root . ' .amaley-de-shop-strip__heading'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'heading_typography','selector'=>$root . ' .amaley-de-shop-strip__heading'));
        $this->add_control('header_desc_color', array('label'=>__('Description Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root . ' .amaley-de-shop-strip__header-desc'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'header_desc_typography','selector'=>$root . ' .amaley-de-shop-strip__header-desc'));
        $this->end_controls_section();

        $this->start_controls_section('style_item', array('label'=>__('Item Box','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('item_states');
        $this->start_controls_tab('item_normal', array('label'=>__('Normal','amaley-discovery-engine')));
        $this->add_control('item_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($item=>'background-color: {{VALUE}};')));
        $this->add_control('item_border_color', array('label'=>__('Border Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($item=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('item_hover', array('label'=>__('Hover','amaley-discovery-engine')));
        $this->add_control('item_hover_bg', array('label'=>__('Hover Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($item . ':hover'=>'background-color: {{VALUE}};')));
        $this->add_control('item_hover_border', array('label'=>__('Hover Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($item . ':hover'=>'border-color: {{VALUE}};')));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control('item_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%','em','rem'), 'selectors'=>array($item=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('item_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%','em'), 'selectors'=>array($item=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'item_shadow','selector'=>$item));
        $this->end_controls_section();

        $this->start_controls_section('style_icon', array('label'=>__('Icon / Image','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('icon_size', array('label'=>__('Icon Size','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','em'), 'range'=>array('px'=>array('min'=>10,'max'=>96)), 'selectors'=>array($icon=>'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
        $this->add_control('icon_color', array('label'=>__('Icon Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($icon=>'color: {{VALUE}};', $icon . ' svg'=>'fill: {{VALUE}};')));
        $this->add_control('icon_bg', array('label'=>__('Icon Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($icon=>'background-color: {{VALUE}};')));
        $this->add_responsive_control('icon_radius', array('label'=>__('Icon Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%','em'), 'selectors'=>array($icon=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('icon_margin', array('label'=>__('Icon Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($icon=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_title', array('label'=>__('Title', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('title_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($title=>'color: {{VALUE}};')));
        $this->add_control('title_hover_color', array('label'=>__('Hover Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($item . ':hover .amaley-de-shop-strip__title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'title_typography','selector'=>$title));
        $this->add_responsive_control('title_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($title=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_desc', array('label'=>__('Description', 'amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('desc_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($desc=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'desc_typography','selector'=>$desc));
        $this->add_responsive_control('desc_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','rem'), 'selectors'=>array($desc=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('hide_desc_mobile', array('label'=>__('Hide Description on Mobile','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'prefix_class'=>'amaley-de-shop-strip-hide-desc-mobile-'));
        $this->end_controls_section();
    }


    private function add_device_hide_control($id, $label, $device){
        $device_label = ucfirst($device);
        $this->add_control($id . '_' . $device, array(
            'label' => sprintf(__('Hide %1$s on %2$s', 'amaley-discovery-engine'), $label, $device_label),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'prefix_class' => 'amaley-de-shop-strip-hide-' . $id . '-' . $device . '-',
        ));
    }

    private function register_advanced_controls(){
        $this->start_controls_section('advanced_visibility_layout', array(
            'label' => __('Visibility / Responsive Layout', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
        ));
        $this->start_controls_tabs('strip_visibility_device_tabs');
        foreach (array('desktop' => __('Desktop', 'amaley-discovery-engine'), 'tablet' => __('Tablet', 'amaley-discovery-engine'), 'mobile' => __('Mobile', 'amaley-discovery-engine')) as $device => $title) {
            $this->start_controls_tab('strip_visibility_' . $device, array('label' => $title));
            $this->add_device_hide_control('widget', __('Whole Strip', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('header', __('Mini Heading Block', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('kicker', __('Kicker', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('heading', __('Heading', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('description', __('Header Description', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('items', __('Items Grid', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('icon', __('Item Icons', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('title', __('Item Titles', 'amaley-discovery-engine'), $device);
            $this->add_device_hide_control('desc', __('Item Descriptions', 'amaley-discovery-engine'), $device);
            $this->end_controls_tab();
        }
        $this->end_controls_tabs();
        $this->add_control('strip_mobile_equal_height', array(
            'label' => __('Mobile Equal Height Items', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
            'separator' => 'before',
            'prefix_class' => 'amaley-de-shop-strip-mobile-equal-height-',
        ));
        $this->end_controls_section();
    }

    private function link_attrs($link){
        if (empty($link['url'])) { return ''; }
        $attrs = ' href="' . esc_url($link['url']) . '"';
        if (!empty($link['is_external'])) { $attrs .= ' target="_blank"'; }
        if (!empty($link['nofollow'])) { $attrs .= ' rel="nofollow"'; }
        return $attrs;
    }

    private function render_icon($item){
        if (empty($item['icon_type']) || 'none' === $item['icon_type']) { return ''; }
        if ('image' === $item['icon_type'] && !empty($item['image']['url'])) {
            return '<span class="amaley-de-shop-strip__icon amaley-de-shop-strip__icon--image"><img src="' . esc_url($item['image']['url']) . '" alt=""></span>';
        }
        if ('icon' === $item['icon_type'] && !empty($item['selected_icon']['value'])) {
            ob_start();
            \Elementor\Icons_Manager::render_icon($item['selected_icon'], array('aria-hidden' => 'true'));
            return '<span class="amaley-de-shop-strip__icon amaley-de-shop-strip__icon--elementor">' . ob_get_clean() . '</span>';
        }
        return '';
    }

    protected function render(){
        $s = $this->get_settings_for_display();
        $mode = !empty($s['strip_mode']) ? sanitize_html_class($s['strip_mode']) : 'trust';
        $mobile_mode = !empty($s['mobile_mode']) ? sanitize_html_class($s['mobile_mode']) : 'stack';
        echo '<section class="amaley-de-shop-strip amaley-de-shop-strip--' . esc_attr($mode) . ' amaley-de-shop-strip--mobile-' . esc_attr($mobile_mode) . '"><div class="amaley-de-shop-strip__inner">';
        if ('yes' === ($s['show_heading'] ?? '')) {
            echo '<div class="amaley-de-shop-strip__header">';
            if ('yes' === ($s['show_kicker'] ?? '') && !empty($s['kicker'])) { echo '<div class="amaley-de-shop-strip__kicker">' . esc_html($s['kicker']) . '</div>'; }
            if ('yes' === ($s['show_strip_title'] ?? '') && !empty($s['heading'])) { echo '<h2 class="amaley-de-shop-strip__heading">' . esc_html($s['heading']) . '</h2>'; }
            if ('yes' === ($s['show_strip_description'] ?? '') && !empty($s['description'])) { echo '<p class="amaley-de-shop-strip__header-desc">' . esc_html($s['description']) . '</p>'; }
            echo '</div>';
        }
        if (!empty($s['items']) && is_array($s['items'])) {
            echo '<div class="amaley-de-shop-strip__items">';
            foreach ($s['items'] as $item) {
                if (isset($item['show_item']) && 'yes' !== $item['show_item']) { continue; }
                $has_link = !empty($item['link']['url']);
                echo $has_link ? '<a class="amaley-de-shop-strip__item"' . $this->link_attrs($item['link']) . '>' : '<div class="amaley-de-shop-strip__item">';
                if ('yes' === ($item['show_icon'] ?? 'yes')) { echo $this->render_icon($item); }
                if ('yes' === ($item['show_title'] ?? 'yes') && !empty($item['title'])) { echo '<h3 class="amaley-de-shop-strip__title">' . esc_html($item['title']) . '</h3>'; }
                if ('yes' === ($item['show_desc'] ?? 'yes') && !empty($item['desc'])) { echo '<p class="amaley-de-shop-strip__desc">' . esc_html($item['desc']) . '</p>'; }
                echo $has_link ? '</a>' : '</div>';
            }
            echo '</div>';
        }
        echo '</div></section>';
    }
}
