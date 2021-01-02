<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Wyświetl książki", "Zobacz książki", "noindex"); ?>

<body>
    <?php showHeader("Wyświetl książki"); ?>
    <?php
    showButtons('books-list');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">

        <?php

        if ($booksList == false) {
        } else {
            if (!(count($booksList) > 0)) {
                echo "Brak książek.";
            } else {
        ?>
                <table id="list" class="full-width simple-border th-small-pd">
                    <thead class="invert">
                        <th>Lp</th>
                        <th>Zdjęcie</th>
                        <th>Tytuł</th>
                        <th>Autorzy</th>
                        <th>Wydawnictwo</th>
                        <th>Rok wydania</th>
                        <th>Liczba egzemplarzy</th>
                        <th>Akcja</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($booksList as $book) {;
                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php if (file_exists($book['image'])) {
        echo '<img src="'.$book["image"].'" height=50>';
    }?></td>
                                <td><?php echo $book['title'] ?></td>
                                <td><?php echo str_replace(", ", "<br>", $book['author']); ?></td>
                                <td><?php echo $book['publishingHouse'] ?></td>
                                <td><?php echo $book['year'] ?></td>
                                <td><?php echo $book['numOfAvailable'] . '/' . $book['inventory'] ?></td>
                                <td><?php if ($isAdmin) {
                                    ?><a href="?action=book-edit&bookId=<?php echo $book['id']; ?>">Edytuj</a>
                                    <?php
                                    }
                                    if ($isAdmin) { ?><a href="?action=book-delete&bookId=<?php echo $book['id']; ?>">Usuń</a>
                                        <?php
                                    }
                                    if ($isReader && $book['inventory'] > 0) {
                                        if ($book['numOfBorrowedByUser'] < 1) {
                                        ?><a href="?action=book-borrow&bookId=<?php echo $book['id']; ?>">Pożycz</a>
                                    <?php
                                        } else {
                                            echo "Masz wypożyczoną " . $book['numOfBorrowedByUser'] . "szt.";
                                        }
                                    } ?>
                                </td>
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