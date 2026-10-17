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

	add_settings_section( 'smnwcrpl_section_tasks', __( 'Additional Tasks', 'regenerate-product-lookup-table-for-woocommerce' ),
		'smnwcrpl_callback_section_tasks', 'smnwcrpl' );

	add_settings_field( 'sync_variable_prices', __( 'Variable product prices', 'regenerate-product-lookup-table-for-woocommerce' ), 'smnwcrpl_callback_field_checkbox',
		'smnwcrpl', 'smnwcrpl_section_tasks', [
			'id'    => 'sync_variable_prices',
			'label' => esc_html__( 'Sync price range and stock status of variable products from their variations. Runs in the background in batches of 50. Each product is re-saved, which fires product update hooks and webhooks.',
					'regenerate-product-lookup-table-for-woocommerce' )
		] );

	add_settings_field( 'recount_terms', __( 'Term counts', 'regenerate-product-lookup-table-for-woocommerce' ), 'smnwcrpl_callback_field_checkbox',
		'smnwcrpl', 'smnwcrpl_section_tasks', [
			'id'    => 'recount_terms',
			'label' => esc_html__( 'Recount products in categories, tags and brands.',
					'regenerate-product-lookup-table-for-woocommerce' )
		] );

}

add_action( 'admin_init', 'smnwcrpl_register_settings' );