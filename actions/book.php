<?php
redirectIfNotLoggedIn();


$bookId=null;
if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];
}


$bookDetails=getBook($bookId);
$bookStats=getBookStats($bookId);

$bookEgzemplarze=getEgzemplarze($bookId);
$bookRezerwacje=getRezerwacje(null,$bookId);

$message = getMessage();
$messageType = getMessageType();
