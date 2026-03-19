<?php
/**
 * Template Name: Startsida
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

get_header(); ?>

<div class="container">
	<main
		id="main"
		class="content-main"
		tabindex="-1"
		aria-label="<?php echo esc_attr__( 'Huvudinnehåll', 'wp-starter-theme' ); ?>"
	>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<nav aria-label="' . esc_attr__( 'Sidnavigering', 'wp-starter-theme' ) . '"><div class="page-links">' . esc_html__( 'Sidor:', 'wp-starter-theme' ),
							'after'  => '</div></nav>',
						)
					);
					?>
				</div>
			</article>
			<?php
		endwhile;
		?>
	</main>
</div>

<?php
get_footer();