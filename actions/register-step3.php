
<?php

$registerName = null;

if (isset($_POST['registerName'])) {
    $registerName = htmlentities($_POST['registerName']);



    $userFromDb = getUserType($registerName, null, false);

    if ($userFromDb['userId'] == null) {
        //nie ma użytkownika

        $password = htmlentities($_POST["password"], ENT_QUOTES, 'UTF-8');
        $email = htmlentities($_POST['email']);
        $phone = htmlentities($_POST['phone']);
        $data_urodzenia = htmlentities($_POST['data_urodzenia']);

        $inserted = insertUser($registerName, $password, $email, $phone, $data_urodzenia, false);

        if ($inserted) {

            redirectToLoginPage("Konto zostało utworzone</br>Zaloguj się", "success");
        } else {
            redirectToLoginPage("Wystąpił błąd. Spróbuj ponownie", "error");
        }
    } else {
        //jest już taki użytkownik
        redirectToLoginPage("Nazwa użytkownika <b>$registerName</b> jest już zajęta</br>Wybierz inną", "warning");
    }
} else {
    redirectToLoginPage();
}
?>