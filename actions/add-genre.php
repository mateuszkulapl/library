<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();
function addGenre() {
    $added = false;
    $error = 0;
    if(isset($_POST['nazwa'])) {
        $nazwa = htmlentities($_POST['nazwa'], ENT_QUOTES, 'UTF-8');
    }else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy tytuł. <br>');
    }

    if($error > 0) {
        $_SESSION['messageType'] = 'warning';
        return false;
    } else {
        insertGenre($nazwa);
    }
    if($added) {
        $_SESSION['message'] = "Dodano gatunek.";
        $_SESSION['messageType'] = "ok";
    }
}
if(isset($_POST['action']) && $_POST['action'] == 'add-genre') {
    addGenre();
}

$message = getMessage();
$messageType = getMessageType();

?>