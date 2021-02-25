<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();
function addPublishigHouse()
{
    $added = false;
    $error = 0;
    if (isset($_POST['nazwa'])) {
        $nazwa = htmlentities($_POST['nazwa'], ENT_QUOTES, 'UTF-8');
    } else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy nazwa wydawnictwa. <br>');
    }

    if ($error > 0) {
        $_SESSION['messageType'] = 'warning';
        return false;
    } else {
        insertPublishingHouse($nazwa);
    }
    if ($added) {
        $_SESSION['message'] = "Dodano gatunek.";
        $_SESSION['messageType'] = "ok";
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'add-publishinghouse') {
    addPublishigHouse();
}

$message = getMessage();
$messageType = getMessageType();
