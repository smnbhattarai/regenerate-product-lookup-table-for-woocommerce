<?php

// No direct access to file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function smnwcrpl_register_settings() {

	register_setting(
		'smnwcrpl_options',
		'smnwcrpl_options',
		'smnwcrpl_callback_validate_options'
	);

	add_settings_section( 'smnwcrpl_section_admin', __( 'Change Cron Duration', 'regenerate-product-lookup-table-for-woocommerce' ),
		'smnwcrpl_callback_section_admin', 'smnwcrpl' );

	add_settings_field( 'cron_schedule_time', __( 'Cron time', 'regenerate-product-lookup-table-for-woocommerce' ), 'smnwcrpl_callback_field_select',
		'smnwcrpl', 'smnwcrpl_section_admin', [
			'id'    => 'cron_schedule_time',
			'label' => esc_html__( 'Cron repeat time. Set this option to lower time if current cron run time is not working properly.',
					'regenerate-product-lookup-table-for-woocommerce' )
		] );

}

add_action( 'admin_init', 'smnwcrpl_register_settings' );