<?php
/**
 * Template part for displaying page content in page.php
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
		<h1 class="entry-title mb-3">
			<?php the_title(); ?>
		</h1>
	</header>

	<div class="entry-content">
		<?php the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Sidor:', 'starterwp-textdomain' ),
				'after'  => '</div>',
			) ); ?>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php edit_post_link(
				sprintf(
					esc_html__( 'Redigera %s', 'starterwp-textdomain' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			); ?>
		</footer>
	<?php endif; ?>
</article>
