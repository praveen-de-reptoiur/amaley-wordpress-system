<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Templates_Admin {

    private static $instance = null;
    private $notice = '';
    private $notice_type = 'updated';

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
        add_action( 'admin_init', array( $this, 'handle_actions' ) );
        add_action( 'admin_post_amaley_tpl_export', array( $this, 'download_export' ) );
    }

    public function register_admin_page() {
        add_menu_page(
            'Amaley Templates',
            'Amaley Templates',
            'manage_options',
            'amaley-templates',
            array( $this, 'render_admin_page' ),
            'dashicons-layout',
            58
        );
    }

    public function handle_actions() {
        if ( empty( $_POST['amaley_tpl_action'] ) || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $action = sanitize_key( wp_unslash( $_POST['amaley_tpl_action'] ) );
        check_admin_referer( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' );

        if ( 'save_settings' === $action ) {
            $this->save_settings();
        } elseif ( 'import_settings' === $action ) {
            $this->import_settings();
        } elseif ( 'rollback' === $action ) {
            $this->rollback_settings();
        } elseif ( 'create_backup' === $action ) {
            Amaley_Templates_Settings::create_backup( 'manual_admin_backup' );
            $this->redirect_with_message( 'Manual backup created safely.', 'updated' );
        }
    }

    private function save_settings() {
        $settings = Amaley_Templates_Settings::get_settings();
        $module   = isset( $_POST['amaley_tpl_module'] ) ? sanitize_key( wp_unslash( $_POST['amaley_tpl_module'] ) ) : 'global';
        $posted   = isset( $_POST['amaley_tpl_settings'] ) && is_array( $_POST['amaley_tpl_settings'] ) ? wp_unslash( $_POST['amaley_tpl_settings'] ) : array();

        if ( ! isset( $settings[ $module ] ) || ! is_array( $posted ) ) {
            $this->redirect_with_message( 'Settings could not be saved because the module was not recognised.', 'error' );
        }

        $settings[ $module ] = Amaley_Templates_Settings::sanitize_settings( $posted );
        Amaley_Templates_Settings::update_settings( $settings );
        Amaley_Templates_Settings::log_event( 'Settings saved for module: ' . $module, 'save' );
        $this->redirect_with_message( 'Settings saved for ' . ucwords( str_replace( '_', ' ', $module ) ) . '.', 'updated' );
    }

    private function import_settings() {
        $json = '';
        if ( ! empty( $_FILES['amaley_tpl_import_file']['tmp_name'] ) ) {
            $file = $_FILES['amaley_tpl_import_file'];
            if ( isset( $file['error'] ) && UPLOAD_ERR_OK === (int) $file['error'] ) {
                $json = file_get_contents( $file['tmp_name'] );
            }
        }

        if ( '' === $json && ! empty( $_POST['amaley_tpl_import_json'] ) ) {
            $json = wp_unslash( $_POST['amaley_tpl_import_json'] );
        }

        $mode  = isset( $_POST['amaley_tpl_import_mode'] ) ? sanitize_key( wp_unslash( $_POST['amaley_tpl_import_mode'] ) ) : 'merge';
        $scope = isset( $_POST['amaley_tpl_import_scope'] ) ? sanitize_key( wp_unslash( $_POST['amaley_tpl_import_scope'] ) ) : 'full';

        $package = json_decode( $json, true );
        if ( ! is_array( $package ) ) {
            $this->redirect_with_message( 'Import failed: JSON could not be read.', 'error' );
        }

        $result = Amaley_Templates_Settings::import_package( $package, $mode, $scope );
        if ( is_wp_error( $result ) ) {
            $this->redirect_with_message( 'Import failed: ' . $result->get_error_message(), 'error' );
        }

        $this->redirect_with_message( 'Import completed. A rollback backup was created before import.', 'updated' );
    }

    private function rollback_settings() {
        $index  = isset( $_POST['amaley_tpl_backup_index'] ) ? absint( $_POST['amaley_tpl_backup_index'] ) : 0;
        $result = Amaley_Templates_Settings::rollback( $index );

        if ( is_wp_error( $result ) ) {
            $this->redirect_with_message( 'Rollback failed: ' . $result->get_error_message(), 'error' );
        }

        $this->redirect_with_message( 'Rollback completed. A backup was created before rollback.', 'updated' );
    }

    private function redirect_with_message( $message, $type = 'updated' ) {
        $url = add_query_arg(
            array(
                'page'              => 'amaley-templates',
                'amaley_tpl_notice' => rawurlencode( $message ),
                'amaley_tpl_type'   => sanitize_key( $type ),
            ),
            admin_url( 'admin.php' )
        );
        wp_safe_redirect( $url );
        exit;
    }

    public function download_export() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Unauthorized.' );
        }

        check_admin_referer( 'amaley_tpl_export_action', 'amaley_tpl_export_nonce' );
        $scope   = isset( $_GET['scope'] ) ? sanitize_key( wp_unslash( $_GET['scope'] ) ) : 'full';
        $package = Amaley_Templates_Settings::make_package( $scope );
        $name    = 'amaley-templates-export-' . $scope . '-' . gmdate( 'Y-m-d-H-i-s' ) . '.json';

        header( 'Content-Type: application/json; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=' . $name );
        echo wp_json_encode( $package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
        exit;
    }

    private function tabs() {
        return array(
            'overview'       => 'Dashboard',
            'single_product' => 'Single Product Template',
            'shop_page'      => 'Shop Page Template',
            'quick_view'     => 'Quick View / Popup',
            'global'         => 'Global Design Tokens',
            'import_export'  => 'Import / Export',
            'debug'          => 'Debug / Health',
            'changelog'      => 'Changelog / Notes',
        );
    }

    public function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $active = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'overview';
        $tabs   = $this->tabs();
        if ( ! isset( $tabs[ $active ] ) ) {
            $active = 'overview';
        }

        if ( ! empty( $_GET['amaley_tpl_notice'] ) ) {
            $message = sanitize_text_field( wp_unslash( $_GET['amaley_tpl_notice'] ) );
            $type    = ! empty( $_GET['amaley_tpl_type'] ) ? sanitize_key( wp_unslash( $_GET['amaley_tpl_type'] ) ) : 'updated';
            echo '<div class="notice ' . ( 'error' === $type ? 'notice-error' : 'notice-success' ) . ' is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
        }

        ?>
        <div class="wrap amaley-tpl-admin">
            <h1>Amaley Templates</h1>
            <p><strong>Version:</strong> <?php echo esc_html( AMALEY_TPL_VERSION ); ?> &nbsp; <strong>Author:</strong> Praveen</p>
            <p>Elementor-native Amaley template widgets. WooCommerce remains the source for products, price, variations, stock, cart, checkout and reviews.</p>

            <style>
                .amaley-tpl-admin .nav-tab-wrapper{margin-top:18px;}
                .amaley-tpl-admin-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:20px;margin-top:18px;max-width:1160px;box-shadow:0 1px 2px rgba(0,0,0,.04);}
                .amaley-tpl-admin-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;max-width:1160px;}
                .amaley-tpl-admin-grid .amaley-tpl-admin-card{margin-top:18px;}
                .amaley-tpl-admin-table{width:100%;border-collapse:collapse;}
                .amaley-tpl-admin-table th{text-align:left;width:260px;vertical-align:top;padding:12px;border-bottom:1px solid #eee;}
                .amaley-tpl-admin-table td{padding:12px;border-bottom:1px solid #eee;}
                .amaley-tpl-admin input[type=text], .amaley-tpl-admin textarea, .amaley-tpl-admin select{width:100%;max-width:680px;}
                .amaley-tpl-status{display:inline-block;border-radius:999px;padding:3px 9px;font-size:12px;font-weight:700;}
                .amaley-tpl-status.ok{background:#e7f7ed;color:#126b32;}.amaley-tpl-status.warning{background:#fff7e2;color:#996800;}.amaley-tpl-status.error{background:#fde8e8;color:#b42318;}.amaley-tpl-status.info{background:#eaf2ff;color:#155eef;}
                .amaley-tpl-codebox{width:100%;min-height:240px;font-family:monospace;font-size:12px;}
                .amaley-tpl-small{color:#666;font-size:12px;line-height:1.6;}
                @media(max-width:960px){.amaley-tpl-admin-grid{grid-template-columns:1fr}.amaley-tpl-admin-table th{width:auto;display:block;border-bottom:none;padding-bottom:4px}.amaley-tpl-admin-table td{display:block;padding-top:0}}
            </style>

            <h2 class="nav-tab-wrapper">
                <?php foreach ( $tabs as $key => $label ) : ?>
                    <a class="nav-tab <?php echo $active === $key ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'page' => 'amaley-templates', 'tab' => $key ), admin_url( 'admin.php' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
                <?php endforeach; ?>
            </h2>

            <?php
            if ( 'overview' === $active ) {
                $this->render_overview();
            } elseif ( 'single_product' === $active ) {
                $this->render_single_product();
            } elseif ( 'shop_page' === $active ) {
                $this->render_shop_page();
            } elseif ( 'quick_view' === $active ) {
                $this->render_planned_module( 'quick_view', 'Quick View / Popup', 'Future product popup and quick-view controls will live here. This will not replace WooCommerce cart/checkout.' );
            } elseif ( 'global' === $active ) {
                $this->render_global();
            } elseif ( 'import_export' === $active ) {
                $this->render_import_export();
            } elseif ( 'debug' === $active ) {
                $this->render_debug();
            } elseif ( 'changelog' === $active ) {
                $this->render_changelog();
            }
            ?>
        </div>
        <?php
    }

    private function render_overview() {
        $settings = Amaley_Templates_Settings::get_settings();
        $checks   = Amaley_Templates_Settings::health_checks();
        ?>
        <div class="amaley-tpl-admin-grid">
            <div class="amaley-tpl-admin-card">
                <h2>Module Structure</h2>
                <ul style="list-style:disc;padding-left:22px;line-height:1.9;">
                    <li><strong>Single Product Template:</strong> active controls + Elementor widgets.</li>
                    <li><strong>Shop Page Template:</strong> reserved separate module for future shop/card/pagination controls.</li>
                    <li><strong>Quick View / Popup:</strong> reserved separate module for future popup controls.</li>
                    <li><strong>Global Design Tokens:</strong> shared colors/fonts/compact mode.</li>
                    <li><strong>Import / Export:</strong> full or module-specific JSON packages with backup before import.</li>
                    <li><strong>Debug / Health:</strong> compatibility checks and event log.</li>
                </ul>
            </div>
            <div class="amaley-tpl-admin-card">
                <h2>Health Snapshot</h2>
                <table class="widefat striped">
                    <tbody>
                    <?php foreach ( $checks as $check ) : ?>
                        <tr><td><span class="amaley-tpl-status <?php echo esc_attr( $check['status'] ); ?>"><?php echo esc_html( strtoupper( $check['status'] ) ); ?></span></td><td><strong><?php echo esc_html( $check['label'] ); ?></strong><br><span class="amaley-tpl-small"><?php echo esc_html( $check['detail'] ); ?></span></td></tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="amaley-tpl-admin-card">
            <h2>Safety Locks</h2>
            <p>No WooCommerce replacement. No cart/checkout replacement. No WooCommerce template override. No CPT registration. No Freshen/Apus global override. No conflict with Amaley Discovery Engine. Elementor widgets use the <code>amaley_tpl_</code> PHP prefix and <code>.amaley-tpl-</code> CSS prefix.</p>
            <p><strong>Current preset:</strong> <?php echo esc_html( $settings['single_product']['preset'] ); ?></p>
        </div>
        <?php
    }

    private function render_single_product() {
        $s = Amaley_Templates_Settings::get_settings();
        $v = $s['single_product'];
        ?>
        <form method="post" class="amaley-tpl-admin-card">
            <?php wp_nonce_field( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' ); ?>
            <input type="hidden" name="amaley_tpl_action" value="save_settings">
            <input type="hidden" name="amaley_tpl_module" value="single_product">
            <h2>Single Product Template Controls</h2>
            <p class="amaley-tpl-small">These defaults are used by Amaley product widgets. Individual Elementor widget controls can still override many labels/settings for special cases.</p>
            <table class="amaley-tpl-admin-table">
                <?php $this->field_select( 'Module Enabled', 'module_enabled', $v['module_enabled'], array( 'yes' => 'Yes', 'no' => 'No' ), 'single_product' ); ?>
                <?php $this->field_text( 'Preset Name', 'preset', $v['preset'], 'single_product' ); ?>
                <?php $this->field_select( 'Hero Layout', 'hero_layout', $v['hero_layout'], array( 'compact_two_column' => 'Compact Two Column', 'story_split' => 'Story Split (future)', 'minimal' => 'Minimal (future)' ), 'single_product' ); ?>
                <?php $this->field_select( 'Buy Now Enabled', 'buy_now_enabled', $v['buy_now_enabled'], array( 'yes' => 'Yes', 'no' => 'No' ), 'single_product' ); ?>
                <?php $this->field_text( 'Buy Now Text', 'buy_now_text', $v['buy_now_text'], 'single_product' ); ?>
                <?php $this->field_select( 'Wishlist Area Enabled', 'wishlist_enabled', $v['wishlist_enabled'], array( 'yes' => 'Yes', 'no' => 'No' ), 'single_product' ); ?>
                <?php $this->field_text( 'Wishlist Text/Icon', 'wishlist_text', $v['wishlist_text'], 'single_product' ); ?>
                <?php $this->field_text( 'Details Tab Label', 'details_label', $v['details_label'], 'single_product' ); ?>
                <?php $this->field_text( 'Origin Tab Label', 'origin_label', $v['origin_label'], 'single_product' ); ?>
                <?php $this->field_text( 'How to Use Tab Label', 'how_to_use_label', $v['how_to_use_label'], 'single_product' ); ?>
                <?php $this->field_text( 'Reviews Tab Label', 'reviews_label', $v['reviews_label'], 'single_product' ); ?>
                <?php $this->field_textarea( 'Trust Strip Items', 'trust_items', $v['trust_items'], 'single_product', 'One item per line: Title|Text' ); ?>
            </table>

            <h3>ACF / Meta Field Names</h3>
            <table class="amaley-tpl-admin-table">
                <?php
                $fields = array( 'origin_short_line', 'linked_cluster', 'linked_shg_group', 'linked_producer_maker', 'village_source_location', 'region_source_belt', 'batch_type', 'harvest_collection_season', 'processing_method', 'traceability_note', 'ingredients_note', 'how_to_use', 'storage_instructions', 'shelf_life', 'allergen_note', 'producer_quote_maker_note' );
                foreach ( $fields as $field ) {
                    $this->field_text( ucwords( str_replace( '_', ' ', $field ) ), $field, isset( $v[ $field ] ) ? $v[ $field ] : $field, 'single_product' );
                }
                ?>
            </table>
            <?php submit_button( 'Save Single Product Settings' ); ?>
        </form>
        <?php
    }


    private function render_shop_page() {
        $s = Amaley_Templates_Settings::get_settings();
        $v = isset( $s['shop_page'] ) ? $s['shop_page'] : array();
        ?>
        <form method="post" class="amaley-tpl-admin-card">
            <?php wp_nonce_field( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' ); ?>
            <input type="hidden" name="amaley_tpl_action" value="save_settings">
            <input type="hidden" name="amaley_tpl_module" value="shop_page">
            <h2>Shop Page Template Controls</h2>
            <p class="amaley-tpl-small">This module stays separate from Single Product. It uses Amaley Discovery Engine for filters/query/pagination and can render your existing Elementor Product Card Loop by Template ID.</p>

            <h3>Hero / Intro</h3>
            <table class="amaley-tpl-admin-table">
                <?php $this->field_select( 'Module Enabled', 'module_enabled', isset( $v['module_enabled'] ) ? $v['module_enabled'] : 'yes', array( 'yes' => 'Yes', 'no' => 'No' ), 'shop_page' ); ?>
                <?php $this->field_text( 'Preset Name', 'preset', isset( $v['preset'] ) ? $v['preset'] : 'shop_page_og_filter_v1', 'shop_page' ); ?>
                <?php $this->field_text( 'Hero Kicker', 'hero_kicker', isset( $v['hero_kicker'] ) ? $v['hero_kicker'] : 'Shop Amaley', 'shop_page' ); ?>
                <?php $this->field_text( 'Hero Title', 'hero_title', isset( $v['hero_title'] ) ? $v['hero_title'] : 'Himalayan Pantry', 'shop_page' ); ?>
                <?php $this->field_text( 'Hero Accent', 'hero_accent', isset( $v['hero_accent'] ) ? $v['hero_accent'] : 'Collections', 'shop_page' ); ?>
                <?php $this->field_textarea( 'Hero Text', 'hero_text', isset( $v['hero_text'] ) ? $v['hero_text'] : '', 'shop_page' ); ?>
                <?php $this->field_textarea( 'Hero Pills', 'hero_pills', isset( $v['hero_pills'] ) ? $v['hero_pills'] : 'Small Batch|Traceable Origin|Natural Himalayan Foods', 'shop_page', 'Use | between items.' ); ?>
            </table>

            <h3>Discovery / Filters</h3>
            <table class="amaley-tpl-admin-table">
                <?php $this->field_text( 'Discovery Heading', 'discovery_heading', isset( $v['discovery_heading'] ) ? $v['discovery_heading'] : 'Shop Amaley', 'shop_page' ); ?>
                <?php $this->field_text( 'Discovery Kicker', 'discovery_kicker', isset( $v['discovery_kicker'] ) ? $v['discovery_kicker'] : 'Filter by origin, ingredient and use', 'shop_page' ); ?>
                <?php $this->field_text( 'Products Per Page', 'per_page', isset( $v['per_page'] ) ? $v['per_page'] : '12', 'shop_page' ); ?>
                <?php $this->field_select( 'Desktop Columns', 'columns_desktop', isset( $v['columns_desktop'] ) ? $v['columns_desktop'] : '3', array( '2' => '2', '3' => '3', '4' => '4' ), 'shop_page' ); ?>
                <?php $this->field_select( 'Tablet Columns', 'columns_tablet', isset( $v['columns_tablet'] ) ? $v['columns_tablet'] : '2', array( '1' => '1', '2' => '2', '3' => '3' ), 'shop_page' ); ?>
                <?php $this->field_select( 'Mobile Columns', 'columns_mobile', isset( $v['columns_mobile'] ) ? $v['columns_mobile'] : '1', array( '1' => '1', '2' => '2' ), 'shop_page' ); ?>
                <?php $this->field_select( 'Desktop Filter Behaviour', 'desktop_filter_mode', isset( $v['desktop_filter_mode'] ) ? $v['desktop_filter_mode'] : 'visible', array( 'visible' => 'Visible', 'compact' => 'Compact Inline', 'drawer' => 'Drawer', 'hidden' => 'Hidden' ), 'shop_page' ); ?>
                <?php $this->field_select( 'Tablet Filter Behaviour', 'tablet_filter_mode', isset( $v['tablet_filter_mode'] ) ? $v['tablet_filter_mode'] : 'compact', array( 'visible' => 'Visible', 'compact' => 'Compact Inline', 'drawer' => 'Drawer', 'hidden' => 'Hidden' ), 'shop_page' ); ?>
                <?php $this->field_select( 'Phone Filter Behaviour', 'mobile_filter_mode', isset( $v['mobile_filter_mode'] ) ? $v['mobile_filter_mode'] : 'compact', array( 'visible' => 'Visible', 'compact' => 'Compact Inline', 'drawer' => 'Drawer', 'hidden' => 'Hidden' ), 'shop_page' ); ?>
                <?php $this->field_select( 'Pagination', 'pagination_type', isset( $v['pagination_type'] ) ? $v['pagination_type'] : 'numbers', array( 'numbers' => 'Numbers', 'none' => 'None' ), 'shop_page' ); ?>
            </table>

            <h3>Filter Visibility</h3>
            <table class="amaley-tpl-admin-table">
                <?php
                $toggles = array(
                    'show_search' => 'Search', 'show_categories' => 'Categories', 'show_price' => 'Price', 'show_tags' => 'Tags', 'show_stock' => 'Stock', 'show_sort' => 'Sort', 'show_active_chips' => 'Active Filter Chips',
                    'show_attr_collection_type' => 'Collection Type Attribute', 'show_attr_core_ingredient' => 'Core Ingredient Attribute', 'show_attr_cluster' => 'Cluster Attribute', 'show_attr_producer_maker' => 'Producer / Maker Attribute', 'show_attr_region_cluster' => 'Region / Source Belt Attribute', 'show_attr_shg' => 'SHG Attribute', 'show_attr_use_case' => 'Use Case Attribute', 'show_attr_village_source_location' => 'Village / Source Location Attribute'
                );
                foreach ( $toggles as $key => $label ) {
                    $this->field_select( $label, $key, isset( $v[ $key ] ) ? $v[ $key ] : 'yes', array( 'yes' => 'Yes', 'no' => 'No' ), 'shop_page' );
                }
                ?>
            </table>

            <h3>Product Card Renderer</h3>
            <table class="amaley-tpl-admin-table">
                <?php $this->field_select( 'Card Renderer', 'card_renderer', isset( $v['card_renderer'] ) ? $v['card_renderer'] : 'elementor_template', array( 'elementor_template' => 'Existing Elementor Loop Item / Template', 'marketplace_card' => 'Discovery Native Marketplace Card', 'default' => 'Discovery Default Card' ), 'shop_page' ); ?>
                <?php $this->field_text( 'Elementor Product Card Template ID', 'elementor_template_id', isset( $v['elementor_template_id'] ) ? $v['elementor_template_id'] : '0', 'shop_page' ); ?>
                <?php $this->field_text( 'Custom Wrapper Class', 'custom_wrapper_class', isset( $v['custom_wrapper_class'] ) ? $v['custom_wrapper_class'] : 'amaley-tpl-shop-og', 'shop_page' ); ?>
                <?php $this->field_textarea( 'Notes', 'notes', isset( $v['notes'] ) ? $v['notes'] : '', 'shop_page' ); ?>
            </table>
            <?php submit_button( 'Save Shop Page Settings' ); ?>
        </form>
        <?php
    }

    private function render_planned_module( $module, $title, $description ) {
        $s = Amaley_Templates_Settings::get_settings();
        $v = isset( $s[ $module ] ) ? $s[ $module ] : array();
        ?>
        <form method="post" class="amaley-tpl-admin-card">
            <?php wp_nonce_field( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' ); ?>
            <input type="hidden" name="amaley_tpl_action" value="save_settings">
            <input type="hidden" name="amaley_tpl_module" value="<?php echo esc_attr( $module ); ?>">
            <h2><?php echo esc_html( $title ); ?></h2>
            <p><?php echo esc_html( $description ); ?></p>
            <table class="amaley-tpl-admin-table">
                <?php $this->field_select( 'Module Status', 'module_enabled', isset( $v['module_enabled'] ) ? $v['module_enabled'] : 'planned', array( 'planned' => 'Planned', 'yes' => 'Enabled', 'no' => 'Disabled' ), $module ); ?>
                <?php $this->field_textarea( 'Notes', 'notes', isset( $v['notes'] ) ? $v['notes'] : '', $module ); ?>
            </table>
            <?php submit_button( 'Save ' . $title . ' Notes' ); ?>
        </form>
        <?php
    }

    private function render_global() {
        $s = Amaley_Templates_Settings::get_settings();
        $v = $s['global'];
        ?>
        <form method="post" class="amaley-tpl-admin-card">
            <?php wp_nonce_field( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' ); ?>
            <input type="hidden" name="amaley_tpl_action" value="save_settings">
            <input type="hidden" name="amaley_tpl_module" value="global">
            <h2>Global Design Tokens</h2>
            <p class="amaley-tpl-small">Shared Amaley colors/fonts. These are defaults for future widgets and module presets.</p>
            <table class="amaley-tpl-admin-table">
                <?php $this->field_text( 'Chocolate / Primary', 'primary_color', $v['primary_color'], 'global' ); ?>
                <?php $this->field_text( 'Gold', 'gold_color', $v['gold_color'], 'global' ); ?>
                <?php $this->field_text( 'Rust', 'rust_color', $v['rust_color'], 'global' ); ?>
                <?php $this->field_text( 'Ivory', 'ivory_color', $v['ivory_color'], 'global' ); ?>
                <?php $this->field_text( 'Cream', 'cream_color', $v['cream_color'], 'global' ); ?>
                <?php $this->field_text( 'Heading Font', 'heading_font', $v['heading_font'], 'global' ); ?>
                <?php $this->field_text( 'Body Font', 'body_font', $v['body_font'], 'global' ); ?>
                <?php $this->field_text( 'Default Radius', 'radius', $v['radius'], 'global' ); ?>
                <?php $this->field_select( 'Compact Mode', 'compact_mode', $v['compact_mode'], array( 'yes' => 'Yes', 'no' => 'No' ), 'global' ); ?>
            </table>
            <?php submit_button( 'Save Global Tokens' ); ?>
        </form>
        <?php
    }

    private function render_import_export() {
        $full_export = Amaley_Templates_Settings::make_package( 'full' );
        $backups     = Amaley_Templates_Settings::get_backups();
        ?>
        <div class="amaley-tpl-admin-grid">
            <div class="amaley-tpl-admin-card">
                <h2>Export Settings / Presets</h2>
                <p class="amaley-tpl-small">Export before every major change. You can export full settings or one module only.</p>
                <p>
                    <?php foreach ( array( 'full' => 'Full Package', 'global' => 'Global Tokens', 'single_product' => 'Single Product', 'shop_page' => 'Shop Page', 'quick_view' => 'Quick View' ) as $scope => $label ) : ?>
                        <a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=amaley_tpl_export&scope=' . $scope ), 'amaley_tpl_export_action', 'amaley_tpl_export_nonce' ) ); ?>"><?php echo esc_html( 'Download ' . $label ); ?></a>
                    <?php endforeach; ?>
                </p>
                <textarea readonly class="amaley-tpl-codebox"><?php echo esc_textarea( wp_json_encode( $full_export, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) ); ?></textarea>
            </div>
            <div class="amaley-tpl-admin-card">
                <h2>Import Settings / Presets</h2>
                <p class="amaley-tpl-small">A rollback backup is created automatically before every import.</p>
                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' ); ?>
                    <input type="hidden" name="amaley_tpl_action" value="import_settings">
                    <p><label><strong>Import Mode</strong></label><br>
                    <select name="amaley_tpl_import_mode"><option value="merge">Merge with current settings</option><option value="replace">Replace selected scope</option></select></p>
                    <p><label><strong>Import Scope</strong></label><br>
                    <select name="amaley_tpl_import_scope"><option value="full">Full</option><option value="global">Global Tokens</option><option value="single_product">Single Product</option><option value="shop_page">Shop Page</option><option value="quick_view">Quick View</option></select></p>
                    <p><label><strong>Upload JSON</strong></label><br><input type="file" name="amaley_tpl_import_file" accept="application/json,.json"></p>
                    <p><label><strong>Or Paste JSON</strong></label><br><textarea name="amaley_tpl_import_json" class="amaley-tpl-codebox" placeholder="Paste Amaley Templates JSON package here"></textarea></p>
                    <?php submit_button( 'Import Settings / Presets' ); ?>
                </form>
            </div>
        </div>
        <div class="amaley-tpl-admin-card">
            <h2>Rollback Backups</h2>
            <form method="post" style="margin-bottom:16px;">
                <?php wp_nonce_field( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' ); ?>
                <input type="hidden" name="amaley_tpl_action" value="create_backup">
                <?php submit_button( 'Create Manual Backup', 'secondary', 'submit', false ); ?>
            </form>
            <?php if ( empty( $backups ) ) : ?>
                <p>No backups yet. A backup will be created before import/rollback, or create one manually.</p>
            <?php else : ?>
                <form method="post">
                    <?php wp_nonce_field( 'amaley_tpl_admin_action', 'amaley_tpl_nonce' ); ?>
                    <input type="hidden" name="amaley_tpl_action" value="rollback">
                    <select name="amaley_tpl_backup_index">
                        <?php foreach ( $backups as $i => $backup ) : ?>
                            <option value="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $backup['created_at'] . ' — ' . $backup['reason'] ); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php submit_button( 'Restore Selected Backup', 'secondary', 'submit', false ); ?>
                </form>
            <?php endif; ?>
        </div>
        <?php
    }

    private function render_debug() {
        $env    = Amaley_Templates_Settings::environment_summary();
        $checks = Amaley_Templates_Settings::health_checks();
        $events = Amaley_Templates_Settings::get_events();
        ?>
        <div class="amaley-tpl-admin-grid">
            <div class="amaley-tpl-admin-card">
                <h2>Compatibility / Health Checks</h2>
                <table class="widefat striped">
                    <tbody>
                    <?php foreach ( $checks as $check ) : ?>
                        <tr><td><span class="amaley-tpl-status <?php echo esc_attr( $check['status'] ); ?>"><?php echo esc_html( strtoupper( $check['status'] ) ); ?></span></td><td><strong><?php echo esc_html( $check['label'] ); ?></strong><br><span class="amaley-tpl-small"><?php echo esc_html( $check['detail'] ); ?></span></td></tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="amaley-tpl-small">This panel cannot guarantee compatibility with every future WordPress/Elementor/PHP update, but it gives clear warnings when dependencies are missing or environment conditions look risky.</p>
            </div>
            <div class="amaley-tpl-admin-card">
                <h2>Debug Report</h2>
                <textarea readonly class="amaley-tpl-codebox"><?php echo esc_textarea( wp_json_encode( $env, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) ); ?></textarea>
            </div>
        </div>
        <div class="amaley-tpl-admin-card">
            <h2>Event Log</h2>
            <?php if ( empty( $events ) ) : ?>
                <p>No events recorded yet.</p>
            <?php else : ?>
                <table class="widefat striped"><thead><tr><th>Time</th><th>Type</th><th>Message</th></tr></thead><tbody>
                <?php foreach ( $events as $event ) : ?>
                    <tr><td><?php echo esc_html( $event['time'] ); ?></td><td><?php echo esc_html( $event['type'] ); ?></td><td><?php echo esc_html( $event['message'] ); ?></td></tr>
                <?php endforeach; ?>
                </tbody></table>
            <?php endif; ?>
        </div>
        <?php
    }

    private function render_changelog() {
        ?>
        <div class="amaley-tpl-admin-card">
            <h2>Changelog / Notes</h2>
            <h3>v1.2.3</h3>
            <ul>
                <li>Product Hero breadcrumb/card can now render above the hero grid by default.</li>
                <li>Added breadcrumb position, margin and min-height controls.</li>
                <li>Prevents oversized breadcrumb block inside the right product summary column.</li>
            </ul>
            <h3>v1.2.1</h3>
            <ul style="list-style:disc;padding-left:22px;line-height:1.8;">
                <li>Activated Shop Page Template module with separate admin controls.</li>
                <li>Added Amaley Templates Shop Hero widget for OG-style shop intro.</li>
                <li>Added Amaley Templates Shop Discovery widget that uses Amaley Discovery Engine for filters, query, sorting, pagination and optional Elementor Product Card Loop rendering.</li>
                <li>Maintained separation: Discovery Engine = filters/listings, Amaley Templates = template/layout layer.</li>
            </ul>
            <h3>v1.1.4 - v1.1.6</h3>
            <ul style="list-style:disc;padding-left:22px;line-height:1.8;">
                <li>Added section-wise Elementor Style controls for Product Hero: layout, image/gallery, breadcrumb/origin line, title/price/description, mini origin card, badges, buttons and meta line.</li>
                <li>Added section-wise Elementor Style controls for Product Info Tabs: tab navigation, panel/body, details table, origin header, origin cards/icons and story/quote.</li>
                <li>Added section-wise Elementor Style controls for Product Origin Panel and Product Trust Strip.</li>
                <li>Kept all selectors scoped to the <code>.amaley-tpl-</code> prefix with no WooCommerce/Freshen/Apus override.</li>
                <li>Maintained no CPT registration, no cart/checkout replacement, no Discovery Engine conflict.</li>
            </ul>
            <h3>v1.1.0 - v1.1.3</h3>
            <ul style="list-style:disc;padding-left:22px;line-height:1.8;">
                <li>Added section-wise admin structure, import/export, debug/health, product origin-in-tabs and origin card image/icon support.</li>
            </ul>
            <h3>v1.0.0</h3>
            <ul style="list-style:disc;padding-left:22px;line-height:1.8;">
                <li>Initial widgets: Product Hero, Product Origin Panel, Product Info Tabs and Product Trust Strip.</li>
            </ul>
        </div>
        <?php
    }

    private function field_text( $label, $key, $value, $module ) {
        ?>
        <tr><th><label for="<?php echo esc_attr( $module . '_' . $key ); ?>"><?php echo esc_html( $label ); ?></label></th><td><input id="<?php echo esc_attr( $module . '_' . $key ); ?>" type="text" name="amaley_tpl_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>"></td></tr>
        <?php
    }

    private function field_textarea( $label, $key, $value, $module, $help = '' ) {
        ?>
        <tr><th><label for="<?php echo esc_attr( $module . '_' . $key ); ?>"><?php echo esc_html( $label ); ?></label></th><td><textarea id="<?php echo esc_attr( $module . '_' . $key ); ?>" rows="5" name="amaley_tpl_settings[<?php echo esc_attr( $key ); ?>]"><?php echo esc_textarea( $value ); ?></textarea><?php if ( $help ) : ?><p class="amaley-tpl-small"><?php echo esc_html( $help ); ?></p><?php endif; ?></td></tr>
        <?php
    }

    private function field_select( $label, $key, $value, $options, $module ) {
        ?>
        <tr><th><label for="<?php echo esc_attr( $module . '_' . $key ); ?>"><?php echo esc_html( $label ); ?></label></th><td><select id="<?php echo esc_attr( $module . '_' . $key ); ?>" name="amaley_tpl_settings[<?php echo esc_attr( $key ); ?>]">
            <?php foreach ( $options as $option_value => $option_label ) : ?>
                <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $value, $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
            <?php endforeach; ?>
        </select></td></tr>
        <?php
    }
}
