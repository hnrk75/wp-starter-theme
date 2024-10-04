<?php
/**
 * Bootstrap 5 Navwalker
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

class navwalker extends Walker_Nav_menu {
	// Property to hold the current menu item
	private $current_item;

	// Array of possible dropdown menu alignment values
	private $dropdown_menu_alignment_values = [
		'dropdown-menu-start',
		'dropdown-menu-end',
		'dropdown-menu-sm-start',
		'dropdown-menu-sm-end',
		'dropdown-menu-md-start',
		'dropdown-menu-md-end',
		'dropdown-menu-lg-start',
		'dropdown-menu-lg-end',
		'dropdown-menu-xl-start',
		'dropdown-menu-xl-end',
		'dropdown-menu-xxl-start',
		'dropdown-menu-xxl-end'
	];

	// Method to start the level (ul element)
	function start_lvl(&$output, $depth = 0, $args = null) {
		// Array to hold classes for the dropdown menu
		$dropdown_menu_class[] = '';

		// Loop through the classes of the current menu item
		foreach($this->current_item->classes as $class) {
			// If the class is in the dropdown alignment values, add it to the array
			if(in_array($class, $this->dropdown_menu_alignment_values)) {
				$dropdown_menu_class[] = $class;
			}
		}

		// Indentation based on the depth level
		$indent = str_repeat("\t", $depth);

		// Determine if it's a sub-menu
		$submenu = ($depth > 0) ? ' sub-menu' : '';

		// Output the opening ul tag with the appropriate classes and depth
		$output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ", $dropdown_menu_class)) . " depth_$depth\">\n";
	}

	// Method to start the element (li and a/button element)
	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		// Set the current menu item
		$this->current_item = $item;

		// Indentation based on the depth level
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$li_attributes = '';
		$class_names = $value = '';

		// Get the classes for the menu item, default to an empty array if none are set
		$classes = empty($item->classes) ? array() : (array) $item->classes;

		// Add necessary classes for dropdowns and nav items
		$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
		$classes[] = 'nav-item';
		$classes[] = 'nav-item-' . $item->ID;

		// Add specific classes for deeper levels with children
		if ($depth && $args->walker->has_children) {
			$classes[] = 'dropdown-menu dropdown-menu-end';
		}

		// Add focus class if the item is active or meets other criteria
		$focus_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? '' : '';
		if ($focus_class) {
			$classes[] = $focus_class;
		}

		// Filter and join the classes, then set them as a string for the class attribute
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';

		// Filter and set the ID for the menu item
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

		// Output the opening li tag with ID and class attributes
		$output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

		// Prepare additional attributes for the link or button
		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		
		// Determine the active class for the menu item
		$active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
		$nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
		
		// Add necessary attributes for the link or button
		$attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . ' ' . $focus_class . '"';

		$item_output = $args->before;
		
		// Replace <a> with <button> if the item has children (for accessibility)
		if ($args->walker->has_children) {
			$item_output .= '<button' . $attributes . '>';
		} else {
			$item_output .= '<a' . $attributes . ' href="' . esc_attr($item->url) . '">';
		}

		// Add the title and close the anchor or button tag
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		if ($args->walker->has_children) {
			$item_output .= '</button>';
		} else {
			$item_output .= '</a>';
		}
		$item_output .= $args->after;

		// Filter and append the item output to the overall output
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}
