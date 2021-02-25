<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Dodaj użytkownika", "Dodaj użytkownika", "noindex"); ?>

<body>
    <?php showHeader("Dodaj użytkownika"); ?>
    <?php
    showButtons('user-add');
    if ($message)
        showMessage($message, $messageType);
    ?>

    <div class="center">
        <form action="index.php?action=user-add" method="POST">
            <label>Imie<br>
                <input type="text" name="name" id="name"  required autofocus autocomplete="off">
            </label><br>
            <label>Nazwisko<br>
                <input type="text" name="surname" id="surname" required autocomplete="off">
            </label><br>
            <label>Nazwa użytkownika<br>
                <input type="text" name="login" id="login" required autocomplete="off">
            </label><br>
            <label>Hasło<br>
                <input type="password" name="password" id="password" required autocomplete="new-password">
            </label><br>
            <label>Rola<br>
                <select name="type" id="type" required>
                    <option value="admin">Administrator</option>
                    <option value="reader">Czytelnik</option>
                </select>
            </label><br>
            <label>Data urodzenia<br>
                <input type="date" name="birthday" id="birthday" required autocomplete="off">
            </label><br>
            <input type="hidden" name="action" value="add">
            <input type="submit" value="Dodaj użytkownika">`
        </form>
    </div>
</body>

</html>