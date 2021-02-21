<?php

redirectIfNotLoggedIn();


if (isset($_GET['bookId'])) {
    $booked = bookABook($_GET['bookId'],$_SESSION['userId']);
    if ($booked == true)
        redirectToBookPage($_GET['bookId'],'Zarezerwowano książkę', 'ok');
    else {
        if ($booked == false) {
            showDebugMessage("can not book a book book" . $_GET["bookId"]);
            redirectToBookPage($_GET["bookId"],'Nie udało się zarezerwować książki ', 'warning');
        } else
            showDebugMessage("error while booking book");
    }
}
redirectToBooksList();
