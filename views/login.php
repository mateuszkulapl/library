<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php'); ?>
<html lang="pl">
<?php showHead("Zaloguj", "zaloguj się na konto"); ?>

<body>
    <?php showHeader("Zaloguj się", "Zaloguj się na swoje konto, aby uzyskać dostęp do aplikacji."); ?>
    <?php
    if ($message)
        showMessage($message, $messageType);
    showButtons('login');
    ?>
    <div class="center">
        <form action="index.php?action=login" method="post">
            <label>login:<br><input type="text" name="login" id="login" required></label><br>
            <label>password:<br><input type="password" name="password" id="password" required></label><br>
            <input type="submit" value="Zaloguj się">
        </form>
    </div>
</body>

</html>