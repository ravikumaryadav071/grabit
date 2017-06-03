function added(counter, catagory_table, itemid, userid){

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

	xmlhttp.open('GET', '../grabit/php_response_to_ajax/add_to_cart.php?userid='+userid+'&&catagory_table='+catagory_table+'&&itemid='+itemid+'&&action=add');
	xmlhttp.onreadystatechange = function(){

		if((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){

			$('#response_text'+counter).html('<p>'+xmlhttp.responseText+'</p>').hide(2500);
			var str_qty = $('#cart_qty').val();
			var qty = parseInt(str_qty) + 1;
			$('#cart_qty').attr('value', qty);
			$('#add_to_cart'+counter).attr('disabled','disabled');
			$('.badge').html(qty);
		
		}
	}

	xmlhttp.send();
}