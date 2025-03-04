<?php
require __DIR__ . "/config/bootstrap.php";

echo "inicio";

use Doctrine\ORM\Tools\SchemaTool;

$entityManager = require __DIR__ . "/config/bootstrap.php";

$schemaTool = new SchemaTool($entityManager);
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();

$schemaTool->updateSchema($metadata);

echo "Esquema de la base de datos creado correctamente.\n";