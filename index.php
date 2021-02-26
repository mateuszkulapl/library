<?php
define('_ROOT_PATH', dirname(__FILE__)); //ścieżka dostępu do katalogu głównego
session_start();

require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'Connectors' . DIRECTORY_SEPARATOR . 'DatabaseConnector.php');
require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'debug.php');


/*
home - strona glowna z menu
login - formularz logowania
logout - akcja wylogowania
image - wyswietlanie obrazka
book-add - dodwanie obrazka
*/

$actions = array(
    'home', 'login', 'logout', 'book', 'book-add', 'logout', '404', 'contact', 'users-list',
    'user-edit', 'user-add', 'user-delete', 'books-list', 'book-delete', 'book-edit', 'book-borrow', 'borrowed-books', 'book-return', 'cancel-book',
    'genre-list', 'add-genre', 'delete-genre', 'edit-genre', 'add-author', 'author-list', 'edit-author', 'delete-author', 'wycofaj-egzemplarz',
    'delete-egzemplarz', 'egzemplarz-list', 'add-publishinghouse', 'delete-publishinghouse', 'edit-publishinghouse', 'publishinghouse-list', 'register-step2', 'book-book', 'cancel-book', 'register-step2', 'register-step3', 'user-profile', 'insert-egzemplarz', 'rent-book'
);

if (isset($_GET['action'])) //sprawdzenie czy w url jest parametr action
{
    $action = $_GET['action']; //pobranie akcji z parametrow url
    if (!in_array($action, $actions))
        $action = '404';
} else //parametr nie jest ustawiony-wyswietlenie do strony glownej, ktora ewentualnie przeniesie do logowania
{
    $action = "home";
}
require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php');
include(_ROOT_PATH . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'functions.php');

include(_ROOT_PATH . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . $action . '.php');
include(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $action . '.php');

include(_ROOT_PATH . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'delete-message.php');
showFooter();
