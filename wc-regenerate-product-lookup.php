<?php
/**
 * Woocommerce regenerate product lookup table
 *
 * @package           SmnWcrpl
 * @author            Suman Bhattarai
 * @copyright         2021 Suman Bhattarai
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Regenerate product lookup table for WooCommerce
 * Plugin URI:        http://sumanbhattarai.com.np/woocommerce-auto-regenerate-product-lookup-table/
 * Description:       This plugin auto regenerates Woocommerce product lookup table.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Suman Bhattarai
 * Author URI:        http://sumanbhattarai.com.np
 * Text Domain:       smnwcrpl
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


// No direct access to file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Load text domain
 */
function smnwcrpl_load_textdomain() {
	load_plugin_textdomain( 'smnwcrpl', false, plugin_dir_path( __FILE__ ) . 'languages/' );
}

add_action( 'plugins_loaded', 'smnwcrpl_load_textdomain' );


/**
 * Load files for admin setting area
 */
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-postsave.php';
}


/**
 * Set default options for cron
 * @return string[]
 */
function smnwcrpl_options_default() {
	return [
		'cron_schedule_time' => 'twicedaily',
	];
}


/**
 * Function to run on product activation
 */
function smnwcrpl_register_cron_when_plugin_is_activated() {
	// If cron is not registered, register it
	if ( ! wp_next_scheduled( 'smnwcrpl_regenerate_product_lookup_table' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'smnwcrpl_regenerate_product_lookup_table' );
	}

	// Add default schedule option
	add_option( 'smnwcrpl_options', [ 'cron_schedule_time' => 'twicedaily' ] );
}

add_action( 'smnwcrpl_regenerate_product_lookup_table', 'smnwcrpl_auto_regenerate_woocommerce_product_lookup_table' );


/**
 * Run Woocommerce product lookup table regeneration
 */
function smnwcrpl_auto_regenerate_woocommerce_product_lookup_table() {
	if ( function_exists( 'wc_update_product_lookup_tables' ) && function_exists( 'wc_update_product_lookup_tables_is_running' ) ) {
		if ( ! wc_update_product_lookup_tables_is_running() ) {
			wc_update_product_lookup_tables();
		}
	}
}


/**
 * Register cron when plugin is activated
 */
register_activation_hook( __FILE__, 'smnwcrpl_register_cron_when_plugin_is_activated' );


/**
 * WHEN PLUGIN IS DEACTIVATED
 * Cleanup
 */

/**
 * Register deactivation hook
 */
register_deactivation_hook( __FILE__, 'smnwcrpl_product_lookup_table_cron_deactivate' );


/**
 * Perform deactivation actions
 */
function smnwcrpl_product_lookup_table_cron_deactivate() {
	$timestamp = wp_next_scheduled( 'smnwcrpl_regenerate_product_lookup_table' );
	wp_unschedule_event( $timestamp, 'smnwcrpl_regenerate_product_lookup_table' );
}