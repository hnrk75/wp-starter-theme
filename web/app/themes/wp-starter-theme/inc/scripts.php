<?php
/**
 * Enqueue scripts and styles
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

// Enqueue scripts and styles with accessibility and performance considerations.
function hnrkagency_scripts() {
	wp_enqueue_style( 'bs5-style', get_stylesheet_directory_uri() . '/style.min.css', array(), '5.3.3', 'all' );
	
	wp_enqueue_script( 'bs5-js', get_template_directory_uri() . '/js/dist/scripts.min.js', array('jquery'), '5.3.3', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if (!is_admin()) {
		echo '<script type="text/javascript">document.body.classList.remove("no-js");</script>';
	}
}
add_action( 'wp_enqueue_scripts', 'hnrkagency_scripts' );

// Filter the HTML script tag to add the `defer` attribute for non-essential scripts.
function hnrkagency_defer_scripts( $tag, $handle, $src ) {
	$defer_scripts = array( 
		'leadgenwp-fa',
	);
	
	if ( in_array( $handle, $defer_scripts ) ) {
		return '<script src="' . esc_url( $src ) . '" defer="defer" aria-label="' . esc_attr__( 'Icke-nödvändigt skript har laddats', 'starterwp-textdomain' ) . '"></script>';
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'hnrkagency_defer_scripts', 10, 3 );
