<?php

class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=php_registration_and_login', 'root', '');
    }

    public function save()
    {
        $stmt = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->execute();
    }

    public function loadByUsername($username)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetchObject('User');

        if (!$user) {
            return null;
        }

        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->password = $user->password;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function userExists($username) {
        $userModel = new User();
        $user = $userModel->loadByUsername($username);
        return $user !== null;
    }
    
}

