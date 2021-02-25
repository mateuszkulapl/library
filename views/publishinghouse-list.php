<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Wyswietl informacje o gatunkach literckich", "Zobacz informacje o kategoriach książek", "noindex"); ?>

<body>
  <?php showHeader("Lista gatunków literackich", "Dodaj gatunek książki"); ?>
  <?php
  showButtons('publishingHouse-list');
  if ($message)
    showMessage($message, $messageType);
  ?>
  <div class="center">

    <?php
    if ($publishingHouseList == false) {
    } else {
      if (!(count($publishingHouseList) > 0)) {
        echo "Brak gatunków literckich.";
      } else {
    ?>
        <table id="list" class="full-width simple-border th-small-pd">
          <thead class="invert">
            <th>Lp</th>
            <th>Nazwa</th>
            <th>Akcja</th>
          </thead>
          <tbody>
            <?php
            $index = 0;


            foreach ($publishingHouseList as $publishingHouse) {;

            ?>
              <tr>
                <td><?php echo ++$index ?></td>
                <td><?php echo $publishingHouse['nazwa']; ?></td>
                <td>
                  <?php if ($isAdmin) {
                  ?><a href="?action=edit-publishinghouse&id_wydawnictwo=<?php echo $publishingHouse['id_wydawnictwo']; ?>">Edytuj</a>
                    <a href="?action=delete-publishinghouse&id_wydawnictwo=<?php echo $publishingHouse['id_wydawnictwo']; ?>">Usuń</a>
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