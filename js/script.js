$(document).ready(function(){

  	$("#toggle").click(function(){

    	$(".toggle").toggle();
	
	});

    $('#textarea').keyup(function(){

    	var remaining = 200 - $(this).val().length;
    	
    	if (remaining < 0) {
    		remaining = 0;
    	}

		$('#count').text(remaining);

	});
			  
});

