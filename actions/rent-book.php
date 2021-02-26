<?php

$id_rezerwacja = null;
$userId = null;
$bookId = null;
$returnTo = null;
$userData = null;
$id_egzemplarza = null;

$id_pracownicy=null;
$id_pracownicy = $_SESSION['userId'];

if (isset($_GET['id_rezerwacja']))
    $id_rezerwacja = $_GET['id_rezerwacja'];

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
if($id_egzemplarza)    
{
    $rented=false;
    $rented=wypozyczEgzemplarz($id_egzemplarza,$userId,$id_pracownicy);
    if($rented)
    {
        usunRezerwacje($id_rezerwacja);
        $message='Wypożyczono "'.$bookData['tytul'].'" użytkownikowi '.$userData['login'].'</br>';
        $messageType="success";
        
    }
    else
    {
        $message="Wystapił błąd";
        $messageType="error";
    }

    if($returnTo="borrowed")
    {
        $message.='<a href="action=book?bookId='.$bookId.'">Zobacz szczegóły książki</a>';
        redirectToBorrowedBooksList($userId);
    }
    else
    {
        $message.='<a href="action=borrowed-books?userId='.$userId.'">Zobacz książki użytkownika</a>';
    }
}



$egzemplarze = getEgzemplarze($bookId, false, true);


if ($id_rezerwacja != null && $userId != null && $bookId != null && $userData != false) {
} else {

    redirectToHomePage("Wystapił błąd", 'error');
}
