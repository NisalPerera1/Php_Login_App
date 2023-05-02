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
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        $errors = $authController->validateRegistration($username, $email, $password, $confirm_password);

        // If there are no errors, create a new user and redirect to the login page
        if (empty($errors)) {
            // Create a new User object
            $user = new User();

            // Set the User object's properties
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);

            // Save the User object to the database
            $user->save();

            // Redirect to the login page
            $_SESSION['success'] = 'You have successfully registered! Please log in.';
            header('Location: login.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <?php if (isset($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p><?php echo $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form method="post" action="">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>

    </body>
</html>
