<?php
/**
 * Template part for displaying posts
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

$full_img = get_post_meta( get_the_ID(), '_djhenke_full_featured', true );
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
		<?php if ( is_single() ) : ?>
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>
		<?php else : ?>
			<h2 class="entry-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_title(); ?>
				</a>
			</h2>
		<?php endif; ?>
	</header>

	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php hnrkagency_posted_on_posted_on(); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content( sprintf(
			wp_kses( __( 'Fortsätt läsa %s <span class="meta-nav">&rarr;</span>', 'starterwp-textdomain' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		));

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Sidor:', 'starterwp-textdomain' ),
			'after'  => '</div>',
		)); ?>
	</div>

	<footer class="entry-footer">
		<?php hnrkagency_entry_footer(); ?>
	</footer>
</article>
