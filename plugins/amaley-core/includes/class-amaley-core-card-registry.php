<?php
/**
 * Amaley Core Card Registry.
 *
 * v1.0.79 base only. It defines reusable card families, presets and assignment locations.
 * It does not replace any existing frontend card output by itself.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Card_Registry {
    const SETTINGS_OPTION = 'amaley_core_template_settings';

    /**
     * Return card families.
     *
     * @return array
     */
    public static function card_families() {
        return array(
            'product' => array(
                'label' => 'Product Card',
                'description' => 'WooCommerce product card rendered through Amaley Core when connected by widgets or Discovery Engine.',
            ),
            'shg' => array(
                'label' => 'SHG / Collective Card',
                'description' => 'Reusable collective card for SHG archives, cluster-linked SHGs and member-linked SHGs.',
            ),
            'cluster' => array(
                'label' => 'Cluster Card',
                'description' => 'Reusable source cluster / territory card.',
            ),
            'member' => array(
                'label' => 'Member / Producer Card',
                'description' => 'Reusable producer card for archives, SHG members and future ecosystem sections.',
            ),
        );
    }

    /**
     * Return card presets by family.
     *
     * @return array
     */
    public static function card_presets() {
        /*
         * v1.0.85.1: One clear OG template per card family.
         * More templates can be added later only when a new design is approved.
         */
        return array(
            'product' => array(
                'og_product_card_1' => 'OG Product Card 1',
            ),
            'shg' => array(
                'og_shg_card_1' => 'OG SHG Card 1',
            ),
            'cluster' => array(
                'og_cluster_card_1' => 'OG Cluster Card 1',
            ),
            'member' => array(
                'og_member_card_1' => 'OG Member Card 1',
            ),
        );
    }

    /**
     * Locked OG card template definitions.
     *
     * These definitions describe the approved card flow without changing any frontend output by themselves.
     * Future approved templates can be added as OG Cluster Card 2, OG SHG Card 2, etc.
     *
     * @return array
     */
    public static function og_card_template_definitions() {
        return array(
            'cluster' => array(
                'og_cluster_card_1' => array(
                    'label' => 'OG Cluster Card 1',
                    'family' => 'cluster',
                    'flow' => array( 'media', 'label', 'title', 'description', 'meta_boxes', 'tags', 'button' ),
                    'description' => 'Approved cluster card following the same origin-card flow as SHG, Member and Product cards.',
                    'future_slots' => array( 'badge', 'icon', 'verification', 'extra_meta', 'secondary_button' ),
                ),
            ),
            'shg' => array(
                'og_shg_card_1' => array(
                    'label' => 'OG SHG Card 1',
                    'family' => 'shg',
                    'flow' => array( 'media', 'label', 'title', 'description', 'meta_boxes', 'tags', 'button' ),
                    'description' => 'Approved SHG / collective card based on the accepted Cluster Single SHG card design.',
                    'future_slots' => array( 'badge', 'icon', 'verification', 'extra_meta', 'secondary_button' ),
                ),
            ),
            'member' => array(
                'og_member_card_1' => array(
                    'label' => 'OG Member Card 1',
                    'family' => 'member',
                    'flow' => array( 'media', 'label', 'title', 'description', 'meta_boxes', 'tags', 'button' ),
                    'description' => 'Approved producer/member card based on the accepted Cluster Single Producer card design.',
                    'future_slots' => array( 'badge', 'icon', 'verification', 'extra_meta', 'secondary_button' ),
                ),
            ),
            'product' => array(
                'og_product_card_1' => array(
                    'label' => 'OG Product Card 1',
                    'family' => 'product',
                    'flow' => array( 'media', 'label', 'title', 'description', 'meta_boxes', 'tags', 'button' ),
                    'description' => 'Approved product card based on the existing Amaley product card design.',
                    'future_slots' => array( 'badge', 'icon', 'stock', 'extra_meta', 'secondary_button' ),
                ),
            ),
        );
    }

    /**
     * Return global assignment locations.
     *
     * @return array
     */
    public static function assignment_locations() {
        return array(
            'product' => array(
                'card_product_discovery_grid' => 'Discovery Product Grid',
                'card_product_member_single_products' => 'Member Single Products',
                'card_product_shg_single_products' => 'SHG Single Products',
                'card_product_cluster_single_products' => 'Cluster Single Products',
                'card_product_home_sections' => 'Homepage / Featured Product Sections',
            ),
            'shg' => array(
                'card_shg_member_single_linked' => 'Member Single Linked SHG',
                'card_shg_cluster_single_list' => 'Cluster Single SHG List',
                'card_shg_archive' => 'SHG Archive',
                'card_shg_ecosystem_sections' => 'Ecosystem SHG Sections',
            ),
            'cluster' => array(
                'card_cluster_member_single_linked' => 'Member Single Linked Cluster',
                'card_cluster_archive' => 'Cluster Archive',
                'card_cluster_shg_single_linked' => 'SHG Single Linked Cluster',
                'card_cluster_ecosystem_sections' => 'Ecosystem Cluster Sections',
            ),
            'member' => array(
                'card_member_shg_single_members' => 'SHG Single Members',
                'card_member_archive' => 'Member / Producer Archive',
                'card_member_cluster_producers' => 'Cluster Producers',
                'card_member_ecosystem_sections' => 'Ecosystem Producer Sections',
            ),
        );
    }

    /**
     * Default assignment values.
     *
     * @return array
     */
    public static function default_assignments() {
        return array(
            // v1.0.85: Simple family-level card templates.
            // These are the only card template settings shown in Amaley Core Settings.
            'card_template_product' => 'og_product_card_1',
            'card_template_shg' => 'og_shg_card_1',
            'card_template_cluster' => 'og_cluster_card_1',
            'card_template_member' => 'og_member_card_1',

            // Legacy internal location keys retained only for backward compatibility.
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
        );
    }

    /**
     * Get preset options for a family.
     *
     * @param string $family Card family key.
     * @return array
     */
    public static function preset_options_for_family( $family ) {
        $presets = self::card_presets();
        return isset( $presets[ $family ] ) ? $presets[ $family ] : array();
    }

    /**
     * Get all saved settings merged with assignment defaults.
     *
     * @return array
     */
    public static function settings() {
        $defaults = self::default_assignments();
        $saved = get_option( self::SETTINGS_OPTION, array() );
        return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
    }

    /**
     * Resolve assignment for a location.
     *
     * @param string $location Assignment key.
     * @param string $fallback Fallback preset.
     * @return string
     */
    public static function get_assignment( $location, $fallback = '' ) {
        $settings = self::settings();
        $defaults = self::default_assignments();

        /*
         * v1.0.85.1 simple model:
         * Section/location keys resolve to one family-level OG template.
         * Old saved preset values are normalized to the OG template so old settings do not keep confusing options alive.
         */
        $family = self::family_from_assignment_key( $location );
        if ( $family ) {
            $generic_key = 'card_template_' . $family;
            if ( isset( $settings[ $generic_key ] ) && '' !== $settings[ $generic_key ] ) {
                return self::normalize_family_preset( $family, $settings[ $generic_key ] );
            }
            if ( isset( $defaults[ $generic_key ] ) ) {
                return sanitize_key( $defaults[ $generic_key ] );
            }
        }

        if ( isset( $settings[ $location ] ) && '' !== $settings[ $location ] ) {
            return $family ? self::normalize_family_preset( $family, $settings[ $location ] ) : sanitize_key( $settings[ $location ] );
        }
        if ( isset( $defaults[ $location ] ) ) {
            return sanitize_key( $defaults[ $location ] );
        }
        return $family ? self::normalize_family_preset( $family, $fallback ) : sanitize_key( $fallback );
    }

    /**
     * Normalize legacy/old preset names to the single OG card template for each family.
     *
     * @param string $family Card family.
     * @param string $preset Raw preset.
     * @return string
     */
    public static function normalize_family_preset( $family, $preset = '' ) {
        $map = array(
            'product' => 'og_product_card_1',
            'shg' => 'og_shg_card_1',
            'cluster' => 'og_cluster_card_1',
            'member' => 'og_member_card_1',
        );

        $family = sanitize_key( $family );
        if ( isset( $map[ $family ] ) ) {
            return $map[ $family ];
        }

        return sanitize_key( $preset );
    }

    /**
     * Check whether a preset is valid for a family.
     *
     * @param string $family Card family.
     * @param string $preset Preset key.
     * @return bool
     */
    public static function is_valid_preset( $family, $preset ) {
        $options = self::preset_options_for_family( $family );
        return isset( $options[ $preset ] );
    }

    /**
     * Resolve family from assignment key.
     *
     * @param string $key Assignment setting key.
     * @return string
     */
    public static function family_from_assignment_key( $key ) {
        if ( 'card_template_product' === $key || 0 === strpos( $key, 'card_product_' ) ) {
            return 'product';
        }
        if ( 'card_template_shg' === $key || 0 === strpos( $key, 'card_shg_' ) ) {
            return 'shg';
        }
        if ( 'card_template_cluster' === $key || 0 === strpos( $key, 'card_cluster_' ) ) {
            return 'cluster';
        }
        if ( 'card_template_member' === $key || 0 === strpos( $key, 'card_member_' ) ) {
            return 'member';
        }
        return '';
    }
}
