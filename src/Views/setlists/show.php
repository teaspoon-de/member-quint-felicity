<?php
$backToString = "Setlists";
$backToURI = "/setlists";
require __DIR__ . "/../layout/topBarItem.php"
?>

<?php
$title = htmlspecialchars($setlist["name"]);
$type = "Setlist";
require __DIR__ . "/../layout/topItem.php"
?>

<?php
$placeHolder = "Song suchen";
$forTracks = true;
$searchMethod = null;
require __DIR__ . "/../layout/search.php"
?>

<link rel="stylesheet" href="/css/setlists.css">
<link rel="stylesheet" href="/css/songs.css">

