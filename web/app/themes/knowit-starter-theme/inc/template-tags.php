<?php
/**
 * Custom template tags
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

if ( ! function_exists( 'knowit_posted_on' ) ) :
	function knowit_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Publicerad %s', 'post date', 'knowit-starter-theme' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'av %s', 'post author', 'knowit-starter-theme' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on"><i class="far fa-clock" aria-hidden="true"></i> ' . wp_kses_post( $posted_on ) . '</span>';
		echo ' <span class="byline"><i class="far fa-user" aria-hidden="true"></i> ' . wp_kses_post( $byline ) . '</span>';

		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list && knowit_categorized_blog() ) {
				printf(
					'<span class="cat-links"><i class="far fa-folder-open" aria-hidden="true"></i> %s</span>',
					wp_kses_post( $categories_list )
				);
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="far fa-comments" aria-hidden="true"></i> ';
			comments_popup_link(
				sprintf(
					wp_kses(
						__( 'Lämna en kommentar<span class="screen-reader-text"> på %s</span>', 'knowit-starter-theme' ),
						array( 'span' => array( 'class' => array() ) )
					),
					esc_html( get_the_title() )
				)
			);
			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'knowit_entry_footer' ) ) :
	function knowit_entry_footer() {
		if ( 'post' === get_post_type() && is_single() ) {
			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) {
				printf(
					'<span class="tags-links"><i class="fas fa-tags" aria-hidden="true"></i> %s</span>',
					wp_kses_post( $tags_list )
				);
			}
		}

		edit_post_link(
			sprintf(
				esc_html__( 'Redigera %s', 'knowit-starter-theme' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link float-right">',
			'</span>',
			0,
			'btn btn-sm btn-danger'
		);
	}
endif;

function knowit_categorized_blog() {
	$all_the_cool_cats = get_transient( 'knowit_categories' );

	if ( false === $all_the_cool_cats ) {
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				'number'     => 2,
			)
		);
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'knowit_categories', $all_the_cool_cats );
	}

	return ( (int) $all_the_cool_cats > 1 );
}

function knowit_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'knowit_categories' );
}
add_action( 'edit_category', 'knowit_category_transient_flusher' );
add_action( 'save_post', 'knowit_category_transient_flusher' );

if ( ! function_exists( 'knowit_post_thumbnail' ) ) :
	function knowit_post_thumbnail( $args = array() ) {
		if ( ! has_post_thumbnail() ) {
			return;
		}

		$defaults = array(
			'context' => 'auto',
			'size'    => 'full',
			'class'   => '',
			'link'    => null,
			'eager'   => false,
		);
		$a = wp_parse_args( $args, $defaults );

		if ( 'auto' === $a['context'] ) {
			if ( is_search() ) {
				$a['context'] = 'search';
			} elseif ( is_singular( 'page' ) ) {
				$a['context'] = 'page';
			} elseif ( is_singular() ) {
				$a['context'] = 'single';
			} else {
				$a['context'] = 'archive';
			}
		}

		$post_id   = get_the_ID();
		$thumb_id  = get_post_thumbnail_id( $post_id );
		$alt_meta  = $thumb_id ? get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) : '';
		$alt_meta  = is_string( $alt_meta ) ? trim( $alt_meta ) : '';
		$img_class = trim( 'rounded ' . (string) $a['class'] );

		$alt_for_img = ( 'single' === $a['context'] || 'page' === $a['context'] )
			? ( $alt_meta !== '' ? $alt_meta : '' )
			: '';

		$loading = $a['eager'] ? 'eager' : 'lazy';

		$wrapper_class = 'post-thumbnail';
		if ( 'single' === $a['context'] ) {
			$full_img = get_post_meta( $post_id, '_knowit_full_featured', true );
			if ( ! empty( $full_img ) ) {
				$wrapper_class .= ' alignfull';
			}
		}

		if ( is_null( $a['link'] ) ) {
			$a['link'] = in_array( $a['context'], array( 'archive', 'search' ), true );
		}

		$img_attrs = array(
			'class'   => $img_class,
			'alt'     => $alt_for_img,
			'loading' => $loading,
		);

		echo '<div class="' . esc_attr( $wrapper_class ) . '">';

		if ( $a['link'] ) {
			echo '<a href="' . esc_url( get_permalink() ) . '">';
			the_post_thumbnail( $a['size'], $img_attrs );
			echo '</a>';
		} else {
			the_post_thumbnail( $a['size'], $img_attrs );
		}

		echo '</div>';
	}
endif;
