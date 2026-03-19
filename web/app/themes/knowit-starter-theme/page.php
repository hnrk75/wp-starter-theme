<?php
/**
 * The template for displaying all pages
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

get_header(); ?>

<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main row">
			<div class="col-md-8" id="main-content" tabindex="-1">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;
				?>
			</div>

			<aside class="col-md-4" aria-label="<?php echo esc_attr__( 'Sidopanel', 'knowit-starter-theme' ); ?>">
				<?php get_sidebar(); ?>
			</aside>
		</main>
	</div>
</div>

<?php
get_footer();
