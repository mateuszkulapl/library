<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php
$title = 'Zwrot książki: '.$bookData['tytul'].' </br> od użytkownika: '.$userData['login'];

showHead("Zwróć książkę", ""); ?>

<body>

    <?php

    showHeader("Zwrot", ""); ?>
    <?php
    showButtons('return-book');


    ?>
    <div class="center">
<h1><?php echo $title;?></h1>
        <?php
        if ($userData) {
        ?>
        <h2>Dane użytkownika</h2>
            <table class="book-info">
                <tr>
                    <td>Login</td>
                    <td><?php echo $userData['login']; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $userData['email']; ?></td>
                </tr>
                <tr>
                    <td>Telefon</td>
                    <td><?php echo $userData['telefon']; ?></td>
                </tr>
                <tr>
                    <td>Data urodzenia</td>
                    <td><?php echo $userData['data_urodzenia']; ?></td>
                </tr>
            </table>

        <?php

        } else {
            "Wystąpił błąd. Nie znaleziono użytkownika";
        }
?>
        <div class="two-buttons">

        
        <a class="button red" href="?confirm=0&action=return-book&id_wypozyczenie=<?php echo $id_wypozyczenie; ?>&userId=<?php echo $userId; ?>&bookId=<?php echo $bookId;?>&returnTo=borrowed&id_egzemplarza=<?php echo $id_egzemplarza;?>">Anuluj
        </a>
        <a class="button green" href="?confirm=1&action=return-book&id_wypozyczenie=<?php echo $id_wypozyczenie; ?>&userId=<?php echo $userId; ?>&bookId=<?php echo $bookId;?>&returnTo=borrowed&id_egzemplarza=<?php echo $id_egzemplarza;?>">egzemplarz o id <?php echo $id_egzemplarza;?></br>Potwierdzam zwrot
        </a>
        </div>
    </div>
</body>
</html>