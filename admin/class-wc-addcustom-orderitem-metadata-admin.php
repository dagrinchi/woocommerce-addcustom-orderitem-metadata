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
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WC_AddCustom_OrderItem_MetaData_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WC_AddCustom_OrderItem_MetaData_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->WC_AddCustom_OrderItem_MetaData, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WC_AddCustom_OrderItem_MetaData_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WC_AddCustom_OrderItem_MetaData_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->WC_AddCustom_OrderItem_MetaData, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

}
