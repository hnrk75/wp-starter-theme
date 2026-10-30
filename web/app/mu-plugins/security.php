<?php
/**
 * Plugin Name: Security Hardening
 *
 * Description: Basic security hardening: enforces disabled registration, disables XML-RPC and application passwords, hides usernames and the WordPress version, sends security headers and emails the admin when a user is created or becomes administrator/editor.
 *
 * Version:     1.0.0
 * Author:      Henrik Pettersson <henrik.pettersson@knowit.se>
 * License:     MIT License
 *
 * @package Security_Hardening
 */

/**
 * Registration is always disabled and new users never get more than the subscriber role,
 * regardless of what is stored in the database.
 */
add_filter( 'pre_option_users_can_register', '__return_zero' );
add_filter(
	'pre_option_default_role',
	function () {
		return 'subscriber';
	}
);

/**
 * Disable XML-RPC completely (brute force via system.multicall, pingbacks).
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );
add_filter(
	'wp_headers',
	function ( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	}
);

/**
 * Application passwords bypass the regular login and are not used.
 */
add_filter( 'wp_is_application_passwords_available', '__return_false' );

/**
 * Prevent logged-out visitors from enumerating usernames.
 */
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		if ( is_user_logged_in() ) {
			return $endpoints;
		}

		foreach ( array_keys( $endpoints ) as $route ) {
			if ( str_starts_with( $route, '/wp/v2/users' ) ) {
				unset( $endpoints[ $route ] );
			}
		}

		return $endpoints;
	}
);

add_action(
	'template_redirect',
	function () {
		if ( is_user_logged_in() ) {
			return;
		}

		if ( is_author() || isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only checks whether the parameter exists.
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	},
	1
);

add_filter(
	'wp_sitemaps_add_provider',
	function ( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	},
	10,
	2
);

/**
 * Same error message whether the username does not exist or the password is wrong.
 */
add_filter(
	'authenticate',
	function ( $user ) {
		if ( is_wp_error( $user ) && array_intersect( $user->get_error_codes(), array( 'invalid_username', 'invalid_email', 'incorrect_password' ) ) ) {
			return new WP_Error( 'invalid_credentials', __( '<strong>Fel:</strong> Felaktigt användarnamn eller lösenord.' ) );
		}

		return $user;
	},
	99
);

/**
 * Do not expose the WordPress version.
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/**
 * Security headers.
 */
add_action(
	'send_headers',
	function () {
		header_remove( 'X-Powered-By' );
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
		header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );

		if ( 'production' === wp_get_environment_type() && is_ssl() ) {
			header( 'Strict-Transport-Security: max-age=31536000' );
		}
	}
);

/**
 * Email the admin when a user is created or gets a role with editing capabilities.
 *
 * @param string $subject Email subject.
 * @param int    $user_id User ID.
 */
function security_hardening_notify( $subject, $user_id ) {
	$user = get_userdata( $user_id );

	if ( ! $user ) {
		return;
	}

	$actor = wp_get_current_user()->user_login;
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

	$message = implode(
		"\n",
		array(
			'Användare: ' . $user->user_login . ' (ID ' . $user->ID . ')',
			'E-post: ' . $user->user_email,
			'Roller: ' . implode( ', ', $user->roles ),
			'Utförd av: ' . ( $actor ? $actor : 'okänd/utloggad' ),
			'IP: ' . ( $ip ? $ip : 'okänd' ),
			'Webbplats: ' . home_url(),
		)
	);

	wp_mail( get_option( 'admin_email' ), '[' . wp_parse_url( home_url(), PHP_URL_HOST ) . '] ' . $subject, $message );
}

add_action(
	'user_register',
	function ( $user_id ) {
		security_hardening_notify( 'Ny användare skapad', $user_id );
	}
);

add_action(
	'set_user_role',
	function ( $user_id, $role, $old_roles ) {
		if ( in_array( $role, array( 'administrator', 'editor' ), true ) && ! in_array( $role, $old_roles, true ) ) {
			security_hardening_notify( 'Användare fick rollen ' . $role, $user_id );
		}
	},
	10,
	3
);
