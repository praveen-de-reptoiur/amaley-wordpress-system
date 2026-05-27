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
        /** @var Amaley_DE_Plugin|null */
        private static $instance = null;

        /** @var Amaley_DE_Renderer */
        public $renderer;

        /** @var Amaley_DE_Query */
        public $query;

        /** @var Amaley_DE_Settings */
        public $settings;

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

            // v1.3.5: Do not register plugin-owned CPTs/taxonomies.
            // Amaley uses CPT UI/ACF for Clusters, SHGs and Members, so the
            // Discovery Engine must not create duplicate admin menus such as
            // amaley_collection, amaley_cluster, amaley_shg or amaley_member.
            add_action('wp_enqueue_scripts', array($this, 'register_assets'));
            add_action('admin_enqueue_scripts', array($this, 'register_admin_assets'));
            add_action('admin_menu', array($this->settings, 'add_admin_menu'));
            add_action('admin_init', array($this->settings, 'maybe_handle_admin_save'));

            add_shortcode('amaley_discovery', array($this, 'shortcode'));

            add_action('wp_ajax_amaley_de_filter', array($this, 'ajax_filter'));
            add_action('wp_ajax_nopriv_amaley_de_filter', array($this, 'ajax_filter'));

            add_action('elementor/widgets/register', array($this, 'register_elementor_widgets'));
            add_action('elementor/elements/categories_registered', array($this, 'register_elementor_category'));
        }

        public function register_assets() {
            wp_register_style('amaley-de-frontend', AMALEY_DE_URL . 'assets/css/amaley-de-frontend.css', array(), AMALEY_DE_VERSION);
            wp_register_script('amaley-de-frontend', AMALEY_DE_URL . 'assets/js/amaley-de-frontend.js', array(), AMALEY_DE_VERSION, true);
            wp_localize_script(
                'amaley-de-frontend',
                'amaleyDiscoveryEngine',
                array(
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'nonce'   => wp_create_nonce('amaley_de_filter_nonce'),
                )
            );
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

            // Runtime patch layer: lets future scoped CSS/style fixes come from
            // Admin → Amaley Discovery → Import/Export JSON instead of replacing
            // plugin files. It loads after the main CSS and remains optional.
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
            $atts = shortcode_atts(
                array(
                    'type'               => 'products',
                    'heading'            => 'Our {Products}',
                    'kicker'             => 'Shop Amaley',
                    'per_page'           => 9,
                    'columns_desktop'    => 3,
                    'columns_tablet'     => 2,
                    'columns_mobile'     => 1,
                    'filter_position'     => 'left',
                    'desktop_filter_position' => 'left',
                    'tablet_filter_position'  => 'top',
                    'mobile_filter_position'  => 'top',
                    'desktop_filter_mode' => 'visible',
                    'tablet_filter_mode'  => 'drawer',
                    'mobile_filter_mode'  => 'drawer',
                    'full_bleed'         => 'yes',
                    'inner_width'        => 'none',
                    'pagination_type'    => 'numbers',
                    'show_search'        => 'yes',
                    'show_categories'    => 'yes',
                    'show_price'         => 'yes',
                    'show_tags'          => 'yes',
                    'show_stock'         => 'yes',
                    'show_sort'          => 'yes',
                    'default_filter_mode'=> 'all',
                    'default_category'   => '',
                    'default_tag'        => '',
                    'default_sort'       => 'latest',
                    'post_type'          => '',
                    'taxonomy'           => '',
                    'card_renderer'      => 'default',
                    'elementor_template_id' => 0,
                ),
                $atts,
                'amaley_discovery'
            );

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
                'search'    => isset($_POST['ade_search']) ? sanitize_text_field(wp_unslash($_POST['ade_search'])) : '',
                'category'  => isset($_POST['ade_category']) ? sanitize_text_field(wp_unslash($_POST['ade_category'])) : '',
                'tag'       => isset($_POST['ade_tag']) ? sanitize_text_field(wp_unslash($_POST['ade_tag'])) : '',
                'stock'     => isset($_POST['ade_stock']) ? sanitize_text_field(wp_unslash($_POST['ade_stock'])) : '',
                'min_price' => isset($_POST['ade_min_price']) ? sanitize_text_field(wp_unslash($_POST['ade_min_price'])) : '',
                'max_price' => isset($_POST['ade_max_price']) ? sanitize_text_field(wp_unslash($_POST['ade_max_price'])) : '',
                'sort'      => isset($_POST['ade_sort']) ? sanitize_text_field(wp_unslash($_POST['ade_sort'])) : '',
                'page'      => isset($_POST['ade_page']) ? max(1, absint(wp_unslash($_POST['ade_page']))) : 1,
                'attrs'     => array(),
            );

            foreach (array('cluster', 'collection_type', 'core_ingredient', 'producer_maker', 'region_cluster', 'shg', 'use_case', 'village_source_location') as $attr_key) {
                $post_key = 'ade_attr_' . $attr_key;
                $filters['attrs'][$attr_key] = isset($_POST[$post_key]) ? sanitize_text_field(wp_unslash($_POST[$post_key])) : '';
            }

            $settings['filters'] = $filters;
            $response = $this->renderer->render_results_only($settings);
            wp_send_json_success($response);
        }

        public function register_elementor_category($elements_manager) {
            $elements_manager->add_category(
                'amaley-discovery-engine',
                array(
                    'title' => __('Amaley Discovery Engine', 'amaley-discovery-engine'),
                    'icon'  => 'fa fa-filter',
                )
            );
        }

        public function register_elementor_widgets($widgets_manager) {
            if (!did_action('elementor/loaded')) {
                return;
            }

            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-base.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-heading-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-text-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-icon-list-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-product-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-collection-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-cluster-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-shg-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-member-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-product-topbar-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-collection-topbar-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-cluster-topbar-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-shg-topbar-widget.php';
            require_once AMALEY_DE_PATH . 'includes/elementor/class-amaley-de-elementor-member-topbar-widget.php';

            $widgets_manager->register(new Amaley_DE_Elementor_Heading_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Text_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Icon_List_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Product_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Collection_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Cluster_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_SHG_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Member_Widget());

            // Topbar preset widgets: same discovery engine, preconfigured for
            // compact horizontal filters. Useful for Cluster/SHG directories
            // and pages where a full left sidebar is not desired.
            $widgets_manager->register(new Amaley_DE_Elementor_Product_Topbar_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Collection_Topbar_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Cluster_Topbar_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_SHG_Topbar_Widget());
            $widgets_manager->register(new Amaley_DE_Elementor_Member_Topbar_Widget());
        }
    }
}
