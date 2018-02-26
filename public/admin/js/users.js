function getUsers(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlUsers+"users.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			if (jsonObjetUser.code == 200){
				for (var i = jsonObjetUser.data.users.length - 1; i >= 0; i--) {
					$(document.getElementById('usersList')).append("<li class='list-group-item text-center'>"+jsonObjetUser.data.users[i].name);
				}
			}
		}
	}
}
function loginUser(){
	var name = document.getElementById('nameLogin');
	var password = document.getElementById('passwordLogin');
	var ajax_url = urlUsers+"login.json";
	var params = "name="+name.value+"&pass="+password.value;
	ajax_url += '?' + params;
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			if(jsonObjetUser.code == 200 && jsonObjetUser.data.name == "admin"){
				saveToken(jsonObjetUser.data.token);
				isLogged(true);
				location.replace(urlVista+"main.html");
			}else{
				window.alert(jsonObjetUser.code+": "+jsonObjetUser.message);
			}
		}
	}
}