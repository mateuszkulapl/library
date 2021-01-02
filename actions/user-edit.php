<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

/**
 *pobranie danych z formularza i aktualizuje użytkownika z bazy
 *@return bool zwraca informacje czy zaktualizowano
 */
function editUser()
{
    $updatePass = false;
    $error = 0;
    if (isset($_POST['userId']))
        $id = htmlentities($_POST["userId"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Wystąpił błąd.<br>');
    }

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
        appendToSessionVariable('message', 'Nieprawidłowa rola. <br>');
    }

    if (isset($_POST['password']))
        $password = htmlentities($_POST["password"], ENT_QUOTES, 'UTF-8');
    if ($password != "")
        $updatePass = true;
    else {
        $updatePass = false;
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
        return updateUser($id, $name, $surname, $login, $password, $birthday, $type, $updatePass, false);
    }
    return false;
}

$message = getMessage();
$messageType = getMessageType();
$userToEdit = false;
if (isset($_POST['userId'])) {
    $updated = editUser();
    if ($updated == true)
        redirectToUsersList('Zaktualizowano użytkownika ' . $_POST["login"], 'ok');
    else
        if ($updated == false)
        redirectToUsersList();
} else {

    if (isset($_GET['userId'])) {
        $userToEdit = getUser($_GET['userId']);
        if ($userToEdit == false) {
            redirectToUsersList('Nie znaleziono użytkownika', 'warning');
            exit();
        }
    } else {
        redirectToUsersList('Wybierz użytkownika', 'alert');
        exit();
    }
}
