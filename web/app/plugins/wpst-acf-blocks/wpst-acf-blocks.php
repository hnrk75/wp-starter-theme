<?php
/**
 * Plugin Name: WPST ACF Blocks
 * Plugin URI:  https://github.com/hnrk75/wp-starter-theme
 * Description: Custom ACF blocks. Requires Advanced Custom Fields Pro.
 * Version:     1.0.0
 * Author:      Henrik Pettersson
 * Author URI:  https://github.com/hnrk75
 * License:     GPL-2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpst-acf-blocks
 * Requires at least: 6.4
 * Requires PHP: 8.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load plugin text domain for translations.
 */
function wpst_acf_load_textdomain() {
	load_plugin_textdomain(
		'wpst-acf-blocks',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'init', 'wpst_acf_load_textdomain' );

/**
 * Add custom block category at the top of the inserter.
 */
function wpst_acf_block_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'wpst-blocks',
				'title' => __( 'Anpassade block', 'wpst-acf-blocks' ),
				'icon'  => 'layout',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'wpst_acf_block_category', 10, 2 );

/**
 * Register ACF blocks.
 * All block registrations live in inc/register-blocks.php.
 */
function wpst_acf_register_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	require_once plugin_dir_path( __FILE__ ) . 'inc/register-blocks.php';
}
add_action( 'acf/init', 'wpst_acf_register_blocks' );

/**
 * Tell ACF to save field group JSON to this plugin's acf-json/ folder.
 */
function wpst_acf_json_save_path( $_path ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	return plugin_dir_path( __FILE__ ) . 'acf-json';
}
add_filter( 'acf/settings/save_json', 'wpst_acf_json_save_path' );

/**
 * Tell ACF to load field group JSON from this plugin's acf-json/ folder.
 */
function wpst_acf_json_load_paths( $paths ) {
	$paths[] = plugin_dir_path( __FILE__ ) . 'acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'wpst_acf_json_load_paths' );

/**
 * Enqueue shared block styles for both editor and front end.
 */
function wpst_acf_enqueue_shared_styles() {
	wp_enqueue_style(
		'wpst-acf-blocks-shared',
		plugin_dir_url( __FILE__ ) . 'assets/css/shared.css',
		array(),
		'1.0.0'
	);
}
add_action( 'enqueue_block_assets', 'wpst_acf_enqueue_shared_styles' );
