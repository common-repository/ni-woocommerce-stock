//var ajax_action_name =  'ajax_niwoostock_action'
jQuery(function($){
	
	$("._ni_stock_message").hide();
	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	$("#niwoostock_email").click(function(event){
		
		$("._ni_stock_message").show();
    	$("._ni_stock_message").html("please wait..");
		
		if (!isEmail($("#txtniwoostock_email").val())){
			$("._ni_stock_message").show();
			$("._ni_stock_message").html("Enter valid email address");
			event.preventDefault();
			
			return false;
		}
		
		
		var niwoostockdata = {
		  action: 'ajax_niwoostock_action',
		  niwoostock_email : $("#txtniwoostock_email").val(),
		  niwoostock_product_name: $("#txtniwoostock_product_name").val(),
		  niwoostock_product_price: $("#txtniwoostock_product_price").val(),
		  niwoostock_product_id: $("#txtniwoostock_product_id").val(),
		  sub_action : "niwoostock_save_email"
		};
		
		$.ajax({
			url: ajax_object_stock.niwoostock_ajaxurl,
			dataType: 'json',
			type: 'post',
			//contentType: 'application/json',
			data: niwoostockdata,
			//processData: false,
			success: function( response, textStatus, jQxhr ){
				//$('#response pre').html( JSON.stringify( data ) );
				//alert( JSON.stringify( response ));
				//alert( JSON.stringify( textStatus ));
				//alert( JSON.stringify( jQxhr ));
				
				//alert(response.status);
				//alert(response.message);
				
				$("._ni_stock_message").show();
				$("._ni_stock_message").html(response.thank_you_message);
				//$("#txtniwoostock_email").val('')
			},
			error: function( jqXhr, textStatus, errorThrown ){
				console.log( errorThrown );
				//alert( JSON.stringify( errorThrown ));
			}
		});
		
		
		event.preventDefault();
	});
});