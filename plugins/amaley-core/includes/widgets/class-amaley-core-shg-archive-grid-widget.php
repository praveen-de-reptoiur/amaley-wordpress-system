<?php
/** Amaley SHG Archive Grid Elementor widget. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_SHG_Archive_Grid_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_core_shg_archive_grid'; }
    public function get_title() { return esc_html__( 'Amaley SHG Archive Grid', 'amaley-core' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'amaley-core-shg-archive-sections' ); }
    public function get_keywords() { return array( 'amaley', 'shg', 'archive', 'grid', 'collective' ); }

    private function defaults() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        return $renderer->grid_defaults();
    }

    protected function register_controls() {
        $d = $this->defaults();

        /** 1. Content */
        $this->start_controls_section( 'section_heading_content', array( 'label' => esc_html__( '1. Heading Content', 'amaley-core' ) ) );
        $this->add_control( 'show_section', array( 'label' => esc_html__( 'Show Section', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_section'] ) );
        $this->add_control( 'label', array( 'label' => esc_html__( 'Small Label', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['label'] ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Heading', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['title'], 'label_block' => true ) );
        $this->add_control( 'description', array( 'label' => esc_html__( 'Description', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => $d['description'] ) );
        $this->end_controls_section();

        /** 2. Show / Hide */
        $this->start_controls_section( 'section_show_hide', array( 'label' => esc_html__( '2. Show / Hide Elements', 'amaley-core' ) ) );
        $toggles = array(
            'show_label' => 'Show Heading Label',
            'show_title' => 'Show Heading',
            'show_description' => 'Show Heading Description',
            'show_images' => 'Show Image / Placeholder Area',
            'show_placeholder' => 'Show Placeholder When No Image',
            'show_verification_badge' => 'Show Verified Badge',
            'show_story' => 'Show Card Description',
            'show_cluster' => 'Show Cluster Detail',
            'show_location' => 'Show Location Detail',
            'show_member_count' => 'Show Members Detail',
            'show_verification_detail' => 'Show Status Detail Box',
            'show_contact' => 'Show Contact Detail',
            'show_product_tags' => 'Show Product/Work Tags',
            'show_button' => 'Show Card Button',
        );
        foreach ( $toggles as $key => $label ) {
            $this->add_control( $key, array( 'label' => esc_html( $label ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => isset( $d[ $key ] ) ? $d[ $key ] : '1' ) );
        }
        $this->end_controls_section();

        /** 3. Data */
        $this->start_controls_section( 'section_data_source', array( 'label' => esc_html__( '3. Data / Query / Source', 'amaley-core' ) ) );
        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of SHG Groups', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 80, 'default' => $d['limit'] ) );
        $this->add_control( 'cluster_id', array( 'label' => esc_html__( 'Filter by Cluster ID', 'amaley-core' ), 'description' => esc_html__( 'Leave blank to show all SHG groups.', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['cluster_id'] ) );
        $this->add_control( 'featured_only', array( 'label' => esc_html__( 'Featured Only', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['featured_only'] ) );
        $this->add_control( 'show_only_website', array( 'label' => esc_html__( 'Show Only Website-visible', 'amaley-core' ), 'description' => esc_html__( 'Keep off while old records do not have the visibility flag.', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => $d['show_only_website'] ) );
        $this->add_control( 'verification_status', array( 'label' => esc_html__( 'Verification Status', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $d['verification_status'], 'options' => array( '' => esc_html__( 'Any', 'amaley-core' ), 'verified' => esc_html__( 'Verified', 'amaley-core' ), 'pending' => esc_html__( 'Pending', 'amaley-core' ), 'review' => esc_html__( 'Review', 'amaley-core' ) ) ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $d['order_by'], 'options' => array( 'menu_order' => esc_html__( 'Menu Order + Title', 'amaley-core' ), 'title' => esc_html__( 'Title', 'amaley-core' ), 'date' => esc_html__( 'Date', 'amaley-core' ), 'modified' => esc_html__( 'Modified', 'amaley-core' ), 'rand' => esc_html__( 'Random', 'amaley-core' ) ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => $d['order'], 'options' => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ) ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty State Message', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['empty_message'], 'label_block' => true ) );
        $this->end_controls_section();

        /** 4. Links */
        $this->start_controls_section( 'section_links_routing', array( 'label' => esc_html__( '4. Links / Routing', 'amaley-core' ) ) );
        $this->add_control( 'detail_url_pattern', array( 'label' => esc_html__( 'Single Page URL Pattern', 'amaley-core' ), 'description' => esc_html__( 'Use {id}, {slug}, {cluster_id}. Example: /shg-detail/?shg_slug={slug}', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['detail_url_pattern'], 'label_block' => true ) );
        $this->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $d['button_text'] ) );
        $this->end_controls_section();

        /** 5. Card content controls */
        $this->start_controls_section( 'section_card_content', array( 'label' => esc_html__( '5. Card Template / Content Controls', 'amaley-core' ) ) );
        $this->add_control( 'card_template', array(
            'label' => esc_html__( 'Card Template', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => isset( $d['card_template'] ) ? $d['card_template'] : 'current_existing',
            'options' => array(
                'current_existing' => esc_html__( 'Current / Existing Card', 'amaley-core' ),
                'og_card_1' => esc_html__( 'OG SHG Card 1', 'amaley-core' ),
            ),
            'description' => esc_html__( 'Lightweight universal selector. No heavy OG full controls are added.', 'amaley-core' ),
        ) );
        $this->add_control( 'story_word_limit', array( 'label' => esc_html__( 'Description Words Per Card', 'amaley-core' ), 'description' => esc_html__( 'Controls how many words are printed before trimming.', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 4, 'max' => 60, 'default' => isset( $d['story_word_limit'] ) ? $d['story_word_limit'] : 16 ) );
        $this->add_control( 'max_tags', array( 'label' => esc_html__( 'Max Tags Per Card', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 10, 'default' => isset( $d['max_tags'] ) ? $d['max_tags'] : 3 ) );
        $this->end_controls_section();

        /** 6. Layout */
        $this->start_controls_section( 'section_layout', array( 'label' => esc_html__( '6. Layout / Responsive Columns', 'amaley-core' ) ) );
        $this->add_control( 'columns_desktop', array( 'label' => esc_html__( 'Columns Desktop', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 5, 'default' => $d['columns_desktop'] ) );
        $this->add_control( 'columns_tablet', array( 'label' => esc_html__( 'Columns Tablet', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 3, 'default' => $d['columns_tablet'] ) );
        $this->add_control( 'columns_mobile', array( 'label' => esc_html__( 'Columns Mobile', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 2, 'default' => $d['columns_mobile'] ) );
        $this->end_controls_section();

        /** 7. Section background */
        $this->start_controls_section( 'style_section_background', array( 'label' => esc_html__( '7. Section Background', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Section Background Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-grid-section' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'content_max_width', array( 'label' => esc_html__( 'Content Max Width', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1600 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-grid-section .amaley-core-shg-archive-wrap' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        /** 8. Section spacing */
        $this->start_controls_section( 'style_section_spacing', array( 'label' => esc_html__( '8. Section Spacing', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-grid-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'heading_bottom_gap', array( 'label' => esc_html__( 'Heading to Cards Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-grid-head' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'grid_gap', array( 'label' => esc_html__( 'Grid Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-cards-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        /** 9. Heading style */
        $this->start_controls_section( 'style_heading_label', array( 'label' => esc_html__( '9. Heading / Label Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'label' => esc_html__( 'Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-kicker' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'label' => esc_html__( 'Heading Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-section-title' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'heading_desc_typography', 'label' => esc_html__( 'Description Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-section-desc' ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-kicker' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-section-title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'heading_desc_color', array( 'label' => esc_html__( 'Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-section-desc' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        /** 10. Card style */
        $this->start_controls_section( 'style_card_box', array( 'label' => esc_html__( '10. Card / Box Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-card, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'card_border_color', array( 'label' => esc_html__( 'Card Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-card, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-card, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'card_body_padding', array( 'label' => esc_html__( 'Card Body Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em','%' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-body, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'card_inner_gap', array( 'label' => esc_html__( 'Card Inner Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 36 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-body, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__body' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();

        /** 11. Image style */
        $this->start_controls_section( 'style_image_placeholder', array( 'label' => esc_html__( '11. Image / Placeholder Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image / Placeholder Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 60, 'max' => 360 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-image, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__media' => 'height: {{SIZE}}{{UNIT}} !important; min-height: {{SIZE}}{{UNIT}} !important;', '{{WRAPPER}} .amaley-core-shg-archive-image img, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__media img' => 'height: {{SIZE}}{{UNIT}} !important; min-height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'image_opacity', array( 'label' => esc_html__( 'Image Opacity', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0.2, 'max' => 1, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-image img, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__media img' => 'opacity: {{SIZE}} !important;' ) ) );
        $this->add_responsive_control( 'placeholder_size', array( 'label' => esc_html__( 'Placeholder Circle Size', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 32, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-image-mark, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__initials' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'placeholder_bg', array( 'label' => esc_html__( 'Placeholder Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-image, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__media' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'verified_badge_bg', array( 'label' => esc_html__( 'Verified Badge Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-badge, {{WRAPPER}} .amaley-core-shg-badge-inline, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__badge, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__badge-inline' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'verified_badge_color', array( 'label' => esc_html__( 'Verified Badge Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-badge, {{WRAPPER}} .amaley-core-shg-badge-inline, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__badge, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__badge-inline' => 'color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();

        /** 12. Text style */
        $this->start_controls_section( 'style_card_text', array( 'label' => esc_html__( '12. Card Text Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_label_typography', 'label' => esc_html__( 'Card Label Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-card-label, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__label' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'label' => esc_html__( 'Card Title Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-archive-body h3, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__title' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_desc_typography', 'label' => esc_html__( 'Card Description Typography', 'amaley-core' ), 'selector' => '{{WRAPPER}} .amaley-core-shg-card-desc, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__excerpt' ) );
        $this->add_control( 'card_label_color', array( 'label' => esc_html__( 'Card Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-card-label, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__label' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-body h3, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__title' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'card_desc_color', array( 'label' => esc_html__( 'Card Description Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-card-desc, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__excerpt' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'description_line_clamp', array( 'label' => esc_html__( 'Description Line Clamp', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 6, 'default' => 2, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-card-desc, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__excerpt' => '-webkit-line-clamp: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();

        /** 13. Details */
        $this->start_controls_section( 'style_details_meta', array( 'label' => esc_html__( '13. Details / Meta Boxes Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'details_gap', array( 'label' => esc_html__( 'Details Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 28 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-detail-grid, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__meta' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'details_box_padding', array( 'label' => esc_html__( 'Details Box Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-detail-grid div, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__meta-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'details_box_bg', array( 'label' => esc_html__( 'Details Box Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-detail-grid div, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__meta-item' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'details_box_border', array( 'label' => esc_html__( 'Details Box Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-detail-grid div, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__meta-item' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'details_label_color', array( 'label' => esc_html__( 'Details Label Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-detail-grid dt, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__meta span' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'details_value_color', array( 'label' => esc_html__( 'Details Value Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-detail-grid dd, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__meta strong' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'details_line_clamp', array( 'label' => esc_html__( 'Details Value Line Clamp', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 4, 'default' => 2, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-detail-grid dd, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__meta strong' => '-webkit-line-clamp: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();

        /** 14. Tags */
        $this->start_controls_section( 'style_tags_badges', array( 'label' => esc_html__( '14. Tags / Badges Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'tag_gap', array( 'label' => esc_html__( 'Tag Gap', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-products, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__tags' => 'gap: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'tag_padding', array( 'label' => esc_html__( 'Tag Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-products span, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__tags span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'tag_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-products span, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__tags span' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'tag_color', array( 'label' => esc_html__( 'Tag Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-products span, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__tags span' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'tag_border_color', array( 'label' => esc_html__( 'Tag Border Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-products span, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__tags span' => 'border-color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();

        /** 15. Button */
        $this->start_controls_section( 'style_button', array( 'label' => esc_html__( '15. Button Style', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Button Padding', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px','em' ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-btn, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Button Radius', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-btn, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__button' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Button Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-btn, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__button' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_color', array( 'label' => esc_html__( 'Button Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-btn, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__button' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_hover_bg', array( 'label' => esc_html__( 'Button Hover Background', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-btn:hover, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__button:hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'button_hover_color', array( 'label' => esc_html__( 'Button Hover Text Color', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-btn:hover, {{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive .amaley-card__button:hover' => 'color: {{VALUE}} !important;' ) ) );
        $this->end_controls_section();

        /** 16. Responsive */
        $this->start_controls_section( 'style_responsive_fine', array( 'label' => esc_html__( '16. Responsive Fine Tuning', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'mobile_card_min_height', array( 'label' => esc_html__( 'Card Min Height', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 720 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-card, {{WRAPPER}} .amaley-card--shg-archive' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'mobile_force_one_column_note', array( 'type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => esc_html__( 'For phone, set Columns Mobile = 1. Use Image Height and Card Body Padding above for phone view.', 'amaley-core' ), 'content_classes' => 'elementor-panel-alert elementor-panel-alert-info' ) );
        $this->end_controls_section();


        $this->start_controls_section( 'alignment_controls', array( 'label' => esc_html__( 'Alignment Controls', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'grid_heading_align', array( 'label' => esc_html__( 'Heading Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-grid-head > div' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_text_align', array( 'label' => esc_html__( 'Card Text Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'amaley-core' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'amaley-core' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'amaley-core' ), 'icon' => 'eicon-text-align-right' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-body, {{WRAPPER}} .amaley-card--shg-archive .amaley-card__body' => 'text-align: {{VALUE}};', '{{WRAPPER}} .amaley-core-shg-detail-grid, {{WRAPPER}} .amaley-card--shg-archive .amaley-card__meta div, {{WRAPPER}} .amaley-card--shg-archive .amaley-card__meta-item' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_button_align', array( 'label' => esc_html__( 'Card Button Alignment', 'amaley-core' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => esc_html__( 'Default', 'amaley-core' ), 'flex-start' => esc_html__( 'Left', 'amaley-core' ), 'center' => esc_html__( 'Center', 'amaley-core' ), 'flex-end' => esc_html__( 'Right', 'amaley-core' ), 'stretch' => esc_html__( 'Full Width', 'amaley-core' ) ), 'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-btn, {{WRAPPER}} .amaley-card--shg-archive .amaley-card__button' => 'align-self: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'motion_style', array( 'label' => esc_html__( 'Animation / Micro Motion', 'amaley-core' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'motion_mode', array(
            'label' => esc_html__( 'Section Animation', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'on',
            'options' => array( 'on' => esc_html__( 'On', 'amaley-core' ), 'off' => esc_html__( 'Off', 'amaley-core' ) ),
            'prefix_class' => 'amaley-core-motion-'
        ) );
        $this->add_control( 'motion_duration', array(
            'label' => esc_html__( 'Animation Duration', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'ms' ),
            'range' => array( 'ms' => array( 'min' => 150, 'max' => 900, 'step' => 50 ) ),
            'default' => array( 'size' => 520, 'unit' => 'ms' ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-duration: {{SIZE}}ms;' )
        ) );
        $this->add_control( 'motion_distance', array(
            'label' => esc_html__( 'Animation Lift Distance', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 18 ) ),
            'default' => array( 'size' => 6, 'unit' => 'px' ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-motion-y: {{SIZE}}px;' )
        ) );
        $this->add_control( 'hover_lift', array(
            'label' => esc_html__( 'Hover Lift', 'amaley-core' ),
            'description' => esc_html__( 'Keep 1–3px for smooth premium motion. Use 0 to disable lift.', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array( 'px' => array( 'min' => 0, 'max' => 8 ) ),
            'default' => array( 'size' => 2, 'unit' => 'px' ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-hover-lift: {{SIZE}}px;' )
        ) );
        $this->add_control( 'hover_scale', array(
            'label' => esc_html__( 'Hover Scale', 'amaley-core' ),
            'description' => esc_html__( 'Use Soft for smooth movement. Set None if the page feels heavy.', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '1.003',
            'options' => array( '1' => esc_html__( 'None', 'amaley-core' ), '1.003' => esc_html__( 'Soft', 'amaley-core' ), '1.006' => esc_html__( 'Medium', 'amaley-core' ), '1.01' => esc_html__( 'Strong', 'amaley-core' ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-hover-scale: {{VALUE}};' )
        ) );
        $this->add_control( 'image_hover_zoom', array(
            'label' => esc_html__( 'Image Hover Zoom', 'amaley-core' ),
            'description' => esc_html__( 'Controls card image/placeholder zoom on hover.', 'amaley-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '1.018',
            'options' => array( '1' => esc_html__( 'None', 'amaley-core' ), '1.012' => esc_html__( 'Very Soft', 'amaley-core' ), '1.018' => esc_html__( 'Soft', 'amaley-core' ), '1.035' => esc_html__( 'Visible', 'amaley-core' ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-core-shg-archive-section' => '--acore-image-zoom: {{VALUE}};' )
        ) );
        $this->end_controls_section();

    }

    protected function render() {
        $renderer = isset( $GLOBALS['amaley_core_shg_archive_sections'] ) ? $GLOBALS['amaley_core_shg_archive_sections'] : new Amaley_Core_SHG_Archive_Sections();
        echo $renderer->render_grid( $this->get_settings_for_display() );
    }
}
