
<?php

$registerName = null;

if (isset($_POST['registerName'])) {
    $registerName = htmlentities($_POST['registerName']);



    $userFromDb = getUserType($registerName, null, false);

    if ($userFromDb['userId'] == null) {
        //nie ma użytkownika

    } else {
        //jest już taki użytkownik
        redirectToLoginPage("Nazwa użytkownika <b>$registerName</b> jest już zajęta</br>Wybierz inną", "warning");
    }
} else {
    redirectToLoginPage();
}
?>