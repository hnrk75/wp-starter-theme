<?php
/**
 * Register widget areas
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

function wpst_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidopanel', 'wp-starter-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Lägg till widgets här.', 'wp-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidfot ett', 'wp-starter-theme' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Lägg till widgets här.', 'wp-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidfot två', 'wp-starter-theme' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Lägg till widgets här.', 'wp-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidfot tre', 'wp-starter-theme' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Lägg till widgets här.', 'wp-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidfot fyra', 'wp-starter-theme' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Lägg till widgets här.', 'wp-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wpst_widgets_init' );
