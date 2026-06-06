<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class APAB_Widget_Info_Tabs extends APAB_Widget_Base {

    public function get_name() { return 'apab_info_tabs'; }
    public function get_title() { return esc_html__( 'Amaley Bridge Info Tabs', 'amaley-page-assignment-bridge' ); }
    public function get_icon() { return 'eicon-tabs'; }

    protected function register_controls() {
        /* -------------------- CONTENT: MAIN -------------------- */
        $this->start_controls_section( 'section_main', array( 'label' => esc_html__( 'Info Tabs / Main', 'amaley-page-assignment-bridge' ) ) );

        $this->add_control( 'show_section', array(
            'label'        => esc_html__( 'Show Info Tabs Section', 'amaley-page-assignment-bridge' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'amaley-page-assignment-bridge' ),
            'label_off'    => esc_html__( 'No', 'amaley-page-assignment-bridge' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ) );

        $this->add_control( 'details_label', array( 'label' => esc_html__( 'Details Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Details' ) );
        $this->add_control( 'origin_label', array( 'label' => esc_html__( 'Origin Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Origin' ) );
        $this->add_control( 'how_label', array( 'label' => esc_html__( 'How To Use Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'How To Use' ) );
        $this->add_control( 'reviews_label', array( 'label' => esc_html__( 'Reviews Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Reviews' ) );

        $this->add_control( 'default_active_tab', array(
            'label'   => esc_html__( 'Default Active Tab', 'amaley-page-assignment-bridge' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'details',
            'options' => array(
                'details' => esc_html__( 'Details', 'amaley-page-assignment-bridge' ),
                'origin'  => esc_html__( 'Origin', 'amaley-page-assignment-bridge' ),
                'how'     => esc_html__( 'How To Use', 'amaley-page-assignment-bridge' ),
                'reviews' => esc_html__( 'Reviews', 'amaley-page-assignment-bridge' ),
            ),
        ) );

        $this->add_control( 'show_details_tab', array( 'label' => esc_html__( 'Show Details Tab', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_origin_tab', array( 'label' => esc_html__( 'Show Origin Tab', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_how_tab', array( 'label' => esc_html__( 'Show How To Use Tab', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_reviews_tab', array( 'label' => esc_html__( 'Show Reviews Tab', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );

        $this->end_controls_section();

        /* -------------------- CONTENT: DETAILS -------------------- */
        $this->start_controls_section( 'section_details_content', array( 'label' => esc_html__( 'Details Tab', 'amaley-page-assignment-bridge' ) ) );
        $this->add_control( 'show_description', array( 'label' => esc_html__( 'Show Product Description', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_ingredients', array( 'label' => esc_html__( 'Show Ingredients', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_weight', array( 'label' => esc_html__( 'Show Net Weight', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_shelf_life', array( 'label' => esc_html__( 'Show Shelf Life', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_storage_note', array( 'label' => esc_html__( 'Show Storage Note With Shelf Life', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_allergen', array( 'label' => esc_html__( 'Show Allergen Note', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_category', array( 'label' => esc_html__( 'Show Category', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'details_layout', array(
            'label'   => esc_html__( 'Details Layout', 'amaley-page-assignment-bridge' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'table',
            'options' => array( 'table' => esc_html__( 'Table Rows', 'amaley-page-assignment-bridge' ), 'cards' => esc_html__( 'Card Rows', 'amaley-page-assignment-bridge' ) ),
        ) );
        $this->add_control( 'ingredients_label', array( 'label' => esc_html__( 'Ingredients Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ingredients' ) );
        $this->add_control( 'weight_label', array( 'label' => esc_html__( 'Net Weight Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Net Weight' ) );
        $this->add_control( 'shelf_label', array( 'label' => esc_html__( 'Shelf Life Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Shelf Life' ) );
        $this->add_control( 'allergen_label', array( 'label' => esc_html__( 'Allergen Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Allergen Note' ) );
        $this->add_control( 'category_label', array( 'label' => esc_html__( 'Category Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Category' ) );
        $this->end_controls_section();

        /* -------------------- CONTENT: ORIGIN -------------------- */
        $this->start_controls_section( 'section_origin_content', array( 'label' => esc_html__( 'Origin Tab', 'amaley-page-assignment-bridge' ) ) );
        $this->add_control( 'show_origin_kicker', array( 'label' => esc_html__( 'Show Kicker', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_origin_title', array( 'label' => esc_html__( 'Show Title', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_origin_intro', array( 'label' => esc_html__( 'Show Intro', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'origin_kicker_text', array( 'label' => esc_html__( 'Kicker Text', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Origin' ) );
        $this->add_control( 'origin_title_text', array( 'label' => esc_html__( 'Title Text', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'From source to shelf' ) );
        $this->add_control( 'origin_intro_source', array(
            'label'   => esc_html__( 'Intro Source', 'amaley-page-assignment-bridge' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'origin_short',
            'options' => array(
                'origin_short' => esc_html__( 'Origin Short Line', 'amaley-page-assignment-bridge' ),
                'traceability' => esc_html__( 'Traceability Note', 'amaley-page-assignment-bridge' ),
                'custom'       => esc_html__( 'Custom Text', 'amaley-page-assignment-bridge' ),
                'hide'         => esc_html__( 'Hide Intro', 'amaley-page-assignment-bridge' ),
            ),
        ) );
        $this->add_control( 'origin_intro_custom', array( 'label' => esc_html__( 'Custom Intro Text', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '' ) );
        $this->add_control( 'show_cluster_card', array( 'label' => esc_html__( 'Show Cluster Card', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_shg_card', array( 'label' => esc_html__( 'Show SHG Card', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_producer_card', array( 'label' => esc_html__( 'Show Producer Card', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_village_card', array( 'label' => esc_html__( 'Show Village / Source Card', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_region_card', array( 'label' => esc_html__( 'Show Region / Belt Card', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_origin_icons', array( 'label' => esc_html__( 'Show Icons / Images', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_traceability', array( 'label' => esc_html__( 'Show Traceability Note', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'cluster_label', array( 'label' => esc_html__( 'Cluster Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cluster' ) );
        $this->add_control( 'shg_label', array( 'label' => esc_html__( 'SHG Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'SHG' ) );
        $this->add_control( 'producer_label', array( 'label' => esc_html__( 'Producer Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Producer' ) );
        $this->add_control( 'village_label', array( 'label' => esc_html__( 'Village Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Village / Source' ) );
        $this->add_control( 'region_label', array( 'label' => esc_html__( 'Region Label', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Region / Belt' ) );
        $this->end_controls_section();

        /* -------------------- CONTENT: HOW / REVIEWS -------------------- */
        $this->start_controls_section( 'section_how_reviews', array( 'label' => esc_html__( 'How To Use / Reviews', 'amaley-page-assignment-bridge' ) ) );
        $this->add_control( 'show_how_text', array( 'label' => esc_html__( 'Show How To Use Text', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_how_storage', array( 'label' => esc_html__( 'Show Storage Note', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_how_shelf', array( 'label' => esc_html__( 'Show Shelf Life', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'how_empty_message', array( 'label' => esc_html__( 'How To Use Empty Message', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Usage and storage guidance will appear here once added in the product backend.' ) );
        $this->add_control( 'show_reviewer_name', array( 'label' => esc_html__( 'Show Reviewer Name', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_review_date', array( 'label' => esc_html__( 'Show Review Date', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_review_stars', array( 'label' => esc_html__( 'Show Stars', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'show_review_text', array( 'label' => esc_html__( 'Show Review Text', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_control( 'reviews_empty_message', array( 'label' => esc_html__( 'Reviews Empty Message', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Reviews will appear here when customers review this product.' ) );
        $this->add_control( 'reviews_layout', array( 'label' => esc_html__( 'Reviews Layout', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cards', 'options' => array( 'cards' => 'Cards', 'list' => 'Simple List' ) ) );
        $this->add_control( 'reviews_count', array( 'label' => esc_html__( 'Reviews To Show', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 50, 'step' => 1, 'default' => 8 ) );
        $this->end_controls_section();

        /* -------------------- CONTENT: FIELD MAPPING -------------------- */
        $this->start_controls_section( 'fields', array( 'label' => esc_html__( 'Product Field Mapping', 'amaley-page-assignment-bridge' ) ) );
        $this->add_control( 'field_ingredients', array( 'label' => 'Ingredients Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ingredients_note' ) );
        $this->add_control( 'field_how', array( 'label' => 'How To Use Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'how_to_use' ) );
        $this->add_control( 'field_storage', array( 'label' => 'Storage Instructions Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'storage_instructions' ) );
        $this->add_control( 'field_shelf', array( 'label' => 'Shelf Life Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'shelf_life' ) );
        $this->add_control( 'field_allergen', array( 'label' => 'Allergen Note Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'allergen_note' ) );
        $this->add_control( 'field_cluster', array( 'label' => 'Linked Cluster Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'linked_cluster' ) );
        $this->add_control( 'field_shg', array( 'label' => 'Linked SHG Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'linked_shg_group' ) );
        $this->add_control( 'field_maker', array( 'label' => 'Linked Producer Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'linked_producer_maker' ) );
        $this->add_control( 'field_village', array( 'label' => 'Village Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'village_source_location' ) );
        $this->add_control( 'field_region', array( 'label' => 'Region Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'region_source_belt' ) );
        $this->add_control( 'field_processing', array( 'label' => 'Processing Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'processing_method' ) );
        $this->add_control( 'field_traceability', array( 'label' => 'Traceability Note Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'traceability_note' ) );
        $this->add_control( 'field_quote', array( 'label' => 'Producer Quote Field', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'producer_quote_maker_note' ) );
        $this->end_controls_section();

        /* -------------------- LAYOUT -------------------- */
        $this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Layout / Responsive', 'amaley-page-assignment-bridge' ) ) );
        $this->add_control( 'tabs_position', array( 'label' => esc_html__( 'Desktop Tabs Position', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'top', 'options' => array( 'top' => 'Top', 'left' => 'Left Side' ) ) );
        $this->add_control( 'mobile_tabs_layout', array( 'label' => esc_html__( 'Mobile Tabs Layout', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'scroll', 'options' => array( 'scroll' => 'Horizontal Scroll', 'two_row' => 'Two Row', 'stacked' => 'Stacked' ) ) );
        $this->add_responsive_control( 'origin_columns', array(
            'label' => esc_html__( 'Origin Columns', 'amaley-page-assignment-bridge' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => array( '1' => '1', '2' => '2', '3' => '3' ),
            'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel .apab-origin-panel--inside-tabs .apab-origin-panel__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ),
        ) );
        $this->add_control( 'traceability_position', array( 'label' => esc_html__( 'Traceability Position', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'below', 'options' => array( 'below' => 'Below Cards', 'above' => 'Above Cards', 'hide' => 'Hide' ) ) );
        $this->end_controls_section();

        /* -------------------- ALIGNMENT -------------------- */
        $this->start_controls_section( 'section_alignment', array( 'label' => esc_html__( 'Alignment', 'amaley-page-assignment-bridge' ) ) );
        $this->add_responsive_control( 'tab_nav_align', array( 'label' => esc_html__( 'Tab Nav Alignment', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => $this->align_options(), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav' => 'justify-content: {{VALUE}};' ), 'toggle' => false ) );
        $this->add_responsive_control( 'panel_align', array( 'label' => esc_html__( 'Panel Content Alignment', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => $this->text_align_options(), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel' => 'text-align: {{VALUE}};' ), 'toggle' => false ) );
        $this->add_responsive_control( 'details_label_align', array( 'label' => esc_html__( 'Details Label Alignment', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => $this->text_align_options(), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__detail-table td:first-child' => 'text-align: {{VALUE}};' ), 'toggle' => false ) );
        $this->add_responsive_control( 'details_value_align', array( 'label' => esc_html__( 'Details Value Alignment', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => $this->text_align_options(), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__detail-table td:last-child' => 'text-align: {{VALUE}};' ), 'toggle' => false ) );
        $this->add_responsive_control( 'origin_header_align', array( 'label' => esc_html__( 'Origin Header Alignment', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => $this->text_align_options(), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel .apab-origin-panel__head' => 'text-align: {{VALUE}};' ), 'toggle' => false ) );
        $this->add_responsive_control( 'origin_card_align', array( 'label' => esc_html__( 'Origin Card Text Alignment', 'amaley-page-assignment-bridge' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => $this->text_align_options(), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel .apab-origin-panel__item' => 'text-align: {{VALUE}};' ), 'toggle' => false ) );
        $this->end_controls_section();

        /* -------------------- STYLE: SECTION / PANEL -------------------- */
        $this->start_controls_section( 'style_section', array( 'label' => esc_html__( 'Section / Panel', 'amaley-page-assignment-bridge' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => 'Section Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'panel_bg', array( 'label' => 'Panel Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'panel_text', array( 'label' => 'Panel Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'panel_border', 'selector' => '{{WRAPPER}} .apab-info-tabs__panel' ) );
        $this->add_control( 'panel_radius', array( 'label' => 'Panel Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'panel_padding', array( 'label' => 'Panel Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => 'Section Margin', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs' => 'margin: {{TOP}}{{UNIT}} auto {{BOTTOM}}{{UNIT}} auto;' ) ) );
        $this->end_controls_section();

        /* -------------------- STYLE: TABS -------------------- */
        $this->start_controls_section( 'style_nav', array( 'label' => 'Tab Navigation', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'nav_color', array( 'label' => 'Tab Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav button' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'active_color', array( 'label' => 'Active Tab Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav button.is-active' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'hover_color', array( 'label' => 'Hover Tab Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav button:hover' => 'color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'active_underline', array( 'label' => 'Active Underline Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav button.is-active' => 'border-bottom-color: {{VALUE}} !important;' ) ) );
        $this->add_control( 'tab_bg', array( 'label' => 'Tab Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav button' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'active_tab_bg', array( 'label' => 'Active Tab Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav button.is-active' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'nav_typography', 'selector' => '{{WRAPPER}} .apab-info-tabs__nav button' ) );
        $this->add_responsive_control( 'tab_gap', array( 'label' => 'Tab Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tab_padding', array( 'label' => 'Tab Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__nav button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->end_controls_section();

        /* -------------------- STYLE: DETAILS -------------------- */
        $this->start_controls_section( 'style_details', array( 'label' => 'Details Table', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'description_color', array( 'label' => 'Description Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__description' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .apab-info-tabs__description, {{WRAPPER}} .apab-info-tabs__description p' ) );
        $this->add_control( 'table_bg', array( 'label' => 'Table Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__detail-table' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'row_border_color', array( 'label' => 'Row Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__detail-table, {{WRAPPER}} .apab-info-tabs__detail-table td' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'label_color', array( 'label' => 'Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__detail-table td:first-child' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'value_color', array( 'label' => 'Value Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__detail-table td:last-child' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'selector' => '{{WRAPPER}} .apab-info-tabs__detail-table td:first-child' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'value_typography', 'selector' => '{{WRAPPER}} .apab-info-tabs__detail-table td:last-child' ) );
        $this->add_responsive_control( 'row_padding', array( 'label' => 'Row Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__detail-table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        /* -------------------- STYLE: ORIGIN -------------------- */
        $this->start_controls_section( 'style_origin', array( 'label' => 'Origin Tab Cards', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'origin_kicker_color', array( 'label' => 'Kicker Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__head span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_title_color', array( 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_intro_color', array( 'label' => 'Intro Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__head p' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'origin_title_typography', 'selector' => '{{WRAPPER}} .apab-origin-panel__title' ) );
        $this->add_control( 'origin_card_bg', array( 'label' => 'Card Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__item' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'origin_card_border_color', array( 'label' => 'Card Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__item' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_card_radius', array( 'label' => 'Card Radius', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__item' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'origin_icon_bg', array( 'label' => 'Icon Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-icon' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'origin_icon_color', array( 'label' => 'Icon Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-icon' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_label_color', array( 'label' => 'Label Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__item span:not(.apab-origin-icon)' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'origin_value_color', array( 'label' => 'Value Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__item strong, {{WRAPPER}} .apab-origin-panel__item a' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'origin_card_gap', array( 'label' => 'Card Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'origin_card_padding', array( 'label' => 'Card Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'traceability_color', array( 'label' => 'Traceability Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__story' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'traceability_bg', array( 'label' => 'Traceability Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-origin-panel__story' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_section();

        /* -------------------- STYLE: REVIEWS -------------------- */
        $this->start_controls_section( 'style_reviews', array( 'label' => 'Reviews', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'review_card_bg', array( 'label' => 'Review Card Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__review' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'review_border_color', array( 'label' => 'Review Border Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__review' => 'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'review_name_color', array( 'label' => 'Reviewer Name Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__review-head strong' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'review_date_color', array( 'label' => 'Date Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__review-head span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'stars_color', array( 'label' => 'Stars Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__stars' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'review_text_color', array( 'label' => 'Review Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__review p' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'review_card_padding', array( 'label' => 'Review Card Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__review' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'review_card_gap', array( 'label' => 'Review Card Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .apab-info-tabs__reviews' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function align_options() {
        return array(
            'flex-start' => array( 'title' => esc_html__( 'Left', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-h-align-left' ),
            'center'     => array( 'title' => esc_html__( 'Center', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-h-align-center' ),
            'flex-end'   => array( 'title' => esc_html__( 'Right', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-h-align-right' ),
        );
    }

    private function text_align_options() {
        return array(
            'left'   => array( 'title' => esc_html__( 'Left', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-text-align-left' ),
            'center' => array( 'title' => esc_html__( 'Center', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-text-align-center' ),
            'right'  => array( 'title' => esc_html__( 'Right', 'amaley-page-assignment-bridge' ), 'icon' => 'eicon-text-align-right' ),
        );
    }

    private function setting( $settings, $key, $default = '' ) {
        return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
    }

    private function is_yes( $settings, $key, $default = true ) {
        if ( ! isset( $settings[ $key ] ) ) {
            return $default;
        }
        return 'yes' === $settings[ $key ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( ! $this->is_yes( $settings, 'show_section', true ) ) {
            return;
        }

        $product = $this->current_product();
        if ( ! $product ) {
            $this->editor_notice();
            return;
        }

        $visible_tabs = $this->visible_tabs( $settings );
        if ( empty( $visible_tabs ) ) {
            return;
        }

        $default_tab = $this->setting( $settings, 'default_active_tab', 'details' );
        if ( ! isset( $visible_tabs[ $default_tab ] ) ) {
            $keys        = array_keys( $visible_tabs );
            $default_tab = reset( $keys );
        }

        $uid           = 'apab-info-tabs-' . $this->get_id();
        $reviews_count = $product->get_review_count();
        $classes       = array(
            'apab-info-tabs',
            'apab-info-tabs--tabs-' . sanitize_html_class( $this->setting( $settings, 'tabs_position', 'top' ) ),
            'apab-info-tabs--mobile-tabs-' . sanitize_html_class( $this->setting( $settings, 'mobile_tabs_layout', 'scroll' ) ),
            'apab-info-tabs--details-' . sanitize_html_class( $this->setting( $settings, 'details_layout', 'table' ) ),
            'apab-info-tabs--reviews-' . sanitize_html_class( $this->setting( $settings, 'reviews_layout', 'cards' ) ),
        );

        echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '" id="' . esc_attr( $uid ) . '">';
        echo '<div class="apab-info-tabs__nav" role="tablist">';
        foreach ( $visible_tabs as $key => $label ) {
            $label_to_show = $label;
            if ( 'reviews' === $key && $reviews_count ) {
                $label_to_show .= ' (' . number_format_i18n( $reviews_count ) . ')';
            }
            $this->tab_button( $key, $label_to_show, $default_tab === $key );
        }
        echo '</div>';

        foreach ( $visible_tabs as $key => $label ) {
            echo '<div class="apab-info-tabs__panel ' . ( $default_tab === $key ? 'is-active' : '' ) . '" data-apab-panel="' . esc_attr( $key ) . '">';
            if ( 'details' === $key ) {
                $this->render_details_panel( $product, $settings );
            } elseif ( 'origin' === $key ) {
                $this->render_origin_panel( $product, $settings );
            } elseif ( 'how' === $key ) {
                $this->render_how_panel( $product, $settings );
            } elseif ( 'reviews' === $key ) {
                $this->render_reviews_panel( $product, $settings );
            }
            echo '</div>';
        }
        echo '</section>';
    }

    private function visible_tabs( $settings ) {
        $tabs = array();
        if ( $this->is_yes( $settings, 'show_details_tab', true ) ) {
            $tabs['details'] = $this->setting( $settings, 'details_label', 'Details' );
        }
        if ( $this->is_yes( $settings, 'show_origin_tab', true ) ) {
            $tabs['origin'] = $this->setting( $settings, 'origin_label', 'Origin' );
        }
        if ( $this->is_yes( $settings, 'show_how_tab', true ) ) {
            $tabs['how'] = $this->setting( $settings, 'how_label', 'How To Use' );
        }
        if ( $this->is_yes( $settings, 'show_reviews_tab', true ) ) {
            $tabs['reviews'] = $this->setting( $settings, 'reviews_label', 'Reviews' );
        }
        return $tabs;
    }

    private function tab_button( $key, $label, $active = false ) {
        echo '<button type="button" class="' . ( $active ? 'is-active' : '' ) . '" data-apab-tab="' . esc_attr( $key ) . '">' . esc_html( strtoupper( $label ) ) . '</button>';
    }

    private function render_details_panel( $product, $settings ) {
        $id          = $product->get_id();
        $ingredients = $this->field_text( $settings['field_ingredients'], $id );
        $shelf       = $this->field_text( $settings['field_shelf'], $id );
        $storage     = $this->field_text( $settings['field_storage'], $id );
        $allergen    = $this->field_text( $settings['field_allergen'], $id );
        $categories  = wc_get_product_category_list( $id, ', ' );
        $weight      = $product->has_weight() ? wc_format_weight( $product->get_weight() ) : '';

        $description = $this->safe_product_description( $product );
        if ( $description && $this->is_yes( $settings, 'show_description', true ) ) {
            echo '<div class="apab-info-tabs__description">' . $description . '</div>';
        }

        $rows = array();
        if ( $this->is_yes( $settings, 'show_ingredients', true ) ) {
            $rows[] = array( $this->setting( $settings, 'ingredients_label', 'Ingredients' ), $ingredients, false );
        }
        if ( $this->is_yes( $settings, 'show_weight', true ) ) {
            $rows[] = array( $this->setting( $settings, 'weight_label', 'Net Weight' ), $weight, false );
        }
        if ( $this->is_yes( $settings, 'show_shelf_life', true ) ) {
            $shelf_value = $shelf;
            if ( $this->is_yes( $settings, 'show_storage_note', true ) && $storage ) {
                $shelf_value = trim( $shelf . ( $shelf ? ' · ' : '' ) . $storage );
            }
            $rows[] = array( $this->setting( $settings, 'shelf_label', 'Shelf Life' ), $shelf_value, false );
        }
        if ( $this->is_yes( $settings, 'show_allergen', true ) ) {
            $rows[] = array( $this->setting( $settings, 'allergen_label', 'Allergen Note' ), $allergen, false );
        }
        if ( $this->is_yes( $settings, 'show_category', true ) ) {
            $rows[] = array( $this->setting( $settings, 'category_label', 'Category' ), $categories, true );
        }

        echo '<table class="apab-info-tabs__detail-table"><tbody>';
        foreach ( $rows as $row ) {
            $this->detail_row( $row[0], $row[1], $row[2] );
        }
        echo '</tbody></table>';
    }

    private function render_origin_panel( $product, $settings ) {
        $id = $product->get_id();
        $origin = APAB_Product_Context::origin_data( $id, array(
            'origin_short' => 'origin_short_line',
            'cluster'      => $settings['field_cluster'],
            'shg'          => $settings['field_shg'],
            'maker'        => $settings['field_maker'],
            'village'      => $settings['field_village'],
            'region'       => $settings['field_region'],
            'batch'        => 'batch_type',
            'season'       => 'harvest_collection_season',
            'traceability' => $settings['field_traceability'],
            'processing'   => $settings['field_processing'],
            'quote'        => $settings['field_quote'],
        ) );

        $rows = array(
            array( 'key' => 'cluster', 'show' => 'show_cluster_card', 'label' => $this->setting( $settings, 'cluster_label', 'Cluster' ), 'value' => isset( $origin['cluster_html'] ) ? $origin['cluster_html'] : '', 'raw' => ! empty( $origin['cluster_ids'][0] ) ? $origin['cluster_ids'][0] : 0 ),
            array( 'key' => 'shg', 'show' => 'show_shg_card', 'label' => $this->setting( $settings, 'shg_label', 'SHG' ), 'value' => isset( $origin['shg_html'] ) ? $origin['shg_html'] : '', 'raw' => ! empty( $origin['shg_ids'][0] ) ? $origin['shg_ids'][0] : 0 ),
            array( 'key' => 'producer', 'show' => 'show_producer_card', 'label' => $this->setting( $settings, 'producer_label', 'Producer' ), 'value' => isset( $origin['maker_html'] ) ? $origin['maker_html'] : '', 'raw' => ! empty( $origin['maker_ids'][0] ) ? $origin['maker_ids'][0] : 0 ),
            array( 'key' => 'village', 'show' => 'show_village_card', 'label' => $this->setting( $settings, 'village_label', 'Village / Source' ), 'value' => ! empty( $origin['source_village'] ) ? esc_html( $origin['source_village'] ) : '', 'raw' => ! empty( $origin['source_village'] ) ? $origin['source_village'] : '' ),
            array( 'key' => 'region', 'show' => 'show_region_card', 'label' => $this->setting( $settings, 'region_label', 'Region / Belt' ), 'value' => ! empty( $origin['region'] ) ? esc_html( $origin['region'] ) : '', 'raw' => ! empty( $origin['region'] ) ? $origin['region'] : '' ),
        );

        $visible_rows = array();
        foreach ( $rows as $row ) {
            if ( $this->is_yes( $settings, $row['show'], true ) && ! empty( $row['value'] ) ) {
                $visible_rows[] = $row;
            }
        }

        $intro = $this->origin_intro_text( $settings, $origin );
        $trace_html = $this->origin_story_html( $settings, $origin );

        if ( empty( $visible_rows ) && ! $intro && ! $trace_html ) {
            echo '<p>Origin details will appear here once added in the product backend.</p>';
            return;
        }

        echo '<section class="apab-origin-panel apab-origin-panel--inside-tabs">';
        echo '<div class="apab-origin-panel__head">';
        if ( $this->is_yes( $settings, 'show_origin_kicker', true ) ) {
            echo '<span>' . esc_html( $this->setting( $settings, 'origin_kicker_text', 'Origin' ) ) . '</span>';
        }
        if ( $this->is_yes( $settings, 'show_origin_title', true ) ) {
            echo '<h2 class="apab-origin-panel__title">' . esc_html( $this->setting( $settings, 'origin_title_text', 'From source to shelf' ) ) . '</h2>';
        }
        if ( $this->is_yes( $settings, 'show_origin_intro', true ) && $intro ) {
            echo '<p>' . esc_html( $intro ) . '</p>';
        }
        echo '</div>';

        if ( 'above' === $this->setting( $settings, 'traceability_position', 'below' ) && $trace_html ) {
            echo $trace_html;
        }

        if ( ! empty( $visible_rows ) ) {
            echo '<div class="apab-origin-panel__grid">';
            foreach ( $visible_rows as $row ) {
                echo '<div class="apab-origin-panel__item">';
                if ( $this->is_yes( $settings, 'show_origin_icons', true ) ) {
                    echo $this->render_origin_icon( $row['raw'], $row['label'] );
                }
                echo '<div><span>' . esc_html( $row['label'] ) . '</span><strong>' . wp_kses_post( $row['value'] ) . '</strong></div></div>';
            }
            echo '</div>';
        }

        if ( 'below' === $this->setting( $settings, 'traceability_position', 'below' ) && $trace_html ) {
            echo $trace_html;
        }
        echo '</section>';
    }

    private function origin_intro_text( $settings, $origin ) {
        if ( 'hide' === $this->setting( $settings, 'origin_intro_source', 'origin_short' ) ) {
            return '';
        }
        if ( 'custom' === $this->setting( $settings, 'origin_intro_source', 'origin_short' ) ) {
            return wp_strip_all_tags( (string) $this->setting( $settings, 'origin_intro_custom', '' ) );
        }
        if ( 'traceability' === $this->setting( $settings, 'origin_intro_source', 'origin_short' ) ) {
            return ! empty( $origin['traceability_note'] ) ? $origin['traceability_note'] : '';
        }
        return ! empty( $origin['origin_short'] ) ? $origin['origin_short'] : '';
    }

    private function origin_story_html( $settings, $origin ) {
        if ( ! $this->is_yes( $settings, 'show_traceability', true ) || 'hide' === $this->setting( $settings, 'traceability_position', 'below' ) ) {
            return '';
        }
        if ( empty( $origin['traceability_note'] ) && empty( $origin['processing_method'] ) && empty( $origin['producer_quote'] ) ) {
            return '';
        }
        ob_start();
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
        return ob_get_clean();
    }

    private function render_how_panel( $product, $settings ) {
        $id      = $product->get_id();
        $how     = $this->field_text( $settings['field_how'], $id );
        $storage = $this->field_text( $settings['field_storage'], $id );
        $shelf   = $this->field_text( $settings['field_shelf'], $id );
        $has     = false;

        if ( $how && $this->is_yes( $settings, 'show_how_text', true ) ) {
            echo '<p>' . esc_html( $how ) . '</p>';
            $has = true;
        }
        if ( $storage && $this->is_yes( $settings, 'show_how_storage', true ) ) {
            echo '<p><strong>Storage:</strong> ' . esc_html( $storage ) . '</p>';
            $has = true;
        }
        if ( $shelf && $this->is_yes( $settings, 'show_how_shelf', true ) ) {
            echo '<p><strong>Shelf Life:</strong> ' . esc_html( $shelf ) . '</p>';
            $has = true;
        }
        if ( ! $has ) {
            echo '<p>' . esc_html( $this->setting( $settings, 'how_empty_message', 'Usage and storage guidance will appear here once added in the product backend.' ) ) . '</p>';
        }
    }

    private function render_reviews_panel( $product, $settings ) {
        $number = max( 1, absint( $this->setting( $settings, 'reviews_count', 8 ) ) );
        $reviews = get_comments( array(
            'post_id' => $product->get_id(),
            'status'  => 'approve',
            'type'    => 'review',
            'number'  => $number,
        ) );

        if ( empty( $reviews ) ) {
            echo '<p>' . esc_html( $this->setting( $settings, 'reviews_empty_message', 'Reviews will appear here when customers review this product.' ) ) . '</p>';
            return;
        }

        echo '<div class="apab-info-tabs__reviews">';
        foreach ( $reviews as $review ) {
            $rating = absint( get_comment_meta( $review->comment_ID, 'rating', true ) );
            echo '<article class="apab-info-tabs__review">';
            if ( $this->is_yes( $settings, 'show_reviewer_name', true ) || $this->is_yes( $settings, 'show_review_date', true ) ) {
                echo '<div class="apab-info-tabs__review-head">';
                if ( $this->is_yes( $settings, 'show_reviewer_name', true ) ) {
                    echo '<strong>' . esc_html( $review->comment_author ) . '</strong>';
                }
                if ( $this->is_yes( $settings, 'show_review_date', true ) ) {
                    echo '<span>' . esc_html( get_comment_date( 'M Y', $review ) ) . '</span>';
                }
                echo '</div>';
            }
            if ( $rating && $this->is_yes( $settings, 'show_review_stars', true ) ) {
                echo '<div class="apab-info-tabs__stars" aria-label="' . esc_attr( $rating . ' out of 5' ) . '">' . esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', max( 0, 5 - $rating ) ) ) . '</div>';
            }
            if ( $this->is_yes( $settings, 'show_review_text', true ) ) {
                echo '<p>' . esc_html( $review->comment_content ) . '</p>';
            }
            echo '</article>';
        }
        echo '</div>';
    }

    private function safe_product_description( $product ) {
        if ( ! $product instanceof WC_Product ) {
            return '';
        }
        $description = (string) $product->get_description();
        if ( '' === trim( wp_strip_all_tags( $description ) ) ) {
            return '';
        }
        $description = do_shortcode( $description );
        $description = wp_kses_post( $description );
        return wpautop( $description );
    }

    private function detail_row( $label, $value, $is_html = false ) {
        if ( '' === trim( wp_strip_all_tags( (string) $value ) ) ) {
            return;
        }
        echo '<tr><td>' . esc_html( strtoupper( $label ) ) . '</td><td>' . ( $is_html ? wp_kses_post( $value ) : esc_html( $value ) ) . '</td></tr>';
    }
}
