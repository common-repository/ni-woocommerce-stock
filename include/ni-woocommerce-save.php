<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Stock_Save' ) ) {
	class Ni_WooCommerce_Stock_Save{
		public function __construct(){
		}
		function niwoostock_save_email(){
			//echo json_encode($_REQUEST);
			global $wpdb;
			$table_name = $wpdb->prefix . "niwoostock";
			$data  = array();
			$message = array();
			$message["status"] = "0";
			$message["message"] = "record not saved";
			
			$niwoostock_email		    = isset($_REQUEST["niwoostock_email"])?$_REQUEST["niwoostock_email"] :"";
			$niwoostock_product_name    = isset($_REQUEST["niwoostock_product_name"])?$_REQUEST["niwoostock_product_name"]:"";
			$niwoostock_product_price   = isset($_REQUEST["niwoostock_product_price"])?$_REQUEST["niwoostock_product_price"]:0;
			$niwoostock_product_id 		= isset($_REQUEST["niwoostock_product_id"])?$_REQUEST["niwoostock_product_id"]:0;
			
			$data["created_date"] 	= date_i18n("Y-m-d H:i:s");
			$data["updated_date"] 	= date_i18n("Y-m-d H:i:s");
			$data["product_id"] 	= $niwoostock_product_id ;
			$data["product_name"] 	= $niwoostock_product_name;
			$data["product_price"] 	= $niwoostock_product_price ;
			$data["email_address"] 	= $niwoostock_email;
			$data["first_name"] 	= "";
			$data["first_name"] 	= "";
			$data["last_name"] 		= "";
			$data["contact_no"]		= "";
			$data["product_notes"]  = "";
			$data["product_sku"]  	= "";
			$data["customer_id"]    = 0;
			
			$row = $wpdb->insert($table_name,$data);
			$lastid = $wpdb->insert_id;
			if ($lastid>0){
				$message["status"] = "1";
				$message["message"] = "record saved";
				
			}
			$email_status = $this->niwoostock_send_email();
			
			echo json_encode(array_merge($email_status,$message));
 			wp_die();	
		}
		function niwoostock_send_email(){
			$data 			    = array();
			$this->option 	    = get_option("niwoostock_setting"); 
			$niwoostock 		= isset($this->option["niwoostock_setting"])?$this->option["niwoostock_setting"]:array();
			$from_email_name 	= isset($niwoostock['niwoostock_from_email_name'])?$niwoostock['niwoostock_from_email_name']:'';
			$from_email 		= isset($niwoostock['niwoostock_from_email'])?$niwoostock['niwoostock_from_email']:'';
			$to_email 			= isset($niwoostock['niwoostock_to_email'])?$niwoostock['niwoostock_to_email']:'';
			$subject_line 		= isset($niwoostock['niwoostock_subject_line'])?$niwoostock['niwoostock_subject_line']:'';
			$thank_you_message 	= isset($niwoostock['niwoostock_thank_you_message'])?$niwoostock['niwoostock_thank_you_message']:'';
		
			if ($thank_you_message ==""){
				$thank_you_message = "Thank you message for contact with us.";
			}
			if ($subject_line ==""){
				$subject_line = "Out of stock products.";
			} 
			
			/*Product Deatils*/
			$niwoostock_email		    = isset($_REQUEST["niwoostock_email"])?$_REQUEST["niwoostock_email"] :"";
			$niwoostock_product_name    = isset($_REQUEST["niwoostock_product_name"])?$_REQUEST["niwoostock_product_name"]:"";
			$niwoostock_product_price   = isset($_REQUEST["niwoostock_product_price"])?$_REQUEST["niwoostock_product_price"]:0;
			$niwoostock_product_id 		= isset($_REQUEST["niwoostock_product_id"])?$_REQUEST["niwoostock_product_id"]:0;
			/*End Product details*/
			
			$html ="";
			$html .= "<div style=\"overflow-x:auto;\">";
			$html  .="<table style=\"width:75%; border:1px solid #00838f; border-collapse: collapse; margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\">";
			
			$html .= "		<tr>";
		 $html .= "			<td colspan=\"2\"  style=\"background:#0097A7;color:#FFFFFF; height:150; padding:15px;font-size:18;font-weight:bold\" >Customer Information</td>";
		 $html .= "		</tr>";
			
			$html  .="<tr>";
			$html  .="<td style=\"padding:10px;border-bottom: 1px solid #00838f; width:200px\" >Customer Email Address</td>";
			$html  .="<td  style=\"padding:10px;border-bottom: 1px solid #00838f;\">{$niwoostock_email}</td>";
			$html  .="</tr>";
			
			$html .= "		<tr>";
		    $html .= "			<td colspan=\"2\" style=\"background:#0097A7;color:#FFFFFF; height:150; padding:15px;font-size:18;font-weight:bold\">Product Information</td>";
		    $html .= "		</tr>";
			
			
			$html  .="<tr>";
			$html  .="<td  style=\"padding:10px;border-bottom: 1px solid #00838f; width:200px\">Product Name</td>";
			$html  .="<td style=\"padding:10px;border-bottom: 1px solid #00838f;\">{$niwoostock_product_name}</td>";
			$html  .="</tr>";
			
			$html  .="<tr>";
			$html  .="<td style=\"padding:10px;border-bottom: 1px solid #00838f;\">Product Price</td>";
			$html  .="<td style=\"padding:10px;border-bottom: 1px solid #00838f;\">{$niwoostock_product_price}</td>";
			$html  .="</tr>";
			$html .= "</div>";
		
			
			//$html  ="Hello Body";
			 
			if ($subject_line ==""){
				$thank_you_message = "Thank you message for contact with us.";
			} 
			$subject_line = $subject_line ." ".  date_i18n("Y-m-d H:i:s");
			
			$headers =  array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			if ($from_email_name ==""){
				$from_email_name = "";
			}
			if ($from_email)
			$headers[] = 'From: '.$from_email_name.' <' .$from_email. '>';
			
			
			 $status = wp_mail($to_email, $subject_line, $html, $headers);
			 if ($status){
				 $status = "1";
			 }else{
				$status = "0";
			 }
			 $data["email_status"] = $status ;
			 $data["thank_you_message"] = $thank_you_message  ;
			 
			 return $data; 
			
		}	
	}
}
?>