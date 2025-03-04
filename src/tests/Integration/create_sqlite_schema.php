<?php
echo "\nCreating SQLite schema...\n"; // Agregar esta línea


require_once __DIR__ . "/../../config/bootstrap.php";

use Doctrine\ORM\Tools\SchemaTool;

$container = require __DIR__ . "/../../config/bootstrap.php";
$entityManager = $container['entityManager'];

$schemaTool = new SchemaTool($entityManager);
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();

//$schemaTool->createSchema($metadata);
//$schemaTool->updateSchema($metadata);
try {
    $schemaTool->createSchema($metadata);
} catch (\Exception $e) {
    echo "Error creating SQLite schema: " . $e->getMessage() . "\n";
}

echo "SQLite schema created.\n"; // Agregar esta línea
