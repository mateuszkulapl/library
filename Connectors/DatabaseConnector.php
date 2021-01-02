<?php
include(_ROOT_PATH . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'config.php');


function getdbconnector()
{
    $pdo = false;
    try {
        $pdo = new PDO('mysql:host=' . host . ';dbname=' . dbname, user, pass);
    } catch (PDOException $e) {
        showDebugMessage("can not create pdo connection. PDO create error: " . $e->getMessage());
        return false;
    }
    return $pdo;
}

/**
 *sprawdzanie hasla dla uzytkownika
 *@param string $login nazwa użytkownika
 *@param string $password zahaszowane haslo
 *@return bool czy poprawne haslo.
 */
function checkPassword($login, $password)
{
    $dbc = getdbconnector();
    if ($dbc != false) {
        $approved = false;
        try {
            $stmt = $dbc->prepare('SELECT count(*) AS "numOfUsers" from users WHERE login=:login AND password=:password  AND active=1');
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':password', $password,);

            if ($stmt->execute() == false) {
                $dbc = null;
                return false;
            } else {
                $row = $stmt->fetch();
                $numOfUsers = $row["numOfUsers"];
                if ($numOfUsers == 1);
                $approved = true;
            }
        } catch (PDOException $e) {
            showDebugMessage("can not login. DB query error: " . $e->getMessage());
            return false;
        }
        return $approved;
    }
    return false;
}

/**
 *sprawdzanie typu uzytkownika
 *funkcja nie sprawdza, czy wystepuja duplikaty
 *@param string $login nazwa użytkownika
 *@param string $password zahaszowane haslo
 *@param bool $checkPassword sprawdza haslo
 *@return false/string typ użytkownika.
 */
