<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Product_Stock' ) ) {
	include_once("ni-woostock-function.php");
	class Ni_WooCommerce_Product_Stock extends Ni_WooStock_Function {
		var $per_page = 10;
		public function __construct(){
		}
		function ni_page_init(){
		//$this->prettyPrint($this->get_product_list());
		$start_date = $this->get_request("start_date",date_i18n("Y-m-d"));
		$end_date = $this->get_request("end_date",date_i18n("Y-m-d"));
		//$input_type = "text";
		$input_type = "hidden";		
		?>
        <div class="niwoostock_container">
            <div class="niwoostock_content">
                <div class="niwoostock_search_form">
                         <form id="frm_niwoostock_search" name="frm_niwoostock_search" method="post">
                        <div class="niwoostock_search_title">product register email</div>
                    <div class="niwoostock_search_row">
                        <div  class="niwoostock_field_wrapper">
                        
                            <label for="start_date">Product Name:</label>
                            <?php $data = $this->get_product_list(); ?>
                            <select name="product_id[]" id="product_id" multiple="multiple">
                            <option value="-1">--Select ALL--</option>
							<?php foreach($data as  $key=>$value):?>
                            	<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php endforeach; ?>
                            </select>
                        </div>
                        <div  class="niwoostock_field_wrapper">
                            <label for="stock_status">Stock Status</label>
                           <select id="stock_status" name="stock_status" class="">
                                    <option value="-1" selected="selected">--Select One--</option>
                                    <option value="instock">In Stock</option>
                                    <option value="outofstock">Out Of Stock</option>
                                    
                                </select>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    
                    <div style="clear:both"></div>
                    <div  class="niwoostock_search_row">
                        <div style="padding:5px; padding-right:23px;">
                            <input type="submit" value="Search" class="niwoostock_button" />
                            <div style="clear:both"></div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                        <input type="<?php echo $input_type; ?>" name="per_page" value="<?php echo $this->per_page; ?>" />
                        <input type="<?php echo $input_type; ?>" name="p" value="0" />
                        <input type="<?php echo $input_type; ?>" name="page" value="<?php echo $_REQUEST["page"]; ?>" />
                        <input type="<?php echo $input_type; ?>" name="action" value="ajax_niwoostock_action" />
                        <input type="<?php echo $input_type; ?>" name="sub_action" value="niwoostock-product-stock" />
                    </form>
                </div>
            </div>
            
        <div class="_niwoostock_ajax_response"></div>  	  
    	</div>
        <?php		 
		}
		function niwoostock_ajax(){
			$this->get_niwoostock_table();
			wp_die();
		}
		function get_niwoostock_table(){
			//echo json_encode($_REQUEST);
		   $count 		 = $this->niwoostock_query("count");
			$row 		 = $this->niwoostock_query();
		    $columns  	 =  $this->get_niwoostock_columns();
			$per_page    = $this->get_request("per_page",10,true);
			$p   		 = $this->get_request("p");
			?>
            <table class="niwoostock_default_table">
            	<thead>
				<?php foreach($columns as $key=>$value): ?>
                		<?php
						switch ($key) {
							case "order_total":
							?>
                             <th><?php echo $value; ?></th>
                            <?php
							break;
							default:
							?>
                            <th><?php echo $value; ?></th>
                            <?php
						}
						?>
					
				<?php endforeach; ?>
					</thead>
                <tbody>
                	<?php if (count($row)>0):?>
                    	<?php foreach ($row as $cogrk => $cogrv): ?>
                        	<tr>
                            	<?php foreach ($columns as $cogck => $cogcv): ?>
                            		<?php 
										switch ($cogck):
											case "stock":
												$cog_value  = isset ($cogrv->$cogck)?$cogrv->$cogck:"0";
												?>
												<td class="wooreport_text_align_right"><?php echo $cog_value; ?></td>
												<?php
												break;
											case "notification_email":
												$cog_value = $this->get_register_email($cogrv->ID);
												//$cog_value  = isset ($cogrv->$cogck)?$cogrv->$cogck:"";
												?>
												<td class="wooreport_text_align_right"><?php echo $cog_value; ?></td>
												<?php
												break;			
											default:
												$cog_value  = isset ($cogrv->$cogck)?$cogrv->$cogck:"";
												?>
												<td><?php echo $cog_value; ?></td>
												<?php
										endswitch;
									 ?>
								<?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                     <?php else:  ?>
                     <tr>
                    	<td  colspan="<?php echo count($columns)  ?>">no record found</td>
                    </tr> 
                     <?php endif; ?>
                </tbody>
            </table>
            <form id="frm_niwoostock_pagination" method="post">
               <?php   $this->get_all_request($_REQUEST); ?>
            </form>
            <?php
			//echo  $this->niwoostock_pagination($count,1);
			echo  $this->niwoostock_pagination($count , $per_page,$p,$url='?');
		}
		function niwoostock_query($type = "row"){
			$parent_product = $this->get_parent_product();
			global $wpdb;
			$start = 0;
			$per_page   			= $this->get_request("per_page",10,true);
			$p   					= $this->get_request("p");
			$product_id 			=  $this->get_request("product_id","-1");
			 
			$stock_status 			=  $this->get_request("stock_status","-1");
			if($p > 1){	$start = ($p - 1) * $per_page;}
			
			$query ="";
			$query .="SELECT ";
			$query .=" * ";
			$query .=" FROM {$wpdb->prefix}posts as posts ";
			
			if ($stock_status !="-1"){
				$query .=" LEFT JOIN {$wpdb->prefix}postmeta as stock_status ON stock_status.post_id=posts.ID ";
			}
			
			$query .=" WHERE 1=1 ";
			$query .=" AND posts.post_type IN ('product','product_variation')";
			if (count($parent_product)>0)
			$query .=" AND posts.ID NOT IN (". implode (", ", $parent_product) .")";
			
			if ($product_id!="" && $product_id!="-1"){
				$query .=" AND posts.ID  IN ({$product_id})";
			}
			if ($stock_status !="-1"){
				$query .=" AND stock_status.meta_key='_stock_status'";
				$query .=" AND stock_status.meta_value='{$stock_status}'";
			}
			
			$query .=" AND posts.post_status IN ('publish') ";	
			$query .=" ORDER BY posts.post_title ";
			
		
			
			//$row = $wpdb->get_results( $query);	
			
			if ($type=="count"){
				$row = $wpdb->get_results( $query);
				$row = count($row);			
			}
			elseif($type=="export"){
				$row = $wpdb->get_results( $query);		
			}else{
				$query .= " LIMIT {$start} , {$per_page} ";
				$row = $wpdb->get_results( $query);			
			}
			
			
			if ($type=="row"){
				foreach($row as $key=>$value){
					$product_post_meta = $this->get_product_post_meta($value->ID);
					foreach($product_post_meta as $pkey=>$pvalue){
						$row[$key]->$pkey = $pvalue;
					}
				}
			}
			
			
			//$this->prettyPrint( $row);		
			return $row;
		}
		function get_product_post_meta($order_id){
			$order_detail	= get_post_meta($order_id);
			$order_detail_array = array();
			foreach($order_detail as $k => $v){
				$k =substr($k,1);
				$order_detail_array[$k] =$v[0];
			}
			return 	$order_detail_array;
		}
		function get_parent_product(){
			global $wpdb;
			$query ="";
			$query .="SELECT ";
			$query .=" posts.post_parent as post_parent ";
			$query .=" FROM {$wpdb->prefix}posts as posts ";
			$query .=" WHERE 1=1 ";
			$query .=" AND posts.post_type IN ('product_variation')";
			$query .=" GROUP BY post_parent ";
			$row = $wpdb->get_results( $query);	
			
			$new_parent_id = array();
			foreach($row as $key=>$value){
				$new_parent_id[] =$value->post_parent ;
			}
			
			return $new_parent_id;
		}
		function get_niwoostock_columns(){
			$columns = array();
			$columns["post_title"] 		= __("Product Name","niwoostock");
			$columns["sku"] 			= __("SKU","niwoostock");
			$columns["stock_status"] 	= __("Stock Status","niwoostock");
			$columns["stock"] 			= __("Stock Quantity","niwoostock");
			$columns["manage_stock"] 	= __("Manage Stock","niwoostock");
			$columns["regular_price"] 	= __("Regular Price","niwoostock");
			$columns["notification_email"] 	= __("Notification Email","niwoostock");
			
			//regular_price
			return $columns;
		}
		function get_register_email($product_id = 0){
			global $wpdb;
			$table_name = $wpdb->prefix . "niwoostock";
			
			$query = "SELECT COUNT(*) FROM " .$table_name;
			$query .= " WHERE 1 = 1 ";
			$query .= " AND product_id ='{$product_id}'";
			
			$row = $wpdb->get_var( $query);		
		
			return $row;	
		}
		function get_product_list(){
			global $wpdb;
			
			$parent_product = $this->get_parent_product();
			
			$query ="";
			$query .="SELECT ";
			$query .=" * ";
			$query .=" FROM {$wpdb->prefix}posts as posts ";
			$query .=" WHERE 1=1 ";
			$query .=" AND posts.post_type IN ('product','product_variation')";
			if (count($parent_product)>0)
			$query .=" AND posts.ID NOT IN (". implode (", ", $parent_product) .")";
			
			$query .=" AND posts.post_status IN ('publish') ";	
			$query .=" ORDER BY posts.post_title ";
			
			$row = $wpdb->get_results( $query);	
			
			$product_row = array();
			foreach($row as $key=>$value){
				$product_row[$value->ID] = $value->post_title;
			}
			
			return $product_row;
		}
				
	}
}