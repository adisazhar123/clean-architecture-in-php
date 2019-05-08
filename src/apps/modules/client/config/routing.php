<?php

use Phalcon\Mvc\Router;

// Create the router
$router = new Router();


$router->add('/', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'index'
]);

$router->addGet('/orders', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'orders'
]);

$router->addPost('/orders', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'createOrder'
]);

$router->addGet('/orders/{order_id}/receipts', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'generateReceipt'
]);

$router->addGet('/orders/{order_id}', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'findOrder'
]);

return $router;