function getUserType($login, $password, $checkPassword)
{
    $dbc = getdbconnector();
    $type = false;
    if ($dbc != false) {
        try {
            if ($checkPassword) {
                $stmt = $dbc->prepare('SELECT type from users WHERE login=:login AND password=:password  AND active=1');
                $stmt->bindValue(':password', $password);
            } else
                $stmt = $dbc->prepare('SELECT type from users WHERE login=:login AND active=1');

            $stmt->bindValue(':login', $login);
            if ($stmt->execute() == false) {
                $type = false;
            } else {
                if ($stmt->rowCount() > 0)
                    $type = $stmt->fetch(PDO::FETCH_ASSOC)["type"];
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not check usertype. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $type;
}


/**
 *zwraca id uzytkownika
 *@param string $login nazwa użytkownika
 */
function getUserId($login)
{
    $dbc = getdbconnector();
    $type = false;
    if ($dbc != false) {
        try {
            $stmt = $dbc->prepare('SELECT id from users WHERE login=:login AND active=1');

            $stmt->bindValue(':login', $login);
            if ($stmt->execute() == false) {
                $id = false;
            } else {
                if ($stmt->rowCount() > 0)
                    $id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get userID. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $id;
}

/**
 *pobieranie listy uzytkownikow
 *@return false/string typ użytkownika.
 */
function getAllUsers()
{
    $dbc = getdbconnector();
    $users = false;
    if ($dbc != false) {

        try {
            $sql = 'SELECT users.id AS id, name, surname, login, YEAR(CURDATE()) - YEAR(birthday) AS age, type, 
            (select count(*) from borrows where borrows.`user-id` =users.id) as numOfBorrowedByUser
            FROM users
            LEFT JOIN borrows 
            ON users.id=borrows.`user-id`
            WHERE users.active=1
            GROUP BY users.id
            ORDER BY id';

            $stmt = $dbc->prepare($sql);
            if ($stmt->execute() == false) {
                showDebugMessage("getAllUsers execute returned false: ");
                $users = false;
            } else {
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC); //pusta tablica, jesli nie ma uzytkownikow
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get userlist from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $users;
}


/**
 *pobieranie wszystkich danych uzytkownika
 *@return false/string false jesli nie znaleziono/ user
 */
function getUser($userId)
{
    $dbc = getdbconnector();
    $user = false;
    if ($dbc != false) {
        try {
            $sql = 'SELECT * FROM users WHERE active=1 AND id=:id';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $userId);
            if ($stmt->execute() == false) {
                showDebugMessage("getUser execute returned false: ");
                $user = false;
            } else {
                $rowCount = $stmt->rowCount();
                if ($rowCount == 1)
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                else {
                    showDebugMessage('get user query returned ' . $rowCount . ' row(s) for user id=' . $userId . '. ');
                }
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get user from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $user;
}


/**
 *aktualizuje użytkownika z bazy
 *@param string $id identyfikator
 *@param string $name imie
 *@param string $login nazwa użytkownika
 *@param string $password haslo
 *@param string $birthday data urodzenia w formacie yyyy-mm-dd
 *@param string $type rola użytkownika
 *@param bool $updatePass
 *@param bool $isPasswordHashed przeslane haslo jest zahaszowane
 *@return bool zwraca informacje czy zaktualizowano
 */
function updateUser($id, $name, $surname, $login, $password, $birthday, $type, $updatePass, $isPasswordHashed = false)
{
    $dbc = getdbconnector();
    $done = false;
    if ($dbc != false) {

        if ($updatePass && !$isPasswordHashed)
            $password = getHashed($password);
        try {
            if ($updatePass)
                $sql = 'UPDATE `users` SET 
            `name` =:name, 
            `surname` =:surname,
            `login` =:login,
            `password` =:password,
            `birthday` =:birthday,
            `type` =:type
            WHERE active=1 AND id=:id';
            else
                $sql = 'UPDATE `users` SET `name` =:name, 
            `surname` =:surname,
            `login` =:login,
            `type` =:type,
            `birthday` =:birthday
            WHERE active=1 AND id=:id';

            $stmt = $dbc->prepare($sql);

            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':surname', $surname);
            $stmt->bindValue(':type', $type);
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':birthday', $birthday);

            if ($updatePass)
                $stmt->bindValue(':password', $password);

            if ($stmt->execute() == false) {
                showDebugMessage("cannot update user id: " . $id);
            } else {
                $done = true;
            }
        } catch (PDOException $e) {
            showDebugMessage("can not get user from db. DB query error: " . $e->getMessage());
        }
        $dbc = null;
    }
    return $done;
}





/**
 *aktualizuje użytkownika z bazy
 *@param string $id identyfikator
 *@param string $name imie
 *@param string $login nazwa użytkownika
 *@param string $password haslo
 *@param string $birthday data urodzenia w formacie yyyy-mm-dd
 *@param bool $isPasswordHashed przeslane haslo jest zahaszowane
 *@return bool zwraca informacje czy zaktualizowano
 */
function insertUser($name, $surname, $login, $password, $birthday, $type, $isPasswordHashed = false)
{
    $dbc = getdbconnector();
    $done = false;
    if ($dbc != false) {

        if (!$isPasswordHashed)
            $password = getHashed($password);
        try {
            $sql = 'INSERT INTO `users` VALUES (NULL, :name, :surname, :login, :password, :type, :birthday, "1");';

            $stmt = $dbc->prepare($sql);

            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':surname', $surname);
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':birthday', $birthday);
            $stmt->bindValue(':type', $type);
            $stmt->bindValue(':birthday', $birthday);
            $stmt->bindValue(':password', $password);

            if ($stmt->execute() == false) {
                showDebugMessage("cannot insert user. login: " . $login);
            } else {
                $done = true;
            }
        } catch (PDOException $e) {
            showDebugMessage("can not insert user. DB query error: " . $e->getMessage());
        }
        $dbc = null;
    }
    return $done;
}



/**
 *usuwanie uzytkownika
 *@return bool czy usuwanie sie powiodlo
 */
function deleteUser($userId)
{
    deleteUserBorrows($userId);//przed usunieciem zwraca ksiazki
    $dbc = getdbconnector();
    $deleted = false;
    if ($dbc != false) {
        try {
            $sql = 'DELETE FROM users WHERE active=1 AND id=:id'; //UPDATE users SET ACTIVE=0 WHERE...

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $userId);
            if ($stmt->execute() == false) {
                showDebugMessage("deleteUser execute returned false: ");
                $deleted = false;
            } else {
                $deleted = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not delete user from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $deleted;
}


/**
 *usuwanie ksiazki
 *@return bool czy usuwanie sie powiodlo
 */
function deleteBook($bookId)
{
    deleteBookBorrows($bookId);
    $dbc = getdbconnector();
    $deleted = false;
    if ($dbc != false) {
        try {
            $sql = 'DELETE FROM books WHERE id=:id'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $bookId);
            if ($stmt->execute() == false) {
                showDebugMessage("deleteBook execute returned false: ");
                $deleted = false;
            } else {
                $deleted = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not delete book from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $deleted;
}


/**
 *pobieranie listy uzytkownikow
 *@param int $userId ud uzytkownika dla ktorego w tabeli zostanie zwrocona liczba wypozyczonych ksiazek
 *@return false/string typ użytkownika.
 */
function getAllBooks($userId=0)
{
    $dbc = getdbconnector();
    $books = false;
    if ($dbc != false) {

        try {
            $sql = 'SELECT books.id AS id, title, author, publishingHouse, year, inventory, `books`.`image`,
            COUNT(borrows.id) as numOfBorrowed,
            inventory-COUNT(borrows.id) as numOfAvailable,
            (select count(*) from borrows where borrows.`user-id` = :userId AND borrows.`book-id`=books.id) as numOfBorrowedByUser
            FROM books
            LEFT JOIN BORROWS
            ON BOOKS.id=borrows.`book-id`
            GROUP BY `books`.`id` ORDER BY title ASC, year DESC';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            if ($stmt->execute() == false) {
                showDebugMessage("getAllBooks execute returned false: ");
                $books = false;
            } else {
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC); //pusta tablica, jesli nie ma uzytkownikow
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get all books from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $books;
}



/**
 *wstawianie ksiazki do bazy
 *@param string $title tytul
 *@param string $author autorzy
 *@param string $publishingHouse wydawnictwo
 *@param string $year rok wydania
 *@param string $inventory liczba egzemplarzy
 *@param bool $uploadedFile sciezka okladki
 *@return bool zwraca informacje czy zaktualizowano
 */
function insertBook($title, $author, $publishingHouse, $year, $inventory, $uploadedFile)
{

    $dbc = getdbconnector();
    $done = false;
    if ($dbc != false) {

        try {
            $sql = 'INSERT INTO `books` (`title`, `author`, `publishingHouse`, `year`, `inventory`, `available`, `image`)
            VALUES (:title, :author, :publishingHouse, :year, :inventory, :inventory, :uploadedFile);';

            $stmt = $dbc->prepare($sql);

            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':author', $author);
            $stmt->bindValue(':publishingHouse', $publishingHouse);
            $stmt->bindValue(':year', $year, PDO::PARAM_INT);
            $stmt->bindValue(':inventory', $inventory, PDO::PARAM_INT);

            if ($uploadedFile != false)
                $stmt->bindValue(':uploadedFile', $uploadedFile);
            else
                $stmt->bindValue(':uploadedFile', NULL, PDO::PARAM_INT);

            if ($stmt->execute() == false) {
                showDebugMessage("cannot insert book.");
            } else {
                $done = true;
            }
        } catch (PDOException $e) {
            showDebugMessage("can not insert book. DB query error: " . $e->getMessage());
        }
        $dbc = null;
    }
    return $done;
}




/**
 *wstawianie ksiazki do bazy
 *@param string $id identyfikator
 *@param string $title tytul
 *@param string $author autorzy
 *@param string $publishingHouse wydawnictwo
 *@param string $year rok wydania
 *@param string $inventory liczba egzemplarzy
 *@param bool $uploadedFile sciezka okladki
 *@param bool $updateImg aktualizowac okladke
 *@return bool zwraca informacje czy zaktualizowano
 */
function updateBook($id, $title, $author, $publishingHouse, $year, $inventory, $image, $updateImg = false)
{
    $dbc = getdbconnector();
    $done = false;
    if ($dbc != false) {

        try {
            if ($updateImg)
                $sql = 'UPDATE `books` SET 
            `title` =:title, 
            `author` =:author,
            `publishingHouse` =:publishingHouse,
            `year` =:year,
            `inventory` =:inventory,
            `available` =:available,
            `image` =:uploadedFile. 
            WHERE id=:id';
            else
                $sql = 'UPDATE `books` SET 
            `title` =:title, 
            `author` =:author,
            `publishingHouse` =:publishingHouse,
            `year` =:year,
            `inventory` =:inventory,
            `available` =:available
            WHERE id=:id';

            $stmt = $dbc->prepare($sql);

            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':author', $author);
            $stmt->bindValue(':publishingHouse', $publishingHouse);
            $stmt->bindValue(':year', $year);
            $stmt->bindValue(':inventory', $inventory);
            $stmt->bindValue(':available', $inventory);


            if ($updateImg)
                $stmt->bindValue(':uploadedFile', $image);

            if ($stmt->execute() == false) {
                showDebugMessage("cannot update book id: " . $id);
            } else {
                $done = true;
            }
        } catch (PDOException $e) {
            showDebugMessage("can not update book. DB query error: " . $e->getMessage());
        }
        $dbc = null;
    }
    return $done;
}

/**
 *pobieranie wszystkich danych uzytkownika
 *@return false/string false jesli nie znaleziono/ user
 */
function getBook($bookId)
{
    $dbc = getdbconnector();
    $user = false;
    if ($dbc != false) {
        try {
            $sql = 'SELECT * FROM books WHERE id=:id';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $bookId);
            if ($stmt->execute() == false) {
                showDebugMessage("getBook execute returned false: ");
                $user = false;
            } else {
                $rowCount = $stmt->rowCount();
                if ($rowCount == 1)
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                else {
                    showDebugMessage('getBook query returned ' . $rowCount . ' row(s) for book id=' . $bookId . '. ');
                }
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not getBook from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $user;
}


/**
 *usuwanie ksiazki
 *@return bool czy usuwanie sie powiodlo
 */
function insertBorrow($bookId, $userId)
{
    $borrowed = false;
    if (getBook($bookId) != false) {

        $dbc = getdbconnector();

        if ($dbc != false) {
            try {
                $sql = 'INSERT INTO `borrows` ( `book-id`, `user-id`) VALUES ( :bookId, :userId);'; //UPDATE books SET ACTIVE=0 WHERE...
                $stmt = $dbc->prepare($sql);
                $stmt->bindValue(':bookId', $bookId);
                $stmt->bindValue(':userId', $userId);
                if ($stmt->execute() == false) {
                    showDebugMessage("INSERT INTO borrows execute returned false: ");
                    $borrowed = false;
                } else {
                    $borrowed = true;
                }
                $dbc = null;
            } catch (PDOException $e) {
                showDebugMessage("can not delete book from db. DB query error: " . $e->getMessage());
                return false;
            }
        }
    }
    return $borrowed;
}


/**
 *pobieranie listy uzytkownikow
 *@return false/string typ użytkownika.
 */
function getBorrowedBooks($userId)
{
    $dbc = getdbconnector();
    $books = false;
    if ($dbc != false) {

        try {
            $sql = 'SELECT borrows.id, books.title, books.author, books.publishingHouse, books.year
            FROM borrows
            LEFT JOIN BOOKS
            ON borrows.`book-id`=books.`id`
            WHERE borrows.`user-id`=:userId ORDER BY title ASC';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            if ($stmt->execute() == false) {
                showDebugMessage("getBorrowedBooks execute returned false: ");
                $books = false;
            } else {
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC); //pusta tablica, jesli nie ma uzytkownikow
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get borrowed books from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $books;
}


/**
 *zwraca ksiazke
 *@return bool czy zwracanie sie powiodlo
 */
function deleteBorrow($borrowId)
{
    $dbc = getdbconnector();
    $deleted = false;
    if ($dbc != false) {
        try {
            $sql = 'DELETE FROM borrows WHERE id=:id'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $borrowId);
            if ($stmt->execute() == false) {
                showDebugMessage("deleteBorrow execute returned false: ");
                $deleted = false;
            } else {
                $deleted = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not delete borrow from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $deleted;
}

/**
 *zwraca ksiazki uzytkownika
 *@return bool czy zwracanie sie powiodlo
 */
function deleteUserBorrows($userID)
{
    $dbc = getdbconnector();
    $deleted = false;
    if ($dbc != false) {
        try {
            $sql = 'DELETE FROM borrows WHERE `user-id`=:userID'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':userID', $userID);
            if ($stmt->execute() == false) {
                showDebugMessage("deleteUserBorrows execute returned false: ");
                $deleted = false;
            } else {
                $deleted = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not delete users borrows from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $deleted;
}

/**
 *zwraca ksiazki uzytkownika
 *@return bool czy zwracanie sie powiodlo
 */
function deleteBookBorrows($bookId)
{
    $dbc = getdbconnector();
    $deleted = false;
    if ($dbc != false) {
        try {
            $sql = 'DELETE FROM borrows WHERE `book-id`=:bookId'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':bookId', $bookId);
            if ($stmt->execute() == false) {
                showDebugMessage("deleteBookBorrows execute returned false: ");
                $deleted = false;
            } else {
                $deleted = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not delete book borrows from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $deleted;
}