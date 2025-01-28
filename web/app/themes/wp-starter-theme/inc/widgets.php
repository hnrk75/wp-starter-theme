<?php
/**
 * Register widget areas
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

function hnrkagency_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidofält', 'starterwp-textdomain' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Lägg till widgets här.', 'starterwp-textdomain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidfot ett', 'starterwp-textdomain' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Lägg till widgets här.', 'starterwp-textdomain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidfot två', 'starterwp-textdomain' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Lägg till widgets här.', 'starterwp-textdomain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidfot tre', 'starterwp-textdomain' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Lägg till widgets här.', 'starterwp-textdomain' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'hnrkagency_widgets_init' );
