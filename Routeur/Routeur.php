<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Response;

$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = str_replace('/index.php', '', $scriptName);

$router = new Router([
    'base_folder' => $basePath,
    'namespace' => 'App\\Controllers'
]);

$userController = new App\Controllers\UserController($basePath);
$loginController = new App\Controllers\LoginController($basePath);
$dashboardController = new App\Controllers\DashboardController($basePath);
$trajetController = new App\Controllers\TrajetController();
$agenceController = new App\Controllers\AgenceController($basePath);


$router->get('/', fn() => $trajetController->trajets());

$router->get('/users', fn() => $userController->users());

$router->get('/login', fn() => $loginController->login());
$router->post('/login', fn() => $loginController->login());
$router->get('/logout', fn() => $loginController->logout());

$router->get('/dashboard', fn() => $dashboardController->index());

$router->get('/agences', fn() => $agenceController->agences());
$router->get('/agences/add', fn() => $agenceController->add(\Symfony\Component\HttpFoundation\Request::createFromGlobals()));
$router->post('/agences/add', fn() => $agenceController->add(\Symfony\Component\HttpFoundation\Request::createFromGlobals()));
$router->get('/agences/edit/{id}', fn($id) => $agenceController->edit(\Symfony\Component\HttpFoundation\Request::createFromGlobals(), $id));
$router->post('/agences/edit/{id}', fn($id) => $agenceController->edit(\Symfony\Component\HttpFoundation\Request::createFromGlobals(), $id));
$router->get('/agences/delete/{id}', fn($id) => $agenceController->delete($id));


set_exception_handler(function($e) {
    echo "<pre>Exception attrapée: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
});

try {
    $response = $router->run();

if ($response instanceof Response) {
    $response->send();
} else {
    echo $response;
}

} catch (Exception $e) {
    echo "<pre>Exception try/catch: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
}
