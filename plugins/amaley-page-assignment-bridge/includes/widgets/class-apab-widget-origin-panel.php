<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APAB_Widget_Origin_Panel extends APAB_Widget_Base {

    public function get_name() { return 'apab_origin_panel'; }
    public function get_title() { return esc_html__( 'Amaley Bridge Origin Panel', 'amaley-page-assignment-bridge' ); }
    public function get_icon() { return 'eicon-map-pin'; }

    protected function register_controls() {
        $this->start_controls_section( 'content', array( 'label' => 'Field Mapping' ) );
        $this->add_control( 'kicker', array( 'label' => 'Kicker', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Origin' ) );
        $this->add_control( 'title', array( 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'From source to shelf' ) );
        $this->add_control( 'field_origin_short_line', array( 'label' => 'Origin Short Line Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'origin_short_line' ) );
        $this->add_control( 'field_cluster', array( 'label' => 'Linked Cluster Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'linked_cluster' ) );
        $this->add_control( 'field_shg', array( 'label' => 'Linked SHG Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'linked_shg_group' ) );
        $this->add_control( 'field_maker', array( 'label' => 'Linked Producer/Maker Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'linked_producer_maker' ) );
        $this->add_control( 'field_village', array( 'label' => 'Village Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'village_source_location' ) );
        $this->add_control( 'field_region', array( 'label' => 'Region Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'region_source_belt' ) );
        $this->add_control( 'field_batch', array( 'label' => 'Batch Type Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'batch_type' ) );
        $this->add_control( 'field_season', array( 'label' => 'Season Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'harvest_collection_season' ) );
        $this->add_control( 'field_processing', array( 'label' => 'Processing Method Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'processing_method' ) );
        $this->add_control( 'field_traceability', array( 'label' => 'Traceability Note Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'traceability_note' ) );
        $this->add_control( 'field_quote', array( 'label' => 'Producer Quote Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'producer_quote_maker_note' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style', array( 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .apab-origin-panel__title' ) );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $product  = $this->current_product();
        if ( ! $product ) {
            $this->editor_notice();
            return;
        }
        $id = $product->get_id();

        $origin = APAB_Product_Context::origin_data( $id, array(
            'origin_short' => $settings['field_origin_short_line'],
            'cluster'      => $settings['field_cluster'],
            'shg'          => $settings['field_shg'],
            'maker'        => $settings['field_maker'],
            'village'      => $settings['field_village'],
            'region'       => $settings['field_region'],
            'batch'        => $settings['field_batch'],
            'season'       => $settings['field_season'],
            'processing'   => $settings['field_processing'],
            'traceability' => $settings['field_traceability'],
            'quote'        => $settings['field_quote'],
        ) );

        $rows = array(
            array( 'Cluster', isset( $origin['cluster_html'] ) ? $origin['cluster_html'] : '', ! empty( $origin['cluster_ids'][0] ) ? $origin['cluster_ids'][0] : 0 ),
            array( 'SHG', isset( $origin['shg_html'] ) ? $origin['shg_html'] : '', ! empty( $origin['shg_ids'][0] ) ? $origin['shg_ids'][0] : 0 ),
            array( 'Producer', isset( $origin['maker_html'] ) ? $origin['maker_html'] : '', ! empty( $origin['maker_ids'][0] ) ? $origin['maker_ids'][0] : 0 ),
            array( 'Village / Source', ! empty( $origin['source_village'] ) ? esc_html( $origin['source_village'] ) : '', ! empty( $origin['source_village'] ) ? $origin['source_village'] : '' ),
            array( 'Region / Belt', ! empty( $origin['region'] ) ? esc_html( $origin['region'] ) : '', ! empty( $origin['region'] ) ? $origin['region'] : '' ),
            array( 'Batch Type', ! empty( $origin['batch_type'] ) ? esc_html( $origin['batch_type'] ) : '', ! empty( $origin['batch_type'] ) ? $origin['batch_type'] : '' ),
            array( 'Season', ! empty( $origin['season'] ) ? esc_html( $origin['season'] ) : '', ! empty( $origin['season'] ) ? $origin['season'] : '' ),
        );

        echo '<section class="apab-origin-panel">';
        echo '<div class="apab-origin-panel__head"><span>' . esc_html( $settings['kicker'] ) . '</span><h2 class="apab-origin-panel__title">' . esc_html( $settings['title'] ) . '</h2>';
        if ( ! empty( $origin['origin_short'] ) ) {
            echo '<p>' . esc_html( $origin['origin_short'] ) . '</p>';
        }
        echo '</div>';

        $has_rows = false;
        foreach ( $rows as $row ) {
            if ( ! empty( $row[1] ) ) {
                $has_rows = true;
                break;
            }
        }

        if ( $has_rows ) {
            echo '<div class="apab-origin-panel__grid">';
            foreach ( $rows as $row ) {
                if ( empty( $row[1] ) ) {
                    continue;
                }
                echo '<div class="apab-origin-panel__item">' . $this->render_origin_icon( $row[2], $row[0] ) . '<div><span>' . esc_html( $row[0] ) . '</span><strong>' . wp_kses_post( $row[1] ) . '</strong></div></div>';
            }
            echo '</div>';
        }

        if ( ! empty( $origin['traceability_note'] ) || ! empty( $origin['processing_method'] ) || ! empty( $origin['producer_quote'] ) ) {
            echo '<div class="apab-origin-panel__story">';
            if ( ! empty( $origin['traceability_note'] ) ) {
                echo '<p>' . esc_html( $origin['traceability_note'] ) . '</p>';
            }
            if ( ! empty( $origin['processing_method'] ) ) {
                echo '<p><strong>Processing:</strong> ' . esc_html( $origin['processing_method'] ) . '</p>';
            }
            if ( ! empty( $origin['producer_quote'] ) ) {
                echo '<blockquote>' . esc_html( $origin['producer_quote'] ) . '</blockquote>';
            }
            echo '</div>';
        }
        echo '</section>';
    }

}
