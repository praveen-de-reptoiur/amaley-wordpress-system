<?php
/**
 * Amaley Livelihood Chain Band widget.
 * Presentation-only. No data mutation.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) {
    return;
}

final class ACWSC109_Livelihood_Chain_Band_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'acwsc109_livelihood_chain_band'; }
    public function get_title() { return esc_html__( 'Amaley Livelihood Chain Band', 'amaley-compact-widgets' ); }
    public function get_icon() { return 'eicon-heart-o'; }
    public function get_categories() { return array( 'amaley-compact' ); }
    public function get_style_depends() { return array( 'acwsc-three-sections' ); }
    public function get_keywords() { return array( 'amaley', 'livelihood', 'chain', 'dark', 'band', 'statement' ); }

    protected function register_controls() {
        $this->content_controls();
        $this->items_controls();
        $this->layout_controls();
        $this->band_style_controls();
        $this->heading_style_controls();
        $this->item_style_controls();
    }

    private function default_items() {
        return array(
            array( 'title' => 'Ingredients', 'description' => 'Rooted in Himalayan produce.', 'icon' => array( 'value' => 'fas fa-seedling', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Producers', 'description' => 'Prepared by community makers.', 'icon' => array( 'value' => 'fas fa-users', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Small Batches', 'description' => 'Made with careful discipline.', 'icon' => array( 'value' => 'fas fa-jar', 'library' => 'fa-solid' ) ),
            array( 'title' => 'Fair Markets', 'description' => 'Connected to conscious buyers.', 'icon' => array( 'value' => 'fas fa-shopping-bag', 'library' => 'fa-solid' ) ),
        );
    }

    private function content_controls() {
        $this->start_controls_section( 'lc_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_kicker', array( 'label' => esc_html__( 'Show Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ) );
        $this->add_control( 'kicker', array( 'label' => esc_html__( 'Kicker', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'VISIBLE VALUE CHAIN', 'condition' => array( 'show_kicker' => 'yes' ) ) );
        $this->add_control( 'heading', array( 'label' => esc_html__( 'Heading', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Not Just Food. A Livelihood Chain.' ) );
        $this->add_control( 'accent_phrase', array( 'label' => esc_html__( 'Accent Phrase', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'A Livelihood Chain.' ) );
        $this->add_control( 'show_decor', array( 'label' => esc_html__( 'Show Decorative Star / Line', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_description', array( 'label' => esc_html__( 'Show Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Every Amaley product connects ingredients, producer groups, village skills and conscious buyers through a visible value chain.', 'condition' => array( 'show_description' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function items_controls() {
        $this->start_controls_section( 'lc_items', array( 'label' => esc_html__( 'Chain Items', 'amaley-compact-widgets' ) ) );
        $this->add_control( 'show_items', array( 'label' => esc_html__( 'Show Items', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_icons', array( 'label' => esc_html__( 'Show Icons', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'show_items' => 'yes' ) ) );
        $this->add_control( 'show_item_descriptions', array( 'label' => esc_html__( 'Show Item Descriptions', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '', 'condition' => array( 'show_items' => 'yes' ) ) );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::ICONS, 'default' => array( 'value' => 'fas fa-leaf', 'library' => 'fa-solid' ) ) );
        $rep->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Item Title' ) );
        $rep->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Short item description.' ) );
        $this->add_control( 'items', array( 'label' => esc_html__( 'Items', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(), 'title_field' => '{{{ title }}}', 'default' => $this->default_items(), 'condition' => array( 'show_items' => 'yes' ) ) );
        $this->end_controls_section();
    }

    private function layout_controls() {
        $this->start_controls_section( 'lc_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .acwsc-lc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'inner_max_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 760, 'max' => 1640 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-lc__inner' => 'max-width: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'content_gap', array( 'label' => esc_html__( 'Content / Items Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-lc__inner' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'item_columns', array( 'label' => esc_html__( 'Item Columns', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'tablet_default' => '4', 'mobile_default' => '2', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ), 'selectors' => array( '{{WRAPPER}} .acwsc-lc__items' => '--acwsc-lc-cols: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'item_gap', array( 'label' => esc_html__( 'Item Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-lc__items' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'text_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right') ), 'selectors' => array( '{{WRAPPER}} .acwsc-lc__copy' => 'text-align: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function band_style_controls() {
        $this->start_controls_section( 'lc_band_style', array( 'label' => esc_html__( 'Band / Background', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'band_bg', array( 'label' => esc_html__( 'Band Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'band_border', array( 'label' => esc_html__( 'Band Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function heading_style_controls() {
        $this->start_controls_section( 'lc_heading_style', array( 'label' => esc_html__( 'Heading / Text', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__kicker' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .acwsc-lc__kicker' ) );
        $this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__title em' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .acwsc-lc__title' ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__desc' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .acwsc-lc__desc' ) );
        $this->add_control( 'decor_color', array( 'label' => esc_html__( 'Decor Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__decor, {{WRAPPER}} .acwsc-lc__decor:before, {{WRAPPER}} .acwsc-lc__decor:after' => 'background: {{VALUE}} !important; color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();
    }

    private function item_style_controls() {
        $this->start_controls_section( 'lc_item_style', array( 'label' => esc_html__( 'Icon Items', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'divider_color', array( 'label' => esc_html__( 'Divider Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__item' => 'border-left-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'icon_circle_bg', array( 'label' => esc_html__( 'Icon Circle Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__icon' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'icon_circle_border', array( 'label' => esc_html__( 'Icon Circle Border', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__icon' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__icon, {{WRAPPER}} .acwsc-lc__icon i, {{WRAPPER}} .acwsc-lc__icon svg, {{WRAPPER}} .acwsc-lc__icon svg *' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important; stroke: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'icon_size', array( 'label' => esc_html__( 'Icon Size', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 26, 'max' => 110 ) ), 'selectors' => array( '{{WRAPPER}} .acwsc-lc__icon' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'item_title_color', array( 'label' => esc_html__( 'Item Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__item-title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'item_title_typography', 'selector' => '{{WRAPPER}} .acwsc-lc__item-title' ) );
        $this->add_control( 'item_text_color', array( 'label' => esc_html__( 'Item Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .acwsc-lc__item-desc' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'item_text_typography', 'selector' => '{{WRAPPER}} .acwsc-lc__item-desc' ) );
        $this->end_controls_section();
    }

    private function yes( $v ) { return 'yes' === $v || '1' === (string) $v; }
    private function accent_title( $title, $accent ) {
        $title = esc_html( (string) $title ); $accent = trim( (string) $accent );
        if ( '' === $accent ) { return $title; }
        $escaped = esc_html( $accent ); $pos = stripos( $title, $escaped );
        return false === $pos ? $title : substr( $title, 0, $pos ) . '<em>' . substr( $title, $pos, strlen( $escaped ) ) . '</em>' . substr( $title, $pos + strlen( $escaped ) );
    }
    private function render_icon( $icon ) {
        if ( ! empty( $icon['value'] ) && class_exists( '\\Elementor\\Icons_Manager' ) ) { ob_start(); \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); return ob_get_clean(); }
        return '<span aria-hidden="true">✦</span>';
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        if ( ! $this->yes( $s['show_section'] ?? 'yes' ) ) { return; }
        $items = is_array( $s['items'] ?? null ) ? $s['items'] : $this->default_items();
        ?>
        <section class="acwsc-lc">
            <div class="acwsc-lc__inner">
                <div class="acwsc-lc__copy">
                    <?php if ( $this->yes( $s['show_kicker'] ?? '' ) && ! empty( $s['kicker'] ) ) : ?><p class="acwsc-lc__kicker"><?php echo esc_html( $s['kicker'] ); ?></p><?php endif; ?>
                    <h2 class="acwsc-lc__title"><?php echo $this->accent_title( $s['heading'] ?? '', $s['accent_phrase'] ?? '' ); ?></h2>
                    <?php if ( $this->yes( $s['show_decor'] ?? 'yes' ) ) : ?><span class="acwsc-lc__decor" aria-hidden="true">✦</span><?php endif; ?>
                    <?php if ( $this->yes( $s['show_description'] ?? 'yes' ) && ! empty( $s['description'] ) ) : ?><p class="acwsc-lc__desc"><?php echo esc_html( $s['description'] ); ?></p><?php endif; ?>
                </div>
                <?php if ( $this->yes( $s['show_items'] ?? 'yes' ) ) : ?>
                <div class="acwsc-lc__items">
                    <?php foreach ( $items as $item ) : ?>
                        <div class="acwsc-lc__item">
                            <?php if ( $this->yes( $s['show_icons'] ?? 'yes' ) ) : ?><span class="acwsc-lc__icon"><?php echo $this->render_icon( $item['icon'] ?? array() ); ?></span><?php endif; ?>
                            <strong class="acwsc-lc__item-title"><?php echo esc_html( $item['title'] ?? '' ); ?></strong>
                            <?php if ( $this->yes( $s['show_item_descriptions'] ?? '' ) && ! empty( $item['description'] ) ) : ?><span class="acwsc-lc__item-desc"><?php echo esc_html( $item['description'] ); ?></span><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
