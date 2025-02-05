<?php
/**
 * The template for displaying search results pages
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

get_header(); ?>

<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main row" role="main" aria-labelledby="search-results-header" aria-live="polite">
			<div class="col-md-8">
				<?php if ( have_posts() ) : ?>
					<header class="page-header" id="search-results-header">
						<h1 class="page-title"><?php printf( esc_html__( 'Sökresultat för: %s', 'starterwp-textdomain' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header>

					<?php while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'search' );
					endwhile;

					the_posts_pagination( array(
						'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i><span class="screen-reader-text">' . __( 'Föregående sida', 'starterwp-textdomain' ) . '</span>',
						'next_text' => '<span class="screen-reader-text">' . __( 'Nästa sida', 'starterwp-textdomain' ) . '</span><i class="fa fa-arrow-right" aria-hidden="true"></i>',
						'aria_label' => esc_html__( 'Pagineringsnavigering', 'starterwp-textdomain' ),
					));
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</main>
	</div>
</div>

<?php get_footer();
