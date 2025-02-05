<?php
/**
 * The main template file
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

get_header(); ?>

<div class="container">
	<div id="primary" class="content-area" role="main">
		<main id="main" class="site-main row" aria-labelledby="main-content">
			<div class="col-md-8">
				<?php if ( have_posts() ) {
					if ( is_home() && !is_front_page() ) {
						echo '<header id="main-content">';
						single_post_title( '<h1 class="page-title">', '</h1>' );
						echo '</header>';
					}

					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					}

					the_posts_pagination( array(
						'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html__( 'Föregående sida', 'starterwp-textdomain' ) . '</span>',
						'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Nästa sida', 'starterwp-textdomain' ) . '</span><i class="fa fa-arrow-right" aria-hidden="true"></i>',
						'aria_label' => esc_html__( 'Pagineringsnavigering', 'starterwp-textdomain' ),
					));
				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
				?>
			</div>

			<div class="col-md-4" role="complementary">
				<?php get_sidebar(); ?>
			</div>
		</main>
	</div>
</div>

<?php get_footer();
