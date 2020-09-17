<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Registration\Controller\Registration' => 'Registration\Controller\RegistrationController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'registration' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/registration[/:action]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Registration\Controller',
                        'controller'    => 'Registration',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Registration' => __DIR__ . '/../view',
        ),
    ),
);
