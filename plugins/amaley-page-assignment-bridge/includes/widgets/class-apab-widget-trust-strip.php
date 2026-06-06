<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APAB_Widget_Trust_Strip extends APAB_Widget_Base {

    public function get_name() { return 'apab_trust_strip'; }
    public function get_title() { return esc_html__( 'Amaley Bridge Trust Strip', 'amaley-page-assignment-bridge' ); }
    public function get_icon() { return 'eicon-check-circle'; }
    public function get_keywords() { return array( 'amaley', 'bridge', 'trust', 'strip', 'single product' ); }

    protected function register_controls() {
        /* -------------------- CONTENT -------------------- */
        $this->start_controls_section(
            'content_section',
            array(
                'label' => esc_html__( 'Content', 'amaley-page-assignment-bridge' ),
            )
        );

        for ( $i = 1; $i <= 3; $i++ ) {
            $defaults = $this->default_item( $i );
            $this->add_control(
                'item_' . $i . '_heading',
                array(
                    'label'     => sprintf( esc_html__( 'Item %d', 'amaley-page-assignment-bridge' ), $i ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 1 === $i ? 'none' : 'before',
                )
            );
            $this->add_control(
                'item_' . $i . '_icon',
                array(
                    'label'   => esc_html__( 'Icon / Symbol', 'amaley-page-assignment-bridge' ),
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => $defaults['icon'],
                )
            );
            $this->add_control(
                'item_' . $i . '_title',
                array(
                    'label'       => esc_html__( 'Title', 'amaley-page-assignment-bridge' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => $defaults['title'],
                    'label_block' => true,
                )
            );
            $this->add_control(
                'item_' . $i . '_text',
                array(
                    'label'       => esc_html__( 'Description', 'amaley-page-assignment-bridge' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'default'     => $defaults['text'],
                    'rows'        => 2,
                    'label_block' => true,
                )
            );
        }

        $this->add_control(
            'legacy_items',
            array(
                'label'       => esc_html__( 'Legacy Fallback Items', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => "Small Batch|Made with limited seasonal capacity\nTraceable Origin|Cluster · SHG · Producer\nCarefully Packed|Packed for safe delivery",
                'description' => esc_html__( 'Fallback only. One item per line: Title|Text.', 'amaley-page-assignment-bridge' ),
                'separator'   => 'before',
            )
        );

        $this->end_controls_section();

        /* -------------------- SHOW / HIDE -------------------- */
        $this->start_controls_section(
            'visibility_section',
            array(
                'label' => esc_html__( 'Show / Hide', 'amaley-page-assignment-bridge' ),
            )
        );

        $visibility = array(
            'show_strip'        => array( 'Show Trust Strip', 'yes' ),
            'show_icons'        => array( 'Show Icons', 'yes' ),
            'show_titles'       => array( 'Show Titles', 'yes' ),
            'show_descriptions' => array( 'Show Descriptions', 'yes' ),
            'show_borders'      => array( 'Show Borders / Dividers', 'yes' ),
            'show_item_1'       => array( 'Show Item 1', 'yes' ),
            'show_item_2'       => array( 'Show Item 2', 'yes' ),
            'show_item_3'       => array( 'Show Item 3', 'yes' ),
        );

        foreach ( $visibility as $control_id => $data ) {
            $this->add_control(
                $control_id,
                array(
                    'label'        => esc_html__( $data[0], 'amaley-page-assignment-bridge' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'default'      => $data[1],
                    'return_value' => 'yes',
                )
            );
        }

        $this->end_controls_section();

        /* -------------------- LAYOUT -------------------- */
        $this->start_controls_section(
            'layout_section',
            array(
                'label' => esc_html__( 'Layout', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'   => esc_html__( 'Columns', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-trust-strip' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
                ),
            )
        );

        $this->add_control(
            'card_layout',
            array(
                'label'   => esc_html__( 'Card Layout', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => array(
                    'horizontal' => esc_html__( 'Horizontal', 'amaley-page-assignment-bridge' ),
                    'vertical'   => esc_html__( 'Vertical', 'amaley-page-assignment-bridge' ),
                ),
            )
        );

        $this->add_responsive_control(
            'card_min_height',
            array(
                'label' => esc_html__( 'Card Min Height', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 40, 'max' => 220 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-trust-strip__item' => 'min-height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        /* -------------------- ALIGNMENT -------------------- */
        $this->start_controls_section(
            'alignment_section',
            array(
                'label' => esc_html__( 'Alignment', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_flex_alignment_control( 'strip_align', 'Strip Items Alignment', '{{WRAPPER}} .apab-trust-strip' );
        $this->add_alignment_control( 'card_align', 'Card Text Alignment', '{{WRAPPER}} .apab-trust-strip__item' );
        $this->add_flex_alignment_control( 'card_content_align', 'Card Content Horizontal Align', '{{WRAPPER}} .apab-trust-strip__item' );
        $this->add_alignment_control( 'title_align', 'Title Alignment', '{{WRAPPER}} .apab-trust-strip__title' );
        $this->add_alignment_control( 'text_align', 'Description Alignment', '{{WRAPPER}} .apab-trust-strip__text' );
        $this->add_flex_alignment_control( 'icon_align', 'Icon Alignment', '{{WRAPPER}} .apab-trust-strip__icon' );

        $this->end_controls_section();

        /* -------------------- STYLE -------------------- */
        $this->start_controls_section(
            'style_section',
            array(
                'label' => esc_html__( 'Section / Cards', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control( 'section_bg', array( 'label' => 'Section Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'card_bg', array( 'label' => 'Card Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'card_hover_bg', array( 'label' => 'Card Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'border_color', array( 'label' => 'Border / Divider Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip, {{WRAPPER}} .apab-trust-strip__item' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'card_radius', array( 'label' => 'Card Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'icon_heading', array( 'label' => 'Icon', 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'icon_bg', array( 'label' => 'Icon Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_color', array( 'label' => 'Icon Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_bg', array( 'label' => 'Icon Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item:hover .apab-trust-strip__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_color', array( 'label' => 'Icon Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item:hover .apab-trust-strip__icon' => 'color: {{VALUE}};' ) ) );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_text_section',
            array(
                'label' => esc_html__( 'Text', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control( 'title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'title_hover_color', array( 'label' => 'Title Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item:hover .apab-trust-strip__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .apab-trust-strip__title' ) );

        $this->add_control( 'text_color', array( 'label' => 'Description Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__text' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'text_hover_color', array( 'label' => 'Description Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item:hover .apab-trust-strip__text' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'text_typography', 'selector' => '{{WRAPPER}} .apab-trust-strip__text' ) );

        $this->end_controls_section();

        /* -------------------- SPACING -------------------- */
        $this->start_controls_section(
            'spacing_section',
            array(
                'label' => esc_html__( 'Spacing / Responsive', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control( 'section_margin', array( 'label' => 'Section Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => 'Section Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => 'Card Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => 'Card Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'content_gap', array( 'label' => 'Icon / Text Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__item' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'title_text_gap', array( 'label' => 'Title / Description Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 30 ) ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__text' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'icon_size', array( 'label' => 'Icon Size', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 18, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .apab-trust-strip__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};' ) ) );

        $this->end_controls_section();
    }

    private function default_item( $index ) {
        $items = array(
            1 => array( 'icon' => '◆', 'title' => 'Small Batch', 'text' => 'Made with limited seasonal capacity' ),
            2 => array( 'icon' => '◆', 'title' => 'Traceable Origin', 'text' => 'Cluster · SHG · Producer' ),
            3 => array( 'icon' => '◆', 'title' => 'Carefully Packed', 'text' => 'Packed for safe delivery' ),
        );
        return isset( $items[ $index ] ) ? $items[ $index ] : array( 'icon' => '◆', 'title' => '', 'text' => '' );
    }

    private function add_alignment_control( $id, $label, $selector ) {
        $this->add_responsive_control(
            $id,
            array(
                'label'   => esc_html__( $label, 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array( 'title' => esc_html__( 'Left', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-text-align-left' ),
                    'center' => array( 'title' => esc_html__( 'Center', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-text-align-center' ),
                    'right' => array( 'title' => esc_html__( 'Right', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-text-align-right' ),
                ),
                'default'   => 'left',
                'toggle'    => false,
                'selectors' => array(
                    $selector => 'text-align: {{VALUE}};',
                ),
            )
        );
    }

    private function add_flex_alignment_control( $id, $label, $selector ) {
        $this->add_responsive_control(
            $id,
            array(
                'label'   => esc_html__( $label, 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__( 'Center', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-h-align-center' ),
                    'flex-end' => array( 'title' => esc_html__( 'Right', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-h-align-right' ),
                ),
                'default'   => 'flex-start',
                'toggle'    => false,
                'selectors' => array(
                    $selector => 'justify-content: {{VALUE}};',
                ),
            )
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( 'yes' !== $settings['show_strip'] ) {
            return;
        }

        $items = array();
        for ( $i = 1; $i <= 3; $i++ ) {
            if ( 'yes' !== $settings[ 'show_item_' . $i ] ) {
                continue;
            }
            $title = isset( $settings[ 'item_' . $i . '_title' ] ) ? trim( (string) $settings[ 'item_' . $i . '_title' ] ) : '';
            $text  = isset( $settings[ 'item_' . $i . '_text' ] ) ? trim( (string) $settings[ 'item_' . $i . '_text' ] ) : '';
            $icon  = isset( $settings[ 'item_' . $i . '_icon' ] ) ? trim( (string) $settings[ 'item_' . $i . '_icon' ] ) : '';
            if ( '' === $title && '' === $text && '' === $icon ) {
                continue;
            }
            $items[] = array( 'title' => $title, 'text' => $text, 'icon' => $icon );
        }

        if ( empty( $items ) ) {
            $items = $this->legacy_items( isset( $settings['legacy_items'] ) ? $settings['legacy_items'] : '' );
        }

        if ( empty( $items ) ) {
            return;
        }

        $classes = array(
            'apab-trust-strip',
            'apab-trust-strip--card-layout-' . sanitize_html_class( $settings['card_layout'] ),
        );
        if ( 'yes' !== $settings['show_borders'] ) {
            $classes[] = 'apab-trust-strip--hide-borders';
        }

        echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        foreach ( $items as $item ) {
            echo '<div class="apab-trust-strip__item">';
            if ( 'yes' === $settings['show_icons'] && '' !== $item['icon'] ) {
                echo '<span class="apab-trust-strip__icon" aria-hidden="true">' . esc_html( $item['icon'] ) . '</span>';
            }
            echo '<div class="apab-trust-strip__body">';
            if ( 'yes' === $settings['show_titles'] && '' !== $item['title'] ) {
                echo '<strong class="apab-trust-strip__title">' . esc_html( $item['title'] ) . '</strong>';
            }
            if ( 'yes' === $settings['show_descriptions'] && '' !== $item['text'] ) {
                echo '<small class="apab-trust-strip__text">' . esc_html( $item['text'] ) . '</small>';
            }
            echo '</div>';
            echo '</div>';
        }
        echo '</section>';
    }

    private function legacy_items( $raw ) {
        $items = array();
        $lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
        foreach ( $lines as $line ) {
            $line = trim( $line );
            if ( '' === $line ) {
                continue;
            }
            $parts = array_map( 'trim', explode( '|', $line, 2 ) );
            $items[] = array(
                'icon'  => '◆',
                'title' => isset( $parts[0] ) ? $parts[0] : '',
                'text'  => isset( $parts[1] ) ? $parts[1] : '',
            );
        }
        return $items;
    }
}
