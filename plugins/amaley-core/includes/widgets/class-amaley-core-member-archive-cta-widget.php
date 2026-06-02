<?php
/** Amaley Member Archive CTA Elementor widget — v1.0.76 controls-only upgrade. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_CTA_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_core_member_archive_cta'; }
    public function get_title(){ return esc_html__( 'Amaley Member Archive CTA', 'amaley-core' ); }
    public function get_icon(){ return 'eicon-call-to-action'; }
    public function get_categories(){ return array( 'amaley-core' ); }
    public function get_style_depends(){ return array( 'amaley-core-member-archive-sections' ); }
    private function defaults(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); return $r->cta_defaults(); }
    protected function register_controls(){
        $d=$this->defaults();
        $this->start_controls_section('content_display',array('label'=>'1. Content + Show / Hide'));
        foreach(array('show_section'=>'Show Section','show_label'=>'Show Label','show_title'=>'Show Title','show_description'=>'Show Description','show_primary_button'=>'Show Primary Button','show_secondary_button'=>'Show Secondary Button') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d[$k])); }
        foreach(array('label'=>'Label','title'=>'Title','description'=>'Description') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>($k==='description'?\Elementor\Controls_Manager::TEXTAREA:\Elementor\Controls_Manager::TEXT),'default'=>$d[$k],'label_block'=>true)); }
        $this->end_controls_section();
        $this->start_controls_section('buttons_content',array('label'=>'2. Button Content / Links'));
        foreach(array('primary_text'=>'Primary Button Text','primary_url'=>'Primary Button URL','secondary_text'=>'Secondary Button Text','secondary_url'=>'Secondary Button URL') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d[$k],'label_block'=>true)); }
        $this->end_controls_section();
        $this->start_controls_section('style_layout',array('label'=>'3. Section / Layout / Alignment','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('section_padding',array('label'=>'Section Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','%'),'selectors'=>array('{{WRAPPER}} .ampa-cta'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('grid_gap',array('label'=>'Text / Button Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>90)),'selectors'=>array('{{WRAPPER}} .ampa-cta-grid'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('text_align',array('label'=>'Text Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-cta-grid > div:first-child'=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('button_align',array('label'=>'Button Alignment','type'=>\Elementor\Controls_Manager::SELECT,'options'=>array(''=>'Default','flex-start'=>'Left','center'=>'Center','flex-end'=>'Right'),'selectors'=>array('{{WRAPPER}} .ampa-cta .ampa-actions'=>'justify-content: {{VALUE}};')));
        $this->end_controls_section();
        $this->start_controls_section('style_background',array('label'=>'4. Background / Shape','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('section_bg',array('label'=>'Section Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-cta'=>'background: {{VALUE}};')));
        $this->add_control('shape_opacity',array('label'=>'Background Glow Opacity','type'=>\Elementor\Controls_Manager::SLIDER,'range'=>array('px'=>array('min'=>0,'max'=>1,'step'=>0.05)),'selectors'=>array('{{WRAPPER}} .ampa-cta::before'=>'opacity: {{SIZE}};')));
        $this->end_controls_section();
        $this->start_controls_section('style_text',array('label'=>'5. Label / Heading / Description','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('label_color',array('label'=>'Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-cta .ampa-kicker'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'label_typography','selector'=>'{{WRAPPER}} .ampa-cta .ampa-kicker'));
        $this->add_control('title_color',array('label'=>'Title Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-cta .ampa-section-title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'title_typography','selector'=>'{{WRAPPER}} .ampa-cta .ampa-section-title'));
        $this->add_control('desc_color',array('label'=>'Description Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-cta .ampa-section-desc'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'desc_typography','selector'=>'{{WRAPPER}} .ampa-cta .ampa-section-desc'));
        $this->end_controls_section();
        $this->start_controls_section('style_buttons',array('label'=>'6. Buttons','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('button_gap',array('label'=>'Button Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>50)),'selectors'=>array('{{WRAPPER}} .ampa-cta .ampa-actions'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_padding',array('label'=>'Button Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-cta .ampa-btn'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'button_typography','selector'=>'{{WRAPPER}} .ampa-cta .ampa-btn'));
        $this->add_control('primary_bg',array('label'=>'Primary Button Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-primary'=>'background: {{VALUE}}; border-color: {{VALUE}};')));
        $this->add_control('primary_color',array('label'=>'Primary Button Text','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-primary'=>'color: {{VALUE}};')));
        $this->add_control('secondary_bg',array('label'=>'Secondary Button Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-secondary'=>'background: {{VALUE}};')));
        $this->add_control('secondary_color',array('label'=>'Secondary Button Text','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-secondary'=>'color: {{VALUE}};')));
        $this->end_controls_section();
    }
    protected function render(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); echo $r->render_cta($this->get_settings_for_display()); }
}
