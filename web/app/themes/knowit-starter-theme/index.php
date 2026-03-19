<?php
/**
 * The main template file
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
				if ( have_posts() ) {

					if ( is_home() && ! is_front_page() ) {
						echo '<header>';
						single_post_title( '<h1 class="page-title screen-reader-text">', '</h1>' );
						echo '</header>';
					}

					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					}

					the_posts_pagination(
						array(
							'screen_reader_text' => esc_html__( 'Sidnavigering', 'knowit-starter-theme' ),
							'prev_text'          => '<i class="fa fa-arrow-left" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html__( 'Föregående sida', 'knowit-starter-theme' ) . '</span>',
							'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Nästa sida', 'knowit-starter-theme' ) . '</span><i class="fa fa-arrow-right" aria-hidden="true"></i>',
						)
					);

				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
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
