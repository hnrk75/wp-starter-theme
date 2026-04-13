<?php
/**
 * The template for displaying archive pages
 *
 * @package WP Starter Theme
 */

get_header(); ?>

<div class="container">
	<main
		id="main"
		class="content-main"
		tabindex="-1"
		aria-label="<?php echo esc_attr__( 'Huvudinnehåll', 'wp-starter-theme' ); ?>"
	>
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', get_post_format() );
			endwhile;

			the_posts_pagination(
				array(
					'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Föregående sida', 'wp-starter-theme' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Nästa sida', 'wp-starter-theme' ) . '</span>',
					'type'               => 'list',
					'screen_reader_text' => esc_html__( 'Navigering för inläggssidor', 'wp-starter-theme' ),
				)
			);
			?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
		<?php endif; ?>
	</main>
</div>

<?php
get_footer();
