<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WC_AddCustom_OrderItem_MetaData
 * @subpackage WC_AddCustom_OrderItem_MetaData/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WC_AddCustom_OrderItem_MetaData
 * @subpackage WC_AddCustom_OrderItem_MetaData/includes
 * @author     Your Name <email@example.com>
 */
class WC_AddCustom_OrderItem_MetaData_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$role = get_role('shop_manager');
		$role->add_cap('redeem_codes');
	}

}
