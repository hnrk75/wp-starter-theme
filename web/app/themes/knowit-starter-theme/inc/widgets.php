<?php
/**
 * Register widget areas
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

function knowit_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidopanel', 'knowit-starter-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Lägg till widgets här.', 'knowit-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidfot ett', 'knowit-starter-theme' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Lägg till widgets här.', 'knowit-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidfot två', 'knowit-starter-theme' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Lägg till widgets här.', 'knowit-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidfot tre', 'knowit-starter-theme' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Lägg till widgets här.', 'knowit-starter-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'knowit_widgets_init' );
