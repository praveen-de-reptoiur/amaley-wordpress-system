<?php
if (!defined('ABSPATH')) { exit; }

class Amaley_DE_Elementor_Contact_Form_CTA_Widget extends \Elementor\Widget_Base {
    public function get_name(){ return 'amaley_de_contact_form_cta'; }
    public function get_title(){ return __('Amaley Contact Form CTA', 'amaley-discovery-engine'); }
    public function get_icon(){ return 'eicon-form-horizontal'; }
    public function get_categories(){ return array('amaley-discovery-engine'); }
    public function get_keywords(){ return array('amaley','contact','form','cta','cf7','wpforms','enquiry'); }
    public function get_style_depends(){ if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }
    public function get_script_depends(){ if (function_exists('amaley_de_bootstrap')) { amaley_de_bootstrap()->register_assets(); } return array('amaley-de-frontend'); }

    protected function register_controls(){ $this->register_content_controls(); $this->register_style_controls(); $this->register_advanced_visibility_controls(); }
    private function switcher($label,$default='yes',$condition=array()){ $args=array('label'=>$label,'type'=>\Elementor\Controls_Manager::SWITCHER,'label_on'=>__('Show','amaley-discovery-engine'),'label_off'=>__('Hide','amaley-discovery-engine'),'return_value'=>'yes','default'=>$default); if($condition){$args['condition']=$condition;} return $args; }
    private function css_color($prop){ return $prop . ': {{VALUE}};'; }

