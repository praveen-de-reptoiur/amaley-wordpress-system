<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Tpl_Origin_Panel_Widget extends Amaley_Tpl_Widget_Base {

    public function get_name() {
        return 'amaley_tpl_origin_panel';
    }

    public function get_title() {
        return esc_html__( 'Amaley Templates Product Origin Panel', 'amaley-templates' );
    }

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return array( 'amaley-templates' );
    }


    public function get_keywords() {
        return array( 'amaley templates', 'amaley', 'templates', 'product', 'single', 'woocommerce' );
    }

    protected function register_controls() {
        $this->start_controls_section( 'content_section', array( 'label' => esc_html__( 'Content / Field Mapping', 'amaley-templates' ) ) );

        $this->add_control( 'kicker', array( 'label' => esc_html__( 'Kicker', 'amaley-templates' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $this->tpl_setting( 'single_product.origin_label', 'Traceable Origin' ) ) );
        $this->add_control( 'title', array( 'label' => esc_html__( 'Title', 'amaley-templates' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'From source to shelf' ) );

        $this->add_field_name_controls( array(
            'field_origin_short_line' => array( 'label' => 'Origin Short Line Field', 'default' => $this->tpl_setting( 'single_product.origin_short_line', 'origin_short_line' ) ),
            'field_cluster' => array( 'label' => 'Linked Cluster Field', 'default' => $this->tpl_setting( 'single_product.linked_cluster', 'linked_cluster' ) ),
            'field_shg' => array( 'label' => 'Linked SHG Group Field', 'default' => $this->tpl_setting( 'single_product.linked_shg_group', 'linked_shg_group' ) ),
            'field_maker' => array( 'label' => 'Linked Producer/Maker Field', 'default' => $this->tpl_setting( 'single_product.linked_producer_maker', 'linked_producer_maker' ) ),
            'field_village' => array( 'label' => 'Village / Source Location Field', 'default' => $this->tpl_setting( 'single_product.village_source_location', 'village_source_location' ) ),
            'field_region' => array( 'label' => 'Region / Source Belt Field', 'default' => $this->tpl_setting( 'single_product.region_source_belt', 'region_source_belt' ) ),
            'field_batch' => array( 'label' => 'Batch Type Field', 'default' => $this->tpl_setting( 'single_product.batch_type', 'batch_type' ) ),
            'field_season' => array( 'label' => 'Harvest / Collection Season Field', 'default' => $this->tpl_setting( 'single_product.harvest_collection_season', 'harvest_collection_season' ) ),
            'field_processing' => array( 'label' => 'Processing Method Field', 'default' => $this->tpl_setting( 'single_product.processing_method', 'processing_method' ) ),
            'field_traceability' => array( 'label' => 'Traceability Note Field', 'default' => $this->tpl_setting( 'single_product.traceability_note', 'traceability_note' ) ),
            'field_quote' => array( 'label' => 'Producer Quote / Maker Note Field', 'default' => $this->tpl_setting( 'single_product.producer_quote_maker_note', 'producer_quote_maker_note' ) ),
        ) );

        $this->end_controls_section();

        $this->start_controls_section( 'style_panel', array( 'label' => esc_html__( 'Panel / Header', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'panel_bg', array( 'label' => 'Panel Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'panel_border', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel' ) );
        $this->add_responsive_control( 'panel_padding', array( 'label' => 'Panel Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'kicker_color', array( 'label' => 'Kicker Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__head span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__head h2' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__head h2' ) );
        $this->add_control( 'intro_color', array( 'label' => 'Intro Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__head p' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_cards', array( 'label' => esc_html__( 'Cards / Icons', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => 'Card Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'card_bg', array( 'label' => 'Card Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__item' ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => 'Card Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'card_radius', array( 'label' => 'Card Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'icon_size', array( 'label' => 'Icon Size', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 20, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'icon_bg', array( 'label' => 'Icon Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_color', array( 'label' => 'Icon Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'label_color', array( 'label' => 'Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__label' ) );
        $this->add_control( 'value_color', array( 'label' => 'Value Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item strong, {{WRAPPER}} .amaley-tpl-origin-panel__item a' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'card_hover_bg', array( 'label' => 'Card Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'card_hover_border_color', array( 'label' => 'Card Hover Border', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_bg', array( 'label' => 'Icon Hover Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover .amaley-tpl-origin-panel__icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'icon_hover_color', array( 'label' => 'Icon Hover Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover .amaley-tpl-origin-panel__icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'value_hover_color', array( 'label' => 'Value Hover Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__item:hover strong, {{WRAPPER}} .amaley-tpl-origin-panel__item:hover a' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'value_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__item strong, {{WRAPPER}} .amaley-tpl-origin-panel__item a' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_story', array( 'label' => esc_html__( 'Story / Quote', 'amaley-templates' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'story_text_color', array( 'label' => 'Story Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story p' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'story_divider_color', array( 'label' => 'Story Divider', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'story_typography', 'selector' => '{{WRAPPER}} .amaley-tpl-origin-panel__story p' ) );
        $this->add_control( 'quote_bg', array( 'label' => 'Quote Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'quote_color', array( 'label' => 'Quote Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'quote_accent', array( 'label' => 'Quote Accent', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'border-left-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'quote_padding', array( 'label' => 'Quote Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-tpl-origin-panel__story blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $product  = $this->current_product();

        if ( ! $product ) {
            $this->fallback_product_message();
            return;
        }

        $id = $product->get_id();
        $cluster_raw = $this->acf_value( $settings['field_cluster'], $id );
        $shg_raw     = $this->acf_value( $settings['field_shg'], $id );
        $maker_raw   = $this->acf_value( $settings['field_maker'], $id );
        $village_raw = $this->text_value( $this->acf_value( $settings['field_village'], $id ) );
        $region_raw  = $this->text_value( $this->acf_value( $settings['field_region'], $id ) );
        $batch_raw   = $this->text_value( $this->acf_value( $settings['field_batch'], $id ) );
        $season_raw  = $this->text_value( $this->acf_value( $settings['field_season'], $id ) );

        $rows = array(
            array( 'label' => 'Cluster', 'value' => $this->post_object_link( $cluster_raw ), 'raw' => $cluster_raw ),
            array( 'label' => 'SHG Group', 'value' => $this->post_object_link( $shg_raw ), 'raw' => $shg_raw ),
            array( 'label' => 'Producer / Maker', 'value' => $this->post_object_link( $maker_raw ), 'raw' => $maker_raw ),
            array( 'label' => 'Village / Source', 'value' => esc_html( $village_raw ), 'raw' => $village_raw ),
            array( 'label' => 'Region / Belt', 'value' => esc_html( $region_raw ), 'raw' => $region_raw ),
            array( 'label' => 'Batch Type', 'value' => esc_html( $batch_raw ), 'raw' => $batch_raw ),
            array( 'label' => 'Season', 'value' => esc_html( $season_raw ), 'raw' => $season_raw ),
        );

        $origin = $this->text_value( $this->acf_value( $settings['field_origin_short_line'], $id ) );
        $processing = $this->text_value( $this->acf_value( $settings['field_processing'], $id ) );
        $trace = $this->text_value( $this->acf_value( $settings['field_traceability'], $id ) );
        $quote = $this->text_value( $this->acf_value( $settings['field_quote'], $id ) );
        ?>
        <section class="amaley-tpl-origin-panel">
            <div class="amaley-tpl-origin-panel__head">
                <span><?php echo esc_html( $settings['kicker'] ); ?></span>
                <h2><?php echo esc_html( $settings['title'] ); ?></h2>
                <?php if ( $origin ) : ?><p><?php echo esc_html( $origin ); ?></p><?php endif; ?>
            </div>

            <div class="amaley-tpl-origin-panel__grid">
                <?php foreach ( $rows as $row ) : ?>
                    <?php $this->render_origin_item( $row['label'], $row['value'], $row['raw'] ); ?>
                <?php endforeach; ?>
            </div>

            <?php if ( $trace || $processing || $quote ) : ?>
                <div class="amaley-tpl-origin-panel__story">
                    <?php if ( $trace ) : ?><p><?php echo esc_html( $trace ); ?></p><?php endif; ?>
                    <?php if ( $processing ) : ?><p><strong>Processing:</strong> <?php echo esc_html( $processing ); ?></p><?php endif; ?>
                    <?php if ( $quote ) : ?><blockquote><?php echo esc_html( $quote ); ?></blockquote><?php endif; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php
    }
}
