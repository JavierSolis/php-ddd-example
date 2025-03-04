<?php

namespace App\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineEntityManagerFactory
{
    public static function create(): EntityManagerInterface
    {
        //return require __DIR__ . '/config/doctrine.php';
        $entityManager = require __DIR__ . "/../../config/doctrine.php";
        return $entityManager;
    }
}