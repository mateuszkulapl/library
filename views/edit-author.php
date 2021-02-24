<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Edytuj autora", "Edytuj informacje o autorze na serwer", "noindex"); ?>
<body>
    <?php showHeader("Edytuj autora"); ?>
    <?php 
    showButtons('add-author');
    if($message) {
        showMessage($message, $messageType);
    }
    ?>
</body>
<div class="center">

        <form action="index.php?action=edit-author" method="POST" enctype="multipart/form-data">
          
                <label>Imie<br>
                    <input type="text" name="imie" id="imie" value="<?php echo $authorToEdit['imie']; ?>" required>
              <br>
              <label>Nazwisko<br>
                    <input type="text" name="nazwisko" id="nazwisko" value="<?php echo $authorToEdit['nazwisko']; ?>" required>
              <br>
               

                <input type="hidden" name="action" value="edit-author">
                <input type="hidden" name="id_autor" value="<?php echo $authorToEdit['id_autor']; ?>">
                <input type="submit" value="Edytuj autora">
        </form>
    </div>

</html>