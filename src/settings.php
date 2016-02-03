<?php
return [
    'settings' => [
        'displayErrorDetails' => true,

        // App
        'app' => [
            'env' => 'dev',
            'key' => '?0x1nh@f0lg@t0',
        ],

        // Monolog
        'logger' => [
            'name' => 'api',
            'path' => __DIR__ . '/../logs/' . date('Y-m-d') . '.log',
        ],

        // Database
        'database' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'crud',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        // Router
        'router' => [
            'public' => [
                '/publico',
            ]
        ],
    ],
];
