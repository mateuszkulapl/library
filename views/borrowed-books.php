<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Wyświetl wypożyczone książki", "Zobacz wypożyczone książki", "noindex"); ?>

<body>
    <?php
if($user!=null)
showHeader("Książki wypożyczone przez:".$user['name']." ".$user['surname'], "login: ".$user['login']); 
else
showHeader("Wypożyczone książki"); ?>

    <?php
    showButtons('borrowed-books');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">

        <?php



        if ($booksList == false) {
            echo "Brak książek.";
        } else {
            if (!(count($booksList) > 0)) {
                echo "Brak książek.";
            } else {
        ?>
                <table id="list" class="full-width simple-border th-small-pd">
                    <thead class="invert">
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Autorzy</th>
                        <th>Wydawnictwo</th>
                        <th>Rok wydania</th>
                        <th>Akcja</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($booksList as $book) {;
                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php echo $book['title'] ?></td>
                                <td><?php echo str_replace(", ", "<br>", $book['author']); ?></td>
                                <td><?php echo $book['publishingHouse'] ?></td>
                                <td><?php echo $book['year'] ?></td>
                                <td><a href="?action=book-return&borrowId=<?php echo $book['id']; ?>">Oddaj</a></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>