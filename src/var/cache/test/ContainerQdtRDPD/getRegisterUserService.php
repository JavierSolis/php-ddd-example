<?php

namespace ContainerQdtRDPD;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getRegisterUserService extends App_KernelTestTestContainer
{
    /*
     * Gets the private 'App\Application\UseCase\RegisterUser' shared autowired service.
     *
     * @return \App\Application\UseCase\RegisterUser
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['App\\Application\\UseCase\\RegisterUser'] = new \App\Application\UseCase\RegisterUser(($container->privates['App\\Infrastructure\\Repository\\DoctrineUserRepository'] ?? $container->load('getDoctrineUserRepositoryService')), ($container->services['event_dispatcher'] ?? self::getEventDispatcherService($container)));
    }
}
