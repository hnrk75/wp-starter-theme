<?php
/**
 * Child theme functions. How to customize the parent theme: see README.md.
 *
 * @package WP Starter Child
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

// Priority 11: after the parent's wpst_setup().
add_action(
	'after_setup_theme',
	function () {
		load_child_theme_textdomain( 'wp-starter-child', get_stylesheet_directory() . '/languages' );

		add_editor_style( 'style.css' );
	},
	11
);
