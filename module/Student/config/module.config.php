<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Student;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'student_home' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/student',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'student_users' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/student/users[/:action]',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'student_internship' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/student/internships[/:action]',
                    'defaults' => [
                        'controller' => Controller\InternshipController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Factory\ControllerFactory::class,
            Controller\UsersController::class => Factory\ControllerFactory::class,
            Controller\InternshipController::class => Factory\ControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'student/index/index' => __DIR__ . '/../view/student/index/index.phtml',
        ],
        'template_path_stack' => [
            'student' => __DIR__ . '/../view',
        ],
    ],
];
