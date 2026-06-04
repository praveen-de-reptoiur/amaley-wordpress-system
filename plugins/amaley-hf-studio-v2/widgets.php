<?php
/**
 * Elementor widgets for Amaley H/F Studio V2.
 *
 * Version 2.0.15: pre-lock safety build. Keeps v2.0.14 controls and adds safer frontend/render baseline in the main plugin file.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! class_exists( '\Elementor\Widget_Base' ) ) { return; }
if ( class_exists( 'AHFS2_Header_Live_Widget' ) ) { return; }

abstract class AHFS2_Elementor_Base_Widget extends \Elementor\Widget_Base {
    protected function yes( array $settings, $key, $default = 'yes' ) {
        if ( ! array_key_exists( $key, $settings ) ) { return 'yes' === $default; }
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
        if ( $description ) { $args['description'] = $description; }
        $this->add_control( $key, $args );
    }

    protected function wp_menu_options() {
        $options = array( '' => '— Select WordPress Menu —' );
        $menus = function_exists( 'wp_get_nav_menus' ) ? wp_get_nav_menus() : array();
        if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
            foreach ( $menus as $menu ) { $options[ (string) $menu->term_id ] = $menu->name; }
        }
        return $options;
    }

    protected function link_list_array( $text ) {
        $items = array();
        foreach ( explode( "\n", (string) $text ) as $line ) {
            $parts = array_map( 'trim', explode( '|', $line, 2 ) );
            if ( empty( $parts[0] ) ) { continue; }
            $items[] = array( 'label' => $parts[0], 'url' => $parts[1] ?? '#' );
        }
        return $items;
    }

    protected function menu_items_from_settings( array $settings ) {
        $source = $settings['menu_source'] ?? 'wp_menu';
        if ( 'wp_menu' === $source && ! empty( $settings['wp_menu'] ) ) {
            $menu_items = wp_get_nav_menu_items( absint( $settings['wp_menu'] ) );
            $items = array();
            if ( ! empty( $menu_items ) && ! is_wp_error( $menu_items ) ) {
                foreach ( $menu_items as $item ) {
                    if ( ! empty( $item->title ) ) {
                        $items[] = array( 'label' => $item->title, 'url' => ! empty( $item->url ) ? $item->url : '#' );
                    }
                }
            }
            if ( ! empty( $items ) ) { return $items; }
        }
        if ( ! empty( $settings['manual_menu_items'] ) && is_array( $settings['manual_menu_items'] ) ) {
            $items = array();
            foreach ( $settings['manual_menu_items'] as $item ) {
                if ( empty( $item['label'] ) ) { continue; }
                $items[] = array( 'label' => $item['label'], 'url' => ! empty( $item['url']['url'] ) ? $item['url']['url'] : '#' );
            }
            if ( ! empty( $items ) ) { return $items; }
        }
        return $this->link_list_array( "Shop|/shop/\nOur Story|/our-story/\nCluster|/clusters/\nCollections|/collections/\nJournal|/journal/\nContact|/contact/\nGifting|/gifting/" );
    }

    protected function strip_items_from_settings( array $settings ) {
        $items = array();
        if ( ! empty( $settings['strip_items'] ) && is_array( $settings['strip_items'] ) ) {
            foreach ( $settings['strip_items'] as $item ) {
                if ( isset( $item['show_item'] ) && 'yes' !== $item['show_item'] ) { continue; }
                $text = trim( (string) ( $item['text'] ?? '' ) );
                if ( '' === $text ) { continue; }
                $items[] = array(
                    'text' => $text,
                    'icon' => trim( (string) ( $item['icon'] ?? '' ) ),
                    'url'  => ! empty( $item['link']['url'] ) ? $item['link']['url'] : '',
                );
            }
        }
        if ( ! empty( $items ) ) { return $items; }
        return array(
            array( 'text' => 'Made in the Himalayas', 'icon' => '🌿', 'url' => '' ),
            array( 'text' => 'Free Shipping on Orders ₹99+', 'icon' => '🚚', 'url' => '' ),
            array( 'text' => 'Thoughtful Gifts', 'icon' => '🎁', 'url' => '' ),
            array( 'text' => 'Deliver to India', 'icon' => '📍', 'url' => '' ),
        );
    }

    protected function add_typography( $name, $label, $selector ) {
        if ( class_exists( '\\Elementor\\Group_Control_Typography' ) ) {
            $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), array(
                'name'     => $name,
                'label'    => $label,
                'selector' => $selector,
            ) );
        }
    }

    protected function add_border( $name, $selector ) {
        if ( class_exists( '\\Elementor\\Group_Control_Border' ) ) {
            $this->add_group_control( \Elementor\Group_Control_Border::get_type(), array(
                'name'     => $name,
                'selector' => $selector,
            ) );
        }
    }

    protected function add_shadow( $name, $selector ) {
        if ( class_exists( '\\Elementor\\Group_Control_Box_Shadow' ) ) {
            $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), array(
                'name'     => $name,
                'selector' => $selector,
            ) );
        }
    }

    protected function inline_css_once() {
        static $done = false;
        if ( $done ) { return; }
        $done = true;
        ?>
        <style id="ahfs2-widget-inline-css-v215">
        .ahfs2-header-widget,.ahfs2-header-widget *,.ahfs2-footer-widget,.ahfs2-footer-widget *{box-sizing:border-box}.ahfs2-header-widget{width:100%;max-width:100%;overflow-x:clip;color:#2e1203;background:#fff8ee;position:relative;z-index:20}.ahfs2-top-strip{background:#2e1203;color:#fff8ee;min-height:34px;display:flex;align-items:center;justify-content:center;padding:0 18px;font:700 12px/1.2 Arial,sans-serif}.ahfs2-strip-grid{width:min(1120px,100%);display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));align-items:center;text-align:center}.ahfs2-strip-grid a{text-decoration:none;color:inherit}.ahfs2-strip-grid span{display:flex;align-items:center;justify-content:center;gap:6px;min-height:18px;padding:0 10px}.ahfs2-strip-grid span+span{border-left:1px solid rgba(255,248,238,.18)}.ahfs2-live-header{display:grid;grid-template-columns:var(--ahfs2-logo-col,220px) var(--ahfs2-menu-col,1fr) var(--ahfs2-icons-col,auto);align-items:center;gap:var(--ahfs2-grid-gap,28px);background:#fff8ee;color:#2e1203;padding:12px 32px;border-bottom:1px solid rgba(46,18,3,.16);min-height:128px;width:100%}.ahfs2-live-header.ahfs2-no-logo{grid-template-columns:1fr auto}.ahfs2-live-header.ahfs2-no-menu{grid-template-columns:220px auto;justify-content:space-between}.ahfs2-live-header.ahfs2-no-icons{grid-template-columns:220px 1fr}.ahfs2-logo{display:inline-flex;align-items:center;justify-content:center;text-decoration:none;color:#2e1203;font:800 28px/1 Georgia,serif;letter-spacing:.19em;white-space:nowrap;min-width:0}.ahfs2-logo img{display:block;width:132px;height:auto;max-height:104px;object-fit:contain}.ahfs2-nav{display:flex;align-items:center;justify-content:center;gap:30px;min-width:0;flex-wrap:nowrap}.ahfs2-nav a{color:#2e1203;text-decoration:none;font:800 13px/1.2 Arial,sans-serif;letter-spacing:.04em;text-transform:uppercase;white-space:nowrap}.ahfs2-icons{display:flex;align-items:center;justify-content:flex-end;gap:10px;white-space:nowrap}.ahfs2-icons a,.ahfs2-menu-toggle{position:relative;color:#2e1203;background:rgba(255,255,255,.18);border:1px solid rgba(46,18,3,.16);text-decoration:none;width:37px;height:37px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;font:700 15px/1 Arial,sans-serif;cursor:pointer}.ahfs2-cart b,.ahfs2-wishlist b{position:absolute;top:-8px;right:-5px;min-width:18px;height:18px;border-radius:18px;background:#c2880a;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:10px}.ahfs2-cart-amount{border:0!important;background:transparent!important;width:auto!important;padding:0 0 0 8px!important;border-radius:0!important;font-size:13px!important;font-weight:800!important;color:#2e1203!important}.ahfs2-logo{margin-right:var(--ahfs2-logo-mr,0px);justify-content:var(--ahfs2-logo-align,center)}.ahfs2-nav{margin-left:var(--ahfs2-menu-ml,0px);margin-right:var(--ahfs2-menu-mr,0px);justify-content:var(--ahfs2-menu-align,center)}.ahfs2-icons{margin-left:var(--ahfs2-icons-ml,0px);justify-content:var(--ahfs2-icons-align,flex-end)}.ahfs2-live-header{max-width:var(--ahfs2-header-inner-max,100%);margin-left:auto;margin-right:auto}.ahfs2-menu-toggle{display:none}.ahfs2-mobile-drawer{position:fixed;inset:0 0 0 auto;width:min(86vw,360px);z-index:99999;background:#fff8ee;box-shadow:-20px 0 40px rgba(0,0,0,.18);padding:24px}.ahfs2-mobile-drawer nav{display:grid;gap:14px;margin-top:30px}.ahfs2-mobile-drawer a{color:#2e1203;text-decoration:none;font:700 16px/1.3 Arial,sans-serif}.ahfs2-drawer-close{border:0;background:#2e1203;color:#fff8ee;border-radius:100px;width:38px;height:38px;font-size:24px;float:right}.ahfs2-footer-widget{background:#2e1203;color:#fff8ee;padding:56px 32px 26px;width:100%;max-width:100%;overflow-x:clip}.ahfs2-footer-grid{display:grid;grid-template-columns:var(--ahfs2-footer-brand-col,1.55fr) var(--ahfs2-footer-shop-col,.9fr) var(--ahfs2-footer-eco-col,.9fr) var(--ahfs2-footer-contact-col,1.15fr);gap:var(--ahfs2-footer-col-gap,70px);max-width:var(--ahfs2-footer-inner-max,1060px);margin:0 auto;align-items:var(--ahfs2-footer-align-items,start);text-align:var(--ahfs2-footer-text-align,left)}.ahfs2-footer-grid.ahfs2-footer-cols-1{grid-template-columns:1fr}.ahfs2-footer-grid.ahfs2-footer-cols-2{grid-template-columns:repeat(2,1fr)}.ahfs2-footer-grid.ahfs2-footer-cols-3{grid-template-columns:repeat(3,1fr)}.ahfs2-footer-brand h2,.ahfs2-footer-widget h3{font-family:Georgia,serif;color:#fff8ee;margin:0 0 20px}.ahfs2-footer-brand h2{letter-spacing:.20em;font-size:26px}.ahfs2-footer-widget h3{font-size:16px;text-transform:uppercase;letter-spacing:.18em;color:#c2880a}.ahfs2-footer-widget p{margin:0;color:#fff8ee;line-height:1.75}.ahfs2-footer-brand .ahfs2-kicker{color:#c2880a;font-weight:800;letter-spacing:.18em;text-transform:uppercase;font-size:12px;margin:22px 0 18px}.ahfs2-footer-widget ul{list-style:none;margin:0;padding:0;display:grid;gap:14px}.ahfs2-footer-widget a{color:#fff8ee;text-decoration:none}.ahfs2-footer-phone{font-size:22px;font-weight:800;margin-bottom:18px!important}.ahfs2-footer-bottom{max-width:var(--ahfs2-footer-inner-max,1060px);margin:36px auto 0;padding-top:18px;border-top:1px solid rgba(255,248,238,.18);display:flex;justify-content:space-between;gap:18px;font-size:12px}.ahfs2-footer-brand{margin-right:var(--ahfs2-footer-brand-mr,0px);padding:var(--ahfs2-footer-brand-pad,0)}.ahfs2-footer-shop{padding:var(--ahfs2-footer-shop-pad,0);margin-left:var(--ahfs2-footer-shop-ml,0px)}.ahfs2-footer-ecosystem{padding:var(--ahfs2-footer-eco-pad,0);margin-left:var(--ahfs2-footer-eco-ml,0px)}.ahfs2-footer-contact{padding:var(--ahfs2-footer-contact-pad,0);margin-left:var(--ahfs2-footer-contact-ml,0px)}@media(max-width:1100px){.ahfs2-live-header{grid-template-columns:170px 1fr auto;gap:18px;padding:12px 20px}.ahfs2-nav{gap:18px}.ahfs2-nav a{font-size:12px}.ahfs2-footer-grid{gap:38px}}@media(max-width:980px){.ahfs2-top-strip{justify-content:flex-start;overflow-x:auto;padding:0 12px;min-height:var(--ahfs2-phone-strip-height,34px)}.ahfs2-strip-grid{display:flex;width:max-content;min-width:100%;gap:0}.ahfs2-strip-grid span{padding:0 18px;white-space:nowrap}.ahfs2-live-header,.ahfs2-live-header.ahfs2-no-logo,.ahfs2-live-header.ahfs2-no-menu,.ahfs2-live-header.ahfs2-no-icons{grid-template-columns:1fr auto;min-height:var(--ahfs2-phone-header-height,82px);padding:var(--ahfs2-phone-header-padding,10px 16px)}.ahfs2-logo{justify-content:flex-start}.ahfs2-logo img{width:var(--ahfs2-phone-logo-width,112px);max-height:var(--ahfs2-phone-logo-max-height,70px)}.ahfs2-nav{display:none}.ahfs2-icons a:not(.ahfs2-cart){display:none}.ahfs2-cart-amount{display:none!important}.ahfs2-menu-toggle{display:inline-flex}.ahfs2-icons{gap:var(--ahfs2-phone-icon-gap,8px)}.ahfs2-icons a,.ahfs2-menu-toggle{width:var(--ahfs2-phone-icon-size,34px);height:var(--ahfs2-phone-icon-size,34px)}.ahfs2-mobile-drawer{width:var(--ahfs2-phone-drawer-width,min(86vw,360px));padding:var(--ahfs2-phone-drawer-padding,24px)}.ahfs2-footer-grid,.ahfs2-footer-grid.ahfs2-footer-cols-1,.ahfs2-footer-grid.ahfs2-footer-cols-2,.ahfs2-footer-grid.ahfs2-footer-cols-3{grid-template-columns:1fr 1fr;gap:34px}.ahfs2-footer-bottom{flex-direction:column}}@media(max-width:640px){.ahfs2-logo img{width:var(--ahfs2-phone-logo-width,94px);max-height:var(--ahfs2-phone-logo-max-height,64px)}.ahfs2-footer-grid,.ahfs2-footer-grid.ahfs2-footer-cols-1,.ahfs2-footer-grid.ahfs2-footer-cols-2,.ahfs2-footer-grid.ahfs2-footer-cols-3{grid-template-columns:1fr}.ahfs2-footer-widget{padding:42px 22px 24px}}
        .ahfs2-mobile-drawer[hidden]{display:none!important}.ahfs2-mobile-drawer.is-open{display:block!important}

        @media(min-width:981px){.ahfs2-strip-hide-desktop{display:none!important}}
        @media(min-width:641px) and (max-width:980px){.ahfs2-strip-hide-tablet,.ahfs2-strip-mobile-hide{display:none!important}}
        @media(max-width:640px){.ahfs2-strip-hide-phone,.ahfs2-strip-mobile-hide{display:none!important}}
        @media(max-width:980px){.ahfs2-strip-mobile-wrap{overflow:visible}.ahfs2-strip-mobile-wrap .ahfs2-strip-grid{display:grid!important;grid-template-columns:1fr 1fr;width:100%!important;min-width:0!important}.ahfs2-strip-mobile-wrap .ahfs2-strip-grid span{white-space:normal!important;padding:6px 10px}.ahfs2-strip-mobile-scroll .ahfs2-strip-grid{display:flex!important;width:max-content!important;min-width:100%!important}.ahfs2-strip-mobile-scroll .ahfs2-strip-grid span{white-space:nowrap!important}}

        .ahfs2-mobile-overlay[hidden]{display:none!important}.ahfs2-mobile-overlay{position:fixed;inset:0;background:rgba(46,18,3,.42);z-index:99998;backdrop-filter:blur(1px)}.ahfs2-mobile-overlay.is-open{display:block!important}.ahfs2-mobile-drawer{top:0;bottom:0;height:100vh;overflow-y:auto;padding:0!important;background:#fff8ee}.ahfs2-mobile-drawer.ahfs2-drawer-left{left:0;right:auto}.ahfs2-mobile-drawer.ahfs2-drawer-right{right:0;left:auto}.ahfs2-drawer-head{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:22px 24px;border-bottom:1px solid rgba(46,18,3,.14);background:#fff8ee}.ahfs2-drawer-logo{display:inline-flex!important;width:auto!important;height:auto!important;border:0!important;background:transparent!important;padding:0!important;border-radius:0!important;text-decoration:none;color:#2e1203}.ahfs2-drawer-logo img{display:block;width:118px;height:auto;max-height:90px;object-fit:contain}.ahfs2-drawer-logo span{font:800 24px/1 Georgia,serif;letter-spacing:.18em}.ahfs2-drawer-close{display:inline-flex;align-items:center;justify-content:center;border:1px solid rgba(46,18,3,.16);background:#fff8ee;color:#2e1203;border-radius:999px;width:42px;height:42px;font-size:22px;float:none;line-height:1}.ahfs2-mobile-drawer nav.ahfs2-drawer-nav{display:grid;gap:0;margin:0;padding:18px 22px 0}.ahfs2-mobile-drawer nav.ahfs2-drawer-nav a{display:flex;align-items:center;min-height:54px;border-bottom:1px solid rgba(46,18,3,.13);padding:0 0;color:#2e1203;text-decoration:none;font:800 15px/1.2 Arial,sans-serif;text-transform:uppercase;letter-spacing:.04em}.ahfs2-drawer-strip{display:grid;gap:0;padding:18px 22px 24px}.ahfs2-drawer-strip span,.ahfs2-drawer-strip a{display:flex;align-items:center;min-height:38px;border-top:1px solid rgba(46,18,3,.08);color:#3a2114;text-decoration:none;font:600 14px/1.35 Arial,sans-serif}.ahfs2-drawer-strip span:first-child,.ahfs2-drawer-strip a:first-child{border-top:0}


        @media(max-width:980px){
          .ahfs2-footer-widget.ahfs2-footer-mobile-two{padding:var(--ahfs2-footer-mobile-padding,42px 22px 24px)}
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-grid,
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-grid.ahfs2-footer-cols-1,
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-grid.ahfs2-footer-cols-2,
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-grid.ahfs2-footer-cols-3,
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-grid.ahfs2-footer-cols-4{grid-template-columns:minmax(0,var(--ahfs2-footer-mobile-shop-width,50%)) minmax(0,var(--ahfs2-footer-mobile-eco-width,50%));column-gap:var(--ahfs2-footer-mobile-col-gap,24px);row-gap:var(--ahfs2-footer-mobile-row-gap,34px);text-align:var(--ahfs2-footer-mobile-text-align,left)}
          .ahfs2-footer-widget.ahfs2-footer-mobile-stack .ahfs2-footer-grid,
          .ahfs2-footer-widget.ahfs2-footer-mobile-stack .ahfs2-footer-grid.ahfs2-footer-cols-1,
          .ahfs2-footer-widget.ahfs2-footer-mobile-stack .ahfs2-footer-grid.ahfs2-footer-cols-2,
          .ahfs2-footer-widget.ahfs2-footer-mobile-stack .ahfs2-footer-grid.ahfs2-footer-cols-3,
          .ahfs2-footer-widget.ahfs2-footer-mobile-stack .ahfs2-footer-grid.ahfs2-footer-cols-4{grid-template-columns:1fr;gap:var(--ahfs2-footer-mobile-row-gap,28px);text-align:var(--ahfs2-footer-mobile-text-align,left)}
          .ahfs2-footer-widget.ahfs2-footer-mobile-two.ahfs2-footer-mobile-brand-full .ahfs2-footer-brand{grid-column:1/-1}
          .ahfs2-footer-widget.ahfs2-footer-mobile-two.ahfs2-footer-mobile-contact-full .ahfs2-footer-contact{grid-column:1/-1}
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-shop{grid-column:1/2}
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-ecosystem{grid-column:2/3}
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-bottom{text-align:var(--ahfs2-footer-mobile-text-align,left)}
        }
        @media(max-width:420px){
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-grid{column-gap:var(--ahfs2-footer-mobile-col-gap,18px)}
          .ahfs2-footer-widget.ahfs2-footer-mobile-two .ahfs2-footer-widget h3,
          .ahfs2-footer-widget.ahfs2-footer-mobile-two h3{font-size:14px;letter-spacing:.14em}
        }
        </style>
        <?php
    }

    protected function inline_js_once() {
        static $done = false;
        if ( $done ) { return; }
        $done = true;
        ?>
        <script id="ahfs2-widget-inline-js-v215">
        (function(){
          if(window.ahfs2DrawerReady){return;}
          window.ahfs2DrawerReady=true;
          function closeDrawer(drawer){ if(drawer){ drawer.hidden=true; drawer.classList.remove("is-open"); var wrap=drawer.closest(".ahfs2-header-widget"); var overlay=wrap?wrap.querySelector(".ahfs2-mobile-overlay"):document.querySelector(".ahfs2-mobile-overlay"); if(overlay){ overlay.hidden=true; overlay.classList.remove("is-open"); } } }
          function closeAll(){ document.querySelectorAll(".ahfs2-mobile-drawer").forEach(closeDrawer); }
          document.addEventListener("click",function(e){
            var toggle=e.target.closest(".ahfs2-menu-toggle");
            if(toggle){
              e.preventDefault(); e.stopPropagation();
              var wrap=toggle.closest(".ahfs2-header-widget");
              var drawer=wrap?wrap.querySelector(".ahfs2-mobile-drawer"):document.querySelector(".ahfs2-mobile-drawer");
              if(drawer){ drawer.hidden=false; drawer.classList.add("is-open"); var overlay=wrap?wrap.querySelector(".ahfs2-mobile-overlay"):document.querySelector(".ahfs2-mobile-overlay"); if(overlay){ overlay.hidden=false; overlay.classList.add("is-open"); } }
              return false;
            }
            var close=e.target.closest("[data-ahfs2-close],.ahfs2-drawer-close");
            if(close){ e.preventDefault(); closeDrawer(close.closest(".ahfs2-mobile-drawer")); return false; }
          },true);
          document.addEventListener("keydown",function(e){ if(e.key==="Escape"){ closeAll(); } });
        })();
        </script>
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
        $this->switcher( 'show_strip', 'Top Announcement Strip', 'yes' );
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
        $this->switcher( 'show_mobile_drawer_logo', 'Drawer Logo Area', 'yes' );
        $this->switcher( 'show_mobile_drawer_close', 'Drawer Close Button', 'yes' );
        $this->switcher( 'show_mobile_drawer_menu', 'Drawer Menu Items', 'yes' );
        $this->switcher( 'show_mobile_drawer_strip', 'Drawer Bottom Info / Strip Items', 'yes' );
        $this->end_controls_section();

        $this->start_controls_section( 'top_strip_content', array( 'label' => 'Top Strip Content / Device' ) );
        $this->add_control( 'top_strip_note', array(
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => 'Use this section for the announcement strip. You can show/hide it separately on desktop, tablet and phone, and add/remove/reorder strip items.',
        ) );
        $this->switcher( 'show_strip_desktop', 'Show Strip on Desktop', 'yes' );
        $this->switcher( 'show_strip_tablet', 'Show Strip on Tablet', 'yes' );
        $this->switcher( 'show_strip_phone', 'Show Strip on Phone', 'yes' );
        $this->add_control( 'strip_mobile_behavior', array(
            'label'   => 'Phone/Tablet Strip Layout',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'scroll',
            'options' => array(
                'scroll' => 'Horizontal Scroll',
                'wrap'   => 'Wrap / Stack Neatly',
                'hide'   => 'Hide on Tablet & Phone',
            ),
        ) );
        $strip = new \Elementor\Repeater();
        $strip->add_control( 'show_item', array( 'label' => 'Show Item', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
        $strip->add_control( 'icon', array( 'label' => 'Icon / Emoji', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🌿' ) );
        $strip->add_control( 'text', array( 'label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Made in the Himalayas' ) );
        $strip->add_control( 'link', array( 'label' => 'Optional Link', 'type' => \Elementor\Controls_Manager::URL ) );
        $this->add_control( 'strip_items', array(
            'label'       => 'Top Strip Items',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $strip->get_controls(),
            'title_field' => '{{{ icon }}} {{{ text }}}',
            'default'     => array(
                array( 'show_item'=>'yes','icon'=>'🌿','text'=>'Made in the Himalayas' ),
                array( 'show_item'=>'yes','icon'=>'🚚','text'=>'Free Shipping on Orders ₹99+' ),
                array( 'show_item'=>'yes','icon'=>'🎁','text'=>'Thoughtful Gifts' ),
                array( 'show_item'=>'yes','icon'=>'📍','text'=>'Deliver to India' ),
            ),
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'logo_content', array( 'label' => 'Logo Content' ) );
        $this->add_control( 'logo_text', array( 'label' => 'Logo Text Fallback', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'AMALEY' ) );
        $this->add_control( 'logo_image', array( 'label' => 'Logo Image', 'type' => \Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'logo_link_note', array( 'type'=>\Elementor\Controls_Manager::RAW_HTML, 'raw'=>'Logo links to homepage by default.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'menu_content', array( 'label' => 'Menu Source / Items' ) );
        $this->add_control( 'menu_source', array( 'label' => 'Menu Source', 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'wp_menu', 'options' => array( 'wp_menu'=>'Use WordPress Menu', 'manual'=>'Manual Custom Menu' ) ) );
        $this->add_control( 'wp_menu', array( 'label' => 'Select WordPress Menu', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => $this->wp_menu_options(), 'condition' => array( 'menu_source' => 'wp_menu' ) ) );
        $manual = new \Elementor\Repeater();
        $manual->add_control( 'label', array( 'label'=>'Label', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'Shop' ) );
        $manual->add_control( 'url', array( 'label'=>'URL', 'type'=>\Elementor\Controls_Manager::URL, 'default'=>array( 'url'=>'/shop/' ) ) );
        $this->add_control( 'manual_menu_items', array( 'label'=>'Manual Menu Items', 'type'=>\Elementor\Controls_Manager::REPEATER, 'fields'=>$manual->get_controls(), 'title_field'=>'{{{ label }}}', 'condition'=>array( 'menu_source'=>'manual' ), 'default'=>array( array( 'label'=>'Shop','url'=>array( 'url'=>'/shop/' ) ), array( 'label'=>'Our Story','url'=>array( 'url'=>'/our-story/' ) ), array( 'label'=>'Cluster','url'=>array( 'url'=>'/clusters/' ) ), array( 'label'=>'Collections','url'=>array( 'url'=>'/collections/' ) ), array( 'label'=>'Journal','url'=>array( 'url'=>'/journal/' ) ), array( 'label'=>'Contact','url'=>array( 'url'=>'/contact/' ) ) ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'icons_content', array( 'label' => 'Header Icons / Cart Text' ) );
        $this->add_control( 'cart_amount_text', array( 'label'=>'Fallback Cart Amount', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'₹120.00' ) );
        $this->add_control( 'icons_note', array( 'type'=>\Elementor\Controls_Manager::RAW_HTML, 'raw'=>'Search, account, wishlist, cart and mobile button show/hide are controlled from Hide / Show Controls.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'mobile_drawer_content', array( 'label' => 'Mobile Drawer Content / Layout' ) );
        $this->add_control( 'mobile_drawer_note', array(
            'type'=>\Elementor\Controls_Manager::RAW_HTML,
            'raw'=>'Live-style drawer flow: Logo + Close button, Menu list, Bottom info strip. Menu comes from the selected WordPress menu/manual menu. Bottom info uses Top Strip Items.',
        ) );
        $this->add_control( 'drawer_side', array(
            'label'   => 'Drawer Opens From',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'left',
            'options' => array( 'left' => 'Left Side', 'right' => 'Right Side' ),
        ) );
        $this->add_control( 'drawer_logo_source', array(
            'label'   => 'Drawer Logo Source',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'same',
            'options' => array( 'same' => 'Use Header Logo', 'text' => 'Use Text Fallback Only' ),
        ) );
        $this->add_control( 'drawer_close_text', array( 'label'=>'Close Button Text/Icon', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'×' ) );
        $this->add_control( 'drawer_bottom_note', array(
            'type'=>\Elementor\Controls_Manager::RAW_HTML,
            'raw'=>'Drawer bottom info items are controlled from Top Strip Items repeater. Use Hide/Show Controls to show or hide the bottom info inside drawer.',
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_header_container', array( 'label'=>'Style: Header Container', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'header_padding', array( 'label'=>'Header Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-live-header'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'header_min_height', array( 'label'=>'Header Height', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','vh' ), 'range'=>array( 'px'=>array( 'min'=>40,'max'=>240 ), 'vh'=>array( 'min'=>4,'max'=>40 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-live-header'=>'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'header_gap', array( 'label'=>'Column Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>120 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-live-header'=>'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'header_bg', array( 'label'=>'Header Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-live-header, {{WRAPPER}} .ahfs2-header-widget'=>'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'header_border_color', array( 'label'=>'Bottom Border Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-live-header'=>'border-bottom-color: {{VALUE}};' ) ) );
        $this->add_border( 'header_border', '{{WRAPPER}} .ahfs2-live-header' );
        $this->add_shadow( 'header_shadow', '{{WRAPPER}} .ahfs2-live-header' );
        $this->end_controls_section();

        $this->start_controls_section( 'style_header_layout', array( 'label'=>'Style: Header Layout / Spacing', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'layout_note', array( 'type'=>\Elementor\Controls_Manager::RAW_HTML, 'raw'=>'Use these controls to adjust the red-marked spaces between Logo, Menu and Icons. Responsive icon beside each control allows Desktop / Tablet / Phone values.' ) );
        $this->add_responsive_control( 'header_inner_max_width', array(
            'label'=>'Header Inner Max Width',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px','%' ),
            'range'=>array( 'px'=>array( 'min'=>600,'max'=>1800 ), '%'=>array( 'min'=>50,'max'=>100 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-header-inner-max: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_logo_col', array(
            'label'=>'Logo Area Width',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px','%' ),
            'range'=>array( 'px'=>array( 'min'=>70,'max'=>520 ), '%'=>array( 'min'=>8,'max'=>45 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-logo-col: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_menu_col', array(
            'label'=>'Menu Area Width',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px','%' ),
            'range'=>array( 'px'=>array( 'min'=>180,'max'=>1000 ), '%'=>array( 'min'=>20,'max'=>80 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-menu-col: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_icons_col', array(
            'label'=>'Icons Area Width',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px','%' ),
            'range'=>array( 'px'=>array( 'min'=>80,'max'=>520 ), '%'=>array( 'min'=>8,'max'=>45 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-icons-col: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_grid_gap', array(
            'label'=>'Logo / Menu / Icons Gap',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px' ),
            'range'=>array( 'px'=>array( 'min'=>0,'max'=>160 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-grid-gap: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_logo_right_space', array(
            'label'=>'Logo Right Space',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px' ),
            'range'=>array( 'px'=>array( 'min'=>-80,'max'=>180 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-logo-mr: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_menu_left_space', array(
            'label'=>'Menu Left Space',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px' ),
            'range'=>array( 'px'=>array( 'min'=>-120,'max'=>220 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-menu-ml: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_menu_right_space', array(
            'label'=>'Menu Right Space',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px' ),
            'range'=>array( 'px'=>array( 'min'=>-120,'max'=>220 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-menu-mr: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_responsive_control( 'layout_icons_left_space', array(
            'label'=>'Icons Left Space',
            'type'=>\Elementor\Controls_Manager::SLIDER,
            'size_units'=>array( 'px' ),
            'range'=>array( 'px'=>array( 'min'=>-120,'max'=>220 ) ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-icons-ml: {{SIZE}}{{UNIT}};' )
        ) );
        $this->add_control( 'layout_logo_align', array(
            'label'=>'Logo Alignment',
            'type'=>\Elementor\Controls_Manager::SELECT,
            'default'=>'center',
            'options'=>array( 'flex-start'=>'Left', 'center'=>'Center', 'flex-end'=>'Right' ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-logo-align: {{VALUE}};' )
        ) );
        $this->add_control( 'layout_menu_align', array(
            'label'=>'Menu Alignment',
            'type'=>\Elementor\Controls_Manager::SELECT,
            'default'=>'center',
            'options'=>array( 'flex-start'=>'Left', 'center'=>'Center', 'flex-end'=>'Right' ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-menu-align: {{VALUE}};' )
        ) );
        $this->add_control( 'layout_icons_align', array(
            'label'=>'Icons Alignment',
            'type'=>\Elementor\Controls_Manager::SELECT,
            'default'=>'flex-end',
            'options'=>array( 'flex-start'=>'Left', 'center'=>'Center', 'flex-end'=>'Right' ),
            'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-icons-align: {{VALUE}};' )
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_phone_quick' , array( 'label'=>'Phone Quick Controls', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'phone_note', array( 'type'=>\Elementor\Controls_Manager::RAW_HTML, 'raw'=>'Use this section for simple phone-only changes. These controls affect mobile view only.' ) );
        $this->add_control( 'phone_logo_width', array( 'label'=>'Phone Logo Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>40,'max'=>220 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-logo-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_logo_max_height', array( 'label'=>'Phone Logo Max Height', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>30,'max'=>160 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-logo-max-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_header_height', array( 'label'=>'Phone Header Height', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>54,'max'=>180 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-header-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_header_padding', array( 'label'=>'Phone Header Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-header-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_icon_size', array( 'label'=>'Phone Icon / Menu Button Size', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>26,'max'=>72 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-icon-size: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_icon_gap', array( 'label'=>'Phone Icon Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>40 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-icon-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_strip_height', array( 'label'=>'Phone Strip Height', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>20,'max'=>70 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-strip-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_drawer_width', array( 'label'=>'Phone Drawer Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','vw' ), 'range'=>array( 'px'=>array( 'min'=>220,'max'=>420 ), 'vw'=>array( 'min'=>55,'max'=>100 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-drawer-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'phone_drawer_padding', array( 'label'=>'Phone Drawer Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-phone-drawer-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_strip', array( 'label'=>'Style: Top Strip', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_typography( 'strip_typography', 'Top Strip Typography', '{{WRAPPER}} .ahfs2-top-strip, {{WRAPPER}} .ahfs2-top-strip a' );
        $this->add_control( 'strip_bg', array( 'label'=>'Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-top-strip'=>'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'strip_color', array( 'label'=>'Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-top-strip, {{WRAPPER}} .ahfs2-top-strip a'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'strip_height', array( 'label'=>'Strip Height', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>20,'max'=>90 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-top-strip'=>'min-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'strip_item_gap', array( 'label'=>'Item Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>80 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-strip-grid'=>'column-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'strip_padding', array( 'label'=>'Strip Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-top-strip'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_logo', array( 'label'=>'Style: Logo', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_typography( 'logo_typography', 'Logo Text Typography', '{{WRAPPER}} .ahfs2-logo' );
        $this->add_control( 'logo_text_color', array( 'label'=>'Logo Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-logo'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'logo_width', array( 'label'=>'Logo Image Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','%' ), 'range'=>array( 'px'=>array( 'min'=>30,'max'=>320 ), '%'=>array( 'min'=>5,'max'=>100 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-logo img'=>'width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'logo_max_height', array( 'label'=>'Logo Max Height', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>20,'max'=>220 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-logo img'=>'max-height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'logo_area_width', array( 'label'=>'Logo Column Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','%' ), 'range'=>array( 'px'=>array( 'min'=>80,'max'=>420 ), '%'=>array( 'min'=>10,'max'=>50 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-header-widget'=>'--ahfs2-logo-col: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_menu', array( 'label'=>'Style: Menu', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_typography( 'menu_typography', 'Menu Typography', '{{WRAPPER}} .ahfs2-nav a' );
        $this->add_control( 'menu_color', array( 'label'=>'Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-nav a'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'menu_hover_color', array( 'label'=>'Hover Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-nav a:hover'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'menu_gap', array( 'label'=>'Menu Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>90 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-nav'=>'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'menu_margin', array( 'label'=>'Menu Margin', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-nav'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'menu_text_transform', array( 'label'=>'Text Transform', 'type'=>\Elementor\Controls_Manager::SELECT, 'options'=>array( 'uppercase'=>'Uppercase','none'=>'Normal','capitalize'=>'Capitalize' ), 'default'=>'uppercase', 'selectors'=>array( '{{WRAPPER}} .ahfs2-nav a'=>'text-transform: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_icons', array( 'label'=>'Style: Header Icons', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_typography( 'icons_typography', 'Icon Typography', '{{WRAPPER}} .ahfs2-icons a, {{WRAPPER}} .ahfs2-menu-toggle' );
        $this->add_typography( 'badge_typography', 'Badge Typography', '{{WRAPPER}} .ahfs2-cart b, {{WRAPPER}} .ahfs2-wishlist b' );
        $this->add_control( 'icon_color', array( 'label'=>'Icon Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-icons a, {{WRAPPER}} .ahfs2-menu-toggle'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'icon_bg', array( 'label'=>'Icon Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-icons a, {{WRAPPER}} .ahfs2-menu-toggle'=>'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'icon_border_color', array( 'label'=>'Icon Border Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-icons a, {{WRAPPER}} .ahfs2-menu-toggle'=>'border-color: {{VALUE}};' ) ) );
        $this->add_control( 'badge_bg', array( 'label'=>'Badge Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-cart b, {{WRAPPER}} .ahfs2-wishlist b'=>'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'badge_color', array( 'label'=>'Badge Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-cart b, {{WRAPPER}} .ahfs2-wishlist b'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'icon_box_size', array( 'label'=>'Icon Box Size', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>20,'max'=>80 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-icons a, {{WRAPPER}} .ahfs2-menu-toggle'=>'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'icon_gap', array( 'label'=>'Icon Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>50 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-icons'=>'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'icon_radius', array( 'label'=>'Icon Radius', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','%' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>60 ), '%'=>array( 'min'=>0,'max'=>50 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-icons a, {{WRAPPER}} .ahfs2-menu-toggle'=>'border-radius: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'cart_amount_color', array( 'label'=>'Cart Amount Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-cart-amount'=>'color: {{VALUE}} !important;' ) ) );
        $this->add_typography( 'cart_amount_typography', 'Cart Amount Typography', '{{WRAPPER}} .ahfs2-cart-amount' );
        $this->end_controls_section();

        $this->start_controls_section( 'style_mobile_drawer', array( 'label'=>'Style: Mobile Drawer', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_responsive_control( 'drawer_width', array( 'label'=>'Drawer Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','vw' ), 'range'=>array( 'px'=>array( 'min'=>220,'max'=>560 ), 'vw'=>array( 'min'=>40,'max'=>100 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-mobile-drawer'=>'width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'drawer_padding', array( 'label'=>'Drawer Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-mobile-drawer'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'drawer_bg', array( 'label'=>'Drawer Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-mobile-drawer'=>'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_text', array( 'label'=>'Drawer Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-mobile-drawer a'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_overlay_bg', array( 'label'=>'Overlay Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-mobile-overlay'=>'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_header_bg', array( 'label'=>'Drawer Header Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-head'=>'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'drawer_logo_width', array( 'label'=>'Drawer Logo Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','%' ), 'range'=>array( 'px'=>array( 'min'=>40,'max'=>240 ), '%'=>array( 'min'=>10,'max'=>100 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-logo img'=>'width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'drawer_head_padding', array( 'label'=>'Drawer Header Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-head'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_typography( 'drawer_menu_typography', 'Drawer Menu Typography', '{{WRAPPER}} .ahfs2-mobile-drawer nav a' );
        $this->add_responsive_control( 'drawer_menu_item_padding', array( 'label'=>'Menu Item Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-mobile-drawer nav a'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_control( 'drawer_menu_divider', array( 'label'=>'Menu Divider Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-mobile-drawer nav a'=>'border-bottom-color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_close_color', array( 'label'=>'Close Button Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-close'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_close_bg', array( 'label'=>'Close Button Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-close'=>'background-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'drawer_close_size', array( 'label'=>'Close Button Size', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>24,'max'=>70 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-close'=>'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_typography( 'drawer_strip_typography', 'Bottom Info Typography', '{{WRAPPER}} .ahfs2-drawer-strip span, {{WRAPPER}} .ahfs2-drawer-strip a' );
        $this->add_control( 'drawer_strip_color', array( 'label'=>'Bottom Info Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-strip, {{WRAPPER}} .ahfs2-drawer-strip a'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'drawer_strip_divider', array( 'label'=>'Bottom Info Divider Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-drawer-strip span, {{WRAPPER}} .ahfs2-drawer-strip a'=>'border-top-color: {{VALUE}};' ) ) );
        $this->add_shadow( 'drawer_shadow', '{{WRAPPER}} .ahfs2-mobile-drawer' );
        $this->end_controls_section();
    }

    protected function render() {
        $this->inline_css_once();
        $this->inline_js_once();
        $s = $this->get_settings_for_display();
        $logo_url = ! empty( $s['logo_image']['url'] ) ? esc_url( $s['logo_image']['url'] ) : '';
        $amount = $s['cart_amount_text'] ?? '₹120.00';
        if ( function_exists( 'WC' ) && WC()->cart ) { $amount = wp_strip_all_tags( WC()->cart->get_cart_subtotal() ); }
        echo '<div class="ahfs2-header-widget">';
        if ( $this->yes( $s, 'show_strip' ) ) {
            $strip_classes = array( 'ahfs2-top-strip' );
            if ( ! $this->yes( $s, 'show_strip_desktop' ) ) { $strip_classes[] = 'ahfs2-strip-hide-desktop'; }
            if ( ! $this->yes( $s, 'show_strip_tablet' ) ) { $strip_classes[] = 'ahfs2-strip-hide-tablet'; }
            if ( ! $this->yes( $s, 'show_strip_phone' ) ) { $strip_classes[] = 'ahfs2-strip-hide-phone'; }
            $strip_classes[] = 'ahfs2-strip-mobile-' . sanitize_html_class( $s['strip_mobile_behavior'] ?? 'scroll' );
            echo '<div class="' . esc_attr( implode( ' ', $strip_classes ) ) . '"><div class="ahfs2-strip-grid">';
            foreach ( $this->strip_items_from_settings( $s ) as $item ) {
                $content = '<span>' . esc_html( trim( ( ! empty( $item['icon'] ) ? $item['icon'] . ' ' : '' ) . $item['text'] ) ) . '</span>';
                echo ! empty( $item['url'] ) ? '<a href="' . esc_url( $item['url'] ) . '">' . $content . '</a>' : $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            echo '</div></div>';
        }
        $show_logo = $this->yes( $s, 'show_logo' );
        $show_menu = $this->yes( $s, 'show_menu' );
        $show_icons = $this->yes( $s, 'show_icons_area' );
        $classes = array( 'ahfs2-live-header' );
        if ( ! $show_logo ) { $classes[] = 'ahfs2-no-logo'; }
        if ( ! $show_menu ) { $classes[] = 'ahfs2-no-menu'; }
        if ( ! $show_icons ) { $classes[] = 'ahfs2-no-icons'; }
        if ( $this->yes( $s, 'show_main_header' ) ) {
            echo '<header class="' . esc_attr( implode( ' ', $classes ) ) . '">';
            if ( $show_logo ) {
                echo '<a class="ahfs2-logo" href="' . esc_url( home_url( '/' ) ) . '">';
                echo $logo_url ? '<img src="' . $logo_url . '" alt="' . esc_attr( $s['logo_text'] ?? 'AMALEY' ) . '">' : '<span>' . esc_html( $s['logo_text'] ?? 'AMALEY' ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo '</a>';
            }
            if ( $show_menu ) {
                echo '<nav class="ahfs2-nav">';
                foreach ( $this->menu_items_from_settings( $s ) as $item ) { echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>'; }
                echo '</nav>';
            }
            if ( $show_icons ) {
                echo '<div class="ahfs2-icons">';
                if ( $this->yes( $s, 'show_search' ) ) { echo '<a href="' . esc_url( home_url( '/?s=' ) ) . '" aria-label="Search">⌕</a>'; }
                if ( $this->yes( $s, 'show_account' ) ) { echo '<a href="' . esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' ) ) . '" aria-label="Account">♙</a>'; }
                if ( $this->yes( $s, 'show_wishlist' ) ) { echo '<a class="ahfs2-wishlist" href="#" aria-label="Wishlist">♡' . ( $this->yes( $s, 'show_wishlist_badge' ) ? '<b>0</b>' : '' ) . '</a>'; }
                if ( $this->yes( $s, 'show_cart' ) ) { $count = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 1; echo '<a class="ahfs2-cart" href="' . esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ) . '" aria-label="Cart">🛒' . ( $this->yes( $s, 'show_cart_badge' ) ? '<b>' . absint( $count ) . '</b>' : '' ) . '</a>'; }
                if ( $this->yes( $s, 'show_cart_amount' ) ) { echo '<a class="ahfs2-cart-amount" href="' . esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ) . '">' . esc_html( $amount ) . '</a>'; }
                if ( $this->yes( $s, 'show_mobile_toggle' ) ) { echo '<button class="ahfs2-menu-toggle" type="button" data-ahfs2-toggle=".ahfs2-mobile-drawer" aria-label="Menu">☰</button>'; }
                echo '</div>';
            }
            echo '</header>';
        }
        if ( $this->yes( $s, 'show_mobile_drawer' ) ) {
            $drawer_side = ( isset( $s['drawer_side'] ) && 'right' === $s['drawer_side'] ) ? 'right' : 'left';
            echo '<div class="ahfs2-mobile-overlay" hidden data-ahfs2-close></div>';
            echo '<div class="ahfs2-mobile-drawer ahfs2-drawer-' . esc_attr( $drawer_side ) . '" hidden>';
            echo '<div class="ahfs2-drawer-head">';
            if ( $this->yes( $s, 'show_mobile_drawer_logo' ) ) {
                echo '<a class="ahfs2-drawer-logo" href="' . esc_url( home_url( '/' ) ) . '">';
                if ( 'same' === ( $s['drawer_logo_source'] ?? 'same' ) && $logo_url ) {
                    echo '<img src="' . $logo_url . '" alt="' . esc_attr( $s['logo_text'] ?? 'AMALEY' ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                } else {
                    echo '<span>' . esc_html( $s['logo_text'] ?? 'AMALEY' ) . '</span>';
                }
                echo '</a>';
            }
            if ( $this->yes( $s, 'show_mobile_drawer_close' ) ) { echo '<button type="button" class="ahfs2-drawer-close" data-ahfs2-close>' . esc_html( $s['drawer_close_text'] ?? '×' ) . '</button>'; }
            echo '</div>';
            if ( $this->yes( $s, 'show_mobile_drawer_menu' ) ) {
                echo '<nav class="ahfs2-drawer-nav">';
                foreach ( $this->menu_items_from_settings( $s ) as $item ) { echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>'; }
                echo '</nav>';
            }
            if ( $this->yes( $s, 'show_mobile_drawer_strip' ) ) {
                echo '<div class="ahfs2-drawer-strip">';
                foreach ( $this->strip_items_from_settings( $s ) as $item ) {
                    $content = '<span>' . esc_html( trim( ( ! empty( $item['icon'] ) ? $item['icon'] . ' ' : '' ) . $item['text'] ) ) . '</span>';
                    echo ! empty( $item['url'] ) ? '<a href="' . esc_url( $item['url'] ) . '">' . $content . '</a>' : $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
                echo '</div>';
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

        $this->start_controls_section( 'footer_brand_content', array( 'label' => 'Footer Brand Column Content' ) );
        $this->add_control( 'logo_text', array( 'label'=>'Logo Text', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'AMALEY' ) );
        $this->add_control( 'logo_image', array( 'label'=>'Footer Logo Image', 'type'=>\Elementor\Controls_Manager::MEDIA ) );
        $this->add_control( 'kicker', array( 'label'=>'Footer Kicker', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'SMALL BATCH • NATURAL • TRACEABLE' ) );
        $this->add_control( 'description', array( 'label'=>'Description', 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>'Premium Himalayan products rooted in community enterprise, producer families, natural ingredients and small-batch production.' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'footer_shop_content', array( 'label' => 'Footer Shop Column Content' ) );
        $this->add_control( 'shop_heading_text', array( 'label'=>'Shop Heading Text', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'Shop' ) );
        $shop = new \Elementor\Repeater();
        $shop->add_control( 'label', array( 'label'=>'Label', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'All Products' ) );
        $shop->add_control( 'url', array( 'label'=>'URL', 'type'=>\Elementor\Controls_Manager::URL, 'default'=>array( 'url'=>'/shop/' ) ) );
        $shop->add_control( 'show_item', array( 'label'=>'Show Item', 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'yes' ) );
        $this->add_control( 'shop_items', array(
            'label'=>'Shop Links',
            'type'=>\Elementor\Controls_Manager::REPEATER,
            'fields'=>$shop->get_controls(),
            'title_field'=>'{{{ label }}}',
            'default'=>array(
                array( 'label'=>'All Products', 'url'=>array( 'url'=>'/shop/' ), 'show_item'=>'yes' ),
                array( 'label'=>'Himalayan Foods', 'url'=>array( 'url'=>'/product-category/himalayan-foods/' ), 'show_item'=>'yes' ),
                array( 'label'=>'Gifting', 'url'=>array( 'url'=>'/gifting/' ), 'show_item'=>'yes' ),
            ),
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'footer_eco_content', array( 'label' => 'Footer Ecosystem Column Content' ) );
        $this->add_control( 'eco_heading_text', array( 'label'=>'Ecosystem Heading Text', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'Ecosystem' ) );
        $eco = new \Elementor\Repeater();
        $eco->add_control( 'label', array( 'label'=>'Label', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'Clusters' ) );
        $eco->add_control( 'url', array( 'label'=>'URL', 'type'=>\Elementor\Controls_Manager::URL, 'default'=>array( 'url'=>'/clusters/' ) ) );
        $eco->add_control( 'show_item', array( 'label'=>'Show Item', 'type'=>\Elementor\Controls_Manager::SWITCHER, 'return_value'=>'yes', 'default'=>'yes' ) );
        $this->add_control( 'eco_items', array(
            'label'=>'Ecosystem Links',
            'type'=>\Elementor\Controls_Manager::REPEATER,
            'fields'=>$eco->get_controls(),
            'title_field'=>'{{{ label }}}',
            'default'=>array(
                array( 'label'=>'Clusters', 'url'=>array( 'url'=>'/clusters/' ), 'show_item'=>'yes' ),
                array( 'label'=>'Women Collectives', 'url'=>array( 'url'=>'/women-collectives/' ), 'show_item'=>'yes' ),
                array( 'label'=>'Producer Families', 'url'=>array( 'url'=>'/producers/' ), 'show_item'=>'yes' ),
            ),
        ) );
        $this->end_controls_section();

        $this->start_controls_section( 'footer_contact_content', array( 'label' => 'Footer Contact Column Content' ) );
        $this->add_control( 'contact_heading_text', array( 'label'=>'Contact Heading Text', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'Contact' ) );
        $this->add_control( 'phone', array( 'label'=>'Phone', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'+91-85952 27121' ) );
        $this->add_control( 'email', array( 'label'=>'Email', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'info@amaleycollective.com' ) );
        $this->add_control( 'hours', array( 'label'=>'Working Hours', 'type'=>\Elementor\Controls_Manager::TEXTAREA, 'default'=>"Monday – Friday: 9:00 – 20:00\nSaturday: 11:00 – 14:00" ) );
        $this->end_controls_section();

        $this->start_controls_section( 'footer_bottom_content', array( 'label' => 'Footer Bottom Bar Content' ) );
        $this->add_control( 'copyright', array( 'label'=>'Copyright', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'© Amaley Collective. All rights reserved.' ) );
        $this->add_control( 'designed_by', array( 'label'=>'Designed By Text', 'type'=>\Elementor\Controls_Manager::TEXT, 'default'=>'Designed by Gram Connect Impact Technologies & Consulting LLP' ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_container', array( 'label'=>'Style: Footer Container', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'footer_bg', array( 'label'=>'Footer Background', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'background-color: {{VALUE}};' ) ) );
        $this->add_control( 'footer_text_color', array( 'label'=>'Footer Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget, {{WRAPPER}} .ahfs2-footer-widget p'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'footer_padding', array( 'label'=>'Footer Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_max_width', array( 'label'=>'Inner Max Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','%' ), 'range'=>array( 'px'=>array( 'min'=>600,'max'=>1600 ), '%'=>array( 'min'=>40,'max'=>100 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-grid, {{WRAPPER}} .ahfs2-footer-bottom'=>'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_column_gap', array( 'label'=>'Column Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>140 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-grid'=>'gap: {{SIZE}}{{UNIT}}; --ahfs2-footer-col-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_layout_spacing', array( 'label'=>'Style: Footer Layout / Spacing', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'footer_brand_col_width', array( 'label'=>'Brand Column Width (fr)', 'type'=>\Elementor\Controls_Manager::NUMBER, 'min'=>0.4, 'max'=>3, 'step'=>0.05, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-grid'=>'--ahfs2-footer-brand-col: {{VALUE}}fr;' ) ) );
        $this->add_control( 'footer_shop_col_width', array( 'label'=>'Shop Column Width (fr)', 'type'=>\Elementor\Controls_Manager::NUMBER, 'min'=>0.4, 'max'=>3, 'step'=>0.05, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-grid'=>'--ahfs2-footer-shop-col: {{VALUE}}fr;' ) ) );
        $this->add_control( 'footer_eco_col_width', array( 'label'=>'Ecosystem Column Width (fr)', 'type'=>\Elementor\Controls_Manager::NUMBER, 'min'=>0.4, 'max'=>3, 'step'=>0.05, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-grid'=>'--ahfs2-footer-eco-col: {{VALUE}}fr;' ) ) );
        $this->add_control( 'footer_contact_col_width', array( 'label'=>'Contact Column Width (fr)', 'type'=>\Elementor\Controls_Manager::NUMBER, 'min'=>0.4, 'max'=>3, 'step'=>0.05, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-grid'=>'--ahfs2-footer-contact-col: {{VALUE}}fr;' ) ) );
        $this->add_responsive_control( 'footer_brand_right_space', array( 'label'=>'Brand Right Space', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>120 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-brand'=>'--ahfs2-footer-brand-mr: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_shop_left_space', array( 'label'=>'Shop Left Space', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>120 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-shop'=>'--ahfs2-footer-shop-ml: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_eco_left_space', array( 'label'=>'Ecosystem Left Space', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>120 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-ecosystem'=>'--ahfs2-footer-eco-ml: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_contact_left_space', array( 'label'=>'Contact Left Space', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>120 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-contact'=>'--ahfs2-footer-contact-ml: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_brand_padding', array( 'label'=>'Brand Column Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-brand'=>'--ahfs2-footer-brand-pad: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_shop_padding', array( 'label'=>'Shop Column Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-shop'=>'--ahfs2-footer-shop-pad: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_eco_padding', array( 'label'=>'Ecosystem Column Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-ecosystem'=>'--ahfs2-footer-eco-pad: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_contact_padding', array( 'label'=>'Contact Column Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-contact'=>'--ahfs2-footer-contact-pad: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_text_align', array( 'label'=>'Footer Text Alignment', 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array( 'left'=>array( 'title'=>'Left','icon'=>'eicon-text-align-left' ), 'center'=>array( 'title'=>'Center','icon'=>'eicon-text-align-center' ), 'right'=>array( 'title'=>'Right','icon'=>'eicon-text-align-right' ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-grid'=>'--ahfs2-footer-text-align: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_mobile_layout', array( 'label'=>'Style: Footer Mobile Layout', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'footer_mobile_layout_note', array(
            'type'=>\Elementor\Controls_Manager::RAW_HTML,
            'raw'=>'Phone/tablet layout ke liye: Brand full width, Shop + Ecosystem side-by-side, Contact full width. Ye live-style mobile footer ke liye hai.',
        ) );
        $this->add_control( 'footer_mobile_layout', array(
            'label'=>'Phone/Tablet Footer Layout',
            'type'=>\Elementor\Controls_Manager::SELECT,
            'default'=>'two',
            'options'=>array( 'two'=>'Shop + Ecosystem Side-by-side', 'stack'=>'Everything Stacked' ),
        ) );
        $this->add_control( 'footer_mobile_brand_full', array( 'label'=>'Brand Full Width on Phone/Tablet', 'type'=>\Elementor\Controls_Manager::SWITCHER, 'label_on'=>'Yes', 'label_off'=>'No', 'return_value'=>'yes', 'default'=>'yes' ) );
        $this->add_control( 'footer_mobile_contact_full', array( 'label'=>'Contact Full Width Below Columns', 'type'=>\Elementor\Controls_Manager::SWITCHER, 'label_on'=>'Yes', 'label_off'=>'No', 'return_value'=>'yes', 'default'=>'yes' ) );
        $this->add_responsive_control( 'footer_mobile_shop_width', array( 'label'=>'Mobile Shop Column Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( '%' ), 'range'=>array( '%'=>array( 'min'=>35,'max'=>65 ) ), 'default'=>array( 'size'=>50, 'unit'=>'%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'--ahfs2-footer-mobile-shop-width: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'footer_mobile_eco_width', array( 'label'=>'Mobile Ecosystem Column Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( '%' ), 'range'=>array( '%'=>array( 'min'=>35,'max'=>65 ) ), 'default'=>array( 'size'=>50, 'unit'=>'%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'--ahfs2-footer-mobile-eco-width: {{SIZE}}%;' ) ) );
        $this->add_responsive_control( 'footer_mobile_column_gap', array( 'label'=>'Mobile Shop/Ecosystem Column Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>80 ) ), 'default'=>array( 'size'=>24, 'unit'=>'px' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'--ahfs2-footer-mobile-col-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_mobile_row_gap', array( 'label'=>'Mobile Section Row Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>90 ) ), 'default'=>array( 'size'=>34, 'unit'=>'px' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'--ahfs2-footer-mobile-row-gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_mobile_padding', array( 'label'=>'Mobile Footer Padding', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em','%' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'--ahfs2-footer-mobile-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
        $this->add_responsive_control( 'footer_mobile_text_align', array( 'label'=>'Mobile Text Alignment', 'type'=>\Elementor\Controls_Manager::CHOOSE, 'options'=>array( 'left'=>array( 'title'=>'Left','icon'=>'eicon-text-align-left' ), 'center'=>array( 'title'=>'Center','icon'=>'eicon-text-align-center' ), 'right'=>array( 'title'=>'Right','icon'=>'eicon-text-align-right' ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget'=>'--ahfs2-footer-mobile-text-align: {{VALUE}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_brand', array( 'label'=>'Style: Brand Column', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_typography( 'footer_logo_typography', 'Logo Text Typography', '{{WRAPPER}} .ahfs2-footer-brand h2' );
        $this->add_responsive_control( 'footer_logo_width', array( 'label'=>'Logo Image Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','%' ), 'range'=>array( 'px'=>array( 'min'=>40,'max'=>300 ), '%'=>array( 'min'=>10,'max'=>100 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-brand img'=>'width: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_typography( 'footer_kicker_typography', 'Kicker Typography', '{{WRAPPER}} .ahfs2-kicker' );
        $this->add_control( 'footer_kicker_color', array( 'label'=>'Kicker Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-kicker'=>'color: {{VALUE}};' ) ) );
        $this->add_typography( 'footer_desc_typography', 'Description Typography', '{{WRAPPER}} .ahfs2-footer-brand p:not(.ahfs2-kicker)' );
        $this->add_control( 'footer_desc_color', array( 'label'=>'Description Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-brand p:not(.ahfs2-kicker)'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'footer_logo_bottom_gap', array( 'label'=>'Logo Bottom Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>70 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-brand img, {{WRAPPER}} .ahfs2-footer-brand h2'=>'margin-bottom: {{SIZE}}{{UNIT}} !important;' ) ) );
        $this->add_responsive_control( 'footer_kicker_gap', array( 'label'=>'Kicker Top/Bottom Gap', 'type'=>\Elementor\Controls_Manager::DIMENSIONS, 'size_units'=>array( 'px','em' ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-kicker'=>'margin: {{TOP}}{{UNIT}} 0 {{BOTTOM}}{{UNIT}} 0;' ) ) );
        $this->add_responsive_control( 'footer_desc_max_width', array( 'label'=>'Description Max Width', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px','%' ), 'range'=>array( 'px'=>array( 'min'=>120,'max'=>600 ), '%'=>array( 'min'=>20,'max'=>100 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-brand p:not(.ahfs2-kicker)'=>'max-width: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_columns', array( 'label'=>'Style: Column Headings / Links', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_typography( 'footer_heading_typography', 'Column Heading Typography', '{{WRAPPER}} .ahfs2-footer-widget h3' );
        $this->add_control( 'footer_heading_color', array( 'label'=>'Heading Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget h3'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'footer_heading_spacing', array( 'label'=>'Heading Bottom Spacing', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>60 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget h3'=>'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_typography( 'footer_link_typography', 'Footer Link Typography', '{{WRAPPER}} .ahfs2-footer-widget a' );
        $this->add_control( 'footer_link_color', array( 'label'=>'Link Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget a'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'footer_link_hover_color', array( 'label'=>'Link Hover Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget a:hover'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'footer_link_gap', array( 'label'=>'Link Row Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>50 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-widget ul'=>'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_shop_column', array( 'label'=>'Style: Shop Column', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'shop_heading_color', array( 'label'=>'Shop Heading Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-shop h3'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'shop_link_color', array( 'label'=>'Shop Link Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-shop a'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'shop_link_gap', array( 'label'=>'Shop Link Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>60 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-shop ul'=>'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_eco_column', array( 'label'=>'Style: Ecosystem Column', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_control( 'eco_heading_color', array( 'label'=>'Ecosystem Heading Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-ecosystem h3'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'eco_link_color', array( 'label'=>'Ecosystem Link Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-ecosystem a'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'eco_link_gap', array( 'label'=>'Ecosystem Link Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>60 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-ecosystem ul'=>'gap: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();

        $this->start_controls_section( 'style_footer_contact', array( 'label'=>'Style: Contact / Bottom Bar', 'tab'=>\Elementor\Controls_Manager::TAB_STYLE ) );
        $this->add_typography( 'footer_contact_typography', 'Contact Text Typography', '{{WRAPPER}} .ahfs2-footer-contact p' );
        $this->add_typography( 'footer_phone_typography', 'Phone Typography', '{{WRAPPER}} .ahfs2-footer-phone' );
        $this->add_typography( 'bottom_bar_typography', 'Bottom Bar Typography', '{{WRAPPER}} .ahfs2-footer-bottom' );
        $this->add_control( 'bottom_bar_color', array( 'label'=>'Bottom Bar Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-bottom'=>'color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'bottom_bar_margin_top', array( 'label'=>'Bottom Bar Top Gap', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>90 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-bottom'=>'margin-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->add_control( 'contact_link_color', array( 'label'=>'Contact Link Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-contact a'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'contact_text_color', array( 'label'=>'Contact Text Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-contact, {{WRAPPER}} .ahfs2-footer-contact p'=>'color: {{VALUE}};' ) ) );
        $this->add_control( 'bottom_bar_border_color', array( 'label'=>'Bottom Bar Border Color', 'type'=>\Elementor\Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-bottom'=>'border-top-color: {{VALUE}};' ) ) );
        $this->add_responsive_control( 'bottom_bar_padding_top', array( 'label'=>'Bottom Bar Padding Top', 'type'=>\Elementor\Controls_Manager::SLIDER, 'size_units'=>array( 'px' ), 'range'=>array( 'px'=>array( 'min'=>0,'max'=>70 ) ), 'selectors'=>array( '{{WRAPPER}} .ahfs2-footer-bottom'=>'padding-top: {{SIZE}}{{UNIT}};' ) ) );
        $this->end_controls_section();
    }

    protected function render() {
        $this->inline_css_once();
        $s = $this->get_settings_for_display();
        $logo_url = ! empty( $s['logo_image']['url'] ) ? esc_url( $s['logo_image']['url'] ) : '';
        $footer_mobile_layout = ( isset( $s['footer_mobile_layout'] ) && 'stack' === $s['footer_mobile_layout'] ) ? 'stack' : 'two';
        $footer_classes = array( 'ahfs2-footer-widget', 'ahfs2-footer-mobile-' . $footer_mobile_layout );
        if ( $this->yes( $s, 'footer_mobile_brand_full' ) ) { $footer_classes[] = 'ahfs2-footer-mobile-brand-full'; }
        if ( $this->yes( $s, 'footer_mobile_contact_full' ) ) { $footer_classes[] = 'ahfs2-footer-mobile-contact-full'; }
        echo '<footer class="' . esc_attr( implode( ' ', $footer_classes ) ) . '">';
        $cols = 0; foreach ( array( 'show_brand_col','show_shop_col','show_eco_col','show_contact_col' ) as $c ) { if ( $this->yes( $s, $c ) ) { $cols++; } }
        echo '<div class="ahfs2-footer-grid ahfs2-footer-cols-' . absint( max( 1, $cols ) ) . '">';
        if ( $this->yes( $s, 'show_brand_col' ) ) {
            echo '<div class="ahfs2-footer-brand">';
            if ( $this->yes( $s, 'show_footer_logo' ) ) { echo $logo_url ? '<img src="' . $logo_url . '" alt="' . esc_attr( $s['logo_text'] ?? 'AMALEY' ) . '" style="max-width:100%;height:auto;margin-bottom:18px">' : '<h2>' . esc_html( $s['logo_text'] ?? 'AMALEY' ) . '</h2>'; }
            if ( $this->yes( $s, 'show_kicker' ) ) { echo '<p class="ahfs2-kicker">' . esc_html( $s['kicker'] ?? '' ) . '</p>'; }
            if ( $this->yes( $s, 'show_description' ) ) { echo '<p>' . esc_html( $s['description'] ?? '' ) . '</p>'; }
            echo '</div>';
        }
        if ( $this->yes( $s, 'show_shop_col' ) ) { echo '<div class="ahfs2-footer-shop">' . ( $this->yes( $s, 'show_shop_heading' ) ? '<h3>' . esc_html( $s['shop_heading_text'] ?? 'Shop' ) . '</h3>' : '' ) . ( $this->yes( $s, 'show_shop_links' ) ? self::link_items( $s['shop_items'] ?? array(), $s['shop_links'] ?? '' ) : '' ) . '</div>'; }
        if ( $this->yes( $s, 'show_eco_col' ) ) { echo '<div class="ahfs2-footer-ecosystem">' . ( $this->yes( $s, 'show_eco_heading' ) ? '<h3>' . esc_html( $s['eco_heading_text'] ?? 'Ecosystem' ) . '</h3>' : '' ) . ( $this->yes( $s, 'show_eco_links' ) ? self::link_items( $s['eco_items'] ?? array(), $s['eco_links'] ?? '' ) : '' ) . '</div>'; }
        if ( $this->yes( $s, 'show_contact_col' ) ) {
            echo '<div class="ahfs2-footer-contact">';
            if ( $this->yes( $s, 'show_contact_heading' ) ) { echo '<h3>' . esc_html( $s['contact_heading_text'] ?? 'Contact' ) . '</h3>'; }
            if ( $this->yes( $s, 'show_phone' ) ) { echo '<p class="ahfs2-footer-phone">' . esc_html( $s['phone'] ?? '' ) . '</p>'; }
            if ( $this->yes( $s, 'show_hours' ) ) { echo '<p>' . nl2br( esc_html( $s['hours'] ?? '' ) ) . '</p>'; }
            if ( $this->yes( $s, 'show_email' ) ) { echo '<p style="margin-top:18px"><a href="mailto:' . esc_attr( $s['email'] ?? '' ) . '">' . esc_html( $s['email'] ?? '' ) . '</a></p>'; }
            echo '</div>';
        }
        echo '</div>';
        if ( $this->yes( $s, 'show_bottom_bar' ) ) {
            echo '<div class="ahfs2-footer-bottom">';
            if ( $this->yes( $s, 'show_copyright' ) ) { echo '<span>' . esc_html( $s['copyright'] ?? '' ) . '</span>'; }
            if ( $this->yes( $s, 'show_designed_by' ) ) { echo '<span>' . esc_html( $s['designed_by'] ?? '' ) . '</span>'; }
            echo '</div>';
        }
        echo '</footer>';
    }

    private static function link_items( $items, $fallback_text = '' ) {
        if ( is_array( $items ) && ! empty( $items ) ) {
            $out = '<ul>';
            foreach ( $items as $item ) {
                if ( is_array( $item ) && isset( $item['show_item'] ) && 'yes' !== $item['show_item'] ) { continue; }
                $label = trim( (string) ( $item['label'] ?? '' ) );
                if ( '' === $label ) { continue; }
                $url = '#';
                if ( ! empty( $item['url']['url'] ) ) { $url = $item['url']['url']; }
                $target = ! empty( $item['url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
                $out .= '<li><a href="' . esc_url( $url ) . '"' . $target . '>' . esc_html( $label ) . '</a></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            return $out . '</ul>';
        }
        return self::link_list( $fallback_text );
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
