<?php
/**
 * The template for displaying all pages
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

get_header(); ?>

<div class="container">
	<div class="content-layout">
		<main
			id="main"
			class="content-main"
			tabindex="-1"
			aria-label="<?php echo esc_attr__( 'Huvudinnehåll', 'wp-starter-theme' ); ?>"
		>
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
			?>
		</main>

		<aside class="content-sidebar" aria-label="<?php echo esc_attr__( 'Sidopanel', 'wp-starter-theme' ); ?>">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</div>

<?php
get_footer();
