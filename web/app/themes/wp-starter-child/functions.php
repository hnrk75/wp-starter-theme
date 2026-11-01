<?php
/**
 * Child theme functions.
 *
 * WordPress loads this file before the parent theme's functions.php. Customize the
 * parent theme from here with:
 * - Hooks and filters, e.g. `wpst_google_fonts_url`.
 * - Pluggable functions: define a `wpst_*` function that the parent wraps in
 *   function_exists() (e.g. wpst_posted_on()) and yours is used instead.
 * - Template overrides: copy a file from the parent's template-parts/ to the same
 *   path in this theme and edit the copy.
 *
 * @package WP Starter Child
 */

/**
 * Child theme CSS, loaded after the parent's ('wpst-style').
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'wpst-child-style',
			get_stylesheet_uri(),
			array( 'wpst-style' ),
			(string) filemtime( get_stylesheet_directory() . '/style.css' )
		);
	}
);

/**
 * Translations and editor styles. Priority 11 runs after the parent's wpst_setup().
 */
add_action(
	'after_setup_theme',
	function () {
		load_child_theme_textdomain( 'wp-starter-child', get_stylesheet_directory() . '/languages' );

		// The parent's editor styles load first, then this one.
		add_editor_style( 'style.css' );
	},
	11
);
