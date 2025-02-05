<?php
/**
 * Navigational breadcrumbs
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

function generate_breadcrumb_link($url, $text) {
	return sprintf(
		'<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item" title="%s">%s</a></span>',
		esc_url($url),
		esc_attr(__('Gå till startsidan', 'starterwp-textdomain')),
		esc_html($text)
	);
}

function handle_category_breadcrumb($showCurrent, $delimiter, $before, $after) {
	$thisCat = get_category(get_query_var('cat'), false);
	if ($thisCat->parent != 0) {
		echo get_category_parents($thisCat->parent, true, ' ' . $delimiter . ' ');
	}
	echo $before . __('Kategori:', 'starterwp-textdomain') . ' ' . single_cat_title('', false) . $after;
}

function handle_date_breadcrumb($delimiter, $before, $after) {
	$year = get_the_time('Y');
	$month = get_the_time('m');
	$day = get_the_time('d');
	echo '<a href="' . get_year_link($year) . '" itemprop="item">' . $year . '</a> ' . $delimiter . ' ';
	echo '<a href="' . get_month_link($year, $month) . '" itemprop="item">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
	echo $before . $day . $after;
}

function handle_single_post_breadcrumb($homeLink, $showCurrent, $delimiter, $before, $after) {
	if (get_post_type() != 'post') {
		$post_type = get_post_type_object(get_post_type());
		$slug = $post_type->rewrite;
		echo '<a href="' . esc_url($homeLink . '/' . $slug['slug'] . '/') . '" itemprop="item">' . esc_html($post_type->labels->singular_name) . '</a>';
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
}

function handle_custom_post_type($before, $after) {
	$post_type = get_post_type_object(get_post_type());
	echo $before . esc_html($post_type->labels->singular_name) . $after;
}

function handle_attachment_breadcrumb($showCurrent, $delimiter, $before, $after) {
	$parent = get_post(get_post()->post_parent);
	$cat = get_the_category($parent->ID);
	$cat = $cat[0];
	echo get_category_parents($cat, true, ' ' . $delimiter . ' ');
	echo generate_breadcrumb_link(get_permalink($parent), $parent->post_title);
	if ($showCurrent == 1) {
		echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
	}
}

function handle_page_breadcrumb($showCurrent, $before, $after) {
	if ($showCurrent == 1) {
		echo $before . get_the_title() . $after;
	}
}

function handle_parent_page_breadcrumb($showCurrent, $delimiter, $before, $after) {
	$parent_id  = get_post()->post_parent;
	$breadcrumbs = [];
	while ($parent_id) {
		$page = get_post($parent_id);
		$breadcrumbs[] = generate_breadcrumb_link(get_permalink($page->ID), get_the_title($page->ID));
		$parent_id  = $page->post_parent;
	}
	$breadcrumbs = array_reverse($breadcrumbs);
	echo implode(' ' . $delimiter . ' ', $breadcrumbs);
	if ($showCurrent == 1) {
		echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
	}
}

function handle_author_breadcrumb($before, $after) {
	global $author;
	$userdata = get_userdata($author);
	echo $before . __('Artiklar postade av', 'starterwp-textdomain') . ' ' . esc_html($userdata->display_name) . $after;
}

function handle_pagination() {
	if (get_query_var('paged')) {
		echo ' (' . __('Sida', 'starterwp-textdomain') . ' ' . get_query_var('paged') . ')';
	}
}

function the_breadcrumb() {
	$showOnHome  = 0; // 0 - don't show, 1 - show
	$delimiter   = '•';
	$home        = __('Startsida', 'starterwp-textdomain');
	$showCurrent = 1; // 0 - don't show, 1 - show current post/page
	$before      = '<span class="current" aria-current="page">';
	$after       = '</span>';

	global $post;
	$homeLink = esc_url(get_bloginfo('url'));

	echo '<div id="crumbs" class="breadcrumbs" role="navigation" aria-label="Breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';

	if (is_home() || is_front_page()) {
		if ($showOnHome == 1) {
			echo generate_breadcrumb_link($homeLink, $home);
		}
		return;
	}

	echo generate_breadcrumb_link($homeLink, $home) . ' ' . $delimiter . ' ';

	if (is_category()) {
		handle_category_breadcrumb($showCurrent, $delimiter, $before, $after);
	} elseif (is_search()) {
		echo $before . __('Sökresultat för', 'starterwp-textdomain') . ' "' . get_search_query() . '"' . $after;
	} elseif (is_day() || is_month() || is_year()) {
		handle_date_breadcrumb($delimiter, $before, $after);
	} elseif (is_single() && !is_attachment()) {
		handle_single_post_breadcrumb($homeLink, $showCurrent, $delimiter, $before, $after);
	} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
		handle_custom_post_type($before, $after);
	} elseif (is_attachment()) {
		handle_attachment_breadcrumb($showCurrent, $delimiter, $before, $after);
	} elseif (is_page() && !$post->post_parent) {
		handle_page_breadcrumb($showCurrent, $before, $after);
	} elseif (is_page() && $post->post_parent) {
		handle_parent_page_breadcrumb($showCurrent, $delimiter, $before, $after);
	} elseif (is_tag()) {
		echo $before . __('Inlägg taggade', 'starterwp-textdomain') . ' "' . single_tag_title('', false) . '"' . $after;
	} elseif (is_author()) {
		handle_author_breadcrumb($before, $after);
	} elseif (is_404()) {
		echo $before . __('Fel 404: Sidan hittades inte', 'starterwp-textdomain') . $after;
	}

	handle_pagination();

	echo '</div>';
}

