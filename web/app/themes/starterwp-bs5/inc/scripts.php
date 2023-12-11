<?php
/**
 * Enqueue scripts and styles
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

// Enqueue scripts and styles.
function starterwp_scripts() {
	wp_enqueue_style( 'starterwp-style', get_stylesheet_directory_uri() . '/style.min.css', array(), '5.3.2' );
	wp_enqueue_script( 'starterwp-js', get_template_directory_uri() . '/js/dist/scripts.min.js', array('jquery'), ' ', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'starterwp_scripts' );

// Filter the HTML script tag of `leadgenwp-fa` script to add `defer` attribute
function starterwp_defer_scripts( $tag, $handle, $src ) {
	$defer_scripts = array( 
		'starterwp-fa'
	);
	if ( in_array( $handle, $defer_scripts ) ) {
		return '<script src="' . $src . '" defer></script>';
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'starterwp_defer_scripts', 10, 3 );
