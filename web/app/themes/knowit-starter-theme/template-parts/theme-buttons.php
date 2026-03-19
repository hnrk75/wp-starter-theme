<?php
/**
 * Template part for displaying buttons page content in page-buttons.php
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

?>

<section id="theme-buttons" class="theme-buttons" aria-labelledby="theme-buttons-title">
	<header class="entry-header">
		<h2 id="theme-buttons-title"><?php echo esc_html__( 'Knappar – temastilar', 'knowit-starter-theme' ); ?></h2>
	</header>

	<div class="entry-content">
		<div class="btn-container">
			<?php
			// 1) Primär knapp
			knowit_button(
				array(
					'label'   => __( 'Primär (button)', 'knowit-starter-theme' ),
					'variant' => 'primary',
					'type'    => 'button',
				)
			);

			// 2) Sekundär knapp
			$icon_plus = '<svg class="icon" width="16" height="16" viewBox="0 0 24 24" role="img" aria-hidden="true">
				<path d="M12 3v18M3 12h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>';
			knowit_button(
				array(
					'label'   => __( 'Sekundär (button)', 'knowit-starter-theme' ),
					'variant' => 'secondary',
					'type'    => 'button',
					'icon_html' => $icon_plus,
					'icon_pos'  => 'after',
				)
			);

			// 3) Framgång – disabled knapp
			knowit_button(
				array(
					'label'    => __( 'Framgång (disabled)', 'knowit-starter-theme' ),
					'variant'  => 'success',
					'type'     => 'button',
					'disabled' => true,
				)
			);

			// 4) Fara – intern länk
			knowit_button(
				array(
					'label'   => __( 'Fara (länk)', 'knowit-starter-theme' ),
					'variant' => 'danger',
					'href'    => home_url( '/kontakt/' ),
				)
			);

			// 5) Varning – extern länk
			knowit_button(
				array(
					'label'    => __( 'Varning (extern länk)', 'knowit-starter-theme' ),
					'variant'  => 'warning',
					'href'     => 'https://example.com',
					'target'   => '_blank',
					'external' => true, // lägger till rel="noopener noreferrer"
				)
			);

			// 6) Information – inaktiv länk (aria-disabled)
			knowit_button(
				array(
					'label'    => __( 'Information (inaktiv länk)', 'knowit-starter-theme' ),
					'variant'  => 'info',
					'href'     => '#',
					'disabled' => true, // lägger till aria-disabled="true" + tabindex="-1"
				)
			);

			// 7) Ljus – vanlig länk
			knowit_button(
				array(
					'label'   => __( 'Ljus (länk)', 'knowit-starter-theme' ),
					'variant' => 'light',
					'href'    => home_url( '/om-oss/' ),
				)
			);

			// 8) Mörk – stor länk
			knowit_button(
				array(
					'label'   => __( 'Mörk (länk stor)', 'knowit-starter-theme' ),
					'variant' => 'dark',
					'href'    => home_url( '/cta/' ),
					'size'    => 'btn-lg',
				)
			);
			?>
		</div>
	</div>
</section>
