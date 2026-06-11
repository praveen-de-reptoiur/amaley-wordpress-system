<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Single_Hero_Clean_Widget extends Amaley_Blog_Elementor_Base {
    public function get_name() {
        return 'amaley_single_hero_full_width_v142';
    }

    public function get_title() {
        return __( 'Amaley Single Hero — Full Width', 'amaley-blog-system' );
    }

    public function get_icon() {
        return 'eicon-featured-image';
    }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
        $this->register_visibility_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section(
            'single_hero_content',
            array(
                'label' => __( 'Single Hero Content', 'amaley-blog-system' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'hero_note',
            array(
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw'  => __( 'Use this full-width hero at the top of Blog Detail Template, above Amaley Single Article Layout — Clean.', 'amaley-blog-system' ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            )
        );

        $this->add_control( 'show_breadcrumb', array( 'label' => __( 'Show Breadcrumb', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => '' ) );
        $this->add_control( 'breadcrumb_blog_label', array( 'label' => __( 'Blog Label', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Blog', 'amaley-blog-system' ), 'condition' => array( 'show_breadcrumb' => 'yes' ) ) );
        $this->add_control( 'show_category', array_merge( array( 'label' => __( 'Show Category Chip', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_title', array_merge( array( 'label' => __( 'Show Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_excerpt', array_merge( array( 'label' => __( 'Show Excerpt', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'excerpt_length', array( 'label' => __( 'Excerpt Length', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 24, 'min' => 8, 'max' => 80, 'condition' => array( 'show_excerpt' => 'yes' ) ) );
        $this->add_control( 'show_meta', array_merge( array( 'label' => __( 'Show Meta Row', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_date', array_merge( array( 'label' => __( 'Show Date', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'condition' => array( 'show_meta' => 'yes' ) ), $this->switch_default() ) );
        $this->add_control( 'show_author', array_merge( array( 'label' => __( 'Show Author', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'condition' => array( 'show_meta' => 'yes' ) ), $this->switch_default() ) );
        $this->add_control( 'show_reading_time', array_merge( array( 'label' => __( 'Show Reading Time', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'condition' => array( 'show_meta' => 'yes' ) ), $this->switch_default() ) );
        $this->add_control(
            'fallback_image',
            array(
                'label' => __( 'Fallback Image', 'amaley-blog-system' ),
                'type'  => \Elementor\Controls_Manager::MEDIA,
                'description' => __( 'Used when the post has no featured image.', 'amaley-blog-system' ),
            )
        );

        $this->end_controls_section();
    }

    private function register_style_controls() {
        $this->start_controls_section( 'hero_wrapper_style', array( 'label' => __( 'Hero Wrapper', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'hero_wrapper_tabs' );

        $this->start_controls_tab( 'hero_container_tab', array( 'label' => __( 'Container', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'hero_max_width', array( 'label' => __( 'Content Max Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 760, 'max' => 1800 ), '%' => array( 'min' => 70, 'max' => 100 ) ), 'default' => array( 'size' => 1180, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_min_height', array( 'label' => __( 'Min Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vh' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 760 ), 'vh' => array( 'min' => 22, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_content_width', array( 'label' => __( 'Text Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%', 'px' ), 'range' => array( '%' => array( 'min' => 35, 'max' => 100 ), 'px' => array( 'min' => 360, 'max' => 980 ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__content' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_content_align', array( 'label' => __( 'Text Alignment', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => __( 'Left', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => __( 'Center', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => __( 'Right', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__content' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_vertical_align', array( 'label' => __( 'Vertical Alignment', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center', 'options' => array( 'flex-start' => __( 'Top', 'amaley-blog-system' ), 'center' => __( 'Middle', 'amaley-blog-system' ), 'flex-end' => __( 'Bottom', 'amaley-blog-system' ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__inner' => 'justify-content: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_items_align', array( 'label' => __( 'Content Items Align', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'flex-start', 'options' => array( 'flex-start' => __( 'Start', 'amaley-blog-system' ), 'center' => __( 'Center', 'amaley-blog-system' ), 'flex-end' => __( 'End', 'amaley-blog-system' ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__content' => 'align-items: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_spacing_tab', array( 'label' => __( 'Spacing', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'hero_outer_padding', array( 'label' => __( 'Section Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'rem', '%' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_widget_margin', array( 'label' => __( 'Widget Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'rem', '%' ), 'selectors' => array( '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_card_padding', array( 'label' => __( 'Card Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'rem', '%' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_text_gap', array( 'label' => __( 'Text Gap / Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__content' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_surface_tab', array( 'label' => __( 'Surface', 'amaley-blog-system' ) ) );
        $this->add_control( 'hero_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'hero_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'hero_border', 'selector' => '{{WRAPPER}} .abs1-hero' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'hero_shadow', 'selector' => '{{WRAPPER}} .abs1-hero' ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'hero_text_style', array( 'label' => __( 'Hero Text', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'hero_text_tabs' );

        $this->start_controls_tab( 'hero_breadcrumb_tab', array( 'label' => __( 'Breadcrumb', 'amaley-blog-system' ) ) );
        $this->add_control( 'breadcrumb_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__breadcrumb, {{WRAPPER}} .abs1-hero__breadcrumb a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'breadcrumb_sep_color', array( 'label' => __( 'Separator Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__breadcrumb span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'breadcrumb_typography', 'selector' => '{{WRAPPER}} .abs1-hero__breadcrumb' ) );
        $this->add_responsive_control( 'breadcrumb_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs1-hero__breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_chip_tab', array( 'label' => __( 'Chip', 'amaley-blog-system' ) ) );
        $this->add_control( 'chip_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__chip' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'chip_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__chip' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'chip_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs1-hero__chip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'chip_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs1-hero__chip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'chip_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs1-hero__chip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'chip_typography', 'selector' => '{{WRAPPER}} .abs1-hero__chip' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'chip_shadow', 'selector' => '{{WRAPPER}} .abs1-hero__chip' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_heading_tab', array( 'label' => __( 'Heading', 'amaley-blog-system' ) ) );
        $this->add_control( 'title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .abs1-hero__title' ) );
        $this->add_responsive_control( 'title_spacing', array( 'label' => __( 'Title Bottom Spacing', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'title_margin', array( 'label' => __( 'Title Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs1-hero__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_meta_tab', array( 'label' => __( 'Meta / Excerpt', 'amaley-blog-system' ) ) );
        $this->add_control( 'meta_color', array( 'label' => __( 'Meta Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__meta' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'excerpt_color', array( 'label' => __( 'Excerpt Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__excerpt' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'excerpt_typography', 'selector' => '{{WRAPPER}} .abs1-hero__excerpt' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_typography', 'selector' => '{{WRAPPER}} .abs1-hero__meta' ) );
        $this->add_responsive_control( 'excerpt_margin', array( 'label' => __( 'Excerpt Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs1-hero__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'meta_gap', array( 'label' => __( 'Meta Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', 'rem' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__meta' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'hero_media_style', array( 'label' => __( 'Hero Image / Media', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'hero_media_tabs' );

        $this->start_controls_tab( 'hero_image_tab', array( 'label' => __( 'Image', 'amaley-blog-system' ) ) );
        $this->add_control( 'image_fit', array( 'label' => __( 'Object Fit', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill', 'none' => 'None' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__image' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'image_x', array( 'label' => __( 'Horizontal Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 50, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__image' => 'object-position: {{SIZE}}% var(--abs1-hero-y, 50%);' ) ) );
        $this->add_responsive_control( 'image_y', array( 'label' => __( 'Vertical Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 50, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__image' => '--abs1-hero-y: {{SIZE}}%;' ) ) );
        $this->add_control( 'image_opacity', array( 'label' => __( 'Image Opacity', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0.1, 'max' => 1, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__image' => 'opacity: {{SIZE}};' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => __( 'Image / Media Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__media, {{WRAPPER}} .abs1-hero__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'image_margin', array( 'label' => __( 'Media Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => array( '{{WRAPPER}} .abs1-hero__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_overlay_tab', array( 'label' => __( 'Overlay', 'amaley-blog-system' ) ) );
        $this->add_control( 'overlay_color', array( 'label' => __( 'Overlay Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .abs1-hero__overlay' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'overlay_opacity', array( 'label' => __( 'Overlay Opacity', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__overlay' => 'opacity: {{SIZE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'hero_hover_tab', array( 'label' => __( 'Hover', 'amaley-blog-system' ) ) );
        $this->add_control( 'enable_image_hover', array( 'label' => __( 'Enable Image Hover Zoom', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hero-hover-' ) );
        $this->add_control( 'image_hover_scale', array( 'label' => __( 'Hover Scale', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.2, 'step' => 0.01 ) ), 'default' => array( 'size' => 1.04 ), 'selectors' => array( '{{WRAPPER}}.abs1-hero-hover-yes .abs1-hero:hover .abs1-hero__image' => 'transform: scale({{SIZE}});' ), 'condition' => array( 'enable_image_hover' => 'yes' ) ) );
        $this->add_control( 'image_transition_duration', array( 'label' => __( 'Transition Duration', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 's' ), 'range' => array( 's' => array( 'min' => 0.1, 'max' => 2, 'step' => 0.1 ) ), 'selectors' => array( '{{WRAPPER}} .abs1-hero__image' => 'transition-duration: {{SIZE}}s;' ) ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_visibility_controls() {
        $this->start_controls_section( 'hero_visibility_section', array( 'label' => __( 'Device Visibility', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_ADVANCED ) );
        $this->add_control( 'hide_hero_desktop', array( 'label' => __( 'Hide Hero on Desktop', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-hero-desktop-' ) );
        $this->add_control( 'hide_hero_tablet', array( 'label' => __( 'Hide Hero on Tablet', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-hero-tablet-' ) );
        $this->add_control( 'hide_hero_mobile', array( 'label' => __( 'Hide Hero on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-hero-mobile-' ) );
        $this->add_control( 'hide_breadcrumb_mobile', array( 'label' => __( 'Hide Breadcrumb on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-breadcrumb-mobile-' ) );
        $this->add_control( 'hide_chip_mobile', array( 'label' => __( 'Hide Chip on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-chip-mobile-' ) );
        $this->add_control( 'hide_media_mobile', array( 'label' => __( 'Hide Background Image on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-media-mobile-' ) );
        $this->add_control( 'hide_excerpt_mobile', array( 'label' => __( 'Hide Excerpt on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-excerpt-mobile-' ) );
        $this->add_control( 'hide_meta_mobile', array( 'label' => __( 'Hide Meta on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'prefix_class' => 'abs1-hide-meta-mobile-' ) );
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

    private function post_image( $post_id, $fallback = '' ) {
        $image = get_the_post_thumbnail_url( $post_id, 'full' );
        if ( ! $image && $fallback ) {
            $image = $fallback;
        }
        if ( ! $image ) {
            $image = Amaley_Blog_Renderer::asset_url( 'assets/img/blog-single-placeholder.svg' );
        }
        return $image;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $post_id = $this->context_post_id();
        if ( ! $post_id ) {
            echo '<section class="abs1-hero"><div class="abs1-hero__inner"><p>' . esc_html__( 'No post available for preview.', 'amaley-blog-system' ) . '</p></div></section>';
            return;
        }

        $title    = get_the_title( $post_id );
        $category = Amaley_Blog_Renderer::primary_category( $post_id );
        $fallback = ! empty( $settings['fallback_image']['url'] ) ? esc_url( $settings['fallback_image']['url'] ) : '';
        $image    = $this->post_image( $post_id, $fallback );
        $excerpt  = Amaley_Blog_Renderer::excerpt( $post_id, ! empty( $settings['excerpt_length'] ) ? absint( $settings['excerpt_length'] ) : 24 );
        ?>
        <section class="abs1-hero" aria-label="<?php echo esc_attr( $title ); ?>">
            <div class="abs1-hero__media" aria-hidden="true">
                <img class="abs1-hero__image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
            </div>
            <span class="abs1-hero__overlay" aria-hidden="true"></span>
            <div class="abs1-hero__inner">
                <?php if ( ! empty( $settings['show_breadcrumb'] ) && 'yes' === $settings['show_breadcrumb'] ) : ?>
                    <nav class="abs1-hero__breadcrumb" aria-label="<?php echo esc_attr__( 'Breadcrumb', 'amaley-blog-system' ); ?>">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'amaley-blog-system' ); ?></a>
                        <span>›</span>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ? get_post_type_archive_link( 'post' ) : home_url( '/blog/' ) ); ?>"><?php echo esc_html( $settings['breadcrumb_blog_label'] ); ?></a>
                        <span>›</span>
                        <strong><?php echo esc_html( wp_trim_words( $title, 8, '…' ) ); ?></strong>
                    </nav>
                <?php endif; ?>
                <div class="abs1-hero__content">
                    <?php if ( ! empty( $settings['show_category'] ) && 'yes' === $settings['show_category'] && $category ) : ?>
                        <span class="abs1-hero__chip"><?php echo esc_html( $category->name ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $settings['show_title'] ) && 'yes' === $settings['show_title'] ) : ?>
                        <h1 class="abs1-hero__title"><?php echo esc_html( $title ); ?></h1>
                    <?php endif; ?>
                    <?php if ( ! empty( $settings['show_excerpt'] ) && 'yes' === $settings['show_excerpt'] && $excerpt ) : ?>
                        <p class="abs1-hero__excerpt"><?php echo esc_html( $excerpt ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $settings['show_meta'] ) && 'yes' === $settings['show_meta'] ) : ?>
                        <div class="abs1-hero__meta">
                            <?php if ( ! empty( $settings['show_date'] ) && 'yes' === $settings['show_date'] ) : ?><span><?php echo esc_html( get_the_date( 'M j, Y', $post_id ) ); ?></span><?php endif; ?>
                            <?php if ( ! empty( $settings['show_reading_time'] ) && 'yes' === $settings['show_reading_time'] ) : ?><span><?php echo esc_html( Amaley_Blog_Reading_Time::get_label( $post_id ) ); ?></span><?php endif; ?>
                            <?php if ( ! empty( $settings['show_author'] ) && 'yes' === $settings['show_author'] ) : ?><span><?php echo esc_html( get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) ) ); ?></span><?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
