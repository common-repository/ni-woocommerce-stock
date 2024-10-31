<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooStock_Dashboard' ) ) {
	include_once("ni-woostock-function.php");
	class Ni_WooStock_Dashboard extends Ni_WooStock_Function {
		public function __construct(){
		
		}
		function ni_page_init(){
		//echo $this->get_register_email('YEAR');
		//$this->get_outofstock_email();
		//$this->prettyPrint($product);
		?>
        <div class="wrap">
        	  <div class="niwoostock_container">
                <div style="clear:both"></div>
                <div class="niwoostock_content">
                    <div class="niwoostock_row">
                        <div class="niwoostock_columns">
                             <div style="border:1px solid #E91E63; border-top:none;">
                                <h3 class="summary_heading">Stock Summary</h3>
                                <div style="width:100%;   margin:0px">
                                	 <div class="niwoostock_parent_box">
                                     	 <div class="niwoostockcogpro-float-left box-color1">
                                         	<div class="niwoostock_box_heading">This year out of stock email</div>
                                            <div class="niwoostock_box_content" ><?php echo $this->get_register_email("YEAR"); ?></div>
                                         </div>
                                          <div class="niwoostockcogpro-float-left box-color2" >
                                         	<div class="niwoostock_box_heading">This Month out of stock email</div>
                                            <div class="niwoostock_box_content" ><?php echo $this->get_register_email("MONTH"); ?></div>
                                         </div>
                                          <div class="niwoostockcogpro-float-left box-color3" >
                                         	<div class="niwoostock_box_heading">Yesterday out of stock email</div>
                                            <div class="niwoostock_box_content" ><?php echo $this->get_register_email("YESTERDAY"); ?></div>
                                         </div>
                                          <div class="niwoostockcogpro-float-left box-color8" >
                                         	<div class="niwoostock_box_heading">Today out of stock email</div>
                                            <div class="niwoostock_box_content" ><?php echo $this->get_register_email("DAY"); ?></div>
                                         </div>
                                     </div>
                                     <div class="niwoostock_parent_box">
                                     	 <div class="niwoostockcogpro-float-left box-color5">
                                         	<div class="niwoostock_box_heading">Total Product Count</div>
                                            <div class="niwoostock_box_content" >
											<?php echo $this->get_total_product(); ?>
                                            </div>
                                         </div>
                                          <div class="niwoostockcogpro-float-left box-color6" >
                                         	<div class="niwoostock_box_heading">Low Stock Product Count</div>
                                            <div class="niwoostock_box_content" >
                                            <?php echo $this->get_low_in_stock(); ?>	
                                            </div>
                                         </div>
                                          <div class="niwoostockcogpro-float-left box-color9" >
                                         	<div class="niwoostock_box_heading">Out of Stock Product Count</div>
                                            <div class="niwoostock_box_content" >
                                            <?php echo $this->get_out_of_stock(); ?>		
                                            </div>
                                         </div>
                                          <div class="niwoostockcogpro-float-left box-color8" >
                                         	<div class="niwoostock_box_heading">Low Most Product Count</div>
                                            <div class="niwoostock_box_content" >
                                             <?php echo $this->get_most_stock(); ?>		
                                            </div>
                                         </div>
                                     </div>
                                </div>
                                <div style="clear:both"></div>	
                                						
                             </div>
                        </div>
                    </div>
                </div>
                <div style="clear:both"></div>
                <div class="niwoostock_content">
                    <div class="niwoostock_row">
                        <div class="niwoostock_columns">
                        	 <div style="font-size:16px; padding:5px; color:#424242; font-weight:bold; text-transform:uppercase">Top 10 out of product stock notification email</div>	
                          	<?php $this->get_outofstock_product(); ?>	
                        </div>
                    </div>
                </div>
                
                <div style="clear:both"></div>
                <div style="padding-bottom:20px;"></div>
                <div class="niwoostock_content">
                    <div class="niwoostock_row">
                        <div class="niwoostock_columns">
                         <div style="font-size:16px; padding:5px; color:#424242; font-weight:bold; text-transform:uppercase">Top 10  out of stock product email</div>	
                         <?php $this->get_outofstock_email(); ?>	
                        </div>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
        <?php	
		}
		function get_register_email($period =''){
			$today_date = date_i18n("Y-m-d");
			global $wpdb;
			$table_name = $wpdb->prefix . "niwoostock";
			$query ="";
			$query .= " SELECT  ";
			$query .= " COUNT(*) ";
			$query .= "	FROM " . $table_name;			
			$query .= " WHERE 1 = 1";
			//if ($start_date && $end_date){	
				//$query .= " AND date_format( created_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date }'";	
			//}
			//$row = $wpdb->get_results( $query);
			//$this->prettyPrint( $row);
			
			if ($period =="YESTERDAY")
			{
				$query .= " AND   date_format( created_date, '%Y-%m-%d') = DATE_SUB('$today_date', INTERVAL 1 DAY) "; 
			}
			if ($period =="DAY"){		
				$query .= " AND   date_format( created_date, '%Y-%m-%d') = '{$today_date}' "; 
				$query .= " GROUP BY  date_format( created_date, '%Y-%m-%d') ";
			}
			if ($period =="WEEK"){		
				$query .= "  AND  YEAR(date_format( created_date, '%Y-%m-%d')) = YEAR('$today_date') AND 
				WEEK(date_format( created_date, '%Y-%m-%d')) = WEEK('$today_date') ";
			}
			if ($period =="MONTH"){		
				$query .= "  AND  YEAR(date_format( created_date, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
				MONTH(date_format( created_date, '%Y-%m-%d')) = MONTH(CURRENT_DATE()) ";
			
			}
			if ($period =="YEAR"){		
				$query .= " AND YEAR(date_format( created_date, '%Y-%m-%d')) = YEAR(date_format(NOW(), '%Y-%m-%d')) "; 
			}
			//echo $query;
			$row = $wpdb->get_var($query);	
			$row  = isset($row ) ? $row  : "0";	
			//$this->prettyPrint($wpdb);
			return $row ;
		}
		function get_outofstock_email($period =''){
			$today_date = date_i18n("Y-m-d");
			global $wpdb;
			$table_name = $wpdb->prefix . "niwoostock";
			$query ="";
			$query .= " SELECT  ";
			$query .= " COUNT(*) as email_count,  email_address ";
			$query .= "	FROM " . $table_name;			
			$query .= " WHERE 1 = 1";
			
			$query .= " GROUP BY email_address";
			$query .= " ORDER BY  email_count DESC";
			$query .= " LIMIT 10";
			
			$row = $wpdb->get_results( $query);
			
			?>
            <table class="niwoostock_default_table">
            	<thead>
                	<tr>
                	<th>Email Address</th>
                    <th>Count</th>
                </tr>
                </thead>
            	
                <?php foreach($row as $key=>$value) :?>
                <tr>
                	<td><?php echo $value->email_address ?></td>
                    <td><?php echo $value->email_count ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php
			
			
		}
		function get_outofstock_product($period =''){
			$today_date = date_i18n("Y-m-d");
			global $wpdb;
			$table_name = $wpdb->prefix . "niwoostock";
			$query ="";
			$query .= " SELECT  ";
			$query .= " COUNT(*) product_count,  product_name ";
			$query .= "	FROM " . $table_name;			
			$query .= " WHERE 1 = 1";
			
			$query .= " GROUP BY product_name";
			$query .= " ORDER BY  product_count DESC";
			$query .= " LIMIT 10";
			
			$row = $wpdb->get_results( $query);
			
			
			?>
            <table class="niwoostock_default_table">
            	<thead>
                	<tr>
                	<th>Product Name</th>
                    <th>Count</th>
                </tr>
                </thead>
            	
                <?php foreach($row as $key=>$value) :?>
                <tr>
                	<td><?php echo $value->product_name ?></td>
                    <td><?php echo $value->product_count ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php
			
			
		}
		
		function get_low_in_stock(){
			global $wpdb;
			$row = array();
			$query = "";
			$stock   = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 1 ) );
			$nostock = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );
		
			$query =  "SELECT COUNT( DISTINCT posts.ID ) as low_in_stock  FROM {$wpdb->prefix}posts as posts
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON posts.ID = postmeta.post_id
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta2 ON posts.ID = postmeta2.post_id
			WHERE 1=1
			AND posts.post_type IN ( 'product', 'product_variation' )
			AND posts.post_status = 'publish'
			AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
			AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$stock}'
			AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) > '{$nostock}'";
			
			$row = $wpdb->get_var($query);
			
			//$this->print_data($wpdb);
			//$this->print_data($row);
			
		
			return $row;
			
		}
		function get_out_of_stock(){
			global $wpdb;
			$row = array();
			$query = "";
			$stock = absint( max( get_option( 'woocommerce_notify_no_stock_amount' ), 0 ) );
		
			$query =  "SELECT COUNT( DISTINCT posts.ID ) as out_of_stock FROM {$wpdb->prefix}posts as posts
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON posts.ID = postmeta.post_id
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta2 ON posts.ID = postmeta2.post_id
			WHERE 1=1
			AND posts.post_type IN ( 'product', 'product_variation' )
			AND posts.post_status = 'publish'
			AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
			AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= '{$stock}'";
			
			$row = $wpdb->get_var($query);
			
			//$this->print_data($wpdb);
			//$this->print_data($row);
			
		
			return $row;
			
		}
		function get_most_stock(){
			global $wpdb;
			$row = array();
			$query = "";
			$stock = absint( max( get_option( 'woocommerce_notify_low_stock_amount' ), 0 ) );
		
			$query =  " SELECT COUNT( DISTINCT posts.ID ) FROM {$wpdb->prefix}posts as posts
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON posts.ID = postmeta.post_id
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta2 ON posts.ID = postmeta2.post_id
			WHERE 1=1
			AND posts.post_type IN ( 'product', 'product_variation' )
			AND posts.post_status = 'publish'
			AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes'
			AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) > '{stock}'";
			
			$row = $wpdb->get_var($query);
			
			//$this->print_data($wpdb);
			//$this->print_data($row);
			
		
			return $row;
			
		}
		function get_total_product(){
			$product = wp_count_posts('product');
			return  isset($product->publish)?$product->publish:0;
		}	
	}
}