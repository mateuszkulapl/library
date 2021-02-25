<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Edytuj gatunek literacki", "Edytuj informacje o gatunku literackim na serwer", "noindex"); ?>

<body>
    <?php showHeader("Edytuj gatunek literacki"); ?>
    <?php
    showButtons('add-genre');
    if ($message) {
        showMessage($message, $messageType);
    }
    ?>
</body>
<div class="center">

    <form action="index.php?action=edit-genre" method="POST" enctype="multipart/form-data">

        <label>Nazwa<br>
            <input type="nazwa" name="nazwa" id="nazwa" value="<?php echo $genreToEdit['nazwa']; ?>" required>
            <br>

            <input type="hidden" name="action" value="edit-genre">
            <input type="hidden" name="id_kategoria" value="<?php echo $genreToEdit['id_kategoria']; ?>">
            <input type="submit" value="Edytuj gatunek">
    </form>
</div>

</html>