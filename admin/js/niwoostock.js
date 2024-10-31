jQuery(function($){
	//alert("dsad");
	 /*$('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
	*/
	//alert(ajax_object_stock.niwoostock_ajaxurl);
	/*$('#example').DataTable( {
        dom: 'Bfrtip',
		"bProcessing": true,
        "sAjaxSource": "response.php",
		"aoColumns":[{ mData: 'product_id' } ,{ mData: 'product_name' }],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });*/
	
	//alert(ajax_object_stock.niwoostock_ajaxurl);
		var table = $('#example').dataTable({
			"bProcessing": true,
			dom: 'Bfrtip',
			/*buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],*/
			 buttons: [
			 { extend: 'copy', text: 'Copy', className: '_nidatable_button' },
			 { extend: 'csv', text: 'CSV', className: '_nidatable_button' },
			 { extend: 'excel', text: 'Excel', className: '_nidatable_button' },
			 { extend: 'pdf', text: 'PDF', className: '_nidatable_button' },
			 { extend: 'print', text: 'Print', className: '_nidatable_button' }
    		],
			"order": [[ 0, "desc" ]],
			"sAjaxSource": ajax_object_stock.niwoostock_ajaxurl + "?action=ajax_niwoostock_action&sub_action=product-register-email",
			"bPaginate":true,
			"sPaginationType":"full_numbers",
			"iDisplayLength": 5,
			
			"aoColumns": [
			{ mData: 'created_date' } ,
			{ mData: 'product_id' },
			{ mData: 'product_name' },
			{ mData: 'product_price' },
			{ mData: 'email_address' }
			]
			});
	
	
	$("#frmTest").submit(function(e) {
		
		
		e.preventDefault();
	});
	$("#frmTest2").submit(function(e) {
		e.preventDefault();
		
		$.ajax({
			url: ajax_object_stock.niwoostock_ajaxurl,
			type: 'post',
			data: $(this).serialize(),
			success: function( response, textStatus, jQxhr ){
				//$('#response pre').html( JSON.stringify( data ) );
				//alert( JSON.stringify( response ));
				
			},
			error: function( jqXhr, textStatus, errorThrown ){
				console.log( errorThrown );
				//alert( JSON.stringify( errorThrown ));
			}
		});
		
		
	});
	
});