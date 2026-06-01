<?php
/** Amaley Cluster Archive Hero Elementor widget. v1.0.32 full control rebuild. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Archive_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_cluster_archive_hero'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Archive Hero', 'amaley-core' ); }
    public function get_icon() { return 'eicon-banner'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'archive', 'hero' ); }

    protected function register_controls() {
        $this->start_controls_section( 'hero_content', array( 'label' => esc_html__( '1. Hero Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley Origins' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Main Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Browse Amaley Source Clusters', 'rows' => 2 ) );
        $this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Word', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Clusters' ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Explore origin geographies, women collectives, producer families and products through a simple cluster directory.', 'rows' => 4 ) );
        $this->end_controls_section();

        $this->start_controls_section( 'breadcrumbs', array( 'label' => esc_html__( '2. Breadcrumbs', 'amaley-core' ) ) );
        $this->add_control( 'show_breadcrumbs', array( 'label' => esc_html__( 'Show Breadcrumbs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        foreach ( array( 'home' => 'Home', 'middle' => 'Middle', 'current' => 'Current' ) as $key => $label ) {
            $this->add_control( $key . '_label', array( 'label' => esc_html__( $label . ' Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'home' === $key ? 'Home' : ( 'middle' === $key ? 'Shop' : 'Clusters' ) ) );
            if ( 'current' !== $key ) {
                $this->add_control( $key . '_url', array( 'label' => esc_html__( $label . ' URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'home' === $key ? '/' : '/shop/' ) );
            }
        }
        $this->end_controls_section();

        $this->start_controls_section( 'buttons', array( 'label' => esc_html__( '3. Buttons', 'amaley-core' ) ) );
        $this->add_control( 'show_buttons', array( 'label' => esc_html__( 'Show Buttons', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'primary_text', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore Products' ) );
        $this->add_control( 'primary_url', array( 'label' => esc_html__( 'Primary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '/shop/' ) );
        $this->add_control( 'secondary_text', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Know the Collectives' ) );
        $this->add_control( 'secondary_url', array( 'label' => esc_html__( 'Secondary Button URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '#cluster-grid' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'right_visual', array( 'label' => esc_html__( '4. Right Visual / Stats', 'amaley-core' ) ) );
        $this->add_control( 'visual_style', array( 'label' => esc_html__( 'Visual Style', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'directory', 'options' => array( 'directory' => 'Directory Card', 'image' => 'Image Card' ) ) );
        $this->add_control( 'right_image_url', array( 'label' => esc_html__( 'Right Image URL', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( 'right_caption', array( 'label' => esc_html__( 'Right Card Caption', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Origin-led Amaley directory', 'rows' => 2 ) );
        $this->add_control( 'show_stats', array( 'label' => esc_html__( 'Show Stats', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'stat_one_label', array( 'label' => esc_html__( 'Stat 1 Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Clusters' ) );
        $this->add_control( 'stat_two_label', array( 'label' => esc_html__( 'Stat 2 Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'SHGs' ) );
        $this->add_control( 'stat_three_label', array( 'label' => esc_html__( 'Stat 3 Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Producers' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'layout', array( 'label' => esc_html__( '5. Layout / Alignment', 'amaley-core' ) ) );
        $this->add_control( 'hero_height', array( 'label' => esc_html__( 'Hero Height Preset', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'compact', 'options' => array( 'compact' => 'Compact', 'standard' => 'Standard', 'deep' => 'Deep' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1720 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-hero-inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'hero_gap', array( 'label' => esc_html__( 'Column Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-hero-inner' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'side_width', array( 'label' => esc_html__( 'Right Column Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 220, 'max' => 560 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-hero-inner' => 'grid-template-columns: minmax(0,1fr) {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'content_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right') ), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .amcas-hero-copy' => 'text-align: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_style', array( 'label' => esc_html__( '6. Section / Background', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'hero_bg', array( 'label' => esc_html__( 'Hero Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-hero' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'hero_overlay', array( 'label' => esc_html__( 'Overlay / Gradient Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-hero-bg' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'selector' => '{{WRAPPER}} .amcas-hero' ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Hero Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Hero Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'text_style', array( 'label' => esc_html__( '7. Typography / Text Colors', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        foreach ( array( 'label' => 'Small Label', 'title' => 'Heading', 'accent' => 'Accent Word', 'description' => 'Description' ) as $key => $label ) {
            $selector = 'label' === $key ? '{{WRAPPER}} .amcas-hero .amcas-label' : ( 'title' === $key ? '{{WRAPPER}} .amcas-hero h1' : ( 'accent' === $key ? '{{WRAPPER}} .amcas-hero h1 em' : '{{WRAPPER}} .amcas-hero-desc' ) );
            $this->add_control( $key . '_color', array( 'label' => esc_html__( $label . ' Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( $selector => 'color: {{VALUE}};' ) ) );
            $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => $key . '_typography', 'label' => esc_html__( $label . ' Typography', 'amaley-core' ), 'selector' => $selector ) );
            $this->add_responsive_control( $key . '_margin', array( 'label' => esc_html__( $label . ' Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'side_style', array( 'label' => esc_html__( '8. Right Card / Stats Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'side_bg', array( 'label' => esc_html__( 'Right Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-hero-mark, {{WRAPPER}} .amcas-hero-side img' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'side_border', 'selector' => '{{WRAPPER}} .amcas-hero-mark, {{WRAPPER}} .amcas-hero-side img' ) );
        $this->add_responsive_control( 'side_padding', array( 'label' => esc_html__( 'Right Card Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amcas-hero-mark' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'side_radius', array( 'label' => esc_html__( 'Right Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-hero-mark, {{WRAPPER}} .amcas-hero-side img, {{WRAPPER}} .amcas-hero-stats' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;' ) ) );
        $this->add_responsive_control( 'stat_padding', array( 'label' => esc_html__( 'Stats Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amcas-hero-stats span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'stat_bg', array( 'label' => esc_html__( 'Stats Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-hero-stats' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'button_style', array( 'label' => esc_html__( '9. Button Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'actions_gap', array( 'label' => esc_html__( 'Button Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min'=>0, 'max'=>48 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amcas-hero .amcas-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','%' ), 'selectors' => array( '{{WRAPPER}} .amcas-hero .amcas-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typo', 'label' => esc_html__( 'Button Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-hero .amcas-btn' ) );
        $this->add_control( 'primary_bg', array( 'label' => esc_html__( 'Primary Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-btn-gold' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'primary_color', array( 'label' => esc_html__( 'Primary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-btn-gold' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'secondary_color', array( 'label' => esc_html__( 'Secondary Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-btn-outline' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_archive_sections'] ) && $GLOBALS['amaley_core_cluster_archive_sections'] instanceof Amaley_Core_Cluster_Archive_Sections ? $GLOBALS['amaley_core_cluster_archive_sections'] : new Amaley_Core_Cluster_Archive_Sections();
        echo $renderer->render_hero( $this->get_settings_for_display() );
    }
}
