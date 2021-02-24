<?php
redirectIfNotLoggedIn();

$bookDetails = null;
$bookStats = null;
$bookEgzemplarze = null;
$bookRezerwacje = null;
$bookId = null;
if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
    if($bookId>0)
    {
    $bookDetails = getBook($bookId);
    $bookStats = getBookStats($bookId);

    $bookEgzemplarze = getEgzemplarze($bookId);
    $bookRezerwacje = getRezerwacje(null, $bookId);
    }
}
$message = getMessage();
$messageType = getMessageType();