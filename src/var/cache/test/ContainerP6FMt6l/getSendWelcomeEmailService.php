<?php

namespace ContainerP6FMt6l;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSendWelcomeEmailService extends App_KernelTestTestDebugContainer
{
    /**
     * Gets the private 'App\Application\EventListener\SendWelcomeEmail' shared autowired service.
     *
     * @return \App\Application\EventListener\SendWelcomeEmail
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/Application/EventListener/SendWelcomeEmail.php';

        return $container->privates['App\\Application\\EventListener\\SendWelcomeEmail'] = new \App\Application\EventListener\SendWelcomeEmail();
    }
}
