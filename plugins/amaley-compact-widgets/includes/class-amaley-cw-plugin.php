<?php
/**
 * Main plugin bootstrap.
 *
 * @package Amaley_Compact_Widgets
 */

defined( 'ABSPATH' ) || exit;

final class Amaley_CW_Plugin {
	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'register_assets' ) );
		add_action( 'init', array( $this, 'register_shortcodes' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_for_shortcodes' ), 20 );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_assets' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_assets' ) );
	}

	public function register_assets() {
		wp_register_style( 'amaley-compact-widgets', AMALEY_CW_URL . 'assets/css/amaley-compact-widgets.css', array(), AMALEY_CW_VERSION );
		wp_register_style( 'amaley-compact-widgets-origin-map', AMALEY_CW_URL . 'assets/css/amaley-cw-origin-map.css', array( 'amaley-compact-widgets' ), AMALEY_CW_VERSION );
	}

	public function enqueue_assets() {
		wp_enqueue_style( 'amaley-compact-widgets' );
		wp_enqueue_style( 'amaley-compact-widgets-origin-map' );
	}

	public function maybe_enqueue_for_shortcodes() {
		if ( is_admin() || ! is_singular() ) {
			return;
		}
		global $post;
		if ( ! $post || empty( $post->post_content ) ) {
			return;
		}
		foreach ( Amaley_CW_Shortcodes::shortcode_map() as $shortcode => $method ) {
			if ( has_shortcode( $post->post_content, $shortcode ) ) {
				$this->enqueue_assets();
				return;
			}
		}
	}

	public function register_shortcodes() {
		$shortcodes = new Amaley_CW_Shortcodes();
		$shortcodes->register();
	}

	public function register_elementor_category( $elements_manager ) {
		if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
			$elements_manager->add_category( 'amaley-compact', array( 'title' => esc_html__( 'Amaley Compact', 'amaley-compact-widgets' ), 'icon' => 'fa fa-leaf' ) );
		}
	}

	public function register_elementor_widgets( $widgets_manager ) {
		if ( ! class_exists( '\Elementor\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
			return;
		}

		require_once AMALEY_CW_PATH . 'includes/widgets/class-amaley-cw-base-widget.php';

		$widgets = Amaley_CW_Renderer::widget_definitions();
		foreach ( $widgets as $key => $definition ) {
			$class_file = AMALEY_CW_PATH . 'includes/widgets/class-amaley-cw-' . str_replace( '_', '-', $key ) . '-widget.php';
			if ( file_exists( $class_file ) ) {
				require_once $class_file;
			}
			$class = 'Amaley_CW_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $key ) ) ) . '_Widget';
			if ( class_exists( $class ) && method_exists( $widgets_manager, 'register' ) ) {
				$widgets_manager->register( new $class() );
			}
		}

		$origin_map_widget = AMALEY_CW_PATH . 'includes/widgets/class-amaley-cw-origin-map-widget.php';
		if ( file_exists( $origin_map_widget ) ) {
			require_once $origin_map_widget;
		}
		if ( class_exists( 'Amaley_CW_Origin_Map_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_CW_Origin_Map_Widget() );
		}
	}
}
