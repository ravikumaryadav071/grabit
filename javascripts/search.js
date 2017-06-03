// $(function(){

// 	var data = ["Samsung", "Apple", "HTC", "Note", "Iphone6", "Imported"];

// 	$("#autosearch").autocomplete({
// 		source: data
// 	});
// });

function init(){

	var searchText = document.getElementById("autosearch");
	searchText.onkeyup = search;

}

onload = init;

function search(){

	var searchText = document.getElementById("autosearch");
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

	var text = searchText.value;
	var index_of_space = text.indexOf(' ');
	xmlhttp.open('GET', '../grabit/php_response_to_ajax/search.php?search_text='+text);
	xmlhttp.onreadystatechange = function(){

			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				var str = xmlhttp.responseText;
				var data = str.split(",");

				$("#autosearch").autocomplete({
					source: data
				});
			}
	}

	xmlhttp.send();

}