<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

/**
 *wgrywanie pliku na serwer.
 *@param int $maxUploadSize maksymalna dopuszczalna wielkosc w bajtach
 *@param array $allowedExtensions tablica z dozwolonymi rozszerzeniami plikow
 *@return string $filename nazwa pliku na serwerze
 */
function uploadFile($maxUploadSize = 1024 * 1024, $fileTitle, $allowedExtensions = array('jpg', 'jpeg', 'png'))
{
    if ($_FILES) {
        if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
            $wielkosc_pliku = $_FILES['plik']['size']; //wielkość w bajtach
            $nazwa_pliku = $_FILES['plik']['name'];
            $tymczasowa_nazwa_pliku = $_FILES['plik']['tmp_name'];
            $extension = getFileExtension($nazwa_pliku);
            $miejsce_docelowe = uploadDir . $fileTitle.'.'.$extension;
            if (in_array($extension, $allowedExtensions)) {
                if ($wielkosc_pliku <= 0) {
                    $_SESSION['message'] = 'Plik jest pusty.';
                } elseif ($wielkosc_pliku > $maxUploadSize) {
                    $_SESSION['message'] = 'Plik jest za duży maksymalnie można wysłać ' . human_filesize($maxUploadSize) . '.';
                } elseif (file_exists($miejsce_docelowe)) {
                    $_SESSION['message'] = 'Wczytywany plik już istnieje na serwerze.';
                } else {
                    if (!@move_uploaded_file($tymczasowa_nazwa_pliku, $miejsce_docelowe))
                        $_SESSION['message'] = 'Podana lokalizacja nie istnieje';
                    else {
                        return $miejsce_docelowe;
                    }
                }
            } else {
                $_SESSION['message'] = 'Dozwolone tylko pliki z rozszerzeniem: ' . implode(', ', $allowedExtensions);
            }
        }
    }
    return null;
}

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
        $author = htmlentities($_POST["author"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy autor. <br>');
    }

    if (isset($_POST['publishingHouse']))
        $publishingHouse = htmlentities($_POST["publishingHouse"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowe wydawnictwo. <br>');
    }

    if (isset($_POST['year']))
        $year = htmlentities($_POST["year"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowy rok. <br>');
    }

    if (isset($_POST['inventory']))
        $inventory = htmlentities($_POST["inventory"], ENT_QUOTES, 'UTF-8');
    else {
        $error += 1;
        appendToSessionVariable('message', 'Nieprawidłowa liczba. <br>');
    }

    if ($error > 0) {
        $_SESSION['messageType'] = "warning";
        return false;
    } else {
        $uploadedFile = uploadFile(2 * 1024 * 1024,$_POST['title']);
        if ($uploadedFile != null) {
            insertBook($title, $author, $publishingHouse, $year, $inventory, $uploadedFile);
        } else {
            insertBook($title, $author, $publishingHouse, $year, $inventory, false);
        }
    }
    if ($added) {
        $_SESSION['message'] = 'Dodano książkę.';
        $_SESSION['messageType'] = 'ok';
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'book-add')
    addBook();


$message = getMessage();
$messageType = getMessageType();
