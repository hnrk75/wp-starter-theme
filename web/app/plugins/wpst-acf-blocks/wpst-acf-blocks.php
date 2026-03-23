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
 */
function wpst_acf_register_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	// --- How to add a new block ------------------------------------
	// 1. Copy blocks/text-block/ and rename the folder
	// 2. Edit block.php — update class names and get_field() calls
	// 3. Register ACF fields for the block in ACF UI or PHP
	// 4. Add a new acf_register_block_type() call below, following
	//    the same pattern as the text block.
	// ---------------------------------------------------------------

	// Text block
	acf_register_block_type(
		array(
			'name'            => 'text-block',
			'title'           => __( 'Textblock', 'wpst-acf-blocks' ),
			'description'     => __( 'Ett enkelt block med rubrik och brödtext.', 'wpst-acf-blocks' ),
			'render_template' => plugin_dir_path( __FILE__ ) . 'blocks/text-block/block.php',
			'category'        => 'wpst-blocks',
			'icon'            => 'editor-paragraph',
			'keywords'        => array( 'text', 'rubrik', 'innehåll' ),
			'supports'        => array(
				'anchor' => true,
				'align'  => false,
			),
		)
	);
}
add_action( 'acf/init', 'wpst_acf_register_blocks' );
