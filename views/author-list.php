<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Wyswietl informacje o autorach ksiazek", "Zobacz informacje o autorach", "noindex"); ?>

<body>
  <?php showHeader("Lista autorów", "Dodaj autora książki"); ?>
  <?php
  showButtons('author-list');
  if ($message)
    showMessage($message, $messageType);
  ?>
  <div class="center">

    <?php
    if ($authorList == false) {
    } else {
      if (!(count($authorList) > 0)) {
        echo "Brak autorów w bazie danych.";
      } else {
    ?>
        <table id="list" class="full-width simple-border th-small-pd">
          <thead class="invert">
            <th>Lp</th>
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Akcja</th>
          </thead>
          <tbody>
            <?php
            $index = 0;


            foreach ($authorList as $author) {;

            ?>
              <tr>
                <td><?php echo ++$index ?></td>
                <td><?php echo $author['imie']; ?></td>
                <td><?php echo $author['nazwisko']; ?></td>
                <td>
                  <?php if ($isAdmin) {
                  ?><a href="?action=edit-author&id_autor=<?php echo $author['id_autor']; ?>">Edytuj</a>
                  
                  <?php
                  } ?>

                </td>
              </tr>

            <?php } ?>
          </tbody>

        </table>
    <?php

      }
    } ?>

  </div>
</body>


</html>