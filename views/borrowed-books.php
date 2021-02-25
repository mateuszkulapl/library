<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Wyświetl Twoje książki", "Zobacz wypożyczone i zarezerwowane książki", "noindex"); ?>

<body>
    <?php
    if ($user != null)
        showHeader("Książki wypożyczone przez użytkownika<br>" . $user['login']);
    else
        showHeader("Wypożyczone książki"); ?>

    <?php
    showButtons('borrowed-books');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">
        <h3>Wypożyczone książki</h3>
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

        </br>
        <h3>Zarezerwowane książki</h3>
        <?php

        if ($rezerwacje == false) {
            echo "Brak książek.";
        } else {
            if (!(count($rezerwacje) > 0)) {
                echo "Brak książek.";
            } else {
        ?>
                <table id="list" class=" list min-width */full-width*/ simple-border th-small-pd">
                    <thead class="invert">
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Akcja</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($rezerwacje as $rezerwacja) {

                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php echo $rezerwacja['tytul'] ?></td>
                                <td>
                                    <a class="button" href="?action=book&bookId=<?php echo $rezerwacja['id_ksiazka']; ?>">Sczegóły książki</a>
                                    <a class="button" href="?action=cancel-book&id_rezerwacja=<?php echo $rezerwacja['id_rezerwacja']; ?>&userId=<?php echo $rezerwacja['id_czytelnik']; ?>">Anuluj rezerwację</a>
                                    <!--todo:anuluj <a href="?action=book-return&borrowId=<?php echo $book['id']; ?>">Oddaj</a>-->
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