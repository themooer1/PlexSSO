<?php
// Injects Authenticator redirect into index.html

$INDEX_URL = "https://app.plex.tv/desktop";
$SEARCH_STR = "<title>Plex</title>"; // Inject script tag after this line
$INJECT_JS = "<script src=\"/js/auth.js\"></script>";

// Pull index.html from plex.tv
$index_page = file_get_contents($INDEX_URL);
// Inject JS to redirect if myPlexAccessToken not found in Local Storage
$index_page = str_replace($SEARCH_STR, $SEARCH_STR . $INJECT_JS, $index_page);

echo $index_page;
