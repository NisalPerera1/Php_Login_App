<?php
// Start session
session_start();

// Include necessary files
require_once 'C:\xampp\htdocs\PHP Registration and Login App\models\User.php';
require_once 'C:\xampp\htdocs\PHP Registration and Login App\Controllers\AuthController.php';

// Create an instance of the AuthController
$authController = new AuthController();

// Check if the user is already logged in
if ($authController->isLoggedIn()) {
    header('Location: secure.php');
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    $errors = $authController->validateLogin($username, $password);

    // Check if user exists in the database
    if (!$authController->getUserByUsername($username)) {
        $errors[] = 'Invalid username or password';
    }

    // If there are no errors, log the user in and redirect to the secure page
    if (empty($errors)) {
        $user = $authController->getUserByUsername($username);
        $authController->loginUser($user);
        header('Location: profile.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles.css">

    </head>
    <body>
        <?php if (isset($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post" action="">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit">Login</button>
        </form>
        <p class= "para">Don't have an account? <a href="register.php">Register here</a>.</p>
    </body>
</html>