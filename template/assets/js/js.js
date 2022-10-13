jQuery(document).ready(function($) {	
	
	// AJAX ASSIGN SHOW POPUP
	$("#jwext_news_ticker_assigncat").change(function(){
		var selected = ($(this).val());
		//alert(selected[0]);
		var admin_url = $('#jwext_news_admin_url').val();
		
		
		if(!selected || !admin_url){
			//alert('Not found Categories Assign Item');
			//return;
		}
		var jwext_hid_cat_postype = $('#jwext_hid_cat_postype').val();
		
		
		$.ajax({
            type : "post", 
            url : admin_url,
            data : {
                action: "news_ticker_get_assignshow",
                assignshow : JSON.stringify(selected),
                jwext_hid_cat_postype : jwext_hid_cat_postype,               
            },
            context: this,
            beforeSend: function(){
            	$("div#popup-assign-show").append('<div id="jwext-progress" data-role="progress" data-type="line" data-small="true"></div>');
            },
            success: function(response) {
				//alert(response);return;
				//$('#popup-form').append(response);
            	 $("#jwext-progress").remove();	
            	 var obj = jQuery.parseJSON(response);  				           	
    	 		 if(obj.posttype!=undefined){
    	 			var select = Metro.getPlugin("#select-render-cat-item", 'select');
    	 			select.data(obj.posttype);
    	 			//var select  = $('#select-render-cat-item').data('select');
    	 		    //select.data(obj.posttype);
    	 			$("#news-tickers-item-form-group").removeClass( "jl-postype-hide" );
            	 }
                
            },
            error: function( jqXHR, textStatus, errorThrown ){
                
            }
        }) 
	});	

});


