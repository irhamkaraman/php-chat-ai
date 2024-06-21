<?php 
include 'env.php';
include 'controller/LoginController.php';
include 'controller/ErrorController.php';

session_start();

$routes = $currentUrl;
$request = $_SERVER['REQUEST_URI'];

switch ($request) {

    // LOGIN
    case $routes.'/login':
        LoginController::index();
        break;
    case $routes.'/register':
        LoginController::register();
        break;
    case $routes.'/do-login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if (LoginController::login($username, $password)) {
                header('Location: '.$currentUrl.'/');
                exit;
            } else {
                header('Location: '.$currentUrl.'/login');
            }
        }
        break;
    case $routes.'/do-register':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['nama'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
                if (LoginController::create($name, $username, $email, $password, $confirmPassword)) {
                    header('Location: '.$currentUrl.'/login');
                    exit;
                } else {
                    header('Location: '.$currentUrl.'/register');
                }
            }
        break;
    case $routes.'/logout':
        LoginController::logout();
        session_start();
        $_SESSION["success"] = "Logout Berhasil";
        header('Location: '.$currentUrl.'/login');
        exit;


    // DASHBOARD
    case $routes.'/':
        require "views/dashboard.php";
        break;


    // ERROR
    default:
        ErrorController::index();
        break;
}

