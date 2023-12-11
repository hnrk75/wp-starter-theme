<?php
/**
 * Add Custom Post Type CMPT
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

add_action( 'init', function() {
	$type       = 'cmpt';
	$labels     = post_type_event( 'Anpassat inlägg', 'Anpassade inlägg' );
	$supports   = [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats' ];
	$arguments  = [
		'labels'                => $labels,
		'supports'              => $supports,
		'rewrite'               => [ 'slug' => 'inlaggstyp' ],
		'has_archive'           => true,
		'rest_base'             => 'inlaggstyp',
		'show_in_rest'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'show_in_menu'          => true,
		'show_ui'               => true,
		'hierarchical'          => false,
		'public'                => true,
		'menu_icon'             => 'dashicons-welcome-write-blog',
		'menu_position'         => 7,
	];
	register_post_type( $type, $arguments );
} );

function post_type_event( $singular = 'Anpassat inlägg', $plural = 'Anpassade inlägg' ) {
	$p_lower = strtolower( $plural );
	$s_lower = strtolower( $singular );

	return [
		'name'               => $plural,
		'singular_name'      => $singular,
		'add_new'            => _x( 'Lägg till inlägg', 'starterwp-textdomain' ),
		'add_new_item'       => __( 'Lägg till inlägg', 'starterwp-textdomain' ),
		'edit_item'          => __( 'Redigera inlägg', 'starterwp-textdomain' ),
		'new_item'           => __( 'Nytt inlägg', 'starterwp-textdomain' ),
		'all_items'          => __( 'Alla inlägg', 'starterwp-textdomain' ),
		'view_item'          => __( 'Se inlägg', 'starterwp-textdomain' ),
		'search_items'       => __( 'Sök inlägg', 'starterwp-textdomain' ),
		'not_found'          => __( 'Inga inlägg hittades', 'starterwp-textdomain' ),
		'not_found_in_trash' => __( 'Inga inlägg hittades i papperskorgen', 'starterwp-textdomain' ), 
	];
}
