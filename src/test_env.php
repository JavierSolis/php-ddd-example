<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config/packages/test'));
$loader->load('framework.yaml');

$config = $container->getParameterBag()->all();

echo "framework.test: " . ($config['framework']['test'] ? 'true' : 'false') . PHP_EOL;
