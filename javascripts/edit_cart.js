function remove_from_cart(counter, itemid){

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

	xmlhttp.open('GET', '../grabit/php_response_to_ajax/remove_from_cart.php?itemid='+itemid);
	xmlhttp.onreadystatechange = function(){

		if((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){

			var qty = $('.badge').html();
			var new_qty = parseInt(qty) - 1;
			$('.badge').html(new_qty);
			$('#response_text'+counter).html('<p>'+xmlhttp.responseText+'</p>');
			$('#item'+counter).hide(3000);

		}

	}

	xmlhttp.send()

}

function save_changes(counter, itemid){

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

	var qty = $('#qty'+counter).val();
	xmlhttp.open('GET', '../grabit/php_response_to_ajax/edit_cart.php?itemid='+itemid+'&&qty='+qty);
	xmlhttp.onreadystatechange = function(){

		if((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){

			$('#response_text'+counter).html('<p>'+xmlhttp.responseText+'</p>').fadeOut(3400);
			$('#qty'+counter).attr('value',qty);

		}

	}

	xmlhttp.send();
}