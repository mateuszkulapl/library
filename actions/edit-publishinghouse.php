<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

function editPublishingHouse()
{
    $edited = false;
    $error = 0;

    if (isset($_POST['id_wydawnictwo'])) {
        $id = htmlentities($_POST['id_wydawnictwo'], ENT_QUOTES, 'UTF-8');
    } else {
        $error += 1;
        appendToSessionVariable('message', 'Wystapił błąd. <br>');
    }

    if (isset($_POST['nazwa'])) {
        $nazwa = htmlentities($_POST["nazwa"], ENT_QUOTES, 'UTF-8');
    } else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowa nazwa. <br>');
    }

    if ($error > 0) {
        $_SESSION['messageType'] = "warning";
        return false;
    } else {
        $edited = updatePublishingHouse($id, $nazwa);
    }
    return $edited;
}

$message = getMessage();
$messageType = getMessage();

$wydawnictwoToEdit = false;
if (isset($_POST['id_wydawnictwo'])) {
    $updated = editPublishingHouse();
    if ($updated == true)
        redirectToPublishingHouseList('Zaktualizowano wydawnictwo', 'ok');
    else
        redirectToPublishingHouseList("Nie udalo sie zaktualizowac");
} else {

    if (isset($_GET['id_wydawnictwo'])) {
        $wydawnictwoToEdit = getPublishingHouse($_GET['id_wydawnictwo']);
        if ($wydawnictwoToEdit == false) {
            redirectToPublishingHouseList('Nie znaleziono wydawnictwo', 'warning');
            exit();
        }
    } else {
        redirectToPublishingHouseList('Wybierz wydawnictwo', 'alert');
        exit();
    }
}
