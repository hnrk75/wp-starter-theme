<?php
/**
 * The main template file
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
						'screen_reader_text' => esc_html__( 'Sidnavigering', 'wp-starter-theme' ),
						'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Föregående sida', 'wp-starter-theme' ) . '</span>',
						'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Nästa sida', 'wp-starter-theme' ) . '</span>',
					)
				);

			} else {
				get_template_part( 'template-parts/content', 'none' );
			}
			?>
		</main>

		<aside class="content-sidebar" aria-label="<?php echo esc_attr__( 'Sidopanel', 'wp-starter-theme' ); ?>">
			<?php get_sidebar(); ?>
		</aside>
	</div>
</div>

<?php
get_footer();
