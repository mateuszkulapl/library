<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php');
showHead("Home", null, "noindex"); ?>

<body>
    <?php
    showHeader("Home");
    showButtons('home');
    if ($message)
        showMessage($message, $messageType);

    ?>
</body>

</html>