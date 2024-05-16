<?php
/**
 * StarterWP functions and definitions
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

if ( ! function_exists( 'starterwp_setup' ) ) :
	function starterwp_setup() {

		// Make theme available for translation. Translations can be filed in the /languages/ directory.
		// If you're building a theme based on StarterWP, use a find and replace to change 'starterwp' to the name of your theme in all the template files.
		load_theme_textdomain( 'starterwp', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title. By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head, and expect WordPress to provide it for us
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature
		add_theme_support( 'custom-background', apply_filters( 'starterwp_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Add wide image support
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content
		add_theme_support( 'responsive-embeds' );

		// Add editor styles
		add_theme_support( 'editor-styles' );

		// Editor color palette
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'starterwp-textdomain' ),
					'slug'  => 'primary',
					'color' => '#007bff',
				),
				array(
					'name'  => __( 'Secondary', 'starterwp-textdomain' ),
					'slug'  => 'secondary',
					'color' => '#6c757d',
				),
				array(
					'name'  => __( 'Success', 'starterwp-textdomain' ),
					'slug'  => 'success',
					'color' => '#28a745',
				),
				array(
					'name'  => __( 'Danger', 'starterwp-textdomain' ),
					'slug'  => 'danger',
					'color' => '#dc3545',
				),
				array(
					'name'  => __( 'Warning', 'starterwp-textdomain' ),
					'slug'  => 'warning',
					'color' => '#ffc107',
				),
				array(
					'name'  => __( 'Info', 'starterwp-textdomain' ),
					'slug'  => 'info',
					'color' => '#17a2b8',
				),
				array(
					'name'  => __( 'Dark Gray', 'starterwp-textdomain' ),
					'slug'  => 'dark',
					'color' => '#343a40',
				),
				array(
					'name'  => __( 'Light Gray', 'starterwp-textdomain' ),
					'slug'  => 'light',
					'color' => '#f8f9fa',
				),
				array(
					'name'  => __( 'White', 'starterwp-textdomain' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);
	}
	endif;
	add_action( 'after_setup_theme', 'starterwp_setup' );

// Set the content width in pixels, based on the theme's design and stylesheet.
function starterwp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'starterwp_content_width', 640 );
}
add_action( 'after_setup_theme', 'starterwp_content_width', 0 );

/*-------------------------------------------------------------
# Register Bootstrap 5 Nav Walker
--------------------------------------------------------------*/
if (!function_exists('register_navwalker')) :
	function register_navwalker() {
		require_once('inc/class-navwalker.php');
		register_nav_menu('main-menu', 'Huvud Meny');
	}
endif;
add_action('after_setup_theme', 'register_navwalker');

/*-------------------------------------------------------------
# Requirements
--------------------------------------------------------------*/
// Extras
require get_template_directory() . '/inc/extras.php';

// Add CSS/JS Scritps
require get_template_directory() . '/inc/scripts.php';

// Custom template tags for this theme
require get_template_directory() . '/inc/template-tags.php';

// Register Widget Areas
require get_template_directory() . '/inc/widgets.php';
