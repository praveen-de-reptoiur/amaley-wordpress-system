<?php
/**
 * Amaley Member / Producer Archive Gallery Elementor widget.
 *
 * v1.0.116: Producer Archive Gallery full scoped controls.
 * Live-safe: controls are limited to gallery elements only. No grid/card/product/CTA controls.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

class Amaley_Core_Member_Archive_Gallery_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_core_member_archive_gallery';
    }

    public function get_title() {
        return esc_html__( 'Amaley Member Archive Gallery', 'amaley-core' );
    }

    public function get_icon() {
        return 'eicon-gallery-masonry';
    }

    public function get_categories() {
        return array( 'amaley-core' );
    }

    public function get_style_depends() {
        return array( 'amaley-core-member-archive-sections' );
    }

    private function defaults() {
        $renderer = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
        return $renderer->gallery_defaults();
    }

    protected function register_controls() {
        $d = $this->defaults();

        $this->start_controls_section( 'content_display', array(
            'label' => esc_html__( '1. Gallery Content / Show-Hide', 'amaley-core' ),
        ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Gallery Section', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_section'] ?? '1',
        ) );

        $this->add_control( 'show_label', array(
            'label'        => esc_html__( 'Show Section Label', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_label'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'show_title', array(
            'label'        => esc_html__( 'Show Section Title', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_title'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'show_description', array(
            'label'        => esc_html__( 'Show Section Description', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_description'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'show_caption', array(
            'label'        => esc_html__( 'Show Image Caption Box', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_caption'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'caption_label_display', array(
            'label'     => esc_html__( 'Caption Small Label', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'block',
            'options'   => array(
                'block' => esc_html__( 'Show', 'amaley-core' ),
                'none'  => esc_html__( 'Hide', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span' => 'display: {{VALUE}};',
            ),
            'condition' => array( 'show_caption' => '1' ),
        ) );

        $this->add_control( 'caption_title_display', array(
            'label'     => esc_html__( 'Image Title', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'block',
            'options'   => array(
                'block' => esc_html__( 'Show', 'amaley-core' ),
                'none'  => esc_html__( 'Hide', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong' => 'display: {{VALUE}};',
            ),
            'condition' => array( 'show_caption' => '1' ),
        ) );

        $this->add_control( 'show_empty_fallback', array(
            'label'        => esc_html__( 'Show Empty/Fallback Card', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_empty_fallback'] ?? '1',
            'condition'    => array( 'show_section' => '1' ),
        ) );

        $this->add_control( 'label', array(
            'label'       => esc_html__( 'Section Label Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['label'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_label' => '1' ),
        ) );

        $this->add_control( 'title', array(
            'label'       => esc_html__( 'Section Title Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['title'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_title' => '1' ),
        ) );

        $this->add_control( 'description', array(
            'label'       => esc_html__( 'Section Description Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => $d['description'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_description' => '1' ),
        ) );

        $this->add_control( 'caption_label', array(
            'label'       => esc_html__( 'Caption Small Label Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['caption_label'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_caption' => '1' ),
        ) );

        $this->add_control( 'empty_message', array(
            'label'       => esc_html__( 'Fallback Message', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => $d['empty_message'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_empty_fallback' => '1' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'data', array(
            'label' => esc_html__( '2. Gallery Images / Source', 'amaley-core' ),
        ) );

        $this->add_control( 'gallery_source', array(
            'label'   => esc_html__( 'Gallery Source', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => $d['gallery_source'] ?? 'manual',
            'options' => array(
                'manual'              => esc_html__( 'Manual Elementor Images', 'amaley-core' ),
                'manual_then_records' => esc_html__( 'Manual Images, then Member Records', 'amaley-core' ),
                'member_records'      => esc_html__( 'Member Records Only', 'amaley-core' ),
            ),
        ) );

        $this->add_control( 'manual_gallery', array(
            'label'       => esc_html__( 'Manual Gallery Images', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::GALLERY,
            'default'     => $d['manual_gallery'] ?? array(),
            'description' => esc_html__( 'Archive page ke liye yahi safest source hai. Images Elementor se manually select/upload hongi.', 'amaley-core' ),
            'condition'   => array( 'gallery_source!' => 'member_records' ),
        ) );

        $this->add_control( 'manual_caption_source', array(
            'label'     => esc_html__( 'Manual Caption Source', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => $d['manual_caption_source'] ?? 'attachment_title',
            'options'   => array(
                'attachment_title'   => esc_html__( 'Attachment Title', 'amaley-core' ),
                'attachment_caption' => esc_html__( 'Attachment Caption', 'amaley-core' ),
                'attachment_alt'     => esc_html__( 'Attachment Alt Text', 'amaley-core' ),
                'fallback'           => esc_html__( 'Fallback Message', 'amaley-core' ),
            ),
            'condition' => array( 'gallery_source!' => 'member_records' ),
        ) );

        $this->add_control( 'limit', array(
            'label'   => esc_html__( 'Image Limit', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 24,
            'default' => $d['limit'] ?? 6,
        ) );

        $this->add_control( 'record_source_note', array(
            'type'            => \Elementor\Controls_Manager::RAW_HTML,
            'raw'             => esc_html__( 'Neeche ke filters sirf Member Records source ke liye hain. Manual archive gallery me inki zarurat nahi hai.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            'condition'       => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->add_control( 'shg_id', array(
            'label'       => esc_html__( 'Filter by SHG ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['shg_id'] ?? '',
            'label_block' => true,
            'condition'   => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->add_control( 'cluster_id', array(
            'label'       => esc_html__( 'Filter by Cluster ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['cluster_id'] ?? '',
            'label_block' => true,
            'condition'   => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->add_control( 'featured_only', array(
            'label'        => esc_html__( 'Featured Only', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['featured_only'] ?? '',
            'condition'    => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->add_control( 'show_only_website', array(
            'label'        => esc_html__( 'Show Only Website-visible', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default'      => $d['show_only_website'] ?? '',
            'condition'    => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->add_control( 'status', array(
            'label'     => esc_html__( 'Status', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => $d['status'] ?? '',
            'options'   => array(
                ''         => esc_html__( 'Any', 'amaley-core' ),
                'active'   => esc_html__( 'Active', 'amaley-core' ),
                'inactive' => esc_html__( 'Inactive', 'amaley-core' ),
                'pending'  => esc_html__( 'Pending', 'amaley-core' ),
            ),
            'condition' => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->add_control( 'order_by', array(
            'label'     => esc_html__( 'Order By', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => $d['order_by'] ?? 'menu_order',
            'options'   => array(
                'menu_order' => esc_html__( 'Menu Order + Title', 'amaley-core' ),
                'title'      => esc_html__( 'Title', 'amaley-core' ),
                'date'       => esc_html__( 'Date', 'amaley-core' ),
                'modified'   => esc_html__( 'Modified', 'amaley-core' ),
                'rand'       => esc_html__( 'Random', 'amaley-core' ),
            ),
            'condition' => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->add_control( 'order', array(
            'label'     => esc_html__( 'Order', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => $d['order'] ?? 'ASC',
            'options'   => array(
                'ASC'  => 'ASC',
                'DESC' => 'DESC',
            ),
            'condition' => array( 'gallery_source!' => 'manual' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'layout', array(
            'label' => esc_html__( '3. Gallery Layout / Columns', 'amaley-core' ),
        ) );

        $this->add_control( 'columns_desktop', array(
            'label'   => esc_html__( 'Columns Desktop', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 5,
            'default' => $d['columns_desktop'] ?? 3,
        ) );

        $this->add_control( 'columns_tablet', array(
            'label'   => esc_html__( 'Columns Tablet', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 4,
            'default' => $d['columns_tablet'] ?? 2,
        ) );

        $this->add_control( 'columns_mobile', array(
            'label'   => esc_html__( 'Columns Mobile', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 2,
            'default' => $d['columns_mobile'] ?? 1,
        ) );

        $this->add_responsive_control( 'gallery_gap_content', array(
            'label'      => esc_html__( 'Gallery Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_section_box', array(
            'label' => esc_html__( '4. Gallery Section Background / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'section_bg', array(
            'label'     => esc_html__( 'Section Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-section' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'content_width', array(
            'label'      => esc_html__( 'Content Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 720, 'max' => 1600 ),
                '%'  => array( 'min' => 60, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'wrap_padding', array(
            'label'      => esc_html__( 'Inner Side Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_heading', array(
            'label' => esc_html__( '5. Gallery Heading / Label / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'heading_align', array(
            'label'     => esc_html__( 'Heading Alignment', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-section-head' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'heading_max_width', array(
            'label'      => esc_html__( 'Heading Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 320, 'max' => 1100 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-section-head' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'heading_bottom_gap', array(
            'label'      => esc_html__( 'Heading to Gallery Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 90 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-section-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-kicker' => 'color: {{VALUE}};',
            ),
            'condition' => array( 'show_label' => '1' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'      => 'label_typography',
            'label'     => esc_html__( 'Label Typography', 'amaley-core' ),
            'selector'  => '{{WRAPPER}} .ampa-gallery-section .ampa-kicker',
            'condition' => array( 'show_label' => '1' ),
        ) );

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'condition'  => array( 'show_label' => '1' ),
        ) );

        $this->add_control( 'heading_color', array(
            'label'     => esc_html__( 'Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-section-title' => 'color: {{VALUE}};',
            ),
            'condition' => array( 'show_title' => '1' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'      => 'heading_typography',
            'label'     => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector'  => '{{WRAPPER}} .ampa-gallery-section .ampa-section-title',
            'condition' => array( 'show_title' => '1' ),
        ) );

        $this->add_responsive_control( 'heading_margin', array(
            'label'      => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'condition'  => array( 'show_title' => '1' ),
        ) );

        $this->add_control( 'desc_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-section-desc' => 'color: {{VALUE}};',
            ),
            'condition' => array( 'show_description' => '1' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'      => 'desc_typography',
            'label'     => esc_html__( 'Description Typography', 'amaley-core' ),
            'selector'  => '{{WRAPPER}} .ampa-gallery-section .ampa-section-desc',
            'condition' => array( 'show_description' => '1' ),
        ) );

        $this->add_responsive_control( 'desc_margin', array(
            'label'      => esc_html__( 'Description Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-section .ampa-section-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'condition'  => array( 'show_description' => '1' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_gallery_cards', array(
            'label' => esc_html__( '6. Gallery Cards / Image', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'image_height', array(
            'label'      => esc_html__( 'Image / Card Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 110, 'max' => 480 ) ),
            'default'    => array( 'size' => 168, 'unit' => 'px' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' => 'height: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'image_fit', array(
            'label'     => esc_html__( 'Image Fit', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'cover',
            'options'   => array(
                'cover'   => esc_html__( 'Cover', 'amaley-core' ),
                'contain' => esc_html__( 'Contain', 'amaley-core' ),
                'fill'    => esc_html__( 'Fill', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card img' => 'object-fit: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'image_position', array(
            'label'     => esc_html__( 'Image Position', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'center center',
            'options'   => array(
                'center center' => esc_html__( 'Center Center', 'amaley-core' ),
                'center top'    => esc_html__( 'Center Top', 'amaley-core' ),
                'center bottom' => esc_html__( 'Center Bottom', 'amaley-core' ),
                'left center'   => esc_html__( 'Left Center', 'amaley-core' ),
                'right center'  => esc_html__( 'Right Center', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card img' => 'object-position: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'card_radius', array(
            'label'      => esc_html__( 'Card Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 70 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' => 'border-radius: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'card_border_width', array(
            'label'      => esc_html__( 'Card Border Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 8 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
            ),
        ) );

        $this->start_controls_tabs( 'gallery_card_state_tabs' );

        $this->start_controls_tab( 'gallery_card_normal_tab', array(
            'label' => esc_html__( 'Normal', 'amaley-core' ),
        ) );

        $this->add_control( 'card_border_color', array(
            'label'     => esc_html__( 'Card Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'fallback_card_bg', array(
            'label'     => esc_html__( 'Fallback Card Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-empty-card' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'gallery_card_shadow',
            'label'    => esc_html__( 'Card Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card',
        ) );

        $this->end_controls_tab();

        $this->start_controls_tab( 'gallery_card_hover_tab', array(
            'label' => esc_html__( 'Hover', 'amaley-core' ),
        ) );

        $this->add_control( 'card_hover_border_color', array(
            'label'     => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card:hover' => 'border-color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'gallery_card_hover_shadow',
            'label'    => esc_html__( 'Hover Shadow', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-gallery-card:hover',
        ) );

        $this->add_responsive_control( 'image_hover_zoom', array(
            'label'      => esc_html__( 'Image Hover Zoom', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( '%' ),
            'range'      => array( '%' => array( 'min' => 100, 'max' => 125 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card:hover img' => 'transform: scale(calc({{SIZE}} / 100));',
            ),
        ) );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section( 'style_caption', array(
            'label' => esc_html__( '7. Gallery Caption / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'overlay_color', array(
            'label'     => esc_html__( 'Overlay Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card::after, {{WRAPPER}} .ampa-gallery-empty-card::after' => 'background: linear-gradient(180deg, rgba(46,18,3,0) 35%, {{VALUE}} 100%);',
            ),
        ) );

        $this->add_responsive_control( 'caption_padding', array(
            'label'      => esc_html__( 'Caption Position / Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption' => 'left: {{LEFT}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
            ),
            'condition'  => array( 'show_caption' => '1' ),
        ) );

        $this->add_responsive_control( 'caption_align', array(
            'label'     => esc_html__( 'Caption Alignment', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption, {{WRAPPER}} .ampa-gallery-empty-card' => 'text-align: {{VALUE}};',
            ),
            'condition' => array( 'show_caption' => '1' ),
        ) );

        $this->add_control( 'caption_label_color', array(
            'label'     => esc_html__( 'Caption Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'caption_label_typography',
            'label'    => esc_html__( 'Caption Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span',
        ) );

        $this->add_responsive_control( 'caption_label_margin', array(
            'label'      => esc_html__( 'Caption Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'caption_title_color', array(
            'label'     => esc_html__( 'Image Title Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'caption_title_typography',
            'label'    => esc_html__( 'Image Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong',
        ) );

        $this->add_responsive_control( 'caption_title_margin', array(
            'label'      => esc_html__( 'Image Title Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_empty', array(
            'label' => esc_html__( '8. Gallery Empty / Fallback', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'fallback_max_width', array(
            'label'      => esc_html__( 'Fallback Card Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 220, 'max' => 900 ),
                '%'  => array( 'min' => 20, 'max' => 100 ),
            ),
            'default'    => array( 'size' => 430, 'unit' => 'px' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-empty-card' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
            'condition'  => array( 'show_empty_fallback' => '1' ),
        ) );

        $this->add_responsive_control( 'fallback_padding', array(
            'label'      => esc_html__( 'Fallback Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-empty-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'condition'  => array( 'show_empty_fallback' => '1' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_motion', array(
            'label' => esc_html__( '9. Gallery Animation / Motion', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'motion_note', array(
            'type'            => \Elementor\Controls_Manager::RAW_HTML,
            'raw'             => esc_html__( 'Motion controls are scoped only to Producer Archive Gallery cards.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_responsive_control( 'gallery_hover_lift', array(
            'label'      => esc_html__( 'Card Hover Lift', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 24 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card:hover' => 'transform: translateY(calc({{SIZE}}{{UNIT}} * -1));',
            ),
        ) );

        $this->add_responsive_control( 'gallery_transition_duration', array(
            'label'      => esc_html__( 'Transition Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range'      => array( 'ms' => array( 'min' => 0, 'max' => 1200 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-card img' => 'transition-duration: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
        echo $renderer->render_gallery( $this->get_settings_for_display() );
    }
}
