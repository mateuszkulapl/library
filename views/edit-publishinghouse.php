<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Edytuj wydawnictwo", "Edytuj informacje o wydawnictwie", "noindex"); ?>
<body>
    <?php showHeader("Edytuj wydawnictwo"); ?>
    <?php 
    showButtons('add-publishinghouse');
    if($message) {
        showMessage($message, $messageType);
    }
    ?>
</body>
<div class="center">

        <form action="index.php?action=edit-publishinghouse" method="POST" enctype="multipart/form-data">
          
                <label>Nazwa<br>
                    <input type="nazwa" name="nazwa" id="nazwa" value="<?php echo $wydawnictwoToEdit['nazwa']; ?>" required>
              <br>
               
                <input type="hidden" name="action" value="edit-publishinghouse">
                <input type="hidden" name="id_wydawnictwo" value="<?php echo $wydawnictwoToEdit['id_wydawnictwo']; ?>">
                <input type="submit" value="Edytuj wydawnictwo">
        </form>
    </div>

</html>