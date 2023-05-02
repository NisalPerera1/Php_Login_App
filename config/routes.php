<?php

// Define the base URL for the application
define('BASE_URL', 'http://localhost/PHP%20Registration%20and%20Login%20App/');

// Define the default controller and action
$controller = 'auth';
$action = 'login';

// Parse the URL to determine the controller and action
if(isset($_GET['controller']) && !empty($_GET['controller'])) {
    $controller = $_GET['controller'];
}
if(isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
}

// Build the path to the controller file
$controllerPath = 'controllers/' . $controller . 'Controller.php';

// Check if the controller file exists
if(file_exists($controllerPath)) {
    // Include the controller file
    require_once $controllerPath;

    // Build the name of the controller class
    $controllerClass = ucfirst($controller) . 'Controller';

    // Check if the controller class exists
    if(class_exists($controllerClass)) {
        // Create an instance of the controller class
        $controllerInstance = new $controllerClass();

        // Call the action method
        if(method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            // Display an error message if the action method doesn't exist
            echo 'Invalid action: ' . $action;
        }
    } else {
        // Display an error message if the controller class doesn't exist
        echo 'Invalid controller: ' . $controller;
    }
} else {
    // Display an error message if the controller file doesn't exist
    echo 'Invalid controller: ' . $controller;
}
