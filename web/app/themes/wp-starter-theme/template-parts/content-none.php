<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */
?>

<section class="no-results not-found" aria-labelledby="no-results-title">
	<header class="page-header">
		<h1 id="no-results-title" class="page-title">
			<?php esc_html_e( 'Inget hittades', 'wp-starter-theme' ); ?>
		</h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					wp_kses(
						__( 'Redo att publicera ditt första inlägg? <a href="%1$s">Börja här</a>.', 'wp-starter-theme' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Tyvärr, inga träffar matchade dina söktermer. Försök igen med andra ord.', 'wp-starter-theme' ); ?></p>
			<?php get_search_form(); ?>

			<nav class="no-results-links" aria-label="<?php echo esc_attr__( 'Alternativ när inget hittas', 'wp-starter-theme' ); ?>">
				<ul>
					<li>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php esc_html_e( 'Gå till startsidan', 'wp-starter-theme' ); ?>
						</a>
					</li>
				</ul>
			</nav>

		<?php else : ?>

			<p><?php esc_html_e( 'Det verkar som vi inte kan hitta det du letar efter. Kanske kan en sökning hjälpa.', 'wp-starter-theme' ); ?></p>
			<?php get_search_form(); ?>

			<nav class="no-results-links" aria-label="<?php echo esc_attr__( 'Alternativ när inget hittas', 'wp-starter-theme' ); ?>">
				<ul>
					<li>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php esc_html_e( 'Gå till startsidan', 'wp-starter-theme' ); ?>
						</a>
					</li>
				</ul>
			</nav>

		<?php endif; ?>
	</div>
</section>
