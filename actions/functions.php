<?php

/**
 * Dodaje alert do tabeli z alertami
 *
 * @param string $wiadomosć wyświetlana
 * @param string $type rodzaj wiadomości (info/warning/success/error)
 * @param boolean $showOnlyInDebugMode wiadomosc zostanie wyświetlona tylko w trybie debugowania
 * @param boolean $backtrace
 * @return void
 */
function addAlert($message, $type = "info", $showOnlyInDebugMode = false, $backtrace = null)
{
    require_once _ROOT_PATH . DIRECTORY_SEPARATOR . 'class'.DIRECTORY_SEPARATOR . 'Alert.php';
    $newAlert = new Alert($message, $type, $showOnlyInDebugMode, $backtrace);
    if (isset($_SESSION['alerts']))
        $alerts = unserialize($_SESSION['alerts']);
    else
        $alerts = [];
    array_push($alerts, $newAlert);
    $_SESSION['alerts'] = serialize($alerts);
}

function renderAlerts()
{
    if (isset($_SESSION['alerts'])) {
        require_once _ROOT_PATH . DIRECTORY_SEPARATOR . 'class'.DIRECTORY_SEPARATOR . 'Alert.php';
        $alerts = unserialize($_SESSION['alerts']);
        if (count($alerts) > 0) {
?>
            <div id="alerts">
                <?php
                foreach ($alerts as $index => $alert) {
                    $alert->render($index);
                }
                ?>
            </div>
            <script>
                addAllertCloseButtonListener();
            </script>
<?php
        }
        unset($_SESSION['alerts']);
    }
}


/**
 *przekierowanie do strony logowania z opcjonalna wiadomoscia.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok)
 */
function redirectToLoginPage($message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    }
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: index.php?action=login");
    exit();
}

function redirectToBookPage($bookId, $message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    }
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: index.php?action=book&bookId=$bookId");
    exit();
}

function redirectToRezerwacjePage($userId, $message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    }
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: index.php?action=borrowed-books&userId=$userId");
    exit();
}

/**
 *przekierowanie do strony logowania z opcjonalna wiadomoscia  z kodem 403
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok)
 */
function redirectToHomePage403($message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    } else {
        addAlert("Nie masz uprawnień do tej strony.","error");
    }
    header("HTTP/1.1 403 Forbidden");
    header("Location: index.php?action=home");
    exit();
}


/**
 *zwraca dozwolone linki na podstawie zalogowanego użytkownika
 */
function getAllowedSites()
{
    $allowedPages = []; //tablica z dozwolonymi wartosciami


    if (isset($_SESSION['type'])) {
        if ($_SESSION['type'] == "admin") {

            array_push($allowedPages, array('page' => 'home', 'name' => 'Strona główna'));
            array_push($allowedPages, array('page' => 'books-list', 'name' => 'Lista książek'));
            array_push($allowedPages, array('page' => 'book-add', 'name' => 'Dodaj książkę'));
            array_push($allowedPages, array('page' => 'users-list', 'name' => 'Lista użytkowników'));
            array_push($allowedPages, array('page' => 'user-add', 'name' => 'Dodaj użytkownika'));
        } else {
            if ($_SESSION['type'] == "reader") {
                array_push($allowedPages, array('page' => 'books-list', 'name' => 'Zobacz książki'));
                array_push($allowedPages, array('page' => 'borrowed-books', 'name' => 'Twoje książki'));
            }
        }
    }

    if (!isset($_SESSION['userId']))
        array_push($allowedPages, array('page' => 'login', 'name' => 'Zaloguj'));
    else {
        array_push($allowedPages, array('page' => 'logout', 'name' => 'Wyloguj'));
    }
    return $allowedPages;
}


/**
 *dodaje text do zmiennej sesyjnej, jeśli istneije, lubtworzy jeśli nie istnieje
 *@param string $name nazwa zmiennej sesyjnej
 *@param string $text tresc dodawana
 */
function appendToSessionVariable($name, $text)
{
    if (isset($_SESSION[$name]))
        $_SESSION[$name] .= $text;
    else
        $_SESSION[$name] = $text;
}


/**
 *przekierowanie do strony głównej z menu.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok)
 */
