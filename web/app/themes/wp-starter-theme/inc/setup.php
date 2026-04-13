<?php
/**
 * Theme setup: supports, menus, editor styles, misc.
 *
 * @package WP Starter Theme
 */

if ( ! function_exists( 'wpst_setup' ) ) :
	function wpst_setup() {

		// Translations
		load_theme_textdomain( 'wp-starter-theme', get_template_directory() . '/languages' );

		// RSS feeds
		add_theme_support( 'automatic-feed-links' );

		// Title tag managed by WordPress
		add_theme_support( 'title-tag' );

		// Featured images
		add_theme_support( 'post-thumbnails' );

		// Custom image sizes
		add_image_size( 'wpst-square', 800, 800, true );  // 1:1
		add_image_size( 'wpst-4-3', 800, 600, true );  // 4:3 landscape
		add_image_size( 'wpst-3-4', 600, 800, true );  // 3:4 portrait
		add_image_size( 'wpst-16-9', 1280, 720, true );  // 16:9 landscape
		add_image_size( 'wpst-9-16', 720, 1280, true );  // 9:16 portrait
		add_image_size( 'wpst-hero', 1920, 1080, true );  // 16:9 full-width hero
		add_image_size( 'wpst-og', 1200, 630, true );  // Open Graph / social

		// HTML5 markup
		add_theme_support(
			'html5',
			array(
				'search-form',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		// Custom logo via Appearance → Customize → Site Identity
		add_theme_support(
			'custom-logo',
			array(
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Block editor support
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );

		// Navigation menus
		register_nav_menus(
			array(
				'main-menu'   => __( 'Huvudmeny', 'wp-starter-theme' ),
				'footer-menu' => __( 'Sidfotsmeny', 'wp-starter-theme' ),
			)
		);

		// Editor styles
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/style.css' );
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'wpst_setup' );

/**
 * Polyfill for wp_body_open (WP < 5.2).
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
	function wp_body_open() {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		do_action( 'wp_body_open' );
	}
}


/**
 * Expose custom image sizes in the media library.
 */
add_filter(
	'image_size_names_choose',
	function ( $sizes ) {
		return array_merge(
			$sizes,
			array(
				'wpst-square' => '1:1 Square (800×800)',
				'wpst-4-3'    => '4:3 Landscape (800×600)',
				'wpst-3-4'    => '3:4 Portrait (600×800)',
				'wpst-16-9'   => '16:9 Landscape (1280×720)',
				'wpst-9-16'   => '9:16 Portrait (720×1280)',
				'wpst-hero'   => 'Hero (1920×1080)',
				'wpst-og'     => 'Open Graph (1200×630)',
			)
		);
	}
);

/**
 * Load navwalker.
 */
if ( ! function_exists( 'wpst_register_navwalker' ) ) :
	function wpst_register_navwalker() {
		$walker_path = get_theme_file_path( 'inc/navwalker.php' );
		if ( file_exists( $walker_path ) ) {
			require_once $walker_path;
		}
	}
endif;
add_action( 'after_setup_theme', 'wpst_register_navwalker' );
