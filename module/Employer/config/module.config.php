<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Employer;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'employer_home' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/employer[/:uid]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'employer_users' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/employer[/:uid]/users[/:action]',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'employer_internships' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/employer[/:uid]/internships[/:action]',
                    'defaults' => [
                        'controller' => Controller\InternshipsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],        ],
    ],
    'view_manager' => [
        'template_map' => [
            'employer/index/index' => __DIR__ . '/../view/employer/index/index.phtml',
        ],
        'template_path_stack' => [
            'employer' => __DIR__ . '/../view',
        ],
    ],
];
