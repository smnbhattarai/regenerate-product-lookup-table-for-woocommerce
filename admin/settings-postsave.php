<?php

// No direct access to file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function smnwcrpl_option_post_save( $old_value, $new_value ) {

	$cron_schedule_time = isset( $new_value['cron_schedule_time'] ) ? sanitize_text_field( $new_value['cron_schedule_time'] ) : '';

	// Keep the existing cron if the new recurrence is not a registered schedule
	if ( ! array_key_exists( $cron_schedule_time, wp_get_schedules() ) ) {
		return;
	}

	smnwcrpl_product_lookup_table_cron_deactivate();

	wp_schedule_event( time(), $cron_schedule_time, 'smnwcrpl_regenerate_product_lookup_table' );

}

add_action( 'update_option_smnwcrpl_options', 'smnwcrpl_option_post_save', 10, 2 );