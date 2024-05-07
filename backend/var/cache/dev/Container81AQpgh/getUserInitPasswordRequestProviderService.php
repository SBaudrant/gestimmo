<?php

namespace Container81AQpgh;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getUserInitPasswordRequestProviderService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\State\UserInitPasswordRequestProvider' shared autowired service.
     *
     * @return \App\State\UserInitPasswordRequestProvider
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/State/UserInitPasswordRequestProvider.php';

        return $container->privates['App\\State\\UserInitPasswordRequestProvider'] = new \App\State\UserInitPasswordRequestProvider(($container->privates['App\\Repository\\UserRepository'] ?? $container->load('getUserRepositoryService')));
    }
}