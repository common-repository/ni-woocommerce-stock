<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Stock_Hook' ) ) {
	class Ni_WooCommerce_Stock_Hook{
		public function __construct(){
			add_action( 'woocommerce_product_meta_start',  array(&$this,'woocommerce_after_add_to_cart_button' ));	
		
		}
		function woocommerce_after_add_to_cart_button(){
		 global $product;
		 $product_id = $product->get_id(); 
		 $stock_status =  $product->get_stock_status();
		 $ni_outofstock_notes =  get_post_meta( $product_id,'_ni_outofstock_notes',true);
		 
			//$this->option 	    = get_option("niwoostock_setting"); 
			//echo $outofstock_notes_showhide 	= isset($niwoostock['outofstock_notes_showhide'])?$niwoostock['outofstock_notes_showhide']:'';
			//echo $outofstock_notes_showhide_email 	= isset($niwoostock['outofstock_notes_showhide_email'])?$niwoostock['outofstock_notes_showhide_email']:'';
		 
		 
		 //error_log($stock_status);
		 
		 if ( $stock_status ==="outofstock" ||  $stock_status ==="onbackorder"):
			$html = "";
			//$html.= "<br/><br/>";
			$html.= "<p>";
			$html .= "<div class=\"_ni_stock_message\"></div>";
			
			$html .= "<input type=\"text\" class=\"woocommerce-Input woocommerce-Input--text input-text\" id =\"txtniwoostock_email\"> <input type=\"button\" value=\"Email\" class=\"single_add_to_cart_button button alt\" id=\"niwoostock_email\">";
			
			$html .= "<input type=\"hidden\" id=\"txtniwoostock_product_name\" name=\"txtniwoostock_product_name\" value=". $product->get_title() ." />";
			$html .= "<input type=\"hidden\" id=\"txtniwoostock_product_price\" name=\"txtniwoostock_product_price\" value=". $product->get_price() ." />";
			$html .= "<input type=\"hidden\" id=\"txtniwoostock_product_id\" name=\"txtniwoostock_product_id\" value=". $product->get_id() ." />";
			
			if (strlen($ni_outofstock_notes)>0):
				$html.= "<div class=\"niwoostock_outofstock_notes\">{$ni_outofstock_notes}</div>";
			endif;
			$html.= "</p>";
			echo  $html;
		 endif;
		}	
	}
}
?>