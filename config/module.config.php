<?php
namespace Boxspaced\EntityManagerModule;

use Boxspaced\EntityManager\EntityManager;

return [
    'entity_manager' => [
        'strict' => false,
        'db' => [
            'driver' => '',
            'database' => '',
            'username' => '',
            'password' => '',
            'hostname' => '',
            'driver_options' => [],
        ],
    ],
    'service_manager' => [
        'factories' => [
            EntityManager::class => EntityManagerFactory::class,
        ]
    ],
];
