<?php
/**
 * The template for displaying search results pages
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

get_header(); ?>

<div class="container">
	<main
		id="main"
		class="content-main"
		tabindex="-1"
		aria-label="<?php echo esc_attr__( 'Sökresultat', 'wp-starter-theme' ); ?>"
	>
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title">
					<?php
					printf(
						esc_html__( 'Sökresultat för: %s', 'wp-starter-theme' ),
						'<span>' . esc_html( get_search_query() ) . '</span>'
					);
					?>
				</h1>
			</header>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'search' );
			endwhile;

			the_posts_pagination(
				array(
					'screen_reader_text' => esc_html__( 'Sidnavigering', 'wp-starter-theme' ),
					'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Föregående sida', 'wp-starter-theme' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Nästa sida', 'wp-starter-theme' ) . '</span>',
				)
			);
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
	</main>
</div>

<?php
get_footer();
