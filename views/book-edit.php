<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Edytuj książkę", "Edytuj informacje o książce na serwer", "noindex"); ?>

<body>
    <?php showHeader("Edytuj książkę"); ?>
    <?php
    showButtons('book-add');
    if ($message)
        showMessage($message, $messageType);
    ?>
    <div class="center">

        <form action="index.php?action=book-edit" method="POST" enctype="multipart/form-data">
            <label>Okładka (jeśli chcesz zmienić)<br>
                <input type="file" name="plik" accept="image/jpeg,image/jpg" /><br>
                <label>Tytuł<br>
                    <input type="text" name="title" id="title" value="<?php echo $bookToEdit['title']; ?>" required>
                </label><br>
                <label>Autor/Autorzy (rodzieleni przecinkami)<br>
                    <input type="text" name="author" id="author" value="<?php echo $bookToEdit['author']; ?>" required>
                </label><br>
                <label>Wydawnictwo<br>
                    <input type="text" name="publishingHouse" id="publishingHouse" value="<?php echo $bookToEdit['publishingHouse']; ?>" required>
                </label><br>
                <label>Rok wydania<br>
                    <input type="number" name="year" id="year" value="<?php echo $bookToEdit['year']; ?>" required>
                </label><br>
                <label>Liczba<br>
                    <input type="number" name="inventory" id="inventory" min=0 value="<?php echo $bookToEdit['inventory']; ?>" required>
                </label><br>
                <input type="hidden" name="action" value="book-edit">
                <input type="hidden" name="bookId" value="<?php echo $bookToEdit['id']; ?>">
                <input type="submit" value="Edytuj książkę">`
        </form>
    </div>
</body>

</html>