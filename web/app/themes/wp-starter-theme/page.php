<?php
/**
 * The template for displaying all pages
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

get_header(); ?>

<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main row" role="main" aria-labelledby="main-content-header">
			<div class="col-md-8">
				<?php while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

					if ( comments_open() || get_comments_number() ) :
						echo '<div id="comments" aria-labelledby="comments-header">';
						echo '<h2 id="comments-header">' . esc_html__( 'Kommentarer', 'starterwp-textdomain' ) . '</h2>';
						comments_template();
						echo '</div>';
					endif;
				endwhile; ?>
			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</main>
	</div>
</div>

<?php get_footer();
