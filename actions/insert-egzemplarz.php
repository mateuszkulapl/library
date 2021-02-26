<?php

$bookId = null;
$numberOfNew = 0;
$numberOfInserted = 0;
if (isset($_POST['bookId'])) {
    $bookId = $_POST['bookId'];
    $numberOfNew = intval($_POST['numberOfNew']);

    $bookData = false;
    $bookData = getBook($bookId);
    if ($bookData) {
        for ($cnt = 0; $cnt < $numberOfNew; $cnt++) {
            $numberOfInserted+=insertEgzemplarz($bookId, false);
        }
    }
    $type="warning";
    if($numberOfInserted==$numberOfNew)
    $type="success";
    redirectToBookPage($bookId,"Wstawiono ".$numberOfInserted." egzemplarzy",$type);
}
redirectToHomePage();