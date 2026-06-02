<?php
/** Admin dashboard and utility pages. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Amaley_Core_Admin {
    private $fields;
    private $settings_option = 'amaley_core_template_settings';

    public function __construct( $fields ) {
        $this->fields = $fields;
        add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 9 );
    }

    public function register_admin_menu() {
        add_menu_page( 'Amaley Core', 'Amaley Core', 'manage_options', 'amaley-core', array( $this, 'render_dashboard' ), 'dashicons-networking', 26 );
        add_submenu_page( 'amaley-core', 'Dashboard', 'Dashboard', 'manage_options', 'amaley-core', array( $this, 'render_dashboard' ) );
        add_submenu_page( 'amaley-core', 'Product Origin Mapping', 'Product Origin Mapping', 'manage_options', 'amaley-core-origin-mapping', array( $this, 'render_origin_mapping_page' ) );
        add_submenu_page( 'amaley-core', 'Settings', 'Settings', 'manage_options', 'amaley-core-settings', array( $this, 'render_settings_page' ) );
    }

    public function render_dashboard() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        echo '<div class="wrap amaley-core-wrap"><h1>Amaley Core Dashboard</h1><p class="amaley-core-lead">Cluster → SHG Group → Member / Producer → Product Origin backbone for Amaley.</p><div class="amaley-core-cards">';
        $this->render_stat_card( 'Total Clusters', $this->count_posts( 'amaley_cluster' ) );
        $this->render_stat_card( 'Total SHG Groups', $this->count_posts( 'amaley_shg_group' ) );
        $this->render_stat_card( 'Total Members / Producers', $this->count_posts( 'amaley_member' ) );
        $this->render_stat_card( 'Products with Origin', $this->count_products_with_origin() );
        $this->render_stat_card( 'Schema Version', AMALEY_CORE_SCHEMA_VERSION );
        echo '</div><div class="amaley-core-panel"><h2>Locked Structure</h2><pre>Cluster\n  └── Multiple SHG Groups\n        └── Multiple Members / Producers\n\nWooCommerce Product\n  └── One Primary Cluster\n  └── One or Multiple SHG Groups\n  └── Optional Members / Producers</pre></div></div>';
    }

    public function render_origin_mapping_page() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        echo '<div class="wrap amaley-core-wrap"><h1>Product Origin Mapping</h1>';
        if ( ! post_type_exists( 'product' ) ) { echo '<div class="notice notice-warning inline"><p>WooCommerce product post type was not found. Activate WooCommerce to use product origin mapping.</p></div></div>'; return; }
        $products = get_posts( array( 'post_type' => 'product', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 100, 'orderby' => 'date', 'order' => 'DESC' ) );
        echo '<p>Showing latest 100 products. Edit a product to manage Amaley Origin Mapping.</p><table class="widefat striped amaley-core-table"><thead><tr><th>Product</th><th>Cluster</th><th>SHGs</th><th>Members</th><th>Status</th><th>Edit</th></tr></thead><tbody>';
        if ( empty( $products ) ) { echo '<tr><td colspan="6">No products found.</td></tr>'; }
        foreach ( $products as $product ) {
            $cluster_id = absint( get_post_meta( $product->ID, '_amaley_origin_cluster_id', true ) );
            echo '<tr><td>' . esc_html( get_the_title( $product ) ) . '</td><td>' . esc_html( $cluster_id ? get_the_title( $cluster_id ) : '—' ) . '</td><td>' . esc_html( $this->names_from_ids( get_post_meta( $product->ID, '_amaley_origin_shg_ids', true ) ) ) . '</td><td>' . esc_html( $this->names_from_ids( get_post_meta( $product->ID, '_amaley_origin_member_ids', true ) ) ) . '</td><td>' . esc_html( $cluster_id ? 'Mapped' : 'Missing Cluster' ) . '</td><td><a href="' . esc_url( get_edit_post_link( $product->ID ) ) . '">Edit</a></td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }

        if ( isset( $_POST['amaley_core_template_settings_action'] ) && check_admin_referer( 'amaley_core_save_template_settings', 'amaley_core_settings_nonce' ) ) {
            if ( 'reset' === sanitize_text_field( wp_unslash( $_POST['amaley_core_template_settings_action'] ) ) ) {
                delete_option( $this->settings_option );
                echo '<div class="notice notice-success is-dismissible"><p>Template settings reset to safe defaults.</p></div>';
            } else {
                update_option( $this->settings_option, $this->sanitize_template_settings( isset( $_POST['amaley_core_template_settings'] ) ? wp_unslash( $_POST['amaley_core_template_settings'] ) : array() ), false );
                echo '<div class="notice notice-success is-dismissible"><p>Template settings saved. Elementor/shortcode output will use these as default values.</p></div>';
            }
        }

        $settings = $this->get_template_settings();
        echo '<div class="wrap amaley-core-wrap"><h1>Amaley Core Settings</h1>';
        echo '<div class="amaley-core-panel"><h2>Version</h2><p><strong>Plugin Version:</strong> ' . esc_html( AMALEY_CORE_VERSION ) . '</p><p><strong>Data Schema Version:</strong> ' . esc_html( AMALEY_CORE_SCHEMA_VERSION ) . '</p></div>';
        echo '<div class="amaley-core-panel"><h2>Non-Coder Rule</h2><p>Cluster, SHG, Member and Product Origin data must remain manageable from WordPress admin without code editing. This page now controls default template copy and section visibility for Amaley Core archive/detail widgets.</p></div>';
        echo '<div class="amaley-core-panel"><h2>Safe Page Setup</h2><p><strong>Recommended live setup:</strong> create normal WordPress pages, design them with section-wise Elementor widgets, then assign their role below. This keeps the system editable without touching theme, WooCommerce, header, footer, routes or PHP templates.</p><ol><li><strong>Cluster Archive page:</strong> add archive section widgets such as Hero, Trust Strip, Intro, Grid and CTA.</li><li><strong>Cluster Single Template page:</strong> later add single section widgets such as Single Hero, Snapshot, Story, Related SHGs, Producers and Products.</li><li><strong>Archive card links:</strong> the Grid widget can automatically use the assigned Single Template page.</li></ol><p class="description">Clean permalink routes can be added later after design and data are stable.</p></div>';

        echo '<form method="post" action="">';
        wp_nonce_field( 'amaley_core_save_template_settings', 'amaley_core_settings_nonce' );
        echo '<input type="hidden" name="amaley_core_template_settings_action" value="save" />';

        echo '<div class="amaley-core-panel"><h2>Page Template Assignment</h2><p class="description">Assign normal WordPress pages to Amaley roles. You can design those pages in Elementor using section-wise widgets. This is safer than theme templates and avoids creating one page per cluster.</p>';
        echo '<h3>Cluster Pages</h3>';
        $this->page_dropdown_field( $settings, 'cluster_archive_page_id', 'Cluster Archive Page' );
        $this->page_dropdown_field( $settings, 'cluster_single_page_id', 'Cluster Single Template Page' );
        $this->select_field( $settings, 'cluster_detail_param_mode', 'Single Page URL Parameter', array( 'slug' => 'cluster_slug — recommended', 'id' => 'cluster_id — numeric ID' ) );
        echo '<p class="description"><strong>Generated cluster detail pattern:</strong> <code>' . esc_html( $this->cluster_detail_pattern_preview( $settings ) ) . '</code></p>';
        echo '<p class="description">Archive Grid cards will use the assigned Single Template Page when its widget setting <strong>Use Assigned Single Template Page</strong> is enabled.</p>';
        echo '<h3>Future Page Assignments</h3><p class="description">These are saved now for consistency, but SHG/Producer archive and single section widgets will be built in the next phases.</p>';
        $this->page_dropdown_field( $settings, 'shg_archive_page_id', 'SHG Archive Page' );
        $this->page_dropdown_field( $settings, 'shg_single_page_id', 'SHG Single Template Page' );
        $this->page_dropdown_field( $settings, 'producer_archive_page_id', 'Producer Archive Page' );
        $this->page_dropdown_field( $settings, 'producer_single_page_id', 'Producer Single Template Page' );
        echo '</div>';

        $this->render_card_assignment_panel( $settings );

        echo '<div class="amaley-core-panel"><h2>Cluster Archive Template Defaults</h2><p class="description">These values are used by <code>[amaley_cluster_archive_page]</code> and the Elementor Cluster Archive Page widget unless overridden inside Elementor.</p>';
        $this->text_field( $settings, 'archive_title', 'Hero Title' );
        $this->text_field( $settings, 'archive_title_accent', 'Hero Accent Word' );
        $this->text_field( $settings, 'archive_kicker', 'Hero Eyebrow / Label' );
        $this->textarea_field( $settings, 'archive_subtitle', 'Hero Subtitle' );
        $this->text_field( $settings, 'archive_breadcrumb_home_url', 'Breadcrumb Home URL' );
        $this->text_field( $settings, 'archive_breadcrumb_middle', 'Breadcrumb Middle Label' );
        $this->text_field( $settings, 'archive_breadcrumb_middle_url', 'Breadcrumb Middle URL' );
        $this->text_field( $settings, 'archive_detail_url_pattern', 'Archive Card Detail URL Pattern' );
        echo '<p class="description">Fallback only. If Cluster Single Template Page is assigned, the Archive Grid can generate detail links automatically. Supported tokens: <code>{id}</code>, <code>{slug}</code>.</p>';
        $this->text_field( $settings, 'archive_intro_title', 'Why Clusters Matter Heading' );
        $this->textarea_field( $settings, 'archive_intro_text', 'Why Clusters Matter Text' );
        $this->text_field( $settings, 'archive_trace_title', 'Traceability Heading' );
        $this->textarea_field( $settings, 'archive_trace_text', 'Traceability Text' );
        $this->text_field( $settings, 'archive_list_title', 'Archive List Heading' );
        $this->textarea_field( $settings, 'archive_list_text', 'Archive List Text' );
        $this->text_field( $settings, 'archive_cta_title', 'CTA Heading' );
        $this->textarea_field( $settings, 'archive_cta_text', 'CTA Text' );
        $this->text_field( $settings, 'archive_cta_button_text', 'CTA Button Text' );
        $this->text_field( $settings, 'archive_cta_button_url', 'CTA Button URL' );
        echo '<h3>Archive Section Visibility</h3>';
        $this->checkbox_field( $settings, 'archive_show_hero', 'Show Hero' );
        $this->checkbox_field( $settings, 'archive_show_trust_strip', 'Show Trust Strip' );
        $this->checkbox_field( $settings, 'archive_show_intro', 'Show Why Clusters Matter Section' );
        $this->checkbox_field( $settings, 'archive_show_traceability', 'Show Traceability Section' );
        $this->checkbox_field( $settings, 'archive_show_featured_cluster', 'Show Featured Cluster Block' );
        $this->checkbox_field( $settings, 'archive_show_cta', 'Show Bottom CTA' );
        echo '</div>';

        echo '<div class="amaley-core-panel"><h2>Cluster Single Template Defaults</h2><p class="description">These values are used by <code>[amaley_cluster_single_page]</code> and the Elementor Cluster Single Page widget unless overridden inside Elementor.</p>';
        $this->text_field( $settings, 'single_kicker', 'Hero Eyebrow / Label' );
        $this->text_field( $settings, 'single_breadcrumb_home_url', 'Breadcrumb Home URL' );
        $this->text_field( $settings, 'single_breadcrumb_middle', 'Breadcrumb Middle Label' );
        $this->text_field( $settings, 'single_breadcrumb_middle_url', 'Breadcrumb Middle URL' );
        echo '<p class="description">Recommended: <code>/clusters/</code> so breadcrumb returns to the archive page.</p>';
        $this->text_field( $settings, 'single_button_text', 'Main Button Text' );
        $this->text_field( $settings, 'single_button_url', 'Main Button URL' );
        echo '<h3>Single Page Section Visibility</h3>';
        $this->checkbox_field( $settings, 'single_show_hero', 'Show Hero' );
        $this->checkbox_field( $settings, 'single_show_trust_strip', 'Show Trust Strip' );
        $this->checkbox_field( $settings, 'single_show_snapshot', 'Show Snapshot' );
        $this->checkbox_field( $settings, 'single_show_story', 'Show Story' );
        $this->checkbox_field( $settings, 'single_show_villages', 'Show Villages' );
        $this->checkbox_field( $settings, 'single_show_shgs', 'Show Linked SHGs' );
        $this->checkbox_field( $settings, 'single_show_members', 'Show Linked Members / Producers' );
        $this->checkbox_field( $settings, 'single_show_products', 'Show Linked Products' );
        $this->checkbox_field( $settings, 'single_show_journey', 'Show Origin Journey' );
        $this->checkbox_field( $settings, 'single_show_gallery', 'Show Gallery' );
        $this->checkbox_field( $settings, 'single_show_cta', 'Show CTA' );
        echo '</div>';

        submit_button( 'Save Template Settings' );
        echo '</form>';
        echo '<form method="post" action="" style="margin-top:10px;">';
        wp_nonce_field( 'amaley_core_save_template_settings', 'amaley_core_settings_nonce' );
        echo '<input type="hidden" name="amaley_core_template_settings_action" value="reset" />';
        submit_button( 'Reset Template Settings', 'secondary', 'submit', false );
        echo '</form>';
        echo '</div>';
    }

    public function get_template_settings() {
        $defaults = $this->template_settings_defaults();
        $saved = get_option( $this->settings_option, array() );
        return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
    }

    private function template_settings_defaults() {
        return array(
            'cluster_archive_page_id' => '0',
            'cluster_single_page_id' => '0',
            'cluster_detail_param_mode' => 'slug',
            'shg_archive_page_id' => '0',
            'shg_single_page_id' => '0',
            'producer_archive_page_id' => '0',
            'producer_single_page_id' => '0',
            // v1.0.85 Simple family-level card templates.
            'card_template_cluster' => 'og_cluster_card_1',
            'card_template_shg' => 'og_shg_card_1',
            'card_template_member' => 'og_member_card_1',
            'card_template_product' => 'og_product_card_1',

            // Legacy internal location keys retained only for backward compatibility. Hidden from UI.
            'card_product_discovery_grid' => 'og_product_card_1',
            'card_product_member_single_products' => 'og_product_card_1',
            'card_product_shg_single_products' => 'og_product_card_1',
            'card_product_cluster_single_products' => 'og_product_card_1',
            'card_product_home_sections' => 'og_product_card_1',
            'card_shg_member_single_linked' => 'og_shg_card_1',
            'card_shg_cluster_single_list' => 'og_shg_card_1',
            'card_shg_archive' => 'og_shg_card_1',
            'card_shg_ecosystem_sections' => 'og_shg_card_1',
            'card_cluster_member_single_linked' => 'og_cluster_card_1',
            'card_cluster_archive' => 'og_cluster_card_1',
            'card_cluster_shg_single_linked' => 'og_cluster_card_1',
            'card_cluster_ecosystem_sections' => 'og_cluster_card_1',
            'card_member_shg_single_members' => 'og_member_card_1',
            'card_member_archive' => 'og_member_card_1',
            'card_member_cluster_producers' => 'og_member_card_1',
            'card_member_ecosystem_sections' => 'og_member_card_1',
            'archive_title' => 'Browse Amaley Source Clusters',
            'archive_title_accent' => 'Source',
            'archive_kicker' => 'Origin Directory',
            'archive_subtitle' => 'A clean directory of source clusters connected with women collectives, producer families and mapped Amaley products.',
            'archive_breadcrumb_home_url' => '/',
            'archive_breadcrumb_middle' => 'Shop',
            'archive_breadcrumb_middle_url' => '/shop/',
            'archive_detail_url_pattern' => '/cluster-detail/?cluster_slug={slug}',
            'archive_intro_title' => 'Amaley is not just a shelf of products.',
            'archive_intro_text' => 'Products come from local ingredients, women collectives, household skills, seasonal rhythms and geographies that shape what can be made well.',
            'archive_trace_title' => 'From cluster to SHG to member to product.',
            'archive_trace_text' => 'The product is the commercial face, but its origin remains legible through cluster, collective and maker connections.',
            'archive_list_title' => 'Browse clusters by state and geography',
            'archive_list_text' => 'Open a cluster to see its detailed page, linked SHGs, members, traceable products and deeper origin viewing.',
            'archive_cta_title' => 'Cluster visibility helps customers and partners buy better.',
            'archive_cta_text' => 'Use cluster visibility to build story-rich product sets, hospitality counters, curated shelves and origin-led retail experiences.',
            'archive_cta_button_text' => 'Explore Amaley Products',
            'archive_cta_button_url' => '/shop/',
            'archive_show_hero' => '1',
            'archive_show_trust_strip' => '1',
            'archive_show_intro' => '1',
            'archive_show_traceability' => '1',
            'archive_show_featured_cluster' => '1',
            'archive_show_cta' => '1',
            'single_kicker' => 'Source Cluster',
            'single_breadcrumb_home_url' => '/',
            'single_breadcrumb_middle' => 'Clusters',
            'single_breadcrumb_middle_url' => '/clusters/',
            'single_button_text' => 'Explore Related Products',
            'single_button_url' => '/shop/',
            'single_show_hero' => '1',
            'single_show_trust_strip' => '1',
            'single_show_snapshot' => '1',
            'single_show_story' => '1',
            'single_show_villages' => '1',
            'single_show_shgs' => '1',
            'single_show_members' => '1',
            'single_show_products' => '1',
            'single_show_journey' => '1',
            'single_show_gallery' => '1',
            'single_show_cta' => '1',
        );
    }

    private function sanitize_template_settings( $raw ) {
        $defaults = $this->template_settings_defaults();
        $clean = array();
        foreach ( $defaults as $key => $default ) {
            if ( 0 === strpos( $key, 'archive_show_' ) || 0 === strpos( $key, 'single_show_' ) ) {
                $clean[ $key ] = isset( $raw[ $key ] ) ? '1' : '0';
                continue;
            }
            if ( false !== strpos( $key, '_page_id' ) ) {
                $clean[ $key ] = isset( $raw[ $key ] ) ? (string) absint( $raw[ $key ] ) : '0';
                continue;
            }
            if ( 0 === strpos( $key, 'card_' ) && class_exists( 'Amaley_Core_Card_Registry' ) ) {
                $family = Amaley_Core_Card_Registry::family_from_assignment_key( $key );
                $value = isset( $raw[ $key ] ) ? sanitize_key( $raw[ $key ] ) : (string) $default;
                $clean[ $key ] = Amaley_Core_Card_Registry::is_valid_preset( $family, $value ) ? $value : (string) $default;
                continue;
            }
            if ( 'cluster_detail_param_mode' === $key ) {
                $mode = isset( $raw[ $key ] ) ? sanitize_key( $raw[ $key ] ) : 'slug';
                $clean[ $key ] = in_array( $mode, array( 'slug', 'id' ), true ) ? $mode : 'slug';
                continue;
            }
            $value = isset( $raw[ $key ] ) ? $raw[ $key ] : $default;
            if ( false !== strpos( $key, '_url' ) ) {
                $clean[ $key ] = esc_url_raw( $value );
            } elseif ( false !== strpos( $key, '_text' ) || false !== strpos( $key, 'subtitle' ) ) {
                $clean[ $key ] = sanitize_textarea_field( $value );
            } else {
                $clean[ $key ] = sanitize_text_field( $value );
            }
        }
        return $clean;
    }

    private function text_field( $settings, $key, $label ) {
        echo '<div class="amaley-core-field"><label for="amaley-core-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label><input type="text" id="amaley-core-' . esc_attr( $key ) . '" name="amaley_core_template_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( isset( $settings[ $key ] ) ? $settings[ $key ] : '' ) . '" /></div>';
    }

    private function textarea_field( $settings, $key, $label ) {
        echo '<div class="amaley-core-field"><label for="amaley-core-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label><textarea id="amaley-core-' . esc_attr( $key ) . '" name="amaley_core_template_settings[' . esc_attr( $key ) . ']" rows="4">' . esc_textarea( isset( $settings[ $key ] ) ? $settings[ $key ] : '' ) . '</textarea></div>';
    }

    private function checkbox_field( $settings, $key, $label ) {
        echo '<div class="amaley-core-field"><label class="amaley-core-inline-check"><input type="checkbox" name="amaley_core_template_settings[' . esc_attr( $key ) . ']" value="1" ' . checked( '1', isset( $settings[ $key ] ) ? $settings[ $key ] : '0', false ) . ' /> ' . esc_html( $label ) . '</label></div>';
    }

    private function page_dropdown_field( $settings, $key, $label ) {
        $current = absint( isset( $settings[ $key ] ) ? $settings[ $key ] : 0 );
        $pages = get_posts( array(
            'post_type' => 'page',
            'post_status' => array( 'publish', 'draft', 'private' ),
            'posts_per_page' => 200,
            'orderby' => 'title',
            'order' => 'ASC',
        ) );
        echo '<div class="amaley-core-field"><label for="amaley-core-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label><select id="amaley-core-' . esc_attr( $key ) . '" name="amaley_core_template_settings[' . esc_attr( $key ) . ']">';
        echo '<option value="0">— Select Page —</option>';
        foreach ( $pages as $page ) {
            echo '<option value="' . esc_attr( $page->ID ) . '" ' . selected( $current, $page->ID, false ) . '>' . esc_html( get_the_title( $page ) ) . ' — /' . esc_html( $page->post_name ) . '/</option>';
        }
        echo '</select></div>';
    }

    private function select_field( $settings, $key, $label, $options ) {
        $current = isset( $settings[ $key ] ) ? (string) $settings[ $key ] : '';
        echo '<div class="amaley-core-field"><label for="amaley-core-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label><select id="amaley-core-' . esc_attr( $key ) . '" name="amaley_core_template_settings[' . esc_attr( $key ) . ']">';
        foreach ( $options as $value => $text ) {
            echo '<option value="' . esc_attr( $value ) . '" ' . selected( $current, (string) $value, false ) . '>' . esc_html( $text ) . '</option>';
        }
        echo '</select></div>';
    }

    private function cluster_detail_pattern_preview( $settings ) {
        $single_id = absint( isset( $settings['cluster_single_page_id'] ) ? $settings['cluster_single_page_id'] : 0 );
        $mode = isset( $settings['cluster_detail_param_mode'] ) && 'id' === $settings['cluster_detail_param_mode'] ? 'id' : 'slug';
        if ( $single_id && get_post_status( $single_id ) ) {
            $base = get_permalink( $single_id );
            if ( $base ) {
                $separator = false === strpos( $base, '?' ) ? '?' : '&';
                return $base . $separator . ( 'id' === $mode ? 'cluster_id={id}' : 'cluster_slug={slug}' );
            }
        }
        return isset( $settings['archive_detail_url_pattern'] ) && $settings['archive_detail_url_pattern'] ? $settings['archive_detail_url_pattern'] : '/cluster-detail/?cluster_slug={slug}';
    }


    /**
     * Render Card Templates & Assignments panel.
     *
     * v1.0.79: settings-only base. Existing frontend widgets are not switched to the card library yet.
     *
     * @param array $settings Settings.
     * @return void
     */
    private function render_card_assignment_panel( $settings ) {
        if ( ! class_exists( 'Amaley_Core_Card_Registry' ) ) {
            return;
        }

        echo '<div class="amaley-core-panel"><h2>Card Templates</h2>';
        echo '<p class="description"><strong>Simple model:</strong> one approved OG card template per family. More templates will be added only later if a new design is approved. Section widgets can later choose Current/Existing Card or the family OG card.</p>';

        echo '<div class="amaley-core-card-assignment-family">';
        echo '<h3>Cluster</h3>';
        $this->card_assignment_select_field( $settings, 'card_template_cluster', 'Cluster Card Temp', 'cluster' );
        echo '</div>';

        echo '<div class="amaley-core-card-assignment-family">';
        echo '<h3>SHGs</h3>';
        $this->card_assignment_select_field( $settings, 'card_template_shg', 'SHG Card Temp', 'shg' );
        echo '</div>';

        echo '<div class="amaley-core-card-assignment-family">';
        echo '<h3>Member</h3>';
        $this->card_assignment_select_field( $settings, 'card_template_member', 'Member Card Temp', 'member' );
        echo '</div>';

        echo '<div class="amaley-core-card-assignment-family">';
        echo '<h3>Product</h3>';
        $this->card_assignment_select_field( $settings, 'card_template_product', 'Product Card Temp', 'product' );
        echo '</div>';

        echo '<p class="description"><strong>Safety:</strong> this screen only stores the family-level default template. Existing pages do not change automatically. Old section-wise assignment keys are kept internally only for backward compatibility.</p>';
        echo '</div>';
    }

    /**
     * Render one card assignment select field.
     *
     * @param array  $settings Settings.
     * @param string $key Setting key.
     * @param string $label Label.
     * @param string $family Card family.
     * @return void
     */
    private function card_assignment_select_field( $settings, $key, $label, $family ) {
        $options = class_exists( 'Amaley_Core_Card_Registry' ) ? Amaley_Core_Card_Registry::preset_options_for_family( $family ) : array();
        $current = isset( $settings[ $key ] ) ? (string) $settings[ $key ] : '';
        echo '<div class="amaley-core-field amaley-core-card-assignment-field"><label for="amaley-core-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label><select id="amaley-core-' . esc_attr( $key ) . '" name="amaley_core_template_settings[' . esc_attr( $key ) . ']">';
        foreach ( $options as $value => $text ) {
            echo '<option value="' . esc_attr( $value ) . '" ' . selected( $current, (string) $value, false ) . '>' . esc_html( $text ) . '</option>';
        }
        echo '</select></div>';
    }


    private function render_stat_card( $label, $value ) { echo '<div class="amaley-core-card"><span>' . esc_html( $label ) . '</span><strong>' . esc_html( $value ) . '</strong></div>'; }
    private function count_posts( $post_type ) { $counts = wp_count_posts( $post_type ); return isset( $counts->publish ) ? absint( $counts->publish ) : 0; }
    private function count_products_with_origin() {
        if ( ! post_type_exists( 'product' ) ) { return 0; }
        $query = new WP_Query( array( 'post_type' => 'product', 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1, 'fields' => 'ids', 'meta_query' => array( array( 'key' => '_amaley_origin_cluster_id', 'value' => '0', 'compare' => '>', 'type' => 'NUMERIC' ) ) ) );
        return absint( $query->found_posts );
    }
    private function names_from_ids( $ids ) {
        $ids = array_filter( array_map( 'absint', (array) $ids ) );
        if ( empty( $ids ) ) { return '—'; }
        $names = array(); foreach ( $ids as $id ) { $names[] = get_the_title( $id ); }
        return implode( ', ', array_filter( $names ) );
    }
}
