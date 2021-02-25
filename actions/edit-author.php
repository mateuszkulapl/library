<?php
redirectIfNotLoggedIn();
redirectIfNotAdmin();

function editAuthor() {
    $edited = false;
    $error = 0;

    if(isset($_POST['id_autor']))
  {
      $id = htmlentities($_POST['id_autor'], ENT_QUOTES, 'UTF-8');

  }  else {
      $error += 1;
      appendToSessionVariable('message', 'Wystapił błąd. <br>');
  }

  if(isset($_POST['imie'])) {
      $imie = htmlentities($_POST["imie"], ENT_QUOTES, 'UTF-8');
     
  }else {
      $error += 1;
      appendToSessionVariable('message', 'Nieprawidłowe imie. <br>');
  }

  if(isset($_POST['nazwisko'])) {
    $nazwisko = htmlentities($_POST["nazwisko"], ENT_QUOTES, 'UTF-8');
}else {
    $error += 1;
    appendToSessionVariable('message', 'Nieprawidłowe nazwisko. <br>');
}


  if($error > 0) {
      $_SESSION['messageType'] = "warning";
      return false;
  }else {
      $edited = updateAuthor($id, $imie, $nazwisko);
      
  }
  return $edited;
}

$message = getMessage();
$messageType = getMessage();

$authorToEdit = false;
if (isset($_POST['id_autor'])) {
    $updated = editAuthor();
    if ($updated == true)
        redirectToAuthorList('Zaktualizowano autora', 'ok');
    else
        redirectToAuthorList("Nie udalo sie zaktualizowac");
} else {

    if (isset($_GET['id_autor'])) {
        $authorToEdit = getAuthor($_GET['id_autor']);
        if ($authorToEdit == false) {
            redirectToAuthorList('Nie znaleziono autora', 'warning');//todo"
            exit();
        }
    } else {
        redirectToAuthorList('Wybierz autora', 'alert');
        exit();
    }
}
?>