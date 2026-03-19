<?php
/**
 * Template part for displaying buttons page content in page-buttons.php
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

?>

<section id="theme-buttons" class="theme-buttons" aria-labelledby="theme-buttons-title">
	<header class="entry-header">
		<h2 id="theme-buttons-title"><?php echo esc_html__( 'Knappar – temastilar', 'wp-starter-theme' ); ?></h2>
	</header>

	<div class="entry-content">
		<div class="btn-container">
			<?php
			// 1) Primär knapp
			wpst_button(
				array(
					'label'   => __( 'Primär (button)', 'wp-starter-theme' ),
					'variant' => 'primary',
					'type'    => 'button',
				)
			);

			// 2) Sekundär knapp
			$icon_plus = '<svg class="icon" width="16" height="16" viewBox="0 0 24 24" role="img" aria-hidden="true">
				<path d="M12 3v18M3 12h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>';
			wpst_button(
				array(
					'label'   => __( 'Sekundär (button)', 'wp-starter-theme' ),
					'variant' => 'secondary',
					'type'    => 'button',
					'icon_html' => $icon_plus,
					'icon_pos'  => 'after',
				)
			);

			// 3) Framgång – disabled knapp
			wpst_button(
				array(
					'label'    => __( 'Framgång (disabled)', 'wp-starter-theme' ),
					'variant'  => 'success',
					'type'     => 'button',
					'disabled' => true,
				)
			);

			// 4) Fara – intern länk
			wpst_button(
				array(
					'label'   => __( 'Fara (länk)', 'wp-starter-theme' ),
					'variant' => 'danger',
					'href'    => home_url( '/kontakt/' ),
				)
			);

			// 5) Varning – extern länk
			wpst_button(
				array(
					'label'    => __( 'Varning (extern länk)', 'wp-starter-theme' ),
					'variant'  => 'warning',
					'href'     => 'https://example.com',
					'target'   => '_blank',
					'external' => true, // lägger till rel="noopener noreferrer"
				)
			);

			// 6) Information – inaktiv länk (aria-disabled)
			wpst_button(
				array(
					'label'    => __( 'Information (inaktiv länk)', 'wp-starter-theme' ),
					'variant'  => 'info',
					'href'     => '#',
					'disabled' => true, // lägger till aria-disabled="true" + tabindex="-1"
				)
			);

			// 7) Ljus – vanlig länk
			wpst_button(
				array(
					'label'   => __( 'Ljus (länk)', 'wp-starter-theme' ),
					'variant' => 'light',
					'href'    => home_url( '/om-oss/' ),
				)
			);

			// 8) Mörk – stor länk
			wpst_button(
				array(
					'label'   => __( 'Mörk (länk stor)', 'wp-starter-theme' ),
					'variant' => 'dark',
					'href'    => home_url( '/cta/' ),
					'size'    => 'btn-lg',
				)
			);
			?>
		</div>
	</div>
</section>
