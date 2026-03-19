<?php
/**
 * Template Name: Startsida
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

get_header(); ?>

<div class="container">
	<div id="primary" class="content-area-full">

		<main id="main" class="site-main" tabindex="-1">
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
								'before' => '<nav aria-label="' . esc_attr__( 'Sidnavigering', 'knowit-starter-theme' ) . '"><div class="page-links">' . esc_html__( 'Sidor:', 'knowit-starter-theme' ),
								'after'  => '</div></nav>',
							)
						);
						?>
					</div>

					<?php
					get_template_part( 'template-parts/theme', 'buttons' );
					get_template_part( 'template-parts/theme', 'typography' );
					?>
				</article>
				<?php
			endwhile;
			?>
		</main>

	</div>
</div>

<?php
get_footer();