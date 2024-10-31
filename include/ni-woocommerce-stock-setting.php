<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Stock_Setting' ) ) {
	class Ni_WooCommerce_Stock_Setting{
		public function __construct(){
		}
		function ni_page_init(){
		?>
        <style>
        ._niwoostock_outofstock_notes { background-color:#FFECB3; margin-top:10px; padding-top:10px; width:50%; border:1px solid #FFC107;}
		._niwoostock_setting_table {width:100%; }
		._niwoostock_setting_table caption{ display: table-caption; padding:10px; margin:10px; 
			text-align: center; background-color:#757575; color:#FFFFFF; font-size:14px; text-transform:uppercase;}
			._niwoostock_setting_table  input[type=text],textarea {
			width: 100%;
			padding: 6px 10px;
			margin: 2px 0;
			box-sizing: border-box;
		}
		._niwoostock_setting_table ._niwoostock_setting_button {
			background-color: #FFC107; /* Green */
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			cursor:pointer;
		}
        </style>
        <?php
		$inputtype = "text";
		$inputtype = "hidden";
		$this->option = get_option("niwoostock_setting");
		//print("<pre>".print_r($this->option,true)."</pre>"); 
		
		
		//echo $this->get_option_value("outofstock_notes_showhide");
		?>
         <div class="_niwoostock_setting_message" ></div>
        <form method="post" name="frmn_niwoostock_setting" id="frmn_niwoostock_setting">
        	<div class="_niwoostock_outofstock_notes">
            
            
                <table class="_niwoostock_setting_table" style="display:none">
             <caption>Show Hide Notes/Email button</caption>
            <tr>
                	<td style="width:200px"><label for="outofstock_notes_showhide">Show/Hide Out of stock notes</label></td>
                    <td> <input type="checkbox"  name="niwoostock_setting[outofstock_notes_showhide]"  <?php echo  isset($this->option["niwoostock_setting"]["outofstock_notes_showhide"])?"checked":""; ?> />  </td>
                    <td></td>
                </tr>
                  <tr>
                	<td style="width:200px"><label for="outofstock_notes_showhide_email">Show/Hide email button</label></td>
                    <td> <input type="checkbox"  name="niwoostock_setting[outofstock_notes_showhide_email]"  <?php echo  isset($this->option["niwoostock_setting"]["outofstock_notes_showhide_email"])?"checked":""; ?>   />  </td>
                    <td></td>
                </tr>
            
            </table>
            
            
            
            <table class="_niwoostock_setting_table">
            <caption>Out of stock product notes css setting</caption>
            	<tr>
                	<td><label for="outofstock_notes_textcolor">Out Of Stock Notes Text Color</label></td>
                    <td><input type="text" 
                    class="niwoostock-color-field"  name="niwoostock_setting[outofstock_notes_text_color]"  
                    id="outofstock_notes_textcolor" value="<?php echo $this->get_option_value("outofstock_notes_text_color","#ffffff"); ?>"   />
                    
                    </td>
                    <td></td>
                </tr>
                <tr>
                	<td><label for="outofstock_notes_background_color">Out Of Stock Notes Background Color</label></td>
                    <td><input type="text" 
                    class="niwoostock-color-field"  name="niwoostock_setting[outofstock_notes_background_color]"  
                    id="outofstock_notes_background_color" value="<?php echo $this->get_option_value("outofstock_notes_background_color","#ffbc00"); ?>"  />
                    
                    </td>
                     <td></td>
                </tr>
                <tr>
                	<td><label for="outofstock_notes_border_color">Out Of Stock Notes  Border Color</label></td>
                    <td><input type="text" 
                    class="niwoostock-color-field"  name="niwoostock_setting[outofstock_notes_border_color]"  
                    id="outofstock_notes_border_color" value="<?php echo $this->get_option_value("outofstock_notes_border_color","#ffbc00"); ?>"  />
                    
                    </td>
                     <td></td>
                </tr>
                
                 <tr>
                	<td><label for="outofstock_notes_margin">Out Of Stock Notes Margin</label></td>
                    <td><input type="text" 
                     name="niwoostock_setting[outofstock_notes_margin]"  
                    id="outofstock_notes_margin" value="<?php echo $this->get_option_value("outofstock_notes_margin","5"); ?>"  />
                    
                    </td>
                     <td></td>
                </tr>
                <tr>
                	<td><label for="outofstock_notes_padding">Out Of Stock Notes Padding</label></td>
                    <td><input type="text" 
                    name="niwoostock_setting[outofstock_notes_padding]"  
                    id="outofstock_notes_padding" value="<?php echo $this->get_option_value("outofstock_notes_padding","5"); ?>"  />
                    
                    </td>
                </tr>
                <tr>
                	<td><label for="outofstock_notes_font_size">Out Of Stock Notes Font Size</label></td>
                    <td><input type="text" 
                    name="niwoostock_setting[outofstock_notes_font_size]"  
                    id="outofstock_notes_font_size" value="<?php echo $this->get_option_value("outofstock_notes_font_size","12"); ?>"  />
                    </td>
                    <td></td>
                </tr>
            </table>
            </div>
            <div class="_niwoostock_outofstock_notes">
            <table class="_niwoostock_setting_table">
            	 <caption>Email Setting</caption>
            	<tr>
                	<td><label for="niwoostock_from_email_name"><?php _e("From Email Name:","niwoostock") ?></label></td>
                    <td>
                    <input type="text" name="niwoostock_setting[niwoostock_from_email_name]" id="niwoostock_from_email_name" 
                    value="<?php echo $this->get_option_value("niwoostock_from_email_name"); ?>" />
                    </td>
                    <td style="display:none">Copy from name from here (WooCommerce->Settings->Email Tab, scroll down find "Email sender options")</td>
                </tr>
                <tr>
                	<td><label for="niwoostock_from_email"><?php _e("From Email Address:","niwoostock") ?></label></td>
                    <td><input type="text" name="niwoostock_setting[niwoostock_from_email]" id="niwoostock_from_email"  value="<?php echo $this->get_option_value("niwoostock_from_email"); ?>" />
                    </td>
                     <td style="display:none">Copy from email address from here (WooCommerce->Settings->Email Tab, scroll down find "Email sender options")</td>
                </tr>
                <tr>
                	<td><label for="niwoostock_to_email"><?php _e("To Email:","niwoostock") ?></label></td>
                    <td><input type="text" name="niwoostock_setting[niwoostock_to_email]" id="niwoostock_to_email"  value="<?php echo $this->get_option_value("niwoostock_to_email"); ?>" />
                    </td>
                    <td style="display:none">Receive Out of stock product notification email</td>
                </tr>
                <tr>
                	<td><label for="niwoostock_subject_line"><?php _e("Subject Line:","niwoostock"); ?></label> </td>
                    <td><input type="text" name="niwoostock_setting[niwoostock_subject_line]" id="niwoostock_subject_line" value="<?php echo $this->get_option_value("niwoostock_subject_line"); ?>" />
                    </td>
                    <td style="display:none">Email subject line</td>
                </tr>
                <tr>
                	<td><label for="niwoostock_thank_you_message"><?php _e("Thank You Message:","niwoostock") ?></label>  </td>
                    <td><textarea name="niwoostock_setting[niwoostock_thank_you_message]" id="niwoostock_thank_you_message" rows="5" cols="40" ><?php echo  trim($this->get_option_value("niwoostock_thank_you_message"));  ?>
                    </textarea>
                    </td>
                    <td style="display:none">Display the message after customer send the product notification email</td>
                </tr>
            </table>
             </div>
              <div class="_niwoostock_outofstock_notes">
              	<table class="_niwoostock_setting_table" style="text-align:right">
                	<tr>
                    	<td><input type="submit" value="Save" class="_niwoostock_setting_button"  /></td>
                    </tr>
                </table>
              </div>
            
             <input type="<?php echo 	$inputtype; ?>" name="action" value="ajax_niwoostock_action" />
            <input type="<?php echo 	$inputtype; ?>" name="sub_action" value="ni-niwoostock-setting" />
        </form>
           <div class="_niwoostock_setting_message" ></div>
        <?php
		}
		function get_option_value($key='',$default=''){
			$_value = "";
			$this->option = get_option("niwoostock_setting"); 
			$niwoostock = isset($this->option["niwoostock_setting"])?$this->option["niwoostock_setting"]:array();
			
			 $_value  = isset($niwoostock[$key])?$niwoostock[$key]:$default;
			return $_value;
		}
		function ni_ajax(){
			//echo json_encode($_REQUEST);
			update_option("niwoostock_setting", $_REQUEST );
			echo "Ni Stock Setting Saved successfully.";
			wp_die();	
		}
	}
}