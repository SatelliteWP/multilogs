<?php
/**
 * Plugin Name:       Multilogs
 * Description:       Multiple logs for multisite (one per site)
 * Version:           1.0
 * Author:            SatelliteWP
 * Author URI:        https://www.satellitewp.com/
 * Requires PHP:      5.6
 * Requires at least: 5.1
 */

function satellitewp_multilogs() {

	// If debug not activated, stop.
	if ( ! defined( 'WP_DEBUG' ) || WP_DEBUG === false ) return;

	// If debug lof is not actived, stop.
	if ( ! defined( 'WP_DEBUG_LOG' ) || WP_DEBUG_LOG === false ) return;

	// If this is not a multiste, stop.
	if ( ! defined( 'WP_ALLOW_MULTISITE' ) || WP_ALLOW_MULTISITE === false ||
			! defined( 'MULTISITE' ) || MULTISITE === false ) return;

	// Site information
	$site = get_site();

	// Path and file information
	$path = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'multilogs';

	// Create directory (if needed)
	if ( ! file_exists( $path ) ) {
			$ret = wp_mkdir_p( $path );
	}

	// Set debug file name
	$file = 'debug-' . $site->id . '.log';

	// Log file
	$log_file = $path . DIRECTORY_SEPARATOR . $file;

	// Set new temporary constant
	define( 'NEW_WP_DEBUG_LOG', $log_file );

	// Set logging path
	$ini = ini_set( 'error_log', $log_file );

}

satellitewp_multilogs();

// Redefine WP_DEBUG_LOG (PHP 5.6+)
use const NEW_WP_DEBUG_LOG as WP_DEBUG_LOG;
