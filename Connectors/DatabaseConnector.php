<?php
include(_ROOT_PATH . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'config.php');


function getdbconnector()
{
    $dsn = "pgsql:host=" . host . ";port=5432;dbname=" . dbname . ";user=" . user . ";password=" . pass . "";
    //var_dump($dsn);
    $conn = false;
    try {
        // create a PostgreSQL database connection
        $conn = new PDO($dsn);
        // display a message if connected to the PostgreSQL successfully
        if ($conn) {
            //echo "Connected to the <strong>".dbname."</strong> database successfully!";
        } else {
            echo "error";
        }
    } catch (PDOException $e) {
        // report error message
        echo $e->getMessage();
    }
    return $conn;
}

/**
 *sprawdzanie hasla dla uzytkownika
 *@param string $login nazwa użytkownika
 *@param string $password zahaszowane haslo
 *@return bool czy poprawne haslo.
 */
function checkPassword($login, $password, $pracownik = false)
{

    $dbc = getdbconnector();
    if ($dbc != false) {
        $approved = false;
        try {
            $stmt = $dbc->prepare('SELECT count(*) AS "numOfUsers" from :tableTabe WHERE login=:login AND haslo=:password  AND active=1');
            if ($pracownik)
                $stmt->bindValue(':tableTabe', 'Pracownik');
            else
                $stmt->bindValue(':tableTabe', 'czytelnicy');
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':password', $password);

            var_dump($stmt);
            if ($stmt->execute() == false) {
                $dbc = null;
                return false;
            } else {
                $row = $stmt->fetch();
                $numOfUsers = $row["numOfUsers"];
                echo "num: " . $numOfUsers;
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
 *@return array(typ,id)
 */
function getUserType($login, $password, $checkPassword)
{

    $dbc = getdbconnector();
    $type = false;
    $userId = null;
    $userInfo = array(
        "type" => $type,
        "userId" => $userId
    );
    if ($dbc != false) {
        try {
            if ($checkPassword) {
                $stmt = $dbc->prepare('SELECT id_czytelnik AS id from czytelnicy WHERE login=:login AND haslo=:password');
                $stmt->bindValue(':password', $password);
            } else
                $stmt = $dbc->prepare('SELECT id_czytelnik AS id from czytelnicy WHERE login=:login');

            $stmt->bindValue(':login', $login);

            if ($stmt->execute() == false) {
                $type = false;
            } else {
                if ($stmt->rowCount() == 1) {
                    $userInfo['type'] = 'reader';
                    $row = $stmt->fetch();
                    $userInfo['userId'] = $row["id"];
                }
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not check usertype. DB query error: " . $e->getMessage());
            return false;
        }
    }
    if ($userInfo['type'] != false)
        return $userInfo;
    $dbc = getdbconnector();
    $type = false;
    if ($dbc != false) {

        try {
            if ($checkPassword) {
                $stmt = $dbc->prepare('SELECT id_pracownicy AS id from pracownik WHERE login=:login AND haslo=:password');
                $stmt->bindValue(':password', $password);
            } else
                $stmt = $dbc->prepare('SELECT id_pracownicy AS id from pracownik WHERE login=:login');

            $stmt->bindValue(':login', $login);
            if ($stmt->execute() == false) {
                $type = false;
            } else {
                if ($stmt->rowCount() > 0) {
                    $userInfo['type'] = 'admin';
                    $row = $stmt->fetch();
                    $userInfo['userId'] = $row["id"];
                }
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not check usertype. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $userInfo;
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
        //todo:
        try {
            $sql = 'SELECT czytelnicy.id_czytelnik, czytelnicy.login, czytelnicy.haslo,czytelnicy.email,czytelnicy.telefon,czytelnicy.data_urodzenia
            FROM czytelnicy';
            $stmt = $dbc->prepare($sql);
            if ($stmt->execute() == false) {
                var_dump($stmt->execute());
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
            $sql = 'SELECT * FROM czytelnicy WHERE id_czytelnik=:id';

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
                $sql = 'UPDATE "users" SET 
            "name" =:name, 
            "surname" =:surname,
            "login" =:login,
            "password" =:password,
            "birthday" =:birthday,
            "type" =:type
            WHERE active=1 AND id=:id';
            else
                $sql = 'UPDATE "users" SET "name" =:name, 
            "surname" =:surname,
            "login" =:login,
            "type" =:type,
            "birthday" =:birthday
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
            $sql = 'INSERT INTO "users" VALUES (NULL, :name, :surname, :login, :password, :type, :birthday, "1");';

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
    deleteUserBorrows($userId); //przed usunieciem zwraca ksiazki
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


function deleteAuthor($authorId)
{
    // deleteBookBorrows($bookId);
    $dbc = getdbconnector();
    $deleted = false;
    if ($dbc != false) {
        try {
            $sql = 'DELETE FROM autorzy WHERE id_autor=:id'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $authorId);
            if ($stmt->execute() == false) {
                showDebugMessage("deleteAuthor execute returned false: ");
                $deleted = false;
            } else {
                $deleted = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not delete author from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $deleted;
}

function deletePublishingHouse($publishingHouseId)
{
    // deleteBookBorrows($bookId);
    $dbc = getdbconnector();
    $deleted = false;
    if ($dbc != false) {
        try {
            $sql = 'DELETE FROM wydawnictwo WHERE id_wydawnictwo=:id'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id',$publishingHouseId);
            if ($stmt->execute() == false) {
                showDebugMessage("delete PublishingHouse execute returned false: ");
                $deleted = false;
            } else {
                $deleted = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not delete publishinghouse from db. DB query error: " . $e->getMessage());
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

            $sql = 'SELECT books.id AS id, title, author, publishingHouse, year, inventory, books.image,
            COUNT(borrows.id) as numOfBorrowed,
            inventory-COUNT(borrows.id) as numOfAvailable,
            (select count(*) from borrows where borrows.user_id = :userId AND borrows.book_id=books.id) as numOfBorrowedByUser
            FROM books
            LEFT JOIN BORROWS
            ON BOOKS.id=borrows.book_id
            GROUP BY books.id ORDER BY title ASC, year DESC';
           

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


function getAllGenres()
{
    $dbc = getdbconnector();
    $genres = false;
    if($dbc != false) {
            try {
                $sql = 'SELECT * FROM kategoria ORDER BY nazwa';
                $stmt = $dbc->prepare($sql);
                if($stmt->execute()==false) {
                    showDebugMessage("getAllGenres execute returned false: ");
                    $genres = false;
                } else {
                    $genres = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                }
                $dbc = null;
            }catch (PDOException $e) {
                showDebugMessage("can not get all genres from Db:". $e->getMessage());
                return false;
            }
    }

    return $genres;
}

function getAllPublishingHouses()
{
    $dbc = getdbconnector();
    $genres = false;
    if($dbc != false) {
            try {
                $sql = 'SELECT * FROM wydawnictwo ORDER BY nazwa';
                $stmt = $dbc->prepare($sql);
                if($stmt->execute()==false) {
                    showDebugMessage("getAllPublishingHouses execute returned false: ");
                    $genres = false;
                } else {
                    $genres = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                }
                $dbc = null;
            }catch (PDOException $e) {
                showDebugMessage("can not get all publishingHouses from Db:". $e->getMessage());
                return false;
            }
    }

    return $genres;
}

function getAllAuthors()
{
    $dbc = getdbconnector();
    $authors = false;
    if($dbc != false) {
            try {
                $sql = 'SELECT * FROM autorzy ORDER BY nazwisko';
                $stmt = $dbc->prepare($sql);
                if($stmt->execute()==false) {
                    showDebugMessage("getAllGenres execute returned false: ");
                    $authors = false;
                } else {
                    $authors = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                }
                $dbc = null;
            }catch (PDOException $e) {
                showDebugMessage("can not get all authors from Db:". $e->getMessage());
                return false;
            }
    }

    return $authors;
}


/**
 *pobieranie listy ksiazek
 */
function getAllBooks()
{
    $dbc = getdbconnector();
    $books = false;
    if ($dbc != false) {

        try {
            $sql = 'SELECT ksiazki.id_ksiazka, ksiazki.tytul, ksiazki.opis, wydawnictwo.nazwa AS wydawnictwo,
            ksiazki.rok_wydania, kategoria.nazwa AS kategoria,
            (SELECT string_agg(autorzy.nazwisko, \', \') AS autorzy FROM autorzyksiazek LEFT JOIN autorzy ON autorzyksiazek.id_autor=autorzy.id_autor
                        WHERE autorzyksiazek.id_ksiazka=ksiazki.id_ksiazka
                        ) AS autorzy
                        FROM ksiazki
                        LEFT JOIN kategoria ON ksiazki.id_kategoria=kategoria.id_kategoria
                        LEFT JOIN wydawnictwo ON ksiazki.id_wydawnictwa=wydawnictwo.id_wydawnictwo
                        ORDER BY ksiazki.id_ksiazka ASC';

            $stmt = $dbc->prepare($sql);
            //$stmt->bindValue(':userId', $userId);
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
 *pobieranie listy autorow ksiazki
 *@param int $id_ksiazka 
 */
function getBookAuthors($id_ksiazka = 0)
{
    $dbc = getdbconnector();
    $bookAuthors = false;
    if ($dbc != false) {

        try {
            $sql = 'SELECT autorzyksiazek.id_autor, autorzy.imie,autorzy.nazwisko
            FROM autorzyksiazek
            LEFT JOIN autorzy ON autorzyksiazek.id_autor=autorzy.id_autor
            WHERE autorzyksiazek.id_ksiazka=:id_ksiazka';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id_ksiazka', $id_ksiazka);
            //var_dump($stmt);
            //$stmt->bindValue(':userId', $userId);
            if ($stmt->execute() == false) {
                showDebugMessage("getBookAuthors execute returned false: ");
                $bookAuthors = false;
            } else {
                $bookAuthors = $stmt->fetchAll(PDO::FETCH_ASSOC); //pusta tablica, jesli nie ma uzytkownikow
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get getBookAuthors from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $bookAuthors;
}

/**
 *pobieranie statystyk ksiazki
 *@param int $id_ksiazka 
 */
function getBookStats($id_ksiazka = 0)
{
    $dbc = getdbconnector();
    $bookStats = false;
    $bookStats['liczba_egzemplarzy'] = false;
    $bookStats['liczba_egzemplarzy_w_bibliotece'] = false;
    $bookStats['liczba_rezerwacji'] = false;
    //liczba wszystkich
    if ($dbc != false) {
        try {
            $sql = 'SELECT COUNT(egzemplarz.id_egzemplarza) AS liczba_egzemplarzy
            FROM egzemplarz
            WHERE egzemplarz.id_ksiazka=:id_ksiazka
            AND egzemplarz.wycofany!=true';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id_ksiazka', $id_ksiazka);
            if ($stmt->execute() == false) {
                showDebugMessage("getBookStats execute returned false: ");
            } else {
                $row = $stmt->fetch();
                $bookStats['liczba_egzemplarzy'] = $row["liczba_egzemplarzy"];
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get getBookStats from db. DB query error: " . $e->getMessage());

            //return false;
        }
    }
    $dbc = getdbconnector();
    if ($dbc != false) {
        try {
            $sql = 'SELECT COUNT(egzemplarz.id_egzemplarza) AS liczba_egzemplarzy_w_bibliotece
        FROM egzemplarz
        LEFT JOIN wypozyczenia ON egzemplarz.id_egzemplarza=wypozyczenia.id_egzemplarza
        WHERE egzemplarz.id_ksiazka=:id_ksiazka
        AND egzemplarz.wycofany!=true
        AND (
            wypozyczenia.data_oddania >= NOW()
            OR
            wypozyczenia.id_egzemplarza IS NULL
            )';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id_ksiazka', $id_ksiazka);
            if ($stmt->execute() == false) {
                showDebugMessage("getBookStats execute returned false: ");
            } else {
                $row = $stmt->fetch();
                $bookStats['liczba_egzemplarzy_w_bibliotece'] = $row["liczba_egzemplarzy_w_bibliotece"];
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get getBookStats from db. DB query error: " . $e->getMessage());

            //return false;
        }
    }

    //liczba_rezerwacji
    $dbc = getdbconnector();
    if ($dbc != false) {
        try {
            $sql = 'SELECT COUNT(rezerwacja.id_rezerwacja) AS liczba_rezerwacji
        FROM rezerwacja
        WHERE rezerwacja.id_ksiazka=:id_ksiazka
        AND rezerwacja.usuniety!=true';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id_ksiazka', $id_ksiazka);
            if ($stmt->execute() == false) {
                showDebugMessage("getBookStats execute returned false: ");
            } else {
                $row = $stmt->fetch();
                $bookStats['liczba_rezerwacji'] = $row["liczba_rezerwacji"];
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get getBookStats from db. DB query error: " . $e->getMessage());
            //return false;
        }
    }
    return $bookStats;
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
            $sql = 'INSERT INTO "books" ("title", "author", "publishingHouse", "year", "inventory", "available", "image")
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

function insertAuthor($imie, $nazwisko) {
    $dbc = getdbconnector();
    $done = false;

    if($dbc != false) {
        try {
            $sql = "INSERT INTO autorzy (imie, nazwisko)VALUES( :imie, :nazwisko)";
            $stmt = $dbc->prepare($sql);
            
            $stmt-> bindValue(':imie', $imie);
            $stmt -> bindValue(':nazwisko', $nazwisko);
            if($stmt-> execute() == false) {
                showDebugMessage("cannot insert author.");
            }else {
                $done = true;
            }
        } catch(PDOException $e) {
            showDebugMessage("can not insert author. DB query error:". $e->getMessage());
        }
        $dbc = null;
    }
        return $done;


}

function insertGenre($title) {
    $dbc = getdbconnector();
    $done= false;
    if($dbc != false) {
        try {
            $sql = "INSERT INTO kategoria (nazwa)VALUES( :nazwa)";
            $stmt = $dbc->prepare($sql);
            
            $stmt-> bindValue(':nazwa', $title);

            if($stmt-> execute() == false) {
                showDebugMessage("cannot insert book.");
            }else {
                $done = true;
            }
        } catch(PDOException $e) {
            showDebugMessage("can not insert genre. DB query error:". $e->getMessage());
        }
        $dbc = null;
    }
        return $done;

}

function insertPublishingHouse($title) {
    $dbc = getdbconnector();
    $done= false;
    if($dbc != false) {
        try {
            $sql = "INSERT INTO wydawnictwo (nazwa)VALUES( :nazwa)";
            $stmt = $dbc->prepare($sql);
            
            $stmt-> bindValue(':nazwa', $title);

            if($stmt-> execute() == false) {
                showDebugMessage("cannot insert publishinghouse.");
            }else {
                $done = true;
            }
        } catch(PDOException $e) {
            showDebugMessage("can not insert genre. DB query error:". $e->getMessage());
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
                $sql = 'UPDATE "books" SET 
            "title" =:title, 
            "author" =:author,
            "publishingHouse" =:publishingHouse,
            "year" =:year,
            "inventory" =:inventory,
            "available" =:available,
            "image" =:uploadedFile. 
            WHERE id=:id';
            else
                $sql = 'UPDATE "books" SET 
            "title" =:title, 
            "author" =:author,
            "publishingHouse" =:publishingHouse,
            "year" =:year,
            "inventory" =:inventory,
            "available" =:available
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

function updateGenre($id, $nazwa) {

    $dbc = getdbconnector();
    $done = false;
    if($dbc != false) {
        try {
            $sql = 'UPDATE kategoria SET nazwa = :nazwa WHERE id_kategoria = :id';
            $stmt = $dbc -> prepare($sql);
            $stmt-> bindValue(':id', $id);
            $stmt -> bindValue(':nazwa', $nazwa);
            if ($stmt->execute() == false) {
                showDebugMessage("cannot update genre id: " . $id);
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


function updatePublishingHouse($id, $nazwa) {

    $dbc = getdbconnector();
    $done = false;
    if($dbc != false) {
        try {
            $sql = 'UPDATE wydawnictwo SET nazwa = :nazwa WHERE id_wydawnictwo = :id';
            $stmt = $dbc -> prepare($sql);
            $stmt-> bindValue(':id', $id);
            $stmt -> bindValue(':nazwa', $nazwa);
            if ($stmt->execute() == false) {
                showDebugMessage("cannot update publishinghouse id: " . $id);
            } else {
                $done = true;
            }
        } catch (PDOException $e) {
            showDebugMessage("can not update publishinghouse. DB query error: " . $e->getMessage());
        }
        $dbc = null;
        
    }
return $done;
    
}

function updateAuthor($id, $imie, $nazwisko) {

    $dbc = getdbconnector();
    $done = false;
    if($dbc != false) {
        try {
            $sql = 'UPDATE autorzy SET imie = :imie, nazwisko = :nazwisko WHERE id_autor = :id';
            $stmt = $dbc -> prepare($sql);
            $stmt-> bindValue(':id', $id);
            $stmt -> bindValue(':imie', $imie);
            $stmt -> bindValue(':nazwisko', $nazwisko);
            if ($stmt->execute() == false) {
                showDebugMessage("cannot update author id: " . $id);
            } else {
                $done = true;
            }
        } catch (PDOException $e) {
            showDebugMessage("can not update author. DB query error: " . $e->getMessage());
        }
        $dbc = null;
        
    }
   
return $done;
    
}
/**
 *pobieranie wszystkich danych uzytkownika
=======
/**
 *pobieranie wszystkich danych ksiazki
>>>>>>> ea19e9b4e422f8f50578ae2668d14ff796d2753e
 *@return false/string false jesli nie znaleziono/ user
 */
function getBook($bookId)
{
    $dbc = getdbconnector();
    $user = false;
    $bookDetails = null;
    if ($dbc != false) {
        try {
            $sql = 'SELECT ksiazki.id_ksiazka, ksiazki.tytul, ksiazki.opis, wydawnictwo.nazwa AS wydawnictwo, ksiazki.rok_wydania, kategoria.nazwa AS kategoria
            FROM ksiazki
            
            LEFT JOIN kategoria ON ksiazki.id_kategoria=kategoria.id_kategoria
            LEFT JOIN wydawnictwo ON ksiazki.id_wydawnictwa=wydawnictwo.id_wydawnictwo
            WHERE id_ksiazka=:id_ksiazka
            ORDER BY ksiazki.id_ksiazka ASC';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id_ksiazka', $bookId);
            if ($stmt->execute() == false) {
                showDebugMessage("getBook execute returned false: ");
                $bookDetails = null;
            } else {
                $rowCount = $stmt->rowCount();
                if ($rowCount == 1)
                    $bookDetails = $stmt->fetch(PDO::FETCH_ASSOC);
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
    return $bookDetails;
}
function getGenre($genreId)
{
    $dbc = getdbconnector();
    $user = false;
    if ($dbc != false) {
        try {
            $sql = 'SELECT * FROM kategoria WHERE id_kategoria=:id';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $genreId);
            if ($stmt->execute() == false) {
                showDebugMessage("getGenre execute returned false: ");
                $user = false;
            } else {
                $rowCount = $stmt->rowCount();
                if ($rowCount == 1)
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                else {
                    showDebugMessage('getGenre query returned ' . $rowCount . ' row(s) for book id=' . $bookId . '. ');
                }
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not getGenre from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $user;
}

function getPublishingHouse($wydawnictwoId)
{
    $dbc = getdbconnector();
    $user = false;
    if ($dbc != false) {
        try {
            $sql = 'SELECT * FROM wydawnictwo WHERE id_wydawnictwo=:id';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $wydawnictwoId);
            if ($stmt->execute() == false) {
                showDebugMessage("getPublishingHouse execute returned false: ");
                $user = false;
            } else {
                $rowCount = $stmt->rowCount();
                if ($rowCount == 1)
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                else {
                    showDebugMessage('getPublishingHouse query returned ' . $rowCount . ' row(s) for book id=' . $bookId . '. ');
                }
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not getPublishingHouse from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $user;
}

function getAuthor($authorId)
{
    $dbc = getdbconnector();
    $user = false;
    if ($dbc != false) {
        try {
            $sql = 'SELECT * FROM autorzy WHERE id_autor=:id';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id', $authorId);
            if ($stmt->execute() == false) {
                showDebugMessage("getAutor execute returned false: ");
                $user = false;
            } else {
                $rowCount = $stmt->rowCount();
                if ($rowCount == 1)
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                else {
                    showDebugMessage('getAutor query returned ' . $rowCount . ' row(s) for author id=' . $authorId . '. ');
                }
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not getAutor from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $user;
}



/**
 *pobieranie wszystkich egzemplarzy danej ksiazki
 *@return null/array null jesli nie znaleziono/ tablica egzemplarzy 
 */
function getEgzemplarze($bookId, $wyswietlWycofane = false)
{
    $dbc = getdbconnector();
    $egzemplarze = null;
    if ($dbc != false) {
        try {
            $sql = 'SELECT egzemplarz.id_egzemplarza, egzemplarz.id_ksiazka, wypozyczenia.id_wypozyczenie, wypozyczenia.id_czytelnik, wypozyczenia.data_wypozyczenia, wypozyczenia.data_oddania, czytelnicy.login
            FROM egzemplarz
            LEFT JOIN wypozyczenia ON egzemplarz.id_egzemplarza=wypozyczenia.id_egzemplarza
            LEFT JOIN czytelnicy ON wypozyczenia.id_czytelnik=czytelnicy.id_czytelnik
            WHERE id_ksiazka=:id_ksiazka';
            if ($wyswietlWycofane != true)
                $sql .= ' AND egzemplarz.wycofany!=true';

            $sql .= ' ORDER BY egzemplarz.id_egzemplarza ASC';

            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id_ksiazka', $bookId);
            if ($stmt->execute() == false) {
                showDebugMessage("getEgzemplarze execute returned false: ");
                $egzemplarze = null;
            } else {
                $egzemplarze = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not getEgzemplarze from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $egzemplarze;
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
                $sql = 'INSERT INTO "borrows" ( "book-id", "user-id") VALUES ( :bookId, :userId);'; //UPDATE books SET ACTIVE=0 WHERE...
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


function bookABook($bookId, $userId)
{
    $borrowed = false;
    $dbc = getdbconnector();
    $success = false;
    if ($dbc != false) {
        try {
            $sql = 'INSERT INTO "rezerwacja" ( "id_ksiazka", "id_czytelnik") VALUES ( :bookId, :userId);'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':bookId', $bookId);
            $stmt->bindValue(':userId', $userId);
            var_dump($sql);
            if ($stmt->execute() == false) {
                showDebugMessage("INSERT INTO rezerwacja execute returned false: ");
                $success = false;
            } else {
                $success = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not book a book from db. DB query error: " . $e->getMessage());
            return false;
        }
    }

    return $success;
}



/**
 *usuwanie rezerwacji
 */
function deleteABookBook($id_rezerwacja)
{
    $borrowed = false;
    $dbc = getdbconnector();
    $success = false;
    if ($dbc != false) {
        try {
            $sql = 'UPDATE "rezerwacja" SET usuniety=true
            WHERE id_rezerwacja=:id_rezerwacja;'; //UPDATE books SET ACTIVE=0 WHERE...
            $stmt = $dbc->prepare($sql);
            $stmt->bindValue(':id_rezerwacja', $id_rezerwacja);
            var_dump($sql);
            if ($stmt->execute() == false) {
                showDebugMessage("UPDATE rezerwacja execute returned false: ");
                $success = false;
            } else {
                $success = true;
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not DELETE a book a book from db. DB query error: " . $e->getMessage());
            return false;
        }
    }

    return $success;
}



/**
 *pobieranie listy uzytkownikow
 *@return false/string typ użytkownika.
 */
function getBorrowedBooks($id_czytelnik = null)
{
    $dbc = getdbconnector();
    $books = false;
    if ($dbc != false) {

        try {
            $sql = 'SELECT wypozyczenia.id_wypozyczenie, ksiazki.tytul,ksiazki.id_ksiazka, czytelnicy.login
            FROM wypozyczenia
            LEFT JOIN egzemplarz
            ON wypozyczenia.id_egzemplarza=egzemplarz.id_egzemplarza
            LEFT JOIN ksiazki
            ON egzemplarz.id_ksiazka=ksiazki.id_ksiazka
            LEFT JOIN czytelnicy
            ON wypozyczenia.id_czytelnik=czytelnicy.id_czytelnik 
            WHERE ';
            if ($id_czytelnik != null) {
                $sql .= " wypozyczenia.id_czytelnik=:id_czytelnik AND";
            }
            $sql .= ' wypozyczenia.data_oddania = NULL
            ORDER BY wypozyczenia.id_wypozyczenie ASC';
            $stmt = $dbc->prepare($sql);
            if ($id_czytelnik != null) {
                $stmt->bindValue(':id_czytelnik', $id_czytelnik);
            }

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



function getRezerwacje($id_czytelnik = null, $id_ksiazka = null)
{
    $dbc = getdbconnector();
    $rezerwacje = false;
    if ($dbc != false) {

        try {
            $sql = 'SELECT rezerwacja.id_rezerwacja,ksiazki.id_ksiazka, rezerwacja.id_czytelnik, ksiazki.tytul, czytelnicy.login
            FROM rezerwacja
            LEFT JOIN ksiazki
            ON rezerwacja.id_ksiazka=ksiazki.id_ksiazka
            LEFT JOIN czytelnicy
            ON rezerwacja.id_czytelnik=czytelnicy.id_czytelnik 
            WHERE';

            if ($id_czytelnik != null) {
                $sql .= " rezerwacja.id_czytelnik=:id_czytelnik AND";
            }
            $sql .= ' rezerwacja.usuniety!=true';

            if ($id_ksiazka != null) {
                $sql .= " AND rezerwacja.id_ksiazka=:id_ksiazka ";
            }
            $sql .= ' ORDER BY rezerwacja.id_rezerwacja ASC';
            $stmt = $dbc->prepare($sql);
            if ($id_czytelnik != null) {
                $stmt->bindValue(':id_czytelnik', $id_czytelnik);
            }
            if ($id_ksiazka != null) {
                $stmt->bindValue(':id_ksiazka', $id_ksiazka);
            }

            if ($stmt->execute() == false) {
                showDebugMessage("getRezerwacje execute returned false: ");
            } else {
                $rezerwacje = $stmt->fetchAll(PDO::FETCH_ASSOC); //pusta tablica, jesli nie ma rezerwacji
            }
            $dbc = null;
        } catch (PDOException $e) {
            showDebugMessage("can not get rezerwacje books from db. DB query error: " . $e->getMessage());
            return false;
        }
    }
    return $rezerwacje;
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
            $sql = 'DELETE FROM borrows WHERE "user-id"=:userID'; //UPDATE books SET ACTIVE=0 WHERE...
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
            $sql = 'DELETE FROM borrows WHERE "book-id"=:bookId'; //UPDATE books SET ACTIVE=0 WHERE...
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
