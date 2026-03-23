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

$blocks_path = plugin_dir_path( dirname( __FILE__ ) ) . 'blocks/';
$blocks_url  = plugin_dir_url( dirname( __FILE__ ) ) . 'blocks/';

// Text block
acf_register_block_type(
	array(
		'name'            => 'text-block',
		'title'           => __( 'Textblock', 'wpst-acf-blocks' ),
		'description'     => __( 'Ett enkelt block med rubrik och brödtext.', 'wpst-acf-blocks' ),
		'render_template' => $blocks_path . 'text-block/block.php',
		'enqueue_style'   => $blocks_url . 'text-block/block.css',
		'category'        => 'wpst-blocks',
		'icon'            => 'editor-paragraph',
		'keywords'        => array( 'text', 'rubrik', 'innehåll' ),
		'supports'        => array(
			'anchor' => true,
			'align'  => false,
		),
	)
);
