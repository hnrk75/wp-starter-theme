<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

?>

<section class="no-results not-found" aria-live="polite">
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e( 'Inget hittades', 'starterwp-textdomain' ); ?>
		</h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php printf( wp_kses_post( __( 'Redo att publicera ditt första inlägg? <a href="%1$s">Kom igång här</a>.', 'starterwp-textdomain' ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p>
				<?php esc_html_e( 'Tyvärr, vi kunde inte hitta något som matchade dina söktermer. Försök gärna igen med andra sökord.', 'starterwp-textdomain' ); ?>
			</p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p>
				<?php esc_html_e( 'Det verkar som vi inte kan hitta det du söker. Kanske kan en sökning hjälpa.', 'starterwp-textdomain' ); ?>
			</p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
