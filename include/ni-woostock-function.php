<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooStock_Function' ) ) {
	class Ni_WooStock_Function {
		public function __construct(){
		}
		function get_request($name,$default = NULL,$set = false){
			if(isset($_REQUEST[$name])){
				$newRequest = $_REQUEST[$name];
				
				if(is_array($newRequest)){
					$newRequest = implode(",", $newRequest);
				}else{
					$newRequest = trim($newRequest);
				}
				
				if($set) $_REQUEST[$name] = $newRequest;
				
				return $newRequest;
			}else{
				if($set) 	$_REQUEST[$name] = $default;
				return $default;
			}
		}
		function niwoostock_pagination($total_row,$per_page=10,$page=1,$url='?'){   
			$total = $total_row;
			$adjacents = "2"; 
			  
			$prevlabel = "&lsaquo; Prev";
			$nextlabel = "Next &rsaquo;";
			$lastlabel = "Last &rsaquo;&rsaquo;";
			  
			$page = ($page == 0 ? 1 : $page);  
			$start = ($page - 1) * $per_page;                               
			  
			$prev = $page - 1;                          
			$next = $page + 1;
			  
			$lastpage = ceil($total/$per_page);
			  
			$lpm1 = $lastpage - 1; // //last page minus 1
			  
			$pagination = "";
			if($lastpage > 1){   
				$pagination .= "<ul class='niwoostock_pagination'>";
				$pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
					  
					if ($page > 1) $pagination.= "<li><a data-page={$prev} href='{$url}page={$prev}'>{$prevlabel}</a></li>";
					  
				if ($lastpage < 7 + ($adjacents * 2)){   
					for ($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page)
						
							$pagination.= "<li><span class='current'>{$counter}</span></li>";
						else
							$pagination.= "<li><a data-page={$counter} href='{$url}page={$counter}'>{$counter}</a></li>";                    
					}
				  
				} elseif($lastpage > 5 + ($adjacents * 2)){
					  
					if($page < 1 + ($adjacents * 2)) {
						  
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							if ($counter == $page)
							
								$pagination.= "<li><span class='current'>{$counter}</span></li>";
							else
								$pagination.= "<li><a data-page={$counter}  href='{$url}page={$counter}'>{$counter}</a></li>";                    
						}
						$pagination.= "<li class='dot'>...</li>";
						$pagination.= "<li><a data-page={$lpm1} href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li><a data-page={$lastpage} href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
							  
					} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
						  
						$pagination.= "<li><a data-page=1 href='{$url}page=1'>1</a></li>";
						$pagination.= "<li><a data-page=2 href='{$url}page=2'>2</a></li>";
						$pagination.= "<li class='dot'>...</li>";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							if ($counter == $page)
							
								$pagination.= "<li><span class='current'>{$counter}</span></li>";
							else
								$pagination.= "<li><a data-page={$counter} href='{$url}page={$counter}'>{$counter}</a></li>";                    
						}
						$pagination.= "<li class='dot'>..</li>";
						$pagination.= "<li><a data-page={$lpm1} href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li><a data-page={$lastpage} href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
						  
					} else {
						  
						$pagination.= "<li><a data-page=1 href='{$url}page=1'>1</a></li>";
						$pagination.= "<li><a data-page=2 href='{$url}page=2'>2</a></li>";
						$pagination.= "<li class='dot'>..</li>";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $page)
								
								$pagination.= "<li><span class='current'>{$counter}</span></li>";
							else
								$pagination.= "<li><a data-page={$counter} href='{$url}page={$counter}'>{$counter}</a></li>";                    
						}
					}
				}
				  
					if ($page < $counter - 1) {
						$pagination.= "<li><a data-page={$next} href='{$url}page={$next}'>{$nextlabel}</a></li>";
						$pagination.= "<li><a data-page={$lastpage} href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
					}
				  
				$pagination.= "</ul>";        
			}
			  
			return $pagination;
		}
		function get_all_request($request = array()){
			//$input_type = "text";
			$input_type = "hidden";
			foreach($request as $key=>$value){
				if (is_array($value)){
					 $value =  implode("','", $value);
				} 
			?>
			<input type="<?php echo $input_type; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
			<?php	
			}
		
		}
		function prettyPrint($row) {
			echo "<pre>";
			print_r($row);
			echo "</pre>";
		}
	}
}
?>