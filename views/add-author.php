<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Dodaj Autora", "Dodaj informacje o autorze na serwer", "noindex"); ?>

<body>
    <?php showHeader("Lista autorów literackich", "Dodaj autora"); ?>
    <?php
    showButtons('add-author');
    if ($message)
        showMessage($message, $messageType);
    ?>
    <div class="center">



<form action="index.php?action=add-author" method = "POST" multipart/from-data>
    <label for="imie">Imie</label><br>
    <input type="text" name="imie" id="imie">   
    <br>
<label for="nazwisko">Nazwisko</label><br>
<input type = "text" name ="nazwisko" id="nazwisko">
<br>
    <input type ="hidden" name = "action" value ="add-author">
    <input type="submit" value="Dodaj Autora"> 
        </form> 
    </div>
</body>

</html>