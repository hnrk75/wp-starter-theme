<?php
/**
 * Template part for displaying results in search pages
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	$thumbnail_size = 'full';
	$thumbnail_alt = esc_attr( get_the_title() ? get_the_title() : 'Inget titel angivet' );

	if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail alignfull">
			<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( $thumbnail_size, array( 'class' => 'rounded', 'alt' => $thumbnail_alt ) ); ?>
			</a>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h2>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php hnrkagency_posted_on(); ?>
			</div>
		<?php endif; ?>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php hnrkagency_entry_footer(); ?>
	</footer>
</article>
