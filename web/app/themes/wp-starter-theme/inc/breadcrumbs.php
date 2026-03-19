<?php
/**
 * Navigational breadcrumbs
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

function wpst_generate_breadcrumb_link( $url, $text, $position ) {
	return sprintf(
		'<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<a class="link-animation" href="%1$s" itemprop="item" title="%2$s"><span itemprop="name">%3$s</span></a>
			<meta itemprop="position" content="%4$d" />
		</li>',
		esc_url( $url ),
		esc_attr( sprintf( __( 'Gå till sidan %s', 'wp-starter-theme' ), $text ) ),
		esc_html( $text ),
		(int) $position
	);
}

function wpst_handle_category_breadcrumb( $show_current, $delimiter, $before, $after, &$position ) {
	$output        = '';
	$posts_page_id = get_option( 'page_for_posts' );

	if ( $posts_page_id ) {
		$posts_page_link  = get_permalink( $posts_page_id );
		$posts_page_title = get_the_title( $posts_page_id );
		$output          .= wpst_generate_breadcrumb_link( $posts_page_link, $posts_page_title, $position++ ) . $delimiter;
	}

	$this_cat = get_category( (int) get_query_var( 'cat' ), false );

	if ( $this_cat && (int) $this_cat->parent !== 0 ) {
		$parents_html = get_category_parents( $this_cat->parent, true, $delimiter );
		$output      .= wp_kses_post( $parents_html );
	}

	$output .= '<li aria-current="page">' . wp_kses_post( $before ) . esc_html__( 'Kategori:', 'wp-starter-theme' ) . ' ' . esc_html( single_cat_title( '', false ) ) . wp_kses_post( $after ) . '</li>';

	echo wp_kses_post( $output );
}

function wpst_handle_date_breadcrumb( $delimiter, $before, $after, &$position ) {
	$year  = get_the_time( 'Y' );
	$month = get_the_time( 'm' );
	$day   = get_the_time( 'd' );

	echo wp_kses_post(
		wpst_generate_breadcrumb_link( get_year_link( $year ), $year, $position )
	);
	++$position;
	echo wp_kses_post( $delimiter );

	echo wp_kses_post(
		wpst_generate_breadcrumb_link( get_month_link( $year, $month ), get_the_time( 'F' ), $position )
	);
	++$position;
	echo wp_kses_post( $delimiter );

	echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( $day ) . wp_kses_post( $after ) . '</li>';
}

function wpst_handle_single_post_breadcrumb( $home_link, $show_current, $delimiter, $before, $after, &$position ) {
	$post_type = get_post_type();

	if ( $post_type !== 'post' ) {

		if ( $post_type === 'artists' ) {
			$terms = get_the_terms( get_the_ID(), 'artists-category' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$term      = $terms[0];
				$term_link = get_term_link( $term );
				if ( ! is_wp_error( $term_link ) ) {
					echo wp_kses_post( wpst_generate_breadcrumb_link( $term_link, $term->name, $position++ ) . $delimiter );
				}
			}
		} elseif ( in_array( $post_type, array( 'services', 'activities' ), true ) ) {
			$post_type_object = get_post_type_object( $post_type );
			if ( $post_type_object && ! empty( $post_type_object->has_archive ) ) {
				$archive_link  = get_post_type_archive_link( $post_type );
				$archive_label = $post_type_object->labels->name;
				echo wp_kses_post( wpst_generate_breadcrumb_link( $archive_link, $archive_label, $position++ ) . $delimiter );
			}
		}

		if ( (int) $show_current === 1 ) {
			echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( get_the_title() ) . wp_kses_post( $after ) . '</li>';
		}
	} else {
		$posts_page_id = get_option( 'page_for_posts' );
		if ( $posts_page_id ) {
			echo wp_kses_post(
				wpst_generate_breadcrumb_link( get_permalink( $posts_page_id ), get_the_title( $posts_page_id ), $position++ ) . $delimiter
			);
		}

		$cat = get_the_category();
		if ( ! empty( $cat ) ) {
			$cat  = $cat[0];
			$cats = get_category_parents( $cat, true, $delimiter );

			if ( (int) $show_current === 0 ) {
				$cats = preg_replace( '#^(.+)\s' . preg_quote( $delimiter, '#' ) . '\s$#', '$1', $cats );
			}
			$cats = rtrim( $cats, ' ' . wp_strip_all_tags( $delimiter ) );

			echo '<li class="breadcrumb-category">' . wp_kses_post( $cats ) . '</li>';
		}

		if ( (int) $show_current === 1 ) {
			echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( get_the_title() ) . wp_kses_post( $after ) . '</li>';
		}
	}
}

function wpst_handle_custom_post_type( $before, $after ) {
	$post_type = get_post_type_object( get_post_type() );
	if ( $post_type && isset( $post_type->labels->name ) ) {
		echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( $post_type->labels->name ) . wp_kses_post( $after ) . '</li>';
	}
}

function wpst_handle_attachment_breadcrumb( $show_current, $delimiter, $before, $after ) {
	$parent = get_post( get_post()->post_parent );
	if ( $parent ) {
		$cat = get_the_category( $parent->ID );
		if ( ! empty( $cat ) ) {
			$cat = $cat[0];
			echo wp_kses_post( get_category_parents( $cat, true, $delimiter ) );
		}
		echo wp_kses_post( wpst_generate_breadcrumb_link( get_permalink( $parent ), $parent->post_title, 0 ) );
	}

	if ( (int) $show_current === 1 ) {
		echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( get_the_title() ) . wp_kses_post( $after ) . '</li>';
	}
}

function wpst_handle_page_breadcrumb( $show_current, $before, $after ) {
	if ( (int) $show_current === 1 ) {
		echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( get_the_title() ) . wp_kses_post( $after ) . '</li>';
	}
}

function wpst_handle_parent_page_breadcrumb( $show_current, $delimiter, $before, $after, &$position ) {
	$parent_id   = get_post()->post_parent;
	$breadcrumbs = array();

	while ( $parent_id ) {
		$page          = get_post( $parent_id );
		$breadcrumbs[] = wpst_generate_breadcrumb_link( get_permalink( $page->ID ), get_the_title( $page->ID ), $position++ );
		$parent_id     = $page->post_parent;
	}

	$breadcrumbs = array_reverse( $breadcrumbs );
	echo wp_kses_post( implode( $delimiter, $breadcrumbs ) );

	if ( (int) $show_current === 1 ) {
		echo wp_kses_post( $delimiter ) . '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( get_the_title() ) . wp_kses_post( $after ) . '</li>';
	}
}

function wpst_handle_author_breadcrumb( $before, $after ) {
	global $author;
	$userdata = get_userdata( $author );
	if ( $userdata ) {
		echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html__( 'Artiklar postade av', 'wp-starter-theme' ) . ' ' . esc_html( $userdata->display_name ) . wp_kses_post( $after ) . '</li>';
	}
}

function wpst_handle_pagination() {
	$paged = (int) get_query_var( 'paged' );

	if ( $paged ) {
		echo ' (' . esc_html__( 'Sida', 'wp-starter-theme' ) . ' ' . esc_html( $paged ) . ')';
	}
}

function wpst_the_breadcrumb( $display = true ) {
	$showOnHome  = 0;
	$delimiter   = '<li class="delimiter" aria-hidden="true"> • </li>';
	$home        = __( 'Startsida', 'wp-starter-theme' );
	$showCurrent = 1;
	$before      = '<span class="current" aria-current="page">';
	$after       = '</span>';

	global $post;
	$home_link = esc_url( get_bloginfo( 'url' ) );

	ob_start();

	if ( is_front_page() ) {
		ob_end_clean();
		return '';
	}

	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Brödsmulor', 'wp-starter-theme' ) . '" role="navigation">';
	echo '<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb-list">';

	$position = 1;
	echo wp_kses_post( wpst_generate_breadcrumb_link( $home_link, $home, $position++ ) );

	if ( is_home() ) {
		$posts_page_id = get_option( 'page_for_posts' );
		if ( $posts_page_id ) {
			$posts_page = get_post( $posts_page_id );
			echo wp_kses_post( $delimiter );
			echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( get_the_title( $posts_page ) ) . wp_kses_post( $after ) . '</li>';
		}
	} elseif ( is_category() ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_category_breadcrumb( $showCurrent, $delimiter, $before, $after, $position );

	} elseif ( is_tax( 'artists-category' ) ) {
		echo wp_kses_post( $delimiter );
		$term = get_queried_object();
		if ( $term && isset( $term->name ) ) {
			echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html( $term->name ) . wp_kses_post( $after ) . '</li>';
		}
	} elseif ( is_search() ) {
		echo wp_kses_post( $delimiter );
		echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html__( 'Sökresultat för', 'wp-starter-theme' ) . ' "' . esc_html( get_search_query() ) . '"' . wp_kses_post( $after ) . '</li>';

	} elseif ( is_day() || is_month() || is_year() ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_date_breadcrumb( $delimiter, $before, $after, $position );

	} elseif ( is_single() && ! is_attachment() ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_single_post_breadcrumb( $home_link, $showCurrent, $delimiter, $before, $after, $position );

	} elseif ( ! is_single() && ! is_page() && get_post_type() !== 'post' && ! is_404() && ! is_tax( 'artists-category' ) ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_custom_post_type( $before, $after );

	} elseif ( is_attachment() ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_attachment_breadcrumb( $showCurrent, $delimiter, $before, $after );

	} elseif ( is_page() && isset( $post->post_parent ) && (int) $post->post_parent !== 0 ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_parent_page_breadcrumb( $showCurrent, $delimiter, $before, $after, $position );

	} elseif ( is_page() ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_page_breadcrumb( $showCurrent, $before, $after );

	} elseif ( is_author() ) {
		echo wp_kses_post( $delimiter );
		wpst_handle_author_breadcrumb( $before, $after );

	} elseif ( is_404() ) {
		echo wp_kses_post( $delimiter );
		echo '<li aria-current="page">' . wp_kses_post( $before ) . esc_html__( 'Fel 404: Sidan hittades inte', 'wp-starter-theme' ) . wp_kses_post( $after ) . '</li>';
	}

	wpst_handle_pagination();

	echo '</ol>';
	echo '</nav>';

	$output = ob_get_clean();

	if ( $display ) {
		echo wp_kses_post( $output );
	} else {
		return $output;
	}
}
