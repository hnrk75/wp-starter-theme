<?php
/**
 * Enqueue scripts and styles
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

if ( ! function_exists( 'knowit_scripts' ) ) :
	function knowit_scripts() {

		$css_rel = 'style.min.css';
		$css_path = get_theme_file_path( $css_rel );
		$css_uri  = get_theme_file_uri( $css_rel );
		$css_ver  = file_exists( $css_path ) ? (string) filemtime( $css_path ) : null;

		wp_enqueue_style(
			'knowit-style',
			$css_uri,
			array(),
			$css_ver
		);

		$js_rel = 'assets/js/dist/scripts.min.js';
		$js_path = get_theme_file_path( $js_rel );
		$js_uri  = get_theme_file_uri( $js_rel );
		$js_ver  = file_exists( $js_path ) ? (string) filemtime( $js_path ) : null;

		// Bootstrap 5 kräver INTE jQuery. Låt deps vara tom om din bundle är vanilla.
		$deps = array();

		wp_enqueue_script(
			'knowit-scripts',
			$js_uri,
			$deps,
			$js_ver,
			true
		);

		wp_script_add_data( 'knowit-scripts', 'defer', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'knowit_scripts' );

/**
 * (Valfritt) Avregistrera jQuery på frontend om du inte använder det.
 * Lämna denna avstängd om du är osäker på om plugins kräver jQuery.
 */
// phpcs:ignore Squiz.PHP.CommentedOutCode.Found
// add_action( 'wp_enqueue_scripts', function () {
// if ( ! is_admin() && ! is_customize_preview() ) {
// wp_deregister_script( 'jquery' );
// }
// }, 0 );

/**
 * (Valfritt) Villkorligt ladda jQuery ENBART på sidor där du vet att det behövs.
 * Exempel: om en specifik shortcode används.
 */
// add_action( 'wp_enqueue_scripts', function () {
// $needs_jquery = false;
//
// Exempel: ladda jQuery om en viss shortcode finns i innehållet.
// if ( is_singular() ) {
// global $post;
// if ( has_shortcode( $post->post_content ?? '', 'min_shortcode_som_behover_jquery' ) ) {
// $needs_jquery = true;
// }
// }
//
// if ( $needs_jquery && ! wp_script_is( 'jquery', 'enqueued' ) ) {
// wp_enqueue_script( 'jquery' );
// }
// }, 20 );
