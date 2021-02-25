<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();
$genreList = getAllGenres();
$isAdmin=false;
$isReader=false;
if(isset($_SESSION['type']) && $_SESSION['type'] =="admin")
$isAdmin=true;
if(isset($_SESSION['type']) && $_SESSION['type'] =="reader")
$isReader=true;
$message = getMessage();
$messageType = getMessageType();



?>