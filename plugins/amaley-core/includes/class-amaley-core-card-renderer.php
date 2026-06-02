<?php
/**
 * Amaley Core Card Renderer.
 *
 * v1.0.81 locks the final shared card structure for Product, SHG, Cluster and Member cards.
 * v1.0.82 supports assigned-template URL overrides and Cluster Single SHG/Member card migration.
 * v1.0.82.1 keeps card CSS registration resilient when renderers are called inside Elementor.
 * v1.0.82.2 keeps final card structure unchanged and improves visual rhythm via scoped CSS.
 * v1.0.86 locks OG Card 1 design flow for Cluster, SHG, Member and Product families without changing accepted card visuals.
 * Existing frontend widgets are still migrated one by one in later versions.
 *
 * @package Amaley_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Core_Card_Renderer {
    /**
     * Render a card by family.
     *
     * @param string $family Card family.
     * @param int    $post_id Post/product ID.
     * @param array  $args Rendering args.
     * @return string
     */
    public static function render( $family, $post_id, $args = array() ) {
        self::enqueue_assets();

        $family = sanitize_key( $family );
        if ( 'product' === $family ) {
            return self::render_product( $post_id, $args );
        }
        if ( 'shg' === $family ) {
            return self::render_shg( $post_id, $args );
        }
        if ( 'cluster' === $family ) {
            return self::render_cluster( $post_id, $args );
        }
        if ( 'member' === $family ) {
            return self::render_member( $post_id, $args );
        }

        return '';
    }

    /**
     * Enqueue card CSS when renderer is used.
     *
     * @return void
     */
    private static function enqueue_assets() {
        if ( function_exists( 'wp_enqueue_style' ) ) {
            if ( ! wp_style_is( 'amaley-core-cards', 'registered' ) && defined( 'AMALEY_CORE_URL' ) ) {
                wp_register_style(
                    'amaley-core-cards',
                    AMALEY_CORE_URL . 'assets/amaley-core-cards.css',
                    array(),
                    defined( 'AMALEY_CORE_VERSION' ) ? AMALEY_CORE_VERSION : '1.0.82.2'
                );
            }
            wp_enqueue_style( 'amaley-core-cards' );
        }
    }

    /**
     * Shared args defaults.
     *
     * @param array $args Raw args.
     * @return array
     */
    private static function defaults( $args ) {
        return wp_parse_args( is_array( $args ) ? $args : array(), array(
            'preset' => 'compact',
            'show_image' => true,
            'show_label' => true,
            'show_title' => true,
            'show_excerpt' => true,
            'show_meta' => true,
            'show_tags' => true,
            'show_button' => true,
            'button_text' => 'View Details',
            'url' => '',
            'label_text' => '',
            'excerpt_words' => 16,
            'class' => '',
        ) );
    }

    /**
     * Render Product card.
     *
     * Final shared structure:
     * media → label → title → excerpt → meta boxes → tags → button.
     *
     * @param int   $product_id Product ID.
     * @param array $args Args.
     * @return string
     */
    public static function render_product( $product_id, $args = array() ) {
        self::enqueue_assets();

        $args = self::defaults( $args );
        $product_id = absint( $product_id );
        if ( ! $product_id || 'product' !== get_post_type( $product_id ) ) {
            return '';
        }

        $title = get_the_title( $product_id );
        $image = get_the_post_thumbnail_url( $product_id, 'large' );
        $url = ! empty( $args['url'] ) ? esc_url_raw( $args['url'] ) : get_permalink( $product_id );
        $price = '';

        if ( function_exists( 'wc_get_product' ) ) {
            $product = wc_get_product( $product_id );
            if ( $product ) {
                $price = $product->get_price_html();
            }
        }

        $origin = get_post_meta( $product_id, '_amaley_origin_source_village', true );
        if ( ! $origin ) {
            $cluster_id = absint( get_post_meta( $product_id, '_amaley_origin_cluster_id', true ) );
            $origin = $cluster_id ? get_the_title( $cluster_id ) : '';
        }

        $excerpt_words = self::number_between( isset( $args['excerpt_words'] ) ? $args['excerpt_words'] : 16, 6, 40 );
        $excerpt = get_the_excerpt( $product_id );
        if ( '' === trim( (string) $excerpt ) ) {
            $excerpt = wp_strip_all_tags( get_post_field( 'post_content', $product_id ) );
        }

        $label_text = isset( $args['label_text'] ) && '' !== trim( (string) $args['label_text'] ) ? trim( (string) $args['label_text'] ) : 'Product';

        return self::card_markup( 'product', $product_id, array(
            'classes' => self::classes( 'product', $args ),
            'title' => $title,
            'label' => $label_text,
            'excerpt' => $excerpt ? wp_trim_words( $excerpt, $excerpt_words ) : '',
            'image' => $image,
            'placeholder' => 'Product',
            'placeholder_initials' => self::initials( $title ),
            'meta' => array(
                array( 'label' => 'Price', 'value' => $price ? $price : 'View product', 'html' => true, 'class' => 'amaley-card__price' ),
                array( 'label' => 'Origin', 'value' => $origin ? $origin : 'Mapped to this cluster' ),
            ),
            'tags' => array( 'Traceable', 'Origin linked' ),
            'url' => $url,
            'button_text' => isset( $args['button_text'] ) && $args['button_text'] ? $args['button_text'] : 'View Product',
            'args' => $args,
        ) );
    }

    /**
     * Render SHG / Collective card.
     *
     * @param int   $shg_id SHG ID.
     * @param array $args Args.
     * @return string
     */
    public static function render_shg( $shg_id, $args = array() ) {
        self::enqueue_assets();

        $args = self::defaults( $args );
        $shg_id = absint( $shg_id );
        if ( ! $shg_id || false === get_post_status( $shg_id ) ) {
            return '';
        }

        $title = get_the_title( $shg_id );
        $image = self::image_for_post( $shg_id );
        $story = get_post_meta( $shg_id, '_amaley_short_story', true );
        $village = get_post_meta( $shg_id, '_amaley_village', true );
        $district = get_post_meta( $shg_id, '_amaley_district', true );
        $members = get_post_meta( $shg_id, '_amaley_member_count', true );
        $verification = get_post_meta( $shg_id, '_amaley_verification_status', true );
        $contact = get_post_meta( $shg_id, '_amaley_contact_person', true );
        $products = get_post_meta( $shg_id, '_amaley_product_categories', true );
        if ( ! $products ) {
            $products = get_post_meta( $shg_id, '_amaley_main_products', true );
        }

        $label_text = isset( $args['label_text'] ) && '' !== trim( (string) $args['label_text'] ) ? trim( (string) $args['label_text'] ) : 'SHG';

        return self::card_markup( 'shg', $shg_id, array(
            'classes' => self::classes( 'shg', $args ),
            'title' => $title,
            'label' => $label_text,
            'excerpt' => $story ? wp_trim_words( $story, self::number_between( $args['excerpt_words'], 8, 40 ) ) : '',
            'image' => $image,
            'placeholder' => 'SHG',
            'placeholder_initials' => self::initials( $title ),
            'meta' => array(
                array( 'label' => 'Village', 'value' => $village ),
                array( 'label' => 'District', 'value' => $district ),
                array( 'label' => 'Members', 'value' => $members ),
                array( 'label' => 'Verification', 'value' => $verification ? $verification : 'Verified' ),
                array( 'label' => 'Contact', 'value' => $contact, 'wide' => true ),
            ),
            'tags' => self::split_tags( $products, 4 ),
            'url' => ! empty( $args['url'] ) ? esc_url_raw( $args['url'] ) : get_permalink( $shg_id ),
            'button_text' => isset( $args['button_text'] ) && $args['button_text'] ? $args['button_text'] : 'View Collective Details',
            'args' => $args,
        ) );
    }

    /**
     * Render Cluster card.
     *
     * Same design flow as the SHG card, with source-cluster data.
     *
     * @param int   $cluster_id Cluster ID.
     * @param array $args Args.
     * @return string
     */
    public static function render_cluster( $cluster_id, $args = array() ) {
        self::enqueue_assets();

        $args = self::defaults( $args );
        $cluster_id = absint( $cluster_id );
        if ( ! $cluster_id || 'amaley_cluster' !== get_post_type( $cluster_id ) ) {
            return '';
        }

        $title = get_the_title( $cluster_id );
        $image = self::image_for_post( $cluster_id );
        $intro = get_post_meta( $cluster_id, '_amaley_short_intro', true );
        if ( ! $intro ) {
            $intro = get_post_meta( $cluster_id, '_amaley_story', true );
        }

        $region = get_post_meta( $cluster_id, '_amaley_region', true );
        $district = get_post_meta( $cluster_id, '_amaley_district', true );
        $villages = get_post_meta( $cluster_id, '_amaley_villages', true );
        $main_products = get_post_meta( $cluster_id, '_amaley_main_products', true );
        $status = get_post_meta( $cluster_id, '_amaley_status', true );

        $label_text = isset( $args['label_text'] ) && '' !== trim( (string) $args['label_text'] ) ? trim( (string) $args['label_text'] ) : ( $region ? $region : 'Source Cluster' );

        return self::card_markup( 'cluster', $cluster_id, array(
            'classes' => self::classes( 'cluster', $args ),
            'title' => $title,
            'label' => $label_text,
            'excerpt' => $intro ? wp_trim_words( $intro, self::number_between( $args['excerpt_words'], 8, 40 ) ) : '',
            'image' => $image,
            'placeholder' => 'Cluster',
            'placeholder_initials' => self::initials( $title ),
            'meta' => array(
                array( 'label' => 'District', 'value' => $district ),
                array( 'label' => 'Villages', 'value' => $villages ),
                array( 'label' => 'Products', 'value' => $main_products ),
                array( 'label' => 'Status', 'value' => $status ? $status : 'Mapped' ),
            ),
            'tags' => self::split_tags( $main_products, 4 ),
            'url' => ! empty( $args['url'] ) ? esc_url_raw( $args['url'] ) : get_permalink( $cluster_id ),
            'button_text' => isset( $args['button_text'] ) && $args['button_text'] ? $args['button_text'] : 'View Cluster Details',
            'args' => $args,
        ) );
    }

    /**
     * Render Member / Producer card.
     *
     * @param int   $member_id Member ID.
     * @param array $args Args.
     * @return string
     */
    public static function render_member( $member_id, $args = array() ) {
        self::enqueue_assets();

        $args = self::defaults( $args );
        $member_id = absint( $member_id );
        if ( ! $member_id || 'amaley_member' !== get_post_type( $member_id ) ) {
            return '';
        }

        $title = get_the_title( $member_id );
        $image = self::image_for_post( $member_id );
        $role = get_post_meta( $member_id, '_amaley_role', true );
        $village = get_post_meta( $member_id, '_amaley_village', true );
        $phone = get_post_meta( $member_id, '_amaley_phone', true );
        $bio = get_post_meta( $member_id, '_amaley_short_bio', true );
        if ( ! $bio ) {
            $bio = get_post_meta( $member_id, '_amaley_short_story', true );
        }
        $skills = get_post_meta( $member_id, '_amaley_skills', true );
        if ( ! $skills ) {
            $skills = get_post_meta( $member_id, '_amaley_products_handled', true );
        }

        $label_text = isset( $args['label_text'] ) && '' !== trim( (string) $args['label_text'] ) ? trim( (string) $args['label_text'] ) : 'Producer';

        return self::card_markup( 'member', $member_id, array(
            'classes' => self::classes( 'member', $args ),
            'title' => $title,
            'label' => $label_text,
            'excerpt' => $bio ? wp_trim_words( $bio, self::number_between( $args['excerpt_words'], 8, 40 ) ) : '',
            'image' => $image,
            'placeholder' => 'Producer',
            'placeholder_initials' => self::initials( $title ),
            'meta' => array(
                array( 'label' => 'Role', 'value' => $role ),
                array( 'label' => 'Village', 'value' => $village ),
                array( 'label' => 'Phone', 'value' => $phone ),
            ),
            'tags' => self::split_tags( $skills, 4 ),
            'url' => ! empty( $args['url'] ) ? esc_url_raw( $args['url'] ) : get_permalink( $member_id ),
            'button_text' => isset( $args['button_text'] ) && $args['button_text'] ? $args['button_text'] : 'View Producer Profile',
            'args' => $args,
        ) );
    }

    /**
     * Shared card markup.
     *
     * This keeps future add-ons easier: extra blocks can be added here without rebuilding all cards.
     *
     * @param string $family Card family.
     * @param int    $post_id Post ID.
     * @param array  $data Card data.
     * @return string
     */
    private static function card_markup( $family, $post_id, $data ) {
        $args = isset( $data['args'] ) ? $data['args'] : array();

        $out = '<article class="' . esc_attr( $data['classes'] ) . '" data-amaley-card-family="' . esc_attr( $family ) . '" data-amaley-card-id="' . esc_attr( absint( $post_id ) ) . '">';

        if ( ! empty( $args['show_image'] ) ) {
            $out .= '<div class="amaley-card__media">';
            if ( ! empty( $data['image'] ) ) {
                $out .= '<img src="' . esc_url( $data['image'] ) . '" alt="' . esc_attr( $data['title'] ) . '" loading="lazy" />';
            } else {
                $out .= '<span class="amaley-card__initials" aria-hidden="true">' . esc_html( ! empty( $data['placeholder_initials'] ) ? $data['placeholder_initials'] : $data['placeholder'] ) . '</span>';
            }
            $out .= '</div>';
        }

        $out .= '<div class="amaley-card__body">';

        if ( ! empty( $args['show_label'] ) && ! empty( $data['label'] ) ) {
            $out .= '<p class="amaley-card__label">' . esc_html( $data['label'] ) . '</p>';
        }

        if ( ! empty( $args['show_title'] ) && ! empty( $data['title'] ) ) {
            $out .= '<h3 class="amaley-card__title">' . esc_html( $data['title'] ) . '</h3>';
        }

        if ( ! empty( $args['show_excerpt'] ) && ! empty( $data['excerpt'] ) ) {
            $out .= '<p class="amaley-card__excerpt">' . esc_html( $data['excerpt'] ) . '</p>';
        }

        if ( ! empty( $args['show_meta'] ) && ! empty( $data['meta'] ) ) {
            $out .= self::meta_markup( $data['meta'] );
        }

        if ( ! empty( $args['show_tags'] ) && ! empty( $data['tags'] ) ) {
            $out .= self::tags_markup( $data['tags'] );
        }

        if ( ! empty( $args['show_button'] ) && ! empty( $data['url'] ) ) {
            $out .= '<a class="amaley-card__button" href="' . esc_url( $data['url'] ) . '">' . esc_html( $data['button_text'] ) . '</a>';
        }

        $out .= '</div></article>';

        return $out;
    }

    /**
     * Meta box markup.
     *
     * @param array $items Meta items.
     * @return string
     */
    private static function meta_markup( $items ) {
        $clean_items = array();

        foreach ( (array) $items as $item ) {
            $value = isset( $item['value'] ) ? $item['value'] : '';
            if ( '' === trim( wp_strip_all_tags( (string) $value ) ) ) {
                continue;
            }
            $clean_items[] = $item;
        }

        if ( empty( $clean_items ) ) {
            return '';
        }

        $out = '<div class="amaley-card__meta">';
        foreach ( $clean_items as $item ) {
            $wide = ! empty( $item['wide'] ) ? ' amaley-card__meta-item--wide' : '';
            $class = ! empty( $item['class'] ) ? ' ' . sanitize_html_class( $item['class'] ) : '';
            $out .= '<div class="amaley-card__meta-item' . esc_attr( $wide ) . '">';
            $out .= '<span>' . esc_html( isset( $item['label'] ) ? $item['label'] : '' ) . '</span>';
            if ( ! empty( $item['html'] ) ) {
                $out .= '<strong class="' . esc_attr( trim( $class ) ) . '">' . wp_kses_post( $item['value'] ) . '</strong>';
            } else {
                $out .= '<strong class="' . esc_attr( trim( $class ) ) . '">' . esc_html( $item['value'] ) . '</strong>';
            }
            $out .= '</div>';
        }
        $out .= '</div>';

        return $out;
    }

    /**
     * Tag/chip markup.
     *
     * @param array $tags Tags.
     * @return string
     */
    private static function tags_markup( $tags ) {
        $tags = array_values( array_filter( array_map( 'trim', (array) $tags ) ) );
        if ( empty( $tags ) ) {
            return '';
        }

        $out = '<div class="amaley-card__tags">';
        foreach ( $tags as $tag ) {
            $out .= '<span>' . esc_html( $tag ) . '</span>';
        }
        $out .= '</div>';

        return $out;
    }

    /**
     * Split CSV/newline/pipe tags.
     *
     * @param string $value Raw tag string.
     * @param int    $limit Max tags.
     * @return array
     */
    private static function split_tags( $value, $limit = 4 ) {
        if ( is_array( $value ) ) {
            $parts = $value;
        } else {
            $parts = preg_split( '/[\r\n,|]+/', (string) $value );
        }

        return array_slice( array_values( array_filter( array_map( 'trim', (array) $parts ) ) ), 0, absint( $limit ) );
    }

    /**
     * Resolve image from featured image or custom image URL.
     *
     * @param int $post_id Post ID.
     * @return string
     */
    private static function image_for_post( $post_id ) {
        $image = get_the_post_thumbnail_url( $post_id, 'large' );
        if ( $image ) {
            return $image;
        }

        $photo = get_post_meta( $post_id, '_amaley_photo_url', true );
        if ( $photo ) {
            return esc_url_raw( $photo );
        }

        return '';
    }

    /**
     * Initials for image fallback.
     *
     * @param string $title Title.
     * @return string
     */
    private static function initials( $title ) {
        $title = trim( wp_strip_all_tags( (string) $title ) );
        if ( '' === $title ) {
            return 'A';
        }

        $words = preg_split( '/\s+/', $title );
        $initials = '';
        foreach ( $words as $word ) {
            if ( '' === $word ) {
                continue;
            }
            $initials .= mb_substr( $word, 0, 1 );
            if ( strlen( $initials ) >= 2 ) {
                break;
            }
        }

        return strtoupper( $initials ? $initials : mb_substr( $title, 0, 1 ) );
    }

    /**
     * Bound a number.
     *
     * @param mixed $value Value.
     * @param int   $min Minimum.
     * @param int   $max Maximum.
     * @return int
     */
    private static function number_between( $value, $min, $max ) {
        return max( absint( $min ), min( absint( $max ), absint( $value ) ) );
    }

    /**
     * Build card classes.
     *
     * @param string $family Card family.
     * @param array  $args Args.
     * @return string
     */
    private static function classes( $family, $args ) {
        $preset = isset( $args['preset'] ) ? sanitize_key( $args['preset'] ) : 'compact';
        $extra = isset( $args['class'] ) ? sanitize_html_class( $args['class'] ) : '';

        $classes = array(
            'amaley-card',
            'amaley-card--' . sanitize_html_class( $family ),
            'amaley-card--' . sanitize_html_class( $preset ),
        );

        if ( $extra ) {
            $classes[] = $extra;
        }

        return implode( ' ', array_filter( $classes ) );
    }
}
