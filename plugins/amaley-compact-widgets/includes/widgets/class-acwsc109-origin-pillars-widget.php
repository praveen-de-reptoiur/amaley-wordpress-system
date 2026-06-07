<?php
/**
 * Amaley Origin Pillars widget.
 * Presentation-only. No posts, products, imports, media writes, or mappings are modified.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) {
    return;
}

final class ACWSC109_Origin_Pillars_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'acwsc109_origin_pillars'; }
    public function get_title() { return esc_html__( 'Amaley Origin Pillars', 'amaley-compact-widgets' ); }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return array( 'amaley-compact' ); }
    public function get_style_depends() { return array( 'acwsc-three-sections' ); }
    public function get_keywords() { return array( 'amaley', 'origin', 'pillars', 'where every product begins', 'cards' ); }

    protected function register_controls() {
        $this->content_controls();
        $this->card_controls();
        $this->layout_controls();
        $this->section_style_controls();
        $this->heading_style_controls();
        $this->card_style_controls();
        $this->image_style_controls();
    }

    private function default_cards() {
        return array(
            array( 'number' => '01.', 'title' => 'Himalayan Ingredients', 'description' => 'Seasonal produce sourced from mountain regions and local growers.', 'icon' => array( 'value' => 'fas fa-seedling', 'library' => 'fa-solid' ) ),
            array( 'number' => '02.', 'title' => 'Community Preparation', 'description' => 'Small-batch preparation by producer groups, SHGs and local makers.', 'icon' => array( 'value' => 'fas fa-mortar-pestle', 'library' => 'fa-solid' ) ),
            array( 'number' => '03.', 'title' => 'Honest Market Linkage', 'description' => 'Products are built to carry quality and a visible livelihood story.', 'icon' => array( 'value' => 'far fa-gem', 'library' => 'fa-regular' ) ),
        );
    }

    private function content_controls() {
        $this->start_controls_section( 'op_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_kicker', array( 'label' => esc_html__( 'Show Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'kicker', array( 'label' => esc_html__( 'Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'OUR ROOTS. OUR PEOPLE. OUR PROMISE.', 'condition' => array( 'show_kicker' => 'yes' ) ) );
        $this->add_control( 'show_title', array( 'label' => esc_html__( 'Show Heading', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Where Every Product Begins', 'condition' => array( 'show_title' => 'yes' ) ) );
        $this->add_control( 'accent_word', array( 'label' => esc_html__( 'Accent Word', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Product', 'condition' => array( 'show_title' => 'yes' ) ) );
        $this->add_control( 'show_divider', array( 'label' => esc_html__( 'Show Decorative Divider', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_description', array( 'label' => esc_html__( 'Show Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Before an Amaley product reaches a shelf, it begins in a place — with a crop, a community, and the women who prepare it with care.', 'condition' => array( 'show_description' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function card_controls() {
        $this->start_controls_section( 'op_cards', array( 'label' => esc_html__( 'Pillar Cards', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_cards', array( 'label' => esc_html__( 'Show Cards', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_card_images', array( 'label' => esc_html__( 'Show Card Images', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'show_cards' => 'yes' ) ) );
        $this->add_control( 'show_card_icons', array( 'label' => esc_html__( 'Show Icon Pill', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'show_cards' => 'yes' ) ) );
        $this->add_control( 'show_card_numbers', array( 'label' => esc_html__( 'Show Numbers', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'show_cards' => 'yes' ) ) );
        $this->add_control( 'show_card_descriptions', array( 'label' => esc_html__( 'Show Card Descriptions', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'show_cards' => 'yes' ) ) );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'image', array( 'label' => esc_html__( 'Card Image', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => array( 'url' => '' ) ) );
        $rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::ICONS, 'default' => array( 'value' => 'fas fa-seedling', 'library' => 'fa-solid' ) ) );
        $rep->add_control( 'number', array( 'label' => esc_html__( 'Number', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01.' ) );
        $rep->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Pillar Title' ) );
        $rep->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Short pillar explanation.' ) );
        $rep->add_control( 'show_this_description', array( 'label' => esc_html__( 'Show This Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'cards', array( 'label' => esc_html__( 'Cards', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}', 'default' => $this->default_cards(), 'condition' => array( 'show_cards' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function layout_controls() {
        $this->start_controls_section( 'op_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'text_position', array( 'label' => esc_html__( 'Text Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'left', 'options' => array( 'left' => 'Text Left / Cards Right', 'right' => 'Cards Left / Text Right' ), 'prefix_class' => 'acwsc-op--text-' ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .acwsc-op' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'inner_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 760, 'max' => 1640 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__inner' => 'max-width: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'columns_gap', array( 'label' => esc_html__( 'Text / Cards Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__grid' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'text_width', array( 'label' => esc_html__( 'Text Column Width %', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 20, 'max' => 55 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__grid' => '--acwsc-op-text: {{SIZE}}% !important;' ) ) );
        $this->add_responsive_control( 'card_columns', array( 'label' => esc_html__( 'Card Columns', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1'=>'1','2'=>'2','3'=>'3' ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__cards' => '--acwsc-op-card-cols: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__cards' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function section_style_controls() {
        $this->start_controls_section( 'op_style_section', array( 'label' => esc_html__( 'Section / Background', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op' => 'background: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function heading_style_controls() {
        $this->start_controls_section( 'op_style_heading', array( 'label' => esc_html__( 'Heading / Text', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__kicker' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .acwsc-op__kicker' ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__title em' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .acwsc-op__title' ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__desc' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .acwsc-op__desc' ) );
        $this->add_control( 'divider_color', array( 'label' => esc_html__( 'Divider Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__divider, {{WRAPPER}} .acwsc-op__divider:before, {{WRAPPER}} .acwsc-op__divider:after' => 'background: {{VALUE}} !important; border-color: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'title_bottom_gap', array( 'label' => esc_html__( 'Title Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__title' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function card_style_controls() {
        $this->start_controls_section( 'op_style_cards', array( 'label' => esc_html__( 'Cards', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__card' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'card_border', array( 'label' => esc_html__( 'Card Border', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__card' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__card' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .acwsc-op__card' ) );
        $this->add_control( 'card_hover_lift', array( 'label' => esc_html__( 'Hover Lift', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 18 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__card:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});' ) ) );
        $this->add_control( 'pill_bg', array( 'label' => esc_html__( 'Icon Pill Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__meta' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'pill_border', array( 'label' => esc_html__( 'Icon Pill Border', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__meta' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'pill_icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__icon, {{WRAPPER}} .acwsc-op__icon i, {{WRAPPER}} .acwsc-op__icon svg, {{WRAPPER}} .acwsc-op__icon svg *' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important; stroke: {{VALUE}} !important;' ) ) );
        $this->add_control( 'number_color', array( 'label' => esc_html__( 'Number Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__number' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__card-title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'selector' => '{{WRAPPER}} .acwsc-op__card-title' ) );
        $this->add_control( 'card_text_color', array( 'label' => esc_html__( 'Card Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-op__card-desc' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_text_typography', 'selector' => '{{WRAPPER}} .acwsc-op__card-desc' ) );
        $this->end_controls_section();
    }

    private function image_style_controls() {
        $this->start_controls_section( 'op_style_image', array( 'label' => esc_html__( 'Card Images', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 420 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__image' => 'height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__image' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'image_position', array( 'label' => esc_html__( 'Image Crop Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => array( 'center center'=>'Center Center','center top'=>'Center Top','center bottom'=>'Center Bottom','left center'=>'Left Center','right center'=>'Right Center' ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__image img' => 'object-position: {{VALUE}} !important;' ) ) );
        $this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover'=>'Cover','contain'=>'Contain','fill'=>'Fill' ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__image img' => 'object-fit: {{VALUE}} !important;' ) ) );
        $this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .acwsc-op__image img' => 'object-fit: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function yes( $v ) { return 'yes' === $v || '1' === (string) $v; }
    private function media_url( $raw ) { return is_array( $raw ) && isset( $raw['url'] ) ? (string) $raw['url'] : (string) $raw; }
    private function accent_title( $title, $accent ) {
        $title = esc_html( (string) $title );
        $accent = trim( (string) $accent );
        if ( '' === $accent ) { return $title; }
        $escaped = esc_html( $accent );
        $pos = stripos( $title, $escaped );
        if ( false === $pos ) { return $title; }
        return substr( $title, 0, $pos ) . '<em>' . substr( $title, $pos, strlen( $escaped ) ) . '</em>' . substr( $title, $pos + strlen( $escaped ) );
    }
    private function render_icon( $icon ) {
        if ( ! empty( $icon['value'] ) && class_exists( '\\Elementor\\Icons_Manager' ) ) {
            ob_start(); \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); return ob_get_clean();
        }
        return '<span aria-hidden="true">✦</span>';
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        if ( ! $this->yes( $s['show_section'] ?? 'yes' ) ) { return; }
        $cards = is_array( $s['cards'] ?? null ) ? $s['cards'] : $this->default_cards();
        ?>
        <section class="acwsc-op">
            <div class="acwsc-op__inner">
                <div class="acwsc-op__grid">
                    <div class="acwsc-op__copy">
                        <?php if ( $this->yes( $s['show_kicker'] ?? 'yes' ) && ! empty( $s['kicker'] ) ) : ?><p class="acwsc-op__kicker"><?php echo esc_html( $s['kicker'] ); ?></p><?php endif; ?>
                        <?php if ( $this->yes( $s['show_title'] ?? 'yes' ) && ! empty( $s['title'] ) ) : ?><h2 class="acwsc-op__title"><?php echo $this->accent_title( $s['title'], $s['accent_word'] ?? '' ); ?></h2><?php endif; ?>
                        <?php if ( $this->yes( $s['show_divider'] ?? 'yes' ) ) : ?><span class="acwsc-op__divider" aria-hidden="true"></span><?php endif; ?>
                        <?php if ( $this->yes( $s['show_description'] ?? 'yes' ) && ! empty( $s['description'] ) ) : ?><p class="acwsc-op__desc"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
                    </div>
                    <?php if ( $this->yes( $s['show_cards'] ?? 'yes' ) ) : ?>
                    <div class="acwsc-op__cards">
                        <?php foreach ( $cards as $index => $card ) : $img = $this->media_url( $card['image'] ?? '' ); ?>
                            <article class="acwsc-op__card">
                                <?php if ( $this->yes( $s['show_card_images'] ?? 'yes' ) ) : ?>
                                    <figure class="acwsc-op__image">
                                        <?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $card['title'] ?? 'Amaley origin visual' ); ?>" loading="lazy"><?php else : ?><span class="acwsc-op__placeholder acwsc-op__placeholder--<?php echo esc_attr( ( $index % 3 ) + 1 ); ?>"></span><?php endif; ?>
                                    </figure>
                                <?php endif; ?>
                                <div class="acwsc-op__body">
                                    <div class="acwsc-op__meta">
                                        <?php if ( $this->yes( $s['show_card_icons'] ?? 'yes' ) ) : ?><span class="acwsc-op__icon"><?php echo $this->render_icon( $card['icon'] ?? array() ); ?></span><?php endif; ?>
                                        <?php if ( $this->yes( $s['show_card_numbers'] ?? 'yes' ) ) : ?><span class="acwsc-op__number"><?php echo esc_html( $card['number'] ?? '' ); ?></span><?php endif; ?>
                                    </div>
                                    <?php if ( ! empty( $card['title'] ) ) : ?><h3 class="acwsc-op__card-title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?>
                                    <?php if ( $this->yes( $s['show_card_descriptions'] ?? 'yes' ) && $this->yes( $card['show_this_description'] ?? 'yes' ) && ! empty( $card['description'] ) ) : ?><p class="acwsc-op__card-desc"><?php echo esc_html( $card['description'] ); ?></p><?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
