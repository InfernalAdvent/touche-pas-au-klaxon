<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Response;

$router = new Router([
    'namespace' => 'App\\Controllers'
]);

$router->get('/', function() {
    return new Response("Route test avec closure OK");
});

$router->get('/home', function() {
    $controller = new App\Controllers\HomeController();
    return $controller->index();
});

$router->get('/user', function() {
    $controller = new App\Controllers\UserController();
    return $controller->index();
});


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
