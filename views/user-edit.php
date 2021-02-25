<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Edytuj użytkownika", "Edytuj użytkownika", "noindex"); ?>

<body>
    <?php showHeader("Edytuj użytkownika"); ?>
    <?php
    showButtons('user-edit');
    if ($message)
        showMessage($message, $messageType);
    ?>

    <div class="center">
        <?php if ($userToEdit != false) { ?>
            <form action="index.php?action=user-edit" method="POST">
                <label>Login<br>
                    <input type="text" name="name" id="name" disabled="disabled" value="<?php echo $userToEdit['login']; ?>" required autofocus autocomplete="off">
                </label><br>
                <label>E-mail<br>
                    <input type="email" minlength="4" maxlength="30" name="email" id="email" value="<?php echo $userToEdit['email']; ?>" required autocomplete="off">
                </label><br>
                <label>Telefon<br>
                    <input type="text" pattern="(\d{9})|(\+\d{11}$)" name="telefon" id="telefon" value="<?php echo $userToEdit['telefon']; ?>" required autocomplete="off">
                </label><br>
                <label>Hasło (uzupełnij, jeśli chcesz zmienić)<br>
                    <input type="password" pattern="()|(^.{4,30}$)" maxlength="30" name="password" title="Hasło od 4 do 30 znaków" id="password" autocomplete="new-password">
                </label><br>
                <label>Data urodzenia<br>
                    <input type="date" name="data_urodzenia" id="data_urodzenia" value="<?php echo $userToEdit['data_urodzenia']; ?>" required autocomplete="off">
                </label><br>
                <script type="text/javascript">
                    data_urodzenia.max = new Date().toISOString().split("T")[0];
                </script>
                <input type="hidden" name="userId" value="<?php echo $userToEdit['id_czytelnik']; ?>">
                <input type="submit" value="Zapisz użytkownika">`
            </form>

        <?php } ?>
    </div>
</body>

</html>