<?php
/**
 * Amaley Process Journey widget.
 * Future-safe: presentation only, no data mutation.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) {
    return;
}

final class ACWSC109_Process_Journey_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'acwsc109_process_journey';
    }

    public function get_title() {
        return esc_html__( 'Amaley Process Journey', 'amaley-compact-widgets' );
    }

    public function get_icon() {
        return 'eicon-flow';
    }

    public function get_categories() {
        return array( 'amaley-compact' );
    }

    public function get_style_depends() {
        return array( 'acwsc-process-journey' );
    }

    public function get_keywords() {
        return array( 'amaley', 'process', 'journey', 'handpicked', 'handcrafted', 'delivery', 'traceable' );
    }

    protected function register_controls() {
        $this->content_controls();
        $this->steps_controls();
        $this->trust_controls();
        $this->layout_controls();
        $this->header_style_controls();
        $this->image_style_controls();
        $this->number_connector_style_controls();
        $this->step_text_style_controls();
        $this->trust_style_controls();
    }

    private function default_steps() {
        return array(
            array( 'number' => '1', 'title' => 'Handpicked', 'description' => 'Carefully selected from the best orchards and fields across the Himalayas.', 'icon' => array( 'value' => 'fas fa-seedling', 'library' => 'fa-solid' ) ),
            array( 'number' => '2', 'title' => 'Handcrafted', 'description' => 'Prepared in small batches by skilled hands using time-honoured methods and traditions.', 'icon' => array( 'value' => 'fas fa-hands', 'library' => 'fa-solid' ) ),
            array( 'number' => '3', 'title' => 'Naturally Processed', 'description' => 'Slowly processed with natural ingredients to retain nutrition, flavour and aroma.', 'icon' => array( 'value' => 'fas fa-leaf', 'library' => 'fa-solid' ) ),
            array( 'number' => '4', 'title' => 'Packed with Care', 'description' => 'Thoughtfully packed using eco-friendly materials to protect freshness and quality.', 'icon' => array( 'value' => 'fas fa-box-open', 'library' => 'fa-solid' ) ),
            array( 'number' => '5', 'title' => 'Delivered to You', 'description' => 'From our hands to your home — delivered with care, so you experience the true taste of the Himalayas.', 'icon' => array( 'value' => 'fas fa-truck', 'library' => 'fa-solid' ) ),
        );
    }

    private function default_trust_items() {
        return array(
            array( 'title' => 'Rooted in Nature', 'text' => 'Pure ingredients from the Himalayas', 'icon' => array( 'value' => 'fas fa-seedling', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Empowering Communities', 'text' => 'Supporting local farmers and artisans', 'icon' => array( 'value' => 'fas fa-users', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Clean & Honest', 'text' => 'No artificial additives, no compromises', 'icon' => array( 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Made with Purpose', 'text' => 'For mindful living and a better tomorrow', 'icon' => array( 'value' => 'far fa-heart', 'library' => 'fa-regular' ) ),
        );
    }

    private function content_controls() {
        $this->start_controls_section( 'process_header_content', array( 'label' => esc_html__( 'Header Content', 'amaley-compact-widgets' ) ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Section', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );
        $this->add_control( 'show_kicker', array(
            'label'        => esc_html__( 'Show Kicker', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );
        $this->add_control( 'kicker', array(
            'label'     => esc_html__( 'Kicker', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'THOUGHTFUL. TRANSPARENT. TRACEABLE.',
            'condition' => array( 'show_kicker' => 'yes' ),
        ) );
        $this->add_control( 'show_heading', array(
            'label'        => esc_html__( 'Show Heading', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );
        $this->add_control( 'heading', array(
            'label'     => esc_html__( 'Heading', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 2,
            'default'   => 'From Mountain Hands to Your Home',
            'condition' => array( 'show_heading' => 'yes' ),
        ) );
        $this->add_control( 'show_description', array(
            'label'        => esc_html__( 'Show Description', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );
        $this->add_control( 'description', array(
            'label'     => esc_html__( 'Description', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 3,
            'default'   => 'Every product follows a careful journey — rooted in nature, guided by people, and delivered with a promise of purity and fairness.',
            'condition' => array( 'show_description' => 'yes' ),
        ) );

        $this->end_controls_section();
    }

    private function steps_controls() {
        $this->start_controls_section( 'process_steps_content', array( 'label' => esc_html__( 'Process Steps', 'amaley-compact-widgets' ) ) );

        $this->add_control( 'show_steps', array(
            'label'        => esc_html__( 'Show Process Steps', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );
        $this->add_control( 'show_step_images', array(
            'label'        => esc_html__( 'Show Step Images', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_steps' => 'yes' ),
        ) );
        $this->add_control( 'show_connector', array(
            'label'        => esc_html__( 'Show Dotted Connector', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_steps' => 'yes' ),
        ) );
        $this->add_control( 'show_step_numbers', array(
            'label'        => esc_html__( 'Show Step Numbers', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_steps' => 'yes' ),
        ) );
        $this->add_control( 'show_step_icons', array(
            'label'        => esc_html__( 'Show Step Icons', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_steps' => 'yes' ),
        ) );
        $this->add_control( 'show_step_descriptions', array(
            'label'        => esc_html__( 'Show Step Descriptions', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_steps' => 'yes' ),
        ) );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'image', array( 'label' => esc_html__( 'Step Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => array( 'url' => '' ) ) );
        $rep->add_control( 'number', array( 'label' => esc_html__( 'Step Number', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '1' ) );
        $rep->add_control( 'icon', array( 'label' => esc_html__( 'Step Icon', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::ICONS, 'default' => array( 'value' => 'fas fa-leaf', 'library' => 'fa-solid' ) ) );
        $rep->add_control( 'title', array( 'label' => esc_html__( 'Step Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Step Title' ) );
        $rep->add_control( 'description', array( 'label' => esc_html__( 'Step Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Add step description here.' ) );
        $rep->add_control( 'show_this_description', array( 'label' => esc_html__( 'Show This Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );

        $this->add_control( 'steps', array(
            'label'       => esc_html__( 'Steps', 'amaley-compact-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'title_field' => '{{{ number }}} - {{{ title }}}',
            'default'     => $this->default_steps(),
            'condition'   => array( 'show_steps' => 'yes' ),
        ) );

        $this->end_controls_section();
    }

    private function trust_controls() {
        $this->start_controls_section( 'process_trust_content', array( 'label' => esc_html__( 'Bottom Trust Strip', 'amaley-compact-widgets' ) ) );

        $this->add_control( 'show_trust_strip', array(
            'label'        => esc_html__( 'Show Bottom Trust Strip', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );
        $this->add_control( 'show_trust_icons', array(
            'label'        => esc_html__( 'Show Trust Icons', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_trust_strip' => 'yes' ),
        ) );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::ICONS, 'default' => array( 'value' => 'fas fa-seedling', 'library' => 'fa-solid' ) ) );
        $rep->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rooted in Nature' ) );
        $rep->add_control( 'text', array( 'label' => esc_html__( 'Text', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Pure ingredients from the Himalayas' ) );

        $this->add_control( 'trust_items', array(
            'label'       => esc_html__( 'Trust Items', 'amaley-compact-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'     => $this->default_trust_items(),
            'condition'   => array( 'show_trust_strip' => 'yes' ),
        ) );

        $this->end_controls_section();
    }

    private function layout_controls() {
        $this->start_controls_section( 'process_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array( '{{WRAPPER}} .acwsc-pj' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'inner_max_width', array(
            'label'      => esc_html__( 'Inner Max Width', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 760, 'max' => 1680 ) ),
            'selectors'  => array( '{{WRAPPER}} .acwsc-pj__inner' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'header_max_width', array(
            'label'      => esc_html__( 'Header Max Width', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 420, 'max' => 980 ) ),
            'selectors'  => array( '{{WRAPPER}} .acwsc-pj__head' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'step_columns', array(
            'label'       => esc_html__( 'Process Columns', 'amaley-compact-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '5',
            'tablet_default' => '3',
            'mobile_default' => '1',
            'options'     => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5' ),
            'selectors'   => array( '{{WRAPPER}} .acwsc-pj__steps' => '--acwsc-pj-cols: {{VALUE}};' ),
        ) );
        $this->add_responsive_control( 'step_gap', array(
            'label'      => esc_html__( 'Step Gap', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array( '{{WRAPPER}} .acwsc-pj__steps' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'trust_columns', array(
            'label'       => esc_html__( 'Bottom Strip Columns', 'amaley-compact-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '4',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options'     => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
            'selectors'   => array( '{{WRAPPER}} .acwsc-pj__trust-grid' => '--acwsc-pj-trust-cols: {{VALUE}};' ),
        ) );
        $this->add_responsive_control( 'trust_margin_top', array(
            'label'      => esc_html__( 'Bottom Strip Top Gap', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
            'selectors'  => array( '{{WRAPPER}} .acwsc-pj__trust' => 'margin-top: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    private function header_style_controls() {
        $this->start_controls_section( 'process_header_style', array( 'label' => esc_html__( 'Header Style', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_background', array( 'label' => esc_html__( 'Section Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__kicker' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__kicker' ) );
        $this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__title' ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__desc' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__desc' ) );
        $this->add_responsive_control( 'kicker_bottom_gap', array( 'label' => esc_html__( 'Kicker Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'heading_bottom_gap', array( 'label' => esc_html__( 'Heading Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'header_to_steps_gap', array( 'label' => esc_html__( 'Header to Steps Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__steps-wrap' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function image_style_controls() {
        $this->start_controls_section( 'process_image_style', array( 'label' => esc_html__( 'Step Images', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 360 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__image' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__image img' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__image' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'image_shadow_color', array( 'label' => esc_html__( 'Image Soft Shadow Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__image' => 'box-shadow: 0 16px 42px {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    private function number_connector_style_controls() {
        $this->start_controls_section( 'process_number_connector_style', array( 'label' => esc_html__( 'Numbers / Connector', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'number_size', array( 'label' => esc_html__( 'Number Circle Size', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 28, 'max' => 86 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__number' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'number_bg', array( 'label' => esc_html__( 'Number Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__number' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'number_color', array( 'label' => esc_html__( 'Number Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__number' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'number_border', array( 'label' => esc_html__( 'Number Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__number' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'number_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__number' ) );
        $this->add_control( 'connector_color', array( 'label' => esc_html__( 'Connector Line / Arrow Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__number-row:after' => 'border-color: {{VALUE}};', '{{WRAPPER}} .acwsc-pj__number-row:before' => 'border-left-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'connector_thickness', array( 'label' => esc_html__( 'Connector Thickness', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 1, 'max' => 6 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__number-row:after' => 'border-top-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'icon_size', array( 'label' => esc_html__( 'Step Icon Size', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 18, 'max' => 72 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} * .45);' ) ) );
        $this->add_control( 'icon_color', array( 'label' => esc_html__( 'Step Icon Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__icon, {{WRAPPER}} .acwsc-pj__icon i, {{WRAPPER}} .acwsc-pj__icon svg, {{WRAPPER}} .acwsc-pj__icon svg *' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important; stroke: {{VALUE}} !important;' ) ) );
        $this->add_control( 'icon_bg', array( 'label' => esc_html__( 'Step Icon Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__icon' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    private function step_text_style_controls() {
        $this->start_controls_section( 'process_step_text_style', array( 'label' => esc_html__( 'Step Text', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'step_title_color', array( 'label' => esc_html__( 'Step Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__step-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'step_title_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__step-title' ) );
        $this->add_control( 'step_text_color', array( 'label' => esc_html__( 'Step Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__step-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'step_text_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__step-desc' ) );
        $this->add_responsive_control( 'icon_to_title_gap', array( 'label' => esc_html__( 'Icon to Title Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__step-title' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'title_description_gap', array( 'label' => esc_html__( 'Title / Description Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__step-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function trust_style_controls() {
        $this->start_controls_section( 'process_trust_style', array( 'label' => esc_html__( 'Bottom Trust Strip Style', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'trust_bg', array( 'label' => esc_html__( 'Strip Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__trust' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'trust_padding', array( 'label' => esc_html__( 'Strip Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__trust' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'trust_radius', array( 'label' => esc_html__( 'Strip Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-pj__trust' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'trust_divider_color', array( 'label' => esc_html__( 'Divider Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__trust-item' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'trust_icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__trust-icon, {{WRAPPER}} .acwsc-pj__trust-icon i, {{WRAPPER}} .acwsc-pj__trust-icon svg, {{WRAPPER}} .acwsc-pj__trust-icon svg *' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important; stroke: {{VALUE}} !important;' ) ) );
        $this->add_control( 'trust_title_color', array( 'label' => esc_html__( 'Trust Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__trust-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'trust_title_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__trust-title' ) );
        $this->add_control( 'trust_text_color', array( 'label' => esc_html__( 'Trust Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-pj__trust-text' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'trust_text_typography', 'selector' => '{{WRAPPER}} .acwsc-pj__trust-text' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        if ( empty( $s['show_section'] ) || 'yes' !== $s['show_section'] ) {
            return;
        }
        $steps = ! empty( $s['steps'] ) && is_array( $s['steps'] ) ? $s['steps'] : $this->default_steps();
        $trust = ! empty( $s['trust_items'] ) && is_array( $s['trust_items'] ) ? $s['trust_items'] : $this->default_trust_items();
        ?>
        <section class="acwsc-pj" data-acwsc="process-journey">
            <div class="acwsc-pj__inner">
                <header class="acwsc-pj__head">
                    <?php if ( $this->yes( $s, 'show_kicker' ) && ! empty( $s['kicker'] ) ) : ?>
                        <p class="acwsc-pj__kicker"><?php echo esc_html( $s['kicker'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( $this->yes( $s, 'show_heading' ) && ! empty( $s['heading'] ) ) : ?>
                        <h2 class="acwsc-pj__title"><?php echo esc_html( $s['heading'] ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $this->yes( $s, 'show_description' ) && ! empty( $s['description'] ) ) : ?>
                        <p class="acwsc-pj__desc"><?php echo esc_html( $s['description'] ); ?></p>
                    <?php endif; ?>
                </header>

                <?php if ( $this->yes( $s, 'show_steps' ) ) : ?>
                    <div class="acwsc-pj__steps-wrap <?php echo $this->yes( $s, 'show_connector' ) ? 'has-connector' : 'no-connector'; ?>">
                        <div class="acwsc-pj__steps">
                            <?php foreach ( $steps as $index => $step ) : ?>
                                <article class="acwsc-pj__step">
                                    <?php if ( $this->yes( $s, 'show_step_images' ) ) : ?>
                                        <figure class="acwsc-pj__image">
                                            <?php $this->render_step_image( $step, $index ); ?>
                                        </figure>
                                    <?php endif; ?>

                                    <div class="acwsc-pj__number-row <?php echo ( $index === count( $steps ) - 1 ) ? 'is-last' : ''; ?>">
                                        <?php if ( $this->yes( $s, 'show_step_numbers' ) ) : ?>
                                            <span class="acwsc-pj__number"><?php echo esc_html( ! empty( $step['number'] ) ? $step['number'] : (string) ( $index + 1 ) ); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ( $this->yes( $s, 'show_step_icons' ) ) : ?>
                                        <div class="acwsc-pj__icon"><?php $this->render_icon( isset( $step['icon'] ) ? $step['icon'] : array() ); ?></div>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $step['title'] ) ) : ?>
                                        <h3 class="acwsc-pj__step-title"><?php echo esc_html( $step['title'] ); ?></h3>
                                    <?php endif; ?>

                                    <?php if ( $this->yes( $s, 'show_step_descriptions' ) && ( ! isset( $step['show_this_description'] ) || 'yes' === $step['show_this_description'] ) && ! empty( $step['description'] ) ) : ?>
                                        <p class="acwsc-pj__step-desc"><?php echo esc_html( $step['description'] ); ?></p>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $this->yes( $s, 'show_trust_strip' ) ) : ?>
                    <aside class="acwsc-pj__trust">
                        <div class="acwsc-pj__trust-grid">
                            <?php foreach ( $trust as $item ) : ?>
                                <div class="acwsc-pj__trust-item">
                                    <?php if ( $this->yes( $s, 'show_trust_icons' ) ) : ?>
                                        <span class="acwsc-pj__trust-icon"><?php $this->render_icon( isset( $item['icon'] ) ? $item['icon'] : array() ); ?></span>
                                    <?php endif; ?>
                                    <div class="acwsc-pj__trust-copy">
                                        <?php if ( ! empty( $item['title'] ) ) : ?><strong class="acwsc-pj__trust-title"><?php echo esc_html( $item['title'] ); ?></strong><?php endif; ?>
                                        <?php if ( ! empty( $item['text'] ) ) : ?><span class="acwsc-pj__trust-text"><?php echo esc_html( $item['text'] ); ?></span><?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }

    private function yes( $settings, $key ) {
        return isset( $settings[ $key ] ) && 'yes' === $settings[ $key ];
    }

    private function render_step_image( $step, $index ) {
        $url = '';
        if ( isset( $step['image']['url'] ) ) {
            $url = (string) $step['image']['url'];
        }
        if ( $url ) {
            echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( isset( $step['title'] ) ? $step['title'] : 'Amaley process step' ) . '" loading="lazy">';
            return;
        }
        echo '<span class="acwsc-pj__image-placeholder acwsc-pj__image-placeholder--' . esc_attr( ( $index % 5 ) + 1 ) . '"></span>';
    }

    private function render_icon( $icon ) {
        if ( class_exists( '\\Elementor\\Icons_Manager' ) && is_array( $icon ) && ! empty( $icon['value'] ) ) {
            \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
            return;
        }
        echo '<span aria-hidden="true">✦</span>';
    }
}
