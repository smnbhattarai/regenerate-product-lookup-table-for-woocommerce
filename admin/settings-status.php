<?php

// No direct access to file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Format a timestamp in site date/time format with relative time
 *
 * @param int $timestamp
 *
 * @return string
 */
function smnwcrpl_format_status_time( $timestamp ) {
	$date = wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp );

	if ( $timestamp > time() ) {
		/* translators: %s: Human readable time span */
		$relative = sprintf( __( 'in %s', 'regenerate-product-lookup-table-for-woocommerce' ), human_time_diff( $timestamp ) );
	} else {
		/* translators: %s: Human readable time span */
		$relative = sprintf( __( '%s ago', 'regenerate-product-lookup-table-for-woocommerce' ), human_time_diff( $timestamp ) );
	}

	return $date . ' (' . $relative . ')';
}


/**
 * Get product lookup table regeneration status
 *
 * @return string
 */
function smnwcrpl_get_product_lookup_status() {
	if ( ! function_exists( 'wc_update_product_lookup_tables_is_running' ) ) {
		return __( 'Unavailable', 'regenerate-product-lookup-table-for-woocommerce' );
	}

	return wc_update_product_lookup_tables_is_running()
		? __( 'Regenerating in background', 'regenerate-product-lookup-table-for-woocommerce' )
		: __( 'Idle', 'regenerate-product-lookup-table-for-woocommerce' );
}


/**
 * Get attribute lookup table regeneration status
 *
 * @return string
 */
function smnwcrpl_get_attribute_lookup_status() {
	if ( ! function_exists( 'wc_get_container' )
		|| ! class_exists( '\Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore' ) ) {
		return __( 'Unavailable', 'regenerate-product-lookup-table-for-woocommerce' );
	}

	$data_store = wc_get_container()->get( \Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore::class );

	if ( ! $data_store->check_lookup_table_exists() ) {
		return __( 'Table does not exist', 'regenerate-product-lookup-table-for-woocommerce' );
	}

	if ( $data_store->regeneration_is_in_progress() ) {
		return __( 'Regenerating in background', 'regenerate-product-lookup-table-for-woocommerce' );
	}

	if ( 'yes' !== get_option( 'woocommerce_attribute_lookup_enabled' ) ) {
		return __( 'Skipped (table usage disabled in WooCommerce settings)', 'regenerate-product-lookup-table-for-woocommerce' );
	}

	return __( 'Idle', 'regenerate-product-lookup-table-for-woocommerce' );
}


/**
 * Get variable product price sync status
 *
 * @return string
 */
function smnwcrpl_get_variable_price_sync_status() {
	if ( 'yes' !== smnwcrpl_get_options()['sync_variable_prices'] ) {
		return __( 'Disabled', 'regenerate-product-lookup-table-for-woocommerce' );
	}

	return smnwcrpl_variable_price_sync_is_running()
		? __( 'Syncing in background', 'regenerate-product-lookup-table-for-woocommerce' )
		: __( 'Idle', 'regenerate-product-lookup-table-for-woocommerce' );
}


/**
 * Get term recount status
 *
 * @return string
 */
function smnwcrpl_get_term_recount_status() {
	return 'yes' === smnwcrpl_get_options()['recount_terms']
		? __( 'Recounted on each run', 'regenerate-product-lookup-table-for-woocommerce' )
		: __( 'Disabled', 'regenerate-product-lookup-table-for-woocommerce' );
}


/**
 * Display status panel and run now button
 */
function smnwcrpl_display_status_section() {
	$last_run = (int) get_option( 'smnwcrpl_last_run', 0 );
	$next_run = wp_next_scheduled( 'smnwcrpl_regenerate_product_lookup_table' );

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display only
	if ( isset( $_GET['smnwcrpl_ran'] ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' .
			esc_html__( 'Regeneration has been started. It continues in the background.', 'regenerate-product-lookup-table-for-woocommerce' ) .
			'</p></div>';
	}

	?>

    <h2><?php esc_html_e( 'Status', 'regenerate-product-lookup-table-for-woocommerce' ); ?></h2>

    <table class="form-table" role="presentation">
        <tr>
            <th scope="row"><?php esc_html_e( 'Last run', 'regenerate-product-lookup-table-for-woocommerce' ); ?></th>
            <td><?php echo esc_html( $last_run ? smnwcrpl_format_status_time( $last_run ) : __( 'Never', 'regenerate-product-lookup-table-for-woocommerce' ) ); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Next scheduled run', 'regenerate-product-lookup-table-for-woocommerce' ); ?></th>
            <td><?php echo esc_html( $next_run ? smnwcrpl_format_status_time( $next_run ) : __( 'Not scheduled', 'regenerate-product-lookup-table-for-woocommerce' ) ); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Product lookup table', 'regenerate-product-lookup-table-for-woocommerce' ); ?></th>
            <td><?php echo esc_html( smnwcrpl_get_product_lookup_status() ); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Attribute lookup table', 'regenerate-product-lookup-table-for-woocommerce' ); ?></th>
            <td><?php echo esc_html( smnwcrpl_get_attribute_lookup_status() ); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Variable product prices', 'regenerate-product-lookup-table-for-woocommerce' ); ?></th>
            <td><?php echo esc_html( smnwcrpl_get_variable_price_sync_status() ); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Term counts', 'regenerate-product-lookup-table-for-woocommerce' ); ?></th>
            <td><?php echo esc_html( smnwcrpl_get_term_recount_status() ); ?></td>
        </tr>
    </table>

    <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="smnwcrpl_run_now">
		<?php
		wp_nonce_field( 'smnwcrpl_run_now' );
		submit_button( __( 'Run now', 'regenerate-product-lookup-table-for-woocommerce' ), 'secondary', 'smnwcrpl_run_now_submit', false );
		?>
        <p class="description"><?php esc_html_e( 'Starts regeneration and enabled additional tasks immediately. Anything already running is skipped.', 'regenerate-product-lookup-table-for-woocommerce' ); ?></p>
    </form>

	<?php
}


/**
 * Handle run now request
 */
function smnwcrpl_handle_run_now() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do this.', 'regenerate-product-lookup-table-for-woocommerce' ), 403 );
	}

	check_admin_referer( 'smnwcrpl_run_now' );

	smnwcrpl_auto_regenerate_woocommerce_product_lookup_table();

	wp_safe_redirect( add_query_arg( 'smnwcrpl_ran', '1', admin_url( 'options-general.php?page=smnwcrpl' ) ) );
	exit;
}

add_action( 'admin_post_smnwcrpl_run_now', 'smnwcrpl_handle_run_now' );
