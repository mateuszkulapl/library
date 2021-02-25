<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

$message = getMessage();
$messageType = getMessageType();


if (isset($_GET['id_wydawnictwo'])) {
    $deleted = deletePublishingHouse($_GET['id_wydawnictwo']);
    if ($deleted == true)
       redirectToPublishingHouseList('Wydawnictwo już nie istenieje', 'ok');
    else {
        if ($deleted == false) {
            showDebugMessage("can not delete publishingHouse" . $_GET["id_wydawnictwo"]);
            redirectToPublishingHouseList('Nie udało się usunac autora', 'warning');
        } else
            showDebugMessage("error while deleting book");
    }
}
redirectToPublishingHouseList();
exit();