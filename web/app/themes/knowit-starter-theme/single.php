<?php
/**
 * The template for displaying all single posts
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
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> aria-labelledby="post-title-<?php the_ID(); ?>">
						<header class="entry-header">
							<h1 class="entry-title" id="post-title-<?php the_ID(); ?>">
								<?php echo esc_html( get_the_title() ); ?>
							</h1>
						</header>

						<div class="entry-content">
							<?php
							the_content();

							wp_link_pages(
								array(
									'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Sidnavigering', 'knowit-starter-theme' ) . '">',
									'after'  => '</nav>',
								)
							);
							?>
						</div>

						<footer class="entry-footer">
							<?php
							edit_post_link(
								esc_html__( 'Redigera', 'knowit-starter-theme' ),
								'<span class="edit-link">',
								'</span>'
							);
							?>
						</footer>
					</article>

					<?php
					the_post_navigation(
						array(
							'screen_reader_text' => esc_html__( 'Inläggsnavigering', 'knowit-starter-theme' ),
							'prev_text'          => '<span class="meta-nav" aria-hidden="true">&larr;</span> <span class="post-title">%title</span>',
							'next_text'          => '<span class="post-title">%title</span> <span class="meta-nav" aria-hidden="true">&rarr;</span>',
						)
					);

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
