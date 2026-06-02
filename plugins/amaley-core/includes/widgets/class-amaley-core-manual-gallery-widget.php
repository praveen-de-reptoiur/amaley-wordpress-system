<?php
/**
 * Amaley Manual Gallery Section Elementor widget.
 *
 * Reusable manual image gallery for archive pages and landing sections.
 * Archive/page galleries use manually selected Elementor images; CPT single
 * galleries should continue using their own record-based gallery widgets.
 *
 * @package Amaley_Core
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Manual_Gallery_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_manual_gallery_section'; }
    public function get_title() { return esc_html__( 'Amaley Manual Gallery Section', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-archive-sections' ); }

    private function renderer() {
        if ( isset( $GLOBALS['amaley_core_member_archive_sections'] ) && is_object( $GLOBALS['amaley_core_member_archive_sections'] ) ) {
            return $GLOBALS['amaley_core_member_archive_sections'];
        }
        return new Amaley_Core_Member_Archive_Sections();
    }

    private function defaults() {
        return $this->renderer()->manual_gallery_defaults();
    }

    protected function register_controls() {
        $d = $this->defaults();

        $this->start_controls_section( 'content_display', array( 'label' => '1. Content + Show / Hide' ) );
        $this->add_control( 'show_section', array( 'label' => 'Show Section', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_section'] ?? '1' ) );
        $this->add_control( 'show_label', array( 'label' => 'Show Label', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_label'] ?? '1' ) );
        $this->add_control( 'show_title', array( 'label' => 'Show Title', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_title'] ?? '1' ) );
        $this->add_control( 'show_description', array( 'label' => 'Show Description', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_description'] ?? '1' ) );
        $this->add_control( 'show_caption', array( 'label' => 'Show Image Caption', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_caption'] ?? '1' ) );
        $this->add_control( 'show_empty_fallback', array( 'label' => 'Show Empty/Fallback Card', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_empty_fallback'] ?? '1' ) );
        $this->add_control( 'label', array( 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['label'] ?? '', 'label_block' => true, 'condition' => array( 'show_label' => '1' ) ) );
        $this->add_control( 'title', array( 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['title'] ?? '', 'label_block' => true, 'condition' => array( 'show_title' => '1' ) ) );
        $this->add_control( 'description', array( 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d['description'] ?? '', 'label_block' => true, 'condition' => array( 'show_description' => '1' ) ) );
        $this->add_control( 'caption_label', array( 'label' => 'Caption Small Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['caption_label'] ?? '', 'label_block' => true, 'condition' => array( 'show_caption' => '1' ) ) );
        $this->add_control( 'empty_message', array( 'label' => 'Fallback Message', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d['empty_message'] ?? '', 'label_block' => true, 'condition' => array( 'show_empty_fallback' => '1' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'manual_images', array( 'label' => '2. Manual Images' ) );
        $this->add_control( 'manual_gallery', array(
            'label' => 'Gallery Images',
            'type' => \Elementor\Controls_Manager::GALLERY,
            'default' => $d['manual_gallery'] ?? array(),
            'description' => 'Archive/page sections ke liye images yahin se manually select/upload karein.',
        ) );
        $this->add_control( 'manual_caption_source', array(
            'label' => 'Caption Source',
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => $d['manual_caption_source'] ?? 'attachment_title',
            'options' => array(
                'attachment_title' => 'Attachment Title',
                'attachment_caption' => 'Attachment Caption',
                'attachment_alt' => 'Attachment Alt Text',
                'fallback' => 'Fallback Message',
            ),
            'condition' => array( 'show_caption' => '1' ),
        ) );
        $this->add_control( 'limit', array( 'label' => 'Image Limit', 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 24, 'default' => $d['limit'] ?? 6 ) );
        $this->end_controls_section();

        $this->start_controls_section( 'layout', array( 'label' => '3. Layout / Responsive' ) );
        $this->add_control( 'columns_desktop', array( 'label' => 'Columns Desktop', 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 6, 'default' => $d['columns_desktop'] ?? 3 ) );
        $this->add_control( 'columns_tablet', array( 'label' => 'Columns Tablet', 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'default' => $d['columns_tablet'] ?? 2 ) );
        $this->add_control( 'columns_mobile', array( 'label' => 'Columns Mobile', 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 2, 'default' => $d['columns_mobile'] ?? 1 ) );
        $this->add_responsive_control( 'grid_gap_control', array( 'label' => 'Image Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .ampa-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'heading_gap', array( 'label' => 'Heading to Gallery Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .ampa-section-head' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_heading_style', array( 'label' => '4. Section + Heading Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => 'Section Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-gallery-section' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => 'Section Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .ampa-gallery-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'content_width', array( 'label' => 'Content Max Width', 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .ampa-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'heading_align', array( 'label' => 'Heading Alignment', 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .ampa-section-head' => 'text-align: {{VALUE}};' ) ) );
        $this->add_control( 'label_color', array( 'label' => 'Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-kicker' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'selector' => '{{WRAPPER}} .ampa-kicker' ) );
        $this->add_control( 'heading_color', array( 'label' => 'Heading Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-section-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .ampa-section-title' ) );
        $this->add_control( 'desc_color', array( 'label' => 'Description Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-section-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'desc_typography', 'selector' => '{{WRAPPER}} .ampa-section-desc' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'gallery_card_style', array( 'label' => '5. Image Card Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'image_height', array( 'label' => 'Image Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 96, 'max' => 420 ) ), 'default' => array( 'size' => 168, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 160, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 150, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'image_fit', array( 'label' => 'Image Fit', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card img' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_control( 'image_position', array( 'label' => 'Image Position', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => array( 'center center' => 'Center Center', 'center top' => 'Center Top', 'center bottom' => 'Center Bottom', 'left center' => 'Left Center', 'right center' => 'Right Center' ), 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card img' => 'object-position: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => 'Card Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'card_border_color', array( 'label' => 'Card Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'gallery_card_shadow', 'selector' => '{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card' ) );
        $this->add_control( 'fallback_bg', array( 'label' => 'Fallback Card Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-gallery-empty-card' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'overlay_color', array( 'label' => 'Overlay Bottom Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card::after, {{WRAPPER}} .ampa-gallery-empty-card::after' => 'background: linear-gradient(180deg,rgba(46,18,3,0) 35%, {{VALUE}} 100%);' ) ) );
        $this->add_responsive_control( 'caption_padding', array( 'label' => 'Caption Position / Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card figcaption' => 'left: {{LEFT}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};' ) ) );
        $this->add_control( 'caption_label_color', array( 'label' => 'Caption Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'caption_label_typography', 'selector' => '{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span' ) );
        $this->add_control( 'caption_title_color', array( 'label' => 'Caption Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'caption_title_typography', 'selector' => '{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong' ) );
        $this->end_controls_section();
    }

    protected function render() {
        echo $this->renderer()->render_manual_gallery( $this->get_settings_for_display() );
    }
}
