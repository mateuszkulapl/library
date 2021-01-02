<?php
redirectIfNotLoggedIn();


$message = getMessage();
$messageType = getMessageType();


if (isset($_GET['bookId'])) {
    $borrowed = insertBorrow($_GET['bookId'], $_SESSION['userId']);
    if ($borrowed == true)
        redirectToBooksList('Wypożyczono', 'ok');
    else {
        if ($borrowed == false) {
            showDebugMessage("can not borrow book" . $_GET["bookId"]);
            //redirectToBooksList('Nie udało się wypożyczyć książki ', 'warning');
        } else
            showDebugMessage("error while deleting book");
    }
}
//redirectToBooksList();
exit();