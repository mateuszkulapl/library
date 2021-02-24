<?php
require_once(_ROOT_PATH . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Manager.php');

abstract class User
{
    protected $login;
    protected $password;
    /**
     *@param string $login login.
     *@param string $password haslo.
     */
    protected function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Sprawdzanie poprawnosci hasla
     *@param string $password haslo.
     *@return bool poprawne haslo.
     */
    public function isCorrectPassword($password)
    {
        return ($this->password == $password);
    }
    /**
     * zwraca nazwe użytkownika
     */
    public function getLogin()
    {
        return $this->login;
    }
    /**
     * zwraca haslo użytkownika
     */
    public function getPassword()
    {
        return $this->password;
    }
}
/**
 *Admin ze wszystkimi uprawnieniami
 */
class Admin extends User implements Manager
{
    protected static $allowedOpttions = array('home', 'book', 'bookAdd', 'deleteUser', 'createUser');
    /**
     *@param string $login login.
     *@param string $password haslo.
     */
    function __construct($login, $password)
    {
        parent::__construct($login, $password, "admin");
    }

    function deleteUser($login)
    {
        if (in_array("deleteUser", $this->alloedOptions))
            return deleteUser($login);
        return false;
    }

    /**
     *tworzy użytkownika i wstawia do bazy
     *@param string $login login
     *@param string $password haslo
     *@param string $type rola admin/reader
     *@param bool $isHashed haslo jest zahaszowane
     *@return bool informacja czy dodano
     */
    function createUser($login, $password, $type, $isHashed = false)
    {
        $newUser = null;
        if (in_array("createUser", $this->alloedOptions)) {
            if ($isHashed == false)
                $password = getHashed($password);
            if ($type == "admin")
                $newUser = new Admin($login, $password);
            else
                if ($type == "reader")
                $newUser = new Reader($login, $password);
            else {
                showDebugMessage("parametr type spoza zakresu: login: " . $login, " type: " . $type);
                return false;
            }
            return insertUser($newUser);
        }
    }

    public function getLogin()
    {
        return $this->login;
    }
    public function getPassword()
    {
        return $this->password;
    }
    function depdeleteBook($book)
    {
        if (in_array("deletebook", $this->alloedOptions))
            //return deleteUser($login);
            return false;
    }
}

/**
 *Czytelnik z ogranicznonymi uprawnieniami
 */
class Reader extends User
{
    protected static $allowedOpttions = array('home', 'book');
    /**
     *@param string $login login
     *@param string $password haslo
     */
    function __construct($login, $password)
    {
        parent::__construct($login, $password, "reader");
    }
    public function getLogin()
    {
        return $this->login;
    }
    public function getPassword()
    {
        return $this->password;
    }
}
