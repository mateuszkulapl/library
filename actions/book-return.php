<?php
redirectIfNotLoggedIn();

$message = getMessage();
$messageType = getMessageType();


if (isset($_GET['borrowId'])) {
    $deleted = deleteBorrow($_GET['borrowId']);
    if ($deleted == true)
        redirectToBorrowedBooksList('Oddano', 'ok');
    else {
        if ($deleted == false) {
            showDebugMessage("can not return book" . $_GET["bookId"]);
            redirectToBooksList('Nie udało się oddanie książki ', 'warning');
        } else
            showDebugMessage("error while returning book");
    }
}
redirectToBorrowedBooksList();
exit();
