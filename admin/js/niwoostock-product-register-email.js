jQuery(function($){
	$( "._niwoostock_datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'yy-mm-dd'
    });
	
	$(document).on('submit','form#frm_niwoostock_search ,form#frm_niwoostock_pagination',  function(event){
		$.ajax({
			
			url:niwoostock_object.niwoostock_ajaxurl,
			data: $(this).serialize(),
			success:function(response) {
				
				$("._niwoostock_ajax_response").html(response);
				//console.log(response);
				//alert(JSON.stringify(response));
			},
			error: function(response){
				//console.log(response);
				//alert(JSON.stringify(response));
			}
		}); 
		event.preventDefault();
	});
	
	$(document).on('click', "ul.niwoostock_pagination a",function(){
		
		//alert("dasdsa");
		var p = $(this).attr("data-page");
		$("#frm_niwoostock_pagination").find("input[name=p]").val(p);
		$("#frm_niwoostock_pagination" ).submit();
		
		return false;
	});
	
	$("#frm_niwoostock_search").trigger("submit");
});