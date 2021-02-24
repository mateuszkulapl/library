<?php

/**
 *wyswietla html head
 *@param null|string $title tresc tagu title
 *@param null|string $description tresc tagu meta description i og:description
 *@param null|string $robots tresc tagu meta robots
 */
function showHead($title = null, $description = null, $robots = "index")
{
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if ($title) { ?><title><?php echo $title . siteName; ?></title>
            <meta property="og:title" content="<?php echo $title; ?>" /><?php } ?>

        <?php if ($description) { ?>
            <meta name="description" content="<?php echo $description; ?>">
            <meta property="og:description" content="<?php echo $description; ?>" /><?php } ?>

        <meta name="robots" content="<?php echo $robots; ?>" />
        <link rel="stylesheet" href="./views/styles/style.css">
        <script>
            function addAllertCloseButtonListener() {
                var closeButtons = document
                    .getElementById("alerts")
                    .getElementsByClassName("close");
                for (var i = 0; i < closeButtons.length; i++) {
                    closeButtons[i].addEventListener("click", function() {
                        this.parentElement.classList.add("closed");
                    });
                }
            }
        </script>
    </head>
    <?php

}
/**
 *wyswietla header, jeśli co najmniej jeden parametr nie jest równy null
 *@param null|string $heading naglowej h1 strony
 *@param null|string $subHeading opis strony
 */
function showHeader($heading = null, $subHeading = null)
{
    if ($heading || $subHeading) {
    ?>
        <header><?php
                if ($heading) echo "<h1>$heading</h1>";
                if ($subHeading) echo "<p>$subHeading</p>";
                ?>
        </header>
    <?php
    }
    renderAlerts();
}

function showButton($page, $active)
{
    ?>
    <a href="index.php?action=<?php echo $page['page']; ?>" <?php if ($active == $page['page']) {
                                                                echo "class=\"active\"";
                                                            } ?>><?php echo $page['name']; ?></a>
    <?php
}

/**
 *wyswietlenie div.message jeśli message różne od null
 *@param array $activePage aktualna strona
 */
function showButtons($activePage)
{
    $allowedPages = getAllowedSites();

    if (sizeof($allowedPages) > 0) {
    ?><nav class="buttons">
            <?php
            foreach ($allowedPages as $page) {
                showButton($page, $activePage);
            }
            ?>
        </nav>
    <?php
    }
}

/**
 *wyswietlenie div#message jeśli message różne od null
 *@param null|string $message wiadomosc wyswietlana
 *@param string $className dodatkowa nazwa klasu elementu div#message, wplywajaca na kolor
 */
function showMessage($message = null, $className = "warning")
{
    if ($className == null)
        $className = "warning";
    if ($message) {
    ?>
        <div id="message" class="center <?php echo $className; ?>">
            <?php if ($message) {
                echo "<p>$message</p>";
            }
            ?>
        </div>
<?php
    }
}