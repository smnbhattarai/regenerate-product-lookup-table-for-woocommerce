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

	if ( ! is_array( $input ) ) {
		$input = [];
	}

	// Fall back to the saved value (or the default) so an invalid submission never clears the schedule
	if ( ! isset( $input['cron_schedule_time'] ) || ! array_key_exists( $input['cron_schedule_time'], $select_options ) ) {
		$options  = get_option( 'smnwcrpl_options', smnwcrpl_options_default() );
		$previous = isset( $options['cron_schedule_time'] ) ? $options['cron_schedule_time'] : null;

		$input['cron_schedule_time'] = array_key_exists( $previous, $select_options )
			? $previous
			: smnwcrpl_options_default()['cron_schedule_time'];

		add_settings_error( 'smnwcrpl_options', 'smnwcrpl_invalid_schedule',
			__( 'Invalid cron time selected. The previous value has been kept.', 'regenerate-product-lookup-table-for-woocommerce' ) );
	}

	return $input;

}