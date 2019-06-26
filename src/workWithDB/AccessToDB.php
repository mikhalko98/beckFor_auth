<?php

class AccessToDB{
    private $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    function getUser($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array($email));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    function addUser($data){
        $sql = "INSERT INTO users(first_name, last_name, email, password) 
                            VALUE (?,?,?,?)";
        $sth = $this->pdo->prepare($sql);
        return $sth->execute(array($data['first_name'], $data['last_name'], $data['email'], $data['password']));
    }
}
?>