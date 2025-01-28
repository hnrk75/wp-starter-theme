<?php
/**
 * Template part for displaying page content in page.php
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail('full', array('class' => 'rounded')); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title mb-3">', '</h1>' ); ?>
	</header>

	<div class="entry-content">
		<?php the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'starterwp-textdomain' ),
				'after'  => '</div>',
			) ); ?>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						esc_html__( 'Edit %s', 'starterwp-textdomain' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer>
	<?php endif; ?>
</article>
