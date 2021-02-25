<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Wyświetl zdjęcie", "Zobacz zdjęcie", "noindex"); ?>

<body>
    <?php showHeader("Wyświetl zdjęcie", "Zobacz zdjęcie"); ?>
    <?php
    showButtons('book');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">

<?php
if(!(sizeof($books)>0))
{
    ?>
    <h2>Brak Zdjęć</h2>
    <figure>
            <img src="<?php echo uploadDir.'default.jpg'?>" alt="Krajobraz">
            <figcaption>Opis obrazka</figcaption>
    </figure>
    <?php
}
else
{
?>
<table id="books">
    <thead>
        <th>Okładka</th>
        <th>Tytuł</th>
        <th>Autor</th>
        <th>Wydawnictwo</th>
        <th>Rok wydania</th>
    </thead>
    <tbody>
        <?php
        foreach($books as $book)
        {
            ?>
        <tr>
            <td><img src="<?php echo uploadDir.$book->getFile();?>" alt="okładka książki <?php echo $book->getTitle();?>" ></td>
            <td><?php echo $book->getTitle();?></td>
            <td><?php echo str_replace(',','<br>',$book->getAuthor());?></td>
            <td><?php echo $book->getPublishingHouse();?></td>
            <td><?php echo $book->getYear();?></td>
        </tr>
        <?php
}?>
    </tbody>
</table>



<?php
}
?>


    </div>
</body>

</html>