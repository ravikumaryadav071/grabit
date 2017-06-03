function delete_from_wishlist(counter, catagory_table, itemid, userid){

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

	xmlhttp.open('GET', '../grabit/php_response_to_ajax/wishlist_op.php?itemid='+itemid+'&&userid='+userid+'&&catagory_table='+catagory_table+'&&action=delete');
	xmlhttp.onreadystatechange = function(){

		if((xmlhttp.readyState == 4) && (xmlhttp.status == 200)){

			$('#delete_response'+counter).html('<p>'+xmlhttp.responseText+'</p>').fadeOut(5500);
			$('#container'+counter).hide(2500);

		}

	}

	xmlhttp.send();

}