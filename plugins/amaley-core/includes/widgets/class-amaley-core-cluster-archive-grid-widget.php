<?php
/** Amaley Cluster Archive Grid Elementor widget. v1.0.32 full control rebuild. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Cluster_Archive_Grid_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_cluster_archive_grid'; }
    public function get_title() { return esc_html__( 'Amaley Cluster Archive Grid', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-cluster-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'cluster', 'archive', 'grid', 'cards' ); }

    protected function register_controls() {
        $this->start_controls_section( 'content_heading', array( 'label' => esc_html__( '1. Section Heading', 'amaley-core' ) ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster directory' ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Open a cluster to explore the full origin story', 'rows' => 2 ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Each cluster card opens a deeper page with its SHGs, producers, mapped products and origin journey.', 'rows' => 3 ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'No Amaley clusters are available yet.', 'rows' => 3 ) );
        $this->end_controls_section();

        $this->start_controls_section( 'routing', array( 'label' => esc_html__( '2. Routing / Single Template', 'amaley-core' ) ) );
        $this->add_control( 'use_template_single', array( 'label' => esc_html__( 'Use Assigned Single Template Page', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1', 'description' => esc_html__( 'Recommended. Uses Amaley Core → Settings → Page Template Assignment.', 'amaley-core' ) ) );
        $this->add_control( 'detail_url_pattern', array( 'label' => esc_html__( 'Manual Detail URL Override', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Optional only. Supports {id} and {slug}.', 'amaley-core' ) ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Card Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View Cluster Story' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'data', array( 'label' => esc_html__( '3. Data Query', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Clusters', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 60, 'default' => 12 ) );
        $this->add_control( 'show_only_website', array( 'label' => esc_html__( 'Only Website-Enabled', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'include_ids', array( 'label' => esc_html__( 'Include Cluster IDs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Comma-separated cluster IDs.', 'amaley-core' ) ) );
        $this->add_control( 'exclude_ids', array( 'label' => esc_html__( 'Exclude Cluster IDs', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Comma-separated cluster IDs.', 'amaley-core' ) ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'title', 'options' => array( 'title' => 'Title', 'date' => 'Date', 'modified' => 'Modified', 'menu_order' => 'Menu Order', 'rand' => 'Random' ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'ASC', 'options' => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', array( 'label' => esc_html__( '4. Card Elements', 'amaley-core' ) ) );
        $fields = array( 'show_image' => 'Image / Fallback Initial', 'show_region' => 'Region / Meta', 'show_villages' => 'Village Text', 'show_products' => 'Product Tags', 'show_counts' => 'SHG / Producer Count Boxes', 'show_button' => 'Button' );
        foreach ( $fields as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html__( 'Show ' . $label, 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'layout', array( 'label' => esc_html__( '5. Layout / Alignment', 'amaley-core' ) ) );
        $this->add_responsive_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ), 'selectors' => array( '{{WRAPPER}} .amcas-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
        $this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Card Grid Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 96 ) ), 'default' => array( 'size' => 24, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amcas-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'heading_block_align', array( 'label' => esc_html__( 'Heading Block Position', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title'=>'Left','icon'=>'eicon-h-align-left' ), 'center' => array( 'title'=>'Center','icon'=>'eicon-h-align-center' ), 'right' => array( 'title'=>'Right','icon'=>'eicon-h-align-right' ) ), 'default' => 'left', 'prefix_class' => 'amcas-head-block-' ) );
        $this->add_responsive_control( 'heading_text_align', array( 'label' => esc_html__( 'Heading Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title'=>'Left','icon'=>'eicon-text-align-left' ), 'center' => array( 'title'=>'Center','icon'=>'eicon-text-align-center' ), 'right' => array( 'title'=>'Right','icon'=>'eicon-text-align-right' ) ), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .amcas-sec-head' => 'text-align: {{VALUE}};' ) ) );
        $this->add_control( 'card_content_align_class', array( 'label' => esc_html__( 'Card Content Position', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title'=>'Left','icon'=>'eicon-h-align-left' ), 'center' => array( 'title'=>'Center','icon'=>'eicon-h-align-center' ), 'right' => array( 'title'=>'Right','icon'=>'eicon-h-align-right' ) ), 'default' => 'left', 'prefix_class' => 'amcas-card-align-' ) );
        $this->add_control( 'button_width_class', array( 'label' => esc_html__( 'Button Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'full', 'options' => array( 'full' => 'Full Width', 'auto' => 'Auto Width' ), 'prefix_class' => 'amcas-card-button-' ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1720 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_section', array( 'label' => esc_html__( '6. Section Box / Background', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'bg', array( 'label' => esc_html__( 'Background Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-grid-sec' => 'background-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'label' => esc_html__( 'Section Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-grid-sec' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'section_shadow', 'selector' => '{{WRAPPER}} .amcas-grid-sec' ) );
        $this->add_responsive_control( 'padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-grid-sec' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_radius', array( 'label' => esc_html__( 'Section Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-grid-sec' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_head', array( 'label' => esc_html__( '7. Heading Elements', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'head_max_width', array( 'label' => esc_html__( 'Heading Block Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 320, 'max' => 1320 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-sec-head' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'head_margin', array( 'label' => esc_html__( 'Heading Block Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-sec-head' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};' ) ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Small Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-sec-head .amcas-label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typo', 'label' => esc_html__( 'Small Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-sec-head .amcas-label' ) );
        $this->add_responsive_control( 'label_margin', array( 'label' => esc_html__( 'Small Label Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-sec-head .amcas-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-sec-head h2' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typo', 'label' => esc_html__( 'Heading Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-sec-head h2' ) );
        $this->add_responsive_control( 'heading_margin', array( 'label' => esc_html__( 'Heading Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-sec-head h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'desc_max_width', array( 'label' => esc_html__( 'Description Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 280, 'max' => 1000 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-sec-head .amcas-head-desc' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-sec-head .amcas-head-desc' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'desc_typo', 'label' => esc_html__( 'Description Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-sec-head .amcas-head-desc' ) );
        $this->add_responsive_control( 'description_margin', array( 'label' => esc_html__( 'Description Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-sec-head .amcas-head-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'card_box_style', array( 'label' => esc_html__( '8. Card Outer Box', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-cluster-card' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'label' => esc_html__( 'Card Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-cluster-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amcas-cluster-card' ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-cluster-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;' ) ) );
        $this->add_responsive_control( 'card_min_height', array( 'label' => esc_html__( 'Card Minimum Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 820 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-cluster-card' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_body_padding', array( 'label' => esc_html__( 'Card Body Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_inner_gap', array( 'label' => esc_html__( 'Card Inner Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 48 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-card-body' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'media_style', array( 'label' => esc_html__( '9. Image / Fallback Area', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'media_height', array( 'label' => esc_html__( 'Image/Fallback Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 520 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-card-media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'media_bg', array( 'label' => esc_html__( 'Fallback Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-media' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'media_radius', array( 'label' => esc_html__( 'Media Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'initial_typo', 'label' => esc_html__( 'Fallback Initial Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-card-media span' ) );
        $this->add_control( 'initial_color', array( 'label' => esc_html__( 'Fallback Initial Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-media span' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'card_text_style', array( 'label' => esc_html__( '10. Card Text Elements', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_meta_color', array( 'label' => esc_html__( 'Region/Meta Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-region' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_meta_typo', 'label' => esc_html__( 'Region/Meta Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-card-region' ) );
        $this->add_responsive_control( 'card_meta_margin', array( 'label' => esc_html__( 'Region/Meta Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-region' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-body h3' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typo', 'label' => esc_html__( 'Card Title Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-card-body h3' ) );
        $this->add_responsive_control( 'card_title_margin', array( 'label' => esc_html__( 'Card Title Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-body h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'card_text_color', array( 'label' => esc_html__( 'Village Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-text' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_text_typo', 'label' => esc_html__( 'Village Text Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-card-text' ) );
        $this->add_responsive_control( 'card_text_margin', array( 'label' => esc_html__( 'Village Text Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'tag_style', array( 'label' => esc_html__( '11. Product Tags', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'tag_wrap_gap', array( 'label' => esc_html__( 'Tag Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 32 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-tags' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_wrap_margin', array( 'label' => esc_html__( 'Tag Wrapper Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-tags' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'tag_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-tags span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'tag_color', array( 'label' => esc_html__( 'Tag Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-tags span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'tag_border_group', 'label' => esc_html__( 'Tag Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-tags span' ) );
        $this->add_responsive_control( 'tag_padding', array( 'label' => esc_html__( 'Tag Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-tags span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_radius', array( 'label' => esc_html__( 'Tag Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-tags span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'tag_typo', 'label' => esc_html__( 'Tag Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-tags span' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'stat_style', array( 'label' => esc_html__( '12. SHG / Producer Stat Boxes', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'stat_wrap_gap', array( 'label' => esc_html__( 'Stats Box Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 48 ) ), 'selectors' => array( '{{WRAPPER}} .amcas-mini-stats' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'stat_wrap_margin', array( 'label' => esc_html__( 'Stats Wrapper Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-mini-stats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'stat_bg', array( 'label' => esc_html__( 'Stat Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-mini-stats .amcas-stat-box' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'stat_border_group', 'label' => esc_html__( 'Stat Box Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-mini-stats .amcas-stat-box' ) );
        $this->add_responsive_control( 'stat_padding', array( 'label' => esc_html__( 'Stat Box Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-mini-stats .amcas-stat-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'stat_radius', array( 'label' => esc_html__( 'Stat Box Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-mini-stats .amcas-stat-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'stat_number_color', array( 'label' => esc_html__( 'Stat Number Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-stat-number' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'stat_number_typo', 'label' => esc_html__( 'Stat Number Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-stat-number' ) );
        $this->add_control( 'stat_label_color', array( 'label' => esc_html__( 'Stat Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-stat-label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'stat_label_typo', 'label' => esc_html__( 'Stat Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-stat-label' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'button_style', array( 'label' => esc_html__( '13. Card Button', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'button_margin', array( 'label' => esc_html__( 'Button Margin', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amcas-card-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'button_border_group', 'label' => esc_html__( 'Button Border', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-card-link' ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-link' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-link' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_hover_bg', array( 'label' => esc_html__( 'Button Hover Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-link:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_hover_color', array( 'label' => esc_html__( 'Button Hover Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amcas-card-link:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typo', 'label' => esc_html__( 'Button Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amcas-card-link' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_cluster_archive_sections'] ) && $GLOBALS['amaley_core_cluster_archive_sections'] instanceof Amaley_Core_Cluster_Archive_Sections ? $GLOBALS['amaley_core_cluster_archive_sections'] : new Amaley_Core_Cluster_Archive_Sections();
        echo $renderer->render_grid( $this->get_settings_for_display() );
    }
}
