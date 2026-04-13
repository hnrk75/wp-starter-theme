<?php
/**
 * Admin customizations.
 *
 * @package WP Starter Theme
 */

// --- Kommentarer avaktiverade globalt ----------------------------
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 10 );

add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit-comments.php' );
	}
);

add_action(
	'init',
	function () {
		remove_post_type_support( 'post', 'comments' );
		remove_post_type_support( 'page', 'comments' );
	}
);

// --- Hide Site Editor (Design) ----------------------------------
// Editors should not see FSE/patterns — misleading for a classic theme.
add_action(
	'admin_menu',
	function () {
		remove_submenu_page( 'themes.php', 'site-editor.php' );
	},
	999
);
