<?php

$bookId = null;
$id_egzemplarza = null;



if (isset($_GET['bookId']))
    $bookId = $_GET['bookId'];

if (isset($_GET['id_egzemplarza']))
    $id_egzemplarza = $_GET['id_egzemplarza'];


$bookData = getBook($bookId);

//po wybraniu egzemplarza
if (isset($_GET['confirm'])) {
    if ($_GET['confirm'] == "1") {
        $deleted = false;
        $deleted = wycofajEgzemplarz($id_egzemplarza);
        if ($deleted) {
            $message = 'Wycofano egzemplarz z obiegu.';
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
    redirectToBookPage($bookId,$message,$messageType);
    exit();
}



if ($id_egzemplarza != null && $bookId != null) {
} else {
    redirectToHomePage("Wystapił błąd", 'error');
}
