<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header.
		'app_env' => getenv('APPLICATION_ENV'),

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
		
		// Database connection settings
        "db" => [
            "host" => getenv('DB_SERVER'),
            "dbname" => getenv('DB_DATABASE'),
            "user" => getenv('DB_USER'),
            "pass" => getenv('DB_PASS'),
        ],
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            // path where the compiled metadata info will be cached
            // make sure the path exists and it is writable
            'cache_dir' => __DIR__ . '/../var/doctrine', //APP_ROOT . '/var/doctrine',

            // you should add any other path containing annotated entity classes
            'metadata_dirs' => [__DIR__ . '/../classes'],

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => getenv('DB_SERVER'),
                'port' => 3306,
                'dbname' => getenv('DB_DATABASE'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASS'),
                'charset' => 'utf-8'
            ]
        ],	
		// FTP connection settings
        "ftp" => [
            "server" => getenv('FTP_SERVER'),
            "user" => getenv('FTP_USER'),
            "pass" => getenv('FTP_PASS')
        ],		
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
