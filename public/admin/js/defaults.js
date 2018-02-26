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
