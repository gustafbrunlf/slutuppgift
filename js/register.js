$(document).ready(function(){

	$('#submit').click(function(event){

		var form 	= document.forms.registrationform;
		var email	= form.email.value;
		var name	= form.username.value;
		var pwd 	= form.password.value;
		var pwd2	= form.password2.value;

		$('#registererror').text('');
		$('#email, #password, #password2, #username').removeClass('fielderror');

		if(email.length > 0 && name.length > 0 && pwd.length > 0 && pwd2.length > 0){

			if(email.indexOf('.') != -1 && email.indexOf('@') != -1){

				if(pwd != pwd2){

					$('#registererror').append("<p>Passwords doesn't match</p><br>");
					$('#password, #password2').addClass('fielderror');

				}

			} else {

				$('#registererror').append("<p>Invalid e-mail</p><br>");
				$('#email').addClass('fielderror');

			}

		} else {

			$('#registererror').append("<p>Please fill in all fields</p><br>");
	
		}

		if($('#registererror').text() != '') {
			event.preventDefault();
		}

	});

});