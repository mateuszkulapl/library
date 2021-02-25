<!DOCTYPE html>
<?php ?>
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
                        <th>Gatunek</th>
                        <th>Rok wydania</th>
                        <th>Wydawnictwo</th>
                        <!--<th>Liczba egzemplarzy</th>-->
                        <th>Akcja</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($booksList as $book) {
                            //$bookStats=getBookStats($book['id_ksiazka']);
                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php echo $book['tytul'] ?></td>

                                <td><?php
                                    // $authors=getBookAuthors($book['id_ksiazka']); 
                                    // $authorsString="";

                                    // foreach ($authors as $author) {
                                    //     $authorsString.=$author['imie']." ".$author['nazwisko'].", ";
                                    // }
                                    // $authorsString=trim($authorsString,', ');

                                    $authorsString = $book['autorzy'];
                                    echo ($authorsString);
                                    ?></td>

                                <td><?php echo $book['kategoria'] ?></td>
                                <td><?php echo $book['rok_wydania'] ?></td>
                                <td><?php echo $book['wydawnictwo'] ?></td>
                                <?php

                                /*
?>
                                <td><?php echo "Dostępne: 
                                ".$bookStats['liczba_egzemplarzy_w_bibliotece']." z ".$bookStats['liczba_egzemplarzy'];
                                ?></td>
                                <?php
*/
                                ?>
                                <td>
                                    <a href="<?php echo "?action=book&bookId=" . $book['id_ksiazka']; ?>">Szczegóły</a>
                                    <?php if ($isAdmin) {
                                    ?>
                                        <!--<a href="?action=book-edit&bookId=<?php echo $book['id_ksiazka']; ?>">Edytuj</a>-->
                                    <?php
                                    }
                                    if ($isAdmin) { ?>
                                        <!--<a href="?action=book-delete&bookId=<?php echo $book['id_ksiazka']; ?>">Usuń</a>-->
                                    <?php
                                    }
                                    /*if ($isReader && $bookStats['liczba_egzemplarzy_w_bibliotece'] > 0) {
                                        if ($book['numOfBorrowedByUser'] < 1) {
                                        ?><a href="?action=book-borrow&bookId=<?php echo $book['id_ksiazka']; ?>">Pożycz</a>
                                    <?php
                                        } else {
                                            echo "Masz wypożyczoną " . $book['numOfBorrowedByUser'] . "szt.";
                                        }
                                    }*/ ?>
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