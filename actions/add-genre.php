<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();
function addGenre()
{
    $added = false;
    $error = 0;
    if (isset($_POST['nazwa'])) {
        $nazwa = htmlentities($_POST['nazwa'], ENT_QUOTES, 'UTF-8');
    } else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy tytuł. <br>');
    }

    if ($error > 0) {
        $_SESSION['messageType'] = 'warning';
        return false;
    } else {

    $genre = checkForGenre(trim(strtolower($nazwa)));
     
    if($genre == null && ctype_digit($nazwa) == false && ctype_space($nazwa)==false) {
        insertGenre(trim(strtolower($nazwa)));
        $added = true;
    } else {
        addAlert("Nie można dodać dwóch gatunku o podwojnej nazwie lub nieprawidłowych danych", "warning");
    }
        
    }
    if ($added) {

        addAlert("Dodano gatunek", "ok");
        redirectToGenreList();
        // $_SESSION['message'] = "Dodano gatunek.";
        // $_SESSION['messageType'] = "ok";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'add-genre') {
    addGenre();
}

$message = getMessage();
$messageType = getMessageType();
