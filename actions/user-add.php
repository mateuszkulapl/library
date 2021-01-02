<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

/**
 *pobranie danych z formularza i dodanie użytkownika do bazy
 *@return bool zwraca informacje czy dodano
 */
function addUser()
{
    $error = 0;

    if (isset($_POST['name']))
        $name = htmlentities($_POST["name"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowe imię. <br>');
    }

    if (isset($_POST['surname']))
        $surname = htmlentities($_POST["surname"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowe wydawnictwo. <br>');
    }

    if (isset($_POST['login']))
        $login = htmlentities($_POST["login"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy login. <br>');
    }

    if (isset($_POST['type']))
        $type = htmlentities($_POST["type"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy typ. <br>');
    }

    if (isset($_POST['password']))
        $password = htmlentities($_POST["password"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowe haslo. <br>');
    }

    if (isset($_POST['birthday']))
        $birthday = htmlentities($_POST["birthday"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy rok. <br>');
    }


    if ($error > 0) {
        $_SESSION['messageType'] = "warning";
        return false;
    } else {
        return insertUser($name, $surname, $login, $password, $birthday, $type, false);
    }
    return false;
}

$message = getMessage();
$messageType = getMessageType();
$userToEdit = false;

if (isset($_POST['action'])) {
    $added = addUser();
    if ($added == true)
        redirectToUsersList('Dodano użytkownika ' . $_POST["login"], 'ok');
    else {
        if ($added == false) {
            showDebugMessage("can not add user");
            redirectToUsersList('Nie udało się dodać użytkownika ' . $_POST["login"], 'warning');
        } else
            showDebugMessage("error while adding user");
    }
}
