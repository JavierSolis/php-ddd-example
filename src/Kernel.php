<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('config/services.yaml');
        $container->extension('framework', [
            'secret' => '%env(APP_SECRET)%'
        ]);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('config/routes.yaml');
    }

    public function getProjectDir(): string
    {
        //return \dirname(__DIR__);
        return __DIR__; // Ahora apunta a la raíz del proyecto

    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
        ];
    }

    public function getEnvironment(): string
    {
        return $_SERVER['APP_ENV'] ?? 'dev';
    }
}