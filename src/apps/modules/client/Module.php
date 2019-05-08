<?php

namespace App\Client;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ModuleDefinitionInterface;
use RestoOrder\Domain\Repository\CustomerRepositoryInterface;

class Module implements ModuleDefinitionInterface
{   
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'App\Client\Controllers\Web' => __DIR__ . '/controllers/web',
            'App\Client\Controllers\Api' => __DIR__ . '/controllers/api',
            'App\Client\Models' => __DIR__ . '/models',
            'App\Client\Services' => __DIR__ . '/services',
            'App\Client\Contracts' => __DIR__ . '/contracts',
            // 'RestoOrder' => __DIR__ .'/../../../core',
//            'RestoOrder\Domain\Repository' => __DIR__ .'/../../../core/Domain/Repository',
//            'RestoOrder\Persistence\Doctrine\Repository' => __DIR__ .'/../.    ./../core/Persistence/Doctrine/Repository',
        ]);

        $loader->register();
    }

    /**
     * Register specific services for the module
     */
    public function registerServices(DiInterface $di = null)
    {
        // Registering the view component
        $di['view'] = function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');

            $view->registerEngines(
                [
                    ".volt" => "voltService",
                ]
            );

            return $view;
        };


        $di->setShared('entityManager', function() {
            
            $paths = array(__DIR__ . "/../../../core/Persistence/Doctrine/Mapping/");
            $isDevMode = true;

            // the connection configuration
            $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => 'adis',
                'password' => '',
                'dbname'   => 'clean_architecture',
            );

            $config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
            $entityManager = EntityManager::create($dbParams, $config);
            $entityManager->clear();
            return $entityManager;
        });

        $di->setShared('customerRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\CustomerRepository($entityManager);
        });

        $di->setShared('foodRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\FoodRepository($entityManager);
        });

        $di->setShared('orderRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\OrderRepository($entityManager);
        });

    }
}
?>