function redirectToHomePage($message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    }
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: index.php?action=home");
    exit();
}

/**
 *przekierowanie do strony z lista uzytkownikow z opcjonalna wiadomoscia.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok).
 */
function redirectToUsersList($message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    }
    header("HTTP/1.1 404 Not Found");
    header("Location: index.php?action=users-list");
    exit();
}

/**
 *przekierowanie do strony z lista ksiazek z opcjonalna wiadomoscia.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok).
 */
function redirectToBooksList($message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    }
    header("HTTP/1.1 404 Not Found");
    header("Location: index.php?action=books-list");
    exit();
}

/**
 *przekierowanie do strony z lista wypozyczonych ksiazek z opcjonalna wiadomoscia.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok).
 */
function redirectToBorrowedBooksList($message = null, $messageType = null)
{
    if ($message) {
        addAlert($message,$messageType);
    }
    header("HTTP/1.1 404 Not Found");
    header("Location: index.php?action=borrowed-books");
    exit();
}



/**
 *przekierowanie do strony logowania, jesli uzytkownik nie jest zalogowany.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok)
 */
function redirectIfNotLoggedIn($message = "Musisz być zalogowany", $messageType = "warning")
{
    if (!isset($_SESSION['type'])) {
        redirectToLoginPage($message, $messageType);
    }
}

/**
 *przekierowanie do strony glownej, jesli uzytkownik nie jest adminem.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 *@param null|string $messageType typ wiadomosci powodujacy okreslony kolor (warning/alert/ok)
 */
function redirectIfNotAdmin($message = "Nie masz uprawnień do tej strony.", $messageType = "error")
{
    if (isset($_SESSION['type']) && $_SESSION['type'] != 'admin') {
        redirectToLoginPage($message, $messageType);
    }
}



/**
 *przekierowanie do strony glownej, jesli uzytkownik jest zalogowany.
 *@param null|string $message wiadomosc wyswietlana na stronie logowania po przekierowaniu.
 */
function redirectIfLoggedIn($message = "Jesteś już zalogowany", $messageType = "alert")
{
    if (isset($_SESSION['id'])) {
        redirectToHomePage($message, $messageType);
    }
}

/**
 *usuwanie komunikatu, aby nie wyswietlal sie ponownie po odswiezeniu strony.
 */
function deleteMessage()
{
    unset($_SESSION['message']);
    unset($_SESSION['messageType']);
}


/**
 *zwraca nazwe pliku bez rozszerzenia (po ostatniej kropce)
 *@param string $filename nazwa pliku z rozszerzeniem
 */
function getFileNameWithoutExtension($filename)
{
    $fileNameArray = (explode('.', $filename));
    array_pop($fileNameArray);
    $fileName = implode('.', $fileNameArray);
    return $fileName;
}

/**
 *zwraca rozszerzenie pliku (po ostatniej kropce).
 *@param string $filename nazwa pliku z rozszerzeniem.
 *@return string rozszerzenie.
 */
function getFileExtension($filename)
{
    $fileNameArray = (explode('.', $filename));
    $extension = end($fileNameArray);
    return $extension;
}

function getMessage()
{
    $message = null;
    $messageType = null;
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    }
    return $message;
}

function getMessageType()
{
    $messageType = null;
    if (isset($_SESSION['messageType']))
        $messageType = $_SESSION['messageType'];
    return $messageType;
}


/**
 *konwersja wielkosci pliku
 *skopiowano z https://gist.github.com/liunian/9338301 .
 *@author https://gist.github.com/redecs
 */
function human_filesize($size, $precision = 2)
{
    $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $step = 1024;
    $i = 0;
    while (($size / $step) > 0.9) {
        $size = $size / $step;
        $i++;
    }
    return round($size, $precision) . $units[$i];
}


/**
 *hashowanie hasel
 *@param string $data dane do zahaszowania
 */
function getHashed($data)
{
    return md5($data);
}

/**
 *tlumaczenie upranwnieni uzytkownika
 *@param string $type typ użytkownika
 */
function translateUserType($type)
{

    if ($type == 'admin')
        return 'Administrator';
    else
    if ($type == 'reader')
        return 'Czytelnik';
    else
        return $type;
}
