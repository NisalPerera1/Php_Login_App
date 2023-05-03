<?php

class Auth {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  function register($username, $email, $password) {
    // Hash the password
    $password_hash = md5($password);

    // Insert the user into the database
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password_hash);
    $stmt->execute();

    // Get the user ID
    $user_id = $this->db->lastInsertId();

    // Return the user ID
    return $user_id;
  }

  function login($username, $password) {
    // Hash the password
    $password_hash = md5($password);

    // Check if the user exists
    $query = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_hash);
    $stmt->execute();

    // Get the user from the database
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the user
    return $user;
  }

  function updatePassword($user_id, $password) {
    // Hash the password
    $password_hash = md5($password);

    // Update the user's password
    $query = "UPDATE users SET password = :password WHERE id = :user_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
  }

  function getUser($user_id) {
    // Get the user from the database
    $query = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the user
    return $user;
  }
}

?>