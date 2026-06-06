<?php
/**
 * Settings helper for Amaley Discovery Engine.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amaley_DE_Settings')) {
    class Amaley_DE_Settings {
        const OPTION_KEY = 'amaley_de_settings';

        public static function defaults() {
            return array(
                'primary_color' => '#2E1203',
                'gold_color' => '#C2880A',
                'rust_color' => '#9A3E17',
                'ivory_color' => '#FFF8EA',
                'cream_color' => '#F9EEE2',
                'heading_font' => '',
                'body_font' => '',
                'collection_post_type' => 'amaley_collection',
                'cluster_post_type' => 'amaley_cluster',
                'shg_post_type' => 'amaley_shg',
                'member_post_type' => 'amaley_member',
                'collection_taxonomy' => 'amaley_collection_type',
                'cluster_taxonomy' => 'amaley_region',
                'shg_taxonomy' => 'amaley_shg_category',
                'member_taxonomy' => 'amaley_member_skill',
                'runtime_css_enabled' => 'no',
                'runtime_css' => '',
                'register_cpts' => 'no',
                'presets' => array(),
            );
        }

        public static function get() {
            $saved = get_option(self::OPTION_KEY, array());
            return wp_parse_args(is_array($saved) ? $saved : array(), self::defaults());
        }

        public static function get_value($key, $default = '') {
            $settings = self::get();
            return isset($settings[$key]) ? $settings[$key] : $default;
        }

        public static function get_preset_settings($key, $type = '') {
            $settings = self::get();
            $key = sanitize_key($key);
            if (empty($settings['presets']) || !is_array($settings['presets']) || empty($settings['presets'][$key]) || !is_array($settings['presets'][$key])) {
                return array();
            }
            $preset = $settings['presets'][$key];
            if (!empty($type) && !empty($preset['type']) && sanitize_key($preset['type']) !== sanitize_key($type)) {
                return array();
            }
            return $preset;
        }

        public function add_admin_menu() {
            add_menu_page(
                __('Amaley Discovery', 'amaley-discovery-engine'),
                __('Amaley Discovery', 'amaley-discovery-engine'),
                'manage_options',
                'amaley-discovery-engine',
                array($this, 'render_admin_page'),
                'dashicons-filter',
                58
            );
        }

        public function maybe_handle_admin_save() {
            if (!is_admin() || empty($_POST['amaley_de_settings_submit'])) {
                return;
            }
            if (!current_user_can('manage_options')) {
                return;
            }
            check_admin_referer('amaley_de_settings_save', 'amaley_de_settings_nonce');
            $current = self::get();
            $current['primary_color'] = sanitize_hex_color($_POST['primary_color'] ?? $current['primary_color']) ?: $current['primary_color'];
            $current['gold_color'] = sanitize_hex_color($_POST['gold_color'] ?? $current['gold_color']) ?: $current['gold_color'];
            $current['rust_color'] = sanitize_hex_color($_POST['rust_color'] ?? $current['rust_color']) ?: $current['rust_color'];
            $current['ivory_color'] = sanitize_hex_color($_POST['ivory_color'] ?? $current['ivory_color']) ?: $current['ivory_color'];
            $current['cream_color'] = sanitize_hex_color($_POST['cream_color'] ?? $current['cream_color']) ?: $current['cream_color'];
            foreach (array('collection_post_type','cluster_post_type','shg_post_type','member_post_type','collection_taxonomy','cluster_taxonomy','shg_taxonomy','member_taxonomy') as $key) {
                if (isset($_POST[$key])) {
                    $current[$key] = sanitize_key(wp_unslash($_POST[$key]));
                }
            }
            $current['register_cpts'] = 'no';
            update_option(self::OPTION_KEY, $current, false);
            add_settings_error('amaley_de_messages', 'amaley_de_saved', __('Settings saved.', 'amaley-discovery-engine'), 'updated');
        }

        public function render_admin_page() {
            if (!current_user_can('manage_options')) {
                return;
            }
            $settings = self::get();
            settings_errors('amaley_de_messages');
            ?>
            <div class="wrap amaley-de-admin-wrap">
                <h1><?php esc_html_e('Amaley Discovery Engine', 'amaley-discovery-engine'); ?></h1>
                <p><?php esc_html_e('Discovery/filter engine for Amaley products and mapped content. This plugin does not register CPTs.', 'amaley-discovery-engine'); ?></p>
                <form method="post">
                    <?php wp_nonce_field('amaley_de_settings_save', 'amaley_de_settings_nonce'); ?>
                    <input type="hidden" name="amaley_de_settings_submit" value="1">
                    <h2><?php esc_html_e('Design Tokens', 'amaley-discovery-engine'); ?></h2>
                    <table class="form-table" role="presentation">
                        <?php foreach (array('primary_color'=>'Primary','gold_color'=>'Gold','rust_color'=>'Rust','ivory_color'=>'Ivory','cream_color'=>'Cream') as $key => $label) : ?>
                            <tr><th scope="row"><label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label></th><td><input type="text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($settings[$key]); ?>" class="regular-text"></td></tr>
                        <?php endforeach; ?>
                    </table>
                    <h2><?php esc_html_e('Existing CPT Mapping', 'amaley-discovery-engine'); ?></h2>
                    <table class="form-table" role="presentation">
                        <?php foreach (array('collection_post_type','cluster_post_type','shg_post_type','member_post_type','collection_taxonomy','cluster_taxonomy','shg_taxonomy','member_taxonomy') as $key) : ?>
                            <tr><th scope="row"><label for="<?php echo esc_attr($key); ?>"><?php echo esc_html(str_replace('_', ' ', ucwords($key, '_'))); ?></label></th><td><input type="text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($settings[$key]); ?>" class="regular-text"></td></tr>
                        <?php endforeach; ?>
                    </table>
                    <?php submit_button(__('Save Settings', 'amaley-discovery-engine')); ?>
                </form>
            </div>
            <?php
        }

        public static function validate_runtime_css_scope($css) {
            if (false !== stripos((string)$css, '<script') || false !== stripos((string)$css, 'javascript:') || false !== stripos((string)$css, '@import')) {
                return new WP_Error('unsafe_css', __('Runtime CSS contains unsafe patterns.', 'amaley-discovery-engine'));
            }
            return true;
        }

        public static function register_optional_content_types() {
            return;
        }
    }
}
