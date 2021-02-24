<?php
redirectIfNotLoggedIn();

$userId=0;
$user=null;
if(isset($_GET['userId']))
{
$userId=($_GET['userId']);
$user=getUser($userId);
}
else
$userId=$_SESSION['userId'];
$booksList=getBorrowedBooks($userId);

$message = getMessage();
$messageType = getMessageType();
