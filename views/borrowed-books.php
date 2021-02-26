<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Wyświetl Twoje książki", "Zobacz wypożyczone i zarezerwowane książki", "noindex"); ?>

<body>
    <?php
    if ($user != null)
        showHeader("Książki użytkownika " . $user['login']);
    else
        showHeader("Wypożyczone książki"); ?>

    <?php
    showButtons('borrowed-books');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">
        <h2>Wypożyczone książki</h2>
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
                        <th>Wypożyczono</th>
                        <th>Autorzy</th>
                        <th>Wydawnictwo</th>
                        <th>Rok wydania</th>
                        <th>Gatunek</th>

                        <th>Akcje</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($booksList as $book) {
                            
                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php echo $book['tytul'] ?></td>
                                <td><?php echo $book['data_wypozyczenia']  ?></td>
                                <td><?php echo $book['autorzy']  ?></td>
                                <td><?php echo $book['wydawnictwo'] ?></td>
                                <td><?php echo $book['rok_wydania'] ?></td>
                                <td><?php echo $book['kategoria'] ?></td>
                                <td><a class="button" href="?action=book&bookId=<?php echo $book['id_ksiazka']; ?>">Szczegóły książki</a>
                                
                                <?php if(isset($_SESSION['type']) && $_SESSION['type'] =="admin"):?>
                                <a class="button" href="?action=return-book&id_wypozyczenie=<?php echo $book['id_wypozyczenie']; ?>&userId=<?php echo $book['id_czytelnik']; ?>&returnToBook=1&bookId=<?php echo $book['id_ksiazka'];?>&id_egzemplarza=<?php echo $book['id_egzemplarza'];?>">Zwrot</a>
                                <?php endif;?>

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

        </br>
        <h2>Zarezerwowane książki</h2>
        <?php

        if ($rezerwacje == false) {
            echo "Brak książek.";
        } else {
            if (!(count($rezerwacje) > 0)) {
                echo "Brak książek.";
            } else {
        ?>
                <table id="list" class=" list full-width simple-border th-small-pd">
                    <thead class="invert">
                        <th>Lp</th>
                        <th>Tytuł</th>
                        <th>Autorzy</th>
                        <th>Wydawnictwo</th>
                        <th>Rok wydania</th>
                        <th>Gatunek</th>

                        <th>Akcje</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($rezerwacje as $rezerwacja) {
                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php echo $rezerwacja['tytul'] ?></td>
                                <td><?php echo $rezerwacja['autorzy']  ?></td>
                                <td><?php echo $rezerwacja['wydawnictwo'] ?></td>
                                <td><?php echo $rezerwacja['rok_wydania'] ?></td>
                                <td><?php echo $rezerwacja['kategoria'] ?></td>
                                <td><a class="button" href="?action=book&bookId=<?php echo $rezerwacja['id_ksiazka']; ?>">Szczegóły</a>
                                <a class="button" href="?action=cancel-book&id_rezerwacja=<?php echo $rezerwacja['id_rezerwacja']; ?>&userId=<?php echo $rezerwacja['id_czytelnik']; ?>">Anuluj rezerwację</a>

                                <?php
                                
                                
                                $bookStats=getBookStats($rezerwacja['id_ksiazka']);
                                $l_dostepnych=$bookStats['liczba_egzemplarzy_w_bibliotece'];
                                $bookRezerwacje=getRezerwacje(null,$bookStats['liczba_egzemplarzy_w_bibliotece']);
                                $l_rezerwacji=count($bookRezerwacje);
                                $pozycjaNa_l_rezerwacji=null;
                                for($cntR=1;$cntR<=$l_rezerwacji;$cntR++)
                                {
                                    if($bookRezerwacje[$cntR-1]['id_czytelnik']==$userId)
                                    {
                                        $pozycjaNa_l_rezerwacji=$cntR;
                                    }
                                }
                                
                                $numerWKolejce =-1*( $l_dostepnych-$pozycjaNa_l_rezerwacji);
                                if($numerWKolejce>0)
                                {
                                    echo "<b>$numerWKolejce</b>. w kolejce oczekujących";
                                }

                                if ($_SESSION['type'] == 'admin'&&(!($numerWKolejce>0))) : 
                                ?>
                                    <a class="button" href="?action=rent-book&id_rezerwacja=<?php echo $rezerwacja['id_rezerwacja']; ?>&userId=<?php echo $rezerwacja['id_czytelnik']; ?>&bookId=<?php echo $rezerwacja['id_ksiazka']; ?>&returnTo=borrowed">Wydaj książkę</a>
                                <?php
                                endif;
                                ?>

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