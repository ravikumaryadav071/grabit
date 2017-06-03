$(document).ready(function(){

	var xmlhttp = false;

	try{

		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

	}catch(e){

		try{

			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

		}catch(E){

			xmlhttp = false;

		}

	}

	if(!xmlhttp && typeof XMLHttpRequest != 'undefined'){

		xmlhttp = new XMLHttpRequest();

	}


	$('#username').keyup(function(){

		var username = $(this).val();
		var user_len = username.length;

		if((user_len > 2) &&(user_len <= 30)){
			
			xmlhttp.open('GET', '../grabit/php_response_to_ajax/register_verify.php?username='+username);
			xmlhttp.onreadystatechange = function(){

				if((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){

					var response = xmlhttp.responseText;
					
					if(response == 'denied'){

						$('#username_response').removeClass();
						$('#username_response').addClass('text-danger');
						$('#username_response').html('<p>Sorry! This Username is not available.</p>');

					}

					if(response == 'granted'){

						$('#username_response').removeClass();
						$('#username_response').addClass('text-success');
						$('#username_response').html('<p>This Username is available. Go on!</p>');

					}

				}

			}

			xmlhttp.send();
		}else{

			$('#username_response').removeClass();
			$('#username_response').addClass('text-warning');
			$('#username_response').html('<p>Your username must be 3 to 30 characters long.</p>');

		}

	});

	$('#email').keyup(function(){

		var email = $(this).val();
		var email_len = email.length;

		if(email_len > 3){

			var index_of_at = email.indexOf('@');
			var index_of_dot = email.indexOf('.');
			var index_of_space = email.indexOf(' ');
			var index_of_atdot = email.indexOf('@.');
			
			if(index_of_dot > 0){

				var domain = email.slice(index_of_dot, email_len-1);
				var domain_len = domain.length;
			
			}
			
			if((index_of_at == 0) || (index_of_at == -1) || (index_of_dot == 0) || (index_of_dot == -1) || (index_of_space != -1) || (index_of_atdot != -1) || (domain_len == 0)){
				
				$('#email_response').removeClass();
				$('#email_response').addClass('text-danger');
				$('#email_response').html('<p>This is not valid Email Id.</p>');

			}else{

				$('#email_response').removeClass();
				$('#email_response').addClass('text-success');
				$('#email_response').html('<p>Email Id is valid.</p>');

			}

		}

		if(email_len <= 3){

			$('#email_response').removeClass();
			$('#email_response').addClass('text-danger');
			$('#email_response').html('<p>This is not valid Email Id.</p>');

		}

	});

	$('#password').keyup(function() {

		var password = $(this).val();
		var password_len = password.length;

		if(password_len <= 6){

			$('#password_response').removeClass();
			$('#password_response').addClass('text-danger');
			$('#password_response').html('<p>Your password must have more than 6 characters.</p>');

		}else{

			$('#password_response').removeClass();
			$('#password_response').addClass('text-success');
			$('#password_response').html('<p>Valid password.</p>');

		}

	});

	$('#password_again').keyup(function() {

		var password = $('#password').val();
		var password_again = $(this).val();
		var password_again_len = password_again.length;
		
		if(password_again_len > 0){

			if(password_again == password){

				$('#password_again_response').removeClass();
				$('#password_again_response').addClass('text-success');
				$('#password_again_response').html('<p>Password matches.</p>');

			}else{

				$('#password_again_response').removeClass();
				$('#password_again_response').addClass('text-danger');
				$('#password_again_response').html('<p>Password is not matching with your first password.</p>')

			}

		}

	});

	$('#name').keyup(function(){

		var name = $(this).val();
		var name_len = name.length;

		if(name_len > 2){

			$('#name_response').removeClass();
			$('#name_response').addClass('text-success');
			$('#name_response').html('<p>Valid</p>');

		}else{

			$('#name_response').removeClass();
			$('#name_response').addClass('text-danger');
			$('#name_response').html('<p>Your name must contain more than 2 characters.</p>');

		}

	});

});