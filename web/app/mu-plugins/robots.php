<?php
/**
 * Plugin Name: Robots.txt
 *
 * Description: Serves a robots.txt that blocks wp-admin (except admin-ajax.php) and points to the core sitemap. Paths and URLs are derived from the site settings, so the file works unchanged in any Bedrock or regular WordPress install.
 *
 * Version:     1.1.0
 * Author:      Henrik Pettersson <henrik.pettersson@knowit.se>
 * License:     MIT License
 *
 * @package Robots_Txt
 */

add_filter(
	'robots_txt',
	function ( $output, $is_public ) {
		// Keep the core output (Disallow: /) when search engines are discouraged.
		if ( 1 !== (int) $is_public ) {
			return $output;
		}

		$admin_path = wp_parse_url( admin_url(), PHP_URL_PATH );

		return implode(
			"\n",
			array(
				'User-agent: *',
				'Disallow: ' . $admin_path,
				'Allow: ' . $admin_path . 'admin-ajax.php',
				'',
				'Sitemap: ' . home_url( '/wp-sitemap.xml' ),
			)
		);
	},
	10,
	2
);
