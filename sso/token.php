<?php
$PlexUser = getenv("PLEX_GUEST_USER");
$PlexPassword = getenv("PLEX_GUEST_PASSWORD");
$PlexLoginURL = "https://plex.tv/users/sign_in.json";

// Create login request for plex.tv

$data = array('user[login]' => $PlexUser, 'user[password]' => $PlexPassword);
$options = array(
	'http' => array(
		'header' => "X-Plex-Client-Identifier: 1IAf7KKAH8wq0eOOw46dwq\n" .
		"X-Plex-Product: php-sso-passthrough\n" .
		"X-Plex-Version: 1.1\n",

		'method' => "POST",

		'content' => http_build_query($data)
	)
);

$context = stream_context_create($options);
$result = file_get_contents($PlexLoginURL, false, $context);

$jdat = json_decode($result, true);

?>

<html>
	<script>
	let plxtkn = "<?php echo $jdat['user']['authentication_token'];?>";
	localStorage.setItem('myPlexAccessToken', plxtkn);
	window.location = "/web/index.html";
	</script>
</html>
