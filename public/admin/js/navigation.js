function checkAlowedNavigation(){
	var isLogged = sessionStorage.getItem("isLogged");
	if(isLogged == "false"){
		location.replace(urlVista+"notauth.html");
	}
}

function logout(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				saveToken("");
				isLogged(false);
				location.replace(urlVista+"index.html");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}	
}
function navigateToMain(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				location.replace(urlVista+"main.html");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
}
function navigateToSongs(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				location.replace(urlVista+"songs.html");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
}
function navigateToNewSong(){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				location.replace(urlVista+"newsong.html");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
}
function navigateToUpdate(id){
	var token = sessionStorage.getItem("token");
	var ajax_url = urlBase+"default_auth.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "GET", ajax_url, true );
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send();
	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetAuth = JSON.parse( ajax_request.responseText );
			if(jsonObjetAuth.code == 200){
				saveID(id);
				location.replace(urlVista+"updateuser.php");
			}else{
				window.alert("Acción no permitida");
			}
		}
	}
	
}