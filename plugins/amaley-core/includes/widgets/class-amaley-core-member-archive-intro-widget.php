<?php
/** Amaley Member Archive Intro Elementor widget — v1.0.76 controls-only upgrade. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_Intro_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_core_member_archive_intro'; }
    public function get_title(){ return esc_html__( 'Amaley Member Archive Intro', 'amaley-core' ); }
    public function get_icon(){ return 'eicon-text-area'; }
    public function get_categories(){ return array( 'amaley-core' ); }
    public function get_style_depends(){ return array( 'amaley-core-member-archive-sections' ); }
    private function defaults(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); return $r->intro_defaults(); }
    protected function register_controls(){
        $d=$this->defaults();
        $this->start_controls_section('content_display',array('label'=>'1. Content + Show / Hide'));
        foreach(array('show_section'=>'Show Section','show_label'=>'Show Label','show_title'=>'Show Title','show_description'=>'Show Description','show_features'=>'Show Feature Cards','show_feature_1'=>'Show Feature 1','show_feature_2'=>'Show Feature 2','show_feature_3'=>'Show Feature 3') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d[$k] ?? '1')); }
        foreach(array('label'=>'Label','title'=>'Title','description'=>'Description') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>($k==='description'?\Elementor\Controls_Manager::TEXTAREA:\Elementor\Controls_Manager::TEXT),'default'=>$d[$k],'label_block'=>true)); }
        for($i=1;$i<=3;$i++){ $this->add_control('feature_'.$i.'_title',array('label'=>'Feature '.$i.' Title','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['feature_'.$i.'_title'],'condition'=>array('show_feature_'.$i=>'1'))); $this->add_control('feature_'.$i.'_text',array('label'=>'Feature '.$i.' Text','type'=>\Elementor\Controls_Manager::TEXTAREA,'default'=>$d['feature_'.$i.'_text'],'condition'=>array('show_feature_'.$i=>'1'))); }
        $this->end_controls_section();
        $this->start_controls_section('style_layout',array('label'=>'2. Section / Layout / Responsive','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('section_padding',array('label'=>'Section Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','%'),'selectors'=>array('{{WRAPPER}} .ampa-intro'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('section_bg',array('label'=>'Section Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-intro'=>'background: {{VALUE}};')));
        $this->add_responsive_control('column_gap',array('label'=>'Column Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>100)),'selectors'=>array('{{WRAPPER}} .ampa-intro-grid'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('content_align',array('label'=>'Text Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-intro-copy'=>'text-align: {{VALUE}};')));
        $this->end_controls_section();
        $this->start_controls_section('style_text',array('label'=>'3. Label / Heading / Description','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('label_color',array('label'=>'Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-kicker'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'label_typography','selector'=>'{{WRAPPER}} .ampa-kicker'));
        $this->add_control('title_color',array('label'=>'Title Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'heading_typography','selector'=>'{{WRAPPER}} .ampa-section-title'));
        $this->add_control('desc_color',array('label'=>'Description Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-section-desc'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'desc_typography','selector'=>'{{WRAPPER}} .ampa-section-desc'));
        $this->end_controls_section();
        $this->start_controls_section('style_cards',array('label'=>'4. Feature Cards','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('feature_gap',array('label'=>'Feature Card Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>70)),'selectors'=>array('{{WRAPPER}} .ampa-feature-grid'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_control('card_bg',array('label'=>'Card Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-feature-card'=>'background: {{VALUE}};')));
        $this->add_control('card_border',array('label'=>'Card Border Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-feature-card'=>'border-color: {{VALUE}};')));
        $this->add_responsive_control('card_padding',array('label'=>'Card Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-feature-card'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('card_radius',array('label'=>'Card Radius','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>50)),'selectors'=>array('{{WRAPPER}} .ampa-feature-card'=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_control('feature_title_color',array('label'=>'Feature Title Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-feature-card strong'=>'color: {{VALUE}};')));
        $this->add_control('feature_text_color',array('label'=>'Feature Text Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-feature-card p'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'feature_title_typography','selector'=>'{{WRAPPER}} .ampa-feature-card strong'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'feature_text_typography','selector'=>'{{WRAPPER}} .ampa-feature-card p'));
        $this->end_controls_section();
    }
    protected function render(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); echo $r->render_intro($this->get_settings_for_display()); }
}
