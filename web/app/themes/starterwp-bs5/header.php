<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
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
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container">

					<?php if ( has_custom_logo() ) {
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
					?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img class="custom-logo" src="<?php echo $image[0]; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						</a>
					<?php } else { ?>
						<div class="navbar-brand mb-0">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</div>
					<?php } ?>

					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="main-menu">
						<?php wp_nav_menu( array(
							'theme_location' => 'main-menu',
							'container'      => false,
							'menu_class'     => '',
							'fallback_cb'    => '__return_false',
							'items_wrap'     => '<ul id="bootscore-navbar" class="navbar-nav ms-auto %2$s">%3$s</ul>',
							'depth'          => 2,
							'walker'         => new navwalker()
						) ); ?>
					</div>

					<div class="search-toggle d-none d-lg-block">
						<button class="search-icon icon-search"><?php echo esc_attr_x( 'Sök', 'starterwp-textdomain' ) ?> <i class="bi bi-search"></i></button>
						<button class="search-icon icon-close"><?php echo esc_attr_x( 'Stäng', 'starterwp-textdomain' ) ?> <i class="bi bi-x-lg"></i></button>
					</div>

				</div>
			</nav>

			<div class="search-container d-none d-lg-block">
				<div class="container">
					<?php get_template_part( 'searchform' ); ?>
				</div>
			</div>

		</header>

		<div class="container">
			<?php if (function_exists( 'the_breadcrumb' )) the_breadcrumb(); ?>
		</div>

		<div id="content" class="site-content">
