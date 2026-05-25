<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Tpl_Shop_Hero_Widget extends Amaley_Tpl_Widget_Base {

    public function get_name() {
        return 'amaley_tpl_shop_hero';
    }

    public function get_title() {
        return esc_html__( 'Amaley Templates Shop Hero', 'amaley-templates' );
    }

    public function get_icon() {
        return 'eicon-archive-title';
    }

    public function get_categories() {
        return array( 'amaley-templates' );
    }

    public function get_keywords() {
        return array( 'amaley templates', 'amaley', 'shop', 'archive', 'hero', 'woocommerce' );
    }

    private function spacing_controls( $prefix, $selector ) {
        $this->add_responsive_control( $prefix . '_padding', array(
            'label' => 'Padding',
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors' => array( '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( $prefix . '_margin', array(
            'label' => 'Margin',
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors' => array( '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
    }

    protected function register_controls() {
        $this->start_controls_section( 'content_shop_hero', array( 'label' => esc_html__( 'Shop Hero Content', 'amaley-templates' ) ) );
        $this->add_control( 'kicker', array( 'label' => 'Kicker', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.hero_kicker', 'Shop Amaley' ), 'label_block' => true ) );
        $this->add_control( 'title', array( 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.hero_title', 'Himalayan Pantry' ), 'label_block' => true ) );
        $this->add_control( 'accent', array( 'label' => 'Accent Word', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'shop_page.hero_accent', 'Collections' ), 'label_block' => true ) );
        $this->add_control( 'description', array( 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $this->tpl_setting( 'shop_page.hero_text', 'Explore small-batch Himalayan foods, teas, preserves and seasonal products linked with Amaley’s village and producer network.' ) ) );
        $this->add_control( 'pills', array( 'label' => 'Pills', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $this->tpl_setting( 'shop_page.hero_pills', 'Small Batch|Traceable Origin|Natural Himalayan Foods' ), 'description' => 'Use | between items.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_wrapper', array( 'label' => esc_html__( 'Wrapper / Layout', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2E1203', 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'padding', array( 'label' => 'Inner Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'outer_margin', array( 'label' => 'Outer Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'max_width', array( 'label' => 'Inner Max Width', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 760, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'text_align', array( 'label' => 'Text Align', 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => 'Left', 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => 'Right', 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__inner' => 'text-align: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'border', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-hero' ) );
        $this->add_responsive_control( 'radius', array( 'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'shadow', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-hero' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_kicker', array( 'label' => esc_html__( 'Kicker', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'kicker_color', array( 'label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C2880A', 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__kicker' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-hero__kicker' ) );
        $this->spacing_controls( 'kicker', '.amaley-tpl-shop-hero__kicker' );
        $this->end_controls_section();

        $this->start_controls_section( 'style_title', array( 'label' => esc_html__( 'Title / Accent', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#FFF8EA', 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'accent_color', array( 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#B5502A', 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__title span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-hero__title' ) );
        $this->spacing_controls( 'title', '.amaley-tpl-shop-hero__title' );
        $this->end_controls_section();

        $this->start_controls_section( 'style_text', array( 'label' => esc_html__( 'Description', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F3D6A8', 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__text' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'text_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-hero__text' ) );
        $this->add_control( 'text_max_width', array( 'label' => 'Text Max Width', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 260, 'max' => 1100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__text' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->spacing_controls( 'text', '.amaley-tpl-shop-hero__text' );
        $this->end_controls_section();

        $this->start_controls_section( 'style_pills', array( 'label' => esc_html__( 'Pills Wrapper', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'pills_gap', array( 'label' => 'Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pills' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'pills_justify', array( 'label' => 'Justify', 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'flex-start' => array( 'title' => 'Left', 'icon' => 'eicon-h-align-left' ), 'center' => array( 'title' => 'Center', 'icon' => 'eicon-h-align-center' ), 'flex-end' => array( 'title' => 'Right', 'icon' => 'eicon-h-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pills' => 'justify-content: {{VALUE}};' ) ) );
        $this->spacing_controls( 'pills_wrap', '.amaley-tpl-shop-hero__pills' );
        $this->end_controls_section();

        $this->start_controls_section( 'style_pill_item', array( 'label' => esc_html__( 'Pill Items', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'pill_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pill' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'pill_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#F8DFA8', 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pill' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'pill_hover_bg', array( 'label' => 'Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pill:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'pill_hover_color', array( 'label' => 'Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pill:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'pill_border_color', array( 'label' => 'Pill Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(194,136,10,.52)', 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pill' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'pill_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-shop-hero__pill' ) );
        $this->spacing_controls( 'pill', '.amaley-tpl-shop-hero__pill' );
        $this->add_responsive_control( 'pill_radius', array( 'label' => 'Border Radius', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-shop-hero__pill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $pills = array_filter( array_map( 'trim', explode( '|', (string) $settings['pills'] ) ) );
        ?>
        <section class="amaley-tpl-shop-hero" aria-label="Amaley shop introduction">
            <div class="amaley-tpl-shop-hero__inner">
                <?php if ( ! empty( $settings['kicker'] ) ) : ?><div class="amaley-tpl-shop-hero__kicker"><?php echo esc_html( $settings['kicker'] ); ?></div><?php endif; ?>
                <h1 class="amaley-tpl-shop-hero__title"><?php echo esc_html( $settings['title'] ); ?><?php if ( ! empty( $settings['accent'] ) ) : ?> <span><?php echo esc_html( $settings['accent'] ); ?></span><?php endif; ?></h1>
                <?php if ( ! empty( $settings['description'] ) ) : ?><p class="amaley-tpl-shop-hero__text"><?php echo esc_html( $settings['description'] ); ?></p><?php endif; ?>
                <?php if ( ! empty( $pills ) ) : ?>
                    <div class="amaley-tpl-shop-hero__pills">
                        <?php foreach ( $pills as $pill ) : ?><span class="amaley-tpl-shop-hero__pill"><?php echo esc_html( $pill ); ?></span><?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
