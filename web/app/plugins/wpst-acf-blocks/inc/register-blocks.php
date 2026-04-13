<?php
/**
 * Register ACF blocks.
 *
 * Add a new acf_register_block_type() call for each block.
 * Copy blocks/text-block/ as a starting point, rename the folder
 * and update class names and get_field() calls in block.php.
 *
 * @package WPST ACF Blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blocks_path = plugin_dir_path( __DIR__ ) . 'blocks/';
$blocks_url  = plugin_dir_url( __DIR__ ) . 'blocks/';

// Text block
acf_register_block_type(
	array(
		'name'            => 'text-block',
		'title'           => __( 'Textblock', 'wpst-acf-blocks' ),
		'description'     => __( 'Rubrik, text och valfri länk. Välj ingress-storlek när ingen rubrik används.', 'wpst-acf-blocks' ),
		'render_template' => $blocks_path . 'text-block/block.php',
		'enqueue_style'   => $blocks_url . 'text-block/block.css',
		'category'        => 'wpst-blocks',
		'icon'            => 'editor-paragraph',
		'keywords'        => array( 'text', 'heading', 'ingress', 'content' ),
		'mode'            => 'preview',
		'supports'        => array(
			'anchor' => true,
			'align'  => array( 'full' ),
		),
	)
);

// Hero block
acf_register_block_type(
	array(
		'name'            => 'hero-block',
		'title'           => __( 'Hero', 'wpst-acf-blocks' ),
		'description'     => __( 'Full bredd med bakgrundsfärg, bild eller video. H1 och ingress centrerat.', 'wpst-acf-blocks' ),
		'render_template' => $blocks_path . 'hero-block/block.php',
		'enqueue_style'   => $blocks_url . 'hero-block/block.css',
		'category'        => 'wpst-blocks',
		'icon'            => 'cover-image',
		'keywords'        => array( 'hero', 'banner', 'cover', 'header' ),
		'mode'            => 'preview',
		'supports'        => array(
			'anchor' => true,
			'align'  => false,
		),
	)
);

// Image Text block
acf_register_block_type(
	array(
		'name'            => 'image-text-block',
		'title'           => __( 'Bild & text', 'wpst-acf-blocks' ),
		'description'     => __( 'Block med bild och text sida vid sida. Välj bildbredd (1/2 eller 1/3) och position (vänster/höger).', 'wpst-acf-blocks' ),
		'render_template' => $blocks_path . 'image-text-block/block.php',
		'enqueue_style'   => $blocks_url . 'image-text-block/block.css',
		'category'        => 'wpst-blocks',
		'icon'            => 'columns',
		'keywords'        => array( 'image', 'text', 'media', 'columns' ),
		'mode'            => 'preview',
		'supports'        => array(
			'anchor' => true,
			'align'  => array( 'full' ),
		),
	)
);
