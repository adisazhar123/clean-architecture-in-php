<?php

return array(
 
    'client' => [
        'namespace' => 'App\Client',
        'webControllerNamespace' => 'App\Client\Controllers\Web',
        'apiControllerNamespace' => 'App\Client\Controllers\Api',
        'className' => 'App\Client\Module',
        'path' => APP_PATH . '/modules/client/Module.php',
        'defaultRouting' => false,
        'defaultController' => 'dashboard',
        'defaultAction' => 'index'
    ],
);

?>