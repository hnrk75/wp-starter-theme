<?php
/**
 * Template part for displaying results in search pages
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php knowit_post_thumbnail( array( 'context' => 'search' ) ); ?>

	<header class="entry-header">
		<?php
		the_title(
			sprintf(
				'<h2 class="entry-title"><a href="%s" rel="bookmark">',
				esc_url( get_permalink() )
			),
			'</a></h2>'
		);
		?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php knowit_posted_on(); ?>
			</div>
		<?php endif; ?>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php knowit_entry_footer(); ?>
	</footer>

</article>
