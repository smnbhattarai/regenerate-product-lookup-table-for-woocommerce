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
		'hourly'     => 'Hourly',
		'twicedaily' => 'Twice Daily',
		'daily'      => 'Daily',
		'weekly'     => 'Weekly',
	];

	if ( ! isset( $input['cron_schedule_time'] ) ) {
		$input['cron_schedule_time'] = null;
	}

	if ( ! array_key_exists( $input['cron_schedule_time'], $select_options ) ) {
		$input['cron_schedule_time'] = null;
	}

	return $input;

}