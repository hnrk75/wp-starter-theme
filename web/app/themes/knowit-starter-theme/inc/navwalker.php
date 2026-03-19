<?php
/**
 * Bootstrap 5 Navwalker med förbättrad a11y (WCAG) och WPCS-compat.
 *
 * @author  Henrik
 * @package Knowit Starter Theme
 */

class Knowit_Navwalker extends Walker_Nav_Menu {

	private $current_item = null;

	private $dropdown_menu_alignment_values = array(
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
		'dropdown-menu-xxl-end',
	);

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$dropdown_menu_class = array();

		if ( isset( $this->current_item->classes ) && is_array( $this->current_item->classes ) ) {
			foreach ( $this->current_item->classes as $class ) {
				if ( in_array( $class, $this->dropdown_menu_alignment_values, true ) ) {
					$dropdown_menu_class[] = $class;
				}
			}
		}

		$indent     = str_repeat( "\t", (int) $depth );
		$submenu    = ( $depth > 0 ) ? ' sub-menu' : '';
		$toggle_id  = isset( $this->current_item->ID ) ? 'nav-toggle-' . (int) $this->current_item->ID : '';
		$submenu_id = isset( $this->current_item->ID ) ? 'nav-submenu-' . (int) $this->current_item->ID : '';

		$output .= "\n$indent<ul"
			. ' id="' . esc_attr( $submenu_id ) . '"'
			. ' class="dropdown-menu' . esc_attr( $submenu ) . ' ' . esc_attr( implode( ' ', $dropdown_menu_class ) ) . " depth_$depth\""
			. ( $toggle_id ? ' aria-labelledby="' . esc_attr( $toggle_id ) . '"' : '' )
			. ">\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$this->current_item = $item;

		$indent    = $depth ? str_repeat( "\t", (int) $depth ) : '';
		$li_attrs  = '';
		$value     = '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_child = ! empty( $args->walker->has_children );

		$classes[] = $has_child ? 'dropdown' : '';
		$classes[] = 'nav-item';
		$classes[] = 'nav-item-' . (int) $item->ID;

		if ( $depth && $has_child ) {
			$classes[] = 'dropdown-menu dropdown-menu-end';
		}

		$is_active = ( ! empty( $item->current ) || ! empty( $item->current_item_ancestor ) || in_array( 'current_page_parent', $item->classes, true ) || in_array( 'current-post-ancestor', $item->classes, true ) );
		if ( $is_active ) {
			$classes[] = 'active';
		}

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$id_attr = apply_filters( 'nav_menu_item_id', 'menu-item-' . (int) $item->ID, $item, $args, $depth );
		$id_attr = $id_attr ? ' id="' . esc_attr( $id_attr ) . '"' : '';

		$output .= $indent . '<li' . $id_attr . $value . $class_names . $li_attrs . '>';

		// Attribut för länk/knapp.
		$attributes  = '';
		$attributes .= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';

		$active_class   = $is_active ? 'active' : '';
		$nav_link_class = ( $depth > 0 ) ? 'dropdown-item' : 'nav-link';

		$toggle_id  = 'nav-toggle-' . (int) $item->ID;
		$submenu_id = 'nav-submenu-' . (int) $item->ID;

		if ( $has_child ) {
			$attributes .= ' id="' . esc_attr( $toggle_id ) . '"'
				. ' class="' . esc_attr( trim( $nav_link_class . ' ' . $active_class ) ) . ' dropdown-toggle"'
				. ' data-bs-toggle="dropdown"'
				. ' aria-haspopup="true"'
				. ' aria-expanded="false"'
				. ' aria-controls="' . esc_attr( $submenu_id ) . '"';
		} else {
			$href         = ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';
			$aria_current = $is_active ? ' aria-current="page"' : '';
			$attributes  .= ' class="' . esc_attr( trim( $nav_link_class . ' ' . $active_class ) ) . '"' . $href . $aria_current;

			if ( ! empty( $item->target ) && strtolower( (string) $item->target ) === '_blank' ) {
				if ( stripos( (string) $item->xfn, 'noopener' ) === false && stripos( (string) $item->xfn, 'noreferrer' ) === false ) {
					if ( strpos( $attributes, ' rel="' ) !== false ) {
						$attributes = preg_replace( '/\srel="([^"]*)"/i', ' rel="$1 noopener noreferrer"', $attributes, 1 );
					} else {
						$attributes .= ' rel="noopener noreferrer"';
					}
				}
			}
		}

		$item_output = $args->before;

		if ( $has_child ) {
			$item_output .= '<button type="button"' . $attributes . '>';
		} else {
			$item_output .= '<a' . $attributes . '>';
		}

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $args->link_before . esc_html( $title ) . $args->link_after;

		if ( $has_child ) {
			$item_output .= '</button>';
		} else {
			$item_output .= '</a>';
		}

		$item_output .= $args->after;

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
