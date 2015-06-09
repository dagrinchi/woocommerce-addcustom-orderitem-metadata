<?php

/**
 *
 * @link              http://dagrinchi.com
 * @since             1.0.0
 * @package           woocommerce-addcustom-orderitem-metadata
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Add Custom Order Item Metadata
 * Plugin URI:        http://dagrinchi.com/woocommerce-addcustom-orderitem-metadata/
 * Description:       This plugin adds the ability to create new custom metadata to WooCommerce order item like custom codes, dates, status etc.
 * Version:           1.0.0
 * Author:            David Alméciga
 * Author URI:        http://dagrinchi.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-addcustom-orderitem-metadata
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-addcustom-orderitem-metadata-activator.php
 */
function activate_WC_AddCustom_OrderItem_MetaData() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-addcustom-orderitem-metadata-activator.php';
	WC_AddCustom_OrderItem_MetaData_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-addcustom-orderitem-metadata-deactivator.php
 */
function deactivate_WC_AddCustom_OrderItem_MetaData() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-addcustom-orderitem-metadata-deactivator.php';
	WC_AddCustom_OrderItem_MetaData_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_WC_AddCustom_OrderItem_MetaData' );
register_deactivation_hook( __FILE__, 'deactivate_WC_AddCustom_OrderItem_MetaData' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-addcustom-orderitem-metadata.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_WC_AddCustom_OrderItem_MetaData() {

	$plugin = new WC_AddCustom_OrderItem_MetaData();
	$plugin->run();

}
run_WC_AddCustom_OrderItem_MetaData();
