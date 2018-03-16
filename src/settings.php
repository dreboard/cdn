<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        "db" => [
            "host" => $_ENV['DB_SERVER'],
            "dbname" => $_ENV['DB_DATABASE'],
            "user" => $_ENV['DB_USER'],
            "pass" => $_ENV['DB_PASS']
        ],
        "orm" => [
            "driver" => 'mysql',
            "host" => $_ENV['DB_SERVER'],
            "database" => $_ENV['DB_DATABASE'],
            "username" => $_ENV['DB_USER'],
            "password" => $_ENV['DB_PASS'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ],
    ],
];
