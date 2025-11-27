<?php

// No direct access to file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * @param $input
 *
 * @return mixed
 */
function smnwcrpl_callback_validate_options( $input ) {

	$select_options = [
		'hourly'     => __( 'Hourly', 'regenerate-product-lookup-table-for-woocommerce' ),
		'twicedaily' => __( 'Twice Daily', 'regenerate-product-lookup-table-for-woocommerce' ),
		'daily'      => __( 'Daily', 'regenerate-product-lookup-table-for-woocommerce' ),
		'weekly'     => __( 'Weekly', 'regenerate-product-lookup-table-for-woocommerce' ),
	];

	if ( ! isset( $input['cron_schedule_time'] ) ) {
		$input['cron_schedule_time'] = null;
	}

	if ( ! array_key_exists( $input['cron_schedule_time'], $select_options ) ) {
		$input['cron_schedule_time'] = null;
	}

	return $input;

}