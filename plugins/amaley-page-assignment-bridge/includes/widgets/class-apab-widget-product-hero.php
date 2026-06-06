<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APAB_Widget_Product_Hero extends APAB_Widget_Base {

    public function get_name() { return 'apab_product_hero'; }
    public function get_title() { return esc_html__( 'Amaley Bridge Product Hero', 'amaley-page-assignment-bridge' ); }
    public function get_icon() { return 'eicon-product-images'; }
    public function get_keywords() { return array( 'amaley', 'bridge', 'product', 'hero', 'woocommerce' ); }

    protected function register_controls() {
        /* -------------------- CONTENT -------------------- */
        $this->start_controls_section(
            'content_section',
            array(
                'label' => esc_html__( 'Content', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_control(
            'origin_field',
            array(
                'label'       => esc_html__( 'Origin Short Line Field', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'origin_short_line',
                'label_block' => true,
            )
        );

        $this->add_control(
            'mini_origin_label',
            array(
                'label'   => esc_html__( 'Mini Origin Label', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Traceable Origin', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_control(
            'badges',
            array(
                'label'       => esc_html__( 'Badges', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Small Batch|Traceable|Natural',
                'description' => esc_html__( 'Use | between badges.', 'amaley-page-assignment-bridge' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'buy_now_text',
            array(
                'label'   => esc_html__( 'Buy Now Text', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Buy Now', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_control(
            'wishlist_text',
            array(
                'label'   => esc_html__( 'Wishlist Icon/Text', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '♡',
            )
        );

        $this->add_control(
            'carefully_packed_text',
            array(
                'label'   => esc_html__( 'Carefully Packed Text', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Carefully packed', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->end_controls_section();

        /* -------------------- SHOW / HIDE -------------------- */
        $this->start_controls_section(
            'visibility_section',
            array(
                'label' => esc_html__( 'Show / Hide', 'amaley-page-assignment-bridge' ),
            )
        );

        $visibility_controls = array(
            'show_breadcrumb'          => array( 'Show Breadcrumb', 'yes' ),
            'show_main_image'          => array( 'Show Main Image', 'yes' ),
            'show_gallery_thumbnails'  => array( 'Show Gallery Thumbnails', 'yes' ),
            'show_mini_origin'         => array( 'Show Mini Origin Box', 'yes' ),
            'show_origin_line'         => array( 'Show Origin Line Above Title', 'yes' ),
            'show_title'               => array( 'Show Product Title', 'yes' ),
            'show_rating'              => array( 'Show Rating', '' ),
            'show_price'               => array( 'Show Price', 'yes' ),
            'show_short_description'   => array( 'Show Short Description', 'yes' ),
            'show_badges'              => array( 'Show Badges', 'yes' ),
            'show_quantity'            => array( 'Show Quantity', 'yes' ),
            'show_add_to_cart'         => array( 'Show Add to Cart', 'yes' ),
            'show_buy_now'             => array( 'Show Buy Now', 'yes' ),
            'show_wishlist'            => array( 'Show Wishlist', 'yes' ),
            'show_meta_row'            => array( 'Show Meta Row', 'yes' ),
            'show_stock'               => array( 'Show Stock', 'yes' ),
            'show_weight'              => array( 'Show Weight', 'yes' ),
            'show_carefully_packed'    => array( 'Show Carefully Packed Text', 'yes' ),
        );

        foreach ( $visibility_controls as $control_id => $data ) {
            $this->add_control(
                $control_id,
                array(
                    'label'        => esc_html__( $data[0], 'amaley-page-assignment-bridge' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'default'      => $data[1],
                    'return_value' => 'yes',
                )
            );
        }

        $this->end_controls_section();

        /* -------------------- LAYOUT -------------------- */
        $this->start_controls_section(
            'layout_section',
            array(
                'label' => esc_html__( 'Layout', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_control(
            'hero_layout',
            array(
                'label'   => esc_html__( 'Desktop Layout', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'image_left',
                'options' => array(
                    'image_left'   => esc_html__( 'Image Left / Content Right', 'amaley-page-assignment-bridge' ),
                    'content_left' => esc_html__( 'Content Left / Image Right', 'amaley-page-assignment-bridge' ),
                    'stacked'      => esc_html__( 'Stacked', 'amaley-page-assignment-bridge' ),
                ),
            )
        );

        $this->add_control(
            'thumbnail_position',
            array(
                'label'   => esc_html__( 'Thumbnail Position', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => array(
                    'bottom' => esc_html__( 'Bottom', 'amaley-page-assignment-bridge' ),
                    'left'   => esc_html__( 'Left', 'amaley-page-assignment-bridge' ),
                ),
                'condition' => array( 'show_gallery_thumbnails' => 'yes' ),
            )
        );

        $this->add_control(
            'button_layout',
            array(
                'label'   => esc_html__( 'Button Layout', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'inline',
                'options' => array(
                    'inline'     => esc_html__( 'Inline', 'amaley-page-assignment-bridge' ),
                    'stacked'    => esc_html__( 'Stacked', 'amaley-page-assignment-bridge' ),
                    'full_width' => esc_html__( 'Full Width', 'amaley-page-assignment-bridge' ),
                ),
            )
        );

        $this->add_responsive_control(
            'column_gap',
            array(
                'label' => esc_html__( 'Column Gap', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-product-hero__grid' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'image_height',
            array(
                'label'      => esc_html__( 'Image Height', 'amaley-page-assignment-bridge' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'vh' ),
                'range'      => array(
                    'px' => array( 'min' => 220, 'max' => 900 ),
                    'vh' => array( 'min' => 30, 'max' => 90 ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .apab-product-hero__main-image img, {{WRAPPER}} .apab-product-hero__image-fallback' => 'height: {{SIZE}}{{UNIT}}; aspect-ratio: auto;',
                ),
                'condition' => array( 'show_main_image' => 'yes' ),
            )
        );

        $this->add_responsive_control(
            'thumbnail_size',
            array(
                'label' => esc_html__( 'Thumbnail Size', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 36, 'max' => 120 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-product-hero__thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array( 'show_gallery_thumbnails' => 'yes' ),
            )
        );

        $this->end_controls_section();

        /* -------------------- ALIGNMENT -------------------- */
        $this->start_controls_section(
            'alignment_section',
            array(
                'label' => esc_html__( 'Alignment', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_alignment_control( 'content_align', 'Content Alignment', '{{WRAPPER}} .apab-product-hero__summary' );
        $this->add_alignment_control( 'title_align', 'Title Alignment', '{{WRAPPER}} .apab-product-hero__title' );
        $this->add_flex_alignment_control( 'price_align', 'Price Alignment', '{{WRAPPER}} .apab-product-hero__price' );
        $this->add_alignment_control( 'description_align', 'Description Alignment', '{{WRAPPER}} .apab-product-hero__short-desc' );
        $this->add_flex_alignment_control( 'badge_align', 'Badge Alignment', '{{WRAPPER}} .apab-product-hero__badges' );
        $this->add_flex_alignment_control( 'button_align', 'Button Alignment', '{{WRAPPER}} .apab-product-hero__cart form.cart, {{WRAPPER}} .apab-product-hero__action-row' );
        $this->add_flex_alignment_control( 'meta_align', 'Meta Row Alignment', '{{WRAPPER}} .apab-product-hero__meta' );
        $this->add_alignment_control( 'mini_origin_align', 'Mini Origin Alignment', '{{WRAPPER}} .apab-product-hero__mini-origin' );

        $this->end_controls_section();

        /* -------------------- STYLE: SECTION -------------------- */
        $this->start_controls_section(
            'style_section',
            array(
                'label' => esc_html__( 'Section', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'section_bg',
            array(
                'label' => esc_html__( 'Background', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .apab-product-hero' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_padding',
            array(
                'label'      => esc_html__( 'Padding', 'amaley-page-assignment-bridge' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .apab-product-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_margin',
            array(
                'label'      => esc_html__( 'Margin', 'amaley-page-assignment-bridge' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .apab-product-hero' => 'margin: {{TOP}}{{UNIT}} auto {{BOTTOM}}{{UNIT}} auto;',
                ),
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: IMAGE -------------------- */
        $this->start_controls_section(
            'style_image',
            array(
                'label' => esc_html__( 'Image / Gallery', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array( 'show_main_image' => 'yes' ),
            )
        );

        $this->add_control( 'image_bg', array( 'label' => 'Image Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__main-image' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'image_border', 'selector' => '{{WRAPPER}} .apab-product-hero__main-image' ) );
        $this->add_control( 'image_radius', array( 'label' => 'Image Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__main-image' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'thumb_border_color', array( 'label' => 'Thumbnail Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__thumb' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'thumb_active_border_color', array( 'label' => 'Active Thumbnail Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__thumb.is-active' => 'border-color: {{VALUE}};' ) ) );

        $this->end_controls_section();

        /* -------------------- STYLE: TITLE / PRICE -------------------- */
        $this->start_controls_section(
            'style_title_price',
            array(
                'label' => esc_html__( 'Title / Price / Text', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control( 'origin_line_color', array( 'label' => 'Origin Line Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__origin-line' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'origin_line_typography', 'selector' => '{{WRAPPER}} .apab-product-hero__origin-line' ) );

        $this->add_control( 'title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .apab-product-hero__title' ) );

        $this->add_control( 'price_color', array( 'label' => 'Price Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__price, {{WRAPPER}} .apab-product-hero__price .amount' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'sale_price_color', array( 'label' => 'Sale Price Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__price ins, {{WRAPPER}} .apab-product-hero__price ins .amount' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'old_price_color', array( 'label' => 'Old Price Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__price del, {{WRAPPER}} .apab-product-hero__price del .amount' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'price_typography', 'selector' => '{{WRAPPER}} .apab-product-hero__price' ) );

        $this->add_control( 'short_desc_color', array( 'label' => 'Short Description Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__short-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'short_desc_typography', 'selector' => '{{WRAPPER}} .apab-product-hero__short-desc' ) );

        $this->end_controls_section();

        /* -------------------- STYLE: BADGES -------------------- */
        $this->start_controls_section(
            'style_badges',
            array(
                'label' => esc_html__( 'Badges', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array( 'show_badges' => 'yes' ),
            )
        );

        $this->add_control( 'badge_text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__badges span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'badge_bg_color', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__badges span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'badge_border_color', array( 'label' => 'Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__badges span' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'badge_padding', array( 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__badges span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'badge_radius', array( 'label' => 'Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__badges span' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'badge_typography', 'selector' => '{{WRAPPER}} .apab-product-hero__badges span' ) );

        $this->end_controls_section();

        /* -------------------- STYLE: BUTTONS -------------------- */
        $this->start_controls_section(
            'style_buttons',
            array(
                'label' => esc_html__( 'Buttons', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control( 'cart_button_bg', array( 'label' => 'Add to Cart Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero .single_add_to_cart_button' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'cart_button_color', array( 'label' => 'Add to Cart Text', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero .single_add_to_cart_button' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'cart_button_hover_bg', array( 'label' => 'Add to Cart Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero .single_add_to_cart_button:hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'cart_button_hover_color', array( 'label' => 'Add to Cart Hover Text', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero .single_add_to_cart_button:hover' => 'color: {{VALUE}} !important;' ) ) );

        $this->add_control( 'buy_now_bg', array( 'label' => 'Buy Now Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-buy-now' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'buy_now_color', array( 'label' => 'Buy Now Text', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-buy-now' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'buy_now_hover_bg', array( 'label' => 'Buy Now Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-buy-now:hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'buy_now_hover_color', array( 'label' => 'Buy Now Hover Text', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-buy-now:hover' => 'color: {{VALUE}} !important;' ) ) );

        $this->add_control( 'wishlist_bg', array( 'label' => 'Wishlist Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-wishlist' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'wishlist_color', array( 'label' => 'Wishlist Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-wishlist' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'wishlist_border_color', array( 'label' => 'Wishlist Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-wishlist' => 'border-color: {{VALUE}};' ) ) );

        $this->add_control( 'button_radius', array( 'label' => 'Button Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero .single_add_to_cart_button, {{WRAPPER}} .apab-buy-now, {{WRAPPER}} .apab-wishlist' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => 'Button Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero .single_add_to_cart_button, {{WRAPPER}} .apab-buy-now' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .apab-product-hero .single_add_to_cart_button, {{WRAPPER}} .apab-buy-now' ) );

        $this->end_controls_section();

        /* -------------------- STYLE: MINI ORIGIN / META -------------------- */
        $this->start_controls_section(
            'style_mini_meta',
            array(
                'label' => esc_html__( 'Mini Origin / Meta', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control( 'mini_origin_bg', array( 'label' => 'Mini Origin Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__mini-origin' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'mini_origin_border_color', array( 'label' => 'Mini Origin Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__mini-origin' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'mini_origin_label_color', array( 'label' => 'Mini Origin Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__mini-origin span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'mini_origin_text_color', array( 'label' => 'Mini Origin Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__mini-origin strong' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'mini_origin_padding', array( 'label' => 'Mini Origin Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__mini-origin' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );

        $this->add_control( 'meta_color', array( 'label' => 'Meta Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-product-hero__meta' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_typography', 'selector' => '{{WRAPPER}} .apab-product-hero__meta' ) );

        $this->end_controls_section();

        /* -------------------- SPACING -------------------- */
        $this->start_controls_section(
            'spacing_section',
            array(
                'label' => esc_html__( 'Spacing / Responsive', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control( 'breadcrumb_margin', array( 'label' => 'Breadcrumb Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'title_margin', array( 'label' => 'Title Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'price_margin', array( 'label' => 'Price Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'desc_margin', array( 'label' => 'Description Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__short-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'badges_gap', array( 'label' => 'Badges Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__badges' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_gap', array( 'label' => 'Button Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__cart form.cart, {{WRAPPER}} .apab-product-hero__action-row' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'meta_gap', array( 'label' => 'Meta Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .apab-product-hero__meta' => 'gap: {{SIZE}}{{UNIT}};' ) ) );

        $this->end_controls_section();
    }

    private function add_alignment_control( $id, $label, $selector, $property = 'text-align: {{VALUE}};' ) {
        $css_value = '{{VALUE}}';
        if ( false !== strpos( $property, 'justify-content' ) ) {
            $css_value = '{{VALUE}}';
        }

        $this->add_responsive_control(
            $id,
            array(
                'label'   => esc_html__( $label, 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__( 'Left', 'amaley-page-assignment-bridge' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'amaley-page-assignment-bridge' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'amaley-page-assignment-bridge' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'default'   => 'left',
                'toggle'    => false,
                'selectors' => array(
                    $selector => $property,
                ),
            )
        );
    }


    private function add_flex_alignment_control( $id, $label, $selector ) {
        $this->add_responsive_control(
            $id,
            array(
                'label'   => esc_html__( $label, 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Left', 'amaley-page-assignment-bridge' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'amaley-page-assignment-bridge' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'amaley-page-assignment-bridge' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'default'   => 'flex-start',
                'toggle'    => false,
                'selectors' => array(
                    $selector => 'justify-content: {{VALUE}};',
                ),
            )
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $product  = $this->current_product();
        if ( ! $product ) {
            $this->editor_notice();
            return;
        }

        $product_id = $product->get_id();
        $origin     = $this->field_text( $settings['origin_field'], $product_id );
        if ( ! $origin ) {
            $origin_data = APAB_Product_Context::origin_data( $product_id, array( 'origin_short' => $settings['origin_field'] ) );
            $origin      = ! empty( $origin_data['origin_short'] ) ? $origin_data['origin_short'] : '';
        }
        $image_id   = $product->get_image_id();
        $gallery    = $product->get_gallery_image_ids();
        $badges     = array_filter( array_map( 'trim', explode( '|', (string) $settings['badges'] ) ) );
        $rating     = $product->get_average_rating();
        $review_count = $product->get_review_count();

        $has_gallery_column = ( 'yes' === $settings['show_main_image'] ) || ( 'yes' === $settings['show_gallery_thumbnails'] && ! empty( $gallery ) ) || ( 'yes' === $settings['show_mini_origin'] );
        $classes = array(
            'apab-product-hero',
            'apab-product-hero--layout-' . sanitize_html_class( $settings['hero_layout'] ),
            'apab-product-hero--thumbs-' . sanitize_html_class( $settings['thumbnail_position'] ),
            'apab-product-hero--buttons-' . sanitize_html_class( $settings['button_layout'] ),
        );
        if ( ! $has_gallery_column ) {
            $classes[] = 'apab-product-hero--no-gallery';
        }
        if ( 'yes' !== $settings['show_quantity'] ) {
            $classes[] = 'apab-product-hero--hide-quantity';
        }

        echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '" data-product-id="' . esc_attr( $product_id ) . '">';

        if ( 'yes' === $settings['show_breadcrumb'] ) {
            echo '<div class="apab-product-hero__breadcrumb">';
            if ( function_exists( 'woocommerce_breadcrumb' ) ) {
                woocommerce_breadcrumb();
            } else {
                echo '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a> / ' . esc_html( $product->get_name() );
            }
            echo '</div>';
        }

        echo '<div class="apab-product-hero__grid">';

        if ( $has_gallery_column ) {
            echo '<div class="apab-product-hero__gallery">';

            if ( 'yes' === $settings['show_main_image'] ) {
                echo '<div class="apab-product-hero__main-image">';
                if ( $image_id ) {
                    echo wp_get_attachment_image( $image_id, 'large' );
                } else {
                    echo '<div class="apab-product-hero__image-fallback">Amaley</div>';
                }
                echo '</div>';
            }

            if ( 'yes' === $settings['show_gallery_thumbnails'] && ! empty( $gallery ) ) {
                echo '<div class="apab-product-hero__thumbs">';
                foreach ( array_slice( $gallery, 0, 5 ) as $index => $gallery_id ) {
                    echo '<button class="apab-product-hero__thumb' . ( 0 === $index ? ' is-active' : '' ) . '" type="button">' . wp_get_attachment_image( $gallery_id, 'thumbnail' ) . '</button>';
                }
                echo '</div>';
            }

            if ( 'yes' === $settings['show_mini_origin'] ) {
                echo '<div class="apab-product-hero__mini-origin"><span>' . esc_html( $settings['mini_origin_label'] ) . '</span><strong>' . esc_html( $origin ? $origin : 'Origin details will appear once filled.' ) . '</strong></div>';
            }

            echo '</div>';
        }

        echo '<div class="apab-product-hero__summary">';
        if ( 'yes' === $settings['show_origin_line'] && $origin ) {
            echo '<div class="apab-product-hero__origin-line">◆ ' . esc_html( $origin ) . '</div>';
        }
        if ( 'yes' === $settings['show_title'] ) {
            echo '<h1 class="apab-product-hero__title">' . esc_html( $product->get_name() ) . '</h1>';
        }

        if ( 'yes' === $settings['show_rating'] ) {
            echo '<div class="apab-product-hero__rating">' . wp_kses_post( wc_get_rating_html( $rating, $review_count ) ) . '<span>' . esc_html( sprintf( _n( '%s review', '%s reviews', $review_count, 'amaley-page-assignment-bridge' ), number_format_i18n( $review_count ) ) ) . '</span></div>';
        }

        if ( 'yes' === $settings['show_price'] ) {
            echo '<div class="apab-product-hero__price">' . wp_kses_post( $product->get_price_html() ) . '</div>';
        }

        if ( 'yes' === $settings['show_short_description'] && $product->get_short_description() ) {
            echo '<div class="apab-product-hero__short-desc">' . wp_kses_post( apply_filters( 'woocommerce_short_description', $product->get_short_description() ) ) . '</div>';
        }

        if ( 'yes' === $settings['show_badges'] && ! empty( $badges ) ) {
            echo '<div class="apab-product-hero__badges">';
            foreach ( $badges as $badge ) {
                echo '<span>' . esc_html( $badge ) . '</span>';
            }
            echo '</div>';
        }

        if ( 'yes' === $settings['show_add_to_cart'] ) {
            echo '<div class="apab-product-hero__cart">';
            echo APAB_Product_Context::with_product_globals( $product, function() { woocommerce_template_single_add_to_cart(); } );
            echo '</div>';
        }

        if ( 'yes' === $settings['show_buy_now'] || 'yes' === $settings['show_wishlist'] ) {
            echo '<div class="apab-product-hero__action-row">';
            if ( 'yes' === $settings['show_buy_now'] && $product->is_purchasable() && $product->is_type( 'simple' ) ) {
                $buy_url = add_query_arg( array( 'add-to-cart' => $product_id, 'quantity' => 1, 'apab_buy_now' => 1 ), home_url( '/' ) );
                echo '<a class="apab-buy-now" href="' . esc_url( $buy_url ) . '">' . esc_html( $settings['buy_now_text'] ) . '</a>';
            }
            if ( 'yes' === $settings['show_wishlist'] ) {
                echo '<button type="button" class="apab-wishlist" aria-label="Wishlist">' . esc_html( $settings['wishlist_text'] ) . '</button>';
            }
            echo '</div>';
        }

        if ( 'yes' === $settings['show_meta_row'] ) {
            $meta_items = array();
            if ( 'yes' === $settings['show_stock'] ) {
                $meta_items[] = $product->is_in_stock() ? esc_html__( 'In stock', 'amaley-page-assignment-bridge' ) : esc_html__( 'Out of stock', 'amaley-page-assignment-bridge' );
            }
            if ( 'yes' === $settings['show_weight'] && $product->has_weight() ) {
                $meta_items[] = esc_html__( 'Weight:', 'amaley-page-assignment-bridge' ) . ' ' . wc_format_weight( $product->get_weight() );
            }
            if ( 'yes' === $settings['show_carefully_packed'] && ! empty( $settings['carefully_packed_text'] ) ) {
                $meta_items[] = $settings['carefully_packed_text'];
            }

            if ( ! empty( $meta_items ) ) {
                echo '<div class="apab-product-hero__meta">';
                foreach ( $meta_items as $item ) {
                    echo '<span>' . esc_html( $item ) . '</span>';
                }
                echo '</div>';
            }
        }

        echo '</div></div></section>';
    }
}
