<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

$message = getMessage();
$messageType = getMessageType();


if (isset($_GET['bookId'])) {
    $deleted = deleteBook($_GET['bookId']);
    if ($deleted == true)
        redirectToBooksList('Książka już nie istenieje', 'ok');
    else {
        if ($deleted == false) {
            showDebugMessage("can not delete book" . $_GET["bookId"]);
            redirectToBooksList('Nie udało się usunac książki ', 'warning');
        } else
            showDebugMessage("error while deleting book");
    }
}
redirectToBooksList();
exit();