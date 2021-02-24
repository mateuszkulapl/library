<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Dodaj gatunek", "Dodaj informacje o książce na serwer", "noindex"); ?>

<body>
    <?php showHeader("Lista gatunków literackich", "Dodaj gatunek książki"); ?>
    <?php
    showButtons('add-genre');
    if ($message)
        showMessage($message, $messageType);
    ?>
    <div class="center">



<form action="index.php?action=add-genre" method = "POST" multipart/from-data>
    <label for="nazwa">Nazwa</label><br>
    <input type="text" name="nazwa">   
    <br>
    <input type ="hidden" name = "action" value ="add-genre">
    <input type="submit" value="Dodaj Gatunek"> 
        </form> 
    </div>
</body>

</html>