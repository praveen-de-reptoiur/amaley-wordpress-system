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

	/** Registers Elementor hooks. */
	public function hooks() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	/**
	 * Registers Amaley widget category.
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
		if ( ! class_exists( '\Elementor\Widget_Base' ) || ! is_object( $widgets_manager ) ) {
			return;
		}

		$widget_files = array(
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-page-trust-strip-widget.php',
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-home-hero-v6-widget.php',
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-pages-hero-other-widget.php',
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-collection-purpose-routes-widget.php',
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-featured-collection-cards-widget.php',
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-collection-detail-split-widget.php',
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-bulk-orders-band-widget.php',
			AMALEY_UI_SECTIONS_KIT_PATH . 'includes/elementor/widgets/class-amaley-elementor-gifting-enquiry-section-widget.php',
		);

		foreach ( $widget_files as $widget_file ) {
			if ( file_exists( $widget_file ) ) {
				require_once $widget_file;
			}
		}

		if ( class_exists( 'Amaley_Elementor_Page_Trust_Strip_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Page_Trust_Strip_Widget() );
		}

		if ( class_exists( 'Amaley_Elementor_Home_Hero_V6_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Home_Hero_V6_Widget() );
		}

		if ( class_exists( 'Amaley_Elementor_Pages_Hero_Other_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Pages_Hero_Other_Widget() );
		}

		if ( class_exists( 'Amaley_Elementor_Collection_Purpose_Routes_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Collection_Purpose_Routes_Widget() );
		}

		if ( class_exists( 'Amaley_Elementor_Featured_Collection_Cards_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Featured_Collection_Cards_Widget() );
		}

		if ( class_exists( 'Amaley_Elementor_Collection_Detail_Split_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Collection_Detail_Split_Widget() );
		}

		if ( class_exists( 'Amaley_Elementor_Bulk_Orders_Band_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Bulk_Orders_Band_Widget() );
		}

		if ( class_exists( 'Amaley_Elementor_Gifting_Enquiry_Section_Widget' ) && method_exists( $widgets_manager, 'register' ) ) {
			$widgets_manager->register( new Amaley_Elementor_Gifting_Enquiry_Section_Widget() );
		}
	}
}
