<?php
/** Amaley SHG Single Gallery Elementor widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Single_Gallery_Widget extends \Elementor\Widget_Base {
    use Amaley_Core_SHG_Single_Widget_Controls;

    public function get_name() { return 'amaley_core_shg_single_gallery'; }
    public function get_title() { return esc_html__( 'Amaley SHG Single Gallery', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-single-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'single', 'gallery' ); }

    protected function register_controls() {
        $renderer = isset( $GLOBALS['amaley_core_shg_single_sections'] ) ? $GLOBALS['amaley_core_shg_single_sections'] : new Amaley_Core_SHG_Single_Sections();

        $this->add_shg_source_controls();
        $this->add_text_controls_from_defaults( 'content', 'Content / Display', $renderer->gallery_defaults(), array( 'shg_id', 'shg_slug', 'preview_shg_id', 'auto_detect', 'empty_message' ) );

        /*
         * v1.0.112-live-safe-gallery-controls
         * Gallery has its own visible elements. Do not force the user to manage
         * image captions through generic card controls. These controls only
         * affect the SHG Single Gallery widget wrapper.
         */
        $this->add_gallery_item_display_controls();
        $this->add_shg_full_style_controls( 'gallery' );
        $this->add_gallery_caption_style_controls();
    }

    /**
     * Gallery-specific content controls.
     * These are CSS-only visibility controls, so no SHG data, gallery URLs,
     * mapping, products, members or page content is changed.
     */
    protected function add_gallery_item_display_controls() {
        $this->start_controls_section( 'gallery_item_display_controls', array(
            'label' => esc_html__( 'Gallery Item Display', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ) );

        $this->add_control( 'gallery_caption_display', array(
            'label'   => esc_html__( 'Image Caption Box', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''     => esc_html__( 'Show', 'amaley-core' ),
                'none' => esc_html__( 'Hide', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption' => 'display: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'gallery_caption_label_display', array(
            'label'   => esc_html__( 'Caption Small Label', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''     => esc_html__( 'Show', 'amaley-core' ),
                'none' => esc_html__( 'Hide', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption span' => 'display: {{VALUE}};',
            ),
            'condition' => array(
                'gallery_caption_display!' => 'none',
            ),
        ) );

        $this->add_control( 'gallery_caption_title_display', array(
            'label'   => esc_html__( 'Image Title', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array(
                ''     => esc_html__( 'Show', 'amaley-core' ),
                'none' => esc_html__( 'Hide', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption strong' => 'display: {{VALUE}};',
            ),
            'condition' => array(
                'gallery_caption_display!' => 'none',
            ),
        ) );

        $this->add_responsive_control( 'gallery_caption_alignment', array(
            'label' => esc_html__( 'Caption Alignment', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'default' => 'left',
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption' => 'text-align: {{VALUE}};',
            ),
            'condition' => array(
                'gallery_caption_display!' => 'none',
            ),
        ) );

        $this->end_controls_section();
    }

    /**
     * Gallery caption style controls.
     * Scoped only to .amss-gallery-item figcaption so section text/card text
     * controls do not bleed into the gallery captions.
     */
    protected function add_gallery_caption_style_controls() {
        $this->start_controls_section( 'gallery_caption_style_controls', array(
            'label' => esc_html__( 'Gallery Caption / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'gallery_caption_background', array(
            'label' => esc_html__( 'Caption Background', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'gallery_caption_padding', array(
            'label' => esc_html__( 'Caption Padding', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'gallery_caption_radius', array(
            'label' => esc_html__( 'Caption Radius', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'gallery_caption_label_heading', array(
            'label' => esc_html__( 'Caption Small Label', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'gallery_caption_label_color', array(
            'label' => esc_html__( 'Label Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption span' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'gallery_caption_label_typography',
            'label'    => esc_html__( 'Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-gallery-item figcaption span',
        ) );

        $this->add_responsive_control( 'gallery_caption_label_margin', array(
            'label' => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'gallery_caption_title_heading', array(
            'label' => esc_html__( 'Image Title', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_control( 'gallery_caption_title_color', array(
            'label' => esc_html__( 'Title Color', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption strong' => 'color: {{VALUE}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'gallery_caption_title_typography',
            'label'    => esc_html__( 'Title Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .amss-gallery-item figcaption strong',
        ) );

        $this->add_responsive_control( 'gallery_caption_title_margin', array(
            'label' => esc_html__( 'Title Margin', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors' => array(
                '{{WRAPPER}} .amss-gallery-item figcaption strong' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_single_sections'] ) ? $GLOBALS['amaley_core_shg_single_sections'] : new Amaley_Core_SHG_Single_Sections();
        echo $renderer->render_gallery( $this->get_settings_for_display() );
    }
}
