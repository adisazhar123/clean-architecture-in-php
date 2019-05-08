<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

$paths = array("/home/adisazhar/projects/phalcon/clean-architecture/core/Persistence/Doctrine/Mapping/");
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

$cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
$deleted = $cacheDriver->deleteAll();

return ConsoleRunner::createHelperSet($entityManager);