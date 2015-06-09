<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WC_AddCustom_OrderItem_MetaData
 * @subpackage WC_AddCustom_OrderItem_MetaData/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WC_AddCustom_OrderItem_MetaData
 * @subpackage WC_AddCustom_OrderItem_MetaData/admin
 * @author     Your Name <email@example.com>
 */

class WC_AddCustom_OrderItem_MetaData_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WC_AddCustom_OrderItem_MetaData    The ID of this plugin.
	 */
	private $WC_AddCustom_OrderItem_MetaData;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $order_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $WC_AddCustom_OrderItem_MetaData       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $WC_AddCustom_OrderItem_MetaData, $version ) {

		$this->WC_AddCustom_OrderItem_MetaData = $WC_AddCustom_OrderItem_MetaData;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * The WC_AddCustom_OrderItem_MetaData_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->WC_AddCustom_OrderItem_MetaData, plugin_dir_url( __FILE__ ) . 'css/wc-addcustom-orderitem-metadata-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * The WC_AddCustom_OrderItem_MetaData_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->WC_AddCustom_OrderItem_MetaData, plugin_dir_url( __FILE__ ) . 'js/wc-addcustom-orderitem-metadata-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function new_order($order_id) {
		$this->order_id = $order_id;
	}

	public function add_order_item_meta($item_id, $values, $cart_item_key) {
		$now = new \DateTime("now");
		$order = wc_get_order($this->order_id);
		wc_add_order_item_meta($item_id, "Ref", $item_id, false);

		for ($i=1; $i <= $values["quantity"]; $i++) {
			$passe = "_ref_" . $item_id . "_" . $i;
			$passe_meta = [$passe => strtoupper(uniqid()), $passe . "_datetime" => $now->format('Y-m-d H:i:s'), $passe . "_is_active" => 1];
			foreach ($passe_meta as $key => $value) {
				wc_add_order_item_meta($item_id, $key, $value);
			}

			$order->add_order_note("Se activó el código " . $passe_meta[$passe . "_code"] . " para la Ref: " . $item_id . "_" . $i);
		}
	}

	public function hidden_order_itemmeta($args) {
		return $args;
	}

}
