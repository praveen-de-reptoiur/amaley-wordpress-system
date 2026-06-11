<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

abstract class Amaley_Blog_Elementor_Base extends \Elementor\Widget_Base {
    public function get_categories() {
        return array( 'amaley-blog' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    protected function switch_default( $value = 'yes' ) {
        return array(
            'label_on'  => __( 'Show', 'amaley-blog-system' ),
            'label_off' => __( 'Hide', 'amaley-blog-system' ),
            'return_value' => 'yes',
            'default'   => $value,
        );
    }

    protected function select_categories_options() {
        $terms = get_terms(
            array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
            )
        );
        $options = array();
        if ( ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $options[ $term->term_id ] = $term->name;
            }
        }
        return $options;
    }

    protected function card_controls() {
        $this->add_control(
            'card_template',
            array(
                'label'   => __( 'Card Template', 'amaley-blog-system' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'blog_card_1',
                'options' => array(
                    'blog_card_1' => __( 'Blog Card 1 — OG Card', 'amaley-blog-system' ),
                ),
            )
        );
        $this->add_control( 'show_image', array_merge( array( 'label' => __( 'Show Image', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'fallback_image', array( 'label' => __( 'Fallback Image', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::MEDIA, 'description' => __( 'Used when a post has no featured image. If empty, Amaley default placeholder is used.', 'amaley-blog-system' ) ) );
        $this->add_control( 'show_category', array_merge( array( 'label' => __( 'Show Category', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_date', array_merge( array( 'label' => __( 'Show Date', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_author', array_merge( array( 'label' => __( 'Show Author', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default( '' ) ) );
        $this->add_control( 'show_reading_time', array_merge( array( 'label' => __( 'Show Reading Time', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_excerpt', array_merge( array( 'label' => __( 'Show Excerpt', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control( 'show_button', array_merge( array( 'label' => __( 'Show Button', 'amaley-blog-system' ), 'type' => \Elementor\Controls_Manager::SWITCHER ), $this->switch_default() ) );
        $this->add_control(
            'excerpt_length',
            array(
                'label'   => __( 'Excerpt Length', 'amaley-blog-system' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 22,
                'min'     => 5,
                'max'     => 80,
            )
        );
        $this->add_control(
            'button_text',
            array(
                'label'   => __( 'Button Text', 'amaley-blog-system' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Read More', 'amaley-blog-system' ),
            )
        );
    }

    protected function card_args( $settings ) {
        return array(
            'template'          => isset( $settings['card_template'] ) ? $settings['card_template'] : 'blog_card_1',
            'show_image'        => ! empty( $settings['show_image'] ) && 'yes' === $settings['show_image'],
            'show_category'     => ! empty( $settings['show_category'] ) && 'yes' === $settings['show_category'],
            'show_date'         => ! empty( $settings['show_date'] ) && 'yes' === $settings['show_date'],
            'show_author'       => ! empty( $settings['show_author'] ) && 'yes' === $settings['show_author'],
            'show_reading_time' => ! empty( $settings['show_reading_time'] ) && 'yes' === $settings['show_reading_time'],
            'show_excerpt'      => ! empty( $settings['show_excerpt'] ) && 'yes' === $settings['show_excerpt'],
            'show_button'       => ! empty( $settings['show_button'] ) && 'yes' === $settings['show_button'],
            'excerpt_length'    => isset( $settings['excerpt_length'] ) ? absint( $settings['excerpt_length'] ) : 22,
            'button_text'       => isset( $settings['button_text'] ) ? $settings['button_text'] : __( 'Read More', 'amaley-blog-system' ),
            'fallback_image'    => ! empty( $settings['fallback_image']['url'] ) ? esc_url( $settings['fallback_image']['url'] ) : '',
            'auto_fallback'      => true,
        );
    }
}
