<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 11/15/16
 */
namespace Album;

use Zend\Router\Http\Segment;

//use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers'  => [
        'factories' => [
//            Controller\AlbumController::class => InvokableFactory::class,
        ],
    ],
    // The following section is new and should be added to your file:
    'router'       => [
        'routes' => [
//            'home'  => [
//                'type'    => Literal::class,
//                'options' => [
//                    'route'    => '/',
//                    'defaults' => [
//                        'controller' => Controller\IndexController::class, // <-- change back here
//                        'action'     => 'index',
//                    ],
//                ],
//            ],
'album' => [
    'type'    => Segment::class,
    'options' => [
        'route'       => '/album[/:action[/:id]]',
        'constraints' => [
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id'     => '[0-9]+',
        ],
        'defaults'    => [
            'controller' => Controller\AlbumController::class,
            'action'     => 'index',
        ],
    ],
],
        ],
    ],
    'navigation'   => [
        'default' => [
            [
                'label' => 'Album',
                'route' => 'album',
                'pages' => [
                    [
                        'label'  => 'Add',
                        'route'  => 'album',
                        'action' => 'add',
                    ],
                    [
                        'label'  => 'Edit',
                        'route'  => 'album',
                        'action' => 'edit',
                    ],
                    [
                        'label'  => 'Delete',
                        'route'  => 'album',
                        'action' => 'delete',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
];