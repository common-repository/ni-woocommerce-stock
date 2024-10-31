<?php 
/*
Plugin Name: Ni WooCommerce Stock Alert Notification
Description: Boost customer retention with the Ni WooCommerce Stock Alert plugin, ensuring engagement even when your store products are out of stock.
Author: 	 anzia
Version: 	 1.1.3
Author URI:  http://naziinfotech.com/
Plugin URI:  https://wordpress.org/plugins/ni-woocommerce-stock/
License:	 GPLv3 or later
License URI: http://www.gnu.org/licenses/agpl-3.0.html
Requires at least: 4.7
Tested up to: 6.4.2
WC requires at least: 3.0.0
WC tested up to: 8.4.0
Last Updated Date: 17-December-2023
Requires PHP: 7.0

*/
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Stock' ) ) {
	class Ni_WooCommerce_Stock{
		public function __construct(){
			include_once("include/ni-woocommerce-stock-init.php");
			$woocust =  new Ni_WooCommerce_Stock_Init();
		}
		public static function niwoostock_create_table() {
			global $wpdb;
 			$table_name = $wpdb->prefix . 'niwoostock';
			$charset_collate = $wpdb->get_charset_collate();
			if($wpdb->get_var("show tables like '{$table_name}'") != $table_name){
				
				$sql = "";
				$sql .= " CREATE TABLE `".$table_name."` (
				  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
				  `created_date` datetime NOT NULL,
				  `updated_date` datetime NOT NULL,
				  `product_id` bigint(20) NOT NULL,
				  `product_name` varchar(500) NOT NULL,
				  `product_price` double NOT NULL,
				  `email_address` varchar(500) NOT NULL,
				  `first_name` varchar(500) NOT NULL,
				  `last_name` varchar(500) NOT NULL,
				  `contact_no` varchar(100) NOT NULL,
				  `product_notes` varchar(500) NOT NULL,
				  `product_sku` varchar(100) NOT NULL,
				  `customer_id` bigint(20) NOT NULL,
				  PRIMARY KEY (`ID`)
				)  AUTO_INCREMENT=1   {$charset_collate} ;";
				
				
				
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
			} 
			
 		}
	}
	$woocustrep  =  new Ni_WooCommerce_Stock();
	register_activation_hook( __FILE__, array( 'Ni_WooCommerce_Stock', 'niwoostock_create_table' ) );
}
?>