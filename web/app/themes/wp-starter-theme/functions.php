<?php
/**
 * Functions and definitions
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

if ( ! function_exists( 'wpst_setup' ) ) :
	function wpst_setup() {

		// Översättningar
		load_theme_textdomain( 'wp-starter-theme', get_template_directory() . '/languages' );

		// RSS feeds
		add_theme_support( 'automatic-feed-links' );

		// <title> hanteras av WP
		add_theme_support( 'title-tag' );

		// Utvalda bilder
		add_theme_support( 'post-thumbnails' );

		// HTML5-markup (korrekt lista)
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		// Block/editor-stöd
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );

		// Menyer
		register_nav_menus(
			array(
				'main-menu' => __( 'Huvudmeny', 'wp-starter-theme' ),
			)
		);

		// Editor styles
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );
	}
endif;
add_action( 'after_setup_theme', 'wpst_setup' );

if ( ! function_exists( 'wp_body_open' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
	function wp_body_open() {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		do_action( 'wp_body_open' );
	}
}

function wpst_add_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	$template_uri = get_template_directory_uri();
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attribut är escapade och HTML är kontrollerad.
	echo '<link rel="icon" href="' . esc_url( $template_uri . '/assets/svg/favicon.svg' ) . '" type="image/svg+xml" />' . "\n";
}
add_action( 'wp_head', 'wpst_add_favicon' );

if ( ! function_exists( 'wpst_register_navwalker' ) ) :
	function wpst_register_navwalker() {
		$walker_path = get_theme_file_path( 'inc/navwalker.php' );
		if ( file_exists( $walker_path ) ) {
			require_once $walker_path;
		}
	}
endif;
add_action( 'after_setup_theme', 'wpst_register_navwalker' );

/*
-------------------------------------------------------------
// Child theme–vänliga includes
--------------------------------------------------------------*/
// Breadcrumbs
locate_template( array( 'inc/breadcrumbs.php' ), true, true );

// Extra helpers
locate_template( array( 'inc/extras.php' ), true, true );

// Buttons helper
locate_template( array( 'inc/helpers-buttons.php' ), true, true );

// SVG icon helper
locate_template( array( 'inc/helpers-svg.php' ), true, true );

// CSS/JS enqueue
locate_template( array( 'inc/scripts.php' ), true, true );

// Template tags
locate_template( array( 'inc/template-tags.php' ), true, true );

// Widget areas
locate_template( array( 'inc/widgets.php' ), true, true );

/*
-------------------------------------------------------------
	Custom ACF Gutenberg Blocks (inc)
-------------------------------------------------------------- */
locate_template( array( 'inc/acf-blocks/blocks.php' ), true, true );
