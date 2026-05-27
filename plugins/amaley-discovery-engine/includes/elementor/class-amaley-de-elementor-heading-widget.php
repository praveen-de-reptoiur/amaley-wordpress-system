<?php
/**
 * Amaley Section Heading Elementor widget.
 *
 * A reusable heading system for Amaley pages so headings do not need to be
 * recreated manually on every page/section.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

class Amaley_DE_Elementor_Heading_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'amaley_section_heading';
    }

    public function get_title() {
        return __('Amaley Section Heading', 'amaley-discovery-engine');
    }

    public function get_icon() {
        return 'eicon-heading';
    }

    public function get_categories() {
        return array('amaley-discovery-engine');
    }

    public function get_keywords() {
        return array('amaley', 'heading', 'section heading', 'title', 'kicker', 'editorial');
    }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section('ade_heading_content', array(
            'label' => __('Heading Content', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ));

        $this->add_control('kicker', array(
            'label'       => __('Small Label / Kicker', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __('Explore by Curation', 'amaley-discovery-engine'),
            'label_block' => true,
        ));

        $this->add_control('heading', array(
            'label'       => __('Main Heading', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => __('Our {Collections}', 'amaley-discovery-engine'),
            'description' => __('Use {word} for the rust italic accent. Example: Our {Collections}', 'amaley-discovery-engine'),
            'label_block' => true,
        ));

        $this->add_control('description', array(
            'label'       => __('Optional Description', 'amaley-discovery-engine'),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => '',
            'label_block' => true,
        ));

        $this->add_control('heading_tag', array(
            'label'   => __('Heading HTML Tag', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'h2',
            'options' => array(
                'h1'  => 'H1',
                'h2'  => 'H2',
                'h3'  => 'H3',
                'h4'  => 'H4',
                'div' => 'DIV',
            ),
        ));

        $this->add_control('show_kicker', array(
            'label'        => __('Show Kicker', 'amaley-discovery-engine'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'amaley-discovery-engine'),
            'label_off'    => __('No', 'amaley-discovery-engine'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ));

        $this->add_control('show_description', array(
            'label'        => __('Show Description', 'amaley-discovery-engine'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'amaley-discovery-engine'),
            'label_off'    => __('No', 'amaley-discovery-engine'),
            'return_value' => 'yes',
            'default'      => '',
        ));

        $this->end_controls_section();
    }

    private function register_style_controls() {
        $this->start_controls_section('ade_heading_wrapper_style', array(
            'label' => __('Wrapper / Spacing Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_responsive_control('alignment', array(
            'label'   => __('Alignment', 'amaley-discovery-engine'),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array('title' => __('Left', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-left'),
                'center' => array('title' => __('Center', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-center'),
                'right' => array('title' => __('Right', 'amaley-discovery-engine'), 'icon' => 'eicon-text-align-right'),
            ),
            'default' => 'center',
            'selectors' => array(
                '{{WRAPPER}} .amaley-section-heading-v1' => 'text-align: {{VALUE}};',
            ),
        ));

        $this->add_responsive_control('max_width', array(
            'label' => __('Max Width', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px', '%'),
            'range' => array(
                'px' => array('min' => 220, 'max' => 1400),
                '%'  => array('min' => 20, 'max' => 100),
            ),
            'default' => array('size' => 900, 'unit' => 'px'),
            'selectors' => array(
                '{{WRAPPER}} .amaley-section-heading-v1__inner' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
        ));

        $this->add_responsive_control('wrapper_margin', array(
            'label' => __('Wrapper Margin', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'selectors' => array(
                '{{WRAPPER}} .amaley-section-heading-v1' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ));

        $this->add_responsive_control('wrapper_padding', array(
            'label' => __('Wrapper Padding', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array('px'),
            'default' => array(
                'top' => '0',
                'right' => '16',
                'bottom' => '0',
                'left' => '16',
                'unit' => 'px',
                'isLinked' => false,
            ),
            'tablet_default' => array(
                'top' => '0',
                'right' => '14',
                'bottom' => '0',
                'left' => '14',
                'unit' => 'px',
                'isLinked' => false,
            ),
            'mobile_default' => array(
                'top' => '0',
                'right' => '12',
                'bottom' => '0',
                'left' => '12',
                'unit' => 'px',
                'isLinked' => false,
            ),
            'selectors' => array(
                '{{WRAPPER}} .amaley-section-heading-v1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
        ));

        $this->add_control('background_color', array(
            'label' => __('Background Color', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'selectors' => array(
                '{{WRAPPER}} .amaley-section-heading-v1' => 'background-color: {{VALUE}};',
            ),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_kicker_style', array(
            'label' => __('Kicker / Small Label Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('kicker_color', array(
            'label' => __('Kicker Color', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#C2880A',
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__kicker' => 'color: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'kicker_typography',
            'label' => __('Kicker Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-section-heading-v1__kicker',
            'fields_options' => array(
                'typography' => array('default' => 'custom'),
                'font_family' => array('default' => 'Lato'),
                'font_size' => array(
                    'default' => array('unit' => 'px', 'size' => 11),
                    'tablet_default' => array('unit' => 'px', 'size' => 10),
                    'mobile_default' => array('unit' => 'px', 'size' => 9),
                ),
                'font_weight' => array('default' => '900'),
                'text_transform' => array('default' => 'uppercase'),
                'line_height' => array('default' => array('unit' => 'em', 'size' => 1.2)),
                'letter_spacing' => array(
                    'default' => array('unit' => 'em', 'size' => 0.34),
                    'tablet_default' => array('unit' => 'em', 'size' => 0.28),
                    'mobile_default' => array('unit' => 'em', 'size' => 0.22),
                ),
            ),
        ));

        $this->add_responsive_control('kicker_bottom_spacing', array(
            'label' => __('Kicker Bottom Spacing', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px' => array('min' => 0, 'max' => 80)),
            'default' => array('size' => 14, 'unit' => 'px'),
            'tablet_default' => array('size' => 12, 'unit' => 'px'),
            'mobile_default' => array('size' => 10, 'unit' => 'px'),
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};'),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_main_heading_style', array(
            'label' => __('Main Heading Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('heading_color', array(
            'label' => __('Heading Color', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#2E1203',
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__title' => 'color: {{VALUE}};'),
        ));

        $this->add_control('accent_color', array(
            'label' => __('Accent Word Color', 'amaley-discovery-engine'),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#B5502A',
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__accent' => 'color: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'heading_typography',
            'label' => __('Heading Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-section-heading-v1__title',
            'fields_options' => array(
                'typography' => array('default' => 'custom'),
                'font_family' => array('default' => 'Playfair Display'),
                'font_size' => array(
                    'default' => array('unit' => 'px', 'size' => 52),
                    'tablet_default' => array('unit' => 'px', 'size' => 45),
                    'mobile_default' => array('unit' => 'px', 'size' => 34),
                ),
                'font_weight' => array('default' => '500'),
                'line_height' => array(
                    'default' => array('unit' => 'em', 'size' => 1.05),
                    'tablet_default' => array('unit' => 'em', 'size' => 1.08),
                    'mobile_default' => array('unit' => 'em', 'size' => 1.08),
                ),
                'letter_spacing' => array('default' => array('unit' => 'px', 'size' => 0)),
            ),
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'accent_typography',
            'label' => __('Accent Word Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-section-heading-v1__accent',
            'fields_options' => array(
                'typography' => array('default' => 'custom'),
                'font_family' => array('default' => 'Playfair Display'),
                'font_size' => array(
                    'default' => array('unit' => 'px', 'size' => 52),
                    'tablet_default' => array('unit' => 'px', 'size' => 45),
                    'mobile_default' => array('unit' => 'px', 'size' => 34),
                ),
                'font_weight' => array('default' => '500'),
                'font_style' => array('default' => 'italic'),
                'line_height' => array(
                    'default' => array('unit' => 'em', 'size' => 1.05),
                    'tablet_default' => array('unit' => 'em', 'size' => 1.08),
                    'mobile_default' => array('unit' => 'em', 'size' => 1.08),
                ),
            ),
        ));

        $this->add_responsive_control('heading_size', array(
            'label' => __('Quick Heading Size', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px' => array('min' => 24, 'max' => 120)),
            'default' => array('size' => 52, 'unit' => 'px'),
            'tablet_default' => array('size' => 45, 'unit' => 'px'),
            'mobile_default' => array('size' => 34, 'unit' => 'px'),
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__title' => 'font-size: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_responsive_control('heading_line_height', array(
            'label' => __('Quick Line Height', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('em'),
            'range' => array('em' => array('min' => 0.8, 'max' => 1.6, 'step' => 0.01)),
            'default' => array('size' => 1.05, 'unit' => 'em'),
            'tablet_default' => array('size' => 1.08, 'unit' => 'em'),
            'mobile_default' => array('size' => 1.08, 'unit' => 'em'),
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__title' => 'line-height: {{SIZE}}{{UNIT}};'),
        ));

        $this->add_responsive_control('heading_bottom_spacing', array(
            'label' => __('Heading Bottom Spacing', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px'),
            'range' => array('px' => array('min' => 0, 'max' => 100)),
            'default' => array('size' => 0, 'unit' => 'px'),
            'tablet_default' => array('size' => 0, 'unit' => 'px'),
            'mobile_default' => array('size' => 0, 'unit' => 'px'),
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__title' => 'margin-bottom: {{SIZE}}{{UNIT}};'),
        ));

        $this->end_controls_section();

        $this->start_controls_section('ade_description_style', array(
            'label' => __('Description Style', 'amaley-discovery-engine'),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ));

        $this->add_control('description_color', array(
            'label' => __('Description Color', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(74, 34, 8, 0.78)',
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__description' => 'color: {{VALUE}};'),
        ));

        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array(
            'name' => 'description_typography',
            'label' => __('Description Typography', 'amaley-discovery-engine'),
            'selector' => '{{WRAPPER}} .amaley-section-heading-v1__description',
            'fields_options' => array(
                'typography' => array('default' => 'custom'),
                'font_family' => array('default' => 'Lato'),
                'font_size' => array(
                    'default' => array('unit' => 'px', 'size' => 15),
                    'tablet_default' => array('unit' => 'px', 'size' => 14),
                    'mobile_default' => array('unit' => 'px', 'size' => 13.5),
                ),
                'font_weight' => array('default' => '400'),
                'line_height' => array(
                    'default' => array('unit' => 'em', 'size' => 1.65),
                    'mobile_default' => array('unit' => 'em', 'size' => 1.58),
                ),
            ),
        ));

        $this->add_responsive_control('description_max_width', array(
            'label' => __('Description Max Width', 'amaley-discovery-engine'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array('px', '%'),
            'range' => array('px' => array('min' => 260, 'max' => 1000), '%' => array('min' => 20, 'max' => 100)),
            'default' => array('size' => 620, 'unit' => 'px'),
            'selectors' => array('{{WRAPPER}} .amaley-section-heading-v1__description' => 'max-width: {{SIZE}}{{UNIT}};'),
        ));

        $this->end_controls_section();
    }

    private function render_accent_heading($heading) {
        $heading = (string) $heading;
        $parts = preg_split('/(\{[^}]+\})/', $heading, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $html = '';
        foreach ($parts as $part) {
            if (preg_match('/^\{([^}]+)\}$/', $part, $matches)) {
                $html .= '<span class="amaley-section-heading-v1__accent">' . esc_html($matches[1]) . '</span>';
            } else {
                $html .= esc_html($part);
            }
        }
        return $html;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $tag = isset($settings['heading_tag']) ? $settings['heading_tag'] : 'h2';
        $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'div');
        if (!in_array($tag, $allowed_tags, true)) {
            $tag = 'h2';
        }

        $kicker = isset($settings['kicker']) ? $settings['kicker'] : '';
        $heading = isset($settings['heading']) ? $settings['heading'] : '';
        $description = isset($settings['description']) ? $settings['description'] : '';
        ?>
        <div class="amaley-section-heading-v1" aria-label="Amaley section heading">
            <div class="amaley-section-heading-v1__inner">
                <?php if ('yes' === ($settings['show_kicker'] ?? 'yes') && '' !== trim($kicker)) : ?>
                    <div class="amaley-section-heading-v1__kicker"><?php echo esc_html($kicker); ?></div>
                <?php endif; ?>

                <<?php echo esc_attr($tag); ?> class="amaley-section-heading-v1__title">
                    <?php echo $this->render_accent_heading($heading); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </<?php echo esc_attr($tag); ?>>

                <?php if ('yes' === ($settings['show_description'] ?? '') && '' !== trim($description)) : ?>
                    <div class="amaley-section-heading-v1__description"><?php echo esc_html($description); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
