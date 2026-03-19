<?php
/**
 * The template for displaying archive pages
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

get_header(); ?>

<div class="container">
	<div id="primary" class="content-area-full">
		<main id="main" class="site-main row">
			<div class="col-12" id="main-content" tabindex="-1">
				<?php if ( have_posts() ) : ?>
					<header class="page-header">
						<?php
							the_archive_title( '<h1 class="page-title mb-3">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header>

					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;

					the_posts_pagination(
						array(
							'prev_text'          => '<i class="fa fa-arrow-left" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html__( 'Föregående sida', 'knowit-starter-theme' ) . '</span>',
							'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Nästa sida', 'knowit-starter-theme' ) . '</span><i class="fa fa-arrow-right" aria-hidden="true"></i>',
							'type'               => 'list',
							'screen_reader_text' => esc_html__( 'Navigering för inläggssidor', 'knowit-starter-theme' ),
						)
					);
					?>

				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>
		</main>
	</div>
</div>

<?php
get_footer();
