<?php
/**
 * Navigational breadcrumbs
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

function the_breadcrumb() {
	// Configuration settings
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = '•'; // delimiter between crumbs
	$home        = 'Start'; // text for the 'Home' link
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb

	global $post;
	$homeLink = get_bloginfo('url'); // Get the home URL

	// Check if it's the homepage or the front page
	if (is_home() || is_front_page()) {
		if ($showOnHome == 1) {
			// Show breadcrumbs on the homepage if configured to do so
			echo '<div id="crumbs" class="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
		}
	} else {
		// Start the breadcrumbs output
		echo '<div id="crumbs" class="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
		
		// Check for different types of pages and outputs corresponding breadcrumb trail
		if (is_category()) {
			// Category page
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				echo get_category_parents($thisCat->parent, true, ' ' . $delimiter . ' ');
			}
			echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
		} elseif (is_search()) {
			// Search results page
			echo $before . 'Search results for "' . get_search_query() . '"' . $after;
		} elseif (is_day()) {
			// Daily archive
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} elseif (is_month()) {
			// Monthly archive
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} elseif (is_year()) {
			// Yearly archive
			echo $before . get_the_time('Y') . $after;
		} elseif (is_single() && !is_attachment()) {
			// Single post
			if (get_post_type() != 'post') {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
				if ($showCurrent == 1) {
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				}
			} else {
				$cat = get_the_category();
				$cat = $cat[0];
				$cats = get_category_parents($cat, true, ' ' . $delimiter . ' ');
				if ($showCurrent == 0) {
					$cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				}
				echo $cats;
				if ($showCurrent == 1) {
					echo $before . get_the_title() . $after;
				}
			}
		} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
			// Custom post type
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif (is_attachment()) {
			// Attachment page
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID);
			$cat = $cat[0];
			echo get_category_parents($cat, true, ' ' . $delimiter . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			if ($showCurrent == 1) {
				echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			}
		} elseif (is_page() && !$post->post_parent) {
			// Single page without parent
			if ($showCurrent == 1) {
				echo $before . get_the_title() . $after;
			}
		} elseif (is_page() && $post->post_parent) {
			// Single page with parent
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_post($parent_id); // Use get_post instead of get_page
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs) - 1) {
					echo ' ' . $delimiter . ' ';
				}
			}
			if ($showCurrent == 1) {
				echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			}
		} elseif (is_tag()) {
			// Tag archive
			echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
		} elseif (is_author()) {
			// Author archive
			global $author;
			$userdata = get_userdata($author);
			echo $before . 'Articles posted by ' . $userdata->display_name . $after;
		} elseif (is_404()) {
			// 404 error page
			echo $before . 'Error 404' . $after;
		}

		// Add pagination to breadcrumbs
		if (get_query_var('paged')) {
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
				echo ' (';
			}
			echo __('Page') . ' ' . get_query_var('paged');
			if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
				echo ')';
			}
		}
		echo '</div>'; // Close the breadcrumbs div
	}
}
