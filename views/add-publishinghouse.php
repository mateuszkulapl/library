<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Dodaj wydawnictwo", "Dodaj informacje o wydawnictwie na serwer", "noindex"); ?>

<body>
    <?php showHeader("Lista wydawnictw", "Dodaj wydawnictwo"); ?>
    <?php
    showButtons('add-publishinghouse');
    if ($message)
        showMessage($message, $messageType);
    ?>
    <div class="center">



<form action="index.php?action=add-publishinghouse" method = "POST" multipart/from-data>
    <label for="nazwa">Nazwa</label><br>
    <input type="text" name="nazwa">   
    <br>
    <input type ="hidden" name = "action" value ="add-publishinghouse">
    <input type="submit" value="Dodaj Wydawnictwo"> 
        </form> 
    </div>
</body>

</html>