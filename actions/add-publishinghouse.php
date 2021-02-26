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
        $wydawnictwo = checkForWydawnictwo(trim(strtolower($nazwa)));
       if($wydawnictwo == null && ctype_digit($nazwa) == false && ctype_space($nazwa)==false) {
        insertPublishingHouse(trim(strtolower($nazwa)));
        $added = true;
       }
       else {
        addAlert("Nie można dodać dodac wyawnictwa o podwójnej nazwie lub nie prawidłowych danych", "warning");
       }
        
    }
    if ($added) {
        // $_SESSION['message'] = "Dodano gatunek.";
        // $_SESSION['messageType'] = "ok";

        addAlert("Dodano wydawnictwo", "ok");
        // redirectToPublishingHouseList();

    }
}
if (isset($_POST['action']) && $_POST['action'] == 'add-publishinghouse') {
    addPublishigHouse();
}

$message = getMessage();
$messageType = getMessageType();
