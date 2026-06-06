<?php
/** Elementor widget for Amaley Universal Showcase. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

if ( ! class_exists( 'AUS_Showcase_Widget', false ) ) {
class AUS_Showcase_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'amaley_universal_showcase'; }
    public function get_title() { return esc_html__( 'Amaley Universal Showcase', 'amaley-universal-showcase' ); }
    public function get_icon() { return 'eicon-slider-push'; }
    public function get_categories() { return array( 'amaley-core' ); }
    public function get_style_depends() { return array( 'aus-showcase' ); }
    public function get_script_depends() { return array( 'aus-showcase' ); }
    public function get_keywords() { return array( 'amaley', 'showcase', 'slider', 'grid', 'cluster', 'shg', 'member', 'product' ); }

    protected function register_controls() {
        $this->source_controls();
        $this->heading_controls();
        $this->layout_controls();
        $this->card_family_controls( 'cluster', 'Cluster', 'OG Cluster Card 1', 'View Cluster', 18 );
        $this->card_family_controls( 'shg', 'SHG', 'OG SHG Card 1', 'View Collective', 18 );
        $this->card_family_controls( 'member', 'Member / Producer', 'OG Member Card 1', 'View Producer', 18 );
        $this->card_family_controls( 'product', 'Product', 'OG Product Card 1', 'View Product', 16 );
        $this->slider_controls();
        $this->style_section_controls();
        $this->style_heading_controls();
        $this->style_cta_controls();
        $this->style_card_box_controls();
        $this->style_card_media_controls();
        $this->style_card_text_controls();
        $this->style_card_meta_controls();
        $this->style_card_button_controls();
        $this->style_navigation_controls();
    }

    private function source_controls() {
        $this->start_controls_section( 'source_section', array( 'label' => esc_html__( '1. Showcase Source', 'amaley-universal-showcase' ) ) );

        $this->add_control( 'show_section', array(
            'label' => esc_html__( 'Show Section', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default' => '1',
        ) );

        $this->add_control( 'content_type', array(
            'label' => esc_html__( 'What to Show', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'cluster',
            'options' => array(
                'cluster' => esc_html__( 'Cluster', 'amaley-universal-showcase' ),
                'shg'     => esc_html__( 'SHG / Producer Group', 'amaley-universal-showcase' ),
                'member'  => esc_html__( 'Member / Producer', 'amaley-universal-showcase' ),
                'product' => esc_html__( 'Product', 'amaley-universal-showcase' ),
            ),
            'description' => esc_html__( 'Only source modes and card controls relevant to this selected type will appear.', 'amaley-universal-showcase' ),
        ) );

        /*
         * Source modes are separated by content type so the editor does not show impossible
         * combinations like Cluster by Cluster or SHG by SHG. The renderer still keeps
         * backward compatibility with the old source_mode value if a saved widget has it.
         */
        $this->add_control( 'source_mode_cluster', array(
            'label' => esc_html__( 'Cluster Source Mode', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest'   => esc_html__( 'Latest / Normal Query', 'amaley-universal-showcase' ),
                'manual'   => esc_html__( 'Manual IDs', 'amaley-universal-showcase' ),
                'featured' => esc_html__( 'Featured Only', 'amaley-universal-showcase' ),
            ),
            'condition' => array( 'content_type' => 'cluster' ),
        ) );

        $this->add_control( 'source_mode_shg', array(
            'label' => esc_html__( 'SHG Source Mode', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest'     => esc_html__( 'Latest / Normal Query', 'amaley-universal-showcase' ),
                'manual'     => esc_html__( 'Manual IDs', 'amaley-universal-showcase' ),
                'featured'   => esc_html__( 'Featured Only', 'amaley-universal-showcase' ),
                'by_cluster' => esc_html__( 'Relation — By Cluster', 'amaley-universal-showcase' ),
            ),
            'condition' => array( 'content_type' => 'shg' ),
        ) );

        $this->add_control( 'source_mode_member', array(
            'label' => esc_html__( 'Member / Producer Source Mode', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest'     => esc_html__( 'Latest / Normal Query', 'amaley-universal-showcase' ),
                'manual'     => esc_html__( 'Manual IDs', 'amaley-universal-showcase' ),
                'featured'   => esc_html__( 'Featured Only', 'amaley-universal-showcase' ),
                'by_cluster' => esc_html__( 'Relation — By Cluster', 'amaley-universal-showcase' ),
                'by_shg'     => esc_html__( 'Relation — By SHG / Producer Group', 'amaley-universal-showcase' ),
            ),
            'condition' => array( 'content_type' => 'member' ),
        ) );

        $this->add_control( 'source_mode_product', array(
            'label' => esc_html__( 'Product Source Mode', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest'           => esc_html__( 'Latest / Normal Query', 'amaley-universal-showcase' ),
                'manual'           => esc_html__( 'Manual IDs', 'amaley-universal-showcase' ),
                'featured'         => esc_html__( 'Featured Only', 'amaley-universal-showcase' ),
                'product_category' => esc_html__( 'Product Category Slug', 'amaley-universal-showcase' ),
                'by_cluster'       => esc_html__( 'Relation — By Cluster', 'amaley-universal-showcase' ),
                'by_shg'           => esc_html__( 'Relation — By SHG / Producer Group', 'amaley-universal-showcase' ),
                'by_member'        => esc_html__( 'Relation — By Member / Producer', 'amaley-universal-showcase' ),
            ),
            'condition' => array( 'content_type' => 'product' ),
        ) );

        $this->add_control( 'relation_help_shg', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'Relation use karne ke liye: SHG Source Mode me “Relation — By Cluster” select karein. Uske baad neeche Select Cluster field dikhega.', 'amaley-universal-showcase' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            'condition' => array( 'content_type' => 'shg' ),
        ) );

        $this->add_control( 'relation_help_member', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'Member relation ke liye “Relation — By Cluster” ya “Relation — By SHG / Producer Group” select karein. Uske baad related selector field dikhega.', 'amaley-universal-showcase' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            'condition' => array( 'content_type' => 'member' ),
        ) );

        $this->add_control( 'relation_help_product', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => esc_html__( 'Product relation ke liye “Relation — By Cluster / SHG / Member” select karein. Uske baad related selector field dikhega.', 'amaley-universal-showcase' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            'condition' => array( 'content_type' => 'product' ),
        ) );

        $this->add_control( 'manual_ids', array(
            'label' => esc_html__( 'Manual IDs', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'description' => esc_html__( 'Comma-separated IDs filtered by selected content type.', 'amaley-universal-showcase' ),
            'conditions' => array(
                'relation' => 'or',
                'terms' => array(
                    array( 'name' => 'source_mode_cluster', 'operator' => '==', 'value' => 'manual' ),
                    array( 'name' => 'source_mode_shg', 'operator' => '==', 'value' => 'manual' ),
                    array( 'name' => 'source_mode_member', 'operator' => '==', 'value' => 'manual' ),
                    array( 'name' => 'source_mode_product', 'operator' => '==', 'value' => 'manual' ),
                ),
            ),
        ) );

        $this->add_control( 'product_category', array(
            'label' => esc_html__( 'Product Category Slugs', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'description' => esc_html__( 'Comma-separated WooCommerce product category slugs. Product only.', 'amaley-universal-showcase' ),
            'condition' => array( 'content_type' => 'product', 'source_mode_product' => 'product_category' ),
        ) );

        $this->add_control( 'relation_cluster_id_shg', array(
            'label' => esc_html__( 'Select Cluster', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'options' => $this->post_options( 'amaley_cluster' ),
            'label_block' => true,
            'condition' => array( 'content_type' => 'shg', 'source_mode_shg' => 'by_cluster' ),
            'description' => esc_html__( 'Shows SHGs linked to this Cluster.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'relation_cluster_id_member', array(
            'label' => esc_html__( 'Select Cluster', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'options' => $this->post_options( 'amaley_cluster' ),
            'label_block' => true,
            'condition' => array( 'content_type' => 'member', 'source_mode_member' => 'by_cluster' ),
            'description' => esc_html__( 'Shows Members/Producers linked through SHGs of this Cluster.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'relation_shg_id_member', array(
            'label' => esc_html__( 'Select SHG / Producer Group', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'options' => $this->post_options( 'amaley_shg_group' ),
            'label_block' => true,
            'condition' => array( 'content_type' => 'member', 'source_mode_member' => 'by_shg' ),
            'description' => esc_html__( 'Shows Members/Producers linked to this SHG.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'relation_cluster_id_product', array(
            'label' => esc_html__( 'Select Cluster', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'options' => $this->post_options( 'amaley_cluster' ),
            'label_block' => true,
            'condition' => array( 'content_type' => 'product', 'source_mode_product' => 'by_cluster' ),
            'description' => esc_html__( 'Shows products mapped to this Cluster.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'relation_shg_id_product', array(
            'label' => esc_html__( 'Select SHG / Producer Group', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'options' => $this->post_options( 'amaley_shg_group' ),
            'label_block' => true,
            'condition' => array( 'content_type' => 'product', 'source_mode_product' => 'by_shg' ),
            'description' => esc_html__( 'Shows products mapped to this SHG / Producer Group.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'relation_member_id_product', array(
            'label' => esc_html__( 'Select Member / Producer', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'default' => '',
            'options' => $this->post_options( 'amaley_member' ),
            'label_block' => true,
            'condition' => array( 'content_type' => 'product', 'source_mode_product' => 'by_member' ),
            'description' => esc_html__( 'Shows products mapped to this Member / Producer.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'featured_only', array(
            'label' => esc_html__( 'Featured Only', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default' => '',
        ) );

        $this->add_control( 'empty_relation_action', array(
            'label' => esc_html__( 'If Relation Has No Items', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => array(
                'latest' => esc_html__( 'Show Latest Items', 'amaley-universal-showcase' ),
                'empty'  => esc_html__( 'Show Empty Message', 'amaley-universal-showcase' ),
                'hide'   => esc_html__( 'Hide Items Area', 'amaley-universal-showcase' ),
                'manual' => esc_html__( 'Show Manual Fallback IDs', 'amaley-universal-showcase' ),
            ),
            'description' => esc_html__( 'Use Show Latest while mapping is being cleaned. For final pages use Empty Message or Manual Fallback.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'relation_fallback_manual_ids', array(
            'label' => esc_html__( 'Manual Fallback IDs', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'condition' => array( 'empty_relation_action' => 'manual' ),
            'description' => esc_html__( 'Used only when selected relation has no items. IDs are filtered by selected content type.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'show_relation_status', array(
            'label' => esc_html__( 'Show Relation Status Label', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default' => '1',
            'description' => esc_html__( 'Shows whether cards are linked relation items or fallback latest/manual items.', 'amaley-universal-showcase' ),
        ) );

        $this->add_control( 'relation_status_linked_text', array(
            'label' => esc_html__( 'Linked Status Text', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Showing linked items',
            'condition' => array( 'show_relation_status' => '1' ),
        ) );

        $this->add_control( 'relation_status_fallback_text', array(
            'label' => esc_html__( 'Fallback Status Text', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Relation empty — showing latest items',
            'condition' => array( 'show_relation_status' => '1' ),
        ) );

        $this->add_control( 'relation_status_empty_text', array(
            'label' => esc_html__( 'Empty Relation Status Text', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'No linked items found',
            'condition' => array( 'show_relation_status' => '1' ),
        ) );

        $this->add_control( 'limit', array( 'label' => esc_html__( 'Number of Items', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 60, 'default' => 8 ) );
        $this->add_control( 'order_by', array( 'label' => esc_html__( 'Order By', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'date', 'options' => array( 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'menu_order' => 'Menu Order', 'rand' => 'Random' ) ) );
        $this->add_control( 'order', array( 'label' => esc_html__( 'Order', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'DESC', 'options' => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ) ) );
        $this->add_control( 'empty_message', array( 'label' => esc_html__( 'Empty State Message', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'No items are available yet.' ) );

        $this->end_controls_section();
    }

    private function heading_controls() {
        $this->start_controls_section( 'heading_section', array( 'label' => esc_html__( '2. Section Heading / CTA', 'amaley-universal-showcase' ) ) );
        $this->add_control( 'section_label', array( 'label' => esc_html__( 'Small Label', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Amaley ecosystem' ) );
        $this->add_control( 'section_title', array( 'label' => esc_html__( 'Heading', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 2, 'default' => 'Explore Amaley stories, sources and products' ) );
        $this->add_control( 'section_description', array( 'label' => esc_html__( 'Description', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'A reusable showcase for clusters, collectives, producers and products.' ) );
        $this->add_control( 'heading_layout_align', array(
            'label' => esc_html__( 'Heading Block Alignment', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array( 'title' => esc_html__( 'Left', 'amaley-universal-showcase' ), 'icon' => 'eicon-h-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-universal-showcase' ), 'icon' => 'eicon-h-align-center' ),
                'right' => array( 'title' => esc_html__( 'Right', 'amaley-universal-showcase' ), 'icon' => 'eicon-h-align-right' ),
            ),
            'default' => 'left',
            'prefix_class' => 'aus-heading-block-align-',
        ) );
        $this->add_control( 'show_section_button', array( 'label' => esc_html__( 'Show Section Button', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'section_button_text', array( 'label' => esc_html__( 'Button Text', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View All', 'condition' => array( 'show_section_button' => '1' ) ) );
        $this->add_control( 'section_button_url', array( 'label' => esc_html__( 'Button URL', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '', 'description' => esc_html__( 'Optional. If empty, the widget uses a safe default URL based on selected content type: /clusters/, /producer-groups/, /producers/, or /shop/.', 'amaley-universal-showcase' ), 'condition' => array( 'show_section_button' => '1' ) ) );
        $this->add_control( 'section_button_align', array(
            'label' => esc_html__( 'Bottom Button Alignment', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array( 'title' => esc_html__( 'Left', 'amaley-universal-showcase' ), 'icon' => 'eicon-h-align-left' ),
                'center' => array( 'title' => esc_html__( 'Center', 'amaley-universal-showcase' ), 'icon' => 'eicon-h-align-center' ),
                'right' => array( 'title' => esc_html__( 'Right', 'amaley-universal-showcase' ), 'icon' => 'eicon-h-align-right' ),
                'full' => array( 'title' => esc_html__( 'Full', 'amaley-universal-showcase' ), 'icon' => 'eicon-h-align-stretch' ),
            ),
            'default' => 'center',
            'prefix_class' => 'aus-bottom-cta-align-',
            'condition' => array( 'show_section_button' => '1' ),
        ) );
        $this->end_controls_section();
    }

    private function layout_controls() {
        $this->start_controls_section( 'layout_section', array( 'label' => esc_html__( '3. Layout Mode', 'amaley-universal-showcase' ) ) );
        $layout_options = array( 'grid' => 'Grid', 'slider' => 'Slider', 'card-row' => 'Card Row', 'list' => 'List' );
        $this->add_control( 'desktop_layout', array( 'label' => esc_html__( 'Desktop Layout', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => $layout_options ) );
        $this->add_control( 'tablet_layout', array( 'label' => esc_html__( 'Tablet Layout', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'grid', 'options' => $layout_options ) );
        $this->add_control( 'phone_layout', array( 'label' => esc_html__( 'Phone Layout', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'slider', 'options' => array( 'slider' => 'Phone Slider', 'card-row' => 'Horizontal Card Row', 'grid' => '1 Column Grid', 'list' => 'Compact List' ) ) );
        $this->add_control( 'columns_desktop', array( 'label' => esc_html__( 'Desktop Columns', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5' ) ) );
        $this->add_control( 'columns_tablet', array( 'label' => esc_html__( 'Tablet Columns', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '2', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ) ) );
        $this->add_control( 'columns_phone', array( 'label' => esc_html__( 'Phone Grid Columns', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1', 'options' => array( '1'=>'1','2'=>'2' ) ) );
        $this->add_responsive_control( 'item_gap', array( 'label' => esc_html__( 'Card Gap', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 22, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__track' => '--aus-gap: {{SIZE}}{{UNIT}}; gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'row_gap', array( 'label' => esc_html__( 'Row Gap', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__track' => 'row-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'mobile_compact_mode', array(
            'label' => esc_html__( 'Phone Compact Polish', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => '1',
            'default' => '1',
            'prefix_class' => 'aus-mobile-compact-',
            'description' => esc_html__( 'Keeps phone cards, meta boxes, arrows and spacing tighter without changing desktop design.', 'amaley-universal-showcase' ),
        ) );
        $this->add_control( 'phone_nav_layout', array(
            'label' => esc_html__( 'Phone Navigation Layout', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'balanced',
            'options' => array(
                'balanced' => esc_html__( 'Balanced', 'amaley-universal-showcase' ),
                'center'   => esc_html__( 'Centered Compact', 'amaley-universal-showcase' ),
                'split'    => esc_html__( 'Split Arrows', 'amaley-universal-showcase' ),
            ),
            'prefix_class' => 'aus-phone-nav-',
        ) );
        $this->end_controls_section();
    }

    private function card_family_controls( $type, $title, $template_label, $button_text, $words ) {
        $this->start_controls_section( $type . '_card_section', array( 'label' => esc_html__( $title . ' Card Controls', 'amaley-universal-showcase' ), 'condition' => array( 'content_type' => $type ) ) );
        $this->add_control( $type . '_card_template', array( 'label' => esc_html__( $title . ' Card Template', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'og_card_1', 'options' => array( 'og_card_1' => $template_label ) ) );
        foreach ( array( 'image'=>'Image / Fallback Initial', 'label'=>'Label', 'title'=>'Title', 'excerpt'=>'Description / Excerpt', 'meta'=>'Meta / Stat Boxes', 'tags'=>'Tags / Chips', 'button'=>'Button' ) as $key => $label ) {
            $this->add_control( $type . '_show_' . $key, array( 'label' => esc_html__( 'Show ' . $label, 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }
        $this->add_control( $type . '_label_text', array( 'label' => esc_html__( $title . ' Label Override', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ) );
        $this->add_control( $type . '_description_words', array( 'label' => esc_html__( $title . ' Description Word Limit', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 6, 'max' => 40, 'default' => $words ) );
        $this->add_control( $type . '_button_text', array( 'label' => esc_html__( $title . ' Button Text', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => $button_text ) );

        $this->add_control( $type . '_meta_heading', array(
            'label' => esc_html__( 'Meta Box Controls', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ) );

        if ( 'shg' === $type ) {
            $this->add_control( 'shg_show_village_meta', array( 'label' => esc_html__( 'Show Village Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'shg_show_district_meta', array( 'label' => esc_html__( 'Show District Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'shg_show_members_meta', array( 'label' => esc_html__( 'Show Members Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'shg_show_verification_meta', array( 'label' => esc_html__( 'Show Verification Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'shg_meta_order', array(
                'label' => esc_html__( 'SHG Meta Order', 'amaley-universal-showcase' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default' => esc_html__( 'Default: Village, District, Members, Verification', 'amaley-universal-showcase' ),
                    'members_first' => esc_html__( 'Members First', 'amaley-universal-showcase' ),
                    'village_members' => esc_html__( 'Village, Members, District, Verification', 'amaley-universal-showcase' ),
                ),
                'prefix_class' => 'aus-shg-meta-order-',
            ) );
        }

        if ( 'cluster' === $type ) {
            $this->add_control( 'cluster_show_district_meta', array( 'label' => esc_html__( 'Show District Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'cluster_show_villages_meta', array( 'label' => esc_html__( 'Show Villages Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'cluster_show_products_meta', array( 'label' => esc_html__( 'Show Products Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'cluster_show_status_meta', array( 'label' => esc_html__( 'Show Status Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }

        if ( 'member' === $type ) {
            $this->add_control( 'member_show_role_meta', array( 'label' => esc_html__( 'Show Role Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'member_show_village_meta', array( 'label' => esc_html__( 'Show Village Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
            $this->add_control( 'member_show_phone_meta', array( 'label' => esc_html__( 'Show Phone Box', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        }

        $this->end_controls_section();
    }

    private function slider_controls() {
        $this->start_controls_section( 'slider_section', array( 'label' => esc_html__( '4. Slider / Pagination Controls', 'amaley-universal-showcase' ) ) );
        $this->add_control( 'show_arrows', array( 'label' => esc_html__( 'Show Arrows', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_dots', array( 'label' => esc_html__( 'Show Dots', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'show_numbers', array( 'label' => esc_html__( 'Show Current / Total Number', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'desktop_cards_view', array( 'label' => esc_html__( 'Desktop Slider Cards Per View', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '4', 'options' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5' ) ) );
        $this->add_control( 'tablet_cards_view', array( 'label' => esc_html__( 'Tablet Slider Cards Per View', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '2', 'options' => array( '1'=>'1','1.5'=>'1.5','2'=>'2','2.5'=>'2.5','3'=>'3' ) ) );
        $this->add_control( 'mobile_cards_view', array( 'label' => esc_html__( 'Phone Cards Per View', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '1.12', 'options' => array( '1'=>'1','1.12'=>'1.12','1.25'=>'1.25','1.5'=>'1.5','2'=>'2' ) ) );
        $this->add_control( 'advanced_slider_heading', array( 'label' => esc_html__( 'Advanced Movement Controls', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'autoplay', array( 'label' => esc_html__( 'Autoplay', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'autoplay_speed', array( 'label' => esc_html__( 'Autoplay Speed (ms)', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1200, 'max' => 12000, 'step' => 100, 'default' => 3500 ) );
        $this->add_control( 'pause_on_hover', array( 'label' => esc_html__( 'Pause On Hover', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->add_control( 'loop_slider', array( 'label' => esc_html__( 'Loop Slider', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '' ) );
        $this->add_control( 'hide_nav_on_single_page', array( 'label' => esc_html__( 'Hide Navigation When Not Needed', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '1' ) );
        $this->end_controls_section();
    }

    private function style_section_controls() {
        $this->start_controls_section( 'style_section_box', array( 'label' => esc_html__( 'Section Box', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => esc_html__( 'Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), array( 'name' => 'section_background', 'selector' => '{{WRAPPER}} .aus-showcase' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_border', 'selector' => '{{WRAPPER}} .aus-showcase' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'section_shadow', 'selector' => '{{WRAPPER}} .aus-showcase' ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => esc_html__( 'Section Padding', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_margin', array( 'label' => esc_html__( 'Section Margin', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_radius', array( 'label' => esc_html__( 'Section Radius', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;' ) ) );
        $this->add_responsive_control( 'inner_width', array( 'label' => esc_html__( 'Inner Max Width', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 720, 'max' => 1760 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__inner' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function style_heading_controls() {
        $this->start_controls_section( 'style_heading', array( 'label' => esc_html__( 'Heading Elements', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'heading_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right') ), 'default' => 'left', 'selectors' => array( '{{WRAPPER}} .aus-showcase__heading' => 'text-align: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'heading_max_width', array( 'label' => esc_html__( 'Heading Max Width', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 260, 'max' => 1100 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__heading' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'description_max_width', array( 'label' => esc_html__( 'Description Max Width', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 240, 'max' => 1000 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__description' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'label_color', array( 'label' => esc_html__( 'Label Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'label_typography', 'selector' => '{{WRAPPER}} .aus-showcase__label' ) );
        $this->add_control( 'title_color', array( 'label' => esc_html__( 'Heading Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .aus-showcase__title' ) );
        $this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__description' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .aus-showcase__description' ) );
        $this->add_responsive_control( 'heading_bottom_gap', array( 'label' => esc_html__( 'Heading Bottom Gap', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 90 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__header' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function style_cta_controls() {
        $this->start_controls_section( 'style_section_cta', array( 'label' => esc_html__( 'Section CTA Button', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'bottom_cta_top_gap', array( 'label' => esc_html__( 'Top Gap From Cards / Navigation', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'default' => array( 'size' => 24, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__footer-cta' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'section_cta_padding', array( 'label' => esc_html__( 'Padding', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__section-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'section_cta_text', array( 'label' => esc_html__( 'Text Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__section-button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'section_cta_bg', array( 'label' => esc_html__( 'Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__section-button' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'section_cta_typography', 'selector' => '{{WRAPPER}} .aus-showcase__section-button' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'section_cta_border', 'selector' => '{{WRAPPER}} .aus-showcase__section-button' ) );
        $this->add_responsive_control( 'section_cta_radius', array( 'label' => esc_html__( 'Radius', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__section-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function style_card_box_controls() {
        $this->start_controls_section( 'style_cards', array( 'label' => esc_html__( 'Card Box', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_bg', array( 'label' => esc_html__( 'Card Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card' ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Card Radius', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Card Inner Padding', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_min_height', array( 'label' => esc_html__( 'Card Min Height', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 720 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'card_hover_lift', array( 'label' => esc_html__( 'Hover Lift', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => '1', 'default' => '', 'prefix_class' => 'aus-card-hover-lift-' ) );
        $this->end_controls_section();
    }

    private function style_card_media_controls() {
        $this->start_controls_section( 'style_card_media', array( 'label' => esc_html__( 'Card Image / Media', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 80, 'max' => 480 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'image_fit', array( 'label' => esc_html__( 'Image Fit', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '', 'options' => array( '' => 'Default', 'cover' => 'Cover', 'contain' => 'Contain' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__media img' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'image_radius', array( 'label' => esc_html__( 'Image Radius', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__media, {{WRAPPER}} .aus-showcase .amaley-card__media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function style_card_text_controls() {
        $this->start_controls_section( 'style_card_text', array( 'label' => esc_html__( 'Card Text', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'card_label_color', array( 'label' => esc_html__( 'Card Label Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__label' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_label_typography', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card__label' ) );
        $this->add_control( 'card_title_color', array( 'label' => esc_html__( 'Card Title Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__title' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_title_typography', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card__title' ) );
        $this->add_control( 'card_title_line_clamp', array(
            'label' => esc_html__( 'Title Line Limit', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '',
            'options' => array( '' => esc_html__( 'Default', 'amaley-universal-showcase' ), '2' => '2 Lines', '3' => '3 Lines', '4' => '4 Lines' ),
            'selectors_dictionary' => array(
                ''  => '',
                '2' => 'display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;',
                '3' => 'display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;',
                '4' => 'display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden;',
            ),
            'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__title' => '{{VALUE}}' ),
        ) );
        $this->add_control( 'card_excerpt_color', array( 'label' => esc_html__( 'Description Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__excerpt' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'card_excerpt_typography', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card__excerpt' ) );
        $this->add_responsive_control( 'card_text_align', array( 'label' => esc_html__( 'Text Alignment', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::CHOOSE, 'options' => array( 'left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right') ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__body' => 'text-align: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    private function style_card_meta_controls() {
        $this->start_controls_section( 'style_card_meta', array( 'label' => esc_html__( 'Meta Boxes / Tags', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'meta_bg', array( 'label' => esc_html__( 'Meta Box Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__meta-item' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'meta_label_color', array( 'label' => esc_html__( 'Meta Label Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__meta-item span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'meta_value_color', array( 'label' => esc_html__( 'Meta Value Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__meta-item strong' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_value_typography', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card__meta-item strong' ) );
        $this->add_responsive_control( 'meta_radius', array( 'label' => esc_html__( 'Meta Radius', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__meta-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'tag_bg', array( 'label' => esc_html__( 'Tag Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__tags span' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'tag_color', array( 'label' => esc_html__( 'Tag Text Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__tags span' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'tag_border', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card__tags span' ) );
        $this->end_controls_section();
    }

    private function style_card_button_controls() {
        $this->start_controls_section( 'style_card_button', array( 'label' => esc_html__( 'Card Button', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'button_width_mode', array(
            'label' => esc_html__( 'Button Width', 'amaley-universal-showcase' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'full',
            'options' => array( 'full' => esc_html__( 'Full Width', 'amaley-universal-showcase' ), 'auto' => esc_html__( 'Auto Width', 'amaley-universal-showcase' ) ),
            'selectors_dictionary' => array( 'full' => 'width:100%;', 'auto' => 'width:auto; align-self:flex-start;' ),
            'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__button' => '{{VALUE}}' ),
        ) );
        $this->add_control( 'button_text_color', array( 'label' => esc_html__( 'Text Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => esc_html__( 'Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__button' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_text_color_hover', array( 'label' => esc_html__( 'Hover Text Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__button:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg_hover', array( 'label' => esc_html__( 'Hover Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__button:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card__button' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'button_border', 'selector' => '{{WRAPPER}} .aus-showcase .amaley-card__button' ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => esc_html__( 'Padding', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => esc_html__( 'Radius', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .aus-showcase .amaley-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    private function style_navigation_controls() {
        $this->start_controls_section( 'style_nav', array( 'label' => esc_html__( 'Slider Navigation', 'amaley-universal-showcase' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'nav_gap', array( 'label' => esc_html__( 'Navigation Gap', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__nav' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'nav_top_gap', array( 'label' => esc_html__( 'Top Gap', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__nav' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'arrow_bg', array( 'label' => esc_html__( 'Arrow Background', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__arrow' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'arrow_color', array( 'label' => esc_html__( 'Arrow Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__arrow' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'arrow_border_color', array( 'label' => esc_html__( 'Arrow Border Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__arrow' => 'border-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'arrow_size', array( 'label' => esc_html__( 'Arrow Size', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 24, 'max' => 72 ) ), 'selectors' => array( '{{WRAPPER}} .aus-showcase__arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'dot_color', array( 'label' => esc_html__( 'Dot Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__dot' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'dot_active_color', array( 'label' => esc_html__( 'Active Dot Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__dot.is-active' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'counter_color', array( 'label' => esc_html__( 'Counter Color', 'amaley-universal-showcase' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .aus-showcase__counter' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_section();
    }

    private function post_options( $post_type ) {
        $options = array( '' => esc_html__( 'Select', 'amaley-universal-showcase' ) );
        $posts = get_posts( array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => 200,
            'orderby' => 'title',
            'order' => 'ASC',
            'fields' => 'ids',
            'no_found_rows' => true,
        ) );
        foreach ( $posts as $post_id ) {
            $options[ (string) $post_id ] = wp_specialchars_decode( get_the_title( $post_id ), ENT_QUOTES ) . ' — ID ' . absint( $post_id );
        }
        return $options;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $engine = isset( $GLOBALS['aus_showcase_plugin'] ) ? $GLOBALS['aus_showcase_plugin'] : null;
        if ( ! $engine && function_exists( 'aus_plugin' ) ) { $engine = aus_plugin(); }
        if ( $engine && method_exists( $engine, 'render' ) ) {
            echo $engine->render( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
}
