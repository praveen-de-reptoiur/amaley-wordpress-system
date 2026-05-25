<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Tpl_Trust_Strip_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amaley_tpl_trust_strip';
    }

    public function get_title() {
        return esc_html__( 'Amaley Templates Product Trust Strip', 'amaley-templates' );
    }

    public function get_icon() {
        return 'eicon-check-circle';
    }

    public function get_categories() {
        return array( 'amaley-templates' );
    }

    public function get_style_depends() {
        return array( 'amaley-templates-frontend' );
    }

    public function get_script_depends() {
        return array( 'amaley-templates-frontend' );
    }


    public function get_keywords() {
        return array( 'amaley templates', 'amaley', 'templates', 'product', 'single', 'woocommerce' );
    }

    protected function register_controls() {
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( 'Items', 'amaley-templates' ) ) );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'icon', array( 'label' => 'Icon/Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '◆' ) );
        $repeater->add_control( 'title', array( 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Traceable Origin' ) );
        $repeater->add_control( 'text', array( 'label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster · SHG · Producer' ) );

        $this->add_control( 'items', array(
            'label' => 'Trust Items',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => array(
                array( 'icon' => '🌿', 'title' => 'Small Batch', 'text' => 'Made with limited seasonal capacity' ),
                array( 'icon' => '◆', 'title' => 'Traceable Origin', 'text' => 'Cluster · SHG · Producer' ),
                array( 'icon' => '📦', 'title' => 'Carefully Packed', 'text' => 'Packed for safe delivery' ),
            ),
            'title_field' => '{{{ title }}}',
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_strip', array( 'label' => esc_html__( 'Strip / Container', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'strip_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'strip_border', 'selector' => '{{WRAPPER}} .amaley-tpl-trust-strip' ) );
        $this->add_responsive_control( 'strip_gap', array( 'label' => 'Column Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_items', array( 'label' => esc_html__( 'Items', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'item_bg', array( 'label' => 'Item Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'item_border_color', array( 'label' => 'Item Divider Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'item_hover_bg', array( 'label' => 'Item Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'item_hover_border_color', array( 'label' => 'Item Hover Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'item_padding', array( 'label' => 'Item Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'item_radius', array( 'label' => 'Item Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'item_shadow', 'selector' => '{{WRAPPER}} .amaley-tpl-trust-strip__item' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_icons', array( 'label' => esc_html__( 'Icon Circle', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'icon_size', array( 'label' => 'Icon Size', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 20, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'icon_bg', array( 'label' => 'Icon Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_color', array( 'label' => 'Icon Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_bg', array( 'label' => 'Icon Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item:hover .amaley-tpl-trust-strip__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_color', array( 'label' => 'Icon Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item:hover .amaley-tpl-trust-strip__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'icon_radius', array( 'label' => 'Icon Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__icon' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_text', array( 'label' => esc_html__( 'Title / Text', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item strong' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-trust-strip__item strong' ) );
        $this->add_control( 'text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'title_hover_color', array( 'label' => 'Title Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item:hover strong' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'text_hover_color', array( 'label' => 'Text Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-trust-strip__item:hover span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'text_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-trust-strip__item span' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="amaley-tpl-trust-strip">
            <?php foreach ( $settings['items'] as $item ) : ?>
                <div class="amaley-tpl-trust-strip__item">
                    <div class="amaley-tpl-trust-strip__icon"><?php echo esc_html( $item['icon'] ); ?></div>
                    <div>
                        <strong><?php echo esc_html( $item['title'] ); ?></strong>
                        <span><?php echo esc_html( $item['text'] ); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
        <?php
    }
}
