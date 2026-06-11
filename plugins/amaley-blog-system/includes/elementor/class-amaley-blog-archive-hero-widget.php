<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Archive_Hero_Widget extends Amaley_Blog_Elementor_Base {
    public function get_name() { return 'amaley_blog_archive_hero'; }
    public function get_title() { return __( 'Amaley Blog Archive Hero', 'amaley-blog-system' ); }
    public function get_icon() { return 'eicon-post-title'; }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
        $this->register_advanced_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section(
            'abs_hero_content_section',
            array(
                'label' => __( 'Hero Content', 'amaley-blog-system' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control( 'show_breadcrumb', array_merge( array( 'label' => __( 'Show Breadcrumb', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'breadcrumb', array( 'label' => __( 'Breadcrumb Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Home / Blogs' ) );
        $this->add_control( 'show_heading', array_merge( array( 'label' => __( 'Show Heading', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'heading', array( 'label' => __( 'Heading', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Stories, Insights & Wellness from the Himalayas' ) );
        $this->add_control( 'show_description', array_merge( array( 'label' => __( 'Show Description', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'description', array( 'label' => __( 'Description', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Explore our latest articles on natural wellness, shilajit benefits, mindful living, and stories from the mountains.' ) );
        $this->add_control( 'show_image', array_merge( array( 'label' => __( 'Show Hero Image', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'hero_image', array( 'label' => __( 'Hero Image', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'hero_image_alt', array( 'label' => __( 'Image Alt Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Stories from the Himalayas' ) );

        $this->end_controls_section();

        $this->start_controls_section(
            'abs_hero_layout_section',
            array(
                'label' => __( 'Hero Layout', 'amaley-blog-system' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'layout_style',
            array(
                'label'   => __( 'Layout', 'amaley-blog-system' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'split',
                'options' => array(
                    'split'      => __( 'Text Left + Image Right', 'amaley-blog-system' ),
                    'centered'   => __( 'Centered Text', 'amaley-blog-system' ),
                    'background' => __( 'Background Image', 'amaley-blog-system' ),
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'abs_hero_fallback_section',
            array(
                'label' => __( 'Fallback', 'amaley-blog-system' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'fallback_style',
            array(
                'label'   => __( 'Fallback Image Style', 'amaley-blog-system' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'brand_mountain',
                'options' => array(
                    'brand_mountain' => __( 'Brand Mountain Visual', 'amaley-blog-system' ),
                    'dark_card'      => __( 'Dark Premium Card', 'amaley-blog-system' ),
                    'none'           => __( 'None', 'amaley-blog-system' ),
                ),
            )
        );

        $this->end_controls_section();
    }

    private function register_style_controls() {
        /**
         * Amaley Universal Full-Control Elementor Design Standard:
         * One major element = one clean Style section.
         * Sub-elements = tabs inside that same section.
         */

        $this->start_controls_section(
            'hero_wrapper_style',
            array(
                'label' => __( 'Hero Wrapper', 'amaley-blog-system' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->start_controls_tabs( 'hero_wrapper_tabs' );

        $this->start_controls_tab(
            'hero_wrapper_container_tab',
            array( 'label' => __( 'Container', 'amaley-blog-system' ) )
        );
        $this->add_responsive_control(
            'hero_wrapper_max_width',
            array(
                'label'      => __( 'Max Width', 'amaley-blog-system' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array( 'min' => 720, 'max' => 1920 ),
                    '%'  => array( 'min' => 60, 'max' => 100 ),
                ),
                'selectors'  => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'max-width: {{SIZE}}{{UNIT}}; margin-left:auto; margin-right:auto;' ),
            )
        );
        $this->add_responsive_control(
            'hero_wrapper_columns_gap',
            array(
                'label'     => __( 'Content / Image Gap', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array( 'px' => array( 'min' => 0, 'max' => 140 ) ),
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'gap: {{SIZE}}{{UNIT}};' ),
            )
        );
        $this->add_responsive_control(
            'hero_wrapper_vertical_align',
            array(
                'label'     => __( 'Vertical Align', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => array(
                    'flex-start' => array( 'title' => __( 'Top', 'amaley-blog-system' ), 'icon' => 'eicon-v-align-top' ),
                    'center'     => array( 'title' => __( 'Middle', 'amaley-blog-system' ), 'icon' => 'eicon-v-align-middle' ),
                    'flex-end'   => array( 'title' => __( 'Bottom', 'amaley-blog-system' ), 'icon' => 'eicon-v-align-bottom' ),
                ),
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'align-items: {{VALUE}};' ),
            )
        );
        $this->add_responsive_control(
            'hero_wrapper_image_width',
            array(
                'label'      => __( 'Image Column Width', 'amaley-blog-system' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( '%', 'px' ),
                'range'      => array(
                    '%'  => array( 'min' => 24, 'max' => 62 ),
                    'px' => array( 'min' => 240, 'max' => 860 ),
                ),
                'selectors'  => array( '{{WRAPPER}} .amaley-blog-archive-hero' => '--amaley-blog-hero-image-width: {{SIZE}}{{UNIT}};' ),
            )
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'hero_wrapper_spacing_tab',
            array( 'label' => __( 'Spacing', 'amaley-blog-system' ) )
        );
        $this->add_responsive_control(
            'hero_wrapper_margin',
            array(
                'label'      => __( 'Margin', 'amaley-blog-system' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            )
        );
        $this->add_responsive_control(
            'hero_wrapper_padding',
            array(
                'label'      => __( 'Padding', 'amaley-blog-system' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            )
        );
        $this->add_responsive_control(
            'hero_wrapper_min_height',
            array(
                'label'     => __( 'Min Height', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array( 'px' => array( 'min' => 0, 'max' => 820 ) ),
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'min-height: {{SIZE}}{{UNIT}};' ),
            )
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'hero_wrapper_surface_tab',
            array( 'label' => __( 'Surface', 'amaley-blog-system' ) )
        );
        $this->add_control(
            'hero_wrapper_background',
            array(
                'label'     => __( 'Background', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'background-color: {{VALUE}};' ),
            )
        );
        $this->add_control(
            'hero_wrapper_gradient_start',
            array(
                'label'     => __( 'Gradient Start', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero::before' => 'background: radial-gradient(circle at 18% 8%, rgba(226,165,29,.18), transparent 32%), linear-gradient(135deg, {{VALUE}} 0%, var(--amaley-blog-brown) 52%, var(--amaley-blog-rust) 100%); opacity:.70;' ),
            )
        );
        $this->add_control(
            'hero_wrapper_gradient_end',
            array(
                'label'     => __( 'Gradient End', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero::before' => 'background: radial-gradient(circle at 18% 8%, rgba(226,165,29,.18), transparent 32%), linear-gradient(135deg, var(--amaley-blog-deep) 0%, var(--amaley-blog-brown) 52%, {{VALUE}} 100%); opacity:.70;' ),
            )
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array( 'name' => 'hero_wrapper_border', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero' )
        );
        $this->add_responsive_control(
            'hero_wrapper_radius',
            array(
                'label'     => __( 'Radius', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            )
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array( 'name' => 'hero_wrapper_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero' )
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'hero_content_style',
            array(
                'label' => __( 'Hero Content', 'amaley-blog-system' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->start_controls_tabs( 'hero_content_tabs' );

        $this->start_controls_tab( 'hero_content_box_tab', array( 'label' => __( 'Box', 'amaley-blog-system' ) ) );
        $this->add_responsive_control(
            'hero_content_align',
            array(
                'label'   => __( 'Text Alignment', 'amaley-blog-system' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'left'   => array( 'title' => __( 'Left', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-left' ),
                    'center' => array( 'title' => __( 'Center', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-center' ),
                    'right'  => array( 'title' => __( 'Right', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-right' ),
                ),
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__content' => 'text-align: {{VALUE}};' ),
            )
        );
        $this->add_responsive_control(
            'hero_content_max_width',
            array(
                'label'     => __( 'Max Width', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => array( 'px' => array( 'min' => 260, 'max' => 1180 ) ),
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__content' => 'max-width: {{SIZE}}{{UNIT}};' ),
            )
        );
        $this->add_responsive_control(
            'hero_content_padding',
            array(
                'label'      => __( 'Padding', 'amaley-blog-system' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array( '{{WRAPPER}} .amaley-blog-archive-hero__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            )
        );
        $this->add_control(
            'hero_content_background',
            array(
                'label'     => __( 'Background', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__content' => 'background: {{VALUE}};' ),
            )
        );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'hero_content_border', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__content' ) );
        $this->add_responsive_control(
            'hero_content_radius',
            array(
                'label'     => __( 'Radius', 'amaley-blog-system' ),
                'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            )
        );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'hero_content_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__content' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_breadcrumb_tab', array( 'label' => __( 'Breadcrumb', 'amaley-blog-system' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_breadcrumb_typography', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__breadcrumb' ) );
        $this->add_control( 'hero_breadcrumb_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__breadcrumb' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'hero_breadcrumb_background', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__breadcrumb' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_breadcrumb_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_breadcrumb_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__breadcrumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_breadcrumb_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_heading_tab', array( 'label' => __( 'Heading', 'amaley-blog-system' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_heading_typography', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__title' ) );
        $this->add_control( 'hero_heading_color', array( 'label' => __( 'Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__title' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_heading_max_width', array( 'label' => __( 'Max Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 260, 'max' => 1180 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__title' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_heading_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Text_Shadow::get_type(), array( 'name' => 'hero_heading_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__title' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_description_tab', array( 'label' => __( 'Description', 'amaley-blog-system' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'hero_description_typography', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__description' ) );
        $this->add_control( 'hero_description_color', array( 'label' => __( 'Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__description' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_description_max_width', array( 'label' => __( 'Max Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 220, 'max' => 950 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__description' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_description_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'hero_visual_style',
            array(
                'label' => __( 'Hero Image / Visual', 'amaley-blog-system' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->start_controls_tabs( 'hero_visual_tabs' );

        $this->start_controls_tab( 'hero_visual_box_tab', array( 'label' => __( 'Box', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'hero_visual_height', array( 'label' => __( 'Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 120, 'max' => 760 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_visual_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_visual_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'hero_visual_border', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'hero_visual_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap' ) );
        $this->add_control(
            'hero_visual_shape',
            array(
                'label'   => __( 'Shape', 'amaley-blog-system' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    'clip-path: polygon(18% 0,100% 0,100% 100%,0 100%);' => __( 'Default Angled', 'amaley-blog-system' ),
                    'clip-path: none;' => __( 'No Clip', 'amaley-blog-system' ),
                    'clip-path: polygon(10% 0,100% 0,92% 100%,0 100%);' => __( 'Soft Slant', 'amaley-blog-system' ),
                    'clip-path: polygon(18% 0,100% 0,82% 100%,0 100%);' => __( 'Editorial Slant', 'amaley-blog-system' ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap' => '{{VALUE}}',
                ),
            )
        );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_visual_image_tab', array( 'label' => __( 'Image', 'amaley-blog-system' ) ) );
        $this->add_control( 'hero_image_object_fit', array( 'label' => __( 'Object Fit', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill', 'none' => 'None' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap img' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_image_object_position', array( 'label' => __( 'Object Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => __( 'Default', 'amaley-blog-system' ), 'center center' => 'Center Center', 'center top' => 'Center Top', 'center bottom' => 'Center Bottom', 'left center' => 'Left Center', 'right center' => 'Right Center' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap img' => 'object-position: {{VALUE}};' ) ) );
        $this->add_control( 'hero_image_opacity', array( 'label' => __( 'Opacity', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => .05 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap img' => 'opacity: {{SIZE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Css_Filter::get_type(), array( 'name' => 'hero_image_css_filter', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap img' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_visual_overlay_tab', array( 'label' => __( 'Overlay', 'amaley-blog-system' ) ) );
        $this->add_control( 'hero_overlay_color', array( 'label' => __( 'Overlay Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap::after' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'hero_overlay_opacity', array( 'label' => __( 'Overlay Opacity', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => .05 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap::after' => 'opacity: {{SIZE}};' ) ) );
        $this->add_control( 'hero_fallback_accent', array( 'label' => __( 'Fallback Accent', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__orb' => 'background: {{VALUE}};', '{{WRAPPER}} .amaley-blog-archive-hero__mountain' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_visual_hover_tab', array( 'label' => __( 'Hover', 'amaley-blog-system' ) ) );
        $this->add_control( 'hero_hover_scale', array( 'label' => __( 'Image Hover Scale', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.25, 'step' => .01 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap:hover img' => 'transform: scale({{SIZE}});' ) ) );
        $this->add_control( 'hero_hover_overlay', array( 'label' => __( 'Hover Overlay Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap:hover::after' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'hero_visual_hover_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap:hover' ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_advanced_controls() {
        $this->start_controls_section( 'abs_device_visibility', array( 'label' => __( 'Device Visibility', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_ADVANCED ) );
        $this->add_responsive_control( 'abs_hide_whole_hero', array( 'label' => __( 'Hide Whole Hero', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero' => 'display:none;' ) ) );
        $this->add_responsive_control( 'abs_hide_breadcrumb_device', array( 'label' => __( 'Hide Breadcrumb', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__breadcrumb' => 'display:none;' ) ) );
        $this->add_responsive_control( 'abs_hide_image_device', array( 'label' => __( 'Hide Image / Visual', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-hero__image-wrap' => 'display:none;' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $image = ! empty( $s['hero_image']['url'] ) ? $s['hero_image']['url'] : '';
        $show_image = ! empty( $s['show_image'] ) && 'yes' === $s['show_image'];
        $fallback_style = ! empty( $s['fallback_style'] ) ? sanitize_html_class( $s['fallback_style'] ) : 'brand_mountain';
        $layout = ! empty( $s['layout_style'] ) ? sanitize_html_class( $s['layout_style'] ) : 'split';
        $image_class = $image ? ' has-image' : ' is-placeholder is-fallback-' . $fallback_style;
        ?>
        <section class="amaley-blog-archive-hero amaley-blog-archive-hero--<?php echo esc_attr( $layout ); ?> amaley-blog-archive-hero--brand">
            <div class="amaley-blog-archive-hero__content">
                <?php if ( ! empty( $s['show_breadcrumb'] ) && 'yes' === $s['show_breadcrumb'] && ! empty( $s['breadcrumb'] ) ) : ?>
                    <div class="amaley-blog-archive-hero__breadcrumb"><?php echo esc_html( $s['breadcrumb'] ); ?></div>
                <?php endif; ?>
                <?php if ( ! empty( $s['show_heading'] ) && 'yes' === $s['show_heading'] && ! empty( $s['heading'] ) ) : ?>
                    <h1 class="amaley-blog-archive-hero__title"><?php echo esc_html( $s['heading'] ); ?></h1>
                <?php endif; ?>
                <?php if ( ! empty( $s['show_description'] ) && 'yes' === $s['show_description'] && ! empty( $s['description'] ) ) : ?>
                    <p class="amaley-blog-archive-hero__description"><?php echo esc_html( $s['description'] ); ?></p>
                <?php endif; ?>
            </div>
            <?php if ( $show_image && ( $image || 'none' !== $fallback_style ) ) : ?>
                <div class="amaley-blog-archive-hero__image-wrap<?php echo esc_attr( $image_class ); ?>">
                    <?php if ( $image ) : ?>
                        <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( ! empty( $s['hero_image_alt'] ) ? $s['hero_image_alt'] : $s['heading'] ); ?>" loading="lazy" />
                    <?php else : ?>
                        <div class="amaley-blog-archive-hero__brand-mark" aria-hidden="true">
                            <span class="amaley-blog-archive-hero__orb"></span>
                            <span class="amaley-blog-archive-hero__mountain amaley-blog-archive-hero__mountain--one"></span>
                            <span class="amaley-blog-archive-hero__mountain amaley-blog-archive-hero__mountain--two"></span>
                            <span class="amaley-blog-archive-hero__mountain amaley-blog-archive-hero__mountain--three"></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php
    }
}
