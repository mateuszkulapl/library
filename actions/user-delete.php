<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

$message = getMessage();
$messageType = getMessageType();


if (isset($_GET['userId'])) {
    $deleted = deleteUser($_GET['userId']);
    if ($deleted == true)
        redirectToUsersList('Usunięto użytkownika ' . $_POST["login"], 'ok');
    else {
        if ($deleted == false) {
            showDebugMessage("can not delete user" . $_POST["login"]);
            redirectToUsersList('Nie udało się usunac użytkownika ' . $_POST["login"], 'warning');
        } else
            showDebugMessage("error while deleting user");
    }
}
redirectToUsersList();
exit();