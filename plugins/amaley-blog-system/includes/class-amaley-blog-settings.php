<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Amaley_Blog_Settings {
    const OPTION = 'amaley_blog_settings';

    public function init() {
        add_action( 'admin_menu', array( $this, 'add_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public static function defaults() {
        return array(
            'archive_page_id'      => 0,
            'single_template_id'   => 0,
            'default_card'         => 'blog_card_1',
            'posts_per_page'       => 9,
            'enable_single_router' => 1,
            'enable_reading_time'  => 1,
            'enable_social_share'  => 1,
            'enable_filters'       => 1,
        );
    }

    public static function get( $key = null, $default = null ) {
        $settings = wp_parse_args( get_option( self::OPTION, array() ), self::defaults() );
        if ( null === $key ) {
            return $settings;
        }
        return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
    }

    public function add_menu() {
        add_menu_page(
            __( 'Amaley Blog System', 'amaley-blog-system' ),
            __( 'Amaley Blog', 'amaley-blog-system' ),
            'manage_options',
            'amaley-blog-system',
            array( $this, 'render_page' ),
            'dashicons-welcome-write-blog',
            58
        );
    }

    public function register_settings() {
        register_setting(
            'amaley_blog_system',
            self::OPTION,
            array(
                'type'              => 'array',
                'sanitize_callback' => array( $this, 'sanitize' ),
                'default'           => self::defaults(),
            )
        );
    }

    public function sanitize( $input ) {
        $input = is_array( $input ) ? $input : array();
        return array(
            'archive_page_id'      => isset( $input['archive_page_id'] ) ? absint( $input['archive_page_id'] ) : 0,
            'single_template_id'   => isset( $input['single_template_id'] ) ? absint( $input['single_template_id'] ) : 0,
            'default_card'         => 'blog_card_1',
            'posts_per_page'       => isset( $input['posts_per_page'] ) ? max( 1, absint( $input['posts_per_page'] ) ) : 9,
            'enable_single_router' => ! empty( $input['enable_single_router'] ) ? 1 : 0,
            'enable_reading_time'  => ! empty( $input['enable_reading_time'] ) ? 1 : 0,
            'enable_social_share'  => ! empty( $input['enable_social_share'] ) ? 1 : 0,
            'enable_filters'       => ! empty( $input['enable_filters'] ) ? 1 : 0,
        );
    }

    public function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $settings = self::get();
        ?>
        <div class="wrap amaley-blog-admin">
            <h1><?php esc_html_e( 'Amaley Blog System', 'amaley-blog-system' ); ?></h1>
            <p><?php esc_html_e( 'Assign the blog archive page and single blog template page. Blog content stays in WordPress Posts.', 'amaley-blog-system' ); ?></p>

            <form method="post" action="options.php">
                <?php settings_fields( 'amaley_blog_system' ); ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="archive_page_id"><?php esc_html_e( 'Blog Listing Page', 'amaley-blog-system' ); ?></label></th>
                        <td>
                            <?php
                            wp_dropdown_pages(
                                array(
                                    'name'              => self::OPTION . '[archive_page_id]',
                                    'id'                => 'archive_page_id',
                                    'selected'          => $settings['archive_page_id'],
                                    'show_option_none'  => __( '— Select Page —', 'amaley-blog-system' ),
                                    'option_none_value' => 0,
                                )
                            );
                            ?>
                            <p class="description"><?php esc_html_e( 'Create a normal page named Blogs and place the Amaley Blog Archive widgets on it.', 'amaley-blog-system' ); ?></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="single_template_id"><?php esc_html_e( 'Single Blog Template Page', 'amaley-blog-system' ); ?></label></th>
                        <td>
                            <?php
                            wp_dropdown_pages(
                                array(
                                    'name'              => self::OPTION . '[single_template_id]',
                                    'id'                => 'single_template_id',
                                    'selected'          => $settings['single_template_id'],
                                    'show_option_none'  => __( '— Select Page —', 'amaley-blog-system' ),
                                    'option_none_value' => 0,
                                )
                            );
                            ?>
                            <p class="description"><?php esc_html_e( 'Create a normal page named Blog Detail Template and place the single blog widgets on it.', 'amaley-blog-system' ); ?></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><?php esc_html_e( 'Default Blog Card', 'amaley-blog-system' ); ?></th>
                        <td>
                            <select name="<?php echo esc_attr( self::OPTION ); ?>[default_card]" disabled>
                                <option value="blog_card_1" selected><?php esc_html_e( 'Blog Card 1 — OG Card', 'amaley-blog-system' ); ?></option>
                            </select>
                            <p class="description"><?php esc_html_e( 'Blog Card 1 is locked as the OG card. Future designs should be added as Blog Card 2, Blog Card 3, etc.', 'amaley-blog-system' ); ?></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="posts_per_page"><?php esc_html_e( 'Posts Per Page', 'amaley-blog-system' ); ?></label></th>
                        <td><input type="number" min="1" id="posts_per_page" name="<?php echo esc_attr( self::OPTION ); ?>[posts_per_page]" value="<?php echo esc_attr( $settings['posts_per_page'] ); ?>" /></td>
                    </tr>

                    <?php $this->checkbox_row( 'enable_single_router', __( 'Enable Single Blog Template Routing', 'amaley-blog-system' ), $settings ); ?>
                    <?php $this->checkbox_row( 'enable_reading_time', __( 'Enable Reading Time', 'amaley-blog-system' ), $settings ); ?>
                    <?php $this->checkbox_row( 'enable_social_share', __( 'Enable Social Share', 'amaley-blog-system' ), $settings ); ?>
                    <?php $this->checkbox_row( 'enable_filters', __( 'Enable Sidebar Filters', 'amaley-blog-system' ), $settings ); ?>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    private function checkbox_row( $key, $label, $settings ) {
        ?>
        <tr>
            <th scope="row"><?php echo esc_html( $label ); ?></th>
            <td>
                <label>
                    <input type="checkbox" name="<?php echo esc_attr( self::OPTION ); ?>[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( ! empty( $settings[ $key ] ) ); ?> />
                    <?php esc_html_e( 'Enabled', 'amaley-blog-system' ); ?>
                </label>
            </td>
        </tr>
        <?php
    }
}
