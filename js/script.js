$(document).ready(function(){

    //$(".toggle").hide();

  	$("#toggle").click(function(){

        $(this).next(".toggle").slideToggle("slow");

    });

    	
//         $(".toggle").slideUp();
// $("#toggle").click(function(){
//     $(this).next(".toggle").slideToggle("slow");
//   });
	
	//});


    $('#textarea').keyup(function(){

    	var remaining = 200 - $(this).val().length;
    	
    	if (remaining < 0) {
    		remaining = 0;
    	}

		$('#count').text(remaining);

	});
			  
});

