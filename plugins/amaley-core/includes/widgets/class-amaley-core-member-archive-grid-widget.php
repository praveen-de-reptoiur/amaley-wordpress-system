<?php
/**
 * Amaley Member Archive Grid Elementor widget.
 *
 * v1.0.99.4 source note:
 * - Adds Card Template selector for Current / Existing Card and OG Member Card 1.
 * - Keeps render-level show/hide controls for Member Archive cards.
 * - Uses existing Member Archive style-control classes bridged in the renderer.
 * - Does not add heavy OG full-control sections or transform controls.
 *
 * @package Amaley_Core
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_Grid_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_core_member_archive_grid'; }
    public function get_title(){ return esc_html__( 'Amaley Member Archive Grid', 'amaley-core' ); }
    public function get_icon(){ return 'eicon-posts-grid'; }
    public function get_categories(){ return array( 'amaley-core' ); }
    public function get_style_depends(){ return array( 'amaley-core-member-archive-sections' ); }
    private function defaults(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); return $r->grid_defaults(); }
    protected function register_controls(){
        $d=$this->defaults();
        $this->start_controls_section('heading_content',array('label'=>'1. Heading Content + Show / Hide'));
        foreach(array('show_section'=>'Show Section','show_label'=>'Show Section Label','show_title'=>'Show Section Title','show_description'=>'Show Section Description') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d[$k])); }
        foreach(array('label'=>'Section Label','title'=>'Section Title','description'=>'Section Description') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>($k==='description'?\Elementor\Controls_Manager::TEXTAREA:\Elementor\Controls_Manager::TEXT),'default'=>$d[$k],'label_block'=>true)); }
        $this->end_controls_section();

        $this->start_controls_section('card_elements',array('label'=>'2. Card Template + Elements + Button Content'));
        $this->add_control('card_template',array(
            'label'=>'Card Template',
            'type'=>\Elementor\Controls_Manager::SELECT,
            'default'=>$d['card_template'] ?? 'current_existing',
            'options'=>array(
                'current_existing'=>'Current / Existing Card',
                'og_card_1'=>'OG Member Card 1',
            ),
            'description'=>'Lightweight selector only. Style controls are not force-mapped to OG card to keep Elementor editor stable.',
        ));
        foreach(array('show_image'=>'Show Image / Placeholder','show_placeholder'=>'Show Placeholder When No Image','show_card_label'=>'Show Card Label','show_role'=>'Show Role Detail','show_village'=>'Show Village Detail','show_shg'=>'Show SHG Detail','show_cluster'=>'Show Cluster Detail','show_skills'=>'Show Skill Tags','show_products'=>'Show Product Tags','show_bio'=>'Show Bio / Description','show_button'=>'Show Card Button','show_section_button'=>'Show Section Button') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d[$k] ?? '1')); }
        $this->add_control('card_label_text',array('label'=>'Card Label Text','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['card_label_text'],'condition'=>array('show_card_label'=>'1')));
        $this->add_control('button_text',array('label'=>'Card Button Text','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['button_text'],'condition'=>array('show_button'=>'1')));
        $this->add_control('detail_url_pattern',array('label'=>'Card Button URL Pattern','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['detail_url_pattern'],'label_block'=>true,'condition'=>array('show_button'=>'1')));
        $this->add_control('section_button_text',array('label'=>'Section Button Text','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['section_button_text'],'condition'=>array('show_section_button'=>'1')));
        $this->add_control('section_button_url',array('label'=>'Section Button URL','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['section_button_url'],'label_block'=>true,'condition'=>array('show_section_button'=>'1')));
        $this->add_control('empty_message',array('label'=>'Fallback / Empty Message','type'=>\Elementor\Controls_Manager::TEXTAREA,'default'=>$d['empty_message']));
        $this->end_controls_section();

        $this->start_controls_section('data_query',array('label'=>'3. Data / Query / Source'));
        foreach(array('limit'=>'Limit','shg_id'=>'Filter by SHG ID','cluster_id'=>'Filter by Cluster ID','include_ids'=>'Include IDs','exclude_ids'=>'Exclude IDs','bio_word_limit'=>'Bio Word Limit') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d[$k] ?? '','label_block'=>true)); }
        $this->add_control('max_skill_tags',array('label'=>'Max Skill Chips','type'=>\Elementor\Controls_Manager::NUMBER,'min'=>0,'max'=>12,'default'=>$d['max_skill_tags'] ?? $d['max_tags'] ?? 3,'condition'=>array('show_skills'=>'1')));
        $this->add_control('max_product_tags',array('label'=>'Max Product Chips','type'=>\Elementor\Controls_Manager::NUMBER,'min'=>0,'max'=>12,'default'=>$d['max_product_tags'] ?? 0,'condition'=>array('show_products'=>'1')));
        $this->add_control('max_tags',array('label'=>'Total Max Chips Fallback','type'=>\Elementor\Controls_Manager::NUMBER,'min'=>0,'max'=>12,'default'=>$d['max_tags'] ?? 3,'description'=>'Fallback limit only. Prefer Max Skill Chips / Max Product Chips above.'));
        $this->add_control('featured_only',array('label'=>'Featured Only','type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d['featured_only']));
        $this->add_control('show_only_website',array('label'=>'Show Only Website-visible','type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d['show_only_website']));
        $this->add_control('status',array('label'=>'Status','type'=>\Elementor\Controls_Manager::SELECT,'default'=>$d['status'],'options'=>array(''=>'Any','active'=>'Active','inactive'=>'Inactive','pending'=>'Pending')));
        $this->add_control('order_by',array('label'=>'Order By','type'=>\Elementor\Controls_Manager::SELECT,'default'=>$d['order_by'],'options'=>array('menu_order'=>'Menu Order + Title','title'=>'Title','date'=>'Date','modified'=>'Modified','rand'=>'Random')));
        $this->add_control('order',array('label'=>'Order','type'=>\Elementor\Controls_Manager::SELECT,'default'=>$d['order'],'options'=>array('ASC'=>'ASC','DESC'=>'DESC')));
        $this->end_controls_section();

        $this->start_controls_section('layout_columns',array('label'=>'4. Layout / Responsive Columns'));
        foreach(array('columns_desktop'=>'Columns Desktop','columns_tablet'=>'Columns Tablet','columns_mobile'=>'Columns Mobile') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>6,'default'=>$d[$k])); }
        $this->end_controls_section();

        $this->start_controls_section('style_section',array('label'=>'5. Section / Heading Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('section_padding',array('label'=>'Section Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','%'),'selectors'=>array('{{WRAPPER}} .ampa-grid-section'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('section_bg',array('label'=>'Section Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-grid-section'=>'background: {{VALUE}};')));
        $this->add_responsive_control('heading_align',array('label'=>'Heading Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-section-head'=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('heading_gap',array('label'=>'Heading to Cards Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>70)),'selectors'=>array('{{WRAPPER}} .ampa-section-head'=>'margin-bottom: {{SIZE}}{{UNIT}};')));
        $this->add_control('label_color',array('label'=>'Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-kicker'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'label_typography','selector'=>'{{WRAPPER}} .ampa-kicker'));
        $this->add_control('heading_color',array('label'=>'Heading Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'heading_typography','selector'=>'{{WRAPPER}} .ampa-section-title'));
        $this->add_control('description_color',array('label'=>'Description Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-desc'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'description_typography','selector'=>'{{WRAPPER}} .ampa-section-desc'));
        $this->end_controls_section();

        $this->start_controls_section('style_grid_card',array('label'=>'6. Card / Box Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('grid_gap',array('label'=>'Card Grid Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>70)),'selectors'=>array('{{WRAPPER}} .ampa-card-grid'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('card_bg',array('label'=>'Card Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-member-card'=>'background: {{VALUE}};')));
        $this->add_control('card_border',array('label'=>'Card Border Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-member-card'=>'border-color: {{VALUE}};')));
        $this->add_responsive_control('card_radius',array('label'=>'Card Radius','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>60)),'selectors'=>array('{{WRAPPER}} .ampa-member-card'=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('body_padding',array('label'=>'Card Body Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-member-body'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('body_gap',array('label'=>'Card Internal Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>40)),'selectors'=>array('{{WRAPPER}} .ampa-member-body'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('card_content_align',array('label'=>'Card Content Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-member-body'=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('card_min_height',array('label'=>'Card Minimum Height','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>620)),'selectors'=>array('{{WRAPPER}} .ampa-member-card'=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_image',array('label'=>'7. Image / Placeholder Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('image_height',array('label'=>'Image Height','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>80,'max'=>420)),'selectors'=>array('{{WRAPPER}} .ampa-member-media'=>'height: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};')));
        $this->add_control('image_fit',array('label'=>'Image Fit','type'=>\Elementor\Controls_Manager::SELECT,'options'=>array('cover'=>'Cover Center','contain'=>'Contain Full Image'),'selectors'=>array('{{WRAPPER}} .ampa-member-media img'=>'object-fit: {{VALUE}}; object-position: center center;')));
        $this->add_control('placeholder_bg',array('label'=>'Placeholder Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-member-media'=>'background: {{VALUE}};')));
        $this->add_control('placeholder_text',array('label'=>'Placeholder Text Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-member-media span'=>'color: {{VALUE}};')));
        $this->add_responsive_control('placeholder_size',array('label'=>'Placeholder Circle Size','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>32,'max'=>110)),'selectors'=>array('{{WRAPPER}} .ampa-member-media span'=>'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'placeholder_typography','selector'=>'{{WRAPPER}} .ampa-member-media span'));
        $this->end_controls_section();

        $this->start_controls_section('style_text',array('label'=>'8. Card Text / Meta / Tags','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('card_label_color',array('label'=>'Card Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-label'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'card_label_typography','selector'=>'{{WRAPPER}} .ampa-card-label'));
        $this->add_control('card_title_color',array('label'=>'Card Title Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-member-body h3'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'card_title_typography','selector'=>'{{WRAPPER}} .ampa-member-body h3'));
        $this->add_control('card_desc_color',array('label'=>'Bio Text Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-desc'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'card_desc_typography','selector'=>'{{WRAPPER}} .ampa-card-desc'));
        $this->add_responsive_control('label_margin',array('label'=>'Label Margin Bottom','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>40)),'selectors'=>array('{{WRAPPER}} .ampa-card-label'=>'margin-bottom: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('title_margin',array('label'=>'Title Margin Bottom','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>40)),'selectors'=>array('{{WRAPPER}} .ampa-member-body h3'=>'margin-bottom: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('desc_margin',array('label'=>'Bio Margin Bottom','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>40)),'selectors'=>array('{{WRAPPER}} .ampa-card-desc'=>'margin-bottom: {{SIZE}}{{UNIT}};')));
        $this->add_control('desc_line_clamp',array('label'=>'Bio Line Clamp','type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>8,'default'=>2,'selectors'=>array('{{WRAPPER}} .ampa-card-desc'=>'-webkit-line-clamp: {{VALUE}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_meta',array('label'=>'9. Meta Boxes Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('meta_columns',array('label'=>'Meta Columns','type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>4,'default'=>2,'selectors'=>array('{{WRAPPER}} .ampa-card-meta'=>'grid-template-columns: repeat({{VALUE}}, minmax(0,1fr));')));
        $this->add_responsive_control('meta_gap',array('label'=>'Meta Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>35)),'selectors'=>array('{{WRAPPER}} .ampa-card-meta'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('meta_margin',array('label'=>'Meta Margin','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-card-meta'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('meta_box_padding',array('label'=>'Meta Box Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-card-meta div'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('meta_box_bg',array('label'=>'Meta Box Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-meta div'=>'background: {{VALUE}};')));
        $this->add_control('meta_box_border',array('label'=>'Meta Box Border Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-meta div'=>'border-color: {{VALUE}};')));
        $this->add_control('meta_label_color',array('label'=>'Meta Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-meta dt'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'meta_label_typography','selector'=>'{{WRAPPER}} .ampa-card-meta dt'));
        $this->add_control('meta_value_color',array('label'=>'Meta Value Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-meta dd'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'meta_value_typography','selector'=>'{{WRAPPER}} .ampa-card-meta dd'));
        $this->add_control('meta_value_line_clamp',array('label'=>'Meta Value Line Clamp','type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>5,'default'=>2,'selectors'=>array('{{WRAPPER}} .ampa-card-meta dd'=>'-webkit-line-clamp: {{VALUE}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_chips_button',array('label'=>'10. Chips + Button Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('chip_gap',array('label'=>'Chip Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>30)),'selectors'=>array('{{WRAPPER}} .ampa-chip-row'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('chip_margin',array('label'=>'Chip Row Margin','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-chip-row'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('chip_padding',array('label'=>'Chip Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-chip-row span'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('chip_bg',array('label'=>'Chip Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-chip-row span'=>'background: {{VALUE}};')));
        $this->add_control('chip_color',array('label'=>'Chip Text Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-chip-row span'=>'color: {{VALUE}};')));
        $this->add_control('chip_border',array('label'=>'Chip Border Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-chip-row span'=>'border-color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'chip_typography','selector'=>'{{WRAPPER}} .ampa-chip-row span'));
        $this->add_responsive_control('button_align',array('label'=>'Card Button Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right'),'stretch'=>array('title'=>'Stretch','icon'=>'eicon-h-align-stretch')),'selectors'=>array('{{WRAPPER}} .ampa-card-button'=>'align-self: {{VALUE}};')));
        $this->add_responsive_control('button_padding',array('label'=>'Button Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-card-button'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_margin_top',array('label'=>'Button Margin Top','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>60)),'selectors'=>array('{{WRAPPER}} .ampa-card-button'=>'margin-top: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_radius',array('label'=>'Button Radius','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>80)),'selectors'=>array('{{WRAPPER}} .ampa-card-button'=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_control('button_bg',array('label'=>'Button Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-button'=>'background: {{VALUE}} !important;')));
        $this->add_control('button_color',array('label'=>'Button Text Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-button'=>'color: {{VALUE}} !important;')));
        $this->add_control('button_hover_bg',array('label'=>'Button Hover Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-button:hover'=>'background: {{VALUE}} !important;')));
        $this->add_control('button_hover_color',array('label'=>'Button Hover Text Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-card-button:hover'=>'color: {{VALUE}} !important;')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'button_typography','selector'=>'{{WRAPPER}} .ampa-card-button'));
        $this->end_controls_section();
        $this->start_controls_section('style_section_button',array('label'=>'11. Section Button Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('section_button_align',array('label'=>'Section Button Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-section-actions'=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('section_button_margin_top',array('label'=>'Section Button Top Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>80)),'selectors'=>array('{{WRAPPER}} .ampa-section-actions'=>'margin-top: {{SIZE}}{{UNIT}};')));
        $this->add_control('section_button_bg',array('label'=>'Section Button Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-button'=>'background: {{VALUE}};')));
        $this->add_control('section_button_color',array('label'=>'Section Button Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-button'=>'color: {{VALUE}};')));
        $this->end_controls_section();
    }
    protected function render(){ $settings=$this->get_settings_for_display(); echo $GLOBALS['amaley_core_member_archive_sections']->render_grid($settings); }
}
