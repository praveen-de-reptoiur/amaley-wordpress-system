<?php
/**
 * Main plugin bootstrap class.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amaley_DE_Plugin')) {
    final class Amaley_DE_Plugin {
        private static $instance = null;
        /** @var Amaley_DE_Renderer */
        public $renderer;
        /** @var Amaley_DE_Query */
        public $query;
        /** @var Amaley_DE_Settings */
        public $settings;
        private $elementor_controls_patched = array();

        public static function instance() {
            if (null === self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function __construct() {
            $this->settings = new Amaley_DE_Settings();
            $this->query = new Amaley_DE_Query();
            $this->renderer = new Amaley_DE_Renderer($this->query);

            add_action('wp_enqueue_scripts', array($this, 'register_assets'));
            add_action('admin_enqueue_scripts', array($this, 'register_admin_assets'));
            add_action('admin_menu', array($this->settings, 'add_admin_menu'));
            add_action('admin_init', array($this->settings, 'maybe_handle_admin_save'));
            add_shortcode('amaley_discovery', array($this, 'shortcode'));
            add_action('wp_ajax_amaley_de_filter', array($this, 'ajax_filter'));
            add_action('wp_ajax_nopriv_amaley_de_filter', array($this, 'ajax_filter'));
            add_action('elementor/widgets/register', array($this, 'register_elementor_widgets'));
            add_action('elementor/elements/categories_registered', array($this, 'register_elementor_category'));

            // Source-level compatibility for the existing Amaley Templates Shop Discovery widget.
            // It changes only Elementor card controls; filters/query/data remain untouched.
            add_action('elementor/element/after_section_end', array($this, 'maybe_patch_elementor_card_controls'), 20, 3);
        }

        public function register_assets() {
            wp_register_style('amaley-de-frontend', AMALEY_DE_URL . 'assets/css/amaley-de-frontend.css', array(), AMALEY_DE_VERSION);
            wp_register_script('amaley-de-frontend', AMALEY_DE_URL . 'assets/js/amaley-de-frontend.js', array(), AMALEY_DE_VERSION, true);
            wp_localize_script('amaley-de-frontend', 'amaleyDiscoveryEngine', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('amaley_de_filter_nonce'),
            ));
        }

        public function register_admin_assets($hook) {
            if ('toplevel_page_amaley-discovery-engine' !== $hook) {
                return;
            }
            wp_enqueue_style('amaley-de-admin', AMALEY_DE_URL . 'assets/css/amaley-de-admin.css', array(), AMALEY_DE_VERSION);
        }

        public function enqueue_frontend_assets() {
            if (!wp_style_is('amaley-de-frontend', 'registered')) {
                $this->register_assets();
            }
            wp_enqueue_style('amaley-de-frontend');
            if (class_exists('Amaley_DE_Settings')) {
                $settings = Amaley_DE_Settings::get();
                if (!empty($settings['runtime_css_enabled']) && 'yes' === $settings['runtime_css_enabled'] && !empty($settings['runtime_css'])) {
                    $runtime_css_check = Amaley_DE_Settings::validate_runtime_css_scope($settings['runtime_css']);
                    if (!is_wp_error($runtime_css_check)) {
                        wp_add_inline_style('amaley-de-frontend', $settings['runtime_css']);
                    }
                }
            }
            wp_enqueue_script('amaley-de-frontend');
        }

        public function shortcode($atts = array()) {
            $atts = shortcode_atts(array(
                'type' => 'products',
                'heading' => 'Our {Products}',
                'kicker' => 'Shop Amaley',
                'per_page' => 9,
                'columns_desktop' => 3,
                'columns_tablet' => 2,
                'columns_mobile' => 1,
                'filter_position' => 'left',
                'desktop_filter_position' => 'left',
                'tablet_filter_position' => 'top',
                'mobile_filter_position' => 'top',
                'desktop_filter_mode' => 'visible',
                'tablet_filter_mode' => 'compact',
                'mobile_filter_mode' => 'compact',
                'full_bleed' => 'yes',
                'inner_width' => 'none',
                'pagination_type' => 'numbers',
                'show_search' => 'yes',
                'show_categories' => 'yes',
                'show_price' => 'yes',
                'show_tags' => 'yes',
                'show_stock' => 'yes',
                'show_sort' => 'yes',
                'default_filter_mode' => 'all',
                'default_category' => '',
                'default_tag' => '',
                'default_sort' => 'latest',
                'post_type' => '',
                'taxonomy' => '',
                'card_renderer' => 'amaley_core_product_card',
                'elementor_template_id' => 0,
                'amaley_core_product_card_template' => 'og_product_card_1',
            ), $atts, 'amaley_discovery');
            return $this->renderer->render($atts);
        }

        public function ajax_filter() {
            check_ajax_referer('amaley_de_filter_nonce', 'nonce');
            $raw_settings = isset($_POST['settings']) ? wp_unslash($_POST['settings']) : '';
            $settings = json_decode($raw_settings, true);
            if (!is_array($settings)) {
                $settings = array();
            }
            $filters = array(
                'search' => isset($_POST['ade_search']) ? sanitize_text_field(wp_unslash($_POST['ade_search'])) : '',
                'category' => isset($_POST['ade_category']) ? sanitize_text_field(wp_unslash($_POST['ade_category'])) : '',
                'tag' => isset($_POST['ade_tag']) ? sanitize_text_field(wp_unslash($_POST['ade_tag'])) : '',
                'stock' => isset($_POST['ade_stock']) ? sanitize_text_field(wp_unslash($_POST['ade_stock'])) : '',
                'min_price' => isset($_POST['ade_min_price']) ? sanitize_text_field(wp_unslash($_POST['ade_min_price'])) : '',
                'max_price' => isset($_POST['ade_max_price']) ? sanitize_text_field(wp_unslash($_POST['ade_max_price'])) : '',
                'sort' => isset($_POST['ade_sort']) ? sanitize_text_field(wp_unslash($_POST['ade_sort'])) : '',
                'page' => isset($_POST['ade_page']) ? max(1, absint(wp_unslash($_POST['ade_page']))) : 1,
                'attrs' => array(),
            );
            foreach (array('cluster','collection_type','core_ingredient','producer_maker','region_cluster','shg','use_case','village_source_location') as $attr_key) {
                $post_key = 'ade_attr_' . $attr_key;
                $filters['attrs'][$attr_key] = isset($_POST[$post_key]) ? sanitize_text_field(wp_unslash($_POST[$post_key])) : '';
            }
            $settings['filters'] = $filters;
            $response = $this->renderer->render_results_only($settings);
            wp_send_json_success($response);
        }

        public function register_elementor_category($elements_manager) {
            $elements_manager->add_category('amaley-discovery-engine', array(
                'title' => __('Amaley Discovery Engine', 'amaley-discovery-engine'),
                'icon' => 'fa fa-filter',
            ));
        }

        public function register_elementor_widgets($widgets_manager) {
            if (!did_action('elementor/loaded')) {
                return;
            }
            $files = array(
                'class-amaley-de-elementor-base.php',
                'class-amaley-de-elementor-heading-widget.php',
                'class-amaley-de-elementor-text-widget.php',
                'class-amaley-de-elementor-icon-list-widget.php',
                'class-amaley-de-elementor-product-widget.php',
                'class-amaley-de-elementor-collection-widget.php',
                'class-amaley-de-elementor-cluster-widget.php',
                'class-amaley-de-elementor-shg-widget.php',
                'class-amaley-de-elementor-member-widget.php',
                'class-amaley-de-elementor-product-topbar-widget.php',
                'class-amaley-de-elementor-collection-topbar-widget.php',
                'class-amaley-de-elementor-cluster-topbar-widget.php',
                'class-amaley-de-elementor-shg-topbar-widget.php',
                'class-amaley-de-elementor-member-topbar-widget.php',
            );
            foreach ($files as $file) {
                $path = AMALEY_DE_PATH . 'includes/elementor/' . $file;
                if (file_exists($path)) {
                    require_once $path;
                }
            }
            $classes = array(
                'Amaley_DE_Elementor_Heading_Widget',
                'Amaley_DE_Elementor_Text_Widget',
                'Amaley_DE_Elementor_Icon_List_Widget',
                'Amaley_DE_Elementor_Product_Widget',
                'Amaley_DE_Elementor_Collection_Widget',
                'Amaley_DE_Elementor_Cluster_Widget',
                'Amaley_DE_Elementor_SHG_Widget',
                'Amaley_DE_Elementor_Member_Widget',
                'Amaley_DE_Elementor_Product_Topbar_Widget',
                'Amaley_DE_Elementor_Collection_Topbar_Widget',
                'Amaley_DE_Elementor_Cluster_Topbar_Widget',
                'Amaley_DE_Elementor_SHG_Topbar_Widget',
                'Amaley_DE_Elementor_Member_Topbar_Widget',
            );
            foreach ($classes as $class) {
                if (class_exists($class)) {
                    $widgets_manager->register(new $class());
                }
            }
        }

        public function maybe_patch_elementor_card_controls($element, $section_id, $args) {
            if (!is_object($element) || !method_exists($element, 'get_name')) {
                return;
            }
            $name = $element->get_name();
            $target_names = array(
                'amaley_tpl_shop_discovery',
                'amaley-tpl-shop-discovery',
            );
            if (!in_array($name, $target_names, true)) {
                return;
            }
            $key = spl_object_hash($element);
            if (isset($this->elementor_controls_patched[$key])) {
                return;
            }
            $this->elementor_controls_patched[$key] = true;

            if (method_exists($element, 'update_control')) {
                $element->update_control('card_renderer', array(
                    'label' => __('Product Card Renderer', 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'amaley_core_product_card',
                    'options' => array(
                        'amaley_core_product_card' => __('Amaley Core Product Card — Select Template', 'amaley-discovery-engine'),
                        'elementor_template' => __('Legacy Elementor Template — Advanced Only', 'amaley-discovery-engine'),
                        'marketplace_card' => __('Discovery Native Marketplace Card', 'amaley-discovery-engine'),
                        'default' => __('Discovery Default Card', 'amaley-discovery-engine'),
                    ),
                ));
                $element->update_control('elementor_template_id', array('condition' => array('card_renderer' => 'elementor_template')));
                $element->update_control('marketplace_badge_text', array('condition' => array('card_renderer' => 'marketplace_card')));
                $element->update_control('marketplace_meta_text', array('condition' => array('card_renderer' => 'marketplace_card')));
            }

            $element->start_controls_section('amaley_de_core_card_source_controls', array(
                'label' => __('Selected Core Product Card', 'amaley-discovery-engine'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => array('card_renderer' => 'amaley_core_product_card'),
            ));
            $element->add_control('amaley_core_product_card_template', array(
                'label' => __('Amaley Core Product Card Template', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'og_product_card_1',
                'options' => apply_filters('amaley_de_core_product_card_template_options', array('og_product_card_1' => __('OG Product Card 1', 'amaley-discovery-engine'))),
            ));
            $this->add_core_card_element_controls($element);
            $element->end_controls_section();
        }

        private function add_core_card_element_controls($element) {
            $switches = array(
                'amaley_dcrsf_show_image' => array('Show Image', 'yes'),
                'amaley_dcrsf_show_label' => array('Show Label', 'yes'),
                'amaley_dcrsf_show_title' => array('Show Title', 'yes'),
                'amaley_dcrsf_show_excerpt' => array('Show Description', 'yes'),
                'amaley_dcrsf_show_meta' => array('Show Price / Origin Meta', 'yes'),
                'amaley_dcrsf_show_tags' => array('Show Tags / Chips', 'yes'),
                'amaley_dcrsf_show_button' => array('Show Button', 'yes'),
            );
            foreach ($switches as $key => $data) {
                $element->add_control($key, array(
                    'label' => __($data[0], 'amaley-discovery-engine'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => $data[1],
                    'return_value' => 'yes',
                ));
            }
            $element->add_control('amaley_dcrsf_label_text', array(
                'label' => __('Label Text Override', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ));
            $element->add_control('amaley_dcrsf_excerpt_words', array(
                'label' => __('Description Word Limit', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 18,
                'min' => 6,
                'max' => 40,
            ));
            $element->add_control('amaley_dcrsf_button_text', array(
                'label' => __('Button Text', 'amaley-discovery-engine'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View Product', 'amaley-discovery-engine'),
            ));
        }
    }
}
