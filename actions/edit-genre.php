<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

function editGenre() {
    $edited = false;
    $error = 0;

    if(isset($_POST['id_kategoria']))
  {
      $id = htmlentities($_POST['id_kategoria'], ENT_QUOTES, 'UTF-8');

  }  else {
      $error += 1;
      appendToSessionVariable('message', 'Wystapił błąd. <br>');
  }

  if(isset($_POST['nazwa'])) {
      $nazwa = htmlentities($_POST["nazwa"], ENT_QUOTES, 'UTF-8');
  }else {
      $error += 1;
      appendToSessionVariable('message', 'Nieprawidłowa nazwa. <br>');
  }

  if($error > 0) {
      $_SESSION['messageType'] = "warning";
      return false;
  }else {
      $edited = updateGenre($id, $nazwa);
  }
  return $edited;
}

$message = getMessage();
$messageType = getMessage();

$genreToEdit = false;
if (isset($_POST['id_kategoria'])) {
    $updated = editGenre();
    if ($updated == true)
        redirectToGenreList('Zaktualizowano książkę ', 'ok');
    else
        redirectToGenreList("Nie udalo sie zaktualizowac");
} else {

    if (isset($_GET['id_kategoria'])) {
        $genreToEdit = getGenre($_GET['id_kategoria']);
        if ($genreToEdit == false) {
            redirectToGenreList('Nie znaleziono gatunku', 'warning');
            exit();
        }
    } else {
        redirectToGenreList('Wybierz gatunek', 'alert');
        exit();
    }
}
?>