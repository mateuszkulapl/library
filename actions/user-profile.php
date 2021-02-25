<?php
redirectIfNotLoggedIn();


$userId = 0;
$user = null;
if (isset($_GET['userId'])) {
    $userId = ($_GET['userId']);
    $user = getUser($userId);
} else {
    $userId = $_SESSION['userId'];
}
$userData = getUser($userId);

if ($userData == false) {
    redirectToHomePage("Nie znaleziono użytkownika");
}
$message = getMessage();
$messageType = getMessageType();
