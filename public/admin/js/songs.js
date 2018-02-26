function createSong(){
	var title = document.getElementById('titleNewSong');
	var artist = document.getElementById('artistNewSong');
	var url = document.getElementById('urlNewSong');
	if(title.value == "" || artist.value == "" || url.value == ""){
		window.alert("Los campos deben estar rellenos");
	}else{
		var token = sessionStorage.getItem("token");
		var ajax_url = urlSongs+"create.json";
		var params = "title="+title.value+"&artist="+artist.value+"&url="+url.value;
		var ajax_request = new XMLHttpRequest();
		ajax_request.open("POST", ajax_url, true);
		ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax_request.setRequestHeader("Authorization", token);
		ajax_request.send(params);

		ajax_request.onreadystatechange = function() {
			if (ajax_request.readyState == 4 ) {
				var jsonObjet = JSON.parse( ajax_request.responseText );
				window.alert( jsonObjet.code+": "+jsonObjet.message);
			}
		}
		
	}
}
function getSongs(){
	
	var token = sessionStorage.getItem("token");
	var ajax_url = urlSongs+"songs.json";
	var ajax_request = new XMLHttpRequest();
	ajax_request.open("GET", ajax_url, true);
	ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send();

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjet = JSON.parse( ajax_request.responseText );
			if (jsonObjet.code == 200){
				for (var i = jsonObjet.data.songs.length - 1; i >= 0; i--) {
					$(document.getElementById('songsList')).append("<li class='list-group-item text-center'>"+jsonObjet.data.songs[i].title+"<button id='delete' onclick='deleteSong("+jsonObjet.data.songs[i].id+")' class='btn btn-primary col-md-offset-3'>Eliminar canción</button><button id='navigateUpdateSong' onclick='navigateToUpdateSong("+jsonObjet.data.songs[i].id+")' class='btn btn-primary col-md-offset-3'>Update song</button></li>");
				}
			}
		}
	}
		
}
function deleteSong(idSong){
	
	var token = sessionStorage.getItem("token");
	var ajax_url = urlSongs+"delete.json";
	var params = "id="+idSong
	var ajax_request = new XMLHttpRequest();
	ajax_request.open("POST", ajax_url, true);
	ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax_request.setRequestHeader("Authorization", token);
	ajax_request.send(params);

	ajax_request.onreadystatechange = function() {
		if (ajax_request.readyState == 4 ) {
			var jsonObjetUser = JSON.parse( ajax_request.responseText );
			window.alert( jsonObjetUser.code+": "+jsonObjetUser.message);
			location.reload();
		}
	}
}