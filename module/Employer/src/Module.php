<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Employer;

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
                Model\UsersTable::class => function($container) {
                    $tableGateway = $container->get(Model\UsersTableGateway::class);
                    return new Model\UsersTable($tableGateway);
                },
                Model\UsersTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\User());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                Model\InternshipsTable::class => function($container) {
                    $tableGateway = $container->get(Model\InternshipsTableGateway::class);
                    return new Model\InternshipsTable($tableGateway);
                },
                Model\InternshipsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Internship());
                    return new TableGateway('internship_offers', $dbAdapter, null, $resultSetPrototype);
                },
                Model\EmployersTable::class => function($container) {
                    $tableGateway = $container->get(Model\EmployersTableGateway::class);
                    return new Model\EmployersTable($tableGateway);
                },
                Model\EmployersTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Employer());
                    return new TableGateway('employers', $dbAdapter, null, $resultSetPrototype);
                },
                Model\Students_InternshipsTable::class => function($container) {
                    $tableGateway = $container->get(Model\Students_InternshipsTableGateway::class);
                    return new Model\Students_InternshipsTable($tableGateway);
                },
                Model\Students_InternshipsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Students_Internships());
                    return new TableGateway('students_internships', $dbAdapter, null, $resultSetPrototype);
                },
                Model\StudentsTable::class => function($container) {
                    $tableGateway = $container->get(Model\StudentsTableGateway::class);
                    return new Model\StudentsTable($tableGateway);
                },
                Model\StudentsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Student());
                    return new TableGateway('students', $dbAdapter, null, $resultSetPrototype);
                },
                Model\FileTable::class => function($container) {
                    $tableGateway = $container->get(Model\FileTableGateway::class);
                    return new Model\FileTable($tableGateway);
                },
                Model\FileTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\File());
                    return new TableGateway('files', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController();
                },
                Controller\UsersController::class => function($container) {
                    return new Controller\UsersController(
                        $container->get(Model\UsersTable::class),
                        $container->get(Model\EmployersTable::class),
                        $container->get(\Zend\Db\Adapter\Adapter::class)
                    );
                },
                Controller\InternshipsController::class => function($container) {
                    return new Controller\InternshipsController(
                        $container->get(Model\InternshipsTable::class),
                        $container->get(Model\EmployersTable::class)
                    );
                },
                Controller\EmployersController::class => function($container) {
                    return new Controller\EmployersController(
                        $container->get(Model\EmployersTable::class),
                        $container->get(Model\UsersTable::class)
                    );
                },
                Controller\Students_InternshipsController::class => function($container) {
                    return new Controller\Students_InternshipsController(
                        $container->get(Model\Students_InternshipsTable::class),
                        $container->get(Model\InternshipsTable::class),
                        $container->get(Model\StudentsTable::class),
                        $container->get(Model\UsersTable::class),
                        $container->get(Model\EmployersTable::class),
                        $container->get(Model\FileTable::class)
                    );
                },
            ],
        ];
    }
}
