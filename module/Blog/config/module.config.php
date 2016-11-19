<?php
// In /module/Blog/config/module.config.php:
namespace Blog;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases'   => [
            Model\PostRepositoryInterface::class => Model\ZendDbSqlRepository::class,
            Model\PostCommandInterface::class    => Model\ZendDbSqlCommand::class,
        ],
        'factories' => [
            Model\PostRepository::class      => InvokableFactory::class,
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class,
            Model\PostCommand::class         => InvokableFactory::class,
            Model\ZendDbSqlCommand::class    => Factory\ZendDbSqlCommandFactory::class,
        ],
    ],
    'controllers'     => [
        'factories' => [
            Controller\ListController::class   => Factory\ListControllerFactory::class,
            Controller\WriteController::class  => Factory\WriteControllerFactory::class,
            Controller\DeleteController::class => Factory\DeleteControllerFactory::class,
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
                                'id' => '\d+',
                            ],
                        ],
                    ],
                    'add'    => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'add',
                            ],
                        ],
                    ],
                    'edit'   => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/edit/:id',
                            'defaults'    => [
                                'controller' => Controller\WriteController::class,
                                'action'     => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'       => '/delete/:id',
                            'defaults'    => [
                                'controller' => Controller\DeleteController::class,
                                'action'     => 'delete',
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
    'navigation'      => [
        'default' => [
            [
                'label' => 'Blog',
                'route' => 'blog',
                'pages' => [
                    [
                        'label'  => 'Detail',
                        'route'  => 'blog/detail',
                        'action' => 'detail',
                    ],
                    [
                        'label'  => 'Add',
                        'route'  => 'blog/add',
                        'action' => 'add',
                    ],
                    [
                        'label'  => 'Edit',
                        'route'  => 'blog/edit',
                        'action' => 'edit',
                    ],
                    [
                        'label'  => 'Delete',
                        'route'  => 'blog/delete',
                        'action' => 'delete',
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