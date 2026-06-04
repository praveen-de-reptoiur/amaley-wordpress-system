<?php
/**
 * Plugin Name: Amaley H/F Studio V2
 * Description: Conflict-safe Elementor-style header/footer studio for Amaley. Multiple H/F templates, assignment rules, and live-style widgets.
 * Version: 2.0.4
 * Author: Praveen
 * Text Domain: amaley-hf-studio-v2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class AHFS2_Plugin {
    const VERSION = '2.0.4';
    const CPT = 'ahfs2_template';
    const OPTION = 'ahfs2_options';
    const RULES_OPTION = 'ahfs2_rules';

    private static $rendered_header = false;
    private static $render_stack = array();

    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_cpt' ), 5 );
        add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
        add_action( 'admin_post_ahfs2_create_template', array( __CLASS__, 'handle_create_template' ) );
        add_action( 'admin_post_ahfs2_set_default', array( __CLASS__, 'handle_set_default' ) );
        add_action( 'admin_post_ahfs2_delete_template', array( __CLASS__, 'handle_delete_template' ) );
        add_action( 'admin_post_ahfs2_save_assignments', array( __CLASS__, 'handle_save_assignments' ) );

        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_frontend_assets' ) );
        add_action( 'wp_body_open', array( __CLASS__, 'render_header' ), 5 );
        add_action( 'wp_footer', array( __CLASS__, 'render_footer' ), 5 );
        add_action( 'wp_footer', array( __CLASS__, 'render_header_fallback_if_needed' ), 1 );
        add_filter( 'body_class', array( __CLASS__, 'body_classes' ) );

        add_action( 'elementor/elements/categories_registered', array( __CLASS__, 'register_elementor_category' ) );
        add_action( 'elementor/widgets/register', array( __CLASS__, 'register_elementor_widgets' ) );
        add_filter( 'elementor/cpt_support', array( __CLASS__, 'add_elementor_cpt_support' ) );
    }

    public static function activate() {
        self::register_cpt();
        if ( ! get_option( self::OPTION ) ) {
            add_option( self::OPTION, self::default_options(), '', false );
        }
        if ( ! get_option( self::RULES_OPTION ) ) {
            add_option( self::RULES_OPTION, array(), '', false );
        }
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    public static function default_options() {
        return array(
            'show_header'       => 1,
            'show_footer'       => 1,
            'default_header_id' => 0,
            'default_footer_id' => 0,
            'hide_theme_header' => 0,
            'hide_theme_footer' => 0,
            'debug_mode'        => 0,
        );
    }

    public static function options() {
        $options = get_option( self::OPTION, array() );
        if ( ! is_array( $options ) ) {
            $options = array();
        }
        return wp_parse_args( $options, self::default_options() );
    }

    public static function update_options( $options ) {
        update_option( self::OPTION, wp_parse_args( $options, self::default_options() ), false );
    }

    public static function rules() {
        $rules = get_option( self::RULES_OPTION, array() );
        return is_array( $rules ) ? $rules : array();
    }

    public static function register_cpt() {
        register_post_type(
            self::CPT,
            array(
                'labels' => array(
                    'name'          => 'Amaley H/F Templates',
                    'singular_name' => 'Amaley H/F Template',
                    'add_new_item'  => 'Add New H/F Template',
                    'edit_item'     => 'Edit H/F Template',
                ),
                'public'              => true,
                'publicly_queryable'  => true,
                'show_ui'             => true,
                'show_in_menu'        => false,
                'show_in_admin_bar'   => true,
                'exclude_from_search' => true,
                'show_in_rest'        => true,
                'supports'            => array( 'title', 'editor', 'elementor' ),
                'rewrite'             => array( 'slug' => 'amaley-hf-template' ),
                'has_archive'         => false,
                'menu_icon'           => 'dashicons-layout',
            )
        );
        add_post_type_support( self::CPT, 'elementor' );
    }

    public static function add_elementor_cpt_support( $post_types ) {
        if ( is_array( $post_types ) && ! in_array( self::CPT, $post_types, true ) ) {
            $post_types[] = self::CPT;
        }
        return $post_types;
    }

    public static function admin_menu() {
        add_menu_page(
            'Amaley H/F Studio V2',
            'Amaley H/F Studio',
            'manage_options',
            'ahfs2-studio',
            array( __CLASS__, 'render_admin_page' ),
            'dashicons-layout',
            58
        );
    }

    public static function admin_url( $tab = 'templates', $args = array() ) {
        return add_query_arg( array_merge( array( 'page' => 'ahfs2-studio', 'tab' => $tab ), $args ), admin_url( 'admin.php' ) );
    }

    public static function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'templates';
        $tabs = array(
            'templates'   => 'Templates',
            'assignments' => 'Assignments',
            'debug'       => 'Debug / Health',
        );
        echo '<div class="wrap ahfs2-admin"><h1>Amaley H/F Studio V2 <span style="font-size:13px;color:#777">v' . esc_html( self::VERSION ) . '</span></h1>';
        self::admin_notice();
        echo '<nav class="nav-tab-wrapper">';
        foreach ( $tabs as $key => $label ) {
            echo '<a class="nav-tab ' . esc_attr( $tab === $key ? 'nav-tab-active' : '' ) . '" href="' . esc_url( self::admin_url( $key ) ) . '">' . esc_html( $label ) . '</a>';
        }
        echo '</nav>';
        if ( 'assignments' === $tab ) {
            self::render_assignments_tab();
        } elseif ( 'debug' === $tab ) {
            self::render_debug_tab();
        } else {
            self::render_templates_tab();
        }
        echo '</div>';
    }

    public static function admin_notice() {
        if ( empty( $_GET['ahfs2_notice'] ) ) {
            return;
        }
        $notice = sanitize_key( wp_unslash( $_GET['ahfs2_notice'] ) );
        $messages = array(
            'created'    => 'Template created. Now edit it with Elementor and publish.',
            'default'    => 'Default template saved.',
            'deleted'    => 'Template moved to trash. Matching assignments were cleared.',
            'saved'      => 'Assignments saved.',
            'bad_nonce'  => 'Security check failed. Please try again.',
            'bad_type'   => 'Template type was invalid.',
        );
        if ( isset( $messages[ $notice ] ) ) {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $messages[ $notice ] ) . '</p></div>';
        }
    }

    public static function get_templates( $type = '' ) {
        $args = array(
            'post_type'      => self::CPT,
            'post_status'    => array( 'publish', 'draft', 'pending' ),
            'posts_per_page' => 100,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'meta_query'     => array(),
        );
        if ( in_array( $type, array( 'header', 'footer' ), true ) ) {
            $args['meta_query'][] = array(
                'key'   => '_ahfs2_type',
                'value' => $type,
            );
        }
        return get_posts( $args );
    }

    public static function render_templates_tab() {
        $headers = self::get_templates( 'header' );
        $footers = self::get_templates( 'footer' );
        echo '<div class="ahfs2-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-top:20px;max-width:1100px">';
        self::create_box( 'header', 'Create Header', 'Header - Main Website' );
        self::create_box( 'footer', 'Create Footer', 'Footer - Main Website' );
        echo '</div>';
        self::templates_table( 'Header Templates', $headers, 'header' );
        self::templates_table( 'Footer Templates', $footers, 'footer' );
    }

    private static function create_box( $type, $title, $placeholder ) {
        echo '<div class="postbox" style="padding:18px;background:#fff;border-radius:10px;border:1px solid #e4d6c5">';
        echo '<h2 style="margin-top:0">' . esc_html( $title ) . '</h2>';
        echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
        wp_nonce_field( 'ahfs2_create_template' );
        echo '<input type="hidden" name="action" value="ahfs2_create_template" />';
        echo '<input type="hidden" name="type" value="' . esc_attr( $type ) . '" />';
        echo '<input type="text" name="title" value="' . esc_attr( $placeholder ) . '" style="width:100%;max-width:360px" />';
        echo '<p><button class="button button-primary">Add New ' . esc_html( ucfirst( $type ) ) . '</button></p>';
        echo '</form></div>';
    }

    private static function templates_table( $title, $templates, $type ) {
        $options = self::options();
        $default_id = absint( $options[ 'header' === $type ? 'default_header_id' : 'default_footer_id' ] );
        echo '<h2 style="margin-top:26px">' . esc_html( $title ) . '</h2>';
        echo '<table class="widefat striped" style="max-width:1100px"><thead><tr><th>Name</th><th>ID</th><th>Status</th><th>Default</th><th>Actions</th></tr></thead><tbody>';
        if ( empty( $templates ) ) {
            echo '<tr><td colspan="5">No templates yet.</td></tr>';
        }
        foreach ( $templates as $template ) {
            $edit_elementor = admin_url( 'post.php?post=' . absint( $template->ID ) . '&action=elementor' );
            $edit_wp = get_edit_post_link( $template->ID, '' );
            $set_url = wp_nonce_url(
                add_query_arg( array( 'action' => 'ahfs2_set_default', 'type' => $type, 'template_id' => $template->ID ), admin_url( 'admin-post.php' ) ),
                'ahfs2_set_default'
            );
            $delete_url = wp_nonce_url(
                add_query_arg( array( 'action' => 'ahfs2_delete_template', 'template_id' => $template->ID ), admin_url( 'admin-post.php' ) ),
                'ahfs2_delete_template'
            );
            echo '<tr>';
            echo '<td><strong>' . esc_html( get_the_title( $template ) ) . '</strong></td>';
            echo '<td>' . absint( $template->ID ) . '</td>';
            echo '<td>' . esc_html( ucfirst( $template->post_status ) ) . '</td>';
            echo '<td>' . ( $default_id === absint( $template->ID ) ? '<strong style="color:green">Default</strong>' : '—' ) . '</td>';
            echo '<td><a class="button button-primary" href="' . esc_url( $edit_elementor ) . '">Edit with Elementor</a> ';
            echo '<a class="button" href="' . esc_url( $edit_wp ) . '">WP Edit</a> ';
            echo '<a class="button" href="' . esc_url( $set_url ) . '">Set as Default</a> ';
            echo '<a class="button" style="color:#a00" onclick="return confirm(\'Move this template to trash? Matching assignments will be cleared.\')" href="' . esc_url( $delete_url ) . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }

    public static function render_assignments_tab() {
        $options = self::options();
        $rules = self::rules();
        $headers = self::get_templates( 'header' );
        $footers = self::get_templates( 'footer' );
        echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="max-width:1150px;margin-top:18px">';
        wp_nonce_field( 'ahfs2_save_assignments' );
        echo '<input type="hidden" name="action" value="ahfs2_save_assignments" />';
        echo '<div class="postbox" style="padding:18px;background:#fff;border-radius:10px;border:1px solid #e4d6c5">';
        echo '<h2>Display Control</h2>';
        self::checkbox_row( 'show_header', 'Show Amaley Header', $options['show_header'] );
        self::select_templates_row( 'default_header_id', 'Default Header', $headers, absint( $options['default_header_id'] ), '— No default header —' );
        self::checkbox_row( 'show_footer', 'Show Amaley Footer', $options['show_footer'] );
        self::select_templates_row( 'default_footer_id', 'Default Footer', $footers, absint( $options['default_footer_id'] ), '— No default footer —' );
        echo '<p><label><input type="checkbox" name="hide_theme_header" value="1" ' . checked( ! empty( $options['hide_theme_header'] ), true, false ) . ' /> Hide theme header on assigned pages</label></p>';
        echo '<p><label><input type="checkbox" name="hide_theme_footer" value="1" ' . checked( ! empty( $options['hide_theme_footer'] ), true, false ) . ' /> Hide theme footer on assigned pages</label></p>';
        echo '<p><label><input type="checkbox" name="debug_mode" value="1" ' . checked( ! empty( $options['debug_mode'] ), true, false ) . ' /> Debug comments for admins only</label></p>';
        echo '</div>';

        echo '<div class="postbox" style="padding:18px;background:#fff;border-radius:10px;border:1px solid #e4d6c5;margin-top:16px">';
        echo '<h2>Rule-Based Assignment</h2><p>Default header/footer works first. Add rules only for special pages.</p>';
        echo '<table class="widefat striped"><thead><tr><th>Enabled</th><th>Name</th><th>Zone</th><th>Template</th><th>Apply To</th><th>IDs CSV</th><th>Priority</th></tr></thead><tbody>';
        $rows = array_values( $rules );
        for ( $i = count( $rows ); $i < 5; $i++ ) {
            $rows[] = array( 'enabled' => 0, 'name' => '', 'zone' => 'header', 'template_id' => 0, 'condition' => 'entire_site', 'ids' => '', 'priority' => 100 );
        }
        foreach ( array_slice( $rows, 0, 10 ) as $i => $rule ) {
            $zone = isset( $rule['zone'] ) && 'footer' === $rule['zone'] ? 'footer' : 'header';
            $templates = 'footer' === $zone ? $footers : $headers;
            echo '<tr>';
            echo '<td><input type="checkbox" name="rules[' . esc_attr( $i ) . '][enabled]" value="1" ' . checked( ! empty( $rule['enabled'] ), true, false ) . ' /></td>';
            echo '<td><input type="text" name="rules[' . esc_attr( $i ) . '][name]" value="' . esc_attr( $rule['name'] ?? '' ) . '" /></td>';
            echo '<td><select name="rules[' . esc_attr( $i ) . '][zone]"><option value="header" ' . selected( $zone, 'header', false ) . '>Header</option><option value="footer" ' . selected( $zone, 'footer', false ) . '>Footer</option></select></td>';
            echo '<td>'; self::template_select( 'rules[' . esc_attr( $i ) . '][template_id]', $templates, absint( $rule['template_id'] ?? 0 ), '— Select —' ); echo '</td>';
            echo '<td>'; self::condition_select( 'rules[' . esc_attr( $i ) . '][condition]', $rule['condition'] ?? 'entire_site' ); echo '</td>';
            echo '<td><input type="text" name="rules[' . esc_attr( $i ) . '][ids]" value="' . esc_attr( $rule['ids'] ?? '' ) . '" placeholder="12,18,24" /></td>';
            echo '<td><input type="number" name="rules[' . esc_attr( $i ) . '][priority]" value="' . esc_attr( absint( $rule['priority'] ?? 100 ) ) . '" style="width:80px" /></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';
        echo '<p><button class="button button-primary button-hero">Save Assignments</button></p>';
        echo '</form>';
    }

    private static function checkbox_row( $key, $label, $checked ) {
        echo '<p><label><input type="checkbox" name="' . esc_attr( $key ) . '" value="1" ' . checked( ! empty( $checked ), true, false ) . ' /> ' . esc_html( $label ) . '</label></p>';
    }

    private static function select_templates_row( $key, $label, $templates, $selected, $empty_label ) {
        echo '<p><label style="display:inline-block;width:150px">' . esc_html( $label ) . '</label> ';
        self::template_select( $key, $templates, $selected, $empty_label );
        echo '</p>';
    }

    private static function template_select( $name, $templates, $selected, $empty_label ) {
        echo '<select name="' . esc_attr( $name ) . '">';
        echo '<option value="0">' . esc_html( $empty_label ) . '</option>';
        foreach ( $templates as $template ) {
            echo '<option value="' . absint( $template->ID ) . '" ' . selected( $selected, absint( $template->ID ), false ) . '>' . esc_html( get_the_title( $template ) . ' (#' . $template->ID . ')' ) . '</option>';
        }
        echo '</select>';
    }

    private static function condition_select( $name, $selected ) {
        $conditions = array(
            'entire_site' => 'Entire Site',
            'homepage'    => 'Homepage',
            'selected_pages' => 'Selected Pages',
            'shop'        => 'Shop Page',
            'products'    => 'All Product Pages',
            'cart'        => 'Cart Page',
            'checkout'    => 'Checkout Page',
            'account'     => 'My Account Page',
            'search'      => 'Search Page',
            'not_found'   => '404 Page',
        );
        echo '<select name="' . esc_attr( $name ) . '">';
        foreach ( $conditions as $value => $label ) {
            echo '<option value="' . esc_attr( $value ) . '" ' . selected( $selected, $value, false ) . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select>';
    }

    public static function render_debug_tab() {
        $options = self::options();
        $rules = self::rules();
        echo '<div class="postbox" style="padding:18px;background:#fff;max-width:900px;margin-top:20px">';
        echo '<h2>Health</h2><ul>';
        echo '<li>Plugin version: <strong>' . esc_html( self::VERSION ) . '</strong></li>';
        echo '<li>Elementor loaded: <strong>' . ( did_action( 'elementor/loaded' ) ? 'Yes' : 'No' ) . '</strong></li>';
        echo '<li>WooCommerce active: <strong>' . ( class_exists( 'WooCommerce' ) ? 'Yes' : 'No' ) . '</strong></li>';
        echo '<li>Default Header ID: <strong>' . absint( $options['default_header_id'] ) . '</strong></li>';
        echo '<li>Default Footer ID: <strong>' . absint( $options['default_footer_id'] ) . '</strong></li>';
        echo '<li>Rules count: <strong>' . count( $rules ) . '</strong></li>';
        echo '<li>Old Amaley H/F active: <strong>' . ( defined( 'AMALEY_HF_VERSION' ) ? 'Yes - deactivate old plugin' : 'No' ) . '</strong></li>';
        echo '<li>Old Site Shell active: <strong>' . ( defined( 'AMALEY_SHELL_VERSION' ) ? 'Yes - deactivate old plugin' : 'No' ) . '</strong></li>';
        echo '</ul>';
        echo '<p>This plugin does not use output buffering. It renders with wp_body_open and wp_footer only.</p>';
        echo '</div>';
    }

    public static function handle_create_template() {
        if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'ahfs2_create_template' ) ) {
            wp_safe_redirect( self::admin_url( 'templates', array( 'ahfs2_notice' => 'bad_nonce' ) ) ); exit;
        }
        $type = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
        if ( ! in_array( $type, array( 'header', 'footer' ), true ) ) {
            wp_safe_redirect( self::admin_url( 'templates', array( 'ahfs2_notice' => 'bad_type' ) ) ); exit;
        }
        $title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : ucfirst( $type ) . ' Template';
        $id = wp_insert_post(
            array(
                'post_type'   => self::CPT,
                'post_title'  => $title ?: ucfirst( $type ) . ' Template',
                'post_status' => 'publish',
            ),
            true
        );
        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, '_ahfs2_type', $type );
            update_post_meta( $id, '_wp_page_template', 'elementor_canvas' );
        }
        wp_safe_redirect( self::admin_url( 'templates', array( 'ahfs2_notice' => 'created' ) ) ); exit;
    }

    public static function handle_set_default() {
        if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'ahfs2_set_default' ) ) {
            wp_safe_redirect( self::admin_url( 'templates', array( 'ahfs2_notice' => 'bad_nonce' ) ) ); exit;
        }
        $type = isset( $_GET['type'] ) ? sanitize_key( wp_unslash( $_GET['type'] ) ) : '';
        $template_id = isset( $_GET['template_id'] ) ? absint( $_GET['template_id'] ) : 0;
        if ( $template_id && self::valid_template( $template_id, $type ) ) {
            $options = self::options();
            if ( 'header' === $type ) {
                $options['default_header_id'] = $template_id;
                $options['show_header'] = 1;
            } elseif ( 'footer' === $type ) {
                $options['default_footer_id'] = $template_id;
                $options['show_footer'] = 1;
            }
            self::update_options( $options );
        }
        wp_safe_redirect( self::admin_url( 'templates', array( 'ahfs2_notice' => 'default' ) ) ); exit;
    }

    public static function handle_delete_template() {
        if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'ahfs2_delete_template' ) ) {
            wp_safe_redirect( self::admin_url( 'templates', array( 'ahfs2_notice' => 'bad_nonce' ) ) ); exit;
        }
        $template_id = isset( $_GET['template_id'] ) ? absint( $_GET['template_id'] ) : 0;
        if ( $template_id && self::CPT === get_post_type( $template_id ) ) {
            wp_trash_post( $template_id );
            $options = self::options();
            if ( absint( $options['default_header_id'] ) === $template_id ) { $options['default_header_id'] = 0; }
            if ( absint( $options['default_footer_id'] ) === $template_id ) { $options['default_footer_id'] = 0; }
            self::update_options( $options );
            $rules = array_filter( self::rules(), function( $rule ) use ( $template_id ) { return absint( $rule['template_id'] ?? 0 ) !== $template_id; } );
            update_option( self::RULES_OPTION, array_values( $rules ), false );
        }
        wp_safe_redirect( self::admin_url( 'templates', array( 'ahfs2_notice' => 'deleted' ) ) ); exit;
    }

    public static function handle_save_assignments() {
        if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'ahfs2_save_assignments' ) ) {
            wp_safe_redirect( self::admin_url( 'assignments', array( 'ahfs2_notice' => 'bad_nonce' ) ) ); exit;
        }
        $options = self::options();
        $header_id = isset( $_POST['default_header_id'] ) ? absint( $_POST['default_header_id'] ) : 0;
        $footer_id = isset( $_POST['default_footer_id'] ) ? absint( $_POST['default_footer_id'] ) : 0;
        $options['show_header'] = ! empty( $_POST['show_header'] ) ? 1 : 0;
        $options['show_footer'] = ! empty( $_POST['show_footer'] ) ? 1 : 0;
        $options['default_header_id'] = self::valid_template( $header_id, 'header' ) ? $header_id : 0;
        $options['default_footer_id'] = self::valid_template( $footer_id, 'footer' ) ? $footer_id : 0;
        $options['hide_theme_header'] = ! empty( $_POST['hide_theme_header'] ) ? 1 : 0;
        $options['hide_theme_footer'] = ! empty( $_POST['hide_theme_footer'] ) ? 1 : 0;
        $options['debug_mode'] = ! empty( $_POST['debug_mode'] ) ? 1 : 0;
        self::update_options( $options );

        $clean_rules = array();
        $posted_rules = isset( $_POST['rules'] ) && is_array( $_POST['rules'] ) ? wp_unslash( $_POST['rules'] ) : array();
        foreach ( $posted_rules as $rule ) {
            if ( empty( $rule['enabled'] ) ) { continue; }
            $zone = isset( $rule['zone'] ) && 'footer' === $rule['zone'] ? 'footer' : 'header';
            $template_id = isset( $rule['template_id'] ) ? absint( $rule['template_id'] ) : 0;
            if ( ! self::valid_template( $template_id, $zone ) ) { continue; }
            $clean_rules[] = array(
                'enabled' => 1,
                'name' => sanitize_text_field( $rule['name'] ?? '' ),
                'zone' => $zone,
                'template_id' => $template_id,
                'condition' => sanitize_key( $rule['condition'] ?? 'entire_site' ),
                'ids' => preg_replace( '/[^0-9,]/', '', (string) ( $rule['ids'] ?? '' ) ),
                'priority' => absint( $rule['priority'] ?? 100 ),
            );
        }
        usort( $clean_rules, function( $a, $b ) { return absint( $b['priority'] ) <=> absint( $a['priority'] ); } );
        update_option( self::RULES_OPTION, $clean_rules, false );
        wp_safe_redirect( self::admin_url( 'assignments', array( 'ahfs2_notice' => 'saved' ) ) ); exit;
    }

    private static function valid_template( $id, $type ) {
        $id = absint( $id );
        if ( ! $id || self::CPT !== get_post_type( $id ) || 'publish' !== get_post_status( $id ) ) {
            return false;
        }
        return get_post_meta( $id, '_ahfs2_type', true ) === $type;
    }

    private static function should_skip_frontend_render() {
        if ( is_admin() || wp_doing_ajax() || wp_is_json_request() || is_feed() ) {
            return true;
        }
        if ( is_singular( self::CPT ) ) {
            return true;
        }
        if ( isset( $_GET['elementor-preview'] ) || isset( $_GET['preview_id'] ) ) {
            return true;
        }
        return false;
    }

    public static function register_frontend_assets() {
        wp_register_style( 'ahfs2-frontend', plugin_dir_url( __FILE__ ) . 'assets/css/frontend.css', array(), self::VERSION );
        wp_register_script( 'ahfs2-frontend', plugin_dir_url( __FILE__ ) . 'assets/js/frontend.js', array(), self::VERSION, true );
    }

    private static function enqueue_frontend() {
        if ( ! wp_style_is( 'ahfs2-frontend', 'registered' ) ) {
            self::register_frontend_assets();
        }
        wp_enqueue_style( 'ahfs2-frontend' );
        wp_enqueue_script( 'ahfs2-frontend' );
    }

    public static function render_header() {
        if ( self::should_skip_frontend_render() ) { return; }
        self::$rendered_header = true;
        $id = self::resolve_template_id( 'header' );
        if ( ! $id ) { self::debug_comment( 'No header assigned.' ); return; }
        self::enqueue_frontend();
        echo '<div class="ahfs2-zone ahfs2-zone-header" data-ahfs2-zone="header">';
        echo self::render_template_content( $id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</div>';
    }

    public static function render_header_fallback_if_needed() {
        if ( self::should_skip_frontend_render() || self::$rendered_header ) { return; }
        $id = self::resolve_template_id( 'header' );
        if ( ! $id ) { return; }
        self::enqueue_frontend();
        echo '<div class="ahfs2-zone ahfs2-zone-header ahfs2-zone-header--fallback" data-ahfs2-zone="header-fallback">';
        echo self::render_template_content( $id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</div>';
        echo '<script>document.documentElement.classList.add("ahfs2-header-fallback-used");</script>';
    }

    public static function render_footer() {
        if ( self::should_skip_frontend_render() ) { return; }
        $id = self::resolve_template_id( 'footer' );
        if ( ! $id ) { self::debug_comment( 'No footer assigned.' ); return; }
        self::enqueue_frontend();
        echo '<div class="ahfs2-zone ahfs2-zone-footer" data-ahfs2-zone="footer">';
        echo self::render_template_content( $id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</div>';
    }

    private static function resolve_template_id( $zone ) {
        $options = self::options();
        if ( 'header' === $zone && empty( $options['show_header'] ) ) { return 0; }
        if ( 'footer' === $zone && empty( $options['show_footer'] ) ) { return 0; }
        foreach ( self::rules() as $rule ) {
            if ( empty( $rule['enabled'] ) || ( $rule['zone'] ?? '' ) !== $zone ) { continue; }
            if ( self::condition_matches( $rule ) && self::valid_template( absint( $rule['template_id'] ), $zone ) ) {
                return absint( $rule['template_id'] );
            }
        }
        $key = 'header' === $zone ? 'default_header_id' : 'default_footer_id';
        $id = absint( $options[ $key ] ?? 0 );
        return self::valid_template( $id, $zone ) ? $id : 0;
    }

    private static function condition_matches( $rule ) {
        $condition = $rule['condition'] ?? 'entire_site';
        if ( 'entire_site' === $condition ) { return true; }
        if ( 'homepage' === $condition ) { return is_front_page() || is_home(); }
        if ( 'selected_pages' === $condition ) {
            $ids = array_filter( array_map( 'absint', explode( ',', (string) ( $rule['ids'] ?? '' ) ) ) );
            return is_page() && in_array( get_queried_object_id(), $ids, true );
        }
        if ( 'shop' === $condition ) { return function_exists( 'is_shop' ) && is_shop(); }
        if ( 'products' === $condition ) { return is_singular( 'product' ); }
        if ( 'cart' === $condition ) { return function_exists( 'is_cart' ) && is_cart(); }
        if ( 'checkout' === $condition ) { return function_exists( 'is_checkout' ) && is_checkout(); }
        if ( 'account' === $condition ) { return function_exists( 'is_account_page' ) && is_account_page(); }
        if ( 'search' === $condition ) { return is_search(); }
        if ( 'not_found' === $condition ) { return is_404(); }
        return false;
    }

    private static function render_template_content( $id ) {
        $id = absint( $id );
        if ( ! $id || isset( self::$render_stack[ $id ] ) ) {
            return '';
        }
        self::$render_stack[ $id ] = true;
        $html = '';
        try {
            if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->frontend ) ) {
                $html = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id, true );
            }
            if ( '' === trim( (string) $html ) ) {
                $content = get_post_field( 'post_content', $id );
                $html = apply_filters( 'the_content', $content );
            }
        } catch ( Throwable $e ) {
            $html = current_user_can( 'manage_options' ) ? '<div class="ahfs2-render-error">Amaley H/F render error: ' . esc_html( $e->getMessage() ) . '</div>' : '';
        }
        unset( self::$render_stack[ $id ] );
        return (string) $html;
    }

    public static function body_classes( $classes ) {
        $options = self::options();
        if ( self::should_skip_frontend_render() ) { return $classes; }
        if ( ! empty( $options['hide_theme_header'] ) && self::resolve_template_id( 'header' ) ) { $classes[] = 'ahfs2-hide-theme-header'; }
        if ( ! empty( $options['hide_theme_footer'] ) && self::resolve_template_id( 'footer' ) ) { $classes[] = 'ahfs2-hide-theme-footer'; }
        return $classes;
    }

    private static function debug_comment( $message ) {
        $options = self::options();
        if ( ! empty( $options['debug_mode'] ) && current_user_can( 'manage_options' ) ) {
            echo "\n<!-- AHFS2: " . esc_html( $message ) . " -->\n";
        }
    }

    public static function register_elementor_category( $elements_manager ) {
        if ( is_object( $elements_manager ) && method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category( 'ahfs2', array( 'title' => 'Amaley H/F Studio', 'icon' => 'fa fa-plug' ) );
        }
    }

    public static function register_elementor_widgets( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }
        require_once __DIR__ . '/widgets.php';
        if ( ! class_exists( 'AHFS2_Header_Live_Widget' ) || ! class_exists( 'AHFS2_Footer_Live_Widget' ) ) { return; }
        if ( method_exists( $widgets_manager, 'register' ) ) {
            $widgets_manager->register( new AHFS2_Header_Live_Widget() );
            $widgets_manager->register( new AHFS2_Footer_Live_Widget() );
        } elseif ( method_exists( $widgets_manager, 'register_widget_type' ) ) {
            $widgets_manager->register_widget_type( new AHFS2_Header_Live_Widget() );
            $widgets_manager->register_widget_type( new AHFS2_Footer_Live_Widget() );
        }
    }
}



AHFS2_Plugin::init();
register_activation_hook( __FILE__, array( 'AHFS2_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'AHFS2_Plugin', 'deactivate' ) );
