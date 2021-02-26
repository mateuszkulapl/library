<?php
redirectIfLoggedIn();
redirectIfNotAdmin();
function addAuthor()
{
    $added = false;
    $error = 0;
    if (isset($_POST['imie']) && $_POST['nazwisko']) {
        $imie = htmlentities($_POST['imie'], ENT_QUOTES, 'UTF-8');
        $nazwisko = htmlentities($_POST['nazwisko'], ENT_QUOTES, 'UTF-8');
    } else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy autor. <br>');
    }

    if ($error > 0) {
        $_SESSION['messageType'] = 'warning';
        return false;
    }  elseif(ctype_space($imie) || ctype_space($nazwisko) || ctype_digit($imie) == true ||ctype_space($nazwisko) ) {
        addAlert("Nieprawidłowe dane dla autora", "warning");
    } else {
        insertAuthor(trim($imie), trim($nazwisko));
        $added = true;
    }

    
    if ($added) {

        addAlert("Dodano autora", "ok");
        redirectToAuthorList();

        // $_SESSION['message'] = "Dodano autora.";
        // $_SESSION['messageType'] = "ok";
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'add-author') {
    addAuthor();
}


$message = getMessage();
$messageType = getMessageType();
