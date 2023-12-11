<?php
/**
 * The template for displaying the footer
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */
?>

	</div>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">

			<div class="row">
				<div class="col-md-4">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
				<div class="col-md-4">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
				<div class="col-md-4">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
			</div>
			
			<div class="site-info mt-5">
				<?php _e( 'Copyright', 'starterwp-textdomain' ); ?> &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ) ?>
			</div>
		
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
