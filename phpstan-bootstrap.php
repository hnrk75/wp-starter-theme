<?php

/**
 * PHPStan bootstrap – definierar WordPress-konstanter utan att starta WordPress.
 * Krävs av szepeviktor/phpstan-wordpress för korrekt typanalys.
 */

defined('ABSPATH') || define('ABSPATH', __DIR__ . '/web/wp/');
defined('WPINC') || define('WPINC', 'wp-includes');
defined('WP_CONTENT_DIR') || define('WP_CONTENT_DIR', __DIR__ . '/web/app');
defined('WP_PLUGIN_DIR') || define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
defined('WPMU_PLUGIN_DIR') || define('WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins');
defined('WP_CONTENT_URL') || define('WP_CONTENT_URL', 'https://example.com/app');
defined('WP_PLUGIN_URL') || define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');
defined('WP_SITEURL') || define('WP_SITEURL', 'https://example.com');
defined('WP_HOME') || define('WP_HOME', 'https://example.com');
defined('DB_NAME') || define('DB_NAME', 'phpstan');
defined('DB_USER') || define('DB_USER', 'phpstan');
defined('DB_PASSWORD') || define('DB_PASSWORD', 'phpstan');
defined('DB_HOST') || define('DB_HOST', 'localhost');
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');
defined('DB_COLLATE') || define('DB_COLLATE', '');
defined('AUTH_KEY') || define('AUTH_KEY', 'phpstan');
defined('SECURE_AUTH_KEY') || define('SECURE_AUTH_KEY', 'phpstan');
defined('LOGGED_IN_KEY') || define('LOGGED_IN_KEY', 'phpstan');
defined('NONCE_KEY') || define('NONCE_KEY', 'phpstan');
defined('AUTH_SALT') || define('AUTH_SALT', 'phpstan');
defined('SECURE_AUTH_SALT') || define('SECURE_AUTH_SALT', 'phpstan');
defined('LOGGED_IN_SALT') || define('LOGGED_IN_SALT', 'phpstan');
defined('NONCE_SALT') || define('NONCE_SALT', 'phpstan');
defined('WP_DEBUG') || define('WP_DEBUG', false);
defined('SCRIPT_DEBUG') || define('SCRIPT_DEBUG', false);
defined('CONCATENATE_SCRIPTS') || define('CONCATENATE_SCRIPTS', true);
defined('COMPRESS_SCRIPTS') || define('COMPRESS_SCRIPTS', true);
defined('COMPRESS_CSS') || define('COMPRESS_CSS', true);

/**
 * WordPress nav menu items are WP_Post objects with extra properties added
 * dynamically by wp_setup_nav_menu_item(). WP_Nav_Menu_Item does not exist
 * as a declared class in WordPress, so we declare it here for PHPStan.
 */
if ( ! class_exists( 'WP_Nav_Menu_Item' ) ) {
	class WP_Nav_Menu_Item {
		public int $ID                     = 0;
		public string $title               = '';
		/** @var string[] */
		public array $classes              = [];
		public string $attr_title          = '';
		public string $target              = '';
		public string $xfn                 = '';
		public string $url                 = '';
		public bool $current               = false;
		public bool $current_item_ancestor = false;
		public bool $current_item_parent   = false;
		public int $db_id                  = 0;
		public int $menu_item_parent       = 0;
		public string $object              = '';
		public int $object_id              = 0;
		public string $type                = '';
		public string $type_label          = '';
		public string $description         = '';
	}
}
