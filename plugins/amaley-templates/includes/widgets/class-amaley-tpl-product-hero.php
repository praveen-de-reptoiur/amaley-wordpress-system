<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Tpl_Product_Hero_Widget extends Amaley_Tpl_Widget_Base {

    public function get_name() {
        return 'amaley_tpl_product_hero';
    }

    public function get_title() {
        return esc_html__( 'Amaley Templates Product Hero', 'amaley-templates' );
    }

    public function get_icon() {
        return 'eicon-product-images';
    }

    public function get_categories() {
        return array( 'amaley-templates' );
    }

    public function get_keywords() {
        return array( 'amaley templates', 'amaley', 'templates', 'product', 'hero', 'woocommerce', 'single' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            array( 'label' => esc_html__( 'Content / Product Data', 'amaley-templates' ) )
        );

        $this->add_control(
            'show_breadcrumb',
            array(
                'label'        => esc_html__( 'Show Breadcrumb', 'amaley-templates' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'breadcrumb_position',
            array(
                'label'   => esc_html__( 'Breadcrumb Position', 'amaley-templates' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'above',
                'options' => array(
                    'above'   => esc_html__( 'Above Product Hero', 'amaley-templates' ),
                    'summary' => esc_html__( 'Inside Product Summary', 'amaley-templates' ),
                ),
                'condition' => array(
                    'show_breadcrumb' => 'yes',
                ),
            )
        );

        $this->add_control(
            'show_rating',
            array(
                'label'        => esc_html__( 'Show Rating', 'amaley-templates' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'show_buy_now',
            array(
                'label'        => esc_html__( 'Show Buy Now Button', 'amaley-templates' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => $this->tpl_setting( 'single_product.buy_now_enabled', 'yes' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'buy_now_text',
            array(
                'label'   => esc_html__( 'Buy Now Text', 'amaley-templates' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => $this->tpl_setting( 'single_product.buy_now_text', esc_html__( 'Buy Now', 'amaley-templates' ) ),
            )
        );

        $this->add_control(
            'show_wishlist_placeholder',
            array(
                'label'        => esc_html__( 'Show Wishlist Placeholder', 'amaley-templates' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => $this->tpl_setting( 'single_product.wishlist_enabled', 'yes' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'origin_short_line_field',
            array(
                'label'       => esc_html__( 'Origin Short Line Field', 'amaley-templates' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => $this->tpl_setting( 'single_product.origin_short_line', 'origin_short_line' ),
                'label_block' => true,
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: WRAPPER / LAYOUT -------------------- */
        $this->start_controls_section(
            'style_layout_section',
            array(
                'label' => esc_html__( 'Layout / Wrapper', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'background_color',
            array(
                'label'   => esc_html__( 'Background', 'amaley-templates' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => $this->tpl_setting( 'global.ivory_color', '#FBF5E6' ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'wrapper_padding',
            array(
                'label'      => esc_html__( 'Wrapper Padding', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'column_gap',
            array(
                'label' => esc_html__( 'Column Gap', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array(
                'name'     => 'wrapper_border',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero',
            )
        );

        $this->add_control(
            'wrapper_radius',
            array(
                'label' => esc_html__( 'Wrapper Radius', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'wrapper_shadow',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero',
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: IMAGE / GALLERY -------------------- */
        $this->start_controls_section(
            'style_gallery_section',
            array(
                'label' => esc_html__( 'Image / Gallery', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'image_bg',
            array(
                'label' => esc_html__( 'Image Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__main-image' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'image_radius',
            array(
                'label' => esc_html__( 'Image Radius', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__main-image' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array(
                'name'     => 'image_border',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__main-image',
            )
        );

        $this->add_control(
            'thumb_size',
            array(
                'label' => esc_html__( 'Thumbnail Size', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 40, 'max' => 120 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'thumb_gap',
            array(
                'label' => esc_html__( 'Thumbnail Gap', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 30 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__thumbs' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'thumb_radius',
            array(
                'label' => esc_html__( 'Thumbnail Radius', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 30 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__thumb' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'image_hover_zoom',
            array(
                'label' => esc_html__( 'Main Image Hover Zoom', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 100, 'max' => 112 ) ),
                'description' => esc_html__( '100 disables zoom; 103 = subtle premium zoom.', 'amaley-templates' ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__main-image:hover img' => 'transform: scale(calc({{SIZE}} / 100));',
                ),
            )
        );

        $this->add_control(
            'thumb_hover_border_color',
            array(
                'label' => esc_html__( 'Thumbnail Hover Border', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__thumb:hover' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'thumb_hover_bg',
            array(
                'label' => esc_html__( 'Thumbnail Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__thumb:hover' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: BREADCRUMB / ORIGIN LINE -------------------- */
        $this->start_controls_section(
            'style_origin_line_section',
            array(
                'label' => esc_html__( 'Breadcrumb / Origin Line', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'breadcrumb_bg',
            array(
                'label' => esc_html__( 'Breadcrumb Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'breadcrumb_color',
            array(
                'label' => esc_html__( 'Breadcrumb Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb, {{WRAPPER}} .amaley-tpl-product-hero__breadcrumb a' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'breadcrumb_link_hover_color',
            array(
                'label' => esc_html__( 'Breadcrumb Link Hover Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb a:hover' => 'color: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_control(
            'breadcrumb_hover_bg',
            array(
                'label' => esc_html__( 'Breadcrumb Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb:hover' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'breadcrumb_padding',
            array(
                'label'      => esc_html__( 'Breadcrumb Padding', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'breadcrumb_margin',
            array(
                'label'      => esc_html__( 'Breadcrumb Margin', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'breadcrumb_min_height',
            array(
                'label' => esc_html__( 'Breadcrumb Min Height', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 180 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb' => 'min-height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'breadcrumb_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__breadcrumb',
            )
        );

        $this->add_control(
            'origin_line_color',
            array(
                'label' => esc_html__( 'Origin Line Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__origin-line' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'origin_line_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__origin-line',
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: TITLE / PRICE / TEXT -------------------- */
        $this->start_controls_section(
            'style_text_section',
            array(
                'label' => esc_html__( 'Title / Price / Description', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'   => esc_html__( 'Title Color', 'amaley-templates' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => $this->tpl_setting( 'global.primary_color', '#2E1203' ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__title',
            )
        );

        $this->add_responsive_control(
            'title_margin',
            array(
                'label'      => esc_html__( 'Title Margin', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'price_color',
            array(
                'label' => esc_html__( 'Price Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__price, {{WRAPPER}} .amaley-tpl-product-hero__price .amount' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__price',
            )
        );

        $this->add_control(
            'price_border_color',
            array(
                'label' => esc_html__( 'Price Divider Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__price' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'rating_text_color',
            array(
                'label' => esc_html__( 'Rating Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__rating' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'rating_star_color',
            array(
                'label' => esc_html__( 'Rating Star Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__rating .star-rating span:before, {{WRAPPER}} .amaley-tpl-product-hero__rating .star-rating:before' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'description_color',
            array(
                'label' => esc_html__( 'Description Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__short-desc' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__short-desc',
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: MINI ORIGIN CARD -------------------- */
        $this->start_controls_section(
            'style_mini_origin_section',
            array(
                'label' => esc_html__( 'Traceable Origin Mini Card', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'mini_origin_bg',
            array(
                'label' => esc_html__( 'Card Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array(
                'name'     => 'mini_origin_border',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin',
            )
        );

        $this->add_responsive_control(
            'mini_origin_padding',
            array(
                'label'      => esc_html__( 'Card Padding', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'mini_origin_label_color',
            array(
                'label' => esc_html__( 'Label Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin span' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'mini_origin_label_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin span',
            )
        );

        $this->add_control(
            'mini_origin_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin strong' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'mini_origin_text_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin strong',
            )
        );

        $this->add_control(
            'mini_origin_hover_bg',
            array(
                'label' => esc_html__( 'Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin:hover' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'mini_origin_hover_border_color',
            array(
                'label' => esc_html__( 'Hover Border Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__mini-origin:hover' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: BADGES -------------------- */
        $this->start_controls_section(
            'style_badges_section',
            array(
                'label' => esc_html__( 'Badges', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'badge_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__badges span' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'badge_bg_color',
            array(
                'label' => esc_html__( 'Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__badges span' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array(
                'name'     => 'badge_border',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__badges span',
            )
        );

        $this->add_responsive_control(
            'badge_padding',
            array(
                'label'      => esc_html__( 'Padding', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__badges span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'badge_radius',
            array(
                'label' => esc_html__( 'Radius', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__badges span' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'badge_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__badges span',
            )
        );

        $this->add_control(
            'badge_hover_text_color',
            array(
                'label' => esc_html__( 'Hover Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__badges span:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'badge_hover_bg_color',
            array(
                'label' => esc_html__( 'Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__badges span:hover' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'badge_hover_border_color',
            array(
                'label' => esc_html__( 'Hover Border Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__badges span:hover' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: CART / BUTTONS -------------------- */
        $this->start_controls_section(
            'style_buttons_section',
            array(
                'label' => esc_html__( 'Cart / Buttons', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'variation_selector_heading',
            array(
                'label' => esc_html__( 'Pack Size / Variation Selector', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::HEADING,
            )
        );

        $this->add_control(
            'variation_table_margin',
            array(
                'label' => esc_html__( 'Variation Area Margin', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'variation_label_color',
            array(
                'label' => esc_html__( 'Label Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations label' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'variation_label_typography',
                'label'    => esc_html__( 'Label Typography', 'amaley-templates' ),
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations label',
            )
        );

        $this->add_control(
            'variation_select_text_color',
            array(
                'label' => esc_html__( 'Dropdown Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'variation_select_bg_color',
            array(
                'label' => esc_html__( 'Dropdown Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'variation_select_border_color',
            array(
                'label' => esc_html__( 'Dropdown Border Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'variation_select_hover_bg_color',
            array(
                'label' => esc_html__( 'Dropdown Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select:hover, {{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select:focus' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'variation_select_focus_border_color',
            array(
                'label' => esc_html__( 'Dropdown Focus Border', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select:hover, {{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select:focus' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'variation_select_min_height',
            array(
                'label' => esc_html__( 'Dropdown Min Height', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 30, 'max' => 90 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select' => 'min-height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'variation_select_padding',
            array(
                'label' => esc_html__( 'Dropdown Padding', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'variation_select_radius',
            array(
                'label' => esc_html__( 'Dropdown Radius', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart table.variations select' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'variation_reset_color',
            array(
                'label' => esc_html__( 'Reset Link Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero form.cart .reset_variations' => 'color: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_control(
            'variation_price_color',
            array(
                'label' => esc_html__( 'Selected Variation Price Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero .single_variation_wrap .woocommerce-variation-price, {{WRAPPER}} .amaley-tpl-product-hero .single_variation_wrap .price' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'variation_availability_color',
            array(
                'label' => esc_html__( 'Selected Variation Stock Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero .single_variation_wrap .woocommerce-variation-availability' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'add_cart_button_heading',
            array(
                'label' => esc_html__( 'Add to Cart Button', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::HEADING,
            )
        );

        $this->add_control(
            'cart_button_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero .single_add_to_cart_button, {{WRAPPER}} .amaley-tpl-product-hero button.single_add_to_cart_button' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'cart_button_bg_color',
            array(
                'label' => esc_html__( 'Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero .single_add_to_cart_button, {{WRAPPER}} .amaley-tpl-product-hero button.single_add_to_cart_button' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'cart_button_hover_text_color',
            array(
                'label' => esc_html__( 'Hover Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero .single_add_to_cart_button:hover, {{WRAPPER}} .amaley-tpl-product-hero button.single_add_to_cart_button:hover' => 'color: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_control(
            'cart_button_hover_bg_color',
            array(
                'label' => esc_html__( 'Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero .single_add_to_cart_button:hover, {{WRAPPER}} .amaley-tpl-product-hero button.single_add_to_cart_button:hover' => 'background: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_control(
            'cart_button_hover_border_color',
            array(
                'label' => esc_html__( 'Hover Border Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero .single_add_to_cart_button:hover, {{WRAPPER}} .amaley-tpl-product-hero button.single_add_to_cart_button:hover' => 'border-color: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_control(
            'buy_now_heading',
            array(
                'label' => esc_html__( 'Buy Now Button', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'buy_now_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-buy-now-button' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'buy_now_bg_color',
            array(
                'label' => esc_html__( 'Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-buy-now-button' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'buy_now_hover_text_color',
            array(
                'label' => esc_html__( 'Hover Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-buy-now-button:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'buy_now_hover_bg_color',
            array(
                'label' => esc_html__( 'Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-buy-now-button:hover' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'wishlist_heading',
            array(
                'label' => esc_html__( 'Wishlist Button', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'wishlist_text_color',
            array(
                'label' => esc_html__( 'Text/Icon Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-wishlist-placeholder' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'wishlist_bg_color',
            array(
                'label' => esc_html__( 'Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-wishlist-placeholder' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'wishlist_hover_text_color',
            array(
                'label' => esc_html__( 'Hover Text/Icon Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-wishlist-placeholder:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'wishlist_hover_bg_color',
            array(
                'label' => esc_html__( 'Hover Background', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-wishlist-placeholder:hover' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'wishlist_hover_border_color',
            array(
                'label' => esc_html__( 'Hover Border Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-wishlist-placeholder:hover' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-buy-now-button, {{WRAPPER}} .amaley-tpl-product-hero .single_add_to_cart_button',
            )
        );

        $this->add_control(
            'button_radius',
            array(
                'label' => esc_html__( 'Button Radius', 'amaley-templates' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-buy-now-button, {{WRAPPER}} .amaley-tpl-wishlist-placeholder, {{WRAPPER}} .amaley-tpl-product-hero .single_add_to_cart_button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: META -------------------- */
        $this->start_controls_section(
            'style_meta_section',
            array(
                'label' => esc_html__( 'Meta / Stock Line', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'meta_color',
            array(
                'label' => esc_html__( 'Text Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__meta' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'meta_typography',
                'selector' => '{{WRAPPER}} .amaley-tpl-product-hero__meta',
            )
        );

        $this->add_control(
            'meta_divider_color',
            array(
                'label' => esc_html__( 'Divider Color', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-product-hero__meta span' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $product  = $this->current_product();

        if ( ! $product ) {
            $this->fallback_product_message();
            return;
        }

        $product_id = $product->get_id();
        $origin     = $this->text_value( $this->acf_value( $settings['origin_short_line_field'], $product_id ) );
        $breadcrumb_position = isset( $settings['breadcrumb_position'] ) ? $settings['breadcrumb_position'] : 'above';
        $image_id   = $product->get_image_id();
        $gallery    = $product->get_gallery_image_ids();
        $rating     = $product->get_average_rating();
        $review_count = $product->get_review_count();
        ?>
        <section class="amaley-tpl-product-hero" data-product-id="<?php echo esc_attr( $product_id ); ?>">
            <?php if ( 'yes' === $settings['show_breadcrumb'] && 'above' === $breadcrumb_position && function_exists( 'woocommerce_breadcrumb' ) ) : ?>
                <div class="amaley-tpl-product-hero__breadcrumb amaley-tpl-product-hero__breadcrumb--top">
                    <?php woocommerce_breadcrumb(); ?>
                </div>
            <?php endif; ?>

            <div class="amaley-tpl-product-hero__gallery">
                <div class="amaley-tpl-product-hero__main-image">
                    <?php
                    if ( $image_id ) {
                        echo wp_get_attachment_image( $image_id, 'large' );
                    } else {
                        echo '<div class="amaley-tpl-product-hero__image-fallback">Amaley</div>';
                    }
                    ?>
                </div>

                <?php if ( ! empty( $gallery ) ) : ?>
                    <div class="amaley-tpl-product-hero__thumbs">
                        <?php foreach ( array_slice( $gallery, 0, 5 ) as $gallery_id ) : ?>
                            <button class="amaley-tpl-product-hero__thumb" type="button">
                                <?php echo wp_get_attachment_image( $gallery_id, 'thumbnail' ); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="amaley-tpl-product-hero__mini-origin">
                    <span>Traceable Origin</span>
                    <strong><?php echo $origin ? esc_html( $origin ) : esc_html__( 'Origin details will appear here once filled.', 'amaley-templates' ); ?></strong>
                </div>
            </div>

            <div class="amaley-tpl-product-hero__summary">
                <?php if ( 'yes' === $settings['show_breadcrumb'] && 'summary' === $breadcrumb_position && function_exists( 'woocommerce_breadcrumb' ) ) : ?>
                    <div class="amaley-tpl-product-hero__breadcrumb amaley-tpl-product-hero__breadcrumb--summary">
                        <?php woocommerce_breadcrumb(); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $origin ) : ?>
                    <div class="amaley-tpl-product-hero__origin-line">◆ <?php echo esc_html( $origin ); ?></div>
                <?php endif; ?>

                <h1 class="amaley-tpl-product-hero__title"><?php echo esc_html( $product->get_name() ); ?></h1>

                <?php if ( 'yes' === $settings['show_rating'] ) : ?>
                    <div class="amaley-tpl-product-hero__rating">
                        <?php echo wc_get_rating_html( $rating, $review_count ); ?>
                        <span><?php echo esc_html( sprintf( _n( '%s review', '%s reviews', $review_count, 'amaley-templates' ), number_format_i18n( $review_count ) ) ); ?></span>
                    </div>
                <?php endif; ?>

                <div class="amaley-tpl-product-hero__price">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>

                <?php if ( $product->get_short_description() ) : ?>
                    <div class="amaley-tpl-product-hero__short-desc">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_short_description', $product->get_short_description() ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="amaley-tpl-product-hero__badges">
                    <span>Small Batch</span>
                    <span>Traceable</span>
                    <span>Natural</span>
                </div>

                <div class="amaley-tpl-product-hero__cart-wrap">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>

                <div class="amaley-tpl-product-hero__action-row">
                    <?php if ( 'yes' === $settings['show_buy_now'] ) : ?>
                        <button type="button" class="amaley-tpl-buy-now-button"><?php echo esc_html( $settings['buy_now_text'] ); ?></button>
                    <?php endif; ?>

                    <?php if ( 'yes' === $settings['show_wishlist_placeholder'] ) : ?>
                        <button type="button" class="amaley-tpl-wishlist-placeholder" aria-label="Wishlist">♡</button>
                    <?php endif; ?>
                </div>

                <div class="amaley-tpl-product-hero__meta">
                    <span><?php echo $product->is_in_stock() ? esc_html__( 'In stock', 'amaley-templates' ) : esc_html__( 'Out of stock', 'amaley-templates' ); ?></span>
                    <?php if ( $product->has_weight() ) : ?>
                        <span><?php echo esc_html__( 'Weight:', 'amaley-templates' ); ?> <?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?></span>
                    <?php endif; ?>
                    <span><?php echo esc_html__( 'Carefully packed', 'amaley-templates' ); ?></span>
                </div>
            </div>
        </section>
        <?php
    }
}
