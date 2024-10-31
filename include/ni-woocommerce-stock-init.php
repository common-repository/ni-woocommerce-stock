<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'Ni_WooCommerce_Stock_Init' ) ) {
	class Ni_WooCommerce_Stock_Init{
		public function __construct(){
			add_action( 'admin_menu',  array(&$this,'admin_menu' ));
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			//add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));	
			add_action('wp_head',  array(&$this,'wp_head'));
			add_action('wp_footer',  array(&$this,'wp_footer'));
			/*Email Button Click*/
			add_action( 'wp_enqueue_scripts',  array(&$this,'wp_enqueue_scripts'));
			
			add_action( 'wp_ajax_ajax_niwoostock_action', array(&$this,'ajax_niwoostock_action'));
    		add_action( 'wp_ajax_nopriv_ajax_niwoostock_action',  array(&$this,'ajax_niwoostock_action'));
			
			
			$this->add_WooCommerce_Stock_Hook_Page();
			$this->add_WooCommerce_Product_Hook_Page();
		}
		function wp_head(){
		}
		function wp_footer(){
		$this->option = get_option("niwoostock_setting"); 
		$niwoostock = isset($this->option["niwoostock_setting"])?$this->option["niwoostock_setting"]:array();
		//echo json_encode($niwoostock["outofstock_notes_text_color"]);
		$text_color  = isset($niwoostock["outofstock_notes_text_color"])?$niwoostock["outofstock_notes_text_color"]:'#000000';
		$background_color  = isset($niwoostock["outofstock_notes_background_color"])?$niwoostock["outofstock_notes_background_color"]:'#FFFFFF';
		$border_color  = isset($niwoostock["outofstock_notes_border_color"])?$niwoostock["outofstock_notes_border_color"]:'#FFFFFF';
		$margin  = isset($niwoostock["outofstock_notes_margin"])?$niwoostock["outofstock_notes_margin"]:'5';
		$padding  = isset($niwoostock["outofstock_notes_padding"])?$niwoostock["outofstock_notes_padding"]:'5';
		$font_size  = isset($niwoostock["outofstock_notes_font_size"])?$niwoostock["outofstock_notes_font_size"]:'12';
		?>
        <style>
        	.niwoostock_outofstock_notes { 
			background-color:<?php echo $background_color; ?>; 
			padding:<?php echo $padding; ?>px; 
			margin:<?php echo $margin; ?>px; 
			color:<?php echo $text_color; ?>; 
			border:1px solid <?php echo $border_color; ?>; 
			font-size: <?php echo $font_size; ?>px;}
        </style>
        <?php	
		}
		function wp_enqueue_scripts(){
			wp_enqueue_script('niwoostock-ajax-script', plugins_url( '../admin/js/script.js', __FILE__ ), array('jquery') ); 
			wp_localize_script('niwoostock-ajax-script','ajax_object_stock',array('niwoostock_ajaxurl'=>admin_url( 'admin-ajax.php' )));
			
			if ( is_product() ):
				wp_enqueue_script('niwoostock-email-script', plugins_url( '../public/js/niwoostock-email.js', __FILE__ ), array('jquery') ); 
				wp_enqueue_style( 'wpse_89494_style_1', get_template_directory_uri() . '/your-style_1.css' );
			endif;
		}
		function admin_enqueue_scripts(){
			if (isset($_REQUEST["page"])){
				wp_enqueue_script('niwoostock-ajax-script', plugins_url( '../admin/js/script.js', __FILE__ ), array('jquery') ); 
				wp_localize_script('niwoostock-ajax-script','niwoostock_object',array('niwoostock_ajaxurl'=>admin_url( 'admin-ajax.php' )));
				/*CSS*/
				if ($_REQUEST["page"]=="niwoostock" || $_REQUEST["page"]=="product-register-email" ||$_REQUEST["page"]== "ni-product-stock"){
					wp_register_style('ni-woostock-style-css', plugins_url( '../admin/css/ni-woostock-style.css', __FILE__ ));
					wp_enqueue_style('ni-woostock-style-css' );
					
					wp_enqueue_script('jquery-ui-datepicker');
					
					wp_register_style('ni-font-awesome-css', plugins_url( '../admin/css/font-awesome.css', __FILE__ ));
					wp_enqueue_style('ni-font-awesome-css' );
					
					wp_register_style('ni-woostock-pagination-css', plugins_url( '../admin/css/ni-woostock-pagination.css', __FILE__ ));
					wp_enqueue_style('ni-woostock-pagination-css' );
					
					wp_register_style( 'ni-woostock-jquery-ui',  plugins_url( '../admin/css/jquery-ui', __FILE__ ) );
					wp_enqueue_style( 'ni-woostock-jquery-ui' );  
				}
				/*END CSS*/
				
			
				if ($_REQUEST["page"]=="product-register-email"){
					wp_enqueue_script('niwoostock-script', plugins_url( '../admin/js/niwoostock-product-register-email.js', __FILE__ ), array('jquery') ); 
				}
				if ($_REQUEST["page"]=="ni-product-stock"){
					wp_enqueue_script('ni-product-stock-script', plugins_url( '../admin/js/niwoostock-product-stock.js', __FILE__ ), array('jquery') ); 
				}
				if ($_REQUEST["page"] == "ni-niwoostock-setting" ){
					wp_enqueue_style( 'wp-color-picker' );
					wp_enqueue_script('ni-product-stock-script', plugins_url( '../admin/js/niwoostock-setting.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
					
				?>
                
                <?php	
				}
			 		
			}
		}
		function add_WooCommerce_Stock_Hook_Page(){
			include_once("ni-woocommerce-stock-hook.php");
			$objhook =  new Ni_WooCommerce_Stock_Hook();
		}
		function add_WooCommerce_Product_Hook_Page(){
			include_once("ni-woocommerce-product-hook.php");
			$objprohook =  new Ni_WooCommerce_Product_Hook();
		}
		//ni-woocommerce-product-hook.php
		function admin_menu(){
			add_menu_page(__(  'Ni Stock', 'niwoostock')
			,__(  'Ni Stock', 'niwoostock')
			,'manage_options'
			,'niwoostock'
			,array(&$this,'add_page')
			,'dashicons-media-document'
			,58.36);
			add_submenu_page('niwoostock'
			,__( 'Dashboard', 'niwoostock' )
			,__( 'Dashboard', 'niwoostock' )
			,'manage_options'
			,'niwoostock' 
			,array(&$this,'add_page'));
			add_submenu_page('niwoostock'
			,__( 'Register Email', 'niwoostock' )
			,__( 'Register Email', 'niwoostock' )
			, 'manage_options', 'product-register-email' 
			, array(&$this,'add_page'));
			
			add_submenu_page('niwoostock'
			,__( 'Product Stock', 'niwoostock' )
			,__( 'Product Stock', 'niwoostock' )
			, 'manage_options', 'ni-product-stock' 
			, array(&$this,'add_page'));
			
			add_submenu_page('niwoostock'
			,__( 'Setting', 'niwoostock' )
			,__( 'Setting', 'niwoostock' )
			, 'manage_options', 'ni-niwoostock-setting' 
			, array(&$this,'add_page'));
			
		}
		function add_page(){
			if(isset($_REQUEST["page"])){
				if ($_REQUEST["page"]=="niwoostock"){
					include_once("ni-woostock-dashboard.php");
					$obj = new Ni_WooStock_Dashboard();
					$obj->ni_page_init();	
				}
				if ($_REQUEST["page"]=="product-register-email"){
					include_once("ni-product-register-email.php");
					$obj = new Ni_Product_Register_Email();
					$obj->ni_page_init();	
				}
				if ($_REQUEST["page"]=="ni-product-stock"){
					include_once("ni-woocommerce-product-stock.php");
					$obj = new Ni_WooCommerce_Product_Stock();
					$obj->ni_page_init();	
				}
				if ($_REQUEST["page"]=="ni-niwoostock-setting"){
					include_once("ni-woocommerce-stock-setting.php");
					$obj = new Ni_WooCommerce_Stock_Setting();
					$obj->ni_page_init();	
				}
			}
			
		}
		function ajax_niwoostock_action(){
			
			if (isset($_REQUEST["sub_action"])){
				$sub_action = $_REQUEST["sub_action"];
				if ($sub_action =="niwoostock_save_email")
				{
					include_once("ni-woocommerce-save.php");
					$obj = new Ni_WooCommerce_Stock_Save();	
					$obj->niwoostock_save_email();
				}
				if ($sub_action =="product-register-email"){
					include_once("ni-product-register-email.php");
					$obj =  new Ni_Product_Register_Email();
					$obj->niwoostock_ajax();
				}
				if ($sub_action =="niwoostock-product-stock"){
					include_once("ni-woocommerce-product-stock.php");
					$obj = new Ni_WooCommerce_Product_Stock();
					$obj->niwoostock_ajax();
				}
				if ($sub_action =="ni-niwoostock-setting"){
					include_once("ni-woocommerce-stock-setting.php");
					$obj = new Ni_WooCommerce_Stock_Setting();
					$obj->ni_ajax();
				}
			}
			//echo json_encode($_REQUEST);
			wp_die();	
		}
	}
}
?>