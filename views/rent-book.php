<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php
$title = 'Wydaj książkę: '.$bookData['tytul'].' </br> użytkownikowi: '.$userData['login'];

showHead($title, ""); ?>

<body>

    <?php

    showHeader($title, ""); ?>
    <?php
    showButtons('rent-book');


    ?>
    <div class="center">

        <?php
        if ($userData) {
        ?>
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



        if($egzemplarze)
        {
            ?>
                    <h2>Wybierz egzemplarz do wydania użytkownikowi</h2>
                    <table class="egz-info">
                        <thead>
                            <th>Id</th>
                            <th>Akcja</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($egzemplarze as $egzemplarz)
                            {
                                echo "<tr>";
                                echo "<td>" . $egzemplarz['id_egzemplarza'] . "</td>";
                                echo "<td>";
                                ?>
<a class="button" href="?action=rent-book&id_rezerwacja=<?php echo $id_rezerwacja; ?>&userId=<?php echo $userId; ?>&bookId=<?php echo $bookId;?>&returnTo=borrowed&id_egzemplarza=<?php echo $egzemplarz['id_egzemplarza'];?>">Wydano ten egzemplarz</a>
                                <?php            
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                }
        ?>
    </div>
</body>
</html>