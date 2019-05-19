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
    'namespace' => 'App\Client\Controllers\Api',
    'module' => 'client',
    'controller' => 'orders',
    'action' => 'createOrder'
]);

$router->addGet('/orders/{order_id}/receipts', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'generateReceipt'
]);

$router->addGet('/orders/{order_id}', [
    'namespace' => 'App\Client\Controllers\Api',
    'module' => 'client',
    'controller' => 'orders',
    'action' => 'findOrder'
]);

$router->addGet('/foods', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'foods'
]);

$router->addPost('/foods', [
    'namespace' => 'App\Client\Controllers\Api',
    'module' => 'client',
    'controller' => 'orders',
    'action' => 'addFood'
]);

$router->addGet('/foods/{foodId}', [
    'namespace' => 'App\Client\Controllers\Api',
    'module' => 'client',
    'controller' => 'orders',
    'action' => 'findFood'
]);

$router->add('/foods/{foodId}', [
    'namespace' => 'App\Client\Controllers\Api',
    'module' => 'client',
    'controller' => 'orders',
    'action' => 'updateFood'
])->via([
    'PUT'
]);

$router->addGet('/coupons', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'dashboard',
    'action' => 'coupons'
]);

$router->addPost('/coupons', [
    'namespace' => 'App\Client\Controllers\Web',
    'module' => 'client',
    'controller' => 'coupons',
    'action' => 'addCoupon'
]);

return $router;