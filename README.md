## Woocommerce auto regenerate product lookup table

This plugin auto regenerates Woocommerce product lookup table which is helpful when product sorting functionality is not
working as expected.

### Description

If you are having trouble with sorting function in products page of Woocommerce, this plugin might help. This sort issue
is seen especially when there is automated script pulling in products to table.

### Features

- Scheduled regeneration of the WooCommerce product lookup table (hourly, twice daily, daily or weekly)
- Scheduled regeneration of the product attributes lookup table used for filtering by attributes
- Optional sync of variable product price ranges and stock status from their variations
- Optional recount of products in categories, tags and brands
- Status panel showing last run, next scheduled run and the state of each task
- "Run now" button to start regeneration immediately

### Requirements

- WordPress 7.0 or later
- WooCommerce
- PHP 7.4 or later

### Installation

1. Upload the plugin files to the `/wp-content/plugins/regenerate-product-lookup-table-for-woocommerce` directory, or install the plugin
   through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to **Settings->Woocommerce regenerate product lookup table** page to configure the plugin

### Note

By default, the plugin adds cron twice a day. If it's not working for you change the duration to lower time (possibly once an
hour).

Variable product price sync re-saves each variable product, which fires WooCommerce product update hooks and webhooks. It
is disabled by default.

See `readme.txt` for the full changelog.
