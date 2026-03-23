<?php
/**
 * The template for displaying the footer
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

$footer_widgets = array(
	'footer-1' => array(
		'label'       => 'Sidfot widgetområde 1',
		'placeholder' => array(
			'title' => get_bloginfo( 'name' ),
			'text'  => esc_html__( 'Lägg till en beskrivning av er verksamhet här.', 'wp-starter-theme' ),
		),
	),
	'footer-2' => array(
		'label'       => 'Sidfot widgetområde 2',
		'placeholder' => array(
			'title' => esc_html__( 'Snabblänkar', 'wp-starter-theme' ),
			'text'  => esc_html__( 'Lägg till en menylista eller länkwidget här.', 'wp-starter-theme' ),
		),
	),
	'footer-3' => array(
		'label'       => 'Sidfot widgetområde 3',
		'placeholder' => array(
			'title' => esc_html__( 'Kontakt', 'wp-starter-theme' ),
			'text'  => esc_html__( 'Lägg till kontaktuppgifter eller en karta här.', 'wp-starter-theme' ),
		),
	),
	'footer-4' => array(
		'label'       => 'Sidfot widgetområde 4',
		'placeholder' => array(
			'title' => esc_html__( 'Övrigt', 'wp-starter-theme' ),
			'text'  => esc_html__( 'Lägg till valfritt innehåll här.', 'wp-starter-theme' ),
		),
	),
);
?>

	</div>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-footer__widgets">

				<?php foreach ( $footer_widgets as $sidebar_id => $widget ) : ?>
				<aside class="widget-area" aria-labelledby="footer-<?php echo esc_attr( $sidebar_id ); ?>-title">
					<h2 id="footer-<?php echo esc_attr( $sidebar_id ); ?>-title" class="screen-reader-text">
						<?php echo esc_html( $widget['label'] ); ?>
					</h2>
					<?php if ( is_active_sidebar( $sidebar_id ) ) : ?>
						<?php dynamic_sidebar( $sidebar_id ); ?>
					<?php else : ?>
						<h3 class="widget-title"><?php echo esc_html( $widget['placeholder']['title'] ); ?></h3>
						<p><?php echo esc_html( $widget['placeholder']['text'] ); ?></p>
					<?php endif; ?>
				</aside>
				<?php endforeach; ?>

			</div>

			<div class="site-footer__copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				- <?php echo esc_html__( 'Alla rättigheter förbehållna.', 'wp-starter-theme' ); ?>
			</div>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
