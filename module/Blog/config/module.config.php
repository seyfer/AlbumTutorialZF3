<?php
// In /module/Blog/config/module.config.php:
namespace Blog;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases'   => [
            // Update this line:
            Model\PostRepositoryInterface::class => Model\ZendDbSqlRepository::class,
        ],
        'factories' => [
            Model\PostRepository::class      => InvokableFactory::class,
            // Add this line:
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class,
        ],
    ],
    'controllers'     => [
        'factories' => [
//            Controller\ListController::class => InvokableFactory::class,
Controller\ListController::class => Factory\ListControllerFactory::class,
        ],
    ],
    'router'          => [
        'routes' => [
            'blog' => [
                'type'          => Literal::class,
                'options'       => [
                    'route'    => '/blog',
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'detail' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/:id',
                            'defaults'    => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager'    => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];