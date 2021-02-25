<?php

redirectIfNotLoggedIn();

$userId = null;
if (isset($_GET['userId'])) {
    $userId = ($_GET['userId']);
} else
    $userId = $_SESSION['userId'];


if (isset($_GET['id_rezerwacja'])) {
    $cancelled = deleteABookBook($_GET['id_rezerwacja'], $userId);
    if ($cancelled == true) {
        $text = 'Anulowano rezerwację książki';
        if (isset($_GET['returnToBook']) && isset($_GET['bookId'])) {
            redirectToBookPage($_GET["bookId"], "usunięto rezerwację", "success");
        }
        redirectToRezerwacjePage($userId, $text, 'success');
    } else {
        if ($cancelled == false) {
            showDebugMessage("can not cancel a book book" . $_GET["bookId"]);
            if (isset($_GET['returnToBook']) && isset($_GET['bookId'])) {
                redirectToBookPage($_GET["bookId"], "Wystąpił błąd. Nie usunięto", "error");
            }
            redirectToBookPage($_GET["bookId"], 'Nie udało się anulować rezerwacji ', 'warning');
        } else
            showDebugMessage("error while cancelling booking book");
    }
}
redirectToBooksList();
