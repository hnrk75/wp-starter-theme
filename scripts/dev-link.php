<?php
/**
 * composer dev:link / dev:unlink — symlink the shared packages to local clones and back.
 * Clones are expected next to the Local site, or in WPST_DEV_DIR.
 *
 * @package WP Starter
 */

$root = dirname( __DIR__ );
$base = getenv( 'WPST_DEV_DIR' ) ? getenv( 'WPST_DEV_DIR' ) : dirname( $root, 3 );
$mode = $argv[1] ?? 'link';

// Package => [ install path, clone folder ].
$packages = array(
	'hnrk75/wp-starter-theme-parent' => array( 'web/app/themes/wp-starter-theme', 'wp-starter-theme-parent' ),
	'hnrk75/wp-security-hardening'   => array( 'web/app/mu-plugins/wp-security-hardening', 'wp-security-hardening' ),
	'hnrk75/hnrk-cookie-consent'     => array( 'web/app/plugins/hnrk-cookie-consent', 'plugins/hnrk-cookie-consent' ),
);

/**
 * Delete a real (non-symlinked) directory recursively.
 *
 * @param string $dir Directory.
 */
function wpst_dev_remove_dir( $dir ) {
	$items = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::CHILD_FIRST
	);
	foreach ( $items as $item ) {
		$item->isDir() && ! $item->isLink() ? rmdir( $item->getPathname() ) : unlink( $item->getPathname() );
	}
	rmdir( $dir );
}

if ( 'unlink' === $mode ) {
	foreach ( $packages as $package => list( $path ) ) {
		$target = "$root/$path";
		if ( is_link( $target ) ) {
			unlink( $target );
			echo "Unlinked $path\n";
		}
	}

	// A missing package folder counts as not installed, so `install` restores it.
	$composer = getenv( 'COMPOSER_BINARY' ) ? getenv( 'COMPOSER_BINARY' ) : 'composer';
	passthru( escapeshellarg( PHP_BINARY ) . ' ' . escapeshellarg( $composer ) . ' install', $code );
	exit( $code );
}

foreach ( $packages as $package => list( $path, $folder ) ) {
	$source = "$base/$folder";
	$target = "$root/$path";

	if ( ! is_dir( "$source/.git" ) ) {
		echo "Skipped $package — no git clone at $source\n";
		continue;
	}

	if ( is_link( $target ) ) {
		echo "Already linked: $path → $source\n";
		continue;
	}

	if ( is_dir( $target ) ) {
		wpst_dev_remove_dir( $target );
	}

	symlink( $source, $target );
	echo "Linked $path → $source\n";
}
