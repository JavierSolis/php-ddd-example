<?php

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once __DIR__ . "/../vendor/autoload.php";


$isDevMode = true;
$cache = $isDevMode ? new ArrayAdapter() : null;

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . "/../Infrastructure/Persistence/Entity"],
    isDevMode: $isDevMode,
    cache: $cache
);

$params = [
    'dbname'   => 'ddd_db_1',
    'user'     => 'admin',
    'password' => 'admin',
    'host'     => 'db',
    'driver'   => 'pdo_mysql',
];
$appEnv = $_ENV['APP_ENV'] ?? 'dev'; // Use a default value if not set.

if ($appEnv === 'test') {
    $params = [
        'driver' => 'pdo_sqlite',
    ];
}

$connection = DriverManager::getConnection($params, $config);


return new EntityManager($connection, $config); 