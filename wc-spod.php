<?php
/**
 * @link              http://www.spreadshop.com/spreadconnect?affiliateID=12890
 * @since             1.0.0
 * @package           wc-spod
 *
 * @wordpress-plugin
 * Plugin Name:       Spreadconnect
 * Plugin URI:        http://www.spreadshop.com/spreadconnect?affiliateID=12890
 * Description:       Connect your WooCommerce Shop to the leading provider of whitelabel print-on-demand services. Get an automatic product, order and order status synchronisation and a seamless integration into your WooCommerce setup ready within minutes.
 * Version:           2.1.5
 * Author:            Spreadconnect
 * Author URI:        http://www.spreadshop.com/spreadconnect?affiliateID=12890
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-spod
 * Domain Path:       /languages
 *
 * WC requires at least: 4.7
 * WC tested up to: 8.2.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
*
* Mark HPOS compatibility
* @since 2.1.2
*/
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * Currently plugin version.
 */
define( 'SPOD_POD_VERSION', '2.1.5' );
define( 'MIN_WORDPRESS_VERSION_REQUIRED', 4.8 );
define( 'MIN_WOOCOMMERCE_VERSION_REQUIRED', 4.7);
define( 'MIN_PHP_VERSION_REQUIRED', 5.6);

/**
 * Temporary table
 */
global $wpdb;
define('SPOD_SHOP_IMPORT_IMAGES', $wpdb->prefix.'spod_shop_import_images');
define('SPOD_SHOP_IMPORT_PRODUCTS', $wpdb->prefix.'spod_shop_import_products');
define('SPOD_SHOP_IMPORT_LOGS', $wpdb->prefix.'spod_shop_import_logs');

/**
 * The code that runs during plugin activation.
 */
function spodpod_activate_spod_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/SpodPodActivator.php';
    SpodPodActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function spodpod_deactivate_spod_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/SpodPodDeactivator.php';
    SpodPodDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'spodpod_activate_spod_plugin' );
register_deactivation_hook( __FILE__, 'spodpod_deactivate_spod_plugin' );

/**
 * plugin update check.
 */
function spodpod_update_spod_plugin() {
    require_once plugin_dir_path( __FILE__ ) . 'classes/SpodPodUpdater.php';
    SpodPodUpdater::update120();
    SpodPodUpdater::update210();
}
add_action('plugins_loaded', 'spodpod_update_spod_plugin');


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'classes/SpodPodPlugin.php';
require plugin_dir_path( __FILE__ ) . 'cron.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function spodpod_run_spod_plugin() {

	$plugin = new SpodPodPlugin();
	$plugin->run();

}
spodpod_run_spod_plugin();
