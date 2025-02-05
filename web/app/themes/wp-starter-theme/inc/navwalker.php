<?php
/**
 * Bootstrap 5 Navwalker
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

 class navwalker extends Walker_Nav_menu {
	private $current_item;
	private $dropdown_menu_alignment_values = [
		'dropdown-menu-start', 'dropdown-menu-end', 'dropdown-menu-sm-start', 'dropdown-menu-sm-end',
		'dropdown-menu-md-start', 'dropdown-menu-md-end', 'dropdown-menu-lg-start', 'dropdown-menu-lg-end',
		'dropdown-menu-xl-start', 'dropdown-menu-xl-end', 'dropdown-menu-xxl-start', 'dropdown-menu-xxl-end'
	];

	private function is_active_item($item) {
		return $item->current || $item->current_item_ancestor || in_array('current_page_parent', $item->classes, true) || in_array('current-post-ancestor', $item->classes, true);
	}

	function start_lvl(&$output, $depth = 0, $args = null) {
		$dropdown_menu_class = [];

		foreach ($this->current_item->classes as $class) {
			if (in_array($class, $this->dropdown_menu_alignment_values)) {
				$dropdown_menu_class[] = $class;
			}
		}

		$submenu = ($depth > 0) ? ' sub-menu' : '';
		$classes = esc_attr(implode(" ", $dropdown_menu_class));

		$output .= "\n" . str_repeat("\t", $depth) . "<ul class=\"dropdown-menu$submenu $classes depth_$depth\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		$this->current_item = $item;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$classes = ['nav-item', 'nav-item-' . $item->ID];
		$classes[] = ($args->walker->has_children) ? 'dropdown' : '';

		if ($this->is_active_item($item)) {
			$classes[] = 'active';
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li ' . $id . $class_names . '>';

		$attributes = '';
		$attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';

		$nav_link_class = ($depth > 0) ? 'dropdown-item ' : 'nav-link ';
		$attributes .= ($args->walker->has_children) ? ' class="' . $nav_link_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="' . $nav_link_class . '"';

		$item_output = $args->before;

		$item_output .= ($args->walker->has_children) ?
			'<button' . $attributes . '>' :
			'<a' . $attributes . ' href="' . esc_attr($item->url) . '">';

		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

		$item_output .= ($args->walker->has_children) ? '</button>' : '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}
