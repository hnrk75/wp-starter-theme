<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

// Adds a search box to the WordPress navigation menu.
function add_search_box_to_menu( $items, $args ) {
	ob_start();
	get_search_form();
	$searchform = ob_get_contents();
	ob_end_clean();
	$items .= '<li class="navbar-search">' . $searchform . '</li>';
	return $items;
}
add_filter('wp_nav_menu_items', 'add_search_box_to_menu', 10, 2);
