<?php
/**
 * Configuration overrides for WP_ENV === 'staging'
 */

use Roots\WPConfig\Config;

/**
 * Keep staging as close to production as possible.
 * Errors are logged to file but never displayed in the browser.
 */

// Prevent search engines from indexing staging.
Config::define('DISALLOW_INDEXING', true);

// Log errors to file — useful for debugging without exposing them to visitors.
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_LOG', true);
Config::define('WP_DEBUG_DISPLAY', false);
ini_set('display_errors', '0');
