<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Checklist\Controller\Task' => 'Checklist\Controller\TaskController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'checklist' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/checklist[/][:action][/:id]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Checklist\Controller',
                        'controller'    => 'Task',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Checklist' => __DIR__ . '/../view',
        ),
    ),
);
