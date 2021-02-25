<?php

require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'functions.php');

function login()
{
    $login = null;
    $password = null;
    if (isset($_POST['login'])) {
        $login = htmlentities($_POST["login"], ENT_QUOTES, 'UTF-8');
        if (isset($_POST['password'])) {
            $password = getHashed(htmlentities($_POST["password"], ENT_QUOTES, 'UTF-8'));
            $userInfoFromDb=getUserType($login, $password,true);
        var_dump($userInfoFromDb);
            $userTypeFromFB=$userInfoFromDb['type'];
            $userId=$userInfoFromDb['userId'];

            //var_dump($userTypeFromFB);
            if($userTypeFromFB !=false) {
                $_SESSION['type']=$userTypeFromFB;
                $_SESSION['userId'] = $userId;
                redirectToHomePage("Zalogowano","ok");
            } else {
                echo "bledne";
                redirectToLoginPage("Nieprawidłowy login lub hasło","error");
            }
        }
    }
}

redirectIfLoggedIn();


if (isset($_POST['login']) && isset($_POST['password'])) {
    login();
}

$message = getMessage();
$messageType = getMessageType();