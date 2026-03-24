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

		// Custom logo via Utseende → Anpassa → Webbplatsidentitet
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
				'main-menu' => __( 'Huvudmeny', 'wp-starter-theme' ),
			)
		);

		// Editor styles
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );
		add_editor_style( 'editor-style.css' );
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
 * Favicon fallback om ingen site icon är satt i admin.
 */
function wpst_add_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	$template_uri = get_template_directory_uri();
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<link rel="icon" href="' . esc_url( $template_uri . '/assets/svg/favicon.svg' ) . '" type="image/svg+xml" />' . "\n";
}
add_action( 'wp_head', 'wpst_add_favicon' );

/**
 * Ladda navwalker.
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
