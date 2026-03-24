<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main">
	<?php echo esc_html__( 'Hoppa till innehåll', 'wp-starter-theme' ); ?>
</a>

<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="container">
			<div class="site-header__inner">

				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home" aria-label="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
				}
				?>

				<button class="site-nav__toggle" type="button"
					aria-controls="main-nav"
					aria-expanded="false"
					aria-label="<?php echo esc_attr__( 'Öppna meny', 'wp-starter-theme' ); ?>">
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</button>

				<nav class="site-nav" id="main-nav" aria-label="<?php echo esc_attr__( 'Huvudmeny', 'wp-starter-theme' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'main-menu',
							'container'      => false,
							'menu_class'     => 'site-nav__menu',
							'menu_id'        => 'main-menu',
							'fallback_cb'    => '__return_false',
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'          => 2,
							'walker'         => new Wpst_Navwalker(),
						)
					);
					?>
				</nav>

			</div>
		</div>
	</header>

	<?php
	if ( function_exists( 'wpst_the_breadcrumb' ) ) {
		$breadcrumbs = wpst_the_breadcrumb( false );
		if ( ! empty( $breadcrumbs ) ) {
			echo '<div class="container">' . wp_kses_post( $breadcrumbs ) . '</div>';
		}
	}
	?>

	<div id="content" class="site-content">
