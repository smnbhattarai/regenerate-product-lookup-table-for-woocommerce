=== Regenerate product lookup table for WooCommerce ===
Contributors: metalfreek
Donate link: https://www.buymeacoffee.com/smnbhattarai/
Tags: woo, woocommerce
Requires at least: 7.0
Tested up to: 7.0
Requires PHP: 7.4
Requires Plugins: woocommerce
Stable tag: 1.0.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin auto regenerates Woocommerce product lookup table which is helpful when product sorting functionality is
not working as expected.

== Description ==

If you are using WooCommerce for your store and having trouble with sorting function in products page of Woocommerce, this plugin might help. This sort issue is seen especially when there is automated script pulling in products to the store or when using external price sync tool. This plugin adds cron to regenerate product lookup table which WooCommerce uses to quickly sort your products.

**Features**

* Scheduled regeneration of the WooCommerce product lookup table (hourly, twice daily, daily or weekly)
* Scheduled regeneration of the product attributes lookup table used for filtering by attributes
* Optional sync of variable product price ranges and stock status from their variations
* Optional recount of products in categories, tags and brands
* Status panel showing last run, next scheduled run and the state of each task
* "Run now" button to start regeneration immediately

All heavy work continues in the background using WooCommerce's Action Scheduler.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/regenerate-product-lookup-table-for-woocommerce` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to **Settings->Woocommerce regenerate product lookup table** page to configure the plugin


== Frequently Asked Questions ==

= What is the default cron run duration =

By default, plugin adds cron twice a day. If it's not working for you change the duration to lower time (possibly once an hour). On large stores, frequent regeneration adds background load, so use the longest duration that keeps sorting correct.

= Can I run regeneration without waiting for the cron? =

Yes. Use the **Run now** button on the plugin settings page. Regeneration starts immediately and continues in the background. Anything already running is skipped.

= Why is the attribute lookup table shown as skipped? =

The attribute lookup table is only regenerated when it is enabled in **WooCommerce->Settings->Products->Advanced**. The plugin leaves it alone when it is disabled, so your setting is not changed.

= Does variable product price sync trigger webhooks? =

Yes. Each variable product is re-saved during the sync, which fires WooCommerce product update hooks and webhooks. This option is disabled by default; enable it only if variable product prices are updated outside WooCommerce.

== Screenshots ==

1. Regenerate product lookup table for WooCommerce plugin option

== Changelog ==

= 1.0.7 =
**New features**

* Added status panel on the settings page showing last run, next scheduled run and the state of each task
* Added "Run now" button to start regeneration immediately
* Added optional variable product price and stock status sync, processed in background batches of 50
* Added optional recount of products in categories, tags and brands

**Fixes**

* Fixed attribute lookup table regeneration bug added in 1.0.6. It now uses WooCommerce's attribute lookup regenerator and only runs when the table is enabled in WooCommerce settings
* Fixed an invalid cron time setting removing the scheduled cron
* Scheduled cron is now restored automatically when it is missing or does not match the saved setting
* Saving settings no longer resets the cron timer unless the cron time changed
* Raised minimum WordPress version to 7.0 to match WooCommerce

= 1.0.6 =
* Added attribute lookup table regeneration action
* Compatibility check for WordPress and Woocommerce

= 1.0.5 =
* Compatibility check for WordPress and Woocommerce

= 1.0.4 =
* Compatibility check for WordPress and Woocommerce

= 1.0.3 =
* Compatibility check for WordPress and Woocommerce

= 1.0.2 =
* Compatibility check
* Donate link added

= 1.0.1 =
* Minor fixes
* Tested with WordPress 5.8
* Made plugin translation ready

= 1.0.0 =
* First Release date: January 31, 2021

== Upgrade Notice ==

= 1.0.7 =
Fixes attribute lookup table regeneration and adds a status panel, Run now button, variable product price sync and term recount. Requires WordPress 7.0 or later.
