<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id     = get_queried_object_id();
$template_id = absint( Amaley_Blog_Settings::get( 'single_template_id', 0 ) );
Amaley_Blog_Template_Router::set_current_post_id( $post_id );

get_header();
?>
<main id="primary" class="site-main amaley-blog-routed-single" data-amaley-blog-post-id="<?php echo esc_attr( $post_id ); ?>">
    <?php
    if ( $template_id && class_exists( '\Elementor\Plugin' ) ) {
        echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $template_id, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } elseif ( $template_id ) {
        $template_post = get_post( $template_id );
        if ( $template_post ) {
            echo apply_filters( 'the_content', $template_post->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    } else {
        while ( have_posts() ) {
            the_post();
            the_title( '<h1>', '</h1>' );
            the_content();
        }
    }
    ?>
</main>
<?php
Amaley_Blog_Template_Router::set_current_post_id( 0 );
get_footer();
