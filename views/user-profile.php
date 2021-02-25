<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php
$title = "";
if ($userData && $userData["login"]) {
    $title = $userData["login"];
};
showHead($title, ""); ?>

<body>

    <?php

    showHeader($title, "Szczegóły konta"); ?>
    <?php
    showButtons('user');
    if ($message)
        showMessage($message, $messageType);

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
                <tr>
                    <td>Książki użytkownika</td>
                    <td><a class="button" href="?action=borrowed-books&userId=<?php echo $userId; ?>">Zobacz</a></td>
                </tr>
            </table>

        <?php

        } else {
            "Wystąpił błąd. Nie znaleziono użytkownika";
        }
        ?>

    </div>
</body>

</html>