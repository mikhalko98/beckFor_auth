<?php
require_once "/var/www/week_8/config.php";
require_once "/var/www/week_8/src/workWithDB/DbConnectManager.php";
require_once "/var/www/week_8/src/workWithDB/AccessToDB.php";

class User
{
    private $AccessToDB;

    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $password;

    function __construct()
    {
        $Config = new Config();
        $DB_testSite = new DbConnectManager($Config->getDns(), $Config->getUser(), $Config->getPass());
        $DB_testSite = $DB_testSite->getdbh();
        $this->AccessToDB = new AccessToDB($DB_testSite);
    }

    function getUser($email)
    {
        $date = $this->AccessToDB->getUser($email);
        $this->id = $date['id'];
        $this->first_name = $date['first_name'];
        $this->last_name = $date['last_name'];
        $this->email = $date['email'];
        $this->password = $date['password'];
        return $this->getObj();
    }

    function addUser($data)
    {
        $user = $this->getUser($data['email']);
        if ($user->id)
            return "user exists";
        else
            return $this->AccessToDB->addUser($data);
    }

    public function getObj()
    {
        return ((object)array('id' => $this->id, 'first_name' => $this->first_name,
            'last_name' => $this->last_name, 'email' => $this->email, 'password' => $this->password));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}

