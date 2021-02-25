<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();


$authorList = getAllAuthors();
$genreList = getAllGenres();
$wydawnictwoList = getAllPublishingHouses();
/**
 *wgrywanie pliku na serwer.
 *@param int $maxUploadSize maksymalna dopuszczalna wielkosc w bajtach
 *@param array $allowedExtensions tablica z dozwolonymi rozszerzeniami plikow
 *@return string $filename nazwa pliku na serwerze
 */

function addBook()
{
  
    $added = false;
    $error = 0;
    if (isset($_POST['title']))
        $title = htmlentities($_POST["title"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy tytuł.<br>');
    }

    if (isset($_POST['author']))
        // $author = htmlentities($_POST["author"], ENT_QUOTES, 'UTF-8');

            $authorList = $_POST['author'];
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy autor. <br>');
    }

    if (isset($_POST['publishingHouse']))
        // $publishingHouse = htmlentities($_POST["publishingHouse"], ENT_QUOTES, 'UTF-8');
$publishingHouse = $_POST["publishingHouse"];
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowe wydawnictwo. <br>');
    }
    if (isset($_POST['kategoria']))
    // $kategoria = htmlentities($_POST["kategoria"], ENT_QUOTES, 'UTF-8');
    $kategoria = $_POST['kategoria'];
else {
    $error += 1;
    appendToSessionVariable('message', 'Nieprawidłowa kategoria. <br>');
}

    if (isset($_POST['year']))
        // $year = htmlentities($_POST["year"], ENT_QUOTES, 'UTF-8');
       $year = $_POST["year"];
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy rok. <br>');
    }

 if (isset($_POST['ilosc'])){
        // $ilosc = htmlentities($_POST["ilosc"], ENT_QUOTES, 'UTF-8');
        $ilosc = $_POST["ilosc"];
 }
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy rok. <br>');
    }
   

    if (isset($_POST['description']))
    $description = htmlentities($_POST["description"], ENT_QUOTES, 'UTF-8');
else {
    $error += 1;
    appendToSessionVariable('message', 'Nieprawidłowy opis. <br>');
}

if (isset($_POST['isbn']))
$isbn = htmlentities($_POST["isbn"], ENT_QUOTES, 'UTF-8');
else {
$error += 1;
appendToSessionVariable('message', 'Nieprawidłowy opis. <br>');
}

    if ($error > 0) {
        $_SESSION['messageType'] = "warning";
        return false;
    } else {
        
        insertBook($isbn, $kategoria, $title, $description, $publishingHouse, $year);
        $highId = getHighestBookId();
        for($i = 0; $i < $ilosc; $i++) {
            insertEgzemplarz($highId["id_ksiazki"], false);

        }
        

         
     foreach($authorList as $autor) {
         
         insertAutorKsiazki($highId["id_ksiazki"], $autor);
     }


        // insertAutorKsiazki();


        // insertEgzemplarz($ilosc, $id_ksiazka= , $wycofany = false);

        }
        if ($added) {
            addAllert("Dodano książkę.", 'ok');
            // $_SESSION['message'] = 'Dodano książkę.';
            // $_SESSION['messageType'] = 'ok';
        }
    
    }
   
if (isset($_POST['action']) && $_POST['action'] == 'book-add')
    addBook();


$message = getMessage();
$messageType = getMessageType();