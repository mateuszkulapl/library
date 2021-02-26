<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php
$title = 'Wycofaj egzamplarz książki <em>'.$bookData['tytul'].'</em> </br> Id egzemplarza '.$id_egzemplarza;

showHead("Wycofaj egzemplarz", ""); ?>

<body>

    <?php

    showHeader("Wycofanie egzemplarza", ""); ?>
    <?php
    showButtons('delete-egzemplarz');


    ?>
    <div class="center">
<h1><?php echo $title;?></h1>
        <div class="two-buttons">

        
        <a class="button red" href="?confirm=0&action=delete-egzemplarz&id_egzemplarza=<?php echo $id_egzemplarza; ?>&bookId=<?php echo $bookId;?>">Anuluj
        </a>
        <a class="button green" href="?confirm=1&action=delete-egzemplarz&id_egzemplarza=<?php echo $id_egzemplarza; ?>&bookId=<?php echo $bookId;?>">Potwierdzam wycofanie z obiegu
        </a>
        </div>
    </div>
</body>
</html>