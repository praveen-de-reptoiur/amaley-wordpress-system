<?php
/** Amaley Member Archive Trust Strip Elementor widget — v1.0.76 controls-only upgrade. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }

class Amaley_Core_Member_Archive_Trust_Strip_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_core_member_archive_trust_strip'; }
    public function get_title(){ return esc_html__( 'Amaley Member Archive Trust Strip', 'amaley-core' ); }
    public function get_icon(){ return 'eicon-info-box'; }
    public function get_categories(){ return array( 'amaley-core' ); }
    public function get_style_depends(){ return array( 'amaley-core-member-archive-sections' ); }
    private function defaults(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); return $r->trust_defaults(); }
    protected function register_controls(){
        $d=$this->defaults();
        $this->start_controls_section('content_display',array('label'=>'1. Content + Show / Hide'));
        foreach(array('show_section'=>'Show Section','show_icon'=>'Show Icon Dot','show_item_title'=>'Show Item Title','show_item_text'=>'Show Item Description') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::SWITCHER,'return_value'=>'1','default'=>$d[$k] ?? '1')); }
        $this->add_control('items',array('label'=>'Trust Items','description'=>'One item per line: Title|Description','type'=>\Elementor\Controls_Manager::TEXTAREA,'rows'=>7,'default'=>$d['items']));
        $this->end_controls_section();
        $this->start_controls_section('layout_content',array('label'=>'2. Layout / Responsive'));
        foreach(array('columns_desktop'=>'Columns Desktop','columns_tablet'=>'Columns Tablet','columns_mobile'=>'Columns Mobile') as $k=>$l){ $this->add_control($k,array('label'=>$l,'type'=>\Elementor\Controls_Manager::NUMBER,'min'=>1,'max'=>4,'default'=>$d[$k])); }
        $this->end_controls_section();
        $this->start_controls_section('style_section',array('label'=>'3. Section / Grid','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('section_padding',array('label'=>'Section Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em','%'),'selectors'=>array('{{WRAPPER}} .ampa-trust'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_control('section_bg',array('label'=>'Section Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-trust'=>'background: {{VALUE}};')));
        $this->add_responsive_control('grid_gap',array('label'=>'Card Gap','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>70)),'selectors'=>array('{{WRAPPER}} .ampa-trust-grid'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->end_controls_section();
        $this->start_controls_section('style_card',array('label'=>'4. Card / Icon / Text','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('card_bg',array('label'=>'Card Background','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-trust-card'=>'background: {{VALUE}};')));
        $this->add_control('card_border',array('label'=>'Card Border Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-trust-card'=>'border-color: {{VALUE}};')));
        $this->add_responsive_control('card_padding',array('label'=>'Card Padding','type'=>\Elementor\Controls_Manager::DIMENSIONS,'size_units'=>array('px','em'),'selectors'=>array('{{WRAPPER}} .ampa-trust-card'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('card_radius',array('label'=>'Card Radius','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>40)),'selectors'=>array('{{WRAPPER}} .ampa-trust-card'=>'border-radius: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('card_align',array('label'=>'Card Alignment','type'=>\Elementor\Controls_Manager::CHOOSE,'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'),'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'),'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')),'selectors'=>array('{{WRAPPER}} .ampa-trust-card'=>'text-align: {{VALUE}};')));
        $this->add_control('icon_color',array('label'=>'Icon Dot Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-trust-card span'=>'background: {{VALUE}};')));
        $this->add_responsive_control('icon_size',array('label'=>'Icon Dot Size','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>4,'max'=>34)),'selectors'=>array('{{WRAPPER}} .ampa-trust-card span'=>'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'title_typography','selector'=>'{{WRAPPER}} .ampa-trust-card strong'));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(),array('name'=>'text_typography','selector'=>'{{WRAPPER}} .ampa-trust-card p'));
        $this->add_control('title_color',array('label'=>'Title Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-trust-card strong'=>'color: {{VALUE}};')));
        $this->add_control('text_color',array('label'=>'Text Color','type'=>\Elementor\Controls_Manager::COLOR,'selectors'=>array('{{WRAPPER}} .ampa-trust-card p'=>'color: {{VALUE}};')));
        $this->end_controls_section();
        $this->start_controls_section('style_motion',array('label'=>'5. Smooth Animation / Transform','tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('motion_mode',array('label'=>'Motion','type'=>\Elementor\Controls_Manager::SELECT,'default'=>'','options'=>array(''=>'Default','on'=>'On','off'=>'Off'),'prefix_class'=>'ampa-motion-'));
        $this->add_control('hover_lift',array('label'=>'Hover Lift','type'=>\Elementor\Controls_Manager::SLIDER,'size_units'=>array('px'),'range'=>array('px'=>array('min'=>0,'max'=>8)),'selectors'=>array('{{WRAPPER}} .ampa-section'=>'--ampa-hover-lift: {{SIZE}}px;')));
        $this->end_controls_section();
    }
    protected function render(){ $r=isset($GLOBALS['amaley_core_member_archive_sections'])?$GLOBALS['amaley_core_member_archive_sections']:new Amaley_Core_Member_Archive_Sections(); echo $r->render_trust_strip($this->get_settings_for_display()); }
}
