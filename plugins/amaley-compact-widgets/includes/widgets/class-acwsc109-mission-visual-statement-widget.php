<?php
/** Mission visual statement widget. */
defined( 'ABSPATH' ) || exit;

final class ACWSC109_Mission_Visual_Statement_Widget extends ACWSC109_Reference_Visual_Statement_Base_Widget {
    public function get_name() { return 'acwsc_mission_visual_statement'; }
    public function get_title() { return esc_html__( 'Amaley Mission Visual Statement', 'amaley-compact-widgets' ); }
    protected function section_type() { return 'mission'; }
    protected function section_title() { return 'Mission'; }
    protected function defaults() {
        return array(
            'badge_text' => 'AMALEY MISSION',
            'kicker' => 'Why We Exist',
            'title' => 'To Build Food With Identity, Care and Fair Value',
            'accent_word' => 'Identity',
            'description' => 'Our mission is to connect Himalayan ingredients, community-rooted producer groups and conscious buyers through products that carry place, people and dignity.',
            'primary_button_text' => 'Explore Our Work',
            'secondary_button_text' => 'Meet the Producers',
            'main_image_alt' => 'Amaley mission visual',
            'floating_image_alt' => 'Community production detail',
            'visual_caption' => 'Small batches · visible origin · fair value',
            'visual_position' => 'left',
        );
    }
    protected function default_points() {
        return array(
            array( 'icon' => '01', 'title' => 'Visible Origin', 'text' => 'Every product should clearly show where it comes from and who adds value.' ),
            array( 'icon' => '02', 'title' => 'Fair Enterprise', 'text' => 'Producer groups, SHGs and local makers should earn through real markets, not token stories.' ),
            array( 'icon' => '03', 'title' => 'Small-batch Care', 'text' => 'We respect local rhythm, seasonality and product quality instead of forcing mass production.' ),
        );
    }
}
