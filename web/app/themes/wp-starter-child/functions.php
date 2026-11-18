<?php
/**
 * Child theme functions. How to customize the parent theme: see README.md.
 *
 * @package WP Starter Child
 */

// Compiled from assets/scss with `npm run build`; style.css only holds the theme header.
add_action(
	'wp_enqueue_scripts',
	function () {
		$file = 'assets/css/style.min.css';
		$path = get_stylesheet_directory() . '/' . $file;

		wp_enqueue_style(
			'wpst-child-style',
			get_stylesheet_directory_uri() . '/' . $file,
			array( 'wpst-style' ),
			file_exists( $path ) ? (string) filemtime( $path ) : null
		);
	}
);

// Priority 11: after the parent's wpst_setup(), so this CSS loads after the parent's in the editor.
add_action(
	'after_setup_theme',
	function () {
		load_child_theme_textdomain( 'wp-starter-child', get_stylesheet_directory() . '/languages' );

		add_editor_style( 'assets/css/style.min.css' );
	},
	11
);
