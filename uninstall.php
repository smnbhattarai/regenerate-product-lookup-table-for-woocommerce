<?php

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// No direct access to file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


delete_option( 'smnwcrpl_options' );