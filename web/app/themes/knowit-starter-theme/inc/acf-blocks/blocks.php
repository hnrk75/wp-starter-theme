<?php
/**
 * Knowit custom ACF blocks
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

function knowit_register_acf_blocks() {
	$blocks_dir = __DIR__;

	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	WP_Filesystem();
	global $wp_filesystem;

	$block_folders = glob( $blocks_dir . '/*', GLOB_ONLYDIR );

	foreach ( $block_folders as $folder ) {
		$json_file = $folder . '/block.json';

		if ( ! $wp_filesystem->exists( $json_file ) ) {
			continue;
		}

		$json_content = $wp_filesystem->get_contents( $json_file );
		if ( false === $json_content ) {
			continue;
		}

		$json = json_decode( $json_content, true );
		if ( ! is_array( $json ) ) {
			continue;
		}

		if ( empty( $json['category'] ) ) {
			$json['category'] = 'custom_blocks';
		}

		acf_register_block_type(
			array_merge(
				$json,
				array(
					'render_template' => $folder . '/block.php',
				)
			)
		);
	}
}
add_action( 'acf/init', 'knowit_register_acf_blocks' );

function knowit_custom_block_category( $categories ) {
	foreach ( $categories as $category ) {
		if ( isset( $category['slug'] ) && $category['slug'] === 'custom_blocks' ) {
			return $categories;
		}
	}

	array_unshift(
		$categories,
		array(
			'slug'  => 'custom_blocks',
			'title' => __( 'Anpassade Block', 'knowit-starter-theme' ),
		)
	);

	return $categories;
}
add_filter( 'block_categories_all', 'knowit_custom_block_category', 10, 2 );
