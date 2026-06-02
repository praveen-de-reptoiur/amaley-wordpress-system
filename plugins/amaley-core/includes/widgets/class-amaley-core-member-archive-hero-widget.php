<?php
/** Amaley Member Archive Hero Elementor widget — v1.0.76 controls-only upgrade. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_core_member_archive_hero'; }
    public function get_title(){ return esc_html__( 'Amaley Member Archive Hero', 'amaley-core' ); }
    public function get_icon(){ return 'eicon-archive-title'; }
    public function get_categories(){ return array( 'amaley-core' ); }
    public function get_style_depends(){ return array( 'amaley-core-member-archive-sections' ); }
    private function defaults(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); return $r->hero_defaults(); }

    protected function register_controls(){
        $d=$this->defaults();
        $this->start_controls_section('content_display',array('label'=>'1. Content + Show / Hide'));
        foreach(array(
            'show_section'=>'Show Section','show_breadcrumb'=>'Show Breadcrumb','show_label'=>'Show Label','show_title'=>'Show Title','show_accent'=>'Show Accent Word','show_description'=>'Show Description','show_primary_button'=>'Show Primary Button','show_secondary_button'=>'Show Secondary Button','show_stats'=>'Show Stats Panel','show_stat_value'=>'Show Stat Values','show_stat_label'=>'Show Stat Labels'
        ) as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d[$k] ?? '1')); }
        foreach(array('breadcrumb'=>'Breadcrumb','label'=>'Small Label','title'=>'Main Heading','accent'=>'Accent Word','description'=>'Description') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>($k==='description'?\Elementor\Controls_Manager::TEXTAREA:\Elementor\Controls_Manager::TEXT),'default'=>$d[$k],'label_block'=>true)); }
        $this->end_controls_section();

        $this->start_controls_section('buttons_content',array('label'=>'2. Button Content / Links'));
        foreach(array('primary_text'=>'Primary Button Text','primary_url'=>'Primary Button URL','secondary_text'=>'Secondary Button Text','secondary_url'=>'Secondary Button URL') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d[$k],'label_block'=>true)); }
        $this->end_controls_section();

        $this->start_controls_section('stats_content',array('label'=>'3. Stats Content / Layout'));
        $this->add_control('stats_mode',array('label'=>'Stats Mode','type'=>\Elementor\Controls_Manager::SELECT,'default'=>$d['stats_mode'],'options'=>array('dynamic'=>'Dynamic','manual'=>'Manual')));
        for($i=1;$i<=4;$i++){ $this->add_control('stat_'.$i.'_value',array('label'=>'Stat '.$i.' Value','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['stat_'.$i.'_value'],'condition'=>array('stats_mode'=>'manual'))); $this->add_control('stat_'.$i.'_label',array('label'=>'Stat '.$i.' Label','type'=>\Elementor\Controls_Manager::TEXT,'default'=>$d['stat_'.$i.'_label'],'condition'=>array('stats_mode'=>'manual'))); }
        foreach(array('stats_columns_desktop'=>'Stats Columns Desktop','stats_columns_tablet'=>'Stats Columns Tablet','stats_columns_mobile'=>'Stats Columns Mobile') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>4,'default'=>$d[$k])); }
        $this->end_controls_section();

        $this->start_controls_section('style_layout',array('label'=>'4. Section / Layout','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('section_padding',array('label'=>'Section Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','%'),'selectors'=>array('{{WRAPPER}} .ampa-hero'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('container_width',array('label'=>'Container Max Width','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>760,'max'=>1500)),'selectors'=>array('{{WRAPPER}} .ampa-wrap'=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('grid_gap',array('label'=>'Copy / Stats Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>90)),'selectors'=>array('{{WRAPPER}} .ampa-hero-grid'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('copy_align',array('label'=>'Copy Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-hero-copy'=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('stats_align',array('label'=>'Stats Panel Alignment','type'=>\Elementor\Controls_Manager::SELECT,'options'=>array(''=>'Default','start'=>'Left','center'=>'Center','end'=>'Right','stretch'=>'Stretch'),'selectors'=>array('{{WRAPPER}} .ampa-hero-panel'=>'justify-self: {{VALUE}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_background',array('label'=>'5. Background / Shape','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('hero_bg',array('label'=>'Hero Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-hero'=>'background: {{VALUE}};')));
        $this->add_control('shape_opacity',array('label'=>'Background Texture Opacity','type'=>\Elementor\Controls_Manager::SLIDER,'range'=>array('px'=>array('min'=>0,'max'=>1,'step'=>0.05)),'selectors'=>array('{{WRAPPER}} .ampa-hero::after'=>'opacity: {{SIZE}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_text',array('label'=>'6. Breadcrumb / Label / Heading / Text','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('breadcrumb_color',array('label'=>'Breadcrumb Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-breadcrumb'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'breadcrumb_typography','selector'=>'{{WRAPPER}} .ampa-breadcrumb'));
        $this->add_control('label_color',array('label'=>'Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-kicker'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'label_typography','selector'=>'{{WRAPPER}} .ampa-kicker'));
        $this->add_control('title_color',array('label'=>'Heading Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-title'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'title_typography','selector'=>'{{WRAPPER}} .ampa-title'));
        $this->add_control('accent_color',array('label'=>'Accent Word Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-title em'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'accent_typography','selector'=>'{{WRAPPER}} .ampa-title em'));
        $this->add_control('description_color',array('label'=>'Description Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-description'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'description_typography','selector'=>'{{WRAPPER}} .ampa-description'));
        $this->end_controls_section();

        $this->start_controls_section('style_buttons',array('label'=>'7. Buttons','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('button_align',array('label'=>'Button Alignment','type'=>\Elementor\Controls_Manager::SELECT,'options'=>array(''=>'Default','flex-start'=>'Left','center'=>'Center','flex-end'=>'Right'),'selectors'=>array('{{WRAPPER}} .ampa-actions'=>'justify-content: {{VALUE}};')));
        $this->add_responsive_control('button_gap',array('label'=>'Button Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>50)),'selectors'=>array('{{WRAPPER}} .ampa-actions'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('button_padding',array('label'=>'Button Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-btn'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'button_typography','selector'=>'{{WRAPPER}} .ampa-btn'));
        $this->add_control('primary_bg',array('label'=>'Primary Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-primary'=>'background: {{VALUE}}; border-color: {{VALUE}};')));
        $this->add_control('primary_color',array('label'=>'Primary Text','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-primary'=>'color: {{VALUE}};')));
        $this->add_control('secondary_bg',array('label'=>'Secondary Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-secondary'=>'background: {{VALUE}};')));
        $this->add_control('secondary_color',array('label'=>'Secondary Text','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-btn-secondary'=>'color: {{VALUE}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_stats',array('label'=>'8. Stats Panel / Stat Boxes','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('stats_panel_bg',array('label'=>'Stats Panel Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-hero-panel'=>'background: {{VALUE}};')));
        $this->add_control('stats_box_bg',array('label'=>'Stat Box Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-hero-stat'=>'background: {{VALUE}};')));
        $this->add_control('stats_box_border',array('label'=>'Stat Box Border','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-hero-stat'=>'border-color: {{VALUE}};')));
        $this->add_control('stat_value_color',array('label'=>'Stat Value Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-hero-stat strong'=>'color: {{VALUE}};')));
        $this->add_control('stat_label_color',array('label'=>'Stat Label Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-hero-stat span'=>'color: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'stat_value_typography','selector'=>'{{WRAPPER}} .ampa-hero-stat strong'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'stat_label_typography','selector'=>'{{WRAPPER}} .ampa-hero-stat span'));
        $this->end_controls_section();

        $this->start_controls_section('style_motion',array('label'=>'9. Smooth Animation / Transform','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('motion_mode',array('label'=>'Motion','type'=>\Elementor\Controls_Manager::SELECT,'default'=>'','options'=>array(''=>'Default','on'=>'On','off'=>'Off'),'prefix_class'=>'ampa-motion-'));
        $this->add_control('hover_lift',array('label'=>'Hover Lift','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>8)),'selectors'=>array('{{WRAPPER}} .ampa-section'=>'--ampa-hover-lift: {{SIZE}}px;')));
        $this->add_control('motion_y',array('label'=>'Entry Movement','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>18)),'selectors'=>array('{{WRAPPER}} .ampa-section'=>'--ampa-motion-y: {{SIZE}}px;')));
        $this->end_controls_section();
    }
    protected function render(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); echo $r->render_hero($this->get_settings_for_display()); }
}
