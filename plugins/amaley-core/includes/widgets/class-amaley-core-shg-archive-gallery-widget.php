<?php
/**
 * Amaley SHG Archive Gallery Elementor widget.
 *
 * v1.0.105 — SHG Archive Gallery full-control pass.
 * Live-site safe scope: Elementor controls only. No data, query, CPT,
 * mapping, product, photo, page-template, or renderer logic changes.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_SHG_Archive_Gallery_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_core_shg_archive_gallery';
    }

    public function get_title() {
        return esc_html__( 'Amaley SHG Archive Gallery', 'amaley-core' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return array( 'amaley-core' );
    }

    public function get_style_depends() {
        return array( 'amaley-core-shg-archive-sections' );
    }

    public function get_keywords() {
        return array( 'amaley', 'shg', 'archive', 'gallery', 'photos' );
    }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        $d        = $renderer->gallery_defaults();

        /* --------------------------------------------------------------------
         * CONTENT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'content', array(
            'label' => esc_html__( 'Content', 'amaley-core' ),
        ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Section', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_section'],
        ) );

        $this->add_control( 'label', array(
            'label'   => esc_html__( 'Small Label', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => $d['label'],
        ) );

        $this->add_control( 'title', array(
            'label'   => esc_html__( 'Title', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => $d['title'],
        ) );

        $this->add_control( 'description', array(
            'label'   => esc_html__( 'Description', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => $d['description'],
        ) );

        $this->add_control( 'empty_message', array(
            'label'       => esc_html__( 'Empty Message', 'amaley-core' ),
            'description' => esc_html__( 'Shown only when no gallery images are available from SHG records.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 2,
            'default'     => $d['empty_message'],
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * DATA SOURCE / QUERY — original logic preserved.
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'query', array(
            'label' => esc_html__( 'Data Source / Query', 'amaley-core' ),
        ) );

        $this->add_control( 'limit', array(
            'label'   => esc_html__( 'Image Limit', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 40,
            'default' => $d['limit'],
        ) );

        $this->add_control( 'cluster_id', array(
            'label'       => esc_html__( 'Filter by Cluster ID', 'amaley-core' ),
            'description' => esc_html__( 'Optional. Leave blank to show gallery images from all SHG groups.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['cluster_id'],
        ) );

        $this->add_control( 'featured_only', array(
            'label'        => esc_html__( 'Featured Only', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['featured_only'],
        ) );

        $this->add_control( 'show_only_website', array(
            'label'        => esc_html__( 'Show Only Website-visible', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_only_website'],
        ) );

        $this->add_control( 'verification_status', array(
            'label'   => esc_html__( 'Verification Status Filter', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => $d['verification_status'],
            'options' => array(
                ''         => esc_html__( 'Any', 'amaley-core' ),
                'verified' => esc_html__( 'Verified', 'amaley-core' ),
                'pending'  => esc_html__( 'Pending', 'amaley-core' ),
                'review'   => esc_html__( 'Needs Review', 'amaley-core' ),
            ),
        ) );

        $this->add_control( 'order_by', array(
            'label'   => esc_html__( 'Order By', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => $d['order_by'],
            'options' => array(
                'menu_order' => esc_html__( 'Menu Order', 'amaley-core' ),
                'title'      => esc_html__( 'Title', 'amaley-core' ),
                'date'       => esc_html__( 'Date', 'amaley-core' ),
                'modified'   => esc_html__( 'Modified', 'amaley-core' ),
                'rand'       => esc_html__( 'Random', 'amaley-core' ),
            ),
        ) );

        $this->add_control( 'order', array(
            'label'   => esc_html__( 'Order', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => $d['order'],
            'options' => array(
                'ASC'  => esc_html__( 'ASC', 'amaley-core' ),
                'DESC' => esc_html__( 'DESC', 'amaley-core' ),
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * SHOW / HIDE
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'visibility', array(
            'label' => esc_html__( 'Show / Hide', 'amaley-core' ),
        ) );

        foreach ( array(
            'show_label'       => 'Small Label',
            'show_title'       => 'Title',
            'show_description' => 'Description',
            'show_caption'     => 'Image Captions',
        ) as $key => $label ) {
            $this->add_control( $key, array(
                'label'        => esc_html( $label ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default'      => isset( $d[ $key ] ) ? $d[ $key ] : '1',
            ) );
        }

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * GALLERY LAYOUT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'layout', array(
            'label' => esc_html__( 'Gallery Layout', 'amaley-core' ),
        ) );

        $this->add_control( 'columns_desktop', array(
            'label'   => esc_html__( 'Columns Desktop', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 6,
            'default' => $d['columns_desktop'],
        ) );

        $this->add_control( 'columns_tablet', array(
            'label'   => esc_html__( 'Columns Tablet', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 4,
            'default' => $d['columns_tablet'],
        ) );

        $this->add_control( 'columns_mobile', array(
            'label'   => esc_html__( 'Columns Mobile', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 2,
            'default' => $d['columns_mobile'],
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: SECTION BACKGROUND / BOX
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'section_box_style', array(
            'label' => esc_html__( 'Section Background / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background',
            'label'    => esc_html__( 'Section Background', 'amaley-core' ),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-section',
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'section_border',
            'label'    => esc_html__( 'Section Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-section',
        ) );

        $this->add_responsive_control( 'section_radius', array(
            'label'      => esc_html__( 'Section Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'section_shadow',
            'label'    => esc_html__( 'Section Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-section',
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: LAYOUT / SPACING
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'layout_spacing_style', array(
            'label' => esc_html__( 'Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'wrap_max_width', array(
            'label'      => esc_html__( 'Container Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 760, 'max' => 1600 ),
                '%'  => array( 'min' => 60, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-archive-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'wrap_padding', array(
            'label'      => esc_html__( 'Container Side Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'allowed_dimensions' => array( 'left', 'right' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-archive-wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'heading_bottom_gap', array(
            'label'      => esc_html__( 'Heading to Gallery Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 90 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'heading_max_width', array(
            'label'      => esc_html__( 'Heading Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 360, 'max' => 1100 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'heading_align', array(
            'label'   => esc_html__( 'Heading Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: HEADING / LABEL / TEXT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'heading_text_style', array(
            'label' => esc_html__( 'Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_style_heading', array(
            'label' => esc_html__( 'Small Label', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-kicker' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-kicker',
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'title_style_heading', array(
            'label'     => esc_html__( 'Title', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-section-title' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-section-title',
        ) );

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'description_style_heading', array(
            'label'     => esc_html__( 'Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'description_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-section-desc' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'description_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-section-desc',
        ) );

        $this->add_responsive_control( 'description_margin', array(
            'label'      => esc_html__( 'Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-head .amaley-core-shg-section-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: GALLERY GRID / CARDS
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'gallery_card_style', array(
            'label' => esc_html__( 'Gallery Cards / Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'gallery_gap', array(
            'label'      => esc_html__( 'Gallery Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'card_min_height', array(
            'label'      => esc_html__( 'Card / Image Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range'      => array(
                'px' => array( 'min' => 140, 'max' => 620 ),
                'vh' => array( 'min' => 20, 'max' => 80 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card' => 'height: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'card_border',
            'label'    => esc_html__( 'Card Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-card',
        ) );

        $this->add_responsive_control( 'card_radius', array(
            'label'      => esc_html__( 'Card Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ),
        ) );

        $this->start_controls_tabs( 'card_state_tabs' );

        $this->start_controls_tab( 'card_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'card_background', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'card_shadow',
            'label'    => esc_html__( 'Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-card',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'card_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'card_hover_background', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card:hover' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'card_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'card_hover_shadow',
            'label'    => esc_html__( 'Hover Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-card:hover',
        ) );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: IMAGE / MEDIA
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'image_media_style', array(
            'label' => esc_html__( 'Image / Media', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'image_object_position', array(
            'label'   => esc_html__( 'Image Position', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''              => esc_html__( 'Default', 'amaley-core' ),
                'center center' => esc_html__( 'Center Center', 'amaley-core' ),
                'center top'    => esc_html__( 'Center Top', 'amaley-core' ),
                'center bottom' => esc_html__( 'Center Bottom', 'amaley-core' ),
                'left center'   => esc_html__( 'Left Center', 'amaley-core' ),
                'right center'  => esc_html__( 'Right Center', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card img' => 'object-position: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'image_opacity', array(
            'label'      => esc_html__( 'Image Opacity', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( '%' ),
            'range'      => array( '%' => array( 'min' => 20, 'max' => 100 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card img' => 'opacity: calc({{SIZE}} / 100);',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Css_Filter::get_type(), array(
            'name'     => 'image_css_filters',
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-card img',
        ) );

        $this->add_control( 'image_hover_zoom', array(
            'label'       => esc_html__( 'Image Hover Zoom', 'amaley-core' ),
            'description' => esc_html__( 'Controls card image zoom on hover.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '1.018',
            'options'     => array(
                '1'     => esc_html__( 'None', 'amaley-core' ),
                '1.012' => esc_html__( 'Very Soft', 'amaley-core' ),
                '1.018' => esc_html__( 'Soft', 'amaley-core' ),
                '1.035' => esc_html__( 'Visible', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => '--acore-image-zoom: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'image_transition_duration', array(
            'label'      => esc_html__( 'Image Transition Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range'      => array( 'ms' => array( 'min' => 100, 'max' => 1000, 'step' => 50 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card img' => 'transition-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: CAPTION OVERLAY / TEXT
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'caption_style', array(
            'label' => esc_html__( 'Caption Overlay / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'caption_padding', array(
            'label'      => esc_html__( 'Caption Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'caption_align', array(
            'label'   => esc_html__( 'Caption Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'caption_overlay_heading', array(
            'label' => esc_html__( 'Overlay Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
        ) );

        $this->start_controls_tabs( 'caption_overlay_tabs' );

        $this->start_controls_tab( 'caption_overlay_normal', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'caption_background', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'caption_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'caption_overlay_hover', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'caption_hover_background', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card:hover figcaption' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'caption_hover_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card:hover figcaption' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'caption_label_heading', array(
            'label'     => esc_html__( 'Caption Label', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'caption_label_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption span' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'caption_label_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption span',
        ) );

        $this->add_control( 'caption_title_heading', array(
            'label'     => esc_html__( 'Caption Title', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'caption_title_color', array(
            'label'     => esc_html__( 'Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'caption_title_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-card figcaption strong',
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: EMPTY MESSAGE
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'empty_style', array(
            'label' => esc_html__( 'Empty Message', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'empty_background', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-empty' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'empty_text_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-empty' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'empty_typography',
            'label'    => esc_html__( 'Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-empty',
        ) );

        $this->add_responsive_control( 'empty_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'empty_border',
            'label'    => esc_html__( 'Border', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-empty',
        ) );

        $this->add_responsive_control( 'empty_radius', array(
            'label'      => esc_html__( 'Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section .amaley-core-shg-empty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        /* --------------------------------------------------------------------
         * STYLE: ANIMATION / MICRO MOTION
         * -------------------------------------------------------------------- */
        $this->start_controls_section( 'motion_style', array(
            'label' => esc_html__( 'Animation / Micro Motion', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'motion_mode', array(
            'label'        => esc_html__( 'Section Animation', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SELECT,
            'default'      => 'on',
            'options'      => array(
                'on'  => esc_html__( 'On', 'amaley-core' ),
                'off' => esc_html__( 'Off', 'amaley-core' ),
            ),
            'prefix_class' => 'amaley-core-motion-',
        ) );

        $this->add_control( 'motion_duration', array(
            'label'      => esc_html__( 'Animation Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range'      => array( 'ms' => array( 'min' => 150, 'max' => 900, 'step' => 50 ) ),
            'default'    => array( 'size' => 520, 'unit' => 'ms' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => '--acore-motion-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->add_control( 'motion_distance', array(
            'label'      => esc_html__( 'Animation Lift Distance', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 18 ) ),
            'default'    => array( 'size' => 6, 'unit' => 'px' ),
            'selectors'  => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => '--acore-motion-y: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_lift', array(
            'label'       => esc_html__( 'Hover Lift', 'amaley-core' ),
            'description' => esc_html__( 'Keep 1–3px for smooth premium motion. Use 0 to disable lift.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => array( 'px' ),
            'range'       => array( 'px' => array( 'min' => 0, 'max' => 8 ) ),
            'default'     => array( 'size' => 2, 'unit' => 'px' ),
            'selectors'   => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => '--acore-hover-lift: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'hover_scale', array(
            'label'       => esc_html__( 'Hover Scale', 'amaley-core' ),
            'description' => esc_html__( 'Use Soft for smooth movement. Set None if the page feels heavy.', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '1.003',
            'options'     => array(
                '1'     => esc_html__( 'None', 'amaley-core' ),
                '1.003' => esc_html__( 'Soft', 'amaley-core' ),
                '1.006' => esc_html__( 'Medium', 'amaley-core' ),
                '1.01'  => esc_html__( 'Strong', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-core-shg-gallery-section' => '--acore-hover-scale: {{VALUE}};',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        echo $renderer->render_gallery( $this->get_settings_for_display() );
    }
}
