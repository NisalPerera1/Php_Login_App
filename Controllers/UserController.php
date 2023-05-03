<?php

class UserController {
    public function login() {
        // Check if user is already logged in
        if (isLoggedIn()) {
            redirect('/dashboard');
        }

        // Check if form was submitted
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validate user input
            if (validateLoginInput($username, $password)) {
                // Authenticate user
                if (authenticateUser($username, $password)) {
                    // Redirect to dashboard
                    redirect('/dashboard');
                } else {
                    // Display error message
                    $error = 'Invalid username or password';
                    include('views/login.php');
                }
            } else {
                // Display error message
                $error = 'Invalid input';
                include('views/login.php');
            }
        } else {
            // Display login form
            include('views/login.php');
        }
    }

}