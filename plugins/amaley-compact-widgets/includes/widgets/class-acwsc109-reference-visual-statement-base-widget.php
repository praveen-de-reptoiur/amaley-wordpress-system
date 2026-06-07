<?php
/**
 * Shared base widget for Amaley Mission/Vision visual statement sections.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) {
    return;
}

abstract class ACWSC109_Reference_Visual_Statement_Base_Widget extends \Elementor\Widget_Base {
    abstract protected function section_type();
    abstract protected function section_title();
    abstract protected function defaults();
    abstract protected function default_points();

    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_categories() {
        return array( 'amaley-compact' );
    }

    public function get_style_depends() {
        return array( 'acwsc-reference-visual-statement' );
    }

    public function get_keywords() {
        return array( 'amaley', 'mission', 'vision', 'himalayan', 'image', 'statement', 'premium' );
    }

    protected function register_controls() {
        $this->content_controls();
        $this->media_controls();
        $this->points_controls();
        $this->layout_controls();
        $this->section_style_controls();
        $this->heading_style_controls();
        $this->visual_style_controls();
        $this->points_style_controls();
        $this->button_style_controls();
    }

    protected function content_controls() {
        $d = $this->defaults();

        $this->start_controls_section( 'mvr_content', array( 'label' => esc_html__( 'Content', 'amaley-compact-widgets' ) ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Section', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'show_badge', array(
            'label'        => esc_html__( 'Show Badge / Label', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'badge_text', array(
            'label'     => esc_html__( 'Badge Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $d['badge_text'],
            'condition' => array( 'show_badge' => 'yes' ),
        ) );

        $this->add_control( 'show_kicker', array(
            'label'        => esc_html__( 'Show Kicker', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'kicker', array(
            'label'     => esc_html__( 'Kicker', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $d['kicker'],
            'condition' => array( 'show_kicker' => 'yes' ),
        ) );

        $this->add_control( 'show_title', array(
            'label'        => esc_html__( 'Show Title', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'title', array(
            'label'     => esc_html__( 'Title', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 3,
            'default'   => $d['title'],
            'condition' => array( 'show_title' => 'yes' ),
        ) );

        $this->add_control( 'accent_word', array(
            'label'       => esc_html__( 'Accent Word', 'amaley-compact-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $d['accent_word'],
            'description' => esc_html__( 'The first exact match inside title will be styled as italic/accent.', 'amaley-compact-widgets' ),
            'condition'   => array( 'show_title' => 'yes' ),
        ) );

        $this->add_control( 'show_description', array(
            'label'        => esc_html__( 'Show Description', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'description', array(
            'label'     => esc_html__( 'Description', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'rows'      => 5,
            'default'   => $d['description'],
            'condition' => array( 'show_description' => 'yes' ),
        ) );

        $this->add_control( 'show_buttons', array(
            'label'        => esc_html__( 'Show Button Row', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'separator'    => 'before',
        ) );

        $this->add_control( 'show_primary_button', array(
            'label'        => esc_html__( 'Show Primary Button', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_buttons' => 'yes' ),
        ) );

        $this->add_control( 'primary_button_text', array(
            'label'     => esc_html__( 'Primary Button Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $d['primary_button_text'],
            'condition' => array( 'show_buttons' => 'yes', 'show_primary_button' => 'yes' ),
        ) );

        $this->add_control( 'primary_button_url', array(
            'label'     => esc_html__( 'Primary Button Link', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::URL,
            'default'   => array( 'url' => '#' ),
            'condition' => array( 'show_buttons' => 'yes', 'show_primary_button' => 'yes' ),
        ) );

        $this->add_control( 'show_secondary_button', array(
            'label'        => esc_html__( 'Show Secondary Button', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_buttons' => 'yes' ),
        ) );

        $this->add_control( 'secondary_button_text', array(
            'label'     => esc_html__( 'Secondary Button Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $d['secondary_button_text'],
            'condition' => array( 'show_buttons' => 'yes', 'show_secondary_button' => 'yes' ),
        ) );

        $this->add_control( 'secondary_button_url', array(
            'label'     => esc_html__( 'Secondary Button Link', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::URL,
            'default'   => array( 'url' => '#' ),
            'condition' => array( 'show_buttons' => 'yes', 'show_secondary_button' => 'yes' ),
        ) );

        $this->end_controls_section();
    }

    protected function media_controls() {
        $d = $this->defaults();

        $this->start_controls_section( 'mvr_media', array( 'label' => esc_html__( 'Visual / Images', 'amaley-compact-widgets' ) ) );

        $this->add_control( 'show_visual', array(
            'label'        => esc_html__( 'Show Visual Panel', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'main_image', array(
            'label'     => esc_html__( 'Wide / Main Collage Image', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::MEDIA,
            'default'   => array( 'url' => '' ),
            'condition' => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'main_image_alt', array(
            'label'     => esc_html__( 'Main Image Alt Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $d['main_image_alt'],
            'condition' => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'show_floating_image', array(
            'label'        => esc_html__( 'Show Tall Collage Image', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'floating_image', array(
            'label'     => esc_html__( 'Tall Collage Image', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::MEDIA,
            'default'   => array( 'url' => '' ),
            'condition' => array( 'show_visual' => 'yes', 'show_floating_image' => 'yes' ),
        ) );

        $this->add_control( 'floating_image_alt', array(
            'label'     => esc_html__( 'Tall Image Alt Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $d['floating_image_alt'],
            'condition' => array( 'show_visual' => 'yes', 'show_floating_image' => 'yes' ),
        ) );

        $this->add_control( 'support_heading', array(
            'label'     => esc_html__( 'Small Supporting Image', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'show_support_image', array(
            'label'        => esc_html__( 'Show Small Supporting Image', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'support_image', array(
            'label'     => esc_html__( 'Small Supporting Image', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::MEDIA,
            'default'   => array( 'url' => '' ),
            'condition' => array( 'show_visual' => 'yes', 'show_support_image' => 'yes' ),
        ) );

        $this->add_control( 'support_image_alt', array(
            'label'     => esc_html__( 'Small Supporting Image Alt Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Amaley supporting visual detail',
            'condition' => array( 'show_visual' => 'yes', 'show_support_image' => 'yes' ),
        ) );

        $this->add_control( 'show_visual_caption', array(
            'label'        => esc_html__( 'Show Visual Caption Badge', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'visual_caption', array(
            'label'     => esc_html__( 'Visual Caption Badge Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => $d['visual_caption'],
            'condition' => array( 'show_visual' => 'yes', 'show_visual_caption' => 'yes' ),
        ) );

        $this->add_control( 'circle_heading', array(
            'label'     => esc_html__( 'Center Circle Badge', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'show_circle_badge', array(
            'label'        => esc_html__( 'Show Center Circle', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_visual' => 'yes' ),
        ) );

        $this->add_control( 'circle_text', array(
            'label'     => esc_html__( 'Circle Text', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => strtoupper( $this->section_title() ),
            'condition' => array( 'show_visual' => 'yes', 'show_circle_badge' => 'yes' ),
        ) );

        $this->add_control( 'circle_subtext', array(
            'label'     => esc_html__( 'Circle Subtext', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => '',
            'condition' => array( 'show_visual' => 'yes', 'show_circle_badge' => 'yes' ),
        ) );

        $this->end_controls_section();
    }

    protected function points_controls() {
        $this->start_controls_section( 'mvr_points', array( 'label' => esc_html__( 'Points / Cards', 'amaley-compact-widgets' ) ) );

        $this->add_control( 'show_points', array(
            'label'        => esc_html__( 'Show Points', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'show_point_icon', array(
            'label'        => esc_html__( 'Show Point Icon / Number', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_points' => 'yes' ),
        ) );

        $this->add_control( 'show_point_title', array(
            'label'        => esc_html__( 'Show Point Title', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_points' => 'yes' ),
        ) );

        $this->add_control( 'show_point_text', array(
            'label'        => esc_html__( 'Show Point Description', 'amaley-compact-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => array( 'show_points' => 'yes' ),
        ) );

        $this->add_control( 'point_content_mode', array(
            'label'       => esc_html__( 'Point Content Mode', 'amaley-compact-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'full',
            'options'     => array(
                'full'             => esc_html__( 'Title + Description', 'amaley-compact-widgets' ),
                'title_only'       => esc_html__( 'Title Only / List Style', 'amaley-compact-widgets' ),
                'description_only' => esc_html__( 'Description Only', 'amaley-compact-widgets' ),
            ),
            'description' => esc_html__( 'Use Title Only when the section needs more compact point-list content.', 'amaley-compact-widgets' ),
            'condition'   => array( 'show_points' => 'yes' ),
        ) );

        $this->add_control( 'point_content_note', array(
            'type'            => \Elementor\Controls_Manager::RAW_HTML,
            'raw'             => esc_html__( 'Each point below also has its own Show Title and Show Description switches. This lets you make some rows title-only and others detailed.', 'amaley-compact-widgets' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            'condition'       => array( 'show_points' => 'yes' ),
        ) );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', array( 'label' => esc_html__( 'Icon / Number', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✓' ) );
        $rep->add_control( 'show_title', array( 'label' => esc_html__( 'Show This Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $rep->add_control( 'title', array( 'label' => esc_html__( 'Point Title / Heading', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Visible Origin', 'condition' => array( 'show_title' => 'yes' ) ) );
        $rep->add_control( 'show_text', array( 'label' => esc_html__( 'Show This Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $rep->add_control( 'text', array( 'label' => esc_html__( 'Point Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Every product should clearly show where it comes from and who adds value.', 'condition' => array( 'show_text' => 'yes' ) ) );

        $this->add_control( 'points', array(
            'label'       => esc_html__( 'Points', 'amaley-compact-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'     => $this->default_points(),
            'condition'   => array( 'show_points' => 'yes' ),
        ) );

        $this->end_controls_section();
    }

    protected function layout_controls() {
        $d = $this->defaults();

        $this->start_controls_section( 'mvr_layout', array( 'label' => esc_html__( 'Layout', 'amaley-compact-widgets' ) ) );

        $this->add_control( 'visual_position', array(
            'label'   => esc_html__( 'Visual Position', 'amaley-compact-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => $d['visual_position'],
            'options' => array(
                'left'  => esc_html__( 'Image Left / Text Right', 'amaley-compact-widgets' ),
                'right' => esc_html__( 'Text Left / Image Right', 'amaley-compact-widgets' ),
            ),
        ) );

        $this->add_control( 'mobile_order', array(
            'label'   => esc_html__( 'Mobile Stack Order', 'amaley-compact-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'inherit',
            'options' => array(
                'inherit'      => esc_html__( 'Inherit Desktop Order', 'amaley-compact-widgets' ),
                'visual_first' => esc_html__( 'Image First / Text Below', 'amaley-compact-widgets' ),
                'text_first'   => esc_html__( 'Text First / Image Below', 'amaley-compact-widgets' ),
            ),
        ) );

        $this->add_responsive_control( 'content_align', array(
            'label'   => esc_html__( 'Text Alignment', 'amaley-compact-widgets' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'default' => 'left',
            'options' => array(
                'left'   => array( 'title' => esc_html__( 'Left', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-center' ),
                'right'  => array( 'title' => esc_html__( 'Right', 'amaley-compact-widgets' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( '{{WRAPPER}} .amaley-mvr-content' => 'text-align: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'columns_gap', array(
            'label'      => esc_html__( 'Image / Text Gap', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 120 ) ),
            'default'    => array( 'size' => 42, 'unit' => 'px' ),
            'tablet_default' => array( 'size' => 28, 'unit' => 'px' ),
            'mobile_default' => array( 'size' => 20, 'unit' => 'px' ),
            'selectors'  => array( '{{WRAPPER}} .amaley-mvr-shell' => 'gap: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'visual_width', array(
            'label'      => esc_html__( 'Visual Column Width %', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( '%' ),
            'range'      => array( '%' => array( 'min' => 35, 'max' => 65 ) ),
            'default'    => array( 'size' => 42, 'unit' => '%' ),
            'selectors'  => array( '{{WRAPPER}} .amaley-mvr-shell' => '--amvr-visual-width: {{SIZE}}%;' ),
        ) );

        $this->end_controls_section();
    }

    protected function section_style_controls() {
        $this->start_controls_section( 'mvr_style_section', array( 'label' => esc_html__( 'Section / Panel', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'section_background', array(
            'label'     => esc_html__( 'Section Background', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#fff8ed',
            'selectors' => array( '{{WRAPPER}} .amaley-mvr-section' => 'background: {{VALUE}};' ),
        ) );

        $this->add_control( 'content_panel_background', array(
            'label'     => esc_html__( 'Content Panel Background', 'amaley-compact-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => array( '{{WRAPPER}} .amaley-mvr-content' => 'background: {{VALUE}};' ),
        ) );

        $this->add_responsive_control( 'section_padding', array(
            'label'      => esc_html__( 'Section Padding', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'default'    => array( 'top' => 58, 'right' => 22, 'bottom' => 58, 'left' => 22, 'unit' => 'px' ),
            'tablet_default' => array( 'top' => 46, 'right' => 18, 'bottom' => 46, 'left' => 18, 'unit' => 'px' ),
            'mobile_default' => array( 'top' => 38, 'right' => 14, 'bottom' => 38, 'left' => 14, 'unit' => 'px' ),
            'selectors'  => array( '{{WRAPPER}} .amaley-mvr-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'inner_max_width', array(
            'label'      => esc_html__( 'Inner Max Width', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 780, 'max' => 1500 ) ),
            'default'    => array( 'size' => 1180, 'unit' => 'px' ),
            'selectors'  => array( '{{WRAPPER}} .amaley-mvr-inner' => 'max-width: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'content_panel_padding', array(
            'label'      => esc_html__( 'Content Panel Padding', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em' ),
            'default'    => array( 'top' => 8, 'right' => 0, 'bottom' => 8, 'left' => 0, 'unit' => 'px' ),
            'selectors'  => array( '{{WRAPPER}} .amaley-mvr-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );

        $this->add_responsive_control( 'content_panel_radius', array(
            'label'      => esc_html__( 'Content Panel Radius', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array( 'px' => array( 'min' => 0, 'max' => 80 ) ),
            'selectors'  => array( '{{WRAPPER}} .amaley-mvr-content' => 'border-radius: {{SIZE}}{{UNIT}};' ),
        ) );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
            'name'     => 'content_panel_shadow',
            'selector' => '{{WRAPPER}} .amaley-mvr-content',
        ) );

        $this->end_controls_section();
    }

    protected function heading_style_controls() {
        $this->start_controls_section( 'mvr_style_heading', array( 'label' => esc_html__( 'Heading / Text', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'badge_background', array( 'label' => esc_html__( 'Badge Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#f4e4c8', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-badge' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'badge_color', array( 'label' => esc_html__( 'Badge Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#9a5b1c', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-badge' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'badge_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-badge' ) );
        $this->add_responsive_control( 'badge_bottom_gap', array( 'label' => esc_html__( 'Badge Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 12, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'kicker_color', array( 'label' => esc_html__( 'Kicker Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#b9821d', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-kicker' => 'color: {{VALUE}};' ), 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'kicker_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-kicker' ) );
        $this->add_responsive_control( 'kicker_bottom_gap', array( 'label' => esc_html__( 'Kicker Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'default' => array( 'size' => 8, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-kicker' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-title' => 'color: {{VALUE}};' ), 'separator' => 'before' ) );
        $this->add_control( 'accent_color', array( 'label' => esc_html__( 'Accent Word Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#b5502a', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-title em' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-title' ) );
        $this->add_responsive_control( 'title_bottom_gap', array( 'label' => esc_html__( 'Title Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 12, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#6f4b34', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-desc' => 'color: {{VALUE}};' ), 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-desc' ) );
        $this->add_responsive_control( 'description_bottom_gap', array( 'label' => esc_html__( 'Description Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 24, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );

        $this->end_controls_section();
    }

    protected function visual_style_controls() {
        $this->start_controls_section( 'mvr_style_visual', array( 'label' => esc_html__( 'Collage Visual / Images', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'visual_background', array( 'label' => esc_html__( 'Collage Stage Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#f5ead6', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-collage-stage' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'collage_stage_height', array(
            'label'      => esc_html__( 'Collage Stage Height', 'amaley-compact-widgets' ),
            'description'=> esc_html__( 'Desktop/tablet/mobile auto-fit height. Mobile still stays as collage, not single image.', 'amaley-compact-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'vh' ),
            'range'      => array( 'px' => array( 'min' => 240, 'max' => 720 ), 'vh' => array( 'min' => 25, 'max' => 80 ) ),
            'default'    => array( 'size' => 430, 'unit' => 'px' ),
            'tablet_default' => array( 'size' => 330, 'unit' => 'px' ),
            'mobile_default' => array( 'size' => 270, 'unit' => 'px' ),
            'selectors'  => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-collage-height: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_responsive_control( 'collage_stage_radius', array( 'label' => esc_html__( 'Stage Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 30, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-collage-stage' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'collage_stage_padding', array( 'label' => esc_html__( 'Stage Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'default' => array( 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-collage-stage' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'collage_max_width', array( 'label' => esc_html__( 'Collage Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 280, 'max' => 760 ) ), 'default' => array( 'size' => 560, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 560, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 360, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'image_fit', array( 'label' => esc_html__( 'All Images Fit', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => esc_html__( 'Cover / Fill Crop', 'amaley-compact-widgets' ), 'contain' => esc_html__( 'Contain / Full Image', 'amaley-compact-widgets' ), 'fill' => esc_html__( 'Stretch Fill', 'amaley-compact-widgets' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-main-visual img, {{WRAPPER}} .amaley-mvr-floating-visual img, {{WRAPPER}} .amaley-mvr-support-visual img, {{WRAPPER}} .amaley-mvr-backdrop-visual img' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_control( 'backdrop_heading', array( 'label' => esc_html__( 'No-Blank Backdrop Fill', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'backdrop_opacity', array( 'label' => esc_html__( 'Backdrop Image Opacity', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 18, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-backdrop-visual' => 'opacity: calc({{SIZE}} / 100);' ) ) );
        $this->add_control( 'backdrop_blur', array( 'label' => esc_html__( 'Backdrop Blur', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'default' => array( 'size' => 6, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-backdrop-visual img' => 'filter: blur({{SIZE}}{{UNIT}}) saturate(1.04); transform: scale(1.06);' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'collage_stage_shadow', 'selector' => '{{WRAPPER}} .amaley-mvr-collage-stage' ) );

        $this->add_control( 'tall_image_heading', array( 'label' => esc_html__( 'Tall / Portrait Image Piece', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'tall_image_width', array( 'label' => esc_html__( 'Tall Image Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 24, 'max' => 62 ) ), 'default' => array( 'size' => 38, 'unit' => '%' ), 'tablet_default' => array( 'size' => 41, 'unit' => '%' ), 'mobile_default' => array( 'size' => 44, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-tall-w: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'tall_image_height', array( 'label' => esc_html__( 'Tall Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 42, 'max' => 92 ) ), 'default' => array( 'size' => 70, 'unit' => '%' ), 'tablet_default' => array( 'size' => 70, 'unit' => '%' ), 'mobile_default' => array( 'size' => 68, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-tall-h: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'tall_image_left', array( 'label' => esc_html__( 'Tall Image Left Offset', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => -25, 'max' => 55 ) ), 'default' => array( 'size' => 0, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-tall-left: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'tall_image_top', array( 'label' => esc_html__( 'Tall Image Top Offset', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => -25, 'max' => 55 ) ), 'default' => array( 'size' => 0, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-tall-top: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'tall_image_radius', array( 'label' => esc_html__( 'Tall Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 26, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 20, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-floating-visual' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'support_image_style_heading', array( 'label' => esc_html__( 'Small Supporting Image Piece', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'support_image_width', array( 'label' => esc_html__( 'Supporting Image Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 20, 'max' => 58 ) ), 'default' => array( 'size' => 36, 'unit' => '%' ), 'tablet_default' => array( 'size' => 36, 'unit' => '%' ), 'mobile_default' => array( 'size' => 38, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-support-w: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'support_image_height', array( 'label' => esc_html__( 'Supporting Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 18, 'max' => 52 ) ), 'default' => array( 'size' => 31, 'unit' => '%' ), 'tablet_default' => array( 'size' => 31, 'unit' => '%' ), 'mobile_default' => array( 'size' => 30, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-support-h: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'support_image_right', array( 'label' => esc_html__( 'Supporting Image Right Offset', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => -15, 'max' => 45 ) ), 'default' => array( 'size' => 3, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-support-right: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'support_image_top', array( 'label' => esc_html__( 'Supporting Image Top Offset', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => -15, 'max' => 45 ) ), 'default' => array( 'size' => 2, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-support-top: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'support_image_radius', array( 'label' => esc_html__( 'Supporting Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 24, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 18, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-support-visual' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'wide_image_heading', array( 'label' => esc_html__( 'Wide / Main Image Piece', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'wide_image_width', array( 'label' => esc_html__( 'Wide Image Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 50, 'max' => 100 ) ), 'default' => array( 'size' => 76, 'unit' => '%' ), 'tablet_default' => array( 'size' => 78, 'unit' => '%' ), 'mobile_default' => array( 'size' => 76, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-wide-w: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'wide_image_height', array( 'label' => esc_html__( 'Wide Image Height', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 35, 'max' => 86 ) ), 'default' => array( 'size' => 58, 'unit' => '%' ), 'tablet_default' => array( 'size' => 58, 'unit' => '%' ), 'mobile_default' => array( 'size' => 54, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-wide-h: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'wide_image_right', array( 'label' => esc_html__( 'Wide Image Right Offset', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => -25, 'max' => 55 ) ), 'default' => array( 'size' => 0, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-wide-right: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'wide_image_bottom', array( 'label' => esc_html__( 'Wide Image Bottom Offset', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => -25, 'max' => 55 ) ), 'default' => array( 'size' => 0, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-wrap' => '--amvr-wide-bottom: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'wide_image_radius', array( 'label' => esc_html__( 'Wide Image Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 26, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 20, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-main-visual' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );

        $this->add_control( 'image_position_heading', array( 'label' => esc_html__( 'Image Crop / Object Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $image_position_options = array(
            'center center' => esc_html__( 'Center Center', 'amaley-compact-widgets' ),
            'center top'    => esc_html__( 'Center Top', 'amaley-compact-widgets' ),
            'center bottom' => esc_html__( 'Center Bottom', 'amaley-compact-widgets' ),
            'left center'   => esc_html__( 'Left Center', 'amaley-compact-widgets' ),
            'right center'  => esc_html__( 'Right Center', 'amaley-compact-widgets' ),
        );
        $this->add_control( 'tall_image_position', array( 'label' => esc_html__( 'Tall Image Crop Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => $image_position_options, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-floating-visual img' => 'object-position: {{VALUE}};' ) ) );
        $this->add_control( 'support_image_position', array( 'label' => esc_html__( 'Supporting Image Crop Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => $image_position_options, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-support-visual img' => 'object-position: {{VALUE}};' ) ) );
        $this->add_control( 'wide_image_position', array( 'label' => esc_html__( 'Wide Image Crop Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => $image_position_options, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-main-visual img, {{WRAPPER}} .amaley-mvr-backdrop-visual img' => 'object-position: {{VALUE}};' ) ) );

        $this->add_control( 'circle_style_heading', array( 'label' => esc_html__( 'Center Mission / Vision Circle', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'circle_size', array( 'label' => esc_html__( 'Circle Size', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 54, 'max' => 220 ) ), 'default' => array( 'size' => 112, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 94, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 76, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-circle-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'circle_x', array( 'label' => esc_html__( 'Circle X Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 10, 'max' => 90 ) ), 'default' => array( 'size' => 45, 'unit' => '%' ), 'mobile_default' => array( 'size' => 45, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-circle-badge' => 'left: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'circle_y', array( 'label' => esc_html__( 'Circle Y Position', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 10, 'max' => 90 ) ), 'default' => array( 'size' => 48, 'unit' => '%' ), 'mobile_default' => array( 'size' => 48, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-circle-badge' => 'top: {{SIZE}}%;' ) ) );
        $this->add_control( 'circle_bg', array( 'label' => esc_html__( 'Circle Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ed', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-circle-badge' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'circle_color', array( 'label' => esc_html__( 'Circle Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-circle-badge' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'circle_border_color', array( 'label' => esc_html__( 'Circle Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(194,136,10,.45)', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-circle-badge' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'circle_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-circle-main' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'circle_shadow', 'selector' => '{{WRAPPER}} .amaley-mvr-circle-badge' ) );

        $this->add_control( 'caption_heading', array( 'label' => esc_html__( 'Visual Caption Badge', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'visual_caption_bg', array( 'label' => esc_html__( 'Caption Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-caption' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'visual_caption_color', array( 'label' => esc_html__( 'Caption Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ed', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-caption' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'visual_caption_radius', array( 'label' => esc_html__( 'Caption Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 999, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-visual-caption' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'visual_caption_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-visual-caption' ) );

        $this->end_controls_section();
    }

    protected function points_style_controls() {
        $this->start_controls_section( 'mvr_style_points', array( 'label' => esc_html__( 'Points / Cards', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_responsive_control( 'points_gap', array( 'label' => esc_html__( 'Point Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'default' => array( 'size' => 14, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-points' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_padding', array( 'label' => esc_html__( 'Point Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_icon_text_gap', array( 'label' => esc_html__( 'Icon to Text Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 12, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point' => 'column-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_copy_gap', array( 'label' => esc_html__( 'Title / Description Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 4, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-copy' => 'display: grid; row-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'point_background', array( 'label' => esc_html__( 'Point Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'point_border_color', array( 'label' => esc_html__( 'Point Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'point_radius', array( 'label' => esc_html__( 'Point Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 18, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'point_shadow', 'selector' => '{{WRAPPER}} .amaley-mvr-point' ) );

        $this->add_control( 'point_hover_heading', array( 'label' => esc_html__( 'Point Hover', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'point_hover_background', array( 'label' => esc_html__( 'Point Hover Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'point_hover_border_color', array( 'label' => esc_html__( 'Point Hover Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point:hover' => 'border-color: {{VALUE}};' ) ) );

        $this->add_control( 'point_icon_heading', array( 'label' => esc_html__( 'Point Icon / Number', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'point_icon_bg', array( 'label' => esc_html__( 'Icon Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#f1dfbf', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'point_icon_color', array( 'label' => esc_html__( 'Icon Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#8d5d12', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-icon, {{WRAPPER}} .amaley-mvr-point-icon i, {{WRAPPER}} .amaley-mvr-point-icon svg, {{WRAPPER}} .amaley-mvr-point-icon svg *' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important; stroke: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'point_icon_size', array( 'label' => esc_html__( 'Icon Size', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 18, 'max' => 76 ) ), 'default' => array( 'size' => 34, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_icon_radius', array( 'label' => esc_html__( 'Icon Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 999 ) ), 'default' => array( 'size' => 999, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-icon' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'point_icon_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-point-icon' ) );

        $this->add_control( 'point_title_heading', array( 'label' => esc_html__( 'Point Heading / Title', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'point_title_color', array( 'label' => esc_html__( 'Title Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'point_title_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-point-title' ) );
        $this->add_responsive_control( 'point_title_bottom_gap', array( 'label' => esc_html__( 'Title Bottom Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 4, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_title_padding', array( 'label' => esc_html__( 'Title Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'point_title_bg', array( 'label' => esc_html__( 'Title Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-title' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'point_title_radius', array( 'label' => esc_html__( 'Title Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-title' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_title_max_width', array( 'label' => esc_html__( 'Title Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px','%' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 900 ), '%' => array( 'min' => 10, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-title' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_title_line_clamp', array( 'label' => esc_html__( 'Title Line Clamp', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 0, 'max' => 6, 'step' => 1, 'description' => esc_html__( '0 = no clamp. Use 1 or 2 for compact point-list rows.', 'amaley-compact-widgets' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-title' => '-webkit-line-clamp: {{VALUE}};' ) ) );

        $this->add_control( 'point_description_heading', array( 'label' => esc_html__( 'Point Description', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'point_text_color', array( 'label' => esc_html__( 'Description Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#72513a', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-text' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'point_text_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-point-text' ) );
        $this->add_responsive_control( 'point_text_padding', array( 'label' => esc_html__( 'Description Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'point_text_bg', array( 'label' => esc_html__( 'Description Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-text' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'point_text_radius', array( 'label' => esc_html__( 'Description Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-text' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_text_max_width', array( 'label' => esc_html__( 'Description Max Width', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px','%' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 1000 ), '%' => array( 'min' => 10, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-text' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'point_text_line_clamp', array( 'label' => esc_html__( 'Description Line Clamp', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 0, 'max' => 8, 'step' => 1, 'description' => esc_html__( '0 = no clamp. Use this to keep point rows compact without deleting text.', 'amaley-compact-widgets' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-point-text' => '-webkit-line-clamp: {{VALUE}};' ) ) );

        $this->end_controls_section();
    }

    protected function button_style_controls() {
        $this->start_controls_section( 'mvr_style_buttons', array( 'label' => esc_html__( 'Buttons', 'amaley-compact-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_responsive_control( 'button_row_gap', array( 'label' => esc_html__( 'Button Row Gap', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 12, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'default' => array( 'top' => 13, 'right' => 20, 'bottom' => 13, 'left' => 20, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 999, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .amaley-mvr-btn' ) );

        $this->add_control( 'primary_button_heading', array( 'label' => esc_html__( 'Primary Button', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'primary_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--primary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_color', array( 'label' => esc_html__( 'Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ed', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--primary' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_border', array( 'label' => esc_html__( 'Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--primary' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_hover_bg', array( 'label' => esc_html__( 'Hover Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#b5502a', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--primary:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_hover_color', array( 'label' => esc_html__( 'Hover Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ed', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--primary:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'primary_hover_border', array( 'label' => esc_html__( 'Hover Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#b5502a', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--primary:hover' => 'border-color: {{VALUE}};' ) ) );

        $this->add_control( 'secondary_button_heading', array( 'label' => esc_html__( 'Secondary Button', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'secondary_bg', array( 'label' => esc_html__( 'Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'transparent', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--secondary' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_color', array( 'label' => esc_html__( 'Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--secondary' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_border', array( 'label' => esc_html__( 'Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(46,18,3,.34)', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--secondary' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_hover_bg', array( 'label' => esc_html__( 'Hover Background', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--secondary:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_hover_color', array( 'label' => esc_html__( 'Hover Text Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ed', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--secondary:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_hover_border', array( 'label' => esc_html__( 'Hover Border Color', 'amaley-compact-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-mvr-btn--secondary:hover' => 'border-color: {{VALUE}};' ) ) );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        if ( empty( $s['show_section'] ) || 'yes' !== $s['show_section'] ) {
            return;
        }

        if ( class_exists( 'Amaley_MVR_Plugin' ) ) {
            Amaley_MVR_Plugin::instance()->enqueue_assets();
        }

        $type = $this->section_type();
        $visual_position = in_array( $s['visual_position'] ?? '', array( 'left', 'right' ), true ) ? $s['visual_position'] : 'left';
        $mobile_order = in_array( $s['mobile_order'] ?? '', array( 'inherit', 'visual_first', 'text_first' ), true ) ? $s['mobile_order'] : 'inherit';
        $classes = 'amaley-mvr-section amaley-mvr-' . esc_attr( $type ) . ' amaley-mvr-visual-' . esc_attr( $visual_position ) . ' amaley-mvr-mobile-' . esc_attr( $mobile_order );

        echo '<section class="' . esc_attr( $classes ) . '" data-amaley-mvr="' . esc_attr( $type ) . '"><div class="amaley-mvr-inner"><div class="amaley-mvr-shell">';

        if ( 'left' === $visual_position ) {
            $this->render_visual( $s );
            $this->render_statement_content( $s );
        } else {
            $this->render_statement_content( $s );
            $this->render_visual( $s );
        }

        echo '</div></div></section>';
    }

    protected function render_visual( $s ) {
        if ( empty( $s['show_visual'] ) || 'yes' !== $s['show_visual'] ) {
            return;
        }

        $main_url     = $this->media_url( $s['main_image'] ?? array() );
        $floating_url = $this->media_url( $s['floating_image'] ?? array() );
        $tall_url     = ( ! empty( $s['show_floating_image'] ) && 'yes' === $s['show_floating_image'] && $floating_url ) ? $floating_url : $main_url;

        echo '<div class="amaley-mvr-visual-wrap"><div class="amaley-mvr-collage-stage">';

        if ( $main_url ) {
            echo '<figure class="amaley-mvr-backdrop-visual" aria-hidden="true"><img src="' . esc_url( $main_url ) . '" alt="" loading="lazy"></figure>';
        }

        if ( $tall_url ) {
            echo '<figure class="amaley-mvr-floating-visual amaley-mvr-collage-tall"><img src="' . esc_url( $tall_url ) . '" alt="' . esc_attr( $s['floating_image_alt'] ?? $s['main_image_alt'] ?? '' ) . '" loading="lazy"></figure>';
        } else {
            echo '<figure class="amaley-mvr-floating-visual amaley-mvr-collage-tall amaley-mvr-visual-placeholder amaley-mvr-visual-placeholder--small"><span>' . esc_html( $s['floating_image_alt'] ?? 'Amaley detail' ) . '</span></figure>';
        }

        if ( ! empty( $s['show_support_image'] ) && 'yes' === $s['show_support_image'] ) {
            $support_url = $this->media_url( $s['support_image'] ?? array() );
            if ( ! $support_url ) {
                $support_url = $main_url ?: $tall_url;
            }
            if ( $support_url ) {
                echo '<figure class="amaley-mvr-support-visual amaley-mvr-collage-support"><img src="' . esc_url( $support_url ) . '" alt="' . esc_attr( $s['support_image_alt'] ?? $s['main_image_alt'] ?? '' ) . '" loading="lazy"></figure>';
            } else {
                echo '<figure class="amaley-mvr-support-visual amaley-mvr-collage-support amaley-mvr-visual-placeholder amaley-mvr-visual-placeholder--small"><span>' . esc_html( $s['support_image_alt'] ?? 'Amaley detail' ) . '</span></figure>';
            }
        }

        if ( $main_url ) {
            echo '<figure class="amaley-mvr-main-visual amaley-mvr-collage-wide"><img src="' . esc_url( $main_url ) . '" alt="' . esc_attr( $s['main_image_alt'] ?? '' ) . '" loading="lazy"></figure>';
        } else {
            echo '<figure class="amaley-mvr-main-visual amaley-mvr-collage-wide amaley-mvr-visual-placeholder"><span>' . esc_html( $s['main_image_alt'] ?? 'Amaley visual' ) . '</span></figure>';
        }

        if ( ! empty( $s['show_circle_badge'] ) && 'yes' === $s['show_circle_badge'] ) {
            $circle_text = ! empty( $s['circle_text'] ) ? $s['circle_text'] : strtoupper( $this->section_title() );
            echo '<div class="amaley-mvr-circle-badge"><span class="amaley-mvr-circle-main">' . esc_html( $circle_text ) . '</span>';
            if ( ! empty( $s['circle_subtext'] ) ) {
                echo '<small class="amaley-mvr-circle-sub">' . esc_html( $s['circle_subtext'] ) . '</small>';
            }
            echo '</div>';
        }

        if ( ! empty( $s['show_visual_caption'] ) && 'yes' === $s['show_visual_caption'] && ! empty( $s['visual_caption'] ) ) {
            echo '<span class="amaley-mvr-visual-caption">' . esc_html( $s['visual_caption'] ) . '</span>';
        }

        echo '</div></div>';
    }

    protected function render_statement_content( $s ) {
        echo '<div class="amaley-mvr-content">';

        if ( ! empty( $s['show_badge'] ) && 'yes' === $s['show_badge'] && ! empty( $s['badge_text'] ) ) {
            echo '<span class="amaley-mvr-badge">' . esc_html( $s['badge_text'] ) . '</span>';
        }
        if ( ! empty( $s['show_kicker'] ) && 'yes' === $s['show_kicker'] && ! empty( $s['kicker'] ) ) {
            echo '<p class="amaley-mvr-kicker">' . esc_html( $s['kicker'] ) . '</p>';
        }
        if ( ! empty( $s['show_title'] ) && 'yes' === $s['show_title'] && ! empty( $s['title'] ) ) {
            echo '<h2 class="amaley-mvr-title">' . $this->title_with_accent( $s['title'], $s['accent_word'] ?? '' ) . '</h2>';
        }
        if ( ! empty( $s['show_description'] ) && 'yes' === $s['show_description'] && ! empty( $s['description'] ) ) {
            echo '<p class="amaley-mvr-desc">' . esc_html( $s['description'] ) . '</p>';
        }

        if ( ! empty( $s['show_points'] ) && 'yes' === $s['show_points'] && ! empty( $s['points'] ) && is_array( $s['points'] ) ) {
            $point_content_mode = isset( $s['point_content_mode'] ) ? sanitize_html_class( $s['point_content_mode'] ) : 'full';
            if ( ! in_array( $point_content_mode, array( 'full', 'title_only', 'description_only' ), true ) ) {
                $point_content_mode = 'full';
            }
            echo '<div class="amaley-mvr-points amaley-mvr-points--' . esc_attr( $point_content_mode ) . '">';
            foreach ( $s['points'] as $point ) {
                $item_show_title = ! empty( $s['show_point_title'] ) && 'yes' === $s['show_point_title'] && 'description_only' !== $point_content_mode && ( ! isset( $point['show_title'] ) || 'yes' === $point['show_title'] );
                $item_show_text  = ! empty( $s['show_point_text'] ) && 'yes' === $s['show_point_text'] && 'title_only' !== $point_content_mode && ( ! isset( $point['show_text'] ) || 'yes' === $point['show_text'] );
                $point_classes = array( 'amaley-mvr-point', 'amaley-mvr-point--' . $point_content_mode );
                if ( ! $item_show_text ) { $point_classes[] = 'amaley-mvr-point--no-description'; }
                if ( ! $item_show_title ) { $point_classes[] = 'amaley-mvr-point--no-title'; }
                echo '<article class="' . esc_attr( implode( ' ', $point_classes ) ) . '">';
                if ( ! empty( $s['show_point_icon'] ) && 'yes' === $s['show_point_icon'] && ! empty( $point['icon'] ) ) {
                    echo '<span class="amaley-mvr-point-icon">' . esc_html( $point['icon'] ) . '</span>';
                }
                echo '<div class="amaley-mvr-point-copy">';
                if ( $item_show_title && ! empty( $point['title'] ) ) {
                    echo '<h3 class="amaley-mvr-point-title">' . esc_html( $point['title'] ) . '</h3>';
                }
                if ( $item_show_text && ! empty( $point['text'] ) ) {
                    echo '<p class="amaley-mvr-point-text">' . esc_html( $point['text'] ) . '</p>';
                }
                echo '</div></article>';
            }
            echo '</div>';
        }

        if ( ! empty( $s['show_buttons'] ) && 'yes' === $s['show_buttons'] ) {
            echo '<div class="amaley-mvr-actions">';
            if ( ! empty( $s['show_primary_button'] ) && 'yes' === $s['show_primary_button'] && ! empty( $s['primary_button_text'] ) ) {
                echo '<a class="amaley-mvr-btn amaley-mvr-btn--primary" href="' . esc_url( $this->url_value( $s['primary_button_url'] ?? array() ) ) . '">' . esc_html( $s['primary_button_text'] ) . '</a>';
            }
            if ( ! empty( $s['show_secondary_button'] ) && 'yes' === $s['show_secondary_button'] && ! empty( $s['secondary_button_text'] ) ) {
                echo '<a class="amaley-mvr-btn amaley-mvr-btn--secondary" href="' . esc_url( $this->url_value( $s['secondary_button_url'] ?? array() ) ) . '">' . esc_html( $s['secondary_button_text'] ) . '</a>';
            }
            echo '</div>';
        }

        echo '</div>';
    }

    protected function media_url( $media ) {
        if ( is_array( $media ) && ! empty( $media['url'] ) ) {
            return (string) $media['url'];
        }
        if ( is_string( $media ) ) {
            return $media;
        }
        return '';
    }

    protected function url_value( $url ) {
        if ( is_array( $url ) && ! empty( $url['url'] ) ) {
            return (string) $url['url'];
        }
        if ( is_string( $url ) && '' !== $url ) {
            return $url;
        }
        return '#';
    }

    protected function title_with_accent( $title, $accent ) {
        $title  = esc_html( (string) $title );
        $accent = trim( (string) $accent );
        if ( '' === $accent ) {
            return $title;
        }
        $escaped = esc_html( $accent );
        $pos = stripos( $title, $escaped );
        if ( false === $pos ) {
            return $title;
        }
        return substr( $title, 0, $pos ) . '<em>' . substr( $title, $pos, strlen( $escaped ) ) . '</em>' . substr( $title, $pos + strlen( $escaped ) );
    }
}
