<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Routeur/Routeur.php';

define('BASE_PATH', '/touche-pas-au-klaxon/public');

// Déclaration des routes
$router = new Router();

$router->get('/', 'App\Controllers\TrajetController@trajets');
$router->get('/dashboard', 'App\Controllers\DashboardController@index');
$router->get('/users', 'App\Controllers\UserController@users');

$router->get('/login', 'App\Controllers\LoginController@login');
$router->post('/login', 'App\Controllers\LoginController@login');
$router->get('/logout', 'App\Controllers\LoginController@logout');

$router->get('/trajet/add', 'App\Controllers\TrajetController@add');
$router->post('/trajet/add', 'App\Controllers\TrajetController@add');
$router->get('/trajet/edit/{id}', 'App\Controllers\TrajetController@edit');
$router->post('/trajet/update/{id}', 'App\Controllers\TrajetController@update');
$router->get('/trajet/delete/{id}', 'App\Controllers\TrajetController@delete');


$router->get('/agences', 'App\Controllers\AgenceController@agences');
$router->get('/agences/add', 'App\Controllers\AgenceController@add');
$router->post('/agences/add', 'App\Controllers\AgenceController@add');
$router->get('/agences/delete/{id}', 'App\Controllers\AgenceController@delete');

$router->get('/trajet/{id}', 'App\Controllers\TrajetController@details');

// Lancer le routeur

$router->dispatch();
