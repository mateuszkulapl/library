<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

$message = getMessage();
$messageType = getMessageType();


if (isset($_GET['id_autor'])) {
    $deleted = deleteAuthor($_GET['id_autor']);
    if ($deleted == true)
        redirectToAuthorList('Autor już nie istenieje', 'ok');
    else {
        if ($deleted == false) {
            showDebugMessage("can not delete autor" . $_GET["id_autor"]);
            redirectToAuthorList('Nie udało się usunac autora', 'warning');
        } else
            showDebugMessage("error while deleting book");
    }
}
redirectToAuthorList();
exit();