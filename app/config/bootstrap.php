<?php

$entityManager = require __DIR__ . "/doctrine.php";
$eventDispatcher = require __DIR__ . "/events.php";

return [
    'entityManager' => $entityManager,
    'eventDispatcher' => $eventDispatcher,
];