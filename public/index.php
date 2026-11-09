<?php
session_start();

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;

$router = new Router();

$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('services', ['controller' => 'ServiceController', 'action' => 'index']);
$router->add('barbers', ['controller' => 'BarberController', 'action' => 'index']);
$router->add('contacts', ['controller' => 'ContactController', 'action' => 'index']);

$router->add('login', ['controller' => 'AuthController', 'action' => 'login']);
$router->add('register', ['controller' => 'AuthController', 'action' => 'register']);
$router->add('logout', ['controller' => 'AuthController', 'action' => 'logout']);

$router->add('cabinet', ['controller' => 'CabinetController', 'action' => 'index']);
$router->add('appointment/create', ['controller' => 'AppointmentController', 'action' => 'create']);

$router->add('admin', ['controller' => 'AdminController', 'action' => 'index']);
$router->add('admin/services', ['controller' => 'AdminController', 'action' => 'services']);
$router->add('admin/barbers', ['controller' => 'AdminController', 'action' => 'barbers']);
$router->add('admin/appointments', ['controller' => 'AdminController', 'action' => 'appointments']);
$router->add('cabinet', ['controller' => 'CabinetController', 'action' => 'index']);
$router->add('cabinet/review', ['controller' => 'CabinetController', 'action' => 'addReview']);

$uri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$uri = str_replace($scriptName, '', $uri);
$uri = str_replace('/public', '', $uri);

$router->dispatch($uri);