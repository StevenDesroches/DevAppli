<?php

namespace Student\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,$requestedName, array $options = null)
    {
        return new $requestedName (
            $container->get(\Zend\Db\Adapter\Adapter::class)
        );
    }
}