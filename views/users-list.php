<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
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
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Login</th>
                        <th>Wiek</th>
                        <th>Uprawnienia</th>
                        <th>Akcja</th>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($usersList as $user) {;
                        ?>
                            <tr>
                                <td><?php echo ++$index; ?></td>
                                <td><?php echo $user['name'] ?></td>
                                <td><?php echo $user['surname'] ?></td>
                                <td><?php echo $user['login'] ?></td>
                                <td><?php echo $user['age'] ?></td>
                                <td><?php echo translateUserType($user['type']); ?></td>
                                <td><a href="?action=user-edit&userId=<?php echo $user['id'];?>">Edytuj</a>
                                    <a href="?action=user-delete&userId=<?php echo $user['id'];?>">Usuń</a>
                                   <?php if ($user['type']=="reader"){?><a href="?action=borrowed-books&userId=<?php echo $user['id'];?>">Pożyczone (<?php echo $user['numOfBorrowedByUser'];?>)</a><?php }?></td>
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