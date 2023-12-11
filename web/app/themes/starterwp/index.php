<?php
/**
 * The main template file
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

get_header(); ?>

	<div class="container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main row" role="main">

				<div class="col-md-8">
					<?php if ( have_posts() ) : if ( is_home() && ! is_front_page() ) : ?>
						<header>
							<?php single_post_title( '<h1 class="page-title screen-reader-text">', '</h1>' ); ?>
						</header>
					<?php endif;
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content', get_post_format() );
						endwhile;
						the_posts_pagination( array(
							'prev_text' => '<i class="fa fa-arrow-left" aria-hidden="true"></i><span class="screen-reader-text">' . __( 'Previous Page', 'text-domain' ) . '</span>',
							'next_text' => '<span class="screen-reader-text">' . __( 'Next Page', 'text-domain' ) . '</span><i class="fa fa-arrow-right" aria-hidden="true"></i>',
						) );
					?>
					<?php else :
						get_template_part( 'template-parts/content', 'none' );
					endif; ?>
				</div>
				
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div>
		
			</main>
		</div>
	</div>

<?php get_footer();
