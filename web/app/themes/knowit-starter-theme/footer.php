<?php
/**
 * The template for displaying the footer
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */
?>

	</div>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row">

				<aside class="col-md-4 widget-area" aria-labelledby="footer-widgets-1-title">
					<h2 id="footer-widgets-1-title" class="screen-reader-text">
						<?php echo esc_html__( 'Sidfot widgetområde 1', 'knowit-starter-theme' ); ?>
					</h2>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</aside>

				<aside class="col-md-4 widget-area" aria-labelledby="footer-widgets-2-title">
					<h2 id="footer-widgets-2-title" class="screen-reader-text">
						<?php echo esc_html__( 'Sidfot widgetområde 2', 'knowit-starter-theme' ); ?>
					</h2>
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</aside>

				<aside class="col-md-4 widget-area" aria-labelledby="footer-widgets-3-title">
					<h2 id="footer-widgets-3-title" class="screen-reader-text">
						<?php echo esc_html__( 'Sidfot widgetområde 3', 'knowit-starter-theme' ); ?>
					</h2>
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</aside>

			</div>

			<div class="site-footer-copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				- <?php echo esc_html__( 'Alla rättigheter förbehållna.', 'knowit-starter-theme' ); ?>
			</div>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
