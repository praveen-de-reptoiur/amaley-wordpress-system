<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Tpl_Info_Tabs_Widget extends Amaley_Tpl_Widget_Base {

    public function get_name() {
        return 'amaley_tpl_info_tabs';
    }

    public function get_title() {
        return esc_html__( 'Amaley Templates Product Info Tabs', 'amaley-templates' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return array( 'amaley-templates' );
    }

    public function get_keywords() {
        return array( 'amaley templates', 'amaley', 'templates', 'product', 'single', 'woocommerce', 'origin', 'tabs', 'traceability' );
    }

    protected function register_controls() {
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( 'Tabs / Labels', 'amaley-templates' ) ) );

        $this->add_control( 'details_label', array( 'label' => 'Details Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'single_product.details_label', 'Details' ) ) );
        $this->add_control( 'origin_label', array( 'label' => 'Origin Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'single_product.origin_label', 'Origin' ) ) );
        $this->add_control( 'how_label', array( 'label' => 'How to Use Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'single_product.how_to_use_label', 'How to Use' ) ) );
        $this->add_control( 'reviews_label', array( 'label' => 'Reviews Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'single_product.reviews_label', 'Reviews' ) ) );

        $this->end_controls_section();

        $this->start_controls_section( 'origin_tab_section', array( 'label' => esc_html__( 'Origin Tab Content', 'amaley-templates' ) ) );

        $this->add_control( 'origin_kicker', array(
            'label'       => esc_html__( 'Origin Kicker', 'amaley-templates' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $this->tpl_setting( 'single_product.origin_label', 'Origin' ),
            'label_block' => true,
        ) );

        $this->add_control( 'origin_title', array(
            'label'       => esc_html__( 'Origin Title', 'amaley-templates' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'From source to shelf',
            'label_block' => true,
        ) );

        $this->add_field_name_controls( array(
            'field_origin_short_line' => array( 'label' => 'Origin Short Line Field', 'default' => $this->tpl_setting( 'single_product.origin_short_line', 'origin_short_line' ) ),
            'field_cluster'           => array( 'label' => 'Linked Cluster Field', 'default' => $this->tpl_setting( 'single_product.linked_cluster', 'linked_cluster' ) ),
            'field_shg'               => array( 'label' => 'Linked SHG Group Field', 'default' => $this->tpl_setting( 'single_product.linked_shg_group', 'linked_shg_group' ) ),
            'field_maker'             => array( 'label' => 'Linked Producer/Maker Field', 'default' => $this->tpl_setting( 'single_product.linked_producer_maker', 'linked_producer_maker' ) ),
            'field_village'           => array( 'label' => 'Village / Source Location Field', 'default' => $this->tpl_setting( 'single_product.village_source_location', 'village_source_location' ) ),
            'field_region'            => array( 'label' => 'Region / Source Belt Field', 'default' => $this->tpl_setting( 'single_product.region_source_belt', 'region_source_belt' ) ),
            'field_batch'             => array( 'label' => 'Batch Type Field', 'default' => $this->tpl_setting( 'single_product.batch_type', 'batch_type' ) ),
            'field_season'            => array( 'label' => 'Harvest / Collection Season Field', 'default' => $this->tpl_setting( 'single_product.harvest_collection_season', 'harvest_collection_season' ) ),
            'field_processing'        => array( 'label' => 'Processing Method Field', 'default' => $this->tpl_setting( 'single_product.processing_method', 'processing_method' ) ),
            'field_traceability'      => array( 'label' => 'Traceability Note Field', 'default' => $this->tpl_setting( 'single_product.traceability_note', 'traceability_note' ) ),
            'field_quote'             => array( 'label' => 'Producer Quote / Maker Note Field', 'default' => $this->tpl_setting( 'single_product.producer_quote_maker_note', 'producer_quote_maker_note' ) ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'details_usage_section', array( 'label' => esc_html__( 'Details / How to Use Fields', 'amaley-templates' ) ) );

        $this->add_field_name_controls( array(
            'field_ingredients' => array( 'label' => 'Ingredients Note Field', 'default' => $this->tpl_setting( 'single_product.ingredients_note', 'ingredients_note' ) ),
            'field_how'         => array( 'label' => 'How to Use Field', 'default' => $this->tpl_setting( 'single_product.how_to_use', 'how_to_use' ) ),
            'field_storage'     => array( 'label' => 'Storage Instructions Field', 'default' => $this->tpl_setting( 'single_product.storage_instructions', 'storage_instructions' ) ),
            'field_shelf'       => array( 'label' => 'Shelf Life Field', 'default' => $this->tpl_setting( 'single_product.shelf_life', 'shelf_life' ) ),
            'field_allergen'    => array( 'label' => 'Allergen Note Field', 'default' => $this->tpl_setting( 'single_product.allergen_note', 'allergen_note' ) ),
        ) );

        $this->end_controls_section();

        /* -------------------- STYLE: TAB NAVIGATION -------------------- */
        $this->start_controls_section( 'style_tab_nav', array( 'label' => esc_html__( 'Tab Navigation', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'nav_bg', array( 'label' => 'Nav Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'nav_border_color', array( 'label' => 'Nav Bottom Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'nav_gap', array( 'label' => 'Tab Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tab_padding', array( 'label' => 'Tab Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'tab_color', array( 'label' => 'Tab Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tab_active_color', array( 'label' => 'Active Tab Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav button.is-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};' ) ) );
        $this->add_control( 'tab_hover_color', array( 'label' => 'Hover Tab Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav button:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tab_hover_bg', array( 'label' => 'Hover Tab Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav button:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'tab_hover_border_color', array( 'label' => 'Hover Tab Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav button:hover' => 'border-bottom-color: {{VALUE}};' ) ) );
        $this->add_control( 'tab_active_bg', array( 'label' => 'Active Tab Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__nav button.is-active' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'tab_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-info-tabs__nav button' ) );

        $this->end_controls_section();

        /* -------------------- STYLE: PANEL -------------------- */
        $this->start_controls_section( 'style_panel', array( 'label' => esc_html__( 'Panel / Body Text', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'panel_bg', array( 'label' => 'Panel Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'panel_text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'panel_padding', array( 'label' => 'Panel Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'panel_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-info-tabs__panel' ) );

        $this->end_controls_section();

        /* -------------------- STYLE: DETAILS TABLE -------------------- */
        $this->start_controls_section( 'style_details_table', array( 'label' => esc_html__( 'Details Table', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'table_border_color', array( 'label' => 'Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel td' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'table_cell_padding', array( 'label' => 'Cell Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'table_label_color', array( 'label' => 'Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel td:first-child' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'table_value_color', array( 'label' => 'Value Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel td:last-child' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'table_row_hover_bg', array( 'label' => 'Row Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel tr:hover td' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'table_row_hover_color', array( 'label' => 'Row Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-info-tabs__panel tr:hover td' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'table_label_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-info-tabs__panel td:first-child' ) );

        $this->end_controls_section();

        /* -------------------- STYLE: ORIGIN HEADER -------------------- */
        $this->start_controls_section( 'style_origin_head', array( 'label' => esc_html__( 'Origin Header', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'origin_panel_bg', array( 'label' => 'Origin Area Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'origin_panel_border', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel' ) );
        $this->add_responsive_control( 'origin_panel_padding', array( 'label' => 'Origin Area Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'origin_kicker_color', array( 'label' => 'Kicker Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__head span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__head h2' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'origin_title_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__head h2' ) );
        $this->add_control( 'origin_intro_color', array( 'label' => 'Intro Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__head p' => 'color: {{VALUE}};' ) ) );

        $this->end_controls_section();

        /* -------------------- STYLE: ORIGIN CARDS / ICONS -------------------- */
        $this->start_controls_section( 'style_origin_cards', array( 'label' => esc_html__( 'Origin Cards / Icons', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_responsive_control( 'origin_card_gap', array( 'label' => 'Card Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'origin_card_bg', array( 'label' => 'Card Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'origin_card_border', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__item' ) );
        $this->add_responsive_control( 'origin_card_padding', array( 'label' => 'Card Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'origin_card_radius', array( 'label' => 'Card Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'origin_icon_size', array( 'label' => 'Icon Size', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 20, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'origin_icon_bg', array( 'label' => 'Icon Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'origin_icon_color', array( 'label' => 'Icon Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_label_color', array( 'label' => 'Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'origin_label_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__label' ) );
        $this->add_control( 'origin_value_color', array( 'label' => 'Value Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item strong, {{WRAPPER}} .amaley-tpl-origin-panel__item a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_card_hover_bg', array( 'label' => 'Card Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'origin_card_hover_border_color', array( 'label' => 'Card Hover Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_icon_hover_bg', array( 'label' => 'Icon Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover .amaley-tpl-origin-panel__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'origin_icon_hover_color', array( 'label' => 'Icon Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover .amaley-tpl-origin-panel__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_value_hover_color', array( 'label' => 'Value Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover strong, {{WRAPPER}} .amaley-tpl-origin-panel__item:hover a' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'origin_value_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__item strong, {{WRAPPER}} .amaley-tpl-origin-panel__item a' ) );

        $this->end_controls_section();

        /* -------------------- STYLE: ORIGIN STORY / QUOTE -------------------- */
        $this->start_controls_section( 'style_origin_story', array( 'label' => esc_html__( 'Origin Story / Quote', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );

        $this->add_control( 'story_border_color', array( 'label' => 'Story Divider Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'story_text_color', array( 'label' => 'Story Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story p' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'story_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__story p' ) );
        $this->add_control( 'quote_bg', array( 'label' => 'Quote Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'quote_text_color', array( 'label' => 'Quote Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'quote_border_color', array( 'label' => 'Quote Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'border-left-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'quote_padding', array( 'label' => 'Quote Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'quote_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' ) );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $product  = $this->current_product();

        if ( ! $product ) {
            $this->fallback_product_message();
            return;
        }

        $id          = $product->get_id();
        $uid         = 'amaley-tpl-tabs-' . $this->get_id();
        $ingredients = $this->text_value( $this->acf_value( $settings['field_ingredients'], $id ) );
        $how         = $this->text_value( $this->acf_value( $settings['field_how'], $id ) );
        $storage     = $this->text_value( $this->acf_value( $settings['field_storage'], $id ) );
        $shelf       = $this->text_value( $this->acf_value( $settings['field_shelf'], $id ) );
        $allergen    = $this->text_value( $this->acf_value( $settings['field_allergen'], $id ) );
        ?>
        <section class="amaley-tpl-info-tabs" id="<?php echo esc_attr( $uid ); ?>">
            <div class="amaley-tpl-info-tabs__nav" role="tablist">
                <button type="button" class="is-active" data-amaley-tab="details"><?php echo esc_html( $settings['details_label'] ); ?></button>
                <button type="button" data-amaley-tab="origin"><?php echo esc_html( $settings['origin_label'] ); ?></button>
                <button type="button" data-amaley-tab="how"><?php echo esc_html( $settings['how_label'] ); ?></button>
                <button type="button" data-amaley-tab="reviews"><?php echo esc_html( $settings['reviews_label'] ); ?></button>
            </div>

            <div class="amaley-tpl-info-tabs__panel is-active" data-amaley-panel="details">
                <?php if ( $product->get_description() ) : ?>
                    <?php echo wp_kses_post( apply_filters( 'the_content', $product->get_description() ) ); ?>
                <?php endif; ?>

                <table>
                    <?php if ( $ingredients ) : ?><tr><td>Ingredients</td><td><?php echo esc_html( $ingredients ); ?></td></tr><?php endif; ?>
                    <?php if ( $shelf ) : ?><tr><td>Shelf Life</td><td><?php echo esc_html( $shelf ); ?></td></tr><?php endif; ?>
                    <?php if ( $allergen ) : ?><tr><td>Allergen Note</td><td><?php echo esc_html( $allergen ); ?></td></tr><?php endif; ?>
                </table>
            </div>

            <div class="amaley-tpl-info-tabs__panel" data-amaley-panel="origin">
                <?php $this->render_origin_content_inside_tab( $settings, $id ); ?>
            </div>

            <div class="amaley-tpl-info-tabs__panel" data-amaley-panel="how">
                <?php if ( $how ) : ?><p><?php echo esc_html( $how ); ?></p><?php endif; ?>
                <?php if ( $storage ) : ?><p><strong>Storage:</strong> <?php echo esc_html( $storage ); ?></p><?php endif; ?>
                <?php if ( ! $how && ! $storage ) : ?><p>Usage and storage guidance will appear here once added in the product backend.</p><?php endif; ?>
            </div>

            <div class="amaley-tpl-info-tabs__panel" data-amaley-panel="reviews">
                <?php
                if ( function_exists( 'woocommerce_product_reviews_tab' ) ) {
                    woocommerce_product_reviews_tab();
                } else {
                    echo '<p>Reviews will appear here when WooCommerce reviews are enabled.</p>';
                }
                ?>
            </div>
        </section>
        <?php
    }

    private function render_origin_content_inside_tab( $settings, $product_id ) {
        $cluster_raw = $this->acf_value( $settings['field_cluster'], $product_id );
        $shg_raw     = $this->acf_value( $settings['field_shg'], $product_id );
        $maker_raw   = $this->acf_value( $settings['field_maker'], $product_id );
        $village_raw = $this->text_value( $this->acf_value( $settings['field_village'], $product_id ) );
        $region_raw  = $this->text_value( $this->acf_value( $settings['field_region'], $product_id ) );
        $batch_raw   = $this->text_value( $this->acf_value( $settings['field_batch'], $product_id ) );
        $season_raw  = $this->text_value( $this->acf_value( $settings['field_season'], $product_id ) );

        $rows = array(
            array( 'label' => 'Cluster', 'value' => $this->post_object_link( $cluster_raw ), 'raw' => $cluster_raw ),
            array( 'label' => 'SHG Group', 'value' => $this->post_object_link( $shg_raw ), 'raw' => $shg_raw ),
            array( 'label' => 'Producer / Maker', 'value' => $this->post_object_link( $maker_raw ), 'raw' => $maker_raw ),
            array( 'label' => 'Village / Source', 'value' => esc_html( $village_raw ), 'raw' => $village_raw ),
            array( 'label' => 'Region / Belt', 'value' => esc_html( $region_raw ), 'raw' => $region_raw ),
            array( 'label' => 'Batch Type', 'value' => esc_html( $batch_raw ), 'raw' => $batch_raw ),
            array( 'label' => 'Season', 'value' => esc_html( $season_raw ), 'raw' => $season_raw ),
        );

        $origin     = $this->text_value( $this->acf_value( $settings['field_origin_short_line'], $product_id ) );
        $processing = $this->text_value( $this->acf_value( $settings['field_processing'], $product_id ) );
        $trace      = $this->text_value( $this->acf_value( $settings['field_traceability'], $product_id ) );
        $quote      = $this->text_value( $this->acf_value( $settings['field_quote'], $product_id ) );
        $has_rows   = false;

        foreach ( $rows as $row ) {
            if ( ! empty( $row['value'] ) ) {
                $has_rows = true;
                break;
            }
        }

        if ( ! $origin && ! $has_rows && ! $trace && ! $processing && ! $quote ) {
            echo '<p>Origin details will appear here once added in the product backend.</p>';
            return;
        }
        ?>
        <div class="amaley-tpl-origin-panel amaley-tpl-origin-panel--inside-tabs">
            <div class="amaley-tpl-origin-panel__head">
                <span><?php echo esc_html( $settings['origin_kicker'] ); ?></span>
                <h2><?php echo esc_html( $settings['origin_title'] ); ?></h2>
                <?php if ( $origin ) : ?><p><?php echo esc_html( $origin ); ?></p><?php endif; ?>
            </div>

            <?php if ( $has_rows ) : ?>
                <div class="amaley-tpl-origin-panel__grid">
                    <?php foreach ( $rows as $row ) : ?>
                        <?php $this->render_origin_item( $row['label'], $row['value'], $row['raw'] ); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( $trace || $processing || $quote ) : ?>
                <div class="amaley-tpl-origin-panel__story">
                    <?php if ( $trace ) : ?><p><?php echo esc_html( $trace ); ?></p><?php endif; ?>
                    <?php if ( $processing ) : ?><p><strong>Processing:</strong> <?php echo esc_html( $processing ); ?></p><?php endif; ?>
                    <?php if ( $quote ) : ?><blockquote><?php echo esc_html( $quote ); ?></blockquote><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
