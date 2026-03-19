<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

// Adds a search box to the WordPress navigation menu.
function wpst_add_search_box_to_menu( $items, $args ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	ob_start();
	get_search_form();
	$search_form = ob_get_clean();

	$search_item = '<li class="navbar-search" role="search">' . $search_form . '</li>';

	return $items . $search_item;
}
add_filter( 'wp_nav_menu_items', 'wpst_add_search_box_to_menu', 10, 2 );
