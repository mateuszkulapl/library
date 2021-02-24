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
            $userTypeFromFB=getUserType($login, $password,true);
            if($userTypeFromFB !=false) {
                $_SESSION['type']=$userTypeFromFB;
                $_SESSION['userId'] = getUserId($login);
                redirectToHomePage("Zalogowano","ok");
            } else {
                // redirectToLoginPage("Nieprawidłowy login lub hasło");
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