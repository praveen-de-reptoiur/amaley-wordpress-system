<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Tpl_Member_Value_Strip_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_tpl_member_value_strip';
    }

    public function get_title() {
        return esc_html__( 'Amaley Templates Member Value Strip', 'amaley-templates' );
    }

    public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_categories() {
        return array( 'amaley-templates' );
    }

    public function get_keywords() {
        return array( 'amaley templates', 'amaley', 'templates', 'member', 'shg', 'strip', 'value', 'profile' );
    }

    public function get_style_depends() {
        return array( 'amaley-templates-frontend' );
    }

    public function get_script_depends() {
        return array( 'amaley-templates-frontend' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_cards',
            array(
                'label' => esc_html__( 'Cards', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'icon_text',
            array(
                'label'       => esc_html__( 'Icon Text', 'amaley-templates' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '✦',
                'label_block' => false,
            )
        );
        $repeater->add_control(
            'title',
            array(
                'label'       => esc_html__( 'Title', 'amaley-templates' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Collective Linked', 'amaley-templates' ),
                'label_block' => true,
                'dynamic'     => array( 'active' => true ),
            )
        );
        $repeater->add_control(
            'text',
            array(
                'label'       => esc_html__( 'Text', 'amaley-templates' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Part of a local producer group.', 'amaley-templates' ),
                'rows'        => 2,
                'label_block' => true,
                'dynamic'     => array( 'active' => true ),
            )
        );
        $repeater->add_control(
            'link',
            array(
                'label'       => esc_html__( 'Optional Link', 'amaley-templates' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                'dynamic'     => array( 'active' => true ),
            )
        );

        $this->add_control(
            'cards',
            array(
                'label'       => esc_html__( 'Value Cards', 'amaley-templates' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
                'default'     => array(
                    array( 'icon_text' => '✦', 'title' => 'Collective Linked', 'text' => 'Part of a local producer group.' ),
                    array( 'icon_text' => '⌂', 'title' => 'Village Linked', 'text' => 'Rooted in place and community.' ),
                    array( 'icon_text' => '✓', 'title' => 'Skill Based', 'text' => 'Built around hands-on capability.' ),
                    array( 'icon_text' => '◆', 'title' => 'Product Connected', 'text' => 'Linked with Amaley’s value chain.' ),
                ),
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'   => esc_html__( 'Columns', 'amaley-templates' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .amaley-tpl-member-strip__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            array(
                'label' => esc_html__( 'Strip / Section', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control(
            'section_bg',
            array(
                'label'     => esc_html__( 'Background', 'amaley-templates' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip' => 'background: {{VALUE}};' ),
            )
        );
        $this->add_responsive_control(
            'section_padding',
            array(
                'label'      => esc_html__( 'Padding', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array( '{{WRAPPER}} .amaley-tpl-member-strip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            )
        );
        $this->add_responsive_control(
            'section_margin',
            array(
                'label'      => esc_html__( 'Margin', 'amaley-templates' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array( '{{WRAPPER}} .amaley-tpl-member-strip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
            )
        );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'selector' => '{{WRAPPER}} .amaley-tpl-member-strip' ) );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_grid',
            array(
                'label' => esc_html__( 'Inner Grid', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_responsive_control(
            'max_width',
            array(
                'label' => esc_html__( 'Max Width', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range' => array( 'px' => array( 'min' => 640, 'max' => 1600 ), '%' => array( 'min' => 60, 'max' => 100 ) ),
                'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__inner' => 'max-width: {{SIZE}}{{UNIT}};' ),
            )
        );
        $this->add_responsive_control(
            'grid_gap',
            array(
                'label' => esc_html__( 'Gap', 'amaley-templates' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ),
                'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__grid' => 'gap: {{SIZE}}{{UNIT}};' ),
            )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_card',
            array(
                'label' => esc_html__( 'Cards', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control( 'card_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'card_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .amaley-tpl-member-strip__card' ) );
        $this->add_control( 'card_hover_border', array( 'label' => 'Hover Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_min_height', array( 'label' => 'Min Height', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 40, 'max' => 160 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'card_radius', array( 'label' => 'Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amaley-tpl-member-strip__card' ) );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_icon',
            array(
                'label' => esc_html__( 'Icon Circle', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control( 'icon_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_color', array( 'label' => 'Icon Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card:hover .amaley-tpl-member-strip__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_color', array( 'label' => 'Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card:hover .amaley-tpl-member-strip__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'icon_size', array( 'label' => 'Size', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 20, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'icon_radius', array( 'label' => 'Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__icon' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_text',
            array(
                'label' => esc_html__( 'Title / Text', 'amaley-templates' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control( 'title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'title_hover_color', array( 'label' => 'Title Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card:hover .amaley-tpl-member-strip__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-member-strip__title' ) );
        $this->add_control( 'text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__text' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'text_hover_color', array( 'label' => 'Text Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__card:hover .amaley-tpl-member-strip__text' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'text_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-member-strip__text' ) );
        $this->add_responsive_control( 'text_gap', array( 'label' => 'Title/Text Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-member-strip__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( empty( $settings['cards'] ) || ! is_array( $settings['cards'] ) ) {
            return;
        }
        ?>
        <section class="amaley-tpl-member-strip" aria-label="<?php echo esc_attr__( 'Member profile highlights', 'amaley-templates' ); ?>">
            <div class="amaley-tpl-member-strip__inner">
                <div class="amaley-tpl-member-strip__grid">
                    <?php foreach ( $settings['cards'] as $index => $card ) :
                        $tag = 'div';
                        $attr = 'class="amaley-tpl-member-strip__card"';
                        if ( ! empty( $card['link']['url'] ) ) {
                            $tag = 'a';
                            $this->add_link_attributes( 'member_strip_card_' . $index, $card['link'] );
                            $attr = 'class="amaley-tpl-member-strip__card" ' . $this->get_render_attribute_string( 'member_strip_card_' . $index );
                        }
                        ?>
                        <<?php echo esc_html( $tag ); ?> <?php echo wp_kses_post( $attr ); ?>>
                            <span class="amaley-tpl-member-strip__icon" aria-hidden="true"><?php echo esc_html( $card['icon_text'] ); ?></span>
                            <span class="amaley-tpl-member-strip__content">
                                <strong class="amaley-tpl-member-strip__title"><?php echo esc_html( $card['title'] ); ?></strong>
                                <span class="amaley-tpl-member-strip__text"><?php echo esc_html( $card['text'] ); ?></span>
                            </span>
                        </<?php echo esc_html( $tag ); ?>>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
