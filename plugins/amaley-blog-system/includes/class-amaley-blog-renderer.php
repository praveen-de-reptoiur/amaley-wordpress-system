<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Renderer {
    public static function card( $post_id, $args = array() ) {
        $defaults = array(
            'template'          => 'blog_card_1',
            'show_image'        => true,
            'show_category'     => true,
            'show_date'         => true,
            'show_author'       => false,
            'show_reading_time' => true,
            'show_excerpt'      => true,
            'show_button'       => true,
            'excerpt_length'    => 22,
            'button_text'       => __( 'Read More', 'amaley-blog-system' ),
            'fallback_image'    => '',
            'auto_fallback'     => true,
        );
        $args    = wp_parse_args( $args, $defaults );
        $post_id = absint( $post_id );

        if ( ! $post_id ) {
            return '';
        }

        $permalink = get_permalink( $post_id );
        $title     = get_the_title( $post_id );
        $excerpt   = self::excerpt( $post_id, absint( $args['excerpt_length'] ) );
        $category  = self::primary_category( $post_id );
        $image     = get_the_post_thumbnail_url( $post_id, 'large' );
        $category_slug = $category ? $category->slug : '';
        $tag_terms = get_the_terms( $post_id, 'post_tag' );
        $tag_slugs = array();
        $tag_names = array();
        if ( ! empty( $tag_terms ) && ! is_wp_error( $tag_terms ) ) {
            foreach ( $tag_terms as $tag_term ) {
                $tag_slugs[] = $tag_term->slug;
                $tag_names[] = $tag_term->name;
            }
        }
        $search_blob = trim( $title . ' ' . $excerpt . ' ' . ( $category ? $category->name : '' ) . ' ' . implode( ' ', $tag_names ) );

        if ( ! $image && ! empty( $args['fallback_image'] ) ) {
            $image = esc_url( $args['fallback_image'] );
        }

        if ( ! $image && ! empty( $args['auto_fallback'] ) ) {
            $image = self::asset_url( 'assets/img/blog-card-placeholder.svg' );
        }

        ob_start();
        ?>
        <article class="amaley-blog-card amaley-blog-card--style-1" data-amaley-blog-card data-title="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>" data-date="<?php echo esc_attr( get_post_time( 'U', true, $post_id ) ); ?>" data-category="<?php echo esc_attr( $category_slug ); ?>" data-tags="<?php echo esc_attr( implode( ' ', $tag_slugs ) ); ?>" data-search="<?php echo esc_attr( wp_strip_all_tags( strtolower( $search_blob ) ) ); ?>">
            <?php if ( $args['show_image'] ) : ?>
                <a class="amaley-blog-card__media" href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
                    <?php if ( $image ) : ?>
                        <img class="amaley-blog-card__image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
                    <?php endif; ?>
                    <?php if ( $args['show_category'] && $category ) : ?>
                        <span class="amaley-blog-card__category"><?php echo esc_html( $category->name ); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <div class="amaley-blog-card__body">
                <?php if ( ! $args['show_image'] && $args['show_category'] && $category ) : ?>
                    <span class="amaley-blog-card__category amaley-blog-card__category--inline"><?php echo esc_html( $category->name ); ?></span>
                <?php endif; ?>

                <h3 class="amaley-blog-card__title">
                    <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
                </h3>

                <?php if ( $args['show_date'] || $args['show_author'] || $args['show_reading_time'] ) : ?>
                    <div class="amaley-blog-card__meta">
                        <?php if ( $args['show_date'] ) : ?>
                            <span><?php echo esc_html( get_the_date( 'M j, Y', $post_id ) ); ?></span>
                        <?php endif; ?>
                        <?php if ( $args['show_author'] ) : ?>
                            <span><?php echo esc_html( get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) ) ); ?></span>
                        <?php endif; ?>
                        <?php if ( $args['show_reading_time'] ) : ?>
                            <span><?php echo esc_html( Amaley_Blog_Reading_Time::get_label( $post_id ) ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $args['show_excerpt'] && $excerpt ) : ?>
                    <p class="amaley-blog-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
                <?php endif; ?>

                <?php if ( $args['show_button'] ) : ?>
                    <a class="amaley-blog-card__button" href="<?php echo esc_url( $permalink ); ?>">
                        <?php echo esc_html( $args['button_text'] ); ?> <span aria-hidden="true">→</span>
                    </a>
                <?php endif; ?>
            </div>
        </article>
        <?php
        return ob_get_clean();
    }

    public static function mini_post( $post_id ) {
        $post_id = absint( $post_id );
        if ( ! $post_id ) {
            return '';
        }

        $image = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
        if ( ! $image ) {
            $image = self::asset_url( 'assets/img/blog-thumb-placeholder.svg' );
        }

        ob_start();
        ?>
        <a class="amaley-blog-mini-post" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
            <span class="amaley-blog-mini-post__thumb">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" loading="lazy" />
            </span>
            <span class="amaley-blog-mini-post__body">
                <strong><?php echo esc_html( get_the_title( $post_id ) ); ?></strong>
                <small><?php echo esc_html( get_the_date( 'M j, Y', $post_id ) ); ?></small>
            </span>
        </a>
        <?php
        return ob_get_clean();
    }

    public static function primary_category( $post_id ) {
        $terms = get_the_terms( $post_id, 'category' );
        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return null;
        }
        return array_shift( $terms );
    }

    public static function excerpt( $post_id, $length = 22 ) {
        $manual = get_the_excerpt( $post_id );
        $text   = $manual ? $manual : get_post_field( 'post_content', $post_id );
        $text   = wp_strip_all_tags( strip_shortcodes( $text ) );
        return wp_trim_words( $text, $length, '…' );
    }

    public static function pagination( WP_Query $query ) {
        if ( $query->max_num_pages <= 1 ) {
            return '';
        }

        $current = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
        $links   = paginate_links(
            array(
                'current'   => $current,
                'total'     => $query->max_num_pages,
                'type'      => 'array',
                'prev_text' => '←',
                'next_text' => '→',
                'add_args'  => self::current_filter_args(),
            )
        );

        if ( empty( $links ) ) {
            return '';
        }

        return '<nav class="amaley-blog-pagination" aria-label="Blog pagination">' . implode( '', $links ) . '</nav>';
    }

    public static function current_filter_args() {
        $allowed = array( 'abs_s', 'abs_category', 'abs_tag', 'abs_orderby', 'abs_view' );
        $args    = array();
        foreach ( $allowed as $key ) {
            if ( isset( $_GET[ $key ] ) && '' !== $_GET[ $key ] ) {
                $args[ $key ] = sanitize_text_field( wp_unslash( $_GET[ $key ] ) );
            }
        }
        return $args;
    }

    public static function asset_url( $relative_path ) {
        $relative_path = ltrim( (string) $relative_path, '/' );
        return esc_url( AMALEY_BLOG_URL . $relative_path );
    }
}
