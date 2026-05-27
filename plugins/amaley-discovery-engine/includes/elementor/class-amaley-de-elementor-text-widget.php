<?php
/**
 * Amaley Editorial Text Elementor widget.
 *
 * A safe replacement for unreliable theme Text Editor/Description widgets.
 * It renders scoped, controlled paragraph content with Amaley defaults.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

class Amaley_DE_Elementor_Text_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'amaley_editorial_text';
    }

    public function get_title() {
        return __('Amaley Editorial Text', 'amaley-discovery-engine');
    }

    public function get_icon() {
        return 'eicon-text-area';
    }

    public function get_categories() {
        return array('amaley-discovery-engine');
    }

    public function get_keywords() {
        return array('amaley', 'paragraph', 'description', 'text', 'editorial', 'body');
    }

    protected function register_controls() {
        $this->start_controls_section('ade_text_content', array(
            'label' => __('Text Content', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $this->add_control('content', array(
            'label'       => __('Paragraph / Description Text', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 7,
            'default'     => __('Amaley is not just a food brand. It is a living architecture of women-led producer groups, local ingredients, and sustained market pathways.', 'amaley-discovery-engine'),
            'label_block' => true,
        ));

        $this->add_control('allow_basic_formatting', array(
            'label'        => __('Allow Basic Formatting', 'amaley-discovery-engine'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'amaley-discovery-engine'),
            'label_off'    => __('No', 'amaley-discovery-engine'),
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => __('Allows basic tags like strong, em, br, and links. Keeps output safer than the theme Text Editor.', 'amaley-discovery-engine'),
        ));

        $this->add_control('html_tag', array(
            'label'   => __('HTML Tag', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'p',
            'options' => array(
                'p'   => 'P',
                'div' => 'DIV',
            ),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_text_wrapper_style', array(
            'label' => __('Wrapper / Spacing Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_responsive_control('alignment', array(
            'label'   => __('Alignment', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left'   => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-left'),
                'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-center'),
                'right'  => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-right'),
            ),
            'default'   => 'left',
            'selectors' => array(
                '{{WRAPPER}} .amaley-editorial-text-v1' => 'text-align: {{VALUE}};',
            ),
        ));

        $this->add_responsive_control('max_width', array(
            'label' => __('Max Width', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px', '%'),
            'range' => array(
                'px' => array('min' => 240, 'max' => 1200),
                '%'  => array('min' => 20, 'max' => 100),
            ),
            'default' => array('size' => 760, 'unit' => 'px'),
            'selectors' => array(
                '{{WRAPPER}} .amaley-editorial-text-v1__inner' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ));

        $this->add_responsive_control('wrapper_padding', array(
            'label' => __('Wrapper Padding', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'default' => array('top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false),
            'selectors' => array(
                '{{WRAPPER}} .amaley-editorial-text-v1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ));

        $this->add_control('background_color', array(
            'label' => __('Background Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => array('{{WRAPPER}} .amaley-editorial-text-v1__inner' => 'background-color: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array(
            'name' => 'wrapper_border',
            'selector' => '{{WRAPPER}} .amaley-editorial-text-v1__inner',
        ));

        $this->add_responsive_control('border_radius', array(
            'label' => __('Border Radius', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors' => array(
                '{{WRAPPER}} .amaley-editorial-text-v1__inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_text_typography_style', array(
            'label' => __('Text Typography Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('text_color', array(
            'label' => __('Text Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#4A2208',
            'selectors' => array('{{WRAPPER}} .amaley-editorial-text-v1__content' => 'color: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'text_typography',
            'label' => __('Text Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-editorial-text-v1__content',
            'fields_options' => array(
                'typography' => array('default' => 'custom'),
                'font_family' => array('default' => 'Lato'),
                'font_size' => array(
                    'default' => array('unit' => 'px', 'size' => 16),
                    'tablet_default' => array('unit' => 'px', 'size' => 15),
                    'mobile_default' => array('unit' => 'px', 'size' => 14),
                ),
                'font_weight' => array('default' => '400'),
                'line_height' => array(
                    'default' => array('unit' => 'em', 'size' => 1.75),
                    'mobile_default' => array('unit' => 'em', 'size' => 1.65),
                ),
            ),
        ));

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $content = isset($settings['content']) ? $settings['content'] : '';
        $tag = isset($settings['html_tag']) && 'div' === $settings['html_tag'] ? 'div' : 'p';
        $allowed = array(
            'strong' => array(),
            'b' => array(),
            'em' => array(),
            'i' => array(),
            'br' => array(),
            'a' => array('href' => array(), 'target' => array(), 'rel' => array()),
        );
        $output = ('yes' === ($settings['allow_basic_formatting'] ?? 'yes')) ? wp_kses($content, $allowed) : esc_html($content);
        ?>
        <div class="amaley-editorial-text-v1" aria-label="Amaley editorial text">
            <div class="amaley-editorial-text-v1__inner">
                <<?php echo esc_attr($tag); ?> class="amaley-editorial-text-v1__content"><?php echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></<?php echo esc_attr($tag); ?>>
            </div>
        </div>
        <?php
    }
}
