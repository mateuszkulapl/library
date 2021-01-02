<?php
redirectIfNotLoggedIn();

require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'Connectors' . DIRECTORY_SEPARATOR . 'BooksConnector.php');

$figureImageSrc = uploadDir . 'default.jpg';
$figureFigcaption = 'Brak pliku graficznego';

$books=getBooks();



$message = getMessage();
$messageType = getMessageType();
