<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\\Elementor\\Widget_Base' ) ) { return; }
if ( class_exists( 'AHFS2_Header_Live_Widget' ) ) { return; }

abstract class AHFS2_Elementor_Base_Widget extends \Elementor\Widget_Base {
    protected function link_list_array( $text ) {
        $items = array();
        foreach ( explode( "\n", (string) $text ) as $line ) {
            $parts = array_map( 'trim', explode( '|', $line, 2 ) );
            if ( empty( $parts[0] ) ) { continue; }
            $items[] = array( 'label' => $parts[0], 'url' => $parts[1] ?? '#' );
        }
        return $items;
    }

    protected function yes( array $settings, $key, $default = 'yes' ) {
        if ( ! array_key_exists( $key, $settings ) ) {
            return 'yes' === $default;
        }
        return 'yes' === $settings[ $key ];
    }

    protected function switcher( $key, $label, $default = 'yes', $description = '' ) {
        $args = array(
            'label'        => $label,
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Show',
            'label_off'    => 'Hide',
            'return_value' => 'yes',
            'default'      => $default,
        );
        if ( $description ) {
            $args['description'] = $description;
        }
        $this->add_control( $key, $args );
    }

    protected function inline_css_once() {
        static $done = false;
        if ( $done ) { return; }
        $done = true;
        ?>
        <style id="ahfs2-widget-inline-css">
        .ahfs2-header-widget,.ahfs2-header-widget *{box-sizing:border-box}.ahfs2-header-widget{width:100%;max-width:100%;font-family:var(--ahfs2-font-body,Arial,sans-serif);color:var(--ahfs2-text,#2e1203);background:var(--ahfs2-header-bg,#fff8ee);position:relative;z-index:20}.ahfs2-top-strip{background:var(--ahfs2-strip-bg,#2e1203);color:var(--ahfs2-strip-color,#fff8ee);min-height:34px;display:flex;align-items:center;justify-content:center;padding:0 18px;font:700 12px/1.2 var(--ahfs2-font-body,Arial,sans-serif)}.ahfs2-strip-grid{width:min(1120px,100%);display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));align-items:center;text-align:center}.ahfs2-strip-grid span{display:flex;align-items:center;justify-content:center;gap:6px;min-height:18px;padding:0 10px}.ahfs2-strip-grid span+span{border-left:1px solid rgba(255,248,238,.18)}.ahfs2-live-header{display:grid;grid-template-columns:220px 1fr auto;align-items:center;gap:28px;background:var(--ahfs2-header-bg,#fff8ee);color:var(--ahfs2-text,#2e1203);padding:var(--ahfs2-pad,12px 32px);border-bottom:1px solid rgba(46,18,3,.16);min-height:128px;width:100%}.ahfs2-live-header.ahfs2-no-logo{grid-template-columns:1fr auto}.ahfs2-live-header.ahfs2-no-menu{grid-template-columns:220px auto;justify-content:space-between}.ahfs2-live-header.ahfs2-no-icons{grid-template-columns:220px 1fr}.ahfs2-live-header.ahfs2-no-logo.ahfs2-no-menu{grid-template-columns:auto;justify-content:end}.ahfs2-live-header.ahfs2-no-logo.ahfs2-no-icons{grid-template-columns:1fr}.ahfs2-live-header.ahfs2-no-menu.ahfs2-no-icons{grid-template-columns:auto}.ahfs2-logo{display:inline-flex;align-items:center;justify-content:center;text-decoration:none;color:var(--ahfs2-text,#2e1203);font:800 28px/1 var(--ahfs2-font-heading,Georgia,serif);letter-spacing:.19em;white-space:nowrap;min-width:0}.ahfs2-logo img{display:block;width:var(--ahfs2-logo-width,132px);height:auto;max-height:104px;object-fit:contain}.ahfs2-nav{display:flex;align-items:center;justify-content:center;gap:30px;min-width:0;flex-wrap:nowrap}.ahfs2-nav a{color:var(--ahfs2-text,#2e1203);text-decoration:none;font:800 13px/1.2 var(--ahfs2-font-body,Arial,sans-serif);letter-spacing:.04em;text-transform:uppercase;white-space:nowrap}.ahfs2-nav a:hover{color:var(--ahfs2-accent,#c2880a)}.ahfs2-icons{display:flex;align-items:center;justify-content:flex-end;gap:10px;white-space:nowrap}.ahfs2-icons a,.ahfs2-menu-toggle{position:relative;color:var(--ahfs2-text,#2e1203);background:rgba(255,255,255,.18);border:1px solid rgba(46,18,3,.16);text-decoration:none;width:37px;height:37px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;font:700 15px/1 Arial,sans-serif;cursor:pointer}.ahfs2-icons a:hover,.ahfs2-menu-toggle:hover{border-color:var(--ahfs2-accent,#c2880a);color:var(--ahfs2-accent,#c2880a)}.ahfs2-cart b,.ahfs2-wishlist b{position:absolute;top:-8px;right:-5px;min-width:18px;height:18px;border-radius:18px;background:var(--ahfs2-accent,#c2880a);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:10px}.ahfs2-cart-amount{border:0!important;background:transparent!important;width:auto!important;padding:0 0 0 8px!important;border-radius:0!important;font-size:13px!important;font-weight:800!important;color:var(--ahfs2-text,#2e1203)!important}.ahfs2-menu-toggle{display:none}.ahfs2-mobile-drawer{position:fixed;inset:0 0 0 auto;width:min(86vw,360px);z-index:99999;background:#fff8ee;box-shadow:-20px 0 40px rgba(0,0,0,.18);padding:24px}.ahfs2-mobile-drawer nav{display:grid;gap:14px;margin-top:30px}.ahfs2-mobile-drawer a{color:#2e1203;text-decoration:none;font:700 16px/1.3 Arial,sans-serif}.ahfs2-drawer-close{border:0;background:#2e1203;color:#fff8ee;border-radius:100px;width:38px;height:38px;font-size:24px;float:right}.ahfs2-footer-widget,.ahfs2-footer-widget *{box-sizing:border-box}.ahfs2-footer-widget{background:var(--ahfs2-footer-bg,#2e1203);color:var(--ahfs2-footer-text,#fff8ee);padding:var(--ahfs2-footer-pad,56px 32px 26px);font-family:var(--ahfs2-font-body,Arial,sans-serif);width:100%;max-width:100%}.ahfs2-footer-grid{display:grid;grid-template-columns:1.55fr .9fr .9fr 1.15fr;gap:70px;max-width:1060px;margin:0 auto}.ahfs2-footer-grid.ahfs2-footer-cols-1{grid-template-columns:1fr}.ahfs2-footer-grid.ahfs2-footer-cols-2{grid-template-columns:repeat(2,1fr)}.ahfs2-footer-grid.ahfs2-footer-cols-3{grid-template-columns:repeat(3,1fr)}.ahfs2-footer-brand h2,.ahfs2-footer-widget h3{font-family:var(--ahfs2-font-heading,Georgia,serif);color:var(--ahfs2-footer-text,#fff8ee);margin:0 0 20px}.ahfs2-footer-brand h2{letter-spacing:.20em;font-size:26px}.ahfs2-footer-widget h3{font-size:16px;text-transform:uppercase;letter-spacing:.18em;color:var(--ahfs2-accent,#c2880a)}.ahfs2-footer-widget p{margin:0;color:var(--ahfs2-footer-text,#fff8ee);line-height:1.75}.ahfs2-footer-brand .ahfs2-kicker{color:var(--ahfs2-accent,#c2880a);font-weight:800;letter-spacing:.18em;text-transform:uppercase;font-size:12px;margin:22px 0 18px}.ahfs2-footer-widget ul{list-style:none;margin:0;padding:0;display:grid;gap:14px}.ahfs2-footer-widget a{color:var(--ahfs2-footer-text,#fff8ee);text-decoration:none}.ahfs2-footer-widget a:hover{color:var(--ahfs2-accent,#c2880a)}.ahfs2-footer-phone{font-size:22px;font-weight:800;margin-bottom:18px!important}.ahfs2-footer-bottom{max-width:1060px;margin:36px auto 0;padding-top:18px;border-top:1px solid rgba(255,248,238,.18);display:flex;justify-content:space-between;gap:18px;font-size:12px}@media(max-width:1100px){.ahfs2-live-header{grid-template-columns:170px 1fr auto;gap:18px;padding:12px 20px}.ahfs2-live-header.ahfs2-no-logo{grid-template-columns:1fr auto}.ahfs2-live-header.ahfs2-no-menu{grid-template-columns:170px auto}.ahfs2-nav{gap:18px}.ahfs2-nav a{font-size:12px}.ahfs2-footer-grid{gap:38px}}@media(max-width:980px){.ahfs2-top-strip{justify-content:flex-start;overflow-x:auto;padding:0 12px}.ahfs2-strip-grid{display:flex;width:max-content;min-width:100%;gap:0}.ahfs2-strip-grid span{padding:0 18px;white-space:nowrap}.ahfs2-live-header,.ahfs2-live-header.ahfs2-no-logo,.ahfs2-live-header.ahfs2-no-menu,.ahfs2-live-header.ahfs2-no-icons{grid-template-columns:1fr auto;min-height:82px;padding:10px 16px}.ahfs2-logo{justify-content:flex-start}.ahfs2-logo img{width:min(var(--ahfs2-logo-width,132px),112px);max-height:70px}.ahfs2-nav{display:none}.ahfs2-icons a:not(.ahfs2-cart){display:none}.ahfs2-cart-amount{display:none!important}.ahfs2-menu-toggle{display:inline-flex}.ahfs2-footer-grid,.ahfs2-footer-grid.ahfs2-footer-cols-1,.ahfs2-footer-grid.ahfs2-footer-cols-2,.ahfs2-footer-grid.ahfs2-footer-cols-3{grid-template-columns:1fr 1fr;gap:34px}.ahfs2-footer-bottom{flex-direction:column}}@media(max-width:640px){.ahfs2-live-header,.ahfs2-live-header.ahfs2-no-logo,.ahfs2-live-header.ahfs2-no-menu,.ahfs2-live-header.ahfs2-no-icons{min-height:72px}.ahfs2-logo{font-size:18px;letter-spacing:.12em}.ahfs2-logo img{width:min(var(--ahfs2-logo-width,132px),94px)}.ahfs2-icons{gap:8px}.ahfs2-icons a,.ahfs2-menu-toggle{width:34px;height:34px}.ahfs2-footer-grid,.ahfs2-footer-grid.ahfs2-footer-cols-1,.ahfs2-footer-grid.ahfs2-footer-cols-2,.ahfs2-footer-grid.ahfs2-footer-cols-3{grid-template-columns:1fr;gap:28px}.ahfs2-footer-widget{padding:42px 22px 24px}.ahfs2-footer-bottom{gap:8px}.ahfs2-footer-brand h2{font-size:22px}}
        </style>
        <?php
    }
}

final class AHFS2_Header_Live_Widget extends AHFS2_Elementor_Base_Widget {
    public function get_name() { return 'ahfs2_header_live'; }
    public function get_title() { return 'Amaley Header - Live Style'; }
    public function get_icon() { return 'eicon-header'; }
    public function get_categories() { return array( 'ahfs2' ); }
    public function get_keywords() { return array( 'amaley', 'header', 'hf' ); }

    protected function register_controls() {
        $this->start_controls_section( 'visibility', array( 'label' => 'Hide / Show Controls' ) );
        $this->add_control( 'visibility_note', array( 'type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => '<strong>No-coder controls:</strong> Turn sections/elements on or off from here. Style controls will come in the next step.' ) );
        $this->switcher( 'show_strip', 'Top Announcement Strip', 'yes' );
        $this->switcher( 'show_strip_1', 'Strip Item 1', 'yes' );
        $this->switcher( 'show_strip_2', 'Strip Item 2', 'yes' );
        $this->switcher( 'show_strip_3', 'Strip Item 3', 'yes' );
        $this->switcher( 'show_strip_4', 'Strip Item 4', 'yes' );
        $this->switcher( 'show_main_header', 'Main Header Row', 'yes' );
        $this->switcher( 'show_logo', 'Logo Area', 'yes' );
        $this->switcher( 'show_menu', 'Desktop Menu', 'yes' );
        $this->switcher( 'show_icons_area', 'Right Icons Area', 'yes' );
        $this->switcher( 'show_search', 'Search Icon', 'yes' );
        $this->switcher( 'show_account', 'Account Icon', 'yes' );
        $this->switcher( 'show_wishlist', 'Wishlist Icon', 'yes' );
        $this->switcher( 'show_wishlist_badge', 'Wishlist Badge Count', 'yes' );
        $this->switcher( 'show_cart', 'Cart Icon', 'yes' );
        $this->switcher( 'show_cart_badge', 'Cart Badge Count', 'yes' );
        $this->switcher( 'show_cart_amount', 'Cart Amount Text', 'yes' );
        $this->switcher( 'show_mobile_toggle', 'Mobile Menu Button', 'yes' );
        $this->switcher( 'show_mobile_drawer', 'Mobile Drawer', 'yes' );
        $this->switcher( 'show_mobile_drawer_close', 'Mobile Drawer Close Button', 'yes' );
        $this->switcher( 'show_mobile_drawer_menu', 'Mobile Drawer Menu Items', 'yes' );
        $this->end_controls_section();

        $this->start_controls_section( 'content', array( 'label' => 'Header Content' ) );
        $this->add_control( 'strip_1', array( 'label' => 'Strip Item 1 Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🌿 Made in the Himalayas' ) );
        $this->add_control( 'strip_2', array( 'label' => 'Strip Item 2 Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🚚 Free Shipping on Orders ₹99+' ) );
        $this->add_control( 'strip_3', array( 'label' => 'Strip Item 3 Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🎁 Thoughtful Gifts' ) );
        $this->add_control( 'strip_4', array( 'label' => 'Strip Item 4 Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '📍 Deliver to India' ) );
        $this->add_control( 'logo_text', array( 'label' => 'Logo Text Fallback', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'AMALEY' ) );
        $this->add_control( 'logo_image', array( 'label' => 'Logo Image', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'menu_text', array( 'label' => 'Menu Items', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Shop|/shop/\nOur Story|/our-story/\nCluster|/clusters/\nCollections|/collections/\nJournal|/journal/\nContact|/contact/\nGifting|/gifting/", 'description' => 'One item per line: Label|URL' ) );
        $this->add_control( 'cart_amount_text', array( 'label' => 'Fallback Cart Amount', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '₹120.00' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style', array( 'label' => 'Quick Visual Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'strip_bg', array( 'label' => 'Top Strip Background', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203' ) );
        $this->add_control( 'strip_color', array( 'label' => 'Top Strip Text', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ee' ) );
        $this->add_control( 'header_bg', array( 'label' => 'Header Background', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ee' ) );
        $this->add_control( 'text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203' ) );
        $this->add_control( 'accent_color', array( 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#c2880a' ) );
        $this->add_responsive_control( 'logo_width', array( 'label' => 'Logo Width', 'type' => \Elementor\Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => 60, 'max' => 260 ) ), 'default' => array( 'size' => 132, 'unit' => 'px' ) ) );
        $this->add_responsive_control( 'padding', array( 'label' => 'Header Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'default' => array( 'top' => 12, 'right' => 32, 'bottom' => 12, 'left' => 32, 'unit' => 'px' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $this->inline_css_once();
        $s = $this->get_settings_for_display();
        $uid = 'ahfs2-h-' . esc_attr( $this->get_id() );
        $logo_url = ! empty( $s['logo_image']['url'] ) ? esc_url( $s['logo_image']['url'] ) : '';
        $logo_width = isset( $s['logo_width']['size'] ) ? absint( $s['logo_width']['size'] ) : 132;
        $pad = $s['padding'] ?? array();
        $padding = sprintf( '%dpx %dpx %dpx %dpx', absint( $pad['top'] ?? 12 ), absint( $pad['right'] ?? 32 ), absint( $pad['bottom'] ?? 12 ), absint( $pad['left'] ?? 32 ) );
        $amount = $s['cart_amount_text'] ?? '₹120.00';
        if ( function_exists( 'WC' ) && WC()->cart ) {
            $amount = wp_strip_all_tags( WC()->cart->get_cart_subtotal() );
        }

        echo '<style>#' . $uid . '{--ahfs2-strip-bg:' . esc_attr( $s['strip_bg'] ?? '#2e1203' ) . ';--ahfs2-strip-color:' . esc_attr( $s['strip_color'] ?? '#fff8ee' ) . ';--ahfs2-header-bg:' . esc_attr( $s['header_bg'] ?? '#fff8ee' ) . ';--ahfs2-text:' . esc_attr( $s['text_color'] ?? '#2e1203' ) . ';--ahfs2-accent:' . esc_attr( $s['accent_color'] ?? '#c2880a' ) . ';--ahfs2-logo-width:' . $logo_width . 'px;--ahfs2-pad:' . esc_attr( $padding ) . ';}</style>';
        echo '<div id="' . $uid . '" class="ahfs2-header-widget">';

        if ( $this->yes( $s, 'show_strip' ) ) {
            echo '<div class="ahfs2-top-strip"><div class="ahfs2-strip-grid">';
            for ( $i = 1; $i <= 4; $i++ ) {
                $show_key = 'show_strip_' . $i;
                $text_key = 'strip_' . $i;
                if ( $this->yes( $s, $show_key ) && ! empty( $s[ $text_key ] ) ) {
                    echo '<span>' . esc_html( $s[ $text_key ] ) . '</span>';
                }
            }
            echo '</div></div>';
        }

        $show_logo = $this->yes( $s, 'show_logo' );
        $show_menu = $this->yes( $s, 'show_menu' );
        $show_icons_area = $this->yes( $s, 'show_icons_area' ) && ( $this->yes( $s, 'show_search' ) || $this->yes( $s, 'show_account' ) || $this->yes( $s, 'show_wishlist' ) || $this->yes( $s, 'show_cart' ) || $this->yes( $s, 'show_cart_amount' ) || $this->yes( $s, 'show_mobile_toggle' ) );
        $header_classes = array( 'ahfs2-live-header' );
        if ( ! $show_logo ) { $header_classes[] = 'ahfs2-no-logo'; }
        if ( ! $show_menu ) { $header_classes[] = 'ahfs2-no-menu'; }
        if ( ! $show_icons_area ) { $header_classes[] = 'ahfs2-no-icons'; }

        if ( $this->yes( $s, 'show_main_header' ) ) {
            echo '<header class="' . esc_attr( implode( ' ', $header_classes ) ) . '">';
            if ( $show_logo ) {
                echo '<a class="ahfs2-logo" href="' . esc_url( home_url( '/' ) ) . '">';
                if ( $logo_url ) { echo '<img src="' . $logo_url . '" alt="' . esc_attr( $s['logo_text'] ?? 'AMALEY' ) . '" />'; } else { echo '<span>' . esc_html( $s['logo_text'] ?? 'AMALEY' ) . '</span>'; }
                echo '</a>';
            }
            if ( $show_menu ) {
                echo '<nav class="ahfs2-nav">';
                foreach ( $this->link_list_array( $s['menu_text'] ?? '' ) as $item ) {
                    echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
                }
                echo '</nav>';
            }
            if ( $show_icons_area ) {
                echo '<div class="ahfs2-icons">';
                if ( $this->yes( $s, 'show_search' ) ) { echo '<a href="?s=" aria-label="Search">⌕</a>'; }
                if ( $this->yes( $s, 'show_account' ) ) { echo '<a href="' . esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' ) ) . '" aria-label="Account">♙</a>'; }
                if ( $this->yes( $s, 'show_wishlist' ) ) { echo '<a class="ahfs2-wishlist" href="#" aria-label="Wishlist">♡' . ( $this->yes( $s, 'show_wishlist_badge' ) ? '<b>0</b>' : '' ) . '</a>'; }
                if ( $this->yes( $s, 'show_cart' ) ) { $count = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 1; echo '<a class="ahfs2-cart" href="' . esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ) . '" aria-label="Cart">🛒' . ( $this->yes( $s, 'show_cart_badge' ) ? '<b>' . absint( $count ) . '</b>' : '' ) . '</a>'; }
                if ( $this->yes( $s, 'show_cart_amount' ) ) { echo '<a class="ahfs2-cart-amount" href="' . esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ) . '">' . esc_html( $amount ) . '</a>'; }
                if ( $this->yes( $s, 'show_mobile_toggle' ) ) { echo '<button class="ahfs2-menu-toggle" type="button" aria-label="Menu">☰</button>'; }
                echo '</div>';
            }
            echo '</header>';
        }

        if ( $this->yes( $s, 'show_mobile_drawer' ) ) {
            echo '<div class="ahfs2-mobile-drawer" hidden>';
            if ( $this->yes( $s, 'show_mobile_drawer_close' ) ) { echo '<button type="button" class="ahfs2-drawer-close">×</button>'; }
            if ( $this->yes( $s, 'show_mobile_drawer_menu' ) ) {
                echo '<nav>';
                foreach ( $this->link_list_array( $s['menu_text'] ?? '' ) as $item ) {
                    echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
                }
                echo '</nav>';
            }
            echo '</div>';
        }
        echo '</div>';
    }
}

final class AHFS2_Footer_Live_Widget extends AHFS2_Elementor_Base_Widget {
    public function get_name() { return 'ahfs2_footer_live'; }
    public function get_title() { return 'Amaley Footer - Live Style'; }
    public function get_icon() { return 'eicon-footer'; }
    public function get_categories() { return array( 'ahfs2' ); }
    public function get_keywords() { return array( 'amaley', 'footer', 'hf' ); }

    protected function register_controls() {
        $this->start_controls_section( 'visibility', array( 'label' => 'Hide / Show Controls' ) );
        $this->add_control( 'visibility_note', array( 'type' => \Elementor\Controls_Manager::RAW_HTML, 'raw' => '<strong>No-coder controls:</strong> Turn footer sections/elements on or off from here. Style controls will come in the next step.' ) );
        $this->switcher( 'show_brand_col', 'Brand / Logo Column', 'yes' );
        $this->switcher( 'show_footer_logo', 'Footer Logo / Logo Text', 'yes' );
        $this->switcher( 'show_kicker', 'Footer Kicker Line', 'yes' );
        $this->switcher( 'show_description', 'Footer Description', 'yes' );
        $this->switcher( 'show_shop_col', 'Shop Column', 'yes' );
        $this->switcher( 'show_shop_heading', 'Shop Heading', 'yes' );
        $this->switcher( 'show_shop_links', 'Shop Links', 'yes' );
        $this->switcher( 'show_eco_col', 'Ecosystem Column', 'yes' );
        $this->switcher( 'show_eco_heading', 'Ecosystem Heading', 'yes' );
        $this->switcher( 'show_eco_links', 'Ecosystem Links', 'yes' );
        $this->switcher( 'show_contact_col', 'Contact Column', 'yes' );
        $this->switcher( 'show_contact_heading', 'Contact Heading', 'yes' );
        $this->switcher( 'show_phone', 'Phone', 'yes' );
        $this->switcher( 'show_hours', 'Working Hours', 'yes' );
        $this->switcher( 'show_email', 'Email', 'yes' );
        $this->switcher( 'show_bottom_bar', 'Bottom Bar', 'yes' );
        $this->switcher( 'show_copyright', 'Copyright Text', 'yes' );
        $this->switcher( 'show_designed_by', 'Designed By Text', 'yes' );
        $this->end_controls_section();

        $this->start_controls_section( 'content', array( 'label' => 'Footer Content' ) );
        $this->add_control( 'logo_text', array( 'label' => 'Logo Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'AMALEY' ) );
        $this->add_control( 'logo_image', array( 'label' => 'Footer Logo Image', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'kicker', array( 'label' => 'Footer Kicker', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'SMALL BATCH • NATURAL • TRACEABLE' ) );
        $this->add_control( 'description', array( 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Natural Himalayan foods made in small batches by women collectives, producer families, and community-rooted value chains.' ) );
        $this->add_control( 'shop_links', array( 'label' => 'Shop Links', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "All Products|/shop/\nCollections|/collections/\nGifting|/gifting/\nSeasonal Specials|/shop/" ) );
        $this->add_control( 'eco_links', array( 'label' => 'Ecosystem Links', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Our Story|/our-story/\nClusters|/clusters/\nSHG Groups|/women-collectives/\nProducers|/producers/" ) );
        $this->add_control( 'phone', array( 'label' => 'Phone', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+91-85952 27121' ) );
        $this->add_control( 'email', array( 'label' => 'Email', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'hello@amaleycollective.com' ) );
        $this->add_control( 'hours', array( 'label' => 'Working Hours', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Monday – Friday: 9:00 – 20:00\nSaturday: 11:00 – 14:00" ) );
        $this->add_control( 'copyright', array( 'label' => 'Copyright', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '© 2026 Amaley. All rights reserved.' ) );
        $this->add_control( 'designed_by', array( 'label' => 'Designed By Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Designed by Gram Connect Impact Technologies & Consulting LLP' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style', array( 'label' => 'Quick Visual Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'footer_bg', array( 'label' => 'Background', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2e1203' ) );
        $this->add_control( 'text_color', array( 'label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff8ee' ) );
        $this->add_control( 'accent_color', array( 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#c2880a' ) );
        $this->add_responsive_control( 'padding', array( 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => array( 'px' ), 'default' => array( 'top' => 56, 'right' => 32, 'bottom' => 26, 'left' => 32, 'unit' => 'px' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $this->inline_css_once();
        $s = $this->get_settings_for_display();
        $uid = 'ahfs2-f-' . esc_attr( $this->get_id() );
        $pad = $s['padding'] ?? array();
        $padding = sprintf( '%dpx %dpx %dpx %dpx', absint( $pad['top'] ?? 56 ), absint( $pad['right'] ?? 32 ), absint( $pad['bottom'] ?? 26 ), absint( $pad['left'] ?? 32 ) );
        $logo_url = ! empty( $s['logo_image']['url'] ) ? esc_url( $s['logo_image']['url'] ) : '';
        echo '<style>#' . $uid . '{--ahfs2-footer-bg:' . esc_attr( $s['footer_bg'] ?? '#2e1203' ) . ';--ahfs2-footer-text:' . esc_attr( $s['text_color'] ?? '#fff8ee' ) . ';--ahfs2-accent:' . esc_attr( $s['accent_color'] ?? '#c2880a' ) . ';--ahfs2-footer-pad:' . esc_attr( $padding ) . ';}</style>';
        echo '<footer id="' . $uid . '" class="ahfs2-footer-widget">';
        $col_count = 0;
        foreach ( array( 'show_brand_col', 'show_shop_col', 'show_eco_col', 'show_contact_col' ) as $col ) { if ( $this->yes( $s, $col ) ) { $col_count++; } }
        echo '<div class="ahfs2-footer-grid ahfs2-footer-cols-' . absint( max( 1, $col_count ) ) . '">';
        if ( $this->yes( $s, 'show_brand_col' ) ) {
            echo '<div class="ahfs2-footer-brand">';
            if ( $this->yes( $s, 'show_footer_logo' ) ) {
                if ( $logo_url ) { echo '<img src="' . $logo_url . '" alt="' . esc_attr( $s['logo_text'] ?? 'AMALEY' ) . '" style="width:132px;max-width:100%;height:auto;margin-bottom:18px" />'; } else { echo '<h2>' . esc_html( $s['logo_text'] ?? 'AMALEY' ) . '</h2>'; }
            }
            if ( $this->yes( $s, 'show_kicker' ) ) { echo '<p class="ahfs2-kicker">' . esc_html( $s['kicker'] ?? '' ) . '</p>'; }
            if ( $this->yes( $s, 'show_description' ) ) { echo '<p>' . esc_html( $s['description'] ?? '' ) . '</p>'; }
            echo '</div>';
        }
        if ( $this->yes( $s, 'show_shop_col' ) ) {
            echo '<div class="ahfs2-footer-shop">';
            if ( $this->yes( $s, 'show_shop_heading' ) ) { echo '<h3>Shop</h3>'; }
            if ( $this->yes( $s, 'show_shop_links' ) ) { echo self::link_list( $s['shop_links'] ?? '' ); }
            echo '</div>';
        }
        if ( $this->yes( $s, 'show_eco_col' ) ) {
            echo '<div class="ahfs2-footer-ecosystem">';
            if ( $this->yes( $s, 'show_eco_heading' ) ) { echo '<h3>Ecosystem</h3>'; }
            if ( $this->yes( $s, 'show_eco_links' ) ) { echo self::link_list( $s['eco_links'] ?? '' ); }
            echo '</div>';
        }
        if ( $this->yes( $s, 'show_contact_col' ) ) {
            echo '<div class="ahfs2-footer-contact">';
            if ( $this->yes( $s, 'show_contact_heading' ) ) { echo '<h3>Contact Us</h3>'; }
            if ( $this->yes( $s, 'show_phone' ) ) { echo '<p class="ahfs2-footer-phone">☎ ' . esc_html( $s['phone'] ?? '' ) . '</p>'; }
            if ( $this->yes( $s, 'show_hours' ) ) { echo '<p>' . nl2br( esc_html( $s['hours'] ?? '' ) ) . '</p>'; }
            if ( $this->yes( $s, 'show_email' ) ) { echo '<p style="margin-top:18px">✉ <a href="mailto:' . esc_attr( $s['email'] ?? '' ) . '">' . esc_html( $s['email'] ?? '' ) . '</a></p>'; }
            echo '</div>';
        }
        echo '</div>';
        if ( $this->yes( $s, 'show_bottom_bar' ) ) {
            echo '<div class="ahfs2-footer-bottom">';
            if ( $this->yes( $s, 'show_copyright' ) ) { echo '<span>' . esc_html( $s['copyright'] ?? '' ) . '</span>'; }
            if ( $this->yes( $s, 'show_designed_by' ) ) { echo '<span>' . esc_html( $s['designed_by'] ?? 'Designed by Gram Connect Impact Technologies & Consulting LLP' ) . '</span>'; }
            echo '</div>';
        }
        echo '</footer>';
    }

    private static function link_list( $text ) {
        $out = '<ul>';
        foreach ( explode( "\n", (string) $text ) as $line ) {
            $parts = array_map( 'trim', explode( '|', $line, 2 ) );
            if ( empty( $parts[0] ) ) { continue; }
            $out .= '<li><a href="' . esc_url( $parts[1] ?? '#' ) . '">' . esc_html( $parts[0] ) . '</a></li>';
        }
        return $out . '</ul>';
    }
}
