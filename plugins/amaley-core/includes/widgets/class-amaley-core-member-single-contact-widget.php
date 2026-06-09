<?php
/**
 * Amaley Core - Member Single Contact CTA Elementor Widget
 *
 * v1.0.143: Clean, section-specific controls only.
 * - Keeps existing frontend CTA design and renderer output.
 * - Removes generic/irrelevant controls.
 * - Adds scoped working controls for section, card, text, phone and buttons.
 * - No data/query/member rendering changes.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Amaley_Core_Member_Single_Contact_Widget' ) ) :

class Amaley_Core_Member_Single_Contact_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_core_member_single_contact';
    }

    public function get_title() {
        return esc_html__( 'Amaley Member Single Contact CTA', 'amaley-core' );
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return array( 'amaley-core' );
    }

    public function get_style_depends() {
        return array( 'amaley-core-member-single-sections' );
    }

    public function get_keywords() {
        return array( 'amaley', 'member', 'producer', 'single', 'contact', 'cta' );
    }

    protected function register_controls() {
        $defaults = $this->defaults_for( 'contact_defaults' );

        $this->register_source_controls( $defaults );
        $this->register_content_controls( $defaults );

        $this->register_section_style_controls();
        $this->register_heading_style_controls();
        $this->register_card_style_controls();
        $this->register_phone_style_controls();
        $this->register_button_style_controls();
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
        return isset( $defaults[ $key ] ) ? $defaults[ $key ] : $fallback;
    }

    private function register_source_controls( $defaults ) {
        $this->start_controls_section( 'source_section', array(
            'label' => esc_html__( 'Contact CTA Data / Preview Source', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ) );

        $this->add_control( 'auto_detect', array(
            'label'        => esc_html__( 'Auto Detect from URL', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'amaley-core' ),
            'label_off'    => esc_html__( 'No', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->default_value( $defaults, 'auto_detect', '1' ),
            'description'  => esc_html__( 'Use current producer/member page automatically. In Elementor preview, use Preview Member ID if needed.', 'amaley-core' ),
        ) );

        $this->add_control( 'preview_member_id', array(
            'label'       => esc_html__( 'Preview Member ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Only for Elementor editor preview when URL auto-detect is empty.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_id', array(
            'label'       => esc_html__( 'Fixed Member ID', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => esc_html__( 'Optional. Leave blank for template use.', 'amaley-core' ),
        ) );

        $this->add_control( 'member_slug', array(
            'label'       => esc_html__( 'Fixed Member Slug', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => '',
            'description' => esc_html__( 'Optional. Leave blank for template use.', 'amaley-core' ),
        ) );

        $this->end_controls_section();
    }

    private function register_content_controls( $defaults ) {
        $this->start_controls_section( 'content_section', array(
            'label' => esc_html__( 'Contact CTA Content / Show-Hide', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Contact CTA Section', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->default_value( $defaults, 'show_section', '1' ),
        ) );

        $this->add_control( 'show_label', array(
            'label'        => esc_html__( 'Show Label / Eyebrow', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->default_value( $defaults, 'show_label', '1' ),
        ) );

        $this->add_control( 'label', array(
            'label'     => esc_html__( 'Label / Eyebrow Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $this->default_value( $defaults, 'label', 'Work with Amaley' ),
            'condition' => array( 'show_label' => '1' ),
        ) );

        $this->add_control( 'show_title', array(
            'label'        => esc_html__( 'Show Heading', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->default_value( $defaults, 'show_title', '1' ),
        ) );

        $this->add_control( 'title', array(
            'label'     => esc_html__( 'Heading Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 3,
            'default'   => $this->default_value( $defaults, 'title', 'Build origin-led product stories with verified producers.' ),
            'condition' => array( 'show_title' => '1' ),
        ) );

        $this->add_control( 'show_description', array(
            'label'        => esc_html__( 'Show Description', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->default_value( $defaults, 'show_description', '1' ),
        ) );

        $this->add_control( 'description', array(
            'label'     => esc_html__( 'Description Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 4,
            'default'   => $this->default_value( $defaults, 'description', '' ),
            'condition' => array( 'show_description' => '1' ),
        ) );

        $this->add_control( 'show_phone', array(
            'label'        => esc_html__( 'Show Phone / WhatsApp Line', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->default_value( $defaults, 'show_phone', '1' ),
        ) );

        $this->add_control( 'show_buttons', array(
            'label'        => esc_html__( 'Show CTA Buttons', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Show', 'amaley-core' ),
            'label_off'    => esc_html__( 'Hide', 'amaley-core' ),
            'return_value' => '1',
            'default'      => $this->default_value( $defaults, 'show_buttons', '1' ),
        ) );

        $this->add_control( 'primary_button_heading', array(
            'label'     => esc_html__( 'Primary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array( 'show_buttons' => '1' ),
        ) );

        $this->add_control( 'primary_text', array(
            'label'     => esc_html__( 'Primary Button Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $this->default_value( $defaults, 'primary_text', 'Explore Products' ),
            'condition' => array( 'show_buttons' => '1' ),
        ) );

        $this->add_control( 'primary_url', array(
            'label'       => esc_html__( 'Primary Button URL', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $this->default_value( $defaults, 'primary_url', '/shop/' ),
            'placeholder' => '/shop/',
            'condition'   => array( 'show_buttons' => '1' ),
        ) );

        $this->add_control( 'secondary_button_heading', array(
            'label'     => esc_html__( 'Secondary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array( 'show_buttons' => '1' ),
        ) );

        $this->add_control( 'secondary_text', array(
            'label'     => esc_html__( 'Secondary Button Text', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $this->default_value( $defaults, 'secondary_text', 'Contact Amaley' ),
            'condition' => array( 'show_buttons' => '1' ),
        ) );

        $this->add_control( 'secondary_url', array(
            'label'       => esc_html__( 'Secondary Button URL', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $this->default_value( $defaults, 'secondary_url', '/contact/' ),
            'placeholder' => '/contact/',
            'condition'   => array( 'show_buttons' => '1' ),
        ) );

        $this->add_control( 'empty_message', array(
            'label'     => esc_html__( 'Fallback / Empty Message', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 3,
            'separator' => 'before',
            'default'   => $this->default_value( $defaults, 'empty_message', '' ),
        ) );

        $this->end_controls_section();
    }

    private function register_section_style_controls() {
        $s = '{{WRAPPER}} .amms-contact';

        $this->start_controls_section( 'style_section', array(
            'label' => esc_html__( 'Section / Background / Layout', 'amaley-core' ),
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

        $this->add_responsive_control( 'content_width', array(
            'label'      => esc_html__( 'CTA Area Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 320, 'max' => 1400 ),
                '%'  => array( 'min' => 40, 'max' => 100 ),
            ),
            'selectors'  => array( '{{WRAPPER}} .amms-contact .amms-wrap' => 'width: min({{SIZE}}{{UNIT}}, 100%);' ),
        ) );

        $this->add_responsive_control( 'section_align', array(
            'label'   => esc_html__( 'Text Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( '{{WRAPPER}} .amms-contact, {{WRAPPER}} .amms-contact-card' => 'text-align: {{VALUE}};' ),
        ) );

        $this->end_controls_section();
    }

    private function register_heading_style_controls() {
        $s = '{{WRAPPER}} .amms-contact';

        $this->start_controls_section( 'style_heading', array(
            'label' => esc_html__( 'Text / Label / Heading / Description', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'label_heading', array(
            'label' => esc_html__( 'Label / Eyebrow', 'amaley-core' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
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

        $this->add_responsive_control( 'label_margin', array(
            'label'      => esc_html__( 'Label Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-kicker' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
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

        $this->add_responsive_control( 'title_margin', array(
            'label'      => esc_html__( 'Heading Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s . ' .amms-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_control( 'desc_heading', array(
            'label'     => esc_html__( 'Description', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'desc_typography',
            'selector' => $s . ' .amms-section-desc',
        ) );

        $this->add_control( 'desc_color', array(
            'label'     => esc_html__( 'Description Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s . ' .amms-section-desc' => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'desc_width', array(
            'label'      => esc_html__( 'Description Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
                'px' => array( 'min' => 200, 'max' => 1000 ),
                '%'  => array( 'min' => 30, 'max' => 100 ),
            ),
            'selectors'  => array( $s . ' .amms-section-desc' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    private function register_card_style_controls() {
        $s = '{{WRAPPER}} .amms-contact .amms-contact-card';

        $this->start_controls_section( 'style_card', array(
            'label' => esc_html__( 'CTA Card / Box', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'card_background',
            'selector' => $s,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
            'name'     => 'card_border',
            'selector' => $s,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'card_shadow',
            'selector' => $s,
        ) );

        $this->add_responsive_control( 'card_padding', array(
            'label'      => esc_html__( 'Card Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'card_margin', array(
            'label'      => esc_html__( 'Card Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'card_radius', array(
            'label'      => esc_html__( 'Card Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $s => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    private function register_phone_style_controls() {
        $s = '{{WRAPPER}} .amms-contact .amms-phone';

        $this->start_controls_section( 'style_phone', array(
            'label' => esc_html__( 'Phone / WhatsApp Line', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'phone_typography',
            'selector' => $s,
        ) );

        $this->add_control( 'phone_color', array(
            'label'     => esc_html__( 'Phone Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s => 'color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'phone_margin', array(
            'label'      => esc_html__( 'Phone Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $s => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->end_controls_section();
    }

    private function register_button_style_controls() {
        $base = '{{WRAPPER}} .amms-contact';

        $this->start_controls_section( 'style_buttons', array(
            'label' => esc_html__( 'CTA Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'button_row_gap', array(
            'label'      => esc_html__( 'Button Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ), 'em' => array( 'min' => 0, 'max' => 6 ) ),
            'selectors'  => array( $base . ' .amms-button-row' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'button_margin', array(
            'label'      => esc_html__( 'Button Row Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $base . ' .amms-button-row' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'button_typography',
            'selector' => $base . ' .amms-btn',
        ) );

        $this->add_responsive_control( 'button_padding', array(
            'label'      => esc_html__( 'Button Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array( $base . ' .amms-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'button_radius', array(
            'label'      => esc_html__( 'Button Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array( $base . ' .amms-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->start_controls_tabs( 'button_tabs' );

        $this->start_controls_tab( 'primary_button_tab', array( 'label' => esc_html__( 'Primary', 'amaley-core' ) ) );
        $this->add_control( 'primary_button_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-primary' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-primary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-primary' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'primary_button_hover_tab', array( 'label' => esc_html__( 'Primary Hover', 'amaley-core' ) ) );
        $this->add_control( 'primary_button_hover_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-primary:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_hover_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-primary:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_button_hover_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-primary:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control( 'secondary_button_heading', array(
            'label'     => esc_html__( 'Secondary Button Colors', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->start_controls_tabs( 'secondary_button_tabs' );

        $this->start_controls_tab( 'secondary_button_tab', array( 'label' => esc_html__( 'Secondary', 'amaley-core' ) ) );
        $this->add_control( 'secondary_button_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-secondary' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_button_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-secondary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_button_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-secondary' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'secondary_button_hover_tab', array( 'label' => esc_html__( 'Secondary Hover', 'amaley-core' ) ) );
        $this->add_control( 'secondary_button_hover_color', array( 'label' => esc_html__( 'Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-secondary:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_button_hover_bg', array( 'label' => esc_html__( 'Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-secondary:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_button_hover_border', array( 'label' => esc_html__( 'Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $base . ' .amms-btn-secondary:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    private function register_empty_style_controls() {
        $s = '{{WRAPPER}} .amms-empty';

        $this->start_controls_section( 'style_empty', array(
            'label' => esc_html__( 'Fallback / Empty Message', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'empty_typography',
            'selector' => $s,
        ) );

        $this->add_control( 'empty_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( $s => 'color: {{VALUE}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array(
            'name'     => 'empty_background',
            'selector' => $s,
        ) );

        $this->end_controls_section();
    }

    protected function render() {
        $renderer = $this->renderer_instance();
        echo $renderer->render_contact( $this->get_settings_for_display() );
    }
}

endif;
