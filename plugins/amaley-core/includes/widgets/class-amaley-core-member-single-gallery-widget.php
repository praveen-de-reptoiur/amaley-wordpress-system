<?php
/**
 * Amaley Member Single Gallery Elementor widget.
 *
 * v1.0.142: Clean gallery-only controls.
 * - Removes unrelated buttons, cards, products, stats and generic controls.
 * - Keeps the existing frontend gallery design/rendering.
 * - Controls target only gallery section, heading, grid, image and caption.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Single_Gallery_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_member_single_gallery'; }
    public function get_title() { return esc_html__( 'Amaley Member Single Gallery', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-member-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'member', 'producer', 'single', 'gallery' ); }

    protected function register_controls() {
        $defaults = $this->defaults_for( 'gallery_defaults' );

        $this->register_source_controls( $defaults );
        $this->register_gallery_content_controls( $defaults );
        $this->register_section_head_controls( $defaults );
        $this->register_section_style_controls();
        $this->register_heading_style_controls();
        $this->register_gallery_style_controls( $defaults );
        $this->register_caption_style_controls( $defaults );
        $this->register_empty_style_controls();
    }

    private function renderer_instance() {
        return isset( $GLOBALS['amaley_core_member_single_sections'] ) && $GLOBALS['amaley_core_member_single_sections'] instanceof Amaley_Core_Member_Single_Sections
            ? $GLOBALS['amaley_core_member_single_sections']
            : new Amaley_Core_Member_Single_Sections();
    }

    private function defaults_for( $method ) {
        $renderer = $this->renderer_instance();
        return method_exists( $renderer, $method ) ? $renderer->$method() : $renderer->base_defaults();
    }

    private function default_value( $defaults, $key, $fallback = '' ) {
        return array_key_exists( $key, $defaults ) ? $defaults[ $key ] : $fallback;
    }

    private function add_clean_switch( $key, $label, $default = '1', $condition = array() ) {
        $args = array(
            'label'        => esc_html__( $label, 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $default,
        );
        if ( ! empty( $condition ) ) { $args['condition'] = $condition; }
        $this->add_control( $key, $args );
    }

    private function register_source_controls( $defaults ) {
        $this->start_controls_section( 'source_section', array(
            'label' => esc_html__( 'Gallery Data / Preview Source', 'amaley-core' ),
        ) );

        $this->add_control( 'source_note', array(
            'type'            => \Elementor\Controls_Manager::RAW_HTML,
            'raw'             => esc_html__( 'Use auto-detect on real single producer pages. Use Preview Member ID only inside Elementor editor.', 'amaley-core' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ) );

        $this->add_clean_switch( 'auto_detect', 'Auto Detect from URL', $this->default_value( $defaults, 'auto_detect', '1' ) );

        $this->add_control( 'preview_member_id', array(
            'label'       => esc_html__( 'Preview Member ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => $this->default_value( $defaults, 'preview_member_id', '' ),
            'description' => esc_html__( 'Use this only when Elementor preview cannot detect the current producer.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_id', array(
            'label'       => esc_html__( 'Fixed Member ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => $this->default_value( $defaults, 'member_id', '' ),
            'description' => esc_html__( 'Optional. Leave empty for dynamic producer pages.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_slug', array(
            'label'       => esc_html__( 'Fixed Member Slug', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $this->default_value( $defaults, 'member_slug', '' ),
            'description' => esc_html__( 'Optional. Leave empty for dynamic producer pages.', 'amaley-core' ),
        ) );

        $this->add_control( 'empty_message', array(
            'label'   => esc_html__( 'Empty / Preview Message', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => $this->default_value( $defaults, 'empty_message', '' ),
        ) );

        $this->end_controls_section();
    }

    private function register_gallery_content_controls( $defaults ) {
        $this->start_controls_section( 'gallery_content_section', array(
            'label' => esc_html__( 'Gallery Content / Display', 'amaley-core' ),
        ) );

        $this->add_clean_switch( 'show_section', 'Show Gallery Section', $this->default_value( $defaults, 'show_section', '1' ) );

        $this->add_control( 'max_images', array(
            'label'   => esc_html__( 'Maximum Images', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 30,
            'step'    => 1,
            'default' => $this->default_value( $defaults, 'max_images', 6 ),
        ) );

        $this->add_clean_switch( 'show_caption', 'Show Caption Overlay', $this->default_value( $defaults, 'show_caption', '1' ) );

        $this->end_controls_section();
    }

    private function register_section_head_controls( $defaults ) {
        $this->start_controls_section( 'section_head_content', array(
            'label' => esc_html__( 'Section Head / Text', 'amaley-core' ),
        ) );

        $this->add_clean_switch( 'show_label', 'Show Label', $this->default_value( $defaults, 'show_label', '1' ) );
        $this->add_control( 'label', array(
            'label'     => esc_html__( 'Label Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $this->default_value( $defaults, 'label', 'Producer Gallery' ),
            'condition' => array( 'show_label' => '1' ),
        ) );

        $this->add_clean_switch( 'show_title', 'Show Heading', $this->default_value( $defaults, 'show_title', '1' ) );
        $this->add_control( 'title', array(
            'label'     => esc_html__( 'Heading Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $this->default_value( $defaults, 'title', 'Visual story from this profile' ),
            'condition' => array( 'show_title' => '1' ),
        ) );

        $this->add_clean_switch( 'show_description', 'Show Description', $this->default_value( $defaults, 'show_description', '1' ) );
        $this->add_control( 'description', array(
            'label'     => esc_html__( 'Description Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 3,
            'default'   => $this->default_value( $defaults, 'description', '' ),
            'condition' => array( 'show_description' => '1' ),
        ) );

        $this->end_controls_section();
    }

    private function register_section_style_controls() {
        $s = '{{WRAPPER}} .amms-gallery';

        $this->start_controls_section( 'style_section_layout', array(
            'label' => esc_html__( 'Section / Background / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'section_background',
            'selector' => $s,
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( $s => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'wrap_width', array(
            'label'      => esc_html__( 'Content Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 320, 'max' => 1600 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-wrap' => 'width: min({{SIZE}}{{UNIT}}, 100%); max-width: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'section_align', array(
            'label'   => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( $s . ' .amms-section-head' => 'text-align: {{VALUE}};' ),
        ) );

        $this->end_controls_section();
    }

    private function register_heading_style_controls() {
        $s = '{{WRAPPER}} .amms-gallery';

        $this->start_controls_section( 'style_heading', array(
            'label' => esc_html__( 'Section Head / Label / Heading', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'head_width', array(
            'label'      => esc_html__( 'Heading Block Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 220, 'max' => 1200 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-section-head' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'head_margin', array(
            'label'      => esc_html__( 'Heading Block Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( $s . ' .amms-section-head' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'label_heading', array(
            'label'     => esc_html__( 'Label', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'label_typography',
            'selector' => $s . ' .amms-kicker',
        ) );
        $this->add_control( 'label_color', array(
            'label'     => esc_html__( 'Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-kicker' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'title_heading', array(
            'label'     => esc_html__( 'Heading', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'title_typography',
            'selector' => $s . ' .amms-section-title',
        ) );
        $this->add_control( 'title_color', array(
            'label'     => esc_html__( 'Heading Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-title' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'description_heading', array(
            'label'     => esc_html__( 'Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'description_typography',
            'selector' => $s . ' .amms-section-desc',
        ) );
        $this->add_control( 'description_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-desc' => 'color: {{VALUE}};' ),
        ) );

        $this->end_controls_section();
    }

    private function register_gallery_style_controls( $defaults ) {
        $s = '{{WRAPPER}} .amms-gallery';

        $this->start_controls_section( 'style_gallery_grid', array(
            'label' => esc_html__( 'Gallery Grid / Image', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'columns_desktop', array(
            'label'     => esc_html__( 'Desktop Columns', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 1,
            'max'       => 6,
            'step'      => 1,
            'default'   => $this->default_value( $defaults, 'columns_desktop', 3 ),
            'selectors' => array( $s . ' .amms-gallery-grid' => '--amms-cols: {{VALUE}};' ),
        ) );

        $this->add_control( 'columns_tablet', array(
            'label'     => esc_html__( 'Tablet Columns', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 1,
            'max'       => 4,
            'step'      => 1,
            'default'   => $this->default_value( $defaults, 'columns_tablet', 2 ),
            'selectors' => array( $s . ' .amms-gallery-grid' => '--amms-cols-tablet: {{VALUE}};' ),
        ) );

        $this->add_control( 'columns_mobile', array(
            'label'     => esc_html__( 'Mobile Columns', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 1,
            'max'       => 2,
            'step'      => 1,
            'default'   => $this->default_value( $defaults, 'columns_mobile', 1 ),
            'selectors' => array( $s . ' .amms-gallery-grid' => '--amms-cols-mobile: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'gallery_gap', array(
            'label'      => esc_html__( 'Gallery Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array( $s . ' .amms-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'gallery_image_height', array(
            'label'      => esc_html__( 'Image Height', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range'      => array(
                'px' => array( 'min' => 120, 'max' => 700 ),
                'vh' => array( 'min' => 10, 'max' => 80 ),
            ),
            'selectors'  => array( $s . ' figure, ' . $s . ' img' => 'min-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'gallery_radius', array(
            'label'      => esc_html__( 'Image Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'gallery_shadow',
            'selector' => $s . ' figure',
        ) );

        $this->end_controls_section();
    }

    private function register_caption_style_controls( $defaults ) {
        $s = '{{WRAPPER}} .amms-gallery';

        $this->start_controls_section( 'style_caption', array(
            'label'     => esc_html__( 'Gallery Caption Overlay', 'amaley-core' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => array( 'show_caption' => '1' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'caption_typography',
            'selector' => $s . ' figcaption',
        ) );

        $this->add_control( 'caption_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' figcaption' => 'color: {{VALUE}};' ),
        ) );

        $this->add_control( 'caption_bg', array(
            'label'     => esc_html__( 'Background Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' figcaption' => 'background: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'caption_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' figcaption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'caption_radius', array(
            'label'      => esc_html__( 'Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s . ' figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'caption_offset', array(
            'label'      => esc_html__( 'Bottom Offset', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array( $s . ' figcaption' => 'bottom: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    private function register_empty_style_controls() {
        $s = '{{WRAPPER}} .amms-gallery';

        $this->start_controls_section( 'style_empty_state', array(
            'label' => esc_html__( 'Fallback / Empty Message', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'empty_typography',
            'selector' => $s . ' .amms-empty',
        ) );

        $this->add_control( 'empty_text_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-empty' => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'empty_background',
            'selector' => $s . ' .amms-empty',
        ) );

        $this->add_responsive_control( 'empty_padding', array(
            'label'      => esc_html__( 'Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-empty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = $this->renderer_instance();
        echo $renderer->render_gallery( $this->get_settings_for_display() );
    }
}
