<?php
redirectIfNotLoggedIn();

$bookDetails = null;
$bookStats = null;
$bookEgzemplarze = null;
$bookRezerwacje = null;
$bookId = null;
$userRezerwacje = null;
$userBooks = null;
$wylaczWypozyczanie = false;
$wylaczWypozyczaniePowod = null;
if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
    if ($bookId > 0) {
        $bookDetails = getBook($bookId);
        $bookStats = getBookStats($bookId);

        $bookEgzemplarze = getEgzemplarze($bookId);
        $bookRezerwacje = getRezerwacje(null, $bookId);


        if (isset($_SESSION['userId'])) {
            $userId = ($_SESSION['userId']);

            $userBooks = getBorrowedBooks($userId);
            $userRezerwacje = getRezerwacje($userId);

            foreach ($userRezerwacje as $userRezerwacja) {
                if ($userRezerwacja['id_ksiazka'] == $bookId)
                    $wylaczWypozyczanie = true;
                $wylaczWypozyczaniePowod = "book";
            }
            foreach ($userBooks as $userBook) {
                if ($userBook['id_ksiazka'] == $bookId)
                    $wylaczWypozyczanie = true;
                $wylaczWypozyczaniePowod = "borrow";
            }
        }
    }
}
$message = getMessage();
$messageType = getMessageType();
