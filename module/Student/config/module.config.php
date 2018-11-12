<?php
namespace Student;

use Zend\Router\Http\Segment; 
use Studenet\Controller\StudentController;


return [

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'student' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/student[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\StudentController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'student' => __DIR__ . '/../view',
        ],
    ],
];