$(document).ready(function(){

    $(".toggled").click(function(){

        $(this).next(".toggle").slideToggle("slow");

    });


    $('#textarea').keyup(function(){

    	var remaining = 200 - $(this).val().length;
    	
    	if (remaining < 0) {
    		remaining = 0;
    	}

		$('#count').text(remaining);

	});
			  
});
