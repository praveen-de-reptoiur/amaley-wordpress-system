<?php
/** Amaley Member Archive Gallery Elementor widget — v1.0.76.3 manual Elementor gallery controls. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_Gallery_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_core_member_archive_gallery'; }
    public function get_title(){ return esc_html__( 'Amaley Member Archive Gallery', 'amaley-core' ); }
    public function get_icon(){ return 'eicon-gallery-masonry'; }
    public function get_categories(){ return array( 'amaley-core' ); }
    public function get_style_depends(){ return array( 'amaley-core-member-archive-sections' ); }
    private function defaults(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); return $r->gallery_defaults(); }
    protected function register_controls(){
        $d=$this->defaults();
        $this->start_controls_section('content_display',array('label'=>'1. Content + Show / Hide'));
        foreach(array('show_section'=>'Show Section','show_label'=>'Show Label','show_title'=>'Show Title','show_description'=>'Show Description','show_caption'=>'Show Caption','show_empty_fallback'=>'Show Empty/Fallback Card') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d[$k] ?? '1')); }
        foreach(array('label'=>'Label','title'=>'Title','description'=>'Description','caption_label'=>'Caption Label','empty_message'=>'Fallback Message') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>in_array($k,array('description','empty_message'),true)?\Elementor\Controls_Manager::TEXTAREA:\Elementor\Controls_Manager::TEXT,'default'=>$d[$k] ?? '','label_block'=>true)); }
        $this->end_controls_section();
        $this->start_controls_section('data',array('label'=>'2. Gallery Images / Source'));
        $this->add_control('gallery_source',array(
            'label'=>'Gallery Source',
            'type'=>\Elementor\Controls_Manager::SELECT,
            'default'=>$d['gallery_source'] ?? 'manual',
            'options'=>array(
                'manual'=>'Manual Elementor Images',
                'manual_then_records'=>'Manual Images, then Member Records',
                'member_records'=>'Member Records Only'
            ),
        ));
        $this->add_control('manual_gallery',array(
            'label'=>'Manual Gallery Images',
            'type'=>\Elementor\Controls_Manager::GALLERY,
            'default'=>$d['manual_gallery'] ?? array(),
            'description'=>'Archive page ke liye yahi use karein. Images Elementor se manually select/upload hongi.',
            'condition'=>array('gallery_source!'=>'member_records'),
        ));
        $this->add_control('manual_caption_source',array(
            'label'=>'Caption Source',
            'type'=>\Elementor\Controls_Manager::SELECT,
            'default'=>$d['manual_caption_source'] ?? 'attachment_title',
            'options'=>array(
                'attachment_title'=>'Attachment Title',
                'attachment_caption'=>'Attachment Caption',
                'attachment_alt'=>'Attachment Alt Text',
                'fallback'=>'Fallback Message'
            ),
            'condition'=>array('gallery_source!'=>'member_records'),
        ));
        $this->add_control('limit',array('label'=>'Image Limit','type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>24,'default'=>$d['limit'] ?? 6));
        $this->add_control('record_source_note',array('type'=>\Elementor\Controls_Manager::RAW_HTML,'raw'=>'Neeche ke filters sirf Member Records source ke liye hain. Manual archive gallery me inki zarurat nahi hai.','content_classes'=>'elementor-panel-alert elementor-panel-alert-info','condition'=>array('gallery_source!'=>'manual')));
        foreach(array('shg_id'=>'Filter by SHG ID','cluster_id'=>'Filter by Cluster ID') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d[$k],'label_block'=>true,'condition'=>array('gallery_source!'=>'manual'))); }
        $this->add_control('featured_only',array('label'=>'Featured Only','type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d['featured_only'],'condition'=>array('gallery_source!'=>'manual')));
        $this->add_control('show_only_website',array('label'=>'Show Only Website-visible','type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d['show_only_website'],'condition'=>array('gallery_source!'=>'manual')));
        $this->add_control('status',array('label'=>'Status','type'=>\Elementor\Controls_Manager::SELECT,'default'=>$d['status'],'options'=>array(''=>'Any','active'=>'Active','inactive'=>'Inactive','pending'=>'Pending'),'condition'=>array('gallery_source!'=>'manual')));
        $this->add_control('order_by',array('label'=>'Order By','type'=>\Elementor\Controls_Manager::SELECT,'default'=>$d['order_by'],'options'=>array('menu_order'=>'Menu Order + Title','title'=>'Title','date'=>'Date','modified'=>'Modified','rand'=>'Random'),'condition'=>array('gallery_source!'=>'manual')));
        $this->add_control('order',array('label'=>'Order','type'=>\Elementor\Controls_Manager::SELECT,'default'=>$d['order'],'options'=>array('ASC'=>'ASC','DESC'=>'DESC'),'condition'=>array('gallery_source!'=>'manual')));
        $this->end_controls_section();
        $this->start_controls_section('layout',array('label'=>'3. Layout / Responsive Columns'));
        foreach(array('columns_desktop'=>'Columns Desktop','columns_tablet'=>'Columns Tablet','columns_mobile'=>'Columns Mobile') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>5,'default'=>$d[$k])); }
        $this->end_controls_section();
        $this->start_controls_section('style_section',array('label'=>'4. Section / Heading Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('section_padding',array('label'=>'Section Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','%'),'selectors'=>array('{{WRAPPER}} .ampa-gallery-section'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('section_bg',array('label'=>'Section Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-gallery-section'=>'background: {{VALUE}};')));
        $this->add_responsive_control('heading_align',array('label'=>'Heading Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-section-head'=>'text-align: {{VALUE}};')));
        $this->add_control('label_color',array('label'=>'Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-kicker'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'label_typography','selector'=>'{{WRAPPER}} .ampa-kicker'));
        $this->add_control('heading_color',array('label'=>'Heading Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'heading_typography','selector'=>'{{WRAPPER}} .ampa-section-title'));
        $this->add_control('desc_color',array('label'=>'Description Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-desc'=>'color: {{VALUE}};')));
        $this->end_controls_section();
        $this->start_controls_section('style_gallery',array('label'=>'5. Gallery / Fallback Card Style','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('grid_gap',array('label'=>'Gallery Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>70)),'selectors'=>array('{{WRAPPER}} .ampa-gallery-grid'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('image_height',array('label'=>'Image / Fallback Height','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>110,'max'=>360)),'default'=>array('size'=>168,'unit'=>'px'),'tablet_default'=>array('size'=>168,'unit'=>'px'),'mobile_default'=>array('size'=>160,'unit'=>'px'),'selectors'=>array('{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card'=>'height: {{SIZE}}{{UNIT}};')));
        $this->add_control('image_fit',array('label'=>'Image Fit','type'=>\Elementor\Controls_Manager::SELECT,'default'=>'cover','options'=>array('cover'=>'Cover','contain'=>'Contain','fill'=>'Fill'),'selectors'=>array('{{WRAPPER}} .ampa-gallery-card img'=>'object-fit: {{VALUE}};')));
        $this->add_control('image_position',array('label'=>'Image Position','type'=>\Elementor\Controls_Manager::SELECT,'default'=>'center center','options'=>array('center center'=>'Center Center','center top'=>'Center Top','center bottom'=>'Center Bottom','left center'=>'Left Center','right center'=>'Right Center'),'selectors'=>array('{{WRAPPER}} .ampa-gallery-card img'=>'object-position: {{VALUE}};')));
        $this->add_responsive_control('fallback_max_width',array('label'=>'Fallback Card Max Width','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px','%'),'range'=>array('px'=>array('min'=>220,'max'=>900),'%'=>array('min'=>20,'max'=>100)),'default'=>array('size'=>430,'unit'=>'px'),'selectors'=>array('{{WRAPPER}} .ampa-gallery-empty-card'=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('card_radius',array('label'=>'Card Radius','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>60)),'selectors'=>array('{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card'=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_control('card_border_color',array('label'=>'Card Border Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card'=>'border-color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(),array('name'=>'gallery_card_shadow','selector'=>'{{WRAPPER}} .ampa-gallery-card, {{WRAPPER}} .ampa-gallery-empty-card'));
        $this->add_control('card_bg',array('label'=>'Fallback Card Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-gallery-empty-card'=>'background: {{VALUE}};')));
        $this->add_control('overlay_color',array('label'=>'Overlay Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-gallery-card::after, {{WRAPPER}} .ampa-gallery-empty-card::after'=>'background: linear-gradient(180deg,rgba(46,18,3,0) 35%, {{VALUE}} 100%);')));
        $this->add_responsive_control('caption_padding',array('label'=>'Caption Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','%'),'selectors'=>array('{{WRAPPER}} .ampa-gallery-card figcaption'=>'left: {{LEFT}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};')));
        $this->add_control('caption_label_color',array('label'=>'Caption Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'caption_label_typography','selector'=>'{{WRAPPER}} .ampa-gallery-card figcaption span, {{WRAPPER}} .ampa-gallery-empty-card span'));
        $this->add_control('caption_title_color',array('label'=>'Caption Title Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'caption_title_typography','selector'=>'{{WRAPPER}} .ampa-gallery-card figcaption strong, {{WRAPPER}} .ampa-gallery-empty-card strong'));
        $this->end_controls_section();
    }
    protected function render(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); echo $r->render_gallery($this->get_settings_for_display()); }
}
