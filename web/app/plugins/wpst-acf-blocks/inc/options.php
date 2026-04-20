<?php
/**
 * Admin settings page for WPST ACF Blocks.
 *
 * Option key:    wpst_acf_blocks_settings
 * Settings group: wpst_acf_blocks_settings_group
 *
 * @package WPST ACF Blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ------------------------------------------------------------
// Defaults
// ------------------------------------------------------------

function wpst_acf_blocks_default_settings() {
	return array();
}

function wpst_acf_blocks_get_settings() {
	return wp_parse_args(
		get_option( 'wpst_acf_blocks_settings', array() ),
		wpst_acf_blocks_default_settings()
	);
}

// ------------------------------------------------------------
// Register settings
// ------------------------------------------------------------

function wpst_acf_blocks_register_settings() {
	register_setting(
		'wpst_acf_blocks_settings_group',
		'wpst_acf_blocks_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'wpst_acf_blocks_sanitize_settings',
			'default'           => wpst_acf_blocks_default_settings(),
		)
	);
}
add_action( 'admin_init', 'wpst_acf_blocks_register_settings' );

function wpst_acf_blocks_sanitize_settings( $input ) {
	return is_array( $input ) ? $input : array();
}

// ------------------------------------------------------------
// Admin menu
// ------------------------------------------------------------

function wpst_acf_blocks_add_menu_page() {
	add_menu_page(
		__( 'ACF Blocks — Inställningar', 'wpst-acf-blocks' ),
		__( 'ACF Blocks', 'wpst-acf-blocks' ),
		'manage_options',
		'wpst-acf-blocks',
		'wpst_acf_blocks_render_settings_page',
		'dashicons-layout',
		80
	);
}
add_action( 'admin_menu', 'wpst_acf_blocks_add_menu_page' );

// ------------------------------------------------------------
// Render page
// ------------------------------------------------------------

function wpst_acf_blocks_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'wpst_acf_blocks_settings_group' );
			do_settings_sections( 'wpst-acf-blocks' );
			submit_button( __( 'Spara inställningar', 'wpst-acf-blocks' ) );
			?>
		</form>
	</div>
	<?php
}
