<?php
/**
 * Enqueue scripts and styles
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

if ( ! function_exists( 'wpst_scripts' ) ) :
	function wpst_scripts() {

		wp_enqueue_style(
			'wpst-google-fonts',
			'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap',
			array(),
			null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- external URL, no version needed
		);

		$css_rel  = 'style.min.css';
		$css_path = get_theme_file_path( $css_rel );
		$css_uri  = get_theme_file_uri( $css_rel );
		$css_ver  = file_exists( $css_path ) ? (string) filemtime( $css_path ) : null;

		wp_enqueue_style( 'wpst-style', $css_uri, array(), $css_ver );

		$js_rel  = 'assets/js/dist/scripts.min.js';
		$js_path = get_theme_file_path( $js_rel );
		$js_uri  = get_theme_file_uri( $js_rel );
		$js_ver  = file_exists( $js_path ) ? (string) filemtime( $js_path ) : null;

		wp_enqueue_script( 'wpst-scripts', $js_uri, array(), $js_ver, true );
		wp_script_add_data( 'wpst-scripts', 'defer', true );
	}
endif;
add_action( 'wp_enqueue_scripts', 'wpst_scripts' );
