<?php
/** Vision visual statement widget. */
defined( 'ABSPATH' ) || exit;

final class ACWSC109_Vision_Visual_Statement_Widget extends ACWSC109_Reference_Visual_Statement_Base_Widget {
    public function get_name() { return 'acwsc_vision_visual_statement'; }
    public function get_title() { return esc_html__( 'Amaley Vision Visual Statement', 'amaley-compact-widgets' ); }
    protected function section_type() { return 'vision'; }
    protected function section_title() { return 'Vision'; }
    protected function defaults() {
        return array(
            'badge_text' => 'AMALEY VISION',
            'kicker' => 'Where We Are Going',
            'title' => 'A Himalayan Brand Where Every Product Has a Named Journey',
            'accent_word' => 'Journey',
            'description' => 'Our vision is to make Amaley a trusted Himalayan brand where customers can discover products through origin, maker, cluster and purpose — not anonymous shelves.',
            'primary_button_text' => 'See the Journey',
            'secondary_button_text' => 'View Products',
            'main_image_alt' => 'Amaley vision visual',
            'floating_image_alt' => 'Named journey and product story detail',
            'visual_caption' => 'Named journeys · trusted quality · community growth',
            'visual_position' => 'right',
        );
    }
    protected function default_points() {
        return array(
            array( 'icon' => '01', 'title' => 'Traceable Discovery', 'text' => 'Customers should be able to connect product, place, cluster, SHG and maker.' ),
            array( 'icon' => '02', 'title' => 'Trusted Himalayan Quality', 'text' => 'The brand should stand for careful sourcing, clear standards and respectful production.' ),
            array( 'icon' => '03', 'title' => 'Community-led Growth', 'text' => 'Growth should strengthen local producers, village value chains and responsible market access.' ),
        );
    }
}
