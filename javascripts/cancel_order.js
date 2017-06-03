function cancel_order(counter, orderid){

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

	xmlhttp.open('GET', '../grabit/php_response_to_ajax/orders_op.php?orderid='+orderid+'&&action=delete');
	xmlhttp.onreadystatechange = function(){

		if((xmlhttp.readyState == 4)&&(xmlhttp.status == 200)){

			$('#response_text'+counter).html('<p>'+xmlhttp.responseText+'</p>').fadeOut(5500);
			$('#order_no'+counter).hide(3500);

		}

	}

	xmlhttp.send();

}