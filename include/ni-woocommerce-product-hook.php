<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Product_Hook' ) ) {
	class Ni_WooCommerce_Product_Hook{
		public function __construct(){
			add_action( 'woocommerce_product_options_general_product_data',  array(&$this,'ni_add_outofstock_notes') );
			add_action( 'woocommerce_process_product_meta',  array(&$this,'ni_save_outofstock_notes') );
		}
		function ni_add_outofstock_notes(){
			global $woocommerce, $post;
  			echo '<div class="options_group">';
  				woocommerce_wp_textarea_input( 
					array( 
						'id'          => '_ni_outofstock_notes', 
						'label'       => __( 'Out of stock notes', 'woocommerce' ), 
						'placeholder' => '', 
						'description' => __( 'Enter Out of stock notes.', 'woocommerce' ) 
					)
				);
			echo '</div>';
		}
		function ni_save_outofstock_notes($post_id){
		  $ni_outofstock_notes = isset($_POST['_ni_outofstock_notes'])?$_POST['_ni_outofstock_notes']:'';
  		   update_post_meta($post_id, '_ni_outofstock_notes', esc_attr($ni_outofstock_notes));
		}
	}
}