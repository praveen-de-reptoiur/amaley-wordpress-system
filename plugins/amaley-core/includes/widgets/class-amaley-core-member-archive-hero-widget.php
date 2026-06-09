<?php
/**
 * Amaley Member / Producer Archive Hero Elementor widget.
 *
 * v1.0.113-archive-hero-full-controls
 * Scope: Producer Archive Hero only.
 * Safe for live site: content/data/query/render logic unchanged; only Elementor controls are expanded and strongly scoped.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_core_member_archive_hero'; }
    public function get_title(){ return esc_html__( 'Amaley Member Archive Hero', 'amaley-core' ); }
    public function get_icon(){ return 'eicon-archive-title'; }
    public function get_categories(){ return array( 'amaley-core' ); }
    public function get_style_depends(){ return array( 'amaley-core-member-archive-sections' ); }

    private function defaults(){
        $r = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
        return $r->hero_defaults();
    }

    protected function register_controls(){
        $d = $this->defaults();

        /**
         * CONTENT CONTROLS
         * Only Producer Archive Hero content controls are kept here.
         */
        $this->start_controls_section( 'content_display', array(
            'label' => esc_html__( '1. Hero Content + Show / Hide', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ) );

        foreach ( array(
            'show_section'          => 'Show Hero Section',
            'show_breadcrumb'       => 'Show Breadcrumb',
            'show_label'            => 'Show Small Label',
            'show_title'            => 'Show Main Heading',
            'show_accent'           => 'Show Accent Word',
            'show_description'      => 'Show Description',
            'show_primary_button'   => 'Show Primary Button',
            'show_secondary_button' => 'Show Secondary Button',
            'show_stats'            => 'Show Stats Panel',
            'show_stat_value'       => 'Show Stat Values',
            'show_stat_label'       => 'Show Stat Labels',
        ) as $k => $l ) {
            $this->add_control( $k, array(
                'label'        => esc_html__( $l, 'amaley-core' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default'      => $d[ $k ] ?? '1',
            ) );
        }

        $this->add_control( 'breadcrumb', array(
            'label'       => esc_html__( 'Breadcrumb Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['breadcrumb'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_breadcrumb' => '1' ),
        ) );

        $this->add_control( 'label', array(
            'label'       => esc_html__( 'Small Label', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['label'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_label' => '1' ),
        ) );

        $this->add_control( 'title', array(
            'label'       => esc_html__( 'Main Heading', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['title'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_title' => '1' ),
        ) );

        $this->add_control( 'accent', array(
            'label'       => esc_html__( 'Accent Word', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['accent'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_title' => '1', 'show_accent' => '1' ),
        ) );

        $this->add_control( 'description', array(
            'label'       => esc_html__( 'Description', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => $d['description'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_description' => '1' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'buttons_content', array(
            'label' => esc_html__( '2. Hero Button Content / Links', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ) );

        $this->add_control( 'primary_text', array(
            'label'       => esc_html__( 'Primary Button Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['primary_text'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_primary_button' => '1' ),
        ) );

        $this->add_control( 'primary_url', array(
            'label'       => esc_html__( 'Primary Button URL', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['primary_url'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_primary_button' => '1' ),
        ) );

        $this->add_control( 'secondary_text', array(
            'label'       => esc_html__( 'Secondary Button Text', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['secondary_text'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_secondary_button' => '1' ),
        ) );

        $this->add_control( 'secondary_url', array(
            'label'       => esc_html__( 'Secondary Button URL', 'amaley-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['secondary_url'] ?? '',
            'label_block' => true,
            'condition'   => array( 'show_secondary_button' => '1' ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'stats_content', array(
            'label' => esc_html__( '3. Hero Stats Content / Layout', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ) );

        $this->add_control( 'stats_mode', array(
            'label'   => esc_html__( 'Stats Mode', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => $d['stats_mode'] ?? 'dynamic',
            'options' => array(
                'dynamic' => esc_html__( 'Dynamic', 'amaley-core' ),
                'manual'  => esc_html__( 'Manual', 'amaley-core' ),
            ),
            'condition' => array( 'show_stats' => '1' ),
        ) );

        for ( $i = 1; $i <= 4; $i++ ) {
            $this->add_control( 'stat_' . $i . '_value', array(
                'label'     => sprintf( esc_html__( 'Stat %d Value', 'amaley-core' ), $i ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => $d[ 'stat_' . $i . '_value' ] ?? '',
                'condition' => array( 'show_stats' => '1', 'stats_mode' => 'manual' ),
            ) );
            $this->add_control( 'stat_' . $i . '_label', array(
                'label'     => sprintf( esc_html__( 'Stat %d Label', 'amaley-core' ), $i ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => $d[ 'stat_' . $i . '_label' ] ?? '',
                'condition' => array( 'show_stats' => '1', 'stats_mode' => 'manual' ),
            ) );
        }

        foreach ( array(
            'stats_columns_desktop' => 'Stats Columns Desktop',
            'stats_columns_tablet'  => 'Stats Columns Tablet',
            'stats_columns_mobile'  => 'Stats Columns Mobile',
        ) as $k => $l ) {
            $this->add_control( $k, array(
                'label'     => esc_html__( $l, 'amaley-core' ),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'min'       => 1,
                'max'       => 4,
                'default'   => $d[ $k ] ?? 2,
                'condition' => array( 'show_stats' => '1' ),
            ) );
        }

        $this->end_controls_section();

        /**
         * STYLE CONTROLS
         * Strongly scoped to .ampa-section.ampa-hero so archive grid/cards/CTA are not affected.
         */
        $this->start_controls_section( 'style_hero_section', array(
            'label' => esc_html__( '4. Hero Section / Background', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'section_margin', array(
            'label'      => esc_html__( 'Section Margin', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'hero_bg', array(
            'label'     => esc_html__( 'Hero Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-section.ampa-hero' => 'background: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'hero_border_color', array(
            'label'     => esc_html__( 'Bottom Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .ampa-section.ampa-hero' => 'border-bottom-color: {{VALUE}};',
            ),
        ) );

        $this->add_control( 'shape_opacity', array(
            'label'     => esc_html__( 'Background Texture Opacity', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ) ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-section.ampa-hero::after' => 'opacity: {{SIZE}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_hero_layout', array(
            'label' => esc_html__( '5. Hero Layout / Spacing', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'container_width', array(
            'label'      => esc_html__( 'Container Max Width', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 760, 'max' => 1600 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero > .ampa-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'container_side_padding', array(
            'label'      => esc_html__( 'Container Side Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero > .ampa-wrap' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'grid_gap', array(
            'label'      => esc_html__( 'Copy / Stats Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'copy_align', array(
            'label'   => esc_html__( 'Copy Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-copy' => 'text-align: {{VALUE}};',
            ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_hero_text', array(
            'label' => esc_html__( '6. Hero Breadcrumb / Label / Heading / Text', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $text_controls = array(
            'breadcrumb' => array( 'label' => 'Breadcrumb', 'selector' => '.ampa-breadcrumb' ),
            'label'      => array( 'label' => 'Small Label', 'selector' => '.ampa-kicker' ),
            'title'      => array( 'label' => 'Main Heading', 'selector' => '.ampa-title' ),
            'accent'     => array( 'label' => 'Accent Word', 'selector' => '.ampa-title em' ),
            'description'=> array( 'label' => 'Description', 'selector' => '.ampa-description' ),
        );

        foreach ( $text_controls as $key => $data ) {
            $this->add_control( $key . '_color', array(
                'label'     => esc_html__( $data['label'] . ' Color', 'amaley-core' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .ampa-section.ampa-hero ' . $data['selector'] => 'color: {{VALUE}};',
                ),
            ) );

            $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
                'name'     => $key . '_typography',
                'label'    => esc_html__( $data['label'] . ' Typography', 'amaley-core' ),
                'selector' => '{{WRAPPER}} .ampa-section.ampa-hero ' . $data['selector'],
            ) );

            $this->add_responsive_control( $key . '_margin', array(
                'label'      => esc_html__( $data['label'] . ' Margin', 'amaley-core' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .ampa-section.ampa-hero ' . $data['selector'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ) );
        }

        $this->end_controls_section();

        $this->start_controls_section( 'style_hero_buttons', array(
            'label' => esc_html__( '7. Hero Buttons', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'button_align', array(
            'label'   => esc_html__( 'Button Alignment', 'amaley-core' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => array(
                ''           => esc_html__( 'Default', 'amaley-core' ),
                'flex-start' => esc_html__( 'Left', 'amaley-core' ),
                'center'     => esc_html__( 'Center', 'amaley-core' ),
                'flex-end'   => esc_html__( 'Right', 'amaley-core' ),
            ),
            'selectors' => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-actions' => 'justify-content: {{VALUE}};',
            ),
        ) );

        $this->add_responsive_control( 'button_gap', array(
            'label'      => esc_html__( 'Button Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-actions' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'button_padding', array(
            'label'      => esc_html__( 'Button Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'button_radius', array(
            'label'      => esc_html__( 'Button Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ), '%' => array( 'min' => 0, 'max' => 50 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'button_typography',
            'label'    => esc_html__( 'Button Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn',
        ) );

        $this->add_control( 'primary_button_heading', array(
            'label'     => esc_html__( 'Primary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->start_controls_tabs( 'primary_button_tabs' );
        $this->start_controls_tab( 'primary_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'primary_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-primary' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'primary_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-primary' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'primary_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-primary' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'primary_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'primary_bg_hover', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-primary:hover' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'primary_color_hover', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-primary:hover' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'primary_border_color_hover', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-primary:hover' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'secondary_button_heading', array(
            'label'     => esc_html__( 'Secondary Button', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        $this->start_controls_tabs( 'secondary_button_tabs' );
        $this->start_controls_tab( 'secondary_button_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'secondary_bg', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-secondary' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'secondary_color', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-secondary' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'secondary_border_color', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-secondary' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'secondary_button_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'secondary_bg_hover', array(
            'label'     => esc_html__( 'Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-secondary:hover' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'secondary_color_hover', array(
            'label'     => esc_html__( 'Text Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-secondary:hover' => 'color: {{VALUE}};' ),
        ) );
        $this->add_control( 'secondary_border_color_hover', array(
            'label'     => esc_html__( 'Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-btn-secondary:hover' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section( 'style_hero_stats', array(
            'label' => esc_html__( '8. Hero Stats Panel / Boxes', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_responsive_control( 'stats_panel_padding', array(
            'label'      => esc_html__( 'Stats Panel Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'stats_gap', array(
            'label'      => esc_html__( 'Stats Gap', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-panel' => 'gap: {{SIZE}}{{UNIT}};',
            ),
        ) );

        $this->add_control( 'stats_panel_bg', array(
            'label'     => esc_html__( 'Stats Panel Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-panel' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'stats_panel_border', array(
            'label'     => esc_html__( 'Stats Panel Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-panel' => 'border-color: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'stats_panel_radius', array(
            'label'      => esc_html__( 'Stats Panel Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
            'selectors'  => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-panel' => 'border-radius: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'stat_box_padding', array(
            'label'      => esc_html__( 'Stat Box Padding', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ) );

        $this->add_responsive_control( 'stat_box_radius', array(
            'label'      => esc_html__( 'Stat Box Radius', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
            'selectors'  => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat' => 'border-radius: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->start_controls_tabs( 'stat_box_tabs' );
        $this->start_controls_tab( 'stat_box_normal', array( 'label' => esc_html__( 'Normal', 'amaley-core' ) ) );
        $this->add_control( 'stats_box_bg', array(
            'label'     => esc_html__( 'Stat Box Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'stats_box_border', array(
            'label'     => esc_html__( 'Stat Box Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'stat_box_hover', array( 'label' => esc_html__( 'Hover', 'amaley-core' ) ) );
        $this->add_control( 'stats_box_bg_hover', array(
            'label'     => esc_html__( 'Hover Background', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat:hover' => 'background: {{VALUE}};' ),
        ) );
        $this->add_control( 'stats_box_border_hover', array(
            'label'     => esc_html__( 'Hover Border Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat:hover' => 'border-color: {{VALUE}};' ),
        ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control( 'stat_value_color', array(
            'label'     => esc_html__( 'Stat Value Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat strong' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'stat_value_typography',
            'label'    => esc_html__( 'Stat Value Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat strong',
        ) );
        $this->add_control( 'stat_label_color', array(
            'label'     => esc_html__( 'Stat Label Color', 'amaley-core' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat span' => 'color: {{VALUE}};' ),
        ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
            'name'     => 'stat_label_typography',
            'label'    => esc_html__( 'Stat Label Typography', 'amaley-core' ),
            'selector' => '{{WRAPPER}} .ampa-section.ampa-hero .ampa-hero-stat span',
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_motion', array(
            'label' => esc_html__( '9. Hero Animation / Micro Motion', 'amaley-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ) );

        $this->add_control( 'motion_mode', array(
            'label'        => esc_html__( 'Motion', 'amaley-core' ),
            'type'         => \Elementor\Controls_Manager::SELECT,
            'default'      => '',
            'options'      => array(
                ''    => esc_html__( 'Default', 'amaley-core' ),
                'on'  => esc_html__( 'On', 'amaley-core' ),
                'off' => esc_html__( 'Off', 'amaley-core' ),
            ),
            'prefix_class' => 'ampa-motion-',
        ) );

        $this->add_control( 'hover_lift', array(
            'label'      => esc_html__( 'Hover Lift', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 14 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero' => '--ampa-hover-lift: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'motion_y', array(
            'label'      => esc_html__( 'Entry Movement', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 30 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero' => '--ampa-motion-y: {{SIZE}}px;',
            ),
        ) );

        $this->add_control( 'motion_duration', array(
            'label'      => esc_html__( 'Animation Duration', 'amaley-core' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range'      => array( 'ms' => array( 'min' => 0, 'max' => 1400 ) ),
            'selectors'  => array(
                '{{WRAPPER}} .ampa-section.ampa-hero' => '--ampa-motion-duration: {{SIZE}}ms;',
            ),
        ) );

        $this->end_controls_section();
    }

    protected function render(){
        $r = isset( $GLOBALS['amaley_core_member_archive_sections'] ) ? $GLOBALS['amaley_core_member_archive_sections'] : new Amaley_Core_Member_Archive_Sections();
        echo $r->render_hero( $this->get_settings_for_display() );
    }
}
