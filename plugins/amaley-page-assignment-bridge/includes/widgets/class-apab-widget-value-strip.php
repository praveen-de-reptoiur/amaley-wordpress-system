<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APAB_Widget_Value_Strip extends APAB_Widget_Base {

    public function get_name() { return 'apab_value_strip'; }
    public function get_title() { return esc_html__( 'Amaley Bridge Member Value Strip', 'amaley-page-assignment-bridge' ); }
    public function get_icon() { return 'eicon-heart'; }

    protected function register_controls() {
        /* -------------------- CONTENT: TILES / CARDS -------------------- */
        $this->start_controls_section(
            'content_tiles',
            array(
                'label' => esc_html__( 'Tiles / Cards', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_section',
            array(
                'label'        => esc_html__( 'Show Member Value Strip', 'amaley-page-assignment-bridge' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'amaley-page-assignment-bridge' ),
                'label_off'    => esc_html__( 'Hide', 'amaley-page-assignment-bridge' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'show_item',
            array(
                'label'        => esc_html__( 'Show This Tile', 'amaley-page-assignment-bridge' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'amaley-page-assignment-bridge' ),
                'label_off'    => esc_html__( 'Hide', 'amaley-page-assignment-bridge' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $repeater->add_control(
            'icon',
            array(
                'label'       => esc_html__( 'Icon / Short Mark', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '◆',
                'label_block' => false,
            )
        );

        $repeater->add_control(
            'title',
            array(
                'label'       => esc_html__( 'Title', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Collective Linked', 'amaley-page-assignment-bridge' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'text',
            array(
                'label'       => esc_html__( 'Text', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Part of a local producer group.', 'amaley-page-assignment-bridge' ),
                'rows'        => 3,
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'link',
            array(
                'label'       => esc_html__( 'Optional Link', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://',
                'default'     => array( 'url' => '' ),
            )
        );

        $this->add_control(
            'value_tiles',
            array(
                'label'       => esc_html__( 'Value Tiles', 'amaley-page-assignment-bridge' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'show_item' => 'yes',
                        'icon'      => 'CL',
                        'title'     => 'Collective Linked',
                        'text'      => 'Part of a local producer group.',
                    ),
                    array(
                        'show_item' => 'yes',
                        'icon'      => 'VL',
                        'title'     => 'Village Linked',
                        'text'      => 'Rooted in place and community.',
                    ),
                    array(
                        'show_item' => 'yes',
                        'icon'      => 'SK',
                        'title'     => 'Skill Based',
                        'text'      => 'Built around hands-on capability.',
                    ),
                    array(
                        'show_item' => 'yes',
                        'icon'      => 'PC',
                        'title'     => 'Product Connected',
                        'text'      => 'Linked with Amaley’s value chain.',
                    ),
                ),
                'title_field' => '{{{ title }}}',
                'description' => esc_html__( 'Add, remove or reorder tiles from here. This replaces the old single textarea block.', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->end_controls_section();

        /* -------------------- CONTENT: SHOW / HIDE -------------------- */
        $this->start_controls_section(
            'content_visibility',
            array(
                'label' => esc_html__( 'Show / Hide', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_icons',
            array(
                'label'        => esc_html__( 'Show Icons', 'amaley-page-assignment-bridge' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'show_titles',
            array(
                'label'        => esc_html__( 'Show Titles', 'amaley-page-assignment-bridge' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'show_text',
            array(
                'label'        => esc_html__( 'Show Text', 'amaley-page-assignment-bridge' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();

        /* -------------------- LAYOUT / ALIGNMENT -------------------- */
        $this->start_controls_section(
            'layout_section',
            array(
                'label' => esc_html__( 'Layout / Alignment', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'           => esc_html__( 'Columns', 'amaley-page-assignment-bridge' ),
                'type'            => \Elementor\Controls_Manager::SELECT,
                'default'         => '4',
                'tablet_default'  => '2',
                'mobile_default'  => '1',
                'options'         => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'selectors'       => array(
                    '{{WRAPPER}} .apab-value-strip' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr)) !important;',
                ),
            )
        );

        $this->add_control(
            'card_layout',
            array(
                'label'   => esc_html__( 'Card Layout', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon_left',
                'options' => array(
                    'icon_left' => esc_html__( 'Icon Left / Text Right', 'amaley-page-assignment-bridge' ),
                    'icon_top'  => esc_html__( 'Icon Top / Text Bottom', 'amaley-page-assignment-bridge' ),
                ),
                'selectors_dictionary' => array(
                    'icon_left' => 'flex-direction: row; align-items: flex-start;',
                    'icon_top'  => 'flex-direction: column; align-items: flex-start;',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip__card' => '{{VALUE}}',
                ),
                'description' => esc_html__( 'Works live in Elementor. Icon Top is useful for centered mobile cards.', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->add_responsive_control(
            'section_alignment',
            array(
                'label'   => esc_html__( 'Section Alignment', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'start'  => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ),
                    'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ),
                    'end'    => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ),
                ),
                'default' => 'start',
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip' => 'justify-items: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'card_alignment',
            array(
                'label'   => esc_html__( 'Card Text Alignment', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'left'   => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ),
                    'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ),
                    'right'  => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ),
                ),
                'default' => 'left',
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip__card' => 'text-align: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'card_min_height',
            array(
                'label' => esc_html__( 'Card Min Height', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array( 'px' => array( 'min' => 0, 'max' => 240 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip__card' => 'min-height: {{SIZE}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'card_width',
            array(
                'label' => esc_html__( 'Card Width', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( '%' ),
                'range' => array( '%' => array( 'min' => 40, 'max' => 100 ) ),
                'default' => array( 'unit' => '%', 'size' => 100 ),
                'tablet_default' => array( 'unit' => '%', 'size' => 100 ),
                'mobile_default' => array( 'unit' => '%', 'size' => 100 ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip__card' => 'width: {{SIZE}}{{UNIT}} !important;',
                ),
                'description' => esc_html__( 'Keep 100% for full cards. Reduce width only when using section alignment.', 'amaley-page-assignment-bridge' ),
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: SECTION / CARDS -------------------- */
        $this->start_controls_section(
            'style_section',
            array(
                'label' => esc_html__( 'Section / Cards', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'bg',
            array(
                'label' => esc_html__( 'Section Background', 'amaley-page-assignment-bridge' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .apab-value-strip' => 'background: {{VALUE}} !important;' ),
            )
        );

        $this->add_control(
            'top_accent_color',
            array(
                'label' => esc_html__( 'Top Accent Color', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip' => 'background-image: linear-gradient(to bottom, {{VALUE}} 0, {{VALUE}} 2px, transparent 2px) !important;',
                ),
            )
        );

        $this->add_control(
            'card_bg',
            array(
                'label' => esc_html__( 'Card Background', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__card' => 'background: {{VALUE}} !important;' ),
            )
        );

        $this->add_control(
            'card_hover_bg',
            array(
                'label' => esc_html__( 'Card Hover Background', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__card:hover' => 'background: {{VALUE}} !important;' ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            array(
                'name'     => 'card_border',
                'selector' => '{{WRAPPER}} .apab-value-strip__card',
            )
        );

        $this->add_control(
            'card_radius',
            array(
                'label' => esc_html__( 'Card Radius', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__card' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .apab-value-strip__card',
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: ICON -------------------- */
        $this->start_controls_section(
            'style_icon',
            array(
                'label' => esc_html__( 'Icon', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'icon_size',
            array(
                'label' => esc_html__( 'Icon Size', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array( 'px' => array( 'min' => 18, 'max' => 80 ) ),
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip__icon' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important; flex-basis: {{SIZE}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_control(
            'icon_bg',
            array(
                'label' => esc_html__( 'Icon Background', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__icon' => 'background: {{VALUE}} !important;' ),
            )
        );

        $this->add_control(
            'icon_color',
            array(
                'label' => esc_html__( 'Icon Color', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__icon' => 'color: {{VALUE}} !important;' ),
            )
        );


        $this->add_responsive_control(
            'icon_alignment',
            array(
                'label'   => esc_html__( 'Icon Alignment', 'amaley-page-assignment-bridge' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array( 'title' => 'Left / Top', 'icon' => 'eicon-h-align-left' ),
                    'center'     => array( 'title' => 'Center', 'icon' => 'eicon-h-align-center' ),
                    'flex-end'   => array( 'title' => 'Right / Bottom', 'icon' => 'eicon-h-align-right' ),
                ),
                'default' => 'flex-start',
                'selectors' => array(
                    '{{WRAPPER}} .apab-value-strip__icon' => 'align-self: {{VALUE}} !important;',
                ),
            )
        );

        $this->end_controls_section();

        /* -------------------- STYLE: TEXT -------------------- */
        $this->start_controls_section(
            'style_text',
            array(
                'label' => esc_html__( 'Title / Text', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label' => esc_html__( 'Title Color', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__title' => 'color: {{VALUE}} !important;' ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .apab-value-strip__title',
            )
        );

        $this->add_control(
            'text_color',
            array(
                'label' => esc_html__( 'Text Color', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__text' => 'color: {{VALUE}} !important;' ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .apab-value-strip__text',
            )
        );

        $this->end_controls_section();

        /* -------------------- SPACING -------------------- */
        $this->start_controls_section(
            'spacing_section',
            array(
                'label' => esc_html__( 'Spacing / Responsive', 'amaley-page-assignment-bridge' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'section_margin',
            array(
                'label'      => esc_html__( 'Section Margin', 'amaley-page-assignment-bridge' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .apab-value-strip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'section_padding',
            array(
                'label'      => esc_html__( 'Section Padding', 'amaley-page-assignment-bridge' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .apab-value-strip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'card_gap',
            array(
                'label' => esc_html__( 'Card Gap', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
                'selectors' => array( '{{WRAPPER}} .apab-value-strip' => 'gap: {{SIZE}}{{UNIT}} !important;' ),
            )
        );

        $this->add_responsive_control(
            'card_padding',
            array(
                'label'      => esc_html__( 'Card Padding', 'amaley-page-assignment-bridge' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .apab-value-strip__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_text_gap',
            array(
                'label' => esc_html__( 'Icon / Text Gap', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__card' => 'gap: {{SIZE}}{{UNIT}} !important;' ),
            )
        );

        $this->add_responsive_control(
            'title_text_gap',
            array(
                'label' => esc_html__( 'Title / Text Gap', 'amaley-page-assignment-bridge' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array( 'px' => array( 'min' => 0, 'max' => 30 ) ),
                'selectors' => array( '{{WRAPPER}} .apab-value-strip__title' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;' ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( isset( $settings['show_section'] ) && 'yes' !== $settings['show_section'] ) {
            return;
        }

        $tiles = $this->get_tiles_from_settings( $settings );
        if ( empty( $tiles ) ) {
            return;
        }

        $layout = isset( $settings['card_layout'] ) && 'icon_top' === $settings['card_layout'] ? 'icon-top' : 'icon-left';
        $classes = array(
            'apab-value-strip',
            'apab-value-strip--layout-' . $layout,
        );

        echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        foreach ( $tiles as $tile ) {
            $title = isset( $tile['title'] ) ? $tile['title'] : '';
            $text  = isset( $tile['text'] ) ? $tile['text'] : '';
            $icon  = isset( $tile['icon'] ) ? $tile['icon'] : '◆';
            $url   = isset( $tile['url'] ) ? $tile['url'] : '';
            $target = ! empty( $tile['target'] ) ? ' target="_blank" rel="noopener"' : '';

            $inner  = '';
            if ( ! empty( $settings['show_icons'] ) && 'yes' === $settings['show_icons'] ) {
                $inner .= '<span class="apab-value-strip__icon">' . esc_html( $icon ) . '</span>';
            }
            $inner .= '<div class="apab-value-strip__body">';
            if ( ! empty( $settings['show_titles'] ) && 'yes' === $settings['show_titles'] && '' !== $title ) {
                $inner .= '<strong class="apab-value-strip__title">' . esc_html( $title ) . '</strong>';
            }
            if ( ! empty( $settings['show_text'] ) && 'yes' === $settings['show_text'] && '' !== $text ) {
                $inner .= '<p class="apab-value-strip__text">' . esc_html( $text ) . '</p>';
            }
            $inner .= '</div>';

            if ( $url ) {
                echo '<a class="apab-value-strip__card apab-value-strip__card--linked" href="' . esc_url( $url ) . '"' . $target . '>' . $inner . '</a>';
            } else {
                echo '<div class="apab-value-strip__card">' . $inner . '</div>';
            }
        }
        echo '</section>';
    }

    private function get_tiles_from_settings( $settings ) {
        $tiles = array();

        if ( ! empty( $settings['value_tiles'] ) && is_array( $settings['value_tiles'] ) ) {
            foreach ( $settings['value_tiles'] as $item ) {
                if ( isset( $item['show_item'] ) && 'yes' !== $item['show_item'] ) {
                    continue;
                }
                $title = isset( $item['title'] ) ? trim( (string) $item['title'] ) : '';
                $text  = isset( $item['text'] ) ? trim( (string) $item['text'] ) : '';
                $icon  = isset( $item['icon'] ) ? trim( (string) $item['icon'] ) : '◆';
                $url   = '';
                $target = false;
                if ( ! empty( $item['link'] ) && is_array( $item['link'] ) && ! empty( $item['link']['url'] ) ) {
                    $url = $item['link']['url'];
                    $target = ! empty( $item['link']['is_external'] );
                }
                if ( '' === $title && '' === $text ) {
                    continue;
                }
                $tiles[] = array(
                    'title'  => $title,
                    'text'   => $text,
                    'icon'   => '' !== $icon ? $icon : '◆',
                    'url'    => $url,
                    'target' => $target,
                );
            }
        }

        if ( empty( $tiles ) && ! empty( $settings['items'] ) ) {
            $lines = preg_split( '/\r\n|\r|\n/', (string) $settings['items'] );
            foreach ( $lines as $line ) {
                $line = trim( $line );
                if ( '' === $line ) {
                    continue;
                }
                $parts = array_map( 'trim', explode( '|', $line, 2 ) );
                $title = isset( $parts[0] ) ? $parts[0] : '';
                $text  = isset( $parts[1] ) ? $parts[1] : '';
                if ( '' === $title && '' === $text ) {
                    continue;
                }
                $tiles[] = array(
                    'title'  => $title,
                    'text'   => $text,
                    'icon'   => '◆',
                    'url'    => '',
                    'target' => false,
                );
            }
        }

        return $tiles;
    }
}
