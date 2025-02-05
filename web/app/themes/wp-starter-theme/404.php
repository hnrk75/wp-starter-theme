<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

get_header(); ?>

<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main row" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">
						<?php esc_html_e( 'Hoppsan! Den sidan kan inte hittas...', 'starterwp-textdomain' ); ?>
					</h1>
				</header>

				<div class="page-content">
					<p>
						<?php esc_html_e( 'Det verkar som om ingenting hittades på den här platsen. Kanske prova någon av länkarna nedan eller en sökning?', 'starterwp-textdomain' ); ?>
					</p>
					<?php get_search_form(); ?>
				</div>
			</section>

		</main>
	</div>
</div>

<?php get_footer();
