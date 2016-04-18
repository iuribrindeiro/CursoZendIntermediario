<?php

namespace SONUser;

return array(
    'router' => array(
        'routes' => array(
            'sonuser-register' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/register',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'Index',
                        'action' => 'register'
                    )                    
                )
            ),
            'user-ativar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register/activate[/:key]',
                    'defaults' => array(                        
                        'controller' => 'SONUser\Controller\Index',
                        'action' => 'ativar'
                    )
                )
            ),
            'user-auth' => array(
              'type' => 'Literal',
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'Auth',
                        'action' => 'index'
                    )
                )
            ),
            'user-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'User',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                        'default' => array(
                            'type' => 'Segment',
                            'options' => array(
                                'route' => '/[:controller[/:action[/:id]]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id' => '\d+'
                                ),
                                'defaults' => array(
                                    '__NAMESPACE__' => 'SONUser\Controller',
                                    'controller' => 'User',
                                )
                            )
                        ),
                        'paginator' => array(
                            'type' => 'Segment',
                            'options' => array(
                                'route' => '/[:controller[/page/:page]]',
                                'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                                ),
                                'defaults' => array(                                
                                '__NAMESPACE__' => 'SONUser\Controller',
                                'controller' => 'User',
                                'page' => 1
                                )
                            )                                                        
                        )
                    )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'SONUser\Controller\Index' => Controller\IndexController::class,
            'SONUser\Controller\User' => Controller\UserController::class,
            'SONUser\Controller\Auth' => Controller\AuthController::class,
        )
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/son-user/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'fixture' => array(
            'SONUser_fixture' => __DIR__ . '/../src/SONUser/Fixture'
        ),
        'driver' => array(          
          'son-user' => array(             
              'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
              'cache' => 'array',
              'paths' => array(__DIR__ . '/../src/SONUser/Entity')
          ),
          'orm_default' => array(
              'drivers'  => array(
                  'SONUser\Entity' => 'son-user'
              ),
          ),
        ),
    )  
);

