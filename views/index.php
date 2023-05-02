<?php
require_once 'vendor/autoload.php';
require_once 'config/database.php';

use \controllers\AuthController;
$controller = new AuthController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'login';
}

switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'register':
        $controller->register();
        break;
    case 'logout':
        $controller->logout();
        break;
    default:
        $controller->login();
        break;
}
