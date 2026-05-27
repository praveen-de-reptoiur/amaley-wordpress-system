<?php
/**
 * Amaley Icon List Elementor widget.
 *
 * A scoped replacement for unreliable generic Icon List widgets, designed for
 * Amaley editorial feature cards and compact icon lists.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

class Amaley_DE_Elementor_Icon_List_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'amaley_icon_list';
    }

    public function get_title() {
        return __('Amaley Icon List', 'amaley-discovery-engine');
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return array('amaley-discovery-engine');
    }

    public function get_keywords() {
        return array('amaley', 'icon', 'list', 'feature', 'cards', 'editorial');
    }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section('ade_icon_list_content', array(
            'label' => __('Icon List Items', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('item_icon', array(
            'label' => __('Icon', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => array('value' => 'fas fa-seedling', 'library' => 'fa-solid'),
        ));
        $repeater->add_control('item_title', array(
            'label' => __('Title', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Rooted Himalayan Ingredients', 'amaley-discovery-engine'),
            'label_block' => true,
        ));
        $repeater->add_control('item_text', array(
            'label' => __('Description', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __('Seasonal, local, and traditional. No artificial shortcuts.', 'amaley-discovery-engine'),
            'rows' => 3,
            'label_block' => true,
        ));
        $repeater->add_control('item_link', array(
            'label' => __('Optional Link', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'amaley-discovery-engine'),
        ));

        $this->add_control('items', array(
            'label' => __('Items', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => array(
                array('item_title' => __('Not Anonymous Sourcing', 'amaley-discovery-engine'), 'item_text' => __('Every product maps to a named cluster, SHG, and producer.', 'amaley-discovery-engine'), 'item_icon' => array('value' => 'fas fa-map', 'library' => 'fa-solid')),
                array('item_title' => __('Women-led, Not Charity-led', 'amaley-discovery-engine'), 'item_text' => __('Dignity through enterprise, not token representation.', 'amaley-discovery-engine'), 'item_icon' => array('value' => 'fas fa-users', 'library' => 'fa-solid')),
                array('item_title' => __('Rooted Himalayan Ingredients', 'amaley-discovery-engine'), 'item_text' => __('Seasonal, local, and traditional. No artificial shortcuts.', 'amaley-discovery-engine'), 'item_icon' => array('value' => 'fas fa-leaf', 'library' => 'fa-solid')),
            ),
            'title_field' => '{{{ item_title }}}',
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_icon_list_layout', array(
            'label' => __('Layout', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $this->add_control('layout_style', array(
            'label' => __('Layout Style', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'cards',
            'options' => array(
                'cards' => __('Feature Cards', 'amaley-discovery-engine'),
                'compact' => __('Compact List', 'amaley-discovery-engine'),
            ),
        ));

        $this->add_responsive_control('columns', array(
            'label' => __('Columns', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '1',
            'tablet_default' => '1',
            'mobile_default' => '1',
            'options' => array('1' => '1', '2' => '2', '3' => '3'),
            'selectors' => array(
                '{{WRAPPER}} .amaley-icon-list-v1__items' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
            ),
        ));

        $this->end_controls_section();
    }

    private function register_style_controls() {
        $this->start_controls_section('ade_icon_list_wrapper_style', array(
            'label' => __('Wrapper / Spacing Style', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_responsive_control('gap', array(
            'label' => __('Item Gap', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px' => array('min' => 0, 'max' => 60)),
            'default' => array('size' => 16, 'unit' => 'px'),
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__items' => 'gap: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_responsive_control('wrapper_padding', array(
            'label' => __('Wrapper Padding', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_icon_list_card_style', array(
            'label' => __('Card / Item Style', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('card_background', array(
            'label' => __('Background Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255, 248, 234, 0.70)',
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__item' => 'background: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .amaley-icon-list-v1__item',
            'fields_options' => array(
                'border' => array('default' => 'solid'),
                'width' => array('default' => array('top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'unit' => 'px', 'isLinked' => true)),
                'color' => array('default' => 'rgba(194, 136, 10, 0.32)'),
            ),
        ));

        $this->add_responsive_control('card_radius', array(
            'label' => __('Border Radius', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'default' => array('top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true),
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));

        $this->add_responsive_control('card_padding', array(
            'label' => __('Card Padding', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'default' => array('top' => '20', 'right' => '22', 'bottom' => '20', 'left' => '22', 'unit' => 'px', 'isLinked' => false),
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_icon_style', array(
            'label' => __('Icon Style', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('icon_color', array(
            'label' => __('Icon Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#C2880A',
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__icon' => 'color: {{VALUE}};'),
        ));

        $this->add_responsive_control('icon_size', array(
            'label' => __('Icon Size', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px' => array('min' => 10, 'max' => 80)),
            'default' => array('size' => 32, 'unit' => 'px'),
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__icon' => 'font-size: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_responsive_control('icon_box_width', array(
            'label' => __('Icon Column Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px' => array('min' => 24, 'max' => 100)),
            'default' => array('size' => 44, 'unit' => 'px'),
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__icon-wrap' => 'flex-basis: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};'),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_icon_text_style', array(
            'label' => __('Text Style', 'amaley-discovery-engine'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('title_color', array(
            'label' => __('Title Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#2E1203',
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__title' => 'color: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'title_typography',
            'label' => __('Title Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-icon-list-v1__title',
            'fields_options' => array(
                'typography' => array('default' => 'custom'),
                'font_family' => array('default' => 'Playfair Display'),
                'font_size' => array('default' => array('unit' => 'px', 'size' => 22), 'mobile_default' => array('unit' => 'px', 'size' => 18)),
                'font_weight' => array('default' => '600'),
                'line_height' => array('default' => array('unit' => 'em', 'size' => 1.2)),
            ),
        ));

        $this->add_control('text_color', array(
            'label' => __('Description Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#4A2208',
            'selectors' => array('{{WRAPPER}} .amaley-icon-list-v1__text' => 'color: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'text_typography',
            'label' => __('Description Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-icon-list-v1__text',
            'fields_options' => array(
                'typography' => array('default' => 'custom'),
                'font_family' => array('default' => 'Lato'),
                'font_size' => array('default' => array('unit' => 'px', 'size' => 14), 'mobile_default' => array('unit' => 'px', 'size' => 13)),
                'font_weight' => array('default' => '400'),
                'line_height' => array('default' => array('unit' => 'em', 'size' => 1.6)),
            ),
        ));

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = isset($settings['items']) && is_array($settings['items']) ? $settings['items'] : array();
        $layout_style = isset($settings['layout_style']) ? $settings['layout_style'] : 'cards';
        ?>
        <div class="amaley-icon-list-v1 amaley-icon-list-v1--<?php echo esc_attr($layout_style); ?>" aria-label="Amaley icon list">
            <div class="amaley-icon-list-v1__items">
                <?php foreach ($items as $item) :
                    $title = isset($item['item_title']) ? $item['item_title'] : '';
                    $text = isset($item['item_text']) ? $item['item_text'] : '';
                    $link = isset($item['item_link']['url']) ? $item['item_link']['url'] : '';
                    $tag_open = $link ? '<a class="amaley-icon-list-v1__item" href="' . esc_url($link) . '">' : '<div class="amaley-icon-list-v1__item">';
                    $tag_close = $link ? '</a>' : '</div>';
                    echo $tag_open; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    ?>
                        <div class="amaley-icon-list-v1__icon-wrap">
                            <span class="amaley-icon-list-v1__icon" aria-hidden="true">
                                <?php \Elementor\Icons_Manager::render_icon($item['item_icon'], array('aria-hidden' => 'true')); ?>
                            </span>
                        </div>
                        <div class="amaley-icon-list-v1__content">
                            <?php if ('' !== trim($title)) : ?><div class="amaley-icon-list-v1__title"><?php echo esc_html($title); ?></div><?php endif; ?>
                            <?php if ('' !== trim($text)) : ?><div class="amaley-icon-list-v1__text"><?php echo esc_html($text); ?></div><?php endif; ?>
                        </div>
                    <?php
                    echo $tag_close; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                endforeach; ?>
            </div>
        </div>
        <?php
    }
}
