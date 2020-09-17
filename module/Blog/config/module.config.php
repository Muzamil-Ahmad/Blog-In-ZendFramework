<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Blog' => 'Blog\Controller\BlogController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/blog[/:action][/:id]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Blog\Controller',
                        'controller'    => 'Blog',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Blog' => __DIR__ . '/../view',
//         		'strategies'=>array(
//         				'ViewJsonStrategy',
//         		),
        ),
    ),
);
