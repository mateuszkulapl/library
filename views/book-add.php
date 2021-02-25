<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Dodaj książkę", "Dodaj informacje o książce na serwer", "noindex"); ?>

<body>
    <?php showHeader("Dodaj książkę", "Dodaj informacje o książce na serwer"); ?>
    <?php
    showButtons('book-add');
    if ($message)
        showMessage($message, $messageType);
    ?>
    <div class="center">

        <form action="index.php?action=book-add" method="POST" enctype="multipart/form-data">
            ` <input type="file" name="plik" accept="image/jpeg,image/jpg" /><br>
            <label>Tytuł<br>
                <input type="text" name="title" id="title" required>
            </label><br>
            <label>Autor/Autorzy (rodzieleni przecinkami)<br>
                <input type="text" name="author" id="author" required>
            </label><br>
            <label>Wydawnictwo<br>
                <input type="text" name="publishingHouse" id="publishingHouse" required>
            </label><br>
            <label>Rok wydania<br>
                <input type="number" name="year" id="year" value="<?php echo date("Y", time()); ?>" required>
            </label><br>
            <label>Liczba<br>
                <input type="number" name="inventory" id="inventory" min=0 required>
            </label><br>
            <input type="hidden" name="action" value="book-add">
            <input type="submit" value="Dodaj książkę">`
        </form>
    </div>
</body>

</html>