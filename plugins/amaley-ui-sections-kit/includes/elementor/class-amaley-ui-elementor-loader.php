<?php
/**
 * Elementor integration loader.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Loads Elementor widgets only after Elementor is ready.
 */
final class Amaley_UI_Elementor_Loader {

	/**
	 * Registers Elementor hooks.
	 *
	 * @return void
	 */
	public function hooks() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	/**
	 * Registers Amaley UI widget category.
	 *
	 * @param object $elements_manager Elementor elements manager.
	 * @return void
	 */
	public function register_category( $elements_manager ) {
		if ( ! is_object( $elements_manager ) || ! method_exists( $elements_manager, 'add_category' ) ) {
			return;
		}

		$elements_manager->add_category(
			'amaley-ui',
			array(
				'title' => esc_html__( 'Amaley UI', 'amaley-ui-sections-kit' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Registers Elementor widgets safely.
	 *
	 * @param object $widgets_manager Elementor widgets manager.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		if ( ! class_exists( '\\Elementor\\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
			return;
		}

		$widget_file = AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-page-trust-strip-widget.php';

		if ( file_exists( $widget_file ) ) {
			require_once $widget_file;
		}

		if ( class_exists( 'Amaley_Elementor_Page_Trust_Strip_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Page_Trust_Strip_Widget() );
		}
	}
}
