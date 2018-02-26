function createList(){
	var name = document.getElementById('nameUpdateList');
	if(name.value != ""){
		var token = sessionStorage.getItem("token");
		var ajax_url = urlLists+"create.json";
		var params = "name="+name.value;
		var ajax_request = new XMLHttpRequest();
		ajax_request.open("POST", ajax_url, true);
		ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax_request.setRequestHeader("Autorization", token);
		ajax_request.send(params);

		ajax_request.onreadystatechange = function() {
			if (ajax_request.readyState == 4 ) {
				var jsonObjetUser = JSON.parse( ajax_request.responseText );
				window.alert( jsonObjetUser.code+": "+jsonObjetUser.message);
			}
		}
	}else{
		window.alert("Debes poner un nombre a la lista");
	}
}
function getPrivateLists(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlLists+"private_lists.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Autorization", token);
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			if(jsonObjetUser.code == 200){
				for (var i = jsonObjetUser.title.length - 1; i >= 0; i--) {
					$(document.getElementById('userPrivateList')).append("<li class='list-group-item text-center'>"+jsonObjetUser.title[i]+"</li>");
				}
			}
		}
	}
}