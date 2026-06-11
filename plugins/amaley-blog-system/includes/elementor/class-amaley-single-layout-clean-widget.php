<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Single_Layout_Clean_Widget extends Amaley_Blog_Elementor_Base {
    public function get_name() {
        return 'amaley_single_layout_clean_v141';
    }

    public function get_title() {
        return __( 'Amaley Single Article Layout — Fixed', 'amaley-blog-system' );
    }

    public function get_icon() {
        return 'eicon-post-content';
    }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_layout_style_controls();
        $this->register_sidebar_style_controls();
        $this->register_article_style_controls();
        $this->register_promo_style_controls();
        $this->register_tags_navigation_style_controls();
        $this->register_related_cards_style_controls();
        $this->register_visibility_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section( 'layout_content', array( 'label' => __( 'Article Layout Content', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ) );
        $this->add_control( 'layout_note', array( 'type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => __( 'Use this below Amaley Single Hero — Full Width. This widget intentionally does not render hero.', 'amaley-blog-system' ), 'content_classes' => 'elementor-panel-alert elementor-panel-alert-info' ) );
        $this->add_control( 'show_sidebar', array_merge( array( 'label' => __( 'Show Left Sidebar', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_toc', array_merge( array( 'label' => __( 'Show On This Page', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'condition' => array( 'show_sidebar' => 'yes' ) ), $this->switch_default() ) );
        $this->add_control( 'toc_title', array( 'label' => __( 'TOC Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'On This Page', 'amaley-blog-system' ), 'condition' => array( 'show_toc' => 'yes' ) ) );
        $this->add_control( 'show_share', array_merge( array( 'label' => __( 'Show Share Block', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'condition' => array( 'show_sidebar' => 'yes' ) ), $this->switch_default() ) );
        $this->add_control( 'share_title', array( 'label' => __( 'Share Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Share This Article', 'amaley-blog-system' ), 'condition' => array( 'show_share' => 'yes' ) ) );
        $this->add_control( 'show_promo', array_merge( array( 'label' => __( 'Show Promo Card', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'condition' => array( 'show_sidebar' => 'yes' ) ), $this->switch_default() ) );
        $this->add_control( 'promo_image', array( 'label' => __( 'Promo Image', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'condition' => array( 'show_promo' => 'yes' ) ) );
        $this->add_control( 'promo_title', array( 'label' => __( 'Promo Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Pure Shilajit Resin', 'amaley-blog-system' ), 'condition' => array( 'show_promo' => 'yes' ) ) );
        $this->add_control( 'promo_text', array( 'label' => __( 'Promo Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => __( '100% Natural & Authentic', 'amaley-blog-system' ), 'condition' => array( 'show_promo' => 'yes' ) ) );
        $this->add_control( 'promo_button', array( 'label' => __( 'Promo Button Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Shop Now', 'amaley-blog-system' ), 'condition' => array( 'show_promo' => 'yes' ) ) );
        $this->add_control( 'promo_link', array( 'label' => __( 'Promo Link', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::URL, 'placeholder' => home_url( '/shop/' ), 'condition' => array( 'show_promo' => 'yes' ) ) );
        $this->add_control( 'show_sidebar_related', array_merge( array( 'label' => __( 'Show Sidebar Related Posts', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'condition' => array( 'show_sidebar' => 'yes' ) ), $this->switch_default() ) );
        $this->add_control( 'sidebar_related_title', array( 'label' => __( 'Sidebar Related Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Related Articles', 'amaley-blog-system' ), 'condition' => array( 'show_sidebar_related' => 'yes' ) ) );
        $this->add_control( 'show_tags', array_merge( array( 'label' => __( 'Show Tags', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_prev_next', array_merge( array( 'label' => __( 'Show Previous / Next', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_related_grid', array_merge( array( 'label' => __( 'Show Related Grid', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'related_grid_title', array( 'label' => __( 'Related Grid Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Related Articles', 'amaley-blog-system' ), 'condition' => array( 'show_related_grid' => 'yes' ) ) );
        $this->add_control( 'related_count', array( 'label' => __( 'Related Grid Count', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 3, 'min' => 1, 'max' => 6, 'condition' => array( 'show_related_grid' => 'yes' ) ) );
        $this->add_responsive_control( 'related_columns', array( 'label' => __( 'Related Grid Columns', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '1', '2' => '2', '3' => '3' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-grid' => '--amaley-blog-columns: {{VALUE}};' ), 'condition' => array( 'show_related_grid' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function register_layout_style_controls() {
        $this->start_controls_section( 'layout_style', array( 'label' => __( 'Article Layout', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'layout_tabs' );
        $this->start_controls_tab( 'layout_container_tab', array( 'label' => __( 'Container', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'layout_max_width', array( 'label' => __( 'Max Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 780, 'max' => 1800 ), '%' => array( 'min' => 70, 'max' => 100 ) ), 'default' => array( 'size' => 1180, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__shell' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sidebar_width', array( 'label' => __( 'Sidebar Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 190, 'max' => 420 ), '%' => array( 'min' => 18, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__shell' => '--abs2-sidebar-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'layout_gap', array( 'label' => __( 'Sidebar–Content Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__shell' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'article_max_width', array( 'label' => __( 'Article Max Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 520, 'max' => 1100 ), '%' => array( 'min' => 60, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__main' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'layout_spacing_tab', array( 'label' => __( 'Spacing', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => __( 'Section Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'layout_margin', array( 'label' => __( 'Widget Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'shell_padding', array( 'label' => __( 'Inner Container Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__shell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'main_stack_gap', array( 'label' => __( 'Content Stack Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__main' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'layout_surface_tab', array( 'label' => __( 'Surface', 'amaley-blog-system' ) ) );
        $this->add_control( 'section_bg', array( 'label' => __( 'Section Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'shell_bg', array( 'label' => __( 'Inner Container Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__shell' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'shell_radius', array( 'label' => __( 'Inner Container Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__shell' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'shell_shadow', 'selector' => '{{WRAPPER}} .abs2-layout__shell' ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_sidebar_style_controls() {
        $this->start_controls_section( 'sidebar_style', array( 'label' => __( 'Sidebar', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'sidebar_tabs' );

        $this->start_controls_tab( 'sidebar_box_tab', array( 'label' => __( 'Box', 'amaley-blog-system' ) ) );
        $this->add_control( 'sidebar_box_bg', array( 'label' => __( 'Box Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__box' => 'background-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'sidebar_box_border', 'selector' => '{{WRAPPER}} .abs2-layout__box' ) );
        $this->add_responsive_control( 'sidebar_box_padding', array( 'label' => __( 'Box Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sidebar_box_radius', array( 'label' => __( 'Box Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'sidebar_box_shadow_clean', 'selector' => '{{WRAPPER}} .abs2-layout__box' ) );
        $this->add_responsive_control( 'sidebar_block_gap', array( 'label' => __( 'Sidebar Block Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__sidebar-stack' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'sidebar_heading_tab', array( 'label' => __( 'Heading', 'amaley-blog-system' ) ) );
        $this->add_control( 'sidebar_heading_color', array( 'label' => __( 'Heading Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__box-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'sidebar_heading_typography', 'selector' => '{{WRAPPER}} .abs2-layout__box-title' ) );
        $this->add_responsive_control( 'sidebar_heading_margin', array( 'label' => __( 'Heading Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'sidebar_heading_divider_color', array( 'label' => __( 'Divider Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__box-title' => 'border-bottom-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'sidebar_toc_tab', array( 'label' => __( 'TOC', 'amaley-blog-system' ) ) );
        $this->add_control( 'toc_link_color', array( 'label' => __( 'Item Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__toc a, {{WRAPPER}} .abs2-layout__toc span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'toc_link_hover_color', array( 'label' => __( 'Item Hover Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__toc a:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'toc_hover_bg', array( 'label' => __( 'Item Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__toc a:hover' => 'background-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'toc_item_typography', 'selector' => '{{WRAPPER}} .abs2-layout__toc a, {{WRAPPER}} .abs2-layout__toc span' ) );
        $this->add_responsive_control( 'toc_item_padding', array( 'label' => __( 'Item Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__toc a, {{WRAPPER}} .abs2-layout__toc span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'toc_item_gap', array( 'label' => __( 'Item Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__toc' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'toc_item_radius', array( 'label' => __( 'Item Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__toc a, {{WRAPPER}} .abs2-layout__toc span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'toc_item_border_color', array( 'label' => __( 'Divider Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__toc a, {{WRAPPER}} .abs2-layout__toc span' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'sidebar_share_tab', array( 'label' => __( 'Share', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'share_gap', array( 'label' => __( 'Icon Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__share' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'share_icon_size', array( 'label' => __( 'Icon Size', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 24, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__share a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'share_icon_color', array( 'label' => __( 'Icon Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__share a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'share_icon_bg', array( 'label' => __( 'Icon Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__share a' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'share_icon_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__share a:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'share_icon_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__share a:hover' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'share_icon_radius', array( 'label' => __( 'Icon Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__share a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'sidebar_mini_tab', array( 'label' => __( 'Mini Posts', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'mini_post_gap', array( 'label' => __( 'Mini Post Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__mini-list' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'mini_thumb_size', array( 'label' => __( 'Thumbnail Size', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 42, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__mini-list .amaley-blog-mini-post__thumb, {{WRAPPER}} .abs2-layout__mini-list img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'mini_thumb_radius', array( 'label' => __( 'Thumbnail Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__mini-list .amaley-blog-mini-post__thumb, {{WRAPPER}} .abs2-layout__mini-list img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'mini_title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__mini-list a, {{WRAPPER}} .abs2-layout__mini-list strong' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'mini_title_hover_color', array( 'label' => __( 'Title Hover Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__mini-list a:hover, {{WRAPPER}} .abs2-layout__mini-list a:hover strong' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'mini_title_typography', 'selector' => '{{WRAPPER}} .abs2-layout__mini-list a, {{WRAPPER}} .abs2-layout__mini-list strong' ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_article_style_controls() {
        $this->start_controls_section( 'article_style', array( 'label' => __( 'Article Content', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'article_tabs' );
        $this->start_controls_tab( 'article_text_tab', array( 'label' => __( 'Text', 'amaley-blog-system' ) ) );
        $this->add_control( 'article_text_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'article_typography', 'selector' => '{{WRAPPER}} .abs2-layout__article' ) );
        $this->add_responsive_control( 'paragraph_gap', array( 'label' => __( 'Paragraph Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article p' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'article_bg', array( 'label' => __( 'Article Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'article_padding', array( 'label' => __( 'Article Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'article_radius', array( 'label' => __( 'Article Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'article_link_color', array( 'label' => __( 'Link Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'article_link_hover_color', array( 'label' => __( 'Link Hover Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article a:hover' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'article_heading_tab', array( 'label' => __( 'Headings', 'amaley-blog-system' ) ) );
        $this->add_control( 'article_heading_color', array( 'label' => __( 'Heading Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article h1, {{WRAPPER}} .abs2-layout__article h2, {{WRAPPER}} .abs2-layout__article h3, {{WRAPPER}} .abs2-layout__article h4' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'article_heading_typography', 'selector' => '{{WRAPPER}} .abs2-layout__article h1, {{WRAPPER}} .abs2-layout__article h2, {{WRAPPER}} .abs2-layout__article h3, {{WRAPPER}} .abs2-layout__article h4' ) );
        $this->add_responsive_control( 'heading_top_gap', array( 'label' => __( 'Heading Top Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article h1, {{WRAPPER}} .abs2-layout__article h2, {{WRAPPER}} .abs2-layout__article h3, {{WRAPPER}} .abs2-layout__article h4' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'heading_bottom_gap', array( 'label' => __( 'Heading Bottom Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article h1, {{WRAPPER}} .abs2-layout__article h2, {{WRAPPER}} .abs2-layout__article h3, {{WRAPPER}} .abs2-layout__article h4' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'article_image_tab', array( 'label' => __( 'Images', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'article_image_width', array( 'label' => __( 'Image Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%', 'px' ), 'range' => array( '%' => array( 'min' => 20, 'max' => 100 ), 'px' => array( 'min' => 120, 'max' => 1200 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'article_image_height', array( 'label' => __( 'Image Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 100, 'max' => 720 ), 'vh' => array( 'min' => 10, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;' ) ) );
        $this->add_control( 'article_image_fit', array( 'label' => __( 'Object Fit', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill', 'none' => 'None' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'article_image_x', array( 'label' => __( 'Horizontal Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'object-position: {{SIZE}}% var(--abs2-article-image-y, 50%);' ) ) );
        $this->add_responsive_control( 'article_image_y', array( 'label' => __( 'Vertical Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => '--abs2-article-image-y: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'article_image_radius', array( 'label' => __( 'Image Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'article_image_spacing', array( 'label' => __( 'Image Vertical Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'article_image_margin', array( 'label' => __( 'Image Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'article_image_padding', array( 'label' => __( 'Image Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'enable_article_image_hover', array( 'label' => __( 'Enable Image Hover Motion', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-article-image-hover-' ) );
        $this->add_control( 'article_image_hover_scale', array( 'label' => __( 'Hover Scale', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.18, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}}.abs2-article-image-hover-yes .abs2-layout__article img:hover' => 'transform: scale({{SIZE}});' ), 'condition' => array( 'enable_article_image_hover' => 'yes' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'article_image_shadow', 'selector' => '{{WRAPPER}} .abs2-layout__article img' ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'article_elements_tab', array( 'label' => __( 'Elements', 'amaley-blog-system' ) ) );
        $this->add_control( 'blockquote_text_color', array( 'label' => __( 'Blockquote Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article blockquote' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'blockquote_bg', array( 'label' => __( 'Blockquote Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article blockquote' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'blockquote_border_color', array( 'label' => __( 'Blockquote Accent Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article blockquote' => 'border-left-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'blockquote_typography', 'selector' => '{{WRAPPER}} .abs2-layout__article blockquote' ) );
        $this->add_responsive_control( 'blockquote_padding', array( 'label' => __( 'Blockquote Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'blockquote_margin', array( 'label' => __( 'Blockquote Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article blockquote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'blockquote_radius', array( 'label' => __( 'Blockquote Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article blockquote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'list_text_color', array( 'label' => __( 'List Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__article li' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'list_item_gap', array( 'label' => __( 'List Item Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article li' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'list_indent', array( 'label' => __( 'List Indent', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__article ul, {{WRAPPER}} .abs2-layout__article ol' => 'padding-left: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_promo_style_controls() {
        $this->start_controls_section( 'promo_style', array( 'label' => __( 'Promo Card', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'promo_tabs' );
        $this->start_controls_tab( 'promo_box_tab', array( 'label' => __( 'Box', 'amaley-blog-system' ) ) );
        $this->add_control( 'promo_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'promo_height', array( 'label' => __( 'Min Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 120, 'max' => 520 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'promo_content_padding', array( 'label' => __( 'Content Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'promo_card_padding', array( 'label' => __( 'Card Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'promo_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'promo_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo, {{WRAPPER}} .abs2-layout__promo-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'promo_border', 'selector' => '{{WRAPPER}} .abs2-layout__promo' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'promo_shadow', 'selector' => '{{WRAPPER}} .abs2-layout__promo' ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'promo_media_tab', array( 'label' => __( 'Image / Overlay', 'amaley-blog-system' ) ) );
        $this->add_control( 'promo_image_fit', array( 'label' => __( 'Object Fit', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-media img' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'promo_image_x', array( 'label' => __( 'Horizontal Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-media img' => 'object-position: {{SIZE}}% var(--abs2-promo-y, 50%);' ) ) );
        $this->add_responsive_control( 'promo_image_y', array( 'label' => __( 'Vertical Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-media img' => '--abs2-promo-y: {{SIZE}}%;' ) ) );
        $this->add_control( 'enable_promo_image_hover', array( 'label' => __( 'Enable Image Hover Zoom', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-promo-image-hover-' ) );
        $this->add_control( 'promo_image_hover_scale', array( 'label' => __( 'Hover Scale', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.2, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}}.abs2-promo-image-hover-yes .abs2-layout__promo:hover .abs2-layout__promo-media img' => 'transform: scale({{SIZE}});' ), 'condition' => array( 'enable_promo_image_hover' => 'yes' ) ) );
        $this->add_control( 'promo_overlay_color', array( 'label' => __( 'Overlay Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-overlay' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'promo_overlay_opacity', array( 'label' => __( 'Overlay Opacity', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-overlay' => 'opacity: {{SIZE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'promo_text_tab', array( 'label' => __( 'Text', 'amaley-blog-system' ) ) );
        $this->add_control( 'promo_title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'promo_text_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-text' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'promo_text_gap', array( 'label' => __( 'Text Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-content' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'promo_title_typography', 'selector' => '{{WRAPPER}} .abs2-layout__promo-title' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'promo_text_typography', 'selector' => '{{WRAPPER}} .abs2-layout__promo-text' ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'promo_button_tab', array( 'label' => __( 'Button', 'amaley-blog-system' ) ) );
        $this->add_control( 'promo_button_color', array( 'label' => __( 'Button Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'promo_button_bg', array( 'label' => __( 'Button Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-button' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'promo_button_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo:hover .abs2-layout__promo-button' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'promo_button_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo:hover .abs2-layout__promo-button' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'promo_button_padding', array( 'label' => __( 'Button Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'promo_button_radius', array( 'label' => __( 'Button Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__promo-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'promo_button_typography', 'selector' => '{{WRAPPER}} .abs2-layout__promo-button' ) );
        $this->add_control( 'enable_promo_motion', array( 'label' => __( 'Enable Promo Hover Lift', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-promo-motion-' ) );
        $this->add_control( 'promo_hover_lift', array( 'label' => __( 'Hover Lift', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}}.abs2-promo-motion-yes .abs2-layout__promo:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});' ), 'condition' => array( 'enable_promo_motion' => 'yes' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_tags_navigation_style_controls() {
        $this->start_controls_section( 'tags_navigation_style', array( 'label' => __( 'Tags / Navigation', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'tags_navigation_tabs' );

        $this->start_controls_tab( 'tags_tab', array( 'label' => __( 'Tags', 'amaley-blog-system' ) ) );
        $this->add_control( 'tag_text_color', array( 'label' => __( 'Tag Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_bg', array( 'label' => __( 'Tag Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags a' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_hover_text_color', array( 'label' => __( 'Hover Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags a:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags a:hover' => 'background-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'tag_typography', 'selector' => '{{WRAPPER}} .abs2-layout__tags a, {{WRAPPER}} .abs2-layout__tags strong' ) );
        $this->add_responsive_control( 'tag_gap', array( 'label' => __( 'Tag Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_margin', array( 'label' => __( 'Tag Block Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_padding', array( 'label' => __( 'Tag Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_radius', array( 'label' => __( 'Tag Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__tags a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'tag_shadow', 'selector' => '{{WRAPPER}} .abs2-layout__tags a' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'prevnext_tab', array( 'label' => __( 'Prev / Next', 'amaley-blog-system' ) ) );
        $this->add_control( 'prevnext_bg', array( 'label' => __( 'Box Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext a' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'prevnext_text_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext a, {{WRAPPER}} .abs2-layout__prevnext span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'prevnext_label_color', array( 'label' => __( 'Label Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext small' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'prevnext_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext a:hover' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'prevnext_hover_text_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext a:hover, {{WRAPPER}} .abs2-layout__prevnext a:hover span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'prevnext_typography', 'selector' => '{{WRAPPER}} .abs2-layout__prevnext span' ) );
        $this->add_responsive_control( 'prevnext_gap', array( 'label' => __( 'Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'prevnext_padding', array( 'label' => __( 'Box Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'prevnext_radius', array( 'label' => __( 'Box Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__prevnext a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'prevnext_border', 'selector' => '{{WRAPPER}} .abs2-layout__prevnext a' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'prevnext_shadow', 'selector' => '{{WRAPPER}} .abs2-layout__prevnext a' ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_related_cards_style_controls() {
        $this->start_controls_section( 'related_cards_style', array( 'label' => __( 'Related Articles', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'related_cards_tabs' );

        $this->start_controls_tab( 'related_section_tab', array( 'label' => __( 'Section', 'amaley-blog-system' ) ) );
        $this->add_control( 'related_heading_color', array( 'label' => __( 'Heading Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related-heading' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_heading_typography', 'selector' => '{{WRAPPER}} .abs2-layout__related-heading' ) );
        $this->add_responsive_control( 'related_heading_margin', array( 'label' => __( 'Heading Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_section_margin', array( 'label' => __( 'Section Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_section_padding', array( 'label' => __( 'Section Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_grid_gap', array( 'label' => __( 'Grid Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'related_card_tab', array( 'label' => __( 'Card', 'amaley-blog-system' ) ) );
        $this->add_control( 'related_card_bg', array( 'label' => __( 'Card Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'related_card_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card:hover' => 'background-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'related_card_border', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card' ) );
        $this->add_responsive_control( 'related_card_radius', array( 'label' => __( 'Card Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_card_padding', array( 'label' => __( 'Card Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_card_body_gap', array( 'label' => __( 'Body Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__body' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'related_card_shadow', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card' ) );
        $this->add_control( 'enable_related_card_motion', array( 'label' => __( 'Enable Card Hover Lift', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-related-card-motion-' ) );
        $this->add_control( 'related_card_hover_lift', array( 'label' => __( 'Hover Lift', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}}.abs2-related-card-motion-yes .abs2-layout__related .amaley-blog-card:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});' ), 'condition' => array( 'enable_related_card_motion' => 'yes' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'related_image_tab', array( 'label' => __( 'Image', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'related_image_height', array( 'label' => __( 'Image Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 100, 'max' => 520 ), 'vh' => array( 'min' => 10, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'related_image_fit', array( 'label' => __( 'Object Fit', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__image' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'related_image_x', array( 'label' => __( 'Horizontal Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__image' => 'object-position: {{SIZE}}% var(--abs2-related-image-y, 50%);' ) ) );
        $this->add_responsive_control( 'related_image_y', array( 'label' => __( 'Vertical Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__image' => '--abs2-related-image-y: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'related_image_radius', array( 'label' => __( 'Image Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__media, {{WRAPPER}} .abs2-layout__related .amaley-blog-card__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'related_image_overlay', array( 'label' => __( 'Overlay Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__media::after' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'enable_related_image_hover', array( 'label' => __( 'Enable Image Hover Zoom', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-related-image-hover-' ) );
        $this->add_control( 'related_image_hover_scale', array( 'label' => __( 'Hover Scale', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.2, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}}.abs2-related-image-hover-yes .abs2-layout__related .amaley-blog-card:hover .amaley-blog-card__image' => 'transform: scale({{SIZE}});' ), 'condition' => array( 'enable_related_image_hover' => 'yes' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'related_text_tab', array( 'label' => __( 'Text', 'amaley-blog-system' ) ) );
        $this->add_control( 'related_category_text_color', array( 'label' => __( 'Category Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__category' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'related_category_bg', array( 'label' => __( 'Category Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__category' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'related_category_padding', array( 'label' => __( 'Category Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'related_title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__title, {{WRAPPER}} .abs2-layout__related .amaley-blog-card__title a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'related_title_hover_color', array( 'label' => __( 'Title Hover Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__title a:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_title_typography', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__title' ) );
        $this->add_control( 'related_meta_color', array( 'label' => __( 'Meta Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__meta' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_meta_typography', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__meta' ) );
        $this->add_control( 'related_excerpt_color', array( 'label' => __( 'Excerpt Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__excerpt' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_excerpt_typography', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__excerpt' ) );
        $this->add_responsive_control( 'related_title_margin', array( 'label' => __( 'Title Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'related_button_tab', array( 'label' => __( 'Button', 'amaley-blog-system' ) ) );
        $this->add_control( 'related_button_color', array( 'label' => __( 'Button Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'related_button_bg', array( 'label' => __( 'Button Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button' => 'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'related_button_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'related_button_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button:hover' => 'background-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'related_button_typography', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button' ) );
        $this->add_responsive_control( 'related_button_padding', array( 'label' => __( 'Button Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'related_button_radius', array( 'label' => __( 'Button Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'related_button_border', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'related_button_shadow', 'selector' => '{{WRAPPER}} .abs2-layout__related .amaley-blog-card__button' ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_visibility_controls() {
        $this->start_controls_section( 'layout_visibility_section', array( 'label' => __( 'Device Visibility', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_ADVANCED ) );
        $this->add_control( 'hide_layout_desktop', array( 'label' => __( 'Hide Layout on Desktop', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-layout-desktop-' ) );
        $this->add_control( 'hide_layout_tablet', array( 'label' => __( 'Hide Layout on Tablet', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-layout-tablet-' ) );
        $this->add_control( 'hide_layout_mobile', array( 'label' => __( 'Hide Layout on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-layout-mobile-' ) );
        $this->add_control( 'hide_sidebar_desktop', array( 'label' => __( 'Hide Sidebar on Desktop', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-sidebar-desktop-' ) );
        $this->add_control( 'hide_sidebar_tablet', array( 'label' => __( 'Hide Sidebar on Tablet', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-sidebar-tablet-' ) );
        $this->add_control( 'hide_sidebar_mobile', array( 'label' => __( 'Hide Sidebar on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-sidebar-mobile-' ) );
        $this->add_control( 'hide_promo_mobile', array( 'label' => __( 'Hide Promo on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-promo-mobile-' ) );
        $this->add_control( 'hide_tags_mobile', array( 'label' => __( 'Hide Tags on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-tags-mobile-' ) );
        $this->add_control( 'hide_prevnext_mobile', array( 'label' => __( 'Hide Previous / Next on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-prevnext-mobile-' ) );
        $this->add_control( 'hide_related_mobile', array( 'label' => __( 'Hide Related Grid on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs2-hide-related-mobile-' ) );
        $this->end_controls_section();
    }

    private function context_post_id() {
        $post_id = get_the_ID();
        if ( $post_id && 'post' === get_post_type( $post_id ) ) {
            return absint( $post_id );
        }
        $latest = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1, 'orderby' => 'date', 'order' => 'DESC' ) );
        return ! empty( $latest[0] ) ? absint( $latest[0]->ID ) : 0;
    }

    private function related_posts( $post_id, $count = 3 ) {
        $cat_ids = wp_get_post_categories( $post_id );
        $args = array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => absint( $count ), 'post__not_in' => array( absint( $post_id ) ), 'ignore_sticky_posts' => true );
        if ( ! empty( $cat_ids ) ) {
            $args['category__in'] = $cat_ids;
        }
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            return $query;
        }
        wp_reset_postdata();
        unset( $args['category__in'] );
        return new WP_Query( $args );
    }

    private function toc_items( $content ) {
        $items = array();
        if ( preg_match_all( '/<h([2-3])[^>]*>(.*?)<\/h\1>/i', $content, $matches, PREG_SET_ORDER ) ) {
            foreach ( $matches as $index => $match ) {
                $text = trim( wp_strip_all_tags( $match[2] ) );
                if ( '' === $text ) {
                    continue;
                }
                $items[] = array( 'id' => 'abs2-section-' . ( $index + 1 ), 'text' => $text, 'level' => absint( $match[1] ) );
            }
        }
        return $items;
    }

    private function content_with_heading_ids( $content, $items ) {
        if ( empty( $items ) ) {
            return $content;
        }
        $i = 0;
        return preg_replace_callback( '/<h([2-3])([^>]*)>/i', function( $match ) use ( &$i, $items ) {
            if ( empty( $items[ $i ]['id'] ) ) {
                return $match[0];
            }
            if ( false !== stripos( $match[2], ' id=' ) ) {
                $i++;
                return $match[0];
            }
            $id = esc_attr( $items[ $i ]['id'] );
            $i++;
            return '<h' . $match[1] . $match[2] . ' id="' . $id . '">';
        }, $content );
    }

    private function promo_image_url( $post_id, $settings ) {
        if ( ! empty( $settings['promo_image']['url'] ) ) {
            return esc_url( $settings['promo_image']['url'] );
        }
        $image = get_the_post_thumbnail_url( $post_id, 'large' );
        return $image ? $image : Amaley_Blog_Renderer::asset_url( 'assets/img/blog-thumb-placeholder.svg' );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $post_id = $this->context_post_id();
        if ( ! $post_id ) {
            echo '<section class="abs2-layout"><div class="abs2-layout__shell"><p>' . esc_html__( 'No post available for preview.', 'amaley-blog-system' ) . '</p></div></section>';
            return;
        }

        $title = get_the_title( $post_id );
        $raw_content = get_post_field( 'post_content', $post_id );
        $filtered_content = apply_filters( 'the_content', $raw_content );
        $toc_items = $this->toc_items( $filtered_content );
        $content = $this->content_with_heading_ids( $filtered_content, $toc_items );
        $sidebar_related = $this->related_posts( $post_id, 3 );
        $related_grid = $this->related_posts( $post_id, ! empty( $settings['related_count'] ) ? absint( $settings['related_count'] ) : 3 );
        $promo_url = ! empty( $settings['promo_link']['url'] ) ? $settings['promo_link']['url'] : home_url( '/shop/' );
        $promo_image = $this->promo_image_url( $post_id, $settings );
        ?>
        <section class="abs2-layout" aria-label="<?php echo esc_attr( $title ); ?>">
            <div class="abs2-layout__shell <?php echo empty( $settings['show_sidebar'] ) || 'yes' !== $settings['show_sidebar'] ? 'abs2-layout__shell--no-sidebar' : ''; ?>">
                <?php if ( ! empty( $settings['show_sidebar'] ) && 'yes' === $settings['show_sidebar'] ) : ?>
                    <aside class="abs2-layout__sidebar" aria-label="<?php echo esc_attr__( 'Article sidebar', 'amaley-blog-system' ); ?>">
                        <div class="abs2-layout__sidebar-stack">
                            <?php if ( ! empty( $settings['show_toc'] ) && 'yes' === $settings['show_toc'] ) : ?>
                                <div class="abs2-layout__box">
                                    <h3 class="abs2-layout__box-title"><?php echo esc_html( $settings['toc_title'] ); ?></h3>
                                    <nav class="abs2-layout__toc" aria-label="<?php echo esc_attr( $settings['toc_title'] ); ?>">
                                        <?php if ( ! empty( $toc_items ) ) : foreach ( $toc_items as $item ) : ?>
                                            <a class="<?php echo 3 === absint( $item['level'] ) ? 'is-child' : ''; ?>" href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
                                        <?php endforeach; else : ?>
                                            <span><?php echo esc_html__( 'Article headings will appear here.', 'amaley-blog-system' ); ?></span>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $settings['show_share'] ) && 'yes' === $settings['show_share'] ) : ?>
                                <div class="abs2-layout__box">
                                    <h3 class="abs2-layout__box-title"><?php echo esc_html( $settings['share_title'] ); ?></h3>
                                    <div class="abs2-layout__share">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink( $post_id ) ); ?>" target="_blank" rel="noopener">f</a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink( $post_id ) ); ?>" target="_blank" rel="noopener">x</a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( get_permalink( $post_id ) ); ?>" target="_blank" rel="noopener">in</a>
                                        <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( $title . ' ' . get_permalink( $post_id ) ); ?>" target="_blank" rel="noopener">w</a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $settings['show_promo'] ) && 'yes' === $settings['show_promo'] ) : ?>
                                <a class="abs2-layout__promo" href="<?php echo esc_url( $promo_url ); ?>">
                                    <span class="abs2-layout__promo-media"><img src="<?php echo esc_url( $promo_image ); ?>" alt="<?php echo esc_attr( $settings['promo_title'] ); ?>" loading="lazy" /></span>
                                    <span class="abs2-layout__promo-overlay"></span>
                                    <span class="abs2-layout__promo-content">
                                        <strong class="abs2-layout__promo-title"><?php echo esc_html( $settings['promo_title'] ); ?></strong>
                                        <span class="abs2-layout__promo-text"><?php echo esc_html( $settings['promo_text'] ); ?></span>
                                        <em class="abs2-layout__promo-button"><?php echo esc_html( $settings['promo_button'] ); ?></em>
                                    </span>
                                </a>
                            <?php endif; ?>

                            <?php if ( ! empty( $settings['show_sidebar_related'] ) && 'yes' === $settings['show_sidebar_related'] && $sidebar_related->have_posts() ) : ?>
                                <div class="abs2-layout__box">
                                    <h3 class="abs2-layout__box-title"><?php echo esc_html( $settings['sidebar_related_title'] ); ?></h3>
                                    <div class="abs2-layout__mini-list">
                                        <?php while ( $sidebar_related->have_posts() ) : $sidebar_related->the_post(); echo Amaley_Blog_Renderer::mini_post( get_the_ID() ); endwhile; wp_reset_postdata(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </aside>
                <?php endif; ?>

                <main class="abs2-layout__main">
                    <article class="abs2-layout__article">
                        <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </article>

                    <?php if ( ! empty( $settings['show_tags'] ) && 'yes' === $settings['show_tags'] ) : $tags = get_the_tags( $post_id ); if ( $tags ) : ?>
                        <div class="abs2-layout__tags"><strong><?php echo esc_html__( 'Tags:', 'amaley-blog-system' ); ?></strong><?php foreach ( $tags as $tag ) : ?><a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a><?php endforeach; ?></div>
                    <?php endif; endif; ?>

                    <?php if ( ! empty( $settings['show_prev_next'] ) && 'yes' === $settings['show_prev_next'] ) : ?>
                        <nav class="abs2-layout__prevnext" aria-label="<?php echo esc_attr__( 'Previous and next posts', 'amaley-blog-system' ); ?>">
                            <?php $prev = get_previous_post(); $next = get_next_post(); ?>
                            <?php echo $prev ? '<a href="' . esc_url( get_permalink( $prev ) ) . '"><small>' . esc_html__( 'Previous Post', 'amaley-blog-system' ) . '</small><span>' . esc_html( get_the_title( $prev ) ) . '</span></a>' : '<span></span>'; ?>
                            <?php echo $next ? '<a href="' . esc_url( get_permalink( $next ) ) . '"><small>' . esc_html__( 'Next Post', 'amaley-blog-system' ) . '</small><span>' . esc_html( get_the_title( $next ) ) . '</span></a>' : '<span></span>'; ?>
                        </nav>
                    <?php endif; ?>

                    <?php if ( ! empty( $settings['show_related_grid'] ) && 'yes' === $settings['show_related_grid'] && $related_grid->have_posts() ) : ?>
                        <section class="abs2-layout__related">
                            <h2 class="abs2-layout__related-heading"><?php echo esc_html( $settings['related_grid_title'] ); ?></h2>
                            <div class="amaley-blog-grid">
                                <?php while ( $related_grid->have_posts() ) : $related_grid->the_post(); echo Amaley_Blog_Renderer::card( get_the_ID(), array( 'show_image' => true, 'show_category' => true, 'show_date' => true, 'show_author' => false, 'show_reading_time' => true, 'show_excerpt' => true, 'show_button' => true, 'excerpt_length' => 18, 'button_text' => __( 'Read More', 'amaley-blog-system' ), 'auto_fallback' => true ) ); endwhile; wp_reset_postdata(); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </main>
            </div>
        </section>
        <?php
    }
}
