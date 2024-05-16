<?php
/**
 * Custom template tags
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

if ( ! function_exists( 'starterwp_posted_on' ) ) :
	function starterwp_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'datum', 'starterwp-textdomain' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( '%s', 'inläggsförfattare', 'starterwp-textdomain' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on"><i class="far fa-clock"></i>' . $posted_on . '</span>
		<span class="byline"><i class="far fa-user"></i>' . $byline . '</span>';

		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'starterwp-textdomain' ) );
			if ( $categories_list && starterwp_categorized_blog() ) {
				printf( '<span class="cat-links"><i class="far fa-folder-open"></i>' . esc_html__( '%1$s', 'starterwp-textdomain' ) . '</span>', $categories_list );
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="far fa-comments"></i>';
			comments_popup_link( sprintf( wp_kses( __( 'Lämna en kommentar<span class="screen-reader-text"> på %s</span>', 'starterwp-textdomain' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

	}
endif;

if ( ! function_exists( 'starterwp_entry_footer' ) ) :
	function starterwp_entry_footer() {
		if ( 'post' === get_post_type() && is_single() ) {
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'starterwp-textdomain' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links"><i class="fas fa-tags"></i>' . esc_html__( '%1$s', 'starterwp-textdomain' ) . '</span>', $tags_list );
			}
		}

		edit_post_link(
			sprintf(
				esc_html__( 'Redigera %s', 'starterwp-textdomain' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link float-right">',
			'</span>', 0, 'btn btn-sm btn-danger'
		);
	}
endif;

function starterwp_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'starterwp_categories' ) ) ) {
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			'number'     => 2,
		) );
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'starterwp_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		return true;
	} else {
		return false;
	}
}

function starterwp_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'starterwp_categories' );
}
add_action( 'edit_category', 'starterwp_category_transient_flusher' );
add_action( 'save_post', 'starterwp_category_transient_flusher' );
