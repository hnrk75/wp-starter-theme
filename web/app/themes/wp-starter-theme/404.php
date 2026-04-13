<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WP Starter Theme
 */

get_header(); ?>

<div class="container">
	<main
		id="main"
		class="content-main"
		tabindex="-1"
		aria-labelledby="page-title-404"
	>
		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title" id="page-title-404">
					<?php esc_html_e( 'Oops! Den här sidan kunde inte hittas.', 'wp-starter-theme' ); ?>
				</h1>
			</header>

			<div class="page-content">
				<p>
					<?php esc_html_e( 'Det verkar som att inget hittades här. Du kan prova en sökning eller använda någon av knapparna nedan.', 'wp-starter-theme' ); ?>
				</p>

				<?php get_search_form(); ?>

				<nav aria-label="<?php echo esc_attr__( 'Alternativa länkar för 404-sidan', 'wp-starter-theme' ); ?>">
					<?php
					wpst_button(
						array(
							'label'      => __( 'Gå till startsidan', 'wp-starter-theme' ),
							'variant'    => 'primary',
							'href'       => home_url( '/' ),
							'aria_label' => __( 'Gå till startsidan', 'wp-starter-theme' ),
						)
					);

					wpst_button(
						array(
							'label'      => __( 'Sök igen', 'wp-starter-theme' ),
							'variant'    => 'secondary',
							'href'       => home_url( '/?s=' ),
							'aria_label' => __( 'Sök igen', 'wp-starter-theme' ),
						)
					);
					?>
				</nav>
			</div>
		</section>
	</main>
</div>

<?php
get_footer();
