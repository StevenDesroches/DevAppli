<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module implements ConfigProviderInterface
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\UserTable::class => function($container) {
                    $tableGateway = $container->get(Model\UserTableGateway::class);
                    return new Model\UserTable($tableGateway);
                },
                Model\UserTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\User());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                Model\StudentTable::class => function($container) {
                    $tableGateway = $container->get(Model\StudentTableGateway::class);
                    return new Model\StudentTable($tableGateway);
                },
                Model\StudentTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Student());
                    return new TableGateway('students', $dbAdapter, null, $resultSetPrototype);
                },
                Model\InternshipsTable::class => function($container) {
                    $tableGateway = $container->get(Model\InternshipsTableGateway::class);
                    return new Model\InternshipsTable($tableGateway);
                },
                Model\InternshipsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Internships());
                    return new TableGateway('internship_offers', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\StudentsController::class => function($container) {
                    return new Controller\StudentsController(
                        $container->get(Model\StudentTable::class)
                    );
                },
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController(
                        $container->get(\Zend\Db\Adapter\Adapter::class)
                    );
                },
                Controller\UsersController::class => function($container) {
                    return new Controller\UsersController(
                        $container->get(\Zend\Db\Adapter\Adapter::class)
                    );
                },
                Controller\EmployersController::class => function($container) {
                    return new Controller\EmployersController(
                        $container->get(\Zend\Db\Adapter\Adapter::class)
                    );
                },
                Controller\InternshipsController::class => function($container) {
                    return new Controller\InternshipsController(
                        $container->get(Model\InternshipsTable::class)
                    );
                },
            ],
        ];
    }
}
