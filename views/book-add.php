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
<input type="file" name="plik" accept="image/jpeg,image/jpg" /><br>
        <label for ="isbn">Numer isbn <br>
        <input type="text" name="isbn"> <br>
        <label for="title">Tytuł</label> <br>
        <input type="text" name = "title"> <br>
        <label for="description">Opis</label>
        <br>
        <textarea name="description" id="" cols="30" rows="10"></textarea>
        <br>
        <label for="rok">Rok</label><br>
        <input name="rok" type="number">
            <br>
      

            <input type="hidden" name="action" value="book-add">
            <input type="submit" value="Dodaj Książke"> 

        </form>
    </div>
</body>

</html>