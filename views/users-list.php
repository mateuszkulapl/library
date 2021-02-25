<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Wyświetl użytkowników", "Zobacz użytkowników", "noindex"); ?>

<body>
    <?php showHeader("Wyświetl użytkowników", "Zobacz użytkowników"); ?>
    <?php
    showButtons('users-list');
    if ($message)
        showMessage($message, $messageType);

    ?>
    <div class="center">
        <?php

        if ($usersList == false) {
        } else {
            if (!(count($usersList) > 0)) {
                echo "Brak użytkowników.";
            } else {
        ?>
                <table id="list" class="full-width simple-border th-small-pd">
                    <thead class="invert">
                        <th>Lp</th>
                        <th>Login</th>
                        <th>E-mail</th>
                        <th>Telefon</th>
                        <th>Data urodzenia</th>
                        <th>Akcja</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($usersList as $user) {;
                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php echo $user['login'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><?php echo $user['telefon'] ?></td>
                                <td><?php echo $user['data_urodzenia'] ?></td>
                                <td>
                                    <a class="button" href="?action=user-edit&userId=<?php echo $user['id_czytelnik']; ?>">Edytuj</a>
                                    <a class="button" href="?action=user-delete&userId=<?php echo $user['id_czytelnik']; ?>">Usuń</a>
                                    <a class="button" href="?action=borrowed-books&userId=<?php echo $user['id_czytelnik']; ?>">Pożyczone</a>
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