<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Redirect to login page
    header('Location: /login');
    exit();
}

// Get the user's name
$username = $_SESSION['username'];

// Display welcome message
echo '<h1>Welcome, ' . $username . '! You have Successfully Loged in </h1>';

// Display logout button
echo '<form action="logout.php" method="post">';
echo '<input type="submit" value="Logout">';
echo '</form>';

// Handle logout logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header('Location: /login');
    exit();
}
?>
