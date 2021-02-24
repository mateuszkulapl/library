<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Edytuj użytkownika", "Edytuj użytkownika", "noindex"); ?>

<body>
    <?php showHeader("Edytuj użytkownika"); ?>
    <?php
    showButtons('book-add');
    if ($message)
        showMessage($message, $messageType);
    ?>

    <div class="center">
    <?php if($userToEdit!=false){?>
        <form action="index.php?action=user-edit" method="POST">
            <label>Imie<br>
                <input type="text" name="name" id="name" value="<?php echo $userToEdit['name']; ?>" required autofocus autocomplete="off">
            </label><br>
            <label>Nazwisko<br>
                <input type="text" name="surname" id="surname" value="<?php echo $userToEdit['surname']; ?>" required autocomplete="off">
            </label><br>
            <label>Nazwa użytkownika<br>
                <input type="text" name="login" id="login" value="<?php echo $userToEdit['login']; ?>" required autocomplete="off">
            </label><br>
            <label>Hasło (uzupełnij, jeśli chcesz zmienić)<br>
                <input type="password" name="password" id="password" autocomplete="new-password">
            </label><br>
            <label>Rola<br>
                <select name="type" id="type" required>
                    <option value="admin" <?php if($userToEdit['type']=='admin') echo ' selected="selected"'?>>Administrator</option>
                    <option value="reader" <?php if($userToEdit['type']=='reader') echo ' selected="selected"'?>>Czytelnik</option>
                </select>
            </label><br>
            <label>Data urodzenia<br>
                <input type="date" name="birthday" id="birthday" value="<?php echo $userToEdit['birthday']; ?>" required autocomplete="off">
            </label><br>
            <input type="hidden" name="userId" value="<?php echo $userToEdit['id']; ?>">
            <input type="submit" value="Zapisz użytkownika">`
        </form>
    <?php }?>
    </div>
</body>

</html>