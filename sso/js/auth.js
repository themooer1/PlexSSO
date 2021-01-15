// Login to Plex (if myPlexAccessToken not found)

var tokenURL = "/sso/token.php";
var redirectURL = "/sso/redirect.php";

if (localStorage.getItem('myPlexAccessToken') == null) {
	console.log("Obnoxious cousin Throckmorton requests a token.");
	window.location = tokenURL;
}