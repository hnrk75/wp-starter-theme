<?php
/**
 * Template part for displaying page content in page.php
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> aria-labelledby="page-title-<?php the_ID(); ?>">

	<?php knowit_post_thumbnail( array( 'context' => 'page' ) ); ?>

	<header class="entry-header">
		<?php the_title( '<h1 id="page-title-' . get_the_ID() . '" class="entry-title mb-3">', '</h1>' ); ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Sidnavigering', 'knowit-starter-theme' ) . '"><span class="page-links-title">' . esc_html__( 'Sidor:', 'knowit-starter-theme' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>
</article>
