<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

$message = getMessage();
$messageType = getMessageType();


if (isset($_GET['id_kategoria'])) {
    $deleted = deleteGenre($_GET['id_kategoria']);
    if ($deleted == true)
        redirectToGenreList('Gatunek już nie istenieje', 'ok');
    else {
        if ($deleted == false) {
            showDebugMessage("can not delete book" . $_GET["id_kategoria"]);
            redirectToGenreList('Nie udało się usunac gatunku', 'warning');
        } else
            showDebugMessage("error while deleting book");
    }
}
redirectToGenreList();
exit();