    private function register_content_controls(){
        $this->start_controls_section('content_text', array('label'=>__('CTA Content','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('layout_preset', array('label'=>__('Layout Preset','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SELECT, 'default'=>'split', 'options'=>array('split'=>__('Text + Form Split','amaley-discovery-engine'), 'form-left'=>__('Form + Text Split','amaley-discovery-engine'), 'stacked'=>__('Stacked','amaley-discovery-engine'), 'centered'=>__('Centered','amaley-discovery-engine')), 'prefix_class'=>'amaley-de-contact-form-layout-'));
        $this->add_control('show_text_panel', $this->switcher(__('Text Panel','amaley-discovery-engine'), 'yes'));
        $this->add_control('show_kicker', $this->switcher(__('Kicker','amaley-discovery-engine'), 'yes', array('show_text_panel'=>'yes')));
        $this->add_control('kicker', array('label'=>__('Kicker Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Enquiry','amaley-discovery-engine'), 'condition'=>array('show_text_panel'=>'yes','show_kicker'=>'yes')));
        $this->add_control('show_heading', $this->switcher(__('Heading','amaley-discovery-engine'), 'yes', array('show_text_panel'=>'yes')));
        $this->add_control('heading', array('label'=>__('Heading','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('Tell us what you are looking for.','amaley-discovery-engine'), 'condition'=>array('show_text_panel'=>'yes','show_heading'=>'yes')));
        $this->add_control('show_description', $this->switcher(__('Description','amaley-discovery-engine'), 'yes', array('show_text_panel'=>'yes')));
        $this->add_control('description', array('label'=>__('Description','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('For bulk orders, gifting, store counters, sourcing stories, collaborations, or product support — share your details and our team will respond.','amaley-discovery-engine'), 'condition'=>array('show_text_panel'=>'yes','show_description'=>'yes')));
        $this->add_control('show_note', $this->switcher(__('Small Note','amaley-discovery-engine'), 'yes', array('show_text_panel'=>'yes')));
        $this->add_control('note', array('label'=>__('Note Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('Response timelines may vary for field locations and community sourcing work.','amaley-discovery-engine'), 'condition'=>array('show_text_panel'=>'yes','show_note'=>'yes')));
        $this->end_controls_section();

        $this->start_controls_section('content_form', array('label'=>__('Form Source','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_form_panel', $this->switcher(__('Form Panel','amaley-discovery-engine'), 'yes'));
        $this->add_control('form_source', array('label'=>__('Form Source','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SELECT, 'default'=>'dummy', 'options'=>array('dummy'=>__('Built-in Demo Form / Mailto','amaley-discovery-engine'), 'shortcode'=>__('Shortcode: Contact Form 7 / WPForms / Fluent Forms','amaley-discovery-engine'), 'html'=>__('Custom HTML Embed','amaley-discovery-engine')), 'condition'=>array('show_form_panel'=>'yes')));
        $this->add_control('recipient_email', array('label'=>__('Recipient Email for Built-in Form','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'hello@amaley.in', 'condition'=>array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->add_control('form_shortcode', array('label'=>__('Form Shortcode','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'rows'=>3, 'placeholder'=>'[contact-form-7 id="123" title="Contact"]', 'condition'=>array('show_form_panel'=>'yes','form_source'=>'shortcode')));
        $this->add_control('form_html', array('label'=>__('Custom HTML','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'rows'=>8, 'placeholder'=>'Paste safe embed HTML here', 'condition'=>array('show_form_panel'=>'yes','form_source'=>'html')));
        $this->add_control('show_form_heading', $this->switcher(__('Form Heading','amaley-discovery-engine'), 'yes', array('show_form_panel'=>'yes')));
        $this->add_control('form_heading', array('label'=>__('Form Heading Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Send an enquiry','amaley-discovery-engine'), 'condition'=>array('show_form_panel'=>'yes','show_form_heading'=>'yes')));
        $this->add_control('show_name_field', $this->switcher(__('Name Field','amaley-discovery-engine'), 'yes', array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->add_control('show_email_field', $this->switcher(__('Email Field','amaley-discovery-engine'), 'yes', array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->add_control('show_phone_field', $this->switcher(__('Phone Field','amaley-discovery-engine'), 'yes', array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->add_control('show_subject_field', $this->switcher(__('Subject Field','amaley-discovery-engine'), 'yes', array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->add_control('show_message_field', $this->switcher(__('Message Field','amaley-discovery-engine'), 'yes', array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->add_control('submit_text', array('label'=>__('Submit Button Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Send Enquiry','amaley-discovery-engine'), 'condition'=>array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->add_control('success_message', array('label'=>__('After Submit Message','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>__('Your email app should open with the enquiry details. Please send it from there.','amaley-discovery-engine'), 'condition'=>array('show_form_panel'=>'yes','form_source'=>'dummy')));
        $this->end_controls_section();

        $this->start_controls_section('content_trust', array('label'=>__('Trust Points','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_CONTENT));
        $this->add_control('show_trust_points', $this->switcher(__('Trust Points','amaley-discovery-engine'), 'yes'));
        $rep = new \Elementor\Repeater();
        $rep->add_control('text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>__('Bulk & gifting support','amaley-discovery-engine'), 'label_block'=>true));
        $this->add_control('trust_points', array('label'=>__('Items','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::REPEATER, 'fields'=>$rep->get_controls(), 'default'=>array(array('text'=>__('Bulk & gifting support','amaley-discovery-engine')), array('text'=>__('Community-sourced products','amaley-discovery-engine')), array('text'=>__('Shop and collaboration enquiries','amaley-discovery-engine'))), 'title_field'=>'{{{ text }}}', 'condition'=>array('show_trust_points'=>'yes')));
        $this->end_controls_section();
    }

    private function register_style_controls(){
        $root='{{WRAPPER}} .amaley-de-contact-form-cta'; $inner=$root.' .amaley-de-contact-form-cta__inner'; $text=$root.' .amaley-de-contact-form-cta__text'; $form=$root.' .amaley-de-contact-form-cta__form-panel'; $fields=$root.' .amaley-de-contact-form-cta__field input, '.$root.' .amaley-de-contact-form-cta__field textarea'; $button=$root.' .amaley-de-contact-form-cta__submit';
        $this->start_controls_section('style_layout', array('label'=>__('Section / Layout','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->start_controls_tabs('layout_tabs');
        $this->start_controls_tab('section_tab', array('label'=>__('Section','amaley-discovery-engine')));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array('name'=>'section_background','selector'=>$root));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'section_border','selector'=>$root));
        $this->add_responsive_control('section_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('section_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($root=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->end_controls_tab();
        $this->start_controls_tab('layout_tab', array('label'=>__('Layout','amaley-discovery-engine')));
        $this->add_responsive_control('inner_max_width', array('label'=>__('Inner Max Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array('px','%'), 'range'=>array('px'=>array('min'=>320,'max'=>1700),'%'=>array('min'=>20,'max'=>100)), 'selectors'=>array($inner=>'max-width: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('columns', array('label'=>__('Columns','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SELECT, 'default'=>'2', 'tablet_default'=>'1', 'mobile_default'=>'1', 'options'=>array('1'=>'1','2'=>'2'), 'selectors'=>array($inner=>'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));')));
        $this->add_responsive_control('gap', array('label'=>__('Column / Row Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>100)), 'selectors'=>array($inner=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('vertical_align', array('label'=>__('Vertical Align','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('start'=>array('title'=>'Top','icon'=>'eicon-v-align-top'), 'center'=>array('title'=>'Middle','icon'=>'eicon-v-align-middle'), 'end'=>array('title'=>'Bottom','icon'=>'eicon-v-align-bottom')), 'selectors'=>array($inner=>'align-items: {{VALUE}};')));
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section('style_text', array('label'=>__('Text Elements','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('text_align', array('label'=>__('Text Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right')), 'selectors'=>array($text=>'text-align: {{VALUE}};')));
        $this->add_responsive_control('text_element_align', array('label'=>__('Text Element Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'), 'stretch'=>array('title'=>__('Stretch','amaley-discovery-engine'),'icon'=>'eicon-h-align-stretch')), 'selectors'=>array($text=>'align-items: {{VALUE}};')));
        $this->add_responsive_control('trust_align', array('label'=>__('Trust Points Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('flex-start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'flex-end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right')), 'selectors'=>array($root.' .amaley-de-contact-form-cta__trust'=>'justify-content: {{VALUE}};')));
        foreach(array('kicker'=>__('Kicker','amaley-discovery-engine'), 'heading'=>__('Heading','amaley-discovery-engine'), 'description'=>__('Description','amaley-discovery-engine'), 'note'=>__('Note','amaley-discovery-engine')) as $key=>$label){
            $this->add_control($key.'_heading', array('label'=>$label, 'type'=>\Elementor\Controls_Manager::HEADING, 'separator'=>'before'));
            $this->add_control($key.'_color', array('label'=>__('Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-form-cta__'.$key=>$this->css_color('color'))));
            $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>$key.'_typography', 'selector'=>$root.' .amaley-de-contact-form-cta__'.$key));
            $this->add_responsive_control($key.'_margin', array('label'=>__('Margin','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'selectors'=>array($root.' .amaley-de-contact-form-cta__'.$key=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        }
        $this->end_controls_section();

        $this->start_controls_section('style_form_box', array('label'=>__('Form Box','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_group_control(\Elementor\Group_Control_Background::get_type(), array('name'=>'form_background','selector'=>$form));
        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), array('name'=>'form_border','selector'=>$form));
        $this->add_responsive_control('form_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($form=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('form_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array($form=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('form_inner_gap', array('label'=>__('Panel Inner Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>70)), 'selectors'=>array($form=>'display:flex; flex-direction:column; gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('form_grid_gap', array('label'=>__('Built-in Form Field Gap','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>0,'max'=>50)), 'selectors'=>array($root.' .amaley-de-contact-form-cta__form'=>'gap: {{SIZE}}{{UNIT}};')));
        $this->add_responsive_control('form_text_align', array('label'=>__('Form Text Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('left'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-text-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-text-align-center'), 'right'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-text-align-right')), 'selectors'=>array($form=>'text-align: {{VALUE}};')));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'form_shadow','selector'=>$form));
        $this->end_controls_section();

        $this->start_controls_section('style_fields', array('label'=>__('Fields','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_control('label_color', array('label'=>__('Label Color','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($root.' .amaley-de-contact-form-cta__field label'=>$this->css_color('color'))));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'label_typography', 'selector'=>$root.' .amaley-de-contact-form-cta__field label'));
        $this->add_control('field_bg', array('label'=>__('Field Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($fields=>$this->css_color('background-color'))));
        $this->add_control('field_text', array('label'=>__('Field Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($fields=>$this->css_color('color'))));
        $this->add_control('field_border_color', array('label'=>__('Field Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($fields=>$this->css_color('border-color'))));
        $this->add_responsive_control('field_radius', array('label'=>__('Field Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($fields=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('field_padding', array('label'=>__('Field Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($fields=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('textarea_height', array('label'=>__('Textarea Height','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>80,'max'=>320)), 'selectors'=>array($root.' .amaley-de-contact-form-cta__field textarea'=>'min-height: {{SIZE}}{{UNIT}};')));
        $this->end_controls_section();

        $this->start_controls_section('style_button', array('label'=>__('Submit Button','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_STYLE));
        $this->add_responsive_control('button_width', array('label'=>__('Width','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::SELECT, 'default'=>'auto', 'mobile_default'=>'full', 'options'=>array('auto'=>__('Auto','amaley-discovery-engine'), 'full'=>__('Full Width','amaley-discovery-engine')), 'selectors_dictionary'=>array('auto'=>'width:auto;', 'full'=>'width:100%;'), 'selectors'=>array($button=>'{{VALUE}}')));
        $this->add_responsive_control('button_align', array('label'=>__('Alignment','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array('start'=>array('title'=>__('Left','amaley-discovery-engine'),'icon'=>'eicon-h-align-left'), 'center'=>array('title'=>__('Center','amaley-discovery-engine'),'icon'=>'eicon-h-align-center'), 'end'=>array('title'=>__('Right','amaley-discovery-engine'),'icon'=>'eicon-h-align-right'), 'stretch'=>array('title'=>__('Stretch','amaley-discovery-engine'),'icon'=>'eicon-h-align-stretch')), 'selectors_dictionary'=>array('start'=>'justify-self:start;', 'center'=>'justify-self:center;', 'end'=>'justify-self:end;', 'stretch'=>'justify-self:stretch; width:100%;'), 'selectors'=>array($button=>'{{VALUE}}')));
        $this->start_controls_tabs('button_tabs');
        $this->start_controls_tab('button_normal', array('label'=>__('Normal','amaley-discovery-engine')));
        $this->add_control('button_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('background-color'))));
        $this->add_control('button_text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('color'))));
        $this->add_control('button_border', array('label'=>__('Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button=>$this->css_color('border-color'))));
        $this->end_controls_tab();
        $this->start_controls_tab('button_hover', array('label'=>__('Hover','amaley-discovery-engine')));
        $this->add_control('button_hover_bg', array('label'=>__('Background','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('background-color'))));
        $this->add_control('button_hover_text', array('label'=>__('Text','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('color'))));
        $this->add_control('button_hover_border', array('label'=>__('Border','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array($button.':hover'=>$this->css_color('border-color'))));
        $this->end_controls_tab(); $this->end_controls_tabs();
        $this->add_responsive_control('button_padding', array('label'=>__('Padding','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'selectors'=>array($button=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_responsive_control('button_radius', array('label'=>__('Radius','amaley-discovery-engine'), 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array($button=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), array('name'=>'button_typography','selector'=>$button));
        $this->add_group_control(\Elementor\Group_Control_Box_Shadow::get_type(), array('name'=>'button_shadow','selector'=>$button));
        $this->end_controls_section();
    }

    private function register_advanced_visibility_controls(){
        $this->start_controls_section('advanced_visibility', array('label'=>__('Visibility / Responsive Layout','amaley-discovery-engine'), 'tab'=>\Elementor\Controls_Manager::TAB_ADVANCED));
        $this->start_controls_tabs('visibility_tabs');
        foreach(array('desktop'=>__('Desktop','amaley-discovery-engine'), 'tablet'=>__('Tablet','amaley-discovery-engine'), 'mobile'=>__('Mobile','amaley-discovery-engine')) as $d=>$label){
            $this->start_controls_tab('vis_'.$d, array('label'=>$label));
            foreach(array('whole'=>'Whole Section','text_panel'=>'Text Panel','kicker'=>'Kicker','heading'=>'Heading','description'=>'Description','note'=>'Note','trust'=>'Trust Points','form_panel'=>'Form Panel','name'=>'Name Field','email'=>'Email Field','phone'=>'Phone Field','subject'=>'Subject Field','message'=>'Message Field') as $key=>$label2){
                $this->add_control('hide_'.$key.'_'.$d, array('label'=>sprintf(__('Hide %s','amaley-discovery-engine'), __($label2,'amaley-discovery-engine')), 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'no'));
            }
            $this->end_controls_tab();
        }
        $this->end_controls_tabs(); $this->end_controls_section();
    }

    private function is_show($s,$key){ return isset($s[$key]) && 'yes' === $s[$key]; }
    private function hide_classes($s,$key){ $c=array(); foreach(array('desktop','tablet','mobile') as $d){ if(!empty($s['hide_'.$key.'_'.$d]) && 'yes'===$s['hide_'.$key.'_'.$d]) $c[]='amaley-de-hide-'.$d; } return implode(' ', $c); }
    private function field($name,$label,$type='text',$placeholder='',$hide_key=''){
        $hide = $hide_key ? ' ' . esc_attr($hide_key) : '';
        if ('textarea' === $type) {
            return '<div class="amaley-de-contact-form-cta__field'.$hide.'"><label for="'.$name.'">'.esc_html($label).'</label><textarea id="'.$name.'" name="'.$name.'" placeholder="'.esc_attr($placeholder).'" required></textarea></div>';
        }
        return '<div class="amaley-de-contact-form-cta__field'.$hide.'"><label for="'.$name.'">'.esc_html($label).'</label><input id="'.$name.'" name="'.$name.'" type="'.esc_attr($type).'" placeholder="'.esc_attr($placeholder).'" required></div>';
    }
    protected function render(){
        if(function_exists('amaley_de_bootstrap')){ amaley_de_bootstrap()->enqueue_frontend_assets(); }
        $s=$this->get_settings_for_display();
        ?>
        <section class="amaley-de-contact-form-cta <?php echo esc_attr($this->hide_classes($s,'whole')); ?>">
            <div class="amaley-de-contact-form-cta__inner">
                <?php if($this->is_show($s,'show_text_panel')): ?>
                    <div class="amaley-de-contact-form-cta__text <?php echo esc_attr($this->hide_classes($s,'text_panel')); ?>">
                        <?php if($this->is_show($s,'show_kicker') && !empty($s['kicker'])): ?><div class="amaley-de-contact-form-cta__kicker <?php echo esc_attr($this->hide_classes($s,'kicker')); ?>"><?php echo esc_html($s['kicker']); ?></div><?php endif; ?>
                        <?php if($this->is_show($s,'show_heading') && !empty($s['heading'])): ?><h2 class="amaley-de-contact-form-cta__heading <?php echo esc_attr($this->hide_classes($s,'heading')); ?>"><?php echo nl2br(esc_html($s['heading'])); ?></h2><?php endif; ?>
                        <?php if($this->is_show($s,'show_description') && !empty($s['description'])): ?><p class="amaley-de-contact-form-cta__description <?php echo esc_attr($this->hide_classes($s,'description')); ?>"><?php echo esc_html($s['description']); ?></p><?php endif; ?>
                        <?php if($this->is_show($s,'show_trust_points') && !empty($s['trust_points'])): ?><ul class="amaley-de-contact-form-cta__trust <?php echo esc_attr($this->hide_classes($s,'trust')); ?>"><?php foreach($s['trust_points'] as $item): if(!empty($item['text'])): ?><li><?php echo esc_html($item['text']); ?></li><?php endif; endforeach; ?></ul><?php endif; ?>
                        <?php if($this->is_show($s,'show_note') && !empty($s['note'])): ?><p class="amaley-de-contact-form-cta__note <?php echo esc_attr($this->hide_classes($s,'note')); ?>"><?php echo esc_html($s['note']); ?></p><?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if($this->is_show($s,'show_form_panel')): ?>
                    <div class="amaley-de-contact-form-cta__form-panel <?php echo esc_attr($this->hide_classes($s,'form_panel')); ?>">
                        <?php if($this->is_show($s,'show_form_heading') && !empty($s['form_heading'])): ?><h3 class="amaley-de-contact-form-cta__form-heading"><?php echo esc_html($s['form_heading']); ?></h3><?php endif; ?>
                        <?php if('shortcode' === $s['form_source'] && !empty($s['form_shortcode'])): ?>
                            <div class="amaley-de-contact-form-cta__shortcode"><?php echo do_shortcode($s['form_shortcode']); ?></div>
                        <?php elseif('html' === $s['form_source'] && !empty($s['form_html'])): ?>
                            <div class="amaley-de-contact-form-cta__html"><?php echo do_shortcode(wp_kses_post($s['form_html'])); ?></div>
                        <?php else: ?>
                            <form class="amaley-de-contact-form-cta__form amaley-de-contact-form-cta__form--mailto" data-recipient="<?php echo esc_attr(!empty($s['recipient_email']) ? sanitize_email($s['recipient_email']) : 'hello@amaley.in'); ?>" data-success="<?php echo esc_attr(!empty($s['success_message']) ? $s['success_message'] : ''); ?>">
                                <?php if($this->is_show($s,'show_name_field')) echo $this->field('amaley_contact_name', __('Name','amaley-discovery-engine'), 'text', __('Your name','amaley-discovery-engine'), $this->hide_classes($s,'name')); ?>
                                <?php if($this->is_show($s,'show_email_field')) echo $this->field('amaley_contact_email', __('Email','amaley-discovery-engine'), 'email', __('you@example.com','amaley-discovery-engine'), $this->hide_classes($s,'email')); ?>
                                <?php if($this->is_show($s,'show_phone_field')) echo $this->field('amaley_contact_phone', __('Phone / WhatsApp','amaley-discovery-engine'), 'tel', __('+91','amaley-discovery-engine'), $this->hide_classes($s,'phone')); ?>
                                <?php if($this->is_show($s,'show_subject_field')) echo $this->field('amaley_contact_subject', __('Subject','amaley-discovery-engine'), 'text', __('Bulk order / product enquiry','amaley-discovery-engine'), $this->hide_classes($s,'subject')); ?>
                                <?php if($this->is_show($s,'show_message_field')) echo $this->field('amaley_contact_message', __('Message','amaley-discovery-engine'), 'textarea', __('Tell us what you need','amaley-discovery-engine'), $this->hide_classes($s,'message')); ?>
                                <button class="amaley-de-contact-form-cta__submit" type="submit"><?php echo esc_html(!empty($s['submit_text']) ? $s['submit_text'] : __('Send Enquiry','amaley-discovery-engine')); ?></button>
                                <div class="amaley-de-contact-form-cta__status" aria-live="polite"></div>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
