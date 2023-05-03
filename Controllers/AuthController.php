<?php

require_once 'C:\xampp\htdocs\PHP Registration and Login App\models\User.php';

class AuthController {
  
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate input
            $errors = $this->validateRegistration($username, $email, $password, $confirm_password);
            if (!empty($errors)) {
                require_once 'views/auth/register.php';
                exit();
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Create user
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($hashed_password);
            $user->save();

            // Redirect to login page
            header('Location: /login');
        } else {
            require_once 'views/auth/register.php';
        }
    }


    public function validateRegistration($username, $email, $password, $confirm_password) {
        $errors = [];

        // Validate username
        if (empty($username)) {
            $errors['username'] = 'Please enter a username';
        } elseif (strlen($username) < 3) {
            $errors['username'] = 'Username must be at least 3 characters';
        }

        // Validate email
        if (empty($email)) {
            $errors['email'] = 'Please enter an email address';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Validate password
        if (empty($password)) {
            $errors['password'] = 'Please enter a password';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        } elseif ($password !== $confirm_password) {
            $errors['password'] = 'Passwords do not match';
        }

        return $errors;
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            // Validate input
            $errors = $this->validateLogin($username, $password);
            if (!empty($errors)) {
                require_once 'views/auth/login.php';
                exit();
            }
    
            $user = $this->getUserByUsername($username);
    
            if (!$user) {
                $error = 'Invalid login credentials';
                require_once 'views/auth/login.php';
                exit();
            }
    
            if (!password_verify($password, $user->getPassword())) {
                $error = 'Invalid login credentials';
                require_once 'views/auth/login.php';
                exit();
            }
    
            // Start session
            session_start();
    
            // Set session variables
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['logged_in'] = true;
    
            // Redirect to secure area
            header('Location: /secure');
        } else {
            require_once 'views/auth/login.php';
        }
    }

    public function validateLogin($username, $password) {
        $errors = [];
    // Validate username
    if (empty($username)) 
    {
        $errors[] = 'Please enter a username.';
    }

        // Validate password
        if (empty($password)) {
            $errors[] = 'Please enter a password.';
        }
        $user = $this->getUserByUsername($username);

        if (!$user) {
            $errors[] = 'Invalid username.';
        }

        if (!password_verify($password, $user->getPassword())) {
            $errors[] = 'Invalid Password';
        }

        return $errors;
    }

    public function getUserByUsername($username) {
        $user = new User();
        $user->setUsername($username);
        $user->loadByUsername($username);
        return $user;
    }

    public function loginUser($user) {
        // Start session
        session_start();

        // Set session variables
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['logged_in'] = true;
    }

}