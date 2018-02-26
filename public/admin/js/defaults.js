var urlBase = "http://localhost/musicApi/public/base/";
var urlLists = "http://localhost/musicApi/public/lists/";
var urlSongs = "http://localhost/musicApi/public/songs/";
var urlUsers = "http://localhost/musicApi/public/users/";
var urlVista = "http://localhost/musicApi/public/admin/";
function saveToken(token){
	sessionStorage.setItem("token", token);
}
function saveID(id){
	sessionStorage.setItem("id", id);
}
function isLogged(logged){
	sessionStorage.setItem("isLogged", logged);
}

function config(){
	var ajax_url = urlBase+"config.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open( "POST", ajax_url, true );
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			window.alert(jsonObjetUser.code+": "+jsonObjetUser.message);
		}
	}
}
