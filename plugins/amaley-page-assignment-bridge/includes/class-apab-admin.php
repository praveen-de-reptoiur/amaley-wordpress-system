<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class APAB_Admin {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
        add_action( 'admin_init', array( $this, 'handle_actions' ) );
    }

    public function register_admin_page() {
        add_menu_page(
            'Amaley Bridge',
            'Amaley Bridge',
            'manage_options',
            'amaley-page-assignment-bridge',
            array( $this, 'render_admin_page' ),
            'dashicons-admin-links',
            59
        );
    }

    public function handle_actions() {
        if ( empty( $_POST['apab_action'] ) || ! current_user_can( 'manage_options' ) ) {
            return;
        }
        check_admin_referer( 'apab_admin_action', 'apab_nonce' );
        $action = sanitize_key( wp_unslash( $_POST['apab_action'] ) );

        if ( 'save_single_product' === $action ) {
            $settings = APAB_Settings::get_settings();
            $posted   = isset( $_POST['apab_single_product'] ) && is_array( $_POST['apab_single_product'] ) ? wp_unslash( $_POST['apab_single_product'] ) : array();
            $clean    = array();

            $clean['enabled']               = isset( $posted['enabled'] ) ? sanitize_key( $posted['enabled'] ) : 'off';
            $clean['assigned_page_id']      = isset( $posted['assigned_page_id'] ) ? absint( $posted['assigned_page_id'] ) : 0;
            $clean['test_product_id']       = isset( $posted['test_product_id'] ) ? absint( $posted['test_product_id'] ) : 0;
            $clean['preview_assigned_page'] = isset( $posted['preview_assigned_page'] ) ? sanitize_key( $posted['preview_assigned_page'] ) : 'yes';
            $clean['preview_product_id']    = isset( $posted['preview_product_id'] ) ? absint( $posted['preview_product_id'] ) : 0;
            $clean['notes']                 = isset( $posted['notes'] ) ? sanitize_textarea_field( $posted['notes'] ) : '';

            if ( ! in_array( $clean['enabled'], array( 'off', 'test', 'all' ), true ) ) {
                $clean['enabled'] = 'off';
            }
            if ( ! in_array( $clean['preview_assigned_page'], array( 'yes', 'no' ), true ) ) {
                $clean['preview_assigned_page'] = 'yes';
            }

            $settings['single_product'] = array_merge( $settings['single_product'], $clean );
            APAB_Settings::update_settings( $settings );
            wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-page-assignment-bridge', 'tab' => 'single_product', 'apab_notice' => rawurlencode( 'Single Product Bridge settings saved.' ) ), admin_url( 'admin.php' ) ) );
            exit;
        }
    }

    private function tabs() {
        return array(
            'single_product' => 'Single Product Assignment',
            'shop_page'      => 'Shop Page Assignment',
            'debug'          => 'Debug / Health',
        );
    }

    public function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $active = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'single_product';
        $tabs   = $this->tabs();
        if ( ! isset( $tabs[ $active ] ) ) {
            $active = 'single_product';
        }
        ?>
        <div class="wrap apab-admin">
            <h1>Amaley Page Assignment Bridge</h1>
            <?php if ( ! empty( $_GET['apab_notice'] ) ) : ?>
                <div class="notice notice-success is-dismissible"><p><?php echo esc_html( sanitize_text_field( wp_unslash( $_GET['apab_notice'] ) ) ); ?></p></div>
            <?php endif; ?>
            <p><strong>Version:</strong> <?php echo esc_html( APAB_VERSION ); ?> &nbsp; <strong>Mode:</strong> Separate bridge plugin. No Amaley Templates/Core/Discovery source modification.</p>
            <style>
                .apab-admin .nav-tab-wrapper{margin-top:18px}.apab-card{background:#fff;border:1px solid #dcdcde;border-radius:8px;padding:20px;margin-top:18px;max-width:1160px;box-shadow:0 1px 2px rgba(0,0,0,.04)}
                .apab-table{width:100%;border-collapse:collapse}.apab-table th{text-align:left;width:280px;vertical-align:top;padding:14px;border-bottom:1px solid #eee}.apab-table td{padding:14px;border-bottom:1px solid #eee}.apab-table select,.apab-table textarea{width:100%;max-width:720px}.apab-small{font-size:12px;color:#666;line-height:1.7}.apab-lock{background:#f7f7f7;border-left:4px solid #5b2b12;padding:12px 14px;margin:14px 0}.apab-status{display:inline-block;border-radius:999px;padding:3px 9px;font-size:12px;font-weight:700}.apab-status.ok{background:#e7f7ed;color:#126b32}.apab-status.warning{background:#fff7e2;color:#996800}.apab-status.error{background:#fde8e8;color:#b42318}
            </style>
            <h2 class="nav-tab-wrapper">
                <?php foreach ( $tabs as $key => $label ) : ?>
                    <a class="nav-tab <?php echo $active === $key ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'page' => 'amaley-page-assignment-bridge', 'tab' => $key ), admin_url( 'admin.php' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
                <?php endforeach; ?>
            </h2>
            <?php
            if ( 'single_product' === $active ) {
                $this->render_single_product();
            } elseif ( 'shop_page' === $active ) {
                $this->render_shop_page();
            } else {
                $this->render_debug();
            }
            ?>
        </div>
        <?php
    }

    private function render_single_product() {
        $s = APAB_Settings::get_settings();
        $v = $s['single_product'];
        ?>
        <form method="post" class="apab-card">
            <?php wp_nonce_field( 'apab_admin_action', 'apab_nonce' ); ?>
            <input type="hidden" name="apab_action" value="save_single_product">
            <h2>Single Product Assignment Bridge</h2>
            <p>Assign a normal Elementor page to render WooCommerce single product URLs. Build that page using <strong>Amaley Bridge</strong> widgets only.</p>
            <div class="apab-lock"><strong>Safety lock:</strong> This plugin does not edit products, images, cart, checkout, Amaley Core, Amaley Discovery Engine, Amaley Templates, header, or footer.</div>
            <table class="apab-table">
                <?php $this->field_select( 'Enable Single Product Bridge', 'enabled', $v['enabled'], array( 'off' => 'Off', 'test' => 'Test Product Only', 'all' => 'All Products' ) ); ?>
                <?php $this->field_page_select( 'Assigned Elementor Page', 'assigned_page_id', $v['assigned_page_id'] ); ?>
                <?php $this->field_product_select( 'Test Product', 'test_product_id', $v['test_product_id'] ); ?>
                <?php $this->field_select( 'Preview Product Context on Assigned Page', 'preview_assigned_page', $v['preview_assigned_page'], array( 'yes' => 'Yes — show product data while editing assigned page', 'no' => 'No' ) ); ?>
                <?php $this->field_product_select( 'Preview Product for Assigned Page / Editor', 'preview_product_id', $v['preview_product_id'] ); ?>
                <tr><th>Widget Order</th><td><strong>Use these v1.3.0 widgets on the assigned page:</strong><br><span class="apab-small">1. Amaley Bridge Product Hero<br>2. Amaley Bridge Trust Strip<br>3. Amaley Bridge Origin Panel<br>4. Amaley Bridge Info Tabs<br>5. Amaley Bridge Member Value Strip</span></td></tr>
                <tr><th>Fallback</th><td><strong>Default WooCommerce single product</strong><br><span class="apab-small">If bridge is off, page is missing, product is missing, or Elementor is unavailable, the default WooCommerce product page remains active.</span></td></tr>
                <?php $this->field_textarea( 'Internal Notes', 'notes', $v['notes'] ); ?>
            </table>
            <?php submit_button( 'Save Single Product Bridge Settings' ); ?>
        </form>
        <?php
    }

    private function render_shop_page() {
        echo '<div class="apab-card"><h2>Shop Page Assignment</h2><p>This module is reserved for later. Current active scope is only Single Product Assignment.</p></div>';
    }

    private function render_debug() {
        $checks = APAB_Settings::health_checks();
        echo '<div class="apab-card"><h2>Debug / Health</h2><table class="widefat striped"><tbody>';
        foreach ( $checks as $check ) {
            echo '<tr><td><span class="apab-status ' . esc_attr( $check['status'] ) . '">' . esc_html( strtoupper( $check['status'] ) ) . '</span></td><td><strong>' . esc_html( $check['label'] ) . '</strong><br><span class="apab-small">' . esc_html( $check['detail'] ) . '</span></td></tr>';
        }
        echo '</tbody></table></div>';
    }

    private function field_select( $label, $key, $value, $options ) {
        echo '<tr><th>' . esc_html( $label ) . '</th><td><select name="apab_single_product[' . esc_attr( $key ) . ']">';
        foreach ( $options as $opt_value => $opt_label ) {
            echo '<option value="' . esc_attr( $opt_value ) . '" ' . selected( (string) $value, (string) $opt_value, false ) . '>' . esc_html( $opt_label ) . '</option>';
        }
        echo '</select></td></tr>';
    }

    private function field_textarea( $label, $key, $value ) {
        echo '<tr><th>' . esc_html( $label ) . '</th><td><textarea rows="4" name="apab_single_product[' . esc_attr( $key ) . ']">' . esc_textarea( $value ) . '</textarea></td></tr>';
    }

    private function field_page_select( $label, $key, $value ) {
        $pages = get_pages( array( 'sort_column' => 'post_title', 'sort_order' => 'ASC' ) );
        echo '<tr><th>' . esc_html( $label ) . '</th><td><select name="apab_single_product[' . esc_attr( $key ) . ']"><option value="0">— Select page —</option>';
        foreach ( $pages as $page ) {
            echo '<option value="' . esc_attr( $page->ID ) . '" ' . selected( absint( $value ), $page->ID, false ) . '>' . esc_html( $page->post_title . ' (#' . $page->ID . ')' ) . '</option>';
        }
        echo '</select><p class="apab-small">Recommended: Amaley Single Product page built with Amaley Bridge widgets.</p></td></tr>';
    }

    private function field_product_select( $label, $key, $value ) {
        $products = get_posts( array( 'post_type' => 'product', 'post_status' => array( 'publish', 'private', 'draft' ), 'numberposts' => 200, 'orderby' => 'title', 'order' => 'ASC' ) );
        echo '<tr><th>' . esc_html( $label ) . '</th><td><select name="apab_single_product[' . esc_attr( $key ) . ']"><option value="0">— Select product —</option>';
        foreach ( $products as $product ) {
            echo '<option value="' . esc_attr( $product->ID ) . '" ' . selected( absint( $value ), $product->ID, false ) . '>' . esc_html( $product->post_title . ' (#' . $product->ID . ')' ) . '</option>';
        }
        echo '</select></td></tr>';
    }
}
