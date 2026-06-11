<?php
/**
 * Plugin Name: Amaley Blog System
 * Description: Professional Amaley blog archive and single blog template system with reusable OG Blog Card 1, Elementor widgets, sidebar filters, related posts, and page assignment.
 * Version: 1.4.7
 * Author: Amaley
 * Text Domain: amaley-blog-system
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AMALEY_BLOG_VERSION', '1.4.7' );
define( 'AMALEY_BLOG_FILE', __FILE__ );
define( 'AMALEY_BLOG_PATH', plugin_dir_path( __FILE__ ) );
define( 'AMALEY_BLOG_URL', plugin_dir_url( __FILE__ ) );

require_once AMALEY_BLOG_PATH . 'includes/class-amaley-blog-reading-time.php';
require_once AMALEY_BLOG_PATH . 'includes/class-amaley-blog-query.php';
require_once AMALEY_BLOG_PATH . 'includes/class-amaley-blog-renderer.php';
require_once AMALEY_BLOG_PATH . 'includes/class-amaley-blog-settings.php';
require_once AMALEY_BLOG_PATH . 'includes/class-amaley-blog-template-router.php';
require_once AMALEY_BLOG_PATH . 'includes/class-amaley-blog-plugin.php';

add_action( 'plugins_loaded', array( 'Amaley_Blog_Plugin', 'instance' ) );
