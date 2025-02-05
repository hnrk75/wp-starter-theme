<?php
/**
 * The template for displaying the footer
 *
 * knowit@author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

?>

	</div>

	<footer id="colophon" class="site-footer" role="contentinfo" aria-labelledby="footer-title">
		<div class="container">
			<div class="row">
				<div class="col-md-4" aria-labelledby="footer-1-title">
					<h2 id="footer-1-title" class="screen-reader-text">
						<?php esc_html_e( 'Sidfot widgetområde 1', 'starterwp-textdomain' ); ?>
					</h2>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
				<div class="col-md-4" aria-labelledby="footer-2-title">
					<h2 id="footer-2-title" class="screen-reader-text">
						<?php esc_html_e( 'Sidfot widgetområde 2', 'starterwp-textdomain' ); ?>
					</h2>
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
				<div class="col-md-4" aria-labelledby="footer-3-title">
					<h2 id="footer-3-title" class="screen-reader-text">
						<?php esc_html_e( 'Sidfot widgetområde 3', 'starterwp-textdomain' ); ?>
					</h2>
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
			</div>

			<div class="site-info mt-5" role="contentinfo">
				<h2 id="footer-title" class="screen-reader-text">
					<?php esc_html_e( 'Sidfotsinformation', 'starterwp-textdomain' ); ?>
				</h2>
				<?php _e( 'Copyright', 'starterwp-textdomain' ); ?> &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>
			</div>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
