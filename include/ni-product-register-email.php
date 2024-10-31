<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_Product_Register_Email' ) ) {
	include_once("ni-woostock-function.php");
	class Ni_Product_Register_Email extends Ni_WooStock_Function {
		var $per_page = 10;
		public function __construct(){
		}
		function ni_page_init(){
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
                        
                            <label for="start_date">Start Date</label>
                            <input id="start_date" name="start_date" type="text" class="_niwoostock_datepicker" readonly="readonly"  value="<?php echo $start_date ; ?>" />
                        </div>
                        <div  class="niwoostock_field_wrapper">
                            <label for="end_date">End Date</label>
                            <input id="end_date" name="end_date" type="text" class="_niwoostock_datepicker" readonly="readonly" value="<?php echo $end_date ; ?>"  />
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
                        <input type="<?php echo $input_type; ?>" name="sub_action" value="product-register-email" />
                    </form>
                </div>
            </div>
            
        <div class="_niwoostock_ajax_response"></div>  	  
    	</div>
        
      
        
        <?php	
		}
		function niwoostock_ajax(){
			//echo json_encode($_REQUEST);
			$this->get_niwoostock_table();
			wp_die();	
		}
		function get_niwoostock_table(){
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
											case "qty":
												$cog_value  = isset ($cogrv->$cogck)?$cogrv->$cogck:"";
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
			global $wpdb;
			$start = 0;
			$per_page   			= $this->get_request("per_page",10,true);
			$p   					= $this->get_request("p");
			
			if($p > 1){	$start = ($p - 1) * $per_page;}
			
			$start_date = $this->get_request("start_date");
			$end_date = $this->get_request("end_date");
			
			$table_name = $wpdb->prefix . "niwoostock";
			$query ="";
			$query .= " SELECT  ";
			$query .= " *,date_format( created_date, '%Y-%m-%d') as  created_date ";
			$query .= "	FROM " . $table_name;			
			$query .= " WHERE 1 = 1";
			if ($start_date && $end_date){	
				$query .= " AND date_format( created_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date }'";	
			}
			
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
			//echo $query;	
			//$this->prettyPrint($row);
			
			return $row;
		}
		function get_niwoostock_columns(){
			$columns =  array();
			$columns["created_date"]    = __("Created Date","niwoostock");
			$columns["email_address"]   = __("Email Address","niwoostock");
			$columns["product_name"]    = __("Product Name","niwoostock");	
			$columns["product_price"]   = __("Product Price","niwoostock");	
			$columns["product_sku"] 	= __("Product SKU","niwoostock");	
			
			return $columns;
		}	
	}
}
?>