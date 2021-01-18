<!DOCTYPE html>
<?php require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'parts' . DIRECTORY_SEPARATOR  . 'showPart.php');
showHead("Nie znaleziono", null, "noindex"); ?>

<body>
    <?php
    showHeader("Nie znaleziono");
    showButtons('404');
    showMessage("Nie znaleziono strony.", 'warning');
    ?>
</body>

</html>