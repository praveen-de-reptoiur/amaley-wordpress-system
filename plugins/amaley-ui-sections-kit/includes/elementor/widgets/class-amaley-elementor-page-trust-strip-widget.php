<?php
/**
 * Elementor Page Trust Strip widget.
 *
 * @package Amaley_UI_Sections_Kit
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) {
	return;
}

/**
 * Elementor-native Amaley Page Trust Strip widget.
 */
final class Amaley_Elementor_Page_Trust_Strip_Widget extends \Elementor\Widget_Base {

	/** {@inheritDoc} */
	public function get_name() {
		return 'amaley_ui_page_trust_strip';
	}

	/** {@inheritDoc} */
	public function get_title() {
		return esc_html__( 'Amaley Page Trust Strip', 'amaley-ui-sections-kit' );
	}

	/** {@inheritDoc} */
	public function get_icon() {
		return 'eicon-check-circle-o';
	}

	/** {@inheritDoc} */
	public function get_categories() {
		return array( 'amaley-ui', 'general' );
	}

	/** {@inheritDoc} */
	public function get_keywords() {
		return array( 'amaley', 'page trust', 'trust strip', 'promise', 'hero below', 'icons' );
	}

	/** {@inheritDoc} */
	public function get_style_depends() {
		return array( 'amaley-ui-sections-kit' );
	}

	/** {@inheritDoc} */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'amaley-ui-sections-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'label',
			array(
				'label'       => esc_html__( 'Small Label', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Amaley Promise', 'amaley-ui-sections-kit' ),
			)
		);

		$this->add_control(
			'trust_title',
			array(
				'label'   => esc_html__( 'Main Text', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( 'Rooted in taste. Built on traceability.', 'amaley-ui-sections-kit' ),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__( 'Icon', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'shield',
				'options' => array(
					'shield'   => esc_html__( 'Shield / Trust', 'amaley-ui-sections-kit' ),
					'batch'    => esc_html__( 'Batch / Product', 'amaley-ui-sections-kit' ),
					'leaf'     => esc_html__( 'Leaf / Natural', 'amaley-ui-sections-kit' ),
					'mountain' => esc_html__( 'Mountain / Himalayan', 'amaley-ui-sections-kit' ),
					'cluster'  => esc_html__( 'Cluster / Network', 'amaley-ui-sections-kit' ),
					'gift'     => esc_html__( 'Gift', 'amaley-ui-sections-kit' ),
					'hands'    => esc_html__( 'Hands / Care', 'amaley-ui-sections-kit' ),
				),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Small batch', 'amaley-ui-sections-kit' ),
			)
		);

		$repeater->add_control(
			'text',
			array(
				'label'   => esc_html__( 'Short Text', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( 'Made with care, not pressure.', 'amaley-ui-sections-kit' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Trust Items', 'amaley-ui-sections-kit' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'icon'  => 'shield',
						'title' => esc_html__( 'Rooted in taste, trust and traceability', 'amaley-ui-sections-kit' ),
						'text'  => esc_html__( 'Every product is built around honest sourcing and visible care.', 'amaley-ui-sections-kit' ),
					),
					array(
						'icon'  => 'batch',
						'title' => esc_html__( 'Never bulk', 'amaley-ui-sections-kit' ),
						'text'  => esc_html__( 'Small batches protect quality and producer rhythm.', 'amaley-ui-sections-kit' ),
					),
					array(
						'icon'  => 'mountain',
						'title' => esc_html__( 'Himalayan sourced', 'amaley-ui-sections-kit' ),
						'text'  => esc_html__( 'Ingredients and stories come from mountain communities.', 'amaley-ui-sections-kit' ),
					),
					array(
						'icon'  => 'cluster',
						'title' => esc_html__( 'Cluster linked', 'amaley-ui-sections-kit' ),
						'text'  => esc_html__( 'Designed to connect products with producer ecosystems.', 'amaley-ui-sections-kit' ),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_section',
			array(
				'label' => esc_html__( 'Layout & Style', 'amaley-ui-sections-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'tone',
			array(
				'label'   => esc_html__( 'Tone', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'cream',
				'options' => array(
					'cream' => esc_html__( 'Cream', 'amaley-ui-sections-kit' ),
					'white' => esc_html__( 'White', 'amaley-ui-sections-kit' ),
					'sand'  => esc_html__( 'Sand', 'amaley-ui-sections-kit' ),
					'deep'  => esc_html__( 'Deep Chocolate', 'amaley-ui-sections-kit' ),
					'green' => esc_html__( 'Earth Green', 'amaley-ui-sections-kit' ),
				),
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'cards',
				'options' => array(
					'cards'   => esc_html__( 'Card Strip', 'amaley-ui-sections-kit' ),
					'compact' => esc_html__( 'Compact Strip', 'amaley-ui-sections-kit' ),
					'minimal' => esc_html__( 'Minimal', 'amaley-ui-sections-kit' ),
				),
			)
		);


		$this->add_control(
			'width',
			array(
				'label'   => esc_html__( 'Width Mode', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'contained',
				'options' => array(
					'contained'  => esc_html__( 'Contained', 'amaley-ui-sections-kit' ),
					'full'       => esc_html__( 'Full width inside section', 'amaley-ui-sections-kit' ),
					'full-bleed' => esc_html__( 'Full bleed viewport', 'amaley-ui-sections-kit' ),
				),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Desktop Columns', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
			)
		);

		$this->add_control(
			'mobile',
			array(
				'label'   => esc_html__( 'Mobile Behaviour', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'stack',
				'options' => array(
					'stack'  => esc_html__( 'Responsive Stacked Cards', 'amaley-ui-sections-kit' ),
					'scroll' => esc_html__( 'Legacy Horizontal Scroll', 'amaley-ui-sections-kit' ),
				),
			)
		);


		$this->add_control(
			'motion',
			array(
				'label'   => esc_html__( 'Transformation', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'glow',
				'options' => array(
					'none' => esc_html__( 'None', 'amaley-ui-sections-kit' ),
					'soft' => esc_html__( 'Soft motion', 'amaley-ui-sections-kit' ),
					'lift' => esc_html__( 'Lift on hover', 'amaley-ui-sections-kit' ),
					'glow' => esc_html__( 'Gold glow', 'amaley-ui-sections-kit' ),
				),
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => esc_html__( 'Intro Alignment', 'amaley-ui-sections-kit' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'amaley-ui-sections-kit' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'amaley-ui-sections-kit' ),
						'icon'  => 'eicon-text-align-center',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	/** {@inheritDoc} */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo Amaley_UI_Trust_Strip::render(
			array(
				'label'       => isset( $settings['label'] ) ? $settings['label'] : '',
				'title'       => isset( $settings['trust_title'] ) ? $settings['trust_title'] : '',
				'items_array' => isset( $settings['items'] ) ? $settings['items'] : array(),
				'tone'        => isset( $settings['tone'] ) ? $settings['tone'] : 'cream',
				'style'       => isset( $settings['style'] ) ? $settings['style'] : 'cards',
				'columns'     => isset( $settings['columns'] ) ? $settings['columns'] : 4,
				'mobile'      => isset( $settings['mobile'] ) ? $settings['mobile'] : 'stack',
				'motion'      => isset( $settings['motion'] ) ? $settings['motion'] : 'glow',
				'align'       => isset( $settings['align'] ) ? $settings['align'] : 'left',
				'width'       => isset( $settings['width'] ) ? $settings['width'] : 'contained',
			)
		);
	}
}
