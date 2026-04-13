<?php
/**
 * The template for displaying the footer
 *
 * @package WP Starter Theme
 */

$footer_widgets = array(
	'footer-1' => array(
		'label'       => __( 'Sidfot widgetområde 1', 'wp-starter-theme' ),
		'placeholder' => array(
			'title' => get_bloginfo( 'name' ),
			'text'  => esc_html__( 'Lägg till en beskrivning av er verksamhet här.', 'wp-starter-theme' ),
		),
	),
	'footer-2' => array(
		'label'       => __( 'Sidfot widgetområde 2', 'wp-starter-theme' ),
		'placeholder' => array(
			'title' => esc_html__( 'Snabblänkar', 'wp-starter-theme' ),
			'text'  => esc_html__( 'Lägg till en menylista eller länkwidget här.', 'wp-starter-theme' ),
		),
	),
	'footer-3' => array(
		'label'       => __( 'Sidfot widgetområde 3', 'wp-starter-theme' ),
		'placeholder' => array(
			'title' => esc_html__( 'Kontakt', 'wp-starter-theme' ),
			'text'  => esc_html__( 'Lägg till kontaktuppgifter eller en karta här.', 'wp-starter-theme' ),
		),
	),
	'footer-4' => array(
		'label'       => __( 'Sidfot widgetområde 4', 'wp-starter-theme' ),
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
				<span>
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</span>

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'container'      => 'nav',
						'container_attr' => array(
							'aria-label' => __( 'Sidfotsmeny', 'wp-starter-theme' ),
						),
						'menu_class'     => 'footer-menu',
						'depth'          => 1,
						'fallback_cb'    => '__return_false',
					)
				);
				?>
			</div>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
