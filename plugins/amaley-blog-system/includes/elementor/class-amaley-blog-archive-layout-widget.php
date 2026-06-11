<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Archive_Layout_Widget extends Amaley_Blog_Elementor_Base {
    public function get_name() { return 'amaley_blog_archive_layout'; }
    public function get_title() { return __( 'Amaley Blog Archive Layout', 'amaley-blog-system' ); }
    public function get_icon() { return 'eicon-posts-grid'; }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
        $this->register_advanced_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section( 'section_query_layout', array( 'label' => __( 'Query & Layout', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ) );
        $this->add_control( 'posts_per_page', array( 'label' => __( 'Posts Per Page', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => Amaley_Blog_Settings::get( 'posts_per_page', 9 ), 'min' => 1, 'max' => 48 ) );
        $this->add_control( 'include_categories', array( 'label' => __( 'Include Categories', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT2, 'multiple' => true, 'options' => $this->select_categories_options() ) );
        $this->add_control( 'exclude_categories', array( 'label' => __( 'Exclude Categories', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT2, 'multiple' => true, 'options' => $this->select_categories_options() ) );
        $this->add_control( 'include_tags', array( 'label' => __( 'Include Tags', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT2, 'multiple' => true, 'options' => $this->select_tags_options() ) );
        $this->add_control( 'exclude_tags', array( 'label' => __( 'Exclude Tags', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT2, 'multiple' => true, 'options' => $this->select_tags_options() ) );
        $this->add_responsive_control( 'columns', array( 'label' => __( 'Columns', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => '3', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-grid' => '--amaley-blog-columns: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'sidebar_width', array( 'label' => __( 'Sidebar Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 220, 'max' => 420 ) ), 'default' => array( 'size' => 280, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-shell' => '--amaley-blog-sidebar-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_sidebar', array( 'label' => __( 'Sidebar Sections', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ) );
        $this->add_control( 'show_sidebar', array_merge( array( 'label' => __( 'Show Sidebar', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_search', array_merge( array( 'label' => __( 'Show Search', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_categories', array_merge( array( 'label' => __( 'Show Categories', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_tags', array_merge( array( 'label' => __( 'Show Tags', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_popular', array_merge( array( 'label' => __( 'Show Popular Posts', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'popular_count', array( 'label' => __( 'Popular Posts Count', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 3, 'min' => 1, 'max' => 8 ) );
        $this->add_control( 'show_promo', array_merge( array( 'label' => __( 'Show Promo Card', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_reset', array_merge( array( 'label' => __( 'Show Reset Filters', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_toolbar', array( 'label' => __( 'Toolbar', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ) );
        $this->add_control( 'show_result_count', array_merge( array( 'label' => __( 'Show Result Count', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'result_count_prefix', array( 'label' => __( 'Result Count Prefix', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Showing' ) );
        $this->add_control( 'show_sort', array_merge( array( 'label' => __( 'Show Sort Dropdown', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_view_toggle', array_merge( array( 'label' => __( 'Show View Toggle', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_pagination', array_merge( array( 'label' => __( 'Show Pagination', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_card', array( 'label' => __( 'Blog Card 1 — OG Card', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ) );
        $this->card_controls();
        $this->end_controls_section();

        $this->start_controls_section( 'section_messages', array( 'label' => __( 'Messages & Labels', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ) );
        $this->add_control( 'sidebar_title', array( 'label' => __( 'Sidebar Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Filter & Explore' ) );
        $this->add_control( 'search_placeholder', array( 'label' => __( 'Search Placeholder', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Search articles...' ) );
        $this->add_control( 'categories_title', array( 'label' => __( 'Categories Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Categories' ) );
        $this->add_control( 'all_categories_label', array( 'label' => __( 'All Categories Label', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'All Categories' ) );
        $this->add_control( 'tags_title', array( 'label' => __( 'Tags Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Tags' ) );
        $this->add_control( 'popular_title', array( 'label' => __( 'Popular Posts Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Popular Posts' ) );
        $this->add_control( 'reset_text', array( 'label' => __( 'Reset Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Clear filters' ) );
        $this->add_control( 'empty_title', array( 'label' => __( 'Empty State Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'No blog posts found.' ) );
        $this->add_control( 'empty_description', array( 'label' => __( 'Empty State Description', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Try changing your search or filters.' ) );
        $this->add_control( 'mobile_filter_text', array( 'label' => __( 'Mobile Filter Button Text', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Filter & Explore' ) );
        $this->add_control( 'drawer_close_text', array( 'label' => __( 'Drawer Close Text/Icon', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '×' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_promo', array( 'label' => __( 'Promo Card Content', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ) );
        $this->add_control( 'promo_heading', array( 'label' => __( 'Promo Heading', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Pure Shilajit' ) );
        $this->add_control( 'promo_subtitle', array( 'label' => __( 'Promo Subtitle', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'From the Himalayas' ) );
        $this->add_control( 'promo_button', array( 'label' => __( 'Promo Button', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Shop Now' ) );
        $this->add_control( 'promo_url', array( 'label' => __( 'Promo URL', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::URL ) );
        $this->add_control( 'promo_image', array( 'label' => __( 'Promo Image', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->end_controls_section();
    }

    private function register_style_controls() {
        $this->start_controls_section( 'style_archive_wrapper', array( 'label' => __( 'Archive Wrapper', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'section_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ea', 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-layout' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'section_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%', 'em' ), 'default' => array( 'top' => 68, 'right' => 42, 'bottom' => 78, 'left' => 42, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-layout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'container_width', array( 'label' => __( 'Container Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 860, 'max' => 1640 ) ), 'default' => array( 'size' => 1180, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-shell' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'column_gap', array( 'label' => __( 'Sidebar / Grid Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 12, 'max' => 80 ) ), 'default' => array( 'size' => 32, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-shell' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'archive_wrapper_border', 'selector' => '{{WRAPPER}} .amaley-blog-archive-layout' ) );
        $this->add_responsive_control( 'archive_wrapper_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-layout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'archive_wrapper_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-archive-layout' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_sidebar_panel', array( 'label' => __( 'Sidebar Panel', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'sidebar_bg', array( 'label' => __( 'Panel Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fffaf1', 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar__card' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'sidebar_padding', array( 'label' => __( 'Panel Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sidebar_radius', array( 'label' => __( 'Panel Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'sidebar_border', 'selector' => '{{WRAPPER}} .amaley-blog-sidebar__card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'sidebar_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-sidebar__card' ) );
        $this->add_control( 'sidebar_heading_color', array( 'label' => __( 'Main Heading Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar__card h3' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'sidebar_heading_typography', 'selector' => '{{WRAPPER}} .amaley-blog-sidebar__card h3' ) );
        $this->add_responsive_control( 'sidebar_heading_margin', array( 'label' => __( 'Main Heading Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar__card h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sidebar_card_gap', array( 'label' => __( 'Sidebar Card Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_search', array( 'label' => __( 'Search Field', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'search_height', array( 'label' => __( 'Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 32, 'max' => 80 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-search' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'search_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'search_bg', array( 'label' => __( 'Input Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .amaley-blog-search' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'search_text_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-search input' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'search_placeholder_color', array( 'label' => __( 'Placeholder Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-search input::placeholder' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'search_icon_color', array( 'label' => __( 'Icon Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-search button' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'search_typography', 'selector' => '{{WRAPPER}} .amaley-blog-search input' ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'search_border', 'selector' => '{{WRAPPER}} .amaley-blog-search' ) );
        $this->add_responsive_control( 'search_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'search_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-search' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_filters', array( 'label' => __( 'Categories / Tags', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'filters_style_tabs' );

        $this->start_controls_tab( 'filters_categories_tab', array( 'label' => __( 'Categories', 'amaley-blog-system' ) ) );
        $this->add_control( 'category_group_heading', array( 'label' => __( 'Category Group', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'category_group_margin', array( 'label' => __( 'Group Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'category_group_padding', array( 'label' => __( 'Group Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'category_divider_color', array( 'label' => __( 'Divider Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories' => 'border-top-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'category_list_gap', array( 'label' => __( 'List Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 36 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories ul' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'category_title_heading', array( 'label' => __( 'Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'category_title_typography', 'selector' => '{{WRAPPER}} .amaley-blog-filter-group--categories h4' ) );
        $this->add_control( 'category_title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories h4' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'category_title_margin', array( 'label' => __( 'Title Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'category_item_heading', array( 'label' => __( 'Items', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'category_item_typography', 'selector' => '{{WRAPPER}} .amaley-blog-filter-group--categories li button' ) );
        $this->add_control( 'category_item_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'category_item_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'category_item_padding', array( 'label' => __( 'Item Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'category_item_border', 'selector' => '{{WRAPPER}} .amaley-blog-filter-group--categories li button' ) );
        $this->add_responsive_control( 'category_item_radius', array( 'label' => __( 'Item Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'category_state_heading', array( 'label' => __( 'Hover / Active', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'category_item_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'category_item_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'category_item_active_color', array( 'label' => __( 'Active Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button.is-active' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'category_item_active_bg', array( 'label' => __( 'Active Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button.is-active' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'category_count_heading', array( 'label' => __( 'Count', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'category_count_typography', 'selector' => '{{WRAPPER}} .amaley-blog-filter-group--categories li button em' ) );
        $this->add_control( 'category_count_color', array( 'label' => __( 'Count Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button em' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'category_count_bg', array( 'label' => __( 'Count Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--categories li button em' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'filters_tags_tab', array( 'label' => __( 'Tags', 'amaley-blog-system' ) ) );
        $this->add_control( 'tag_group_heading', array( 'label' => __( 'Tag Group', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'tag_group_margin', array( 'label' => __( 'Group Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--tags' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'tag_group_padding', array( 'label' => __( 'Group Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--tags' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'tag_group_divider_color', array( 'label' => __( 'Divider Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--tags' => 'border-top-color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_title_heading', array( 'label' => __( 'Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'tag_title_typography', 'selector' => '{{WRAPPER}} .amaley-blog-filter-group--tags h4' ) );
        $this->add_control( 'tag_title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--tags h4' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'tag_title_margin', array( 'label' => __( 'Title Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-group--tags h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'tag_chip_heading', array( 'label' => __( 'Chips', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_responsive_control( 'tag_chip_gap', array( 'label' => __( 'Chip Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 32 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'tag_chip_typography', 'selector' => '{{WRAPPER}} .amaley-blog-tag-cloud button' ) );
        $this->add_control( 'tag_chip_color', array( 'label' => __( 'Chip Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_chip_bg', array( 'label' => __( 'Chip Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'tag_chip_padding', array( 'label' => __( 'Chip Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'tag_chip_border', 'selector' => '{{WRAPPER}} .amaley-blog-tag-cloud button' ) );
        $this->add_responsive_control( 'tag_chip_radius', array( 'label' => __( 'Chip Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'tag_chip_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-tag-cloud button' ) );
        $this->add_control( 'tag_state_heading', array( 'label' => __( 'Hover / Active', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'tag_chip_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_chip_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'tag_chip_active_color', array( 'label' => __( 'Active Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button.is-active' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'tag_chip_active_bg', array( 'label' => __( 'Active Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-tag-cloud button.is-active' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'filters_reset_tab', array( 'label' => __( 'Reset', 'amaley-blog-system' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'reset_typography', 'selector' => '{{WRAPPER}} .amaley-blog-reset' ) );
        $this->add_control( 'reset_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-reset' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'reset_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-reset' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'reset_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-reset' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'reset_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-reset' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'reset_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-reset:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'reset_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-reset:hover' => 'background: {{VALUE}};' ) ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'style_toolbar', array( 'label' => __( 'Toolbar / Sort / View', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'toolbar_tabs' );
        $this->start_controls_tab( 'toolbar_count_tab', array( 'label' => __( 'Result Count', 'amaley-blog-system' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'toolbar_result_typography', 'selector' => '{{WRAPPER}} .amaley-blog-result-count' ) );
        $this->add_control( 'toolbar_result_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-result-count' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'toolbar_result_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-result-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'toolbar_sort_tab', array( 'label' => __( 'Sort Dropdown', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'toolbar_gap', array( 'label' => __( 'Toolbar Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-toolbar__actions' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sort_width', array( 'label' => __( 'Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 120, 'max' => 320 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sort select' => 'min-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'sort_height', array( 'label' => __( 'Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 32, 'max' => 72 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sort select' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'sort_typography', 'selector' => '{{WRAPPER}} .amaley-blog-sort select' ) );
        $this->add_control( 'sort_text_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-sort select' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'sort_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-sort select' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'sort_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sort select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'sort_border', 'selector' => '{{WRAPPER}} .amaley-blog-sort select' ) );
        $this->add_responsive_control( 'sort_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sort select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'sort_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-sort select' ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'toolbar_view_tab', array( 'label' => __( 'View Toggle', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'view_wrapper_gap', array( 'label' => __( 'Button Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 24 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'view_wrapper_padding', array( 'label' => __( 'Wrapper Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'view_wrapper_bg', array( 'label' => __( 'Wrapper Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'view_wrapper_border', 'selector' => '{{WRAPPER}} .amaley-blog-view-toggle' ) );
        $this->add_responsive_control( 'view_wrapper_radius', array( 'label' => __( 'Wrapper Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'view_button_size', array( 'label' => __( 'Button Size', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 28, 'max' => 72 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'view_button_radius', array( 'label' => __( 'Button Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'view_icon_size', array( 'label' => __( 'Icon Size', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 10, 'max' => 34 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_control( 'view_icon_color', array( 'label' => __( 'Icon Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button svg rect, {{WRAPPER}} .amaley-blog-view-toggle button svg path' => 'stroke: {{VALUE}} !important; fill: none;' ) ) );
        $this->add_control( 'view_active_icon_color', array( 'label' => __( 'Active Icon Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button.is-active svg rect, {{WRAPPER}} .amaley-blog-view-toggle button.is-active svg path' => 'stroke: {{VALUE}} !important; fill: none;' ) ) );
        $this->add_control( 'view_button_bg', array( 'label' => __( 'Button Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'view_button_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button:hover' => 'background: {{VALUE}} !important;' ) ) );
        $this->add_control( 'view_active_bg', array( 'label' => __( 'Active Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-view-toggle button.is-active' => 'background: {{VALUE}} !important;' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'style_grid', array( 'label' => __( 'Blog Grid', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'grid_gap', array( 'label' => __( 'Grid Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 10, 'max' => 70 ) ), 'default' => array( 'size' => 24, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'equal_height_cards', array( 'label' => __( 'Equal Height Cards', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $this->add_responsive_control( 'list_layout_gap', array( 'label' => __( 'List View Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 10, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}}.amaley-blog-view-list .amaley-blog-grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_card', array( 'label' => __( 'Blog Card 1', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'card_style_tabs' );

        $this->start_controls_tab( 'card_box_tab', array( 'label' => __( 'Box', 'amaley-blog-system' ) ) );
        $this->add_control( 'card_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fffaf1', 'selectors' => array( '{{WRAPPER}} .amaley-blog-card' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'card_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_gap', array( 'label' => __( 'Body Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 34 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__body' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'card_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'default' => array( 'size' => 14, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card' => 'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .amaley-blog-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-card' ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_hover_shadow', 'label' => __( 'Hover Shadow', 'amaley-blog-system' ), 'selector' => '{{WRAPPER}} .amaley-blog-card:hover' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'card_image_tab', array( 'label' => __( 'Image', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'media_height', array( 'label' => __( 'Image Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 120, 'max' => 420 ) ), 'default' => array( 'size' => 230, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__media' => 'height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'media_radius', array( 'label' => __( 'Image Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__media, {{WRAPPER}} .amaley-blog-card__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'image_object_fit', array( 'label' => __( 'Object Fit', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'cover', 'options' => array( 'cover' => 'Cover', 'contain' => 'Contain', 'fill' => 'Fill' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__image' => 'object-fit: {{VALUE}};' ) ) );
        $this->add_control( 'image_object_position', array( 'label' => __( 'Object Position', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'center center', 'options' => array( 'center center' => 'Center', 'top center' => 'Top', 'bottom center' => 'Bottom', 'left center' => 'Left', 'right center' => 'Right' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__image' => 'object-position: {{VALUE}};' ) ) );
        $this->add_control( 'image_overlay_opacity', array( 'label' => __( 'Overlay Opacity', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__media:after' => 'opacity: {{SIZE}};' ) ) );
        $this->add_control( 'image_hover_scale', array( 'label' => __( 'Hover Scale', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 1.2, 'step' => 0.01 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card:hover .amaley-blog-card__image' => 'transform: scale({{SIZE}});' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'card_text_tab', array( 'label' => __( 'Text', 'amaley-blog-system' ) ) );
        $this->add_control( 'chip_heading', array( 'label' => __( 'Category Chip', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'chip_typography', 'selector' => '{{WRAPPER}} .amaley-blog-card__category' ) );
        $this->add_control( 'chip_color', array( 'label' => __( 'Chip Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__category' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'chip_bg', array( 'label' => __( 'Chip Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#a66d1f', 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__category' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'chip_padding', array( 'label' => __( 'Chip Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'chip_radius', array( 'label' => __( 'Chip Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'title_heading', array( 'label' => __( 'Title', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .amaley-blog-card__title' ) );
        $this->add_control( 'title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'title_hover_color', array( 'label' => __( 'Title Hover Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__title:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'title_margin', array( 'label' => __( 'Title Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'meta_heading', array( 'label' => __( 'Meta', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'meta_typography', 'selector' => '{{WRAPPER}} .amaley-blog-card__meta' ) );
        $this->add_control( 'meta_color', array( 'label' => __( 'Meta Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#8b5f45', 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__meta' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'excerpt_heading', array( 'label' => __( 'Excerpt', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'excerpt_typography', 'selector' => '{{WRAPPER}} .amaley-blog-card__excerpt' ) );
        $this->add_control( 'excerpt_color', array( 'label' => __( 'Excerpt Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#5a3a2a', 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__excerpt' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'excerpt_margin', array( 'label' => __( 'Excerpt Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'card_button_tab', array( 'label' => __( 'Button', 'amaley-blog-system' ) ) );
        $this->add_control( 'button_normal_heading', array( 'label' => __( 'Normal', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .amaley-blog-card__button' ) );
        $this->add_control( 'button_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__button' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__button' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'button_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'button_border', 'selector' => '{{WRAPPER}} .amaley-blog-card__button' ) );
        $this->add_responsive_control( 'button_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'button_hover_heading', array( 'label' => __( 'Hover', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'button_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__button:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'button_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__button:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'button_hover_border_color', array( 'label' => __( 'Hover Border Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-card__button:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'button_hover_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-card__button:hover' ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'style_popular', array( 'label' => __( 'Popular Posts', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'popular_tabs' );
        $this->start_controls_tab( 'popular_box_tab', array( 'label' => __( 'Box', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'popular_box_padding', array( 'label' => __( 'Box Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar__popular' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'popular_item_gap', array( 'label' => __( 'Item Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 32 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-popular' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'popular_divider_color', array( 'label' => __( 'Divider Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-popular__item' => 'border-bottom-color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'popular_text_tab', array( 'label' => __( 'Text', 'amaley-blog-system' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'popular_heading_typography', 'selector' => '{{WRAPPER}} .amaley-blog-sidebar__popular h3' ) );
        $this->add_control( 'popular_heading_color', array( 'label' => __( 'Heading Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar__popular h3' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'popular_title_typography', 'selector' => '{{WRAPPER}} .amaley-blog-popular__title' ) );
        $this->add_control( 'popular_title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-popular__title' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'popular_title_hover_color', array( 'label' => __( 'Title Hover Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-popular__title:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'popular_date_typography', 'selector' => '{{WRAPPER}} .amaley-blog-popular__date' ) );
        $this->add_control( 'popular_date_color', array( 'label' => __( 'Date Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-popular__date' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'popular_image_tab', array( 'label' => __( 'Image', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'popular_thumb_size', array( 'label' => __( 'Thumbnail Size', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 34, 'max' => 120 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-popular__thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'popular_thumb_radius', array( 'label' => __( 'Thumbnail Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-popular__thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'style_pagination', array( 'label' => __( 'Pagination', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'pagination_tabs' );
        $this->start_controls_tab( 'pagination_normal_tab', array( 'label' => __( 'Normal', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'pagination_gap', array( 'label' => __( 'Gap', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 40 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-pagination' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'pagination_button_size', array( 'label' => __( 'Button Size', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 24, 'max' => 70 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-pagination .page-numbers' => 'min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'pagination_bg', array( 'label' => __( 'Button Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fffaf1', 'selectors' => array( '{{WRAPPER}} .amaley-blog-pagination .page-numbers' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'pagination_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-pagination .page-numbers' => 'color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'pagination_border', 'selector' => '{{WRAPPER}} .amaley-blog-pagination .page-numbers' ) );
        $this->add_responsive_control( 'pagination_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'pagination_active_tab', array( 'label' => __( 'Active / Hover', 'amaley-blog-system' ) ) );
        $this->add_control( 'pagination_active_bg', array( 'label' => __( 'Active Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#a66d1f', 'selectors' => array( '{{WRAPPER}} .amaley-blog-pagination .page-numbers.current, {{WRAPPER}} .amaley-blog-pagination .page-numbers:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};' ) ) );
        $this->add_control( 'pagination_active_color', array( 'label' => __( 'Active Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .amaley-blog-pagination .page-numbers.current, {{WRAPPER}} .amaley-blog-pagination .page-numbers:hover' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'style_promo', array( 'label' => __( 'Promo Card', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'promo_tabs' );
        $this->start_controls_tab( 'promo_box_tab', array( 'label' => __( 'Box', 'amaley-blog-system' ) ) );
        $this->add_control( 'promo_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo' => 'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'promo_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'promo_min_height', array( 'label' => __( 'Min Height', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 120, 'max' => 460 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'promo_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'promo_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-promo' ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'promo_text_tab', array( 'label' => __( 'Text', 'amaley-blog-system' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'promo_title_typography', 'selector' => '{{WRAPPER}} .amaley-blog-promo span' ) );
        $this->add_control( 'promo_title_color', array( 'label' => __( 'Title Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#f8d66f', 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo span' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'promo_subtitle_color', array( 'label' => __( 'Subtitle Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ea', 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo small' => 'color: {{VALUE}};' ) ) );
        $this->end_controls_tab();
        $this->start_controls_tab( 'promo_button_tab', array( 'label' => __( 'Button', 'amaley-blog-system' ) ) );
        $this->add_control( 'promo_button_bg', array( 'label' => __( 'Button Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ea', 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo em' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'promo_button_color', array( 'label' => __( 'Button Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203', 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo em' => 'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'promo_button_radius', array( 'label' => __( 'Button Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-promo em' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'style_mobile_drawer', array( 'label' => __( 'Mobile Drawer', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->start_controls_tabs( 'mobile_drawer_tabs' );

        $this->start_controls_tab( 'mobile_drawer_toggle_tab', array( 'label' => __( 'Filter Button', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'mobile_filter_alignment', array(
            'label' => __( 'Alignment', 'amaley-blog-system' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => array(
                'left' => array( 'title' => __( 'Left', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-left' ),
                'center' => array( 'title' => __( 'Center', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-center' ),
                'right' => array( 'title' => __( 'Right', 'amaley-blog-system' ), 'icon' => 'eicon-text-align-right' ),
            ),
            'selectors' => array( '{{WRAPPER}} .amaley-blog-mobile-actions' => 'text-align: {{VALUE}};' ),
        ) );
        $this->add_control( 'mobile_filter_width', array(
            'label' => __( 'Button Width', 'amaley-blog-system' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'auto',
            'options' => array( 'auto' => __( 'Auto', 'amaley-blog-system' ), '100%' => __( 'Full Width', 'amaley-blog-system' ) ),
            'selectors' => array( '{{WRAPPER}} .amaley-blog-archive-layout .amaley-blog-filter-toggle' => 'width: {{VALUE}};' ),
        ) );
        $this->add_responsive_control( 'mobile_filter_margin', array(
            'label' => __( 'Margin', 'amaley-blog-system' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
        ) );
        $this->add_control( 'mobile_filter_normal_heading', array( 'label' => __( 'Normal', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'mobile_filter_typography', 'selector' => '{{WRAPPER}} .amaley-blog-filter-toggle' ) );
        $this->add_control( 'mobile_filter_color', array( 'label' => __( 'Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'mobile_filter_bg', array( 'label' => __( 'Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'mobile_filter_border', 'selector' => '{{WRAPPER}} .amaley-blog-filter-toggle' ) );
        $this->add_responsive_control( 'mobile_filter_radius', array( 'label' => __( 'Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'mobile_filter_padding', array( 'label' => __( 'Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'mobile_filter_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-filter-toggle' ) );
        $this->add_control( 'mobile_filter_hover_heading', array( 'label' => __( 'Hover', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'mobile_filter_hover_color', array( 'label' => __( 'Hover Text Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'mobile_filter_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'mobile_filter_hover_border_color', array( 'label' => __( 'Hover Border Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-filter-toggle:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'mobile_filter_hover_shadow', 'label' => __( 'Hover Shadow', 'amaley-blog-system' ), 'selector' => '{{WRAPPER}} .amaley-blog-filter-toggle:hover' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'mobile_drawer_panel_tab', array( 'label' => __( 'Drawer Panel', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'mobile_drawer_width_style', array(
            'label' => __( 'Drawer Width', 'amaley-blog-system' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => array( 'vw' => array( 'min' => 70, 'max' => 100 ), 'px' => array( 'min' => 280, 'max' => 520 ) ),
            'size_units' => array( 'vw', 'px' ),
            'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar' => '--amaley-blog-drawer-width: {{SIZE}}{{UNIT}};' ),
        ) );
        $this->add_control( 'mobile_drawer_bg', array( 'label' => __( 'Panel Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar-mobile-drawer .amaley-blog-sidebar' => 'background: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'mobile_drawer_padding', array( 'label' => __( 'Panel Padding', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar-mobile-drawer .amaley-blog-sidebar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'mobile_drawer_radius', array( 'label' => __( 'Panel Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar-mobile-drawer .amaley-blog-sidebar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'mobile_drawer_border', 'selector' => '{{WRAPPER}} .amaley-blog-sidebar-mobile-drawer .amaley-blog-sidebar' ) );
        $this->add_control( 'mobile_drawer_overlay_style', array( 'label' => __( 'Overlay Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar-mobile-drawer .amaley-blog-sidebar.is-open' => '--amaley-blog-drawer-overlay: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'mobile_drawer_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-sidebar-mobile-drawer .amaley-blog-sidebar.is-open' ) );
        $this->end_controls_tab();

        $this->start_controls_tab( 'mobile_drawer_close_tab', array( 'label' => __( 'Close Button', 'amaley-blog-system' ) ) );
        $this->add_responsive_control( 'drawer_close_size', array( 'label' => __( 'Size', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 24, 'max' => 72 ) ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar-mobile-drawer .amaley-blog-sidebar.is-open > .amaley-blog-drawer-close' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'drawer_close_margin', array( 'label' => __( 'Margin', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-drawer-close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'drawer_close_normal_heading', array( 'label' => __( 'Normal', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array( 'name' => 'drawer_close_typography', 'selector' => '{{WRAPPER}} .amaley-blog-drawer-close' ) );
        $this->add_control( 'drawer_close_color', array( 'label' => __( 'Close Icon Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-drawer-close' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_close_bg', array( 'label' => __( 'Close Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-drawer-close' => 'background: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array( 'name' => 'drawer_close_border', 'selector' => '{{WRAPPER}} .amaley-blog-drawer-close' ) );
        $this->add_responsive_control( 'drawer_close_radius', array( 'label' => __( 'Close Radius', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-drawer-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'drawer_close_shadow', 'selector' => '{{WRAPPER}} .amaley-blog-drawer-close' ) );
        $this->add_control( 'drawer_close_hover_heading', array( 'label' => __( 'Hover', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
        $this->add_control( 'drawer_close_hover_color', array( 'label' => __( 'Hover Icon Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-drawer-close:hover' => 'color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_close_hover_bg', array( 'label' => __( 'Hover Background', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-drawer-close:hover' => 'background: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_close_hover_border_color', array( 'label' => __( 'Hover Border Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .amaley-blog-drawer-close:hover' => 'border-color: {{VALUE}};' ) ) );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array( 'name' => 'drawer_close_hover_shadow', 'label' => __( 'Hover Shadow', 'amaley-blog-system' ), 'selector' => '{{WRAPPER}} .amaley-blog-drawer-close:hover' ) );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

    }


    private function register_advanced_controls() {
        $this->start_controls_section( 'section_mobile_behaviour', array( 'label' => __( 'Mobile Behaviour', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_ADVANCED ) );
        $this->add_control( 'sidebar_mobile_mode', array( 'label' => __( 'Sidebar Mode on Mobile', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'drawer', 'options' => array( 'drawer' => __( 'Drawer', 'amaley-blog-system' ), 'stacked' => __( 'Stacked', 'amaley-blog-system' ), 'hidden' => __( 'Hidden', 'amaley-blog-system' ) ) ) );
        $this->add_responsive_control( 'drawer_width', array( 'label' => __( 'Drawer Width', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => array( 'vw' => array( 'min' => 70, 'max' => 100 ), 'px' => array( 'min' => 280, 'max' => 480 ) ), 'size_units' => array( 'vw', 'px' ), 'default' => array( 'size' => 88, 'unit' => 'vw' ), 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar' => '--amaley-blog-drawer-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'drawer_overlay_color', array( 'label' => __( 'Drawer Overlay Color', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(0,0,0,.38)', 'selectors' => array( '{{WRAPPER}} .amaley-blog-sidebar.is-open' => '--amaley-blog-drawer-overlay: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'section_device_visibility', array( 'label' => __( 'Device Visibility', 'amaley-blog-system' ), 'tab' => \Elementor\Controls_Manager::TAB_ADVANCED ) );
        $visibility = array(
            'sidebar' => array( 'label' => __( 'Hide Sidebar', 'amaley-blog-system' ), 'selector' => '.amaley-blog-sidebar' ),
            'toolbar' => array( 'label' => __( 'Hide Toolbar', 'amaley-blog-system' ), 'selector' => '.amaley-blog-toolbar' ),
            'search' => array( 'label' => __( 'Hide Search', 'amaley-blog-system' ), 'selector' => '.amaley-blog-search' ),
            'tags' => array( 'label' => __( 'Hide Tags', 'amaley-blog-system' ), 'selector' => '.amaley-blog-tag-cloud' ),
            'popular' => array( 'label' => __( 'Hide Popular Posts', 'amaley-blog-system' ), 'selector' => '.amaley-blog-sidebar__popular' ),
            'promo' => array( 'label' => __( 'Hide Promo Card', 'amaley-blog-system' ), 'selector' => '.amaley-blog-promo' ),
            'card_image' => array( 'label' => __( 'Hide Card Image', 'amaley-blog-system' ), 'selector' => '.amaley-blog-card__media' ),
            'card_excerpt' => array( 'label' => __( 'Hide Card Excerpt', 'amaley-blog-system' ), 'selector' => '.amaley-blog-card__excerpt' ),
            'card_button' => array( 'label' => __( 'Hide Card Button', 'amaley-blog-system' ), 'selector' => '.amaley-blog-card__button' ),
        );
        foreach ( $visibility as $key => $data ) {
            $this->add_responsive_control( 'hide_' . $key, array( 'label' => $data['label'], 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'selectors' => array( '{{WRAPPER}} ' . $data['selector'] => 'display:none;' ) ) );
        }
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $s['client_side_archive'] = true;
        $query = Amaley_Blog_Query::archive_query( $s );
        $view = 'grid';
        $sidebar_mode = ! empty( $s['sidebar_mobile_mode'] ) ? sanitize_html_class( $s['sidebar_mobile_mode'] ) : 'drawer';
        $equal_height = ! empty( $s['equal_height_cards'] ) && 'yes' === $s['equal_height_cards'] ? ' is-equal-height' : '';
        ?>
        <section class="amaley-blog-archive-layout amaley-blog-view-<?php echo esc_attr( $view ); ?> amaley-blog-sidebar-mobile-<?php echo esc_attr( $sidebar_mode ); ?><?php echo esc_attr( $equal_height ); ?>" data-amaley-blog-archive data-posts-per-page="<?php echo esc_attr( ! empty( $s['posts_per_page'] ) ? absint( $s['posts_per_page'] ) : 9 ); ?>" data-result-prefix="<?php echo esc_attr( ! empty( $s['result_count_prefix'] ) ? $s['result_count_prefix'] : __( 'Showing', 'amaley-blog-system' ) ); ?>">
            <?php if ( $this->is_yes( $s, 'show_sidebar' ) && 'hidden' !== $sidebar_mode ) : ?>
                <div class="amaley-blog-mobile-actions">
                    <button class="amaley-blog-filter-toggle" type="button" data-amaley-blog-drawer-open><?php echo esc_html( ! empty( $s['mobile_filter_text'] ) ? $s['mobile_filter_text'] : __( 'Filter & Explore', 'amaley-blog-system' ) ); ?></button>
                </div>
            <?php endif; ?>
            <div class="amaley-blog-archive-shell">
                <?php if ( $this->is_yes( $s, 'show_sidebar' ) ) : ?>
                    <aside class="amaley-blog-sidebar" data-amaley-blog-drawer>
                        <button type="button" class="amaley-blog-drawer-close" data-amaley-blog-drawer-close><?php echo esc_html( ! empty( $s['drawer_close_text'] ) ? $s['drawer_close_text'] : '×' ); ?></button>
                        <?php $this->render_sidebar( $s ); ?>
                    </aside>
                <?php endif; ?>

                <div class="amaley-blog-archive-main">
                    <div class="amaley-blog-toolbar">
                        <?php if ( $this->is_yes( $s, 'show_result_count' ) ) : ?>
                            <div class="amaley-blog-result-count"><?php echo esc_html( $this->result_count_label( $query, $s ) ); ?></div>
                        <?php endif; ?>
                        <div class="amaley-blog-toolbar__actions">
                            <?php if ( $this->is_yes( $s, 'show_sort' ) ) : $this->render_sort(); endif; ?>
                            <?php if ( $this->is_yes( $s, 'show_view_toggle' ) ) : $this->render_view_toggle( $view ); endif; ?>
                        </div>
                    </div>

                    <div class="amaley-blog-grid">
                        <?php
                        if ( $query->have_posts() ) {
                            while ( $query->have_posts() ) {
                                $query->the_post();
                                echo Amaley_Blog_Renderer::card( get_the_ID(), $this->card_args( $s ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<div class="amaley-blog-empty"><strong>' . esc_html( ! empty( $s['empty_title'] ) ? $s['empty_title'] : __( 'No blog posts found.', 'amaley-blog-system' ) ) . '</strong><p>' . esc_html( ! empty( $s['empty_description'] ) ? $s['empty_description'] : __( 'Try changing your search or filters.', 'amaley-blog-system' ) ) . '</p></div>';
                        }
                        ?>
                    </div>
                    <?php if ( $this->is_yes( $s, 'show_pagination' ) ) : ?>
                        <nav class="amaley-blog-pagination" aria-label="Blog pagination" data-amaley-blog-pagination></nav>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function render_sidebar( $s ) {
        ?>
        <div class="amaley-blog-sidebar__card amaley-blog-sidebar__filters">
            <?php if ( ! empty( $s['sidebar_title'] ) ) : ?><h3><?php echo esc_html( $s['sidebar_title'] ); ?></h3><?php endif; ?>
            <?php if ( $this->is_yes( $s, 'show_search' ) ) : ?>
                <div class="amaley-blog-search" role="search">
                    <input type="search" data-amaley-blog-search value="" placeholder="<?php echo esc_attr( ! empty( $s['search_placeholder'] ) ? $s['search_placeholder'] : __( 'Search articles...', 'amaley-blog-system' ) ); ?>" />
                    <button type="button" data-amaley-blog-search-button aria-label="<?php esc_attr_e( 'Search', 'amaley-blog-system' ); ?>">⌕</button>
                </div>
            <?php endif; ?>
            <?php if ( $this->is_yes( $s, 'show_categories' ) ) : $this->render_categories( $s ); endif; ?>
            <?php if ( $this->is_yes( $s, 'show_tags' ) ) : $this->render_tags( $s ); endif; ?>
            <?php if ( $this->is_yes( $s, 'show_reset' ) ) : ?><button type="button" class="amaley-blog-reset is-hidden" data-amaley-blog-reset><?php echo esc_html( ! empty( $s['reset_text'] ) ? $s['reset_text'] : __( 'Clear filters', 'amaley-blog-system' ) ); ?></button><?php endif; ?>
        </div>
        <?php if ( $this->is_yes( $s, 'show_popular' ) ) : ?>
            <div class="amaley-blog-sidebar__card amaley-blog-sidebar__popular"><h3><?php echo esc_html( ! empty( $s['popular_title'] ) ? $s['popular_title'] : __( 'Popular Posts', 'amaley-blog-system' ) ); ?></h3><?php $this->render_popular( $s ); ?></div>
        <?php endif; ?>
        <?php if ( $this->is_yes( $s, 'show_promo' ) ) : ?>
            <?php $this->render_promo( $s ); ?>
        <?php endif; ?>
        <?php
    }

    private function render_categories( $s ) {
        $terms = get_terms( array( 'taxonomy' => 'category', 'hide_empty' => true ) );
        echo '<div class="amaley-blog-filter-group amaley-blog-filter-group--categories"><h4>' . esc_html( ! empty( $s['categories_title'] ) ? $s['categories_title'] : __( 'Categories', 'amaley-blog-system' ) ) . '</h4><ul>';
        echo '<li><button type="button" class="is-active" data-amaley-blog-category="all"><span>' . esc_html( ! empty( $s['all_categories_label'] ) ? $s['all_categories_label'] : __( 'All Categories', 'amaley-blog-system' ) ) . '</span></button></li>';
        if ( ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                printf( '<li><button type="button" data-amaley-blog-category="%1$s"><span>%2$s</span><em>%3$s</em></button></li>', esc_attr( $term->slug ), esc_html( $term->name ), esc_html( $term->count ) );
            }
        }
        echo '</ul></div>';
    }

    private function render_tags( $s ) {
        $terms = get_terms( array( 'taxonomy' => 'post_tag', 'hide_empty' => true, 'number' => 16 ) );
        echo '<div class="amaley-blog-filter-group amaley-blog-filter-group--tags"><h4>' . esc_html( ! empty( $s['tags_title'] ) ? $s['tags_title'] : __( 'Tags', 'amaley-blog-system' ) ) . '</h4><div class="amaley-blog-tag-cloud">';
        if ( ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                printf( '<button type="button" data-amaley-blog-tag="%1$s">%2$s</button>', esc_attr( $term->slug ), esc_html( $term->name ) );
            }
        }
        echo '</div></div>';
    }

    private function render_popular( $s ) {
        $q = Amaley_Blog_Query::popular_posts( ! empty( $s['popular_count'] ) ? absint( $s['popular_count'] ) : 3 );
        while ( $q->have_posts() ) { $q->the_post(); echo Amaley_Blog_Renderer::mini_post( get_the_ID() ); }
        wp_reset_postdata();
    }

    private function render_promo( $s ) {
        $url = ! empty( $s['promo_url']['url'] ) ? $s['promo_url']['url'] : '#';
        $target = ! empty( $s['promo_url']['is_external'] ) ? ' target="_blank"' : '';
        $rel = ! empty( $s['promo_url']['nofollow'] ) ? ' rel="nofollow"' : '';
        $img = ! empty( $s['promo_image']['url'] ) ? $s['promo_image']['url'] : '';
        ?>
        <a class="amaley-blog-promo" href="<?php echo esc_url( $url ); ?>"<?php echo $target . $rel; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> style="<?php echo $img ? 'background-image:url(' . esc_url( $img ) . ')' : ''; ?>">
            <span><?php echo esc_html( $s['promo_heading'] ); ?></span>
            <small><?php echo esc_html( $s['promo_subtitle'] ); ?></small>
            <em><?php echo esc_html( $s['promo_button'] ); ?></em>
        </a>
        <?php
    }

    private function render_sort() {
        ?>
        <div class="amaley-blog-sort">
            <select data-amaley-blog-sort aria-label="<?php esc_attr_e( 'Sort posts', 'amaley-blog-system' ); ?>">
                <option value="date_desc"><?php esc_html_e( 'Latest First', 'amaley-blog-system' ); ?></option>
                <option value="date_asc"><?php esc_html_e( 'Oldest First', 'amaley-blog-system' ); ?></option>
                <option value="title_asc"><?php esc_html_e( 'Title A–Z', 'amaley-blog-system' ); ?></option>
                <option value="title_desc"><?php esc_html_e( 'Title Z–A', 'amaley-blog-system' ); ?></option>
            </select>
        </div>
        <?php
    }

    private function render_view_toggle( $view ) {
        ?>
        <div class="amaley-blog-view-toggle" role="group" aria-label="<?php esc_attr_e( 'Change blog layout', 'amaley-blog-system' ); ?>">
            <button type="button" class="is-active" data-amaley-blog-view="grid" aria-label="<?php esc_attr_e( 'Grid view', 'amaley-blog-system' ); ?>" title="<?php esc_attr_e( 'Grid view', 'amaley-blog-system' ); ?>">
                <svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><rect x="3" y="3" width="5" height="5" rx="1.1"></rect><rect x="12" y="3" width="5" height="5" rx="1.1"></rect><rect x="3" y="12" width="5" height="5" rx="1.1"></rect><rect x="12" y="12" width="5" height="5" rx="1.1"></rect></svg>
            </button>
            <button type="button" data-amaley-blog-view="list" aria-label="<?php esc_attr_e( 'List view', 'amaley-blog-system' ); ?>" title="<?php esc_attr_e( 'List view', 'amaley-blog-system' ); ?>">
                <svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><rect x="3" y="4" width="4" height="4" rx="1"></rect><path d="M10 5h7"></path><path d="M10 7h5"></path><rect x="3" y="12" width="4" height="4" rx="1"></rect><path d="M10 13h7"></path><path d="M10 15h5"></path></svg>
            </button>
        </div>
        <?php
    }

    private function result_count_label( $query, $s ) {
        $paged = max( 1, $query->get( 'paged' ) );
        $ppp = ! empty( $s['posts_per_page'] ) ? max( 1, absint( $s['posts_per_page'] ) ) : max( 1, $query->get( 'posts_per_page' ) );
        $start = $query->found_posts ? ( ( $paged - 1 ) * $ppp + 1 ) : 0;
        $end = min( $query->found_posts, $paged * $ppp );
        $prefix = ! empty( $s['result_count_prefix'] ) ? $s['result_count_prefix'] : __( 'Showing', 'amaley-blog-system' );
        return sprintf( '%1$s %2$s–%3$s of %4$s results', $prefix, $start, $end, $query->found_posts );
    }

    private function is_yes( $settings, $key ) {
        return ! empty( $settings[ $key ] ) && 'yes' === $settings[ $key ];
    }

    private function select_tags_options() {
        $terms = get_terms( array( 'taxonomy' => 'post_tag', 'hide_empty' => false ) );
        $options = array();
        if ( ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) { $options[ $term->term_id ] = $term->name; }
        }
        return $options;
    }
}
