<?php
/**
 * Admin pages.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell_Admin {
    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
        add_action( 'admin_post_amaley_shell_save_settings', array( __CLASS__, 'save_settings' ) );
    }

    public static function menu() {
        add_menu_page(
            'Amaley Site Shell',
            'Amaley Site Shell',
            'manage_options',
            'amaley-site-shell',
            array( __CLASS__, 'render_page' ),
            'dashicons-layout',
            57
        );
    }

    public static function save_settings() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to save settings.', 'amaley-site-shell' ) );
        }
        check_admin_referer( 'amaley_shell_save_settings' );

        $settings = Amaley_Shell_Settings::all();
        $posted   = isset( $_POST['amaley_shell'] ) && is_array( $_POST['amaley_shell'] ) ? wp_unslash( $_POST['amaley_shell'] ) : array();

        $checkboxes = array(
            'enable_header', 'enable_footer', 'auto_render_header', 'auto_render_footer', 'show_announcement',
            'sticky_header', 'show_cta', 'show_cart', 'show_account',
        );
        foreach ( $checkboxes as $key ) {
            $posted[ $key ] = ! empty( $posted[ $key ] ) ? 1 : 0;
        }

        $merged = array_merge( $settings, $posted );
        Amaley_Shell_Settings::update( $merged );

        $tab = isset( $_POST['amaley_shell_tab'] ) ? sanitize_key( wp_unslash( $_POST['amaley_shell_tab'] ) ) : 'dashboard';
        wp_safe_redirect( add_query_arg( array( 'page' => 'amaley-site-shell', 'tab' => $tab, 'amaley_shell_notice' => 'saved' ), admin_url( 'admin.php' ) ) );
        exit;
    }

    public static function render_page() {
        $settings = Amaley_Shell_Settings::all();
        $tab      = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'dashboard';
        $tabs     = array(
            'dashboard' => 'Dashboard',
            'header'    => 'Header Settings',
            'mobile'    => 'Mobile Header',
            'nav'       => 'Navigation',
            'footer'    => 'Footer Settings',
            'design'    => 'Design Controls',
            'import'    => 'Import / Export',
            'settings'  => 'Settings',
        );
        ?>
        <div class="wrap amaley-shell-admin-wrap">
            <h1>Amaley Site Shell <span>v<?php echo esc_html( AMALEY_SHELL_VERSION ); ?></span></h1>
            <?php self::notice(); ?>
            <nav class="nav-tab-wrapper amaley-shell-tabs">
                <?php foreach ( $tabs as $key => $label ) : ?>
                    <a class="nav-tab <?php echo $tab === $key ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'page' => 'amaley-site-shell', 'tab' => $key ), admin_url( 'admin.php' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
                <?php endforeach; ?>
            </nav>

            <?php if ( 'dashboard' === $tab ) : ?>
                <?php self::dashboard( $settings ); ?>
            <?php elseif ( 'import' === $tab ) : ?>
                <?php self::import_export(); ?>
            <?php else : ?>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="amaley-shell-form">
                    <?php wp_nonce_field( 'amaley_shell_save_settings' ); ?>
                    <input type="hidden" name="action" value="amaley_shell_save_settings" />
                    <input type="hidden" name="amaley_shell_tab" value="<?php echo esc_attr( $tab ); ?>" />
                    <?php
                    if ( 'header' === $tab ) {
                        self::header_fields( $settings );
                    } elseif ( 'mobile' === $tab ) {
                        self::mobile_fields( $settings );
                    } elseif ( 'nav' === $tab ) {
                        self::nav_fields( $settings );
                    } elseif ( 'footer' === $tab ) {
                        self::footer_fields( $settings );
                    } elseif ( 'design' === $tab ) {
                        self::design_fields( $settings );
                    } elseif ( 'settings' === $tab ) {
                        self::settings_fields( $settings );
                    }
                    ?>
                    <p class="submit"><button type="submit" class="button button-primary button-hero">Save Amaley Site Shell Settings</button></p>
                </form>
            <?php endif; ?>
        </div>
        <?php
    }

    private static function notice() {
        if ( empty( $_GET['amaley_shell_notice'] ) ) {
            return;
        }
        $notice = sanitize_key( wp_unslash( $_GET['amaley_shell_notice'] ) );
        $map    = array(
            'saved'         => 'Settings saved successfully.',
            'imported'      => 'Settings imported successfully. A backup of previous settings was stored.',
            'import_failed' => 'Import failed. Please check the JSON format.',
            'reset'         => 'Settings reset to default. A backup of previous settings was stored.',
        );
        if ( isset( $map[ $notice ] ) ) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $map[ $notice ] ) . '</p></div>';
        }
    }

    private static function dashboard( array $settings ) {
        $nav_count    = is_array( $settings['nav_items'] ) ? count( $settings['nav_items'] ) : 0;
        $footer_count = is_array( $settings['footer_columns'] ) ? count( $settings['footer_columns'] ) : 0;
        ?>
        <div class="amaley-shell-admin-grid">
            <?php self::kpi( 'Header', ! empty( $settings['enable_header'] ) ? 'Enabled' : 'Disabled' ); ?>
            <?php self::kpi( 'Footer', ! empty( $settings['enable_footer'] ) ? 'Enabled' : 'Disabled' ); ?>
            <?php self::kpi( 'Auto Header', ! empty( $settings['auto_render_header'] ) ? 'ON — test carefully' : 'OFF' ); ?>
            <?php self::kpi( 'Auto Footer', ! empty( $settings['auto_render_footer'] ) ? 'ON — test carefully' : 'OFF' ); ?>
            <?php self::kpi( 'Navigation Items', (string) $nav_count ); ?>
            <?php self::kpi( 'Footer Columns', (string) $footer_count ); ?>
        </div>
        <div class="amaley-shell-admin-card">
            <h2>Shortcodes</h2>
            <p>Use these in Elementor Shortcode widget, page builder, or template areas:</p>
            <code>[amaley_site_header]</code><br />
            <code>[amaley_site_footer]</code>
        </div>
        <div class="amaley-shell-admin-card">
            <h2>Safety Status</h2>
            <ul>
                <li>Auto Render Mode default OFF, but can now be enabled/disabled directly from backend settings.</li>
                <li>Existing theme header/footer hiding is optional and staging-only.</li>
                <li>Scoped frontend CSS prefix: <code>.amaley-shell-</code></li>
                <li>PHP prefix: <code>Amaley_Shell_</code> / <code>amaley_shell_</code></li>
                <li>WooCommerce and Elementor are not replaced by this plugin.</li>
            </ul>
        </div>
        <?php
    }

    private static function kpi( $label, $value ) {
        echo '<div class="amaley-shell-admin-kpi"><span>' . esc_html( $label ) . '</span><strong>' . esc_html( $value ) . '</strong></div>';
    }

    private static function header_fields( array $s ) {
        ?>
        <div class="amaley-shell-admin-card"><h2>Header Settings</h2>
            <?php self::checkbox( 'enable_header', 'Enable Header', $s ); ?>
            <?php self::checkbox( 'show_announcement', 'Enable Announcement Strip', $s ); ?>
            <?php self::text( 'announcement_text', 'Announcement Text', $s ); ?>
            <?php self::url( 'announcement_link', 'Announcement Link', $s ); ?>
            <?php self::url( 'logo_url', 'Logo Image URL', $s ); ?>
            <?php self::text( 'logo_text', 'Logo Text Fallback', $s ); ?>
            <?php self::number( 'logo_width_desktop', 'Logo Width Desktop', $s ); ?>
            <?php self::number( 'logo_width_tablet', 'Logo Width Tablet', $s ); ?>
            <?php self::number( 'logo_width_mobile', 'Logo Width Mobile', $s ); ?>
            <?php self::number( 'header_height', 'Header Height', $s ); ?>
            <?php self::checkbox( 'sticky_header', 'Sticky Header', $s ); ?>
            <?php self::checkbox( 'show_cta', 'Show CTA Button', $s ); ?>
            <?php self::text( 'cta_text', 'CTA Text', $s ); ?>
            <?php self::url( 'cta_link', 'CTA Link', $s ); ?>
            <?php self::checkbox( 'show_cart', 'Show Cart Link', $s ); ?>
            <?php self::checkbox( 'show_account', 'Show Account Link', $s ); ?>
            <?php self::url( 'account_link', 'Account Link', $s ); ?>
        </div>
        <?php
    }

    private static function mobile_fields( array $s ) {
        ?>
        <div class="amaley-shell-admin-card"><h2>Mobile Header / Drawer</h2>
            <?php self::number( 'mobile_breakpoint', 'Mobile Breakpoint in px', $s ); ?>
            <p class="description">Below this width, desktop navigation hides and mobile drawer button appears.</p>
            <p>Mobile drawer uses the same Navigation items. Use the Navigation tab to choose which items show on mobile.</p>
        </div>
        <?php
    }

    private static function nav_fields( array $s ) {
        $items = is_array( $s['nav_items'] ) ? $s['nav_items'] : array();
        for ( $i = 0; $i < 3; $i++ ) {
            $items[] = array( 'label' => '', 'url' => '', 'desktop' => 1, 'mobile' => 1, 'new_tab' => 0, 'highlight' => 0, 'badge' => '' );
        }
        ?>
        <div class="amaley-shell-admin-card"><h2>Navigation Manager</h2>
            <p>Edit labels, URLs, visibility, badges and highlight state. Leave Label or URL blank to remove a row.</p>
            <table class="widefat striped amaley-shell-table">
                <thead><tr><th>Label</th><th>URL</th><th>Desktop</th><th>Mobile</th><th>New Tab</th><th>Highlight</th><th>Badge</th></tr></thead>
                <tbody>
                <?php foreach ( $items as $i => $item ) : ?>
                    <tr>
                        <td><input type="text" name="amaley_shell[nav_items][<?php echo esc_attr( $i ); ?>][label]" value="<?php echo esc_attr( $item['label'] ?? '' ); ?>" /></td>
                        <td><input type="text" name="amaley_shell[nav_items][<?php echo esc_attr( $i ); ?>][url]" value="<?php echo esc_attr( $item['url'] ?? '' ); ?>" /></td>
                        <td><input type="checkbox" name="amaley_shell[nav_items][<?php echo esc_attr( $i ); ?>][desktop]" value="1" <?php checked( ! empty( $item['desktop'] ) ); ?> /></td>
                        <td><input type="checkbox" name="amaley_shell[nav_items][<?php echo esc_attr( $i ); ?>][mobile]" value="1" <?php checked( ! empty( $item['mobile'] ) ); ?> /></td>
                        <td><input type="checkbox" name="amaley_shell[nav_items][<?php echo esc_attr( $i ); ?>][new_tab]" value="1" <?php checked( ! empty( $item['new_tab'] ) ); ?> /></td>
                        <td><input type="checkbox" name="amaley_shell[nav_items][<?php echo esc_attr( $i ); ?>][highlight]" value="1" <?php checked( ! empty( $item['highlight'] ) ); ?> /></td>
                        <td><input type="text" name="amaley_shell[nav_items][<?php echo esc_attr( $i ); ?>][badge]" value="<?php echo esc_attr( $item['badge'] ?? '' ); ?>" /></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    private static function footer_fields( array $s ) {
        ?>
        <div class="amaley-shell-admin-card"><h2>Footer Settings</h2>
            <?php self::checkbox( 'enable_footer', 'Enable Footer', $s ); ?>
            <?php self::url( 'footer_logo_url', 'Footer Logo URL', $s ); ?>
            <?php self::textarea( 'footer_description', 'Footer Description', $s ); ?>
            <?php self::email( 'contact_email', 'Contact Email', $s ); ?>
            <?php self::text( 'contact_phone', 'Contact Phone', $s ); ?>
            <?php self::text( 'contact_whatsapp', 'WhatsApp Number', $s ); ?>
            <?php self::textarea( 'contact_address', 'Address', $s ); ?>
            <?php self::url( 'instagram_link', 'Instagram Link', $s ); ?>
            <?php self::url( 'facebook_link', 'Facebook Link', $s ); ?>
            <?php self::url( 'linkedin_link', 'LinkedIn Link', $s ); ?>
            <?php self::url( 'youtube_link', 'YouTube Link', $s ); ?>
            <?php self::text( 'copyright_text', 'Copyright Text', $s ); ?>
            <?php self::text( 'designed_by_text', 'Designed By Text', $s ); ?>
        </div>
        <?php self::footer_columns_fields( $s ); ?>
        <?php
    }

    private static function footer_columns_fields( array $s ) {
        $columns = is_array( $s['footer_columns'] ) ? $s['footer_columns'] : array();
        for ( $c = 0; $c < 2; $c++ ) {
            $columns[] = array( 'title' => '', 'links' => array() );
        }
        ?>
        <div class="amaley-shell-admin-card"><h2>Footer Columns</h2>
            <p>Leave title blank to remove a column. Leave label or URL blank to remove a link.</p>
            <?php foreach ( $columns as $c => $column ) : ?>
                <div class="amaley-shell-column-box">
                    <label>Column Title</label>
                    <input type="text" name="amaley_shell[footer_columns][<?php echo esc_attr( $c ); ?>][title]" value="<?php echo esc_attr( $column['title'] ?? '' ); ?>" />
                    <table class="widefat striped amaley-shell-table">
                        <thead><tr><th>Link Label</th><th>URL</th></tr></thead>
                        <tbody>
                        <?php
                        $links = isset( $column['links'] ) && is_array( $column['links'] ) ? $column['links'] : array();
                        for ( $i = 0; $i < 2; $i++ ) {
                            $links[] = array( 'label' => '', 'url' => '' );
                        }
                        foreach ( $links as $i => $link ) :
                            ?>
                            <tr>
                                <td><input type="text" name="amaley_shell[footer_columns][<?php echo esc_attr( $c ); ?>][links][<?php echo esc_attr( $i ); ?>][label]" value="<?php echo esc_attr( $link['label'] ?? '' ); ?>" /></td>
                                <td><input type="text" name="amaley_shell[footer_columns][<?php echo esc_attr( $c ); ?>][links][<?php echo esc_attr( $i ); ?>][url]" value="<?php echo esc_attr( $link['url'] ?? '' ); ?>" /></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    private static function design_fields( array $s ) {
        ?>
        <div class="amaley-shell-admin-card"><h2>Design Controls</h2>
            <?php self::color( 'color_header_bg', 'Header Background', $s ); ?>
            <?php self::color( 'color_header_text', 'Header Text', $s ); ?>
            <?php self::color( 'color_header_border', 'Header Border', $s ); ?>
            <?php self::color( 'color_accent', 'Accent', $s ); ?>
            <?php self::color( 'color_button_bg', 'Button Background', $s ); ?>
            <?php self::color( 'color_button_text', 'Button Text', $s ); ?>
            <?php self::color( 'color_footer_bg', 'Footer Background', $s ); ?>
            <?php self::color( 'color_footer_text', 'Footer Text', $s ); ?>
            <?php self::color( 'color_footer_muted', 'Footer Muted Text', $s ); ?>
            <?php self::color( 'color_footer_link', 'Footer Links', $s ); ?>
            <?php self::text( 'font_heading', 'Heading Font Stack', $s ); ?>
            <?php self::text( 'font_body', 'Body Font Stack', $s ); ?>
        </div>
        <?php
    }

    private static function settings_fields( array $s ) {
        ?>
        <div class="amaley-shell-admin-card"><h2>Render Settings</h2>
            <p><strong>Recommended:</strong> Keep auto render OFF during staging. Use shortcodes or Elementor widgets first.</p>
            <?php self::checkbox( 'auto_render_header', 'Backend Enable Header Auto Render', $s ); ?>
            <p class="description">When ON, Amaley header is injected automatically using <code>wp_body_open</code>. No page shortcode needed.</p>
            <?php self::checkbox( 'auto_render_footer', 'Backend Enable Footer Auto Render', $s ); ?>
            <p class="description">When ON, Amaley footer is injected automatically before the theme footer loads. No page shortcode needed.</p>
            <hr />
            <h3>Replace Existing Theme Shell — Staging Only</h3>
            <p><strong>Use this only on staging after visual check.</strong> These options hide the current theme header/footer so Amaley Site Shell can become the visible header/footer.</p>
            <?php self::checkbox( 'hide_theme_header', 'Hide Existing Theme Header', $s ); ?>
            <?php self::textarea( 'theme_header_selector', 'Theme Header CSS Selectors', $s ); ?>
            <?php self::checkbox( 'hide_theme_footer', 'Hide Existing Theme Footer', $s ); ?>
            <?php self::textarea( 'theme_footer_selector', 'Theme Footer CSS Selectors', $s ); ?>
        </div>
        <?php
    }

    private static function import_export() {
        $export_url = wp_nonce_url( add_query_arg( array( 'page' => 'amaley-site-shell', 'amaley_shell_export' => 1 ), admin_url( 'admin.php' ) ), 'amaley_shell_export_settings' );
        ?>
        <div class="amaley-shell-admin-card">
            <h2>Export Settings</h2>
            <p>Download a JSON backup of current Amaley Site Shell settings.</p>
            <a class="button button-primary" href="<?php echo esc_url( $export_url ); ?>">Export Settings JSON</a>
        </div>
        <div class="amaley-shell-admin-card">
            <h2>Import Settings</h2>
            <p>Paste a previously exported JSON file content. Existing settings will be backed up first.</p>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php wp_nonce_field( 'amaley_shell_import_settings' ); ?>
                <input type="hidden" name="action" value="amaley_shell_import_settings" />
                <textarea name="amaley_shell_import_json" rows="12" class="large-text code"></textarea>
                <p><button type="submit" class="button button-primary">Import Settings</button></p>
            </form>
        </div>
        <div class="amaley-shell-admin-card amaley-shell-danger">
            <h2>Reset to Default</h2>
            <p>This stores a backup first, then resets header/footer settings to default Amaley baseline.</p>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php wp_nonce_field( 'amaley_shell_reset_settings' ); ?>
                <input type="hidden" name="action" value="amaley_shell_reset_settings" />
                <button type="submit" class="button">Reset to Default</button>
            </form>
        </div>
        <?php
    }

    private static function field_wrap( $key, $label, $html ) {
        echo '<div class="amaley-shell-field"><label for="amaley_shell_' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label><div>' . $html . '</div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    private static function text( $key, $label, array $s ) { self::field_wrap( $key, $label, '<input type="text" id="amaley_shell_' . esc_attr( $key ) . '" name="amaley_shell[' . esc_attr( $key ) . ']" value="' . esc_attr( $s[ $key ] ?? '' ) . '" class="regular-text" />' ); }
    private static function email( $key, $label, array $s ) { self::field_wrap( $key, $label, '<input type="email" id="amaley_shell_' . esc_attr( $key ) . '" name="amaley_shell[' . esc_attr( $key ) . ']" value="' . esc_attr( $s[ $key ] ?? '' ) . '" class="regular-text" />' ); }
    private static function url( $key, $label, array $s ) { self::field_wrap( $key, $label, '<input type="text" id="amaley_shell_' . esc_attr( $key ) . '" name="amaley_shell[' . esc_attr( $key ) . ']" value="' . esc_attr( $s[ $key ] ?? '' ) . '" class="regular-text" placeholder="/shop/ or https://..." />' ); }
    private static function number( $key, $label, array $s ) { self::field_wrap( $key, $label, '<input type="number" id="amaley_shell_' . esc_attr( $key ) . '" name="amaley_shell[' . esc_attr( $key ) . ']" value="' . esc_attr( $s[ $key ] ?? 0 ) . '" class="small-text" /> px' ); }
    private static function color( $key, $label, array $s ) { self::field_wrap( $key, $label, '<input type="text" id="amaley_shell_' . esc_attr( $key ) . '" name="amaley_shell[' . esc_attr( $key ) . ']" value="' . esc_attr( $s[ $key ] ?? '' ) . '" class="regular-text" placeholder="#2e1203" />' ); }
    private static function textarea( $key, $label, array $s ) { self::field_wrap( $key, $label, '<textarea id="amaley_shell_' . esc_attr( $key ) . '" name="amaley_shell[' . esc_attr( $key ) . ']" rows="4" class="large-text">' . esc_textarea( $s[ $key ] ?? '' ) . '</textarea>' ); }
    private static function checkbox( $key, $label, array $s ) { self::field_wrap( $key, $label, '<label><input type="checkbox" name="amaley_shell[' . esc_attr( $key ) . ']" value="1" ' . checked( ! empty( $s[ $key ] ), true, false ) . ' /> Yes</label>' ); }
}
