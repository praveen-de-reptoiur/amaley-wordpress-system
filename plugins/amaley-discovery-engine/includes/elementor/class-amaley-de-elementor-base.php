<?php
if (!defined('ABSPATH')) { exit; }

abstract class Amaley_DE_Elementor_Base_Widget extends \Elementor\Widget_Base {
    abstract protected function get_discovery_type();
    abstract protected function get_default_heading();
    abstract protected function get_default_kicker();
    protected function get_default_filter_position() { return 'left'; }
    protected function get_default_desktop_filter_position() { return $this->get_default_filter_position(); }
    protected function get_default_tablet_filter_position() { return 'top'; }
    protected function get_default_mobile_filter_position() { return 'top'; }
    protected function get_default_desktop_filter_mode() { return 'visible'; }
    protected function get_default_tablet_filter_mode() { return 'compact'; }
    protected function get_default_mobile_filter_mode() { return 'compact'; }
    protected function get_default_custom_wrapper_class() { return ''; }

    public function get_icon() { return 'eicon-filter'; }
    public function get_categories() { return array('amaley-discovery-engine'); }
    public function get_keywords() { return array('amaley','discovery','filter','products','collections','clusters','shg','members'); }
    public function get_style_depends() { if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }
    public function get_script_depends() { if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section('ade_heading_content', array(
            'label' => __('Heading Content','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('kicker', array(
            'label'       => __('Small Label / Kicker','amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $this->get_default_kicker(),
            'label_block' => true,
        ));
        $this->add_control('heading', array(
            'label'       => __('Main Heading','amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => $this->get_default_heading(),
            'label_block' => true,
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_query_filters', array(
            'label' => __('Query & Filters','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('per_page', array(
            'label' => __('Cards Per Page','amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::NUMBER,
            'default' => 9,
            'min' => 1,
            'max' => 96,
        ));
        $this->add_control('show_search', $this->switcher(__('Show Search','amaley-discovery-engine'), 'yes'));
        $this->add_control('show_categories', $this->switcher(__('Show Category Filter','amaley-discovery-engine'), 'yes'));
        $this->add_control('show_tags', $this->switcher(__('Show Tag Filter','amaley-discovery-engine'), 'yes'));
        $this->add_control('show_price', $this->switcher(__('Show Price Filter','amaley-discovery-engine'), 'yes'));
        $this->add_control('show_stock', $this->switcher(__('Show Stock Filter','amaley-discovery-engine'), 'yes'));
        $this->add_control('show_sort', $this->switcher(__('Show Sort','amaley-discovery-engine'), 'yes'));
        if ('products' === $this->get_discovery_type()) {
            foreach ($this->product_attribute_control_map() as $key => $data) {
                $this->add_control('show_attr_' . $key, $this->switcher(sprintf(__('Show %s Filter','amaley-discovery-engine'), $data['label']), in_array($key, array('cluster','shg','producer_maker'), true) ? 'yes' : 'no'));
            }
        }
        $this->add_control('default_sort', array(
            'label' => __('Default Sort','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest'=>__('Latest','amaley-discovery-engine'),
                'title'=>__('A to Z','amaley-discovery-engine'),
                'price_low'=>__('Price low-high','amaley-discovery-engine'),
                'price_high'=>__('Price high-low','amaley-discovery-engine'),
                'popular'=>__('Popular','amaley-discovery-engine'),
                'featured'=>__('Featured','amaley-discovery-engine'),
            ),
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_layout', array(
            'label' => __('Layout','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_responsive_control('columns_desktop', array(
            'label' => __('Columns','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 3,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'min' => 1,
            'max' => 6,
        ));
        $this->add_control('desktop_filter_position', array(
            'label' => __('Desktop Filter Position','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => $this->get_default_desktop_filter_position(),
            'options' => array('left'=>__('Left Sidebar','amaley-discovery-engine'), 'top'=>__('Top Bar','amaley-discovery-engine')),
        ));
        $this->add_control('tablet_filter_mode', array(
            'label' => __('Tablet Filter Mode','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => $this->get_default_tablet_filter_mode(),
            'options' => array('visible'=>__('Visible','amaley-discovery-engine'), 'compact'=>__('Compact','amaley-discovery-engine'), 'drawer'=>__('Drawer','amaley-discovery-engine')),
        ));
        $this->add_control('mobile_filter_mode', array(
            'label' => __('Mobile Filter Mode','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => $this->get_default_mobile_filter_mode(),
            'options' => array('visible'=>__('Visible','amaley-discovery-engine'), 'compact'=>__('Compact','amaley-discovery-engine'), 'drawer'=>__('Drawer','amaley-discovery-engine')),
        ));
        $this->add_control('custom_wrapper_class', array(
            'label' => __('Custom Wrapper Class','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => $this->get_default_custom_wrapper_class(),
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_card_renderer', array(
            'label' => __('Product Card Renderer','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));
        $this->add_control('card_renderer', array(
            'label' => __('Card Renderer','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'amaley_core_product_card',
            'options' => array(
                'amaley_core_product_card'=>__('Amaley Core Product Card — Select Template','amaley-discovery-engine'),
                'elementor_template'=>__('Legacy Elementor Template — Advanced Only','amaley-discovery-engine'),
                'marketplace_card'=>__('Discovery Native Marketplace Card','amaley-discovery-engine'),
                'default'=>__('Discovery Default Card','amaley-discovery-engine'),
            ),
        ));
        $this->add_control('amaley_core_product_card_template', array(
            'label' => __('Amaley Core Product Card Template','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'og_product_card_1',
            'options' => array('og_product_card_1'=>__('OG Product Card 1','amaley-discovery-engine')),
            'condition' => array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->add_control('elementor_template_id', array(
            'label' => __('Elementor Template ID','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => array('card_renderer'=>'elementor_template'),
        ));
        $this->add_control('marketplace_badge_text', array(
            'label' => __('Native Card Badge Text','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Bestseller',
            'condition' => array('card_renderer'=>'marketplace_card'),
        ));
        $this->add_control('marketplace_meta_text', array(
            'label' => __('Native Card Small Label','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Amaley Collection',
            'condition' => array('card_renderer'=>'marketplace_card'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_core_card_content', array(
            'label' => __('Selected OG Product Card — Content','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            'condition' => array('card_renderer'=>'amaley_core_product_card'),
        ));
        foreach (array(
            'show_image'=>'Show Image',
            'show_label'=>'Show Label',
            'show_title'=>'Show Title',
            'show_excerpt'=>'Show Description',
            'show_meta'=>'Show Price / Origin Meta Boxes',
            'show_tags'=>'Show Tags / Chips',
            'show_button'=>'Show Button',
        ) as $short => $label) {
            $this->add_control('amaley_dcrsf_' . $short, $this->switcher(__($label,'amaley-discovery-engine'), 'yes', array('card_renderer'=>'amaley_core_product_card')));
        }
        $this->add_control('amaley_dcrsf_label_text', array(
            'label'=>__('Label Text Override','amaley-discovery-engine'),
            'type'=>\Elementor\Controls_Manager::TEXT,
            'default'=>'',
            'placeholder'=>__('Product','amaley-discovery-engine'),
            'condition'=>array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->add_control('amaley_dcrsf_excerpt_words', array(
            'label'=>__('Description Word Limit','amaley-discovery-engine'),
            'type'=>\Elementor\Controls_Manager::NUMBER,
            'default'=>16,
            'min'=>6,
            'max'=>40,
            'condition'=>array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->add_control('amaley_dcrsf_button_text', array(
            'label'=>__('Button Text','amaley-discovery-engine'),
            'type'=>\Elementor\Controls_Manager::TEXT,
            'default'=>__('View Product','amaley-discovery-engine'),
            'condition'=>array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->end_controls_section();
    }

    private function register_style_controls() {
        $card = '{{WRAPPER}} .amaley-dcrsf-core-card-wrap > .amaley-card.amaley-card--product';
        $media = $card . ' > .amaley-card__media';
        $image = $media . ' > img';
        $body = $card . ' > .amaley-card__body';
        $label = $body . ' > .amaley-card__label';
        $title = $body . ' > .amaley-card__title';
        $excerpt = $body . ' > .amaley-card__excerpt';
        $meta = $body . ' .amaley-card__meta';
        $meta_item = $body . ' .amaley-card__meta-item';
        $meta_label = $body . ' .amaley-card__meta span';
        $meta_value = $body . ' .amaley-card__meta strong, ' . $body . ' .amaley-card__price, ' . $body . ' .amaley-card__price .amount, ' . $body . ' .amaley-card__price .woocommerce-Price-amount, ' . $body . ' .amaley-card__price bdi';
        $tags = $body . ' .amaley-card__tags';
        $tag = $body . ' .amaley-card__tags span';
        $button = $body . ' > .amaley-card__button';

        $this->start_controls_section('ade_style_section_heading', array(
            'label' => __('Section / Heading','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->add_control('ade_style_section_bg', array(
            'label' => __('Section Background','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1' => 'background-color: {{VALUE}};'),
        ));
        $this->add_control('ade_style_heading_color', array(
            'label' => __('Heading Color','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__heading' => 'color: {{VALUE}};'),
        ));
        $this->add_control('ade_style_heading_accent_color', array(
            'label' => __('Heading Accent Color','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__heading span' => 'color: {{VALUE}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'ade_style_heading_typography',
            'selector' => '{{WRAPPER}} .amaley-discovery-engine-v1__heading',
        ));
        $this->add_responsive_control('ade_style_section_padding', array(
            'label' => __('Section Padding','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','%','em'),
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_style_filters', array(
            'label' => __('Filters / Toolbar','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->add_control('ade_style_filter_bg', array(
            'label' => __('Filter Panel Background','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters' => 'background-color: {{VALUE}};'),
        ));
        $this->add_control('ade_style_filter_text', array(
            'label' => __('Filter Text Color','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters, {{WRAPPER}} .amaley-discovery-engine-v1__filters label' => 'color: {{VALUE}};'),
        ));
        $this->add_control('ade_style_filter_field_bg', array(
            'label' => __('Input Background','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters input, {{WRAPPER}} .amaley-discovery-engine-v1__filters select' => 'background-color: {{VALUE}};'),
        ));
        $this->add_control('ade_style_filter_field_border', array(
            'label' => __('Input Border Color','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters input, {{WRAPPER}} .amaley-discovery-engine-v1__filters select' => 'border-color: {{VALUE}};'),
        ));
        $this->add_responsive_control('ade_style_filter_radius', array(
            'label' => __('Filter Panel Radius','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>0,'max'=>60)),
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__filters' => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_style_grid', array(
            'label' => __('Grid / Spacing','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->add_responsive_control('ade_style_grid_gap', array(
            'label' => __('Grid Gap','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>0,'max'=>80)),
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1__grid' => 'gap: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('ade_style_sidebar_width', array(
            'label' => __('Sidebar Width','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>200,'max'=>420)),
            'selectors' => array('{{WRAPPER}} .amaley-discovery-engine-v1' => '--ade-sidebar-width: {{SIZE}}{{UNIT}};'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_style_core_card_layout', array(
            'label' => __('Selected OG Product Card — Layout','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->start_controls_tabs('ade_style_core_card_layout_tabs');
        $this->start_controls_tab('ade_style_core_card_layout_normal', array('label'=>__('Normal','amaley-discovery-engine')));
        $this->add_control('ade_style_core_card_bg', array(
            'label' => __('Card Background','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($card => 'background-color: {{VALUE}}; --amaley-card-paper: {{VALUE}};'),
        ));
        $this->add_control('ade_style_core_card_border_color', array(
            'label' => __('Border Color','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($card => 'border-color: {{VALUE}}; --amaley-card-border: {{VALUE}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'ade_style_core_card_shadow',
            'selector' => $card,
        ));
        $this->end_controls_tab();
        $this->start_controls_tab('ade_style_core_card_layout_hover', array('label'=>__('Hover','amaley-discovery-engine')));
        $this->add_control('ade_style_core_card_bg_hover', array(
            'label' => __('Card Hover Background','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($card . ':hover' => 'background-color: {{VALUE}};'),
        ));
        $this->add_control('ade_style_core_card_border_hover', array(
            'label' => __('Hover Border Color','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($card . ':hover' => 'border-color: {{VALUE}};'),
        ));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name' => 'ade_style_core_card_shadow_hover',
            'selector' => $card . ':hover',
        ));
        $this->add_responsive_control('ade_style_core_card_lift_hover', array(
            'label' => __('Hover Lift','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>0,'max'=>24)),
            'selectors' => array($card => 'transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease, background-color .22s ease;', $card . ':hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});'),
        ));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control('ade_style_core_card_radius', array(
            'label' => __('Card Radius','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>0,'max'=>60)),
            'separator' => 'before',
            'selectors' => array($card => 'border-radius: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('ade_style_core_card_min_height', array(
            'label' => __('Card Min Height','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>0,'max'=>720)),
            'selectors' => array($card => 'min-height: {{SIZE}}{{UNIT}};'),
        ));
        $this->add_responsive_control('ade_style_core_card_media_height', array(
            'label' => __('Image / Media Height','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>80,'max'=>420)),
            'selectors' => array($media => 'height: {{SIZE}}{{UNIT}} !important;'),
        ));
        $this->add_control('ade_style_core_card_media_bg', array(
            'label' => __('Image Placeholder Background','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array($media => 'background: {{VALUE}};'),
        ));
        $this->add_control('ade_style_core_card_image_fit', array(
            'label' => __('Image Fit','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array('' => __('Default','amaley-discovery-engine'), 'cover'=>__('Cover','amaley-discovery-engine'), 'contain'=>__('Contain','amaley-discovery-engine'), 'fill'=>__('Fill','amaley-discovery-engine')),
            'selectors' => array($image => 'object-fit: {{VALUE}};'),
        ));
        $this->add_responsive_control('ade_style_core_card_body_padding', array(
            'label' => __('Body Padding','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px','em'),
            'selectors' => array($body => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));
        $this->add_responsive_control('ade_style_core_card_body_gap', array(
            'label' => __('Body Gap','amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px'=>array('min'=>0,'max'=>40)),
            'selectors' => array($body => 'gap: {{SIZE}}{{UNIT}};'),
        ));
        $this->end_controls_section();

        $this->start_controls_section('ade_style_core_card_text', array(
            'label' => __('Selected OG Product Card — Text','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->add_control('ade_style_core_card_label_color', array('label'=>__('Label Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($label=>'color: {{VALUE}}; --amaley-card-gold: {{VALUE}};')));
        $this->add_control('ade_style_core_card_label_hover_color', array('label'=>__('Label Hover Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($card . ':hover .amaley-card__label'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'ade_style_core_card_label_typography','selector'=>$label));
        $this->add_control('ade_style_core_card_title_color', array('label'=>__('Title Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'separator'=>'before', 'selectors'=>array($title=>'color: {{VALUE}}; --amaley-card-dark: {{VALUE}};')));
        $this->add_control('ade_style_core_card_title_hover_color', array('label'=>__('Title Hover Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($card . ':hover .amaley-card__title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'ade_style_core_card_title_typography','selector'=>$title));
        $this->add_responsive_control('ade_style_core_card_title_min_height', array('label'=>__('Title Min Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'range'=>array('px'=>array('min'=>0,'max'=>160)), 'selectors'=>array($title=>'min-height: {{SIZE}}{{UNIT}} !important;')));
        $this->add_control('ade_style_core_card_excerpt_color', array('label'=>__('Description Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'separator'=>'before', 'selectors'=>array($excerpt=>'color: {{VALUE}}; --amaley-card-muted: {{VALUE}};')));
        $this->add_control('ade_style_core_card_excerpt_hover_color', array('label'=>__('Description Hover Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($card . ':hover .amaley-card__excerpt'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'ade_style_core_card_excerpt_typography','selector'=>$excerpt));
        $this->add_responsive_control('ade_style_core_card_excerpt_min_height', array('label'=>__('Description Min Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'range'=>array('px'=>array('min'=>0,'max'=>160)), 'selectors'=>array($excerpt=>'min-height: {{SIZE}}{{UNIT}} !important;')));
        $this->end_controls_section();

        $this->start_controls_section('ade_style_core_card_meta_tags', array(
            'label' => __('Selected OG Product Card — Meta & Tags','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->add_responsive_control('ade_style_core_card_meta_gap', array('label'=>__('Meta Box Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'range'=>array('px'=>array('min'=>0,'max'=>30)), 'selectors'=>array($meta=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('ade_style_core_card_meta_bg', array('label'=>__('Meta Box Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($meta_item=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_meta_bg_hover', array('label'=>__('Meta Box Hover Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($card . ':hover .amaley-card__meta-item'=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_meta_border', array('label'=>__('Meta Box Border Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($meta_item=>'border-color: {{VALUE}};')));
        $this->add_responsive_control('ade_style_core_card_meta_radius', array('label'=>__('Meta Box Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'range'=>array('px'=>array('min'=>0,'max'=>40)), 'selectors'=>array($meta_item=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('ade_style_core_card_meta_padding', array('label'=>__('Meta Box Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($meta_item=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('ade_style_core_card_meta_label_color', array('label'=>__('Meta Label Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'separator'=>'before', 'selectors'=>array($meta_label=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'ade_style_core_card_meta_label_typography','selector'=>$meta_label));
        $this->add_control('ade_style_core_card_meta_value_color', array('label'=>__('Meta Value / Price Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($meta_value=>'color: {{VALUE}} !important;')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'ade_style_core_card_meta_value_typography','selector'=>$meta_value));
        $this->add_responsive_control('ade_style_core_card_tag_gap', array('label'=>__('Tag Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'separator'=>'before', 'range'=>array('px'=>array('min'=>0,'max'=>24)), 'selectors'=>array($tags=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('ade_style_core_card_tag_bg', array('label'=>__('Tag Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($tag=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_tag_text', array('label'=>__('Tag Text Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($tag=>'color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_tag_border', array('label'=>__('Tag Border Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($tag=>'border-color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_tag_bg_hover', array('label'=>__('Tag Hover Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($tag . ':hover'=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_tag_text_hover', array('label'=>__('Tag Hover Text Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($tag . ':hover'=>'color: {{VALUE}};')));
        $this->add_responsive_control('ade_style_core_card_tag_radius', array('label'=>__('Tag Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'range'=>array('px'=>array('min'=>0,'max'=>40)), 'selectors'=>array($tag=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'ade_style_core_card_tag_typography','selector'=>$tag));
        $this->end_controls_section();

        $this->start_controls_section('ade_style_core_card_button', array(
            'label' => __('Selected OG Product Card — Button','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array('card_renderer'=>'amaley_core_product_card'),
        ));
        $this->start_controls_tabs('ade_style_core_card_button_tabs');
        $this->start_controls_tab('ade_style_core_card_button_normal', array('label'=>__('Normal','amaley-discovery-engine')));
        $this->add_control('ade_style_core_card_button_bg', array('label'=>__('Button Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_button_text', array('label'=>__('Button Text Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>'color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_button_border', array('label'=>__('Button Border Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>'border-color: {{VALUE}}; border-style: solid; border-width: 1px;')));
        $this->end_controls_tab();
        $this->start_controls_tab('ade_style_core_card_button_hover', array('label'=>__('Hover','amaley-discovery-engine')));
        $this->add_control('ade_style_core_card_button_bg_hover', array('label'=>__('Button Hover Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button . ':hover, ' . $button . ':focus'=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_button_text_hover', array('label'=>__('Button Hover Text Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button . ':hover, ' . $button . ':focus'=>'color: {{VALUE}};')));
        $this->add_control('ade_style_core_card_button_border_hover', array('label'=>__('Button Hover Border Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button . ':hover, ' . $button . ':focus'=>'border-color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'ade_style_core_card_button_shadow_hover','selector'=>$button . ':hover, ' . $button . ':focus'));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'ade_style_core_card_button_typography','selector'=>$button));
        $this->add_responsive_control('ade_style_core_card_button_padding', array('label'=>__('Button Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'separator'=>'before', 'selectors'=>array($button=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('ade_style_core_card_button_radius', array('label'=>__('Button Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'range'=>array('px'=>array('min'=>0,'max'=>80)), 'selectors'=>array($button=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('ade_style_core_card_button_min_height', array('label'=>__('Button Min Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px'), 'range'=>array('px'=>array('min'=>24,'max'=>90)), 'selectors'=>array($button=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('ade_style_pagination', array(
            'label' => __('Pagination','amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));
        $this->add_control('ade_style_pagination_bg', array('label'=>__('Page Button Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array('{{WRAPPER}} .amaley-discovery-engine-v1__pagination a, {{WRAPPER}} .amaley-discovery-engine-v1__pagination span'=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_pagination_text', array('label'=>__('Page Button Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array('{{WRAPPER}} .amaley-discovery-engine-v1__pagination a, {{WRAPPER}} .amaley-discovery-engine-v1__pagination span'=>'color: {{VALUE}};')));
        $this->add_control('ade_style_pagination_active_bg', array('label'=>__('Active Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array('{{WRAPPER}} .amaley-discovery-engine-v1__pagination .is-active'=>'background-color: {{VALUE}};')));
        $this->add_control('ade_style_pagination_active_text', array('label'=>__('Active Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array('{{WRAPPER}} .amaley-discovery-engine-v1__pagination .is-active'=>'color: {{VALUE}};')));
        $this->end_controls_section();
    }

    protected function switcher($label, $default = 'yes', $condition = array()) {
        $control = array('label' => $label, 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => $default, 'return_value' => 'yes');
        if (!empty($condition)) { $control['condition'] = $condition; }
        return $control;
    }

    protected function product_attribute_control_map() {
        return array(
            'collection_type' => array('label' => __('Collection Type','amaley-discovery-engine'), 'taxonomy' => 'pa_collection-type'),
            'core_ingredient' => array('label' => __('Core Ingredient','amaley-discovery-engine'), 'taxonomy' => 'pa_ingredient'),
            'cluster' => array('label' => __('Cluster','amaley-discovery-engine'), 'taxonomy' => 'pa_cluster'),
            'producer_maker' => array('label' => __('Producer / Maker','amaley-discovery-engine'), 'taxonomy' => 'pa_producer-maker'),
            'region_cluster' => array('label' => __('Source Belt / Region Cluster','amaley-discovery-engine'), 'taxonomy' => 'pa_region-cluster'),
            'shg' => array('label' => __('SHG / Producer Group','amaley-discovery-engine'), 'taxonomy' => 'pa_shg'),
            'use_case' => array('label' => __('Use Case','amaley-discovery-engine'), 'taxonomy' => 'pa_use-case'),
            'village_source_location' => array('label' => __('Village / Source Location','amaley-discovery-engine'), 'taxonomy' => 'pa_village-source-location'),
        );
    }

    protected function render() {
        if (!function_exists('amaley_de_bootstrap')) { return; }
        $s = $this->get_settings_for_display();
        $settings = $s;
        $settings['type'] = $this->get_discovery_type();
        $settings['tablet_filter_position'] = 'top';
        $settings['mobile_filter_position'] = 'top';
        $settings['desktop_filter_mode'] = 'visible';
        echo amaley_de_bootstrap()->renderer->render($settings); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
