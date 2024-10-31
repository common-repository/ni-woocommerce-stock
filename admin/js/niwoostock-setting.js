(function( $ ) {
 	//alert(ajax_object_stock.niwoostock_ajaxurl);
 	var myOptions = {
		// you can declare a default color here,
		// or in the data-default-color attribute on the input
		defaultColor: false,
		// a callback to fire whenever the color changes to a valid color
		change: function(event, ui){},
		// a callback to fire when the input is emptied or an invalid color
		clear: function() {},
		// hide the color picker controls on load
		hide: true,
		// show a group of common colors beneath the square
		// or, supply an array of colors to customize further
		palettes: true
	};
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.niwoostock-color-field').wpColorPicker(myOptions);
    });
	
	$("#frmn_niwoostock_setting").submit(function(event) {
		event.preventDefault();
		
		/*
		if (is_validate()){
		}else{
		return false;
		}
		*/
		
		//alert("dsad");
		$.ajax({
			url:niwoostock_object.niwoostock_ajaxurl,
			type: 'post',
			data: $("#frmn_niwoostock_setting").serialize(),
			success: function( response, textStatus, jQxhr ){
				//$('#response pre').html( JSON.stringify( data ) );
				//alert( JSON.stringify( response ));
				$("._niwoostock_setting_message").html(response);
			},
			error: function( jqXhr, textStatus, errorThrown ){
				console.log( errorThrown );
				//alert( JSON.stringify( errorThrown ));
			}
		});
	});
	
	function is_validate(){
		var valid = true;
		var msg = "";
		var niwoostock_from_email_name='';
		var niwoostock_from_email='';
		var niwoostock_to_email='';
		
		niwoostock_from_email_name  = $("#niwoostock_from_email_name").val();
		niwoostock_from_email 		= $("#niwoostock_from_email").val();
		niwoostock_to_email         = $("#niwoostock_to_email").val();
		
		if (niwoostock_from_email_name==""){
			msg += "Enter from email name ";
		}
		if (niwoostock_from_email==""){
			msg += "Enter from email name ";
		}else{
			if (!validateEmail(niwoostock_from_email)){
			msg += "Enter valid from email ";
			}
		}
		if (niwoostock_to_email==""){
			msg += "Enter to email  ";
		}else{
			if (!validateEmail(niwoostock_to_email)){
				msg += "Enter valid to email ";
			}
		}
		if (msg.length>0 || msg != ""){
			valid = false;
			//alert(msg);
		}
		return valid;
		
	}
	function validateEmail($email) {
	  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	  return emailReg.test( $email );
	}
	
     
})( jQuery );