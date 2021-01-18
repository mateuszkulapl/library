<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

$usersList=getAllUsers();
$message = getMessage();
$messageType = getMessageType();
