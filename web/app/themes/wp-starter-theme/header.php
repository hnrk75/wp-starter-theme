<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * knowit@author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">

		<header id="masthead" class="site-header" role="banner">
			<nav class="navbar navbar-expand-lg navbar-light" role="navigation" aria-label="Huvudmeny">
				<div class="container">

					<?php
					if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
						$alt_text = get_bloginfo( 'name' ) ? esc_attr( get_bloginfo( 'name' ) ) : esc_attr__( 'Webbplatsens logotyp', 'starterwp-textdomain' );
						echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
						echo '<img class="custom-logo" src="' . esc_url( $image[0] ) . '" alt="' . $alt_text . '">';
						echo '</a>';
					} else {
						echo '<div class="navbar-brand mb-0">';
						echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
						bloginfo( 'name' );
						echo '</a>';
						echo '</div>';
					}
					?>

					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Öppna/stäng meny">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="main-menu">
						<?php 
						wp_nav_menu( array(
							'theme_location' => 'main-menu',
							'container'      => false,
							'menu_class'     => '',
							'fallback_cb'    => '__return_false',
							'items_wrap'     => '<ul id="bootscore-navbar" class="navbar-nav ms-auto %2$s">%3$s</ul>',
							'depth'          => 2,
							'walker'         => new navwalker(),
							'menu_id'        => 'main-menu',
							'link_before'    => '<span>',
							'link_after'     => '</span>',
						) ); 
						?>
					</div>

				</div>
			</nav>
		</header>

		<div class="container">
			<nav class="breadcrumb-nav" aria-label="Brödsmulor">
				<?php if ( function_exists( 'the_breadcrumb' ) ) the_breadcrumb(); ?>
			</nav>
		</div>

		<div id="content" class="site-content">