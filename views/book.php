<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead($bookDetails["tytul"], ""); ?>

<body>

    <?php

    showHeader($bookDetails["tytul"], "Szczegóły książki"); ?>
    <?php
    showButtons('book');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">

        <?php

        ?>
        <table class="book-info">
            <tr>
                <td>Tytuł</td>
                <td><?php echo $bookDetails['tytul']; ?></td>
            </tr>
            <tr>
                <td>Opis</td>
                <td><?php echo $bookDetails['opis']; ?></td>
            </tr>
            <tr>
                <td>Wydawnictwo</td>
                <td><?php echo $bookDetails['wydawnictwo']; ?></td>
            </tr>
            <tr>
                <td>Rok wydania</td>
                <td><?php echo $bookDetails['rok_wydania']; ?></td>
            </tr>
            <tr>
                <td>Kategoria</td>
                <td><?php echo $bookDetails['kategoria']; ?></td>
            </tr>
            <tr>
                <td>Liczba egzemplarzy</td>
                <td><?php echo $bookStats['liczba_egzemplarzy']; ?></td>
            </tr>
            <tr>
                <td>Liczba egzemplarzy w bibliotece</td>
                <td><?php echo $bookStats['liczba_egzemplarzy_w_bibliotece']; ?></td>
            </tr>
            <tr>
                <td>Liczba rezerwacji</td>
                <td><?php echo $bookStats['liczba_rezerwacji']; ?></td>
            </tr>
        </table>
        
            <?php

            //przycisk rezerwuj
            if ($bookStats['liczba_egzemplarzy'] > 0) {
                $numerWKolejce = -1 * ($bookStats['liczba_egzemplarzy_w_bibliotece'] - $bookStats['liczba_rezerwacji'] - 1);

                if ($numerWKolejce <= 0) {
            ?>
                    Książki są dostępne</br>Możesz dokonać rezerwacji</br>
                    <div class="buttons">
                    <a href="?action=book-book&bookId=<?php echo $bookDetails['id_ksiazka']; ?>" class="button rezerwuj">Rezerwuj</a>
                </div>
                <?php
                } else {
                    echo "<h4>Brak dostępnych książek.</h4>";
                    echo "Możesz zarezerwować książkę, będziesz $numerWKolejce. w kolejce oczekujących.";
                ?>
                <div class="buttons">
                    <a href="?action=book-book&bookId=<?php echo $bookDetails['id_ksiazka']; ?>" class="button rezerwuj">Rezerwuj</a>
                </div>
            <?php

                }
            }
            ?>
        <?php

        if ($bookEgzemplarze) {
        ?>
            <h2>Egzemplarze</h2>

            <table class="egz-info">
                <thead>
                    <th>Id</th>
                    <th>Wypożyczona</th>
                    <th>Data wypożyczenia</th>
                    <th>Wypożyczono przez</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($bookEgzemplarze as $egzemplarz) {
                        echo "<tr>";
                        echo "<td>" . $egzemplarz['id_egzemplarza'] . "</td>";

                        echo "<td><!--wypozyczona-->";
                        if ($egzemplarz['id_wypozyczenie'] == null)
                            echo "Nie";
                        else
                            echo "Tak";
                        echo "</td><!--wypozyczona-->";



                        echo "<td><!--data wypozyczenia-->";
                        if ($egzemplarz['id_wypozyczenie'] == null)
                            echo "-";
                        else
                            echo $egzemplarz['data_wypozyczenia'];
                        echo "</td><!--data wypozyczenia-->";


                        echo "<td><!--osoba wypozyczenia-->";
                        if ($egzemplarz['login'] == null)
                            echo "-";
                        else
                            echo $egzemplarz['login'];
                        echo "</td><!--data wypozyczenia-->";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>


        <?php
        } else {

        ?><h2>Brak egzemplarzy</h2><?php
                                }

                                    ?>

    </div>
</body>

</html>