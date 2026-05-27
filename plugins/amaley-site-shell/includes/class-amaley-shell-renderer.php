<?php
/**
 * Frontend renderer.
 *
 * @package AmaleySiteShell
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Amaley_Shell_Renderer {
    /** Render header. */
    public static function render_header() {
        $settings = Amaley_Shell_Settings::all();
        if ( empty( $settings['enable_header'] ) ) {
            return '';
        }

        Amaley_Shell_Assets::enqueue_frontend();

        ob_start();
        self::render_announcement( $settings );
        ?>
        <header class="amaley-shell-header <?php echo ! empty( $settings['sticky_header'] ) ? 'amaley-shell-header--sticky' : ''; ?>" data-amaley-shell="header">
            <div class="amaley-shell-header-inner">
                <a class="amaley-shell-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <?php if ( ! empty( $settings['logo_url'] ) ) : ?>
                        <img src="<?php echo esc_url( $settings['logo_url'] ); ?>" alt="<?php echo esc_attr( $settings['logo_text'] ); ?>" loading="eager" decoding="async" />
                    <?php else : ?>
                        <span><?php echo esc_html( $settings['logo_text'] ); ?></span>
                    <?php endif; ?>
                </a>

                <nav class="amaley-shell-desktop-nav" aria-label="Amaley main navigation">
                    <?php self::render_nav_items( $settings, 'desktop' ); ?>
                </nav>

                <div class="amaley-shell-header-actions">
                    <?php if ( ! empty( $settings['show_cta'] ) && ! empty( $settings['cta_text'] ) ) : ?>
                        <a class="amaley-shell-button" href="<?php echo esc_url( $settings['cta_link'] ); ?>"><?php echo esc_html( $settings['cta_text'] ); ?></a>
                    <?php endif; ?>
                    <?php if ( ! empty( $settings['show_cart'] ) ) : ?>
                        <a class="amaley-shell-icon-link" href="<?php echo esc_url( self::cart_url() ); ?>" aria-label="Cart">Cart</a>
                    <?php endif; ?>
                    <?php if ( ! empty( $settings['show_account'] ) ) : ?>
                        <a class="amaley-shell-icon-link" href="<?php echo esc_url( $settings['account_link'] ); ?>" aria-label="Account">Account</a>
                    <?php endif; ?>
                </div>

                <button class="amaley-shell-mobile-toggle" type="button" aria-controls="amaley-shell-mobile-drawer" aria-expanded="false">
                    <span class="amaley-shell-mobile-toggle-line"></span>
                    <span class="amaley-shell-mobile-toggle-line"></span>
                    <span class="amaley-shell-mobile-toggle-line"></span>
                    <span class="screen-reader-text">Open menu</span>
                </button>
            </div>
        </header>
        <?php
        self::render_mobile_drawer( $settings );
        return ob_get_clean();
    }

    /** Render footer. */
    public static function render_footer() {
        $settings = Amaley_Shell_Settings::all();
        if ( empty( $settings['enable_footer'] ) ) {
            return '';
        }

        Amaley_Shell_Assets::enqueue_frontend();

        ob_start();
        ?>
        <footer class="amaley-shell-footer" data-amaley-shell="footer">
            <div class="amaley-shell-footer-inner">
                <div class="amaley-shell-footer-brand">
                    <a class="amaley-shell-footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php if ( ! empty( $settings['footer_logo_url'] ) ) : ?>
                            <img src="<?php echo esc_url( $settings['footer_logo_url'] ); ?>" alt="<?php echo esc_attr( $settings['logo_text'] ); ?>" loading="lazy" decoding="async" />
                        <?php elseif ( ! empty( $settings['logo_url'] ) ) : ?>
                            <img src="<?php echo esc_url( $settings['logo_url'] ); ?>" alt="<?php echo esc_attr( $settings['logo_text'] ); ?>" loading="lazy" decoding="async" />
                        <?php else : ?>
                            <span><?php echo esc_html( $settings['logo_text'] ); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if ( ! empty( $settings['footer_description'] ) ) : ?>
                        <p><?php echo esc_html( $settings['footer_description'] ); ?></p>
                    <?php endif; ?>
                </div>

                <div class="amaley-shell-footer-columns">
                    <?php foreach ( (array) $settings['footer_columns'] as $column ) : ?>
                        <div class="amaley-shell-footer-column">
                            <h3><?php echo esc_html( $column['title'] ?? '' ); ?></h3>
                            <ul>
                                <?php foreach ( (array) ( $column['links'] ?? array() ) as $link ) : ?>
                                    <li><a href="<?php echo esc_url( $link['url'] ?? '#' ); ?>"><?php echo esc_html( $link['label'] ?? '' ); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>

                    <div class="amaley-shell-footer-column amaley-shell-footer-contact">
                        <h3>Contact</h3>
                        <ul>
                            <?php if ( ! empty( $settings['contact_email'] ) ) : ?>
                                <li><a href="mailto:<?php echo esc_attr( $settings['contact_email'] ); ?>"><?php echo esc_html( $settings['contact_email'] ); ?></a></li>
                            <?php endif; ?>
                            <?php if ( ! empty( $settings['contact_phone'] ) ) : ?>
                                <li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $settings['contact_phone'] ) ); ?>"><?php echo esc_html( $settings['contact_phone'] ); ?></a></li>
                            <?php endif; ?>
                            <?php if ( ! empty( $settings['contact_address'] ) ) : ?>
                                <li><span><?php echo esc_html( $settings['contact_address'] ); ?></span></li>
                            <?php endif; ?>
                        </ul>
                        <?php self::render_socials( $settings ); ?>
                    </div>
                </div>
            </div>

            <div class="amaley-shell-footer-bottom">
                <span><?php echo esc_html( $settings['copyright_text'] ); ?></span>
                <span><?php echo esc_html( $settings['designed_by_text'] ); ?></span>
            </div>
        </footer>
        <?php
        return ob_get_clean();
    }

    /** Render announcement. */
    private static function render_announcement( array $settings ) {
        if ( empty( $settings['show_announcement'] ) || empty( $settings['announcement_text'] ) ) {
            return;
        }
        $content = esc_html( $settings['announcement_text'] );
        ?>
        <div class="amaley-shell-announcement" data-amaley-shell="announcement">
            <?php if ( ! empty( $settings['announcement_link'] ) ) : ?>
                <a href="<?php echo esc_url( $settings['announcement_link'] ); ?>"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
            <?php else : ?>
                <span><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
            <?php endif; ?>
        </div>
        <?php
    }

    /** Render navigation items. */
    private static function render_nav_items( array $settings, $context = 'desktop' ) {
        echo '<ul class="amaley-shell-nav-list">';
        foreach ( (array) $settings['nav_items'] as $item ) {
            if ( 'desktop' === $context && empty( $item['desktop'] ) ) {
                continue;
            }
            if ( 'mobile' === $context && empty( $item['mobile'] ) ) {
                continue;
            }
            $classes = array( 'amaley-shell-nav-item' );
            if ( ! empty( $item['highlight'] ) ) {
                $classes[] = 'amaley-shell-nav-item--highlight';
            }
            $target = ! empty( $item['new_tab'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
            echo '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';
            echo '<a href="' . esc_url( $item['url'] ?? '#' ) . '"' . $target . '>' . esc_html( $item['label'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            if ( ! empty( $item['badge'] ) ) {
                echo '<span class="amaley-shell-nav-badge">' . esc_html( $item['badge'] ) . '</span>';
            }
            echo '</a></li>';
        }
        echo '</ul>';
    }

    /** Render mobile drawer. */
    private static function render_mobile_drawer( array $settings ) {
        ?>
        <div class="amaley-shell-mobile-overlay" data-amaley-shell-mobile-close hidden></div>
        <aside id="amaley-shell-mobile-drawer" class="amaley-shell-mobile-drawer" aria-hidden="true">
            <div class="amaley-shell-mobile-drawer-head">
                <span class="amaley-shell-mobile-brand"><?php echo esc_html( $settings['logo_text'] ); ?></span>
                <button class="amaley-shell-mobile-close" type="button" data-amaley-shell-mobile-close aria-label="Close menu">×</button>
            </div>
            <nav class="amaley-shell-mobile-nav" aria-label="Amaley mobile navigation">
                <?php self::render_nav_items( $settings, 'mobile' ); ?>
            </nav>
            <?php if ( ! empty( $settings['show_cta'] ) && ! empty( $settings['cta_text'] ) ) : ?>
                <a class="amaley-shell-mobile-cta" href="<?php echo esc_url( $settings['cta_link'] ); ?>"><?php echo esc_html( $settings['cta_text'] ); ?></a>
            <?php endif; ?>
        </aside>
        <?php
    }

    /** Render social links. */
    private static function render_socials( array $settings ) {
        $links = array(
            'Instagram' => $settings['instagram_link'] ?? '',
            'Facebook'  => $settings['facebook_link'] ?? '',
            'LinkedIn'  => $settings['linkedin_link'] ?? '',
            'YouTube'   => $settings['youtube_link'] ?? '',
        );
        $links = array_filter( $links );
        if ( empty( $links ) ) {
            return;
        }
        echo '<div class="amaley-shell-socials">';
        foreach ( $links as $label => $url ) {
            echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $label ) . '</a>';
        }
        echo '</div>';
    }

    /** Cart URL. */
    private static function cart_url() {
        if ( function_exists( 'wc_get_cart_url' ) ) {
            return wc_get_cart_url();
        }
        return home_url( '/cart/' );
    }
}
