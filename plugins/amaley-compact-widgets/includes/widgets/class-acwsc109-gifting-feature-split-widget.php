<?php
/**
 * Amaley Gifting Feature Split widget.
 * Presentation-only. No data mutation.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) {
    return;
}

final class ACWSC109_Gifting_Feature_Split_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'acwsc109_gifting_feature_split'; }
    public function get_title() { return esc_html__( 'Amaley Gifting Feature Split', 'amaley-compact-widgets' ); }
    public function get_icon() { return 'eicon-gift'; }
    public function get_categories() { return array( 'amaley-compact' ); }
    public function get_style_depends() { return array( 'acwsc-three-sections' ); }
    public function get_keywords() { return array( 'amaley', 'gifting', 'corporate', 'feature', 'split', 'bulk' ); }

    protected function register_controls() {
        $this->content_controls();
        $this->checklist_controls();
        $this->image_controls();
        $this->trust_controls();
        $this->layout_controls();
        $this->section_style_controls();
        $this->heading_style_controls();
        $this->checklist_style_controls();
        $this->button_style_controls();
        $this->image_style_controls();
        $this->trust_style_controls();
    }

    private function default_checklist() {
        return array(
            array( 'text' => 'Custom hampers for teams & clients', 'icon' => array( 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ) ),
            array( 'text' => 'Co-branding and personalised notes', 'icon' => array( 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ) ),
            array( 'text' => 'Bulk orders with seamless delivery', 'icon' => array( 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ) ),
            array( 'text' => 'Sustainable, ethical and impact-driven', 'icon' => array( 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ) ),
        );
    }

    private function default_trust_items() {
        return array(
            array( 'title' => 'Thoughtful Gifting That Leaves an Impact', 'text' => '', 'icon' => array( 'value' => 'fas fa-seedling', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Strengthen Relationships with Meaning', 'text' => '', 'icon' => array( 'value' => 'far fa-handshake', 'library' => 'fa-regular' ) ),
            array( 'title' => 'Premium Quality, Always', 'text' => '', 'icon' => array( 'value' => 'fas fa-gift', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Ethical Choices for a Better Tomorrow', 'text' => '', 'icon' => array( 'value' => 'fas fa-globe-asia', 'library' => 'fa-solid' ) ),
        );
    }

    private function content_controls() {
        $this->start_controls_section( 'gift_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_kicker', array( 'label' => esc_html__( 'Show Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'kicker', array( 'label' => esc_html__( 'Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'FOR TEAMS, CLIENTS & PARTNERS', 'condition' => array( 'show_kicker' => 'yes' ) ) );
        $this->add_control( 'heading', array( 'label' => esc_html__( 'Heading', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Corporate Gifting Made Meaningful' ) );
        $this->add_control( 'accent_word', array( 'label' => esc_html__( 'Accent Word', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Meaningful' ) );
        $this->add_control( 'show_divider', array( 'label' => esc_html__( 'Show Decorative Divider', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_description', array( 'label' => esc_html__( 'Show Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Strengthen your relationships with gifts that reflect gratitude, thoughtfulness and a shared commitment to quality.', 'condition' => array( 'show_description' => 'yes' ) ) );
        $this->add_control( 'show_button', array( 'label' => esc_html__( 'Show CTA Button', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Corporate Gifting →', 'condition' => array( 'show_button' => 'yes' ) ) );
        $this->add_control( 'button_url', array( 'label' => esc_html__( 'Button Link', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => array( 'url' => '#' ), 'condition' => array( 'show_button' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function checklist_controls() {
        $this->start_controls_section( 'gift_checklist', array( 'label' => esc_html__( 'Checklist', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_checklist', array( 'label' => esc_html__( 'Show Checklist', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_check_icons', array( 'label' => esc_html__( 'Show Icons', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'show_checklist' => 'yes' ) ) );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::ICONS, 'default' => array( 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ) ) );
        $rep->add_control( 'text', array( 'label' => esc_html__( 'Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Checklist point' ) );
        $this->add_control( 'checklist', array( 'label' => esc_html__( 'Checklist Items', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ text }}}', 'default' => $this->default_checklist(), 'condition' => array( 'show_checklist' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function image_controls() {
        $this->start_controls_section( 'gift_image', array( 'label' => esc_html__( 'Image / Visual', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_image', array( 'label' => esc_html__( 'Show Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'image', array( 'label' => esc_html__( 'Main Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => array( 'url' => '' ), 'condition' => array( 'show_image' => 'yes' ) ) );
        $this->add_control( 'show_caption', array( 'label' => esc_html__( 'Show Image Caption', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ) );
        $this->add_control( 'caption', array( 'label' => esc_html__( 'Image Caption', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rooted in Goodness', 'condition' => array( 'show_caption' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function trust_controls() {
        $this->start_controls_section( 'gift_trust', array( 'label' => esc_html__( 'Bottom Value Strip', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_trust', array( 'label' => esc_html__( 'Show Bottom Strip', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_trust_icons', array( 'label' => esc_html__( 'Show Icons', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'show_trust' => 'yes' ) ) );
        $this->add_control( 'show_trust_text', array( 'label' => esc_html__( 'Show Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '', 'condition' => array( 'show_trust' => 'yes' ) ) );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::ICONS, 'default' => array( 'value' => 'fas fa-gift', 'library' => 'fa-solid' ) ) );
        $rep->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Value title' ) );
        $rep->add_control( 'text', array( 'label' => esc_html__( 'Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => '' ) );
        $this->add_control( 'trust_items', array( 'label' => esc_html__( 'Value Items', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}', 'default' => $this->default_trust_items(), 'condition' => array( 'show_trust' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function layout_controls() {
        $this->start_controls_section( 'gift_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'image_position', array( 'label' => esc_html__( 'Image Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'right', 'options' => array( 'right' => 'Text Left / Image Right', 'left' => 'Image Left / Text Right' ), 'prefix_class' => 'acwsc-gift--image-' ) );
        $this->add_control( 'mobile_order', array( 'label' => esc_html__( 'Mobile Stack Order', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'text-first', 'options' => array( 'text-first' => 'Text First', 'image-first' => 'Image First' ), 'prefix_class' => 'acwsc-gift--mobile-' ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'inner_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 760, 'max' => 1640 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__inner' => 'max-width: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'column_gap', array( 'label' => esc_html__( 'Column Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__main' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'text_width', array( 'label' => esc_html__( 'Text Width %', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 24, 'max' => 55 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__main' => '--acwsc-gift-text: {{SIZE}}% !important;' ) ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 140, 'max' => 620 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__image' => 'height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'trust_columns', array( 'label' => esc_html__( 'Bottom Strip Columns', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust-grid' => '--acwsc-gift-trust-cols: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function section_style_controls() {
        $this->start_controls_section( 'gift_section_style', array( 'label' => esc_html__( 'Section / Background', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift' => 'background: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function heading_style_controls() {
        $this->start_controls_section( 'gift_heading_style', array( 'label' => esc_html__( 'Heading / Text', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__kicker' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .acwsc-gift__kicker' ) );
        $this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__title em' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .acwsc-gift__title' ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__desc' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .acwsc-gift__desc' ) );
        $this->add_control( 'divider_color', array( 'label' => esc_html__( 'Divider Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__divider, {{WRAPPER}} .acwsc-gift__divider:before, {{WRAPPER}} .acwsc-gift__divider:after' => 'background: {{VALUE}} !important; border-color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function checklist_style_controls() {
        $this->start_controls_section( 'gift_check_style', array( 'label' => esc_html__( 'Checklist', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'check_icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__check-icon, {{WRAPPER}} .acwsc-gift__check-icon i, {{WRAPPER}} .acwsc-gift__check-icon svg, {{WRAPPER}} .acwsc-gift__check-icon svg *' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important; stroke: {{VALUE}} !important;' ) ) );
        $this->add_control( 'check_text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__check' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'check_typography', 'selector' => '{{WRAPPER}} .acwsc-gift__check' ) );
        $this->add_responsive_control( 'check_gap', array( 'label' => esc_html__( 'Checklist Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 36 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__checks' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function button_style_controls() {
        $this->start_controls_section( 'gift_button_style', array( 'label' => esc_html__( 'Button', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_border', array( 'label' => esc_html__( 'Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_hover_bg', array( 'label' => esc_html__( 'Hover Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn:hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_hover_text', array( 'label' => esc_html__( 'Hover Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn:hover' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_hover_border', array( 'label' => esc_html__( 'Hover Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn:hover' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 999 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__btn' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .acwsc-gift__btn' ) );
        $this->end_controls_section();
    }

    private function image_style_controls() {
        $this->start_controls_section( 'gift_image_style', array( 'label' => esc_html__( 'Image', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover'=>'Cover','contain'=>'Contain','fill'=>'Fill' ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__image img' => 'object-fit: {{VALUE}} !important;' ) ) );
        $this->add_control( 'gift_image_position', array( 'label' => esc_html__( 'Image Crop Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => array( 'center center'=>'Center Center','center top'=>'Center Top','center bottom'=>'Center Bottom','left center'=>'Left Center','right center'=>'Right Center' ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__image img' => 'object-position: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__image' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'image_shadow', 'selector' => '{{WRAPPER}} .acwsc-gift__image' ) );
        $this->add_control( 'caption_bg', array( 'label' => esc_html__( 'Caption Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__caption' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'caption_color', array( 'label' => esc_html__( 'Caption Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__caption' => 'color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function trust_style_controls() {
        $this->start_controls_section( 'gift_trust_style', array( 'label' => esc_html__( 'Bottom Value Strip', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'trust_bg', array( 'label' => esc_html__( 'Strip Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'trust_border', array( 'label' => esc_html__( 'Strip Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust, {{WRAPPER}} .acwsc-gift__trust-item' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'trust_padding', array( 'label' => esc_html__( 'Strip Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'trust_radius', array( 'label' => esc_html__( 'Strip Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'trust_icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust-icon, {{WRAPPER}} .acwsc-gift__trust-icon i, {{WRAPPER}} .acwsc-gift__trust-icon svg, {{WRAPPER}} .acwsc-gift__trust-icon svg *' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important; stroke: {{VALUE}} !important;' ) ) );
        $this->add_control( 'trust_title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust-title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'trust_title_typography', 'selector' => '{{WRAPPER}} .acwsc-gift__trust-title' ) );
        $this->add_control( 'trust_text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-gift__trust-text' => 'color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function yes( $v ) { return 'yes' === $v || '1' === (string) $v; }
    private function media_url( $raw ) { return is_array( $raw ) && isset( $raw['url'] ) ? (string) $raw['url'] : (string) $raw; }
    private function link_url( $raw ) { return is_array( $raw ) && isset( $raw['url'] ) ? (string) $raw['url'] : (string) $raw; }
    private function accent_title( $title, $accent ) { $title = esc_html( (string) $title ); $accent = trim( (string) $accent ); if ( '' === $accent ) { return $title; } $escaped = esc_html( $accent ); $pos = stripos( $title, $escaped ); return false === $pos ? $title : substr( $title, 0, $pos ) . '<em>' . substr( $title, $pos, strlen( $escaped ) ) . '</em>' . substr( $title, $pos + strlen( $escaped ) ); }
    private function render_icon( $icon ) { if ( ! empty( $icon['value'] ) && class_exists( '\\Elementor\\Icons_Manager' ) ) { ob_start(); \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); return ob_get_clean(); } return '<span aria-hidden="true">✓</span>'; }

    protected function render() {
        $s = $this->get_settings_for_display();
        if ( ! $this->yes( $s['show_section'] ?? 'yes' ) ) { return; }
        $checks = is_array( $s['checklist'] ?? null ) ? $s['checklist'] : $this->default_checklist();
        $trust = is_array( $s['trust_items'] ?? null ) ? $s['trust_items'] : $this->default_trust_items();
        $image = $this->media_url( $s['image'] ?? '' );
        ?>
        <section class="acwsc-gift">
            <div class="acwsc-gift__inner">
                <div class="acwsc-gift__main">
                    <div class="acwsc-gift__copy">
                        <?php if ( $this->yes( $s['show_kicker'] ?? 'yes' ) && ! empty( $s['kicker'] ) ) : ?><p class="acwsc-gift__kicker"><?php echo esc_html( $s['kicker'] ); ?></p><?php endif; ?>
                        <h2 class="acwsc-gift__title"><?php echo $this->accent_title( $s['heading'] ?? '', $s['accent_word'] ?? '' ); ?></h2>
                        <?php if ( $this->yes( $s['show_divider'] ?? 'yes' ) ) : ?><span class="acwsc-gift__divider" aria-hidden="true"></span><?php endif; ?>
                        <?php if ( $this->yes( $s['show_description'] ?? 'yes' ) && ! empty( $s['description'] ) ) : ?><p class="acwsc-gift__desc"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
                        <?php if ( $this->yes( $s['show_checklist'] ?? 'yes' ) ) : ?>
                            <div class="acwsc-gift__checks">
                                <?php foreach ( $checks as $check ) : ?><div class="acwsc-gift__check"><?php if ( $this->yes( $s['show_check_icons'] ?? 'yes' ) ) : ?><span class="acwsc-gift__check-icon"><?php echo $this->render_icon( $check['icon'] ?? array() ); ?></span><?php endif; ?><span><?php echo esc_html( $check['text'] ?? '' ); ?></span></div><?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( $this->yes( $s['show_button'] ?? 'yes' ) && ! empty( $s['button_text'] ) ) : ?><a class="acwsc-gift__btn" href="<?php echo esc_url( $this->link_url( $s['button_url'] ?? '#' ) ?: '#' ); ?>"><?php echo esc_html( $s['button_text'] ); ?></a><?php endif; ?>
                    </div>
                    <?php if ( $this->yes( $s['show_image'] ?? 'yes' ) ) : ?>
                    <figure class="acwsc-gift__image">
                        <?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $s['heading'] ?? 'Amaley gifting visual' ); ?>" loading="lazy"><?php else : ?><span class="acwsc-gift__placeholder"></span><?php endif; ?>
                        <?php if ( $this->yes( $s['show_caption'] ?? '' ) && ! empty( $s['caption'] ) ) : ?><figcaption class="acwsc-gift__caption"><?php echo esc_html( $s['caption'] ); ?></figcaption><?php endif; ?>
                    </figure>
                    <?php endif; ?>
                </div>
                <?php if ( $this->yes( $s['show_trust'] ?? 'yes' ) ) : ?>
                <div class="acwsc-gift__trust">
                    <div class="acwsc-gift__trust-grid">
                    <?php foreach ( $trust as $item ) : ?>
                        <div class="acwsc-gift__trust-item">
                            <?php if ( $this->yes( $s['show_trust_icons'] ?? 'yes' ) ) : ?><span class="acwsc-gift__trust-icon"><?php echo $this->render_icon( $item['icon'] ?? array() ); ?></span><?php endif; ?>
                            <strong class="acwsc-gift__trust-title"><?php echo esc_html( $item['title'] ?? '' ); ?></strong>
                            <?php if ( $this->yes( $s['show_trust_text'] ?? '' ) && ! empty( $item['text'] ) ) : ?><span class="acwsc-gift__trust-text"><?php echo esc_html( $item['text'] ); ?></span><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
