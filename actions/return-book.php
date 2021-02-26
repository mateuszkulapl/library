<?php

$id_wypozyczenie = null;
$userId = null;
$bookId = null;
$returnTo = null;
$userData = null;
$id_egzemplarza = null;

$id_pracownicy = null;
$id_pracownicy = $_SESSION['userId'];

if (isset($_GET['id_wypozyczenie']))
    $id_wypozyczenie = $_GET['id_wypozyczenie'];

if (isset($_GET['userId']))
    $userId = $_GET['userId'];

if (isset($_GET['bookId']))
    $bookId = $_GET['bookId'];

if (isset($_GET['returnTo']))
    $returnTo = $_GET['returnTo'];
if (isset($_GET['id_egzemplarza']))
    $id_egzemplarza = $_GET['id_egzemplarza'];

$userData = getUser($userId);
$userLogin = $userData['login'];

$bookData = getBook($bookId);

//po wybraniu egzemplarza
if (isset($_GET['confirm'])) {
    if ($_GET['confirm'] == "1") {
        $returned = false;
        $returned = zwrocWypozyczenie($id_wypozyczenie, $id_pracownicy);
        if ($returned) {
            $message = 'Zwrócono książkę "' . $bookData['tytul'] . '" od użytkownika ' . $userData['login'] . '</br>';
            $messageType = "success";
        } else {
            $message = "Wystapił błąd";
            $messageType = "error";
        }
    } else {
        //anulowano
        $message = "Anulowano";
        $messageType = "info";
    }
    if ($returnTo = "borrowed") {
        $message .= ' <a href="action=book?bookId=' . $bookId . '">Zobacz szczegóły książki</a>';
        redirectToBorrowedBooksList($userId, $message, $messageType);
    } else {
        //$message.='<a href="action=borrowed-books?userId='.$userId.'">Zobacz książki użytkownika</a>';
        redirectToBorrowedBooksList($userId, $message, $messageType);
    }
    
}

//$egzemplarze = getEgzemplarze($bookId, false, true);


if ($id_wypozyczenie != null && $userId != null && $bookId != null && $userData != false) {
} else {

    redirectToHomePage("Wystapił błąd", 'error');
}
