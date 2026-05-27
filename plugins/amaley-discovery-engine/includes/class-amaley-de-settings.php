<?php
/**
 * Settings, defaults, CPT registration, and import/export admin UI.
 *
 * @package AmaleyDiscoveryEngine
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Amaley_DE_Settings')) {
    class Amaley_DE_Settings {
        const OPTION_KEY = 'amaley_de_settings';
        const PRESETS_OPTION_KEY = 'amaley_de_presets';
        const BACKUP_OPTION_KEY = 'amaley_de_import_backups';
        const PACKAGE_SCHEMA = 'amaley_discovery_engine_package_v1';

        /**
         * Default plugin settings.
         *
         * @return array
         */
        public static function defaults() {
            return array(
                'register_cpts'           => 'no',
                'collection_post_type'    => 'amaley_collection',
                'cluster_post_type'       => 'amaley_cluster',
                'shg_post_type'           => 'amaley_shg',
                'member_post_type'        => 'amaley_member',
                'collection_taxonomy'     => 'amaley_collection_type',
                'cluster_taxonomy'        => 'amaley_region',
                'shg_taxonomy'            => 'amaley_shg_category',
                'member_taxonomy'         => 'amaley_member_skill',
                'relation_cluster_meta'   => '_amaley_cluster_id',
                'relation_shg_meta'       => '_amaley_shg_id',
                'relation_member_meta'    => '_amaley_member_id',
                'primary_color'           => '#2E1203',
                'gold_color'              => '#C2880A',
                'rust_color'              => '#B5502A',
                'ivory_color'             => '#F7EFE2',
                'cream_color'             => '#FFF8EA',
                'heading_font'            => 'Playfair Display',
                'body_font'               => 'Lato',
                'runtime_css_enabled'     => 'yes',
                'runtime_css'             => '',
            );
        }

        /**
         * Default reusable presets. These can be replaced or extended by JSON import.
         *
         * Presets are intentionally stored separately from plugin settings so future
         * card/filter/layout packs can be imported without replacing the plugin core.
         *
         * @return array
         */
        public static function default_presets() {
            return array(
                'product_shop_full' => array(
                    'label'       => 'Product Shop — Full Filter System',
                    'type'        => 'products',
                    'description' => 'Full-width product discovery with sidebar filters, price, tags, stock, sort and pagination.',
                    'settings'    => array(
                        'per_page'            => 12,
                        'columns_desktop'     => 3,
                        'columns_tablet'      => 2,
                        'columns_mobile'      => 1,
                        'filter_position'     => 'left',
                        'full_bleed'          => 'yes',
                        'inner_width'         => 'none',
                        'pagination_type'     => 'numbers',
                        'show_search'         => 'yes',
                        'show_categories'     => 'yes',
                        'show_price'          => 'yes',
                        'show_tags'           => 'yes',
                        'show_stock'          => 'yes',
                        'show_sort'           => 'yes',
                        'show_active_chips'   => 'yes',
                        'section_padding_top' => 76,
                        'section_padding_bottom' => 84,
                    ),
                ),
                'product_home_curated' => array(
                    'label'       => 'Product Home — Curated Premium Grid',
                    'type'        => 'products',
                    'description' => 'Homepage-friendly product grid with lighter filtering and premium Amaley spacing.',
                    'settings'    => array(
                        'per_page'            => 8,
                        'columns_desktop'     => 4,
                        'columns_tablet'      => 2,
                        'columns_mobile'      => 1,
                        'filter_position'     => 'top',
                        'full_bleed'          => 'no',
                        'inner_width'         => '1180',
                        'pagination_type'     => 'none',
                        'show_price'          => 'no',
                        'show_stock'          => 'no',
                    ),
                ),
                'collection_directory' => array(
                    'label'       => 'Collection Directory',
                    'type'        => 'collections',
                    'description' => 'Collection listing with taxonomy filter, search, sort and pagination.',
                    'settings'    => array(
                        'per_page'            => 9,
                        'columns_desktop'     => 3,
                        'columns_tablet'      => 2,
                        'columns_mobile'      => 1,
                        'filter_position'     => 'left',
                        'full_bleed'          => 'yes',
                        'inner_width'         => 'none',
                        'pagination_type'     => 'numbers',
                    ),
                ),
                'cluster_directory' => array(
                    'label'       => 'Cluster Directory',
                    'type'        => 'clusters',
                    'description' => 'Cluster listing with taxonomy filter, search, sort and pagination.',
                    'settings'    => array(
                        'per_page'            => 12,
                        'columns_desktop'     => 3,
                        'columns_tablet'      => 2,
                        'columns_mobile'      => 1,
                        'filter_position'     => 'left',
                        'full_bleed'          => 'yes',
                        'inner_width'         => 'none',
                        'pagination_type'     => 'numbers',
                    ),
                ),
                'shg_directory' => array(
                    'label'       => 'SHG Directory',
                    'type'        => 'shgs',
                    'description' => 'SHG listing with cluster/taxonomy mapping and pagination.',
                    'settings'    => array(
                        'per_page'            => 12,
                        'columns_desktop'     => 3,
                        'columns_tablet'      => 2,
                        'columns_mobile'      => 1,
                        'filter_position'     => 'left',
                        'full_bleed'          => 'yes',
                        'pagination_type'     => 'numbers',
                    ),
                ),
                'member_directory' => array(
                    'label'       => 'Member Directory',
                    'type'        => 'members',
                    'description' => 'Member listing with taxonomy/search/sort and pagination.',
                    'settings'    => array(
                        'per_page'            => 16,
                        'columns_desktop'     => 4,
                        'columns_tablet'      => 2,
                        'columns_mobile'      => 1,
                        'filter_position'     => 'left',
                        'full_bleed'          => 'yes',
                        'pagination_type'     => 'numbers',
                    ),
                ),
            );
        }

        /**
         * Get merged settings.
         *
         * @return array
         */
        public static function get() {
            $saved = get_option(self::OPTION_KEY, array());
            if (!is_array($saved)) {
                $saved = array();
            }
            return wp_parse_args($saved, self::defaults());
        }

        /**
         * Get reusable presets.
         *
         * @return array
         */
        public static function get_presets() {
            $saved = get_option(self::PRESETS_OPTION_KEY, array());
            if (!is_array($saved)) {
                $saved = array();
            }
            return array_replace_recursive(self::default_presets(), self::sanitize_presets($saved));
        }

        /**
         * Get preset options for Elementor select controls.
         *
         * @param string $type Optional widget type filter.
         * @return array
         */
        public static function get_preset_options($type = '') {
            $options = array('' => __('Do not use imported preset', 'amaley-discovery-engine'));
            foreach (self::get_presets() as $key => $preset) {
                if (!empty($type) && !empty($preset['type']) && $type !== $preset['type']) {
                    continue;
                }
                $options[$key] = !empty($preset['label']) ? $preset['label'] : $key;
            }
            return $options;
        }

        /**
         * Get preset settings.
         *
         * @param string $key Preset key.
         * @param string $type Optional type check.
         * @return array
         */
        public static function get_preset_settings($key, $type = '') {
            $key = sanitize_key($key);
            $presets = self::get_presets();
            if (empty($presets[$key]) || empty($presets[$key]['settings']) || !is_array($presets[$key]['settings'])) {
                return array();
            }
            if (!empty($type) && !empty($presets[$key]['type']) && $type !== $presets[$key]['type']) {
                return array();
            }
            return self::sanitize_deep($presets[$key]['settings']);
        }

        /**
         * Get single setting.
         *
         * @param string $key Setting key.
         * @param mixed  $fallback Fallback value.
         * @return mixed
         */
        public static function get_value($key, $fallback = '') {
            $settings = self::get();
            return isset($settings[$key]) ? $settings[$key] : $fallback;
        }

        /**
         * Save settings safely.
         *
         * @param array $settings New settings.
         * @return void
         */
        public static function save($settings) {
            update_option(self::OPTION_KEY, self::sanitize_settings($settings), false);
        }

        /**
         * Sanitize settings according to known keys.
         *
         * @param array $settings Raw settings.
         * @return array
         */
        public static function sanitize_settings($settings) {
            $defaults = self::defaults();
            $settings = is_array($settings) ? $settings : array();
            $clean = array();

            foreach ($defaults as $key => $default) {
                if (!isset($settings[$key])) {
                    $clean[$key] = ('register_cpts' === $key) ? 'no' : $default;
                    continue;
                }

                if ('register_cpts' === $key || 'runtime_css_enabled' === $key) {
                    $clean[$key] = 'yes' === $settings[$key] ? 'yes' : 'no';
                    continue;
                }

                if ('runtime_css' === $key) {
                    $clean[$key] = self::sanitize_runtime_css($settings[$key]);
                    continue;
                }

                if (false !== strpos($key, 'color')) {
                    $color = sanitize_hex_color($settings[$key]);
                    $clean[$key] = $color ? $color : $default;
                    continue;
                }

                $clean[$key] = sanitize_text_field($settings[$key]);
            }

            return $clean;
        }

        /**
         * Save preset library safely.
         *
         * @param array $presets Presets.
         * @return void
         */
        public static function save_presets($presets) {
            update_option(self::PRESETS_OPTION_KEY, self::sanitize_presets($presets), false);
        }

        /**
         * Keep a small rollback history before imports/settings changes.
         *
         * @param string $reason Backup reason.
         * @return void
         */
        public static function create_backup($reason = 'manual') {
            $backups = get_option(self::BACKUP_OPTION_KEY, array());
            $backups = is_array($backups) ? $backups : array();
            array_unshift($backups, array(
                'created_at' => current_time('mysql'),
                'reason'     => sanitize_text_field($reason),
                'package'    => self::export_package(),
            ));
            $backups = array_slice($backups, 0, 8);
            update_option(self::BACKUP_OPTION_KEY, $backups, false);
        }

        /**
         * Get available rollback backups.
         *
         * @return array
         */
        public static function get_backups() {
            $backups = get_option(self::BACKUP_OPTION_KEY, array());
            return is_array($backups) ? $backups : array();
        }

        /**
         * Restore a saved backup package.
         *
         * @param int $index Backup index.
         * @return true|WP_Error
         */
        public static function restore_backup($index) {
            $backups = self::get_backups();
            $index = absint($index);
            if (!isset($backups[$index]['package']) || !is_array($backups[$index]['package'])) {
                return new WP_Error('amaley_de_backup_missing', __('Selected rollback backup was not found.', 'amaley-discovery-engine'));
            }
            self::create_backup('before_rollback');
            return self::import_package($backups[$index]['package'], 'replace', false);
        }

        /**
         * Check if runtime CSS is scoped to this plugin. Prevents accidental global CSS conflicts.
         *
         * @param string $css CSS to validate.
         * @return true|WP_Error
         */
        public static function validate_runtime_css_scope($css) {
            $css = trim((string) $css);
            if ('' === $css) {
                return true;
            }

            $css_without_comments = preg_replace('/\/\*.*?\*\//s', '', $css);
            preg_match_all('/([^{}]+)\{/', $css_without_comments, $matches);
            if (empty($matches[1])) {
                return true;
            }

            $unsafe = array();
            foreach ($matches[1] as $selector_group) {
                $selector_group = trim($selector_group);
                if ('' === $selector_group) {
                    continue;
                }
                if (0 === strpos($selector_group, '@media') || 0 === strpos($selector_group, '@supports') || 0 === strpos($selector_group, '@container')) {
                    continue;
                }
                if (false !== stripos($selector_group, '@keyframes') || preg_match('/^(from|to|\d+%)$/i', $selector_group)) {
                    continue;
                }

                $selectors = array_map('trim', explode(',', $selector_group));
                foreach ($selectors as $selector) {
                    if ('' === $selector) {
                        continue;
                    }
                    if (false === strpos($selector, '.amaley-discovery-engine-v1') && false === strpos($selector, '.amaley-de-')) {
                        $unsafe[] = $selector;
                    }
                }
            }

            if (!empty($unsafe)) {
                return new WP_Error(
                    'amaley_de_runtime_css_unscoped',
                    sprintf(
                        /* translators: %s unsafe selectors */
                        __('Runtime CSS import blocked. Keep every selector scoped to .amaley-discovery-engine-v1 or .amaley-de-. Unsafe selectors: %s', 'amaley-discovery-engine'),
                        esc_html(implode(', ', array_slice(array_unique($unsafe), 0, 8)))
                    )
                );
            }

            return true;
        }

        /**
         * Sanitize preset library.
         *
         * @param array $presets Raw presets.
         * @return array
         */
        public static function sanitize_presets($presets) {
            $clean = array();
            if (!is_array($presets)) {
                return $clean;
            }

            foreach ($presets as $key => $preset) {
                $safe_key = sanitize_key($key);
                if (!$safe_key || !is_array($preset)) {
                    continue;
                }

                $clean[$safe_key] = array(
                    'label'       => isset($preset['label']) ? sanitize_text_field($preset['label']) : $safe_key,
                    'type'        => isset($preset['type']) ? sanitize_key($preset['type']) : '',
                    'description' => isset($preset['description']) ? sanitize_textarea_field($preset['description']) : '',
                    'settings'    => isset($preset['settings']) && is_array($preset['settings']) ? self::sanitize_deep($preset['settings']) : array(),
                );
            }

            return $clean;
        }

        /**
         * Recursively sanitize imported preset data.
         *
         * @param mixed $value Raw value.
         * @return mixed
         */
        public static function sanitize_deep($value) {
            if (is_array($value)) {
                $clean = array();
                foreach ($value as $key => $item) {
                    $clean_key = is_string($key) ? sanitize_key($key) : absint($key);
                    $clean[$clean_key] = self::sanitize_deep($item);
                }
                return $clean;
            }

            if (is_bool($value) || is_int($value) || is_float($value)) {
                return $value;
            }

            if (is_string($value)) {
                $trimmed = trim($value);
                if (0 === strpos($trimmed, '#') && sanitize_hex_color($trimmed)) {
                    return sanitize_hex_color($trimmed);
                }
                return sanitize_text_field($trimmed);
            }

            return '';
        }

        /**
         * Sanitize admin-imported runtime CSS.
         *
         * This CSS is intended for future non-core visual fixes/presets without
         * replacing the plugin. It must remain scoped by the admin/user. Dangerous
         * script-like patterns are stripped. Only users with manage_options can save/import it.
         *
         * @param string $css Raw CSS.
         * @return string
         */
        public static function sanitize_runtime_css($css) {
            $css = is_string($css) ? wp_unslash($css) : '';
            $css = str_replace(array("\0", "<script", "</script"), '', $css);
            $css = preg_replace('/javascript\s*:/i', '', $css);
            $css = preg_replace('/expression\s*\(/i', '', $css);
            $css = preg_replace('/behavior\s*:/i', '', $css);
            $css = preg_replace('/@import[^;]+;/i', '', $css);
            $css = wp_kses_no_null($css);
            return trim($css);
        }

        /**
         * Build a portable export package.
         *
         * @return array
         */
        public static function export_package() {
            return array(
                'schema'      => self::PACKAGE_SCHEMA,
                'plugin'      => 'Amaley Discovery Engine',
                'author'      => 'Praveen',
                'version'     => defined('AMALEY_DE_VERSION') ? AMALEY_DE_VERSION : 'unknown',
                'exported_at' => current_time('mysql'),
                'settings'    => self::get(),
                'presets'     => self::get_presets(),
                'notes'       => array(
                    'purpose'       => 'Portable settings, CPT mappings, design tokens and widget presets for Amaley Discovery Engine.',
                    'safe_import'   => 'Import can merge with existing settings or replace settings/presets. Plugin core files are not changed.',
                    'runtime_css'   => 'Future visual/layout fixes can be imported as scoped runtime CSS, reducing the need for plugin ZIP replacement.',
                    'compatibility' => 'Scoped CSS/JS, Elementor-native widgets, WooCommerce-safe query, URL fallback, AJAX, pagination, responsive layout.',
                ),
            );
        }

        /**
         * Import a package or old simple settings JSON.
         *
         * @param array  $data Imported data.
         * @param string $mode merge|replace.
         * @return true|WP_Error
         */
        public static function import_package($data, $mode = 'merge', $create_backup = true) {
            if (!is_array($data)) {
                return new WP_Error('amaley_de_import_invalid', __('Import data is not a valid JSON object.', 'amaley-discovery-engine'));
            }

            $mode = ('replace' === $mode) ? 'replace' : 'merge';
            $current_settings = ('replace' === $mode) ? self::defaults() : self::get();
            $current_presets  = ('replace' === $mode) ? array() : self::get_presets();

            $settings_to_import = array();
            $presets_to_import = array();

            if (isset($data['settings']) && is_array($data['settings'])) {
                $settings_to_import = $data['settings'];
            } else {
                // Backward compatibility: v1.0.2 exported settings directly without package wrapper.
                $possible_setting_keys = array_intersect(array_keys(self::defaults()), array_keys($data));
                if (!empty($possible_setting_keys)) {
                    $settings_to_import = $data;
                }
            }

            if (isset($data['presets']) && is_array($data['presets'])) {
                $presets_to_import = $data['presets'];
            }
            if (isset($data['widget_presets']) && is_array($data['widget_presets'])) {
                $presets_to_import = array_replace_recursive($presets_to_import, $data['widget_presets']);
            }
            if (isset($data['filter_presets']) && is_array($data['filter_presets'])) {
                $presets_to_import = array_replace_recursive($presets_to_import, $data['filter_presets']);
            }
            if (isset($data['style_presets']) && is_array($data['style_presets'])) {
                $presets_to_import = array_replace_recursive($presets_to_import, $data['style_presets']);
            }

            if (empty($settings_to_import) && empty($presets_to_import)) {
                return new WP_Error('amaley_de_import_empty', __('No supported settings or presets were found in this JSON.', 'amaley-discovery-engine'));
            }

            if (!empty($settings_to_import) && isset($settings_to_import['runtime_css'])) {
                $runtime_css_check = self::validate_runtime_css_scope($settings_to_import['runtime_css']);
                if (is_wp_error($runtime_css_check)) {
                    return $runtime_css_check;
                }
            }

            if ($create_backup) {
                self::create_backup('before_import_' . $mode);
            }

            if (!empty($settings_to_import)) {
                self::save(wp_parse_args($settings_to_import, $current_settings));
            }

            if (!empty($presets_to_import)) {
                self::save_presets(array_replace_recursive($current_presets, self::sanitize_presets($presets_to_import)));
            }

            return true;
        }

        /**
         * Register optional CPTs/taxonomies for a fresh WordPress install.
         * Existing JetEngine/custom post types are not overridden.
         *
         * @return void
         */
        public static function register_optional_content_types() {
            // v1.3.5: CPT registration is intentionally disabled.
            // Reason: Amaley now keeps Clusters / SHG Groups / SHG Members in
            // CPT UI + ACF. The Discovery Engine should only provide Elementor
            // widgets, filters, rendering, styling, import/export and AJAX.
            // Keeping this method as a no-op preserves backward compatibility
            // for any external call while preventing duplicate admin menus.
            return;
        }

        // v1.3.5: The old CPT/taxonomy helper methods were removed from the
        // active registration flow to avoid accidental duplicate content types.

        /**
         * Add admin menu.
         *
         * @return void
         */
        public function add_admin_menu() {
            add_menu_page(
                'Amaley Discovery Engine',
                'Amaley Discovery',
                'manage_options',
                'amaley-discovery-engine',
                array($this, 'render_admin_page'),
                'dashicons-filter',
                58
            );
        }

        /**
         * Handle admin save/import/export requests.
         *
         * @return void
         */
        public function maybe_handle_admin_save() {
            if (!is_admin() || !current_user_can('manage_options')) {
                return;
            }

            if (empty($_POST['amaley_de_action'])) {
                return;
            }

            check_admin_referer('amaley_de_save_settings', 'amaley_de_nonce');

            $action = sanitize_text_field(wp_unslash($_POST['amaley_de_action']));

            if ('download_export' === $action) {
                $filename = 'amaley-discovery-engine-export-' . gmdate('Y-m-d-H-i-s') . '.json';
                nocache_headers();
                header('Content-Type: application/json; charset=utf-8');
                header('Content-Disposition: attachment; filename=' . $filename);
                echo wp_json_encode(self::export_package(), JSON_PRETTY_PRINT); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                exit;
            }

            if ('save_settings' === $action) {
                $settings = isset($_POST['amaley_de_settings']) ? wp_unslash($_POST['amaley_de_settings']) : array();
                if (is_array($settings)) {
                    if (isset($settings['runtime_css'])) {
                        $runtime_css_check = self::validate_runtime_css_scope($settings['runtime_css']);
                        if (is_wp_error($runtime_css_check)) {
                            add_settings_error('amaley_de_messages', 'amaley_de_runtime_css_error', $runtime_css_check->get_error_message(), 'error');
                            return;
                        }
                    }
                    self::create_backup('before_manual_save');
                    self::save($settings);
                    add_settings_error('amaley_de_messages', 'amaley_de_saved', 'Settings saved. A rollback backup was created first.', 'updated');
                }
            }

            if ('restore_backup' === $action) {
                $backup_index = isset($_POST['amaley_de_backup_index']) ? absint($_POST['amaley_de_backup_index']) : 0;
                $result = self::restore_backup($backup_index);
                if (is_wp_error($result)) {
                    add_settings_error('amaley_de_messages', 'amaley_de_restore_error', $result->get_error_message(), 'error');
                } else {
                    add_settings_error('amaley_de_messages', 'amaley_de_restored', 'Rollback completed. Previous settings were backed up before restore.', 'updated');
                }
            }

            if ('import_settings' === $action) {
                $json = isset($_POST['amaley_de_import_json']) ? trim(wp_unslash($_POST['amaley_de_import_json'])) : '';

                if (empty($json) && !empty($_FILES['amaley_de_import_file']['tmp_name'])) {
                    $file = $_FILES['amaley_de_import_file'];
                    $ext = strtolower(pathinfo(isset($file['name']) ? $file['name'] : '', PATHINFO_EXTENSION));
                    if ('json' === $ext && !empty($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
                        $json = file_get_contents($file['tmp_name']); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
                    }
                }

                $data = json_decode($json, true);
                $mode = isset($_POST['amaley_de_import_mode']) ? sanitize_text_field(wp_unslash($_POST['amaley_de_import_mode'])) : 'merge';
                $result = self::import_package($data, $mode);

                if (is_wp_error($result)) {
                    add_settings_error('amaley_de_messages', 'amaley_de_import_error', $result->get_error_message(), 'error');
                } else {
                    add_settings_error('amaley_de_messages', 'amaley_de_imported', 'Import completed. Settings/presets are now available without changing plugin files.', 'updated');
                }
            }
        }

        /**
         * Render admin settings page.
         *
         * @return void
         */
        public function render_admin_page() {
            if (!current_user_can('manage_options')) {
                return;
            }

            $settings = self::get();
            $presets = self::get_presets();
            $export_package = wp_json_encode(self::export_package(), JSON_PRETTY_PRINT);
            ?>
            <div class="wrap amaley-de-admin-wrap">
                <h1>Amaley Discovery Engine</h1>
                <p><strong>By Praveen.</strong> Core discovery engine for products and existing mapped content types. CPT registration is disabled to avoid duplicate Amaley menus.</p>
                <p><strong>Compatibility Lock:</strong> scoped CSS/JS, Elementor-native widgets, WooCommerce-safe queries, AJAX + URL fallback, pagination, mobile drawer, import/export presets, and fully responsive desktop/tablet/mobile layout.</p>
                <?php settings_errors('amaley_de_messages'); ?>

                <div class="amaley-de-admin-grid">
                    <form method="post" class="amaley-de-admin-card">
                        <?php wp_nonce_field('amaley_de_save_settings', 'amaley_de_nonce'); ?>
                        <input type="hidden" name="amaley_de_action" value="save_settings">

                        <h2>General & Mapping Settings</h2>
                        <p>Use existing CPT UI/ACF post types. This plugin no longer registers default Collections, Clusters, SHGs or Members CPTs.</p>

                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row">Register default CPTs</th>
                                <td>
                                    <input type="hidden" name="amaley_de_settings[register_cpts]" value="no">
                                    <strong>Disabled in v1.3.5.</strong><br>
                                    <span class="description">Amaley Clusters / SHG Groups / SHG Members are managed through CPT UI + ACF. The Discovery Engine will not create duplicate CPT menus.</span>
                                </td>
                            </tr>
                            <?php
                            $fields = array(
                                'collection_post_type'  => 'Collection Post Type',
                                'cluster_post_type'     => 'Cluster Post Type',
                                'shg_post_type'         => 'SHG Post Type',
                                'member_post_type'      => 'Member Post Type',
                                'collection_taxonomy'   => 'Collection Taxonomy',
                                'cluster_taxonomy'      => 'Cluster Taxonomy',
                                'shg_taxonomy'          => 'SHG Taxonomy',
                                'member_taxonomy'       => 'Member Taxonomy',
                                'relation_cluster_meta' => 'Cluster Relation Meta Key',
                                'relation_shg_meta'     => 'SHG Relation Meta Key',
                                'relation_member_meta'  => 'Member Relation Meta Key',
                            );
                            foreach ($fields as $key => $label) :
                                ?>
                                <tr>
                                    <th scope="row"><label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label></th>
                                    <td><input class="regular-text" id="<?php echo esc_attr($key); ?>" name="amaley_de_settings[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($settings[$key]); ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                        <h2>Default Amaley Design Tokens</h2>
                        <table class="form-table" role="presentation">
                            <?php
                            $colors = array(
                                'primary_color' => 'Chocolate',
                                'gold_color'    => 'Gold',
                                'rust_color'    => 'Rust',
                                'ivory_color'   => 'Ivory',
                                'cream_color'   => 'Cream',
                            );
                            foreach ($colors as $key => $label) :
                                ?>
                                <tr>
                                    <th scope="row"><label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label></th>
                                    <td><input type="text" class="regular-text" id="<?php echo esc_attr($key); ?>" name="amaley_de_settings[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($settings[$key]); ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th scope="row">Heading Font</th>
                                <td><input class="regular-text" name="amaley_de_settings[heading_font]" value="<?php echo esc_attr($settings['heading_font']); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">Body Font</th>
                                <td><input class="regular-text" name="amaley_de_settings[body_font]" value="<?php echo esc_attr($settings['body_font']); ?>"></td>
                            </tr>
                        </table>

                        <h2>Runtime Styling & Patch Layer</h2>
                        <p>This layer is for future safe CSS/style fixes imported by JSON. Use it for layout/card/filter polish without changing plugin core files.</p>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row">Enable Runtime CSS</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="amaley_de_settings[runtime_css_enabled]" value="yes" <?php checked($settings['runtime_css_enabled'], 'yes'); ?>>
                                        Load imported runtime CSS after the plugin stylesheet.
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="runtime_css">Runtime CSS</label></th>
                                <td>
                                    <textarea id="runtime_css" class="large-text code" rows="10" name="amaley_de_settings[runtime_css]" placeholder="Example: .amaley-discovery-engine-v1.my-page-class { --ade-grid-gap: 30px; }"><?php echo esc_textarea($settings['runtime_css']); ?></textarea>
                                    <p class="description">Keep CSS scoped to <code>.amaley-discovery-engine-v1</code> or a custom wrapper class. This is exported/imported with presets.</p>
                                </td>
                            </tr>
                        </table>

                        <p><button type="submit" class="button button-primary">Save Settings</button></p>
                    </form>

                    <div class="amaley-de-admin-card">
                        <h2>Import / Export Settings & Presets</h2>
                        <p>This is the safe system for future changes: import settings, CPT mappings, filter presets, style presets and scoped runtime CSS patches without replacing plugin core files.</p>

                        <h3>Export Full Package</h3>
                        <p>Copy this JSON or download it as a backup before major changes.</p>
                        <textarea readonly rows="14" class="large-text code"><?php echo esc_textarea($export_package); ?></textarea>
                        <form method="post" style="margin-top:12px;">
                            <?php wp_nonce_field('amaley_de_save_settings', 'amaley_de_nonce'); ?>
                            <input type="hidden" name="amaley_de_action" value="download_export">
                            <button type="submit" class="button button-secondary">Download Export JSON</button>
                        </form>

                        <h3>Import JSON Package</h3>
                        <form method="post" enctype="multipart/form-data">
                            <?php wp_nonce_field('amaley_de_save_settings', 'amaley_de_nonce'); ?>
                            <input type="hidden" name="amaley_de_action" value="import_settings">
                            <p>
                                <label><input type="radio" name="amaley_de_import_mode" value="merge" checked> Merge with current settings</label><br>
                                <label><input type="radio" name="amaley_de_import_mode" value="replace"> Replace settings/presets with import</label>
                            </p>
                            <p><input type="file" name="amaley_de_import_file" accept="application/json,.json"></p>
                            <textarea name="amaley_de_import_json" rows="10" class="large-text code" placeholder="Or paste preset JSON here"></textarea>
                            <p><button type="submit" class="button button-primary">Import Settings / Presets</button></p>
                        </form>

                        <p class="description"><strong>Safety:</strong> Every import creates an automatic rollback backup first. Runtime CSS is blocked unless every selector is scoped to <code>.amaley-discovery-engine-v1</code> or <code>.amaley-de-</code>.</p>

                        <h3>Rollback Backups</h3>
                        <p>If an imported preset/patch creates an unexpected layout issue, restore a previous backup. The latest 8 backups are kept automatically.</p>
                        <?php $backups = self::get_backups(); ?>
                        <?php if (empty($backups)) : ?>
                            <p><em>No rollback backups yet. A backup is created before every import or manual settings save.</em></p>
                        <?php else : ?>
                            <form method="post" style="margin-bottom:18px;">
                                <?php wp_nonce_field('amaley_de_save_settings', 'amaley_de_nonce'); ?>
                                <input type="hidden" name="amaley_de_action" value="restore_backup">
                                <select name="amaley_de_backup_index">
                                    <?php foreach ($backups as $index => $backup) : ?>
                                        <option value="<?php echo esc_attr($index); ?>"><?php echo esc_html(($backup['created_at'] ?? '') . ' — ' . ($backup['reason'] ?? 'backup')); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="button button-secondary">Restore Selected Backup</button>
                            </form>
                        <?php endif; ?>

                        <h3>Available Presets</h3>
                        <p>Imported presets can be selected inside Elementor widget settings under <strong>Query & Filters → Use Imported Preset</strong>.</p>
                        <ul class="amaley-de-preset-list">
                            <?php foreach ($presets as $key => $preset) : ?>
                                <li><code><?php echo esc_html($key); ?></code> — <?php echo esc_html(isset($preset['label']) ? $preset['label'] : $key); ?> <em>(<?php echo esc_html(isset($preset['type']) ? $preset['type'] : ''); ?>)</em></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
