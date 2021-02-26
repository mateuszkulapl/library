<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php
$title = "";
if ($bookDetails && $bookDetails["tytul"]) {
    $title = $bookDetails["tytul"];
};
showHead($title, ""); ?>
 
<body>

    <?php

    showHeader($title, "Szczegóły książki"); ?>
    <?php
    showButtons('book');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">

        <?php
        if ($bookDetails) {
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
                    <td>Autorzy</td>
                    <?php
                    $authors = getBookAuthors($bookDetails['id_ksiazka']);
                    $authorsString = "";
                    foreach ($authors as $author) {
                        $authorsString .= $author['imie'] . " " . $author['nazwisko'] . "</br>";
                    }
                    $authorsString = trim($authorsString, ' ');
                    $authorsString = trim($authorsString, '</br>');
                    $authorsString = trim($authorsString, ' ');
                    $authorsString = trim($authorsString, '</br>');
                    $authorsString = trim($authorsString, ' ');

                    $authorsString = trim($authorsString, '</br>');
                    $authorsString = trim($authorsString, '<br>');
                    //$authorsString=$bookDetails['autorzy']
                    ?>

                    <td><?php echo $authorsString;  ?></td>
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
            if ($_SESSION['type'] != 'admin') {
                if ($bookStats['liczba_egzemplarzy'] > 0) {

                    if ($wylaczWypozyczanie == false) {
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
                            if ($_SESSION['type'] != 'admin') {
                                echo "<b>Możesz zarezerwować książkę, będziesz $numerWKolejce. w kolejce oczekujących</b>.";
                            ?>
                                <div class="buttons">
                                    <a href="?action=book-book&bookId=<?php echo $bookDetails['id_ksiazka']; ?>" class="button rezerwuj">Rezerwuj</a>
                                </div>
            <?php
                            }
                        }
                    } else {
                        echo "<h3>Nie możesz wypożyczyć tej książki</h3>";
                        if ($wylaczWypozyczaniePowod == "book") {
                            echo "Zarezerwowałeś już tę książkę";
                        }
                        if ($wylaczWypozyczaniePowod == "borrow") {
                            echo "Masz już wypożyczoną tę książkę";
                        }
                    }
                }
            }
            ?>
            <?php
            if ($_SESSION['type'] == 'admin') {

                //dodawanie egzemplarza start
                ?>
                <h3>Dodaj egzemplarze</h3>
                
                <form action="?action=insert-egzemplarz" method="post">
                <input type="hidden" name="bookId" value=<?php echo $bookId;?>>
                <input type="number" name="numberOfNew" id="numberOfNew" min=0></br>
                <button type="submit">Dodaj</button>
                </form>

                <?php
                //dodawanie egzemplarza end
                if ($bookEgzemplarze) {
            ?>
                    <h2>Egzemplarze (<?php echo count($bookEgzemplarze); ?> szt.)</h2>
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
                ?>
                    <h2>Brak egzemplarzy</h2>
                <?php
                }

                if ($bookRezerwacje) {
                ?>
                    <h2>Rezerwacje</h2>

                    <table class="egz-info">
                        <thead>
                            <th>Id</th>
                            <th>Użytkownik</th>
                            <th>Akcje</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($bookRezerwacje as $rezerwacja) {
                                echo "<tr>";
                                echo "<td>" . $rezerwacja['id_rezerwacja'] . "</td>";
                                echo '<td><a href="?action=user-profile&userId=' . $rezerwacja['id_czytelnik'] . '">' . $rezerwacja['login'] . '</a></td>';
                                echo "<td>";
                            ?>
                                <a class="button" href="?action=cancel-book&id_rezerwacja=<?php echo $rezerwacja['id_rezerwacja']; ?>&userId=<?php echo $rezerwacja['id_czytelnik']; ?>&returnToBook=1&bookId=<?php echo $bookId; ?>">Anuluj rezerwację</a>
                            <?php
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                <?php
                } else {

                ?>
                    <h2>Brak rezerwacji</h2>
        <?php
                }
            }
        } else {
            "Wystąpił błąd. Nie podano identifikatora książki";
        }
        ?>

    </div>
</body>

</html>